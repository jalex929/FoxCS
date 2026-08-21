# MVP Unit Folder Structure

**New 2026-08-04, replacing the Moodle side while it's paused** — see `../decisions-log.md`'s "Paused Moodle" entry and `../CLAUDE.md`'s Status section. This is the physical folder structure and naming convention for the MVP: one self-contained folder per unit, distributed to and submitted from Google Classroom, carrying the *same* instructional logic the Moodle plan was built around (DOK spread, the Reinforce/Core/Extend ladder, visible objectives) without a live engine behind it.

**This extends the existing schema, it doesn't replace it.** `lesson-schema.md`'s fields (`lesson_id`, `unit_id`, `objectives`, `skills`, `dok_levels_covered`) all carry forward unchanged — they were already surface-agnostic. What's missing is a folder-native home for what the `moodle:` block used to describe (video, H5P, guided practice, adaptive support routing, handoff instructions). See `lesson-schema.md`'s "MVP Delivery Mapping" note for exactly which `moodle:` field maps to which piece below.

**Reference implementation, current as of 2026-08-06:** `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/`. Read that folder directly alongside this doc — it's the ground truth this doc describes. The other 5 lessons in Unit 01 haven't been rebuilt to match yet (see `../decisions-log.md`'s 2026-08-06 entry); don't treat them as representative of the current pattern.

## Two folder copies — authoring source vs. distributed student copy

**Don't confuse these.** They're not the same folder:

- **Authoring source** (`courses/<course>/content/unit_XX_slug/...`, lives in this repo) — the student-facing content only. See below — answer keys don't belong here at all anymore, not even to be stripped later.
- **Teacher materials** (`courses/<course>/teacher-materials/unit_XX_slug/...`) — mastery-check answer keys and any other teacher-only content, kept in a completely separate tree from day one. **Corrected 2026-08-04→2026-08-06:** an earlier version of this doc described a single "authoring source has everything, a scripted export step produces the student copy." That was wrong in a way Jay caught directly: the `content/` tree *is* the student-facing folder, so answer keys must never be placed there in the first place, not placed-then-stripped. There is no export step for this reason anymore — `content/unit_XX_slug/` is always safe to hand a student as-is.
- **Distribution** is still a separate concern from either of the above — see "Distribution / Submission Mechanics" below.

## Folder Tree

**Flat, numbered files — no subfolders, revised 2026-08-06.** An earlier version of this structure used number-prefixed subfolders (`1_content/`, `2_examples/`, etc.). Jay simplified further: since each numbered step is usually just one file, subfolders added a click without adding clarity. Files now live directly in the lesson folder, numbered `01_`, `02_`, `03_`... in the exact order a student should do them, **contiguous per lesson with no gaps** — if a lesson has no example code, the next file simply takes the next number, it doesn't leave a hole at that slot. Numbers mean the same thing loosely (early = intro, late = wrap-up) but the *exact* step count varies per lesson depending on what that lesson actually needs — there's no fixed global slot-to-filetype mapping anymore.

```
unit_XX_slug/                                   e.g. unit_01_what_is_programming/
  unit_XX_overview.html                          Landing page: objectives, lesson list w/ real clickable links, project blurb
  lesson_XX_YY_slug/                             e.g. lesson_01_04_printing_output/ — reuses lesson_id verbatim, unchanged
    00_table_of_contents.html                    Real entry point and hub — every file in the lesson, one line each, with a "Check My
                                                   Progress" folder scan. See "Table of Contents" below.
    01_instruction.html                          Instructional content, baked in. Explicit Learning + Language "I can..." objectives (per
                                                   waypoint_curriculum_copywriting_guide.md Section 7-8), a numbered "What To Do Next" list with real
                                                   links, and a "Before You Submit" self-check where relevant.
    02_example_01.py                              Only for lessons with real code — the next file just takes 02 if there's no example.
    03_flashcards.html                            Click-to-flip term/definition deck, real CSS 3D flip animation, labeled Term/Definition faces.
                                                   Cards involving real syntax get a "Show Example" toggle. Pure throwaway practice — no save
                                                   mechanism, nothing submitted. Vocabulary-confusion signal is collected later, in the feedback
                                                   form's open-ended question, not here — see "What Flashcards Don't Do" below.
    04_vocab_quiz.html                             Drag-to-match term/definition quiz, same terms as 03's flashcards. Shuffled slot order, save
                                                   disabled until all correct. Saves with a _completed filename suffix. This is where flashcard
                                                   study actually earns XP — see "Vocab Quiz" below.
    05_practice.html                                Duolingo-style drills: click-to-build code-block exercises, dropdown fill-in-the-blank, typed
                                                   fill-in-the-blank. Auto-checked, plain JS, no libraries. Also disposable — nothing saved, since
                                                   these are repetition, not evidence.
    06_practice.py                                  The real hands-on code-writing practice, saved normally in VS Code (Ctrl+S). This is where actual
                                                   typing/writing practice belongs — the drills above build recognition, this builds production.
    07_project.html                                 The applied/application task. Has a tiered checklist: Required (must-complete) + Tier 1/Tier 2
                                                   bonus items worth escalating XP — see "Tiered Project XP" below. Bigger applications can span
                                                   multiple numbered .py files instead of one.
    08_project.py                                   Where the student writes the project. Fixed filename, no renaming (see "No Self-Naming" below).
    09_mastery_check.html                           Password-gated prompt sheet. Plain, readable questions once unlocked — no answer inputs on this
                                                   page anymore (see "Mastery Checks" below). Unlock/completion times save automatically as hidden
                                                   fields in this file's own source — nothing for the student to copy (corrected 2026-08-07).
    10_mastery_check.py                             Where the student's actual answers go — including code-writing answers, since "mastery checks
                                                   often involve things people need to code" (Jay). Comment-stubbed per question.
    11_feedback.html                                Quick per-lesson feedback: click 1-5 ratings, type short answers, click Save. Uses save-in-place
                                                   (see below). Question bank lives in feedback-collection.md.
  project/                                         Unit-level capstone only, not per-lesson — the one thing that doesn't belong inside a single
                                                   lesson folder, since it draws on the whole unit.
    unit_XX_project_instructions.html
    unit_XX_project.py
  supplemental/
    GMETRIX-<original-name>                       GMetrix-derived reference material — GMETRIX- prefix unchanged, see vscode-content-conventions.md
    <descriptive-name>.<ext>                      FoxCS-original supplemental material — no special prefix needed
```

**The journal** (where a unit has one) is a numbered file inside whichever lesson's folder it's thematically about, same rule as everything else — e.g. Unit 01's journal (about Input-Process-Output) lives inside `lesson_01_02_input_process_output/` as one of that lesson's numbered files, not in a separate unit-level folder. One entry per **unit**, not per lesson — see `../../courses/python/course-plan.md`'s "Game Design, UX, and Journal Threads" section for why. It's a single plain `.txt` file with the prompt, rubric, and academic-integrity notice written directly at the top, ending in a "write below this line" marker.

## Part Numbering ("1.4.N")

**Added 2026-08-11 per Jay.** Every numbered file also gets a precise `Unit.Lesson.Part` citation label — e.g. `1.4.5` always means Lesson 01.4's Practice page — so any part of a lesson can be referenced exactly, in conversation or in review notes, without needing the filename. This is a **citation label layered on top of the existing `00`-`11` filename convention, not a replacement for it.** Filenames, folder names, and hrefs are all unchanged — only the student/reviewer-facing label (title tag, H1 or header comment, and the table of contents' badges) changes.

- Each conceptual step gets the next integer, **except** a paired HTML+PY step that's really one conceptual step (student-facing instructions + the file they actually write in) — those share one part number with an **`a`/`b` suffix** instead of each taking its own integer: `1.4.7a` (project instructions) / `1.4.7b` (project code), `1.4.8a` (mastery check prompts) / `1.4.8b` (mastery check answers).
- Reference mapping for Lesson 01.4: `1.4.1` instruction, `1.4.2` example, `1.4.3` flashcards, `1.4.4` vocab quiz, `1.4.5` practice, `1.4.6` application, `1.4.7a`/`1.4.7b` project, `1.4.8a`/`1.4.8b` mastery check, `1.4.9` feedback. `00_table_of_contents.html` itself stays at the lesson level (`1.4`, no part digit) since it's the hub, not a numbered part.
- **Every resource also names its own type directly on the page** — not just the number. Each page's `<h1>` (or, for `.py` files, its header comment) reads `N.N.N — Type: Subtitle` (e.g. `1.4.5 — Practice`, `1.4.7a — Project Instructions: Status Message Board`); `00_table_of_contents.html` shows the same type as a small `.toc-type` chip next to each filename. A bare number without a type label isn't enough — per Jay, "the resource itself should be labeled on the page."
- Apply this to every future lesson, not just 01.4 — the part number always restarts at `1` for each new lesson (`1.5.1`, `1.5.2`, ... for Lesson 01.5, etc.), it's lesson-scoped, not unit- or course-scoped.

## Table of Contents

**Added 2026-08-11 per Jay.** Every lesson gets a `00_table_of_contents.html` as its real entry point, replacing a pure linear "Next: →" chain as the only way to move around. It lists every numbered file with a one-line description and a direct link, so a student (or Jay, reviewing) can jump to any step or see the shape of the whole lesson before starting, rather than only ever being able to go forward one page at a time.

**"Check My Progress"** uses the File System Access API's `showDirectoryPicker()` — same API family as the `showSaveFilePicker()` used for save-in-place elsewhere in this lesson — to let a student point at their own copy of the lesson folder. It then checks, read-only, for the presence of specific `_completed`-suffixed filenames and marks those steps done. It never opens or modifies a file, only checks whether a given filename exists in the folder. A light sanity check (confirming `01_instruction.html` is present) guards against a student picking the wrong folder and seeing everything falsely reported as "not yet."

**This only works for files with a save-in-place mechanism that renames itself on save.** `04_vocab_quiz.html`, `05_practice.html`, `09_mastery_check.html`, and `11_feedback.html` all save with a `_completed` suffix (e.g. `04_vocab_quiz.html` → `04_vocab_quiz_completed.html`) specifically so this scan can detect them — see "Vocab Quiz" below for where that convention started. **Most `.py` files (`02_example_01.py`, `06_application.py`, `08_project.py`) can't be included** — they're saved directly in VS Code (Ctrl+S) with a fixed filename, and per "No Self-Naming" below, there's no mechanism available to rename them on save the way a browser page can rename itself. The table of contents shows those rows as not auto-trackable rather than faking a signal from something indirect like file size or edit time, which could easily be wrong.

**`10_mastery_check.py` is the one deliberate exception, added 2026-08-20 per Jay.** `09_mastery_check.html`'s own instructions now tell the student to do a one-time manual "Save As" to `10_mastery_check_completed.py` once they've answered all four questions — a real, narrow exception to "No Self-Naming," not a reopening of it generally (see that section below for why the other `.py` files stay excluded). This works specifically because a mastery check has a genuine, single "I'm done" moment the same way the HTML pages do; `application.py`/`project.py` don't have an equivalent natural completion point, so they're unaffected. `00_table_of_contents.html`'s `COMPLETED_TARGETS` includes this filename the same way it does the `_completed.html` files. `05-grader/school-side/auto_grade.py`'s needs-review pattern was updated from `mastery_check\.py$` to `mastery_check(_completed)?\.py$` so it still flags the file for review under its new name (verified: the un-updated pattern silently stopped matching, which would have made a *completed* mastery check invisible to the needs-review manifest while an *unfinished* one still got flagged — the wrong way around). Separately, the same rebuild also found and fixed a real timestamp-parsing bug unrelated to this rename (see that script's own header/tests).

**Footer nav, every numbered page:** added the same day, alongside the table of contents. Every numbered HTML page's footer anticipates three places a student might need to go, not just "Next": back to the previous page, back to the table of contents, or forward. See `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/`'s numbered files for the reference `.page-nav` / `.page-nav-links` pattern (a `.page-nav-prev` / `.page-nav-toc` / `.page-nav-next` row). On a password-gated page like a mastery check, the nav footer lives outside the locked content block, since a student should be able to navigate away without needing the password first.

## No Self-Naming

Students never rename files or add a codename to a filename. Every file has a fixed, predictable name; students edit and save the file they're given. The whole lesson folder goes to Google Classroom exactly as provided, already tied to the student's real Classroom identity — Jay's codename-swap script (`../01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section) does the renaming and real-name stripping *after* collection, before anything reaches `05-grader/` or Claude Code. Don't reintroduce codename-based filenames or a naming-compliance rubric line in future units.

## Provide an Editable File, Not a Blank Page

Wherever a student needs to write something, give them a real file already in the folder with the prompt/rubric/instructions built into it as text, ready to open and edit directly — don't show a read-only instructions page and expect them to separately create a new file. The journal and mastery-check answer file both follow this: everything they need is already there, they write, they save.

## Mastery Checks

**Redesigned 2026-08-06 — see `../decisions-log.md`'s entry of that date for the full reasoning, including what was tried and dropped along the way.**

- `NN_mastery_check.html` is a **password-gated prompt sheet only**. Once unlocked, the questions are plain, readable text — there's no answer content to protect on this page anymore, so the earlier base64-obfuscation mechanism (from the 2026-08-04 design) no longer applies; there's nothing left to obfuscate.
- The student's actual answers — including code they write or fix — go in a paired `NN_mastery_check.py` (or `.txt` for a lesson with no code yet), comment-stubbed per question, saved normally in VS Code. This is deliberate: mastery checks frequently involve writing or fixing real code, and a real code editor is a better place for that than a browser textarea. See `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/09_mastery_check.py` for the pattern.
- **Password gate is not real security.** It's a client-side JS check, fully visible to anyone who views the page source — a determined student can bypass it trivially. Its actual purpose is pacing: Jay controls when a group can start by giving out the password verbally or via an announcement, the same way a paper quiz might be handed out at a specific moment.
- **Multi-variant** still applies where it's worth the authoring effort: a mastery check can ship as 2-5 parallel versions, each behind its own password, each with different surface details (scenario nouns, numbers) but identical underlying objectives and DOK level — lets Jay release different versions on different days/sections and cross-check a submission's variant against when that student's section actually had the password. Passwords are **6-character alphanumeric**, matching the format of real certification exam codes students will see later. Building multiple variants for every lesson is real additional authoring work — don't assume it's done for a lesson unless its teacher-materials key says so.
- **Open/timing signal — redesigned 2026-08-07.** Students used to copy a visible unlock timestamp into their answer file by hand; Jay flagged that as a mistake in the original design (easy to get wrong, one more thing to remember). Now the mastery-check HTML page writes its own `unlocked_at` time automatically the moment the password is entered, and a `completed_at` time when the student clicks "Mark Complete & Save" (reusing the same `showSaveFilePicker` save-in-place mechanism as the feedback form and vocab quiz) — both as hidden, visually-hidden-but-DOM-present fields (not literal white-on-white text, since color-matched text can still be selected or picked up by accessibility tools) saved inside the page's own HTML source for the grader to read. Still a lightweight, non-tamper-proof signal — a determined student could edit dev tools before saving — but far more reliable than hand-copying a time, and nothing visible cluttering the page. Reference: `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/09_mastery_check.html`; prototype: `component-library/index.html`'s #12.
- Every mastery check ships with placeholder password(s) marked `CHANGE ME` in a code comment — change before distributing, and again to re-lock for a new attempt or section.

## Assessment Tiers by Program Shape (noted 2026-08-20, not yet built)

Per Jay, a real design distinction to carry into future authoring, grounded in the actual Certiport Python Next Gen exam format (not invented): that exam gives students a coding lab where they switch between roughly **7 separate, mostly unrelated files**, completing a discrete task in each — real exam-taking comfort with that structure (navigating between many small, independent files under time pressure) is itself a skill worth deliberately building, not just the underlying Python content.

That maps onto three distinct program shapes across FoxCS's own assessment types, not one shape reused everywhere:

- **Mastery Check** — one cohesive program (or a small handful of closely-related questions inside one program). Already the built pattern — see "Mastery Checks" above.
- **[Name TBD, tentatively "Unit Test" per Jay's own phrasing] — a short set of 4-7 small, genuinely independent programs**, mirroring the exam's own multi-file-lab structure. **Naming collision to resolve before this gets built**: `course-plan.md`'s Lesson 15.6 ("Introduction to Unit Testing," GMetrix Domain 5) already uses "Unit Testing" for the real CS concept (`assert`, `try`/`except`, etc.) — reusing that exact term for this different, assessment-format meaning would collide with real content students will hit later in the year. Needs a different name (e.g. "Skills Check," "Lab Set," "Multi-File Check") before it's built into any file-naming convention, teacher-materials key, or `lesson-schema.md` — not decided here, flagged in `open-questions.md`.
- **Project** — one larger program (already the built pattern — see "Tiered Project XP" below).

Not yet scoped: which units get this new tier, how many per course, exact file-naming convention for 4-7 small `.py` files in one folder (likely `NN_[tier]_01.py` through `NN_[tier]_07.py` or similar, TBD), and how — if at all — `05-grader/school-side/auto_grade.py`'s needs-review matching should recognize the new file group. Recorded here so it isn't lost before a real scoping pass, not something to build speculatively ahead of that pass.

## Tiered Project XP

Added 2026-08-06. The project/application step's instructions page includes a checklist split into a **Required** tier (must-complete to pass) and escalating bonus tiers (Tier 1, Tier 2, ...) worth increasing XP, extending the existing `xp:` block in `lesson-schema.md`. See `06_project.html` in the reference implementation for the pattern — background-colored boxes per tier, clearly labeled. Bigger applications can span multiple numbered `.py` files instead of one, if the task genuinely needs it.

## What Flashcards Don't Do (and why)

Flashcards are pure throwaway practice: flip, read, move on. No save mechanism, no ratings, no filesystem writes. **A per-term self-assessment feature (rate each term "I know this" / "still learning," saved for later review) was built and then deliberately removed on 2026-08-06** — see `../decisions-log.md`. Don't re-add saving/rating to flashcards without a real reason to revisit that call.

## Vocab Quiz (added 2026-08-06)

This is where flashcard-study effort actually earns XP — not the flashcards themselves. `NN_vocab_quiz.html`, placed right after the flashcards file, is a drag-and-drop (with click-to-place as a fallback) term-to-definition matching quiz:

- Term bank and definition-slot order are **shuffled independently** so position can't be memorized as a shortcut.
- **Redesigned 2026-08-11 per Jay: placement is tentative, grading is explicit.** Dragging or clicking a term into a slot no longer grades that pair immediately — it's a provisional placement (neutral styling) until the student clicks **Check Answers**, which grades everything placed so far at once. Correct pairs lock in green; wrong pairs bounce back to the bank with a shake, no shaming language, and stay retryable. This matches "it's a quiz — check it for feedback first" rather than auto-grading on drop, and it's what makes each Check click a real, loggable attempt rather than only ever seeing a final all-correct state. Brute-forcing by trying every combination is still an accepted tradeoff, same as before.
- **Attempts are logged, not just the end state.** A hidden per-page telemetry log (same mechanism as `05_practice.html`'s) records every Check click: attempt number, and exactly what was placed in each slot and whether it was right, not just whether the quiz eventually got finished. This is what lets Jay see how many tries a term-matching took and what the wrong attempts actually were.
- **Save requires both a full match and a completed reflection.** Previously save unlocked at 5/5 matched with no reflection requirement; now the reflection textarea (see below) also has to have real content before Save enables. A reflection asking "what memory trick did you use, if any" gates on non-empty text, not on being "good" — "I didn't need one" is a valid answer.
- On save, the filename gets a **`_completed`** suffix (e.g. `04_vocab_quiz.html` → `04_vocab_quiz_completed.html`), so it's visible at a glance in a folder listing whether a student actually finished it, without opening the file. **This convention has since spread to every other saved page in the lesson** (`05_practice.html`, `09_mastery_check.html`, `11_feedback.html`) specifically so `00_table_of_contents.html`'s folder scan can detect completion across the whole lesson, not just here — see "Table of Contents" above.
- Reopening an already-completed file shows the finished state immediately (a `data-completed` flag baked into the saved HTML) rather than resetting to a fresh, unsolved quiz.
- Extends `lesson-schema.md`'s `xp:` block with a `vocab_quiz` value.
- **Reflection answers are a capture target for the future grader, not yet built.** Jay wants `05-grader/` to eventually extract themes from these reflection answers and build a quick-reference of effective memory tricks students came up with, some of which he may want to share with the whole class. Not built — flagged here as a real future requirement, not a hypothetical one, so it isn't lost. See `05-grader/README.md`.

See `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/04_vocab_quiz.html` for the reference implementation (5 terms, matching the same 5 flashcards in that lesson's `03_flashcards.html` — keep the term/definition pairs identical between a lesson's flashcards and its vocab quiz, don't let them drift).

## Component Library

**Added 2026-08-06 — start here before building any new interactive piece.** `02-authoring-system/component-library/index.html` is a real, self-contained HTML page — open it directly in a browser — cataloging every interactive pattern FoxCS has, each with a working, clickable demo using deliberately generic, non-curriculum content (fruits, sandwich-making steps) so nothing on that page is ever mistaken for real lesson material. Each entry names its status (live in a real lesson / demoed here first, not yet deployed / pattern documented, nothing deployed) and links to the real reference implementation where one exists.

This exists because an earlier attempt embedded a placeholder video directly into real lesson content (`01_instruction.html`) — Jay caught that this was fabricating content rather than proving a mechanic, and it was then confirmed the hard way: clicking the placeholder produced a real YouTube Error 153 ("invalid video player configuration"). The fix: prove a mechanic in the component library first, using content that can never be confused for something real, then deploy it into an actual lesson only once it's genuinely ready.

### Interactive Drill Types (running list)

All live inside a lesson's Practice page (`NN_practice.html`, student-facing label "Practice" — not "Practice Drills" or "Guided Practice," see `adaptive-practice-model.md`'s naming note) unless noted. See the component library for a demo of every type, and `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/05_practice.html` for the ones already deployed in real content:

| Type | What it tests | Status |
|---|---|---|
| Block builder | Assemble one line of code in the correct token order | Live — `05_practice.html` Drills 1 & 5 |
| Dropdown fill-in-blank | Pick the correct option from a constrained set | Live — `05_practice.html` Drill 2 |
| Typed fill-in-blank | Recall a specific word with no options given | Live — `05_practice.html` Drills 3 & 4 |
| Combined blank | One dropdown + one typed blank in the same passage | Live — `05_practice.html` Drill 6 |
| Matching (drag term → definition) | Vocabulary recall, shuffled both sides | Live — `04_vocab_quiz.html`, gated on 100% + XP |
| Multi-line block builder, indentation-aware | Structural/sequencing understanding across more than one line | Live — `05_practice.html` Drill 7 (bonus/preview only — see below) |
| **Categorization** (drag items into labeled bins) | Sorting instances into the right category | Demoed in the component library only — good fit for 01.2 (Input/Process/Output) and 01.6 (SyntaxError vs. NameError), not yet built into either |
| **Sequencing** (reorder already-formed lines) | Recognizing that order changes meaning/output | Demoed in the component library only — good fit for 01.3 (the lesson is literally about execution order), not yet built in |

**Practice is moving from a flat drill list to small adaptive skill nodes — see `adaptive-practice-model.md`.** Added 2026-08-11: reverses part of the 2026-08-06 flat-list decision, but reuses the Reinforce/Core/Extend ladder already specified in `objectives-and-skills-proficiency.md` and the telemetry schema already specified in `telemetry-and-analytics.md`, run client-side in the practice page's own JS instead of Moodle's Lesson activity. Design only as of 2026-08-11 — `05_practice.html` hasn't been rebuilt to this shape yet.

**Indentation-aware content is bonus/preview only in Unit 01.** `if`/loops/functions aren't taught until Units 05-07, so Drill 7 is explicitly labeled a "Sneak Peek," not core graded content — don't build indentation into a Unit 01 mastery check or project. The multi-line-row-with-independent-token-banks mechanic it uses is meant to be reused for real once those later units need it.

**Multi-line block builder layout fixed 2026-08-10 per Jay**: all target line rows now render together first, empty, so a student sees the full shape of what they're building (including the indentation relationship between lines) before touching any blocks. The token banks moved below both lines instead of interleaving one line's bank between it and the next line's target — see `component-library/index.html` component #3 and `05_practice.html` Drill 7 for the corrected pattern. Applies to any future multi-line block builder, not just this one.

**Future enhancement, not yet built (noted 2026-08-10 per Jay):** eventually, block builder banks (single-line and multi-line) should be overprovisioned with a few extra pieces the student doesn't need — real distractors, not just the correct set in shuffled order — and some blanks should require typing instead of only dragging a pre-made block into place. Both raise the difficulty/diagnostic value above pure reordering. Not scoped or built yet; flagged here so it isn't lost.

### Embedded Video

**Pattern documented in the component library, not deployed anywhere.** No real video content exists yet — see the incident above. When one does, use `youtube-nocookie.com` (YouTube's privacy-reduced embed domain, fewer tracking cookies than `youtube.com/embed`) as the default, consistent with FoxCS's existing privacy stance. The responsive-aspect-ratio wrapper (`position:relative` + `padding-top:56.25%`, keeps 16:9 at any width) is proven and ready to reuse. Native player controls should stay visible by default — never suppress them. **Never invent or guess a real video ID/URL** — the component library's demo intentionally contains no iframe and no URL at all, only the container and a `{{REAL_VIDEO_ID}}` template snippet, specifically to avoid repeating the Error 153 mistake.

## Feedback

`NN_feedback.html` is the last numbered file in a lesson. Click-based 1-5 scale ratings plus a few open-ended text questions, drawn from `feedback-collection.md`'s question bank. Uses the same save-in-place mechanism as mastery-check code files use VS Code's Ctrl+S — click through the form, click "Save My Feedback," done. **Explicitly not a copy-paste-into-another-file workflow** — Jay rejected that design directly ("I do not want them to fill it out in one place, copy it to another, and turn it in a complex way"). Also explicitly not a Google Form/Sheet pipeline or a Google Sites–hosted page — both were considered and set aside because they'd add a location to pull data from, not reduce the number of places, which was the actual goal.

## Save-in-Place

Used by feedback forms and (where a lesson wants it) flashcard/practice interactivity that needs to persist something — anywhere a browser page needs to write structured input (ratings, short answers) back to its own file. **Not used for mastery-check or project code answers anymore** — those are plain files saved via VS Code, per "Mastery Checks" above.

Mechanism: the File System Access API (`showSaveFilePicker`) where available (Chrome/Edge, including ChromeOS — covers most school Chromebooks). The first save in a session asks the student to pick the file once (suggesting its own current name, so re-selecting it overwrites); the browser remembers that handle afterward, so every later save that session is silent, no dialog. Falls back to a classic download for browsers without the API. **Not yet tested on real school devices, especially over `file://` rather than http(s)** — see `05-grader/README.md`'s Testing Needs.

The Chrome permission prompt this triggers ("This site can see changes you make") is expected — it's the browser confirming a page is about to write to disk, exactly what's supposed to happen. Not an error.

## Scrappy Means Delivery Mechanism, Not Content Quality

This folder layout needs to repeat cleanly across 4 courses (see `open-questions.md`), not be bespoke per unit — don't add files beyond what a lesson genuinely needs, and resist the urge to add polish before the format is proven. That's the only thing "scrappy" describes. The instructional content, drills, project tasks, and mastery-check questions should be full-quality, same rigor as if this were going into Moodle.

## Distribution / Submission Mechanics

- Jay posts the unit folder as a Google Classroom assignment — likely zipped, or a shared read-access Drive folder students copy into their own space.
- Students do their work inside their own copy, using the files exactly as provided (no renaming — see "No Self-Naming").
- Students submit the **entire folder** back through Classroom — not individual files pulled out of it (already the rule in `01-privacy-and-governance/codename-policy.md`).
- Jay downloads submissions, runs the codename-swap-on-download script (not yet built — see `open-questions.md`) to strip real names and assign codenames, then grades / analyzes with Claude Code.

## Open items this doc doesn't resolve

- The instructional HTML's actual visual template (layout, illustration placement) is blocked on Jay's forthcoming updated image-style-guide reference — see `image-style-guide.md`, `../open-questions.md`.
- The codename-swap-on-download script isn't built yet.
- Whether the drills/tiered-XP/redesigned-mastery-check/feedback-form pattern from Lesson 01.4 gets rolled out to the rest of Unit 01 — not yet done, see `../decisions-log.md`'s 2026-08-06 entry.
- Whether/how a lesson with multiple exercise files for its application step (mentioned as a real possibility, not yet built) should be numbered — likely `07_project_01.py`, `08_project_02.py`, etc., but not tested against a real multi-file case yet.
