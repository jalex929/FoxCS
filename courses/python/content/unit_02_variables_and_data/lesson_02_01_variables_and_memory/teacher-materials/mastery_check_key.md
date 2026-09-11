# 2.1 Mastery Check Answer Key

**Live status, 2026-09-09:** promoted from the sandbox pilot (course id=9, quizid=11, cmid=240) to the real `foxcs-python` course -- same 4 questions and answer variants, transcribed exactly, not rewritten. Live cmid=269, quizid=12, section 3 (Unit 02), positioned right after 02.1 Project (248) in the module sequence. Grade set to 10 points per `feedback_lesson_point_scale.md`'s standing scale (the sandbox pilot and Unit 01's live Mastery Checks used a 100-point convention that predates this rule). Password: `Mango47$`. Deployed as part of reinstating per-lesson Mastery Checks as the standard for Unit 02 -- see `decisions-log.md`'s 2026-09-09 entry. Not yet reviewed by Jay on the real course.

4 items, native Moodle quiz (shortanswer + multichoice, deterministic auto-grading per `mastery-check-standards.md`'s "prefer deterministic validation" rule). 3 attempts, averaged. DOK 2-3, each item synthesizes across more than one of this lesson's 4 skill nodes rather than repeating a single Practice item verbatim.

## Item 1 (shortanswer) — predicts output of a reassignment

**Prompt:**
```
score = 0
score = 15
print("Score:", score)
```
What does this program print?

**Accepted answers (case-sensitive on the label text, exact spacing):** `Score: 15`

**Targets:** `reassigns_variable`, `prints_variable_with_text`

## Item 2 (shortanswer) — fixes a broken assignment line

**Prompt:** This line is supposed to create a variable named `lives` set to `3`, but it has a mistake: `3 = lives`. Write the corrected line.

**Accepted answers:** `lives = 3` (accept with or without surrounding whitespace; reject anything with the sides reversed or a different operator)

**Targets:** `creates_variable`

## Item 3 (multichoice) — valid naming, single correct answer

**Prompt:** Which of these variable names is valid in Python?

- A) `1st_place`
- B) `player class`
- C) `player_class` (correct)
- D) `def`

**Why each wrong option is wrong:** A starts with a digit. B contains a space. D is a reserved Python word.

**Targets:** `variable_naming_rules`

## Item 4 (shortanswer) — fixes a concatenation TypeError

**Updated 2026-09-04, post-02.1-review:** reworked from a comma-only print-prediction item, per the decision that 02.1's printing skill now covers both `+` and comma concatenation and Mastery Check should test the distinction, not commas alone. Uses `total` as the variable name (not `score`, which Practice's own items already use) so this is a real synthesis check, not a verbatim repeat of a Practice item. Verified live 2026-09-04 via a real quiz attempt as `foxcstest`: graded fraction 1.0 (`mdl_question_attempt_steps`, question id 107).

**Prompt:**
```
total = 12
print("Total: " + total)
```
This line is supposed to print `Total: 12`, using `+`, but it crashes. Write the corrected line.

**Accepted answers:** `print("Total: " + str(total))`, `print("Total: "+str(total))` (accept with or without the space around `+`; reject any version that doesn't wrap `total` in `str(...)`, and reject a comma-based rewrite — the item is specifically testing whether the student can fix `+`, not whether they know an alternative exists)

**Targets:** `concatenates_with_plus`, `creates_variable`

## Grading Notes

All 4 items are auto-graded by Moodle's native question engine (shortanswer exact/normalized match, multichoice). No manual grading pass is needed for this Mastery Check specifically, unlike lessons that lean on essay questions. If a student's shortanswer response is a near-miss (extra whitespace, a trailing period), Moodle's normalized matching should already accept it; if a real pattern of near-misses shows up in practice, add the variant to the accepted-answers list in the quiz's question bank rather than manually re-grading each occurrence.
