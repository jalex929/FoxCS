# H5P Builder Scripts

Reusable Python scripts for generating `.h5p` packages from plain question
data, instead of hand-writing `content.json` per activity (the approach used
for the original Unit 01 Check, before this existed). Built 2026-08-30 while
authoring the Unit 01 ACT Math Baseline.

Relies on the target content types already being installed server-side via
the H5P Content Type Hub sync (see `moodle-course-shells.md`'s "H5P pipeline
proven" entry) -- packages built here don't bundle any library code, just
`h5p.json` + `content/content.json`.

## `build_questionset.py`

Two builder functions:

- `build(questions, title, out_path, intro_html, pass_percentage=70)` -- an
  `H5P.QuestionSet` (1.21) of `H5P.MultiChoice` (1.16) sub-questions. Each
  question dict: `{"question": "<p>...</p>", "answers": [{"text": ..., "correct": bool, "feedback": ...}, ...]}`.
- `build_column(blocks, title, out_path)` -- an `H5P.Column` (1.22) of
  `H5P.AdvancedText` (1.1) and `H5P.Essay` (1.5) blocks. Each block is a
  tuple: `("text", html)` or `("essay", task_description_html, placeholder_text)`.

## `unit01_baseline_questions.py`

The 24-question ACT Math Baseline content (question text, answers, feedback,
plus baseline-only metadata: domain/skill/difficulty/expected strategy/likely
misconception/likely error type -- used to build the teacher-only answer key,
not included in the H5P package itself).

## `build_unit01_baseline_quickref.py` / `build_unit01_days4and5.py`

The pre-baseline rules-reminder reference card, and the Day 4/5 reflection
activities (baseline reflection, final "Build Your Starting Strategy"
reflection), all as `H5P.Column` packages via `build_column()`.

## Usage pattern

```
python3 build_unit01_days4and5.py   # writes .h5p files to /tmp/h5p-build/
cp create-h5p-activity.php /tmp/    # www-data can't traverse /home/jay
sudo -u www-data php /tmp/create-h5p-activity.php /tmp/h5p-build/FILE.h5p <unit-number> "<name>"
```

Then verify via the authenticated-embed-page method documented in
`moodle-course-shells.md` (DB-only verification via `mdl_h5p.jsoncontent`
only works after the activity has been viewed at least once through the
player -- the record isn't created at upload time).

## `merge_unit01.py`

One-off script (2026-08-30) that consolidated Unit 01 from 16 visible Moodle
items to 12: pulls the *actual stored* `jsoncontent` for existing activities
straight from `mdl_h5p` (via the `cmid -> mdl_files.pathnamehash -> mdl_h5p.id`
join documented below, since `mdl_h5pactivity` has no direct FK to it) and
recombines real content blocks into merged Column/QuestionSet packages --
never re-authors content from scratch. Useful as a template for any future
"combine these existing activities" pass on another unit.

**Finding a cmid's actual H5P content id** (needed before pulling
`jsoncontent` -- `mdl_h5pactivity` doesn't store this directly, and it isn't
created until the activity has been viewed at least once):

```sql
SELECT ctx.instanceid AS cmid, f.filename, h.id AS h5p_id
FROM mdl_context ctx
JOIN mdl_files f ON f.contextid = ctx.id AND f.component='mod_h5pactivity'
                 AND f.filearea='package' AND f.filename != '.'
LEFT JOIN mdl_h5p h ON h.pathnamehash = f.pathnamehash
WHERE ctx.instanceid IN (<cmids>) AND ctx.contextlevel = 70;
```

## Extending to a new activity

Write a new `unitNN_*.py` module with a `QUESTIONS` list (for a QuestionSet)
or a `blocks` list (for a Column), import the relevant `build*()` function,
and run it. No need to touch `build_questionset.py` itself unless a new H5P
content type is needed.
