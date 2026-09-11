# 2.5 Mastery Check Answer Key

Built 2026-09-09, as part of retrofitting per-lesson Mastery Checks onto Unit 02 (`course-plan.md`'s "Mastery Check not yet built" flag, added the same day per `decisions-log.md`'s 2026-09-09 entry reinstating the per-lesson standard). 4 items, native Moodle quiz (shortanswer + multichoice, deterministic auto-grading per `mastery-check-standards.md`'s "prefer deterministic validation" rule). 3 attempts, averaged. DOK 2-3, each item synthesizes 2+ of this lesson's 5 skill nodes rather than repeating a Practice item verbatim. Scenarios (boss defeated, save-slot full, email verified) are deliberately different from both 02.5's own live Practice items (game_paused, is_alive, door_locked, sound_enabled, assignment_submitted, level_complete, quest_complete, game_over) and from 02.1/02.2/02.3/02.4's Mastery Check scenarios.

**Scope boundary, deliberate:** no item uses comparison operators (`==`, `!=`) or conditional logic (`if`/`else`) -- 02.5's Instruction content stops at plain `True`/`False` assignment and reassignment; conditionals are a later unit, so testing them here would be testing something not yet taught.

## Item 1 (shortanswer) -- fix the boolean casing

**Prompt:** This line is supposed to create a boolean named `boss_defeated` set to `False`, but it has a mistake:
```
boss_defeated = false
```
Write the corrected line.

**Accepted answers:** `boss_defeated = False`, `boss_defeated=False`

**Targets:** `applies_boolean_casing`, `identifies_boolean_type`

## Item 2 (shortanswer) -- fix the string-disguised boolean

**Prompt:** This line is supposed to set `save_slot_full` to the real Python boolean `True`, but it has two mistakes:
```
save_slot_full = "true"
```
Write the corrected line.

**Accepted answers:** `save_slot_full = True`, `save_slot_full=True`

**Targets:** `distinguishes_boolean_from_string` (drop the quotes), `applies_boolean_casing` (capitalize correctly) -- both mistakes must be fixed together

## Item 3 (multichoice) -- write the real boolean correctly

**Prompt:** A variable `email_verified` needs to hold the real Python boolean value `False`. Which of these is written correctly?

- A) `email_verified = False` -- **correct**
- B) `email_verified = "False"` -- wrong, quotes make it a string
- C) `email_verified = FALSE` -- wrong, incorrect casing
- D) `email_verified = 0` -- wrong, that's an integer

**Targets:** `identifies_boolean_type`, `applies_boolean_casing`, `distinguishes_boolean_from_string`

## Item 4 (multichoice) -- choose a boolean on purpose

**Prompt:** A game needs to track several things about a boss fight. Which of these should be stored as a boolean?

- A) whether the player has beaten the final boss -- **correct**
- B) the number of enemies defeated -- wrong, that's a count (integer)
- C) the name of the current level -- wrong, that's text (string)
- D) the exact time remaining (45.2 seconds) -- wrong, that needs decimal precision (float)

**Targets:** `selects_boolean_for_two_state_information`, `interprets_true_false_as_program_state`

## Grading Notes

All 4 items are auto-graded natively by Moodle (shortanswer exact/normalized match, multichoice). No manual grading pass needed. Grade set to 10 points per `feedback_lesson_point_scale.md`'s standing scale. Password: `Lychee58!`. Live cmid=273, quizid=16, deployed 2026-09-09 via `07-infrastructure/moodle-scripts/build-lesson-02-05-mastery-check.php`. Module order verified: sits after 02.5's Coding Exercise (cmid=267) and before the Unit 02 Mixed Data-Type Checkpoint (cmid=268) -- see `07-infrastructure/moodle-scripts/reorder-unit02-section-2026-09-09-e.php`. Not yet reviewed by Jay.
