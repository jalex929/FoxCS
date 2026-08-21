# XP and Incentives

**Status: first-pass draft, 2026-08-21, per Jay — numbers are a proposal to react to and adjust, not settled.** This is a separate incentive layer on top of the existing completion/grading model (`05-grader/`, `feedback-and-grading-spec.md`), not a replacement for it. XP is meant to reward genuine engagement across every content type, encourage above-and-beyond work specifically, and give students a real, checkable number that reflects effort over the year — not a proxy for the actual grade.

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
| Flashcards | *Not yet trackable* | — | No completion signal exists in the current flashcard component (pure self-study, no save action). Flagged, not solved here — would need a lightweight "reviewed all N cards" click-through tracker before any XP could attach to it honestly. Don't fake a signal. |
| Journal Entry | Scales with the unit's own word-count target (see below) | A real save with content meeting or exceeding the stated minimum | Ties naturally to the existing year-long journal thread (`courses/python/course-plan.md`'s "Game Design, UX, and Journal Threads" section), which already grows from 50-75 words in Unit 00 to a ~2-page paper by the Unit 20 capstone. |
| Project — Required tier | 25 | The required checklist items are genuinely met | Baseline for a passing project submission. |
| Project — Bonus Tier 1 | +10 | One meaningful extension (matches `feedback-and-grading-spec.md`'s "+1 bonus point" description) | |
| Project — Bonus Tier 2 | +15 | Exceptional depth/creativity/ambition (matches that doc's "+2 bonus points" description) | Escalating, not flat — the point is to make going further worth noticeably more, not just a little more. |

**Naming-issue penalty (already implemented):** if a student's file doesn't match the expected filename but the grader can still identify it with reasonable confidence, it applies a flat **-2 XP** penalty rather than either ignoring the file or reporting zero credit — see `auto_grade.py`'s `NAMING_PENALTY_XP` and `find_file_fuzzy()`. The penalty never drops a genuinely-completed activity's XP below 1 (`MIN_XP_AFTER_PENALTY`) — a naming slip should sting a little, not erase real work.

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

- Flashcard completion tracking (needed before any XP can attach to flashcards honestly).
- Embedded Quick Check telemetry (needed before reading-page XP is real, not just documented).
- Exact journal XP scaling formula per unit, tied concretely to `course-plan.md`'s word-count progression — sketched above as a principle, not yet a per-unit table.
- The XP aggregation script and the lookup page itself — both concept-only as of this entry.
- Whether XP should ever be visible to a student *before* Jay's weekly release-gate review (leaning no, for consistency with every other grader output, but not explicitly decided).
