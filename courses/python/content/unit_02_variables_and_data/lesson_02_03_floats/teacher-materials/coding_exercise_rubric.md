# 2.3 Coding Exercise: Floats: grading rubric

**Points:** 10 (the Coding Exercise value in `02-authoring-system/grade-point-scale.md`). **Starter file:** `GMETRIX-113-numbers.py`. **Source:** criteria and points are Jay's, from `courses/python/teacher-materials/sources/KEY_Unit_2_Coding_Exercise_Rubrics_2026-09-28.pdf`, built from the live Moodle starter files and instructions. Transcribed 2026-11-04.

The student adds a print statement for addition, answers a blank, changes it to division, answers another blank, then fills in a final vocabulary blank.

## Submission gate (check first)

From Jay's Sept 28 key. About 70% of Unit 2 zeros came from these, so apply them the same way every time:

- [ ] **The work can be opened.** A CodeHS sandbox link that isn't shared "anyone with the link" scores 0, with the standard note and a resubmission allowed.
- [ ] **It's this exercise.** Work for a different exercise scores 0, with a note naming which one it actually is, and a resubmission allowed.
- [ ] **Something was changed.** The untouched starter file scores 0, with a note that no work was done, and a resubmission allowed.

The new iteration of the course takes a `.py` upload only, which removes the first case entirely. Until then, keep applying the gate.

## Criteria

| Criterion | Points | What to check |
|---|---|---|
| Addition print statement | 2 | Prints `number_of_tries + multiplier` (or equivalent) and runs without error. |
| Blank 3 answered | 1 | Answer is **float** (int + float returns a float). |
| Changed to division | 2 | The same print statement now divides instead of adds, and runs without error. |
| Blank 5 answered | 1 | Answer is **float** (Python 3's `/` always returns a float). |
| Blank 6 answered | 2 | Scores and counters use **integers**, money uses **floats**. |
| Both runs verified | 2 | The student actually ran the file both times, not just wrote the code: correct output for both the addition and the division version. |

Written answers are judged on the idea, not the English (`05-grader/comment-reasoning-rubric.md`, "What not to grade"). Accept close paraphrases. The final file only holds the division version, so "both runs verified" is judged from the student's comments or answers, not from the program run.

## What the on-submission grader can check

Runs without errors, and the output contains `2.0` (3 / 1.5). The three blanks are review criteria for the AI tier.

## Points vs. the 50% runs / 50% correct standard

`02-authoring-system/coding-exercise-standards.md` (Sept 14) splits every Coding Exercise 50/50. This rubric (Sept 28) splits points by task instead. Both are kept as written until Jay decides which wins; see `REPO_MAP.md`'s Known Tensions.
