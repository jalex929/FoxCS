# 01.3 Coding Exercise: Write a real program: grading rubric

**Points:** 10, split 50% runs / 50% correct (`02-authoring-system/coding-exercise-standards.md`). **Bonus tiers** (+10 / +20 XP) are separate from the grade and never change it. **Source:** the assignment as built in `07-infrastructure/moodle-scripts/build-lesson-01-03-coding-exercise.php`. Written 2026-11-04 to close the gap `coding-exercise-standards.md` flagged (Unit 01's Coding Exercises went live without rubrics).

Students pick one of five themes (short story, hero's adventure, recipe, boss battle announcer, character bio card) and bring it to life with `print()` statements.

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Runs (5 points)

| Criterion | Points | What to check |
|---|---|---|
| Runs without errors | 5 | The file runs top to bottom with no error. Any syntax or runtime error: 0 here, and the correct half can't be judged. |

## Correct (5 points)

| Criterion | Points | What to check |
|---|---|---|
| At least 5 real print() statements | 3 | Five or more, each doing real work (a sentence or a real line of the theme), not one word or a blank line. 3 or 4 real ones: 2 points. 1 or 2: 1 point. |
| Fits a chosen theme, in a sensible order | 2 | The output reads as one of the five options, and the lines appear in the order they should (beginning, middle, end for a story; steps in order for a recipe). On theme but out of order: 1 point. |

The theme is open on purpose. Any coherent take on an option earns full credit; don't grade creativity or writing quality.

## What the on-submission grader can check

Runs without errors and prints at least 5 lines of output (`minOutputLines: 5`). Theme and order are review criteria for the AI tier.
