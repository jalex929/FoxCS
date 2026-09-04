# 2.1 Project Rubric: Character Status Tracker

Internal rubric for the Project module's submitted `.py` file. Written per the 2026-09-04 standing rule that every gradable submission ships with a rubric alongside it, not just an answer key, so the `05-grader/` autograder has something concrete to check against. Not points-weighted beyond what's below; this is a checklist, matching the "plain checklist is sufficient" guidance.

## What a Complete Submission Needs

- [ ] At least 4 variables describing character state, each with a real, snake_case-valid name.
- [ ] At least one variable holds a string value (quoted), at least one holds a number.
- [ ] Every variable is printed with a text label via `print("Label:", variable)` or equivalent, not a bare `print(variable)`.
- [ ] At least one variable is reassigned partway through the file (the same name, a new value) and printed again afterward so the change is visible in the output.
- [ ] The file runs with no syntax errors.
- [ ] File is submitted as a single `.py` file upload (not pasted text, not a `.txt` or `.docx`).

## Common Misconceptions to Watch For

- `CODE-VAR-01`: Reassigns by creating a second, differently-named variable instead of overwriting the original (e.g. `health = 100` then `health2 = 80`) — misses the actual reassignment skill.
- `CODE-VAR-02`: Prints a bare value with no label (`print(100)` instead of `print("Health:", 100)`) — misses the usability point taught in the lesson.
- `CODE-VAR-03`: Uses a variable name that breaks a naming rule but happens to run anyway in a way that looks accidental (unlikely given Python would raise a `SyntaxError`, but check for a name that only barely passes, like a single-letter name that loses all meaning).

## Tier Bonus Checks (Optional, +10 / +20 XP)

- [ ] Tier 1: 2+ additional state variables beyond the required 4, genuinely different kinds of information (not just more health-like numbers).
- [ ] Tier 1: a real comment explaining one naming choice, not a generic "this is a variable" comment.
- [ ] Tier 2: a second reassignment at a distinct point in the program.
- [ ] Tier 2: a genuine 2-3 sentence comment connecting the chosen print labels to what a real player would need to understand them. A comment that just restates "labels are good" without saying why, for this specific submission, does not meet this bar.

## Full Credit / Partial Credit / No Credit

- **Full credit:** all Required items checked, code runs, reassignment is visible in the output.
- **Partial credit:** Required items mostly present but one is missing or broken (e.g. reassignment creates a new variable instead of overwriting, per `CODE-VAR-01`) — award credit for what's genuinely demonstrated, note the gap in feedback.
- **No credit / insufficient evidence:** fewer than 4 real variables, no labels on any printed output, or the file does not run at all.
