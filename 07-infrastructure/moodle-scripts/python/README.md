# Python (Game I) Moodle Upload Scripts

Built 2026-08-30, when Jay decided to start using the `foxcs-python` Moodle
shell to review Python's already-authored MVP folder content (previously
Moodle was paused platform-wide for Python, delivery was Google Classroom
folders only — see root `CLAUDE.md`'s Status section; that decision hasn't
changed, this is an additional review channel, not a replacement).

## The core problem this solves

Python's MVP lesson folders (`courses/python/content/unit_XX_slug/lesson_XX_YY_slug/`)
are self-contained: ~8-12 numbered files (`00_table_of_contents.html` through
a mastery check and feedback page) linked to each other by real relative
paths, plus a sticky nav menu (see `../../02-authoring-system/mvp-unit-folder-structure.md`'s
"Unit-Wide Nav Menu" section) that also links to every *other* lesson in the
unit via `../lesson_XX_YY.../...` relative paths.

Uploading each numbered file as its own Moodle resource (the pattern used
for Seminar III) would create 8-12 items per lesson — 60+ for just Unit 01 —
recreating the exact "too many small activities" sprawl problem Seminar
III's Lesson 1 was consolidated to fix earlier the same day.

## The approach: one Moodle resource per lesson, multi-file

Moodle's File resource (`mod_resource`) supports uploading several files
into one resource's file area with one designated as the "main file"
(`file_set_sortorder(..., 1)` — no such thing as a stored `mainfile` column,
it's computed at render time from whichever file has `sortorder = 1`).
When a student opens the resource, Moodle serves the main file embedded;
that file's own relative links to its *sibling* files (uploaded into the
same resource) resolve correctly, since they're all served from the same
`pluginfile.php/{contextid}/mod_resource/content/0/{filename}` file area.

**This only works within one lesson's own files.** A relative link that
tries to go *up and into a different lesson's folder* (`../lesson_01_02.../...`)
does **not** 404 — it silently resolves back to a file in the *same*
resource's flat file area (Moodle's pluginfile router doesn't have a real
directory tree to walk up out of), so a student clicking "jump to Lesson
01.2" from inside Lesson 01.1's Moodle copy would silently stay on Lesson
01.1's content with no error. Confirmed by testing, not assumed.

## `stage_unit01_for_moodle.py`

Run first, from a machine with the repo (not `www-data`, this is a local
staging step): copies each lesson folder to `/tmp/python-src-moodle/` and
strips every cross-lesson entry from the nav menu's markup (any menu entry
whose links start with `../` gets dropped), keeping only the current
lesson's own file list. **The real repo files are never touched** — this
only edits the staged copy, since the un-stripped version is correct for
the actual Google Classroom folder delivery context, just not for Moodle.

The unit overview page and unit-level project files are **not** run through
this stripping step (uploaded via `upload_python_single_file.php` instead,
see below) — they inherently link into every lesson, so the same limitation
applies to them and isn't worth solving given they're secondary pages.

## `upload_python_lesson.php`

```
sudo -u www-data php upload_python_lesson.php <staged-lesson-folder> <unit-num> "<name>"
```

Uploads every file in the given folder into one new `mod_resource`, sets
`00_table_of_contents.html` as the main file. Section number = unit number
+ 1, same convention as `create-h5p-activity.php` and Seminar III's scripts.

## `upload_python_single_file.php`

```
sudo -u www-data php upload_python_single_file.php <local-file> <unit-num> "<name>"
```

Plain single-file upload, same pattern as Seminar III's
`populate-seminar3-resources.php`. Used for the unit overview page and the
unit-level project files, which don't need the multi-file treatment.

## Staging note

`www-data` can't traverse `/home/jay` (see `moodle-course-shells.md`'s
"Known gotcha") — stage into `/tmp` and `chmod -R o+rX` before running
either upload script as `www-data`, same pattern as every other script in
this directory.

## Nav simplified further, 2026-08-30 (later)

Jay's feedback after the first upload: since each lesson is now its own tab
in Moodle's section list, the in-page menu showing "Unit 01" with all 6
lessons collapsed inside was redundant, and he wanted just the current
lesson's own sub-items. `stage_unit01_for_moodle.py` was rewritten:
instead of stripping cross-lesson `<details>` entries from the full nested
menu, it now replaces the whole thing with a flat, always-visible list of
just the current lesson's own files (`.lesson-menu-wrap`, no toggle, no
per-lesson collapse) — the real repo files' full nested menu is
untouched, this only affects the staged Moodle copies.

## `build_lesson1_interactivebook_pilot.py`

A parallel exploration, not a replacement (yet): Jay asked whether an
`H5P.InteractiveBook` (native chapter/page navigation, avoids the
cross-lesson-link problem entirely) might be a better fit than the
HTML-file model. Piloted on Lesson 01.1 only, covering the *conceptual*
content (Instruction, Flashcards as `H5P.Dialogcards`, Vocab Quiz and
Practice as `H5P.QuestionSet`, Project as `H5P.Essay`) — real content
adapted from the existing lesson, not fabricated. The Mastery Check step
deliberately stays outside the book (password-gate + auto-timestamp has
no H5P equivalent) and the code-writing steps stay in VS Code as before —
this maps onto the original "Moodle for concepts, VS Code for applied
work" Two-Surface model from before Moodle was paused.

**Hit and fixed a real, silent H5P bug building this** — see
`../../h5p-content-type-guide.md`'s new "single-field group gets
auto-flattened" section. Short version: `chapters` list items must be the
bare `H5P.Column` object, not wrapped in `{"chapter": {...}}` the way the
semantics' field name suggests — the wrapped version uploads with zero
errors but Moodle silently strips the entire chapter list during
filtering. Caught by directly reading `h5p.classes.php`'s `validateGroup()`,
not guessed.

Live at `foxcs-python` section 2, cmid 97, right after the overview page
and before the HTML-file version of 01.1, specifically so Jay can compare
both directly before deciding whether to port the other 5 lessons.

## What's live as of 2026-08-30

`foxcs-python`, section 2 (Unit 01): Overview, the Interactive Book pilot,
all 6 HTML-file lessons (01.1-01.6, each a multi-file resource, simplified
nav), and the unit-level project pair. Verified via authenticated fetch:
every lesson's main file renders with the right title, a same-lesson
sibling file resolves correctly, and the pilot's all 6 chapters/13
questions/1 flashcard deck/1 essay render with zero validity errors.

## Not done

- Units 00, 02-20 — only Unit 01 has real content to upload yet.
- No fix for the cross-lesson-link limitation described above beyond
  stripping the dead links from the lesson copies. A student using the
  Moodle copy needs to go back to the course's section list to move
  between lessons, not the in-page menu.
- No verification via a real rendered browser (see root `worklog.md`'s
  Playwright checklist) — everything here was checked via authenticated
  `curl`, same method used throughout the Seminar III Moodle build.
- Jay's decision on whether to port the other 5 lessons to Interactive
  Book format, pending his review of the pilot.
