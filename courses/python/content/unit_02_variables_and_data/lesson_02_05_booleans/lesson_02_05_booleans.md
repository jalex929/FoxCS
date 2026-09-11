---
lesson_id: lesson_02_05_booleans
unit_id: unit_02
lesson_number: "02.5"
title: Booleans
dok_levels_covered: [1, 2, 3]
skills:
  - skill_id: identifies_boolean_type
    description: Recognizes boolean values (exactly True or False, capitalized, no quotation marks).
  - skill_id: applies_boolean_casing
    description: Writes True/False with the exact casing Python requires, and predicts that other casings (true, TRUE) crash with a NameError since Python reads them as an undefined variable name, not a keyword.
  - skill_id: distinguishes_boolean_from_string
    description: Distinguishes the real boolean True/False from a string that happens to say "True"/"False", since quotation marks always win.
  - skill_id: interprets_true_false_as_program_state
    description: Reads a boolean variable as a fact about current program state, and recognizes that reassigning it (False to True) is how a program remembers something happened.
  - skill_id: selects_boolean_for_two_state_information
    description: Selects a boolean for information with exactly two possible states (locked/unlocked, on/off), as opposed to an integer, string, or float.
---

# 2.5 Booleans

**Backfilled documentation, written 2026-09-09 against the lesson's real deployed content** -- the Instruction page (`01_instruction.html`) and Coding Exercise (`coding-exercise/GMETRIX-114-boolean.py`) were already live on the real `foxcs-python` Moodle course before this record existed (built to the sandbox 2026-09-08, promoted to the real course 2026-09-09: Instruction cmid=262, Coding Exercise cmid=267). This file exists to document that real content, matching the structural pattern `../lesson_02_02_integers/lesson_02_02_integers.md` established. See `../../../../../worklog.md` for the Unit 02 build session this lesson is part of, and `../../../course-plan.md`'s Unit 02 section for the standing checklist.

## Overview

Fifth of five data-type lessons (2.2-2.6), each covering one Python type in depth. This lesson covers booleans: recognizing them, writing `True`/`False` with the exact casing Python requires, telling a real boolean apart from a string that looks like one, reading a boolean as real program state, and choosing a boolean on purpose for anything with exactly two possible states.

## Objectives

- Recognize a value written as a boolean (exactly `True` or `False`, capitalized, no quotation marks).
- Write `True`/`False` with the exact casing Python requires, and predict that other casings (`true`, `TRUE`) crash with a `NameError`, since Python reads them as an undefined variable name rather than a keyword.
- Distinguish the real boolean `True`/`False` from a string that happens to say `"True"`/`"False"`, since quotation marks always win over what a word looks like.
- Read a boolean variable as a fact about the program's current state, and recognize that reassigning it (from `False` to `True`) is how a program remembers that something just happened.
- Choose a boolean on purpose for information with exactly two possible states (locked/unlocked, on/off), as opposed to an integer, string, or float.

## Prerequisites

- 2.2 Integers (`../lesson_02_02_integers/`) -- recognizing integers, choosing an integer for a countable quantity (contrasted here with a two-state boolean).
- 2.3 Floats (`../lesson_02_03_floats/`) -- recognizing floats, choosing a float for a decimal quantity (contrasted here with a two-state boolean).
- 2.4 Strings (`../lesson_02_04_strings/`) -- recognizing strings, understanding that quotation marks decide type regardless of appearance, which this lesson directly reuses for the boolean-looking-string case.

## Vocabulary

- boolean
- `True` / `False`
- program state

---

## Moodle Content (5-module structure)

### Instruction (`01_instruction.html`)

Single self-contained page, same Watch First -> Learn -> Key Terms -> Practice shape and same Skulpt-checked drill engine as 2.1-2.4. 5 real adaptive skill nodes (one per skill above), each with a core item (Build-the-Code or Multiple Choice), a reinforce item, and an extend item. No spiral review or Game/UX reflection items this lesson, matching the established pattern.

**Scope note:** node 2 (`applies_boolean_casing`) is explicit that Python's booleans are the one common exception to Python's otherwise-lowercase keywords -- the Learn section states it directly: "This is different from most other Python keywords, which are lowercase. Booleans are the exception." The reinforce item for this node predicts a real `NameError` from `sound_enabled = true` (lowercase), not a vague "it doesn't work."

**Node summary, from the live page:**
1. `identifies_boolean_type` -- core: fill in `game_paused = True`, checked against `Game Paused: True`. reinforce: MC, which of `True`/`"True"`/`1`/`true` is a boolean (correct: `True`). extend: fill in `print(type(door_locked))` against `door_locked = False`, expects `<class 'bool'>`.
2. `applies_boolean_casing` -- core: MC, which of `is_alive = True`/`is_alive = true`/`is_alive = TRUE` is valid Python (correct: `True`). reinforce: MC, what actually happens when `sound_enabled = true` (lowercase) runs (correct: crashes -- Python looks for a variable named `true`, which doesn't exist). extend: fill in `sound_enabled = True` against `Sound Enabled: True`.
3. `distinguishes_boolean_from_string` -- core: `quest_complete = True` exists, fill in `print(type(quest_complete))`, expects `<class 'bool'>`. reinforce: MC, `"True"` is written with quotation marks -- what type is it (correct: string). extend: `status = "True"` exists, fill in `print(type(status))`, expects `<class 'str'>`.
4. `interprets_true_false_as_program_state` -- core: fill in `assignment_submitted = False`, checked against `Assignment Submitted: False`. reinforce: MC, `game_over` holds `False` -- what does that tell you about current state (correct: the game has not ended). extend: `level_complete = False` exists (level just finished), fill in `level_complete = True` against `Level Complete: True`.
5. `selects_boolean_for_two_state_information` -- core: MC, which of (door locked / score / player name / exact game speed 1.5) should be a boolean (correct: door locked). reinforce: MC, which of (coins collected / sound enabled / username) has exactly two states (correct: sound enabled). extend: fill in `is_alive = True` against `Is Alive: True`.

Full item-by-item detail, including live wording and feedback text, is in `teacher-materials/practice_question_bank.md`.

### Video

**"Python Booleans || Python Tutorial || Learn Python Programming"** by Socratica, embedded at the top of the Instruction page. **Length confirmed: 4:39** (Jay-confirmed 2026-09-08, used as-is) -- the only one of 02.2-02.4's videos with an independently confirmed runtime. Per `../../../video-resources.md`.

### Coding Exercise (`coding-exercise/GMETRIX-114-boolean.py`)

Live as a native Moodle Assignment (cmid=267), file-only `.py` submission, matching 2.2-2.4's Coding Exercise settings. The real starter file (Workbook p.11, bool half, GMetrix Domain 1 Lesson 2 Objective 1.1.4) deliberately keeps the licensed source's real bug in place: line 1 reads `char_life = true` (lowercase). The exercise's numbered steps have students: (1) run the file exactly as-is and read the real `NameError` Python raises, (2) fix line 1 so `char_life` is a real Python boolean, then re-run to confirm it prints "you are still in the game", (3) fill in a closing blank naming the casing rule Python requires for boolean values. This is a deliberate build choice, not an oversight -- running the buggy code first and reading the real error is what teaches `applies_boolean_casing` experientially, rather than just stating the casing rule. Save-as convention follows the workbook's own instruction: `GMETRIX-114-boolean-completed.py` (hyphen before "completed").

### Project, Mastery Check, Feedback

**Project:** Not built for this lesson. Per-lesson Projects aren't the standing pattern for 02.2 onward -- 02.1's own Project was Unit 02's pilot-proof pass, not a per-lesson template carried forward.

**Mastery Check:** being built separately, see `teacher-materials/mastery_check_key.md` once available.

**Feedback:** resolved 2026-09-09 -- one combined Feedback activity covering 02.2-02.5 together, planned to be built once 02.6 lands, not a per-lesson activity for this lesson individually. Since 02.5 is the last lesson in that combined group, the combined activity effectively closes out this lesson's own feedback loop once built.

## Next Steps

- Not yet reviewed by Jay.
- Video length is the one already-confirmed exception among 02.2-02.5 (4:39, Jay-confirmed) -- no open item here, unlike the other three lessons in this backfill.
- Project/Mastery-Check-as-unit-level is no longer the plan as of 2026-09-09 -- per-lesson Mastery Checks are now the standard (being built in parallel to this backfill) and there is no unit-level cumulative Mastery Check. The Unit Project instead carries cross-lesson synthesis, per `../../../../../02-authoring-system/mastery-check-standards.md`.
