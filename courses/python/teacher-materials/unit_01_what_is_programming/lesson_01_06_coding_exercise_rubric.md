# 01.6 Coding Exercise: Fix the Big Four: grading rubric

**Points:** 10, split 50% runs / 50% correct (`02-authoring-system/coding-exercise-standards.md`). **Bonus tiers** (+10 / +20 XP) are separate from the grade and never change it. **Source:** the assignment as built in `07-infrastructure/moodle-scripts/build-lesson-01-06-coding-exercise.php`. Written 2026-11-04 to close the gap `coding-exercise-standards.md` flagged (Unit 01's Coding Exercises went live without rubrics).

Students fix a four-line program where each line has exactly one of the unit's Big Four mistakes, and name the mistake in a comment above each fix.

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Runs (5 points)

| Criterion | Points | What to check |
|---|---|---|
| Runs without errors | 5 | Every line is fixed well enough for the whole file to run. If any line still errors, the file doesn't run: 0 here. |

## Correct (5 points)

| Criterion | Points | What to check |
|---|---|---|
| Output matches the intended lines | 3 | Prints exactly `Welcome to the arena`, `Choose your character`, `Good luck out there!`, `Battle Start`. 0.75 per line. |
| Each fix comment names the right mistake | 2 | Expected answers, 0.5 each: line 1 `print(Welcome to the arena)`: **missing quotes**. Line 2 `Print(...)`: **wrong capitalization**. Line 3: **missing (closing) quote**. Line 4 `print(Battle Start)`: **missing quotes**. Close paraphrases count. |

These are expected answers, marked right or wrong. Tier 2's error names are bonus XP: right only if they match what Python actually raises (`NameError` / `SyntaxError` as appropriate).

## What the on-submission grader can check

Runs without errors, and the output contains all four intended lines. The named mistakes are review criteria.
