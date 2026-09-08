# FoxCS: Python -- Course Unit Skills Map (imported from Google Doc)

**Imported 2026-09-08** from the Google Doc "FoxCS Python -- Course Unit Skills Map" (source of truth for per-lesson skills, misconceptions, adaptive-question targets, mastery-check coverage, and project connections), so this content is version-controlled and available during real lesson authoring rather than living only in Drive. See `course-plan.md` for the master unit/lesson checklist (titles, GMetrix tie-ins, Game/UX tie-ins, journal prompts) -- that file stays the authoring status tracker; this file is the deeper per-lesson skill/assessment specification `course-plan.md` points to.

**Corrected on import:** the doc's own "Status" note below claims only Units 01-06 are "developed in detail." That's stale -- the doc actually carries full lesson-by-lesson detail (Skills, Conceptual Model, Common Misconceptions, Adaptive Question Targets, Coding Exercise, Mastery Check Coverage) through **Unit 09**, then a lighter "Skills Review" pass (skills list + recommended skill categories, no full misconception/question-family breakdown) for Units 10-20, plus a dedicated certification-prep thread starting at Unit 19. Left as-is below rather than silently rewritten, since Jay may want to update the live Doc to match.

**Cross-checked 2026-09-08** against `gmetrix-content-mapping.md` and `python-certification-workbook-map.md` (both landed in the repo the same day, shortly after this file was first imported). `gmetrix-content-mapping.md` turned out to be a raw export duplicating this file's own Units 16-20 content, not a distinct document -- no separate merge needed from it. `python-certification-workbook-map.md` is Jay's real canonical LearnKey/GMetrix workbook-and-video ownership map; it prompted two real corrections in `course-plan.md` (the `323-command.py` command-line page is assigned to Unit 18, not skipped; "Data Structures" is Unit 09's, not Unit 08's) -- see that file's Unit 03/08/09/18 notes and its GMetrix Domain Mapping table for the fixed version. Nothing in this skills-map file itself needed changing from that cross-check.

**Overlap flagged, not yet reconciled:** the framework sections below (Skill Naming, Adaptive Practice Structure, Question-Bank Planning, Code Dropdowns, Practice/Coding Exercise/Mastery Check/Project definitions, Code Stepper, Unit Locking) restate and extend material that already lives in `../../02-authoring-system/objectives-and-skills-proficiency.md`, `content-authoring-standards.md`, `adaptive-practice-model.md`, and `lesson-schema.md`. Nothing here contradicted those docs on the sections actually compared, but no line-by-line reconciliation has been done. Treat those four docs as the still-governing "Source of Truth for Content Authoring" list in the parent `CLAUDE.md`; use this file for the per-unit skill content those docs don't cover.

Minor lesson-title corrections applied to `course-plan.md` from this doc (source of truth): **04.4** "Integer vs Float Division" -> "Division and Floor Division"; **04.8** "Rounding and Reasonableness" -> "Rounding, Floor, Ceiling, and Reasonableness"; **07.4** "Parameters" -> "Parameters and Arguments". Every other unit/lesson title in `course-plan.md` was checked against this doc and already matched exactly.

Em dashes converted to plain hyphens throughout on import, per Jay's writing-style preference (applies to all authored course content).

---

# FoxCS Python - Full Course Skills, Assessment, and Authoring Map

*Living master planning document for the revised FoxCS Python course.*

> **Status:** This document is being built progressively across the full Python course. Units 01-06 are currently developed in detail. Additional units will be added to this same document as their skills, instructional scope, assessment expectations, and projects are finalized.

This is intended to become the **complete course map and authoring specification for the entire FoxCS Python course**, rather than a separate document for only the opening units.

As later units are developed, they should be appended to this document using the same instructional and assessment framework.

---

# Purpose of This Document

This document defines:

- the instructional structure of the course
- the skills students are expected to develop
- the adaptive-practice model
- lesson and mastery expectations
- coding exercise expectations
- project expectations
- cross-cutting troubleshooting skills
- Code Stepper expectations
- pacing and locking conventions
- conceptual teaching approaches
- relatable analogies and mental models
- common misconceptions worth detecting
- question-bank targets
- mastery-check coverage
- project transfer expectations
- certification alignment where appropriate

The goal is to make every lesson specific enough that:

1. instruction can be intentionally authored around the exact concepts students need,
2. adaptive practice can identify which part of a concept a student does or does not understand,
3. mastery checks can verify the skills defined for the lesson,
4. reteaching can target a specific misconception instead of repeating an entire lesson,
5. coding exercises can give students smaller opportunities to apply their skills,
6. projects can require students to synthesize skills independently,
7. students can develop increasingly independent debugging and problem-solving habits,
8. course authors can build large adaptive question banks from clearly defined skill and question families,
9. future revisions can identify exactly where a skill is introduced, practiced, mastered, and applied,
10. the finished document can serve as the blueprint for building the complete Moodle course.

---

# Document Development Status

The document should continue growing as the remaining Python units are reviewed.

Current development:

- **Unit 01 - What Is Programming?** - developed / established
- **Unit 02 - Variables & Data** - developed in detail
- **Unit 03 - User Input & Strings** - developed in detail
- **Unit 04 - Math for Programmers** - developed in detail
- **Unit 05 - Making Decisions** - developed in detail
- **Unit 06 - Loops & Repetition** - developed in detail
- **Unit 07 and beyond** - to be added as planning continues

Do not treat Unit 06 as the end of this document.

Future units should continue directly after Unit 06 using the same format and standing authoring expectations.

---

# Standing Instructional Model

## Skills First

Every lesson should define **discrete, observable skills**.

A skill should be narrow enough that if a student struggles, the teacher or adaptive system can determine what specifically needs additional practice.

For example, instead of assessing only:

> Understands loops

separate skills may include:

- identifies the loop condition
- predicts whether the loop starts
- tracks the loop variable
- predicts when the loop ends
- recognizes an infinite loop
- repairs the update causing the infinite loop

This allows reteaching to target the actual conceptual gap.

---

# Skill Naming

Where practical, skills should use concise machine-readable names such as:

```text
creates_variable
traces_variable_state
uses_floor_division
writes_if_statement
detects_infinite_loop
```

The skill description should explain what observable student performance demonstrates the skill.

Example:

```markdown
- **traces_variable_state** - Tracks how a variable's value changes as Python executes multiple lines of code.
```

These names can later support:

- adaptive-practice tagging
- mastery tracking
- question-bank metadata
- reteaching assignments
- analytics
- progress reports
- prerequisite relationships

---

# Adaptive Practice Structure

Each assessed skill has questions available at three difficulty tiers:

- **Reinforce**
- **Core**
- **Extend**

## Starting Tier

Students begin each assessed skill at **Core**.

## Movement

The first question for a skill is Core.

```text
CORE
├── correct → EXTEND
└── incorrect → REINFORCE
```

Students normally answer:

> **2 questions per assessed skill**

during that lesson's adaptive practice.

The second question provides an additional piece of evidence while immediately adapting to the student's first response.

---

# Minimum Question Bank Per Skill

Author at least:

- **1 Reinforce question**
- **2 Core questions**
- **1 Extend question**

Minimum:

> **4 authored adaptive questions per assessed skill**

The second Core question provides an alternate starting question for:

- another attempt
- reassessment
- repeated practice
- future review
- an alternate lesson attempt

Additional questions should be authored when a skill:

- has several common misconceptions
- is particularly important for later coursework
- benefits from high repetition
- appears frequently on certification assessments
- needs variation to prevent memorization
- has several meaningful application contexts

The four-question requirement is therefore a **minimum**, not a target maximum.

---

# Adaptive Tier Purpose

## Reinforce

Reinforce questions should:

- isolate one concept
- reduce unnecessary reading load
- reduce unnecessary syntax load
- provide greater scaffolding
- use familiar examples
- emphasize recognition or direct application
- help diagnose the misconception

Possible formats:

- code dropdown
- multiple choice
- matching
- identify the incorrect line
- partially completed code
- simplified trace table
- select the correct variable
- select the correct value
- select the correct operator

---

## Core

Core represents the expected independent proficiency for the lesson.

Core questions should:

- use normal Python syntax
- require students to apply the skill
- use familiar but not identical examples
- include prediction
- include code reading
- include construction
- include debugging where appropriate

A student demonstrating Core proficiency should be ready to continue progressing through the course.

---

## Extend

Extend questions should:

- remove some scaffolding
- use a less familiar context
- require transfer
- combine the current skill with prior skills
- require deeper explanation or tracing
- ask students to make a programming decision

Extend should **not** require concepts that have not yet been taught.

Extend means:

> Apply the skill more independently.

It should not mean:

> Learn next week's content early.

---

# Question-Bank Planning

The course map should define **question families**, not every literal question.

Use phrasing such as:

> Write a question that asks students to...

Each question family should later produce multiple actual question-bank items.

Example planning statement:

```text
Write a question that asks students to predict a variable after reassignment.
```

Possible later question-bank items could include:

```python
score = 5
score = 10
```

or:

```python
lives = 3
lives = lives - 1
```

or:

```python
level = 2
level = level + 3
```

The planning hierarchy is:

```text
SKILL
↓
QUESTION FAMILY
↓
REINFORCE / CORE / EXTEND VARIANTS
↓
ADAPTIVE PRACTICE
↓
MASTERY CHECK
↓
TARGETED RETEACHING WHEN NEEDED
```

---

# Common Practice Question Types

Use a mixture of:

- multiple choice
- code dropdowns
- code completion
- fill in a missing expression
- predict the output
- predict the next variable value
- line-by-line tracing
- categorization
- matching
- error identification
- debugging
- short code construction
- sequencing
- short explanation
- choose the best solution
- compare two pieces of code

The question format should support the skill being assessed rather than forcing every skill into the same interaction type.

---

# Code Dropdowns

Some practice questions may contain dropdowns directly inside code.

Example:

```python
if score [ >= ▼ ] 70:
 print("Passing")
```

or:

```python
groups = students [ // ▼ ] group_size
```

Code dropdowns are useful because they isolate:

> Can the student choose the correct piece of syntax?

without simultaneously assessing:

> Can the student reproduce the entire syntax from memory?

Dropdown questions should support instruction but should not completely replace independent construction questions.

---

# Practice, Coding Exercises, Mastery Checks, and Projects

These have different instructional purposes.

---

# Adaptive Practice

Adaptive practice develops individual skills through repeated, targeted questions.

It should:

- respond to student performance
- expose misconceptions
- provide additional practice when needed
- vary examples
- support multiple attempts
- build fluency before mastery

Getting a question wrong should often result in:

> better-targeted practice

rather than simply a score penalty.

---

# Coding Exercises

A **coding exercise** is a small, bounded application task.

Students receive a single programming prompt explaining what they need to create, repair, or modify.

A coding exercise may:

- begin with a blank editor
- provide starter code
- provide a downloadable `.py` file
- ask students to repair broken code
- ask students to modify working code
- ask students to complete a small program
- combine several closely related lesson skills

Coding exercises should generally be completable within:

- part of a lesson
- one class period
- a short independent work block

Coding exercises are the bridge between:

```text
isolated adaptive questions
↓
applied coding
↓
larger independent projects
```

A coding exercise is intentionally more bounded than a project.

---

# Mastery Checks

A lesson mastery check verifies that students can independently demonstrate the **skills defined for that lesson**.

Every assessed skill should appear in the mastery blueprint.

A mastery check does not necessarily need one question per skill if one well-designed question provides evidence for multiple closely related skills.

However, the authoring plan should explicitly identify how every skill is assessed.

Mastery checks should favor:

- reduced scaffolding
- unfamiliar examples
- independent prediction
- tracing
- construction
- debugging
- explanation when conceptual understanding matters

Mastery checks should answer:

> Can this student independently use and understand the skills from this lesson?

A student should not pass a lesson mastery check simply because several questions happened to assess the same narrow portion of the lesson.

---

# Projects

Projects require students to synthesize skills in a less-scaffolded environment.

Unless deliberately designed otherwise, projects should:

- begin with a blank file
- provide a requirements list
- allow multiple valid implementations
- require students to make programming decisions
- require previously learned skills
- require current-unit skills
- offer natural opportunities for creativity
- provide optional stretch opportunities

Projects should **not** introduce critical prerequisite knowledge for the first time.

---

# Required vs Stretch Project Skills

## Required

Required skills represent what all students should be able to apply after completing the unit.

## Stretch

Stretch opportunities allow students to:

- deepen a project
- improve usability
- add features
- combine prior concepts
- solve a more complex version
- explore beyond minimum mastery

Stretch work should be meaningful.

It should not simply add more lines of code.

---

# Cross-Cutting Troubleshooting Routine

Beginning in Unit 02, students repeatedly practice:

# Read → Identify → Test → Revise → Ask

Learning how to respond when something does not work is one of the most important skills developed in this course.

---

## 1. Read

Read:

- the instructions
- the relevant code
- the output
- the error message

before making changes.

---

## 2. Identify

Describe:

- what appears to be happening
- where the problem may be
- what is different from the expected behavior

---

## 3. Test

Make **one reasonable change** or test one hypothesis.

Students should increasingly avoid changing several unrelated things at once.

---

## 4. Revise

Use the result of the test to determine:

- whether the hypothesis was correct
- what should be changed next
- whether the problem changed
- whether additional evidence is needed

---

## 5. Ask

When additional support is needed, ask a **specific question**.

Students should increasingly communicate:

- what they expected
- what actually happened
- where they think the problem may be
- what they have already tried

Example:

> I expected the score to increase to 20, but it stays at 10. I checked the assignment line and tried moving the update inside the loop. I am not sure whether the condition is preventing the update from running.

---

# Troubleshooting Scaffolding Progression

## Early Units

Provide prompts for each step:

```text
READ:
What does the error message say?

IDENTIFY:
Which line appears related to the error?

TEST:
Which of these changes would be reasonable?

REVISE:
What happened after the change?

ASK:
Complete:
"I expected ___, but ___ happened. I already tried ___."
```

---

## Middle Units

Reduce scaffolding:

> Identify the likely problem and explain what you would test first.

---

## Later Units

Students independently use:

> Read → Identify → Test → Revise → Ask

when debugging larger programs.

The routine should appear in:

- adaptive practice
- coding exercises
- mastery preparation
- project troubleshooting
- teacher feedback
- code review

Future units should continue increasing student independence with this routine.

---

# Code Stepper Component

Develop a reusable **Code Stepper** component.

The purpose is to make Python's execution process visible.

The component should allow students to see how the computer reads and executes a program one step at a time.

The Code Stepper should become increasingly important when students encounter:

- variable state
- expressions
- conditionals
- loops
- nested structures
- functions
- collections
- longer programs

---

# Code Stepper Controls

The component should support:

- **Step Forward**
- **Play**
- **Pause**
- **Restart**

Potential later additions:

- Step Back
- execution-speed control
- breakpoint
- skip to next output
- hide/reveal prediction

---

# Code Stepper Display

## Current Line

Highlight the line Python is currently processing.

## Variables

Display current variable names and values.

Example:

```text
Variables

count = 2
score = 30
```

## Output

Show console output as it appears.

## Conditions

When appropriate, show:

```text
count <= 3
→ True
```

## Branch Behavior

When using conditionals, visually identify:

- branch selected
- branch skipped

## Loop Movement

Clearly show when execution jumps:

```text
bottom of loop
↓
back to condition
```

## Future Function Behavior

When functions are introduced, the stepper should eventually show:

- function call
- movement into function body
- parameter values
- local variables
- return value
- movement back to the calling line

---

# Code Stepper Learning Progression

Students should gradually progress through:

## Stage 1

Watch the program step automatically.

## Stage 2

Manually press **Step**.

## Stage 3

Predict the next highlighted line before pressing Step.

## Stage 4

Predict the next variable value.

## Stage 5

Complete part of a trace table.

## Stage 6

Build the entire trace independently.

## Stage 7

Trace unfamiliar code without the interactive stepper.

The Code Stepper is therefore a scaffold toward independent code tracing, not a replacement for tracing.

---

# Pacing and Locking

Lessons receive **recommended completion dates**.

A recommended lesson deadline is:

> a pacing marker

not:

> a lock date.

Students may continue accessing a lesson after its recommended deadline.

---

# Unit Locking

All lessons, practices, coding exercises, mastery checks when appropriate, and projects remain available until the **unit lock date**.

Typical sequence:

```text
Lesson recommended deadlines
↓
Recommended unit completion
↓
1 additional week for completion/review
↓
UNIT LOCK
```

The unit lock is the actual content-access deadline.

---

# Reteaching Categories

Assessment data should help identify **what kind of difficulty a student is experiencing**.

These categories should be used across the entire course where relevant.

---

## Syntax

Student understands the idea but cannot correctly express it in Python.

Examples:

- missing colon
- incorrect indentation
- wrong operator symbol
- unmatched quote

---

## Vocabulary / Symbol Meaning

Student does not reliably understand a programming term or symbol.

Examples:

- `%`
- `//`
- `elif`
- `range`
- `continue`

---

## Code Reading

Student may reproduce a model but cannot determine what existing code does.

---

## State Tracking

Student loses track of changing values.

Especially relevant to:

- reassignment
- counters
- accumulators
- conditionals
- while loops
- nested loops
- functions
- later collections

---

## Conditional Reasoning

Student has difficulty determining whether an expression evaluates to:

```text
True
```

or:

```text
False
```

---

## Decomposition

Student understands individual statements but cannot break a larger problem into steps.

---

## Transfer

Student succeeds when a problem closely matches an example but struggles to use the same concept in a different context.

---

# Standing Authoring Template for Lessons

Every lesson from Unit 02 forward should eventually include the following where appropriate.

Not every section must be equally large in every lesson, but the author should deliberately consider each one.

---

## 1. Lesson Goal

Student-friendly explanation of:

- what students are learning
- why it matters

---

## 2. Skills

Discrete assessable skills.

---

## 3. Conceptual Understanding

What students need to understand beyond syntax.

---

## 4. Vocabulary / Syntax

Relevant:

- words
- symbols
- syntax patterns
- reference tables

---

## 5. Analogy / Mental Model

Provide a relatable high-school-level explanation when useful.

Avoid analogies that introduce more complexity than the programming concept itself.

---

## 6. Worked Examples

Break examples into explicit steps.

Where possible:

> predict before revealing.

---

## 7. Code Stepper

Use whenever execution order or changing state meaningfully improves conceptual understanding.

---

## 8. Common Misconceptions

Document likely misunderstandings.

These should later help create:

- distractors
- feedback
- Reinforce questions
- reteaching paths

---

## 9. Read → Identify → Test → Revise → Ask

Include deliberate troubleshooting practice where appropriate.

---

## 10. Adaptive Practice Blueprint

For each assessed skill:

```text
1 Reinforce
2 Core
1 Extend
```

Students normally answer:

```text
2 questions per skill
```

starting at Core.

---

## 11. Question Targets

Use:

> Write a question that asks students to...

Question targets define families.

Actual question banks will later include multiple variants.

---

## 12. Coding Exercise

Provide one bounded programming task applying lesson skills when appropriate.

May include:

- starter code
- downloadable `.py`
- a blank editor
- debugging code
- modification of an existing program

---

## 13. Mastery Check Blueprint

Explicitly map every assessed skill to mastery evidence.

---

## 14. Recommended Deadline

Provide a pacing marker.

The lesson remains accessible after this date.

---

## 15. Project Connection

Identify how the lesson contributes to the unit project.

---

## 16. Stretch / Transfer

Identify optional ways students can:

- deepen
- combine
- transfer
- personalize

the skill.

---

# Course-Wide Conceptual Progression

A major conceptual thread through the course is **program state and execution**.

The exact progression will continue to expand as later units are added.

Current progression:

## Unit 01

Students learn:

> Python executes instructions.

Focus:

```text
instructions and execution
```

## Unit 02

Students learn:

> values can be stored and changed.

Focus:

```text
variable state
```

## Unit 03

Students learn:

> user information can enter the program and influence output.

Focus:

```text
input → stored state → output
```

## Unit 04

Students learn:

> state can be mathematically transformed.

Focus:

```text
expression evaluation
```

## Unit 05

Students learn:

> state determines which path executes.

Focus:

```text
branching
```

## Unit 06

Students learn:

> state changes repeatedly and controls repetition.

Focus:

```text
iteration
```

Current progression:

```text
instructions
↓
state
↓
input
↓
calculation
↓
decision
↓
repetition
↓
[future course concepts added here]
```

As Units 07 and beyond are developed, extend this progression rather than replacing it.

---

# UNIT 01: What Is Programming?

*Unit 01 is the introductory foundation and is currently considered locked.*

*GMetrix tie-in: none.*

## Unit Goal

Students understand what programming is, how computers follow instructions, how Python executes simple programs, and how to use basic output and comments.

The unit establishes the foundational idea:

> Computers are extremely literal.

---

# 01.1 What Programs Do

## Skills / Content

- defines what a program is
- recognizes that programs consist of instructions
- distinguishes human interpretation from computer literalness
- recognizes that programming languages communicate instructions to computers
- uses introductory programming vocabulary appropriately

## Conceptual Model

A computer does not automatically infer what a programmer meant.

It does:

> what the instructions actually say.

Relatable examples may include:

- giving someone overly vague directions
- entering the wrong destination into GPS
- telling a game character exactly what actions are allowed
- following a recipe with missing steps

---

# 01.2 Input → Process → Output

## Skills / Content

- identifies input
- identifies processing
- identifies output
- recognizes the Input → Process → Output structure
- applies the model to familiar systems
- applies the model to a simple computer program

## Relatable Examples

ATM:

```text
INPUT
PIN + withdrawal amount

PROCESS
verify account and balance

OUTPUT
cash + updated balance
```

Video game:

```text
INPUT
button press

PROCESS
game checks player's current state

OUTPUT
character jumps
```

---

# 01.3 Writing Your First Program

## Skills / Content

- predicts output before running code
- understands that Python normally executes top-to-bottom
- recognizes each line as an instruction
- compares predicted output with actual output

## Conceptual Goal

Students should begin forming the habit:

> Read the code before pressing Run.

---

# 01.4 Printing Output

## Skill

- **uses_print** - Uses `print()` correctly and understands the basic anatomy of a print statement.

## Students Should Recognize

```python
print("Hello")
```

as:

```text
print
↓
Python instruction

()
↓
information being passed to print

"Hello"
↓
string to display
```

## Common Beginner Mistakes

Include:

- forgetting quotes around text
- forgetting a closing parenthesis
- mismatched quotes
- incorrect spelling/capitalization of `print`

---

# 01.5 Comments and Documentation

## Skills / Content

- writes a Python comment
- recognizes `#`
- explains why comments are useful
- understands that Python ignores comments during normal execution
- writes comments that describe intent rather than unnecessarily repeating obvious code

Example:

```python
# Display the starting message
print("Welcome!")
```

---

# 01.6 Common Syntax Mistakes

## Skill

- **diagnoses_syntax_error** - Recognizes and repairs common beginner syntax errors.

Include the introductory "Big Four" style errors such as:

- unmatched quotation marks
- unmatched parentheses
- misspelled command
- missing punctuation / malformed statement

Students should begin practicing:

> Read the error → inspect the relevant line → test one fix.

---

# Unit 01 Project: Interactive Greeting

## Scope

Project should remain limited to Unit 01 concepts.

Students use:

- `print()`
- text
- comments
- intentional output formatting

Do not require variables or `input()` yet if those concepts have not been introduced.

---

# UNIT 02: Variables & Data

*GMetrix tie-in: Domain 1.*

Relevant concepts include:

- `str`
- `int`
- `float`
- `bool`
- type conversion
- assignment

## Unit Conceptual Goal

Students understand that programs can:

- store information
- label information
- identify different data types
- change stored values
- convert between compatible types
- track changing program state

Unit 02 begins deliberate use of:

> **Read → Identify → Test → Revise → Ask**

---

# 02.1 Variables and Memory

## Skills

- **creates_variable** - Creates a variable using an assignment statement.
- **variable_naming_rules** - Determines whether a Python variable name is valid and applies `snake_case`.
- **reassigns_variable** - Reassigns an existing variable to a new value.
- **recognizes_assignment_operator** - Understands `=` as assignment.
- **distinguishes_name_from_value** - Identifies the variable name and the value being stored.
- **recognizes_quoted_name_is_string** - Understands that `"score"` is a string rather than a reference to the variable `score`.
- **case_sensitivity_matters** - Recognizes that Python identifiers are case-sensitive.
- **concatenates_with_commas** - Combines literal text and variables using comma-separated `print()` arguments.
- **concatenates_with_plus** - Combines strings using `+` and converts non-string values when needed.

---

## Conceptual Model

A variable is a **named place where the program remembers a value**.

Avoid implying that the value is permanent.

Example:

```python
score = 10
score = 20
```

The current value of `score` is:

```text
20
```

The old value is not secretly preserved by that variable.

---

## Common Misconceptions

Students may believe:

- `=` means mathematical equality
- assigning a new value creates a second copy
- `"score"` refers to `score`
- capitalization does not matter
- a variable's original value is permanently attached to it

---

## Adaptive Question Targets

Create Reinforce/Core/Extend variants for prompts such as:

- Write a question that asks students to identify the variable name.
- Write a question that asks students to identify the stored value.
- Write a question that asks students to create an assignment statement.
- Write a question that asks students to select a valid variable name.
- Write a question that asks students to repair an invalid variable name.
- Write a question that asks students to predict a variable after reassignment.
- Write a question that contrasts `score` and `"score"`.
- Write a question that tests case sensitivity.
- Write a code-dropdown question selecting a valid assignment statement.
- Write a debugging question using Read → Identify → Test → Revise.

---

## Coding Exercise

Create a small character/profile program that stores multiple pieces of information in variables and prints them.

Possible variables:

```python
player_name
level
health
favorite_game
```

---

## Recommended Deadline

**Tuesday, September 8**

---

# 02.2 Integers

## Skills

- **identifies_integer_type** - Recognizes whole-number integer values.
- **distinguishes_integer_from_string** - Distinguishes `5` from `"5"`.
- **recognizes_negative_integer** - Recognizes negative whole numbers as integers.
- **uses_integer_for_countable_quantity** - Selects integers for quantities such as lives or items.
- **predicts_basic_integer_arithmetic** - Predicts simple arithmetic involving integers.

---

## Conceptual Model

Integers are appropriate for quantities such as:

- lives
- level
- number of enemies
- inventory count
- points
- number of students

---

## Adaptive Question Targets

- Write a question asking students to classify a value as integer or non-integer.
- Write a question comparing `5` and `"5"`.
- Write a question asking which variable should use an integer.
- Write a question predicting simple integer arithmetic.
- Write a debugging question where a number was accidentally stored as text.

---

## Recommended Deadline

**Wednesday, September 9**

---

# 02.3 Floats

## Skills

- **identifies_float_type** - Recognizes a numeric value containing a decimal point as a float.
- **distinguishes_int_vs_float** - Distinguishes integers and floats.
- **recognizes_float_disguised_as_whole** - Recognizes `12.0` as a float.
- **uses_float_for_decimal_quantity** - Selects floats when decimal precision is needed.
- **predicts_mixed_numeric_result** - Predicts basic results involving int and float values.

---

## Key Misconception

```python
12.0
```

is a float even though:

```text
12.0 = 12 mathematically
```

The decimal point affects the Python type.

---

## Relatable Examples

Floats may represent:

- game speed
- elapsed time
- prices
- percentages
- coordinates
- measurements

---

## Adaptive Question Targets

- Write a question comparing `12` and `12.0`.
- Write a question asking students to choose int or float for a context.
- Write a question predicting a mixed int/float calculation.
- Write a code-dropdown question selecting an appropriate numeric representation.

---

## Recommended Deadline

**Thursday, September 10**

---

# 02.4 Strings

## Skills

- **identifies_string_type** - Recognizes values inside quotes as strings.
- **recognizes_quotes_override_appearance** - Understands that quotes determine string type.
- **distinguishes_string_from_variable** - Distinguishes `"name"` from `name`.
- **recognizes_numeric_looking_string** - Recognizes `"100"` as a string.
- **recognizes_boolean_looking_string** - Recognizes `"True"` as a string.

---

## Conceptual Model

Quotation marks tell Python:

> Treat these characters as text.

Therefore:

```python
"100"
```

is not automatically a number.

---

## Adaptive Question Targets

- Write a question asking students to identify strings.
- Write a question comparing `100` and `"100"`.
- Write a question comparing `True` and `"True"`.
- Write a question contrasting a variable name with the same letters inside quotes.
- Write a question asking why arithmetic fails with numeric-looking text.

---

## Recommended Deadline

**Thursday, September 10**

---

# 02.5 Booleans

## Skills

- **identifies_boolean_type** - Recognizes `True` and `False`.
- **applies_boolean_casing** - Uses capitalized Python Boolean values.
- **distinguishes_boolean_from_string** - Distinguishes `True` from `"True"`.
- **interprets_true_false_as_program_state** - Connects Boolean values to program state.
- **selects_boolean_for_two_state_information** - Identifies when Boolean data is appropriate.

---

## Relatable Examples

Booleans can represent:

```text
game_paused
player_alive
door_locked
assignment_submitted
sound_enabled
```

These values naturally have two states.

---

## Common Misconceptions

```python
true
```

is not the Python Boolean:

```python
True
```

and:

```python
"True"
```

is a string.

---

## Recommended Deadline

**Friday, September 11**

---

# Unit 02 Mixed Data-Type Checkpoint

Students should distinguish values such as:

```text
12
12.0
"12"
True
"True"
score
"score"
```

This checkpoint should deliberately surface misconceptions before students begin conversion.

---

# 02.6 Type Conversion

## Skills

- **uses_type_function** - Uses `type()` to inspect a value's type.
- **interprets_type_output** - Reads results such as `<class 'int'>`.
- **converts_to_string** - Uses `str()`.
- **converts_to_integer** - Uses `int()`.
- **converts_to_float** - Uses `float()`.
- **predicts_valid_conversion** - Determines whether a conversion will work.
- **predicts_invalid_conversion** - Recognizes incompatible conversion attempts.
- **selects_conversion_for_context** - Chooses the conversion a program needs.

---

## Conceptual Bridge

Conversion changes:

> how Python should interpret the value.

Example:

```python
"12"
```

looks numeric to a person.

Python still treats it as text until explicitly converted.

---

## Troubleshooting Integration

Give students a type-related error.

Practice:

1. Read the message.
2. Identify the values involved.
3. Check the types.
4. Test a conversion.
5. Revise based on the result.
6. Ask a specific question if needed.

---

## Adaptive Question Targets

- Write a question asking students to interpret `type()` output.
- Write a question choosing the correct conversion function.
- Write a question predicting a successful conversion.
- Write a question predicting an invalid conversion.
- Write a debugging question involving incompatible types.
- Write a code dropdown choosing `str`, `int`, or `float`.

---

## Recommended Deadline

**Monday, September 14**

---

# 02.7 Reading Code with Variables

## Skills

- **traces_variable_state** - Tracks variable values line-by-line.
- **interprets_reassignment_expressions** - Understands statements such as `score = score + 2`.
- **predicts_final_variable_value** - Determines final variable state.
- **predicts_output_from_variable_state** - Predicts output after variable changes.
- **debugs_variable_code** - Finds and fixes variable-related errors.
- **explains_variable_change** - Explains why a variable changed.
- **saves_code_for_later_review** - Saves work in a way that can be found again.

---

## Code Stepper Introduction

Use the Code Stepper for the first time.

Example:

```python
score = 5
score = score + 10
score = score * 2
print(score)
```

### Initial Experience

Students watch the stepper.

### Next Experience

Before pressing Step:

> What will `score` be after this line?

Students should begin understanding **state change**, which becomes increasingly important in later units.

---

## Adaptive Question Targets

- Write a question asking students to predict a variable after one reassignment.
- Write a question requiring a multi-line trace.
- Write a question asking which line changed the value.
- Write a debugging question involving the wrong variable name.
- Write a question involving case sensitivity.
- Write a question asking students to explain why `score = score + 5` works.

---

## Recommended Deadline

**Tuesday, September 15**

---

# Unit 02 Adaptive Review / Targeted Reteaching

## Recommended

**Wednesday, September 16**

Use skill-level data.

Do not simply assign:

> Repeat Unit 02.

Instead assign targeted work such as:

- variable naming
- strings vs numbers
- type conversion
- reassignment
- variable tracing

---

# Unit 02 Mastery Check

## Recommended

**Thursday, September 17**

Mastery should provide evidence for:

- assignment
- naming
- reassignment
- data-type identification
- int/float distinction
- strings
- Booleans
- type conversion
- variable tracing
- debugging a variable/type issue

---

# Unit 02 Project: Personal Profile Generator

## Project Work

**September 18-21**

## Required Skills

Students should:

- create meaningful variables
- use multiple data types
- reassign at least one value when appropriate
- combine values into readable output
- demonstrate correct type usage
- organize clear output

---

## Stretch Opportunities

Students may add:

- additional profile categories
- calculated information
- improved visual formatting
- optional personalization
- derived values
- more sophisticated output

---

# Recommended Unit 02 Completion

**Monday, September 21**

# Unit 02 Lock

**Monday, September 28**

All Unit 02 lesson content remains accessible until the unit locks.

---

# UNIT 03: User Input & Strings

*GMetrix tie-in: Domain 3.*

Relevant concepts include:

- user input
- console interaction
- formatted text output

## Unit Conceptual Goal

Students move from:

> programs containing fixed information

to:

> programs that respond to the user.

Students learn that input creates a user/program interaction and that strings can be combined, formatted, transformed, and sliced.

---

# 03.1 Receiving User Input

## Skills

- **reads_user_input** - Uses `input()`.
- **stores_input_in_variable** - Saves the returned user input.
- **recognizes_input_returns_string** - Understands that `input()` returns a string.
- **responds_to_input_dynamically** - Uses entered information later in the program.
- **writes_clear_prompt** - Writes a useful prompt for the user.
- **predicts_input_based_output** - Predicts output given a specific user response.

---

## Conceptual Bridge

`input()` tells the computer:

> Stop here and wait for information from the user before continuing.

---

## Game / UX Tie-In

A program becomes more engaging when it reacts to:

- player name
- preferences
- choices
- responses

Prompt wording also affects usability.

Compare:

```text
Input:
```

with:

```text
Enter your player name:
```

The second is technically and experientially clearer.

---

## Adaptive Question Targets

- Write a question identifying what `input()` does.
- Write a question identifying where user input is stored.
- Write a question predicting output for a supplied response.
- Write a question repairing code that fails to store input.
- Write a question choosing the clearest input prompt.
- Write a question asking why numeric-looking input is still a string.

---

# 03.2 Building Dynamic Output

## Skills

- **combines_input_and_output** - Uses entered information in output.
- **formats_output_meticulously** - Produces readable, intentional formatting.
- **includes_needed_spacing_and_punctuation** - Handles spaces and punctuation correctly.
- **creates_user_specific_response** - Produces output based on user data.
- **evaluates_output_readability** - Judges whether output is understandable.

---

## Example

Poor:

```text
Name:Alex
```

Better:

```text
Name: Alex
```

This lesson reinforces that:

> technically functioning code can still have poor usability.

---

## Adaptive Question Targets

- Write a question asking which output is easier to read.
- Write a question identifying missing spaces.
- Write a question predicting dynamic output.
- Write a debugging question involving awkward formatting.
- Write a question asking students to revise unclear output.

---

# 03.3 String Concatenation

## Skills

- **joins_multiple_strings**
- **predicts_concatenated_output**
- **distinguishes_string_joining_from_numeric_addition**
- **converts_nonstring_for_concatenation**
- **selects_output_composition_method**

---

## Conceptual Focus

Students should understand the difference between:

```python
5 + 5
```

and:

```python
"5" + "5"
```

The first produces:

```text
10
```

The second produces:

```text
55
```

because string concatenation joins text.

---

## Adaptive Question Targets

- Write a question predicting concatenated output.
- Write a question contrasting numeric addition with string joining.
- Write a question requiring `str()` conversion.
- Write a question repairing a `TypeError`.
- Write a question asking students to select commas or `+` appropriately.

---

# 03.4 F-Strings

## Skills

- **writes_fstrings**
- **identifies_fstring_prefix**
- **places_value_in_braces**
- **distinguishes_literal_text_from_interpolation**
- **predicts_fstring_output**
- **debugs_fstring_syntax**

---

## Required Teaching Pattern

Teach this as a recognizable shape:

```python
f"text {variable} more text"
```

Students should become comfortable recognizing:

```text
f
quotes
literal text
{variable/expression}
```

through repetition.

---

## Adaptive Question Targets

- Write a question identifying the `f`.
- Write a question identifying the braces.
- Write a question predicting f-string output.
- Write a code dropdown completing an f-string.
- Write a debugging question involving missing braces.
- Write a question converting concatenation into an f-string.

---

# 03.5 String Format

## Skills

- **uses_format_method**
- **matches_placeholder_to_value**
- **formats_multiple_values**
- **predicts_format_output**
- **uses_format_reference_when_needed**

---

## Teaching Note

Provide a format-specification reference.

Students do not need to memorize every possible formatting specification.

Focus on:

> recognizing how `.format()` works and how to use a reference when necessary.

---

# 03.6 Common String Methods

## Skills

- **calls_string_method**
- **applies_string_methods**
- **predicts_method_result**
- **recognizes_method_returns_new_string**
- **stores_transformed_string_when_needed**
- **selects_method_for_goal**

---

## Conceptual Challenge

Students may write:

```python
name.upper()
print(name)
```

and expect `name` itself to have permanently changed.

Teach that many string methods:

> return a new string

rather than altering the original string in place.

---

## Adaptive Question Targets

- Write a question predicting a string-method result.
- Write a question selecting the appropriate method.
- Write a question asking whether the original variable changes.
- Write a debugging question where the returned value was not saved.
- Write a question asking students to store a transformed string.

---

# 03.7 String Slicing Introduction

## Skills

- **identifies_string_index**
- **slices_strings**
- **predicts_slice_boundaries**
- **recognizes_exclusive_end**
- **uses_omitted_slice_boundary**
- **reverses_a_string**

---

## Required Teaching Model

Teach slicing as:

> cutting **before** each index.

Example:

```python
word[0:3]
```

means:

> Cut before position `0` and cut before position `3`.

This uses one consistent mental model instead of:

> start on 0 but stop before 3.

---

## Visual Model

For:

```text
P Y T H O N
0 1 2 3 4 5
```

```python
word[0:3]
```

cuts:

```text
| P Y T | H O N
```

resulting in:

```text
PYT
```

---

## Adaptive Question Targets

- Write a question asking students to identify an index.
- Write a question asking what a slice returns.
- Write a question emphasizing the exclusive endpoint.
- Write a question asking students to select slice boundaries.
- Write a question using an omitted start/end.
- Write a question asking students to reverse a string.

---

# Unit 03 Project: Mad Lib Generator

## Required Skills

Students should:

- capture multiple inputs
- store user responses
- build dynamic output
- format readable text
- use appropriate string-composition techniques
- demonstrate basic string manipulation

---

## Stretch Opportunities

Students may add:

- additional story sections
- string transformations
- formatted headings
- more personalized output
- optional later decision branches once Unit 05 is learned
- replay functionality once loops are learned

---

# UNIT 04: Math for Programmers

*GMetrix tie-in: Domain 1 arithmetic operators.*

Percentages, rates, formula building, rounding, floor/ceiling, and real-world problem solving provide additional FoxCS content beyond the narrow certification objectives.

## Game / UX Tie-In

Math drives:

- scoring
- damage
- health
- timers
- physics
- movement
- currency
- XP
- percentages
- item prices
- cooldowns
- resource systems

## Unit Conceptual Goal

Students understand that programming math is familiar mathematics expressed as:

> precise operations and formulas the computer can execute.

Students should increasingly be able to:

- predict calculations
- translate word problems
- write formulas
- track intermediate values
- choose the correct operation
- evaluate whether a result is reasonable

---

# 04.1 Math in Programming

## Skills

- **recognizes_math_expression**
- **predicts_math_result**
- **connects_math_to_program_behavior**
- **distinguishes_calculation_from_output**
- **uses_variables_as_quantities**

---

## Conceptual Bridge

Programming math can be explained through a scoreboard.

A scoreboard does not invent its own rules.

It follows instructions such as:

```text
add 2 points
subtract 1 timeout
increase the score
```

Likewise:

```python
health = health - 10
```

means:

> Take the current health value, subtract 10, and store the result.

---

## Important Distinction

This expression:

```python
5 + 3
```

calculates a value.

This:

```python
print(5 + 3)
```

calculates **and displays** it.

Calculation and output are different actions.

---

# 04.2 Arithmetic Operators

## Skills

- **uses_addition_operator**
- **uses_subtraction_operator**
- **uses_multiplication_operator**
- **uses_division_operator**
- **uses_exponent_operator**
- **recognizes_programming_operator_symbols**
- **selects_correct_arithmetic_operator**
- **predicts_operator_result**
- **writes_arithmetic_expression**

---

## Operator Reference

| Math idea | Python |
|---|---|
| Addition | `+` |
| Subtraction | `-` |
| Multiplication | `*` |
| Division | `/` |
| Exponent | `**` |

---

## Teaching Note

A student who understands multiplication but writes:

```text
×
```

instead of:

```python
*
```

has a **syntax gap**, not necessarily a mathematical misunderstanding.

Assess these separately when possible.

---

## Adaptive Question Targets

- Write a question selecting the correct operator.
- Write a question translating a verbal operation into code.
- Write a question predicting arithmetic output.
- Write a code-dropdown question selecting an operator.
- Write a debugging question involving an incorrect operator.
- Write a question asking students to construct a simple expression.

---

# 04.3 Order of Operations

## Skills

- **applies_order_of_operations**
- **predicts_multioperator_expression**
- **uses_parentheses_to_control_order**
- **traces_expression_steps**
- **distinguishes_code_order_from_math_order**
- **adds_parentheses_for_readability**

---

## Conceptual Bridge

Students have already learned:

> Python reads statements top-to-bottom.

Clarify that this does not mean every mathematical operation on a line happens left-to-right.

Example:

```python
score = 10 + 2 * 5
```

Python must evaluate the expression before the assignment completes.

Trace:

```text
10 + 2 * 5
10 + 10
20
```

Then:

```python
score = 20
```

---

## Common Misconception

Students may incorrectly combine:

> Python runs top-to-bottom

with:

> do every operator from left-to-right.

Make this misconception explicit.

---

# 04.4 Division and Floor Division

## Skills

- **uses_true_division**
- **uses_floor_division**
- **distinguishes_true_and_floor_division**
- **predicts_division_type**
- **predicts_floor_division_result**
- **selects_division_operator_for_context**
- **interprets_floor_division_as_complete_groups**

---

## Conceptual Bridge

17 students forming groups of 4:

```python
17 / 4
```

asks:

> What is the full mathematical quotient?

Result:

```text
4.25
```

But:

```python
17 // 4
```

can answer:

> How many complete groups of four fit?

Result:

```text
4
```

---

## Important Note

Do not simply tell students:

> `//` means round down.

Teach:

> floor division is a division operation that returns the floor of the quotient.

For early positive-number examples, complete groups are a useful model.

---

## Adaptive Question Targets

- Write a question predicting `/`.
- Write a question predicting `//`.
- Write a question asking students to choose `/` or `//`.
- Write a question explaining why the outputs differ.
- Write a real-world complete-groups problem.
- Write a code-dropdown question selecting the correct division operator.
- Write a debugging question involving the wrong division operator.

---

# 04.5 Modulo and Remainders

## Skills

- **calculates_remainder**
- **uses_modulo_operator**
- **distinguishes_modulo_from_percentage**
- **pairs_division_and_modulo**
- **detects_even_odd**
- **detects_divisibility**
- **applies_modulo_to_cycles**

---

## Conceptual Bridge

Continue the grouping problem:

```python
17 // 4
```

gives:

```text
4 complete groups
```

and:

```python
17 % 4
```

gives:

```text
1 left over
```

Together:

> complete groups + leftovers

---

## Important Misconception

Students know `%` from school as:

> percent.

In Python:

```python
20 % 6
```

means:

> remainder after division

not:

> twenty percent of six.

Explicitly contrast these meanings.

---

## Relatable Applications

Modulo can help with:

- even/odd checks
- divisibility
- wrapping values
- repeating patterns
- alternating turns
- clock-style cycles

---

# 04.6 Percentages and Rates

## Skills

- **converts_percent_to_decimal**
- **calculates_percentage_of_value**
- **calculates_increase**
- **calculates_decrease**
- **distinguishes_amount_from_final_total**
- **calculates_rate**
- **translates_rate_problem_to_expression**

---

## Relatable Contexts

Use:

- sale prices
- game discounts
- XP bonuses
- damage multipliers
- sales tax
- battery percentage
- shooting percentage
- hourly pay
- points per game
- cost per item

---

## Key Conceptual Distinction

For a `$50` item at `20%` off:

```python
discount = 50 * 0.20
```

calculates:

> discount amount

not:

> final price.

Then:

```python
final_price = 50 - discount
```

calculates the final price.

Students should be assessed on this distinction.

---

# 04.7 Formulas with Variables

## Skills

- **identifies_formula_inputs**
- **translates_formula_to_code**
- **builds_formula_from_words**
- **uses_descriptive_formula_variables**
- **stores_calculated_result**
- **reuses_calculated_values**
- **traces_formula_values**
- **updates_formula_when_inputs_change**

---

## Conceptual Bridge

A formula is like a recipe template.

Example:

```python
total = price * quantity
```

The structure stays the same.

The values can change.

This helps students move from:

> solving one arithmetic problem

to:

> creating a reusable solution.

---

# 04.8 Rounding, Floor, Ceiling, and Reasonableness

## Skills

- **uses_round_function**
- **rounds_to_requested_precision**
- **uses_math_floor**
- **uses_math_ceil**
- **imports_math_module**
- **distinguishes_floor_ceil_round**
- **distinguishes_floor_from_floor_division**
- **predicts_rounding_function_result**
- **selects_rounding_strategy_from_context**
- **estimates_expected_result**
- **checks_result_reasonableness**
- **recognizes_float_precision_artifact**

---

## Core Distinction

```text
round()
→ nearest

math.floor()
→ integer at or below

math.ceil()
→ integer at or above

//
→ floor-division operation
```

---

## Ceiling Analogy: Buses

73 students need buses.

Each bus holds 30 students.

```python
73 / 30
```

produces approximately:

```text
2.43
```

You cannot order:

```text
2.43 buses
```

You need:

```text
3 buses
```

This is a ceiling situation.

---

## Floor Analogy: Complete Teams

73 students form teams of 10.

There are:

```text
7 complete teams
```

before dealing with leftover students.

This is a floor-style situation.

---

## Round Analogy

A game has an average user rating of:

```text
4.46
```

If displayed to one decimal place:

```text
4.5
```

This is normal rounding.

---

## Visual Comparison

For:

```text
3.2
```

```text
floor → 3
round → 3
ceil → 4
```

For:

```text
3.8
```

```text
floor → 3
round → 4
ceil → 4
```

---

## Reasonableness

Students should learn:

> Code running successfully does not prove the result is correct.

Example:

A program produces:

```text
$6,437.20
```

for a `$12` lunch.

Python may have successfully executed the programmer's incorrect formula.

Students should still ask:

> Does this answer make sense?

---

## Float Precision

Introduce lightly.

Students may occasionally see:

```text
0.30000000000000004
```

Do not turn this into a deep floating-point lesson.

The immediate goal is:

> recognize that decimal representation can occasionally look unusual.

---

## Adaptive Question Targets

- Write a question predicting `round()`.
- Write a question predicting `math.floor()`.
- Write a question predicting `math.ceil()`.
- Write a question choosing round/floor/ceil from context.
- Write a question requiring `import math`.
- Write a question contrasting `//` and `math.floor()`.
- Write a debugging question where `round()` was used but `ceil()` is needed.
- Write a question asking whether a numeric result is reasonable.
- Write a code dropdown choosing floor/ceil/round.

---

# 04.9 Solving Real-World Problems

## Skills

- **identifies_known_values**
- **identifies_target_value**
- **ignores_irrelevant_information**
- **decomposes_math_problem**
- **orders_calculation_steps**
- **translates_steps_to_code**
- **labels_intermediate_values**
- **verifies_result**
- **debugs_formula_logic**

---

# Problem-Solving Framework

Teach students to ask:

## 1. What do I know?

Identify the known values.

## 2. What am I trying to find?

Identify the final result.

## 3. What needs to happen first?

Break down dependencies.

## 4. What operation matches each step?

Choose operators and formulas.

## 5. What should I call each value?

Use meaningful variables.

## 6. Does the answer make sense?

Evaluate reasonableness.

---

# Unit 04 Project: Tip, Tax, and Discount Calculator

## Required Skills

Students should:

- accept numeric input
- convert input appropriately
- calculate percentages
- use arithmetic operators
- use variables for intermediate values
- apply a multi-step formula
- round currency output appropriately
- format readable output
- check reasonableness

---

## Suggested Decomposition

```text
original price
↓
discount amount
↓
discounted price
↓
tax amount
↓
subtotal
↓
tip amount
↓
final total
```

Students should not be required to write everything as one giant expression.

Intermediate variables improve:

- readability
- debugging
- assessment
- conceptual understanding

---

## Stretch Opportunities

Students may add:

- custom tip percentages
- bill splitting
- coupon thresholds
- multiple discounts
- optional fees
- ceiling calculations for packages/items
- receipt-style output
- improved formatting

---

# UNIT 05: Making Decisions

*GMetrix tie-in includes Domain 1 comparison/logical/identity operators and Domain 2 branching statements.*

Keep the Domain 1 operator content and Domain 2 branching content conceptually separated rather than overloading a single lesson.

## Game / UX Tie-In

Conditionals control:

- win/lose states
- dialogue choices
- unlock conditions
- enemy behavior
- permissions
- recommendations
- menus
- user feedback
- score thresholds

---

# Unit Conceptual Goal

Students understand a conditional as:

> Python asking a yes/no question about the current program state and selecting what happens next.

---

# 05.1 Comparison Operators

## Skills

- **recognizes_comparison_expression**
- **uses_equality_operator**
- **distinguishes_assignment_and_equality**
- **uses_not_equal_operator**
- **uses_greater_less_operators**
- **uses_greater_equal_less_equal**
- **predicts_comparison_boolean**
- **selects_correct_comparison_operator**
- **reads_comparison_in_plain_language**
- **writes_comparison_from_rule**
- **constructs_comparison_symbol_from_language**

---

## Core Mental Model

Every comparison asks a yes/no question.

Example:

```python
score >= 100
```

asks:

> Is the score greater than or equal to 100?

Python answers:

```text
True
```

or:

```text
False
```

---

# `=` vs `==`

Teach:

```text
=
put/store this value here
```

and:

```text
==
are these values equal?
```

This distinction should receive independent assessment.

---

# `<=` and `>=` Memory Support

Write the symbols in the same order students say the phrase.

## Less Than or Equal To

Say:

```text
less than
or equal to
```

Write:

```text
< =
```

Combine:

```python
<=
```

## Greater Than or Equal To

Say:

```text
greater than
or equal to
```

Write:

```text
> =
```

Combine:

```python
>=
```

Do not present these as arbitrary symbol combinations students must memorize.

---

## Adaptive Question Targets

- Write a question selecting the correct comparison operator.
- Write a question predicting True/False.
- Write a question translating plain language into a comparison.
- Write a question translating comparison code into plain language.
- Write a question distinguishing `=` and `==`.
- Write a code-dropdown question choosing `<`, `>`, `<=`, or `>=`.
- Write a debugging question involving the wrong comparison operator.

---

# 05.2 Boolean Logic

## Skills

- **uses_and_operator**
- **uses_or_operator**
- **uses_not_operator**
- **predicts_compound_boolean**
- **distinguishes_and_vs_or**
- **translates_compound_rule_to_code**
- **uses_parentheses_in_boolean_logic**
- **recognizes_identity_operator**
- **distinguishes_identity_from_equality**
- **predicts_basic_identity_expression**

---

## `and` Conceptual Bridge

You need:

> your ticket **AND** your school ID.

Both requirements must be satisfied.

---

## `or` Conceptual Bridge

You may pay with:

> cash **OR** card.

Either accepted option is enough.

---

## `not` Conceptual Bridge

`not` reverses a Boolean state.

Example:

```text
NOT locked
```

means:

> the locked condition is false.

---

# Identity Operators

Introduce:

```python
is
is not
```

only at the level required by the relevant certification content.

Students should understand:

```text
==
compares equality
```

while:

```text
is
checks identity
```

Do **not** introduce `is None` as a required pattern at this stage.

Do not over-expand identity beyond what students need for the course and exam.

---

## Adaptive Question Targets

- Write a question asking students to select `and` or `or`.
- Write a question predicting a compound Boolean.
- Write a question translating a verbal requirement into Boolean logic.
- Write a debugging question with incorrect `and`/`or`.
- Write a question introducing `not`.
- Write a certification-style question distinguishing `is` from `==`.

---

# 05.3 If Statements

## Skills

- **writes_if_statement**
- **connects_condition_to_branch**
- **uses_colon_after_condition**
- **indents_conditional_body**
- **predicts_if_execution**
- **writes_condition_for_requirement**
- **distinguishes_condition_from_action**

---

## Conceptual Bridge

An `if` statement acts like a locked door.

Example:

```python
if level >= 10:
 print("Area unlocked")
```

Python asks:

> Does the player meet the requirement?

If yes:

> run the indented code.

If no:

> skip it.

---

## Structural Breakdown

```text
if score >= 100:
 └──────────── question

 print("You win!")
 └──────────── action when True
```

---

# 05.4 If-Else

## Skills

- **writes_if_else_structure**
- **predicts_exclusive_branch**
- **matches_else_to_if**
- **uses_else_for_remaining_case**
- **traces_if_else**
- **designs_two_outcome_decision**

---

## Conceptual Bridge

Two doors:

```text
Is the password correct?

YES → unlock
NO → show error
```

Exactly one path should run.

---

## Adaptive Question Targets

- Write a question predicting which branch runs.
- Write a question completing an if/else structure.
- Write a question identifying incorrect indentation.
- Write a question asking when `else` is appropriate.
- Write a debugging question where both outcomes are incorrectly implemented as separate conditions.

---

# 05.5 Elif

## Skills

- **writes_elif_branch**
- **distinguishes_elif_from_separate_if**
- **traces_first_matching_branch**
- **orders_conditions_correctly**
- **uses_else_as_fallback**
- **designs_multiway_decision**

---

## Conceptual Bridge

Think of a grading scale checked from the top downward.

```text
90+? → A
80+? → B
70+? → C
...
```

Once one condition matches:

> Python stops checking the remaining branches in that chain.

---

## Important Misconception

This ordering creates a logic problem:

```python
if grade >= 60:
 print("Passing")
elif grade >= 90:
 print("A")
```

A grade of:

```text
95
```

already satisfies:

```text
grade >= 60
```

so Python never reaches the later `elif`.

This is a **branch-order reasoning problem**, not a syntax problem.

---

# 05.6 Nested Conditionals

## Skills

- **recognizes_nested_conditional**
- **tracks_indentation_levels**
- **traces_nested_decision**
- **writes_nested_conditional**
- **distinguishes_nested_from_compound_condition**
- **selects_nesting_when_second_question_depends_on_first**

---

## Conceptual Bridge

Think:

```text
building
↓
classroom
↓
desk
```

A question about the desk may only matter after the student has entered the correct classroom.

Similarly:

> A second decision may only matter after the first condition is satisfied.

---

# 05.7 Reading Conditional Code

## Skills

- **traces_conditional_flow**
- **evaluates_conditions_separately**
- **predicts_conditional_output**
- **identifies_unreachable_branch**
- **identifies_missing_case**
- **debugs_conditional_operator**
- **debugs_conditional_structure**
- **explains_branch_choice**

---

# Code Stepper Expansion

The Code Stepper should now display:

```text
Current line

Variables

Condition
→ True / False

Chosen branch

Skipped branch

Output
```

Students should increasingly predict:

> Which branch will Python choose?

before pressing Step.

---

# Conditional Trace Routine

Teach:

1. Record current variable values.
2. Evaluate the first relevant condition.
3. Write `True` or `False`.
4. Follow only the branch Python follows.
5. Continue through the structure.
6. State final output/state.

---

# Unit 05 Project: Decision-Based Quiz

## Required Skills

Students should:

- capture user input
- compare responses
- use `if`
- use `if/else`
- use `elif`
- update score/state
- use at least one compound condition
- produce clear feedback

---

## Stretch Opportunities

Students may add:

- question categories
- multiple endings
- personality/result profiles
- randomized questions later
- validation
- replay
- weighted scoring
- difficulty settings

---

# UNIT 06: Loops & Repetition

*GMetrix tie-in: Domain 2 Objective 2.2 Iteration.*

Relevant concepts include:

- `while`
- `for`
- `break`
- `continue`
- `pass`
- nested loops
- compound loop conditions

## Game / UX Tie-In

Loops power:

- game update cycles
- animation
- repeated input
- timers
- inventories
- repeated calculations
- simulations
- menus
- validation
- repeated actions

The video-game industry literally uses the term:

> **game loop**

---

# Unit Conceptual Goal

Students understand a loop as:

> repeated execution controlled by a rule.

Use four questions throughout the unit:

## 1. What repeats?

## 2. What causes it to repeat?

## 3. What changes each time?

## 4. What causes it to stop?

---

# 06.1 Why Loops Matter

## Skills

- **recognizes_repetitive_code**
- **explains_loop_purpose**
- **identifies_repeated_action**
- **identifies_repetition_rule**
- **distinguishes_loop_from_single_execution**
- **predicts_repeated_output**

---

## Conceptual Bridge

Instead of writing:

```python
print("Jump")
print("Jump")
print("Jump")
print("Jump")
print("Jump")
```

tell the computer:

> Perform this action five times.

Analogy:

If someone needs to stamp 100 sheets of paper, you would not verbally say:

> Stamp paper one.

then separately:

> Stamp paper two.

You would give:

> one repeated instruction.

---

# 06.2 While Loops

## Skills

- **writes_while_loop**
- **identifies_while_condition**
- **predicts_while_entry**
- **traces_while_iterations**
- **updates_loop_state**
- **predicts_while_termination**
- **detects_infinite_loop**
- **repairs_infinite_loop**
- **selects_while_for_unknown_repetitions**

---

## Conceptual Bridge

Phone charging:

> **While** the battery is below 100%, keep charging.

The number of repetitions is not known in advance.

The **condition** decides when the process stops.

---

# Code Stepper Priority Lesson

Example:

```python
count = 1

while count <= 3:
 print(count)
 count = count + 1
```

The stepper should make this cycle visible:

```text
check condition
↓
execute body
↓
change count
↓
jump back
↓
check condition again
```

---

## Trace Example

| Check | count before | condition | output | count after |
|---:|---:|---|---:|---:|
| 1 | 1 | True | 1 | 2 |
| 2 | 2 | True | 2 | 3 |
| 3 | 3 | True | 3 | 4 |
| 4 | 4 | False | none | stop |

---

## Infinite Loops

Students should explicitly learn:

A `while` loop can run forever when:

> the condition never becomes false.

Assess:

- recognizing the problem
- identifying the state that should change
- repairing the update

---

# 06.3 For Loops

## Skills

- **writes_for_loop**
- **identifies_iteration_variable**
- **identifies_iterable**
- **predicts_for_iterations**
- **tracks_iteration_value**
- **uses_iteration_value_in_body**
- **iterates_over_string**
- **selects_for_loop_for_sequence**

---

## Conceptual Bridge

Taking attendance:

> For each student on the roster, call that student's name.

Example:

```python
for student in roster:
```

means conceptually:

> Get the next student, temporarily refer to that value as `student`, and run the indented code.

---

# 06.4 Range

## Skills

- **uses_range_stop**
- **predicts_range_sequence**
- **recognizes_exclusive_stop**
- **uses_range_start_stop**
- **uses_range_step**
- **counts_loop_iterations**
- **creates_counting_pattern**
- **creates_countdown**
- **selects_range_for_repetition_count**

---

# Conceptual Connection to Slicing

The stop value is not included.

Example:

```python
range(0, 5)
```

represents:

```text
0 1 2 3 4 |5
 stop
```

Connect this to the same exclusive-end model introduced in slicing.

---

# 06.5 Loop Patterns

## Skills

- **uses_counter_pattern**
- **uses_accumulator_pattern**
- **uses_repeated_input_pattern**
- **uses_sentinel_pattern**
- **uses_validation_loop**
- **distinguishes_counter_from_accumulator**
- **initializes_loop_variable_correctly**
- **updates_loop_variable_correctly**
- **selects_loop_pattern_for_problem**

---

## Counter Analogy

A counter behaves like tally marks.

```python
count = count + 1
```

means:

> One more thing happened.

---

## Accumulator Analogy

An accumulator behaves like a scoreboard.

```python
total = total + points
```

means:

> Keep the old total and add the newest points.

---

## Important Distinction

```python
total = number
```

replaces the previous total.

```python
total = total + number
```

accumulates.

This should receive explicit practice.

---

# 06.6 Break

## Skills

- **uses_break**
- **predicts_break_behavior**
- **distinguishes_break_from_condition_failure**
- **uses_conditional_break**
- **identifies_code_skipped_after_break**
- **selects_break_for_early_exit**

---

## Conceptual Bridge

`break` is an emergency exit.

The normal repetition could continue, but:

> a special condition causes an immediate exit.

---

# 06.7 Continue

## Skills

- **uses_continue**
- **predicts_continue_behavior**
- **distinguishes_continue_from_break**
- **uses_conditional_continue**
- **traces_iteration_after_continue**

---

## Conceptual Bridge

Checking a stack of assignments:

If one belongs to the wrong class:

> skip that paper and move to the next one.

That is:

```python
continue
```

If a fire alarm occurs and the entire task ends:

```python
break
```

This analogy helps distinguish the two.

---

# 06.8 Pass

## Skills

- **recognizes_pass_statement**
- **uses_pass_placeholder**
- **distinguishes_pass_from_continue**
- **distinguishes_pass_from_break**
- **predicts_pass_behavior**

---

## Conceptual Bridge

`pass` is like a sticky note:

> Fill this part in later.

It does not:

- stop the loop
- skip the iteration
- jump somewhere else

It gives Python a valid placeholder statement.

---

## Teaching Note

Keep this lesson comparatively brief.

`pass` is certification-relevant but should not receive the same conceptual weight as:

- `while`
- `for`
- state tracking
- loop tracing

---

# 06.9 Nested Loops

## Skills

- **recognizes_nested_loop**
- **distinguishes_outer_inner_loop**
- **traces_nested_iterations**
- **predicts_nested_iteration_count**
- **uses_nested_loops_for_grid**
- **tracks_multiple_loop_variables**
- **writes_simple_nested_loop**

---

## Conceptual Bridge

School schedule:

```text
Monday
 Period 1
 Period 2
 Period 3

Tuesday
 Period 1
 Period 2
 Period 3
```

For every school day:

> repeat the class-period cycle.

The inner repetition completes inside every outer iteration.

---

## Additional Visual

Grid:

> For each row, visit every column.

This prepares students for:

- grids
- game boards
- tables
- two-dimensional data
- later game programming concepts

---

# Code Stepper for Nested Loops

Use clear nesting depth.

Show:

```text
outer loop
 inner loop
 inner loop
 inner loop
outer loop advances
 inner loop starts again
```

Students should be able to see:

> the inner loop completes before the outer loop advances again.

---

# 06.10 Reading Loop Traces

## Skills

- **traces_loop_state**
- **evaluates_loop_condition_each_time**
- **predicts_loop_output**
- **counts_iterations**
- **identifies_initialization_condition_update**
- **traces_compound_loop_condition**
- **detects_off_by_one_error**
- **detects_infinite_loop_from_trace**
- **debugs_loop_logic**
- **explains_loop_termination**

---

# Required Learning Progression

## Stage 1

Watch the Code Stepper.

## Stage 2

Predict the next highlighted line.

## Stage 3

Predict the next variable value.

## Stage 4

Complete part of a trace table.

## Stage 5

Create the trace table.

## Stage 6

Trace unfamiliar code without the interactive stepper.

---

# Trace Structure

Students should become comfortable with tables such as:

| Iteration | value before | condition | action/output | value after |
|---:|---:|---|---|---:|
| 1 | 0 | True | +10 | 10 |
| 2 | 10 | True | +10 | 20 |
| 3 | 20 | True | +10 | 30 |
| Check | 30 | False | stop | 30 |

---

# Off-by-One Errors

Students should learn to recognize loops that run:

> one too many

or:

> one too few

times.

These are common logic errors and should be deliberately included in:

- adaptive practice
- debugging
- Code Stepper examples

---

# Compound Loop Conditions

Students should trace conditions using:

```python
and
or
```

Example:

```python
while lives > 0 and score < 100:
```

Students should determine:

- each individual comparison
- the combined Boolean result
- whether another iteration occurs

---

# Unit 06 Project: Number Guessing Game

## Required Skills

Students should:

- create or use a target value
- capture repeated guesses
- convert guesses to numeric type
- use a `while` loop
- compare guess and target
- provide high/low feedback
- maintain an attempt counter
- update loop state
- terminate correctly
- produce readable output

---

## Project Assessment

Do not assess only:

> Does the game work?

Assess independently:

1. Does user input repeat?
2. Is numeric conversion correct?
3. Are comparisons correct?
4. Does high/low feedback work?
5. Does state update each iteration?
6. Does the loop terminate?
7. Can the student explain why it terminates?
8. Can the student trace an example run?

---

## Stretch Opportunities

Students may add:

- randomized target
- attempt limit
- compound loop conditions
- difficulty levels
- scoring based on attempts
- replay
- best score
- hints
- input validation
- additional game modes

---

# NEXT DEVELOPMENT SECTION

Units 07 and beyond should be added **below this point** as they are reviewed.

For each new unit:

1. verify the unit against the existing FoxCS course plan and certification objectives,
2. identify discrete assessable skills,
3. identify conceptual prerequisites from previous units,
4. identify common misconceptions,
5. create relatable teaching analogies where useful,
6. define adaptive-practice question families,
7. determine where the Code Stepper or another interactive component is useful,
8. define coding exercises,
9. define mastery-check coverage,
10. define the unit project and required/stretch skills,
11. assign recommended pacing markers,
12. extend the course-wide conceptual progression near the top of this document.

Do not create a separate course-map document for later units.

Continue extending this master document until it represents the **complete FoxCS Python course**.

````
# UNIT 07: Functions

*GMetrix tie-in: Domain 4 only.*

Relevant certification content includes:

- call signatures
- default values
- `return`
- `def`
- `pass` inside function definitions
- documentation strings

GMetrix alignment comes primarily from Domain 4, Lesson 2, Objective 4.2, with documentation strings from Lesson 1, Objective 4.1.4.

## Game / UX Tie-In

Functions are reusable behaviors.

In a game, actions such as:

```python
jump()
attack()
take_damage()
heal()
```

can be represented as functions.

Functions allow a mechanic to exist as a reusable system instead of rewriting the same instructions every time the behavior is needed.

---

## Journal

**Recommended length: 100-150 words**

If a character in your favorite game were built with functions, name three functions it might need, such as:

```python
jump()
attack()
heal()
```

For one of those functions:

- describe what the function would do,
- identify any information it would need as parameters,
- and explain what it might return or change.

---

## Unit Conceptual Goal

Students understand that functions allow programmers to:

- group related instructions,
- give a behavior a meaningful name,
- reuse behavior,
- provide information to a function,
- receive information back from a function,
- reduce unnecessary repetition,
- organize larger programs into manageable pieces.

A major conceptual shift in this unit is:

> Writing a function and running a function are two different actions.

Students should also learn that execution may temporarily leave the normal top-to-bottom flow when a function is called and then return to the calling location afterward.

---

# 07.1 Why Functions Matter

## Lesson Goal

Students recognize when a group of instructions represents a reusable task and understand why programmers organize behaviors into functions.

---

## Skills

- **recognizes_reusable_behavior** - Identifies code or behavior that would reasonably belong in a reusable function.
- **explains_function_purpose** - Explains that a function groups instructions into a named reusable behavior.
- **distinguishes_function_from_repeated_code** - Recognizes when repeated instructions could be replaced by one reusable function.
- **chooses_meaningful_function_name** - Selects a clear action-oriented name for a function.

---

## Conceptual Understanding

A function is not just:

> code with a `def` in front of it.

It represents:

> one meaningful job the program knows how to perform.

Examples:

```text
jump
calculate_damage
display_score
heal_player
```

Students should begin thinking about programs as:

> collections of behaviors

rather than one long sequence of unrelated instructions.

---

## Mental Model: Game Abilities

A game character may have an ability called:

> Jump

The player does not manually specify:

1. increase vertical velocity,
2. update animation,
3. play sound,
4. change movement state.

The player activates:

```python
jump()
```

The meaningful name represents the larger behavior.

This is similar to how functions allow programmers to hide several implementation steps behind one meaningful action.

---

## Common Misconceptions

Students may believe:

- functions are only useful when code repeats exactly,
- every line of code should become its own function,
- function names describe data rather than actions,
- functions automatically run when written,
- more functions always means better code.

Emphasize:

> A useful function normally represents one meaningful responsibility.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify repeated behavior that could become a function,
- choose the clearest function name for a described task,
- compare repeated code with a function-based solution,
- explain why a function could make a program easier to understand,
- identify when code represents one responsibility versus several unrelated responsibilities.

---

## Coding Exercise

### Reusable Messages

Give students a short program that prints the same multi-line message several times.

Ask students to:

1. identify the repeated behavior,
2. move that behavior into a function,
3. give the function a meaningful name,
4. use the function wherever the behavior is needed.

Starter code may be provided.

---

## Mastery Check Coverage

Students should demonstrate that they can:

- recognize reusable behavior,
- explain why functions are useful,
- choose a reasonable function name,
- identify an appropriate responsibility for one function.

---

## Project Connection

Students will eventually build several related functions for the Unit 07 Function Toolkit.

---

# 07.2 Defining Functions

## Lesson Goal

Students learn the syntax and structure used to define a Python function.

---

## Skills

- **writes_function_definition** - Writes a basic function using `def`, a valid name, parentheses, colon, and indented body.
- **identifies_function_structure** - Identifies the name, header, and body of a function.
- **uses_function_indentation** - Correctly indents statements belonging to the function.
- **recognizes_definition_does_not_execute** - Understands that defining a function does not automatically run its body.
- **uses_pass_in_function_placeholder** - Uses `pass` when a function definition intentionally needs a temporary empty body.

---

## Core Syntax

```python
def greet():
 print("Hello!")
```

Break it apart:

```text
def
↓
Python is defining a function

greet
↓
function name

()
↓
information can eventually be received here

:
↓
the function body is beginning

 print("Hello!")
↓
indented instructions that belong to the function
```

---

## Important Concept

This code:

```python
def greet():
 print("Hello!")
```

does **not** automatically print:

```text
Hello!
```

Python has learned:

> what `greet()` means.

The program has not yet been told:

> run `greet()`.

That distinction should be established before function calls are introduced.

---

## `pass` in Functions

Students already encountered:

```python
pass
```

in Unit 06.

Revisit it here as a valid placeholder:

```python
def calculate_score():
 pass
```

This allows the programmer to define the structure now and add the implementation later.

Do not treat this as a major new concept.

---

## Common Misconceptions

- forgetting `def`
- forgetting parentheses
- forgetting the colon
- not indenting the body
- assuming the function runs immediately
- writing spaces in a function name
- confusing variable naming and function naming conventions

---

## Read → Identify → Test → Revise → Ask

Provide broken function definitions.

Students should:

1. **Read** the definition and error.
2. **Identify** the structural problem.
3. **Test** one correction.
4. **Revise** if another problem remains.
5. **Ask** a specific question if needed.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify the parts of a function definition,
- complete a function header using code dropdowns,
- identify a missing colon,
- repair incorrect indentation,
- determine whether defining a function produces output,
- write a simple no-parameter function.

---

## Coding Exercise

### Create Three Actions

Students create:

```python
def show_title():
 ...

def show_instructions():
 ...

def show_goodbye():
 ...
```

Each function should have one clear responsibility.

The functions may be defined but calls can be added in the next lesson.

---

## Mastery Check Coverage

Students should independently:

- recognize function-definition syntax,
- construct a valid function,
- identify its body,
- explain whether the body runs immediately,
- repair a basic definition error.

---

# 07.3 Calling Functions

## Lesson Goal

Students understand that defining a function creates reusable behavior while calling the function causes that behavior to execute.

---

## Skills

- **calls_function** - Calls a previously defined function using its name and parentheses.
- **distinguishes_definition_from_call** - Distinguishes where a function is defined from where it is executed.
- **traces_function_execution** - Follows execution from the calling line into the function body and back.
- **predicts_multiple_calls** - Predicts behavior when the same function is called more than once.
- **identifies_call_order** - Determines the order in which multiple function calls occur.

---

## Core Distinction

Definition:

```python
def cheer():
 print("Go!")
```

Call:

```python
cheer()
```

Teach students to say:

> `def` teaches Python what the function does.

> A function call tells Python to do it now.

---

# Code Stepper Expansion: Function Calls

This is a major Code Stepper lesson.

Example:

```python
def cheer():
 print("Go!")

print("Start")
cheer()
print("Finish")
```

The Code Stepper should show:

```text
print("Start")
↓
cheer()
↓
jump to function body
↓
print("Go!")
↓
function finishes
↓
return to the line after cheer()
↓
print("Finish")
```

Students should visibly see that function execution temporarily changes location.

---

## Prediction Progression

### Stage 1

Watch the stepper enter and exit a function.

### Stage 2

Before stepping:

> Which line will Python execute next?

### Stage 3

Students trace multiple calls independently.

---

## Common Misconceptions

Students may:

- define a function but never call it,
- call a function before understanding which definition it uses,
- believe the function body runs only once,
- believe execution continues from the bottom of the function file rather than returning to the calling location,
- forget parentheses when calling.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify the line that calls a function,
- distinguish a definition from a call,
- predict output order,
- determine how many times a function runs,
- identify where execution resumes after a function finishes,
- debug a program where a function is defined but never called.

---

## Coding Exercise

### Reusable Game Messages

Students define and call functions such as:

```python
show_welcome()
show_level_start()
show_game_over()
```

Require at least one function to be called more than once.

---

## Mastery Check Coverage

Students should demonstrate:

- correct function calling,
- definition/call distinction,
- output prediction,
- execution-order tracing,
- understanding of repeated calls.

---

# 07.4 Parameters and Arguments

## Lesson Goal

Students understand how a function can receive information so the same behavior can work with different values.

---

## Skills

- **defines_parameter** - Adds a parameter to a function definition.
- **passes_argument** - Provides an argument when calling a function.
- **distinguishes_parameter_from_argument** - Distinguishes the placeholder in a definition from the actual supplied value.
- **tracks_parameter_value** - Determines what value a parameter contains during a specific function call.
- **uses_multiple_parameters** - Defines and calls a function requiring more than one piece of information.
- **selects_needed_parameters** - Identifies information that should be supplied rather than hardcoded.

---

## Core Example

```python
def greet(name):
 print(f"Hello, {name}!")

greet("Maya")
```

Explain:

```text
name
↓
PARAMETER
placeholder defined by the function

"Maya"
↓
ARGUMENT
actual value supplied during this call
```

During this call:

```text
name = "Maya"
```

---

## Mental Model: Customizable Ability

Imagine:

```python
attack(enemy)
```

The behavior is:

> attack something.

The function needs additional information:

> Which enemy?

That information is supplied when the function is called.

---

## Multiple Parameters

Example:

```python
def show_damage(player, damage):
 print(f"{player} took {damage} damage.")
```

Call:

```python
show_damage("Alex", 15)
```

Students should trace:

```text
player = "Alex"
damage = 15
```

---

## Common Misconceptions

- using parameter and argument as interchangeable terms without understanding the distinction,
- forgetting to supply an argument,
- supplying arguments in the wrong order,
- hardcoding values that should vary,
- believing a parameter keeps its value permanently after the function ends.

---

# Code Stepper

When entering the function, show:

```text
Call:
greet("Maya")

Parameter setup:
name = "Maya"
```

Then execute the function body.

This makes argument-to-parameter transfer visible.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify a parameter,
- identify an argument,
- predict a parameter's value during a specific call,
- complete a function call,
- match several arguments to their parameters,
- decide which information should become a parameter instead of being hardcoded,
- debug a missing or incorrectly ordered argument.

---

## Coding Exercise

### Personalized Player Status

Create a function such as:

```python
def show_status(player_name, health):
 ...
```

Call it several times with different values.

---

## Mastery Check Coverage

Students should demonstrate:

- parameter definition,
- argument passing,
- parameter/argument distinction,
- value tracking,
- basic multiple-parameter use.

---

# 07.5 Return Values

## Lesson Goal

Students understand that a function can produce a value for the rest of the program to use.

---

## Skills

- **uses_return_statement** - Returns a value from a function.
- **distinguishes_return_from_print** - Explains the difference between displaying a value and giving a value back to the program.
- **captures_return_value** - Stores a returned value in a variable.
- **uses_return_value** - Uses a returned value in later code or another expression.
- **traces_return_flow** - Traces the returned value from the function back to the calling expression.
- **recognizes_return_ends_function** - Recognizes that execution of that function call ends when an unconditional `return` executes.

---

# Critical Concept: `print()` vs `return`

Compare:

```python
def add(a, b):
 print(a + b)
```

with:

```python
def add(a, b):
 return a + b
```

The first:

> displays a result.

The second:

> gives a result back to the part of the program that called the function.

---

## Mental Model: Giving Something Back

A cashier might announce:

> Your total is $12.

That is similar to displaying information.

But if another part of the process needs to use the total, the value needs to be handed back.

That is the role of:

```python
return
```

---

# Code Stepper Return Flow

For:

```python
def add(a, b):
 return a + b

total = add(5, 7)
```

show:

```text
call add(5, 7)
↓
a = 5
b = 7
↓
calculate 12
↓
return 12
↓
replace add(5, 7) with 12
↓
total = 12
```

This replacement model is particularly useful.

Students can think:

> The function call becomes the value it returns.

---

## Common Misconceptions

- using `print()` when the program needs a reusable value,
- expecting `print()` to return the displayed value,
- returning a value but never storing or using it,
- believing code after an unconditional `return` will still execute,
- confusing the function's calculation with the calling variable.

---

## Adaptive Question Targets

Write question families that ask students to:

- distinguish `print()` and `return`,
- predict a returned value,
- determine the value stored after a function call,
- complete a function with an appropriate return statement,
- use a returned value in another expression,
- identify unreachable code after an unconditional return,
- debug a function that prints when it needs to return.

---

## Coding Exercise

### Damage Calculator

Create:

```python
def calculate_damage(base_damage, multiplier):
 ...
```

The function must **return** the calculated damage.

The calling code then stores and prints that returned value.

---

## Mastery Check Coverage

Students should demonstrate:

- return syntax,
- print/return distinction,
- returned-value tracing,
- capturing a return value,
- using a return value elsewhere.

---

# 07.6 Variable Scope

## Lesson Goal

Students understand that variables created inside a function normally belong to that function's local working space.

---

## Skills

- **recognizes_local_variable** - Identifies a variable created inside a function as local to that function.
- **recognizes_parameter_as_local** - Understands that parameters act as local names during a function call.
- **distinguishes_local_and_outer_scope** - Determines whether a variable is available inside or outside a function in straightforward examples.
- **predicts_scope_access** - Predicts whether a variable name can be used at a particular location.
- **debugs_basic_scope_error** - Identifies and repairs code that incorrectly relies on a local variable outside its function.

---

## Conceptual Model: Function Workspace

Treat each function call as having its own temporary workspace.

Example:

```python
def calculate_score():
 bonus = 10
 print(bonus)
```

`bonus` belongs to the function's workspace.

When the function finishes, code outside should not assume that the local name is available.

---

## Code Stepper Scope Display

When entering a function, the Code Stepper should show a separate panel:

```text
Function: calculate_score

Local Variables
bonus = 10
```

When execution leaves the function, the local workspace closes.

---

## Teaching Boundary

Keep this lesson introductory.

Do not make this a deep lesson on:

- `global`,
- closures,
- namespaces,
- LEGB lookup rules.

The immediate goal is understanding:

> variables inside a function may not be available everywhere else.

---

## Common Misconceptions

- assuming every variable is global,
- attempting to use a local variable after the function ends,
- assuming parameters permanently exist after the call,
- confusing two variables with the same name in different scopes.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify a local variable,
- determine where a variable can be accessed,
- identify which variables are parameters/local values,
- predict whether a line will successfully access a name,
- debug a straightforward scope problem.

---

## Coding Exercise

### Fix the Missing Result

Provide code where a useful calculated value exists only locally.

Students must determine whether the function should:

- print it,
- return it,
- or use it inside the function.

This reinforces both scope and `return`.

---

## Mastery Check Coverage

Students should demonstrate:

- local-variable recognition,
- parameter scope,
- basic access reasoning,
- scope-related debugging.

---

# 07.7 Default Parameters

## Lesson Goal

Students understand that parameters can provide a default value used when the caller does not supply a replacement.

---

## Skills

- **defines_default_parameter** - Defines a parameter with a default value.
- **uses_default_argument** - Predicts and uses the default when an argument is omitted.
- **overrides_default_argument** - Supplies another value when calling the function.
- **distinguishes_required_and_optional_parameters** - Identifies which information must be supplied and which has a default.
- **selects_reasonable_default** - Chooses a default that makes sense for a described function.

---

## Example

```python
def attack(damage=10):
 print(f"You deal {damage} damage.")
```

Call:

```python
attack()
```

uses:

```text
damage = 10
```

Call:

```python
attack(25)
```

uses:

```text
damage = 25
```

---

## Mental Model

A default represents:

> what the function should use when the caller does not make another choice.

Examples:

- starting lives = 3
- normal damage = 10
- default difficulty = `"normal"`

---

## Common Misconceptions

- thinking a default can never be replaced,
- thinking optional parameters must always be supplied,
- confusing default values with returned values,
- forgetting which parameters are required.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify a default parameter,
- predict a call that omits the optional argument,
- predict a call that overrides the default,
- distinguish required and optional parameters,
- select a reasonable default for a described behavior,
- construct a function containing a default value.

---

## Coding Exercise

### Configurable Greeting

Create a function such as:

```python
def greet_player(name, greeting="Welcome"):
 ...
```

Call it:

- using the default,
- overriding the default.

---

## Mastery Check Coverage

Students should demonstrate:

- default syntax,
- default-use prediction,
- overriding a default,
- required/optional distinction.

---

# 07.8 Call Signatures

## Lesson Goal

Students learn to read a function definition as a guide to how that function may be called.

---

## Skills

- **reads_call_signature** - Uses a function definition to determine what information a call requires.
- **matches_arguments_to_parameters** - Determines which supplied values map to which parameters.
- **identifies_valid_function_call** - Distinguishes valid and invalid calls.
- **diagnoses_argument_count_error** - Recognizes calls with missing or excessive required arguments.
- **constructs_valid_function_call** - Writes a call that matches the function signature.

---

## Core Question

Given:

```python
def create_player(name, level=1):
```

ask:

> How can this function legally be called?

Valid:

```python
create_player("Alex")
```

Valid:

```python
create_player("Alex", 5)
```

Missing required information:

```python
create_player()
```

---

## Mental Model

The function definition acts like an instruction label:

```text
create_player(name, level=1)
```

which tells another programmer:

```text
Required:
name

Optional:
level
Default:
1
```

---

## Adaptive Question Targets

Write question families that ask students to:

- identify required parameters,
- identify optional parameters,
- match positional arguments to parameters,
- select all valid function calls,
- diagnose a missing argument,
- diagnose too many arguments,
- construct a valid call from a signature.

Code dropdowns are particularly useful here.

---

## Coding Exercise

### Use the API

Provide several already-written functions.

Students are **not allowed to edit the definitions**.

They must read each signature and write valid calls that produce required results.

This reinforces the idea that programmers often use functions written by someone else.

---

## Mastery Check Coverage

Students should demonstrate:

- signature interpretation,
- required/optional recognition,
- argument mapping,
- valid call construction,
- basic argument-count debugging.

---

# 07.9 Docstrings

## Lesson Goal

Students understand that functions should communicate what they are meant to do, especially when another programmer may need to use them.

---

## Skills

- **recognizes_docstring** - Identifies a documentation string inside a function.
- **writes_function_docstring** - Writes a concise docstring describing a function's purpose.
- **documents_inputs_and_output** - Describes important parameters and returned information when appropriate.
- **distinguishes_docstring_from_comment** - Recognizes that docstrings document the function as a usable component.
- **uses_docstring_to_understand_function** - Uses documentation to determine how an unfamiliar function should be used.

---

## Example

```python
def calculate_score(hits, misses):
 """Calculate a player's score using hits and misses."""
 return hits * 10 - misses * 2
```

---

## Conceptual Distinction

A normal comment may explain:

> Why did the programmer write this line?

A function docstring explains:

> What does this function do, and how should someone use it?

---

## Teaching Boundary

Students do not need professional-scale documentation conventions yet.

Focus on:

- purpose,
- important inputs,
- returned result when appropriate.

The exact GMetrix Pydoc exercise should be checked directly against the workbook during lesson authoring because the current course map flags its project-file pairing as unusual.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify a docstring,
- distinguish a docstring from a normal comment,
- choose the clearest function description,
- write a short docstring,
- determine what a function does using its documentation,
- identify missing or misleading documentation.

---

## Coding Exercise

### Document the Toolkit

Give students several functions with no documentation.

Students add concise docstrings that accurately describe each function.

---

## Mastery Check Coverage

Students should demonstrate:

- docstring recognition,
- purpose documentation,
- comment/docstring distinction,
- use of documentation to understand unfamiliar code.

---

# 07.10 Reading Function Code

## Lesson Goal

Students integrate the unit's concepts by tracing complete function-based programs.

---

## Skills

- **traces_function_call** - Follows execution from caller to function and back.
- **tracks_function_inputs** - Tracks arguments into parameter values.
- **tracks_local_state** - Tracks relevant local variables during function execution.
- **predicts_function_result** - Determines returned value or observable effect.
- **traces_multiple_functions** - Follows a program containing multiple function calls.
- **debugs_function_flow** - Identifies a logic or structure problem involving a function call.

---

# Code Stepper Priority Lesson

The Code Stepper should show:

```text
CALLING CODE
↓
function call
↓
parameter assignment
↓
local function execution
↓
return/effect
↓
back to calling location
↓
continue program
```

---

## Example

```python
def calculate_bonus(score):
 bonus = score // 10
 return bonus

player_score = 85
bonus_points = calculate_bonus(player_score)
final_score = player_score + bonus_points

print(final_score)
```

Students should trace:

```text
player_score = 85

calculate_bonus(85)
↓
score = 85
↓
bonus = 8
↓
return 8
↓
bonus_points = 8
↓
final_score = 93
```

---

## Read → Identify → Test → Revise → Ask

At this stage, troubleshooting prompts should provide less scaffolding.

Example:

> The program runs but produces the wrong final value. Trace the function call, identify where the state first differs from what you expected, and test one correction.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify which function executes next,
- predict parameter values,
- predict local variables,
- predict a returned value,
- determine where execution resumes,
- trace two connected functions,
- debug incorrect function flow.

---

## Coding Exercise

### Function Trace Challenge

Students receive a downloadable `.py` file containing several short functions.

They must:

1. predict the final output,
2. complete a trace,
3. run the program,
4. compare prediction and result,
5. revise any incorrect reasoning.

---

## Mastery Check Coverage

Students should independently demonstrate:

- function definition/call understanding,
- argument/parameter tracking,
- return-value reasoning,
- local-state tracking,
- call-order tracing,
- basic function debugging.

---

# Unit 07 Adaptive Review / Targeted Reteaching

Use skill-level evidence to distinguish needs such as:

- function syntax,
- definition vs call,
- parameter/argument reasoning,
- return vs print,
- scope,
- call signatures,
- execution tracing.

Do not assign the entire unit again when a student's difficulty is isolated.

---

# Unit 07 Mastery Expectations

By the end of the unit, students should be able to:

- define and call functions,
- organize code into meaningful reusable behaviors,
- use parameters and arguments,
- return and reuse values,
- distinguish local function state from outside state,
- use default parameters,
- read call signatures,
- document functions,
- trace function execution,
- debug basic function-related problems.

---

# Unit 07 Project: Function Toolkit

## Project Goal

Students build a reusable collection of functions that work together as one program.

The project begins with:

- a blank `.py` file,
- a requirements list,
- no prewritten implementation.

---

## Possible Framing

### Game Utility Toolkit

Possible functions may include:

```python
calculate_damage()
heal_player()
calculate_bonus()
display_status()
format_player_name()
```

The exact implementation should remain flexible.

---

## Required Skills

The project should require students to:

- define multiple functions,
- call each function appropriately,
- use meaningful function names,
- use parameters,
- use at least one returned value,
- use local variables appropriately,
- use at least one default parameter,
- include useful docstrings,
- combine multiple functions into one coherent program.

---

## Project Assessment

Assess separately:

1. Are functions divided into meaningful responsibilities?
2. Are function definitions syntactically correct?
3. Are functions called correctly?
4. Are parameters used appropriately?
5. Are return values used when information must leave a function?
6. Is local state handled appropriately?
7. Are names meaningful?
8. Is documentation useful?
9. Can the student explain how execution moves through the program?

---

## Stretch Opportunities

Students may:

- have one function call another function,
- add additional configurable parameters,
- refactor code from an earlier project into functions,
- create a simple text menu,
- build a more complete game-stat system,
- improve usability and output formatting.

---

# UNIT 08: Lists

*GMetrix tie-in: Domain 1 only.*

Relevant certification content includes:

- indexing,
- slicing,
- data structures,
- lists,
- list operations.

This unit completes much of Domain 1 Objective 1.2 that began earlier with type conversion.

Do not move Unit 10's formal containment-operator instruction into this unit. Students may naturally encounter familiar examples, but dedicated `in` / membership testing remains in Unit 10.

---

## Game / UX Tie-In

Lists are used for collections such as:

- inventories,
- leaderboards,
- enemy waves,
- decks of cards,
- dialogue queues,
- levels,
- scores.

Many game systems that manage:

> several related things in order

can be represented with lists.

---

## Journal

**Recommended length: 150-200 words**

Pick a game system that is essentially a list underneath, such as:

- an inventory,
- a leaderboard,
- a deck of cards,
- a quest list,
- an enemy wave,
- a level queue.

Describe:

1. what information is stored in the list,
2. why order matters or does not matter,
3. one action the player can take that changes the list,
4. how the game responds to that change.

---

## Unit Conceptual Goal

Students move from storing:

> one value in one variable

to organizing:

> many related values in one ordered collection.

Students should understand that:

- lists preserve order,
- each item has a position,
- positions can be used to access or change items,
- list contents can grow or shrink,
- lists work naturally with loops,
- slicing works with lists using the same conceptual model previously learned for strings.

---

# 08.1 Why Lists Matter

## Lesson Goal

Students recognize when several related values should be organized as one collection.

---

## Skills

- **recognizes_collection_need** - Identifies situations where several related values should be stored together.
- **explains_list_purpose** - Explains that a list stores an ordered collection of values.
- **distinguishes_single_value_from_collection** - Distinguishes a normal single value from a list containing several values.
- **selects_list_for_ordered_data** - Chooses a list when a problem requires a changing ordered collection.

---

## Conceptual Bridge: Inventory

Without a list:

```python
item1 = "Potion"
item2 = "Sword"
item3 = "Key"
item4 = "Map"
```

With a list:

```python
inventory = ["Potion", "Sword", "Key", "Map"]
```

The list communicates:

> These values belong together.

---

## Common Misconceptions

Students may believe:

- a list is simply a longer variable name,
- every item needs its own variable anyway,
- order does not matter,
- all collections behave exactly like strings,
- lists must contain only one data type.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify which scenario would benefit from a list,
- distinguish a single value from a collection,
- choose between separate variables and one list,
- explain why an inventory is naturally represented as a list,
- identify whether order matters in a described collection.

---

## Coding Exercise

### Organize the Inventory

Give students a program using several separate item variables.

Ask them to reorganize the related values into a list.

---

## Mastery Check Coverage

Students should demonstrate:

- list-purpose understanding,
- collection recognition,
- appropriate list selection,
- ordered-data reasoning.

---

# 08.2 Creating Lists

## Lesson Goal

Students create Python lists and recognize the syntax used to represent them.

---

## Skills

- **creates_list** - Creates a list using square brackets and comma-separated values.
- **creates_empty_list** - Creates an empty list that can receive values later.
- **recognizes_list_structure** - Identifies the brackets, items, and separators in a list.
- **stores_list_in_variable** - Assigns a list to a meaningful variable.
- **predicts_list_contents** - Determines what values a created list contains and in what order.

---

## Core Syntax

```python
inventory = ["Potion", "Sword", "Key"]
```

Breakdown:

```text
inventory
↓
variable holding the collection

[]
↓
list

"Potion", "Sword", "Key"
↓
items stored in order
```

---

## Empty Lists

```python
scores = []
```

An empty list means:

> The collection exists, but it currently contains no items.

This becomes important when values are added over time.

---

## Mixed Types

Python permits:

```python
example = ["Alex", 10, True]
```

Students should recognize this as valid Python.

However, discuss that collections are often easier to reason about when the items represent the same kind of thing.

---

## Common Misconceptions

- using parentheses instead of brackets,
- forgetting commas,
- forgetting quotes around text,
- assuming an empty list is the same as no variable,
- assuming lists can contain only strings.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify valid list syntax,
- construct a simple list,
- construct an empty list,
- identify list items in order,
- repair malformed list syntax,
- select an appropriate variable name for a collection.

---

## Coding Exercise

### Build a Playlist

Students create a list containing several song titles, game titles, or other age-appropriate items.

They print the list and explain its current order.

---

## Mastery Check Coverage

Students should demonstrate:

- list creation,
- empty-list creation,
- syntax recognition,
- ordered-content prediction.

---

# 08.3 Accessing Items

## Lesson Goal

Students use indexes to access individual values inside a list.

---

## Skills

- **identifies_list_index** - Determines the index of an item.
- **accesses_list_item** - Uses square-bracket indexing to retrieve an item.
- **applies_zero_based_indexing** - Correctly reasons about indexes beginning at 0.
- **distinguishes_index_from_value** - Distinguishes an item's position from the actual stored item.
- **uses_negative_index** - Uses basic negative indexing such as `-1` to access items from the end.
- **recognizes_invalid_index** - Identifies an index that lies outside the list.

---

# Connection to String Indexing

Students already encountered indexing with strings.

Use the same model.

String:

```text
P Y T H O N
0 1 2 3 4 5
```

List:

```text
Sword Potion Key Map
 0 1 2 3
```

The rule remains:

> Index 0 is the first item.

---

## Example

```python
inventory = ["Sword", "Potion", "Key", "Map"]

print(inventory[2])
```

Output:

```text
Key
```

---

## Negative Index

```python
inventory[-1]
```

means:

> last item.

Keep negative indexing basic at this stage.

---

## Common Misconceptions

- treating the first item as index 1,
- confusing index 2 with the second item,
- writing the item's value where an index is expected,
- accessing an index beyond the end of the list,
- forgetting brackets around the index.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify the index of an item,
- predict the item at a supplied index,
- retrieve an item using code,
- distinguish index from value,
- use `-1`,
- identify an invalid/out-of-range index,
- connect list indexing to previously learned string indexing.

---

## Coding Exercise

### Inventory Lookup

Students receive:

```python
inventory = ["Potion", "Key", "Map", "Shield", "Gem"]
```

They must print specific items using indexes rather than rewriting the item text.

---

## Mastery Check Coverage

Students should independently demonstrate:

- zero-based indexing,
- item retrieval,
- index/value distinction,
- basic negative indexing,
- out-of-range recognition.

---

# 08.4 Updating Items

## Lesson Goal

Students modify an existing list item by assigning a new value to a specific index.

---

## Skills

- **updates_list_item** - Replaces an existing item using index assignment.
- **selects_index_to_update** - Determines which index must change.
- **predicts_list_after_update** - Predicts the entire list after replacement.
- **distinguishes_update_from_addition** - Recognizes that replacing an item does not increase the list length.
- **debugs_wrong_index_update** - Identifies when the wrong position was changed.

---

## Example

```python
inventory = ["Sword", "Potion", "Key"]

inventory[1] = "Super Potion"
```

Result:

```python
["Sword", "Super Potion", "Key"]
```

---

## Mental Model: Numbered Slots

Imagine a set of numbered cubbies.

Updating:

```python
inventory[1] = "Super Potion"
```

means:

> Replace whatever is currently in slot 1.

It does not:

> create a new slot.

---

## Adaptive Question Targets

Write question families that ask students to:

- determine which index should be changed,
- predict a list after one update,
- complete an index-assignment statement,
- distinguish replacement from adding an item,
- debug a program that changes the wrong list position.

---

## Coding Exercise

### Equipment Upgrade

Students receive a simple equipment list and must replace several items using index assignment.

---

## Mastery Check Coverage

Students should demonstrate:

- correct index assignment,
- resulting-list prediction,
- replacement/addition distinction,
- basic update debugging.

---

# 08.5 Append

## Lesson Goal

Students add new values to the end of a list using `append()`.

---

## Skills

- **uses_append** - Adds one item to the end of a list.
- **predicts_append_result** - Predicts the list after appending.
- **distinguishes_append_from_update** - Determines whether a problem requires adding or replacing.
- **uses_append_with_generated_value** - Appends a value produced by input or another expression.
- **recognizes_append_changes_list** - Understands that `append()` modifies the existing list.

---

## Example

```python
inventory = ["Sword", "Potion"]

inventory.append("Key")
```

Result:

```python
["Sword", "Potion", "Key"]
```

---

## Conceptual Model

`append()` means:

> Add this as the new last item.

---

## Important Misconception

Students may attempt:

```python
inventory = inventory.append("Key")
```

This is not how `append()` should normally be used.

Teach the beginner-safe pattern:

```python
inventory.append("Key")
```

The existing list is modified.

Do not turn this into a deep lesson about `None`; explain only enough to prevent the common mistake.

---

## Connection to Loops

Example:

```python
scores = []

for round_number in range(3):
 score = int(input("Enter score: "))
 scores.append(score)
```

Students can now build a collection over time.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict where an appended item appears,
- predict the list after several appends,
- choose append versus index update,
- complete an append statement,
- append a value obtained from another expression,
- repair incorrect use of `append()`.

---

## Coding Exercise

### Build a Score List

Students begin with:

```python
scores = []
```

and add several scores to it.

Starter code may use input or supplied values.

---

## Mastery Check Coverage

Students should demonstrate:

- append syntax,
- end-position reasoning,
- append/update distinction,
- collection-building behavior.

---

# 08.6 Insert

## Lesson Goal

Students insert a new item at a chosen position while preserving the existing items.

---

## Skills

- **uses_insert** - Adds an item at a specific index using `insert()`.
- **selects_insert_index** - Chooses the position where a new item should appear.
- **predicts_insert_result** - Predicts the list after insertion.
- **recognizes_items_shift** - Understands that existing items move rather than being replaced.
- **distinguishes_insert_from_append** - Chooses insert or append based on desired position.

---

## Example

```python
players = ["Alex", "Sam", "Jordan"]

players.insert(1, "Maya")
```

Result:

```python
["Alex", "Maya", "Sam", "Jordan"]
```

---

## Mental Model: Joining a Line

If someone joins a line in position 1:

> the people after that position move back.

They are not deleted.

This makes `insert()` different from index assignment.

---

## Adaptive Question Targets

Write question families that ask students to:

- select an insertion index,
- predict the resulting list,
- identify which existing items shift,
- distinguish insert from append,
- distinguish insert from replacement,
- construct an `insert()` call.

---

## Coding Exercise

### Priority Queue

Students have a list of tasks or players.

They must insert a higher-priority item at a specified position.

---

## Mastery Check Coverage

Students should demonstrate:

- insertion syntax,
- position selection,
- shifting behavior,
- insert/append/update distinction.

---

# 08.7 Remove

## Lesson Goal

Students remove a list item by specifying its value.

---

## Skills

- **uses_remove** - Removes an item by value.
- **predicts_remove_result** - Predicts the list after removal.
- **distinguishes_value_from_index_removal** - Recognizes that `remove()` searches for a value rather than an index.
- **recognizes_first_matching_removal** - Understands that `remove()` removes the first matching value.
- **recognizes_missing_value_problem** - Predicts that attempting to remove an absent value creates a problem.

---

## Example

```python
inventory = ["Potion", "Key", "Potion", "Map"]

inventory.remove("Potion")
```

Result:

```python
["Key", "Potion", "Map"]
```

The **first** matching `"Potion"` is removed.

---

## Conceptual Model

`remove()` asks:

> Find this value and remove it.

It does not ask:

> Remove whatever is at this numbered position.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify which item `remove()` removes,
- predict the resulting list,
- reason about duplicate values,
- distinguish value removal from index-based removal,
- recognize a removal attempt using a value that is not present,
- construct a basic remove operation.

---

## Coding Exercise

### Remove an Inventory Item

Students remove specified items from a provided inventory.

Include at least one duplicated value so they observe first-match behavior.

---

## Mastery Check Coverage

Students should demonstrate:

- removal by value,
- resulting-list prediction,
- duplicate behavior,
- value/index distinction.

---

# 08.8 Pop

## Lesson Goal

Students remove an item by position and understand that `pop()` also produces the removed value.

---

## Skills

- **uses_pop** - Removes an item using `pop()`.
- **uses_pop_index** - Removes a specified indexed item.
- **recognizes_default_pop_last** - Understands that `pop()` without an index removes the final item.
- **captures_popped_value** - Stores or uses the value returned by `pop()`.
- **distinguishes_pop_from_remove** - Chooses value-based or position-based removal appropriately.

---

## Core Contrast

```python
inventory.remove("Potion")
```

means:

> Remove the value `"Potion"`.

```python
item = inventory.pop(0)
```

means:

> Remove the item at index 0 and give that removed value back.

---

## Mental Model: Drawing a Card

Imagine taking the top card from a deck.

The card:

- leaves the deck,
- but now exists in your hand.

Likewise:

```python
card = deck.pop()
```

changes the list and produces the removed item.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict which item `pop()` removes,
- predict the resulting list,
- predict the returned value,
- distinguish `remove()` and `pop()`,
- choose whether to provide an index,
- construct a call that stores the popped value.

---

## Coding Exercise

### Use an Item

Students model using an inventory item:

```python
used_item = inventory.pop(0)
```

Then display:

- which item was used,
- what remains in the inventory.

---

## Mastery Check Coverage

Students should demonstrate:

- default and indexed pop,
- return-value understanding,
- resulting-list prediction,
- pop/remove distinction.

---

# 08.9 Looping Through Lists

## Lesson Goal

Students combine lists with previously learned loops to process every item in a collection.

---

## Skills

- **iterates_through_list** - Uses a `for` loop to visit each list item.
- **tracks_current_list_item** - Identifies the current iteration value.
- **predicts_list_loop_output** - Predicts output produced across list iterations.
- **processes_each_list_item** - Applies an operation to each item.
- **combines_list_loop_with_condition** - Uses previously learned decision logic while iterating through a list.
- **distinguishes_item_from_list** - Distinguishes the entire collection from the temporary current item.

---

## Core Example

```python
inventory = ["Potion", "Key", "Map"]

for item in inventory:
 print(item)
```

Conceptually:

```text
Take first item
↓
item = "Potion"
↓
run body

Take next item
↓
item = "Key"
↓
run body

Take next item
↓
item = "Map"
↓
run body
```

---

# Code Stepper

Display:

```text
List:
["Potion", "Key", "Map"]

Current item:
"Potion"
```

Then advance the current item with each iteration.

This connects directly to Unit 06's loop tracing.

---

## Conditionals Inside List Loops

Example:

```python
scores = [85, 120, 95, 140]

for score in scores:
 if score >= 100:
 print(score)
```

Students now combine:

- collection,
- iteration,
- decision.

---

## Teaching Boundary

Do not overemphasize:

```python
for i in range(len(items)):
```

at this point unless the index is genuinely needed.

Prefer:

```python
for item in items:
```

when students only need the values.

This keeps the concept simpler and more Pythonic.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify the current item during each iteration,
- predict loop output,
- complete a list-based `for` loop,
- apply an operation to each item,
- combine a condition with list iteration,
- distinguish the list variable from the iteration variable.

---

## Coding Exercise

### High Score Filter

Students receive a list of scores and write a loop that displays scores meeting a specified condition.

Do not formally teach membership testing here.

---

## Mastery Check Coverage

Students should demonstrate:

- list iteration,
- current-item tracking,
- output prediction,
- processing every item,
- basic conditional integration.

---

# 08.10 List Slicing

## Lesson Goal

Students apply the slicing model learned with strings to ordered list collections.

---

## Skills

- **slices_list** - Extracts part of a list using slice syntax.
- **predicts_list_slice** - Determines the list produced by a slice.
- **applies_exclusive_slice_end** - Applies the established exclusive endpoint model.
- **uses_omitted_slice_boundary** - Uses omitted start or end positions.
- **uses_slice_step** - Uses a basic step value when appropriate.
- **connects_string_and_list_slicing** - Recognizes that the same slicing rules apply to strings and lists.

---

# Required Teaching Model

Do **not** introduce a new mental model.

Use the same:

> Cut before each index.

For:

```python
players[1:4]
```

students should interpret:

> Cut before index 1 and before index 4.

---

## Visual Example

```text
Alex Maya Sam Jordan Kai
 0 1 2 3 4
```

For:

```python
players[1:4]
```

visualize:

```text
Alex | Maya Sam Jordan | Kai
 1 4
```

Result:

```python
["Maya", "Sam", "Jordan"]
```

---

## Connection to Unit 03

Explicitly remind students:

```text
String slicing
and
List slicing
```

follow the same indexing/slicing model.

This is deliberate retrieval practice rather than a brand-new concept.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict a basic list slice,
- identify slice boundaries,
- explain why the endpoint is excluded,
- write a slice for a specified subset,
- use an omitted boundary,
- use a basic step,
- compare string slicing and list slicing.

---

## Coding Exercise

### Leaderboard Views

Given a leaderboard list, students display:

- the first three players,
- everyone after a specified point,
- a selected middle section.

Formal sorting belongs in Unit 10, so provide the leaderboard already ordered.

---

## Mastery Check Coverage

Students should demonstrate:

- slice construction,
- slice prediction,
- exclusive endpoint understanding,
- omitted-boundary use,
- connection to prior string slicing.

---

# Unit 08 Adaptive Review / Targeted Reteaching

Use evidence to distinguish needs such as:

- list syntax,
- index reasoning,
- update vs add,
- append vs insert,
- remove vs pop,
- loop/list integration,
- slicing.

Particularly watch for students who understand the operation but struggle specifically with zero-based indexing.

---

# Unit 08 Mastery Expectations

By the end of the unit, students should be able to:

- create lists,
- access items,
- update items,
- append items,
- insert items,
- remove values,
- pop items,
- loop through lists,
- slice lists,
- reason about list state after mutations.

---

# Unit 08 Project: List Manager

## Project Goal

Students create a program that manages an ordered collection whose contents change over time.

The project begins from:

- a blank file,
- a requirements list.

---

## Possible Framing: Inventory Manager

Students may manage an inventory such as:

```python
["Potion", "Sword", "Map"]
```

The program should demonstrate several meaningful list operations.

The project may retain the generic title:

> List Manager

while using inventory as the recommended context.

---

## Required Skills

Students should:

- create a list,
- display list contents clearly,
- access a specific item,
- update an item,
- append an item,
- insert an item,
- remove an item appropriately,
- use `pop()` appropriately,
- loop through the list,
- produce at least one list slice.

---

## Project Assessment

Assess:

1. Is the list structured correctly?
2. Can the student access items using indexes?
3. Can the student replace an existing item?
4. Can the student add items appropriately?
5. Can the student distinguish append and insert?
6. Can the student distinguish remove and pop?
7. Can the student iterate through the collection?
8. Can the student slice the collection?
9. Can the student explain how the list changed during program execution?

---

## Stretch Opportunities

Students may add:

- a repeating menu using Unit 06,
- clearer usability and formatting,
- inventory capacity,
- duplicate-item handling,
- multiple categories,
- a simple selection interface,
- statistics using previously learned math.

Avoid requiring:

- formal membership testing,
- sorting,
- searching algorithms,

because those concepts have a deliberate home in Unit 10.

---

# UNIT 09: Working with Data Collections

*GMetrix hands-on tie-in: none.*

The GMetrix Domain 1 glossary includes terminology for:

- Dictionary,
- Set,
- Tuple Variable,

but the course materials do not provide dedicated hands-on exercises for tuples or dictionaries.

This unit should therefore be treated as **FoxCS-original instructional content**, with certification vocabulary used only as a terminology reference.

Sets are **not** added to this unit simply because they appear in the glossary. The current FoxCS course map intentionally focuses this unit on:

- tuples,
- dictionaries,
- nested data,
- data modeling.

---

## Game / UX Tie-In

Dictionaries represent structured game information.

Examples:

- player statistics,
- enemy statistics,
- item properties,
- save data,
- configuration information.

Unlike a list, where an item is primarily identified by its position, dictionary information can be identified by a meaningful name.

Example:

```python
player = {
 "name": "Alex",
 "health": 100,
 "level": 5
}
```

---

## Journal

**Recommended length: 150-200 words**

Design a simple dictionary that could represent:

- one item,
- one character,
- one enemy,
- or another game entity.

Include several meaningful key-value pairs.

Then explain:

1. what each key represents,
2. why the game or player needs that information,
3. why meaningful keys make the data easier to understand than a collection based only on numbered positions.

---

## Unit Conceptual Goal

Students understand that different types of information benefit from different organizational structures.

Students should increasingly ask:

> What shape should my data have?

rather than:

> Which syntax did the example use?

The unit introduces the distinction between:

```text
single value
ordered changing collection
ordered fixed grouping
named structured data
nested data
```

Students should learn to choose between:

- variables,
- lists,
- tuples,
- dictionaries

based on the structure of the problem.

---

# 09.1 Tuples

## Lesson Goal

Students understand tuples as ordered collections that are intended to remain fixed after creation.

---

## Skills

- **creates_tuple** - Creates a tuple using correct syntax.
- **accesses_tuple_item** - Retrieves tuple items using indexes.
- **recognizes_tuple_immutability** - Understands that tuple items cannot be replaced using normal index assignment.
- **distinguishes_tuple_from_list** - Compares the purposes of tuples and lists.
- **selects_tuple_for_fixed_group** - Chooses a tuple when related ordered values should remain fixed.

---

## Conceptual Bridge

Lists are useful when the collection itself may change.

Tuples are useful when a group of related values should stay together in a fixed structure.

Example:

```python
position = (125, 300)
```

This represents:

```text
x = 125
y = 300
```

Other relatable examples:

```python
rgb_color = (255, 120, 0)
birthday = (8, 24, 2010)
screen_size = (1920, 1080)
```

---

## Mental Model

A tuple can be introduced as:

> a packaged group of ordered values whose structure is meant to stay stable.

Avoid framing immutability only as:

> Python refuses to let you change it.

Students should understand **why** fixed data can be useful.

---

## Common Misconceptions

- assuming tuples and lists are interchangeable,
- attempting index assignment on a tuple,
- assuming tuples have no order,
- assuming tuple items cannot be accessed by index,
- choosing a tuple for data that needs frequent mutation.

---

## Adaptive Question Targets

Write question families that ask students to:

- distinguish tuple syntax from list syntax,
- access a tuple item,
- predict an indexed tuple value,
- identify why an attempted tuple update fails,
- choose list or tuple for a described situation,
- explain why a fixed group is appropriately represented as a tuple.

---

## Coding Exercise

### Coordinate Data

Students create several coordinate tuples and print selected x/y values using indexing.

Starter code may be used initially.

---

## Mastery Check Coverage

Students should demonstrate:

- tuple creation,
- tuple indexing,
- immutability understanding,
- list/tuple distinction,
- appropriate structure selection.

---

# 09.2 Tuple Unpacking

## Lesson Goal

Students assign the individual values from a tuple to meaningful variable names.

---

## Skills

- **unpacks_tuple** - Assigns tuple items to multiple variables in one statement.
- **matches_unpacking_positions** - Matches each tuple position to the correct variable.
- **predicts_unpacked_values** - Determines variable values after unpacking.
- **recognizes_unpacking_count_requirement** - Recognizes straightforward mismatches between the number of values and variables.
- **uses_unpacking_for_related_data** - Uses unpacking to make grouped information easier to work with.

---

## Core Example

```python
position = (125, 300)

x, y = position
```

Visualize:

```text
(125, 300)
 ↓ ↓
 x y
```

Afterward:

```text
x = 125
y = 300
```

---

## Conceptual Model

Before emphasizing the vocabulary **unpacking**, explain:

> Take the values out of their positions and give each one a useful name.

Then attach the formal term:

> Python calls this unpacking.

---

## Common Misconceptions

- reversing variable order,
- providing too few or too many variables,
- believing unpacking destroys the tuple,
- thinking the variable names must match some names already stored in the tuple.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict values after tuple unpacking,
- match tuple positions to variable names,
- complete an unpacking statement,
- identify a value-count mismatch,
- use unpacked variables in later code,
- explain why unpacking improves readability.

---

## Coding Exercise

### Player Position

Students receive:

```python
player_position = (250, 175)
```

They unpack it into:

```python
x
y
```

and produce readable position output.

---

## Mastery Check Coverage

Students should demonstrate:

- basic unpacking,
- positional reasoning,
- value prediction,
- mismatch recognition.

---

# 09.3 Dictionaries

## Lesson Goal

Students understand dictionaries as collections that associate meaningful keys with values.

---

## Skills

- **creates_dictionary** - Creates a dictionary using key-value pairs.
- **identifies_key_value_pair** - Distinguishes keys from their associated values.
- **accesses_dictionary_value** - Retrieves a value using its key.
- **distinguishes_dictionary_from_list** - Determines when named data is more appropriate than positional data.
- **uses_meaningful_dictionary_keys** - Chooses keys that clearly describe the stored information.

---

# Core Comparison: Position vs Meaning

List:

```python
player = ["Alex", 100, 5]
```

Question:

> What does index 1 represent?

A reader must already know the structure.

Dictionary:

```python
player = {
 "name": "Alex",
 "health": 100,
 "level": 5
}
```

Now:

```python
player["health"]
```

communicates what the data means.

---

## Mental Model: Profile Card

Think of a profile form:

```text
Name: Alex
Health: 100
Level: 5
```

The labels:

```text
Name
Health
Level
```

act like keys.

The information beside them acts like values.

---

## Common Misconceptions

- confusing braces with list brackets,
- confusing a key with its value,
- trying to access dictionary information by numeric position,
- forgetting quotes around string keys,
- using unclear key names.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify a key,
- identify its associated value,
- create a basic dictionary,
- retrieve a value using a key,
- distinguish list indexing from dictionary key access,
- select a meaningful key name,
- choose list versus dictionary for a described data problem.

---

## Coding Exercise

### Character Stats

Students create:

```python
player = {
 "name": ...,
 "health": ...,
 "level": ...
}
```

Then display individual values using keys.

---

## Mastery Check Coverage

Students should demonstrate:

- dictionary creation,
- key/value distinction,
- key access,
- meaningful-key use,
- list/dictionary structural reasoning.

---

# 09.4 Keys and Values

## Lesson Goal

Students inspect and work with the different parts of a dictionary.

---

## Skills

- **identifies_dictionary_keys** - Identifies the labels used to access dictionary data.
- **identifies_dictionary_values** - Identifies the information associated with keys.
- **uses_keys_method** - Uses `.keys()` when the program needs the keys.
- **uses_values_method** - Uses `.values()` when the program needs the values.
- **recognizes_items_as_key_value_pairs** - Recognizes `.items()` as representing paired keys and values.

---

## Example

```python
player = {
 "name": "Alex",
 "health": 100,
 "level": 5
}
```

Conceptually:

```text
KEY VALUE
"name" → "Alex"
"health"→ 100
"level" → 5
```

---

## Key Access

```python
player["health"]
```

asks:

> Give me the value associated with the key `"health"`.

---

## Methods

```python
player.keys()
```

focuses on:

> the labels.

```python
player.values()
```

focuses on:

> the stored values.

```python
player.items()
```

represents:

> each key together with its value.

Full `.items()` iteration will be practiced in 09.6.

---

## Common Misconceptions

- assuming keys and values are interchangeable,
- assuming dictionary keys are indexes,
- using a value to attempt key access,
- confusing `.keys()` and `.values()`.

---

## Adaptive Question Targets

Write question families that ask students to:

- distinguish keys from values,
- identify the value associated with a key,
- choose `.keys()` or `.values()` for a stated goal,
- recognize what `.items()` represents,
- predict the result of basic key access,
- debug incorrect key/value reasoning.

---

## Coding Exercise

### Inspect a Game Item

Students receive a dictionary representing an item.

They must display:

- selected values,
- the available keys,
- the stored values.

---

## Mastery Check Coverage

Students should demonstrate:

- key/value distinction,
- correct key lookup,
- `.keys()` use,
- `.values()` use,
- conceptual understanding of `.items()`.

---

# 09.5 Updating Dictionaries

## Lesson Goal

Students change existing dictionary information and add new key-value pairs.

---

## Skills

- **updates_dictionary_value** - Changes the value associated with an existing key.
- **adds_dictionary_entry** - Adds a new key-value pair through assignment.
- **distinguishes_add_from_update** - Predicts whether assignment changes an existing entry or creates a new one.
- **predicts_dictionary_after_assignment** - Determines dictionary state after several changes.
- **debugs_key_typo** - Identifies problems caused by inconsistent key spelling.

---

## Existing Key

```python
player["health"] = 80
```

If `"health"` already exists:

> update its value.

---

## New Key

```python
player["armor"] = 25
```

If `"armor"` does not already exist:

> create a new entry.

---

## Important Concept

The same syntax can perform two different operations based on whether the key already exists:

```text
existing key
→ UPDATE

new key
→ ADD
```

Students should reason about the dictionary's current state before predicting the result.

---

## Common Misconception: Accidental New Key

Example:

```python
player["helth"] = 80
```

instead of:

```python
player["health"] = 80
```

The typo may create a new key rather than changing the intended one.

This is a strong:

> Read → Identify → Test → Revise

debugging opportunity.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict an updated dictionary value,
- identify whether assignment adds or updates,
- add a new key,
- update an existing key,
- predict dictionary state after multiple assignments,
- debug an accidental key typo.

---

## Coding Exercise

### Update Character State

Students receive a player dictionary.

They must:

- reduce health,
- increase level,
- add a new property.

---

## Mastery Check Coverage

Students should demonstrate:

- dictionary update,
- dictionary addition,
- add/update distinction,
- state prediction,
- key-name debugging.

---

# 09.6 Looping Through Dictionaries

## Lesson Goal

Students combine dictionary structures with loops and tuple unpacking to process structured data.

---

## Skills

- **loops_through_dictionary_keys** - Iterates through dictionary keys.
- **loops_through_dictionary_values** - Iterates through dictionary values.
- **loops_through_dictionary_items** - Iterates through paired key-value entries.
- **unpacks_key_value_pair** - Uses two variables to unpack `.items()` pairs.
- **selects_dictionary_iteration_style** - Chooses keys, values, or items based on the task.
- **predicts_dictionary_loop_output** - Traces output from straightforward dictionary loops.

---

## Keys

```python
for key in player:
 print(key)
```

or:

```python
for key in player.keys():
 print(key)
```

---

## Values

```python
for value in player.values():
 print(value)
```

---

## Keys and Values Together

```python
for key, value in player.items():
 print(key, value)
```

This deliberately combines:

- Unit 06 loops,
- Unit 09.2 tuple unpacking,
- dictionaries.

---

# Code Stepper

For:

```python
for key, value in player.items():
 print(key, value)
```

show:

```text
Current pair:
("name", "Alex")

Unpacking:
key = "name"
value = "Alex"

Run body
↓
next pair
```

This makes the relationship between `.items()` and unpacking visible.

---

## Common Misconceptions

- assuming a normal dictionary loop gives values rather than keys,
- mixing up `.keys()` and `.values()`,
- forgetting two variables when unpacking `.items()`,
- treating `key` and `value` as special required names,
- losing track of the current pair.

---

## Adaptive Question Targets

Write question families that ask students to:

- predict what a normal dictionary loop visits,
- choose `.keys()`, `.values()`, or `.items()`,
- predict key/value variables during an iteration,
- complete an `.items()` loop,
- trace dictionary-loop output,
- explain why tuple unpacking works with `.items()`.

---

## Coding Exercise

### Character Sheet

Students loop through a player dictionary and display:

```text
name: Alex
health: 100
level: 5
```

without manually writing one `print()` statement for every field.

---

## Mastery Check Coverage

Students should demonstrate:

- key iteration,
- value iteration,
- item iteration,
- pair unpacking,
- appropriate iteration-method selection.

---

# 09.7 Nested Data

## Lesson Goal

Students understand that collections can contain other collections and learn to trace nested access one step at a time.

---

## Skills

- **recognizes_nested_collection** - Identifies when one collection is stored inside another.
- **accesses_nested_value** - Retrieves a value through multiple levels of access.
- **traces_nested_lookup** - Resolves a nested expression one level at a time.
- **reads_dictionary_with_list_value** - Interprets a dictionary containing a list.
- **reads_list_of_dictionaries** - Interprets a list containing dictionary records.
- **updates_nested_value** - Makes a straightforward change to information inside a nested structure.

---

## Start with One Level of Nesting

Example:

```python
player = {
 "name": "Alex",
 "inventory": ["Potion", "Key", "Map"]
}
```

Now:

```python
player["inventory"]
```

produces:

```python
["Potion", "Key", "Map"]
```

Then:

```python
player["inventory"][1]
```

can be decomposed as:

```text
player
↓
get "inventory"
↓
["Potion", "Key", "Map"]
↓
get index 1
↓
"Key"
```

---

# Required Teaching Approach

Do not ask students to mentally resolve the entire nested expression at once.

Teach:

> Work from the inside/left structure one access at a time.

Ask:

1. What does the first lookup produce?
2. What type of value is that?
3. What does the next access do to that value?

---

## List of Dictionaries

Once the first model is secure:

```python
enemies = [
 {"name": "Slime", "health": 20},
 {"name": "Bat", "health": 15}
]
```

Students can trace:

```python
enemies[1]["health"]
```

as:

```text
enemies[1]
↓
{"name": "Bat", "health": 15}

["health"]
↓
15
```

---

# Code Stepper / Expression Stepper

This is a useful opportunity to extend the Code Stepper with **expression resolution**.

For:

```python
enemies[1]["health"]
```

the interface could highlight:

```text
Step 1:
enemies[1]

Result:
{"name": "Bat", "health": 15}

Step 2:
["health"]

Result:
15
```

---

## Common Misconceptions

- trying to use a key before retrieving the dictionary containing it,
- confusing list indexes and dictionary keys,
- attempting to process the entire nested expression as one unexplained operation,
- losing track of the type produced at each step.

---

## Adaptive Question Targets

Write question families that ask students to:

- identify nested structures,
- predict the result of the first lookup,
- predict the final nested value,
- distinguish an index from a key in the same expression,
- trace a dictionary containing a list,
- trace a list containing dictionaries,
- update a straightforward nested value.

---

## Coding Exercise

### Enemy Data

Students receive a small list of enemy dictionaries.

They must:

- display a specific enemy's name,
- display a specific health value,
- update one value,
- explain each access step.

Starter data should be provided so the task focuses on nested access rather than data entry.

---

## Mastery Check Coverage

Students should demonstrate:

- nested-structure recognition,
- step-by-step lookup,
- index/key distinction,
- list-of-dictionaries reasoning,
- straightforward nested updates.

---

# 09.8 Modeling Real-World Data

## Lesson Goal

Students choose appropriate Python structures to represent information based on how that information is organized and used.

---

## Skills

- **identifies_data_relationships** - Identifies which values belong together and how they relate.
- **selects_collection_type** - Chooses a variable, list, tuple, or dictionary based on the problem.
- **models_entity_with_dictionary** - Represents one structured entity using meaningful keys.
- **models_multiple_entities** - Uses an appropriate collection to represent several similar entities.
- **explains_data_model_choice** - Explains why a selected structure fits the problem.
- **revises_data_model** - Improves a confusing or poorly organized representation.

---

# Data-Structure Decision Framework

Use:

```text
ONE VALUE?
→ variable

ORDERED COLLECTION THAT MAY CHANGE?
→ list

ORDERED FIXED GROUP?
→ tuple

NAMED PROPERTIES?
→ dictionary
```

For multiple structured entities:

```text
several dictionaries
↓
often stored in a list
```

---

## Example: Player Data

Separate variables:

```python
player_name = "Alex"
player_health = 100
player_level = 5
```

Possible dictionary model:

```python
player = {
 "name": "Alex",
 "health": 100,
 "level": 5
}
```

Now the related information is represented as one entity.

---

## Example: Several Players

```python
players = [
 {
 "name": "Alex",
 "health": 100
 },
 {
 "name": "Maya",
 "health": 85
 }
]
```

This represents:

```text
LIST
↓
multiple players

DICTIONARY
↓
one player's named properties
```

---

## Important Design Skill

There may be more than one technically possible solution.

Students should learn to ask:

> Which structure makes the information easiest to understand and work with?

This introduces data-modeling judgment rather than only syntax reproduction.

---

## Common Misconceptions

- choosing structures only because they were most recently taught,
- using a tuple when data needs to change frequently,
- using a list when named properties would be clearer,
- creating many unrelated variables for values that form one entity,
- nesting data unnecessarily.

---

## Adaptive Question Targets

Write question families that ask students to:

- choose variable/list/tuple/dictionary for a scenario,
- explain why a structure is appropriate,
- convert several related variables into a dictionary,
- identify poorly organized data,
- compare two possible models,
- choose a structure for multiple similar records,
- revise a confusing model.

---

## Coding Exercise

### Model a Game Entity

Students choose one:

- player,
- enemy,
- item,
- quest,
- game level.

They create an appropriate structure representing that entity and briefly explain the design.

---

## Mastery Check Coverage

Students should demonstrate:

- structure selection,
- relationship identification,
- dictionary modeling,
- multiple-entity reasoning,
- explanation of design choice.

This lesson should assess conceptual organization as well as syntax.

---

# Unit 09 Adaptive Review / Targeted Reteaching

Use skill evidence to distinguish needs such as:

- tuple/list distinction,
- tuple unpacking,
- dictionary syntax,
- key/value reasoning,
- dictionary mutation,
- dictionary iteration,
- nested access,
- data-model selection.

Nested-data difficulty should not automatically be interpreted as failure to understand basic dictionaries.

---

# Unit 09 Mastery Expectations

By the end of the unit, students should be able to:

- create and use tuples,
- unpack tuples,
- create dictionaries,
- distinguish keys and values,
- retrieve information using keys,
- add and update dictionary information,
- loop through keys, values, and items,
- unpack key-value pairs,
- trace simple nested data,
- model real-world information using appropriate structures,
- explain why one structure fits a problem better than another.

---

# Unit 09 Project: Contact Manager

## Project Goal

Students model and manage structured information about multiple contacts.

The project synthesizes:

- lists,
- dictionaries,
- loops,
- nested data,
- data modeling.

The project begins from:

- a blank `.py` file,
- a requirements list.

---

## Suggested Data Model

One contact:

```python
contact = {
 "name": "Alex",
 "phone": "555-1234",
 "email": "alex@example.com"
}
```

Multiple contacts:

```python
contacts = [
 {
 "name": "Alex",
 "phone": "555-1234",
 "email": "alex@example.com"
 },
 {
 "name": "Jordan",
 "phone": "555-9876",
 "email": "jordan@example.com"
 }
]
```

---

## Required Skills

Students should:

- represent one contact using a dictionary,
- use meaningful keys,
- represent multiple contacts in an appropriate collection,
- access a contact's information,
- update at least one field,
- add at least one field or record as appropriate,
- loop through dictionary information,
- work with nested list/dictionary data,
- display contact information clearly,
- explain the chosen data structure.

Tuple use may appear where naturally appropriate, but should not be forced into the project merely to check a box.

Tuple mastery should already be verified through practice and mastery checks.

---

## Project Assessment

Assess separately:

1. Is one contact modeled clearly?
2. Are meaningful dictionary keys used?
3. Are multiple contacts organized appropriately?
4. Can the student access nested information?
5. Can the student update existing information?
6. Can the student loop through structured data?
7. Is output understandable to the user?
8. Can the student explain why lists and dictionaries were combined?
9. Can the student trace how a specific value is reached?

---

## Stretch Opportunities

Students may add:

- interactive contact creation,
- contact deletion,
- editing several fields,
- a repeating menu,
- duplicate-name handling,
- additional fields,
- favorite/contact-group information,
- improved display formatting.

Do not require:

- formal searching algorithms,
- sorting,
- file persistence.

Those have later homes in the course:

- sorting/searching in Unit 10,
- file input/output in Unit 16.

---

# Units 07-09 Conceptual Progression

These three units form a connected shift in how students think about program organization.

## Unit 07

Students move from:

```text
one long sequence of instructions
```

to:

```text
named reusable behaviors
```

Core idea:

> Organize what the program **does**.

---

## Unit 08

Students move from:

```text
one value per variable
```

to:

```text
ordered collections of related values
```

Core idea:

> Organize many related **values**.

---

## Unit 09

Students move from:

```text
data identified mainly by position
```

to:

```text
data organized by meaning and relationships
```

Core idea:

> Organize what the data **means**.

Together:

```text
FUNCTIONS
organize behavior
↓
LISTS
organize collections
↓
TUPLES + DICTIONARIES
organize structured data
```

These skills prepare students for later work with:

- sorting,
- searching,
- randomness,
- files,
- testing,
- larger programs,
- classes and objects.
````

# UNIT 10: Sorting, Searching, and Patterns - Skills Review

## Unit Scope

Unit 10 includes:

- 10.1 `sort()`
- 10.2 `sorted()`
- 10.3 `reverse()`
- 10.4 `min()`, `max()`, and `sum()`
- 10.5 Membership Testing
- 10.6 Pattern Recognition Through Data
- 10.7 Introduction to Searching

Project:

- Data Explorer

The main conceptual progression is:

```text
organize data
↓
inspect data
↓
check whether something is present
↓
recognize patterns
↓
search for specific information
```

The major certification tie-in is Membership Testing using:

```python
in
not in
```

Sorting, aggregate functions, pattern recognition, and introductory searching are primarily FoxCS-original.

---

# 10.1 `sort()`

## Primary Assessed Skills

- **uses_list_sort** - Uses `.sort()` correctly on a list.
- **predicts_sorted_list** - Predicts the resulting order after sorting.
- **recognizes_sort_mutates_list** - Understands that `.sort()` changes the original list.
- **recognizes_default_sort_order** - Recognizes that default sorting is ascending.
- **selects_sort_for_original_change** - Chooses `.sort()` when changing the original collection is appropriate.

## Supporting Concepts

Students should also recognize that:

- numeric lists can be sorted,
- text lists can be sorted,
- `.sort()` is a list method,
- the original list remains the object being modified.

## Important Misconception

Students may try:

```python
sorted_scores = scores.sort()
```

For beginner instruction, reinforce:

```python
scores.sort()
```

when the goal is to modify the existing list.

Avoid making `None` a major conceptual focus here.

---

# 10.2 `sorted()`

## Primary Assessed Skills

- **uses_sorted_function** - Uses `sorted()` correctly.
- **recognizes_sorted_returns_new_list** - Understands that `sorted()` produces a new list.
- **preserves_original_collection** - Recognizes that the original collection is unchanged.
- **distinguishes_sort_and_sorted** - Chooses appropriately between `.sort()` and `sorted()`.
- **captures_sorted_result** - Stores the returned sorted collection when needed.

## Core Distinction

```text
.sort()
→ modify the original list

sorted()
→ produce a new sorted list
```

## Important Diagnostic Skill

The most important distinction is:

> mutation versus returned value

This should appear in:

- adaptive practice,
- coding exercises,
- mastery checks.

---

# 10.3 `reverse()`

## Primary Assessed Skills

- **uses_reverse_method** - Uses `.reverse()` correctly.
- **predicts_reversed_list** - Predicts the order after reversal.
- **recognizes_reverse_mutates_list** - Understands that `.reverse()` changes the original list.
- **distinguishes_reverse_from_sorting** - Understands that reversing and sorting are different operations.
- **uses_reverse_sorting_option** - Recognizes or uses descending sorting with `reverse=True`.

## Important Misconception

Given:

```python
numbers = [3, 1, 2]
numbers.reverse()
```

the result is:

```python
[2, 1, 3]
```

not:

```python
[3, 2, 1]
```

Students should understand:

> Reverse means put the current order backward.

It does not mean:

> Sort from greatest to least.

## Supporting / Extend Skill

Descending sorting may use:

```python
sorted(numbers, reverse=True)
```

or:

```python
numbers.sort(reverse=True)
```

This can be Core or Extend depending on pacing.

---

# 10.4 `min()`, `max()`, and `sum()`

## Primary Assessed Skills

- **uses_min_function** - Uses `min()` to find the lowest value.
- **uses_max_function** - Uses `max()` to find the highest value.
- **uses_sum_function** - Uses `sum()` to calculate a total.
- **selects_aggregate_function** - Chooses the correct function for a stated goal.
- **predicts_aggregate_result** - Predicts the result of `min()`, `max()`, or `sum()`.

## Conceptual Model

Students should connect questions to functions:

```text
highest score
→ max()

lowest time
→ min()

total points
→ sum()
```

## Skill-Tracking Note

Do not over-fragment this lesson.

The most important skill is:

> selecting the appropriate aggregate function based on the question being asked.

---

# 10.5 Membership Testing

## Certification Importance

This is the direct Unit 10 GMetrix / Certiport concept.

Core operators:

```python
in
not in
```

## Primary Assessed Skills

- **uses_in_operator** - Uses `in` to test membership.
- **uses_not_in_operator** - Uses `not in` correctly.
- **predicts_membership_boolean** - Predicts whether a membership expression returns `True` or `False`.
- **selects_membership_operator** - Chooses `in` or `not in` for a stated rule.
- **uses_membership_in_condition** - Uses membership testing inside a conditional.
- **distinguishes_membership_from_indexing** - Distinguishes checking for presence from accessing by position.

## Core Distinction

```python
"Key" in inventory
```

asks:

> Is `"Key"` present?

while:

```python
inventory[2]
```

asks:

> What item is at position 2?

These are different operations and should be explicitly contrasted.

---

# 10.6 Pattern Recognition Through Data

## Primary Assessed Skills

- **identifies_repeated_data_pattern** - Recognizes a repeated or predictable relationship in data.
- **describes_pattern_rule** - Explains the observed pattern clearly.
- **predicts_next_pattern_value** - Uses an observed pattern to predict what comes next.
- **recognizes_outlier_or_break** - Identifies a value that does not fit the pattern.
- **uses_code_to_inspect_pattern** - Uses previously learned Python tools to examine data for a pattern.

## Teaching Boundary

This should not become a formal mathematics-sequences unit.

The purpose is computational thinking:

> Can the student notice useful regularity in data?

Possible examples:

- increasing scores,
- alternating values,
- repeated categories,
- repeated game events,
- values changing by a consistent amount.

## Game / Learning Connection

Students can connect this to how players learn game systems:

```text
observe repeated behavior
↓
notice pattern
↓
predict what will happen
↓
adjust strategy
```

That is similar to how programmers recognize reusable code and data patterns.

---

# 10.7 Introduction to Searching

## Primary Assessed Skills

- **searches_list_for_target** - Searches through a list for a target value.
- **uses_loop_to_search** - Uses iteration to inspect items one at a time.
- **tracks_search_state** - Tracks whether or where a target has been found.
- **stops_search_when_found** - Uses previously learned control flow to stop when appropriate.
- **distinguishes_membership_check_from_manual_search** - Understands when a loop-based search provides more information than `in`.
- **predicts_search_result** - Predicts the outcome of a straightforward search.

## Conceptual Distinction

```python
target in items
```

answers:

> Is the target present?

A manual search can answer more detailed questions:

- Where is it?
- Which item matched?
- What should happen when it is found?
- How many matches are there?

## Teaching Boundary

This is an introduction to searching logic.

Do not turn this into a formal algorithms unit involving:

- binary search,
- Big O notation,
- algorithmic complexity analysis.

The goal is to understand the search pattern.

---

# Unit 10 Recommended Skill Categories

The major mastery categories are:

1. sorting behavior,
2. mutation versus returned values,
3. reversing versus sorting,
4. aggregate functions,
5. membership testing,
6. pattern recognition,
7. manual search logic.

---

# Unit 10 Project: Data Explorer

## Likely Required Skill Areas

Students should be able to:

- work with a collection of data,
- organize data,
- calculate useful summary values,
- check for membership,
- search for specific information,
- recognize or describe a pattern,
- display conclusions clearly.

Avoid requiring concepts from later units.

---

# UNIT 11: Randomness and Simulation - Skills Review

## Unit Scope

Unit 11 includes:

- 11.1 Importing Modules
- 11.2 `random`
- 11.3 `randint`
- 11.4 `choice`
- 11.5 `shuffle`
- 11.6 Simple Simulations
- 11.7 Probability Through Code

Project:

- Game of Chance

The certification objective also requires explicit exposure to:

- `randrange`
- `sample`

even though they do not currently have standalone FoxCS lesson titles.

The conceptual progression is:

```text
import a tool
↓
generate a random value
↓
select random outcomes
↓
reorder data randomly
↓
repeat random events
↓
analyze what happened
```

---

# 11.1 Importing Modules

## Primary Assessed Skills

- **uses_import_statement** - Uses `import` to make a module available.
- **recognizes_module_namespace** - Recognizes the module name before a function call.
- **calls_module_function** - Calls a function through its module.
- **distinguishes_builtin_from_imported_function** - Distinguishes functions available automatically from functions provided through a module.
- **identifies_missing_import** - Recognizes when code uses a module that has not been imported.

## Core Example

```python
import random

number = random.randint(1, 6)
```

Students should recognize:

```text
random
→ module

randint
→ function provided by the module
```

## Teaching Boundary

Use:

```python
import random
```

as the primary pattern.

Do not complicate this unit with multiple import styles unless needed for certification exposure.

---

# 11.2 `random()`

## Primary Assessed Skills

- **uses_random_function** - Uses `random.random()` correctly.
- **recognizes_random_range** - Understands that the result is at least `0.0` and less than `1.0`.
- **predicts_valid_random_output** - Identifies whether a possible result could be returned.
- **uses_random_for_probability_threshold** - Uses a random decimal in a simple probability condition.
- **recognizes_random_is_nondeterministic** - Understands that repeated execution may produce different results.

## Core Conceptual Shift

Students cannot usually answer:

> What exact number will Python return?

Instead they answer:

> What values are possible?

For:

```python
random.random()
```

the range is:

```text
0.0 <= result < 1.0
```

---

# 11.3 `randint()`

## Primary Assessed Skills

- **uses_randint** - Uses `random.randint()` correctly.
- **identifies_randint_bounds** - Identifies the starting and ending values.
- **recognizes_randint_inclusive_bounds** - Understands that both endpoints may be returned.
- **selects_randint_range** - Chooses appropriate bounds for a described random event.
- **predicts_possible_randint_values** - Determines whether a value is possible.

## High-Value Comparison

Compare:

```python
range(1, 6)
```

with:

```python
random.randint(1, 6)
```

`range(1, 6)` does not include `6`.

`randint(1, 6)` can return `6`.

This difference should be explicitly assessed.

---

# Certification Extension: `randrange()`

## Primary / Supporting Skills

- **uses_randrange** - Uses `random.randrange()` in straightforward situations.
- **recognizes_randrange_exclusive_stop** - Connects its stop behavior to `range()`.
- **uses_randrange_step** - Uses a step to constrain possible results.
- **distinguishes_randrange_and_randint** - Distinguishes exclusive-stop and inclusive-bound random integer generation.

## Possible Placement

This can be incorporated into 11.3 rather than becoming a new lesson.

A useful connection is:

```text
range()
and
randrange()
```

share similar boundary logic.

---

# 11.4 `choice()`

## Primary Assessed Skills

- **uses_random_choice** - Selects one random value from a sequence.
- **selects_sequence_for_choice** - Identifies the collection from which an outcome should be chosen.
- **predicts_possible_choice_outputs** - Determines which outcomes are possible.
- **uses_choice_for_game_event** - Uses `choice()` for a straightforward random event.
- **distinguishes_choice_from_randint** - Chooses between selecting an existing item and generating a number.

## Example

```python
random.choice(["Fire", "Water", "Grass"])
```

Possible results are limited to the values already in the collection.

---

# Certification Extension: `sample()`

## Primary / Supporting Skills

- **uses_random_sample** - Uses `random.sample()` to select multiple values.
- **recognizes_sample_returns_multiple_items** - Understands that more than one item may be selected.
- **recognizes_sample_unique_selection** - Understands that a basic sample selects unique items from the population.
- **distinguishes_sample_and_choice** - Chooses between one random item and multiple unique random items.

## Possible Placement

Teach alongside 11.4 because:

```text
choice()
→ one item

sample()
→ multiple unique items
```

This does not require a separate FoxCS lesson.

---

# 11.5 `shuffle()`

## Primary Assessed Skills

- **uses_shuffle** - Uses `random.shuffle()` on a list.
- **recognizes_shuffle_mutates_list** - Understands that the original list order changes.
- **predicts_shuffle_constraints** - Recognizes what can and cannot change after shuffling.
- **distinguishes_shuffle_from_choice** - Distinguishes random reordering from selecting an item.
- **recognizes_shuffle_preserves_items** - Understands that the list contains the same items after shuffling.

## Important Concept

Shuffle changes:

```text
ORDER
```

but does not change:

```text
WHICH ITEMS EXIST
```

This should connect to prior mutation concepts from:

- `.sort()`
- `.reverse()`

---

# 11.6 Simple Simulations

## Primary Assessed Skills

- **models_random_event** - Represents a random real-world or game event in code.
- **repeats_simulation_with_loop** - Repeats the event using a loop.
- **tracks_simulation_results** - Records outcomes across repeated trials.
- **uses_counter_for_outcomes** - Counts how often specific outcomes occur.
- **summarizes_simulation_results** - Produces useful results from repeated trials.
- **recognizes_simulation_variability** - Understands that separate simulation runs may produce different totals.

## Strong Integration Opportunity

This lesson combines:

- loops,
- counters,
- lists or dictionaries where useful,
- random functions,
- output interpretation.

Possible simulations:

- coin flips,
- dice rolls,
- loot drops,
- enemy encounters,
- random game events.

---

# 11.7 Probability Through Code

## Primary Assessed Skills

- **calculates_empirical_probability** - Calculates probability based on observed simulation results.
- **distinguishes_theoretical_and_observed_probability** - Distinguishes expected probability from what actually happened in one simulation.
- **calculates_outcome_frequency** - Determines how often an outcome occurred.
- **interprets_simulation_ratio** - Converts simulation counts into a meaningful ratio or percentage.
- **compares_expected_and_observed_results** - Compares simulation results to theoretical expectations.
- **recognizes_larger_trials_stabilize_results** - Understands that more trials generally produce more stable observed proportions.

## Example

A fair coin has:

```text
theoretical probability of heads
→ 50%
```

A simulation of 20 flips might produce:

```text
12 heads
8 tails
```

That does not mean the theoretical probability changed.

Students should understand random variation.

---

# Unit 11 Recommended Skill Categories

The major mastery categories are:

1. importing and using a module,
2. random decimal generation,
3. random integer generation,
4. random selection,
5. random reordering,
6. repeated simulation,
7. empirical probability.

Certification exposure must also include:

- `randrange()`
- `sample()`

---

# Unit 11 Project: Game of Chance

## Likely Required Skill Areas

Students should:

- import the random module,
- generate or select random outcomes,
- use conditionals based on outcomes,
- track game state,
- repeat gameplay appropriately,
- display clear feedback,
- explain where randomness affects the game.

Stretch opportunities may include:

- multiple random mechanics,
- probability balancing,
- score systems,
- risk/reward decisions,
- simulations of expected outcomes.

---

# UNIT 12: Useful Python Tools - Skills Review

## Unit Scope

Unit 12 includes:

- 12.1 The Math Module
- 12.2 `ceil()`
- 12.3 `floor()`
- 12.4 `trunc()`
- 12.5 `sqrt()`
- 12.6 Working with Common Tools

Project:

- Calculator Upgrade

Certification coverage requires exposure to:

- `fabs`
- `ceil`
- `floor`
- `trunc`
- `fmod`
- `frexp`
- `nan`
- `isnan`
- `sqrt`
- `isqrt`
- `pow`
- `pi`

The core FoxCS lessons can emphasize the most useful tools while still ensuring all certification functions are encountered.

---

# 12.1 The Math Module

## Primary Assessed Skills

- **imports_math_module** - Imports the `math` module correctly.
- **recognizes_math_namespace** - Recognizes `math.` as access to a module member.
- **calls_math_function** - Calls a math-module function correctly.
- **uses_math_constant** - Uses a provided math constant such as `math.pi`.
- **selects_math_tool_from_reference** - Uses a reference to identify an appropriate math tool.

## Conceptual Model

Students should understand:

```python
math.sqrt(25)
```

as:

```text
math
→ module

sqrt
→ tool inside the module

25
→ information passed to the tool
```

## Teaching Goal

Students do not need to memorize every available function.

An important real programming skill is:

> knowing how to find and interpret an appropriate tool.

---

# 12.2 `ceil()`

## Primary Assessed Skills

- **uses_math_ceil** - Uses `math.ceil()` correctly.
- **predicts_ceil_result** - Predicts the result for positive and negative values.
- **selects_ceil_for_context** - Chooses ceiling when a value must be rounded upward to the next integer boundary.
- **distinguishes_ceil_from_round** - Distinguishes ceiling from ordinary rounding.
- **distinguishes_ceil_from_floor** - Distinguishes upward and downward integer boundaries.

## Example

```python
math.ceil(2.1)
```

returns:

```text
3
```

## Applied Context

If a game requires enough containers to hold all items:

```text
10 items
4 items per container
```

then the program may need:

```text
3 containers
```

because a partial final group still requires a container.

---

# 12.3 `floor()`

## Primary Assessed Skills

- **uses_math_floor** - Uses `math.floor()` correctly.
- **predicts_floor_result** - Predicts results for positive and negative values.
- **selects_floor_for_context** - Chooses floor when a value must move to the lower integer boundary.
- **distinguishes_floor_from_ceil** - Distinguishes floor and ceiling.
- **distinguishes_floor_from_floor_division** - Distinguishes `math.floor()` from `//`.

## Critical Distinction

```python
math.floor(7.8)
```

takes one numeric value and finds its floor.

```python
17 // 4
```

performs division using floor-division behavior.

They are related mathematical ideas but are different Python operations.

---

# 12.4 `trunc()`

## Primary Assessed Skills

- **uses_math_trunc** - Uses `math.trunc()` correctly.
- **predicts_trunc_result** - Predicts the result.
- **recognizes_trunc_toward_zero** - Understands that truncation removes the fractional portion toward zero.
- **distinguishes_trunc_from_floor** - Distinguishes truncation from floor, especially for negative values.
- **selects_trunc_for_context** - Chooses truncation when discarding the decimal portion is appropriate.

## Required Comparison

For a positive value:

```text
floor(3.8) = 3
trunc(3.8) = 3
```

The results look identical.

For a negative value:

```text
floor(-3.8) = -4
trunc(-3.8) = -3
```

The difference becomes visible.

Negative examples are necessary for actual conceptual understanding.

---

# 12.5 `sqrt()`

## Primary Assessed Skills

- **uses_math_sqrt** - Uses `math.sqrt()` correctly.
- **predicts_square_root** - Predicts straightforward square-root results.
- **connects_square_and_square_root** - Recognizes the inverse relationship between squaring and square root.
- **uses_sqrt_in_formula** - Uses square root as part of a larger formula.
- **recognizes_invalid_negative_real_sqrt** - Recognizes that the normal `math.sqrt()` function does not accept a negative real-number input.

## Core Example

```python
math.sqrt(25)
```

returns:

```text
5.0
```

## Possible Extend Connection

Distance calculations may use:

```python
distance = math.sqrt(x_difference ** 2 + y_difference ** 2)
```

This should be Extend rather than required Core unless it naturally fits pacing.

---

# 12.6 Working with Common Tools

## Primary Assessed Skills

- **selects_math_function_for_problem** - Chooses an appropriate math function based on a stated goal.
- **reads_math_function_reference** - Uses documentation or a provided reference to understand an unfamiliar function.
- **combines_math_functions_with_prior_skills** - Uses math tools inside larger calculations.
- **predicts_math_function_output** - Predicts results from common math functions.
- **debugs_math_module_usage** - Repairs straightforward problems involving imports or function calls.
- **distinguishes_related_math_tools** - Chooses correctly among similar operations.

---

# Certification Exposure: Additional Math Tools

These functions should receive explicit exposure even if they do not each become standalone FoxCS lessons.

## `fabs()`

### Supporting Skills

- **recognizes_math_fabs** - Recognizes `math.fabs()` as absolute distance from zero.
- **predicts_fabs_result** - Predicts straightforward results.
- **distinguishes_fabs_from_signed_value** - Understands that the returned result is nonnegative.

---

## `fmod()`

### Supporting Skills

- **recognizes_math_fmod** - Recognizes `math.fmod()` as a remainder/modulus-style tool.
- **predicts_basic_fmod_result** - Predicts straightforward results.
- **distinguishes_fmod_from_percent_operator** - Recognizes that `math.fmod()` and `%` are related but distinct tools.

Do not overcomplicate this distinction beyond certification needs.

---

## `frexp()`

### Supporting Skills

- **recognizes_math_frexp** - Recognizes that `math.frexp()` returns mantissa and exponent information.
- **interprets_frexp_result_from_reference** - Uses documentation/reference material to interpret its output.

This is a strong example of:

> use documentation rather than memorize obscure behavior.

---

## `nan` and `isnan()`

### Supporting Skills

- **recognizes_nan_value** - Recognizes `nan` as a special not-a-number value.
- **uses_isnan** - Recognizes or uses `math.isnan()` to test for NaN.
- **distinguishes_nan_and_isnan** - Distinguishes the value from the checking function.

This distinction is certification-important.

---

## `isqrt()`

### Supporting Skills

- **uses_math_isqrt** - Recognizes or uses integer square root.
- **distinguishes_sqrt_and_isqrt** - Distinguishes regular square root from integer square-root behavior.

---

## `pow()`

### Supporting Skills

- **uses_math_pow** - Recognizes or uses `math.pow()`.
- **connects_pow_to_exponentiation** - Connects it to previously learned exponent concepts.
- **distinguishes_pow_from_operator** - Recognizes that exponentiation can also be performed with `**`.

---

## `pi`

### Supporting Skills

- **uses_math_pi** - Uses `math.pi` as a constant.
- **recognizes_pi_is_constant** - Distinguishes a constant from a function call.
- **uses_pi_in_formula** - Applies `math.pi` in a straightforward formula.

---

# High-Priority Comparison Matrix

Students should eventually distinguish:

| Tool | Main Idea |
|---|---|
| `round()` | nearest value |
| `math.ceil()` | move upward to the ceiling integer |
| `math.floor()` | move downward to the floor integer |
| `math.trunc()` | remove fractional portion toward zero |
| `//` | floor division between two values |
| `math.sqrt()` | square root |
| `math.isqrt()` | integer square root |

Negative-number examples should be included because positive-only examples can hide the difference between:

- floor,
- truncation.

---

# Unit 12 Recommended Skill Categories

The major mastery categories are:

1. importing and using the math module,
2. ceiling,
3. floor,
4. truncation,
5. square root,
6. selecting appropriate tools,
7. reading reference material for unfamiliar certification functions.

The less-common certification functions should generally be treated as:

```text
explicit exposure
+
reference-reading practice
```

rather than each creating a large independent adaptive skill bank.

---

# Unit 12 Project: Calculator Upgrade

## Likely Required Skill Areas

Students should:

- import the math module,
- use multiple math tools,
- select appropriate functions for the task,
- combine module functions with prior arithmetic skills,
- display readable results,
- explain why each selected tool is appropriate.

Possible contexts include:

- geometry,
- game statistics,
- resource calculations,
- distance,
- rounding decisions,
- upgraded versions of earlier calculators.

---

# Units 10-12 Conceptual Progression

## Unit 10

Students learn to:

> organize and inspect existing data.

```text
sort
↓
summarize
↓
check membership
↓
search
```

## Unit 11

Students learn to:

> introduce uncertainty and study repeated outcomes.

```text
random values
↓
random choices
↓
simulation
↓
probability
```

## Unit 12

Students learn to:

> use Python's standard-library tools instead of rebuilding every calculation themselves.

```text
identify problem
↓
select tool
↓
call tool
↓
interpret result
```

Together:

```text
UNIT 10
understand data
↓
UNIT 11
generate and simulate data
↓
UNIT 12
use specialized tools to solve problems with data
```

# UNIT 13: Debugging and Errors - Skills Review

## Unit Scope

Unit 13 includes:

- 13.1 What Errors Teach Us
- 13.2 `SyntaxError`
- 13.3 `NameError`
- 13.4 `TypeError`
- 13.5 `ValueError`
- 13.6 `IndexError`
- 13.7 `KeyError`
- 13.8 Reading Tracebacks

Project:

- Debugging Challenge

The main conceptual progression is:

```text
notice unexpected behavior
↓
classify the problem
↓
read available evidence
↓
identify the likely cause
↓
test one hypothesis
↓
revise
↓
verify the fix
```

This unit also formalizes the troubleshooting routine students have been using since early in the course:

```text
Read
↓
Identify
↓
Test
↓
Revise
↓
Ask
```

The major certification connection is LearnKey / GMetrix Domain 5:

- Syntax Errors
- Logic Errors
- Runtime Errors
- Review 5.1

FoxCS goes further by distinguishing specific Python exception types.

---

# 13.1 What Errors Teach Us

## Primary Assessed Skills

- **distinguishes_error_categories** - Distinguishes syntax errors, logic errors, and runtime errors.
- **classifies_bug_from_behavior** - Uses program behavior to identify the likely category of problem.
- **recognizes_error_as_feedback** - Treats errors and unexpected output as information that can guide debugging.
- **selects_debugging_first_step** - Chooses a reasonable first action when investigating a problem.
- **applies_debugging_routine** - Uses Read → Identify → Test → Revise → Ask deliberately.

## Core Error Categories

### Syntax Error

Python cannot correctly interpret the written code.

Example causes:

- missing colon,
- unmatched parenthesis,
- broken quotation marks,
- malformed statement.

### Runtime Error

The program begins running but encounters an operation it cannot complete.

Examples may later include:

- undefined names,
- incompatible types,
- invalid values,
- invalid indexes,
- missing dictionary keys.

### Logic Error

The program runs without crashing but produces the wrong result.

Example:

```python
price = 10
tax = 0.08

total = price + tax
```

The code runs, but the calculation does not correctly calculate tax.

## Critical Distinction

```text
Syntax error
→ Python cannot properly interpret the code

Runtime error
→ Python encounters a problem while executing

Logic error
→ Python executes the instructions, but the instructions are wrong
```

## Important Misconception

Students may believe:

> If there is no red error message, the program must be correct.

Logic errors directly challenge that assumption.

## Adaptive Question Targets

Write question families that ask students to:

- classify an error as syntax, runtime, or logic,
- identify evidence supporting the classification,
- choose an appropriate first debugging step,
- compare expected and actual behavior,
- identify which part of the troubleshooting routine should happen next,
- distinguish a crash from incorrect output.

---

# 13.2 `SyntaxError`

## Primary Assessed Skills

- **recognizes_syntax_error** - Recognizes a syntax-related failure.
- **locates_syntax_error** - Uses Python's reported location as a clue.
- **identifies_invalid_python_structure** - Identifies malformed Python syntax.
- **repairs_syntax_error** - Corrects a straightforward syntax problem.
- **uses_error_location_as_clue** - Uses the reported line and surrounding code during debugging.
- **checks_near_reported_line** - Recognizes that the underlying problem may occur on or immediately before the reported line.

## Common Causes

Examples include:

```python
if score > 10
 print("You win!")
```

Missing:

```text
:
```

---

```python
print("Hello"
```

Missing:

```text
)
```

---

```python
name = "Alex
```

Missing closing quotation mark.

## Important Concept

An error message may identify:

> where Python finally became unable to interpret the code

rather than perfectly describing:

> the exact character the student originally typed incorrectly.

Students should inspect the reported line and nearby code.

## Adaptive Question Targets

Write question families that ask students to:

- identify malformed syntax,
- locate a missing symbol,
- repair code,
- interpret a reported syntax-error line,
- inspect the preceding line when appropriate,
- distinguish syntax failure from a logic mistake.

---

# 13.3 `NameError`

## Primary Assessed Skills

- **recognizes_name_error** - Recognizes when Python cannot find a referenced name.
- **identifies_undefined_name** - Identifies the name Python does not currently know.
- **checks_identifier_spelling** - Checks spelling when debugging a name problem.
- **checks_case_sensitivity** - Recognizes capitalization differences in identifiers.
- **checks_definition_before_use** - Determines whether a variable or function exists before it is referenced.
- **repairs_name_error** - Corrects a straightforward `NameError`.

## Retrieval from Unit 02

Students should reconnect to:

```python
score
Score
"score"
```

These represent different things.

Example:

```python
score = 100

print(Score)
```

Python does not treat:

```text
score
```

and:

```text
Score
```

as the same name.

## Common Causes

- misspelled variable,
- capitalization mismatch,
- variable used before assignment,
- function name misspelled,
- referencing a name that does not exist.

## Adaptive Question Targets

Write question families that ask students to:

- identify the undefined name,
- identify spelling differences,
- identify capitalization differences,
- determine whether assignment occurred before use,
- repair a `NameError`,
- explain why a quoted string does not cause the same problem.

---

# 13.4 `TypeError`

## Primary Assessed Skills

- **recognizes_type_error** - Recognizes a failure caused by incompatible data types or an invalid operation for a type.
- **identifies_incompatible_types** - Determines which values or operations are incompatible.
- **predicts_type_error** - Predicts when an operation will produce a `TypeError`.
- **checks_value_types** - Uses prior type knowledge when debugging.
- **selects_type_conversion** - Selects an appropriate conversion when conversion is the correct solution.
- **repairs_type_error** - Corrects a straightforward type-related problem.

## Example

```python
score = 10

print("Score: " + score)
```

The program attempts to concatenate:

```text
string + integer
```

One possible repair is:

```python
print("Score: " + str(score))
```

Another is:

```python
print(f"Score: {score}")
```

## Conceptual Model

A `TypeError` often means:

> The kind of value involved does not support the operation being attempted.

## Common Misconception

Do not train students to automatically convert everything to a string.

The debugging question should be:

> What type does this operation actually need?

## Adaptive Question Targets

Write question families that ask students to:

- identify the types involved,
- determine whether an operation is valid,
- predict a `TypeError`,
- choose an appropriate conversion,
- repair incompatible-type code,
- explain why the operation fails.

---

# 13.5 `ValueError`

## Primary Assessed Skills

- **recognizes_value_error** - Recognizes when an acceptable type contains an unusable value.
- **distinguishes_type_error_and_value_error** - Distinguishes incompatible type from invalid value.
- **identifies_invalid_conversion_value** - Identifies a value that cannot be converted as requested.
- **predicts_value_error** - Predicts straightforward `ValueError` situations.
- **checks_value_before_conversion** - Recognizes when user-provided values may fail conversion.
- **repairs_value_error** - Corrects or handles a straightforward value problem.

## Core Example

```python
age = int("hello")
```

The supplied object is a string.

Strings can sometimes be converted to integers:

```python
int("17")
```

But:

```text
"hello"
```

does not represent a valid integer.

## Core Distinction

```text
TypeError
→ wrong kind of thing for this operation

ValueError
→ acceptable general kind of thing, but unusable specific value
```

## High-Value Comparison

```python
"Age: " + 17
```

may produce:

```text
TypeError
```

while:

```python
int("seventeen")
```

may produce:

```text
ValueError
```

## Adaptive Question Targets

Write question families that ask students to:

- distinguish TypeError and ValueError,
- identify whether a conversion is valid,
- predict whether a string can be converted,
- locate the problematic value,
- repair a conversion problem,
- explain why the value is unacceptable.

---

# 13.6 `IndexError`

## Primary Assessed Skills

- **recognizes_index_error** - Recognizes an invalid sequence index.
- **identifies_out_of_range_index** - Determines when an index is outside the valid range.
- **determines_valid_index_range** - Determines valid indexes based on collection length.
- **connects_length_and_last_index** - Recognizes that the final positive index is `len(collection) - 1`.
- **predicts_index_error** - Predicts whether indexed access will fail.
- **repairs_index_error** - Corrects a straightforward invalid-index problem.

## Retrieval from Unit 08

Given:

```python
items = ["Sword", "Potion", "Key"]
```

students should reason:

```text
length = 3

valid positive indexes:
0
1
2
```

Therefore:

```python
items[3]
```

attempts to access a fourth item that does not exist.

## Important Relationship

```text
length
→ number of items

last index
→ length - 1
```

## Adaptive Question Targets

Write question families that ask students to:

- calculate valid indexes,
- identify the last valid index,
- predict an `IndexError`,
- identify an out-of-range access,
- repair incorrect indexing,
- explain the relationship between length and index.

---

# 13.7 `KeyError`

## Primary Assessed Skills

- **recognizes_key_error** - Recognizes an attempted lookup using a missing dictionary key.
- **identifies_missing_dictionary_key** - Determines which requested key is unavailable.
- **checks_dictionary_keys** - Inspects available keys before or during debugging.
- **distinguishes_key_error_from_index_error** - Distinguishes dictionary lookup failures from list indexing failures.
- **predicts_key_error** - Predicts whether a key lookup will succeed.
- **repairs_key_error** - Corrects a straightforward dictionary-key problem.

## Retrieval from Unit 09

Example:

```python
player = {
 "name": "Alex",
 "health": 100
}

print(player["mana"])
```

The dictionary has no:

```text
"mana"
```

key.

## Core Comparison

```python
items[5]
```

may produce:

```text
IndexError
```

because the requested **position** does not exist.

```python
player["mana"]
```

may produce:

```text
KeyError
```

because the requested **key** does not exist.

## Adaptive Question Targets

Write question families that ask students to:

- identify available dictionary keys,
- predict whether lookup succeeds,
- identify a missing key,
- distinguish index and key failures,
- correct a misspelled key,
- repair straightforward dictionary access.

---

# 13.8 Reading Tracebacks

## Primary Assessed Skills

- **identifies_exception_type** - Finds the exception type in a traceback.
- **identifies_error_message** - Identifies the descriptive error message.
- **identifies_reported_line** - Locates the reported source-code line.
- **reads_traceback_bottom_up** - Begins with the final exception information and works backward as needed.
- **connects_traceback_to_source_code** - Relates traceback information to the relevant program line.
- **forms_debugging_hypothesis** - Proposes a reasonable explanation for the problem.
- **tests_debugging_hypothesis** - Makes one focused test or revision.
- **explains_error_cause** - Explains the cause rather than simply naming the exception.

## Traceback Reading Routine

Students should learn:

```text
1. What exception occurred?
2. What message did Python provide?
3. What line is reported?
4. What was that line trying to do?
5. What values were involved?
6. What is one reasonable hypothesis?
7. What single change can I test?
```

## Visual Mental Model

```text
BOTTOM OF TRACEBACK
↓
exception type + message

LOOK UPWARD
↓
reported location

RETURN TO CODE
↓
inspect values and operation
```

## Important Logic-Error Contrast

Logic errors often do not create a traceback.

Therefore debugging has two major paths:

```text
PROGRAM CRASHES
↓
read traceback

PROGRAM RUNS BUT IS WRONG
↓
compare expected vs actual
↓
trace program state
```

This distinction should be explicitly assessed.

## Code Stepper Connection

The Code Stepper becomes especially useful for logic errors.

Students can compare:

```text
expected state
vs
actual state
```

line by line until they find:

> the first place the program becomes different from what they expected.

## Adaptive Question Targets

Write question families that ask students to:

- identify traceback components,
- identify the exception type,
- identify the reported line,
- explain the likely cause,
- choose a debugging hypothesis,
- distinguish traceback debugging from logic-error tracing,
- determine the best next debugging action.

---

# Unit 13 Recommended Skill Categories

The major mastery categories are:

1. error-category recognition,
2. `SyntaxError`,
3. `NameError`,
4. `TypeError`,
5. `ValueError`,
6. `IndexError`,
7. `KeyError`,
8. traceback interpretation,
9. logic-error debugging,
10. systematic troubleshooting.

## Skill-Tracking Note

Not every possible source of each exception needs its own adaptive skill ID.

For example:

```text
checks spelling
checks capitalization
checks definition-before-use
```

may appear as supporting evidence underneath:

```text
recognizes/repairs NameError
```

if the adaptive question count becomes too large.

---

# Unit 13 Project: Debugging Challenge

## Likely Required Skill Areas

Students should receive a program containing multiple intentionally introduced problems.

The program should include a reasonable mixture of:

- syntax error,
- logic error,
- `NameError`,
- `TypeError`,
- `ValueError`,
- `IndexError`,
- `KeyError`.

Students should:

1. run or inspect the program,
2. identify one problem,
3. classify the problem,
4. explain the evidence,
5. make one focused revision,
6. test the change,
7. continue until the program behaves correctly.

## Project Assessment

Assess:

- accurate error identification,
- use of traceback information,
- systematic debugging,
- quality of repair,
- verification after repair,
- ability to explain the cause.

Avoid making success depend only on:

> eventually producing working code.

The debugging process itself should be assessable.

---

# UNIT 14: Exception Handling - Skills Review

## Unit Scope

Unit 14 includes:

- 14.1 `try`
- 14.2 `except`
- 14.3 `else`
- 14.4 `finally`
- 14.5 Handling User Errors
- 14.6 Defensive Programming

Project:

- Safe Input System

Certification coverage also requires:

```python
raise
```

even though it does not currently have a standalone FoxCS lesson.

The strongest placement is within:

- 14.6 Defensive Programming

The main conceptual progression is:

```text
understand failures
↓
anticipate failures
↓
attempt risky operation
↓
respond safely if it fails
↓
allow user recovery
↓
design programs that fail gracefully
```

---

# 14.1 `try`

## Primary Assessed Skills

- **writes_try_block** - Writes a correctly structured `try` block.
- **identifies_risky_code** - Identifies code that may reasonably produce an exception.
- **places_risky_code_in_try** - Places the appropriate operation inside the `try` block.
- **predicts_try_execution** - Predicts what happens when the attempted code succeeds.
- **distinguishes_try_from_error_prevention** - Understands that `try` handles possible failure rather than making failure impossible.

## Core Example

```python
try:
 age = int(input("Enter your age: "))
```

The program is saying:

> Attempt this operation.

It is not saying:

> This operation cannot fail.

## Important Misconception

Students may believe that:

```python
try:
```

automatically prevents errors.

Instead:

> `try` establishes an area where an exception can be responded to intentionally.

## Adaptive Question Targets

Write question families that ask students to:

- identify risky code,
- select what belongs inside `try`,
- construct a `try` block,
- predict successful execution,
- explain what `try` does,
- distinguish handling from prevention.

---

# 14.2 `except`

## Primary Assessed Skills

- **writes_except_block** - Writes an exception handler.
- **handles_specific_exception** - Handles an expected exception type.
- **matches_exception_to_handler** - Selects an appropriate handler for a known failure.
- **predicts_except_execution** - Predicts when the exception block executes.
- **distinguishes_specific_and_broad_except** - Recognizes the benefit of handling known exceptions specifically.
- **provides_useful_error_feedback** - Gives the user meaningful information rather than exposing a crash.

## Preferred Beginner Pattern

```python
try:
 age = int(input("Enter your age: "))
except ValueError:
 print("Please enter a whole number.")
```

Prefer specific handling such as:

```python
except ValueError:
```

over immediately training students to use:

```python
except:
```

## Conceptual Model

```text
try
→ attempt the action

except
→ what should happen if this specific failure occurs?
```

## Common Misconception

An `except` block should not simply hide every possible error.

Students should increasingly ask:

> Which failure am I actually prepared to handle?

## Adaptive Question Targets

Write question families that ask students to:

- select an exception type,
- predict whether `except` executes,
- construct a handler,
- match an error to its handler,
- choose a useful error message,
- distinguish specific from broad handling.

---

# 14.3 `else`

## Primary Assessed Skills

- **uses_exception_else** - Uses `else` in exception-handling structure.
- **predicts_else_execution** - Recognizes that exception `else` runs when the `try` succeeds without the handled exception.
- **distinguishes_try_body_and_else_body** - Separates risky code from code that should run only after successful completion.
- **places_success_only_code_in_else** - Places appropriate success behavior in `else`.
- **traces_try_except_else** - Traces execution through the structure.

## Core Example

```python
try:
 age = int(input("Enter your age: "))
except ValueError:
 print("Please enter a whole number.")
else:
 print(f"You entered {age}.")
```

## Important Distinction

Students already know conditional:

```python
else:
```

Exception-handling `else` is related structurally but has a different trigger.

```text
conditional else
→ previous condition was false

exception else
→ try completed without the handled exception
```

This distinction should be explicitly assessed.

---

# 14.4 `finally`

## Primary Assessed Skills

- **uses_finally** - Writes a `finally` block correctly.
- **predicts_finally_execution** - Predicts that `finally` executes regardless of success or handled failure.
- **recognizes_finally_always_runs** - Understands its cleanup/final-action role.
- **selects_cleanup_code** - Identifies behavior appropriate for `finally`.
- **traces_try_except_else_finally** - Traces the complete exception-handling structure.

## Mental Model

`finally` means:

> Whether the attempt succeeded or failed, perform this final action.

## Example Structure

```python
try:
 ...
except ValueError:
 ...
else:
 ...
finally:
 ...
```

Students should be able to trace which blocks execute in:

### Successful case

```text
try
↓
else
↓
finally
```

### Handled-exception case

```text
try
↓
except
↓
finally
```

---

# Certification Extension: `raise`

## Recommended Placement

Teach `raise` inside:

> 14.6 Defensive Programming

rather than creating a separate lesson.

## Primary / Supporting Skills

- **recognizes_raise_statement** - Recognizes that `raise` intentionally triggers an exception.
- **raises_exception_for_invalid_state** - Uses `raise` in a straightforward situation where the program detects an unacceptable state.
- **selects_exception_to_raise** - Selects a reasonable exception for a guided scenario.
- **distinguishes_raise_from_except** - Distinguishes creating an exception from handling one.

The first two should be the strongest assessment targets.

## Core Distinction

```text
raise
→ intentionally create/report an exception

except
→ respond to an exception
```

## Example

```python
temperature = -5

if temperature < 0:
 raise ValueError("Temperature cannot be below zero for this system.")
```

Keep examples controlled and understandable.

---

# 14.5 Handling User Errors

## Primary Assessed Skills

- **handles_invalid_user_input** - Prevents invalid user input from terminating the program unexpectedly.
- **retries_after_invalid_input** - Allows another attempt when appropriate.
- **provides_clear_error_message** - Tells the user what went wrong in understandable language.
- **preserves_program_flow_after_error** - Allows the program to continue appropriately after handling a failure.
- **combines_loop_and_exception_handling** - Combines previously learned loops with exception handling.
- **selects_exception_for_input_failure** - Handles the likely exception produced by an input/conversion operation.

## Core Pattern

```python
while True:
 try:
 age = int(input("Enter your age: "))
 break
 except ValueError:
 print("Please enter a whole number.")
```

This combines:

```text
Unit 03
input

Unit 06
loops

Unit 13
ValueError

Unit 14
exception handling
```

## UX / Usability Connection

Compare:

### Poor experience

```text
Traceback...
ValueError...
```

with:

```text
Please enter a whole number.
```

The program should communicate:

- what happened,
- what the user can do next.

## Adaptive Question Targets

Write question families that ask students to:

- choose an exception to handle,
- select a useful user-facing message,
- complete a retry loop,
- predict repeated-input behavior,
- identify whether program flow continues,
- repair a program that crashes on invalid input.

---

# 14.6 Defensive Programming

## Primary Assessed Skills

- **anticipates_invalid_input** - Identifies values or situations that could create problems.
- **identifies_failure_point** - Identifies where a program is vulnerable to failure.
- **prevents_avoidable_failure** - Uses validation or program logic to avoid a predictable problem.
- **uses_exception_handling_when_needed** - Recognizes when exception handling is appropriate.
- **raises_invalid_state** - Uses `raise` in a guided invalid-state scenario.
- **designs_recovery_path** - Plans what should happen after a recoverable problem.
- **writes_user_friendly_failure_message** - Communicates failure clearly and constructively.

## Core Design Principle

Teach:

> Prevent when reasonably possible. Handle when failure is still possible.

Example:

Instead of intentionally creating:

```python
items[10]
```

and then catching `IndexError`, a program may first determine whether the index is valid.

Exception handling should not replace reasonable program logic.

## Defensive Programming Questions

Students should ask:

```text
What could go wrong?
↓
Can I prevent it?
↓
If I cannot fully prevent it, can I handle it?
↓
What should the user experience when it happens?
↓
Can the program recover?
```

## Strong Usability Connection

This is the course's clearest intersection of:

```text
technical correctness
+
user experience
```

A program is not fully usable if normal user mistakes cause:

- crashes,
- cryptic messages,
- lost progress,
- unclear recovery.

---

# Unit 14 Recommended Skill Categories

The major mastery categories are:

1. identifying risky operations,
2. `try`,
3. specific `except` handling,
4. `else`,
5. `finally`,
6. user-input recovery,
7. defensive programming,
8. basic `raise` usage,
9. exception-flow tracing.

## Skill-Tracking Note

Avoid creating separate adaptive banks for every tiny structural feature.

For example:

```text
uses colon
indents except body
indents finally body
```

should normally be assessed as part of broader syntax skills rather than becoming independent high-volume skill tags.

---

# Unit 14 Project: Safe Input System

## Project Goal

Students build a program designed to handle realistic user mistakes without crashing.

## Likely Required Skill Areas

Students should:

- accept user input,
- perform at least one conversion,
- use `try`,
- handle at least one specific exception,
- provide understandable error feedback,
- allow an appropriate retry,
- continue after successful input,
- use a loop appropriately,
- validate at least one value,
- demonstrate a defensive-programming decision.

## Possible Contexts

- player setup,
- game settings,
- age/number entry,
- character statistics,
- menu selection,
- calculator inputs.

## Project Assessment

Assess:

1. Does the program identify realistic failure opportunities?
2. Does it use specific exception handling appropriately?
3. Does it avoid crashing during expected user mistakes?
4. Are messages useful?
5. Can the user recover?
6. Is repeated input controlled correctly?
7. Can the student explain why each validation/exception decision exists?

## Stretch Opportunities

Students may:

- handle multiple exception types,
- create reusable input functions,
- use `else`,
- use `finally`,
- deliberately `raise` an exception for an invalid state,
- create multiple validation rules.

---

# UNIT 15: Testing Your Code - Skills Review

## Unit Scope

Unit 15 includes:

- 15.1 Why Testing Matters
- 15.2 Manual Testing
- 15.3 Assertions
- 15.4 Test Cases
- 15.5 Edge Cases
- 15.6 Introduction to Unit Testing

Project:

- Testing Challenge

Certification coverage includes:

- `unittest`
- testing Functions
- testing Methods
- Assert Methods
- `assertIsInstance`
- `assertEqual`
- `assertTrue`
- `assertIs`
- `assertIn`

The conceptual progression is:

```text
know what should happen
↓
test it deliberately
↓
compare expected and actual
↓
test boundaries and unusual inputs
↓
automate repeatable tests
```

---

# 15.1 Why Testing Matters

## Primary Assessed Skills

- **explains_testing_purpose** - Explains why code should be tested intentionally.
- **distinguishes_testing_from_debugging** - Distinguishes checking behavior from investigating an identified problem.
- **identifies_expected_behavior** - States what a program or function should do before testing it.
- **recognizes_repeatable_test_value** - Understands why consistent tests are useful.
- **recognizes_testing_before_release** - Understands that testing should happen before users discover failures.

## Core Distinction

```text
TESTING
→ intentionally check whether code behaves as expected

DEBUGGING
→ investigate and repair a known or suspected problem
```

Testing may reveal the need for debugging.

## Important Misconception

Students may think:

> I ran it once and it worked, so I tested it.

One successful example is evidence, but not sufficient testing.

---

# 15.2 Manual Testing

## Primary Assessed Skills

- **creates_manual_test** - Designs a straightforward test performed by the programmer.
- **defines_test_input** - Identifies the input being tested.
- **defines_expected_output** - Determines the expected behavior before running the test.
- **records_actual_output** - Records what actually occurred.
- **compares_expected_and_actual** - Determines whether behavior matched the expectation.
- **identifies_pass_fail_result** - Classifies the test result accurately.

## Recommended Testing Table

| Test Input | Expected Result | Actual Result | Pass / Fail |
|---|---|---|---|

Students should fill in:

```text
EXPECTED
```

before running the program whenever practical.

This reduces:

> changing the expected result after seeing what the code happened to do.

## Example

For:

```python
def double(number):
 return number * 2
```

Possible manual test:

| Input | Expected | Actual | Pass? |
|---:|---:|---:|---|
| 5 | 10 | 10 | Pass |

---

# 15.3 Assertions

## Primary Assessed Skills

- **uses_assert_statement** - Uses a basic Python `assert` statement.
- **predicts_assert_result** - Predicts whether an assertion succeeds or fails.
- **writes_assertion_for_expectation** - Converts an expected condition into an assertion.
- **recognizes_assertion_failure** - Recognizes what an assertion failure indicates.
- **connects_assertion_to_expected_behavior** - Understands that the assertion expresses what the programmer expects to be true.

## Basic Python Example

```python
result = 2 + 2

assert result == 4
```

The assertion represents:

> I expect `result == 4` to be true.

## Conceptual Model

```text
EXPECTED RULE
↓
assertion
↓
check actual program result
↓
pass or fail
```

## Important Distinction

This lesson can introduce basic:

```python
assert
```

before students encounter the more formal `unittest` methods in 15.6.

---

# Certification Assertion Methods

Students must also encounter:

```python
assertEqual
assertTrue
assertIs
assertIn
assertIsInstance
```

Do not make each method an entire lesson.

They should become part of:

- reference practice,
- selection questions,
- Unit 15.6 automated tests.

## Certification-Level Supporting Skills

- **recognizes_assert_equal** - Selects `assertEqual` when two values should be equal.
- **recognizes_assert_true** - Selects `assertTrue` when an expression should evaluate to `True`.
- **recognizes_assert_is** - Recognizes identity-based testing.
- **recognizes_assert_in** - Selects membership testing.
- **recognizes_assert_is_instance** - Selects an instance/type relationship test.
- **selects_assert_method** - Chooses an appropriate assertion method for a described expectation.

The final selection skill is more valuable than five isolated memorization banks.

---

# 15.4 Test Cases

## Primary Assessed Skills

- **writes_test_case** - Creates a test with a specific input and expected result.
- **identifies_test_input** - Identifies what value or situation is being tested.
- **identifies_expected_result** - States what should happen.
- **selects_representative_test** - Chooses a useful normal case.
- **creates_multiple_tests_for_function** - Uses more than one test to evaluate behavior.
- **names_test_case_clearly** - Describes what a test is intended to verify.

## Example

Given:

```python
def is_passing(score):
 return score >= 70
```

A weak testing strategy is:

```text
80
```

only.

A stronger set includes:

```text
69 → False
70 → True
71 → True
```

This prepares students for edge cases.

## Core Questions

For every test:

```text
What are we testing?
What input will we use?
What should happen?
Why is this test useful?
```

---

# 15.5 Edge Cases

## Primary Assessed Skills

- **recognizes_edge_case** - Recognizes an unusual or boundary input likely to expose errors.
- **identifies_boundary_value** - Identifies a meaningful threshold or limit.
- **tests_boundary_values** - Tests values at and around a boundary.
- **tests_empty_input** - Recognizes empty collections/strings as useful tests when relevant.
- **tests_extreme_or_unusual_input** - Chooses unusual but valid/possible values.
- **distinguishes_normal_and_edge_case** - Distinguishes representative use from boundary testing.
- **selects_edge_case_for_function** - Chooses an edge case likely to reveal a specific mistake.

## Core Mental Model

Do not only ask:

> What value will probably work?

Also ask:

> What value is most likely to reveal a mistake?

## Common Edge Cases

Depending on the program:

```text
0
negative values
empty string
empty list
one item
duplicate values
minimum allowed value
maximum allowed value
exact threshold
one below threshold
one above threshold
```

## Boundary Example

If passing is:

```python
score >= 70
```

then high-value tests include:

```text
69
70
71
```

because the most likely mistake occurs at the boundary.

## Adaptive Question Targets

Write question families that ask students to:

- identify a boundary,
- choose a useful edge case,
- distinguish normal and edge cases,
- determine which test is most likely to reveal an off-by-one error,
- construct tests around a threshold,
- explain why a test is useful.

---

# 15.6 Introduction to Unit Testing

## Primary Assessed Skills

- **imports_unittest** - Imports Python's `unittest` module.
- **recognizes_testcase_class** - Recognizes the basic `unittest.TestCase` structure.
- **writes_basic_unit_test** - Creates a simple automated test.
- **calls_function_under_test** - Calls the target function within a test.
- **uses_assert_equal** - Uses `assertEqual()` for a straightforward expected result.
- **selects_assert_method** - Chooses an appropriate assertion method.
- **runs_unit_tests** - Runs a basic unit-testing file.
- **interprets_test_result** - Determines whether tests passed or failed.

## Core Example

```python
import unittest

def add(a, b):
 return a + b

class TestAdd(unittest.TestCase):

 def test_add_positive_numbers(self):
 self.assertEqual(add(2, 3), 5)

if __name__ == "__main__":
 unittest.main()
```

Students do not need deep understanding of every structural detail immediately.

The essential mental model is:

```text
function
↓
known input
↓
expected result
↓
automated assertion
↓
pass / fail
```

---

# Assertion Method Selection

Students should recognize patterns such as:

## `assertEqual`

```python
self.assertEqual(actual, expected)
```

Use when:

> these two values should be equal.

---

## `assertTrue`

```python
self.assertTrue(condition)
```

Use when:

> this condition should be true.

---

## `assertIn`

```python
self.assertIn(item, collection)
```

Use when:

> this value should be present.

---

## `assertIs`

Use when:

> two references should identify the same object.

Keep this at certification-appropriate depth.

---

## `assertIsInstance`

Use when:

> a value should be an instance of a particular type/class.

Students need recognition and basic use, not advanced type-system knowledge.

---

# OOP Boundary

LearnKey's certification material refers to:

- functions,
- methods,
- classes.

FoxCS does not formally teach classes until Unit 19.

Therefore Unit 15 should teach the minimum certification vocabulary needed:

```text
function
→ reusable behavior

method
→ function associated with a class/object

class
→ framework used to create objects
```

Students may:

- read a prewritten class,
- identify a method,
- recognize a unit test for a method.

Students should **not** be expected to design and write substantial classes yet.

That belongs to Unit 19.

---

# Manual Testing vs Unit Testing

Students should explicitly compare:

```text
MANUAL TESTING
programmer runs a test and observes result

UNIT TESTING
test code runs checks automatically
```

Neither replaces the other completely.

The progression should feel like:

```text
I know what I expect
↓
I test it manually
↓
I identify important cases
↓
I automate repeatable checks
```

---

# Unit 15 Recommended Skill Categories

The major mastery categories are:

1. purpose of testing,
2. testing vs debugging,
3. expected vs actual behavior,
4. manual test design,
5. basic assertions,
6. test-case design,
7. boundary and edge-case testing,
8. basic `unittest`,
9. assertion-method selection,
10. interpretation of test results.

## Skill-Tracking Note

Do not create independent high-volume banks for all five `unittest` assertion methods.

A better structure is:

```text
selects_assert_method
```

as the major diagnostic skill, with the individual methods appearing as knowledge/components inside that family.

`assertEqual()` may receive somewhat deeper practice because it is likely to be the student's most commonly used unit-test assertion.

---

# Unit 15 Project: Testing Challenge

## Project Goal

Students demonstrate that they can evaluate a program systematically rather than relying on:

> It ran once, so it works.

## Possible Project Structure

Provide one or more functions such as:

```python
calculate_discount()
is_passing()
calculate_damage()
validate_score()
```

Students must build a testing plan.

## Required Skills

Students should:

- identify expected behavior,
- write normal test cases,
- identify meaningful edge cases,
- record expected results,
- perform manual testing,
- write automated tests,
- use at least one assertion method,
- interpret failures,
- debug a failure when one is discovered,
- rerun tests after revision.

## Project Assessment

Assess:

1. Are expected results defined before testing?
2. Are normal cases included?
3. Are meaningful edge cases included?
4. Are boundaries tested?
5. Are automated tests valid?
6. Are assertion methods selected appropriately?
7. Can the student interpret a failed test?
8. Does the student revise code based on evidence?
9. Does the student rerun tests after making changes?

## Stretch Opportunities

Students may:

- write a larger `unittest.TestCase`,
- use several assertion methods,
- test multiple functions,
- test a prewritten method,
- create regression tests for previously discovered bugs,
- build a more complete test suite.

---

# Units 13-15 Conceptual Progression

## Unit 13: Debugging and Errors

Students learn:

> Something has already gone wrong. How do I understand what happened?

```text
observe failure
↓
classify
↓
read evidence
↓
trace
↓
form hypothesis
↓
repair
```

---

## Unit 14: Exception Handling

Students learn:

> Something might go wrong. How can the program respond safely?

```text
anticipate
↓
try
↓
handle
↓
recover
↓
communicate clearly
```

---

## Unit 15: Testing Your Code

Students learn:

> How can I intentionally look for problems before a user discovers them?

```text
define expected behavior
↓
design test
↓
run test
↓
compare
↓
find edge cases
↓
automate
```

---

# Three-Unit Quality Progression

The overall progression is:

```text
UNIT 13
DEBUG

Understand failure after it appears.

↓

UNIT 14
HANDLE

Design the program to recover from expected failure.

↓

UNIT 15
TEST

Look for failure proactively before release.
```

Another useful framing is:

```text
What went wrong?
↓
What should happen when something goes wrong?
↓
How can I know whether the program works?
```

Together, these units shift students from:

> getting code to run

toward:

> building code they can trust, explain, test, and improve.

# UNIT 16: File Input & Output - Skills Review

## Unit Scope

Unit 16 includes:

- 16.1 Why Files Matter
- 16.2 Reading Files
- 16.3 Writing Files
- 16.4 Appending Files
- 16.5 Context Managers
- 16.6 Processing Text Files

Project:

- Journal Application

The main conceptual progression is:

```text
program data exists temporarily
↓
save data outside the running program
↓
read saved data
↓
write new data
↓
add to existing data
↓
manage files safely
↓
process stored text
```

This unit introduces persistence.

Until now, most program state has disappeared when the program ends.

Files allow programs to remember information between runs.

---

# 16.1 Why Files Matter

## Primary Assessed Skills

- **explains_file_persistence** - Explains why files allow information to remain available after a program stops.
- **distinguishes_memory_and_file_storage** - Distinguishes temporary program variables from persistent file data.
- **identifies_file_use_case** - Recognizes when a program should store information in a file.
- **distinguishes_read_write_append_goals** - Identifies whether a task requires reading, replacing, or adding data.
- **recognizes_file_path_role** - Understands that a program needs a location/name to access a file.
- **selects_file_operation_for_goal** - Chooses an appropriate general file operation from a stated need.

## Core Mental Model

Variables are like information written on a temporary whiteboard:

```text
program starts
↓
variables exist
↓
program ends
↓
variable state disappears
```

A file is more like information saved in a notebook:

```text
program writes information
↓
program ends
↓
file remains
↓
future program run can read it
```

## Game Connection

Files can store:

- player names,
- saved progress,
- high scores,
- settings,
- inventory,
- logs,
- game history.

A save system is fundamentally a persistence system.

## Core File Operations

Students should conceptually distinguish:

```text
READ
→ get existing information

WRITE
→ create or replace information

APPEND
→ add information to the end
```

## Adaptive Question Targets

Write question families that ask students to:

- distinguish persistent and temporary information,
- choose read/write/append for a scenario,
- identify why a program may need a file,
- identify what could be stored in a save file,
- distinguish replacing data from adding data.

---

# 16.2 Reading Files

## Primary Assessed Skills

- **opens_file_for_reading** - Opens a file in read mode.
- **uses_read_method** - Reads file content using `.read()`.
- **stores_file_content** - Stores retrieved file content in a variable.
- **predicts_file_read_result** - Predicts what information is retrieved.
- **distinguishes_file_object_and_contents** - Distinguishes the opened file object from the text stored inside the file.
- **closes_open_file** - Closes a manually opened file when appropriate.
- **debugs_basic_read_failure** - Diagnoses straightforward problems in file-reading code.

## Core Example

```python
file = open("message.txt", "r")

message = file.read()

print(message)

file.close()
```

## Conceptual Flow

```text
file on computer
↓
open connection
↓
read contents
↓
store contents
↓
use contents in program
↓
close connection
```

## Important Distinction

This:

```python
file = open("message.txt", "r")
```

does not mean:

> `file` contains the text itself.

It represents the opened file object.

This:

```python
message = file.read()
```

retrieves the contents.

## Common Misconceptions

Students may:

- forget quotation marks around the filename,
- confuse the file object with file contents,
- expect `open()` to automatically print the file,
- use the wrong mode,
- forget `.read()`,
- attempt to work with a file that is not where the program expects it.

## Adaptive Question Targets

Write question families that ask students to:

- identify read mode,
- sequence opening and reading,
- identify which variable stores content,
- predict printed output,
- identify a missing `.read()`,
- repair straightforward file-reading code.

---

# 16.3 Writing Files

## Primary Assessed Skills

- **opens_file_for_writing** - Opens a file using write mode.
- **uses_write_method** - Writes text to a file.
- **recognizes_write_can_replace_content** - Understands that writing to an existing file can overwrite prior contents.
- **creates_file_with_write_mode** - Recognizes that write mode can create a file when appropriate.
- **writes_newline_character** - Uses `\n` when stored output needs a new line.
- **writes_string_data_to_file** - Supplies appropriate text data to `.write()`.
- **verifies_written_file_content** - Checks whether the expected information was saved.

## Core Example

```python
file = open("score.txt", "w")

file.write("100")

file.close()
```

## Critical Warning

Students should understand:

```text
"w"
```

is not:

> add more information.

It may replace what was already stored.

That distinction becomes essential before 16.4.

## Newline Example

```python
file.write("Alex\n")
file.write("Jordan\n")
```

creates separate lines.

## Important Type Connection

`.write()` expects string data.

Students may need:

```python
file.write(str(score))
```

rather than:

```python
file.write(score)
```

This meaningfully retrieves Unit 02 type-conversion skills.

## Adaptive Question Targets

Write question families that ask students to:

- identify write mode,
- predict whether existing content is replaced,
- add newline characters,
- identify a type problem,
- sequence opening/writing/closing,
- repair write code,
- determine what a resulting file contains.

---

# 16.4 Appending Files

## Primary Assessed Skills

- **opens_file_for_appending** - Opens a file in append mode.
- **uses_append_file_pattern** - Adds new text without replacing existing content.
- **distinguishes_append_and_write** - Chooses correctly between `a` and `w`.
- **predicts_appended_file_content** - Predicts resulting content after appending.
- **uses_newline_when_appending** - Formats appended records appropriately.
- **selects_append_for_history_data** - Recognizes when accumulating information is appropriate.

## Core Example

Existing file:

```text
Alex
Jordan
```

Code:

```python
file = open("players.txt", "a")

file.write("Maya\n")

file.close()
```

Result:

```text
Alex
Jordan
Maya
```

## Core Distinction

```text
WRITE
→ replace/create content

APPEND
→ keep old content and add more
```

## Strong Use Cases

Append is appropriate for:

- journals,
- activity logs,
- score history,
- event logs,
- game session history.

## Adaptive Question Targets

Write question families that ask students to:

- select append vs write,
- predict resulting file contents,
- identify an incorrect mode,
- add properly separated entries,
- choose append for a persistent-history scenario.

---

# 16.5 Context Managers

## Primary Assessed Skills

- **uses_with_statement_for_file** - Opens a file using a `with` statement.
- **recognizes_automatic_file_closing** - Understands that the context manager handles closing automatically.
- **identifies_context_manager_scope** - Identifies which statements operate while the file is open.
- **rewrites_manual_file_pattern_with_with** - Converts open/use/close code to a context-manager structure.
- **selects_context_manager_for_safe_file_use** - Recognizes `with` as the preferred beginner pattern for routine file access.
- **traces_with_statement_execution** - Predicts what happens inside and after the block.

## Core Example

```python
with open("message.txt", "r") as file:
 message = file.read()

print(message)
```

## Mental Model

Think:

> Use this file while I am inside this block.

When execution leaves the block:

```text
file is automatically closed
```

## Before and After

### Manual

```python
file = open("message.txt", "r")
message = file.read()
file.close()
```

### Context Manager

```python
with open("message.txt", "r") as file:
 message = file.read()
```

## Important Misconception

Students may think:

```python
as file
```

means the file's text is immediately stored in `file`.

It does not.

`file` is still the file object.

The program still needs:

```python
file.read()
```

to retrieve content.

---

# 16.6 Processing Text Files

## Primary Assessed Skills

- **processes_file_text** - Uses file contents as program data.
- **iterates_through_file_lines** - Processes text one line at a time when appropriate.
- **removes_unwanted_line_breaks** - Handles newline characters when processing stored text.
- **splits_file_content** - Breaks stored text into useful components when appropriate.
- **combines_file_io_with_prior_skills** - Uses loops, conditionals, lists, or functions with file data.
- **extracts_information_from_text_file** - Retrieves useful information from stored text.
- **transforms_file_data** - Converts stored text into a useful representation.
- **selects_processing_strategy** - Chooses an appropriate approach for a file-processing task.

## Example

File:

```text
Alex
Maya
Jordan
```

Possible program:

```python
with open("players.txt", "r") as file:
 for line in file:
 print(line.strip())
```

## Integration

This lesson should deliberately retrieve:

```text
strings
+
loops
+
lists
+
conditionals
+
functions
+
files
```

Students are no longer learning these concepts independently.

They are composing them.

---

# Certification Supporting Content: File Existence and Deletion

The certification sequence also includes:

- checking whether a file exists,
- deleting a file.

These do not need new full FoxCS lessons, but students should receive explicit exposure during Unit 16.

## Supporting Skills

- **recognizes_file_existence_check** - Understands why a program may verify that a file exists before using it.
- **selects_file_existence_check_for_safety** - Recognizes appropriate situations for checking before access.
- **recognizes_file_deletion_operation** - Understands that programs can remove files.
- **recognizes_file_deletion_risk** - Understands that deletion is destructive and should be used deliberately.

## Course Boundary

Do not turn this into the full operating-system module lesson.

Unit 18 owns:

- `os`,
- `os.path`,
- system-level path operations.

Unit 16 owns the file-I/O concept:

> What should a program do with persistent data?

---

# Unit 16 Recommended Skill Categories

The major mastery categories are:

1. persistence,
2. reading,
3. writing,
4. appending,
5. file modes,
6. context managers,
7. text-file processing,
8. combining files with prior programming structures.

---

# Unit 16 Project: Journal Application

## Project Goal

Students create a program that stores written journal entries persistently.

This deliberately connects the programming project to the journal-writing habit students have used throughout the course.

## Likely Required Skill Areas

Students should:

- accept a journal entry,
- save the entry to a file,
- preserve earlier entries,
- read stored entries,
- use a context manager,
- format stored entries clearly,
- use appropriate file modes,
- handle newlines correctly,
- organize code with functions where appropriate.

## Possible Features

Core:

```text
Write entry
View entries
Exit
```

## Project Assessment

Assess:

1. correct file mode selection,
2. persistence between runs,
3. readable stored data,
4. correct use of context managers,
5. successful reading,
6. successful appending,
7. integration of prior programming skills.

## Stretch Opportunities

Students may add:

- timestamps later after Unit 17,
- entry titles,
- search,
- multiple journal files,
- categories,
- deletion with confirmation,
- summary statistics.

Do not require Unit 17 datetime functionality in the core project before it is taught.

---

# UNIT 17: Dates, Times, and Calendars - Skills Review

## Unit Scope

Unit 17 includes:

- 17.1 What Is Datetime?
- 17.2 Current Date and Time
- 17.3 Timedelta
- 17.4 Date Calculations
- 17.5 `strftime`
- 17.6 Practical Date Programs

Project:

- Event Countdown

The main conceptual progression is:

```text
represent time
↓
get current time
↓
represent a duration
↓
calculate between dates
↓
format time for humans
↓
build useful time-based behavior
```

Certification coverage particularly includes:

- `now`
- `strftime`
- `weekday`

FoxCS extends this into broader practical date calculations.

---

# 17.1 What Is Datetime?

## Primary Assessed Skills

- **recognizes_datetime_module** - Recognizes Python's datetime tools as support for dates and times.
- **distinguishes_date_time_and_duration** - Distinguishes a moment/date from an amount of elapsed time.
- **identifies_datetime_use_case** - Recognizes when a program needs date/time information.
- **imports_datetime_tools** - Imports the required datetime functionality.
- **reads_datetime_value** - Interprets the major components of a datetime value.

## Conceptual Model

A datetime represents:

> a particular point on a calendar and clock.

Examples:

```text
September 5, 2026
3:30 PM
September 5, 2026 at 3:30 PM
```

A duration is different:

```text
three days
two hours
45 seconds
```

That distinction becomes important in 17.3.

## Game Connection

Datetime tools can support:

- cooldowns,
- daily rewards,
- event start/end dates,
- session logs,
- countdowns,
- scheduled content.

---

# 17.2 Current Date and Time

## Primary Assessed Skills

- **gets_current_datetime** - Retrieves the current date/time.
- **stores_current_datetime** - Stores the returned value for later use.
- **accesses_datetime_component** - Reads useful components when appropriate.
- **uses_weekday_value** - Retrieves or interprets weekday information.
- **predicts_dynamic_time_behavior** - Recognizes that current-time code produces different values at different moments.
- **distinguishes_fixed_and_current_datetime** - Distinguishes hard-coded dates from dynamically retrieved current time.

## Core Example

```python
from datetime import datetime

now = datetime.now()

print(now)
```

## Conceptual Shift

Students should understand:

> The exact result depends on when the program runs.

The code is predictable.

The returned data changes.

---

# Certification Supporting Skill: `weekday()`

## Primary / Supporting Skills

- **uses_weekday_method** - Retrieves weekday information from a date.
- **interprets_weekday_number** - Interprets the returned weekday number using the relevant Python convention.
- **connects_weekday_to_date** - Uses weekday information in a practical program.

This can live inside 17.2 or 17.6 rather than requiring another lesson.

---

# 17.3 Timedelta

## Primary Assessed Skills

- **creates_timedelta** - Creates a duration using `timedelta`.
- **recognizes_timedelta_as_duration** - Understands that a timedelta represents elapsed time rather than a specific calendar moment.
- **uses_timedelta_days** - Represents a straightforward number of days.
- **uses_timedelta_hours_minutes** - Represents smaller time intervals when appropriate.
- **adds_timedelta_to_datetime** - Calculates a later datetime.
- **subtracts_timedelta_from_datetime** - Calculates an earlier datetime.
- **distinguishes_datetime_and_timedelta** - Chooses correctly between point-in-time and duration values.

## Core Distinction

```text
datetime
→ when?

timedelta
→ how long?
```

## Example

```python
from datetime import datetime, timedelta

today = datetime.now()

next_week = today + timedelta(days=7)
```

---

# 17.4 Date Calculations

## Primary Assessed Skills

- **subtracts_datetimes** - Calculates the duration between two datetime values.
- **calculates_future_date** - Determines a future date using a duration.
- **calculates_past_date** - Determines a previous date using a duration.
- **interprets_date_difference** - Interprets the resulting time difference.
- **selects_date_calculation** - Chooses an appropriate arithmetic operation for a time problem.
- **uses_date_calculation_in_condition** - Uses calculated time information in program logic.
- **debugs_date_calculation** - Repairs straightforward date-calculation mistakes.

## Core Patterns

```text
datetime + timedelta
→ future datetime
```

```text
datetime - timedelta
→ earlier datetime
```

```text
datetime - datetime
→ duration
```

Students should distinguish all three.

## Applied Examples

- days until an event,
- days since an event,
- unlock date,
- account age,
- time remaining,
- next scheduled reward.

---

# 17.5 `strftime`

## Primary Assessed Skills

- **uses_strftime** - Formats a datetime as text.
- **recognizes_format_code_role** - Understands that formatting codes determine displayed components.
- **formats_date_for_user** - Produces a clear human-readable date.
- **formats_time_for_user** - Produces readable time output.
- **distinguishes_datetime_and_formatted_string** - Recognizes that `strftime()` produces text.
- **selects_format_from_reference** - Uses a reference to choose appropriate formatting codes.

## Conceptual Model

A datetime contains data.

`strftime()` controls:

> how that data is shown to a person.

## Example

```python
formatted = now.strftime("%m-%d-%Y")
```

Students do not need to memorize every format code.

An important skill is:

> use a formatting reference accurately.

## UX Connection

These may represent the same underlying date:

```text
09-05-2026
September 5, 2026
Sat, Sep 5
```

Formatting is partly a usability decision.

---

# 17.6 Practical Date Programs

## Primary Assessed Skills

- **combines_datetime_tools** - Uses multiple datetime concepts in one program.
- **builds_countdown_logic** - Calculates time remaining until an event.
- **builds_elapsed_time_logic** - Calculates time since an event.
- **formats_calculated_date_output** - Makes calculated dates readable.
- **uses_date_logic_in_program** - Uses date/time values to affect program behavior.
- **selects_datetime_tool_for_problem** - Chooses `datetime`, `timedelta`, `weekday`, or `strftime` appropriately.
- **explains_time_based_program_flow** - Explains how time information affects the program.

## Synthesis

Students should increasingly see:

```text
datetime.now()
+
timedelta
+
date arithmetic
+
strftime()
+
conditionals
```

as parts of one system rather than unrelated functions.

---

# Unit 17 Recommended Skill Categories

The major mastery categories are:

1. datetime representation,
2. current date/time,
3. date vs duration,
4. timedelta,
5. date arithmetic,
6. weekday information,
7. output formatting,
8. practical time-based programs.

---

# Unit 17 Project: Event Countdown

## Project Goal

Students build a program that calculates and displays time remaining until a meaningful future event.

## Likely Required Skill Areas

Students should:

- represent a target date,
- retrieve the current date/time,
- calculate a difference,
- interpret the resulting duration,
- format output clearly,
- use at least one conditional based on the countdown,
- organize code cleanly.

## Example Output

```text
Event: Game Launch
Date: October 15, 2026
Days Remaining: 40
```

## Possible Conditional Feedback

```text
more than 30 days
→ "Still some time to go."

7-30 days
→ "Getting close!"

0-6 days
→ "Almost here!"
```

## Stretch Opportunities

Students may:

- allow user-entered dates,
- display hours/minutes,
- support multiple events,
- determine weekdays,
- add countdown information to the Unit 16 Journal Application,
- create recurring-event logic.

---

# UNIT 18: Working with the Computer - Skills Review

## Unit Scope

Unit 18 includes:

- 18.1 Introduction to `os`
- 18.2 `getcwd`
- 18.3 `listdir`
- 18.4 `exists`
- 18.5 Introduction to `sys`
- 18.6 Command-Line Arguments

Project:

- File Finder

Certification coverage also includes:

- `io`
- `os.path`
- broader `sys` behavior,
- the remaining Domain 3 command-line content.

The main conceptual progression is:

```text
Python program
↓
interact with operating system
↓
identify current location
↓
inspect files/folders
↓
construct and verify paths
↓
receive information from command line
```

This unit should feel like:

> Python can interact with the environment around the program.

Unit 18 is also the final unit containing new LearnKey workbook/video certification content.

---

# Certification Supporting Concept: `io`

The certification sequence includes the `io` module.

FoxCS does not currently give it a dedicated lesson.

It should receive explicit exposure during the Unit 18 module overview.

## Supporting Skills

- **recognizes_io_module** - Recognizes `io` as a standard-library module related to input/output streams.
- **distinguishes_memory_stream_and_physical_file** - Recognizes that some streams can operate in memory rather than on a physical file.
- **recognizes_stringio_purpose** - Recognizes `StringIO` as an in-memory text stream at certification depth.
- **uses_module_reference** - Uses reference material to interpret unfamiliar module functionality.

Do not turn `io` into a major independent FoxCS programming sequence.

---

# 18.1 Introduction to `os`

## Primary Assessed Skills

- **imports_os_module** - Imports `os`.
- **recognizes_os_module_purpose** - Recognizes that `os` provides operating-system-related tools.
- **calls_os_function** - Calls a straightforward function from the module.
- **identifies_os_use_case** - Recognizes when a program needs information about files, folders, or the operating environment.
- **distinguishes_file_content_and_file_system** - Distinguishes working with data inside files from working with the file system itself.
- **uses_os_reference** - Uses documentation/reference material for an unfamiliar `os` function.

## Important Unit Boundary

Unit 16 asked:

> What information is stored in the file?

Unit 18 asks:

> Where is the file, does it exist, and what files/folders are around it?

That distinction should be explicit.

---

# 18.2 `getcwd`

## Primary Assessed Skills

- **uses_getcwd** - Retrieves the current working directory.
- **interprets_working_directory** - Explains what the current working directory represents.
- **connects_working_directory_to_relative_path** - Recognizes why relative filenames depend on the program's current location.
- **uses_working_directory_for_debugging** - Uses the current directory to diagnose a missing-file problem.
- **predicts_getcwd_output_type** - Recognizes that the result is path information represented as text.

## Core Mental Model

The current working directory answers:

> Where is Python looking from right now?

This becomes highly useful when students say:

> But the file is right there!

and Python cannot find it.

---

# 18.3 `listdir`

## Primary Assessed Skills

- **uses_listdir** - Retrieves the contents of a directory.
- **interprets_directory_listing** - Interprets returned file/folder names.
- **loops_through_directory_items** - Iterates through directory entries.
- **searches_directory_listing** - Uses prior searching/membership skills with a directory list.
- **distinguishes_directory_and_file** - Recognizes the conceptual difference between a folder and a file.
- **uses_listdir_for_file_discovery** - Uses directory inspection to find available files.

## Strong Prior-Skill Integration

`os.listdir()` produces data students can treat like a collection.

That connects naturally to:

- lists,
- loops,
- membership,
- searching.

---

# 18.4 `exists`

## Primary Assessed Skills

- **checks_path_exists** - Determines whether a path exists.
- **uses_os_path_tools** - Uses `os.path` functionality at an introductory level.
- **interprets_exists_boolean** - Recognizes that an existence check returns Boolean information.
- **uses_exists_in_condition** - Uses an existence test to control program behavior.
- **builds_path_with_join** - Uses `os.path.join()` in a guided path-construction situation.
- **distinguishes_valid_and_invalid_path** - Determines whether a path points to an available resource.
- **prevents_missing_path_failure** - Checks before attempting an operation when appropriate.

## Core Example Pattern

```python
if os.path.exists(file_path):
 print("File found.")
else:
 print("File not found.")
```

## Defensive Programming Connection

This retrieves Unit 14:

> Check predictable problems before they become failures.

---

# 18.5 Introduction to `sys`

## Primary Assessed Skills

- **imports_sys_module** - Imports `sys`.
- **recognizes_sys_module_purpose** - Recognizes `sys` as access to interpreter/system-related functionality.
- **reads_sys_argv** - Recognizes command-line argument information in `sys.argv`.
- **recognizes_program_name_in_argv** - Understands that the script itself occupies the first argument position.
- **accesses_command_line_argument** - Retrieves a provided argument by index.
- **recognizes_missing_argument_risk** - Identifies how accessing an unavailable argument can fail.
- **uses_sys_reference** - Interprets a straightforward `sys` tool using documentation/reference material.

## Conceptual Model

When a program is run from the command line:

```text
python game.py Alex
```

the command contains information.

`sys.argv` lets the Python program inspect that information.

---

# 18.6 Command-Line Arguments

## Primary Assessed Skills

- **runs_python_from_command_line** - Runs a Python program using a command-line interface.
- **passes_command_line_argument** - Supplies an argument when launching the program.
- **accesses_command_line_argument_value** - Uses `sys.argv` to retrieve supplied input.
- **maps_argument_position_to_value** - Connects argument order to list indexes.
- **distinguishes_console_input_and_cli_argument** - Distinguishes `input()` from launch-time arguments.
- **validates_argument_count** - Checks whether expected arguments are available.
- **uses_cli_argument_in_program** - Uses the supplied value meaningfully.
- **debugs_basic_cli_execution** - Resolves straightforward issues involving launch location or missing arguments.

## Core Comparison

### Runtime Prompt

```python
name = input("Name: ")
```

The program starts first.

Then it asks the user for input.

### Command-Line Argument

```text
python game.py Alex
```

The information is supplied as the program is launched.

Students should distinguish these two input mechanisms.

## Connection to Lists

`sys.argv` behaves like an ordered collection.

Students can use their prior indexing knowledge:

```text
argv[0]
→ script/program name

argv[1]
→ first supplied argument
```

---

# Unit 18 Recommended Skill Categories

The major mastery categories are:

1. module use,
2. file system vs file contents,
3. current working directory,
4. directory listing,
5. path existence,
6. basic `os.path`,
7. `sys`,
8. command-line arguments,
9. file-system troubleshooting.

---

# Unit 18 Project: File Finder

## Project Goal

Students build a utility that helps a user inspect and locate files.

## Likely Required Skill Areas

Students should:

- import appropriate modules,
- identify the current directory,
- list directory contents,
- accept or receive a filename,
- check whether a path exists,
- clearly report whether the file was found,
- use loops/conditions appropriately,
- organize output clearly.

## Possible Core Interaction

```text
Current Folder:
...

Files:
...

Enter a filename:
notes.txt

Result:
notes.txt was found.
```

## Project Assessment

Assess:

- correct module use,
- correct path reasoning,
- appropriate Boolean checks,
- correct directory inspection,
- clear user feedback,
- integration with prior list/search skills.

## Stretch Opportunities

Students may:

- search a subfolder,
- accept a command-line filename,
- show full paths,
- filter by extension,
- count file types,
- sort results,
- create a more advanced directory search.

Do not require recursive directory traversal unless intentionally introduced as Extend.

---

# Unit 18 Certification Completion Checkpoint

Unit 18 is the **hard completion point for new certification courseware**.

Before students transition into the final certification-preparation phase, verify:

- [ ] All required LearnKey videos have been completed.
- [ ] All mapped workbook pages have been completed.
- [ ] All Fill-in-the-Blanks activities have been completed.
- [ ] All LearnKey Coding Exercises have been completed.
- [ ] All certification reviews have been completed.
- [ ] All starter-file activities have been completed.
- [ ] All six certification domains have been encountered.
- [ ] Students have access to the certification study guide.
- [ ] Students understand how to interpret domain-level practice results.

At this point:

```text
NEW CERTIFICATION CONTENT
→ complete

CERTIFICATION READINESS
→ becomes an ongoing focus
```

---

# Certification Preparation Transition After Unit 18

Beginning after Unit 18, certification preparation should shift from:

```text
LEARN NEW CERTIFICATION CONTENT
```

to:

```text
ASSESS
↓
IDENTIFY WEAK AREAS
↓
STUDY
↓
TARGET PRACTICE
↓
REASSESS
↓
CERTIFICATION EXAM
```

Students should begin completing:

- full-length certification practice exams,
- study-guide review,
- domain-specific practice,
- targeted remediation,
- repeated readiness checks.

This work runs alongside Units 19-20 rather than replacing them.

---

# Full-Length Certification Practice Exams

Beginning after Unit 18, students should regularly complete full-length IT Specialist - Python practice exams.

The first full-length practice exam should primarily function as a diagnostic.

Full-length practice exams allow students to:

- experience the complete exam format,
- practice moving between certification domains,
- develop testing endurance,
- identify concepts that have not transferred from lesson practice,
- receive overall and domain-level proficiency data,
- identify what to study next.

The primary question after a practice exam should be:

> What does this result tell me to study next?

rather than simply:

> What score did I get?

---

# Domain-Specific Practice

Students should use practice-exam results to identify their lowest-proficiency certification areas.

The six domains are:

1. Operations Using Data Types and Operators
2. Flow Control with Decisions and Loops
3. Input and Output Operations
4. Code Documentation and Structure
5. Troubleshooting and Error Handling
6. Operations Using Modules and Tools

After a practice exam:

```text
FULL PRACTICE EXAM
↓
REVIEW DOMAIN SCORES
↓
IDENTIFY LOWEST-PROFICIENCY DOMAIN
↓
USE STUDY GUIDE
↓
COMPLETE DOMAIN-SPECIFIC PRACTICE
↓
REVIEW MISSED CONCEPTS
↓
REASSESS
```

Students should not automatically receive equal review across all six domains.

---

# Using the Certification Study Guide

The study guide should now become an active diagnostic-reference tool.

Students should use it to:

- review terminology connected to missed questions,
- locate forgotten syntax,
- refresh uncommon certification functions,
- review objective-specific concepts,
- identify what they do and do not remember,
- prepare before targeted practice,
- confirm understanding after remediation.

The study guide should not simply become:

> read the entire study guide again.

Instead:

```text
practice evidence
↓
specific weakness
↓
specific study-guide section
↓
specific practice
```

---

# Certification Domain-to-Unit Review Map

| Certification Domain | Primary FoxCS Units for Review |
|---|---|
| Domain 1 - Data Types and Operators | Units 02, 04, 05, 08, 09, 10 |
| Domain 2 - Decisions and Loops | Units 05-06 |
| Domain 3 - Input and Output | Units 03, 16, 18 |
| Domain 4 - Documentation and Functions | Unit 07 |
| Domain 5 - Troubleshooting and Error Handling | Units 13-15 |
| Domain 6 - Modules and Tools | Units 11, 12, 17, 18 |

Students should increasingly move from:

```text
"My Domain 5 score is low."
```

to:

```text
"I need to review debugging, exception handling, and testing."
```

and eventually:

```text
"My weakest skills are exception-flow tracing and choosing assertion methods."
```

That level of diagnosis is the goal.

---

# UNIT 19: Classes and Objects - Skills Review

## Unit Scope

Unit 19 includes:

- 19.1 What Are Objects?
- 19.2 Creating Classes
- 19.3 Attributes
- 19.4 Methods
- 19.5 `__init__`
- 19.6 Modeling Real-World Systems
- 19.7 Introduction to Inheritance

Project:

- Employee Management System

This unit is FoxCS-original.

The IT Specialist - Python certification does not require full object-oriented programming.

The conceptual progression is:

```text
related data + behavior
↓
object
↓
class as blueprint
↓
attributes
↓
methods
↓
constructor
↓
multiple modeled entities
↓
shared structure through inheritance
```

This is one of the largest conceptual shifts in the course.

---

# Unit 19 Parallel Certification Thread

Unit 19 should not be replaced with certification review.

Instead, students now work toward two goals in parallel:

```text
FOXCS CORE
Classes and Objects

+

CERTIFICATION PREP
Diagnostic practice and targeted remediation
```

Possible certification work during Unit 19:

- first or additional full-length practice exam,
- domain-score analysis,
- study-guide review,
- domain-specific practice,
- objective-specific remediation,
- teacher-assigned practice based on proficiency,
- review of uncommon certification tools.

Students who demonstrate strong readiness may spend less time on remediation.

Students whose diagnostic evidence shows clear weaknesses should receive more targeted practice.

---

# 19.1 What Are Objects?

## Primary Assessed Skills

- **recognizes_object** - Recognizes an object as a programming entity containing related state and behavior.
- **distinguishes_class_and_object** - Distinguishes a blueprint/type from an individual instance.
- **identifies_object_state** - Identifies information an object needs to remember.
- **identifies_object_behavior** - Identifies actions an object should perform.
- **groups_state_and_behavior** - Recognizes related variables/functions that could belong together.
- **models_entity_as_object** - Determines when an entity is a useful candidate for object-oriented modeling.

## Mental Model

A class is a blueprint.

An object is one thing created from that blueprint.

Example:

```text
CLASS
Player

OBJECTS
player_one
player_two
player_three
```

Each player can follow the same structure while storing different values.

## Game Connection

Possible game objects:

- Player
- Enemy
- Item
- Weapon
- Door
- Quest
- Level

---

# 19.2 Creating Classes

## Primary Assessed Skills

- **writes_class_definition** - Writes basic Python class syntax.
- **recognizes_class_keyword** - Identifies `class`.
- **names_class_conventionally** - Uses an appropriate class-name convention.
- **creates_object_instance** - Creates an instance from a class.
- **distinguishes_class_definition_and_instantiation** - Distinguishes defining a class from creating an object.
- **predicts_multiple_instances** - Understands that one class can create multiple independent objects.

## Basic Example

```python
class Player:
 pass

player_one = Player()
player_two = Player()
```

## Core Distinction

```text
class Player:
→ define the blueprint

Player()
→ create an object from the blueprint
```

## Connection to Functions

Students have already seen:

```python
def
```

as defining reusable behavior.

Now they see:

```python
class
```

as defining a reusable entity structure.

---

# 19.3 Attributes

## Primary Assessed Skills

- **creates_instance_attribute** - Stores data on an object.
- **accesses_instance_attribute** - Retrieves an attribute using dot notation.
- **updates_instance_attribute** - Changes object state.
- **distinguishes_attributes_between_instances** - Recognizes that different objects can have different values.
- **predicts_object_state** - Traces attribute values over time.
- **selects_attribute_for_entity** - Identifies appropriate state for a modeled object.

## Conceptual Model

Variables describe program state.

Attributes describe:

> state belonging to a particular object.

Example:

```text
player_one.health
player_two.health
```

These represent separate state.

## Game Example

```text
Player
├── name
├── health
├── score
└── level
```

---

# 19.4 Methods

## Primary Assessed Skills

- **recognizes_method** - Recognizes a function belonging to a class.
- **defines_instance_method** - Writes a basic method.
- **calls_instance_method** - Calls behavior through an object.
- **uses_self_parameter** - Uses `self` in basic method definitions.
- **accesses_attribute_from_method** - Uses object state inside behavior.
- **updates_attribute_from_method** - Changes object state through a method.
- **distinguishes_function_and_method** - Distinguishes standalone functions from behavior associated with an object.
- **selects_method_for_entity_behavior** - Determines appropriate actions for an object.

## Core Comparison

```text
FUNCTION
heal_player(player)

METHOD
player.heal()
```

Both can solve problems.

The method version communicates:

> healing is behavior belonging to this Player object.

## Game Connection

Possible methods:

```text
player.jump()
player.attack()
player.heal()

enemy.take_damage()
enemy.move()

item.use()
```

This brings the Unit 07 game-ability analogy back at a more advanced level.

---

# 19.5 `__init__`

## Primary Assessed Skills

- **recognizes_init_method** - Recognizes `__init__` as initialization behavior.
- **defines_init_method** - Writes a basic constructor-style initializer.
- **initializes_instance_attributes** - Sets initial object state.
- **passes_values_during_instantiation** - Supplies values when creating an object.
- **maps_constructor_arguments_to_attributes** - Traces values into object state.
- **distinguishes_parameter_and_attribute** - Distinguishes temporary method parameters from stored object attributes.
- **predicts_initialized_object_state** - Determines state immediately after object creation.

## Core Example

```python
class Player:
 def __init__(self, name, health):
 self.name = name
 self.health = health
```

Create:

```python
player = Player("Alex", 100)
```

Resulting state:

```text
player.name
→ "Alex"

player.health
→ 100
```

## Important Distinction

Inside:

```python
def __init__(self, name):
 self.name = name
```

these two `name` references have related but distinct roles:

```text
name
→ incoming parameter

self.name
→ attribute stored on the object
```

This deserves explicit tracing.

---

# 19.6 Modeling Real-World Systems

## Primary Assessed Skills

- **identifies_entity_attributes** - Determines information an entity needs to store.
- **identifies_entity_methods** - Determines behavior an entity needs.
- **designs_class_from_requirements** - Converts requirements into a class structure.
- **creates_multiple_related_objects** - Uses one class to represent multiple entities.
- **combines_objects_with_collections** - Stores and processes objects in lists when appropriate.
- **selects_class_vs_dictionary** - Chooses between simpler structured data and a class based on problem needs.
- **explains_object_model_choice** - Justifies why a class structure is useful.
- **revises_class_design** - Improves an initial model based on requirements.

## Important Comparison to Unit 09

A dictionary may be enough for:

> named information.

A class becomes especially valuable when an entity has:

```text
STATE
+
BEHAVIOR
```

Example:

```text
dictionary
→ character data

class
→ character data + character actions
```

Neither is automatically better.

The design question is:

> What structure fits the problem?

---

# 19.7 Introduction to Inheritance

## Primary Assessed Skills

- **recognizes_inheritance_relationship** - Recognizes a parent/child class relationship.
- **creates_basic_subclass** - Creates a straightforward subclass.
- **recognizes_inherited_attributes_methods** - Understands that a subclass can use inherited behavior.
- **adds_subclass_specific_behavior** - Adds behavior unique to the child class.
- **distinguishes_parent_and_child_class** - Identifies shared and specialized responsibilities.
- **selects_reasonable_inheritance_relationship** - Recognizes when two entities genuinely have an "is-a" relationship.

## Mental Model

```text
Enemy
├── move()
├── take_damage()
└── health

Boss
inherits Enemy
+
special_attack()
```

A Boss:

> is an Enemy with additional/specialized behavior.

## Important Design Warning

Do not teach inheritance as:

> use this whenever two classes have something in common.

Use:

> Child **is a type of** Parent.

Examples:

```text
Boss is an Enemy
→ reasonable

Sword is a Player
→ not reasonable
```

## Teaching Boundary

This is an introduction.

Do not require:

- multiple inheritance,
- abstract base classes,
- deep polymorphism,
- advanced `super()` patterns,
- complex class hierarchies,
- metaclasses.

---

# Unit 19 Recommended Skill Categories

The major mastery categories are:

1. object/class distinction,
2. creating classes,
3. creating instances,
4. attributes,
5. methods,
6. `self`,
7. `__init__`,
8. object-state tracing,
9. class modeling,
10. introductory inheritance.

---

# Unit 19 Project: Employee Management System

## Project Goal

Students model multiple employees using classes and objects.

Although game examples may dominate instruction, the project deliberately tests whether students can transfer object-oriented thinking to a non-game context.

## Likely Required Skill Areas

Students should:

- define an Employee class,
- initialize employees with useful attributes,
- create multiple employee objects,
- create at least one meaningful method,
- display employee information,
- update employee state through appropriate behavior,
- store multiple employee objects,
- process those objects,
- explain their class design.

## Possible Attributes

```text
name
employee_id
department
role
salary
hours
```

Use only those appropriate to the project scope.

## Possible Methods

```text
display_info()
update_role()
calculate_pay()
give_raise()
```

## Inheritance Requirement

Inheritance can be:

- required at a modest level,
- or included as a strong extension depending on pacing.

Possible relationship:

```text
Employee
↓
Manager
```

A Manager is an Employee with additional responsibilities.

## Project Assessment

Assess:

1. class design,
2. instance creation,
3. attribute use,
4. method use,
5. `__init__`,
6. correct use of `self`,
7. modeling decisions,
8. code readability,
9. ability to explain state and behavior.

## Stretch Opportunities

Students may:

- create subclasses,
- create multiple employee types,
- build a menu interface,
- calculate payroll,
- save employee information using Unit 16 skills,
- add hire dates using Unit 17,
- search/sort employees,
- add tests from Unit 15.

---

# Unit 19 Certification Preparation

## Full-Length Practice Exam

At least one full-length practice exam should occur during this certification-preparation phase if scheduling allows.

After the exam, students should record:

- overall result,
- Domain 1 proficiency,
- Domain 2 proficiency,
- Domain 3 proficiency,
- Domain 4 proficiency,
- Domain 5 proficiency,
- Domain 6 proficiency.

## Diagnostic Analysis

Students should identify:

```text
strongest domain
lowest-proficiency domain
secondary review domain
specific concepts needing review
```

## Targeted Practice

Certification work should then prioritize:

```text
PRIMARY
lowest-proficiency domain

SECONDARY
next-lowest domain

MAINTENANCE
already-strong domains
```

Students may use:

- the certification study guide,
- domain-specific GMetrix practice,
- prior FoxCS lessons,
- targeted Moodle practice,
- prior workbook activities as references,
- focused coding exercises where needed.

The goal is individualized remediation rather than repeating all six domains equally.

---

# UNIT 20: Capstone Project - Skills Review

## Unit Scope

Unit 20 includes:

- 20.1 Project Planning
- 20.2 Feature Scoping
- 20.3 Building V1
- 20.4 Testing and Debugging
- 20.5 Reflection and Revision

Final Project:

- Capstone Project

Unit 20 does not introduce a major new Python syntax topic.

Its purpose is:

> independent synthesis.

Students should demonstrate that they can choose and combine appropriate tools from across the course.

The progression is:

```text
idea
↓
requirements
↓
scope
↓
plan
↓
build
↓
test
↓
revise
↓
explain
```

---

# Unit 20 Parallel Certification Thread

Unit 20 continues two goals in parallel:

```text
CAPSTONE DEVELOPMENT
+
TARGETED CERTIFICATION PREPARATION
```

The capstone should not be replaced by weeks of generic test preparation.

Students continue authentic programming while certification review responds to diagnostic evidence.

Possible certification work during Unit 20 includes:

- additional full-length practice exams,
- study-guide review,
- domain-specific GMetrix practice,
- objective-specific remediation,
- comparison of practice-exam results,
- certification readiness checks,
- final exam preparation.

Students demonstrating strong readiness may spend proportionally more time on capstone development.

Students with significant certification gaps should receive more focused remediation.

---

# Capstone Skill Philosophy

The capstone should not require:

> every Python feature learned during the year.

Instead students should demonstrate:

> deliberate selection of appropriate features for the problem they chose.

A smaller coherent program using six concepts well is preferable to:

> a large program containing twelve features simply because a checklist required them.

There should still be minimum technical requirements, but they should support the project rather than distort it.

---

# 20.1 Project Planning

## Primary Assessed Skills

- **defines_project_problem** - Clearly identifies what the program will do or what experience it will create.
- **identifies_target_user** - Identifies who will use the program.
- **defines_project_goal** - States a concrete desired outcome.
- **identifies_required_inputs** - Determines what information the program needs.
- **identifies_required_outputs** - Determines what the program should produce.
- **identifies_program_state** - Determines information the program must remember.
- **decomposes_project_features** - Breaks the project into smaller components.
- **identifies_prior_course_tools** - Connects planned features to Python concepts learned earlier.
- **creates_initial_project_plan** - Produces an actionable implementation plan.

## Planning Questions

Students should answer:

```text
What am I building?

Who is it for?

What can the user do?

What information must the program remember?

What decisions must the program make?

What repeats?

What data must be organized?

What could go wrong?

How will I know it works?
```

## Computational Thinking Connection

This returns directly to decomposition:

```text
large problem
↓
smaller problems
↓
implementable tasks
```

---

# 20.2 Feature Scoping

## Primary Assessed Skills

- **distinguishes_required_and_optional_features** - Separates necessary functionality from enhancements.
- **defines_minimum_viable_project** - Identifies the smallest complete version of the program.
- **prioritizes_features** - Orders features based on importance.
- **identifies_dependency_between_features** - Recognizes when one feature depends on another.
- **estimates_feature_complexity** - Makes a reasonable judgment about difficulty.
- **removes_out_of_scope_feature** - Recognizes when a feature threatens completion.
- **creates_stretch_feature_list** - Separates optional ideas from core requirements.
- **revises_scope_based_on_constraints** - Adjusts the plan based on time, skill, or technical limitations.

## Core Model

Use:

```text
REQUIRED
→ project does not work without it

IMPORTANT
→ improves the complete experience

STRETCH
→ attempt after the core works
```

## Critical Capstone Principle

Students should not attempt:

```text
all features at once
```

The capstone should reinforce:

> Finish a strong core before expanding.

---

# 20.3 Building V1

## Primary Assessed Skills

- **builds_minimum_viable_version** - Produces a functional first complete version.
- **implements_feature_incrementally** - Builds one understandable feature at a time.
- **tests_feature_after_implementation** - Checks functionality during development.
- **integrates_multiple_course_concepts** - Combines prior Python concepts coherently.
- **maintains_program_state** - Manages changing data appropriately.
- **organizes_program_structure** - Uses functions/classes/files/collections where they improve the design.
- **uses_descriptive_names** - Writes readable identifiers.
- **documents_nonobvious_code** - Uses comments/docstrings appropriately.
- **uses_troubleshooting_routine_independently** - Applies systematic debugging without immediately requesting the solution.
- **saves_working_checkpoint** - Maintains a usable version before large changes.

## Development Pattern

Encourage:

```text
build one feature
↓
run it
↓
verify
↓
save working state
↓
build next feature
```

rather than:

```text
write entire project
↓
run for first time
↓
discover dozens of interacting problems
```

## Potential Course Concepts

A capstone may appropriately use:

- variables,
- input/output,
- strings,
- arithmetic,
- conditionals,
- loops,
- functions,
- lists,
- dictionaries,
- searching/sorting,
- randomness,
- modules,
- exception handling,
- testing,
- files,
- datetime,
- classes.

Not every project needs every item.

---

# 20.4 Testing and Debugging

## Primary Assessed Skills

- **creates_capstone_test_plan** - Defines how major features will be verified.
- **tests_core_feature** - Tests required behavior.
- **tests_integration_between_features** - Checks whether connected components work together.
- **tests_edge_cases_in_project** - Identifies project-specific boundary/unusual situations.
- **records_bug** - Clearly documents a discovered problem.
- **reproduces_bug** - Determines steps that reliably trigger a problem.
- **forms_debugging_hypothesis** - Proposes a likely cause using evidence.
- **tests_debugging_change** - Makes a focused revision.
- **verifies_bug_fix** - Confirms that the original problem is resolved.
- **checks_for_regression** - Confirms that the fix did not break previously working behavior.
- **uses_user_testing_feedback** - Incorporates feedback from another user when appropriate.

## Bug Record Structure

Students can document:

```text
Expected:
...

Actual:
...

Steps to reproduce:
...

Likely cause:
...

Change tested:
...

Result:
...
```

## Integration of Units 13-15

This is where:

```text
DEBUGGING
+
EXCEPTION HANDLING
+
TESTING
```

should become part of normal development rather than isolated units.

---

# 20.5 Reflection and Revision

## Primary Assessed Skills

- **evaluates_project_against_goal** - Determines whether the project accomplishes its intended purpose.
- **evaluates_user_experience** - Considers clarity, feedback, and usability.
- **identifies_project_strength** - Identifies a concrete successful design/technical decision.
- **identifies_project_limitation** - Identifies a meaningful weakness or unfinished area.
- **uses_feedback_to_prioritize_revision** - Chooses revisions based on evidence.
- **implements_meaningful_revision** - Makes a change that improves the project.
- **explains_revision_rationale** - Explains why a change was made.
- **reflects_on_skill_growth** - Identifies programming/design growth across the course.
- **identifies_next_learning_goal** - Identifies a reasonable next technical or design skill to develop.

## Revision Principle

Revision should not mean:

> change colors or rename variables because the assignment requires a revision.

A meaningful revision should improve:

- functionality,
- reliability,
- usability,
- organization,
- clarity,
- performance at the course-appropriate level.

---

# Capstone Technical Requirements

The final project should demonstrate a meaningful subset of the course.

A reasonable baseline might require evidence of:

## Program State

Use variables and/or object attributes to track meaningful information.

## User Interaction or Program Input

The program receives information through an appropriate mechanism.

## Decision-Making

Use conditional logic for meaningful program behavior.

## Repetition

Use a loop where repetition is genuinely needed.

## Organization

Use functions and/or classes to organize nontrivial behavior.

## Structured Data

Use at least one meaningful collection such as:

- list,
- tuple where appropriate,
- dictionary,
- list of objects.

## Error Awareness

Demonstrate either:

- input validation,
- exception handling,
- defensive programming,
- another appropriate failure-handling mechanism.

## Testing

Provide evidence that core features were deliberately tested.

## Documentation

Use:

- meaningful names,
- appropriate comments,
- docstrings where useful.

---

# Optional Advanced Capstone Features

Depending on the project, students may additionally use:

- file persistence,
- datetime,
- randomness,
- searching,
- sorting,
- classes,
- inheritance,
- command-line arguments,
- automated unit tests.

These should not be included merely to increase feature count.

---

# Capstone Project Types

Students should have meaningful choice.

Possible formats include:

## Game / Game-System Project

Examples:

- text adventure,
- combat simulator,
- character system,
- probability game,
- inventory simulator,
- turn-based game,
- game-stat tracker.

## Utility / Application

Examples:

- planner,
- study tool,
- calculator,
- tracker,
- organizer,
- journal,
- file utility.

## Data-Oriented Project

Examples:

- statistics explorer,
- score tracker,
- recommendation tool,
- searchable collection,
- simulation.

## Student-Proposed Project

Allowed when the project:

- fits available Python skills,
- has a clear user/purpose,
- has an achievable scope,
- demonstrates sufficient programming complexity.

---

# Capstone Project Assessment Categories

A final rubric should likely evaluate:

## 1. Functional Completion

Does the core program work?

## 2. Computational Thinking

Did the student break the problem into manageable systems?

## 3. Programming Skill

Are Python concepts applied correctly?

## 4. Program Structure

Is code organized in a way the student can explain?

## 5. Testing and Reliability

Did the student intentionally verify behavior?

## 6. Debugging and Revision

Is there evidence of diagnosis and improvement?

## 7. User Experience / Game Design

Does the program communicate clearly and support its intended experience?

## 8. Explanation and Ownership

Can the student explain:

- what the code does,
- why they made major decisions,
- what they changed,
- what they learned?

This final category is especially important for establishing genuine mastery.

---

# Unit 20 Certification Readiness Cycle

Certification preparation should continue alongside the capstone.

Use a repeated cycle:

```text
1. FULL-LENGTH PRACTICE EXAM

2. ANALYZE RESULTS
 - overall score
 - domain scores
 - missed concepts

3. SELECT PRIORITY DOMAIN

4. STUDY
 - certification study guide
 - prior FoxCS lessons
 - prior reference materials

5. PRACTICE
 - domain-specific questions
 - GMetrix domain practice
 - targeted coding where appropriate

6. CHECK UNDERSTANDING

7. TAKE ANOTHER FULL-LENGTH PRACTICE EXAM

8. COMPARE RESULTS
```

Students should be able to answer:

```text
What is my weakest domain?

What specific concepts inside that domain are weak?

What am I doing to improve them?

Did my next practice result show improvement?
```

---

# Practice Exam Data as Adaptive Evidence

Practice-exam performance should become another source of adaptive evidence.

Example:

```text
Student A

Domain 1: 90%
Domain 2: 88%
Domain 3: 84%
Domain 4: 91%
Domain 5: 72%
Domain 6: 61%
```

The student should not receive equal review across all domains.

Instead:

```text
PRIMARY REVIEW
Domain 6

SECONDARY REVIEW
Domain 5

MAINTENANCE
Domains 1-4
```

This matches the broader FoxCS adaptive philosophy:

> Practice should respond to evidence of what the learner actually needs.

---

# Certification Readiness Reflection

Students should periodically record:

```text
Current strongest domain:
...

Current lowest-proficiency domain:
...

Specific concept I need to review:
...

Study-guide section I used:
...

Practice I completed:
...

Evidence that I improved:
...
```

This makes certification preparation a metacognitive process rather than simply repeated test-taking.

---

# Certification Boundary

Unit 20 does not introduce new LearnKey workbook or video content.

By this point:

- all LearnKey videos should already have been completed,
- all mapped workbook pages should already have been completed,
- all LearnKey Coding Exercises should already have been completed,
- all certification reviews should already have been completed.

Units 19-20 therefore focus on:

```text
FULL-LENGTH PRACTICE
+
DIAGNOSTIC ANALYSIS
+
TARGETED DOMAIN PRACTICE
+
STUDY-GUIDE USE
+
CERTIFICATION READINESS
```

while students continue authentic Python development.

---

# Unit 20 Recommended Skill Categories

The major mastery categories are:

1. project planning,
2. decomposition,
3. scope management,
4. feature prioritization,
5. incremental development,
6. integration of prior Python concepts,
7. independent troubleshooting,
8. testing,
9. debugging,
10. revision,
11. usability/design reasoning,
12. technical explanation,
13. reflection.

---

# Unit 20 Final Project: Capstone Project

## Core Expectations

Students should:

- propose an achievable project,
- define its user/purpose,
- define required features,
- separate core and stretch scope,
- build a functional V1,
- integrate multiple Python concepts,
- test intentionally,
- document discovered problems,
- revise based on evidence,
- produce a final functioning version,
- explain major technical decisions,
- reflect on their growth.

## Strong Final Evidence

The most valuable evidence is not simply:

```text
finished program
```

It is:

```text
plan
+
working code
+
testing evidence
+
revision evidence
+
student explanation
```

Together these provide much stronger evidence of actual programming mastery.

---

# Units 16-20 Conceptual Progression

## Unit 16: File Input & Output

Students learn:

> How can my program remember information after it closes?

```text
temporary state
↓
persistent data
```

---

## Unit 17: Dates, Times, and Calendars

Students learn:

> How can a program reason about when something happens and how much time passes?

```text
time
↓
duration
↓
calculation
↓
human-readable output
```

---

## Unit 18: Working with the Computer

Students learn:

> How can my Python program interact with the environment it runs inside?

```text
program
↓
file system
↓
paths
↓
operating system
↓
command line
```

Unit 18 also marks:

```text
CERTIFICATION COURSEWARE
→ complete
```

---

## Unit 19: Classes and Objects

Students learn:

> How can I model larger systems by combining related state and behavior?

```text
data
+
behavior
↓
objects
↓
systems
```

At the same time:

```text
full-length certification practice
+
targeted remediation
```

begins or continues.

---

## Unit 20: Capstone

Students learn:

> How do I independently decide which programming tools to combine to solve a larger problem?

```text
problem
↓
plan
↓
scope
↓
build
↓
test
↓
revise
↓
explain
```

Certification preparation continues in parallel:

```text
practice exam
↓
diagnose
↓
study
↓
target practice
↓
reassess
↓
certification
```

---

# Final Course Conceptual Progression

Across the full Python sequence:

```text
instructions
↓
state
↓
input
↓
calculation
↓
decision
↓
repetition
↓
reusable behavior
↓
ordered collections
↓
structured data
↓
data organization and search
↓
randomness
↓
standard-library tools
↓
understanding failure
↓
handling failure
↓
testing
↓
persistence
↓
time
↓
computer environment
↓
objects and systems
↓
independent synthesis
```

The final shift is from:

```text
"What Python feature should I use?"
```

toward:

```text
"What does this problem require, and which tools I know fit that need?"
```

At the same time, certification preparation shifts from:

```text
"Have I completed the certification content?"
```

toward:

```text
"What evidence shows I am ready for the exam, and what do I still need to strengthen?"
```

That combination of independent programming and evidence-based certification preparation is the final transfer goal of the course.

