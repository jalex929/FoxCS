# 01.6 Mastery Check: Teacher Key

**Never include this file in the folder distributed to students.**

**1. (DOK 2)** `print("New Record!")`. Missing closing quote (`SyntaxError: EOL while scanning string literal`).

**2. (DOK 2)** `print("Paused")`. Missing quotes, so `Paused` was read as an undefined variable name (`NameError: name 'Paused' is not defined`).

**3. (DOK 3. Two simultaneous errors)** `print("Continue")`. Mistake one: capitalized `Print` should be lowercase `print`; mistake two: missing quotes around `Continue`. Full credit requires both named separately, not "it was broken in two ways." This is intentionally harder than items 1-2 because real broken code often has more than one problem at once, and a student needs to fix and re-check rather than assume one fix is the whole answer.

**4. (DOK 3. Explain the underlying distinction, not just memorize the table)** Expected: a `SyntaxError` means Python couldn't even parse the grammar of the line. It doesn't know what you meant at all (missing quote, missing parenthesis). A `NameError` means Python parsed the line fine grammatically, but then went looking for something by an exact name (a variable, a misspelled/miscapitalized function name) and didn't find it defined anywhere. Full credit requires stating that a `NameError` implies the line *was* valid syntax. Python "understood the grammar" and got stuck on a different problem (an undefined name). Students who describe both errors identically ("Python didn't understand the code") haven't actually distinguished them, which is the whole point of this item.

**Common misconception to watch for (`CODE-01`):** treating every red error message as the same category of problem ("a syntax error"), rather than reading which specific error Python raised. This item exists specifically to check whether that distinction actually landed, not just whether the student can fix code by trial and error.
