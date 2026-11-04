# Unit 02 Project: Personal Profile Generator: grading rubric

**Status: proposed.** From Jay's `courses/python/teacher-materials/sources/Unit_2_Project_Grading_Scale_2026-10-16.pdf`. Confirm these requirements match what students were actually assigned before grading against it. **Points:** the assignment's posted maximum (20 is provisional, `02-authoring-system/grade-point-scale.md`).

## Required task

A fictional profile with at least five meaningful variables, including `str`, `int`, `float` and `bool`. Print a labelled profile, reassign one existing variable and show the update, and write a summary using `+` with `str()` where needed. Submit one runnable `.py` file, with a comment explaining one data-type choice and evidence of two test runs. Fixed values; no user input needed.

## Evidence

Holistic: no per-criterion points. The evidence decides the one overall tier below.

| Criterion | | Evidence |
|---|---|---|
| Correctness |  | **Full:** runs; labels and summary match the current values, including the reassigned one; both tests behave as expected. **Partial:** mostly correct, but one value is stale, a local defect remains, or one test fails. |
| Concept usage |  | **Full:** five meaningful variables covering all four types; same-name reassignment; correct `+` and `str()`. **Partial:** some types or the conversion missing, or the update creates a second name. Credit each concept shown. |
| Code quality and explanation |  | **Full:** meaningful names, clear labels, a specific comment on why one type fits its value. **Partial:** unclear names or labels, or a generic explanation. |
| Completeness and testing |  | **Full:** profile, update, summary, `.py` file, and two documented tests. **Partial:** a section, submission detail, or test missing. |

## Overall tier (one per project)

| Tier | Grade | Evidence needed |
|---|---|---|
| Below Starter | Varies | Central profile or state-change evidence missing, nonfunctional, or too limited. Score from this rubric and teacher review; no automatic 80% floor. |
| Starter | 80% | Runnable, meaningful profile with at least four variables, a string and a number, labels, and visible same-name reassignment, but full-credit elements missing. |
| Skilled | 100% | Every required element complete and correct. No optional feature needed. |
| Legendary | 103% | Skilled plus a useful additional profile detail and a documented changed-data test confirming profile and summary still agree. |
| Mythic | 106% | Legendary plus a clear design rationale for type choices, updates, and output usability, with concrete examples from the program. |

Check the required work first: an optional feature never makes up for a missing requirement. Apply one tier; don't stack the older XP bonuses on top.

**Test example:** Nova starts at level 3 and is reassigned to 4; label and summary both show 4. Change the start to 7 and the update to 8; both show 8.
