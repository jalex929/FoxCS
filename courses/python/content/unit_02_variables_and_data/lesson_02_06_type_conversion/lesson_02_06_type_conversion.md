---
lesson_id: lesson_02_06_type_conversion
unit_id: unit_02
lesson_number: "02.6"
title: Type Conversion
dok_levels_covered: [1, 2, 3]
skills:
  - skill_id: uses_type_function
    description: Uses type() to inspect a value's type.
  - skill_id: interprets_type_output
    description: Reads results such as <class 'int'>.
  - skill_id: converts_to_string
    description: Uses str().
  - skill_id: converts_to_integer
    description: Uses int().
  - skill_id: converts_to_float
    description: Uses float().
  - skill_id: predicts_valid_conversion
    description: Determines whether a conversion will work.
  - skill_id: predicts_invalid_conversion
    description: Recognizes incompatible conversion attempts.
  - skill_id: selects_conversion_for_context
    description: Chooses the conversion a program needs.
---

# 2.6 Type Conversion

Built 2026-09-10, against `skills-map.md`'s "02.6 Type Conversion" section. Recommended deadline there is Monday Sept 14, already past by build time -- flagging the date is stale, not backfilling a fake earlier build date. Repo-only so far: not yet deployed to any Moodle course. See `../../../../decisions-log.md` and `../../../../worklog.md` for the build session this lesson is part of.

## Overview

Sixth of the Unit 02 data-type lessons and the first to cover conversion between types rather than recognizing one type. Builds directly on 02.2-02.5 (each of which deliberately excluded `str()`/`int()` conversion, reserving it for this lesson) and introduces the 6-step Troubleshooting Routine for type-related bugs, since these are frequently **silent** (the program runs, just wrong) rather than crashing outright.

## Objectives

- Use `type()` and read its `<class '...'>` output correctly.
- Use `str()`, `int()`, and `float()` to convert a value's type on purpose.
- Predict whether a given conversion will succeed or raise a `ValueError`.
- Choose the correct conversion function for a given context (math vs. text output).
- Apply the 6-step Troubleshooting Routine (Read -> Identify -> Check types -> Test a conversion -> Revise -> Ask a specific question) to a type-related bug.

## Prerequisites

- 2.2 Integers, 2.3 Floats, 2.4 Strings, 2.5 Booleans (`../lesson_02_0{2,3,4,5}_*/`) -- recognizing each type this lesson converts between.
- Unit 02 Mixed Data-Type Checkpoint (`../checkpoint_mixed_data_types/`) -- the seven-value confusion set this lesson's conversions resolve.

## Vocabulary

- `type()`
- `str()` / `int()` / `float()`
- `ValueError`
- conversion

---

## Moodle Content (module structure)

### Instruction (`01_instruction.html`)

Single self-contained page, matching the 02.1-02.5 telemetry/save pattern (`local_foxcstelemetry` Option C: bootstrap/logEvent/localBackup, per-field draft autosave on the two open-text items). No `progress_state` resume gate here (unlike 02.1) -- page is short enough (Learn + Troubleshooting Routine + Practice, no long gated Learn sequence) that draft-autosaved answers are enough; nothing blocks re-reading earlier sections on return.

Content: Why This Matters, `type()` and Reading Its Output, The Three Conversion Functions, Predicting Valid and Invalid Conversions, The Troubleshooting Routine (all 6 steps) with a Worked Example built around the real GMetrix file (`121-conversion.py` -- the `rating * 100` string-repetition bug, chosen deliberately because it does NOT crash), then 6 Practice items.

**Real coverage gap, flagged not silently left:** the Practice section has one item per skill except `uses_type_function` (only demonstrated in the Troubleshooting Routine, never asked as its own practice item) and `converts_to_float` (`float()` is taught in the Learn section but no Practice item requires using or predicting it -- all 3 conversion-function items in Practice use `str()`/`int()`). Both are candidates for the `_02` question-bank pass below rather than a same-day Instruction-page edit.

### Coding Exercise (`coding-exercise/GMETRIX-121-conversion.py`)

Real GMetrix starter file (Workbook Domain 1, Objective 1.2.1 Data Type Conversion), same file used as the Worked Example above. Bug is the deliberate silent one: `rating` stays a string from `input()`, so `rating * 100` is legal string repetition, not math. Save-as convention: `GMETRIX-121-conversion-completed.py` (hyphen, matching 02.2-02.5's own convention). See `teacher-materials/coding_exercise_rubric.md` for the grading checklist.

### Mastery Check, Project, Feedback

**Not built this pass.** Per `course-plan.md`'s Unit 02 note, 02.6/02.7 are meant to get a per-lesson Mastery Check built alongside their Instruction content (same as 02.1-02.5), not deferred to a unit-level check (that pattern was dropped 2026-09-09). Feedback stays deferred to the single combined 02.2-02.6 activity per Jay's 2026-09-09 decision, now buildable since 02.6 exists.

## Next Steps

- Build the 02.6 Mastery Check (native Moodle quiz, 4 synthesis items per the 02.2-02.5 pattern, grade=10 per the standing point scale) -- next real gap, not yet started.
- Write a deploy script and push Instruction + Coding Exercise live (needs `backup_moodle.sh` first and Jay's go-ahead, per the Data Safety rule -- not done as a side effect of this repo-only pass).
- Backfill 02.3/02.4/02.5's own missing `.md`/`practice_question_bank.md` files -- flagged in `course-plan.md`'s 2026-09-08 note as due "before starting 02.6/02.7" and still not done; this lesson's build proceeded ahead of that anyway, per how the interrupted session actually played out.
- Not yet reviewed by Jay.
