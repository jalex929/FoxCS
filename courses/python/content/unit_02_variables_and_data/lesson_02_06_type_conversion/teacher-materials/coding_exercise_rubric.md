# 2.6 Coding Exercise Grading Rubric — GMETRIX-121-conversion.py

Built 2026-09-10, per the standing rule that every gradable submission needs an internal rubric/checklist in `teacher-materials/` for the autograder to grade against. This is the first Coding Exercise in Unit 02 to get one written down -- 02.2-02.5's own CE grading has been running without a recorded checklist; that gap is real and flagged in `worklog.md`, not fixed here.

**Source file:** real GMetrix Workbook file, Domain 1 / Objective 1.2.1 (Data Type Conversion). Same file used as the lesson's Worked Example. **Submission convention:** file upload only (`.py`), student saves as `GMETRIX-121-conversion-completed.py` (hyphen, matching 02.2-02.5's convention), no online-text fallback.

## The starter bug

```python
# rating is supposed to be a whole number
rating = (input("Enter a rating between 1 and 5"))
points = (rating) * 100
print("You have " + (points) + " to start.")
```

Silent bug, deliberately: `input()` always returns a string, so `rating` is `"3"` (text), not `3`. `"3" * 100` is legal Python (string repetition), so the program does not crash -- it just prints `3` repeated 100 times instead of `300`. This is the same file used as the lesson's Worked Example, so a student who read the Instruction page before starting has already seen the fix walked through once; the Coding Exercise is applying it themselves, not discovering it cold.

## Correct fix (reference solution)

```python
rating = int(input("Enter a rating between 1 and 5"))
points = rating * 100
print("You have " + str(points) + " to start.")
```
(`print("You have", points, "to start.")` using comma-separated args is an equally valid alternative to the `str()`-wrapped `+` version -- don't penalize for choosing commas over `str()`, both are taught elsewhere in Unit 02.)

## Grading checklist

- [ ] **`rating` is converted to a number immediately after `input()`**, via `int(...)` wrapped around the `input()` call (or applied to `rating` on the next line before any math happens). `float(...)` is not the intended fix here (ratings are whole numbers, matching `uses_integer_for_countable_quantity` from 02.2) but should not be marked wrong if the rest of the program still produces correct output.
- [ ] **`points` is computed via real integer multiplication, not string repetition.** Testable directly: run the submission with input `3` and confirm the output contains `300`, not `3` repeated 100 times.
- [ ] **The final `print()` line runs without a `TypeError`.** Either `points` is wrapped in `str(...)` for `+` concatenation, or the line is rewritten to use comma-separated `print()` arguments instead.
- [ ] **Program runs end-to-end for at least two different valid inputs** without crashing or silently misbehaving (e.g., input `1` -> output contains `100`; input `5` -> output contains `500`).
- [ ] **No leftover debugging artifacts** -- stray `print(type(...))` calls or diagnostic comments added while fixing the bug should be cleaned up before submission (not a hard fail on their own, but flag if present).
- [ ] **Filename matches the save-as convention** (`GMETRIX-121-conversion-completed.py`) -- flag, don't fail solely on this, but note it for the file-naming pattern check across the unit.

## Grade value

Not yet set live (this lesson hasn't been deployed to Moodle yet -- see `../lesson_02_06_type_conversion.md`'s Next Steps). Per `feedback_lesson_point_scale.md`'s standing scale, this is a practice/application-tier item (2-5 pts), not a quiz/assessment (10 pts) -- closer to the Unit 02 Checkpoint's `grade=5` than a Mastery Check's `grade=10`. Confirm the exact live grade value against 02.2-02.5's own Coding Exercise `grade` field at deploy time rather than assuming 5 -- those weren't independently confirmed while writing this rubric.

## Not covered by this checklist

This rubric grades the fix, not code style (variable naming, comments) -- Unit 02's skills-map scope for this lesson is type conversion specifically, not general code quality. If a submission fixes the conversion bug but introduces an unrelated new error, treat that as a separate, secondary flag rather than folding it into this checklist's pass/fail.
