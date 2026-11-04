# 01.4 Mastery Check: Printing Output: rubric and answer key

**Never include this file in anything students can see.** Rewritten 2026-11-04 from the live quiz's own build script, so each item below is exactly what students are given. Replaces the earlier narrative key, which described questions the live quiz no longer asks.

**Live structure:** `build-lesson-01-04-mastery-check.php`. A pool of 10 essay tasks. Hand-graded.

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

**Task:** Predict exactly what this displays: `print("Welcome back!")` then `print("You have 3 lives remaining.")`

**Full credit needs:**
- [ ] **Expected answer:** `Welcome back!` on line 1, `You have 3 lives remaining.` on line 2
- [ ] No quotes in the prediction, in the right order

**Drops a tier:** includes the quotes or `print` in the predicted output, or one line wrong.

**Watch for:** Predicting the quotes appear on screen.

## Item 2

**Task:** Rewrite `print("Inventory Full)` correctly and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("Inventory Full")`
- [ ] **Expected mistake:** a missing (closing) quotation mark

**Drops a tier:** correct fix with the wrong name, or the right name with a broken fix.

## Item 3

**Task:** Rewrite `print "Quest Complete"` correctly and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("Quest Complete")`
- [ ] **Expected mistake:** missing parentheses

**Drops a tier:** correct fix, wrong or missing name.

## Item 4

**Task:** Write one `print()` statement telling a player they don't have enough coins, then explain what makes it good feedback.

**Full credit needs:**
- [ ] A valid `print()` with a clear, specific message (`print("Not enough coins. You need 5 more.")`)
- [ ] Explains it's good because it tells the player exactly what's wrong (and ideally what to do), not a vague or code-like message

**Drops a tier:** a vague message (`"Error"`), or a good message with no explanation.

**Sentence starter (80-85%):** "My message is good feedback because it tells the player ___."

## Item 5

**Task:** In `print("Game paused.")`, identify what `print` is called, what `"Game paused."` is called, and its role. Use *function*, *string*, *argument*.

**Full credit needs:**
- [ ] `print` is a **function**
- [ ] `"Game paused."` is a **string**
- [ ] It's the function's **argument** (the value given to the function to display)

**Drops a tier:** two of the three terms placed correctly.

**Watch for:** Calling the whole line the argument (the same misconception as Item 6).

## Item 6

**Task:** A classmate says that in `print("Level up!")` the whole thing, including `print`, is the argument. What's wrong, and what is each part called?

**Full credit needs:**
- [ ] The argument is only what's inside the parentheses
- [ ] `print` is the **function**, `"Level up!"` is the **string**, which is the **argument**

**Drops a tier:** says it's wrong without giving the correct terms.

**Sentence starter (80-85%):** "The argument is only ___. The word print is the ___."

## Item 7

**Task:** Predict exactly what this displays: `print("Starting game...")`, `print("Player joined.")`, `print("Score: 0")`. Then explain what changes if lines 2 and 3 were swapped.

**Full credit needs:**
- [ ] **Expected output:** `Starting game...`, `Player joined.`, `Score: 0`, one per line
- [ ] Swapping lines 2 and 3 swaps the order those two lines appear: `Score: 0` would come before `Player joined.`

**Drops a tier:** correct prediction but a wrong or missing explanation of the swap.

## Item 8

**Task:** Write one `print()` statement for a moment in a game when text appears, then explain what makes the text a string and what makes `print()` a function.

**Full credit needs:**
- [ ] A valid `print()` statement matching the described moment
- [ ] The text is a string because it's inside quotation marks
- [ ] `print()` is a function because it's a named command that does a job (displays what it's given)

**Drops a tier:** valid statement but one of the two explanations missing.

## Item 9

**Task:** A friend asks why Python cares so much about quotation marks and parentheses in `print()`. Explain why both matter.

**Full credit needs:**
- [ ] Quotation marks show where the string starts and ends (what text to display)
- [ ] Parentheses hold what's being given to the `print` function (its argument), so Python knows the function is being called

**Drops a tier:** explains one of the two.

**Sentence starter (80-85%):** "Quotation marks tell Python ___. Parentheses tell Python ___."

## Item 10

**Task:** Rewrite `PRINT("Level Complete!")` correctly and name the mistake.

**Full credit needs:**
- [ ] **Expected fix:** `print("Level Complete!")`
- [ ] **Expected mistake:** wrong capitalization (Python is case-sensitive)

**Drops a tier:** correct fix, wrong or missing name.

