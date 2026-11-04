# 01.5 Coding Exercise: Comments that explain why: grading rubric

**Points:** 10, split 50% runs / 50% correct (`02-authoring-system/coding-exercise-standards.md`). **Bonus tiers** (+10 / +20 XP) are separate from the grade and never change it. **Source:** the assignment as built in `07-infrastructure/moodle-scripts/build-lesson-01-05-coding-exercise.php`. Written 2026-11-04 to close the gap `coding-exercise-standards.md` flagged (Unit 01's Coding Exercises went live without rubrics).

Students add a comment above each of four `print()` lines explaining *why* the line exists, without changing what the program does.

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Runs (5 points)

| Criterion | Points | What to check |
|---|---|---|
| Runs, with behavior unchanged | 5 | Runs with no error and still prints exactly the original four lines, in order: `Welcome back, Player!`, `Level 3`, `Time remaining: 02:45`, `Warning: low health!`. Runs but output changed: 3 points. |

## Correct (5 points)

| Criterion | Points | What to check |
|---|---|---|
| A comment above every print() | 1 | All four lines have a comment directly above them. Missing comments score 0 on the scale below. |
| Each comment explains why | 4 | Score each comment on the leveled scale in `05-grader/comment-reasoning-rubric.md`, average, and use its band: 100% = 4, 85% = 3.4, 70% = 2.8, 55% = 2.2, 40% = 1.6, 20% = 0.8. |

This is the one Unit 01 exercise where students give their own reasoning, so the leveled scale applies. Different true reasons can all earn full marks.

## What the on-submission grader can check

Runs without errors, and the output contains all four original lines (`expectedContains`). The comments are review criteria (`reviewCriteria`), so this exercise is never auto-scored as flawless.
