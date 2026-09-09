---
lesson_id: lesson_02_03_floats
unit_id: unit_02
lesson_number: "02.3"
title: Floats
dok_levels_covered: [1, 2, 3]
skills:
  - skill_id: identifies_float_type
    description: Recognizes float values (a decimal point present, no quotation marks).
  - skill_id: distinguishes_int_vs_float
    description: Distinguishes a float from an integer by checking for the decimal point specifically, not the value or the presence of quotation marks.
  - skill_id: recognizes_float_disguised_as_whole
    description: Recognizes that a float written as a whole number (12.0) is still a float, since Python decides type from how a value is written, not what it equals mathematically.
  - skill_id: uses_float_for_decimal_quantity
    description: Selects a float for quantities that need decimal precision (price, percentage, measurement), as opposed to a plain integer count, text, or a two-state boolean.
  - skill_id: predicts_mixed_numeric_result
    description: Predicts that combining an integer and a float in arithmetic always produces a float, keeping the extra precision rather than crashing or truncating.
---

# 2.3 Floats

**Backfilled documentation, written 2026-09-09 against the lesson's real deployed content** -- the Instruction page (`01_instruction.html`) and Coding Exercise (`coding-exercise/GMETRIX-113-numbers.py`) were already live on the real `foxcs-python` Moodle course before this record existed (built to the sandbox 2026-09-08, promoted to the real course 2026-09-09: Instruction cmid=260, Coding Exercise cmid=265). This file exists to document that real content, matching the structural pattern `lesson_02_02_integers.md` established. See `../../../../../worklog.md` for the Unit 02 build session this lesson is part of, and `../../../course-plan.md`'s Unit 02 section for the standing checklist.

## Overview

Third of five data-type lessons (2.2-2.6), each covering one Python type in depth. This lesson covers floats: recognizing them, telling them apart from integers (including the trickiest case, a float written as a whole number like `12.0`), choosing a float on purpose for a quantity that needs decimal precision, and predicting what happens when integers and floats are mixed in arithmetic.

## Objectives

- Recognize a value written as a float (a decimal point present, no quotation marks).
- Distinguish a float like `12.0` from an integer like `12`, by checking for the decimal point specifically rather than the value itself.
- Recognize that a float written as a whole number (`12.0`) is still a float, not an integer, since Python decides type from how a value is written, not what it equals mathematically.
- Choose a float on purpose for a quantity that needs decimal precision (price, percentage, measurement), as opposed to a plain count, text, or a two-state boolean.
- Predict that mixing an integer and a float in arithmetic (`5 + 2.0`) always produces a float, never crashes and never drops the extra precision.

## Prerequisites

- 2.2 Integers (`../lesson_02_02_integers/`) -- recognizing integers, distinguishing an integer from a numeric-looking string, choosing an integer for a countable quantity.

## Vocabulary

- float
- floating-point number
- `type()`

---

## Moodle Content (5-module structure)

### Instruction (`01_instruction.html`)

Single self-contained page, same Watch First -> Learn -> Key Terms -> Practice shape and same Skulpt-checked drill engine as 2.1/2.2. 5 real adaptive skill nodes (one per skill above), each with a core item (Build-the-Code or Multiple Choice), a reinforce item, and an extend item (Build-the-Code, harder or new context). No spiral review or Game/UX reflection items this lesson, matching 2.2's pattern.

**Scope note:** node 3 (`recognizes_float_disguised_as_whole`) is the trickiest concept in the lesson -- students have to accept that `12.0` is a float even though it's mathematically equal to the integer `12`. The Learn section calls this out explicitly ("The Trickiest Case: A Float That Looks Whole") and the Usability Note ties it to a real symptom (a grade average coming out as `90.0` instead of `90`).

**Node summary, from the live page:**
1. `identifies_float_type` -- core: fill in `game_speed = 1.5`, checked against `Game Speed: 1.5`. reinforce: MC, which of `7`/`7.5`/`"7.5"`/`True` is a float (correct: `7.5`). extend: fill in `print(type(distance))` against `distance = 3.75`, expects `<class 'float'>`.
2. `distinguishes_int_vs_float` -- core: MC, which of `12`/`12.0`/`"12"`/`True` is a float, not an integer (correct: `12.0`). reinforce: MC, is `12.0` still a float even though it equals `12` (correct: yes). extend: fill in `average_score = 88.0` against `Average Score: 88.0`.
3. `recognizes_float_disguised_as_whole` -- core: fill in `print(type(height))` against `height = 6.0`, expects `<class 'float'>`. reinforce: MC, is a variable holding `20.0` a float or integer (correct: float). extend: a thermostat context, fill in `target = 70.0` against `Target: 70.0`.
4. `uses_float_for_decimal_quantity` -- core: fill in `game_speed = 1.25` against `Game Speed: 1.25`. reinforce: MC, which of (lives / price $4.99 / name / paused state) needs a float (correct: price). extend: `price = 4.99` exists, fill in `tax = 0.35` so `price + tax` prints `Total: 5.34`.
5. `predicts_mixed_numeric_result` -- core: `lives = 3` and `bonus = 0.5` exist, fill in `total = lives + bonus` against `Total: 3.5`. reinforce: MC, what does `5 + 2.0` print (correct: `7.0`). extend: `base = 10` exists, fill in `adjusted = base * 0.75` against `Adjusted: 7.5`.

Full item-by-item detail, including live wording and feedback text, is in `teacher-materials/practice_question_bank.md`.

### Video

**"Python Integers vs Floats - Visually Explained"** by Visually Explained, embedded at the top of the Instruction page. Per `../../../video-resources.md`, this pairing was Jay's deliberate choice: 2.2 got the combined Corey Schafer integers-and-floats video (first exposure to numeric types generally), and 2.3 gets this int-vs-float comparison instead, since it's a better fit for what's actually new in this lesson. **Length not yet independently confirmed** -- automated YouTube length lookups from this droplet have failed for every video except 2.5's; verify by eye before a class watches it.

### Coding Exercise (`coding-exercise/GMETRIX-113-numbers.py`)

Live as a native Moodle Assignment (cmid=265), file-only `.py` submission, matching 2.2's Coding Exercise settings. The real starter file (Workbook p.11, float half, GMetrix Domain 1 Lesson 2 Objective 1.1.3) gives students `number_of_tries = 3` (int) and `multiplier = 1.5` (float) already defined, then has them: (1) write a `print` statement adding the two together and predict the resulting type as a comment, (2) change that same statement to divide instead of add and predict the resulting type again, (3) fill in a closing blank contrasting when a game would need an integer (scores) versus a float (money). Save-as convention follows the workbook's own instruction: `GMETRIX-113-numbers-completed.py` (hyphen before "completed").

### Project, Mastery Check, Feedback

**Project:** Not built for this lesson. Per-lesson Projects aren't the standing pattern for 02.2 onward -- 02.1's own Project was Unit 02's pilot-proof pass, not a per-lesson template carried forward.

**Mastery Check:** being built separately, see `teacher-materials/mastery_check_key.md` once available.

**Feedback:** resolved 2026-09-09 -- one combined Feedback activity covering 02.2-02.5 together, planned to be built once 02.6 lands, not a per-lesson activity for this lesson individually.

## Next Steps

- Not yet reviewed by Jay.
- Video length for the Visually Explained video (assigned in `../../../video-resources.md`) is still not independently confirmed -- check before relying on the stated runtime, even though the page is already live.
- Project/Mastery-Check-as-unit-level is no longer the plan as of 2026-09-09 -- per-lesson Mastery Checks are now the standard (being built in parallel to this backfill) and there is no unit-level cumulative Mastery Check. The Unit Project instead carries cross-lesson synthesis, per `../../../../../02-authoring-system/mastery-check-standards.md`.
