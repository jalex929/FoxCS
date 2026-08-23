# XP and Incentives

**Status: baseline XP values locked in 2026-08-22, per Jay.** The mechanisms behind a few rows (embedded Quick Check, Flashcards, Extra/Extend Practice) are still not yet built — see each row and the sections below — but the *point values* themselves are settled, not draft. This is a separate incentive layer on top of the existing completion/grading model (`05-grader/`, `feedback-and-grading-spec.md`), not a replacement for it. XP is meant to reward genuine engagement across every content type, encourage above-and-beyond work specifically, and give students a real, checkable number that reflects effort over the year — not a proxy for the actual grade.

## The Core Rule: No XP for Passive Content

Per Jay directly: *"we want to find the balance of encouraging students to actually read content by offering XP but also make sure they are reading the content by asking them to reflect."*

**XP is never awarded for simply opening a page.** Every XP-earning activity requires the student to do something — answer a quiz question, write a reflection, complete a drill, unlock and finish a mastery check. A page with no interaction of any kind earns no XP on its own, no matter how long it was open. This is already true of the four activity types `05-grader/school-side/auto_grade.py` currently scores (see that script's `XP_TABLE`) — none of them award XP for a bare file existing, only for genuine completion signals (a real reflection, a saved practice attempt, both mastery-check timestamps present).

## Proposed XP Table

| Activity | XP | Requires | Notes |
|---|---|---|---|
| Vocab Quiz | 5 | All terms matched + a real (non-empty) reflection | Already implemented in `auto_grade.py`. |
| Practice | 8 | At least one drill genuinely attempted | Not gated on getting every drill right — matches the existing "Save is NOT gated on perfection" philosophy (`mvp-unit-folder-structure.md`). Already implemented. |
| Embedded Quick Check (inside an instruction page) | 3 per check answered | The student actually selects/submits an answer, correct or not | **Not yet implemented anywhere.** This is the mechanism that makes reading pages earn XP without becoming passive — see "Reading Pages" below. |
| Mastery Check | 20 | Both `unlocked_at` and `completed_at` timestamps present | The largest single-activity award — it's the real DOK-appropriate checkpoint. Already implemented. |
| Feedback Form | 3 | Saved | Already implemented. |
| Flashcards | 3 | Every card in the set flipped at least once, then a "Mark as Reviewed" button (disabled until that's true) is clicked | **Proposed 2026-08-22, per Jay — not yet built.** Same weight as Feedback/Quick Check: real but light interaction, not a graded activity. The button must be gated on genuinely flipping every card, not just opening the page — otherwise this is exactly the "XP for passive content" case the core rule exists to prevent. Needs a small telemetry write on click (`flashcards_reviewed: true`, same `_completed`-suffix-or-equivalent pattern as everything else) before `auto_grade.py` can read it. |
| Journal Entry | Scales with the unit's own word-count target (see below) | A real save with content meeting or exceeding the stated minimum | Ties naturally to the existing year-long journal thread (`courses/python/course-plan.md`'s "Game Design, UX, and Journal Threads" section), which already grows from 50-75 words in Unit 00 to a ~2-page paper by the Unit 20 capstone. |
| Project — Required tier | 25 | The required checklist items are genuinely met | Baseline for a passing project submission. |
| Project — Bonus Tier 1 | +10 | One meaningful extension (matches `feedback-and-grading-spec.md`'s "+1 bonus point" description) | |
| Project — Bonus Tier 2 | +15 | Exceptional depth/creativity/ambition (matches that doc's "+2 bonus points" description) | Escalating, not flat — the point is to make going further worth noticeably more, not just a little more. |

**Naming-issue penalty (already implemented):** if a student's file doesn't match the expected filename but the grader can still identify it with reasonable confidence, it applies a flat **-2 XP** penalty rather than either ignoring the file or reporting zero credit — see `auto_grade.py`'s `NAMING_PENALTY_XP` and `find_file_fuzzy()`. The penalty never drops a genuinely-completed activity's XP below 1 (`MIN_XP_AFTER_PENALTY`) — a naming slip should sting a little, not erase real work.

## Extra Practice Beyond the Required Lane Earns More XP

Per Jay directly (2026-08-22): a student who opts into extra practice beyond what's required should be able to earn more XP for it, not just the flat one-time 8 XP above — and it should be worth noticeably more than base Practice, not just a token top-up, same escalating logic as the Project bonus tiers. **Extra/Extend Practice is worth 15 XP** (value locked in; the mechanism to award it is not yet built).

This is a real gap in the table above — as implemented today, `auto_grade.py`'s `grade_practice()` pays the full 8 XP on genuine first attempt and has no concept of a second, voluntary pass.

**Proposed shape** (mechanism design — not yet built, needs its own pass once the base XP mechanisms above are proven against real submissions):

- The unit folder's self-navigated Reinforce/Core/Extend ladder (`mvp-unit-folder-structure.md`) already gives a student somewhere to go beyond the required Core lane. Genuine engagement with the **Extend** lane — not just opening it, the same "no XP for passive content" rule as everywhere else — earns the 15 XP on top of the base 8 Practice XP, rather than folding into the same flat award.
- A student who redoes Core practice after already saving it once (e.g., wants another attempt at a drill they got wrong) is a different case from first-time Extend engagement, and probably shouldn't pay out the same way — repeat-attempt farming of the same drill set for repeated XP is the failure mode to design against. Whatever mechanism gets built needs a cap or a "new attempt on genuinely new content" gate, not an unbounded per-save award.
- This needs its own telemetry distinction (Extend-lane attempts vs. Core-lane attempts are currently the same event type in `telemetry-and-analytics.md`'s schema) before the grader could tell them apart — same category of gap as the embedded Quick Check telemetry below.

Not scoped yet: whether the 15 XP is per-lesson or per-drill-set, and the exact anti-farming cap. Added to Open Items below.

## Reading Pages: XP Through Interaction, Not Just Presence

Every instruction page that wants to earn XP needs at least one embedded Quick Check (the pattern already used in several Unit 0 and Unit 01 lessons — a short inline question with immediate feedback, distinct from the graded standalone Vocab Quiz/Practice/Mastery Check pages). This is deliberately the *lightest-weight* interaction in the whole system — one click, instant feedback, no save step — specifically so it doesn't compete with the heavier graded activities, but it's enough to prove the student actually engaged with that section rather than skimming past it.

**Not yet built:** none of the existing embedded Quick Checks currently write an XP/completion signal anywhere (they're pure client-side, ungraded, no telemetry). Before this row of the table is real, Quick Checks need a small telemetry write (matching the existing `foxcs-telemetry` pattern used elsewhere) that the grader can read — this is new work, not a retrofit of something already tracked. Scope it as its own pass once the current Unit 01 rebuild lands, not bundled in blind.

## Above-and-Beyond, Converted to XP

`feedback-and-grading-spec.md`'s existing Above-and-Beyond Bonus (Section 15) stays exactly as-is for the actual **grade** — a rare, teacher-approved +0/+1/+2 point bonus on a project's rubric score. This is a *separate* number from XP, not the same thing. Proposed XP conversion, applied only when Jay approves the bonus (never automatic, matching that section's `requiresTeacherApproval: true` rule):

- +1 bonus point approved → **+10 XP**
- +2 bonus points approved → **+20 XP**

This is the main lever for "I really want to incentivize above and beyond work" — the bonus tiers on the project itself (above) plus this conversion make genuinely exceptional work worth a clearly bigger XP jump than just finishing the required baseline, without touching the actual grading rubric's own rarity/approval rules.

## XP Lookup (concept, not yet built)

Jay wants students to be able to check their own accumulated XP as "the more official method based on their work" — a real number, not a private spreadsheet only Jay sees. Proposed shape, consistent with the existing codename-only / Release Gate architecture (`01-privacy-and-governance/data-boundaries.md`):

1. After a grading pass, `auto_grade.py`'s per-submission `total_xp_awarded` values get summed per codename across every lesson graded so far, producing a small `xp_totals.csv`/`.json` (codename → cumulative XP). Not yet built — a short aggregation step on top of the existing per-lesson report, not a new grading engine.
2. That file goes through the same Release Gate as any other grader output — Jay reviews it before it's published anywhere a student can see it. Nothing about XP being "just a fun number" exempts it from that rule; it's still generated from an automated process and still needs a human check before release.
3. A simple, self-contained student-facing **XP Lookup** page (matching the "no build system, self-contained HTML" architecture everywhere else) where a student enters their own codename and sees their current total, sourced from that published file — no server, no login, just a static page reading a small embedded/fetched JSON blob Jay re-publishes after each grading pass.

Not yet built. Needs the XP-earning mechanisms above to actually exist and be tested against real (or realistic sample) submissions first — see the mixed-proficiency Unit 01 sample submission folder being built alongside this doc for exactly that purpose.

## Open Items

- Extra/Extend Practice mechanism (value locked at 15 XP, see "Extra Practice Beyond the Required Lane Earns More XP" above) — needs a telemetry distinction between Extend-lane and Core-lane attempts and an anti-farming cap before it's buildable.
- Flashcard "Mark as Reviewed" mechanism (value locked at 3 XP, see table above) — needs the flip-all-cards gate and a telemetry write built into the flashcard component before any lesson can actually award it.
- Embedded Quick Check telemetry (needed before reading-page XP is real, not just documented).
- Exact journal XP scaling formula per unit, tied concretely to `course-plan.md`'s word-count progression — sketched above as a principle, not yet a per-unit table.
- The XP aggregation script and the lookup page itself — both concept-only as of this entry.
- Whether XP should ever be visible to a student *before* Jay's weekly release-gate review (leaning no, for consistency with every other grader output, but not explicitly decided).
