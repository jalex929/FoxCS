# 01.6 Mastery Check: Common Syntax Mistakes: rubric and answer key

**Never include this file in anything students can see.** Rewritten 2026-11-04 from the live quiz's own build script, so each item below is exactly what students are given. Replaces the earlier narrative key, which described questions the live quiz no longer asks.

**Live structure:** `build-lesson-01-06-mastery-check.php`. A pool of 10 essay tasks. Hand-graded. Mistake names are expected answers; accept any clear wording of the Big Four (missing quote, missing parentheses, wrong capitalization, missing quotes entirely).

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
- **Extra spaces never cost credit.** A fix or a `print()` statement with extra spaces (`print( "Hi" )`, `print ("Hi")`) that is still valid Python is correct. Add one style note instead: clean Python writes `print("Hi")`, with no extra spaces. Per Jay, 2026-11-04.
- **Every response gets feedback.** An 80-85% response gets a sentence starter specific to its task, never just "try again".

## Item 1

**Task:** Fix `print("New Record!` so it displays `New Record!`, and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("New Record!")`
- [ ] **Expected mistake:** missing closing quotation mark (and closing parenthesis). Naming the quote is enough

**Drops a tier:** a correct fix with a wrong name.

## Item 2

**Task:** Fix `print(Paused)` so it displays `Paused`, and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("Paused")`
- [ ] **Expected mistake:** missing quotation marks (Python reads `Paused` as a name, a NameError)

**Drops a tier:** a correct fix, name missing.

## Item 3

**Task:** `Print(Continue` has three mistakes at once. Fix all three and name each. It should display `Continue`. (Reworded 2026-11-04: it said "two", but the line has three.)

**Full credit needs:**
- [ ] **Expected fix:** `print("Continue")`
- [ ] Names all three: wrong capitalization (`Print`), missing quotation marks, missing closing parenthesis

**Drops a tier:** two of the three fixed or named. **Students who saw the old "two mistakes" wording** (the live course before the reword): full credit for fixing all three and naming any two.

## Item 4

**Task:** How can you tell a mistake that causes a SyntaxError from one that causes a NameError? What is Python confused about in each case?

**Full credit needs:**
- [ ] **SyntaxError:** the line breaks Python's rules for how code is written, so Python can't read it (a missing quote or parenthesis)
- [ ] **NameError:** the line is readable, but uses a name Python doesn't know (unquoted text, or `Print`)

**Drops a tier:** describes one error type.

**Sentence starter (80-85%):** "A SyntaxError means ___. A NameError means Python doesn't know ___."

## Item 5

**Task:** Fix `print(Game Saved)` so it displays `Game Saved`, and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("Game Saved")`
- [ ] **Expected mistake:** missing quotation marks

**Drops a tier:** a correct fix, name missing.

## Item 6

**Task:** What does EOL stand for, what usually causes an error mentioning it, and give a broken line that would cause it.

**Full credit needs:**
- [ ] **EOL = End Of Line**
- [ ] Usually caused by a string missing its closing quotation mark
- [ ] An example such as `print("Hello)`

**Drops a tier:** two of the three.

## Item 7

**Task:** Define *syntax* and *parenthesis* in your own words, and explain how they relate using a `print()` example.

**Full credit needs:**
- [ ] **Syntax:** the rules for how code must be written
- [ ] **Parenthesis:** the `(` or `)` symbol
- [ ] Python's syntax requires `print` to have parentheses around what it displays: `print("Hi")`

**Drops a tier:** both defined but not related.

## Item 8

**Task:** You see `NameError: name 'Score' is not defined`. A teammate says that means a typo, like a missing letter. Are they right?

**Full credit needs:**
- [ ] Not exactly, or only partly: a NameError means Python found a **name it doesn't recognize**
- [ ] Here `Score` could be a variable that was never created, a capitalization mismatch (`score` vs `Score`), or text missing its quotes. Not necessarily a missing letter

**Drops a tier:** says they're wrong without explaining what a NameError means.

## Item 9

**Task:** `print(Try Again` has two mistakes. Fix both and name each. It should display `Try Again`.

**Full credit needs:**
- [ ] **Expected fix:** `print("Try Again")`
- [ ] Names both: missing quotation marks and a missing closing parenthesis

**Drops a tier:** one fixed or named.

## Item 10

**Task:** Describe the 4-step debugging process in your own words, and explain why fixing one mistake at a time matters.

**Full credit needs:**
- [ ] The four steps in order: read the last line of the error, find the line number, compare against the rules, fix one thing and run again
- [ ] One at a time matters because a fix can change or reveal the next error, so running after each fix shows what's really left

**Drops a tier:** three of four steps, or the steps without the reason.

