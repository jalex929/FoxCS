# Unit 01 Content Inventory & Gap Analysis: "What Is Programming?"

**Status note, 2026-08-30: the gaps this doc identifies (mastery checks, the Interactive Greeting project, 01.2/01.5's TSV practice) have all since been built into real FoxCS lesson content** — see `../../decisions-log.md`'s 2026-08-30 entry and `../../02-authoring-system/mvp-unit-folder-structure.md`. Kept below as a historical record of what `adaptive-python`'s source material offered for sampling, still useful if a future unit needs the same kind of source-material audit, but don't treat "What to prioritize next" as current.

What already exists in `adaptive-python` for Unit 01, checked against the lesson's actual Programming/Computational-Thinking/Language objectives (`Curriculum_Python Fundamentals.md`), and what's genuinely missing. Read directly from the source files (`python-app/curriculum/`), not inferred from filenames — see `02-authoring-system/moodle-quick-pilot-workflow.md` for how to pull from these into Moodle.

## Per-lesson status

| Lesson | Practice questions (`.tsv`) | JSON draft bank | Mastery check | Notes |
|---|---|---|---|---|
| 01.1 What Programs Do | ✅ 11 questions, published | ✅ 22 questions | ❌ empty (header only) | Purely conceptual, no code — thermostat/vending-machine/ATM scenarios |
| 01.2 Input-Process-Output | ❌ file doesn't exist | ✅ 22 questions | ❌ file doesn't exist | Only the JSON draft bank exists for this lesson at all |
| 01.3 Writing Your First Program | ✅ 24 questions, published | ✅ present | ❌ empty (header only) | First lesson with real Python syntax; includes a real `NameError` traceback-reading question |
| 01.4 Printing Output | ✅ 31 questions, published | ✅ present | ❌ empty (header only) | Richest lesson — also has a full exemplar teaching package (see below) |
| 01.5 Comments and Documentation | ❌ file doesn't exist | ✅ present | ❌ file doesn't exist | Only the JSON draft bank exists, same gap shape as 01.2 |
| 01.6 Common Syntax Mistakes | ✅ 16 questions, published | ❌ doesn't exist | ❌ empty (header only) | Only lesson missing a JSON bank; strong on multi-error debugging |
| Project: Interactive Greeting | — | — | — | `project_module_01.tsv` exists but has **zero data rows** — no project content at all |
| Unit-level mastery check | — | — | ❌ empty (header only) | `mastery_check_module_01.tsv` |

**The systemic gap, not a per-lesson one:** every single mastery-check file in this unit — all six lessons plus the unit-level one — exists as a file but has zero data rows. This isn't scattered; it's a complete, consistent absence across the whole unit. Prioritize this over sampling more practice questions, since practice content already exists in some form everywhere except 01.2/01.5's TSVs, but mastery checks exist *nowhere*.

## Bonus find: 01.4 has a full teaching-content exemplar

`curriculum/exemplar/lesson_01_04_printing_output/` isn't just questions — it's a complete authored lesson package: 8 objectives with mastery criteria, 14 real teaching content blocks (explanation, a Python-2-vs-3 callout, two misconception call-outs, guided practice, reflection, confidence check), 18 questions, and 12 multi-condition test cases. This is worth using as the template/reference for what a fully-authored FoxCS lesson record should contain, not just a question source — it's the most complete single lesson in the entire unit.

There's also a separate, differently-structured curriculum tree (`curriculum/generated/`, `curriculum/source/`) covering similar ground under different lesson IDs (e.g. `lesson_first_print_statement.json`, fully built out) — thematically useful for phrasing/scaffolding ideas, but not filed under Unit 01's actual lesson IDs, so don't treat it as "01.4 content" proper.

## Objective coverage — Language Objectives specifically

Language objectives (FoxCS's own addition, not something `adaptive-python` formally tracks as a tagged field) are still reasonably well covered *implicitly* — most lessons include `written_response` questions that require the student to use the exact target vocabulary in their own explanation (e.g. 01.1's "explain the recommendation feature using the terms input, process, and output," 01.2's barcode-scanner IPO breakdown). These are good candidates to explicitly re-tag as language-objective evidence when adapted into a FoxCS lesson record, rather than needing to be authored from scratch.

## What to prioritize next

1. **Mastery checks — genuinely missing everywhere, highest-priority gap.** Nothing to sample from `adaptive-python` here; these need to be authored new for FoxCS, informed by the objectives and the existing practice-question style.
2. **The Interactive Greeting project — completely empty, needs full authoring**, not adaptation. The unit's Programming/CT/Language objectives for the project (write a complete program with output + comments, debug simple mistakes, explain the program in beginner vocabulary) are already known; there's just no existing scenario/starter-code/success-criteria to draw from.
3. **01.2 and 01.5 have no TSV practice content**, only draft JSON — those JSON banks are the sampling source for those two specifically.
4. **Reflection questions** (per Jay's "eventually this will include reflection questions" note) aren't tracked as a distinct field anywhere in this content — they'd need to be authored fresh per FoxCS's `lesson-schema.md` reflection block, though the exemplar 01.4 package's "reflection" and "confidence check" content blocks are a reasonable model for tone/shape.
