# 01.4 Coding Exercise: Status board: grading rubric

**Points:** 10, split 50% runs / 50% correct (`02-authoring-system/coding-exercise-standards.md`). **Bonus tiers** (+10 / +20 XP) are separate from the grade and never change it. **Source:** the assignment as built in `07-infrastructure/moodle-scripts/build-lesson-01-04-coding-exercise.php`. Written 2026-11-04 to close the gap `coding-exercise-standards.md` flagged (Unit 01's Coding Exercises went live without rubrics).

Students write a game status board: normal status lines plus one message reporting a problem, worded the way the lesson's usability idea asks (specific and readable, not a code).

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Runs (5 points)

| Criterion | Points | What to check |
|---|---|---|
| Runs without errors | 5 | The file runs with no error. |

## Correct (5 points)

| Criterion | Points | What to check |
|---|---|---|
| At least 3 status lines | 2 | Three or more `print()` lines showing normal status information (health, score, level, and so on). Two: 1 point. |
| A clear problem message | 3 | At least one line reports a problem as a sentence a player would understand (`Not enough gold. You need 20 more.`), not a code like `ERR_02`. A problem message that is vague (`Error.`): 1 point. |

This is an expected-answer check, not a writing grade: either the problem is stated clearly enough to act on, or it isn't. Tier 2's comment on *why* the message is worded that way is bonus XP, judged with `05-grader/comment-reasoning-rubric.md`.

## What the on-submission grader can check

Runs without errors and prints at least 4 lines (`minOutputLines: 4`). Which line is the problem message, and whether it's clear, are review criteria.
