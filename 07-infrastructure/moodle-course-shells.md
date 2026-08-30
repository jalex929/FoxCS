# Moodle: Course Category/Shell Setup (dev instance)

Built 2026-08-29 on the `foxcs-droplet` build/dev Moodle instance (see `moodle-vm-setup.md`). This is structure only — getting the 4 FoxCS courses ready to receive real content once NTC Hosting (the actual production host, see `decisions-log.md`'s 2026-08-29 entry) is live and the build here gets migrated over.

## What exists now

**One category:** `FoxCS` (idnumber `foxcs`).

**Four course shells**, all `topics` format, all in the `FoxCS` category:

| Shortname | Fullname | Sections | Section names |
|---|---|---|---|
| `foxcs-python` | FoxCS: Python (Game Programming I) | 21 | Renamed to the real Unit 00-20 titles from `courses/python/course-plan.md` |
| `foxcs-game2` | FoxCS: Game Programming II (Game II) | 1 | Default ("Topic 1") — no `course-plan.md` exists yet, see root `CLAUDE.md` |
| `foxcs-webdev` | FoxCS: Web Dev (Web II) | 1 | Default ("Topic 1") — no `course-plan.md` exists yet |
| `foxcs-seminar3` | FoxCS: Seminar III | 39 | Renamed to the Unit 00-38 titles from `courses/seminar-iii/01_SEMINAR_III_COURSE_PLAN`. Moodle **section number** stays 1-39 (section N = Unit (N-1)) — see the renumbering note below. |

**Seminar III also has real content uploaded** as File resources, one per unit section, sourced from what already exists in `courses/seminar-iii/`:

- Units 01-08: the teacher presentation deck (`teacher-materials/unit-NN-presentation.html`) — uploaded **hidden** (`visible=0`), so only teacher/manager roles can see it. These decks carry the presenter's speaker-note script; students should never see that, or the deck should be treated the same as anything gated by `01-privacy-and-governance` — kept out of student view by default rather than trusted to a "don't look" convention.
- Unit 04: `teacher-materials/unit-04-answer-keys.html` — also hidden, per the standing rule that answer keys never go in student-facing docs.
- Units 02, 03, 04, 06, 08: `instructional-content/*.html` — visible (student-facing).
- Units 02, 04, 06, 08: `printable-sheets/*.html` — visible (student-facing). Unit 06 only has a quick-reference sheet uploaded; the other 3 printable-sheet types don't exist yet for that unit.
- Unit 05, 07: **deck only** — no instructional-content or printable-sheets exist in the repo yet for these units, so nothing else was uploaded.

This matches the repo audit in `worklog.md`'s 2026-08-29 entries exactly (adjusted for the renumbering below) — nothing was invented to fill gaps, only what already existed got uploaded.

## Renumbering: Week N → Unit (N-1), 2026-08-29

Seminar III originally organized around calendar weeks tied to specific dates (Week 1 = Aug 24-28, etc.). Per Jay, this course is moving to stable **unit numbers decoupled from the calendar**, matching the `Unit NN` convention Python already uses, to support self-paced work — a student's progress isn't supposed to be pinned to a specific calendar week. **This is Seminar III-specific** — Python already used Unit numbering and didn't need to change; Game II and Web Dev have no numbering yet since neither has a course-plan.

Mapping: **old Week N = new Unit (N-1)**, zero-padded 2 digits (Week 1 → Unit 00, Week 2 → Unit 01, ... Week 39 → Unit 38). Applied everywhere:

- `01_SEMINAR_III_COURSE_PLAN` and `02_SEMINAR_III_ACADEMIC_CONTENT_MAP` — every `Week N`/`Weeks N-M` heading and body reference (headings, prose, ranges) converted.
- All content files renamed `week-NN-*` → `unit-(NN-1)-*` across `teacher-materials/`, `instructional-content/`, `printable-sheets/`, and the top-level `week-0N-plan` source docs (now `unit-0N-plan`) — plus any literal "Week N" text inside those files (title tags, headers, cross-references like "Transition to Week 4").
- `tools/render-deck-pdf/README.md`'s usage examples.
- This Moodle course's section names and the `mdl_resource.name` field on every already-uploaded resource (both re-run via the scripts below).

**Moodle section *number* was deliberately left alone** — section 1 still holds what's now called Unit 00, section 2 holds Unit 01, etc. Only display names changed, so no content had to move between sections. `populate-seminar3-resources.php` now expects `unit-NN-*` filenames and computes the target section as `unit number + 1`.

Quarter-level date ranges (e.g. "Quarter 1: August 24 – October 23") were left as-is — those are real administrative grading-period boundaries, not part of the per-unit sequencing that's being decoupled from the calendar.

**Not done:** custom theme/branding (still default `boost`), enrollment/roles beyond the admin account, H5P content (native H5P activities, as opposed to the uploaded static HTML), Game II/Web II/most-of-Python content (doesn't exist in the repo yet to upload).

## How this was built

Scripts live in `07-infrastructure/moodle-scripts/` in this repo:

- `create-category.php` — creates the `FoxCS` category. Idempotent.
- `courses.csv` + Moodle's own `admin/tool/uploadcourse` CLI tool — creates the 4 course shells.
- `rename-seminar3-sections.php` / `rename-python-sections.php` — renames sections 1-N to the real unit titles using Moodle's `course_update_section()`. Safe to re-run.
- `rename-seminar3-resource-names.php` — renames already-uploaded resources' `mdl_resource.name` from `Week N ...` to `Unit XX ...`. One-time, part of the 2026-08-29 renumbering; safe to re-run (no-ops once names no longer match `Week N`).
- `populate-seminar3-resources.php` — walks staged HTML source files and creates File resources via Moodle's `create_module()` API, matching by `unit-NN-` filename prefix (section number = unit number + 1), hiding anything from `teacher-materials/`.

## Known gotcha: `/home/jay` isn't readable by `www-data`

This repo lives at `/home/jay/FoxCS`, and `/home/jay` is `750 jay:jay` — Apache/CLI-as-`www-data` cannot traverse into it at all (not just read files, the directory itself is unreachable). Every script above that needs to read a file from this repo (the CSV, the HTML source files) fails silently-ish with unhelpful errors (`uploadcourse.php` just prints "Invalid input CSV file" and the help text, no matter what's actually wrong) unless the file is staged somewhere `www-data` can reach first.

**Working pattern:** copy whatever the script needs into `/tmp` (or another world-readable path) before running as `www-data`:

```
cp /home/jay/FoxCS/07-infrastructure/moodle-scripts/SCRIPT.php /tmp/SCRIPT.php
sudo -u www-data php /tmp/SCRIPT.php
```

For `populate-seminar3-resources.php` specifically, the HTML source also needs staging first:

```
rm -rf /tmp/seminar-iii-src && mkdir -p /tmp/seminar-iii-src
cp -r /home/jay/FoxCS/courses/seminar-iii/teacher-materials /tmp/seminar-iii-src/
cp -r /home/jay/FoxCS/courses/seminar-iii/instructional-content /tmp/seminar-iii-src/
cp -r /home/jay/FoxCS/courses/seminar-iii/printable-sheets /tmp/seminar-iii-src/
chmod -R o+rX /tmp/seminar-iii-src
```

Don't try to fix this by loosening `/home/jay`'s permissions — that opens the whole home directory (including anything outside this repo) to every process on the box, a much bigger change than this narrow need justifies.

## Next time content changes

Re-running `populate-seminar3-resources.php` is safe — it skips any (course, section, resource name) combination that already exists rather than duplicating. If a source HTML file's *content* changes but the filename doesn't, this script won't pick up the update (it only checks for existence, not content diffs) — re-upload that one manually via the Moodle UI, or extend the script to overwrite, if this becomes a common need.

## Access-ease pass, 2026-08-29

Jay asked to make sure content is as easy as possible to get to once real students are on this. Checked (not guessed) three things against Moodle's actual source before changing anything:

- **File resources already display embedded, not downloaded.** `mod/resource/locallib.php`'s `resource_get_final_display_type()` auto-resolves the default "Automatic" display setting to `RESOURCELIB_DISPLAY_EMBED` for any `.htm`/`.html` mimetype. Every resource `populate-seminar3-resources.php` creates uses the default (`display = 0`), so clicking one already shows the page inline rather than triggering a download. No change needed.
- **Course layout already shows every section on one scrolling page**, not paginated. Checked `mdl_course_format_options` (`coursedisplay = 0`, i.e. `COURSE_DISPLAY_SINGLEPAGE`) for all 4 courses — this is Moodle's own default, not something set here. Combined with Boost's built-in Course Index side panel (also default, nothing to configure), students can both scroll and jump directly to any unit.
- **Admin (Jay) is now enrolled as Teacher in all 4 courses** (`enrol-admin-as-teacher.php`, safe to re-run) — previously not enrolled anywhere, so the courses only showed up under Site Administration, not the Dashboard. This is a dev-instance convenience for browsing normally; real student/teacher enrolment methods and rosters are a separate, later task.

**Admin password reset** to a known value for preview access, since the value set at install time was never recorded anywhere (a real gap `moodle-vm-setup.md` already flagged). Done via `admin/cli/reset_password.php`, not by guessing or searching for a stored value that doesn't exist. **Rotate this again before any real student data touches this instance** — same standing caveat as before, now just with a password Jay can actually use in the meantime.

## H5P pipeline proven, 2026-08-29 — Unit 01's Check rebuilt as a real interactive activity

Jay asked to see real interactive H5P content in Moodle, not just static HTML. Built and confirmed working end-to-end:

**The H5P Content Type Hub had never been synced on this instance** — `mdl_h5p_libraries` was empty. Manually triggered the scheduled task that normally runs monthly: `sudo -u www-data php admin/cli/scheduled_task.php --execute="\core\task\h5p_get_content_types_task"`. This reached out to h5p.org and installed **33 content-type libraries** (MultiChoice, QuestionSet, TrueFalse, DragText, DragQuestion, Blanks, MarkTheWords, CoursePresentation, and more), confirmed via `mdl_h5p_libraries`. Outbound HTTPS from this droplet works fine for this even though inbound is locked to SSH-only.

**Key technical finding: a `.h5p` package doesn't need to bundle library code if the target library is already installed server-side.** Read Moodle's H5P validator source directly (`h5p/h5plib/v128/joubel/core/h5p.classes.php`'s `isValidPackage()`) rather than assuming — it only requires a valid `h5p.json` and `content/content.json`; any library folders present in the zip get processed, but none are required if the main library is already installed and enabled. This means new H5P content can be authored as a tiny hand-built zip (just the two JSON files) instead of needing to source/bundle real H5P library JS/CSS.

**Built `Unit 01 Check (Interactive)`** — a real `H5P.QuestionSet` (1.21) wrapping 10 `H5P.MultiChoice` (1.16) sub-questions, transcribed from the same 10 questions already in `printable-sheets/unit-01-check.html` (same stems, same options, same correct answers — verified against `teacher-materials/unit-01-answer-keys.html` line by line, not re-derived). Semantics/defaults for both library types were read directly from the installed `semantics.json` files (via Moodle's file storage, not guessed from general H5P knowledge, since exact required/optional fields and default text vary by installed version). Confirmed working by logging in via `curl` and fetching both the activity view page and its H5P embed page: title resolves to "Question Set", `library` field correctly shows `H5P.QuestionSet 1.21`, and all 10 questions are present in the processed `jsonContent`.

Piloted first as a single question (`H5P.MultiChoice` only) to validate the whole pipeline cheaply before committing to the full 10-question build — that pilot module was deleted once the real version was confirmed working.

**Scripts**, both in `07-infrastructure/moodle-scripts/`:
- `create-h5p-activity.php <package.h5p> <unit-number> <name>` — general-purpose: stages a `.h5p` file into a draft area and creates the `h5pactivity` course module via `create_module()`, same pattern as `populate-seminar3-resources.php` uses for File resources. Section resolves as unit number + 1, matching the existing convention.
- `create-h5p-pilot.php` — the original single-question proof script, kept for reference; superseded by the general-purpose version above for actual content.

The `.h5p` package files themselves (built via a one-off Python script, not saved as a reusable tool yet) aren't in the repo — only the Moodle-side scripts are. **Worth doing next:** a proper content-authoring script/template that takes question data (stem, options, correct answer) and emits a valid `.h5p` package, rather than hand-writing the JSON per activity like this first one.

**The old static `printable-sheets/unit-01-check.html` was left in place, not deleted** — Jay's call on when/whether to retire it now that the interactive version exists.

## Unit 01 instructional content rebuilt as interactive H5P, 2026-08-29

Jay asked to see the instructional content itself made interactive, not just the check. Rebuilt `unit-01-what-do-i-do-when-im-stuck.html` as **`Unit 01: What Do I Do When I'm Stuck? (Interactive)`**, an `H5P.Column` (1.22) mixing 6 `H5P.AdvancedText` reading blocks with 4 embedded checks-for-understanding placed at natural pause points in the reading, not just at the end:

- 2 `H5P.MultiChoice` questions (a fresh scenario each, not reused from the Check, so reading the instructional page doesn't just spoil the check answers).
- 1 `H5P.TrueFalse` question.
- **2 `H5P.SortParagraphs` ("Sort the Paragraphs") sequencing exercises**, added per Jay's request to use a real sequencing interaction where one fits: reordering the five-question routine back into its correct sequence, and reordering the steps of solving `6 + 3 × 4` via order of operations. `H5P.SortParagraphs` was already installed from the same Hub sync as the other content types — its `paragraphs` field is just a plain list of strings in the correct order, shuffled for the student and checked on submit.

Verified the same way as the Check: authenticated `curl` against the activity's embed page, confirming `library: H5P.Column 1.22` and that all 11 sub-content blocks (6/2/1/2 by type) are present in the processed output.

**The old static instructional HTML was left in place, not deleted**, same as the Check.

**Not yet done:** guided practice and independent practice are still static HTML. Both are open-ended/written-response in their current form (work shown, short explanations), which doesn't map onto H5P's answer-checked question types as directly as the Check did — worth deciding the right H5P shape for these (versus which parts should stay open-ended) before rebuilding, rather than forcing a multiple-choice fit where it doesn't belong.

## Sequencing added, and a real content-type-compatibility bug caught, 2026-08-29

Jay asked for real sequencing/reordering interactions where they fit. **`H5P.SortParagraphs`** ("Sort the Paragraphs") was already installed from the Hub sync and is the right fit — a plain ordered list of text strings, shuffled for the student and checked against the original order.

**First attempt nested three `SortParagraphs` blocks inside the Unit 01 Column, and it silently broke** — Moodle rendered "The H5P library H5P.SortParagraphs 0.11 used in the content is not valid" instead of the actual exercises. Root cause, found by reading `h5p.classes.php`'s `validateLibrary()`: a `library`-type field (like `H5P.Column`'s `content` field, or `H5P.QuestionSet`'s `questions` field) only accepts sub-content types explicitly listed in *that specific field's* `semantics.json` options array — being installed and enabled site-wide isn't enough. Checked both: **neither `H5P.Column` (1.22) nor `H5P.QuestionSet` (1.21) lists `H5P.SortParagraphs` as an allowed sub-content type** in this installed version. It's a standalone-only activity type here, not composable inside those two wrappers.

**Fix: split it out.** The Column kept the reading + `H5P.MultiChoice`/`H5P.TrueFalse` checks (9 blocks, all confirmed-compatible sub-types). The three sequencing exercises became their own standalone `h5pactivity` modules, placed in Unit 01's section right after the Column:

- **Unit 01: Sequence the Five-Question Routine (Interactive)** — reorder the 5 questions back into their real sequence.
- **Unit 01: Sequence the Order of Operations Steps (Interactive)** — reorder the steps of solving `6 + 3 × 4`.
- **Unit 01: Sequence a Real-World Problem (Interactive)** — a fresh scenario (affording shoes vs. saving for a gift), sequencing the concrete real-world steps of applying the problem-solving routine, not just the abstract question labels. Added per Jay's specific request for a real-world application, distinct from the more abstract routine-reordering exercise.

All three verified error-free and content-correct via the same authenticated-`curl`-against-the-embed-page method used throughout this session (each activity's response checked for its own distinctive text, confirming no cross-contamination between the three).

**Lesson for future H5P builds:** before nesting any library inside a `Column`/`QuestionSet`/similar wrapper, check that wrapper's own `semantics.json` options list for the sub-library first — don't assume "installed and enabled" is sufficient. `is_valid_package()`'s checks (used for the initial upload) are a different, looser check than `validateLibrary()`'s per-field options check (used when the wrapper actually renders its children) — passing the former does not guarantee passing the latter.

## Real SVG-drawn diagrams added, 2026-08-29

Jay asked for a visual "breaking it down" treatment of the problem-solving sequence, and for SVGs generally wherever they'd help visual learners. Two diagrams built and embedded in the Unit 01 Column:

- **`routine-flow.svg`** — the five-question routine as five connected numbered steps (STOP/FIND/CONNECT/TRY/CHECK), each with its real question text and a short example, placed right after the routine's text explanation.
- **`error-types.svg`** — the five error types as icon cards (lightbulb for Knowledge, looping arrow for Process, off-center target for Execution, question-mark speech bubble for Comprehension, signpost for Strategy), each with its description and suggested next step, placed right after "Why Was My Answer Wrong?"

**A real constraint discovered mid-build: H5P's content-file whitelist does not include `svg`.** Checked `H5PCore::$defaultContentWhitelist` directly (`h5plib/v128/joubel/core/h5p.classes.php`) rather than assuming, and confirmed Moodle's own `framework::getWhitelist()` doesn't extend it either — raw `.svg` files bundled inside a `.h5p` package's `content/images/` folder get rejected at upload with a "file not allowed" error. **Fix: draw the diagrams as SVG (for precise, easy-to-edit source), then rasterize to PNG before packaging** — `librsvg2-bin` (`rsvg-convert`) installed via `apt` for this, converting at 1400px width for crisp display at any reasonable embed size. `H5P.Image` (already confirmed in `Column`'s allowed sub-content list) displays the PNG; the `.svg` source files themselves aren't part of the `.h5p` package, only the rendered PNGs are.

Verified the same way as everything else: authenticated `curl` against the embed page confirmed no validity errors and both image paths present, then fetched the actual image bytes directly from Moodle's `pluginfile.php` to confirm they're served correctly and byte-identical to the source PNG (not just referenced).

**SVG source files** now live in the repo at `07-infrastructure/moodle-scripts/diagrams/` (`routine-flow.svg`, `error-types.svg`) so they survive past this session and can be edited/regenerated later — `rsvg-convert -w 1400 <file>.svg -o <file>.png` reproduces the exact PNGs used in the deployed content.

## Instructional content split, error-type testing added, arrow fixed, 2026-08-29

Three pieces of feedback from Jay after reviewing the first interactive instructional build:

1. **The Process icon's arrow pointed the wrong way.** Fixed in `error-types.svg`: recomputed the arc and arrowhead from real geometry instead of eyeballing it (circle center, radius, and the tangent direction at the arc's endpoint all computed explicitly) so the arrowhead correctly points in the direction of rotation. Regenerated the PNG and re-verified the served image bytes.
2. **"Learn From the Error" needed a way to test understanding, not just read worked examples.** Its three worked examples reveal their own answers in the text, so a quiz on those specific three wouldn't test anything. Added a **"Test Yourself"** block with 4 new multiple-choice scenarios (covering Process, Execution, Comprehension, and Strategy — Knowledge was already covered by an earlier question) right after the worked examples, using fresh scenarios not reused from the Check, the practice sheets, or the worked examples themselves.
3. **Split into two shorter readings**, per Jay's suggestion: one long Column became two —

   - **`Unit 01: Solving Problems (Interactive)`** — Getting Stuck Is Information, the five-question routine, the routine-flow diagram, one check, Walk Through a Problem, and a short routine-focused Quick Reference. 6 blocks.
   - **`Unit 01: Error Types (Interactive)`** — Why Was My Answer Wrong, the error-types diagram (fixed arrow), the existing Knowledge check, the True/False check, Learn From the Error, the new 4-question Test Yourself block, and an error-types-focused Quick Reference. 11 blocks.

   The original combined `Unit 01: What Do I Do When I'm Stuck? (Interactive)` activity was deleted and replaced by these two rather than kept alongside them, since it fully overlaps both.

Both verified error-free via the same authenticated-embed-page method as everything else in this build, including confirming block counts (Activity A: 1 MultiChoice; Activity B: 5 MultiChoice + 1 True/False + both images) match what was actually authored.

## Unit 01 completeness pass and sequencing, 2026-08-29

Jay asked for a full pass to make sure Unit 01 has everything a Learner needs to practice, and to sequence the activities (01.1, 01.2, ...) rather than leave them as an unordered pile in the section.

**Content gap filled:** the "Classify the Error" portions of Guided Practice and Independent Practice were static, non-interactive lists (name the error type, no feedback). Built two new `H5P.QuestionSet` activities from the exact same scenarios already in the printed sheets and answer key (not new content) — **Guided Practice: Classify the Error (Interactive)** (5 questions) and **Independent Practice: Classify the Error (Interactive)** (10 questions) — each with the same per-option feedback structure (reason + next step) used everywhere else. **The "Five-Question Routine" halves of both practice sheets were deliberately left static** — those are open-ended, show-your-work problems ("write out all five questions for each"), and forcing them into multiple-choice would misrepresent the task rather than support it.

**Sequenced and renamed** all 11 student-facing Unit 01 resources with a `01.N --` prefix reflecting the real order a Learner should work through them:

1. Solving Problems (Interactive)
2. Sequence the Five-Question Routine (Interactive)
3. Error Types (Interactive)
4. Sequence the Order of Operations Steps (Interactive)
5. Sequence a Real-World Problem (Interactive)
6. Guided Practice
7. Guided Practice: Classify the Error (Interactive)
8. Independent Practice
9. Independent Practice: Classify the Error (Interactive)
10. Quick Reference
11. Check (Interactive)

**Hid two now-superseded static resources** (not deleted) — the original combined instructional page and the original static Check — since interactive replacements fully cover the same content and leaving both versions visible would leave a Learner unsure which one to actually do. Teacher-only resources (deck, answer keys) untouched.

Script: `07-infrastructure/moodle-scripts/sequence-unit01.php` — renames via direct DB update (bypassing the edit form, since there's no browser here), hides the superseded pair, and rewrites `course_sections.sequence` to the intended display order while preserving every other cmid in the section. Safe to re-run.

**Still outstanding, not built this pass:** the ACT Math Baseline (`unit-01-plan` sections 21-29, 20-24 questions with skill/domain/difficulty metadata) — flagged repeatedly as a separate, larger deliverable, still true. That's the one real content gap left in Unit 01.

## Guided/Independent Practice made genuinely interactive, 2026-08-29

Jay's rule: guided practice should be interactive; a worked example can stay static since nothing is being answered, but anything a Learner is meant to answer or work out needs to be something they can actually type into.

Rebuilt both **01.6 Guided Practice** and **01.8 Independent Practice** as `H5P.Column` activities using `H5P.Essay` (confirmed present in Column's allowed sub-content list, unlike `SortParagraphs`) for every "try these" problem — a real text box, a placeholder prompting a full five-question-routine response, and a "Show sample solution" button revealing a real worked answer (not just a final number) after submitting. Worked examples (the chore-timing demo in Guided Practice) stayed as static `H5P.AdvancedText`, matching the rule exactly. The "Classify the Error" halves of both sheets were already interactive as separate 01.7/01.9 activities from the prior pass, so weren't duplicated here.

A build bug surfaced and got fixed immediately: `create_module()` auto-appends a new module to the end of `course_sections.sequence`, so swapping the new cmids into their intended mid-sequence position (replacing the old static resources) left a duplicate trailing copy. Fixed by deduplicating the sequence, keeping the first (correctly positioned) occurrence.

Old static `01.6`/`01.8` resources hidden and renamed to `... (old static version, superseded)` so they're unambiguous in the hidden/admin list, not deleted.

## H5P content-type reference, 2026-08-29

Jay asked to catalog what's actually available (all 33 content types installed via the Hub sync, see the "H5P pipeline proven" entry above) and when to use what, so future choices are deliberate instead of trial-and-error like the `SortParagraphs`-in-`Column` incompatibility discovered earlier. New doc: **`07-infrastructure/h5p-content-type-guide.md`**.

## Migrating to the eventual NTC Hosting production instance

Not yet done. Per `moodle-vm-setup.md`'s existing "Migrating to the eventual production host" section, this means either a course backup (`.mbz`) restore per course, or a full site migration once NTC Hosting is confirmed to support what's needed. Revisit once the domain is registered and hosting specs are confirmed (see `decisions-log.md`, 2026-08-29).
