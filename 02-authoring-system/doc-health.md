# Doc Health

**Added 2026-08-31**, per `pipeline-comparison-python-app-2026-08-31.md`'s recommendation 4 — a lightweight version of python-app's `documentation-status.md`, sized for FoxCS's actual authoring-doc set (this folder). Tracks when each file was last reviewed against actual current practice, not just when it was last edited.

This is a baseline pass, not a deep audit: files touched this session (2026-08-31) are marked reviewed today; everything else is marked not yet audited until someone actually checks it against reality.

| File | Last reviewed | Status | Notes |
|---|---|---|---|
| adaptive-practice-model.md | 2026-08-31 | stable | reconciled: Moodle resumed 2026-08-28, status note added pointing to `mod_lesson` as primary mechanism; this doc kept as reference for static VS Code-side practice only |
| authoring-flow-gaps-2026-08-11.md | | not yet audited | |
| authoring-workflow.md | 2026-08-31 | stable | Phase 7 AI-validation line added this session |
| browser-python-execution.md | | not yet audited | |
| content-authoring-standards.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| content-voice-and-tone.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| design-system.md | | not yet audited | |
| doc-health.md | 2026-08-31 | stable | this file |
| feedback-collection.md | | not yet audited | |
| image-style-guide.md | | not yet audited | superseded, kept for reference |
| instructional-image-guide.md | | not yet audited | |
| lesson-navigation-standards.md | | not yet audited | |
| lesson-quality-standards.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| lesson-schema.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
| mastery-check-standards.md | | not yet audited | Source of Truth doc — see CLAUDE.md |
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
