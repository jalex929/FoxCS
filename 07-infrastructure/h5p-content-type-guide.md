# H5P Content Type Guide

What's actually installed on the dev Moodle instance, and when to reach for which one. Built 2026-08-29 after enough trial-and-error building Unit 01 (most notably discovering `H5P.SortParagraphs` can't nest inside `H5P.Column` or `H5P.QuestionSet` even though it's installed and enabled) that it was worth writing down instead of re-discovering per unit. See `moodle-course-shells.md`'s "H5P pipeline proven" and "Instructional content split" sections for the full incident writeups this doc is distilled from.

## How content types get installed here

Nothing is available until `\core\task\h5p_get_content_types_task` runs (it's normally monthly cron; was triggered manually 2026-08-29). That pulls a curated set from the H5P Hub — 33 top-level types plus their dependencies, currently ~140 library records total in `mdl_h5p_libraries`. A `.h5p` package only needs `h5p.json` + `content/content.json` if every library it references is already installed here; it does **not** need to bundle library code itself (confirmed by reading `h5p.classes.php`'s validator directly, not assumed) — that's what makes hand-building packages with a small Python script practical instead of needing real H5P authoring tools.

## The hard-won rule: nesting is allowlisted per wrapper, not global

`H5P.Column` and `H5P.QuestionSet` each declare their own `semantics.json` list of exactly which sub-content types they accept. Being installed and enabled site-wide is **not** enough — if a type isn't on *that specific field's* options list, Moodle silently shows "library ... is not valid" instead of the content. Always check the wrapper's own semantics before assuming a type will nest. The two checked so far:

- **`H5P.Column` (1.22) accepts:** Accordion, Agamotto, Audio, AudioRecorder, Blanks, Chart, Collage, CoursePresentation, Dialogcards, DocumentationTool, DragQuestion, DragText, Essay, GuessTheAnswer, Table, AdvancedText, IFrameEmbed, Image, ImageHotspots, ImageHotspotQuestion, ImageSlider, InteractiveVideo, Link, MarkTheWords, MemoryGame, MultiChoice, Questionnaire, QuestionSet, Row, SingleChoiceSet, Summary, Timeline, TrueFalse, Video, MultiMediaChoice.
- **`H5P.QuestionSet` (1.21) accepts:** MultiChoice, DragQuestion, Blanks, MarkTheWords, DragText, TrueFalse, Essay, MultiMediaChoice. Narrower than Column — it's specifically a quiz wrapper, not a general content container.
- **Not accepted by either:** `SortParagraphs` — confirmed standalone-only. If a design calls for sequencing/reordering, it has to be its own separate `h5pactivity` module, not embedded in a reading.

## Another hard-won rule: a single-field `group` gets auto-flattened, silently

Found 2026-08-30 building the first `H5P.InteractiveBook` (see Python's `07-infrastructure/moodle-scripts/python/README.md`). `InteractiveBook`'s `chapters` list has a `field` of `type: "group"` with exactly one named sub-field (`chapter`, itself `type: "library"` accepting `H5P.Column`). The natural-looking JSON — each list item as `{"chapter": {library, params, subContentId, metadata}}`, matching the semantics' field name — is **wrong**, and Moodle gives no error for it. It just silently drops the entire `chapters` array during filtering (`mdl_h5p.filtered` ends up ~176 bytes, just the top-level `showCoverPage`/`behaviour` fields, no error message logged anywhere).

**Root cause, found by reading `h5p.classes.php`'s `validateGroup()` directly, not guessed:** a group with `count($semantics->fields) == 1` gets flattened — the validator applies the *single field's own* validator directly to the group's value, expecting the wrapper key to already be gone. So each `chapters` list item must be the **bare `H5P.Column` library object directly**, no `{"chapter": ...}` wrapper at all — same flat shape `H5P.QuestionSet`'s `questions` list already uses, just non-obvious here because `chapters`' semantics *look* like they want a named wrapper.

**General lesson:** when a `list`'s `field` is `type: "group"`, check `validateGroup()`'s flattening rule (single-field groups collapse; multi-field groups keep their key structure) before assuming the wrapper key from the semantics' field name belongs in the JSON. A silent, error-free content loss like this is easy to misread as "the package uploaded fine, so the content must be fine too" — verify actual chapter/section content survived filtering (grep the embed page for real content text, not just check for a validity-error string), don't just check for the absence of an error.

## What's actually built into Seminar III so far (proven working)

| Type | Used for | Notes |
|---|---|---|
| `H5P.AdvancedText` | Reading/prose blocks inside a Column | Just a `text` field with an HTML widget; the workhorse for anything that isn't a question |
| `H5P.Column` | A full instructional page: reading + embedded checks in one flowing scroll | Unit 01's Solving Problems / Error Types readings |
| `H5P.MultiChoice` | Single-answer questions with per-option feedback (`answers[].tipsAndFeedback.chosenFeedback`) | Used everywhere — Checks, inline reading checks, error-classification practice |
| `H5P.TrueFalse` | Binary questions with custom `correctAnswerMessage`/`wrongAnswerMessage` | One per reading so far; good for a single conceptual gut-check, not a full assessment |
| `H5P.QuestionSet` | Wraps several `MultiChoice` questions into one quiz with intro page, progress dots, retry, and a results screen | Every Unit 01 "Check" |
| `H5P.Image` | Diagrams — SVGs drawn locally then rasterized to PNG (`.svg` isn't in H5P's content-file whitelist, `.png` is) | The routine-flow and error-types diagrams |
| `H5P.Essay` | Free-text typed response with a "Show sample solution" reveal and light keyword-based scoring | Guided/Independent Practice's open-ended five-question-routine problems |
| `H5P.SortParagraphs` | Drag-to-reorder a list of text items into the correct sequence | The three Unit 01 sequencing exercises — always standalone, never nested |

## Worth exploring for later units (installed, not yet used)

Organized by what they're actually good for, not just what exists — the full ~140-record library list is in `mdl_h5p_libraries` if something more exotic is ever needed.

**More question types, same QuestionSet/Column-compatible family:**
- `H5P.Blanks` (Fill in the Blanks) — type a missing word/number directly into a sentence, auto-checked. Good fit for short numeric answers where multiple-choice would give away too much (e.g. "6 + 3 × 4 = ___").
- `H5P.DragText` (Drag the Words) — drag words into blanks instead of typing. Same use case as Blanks, more kinesthetic.
- `H5P.MarkTheWords` — click to highlight the correct word(s) in a passage. Could fit "identify the operation keyword" or ELA close-reading tasks once those units exist.
- `H5P.DragQuestion` (Drag and Drop) — position items onto a background/dropzones. Better fit for spatial/categorization tasks (e.g. sorting error types into labeled bins) than SortParagraphs' pure linear-order use case.
- `H5P.SingleChoiceSet` — rapid single-choice cards, swipe-through pacing. A lighter-weight alternative to QuestionSet for a quick warm-up rather than a formal check.

**Presentation/long-form, alternatives to Column:**
- `H5P.CoursePresentation` — real slide deck with interactive elements per slide, its own navigation and a summary slide. Worth considering for content that's naturally slide-paced rather than scroll-paced — may be a better fit than Column for some readings, or could replace the teacher deck's role for a student-facing version.
- `H5P.InteractiveBook` — multi-chapter container, each chapter holding its own mix of content. Natural fit once a unit's reading is long enough to want a table-of-contents/chapter structure instead of one long scroll.
- `H5P.BranchingScenario` — choose-your-own-path, next content depends on the answer given. Interesting for postsecondary-pathway decision content (College Prep vs. Workforce Readiness units) where the whole point is "your path depends on your choices."

**Domain-specific, worth remembering when those units get built:**
- `H5P.Chart` — real data visualization (bar/pie). Data & Scientific Reasoning units.
- `H5P.ArithmeticQuiz` — auto-generates arithmetic drills on the fly. Could supplement Numbers & Operations retrieval practice without hand-authoring every problem.
- `H5P.StructureStrip` — a writing-scaffold tool (topic sentence / evidence / analysis style prompts). Reading/English units, especially the ACT English content.
- `H5P.Dialogcards` / `H5P.Flashcards` — front/back study cards. Vocabulary-heavy content (error-type names, ACT terminology) could use these as a study-mode supplement to the graded checks.
- `H5P.Summary` — click the correct statement among several distractors to build a running summary. A lighter comprehension-check format than full MultiChoice.
- `H5P.Accordion` — collapsible sections. Good fit for a glossary or FAQ-style reference page.
- `H5P.DocumentationTool` — structured multi-field form output. Could fit the postsecondary-planning application/goal-setting content (Unit 33+) better than a plain Essay box.

**Lower priority / niche** (installed as part of the Hub's default set, no obvious FoxCS use yet): `Crossword`, `FindTheWords`, `PersonalityQuiz`, `GuessTheAnswer`, `ImageSequencing`, `Cornell`, `GameMap`, `Questionnaire`, `KewArCode`, `ARScavenger`, `ThreeImage`, `Collage`, `Agamotto`, `ImageJuxtaposition`, `ImageSlider`, `AdventCalendar`. Not ruled out, just nothing in the current course design points at them yet.

## Before using a new type

1. Check the DB for its `semantics.json` (via its `contenthash` in `mdl_files` where `component='core_h5p'`, `filearea='libraries'`) to get the real field structure and defaults — don't guess from general H5P knowledge, versions and required fields drift.
2. If nesting it inside `Column` or `QuestionSet`, check that wrapper's own options list first (see above) — don't assume installed means compatible.
3. Build a one-question pilot, deploy it, and verify via an authenticated `curl` against the activity's embed page before committing to a full build — cheap to prove the pipeline works before investing in content.
