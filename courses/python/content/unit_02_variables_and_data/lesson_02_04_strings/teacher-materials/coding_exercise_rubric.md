# 2.4 Coding Exercise: Strings: grading rubric

**Points:** 10 (the Coding Exercise value in `02-authoring-system/grade-point-scale.md`). **Starter file:** `GMETRIX-111-str.py`. **Source:** criteria and points are Jay's, from `courses/python/teacher-materials/sources/KEY_Unit_2_Coding_Exercise_Rubrics_2026-09-28.pdf`, built from the live Moodle starter files and instructions. Transcribed 2026-11-04.

The student prints a full name, then answers two conceptual questions about quoting.

## Submission gate (check first)

From Jay's Sept 28 key. About 70% of Unit 2 zeros came from these, so apply them the same way every time:

- [ ] **The work can be opened.** A CodeHS sandbox link that isn't shared "anyone with the link" scores 0, with the standard note and a resubmission allowed.
- [ ] **It's this exercise.** Work for a different exercise scores 0, with a note naming which one it actually is, and a resubmission allowed.
- [ ] **Something was changed.** The untouched starter file scores 0, with a note that no work was done, and a resubmission allowed.

The new iteration of the course takes a `.py` upload only, which removes the first case entirely. Until then, keep applying the gate.

## Criteria

| Criterion | Points | What to check |
|---|---|---|
| Full-name print statement | 4 | Outputs `first_name` and `last_name` together in a valid order. If last-then-first, the two are separated by a comma, as instructed. |
| Runs without error | 2 | Running the file prints the full name with no errors. |
| Blank 4 answered | 2 | Answer is **curly** (or "smart") quotes. Python only accepts straight single or double quotes. |
| Q5 explanation | 2 | Identifies that the unescaped apostrophe in `'Jason's turn'` closes the string early, breaking the rest of the line. Accept any answer that names the apostrophe as the cause. |

Written answers are judged on the idea, not the English (`05-grader/comment-reasoning-rubric.md`, "What not to grade"). Accept close paraphrases. Q5 has an expected answer (the apostrophe ends the string early). Mark it right or wrong against that; it is not scored on the leveled "why" scale.

## What the on-submission grader can check

Runs without errors, and the output contains both `Jason` and `Manibog`. Name order and the comma rule, and both written answers, are review criteria.

## Points vs. the 50% runs / 50% correct standard

`02-authoring-system/coding-exercise-standards.md` (Sept 14) splits every Coding Exercise 50/50. This rubric (Sept 28) splits points by task instead. Both are kept as written until Jay decides which wins; see `REPO_MAP.md`'s Known Tensions.
