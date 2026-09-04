# Chat Log

Running TLDR of Claude's conversations with Jay, across sessions — **not a transcript.** Captures context Jay provides, questions Claude asks, and how those questions get resolved, so a session that gets interrupted before Jay finishes responding still leaves a record of what was pending.

**Update continuously, not batched at session end.** Specifically:

- Log context Jay provides (background, constraints, corrections) as soon as it's given.
- Log a question **the moment it's asked** — before Jay answers — so an interrupted session still shows what was left open.
- Update that same entry in place once Jay answers, rather than leaving the "asked" version to go stale. An entry that's still open when a session ends stays open until answered.

**This is not where decisions live.** Anything decided here that matters going forward must also be written into `decisions-log.md` (permanent decisions) or `worklog.md` (technical mid-flight state) — same session, not deferred. `chat-log.md` is the conversational TLDR that makes those other logs easier to update in real time; it doesn't replace them. See `open-questions.md` for longer-lived unresolved questions that outlive a single conversation.

Newest entries at the top, grouped by day.

---

## 2026-09-04

**Context from Jay:** Will be out Sept 21 – Oct 30 (6 weeks). Wants a running conversational log so nothing is lost if a session ends before he responds to something — separate from `worklog.md`'s technical state and `decisions-log.md`'s permanent decisions.

**Q (asked, answered):** "How should conversation continuity be tracked, given sessions can get interrupted before Jay responds?" → Built `chat-log.md` (this file): a TLDR, not a transcript; questions logged before *and* after Jay answers; decisions still flow through to `decisions-log.md`/`worklog.md` as normal, this just backstops the conversational thread itself. `CLAUDE.md` updated to reference it and to call out committing to these logs regularly through a session, not just at the end.

**Next up:** pick a build mechanism per Seminar III lesson (2–8) before dispatching parallel builds — carried over from earlier today's ground-truth audit, see `worklog.md`.
