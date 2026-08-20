# 1.1 Mastery Check: Teacher Key

**Never include this file in the folder distributed to students.** See `../../../../../02-authoring-system/mvp-unit-folder-structure.md`.

**Rebuilt 2026-08-20** to match `lesson_01_04_printing_output`'s current mastery-check pattern. Two format changes from the version this replaces:

1. **Single password, not the old 3-variant (A/B/C) design.** The base64-obfuscated multi-variant mechanism is retired lesson-wide as of the 2026-08-06 mastery-check redesign (see `../../../../../decisions-log.md`) — matches `lesson_01_04_printing_output`'s current reference pattern, which also uses one password. Multi-variant is still available per `mastery-check-standards.md` if a future need justifies the extra authoring effort.
2. **Student answer surface is `06_mastery_check.py`** (a plain comment-stubbed file edited/saved in VS Code), not textareas embedded in `05_mastery_check.html`. `05_mastery_check.html` writes `unlocked_at` and `completed_at` timestamps automatically into hidden fields the moment the password is entered and "Mark Complete & Save" is clicked — check the submitted `05_mastery_check.html`'s source for both, not the `.py` file. Still a lightweight, non-tamper-proof pacing signal, useful as a cross-check against when the student's section actually got the password, not proof on its own.

Underlying questions and grading criteria are unchanged from the original draft (same 3 core scenarios), plus a new 4th question testing the Python/programming-language objective, which the original 3-question version didn't cover on its own.

**1. (DOK 2. Interpretation)** Looking for a genuinely new example (not video game, not calculator app, per the prompt) with the instruction-following idea stated correctly. E.g. a washing machine, a traffic light, a GPS. Full credit requires the student to identify that it's a program *because* it follows exact steps, not just because it's "a machine" or "electronic."

**2. (DOK 2. Application to a new scenario)** Any specific, plausible instruction counts. E.g. "if the amount inserted is less than the price, don't release the item" or "if the button for slot B4 is pressed, dispense from slot B4." Full credit requires an instruction stated with an actual condition/action, not just "it checks the money" with no specifics.

**3. (DOK 3. Justify/argue a position)** Expected position: disagree, with reasoning that computers don't "figure things out." They follow the exact instructions a programmer wrote, including when those instructions produce a wrong or unexpected result. Full credit requires correct use of "instruction" as the mechanism, not just asserting disagreement. Partial credit for a correct instinct without connecting it back to "instruction" specifically. That's the vocabulary check this item is doing double duty on.

**4. (DOK 2. Role/purpose explanation, new item)** Looking for: a programming language (Python or otherwise) is a tool for writing instructions in a form a computer can actually carry out, and a programmer needs one because a computer can't be given instructions in plain, everyday human language. Full credit requires naming that translation role specifically, not just "Python is what we use in this class" with no explanation of why a language is needed at all. Partial credit for identifying Python as "a programming language" without explaining the role a language plays.

**Common misconception to watch for (`CODE-01`):** students describing a computer as "deciding" or "understanding" rather than "following instructions that were written by a person." This is the single biggest misconception this whole lesson exists to head off. If it shows up in Q3 especially, that's a flag the core idea didn't land, not just a minor wording issue.

**Common misconception to watch for (`CODE-02`, new):** conflating "a program" with "any file" or "anything electronic" (relevant to Q1 and to Practice Drill 8). A student who calls a printed book or a plain text document "a program" hasn't yet separated "runs and follows instructions" from "exists on/near a computer."
