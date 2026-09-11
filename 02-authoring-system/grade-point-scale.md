# Grade Point Scale

**Status: settled 2026-09-10, per Jay directly, across several rounds of back-and-forth.** Built for FoxCS: Python (the only course with live graded content so far) but written to be the standing template every other CS pathway course (Game II, Web Dev, Software Dev) reuses once they reach live build — see `../CLAUDE.md`'s course catalog. Don't invent a different scale per course; extend this one.

## This Is the Moodle Gradebook `grade` Field — Not XP

**These two systems are separate, with exactly one deliberate, narrow bridge between them (Project extra credit, below) — don't extend that bridge anywhere else without a real reason:**

- **This doc** — the actual Moodle gradebook point total per activity (the `grade`/`grademax` field on an `assign`/`quiz` module). This is what shows up on a report card / percentage grade.
- **XP** (`xp-and-incentives.md`) — a wholly separate incentive layer, already locked 2026-08-22 (Mastery Check = 20 XP, Practice = 8 XP, Project = 25 XP + bonus tiers, etc.), tracked outside Moodle's own gradebook by `05-grader/school-side/auto_grade.py`. **XP is not a student's grade.** Don't reuse XP numbers as grade numbers, or vice versa, outside the one conversion defined below — they answer different questions (XP: "did you engage genuinely," grade: "how well did you do").

## Why This Exists

Before this doc, live grade values were a real mess: Unit 01's Coding Exercises and Mastery Checks were all `grade=100` (old percentage-style default), 02.1's Project was also `grade=100`, but 02.1-02.5's Mastery Checks had already been moved to `grade=10` per `feedback_lesson_point_scale.md`'s "keep totals small" rule, and 02.2-02.5's Coding Exercise grade values were never confirmed anywhere. No consistent structure existed to hand to the next course. This doc is that structure.

## The Four Activity Types

| Type | Grade max | Notes |
|---|---|---|
| **Instruction** (Learn + Practice bundled — see `../CLAUDE.md`'s 5-module structure) | **5** | Currently earns 0 anywhere live — the embedded Practice items are client-side JS checks (`checkMC`/`checkText` etc.), never touch Moodle's gradebook. This is new: a light completion-based credit (genuinely worked through the reading-checks/practice, not gated on getting every item right — matches the "no XP for passive content" spirit, just as a grade instead of XP). |
| **Coding Exercise** | **10** (full exercise) / **5** (Checkpoint-style lighter review, e.g. the Unit 02 Mixed Data-Type Checkpoint) | Real graded work product — a fixed bug, an autograder-checkable rubric (see e.g. `courses/python/content/unit_02_variables_and_data/lesson_02_06_type_conversion/teacher-materials/coding_exercise_rubric.md` for the shape a per-lesson rubric should take). Same tier as Mastery Check when it's the full version. |
| **Mastery Check** | **10** | Already the live, consistent value across 02.1-02.5 (`build-lesson-02-0{1-5}-mastery-check.php`). No change — this is the anchor the rest of the scale was set relative to. |
| **Project** | **25** (uninflated — this is the real Moodle max, no overflow inside Moodle's own rubric) | Tier assessment (Starter/Skilled/Legendary/Mythic, unchanged from `project-rubric-and-xp-tiers.md`) still produces 15/25/35/45 XP. Base Moodle grade is `min(tier_XP, 25)`. Extra XP above 25 converts to a small bonus percentage — see "Project: How the Extra-Credit Mechanism Works" below. |

Per-lesson nominal total (everything at "meets requirements," not exceptional): 5 + 10 + 10 + 25 = **50**. A student who does exactly what's asked, well, across all four scores 50/50 = 100%. A Legendary or Mythic project adds a small XP-converted bonus on top of just its own item (+2% or +4% on the Project specifically) — see below — not a large jump on the whole lesson total.

## Project: How the Extra-Credit Mechanism Works

Per Jay directly: point totals should stay small (no item inflated to 100), a student should be able to exceed 100% through exceptional project work, but the overage should be **modest, not excessive** — "a few points over 100%," not the 120-140% range a raw rubric-overflow approach would produce.

**Revised mechanism, replacing a rubric-overflow-based first draft of this section:** the Project's Moodle `grade` field stays a normal, uninflated **25** (the Skilled/on-level tier — full marks for genuinely meeting every requirement, nothing more). The tier assessment itself (Starter/Skilled/Legendary/Mythic) is made the same way it already is for XP purposes — see `project-rubric-and-xp-tiers.md`'s rubric criteria — and produces the existing tier XP value (15/25/35/45), unchanged. The Moodle-native base score is `min(tier_XP, 25)`, so Starter shows 15/25 (60%), and Skilled/Legendary/Mythic all show a full 25/25 (100%) base — a project can't score *below* Skilled just for being merely correct, and can't inflate past 25 in Moodle's own rubric either.

**Then, separately, extra project XP converts to a small bonus on top, per Jay's stated rate: every 5 XP earned above the Skilled baseline (25) adds +1% to that Project's grade.**

```
extra_xp = max(0, tier_XP - 25)
bonus_percent = floor(extra_xp / 5)
```

- Starter (15 XP): extra = 0 (below baseline, no bonus) — Project grade: 15/25 = **60%**
- Skilled (25 XP): extra = 0 — Project grade: 25/25 = **100%**
- Legendary (35 XP): extra = 10 → **+2%** — Project grade: **102%**
- Mythic (45 XP): extra = 20 → **+4%** — Project grade: **104%**

The existing tier ceiling (Mythic = 45, the top of the already-locked XP table) self-limits the bonus at +4% — there's no separate arbitrary cap to maintain, it falls out of numbers that are already fixed elsewhere. This directly matches "a few points over 100%, not excessive."

**Not yet decided, real engineering question:** how the +2%/+4% actually lands in Moodle's gradebook — options include a small grade override on the Project item itself (raw score set to 25 × 1.0{bonus}, e.g. 25.5 for Mythic) or a separate tiny always-positive "Project Bonus" extra-credit item that only ever adds. Either works; pick one when this is actually implemented, don't build both.

## Known Tension This Doc Creates — Above-and-Beyond Bonus (Section 15)

`05-grader/feedback-and-grading-spec.md` Section 15 ("Above-and-Beyond Bonus") describes a **separate**, older mechanism: up to +1/+2 bonus points added on top of a project's rubric score, teacher-approval-gated. This is the same "stacking" model `project-rubric-and-xp-tiers.md` already said it was replacing for XP (25 required + stacking bonuses) — but Section 15 was never actually updated to match, and it's written for the live autograder (`05-grader/`), a more sensitive doc to edit unilaterally. **Not resolved here.** The XP-to-percent bonus above should probably *be* the Above-and-Beyond mechanism going forward, computed automatically from the tier XP rather than a separate teacher-approved +1/+2 judgment call — two different bonus mechanisms both firing off the same "exceeded expectations" signal would double-count it. Flagged in `REPO_MAP.md`'s Known Tensions list — resolve before `05-grader/` is actually driving real grades against Project submissions.

## Open Retrofit Questions — Real Grade Changes, Need Jay's Go-Ahead

Not applied to anything live yet. Both are real changes to currently-enrolled students' grades:

1. **Unit 01** (01.4-01.6 Coding Exercises + Mastery Checks, all still `grade=100`) **and 02.1's Project** (still `grade=100`) — rescale to match this doc, or leave grandfathered since they already shipped?
2. **Instruction's new 5-point grade** — apply retroactively to the already-live 02.1-02.5 Instruction pages (meaning past student work needs a grade backfilled), or forward-only starting at 02.6?

## Applying This to Future Courses

When Game II / Web Dev / Software Dev reach live build (see `../CLAUDE.md`'s course catalog), reuse this table directly rather than re-deriving a scale per course — that's the whole point of settling it here first on Python. If a future course's module structure doesn't map cleanly onto Instruction/Coding Exercise/Mastery Check/Project (e.g. a course with no Coding Exercise tier), update this doc's table to add that course's own row rather than forking a separate point-scale doc per course.
