# FoxCS: Python: Course Plan

Source: `adaptive-python`'s `Curriculum_Python Fundamentals.md` ("Python Fundamentals: Computational Thinking Through Python"), 21 modules (00-20). This is the scope skeleton for FoxCS: Python. A lot of the actual question/lesson content will be adapted from what's already built there, not written from scratch. Verified 2026-07-24: every unit and lesson title below was checked line-by-line against the source file and matches exactly.

**Terminology note (2026-07-24):** FoxCS calls these **Units** (not "Modules") throughout this course, since it reads more naturally for a high school audience. This is a FoxCS-only naming choice and does not change anything in `adaptive-python`, which keeps calling them Modules. "Unit NN" in this file always corresponds 1:1 to "Module NN" in `Curriculum_Python Fundamentals.md`.

GMetrix/Certiport tie-ins below are sourced from a full read-through of `Python_v2_Student_Workbook.pdf` (LearnKey "Python v2," aligned to the IT Specialist – Python exam. 82 numbered exercises across the 6 domains, each with its own Steps for Completion, project file(s), time estimate, and exam objective) plus the actual starter files in `Python v2 Support Files/Domain 1-6/Student/`. GMetrix content is licensed reference material, not something to copy wholesale. See `01-privacy-and-governance/licensing-boundaries.md` for the boundary (it must never reach the commercial `adaptive-python` app) and `02-authoring-system/vscode-content-conventions.md` for the `GMETRIX-` file-naming convention required whenever GMetrix material is adapted into a lesson.

**One-domain-per-activity rule:** each GMetrix exercise in the workbook is small (most starter files are 2-16 lines; most exercises run 5-15 minutes) and scoped to exactly one domain. When a FoxCS unit's GMetrix tie-in below references more than one domain, that means two or more *separate* single-domain activities for that unit. Never blend files from two different `Domain N/Student/` folders into one activity or worksheet. A student working a GMetrix extra-credit activity should always be able to say "I'm in Domain N" without ambiguity. It's fine for the same domain to resurface in a unit much later in the year (e.g. Domain 3 shows up in Unit 03, then again in Unit 16). That's just two separate single-domain visits, not hopping, since they're far apart in time. What actually causes confusion, and what this mapping avoids, is mixing domains *within* one sitting.

**How GMetrix's own numbering works. Kept exactly as the workbook has it, nothing renamed:** the workbook runs on two numbering axes at once. **Domain → Lesson** (e.g. "Domain 1 Lesson 6") is the workbook's own pacing/video grouping. Domain 1 has 9 Lessons, most other domains have 2-3. **Objective → item** (e.g. "1.3", "1.3.4") is the IT Specialist – Python exam's own blueprint numbering, printed under "Objectives covered" on every exercise. A Lesson can span multiple Objectives, and one Objective can span multiple Lessons. They're not the same axis. Every support file is named after the **Objective** axis: first digit = Domain, second digit = Objective within that Domain, third digit = item within that Objective. So `111-str.py` = Domain 1, Objective 1.1, item 1 (`1.1.1 str`); `112-numbers.py` = Domain 1, Objective 1.1, item 2 (`1.1.2 int`). Both live in "Domain 1 Lesson 2" on the Lesson axis, but the Lesson number itself never appears in the filename. Every citation below gives both numbers. Domain/Lesson (for finding it in the workbook) and Objective/item (for finding the actual file).

**Game design / UX / journal tie-ins (added 2026-08-04):** every unit below also carries a *Game/UX tie-in* line (connecting the unit's Python concept to a game-design or usability idea, so the course reads as a game-design class even before students have the coding skill to build much) and a *Journal* line (the unit's entry in a year-long, iteratively-building reflective writing thread, starting at 50-75 words and growing to a ~2-page paper by the Capstone). Full rationale, the MDA framework primer, and the word-count progression schedule are in the **Game Design, UX, and Journal Threads** section at the bottom of this file. Read that section before authoring any unit's journal prompt in full, since the per-unit lines here are intentionally short.

This file is the master checklist. Check off lessons as their `content/` markdown file is authored (not as "finished". Just "drafted"). Each lesson should end up as one file in `content/`, following `templates/lesson-template.md`.

**Legend:** ⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final

---

## Unit 00: Course Onboarding

**Revised 2026-08-17 — no longer authored standalone here.** Game I does not have its own Unit 00 anymore. It shares one onboarding unit with Game II and Web II — see `../../00-project-overview/shared-unit-00-onboarding.md`. Game I students see that doc's **Level 1** edition: Python pathway only, MDA framework kept as core content (not a tagged callout, since Game I is single-pathway), same lesson spine (Welcome, How Learning Works, Using Your Tools, Troubleshooting Is Learning, Computational Thinking, How Problem-Solving Works, Getting Unstuck). GMetrix's Domain 1/Lesson 1 tie-in (Python Introduction, Installing Python) and the original 50-75 word MDA journal prompt both carry over into that shared doc's Level 1 edition — not duplicated here. **Physically not yet built** — the shared doc is an outline only as of 2026-08-17, same status this section was already in.

Unit 01 below is Game I's real first authored unit.

## Unit 01: What Is Programming?
*GMetrix tie-in: none. The workbook has no conceptual "what is a program" content beyond installation, which is already placed under Unit 00.*
*Game/UX tie-in: Input-Process-Output (01.2) is the basic model behind every interactive system, including a game loop (player input → game logic → screen output). Printing output (01.4) is a game's simplest form of feedback to the player. First usability idea: clear, friendly output beats terse or cryptic output.*
*Journal (50-100 words): Every game takes input from a player and gives output back. Describe the Input-Process-Output loop for a game you know, using specific examples.*
- [x] 01.1 What Programs Do ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_01_what_programs_do/`
- [x] 01.2 Input-Process-Output ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_02_input_process_output/`
- [x] 01.3 Writing Your First Program ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_03_writing_your_first_program/`
- [x] 01.4 Printing Output ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/`
- [x] 01.5 Comments and Documentation ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_05_comments_and_documentation/`
- [x] 01.6 Common Syntax Mistakes ✅ drafted 2026-08-04 . `courses/python/content/unit_01_what_is_programming/lesson_01_06_common_syntax_mistakes/`
- [x] 01 Project: Interactive Greeting ✅ drafted 2026-08-04. Scoped to print()/comments only (input()/variables aren't taught until Units 02-03); see `project/unit_01_project_instructions.html`

## Unit 02: Variables & Data
*GMetrix tie-in: Domain 1 only. Lesson 2, Objective 1.1. Strings and Integers (`111-str.py` = 1.1.1 str, `112-numbers.py` = 1.1.2 int), Floats and Bools (`113-numbers.py` = 1.1.3 float, `114-boolean.py` = 1.1.4 bool), Review 1.1 (`114-analyze.py`). Lesson 3, Objective 1.2.1. Data Type Conversion (`121-conversion.py`). (Indexing, the other half of Lesson 3. Objective 1.2.2. Moved to Unit 08 with the rest of that Objective run; see that unit's note.) Strong 1:1 fit for 02.2-02.6.
Also the home for Domain 1's Assignment Operator content. Lesson 6, Objective 1.3.1 (`131-assignment.py`, "Assignment Order") and its companion Lesson 8, Objective 1.4.1 (`141-assignment.py`, "Using Assignment Operators"). Assignment is what 02.1 Variables and Memory is about, so both short Domain 1 exercises land here rather than with the rest of the operators in Unit 05.*
*Game/UX tie-in: Variables are game state. Score, health, lives, position, inventory count. Every data type this unit covers is a kind of information a real game has to track and remember between frames.*
*Journal (50-100 words): List three pieces of information ("variables") a video game needs to keep track of while you play. Why does the game need to remember each one?*
- [ ] 02.1 Variables and Memory
- [ ] 02.2 Integers
- [ ] 02.3 Floats
- [ ] 02.4 Strings
- [ ] 02.5 Booleans
- [ ] 02.6 Type Conversion
- [ ] 02.7 Reading Code with Variables
- [ ] 02 Project: Personal Profile Generator

## Unit 03: User Input & Strings
*GMetrix tie-in: Domain 3 only. Lesson 3. Read Input from Console, Objective 3.2.1 (`321-input.py`); Print Formatted Text, Objective 3.2.2 (no starter file, string.format()/f-string methods). Fits 03.1-03.5. Lesson 3 also has a third piece, Use Command-Line Arguments, Objective 3.2.3 (`323-command.py`). Skip it here; FoxCS doesn't teach command-line execution until Unit 18, and Domain 6 has its own command-line file there (`614-command.py`), so there's no need to reach back into the Domain 3 folder later. (Indexing, previously noted here, moved entirely to Unit 08 alongside the rest of Domain 1's Objective 1.2 run. Keeps this unit Domain-3-only.)*
*Game/UX tie-in: Receiving user input is the player-input half of every interactive system, and the first real usability question of the course: what happens if the player types something the program didn't expect? This seed gets revisited properly once exception handling exists (Unit 14).*
*Journal (75-100 words): Think about a time a game or app didn't understand something you typed or tapped. What happened, and how did it make you feel? What could the designer have done differently?*
- [ ] 03.1 Receiving User Input
- [ ] 03.2 Building Dynamic Output
- [ ] 03.3 String Concatenation
- [ ] 03.4 F-Strings
- [ ] 03.5 String Format
- [ ] 03.6 Common String Methods
- [ ] 03.7 String Slicing Introduction
- [ ] 03 Project: Mad Lib Generator

## Unit 04: Math for Programmers
*GMetrix tie-in: Domain 1 only. Lesson 7, Objective 1.3.4. Arithmetic Order (`134-arithmetic.py`) and its companion Lesson 9, Objective 1.4.4. Using Arithmetic Operators (`144-arithmetic.py`). Fits 04.2 Arithmetic Operators exactly. This is one operator type out of Domain 1's larger six-type operator run (Objectives 1.3.1-1.3.6 and 1.4.1-1.4.6) that's being split across four units rather than kept as one block. See the "Domain 1's operators, split by type" note at the bottom of this file. Percentages, rounding, and real-world formula-building (04.6-04.9) are FoxCS-original, not covered by the workbook.*
*Game/UX tie-in: Math is the invisible engine behind scoring, damage calculations, physics, and timers. Most of what a game "feels like" numerically is arithmetic a player never sees directly.*
*Journal (75-100 words): Pick a number you've seen in a game (a score, a damage amount, a timer). Guess at the math formula that might produce it, and explain your reasoning.*
- [ ] 04.1 Math in Programming
- [ ] 04.2 Arithmetic Operators
- [ ] 04.3 Order of Operations
- [ ] 04.4 Integer vs Float Division
- [ ] 04.5 Modulo and Remainders
- [ ] 04.6 Percentages and Rates
- [ ] 04.7 Formulas with Variables
- [ ] 04.8 Rounding and Reasonableness
- [ ] 04.9 Solving Real-World Problems
- [ ] 04 Project: Tip, Tax, and Discount Calculator

## Unit 05: Making Decisions
*GMetrix tie-in: two separate single-domain activities.
(1) Domain 1. Comparison, Logical, and Identity operators: Lesson 6, Objectives 1.3.2/1.3.3 (`132-comparison.py`, `133-logical.py`) and Lesson 7, Objective 1.3.5 (`135-identity.py`), plus their Lesson 8-9 companions, Objectives 1.4.2/1.4.3/1.4.5 (`142-comparison.py`, `143-logical.py`, `145-identity.py`). Fits 05.1-05.2. Identity (`is` vs `==`) has no dedicated FoxCS lesson anywhere in the adaptive-python skeleton. This is its resolved home (was an open question, see `decisions-log.md` 2026-07-24), taught as a short add-on next to comparison operators since that's conceptually where it lives.
(2) Domain 2, Lesson 1, Objective 2.1. Branching Statements: if (2.1.1, no file), elif (2.1.2, no file), else (2.1.3, no file), Nested/Compound Conditions (2.1.4, `214-nested.py`), Review 2.1 (`214-analyze.py`). A near 1:1 match for 05.3-05.6.
Keep these as two clearly separate activities (Domain 1 operators, then Domain 2 branching). Don't blend the files.*
*Game/UX tie-in: If/else is the literal logic behind win/lose conditions, dialogue branches, and enemy AI decisions. First real MDA revisit since Unit 00: a simple Mechanic (a rule like "if health <= 0") produces a Dynamic (game over triggers) and an Aesthetic (tension as health gets low).*
*Journal (100-150 words): Choose a decision a game makes for the player or about the player (win/lose, a dialogue branch, enemy behavior). Write the logic as an if/else statement in plain English, then explain what Dynamic and Aesthetic result from that Mechanic. Look back at your Unit 00 journal entry. Has your thinking about Mechanics, Dynamics, and Aesthetics changed?*
- [ ] 05.1 Comparison Operators
- [ ] 05.2 Boolean Logic
- [ ] 05.3 If Statements
- [ ] 05.4 If-Else
- [ ] 05.5 Elif
- [ ] 05.6 Nested Conditionals
- [ ] 05.7 Reading Conditional Code
- [ ] 05 Project: Decision-Based Quiz

## Unit 06: Loops & Repetition
*GMetrix tie-in: Domain 2 only, Objective 2.2 (Iteration), spanning Lesson 2 and Lesson 3. Lesson 2. While (2.2.1, `221-while.py`), for (2.2.2, `222-for.py`), break/continue (2.2.3/2.2.4, `224-continue.py`). Lesson 3. Pass (2.2.5, `225-pass.py`), Nested Loops (2.2.6, `226-nested.py`), Loops with Compound Conditions (2.2.7, `227-compound.py`), Review 2.2 (`227-analyze.py`). Near 1:1 match across the whole unit.*
*Game/UX tie-in: Explicit vocabulary moment. The update/render cycle every video game runs on is literally called "the game loop" in the industry. While/for loops map directly onto animation frames, enemy patrol patterns, and repeated challenges.*
*Journal (100-150 words): Every video game runs on something programmers literally call "the game loop". Check, update, draw, repeat. Where in a game you play can you see this repetition happening? Connect it to a while or for loop concept from this unit.*
- [ ] 06.1 Why Loops Matter
- [ ] 06.2 While Loops
- [ ] 06.3 For Loops
- [ ] 06.4 Range
- [ ] 06.5 Loop Patterns
- [ ] 06.6 Break
- [ ] 06.7 Continue
- [ ] 06.8 Pass
- [ ] 06.9 Nested Loops
- [ ] 06.10 Reading Loop Traces
- [ ] 06 Project: Number Guessing Game

## Unit 07: Functions
*GMetrix tie-in: Domain 4 only. Lesson 2, Objective 4.2. Call Signatures (4.2.1, no file), Default Values (4.2.2, `422-default.py`), return (4.2.3, no file), def (4.2.4, `424-def.py`), pass in Functions (4.2.5, `425-pass.py`), Review 4.2 (`425-analyze.py`). Fits 07.2-07.8. Lesson 1, Objective 4.1's Documentation Strings (4.1.4, `414-docstrings.py`) fits 07.9 Docstrings. The workbook's Pydoc exercise (4.1.5) is listed against `Datetime.txt` as its project file, worth double-checking directly against the workbook page when this lesson gets authored since that's an unusual pairing. Both Lessons are Domain 4, so this stays a single-domain unit even though it draws from two Lessons.*
*Game/UX tie-in: Functions are reusable abilities . `jump()`, `attack()`, `take_damage()`. The building blocks that let a game mechanic exist as a modular, reusable system instead of one-off code.*
*Journal (100-150 words): If a character in your favorite game were built with functions, name three functions it might need (e.g., jump(), attack()). For one of them, describe what parameters (inputs) it would need and what it would return or do.*
- [ ] 07.1 Why Functions Matter
- [ ] 07.2 Defining Functions
- [ ] 07.3 Calling Functions
- [ ] 07.4 Parameters
- [ ] 07.5 Return Values
- [ ] 07.6 Variable Scope
- [ ] 07.7 Default Parameters
- [ ] 07.8 Call Signatures
- [ ] 07.9 Docstrings
- [ ] 07.10 Reading Function Code
- [ ] 07 Project: Function Toolkit

## Unit 08: Lists
*GMetrix tie-in: Domain 1 only. Lesson 3, Objective 1.2.2. Indexing (`122-indexing.py`) (the other half of Lesson 3, Data Type Conversion/1.2.1, is anchored at Unit 02 instead). Lesson 4. Slicing, Objective 1.2.3 (`123-slicing.py`); Data Structures, Objective 1.2.4 (workbook lists project file as N/A, but `124-structure.py` exists in the folder for it. Worth confirming against the actual workbook page during authoring). Lesson 5, Objectives 1.2.5-1.2.6. Lists and Their Operations, one combined exercise (`126-list_operations.py`; the folder also has a `125-list.py` that looks related but isn't cited by name in the workbook text. Check it directly when authoring), Review 1.2 (`126-analyze.py`). Strong fit, especially 08.3 Accessing Items (indexing) and 08.10 List Slicing.*
*Game/UX tie-in: Lists are inventory systems, leaderboards, enemy waves, and dialogue queues. Most "collections of things" a game manages are a list underneath.*
*Journal (150-200 words): Pick a game system that's really a list underneath (an inventory, a leaderboard, a deck of cards, a level queue). Describe what's stored in it and one action (add, remove, reorder) the player can take on that list, and how the game responds.*
- [ ] 08.1 Why Lists Matter
- [ ] 08.2 Creating Lists
- [ ] 08.3 Accessing Items
- [ ] 08.4 Updating Items
- [ ] 08.5 Append
- [ ] 08.6 Insert
- [ ] 08.7 Remove
- [ ] 08.8 Pop
- [ ] 08.9 Looping Through Lists
- [ ] 08.10 List Slicing
- [ ] 08 Project: List Manager

## Unit 09: Working with Data Collections
*GMetrix tie-in: none for hands-on practice. The workbook's Domain 1 glossary defines Dictionary, Set, and Tuple Variable as vocabulary (under the "Data Structures" lesson), but there are no dedicated dict/tuple/set exercise files in `Python v2 Support Files/Domain 1/`. Treat this unit as FoxCS-original; a GMetrix vocabulary callout could be borrowed for terminology but not practice content. Flagged as a genuine content gap, not an oversight. See `open-questions.md`.*
*Game/UX tie-in: Dictionaries are structured game data. A character's full stat block, an item's properties, a save-file record. Where each piece of information has a name (key), not just a position.*
*Journal (150-200 words): Design a simple dictionary that could represent one item, character, or enemy in a game (name, stats, etc. as key-value pairs). Explain each key and why a player or the game itself would need that information.*
- [ ] 09.1 Tuples
- [ ] 09.2 Tuple Unpacking
- [ ] 09.3 Dictionaries
- [ ] 09.4 Keys and Values
- [ ] 09.5 Updating Dictionaries
- [ ] 09.6 Looping Through Dictionaries
- [ ] 09.7 Nested Data
- [ ] 09.8 Modeling Real-World Data
- [ ] 09 Project: Contact Manager

## Unit 10: Sorting, Searching, and Patterns
*GMetrix tie-in: Domain 1 only, and narrow. The Containment Operator content: Lesson 7, Objective 1.3.6 (`136-containment.py`, "Containment Order") and its companion Lesson 9, Objective 1.4.6 (`146-containment.py`, "Using the Containment Operator," which also carries the Review 1.4 file `146-analyze.py`). Fits 10.5 Membership Testing exactly (it's literally the same concept, `in`). This is the last of Domain 1's split-out operator lessons. See the operators note at the bottom of this file. sort()/sorted()/min()/max()/searching (10.1-10.4, 10.6-10.7) are not covered by the workbook.*
*Game/UX tie-in: Sorting builds leaderboards and organizes inventories. Searching is the basis of "find item" and simple pathfinding. Pattern recognition (10.6) is also a genuine learning-design idea. It's how players learn a game's rules through repetition, the same way students are learning Python's patterns through repetition (ties back to 00.2 How Learning Works).*
*Journal (200-250 words): Leaderboards are sorted lists. Pick a real or imagined leaderboard and describe how it should be sorted and why (highest score first? fastest time first?). Then reflect: how does a player learn a game's patterns over time, the way you're learning Python's patterns over time?*
- [ ] 10.1 sort()
- [ ] 10.2 sorted()
- [ ] 10.3 reverse()
- [ ] 10.4 min(), max(), and sum()
- [ ] 10.5 Membership Testing
- [ ] 10.6 Pattern Recognition Through Data
- [ ] 10.7 Introduction to Searching
- [ ] 10 Project: Data Explorer

## Unit 11: Randomness and Simulation
*GMetrix tie-in: Domain 6 only. Lesson 3, Objective 6.2.3 (random: randrange, randint, random, shuffle, choice, sample). Random with Numbers and Random with Lists, plus a Final Review. The workbook's text lists project files as N/A for these pages, but the folder has `623-random.py`, `623-choice.py`, `623-shuffle.py`, and `623-final.py`. Check the workbook page directly during authoring to match files to steps precisely. Strong fit for 11.2-11.5.*
*Game/UX tie-in: The deepest MDA moment so far. Randomness is itself a Mechanic. And it's a Mechanic that directly produces Dynamics (unpredictability, replayability) and Aesthetics (surprise, luck-based tension or excitement). Pairs directly with this unit's own project, "Game of Chance."*
*Journal (250-300 words): Randomness is a Mechanic. Using the MDA framework from Unit 00, explain how adding randomness to a game changes its Dynamics (what actually happens when you play) and its Aesthetics (how it feels to play). Use your Unit 11 project (Game of Chance) as your example, and reference how your Unit 00 or Unit 05 thinking about MDA has grown.*
- [ ] 11.1 Importing Modules
- [ ] 11.2 random
- [ ] 11.3 randint
- [ ] 11.4 choice
- [ ] 11.5 shuffle
- [ ] 11.6 Simple Simulations
- [ ] 11.7 Probability Through Code
- [ ] 11 Project: Game of Chance

## Unit 12: Useful Python Tools
*GMetrix tie-in: Domain 6 only. Lesson 2, Objective 6.2.1. Math (fabs, ceil, floor, trunc, fmod, frexp, nan, isnan, sqrt, isqrt, pow, pi), split across two workbook pages (Math; isnan/sqrt/isqrt/pi) that both cite the same Objective. The workbook text lists project files as N/A for both pages, but `621-math.py` exists in the folder. Confirm the exact file-to-step mapping against the workbook page during authoring. Strong fit for the whole unit (12.2-12.5 map onto individual functions from this same Objective).*
*Game/UX tie-in: Math-module functions are the invisible calculations behind smooth gameplay. Rounding damage numbers, physics, distance checks. Work a player benefits from but never sees directly.*
*Journal (225-275 words): Pick one math function from this unit (ceil, floor, sqrt, etc.) and describe a specific place a game might use it behind the scenes, where the player never sees the math directly but would notice if it were wrong.*
- [ ] 12.1 The Math Module
- [ ] 12.2 ceil()
- [ ] 12.3 floor()
- [ ] 12.4 trunc()
- [ ] 12.5 sqrt()
- [ ] 12.6 Working with Common Tools
- [ ] 12 Project: Calculator Upgrade

## Unit 13: Debugging and Errors
*GMetrix tie-in: Domain 5 only. Lesson 1, Objective 5.1. Syntax Errors (5.1.1, `511-syntax.py`), Logic Errors (5.1.2, `512-logic.py`), Runtime Errors (5.1.3, `513-runtime.py`), Review 5.1 (`513-analyze.py`). Strong 1:1 fit; GMetrix doesn't break errors down by exception type (SyntaxError/NameError/TypeError/etc.) the way this unit does, so treat GMetrix as a source for the error-category framing (13.1, 13.8) rather than per-type content (13.2-13.7).*
*Game/UX tie-in: Reframe debugging explicitly as playtesting/QA. The professional game-industry practice of finding what breaks the experience before players do. Ties directly back to 00.4 Debugging Is Learning.*
*Journal (250-300 words): Professional game studios have entire QA (quality assurance) teams whose job is to break the game on purpose so bugs get fixed before players see them. Describe a bug (SyntaxError, NameError, TypeError, etc.. Pick one from this unit) you fixed recently, and explain how a QA tester might have first noticed a bug like it.*
- [ ] 13.1 What Errors Teach Us
- [ ] 13.2 SyntaxError
- [ ] 13.3 NameError
- [ ] 13.4 TypeError
- [ ] 13.5 ValueError
- [ ] 13.6 IndexError
- [ ] 13.7 KeyError
- [ ] 13.8 Reading Tracebacks
- [ ] 13 Project: Debugging Challenge

## Unit 14: Exception Handling
*GMetrix tie-in: Domain 5 only. Lesson 2, Objective 5.2. Try/except/else/finally (5.2.1-5.2.4, no starter file), raise (5.2.5, no starter file), Review 5.2 (`525-analyze.py`). Near 1:1 match.*
*Game/UX tie-in: The strongest usability moment in the course. Good usability means a program never just crashes on the user. It explains what went wrong and helps them recover (Nielsen's error-prevention/clear-recovery heuristics, in industry terms). try/except and 14.5 Handling User Errors are the technical mechanism; 14.6 Defensive Programming is the design mindset.*
*Journal (300-350 words): Good usability means a program never just crashes on the user. It explains what went wrong and helps them recover. Pick a program or game that handled an error badly (a crash, a confusing message) and one that handled it well. Using try/except concepts from this unit, describe how you'd rewrite the bad example to give the user a clear, friendly message instead.*
- [ ] 14.1 try
- [ ] 14.2 except
- [ ] 14.3 else
- [ ] 14.4 finally
- [ ] 14.5 Handling User Errors
- [ ] 14.6 Defensive Programming
- [ ] 14 Project: Safe Input System

## Unit 15: Testing Your Code
*GMetrix tie-in: Domain 5 only. Lesson 3, Objective 5.3. Unittest/Assert Methods (5.3.1/5.3.4: assertIsInstance, assertEqual, assertTrue, assertIs, assertIn), Functions/Methods (5.3.2/5.3.3), Review 5.3 (`534-analyze.py`). The workbook text lists project files as N/A here, but the folder has `531-unittest.py` (confirmed by direct read. A plain `unittest.TestCase` example) plus `532-functions.py`, `533-methods.py`, `534-assert.py`. Strong fit for 15.3, 15.6.*
*Game/UX tie-in: Testing is the technical, repeatable counterpart to playtesting. A test case says exactly "when the player does X, the game should do Y," defined in advance instead of discovered by accident.*
*Journal (300-350 words): A test case says "when the player does X, the game should do Y." Write three test cases for a simple game mechanic of your choice (can be from a game you play, or your own project), then explain why "edge cases" (unusual inputs) matter just as much as the expected ones.*
- [ ] 15.1 Why Testing Matters
- [ ] 15.2 Manual Testing
- [ ] 15.3 Assertions
- [ ] 15.4 Test Cases
- [ ] 15.5 Edge Cases
- [ ] 15.6 Introduction to Unit Testing
- [ ] 15 Project: Testing Challenge

## Unit 16: File Input & Output
*GMetrix tie-in: Domain 3 only. Lesson 1, Objective 3.1. Open/close (3.1.1/3.1.2, no file), read (3.1.3, `313-read.py`), write (3.1.4, no file), append (3.1.5, `315-append.py`). Lesson 2. Check Existence (3.1.6, no file), delete (3.1.7, no file), with Statement (3.1.8, `318-with.py`), Review 3.1 (`318-analyze.py`). Strong 1:1 fit across the whole unit. This is Domain 3's second and last visit (the first was Console I/O, Objective 3.2, back in Unit 03). A single-domain revisit, not a mix.*
*Game/UX tie-in: Save/load systems are file I/O. This is literally how a game remembers progress between sessions. Nice built-in echo: this unit's own project is called "Journal Application," directly mirroring the writing thread students have been doing all year.*
*Journal (350-450 words): Every game with a "Save" button is using file I/O behind the scenes. Explain, in your own words, what information a save file for a game you enjoy would probably need to store, and why losing that file would matter to a player. Then reflect on this unit's own project (a Journal Application). What's similar between a save file and a written journal entry like the ones you've been writing all year?*
- [ ] 16.1 Why Files Matter
- [ ] 16.2 Reading Files
- [ ] 16.3 Writing Files
- [ ] 16.4 Appending Files
- [ ] 16.5 Context Managers
- [ ] 16.6 Processing Text Files
- [ ] 16 Project: Journal Application

## Unit 17: Dates, Times, and Calendars
*GMetrix tie-in: Domain 6 only. Lesson 2, Objective 6.2.2. Datetime (now, strftime, weekday), file `622-datetime.py`. Strong fit.*
*Game/UX tie-in: Timers, cooldowns, daily rewards, and event countdowns are all datetime concepts. Common in mobile and live-service games specifically to shape player behavior and return visits.*
*Journal (350-450 words): Many games use timers or countdowns (a cooldown, a daily login bonus, an event ending soon). Pick one example and explain the psychological effect it has on players. Why might a designer choose to include a countdown at all, beyond the technical need to track time?*
- [ ] 17.1 What Is Datetime?
- [ ] 17.2 Current Date and Time
- [ ] 17.3 Timedelta
- [ ] 17.4 Date Calculations
- [ ] 17.5 strftime
- [ ] 17.6 Practical Date Programs
- [ ] 17 Project: Event Countdown

## Unit 18: Working with the Computer
*GMetrix tie-in: Domain 6 only. Lesson 1, Objective 6.1. Io (6.1.1, workbook text lists N/A but `611-io.py` exists), os (6.1.2, `612-os.py`), os.path (6.1.3, `613-ospath.py`), sys (6.1.4, workbook text lists N/A but the folder has `614-sys.py`, `614-command.py`, `614-command.txt`, `614-log.txt`). Sys's own Objective already includes command-line arguments in its description ("importing modules, opening, reading and writing files, command-line arguments"), which is why Unit 03 didn't need to reach into Domain 3's separate command-line file (`323-command.py`). Review 6.1 (`614-analyze.py`). Strong fit across the whole unit, single domain throughout.*
*Game/UX tie-in: File-system and command-line concepts are the invisible infrastructure a game runs on top of. Finding save files, checking install directories. Good design means a player should never have to think about any of it; when they do (a missing save file, a broken path), that's a design failure, not just a bug.*
*Journal (400-500 words): Most players never think about the file system a game runs on top of. But if a save file goes missing or a game can't find a folder it needs, the whole experience breaks. Describe, using a concept from this unit (os, sys, file paths), one "invisible" piece of infrastructure a game you enjoy probably depends on, and why good design means the player should never have to think about it.*
- [ ] 18.1 Introduction to os
- [ ] 18.2 getcwd
- [ ] 18.3 listdir
- [ ] 18.4 exists
- [ ] 18.5 Introduction to sys
- [ ] 18.6 Command-Line Arguments
- [ ] 18 Project: File Finder

## Unit 19: Classes and Objects
*GMetrix tie-in: none. The IT Specialist Python v2 objectives don't cover OOP/classes at all. Treat this unit as entirely FoxCS-original. Flagged alongside Unit 09 as a genuine coverage gap, not an oversight.*
*Game/UX tie-in: The biggest game-design payoff in the whole course. Player/Enemy/Item classes and inheritance (Enemy → Boss) are exactly how real games structure their entities. Designing a class well is designing a Mechanic well. This is where MDA analysis and actual code finally fully meet.*
*Journal (450-600 words): Design a class for one game character or object type (a Player, an Enemy, an Item. Your choice). List its attributes and at least two methods, and explain your design choices using the MDA framework: how does this class's structure (Mechanics) shape what can happen during play (Dynamics), and what feeling should that produce for the player (Aesthetics)? Reference how your understanding of Mechanics has changed since your very first Unit 00 journal entry.*
- [ ] 19.1 What Are Objects?
- [ ] 19.2 Creating Classes
- [ ] 19.3 Attributes
- [ ] 19.4 Methods
- [ ] 19.5 init
- [ ] 19.6 Modeling Real-World Systems
- [ ] 19.7 Introduction to Inheritance
- [ ] 19 Project: Employee Management System

## Unit 20: Capstone Project
*GMetrix tie-in: none. Capstone is course-original by design.*
*Game/UX tie-in: Full-year synthesis. The journal entry below is the "2-page paper" the year's progression has been building toward. A short design document covering Mechanics, Dynamics, Aesthetics, and a usability decision, for the student's own capstone.*
*Journal (500-700 words, ~2 pages): Write a short design document for your capstone project. Include: (1) what your program's core Mechanics are (the actual rules/code you built), (2) what Dynamics emerge when someone uses it, (3) what Aesthetic/emotional experience you want the user to have, and (4) at least one usability decision you made to keep the experience clear and forgiving for someone using it for the first time. Close by looking back at your very first Unit 00 journal entry. How has your thinking about games, code, and design grown across the year?*
- [ ] 20.1 Project Planning
- [ ] 20.2 Feature Scoping
- [ ] 20.3 Building V1
- [ ] 20.4 Testing and Debugging
- [ ] 20.5 Reflection and Revision
- [ ] 20 Final Project

**Pacing target, added 2026-08-17 per `../../CLAUDE.md`'s Hard Constraints:** Unit 20 should be finished, including the IT Specialist – Python certification exam itself, **before mid-April** — AP testing runs mid-to-late April and seniors are typically checked out by mid-May, and Jay's direct observation is that motivation drops hard once those periods hit. Units 01-20 need to fit the calendar window before that, not treat the last several weeks of school as ordinary instructional time. Exact week-by-week pacing against real dates is blocked on the official CPS academic calendar (see `../../open-questions.md`) — this is a target to design toward, not a scheduled date yet.

## Post-Capstone: MakeCode Arcade (2D Projects)

**Added 2026-08-17, not yet scoped into units/lessons.** Per Jay: Game I students are expected to earn one certification (IT Specialist – Python) and are not expected to pursue a second the way Game II/Web II students are (see `../../decisions-log.md`'s 2026-08-17 entry on certification framing). After Unit 20's capstone and certification exam, the course moves into **MakeCode Arcade** for 2D game projects — a natural fit for the AP-testing-through-end-of-year stretch flagged in the pacing constraint above, since it's lower-stakes, high-engagement, block-code-adjacent work that doesn't assume strong attendance or motivation, and doesn't require new core Python content a student can't afford to miss. **Not confirmed as deliberately timed there** — flagged as plausible, not decided (see `../../open-questions.md`). No units/lessons drafted for this stretch yet; scope, length, and whether it's graded or purely enrichment are all open.

---

## Reuse Notes

`adaptive-python` already has a substantial question bank and project prompts built against this same unit structure (`curriculum/questions/`, `curriculum/projects/`, `curriculum/json/` in that repo). When authoring a FoxCS: Python lesson, check there first. Adapting existing content (trimmed down, restructured into the branching correct/incorrect pattern) will usually be faster than writing from scratch. Not everything will carry over cleanly: that content assumes the full adaptive-python schema (XP, adaptive tiers, hidden tests, 4 difficulty bands), which this course intentionally doesn't use. Pull the pedagogical content (prompts, correct answers, misconceptions, hints) and leave the schema-specific parts behind.

## GMetrix Domain Mapping

Source: a full read-through of `Python_v2_Student_Workbook.pdf` (LearnKey "Python v2" courseware, aligned to the IT Specialist – Python exam. 82 exercises across 6 domains, extracted via `pdftotext` and read in full, not just the table of contents) plus every actual starter file in `Python v2 Support Files/Domain 1-6/Student/` (91 `.py`/support files total). See the "How GMetrix's own numbering works" note at the top of this file for how Domain/Lesson and Objective/item numbers relate to filenames like `114-boolean.py` or `211-if.py`. Every unit note above cites both.

| GMetrix Domain | Workbook Topics | FoxCS Unit(s). Each a single-domain visit |
|---|---|---|
| Domain 1. Operations Using Data Types and Operators | Data types (str/int/float/bool), conversion, indexing, slicing, data structures overview, list operations, and six operator types (assignment, comparison, logical, arithmetic, identity, containment) | 00 (install/setup only), 02 (data types + assignment operator), 04 (arithmetic operator), 05 (comparison/logical/identity operators), 08 (indexing/slicing/lists), 10 (containment operator) |
| Domain 2. Branching Statements and Iteration | if/elif/else, nested/compound conditions, while, for, break, continue, pass, nested loops | 05 (branching), 06 (loops) |
| Domain 3. File Input/Output and Console Input/Output | open/close/read/write/append, check existence, delete, with statement, console input, formatted print, command-line arguments | 03 (console I/O only), 16 (file I/O) |
| Domain 4. Document Code Segments and Function Definitions | Indentation, whitespace, comments, docstrings, pydoc, call signatures, default values, return, def, pass | 07 (functions + docstrings) |
| Domain 5. Errors, Exception Handling, and Unit Testing | Syntax/logic/runtime errors, try/except/else/finally, raise, assert, unit testing basics | 13 (errors), 14 (exceptions), 15 (testing) |
| Domain 6. System/Command-Line Operations and Built-in Modules | io, os, os.path, sys (incl. command-line arguments), math (incl. isnan/sqrt/isqrt/pi), datetime, random | 11 (random), 12 (math), 17 (datetime), 18 (os/sys/command-line) |

**Domain 1's operators, split by type. Why:** Domain 1 actually teaches each operator type (assignment, comparison, logical, arithmetic, identity, containment) *twice*. Once under Objective 1.3 "Determine the sequence of execution" (Lessons 6-7, files `131`-`136`) and again under Objective 1.4 "Select operators to achieve the intended results" (Lessons 8-9, files `141`-`146`). Twelve short exercises total, back-to-back as one workbook unit. Rather than anchoring that whole unit at a single FoxCS unit (which would mean either cramming six operator types × two objectives into one week, or making students backtrack to the Domain 1 folder from a unit that's about something else), each operator type (both its 1.3.x and 1.4.x exercise) is split out to the one FoxCS unit that already teaches that exact concept: assignment → Unit 02, arithmetic → Unit 04, comparison/logical/identity → Unit 05, containment → Unit 10. Each landing spot is still a single-domain (Domain 1), single-concept activity, just with two small companion files instead of one. This isn't domain-hopping, it's four small check-ins spread across the year instead of one oversized twelve-exercise block.

**Coverage gaps (GMetrix has no content for these FoxCS units):** Unit 09 (tuples/dictionaries. Domain 1's glossary defines the vocabulary but there's no practice content), most of Unit 10 (sort/sorted/min/max/searching. Only Membership Testing has a GMetrix match), Unit 19 (classes/OOP. Not on the exam at all), Unit 20 (capstone, by design). These stay entirely FoxCS-original.

**Resolved:** the identity operator (`is` vs `==`) previously had no FoxCS home. It's now placed in Unit 05 alongside comparison operators (see that unit's note above). See `decisions-log.md`, 2026-07-24.

**How to use this in authoring:** when a unit has a GMetrix tie-in, check the specific files named in that unit's note (or the matching `Python v2 Support Files/Domain N/Student/` folder) for exercise ideas alongside the `adaptive-python` question bank. Anything adapted from GMetrix gets the `GMETRIX-` filename prefix per `02-authoring-system/vscode-content-conventions.md` and must stay traceable per `01-privacy-and-governance/licensing-boundaries.md`. Keep each GMetrix-derived activity scoped to files from one domain folder only. See the one-domain-per-activity rule at the top of this file. GMetrix content is a source of exercise *ideas and structure*, not a replacement for the adaptive-python-derived core content. This course's practice volume is intentionally lighter than either source.

## Game Design, UX, and Journal Threads

Added 2026-08-04, per Jay's request to make the course *feel* like a game-design class throughout, not just a Python-syntax class with a game-themed coat of paint at the end. Including when students' Python skills aren't yet advanced enough to actually build the mechanic being discussed. Every unit above carries a *Game/UX tie-in* line (the concept connection) and a *Journal* line (that unit's writing prompt). This section is the shared rationale behind both, so it's written once instead of repeated 21 times.

### The MDA Framework

**Mechanics / Dynamics / Aesthetics** (Hunicke, LeBlanc, Zubek) is the lens used throughout the course to connect "what the code does" to "why a game feels the way it does":

- **Mechanics**. The rules and systems, literally what the code implements (a variable, a conditional, a loop, a class).
- **Dynamics**. The runtime behavior that emerges from Mechanics interacting with a player over time (a chase, a comeback, a stalemate).
- **Aesthetics**. The emotional response a player has as a result (tension, delight, frustration, pride).

Introduced in Unit 00 using only games students already play. Deliberately *before* they have the coding skill to build any of it themselves, per Jay's explicit intent: *"even if they do not always get to practice this because their skills are not as advanced, I want them to have some concepts to keep it engaging."* Revisited with growing sophistication at Units 05, 11, 19, and 20. Each revisit explicitly asks the student to look back at an earlier entry, which is what makes the thread iterative rather than four disconnected MDA mentions.

### Usability / Human-Centered Design: a lighter throughline than Game II/Web II

Per `../../CLAUDE.md`'s Platform Decisions, usability/HCD should touch every FoxCS course but is *especially* a focus in Web Dev/Web II and Game II. In this course it's a real but lighter throughline, seeded early (Unit 03's "what happens when input surprises the program") and paid off properly once the technical tools exist to act on it (Unit 14's exception-handling-as-usability unit is the deliberate peak), rather than front-loaded before students can do anything about it.

### Journal Progression: word counts are floors, not caps

Starts at 50-75 words (Unit 00) and grows to 500-700 words / roughly a 2-page paper by the Capstone (Unit 20). Assumption made explicit: "2-page paper" is treated as ~500-700 words, consistent with a typical double-spaced high-school-essay page count. Adjust if Jay's actual expectation runs longer or shorter. The progression is intentionally not a perfectly even staircase (some units sit close to their neighbors). The point is a believable overall climb across four rough stages, not a rigid formula:

| Stage | Units | Word range | What's expected |
|---|---|---|---|
| 1. Warm-Up: Naming What You See | 00-04 | 50-100 | Observing/naming game concepts from games they already know; no coding skill required |
| 2. Describing How It Works | 05-09 | 100-200 | Connecting a code construct they can now write (conditionals, loops, functions, data) to a game mechanic |
| 3. Analyzing and Justifying | 10-15 | 200-350 | Structured paragraphs with reasoning/evidence; first real usability critique writing (Unit 14) |
| 4. Designing and Synthesizing | 16-20 | 350-700 | Full design-document-style writing; explicit callbacks to earlier entries; Unit 20 closes the year by revisiting Unit 00 directly |

**Grading philosophy (rubric confirmed 2026-08-04):** journals are graded on:

- **Thoughtfulness and completion of the ask**. Did the student actually address what the prompt asked, not just write words in the general vicinity of the topic.
- **Genuine reflection, rooted in concepts as needed**. The response should show real engagement with the unit's actual concept (MDA, the mechanic category, the usability idea), not a generic opinion that could have been written before the unit started.
- **Opinions need to earn their place**. If a student takes a stance, it should be justified (why they think that), and should tie back to a source/reference when relevant (the game they're analyzing, the unit's concept, a GMTK episode if one was used) rather than floating free of evidence.
- **It should sound like the student wrote it.** Writing that doesn't read as the student's own voice is itself a flag, independent of content quality.

This is still lighter-touch than literary/grammar grading (`02-authoring-system/lesson-schema.md`'s `skip_check_required` principle). The writing skill being built is *thinking in writing about design*, not prose polish. Exact points/XP value per entry isn't set yet.

**Academic integrity. AI use is forbidden, not just discouraged.** Using AI to generate a journal entry (or any other written response) and submitting it as the student's own is a 0 on the assignment, documented in Aspen as a logged incident. The same rule applies to AI-generated code submitted as a student's own work. This is a platform-wide policy, not a Python-specific or journal-specific one. Full detail, including the human-review safeguard around automated detection, is in `../../01-privacy-and-governance/academic-integrity-ai-use.md`. Don't build or describe any automated "AI-generated, therefore 0" pipeline step without that safeguard attached.

### General Game Mechanics Vocabulary

Added 2026-08-04, alongside MDA, to make the game-mechanics learning more general than each unit's specific Python tie-in. A named taxonomy students can point back to all year, not just as specific as whatever concept a given unit happens to teach. Introduce this table in Unit 00, the same session MDA gets introduced:

| Mechanic Category | What it means | Where it already shows up in this course |
|---|---|---|
| Core Loop | The repeated cycle of actions a player performs (check → act → get feedback → repeat) | Unit 06 (loops = the literal "game loop") |
| State & Resource Tracking | Values a game must remember and update (health, score, inventory) | Unit 02 (variables = game state), Unit 08 (lists = inventory) |
| Rules & Decision Systems | The branching logic that decides outcomes | Unit 05 (if/else = win/lose, dialogue branches) |
| Player Actions & Abilities | The verbs a player/character can perform | Unit 07 (functions = jump()/attack()) |
| Progression & Feedback | How a player sees their own improvement or standing | Unit 10 (sorting = leaderboards) |
| Chance & Risk/Reward | Uncertainty as a deliberate design choice | Unit 11 (randomness) |
| Failure States & Forgiveness | What happens when something goes wrong, and how gracefully | Unit 14 (exception handling = usability) |
| Pacing & Time Pressure | How time itself shapes player behavior | Unit 17 (timers, cooldowns) |
| Entities & Systems Architecture | How a game's "things" (characters, items) are structured and relate to each other | Unit 19 (classes) |

Each unit's Game/UX tie-in above already teaches one of these categories in practice. This table just names the category explicitly so students (and future authors) have one consistent vocabulary to reuse, instead of each unit's mechanic connection staying implicit. Later units' journal prompts can reference these category names directly ("this is a Failure States mechanic") once the vocabulary exists. **First cut, not final**. Jay may want different category names or boundaries; revise once Unit 00 is actually authored and this gets used for real.

### File Format and Naming

Per Jay: *"These can be txt files in some cases that they write in and submit like journals."* Default: every journal entry is its own `.txt` file from Unit 00 onward, building the file-habit early even while entries are short. Consistent with the rest of the course already treating file-naming compliance as a graded skill (`02-authoring-system/vscode-content-conventions.md`). Embedding the shortest entries inside another artifact instead (e.g. a response box in the instructional HTML) is a valid teacher option Jay left open for Stage 1 specifically, not a requirement.

Convention, extending `02-authoring-system/mvp-unit-folder-structure.md` (which this section also updates. See that file's folder tree and naming table):

| What | Convention |
|---|---|
| Journal prompt (student-facing) | `lesson_XX_YY/journal/unit_XX_journal_prompt.html` — nested in whichever lesson the entry is thematically about, not a unit-level folder (revised 2026-08-04, see `mvp-unit-folder-structure.md`'s "All Lesson Content Lives in the Lesson Folder" section) |
| Student's submitted entry | `lesson_XX_YY/journal/{codename}_unit_XX_journal.txt` |

This is a **unit-level** artifact, alongside the Unit Project, even though it physically lives inside one specific lesson's folder. Not a per-lesson artifact, matching the existing "avoid busy work" cap already in place for practice items and mastery checks ([[project-foxcs-practice-philosophy]] in memory). One entry per unit, 21 for the year, is the whole design. No additional journal cadence should be added without revisiting this section first. When authoring a future unit, place its journal inside whichever lesson's folder the prompt is actually about (e.g. Unit 01's IPO-themed journal lives in `lesson_01_02_input_process_output/`) — not always the last lesson, and not a separate top-level folder.

### Game Maker's Toolkit (GMTK) Video Analysis

Folds in an existing practice, not a new one: Jay already watches Game Maker's Toolkit videos with the class and has students reflect afterward. That reflection is a natural fit for this same journal thread rather than a separate activity. Same file, same word-count-for-that-stage, just with "respond to the video" swapped in for "respond to the prompt" on the units where a video is used.

**Not filled in here on purpose:** exact episode titles and links aren't listed below. Pick real, verified episodes yourself (or hand them to me by title/URL and I'll slot them in) rather than have anything guessed at here. What's mapped is *where a GMTK episode would land well against this course's own progression*, by topic, so picking episodes is a matter of matching topic to slot:

| Unit | Why a GMTK episode fits here |
|---|---|
| 00 | A general "what makes a game good" / design-fundamentals episode, watched before students write their very first MDA journal entry. Primes the vocabulary before they use it. |
| 05 | An episode on player choice, decision-making, or difficulty. Pairs with the if/else-as-Mechanic journal prompt. |
| 06 | An episode touching on game feel, feedback loops, or the moment-to-moment "game loop". Pairs with the loops-as-game-loop prompt. |
| 11 | An episode on randomness, luck, or procedural generation. Direct pairing with the Game of Chance project and MDA-of-randomness prompt. |
| 14 | An episode on accessibility, difficulty/fairness, or forgiving design. Direct pairing with the usability/error-handling journal prompt, likely the strongest single tie-in of the year. |
| 19 | An episode on game systems, enemy design, or boss design. Pairs with the class-design-as-Mechanic-design prompt. |
| 20 | Optional, teacher's call. A capstone-appropriate episode (postmortems, "what makes a game finish well") ahead of the final design-document journal entry. |

Whether this becomes required (baked into the journal prompt itself) or stays an optional in-class enrichment Jay adds at his discretion isn't settled. Treat it as the latter until stated otherwise, since it depends on Jay's actual class time, not just content design.

### Not Yet Decided

- Exact points/XP value per journal entry (grading *criteria* are now confirmed above; the point value isn't).
- Which specific GMTK episodes get used where (see table above). Needs real titles/links from Jay, not invented here.
- Whether Game II/Web II eventually get their own version of this thread. Plausible given they're also "Game" courses, but this pass was scoped to Python only; don't assume it carries over without being asked.
- Which AI-detection method/tool the grader will actually use for the authenticity check. See `../../01-privacy-and-governance/academic-integrity-ai-use.md` and `../../open-questions.md`.
