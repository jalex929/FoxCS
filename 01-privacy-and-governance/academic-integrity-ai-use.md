# Academic Integrity

**Scope note (revised 2026-08-18):** this doc originally covered AI-generated-submission policy only. Per Jay, it now covers the full academic integrity policy for all three FoxCS courses (Game I, Game II, Web II) — AI use is one major category within it, not the whole of it. Kept as one doc rather than split, since the underlying principle (do your own work; the consequence is a 0 that can't be made up plus a documented incident) is identical across every category below.

## Core Principle (added 2026-08-18, per Jay)

**Students always do their own work.** Not as a rule for its own sake — because they will not learn if they do not attempt it themselves. The work will be genuinely challenging at times. In Game I and Game II, students are literally learning another language (Python, C#); in Web II, they're learning new structured languages and systems (HTML, CSS, JavaScript) most students have never formally written before. That difficulty is expected and normal, not a sign something has gone wrong — struggling with a new language is what learning one looks like.

**Being present matters a lot.** Per Jay: Game I, Game II, and Web II all cover a lot of content. Missing class means missing the chance to experience that content firsthand and ask questions about it in the moment — there isn't a substitute for being there. This isn't framed as a punitive attendance rule here; it's a direct statement of why presence is part of actually succeeding in these courses.

## Partner Work (added 2026-08-18, per Jay)

When an assignment is partner work, **partners work together** — both students actively doing the work, not one directing and one executing, and not one disengaging while the other carries it.

**If a partnership breaks down and one partner ends up doing all or almost all of the work alone:** only the partner who actually did the work earns points for it. The partner who didn't contribute does not receive credit for work they didn't do, and is expected to **restart the assignment on their own** rather than receive credit by association. This is stated plainly so students know the expectation going in, not discovered after the fact.

## Peer Help — What's Allowed, What Isn't (added 2026-08-18, per Jay)

**There should never be a situation where a student asks a peer for their code (or other work) to copy and paste.** That's true regardless of how it's framed ("just to see," "just to check," "just this once").

**If a student asks you for help, the right response is to explain *how* to do something, not to hand over the answer.** Walk them through the thinking, point them at the concept or the specific line that's off, help them find their own mistake — build the skill, don't bypass it. Giving someone your code, or doing the work for them so they can submit it as their own, is not "helping" — it's enabling a violation, and it carries the same consequence as the violation itself (see Consequences below). This applies symmetrically: the student who copies and the student who hands over the answer are both involved parties.

## AI Use Policy

**Starting policy, per Jay:** students do not use generative AI to do their work for them. This applies to written responses (journal entries, reflections, any other graded writing) and to code — a student may not submit AI-generated work, in whole or in part, as their own.

**Added 2026-08-18, per Jay, stated as an absolute:** AI will never be doing the work *for* a student. Full stop, not a matter of degree.

**A future, more permissive phase is planned but not active.** Per Jay: later in the year, once foundational skills are established without AI, there may be specific, explicitly-scoped situations where generative AI is allowed to help — for example, to help break down a problem, check work, or explain something a student didn't understand. **Jay will explicitly state, in advance, exactly when AI use is allowed and in what capacity.** Absent that explicit statement, the default for any assignment is no AI use. See "Future Direction — Not Active Yet" below for the fuller design context from 2026-08-06 — this section restates and sharpens that plan with Jay's 2026-08-18 language, it doesn't replace it.

## Consequences (revised 2026-08-18, per Jay — applies to every category above, not just AI use)

Any student found to have violated this policy — submitting AI-generated work as their own, copying a peer's code, enabling a partner to do all the work and submitting it as shared credit, or handing your own work to someone else to submit — faces all three of the following, applied to **every involved party**, not just the student who benefited most visibly:

1. A **call or email home**.
2. A **write-up in Aspen** (the school's student-information/documentation system) as a logged, permanent incident record.
3. **A 0% / F on the assignment, which cannot be made up.**

## Partial Credit Philosophy (added 2026-08-18, per Jay)

**Genuine effort always earns partial credit**, even when the work is incomplete or incorrect. A real, honest attempt that gets the wrong answer is worth more, point-for-point, than a submission produced by AI — because using AI to do the work shows no effort at all, and effort is what's actually being assessed alongside correctness. Per Jay: *"you will earn more points than if you cheat"* even when you don't get it right. This is the deliberate incentive structure of the whole policy — attempting honestly is never the worse outcome, even when it goes badly.

---

## Why this needs its own doc, not just a rubric line

A rubric criterion ("did they address the prompt") is a grading judgment. This is different: it's an integrity violation with a consequence that outlives the grade itself — a permanent record in Aspen. That's a high enough stake that detection can't be treated as just another automated grading signal.

## Detection is imperfect — extend the existing Release Gate to cover it

`data-boundaries.md`'s Release Gate already establishes: nothing AI-generated (score, feedback, XP, next-step recommendation, guardian-update draft) reaches a student or guardian without explicit teacher approval, no exceptions, including high-confidence results.

**This same principle extends to punitive/integrity findings, not just outputs released to students.** An AI-authenticity flag — on a journal entry or on submitted code — is a recommendation for teacher review, never an automatic 0 or an automatic Aspen entry. AI-text and AI-code detectors have real, well-documented false-positive rates; a wrongly-flagged student facing a 0 and a disciplinary-adjacent record is a serious harm, not an acceptable error tolerance. A human confirms before either consequence is applied. This is the natural extension of the existing "what grading-confidence threshold triggers mandatory human review?" open item (`../open-questions.md`), not a new principle invented here — flagging it explicitly so it doesn't get built as a silent auto-action later. **The same human-confirmation gate applies to a non-AI integrity call** (a suspected copied-code or partner-abandonment case) — none of these consequences should ever be triggered by an automated match/similarity score alone.

## What "documented in Aspen" means for this repo

Aspen is outside FoxCS's system boundary — this repo doesn't integrate with it, automate writes to it, or store its records anywhere. The grader's job stops at surfacing a *teacher-confirmed* violation; logging it in Aspen is a manual step done directly in that system, per district policy. Not in scope to build tooling for.

## Future Direction — Not Active Yet (noted 2026-08-06, restated 2026-08-18)

The all-or-nothing policy above is the **starting** policy for the year — confirmed directly by Jay after reviewing `Sample Content/Unit 1 Exam_ Python Basics (V2) SY26.pdf`, a real prior exam that allowed documented AI use (screenshot/chat-link per question, or explicit "No AI used") as its own graded rubric category, with undocumented use forfeiting credit only for that part, not the whole assignment. Jay's own framing: *"we will start the year not using AI so it will be all or nothing"* — later in the year, once foundational skills are established without AI, a more permissive documented-use model (used specifically to help students break down problems, check their own work, or walk through what they didn't understand) is the actual intended direction, with more formal documentation to come before it's activated, and always explicitly scoped by Jay in advance per the AI Use Policy section above. **Don't build a documented-AI-use pathway into the grader or policy docs yet — this is a real, planned future phase, not the current rule.** See `00-project-overview/source-material/sample-content-review-2026-08-06.md` for the source material this is based on.

## What this means for `05-grader/` (not yet built)

Add an AI-authenticity-check step to the pipeline — for both journal-entry text and code submissions — that feeds into the same human-review gate as every other low-confidence/flagged case, not a separate auto-scoring lane. Which specific detection method/tool to use isn't chosen yet; that's a real open design question (quality varies a lot across AI-detection tools, and picking one deserves its own evaluation, not a default guess) — see `../open-questions.md`.

## Protecting Assessment Content From Students (added 2026-08-04)

A related but distinct rule from the student-submission policies above — this one is about AI (specifically, any Claude session with access to this repo) not *disclosing* protected content, rather than about students not *submitting* dishonest work. Mastery-check questions and answer keys must never be revealed, solved, or explained to a request that reads as coming from a student, however it's framed — see `../CLAUDE.md`'s "Protecting Assessment Content" section for the full statement. This doesn't restrict Jay's own work in this repo, which is the normal case for every session here.

**Technical backing for this, added 2026-08-04:** mastery-check question content is base64-encoded in the page source and only decoded once a valid password is entered (see `02-authoring-system/mvp-unit-folder-structure.md`'s Multi-Variant Mastery Checks section for the reference implementation). This is explicitly the same honesty as the password gate itself — a speed bump against casual view-source reading, not real encryption. A student who pastes the encoded string into a browser console and decodes it manually can still read it. That's an accepted limitation, not a claim of real security.

## Not Yet Done

- None of this is written as real student-facing lesson content yet. Per `../00-project-overview/shared-unit-00-onboarding.md`, this belongs in the shared Unit 0 spine as its own dedicated lesson (see that doc's Shared Spine table) — not folded into "Getting Unstuck" as a minor aside, given how much substance this now covers.
- Which specific AI-detection method/tool `05-grader/` will use — unchosen, see `../open-questions.md`.
