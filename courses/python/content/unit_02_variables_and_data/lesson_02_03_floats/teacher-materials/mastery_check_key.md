# 2.3 Mastery Check Answer Key

Built 2026-09-09, as part of retrofitting per-lesson Mastery Checks onto Unit 02 (`course-plan.md`'s "Mastery Check not yet built" flag, added the same day per `decisions-log.md`'s 2026-09-09 entry reinstating the per-lesson standard). 4 items, native Moodle quiz (shortanswer + multichoice, deterministic auto-grading per `mastery-check-standards.md`'s "prefer deterministic validation" rule). 3 attempts, averaged. DOK 2-3, each item synthesizes 2+ of this lesson's 5 skill nodes rather than repeating a Practice item verbatim. Scenarios (potion strength, character weight, fuel gauge, coin multiplier) are deliberately different from both 02.3's own live Practice items (game_speed, price/tax, lives/bonus, base) and from 02.1/02.2's Mastery Check scenarios (score, health, tries).

**Scope boundary, deliberate:** no item requires `str()`/`int()` conversion syntax -- 02.3's Instruction content never introduces it (conversion is Lesson 2.6's job), so testing it here would violate Backwards Design's own premise that the Mastery Check should test what the lesson actually covered.

## Item 1 (shortanswer) -- predict a mixed-type potion effect

**Prompt:**
```
potion_strength = 2
bonus = 0.75
print("Strength:", potion_strength + bonus)
```
What does this print?

**Accepted answer:** `Strength: 2.75`

**Targets:** `predicts_mixed_numeric_result` (int + float arithmetic), `uses_float_for_decimal_quantity`

## Item 2 (shortanswer) -- fix the disguised-whole-number weight

**Prompt:** A character sheet stores every measurement as a float, even exact whole numbers. This line is supposed to store a character's weight as 180 pounds, using a float, but it's written as an integer:
```
weight = 180
```
Write the corrected line.

**Accepted answers:** `weight = 180.0`, `weight=180.0`

**Targets:** `recognizes_float_disguised_as_whole`, `distinguishes_int_vs_float`

## Item 3 (multichoice) -- identify the real float

**Prompt:** A vehicle's `fuel_level` should be a float. Which of these values is actually a float, not just something that looks like one?

- A) `3` -- wrong, no decimal point (integer)
- B) `3.0` -- **correct**
- C) `"3.0"` -- wrong, quoted (string)
- D) `False` -- wrong, boolean

**Targets:** `identifies_float_type`, `recognizes_float_disguised_as_whole` (3.0 is a whole-number value written as a float)

## Item 4 (multichoice) -- predict the mixed-type multiplier result

**Prompt:** `coins = 12` and `multiplier = 1.5` already exist. What does this print?
```
print(coins * multiplier)
```
- A) prints `18` -- wrong, mixing int and float produces a float
- B) prints `18.0` -- **correct**
- C) prints `"18.0"` -- wrong, neither value is a string
- D) crashes -- wrong, this combination never crashes

**Targets:** `uses_float_for_decimal_quantity`, `predicts_mixed_numeric_result`

## Grading Notes

All 4 items are auto-graded natively by Moodle (shortanswer exact/normalized match, multichoice). No manual grading pass needed. Grade set to 10 points per `feedback_lesson_point_scale.md`'s standing scale. Password: `Kiwi63#`. Live cmid=271, quizid=14, deployed 2026-09-09 via `07-infrastructure/moodle-scripts/build-lesson-02-03-mastery-check.php`. Module order verified: sits after 02.3's Coding Exercise (cmid=265) and before 02.4's Instruction (cmid=261) -- see `07-infrastructure/moodle-scripts/reorder-unit02-section-2026-09-09-c.php`. Not yet reviewed by Jay.
