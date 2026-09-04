# Content Authoring Standards: DOK Levels, Universal Design, and Documentation

This is the reference for **how to write and document** an activity, question, or lesson component. As distinct from `content-voice-and-tone.md` (the *voice* it should be written in) and `lesson-quality-standards.md` (the checklist a finished lesson should pass). Use this doc while authoring; use `lesson-quality-standards.md` to check your work afterward. See `mastery-check-standards.md` specifically for mastery-check items. They follow the DOK rubric below but have their own count/authoring-order rules.

Sourced from a full read-through of `adaptive-python`'s docs (`python-app/docs/content/`, `docs/ux/`, `docs/learning-science/`, `docs/ai/`), adapted down to FoxCS's much lighter scope. A solo/small-team, 1-hour/week grading budget, non-adaptive, two-surface (Moodle + VS Code) course, not a production app with a multi-role review pipeline. Where adaptive-python's version was sized for that bigger pipeline, only the load-bearing part was kept.

## DOK Levels

**Note on sourcing:** `dok_levels_covered` was already stubbed into `lesson-schema.md`, but adaptive-python turns out not to define a DOK rubric anywhere. It uses "DOK 2, 3, or 4" as unexplained shorthand in a few architecture docs, assuming Webb's model as background knowledge rather than writing it out. What adaptive-python *does* define is its own `question_complexity` axis (`isolated → integrated → transfer → synthesis`) and an objective-sequencing progression (`recognition → interpretation → application → debugging → synthesis`). Both useful cross-checks, referenced below, but not a substitute for an actual DOK rubric. The levels below are FoxCS's own, built from Webb's Depth of Knowledge (the standard your students' other classes already use), not ported from adaptive-python.

| DOK | Name | What it asks of the student | Rough adaptive-python analog |
|---|---|---|---|
| 1 | Recall & Reproduction | Recall a fact, definition, or syntax rule; follow a taught procedure exactly as shown | `isolated` |
| 2 | Skill / Concept Application | Apply a concept in a straightforward but new situation; more than one step; interpret, compare, predict | `integrated` |
| 3 | Strategic Thinking | Reason, plan, justify; non-routine problems with more than one reasonable approach; debug, decide, explain | `transfer` |
| 4 | Extended Thinking | Multi-concept, often open-ended and time-extended; typically a project. Plan, build, test, revise | `synthesis` |

**Python-specific examples, one per level:**

- **DOK 1** . "What does `print()` display?" / "Which of these is a valid variable name?" / "Write a `for` loop that counts from 1 to 10" (direct reproduction of a pattern just taught).
- **DOK 2** . "Predict what this program will print, then run it to check." / "Write a program that asks for the user's name and age, then prints a sentence using both." / "Given this list, write the code to add an item and print the updated list."
- **DOK 3** . "This program has a bug. Find it, fix it, and explain what was wrong." / "You need to store student names and their grades. Would you use a list or a dictionary? Justify your choice." / "Rewrite this repetitive code using a loop, and explain why your version is better."
- **DOK 4**. A unit project (Mad Lib Generator, Number Guessing Game, the Capstone) where the student plans, builds, tests, and revises a working program from a loose prompt, combining several concepts. "Design and build a program that tracks something you care about, using at least three concepts from this unit."

**How to use it:** every lesson's `dok_levels_covered` field (see `lesson-schema.md`) should span more than one level across the two surfaces. Moodle typically carries DOK 1-2 (vocabulary, guided practice, predict-the-output), VS Code typically carries DOK 2-4 (practice sets, project, reflection). Don't cluster all DOK 1 on Moodle and all DOK 3-4 in VS Code by default. Some conceptual depth belongs in a reflection prompt, some straightforward application makes a good VS Code warm-up. This is also stated in `lesson-quality-standards.md`; this doc is what gives that line an actual rubric to point to.

**Two authoring techniques worth deliberately using, not just DOK 3-4 window dressing:**
- **Predictive reasoning**. Ask "what will this output?" or "which line causes the problem?" *before* the student runs the code. Strengthens the mental model in a way that running-and-observing alone doesn't.
- **Debugging as retrieval, not just a skill category**. A debugging task simultaneously exercises syntax recall, conceptual understanding, and pattern recognition. Treat debugging exercises as legitimate DOK 2-3 retrieval practice, not a side activity.

## Universal Design / Approachability

Concrete, actionable rules for the content itself. Not app-UI accessibility (screen readers, touch targets, contrast ratios), which doesn't apply to FoxCS's Moodle + VS Code delivery. Each rule below is something you can check while writing a specific question or lesson.

- **Written explicitly for ELL, IEP, and 504 students** (named directly per Jay, 2026-08-04. Not just "accessibility" in the abstract). Every rule below exists to serve these students specifically, alongside everyone else.
- **No assumed background.** Don't assume a specific home setup, family structure, income level, or cultural context in examples or scenarios. Use inclusive names; avoid stereotypes.
- **Plain language, deliberately.** Concise sentences, reduced jargon. New terminology is introduced intentionally and in context. Never as a memorization list. Prefer "Variables: Saving Information" over "Primitive Data Types and Variable Assignment."
- **One primary concept per unit of content.** Each explanation block, H5P activity, or practice file should focus on a single new idea. Don't bundle two new concepts into one explanation because it's convenient.
- **Chunk, don't jump.** Short, staged instructions and progressive examples. If a step feels like a big leap from the last one, it's missing an intermediate step, not a sign the student needs to "just get it."
- **Coherence. Cut what isn't load-bearing.** No decorative content, no tangents, no extra examples that don't add a new angle on the concept. Extraneous content competes for the same attention as the actual concept.
- **Keep explanation physically next to what it explains.** In a VS Code file, comments/instructions live right above the code they describe, not in a separate document the student has to hold in their head alongside the editor. In Moodle, feedback appears near the action that triggered it.
- **Don't say the same thing twice in competing formats.** If a video already explains something, the accompanying text shouldn't re-narrate it. It should add something (a worked example, a different angle), or it's just redundant load.
- **Vary problem context, not just difficulty.** When a lesson gives multiple practice items at the same DOK level, vary the scenario (not just the numbers). This is what builds transfer, not just repetition. A Reinforce/Core/Extend set that's the same problem with different variable names isn't doing this.
- **Support multilingual learners.** Avoid overly academic phrasing and idioms that don't translate literally. This is a plain-writing constraint that helps everyone, not just multilingual students.

## Question & Activity Documentation Standards

FoxCS doesn't need adaptive-python's full pipeline (multi-role sign-off, telemetry validation, staged rollback). There's no adaptive engine and no large content team. What's worth keeping, scaled down:

- **Misconception → recovery pairing.** Already required by `lesson-quality-standards.md`: every named misconception needs somewhere to send the student (a specific support resource, not just "review the lesson"). Use the `Common Misconceptions` section already in `../templates/lesson-template.md` (`CODE-01:` style). A code with no paired resource is a dead end, not a placeholder to fill in later.
- **A few real variants, not one question repeated.** When a Reinforce/Core/Extend lane needs more than one item at the same level, each variant should have a genuinely different scenario/context, not just swapped numbers or variable names. Same rule as the "vary problem context" point above, applied to how you write the files. FoxCS's practice volume is intentionally light (a handful of files per lane, not adaptive-python's 3-5-per-objective question banks), so make each one count rather than padding the count.
- **Distinguish what the student sees from what's actually checked.** Even without an automated grader yet, write practice/project instructions so the visible task ("make the program print X") and the actual grading criteria (in the rubric) are both explicit and don't silently diverge. This is what "sufficient evidence for grading" in `lesson-quality-standards.md` means in practice.
- **Status, not just existence.** Use `course-plan.md`'s existing legend (⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final) as the actual authoring-status field for every lesson. A lesson isn't "done" at ✅ (drafted), it's done at 🔍 (reviewed). Don't let drafted-but-unreviewed content quietly become the de facto final version.
- **Hints escalate, they don't reveal.** The `Stuck Support` section in `lesson-template.md` should walk a student from a conceptual nudge toward (but not to) the answer, in stages. A reminder of the concept, then a more directional nudge, then a structural suggestion. Never jump straight from "you're stuck" to the full solution.
- **A stated error count must be verified, or left vague.** If a prompt names a specific number of mistakes ("correct the 2 mistakes in this line of code"), that number must be checked against the actual code before publishing — a real instance shipped saying "2" when the line had 3. If the count hasn't been (or can't be) verified, don't state one: use open language instead ("there are multiple errors in this line of code — write the corrected version") so the prompt can't be wrong about something it doesn't need to claim.
- **Distractors must not be eliminable from the prompt's own wording.** Added 2026-08-11 after a real bug in `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/05_practice.html` Drill 8: the prompt said "this line has more than one thing wrong with it," while two of the four answer options were phrased as "X only." A student could throw out both "only" options and the "nothing is wrong" option without reading the actual code at all, purely from the setup sentence. Read every multiple-choice/dropdown question as if you're a student who hasn't looked at the content yet, just the prompt and option text side by side, and ask whether any option can be ruled in or out from wording alone. If the prompt reveals how many things are true, how many parts are affected, or otherwise narrows the option set before the content is even examined, rewrite the prompt to be neutral (state what's being asked, not what shape the answer takes) and let the options carry the actual difficulty. This matters more than usual for FoxCS specifically, since Jay authors and reviews every question directly and needs the difficulty he intends to actually land — a leaked answer silently flattens a question's real DOK level without ever showing up as an authoring error unless someone notices the pattern.

## Learning-Science Principles Worth Keeping in Mind

Short authoring philosophy, not a checklist. These inform judgment calls the rules above don't fully cover:

- **Guided decomposition, not oversimplification.** Breaking a concept into smaller steps should reduce confusion without stripping out the actual reasoning the student needs to do. If a "simplified" version removes the thinking, it's over-scaffolded.
- **Healthy challenge vs. harmful frustration.** Healthy: persistence, experimentation, productive debugging. Harmful: repeated unsupported failure, a jump in complexity with no bridge. Use this as a gut-check when deciding how hard a DOK 3 question should be before a stuck pathway kicks in.
- **Spiral review should feel like progress, not punishment.** When an earlier skill reappears in a later unit, it should show up in a more varied or complex context. Not as a flat repeat that reads as "you're being made to redo this."
