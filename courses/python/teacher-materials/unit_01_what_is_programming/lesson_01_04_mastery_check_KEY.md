# 01.4 Mastery Check: Teacher Key

**Never include this file in the folder distributed to students.**

**Format changed 2026-08-06:** the student answer surface is `10_mastery_check.py` (a plain file edited/saved in VS Code), not textareas embedded in `09_mastery_check.html`. The questions below and their grading criteria are unchanged — only where a student's answer physically lives changed.

**Timestamp mechanism corrected 2026-08-07:** students do **not** copy a timestamp anywhere — the earlier version of this doc described that convention and it was a mistake Jay caught. `09_mastery_check.html` now writes an `unlocked_at` time automatically the moment the password is entered, and a `completed_at` time when the student clicks "Mark Complete & Save," both as hidden (visually-hidden-but-DOM-present, not literal white-on-white) fields saved inside that file's own HTML source — check the submitted `09_mastery_check.html`'s source for both, not the `.py` file. Still a lightweight, non-tamper-proof pacing signal (see `mvp-unit-folder-structure.md`), useful as a cross-check against when their section actually got the password, not proof on its own — just no longer dependent on a student copying it correctly.

**1. (DOK 1-2. Direct prediction)** Exactly:
```
Welcome back!
You have 3 lives remaining.
```
Deterministic, auto-checkable once the grader exists.

**2. (DOK 2. Debug, missing closing quote)** Correct: `print("Inventory Full")`. Mistake: missing closing quote (would raise `SyntaxError: EOL while scanning string literal`). Full credit requires naming the mistake, not just producing a working fix. A student who fixes it by accident/trial-and-error without being able to name what was wrong hasn't demonstrated the actual objective.

**3. (DOK 2. Debug, missing parentheses)** Correct: `print("Quest Complete")`. Mistake: missing parentheses (Python 2 style; raises `SyntaxError: Missing parentheses in call to 'print'` in Python 3). Same naming requirement as above.

**4. (DOK 3. Apply the usability idea from this lesson, not just write valid syntax)** Any syntactically correct `print()` with a specific, readable message earns partial credit (e.g. `print("You need 10 more coins to buy this item.")`). Full credit requires the explanation to name *why* it's good feedback. Specific/readable/actionable. Not just "because it's correct Python" or "because it works." A student who writes `print("Error 402")` and calls it good feedback should not get full credit on the explanation half, even if the code runs fine. That's exactly the "bad feedback" example the lesson's game-connection callout warned against.

**Common misconceptions to watch for:** `CODE-01`. Treating "the code runs without crashing" as the same thing as "this is good output" (item 4 specifically tests for this). `CODE-02`. Fixing a syntax error without being able to explain what was wrong (items 2-3). This is a real gap even when the fix itself is correct, since the same mistake will recur in later lessons if the underlying rule wasn't actually understood.
