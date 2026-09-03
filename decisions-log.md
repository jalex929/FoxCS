# Decisions Log

Append-only. Newest entries at the top. Each entry: what was decided, why, and what it supersedes.

---

## 2026-08-30 (final) — Mastery Check built as a real Moodle Quiz; Moodle-replaces-Classroom floated, deliberately not scoped yet

**Context:** Jay asked about password-protected mastery checks going forward, which surfaced that today's Moodle upload work (both the file-based lessons and the Interactive Book pilot) is currently a **read-only preview mirror** -- students aren't actually submitting anything to Moodle at all. The real submission path is still Google Classroom (students edit files in their own copy, submit the whole folder back through Classroom, Jay downloads and grades). Asked directly whether Jay wanted Moodle to become the real submission point; he said yes in principle ("I would be happy to make moodle the replacement to Google Classroom"), and confirmed he's not worried about needing one unified submission -- per-activity is fine.

**Decided:** that's a large migration (student enrollment, a real submission mechanism per content type, reworking `05-grader/`'s Classroom-shaped codename-swap pipeline) that hasn't been scoped, so **deliberately started narrow**: prove the pattern on Mastery Check specifically, since that's what prompted the question and is the one piece H5P categorically cannot do (no password-gate mechanism exists in any installed H5P content type, confirmed while building yesterday's pilot).

**Built:** Lesson 01.1's Mastery Check as a real `mod_quiz` instance -- 4 `qtype_essay` questions (manually graded, same real open-ended questions as `07_mastery_check.html`) plus a native "require password" setting. This is Moodle's own supported password mechanism, not anything hand-rolled, with real gradebook/attempt tracking as a side benefit the HTML/H5P versions never had.

**Real implementation problems hit and solved, not glossed over:**
- Moodle's PHPUnit test-generator classes (`mod_quiz_generator`, `core_question_generator`) looked like the obvious tool but have a hard `PHPUnit\Framework\TestCase` dependency -- confirmed unusable standalone by trying, not assumed. Fell back to the actual production save path (`question_type::save_question()`, the same code the real question-editing form calls) instead.
- `create_module()` for a quiz needs `$moduleinfo->quizpassword`, not `->password` -- the raw DB column is `password`, but the form-field name `quizpassword` is what the creation code expects, confirmed by reading `mod/quiz/lib.php`'s own remapping line after a real failed DB write pointed at it.
- `quiz_update_sumgrades()` no longer exists as a standalone function -- renamed to `\mod_quiz\grade_calculator::recompute_quiz_sumgrades()`, an instance method obtained via `quiz_settings::create($quizid)->get_grade_calculator()`. Found via `mod/quiz/UPGRADING.md`'s own rename log, not guessed.
- **Verified end to end, not just checked for absence of errors**: fetched the real quiz view page and confirmed an actual `<input type="password" name="quizpassword">` renders, proving Moodle's own native access-control code is really gating this, not something that merely looks configured.

**Not yet done:** wiring this into either the HTML-file lesson or the Interactive Book as 01.1's "real" mastery check (it's a standalone proof right now, not linked from either), the same pattern for Lessons 01.2-01.6, and the full Moodle-replaces-Classroom scope (enrollment, per-content-type submission design, grader rework) -- all explicitly deferred pending Jay's review of this one piece.

**Supersedes:** nothing structural, extends today's earlier Moodle-upload work. Root `CLAUDE.md`'s "Moodle paused, Classroom is the delivery mechanism" framing is now under real reconsideration but not yet formally changed -- don't treat it as settled either way.

---

## 2026-08-30 (final) — Simplified Python's Moodle nav; piloted H5P Interactive Book for Lesson 01.1

**Context:** Jay reviewed the Moodle-uploaded Unit 01 content (previous entry) and gave two pieces of feedback: (1) the in-page nav menu showing "Unit 01" with all 6 lessons collapsed inside is redundant now that each lesson is its own Moodle tab — it should just show the current lesson's own sub-items; (2) clicking a subitem link produced a blank page/error (a real symptom, not fully diagnosable without a real browser — see `worklog.md`'s Playwright checklist). Jay also asked whether an H5P Interactive Book might be a better fit given its native page navigation, floated as a real architectural question, not a snap decision.

**Decided:**

- **Nav simplified.** `stage_unit01_for_moodle.py` rewritten to replace the full nested unit-menu with a flat, always-visible list of just the current lesson's own files, for the Moodle-uploaded copies only — the real repo files keep their full cross-lesson menu, since that's correct for actual Classroom-folder delivery. All 6 lessons re-uploaded (old cmids 85-90 deleted, new cmids 98-103).
- **H5P Interactive Book piloted on Lesson 01.1 only**, not committed to for all 6 lessons — real rebuild cost (existing custom JS drills have no direct H5P equivalent) justified proving the idea first. Covers the conceptual content (Instruction as `H5P.Column`/`AdvancedText`+`MultiChoice` quick-checks, Flashcards as `H5P.Dialogcards`, Vocab Quiz and Practice as `H5P.QuestionSet`, Project as `H5P.Essay`) adapted from the real existing lesson content, not fabricated. Mastery Check deliberately excluded (no H5P equivalent for the password-gate + auto-timestamp mechanism `mvp-unit-folder-structure.md` specifies) and code-writing steps stay in VS Code — this resumes the original pre-pause "Moodle for concepts, VS Code for applied work" Two-Surface model rather than replacing it. Live at cmid 97, positioned right after the overview page and before the HTML-file version of 01.1 for direct side-by-side comparison.

**Real bug found and fixed, worth remembering:** `H5P.InteractiveBook`'s `chapters` list appeared to want each item wrapped as `{"chapter": {...Column...}}`, matching the semantics field name. This is wrong and **fails completely silently** — no upload error, no validity message, the package looks fine, but Moodle's content filter strips the entire `chapters` array during processing (confirmed: `mdl_h5p.filtered` ended up ~176 bytes, just the top-level settings). Root cause, found by reading `h5p.classes.php`'s `validateGroup()` directly: a semantics `group` with exactly one field gets auto-flattened by the validator, so the wrapper key must be omitted — each chapter is the bare `H5P.Column` object, same flat shape `H5P.QuestionSet`'s `questions` list already uses. Documented in `07-infrastructure/h5p-content-type-guide.md`'s new section, alongside the general lesson: don't just check for the absence of a validity error, verify actual content text survived filtering.

**Still open:** Jay's decision on porting the other 5 lessons to Interactive Book format, pending his review of the pilot. The subitem-click symptom Jay reported is still not independently diagnosed (no sandbox restriction found in Moodle's embed iframe code, but no real browser available to fully test) — moot for 01.1 once/if the Interactive Book pilot is adopted, since H5P handles its own navigation internally rather than raw iframe-embedded static files.

**Supersedes:** nothing structural in the earlier entry — the same 6 lesson resources exist, just re-uploaded with simplified nav, plus one new pilot resource.

---

## 2026-08-30 (yet later still) — Python Unit 01 content uploaded to Moodle, as a review channel

**Context:** Jay tried to review Unit 01's content but has no way to open local HTML files from this droplet session (not on his desktop yet). He'd apparently looked at the `foxcs-python` Moodle shell (built 2026-08-29 as an empty structural skeleton) and found "Unit 1 empty" — accurate for Moodle specifically, even though the repo's Unit 01 content is fully built. Asked directly whether to keep Python's Moodle shell empty (repo-only review, wait for desktop) or upload the built content there now; chose to upload.

**Decided:** Moodle becomes an additional review/preview channel for Python content, not a replacement for the Google Classroom MVP delivery model (unchanged, still paused-for-Moodle per root `CLAUDE.md`'s Status section).

**Real technical problem solved:** Python's lesson folders are ~8-12 numbered files linked by real relative paths, including a nav menu that also links to every *other* lesson in the unit. Uploading each file as its own Moodle resource (Seminar III's pattern) would create 60+ items for just Unit 01 — the exact sprawl problem fixed for Seminar III's Lesson 1 earlier the same day. Instead, built a multi-file-per-resource approach: each lesson uploads as **one** Moodle resource containing all its files, with `00_table_of_contents.html` set as the main/entry file via `file_set_sortorder()` (confirmed by reading Moodle's own `mod/resource/locallib.php`, not guessed) — sibling files in the same resource resolve correctly since Moodle serves them from one shared file area.

**Real limitation found and handled, not glossed over:** a cross-lesson link (`../lesson_01_02.../...`) doesn't 404 in this setup — it silently resolves back into the *same* resource's own file area, so a student clicking "jump to Lesson 01.2" from inside 01.1 would silently stay on 01.1 with no visible error. Confirmed by testing the actual `pluginfile.php` URL, not assumed. Fixed by staging a Moodle-specific copy (`07-infrastructure/moodle-scripts/python/stage_unit01_for_moodle.py`) that strips cross-lesson menu entries before upload — **the real repo files are untouched**, since the un-stripped version is correct for their actual Google Classroom delivery context. Within-lesson navigation (flashcards, quiz, practice, project, mastery check) still works perfectly; moving between lessons in the Moodle copy requires going back to the course's section list.

**Built and live:** `foxcs-python` section 2 (Unit 01) now has an overview page, all 6 lessons, and the unit-level project pair, 9 resources total, all verified via authenticated fetch (correct title, correct main file, same-lesson sibling navigation confirmed working). Full scripts and reasoning: `07-infrastructure/moodle-scripts/python/README.md`.

**Found, not touched:** a pre-existing stray resource ("Lesson 1 Presentation (Teacher)") sitting in `foxcs-python` section 1 (Orientation) — doesn't match Python's naming convention at all (uses Seminar III's "Lesson N" pattern), likely a leftover test artifact from 2026-08-29's course-shell build. Harmless, unrelated to this section's work, left alone rather than guessed at.

**Not yet done:** Units 00, 02-20 have no content to upload yet. No real-browser (Playwright) verification of any of this — see `worklog.md`'s checklist, same gap as the rest of today's Python work.

---

## 2026-08-30 (yet later) — Python Unit 01 brought to full consistency; nav-menu sync tooling built

**Context:** Jay asked to start building out FoxCS: Python (Game I), picking Unit 00 (Course Onboarding) and Unit 01 first. Investigation found Unit 00 was a false alarm: it's already fully built as shared cross-course content (`shared/unit_00_onboarding_level1/`, done 2026-08-18) — only `course-plan.md`'s stale pointer needed fixing. The real work was Unit 01, which `mvp-unit-folder-structure.md` and `unit-01-content-inventory.md` both (incorrectly) claimed was "not yet rebuilt to the current pattern" for 5 of its 6 lessons.

**Decided/built:**

- **Dispatched 5 parallel background agents**, one per lesson (01.1, 01.2, 01.3, 01.5, 01.6), each told to treat `lesson_01_04_printing_output/` (the reference implementation) as a literal template and read the existing lesson content before rewriting anything.
- **Finding that changed the whole scope:** every single fork independently discovered its assigned lesson was already rebuilt to the modern pattern in earlier sessions (mostly 2026-08-20/21) — the "not yet rebuilt" docs were simply stale. What was real and still missing, matched to `mvp-unit-folder-structure.md`'s own explicit component recommendations:
  - **01.2**: the Categorization drag-and-drop drill (Input/Process/Output sorting), flagged since 2026-08-06 as intended for this lesson and never built. Added as a new drill; a real scoring bug (re-counting already-correct items) was caught and fixed during the build.
  - **01.3**: the Sequencing drill (reordering scrambled `print()` lines), same story, plus a missing `06_application.py` hands-on step. Both added; two real pre-existing bugs (a stale prev-link, a wrong filename in mastery-check save instructions) caught and fixed.
  - **01.6**: the Categorization drill (SyntaxError vs. NameError sorting), same story.
  - **01.1**: no drill gap, but a missing project step — which turned out to be a *deliberate* 2026-08-20 decision (01.1 is purely conceptual, no code yet, so a project didn't apply), not an oversight. The fork's directive didn't know this and built one anyway (a pseudocode/plain-English "design a program" project), explicitly flagged as a reversal needing Jay's confirmation — **still open, not yet resolved.**
  - **01.5**: no structural gaps at all, existing content was already excellent.
- **Repo-wide em-dash violation found and fixed**, ~475 instances across every lesson in the unit except 01.6 (which a fork had already cleaned during its own build) — a real, previously-unflagged breach of Jay's standing no-em-dash rule, missed by every prior session that touched this content. Fixed via a mix of targeted forks (contextual replacement: period-split, colon, comma depending on grammatical role, never blind hyphen substitution) and direct fixes after two of five forks hit a session usage limit mid-task. Pure dev/internal comments (`<!-- -->` author notes, JS/CSS `//`/`/* */` comments never rendered to a student) were deliberately left alone as out of scope, consistent with what the first fork to hit this (01.5's) had already treated as the right line to draw.
- **Changed the documented title-format convention repo-wide**: `N.N.N — Type: Subtitle` → `N.N.N Type: Subtitle` (dropped the em-dash separator; the colon already does the job). Applied to every lesson and to `mvp-unit-folder-structure.md`'s own documented examples.
- **Built and verified a nested, collapsible unit-wide nav menu** (per Jay's direct request) — turned out to already exist (`<details>`/`<summary>`, 3 levels: unit toggle → per-lesson collapse → file links), but copy-pasted inline into all 47 HTML files with no shared source. The parallel lesson rebuilds caused real drift (stale file lists in sibling lessons' copies; one rebuild dropped the other 5 lessons from its copy entirely). Fixed with a new script, `02-authoring-system/tools/sync_unit01_nav_menu.py`, that regenerates the menu from one source-of-truth file list and syncs it identically everywhere — verified every resulting link resolves to a real file. This copy-paste architecture and the sync tool are now documented in `mvp-unit-folder-structure.md`'s new "Unit-Wide Nav Menu" section so it isn't rediscovered the hard way again.
- Marked all 6 lessons 🔍 reviewed (not just ✅ drafted) in `course-plan.md`, and corrected the stale "not yet rebuilt"/"no content" claims in `mvp-unit-folder-structure.md` and `unit-01-content-inventory.md`.

**Not yet done:** Jay's confirmation on 01.1's project-step reversal (see above). Verifying any of this in a real browser (one fork flagged it couldn't get Playwright running and relied on syntax-check + manual trace instead — weaker evidence than this repo's usual authenticated-browser-click-through standard). A repo-wide em-dash sweep beyond Unit 01 (Unit 00's shared onboarding content, and anywhere else in FoxCS, haven't been checked).

**Supersedes:** the "5 lessons not yet rebuilt" and "no drill gap filled" claims in `mvp-unit-folder-structure.md`'s 2026-08-06 note and `unit-01-content-inventory.md`.

---

## 2026-08-30 (later still) — Seminar III renamed Unit N → Lesson N; orientation content unnumbered

**Context:** After consolidating Lesson 1 (then still called "Unit 01"), Jay revisited the earlier-deferred Unit-to-Lesson rename, specifically asking about the orientation content (old "Unit 00"). Confirmed with Jay: orientation gets pulled out of the numbered sequence entirely as **"Orientation"** rather than "Lesson 0" (avoids the confusing off-by-one where "Unit 01" was actually the *second* week) — matching how Python keeps its own onboarding *inside* its Unit numbering was explicitly not followed here, since Jay said this scheme is Seminar III-specific. Also confirmed the letter-suffix rule: a lesson combining academic-skills and postsecondary content in the same week gets split as "Lesson NA"/"Lesson NB"; a lesson with only one gets a bare number, no letter.

**Decided:** Because orientation is pulled out of the sequence rather than shifted, this rename needed **no renumbering arithmetic** — "Unit NN" simply becomes "Lesson N" everywhere except Unit 00, which becomes "Orientation". Applied:

- **Moodle (all 39 sections + every resource/h5pactivity name in the course, not just the 9 with content):** `07-infrastructure/moodle-scripts/rename-units-to-lessons.php` — regex-transforms "Unit 00: X" → "Orientation: X", "Unit NN: X" → "Lesson N: X" (drops leading zero), "Unit 00 X" → "Orientation X", "Unit NN X" → "Lesson N X", and the "01.N --" item-prefix convention → "N.M --". Section **numbers** unchanged (section 1 = Orientation, section 2 = Lesson 1, etc.) — only display names moved, so no content had to be relocated between sections, same low-risk pattern as the 2026-08-29 Week→Unit rename. One item needed a manual follow-up fix (a mid-string "Unit 01" the front-anchored regex didn't catch).
- **Repo files:** every `unit-NN-*` file (plan docs, `instructional-content/`, `printable-sheets/`, `teacher-materials/`) renamed to `lesson-N-*` (no leading zero); `unit-00-*` → `orientation-*`. 41 files renamed via `git mv`.
- **In-file text:** every literal "Unit 0N" / "Unit N" string across both course-plan source docs, all lesson-plan files, and all HTML content converted to "Lesson N" (or "Orientation" for 00) via a single regex pass — 44 files, ~450 replacements total.
- **`populate-seminar3-resources.php`** updated to match `lesson-N-*`/`orientation-*` filenames going forward, computing section number from the parsed lesson number (or 1 for orientation) rather than a fixed `unitnum + 1` pattern keyed to two-digit unit numbers.
- **`07-infrastructure/moodle-scripts/h5p-builder/`** scripts and README renamed (`unit01_*` → `lesson1_*`) and their internal "Unit 01" strings updated to match, for consistency with anything that re-runs them later.
- Root `CLAUDE.md`'s course table entry for Seminar III rewritten to describe the new Lesson/Orientation model and current build status, replacing a stale 2026-08-29 description.

**Deliberately not touched:** `courses/python/`'s own `Unit NN` numbering (unaffected, Jay confirmed this is Seminar III-specific) and historical `decisions-log.md`/`worklog.md` entries describing what was true under the old naming at the time.

**Not yet done:** the actual A/B letter-suffix split doesn't apply anywhere yet, since no Quarter 1 lesson currently combines academic and postsecondary content in the same week (per the real course plan, Q1 postsecondary work is light and not weekly). Also not touched: a handful of internal H5P content `title` fields baked into already-uploaded package JSON (e.g. an H5P activity's own on-page header) still say "Unit 01" in a few places — cosmetic, lower-visibility than the Moodle activity-list name that's now correct everywhere, flagged rather than chased down this pass.

**Supersedes:** the 2026-08-29 Week→Unit renumbering's naming (not its section-number/no-content-relocation mechanism, which this reused directly).

---

## 2026-08-30 (later) — Unit 01 consolidated from 16 to 12 activities

**Context:** Jay flagged that 16 separate items in one Moodle section felt sprawling, and asked whether "1 week = 1 unit" was the right model going forward, floating a Unit-to-Lesson rename with A/B letter suffixes for academic vs. postsecondary content. Scoped down to just the activity-count problem first (his call, explicitly deferring the rename) since the rename would touch ~40 sections and 30+ filenames for a naming question, while the sprawl was a real, separately-fixable problem.

**Decided/built:** Merged 4 pairs of activities using real H5P-content-level merges (not just Moodle grouping), respecting the standalone-SortParagraphs constraint discovered 2026-08-29 (still can't nest inside Column/QuestionSet):

- Guided Practice (Column/Essay) + its Classify-the-Error questions (QuestionSet/MultiChoice) → one Column, since MultiChoice *is* an allowed Column sub-type (already proven). Same for Independent Practice.
- The pre-baseline Quick Reference (Column of text blocks) folded directly into the ACT Math Baseline's own `introPage.introduction` HTML field, rather than standing alone — H5P.QuestionSet already has a rich-HTML intro slot built for exactly this.
- The Day 4 (baseline) and Day 5 (final "Build Your Starting Strategy") reflections merged into one two-part Column, since they're structurally identical (Column + Essay) and pedagogically sequential.

Built via `07-infrastructure/moodle-scripts/h5p-builder/merge_unit01.py`, which pulls each source activity's *actual stored* `jsoncontent` from the DB (not re-authored from scratch) and recombines the real content blocks — no content was rewritten or lost, only regrouped. All 4 merges verified via the same authenticated-embed-page method as every other activity in this build (block/question counts, library versions, no validity errors) before hiding any originals.

**Result:** Unit 01 section now shows 12 visible items (Week at a Glance + 01.1-01.11) instead of 16. The three SortParagraphs sequencing activities (01.2/01.4/01.5) stay standalone — genuinely can't be merged given the H5P constraint, and they test distinct sequences that shouldn't be combined content-wise anyway.

**Not decided:** the Unit-to-Lesson rename with A/B postsecondary suffixes — explicitly deferred, not rejected. Revisit once Jay wants to reopen it; it's a bigger job (touches every section name, every `unit-NN-*` filename, and every script from the 2026-08-29 renumbering) than today's consolidation.

**Supersedes:** nothing structural — the 8 originals (cmids 66,64,67,65,69,68,70,71) are hidden, not deleted, consistent with this repo's standing "hide, don't delete superseded content" convention.

---

## 2026-08-30 — Unit 01's ACT Math Baseline built (Day 3-5 gap closed); reusable question-to-H5P builder script added

**Context:** Jay confirmed Unit 01 (Aug 31-Sep 4) is a fully academic week with no postsecondary content this cycle, then asked to build whatever was left. A readiness check against the live Moodle dev instance found Days 1-2 fully built (10 interactive H5P activities) but Day 3 (the ACT Math Baseline) completely missing, with Days 4-5 blocked on it — the same gap flagged and never picked up in yesterday's worklog.

**Decided/built:**

- **24-question ACT Math Baseline**, matching `unit-01-plan`'s domain/difficulty distribution exactly (Numbers & Operations 4, Fractions & Decimals 4, Percent 3, Ratios/Rates/Proportions 3, Variables & Expressions 3, Equations 3, Mixed Application 4; difficulty 8 Level A / 10 Level B / 6 Level C). Built as `H5P.QuestionSet` (matching the existing Check's pattern), uploaded as `01.13 -- ACT Math Baseline`.
- **A pre-baseline "Quick Reference" reminder card** (`01.12`), per Jay's direction: the baseline tests skills (order of operations, signed numbers, fraction operations, percent, proportions, equation-solving) that Unit 01 itself doesn't teach — those come in Units 02-08. A full re-teach would defeat the diagnostic's purpose (seeing what students currently know), so this is deliberately rules/reminders only, no worked practice.
- **Day 4/5 reflection activities** (`01.14` baseline reflection, `01.15` final "Build Your Starting Strategy" reflection) as `H5P.Column` + `H5P.Essay` activities, covering `unit-01-plan` sections 27-29 (confidence check-in, Strength/Developing/Priority self-identification) and section 30's Day 5 structure.
- **Teacher-only answer key/skill map** (`courses/seminar-iii/teacher-materials/unit-01-baseline-answer-key.html`, uploaded hidden): full metadata table (domain/skill/difficulty/correct answer/expected strategy/likely misconception/likely error type) for all 24 questions, discussion prompts, and a results-summary language template.
- **A "Week at a Glance" pacing calendar** (`courses/seminar-iii/printable-sheets/unit-01-week-at-a-glance.html`), per Jay's request for a dual-purpose doc: student-facing day-by-day overview and a teacher pacing map naming the exact Moodle activity due each day. Uploaded visible, placed first in the section.
- **Reusable question-data-to-.h5p builder** (`07-infrastructure/moodle-scripts/h5p-builder/`) — the tool flagged as a queued task in yesterday's worklog and never built. Two functions (`build()` for QuestionSet+MultiChoice, `build_column()` for Column+AdvancedText+Essay) reverse-engineered directly from the existing Check/Guided-Practice content's stored `jsoncontent`, not guessed from general H5P knowledge.
- **Verification method note:** direct DB inspection of `mdl_h5p.jsoncontent` only works after an activity has been viewed at least once through the player (Moodle processes H5P packages lazily on first view) — the authenticated-curl-against-the-embed-page method remains necessary, and from this droplet requires a `Host: localhost:8080` header override since `$CFG->wwwroot` includes the SSH-tunnel port and nothing actually listens on 8080 locally.

**Side effect caught and fixed:** re-running `populate-seminar3-resources.php` (to pick up the new week-at-a-glance sheet) re-uploaded three already-superseded static resources as fresh duplicates, because their Moodle names had since been changed by `sequence-unit01.php` (the script's duplicate-check compares against the *original* generated name). The four new duplicates were found and hidden, not deleted. **Known gotcha for future re-runs:** re-run this script only for genuinely new source files, or expect to clean up duplicates of anything already renamed.

**Not yet done:** rotating the dev-instance admin password again (still the same preview password set 2026-08-29/30); migrating any of Unit 01 to NTC Hosting once that's live.

**Supersedes:** nothing — closes the specific Day 3-5 gap flagged in `worklog.md`'s 2026-08-29 "Next up" list.

---

## 2026-08-29 (later) — Seminar III renumbered Week N → Unit (N-1), decoupled from the calendar for self-paced work

**Context:** Jay asked to scope Unit 00 (orientation)/Unit 01/Unit 02 content, introducing "Week 0" as the intro week distinct from the existing "Week 1: Welcome to Seminar III." Asked directly whether this meant a real renumbering or just conversational shorthand — Jay's answer: shift to identifying by **unit number**, not week-of-year, specifically so the numbering doesn't have to keep changing as self-paced student progress diverges from a fixed calendar. Confirmed this applies to Seminar III only — Python already uses `Unit NN`, Game II/Web Dev have no numbering yet (no course-plan for either).

**Decided:** Old `Week N` → new `Unit (N-1)`, zero-padded 2 digits (Week 1 → Unit 00 ... Week 39 → Unit 38), matching Python's existing `Unit 00` starting point. Applied everywhere, since nothing here was committed to git yet (low-risk to do properly rather than leave mixed terminology):

- Both Seminar III source docs (`01_SEMINAR_III_COURSE_PLAN`, `02_SEMINAR_III_ACADEMIC_CONTENT_MAP`) — all `Week N`/`Weeks N-M` headings, prose, and ranges converted (64 replacements total across both files).
- Every content file renamed `week-NN-*` → `unit-(NN-1)-*` (30 files across `teacher-materials/`, `instructional-content/`, `printable-sheets/`) plus the 8 top-level `week-0N-plan` source docs → `unit-0N-plan`, and literal `Week N` text inside all of them (titles, headers, cross-references) updated to match (367 replacements across the 8 plan docs alone).
- `tools/render-deck-pdf/README.md`'s usage examples.
- The dev Moodle instance: all 39 section display names and all 31 already-uploaded resources' `mdl_resource.name` field. Section **number** (1-39) was deliberately left unchanged — only labels moved, so no uploaded content had to be relocated between sections. Full detail: `07-infrastructure/moodle-course-shells.md`'s new "Renumbering" section.
- `populate-seminar3-resources.php` updated to match `unit-NN-*` filenames going forward (target section = unit number + 1) rather than `week-NN-*`.

**Deliberately not touched:** Quarter-level date ranges (Quarter 1: Aug 24 – Oct 23, etc.) — those are real grading-period boundaries, not part of the per-unit sequence being decoupled from the calendar. Also not touched: historical entries in this file and in `worklog.md` that refer to "Week N" — those describe what was true at the time under the old naming and aren't being rewritten after the fact.

**Supersedes:** the calendar-week-based numbering used throughout Seminar III's source docs and file naming since the course was first scoped (2026-08-24) through the 2026-08-25 restructure.

---

## 2026-08-29 — Moodle production host resolved to NTC Hosting; dev-droplet course shells built for all 4 courses

**Context:** Jay asked to continue the Moodle resume from 2026-08-28 by connecting a newly-registered domain (`foxcs.online`). That surfaced two things: the domain wasn't actually registered yet (confirmed via direct RDAP query against Radix, the `.online` registry — "available for registration" — then confirmed by Jay: "it is hosted but not registered"), and the production-host question flagged as unresolved in `moodle-vm-setup.md` needed an answer before DNS could mean anything.

**Decided:**

- **NTC Hosting (a shared hosting account Jay already has, confirmed by him as Moodle-5.2.2-ready despite being the basic plan) is the production Moodle host.** The `foxcs-droplet` stays build/dev-only, unchanged from the 2026-08-28 decision — nothing here reverses that.
- **Domain registration is blocked on payment**, which Jay can't complete until 2026-08-30. Plan once paid: register `foxcs.online` **through NTC Hosting directly** (same provider as the hosting account) so nameservers auto-configure, rather than registering elsewhere and manually pointing NS records. Jay separately provided NTC's standing NS records (`dns.ntchosting.com`/`dns2`/`dns3`/`dns4`, default route `198.23.48.50`, shared SSL IP `162.210.96.119`) in case that changes.
- **Browser automation isn't available in this session even though Jay's Claude in Chrome extension is active locally** — this Claude Code session runs directly on the `foxcs-droplet` (confirmed via `hostname`), a remote SSH-based session the local extension can't pair with. Confirmed via `ToolSearch` returning zero `mcp__claude-in-chrome__*` tools here. Registrar/cPanel work in this session has to be a manual walkthrough (Jay reports what he sees, told what to click) until/unless a Claude Code session running on Jay's own machine picks up that part.
- **Built Moodle course shells for all 4 FoxCS courses on the dev instance**, at Jay's request ("let's build the shell for all classes") ahead of hosting being ready, so courses are structurally ready to receive content and/or migrate once NTC Hosting is live: one `FoxCS` category, 4 `topics`-format course shells (`foxcs-python` 21 sections renamed to the real Unit 00-20 titles, `foxcs-seminar3` 39 sections renamed to the real Week 1-39 titles, `foxcs-game2`/`foxcs-webdev` left as single-section skeletons since neither has a `course-plan.md` yet). Full detail and the scripts used: `07-infrastructure/moodle-course-shells.md`.
- **Uploaded Seminar III's existing real content** (decks, instructional pages, printable sheets) into the matching week sections as File resources — nothing invented, only what the repo audit in `worklog.md` already confirmed exists. Teacher decks and the one existing answer-key doc were uploaded **hidden** (`visible=0`) rather than trusted to a "don't look" convention, since students could otherwise open a deck's speaker-note script or an answer key directly.
- **Found and documented a real infrastructure gotcha:** `/home/jay` (where this repo lives) is `750 jay:jay` — `www-data` can't traverse into it at all, so any Moodle CLI script or upload that needs to read a repo file has to stage it in `/tmp` first. Chose not to loosen `/home/jay`'s permissions to fix this — too broad a change for a narrow need. See `07-infrastructure/moodle-course-shells.md`'s "Known gotcha" section.

**Not yet done:** actually registering the domain (blocked on payment), custom Moodle theme/branding, enrollment/roles, H5P-native content (vs. the uploaded static HTML), any content for Game II/Web Dev/most of Python (doesn't exist in the repo yet), migrating any of this dev-instance work to NTC Hosting once it's live.

**Supersedes:** nothing — this extends the 2026-08-28 Moodle-resumed decision and resolves the "production hosting target not yet decided" gap it explicitly left open.

---

## 2026-08-28 — Moodle resumed, build/dev instance stood up on the FoxCS droplet

**Context:** Jay asked, from a Claude Code session running on the `foxcs-droplet` (see `07-infrastructure/droplet-setup.md`), to resume Moodle work and stand up a real running instance — reversing the 2026-08-04 pause, which had held Moodle back pending a proven MVP folder/Classroom content-and-grading loop. Confirmed explicitly (not assumed) before proceeding, since it directly reverses a documented decision.

**Decided:**

- **Moodle resumed as of today**, ahead of the MVP loop being fully proven. The MVP folder/Classroom track is not abandoned or paused by this — both tracks are active in parallel.
- **This droplet is build/dev-only, not the production host.** Jay's stated intent: build the Moodle side here (themes, plugins, course structure, H5P content, iframe-embedded interactive components pulled from this repo's component library), then host the real student-facing instance somewhere else once ready. Which host that will be is not yet decided — see `07-infrastructure/moodle-vm-setup.md`'s Known gaps.
- Installed a fresh Moodle **5.2.2+ (Build: 20260818)** instance (latest stable branch, `MOODLE_502_STABLE`) directly on the droplet: Apache + PHP 8.3 + MariaDB, source cloned to `/var/www/moodle`, data at `/var/www/moodledata`. Full stack/paths/gotchas documented in new `07-infrastructure/moodle-vm-setup.md`.
- **This is a third, separate Moodle instance** — distinct from Jay's local Windows install (`C:\Users\Jay Fox\server\moodle`, 5.3dev) referenced in this file's Moodle-role history. None of the three share a database or content.
- Corrected a version mismatch: Jay referred to "Moodle 5.5.5+" when asking for this to be set up. **No such version exists** — `git ls-remote` against `moodle/moodle` shows the latest stable branch is 5.2 (tags through v5.2.2). Installed 5.2.2 instead and flagged the discrepancy rather than guessing at a nonexistent target.
- Firewall: briefly opened `ufw` for 80/443 at Jay's explicit confirmation to test public reachability, then closed again once Jay clarified the droplet is dev-only — confirmed closed via an external fetch (not a self-curl to the droplet's own public IP, which is misleading due to how Linux routes traffic to a box's own address over loopback).

**Not yet done:** TLS/domain, admin password rotation, DB/moodledata backups, choosing the production host, migrating anything built here to it. See `07-infrastructure/moodle-vm-setup.md`.

**Supersedes:** the 2026-08-04 "Moodle paused" status in this file's Status and Platform Decisions sections, updated to match.

---

## 2026-08-18 — Academic integrity policy substantially expanded; Web II cert order corrected; MakeCode avatar mechanics researched

**Context:** Continued the same day's work — Jay dictated a full academic integrity policy, corrected the Web II certification required/encouraged order, and asked for real (not fabricated) MakeCode Arcade avatar instructions.

**Academic integrity — `01-privacy-and-governance/academic-integrity-ai-use.md` substantially rewritten**, scope widened from "AI use" specifically to the full academic integrity policy (doc kept its filename/title, scope note added). New content, all per Jay directly: the core principle (do your own work; you won't learn otherwise; the material is genuinely hard because it's a new language); why being present matters given how much content these courses cover; partner-work rules (partners work together; if one partner ends up doing all the work, only that partner earns credit, the other restarts solo); the peer-help boundary (explain *how*, never hand over code to copy/paste — the helper is as accountable as the copier); a sharpened AI-use statement (AI will never do the work *for* a student; a future permissive phase exists but only when Jay explicitly states it); unified consequences for every violation category (call/email home + Aspen write-up + a 0%/F that cannot be made up, applied to every involved party); and a partial-credit philosophy (genuine effort always beats a cheated 0, even when the honest attempt is wrong).

**Shared Unit 0 spine restructured** (`00-project-overview/shared-unit-00-onboarding.md`) to give this real space: **new 00.8 "Academic Integrity: Doing Your Own Work"** lesson, fully shared, no L1/L2 split — previously this was folded into 00.7 Getting Unstuck as a minor aside, which undersold how much Jay wants this covered. Choosing Your Pathway renumbered from 00.8 → **00.9** (L2 only). Folder-tree sketch updated to match.

**Web II certification order corrected** (`courses/web-dev/course-plan.md`, `courses/web-dev/CLAUDE.md`): the starter-context course map states HTML5 Application Development as required and JavaScript as encouraged. Per Jay, **that's backwards from the real prerequisite structure — JavaScript certification is a prerequisite for HTML5 Application Development.** Corrected to: **JavaScript required/mandatory**, **HTML5 Application Development encouraged and gated by the JS prerequisite**. The exam-timing sequence already in the course-plan (JS attemptable after Unit 15, HTML5 App Dev after Unit 20/21) needed no change — only the required/encouraged labels were swapped. Flagged, not yet written: the Unity Artist "achievable, not guaranteed, tied to effective time use" tone (confirmed earlier today) likely applies to HTML5 App Dev now that the shape of the two situations matches.

**MakeCode Arcade avatar mechanics — real research done, replacing placeholder uncertainty** (`00-project-overview/kickoff-avatar-and-intro-activity.md`): web search (not fabrication) confirmed **500×500 is MakeCode Arcade's own actual documented maximum image size** — not an arbitrary number, so "size up to the max" and "500×500" are the same instruction. Also confirmed and sourced: changing the color palette (Assets tab → Colors button → pick/build a palette, up to 15 colors + transparent → Apply) and canvas resizing (a resizable marquee in the image editor). Official keyboard shortcuts pulled from `makecode.com/asset-editor-shortcuts`. **Update, later same day: fully resolved.** Jay walked through the actual export path himself and captured every step as a screenshot (`makecode images/`, 8 PNGs + his own example) — full 9-step sequence now in the activity doc's Part 1. One correction from this: **the exported file is a `.bmp`, not a PNG** — every `avatar.png` reference elsewhere in this repo is stale and should read `avatar.bmp`.

---

## 2026-08-18 — Navigation overhaul: menu links, group nesting, and a reusable authoring standard

**Context:** Jay asked for a subagent-driven navigation consistency pass, real lesson names in nav text, and a way to jump around the unit without strict linear movement. Mid-pass, several more fixes queued up: a policy leak, warmer pathway-choice framing, labeled diagram nodes, wording fixes, and a missing-nav bug on the hub page itself.

**Two parallel forks did a full navigation pass**, one per edition (`bc269e3` Level 1, `fde3312` Level 2, both reconciled and included in this push): fixed inaccurate next/previous claims (2 new real bugs found beyond the 2 already known — 0.8's "next" pointed at the overview instead of 0.9 in Level 2; the overview page's own 0.2 description was stale), replaced generic "Continue to the next lesson" link text with real lesson names everywhere, and added a "Unit 0 Menu" link to every single page so cross-lesson navigation isn't strictly linear.

**Verified the two editions' shared lessons actually stayed in sync** after both forks worked independently — confirmed 0.2/0.4/0.5/0.7 fully identical (a scary-looking full-file diff turned out to be pure CRLF line-ending noise, not real divergence), 0.8 differs only in its legitimate structural next-link (Level 1 ends there, Level 2 continues to 0.9), and found/fixed one small gap (Level 2's 0.8 was missing the `.page-nav-menu` CSS rule the link depended on).

**Nested group structure added, both to the hub page and every individual lesson**: four labeled sections (Getting Started / Thinking Like a Builder / Working With Others / Choosing Your Path for Level 2 only) replace what was one flat undifferentiated list. Each lesson now shows a small group-tag label above its title so a student always knows where they are in the unit's overall arc, not just which single lesson they're on.

**Fixed the hub page's own missing navigation** — `unit_00_overview.html` had no footer nav at all, a real dead-end Jay caught. Added a prominent "Start Lesson 0.1: Welcome →" call to action.

**Additional fixes found and applied during the same pass:**
- Level 2's `0.9` still named "Reinforce/Core/Extend" in its "How They're Alike" list — a leftover from before that policy changed. Fixed to generic language.
- `0.9`'s pathway-fork diagram now has real labels ("You" at the top node, "Web Dev" and "Game Design/Unity" at the branch ends) instead of relying entirely on surrounding text.
- The "This choice isn't about which class you're in" framing rewritten warmer and more specific: Game II and Web II share the same room and period (a real scheduling fact, now saved to memory), not just a cross-enrollment policy — the goal is students feeling excited about their choice, not just permitted to make it.
- "If You're Leaning Web Dev" / "...Game Design/Unity" changed to "Leaning Toward" for clarity — flagged as too conversational for written instructions.
- `0.6`'s "This Isn't Just for Code" pro-tip now includes non-coding examples (a recipe, directions, a schedule), not just other tech examples.
- `0.3` (Level 2) now includes a real copy-pasteable HTML sample for students who don't remember any HTML yet, plus the missing `<pre>` CSS and the bolded `Ctrl+S` shortcut it was missing.
- **The kickoff `02_self_intro_slide.html`'s embedded "TEACHER TO-DO, not shown to Learners once filled in" box removed from both editions** — resolved per Jay: each student creates their own individual Google Slides file, not a shared class deck. This pattern (a teacher-only placeholder left inside a student-facing file) is now a documented standing rule, not just a one-off fix — see the new memory below.

**New standing memories saved:**
- Student-facing FoxCS content must always be immediately deployable with zero review — no embedded "TEACHER TO-DO" notes; surface teacher action items in chat instead.
- Game II and Web II share the same room/period — a physical fact, not just a policy, that should keep shaping how pathway choice is framed.

**New reference doc: `02-authoring-system/lesson-navigation-standards.md`** — the page-nav/menu/group-tag pattern written down as a real standard, plus a concrete checklist for what to update whenever a lesson is inserted, removed, or reordered (the exact bug class this whole session's cleanup was fixing by hand). Applies to Units 1+ in every course, not just Unit 0.

---

## 2026-08-18 — Large accuracy/clarity/policy pass across Unit 0

**Context:** Jay reviewed the built Unit 0 content directly and flagged a real cluster of issues: a genuine policy reversal on Reinforce/Core/Extend transparency, a Level 1/Level 2 content-leakage bug, several factual inaccuracies, ELL-accessibility idioms, and missing detail. All fixed and verified in-browser.

**Reinforce/Core/Extend is no longer taught to students, policy change:**

- **New rule, documented in `02-authoring-system/objectives-and-skills-proficiency.md` and `content-voice-and-tone.md`**: the R/C/E practice-routing system is internal only. Never name it, diagram it, or explain its mechanism to students — even a visible per-item label is discouraged. Per Jay: naming the tier risks a student reading themselves as "at a lesser level," which cuts against the whole growth-mindset framing this repo is built around.
- **Lesson 0.2 rewritten, both editions**: the explicit "Reinforce, Core, and Extend" section (with its named ladder cards and staircase diagram) is replaced with lighter, mechanism-free language about practice adjusting to what a student needs — same growth-mindset message, no exposed system.

**Level 1/Level 2 content leakage fixed — a real bug, not just polish:**

- Several of the "fully shared" lessons (0.2, 0.4, 0.5, 0.6, 0.8) named Unity, Python, JavaScript, or HTML/CSS specifically in their examples, which is fine for edition-specific lessons (0.1, 0.3, 0.9) but breaks the Level 1-never-sees-Unity / Level 2-never-sees-Python rule for lessons meant to be byte-identical across both editions. Fixed by genericizing every example in the shared lessons (e.g. "a game engine" instead of "Unity," "your code" instead of "a Python program") — per Jay's own guidance on how to phrase this.

**Factual accuracy fixes:**

- **Software is pre-installed, not something students install.** Lesson 0.3 (both editions) rewritten from "install Python/VS Code/Unity" instructions to "confirm it's already installed and working" — Jay installs everything beforehand.
- **Cross-lesson references corrected**: 0.4 said "the next lesson (Getting Unstuck)" when Getting Unstuck is actually Lesson 0.7, not immediately next — changed to "a future lesson." 0.6 said "the previous lesson" for Troubleshooting (0.4) when 0.5 actually sits between them — changed to name the lesson number directly instead of claiming adjacency. General rule going forward: never say "next/previous lesson" unless it's actually the literal next/previous one; name the lesson number when it isn't adjacent.
- **Keyboard shortcuts now bolded** (e.g. `**Ctrl+S**`) so they stand out from surrounding prose.

**ELL-accessibility language pass:** removed figures of speech that don't translate well for English Language Learners — "it clicks" (0.2, both instances), "hit a snag" (0.6) — replaced with plain, literal phrasing ("you understand it," "before you even run into a problem").

**Content additions:**

- **Peer help reframed as a good first option** (0.7), not a fallback behind the teacher — explicitly tied to "knowing how to ask well," per Jay.
- **Abstraction Micro Diagram (0.5) refined a second time**: now shows a few faded details *inside* the box (some complexity exists but isn't the focus) alongside the ones already outside it (details left out entirely) — Jay wanted both, not just outside.
- **0.8 Academic Integrity**: added a bold lead sentence ("To start the year, we will not be using AI in our work") and the specific consequence detail that an Aspen-logged incident leads to a conversation with a member of the school's Disciplinary Team.
- **Kickoff avatar instructions corrected**: students type `avatar` as the filename; MakeCode's own save dialog appends `.bmp` automatically, producing `avatar.bmp` — the earlier instruction had them typing the full `avatar.bmp` including the extension, which isn't how the save dialog actually works.

**Not yet done, explicitly deferred to its own phase, not squeezed into this pass:** a short check-for-understanding quiz (3-5 questions) between lessons, a vocab quiz plus a harder scenario-matching exercise wherever terms are introduced, and an unsaved-changes save-prompt on the page-nav links for any page with real student input. These need real interactive-component design, not a quick text edit — see the next work session.

---

## 2026-08-18 — Six more Micro Diagrams added across Unit 0, both editions

**Context:** Jay asked to keep going through the rest of Unit 0's terms using best judgment, push everything, and be able to walk away.

**Built, all following the new Section 21 SVG recipe, all verified in-browser:**

- **0.5 Computational Thinking**: Pattern Recognition (two matching boxes with identical dot patterns, connected by a dashed line, green checkmark), Abstraction (a box with faded/hidden internal detail and one arrow in, one arrow out), Algorithmic Thinking (four connected steps, the last one checkmarked).
- **0.2 How Learning Works**: an ascending three-step staircase for Reinforce/Core/Extend, placed right before the existing ladder cards.
- **0.4 Troubleshooting Is Learning**: a magnifying glass focused on one marked spot on a line — deliberately not a literal bug icon (avoids a crude/juvenile hand-drawn insect), still reads as "finding exactly where the problem is."
- **0.9 Choosing Your Pathway (Level 2 only)**: one path forking into two, colored to match the existing Web Dev (blue) and Game Design/Unity (purple) pathway boxes already on that page.

**Deliberately skipped, judgment call, not oversight:**

- **0.1 Welcome's MDA terms** (Mechanics/Dynamics/Aesthetics) — these are abstract design concepts, not structural/container concepts like a variable or a box splitting apart. Forcing a box-metaphor onto "a feeling the game gives you" risked landing cutesy (a heart/star icon) rather than mature, which the image guide explicitly warns against. Left for a later, more deliberate pass rather than a weak version now.
- **0.6 How Problem-Solving Works' five-step process** — five distinct steps each carrying real meaning doesn't fit the Micro Diagram tier's "one metaphor, 0-2 labels" limit. This is what the full Process/Sequence template family (Section 10.5) exists for; illustrating it properly is future work, not a Micro Diagram.
- **0.7 Getting Unstuck** and **0.8 Academic Integrity** — the former's "ask a peer for help" concept is hard to render abstractly without human figures (which the guide also cautions against); the latter is a serious-toned policy lesson where a decorative diagram would undercut the tone, not support it.

**Every fully-shared lesson kept in sync across both editions** (0.2, 0.4, 0.5 edited once, copied into both `unit_00_onboarding_level1/` and `_level2/`).

---

## 2026-08-18 — Micro Diagram production proven and documented as a repeatable SVG recipe

**Context:** Continued the same day's image-guide work — Jay asked to actually see a lesson with real embedded images, then specifically a variable-as-box example, then a written spec for reproducing the technique.

**Decided/built:**

- **Clarified a real capability gap directly with Jay**: Claude has no image-generation capability at all (not a tool being underused — it doesn't exist), and the only image-adjacent tool available (Canva) is built for marketing documents, not precise semantic-color technical diagrams. Hand-coded inline SVG was proposed as the practical alternative for the Micro Diagram tier specifically, and confirmed as "okay" by Jay.
- **Two real Micro Diagrams built and verified in-browser**: Decomposition (deployed live in Lesson 0.5, both editions) and Variable (`score` box, `100` inside, arrow in — matching Jay's own original example from earlier in the day). Both use the guide's exact hex tokens, not eyeballed colors.
- **New reference tool: `02-authoring-system/illustration-examples-gallery.html`** — same status/purpose as `component-library/index.html` (a proof-before-deploying reference page, not lesson content), showing both examples with their real semantic-color/composition rationale.
- **New `instructional-image-guide.md` Section 21, SVG Production Recipe for Micro Diagrams** — a concrete, repeatable spec extracted from actually building the two examples: canvas/coordinate conventions, the box/arrow/label recipes with exact hex values and size ranges, the embedding wrapper pattern (including required `role="img"`/`aria-label`), a QA checklist, and where new vs. deployed examples belong. Appended as a new section rather than inserted earlier, to avoid renumbering Sections 1-20 which are already cross-referenced by number elsewhere in this repo.

---

## 2026-08-18 — Instructional image guide adopted, new Micro Diagram tier added

**Context:** Jay dropped a comprehensive starting-point image guide (`starter context/FoxCS_Instructional_Image_Generation_Guide.md`) to address a real problem: current lesson pages read as walls of text, and Jay wants small, focused illustrations woven in, not dense anchor-chart-style graphics.

**Decided/built:**

- **Adopted as the canonical illustration standard.** Moved to `02-authoring-system/instructional-image-guide.md`, superseding the older `image-style-guide.md` (a thinner, validated-categorical-6-hue palette built for a since-paused Moodle/H5P color conflict that no longer applies). Old file kept as a superseded stub pointing to the new one, not deleted — same pattern as every other superseded doc in this repo.
- **New Section 10.7, Micro Diagram, added** — the real gap Jay identified: every existing template family (even "Low Density") is a standalone teaching artifact with a title, definition, code panel, and takeaway footer. None of them fit "a labeled box with an arrow showing something being stored," embedded inline next to the sentence that describes it. Micro Diagram is the smallest tier: one visual metaphor, 0-2 short labels, explicitly no title/code/takeaway/corner-label. Added supporting updates to the density-rules section (new "Micro Density" tier), the production-prompt section, the metadata schema, the file-naming convention, and the nonnegotiable-rules list.
- **Size resolved through back-and-forth with Jay**: not icon-scale — a real illustration, ~700-760px wide (matching the lesson content column's own `max-width: 760px`), with genuine padding around the metaphor inside that frame, not the shape stretched edge to edge.
- **Production method**: still AI-generated (following the guide's existing art-direction/prompt system), not hand-coded SVG — Jay's size clarification (a real illustration, not a tiny icon) argued against hand-coding, since matching the guide's soft-shaded flat-vector style convincingly by hand isn't practical at that scale.
- **Confirmed**: this guide (and all of `02-authoring-system/`) is teacher/authoring-side material, never distributed to students. Only the finished generated image files (plus required alt text) land in a lesson's real `content/` folder.

**Not done yet:** no lesson HTML (Unit 0 or Python's Unit 01) has any real illustrations embedded per this guide yet — the guide existing doesn't retrofit existing pages. That's a real next step, not automatic.

---

## 2026-08-18 — Shared Unit 0 built (both editions), plus a pathway-comparison lesson

**Context:** Jay asked to build real Unit 0 HTML for all three courses, and to fill in the per-unit journal-thread lines for Game II and Web II first (both done via parallel forks earlier the same day — see the "throughline frameworks" entry above). Also asked, mid-build, for Lesson 0.9 to include a real comparison of the two Level 2 pathways.

**Decided/built:**

- **Two-folder decision confirmed and built**: `shared/unit_00_onboarding_level1/` (Game I) and `shared/unit_00_onboarding_level2/` (Game II + Web II), matching the two-real-editions plan from earlier the same day (not one shared file with labeled boxes — Game I must never see Web/Unity content, full stop).
- **All lessons built and verified in-browser** (local HTTP server + Chrome screenshots, not just written blind): 0.1 Welcome (edition-specific — L1 gets the full MDA framework intro, L2 gets pathway-choice framing without naming pathways in depth yet), 0.2 How Learning Works, 0.3 Using Your Tools (edition-specific — L1 is Python/VS Code only, L2 sets up both Web Dev and Game Design/Unity tooling since the pathway isn't chosen yet), 0.4 Troubleshooting Is Learning, 0.5 Computational Thinking, 0.6 How Problem-Solving Works, 0.7 Getting Unstuck, 0.8 Academic Integrity (the full expanded policy from `01-privacy-and-governance/academic-integrity-ai-use.md`, translated into real student-facing copy), and 0.9 Choosing Your Pathway (L2 only).
- **0.9 now includes a real "How They're Alike / How They're Different" comparison**, per Jay's request, so a student can make an informed, comfortable choice: alike on being project-based, leading to a cert, centering a real user/player, using the same Reinforce/Core/Extend and troubleshooting processes, and eventually offering open-ended project choice; different on entry diagnostics (Web Dev has one, Game Design/Unity doesn't, since Unity is new territory for nearly everyone), pacing shape (steady climb vs. a big 2D-to-3D shift), and total unit count (21 vs. 29). Grounded in the real course-plans, not invented.
- **The kickoff avatar + self-intro activity, built earlier the same day, duplicated into both editions** (`kickoff/`) rather than left in its placeholder location.
- Both editions' content matches `content-voice-and-tone.md` (Learner-facing tone, no em dashes, calm/supportive framing) and the established plain-styling visual pattern from Python's Unit 01.

**Not done yet:** flashcards/vocab-quiz/practice/mastery-check/feedback pages for Unit 0 (deliberately skipped — Unit 0 has no code to drill yet, instruction-only pages fit what it actually is); linking each course's `course-plan.md` to the real built path; any real classroom distribution.

---

## 2026-08-18 — Corrected post-AP-testing pacing framing; designed cross-course MakeCode avatar kickoff activity

**Context:** Jay corrected a mischaracterization from the 2026-08-17 pacing constraint, then gave a new cross-course activity to design.

**Corrected:**

- **The AP-testing/senior-checkout window is not a call for "low-stakes" or filler content.** Per Jay: students should be working on real projects during this stretch. The 2026-08-17 pacing constraint (`CLAUDE.md`'s Hard Constraints) and every doc that echoed its "lower-stakes, high-engagement" phrasing (`open-questions.md`, `courses/python/course-plan.md`, `courses/game-programming-2/course-plan.md` and `CLAUDE.md`, `courses/web-dev/course-plan.md` and `CLAUDE.md`) are corrected: the reason project-based work fits this window is **delivery independence** (it doesn't require fresh full-class direct instruction or full attendance to progress), not reduced rigor.
- **Game I's post-capstone MakeCode Arcade work is not a wind-down or busywork activity.** Per Jay directly: it's meant as a real, rigorous test of applying a full year of game-design/programming skills in a faster prototyping environment. `courses/python/course-plan.md`'s "Post-Capstone: MakeCode Arcade" section is corrected accordingly.

**Designed (new, not built):**

- **A universal kickoff activity, all three courses, no Level 1/Level 2 split** — see `00-project-overview/kickoff-avatar-and-intro-activity.md`. Every student creates a personal avatar in **MakeCode Arcade** early in the year (introduced specifically for this, unrelated to Game I's/Game II's later real uses of the same tool), exports it as a fixed `avatar.bmp` (corrected same day — MakeCode's export is `.bmp`, not `.png`) at exactly 500×500px into a predictable folder location, then builds one **Google Slides** self-intro slide (grade, hobbies, favorite game — any kind, not just video games — what they're looking forward to) using that avatar.
- **This is a surprise**: Jay intends to get the avatars printed. Not to be disclosed in student-facing instructions — flagged as an authoring caution in the design doc.
- **Not yet verified**: MakeCode Arcade's actual image-export/scaling mechanics (its native canvas is small pixel art; whether it can export directly at 500×500 or needs a separate upscale step is untested) — explicitly flagged not to be written into real student instructions until someone actually walks the export path, consistent with this repo's existing "prove a mechanic before deploying" principle (`02-authoring-system/mvp-unit-folder-structure.md`'s Component Library section).
- Cross-linked from `00-project-overview/shared-unit-00-onboarding.md` as a pre-spine activity.

---

## 2026-08-18 — Unity certification framing confirmed, with a supportive-but-honest time-use warning

**Context:** Jay confirmed the Unity cert recommendation from 2026-08-17 (Programmer required, Artist encouraged) and gave specific guidance on how the Artist credential should be framed to students.

**Decided:**

- **Unity Certified User Programmer** — required/mandatory credential for Game Design/Unity pathway students. Unchanged from the 2026-08-17 recommendation, now confirmed rather than pending.
- **Unity Certified User Artist** — **achievable, not guaranteed.** Every student is expected to engage with Artist-track content throughout the year; a student who keeps herself moving and uses class time well has a real opportunity to finish both credentials. Completion is explicitly contingent on effective time use, not promised regardless of effort.
- **Tone, per Jay directly:** supportive, not a threat. Paired with an honest warning that every year some students don't complete available content — not from lack of ability, but from misusing class time (playing unrelated games, doing work for other classes during work time). Students should hear both halves: real encouragement to go for the second credential, and a clear-eyed statement that the content won't wait if class time gets misused.
- Recorded in `courses/game-programming-2/course-plan.md`'s and `CLAUDE.md`'s Certification Framing sections. **Not yet written as actual student-facing lesson content** — this is the internal decision and intended tone, still needs a real home (likely Unit 01's orientation content, not the pathway-agnostic shared Unit 0).
- **Flagged, not yet applied:** Web Dev's JavaScript-encouraged credential likely deserves the same "achievable with good time use, not guaranteed" framing. Not extended there yet.

---

## 2026-08-17 — GitHub repo created, shared Unit 0 architecture decided, Game II/Web II starter content added

**Context:** Jay is resuming work on Game II and Web II (previously just placeholders in `courses/`), wants a single onboarding unit that reads the same across all three courses, and wants the whole `FoxCS/` repo pushed to GitHub so work can continue from any machine.

**Decided/built:**

- **GitHub repo created**: `jalex929/FoxCS`, **private** (contains mastery-check answer keys and other assessment content that must never be public-visible, per `CLAUDE.md`'s "Protecting Assessment Content" section). `git init` + full initial commit + push, including the large licensed reference PDFs and support files (~460MB total) — pushed as a private repo for Jay's own multi-device access, not redistribution. `origin` set to `https://github.com/jalex929/FoxCS.git`, default branch `main`.
- **New `starter context/` folder added by Jay**: LearnKey/Certiport-aligned student workbooks and support files for JavaScript (INF-302) and HTML5 Application Development, Unity certification exam objectives (Programmer, Digital Artist — no Unity workbook exists), and two pre-drafted course maps (`Web_Development_Course_Map_Certification_Aligned.md`, `Unity_Game_Development_Course_Map_Certification_Aligned_Complete.md`). These are the source material for Game II's and Web II's `course-plan.md`, the same role `Python_v2_Student_Workbook.pdf` plays for Game I. Not yet digested into either course's own `course-plan.md` — see each new course's `CLAUDE.md`.
- **Shared Unit 0 architecture decided** — full design in `00-project-overview/shared-unit-00-onboarding.md`. Summary: one shared onboarding unit, authored once, delivered as **two editions**, not three separate per-course units:
  - **Level 1** (Game I only): Python pathway only, matches Game I's existing single-pathway model.
  - **Level 2** (Game II **and** Web II, treated as one shared cohort for Unit 0 only): both Web Dev and Game Design/Unity pathways shown to every Level 2 student, regardless of which of the two courses she's actually enrolled in. This is what lets a student enrolled in both Game II and Web II choose to go deep on one pathway or split across both, rather than being locked to "her course's" pathway.
  - **Pathway choice is not tied to course enrollment.** Reinforced by Jay same day: a Game II student may choose Unity or Web Dev; a Web II student may equally choose Unity or Web Dev. Neither pathway "belongs" to one course — a dual-enrolled student (both Game II and Web II) is just the clearest illustration of this, not a special case. How Units 1+ actually get delivered for a student whose chosen pathway doesn't match her course's "default" isn't resolved — flagged in the design doc's Open Items.
  - Pathway scope kept deliberately narrow for now: Web Dev = HTML/CSS/JavaScript only, **no PHP or backend/app-dev mention in onboarding** (may come later in Web II's real course-plan if it actually happens — don't promise it to students early). Unity = game dev in Unity/C#, no JS-vs-Unity nuance explained at the onboarding level.
  - Relevance marked via **inline labeled callout boxes** on one linear page (not a branching picker) — "Python Pathway"/"Web Dev Pathway"/"Unity Pathway" labels, reusing the existing component-library visual language.
  - Physically lives in a new shared location (`shared/unit_00_onboarding/`, not yet created), not duplicated into each course's `content/` tree.
- **Certification framing for the year, captured for future course-plan work (not yet built into any course-plan.md):** one certification is the mandatory floor per pathway; a second is encouraged where the pathway supports it (matches the Web course map's existing "required HTML5 App Dev + strongly encouraged JavaScript" framing). Game I is the exception — one certification (IT Specialist Python), then the course moves on to **MakeCode Arcade** for 2D projects rather than pursuing a second cert. Which Unity certification (Programmer vs. Digital Artist) is the mandatory one for Game II isn't decided yet — see `open-questions.md`.
- **New course folder skeletons created**: `courses/game-programming-2/` and `courses/web-dev/`, each with a `CLAUDE.md` stub following the same pattern as `courses/python/CLAUDE.md`. Neither has a `course-plan.md` or any `content/` yet — digesting the starter-context course maps into a real unit/lesson checklist (matching `courses/python/course-plan.md`'s format) is the next real work item for each.

**Pathway naming reinforced same day:** the Level 2 pathway formerly called just "Unity" is renamed **"Game Design/Unity"** throughout the shared Unit 0 doc, both course `CLAUDE.md` files, and `courses/game-programming-2/course-plan.md`'s intro — per Jay, both Level 2 pathways (Web Dev, Game Design/Unity) should be understood as options available to *either* Level 2 class period's students, and the pathway name shouldn't read as tied to one course. The `game-programming-2/` folder name itself is unchanged (an internal repo path, not the student-facing pathway name).

**Not done yet, flagged so it isn't lost:**

- The actual shared Unit 0 instructional HTML — outline only, see the design doc's own Open Items.
- `courses/python/course-plan.md`'s existing Unit 00 section still describes its own standalone Python-only Unit 00 — not yet rewritten to point at the shared unit instead.
- `course-plan.md` for Game II and Web II, built from the new starter-context material.
- Reconciling the starter-context Web course map's own "Web Development I / Web Development II" framing (one continuous course with an acceleration path) against `CLAUDE.md`'s existing Courses table, which currently treats "Web Dev"/"Web II" as a single FoxCS course with no "Web I" — not a contradiction necessarily, but worth a deliberate read-through before course-plan.md gets written.

---

## 2026-08-11 — Table of contents + Back/TOC/Next nav, vocab quiz check-then-grade redesign, feedback form idiom/recall fixes, two authoring bugs fixed

**Context:** Continued direct review of Lesson 01.4's real content (`lesson_01_04_printing_output/`). Several separate but related fixes in one stretch: navigation structure, one page's grading model, another page's question design, and two content-quality bugs caught by inspection.

**Decided/built — navigation:**

- **New `00_table_of_contents.html`**, the lesson's real entry point from now on, replacing a pure linear "Next: →" chain as the only way to move through the lesson. Lists every numbered file with a one-line description and a direct link. Includes a **"Check My Progress"** control using `showDirectoryPicker()` (File System Access API, same family as the `showSaveFilePicker()` already used for save-in-place) to scan a student's own copy of the folder for `_completed`-suffixed files and mark those steps done — read-only, filenames only, nothing opened or changed. `.py` files can't be included in this scan (no renaming mechanism available to them, per "No Self-Naming" — see `mvp-unit-folder-structure.md`'s new "Table of Contents" section for the full writeup, including why a size/mtime heuristic was rejected as unreliable).
- **The `_completed` save-suffix convention (introduced 2026-08-06 for `04_vocab_quiz.html` only) is now applied to every saved page in the lesson**: `05_practice.html`, `09_mastery_check.html`, `11_feedback.html`. This is specifically what makes the table of contents' folder scan possible across the whole lesson, not just one page.
- **Every numbered page's footer now anticipates three destinations, not one**: back to the previous page, back to the table of contents, or forward — a `.page-nav-prev` / `.page-nav-toc` / `.page-nav-next` row, applied to `01_instruction.html`, `03_flashcards.html` (previously had no footer nav at all), `04_vocab_quiz.html`, `05_practice.html`, `07_project.html`, `09_mastery_check.html` (previously had no footer nav at all — added outside the password-locked content block, since a student should be able to navigate away without entering the password), and `11_feedback.html` (previously a single bare "Continue to Lesson 01.5" link, not a real nav row).

**Decided/built — vocab quiz (`04_vocab_quiz.html`) redesigned from auto-grade to check-then-grade:**

- Placing a term into a slot (drag or click) is now **tentative** — no grading happens on drop anymore. A new **Check Answers** button grades everything currently placed at once: correct pairs lock in, wrong pairs bounce back to the bank. Reasoning: it's a quiz, and a quiz should let a student see their attempt before finding out if it's right, not auto-grade the instant something lands in a slot.
- **Every Check click is now logged** to the page's hidden telemetry block (same mechanism as `05_practice.html`) — attempt number, and exactly which term was placed in which slot and whether it was correct. Answers the standing "how many times did they need to attempt it, and what were the attempts" question, which the old auto-grade version had no way to answer (it only ever showed a final state).
- **Save now requires both a full match (5/5) and the reflection textarea having real content** — previously the reflection (added 2026-08-10) was optional and didn't gate Save at all.
- Reflection answers are a flagged future input to the not-yet-built grader — see `05-grader/README.md`'s new note: extract themes across a class's answers, surface effective memory tricks, flag ones worth sharing with the whole class.

**Decided/built — feedback form (`11_feedback.html`) redesigned to remove recall dependency and idioms:**

- The vocab-confusion question used to ask "which terms are still fuzzy for you?" purely from memory. Two problems: **"fuzzy" is an idiom** that doesn't reliably translate for ELL students, and **asking students to recall which terms exist, from memory, to answer a question about them** is exactly the kind of recall-dependency the rest of this lesson was already being fixed to avoid (see below). Replaced with a real checkbox list of the 5 actual terms, each with a short plain-language reminder, plus a mutually-exclusive "None — I can explain all 5" option.
- Added specific-comment follow-ups under the clarity and difficulty rating questions ("if anything was unclear, what was it" / "what was the most difficult part"), instead of capturing only a 1-5 number for those.
- The old combined "name one specific helpful thing, or one specific confusing thing" question is now two separate questions — most rewarding/helpful, and getting help when something was difficult — instead of asking a student to pick one framing to answer.
- Same idiom-avoidance pass applied lesson-wide in wording ("got stuck" → "difficult to understand," etc.) per `content-authoring-standards.md`'s existing "support multilingual learners" rule.

**Decided/built — "don't require recall of a past section" fix, applied lesson-wide:**

- `07_project.html`'s Game Connection card used to say "same idea as the instructional page's Game Connection section" without restating what that idea actually was — fixed to restate the specific-vs-vague-output idea and its concrete example inline, so a student who doesn't remember the earlier page still gets the connection.
- `05_practice.html` Drill 7's prompt used to say "build the pattern from the Sneak Peek section... that section is exactly where to look" — fixed to state the if/indented-line pattern inline instead of only pointing back. Drills 3, 4, and 6's incorrect-answer feedback used to say "look back at the Key Terms section" — fixed to give a self-contained clue instead, since each drill's own prompt already contains the full definition anyway.

**Three content-quality bugs found and fixed, `05_practice.html`:**

- **Drills 1 and 5's block bank re-sorted back to unshuffled order every time a piece was placed or returned.** `renderBlockDrill()` rebuilt the bank by iterating the target array's own definition order on every re-render, discarding the shuffle `initBlockDrill()` had set up initially. Fixed by threading the shuffled order through as a persistent `bankOrder` argument on every render call instead of recomputing from `target` — a taken piece is now just filtered out of that fixed order, and everything after it shifts left, instead of the whole bank re-sorting.
- **Drill 7's block bank wasn't shuffled.** It rendered in `d7Pieces`' own definition order, which happened to already be the exact order both target lines needed — the drill was solvable by clicking top-to-bottom without reading anything. Fixed with a `d7BankOrder` shuffle, same fix pattern already used by Drills 1/5.
- **Drill 8's prompt leaked the answer.** It said "this line has more than one thing wrong with it," while two of the four options were phrased as "X only" — a student could eliminate those two plus "nothing is wrong" from the prompt's own wording alone, without reading the actual broken code. Fixed by making the prompt neutral. **New standing rule added to `content-authoring-standards.md`**: distractors must not be eliminable from a prompt's own wording — read every multiple-choice question as a student who's only seen the prompt and options, not the content, and check whether any option can be ruled in or out before the content is even examined.
- Also toned down Drills 3/4's wrong-answer hints after Jay flagged them as too revealing (an earlier fix pass had added "starts with 'arg' and has 8 letters" style hints, functionally handing over the answer to what's meant to be a recall drill).

**Still open, explicitly not resolved in this pass:** whether practice drills should have real adaptive branching (a hybrid, scaled-down version of the original Waypoint model, not the full one) — see the next entry.

---

## 2026-08-11 (also later) — Browser Python execution design + authoring-flow gap audit

**Context:** Jay asked two separate things in the same stretch: (1) identify real gaps in the authoring process itself, not just content, and note any DOK concerns; (2) explore building the "functional IDE simulation" discussed earlier — real code, real output, robust enough for adaptive practice and MVP testing — explicitly open to standing up a custom API on his portfolio site/GitHub if needed.

**Built:**

- **`02-authoring-system/authoring-flow-gaps-2026-08-11.md`** — a process audit distinct from `open-questions.md` (which is mostly platform/privacy/grading questions). Covers: no content-QA step exists that would have caught this session's own bugs (Drill 8's leaking prompt, the unshuffled banks, the save-serialization data-loss bug); no lesson has ever reached "reviewed/final" status despite the schema defining it; no reusable template has been extracted from the now-proven Lesson 01.4 pattern; the codename-swap and student-copy-export scripts still block any real pilot regardless of content quality; the new mixed-assessment signal in `adaptive-practice-model.md` depends on a grader that's still a placeholder; the File System Access API surface grew again today (`showDirectoryPicker` added on top of the existing `showSaveFilePicker`) with zero real-device testing; DOK levels are still an unpopulated stub; spiral review has a real early-unit material shortage; the mastery-check answer key's existence is unverified. Also captures, in Jay's own framing: he wants **robust, repeatable tests/checks** for content accuracy (answers/hints/option-ordering), ELL/IEP-appropriate language, and whether adaptive practice's Reinforce-lane support gives a real concept breakdown for intervention — none of this exists as a process yet, every catch so far has been one person reading closely.
- **`02-authoring-system/browser-python-execution.md`** — evaluated real in-browser Python execution. **Recommends Pyodide** (WASM CPython, runs entirely client-side, self-hostable) over Jay's own suggested custom-API fallback: Pyodide is the only option that adds zero new network dependency, zero new security/abuse surface, and stays consistent with every "no live backend, no phone-home, self-hosted assets" decision already made this session (telemetry design, save-in-place, self-hosted fonts). The custom-API path is kept explicitly open for later, once a unit needs something Pyodide's package/stdlib coverage genuinely can't cover — not needed for Unit 01. Sketches a new "Run & Check" item type for `adaptive-practice-model.md`'s skill nodes: real code editor, Run button, captured stdout compared against expected output — a genuinely higher-DOK format than anything in Practice today.

**Not built:** either doc is design/audit only. No code was written for Python execution; no gap from the audit was fixed as part of writing it (several already had been fixed earlier the same day, coincidentally, before the audit was requested).

---

## 2026-08-11 (yet later) — Sample-submission test fixture built

**Context:** Jay wants to test `00_table_of_contents.html`'s "Check My Progress" feature against something real before real student submissions exist, and wants the same fixture available later for testing the not-yet-built grader.

**Built:** `05-grader/sample-submissions/PY1-A-DELTA04_lesson_01_04_printing_output/` — a full 12-file copy of Lesson 01.4's folder, hand-edited to look like a real, partially-imperfect student submission (persona: nearing proficiency, strong on basic mechanics, a consistent soft spot around precise argument/output terminology and writing genuinely specific feedback messages, the same thread showing up independently across the vocab quiz, Practice, the mastery check, the project, and the feedback form). Kept under `05-grader/`, not `courses/python/content/`, so it can never be mistaken for real distributable content. Full persona/file breakdown in the new `05-grader/sample-submissions/README.md`.

**Bug caught while building it:** `11_feedback.html`'s `currentFileName()` was never actually updated to add the `_completed` suffix, even though the table of contents' progress scan and this same decisions-log's earlier entry both already assumed it produced `11_feedback_completed.html`. Fixed to match `04_vocab_quiz.html`/`05_practice.html`/`09_mastery_check.html`'s pattern.

---

## 2026-08-11 (even later) — Critical bug: form control state lost on save-in-place; wording/naming/link fixes

**Context:** While planning a realistic test-student sample-submission folder (requested by Jay, to test `00_table_of_contents.html`'s progress check and the future grader), working out exactly what a "saved" file's DOM should look like surfaced a real, previously-unnoticed bug.

**Bug found and fixed:** `outerHTML` serialization (the mechanism every save-in-place page in this lesson uses) does **not** capture a `<textarea>`'s typed value, a `<select>`'s chosen option, a text `<input>`'s typed value, or a checkbox's checked state — all four are IDL properties the HTML spec deliberately decouples from their content/attribute representation, unlike `textContent` or `class` (which do serialize correctly, confirmed still fine for the scale-rating buttons' `.selected` class and the mastery check's hidden timestamp spans). Concretely: a student fills in the vocab quiz reflection, checks feedback-form boxes, or picks a Practice dropdown/types a Practice answer, clicks Save — and every one of those would silently revert to blank/default the next time the file is opened, Jay included. This was a real, live data-loss bug across content already treated as working. Fixed with a `syncFormStateToDom()` helper (copies live `.value`/`.checked` into the attribute/content each control actually serializes) called immediately before building `htmlContent` in every affected `saveWork()`/`markComplete()`:

- `04_vocab_quiz.html` — reflection textarea.
- `05_practice.html` — Drills 2/6/8's `<select>`s, Drills 3/4/6's typed `<input>`s.
- `11_feedback.html` — 4 followup/open-ended textareas, 6 term checkboxes.
- `09_mastery_check.html` — confirmed unaffected; its only persisted fields are plain hidden `<span>` timestamps set via `textContent`, not a form control.
- **Also caught while building the sample-submission fixture below: `11_feedback.html`'s `currentFileName()` was never actually updated to add the `_completed` suffix**, even though this same entry (and `00_table_of_contents.html`'s progress scan) already assumed it produced `11_feedback_completed.html`. Fixed to match the other three.

**Also fixed the same session, smaller items:**
- `00_table_of_contents.html`'s file links weren't visually distinct as clickable (color + bold, underline was hover-only) — now underlined by default, per Jay.
- **Renamed "Practice Drills" to "Practice"** everywhere it appeared (title, H1, nav links, cross-references in `01_instruction.html`, `04_vocab_quiz.html`, `07_project.html`, `mvp-unit-folder-structure.md`) — "guided practice" is reserved specifically for the embedded quick-checks in `01_instruction.html`, this standalone page is just "Practice." See `adaptive-practice-model.md`'s Naming section.
- The vague "attempt every drill you can... fine to end up with a different number attempted" wording in `05_practice.html` could read as "any number, including very few, is fine." Replaced with a concrete expected range: typically **8-15 questions**.

---

## 2026-08-11 (later) — Adaptive practice model: hybrid, small skill nodes, reusing the existing ladder + telemetry design

**Context:** Jay confirmed practice should have real adaptive branching after all — a hybrid model, scaled back from the full original scope, not the flat list the 2026-08-06 decision landed on. Also asked whether some current drills could move into guided practice inside the instructional page instead of independent practice.

**Decided:** New `02-authoring-system/adaptive-practice-model.md`. The key finding while designing this: **the Reinforce/Core/Extend ladder and its telemetry schema already existed**, fully specified — `objectives-and-skills-proficiency.md`'s ladder rules (2026-07-24) and `telemetry-and-analytics.md`'s `drill_attempt`/`lane_transition` event shape (2026-08-08) were both written for the original Moodle-Lesson-activity plan and never actually wired into a real lesson once Moodle paused. This isn't a new model, it's finally implementing an already-designed one, on a different surface (a practice page's own client-side JS, since there's no Moodle Lesson activity or live backend anymore) and at a smaller scale than either prior plan discussed.

- **Skill nodes**, not a flat drill list: each trackable skill gets a small pool (Core 1, Reinforce 1-2, Extend 1-2 — 3-5 items, not the 5-per-skill rate `objectives-and-skills-proficiency.md` was already second-guessing). A 2-3 node lesson lands around 6-15 items total, same routing rules as before (sticky Reinforce/Extend endpoints, one move per attempt, no fourth level).
- **One new telemetry value**: `lane_transition.reason: "lane_exhausted"`, for when a student is still wrong after a lane's tiny pool runs out — a real, loggable outcome given how small these pools are, not an edge case to paper over.
- **Hints now apply to practice nodes**, not just the stepper/project-hint components `hint_reveal` originally covered — one optional, single-level conceptual hint per Core item, specifically to answer Jay's "where did they leverage support" ask, which nothing in the current flat-drill format captures at all.
- **Worked example for Lesson 01.4**: its current 8 flat drills resort into 2 adaptive nodes (`print_syntax`, `diagnosing_errors`, ~6 items total) plus 2-3 lighter guided-practice quick-checks moved earlier into `01_instruction.html` (pure DOK-1 recall items that don't need branching), plus Drill 7 (the Unit 05 if-statement sneak peek) staying exactly as-is outside the ladder, per its existing bonus/preview-only status.

**Not done in this pass:** `05_practice.html` itself hasn't been rebuilt to this model yet — this is the design, confirmed as the shape to build next, same "design, then prove on the reference lesson" order every other pattern here has followed. Also flagged, not resolved: whether guided-practice quick-checks need their own (lighter) telemetry, since they're currently explicitly untracked and are exactly where a student's first struggle would show up.

**Supersedes:** the 2026-08-06 decision's flat-list-only stance, narrowly — that decision's reasoning (don't rebuild the old deep-branching-tree engine) still holds; what's changing is scope, not a full reversal.

---

## 2026-08-10 (even later) — Multi-line block builder layout, Light/Dark color fix, more Synthwave violet, misconception blocks redesigned + click-to-reveal fix, Key Terms analogies, vocab quiz reflection prompt

**Context:** A long stretch of smaller, concrete pieces of feedback in one sitting, spanning both the theme system and real Lesson 01.4 content.

**Decided/built:**

- **Multi-line block builder layout fixed** (component-library #3 and the real Drill 7 in `05_practice.html`): all target line rows now render together first, empty, so a student sees the full shape of what they're building — including the indentation relationship between lines — before touching any blocks. Token banks moved below both lines instead of interleaving. Documented as the standing pattern for any future multi-line drill in `mvp-unit-folder-structure.md`, which also now flags a **future enhancement, not built yet**: overprovisioned banks (real distractor pieces, not just the correct set shuffled) and requiring some blanks to be typed rather than only dragged.
- **Light/Dark's Warning and Error colors were too close to tell apart** — both were the same pale-amber family. Rebuilt as genuinely distinct hues (Warning stays amber/gold, Error moves to a muted wine/rose family), both as real chips matching the box-vs-page fix already applied elsewhere. Still nowhere near alarm-red, per `design-system.md`'s Tone Note.
- **Synthwave's violet accent given more real presence** per Jay's request — now also used for `--accent-dashed` (drag-and-drop zone borders, real interactive surface) and `--placed-bg`/`--placed-text` (already-placed block pieces get their own violet identity instead of plain blue-violet). Jay explicitly confirmed the existing semantic feedback colors (success/warning/error/info) should stay untouched — those are approved as-is.
- **Two Mistakes section restyled from a heavy red "misconception" block to a plain reading card.** This wasn't just a style preference — the old `.misconception` class (`#f6c5c4` background) was a real violation of `design-system.md`'s own Tone Note, which reserves red specifically for academic-integrity warnings, not ordinary common-mistakes explainers. New `.mistake` style: neutral background, small "Common Mistake" eyebrow label, same visual family as `.objectives`.
- **New "Click to see the fixed version" reveal**, one per mistake example: shows the corrected code with exactly the changed character(s) highlighted in a muted red diff-highlight (`.diff-added`), plus a one-line note naming what changed. Framed as a diff/markup convention (showing what changed), not a "wrong answer" alarm signal — a different use of red than the Tone Note governs, and not in tension with it.
- **Every Key Term now has an Example or Note, and the more abstract ones (`function`, `string`, `argument`, `SyntaxError`) also get a high-school-appropriate analogy** (a vending machine for `function`, air quotes for `string`, texting a friend a time and place for `argument`, a sentence missing its closing quotation mark for `SyntaxError`). `output` gets an Example only — concrete enough not to need a forced comparison. New `.term-analogy` style (violet, italic) visually distinguishes "this is a comparison" from "this is a concrete usage example" (`.term-example`, blue).
- **New reflection prompt at the end of `04_vocab_quiz.html`**: an optional textarea asking whether the student used any memory tricks for the vocabulary, and what worked. Doesn't gate Save — the completed match is still the real submission requirement. Saved the same way as the rest of the page (`document.documentElement.outerHTML`), the same pattern already proven in `11_feedback.html`'s answer boxes, so no new save mechanism was needed.
- Content readability pass on `01_instruction.html`: several dense paragraphs split up, most notably the Game Connection tie-in (previously one 7-sentence block, now five short paragraphs with a natural progression) and the "Why parentheses?" callout.
- Browser-tested throughout: both reveal buttons tested (correct diff-highlighted fix shown for each mistake), Drill 7's new layout confirmed to still build/check correctly, the vocab quiz reflection box renders and accepts input, Key Terms cards render with both Example and Analogy lines distinguishable. No console errors.

---

## 2026-08-10 (later) — Texture tuning; Lesson 01.4 content fixes (isolated error example, label formatting, Key Terms cards, checklist relocation, new compound-error drill)

**Context:** Two threads in the same stretch. First, more live review of the theme specimen: the paper texture needed to be more visible and scroll with the page rather than stay pinned, a specific yellow-vs-brown tint preference, and a real contrast bug in inline `<code>` nested inside colored feedback boxes (near-black text on dark blue in Synthwave's Error box — inherited color, not a chosen one). Second, Jay reviewed real Lesson 01.4 content (`courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/`) and flagged several issues at once.

**Decided/built — theme specimen:**

- Texture opacity raised twice (0.035 → 0.08 → 0.1) after Jay still couldn't perceive it at the guide's own suggested value; tint shifted from dark brown toward yellow-gold, with the real limit noted (alpha-based grain blends with the pale page background at low-alpha pixels, capping how saturated a "boosted" swatch can look without switching techniques).
- Texture/grid layer changed from `position: fixed` to `position: absolute` so it scrolls with page content instead of staying pinned to the viewport.
- `code, pre` given an explicit `color: var(--color-text)` — previously inherited the surrounding text color, which broke badly inside colored feedback boxes with near-black text (Synthwave's Error state specifically). This was a real bug, not a preference call.
- Full detail and before/after values: `theme-system.md`'s Background Texture section.

**Decided/built — Lesson 01.4 content, all in `lesson_01_04_printing_output/`:**

- **`01_instruction.html`'s "Two Mistakes" Mistake 1 example was accidentally teaching two errors as one.** The code sample (`print("Hello, Python!`) was missing both the closing quote *and* the closing parenthesis, but the prose only discussed the quote — so the missing `)` went unremarked and undermined the "isolate one error" teaching goal of the section. Changed to `print("Hello, Python!)` — the `)` character is now visibly present in the source (though still functionally swallowed into the unterminated string, so it's still a genuine `SyntaxError: EOL while scanning string literal`), making it unambiguous that the quote is the one and only problem in this example. Prose updated to point this out directly ("notice the `)` is right there, but it doesn't help...").
- **New standing rule, applied here and documented in `content-voice-and-tone.md`**: a bolded `Label:` lead-in (`Fix:`, `Note:`, `Example:`, `Handoff to VS Code:`, `Up next:`, `Game connection:`) always starts its own line/paragraph, never runs mid-sentence after preceding prose. Applied to all 6 instances found across `01_instruction.html`, `07_project.html`, and `09_mastery_check.html`.
- **Key Terms redesigned from a browser-default `<dl>`** (term, definition indented on the line below via default `dd` margin) **to non-clickable-looking cards** — term and definition at the same left indent inside a bordered, tinted box (no hover state, no cursor change, nothing suggesting interactivity), so each term+definition (and, where present, an `Example:`/`Note:` sub-line) reads as one visually grouped unit. The `SyntaxError` term now has a real `Example:` line, since it's the term where a worked example actually helps.
- **The "Before You Submit. Checklist" section removed from `01_instruction.html`** — Jay's read: a passive checklist with nothing to check off, sitting on a page the Learner isn't actively doing anything on, didn't earn its place. **Relocated to `05_practice.html`** as a plain-bulleted (not checkbox-styled) reminder directly above Drill 1, where a Learner is actually building a `print()` statement and can use it as a real self-check before clicking Check.
- **New Drill 8 in `05_practice.html`: a compound-error diagnosis question**, deliberately the mirror of the now-isolated Mistake 1 example — `print("Not enough gold` is missing *both* the closing quote and the closing parenthesis, and the Learner picks from four descriptions of what's wrong. Partial-credit feedback for picking only one of the two real problems, distinguished from the "nothing is wrong" distractor. This is the "practice diagnosing a real compound error" Jay asked for, deliberately separated from the instructional page's single-error teaching example so the two don't get taught as one confusing thing.
- Browser-tested end to end: both mistake examples render correctly, Key Terms cards read cleanly, the relocated reminder sits correctly above Drill 1, and Drill 8 was exercised with both a partial-credit answer and the correct answer, confirming the right feedback message each time. No console errors.

---

## 2026-08-10 — Full contrast rebuild for Natural/Synthwave, background textures, per-theme body fonts

**Context:** Jay asked to see the Natural/Synthwave background textures, then — while that was in progress — flagged three more things from actually looking at the live specimen: the Natural/Synthwave palettes could be "expanded a bit more," Natural's background could go even paler, and the semantic feedback boxes in both themes "seem fairly low contrast" — with an explicit instruction that everything should clear AA by default and AAA where possible. Separately, mid-session, relaxed the "body text is always Atkinson Hyperlegible" rule: theme-appropriate body fonts are fine as long as they're genuinely legible (no script/handwritten/decorative faces, nothing that raises cognitive load over a long passage).

**Decided/built:**

- **Real WCAG math this time, not eyeballing.** Wrote an actual relative-luminance/contrast-ratio calculator and audited every color pair in both themes. Finding: every pair already technically passed AA-normal (4.5:1) for text-on-its-own-background — Jay's "low contrast" reaction was correct anyway, because nothing had checked whether a feedback *box* stood out from the *page* background around it. Measured: Natural's boxes were ~1.2-1.3:1 against the page (and accent/warning/error were literally the identical color, `#6f3a17` on `#E8D3AE`); Synthwave's were ~1.4-2.1:1. A box that only reaches 1.2:1 against its surroundings doesn't read as a distinct surface no matter how readable the text inside it is.
- **Feedback rebuilt as rich, saturated chips instead of pale tints**, in both themes: Natural flips to dark-color-fill + white text (e.g. success `#245638` bg, ~8.5:1 text, ~8.2:1 vs page); Synthwave flips to bright-color-fill + dark text (e.g. success `#3DDC97` bg, ~8.7:1 text, ~8.7:1 vs page). Every pair now clears AAA-normal (7:1) for text, and box-vs-page contrast is up to 5.4-9.6:1 across both themes — a real, visible surface, not a near-invisible tint.
- **Synthwave's Accent/badge color is now a genuine 5th hue (violet, `#B79CFF`)** instead of reusing Error's magenta — this is also the concrete answer to "expand the palette a bit more": cyan / magenta-pink / violet / amber / green / blue-violet, not just cyan-and-magenta.
- **Natural's background lightened again** (`#F9F5E7` → `#FCFAF1`), and text/heading/primary/muted-text darkened slightly to push from AAA-large-only to full AAA-normal (7:1) everywhere the hue could support it without losing identity.
- **Background textures built and wired live**, per the guide's own Section 30 decorative tokens (`--decoration-texture-opacity: 0.035` for Natural, `--decoration-grid-opacity: 0.08` for Synthwave — both the guide's own suggested numbers): Natural gets an SVG `feTurbulence` fractal-noise paper grain (no repeat seam, unlike a tiled photo — satisfies the guide's "avoid strong repeating patterns" rule); Synthwave gets a plain CSS `repeating-linear-gradient` line grid tinted with the theme's primary cyan. Implemented as a `body::before`/`::after` layer in `theme-typography-specimen.html`, sitting behind all content. Since the real production opacity is deliberately near-invisible (by design, per the guide), the specimen shows both the true live version (the whole page background) and a boosted-visibility swatch side by side so the pattern is actually inspectable.
- **Body font is no longer Atkinson Hyperlegible in every theme.** Self-hosted two more free/OFL Google Fonts: **Lora** for Natural (a contemporary text serif built for reading, not a display/script face — matches the "warm, thoughtful, slightly handcrafted" brief without tipping into "rustic/vintage," which the guide's own Section 8 explicitly warns against) and **Sora** for Synthwave (a geometric UI sans with tech character, chosen specifically because the guide rules out JetBrains Mono for long-form copy, Section 7). Light/Dark keep Atkinson Hyperlegible — their brief is "familiar/low-distraction," where a personality body font would work against the goal.
- **Applied to both the specimen and the production files** (`shared-styles/foxcs-theme-natural.css` / `-synth.css`), same variable names, so the component library and `theme-and-telemetry-demo.html` inherit the new colors automatically (they link these files directly). Fonts are not yet wired into `foxcs-base.css` (still hardcodes Georgia, doesn't link `foxcs-fonts.css`) — flagged in `theme-system.md`'s "Not Yet Decided," same "coexist for now" status as the semantic-token migration.
- **Browser-tested end to end**: all four themes re-verified visually (paler Natural bg, visible Lora serif vs. Sora geometric-sans body text, vivid feedback chips in both themes, boosted vs. true-opacity texture swatches), no console errors.

---

## 2026-08-09 — Built Code Hotspot (component #17): hover annotations + ordered step-through for exploring *why* specific keywords are in a code block

**Context:** Jay asked, mid-session, for a component like the Glossary Term hover/click card (#13) but for code — the concrete example given was C#'s `public`/`private`/`void` in a Unity method signature, where a student might want to hover a keyword and see why it's there. He also described a second possible shape: a slideshow-style step-through where a different keyword is highlighted per step and the explanation "subtly changes," explicitly distinguishing this from the Code Execution Stepper (#14), which shows runtime behavior, not structural reasoning.

**Decided/built — component #17 in `component-library/index.html`:**

- **Both interaction shapes exist, sharing one state, not two separate demos.** Hovering or clicking an underlined keyword in the code block shows a positioned definition card (identical mechanism to #13: hover shows/hides, click pins, Escape/click-elsewhere closes, keyboard-accessible). A ◀ ▶ transport below the code steps through the same keywords in a fixed order, slideshow-style, updating a note panel's text and highlighting the corresponding token — no execution simulation involved, this is annotating *why*, not tracing *what runs*. Clicking a keyword directly also moves the step position to match it, so free exploration and ordered walkthrough stay in sync instead of fighting each other.
- **Demo content is exactly Jay's example**: a small `PlayerController.cs` with `public class`, `private int health`, `void Start()`, and `public void TakeDamage(int amount)` — real, valid C#, 5 hotspots (`public` on the class, `private` on the field, `void` on both methods' return type, `public` on the method) each with its own distinct explanation, since "public on a class" and "public on a method" mean different things.
- **Reused, not duplicated, existing infrastructure**: the dark IDE surface (`foxcs-ide-dark.css`'s `.ide-demo`/`.ide-code`/`.tok-kw` classes from component #14) for the code display and transport chrome, and the glossary card's hover/pin/keyboard pattern (#13) for the annotation mechanism — new CSS added to `foxcs-ide-dark.css` is only the hotspot-specific pieces (`.hotspot`, `.hotspot-active`, `.hotspot-card`), not a second copy of either existing system.
- **Browser-tested**: clicking a token pins the card, highlights it, and correctly jumps the step counter to match ("Step 1 of 5"); the Step ▶ transport advances through tokens, updates the note panel text, and closes any pinned card (since stepping isn't a hover/click action) — confirmed exactly this behavior in a live screenshot sequence, not just read over. No console errors.
- **Not yet deployed** — proposed for the first real appearance of any new-to-students keyword/syntax pattern, most concretely C#/Unity access modifiers and return types once Game II exists, but the mechanism itself is language-agnostic (any code block, any hand-picked set of hotspot tokens).

---

## 2026-08-08 (even later) — Real Natural/Synthwave palette from Jay's typography style guide; fonts self-hosted; typography specimen page built

**Context:** Jay added `logos/waypoint_theme_typography_style_guide_full.md` — a real, detailed spec (not a placeholder) covering all 4 themes' colors with computed contrast ratios, a full typography strategy, and explicit accessibility rules (WCAG 2.2 AA minimum, a Critical Synthwave Contrast Rule keeping brand magenta out of text/UI use, a rule keeping Natural's decorative leaf-green out of functional use). Asked to keep FoxCS's already-approved Light/Dark exactly as they are, bring in the guide's Natural/Synthwave palette (improving gaps as needed), require every font to be free/Google-Fonts-downloadable, keep copies in the students' shared-styles folder, and show it all on one toggleable HTML page.

**Decided/built:**

- **`shared-styles/foxcs-theme-natural.css` and `foxcs-theme-synth.css` replaced** with the guide's real palette, mapped onto the same variable names as the earlier placeholder files (drop-in, no changes needed to `foxcs-base.css` or any component). Gaps the guide leaves unspecified were filled in and flagged inline: semantic warning/info colors (the guide specs the success/warning/error/info *API* in Section 25 but not exact hex per theme), and a button-safe "amber" secondary-action color for Synthwave — the guide's functional magenta (`#E656F3`, ~5.1:1) is verified for *text*, not as a fill with FoxCS's existing hardcoded white button text on top, so a separately-darkened magenta fills that role instead.
- **Fonts self-hosted, not linked to Google's CDN** — `shared-styles/foxcs-fonts.css` + 5 real `.woff2` files in `shared-styles/fonts/` (Atkinson Hyperlegible 400/700 static; Nunito Sans, JetBrains Mono, and Source Sans 3 as single variable-font files, since Google serves one file per family for those, not one per weight — confirmed by checking the actual URLs, not assumed). Same "no external dependency in distributed content" reasoning already applied everywhere else — a Google Fonts request at render time is exactly the kind of external call real lesson content avoids. All four families confirmed free/open-source (SIL OFL) and downloadable from fonts.google.com, per Jay's explicit requirement.
- **New `theme-typography-specimen.html`** — a real toggleable page (not a mockup) implementing the guide's own recommended semantic token architecture (Section 3: `--color-bg`, `--color-surface`, `--color-on-primary`, etc.) directly, standalone from the older simpler token set the component library runs on. Shows real typography per theme (heading font swaps: Atkinson Hyperlegible for Light/Dark, Nunito Sans for Natural, JetBrains Mono for Synthwave; body always Atkinson Hyperlegible; code always JetBrains Mono), a color-swatch grid reading live CSS custom property values (not hand-copied hex), buttons, border/focus states, and all 4 semantic feedback types. Explicitly documents FoxCS's own house rule (never red for general incorrect-answer feedback, red reserved for academic-integrity flags) since the guide's semantic model doesn't know about that rule on its own.
- **Live-reviewed and revised with Jay, same session, based on real reactions to the rendered page — not just following the guide's numbers**: Natural's background lightened (`#FAF5E0` → `#F9F5E7`, still safely within AA since lightening only increases contrast against the existing dark text) because it read too tan/yellow in practice; Synthwave's `--border-strong` swapped from the guide's own periwinkle `#858AF0` to the brand magenta `#D52AE3` for real visible pink presence — legitimate under the guide's own Critical Contrast Rule, since non-text UI only needs 3:1 and the brand magenta clears it at ~3.86:1 even though it fails for text; added a `--color-accent`/badge pattern using the guide's functional magenta for a second, text-safe dose of pink (directly implementing the guide's own suggested "badges, selected states" use case, Section 18); and every theme's semantic feedback backgrounds were brightened after noticing the original tints barely registered as distinct colored surfaces against their own dark page backgrounds, not just checked for text contrast in isolation.
- **Browser-tested throughout** (local server + Chrome automation): confirmed all 5 font files load with 200 status (not silently falling back to system fonts), confirmed each theme's heading font actually renders (visibly different letterforms per theme in screenshots), confirmed the pink-presence and feedback-brightness fixes visually before considering them done, no console errors.
- **`theme-and-telemetry-demo.html` and `component-library/index.html`'s #15 description updated** to stop calling Natural/Synthwave "placeholder" — they automatically picked up the real colors since they link the same shared theme files, but the surrounding text was stale and got corrected.
- **Not done:** the parchment texture treatment for Natural (guide Section 10 describes it, nothing implemented); migrating the component library's older token names to this specimen's fuller semantic architecture (the two coexist for now, see `theme-system.md`'s "Not Yet Decided").

---

## 2026-08-08 (later still) — Theme system + telemetry wired into the component library as components #15 and #16, browser-tested

**Context:** Follow-up to the design-only entry immediately below — Jay asked to start wiring the theme-system.md/telemetry-and-analytics.md designs into the component library as a real demo.

**Built:**

- **Four new theme files** in `shared-styles/`: `foxcs-theme-light.css` and `foxcs-theme-dark.css` (values copied as-is from the already-approved `foxcs-base.css` palette, just made independently linkable), `foxcs-theme-natural.css` and `foxcs-theme-synth.css` (new, explicitly marked **placeholder palettes**, not contrast-verified, pending Jay's real visual reference). `foxcs-base.css` itself was left untouched — CSS's own cascade (later `:root` block wins at equal specificity) means a page can link it first and a theme file second without editing the original, so the already-shipped light/dark toggle mechanism in the library's own chrome stays exactly as it was.
- **`shared-styles/foxcs-telemetry.js`** — the reusable event-log mechanism from `telemetry-and-analytics.md`: `FoxCSTelemetry.init()`, `.log(type, fields)`, `.recordSave(theme)`, writing to a hidden `<script type="application/json" id="foxcs-telemetry">` block, generalizing the mastery-check's hidden-timestamp trick into a real append-only log.
- **New demo page** `component-library/theme-and-telemetry-demo.html`: a real `<link id="foxcs-theme-link">` swappable two ways (a dropdown, and a text field standing in for hand-editing the href — both call the same code path), reconciled at Save by rewriting that link's `href` before serializing; a small throwaway Core/Reinforce/Extend arithmetic drill (generic content, same rule as every other library demo) that logs real `drill_attempt`/`lane_transition` events and visibly flags the "stuck" heuristic from `telemetry-and-analytics.md` after 2 consecutive incorrect Reinforce attempts; a "Show/hide" toggle that surfaces the normally-hidden telemetry JSON so the mechanism can actually be watched updating live — real lesson pages would never show this panel.
- **`component-library/index.html`** gained #15 (Theme System) and #16 (Telemetry Event Log), #15 embedding the demo page live via iframe (same pattern as the video-embed component), #16 pointing back at it rather than duplicating the iframe.
- **Browser-tested end to end** (local static server + Chrome automation, not just read over): confirmed Light/Dark/Natural/Synthwave all render correctly including the placeholder Synthwave palette (deep purple background, magenta heading, neon-purple buttons — no console errors), confirmed the dropdown and link-edit paths both fire `theme_change` events, ran the drill down the Reinforce path and confirmed `drill_attempt`/`lane_transition` events logged with correct fields, and confirmed the telemetry panel updates live and the iframe renders correctly inside the main library page.
- **Not yet wired into any other component** — the stepper's own play/pause/step/speed controls, drag-to-match, categorization, sequencing, and hint reveals don't call `FoxCSTelemetry.log()` yet. That's the natural next increment once this mechanism itself gets Jay's reaction, per `telemetry-and-analytics.md`'s own "Not Yet Decided" list.
- **Still not resolved:** the Classroom-folder-structure-on-download question flagged in the entry below — this demo's theme files are linked cross-folder (`../shared-styles/...`), which is fine for a locally-opened reference tool but is exactly the shape `theme-system.md` says to avoid once real lesson content ships.

---

## 2026-08-08 (later) — Designed the 4-theme system and a full interaction-telemetry layer (both design-only, not yet built)

**Context:** Jay wants students to be able to customize their color theme (light default, dark, a new Natural/parchment palette, a new Synthwave/cyber palette — real palettes pending his own visual-generation reference, started with the `logos/` exploration) and, separately, wants much richer data than currently exists on how students actually move through content: theme chosen, every code-stepper speed change (not just the final value), hints used, the real breakdown of Core/Reinforce/Extend routing per skill, what happens when a student gets stuck, whether Reinforce actually recovers a skill, and start/save timestamps for time-on-task. Explicitly wants this landing in markdown/JSON files he can later load into a real database, not a live backend.

**Decided:**

- **Theme selection has two layers, reconciled at Save.** A persistent choice lives in a real `<link rel="stylesheet" id="foxcs-theme-link" href="...">` a student edits by hand (Jay's own preference — an intentional, hands-on "customize your workspace" moment, and it survives across devices/browsers since it's baked into the file, not `localStorage`). A live top-of-page selector previews instantly via JS. On Save, the DOM's `<link href>` gets rewritten to match whatever the selector currently shows, so the student's last choice — however they made it — is what's baked into the file for next time. Full design: `02-authoring-system/theme-system.md`.
- **`foxcs-base.css` needs restructuring** (not yet done) — structure stays in that file, but each theme's variable *values* move into its own small linkable file (`foxcs-theme-light.css`/`-dark.css`/`-natural.css`/`-synth.css`), since the hand-edited `<link>` needs something real to point at. This is a real change to the 2026-08-08-earlier shared-styles design, not additive — see `theme-system.md` for why.
- **This reopens the still-unresolved Classroom-folder-structure-on-download question** — the same unknown that already kept `shared-styles/` unlinked from real lesson content. Mitigated for now by keeping theme files same-folder rather than a shared cross-unit reference (duplication over risk), but flagged directly to Jay that this question now blocks three separate decisions and is cheap to test empirically (one throwaway Classroom round-trip). Not resolved in this session.
- **Telemetry is one hidden JSON event log per page** (`<script type="application/json" id="foxcs-telemetry">`), generalizing the existing hidden-timestamp pattern from the mastery-check password gate (component #12) into a full append-only event array: theme changes, stepper play/pause/step/speed-change, hint reveals, drill attempts (skill/lane/correct/attempt number), and lane transitions (from/to/reason) — logging the full path through Core/Reinforce/Extend, not just the endpoint. Page-level `opened_at`/`saves[]` timestamps answer the time-on-task question directly. Full schema and event types: `02-authoring-system/telemetry-and-analytics.md`.
- **Pipeline rides the existing not-yet-built codename-swap script**, extended to also extract each submitted file's telemetry blob into a normalized per-codename/per-page record under a new `06-data-and-spreadsheets/telemetry/` directory (markdown/JSON, matching what Jay asked for) — deliberately not a new pipeline stage, since that script is already the point where every submitted file gets touched before reaching `05-grader/` or any AI tool.
- **First-cut "stuck" heuristic, explicitly flagged as unvalidated:** 2+ consecutive Reinforce-lane attempts on the same skill still incorrect, with no intervening recovery. Same epistemic posture as the existing unresolved skill-granularity question in `objectives-and-skills-proficiency.md` — a starting point to pressure-test against real pilot data, not a locked answer.
- **Privacy addendum added to `data-boundaries.md`** — this is meaningfully richer behavioral data than that doc anticipated when written; confirmed it's covered by the same Release Gate/codename-swap boundary (no separate, less-protected path), and flagged as worth raising with the district privacy officer alongside the existing SOPPA note, since click-level behavior is a different sensitivity category than submitted code even with identity already stripped.
- **Nothing implemented yet** — both docs are architecture only. Real Natural/Synthwave palette values, the `foxcs-base.css` split, and wiring the event log into the actual component library are the next real steps, gated on Jay's reaction to this design and on the Classroom folder-structure test above.

---

## 2026-08-08 — Shared CSS extracted; light/dark theme toggle added; stepper refined (finer speed control, explicit post-loop step)

**Context:** Jay asked for a shared CSS folder and a basic design system, closing the "no shared stylesheet yet" gap `design-system.md` had flagged since 2026-08-06. Mid-task, he added two more requirements: real AA contrast throughout, and a light/dark toggle for students who'd prefer it — explicitly not stark black-on-white or white-on-black in either mode. Separately, he asked for finer speed control on the code stepper (0.25 through 2.0 in quarter-increments) and a clearer demonstration that the program keeps executing after a loop block, even when the loop ran zero times.

**Decided/built:**

- **`02-authoring-system/shared-styles/`** — new folder. `foxcs-base.css` (light-page palette, typography, buttons, feedback states, every reusable component's styling, now expressed as CSS custom properties with light `:root` values and `[data-theme="dark"]` overrides), `foxcs-ide-dark.css` (the stepper's dark surface, kept separate and non-variable since it simulates an editor and stays dark regardless of the page's own toggle), `foxcs-theme-toggle.js` (defaults to `prefers-color-scheme`, remembers a manual override via `localStorage`), and a `README.md` explaining the design.
- **Component library is the first live consumer** — `index.html` now links all three shared files instead of repeating its own copy, and has a working dark-mode toggle button in its header. This is the real proof the extraction works, not just a theoretical split.
- **Real lesson content does NOT link the shared files yet, on purpose.** Whether Google Classroom preserves a unit folder's directory structure on download is still an open, untested question — an external `<link>` in distributed content would silently break (unstyled page) if Classroom flattens folders or a file gets separated from its containing folder. Lesson pages keep their own embedded `<style>` block, hand-synced against `foxcs-base.css`, until that question resolves. Documented in `shared-styles/README.md` and `design-system.md`'s "Known Gap" section.
- **Neither theme uses a stark extreme**: light mode text `#1a1a1a` on background `#fbfbf9` (not pure white), dark mode text `#e6e9ef` on background `#1e2430` (not pure black, same family as the IDE surface for continuity). Real WCAG contrast ratios computed (not eyeballed) for the load-bearing pairs — see `design-system.md`'s new "Dark Mode / Theme Toggle" section for the table. Notably, the *existing* light-mode accent colors (`#1a5aa8`, `#9a5a00`) measured badly as plain text directly on the new dark background (2.28:1 and 2.84:1 — both fail) even though they remain fine as button fills; dark mode uses brighter substitute accents (`#8fbdf0`, `#e0a84a`) for text/headings specifically. Some secondary dark-mode pairs (box/border/incorrect-feedback) were reasoned by analogy rather than individually computed — flagged honestly rather than overclaiming full verification.
- **Stepper speed control** replaced with a range slider (0.25 to 2.0, quarter-step increments) instead of three fixed options, mapped to a base 700ms interval divided by the multiplier.
- **Stepper traces extended** with a 4th code line (`print("Loop finished!")`, unindented) and a corresponding step in all three branches, showing execution continuing past the loop regardless of how many iterations ran — including the empty-list branch, which now explicitly demonstrates a loop that runs zero times still lets the program fall through to what comes next.

---

## 2026-08-08 — Built the code execution stepper (simulated IDE); declined the general simulated-IDE idea

**Context:** Following the component library review, Jay asked two related questions: should there be a simulated in-browser IDE that matches typed code against accepted responses, and separately, a static/scripted stepper that visualizes how code executes (current line, variables, output) so students can see loops and top-to-bottom flow. Recommended building the second, not the first — the first is close to the same territory as the Monaco/Pyodide question already researched and rejected earlier this session (students already have real Python via VS Code; a fake in-browser matcher either handles only anticipated inputs or risks telling a student broken code is "right"). Jay agreed to hold off on the IDE-matching idea and move forward with the stepper, then specified real requirements for it: a simulated IDE look with syntax highlighting; Play/Pause, Step forward/back, and a speed control; a way for students to change a value (dropdown or typed) and see a different outcome; and, specifically for showing a debugging fix in progress, an actual typing animation at randomized per-character speed so it reads as genuine typing rather than a robotic fixed interval.

**Decided/built — component #14 in `component-library/index.html`:**

- **Nothing actually executes.** Every step is a hand-authored JS object (current line, variable snapshot, accumulated output, a plain-language note) — explicitly framed in the component's own description as "closer to a comic strip of a program's execution than a real interpreter," the same honesty standard as every other component in this library. This is the load-bearing distinction from the declined IDE-matching idea.
- **The "change a value and see how it responds" ask is a curated branch, not live recalculation.** A dropdown picks between a small number of fully pre-authored traces (3 fruits / 1 fruit / empty list, for the demo's for-loop-over-a-list example) — each is its own complete, hand-written step sequence, not computed from the input. Documented as a deliberate design boundary, not a limitation to hide.
- **Simulated IDE chrome**: dark editor surface (new palette, see `design-system.md`'s "Dark IDE-Simulation Surface" section — a deliberate exception to the light-page palette, since real editors are dark), line numbers, a small regex-based Python syntax highlighter (keywords/strings/numbers/comments) good enough for hand-authored demo lines, a variables panel and an output panel that update per step, and a current-line highlight.
- **Transport controls**: Step ◀ / ▶, Play/Pause (auto-advances on an interval), and a speed selector (0.5x/1x/2x) that changes the interval length.
- **Separate typing-animation demo** ("Bonus: watching a fix get typed") for the debugging/edit case specifically — types a corrected line character-by-character at a randomized 35-125ms per-character delay, distinct from the main stepper (which moves by discrete steps, not per-character, since typing every print statement character-by-character across many loop iterations would be tedious rather than illustrative).
- **Not yet deployed** into any real lesson — proposed generally for any lesson introducing a new control-flow concept (loops, conditionals, functions).

---

## 2026-08-07 — First real video embed tested; component library review (feedback voice, drag-to-match labeling, categorization feedback, sequencing backup, timestamp redesign)

**Context:** Two things in the same stretch. First, Jay provided a real video link and embed code (`youtube.com/watch?v=NlAFWaa9UQo`) to finally test the video-embed pattern for real, after the earlier placeholder-ID attempt produced a genuine YouTube Error 153. Second, a full review pass of the component library surfaced several real fixes: the multi-line block builder used syntax that was neither valid Python nor labeled pseudocode; success feedback across most components was a flat "Right!" with no explanation; drag-to-match hid the dropped term once placed, making it unclear what was matched to what; categorization gave no text feedback, only a silent counter and a momentary red flash; sequencing had no non-drag fallback; and the password-gate mastery-check timestamp required students to hand-copy a visible time into their answer file, which Jay said was a mistake in the original design.

**Decided/built:**

- **Video embed is now Live**, using the real ID on `youtube-nocookie.com` (FoxCS's default), with the `si=` share-tracking parameter dropped (that's YouTube's own per-click attribution, not something to check into course files). First real proof this pattern actually works, not just a documented shape. Not yet deployed into any real lesson — where it belongs isn't decided.
- **Multi-line block builder** now uses real, valid Python (`if temperature < 32:` / `print("Wear a coat")`) with a visible "Python" language badge. New standing rule: a block-builder target must always be either real valid syntax in the language being taught, or clearly labeled pseudocode — never an ambiguous mix.
- **Feedback voice rewritten** across block builder, multi-line block builder, dropdown, typed, combined blank, categorization, matching, and sequencing: success messages now explain *why* the answer is right, not just confirm it. Where a wrong answer genuinely can't be diagnosed (free-recall typed answers especially), feedback falls back to a general, always-true reminder ("check your spelling, look back at the material") rather than guessing at a cause — modeled explicitly on Jay's own example phrasing.
- **Drag-to-match** now shows a small labeled badge with the dropped term's name inside its matched definition slot, so it's always clear what was matched to what even after the term chip disappears from the bank.
- **Categorization** now gives real text feedback on both correct and incorrect drops, plus a "why" explanation when the last item is sorted, instead of a silent counter and an unexplained red flash.
- **Sequencing** now has ▲▼ buttons on every item as a non-drag backup, since native HTML5 drag-and-drop isn't reliable on all touch/trackpad devices.
- **Glossary card now clamps to the viewport** — won't run off the right edge, flips above the term if there's no room below.
- **Password-gate mastery-check timestamp redesigned** (see next entry) — students no longer hand-copy a visible time.

---

## 2026-08-07 — Reflection question pool redesigned; new glossary-term hover/click component built

**Context:** Jay refined the reflection design further: rather than one fixed set of backward-looking questions, he wants a varied pool — "most interesting thing learned," "how else might [concept] apply to a game someone's designing," "describe a different use," "what other games use this" — tailored per week's concept, getting more involved as the year progresses, aimed at getting students to make educated guesses and take a stance, not just notice things. He also asked for real game-design vocabulary (mechanics, aesthetics, etc.) to appear in the pages, with a hover-or-click definition card on vocabulary terms — hover shows/hides automatically, click pins it open until clicked again, and the same pattern should apply to first-use vocabulary on instructional pages generally, not just Game of the Week.

**Decided/built:**

- **Reflection question pool**, documented in `game_of_the_week/README.md`: open/general, generative/apply-elsewhere, design-generative, and transfer question types, 2-3 picked and concept-filled per week rather than one static set. Framed explicitly as direct practice for the design-your-own-game skill the thread builds toward at Week 39.
- **New component #13 — Glossary Term hover/click card** — prototyped first in `02-authoring-system/component-library/index.html` per the standing component-library-first rule (generic cooking-demo terms, consistent with the library's existing generic-content theme), then applied to `_TEMPLATE_reference.html` as its first real usage. Underlined term, definition card on hover; click pins it open (matters on touch devices where hover isn't reliable) — closes on second click, click-elsewhere, or Escape. Keyboard-accessible (Tab, Enter/Space, Escape). Card background reuses the existing AA-verified `#1a5aa8` fill rather than introducing a new color pairing.
- **`_TEMPLATE_reference.html` rewritten** to use the pool (one open question + two concept-filled questions covering both of Week 4's Focus terms) and the glossary component (hidden information, mechanic, aesthetic, balance all wired with real definitions).
- **Standing rule added:** the glossary-term pattern is proposed for first-use vocabulary on any instructional page, not just Game of the Week — not yet rolled out anywhere else.

---

## 2026-08-06 — Real Game of the Week calendar received; reflection redesigned to look backward, not forward

**Context:** Follow-up to the Game of the Week design below. Jay pointed out two things: (1) asking students to reflect on "what you'll notice next week" doesn't work, since they don't know what next week's game is; (2) he'd rather have them reflect on whether the concept changes how they perceive a game they already know. Jay also added `Sample Content/GAME OF THE WEEK CALENDAR (2026–27).pdf` — a real, dated, 39-week calendar (Aug 24-Jun 11) with a game and a terse 2-4-word design-focus per week.

**Decided/built:**

- **Reflection now looks backward/inward, never forward.** `_TEMPLATE_reference.html`'s closing question changed from "what will you watch for next week" to "does this game feel different to you now that you've thought about it." General rule documented in `game_of_the_week/README.md`.
- **The real calendar is now the content source**, transcribed to `courses/python/game_of_the_week/game_of_the_week_calendar_2026-27.md` (PDF stays the source of record if they ever diverge). This resolves the "blocked on Jay's game list" item from the entry below.
- **Real connections surfaced, not yet confirmed with Jay:** Week 4 is Rock-Paper-Scissors ("Balance, probability") — near-identical to the existing reference template, so that page is closer to real content than a throwaway demo now. Week 39, the last week of the year, is "Final Game Jam Warm-Up — Mechanic redesign" — a strong candidate for where the design-your-own-game-concept/MakeCode idea lands, possibly paired with the Unit 20 capstone's already-planned design-document journal entry, but the calendar doesn't say MakeCode explicitly so this isn't assumed. Week 31 ("Snake — Input systems, loops," mid-April) is a possible natural, unforced tie-in to the Python course's loops unit if pacing lines up — not checked against `course-plan.md` yet.
- **Not yet built:** real weekly pages from the calendar. Template is proven; rollout hasn't started (task #18).

---

## 2026-08-06 — Designed "Game of the Week," a weekly habit-forming thread separate from the code-revisit spine

**Context:** Same conversation as the Guess-the-Number revisit spine below. Jay pointed out that a 4-milestone-a-year code spine builds toward a payoff but won't build a *habit* — iteration-thinking needs more frequent, lower-stakes practice than that. Jay's own idea: a weekly "Game of the Week" session, playing a different game (paper or online) each week to gradually build game-design thinking, with a page per game explaining it (also serving as a standing reference) and a brief reflection students submit.

**Decided:**

- **Two complementary tracks, not one mechanic split in two.** The Guess-the-Number spine (see entry below) = iterate on your own code, milestone-paced. Game of the Week = analyze someone else's finished game, weekly, low-stakes — the actual habit-forming vehicle.
- **Not tied to unit content.** Jay explicitly chose loose over tight mapping — forcing lockstep with that week's unit would fight real pacing variance and turn a fun, break-up-the-week moment into a content dependency. Thematic connections get called out only when natural.
- **Distribution stays Classroom-only, no second location.** Jay considered hosting the weekly pages on a Google Site with iframes specifically to prepopulate the whole year in one sitting. Rejected for two reasons: (1) it reintroduces exactly the "don't add a submission/hosting location" principle already applied when Google Forms/Sites were rejected for the feedback form, and (2) it would stack an untested cross-origin File System Access API permissions question on top of the already-untested "does save-in-place even work on school Chromebooks" question. The actual goal (prepopulate once, touch it once) is achievable natively: write all weeks now, attach each to its own Classroom assignment, and use Classroom's **Schedule** feature to set real publish dates in advance.
- **Students keep one persistent "Game of the Week" folder** in their Classroom-connected space, made once and reused all year — unlike unit folders, which are per-unit. Files are Jay-named (`week_03_<gamename>.html`), no student renaming, consistent with the platform-wide no-self-naming rule.
- **Reflection is embedded in the same page and saved in place**, reusing the exact mechanism already proven on `lesson_01_04`'s feedback form and vocab quiz — not a new mechanism, not a separate file.
- **Reflection is genuinely brief** (2-3 guided questions, sentence starters rather than a cold open blank) and graded as a lightweight completion/authenticity check, not full rubric scoring — a weekly recurring grading surface has to respect the same 1-hour/week budget as everything else.
- **Scaffolding fades over the year.** Early weeks get a full worked explanation of the concept in play (Jay's example: walking through *why* hidden information/randomness creates excitement in something as familiar as Rock-Paper-Scissors, not just naming the concept and expecting students to see it). Later weeks should progressively shrink that explanation and open the reflection prompts toward fully independent noticing — same gradual-release shape as the journal thread's word-count progression.
- **Built:** `courses/python/game_of_the_week/_TEMPLATE_reference.html` (Rock-Paper-Scissors, generic placeholder content per the component-library-first rule — Jay's real game list hasn't been provided yet) and `courses/python/game_of_the_week/README.md` documenting the design above. Nothing beyond the template exists; real weekly content is blocked on Jay's game sheet.
- **Scope:** Python-specific for now. Whether this extends to Game II/Web Dev is an open question, not decided either way.

---

## 2026-08-06 — Designed the Guess-the-Number revisit/iterate spine across the Python course

**Context:** Jay asked for a course-wide "revisit and iterate" mechanic that's meaningful without being boring, offering several possible shapes (a finite small-project progression, one larger incrementally-built project, a series of abandon-and-restart projects, Python turtle as a recurring thread) and asking for a design recommendation, not a guess.

**Decided:**

- **One primary thread, not a new mega-project**, built by connecting projects that were already independently planned in `course-plan.md` without anyone having noticed they formed a sequence: Unit 06's project was already "Number Guessing Game," Unit 11's was already "Game of Chance," Unit 14's was already "Safe Input System," and Unit 03's own existing Game/UX tie-in text already said its input-usability seed "gets revisited properly once exception handling exists (Unit 14)."
- **Required spine:** Unit 05 (single guess, if/elif feedback) → Unit 06 *(existing project)* add a `while` loop, guess-until-correct or bounded-attempts as a real choice → Unit 11 *(existing project)* swap the fixed target for `random.randint()` → Unit 14 *(existing project)* add try/except so bad input doesn't crash it. Four touchpoints, weeks apart, each unlocked by a tool that unit just taught, stopping at 14 — a real ceiling, not endless iteration.
- **Optional bonus tail**, using the tiered-XP pattern already built into lesson 01.4: Units 08-10 (track guess history, sort a leaderboard), Unit 16 (save high scores to a file — this absorbs the "one big incrementally-built project" idea instead of running a second parallel mega-project), Unit 19 (bonus: refactor into a class, alongside that unit's own real project, not replacing it).
- **Python turtle graphics kept as a separate, purely visual thread** for Units 06-07 only (draw a shape → loop to repeat it → package as a function → call with different parameters to compose a bigger image) — additive alongside existing GMetrix-aligned content in those units, not a replacement, since GMetrix content is certification-required.
- **Not yet built:** none of this has real lesson content written yet; this is the confirmed design, pending rollout once Units 05/06/11/14 are authored.

---

## 2026-08-04 — Removed self-naming, numbered lesson subfolders, and made the journal a directly-editable file

**Context:** Further feedback on Unit 01: instructions should be even more explicit; students shouldn't have to rename files with a codename, since Jay's own script handles renaming and real-name stripping after Classroom collection and before anything reaches Claude Code; lesson subfolders should be numbered so completion order is unambiguous just from looking at the folder; and writing tasks (the journal specifically) should hand students a real file to edit directly rather than a read-only prompt page plus an expectation they create their own file.

**Decided/built:**

- **No more self-naming with a codename.** Reversed the `{codename}_lesson_XX_YY.py` convention platform-wide — every file now ships with a fixed name; students edit and save the provided file, never renaming or constructing a filename themselves. The whole lesson folder goes to Classroom as-is, already tied to the student's real Classroom identity; Jay's codename-swap script does the renaming and real-name stripping afterward, before anything reaches `05-grader/` or Claude Code. This removed the `file_naming_points` rubric line from `lesson-schema.md` — there's no self-naming task left to grade. Updated `lesson-schema.md`, `vscode-content-conventions.md`, and `codename-policy.md`'s Student-Facing Rules to match. Unit 01's project file renamed from `unit_01_project_starter.py` to `unit_01_project.py` (drop the "_starter" suffix and the rename-before-submitting instruction) as the concrete example.
- **Lesson subfolders are now number-prefixed**, added across all 6 Unit 01 lessons: `1_content`, `2_examples` (where present), `3_flashcards`, `4_practice`, `5_mastery_check`, `6_journal` (where present). Same number always means the same folder type across every lesson, so a missing folder (e.g. no `2_examples` in a pre-syntax lesson) just leaves a gap rather than renumbering. Every internal link across all 27 HTML files in the unit was updated to match — verified no stale references remain. `mvp-unit-folder-structure.md` updated as the canonical convention going forward.
- **Journal redesigned as a single editable `.txt` file**, replacing the earlier HTML-prompt-page-plus-separately-created-file design. `6_journal/unit_01_journal.txt` now has the prompt, grading rubric, and academic-integrity notice written directly at the top as plain text, ending with a "write your answer below this line" marker — the Learner opens it in VS Code, writes, and saves, nothing new to create. New general principle documented in `vscode-content-conventions.md` and `mvp-unit-folder-structure.md`: provide an editable file with instructions built in, not a read-only page, wherever a Learner needs to write something. The project starter already followed this instinct; apply it to future writing tasks by default.
- **More explicit instructions added at the unit level**: `unit_01_overview.html` now states the numbered-folder convention directly ("look at the folder with the next number") and states plainly that no renaming or codename-adding is needed, rather than leaving both as things a student has to infer from individual lesson pages.
- Fixed lingering `"user"` → `"player"` instances found while touching the project instructions, missed in the earlier terminology pass.

**Superseded:** the `{codename}_lesson_XX_YY.py` file-naming convention and its rubric line, everywhere it appeared; the unnumbered `content/`/`examples/`/`flashcards/`/`practice/`/`mastery_check/`/`journal/` folder names, everywhere in Unit 01 and in `mvp-unit-folder-structure.md`'s canonical description; the HTML-only journal prompt page.

---

## 2026-08-06 (later still) — Reviewed Jay's prior-year Sample Content; adopted a complete grading/feedback spec; confirmed AI-use policy stays all-or-nothing for now

**Context:** Jay added `FoxCS/Sample Content/` — real prior-year teaching materials (project banks, a full Unit 1 packet with real pacing/due dates, a grading-feedback spec, rubrics, an exam, a game-concept reference list) to inform this year's redesign. A research agent read every file in full; findings preserved in `00-project-overview/source-material/sample-content-review-2026-08-06.md`, this entry covers what was decided as a result.

**Decided:**

- **Validated the current numbered-file lesson structure directly against a real prior failure.** The old U1L3 packet needed a student to track down 6+ separate files/links for one lesson, with objectives copy-pasted across 4 of them and the rubric duplicated across 2 — no single source of truth. This isn't hypothetical justification for the current design; it's the actual problem it fixes.
- **Adopted `Sample Content/ai_autograder_feedback_guidance.md` as `05-grader/feedback-and-grading-spec.md`**, the canonical feedback-voice/rubric/output-format spec for the eventual grading engine — see `05-grader/README.md`'s new section. This is a complete, ~1290-line spec Jay had already written: feedback voice rules, an 8-step feedback pattern, rubric-preservation rules, a mastery-check label set, a capped and teacher-gated bonus mechanism, a full JSON output schema, an Academic Integrity section that flags rather than accuses, and 7 worked example feedback blocks. This directly resolves the "sample teacher feedback responses" task queued earlier in the session — the examples already existed, they just needed to be found and positioned correctly.
- **AI-use policy stays all-or-nothing (no change) for the start of the year, with a confirmed future direction.** A real prior exam (`Unit 1 Exam_ Python Basics (V2) SY26.pdf`) allowed documented AI use (screenshot/chat-link per question) as its own graded rubric category, undocumented use forfeiting credit only for that part — a materially more permissive model than FoxCS's current written policy (any AI use = 0 + Aspen record). Asked Jay directly rather than silently reconciling the two. Confirmed: the exam's flexibility was a later-in-year evolution, intentionally introduced only once foundational skills were established without AI — not the starting policy. FoxCS's existing all-or-nothing policy is correct for now; a documented-use pathway is real future intent (specifically for using AI to break down problems, check work, or walk through confusion) but not to be built yet. Noted in `01-privacy-and-governance/academic-integrity-ai-use.md`'s new "Future Direction — Not Active Yet" section so this isn't lost or built prematurely.
- **Found real precedent for "iterate on an earlier activity"** (Wasteland Adventure → Wasteland 2.0: The Expansion Pack, a real, scheduled, 11-days-later revisit where students return to their own original code at their own original tier and receive direct escalations of the same graded categories) — but **Jay's specific example (input → later add a loop → first bounded-guess-count then guess-until-correct) does not exist in any prior material.** This is confirmed as a new design to build, modeled on the Expansion Pack's shape, not something to port. Not yet designed or built.
- **Found an existing student-choice framework worth adapting**, not yet adopted into FoxCS: three prior project banks (Python 21 entries, Unity 17, Web Dev 27) share a Prompt / What You'll Make / Core Skills / Creative Twist / Challenge Mode format, all inviting full free-choice ("come up with your own project, using these for inspiration"). Not yet built into FoxCS's structure.

**Not yet decided / not yet built, flagged rather than guessed at:** whether/how to build a FoxCS-native project-bank system modeled on the old ones; the concrete design for a real "revisit and iterate" mechanic (Jay's guess-count → guess-until-correct example specifically); whether the Game Concept Categories list, Game Studio Concept Project, or Climate Action App workbook structures get adapted into FoxCS directly or stay reference-only.

---

## 2026-08-06 (later still) — Removed the fabricated video embed from real lesson content; built a real, browsable component library instead

**Context:** After the video-embed and interactivity-survey entry below, Jay clarified: he didn't want a fabricated video embedded in real lesson content — he's building toward a proper component library so the *functionality* is proven and available, not toward finished-looking placeholder content. He then asked specifically for this to be a real HTML file he could open and click through, not a written doc. While that was in progress, he tried the placeholder video anyway and got a real YouTube **Error 153** ("invalid video player configuration") — direct, concrete confirmation that the placeholder was fabricated content, not a working example, which is exactly the distinction he'd just drawn.

**Decided/built:**

- **Removed the video embed entirely from `01_instruction.html`** (Lesson 01.4's real instructional page) — no video section, no iframe, no placeholder ID. Real lesson content should never contain something that fails when actually used.
- **New `02-authoring-system/component-library/index.html`** — a single, self-contained, real HTML page Jay opens directly in a browser to see and test every interactive pattern FoxCS has built. Deliberately uses generic, non-curriculum demo content (fruits, sandwich-making steps, simple sentences) throughout, specifically so nothing on this page could ever be mistaken for authored lesson material.
- Twelve components cataloged, each with a status badge:
  - **Live in 01.4** (7): flip card, single-line block builder, multi-line indentation-aware block builder, dropdown blank, typed blank, combined blank, drag-to-match.
  - **New — demoed here first, not yet deployed** (2): **categorization** (drag into labeled bins) and **sequencing** (drag to reorder), the two types identified in the interactivity survey below but not yet built anywhere. Built as real, working, generic demos here specifically so Jay can review and approve the mechanic before it's invested into real 01.2/01.3/01.6 content — same "prove one reference first" pattern used for the vocab quiz and Lesson 01.4 itself.
  - **Pattern documented, not deployed** (1): video embed. Shows only the proven responsive-aspect-ratio container (a `<div>` with a padding-based 16:9 trick) with **no iframe and no URL at all** — not even a placeholder one — plus the exact HTML snippet (with a `{{REAL_VIDEO_ID}}` template token, not a fake-real-looking ID) to drop in once actual video content exists. Documents the Error 153 incident directly in the page's own description as the reason this component stayed pattern-only rather than "demoed live."
  - **Toy demos of two cross-cutting mechanisms** (2): save-in-place (a plain textarea wired to the real `showSaveFilePicker` API, so Jay can test the save-and-reopen behavior in isolation) and the password gate + unlock-timestamp convention (demo password `DEMO01`).
- Each component links back to its real reference implementation in Lesson 01.4 (file path named directly) so the library stays a pointer to working code, not a second copy that could drift out of sync.

**Superseded:** the video-embed section of `01_instruction.html` from the entry immediately below (built, then removed same day). The interactivity-survey findings and the categorization/sequencing identification from that same entry are NOT superseded — they're now demonstrated as working code here rather than just described in prose.

---

## 2026-08-06 (later still) — Video embed, indentation-aware sneak-peek drag-drop, combined dropdown+typed blank, and an interactivity survey of Unit 01

**Context:** Jay asked what else could be more interactive across Unit 01, specifically wanting drag-and-drop/matching/sequencing to be a real part of the content (not just the vocab quiz), plus embedded video with visible player controls, a demonstrated example of drag-and-drop that respects proper code indentation and structure, and a combined exercise where some blanks are dropdown-selected and others are freely typed by the student.

**Surveyed Unit 01 for interactivity gaps.** Lesson 01.4 has the richest toolkit so far (block-builder, vocab-matching quiz). Lessons 01.1, 01.2, 01.3, 01.5, 01.6 are still on the plainer pre-2026-08-06 engine — that gap closes naturally via the already-queued rollout of the 01.4 pattern (see the entry above). Identified three genuinely distinct drag-drop types worth adding to the toolkit beyond matching/block-building, each mapped to where it fits best rather than applied generically: **categorization** (drag items into labeled bins — strong fit for 01.2's Input/Process/Output sorting and 01.6's SyntaxError-vs-NameError sorting) and **sequencing** (reorder a scrambled list of already-formed lines — strong fit for 01.3, which is literally about the fact that Python runs lines in the order they're written). Not yet built — flagged for when the broader rollout happens, not built piecemeal ahead of it.

**Video embed, decided and built.** Jay chose hosted video (YouTube or similar) over local `.mp4` files or a plain placeholder. Implemented on `01_instruction.html` using **`youtube-nocookie.com`** — YouTube's privacy-enhanced embed domain, which sets fewer tracking cookies than the standard `youtube.com/embed` domain — as a reasonable default consistent with FoxCS's existing privacy stance, not something Jay was explicitly asked to pick between. Native player controls (play/pause/volume/scrubber/fullscreen) are visible by default; nothing suppresses them. **The embedded video ID is a placeholder** (`REPLACE_WITH_REAL_VIDEO_ID`), clearly marked as such in a comment — no real video exists yet, and per this assistant's own standing rule against guessing/inventing URLs, a real ID was never fabricated. Jay needs to swap in a real video ID before this reaches students.

**Indentation-aware drag-drop, built as a labeled bonus, not core content.** Unit 01 doesn't actually teach anything that requires indentation yet (`if`, loops, and functions don't start until Units 05-07), so building a "real" indentation example into Unit 01's graded content would have meant front-loading a concept ahead of its actual place in the curriculum. Instead, built **Drill 7** on `05_practice.html`: a two-line, indentation-visible block builder previewing a simple `if` statement (`if health <= 0:` / `    print("Game Over")`), explicitly labeled "Bonus — Sneak Peek at Unit 05." Each line has its own token bank and its own drop target; the second line's row is visually indented via a CSS left-border/padding treatment so the structural relationship is visible without asking the student to construct indentation themselves (they're not taught comparison operators like `<=` yet either, so `health <= 0` is one atomic draggable token, not something they assemble from parts — kept honest about what's actually in scope this early). Both lines are checked together on one "Check Both Lines" button. This is the general mechanic FoxCS now has available whenever a future lesson (Units 05-07 especially) needs a real indentation-respecting block-builder — the multi-line-row-with-independent-token-banks pattern generalizes directly.

**Combined dropdown + typed blank, built as Drill 6** on the same practice page: one sentence, two blanks — a dropdown (print's required capitalization) and a free-typed blank (the word for quoted text) — checked together, with feedback naming which specific blank(s) still need work if either is wrong. This is a genuinely different exercise shape from the existing standalone dropdown-only and typed-only drills (which test one isolated blank each), not a duplicate.

**Fixed two stale filename references found while working in these files** (leftover from the vocab-quiz renumber a few hours earlier): `05_practice.html`'s own intro text and header comment still said `05_practice.py` instead of `06_practice.py`. Worth noting as a reminder that every renumber needs a full-file text sweep, not just href/link updates — plain prose mentions of a filename are just as easy to miss.

**Not yet built:** the three categorization/sequencing drag-drop exercises identified in the survey (01.2's I/P/O sort, 01.3's line-reordering, 01.6's error-type sort) — flagged for the broader Unit 01 rollout, not built ahead of it as one-offs.

---

## 2026-08-06 (later same day) — Added a drag-to-match vocab quiz as the real XP-earning flashcard-study activity, replacing self-assessment entirely

**Context:** Jay had asked earlier the same day how to give XP for studying flashcards. The self-assessment rating feature built and then dropped earlier in the day (see the entry below) was one attempt; this is the concrete resolution — a vocab-matching quiz that doubles as the study activity and the graded submission at once.

**Decided/built:**

- New `04_vocab_quiz.html` on the Lesson 01.4 reference implementation, inserted right after flashcards (`03_flashcards.html`) — a drag-and-drop (plus click-to-place, since native HTML5 drag-and-drop isn't reliable on every input device) term-to-definition matching quiz, reusing the exact same 5 term/definition pairs as that lesson's flashcards.
- Both the term-bank order and the definition-slot order are shuffled **independently**, so position can't be used as a shortcut.
- Wrong drops bounce back with a brief shake animation and stay retryable — no shame language, consistent with `content-voice-and-tone.md`. This can be brute-forced by trying every combination, which is an accepted tradeoff for a matching format, not a design flaw.
- **Save is gated on 100% correct** — there's no partial-completion save state, because completing the quiz correctly *is* the submission. This is a deliberate difference from every other save-in-place page built so far (flashcards had no save at all; feedback/mastery-check-adjacent pages saved whatever was filled in). Reopening an already-completed file shows the finished state immediately via a `data-completed` flag baked into the saved HTML, rather than resetting to a fresh unsolved quiz.
- **On save, the filename gets a `_completed` suffix** (e.g. `04_vocab_quiz.html` → `04_vocab_quiz_completed.html`) — Jay's own idea, and a good one: it makes completion status visible from a folder listing alone, no need to open the file to check.
- Extended `lesson-schema.md`'s `xp:` block with a `vocab_quiz` value.
- **Inserting this file required a full renumber of the rest of Lesson 01.4** — everything from the old `04_practice.html` onward shifted up by one (`04→05`, `05→06`, ... `10→11`), since the numbering rule is strict: contiguous, no gaps, per lesson. Every cross-reference (hrefs, `<code>`-tag filenames mentioned in instructions, `currentFileName()` JS fallbacks, the "Continue to X" links) was checked and fixed — verified with a scripted sweep afterward that no stale references to the old numbers remained anywhere in the lesson folder.
- `mvp-unit-folder-structure.md` updated: the folder-tree diagram now includes `04_vocab_quiz.html` at its correct slot with the rest renumbered, and a new "Vocab Quiz" section documents the pattern (shuffle-independently, save-gated-on-completion, `_completed` suffix) as the reference for building this into future lessons.

**Superseded:** nothing content-wise — this is additive to the same-day reference implementation. File numbers 04 through 10 in `lesson_01_04_printing_output/` all shifted by one; any external note referencing the old numbers for that lesson (there shouldn't be any left, but worth knowing if one turns up) is stale.

---

## 2026-08-06 — Major simplification pass: dropped Monaco/Pyodide, moved mastery checks and code practice to plain VS Code files, redesigned practice as Duolingo-style drills, added tiered project XP, redesigned feedback as a saved HTML form, and wrote a corrected color/design-system doc

**Context:** A long design conversation, starting from "should mastery-check coding questions use a Monaco-style embedded IDE" and ending in a real simplification of the whole Unit 01 interactive-content approach. Several ideas were proposed, researched, and then deliberately walked back once their actual cost became clear — recorded here in full so a future session doesn't re-propose the same discarded paths without knowing why they were dropped.

**Researched and rejected: Monaco and Pyodide/Klipse for in-browser code execution.**
- Checked `adaptive-python`'s own docs directly rather than trust the "Waypoint uses Monaco" assumption: `docs/architecture/ide-architecture.md` (marked `status: stable`, far more detailed) states explicitly *"no Monaco, no browser runtime, no WebView... The editor does not use a third-party editor library."* A separate, less-detailed doc (`docs/ux/mobile-coding-experience.md`) mentions a "Monaco Editor Strategy" but reads as a stale, superseded plan. Waypoint's actual shipped choice is a styled `TextInput`/textarea, not a real editor library — validating the same tradeoff FoxCS needs (no bundler, no build step, plain static HTML).
- Separately researched H5P's "Interactive Code" content type (real, exists, built on Klipse, which uses Skulpt for Python 2 and Pyodide for Python 3 to execute code fully client-side, no server). Verified self-hosting is possible via npm but Pyodide itself is a real 10-30MB runtime download **every browser session**, whether self-hosted or CDN-hosted — self-hosting moves *where* the download comes from, not *whether* it happens. Also flagged Klipse's GPLv3 license (a copyleft license; likely a non-issue since FoxCS would only be linking/embedding it via script tag, not modifying and redistributing its source, but explicitly not legal advice).
- **Decision: skip both.** The deciding fact, once surfaced: students already have Python installed via VS Code. Browser-based execution solves a problem FoxCS doesn't have, at a real ongoing cost (large per-session downloads, a license to track, another moving system). Real code execution already happens for free in VS Code, which every other lesson file already uses.

**Redesigned mastery checks — coding answers move to plain `.py` files.** The mastery-check HTML page is now *just* the password-gated prompt sheet: plain, readable questions once unlocked (multi-variant still works — separate password per version — but the earlier base64-obfuscation-of-hidden-variants approach is dropped along with it, since there's no longer any answer content embedded in the page to protect; the questions themselves were already the thing being password-gated). The actual answers go in a paired `NN_mastery_check.py`, edited and saved in VS Code exactly like every other coding file. This also retired the custom "Save My Work" File System Access API mechanism *for mastery checks specifically* — nothing left in that file needs a save button, since VS Code's own Ctrl+S does the job.
- **Open/timing signal, resolved:** since answers are now a plain file with no page-level JS running while the student works, there's no automatic open/save logging. Landed on the lightest option that doesn't reintroduce save-in-place machinery: the password-gated page displays a timestamp the moment it unlocks, and the student is asked to paste it as a comment at the top of their answer file before starting. Explicitly not tamper-proof (a student could fake it), but it's genuinely lightweight and gives the same cross-day audit signal Jay wanted (does the timestamp in a submission match when that student's section actually had the password) without new code.

**Redesigned practice — Duolingo-style drills, genuinely disposable.** `04_practice.html` is no longer the earlier stateful Reinforce/Core/Extend routing engine — it's now a flat list of independent, replayable drills: click-to-build code-block exercises, dropdown fill-in-the-blank, typed fill-in-the-blank, all auto-checked, all plain JS (no libraries). Nothing here is saved, because nothing here is evidence — it's repetition. The actual hands-on code-writing practice moved to a new paired `05_practice.py`, saved normally in VS Code, which is where "typing real print() statements" actually belongs.

**Tiered XP added to the project/application step.** `06_project.html` now has a Required tier (must-complete) plus Tier 1 and Tier 2 bonus checklists worth escalating XP, extending the existing `xp:` block described in `lesson-schema.md`. Bigger applications in future lessons can span multiple numbered exercise files instead of one.

**Feedback redesigned twice in the same conversation, worth recording both turns.**
1. First pass: a "Copy My Answers" button that formatted form input into text the student would paste into a separate `.txt` file. **Jay rejected this explicitly** — "I do not want them to fill it out in one place, copy it to another, and turn it in a complex way." 
2. Also considered and set aside: a real Google Form → Sheet pipeline (genuinely simple to build, but is new infrastructure outside FoxCS's self-contained-folder model, and Jay's stated goal was pulling from *fewer* places, not adding one) and a Google Sites hosting layer (same reasoning — would add a location, not remove one, since everything already works as plain files with zero hosting needed).
3. **Landed on:** an HTML form (click 1-5 scale ratings, type short answers) using the *same* save-in-place mechanism already built for mastery checks/flashcards — click through, click Save, the browser writes the filled-in form directly back to the same file. No copy-paste, no second location, no new backend. This is the mechanism Jay was actually asking about when he asked why Chrome warns "this site can see changes you make" (answered: that's the expected File System Access API permission prompt, not an error).
4. `feedback-collection.md`'s question bank was reused and updated: dropped the stale "how helpful was the Moodle content" item (Moodle's paused), added a new open-ended question asking which flashcard vocabulary terms are still fuzzy.

**Per-term flashcard self-assessment — tried, then deliberately dropped in the same session.** Jay initially asked for a per-term "I know this / still learning" rating that would persist (so weak vocabulary could be flagged across the class). Built it (rating buttons + the save-in-place mechanism, ratings serialized back into the page's own script tag on save) — then Jay reconsidered: *"instead of adding complexity with the flashcards"*, fold that signal into the feedback form's open-ended vocab question instead, in the student's own words, which is richer data anyway (specific term names and *why* they're confusing, not just a binary rating). Flashcards were reverted to pure flip-only practice: no save mechanism, no filesystem writes, nothing to submit. This is recorded in detail because it's a real example of "build it, then realize the simpler version was better" — worth remembering as a pattern, not just an outcome.

**New color/design-system doc** (`02-authoring-system/design-system.md`), triggered by a real, found defect: the flashcard deck's solid-blue card back with white text measured 4.42:1 contrast, just under WCAG AA's 4.5:1 minimum for normal text, and a pale-blue label on that same background measured 3.59:1. Computed a corrected palette (primary interactive blue `#1a5aa8`, verified 6.84:1 with white; primary interactive amber `#9a5a00`, verified 5.47:1) and documented it as the required reference for any future color pairing, rather than continuing to eyeball colors per page. Deliberately scoped small — a color-usage contract plus a few structural rules, not a full spacing/typography design system, since that would be premature for content still finding its shape.

**Reference implementation, not yet rolled out.** All of the above was built completely on **Lesson 01.4 only** (`courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/`), now a 10-file numbered sequence (`01_instruction.html` through `10_feedback.html`). Lessons 01.1, 01.2, 01.3, 01.5, 01.6 still run the earlier engine (stateful practice routing, embedded-textarea mastery checks, old un-corrected colors) from the prior session's pass. This is deliberate — the goal was proving the new pattern on one lesson before repeating the rework a third time across the whole unit. Rolling this out to the other 5 lessons is the natural next step, not yet done.

**Superseded:** the stateful Reinforce/Core/Extend practice-routing JS engine (`mvp-unit-folder-structure.md`'s prior description of `04_practice.html`); the embedded-textarea-plus-save-in-place mastery-check answer format; the base64-obfuscated multi-variant mastery-check design from the 2026-08-04 session (still valid in spirit — multi-variant/password-gating stays — but the obfuscation mechanism specifically is gone since there's no longer answer content to hide); the old, AA-failing color values (`#2a78d6` and `#eda100` as filled-background-with-white-text colors) wherever they're touched going forward, per `design-system.md`.

---

## 2026-08-04 — Journal relocation, flip-animation flashcards, save-in-place mechanism, multi-variant obfuscated mastery checks, and an assessment-content protection policy

**Context:** Feedback on the just-built Unit 01, arriving as several distinct notes in close succession: journal should live inside a lesson folder, not a separate unit-level one; flashcards should feel like a natural part of the lesson with a real flip animation and stronger visual hierarchy; "Save My Work" should overwrite the file in place rather than download a new copy; mastery checks should ship as several password-gated variants so releases across multiple days/sections can be cross-checked for timing; those variants' content shouldn't sit as plain readable text in the page source; and a new instruction that assessment content must never be disclosed to a student who asks, in any session working with this repo.

**Decided/built (proof of concept on Lesson 01.1's trio, then rolled out where noted):**

- **Journal moved into the lesson it's thematically about.** Was a unit-level `journal/` folder sibling to the lesson folders; now lives inside `lesson_01_02_input_process_output/journal/`, since the Unit 01 journal prompt is about Input-Process-Output. New principle documented in `mvp-unit-folder-structure.md`: content that belongs to one specific lesson lives inside that lesson's folder, even if it's tracked at the unit level for cadence (the journal is still one-per-unit, not one-per-lesson — only its physical location changed). The Unit Project is the one deliberate exception, since it draws on every lesson and doesn't belong to just one.
- **Flashcards rebuilt with a real CSS 3D flip animation** (`perspective` + `rotateY` + `backface-visibility`) replacing the earlier instant class-swap, plus stronger visual hierarchy: labeled Term/Definition faces, a progress bar, and primary (flip navigation) vs. secondary (shuffle/restart) button grouping. Rolled out across all 6 lessons.
- **"Save My Work" now tries to overwrite the file in place**, not download a new copy. Uses the File System Access API (`showSaveFilePicker`) where available (Chrome/Edge, including ChromeOS). First save in a session asks the Learner to pick the file once (suggesting its own current name, so re-selecting it overwrites); the handle is then reused silently for the rest of that page session. Falls back to a classic download for browsers without the API. Rolled out across all 6 lessons' practice pages and mastery checks. Practice pages also got a real bug fix: reopening a file saved mid-progress would have re-rendered and duplicated the starting question on top of the already-answered ones baked into the saved HTML — fixed with a check that skips the initial render if the question log already has content.
- **Multi-variant, password-gated mastery checks.** Built on Lesson 01.1 as the reference implementation: 3 passwords (6-character alphanumeric, matching the format of real certification exam codes, per Jay), each unlocking a different but equivalent version of the same 3 questions (different scenario nouns, identical objectives and DOK). On unlock, the page records which variant and the browser-clock timestamp, displayed and saved as part of the submission — lets Jay cross-check a saved file's variant/timestamp against when that student's section actually took it. **Not yet rolled out to the other 5 lessons** — writing genuinely distinct variants is real additional authoring per lesson, not a toggle.
- **Content obfuscation for mastery checks.** The original multi-variant build still rendered all 3 variants into the page as hidden `display:none` divs, exposing everything to a plain View Source regardless of password. Fixed: each variant's question HTML is now base64-encoded as a JS constant and only decoded via `atob()` + injected into the DOM after a correct password. Stated plainly in three places (`mvp-unit-folder-structure.md`, the `_KEY.md`, this entry): this is the same honesty as the password gate itself, a speed bump against casual view-source reading, not real encryption — a student who pastes the encoded string into a console and decodes it can still read it.
- **New instruction: never disclose assessment content to a student who asks.** Added to `../CLAUDE.md` (a new "Protecting Assessment Content" section) and cross-referenced from `01-privacy-and-governance/academic-integrity-ai-use.md`. Applies to any session working with this repo, regardless of how the request is framed; does not restrict Jay's own work, which is the normal case here. Students don't have Claude Code access at school; this defends against a student encountering this content another way (e.g. a personal subscription at home).
- **Fixed a real bug found while doing this work, unrelated to any of the above asks:** an earlier scripted em-dash cleanup pass had introduced actual newline characters into a JS string literal (`'<!DOCTYPE html>\n'`) instead of leaving the escaped `\n` intact, and a separate script bug had written the full Windows file path instead of just the filename into a save-fallback default. Root cause: this environment's Bash tool mangles backslash sequences when invoking the native Windows Python via inline `-c`/heredoc arguments (an MSYS/Git-Bash quirk) — writing fix scripts to real files via the Write tool and then executing them sidesteps it. Both bugs are fixed across all affected files; noting the root cause here so a future session doesn't re-introduce it the same way.

**Not done, flagged rather than attempted:** multi-variant + obfuscated content for Lessons 01.2-01.6's mastery checks (only 01.1 has it); real device/browser testing of the save-in-place mechanism, especially over `file://` (already flagged in `05-grader/README.md`'s Testing Needs, still open).

---

## 2026-08-04 — Interactive practice engine, password-gated mastery checks, navigation clarity, and the Waypoint copywriting guide (largest single pass of the session)

**Context:** Several requests arrived in quick succession while Unit 01 was already built: (1) flashcards with example-reveal for syntax terms, (2) build Unit 00 too, (3) convert practice from static files to a self-contained interactive HTML that delivers Reinforce/Core/Extend questions progressively and lets a Learner save their work, (4) password-gate mastery checks (soft, Jay-managed) and make navigation between pieces "as streamlined as possible" since folder structures confuse students, (5) never use em dashes in curriculum copy, write explicitly for ELL/IEP/504 students, and follow "Waypoint Learning high school version" copywriting rules — followed shortly by Jay providing the actual guide (`waypoint_curriculum_copywriting_guide.md`) and asking that Learning and Language objectives be explicitly identified per lesson.

**Decided/built:**

- **Interactive practice engine**, one shared JS pattern reused across all 6 Unit 01 lessons: starts at a Core question, routes to Reinforce (wrong) or Extend (right) per the existing sticky-endpoint ladder rule, appends each answered question to the page so it builds up as a visible record, and ends with a "Save My Work" button (JS Blob download, prompts for codename to build the filename). Auto-checked types: multiple-choice/multi-select and predict-output (exact string match). Self-attested types (code-writing/debugging): a "Show Model Answer" reveal plus an "I'm Done" continue button, since client-side JS can't execute or grade arbitrary Python. Routing logic lives in the page's JS but is never narrated to the Learner — satisfies "wiring present, not surfaced."
- **Flashcards**, same reused pattern per lesson: click-to-flip term/definition, plus a "Show Example" button that only appears on cards tagged with a code example (i.e., only from Lesson 01.3 onward, once real syntax exists). Shuffle and restart included.
- Replaced the old scattered `practice/reinforce/`, `practice/core/`, `practice/extend/` files and separate `ANSWER_KEY.md` with the single interactive `practice/lesson_XX_YY_practice.html` per lesson, across all 6 lessons — old files deleted, not left alongside the new ones.
- **Mastery checks upgraded**: real `<textarea>` inputs (not empty `<div>`s meant to be hand-edited) plus a "Save My Work" button, matching the practice page's pattern. **Password gate added, explicitly flagged as not real security** — a client-side JS check Jay uses to control pacing (when a group can start), fully visible via page source, not a barrier against a determined Learner. Placeholder passwords (`unit01-lessonNN`) marked "CHANGE ME" so this doesn't ship with a guessable default forever.
- **Navigation clarity**, per Jay's "folder structures are confusing for students": every lesson's instructional page now has a numbered "What To Do Next" list with real clickable `<a href>` links to flashcards/practice/mastery check (previously these were `<code>` path text a Learner would have had to find manually), and each mastery check links directly to the next lesson (or the Unit Project, for 01.6). Practice pages' completion box links directly to that lesson's mastery check.
- **No em dashes.** Retroactively cleaned up across all 38 already-written curriculum files via a scripted pass (heading em dashes → colon, body-prose em dashes → sentence break, which also serves the plain-language goal), then hand-fixed several places where two em dashes forming a parenthetical had been mangled into broken sentence fragments by the blind script. Added the rule to `content-voice-and-tone.md` and memory so new content doesn't reintroduce it.
- **`waypoint_curriculum_copywriting_guide.md` adopted as the primary curriculum-copy reference**, superseding most of `content-voice-and-tone.md`'s prior content (which is now a short FoxCS-specific supplement, not the main source). Real, detailed guide: Learner-variability design principles, cognitive-load rules, Reinforce/Core/Extend copy characteristics, feedback-progression patterns, and a full "I can..." objective-writing system.
- **Terminology reversed: "Learner" (capital L), not "student," in curriculum copy.** This directly reverses an earlier explicit FoxCS decision ("real classroom, use the real word"). Flagged the conflict and asked Jay directly rather than guessing either way, given the retroactive cost of guessing wrong in either direction — confirmed "Learner." Also reversed "user" → "Learner"/"player"/"person" depending on context, per the guide's parallel rule. Scope: applies to Learner-facing curriculum copy only (instructional pages, flashcards, practice, mastery-check questions, journal prompts, project instructions) — not to internal/author-facing docs (privacy policy, decisions-log, teacher-only mastery-check `_KEY.md` files) where "student" still correctly describes real people in a real school. Retroactively fixed the handful of real instances found in Unit 01's visible prose (most of the content already used direct "you" address, so the actual footprint was small).
- **Learning and Language objectives made explicit**, per the guide's Section 7-8 "I can..." formula, added to all 6 Unit 01 lessons' instructional pages as two clearly labeled lists (previously one generic "What you'll learn" list that blended both). Learning objectives use observable verbs (explain, identify, write, predict, fix); language objectives name the specific vocabulary terms in bold, tied to the lesson's actual language demand.

**Not done — flagged, not attempted this pass:**
- A full prose rewrite of Unit 01 against every rule in the new Waypoint guide (cognitive-load sequencing, feedback-progression staging, etc.) — the guide is far more detailed than what was used to author Unit 01 originally. Applied the concretely-requested pieces (objectives, terminology, em dashes); a full alignment pass against the whole guide is a separate, larger task not yet scoped.
- Unit 00 itself — next up.

**Superseded:** the "student" terminology decision from earlier sessions (`content-voice-and-tone.md`'s prior "What Changes for FoxCS" table row); the old scattered practice-file structure for Unit 01 (`mvp-unit-folder-structure.md` still describes that structure — needs a follow-up update to describe the interactive-practice + flashcards pattern as the new default, not yet done).

---

## 2026-08-04 — Documented codename-swap script, grading-engine, and testing requirements (not built — captured so they don't get lost)

**Context:** Jay asked to document these three needs explicitly rather than leave them scattered across worklog mentions.

**Decided:** Added a "Tooling Needed" section to `01-privacy-and-governance/codename-policy.md` (codename-swap script — purpose, input/output, open dependency on the Classroom-download-format question). Consolidated everything gathered so far into `05-grader/README.md` — a "Requirements Gathered So Far" section (codename-swap intake dependency, AI-authenticity check + mandatory human-review gate, mastery-check `_KEY.md` as the auto-grading source, journal rubric, practice self-check keys being intentionally student-visible) and a "Testing Needs" section distinguishing pilot-loop testing (the whole Classroom distribute/submit/swap/grade chain) from interactive-content testing (the new JS practice HTML on real school devices/browsers, Chromebooks especially). Cross-linked from `open-questions.md`. Nothing built — this is a documentation-only pass.

---

## 2026-08-04 — Built Unit 01 end-to-end in the new MVP folder format — the first real content, not just design docs

**Context:** With the folder structure, journal thread, and academic-integrity policy all designed, Jay confirmed the human-review safeguard and said to build Unit 01 for real — the first actual test of whether the MVP format holds up against real content, per the worklog's own "confirm or break the design while it's cheap to change" plan.

**Decided/built:**

- Full unit at `courses/python/content/unit_01_what_is_programming/`: a unit overview page, all 6 lessons (01.1-01.6) each with instructional HTML, examples where code exists, Reinforce/Core/Extend practice files, a visible self-check answer key, and a mastery check with a teacher-only key — plus the Unit Project (Interactive Greeting) and the Unit 01 journal prompt. 46 files total.
- Sourced real question/misconception material from `adaptive-python` where it existed (TSVs for 01.1/01.3/01.6, JSON draft banks for 01.2/01.5, the full teaching-content exemplar for 01.4) rather than writing from scratch — per `course-plan.md`'s own Reuse Notes — but rewrote everything in FoxCS's voice (`content-voice-and-tone.md`) and scaled practice volume down hard: ~5 practice items per lesson across all three lanes plus a 3-4 item mastery check, nowhere near adaptive-python's 75-180-question-per-lesson banks.
- **Caught a real scope bug before it shipped:** the adaptive-python-derived project title "Interactive Greeting" implies using `input()`, but Unit 01 doesn't teach `input()` (Unit 03) or variables (Unit 02) — building the project as literally interactive would have required tools students don't have yet. Resolved by explicitly scoping the project to a *scripted preview* of an interactive exchange, using only `print()` and comments, with the instructions naming this limitation directly rather than quietly pretending the project uses real input. Noted as a nice forward callback: Unit 03 can reference "remember your Unit 01 project?" once real `input()` exists.
- Wove the game-design/UX tie-ins from the same day's earlier pass into the actual instructional content for every lesson (not just the course-plan.md summary line) — e.g. 01.4's usability idea (specific, readable output vs. a bare error code) became a real practice/mastery-check task, not just a mentioned concept; 01.6 reframed debugging explicitly as the QA/playtesting habit referenced in Unit 13's plan.
- Every mastery check got a teacher-only `_KEY.md` (DOK-tagged answers, common misconceptions named) kept out of the folder that would ever go to students — first real exercise of the two-copy model from `mvp-unit-folder-structure.md`.
- Marked all of Unit 01's checkboxes ✅ drafted (not 🔍 reviewed) in `course-plan.md`, per `content-authoring-standards.md`'s own rule that drafted and reviewed aren't the same status — this content hasn't been reviewed by Jay yet.
- Used a single shared plain-HTML/CSS template across every page, explicitly not visually polished — flagged in a header comment on every file pointing at the still-pending image-style-guide update, so restyling happens once, consistently, not page-by-page.

**Not done, flagged rather than guessed at:** whether this is the right depth/pacing for a real class period per lesson; whether the practice/mastery item counts feel right once a real student works through them; the journal-file distribution mechanics (zipping, Classroom upload) haven't been tested with an actual folder yet.

**Superseded:** nothing — first real content, no prior draft existed for Unit 01.

---

## 2026-08-04 — Journal grading rubric + AI-use academic integrity policy; clarified "scrappy" scope; added general game-mechanics vocabulary

**Context:** Follow-up to the same day's game-design/journal pass. Jay gave the actual grading criteria for journal entries, a hard academic-integrity rule about AI-generated writing and code, and two clarifications: (1) "scrappy" MVP delivery must not be read as license for lower-quality content, and (2) game-mechanics learning should also exist in a more general form, not only as specific as each unit's individual Python tie-in happens to be.

**Decided:**

- **Journal grading rubric**, added to `courses/python/course-plan.md`'s Journal Threads section: thoughtfulness + completion of the ask; genuine reflection rooted in the unit's actual concept, not a generic pre-existing opinion; stated opinions must be justified and tied to a reference/source when relevant (the game analyzed, the concept, a GMTK episode); the writing should sound like the student's own voice. Still lighter-touch than literary/grammar grading — the skill being built is thinking in writing about design, not prose polish.
- **New academic-integrity policy, platform-wide:** AI-generated writing or AI-generated code submitted as a student's own work is forbidden — consequence is a 0 on the assignment and a logged incident in Aspen (the school's SIS/documentation system). New file `01-privacy-and-governance/academic-integrity-ai-use.md` is the canonical record; `course-plan.md`'s journal section states the journal-specific instance and links back rather than duplicating.
- **Added an explicit safeguard not stated by Jay but treated as required given the stakes:** extended the existing Release Gate principle (`data-boundaries.md` — nothing AI-generated reaches a student without teacher approval) to also cover *punitive* findings, not just released outputs. An AI-authenticity flag is a recommendation for human review, never an automatic 0/Aspen action — AI-detection tools have real false-positive rates, and a wrongly-flagged student facing a permanent record is a serious-enough harm to warrant this even though Jay didn't ask for it explicitly. Flagged this addition clearly rather than silently building an auto-punish pipeline.
- **"Scrappy" scope clarified** in `../CLAUDE.md` and `02-authoring-system/mvp-unit-folder-structure.md`: it describes delivery mechanism only (folders instead of Moodle H5P, one repeatable structure across 4 courses instead of bespoke engineering) — never content quality, depth, or rigor. Added explicit notes in both files so this doesn't get misread in a future session.
- **General Game Mechanics Vocabulary** table added to `course-plan.md`, alongside the MDA primer: nine named mechanic categories (Core Loop, State & Resource Tracking, Rules & Decision Systems, Player Actions & Abilities, Progression & Feedback, Chance & Risk/Reward, Failure States & Forgiveness, Pacing & Time Pressure, Entities & Systems Architecture), each mapped to where it already shows up in the existing per-unit tie-ins. This is an assumption about what "bring in game mechanics learning in a more general way" meant — a named, reusable taxonomy layer on top of the specific per-unit connections, introduced in Unit 00 alongside MDA — flagged as a first cut, not confirmed as the intended reading.
- Updated `open-questions.md`: logged the AI-detection tool choice as open, and marked the human-review-before-punitive-action question as resolved for this specific case (general confidence-threshold question elsewhere stays open).

**Superseded:** the "exact grading rubric... isn't set yet" line from the same-day Journal Threads entry — replaced with the real rubric above; point/XP value is still unset.

---

## 2026-08-04 — Threaded game design, MDA framework, UX/HCD, and a year-long journal into FoxCS: Python

**Context:** Jay asked for "one more pass through the Python course" to make it feel like a genuine game-design class throughout — not just Python syntax with game theming bolted on at the end — including the MDA framework (Mechanics/Dynamics/Aesthetics) and student analysis/reflection, submitted as `.txt` "journal" files in some cases. Explicit progression: 50-100 words early, building to ~2-page papers by year's end, iterative (later entries build on earlier ones). Mid-task, Jay also added: Game Maker's Toolkit (GMTK) videos are already watched with the class and reflected on, and should be considered for inclusion.

**Decided:**

- Read the full `course-plan.md` (all 21 units) before touching anything, so the tie-ins land on real unit content rather than generic game-themed filler.
- Added a *Game/UX tie-in* line and a *Journal* line to every one of the 21 units in `course-plan.md`, plus a new trailing "Game Design, UX, and Journal Threads" section holding the shared rationale (MDA primer, word-count progression table, grading philosophy, file/naming convention, GMTK tie-in table) — written once rather than repeated 21 times.
- **MDA introduced in Unit 00**, deliberately before students have coding skill to build any of it — matches Jay's explicit "even if they do not always get to practice this... I want them to have some concepts to keep it engaging." Revisited with growing sophistication at Units 05 (if/else as Mechanic), 11 (randomness — the deepest MDA moment, paired with the existing "Game of Chance" project), 19 (classes as game-object architecture — the biggest payoff), and 20 (capstone synthesis) — each revisit explicitly instructs the student to look back at an earlier entry, which is what makes it iterative rather than four disconnected mentions.
- **Word-count progression:** 50-75 words (Unit 00) → 500-700 words / ~2 pages (Unit 20), across 4 rough stages (Warm-Up/Describing/Analyzing/Synthesizing), deliberately not a perfectly even staircase. Made an assumption explicit rather than guessing silently: "2-page paper" is treated as ~500-700 words (typical double-spaced HS-essay page count) — flagged for Jay to correct if his actual expectation differs.
- **Usability/HCD** kept as a real but lighter throughline than Game II/Web II will get (per the existing Platform Decisions note in `../CLAUDE.md`) — seeded at Unit 03 (input surprises), paid off properly at Unit 14 (exception handling reframed as the strongest usability unit in the course, tying to Nielsen's error-prevention/recovery heuristics), not front-loaded before students can act on it.
- **Journal is a unit-level artifact** (one per unit, 21/year), not per-lesson — matches the existing practice/mastery-check "avoid busy work" volume caps already established ([[project-foxcs-practice-philosophy]] in memory). File convention: `journal/unit_XX_journal_prompt.html` + `journal/{codename}_unit_XX_journal.txt`, extending `02-authoring-system/mvp-unit-folder-structure.md`'s folder tree and naming table (updated accordingly) — `.txt` by default even for the shortest entries, per Jay's "these can be txt files... like journals," with the option (not requirement) to embed the very shortest Stage-1 entries elsewhere instead.
- **Grading philosophy stated explicitly, not left implicit:** journals graded for genuine, specific engagement (same principle as existing lesson reflections' `skip_check_required`), not literary/grammar quality — this is a CS class, and grading prose quality would both misrepresent the goal and blow the 1-hour/week grading budget. Exact rubric/points/XP not set yet.
- **GMTK videos:** folded into the same journal thread rather than a separate activity (watch as a class → reflect in that unit's journal entry). Mapped *why* a GMTK episode would fit well at Units 00, 05, 06, 11, 14, 19, and 20 (by topic), but did not name or link specific episodes — Jay already has episodes he uses; per this assistant's own rule against guessing URLs for non-programming purposes, exact titles/links need to come from him.
- Updated `courses/python/CLAUDE.md`'s Content Model section to point at the new thread and to reflect the Moodle-paused MVP delivery mapping (previously stale, still described the old Moodle/VS Code split as current).

**Superseded:** nothing — additive to `course-plan.md`, `mvp-unit-folder-structure.md`, and `courses/python/CLAUDE.md`. The GMetrix tie-in lines and unit checklists are untouched.

---

## 2026-08-04 — Designed the MVP unit-folder structure and naming convention

**Context:** Following the Moodle-pause pivot (entry below), Jay asked to start on the folder structure and naming convention for the MVP. Read the existing schema first (`lesson-schema.md`, `vscode-content-conventions.md`, `templates/lesson-template.md`, `codename-policy.md`) rather than inventing something new — the goal was extending what already existed, not a parallel scheme.

**Decided:**

- New file `02-authoring-system/mvp-unit-folder-structure.md` is the canonical reference. Key finding that shaped it: the `practice/reinforce/core/extend` folder structure in `lesson-schema.md` was *already* a static, non-live-engine ladder before Moodle's Lesson activity revived a live version on 2026-07-24 — so the MVP doesn't need to invent a self-navigation mechanism from scratch, it reverts to what was already designed, plus an explicit self-check step (a visible `ANSWER_KEY.md` in `practice/core/`, with routing instructions narrated in the instructional HTML instead of engine-enforced).
- Unit folder naming (`unit_XX_slug`) is new but extends the existing pattern exactly — `lesson_id` already carries a slug (`lesson_01_04_printing_output`), so the unit folder does the same on top of the existing bare `unit_id` (`unit_01`).
- Instructional content (video/H5P/guided practice/vocabulary) becomes `content/lesson_XX_YY_instruction.html`, baked-in per lesson. This isn't a new concept introduced for the MVP — `lesson-template.md` already had a precedent for local, non-Moodle HTML ("Stuck Support (local HTML, non-answer-revealing)"); the MVP just extends that same idea to carry the main instructional content too, not just stuck-support pages.
- **Explicit two-copy model:** the authoring source (this repo) and the distributed student copy (what actually goes to Google Classroom) are not the same folder — mastery-check answer keys, rubrics, and teacher notes must never be in the distributed copy. Flagged the export step needed to produce that copy safely as not-yet-built tooling, same urgency tier as the codename-swap script.
- Added a small "MVP Delivery Mapping" table to `lesson-schema.md` (field → file) and a short naming addendum to `vscode-content-conventions.md`, rather than duplicating the schema — the underlying authoring standards (objectives, DOK, skills) don't change, only where Moodle's fields physically land.
- Resolved two `open-questions.md` items as part of this (naming convention; ladder-without-a-live-engine). Added new ones: the student-copy export script, and whether curated existing third-party Unity content will need this same distribution treatment later.

**Superseded:** nothing — this is new, additive documentation. The paused Moodle docs (`moodle-lesson-ladder-setup.md`, `moodle-quick-pilot-workflow.md`) are unchanged.

---

## 2026-08-04 — Course catalog clarified: 4 courses, Game I/II + Web II framing, Unity as a student-chosen lane

**Context:** While the folder-structure work above was in progress, Jay filled in the actual course catalog across two messages — this had been an open question (`CLAUDE.md` only listed 3 courses; Jay had said there were 4).

**Decided/clarified (still forming — Jay's own words: "perhaps this may look like something else"):**

- **Game Programming I** = the existing FoxCS: Python course. Structured/sequential (Unit 00 → 01 → 02...), unchanged.
- **Game Programming II** = JavaScript/HTML5 app-dev content, historically paired with end-of-year Unity exploration time if there was room. That priority is reversing: students may now choose to focus on **Unity only** for the year if they prefer — JS is not required. Needs curated *existing* third-party Unity content (e.g. Unity Learn) for platform familiarization, not just FoxCS-original material — licensing not yet checked.
- **Web Dev**, also referred to as **"Web II"** = HTML/CSS/JavaScript, usability/human-centered design as an explicit focus (more so than other courses), a PHP-or-similar backend for data storage.
- **Game II and Web II share a pedagogical model** distinct from Game I: goal-setting and independent student exploration, with heavy scaffolded support, rather than a fixed unit-by-unit sequence. Students choose a path across Game II/Web II content rather than following one fixed track.
- **Not resolved:** whether "Unity" remains a separately-named course/folder (as originally planned in `CLAUDE.md`'s Courses table) or is now fully absorbed as a lane inside Game II. Logged as open rather than guessed at.
- Updated `CLAUDE.md`'s Courses table to reflect the clearer parts (Game I/Game II/Web II framing, the Unity-lane note, the independent-exploration pedagogical split) and flagged the unresolved part explicitly rather than picking one reading.
- **Not yet done, flagged in `open-questions.md`:** whether Game II/Web II's independent, choice-driven structure fits the sequential `unit_01/unit_02/...` folder model designed above at all — likely needs a different (menu/choice-board) shape once those courses are actually built. Not designed yet; Game I stays the first real build target.

**Superseded:** the flat 3-course Courses table (Python/Web Dev/Unity, no pedagogical distinction) from the 2026-07-24 session's initial structure.

---

## 2026-08-04 — Paused Moodle, pivoted to an MVP: self-contained unit folders submitted via Google Classroom

**Context:** Session picked up from the 2026-07-24 worklog plan (build H5P/Lesson-ladder/VS Code samples for lesson 01.4, research Pyodide/JupyterLite, author real mastery-check content). Before starting, Jay redirected: *"I am thinking we should pivot to the absolute MVP version of this content... I want to focus on making the core content and the grading engine so I can refine this as I am able."* Confirmed explicitly: *"This is essentially pausing the moodle project and pulling the same logic into creating folders of content that will support the same learning."* Also: 4 courses need to be written, and the priority is a scrappy, repeatable version across all of them before polishing any one — *"I think it would be most helpful to do that in the scrappiest way to start. Then later, I can worry about the rest."*

**Decided:**

- **Moodle work is paused, not abandoned.** The Two-Surface Delivery Model, `moodle-lesson-ladder-setup.md`, `moodle-quick-pilot-workflow.md`, and `h5p-authoring-and-automation.md` are kept as-is for when Moodle resumes — not rewritten or deleted. Reasoning for the pause: core content and the grading engine are the actual bottleneck; Moodle H5P/Lesson-activity production is authoring-expensive and shouldn't consume cycles before the underlying content and grading loop are proven, especially across 4 courses.
- **MVP replacement:** one self-contained folder per unit — instructional HTML pages with learning content baked directly in, supplemental materials, and practice/mastery-check files, under a meaningful naming convention (not yet designed — see `open-questions.md`). The same instructional logic the Moodle plan carried (DOK spread, the Reinforce/Core/Extend ladder, visible objectives) needs to be re-expressed as self-navigated folder content instead of a live Moodle engine — exact mechanism (e.g., an answer-key-driven "if you missed this, open X" pointer inside the HTML) not yet designed. Flagged as an open question rather than guessed at.
- **Submissions move to Google Classroom for the MVP phase**, reversing the 2026-07-24 "Moodle is system of record" correction — that decision assumed live Moodle content existed to submit against, which is no longer the near-term plan. Students submit their codename folder directly in Classroom. Moodle resumes as system of record once two-surface content is actually built. Updated `CLAUDE.md`'s Platform Decisions table accordingly.
- **New privacy/grading requirement surfaced:** a script to strip real student names and swap in codenames on download, before anything reaches an AI grading tool — this is now a concrete, near-term requirement for `05-grader/` (or an intake step ahead of it), not a someday item. Not yet built.
- **Image style guide update pending from Jay, not yet delivered:** Jay has been separately designing an updated visual/image-generation style reference for the instructional-content illustrations and said he'll bring it in later. `02-authoring-system/image-style-guide.md` already exists with a validated color palette and principles from the earlier session — treat Jay's forthcoming version as a replacement/update to reconcile against, not a from-scratch addition.
- **Scope correction:** FoxCS actually has **4 planned courses**, not the 3 listed in `CLAUDE.md`'s Courses table (Python, Web Dev, Unity). The 4th hasn't been named yet — flagged in `open-questions.md`, not guessed at.
- Did not touch: `02-authoring-system/lesson-schema.md`, `authoring-workflow.md`, `content-authoring-standards.md`, `objectives-and-skills-proficiency.md`, or the mastery-check standards updated earlier this session — those describe authoring logic (objectives, DOK, skills, mastery-check content) that's surface-agnostic and carries forward into the folder format unchanged. What changes is delivery mechanism, not authoring standards.

**Superseded:** `CLAUDE.md`'s Purpose/Status sections and the Submissions row of its Platform Decisions table, as written through the 2026-07-24 session. The Two-Surface Delivery Model section itself is marked paused-for-reference, not superseded — see the note added at its head.

---

## 2026-08-04 — Reconciled `starter/skilled/legendary/mythic` band vocabulary: kept as a cosmetic label, not adaptive-python's routing structure

**Context:** Left unresolved at the end of the 2026-07-24 session (`worklog.md`). `mastery-check-standards.md` had flatly dropped adaptive-python's difficulty-band vocabulary in favor of FoxCS's DOK rubric. Jay pushed back: *"I do want to keep the starter/skilled/legendary/mythic potentially. Folks seemed to respond to this but if it doesn't fit authentically and meaningfully then we can skip it."*

**Decided:**

- Checked what the bands actually do in adaptive-python (`python-app/docs/content/question-complexity-model.md`): they're one axis of a 4-band × 3-lane progression matrix, crossed with `question_complexity` (isolated/integrated/transfer/synthesis) and enforced via `prerequisite_objectives` gating (the Handoff Rule). That's structural, not decorative — and it's exactly the deep multi-level branching complexity the 2026-07-24 entry already retired in favor of FoxCS's shallow, 3-lane Reinforce/Core/Extend ladder (`02-authoring-system/objectives-and-skills-proficiency.md`). FoxCS also has no adaptive engine to enforce band-to-band handoffs. So the bands cannot come back as a structural/routing mechanism — that door stays closed.
- What *can* come back: the vocabulary itself, as a purely cosmetic, student-facing label layer, fully decoupled from routing. The internal authoring axis stays DOK — that's what actually drives question design and feeds `dok_levels_covered`. A band name is just an optional skin on top, for the motivational effect Jay observed.
- Found a clean mapping rather than inventing one: adaptive-python already restricts its own mastery checks to its two hardest bands only (`legendary`/`mythic`, never `starter`/`skilled`) — which lines up naturally with FoxCS's existing DOK 2-3 skew for mastery checks. Adopted: **DOK 2 → "Legendary"**, **DOK 3 → "Mythic"** as optional display labels on mastery-check items. `starter`/`skilled` stay unused in mastery checks (matching adaptive-python's own rule) but remain available as optional flavor labels elsewhere (e.g. practice-item difficulty) if a future lesson wants them — not required now, not authored yet.
- Updated `02-authoring-system/mastery-check-standards.md`'s "Difficulty bands" bullet accordingly. No other file touched — `objectives-and-skills-proficiency.md`'s Reinforce/Core/Extend Ladder section never referenced band vocabulary, so there was no conflict to reconcile there.

**Superseded:** the flat "adaptive-python's `starter/skilled/legendary/mythic` doesn't exist in FoxCS" line from the 2026-07-24 mastery-check-standards entry — narrowed to "doesn't exist as a structure," not "doesn't exist at all."

---

## 2026-07-24 — Mastery-check authoring standards ported from adaptive-python

**Context:** Jay asked to audit whether mastery-check authoring is already documented in `adaptive-python`, and build the guidance if not.

**Decided:**

- It's already documented, thoroughly — `docs/content/mastery-check-schema.md` (module-level) and `curriculum/schemas/MASTERY_CHECK_LESSON_README.md` (lesson-level, plus a template TSV). This was a port-and-scale-down task, not a from-scratch build.
- Kept unchanged: backwards design (author the mastery check before lesson practice content — it defines the target), one primary objective per item, preference for deterministic/auto-gradable validation (more important for FoxCS than for adaptive-python, since there's no coderunner plugin and no grading engine yet — every open-ended item is a manual-grading cost against the 1-hour/week budget), status lifecycle mapped onto FoxCS's existing course-plan.md legend rather than a second vocabulary.
- Scaled down: question count from adaptive-python's 8-12/lesson + 20-25/module to **3-5 per lesson mastery check** (stacking a large second question set on the already-tight 10-15-per-lesson practice cap isn't right); difficulty bands (`starter/skilled/legendary/mythic`) replaced with FoxCS's own DOK rubric, skewed DOK 2-3.
- **Dropped entirely: a separate unit-level mastery-check file.** adaptive-python has both lesson- and module-level checks, with the module-level one testing cross-lesson synthesis. FoxCS already has a home for that — the Unit Project (e.g. "Interactive Greeting") already requires combining skills across a unit's lessons. A second unit-level quiz on top of it would be redundant volume, against the same "avoid busy work" principle from the practice-ladder work earlier today.
- New file: `02-authoring-system/mastery-check-standards.md`, cross-linked from `content-authoring-standards.md`. Open item: whether lesson mastery checks live in Moodle or VS Code — leaning Moodle, not confirmed until the first real one is built.

---

## 2026-07-24 — Unit 01 content inventory complete; systemic mastery-check gap found

**Context:** Jay wants to sample his drafted content against Unit 01's actual learning/language objectives and identify what's still needed, ahead of building a real pilot lesson.

**Decided/found:**

- Full inventory of `adaptive-python`'s existing content for Unit 01 (01.1-01.6 + project), read directly from source files, written up in `courses/python/unit-01-content-inventory.md`.
- **The real gap is systemic, not scattered:** every mastery-check file in the unit — all six per-lesson files plus the unit-level one — exists but has zero data rows. Practice-question content exists in some form for every lesson except 01.2 and 01.5 (which only have draft JSON banks, no TSV). The unit project (`project_module_01.tsv`) is a header with zero rows — no project content exists at all.
- Found a bonus resource: `curriculum/exemplar/lesson_01_04_printing_output/` is a fully-authored lesson package (objectives, 14 teaching content blocks, questions, test conditions) — the most complete single lesson in the unit, worth using as the template for what a fully-authored FoxCS lesson record should contain.
- Language-objective coverage is better than expected without any dedicated tagging — `written_response` questions already require students to use target vocabulary in their own explanation, which maps directly to language-objective evidence once re-tagged.
- Priority for next authoring: mastery checks (missing everywhere) and the unit project (missing entirely) over more practice-question sampling, since practice content already exists in some form for 4 of 6 lessons.

---

## 2026-07-24 — Reteach page says "your teacher," not "Mr. Fox" — generalized for other pilot testers

**Context:** Jay wants to have other teachers test this course too, not just run it himself — so student-facing content can't hardcode his own name.

**Decided:**

- `moodle-lesson-ladder-setup.md`'s Reteach page instruction now says "check in with your teacher," not "see Mr. Fox." Jay being Mr. Fox is still true and still useful context for design instincts (real teacher, real classroom, not an abstract institution) — it just can't leak into actual student-facing copy.
- General rule going forward: any FoxCS content a student would actually see must reference "your teacher" generically, never a specific teacher's name — even though Jay himself is the primary/first author and pilot instructor.

---

## 2026-07-24 — Scoped a quick-pilot Moodle workflow; resolved the Reteach exit; adaptive-python's JSON pipeline confirmed out of scope

**Context:** Jay clarified the actual near-term goal: not a robust production import pipeline, just getting a small real sample of content into Moodle fast to test whether it reads well to students. He also resolved the one open item from the ladder-setup doc.

**Decided:**

- adaptive-python's JSON-generation/import-pipeline docs (`content-import-pipeline.md`, `json-generation-guidelines.md`, `spreadsheet-schema-guide.md`) are confirmed **not relevant** to the Moodle side — that's production tooling for the app itself. Dropped from the worklog's next-session plan.
- Surveyed adaptive-python's actual existing content directories (`python-app/curriculum/json/`, `questions/`, `projects/`) as the real sampling source Jay meant by "the skeletons I've built so far." The `json/lesson_XX_YY_mc.json` files are the best source — code is already safely embedded (escaped strings, not raw spreadsheet cells) and each question already carries `difficulty_band` and `practice_lane` tags that map onto the ladder. The `.tsv` question files carry more metadata but risk the original tab/whitespace problem for lessons with code-heavy prompts — prefer JSON when both exist.
- New file: `02-authoring-system/moodle-quick-pilot-workflow.md` — practical answers to "what does uploading content into Moodle actually look like": manual Question Bank entry (default for this first pilot) vs. GIFT-format text import (faster at volume, but its `{ }~=#` syntax collides with Python code containing dicts/f-strings — flagged explicitly); H5P authored directly in Moodle's built-in browser editor (skip the `.h5p`-package-generation plan for this phase, that's for later scale); the Lesson-activity ladder using only Tier 1 (fully manual) from `moodle-lesson-ladder-setup.md`, ignoring Tiers 2-3 until the content itself is validated.
- **Resolved the last open item in `moodle-lesson-ladder-setup.md`:** when a student exhausts the last Reinforce item and is still wrong, they're routed to a static **Reteach page** (brief re-explanation), then directed to see the teacher (Jay — "Mr. Fox") in person. Not another auto-served question — a real conversation is the right next step at that point.

---

## 2026-07-24 — Moodle's Lesson activity will implement the Reinforce/Core/Extend ladder live, kept light

**Context:** Jay decided he'll be using Moodle's Lesson activity structure often for this ladder, with an explicit instruction to keep it light.

**Decided:**

- The Reinforce/Core/Extend ladder (formalized earlier today — see the entry below) runs live in Moodle via `mod/lesson`, not only as a weekly-batch tip as originally proposed. This partially brings back the Lesson-activity mechanism that was superseded in the very first 2026-07-24 entry — but what got retired there was the *depth* (many-level branching tree) and spreadsheet-based authoring, not Lesson activity as a mechanism. This is explicitly the shallow 3-lane version, not a return to the old design.
- "Keeping it light" defined concretely: one branch point per skill checkpoint (Core question, wrong→Reinforce page, right→Extend page, no answer-specific branch targets beyond right/wrong), Reinforce/Extend loop within their own lane per the sticky-endpoint rule, page count per skill checkpoint tracks the pool-size cap directly (not padded beyond it), and one reusable page/branch template across skills so authoring stays fast.
- VS Code-side practice is unaffected — still static files, still driven by the weekly tip system, since there's no live grading engine for code submissions.
- H5P's Branching Scenario content type is no longer a live-branching candidate to evaluate — Lesson activity is the pick, so checking whether Branching Scenario is installed on this instance is no longer necessary.
- Documented in `02-authoring-system/objectives-and-skills-proficiency.md` (Reinforce/Core/Extend Ladder section) and `CLAUDE.md` (Two-Surface Delivery Model Superseded note, updated in place to reflect the partial revival).
- Added `02-authoring-system/moodle-lesson-ladder-setup.md`: the click-by-click mechanics (Moodle Question pages, Answers, Jumps — no plugin needed, this is core Moodle), a worked example building one skill's Core/Reinforce/Extend page cluster, and a 3-tier sustainability path (manual in the Lesson editor first; templated export/import via Moodle's backup XML if that gets painful across 21 units; Web Services automation only if templating still isn't enough). Left one open item: what happens when a student exhausts the last Reinforce item and is still wrong — not decided, doesn't block the pilot lesson.

---

## 2026-07-24 — Formalized the Reinforce/Core/Extend routing ladder

**Context:** Jay proposed simplifying practice-question routing to three lanes with one move per attempt (Core→Reinforce on wrong, Core→Extend on right, sticky endpoints so a repeated wrong/right stays in-lane rather than going deeper), sized with roughly double the pool in Reinforce/Extend vs Core, and asked how deep the ladder should go.

**Decided:**

- Confirmed depth of exactly 3 lanes, no deeper — a 4th-level "Reinforce of a Reinforce" would recreate the branching-tree complexity that already got the old per-question branching design (`templates/question-branching-template.csv`, Moodle-Lesson-branching) superseded.
- Pool-size guideline: Core 1-2, Reinforce 2-4, Extend 2-4 per skill.
- This ladder runs as the logic behind the already-speced "Keep Practicing"/"Strong Here" weekly tips in `objectives-and-skills-proficiency.md`, not as live in-Moodle branching — consistent with the no-adaptive-engine, weekly-batch-grading constraint. Checked the local Moodle install: its built-in "Adaptive" question behaviour only retries the same question with a penalty, it doesn't route between different question pools, so it doesn't implement this on its own. Two native mechanisms could do live routing later if ever wanted — Moodle's Lesson activity (core, confirmed present) or H5P's Branching Scenario content type (not confirmed installed — H5P content types load from the H5P Hub at runtime, needs a live check) — neither needed for the pilot lesson.
- Documented in `02-authoring-system/objectives-and-skills-proficiency.md`, new "Reinforce / Core / Extend Ladder" section.

---

## 2026-07-24 — Added `content-authoring-standards.md`: DOK rubric, universal design, question documentation

**Context:** Jay asked to port over adaptive-python's guidance on writing content — voice/tone (already done in an earlier session), universal design/approachability, and varied DOK levels — into a single trackable FoxCS doc for how activities/questions get written and documented.

**Decided:**

- Read through adaptive-python's `docs/content/`, `docs/ux/`, `docs/learning-science/`, and `docs/ai/` docs (question-complexity-model, taxonomy-and-tagging-system, objective-writing-guidelines, accessibility-strategy/pattern-library, cognitive-load-strategy, content-quality-assurance, ai-validation-pipeline, retrieval-practice-model, learning-science-foundations) to find what's actually portable.
- **Finding: adaptive-python has no real DOK rubric.** "DOK 2, 3, or 4" appears as unexplained shorthand in three architecture docs, never defined. What it has instead is its own `question_complexity` axis (`isolated → integrated → transfer → synthesis`) and an objective-sequencing progression (`recognition → interpretation → application → debugging → synthesis`) — useful cross-references, not something to port directly. Built FoxCS's own Webb's-DOK-based rubric (levels 1-4, with Python-specific examples) from scratch instead, since `lesson-schema.md`'s `dok_levels_covered` field already existed with no rubric behind it — this resolves that gap.
- Ported the parts of adaptive-python's universal-design/accessibility guidance that are actually about *content* (plain language, no assumed background, chunking, coherence, one-concept-per-unit, vary problem context, contiguity between explanation and code) — explicitly excluded everything that's app-UI-specific (screen readers, touch targets, contrast ratios), since FoxCS delivers through Moodle + VS Code, not a mobile app.
- Ported a lightweight version of adaptive-python's question/content documentation standards (misconception → recovery pairing, real variants instead of padded repeats, status tracking, staged hints) — explicitly scaled down from adaptive-python's multi-role review pipeline (schema/technical/instructional/accessibility sign-off, telemetry validation, staged rollback), which is sized for a much bigger team than FoxCS has.
- New file: `02-authoring-system/content-authoring-standards.md`. Cross-linked from `lesson-quality-standards.md` (which referenced "DOK level" and "accessibility considerations" with no rubric behind either) and `lesson-schema.md`'s `dok_levels_covered` note. Added to the folder-structure table in root `CLAUDE.md`.

---

## 2026-07-24 — Renamed "Module" to "Unit" across FoxCS (course-plan.md and shared authoring docs)

**Context:** Jay asked whether "Unit" or "Module" reads better for a high school audience, before any lesson content gets authored.

**Decided:**

- FoxCS now calls the top-level curriculum grouping a **Unit**, not a "Module" — it's the term students already have automatic from every other high school class, where "Module" reads more like a corporate/college LMS.
- This is a FoxCS-only naming choice, platform-wide (applies to every future FoxCS course, not just Python). It does **not** touch `adaptive-python`, which keeps calling them Modules — Jay was explicit about not wanting that project's naming changed. "Unit NN" in FoxCS docs always corresponds 1:1 to "Module NN" in `adaptive-python`'s `Curriculum_Python Fundamentals.md`.
- Renamed everywhere it meant the curriculum-grouping concept: `courses/python/course-plan.md` (all 21 unit headers and every cross-reference), the canonical schema field (`02-authoring-system/lesson-schema.md` and `templates/lesson-template.md`: `module_id` → `unit_id`), `templates/grading-rubric-template.md`, `02-authoring-system/authoring-workflow.md`, `02-authoring-system/objectives-and-skills-proficiency.md`, `02-authoring-system/vscode-content-conventions.md`, root `CLAUDE.md`, `courses/python/CLAUDE.md`, and `open-questions.md`.
- Left every reference to Python's own `import`-style modules alone (e.g. "Importing Modules," "The Math Module," "Built-in Modules" in the GMetrix Domain 6 table) — those are a different, unrelated meaning of "module" and were never in scope.
- Did not edit past entries in this log — it's append-only, so earlier entries below still say "Module" because that was the term in use at the time. Also fixed one unrelated stale line noticed in `templates/lesson-template.md` while in there: VS Code submissions said "via Google Classroom," which contradicted the 2026-07-24 Moodle-is-system-of-record decision above — corrected to Moodle.

**Superseded:** the word "Module" as FoxCS's own term for this concept, everywhere except inside `decisions-log.md`'s historical entries and references to `adaptive-python`'s own file/field names.

---

## 2026-07-24 — Corrected GMetrix numbering: preserve the workbook's exact Domain/Lesson/Objective structure

**Context:** Jay flagged that the GMetrix domain/lesson/objective numbering must be kept exactly as the workbook has it — students reference the actual workbook and support files directly, so nothing in `course-plan.md` should rename, renumber, or loosely paraphrase that structure.

**Decided:**

- Confirmed the workbook actually runs on two numbering axes: **Domain → Lesson** (pacing grouping, e.g. "Domain 1 Lesson 6") and **Objective → item** (exam blueprint numbering, e.g. "1.3.4"), which don't correspond 1:1 — one Lesson can span multiple Objectives and vice versa. Support filenames follow the Objective axis (digit 1 = Domain, digit 2 = Objective, digit 3 = item), not the Lesson axis. Documented this precisely at the top of `course-plan.md` as the canonical decode key.
- Corrected a real error from the earlier mapping pass: `134-arithmetic.py` and the other `13X` operator files had been mislabeled as Objective `1.4.X` ("Select Operators") when they're actually Objective `1.3.X` ("Sequence of Execution") — a different Lesson (6-7 vs 8-9) and a different exam objective entirely. Every module note citing a Domain 1 operator file was corrected, and each now also cites its `14X` companion file (Domain 1 actually teaches every operator type twice, once per objective — both are short, both are Domain 1, both are now included rather than picking one arbitrarily).
- Also corrected Module 08: Indexing is Domain 1 **Lesson 3** (Objective 1.2.2), not Lesson 4 as previously written.
- Where the workbook's own text lists a project file as "N/A" but a matching file exists in the `Student/` folder anyway (this happened several times — Domain 6's `621-math.py`, `611-io.py`, `614-sys.py`; Domain 5's `531-unittest.py` and others), flagged it explicitly rather than asserting false precision, with a note to confirm against the actual workbook page during authoring.
- Every module's GMetrix tie-in note now cites both the Domain/Lesson and the Objective/item number, matching the workbook's own language exactly, per file.

**Superseded:** the topic-level-only (no objective numbers, and one confirmed wrong objective number) GMetrix citations from the refinement pass immediately below.

---

## 2026-07-24 — Refined GMetrix mapping: one-domain-per-activity, operators split by type

**Context:** Jay asked for a deeper pass on the GMetrix mapping added earlier today — read the actual PDF content (not just the table of contents) and the actual support files, with the explicit goal that students shouldn't have to track more than one GMetrix domain at a time unless jumping around is genuinely helpful.

**Decided:**

- Extracted the full workbook text (`pdftotext`, all 125 pages, 82 numbered exercises) and read every "Steps for Completion" / "Project Details" block, plus sampled actual starter files (`111-str.py`, `531-unittest.py`, etc.) to confirm the real shape of GMetrix content: tiny (2-16 line) starter files, 5-15 minutes each, tightly scoped to one concept.
- That changed the read on the "domain-hopping" risk: the danger isn't a domain resurfacing across multiple modules over the year (fine — that's just spaced repetition), it's a single *activity* blending files from two different `Domain N/Student/` folders at once. Added an explicit **one-domain-per-activity rule** to `course-plan.md` to make this the standing authoring constraint.
- Found that Domain 1's "Select Operators" lesson (assignment/comparison/logical/arithmetic/identity/containment, objectives 1.4.1-1.4.6) was vaguely anchored at Module 05 in the earlier pass. On closer reading, each of the six operator types already has an exact-match FoxCS module that teaches that same concept — **split it accordingly**: assignment → Module 02, arithmetic → Module 04, comparison/logical/identity → Module 05, containment → Module 10. Each landing spot stays single-domain and single-concept; this isn't hopping, it's four small check-ins instead of one overloaded week.
- **Resolved the identity-operator open question** from the earlier pass: `is` vs `==` now lives in Module 05, next to comparison operators.
- Removed the earlier vague Module 03 tie-in to Domain 1's indexing content — indexing now lives entirely in Module 08 with the rest of Domain 1 Lesson 4, keeping Module 03 a clean Domain-3-only (console I/O) stop.
- Found "command-line arguments" is taught twice in the workbook — once under Domain 3 Lesson 3 (`323-command.py`), once under Domain 6's `sys` lesson (`614-command.py`, objective 6.1.4 explicitly covers it). Module 18 (where FoxCS actually teaches command-line execution) uses Domain 6's own copy — no need to reach back into the Domain 3 folder.
- Added specific filenames to every module's GMetrix tie-in note (previously lesson-topic-level only) so authoring can go straight to the right file.

**Superseded:** the looser domain-level (not file-level) GMetrix tie-in notes and the unresolved identity-operator gap from the 2026-07-24 mapping entry below.

---

## 2026-07-24 — Verified course-plan.md against adaptive-python source; mapped GMetrix domains onto it

**Context:** `courses/python/course-plan.md` claimed to be sourced from `adaptive-python`'s `Curriculum_Python Fundamentals.md`, and `02-authoring-system/vscode-content-conventions.md` flagged the GMetrix Domain 1-6 → module mapping as not yet done.

**Decided:**

- Verified `course-plan.md` module-by-module against the source curriculum file — every module and lesson title matches exactly, no drift.
- Extracted the GMetrix/Certiport domain and objective structure from `Python_v2_Student_Workbook.pdf` (LearnKey "Python v2," IT Specialist – Python exam) via `pdftotext`, cross-checked against the numbered practice files in `Python v2 Support Files/Domain 1-6/Student/`.
- Added a per-module "GMetrix tie-in" line to every module in `course-plan.md`, plus a consolidated "GMetrix Domain Mapping" table and gap list at the end of the file.
- Identified two genuine coverage gaps where GMetrix has no content: Module 09 (tuples/dictionaries) and Module 19 (classes/OOP — not on the exam at all). Both stay entirely FoxCS-original; not a mistake, just documented so nobody goes looking for GMetrix source material that doesn't exist.
- Identified one gap in the other direction: GMetrix's Domain 1 covers the identity operator (`is` vs `==`), which no module in the `adaptive-python`-derived skeleton currently teaches. Added to `open-questions.md` — needs a decision on which module absorbs it (leaning Module 05, near comparison operators).
- Updated `vscode-content-conventions.md`'s stale "not done yet" note to point at the new mapping.

**Superseded:** the "mapping not done yet" note in `vscode-content-conventions.md`.

---

## 2026-07-24 — Reconciled braindump + handoff docs into FoxCS structure

**Context:** Jay dropped two documents (`00-project-overview/source-material/braindump.md` and `.../python-curriculum-authoring-grading-handoff.md`) describing a much larger system than the Moodle-Lesson-branching plan from the prior session: VS Code + local folders as the primary hands-on surface, Google Classroom submission, an AI-assisted grading pipeline with teacher-approval gating, codename-based privacy, XP/levels/lanes reused from `adaptive-python` terminology, similarity and proficiency-consistency review, and a much larger proposed repo structure.

**Decided:**

- `python-curriculum-authoring-grading-handoff.md` is treated as the primary/canonical spec going forward — it's the more structured, decision-ready version. `braindump.md` is kept as supporting narrative context; nothing in it should be treated as more authoritative than the handoff doc where they overlap.
- FoxCS restructured to merge the handoff's proposed repo layout with the existing multi-course structure: shared/course-agnostic pieces (`00-project-overview/`, `01-privacy-and-governance/`, `02-authoring-system/`, `05-grader/`, `06-data-and-spreadsheets/`) live at the `FoxCS/` root; course-specific content stays under `courses/<course>/`.
- **Two-surface model confirmed** (resolves the Moodle-role question from last session): Moodle carries the conceptual layer — video, H5P interactive practice, guided practice, vocabulary, light adaptive support, optional extra-credit XP — and explicitly hands students off into VS Code with a specific task. VS Code carries the applied/creative layer — real typing practice, higher-DOK work, graded reflection, file-naming-convention compliance, submission via Google Classroom. Neither surface is "shelved" — they're sequential within a single lesson, and DOK levels should deliberately span both rather than clustering on one side.
- The Moodle **Lesson-branching mechanic** (per-question wrong→support, right→stretch jump targents) designed in the prior session is **superseded** by the Reinforce/Core/Extend practice-folder model from the handoff doc, plus Moodle's own light adaptive support and H5P instant feedback. `templates/question-branching-template.csv` is kept but is now provisional/secondary — it may still be useful for structuring Moodle guided-practice or H5P content, but it's not the primary practice-authoring artifact anymore. `templates/lesson-template.md` replaced accordingly.
- Locked in as-specified (not open questions): the canonical lesson YAML schema (`02-authoring-system/lesson-schema.md`), the 104-step authoring workflow (`02-authoring-system/authoring-workflow.md`, reorganized into 8 phases), lesson quality standards, and the codename policy/format (provisional pending final confirmation).
- **New hard constraint captured:** grading + feedback release is budgeted at 1 hour/week for the whole class. This now drives the design goals for `05-grader/` and `06-data-and-spreadsheets/` — batch efficiency and automatic focus-group/intervention-list generation are first-class requirements, not later nice-to-haves.
- Grader implementation and spreadsheet/dashboard implementation are explicitly **not started** — placeholders only. Per braindump's own phase order (confirm structure → define authoring process → build a small complete curriculum sample → pilot), building the grader is downstream of having real lesson content to grade against.

**Superseded:** the FoxCS `CLAUDE.md` and `courses/python/CLAUDE.md` written in the prior session (Moodle-Lesson-branching-centric, ~30-question flat practice pool per lesson). Both rewritten to match this entry.

**Still open:** see `open-questions.md`.

---

## 2026-08-30 — Moodle resumed as the real delivery platform; the 2026-08-04 pause is over

**Context:** Between the 2026-08-04 pause entry above and now, Jay actually stood up live Moodle infrastructure on his own DigitalOcean droplet, pointed `foxcs.online` at it with real Let's Encrypt SSL, and built real content against it: an H5P Interactive Book pilot for Python Lesson 1 (Instruction), an H5P BranchingScenario for Practice, a native Moodle Quiz for Mastery Check (password-gated, 3-attempt cap, `QUIZ_GRADEAVERAGE`), a `foxcstest` student account enrolled across all `foxcs-%` courses, and admin access. Root `CLAUDE.md` still read "Moodle is paused" throughout this build, unedited. Jay flagged this directly: *"mopodle is not paused, that is an old note. let's change it."*

**Decided:**

- **Moodle is the live, real delivery platform now** — not paused, not "infrastructure prep for later." The MVP folder-and-Classroom pivot from 2026-08-04 is itself superseded, not the other way around.
- **The 4-module-per-lesson structure is the real, current lesson shape**: (1) Instruction — H5P Interactive Book (concept + vocab + vocab quiz + guided examples), (2) Practice — H5P BranchingScenario (light adaptive remediation, chosen over QuestionSet for its "safer long-term" text-based breakdown-on-struggle behavior), (3) Project — native Moodle Assignment (rubric, downloadable zip of starter files, real file-upload submission, self-serve CodeHS-Sandbox fallback for Chromebook days), (4) Mastery Check + Feedback — one native, password-gated Moodle Quiz (3-attempt cap, averaged not highest, genuine 1-5 feedback question, rubric-tied "how to reach the next tier" guidance).
- **Submissions are back on Moodle**, not Google Classroom — Project file-upload via `mod_assign`, Mastery Check via `mod_quiz`, both native to the live course.
- Content is still authored as self-contained instructional HTML first where that's the natural drafting format (concept pages, practice items) — that step doesn't change. What changes is the packaging/delivery step: it now ends in an H5P/Moodle-native artifact, not a Classroom folder.
- The Starter/Skilled/Legendary/Mythic XP-tier vocabulary (2026-08-04 entry below) stays exactly as decided — cosmetic label, not a routing mechanism — unaffected by this reversal.

**Superseded:** the 2026-08-04 "Paused Moodle, pivoted to an MVP" entry above, and root `CLAUDE.md`'s Purpose/Status sections, Two-Surface Delivery Model pause note, and the Submissions row of its Platform Decisions table — all rewritten to match this entry.

**Still open:** whether the MVP folder format is kept as a fallback for any course/situation (e.g., a Chromebook-only day, or Seminar III's non-unit-shaped content) or fully retired now that Moodle is live — not raised by Jay, not guessed at here.

---

## 2026-08-30 — Created FoxCS: Software Dev, the 5th course, from session context alone (no local source document)

**Context:** Jay asked for course maps to be built out for each CS pathway. Root `CLAUDE.md`'s Courses table already had a stub row for Software Dev (added earlier this session, referencing the CPS-authenticated "Fox Game II/Web II Syllabus SY27" Google Doc Jay had read into the session via browser), but the course folder itself — `CLAUDE.md`, `course-plan.md`, any content — did not exist yet.

**Decided:**

- Built `courses/software-dev/CLAUDE.md` and `courses/software-dev/course-plan.md` from what was already established in-session about the pathway (5-stage progression: HTML+CSS → JavaScript → HTML5 Application Development → Java → Software Development) plus the framing already written into the Unit 0 pathway-choice page's `.pathway-box.softwaredev`/`.concept-card.softwaredev`. **No local copy of the source Google Doc exists in this repo** — checked `starter context/` directly, confirmed absent. Recommend Jay export it in so future sessions aren't relying on session memory of a browser read.
- **Software Dev's own course-plan starts at Unit SD-01, not a continuation of Web Dev's Unit 01-21 numbering.** Stages 1-3 of the 5-stage progression (HTML+CSS, JavaScript, HTML5 App Dev) are `courses/web-dev/course-plan.md`'s content already — Software Dev is a genuinely separate course that begins only once a student clears a Web Dev prerequisite (exact threshold undefined), not Web Dev's own later units. This resolved a real risk of accidentally duplicating Web Dev's curriculum under a new name.
- **First real unit count for this pathway: 16 units** (SD-01 to SD-16, split into Stage 4 "Java Fundamentals" and Stage 5 "Software Development"). This resolves the `.placeholder-flag` left in the Unit 0 pathway-choice page's "How They're Different" comparison, which previously had no number to cite for this pathway. Flagged everywhere as a first-pass estimate, not validated against a real calendar or confirmed with Jay.
- **Real content gap surfaced and flagged, not papered over:** no licensed Java curriculum source (workbook, support files, exam-objective document) exists anywhere in this repo, unlike Python (GMetrix) and Web Dev (LearnKey JS/HTML5 workbooks). Every unit's "Tie-in" line in the new course-plan is marked "(no source — flagged)" rather than inventing exercise numbers. This is the top blocker before any real Java lesson content can be authored.
- "IT Specialist – Java" is used as a working-assumption certification target for the Java stage, consistent with Certiport being FoxCS's throughline elsewhere — explicitly marked unconfirmed, since no exam-objective document exists locally to verify against (contrast Python/JS/HTML5, which all have one).
- Updated root `CLAUDE.md`'s Courses table row for Software Dev from "Not yet created" to reflect the new folder and its real status.

**Still open:** see `courses/software-dev/CLAUDE.md`'s Open Questions — sourcing a Java curriculum, the exact Web Dev→Software Dev prerequisite threshold, whether "IT Specialist – Java" is the right certification target, Stage 5's lack of any certification mapping, scheduling for a variable-entry-point course, and realistic enrollment size.

---

## 2026-08-31 — Content-authoring pipeline gap analysis (vs. python-app) + 5 recommendations implemented via parallel subagents

**Context:** Jay asked for a comparison of FoxCS's content-authoring pipeline against `jalex929/python-app` (temporarily made public for cloning, re-privated immediately after), to find why content needs too much manual correction on the first pass ("I am currently needing to give too many insights about how to improve content and I want to make sure the documentation is carrying this lift").

**Decided/found:**

- Wrote `02-authoring-system/pipeline-comparison-python-app-2026-08-31.md`. Core finding: FoxCS already ported the right content-quality philosophy from python-app (DOK rubric, universal design, misconception pairing — in places more rigorous than python-app's own). What's missing is enforcement: python-app ties documented rules to real checks (schema validation, a stated "new rule → new test" convention); FoxCS's pipeline is prose a human must remember to apply. Grounded this in two real incidents found *during this same session*: `codename-policy.md` documented a codename format that was never actually implemented, and `worklog.md` described a password-sync bug as still-broken after it had already been fixed — both the same failure shape as the content bugs `authoring-flow-gaps-2026-08-11.md` already found.
- Jay approved all 5 recommendations and asked for parallel/non-conflicting subagent execution, plus expanded scope: real content authoring (adaptive flow) using Moodle's native branching, heavy density for CS pathways, lighter for Seminar III.
- **Ran 5 tracks.** Tracks A, B, C in parallel; D1/D2 after B finished (they depended on its reconciliation).
  - **Track A** — recs 1/2/4/5: added a 7-doc "Source of Truth" list to `CLAUDE.md` ("when in doubt, these win," borrowed from python-app's own convention); added "last verified" freshness markers to `codename-policy.md`/`roster-schema.md`; created `02-authoring-system/doc-health.md` (lightweight per-file review-status table for `02-authoring-system/`); added an explicit rule to `authoring-workflow.md` Phase 7 that AI-generated content must pass validation before being marked drafted.
  - **Track B** — found and fixed a real, undiscovered doc contradiction: `adaptive-practice-model.md` (2026-08-11) assumed Moodle was still paused and designed a static-HTML/JS fallback ladder engine; Moodle actually resumed 2026-08-28. Reconciled it to point at the Moodle-native `mod_lesson` ladder (already decided 2026-07-24) as primary. Settled the previously-unresolved pool-size split between two docs at **Core 1 / Reinforce 1-2 / Extend 1-2**. Added two new authoring rules to `objectives-and-skills-proficiency.md` per Jay: Reinforce items must decompose the concept (real intervention, not just "easier"); Extend items must add richer context without restating getting-started basics. Added a course-density rule: CS pathways get a full cluster per skill per lesson; Seminar III gets one selectively, typically 0-1 per lesson.
  - **Mid-execution, a second doc contradiction surfaced**: a later, 2026-08-30 decisions-log entry (this file, "Moodle resumed as the real delivery platform") separately described H5P BranchingScenario as "the real, current lesson shape" for Practice — apparently written without cross-referencing the earlier 2026-07-24 Lesson-activity decision. Checked the live DB directly rather than trust either doc: **neither mechanism had any content built yet** (mod_lesson empty, no H5P BranchingScenario instances). Asked Jay directly; he confirmed the deciding requirement was that responses save server-side in Moodle itself (never local file save) with student review — `mod_lesson` satisfies this natively and unambiguously, so it's the settled mechanism going forward. This is now the second real instance of exactly the doc-drift problem the pipeline comparison was about, caught live instead of silently compounding.
  - **Track C** — built `02-authoring-system/tools/check-lesson-ladder-wiring.php` (validates a `mod_lesson` cluster's jump wiring, lane-crossing, and pool-size cap against the live DB, read-only) plus three checkers for the original `authoring-flow-gaps-2026-08-11.md` bug classes (`check_shuffle_persistence.py`, `check_save_serialization.py`, `check_eliminable_distractors.py`), run against the 49 existing static HTML files under `courses/python/content/` with real, verified results (0 shuffle failures, 0 save-serialization failures — both already fixed by the 2026-08-11 pass — 5 files flagged for human review on eliminable distractors, including a correct catch on Lesson 01.4's already-reviewed Drill 8).
  - **Track D1** — built the first real Reinforce/Core/Extend cluster: `01.1 What Programs Do (Practice)` (cmid=188, Section 2/Unit 01 of `foxcs-python`), skill `explains_computer_literalness`, grounded in the actual live Instruction content (not a schema placeholder). Checker passed clean. Discovered and documented a real, minor open gap: Moodle's Lesson renderer leaks a page's title into the browser tab even with the sidebar nav hidden, in tension with "never show students the tier names" — not fixed yet, flagged in the new `02-authoring-system/adaptive-ladder-runbook.md`.
  - **Track D2** — built the second cluster in Seminar III: `1.10 -- Order of Operations: Extra Practice` (cmid=191, Section 2/Lesson 1). Correctly deviated from the originally-suggested ACT Math Baseline target after investigating live content (branching mid-diagnostic would compromise the baseline's signal) in favor of the already-flagged "Order of Operations Practice" fixed-progression activity that `courses/seminar-iii/CLAUDE.md` and `worklog.md` both explicitly named as needing real adaptive branching. Checker passed clean on first run.
  - Both D1/D2 initially needed a mid-task correction on Moodle information architecture: Moodle has no true nested folders (flat Sections + Activities only). Verified the existing convention directly against the live DB rather than assume — Python folds Unit→Lesson into Section=Unit + `"NN.M Title (Type)"` activity naming; Seminar III folds Lesson→sub-item into Section=Lesson + `"N.M -- Title"` naming (double-hyphen). Both builds were corrected mid-flight to match and verified against the live section/module sequence.
- Wrote `02-authoring-system/adaptive-ladder-runbook.md` — a practical "build the next cluster" guide (settled design summary, IA/naming convention per course, required Lesson settings with the source-code line justifying each, checker usage, the reference script to copy), so Jay can keep authoring clusters without re-deriving tonight's session.
- **Found and fixed a real PII leak in this repo before committing**: an earlier edit this session (correcting `codename-policy.md`/`roster-schema.md`'s stale codename-format documentation) had included a real student email address (`jjreid1@cps.edu`, tied to the `G21-ANDROMEDA` anomaly) directly in the markdown. Caught via a pre-commit grep sweep for `@cps.edu` across all changed files — redacted from both files before anything was committed. No PII reached git history.

**Not done / still open:**
- The browser-tab page-title leak (Track D1's finding) — needs a page-naming convention decision before the next cluster is built.
- Whether/how to build clusters for Game II, Web Dev, Software Dev (no content exists yet in any of them) — the density rule says "full ladder, every lesson" once content exists, but content itself is the bigger gap there, unchanged by tonight's work.
- Retrofitting tonight's Python cluster's page names if a tier-neutral naming convention gets adopted later.

---

## 2026-09-03 — Lesson 01.4 build completed; Mastery Check pool design confirmed as the real standard; mod_feedback established as the Feedback mechanism

**Context:** Continuing 01.4's build from `lesson-01-04-build-plan.md` (Instruction live, Practice scripted-not-run, Mastery Check/Coding Exercise spec'd but not built). Jay confirmed it's fine to build directly into the live `foxcs-python` course as long as new modules stay hidden (`visible=0`) until reviewed — matching the pattern already used for 01.1's Mastery Check before it was flipped visible, not a new policy.

**Real doc-vs-DB mismatch found and resolved, same failure shape as prior sessions' pipeline-comparison findings:** the build plan's Mastery Check section 3 specified "4 fixed essay questions," written before checking live state. Queried `mdl_quiz_slots` directly for 01.1 and 01.3: both were actually redesigned 2026-09-01 (see `rebuild-mastery-check-task-pool.php`'s own header) to a password + random-draw-of-1-from-a-10-task-pool model, grademethod=average across 3 attempts — the plan doc never got updated to reflect that redesign. Flagged to Jay directly rather than silently building to either the stale doc or a silent reinterpretation; **Jay confirmed the pool pattern is the real standard to match**, not a one-off for 01.1/01.3.

**Decided:**

- **01.4's Mastery Check** (cmid=214) built to match: slot 1 reuses the SAME shared academic-integrity question (id=21) across all lessons rather than duplicating it (confirmed this is what 01.2/01.3 already do); slot 2 is a random draw of 1 from a new 10-task pool (`Lesson 01.4 Mastery Check - Task Pool`, category id=20) — the original 4 questions ported verbatim from `09_mastery_check.html`/the teacher KEY, plus 6 new questions written to cover facets the original 4 didn't touch. Real gap found while writing the new 6: **none of the original 4 tested 01.4's actual language objective** (function/string/argument terminology) — 2 of the 6 new questions fix that directly. The other 4 add a fresh prediction-with-order-matters variant, a game-connection application item, a transfer/conceptual item, and one genuinely new debug error category (capitalization: `PRINT()` vs `print()`) distinct from every quote/paren variant already used elsewhere in this lesson.
- **SEB and due date, Jay's explicit calls:** skip Safe Exam Browser on 01.4 for now (matches 01.1's own still-unresolved status, not a new no); defer the due date like 01.2/01.3, don't set one yet.
- **01.4 Coding Exercise** (cmid=215) built mirroring cmid=206 (01.3's own Assignment) exactly, per the build plan's own instruction to check live settings rather than guess: simple point grading (grade=100, NOT a Moodle rubric — 01.3 isn't rubric-based despite the build plan speculating one might be needed), onlinetext + file submission both enabled, no feedback plugins enabled (matches 01.3's actual live config, not a new choice made here). The real tiered XP structure (Required / Tier 1 +10 / Tier 2 +20, from `07_project.html`) is documented in the intro text for the student, same as how this course already keeps XP bookkeeping outside Moodle's own point grade.
- **New this session, not previously decided: 01.4 Feedback (cmid=218) is the first Feedback/reflection step built into Moodle for ANY lesson in this course.** Prompted directly by Jay asking mid-session for a real reflection component ("what felt challenging or what made sense"). Checked first: 11_feedback.html already has a fully authored 6-question reflection page per `feedback-collection.md`'s design, just never ported into Moodle for 01.1/01.2/01.3 either — a real standing gap, not unique to 01.4. **Chose `mod_feedback` over folding a reflection question into the Mastery Check pool**, for a real structural reason: the pool draws only 1 of 10 questions per student attempt, so a reflection item living there would reach roughly 1 in 10 students, not all of them — wrong mechanism for something meant to inform every student's and every lesson's feedback loop. `mod_feedback` is also the semantically correct fit independent of that: Moodle's own non-graded survey activity, matching `feedback-collection.md`'s explicit rule that this data must never touch a student's academic grade. Built via Moodle's own item-class API (`feedback_get_item_class()->set_data()->save_item()`, the same code path the real question-editing UI and Moodle's own test generator use) rather than hand-rolled presentation-string DB inserts — 8 items total (3 rated 1-5 scales, 2 optional followup textareas, 1 vocab self-check checklist, 2 open reflection prompts), all read back and verified against the DB. **This establishes the pattern for porting 01.1-01.3's own `NN_feedback.html` files into Moodle next**, and for every future lesson going forward — not yet done for 01.1-01.3, a real follow-up item.
- Hit and fixed one real, non-obvious Moodle gotcha building the feedback activity: `create_module()` for `mod_feedback` requires the raw `page_after_submit`/`page_after_submitformat` scalar fields set directly (not just the `page_after_submit_editor` array) — the module's own `add_instance()` only back-fills that field from the editor array in a post-insert UPDATE, but the initial INSERT fails first (`Field 'page_after_submit' doesn't have a default value`) if the raw field isn't already present on the object. Two failed attempts rolled back cleanly (verified no orphaned `course_modules` rows survived) before finding the fix.
- Reordered Unit 01's section sequence so 01.4's real modules display in completion order (Instruction → Practice → Coding Exercise → Mastery Check → Feedback), matching 01.1's established convention. Left cmid=101 (01.4's old hidden MVP placeholder) untouched — verified its only log activity is admin/system events (created/viewed/updated), zero real student interaction, but deletion isn't required for 01.4 to work and wasn't asked for.

**Status: all 5 of 01.4's real pieces exist and are verified against the DB** (Instruction cmid=212 visible, Practice cmid=213 visible, Mastery Check cmid=214 hidden, Coding Exercise cmid=215 hidden, Feedback cmid=218 hidden). Hidden items need Jay's review before flipping visible — same pattern as every prior lesson.

