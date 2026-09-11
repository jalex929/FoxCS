# Grade Point Scale

**Status: revised 2026-09-11, per Jay directly — Project moved from per-lesson to per-unit.** Supersedes the 2026-09-10 version below, which scored Project as part of every lesson's own 50-point total. Built for FoxCS: Python (the only course with live graded content so far) but written to be the standing template every other CS pathway course (Game II, Web Dev, Software Dev) reuses once they reach live build — see `../CLAUDE.md`'s course catalog. Don't invent a different scale per course; extend this one.

## This Is the Moodle Gradebook `grade` Field — Not XP

**These two systems are separate, with exactly one deliberate, narrow bridge between them (Project extra credit, below) — don't extend that bridge anywhere else without a real reason:**

- **This doc** — the actual Moodle gradebook point total per activity (the `grade`/`grademax` field on an `assign`/`quiz` module). This is what shows up on a report card / percentage grade.
- **XP** (`xp-and-incentives.md`) — a wholly separate incentive layer, already locked 2026-08-22 (Mastery Check = 20 XP, Practice = 8 XP, Project = 25 XP + bonus tiers, etc.), tracked outside Moodle's own gradebook by `05-grader/school-side/auto_grade.py`. **XP is not a student's grade.** Don't reuse XP numbers as grade numbers, or vice versa, outside the one conversion defined below — they answer different questions (XP: "did you engage genuinely," grade: "how well did you do").

## Why This Exists

Before this doc, live grade values were a real mess: Unit 01's Coding Exercises and Mastery Checks were all `grade=100` (old percentage-style default), 02.1's Project was also `grade=100`, but 02.1-02.5's Mastery Checks had already been moved to `grade=10` per `feedback_lesson_point_scale.md`'s "keep totals small" rule, and 02.2-02.5's Coding Exercise grade values were never confirmed anywhere. No consistent structure existed to hand to the next course. This doc is that structure.

## The Lesson-Level Activity Types

**Project is no longer one of these — see "Unit Project" below.** Every lesson gets:

| Type | Grade max | Notes |
|---|---|---|
| **Instruction** (Learn + Practice bundled — see `../CLAUDE.md`'s 5-module structure) | **5** | Currently earns 0 anywhere live — the embedded Practice items are client-side JS checks (`checkMC`/`checkText` etc.), never touch Moodle's gradebook. This is new: a light completion-based credit (genuinely worked through the reading-checks/practice, not gated on getting every item right — matches the "no XP for passive content" spirit, just as a grade instead of XP). |
| **Coding Exercise** | **10** (full exercise) / **5** (Checkpoint-style lighter review, e.g. the Unit 02 Mixed Data-Type Checkpoint) | Real graded work product — a fixed bug, an autograder-checkable rubric (see e.g. `courses/python/content/unit_02_variables_and_data/lesson_02_06_type_conversion/teacher-materials/coding_exercise_rubric.md` for the shape a per-lesson rubric should take). Same tier as Mastery Check when it's the full version. |
| **Mastery Check** | **10** | Already the live, consistent value across 02.1-02.5 (`build-lesson-02-0{1-5}-mastery-check.php`). No change — this is the anchor the rest of the scale was set relative to. |

Per-lesson nominal total: 5 + 10 + 10 = **25**. A student who does exactly what's asked, well, across all three scores 25/25 = 100% *for that lesson*. Reflection is a separate, always-required element threaded through this (per-lesson or per-unit) via the existing Feedback module — see "Reflection Stays Required" below; it isn't a scored point item, don't add it to this table.

## Unit Project — Moved Out of the Per-Lesson Total, 2026-09-11

**Per Jay directly (2026-09-11): move to one major, summative Project per unit, not one per lesson.** Coding Exercises stay at the lesson level (see table above) — Project is the one activity type that graduates to unit scope. The Project is **required, not optional** — Jay's framing is that it's core, practical skill-building ("feel comfortable coding from nothing"), not extra-credit busywork — even though its points land *on top of* the per-lesson totals rather than inside any single lesson's own 25.

**Grade max: 20 points (provisional — Jay said "perhaps," not settled the way the 5/10/10 lesson values are).**

**Resolved 2026-09-11 — tier→grade is a direct lookup table, not a ratio of tier_XP to grade max.** There are only 4 discrete tiers (Starter/Skilled/Legendary/Mythic, per `project-rubric-and-xp-tiers.md`), so there's no need for continuous XP-to-points math for the base grade — the earlier "Option A vs Option B" rescale question this section used to pose doesn't actually apply once you stop trying to derive the percentage from a ratio. **Per Jay directly: Starter should land at 80%, not a strictly-proportional 60%** (60% is what a literal 15-XP/25-XP ratio would produce) — more generous credit for genuinely-completed-but-baseline project work. Skilled/Legendary/Mythic keep the same bonus logic as before (unaffected by the point-max change, since it's expressed in percentage terms):

| Tier | Tier XP | Project grade |
|---|---|---|
| Starter | 15 | **80%** (16/20) — set directly, not derived from the XP ratio |
| Skilled | 25 | **100%** (20/20) |
| Legendary | 35 | **103%** (+3%, "+3% per 10 XP over the Skilled baseline" — raised 2026-09-11 from an earlier +2%/+4% pass, per Jay: enough to feel worth chasing without inflating the grade) |
| Mythic | 45 | **106%** (+6%) |

```
if tier == Starter:  grade_percent = 80
elif tier == Skilled: grade_percent = 100
else:  # Legendary or Mythic
  extra_xp = tier_XP - 25
  grade_percent = 100 + floor(extra_xp / 10) * 3
```

Point totals stay small (no item inflated to 100), a student can exceed 100% through exceptional project work, but the overage stays modest — "a few points over 100%," matching the original intent.

**Still not yet decided, real engineering question (carried over, unaffected by the per-lesson→per-unit move or this resolution):** how the grade percent actually lands in Moodle's gradebook — a grade override on the Project item itself, or a separate always-positive "Project Bonus" extra-credit item. Pick one when this is actually implemented, don't build both.

## Known Tension This Doc Creates — Above-and-Beyond Bonus (Section 15)

`05-grader/feedback-and-grading-spec.md` Section 15 ("Above-and-Beyond Bonus") describes a **separate**, older mechanism: up to +1/+2 bonus points added on top of a project's rubric score, teacher-approval-gated. This is the same "stacking" model `project-rubric-and-xp-tiers.md` already said it was replacing for XP (25 required + stacking bonuses) — but Section 15 was never actually updated to match, and it's written for the live autograder (`05-grader/`), a more sensitive doc to edit unilaterally. **Not resolved here.** The XP-to-percent bonus above should probably *be* the Above-and-Beyond mechanism going forward, computed automatically from the tier XP rather than a separate teacher-approved +1/+2 judgment call — two different bonus mechanisms both firing off the same "exceeded expectations" signal would double-count it. Flagged in `REPO_MAP.md`'s Known Tensions list — resolve before `05-grader/` is actually driving real grades against Project submissions.

## Reflection Stays Required

**Per Jay directly (2026-09-11): every unit/lesson must keep a genuine reflection component, per-lesson or per-unit** — this isn't new scope, it's a standing requirement that must survive any retrofit or simplification. The existing native Moodle Feedback module (the 5th per-lesson module, `../CLAUDE.md`'s Purpose section) already serves this at lesson granularity. Nothing here changes that by default — if Unit 01's retrofit (below) or a future course's structure ever consolidates Feedback to per-unit instead of per-lesson, that's a deliberate call to make explicitly, not something that should quietly disappear because a unit got simplified.

## Unit 01 Retrofit — Simplified, Not Full Realignment

**Per Jay directly (2026-09-11), settled: Unit 01 does NOT need to fully match the model above.** It should move *much closer* to it, but a full per-module rescale isn't required. **The one hard constraint: nothing in Unit 01 should show `grademax=100` anymore** — that's the actual bar, not "matches Instruction=5/CE=10/MC=10 exactly."

**The approved simplification: one consolidated Unit 01 grade, not itemized per module.** Each of Unit 01's 6 lessons (01.1-01.6) contributes a flat, equal share — Jay's own suggestion was **5 points per lesson** (6 lessons × 5 = 30 total, tentative like the Unit Project's 20 above, not locked the way 5/10/10 is), credited for **completion** (the student took the Mastery Check) rather than fine-grained proportional scoring per item. This supersedes the earlier 2026-09-08 unit-level weighted-average model (`decisions-log.md`'s matching entry — MC 18/CE 4/Practice 3 = 25) that was already live for Unit 01; that model is now superseded by this simpler one, not layered on top of it.

**Still blocking any live change here, unrelated to the model decision above:** exactly 5 of Unit 01's 6 Mastery Check quizzes have empty `mdl_quiz_grades` despite real `mdl_grade_grades` data (01.3 alone has matching cache data) — root-cause this before touching any Unit 01 grade live, since Moodle reads from that cache, not the raw grade table. See the point-totals audit that found this (2026-09-10/11 session) for the exact query used to confirm it.

## Applying This to Future Courses

When Game II / Web Dev / Software Dev reach live build (see `../CLAUDE.md`'s course catalog), reuse this structure directly rather than re-deriving a scale per course — that's the whole point of settling it here first on Python. Per-lesson: Instruction/Coding Exercise/Mastery Check as in the table above. Per-unit: one required Unit Project. If a future course's module structure doesn't map cleanly onto this (e.g. a course with no Coding Exercise tier), update this doc to add that course's own row rather than forking a separate point-scale doc per course.
