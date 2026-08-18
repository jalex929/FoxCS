# 01.3 Mastery Check: Teacher Key

**Never include this file in the folder distributed to students.**

**1. (DOK 1-2. Direct prediction)** Exactly:
```
Setting up...
Score: 0
Lives: 3
Go!
```
Deterministic. This can be auto-checked against the exact string once the grader exists (`validation_method: exact_output` in adaptive-python's terms). Full credit requires the exact order and exact text; a right answer with lines out of order is not full credit even though every line is individually correct.

**2. (DOK 2. Construct code from a target output, then DOK 3. Reason about consequence)** Any three statements producing that exact output in order earn credit for the first part, e.g. `print("Loading save file...")`, `print("Welcome back, Player!")`, `print("Continue where you left off? (y/n)")`. For the second part: yes, the program would still run without crashing (Python doesn't care about the *meaning* of the order, only the programmer does). But the output would no longer make sense to a player ("Welcome back, Player!" appearing before "Loading save file..." reads as backwards). Full credit requires distinguishing these two questions explicitly. This is the item most likely to reveal a student who thinks "it runs" and "it's correct" are the same thing.

**3. (DOK 3. Refute a misconception)** Expected: disagree. Python does not reorder or interpret intent. It runs exactly the statements in exactly the order written, every time. "Sensible order" is something a *programmer* has to get right by writing the statements in the right order in the first place; Python has no concept of what would make sense to a player. Full credit requires stating clearly that Python does *not* reorder anything on its own. A student who says "disagree" but reasons for the wrong reason (e.g. "because computers aren't actually that fast") should not get full credit.

**Common misconception to watch for (`CODE-01`):** "the computer will figure out what I meant". This is the same misconception flagged in 01.1's key, showing up again in a more specific form (order-independence rather than instruction-following in general). If it persists here, it's worth a direct callback to 01.1 rather than treating it as a new issue.
