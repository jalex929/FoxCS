# FoxCS Python — LearnKey / GMetrix Workbook Mapping

*Canonical certification-content mapping for FoxCS Python.*

This document maps the LearnKey **Python v2** certification-preparation course and workbook to FoxCS Python Units 02–20.

It is intentionally separate from the FoxCS skills/course map.

The skills/course map answers:

> What are students learning?

This document answers:

> Where is every LearnKey video, workbook activity, coding exercise, and certification review completed?

---

# Purpose

By the time students complete the Python course and prepare for the **IT Specialist – Python** certification exam, they should have completed the full LearnKey Python v2 certification-preparation sequence that has been assigned to FoxCS.

This includes:

- all required LearnKey video topics and subtopics,
- all workbook instructional pages,
- all Fill-in-the-Blanks activities,
- all code-reading activities,
- all Coding Exercises,
- all certification review activities,
- all workbook-listed starter-file activities,
- all six certification domains.

The goal is complete coverage without duplication.

Each workbook activity and video subtopic should have **one canonical FoxCS home**.

---

# Important Mapping Rule: Assign Once

A workbook page should appear in only one FoxCS unit.

A LearnKey video subtopic should also have one primary assignment point.

Some LearnKey **Review** pages list both:

- the immediately preceding subtopic, and
- the review subtopic.

For example:

```text
Loops with Compound Conditions; Review 2.2
```

does **not** mean students should watch the Loops with Compound Conditions video twice.

Instead:

```text
First assignment
→ watch Loops with Compound Conditions

Review assignment
→ watch only the new Review 2.2 segment
```

Use this same rule throughout the course.

---

# Workbook Page Numbers

This document uses the **printed workbook page number** as the primary reference.

Example:

```text
Workbook p. 47
```

When useful for authoring, the PDF page is also listed.

The PDF page is normally six pages later than the printed workbook page because the PDF includes front matter.

Example:

```text
Workbook p. 47
PDF p. 53
```

Student-facing materials should normally refer only to the printed workbook page number.

---

# Site Activity Types

When recreating LearnKey workbook content inside FoxCS/Moodle, classify it using the following activity types.

## Workbook Page

Use for activities primarily involving:

- code reading,
- prediction,
- matching,
- conceptual questions,
- short answer,
- True/False,
- analysis that does not require students to edit/run a Python file.

---

## Fill-in-the-Blanks

Use when the workbook asks students to supply specific missing:

- vocabulary,
- syntax,
- operators,
- definitions,
- results.

Fill-in-the-Blanks may appear:

- as a standalone activity, or
- embedded directly into instructional content.

If the original workbook page combines Fill-in-the-Blanks with a coding task, separate them in FoxCS.

---

## Coding Exercise

Use when students must:

- open a `.py` file,
- create a `.py` file,
- edit Python code,
- run Python code,
- execute code from the command line,
- perform an applied programming task.

Coding Exercises may provide:

- a starter file,
- downloadable code,
- or a blank file and requirements.

---

## Certification Review

Use for cumulative LearnKey review activities.

A Certification Review may also be a Coding Exercise.

Example:

```text
Certification Review / Coding Exercise
```

---

# Source Fidelity

FoxCS may recreate the **learning experience** of a workbook page inside Moodle, but the source mapping should remain visible internally.

Each recreated activity should preserve metadata such as:

- original workbook title,
- workbook page,
- LearnKey Domain,
- LearnKey Lesson,
- Topic,
- Subtopic,
- objective,
- starter file when applicable,
- FoxCS unit assignment.

The LearnKey/GMetrix material is licensed reference content.

Recreate the instructional experience rather than copying the commercial workbook wholesale.

---

# Course-Wide Domain Ownership

| LearnKey Domain | Certification Focus | FoxCS Unit Ownership |
|---|---|---|
| Domain 1 | Data Types and Operators | Units 02, 04, 05, 08, 09, 10 |
| Domain 2 | Decisions and Loops | Units 05–06 |
| Domain 3 | Input and Output | Units 03, 16, 18 |
| Domain 4 | Documentation and Functions | Unit 07 |
| Domain 5 | Errors, Exceptions, Testing | Units 13–15 |
| Domain 6 | Modules and Tools | Units 11, 12, 17, 18 |

FoxCS-original units without dedicated workbook exercises:

- Unit 19 — Classes and Objects
- Unit 20 — Capstone Project

Unit 09 primarily uses one Domain 1 vocabulary/data-structures workbook page rather than dedicated tuple/dictionary practice.

---

# UNIT 02: Variables & Data

## Certification Focus

Domain 1:

- Identify Data Types
- Data Type Conversion
- Assignment Order
- Using Assignment Operators

---

## LearnKey Video Ownership

### Domain 1 Lesson 2 — Identify Data Types Part 2

Assign these video subtopics during Unit 02:

- `str`
- `int`
- `float`
- `bool`
- Review on 1.1

### Domain 1 Lesson 3 — Analyze Data Types and Operators Part 1

Assign:

- Data Type Conversion

Do **not** assign Indexing here.

Indexing belongs to Unit 08.

### Domain 1 Lesson 6 — Sequence of Execution Part 1

Assign:

- Assignment Order

### Domain 1 Lesson 8 — Select Operators Part 1

Assign:

- Assignment

Comparison and Logical are reserved for Unit 05.

---

# Unit 02 Workbook Mapping

## Workbook p. 10 — Strings and Integers

- **PDF page:** 16
- **Domain:** 1
- **LearnKey Lesson:** 2
- **Topic:** Identify Data Types
- **Subtopics:** `str`; `int`
- **Objectives:** 1.1.1; 1.1.2
- **Files:** `111-str.py`, `112-numbers.py`
- **FoxCS placement:** 02.1–02.4
- **Site implementation:** Split activity

### Coding Exercise: Strings and Integers

Use the original coding tasks involving:

- strings,
- variables,
- printing names,
- identifying integer data types.

### Workbook Questions / Fill-in-the-Blanks

Separate conceptual questions from the executable coding task.

---

## Workbook p. 11 — Floats and Bools

- **PDF page:** 17
- **Domain:** 1
- **LearnKey Lesson:** 2
- **Topic:** Identify Data Types
- **Subtopics:** `float`; `bool`
- **Objectives:** 1.1.3; 1.1.4
- **Files:** `113-numbers.py`, `114-boolean.py`
- **FoxCS placement:** 02.3–02.5
- **Site implementation:** Split activity

### Coding Exercise: Floats and Bools

Students work with:

- float values,
- mixed numeric calculations,
- Boolean values.

### Fill-in-the-Blanks / Workbook Questions

Separate questions involving:

- appropriate number types,
- Boolean casing,
- returned calculation types.

---

## Workbook p. 12 — Review 1.1

- **PDF page:** 18
- **Domain:** 1
- **LearnKey Lesson:** 2
- **Topic:** Identify Data Types
- **New video subtopic:** Review on 1.1
- **File:** `114-analyze.py`
- **FoxCS placement:** Unit 02 mixed data-type review
- **Site activity:** Certification Review / Coding Exercise

Students analyze several expressions and identify their data types.

Do not reassign the `bool` video just because the review page also references it.

---

## Workbook p. 14 — Data Type Conversion

- **PDF page:** 20
- **Domain:** 1
- **LearnKey Lesson:** 3
- **Topic:** Analyze Data Types and Operators Part 1
- **Subtopic:** Data Type Conversion
- **Objective:** 1.2.1
- **File:** `121-conversion.py`
- **FoxCS placement:** 02.6
- **Site activity:** Coding Exercise

---

## Workbook p. 23 — Assignment Operators

- **PDF page:** 29
- **Domain:** 1
- **LearnKey Lesson:** 6
- **Topic:** Sequence of Execution Part 1
- **Subtopic:** Assignment Order
- **Objective:** 1.3.1
- **File:** None
- **FoxCS placement:** 02.7
- **Site activity:** Fill-in-the-Blanks / Workbook Page

Focus:

- assignment precedence,
- reassignment,
- left-side/right-side reasoning.

---

## Workbook p. 32 — Using Assignment Operators

- **PDF page:** 38
- **Domain:** 1
- **LearnKey Lesson:** 8
- **Topic:** Select Operators Part 1
- **Subtopic:** Assignment
- **Objective:** 1.4.1
- **File:** None
- **FoxCS placement:** Unit 02 certification extension/review
- **Site activity:** Workbook Page / Fill-in-the-Blanks

This remains in Unit 02 because the course plan places **both assignment-operator objectives** with variables and assignment.

The page also references arithmetic forms such as:

- modulus,
- floor division,
- exponentiation.

Students may encounter those expressions here as certification exposure, but their deeper conceptual instruction occurs in Unit 04.

Do not assign this page again in Unit 04.

---

# UNIT 03: User Input & Strings

## Certification Focus

Domain 3:

- Read Input from Console
- Print Formatted Text

---

## LearnKey Video Ownership

### Domain 3 Lesson 3 — Console Input and Output

Assign:

- Read Input from Console
- Print Formatted Text

Do **not** yet assign:

- Use Command-Line Arguments
- First Half Review

Those are moved to Unit 18 so that all workbook content is eventually completed after students have learned command-line execution.

---

# Unit 03 Workbook Mapping

## Workbook p. 66 — Read Input from Console

- **PDF page:** 72
- **Domain:** 3
- **LearnKey Lesson:** 3
- **Topic:** Console Input and Output
- **Subtopic:** Read Input from Console
- **Objective:** 3.2.1
- **File:** `321-input.py`
- **FoxCS placement:** 03.1
- **Site activity:** Coding Exercise

---

## Workbook p. 67 — Print Formatted Text

- **PDF page:** 73
- **Domain:** 3
- **LearnKey Lesson:** 3
- **Topic:** Console Input and Output
- **Subtopic:** Print Formatted Text
- **Objective:** 3.2.2
- **File:** None
- **FoxCS placement:** 03.4–03.5
- **Site activity:** Workbook Page / Code Reading

Covers:

- `string.format()`
- f-strings
- formatted output.

---

# UNIT 04: Math for Programmers

## Certification Focus

Domain 1:

- Arithmetic Order
- Using Arithmetic Operators

---

## LearnKey Video Ownership

### Domain 1 Lesson 7 — Sequence of Execution Part 2

Assign:

- Arithmetic Order

Do not assign:

- Identity Order → Unit 05
- Containment Order → Unit 10
- Review 1.3 → Unit 10

### Domain 1 Lesson 9 — Select Operators Part 2

Assign:

- Arithmetic

Do not assign:

- Identity → Unit 05
- Containment → Unit 10
- Review 1.4 → Unit 10

---

# Unit 04 Workbook Mapping

## Workbook p. 27 — Arithmetic

- **PDF page:** 33
- **Domain:** 1
- **LearnKey Lesson:** 7
- **Topic:** Sequence of Execution Part 2
- **Subtopic:** Arithmetic Order
- **Objective:** 1.3.4
- **File:** `134-arithmetic.py`
- **FoxCS placement:** 04.2–04.3
- **Site implementation:** Split activity

### Fill-in-the-Blanks / Workbook Questions

Covers arithmetic precedence.

### Coding Exercise: Arithmetic Order

Use `134-arithmetic.py`.

Students alter parentheses to change calculation order.

---

## Workbook p. 36 — Using Arithmetic Operators

- **PDF page:** 42
- **Domain:** 1
- **LearnKey Lesson:** 9
- **Topic:** Select Operators Part 2
- **Subtopic:** Arithmetic
- **Objective:** 1.4.4
- **File:** None
- **FoxCS placement:** 04.2–04.5
- **Site activity:** Workbook Page / Fill-in-the-Blanks / Code Reading

Covers:

- quotient behavior,
- arithmetic operators,
- expression results.

---

# UNIT 05: Making Decisions

## Certification Focus

Domain 1:

- Comparison Order
- Logical Order
- Identity Order
- Comparison
- Logical
- Identity

Domain 2:

- `if`
- `elif`
- `else`
- Nested and Compound Conditions
- Review 2.1

Keep Domain 1 and Domain 2 work as separate certification activities.

---

# Unit 05 Domain 1 Video Ownership

## Domain 1 Lesson 6

Assign:

- Comparison Order
- Logical Order

## Domain 1 Lesson 7

Assign:

- Identity Order

## Domain 1 Lesson 8

Assign:

- Comparison
- Logical

## Domain 1 Lesson 9

Assign:

- Identity

Containment remains Unit 10.

---

# Unit 05 Domain 1 Workbook Mapping

## Workbook p. 24 — Comparison Operators

- **PDF page:** 30
- **Lesson:** Domain 1 Lesson 6
- **Subtopic:** Comparison Order
- **Objective:** 1.3.2
- **Site activity:** Fill-in-the-Blanks / Workbook Page
- **FoxCS placement:** 05.1

---

## Workbook p. 25 — Logical Operators

- **PDF page:** 31
- **Lesson:** Domain 1 Lesson 6
- **Subtopic:** Logical Order
- **Objective:** 1.3.3
- **Site activity:** Fill-in-the-Blanks / Code Reading
- **FoxCS placement:** 05.2

---

## Workbook p. 28 — Identity Operator

- **PDF page:** 34
- **Lesson:** Domain 1 Lesson 7
- **Subtopic:** Identity Order
- **Objective:** 1.3.5
- **Site activity:** Fill-in-the-Blanks
- **FoxCS placement:** 05.2

---

## Workbook p. 33 — Using Comparison Operators

- **PDF page:** 39
- **Lesson:** Domain 1 Lesson 8
- **Subtopic:** Comparison
- **Objective:** 1.4.2
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.1

---

## Workbook p. 34 — Using Logical Operators

- **PDF page:** 40
- **Lesson:** Domain 1 Lesson 8
- **Subtopic:** Logical
- **Objective:** 1.4.3
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.2

---

## Workbook p. 37 — Using the Identity Operator

- **PDF page:** 43
- **Lesson:** Domain 1 Lesson 9
- **Subtopic:** Identity
- **Objective:** 1.4.5
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.2

---

# Unit 05 Domain 2 Video Ownership

### Domain 2 Lesson 1 — Branching Statements

Assign:

- `if`
- `elif`
- `else`
- Nested and Compound Conditions
- Review 2.1

---

# Unit 05 Domain 2 Workbook Mapping

## Workbook p. 41 — Branching Statements: if

- **PDF page:** 47
- **Objective:** 2.1.1
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.3

---

## Workbook p. 42 — Branching Statements: elif

- **PDF page:** 48
- **Objective:** 2.1.2
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.5

---

## Workbook p. 43 — Branching Statements: else

- **PDF page:** 49
- **Objective:** 2.1.3
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 05.4

---

## Workbook p. 44 — Nested/Compound Conditions

- **PDF page:** 50
- **Objective:** 2.1.4
- **File:** `214-nested.py`
- **Site activity:** Coding Exercise + Workbook Questions
- **FoxCS placement:** 05.6

---

## Workbook p. 45 — Review 2.1

- **PDF page:** 51
- **New video subtopic:** Review 2.1
- **File:** `214-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** 05.7

Do not reassign the Nested and Compound Conditions video.

---

# UNIT 06: Loops & Repetition

## Certification Focus

Domain 2 Objective 2.2:

- `while`
- `for`
- `break`
- `continue`
- `pass`
- Nested Loops
- Loops with Compound Conditions
- Review 2.2

---

# Unit 06 Video Ownership

## Domain 2 Lesson 2 — Iteration Part 1

Assign:

- `while`
- `for`
- `break`
- `continue`

## Domain 2 Lesson 3 — Iteration Part 2

Assign:

- `pass`
- Nested Loops
- Loops with Compound Conditions
- Review 2.2

---

# Unit 06 Workbook Mapping

## Workbook p. 47 — Iteration: while

- **PDF page:** 53
- **Objective:** 2.2.1
- **File:** `221-while.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 06.2

---

## Workbook p. 48 — Iteration: for

- **PDF page:** 54
- **Objective:** 2.2.2
- **File:** `222-for.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** after 06.4 Range

The workbook activity uses `range()` including step behavior.

---

## Workbook p. 49 — Iteration: break and continue

- **PDF page:** 55
- **Objectives:** 2.2.3; 2.2.4
- **File:** `224-continue.py`
- **FoxCS placement:** after 06.7
- **Site implementation:** Split

### Workbook Page: `break`

Recreate the initial break-analysis question separately.

### Coding Exercise: `continue`

Use the `224-continue.py` task.

---

## Workbook p. 51 — Iteration: pass

- **PDF page:** 57
- **Objective:** 2.2.5
- **File:** `225-pass.py`
- **FoxCS placement:** 06.8
- **Site implementation:** Split

### Fill-in-the-Blanks: `pass`

Complete the conceptual placeholder question first.

### Coding Exercise: `pass`

Then use `225-pass.py`.

---

## Workbook p. 52 — Nested Loops

- **PDF page:** 58
- **Objective:** 2.2.6
- **File:** `226-nested.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 06.9

---

## Workbook p. 53 — Loops with Compound Conditions

- **PDF page:** 59
- **Objective:** 2.2.7
- **File:** `227-compound.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 06.10

---

## Workbook p. 54 — Review 2.2

- **PDF page:** 60
- **New video subtopic:** Review 2.2
- **File:** `227-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 06 review

Do not re-watch Loops with Compound Conditions.

---

# UNIT 07: Functions

## Certification Focus

Domain 4:

- code documentation and structure,
- function definitions.

Because all Domain 4 certification content must be completed, this unit owns **both Domain 4 lessons**, including documentation concepts students may have encountered earlier.

Some content is reinforcement rather than first instruction.

---

# Unit 07 Video Ownership

## Domain 4 Lesson 1 — Document Code Segments

Assign once:

- Use Indentation
- Whitespace
- Comments
- Documentation Strings
- Use Pydoc for Documentation
- Review 4.1

## Domain 4 Lesson 2 — Function Definitions

Assign:

- Call Signatures
- Default Values
- `return`
- `def`
- Use `pass` in Functions
- Review 4.2

---

# Unit 07 Workbook Mapping

## Workbook p. 71 — Use Indentation

- **PDF page:** 77
- **Objective:** 4.1.1
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** early Unit 07 certification review

This is reinforcement of indentation knowledge students have already used in Units 05–06.

---

## Workbook p. 72 — Whitespace

- **PDF page:** 78
- **Objective:** 4.1.2
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** early Unit 07

---

## Workbook p. 73 — Comments

- **PDF page:** 79
- **Objective:** 4.1.3
- **File:** `413-comments.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** Unit 07 documentation sequence

This reinforces comments first introduced earlier in FoxCS.

---

## Workbook p. 74 — Documentation Strings

- **PDF page:** 80
- **Objective:** 4.1.4
- **File:** `414-docstrings.py`
- **Site activity:** Coding Exercise + Workbook Questions
- **FoxCS placement:** 07.9

---

## Workbook p. 75 — Use Pydoc for Documentation

- **PDF page:** 81
- **Objective:** 4.1.5
- **Workbook-listed project file:** `Datetime.txt`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 07.9 certification extension

Students use the command line to:

- inspect documentation,
- generate documentation,
- save output.

This page is completed here even though more general command-line instruction occurs later.

Treat the commands as guided certification procedures rather than full command-line mastery.

---

## Workbook p. 76 — Review 4.1

- **PDF page:** 82
- **New video subtopic:** Review 4.1
- **File:** `415-review.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** after Domain 4 documentation work

Do not re-watch Pydoc.

---

## Workbook p. 78 — Call Signatures

- **PDF page:** 84
- **Objective:** 4.2.1
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 07.8

---

## Workbook p. 79 — Default Values

- **PDF page:** 85
- **Objective:** 4.2.2
- **File:** `422-default.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 07.7

---

## Workbook p. 80 — Use return

- **PDF page:** 86
- **Objective:** 4.2.3
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 07.5

---

## Workbook p. 81 — Use def

- **PDF page:** 87
- **Objective:** 4.2.4
- **File:** `424-def.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** after 07.4

The exercise integrates:

- function definition,
- parameters,
- return values,
- function calls.

---

## Workbook p. 82 — Use pass in Functions

- **PDF page:** 88
- **Objective:** 4.2.5
- **File:** `425-pass.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** Unit 07 function-definition sequence

---

## Workbook p. 83 — Review 4.2

- **PDF page:** 89
- **New video subtopic:** Review 4.2
- **File:** `425-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 07 review

Do not re-watch Use pass in Functions.

---

# UNIT 08: Lists

## Certification Focus

Domain 1 Objective 1.2:

- Indexing
- Slicing
- Lists
- List Operations
- Review 1.2

---

# Unit 08 Video Ownership

Assign:

### Domain 1 Lesson 3

- Indexing

### Domain 1 Lesson 4

- Slicing

Do not assign Construct Data Structures here.

That belongs to Unit 09.

### Domain 1 Lesson 5

- Lists
- List Operations
- Review on 1.2 Part 1
- Review on 1.2 Part 2

---

# Unit 08 Workbook Mapping

## Workbook p. 15 — Indexing

- **PDF page:** 21
- **Objective:** 1.2.2
- **File:** `122-indexing.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 08.3

---

## Workbook p. 17 — Slicing

- **PDF page:** 23
- **Objective:** 1.2.3
- **File:** `123-slicing.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 08.10

Students may have encountered string slicing earlier, but this is the **single official LearnKey Slicing assignment**.

---

## Workbook p. 20 — Lists and Their Operations

- **PDF page:** 26
- **Objectives:** 1.2.5; 1.2.6
- **File:** `126-list_operations.py`
- **FoxCS placement:** 08.2–08.6
- **Site implementation:** Split

### Workbook Questions / Fill-in-the-Blanks

Cover:

- list purpose,
- methods,
- objects/method terminology.

### Coding Exercise: List Operations

Use:

```text
126-list_operations.py
```

for:

- `append()`,
- `insert()`.

---

## Workbook p. 21 — Review 1.2

- **PDF page:** 27
- **New video subtopics:** Review on 1.2 Part 1; Review on 1.2 Part 2
- **Files:** `126-list_operations.py`, `126-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 08 review

Do not re-watch List Operations.

---

# UNIT 09: Working with Data Collections

## Certification Focus

Limited Domain 1 data-structure vocabulary coverage.

There is no dedicated LearnKey tuple/dictionary practice sequence, but one workbook page covers:

- dictionaries,
- sets,
- tuples.

---

# Unit 09 Video Ownership

### Domain 1 Lesson 4

Assign:

- Construct Data Structures

This video subtopic is assigned here rather than Unit 08.

---

# Unit 09 Workbook Mapping

## Workbook p. 18 — Data Structures

- **PDF page:** 24
- **Domain:** 1
- **LearnKey Lesson:** 4
- **Topic:** Analyze Data Types and Operators Part 2
- **Subtopic:** Construct Data Structures
- **Objective:** 1.2.4
- **Workbook-listed file:** None
- **Site activity:** Fill-in-the-Blanks / Matching / Workbook Page
- **FoxCS placement:** early Unit 09

Covers certification vocabulary for:

- Dictionary
- Set
- Tuple

FoxCS then provides the deeper original instruction for:

- tuples,
- dictionaries,
- nested data.

Sets do not require a full FoxCS unit merely because they appear on this workbook page.

---

# UNIT 10: Sorting, Searching, and Patterns

## Certification Focus

Final Domain 1 operator content:

- Containment Order
- Containment
- Review 1.3
- Review 1.4

This unit closes the split Domain 1 operator sequence after assignment, arithmetic, comparison, logical, and identity have already been completed.

---

# Unit 10 Video Ownership

### Domain 1 Lesson 7

Assign:

- Containment Order
- Review on 1.3

### Domain 1 Lesson 9

Assign:

- Containment
- Review on 1.4

---

# Unit 10 Workbook Mapping

## Workbook p. 29 — Containment Operator

- **PDF page:** 35
- **Objective:** 1.3.6
- **File:** None
- **Site activity:** Fill-in-the-Blanks / Code Reading
- **FoxCS placement:** 10.5 Membership Testing

---

## Workbook p. 30 — Review 1.3

- **PDF page:** 36
- **New video subtopic:** Review on 1.3
- **File:** None
- **Site activity:** Certification Review / Fill-in-the-Blanks
- **FoxCS placement:** Unit 10 certification review

This review deliberately revisits:

- assignment order,
- comparison order,
- logical order,
- arithmetic order,
- identity order,
- containment order.

Do not reassign earlier workbook pages or videos.

---

## Workbook p. 38 — Using the Containment Operator

- **PDF page:** 44
- **Objective:** 1.4.6
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 10.5

---

## Workbook p. 39 — Review 1.4

- **PDF page:** 45
- **New video subtopic:** Review on 1.4
- **File:** `146-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 10 review

This is the final Domain 1 operator review.

---

# UNIT 11: Randomness and Simulation

## Certification Focus

Domain 6 Objective 6.2.3:

- `randrange`
- `randint`
- `random`
- `shuffle`
- `choice`
- `sample`

---

# Unit 11 Video Ownership

### Domain 6 Lesson 3 — Solve Complex Problems Part 2

Assign:

- Random with Numbers
- Random with Lists
- Final Review

---

# Unit 11 Workbook Mapping

## Workbook p. 108 — Random with Numbers

- **PDF page:** 114
- **Objective:** 6.2.3
- **Workbook-listed file:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 11.2–11.3

Certification coverage includes:

- `randrange()`,
- `randint()`,
- `random()`.

FoxCS should explicitly include `randrange()` even if it does not receive its own full lesson.

---

## Workbook p. 109 — Random with Lists

- **PDF page:** 115
- **Objective:** 6.2.3
- **Workbook-listed file:** None
- **Site activity:** Matching / Workbook Page
- **FoxCS placement:** 11.4–11.5

Covers:

- `shuffle()`,
- `choice()`,
- `sample()`.

`sample()` must be covered even if it is incorporated into an existing lesson rather than receiving a standalone lesson.

---

## Workbook p. 110 — Review 6.2

- **PDF page:** 116
- **New video subtopic:** Final Review
- **Workbook-listed starter:** None
- **Required output file:** student creates `623-final`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 11 review

Students build a small random-calculation application.

Do not re-watch Random with Lists.

---

# UNIT 12: Useful Python Tools

## Certification Focus

Domain 6 Objective 6.2.1 — Math:

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

---

# Unit 12 Video Ownership

### Domain 6 Lesson 2 — Solve Complex Problems Part 1

Assign:

- Math
- isnan, sqrt, isqrt, and pi

Datetime is reserved for Unit 17.

---

# Unit 12 Workbook Mapping

## Workbook p. 104 — Math

- **PDF page:** 110
- **Objective:** 6.2.1
- **Workbook-listed file:** None
- **Site activity:** Matching / Workbook Page
- **FoxCS placement:** 12.1–12.4

Covers:

- `fabs`
- `ceil`
- `floor`
- `trunc`
- `fmod`
- `frexp`

Although FoxCS may emphasize the most broadly useful tools, every listed certification function should still receive explicit exposure.

---

## Workbook p. 105 — isnan, sqrt, isqrt, and pi

- **PDF page:** 111
- **Objective:** 6.2.1
- **Workbook-listed file:** None
- **Site activity:** Workbook Page / Code Prediction
- **FoxCS placement:** 12.5–12.6

Covers:

- `nan`
- `isnan`
- `sqrt`
- `isqrt`
- `pow`
- `pi`

---

# UNIT 13: Debugging and Errors

## Certification Focus

Domain 5 Objective 5.1:

- Syntax Errors
- Logic Errors
- Runtime Errors
- Review 5.1

---

# Unit 13 Video Ownership

### Domain 5 Lesson 1 — Analyze, Detect, and Fix Errors

Assign:

- Syntax Errors
- Logic Errors
- Runtime Errors
- Review 5.1

---

# Unit 13 Workbook Mapping

## Workbook p. 85 — Syntax Errors

- **PDF page:** 91
- **Objective:** 5.1.1
- **File:** `511-syntax.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 13.1–13.2

---

## Workbook p. 86 — Logic Errors

- **PDF page:** 92
- **Objective:** 5.1.2
- **File:** `512-logic.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** Unit 13 logic-error instruction

---

## Workbook p. 87 — Runtime Errors

- **PDF page:** 93
- **Objective:** 5.1.3
- **File:** `513-runtime.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 13.3–13.7 as appropriate

LearnKey treats runtime errors as one category while FoxCS breaks specific exceptions into greater detail.

---

## Workbook p. 88 — Review 5.1

- **PDF page:** 94
- **New video subtopic:** Review 5.1
- **File:** `513-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** 13.8 / unit review

Do not re-watch Runtime Errors.

---

# UNIT 14: Exception Handling

## Certification Focus

Domain 5 Objective 5.2:

- `try`
- `except`
- `else`
- `finally`
- `raise`
- Review 5.2

---

# Unit 14 Video Ownership

### Domain 5 Lesson 2 — Exception Handling

Assign:

- `try`
- `except`
- else in Exception Handling
- `finally`
- `raise`
- Review 5.2

---

# Unit 14 Workbook Mapping

## Workbook p. 90 — Exception Handling: try, except, else, and finally

- **PDF page:** 96
- **Objectives:** 5.2.1–5.2.4
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 14.1–14.4

---

## Workbook p. 91 — Exception Handling: raise

- **PDF page:** 97
- **Objective:** 5.2.5
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** Unit 14 exception-handling extension

`raise` should receive certification coverage even if it does not become a standalone FoxCS lesson.

---

## Workbook p. 92 — Review 5.2

- **PDF page:** 98
- **New video subtopic:** Review 5.2
- **File:** `525-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 14 review

Do not re-watch `raise`.

---

# UNIT 15: Testing Your Code

## Certification Focus

Domain 5 Objective 5.3:

- Unittest
- Functions
- Methods
- Assert Methods
- Review 5.3

---

# Unit 15 Video Ownership

### Domain 5 Lesson 3 — Perform Unit Testing

Assign:

- Unittest
- Functions
- Methods
- Assert Methods
- Review 5.3

---

# Unit 15 Workbook Mapping

## Workbook p. 94 — Assert Methods

- **PDF page:** 100
- **Objectives:** 5.3.1; 5.3.4
- **File listed in workbook:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 15.3 / 15.6

Certification methods include:

- `assertIsInstance`
- `assertEqual`
- `assertTrue`
- `assertIs`
- `assertIn`

---

## Workbook p. 95 — Functions and Methods

- **PDF page:** 101
- **Objectives:** 5.3.2; 5.3.3
- **File:** None
- **Site activity:** Fill-in-the-Blanks / Workbook Page
- **FoxCS placement:** 15.4–15.6

This page includes limited class/method vocabulary before Unit 19.

Treat that vocabulary as certification exposure rather than full OOP instruction.

---

## Workbook p. 96 — Review 5.3

- **PDF page:** 102
- **New video subtopic:** Review 5.3
- **File:** `534-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 15 review

Do not re-watch Assert Methods.

---

# UNIT 16: File Input & Output

## Certification Focus

Domain 3 Objective 3.1:

- `open`
- `close`
- `read`
- `write`
- `append`
- Check Existence
- `delete`
- `with` Statement
- Review 3.1

---

# Unit 16 Video Ownership

## Domain 3 Lesson 1 — File Input and Output Part 1

Assign:

- `open`
- `close`
- `read`
- `write`
- `append`

## Domain 3 Lesson 2 — File Input and Output Part 2

Assign:

- Check Existence
- `delete`
- `with` Statement
- Review 3.1

---

# Unit 16 Workbook Mapping

## Workbook p. 56 — open and close

- **PDF page:** 62
- **Objectives:** 3.1.1; 3.1.2
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** introductory Unit 16 file instruction

---

## Workbook p. 57 — read

- **PDF page:** 63
- **Objective:** 3.1.3
- **File:** `313-read.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 16.2

---

## Workbook p. 58 — write

- **PDF page:** 64
- **Objective:** 3.1.4
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 16.3

---

## Workbook p. 59 — append

- **PDF page:** 65
- **Objective:** 3.1.5
- **File:** `315-append.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 16.4

---

## Workbook p. 61 — Check Existence

- **PDF page:** 67
- **Objective:** 3.1.6
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** Unit 16 file-safety instruction

---

## Workbook p. 62 — delete

- **PDF page:** 68
- **Objective:** 3.1.7
- **File:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** Unit 16

---

## Workbook p. 63 — with Statement

- **PDF page:** 69
- **Objective:** 3.1.8
- **File:** `318-with.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 16.5

---

## Workbook p. 64 — Review 3.1

- **PDF page:** 70
- **New video subtopic:** Review 3.1
- **File:** `318-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 16 review

Do not re-watch `with` Statement.

---

# UNIT 17: Dates, Times, and Calendars

## Certification Focus

Domain 6 Objective 6.2.2:

- `datetime`
- `now`
- `strftime`
- `weekday`

---

# Unit 17 Video Ownership

### Domain 6 Lesson 2 — Solve Complex Problems Part 1

Assign:

- datetime

Math subtopics were already completed in Unit 12.

---

# Unit 17 Workbook Mapping

## Workbook p. 106 — datetime

- **PDF page:** 112
- **Objective:** 6.2.2
- **File:** `622-datetime.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 17.1–17.5

Covers:

- current date/time,
- formatting,
- weekday values,
- weekday names.

---

# UNIT 18: Working with the Computer

## Certification Focus

Domain 6:

- `io`
- `os`
- `os.path`
- `sys`
- Review 6.1

Plus the remaining Domain 3 Lesson 3 content:

- Use Command-Line Arguments
- First Half Review

This placement ensures that **every LearnKey workbook page and video subtopic is completed**, while keeping command-line work in the point of the FoxCS sequence where students are ready for it.

Keep Domain 3 and Domain 6 activities separate.

---

# Unit 18 Domain 3 Video Ownership

### Domain 3 Lesson 3

Assign the previously deferred:

- Use Command-Line Arguments
- First Half Review

Do not re-watch:

- Read Input from Console
- Print Formatted Text

Those were completed in Unit 03.

---

# Unit 18 Domain 3 Workbook Mapping

## Workbook p. 68 — Use Command-Line Arguments

- **PDF page:** 74
- **Domain:** 3
- **Objective:** 3.2.3
- **File:** `323-command.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 18.6

Students:

- run a Python file from a command prompt,
- use a command-line argument,
- verify the result.

---

## Workbook p. 69 — Review 3.2

- **PDF page:** 75
- **New video subtopic:** First Half Review
- **Workbook-listed starter:** None
- **Required student-created file:** `323-items-completed`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** after Domain 3 command-line exercise in Unit 18

Do not re-watch Use Command-Line Arguments.

The review intentionally synthesizes concepts from earlier domains.

---

# Unit 18 Domain 6 Video Ownership

### Domain 6 Lesson 1 — System and Command-Line Operations

Assign:

- `io`
- `os`
- `os.path`
- `sys`
- Review 6.1

---

# Unit 18 Domain 6 Workbook Mapping

## Workbook p. 98 — io

- **PDF page:** 104
- **Objective:** 6.1.1
- **File:** None listed in workbook
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** Unit 18 module introduction

---

## Workbook p. 99 — os

- **PDF page:** 105
- **Objective:** 6.1.2
- **File:** `612-os.py`
- **Site implementation:** Split

### Workbook Questions

Analyze existing `os` code.

### Coding Exercise: os

Use `612-os.py`.

---

## Workbook p. 100 — os.path

- **PDF page:** 106
- **Objective:** 6.1.3
- **File:** `613-ospath.py`
- **Site activity:** Coding Exercise
- **FoxCS placement:** 18.4

---

## Workbook p. 101 — sys

- **PDF page:** 107
- **Objective:** 6.1.4
- **File listed in workbook:** None
- **Site activity:** Workbook Page / Code Reading
- **FoxCS placement:** 18.5–18.6

Includes:

- module behavior,
- `sys.argv`,
- command-line argument concepts.

---

## Workbook p. 102 — Review 6.1

- **PDF page:** 108
- **New video subtopic:** Review 6.1
- **File:** `614-analyze.py`
- **Site activity:** Certification Review / Coding Exercise
- **FoxCS placement:** Unit 18 review

Do not re-watch `sys`.

---

# UNIT 19: Classes and Objects

## LearnKey Workbook Mapping

There are **no dedicated IT Specialist – Python workbook pages for OOP/classes**.

Unit 19 is FoxCS-original.

Students encountered limited certification vocabulary around:

- classes,
- objects,
- methods,

during Domain 5 testing content, but that did not constitute full OOP instruction.

Unit 19 provides the actual instructional sequence.

---

## Workbook Pages Assigned

```text
None
```

---

## New LearnKey Video Subtopics Assigned

```text
None
```

---

# UNIT 20: Capstone Project

## LearnKey Workbook Mapping

The Capstone is FoxCS-original.

There are no new LearnKey workbook pages assigned in this unit.

By the time students enter the final certification-preparation period, all workbook pages and video subtopics mapped to Units 02–18 should already be complete.

---

## Workbook Pages Assigned

```text
None
```

---

## New LearnKey Video Subtopics Assigned

```text
None
```

---

# Certification Completion Checkpoint

Before the IT Specialist – Python certification exam, verify that each student has completed the certification sequence mapped in this document.

Students should not reach certification preparation with unexplored workbook/video content remaining.

---

# Workbook Ownership Audit

The following table provides the canonical ownership of every workbook activity assigned from Unit 02 onward.

| Workbook Page | Original Title | FoxCS Unit |
|---:|---|---:|
| 10 | Strings and Integers | 02 |
| 11 | Floats and Bools | 02 |
| 12 | Review 1.1 | 02 |
| 14 | Data Type Conversion | 02 |
| 15 | Indexing | 08 |
| 17 | Slicing | 08 |
| 18 | Data Structures | 09 |
| 20 | Lists and Their Operations | 08 |
| 21 | Review 1.2 | 08 |
| 23 | Assignment Operators | 02 |
| 24 | Comparison Operators | 05 |
| 25 | Logical Operators | 05 |
| 27 | Arithmetic | 04 |
| 28 | Identity Operator | 05 |
| 29 | Containment Operator | 10 |
| 30 | Review 1.3 | 10 |
| 32 | Using Assignment Operators | 02 |
| 33 | Using Comparison Operators | 05 |
| 34 | Using Logical Operators | 05 |
| 36 | Using Arithmetic Operators | 04 |
| 37 | Using the Identity Operator | 05 |
| 38 | Using the Containment Operator | 10 |
| 39 | Review 1.4 | 10 |
| 41 | Branching Statements: if | 05 |
| 42 | Branching Statements: elif | 05 |
| 43 | Branching Statements: else | 05 |
| 44 | Nested/Compound Conditions | 05 |
| 45 | Review 2.1 | 05 |
| 47 | Iteration: while | 06 |
| 48 | Iteration: for | 06 |
| 49 | Iteration: break and continue | 06 |
| 51 | Iteration: pass | 06 |
| 52 | Nested Loops | 06 |
| 53 | Loops with Compound Conditions | 06 |
| 54 | Review 2.2 | 06 |
| 56 | open and close | 16 |
| 57 | read | 16 |
| 58 | write | 16 |
| 59 | append | 16 |
| 61 | Check Existence | 16 |
| 62 | delete | 16 |
| 63 | with Statement | 16 |
| 64 | Review 3.1 | 16 |
| 66 | Read Input from Console | 03 |
| 67 | Print Formatted Text | 03 |
| 68 | Use Command-Line Arguments | 18 |
| 69 | Review 3.2 | 18 |
| 71 | Use Indentation | 07 |
| 72 | Whitespace | 07 |
| 73 | Comments | 07 |
| 74 | Documentation Strings | 07 |
| 75 | Use Pydoc for Documentation | 07 |
| 76 | Review 4.1 | 07 |
| 78 | Call Signatures | 07 |
| 79 | Default Values | 07 |
| 80 | Use return | 07 |
| 81 | Use def | 07 |
| 82 | Use pass in Functions | 07 |
| 83 | Review 4.2 | 07 |
| 85 | Syntax Errors | 13 |
| 86 | Logic Errors | 13 |
| 87 | Runtime Errors | 13 |
| 88 | Review 5.1 | 13 |
| 90 | Exception Handling: try, except, else, and finally | 14 |
| 91 | Exception Handling: raise | 14 |
| 92 | Review 5.2 | 14 |
| 94 | Assert Methods | 15 |
| 95 | Functions and Methods | 15 |
| 96 | Review 5.3 | 15 |
| 98 | io | 18 |
| 99 | os | 18 |
| 100 | os.path | 18 |
| 101 | sys | 18 |
| 102 | Review 6.1 | 18 |
| 104 | Math | 12 |
| 105 | isnan, sqrt, isqrt, and pi | 12 |
| 106 | datetime | 17 |
| 108 | Random with Numbers | 11 |
| 109 | Random with Lists | 11 |
| 110 | Review 6.2 | 11 |

---

# Workbook Pages Outside Units 02–20

The LearnKey workbook also includes introductory/setup material before Unit 02.

These are **not missing** from this mapping.

They belong to the shared FoxCS onboarding / Unit 00 sequence:

- Workbook p. 7 — Python Introduction
- Workbook p. 8 — Installing Python

They should not be reassigned in Units 02–20.

---

# Video Subtopic Ownership Audit

## Unit 02

- `str`
- `int`
- `float`
- `bool`
- Review on 1.1
- Data Type Conversion
- Assignment Order
- Assignment

## Unit 03

- Read Input from Console
- Print Formatted Text

## Unit 04

- Arithmetic Order
- Arithmetic

## Unit 05

- Comparison Order
- Logical Order
- Identity Order
- Comparison
- Logical
- Identity
- `if`
- `elif`
- `else`
- Nested and Compound Conditions
- Review 2.1

## Unit 06

- `while`
- `for`
- `break`
- `continue`
- `pass`
- Nested Loops
- Loops with Compound Conditions
- Review 2.2

## Unit 07

- Use Indentation
- Whitespace
- Comments
- Documentation Strings
- Use Pydoc for Documentation
- Review 4.1
- Call Signatures
- Default Values
- `return`
- `def`
- Use `pass` in Functions
- Review 4.2

## Unit 08

- Indexing
- Slicing
- Lists
- List Operations
- Review on 1.2 Part 1
- Review on 1.2 Part 2

## Unit 09

- Construct Data Structures

## Unit 10

- Containment Order
- Review on 1.3
- Containment
- Review on 1.4

## Unit 11

- Random with Numbers
- Random with Lists
- Final Review

## Unit 12

- Math
- isnan, sqrt, isqrt, and pi

## Unit 13

- Syntax Errors
- Logic Errors
- Runtime Errors
- Review 5.1

## Unit 14

- `try`
- `except`
- else in Exception Handling
- `finally`
- `raise`
- Review 5.2

## Unit 15

- Unittest
- Functions
- Methods
- Assert Methods
- Review 5.3

## Unit 16

- `open`
- `close`
- `read`
- `write`
- `append`
- Check Existence
- `delete`
- `with` Statement
- Review 3.1

## Unit 17

- datetime

## Unit 18

### Domain 3

- Use Command-Line Arguments
- First Half Review

### Domain 6

- `io`
- `os`
- `os.path`
- `sys`
- Review 6.1

## Unit 19

No new LearnKey subtopics.

## Unit 20

No new LearnKey subtopics.

---

# Final Coverage Rule

This file is the canonical source for LearnKey workbook/video ownership.

When authoring or revising a FoxCS unit:

1. Find the unit in this mapping.
2. Assign only the workbook pages owned by that unit.
3. Assign only the new video subtopics owned by that unit.
4. When a review page repeats the preceding subtopic in its blue panel, assign only the new review video segment.
5. Split Fill-in-the-Blanks from Coding Exercises when both appear on the same workbook page.
6. Preserve the original workbook title and page number in activity metadata.
7. Keep each LearnKey Domain clearly identifiable.
8. Do not move or duplicate a page without updating this canonical map.
9. Before certification, audit the student's completion against this document.
10. By the end of Unit 18, all substantive LearnKey workbook pages and video subtopics should be complete, leaving Units 19–20 available for FoxCS-original advanced work, capstone development, final review, and certification preparation.