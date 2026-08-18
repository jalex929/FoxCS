# Telemetry and Analytics

Added 2026-08-08. Captures how students actually move through content — not just final answers — so Jay can see real trends: which themes are popular, whether Reinforce items actually recover a skill, where students get stuck, how long content really takes, whether a concept needed to be broken down further before it landed.

**This schema sat unused until 2026-08-11** — see `adaptive-practice-model.md` for the MVP implementation that finally wires `drill_attempt`'s `lane`/`skill_id` fields and `lane_transition` into a real practice page. Before that, `05_practice.html` only ever logged a flat `drill_id` with no lane concept, since practice was a flat drill list per the 2026-08-06 decision. `hint_reveal` is also newly applied to practice nodes as of that doc, not just the stepper/hint components it originally covered.

## Design Constraints This Has to Respect

- **1 hour/week grading budget** (`../CLAUDE.md`'s Hard Constraint) — telemetry must be batch-ingestible and summarizable automatically. Nothing here should require reading raw event logs by hand.
- **Codename-only, same Release Gate as everything else** (`../01-privacy-and-governance/data-boundaries.md`, `codename-policy.md`) — telemetry is embedded in the same submitted file that already goes through the not-yet-built codename-swap script before reaching `05-grader/` or any AI tool. It never has a separate, less-protected path.
- **No live backend.** Everything in the MVP model is a static file, opened via `file://` or a local folder, saved in place. Telemetry can't phone home — it can only accumulate in the DOM and get written out when the student saves, exactly like the existing hidden mastery-check timestamp fields (component library #12, `lesson_01_04/09_mastery_check.html`). This doc generalizes that one-field pattern into a full event log.
- **Consequence: nothing is captured for a session that's never saved.** If a student opens a page, works for 20 minutes, and closes without saving, that interaction data is gone — same limitation the save-in-place model already has for the work itself. Not solvable without a live backend; not treated as a gap to fix, just a known boundary.

## Capture Mechanism

One hidden JSON blob per page, written into a `<script type="application/json" id="foxcs-telemetry">` block (same "hidden field, not visible UI" pattern as the timestamp mechanism). JS appends to an in-memory event array on every tracked interaction and re-serializes it into that script block continuously — so whatever's in the DOM at the moment of Save is always current, with no separate "finalize telemetry" step to forget.

```html
<script type="application/json" id="foxcs-telemetry" aria-hidden="true">
{
  "page_id": "lesson_01_04_printing_output/09_mastery_check",
  "opened_at": "2026-08-08T14:03:12Z",
  "saves": [
    { "at": "2026-08-08T14:11:40Z", "theme": "natural" }
  ],
  "events": [
    { "type": "theme_change", "at": "2026-08-08T14:05:02Z", "from": "light", "to": "natural", "method": "link_edit" },
    { "type": "stepper_speed_change", "at": "2026-08-08T14:06:15Z", "value": 0.5 },
    { "type": "stepper_play", "at": "2026-08-08T14:06:16Z" },
    { "type": "stepper_step", "at": "2026-08-08T14:06:40Z", "direction": "forward", "index": 3 },
    { "type": "hint_reveal", "at": "2026-08-08T14:07:02Z", "hint_id": "mc_q3_hint1" },
    { "type": "drill_attempt", "at": "2026-08-08T14:07:30Z", "skill_id": "print_output", "item_id": "core_02", "lane": "core", "correct": false, "attempt_number": 1 },
    { "type": "lane_transition", "at": "2026-08-08T14:07:31Z", "skill_id": "print_output", "from": "core", "to": "reinforce", "reason": "incorrect" },
    { "type": "drill_attempt", "at": "2026-08-08T14:08:10Z", "skill_id": "print_output", "item_id": "reinforce_01", "lane": "reinforce", "correct": true, "attempt_number": 1 },
    { "type": "lane_transition", "at": "2026-08-08T14:08:11Z", "skill_id": "print_output", "from": "reinforce", "to": "core", "reason": "correct_recovered" }
  ]
}
</script>
```

Every page that has *any* tracked interaction gets this block; a page with nothing to track (a pure static-content page with no drills, stepper, or theme control) doesn't need one.

## Event Types

| `type` | Fields | Fired by |
|---|---|---|
| `theme_change` | `from`, `to`, `method` (`link_edit` \| `dropdown`) | Theme system (`theme-system.md`) |
| `stepper_speed_change` | `value` (0.25–2.0) | Code stepper (component #14) — every change, not just the final value, so a "starts at 1x then slows down" pattern is visible |
| `stepper_play` / `stepper_pause` | — | Code stepper |
| `stepper_step` | `direction` (`forward`\|`back`), `index` | Code stepper |
| `hint_reveal` | `hint_id` | Any component with staged/revealable hints |
| `drill_attempt` | `skill_id`, `item_id`, `lane` (`core`\|`reinforce`\|`extend`), `correct`, `attempt_number` | Any practice drill (block builder, drag-to-match, categorization, sequencing, etc.) |
| `lane_transition` | `skill_id`, `from`, `to`, `reason` (`incorrect`\|`correct_advance`\|`correct_recovered`\|`lane_exhausted`) | The Reinforce/Core/Extend router (`objectives-and-skills-proficiency.md`) — logs every move, not just the endpoint, so the full path through the ladder is reconstructable. `lane_exhausted` (added 2026-08-11, see `adaptive-practice-model.md`) fires when a student is still wrong after using every item in a lane's small pool — the MVP's pools are deliberately tiny (1-2 items/lane), so running out is a real, loggable outcome, not an edge case to ignore. |

Page-level fields (`opened_at`, `saves[]`) capture start/save timestamps directly — no separate event needed for those, since they're properties of the session itself rather than a discrete interaction.

## What This Answers, Directly

- **Theme popularity / approach patterns** — aggregate `theme_change.to` and final `saves[].theme` across all students.
- **Stepper usage patterns** — "starts at 1x, slows down" vs. "never touches it" is visible directly in `stepper_speed_change` sequences, not just a final value.
- **Time-on-content** — `saves[last].at - opened_at` per page, aggregated per lesson, gives a real duration signal without asking students to self-report.
- **Does Reinforce actually work?** — for a given `skill_id`, count `lane_transition` sequences that end `reason: "correct_recovered"` vs. ones with multiple consecutive `reason: "incorrect"` Reinforce-lane attempts. This is the direct answer to "are they able to recover the skill and move forward, or do they need more Reinforce."
- **"Stuck" — first-cut operational definition, flagged as unvalidated:** a skill is **stuck** if a student accumulates **2 or more consecutive Reinforce-lane `drill_attempt`s for the same `skill_id` that are still `correct: false`** within one session, with no intervening `correct_recovered` transition. This is a starting heuristic, not a validated one — same epistemic posture as `objectives-and-skills-proficiency.md`'s open question on skill granularity: "start with something reasonable, validate once real pilot data exists." Revisit the threshold once Unit 01 actually has students moving through it.
- **Evidence that breaking a concept down further helped** — compare `drill_attempt.correct` rates on Core items immediately following a `correct_recovered` transition against the original Core miss. A real improvement there is the concrete evidence Jay asked for.

## Pipeline: File → Aggregate Data

1. Student saves; the telemetry JSON blob is part of the saved file, same as the rest of the page content.
2. Student submits the whole unit folder via Classroom, as already required by `codename-policy.md`.
3. Jay downloads the batch. **The not-yet-built codename-swap script** (`codename-policy.md`'s "Tooling Needed" section) is the natural place to also extract each page's telemetry blob — it's already the pipeline stage responsible for touching every submitted file before anything reaches `05-grader/` or an AI tool, so this adds an extraction step to existing scope rather than a new pipeline stage.
4. Extracted telemetry gets written as one normalized record per `codename` + `page_id`, as **markdown or JSON files** (Jay's own preferred format, since it "can later feed into a database") under a new `06-data-and-spreadsheets/telemetry/` directory — human-scannable in the interim, structured enough to bulk-import into a real database once `06-data-and-spreadsheets/` moves past placeholder status.
5. Weekly grading pass (the same 1-hour/week batch Jay already runs) can fold in an automatic telemetry summary — popular themes, stuck-skill list, average time-on-lesson — as one more output of that same pass, not a second task. Matches the existing "automatic focus-group/intervention-list generation" requirement already on the books for `05-grader/`.

## Privacy Note

Telemetry contains no identity information by construction — it travels inside the same file that's already gated by the Release Gate and codename-swap step. But it's meaningfully richer *behavioral* data (timing, click-level interaction, error/recovery patterns) than `data-boundaries.md` currently anticipates when it was written. Worth a short addendum there flagging this as in-scope and covered by the same boundaries, not a new category needing separate rules — done as part of this same change (see `data-boundaries.md`'s new note).

## Not Yet Decided

- Exact `hint_id` / `item_id` / `skill_id` naming convention — should follow whatever `lesson-schema.md` already establishes for skill IDs; not cross-checked yet.
- Whether `saves[]` needs anything beyond `at` + `theme` (e.g., a rolling word count for journal entries, to see writing-in-progress vs. one big paste at the end) — flagged as a possible future field, not built.
- The "stuck" heuristic's threshold (2 consecutive) is a guess pending real pilot data, as noted above.
- Where exactly the telemetry-extraction step lives inside the codename-swap script's implementation — not built yet, same status as the script itself.
