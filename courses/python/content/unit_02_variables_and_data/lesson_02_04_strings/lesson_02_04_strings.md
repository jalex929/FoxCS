---
lesson_id: lesson_02_04_strings
unit_id: unit_02
lesson_number: "02.4"
title: Strings
dok_levels_covered: [1, 2, 3]
skills:
  - skill_id: identifies_string_type
    description: Recognizes string values (text wrapped in quotation marks), regardless of what characters appear inside them.
  - skill_id: recognizes_quotes_override_appearance
    description: Recognizes that quotation marks decide the type no matter what's inside them -- a number, True/False, or another variable's name spelled out is still a string once quoted.
  - skill_id: distinguishes_string_from_variable
    description: Distinguishes a bare variable name (looked up, prints the stored value) from the same word in quotes (printed literally), e.g. room vs. "room".
  - skill_id: recognizes_numeric_looking_string
    description: Recognizes a numeric-looking string (like "5") as text, not a number, and predicts that + on two such strings joins them rather than adding.
  - skill_id: recognizes_boolean_looking_string
    description: Recognizes a boolean-looking string (like "True") as text, not the real Python boolean, and distinguishes it from the unquoted True.
---

# 2.4 Strings

**Backfilled documentation, written 2026-09-09 against the lesson's real deployed content** -- the Instruction page (`01_instruction.html`) and Coding Exercise (`coding-exercise/GMETRIX-111-str.py`) were already live on the real `foxcs-python` Moodle course before this record existed (built to the sandbox 2026-09-08, promoted to the real course 2026-09-09: Instruction cmid=261, Coding Exercise cmid=266). This file exists to document that real content, matching the structural pattern `../lesson_02_02_integers/lesson_02_02_integers.md` established. See `../../../../../worklog.md` for the Unit 02 build session this lesson is part of, and `../../../course-plan.md`'s Unit 02 section for the standing checklist.

## Overview

Fourth of five data-type lessons (2.2-2.6), each covering one Python type in depth. This lesson covers strings: recognizing them, understanding that quotation marks decide the type regardless of what's inside them, telling a bare variable name apart from the same word in quotes, and spotting numbers and booleans disguised as strings.

## Objectives

- Recognize a value written as a string (text wrapped in quotation marks), regardless of what characters appear inside the quotes.
- Recognize that quotation marks decide the type no matter what's inside them -- a number, `True`/`False`, or another variable's name spelled out is still a string once quoted.
- Distinguish a bare variable name (`room`, which Python looks up) from the same word in quotes (`"room"`, which Python prints literally).
- Recognize a numeric-looking string (like `"5"`) as text, not a number, and predict that `+` on two such strings joins them together instead of adding.
- Recognize a boolean-looking string (like `"True"`) as text, not the real Python boolean, and distinguish it from the unquoted `True`.

## Prerequisites

- 2.2 Integers (`../lesson_02_02_integers/`) -- recognizing integers, distinguishing an integer from a numeric-looking string (`player_id = "042"`, the exact case this lesson's node 4 revisits from the other direction).
- 2.3 Floats (`../lesson_02_03_floats/`) -- recognizing floats, distinguishing floats from integers.

## Vocabulary

- string
- quotation marks
- `type()`

---

## Moodle Content (5-module structure)

### Instruction (`01_instruction.html`)

Single self-contained page, same Watch First -> Learn -> Key Terms -> Practice shape and same Skulpt-checked drill engine as 2.1-2.3. 5 real adaptive skill nodes (one per skill above), each with a core item (Build-the-Code or Multiple Choice), a reinforce item, and an extend item. No spiral review or Game/UX reflection items this lesson, matching the established pattern.

**Scope note:** the Learn section's single most load-bearing rule is "Quotes Override Appearance" (node 2) -- the page states it explicitly: "whatever is inside quotation marks is text, no matter what it looks like. Python doesn't check the contents to decide the type -- it just checks for the quotation marks." This is directly connected back to 2.2's `player_id = "042"` example via a Usability Note, reinforcing the concept across lessons rather than introducing it in isolation.

**Node summary, from the live page:**
1. `identifies_string_type` -- core: fill in `player_name = "Rowan"`, checked against `Player Name: Rowan`. reinforce: MC, which of `Rowan` (unquoted)/`"Rowan"`/`5`/`True` is a string (correct: `"Rowan"`). extend: fill in `print(type(greeting))` against `greeting = "Hello"`, expects `<class 'str'>`.
2. `recognizes_quotes_override_appearance` -- core: fill in `id_code = "100"` (text on purpose) against `ID Code: 100`. reinforce: MC, what type is `"True"` (correct: string). extend: fill in `print(type(quantity))` against `quantity = "42"`, expects `<class 'str'>`.
3. `distinguishes_string_from_variable` -- core: `location = "cave"` exists, fill in `print(location)` against `cave`. reinforce: MC, `x = "score"` was created, what does `print(x)` print (correct: `score`). extend: same `location = "cave"`, fill in `print("location")` to print the literal word `location` instead of the stored value.
4. `recognizes_numeric_looking_string` -- core: fill in `zip_code = "60601"` (text on purpose) against `Zip Code: 60601`. reinforce: MC, is `"100"` an integer or a string (correct: string). extend: `count = "5"` exists, fill in `print(count + count)` against `55` (string concatenation, not addition).
5. `recognizes_boolean_looking_string` -- core: fill in `status = "True"` (a string that says True, not the real boolean) against `Status: True`. reinforce: MC, which of `"True"`/`True` is the real Python boolean (correct: `True`, unquoted). extend: fill in `print(type(door_locked))` against `door_locked = "False"`, expects `<class 'str'>`.

Full item-by-item detail, including live wording and feedback text, is in `teacher-materials/practice_question_bank.md`.

### Video

**"Python Strings || Python Tutorial || Python Programming"** by Socratica, embedded at the top of the Instruction page. **Length not yet independently confirmed** -- automated YouTube length lookups from this droplet have failed for every video except 2.5's; verify by eye before a class watches it. Per `../../../video-resources.md`.

### Coding Exercise (`coding-exercise/GMETRIX-111-str.py`)

Live as a native Moodle Assignment (cmid=266), file-only `.py` submission, matching 2.2/2.3's Coding Exercise settings. The real starter file (Workbook p.10, str half, GMetrix Domain 1 Lesson 2 Objective 1.1.1) gives students `first_name = "Jason"` and `last_name = "Manibog"` already defined, then has them: (1) write a `print` statement that combines both into a full name, in either order (with a comma if last-then-first), (2) run it to confirm, (3) fill in a blank naming the one quote style Python does not allow (mixing single/double, e.g. triple quotes is not the expected answer here -- the blank is about the specific rule the workbook is testing), (4) explain in a comment why `print('Jason's turn')` would error. Save-as convention follows the workbook's own instruction: `GMETRIX-111-str-completed.py` (hyphen before "completed").

### Project, Mastery Check, Feedback

**Project:** Not built for this lesson. Per-lesson Projects aren't the standing pattern for 02.2 onward -- 02.1's own Project was Unit 02's pilot-proof pass, not a per-lesson template carried forward.

**Mastery Check:** being built separately, see `teacher-materials/mastery_check_key.md` once available.

**Feedback:** resolved 2026-09-09 -- one combined Feedback activity covering 02.2-02.5 together, planned to be built once 02.6 lands, not a per-lesson activity for this lesson individually.

## Next Steps

- Not yet reviewed by Jay.
- Video length for the Socratica "Python Strings" video (assigned in `../../../video-resources.md`) is still not independently confirmed -- check before relying on the stated runtime, even though the page is already live.
- Real content question, flagged rather than guessed: the starter file's step 4 ("Fill in the blank: in Python, you can wrap a string in single or double quotes, but not ___ quotes") doesn't spell out its own expected answer in the file itself -- the file is self-checked by the student, no answer key embedded there (correctly, per the no-answer-keys-in-student-docs rule), but there's also no `teacher-materials/` key for the Coding Exercise's own blanks. Worth adding one alongside the Mastery Check retrofit, since `feedback_submission_rubric_requirement.md` expects every gradable submission to have an internal rubric.
- Project/Mastery-Check-as-unit-level is no longer the plan as of 2026-09-09 -- per-lesson Mastery Checks are now the standard (being built in parallel to this backfill) and there is no unit-level cumulative Mastery Check. The Unit Project instead carries cross-lesson synthesis, per `../../../../../02-authoring-system/mastery-check-standards.md`.
