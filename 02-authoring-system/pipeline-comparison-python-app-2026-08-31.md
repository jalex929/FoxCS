# Authoring Pipeline Gap Analysis: FoxCS vs. python-app (adaptive-python)

**Added 2026-08-31**, per Jay's direct request to compare FoxCS's content-authoring pipeline against `jalex929/python-app` (the commercial adaptive-python app, temporarily made public for this clone, then re-privated) and identify what's making FoxCS content need too much manual correction on the first pass. Jay's own framing: *"I am currently needing to give too many insights about how to improve content and I want to make sure the documentation is carrying this lift."*

This is a process/pipeline audit, not a content audit — same scope boundary as `authoring-flow-gaps-2026-08-11.md`, which this document extends with an external comparison point.

## Bottom line

**FoxCS already ported the right content-quality philosophy from python-app** — `content-authoring-standards.md`, `content-voice-and-tone.md`, `mastery-check-standards.md`, and `objectives-and-skills-proficiency.md` are all explicitly adapted from python-app's `docs/content/`, `docs/ux/`, `docs/learning-science/`, and `docs/ai/`, scaled down correctly for FoxCS's solo/small-team reality. The DOK rubric, universal-design rules, and misconception-pairing requirement are as good as or better-grounded than python-app's own equivalents (see "Where FoxCS is already ahead" below).

**What's missing isn't better prose guidance — it's enforcement.** Every one of python-app's real structural advantages comes down to one idea: **turn a documented rule into something a machine checks, not something a human has to remember to check.** FoxCS's entire pipeline (`authoring-workflow.md`'s 8 phases, `lesson-quality-standards.md`'s checklist) is prose that a human (Jay, or a Claude Code session) has to execute correctly from memory every single lesson. python-app has the same prose layer, but backs a meaningful slice of it with actual code: schema-validated JSON, automated duplicate/reference checks, and — most importantly — a rule tying every new documented content-validation rule to a real test file. That's the direct answer to "the documentation should carry the lift": in python-app, a documented rule that has no enforcing test is, by its own stated convention, incomplete.

This matches exactly what `authoring-flow-gaps-2026-08-11.md` already found from the inside: four real bugs (unshuffled block banks, a save-serialization data-loss bug, an eliminable-distractor question) all slipped through because **no automated check existed for any of them** — every catch was a human read-through. That gap audit named the symptom. This document names the structural reason it keeps recurring and what python-app does differently.

## Where FoxCS is already ahead

Worth stating plainly so the fix doesn't overcorrect into copying python-app wholesale:

- **python-app's DOK-equivalent rubric doesn't actually exist.** `content-authoring-standards.md` found this directly: python-app uses "DOK 2, 3, or 4" as unexplained shorthand in places, without ever defining Webb's model. FoxCS's DOK table (with a Python-specific example per level) is more rigorous than its source.
- **python-app's own documentation is heavily aspirational.** Most of its ~40 content/AI/meta docs are written entirely in "the system should..." language — a target architecture, not a built one. Its own `docs/meta/documentation-status.md` (last audited 2026-05-21) lists 20+ files as **known stubs** (placeholder content, 1 line or less) across `docs/product/`, `docs/architecture/`, `docs/operations/`, and `docs/learning-science/`, and marks most sections "Not audited." Its own root `CLAUDE.md` narrows this down to 25 named canonical docs as the *real* source of truth — an implicit admission that most of the ~122-file `docs/` tree isn't reliable as-is. FoxCS's authoring docs, by contrast, are shorter, load-bearing, and describe a process that's actually been run (Lesson 01.4's real iteration history, not a hypothetical pipeline).
- **FoxCS's misconception→recovery pairing rule is stricter than python-app's.** python-app's QA docs mention "misconception handling" as a review-checklist bullet; FoxCS requires a named misconception code to have a paired recovery resource before it's allowed to exist at all (`content-authoring-standards.md`).

## The core structural gap

| | FoxCS | python-app |
|---|---|---|
| Content quality rules | Written as prose guidance (`content-authoring-standards.md`, `lesson-quality-standards.md`) | Same, but a subset also enforced as schema/type constraints |
| Canonical content representation | Hand-authored HTML/H5P per lesson, no shared schema across lessons | Canonical JSON schema (course→module→lesson→content_block) that every lesson's content must conform to |
| Automated validation | **None.** Phase 7 ("Validate") of `authoring-workflow.md` is 8 fully manual steps — a human runs code examples, checks accessibility, checks folder structure by hand | Partial but real: TSV/JSON parser produces typed objects, cross-batch duplicate-ID detection, missing-reference checks, required-field/type validation — all run in code before anything reaches "draft" status |
| AI-generated content rule | Implicit — Phase 7 applies to all content, no AI-specific gate | Explicit, stated as a hard rule: *"AI output alone is not considered production-ready"* — must pass schema validation before being considered done |
| Tying a documented rule to enforcement | No mechanism — a new rule (e.g. 2026-08-11's "distractors must not be eliminable from the prompt") lives in prose only, relies on the next author remembering to apply it | Explicit convention in root `CLAUDE.md`: *"New content validation rule in docs → add a test to `src/__tests__/content-qa.test.ts`"* |
| Source-of-truth clarity | `CLAUDE.md` lists the full folder tree flat, no distinction between load-bearing and draft/reference-only docs | Root `CLAUDE.md` names an explicit, numbered 25-document "Source of Truth" list: *"All other docs must align to them. When in doubt, these win."* |
| Documentation staleness tracking | None — staleness is discovered by accident (see below) | `docs/meta/documentation-status.md`: a dated, per-file audit table (stable / stub / not-audited), explicitly meant to be re-run after each doc pass |
| Freshness gate at point of use | None | `CLAUDE.md` opens with a runnable check (`npm run build`, `npm test`) and a "Last verified: [date] — PASSED" line, so anyone starting work sees immediately whether the ground truth is current |

## Why this matters concretely (not hypothetically)

Two real, independent incidents from this same week show the identical failure shape — a prose doc says one thing, reality drifted, and nothing caught it until a human happened to check by accident:

1. **`codename-policy.md` and `roster-schema.md` documented a codename format (`G1-1-NOVA`, course-code + period) that was never actually implemented** — the real generator used a different, undocumented scheme (`G1-NOVA`, letter+period fused) from day one. This went unnoticed until this session's roster-enrollment check needed the real format and found it didn't match the docs. No test or check would have caught this without someone re-deriving the actual format from the live spreadsheet.
2. **`worklog.md` documented a critical password-sync bug as still-broken with a specific "not yet done" list**, but a *later* session (also 2026-08-31) had already fixed most of it — including creating a previously-"missing" account — without a worklog update reflecting completion. A live re-audit this session found the true state matched neither the stale narrative nor an assumption of "still broken." `authoring-workflow.md`'s own Phase 8 step 66 ("record what changed... in `decisions-log.md`") exists for exactly this, but nothing enforces it happening at the moment a fix lands, only after the fact if someone remembers.

Both are the same class of bug `authoring-flow-gaps-2026-08-11.md` already identified in lesson content (a save-serialization bug that silently lost real student input) — a documented/assumed state and the actual state disagreed, and the only thing that ever catches this in FoxCS's current pipeline is a human noticing, on whatever day they happen to look.

## Recommendations, ranked by effort vs. impact

### 1. Add a "Source of Truth" list to `CLAUDE.md` (lowest effort, addresses Jay's stated example directly)

Jay's own example — *"I want to make sure we are using the markdown from the repo and that we can make it so this is up to date"* — is exactly what python-app's 25-doc list solves. Concretely: add a short, named list to FoxCS's root `CLAUDE.md` (or each course's own `CLAUDE.md`) of the specific docs that actually govern authoring right now — `content-authoring-standards.md`, `lesson-quality-standards.md`, `lesson-schema.md`, `authoring-workflow.md`, `content-voice-and-tone.md`, `mastery-check-standards.md` — with the same "when in doubt, these win" framing. This doesn't require new tooling, just an explicit statement of what's load-bearing, so a session authoring content knows it must re-read these specific files fresh rather than working from what it remembers about them (which is exactly how `codename-policy.md`'s drift went unnoticed for weeks).

### 2. Add a "last verified" line to the docs that drift fastest (low effort)

`codename-policy.md`, `roster-schema.md`, and any doc describing a live system's actual behavior (as opposed to a design decision) should carry a one-line "verified against live [Moodle DB / roster sheet] on [date]" note, the same way python-app's `CLAUDE.md` opens with "Last verified build: [date] — PASSED." A stale verification date is a visible signal to re-check before trusting the doc, rather than silent drift.

### 3. Tie every new authoring rule to a real check, even a cheap one (medium effort, highest long-term payoff)

Adopt python-app's convention directly: **a new rule added to `content-authoring-standards.md` or `lesson-quality-standards.md` isn't done until there's something that checks for it**, even if that's a 10-line script rather than a full test suite. The four bugs in `authoring-flow-gaps-2026-08-11.md` are the concrete backlog for this:
   - A script that opens a lesson's practice HTML and confirms a block-bank's rendered order differs from its data-order (catches the unshuffled-bank bug class).
   - A script that fills every `<textarea>`/`<select>`/checkbox in a save-in-place page, triggers save, and confirms the saved file actually contains what was entered (catches the data-loss bug class — this one is the highest priority given it silently destroys real student work).
   - A prompt/option-text scan that flags multiple-choice questions where an option's own wording (e.g. "X only") could be ruled in/out without reading the question content (catches the eliminable-distractor bug class; the rule already exists in prose, this just automates the check the rule describes).

   None of these need python-app's full schema/Supabase machinery — they're standalone scripts against FoxCS's existing HTML files, sized to FoxCS's actual scale (a few dozen lesson files, not hundreds).

### 4. A lightweight documentation-status table (medium effort)

Not python-app's full 122-file audit machinery, but a short table in `open-questions.md` or a new `02-authoring-system/doc-health.md`: which authoring docs were last reviewed against actual current practice, and when. Given how small FoxCS's authoring-doc set is (~25 files in `02-authoring-system/`), this is a much cheaper version of python-app's `documentation-status.md` and would have caught both of this week's stale-doc incidents on the next scheduled pass rather than by accident.

### 5. State the AI-content rule explicitly (low effort)

Since essentially all FoxCS content is now Claude Code-authored, borrow python-app's explicit framing rather than leaving it implicit: add one line to `authoring-workflow.md` or `content-authoring-standards.md` stating that AI-generated content is never considered done at the point of generation — it must pass Phase 7's validation steps (and, once built, recommendation 3's automated checks) before being marked drafted, let alone reviewed/final. This won't change behavior by itself, but makes the existing (currently implicit) expectation checkable and citable, the same way python-app's rule is one sentence a session can be pointed back to.

## What NOT to import from python-app

- **Not the full canonical-JSON-schema + Supabase pipeline.** That's built for a multi-tenant commercial app with adaptive sequencing across a large content team; FoxCS is a solo-authored, two-surface (Moodle + VS Code), 1-hour/week-grading-budget course. `content-authoring-standards.md` already made this call correctly for content philosophy — the same judgment applies to pipeline infrastructure.
- **Not the 40-plus-file `docs/ai/` + `docs/meta/` governance layer wholesale.** Most of it is unbuilt aspiration for python-app itself. The load-bearing ideas (source-of-truth list, staleness tracking, rule→test convention) are worth taking; the surrounding governance ceremony (ownership models, archive strategy, version policy documents) isn't sized for a one-person course-build.
- **Not a rewrite of `authoring-workflow.md`'s 8 phases.** The phases are sound and reflect real, proven iteration (Lesson 01.4). The gap is entirely in Phase 7's total lack of automation, not in the phase structure itself.
