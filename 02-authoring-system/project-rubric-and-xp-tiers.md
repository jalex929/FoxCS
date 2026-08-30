# Project Rubric and XP Tiers

**Status: first real formalization of this pattern, 2026-08-30.** Two things existed only in conversation before this doc — the Starter/Skilled/Legendary/Mythic project-XP tier numbers, and the "how a student finds out what would move them up a tier" feedback pattern — neither had been written into a file. This doc reconciles them against `xp-and-incentives.md`'s existing Project XP rows (Required 25 / Bonus +10 / Bonus +15) and turns both into one buildable rubric shape, usable in Moodle's native Advanced Grading: Rubric on every Project Assignment. **Flagged for Jay to confirm:** the exact tier numbers below are this session's best reconstruction of "Starter/Skilled/Legendary/Mythic, Mythic ≈ +20 over baseline" from earlier conversation — check them against your own memory of that conversation before treating them as locked, since they were never persisted anywhere before now.

## Why One Rubric Shape, Reused Every Lesson

Every Project module (module 3 of the 4-module lesson structure — see root `CLAUDE.md`) needs a rubric attached via Moodle's native Advanced Grading: Rubric on the `mod_assign` activity, so students see a real shaded/graded rubric as feedback (not just a numeric score), per the standing requirement that "students should always be able to see the rubric and receive feedback of a shaded-in visual of that rubric." Reusing one rubric *shape* across lessons — same criteria, same tier ladder, only the task-specific descriptions change — keeps grading fast (the 1-hour/week budget in root `CLAUDE.md`'s Hard Constraints) and keeps the XP tiers meaningful as a running, comparable signal across the whole year rather than a fresh scale every lesson.

## The Reconciliation

`xp-and-incentives.md` (still accurate for every *other* activity type) describes Project XP as a 25-point required baseline plus stacking bonuses (+10, then +15, for a max of 50). The Starter/Skilled/Legendary/Mythic tier system **replaces that stacking model with one flat, mutually exclusive tier** — a student lands on exactly one tier per project, not a base score plus add-ons layered on top. This is a real, deliberate change to that doc's Project rows, not an addition alongside them. `xp-and-incentives.md` should be updated to point here the next time it's touched.

| Tier | XP | What it represents | Relationship to the old stacking model |
|---|---|---|---|
| **Starter** | 15 | The project runs and does the required task, but is minimal — meets the letter of the checklist without much beyond it. | New floor — the old model had no "did the minimum, nothing more" XP value below the 25-point baseline. |
| **Skilled** | 25 | Solid, complete work. Every required checklist item is genuinely met, code is reasonably clean, the student clearly understood the lesson's target concept. | Same number as the old "Required tier" baseline — this is the expected, on-grade-level outcome. |
| **Legendary** | 35 | One meaningful extension beyond the requirements — the student added something real (an extra feature, a genuinely harder variation, noticeably better polish) that wasn't asked for. | Skilled (25) + old Bonus Tier 1 (+10). |
| **Mythic** | 45 | Exceptional depth, creativity, or ambition — work that goes well beyond what the lesson asked for, not just one add-on but a genuinely bigger reach. | Skilled (25) + old Bonus Tier 2 (+20, updated from the doc's original +15 per Jay's later "Mythic +20 would be fine" note). |

**On escalating totals across a whole year:** Jay flagged directly that if students do "all of the things" (Vocab Quiz 5 + Practice 8 + Mastery Check 20 + Feedback 3 + a Mythic Project 45, per lesson) the totals add up fast, and scaling back may be warranted — but also said scaling back is fine to defer. **Not resolved here.** This doc keeps Unit 01's tier numbers as the working baseline for every lesson for now; a full-year scaling curve (e.g., do Legendary/Mythic values grow across units, or hold flat all year) is still open — see Open Items below.

## Standard Rubric Criteria (Moodle Advanced Grading: Rubric)

Four criteria, each with four levels matching the four tiers. Point values per criterion should sum to the tier's total XP number above when a submission lands on the same level across all four criteria — a project doesn't have to land on the same tier for every criterion in practice (Moodle's rubric totals the levels actually selected), but the *level descriptors* are written so that a consistent submission naturally lines up with one tier.

| Criterion | Starter (lowest level) | Skilled | Legendary | Mythic (highest level) |
|---|---|---|---|---|
| **Correctness** | Runs, produces the required output for the basic case, but breaks or gives wrong results on anything slightly off the happy path. | Runs correctly for the full stated task, including reasonable edge cases the lesson actually covered. | Correct, and handles at least one edge case or input variation beyond what the lesson explicitly required. | Correct, robust, and clearly considered inputs/cases a typical student wouldn't have thought to test. |
| **Concept usage** | Uses the lesson's target concept(s) at a surface level — present, but not really leveraged. | Uses the lesson's target concept(s) appropriately and clearly, matching what was taught. | Combines the lesson's concept with something from an earlier lesson in a way that strengthens the solution. | Uses the concept in a genuinely creative or non-obvious way that shows real understanding, not just recall. |
| **Code quality & documentation** | Works, but is hard to follow — inconsistent naming, no comments, minimal structure. | Readable, reasonably organized, sensibly named variables, comments where the lesson's standards call for them (see `content-authoring-standards.md`). | Clearly organized beyond the minimum — logical structure, comments that explain *why* not just *what*, per `02-authoring-system/content-voice-and-tone.md`. | Genuinely polished — the kind of code quality a student could show someone else without embarrassment. |
| **Completeness & ambition** | Attempts the full required scope, nothing more. | Attempts the full required scope confidently, no missing pieces. | Adds one real extension beyond the required scope (extra feature, harder variation, meaningfully better polish). | Adds substantial extension(s) — not just one add-on, a genuinely bigger reach than the lesson asked for. |

**Per-lesson authoring note:** when building a specific lesson's Project rubric, copy this table and rewrite each cell's task-specific detail (what "runs correctly for the full stated task" means for *this* project) — the column headers (Starter/Skilled/Legendary/Mythic) and the underlying logic (surface-level → solid → one extension → substantial extension) stay fixed across every lesson so the tiers stay comparable year over year.

## Feedback: How to Reach the Next Tier

Per Jay directly: *"I also want to give them some guidance in their feedback about how they can reach the next XP tier if they want to add to their project."* Moodle's native Assignment rubric doesn't have a built-in "next tier" field, so this is delivered as a short, rubric-tied comment in the Assignment's feedback-comment box (not a separate document), written against whichever tier the student actually landed on:

- **Landed on Starter →** name the single most load-bearing gap (usually Correctness or Completeness), concretely: *"Your program works for [X] but not [Y] — fixing that gets you to Skilled."* Never vague ("needs more work").
- **Landed on Skilled →** name one specific, genuinely optional extension tied to the Legendary column's task-specific descriptor for this project: *"If you want to push this further, [specific idea] would move you into Legendary."* The suggestion should be concrete enough that a student could actually start on it, not a generic "add more features."
- **Landed on Legendary →** name what Mythic would look like for this specific project, and be honest that it's a real reach, not a small step: *"Mythic on this project would mean [specific, ambitious idea] — that's a genuine step up, not a quick add-on."*
- **Landed on Mythic →** no "next tier" language — this is the ceiling. Feedback here should be specific praise (what exactly made it Mythic), not generic ("great job!").

This guidance is written once per project (as part of authoring the Project module), not improvised per-student at grading time — same batch-efficiency logic as the rest of `05-grader/`'s design. A lesson's Project module should ship with these four tier-transition comments pre-written, ready to paste/lightly-edit into Moodle's feedback-comment field during the weekly grading pass.

## Open Items

- Full-year XP scaling curve (flat Starter/Skilled/Legendary/Mythic values all 21 units, vs. growing values as projects get harder) — not decided, see Jay's "if it makes sense to scale this back a bit, that is fine too" note above.
- `xp-and-incentives.md`'s Project rows (25/+10/+15) should be edited to point here and marked superseded the next time that file is touched — not done automatically in this pass, to avoid two agents editing that file at once mid-session.
- Whether the same four-tier rubric shape extends to Game II/Web Dev/Software Dev projects, or each pathway gets its own tier-to-XP mapping — not raised by Jay yet.
- The rubric-shaded-visual-feedback mechanism for the *Mastery Check Quiz* (as opposed to the Project Assignment, which has native Moodle rubric support) is still unresolved — no native Moodle equivalent exists for Quiz; leaning toward hand-built HTML in the quiz's feedback field, not confirmed.
