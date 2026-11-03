# Portfolio Prep: Public Showcase of FoxCS

**Started 2026-11-03**, per Jay: get FoxCS ready to feature in job interviews (AI engineering roles) without exposing student data, assessments, or licensed Certiport/GMetrix content. The approach is a **separate, sanitized showcase repo with fresh history**. This operational repo stays the real working space. It's been built from an outside portfolio-readiness review (ChatGPT, shared by Jay), adapted to what's actually true here.

## Files in this folder

| File | Purpose |
|---|---|
| `security-and-licensing-audit-2026-11-03.md` | What is publicly exposed in this repo right now, and what to do about it. **Read first.** |
| `rag-integration-notes.md` | Internal notes on how RAG could be integrated into FoxCS later. Nothing built |
| `export_showcase.sh` | Copies `portfolio-showcase/` into a brand-new git repo (fresh history, leak scan and tests must pass first) |

The showcase content itself lives at the repo root in `portfolio-showcase/`, so it's easy to find and edit.

## The plan, as a checklist

| # | Step | Status |
|---|---|---|
| 1 | Audit sensitive and licensed content | **Done**, see the audit. **Urgent follow-up for Jay: make FoxCS private and rotate the quiz/test-account passwords** |
| 2 | Portfolio-focused root README | Done: `portfolio-showcase/README.md` |
| 3 | Architecture diagram | Done: Mermaid diagrams in the README and `docs/architecture.md` (render natively on GitHub). Screenshots of the live platform still needed, see below |
| 4 | End-to-end demonstration with synthetic data | Done: two synthetic submissions, committed grader output in `examples/demo-output/` |
| 5 | Testing and validation evidence | Done: `docs/testing.md`, a CI workflow, 55 tests across 3 suites, documented gaps |
| 6 | AI reliability and boundaries | Done: `docs/ai-reliability-and-boundaries.md` and `docs/grading-pipeline.md` (capability status table, the six "how does it actually work" questions) |
| 7 | Small LLM evaluation suite | Structure done: 6 adversarial cases, 11 deterministic checks, reference judgments, tests. **Next: baseline model runs** |
| - | RAG | Documented only, deliberately not built (`rag-integration-notes.md`, public version in `docs/rag-roadmap.md`) |

## What Jay needs to do (things no session tool can do)

1. **Make `jalex929/FoxCS` private.** GitHub, Settings, General, Danger Zone, Change visibility. See the audit for why this is urgent beyond portfolio prep.
2. **Rotate passwords** for live Mastery Check quizzes and the Moodle test account. They've been publicly readable.
3. **Create the showcase repo:** an empty GitHub repo named `foxcs-showcase` (no README or license), then run `bash 00-project-overview/portfolio-prep/export_showcase.sh` and follow the printed push steps. A session could push it afterwards if the new repo is added to its scope.
4. **Set the GitHub About panel** on the new repo:
   - Description: `Live Moodle learning platform with a hybrid assessment pipeline: deterministic grading, AI-assisted feedback, teacher approval gate, and an eval harness for AI grading outputs.`
   - Website: `https://www.jayfox.design` (or the case-study page once it exists)
   - Topics: `education-technology`, `ai-evaluation`, `llm`, `moodle`, `python`, `assessment`, `human-in-the-loop`, `responsible-ai`
5. **Add screenshots** of the real platform (an Instruction page, the practice ladder, a Moodle gradebook view with pseudonymous IDs only) to `portfolio-showcase/docs/images/` and reference them near the top of the README. Check every screenshot for real usernames, names, and the live URL first. The leak scanner flags image files for manual review on purpose.
6. **Pick a license** for the showcase (MIT is common for portfolio code), or leave it unlicensed (all rights reserved). It's a deliberate choice, so it wasn't made for you.

## What was deliberately not done

- No history rewrite, deletion, or visibility change on this repo. All are destructive or outward-facing and need Jay's explicit go-ahead.
- No RAG build and no Storybook, per the review's own advice.
- No changes to live Moodle.
- The bonus-points Known Tension (`REPO_MAP.md`) was not resolved. That's Jay's call. The showcase documents the bonus path as not active, and the eval harness rejects any output that applies a bonus.

## Keeping the showcase in sync

`portfolio-showcase/grader/auto_grade.py` is a sanitized copy of `05-grader/school-side/auto_grade.py` (renamed identifiers, rewritten comments, same logic). If the real grader changes, port the change by hand and re-run `python tools/check_showcase_clean.py` plus the tests. Then re-export or commit to the showcase repo directly. Never copy files from elsewhere in this repo into the showcase without running the scanner.

## Interview framing notes

- Lead with the problem (1 hour/week grading budget), the three-layer design, and the Release Gate.
- The authority hierarchy and Known Tensions list is the strongest "working with coding agents" story. Use the per-lesson Mastery Check reversal as the concrete example.
- Be precise about AI-assisted review: it's a teacher-operated workflow, not an unattended service. The status table exists so nobody overclaims.
- Don't claim SOPPA/district compliance. Say the separation design supports it and that the district review is pending.
- The eval harness is the probabilistic-evaluation story. Its honest next step (baseline runs, variance across repeated runs) is itself a good talking point.
