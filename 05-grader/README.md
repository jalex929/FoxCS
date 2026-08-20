# Grader

## Architecture, decided 2026-08-18: two tiers, two machines

Jay's teacher machine (school) has cmd/PowerShell and Python, but **no Claude Code, no ChatGPT, no Claude products** — Copilot only, and Jay wants to avoid relying on it. Jay's home machine has Claude Code. The grading design splits along exactly that line, and it turns out to split cleanly along a line the content already has:

- **School machine, stdlib-only Python, no AI, no network — `school-side/auto_grade.py`.** Grades the content that's *structurally* auto-gradable: the four HTML pages that save themselves with a `_completed` suffix and carry either a hidden `foxcs-telemetry` JSON block (vocab quiz, practice — attempts, correctness, drill IDs, all already logged by the page itself) or hidden timestamp spans (mastery check's unlock/complete times). This script never judges quality — it reads facts the page already recorded about itself. It also writes a `needs_review_manifest.csv` listing every file it deliberately did *not* grade (project code, application code, mastery-check written answers), so nothing gets silently skipped. Verified against the real fixture in `sample-submissions/` — see that folder's README for what the fixture represents.
- **Home machine, Claude Code — everything in `needs_review_manifest.csv`.** Short-response, code, and project work need the holistic judgment `feedback-and-grading-spec.md` was written for (rubric preservation, best-fit scoring, evidence-based feedback voice, human-review triggers). That spec is Claude Code's context when grading these; it isn't reimplemented as rules in a script. Jay's own instinct (2026-08-18) was that trying to force this tier into regex/command-prompt grading would be worse than just using Claude Code where it's actually available — that's the design here, not a compromise.

**The Release Gate still applies to both tiers.** `auto_grade.py`'s output is a report, not a released grade — see `../01-privacy-and-governance/data-boundaries.md`. Nothing reaches a student until Jay approves it, regardless of which machine produced it.

**Tests:** `school-side/tests/test_auto_grade.py` (stdlib `unittest`, 21 tests) covers every extraction rule in isolation (telemetry parsing, malformed JSON, missing files) plus an end-to-end run against the real fixture in `sample-submissions/`, asserting the exact values documented in that fixture's persona. Run with `python -m unittest discover -s 05-grader/school-side/tests -v`. `.github/workflows/grader-tests.yml` runs this same suite in CI on every push touching the grader code — **code correctness only**, it never touches real student data, since none lives in this repo.

**Spreadsheet output, decided 2026-08-18:** `auto_grade_report.csv` and `needs_review_manifest.csv` are already spreadsheet-native — CSV opens directly in Excel or imports straight into Google Sheets, no database layer needed. Jay's own call: prefer landing straight in a spreadsheet over standing up Supabase or similar, unless a real need for one shows up later. These two CSVs are meant to feed **the teacher spreadsheet** described in `../06-data-and-spreadsheets/` (not yet built) once that exists, rather than being a dead-end report.

**Not decided:** whether `auto_grade.py` should ever run *inside* GitHub Actions against real (codenamed) submissions pushed to this repo, rather than run locally on the school machine. That's a data-boundary/retention decision (see `../01-privacy-and-governance/data-boundaries.md`'s still-open Retention question), not just a CI question — flagging it here rather than deciding it silently. The CI workflow that exists today only runs the test suite against synthetic and fixture data, never real submissions.

**Not built yet, and out of scope for `auto_grade.py`:** the codename-swap-on-download script (`../01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section) — `auto_grade.py` assumes it's already running against codename-swapped folders, it doesn't do that swap itself. Also not built: getting the two reports (`auto_grade_report.csv`, `needs_review_manifest.csv`) plus the raw needs-review files from the school machine to the home machine — the repo itself (commit at school, pull at home) is the obvious sync path given everything else here already goes through git, but that workflow hasn't been walked end-to-end yet.

Everything below this line is the original, broader design intent this two-tier split grew out of — kept for reference, most of it still applies to the home-machine/Claude Code tier specifically.

---

The grading pipeline itself is real software (file validation → execution → hidden tests → static analysis → rubric scoring → feedback drafting → similarity analysis → proficiency-consistency review → XLSX export → teacher approval) and is a separate build from curriculum authoring. Per the phase order in `../00-project-overview/source-material/braindump.md`, the sequence is: confirm structure → define authoring process → build a small complete curriculum sample → *then* build/pilot the grader against real submissions. We're still in the first two phases.

## Feedback and Grading Spec — Adopted 2026-08-06

**`feedback-and-grading-spec.md`** (copied from `Sample Content/ai_autograder_feedback_guidance.md`, a real doc Jay had already written) is the canonical voice/rubric/output-format spec for whatever grading engine eventually gets built here. It's genuinely comprehensive — feedback voice with banned/preferred phrasing, an 8-step standard feedback pattern, rubric-preservation rules ("primary source of truth," best-fit scoring so one minor gap doesn't tank a score), a mastery-check label set (Mastery Demonstrated / Nearly There / Needs Additional Practice / Not Enough Evidence / Teacher Review Required), an `essentialForMastery` flag for criteria that can block mastery even at a high overall score, a capped (+2, requires teacher approval, never auto-applied) above-and-beyond bonus, a full JSON output schema, an Academic Integrity section that flags rather than accuses, a 14-item human-review-trigger list, and 7 worked example feedback blocks covering common submission types. Read it in full before writing any grader code or feedback templates — don't re-derive rules it already answers. See `../00-project-overview/source-material/sample-content-review-2026-08-06.md` for how this was found and what else came with it.

## Hard Design Constraint

**Target: 1 hour per week of teacher time, including reviewing and releasing feedback, for the whole class.** This is not a nice-to-have — it's the constraint that determines whether the grader design is viable at all. Every design decision here should be evaluated against it:

- The teacher-review step must be fast per student (skim evidence + score, approve/edit/reject), not a re-grade.
- Batch operations matter more than per-student polish — approving 25-30 students in an hour means seconds per student for the clean cases, with more time reserved for the flagged/low-confidence ones.
- The **focus-group output is not a separate task** — it has to fall out of the same weekly pass that produces grades, not require a second pass through the data. See `../06-data-and-spreadsheets/README.md`.

## Expected Structure (from the handoff doc, not yet created)

```
05-grader/
  requirements.md
  grader-workflow.md
  confidence-rules.md
  human-review-rules.md
  config/
  prompts/
  schemas/
  validators/
  runners/
  tests/
  similarity/
  reporting/
  output-examples/
```

## Requirements Gathered So Far (2026-08-04, consolidated so nothing gets lost — still not built)

Everything below is a real requirement surfaced during content-authoring work, before the grader itself has been started. Recorded here so building it later doesn't mean re-deriving these from scratch:

- **Codename-swap intake step.** Must run before anything downstream touches a submission — see `../01-privacy-and-governance/codename-policy.md`'s "Tooling Needed" section. Not built; blocks real use of everything below it.
- **AI-authenticity check, for both code and journal-entry text.** Required by `../01-privacy-and-governance/academic-integrity-ai-use.md`. Must feed into the same human-review gate as every other flagged case — **never an automatic 0 or automatic Aspen-documentation action**, regardless of detector confidence. Detection tool/method not chosen yet.
- **Mastery-check auto-grading source.** Each lesson's `mastery_check/lesson_XX_YY_mastery_check_KEY.md` (see `../02-authoring-system/mvp-unit-folder-structure.md`) is teacher-only and holds the DOK-tagged expected answers and named misconceptions — this is the source the grader should read against for mastery-check items, not something to re-derive per lesson.
- **Journal grading rubric.** Thoughtfulness + completion of the ask, genuine reflection rooted in the unit's concept, justified opinions with source ties, authentic voice — see `../courses/python/course-plan.md`'s Journal Threads section. Points/XP value per entry still unset.
- **Practice-ladder self-check answers are intentionally student-visible** (`practice/core/ANSWER_KEY.md` or the equivalent embedded in a lesson's interactive practice HTML) — the grader should not treat a student having seen these as evidence of anything; they're part of the self-navigated design, not a leak.
- **Vocab-quiz reflection theme extraction, added 2026-08-11.** Every lesson's `NN_vocab_quiz.html` ends with a required reflection ("what memory trick did you use, if any" — see `../02-authoring-system/mvp-unit-folder-structure.md`'s Vocab Quiz section). Jay wants the grader to extract themes across a class's reflection answers and surface a quick-reference of genuinely effective memory tricks, flagging ones worth sharing with the whole class (with the originating student's permission/anonymized, TBD). This is a real, explicitly-requested future requirement, not a hypothetical — don't lose it when the grader's actual design work starts.

## Testing Needs (2026-08-04, documented ahead of having anything to test)

Two distinct kinds, don't conflate them:

1. **Pilot-loop testing** — the whole MVP delivery mechanism end-to-end: distribute a real unit folder via Google Classroom → student does the work → student submits the whole folder back → teacher downloads → codename-swap runs → grading happens. Nothing in this chain has been tested with a real folder yet. Specific unknowns to test for: whether Classroom preserves directory structure on download (see `../open-questions.md`), whether a zipped folder is the right distribution unit or something else works better, how long a real download-and-swap-and-grade pass actually takes against the 1-hour/week budget.
2. **Interactive-content testing on real school devices/browsers.** As of the Unit 01 build, lesson practice is moving to self-contained interactive HTML (JS-driven self-checking questions, a save-to-file button) — see `../02-authoring-system/mvp-unit-folder-structure.md`. This needs real testing on whatever devices/browsers students actually use (Chromebooks are common in school settings and have their own quirks around file downloads and local storage) before it's trusted as the default format across every unit. Not tested yet.

## Before Building This

Needs answers to (see `../open-questions.md`):
- Submission cadence — whole lesson at once, or one file at a time (recommendation logged there)
- Which Python version / VS Code config is standard on school machines
- Grading-confidence thresholds and what triggers mandatory human review
- Similarity-flag threshold
