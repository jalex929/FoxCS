# Content Voice and Tone

**Superseded 2026-08-04 as the primary source — see `../waypoint_curriculum_copywriting_guide.md`.** Jay provided a full Waypoint Learning curriculum copywriting guide (voice, cognitive-load rules, Reinforce/Core/Extend copy patterns, "I can..." learning and language objective formulas, feedback patterns, a full review checklist). That file is now the canonical reference for FoxCS curriculum copy. This doc stays as a shorter FoxCS-specific supplement: the parts of the earlier `adaptive-python` adaptation that still apply, plus FoxCS-specific additions (em dashes, GMetrix tone) not covered by the Waypoint guide. When the two conflict, the Waypoint guide wins.

Originally adapted from `adaptive-python`'s `docs/meta/terminology-and-language-standards.md` and `docs/ux/error-message-guidelines.md`.

## What Carries Over Unchanged

**Tone should remain:** calm, professional, supportive, structured, non-judgmental.

**Avoid:** hype-heavy language, shame-based language, overly casual phrasing, emotionally manipulative copy, sarcasm, blame-oriented phrasing.

**Never use:** "Wrong," "Failed," "Incorrect again," "You should know this," "You failed too many times."

**Preferred error/feedback structure:**
```
What happened
↓
Why it may have happened
↓
Suggested next step
```

**Preferred examples (directly reusable):**
- "The program may be missing a closing parenthesis. Try checking the line highlighted in the editor."
- "The output does not match the expected result yet. Try checking whether the variable name matches earlier usage."
- "You can try again after reviewing the previous step."

## What Changes for FoxCS

| adaptive-python | FoxCS |
|---|---|
| "Learner" | **"Learner" (capital L), confirmed 2026-08-04.** Earlier sessions had switched this to "student," reasoning that FoxCS is a real classroom. Reversed once Jay provided `../waypoint_curriculum_copywriting_guide.md` and confirmed explicitly: follow that guide's terminology, including "Learner," not "student." Use "Learner" in all student-facing/curriculum copy (instructional pages, flashcards, practice, mastery checks, journal prompts, project instructions). Internal/author-facing docs (privacy policy, grading rubrics, decisions-log, teacher-only mastery-check keys) can still say "student" where they're describing real people in a real school, not writing in Waypoint's instructional voice — that's a different kind of document, not curriculum copy. Also avoid "user" in the same curriculum-copy contexts; use "Learner," "player" (when discussing the end-user of code a Learner is writing), or "person" instead. |
| App-native terms (Mastery Objective, Activity) | Keep where they map cleanly (see `objectives-and-skills-proficiency.md`); don't force a term that doesn't fit a classroom context |
| No teacher in the loop | Every AI-generated message is teacher-reviewed before release (see `../CLAUDE.md`). Tone matters even more here since a human is vouching for it |

## Mastery / Progression Language

From `adaptive-python`'s mastery philosophy. Directly applicable:

- Mastery is **not** perfect first-attempt performance, memorization, speed, or flawless execution.
- Debugging, revision, and experimentation **are** part of mastery, not evidence of failure.
- Progression language should be: supportive, non-elitist, confidence-building, growth-oriented.
- Avoid: competitive framing, superiority language, exclusionary ranking language.
- Preferred framing: progress, growth, practice, revision, confidence, persistence.

This directly informs the proficiency scale in `objectives-and-skills-proficiency.md`. A scale that reads as ranking or deficit ("Insufficient," "Not Evident") cuts against this philosophy even if the underlying data model needs that granularity internally.

## Punctuation and Sentence Style (added 2026-08-04)

**No em dashes.** Jay avoids them in his own writing and wants FoxCS content to follow the same rule, in every student-facing file (instructional pages, flashcards, practice, mastery checks, journal prompts) and in `course-plan.md` prose. Use a period, comma, colon, or parentheses instead. If a sentence only works with an em dash, it usually means the sentence should be split into two.

## Bolded Lead-In Labels Start Their Own Line (added 2026-08-10)

Any bolded `Label:` used to open a thought (`Fix:`, `Note:`, `Example:`, `Handoff to VS Code:`, `Up next:`, etc.) starts on its own line, never runs mid-paragraph after preceding prose. Flagged after Jay reviewed `lesson_01_04_printing_output/01_instruction.html` and found `<strong>Fix:</strong>` buried at the end of an explanatory sentence, easy to skim past. Structurally, this means each labeled thought gets its own `<p>` (or block element), not a run-on inside the paragraph that precedes it — see that same file's Two Mistakes section for the corrected pattern (`decisions-log.md`'s 2026-08-10 entry has the before/after).

## Waypoint Learning High-School Copywriting Standards

**Found — see `../waypoint_curriculum_copywriting_guide.md`.** Jay provided this directly on 2026-08-04, after an earlier search of `adaptive-python` only turned up a combined "high school and adult learners" version (`python-app/curriculum/CHATGPT_PROMPT.md`, `prior-agent-context.txt`) that undersold how detailed the real guide is. The real guide is comprehensive: Learner-variability design principles, cognitive-load rules, concrete-to-abstract sequencing, Reinforce/Core/Extend copy characteristics, feedback-progression patterns (Notice → Recall → Prompt → Decompose → Model → Reattempt), a full "I can..." objective-writing system (Section 7-8), and a publish-time review checklist (Section 13). Read it directly rather than relying on this summary — this doc only calls out FoxCS-specific deltas from it (em dashes, GMetrix tone), not a restatement.

Confirmed still true from the earlier, thinner search: avoid trick questions; use everyday/real-world examples; avoid examples requiring specialized professional knowledge; build confidence without lowering rigor (the guide's own Section 1.7, same instinct as this doc's Mastery/Progression Language section above).

## Accessibility: Write for ELL, IEP, and 504 Students Explicitly

Named directly per Jay's 2026-08-04 request, not folded into vaguer "multilingual learners" language. Every rule in `content-authoring-standards.md`'s Universal Design section (plain language, no assumed background, chunk instructions, one concept at a time) exists specifically to serve English Language Learners, students with an IEP, and students with a 504 plan. Keep that framing explicit when writing or reviewing content, not just as an unstated background goal.

## Applying This to GMetrix Content

Workbook-derived content (see `../01-privacy-and-governance/licensing-boundaries.md`) is often written in flatter, more exam-prep-style language. When recreating it as H5P/lesson content, rewrite the surrounding instructional voice to match this guide. The underlying technical content and file naming stay traceable to GMetrix, but the tone shouldn't feel like a different product bolted onto the course.
