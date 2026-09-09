---
lesson_id: checkpoint_mixed_data_types
unit_id: unit_02
lesson_number: null
title: "Unit 02 Checkpoint: Mixed Data Types"
dok_levels_covered: [1, 2]
skills:
  - skill_id: distinguishes_all_four_data_types_together
    description: Given a mixed set of values across int/float/str/bool, identifies each one's real type, including the two hardest confusions -- a quoted lookalike ("True", "12") vs. the real value, and a bare variable name vs. a string of that same name.
---

# Unit 02 Checkpoint: Mixed Data Types

Not a numbered lesson (02.x) -- an unscored-position review checkpoint that sits between 02.5 Booleans and 02.6 Type Conversion, per `../../course-plan.md`'s Unit 02 section and `../../skills-map.md`'s "Unit 02 Mixed Data-Type Checkpoint" note. Built 2026-09-09 as this session's prioritized build item, per Jay's direct instruction.

## Why This Exists

02.2-02.5 taught int/float/str/bool one at a time. This checkpoint is the first time students have to tell all four apart *together*, on purpose, right before 02.6 teaches conversion between them. Per `skills-map.md`: **"This checkpoint should deliberately surface misconceptions before students begin conversion."** If a student can't yet tell `12` from `"12"` from `score` (a variable holding `12`) from `"score"` (the literal text), type conversion won't make sense yet -- conversion is about deliberately crossing between types a student can already recognize.

## Source Material

- **GMetrix Workbook p.12, "Review 1.1"** (PDF page 18), read directly from `Python_v2_Student_Workbook.pdf`: "Identify the data types for each of the five print statements," 5 minutes estimated, using the real `114-analyze.py` file (`Python v2 Support Files/Domain 1/Student/114-analyze.py`). Video reference subtopics: `bool` (already assigned to 02.5, **not re-assigned here**) and `Review on 1.1` (not yet picked -- see Open Items below).
- `python-certification-workbook-map.md`'s Workbook p.12 entry: FoxCS placement "Unit 02 mixed data-type review," site activity "Certification Review / Coding Exercise."
- `skills-map.md`'s own short note (not a full lesson section like 02.2-02.7 get): explicitly names the seven-value confusion set `12` / `12.0` / `"12"` / `True` / `"True"` / `score` / `"score"` as what the checkpoint should test, which is harder and more targeted than the real GMetrix file's 5 generic type-checks alone.

## What Was Built

**Coding Exercise** (`coding-exercise/GMETRIX-114-analyze.py`), matching the file-only-.py submission pattern already standard for 02.2-02.5:

- **Part 1** is the real GMetrix `114-analyze.py` content, unmodified -- 5 `print(type(...))` statements, each preceded by a predict-first comment prompt, matching the workbook's own "identify the data types for each of the five print statements" task exactly.
- **Part 2** is FoxCS-original, added specifically to cover `skills-map.md`'s seven-value confusion set that the real GMetrix file doesn't test on its own: `12`, `12.0`, `"12"`, `True`, `"True"`, `score` (a variable), `"score"` (a string). Students predict each one's type as a comment, then uncomment a `print(type(...))` block to self-check. **No answer key is written anywhere in the student file** -- `type()`'s own output is the check, per the standing no-answer-keys-in-student-docs rule.

## Scope Decisions Made

- **Grade set to 5, not the 10 used for 02.2-02.5's Coding Exercises.** Those are fuller GMetrix-sourced builds; this is explicitly a 5-minute review task per the workbook's own "Estimated completion time." Matches `feedback_lesson_point_scale.md`'s 2-5pt practice tier rather than the 10pt quiz/assessment tier. **Flag for Jay to confirm** -- first time this distinction has been applied inside the Coding Exercise module type rather than between module types.
- **Not built as a separate Instruction module.** This checkpoint has no new concept to teach (unlike 02.2-02.5) -- it is pure review, so it only gets a Coding Exercise, no Instruction/Project/Mastery Check/Feedback modules of its own.
- **Module name:** "Unit 02 Checkpoint: Mixed Data Types" -- deliberately not given a "02.X" number, since it isn't a numbered lesson in `course-plan.md`/`skills-map.md`, to avoid implying a fixed slot in the 02.1-02.7 sequence.

## Open Items

- **"Review on 1.1" video not yet picked.** The workbook names it as a video subtopic for this page, but nobody has chosen a real video for it yet (unlike 02.2-02.5, where Jay picked or confirmed each video). Not embedded or linked in this build -- flag to Jay rather than picking one unasked, matching how video selection has worked for every other Unit 02 lesson.
- **Grade value (5) not yet confirmed by Jay** -- see Scope Decisions above.
- **Not yet deployed live** as of this doc's writing -- see `../../../../worklog.md` for deploy status.
- **Not yet reviewed by Jay.**
