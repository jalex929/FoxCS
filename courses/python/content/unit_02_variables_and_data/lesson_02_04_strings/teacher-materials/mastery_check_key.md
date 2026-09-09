# 2.4 Mastery Check Answer Key

Built 2026-09-09, as part of retrofitting per-lesson Mastery Checks onto Unit 02 (`course-plan.md`'s "Mastery Check not yet built" flag, added the same day per `decisions-log.md`'s 2026-09-09 entry reinstating the per-lesson standard). 4 items, native Moodle quiz (shortanswer + multichoice, deterministic auto-grading per `mastery-check-standards.md`'s "prefer deterministic validation" rule). 3 attempts, averaged. DOK 2-3, each item synthesizes 2+ of this lesson's 5 skill nodes rather than repeating a Practice item verbatim. Scenarios (quest item name, ticket number, save-file flag) are deliberately different from both 02.4's own live Practice items (player_name/Rowan, room/kitchen, id_code/100, count="5", status/door_locked "True"/"False", location/cave, zip_code) and from 02.1/02.2/02.3's Mastery Check scenarios.

**Scope boundary, deliberate:** no item requires string indexing or string methods -- 02.4's Instruction content stops at `+` concatenation between two strings; indexing is scoped to Unit 08 per `course-plan.md`, so testing it here would be testing something not yet taught anywhere in the course.

## Item 1 (shortanswer) -- variable vs. quoted word

**Prompt:** `item_name = "Silver Key"` already exists. What does this print?
```
print("item_name")
```

**Accepted answer:** `item_name`

**Targets:** `distinguishes_string_from_variable`, `recognizes_quotes_override_appearance`

## Item 2 (shortanswer) -- fix the missing quotes on a numeric-looking string

**Prompt:** A player's ticket number will never be used in math, so it should be stored as text. This line is supposed to store ticket number 4521 as a string, but it's missing something:
```
ticket_number = 4521
```
Write the corrected line.

**Accepted answers:** `ticket_number = "4521"`, `ticket_number="4521"`

**Targets:** `recognizes_numeric_looking_string`, `recognizes_quotes_override_appearance`

## Item 3 (multichoice) -- identify the real string

**Prompt:** Which of these is a real Python string?

- A) `200` -- wrong, no quotes (integer)
- B) `"200"` -- **correct**
- C) `200.0` -- wrong, decimal point and no quotes (float)
- D) `True` -- wrong, boolean

**Targets:** `identifies_string_type`, `recognizes_numeric_looking_string`

## Item 4 (multichoice) -- boolean-looking string from a save file

**Prompt:** A save file stores a variable this way:
```
unlocked = "True"
```
What type is `unlocked`?

- A) Boolean -- wrong, the quotation marks rule this out
- B) String -- **correct**
- C) Integer -- wrong, not made of digits, and quotes would rule it out anyway
- D) It depends on how it's used later in the program -- wrong, type is decided by how a value is written, not by later use

**Targets:** `identifies_string_type`, `recognizes_boolean_looking_string`

## Grading Notes

All 4 items are auto-graded natively by Moodle (shortanswer exact/normalized match, multichoice). No manual grading pass needed. Grade set to 10 points per `feedback_lesson_point_scale.md`'s standing scale. Password: `Guava91&`. Live cmid=272, quizid=15, deployed 2026-09-09 via `07-infrastructure/moodle-scripts/build-lesson-02-04-mastery-check.php`. Module order verified: sits after 02.4's Coding Exercise (cmid=266) and before 02.5's Instruction (cmid=262) -- see `07-infrastructure/moodle-scripts/reorder-unit02-section-2026-09-09-d.php`. Not yet reviewed by Jay.
