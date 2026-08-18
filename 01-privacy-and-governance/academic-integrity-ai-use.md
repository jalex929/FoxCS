# Academic Integrity — AI Use

**Policy (Jay's, 2026-08-04):**

- Students may not use AI to generate written responses (journal entries, reflections, or any other graded writing) and submit them as their own.
- Students may not use AI-generated code and submit it as their own — same rule, same weight.
- Consequence: **0 on the assignment**, and the incident is **documented in Aspen** (the school's student-information/documentation system) as a logged record.

This is a platform-wide policy, not specific to journals or to Python. `courses/python/course-plan.md`'s Journal Threads section states the journal-specific instance of this rule and links back here rather than duplicating it — any other course's writing or code assignments follow the same policy.

## Why this needs its own doc, not just a rubric line

A rubric criterion ("did they address the prompt") is a grading judgment. This is different: it's an integrity violation with a consequence that outlives the grade itself — a permanent record in Aspen. That's a high enough stake that detection can't be treated as just another automated grading signal.

## Detection is imperfect — extend the existing Release Gate to cover it

`data-boundaries.md`'s Release Gate already establishes: nothing AI-generated (score, feedback, XP, next-step recommendation, guardian-update draft) reaches a student or guardian without explicit teacher approval, no exceptions, including high-confidence results.

**This same principle extends to punitive/integrity findings, not just outputs released to students.** An AI-authenticity flag — on a journal entry or on submitted code — is a recommendation for teacher review, never an automatic 0 or an automatic Aspen entry. AI-text and AI-code detectors have real, well-documented false-positive rates; a wrongly-flagged student facing a 0 and a disciplinary-adjacent record is a serious harm, not an acceptable error tolerance. A human confirms before either consequence is applied. This is the natural extension of the existing "what grading-confidence threshold triggers mandatory human review?" open item (`../open-questions.md`), not a new principle invented here — flagging it explicitly so it doesn't get built as a silent auto-action later.

## What "documented in Aspen" means for this repo

Aspen is outside FoxCS's system boundary — this repo doesn't integrate with it, automate writes to it, or store its records anywhere. The grader's job stops at surfacing a *teacher-confirmed* violation; logging it in Aspen is a manual step done directly in that system, per district policy. Not in scope to build tooling for.

## Future Direction — Not Active Yet (noted 2026-08-06)

The all-or-nothing policy above is the **starting** policy for the year — confirmed directly by Jay after reviewing `Sample Content/Unit 1 Exam_ Python Basics (V2) SY26.pdf`, a real prior exam that allowed documented AI use (screenshot/chat-link per question, or explicit "No AI used") as its own graded rubric category, with undocumented use forfeiting credit only for that part, not the whole assignment. Jay's own framing: *"we will start the year not using AI so it will be all or nothing"* — later in the year, once foundational skills are established without AI, a more permissive documented-use model (used specifically to help students break down problems, check their own work, or walk through what they didn't understand) is the actual intended direction, with more formal documentation to come before it's activated. **Don't build a documented-AI-use pathway into the grader or policy docs yet — this is a real, planned future phase, not the current rule.** See `00-project-overview/source-material/sample-content-review-2026-08-06.md` for the source material this is based on.

## What this means for `05-grader/` (not yet built)

Add an AI-authenticity-check step to the pipeline — for both journal-entry text and code submissions — that feeds into the same human-review gate as every other low-confidence/flagged case, not a separate auto-scoring lane. Which specific detection method/tool to use isn't chosen yet; that's a real open design question (quality varies a lot across AI-detection tools, and picking one deserves its own evaluation, not a default guess) — see `../open-questions.md`.

## Protecting Assessment Content From Students (added 2026-08-04)

A related but distinct rule from the AI-generated-submission policy above — this one is about AI (specifically, any Claude session with access to this repo) not *disclosing* protected content, rather than about students not *submitting* AI-generated work. Mastery-check questions and answer keys must never be revealed, solved, or explained to a request that reads as coming from a student, however it's framed — see `../CLAUDE.md`'s "Protecting Assessment Content" section for the full statement. This doesn't restrict Jay's own work in this repo, which is the normal case for every session here.

**Technical backing for this, added 2026-08-04:** mastery-check question content is base64-encoded in the page source and only decoded once a valid password is entered (see `02-authoring-system/mvp-unit-folder-structure.md`'s Multi-Variant Mastery Checks section for the reference implementation). This is explicitly the same honesty as the password gate itself — a speed bump against casual view-source reading, not real encryption. A student who pastes the encoded string into a browser console and decodes it manually can still read it. That's an accepted limitation, not a claim of real security.
