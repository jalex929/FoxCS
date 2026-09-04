---
lesson_id: lesson_02_01_variables_and_memory
unit_id: unit_02
lesson_number: "02.1"
title: Variables and Memory
dok_levels_covered: [1, 2, 3]
---

# 2.1 Variables and Memory

Sandbox prototype, built 2026-09-04 as the reference implementation for Unit 02's pilot lesson, under the 5-module structure settled the same day. See `../../../../decisions-log.md` and `../../../../worklog.md` for the full build history and open items. Deployed to the sandbox course (`sandbox-adaptive-demo`, course id 9), not any real course.

## Overview

Introduces variables as the mechanism a program uses to remember information while it runs, framed around game state (health, lives, score). Covers creating a variable, the naming rules Python enforces, changing a variable's value, and combining variables with literal text in `print()`. Sets up Units 2.2-2.6, which cover each data type (integers, floats, booleans, strings, type conversion) in real depth.

## Objectives

- Create a variable using an assignment statement with a value of the correct type.
- Apply Python's variable naming rules (start character, allowed characters, case sensitivity, reserved words, snake_case convention) to judge whether a name is valid.
- Reassign an existing variable to a new value and explain that the old value is not retained.
- Write a `print()` call that combines one or more variables with literal text, using commas.
- Recognize integer, string, and boolean values by how they are written (quotes or their absence).

## Prerequisites

- Unit 01 (`courses/python/content/unit_01_what_is_programming/`), specifically 01.4 Printing Output (`print()` syntax) and 01.6 Common Syntax Mistakes (spotting a broken line).

## Vocabulary

- variable
- assignment operator
- value
- snake_case
- reassignment

---

## Moodle Content (5-module structure, 2026-09-04)

### Instruction (`01_instruction.html`)

Single self-contained page, expandable jump-to-section menu, not a forced linear flow. Bundles:

- **Learn**: Creating a Variable, Naming Your Variables, Changing a Variable's Value, Printing Variables With Text, What Kind of Value? (light data-type intro, full treatment deferred to 2.2-2.6). One Game Connection card and one Usability Note card, both referenced later by Practice's Game Connection/UX items.
- **Key Terms**: 3 flip flashcards (variable, assignment operator, value) + 2 ungraded quick-checks.
- **Practice**: 4 real adaptive Reinforce/Core/Extend skill nodes (`creates_variable`, `variable_naming_rules`, `reassigns_variable`, `prints_variable_with_text`, pool size Core 1 / Reinforce 1 / Extend 1 each, per `objectives-and-skills-proficiency.md`), 2 spiral review items (pulled from Lesson 01.4 `uses_print` and Lesson 01.6 `diagnoses_syntax_error`), 1 Game Connection item, 1 Usability item. 16 items total, above the doc's "typical 8-15" ceiling but within its explicit "3-4 skills stays inside budget" allowance for a 4-node lesson.

**Real authoring decision, not previously settled:** `adaptive-practice-model.md` names 5 candidate topics for this lesson (creating variables, naming rules, reassignment, data types, printing with text). Data types is deliberately built as a lighter, ungraded guided-practice quick-check instead of a 5th full adaptive node, per that same doc's "DOK-1 pure recall belongs in guided practice, not a scored node" rule — full data-type mastery belongs to Units 2.2-2.6, not this lesson.

Completion/telemetry via `local_foxcstelemetry` (Option C), not the DOM-blob save-in-place model — that model assumed no live backend; one exists now. Completion fires once all 4 nodes resolve and both spiral items are attempted.

### Project (`02_project.html`)

"Character Status Tracker." Tiered (Required / Tier 1 +10 XP / Tier 2 +20 XP), 3-level escalating hints (nudge, then a concrete first step, then a commented shell with no actual code). Native Moodle Assignment, file-upload-only submission, restricted to `.py`. Rubric: `teacher-materials/rubric_project.md`.

### Coding Exercise

**Not built for this lesson.** Judgment call: the Project module already covers this lesson's applied coding task (writing a real program using all 4 skill nodes together). Per the settled cardinality rule ("only when a lesson actually has one"), a second, separate Coding Exercise would be redundant with Project rather than a genuinely distinct task.

### Mastery Check

4 items (FoxCS default 3-5), native Moodle Quiz, password-gated, 3 attempts averaged. All deterministic (2 shortanswer predict-output/fix-the-line, 1 multichoice naming judgment, 1 shortanswer predict-output), per `mastery-check-standards.md`'s preference for auto-gradable types over essay/manual grading. Each item targets more than one skill node (synthesis, not a verbatim repeat of a Practice item). Answer key: `teacher-materials/mastery_check_key.md`.

### Feedback

Native Moodle Feedback activity, same shape as Lessons 01.4-01.6 (Clarity/Difficulty/Interest rated items + follow-up textareas + a 5-term vocab self-check checklist using this lesson's own terms + 2 open reflection questions).

---

## VS Code Content

Not built for this prototype pass. The Project module's file-upload submission covers this lesson's applied coding work; a separate VS Code-side folder/file convention was not built since Moodle-native submission is the live model as of 2026-08-28/30 (see root `CLAUDE.md`).

## Grading

See `teacher-materials/rubric_project.md` for the Project rubric and `teacher-materials/mastery_check_key.md` for the Mastery Check key. XP: Project Tier 1 +10, Tier 2 +20 (on top of Tier 1). Mastery Check and Practice do not carry separate XP in this prototype; matches the pattern already live for Lessons 01.4-01.6.

## Next Steps

- Mastery Check password needs to be generated fresh (not reused from another lesson) if this ever moves beyond the sandbox.
- Deploy verification: see `../../../../worklog.md`'s matching 2026-09-04 entry for what was checked live (Playwright + direct DB query) vs. what still needs a real classroom test.
- Not yet decided: whether this lesson's Instruction page should also get the native-Lesson-branching mechanism some earlier Unit 01 lessons used, or whether every future lesson standardizes on this tabbed/client-side-ladder shape. This prototype assumes the latter, per the 2026-09-04 module-structure decision, but that decision was made before this lesson existed to test it against.
