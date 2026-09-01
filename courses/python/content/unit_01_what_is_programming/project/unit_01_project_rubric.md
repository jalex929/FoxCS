# Grading Rubric — Unit 01 Project: Interactive Greeting

Follows `templates/grading-rubric-template.md`'s shape. Grounded directly in the real requirements stated in `unit_01_project_instructions.html` — not invented separately from the assignment text.

## Item

- **Title:** Unit 01 Project — Interactive Greeting
- **Unit / Lesson:** Unit 01: What Is Programming?
- **Type:** mini-project
- **Submission format:** `unit_01_project.py`

## Criteria

| Criterion | Description | Points / Weight |
|---|---|---|
| Print statement count and flow | At least 6 `print()` statements, ordered so the exchange reads like a real back-and-forth greeting (not 6 disconnected lines) | 25% |
| Comment quality | At least one comment that explains what a section of the program is doing and *why* — not a restatement of the line below it (matches 01.5's weak-vs-strong comment distinction) | 20% |
| Runs cleanly | No syntax errors; the file runs top to bottom without Python flagging anything (matches 01.6's target skill) | 25% |
| Personalization | Uses a specific invented name and a specific invented detail about the player, not a generic "Hello, player" greeting | 20% |
| Concept scope | Sticks to what Unit 01 actually taught — `print()`, comments, statement order — no real `input()` or variables used as a workaround (the assignment explicitly says real interactivity isn't taught until Unit 03, and using it early would mean the student didn't actually practice the intended skill) | 10% |

## Mastery / Completion Threshold

Meets expectations = at least 4 of 5 criteria clearly met, with Runs Cleanly and Print Statement Count/Flow both required regardless of the other three (a program that doesn't run, or that doesn't have a real back-and-forth exchange, hasn't demonstrated the core skill even if comments/personalization are strong).

## Feedback Bank

- **Strong submission:** All 5 criteria met — the greeting reads like a real exchange, the comment explains real intent, it runs clean, and the personalization is specific and genuine.
- **Meets expectations, minor issues:** Core exchange and clean run are both solid; one lighter criterion (comment quality or personalization specificity) is present but thin. Note which one specifically.
- **Needs revision — generic greeting:** Personalization criterion not met — greeting reads as templated ("Hello, player!") rather than naming a specific invented person/detail. Point back to the assignment's own game-connection framing (a save-file screen greeting a specific player) as the model to aim for.
- **Needs revision — weak or missing comment:** Either no comment at all, or a comment that just restates the line below it word-for-word. Point back to 01.5's real vs. weak comment examples.
- **Needs revision — syntax errors present:** File doesn't run clean. This is the one criterion with a hard, checkable answer — actually run the file before scoring, don't assume from reading the code.
- **Needs revision — used input()/variables early:** Student jumped ahead to Unit 02/03 concepts instead of practicing the Unit 01 skill the assignment is actually testing. Not wrong code, but not evidence of the target skill — flag warmly, not punitively (the assignment itself says "you're not doing it wrong" for not using input(), so a student who *does* use it isn't being dishonest, just skipping the intended practice).

## Notes

The assignment's own "Example Shape (Don't Copy. Write Your Own)" block is a real, close-to-complete solution shape — when grading, distinguish between a student who followed that shape with genuinely different content (fine, expected) versus one who submitted something structurally identical with only the name/detail swapped (worth a closer look, possible near-copy, not necessarily a violation but worth teacher awareness per the naming-issue-adjacent judgment calls `feedback-and-grading-spec.md` already covers).
