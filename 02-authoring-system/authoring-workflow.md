# Authoring Workflow

The full process for taking one lesson from "just an entry in `course-plan.md`" to "piloted and revised." Grouped into phases for readability — originally a flat 104-step list, reorganized here without cutting any steps. Every lesson should go through all of these before being considered pilot-ready.

## Phase 1 — Define

1. Confirm the lesson ID, unit, and sequence.
2. Confirm the lesson title and overview.
3. Confirm programming, computational-thinking, and language objectives.
4. Confirm prerequisites and vocabulary.
5. Confirm which DOK levels this lesson covers, and whether they're reasonably spread across Moodle and VS Code (not all easy DOK on one surface).
6. Define what mastery looks like.
7. Define what partial understanding looks like.
8. Define what constitutes a meaningful attempt.
9. Define conditions for no score.
10. Define common misconceptions and assign misconception codes.

## Phase 2 — Define Grading Rules

11. Define rubric criteria and point values.
12. Define XP opportunities (including any Moodle extra-credit engagement).
13. Define revision and reassessment expectations.
14. Define progression rules (mastery → next lesson; struggle → reinforce/reassess).
15. Define Reinforce, Core, and Extend expectations for this lesson's practice sets.
16. Define Starter/Skilled/Legendary/Mythic expectations, if this lesson uses them.

## Phase 3 — Author Moodle Content

17. Write the lesson introduction / video script (or source existing video).
18. Build H5P interactive practice (vocabulary, drag-drop, guided practice) with instant feedback.
19. Write the guided-practice walkthrough.
20. Write Reinforce/Extend adaptive support content for Moodle.
21. Write the extra-credit/XP-bonus Moodle activity, if this lesson has one.
22. Write the handoff instructions that send the student into VS Code with an explicit task.

## Phase 4 — Author VS Code Content

23. Write instructional explanations and worked examples.
24. Create visual explanations or diagrams, if needed.
25. Create prediction questions and checks for understanding.
26. Create guided practice and independent practice.
27. Create Reinforce, Core, and Extend practice files.
28. Create stuck supports and common-error supports (local HTML).
29. Create challenge/extension materials.
30. Create reflection prompts (remember: graded, and must be checked for genuine completion, not just presence).
31. Create note-taking prompts.
32. Create submission instructions, file-naming instructions, and a submission checklist.
33. Confirm the exact file-naming convention and its point value.

## Phase 5 — Author Grading Materials

34. Create visible test cases.
35. Create hidden test cases.
36. Define acceptable alternate approaches — and approaches that technically run but don't demonstrate the target concept.
37. Create sample full-credit, partial-credit, minimal-attempt, and no-score responses.
38. Write answer guidance (a range of acceptable solutions), not a single fixed answer key.
39. Write rubric-based grading guidance.
40. Define automated grader configuration and human-review triggers for this lesson.
41. Define grading-confidence rules.
42. Write feedback templates, including misconception-specific, revision, reassessment, and extension feedback.
43. Define next-level/next-lane recommendation rules.
44. Define small-group recommendation rules tied to this lesson's misconception codes.

## Phase 6 — Generate Outputs

45. Generate student-facing Moodle content.
46. Generate the student-facing VS Code lesson folder.
47. Generate the teacher guide.
48. Generate rubric and test files.
49. Generate grader configuration.
50. Generate spreadsheet-ready records.

## Phase 7 — Validate

51. Validate all filenames, internal links, and image paths.
52. Validate folder structure against the schema.
53. Run accessibility and spelling/grammar checks.
54. Run all code examples.
55. Run visible and hidden tests against the reference solution.
56. Test alternate valid solutions, incomplete solutions, and common incorrect solutions.
57. Test missing-file and malformed-folder behavior (what does the grader do when a student submits wrong)?
58. Test the lesson on a school-like machine: no command line, no package installs, matches the available Python/VS Code configuration.
58a. AI-generated content is not done at the point of generation — it must pass steps 51-58 above before it can be marked drafted (✅) in `course-plan.md`'s status legend, let alone reviewed/final (🔍).

## Phase 8 — Pilot and Revise

59. Pilot the lesson with students.
60. Observe where students get confused, on both surfaces.
61. Record common misconceptions that weren't anticipated.
62. Review grader accuracy and scoring consistency.
63. Review false-positive similarity flags and low-confidence grading decisions.
64. Review whether feedback and support resources were actually useful.
65. Revise the lesson, the grader, and the authoring pipeline itself.
66. Record what changed and why in `../decisions-log.md`.
67. Approve the lesson for broader use, then apply the validated structure to the next lesson.

## Quality Bar

Every lesson should meet the standards in `lesson-quality-standards.md` before being marked pilot-ready.
