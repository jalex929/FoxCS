# Authoring Flow Gaps — 2026-08-11 Audit

Requested by Jay: a direct look at where the authoring process and content-development pipeline are genuinely thin right now, not a restatement of `open-questions.md` (which is mostly platform/privacy/grading-workflow questions). This is scoped to **how lessons actually get built, checked, and rolled out** — the process itself, not any one lesson's content. Jay said he'd provide more context and address these later; nothing here is scoped to fix today.

## 1. There is no content-QA step that would have caught this session's own bugs

Four real bugs were found in already-"working" content this session, all by Jay reading closely, not by any authoring checklist step:

- Drill 8's prompt wording let a student eliminate 3 of 4 options without reading the code (`content-authoring-standards.md` now has a rule about this, added *after* the bug, not before).
- Drill 7's block bank rendered unshuffled — solvable by clicking top to bottom.
- Drills 1/5's block bank re-sorted back to unshuffled order on every placement (same root cause as the item above, different symptom).
- A save-serialization bug where a `<textarea>`, `<select>`, or checkbox's actual value never made it into the saved file at all — a student's real answer would silently vanish on reopen. This one is worse than the others: it's not a rigor gap, it's data loss, and it existed across four files before anyone noticed.

**The gap:** none of `authoring-workflow.md`'s 8 phases, `lesson-quality-standards.md`'s checklist, or `content-authoring-standards.md` (before today) had a step that says "verify shuffled content actually stays shuffled across interaction," "verify distractors aren't eliminable from the prompt alone," or "verify a save-in-place page's saved file actually contains what was typed/selected/checked, not just what the JS thinks happened." **Jay explicitly flagged this as a priority to build out** (2026-08-11): more robust, repeatable tests/checks specifically for (a) accuracy of actual content — correct answers, correct hints, correct answer/option ordering; (b) language that isn't hard for ELL/IEP students to parse (idioms, hyperbole, figures of speech, recall-dependency — the "fuzzy" fix and the vocab-quiz-reflection redesign are exactly this category); and (c) whether the adaptive practice model's Reinforce-lane support actually gives a real concept breakdown when a student needs intervention, not just another attempt at the same difficulty. None of this exists as a repeatable process yet — every catch so far has been a human read-through, which doesn't scale past one reviewer's attention on one lesson at a time. This is real, prioritized future work, not filed away — see `adaptive-practice-model.md`'s and `content-authoring-standards.md`'s open items for where this eventually plugs in.

## 2. No lesson has ever actually reached "reviewed/final" status

`course-plan.md`'s own status legend (⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final) has never been exercised end-to-end on Lesson 01.4, the one lesson that's gone through the most iteration of anything in this repo. There's no record of a discrete "review pass" happening — what happened instead was continuous live editing based on Jay's read-through feedback, which is a different (and so far, more effective) process than what the schema describes. Worth deciding: is the 4-state legend the real process, or should it be revised to describe what's actually working (iterative live review) instead of an idealized draft→review pipeline that's never actually been run?

## 3. No reusable template has been extracted from the now-proven Lesson 01.4 pattern

`worklog.md`'s "Next up" has said "roll the Lesson 01.4 pattern out to 01.1-01.3/01.5-01.6" for a while, but there's no template doc that captures the pattern *as it actually landed* after all of today's changes: the concept-card system, the Back/TOC/Next footer convention, the `1.4.N` part-numbering scheme, the guided-practice-in-instruction vs. Practice-page split, the `_completed` save convention, the mixed auto-/teacher-checked assessment shape. Someone (Jay or a future session) rebuilding Lesson 01.5 today would have to reconstruct all of this by reading Lesson 01.4's files directly rather than following a checklist. Worth building a real template/checklist doc before the next lesson starts, not after.

## 4. The pipeline that would let any of this reach real students doesn't exist yet

Two scripts block piloting entirely, independent of how polished the content is:

- **Codename-swap-on-download** — strips real names, assigns codenames, on Classroom download. Not built.
- **Student-copy export** — currently a manual "remember not to include KEY files" step producing the distributed folder from the authoring source. Not built.

No amount of content quality matters until these exist — this is the actual bottleneck between "Lesson 01.4 is in good shape" and "a real student can do Lesson 01.4."

## 5. The new mixed-assessment signal (adaptive-practice-model.md) depends on a grader that's a placeholder

The whole point of splitting Practice into auto-checked and teacher-checked items was to give Jay a real readiness signal — "does this student need to revisit the instruction, or move on." The auto-checked half works today (telemetry). **The teacher-checked half has nowhere to land** — `05-grader/` is still a requirements list, not software. Until it exists, half of the signal this design promises is aspirational. Not a reason to not build it, but worth being honest that "Practice tells you who needs support" isn't fully true yet.

## 6. File System Access API surface has grown and is still completely untested on real devices

`05-grader/README.md`'s Testing Needs already flagged `showSaveFilePicker` as untested on real school Chromebooks/`file://`. Today added a second, related API dependency: `00_table_of_contents.html`'s "Check My Progress" uses `showDirectoryPicker()`. If either API behaves differently than expected on real school hardware/browser policy (Chromebooks in managed environments sometimes restrict File System Access API features), a meaningful chunk of what got built today silently doesn't work, and nobody would know until a real pilot. This risk grew today, it didn't shrink.

## 7. DOK levels are still a stub

`lesson-schema.md`'s `dok_levels_covered` field exists but has never actually been populated for Lesson 01.4, the reference lesson. Practice's items (even under the new adaptive-node redesign) are mostly DOK 1-2; the one DOK 2-3 item (diagnosing the compound error, Drill 8 / soon to be a `diagnosing_errors` node) is still the exception, not the norm. The 2026-08-06 note calling the current drill approach an "acceptable worst case, not final state" has never been revisited despite two practice-model redesigns since. Worth deciding whether DOK spread is tracked concretely per lesson or stays an aspiration.

## 8. Spiral review has a real structural gap in early units

`adaptive-practice-model.md`'s new 2-4-item spiral review requirement runs into a real wall in Unit 00/01: the first few lessons of the year don't have 2+ prior lessons' worth of genuinely distinct skills to draw on yet. This isn't a one-lesson footnote — it needs an explicit early-unit exception or ramp-up rule (e.g., "spiral review floor doesn't apply until Lesson 01.4" or similar), decided once, not re-discovered lesson by lesson.

## 9. Mastery-check answer key existence is unverified

`09_mastery_check.html` and `content-authoring-standards.md` both reference `teacher-materials/.../lesson_01_04_mastery_check_KEY.md` as the DOK-tagged answer key with named misconception codes. Whether that file actually exists in the state the standards describe hasn't been checked this session — worth confirming before treating Lesson 01.4 as fully "reference-implementation-complete."

## Not a gap, but worth naming: iteration speed vs. process overhead

Today's session covered vocab-quiz regrading, a feedback-form redesign, a table of contents with a live folder scan, a part-numbering scheme, a critical save bug across four files, and an adaptive-practice-model design — all in one continuous back-and-forth with Jay reading real content and reacting. This is genuinely effective for a solo/small-team build, but it's also exactly the kind of process that makes gaps 1-3 above easy to miss: there's no forcing function that pauses to ask "does this change need a doc update, a template update, a regression check on other files touched by the same convention" before moving to the next piece of feedback. Not proposing a heavier process — just naming the tradeoff explicitly, since it's the mechanism behind most of the gaps above.
