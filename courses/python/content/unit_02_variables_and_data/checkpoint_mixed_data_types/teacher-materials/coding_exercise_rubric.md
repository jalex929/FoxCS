# Unit 02 Checkpoint: Mixed Data Types: grading rubric

**Points:** 5 (a short review task, per `checkpoint_mixed_data_types.md`'s Scope Decisions). **Starter file:** `GMETRIX-114-analyze.py`. Written 2026-11-04. All predictions are **expected answers**, marked right or wrong; any clear way of naming the type counts (`str`, "string", "text").

## Submission gate (check first)

The same gate as Unit 02 (Jay's Sept 28 key): an unshared CodeHS link, work for a different exercise, or the untouched starter scores 0, with a note and a resubmission allowed. The new iteration of the course takes a `.py` upload only.

## Criteria

| Criterion | Points | What to check |
|---|---|---|
| Part 1 predictions | 2 | Five predictions as comments, before running. Expected: a. `str`, b. `bool`, c. `str` (`"20000"` is quoted), d. `float`, e. `int`. All 5 right: 2. 3 or 4 right: 1. Fewer: 0. |
| Part 2 predictions | 2 | Seven predictions. Expected: 1. `int`, 2. `float`, 3. `str`, 4. `bool`, 5. `str` (`"True"` is quoted), 6. `score`: accept **int** (it holds 12) **or** "a variable, not a value"; the starter's wording invites both, so both are right. 7. `str`. All 7: 2. 5 or 6: 1.5. 3 or 4: 1. Fewer: 0. |
| Checked by running | 1 | The `print(type(...))` block was uncommented and the file runs, printing twelve `<class '...'>` lines. |

Predictions are graded as written, even if the student then saw the real output. A prediction corrected after running, with a note saying so, still counts as right: catching your own misconception is the point of the checkpoint.

## What the on-submission grader can check

Runs without errors and prints at least 12 lines (`minOutputLines: 12`), which only happens with the check block uncommented. The predictions are review criteria.

## Known issue

Item 6's instruction ("a bare variable name ... isn't a value by itself") conflicts with `type(score)` printing `<class 'int'>`. Reword the starter in the polish pass so there's one expected answer.
