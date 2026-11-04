# Assessing "why" comments: how correct is the student's reasoning?

**Added 2026-11-04, per Jay:** "Let's come up with more guidance then for how to assess to what extent students are correct when giving the why in their comment."

Some Coding Exercises ask students to explain *why* in a comment, in their own words: why a line exists (01.5), or why a message is worded the way it is (01.4). Output checks can't see any of this, and there's no single right sentence. This rubric is how a reviewer, human or AI, decides how correct each of those comments is. A lesson's own rubric file links here and says which comments count.

## First: does the comment have an expected answer?

**Most Coding Exercise questions do, and they are marked right or wrong against the key, not on this scale** (per Jay, 2026-11-04). Examples:

- a fill-in-the-blank (02.2's "strings / text", 02.5's "Title casing");
- a type prediction (the Unit 02 Checkpoint);
- naming which mistake a fix corrected (01.6);
- a short "why does this error happen" with one known cause (02.4's apostrophe).

For those, **accept close paraphrases and any English** ("What not to grade" below still applies), and mark them right or wrong. Use the leveled scale only when the student is asked to give *their own* reasoning and several different answers could all be right.

## Score each comment on one scale

Judge every required comment on its own, then combine them (see "From comments to a grade" below).

| Level | Name | What it looks like | Example (above `print("Time remaining: 02:45")`) |
|---|---|---|---|
| 3 | **Accurate reason** | A real reason that is true of *this* line in *this* program: who it's for, what it lets them do, or what goes wrong without it | `# shows how long the player has left so they can decide whether to rush` |
| 2 | **Reason, but vague or partly off** | It points at a purpose, but it's generic enough to fit almost any line, or it's mostly right with one inaccuracy | `# so the player knows stuff` / `# tells the player the time` (true, but it's the what, not the why) |
| 1 | **Restates the code** | It describes what the line does, in other words, with no reason | `# prints the time remaining` / `# print statement` |
| 0 | **Missing, wrong, or about something else** | No comment, a comment that contradicts what the line does, or one that describes a different line | `# saves the player's score` / `# this line asks for input` |

A level 2 that is *accurate but generic* and a level 2 that is *specific but slightly wrong* are both "partly correct." Say which one in the feedback, because the next step is different.

## Four questions that decide the level

Ask them in order. The first "no" sets the ceiling.

1. **Is there a comment, and is it about this line?** No: level 0. A comment one line off (describing the line below) counts as about a different line.
2. **Is it true?** Check it against what the line actually does when the program runs. A claim the code doesn't support (it says "warns the player" above a line that prints the level) is level 0, however well written.
3. **Is it a reason, not a description?** Use the **deletion test**: if this line were deleted, would the comment explain what the program loses? "Prints the time" doesn't. "So they can decide whether to rush" does. A description only is level 1.
4. **Is it specific to this program?** Use the **swap test**: could this exact comment sit above any other line and still fit? "So the user knows" fits everywhere, so it's level 2. A reason tied to this line's job in this program is level 3.

## What not to grade

- **English.** Many FoxCS students are English Language Learners. Grade the idea, not the grammar, spelling, or vocabulary. `# so player see time and go faster if almost done` is level 3. This follows the 2026-09-13 ELL decision for Unit 01 essays.
- **Length.** A short comment with a true, specific reason beats a long one that restates the code. Never reward word count.
- **One right answer.** Different reasons can all be true of the same line. `# builds tension before the warning` and `# so they can plan their moves` are both level 3 for the timer line. If it's true, a reason, and specific, it scores, even if it isn't the reason you had in mind.
- **Style choices** the exercise didn't ask about, like comment placement (above vs. beside) when the exercise only asks that each line has one.

## Where this scale applies

| Exercise | Comment | How it's marked |
|---|---|---|
| 01.4 Status board | Why one message is worded that way (Tier 1/2 bonus) | **This scale.** Level 3 names the usability idea from the lesson: specific and readable for a player, not a code like `ERR_02` |
| 01.5 Comments that explain why | Why each `print()` exists | **This scale**, every line, using the four questions above |
| 01.6 Fix the Big Four | Which mistake each fix corrected | **Expected answer** per line: one of the four (missing quote, missing parentheses, wrong capitalization, missing quotes entirely) |
| Unit 02 Checkpoint | Each value's type | **Expected answer** per value |
| 02.2 to 02.6 | Fill-in blanks and short answers | **Expected answer**, per each lesson's rubric |

## From comments to a grade

Comments feed the **correct** half of the Coding Exercise score (`02-authoring-system/coding-exercise-standards.md`: 50% runs, 50% correct). "Runs" stays a fact from the program run.

- **Average the levels** of the required comments, then take the band at or below the average:

  | Average level | Correct half earns |
  |---|---|
  | 3.0 | 100% |
  | 2.5 to 2.9 | 85% |
  | 2.0 to 2.4 | 70% |
  | 1.5 to 1.9 | 55% |
  | 1.0 to 1.4 | 40% |
  | above 0, below 1.0 | 20% |
  | 0 (no required comment attempted) | 0% |

- **Best fit, not perfection** (`feedback-and-grading-spec.md`). One weaker comment shouldn't cost a whole band when it's *vague* rather than *wrong*. If every comment below level 3 is a level 2 of the generic kind, move up one band. Example: three 3s and one generic 2 average 2.75, which would be 85%, so it earns 100%. A 2 that is partly wrong gets no bump.
- **A wrong comment (level 0) on an otherwise strong submission** costs that comment only. Don't let one false claim sink the rest.
- **Bonus tiers (XP) are separate.** They never change the 10-point grade, and an unapproved bonus is still never applied (`release_check.py` blocks it).

## Feedback by level

Feedback names the line, quotes the comment, and gives one concrete next step. Never "good job" alone.

- **Level 3:** say what made it a reason. "Your comment on the timer line says what the player *does* with that information. That's exactly the why."
- **Level 2 (generic):** a frame to make it specific. "'So the player knows' fits any line. Try: 'so the player can ___ before ___.'"
- **Level 2 (partly off):** point at the one inaccuracy. "This line shows the level, not the score. What does knowing the level help the player do?"
- **Level 1:** the deletion test, as a question. "If this line were gone, what would the player miss? Write that."
- **Level 0:** what the line really does, then the question. "This line prints the time remaining, it doesn't save anything. Why would a player want to see the time?"

For students who mostly land at level 1, give sentence starters (the 2026-09-13 scaffolding rule): "This line is here so that…", "Without this, the player wouldn't…", "This helps the player decide…".

## For the AI reviewer

The review worker sends judgment cases to Claude with the exercise rubric. When a rubric criterion points at this document, the reviewer must:

1. **Score each required comment separately.** Quote it in `evidence` exactly as written, with its level and which question set the level. The release check blocks any quote that isn't in the submission.
2. **Never infer a comment that isn't there.** A missing comment is level 0. Not "probably meant to."
3. **Don't penalize English.** If the meaning is clear, score the meaning.
4. **Hold for the teacher** (`teacherReviewRequired`, with the reason) when the meaning genuinely can't be read, a comment could be true under a reasonable reading of the program, or most comments sit on a level boundary.
5. **Use the mapping above** for the correct half, and say in `rationale` which comments set it.

## Not yet done

- Calibration: score a real batch by hand (Jay) and by the reviewer, and compare level by level. The eval harness in `portfolio-showcase/evals/` can hold synthetic cases for this, but the thresholds above are a first draft until real comments have been through it.
