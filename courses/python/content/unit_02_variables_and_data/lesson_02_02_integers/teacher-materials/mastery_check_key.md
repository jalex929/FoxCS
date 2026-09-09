# 2.2 Mastery Check Answer Key

Built 2026-09-09, as part of reinstating per-lesson Mastery Checks as the standard for Unit 02 (reversing the 2026-09-08 unit-level-only scoping -- see `../../../../../decisions-log.md`'s 2026-09-09 entry). 4 items, native Moodle quiz (shortanswer + multichoice, deterministic auto-grading per `mastery-check-standards.md`'s "prefer deterministic validation" rule). 3 attempts, averaged. DOK 2-3, each item synthesizes 2+ of this lesson's 5 skill nodes rather than repeating a Practice item verbatim.

**Scope boundary, deliberate:** no item requires `str()`/`int()` conversion syntax. 02.2's own Instruction scope note says conversion is Lesson 2.6's job -- testing it here would be testing something not yet taught, violating Backwards Design's own premise that the Mastery Check should test what the lesson actually covered.

## Item 1 (shortanswer) — precedence in a countable-quantity context

**Prompt:**
```
score = 4
score = score + 3 * 2
print("Score:", score)
```
What does this print?

**Accepted answer:** `Score: 10`

**Targets:** `predicts_basic_integer_arithmetic` (multiplication before addition), `uses_integer_for_countable_quantity`

## Item 2 (shortanswer) — negative integer via subtraction

**Prompt:**
```
health = 8
health = health - 20
print("Health:", health)
```
What does this print?

**Accepted answer:** `Health: -12`

**Targets:** `recognizes_negative_integer`, `predicts_basic_integer_arithmetic`, `uses_integer_for_countable_quantity`

## Item 3 (multichoice) — identify the real integer

**Prompt:** Which of these is a real integer, not just something that looks like one?

- A) `"9"` -- wrong, quoted (string)
- B) `9.0` -- wrong, decimal point (float)
- C) `-9` -- **correct**
- D) `True` -- wrong, boolean

**Targets:** `identifies_integer_type`

## Item 4 (multichoice) — predict the TypeError

**Prompt:**
```
tries = "5"
print(tries + 2)
```
What happens when this runs?

- A) prints `7` -- wrong, `tries` is a string, this isn't math
- B) prints `"52"` -- wrong, that's what `*` would do, not `+`
- C) crashes with a TypeError -- **correct**
- D) prints `5` -- wrong, the `+2` doesn't just vanish

**Targets:** `distinguishes_integer_from_string`

## Grading Notes

All 4 items are auto-graded natively by Moodle (shortanswer exact/normalized match, multichoice). No manual grading pass needed. Grade set to 10 points per `feedback_lesson_point_scale.md`'s standing scale. Password: `Papaya82%`. Live cmid/quizid: see `worklog.md`'s matching 2026-09-09 entry once deployed. Not yet reviewed by Jay.
