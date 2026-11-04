# 01.1 Mastery Check: What Programs Do: rubric and answer key

**Never include this file in anything students can see.** Rewritten 2026-11-04 from the live quiz's own build script, so each item below is exactly what students are given. Replaces the earlier narrative key, which described questions the live quiz no longer asks.

**Live structure:** `rebuild-mastery-check-task-pool.php`. A pool of 10 essay tasks: the 4 original questions plus 6 added 2026-09-01. Hand-graded.

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

**Task:** Explain, in your own words, what a program is. Use an everyday example that is NOT a video game and NOT a calculator app.

**Full credit needs:**
- [ ] Says a program is a set of instructions a computer follows (in order)
- [ ] Gives a real everyday example that isn't a game or calculator (a microwave, a traffic light, a GPS, a washing machine)
- [ ] Connects the example to instructions being followed

**Drops a tier:** a game or calculator example; or an example with no link to instructions.

**Watch for:** `CODE-02`: calling anything electronic, or any file, "a program" (a printed book, a text document).

**Sentence starter (80-85%):** "A program is a list of ___ that a computer follows. For example, a ___ follows instructions like ___."

## Item 2

**Task:** Describe at least one specific instruction that must exist inside a vending machine's program.

**Full credit needs:**
- [ ] States one specific, plausible instruction ("if the money is less than the price, don't release the snack")
- [ ] It's an instruction the machine could actually follow, not a description of the machine

**Drops a tier:** a vague statement ("it gives you food") with no condition or step.

**Sentence starter (80-85%):** "If the customer ___, then the machine ___."

## Item 3

**Task:** Do you agree or disagree that "computers are smart, they figure things out on their own"? Explain using the word *instruction*.

**Full credit needs:**
- [ ] Disagrees
- [ ] Explains that computers follow the exact instructions a person wrote, including when those instructions are wrong
- [ ] Uses the word *instruction* correctly

**Drops a tier:** agrees, or disagrees with no reason tied to instructions.

**Watch for:** `CODE-01`: describing the computer as deciding or understanding, instead of following instructions a person wrote. This misconception is what the lesson exists to head off.

**Sentence starter (80-85%):** "I disagree, because a computer only ___ the instructions that ___."

## Item 4

**Task:** Explain what a programming language like Python is for, and why a programmer needs one.

**Full credit needs:**
- [ ] A programming language is a way to write instructions in a form a computer can carry out
- [ ] A programmer needs one because a computer can't be given instructions in everyday human language

**Drops a tier:** names Python as a language without saying what it's for, or why it's needed.

**Sentence starter (80-85%):** "A programming language lets a programmer ___ so that the computer can ___."

## Item 5

**Task:** Set score to 0, add 20, add 20 again, then display score. The display step was written right after the first "add 20". What will the program display, and why?

**Full credit needs:**
- [ ] **Expected answer: 20**
- [ ] Explains that the program runs in the order written, so it displays before the second "add 20" happens

**Drops a tier:** says 40 (follows what was meant, not what was written), or says 20 with no reason.

**Watch for:** `CODE-01`: answering 40 because "the computer knows what you meant."

**Sentence starter (80-85%):** "It shows ___ because the display step comes before ___."

## Item 6

**Task:** Explain the difference between a *programmer* and a *program*. Give an example that shows you understand both words.

**Full credit needs:**
- [ ] A programmer is a person who writes instructions
- [ ] A program is the set of instructions they write, which a computer follows
- [ ] An example uses both words correctly

**Drops a tier:** defines one term only, or swaps them.

**Sentence starter (80-85%):** "A programmer is a ___ who writes ___. A program is ___."

## Item 7

**Task:** What is the difference between a program and a single instruction? Use the recipe idea from this lesson.

**Full credit needs:**
- [ ] A single instruction is one step (one line of a recipe)
- [ ] A program is the whole set of steps in order (the whole recipe)

**Drops a tier:** a recipe answer that never separates one step from the whole.

**Sentence starter (80-85%):** "An instruction is like one ___ in a recipe. A program is like ___."

## Item 8

**Task:** An automatic door opens when it detects motion within 3 feet. What happens if someone stands exactly 4 feet away and waves? Use what you learned about computers being literal.

**Full credit needs:**
- [ ] **Expected answer: the door doesn't open**
- [ ] Explains it follows the 3-foot rule exactly and can't tell the person wants in

**Drops a tier:** says it opens "because they're close", or says it stays closed with no reason.

**Watch for:** `CODE-01` again: "it can tell they want to come in."

**Sentence starter (80-85%):** "The door will ___ because its instruction only says ___."

## Item 9

**Task:** Pick a video game you've played. Describe one specific instruction a programmer had to write for it to work the way it does.

**Full credit needs:**
- [ ] Names a real game
- [ ] Describes one specific, plausible instruction ("when the player's health reaches 0, show Game Over")

**Drops a tier:** describes the game in general ("it has levels") instead of one instruction.

**Sentence starter (80-85%):** "In ___, a programmer had to write: when ___, then ___."

## Item 10

**Task:** If programming languages didn't exist, how would a person give a computer instructions directly? Why were languages like Python invented?

**Full credit needs:**
- [ ] Directly would mean the computer's own low-level language (machine code, 1s and 0s) or wiring, which is very hard for people
- [ ] Languages like Python were invented to make writing instructions easier for people to read and write

**Drops a tier:** says only "it would be hard" without saying what the alternative is or why Python helps.

**Sentence starter (80-85%):** "Without languages, people would have to use ___. Python was invented so that ___."

