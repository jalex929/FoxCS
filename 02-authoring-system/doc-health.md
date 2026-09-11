# Doc Health

**Added 2026-08-31**, per `pipeline-comparison-python-app-2026-08-31.md`'s recommendation 4 — a lightweight version of python-app's `documentation-status.md`, sized for FoxCS's actual authoring-doc set (this folder). Tracks when each file was last reviewed against actual current practice, not just when it was last edited.

This is a baseline pass, not a deep audit: files touched this session (2026-08-31) are marked reviewed today; everything else is marked not yet audited until someone actually checks it against reality.

| File | Last reviewed | Status | Notes |
|---|---|---|---|
| adaptive-ladder-runbook.md | | not yet audited | added to this folder since the last full pass; no row existed |
| adaptive-practice-model.md | 2026-08-31 | stable | reconciled: Moodle resumed 2026-08-28, status note added pointing to `mod_lesson` as primary mechanism; this doc kept as reference for static VS Code-side practice only |
| authoring-flow-gaps-2026-08-11.md | 2026-09-03 | stable | gaps #1's four named bugs (unshuffled banks, save-serialization, eliminable distractors, plus a new drill-feedback-completeness check) and gap #9 (mastery-check answer key existence) all now have real automated checkers + test suites in `02-authoring-system/tools/` — see that folder's `tests/`. Gap #9 specifically: verified today the 6 real `teacher-materials/.../*_mastery_check_KEY.md` files do exist and are well-formed. Gaps #2-8 (lesson review-status tracking, template extraction, the codename/export pipeline, File System Access API device testing, DOK stub, spiral-review gap, iteration-speed tradeoff) are still open, not addressed by this pass. |
| authoring-workflow.md | 2026-08-31 | stable | Phase 7 AI-validation line added this session |
| browser-python-execution.md | | not yet audited | |
| certiport-gmetrix-account-setup.md | | not yet audited | added to this folder since the last full pass; no row existed |
| content-authoring-standards.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| content-voice-and-tone.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| design-system.md | | not yet audited | |
| doc-health.md | 2026-08-31 | stable | this file |
| feedback-collection.md | | not yet audited | |
| grade-point-scale.md | 2026-09-11 | stable | revised 2026-09-11: Project moved from per-lesson (25, in the 50-pt lesson total) to per-unit (20, required, on top); Unit 01 gets a simplified one-grade retrofit instead of full realignment — see the doc's own Unit 01 Retrofit section. XP-tier-to-grade formula for the Unit Project still needs Option A/B resolved before implementation. |
| h5p-content-type-gotchas.md | | not yet audited | Source of Truth doc — see CLAUDE.md (8th doc, added 2026-09-02) — has no row in the original baseline pass despite being cited as authoritative since |
| image-style-guide.md | | not yet audited | superseded, kept for reference |
| instructional-image-guide.md | | not yet audited | |
| lesson-navigation-standards.md | | not yet audited | |
| lesson-quality-standards.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| lesson-schema.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| mastery-check-standards.md | 2026-09-09 | stable | Source of Truth doc — see CLAUDE.md. Open item resolved (Moodle Quiz confirmed default, not VS Code); new standing rule added (no starter-file scaffolding for a VS Code Mastery Check item, per Jay's IntelliSense-autofill concern) |
| moodle-lesson-ladder-setup.md | | not yet audited | paused, kept for reference |
| moodle-quick-pilot-workflow.md | | not yet audited | paused, kept for reference |
| mvp-unit-folder-structure.md | | not yet audited | |
| objectives-and-skills-proficiency.md | 2026-08-31 | stable | Source of Truth doc — see CLAUDE.md. Ladder section updated: single pool-size number (Core 1/Reinforce 1-2/Extend 1-2), Reinforce-decomposes + Extend-adds-context rules, CS-vs-Seminar-III density subsection added |
| pipeline-comparison-python-app-2026-08-31.md | 2026-08-31 | stable | this session's own audit doc |
| project-rubric-and-xp-tiers.md | | not yet audited | |
| telemetry-and-analytics.md | | not yet audited | |
| theme-system.md | | not yet audited | |
| vscode-content-conventions.md | | not yet audited | |
| xp-and-incentives.md | | not yet audited | |

## How to update this file

When you actually review a file against current practice (not just skim it), update its row: set `Last reviewed` to today's date and `Status` to `stable`, `needs-review` (drifted, not yet fixed), or `known-stale` (confirmed wrong, fix tracked elsewhere). Add a one-line note if the status needs context. New files in this folder get a row with a blank date and `not yet audited`.
