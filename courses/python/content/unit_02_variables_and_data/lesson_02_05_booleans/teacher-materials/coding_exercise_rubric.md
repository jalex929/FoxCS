# 2.5 Coding Exercise: Booleans: grading rubric

**Points:** 10 (the Coding Exercise value in `02-authoring-system/grade-point-scale.md`). **Starter file:** `GMETRIX-114-boolean.py`. **Source:** criteria and points are Jay's, from `courses/python/teacher-materials/sources/KEY_Unit_2_Coding_Exercise_Rubrics_2026-09-28.pdf`, built from the live Moodle starter files and instructions. Transcribed 2026-11-04.

The student runs a broken file, fixes a casing bug, then answers a vocabulary blank.

## Submission gate (check first)

From Jay's Sept 28 key. About 70% of Unit 2 zeros came from these, so apply them the same way every time:

- [ ] **The work can be opened.** A CodeHS sandbox link that isn't shared "anyone with the link" scores 0, with the standard note and a resubmission allowed.
- [ ] **It's this exercise.** Work for a different exercise scores 0, with a note naming which one it actually is, and a resubmission allowed.
- [ ] **Something was changed.** The untouched starter file scores 0, with a note that no work was done, and a resubmission allowed.

The new iteration of the course takes a `.py` upload only, which removes the first case entirely. Until then, keep applying the gate.

## Criteria

| Criterion | Points | What to check |
|---|---|---|
| Bug fixed | 4 | `char_life = true` changed to `char_life = True` (correct Python capitalization). |
| Runs correctly | 3 | Running the file prints `you are still in the game` with no errors. |
| Blank 3 answered | 3 | Answer is **Title** (capitalized) casing: booleans are written `True` / `False`, not `true` / `false`. |

Written answers are judged on the idea, not the English (`05-grader/comment-reasoning-rubric.md`, "What not to grade"). Accept close paraphrases.

## What the on-submission grader can check

Runs without errors, and the output contains `you are still in the game`. A file that still has `true` fails with a `NameError`, which the grader reports as does-not-run. The blank is a review criterion.

## Points vs. the 50% runs / 50% correct standard

`02-authoring-system/coding-exercise-standards.md` (Sept 14) splits every Coding Exercise 50/50. This rubric (Sept 28) splits points by task instead. Both are kept as written until Jay decides which wins; see `REPO_MAP.md`'s Known Tensions.
