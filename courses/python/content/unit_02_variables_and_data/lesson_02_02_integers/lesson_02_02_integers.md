---
lesson_id: lesson_02_02_integers
unit_id: unit_02
lesson_number: "02.2"
title: Integers
dok_levels_covered: [1, 2, 3]
skills:
  - skill_id: identifies_integer_type
    description: Recognizes whole-number integer values (plain digits, no quotes, no decimal point).
  - skill_id: distinguishes_integer_from_string
    description: Distinguishes 5 from "5", including predicting that + will raise a TypeError when mixing a string that looks numeric with a real integer.
  - skill_id: recognizes_negative_integer
    description: Recognizes negative whole numbers as integers, and predicts arithmetic that crosses zero.
  - skill_id: uses_integer_for_countable_quantity
    description: Selects an integer for quantities that are counted one at a time (lives, arrows, gold), as opposed to text, booleans, or decimal measurements.
  - skill_id: predicts_basic_integer_arithmetic
    description: Predicts results of +, -, and * on integers, including operator precedence (multiplication before addition).
---

# 2.2 Integers

Sandbox prototype, built 2026-09-08 against `skills-map.md`'s "02.2 Integers" section, as part of finishing out the rest of Unit 02 (02.1 Variables and Memory is already live). Deployed to the sandbox course (`sandbox-adaptive-demo`, course id 9), not any real course. See `../../../../decisions-log.md` and `../../../../worklog.md` for the Unit 02 build session this lesson is part of.

## Overview

First of five data-type lessons (2.2-2.6), each covering one Python type in depth. This lesson covers integers: recognizing them, telling them apart from numbers written as text (a common source of real bugs), recognizing negative integers, choosing integers for countable game-state quantities, and predicting basic integer arithmetic including operator precedence.

## Objectives

- Recognize a value written as an integer (plain digits, no quotes, no decimal point).
- Distinguish an integer like `10` from a string that looks like a number, like `"10"`, and predict that combining the two with `+` raises a `TypeError`.
- Recognize negative integers and predict simple arithmetic that crosses zero.
- Choose an integer for a quantity that is counted one at a time (lives, arrows, gold), as opposed to text, a boolean, or a decimal measurement.
- Predict the result of `+`, `-`, and `*` on integers, including that multiplication happens before addition without parentheses.

## Prerequisites

- 2.1 Variables and Memory (`../lesson_02_01_variables_and_memory/`) — creating and reassigning variables, printing a variable with text.

## Vocabulary

- integer
- negative integer
- `type()`

---

## Moodle Content (5-module structure)

### Instruction (`01_instruction.html`)

Single self-contained page, same Learn -> Key Terms -> Practice shape and same Skulpt-checked drill engine as 2.1. 5 real adaptive skill nodes (one per skill above), each with a Skulpt-checked Build-the-Code core item, a multiple-choice reinforce item, and a harder Build-the-Code (or, for skills 2.2's node 2, a predict-the-error multiple-choice) extend item. No spiral review or Game/UX reflection items this lesson — those return once more of Unit 02's own content exists to spiral back to.

**Scope note:** node 2 (`distinguishes_integer_from_string`) deliberately does NOT teach `str()`/`int()` conversion — that's Lesson 2.6's job. The reinforce item predicts the `TypeError` from mixing a string and an int with `+`, and explicitly tells students the fix is coming in 2.6, rather than teaching it early.

### Project, Coding Exercise, Mastery Check, Feedback

**Not built for this lesson**, matching skills-map.md's structure: Unit 02 has ONE cumulative Mastery Check and ONE Project at the unit level (after 2.7), not a per-lesson Mastery Check/Project the way 2.1 got (2.1's own Project was Unit 02's pilot-proof pass, not the standing per-lesson pattern for 2.2 onward). A per-lesson Feedback activity was skipped this pass for time — flag to Jay whether every data-type lesson should still get its own light Feedback activity like 01.4-01.6/02.1 did, or whether one combined Feedback at the end of the data-type run (after 2.6) is enough.

## Next Steps

- Deploy to sandbox via `create-sandbox-unit02-02-integers-instruction.php` (copied from 02.1's deploy script pattern).
- Not yet reviewed by Jay.
- Video length for the Corey Schafer video (assigned in `video-resources.md`) is not yet independently confirmed — check before this goes live in any real course.
