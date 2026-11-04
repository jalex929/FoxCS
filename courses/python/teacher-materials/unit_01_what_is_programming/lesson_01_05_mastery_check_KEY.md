# 01.5 Mastery Check: Comments and Documentation: rubric and answer key

**Never include this file in anything students can see.** Rewritten 2026-11-04 from the live quiz's own build script, so each item below is exactly what students are given. Replaces the earlier narrative key, which described questions the live quiz no longer asks.

**Live structure:** `build-lesson-01-05-mastery-check.php`. A pool of 10 essay tasks. Hand-graded. Items 2, 7 and 10 ask for a "why" comment: judge those with the leveled scale in `05-grader/comment-reasoning-rubric.md` (level 3 = 100%, level 2 = 90%, level 1 = 85%, a genuine attempt = 80%).

## How every task is scored

The live Mastery Check is two questions: the **academic integrity acknowledgment** (always first; full credit for acknowledging it) and **one task drawn at random** from the pool below. Students get 3 attempts, and the attempts are averaged.

Unit 01 written answers use Jay's Sept 13 scale (`decisions-log.md`, 2026-09-13), because many students are English Language Learners and a real attempt shouldn't score 0:

| Score | The answer |
|---|---|
| 100% | Has every **Full credit needs** element for its task, stated clearly |
| 95% | Has every element, with one imprecise word or small slip |
| 90% | Gets the central idea right, but one required element is missing |
| 85% | A real attempt with one element right |
| 80% | A genuine attempt that restates the question or is mostly incorrect (the floor for any real attempt) |
| 0% | Blank, off-topic, or not a real attempt |

- **Grade the idea, not the English.** Spelling, grammar and word choice never cost a tier (`05-grader/comment-reasoning-rubric.md`, "What not to grade").
- **Expected answers are right or wrong.** Where a task has one (an output, a mistake's name, a term), mark it against the key and accept close paraphrases.
- **Every response gets feedback.** An 80-85% response gets a sentence starter specific to its task, never just "try again".

## Item 1

**Task:** Predict exactly what displays: `# Show the player's current level`, `print("Level 5")`, `# print("Level 6 - not unlocked yet")`, `print("Keep going!")`

**Full credit needs:**
- [ ] **Expected output:** `Level 5` then `Keep going!`
- [ ] Nothing from the commented lines appears

**Drops a tier:** includes `Level 6` or a comment's text.

**Watch for:** Thinking a commented-out `print` still runs.

## Item 2

**Task:** Rewrite the weak comment `# print the message` (above `print("Game paused")`) so it explains WHY the line exists.

**Full credit needs:**
- [ ] A comment giving a real reason (`# let the player know the game is waiting for them`), not a restatement
- [ ] Level 3 on the comment-reasoning scale

**Drops a tier:** a level 2 (vague) or level 1 (restates the code) comment.

**Sentence starter (80-85%):** "# so the player knows ___"

## Item 3

**Task:** A classmate says comments are a waste of time because Python ignores them. Agree or disagree? Explain.

**Full credit needs:**
- [ ] Disagrees
- [ ] Python does ignore them, but they're for people: they explain why code exists, help teammates and your future self, and allow commenting out code

**Drops a tier:** disagrees with no reason, or agrees.

**Sentence starter (80-85%):** "Python ignores comments, but people use them to ___."

## Item 4

**Task:** Predict exactly what displays: `print("Wave 1 incoming")`, `# print("Wave 1 - test spawn rate x2")`, `print("Defend the base!")`, `# Reward the player after surviving`, `print("Wave cleared. +50 XP")`

**Full credit needs:**
- [ ] **Expected output:** `Wave 1 incoming`, `Defend the base!`, `Wave cleared. +50 XP`, in that order
- [ ] No commented text

**Drops a tier:** an extra commented line included, or a line out of order.

## Item 5

**Task:** Explain the difference between a comment and documentation. Are they the same? Use both terms correctly.

**Full credit needs:**
- [ ] Not the same
- [ ] A **comment** is a note in the code (after `#`) about a specific line or section
- [ ] **Documentation** is the broader explanation of a whole program (how to use it, what it does), which comments can be part of

**Drops a tier:** says they're different but defines only one.

## Item 6

**Task:** You want to stop one line from running temporarily without deleting it. What do you do, and what is it called?

**Full credit needs:**
- [ ] **Expected answer:** put `#` at the start of the line
- [ ] It's called **commenting out**

**Drops a tier:** the action right but not the term, or the reverse.

**Sentence starter (80-85%):** "I would put a ___ at the start, which is called ___."

## Item 7

**Task:** Rewrite the weak comment `# set score to 0` (above `score = 0`) so it explains WHY the score is set at this point.

**Full credit needs:**
- [ ] A reason tied to the game moment (`# start each new round from zero so the last round's points don't carry over`)
- [ ] Level 3 on the comment-reasoning scale

**Drops a tier:** a level 2 or level 1 comment.

**Sentence starter (80-85%):** "# reset the score so that ___"

## Item 8

**Task:** A teammate deletes a line instead of commenting it out: "same result, right?" Explain one real difference.

**Full credit needs:**
- [ ] The program runs the same either way, **but**
- [ ] A commented-out line can be restored easily (and shows what was there and why), while a deleted line is gone

**Drops a tier:** says they're different with no actual difference given.

## Item 9

**Task:** Predict exactly what displays: `# print("Boss defeated!")`, `print("Boss defeated!")`, `# End of battle`

**Full credit needs:**
- [ ] **Expected output:** `Boss defeated!` exactly **once**

**Drops a tier:** predicts it twice, or not at all.

**Watch for:** Treating the commented line as running too.

## Item 10

**Task:** Describe a piece of game code in a sentence, write one strong comment for it, and explain what makes the comment strong.

**Full credit needs:**
- [ ] A described piece of code
- [ ] A comment that explains why it exists (level 3)
- [ ] Explains that strong comments give the reason, not a restatement of what the code does

**Drops a tier:** a strong comment with no explanation, or an explanation with a weak comment.

