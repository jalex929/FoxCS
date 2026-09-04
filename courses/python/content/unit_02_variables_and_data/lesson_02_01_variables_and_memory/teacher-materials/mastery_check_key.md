# 2.1 Mastery Check Answer Key

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

## Item 4 (shortanswer) — predicts output of a multi-piece print

**Prompt:**
```
player = "Nia"
room = "the vault"
print(player, "entered", room)
```
What does this program print?

**Accepted answers:** `Nia entered the vault`

**Targets:** `prints_variable_with_text`, `creates_variable`

## Grading Notes

All 4 items are auto-graded by Moodle's native question engine (shortanswer exact/normalized match, multichoice). No manual grading pass is needed for this Mastery Check specifically, unlike lessons that lean on essay questions. If a student's shortanswer response is a near-miss (extra whitespace, a trailing period), Moodle's normalized matching should already accept it; if a real pattern of near-misses shows up in practice, add the variant to the accepted-answers list in the quiz's question bank rather than manually re-grading each occurrence.
