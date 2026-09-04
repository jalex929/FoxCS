# Chat Log

Running TLDR of Claude's conversations with Jay, across sessions — **not a transcript.** Captures context Jay provides, questions Claude asks, and how those questions get resolved, so a session that gets interrupted before Jay finishes responding still leaves a record of what was pending.

**Update continuously, not batched at session end.** Specifically:

- Log context Jay provides (background, constraints, corrections) as soon as it's given.
- Log a question **the moment it's asked** — before Jay answers — so an interrupted session still shows what was left open.
- Update that same entry in place once Jay answers, rather than leaving the "asked" version to go stale. An entry that's still open when a session ends stays open until answered.

**This is not where decisions live.** Anything decided here that matters going forward must also be written into `decisions-log.md` (permanent decisions) or `worklog.md` (technical mid-flight state) — same session, not deferred. `chat-log.md` is the conversational TLDR that makes those other logs easier to update in real time; it doesn't replace them. See `open-questions.md` for longer-lived unresolved questions that outlive a single conversation.

Newest entries at the top, grouped by day.

---

## 2026-09-04 (latest) — redirected to Unit 02, unleveraged docs surfaced

**Context from Jay:** The DOK/rigor/typed-code example from his previous message was only an example, not a fixed checklist — the real point is that a lot of existing documentation in this repo hasn't actually been leveraged yet. Wants to shift focus to building a strong Unit 02 (confirmed: zero content exists there yet). Also resolved two open threads directly: 01.5/01.6 not having a Project module is fine (not every lesson needs one, especially given the new "many Coding Exercises, only one Project" cardinality rule), and by extension the whole "rework 01.5/01.6 now?" question is moot for that specific point.

**Grounded, not just re-read:** cross-checked `adaptive-practice-model.md` and `browser-python-execution.md` against what's actually deployed in Unit 01 — confirmed neither has ever been built into a real lesson (still a flat drill list, no Pyodide "Run & Check" anywhere). Also found and resolved a genuinely stale doc while grounding this: `courses/python/CLAUDE.md` still said "no lesson content authored" and "Moodle is paused," both false since August. And closed a real dangling open question: the 2026-08-20 "assessment tier, name TBD" turned out to already be resolved in practice — it shipped as "Coding Exercise."

**Next up, not yet decided:** which Unit 02 lesson is the pilot for the new adaptive-node/spiral-review/Game-UX/hint model, and whether Pyodide "Run & Check" ships in that pilot or gets a real Chromebook test first given its untested 6-10MB download cost. See `worklog.md`'s matching entry.

## 2026-09-04 (even later) — per-lesson module structure locked in

**Context from Jay:** Specified the target module list directly: Instruction (bundling instruction/vocab flashcards/vocab quiz/other questions/adaptive practice, not password-gated), a separate Project module (instructions+submission combined), Mastery Check, and Coding Exercise as its own module "when relevant." Students should attach a `.py` file for submissions rather than pasting code. Mid-message, clarified the earlier tabbed-navigation thread: wants a per-lesson expandable top menu covering all of that lesson's own content (like the pre-08-30 flat-file lessons, minus the complicated nested cross-lesson part). Also noted directly: the 01.4–01.6 pattern built so far is "OKAY but... can be greatly improved."

**Q (asked, answered):** Three clarifying questions before writing this into `CLAUDE.md`/`decisions-log.md`, since guessing wrong meant rebuilding across every future lesson. "Is Project the same content as the already-built Coding Exercise, renamed, or genuinely separate?" → Genuinely separate, both can exist in one lesson. "What happens to the separate Feedback module (not in your list)?" → No strong preference, asked for a recommendation — kept it separate (matches what's already built, distinct reflection-vs-assessment purpose). "How strict should the `.py`-attachment expectation be?" → File upload only, restricted to `.py`, no online-text fallback.

**Resolved this session:** full 5-module structure written into `CLAUDE.md`'s Purpose section and `decisions-log.md`. Real open thread, not yet decided: whether already-built 01.5/01.6 (Instruction+Practice split across two native Lesson activities, no Project module at all) get reworked now to match, or stay a grandfathered exception — see `worklog.md`.

## 2026-09-04 (later) — structure brainstorm, resolved to a prototype

**Context from Jay:** Torn between the current lesson/practice structure and an earlier tabbed-page structure. Wants student work captured/saved, autograder-assigned points/XP, strong visual completion confirmation, and to keep the interactivity already rebuilt into the component library. Real pain point driving this: percentage-complete is broken and Lesson 01.3 can't be marked done. Also flagged a content bug: mastery-check prompts that name a specific error count ("correct the 2 mistakes") should either be verified correct or reworded vague — added as a standing rule in `content-authoring-standards.md`, with one live instance found but not yet fixed (see `worklog.md`).

**Q (asked, answered):** "What's the actual top priority — save/completion accuracy, visual polish, or fastest build given the absence?" → Save student work + fix completion/gradebook accuracy, with a strong learner experience so students can focus on content. "Open to SCORM packaging?" → Not sure, wanted the tradeoffs walked through more first. "How much detail should be captured?" → Full interaction telemetry.

**Q (asked, answered):** After a deeper, source-verified tradeoff walkthrough (SCORM vs. full native rebuild vs. a custom completion-API endpoint — see `decisions-log.md`'s 2026-09-04 entry), asked whether to prototype the custom-endpoint option on one lesson or keep discussing. → **Prototype it, in the test/sandbox course** (`sandbox-adaptive-demo`), not a live course.

**Resolved this session:** built and verified end-to-end in the sandbox — see `decisions-log.md` and `worklog.md`'s matching 2026-09-04 entries. Next real decision (not yet made): which live lesson gets this first, and whether XP/grading gets pushed from this endpoint or left entirely to the autograder.

## 2026-09-04

**Context from Jay:** Will be out Sept 21 – Oct 30 (6 weeks). Wants a running conversational log so nothing is lost if a session ends before he responds to something — separate from `worklog.md`'s technical state and `decisions-log.md`'s permanent decisions.

**Q (asked, answered):** "How should conversation continuity be tracked, given sessions can get interrupted before Jay responds?" → Built `chat-log.md` (this file): a TLDR, not a transcript; questions logged before *and* after Jay answers; decisions still flow through to `decisions-log.md`/`worklog.md` as normal, this just backstops the conversational thread itself. `CLAUDE.md` updated to reference it and to call out committing to these logs regularly through a session, not just at the end.

**Next up:** pick a build mechanism per Seminar III lesson (2–8) before dispatching parallel builds — carried over from earlier today's ground-truth audit, see `worklog.md`.
