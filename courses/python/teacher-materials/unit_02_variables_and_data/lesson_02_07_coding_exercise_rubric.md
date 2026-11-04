# 2.7 Coding Exercise: Reading Code with Variables: grading rubric

**Points:** 10. **Starter file:** `score_tracker_debug.py`. **Source:** criteria and points are Jay's, from `courses/python/teacher-materials/sources/KEY_Unit_2_Coding_Exercise_Rubrics_2026-09-28.pdf`. Transcribed 2026-11-04. The lesson and its starter file were built during the absence and are **not in this repo yet**: commit them from the droplet.

The bug: each round reassigns `score` instead of adding to it, so the "running total" never accumulates. A pure debugging task with no written answers.

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Criteria

| Criterion | Points | What to check |
|---|---|---|
| Fix applied | 5 | Each round's score line accumulates (`score += round_x` or `score = score + round_x`) instead of reassigning. |
| Correct output | 5 | Running the file prints exactly: `After round 1: 10`, `After round 2: 25`, `After round 3: 30`. |

## What the on-submission grader can check

Both criteria: the output check (`expectedContains` for each of the three lines) proves the fix. This exercise can be fully auto-scored, with no review criteria.
