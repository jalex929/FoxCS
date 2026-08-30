# FoxCS: Software Dev: Course Plan

**First draft, built 2026-08-30.** This is the newest and least source-material-backed course-plan in FoxCS — see `CLAUDE.md`'s Source Material section before treating anything here as locked. Where Python's course-plan.md cites exact GMetrix workbook exercises for every unit, this file mostly can't — no equivalent licensed Java curriculum exists in this repo yet. Tie-in lines below are marked **(no source — flagged)** wherever that's true, rather than inventing exercise numbers.

**Why this course-plan starts at "SD-01," not "Unit 22" or "Unit 01":** Software Dev is a continuation course, not a parallel same-day choice like Game II/Web Dev. Stages 1-3 of the pathway's real 5-stage progression (HTML+CSS, JavaScript, HTML5 Application Development) are `../web-dev/course-plan.md`'s Unit 01-21 content — a Software Dev student has already been through that course (or cleared its prerequisite threshold) before Unit SD-01 begins. Continuing Web Dev's own numbering (e.g. "Unit 22") would wrongly imply this is the same course picking up where Web Dev left off, rather than a genuinely separate course with its own enrollment and its own teacher-facing structure. A fresh SD-01 sequence keeps that distinction visible everywhere this plan is referenced.

**Unit count (16) is a first-pass estimate, not validated against a real calendar.** Split roughly in half: Stage 4 (Java Fundamentals, SD-01 to SD-08) and Stage 5 (Software Development, SD-09 to SD-16). This resolves the `.placeholder-flag` left in the Unit 0 pathway-choice page — that page can now cite "16 units" instead of leaving the comparison blank. Confirm with Jay once realistic enrollment/pacing is known (see `CLAUDE.md`'s Open Questions).

**Legend:** ⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final. Everything below is ⬜ — this is a skeleton, not authored content.

---

## Stage 4: Java Fundamentals

### Unit SD-01: Why a Second Language? / Java Setup & Syntax Basics
*Tie-in: (no source — flagged). Framing idea: after a full year in JavaScript/HTML5's loosely-typed, browser-run world, Java's compiled, statically-typed model is a deliberate contrast — the point of Stage 4 isn't "learn another language for its own sake," it's experiencing a genuinely different way programs get written and run, which is real preparation for software engineering broadly, not just Java specifically.*
- [ ] SD-01.1 Why Learn a Second Language
- [ ] SD-01.2 Installing Java / Setting Up a Java Project (IDE choice not yet decided — see Open Questions)
- [ ] SD-01.3 Compiling vs. Interpreting: What's Actually Different from Python/JS
- [ ] SD-01.4 Java Syntax Basics (statements, semicolons, blocks)
- [ ] SD-01.5 Your First Java Program

### Unit SD-02: Variables, Types & Operators in Java
*Tie-in: (no source — flagged). Java's static typing is a real conceptual shift from Python's variables (Unit 02 there) — worth an explicit compare/contrast back to that unit rather than teaching typing as if it's the student's first exposure to variables at all.*
- [ ] SD-02.1 Declaring Typed Variables
- [ ] SD-02.2 Primitive Types (int, double, boolean, char)
- [ ] SD-02.3 Type Casting
- [ ] SD-02.4 Operators in Java
- [ ] SD-02.5 Strings in Java (String class, not a primitive — worth flagging explicitly)

### Unit SD-03: Control Flow
*Tie-in: (no source — flagged). Largely transferable thinking from Python Unit 05-06 (branching, loops) — this unit's real content is Java's syntax for the same logic students already know, not new conceptual ground. Pacing should reflect that (faster than Units 05-06 originally took).*
- [ ] SD-03.1 If / Else If / Else in Java
- [ ] SD-03.2 Switch Statements (no direct Python equivalent — genuinely new)
- [ ] SD-03.3 While and For Loops in Java
- [ ] SD-03.4 Enhanced For-Each Loops

### Unit SD-04: Methods & Parameters
*Tie-in: (no source — flagged). Java requires explicit return types and parameter types on every method — connect back to Python Unit 07 (Functions) as "the same idea, now with the type information written out loud instead of implied."*
- [ ] SD-04.1 Defining Methods with Typed Parameters and Return Types
- [ ] SD-04.2 Method Overloading (new concept, no Python equivalent)
- [ ] SD-04.3 Static vs. Instance Methods (light introduction — full depth waits for SD-06's OOP unit)

### Unit SD-05: Arrays & Collections
*Tie-in: (no source — flagged).*
- [ ] SD-05.1 Arrays: Fixed-Size, Typed Lists
- [ ] SD-05.2 Multi-Dimensional Arrays
- [ ] SD-05.3 ArrayList and the Collections Framework
- [ ] SD-05.4 Iterating Collections

### Unit SD-06: Object-Oriented Programming I — Classes & Objects
*Tie-in: (no source — flagged). This is arguably the real point of the whole Java stage: Python doesn't force OOP the way Java does. First genuine encounter with classes-as-blueprints for a lot of students, even ones who've been coding all year.*
- [ ] SD-06.1 Why Object-Oriented Programming
- [ ] SD-06.2 Defining a Class (fields, constructors)
- [ ] SD-06.3 Creating and Using Objects
- [ ] SD-06.4 Encapsulation (private fields, getters/setters)

### Unit SD-07: Object-Oriented Programming II — Inheritance & Polymorphism
*Tie-in: (no source — flagged).*
- [ ] SD-07.1 Inheritance (extends, superclass/subclass)
- [ ] SD-07.2 Overriding Methods
- [ ] SD-07.3 Polymorphism
- [ ] SD-07.4 Interfaces (introductory level)

### Unit SD-08: Java Checkpoint / Certification Prep Project
*Tie-in: (no source — flagged; this unit assumes an "IT Specialist – Java" checkpoint, which is unconfirmed — see `CLAUDE.md`'s Certification Framing.)*
- [ ] SD-08.1 Review: Java Concepts So Far
- [ ] SD-08 Project: Small Java Application (console-based, uses at least one custom class)
- [ ] SD-08 Certification Checkpoint (pending confirmation this exam exists/is the right target)

---

## Stage 5: Software Development

**Framing:** where Stage 4 is "learn a new language," Stage 5 is "learn what it means to build software as a discipline" — planning, structure, collaboration tooling, testing, and a real multi-file project, regardless of language. This is the stage that matches the pathway's own framing on the Unit 0 pathway-choice page: "more time on the 'why' behind the code... how software actually gets designed, built, tested, and maintained."

### Unit SD-09: What "Software Development" Means
- [ ] SD-09.1 Beyond Writing Code: The Software Development Lifecycle (SDLC)
- [ ] SD-09.2 Requirements: What Are We Actually Building?
- [ ] SD-09.3 Planning Before Building: Pseudocode and Flowcharts

### Unit SD-10: Software Design Principles
- [ ] SD-10.1 Breaking a Problem into Modules
- [ ] SD-10.2 Naming, Readability, and Code as Communication
- [ ] SD-10.3 An Introduction to Design Patterns (light — not a full patterns catalog)

### Unit SD-11: Version Control & Collaboration
- [ ] SD-11.1 Why Version Control (the problem it solves)
- [ ] SD-11.2 Git Basics: commit, branch, merge
- [ ] SD-11.3 GitHub: Pull Requests and Code Review Basics

### Unit SD-12: Testing & Debugging as a Discipline
- [ ] SD-12.1 Why Test Before Someone Else Finds the Bug
- [ ] SD-12.2 Writing Simple Unit Tests
- [ ] SD-12.3 Debugging Strategy (connect back to Python's Unit 00 "Troubleshooting Is Learning" content — same mindset, more formal tools)

### Unit SD-13: Working with Data & APIs
- [ ] SD-13.1 Reading/Writing Structured Data (JSON)
- [ ] SD-13.2 What an API Is and Why Software Talks to Other Software
- [ ] SD-13.3 Making a Simple API Request

### Unit SD-14: Software Architecture — Planning a Real Project
- [ ] SD-14.1 From One File to Many: Organizing a Real Codebase
- [ ] SD-14.2 Choosing a Project Idea and Scoping It Honestly
- [ ] SD-14.3 Writing a Project Plan/Spec Before Coding

### Unit SD-15: Capstone Project — Design & Build
- [ ] SD-15.1 Capstone Kickoff: Spec Review
- [ ] SD-15.2 Build Sprint 1
- [ ] SD-15.3 Build Sprint 2

### Unit SD-16: Capstone Project — Present & Reflect
- [ ] SD-16.1 Finishing and Polishing
- [ ] SD-16.2 Presenting Your Software
- [ ] SD-16 Project: Capstone Presentation + Reflection (journal-thread tie-in undecided — see `CLAUDE.md`'s Open Questions)

---

## Open Items Carried From `CLAUDE.md`

Do not treat as resolved just because units are listed above:

- No Java curriculum source exists — every "Tie-in" line above marked "(no source — flagged)" needs a real content source before authoring begins.
- IDE choice for Java (IntelliJ? VS Code + Java extension, matching the other courses' VS Code usage? Something else?) — not decided, affects SD-01.2.
- "IT Specialist – Java" as SD-08's certification target is an assumption, not a confirmed fact.
- Stage 5 has no certification mapping — SD-16's capstone may be the actual "credential" for this stage (a portfolio piece, not an exam), but that's not decided.
- Whether Stage 5's capstone (SD-15/SD-16) ties into Game I/Game II's Game/UX-and-journal thread, or Software Dev opts out of that thread entirely, is undecided.
