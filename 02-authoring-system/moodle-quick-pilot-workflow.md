# Moodle Quick Pilot Workflow: Getting a Sample of Content In to Test

This is **not** the production authoring pipeline — it's how to get a small, real sample of content into Moodle fast, so you can test whether it actually reads well to students, before investing in anything more automated. Once you're past the "does this feel right" question, use `content-authoring-standards.md` and `lesson-schema.md` for real authoring. The JSON-generation/import-pipeline docs in `adaptive-python` (`content-import-pipeline.md`, `json-generation-guidelines.md`, `spreadsheet-schema-guide.md`) describe that app's own production pipeline, not Moodle — not relevant here.

## Where to pull sample content from

`adaptive-python` already has real content built for this same curriculum skeleton:

- **`python-app/curriculum/json/lesson_XX_YY_mc.json`** — the best source to sample from. Code is already embedded safely (fenced code blocks inside properly-escaped JSON strings, not raw spreadsheet cells), and each question already carries `prompt`, `correct_answer`, `feedback_correct`, `feedback_incorrect`, `difficulty_band` (starter/skilled/legendary), and `practice_lane` (reinforce/core/extend) — that last one maps directly onto the ladder from `objectives-and-skills-proficiency.md`.
- **`python-app/curriculum/questions/lesson_XX_YY.tsv`** — more metadata (hints, concept tags), but raw TSV. Fine for lessons where prompts have no embedded code; riskier where they do (this is exactly the tab/whitespace problem you flagged originally). Prefer the JSON version when both exist for the same lesson.
- **`python-app/curriculum/projects/project_module_XX.tsv`** — project prompts, useful for anything project-shaped or Extend-lane.

Pick maybe 5-10 items spanning Core/Reinforce/Extend for one skill (2-3 each, matching the pool-size guidance), hand-adapt them — trim to FoxCS's lighter format, rewrite tone per `content-voice-and-tone.md` (close to adaptive-python's, not identical), and hand-enter into Moodle. This is a copy-and-rewrite step, not a scripted import, and that's the right amount of process for this phase.

## Getting a question into Moodle

Two genuinely fast options at this volume:

1. **Type it directly into the Question Bank.** Course → Question bank → Create a new question → pick a type (Multiple choice, Short answer, Essay, etc.) → paste prompt/answers/feedback. For 5-10 questions this is maybe 20-30 minutes of clicking, no tooling needed, zero risk of format mistakes.
2. **Write it as GIFT format and import once.** GIFT is Moodle's plain-text question format — multiple questions in one text file using a simple syntax (`::Title::Question text {=correct answer ~wrong answer ~wrong answer}`), then Question bank → Import → GIFT format. Faster than the UI once you're past ~4-5 questions, and it's plain text — no spreadsheet, no tab-in-cell problem. One real caution: GIFT uses `{ }`, `~`, `=`, `#` as its own syntax, so Python code samples with dictionaries/sets/f-strings need those characters escaped with a backslash, or they'll break the import. Moodle XML format doesn't have this collision if you hit it often.

**For this first pilot sample, default to manual UI entry** — slower per-question, but you're only doing a handful, and there's no format-escaping risk to debug. GIFT is worth learning once you're doing this at real volume, not before.

## Supplementing with H5P

Skip the `.h5p`-package-generation plan in `h5p-authoring-and-automation.md` for this phase — that's aimed at eventual scale, not a quick test.

- Course → Add an activity → **Interactive Content (H5P)**.
- Choose **"create content"**, not "upload" — this opens Moodle's built-in browser-based H5P editor directly.
- Pick a content type already available on this instance (Multiple Choice, Drag the Words, Fill in the Blanks, Course Presentation, etc.) and author right there in the browser. No export, no zip, no hand-edited JSON.

This is the fastest path to a testable H5P activity for a one-off sample, full stop.

## The Lesson-activity ladder, for this phase specifically

Use `moodle-lesson-ladder-setup.md`'s mechanics section (Question page → Answer → Jump) exactly as written — that part doesn't change. But ignore its sustainability Tiers 2 and 3 for now. For a content-feel pilot, **Tier 1 (fully manual, in the Lesson editor) is the entire plan.** There's no reason to build export/import tooling before you know the questions themselves are the right ones.

## What this explicitly does not need right now

- adaptive-python's JSON-generation/import-pipeline docs — production tooling for a different app, not this phase.
- Any Web Services scripting.
- Any bulk-generation or automation of any kind.

The only goal right now: get a believable sample in front of students and see if it lands.
