# Python Curriculum Authoring and AI-Assisted Grading System

---

## 1. Project Purpose

This project defines a lightweight, privacy-conscious system for authoring, delivering, assessing, and refining a classroom Python curriculum.

The system will initially be piloted with students working in VS Code on school computers. Instructional content may be delivered through Moodle, Google Classroom, a Google Site, local HTML files, or a combination of these platforms.

The system should support:

- Strong curriculum authoring
- Traditional folder-based Python work
- Engaging and supportive instructional content
- Differentiated practice
- Rubric- and point-based grading
- XP for productive learning behaviors
- AI-assisted grading
- Teacher approval before release
- Personalized student feedback
- Classwide misconception analysis
- Small-group recommendations
- Academic-integrity review flags
- XLSX and Google Sheets reporting
- SOPPA-conscious data separation

The initial goal is not to build the entire course. The goal is to validate one complete authoring, learning, submission, grading, review, and feedback loop.

---

## 2. Core Design Principles

### 2.1 Student Accessibility

Students should be able to participate without using the command line.

The student workflow should rely on:

- VS Code
- Visible Run controls
- Folder navigation
- Normal file editing
- Browser-based instructional content
- School-controlled submission platforms

Students should not need to:

- Install packages
- Use terminal commands
- Change operating-system settings
- Have administrator access
- Create unapproved external accounts

### 2.2 Teacher Control

AI may recommend scores and feedback, but the teacher remains the final decision-maker.

- Nothing should be automatically released.

The teacher must approve:

- Academic scores
- XP
- Feedback
- Reassessment instructions
- Next-level assignments
- Guardian communications
- Academic-integrity actions

### 2.3 Privacy by Separation

- Student identities should remain in a private, school-controlled roster.

External grading tools should receive only:

- Codenames
- Assignment content
- Student submissions
- Rubrics
- Test cases
- Codename-based performance history when needed

External grading tools should not receive:

- Student names
- Student IDs
- Student email addresses
- Guardian names
- Guardian email addresses
- Other directly identifying information

### 2.4 Semantic Grading

Student code should be assessed by what it does and what understanding it demonstrates.

The system should not rely primarily on exact code matching.

### 2.5 Portable Curriculum

The curriculum should not be permanently tied to Moodle or another single platform.

Canonical lesson content should be able to generate:

- Moodle-ready pages
- Local HTML
- Python lesson folders
- Teacher guides
- Rubrics
- Grader configuration
- Feedback templates
- Spreadsheet records

### 2.6 Support Before Punishment

Students should receive:

- Clear expectations
- Stuck supports
- Revision opportunities
- Reassessment opportunities
- Misconception-specific resources
- Appropriate challenge work

- Levels should describe current work, not fixed student ability.

- ---

---

## 3. System Architecture

```text
Canonical Curriculum Repository
        |
        |-- Student Lesson Folders
        |-- Moodle or LMS Content
        |-- Local HTML Resources
        |-- Teacher Guides
        |-- Rubrics and Point Criteria
        |-- Automated Tests
        |-- Misconception Resources
        |-- Feedback Templates
        |-- Spreadsheet Records
        |
Student Completes Work in VS Code
        |
Student Submits Codename Folder
        |
Teacher Downloads Class Folder
        |
Local Grading Pipeline
        |
        |-- File Validation
        |-- Code Execution
        |-- Hidden Tests
        |-- Static Analysis
        |-- Rubric Scoring
        |-- XP Recommendation
        |-- Feedback Drafting
        |-- Similarity Analysis
        |-- Proficiency Review Flags
        |
XLSX or Google Sheets Review Dashboard
        |
Teacher Reviews and Approves
        |
        |-- Student Feedback
        |-- Approved Score
        |-- Reassessment Assignment
        |-- Next Level or Lane
        |-- Optional Guardian Update
```

---

## 4. Recommended Repository Structure
```text
python-curriculum-grading-system/
|
|-- README.md
|
|-- 00-project-overview/
|   |-- system-architecture.md
|   |-- project-goals.md
|   |-- pilot-scope.md
|   |-- implementation-roadmap.md
|   |-- decisions-log.md
|   |-- open-questions.md
|
|-- 01-privacy-and-governance/
|   |-- data-boundaries.md
|   |-- soppa-review-checklist.md
|   |-- codename-policy.md
|   |-- data-retention.md
|   |-- approved-tools.md
|   |-- human-review-policy.md
|   |-- academic-integrity-policy.md
|
|-- 02-authoring-system/
|   |-- authoring-workflow.md
|   |-- lesson-quality-standards.md
|   |-- accessibility-standards.md
|   |-- content-style-guide.md
|   |-- lesson-schema.md
|   |-- exercise-schema.md
|   |-- rubric-schema.md
|   |-- misconception-schema.md
|   |-- feedback-schema.md
|   |
|   |-- templates/
|       |-- lesson-template.yaml
|       |-- exercise-template.yaml
|       |-- rubric-template.yaml
|       |-- misconception-template.yaml
|       |-- feedback-template.yaml
|
|-- 03-student-course-template/
|   |-- README-FIRST.html
|   |-- HOW-TO-USE-VSCODE.html
|   |-- HOW-TO-SAVE-YOUR-WORK.html
|   |-- HOW-TO-SUBMIT.html
|   |-- BACKUP-YOUR-WORK.html
|   |-- WHEN-YOU-ARE-STUCK.html
|   |-- READY-FOR-A-CHALLENGE.html
|   |
|   |-- images/
|   |-- shared-support/
|   |-- notes/
|   |
|   |-- lessons/
|       |-- lesson_00_01_course_orientation/
|       |-- lesson_00_02_opening_vscode/
|       |-- lesson_00_03_running_python/
|       |-- lesson_00_04_debugging_is_learning/
|       |-- lesson_01_01_first_python_output/
|
|-- 04-teacher-kit/
|   |-- teacher-guide.md
|   |-- grading-guide.md
|   |-- feedback-review-guide.md
|   |-- similarity-review-guide.md
|   |-- student-conference-guide.md
|   |-- small-group-guide.md
|   |
|   |-- lesson-guides/
|   |-- answer-guidance/
|   |-- rubrics/
|   |-- sample-responses/
|   |-- misconception-guides/
|   |-- reassessment-guides/
|   |-- extension-guides/
|
|-- 05-grader/
|   |-- README.md
|   |-- requirements.md
|   |-- grader-workflow.md
|   |-- confidence-rules.md
|   |-- human-review-rules.md
|   |
|   |-- config/
|   |-- prompts/
|   |-- schemas/
|   |-- validators/
|   |-- runners/
|   |-- tests/
|   |-- similarity/
|   |-- reporting/
|   |-- output-examples/
|
|-- 06-data-and-spreadsheets/
|   |-- dashboard-schema.md
|   |-- roster-schema.md
|   |-- grading-export-schema.md
|   |-- misconception-codes.md
|   |-- small-group-rules.md
|   |-- communication-workflow.md
|   |
|   |-- templates/
|   |   |-- roster-template.xlsx
|   |   |-- grading-dashboard-template.xlsx
|   |   |-- misconception-template.xlsx
|   |
|   |-- apps-script/
|       |-- README.md
|       |-- generate-student-drafts.gs
|       |-- generate-guardian-drafts.gs
|       |-- generate-html-reports.gs
|       |-- approval-controls.gs
|
|-- 07-feedback-system/
|   |-- feedback-principles.md
|   |-- student-feedback-template.md
|   |-- guardian-update-template.md
|   |-- reassessment-template.md
|   |-- extension-template.md
|   |
|   |-- html/
|       |-- student-feedback-report.html
|       |-- rubric-breakdown.html
|       |-- misconception-review.html
|
|-- 08-review-site/
|   |-- site-map.md
|   |-- publishing-workflow.md
|   |-- misconception-index.md
|   |-- syntax-reference.md
|   |-- debugging-reference.md
|   |
|   |-- pages/
|       |-- variables/
|       |-- data-types/
|       |-- conditionals/
|       |-- loops/
|       |-- functions/
|
|-- 09-codename-system/
|   |-- codename-rules.md
|   |-- codename-generation.md
|   |-- multi-section-rules.md
|   |-- student-instructions.md
|   |-- roster-mapping-schema.md
|   |
|   |-- tools/
|       |-- generate-codenames.py
|
|-- 10-pilot/
    |-- pilot-plan.md
    |-- pilot-success-criteria.md
    |-- teacher-observation-log.md
    |-- student-feedback-survey.md
    |-- grader-evaluation.md
    |-- revision-log.md
    |
    |-- sample-unit/
    |-- sample-submissions/
    |-- expected-grader-output/
```

---

## 5. Student Experience
### 5.1 Course-Home Workflow

The course platform should provide:

- Lesson navigation
- Lesson introductions
- Objectives
- Embedded visuals
- Downloadable folders
- Submission instructions
- Reflection prompts
- Approved feedback
- Approved scores
- Progress information

Moodle is a likely initial platform, but the curriculum should remain portable.

### 5.2 VS Code Workflow

Students should:

- Open VS Code.
- Open the assigned lesson folder.
- Use the Explorer panel to locate files.
- Read the start-here instructions.
- Open the required Python file.
- Edit the code.
- Use the visible Run control.
- Review the output or error.
- Save the file.
- Complete the remaining practice.
- Complete the reflection.
- Back up the folder.
- Submit the full codename folder.
### 5.3 Student Lesson-Folder Example
```text
- lesson_01_01_first_python_output/
|
|-- START-HERE.html
|-- OBJECTIVES.html
|-- SUBMISSION-CHECKLIST.html
|
|-- instruction/
|   |-- 01_what_is_output.html
|   |-- 02_using_print.html
|   |-- 03_common_errors.html
|
|-- examples/
|   |-- example_01.py
|   |-- example_02.py
|
|-- practice/
|   |-- reinforce/
|   |   |-- practice_01.py
|   |   |-- practice_02.py
|   |
|   |-- core/
|   |   |-- practice_01.py
|   |   |-- practice_02.py
|   |   |-- practice_03.py
|   |
|   |-- extend/
|       |-- challenge_01.py
|
|-- project/
|   |-- codename_message.py
|
|-- support/
|   |-- WHEN-YOU-ARE-STUCK.html
|   |-- CHECK-YOUR-QUOTES.html
|   |-- FIND-THE-RUN-BUTTON.html
|
|-- reflection/
|   |-- reflection.txt
|
|-- notes/
|   |-- my_notes.txt
|
|-- images/
    |-- vscode-run-button.png
    |-- print-function-diagram.png
```
### 5.4 Student Python-File Style
```python
# Practice 1: Displaying a message
#
# Goal:
# Use print() to display a message.
#
# Instructions:
# 1. Replace the text inside the quotation marks.
# 2. Save the file.
# 3. Use the Run button in VS Code.
# 4. Check the output.
#
# Need help?
# Open support/WHEN-YOU-ARE-STUCK.html

- print("Replace this message")
```
### 5.5 Local HTML Support
```html
- <details>
- <summary>I am stuck: my code has an error</summary>

- <p>Check whether your opening and closing quotation marks match.</p>

- <pre><code>print("Hello")</code></pre>

- <p>Then save the file and run it again.</p>
- </details>
```

---

## 6. Course Delivery Layer
### 6.1 Moodle Responsibilities

- Moodle may manage:

- Accounts
- Course navigation
- Announcements
- Lesson pages
- Embedded media
- Download links
- Assignment submissions
- Completion tracking
- Approved feedback
- Approved scores
- Reflections
- Basic quizzes
### 6.2 External Repository Responsibilities

- The repository should manage:

- Canonical lesson content
- Python files
- Local HTML
- Rubrics
- Points
- XP
- Answer guidance
- Test cases
- Misconception codes
- Practice variants
- Grader prompts
- Spreadsheet schemas
- Feedback templates
### 6.3 Google Site Responsibilities

- A Google Site may provide shared, nonprivate resources:

- Common misconceptions
- Syntax references
- Debugging support
- Review material
- Reassessment preparation
- Extension opportunities
- Worked examples

Student-specific feedback should not be published on a shared site.

---

## 7. Codename System
### 7.1 Goals

- The codename system should:

- Remove names from external grading workflows
- Preserve stable student identifiers
- Work across assignments
- Work across class sections
- Follow roster order
- Avoid revealing personal information
### 7.2 Example Format
```text
- PY1-A-ALPHA01
- PY1-A-ALPHA02
- PY1-A-ALPHA03
```

- Possible components:

- PY1: Course
- A: Class section
- ALPHA01: Alphabetized roster position
### 7.3 Private Roster Fields
```text
- codename
- student_name
- student_email
- guardian_email
- class_section
- school_student_id
- active_status
```

Only the codename should be included in external AI-assisted grading.

### 7.4 Student Naming Rules

- Students should:

- Name their main folder with the codename.
- Use the assigned filenames.
- Avoid putting their real name in comments.
- Avoid personal information in reflections.
- Submit the complete folder.
- Confirm the folder name before submission.

---

## 8. Grading Philosophy

The grader should answer:

- What evidence of learning exists?
- What works correctly?
- What does not work?
- Which concept is demonstrated?
- Which concept is missing?
- What score does the rubric support?
- How confident is that recommendation?
- What should the student do next?
- Does a teacher need to inspect this result?

The grader should not answer only:

- Does this file exactly match the answer key?

---

## 9. Grading Pipeline


1. Discover student folders


2. Validate folder names


3. Validate required files


4. Detect missing or unreadable files


5. Read assignment configuration


6. Run Python files safely


7. Capture output


8. Capture syntax and runtime errors


9. Run visible test cases


10. Run hidden test cases


11. Perform static analysis


12. Check required concept use


13. Evaluate reflections


14. Apply rubric criteria


15. Recommend points


16. Recommend XP


17. Generate evidence summary


18. Generate student feedback draft


19. Assign misconception codes


20. Recommend remediation


21. Recommend reassessment or extension


22. Recommend next level and lane


23. Record grading confidence


24. Flag human-review cases


25. Run classwide similarity analysis


26. Run proficiency-consistency analysis


27. Export XLSX


28. Await teacher approval


## 10. Code Assessment Methods
### 10.1 File Checks
- Required files exist
- Files are named correctly
- Files are readable
- Folder structure is intact
### 10.2 Execution Checks
- Program runs
- Program exits normally
- Program does not hang
- Output is captured
- Errors are classified
### 10.3 Behavioral Tests
- Expected output
- Multiple inputs
- Edge cases
- Invalid inputs when appropriate
- Required state changes
- Required calculations
### 10.4 Static Analysis
- Required concept appears
- Variables are used meaningfully
- Hardcoding is identified
- Functions are defined and called
- Loops update correctly
- Conditions are structured appropriately
### 10.5 Rubric Reasoning
- Correctness
- Concept understanding
- Completeness
- Organization
- Explanation
- Reflection
- Revision quality
### 10.6 Human-Review Triggers
- Ambiguous but potentially valid solution
- Unexpected advanced approach
- Unsafe or unexecutable code
- Missing evidence
- Conflicting test and rubric results
- Very low grading confidence
- Similarity concerns
- Proficiency inconsistency
- Possible assignment misunderstanding

---

## 11. Points and Rubrics
### 11.1 Sample Point Structure
| Criterion | Points |
|---|---|
| Required files submitted | 1 |
| Program runs | 2 |
| Required behavior is correct | 4 |
| Target concept is demonstrated | 4 |
| Code is readable and organized | 2 |
| Reflection demonstrates understanding | 2 |
| Total | 15 |
### 11.2 Sample Rubric
Target Concept
Points	Description
4	Demonstrates the target concept accurately and completely.
3	Demonstrates the concept with a small error or missed case.
2	Demonstrates partial understanding but needs significant revision.
1	Attempts the concept but does not yet demonstrate functional understanding.
0	No relevant attempt or insufficient evidence.
Required Behavior
Points	Description
4	Produces correct behavior across all required tests.
3	Produces mostly correct behavior with one limited issue.
2	Produces partially correct behavior.
1	Runs but does not meet most requirements.
0	Does not run or contains no meaningful attempt.
### 11.3 Evidence-First Output
```text
Recommended score: 11/15
Confidence: High

Evidence:
- All required files were submitted.
- The program ran without syntax errors.
- Three of four hidden tests passed.
- The student used a conditional correctly.
- The final condition misses one boundary case.
- The reflection accurately explains the main idea.

Recommended revision:
Update the final comparison and rerun the boundary test.
```

---

## 12. XP System
### 12.1 XP Purpose

XP recognizes productive learning behaviors that may not belong in the academic score.

### 12.2 XP Examples
| Action | XP |
|---|---|
| Complete reflection | 10 |
| Revise after feedback | 15 |
| Complete reassessment | 15 |
| Document debugging process | 10 |
| Complete optional challenge | 20 |
| Explain alternate solution | 15 |
| Complete additional practice | 10 |
| Submit thoughtful notes | 5 |
### 12.3 XP Rules
- XP should not replace grades.
- XP should usually not be deducted.
- XP should reward authentic participation.
- XP should not reward empty completion.
- XP should be visible separately from academic points.

---

## 13. Adaptive Levels and Lanes
### 13.1 Levels
- Starter
- Skilled
- Legendary
- Mythic
### 13.2 Lanes
- Reinforce
- Core
- Extend
### 13.3 Example Assignment Record
```yaml
codename: PY1-A-ALPHA07
lesson_id: lesson_02_03_string_operations
assigned_level: skilled
assigned_lane: core
practice_set: set_b
required_revision: false
required_reassessment: false
optional_support: skilled_reinforce_set_a
optional_challenge: skilled_extend_set_a
```
### 13.4 Progress Statuses
- Not Started
- Attempted
- Needs Support
- Ready to Revise
- Ready to Reassess
- Mastered
- Ready to Extend
### 13.5 Instructional Policy

A student may complete lower-level work when needed.

The student should not be punished for using an appropriate support level.

The score should reflect what the student demonstrated.

A genuine attempt is still required.

---

## 14. Practice-Set Architecture
```text
practice/
|
|-- reinforce/
|   |-- set-a/
|   |-- set-b/
|
|-- core/
|   |-- set-a/
|   |-- set-b/
|   |-- set-c/
|
|-- extend/
    |-- set-a/
    |-- set-b/

Initial implementation:

- Most students receive the same Core set.
- Reinforce and Extend are optional or teacher-assigned.
- Individualized sets are introduced gradually.

Future assignment logic may consider:

- Mastery
- Misconceptions
- Prior attempts
- Readiness
- Need for fresh reassessment
- Need to reduce answer sharing
- Teacher-selected goals
```

---

## 15. Similarity Analysis
### 15.1 Purpose

The similarity system identifies submissions that may need teacher review.

It does not determine guilt.

### 15.2 Comparison Signals
- Identical code
- Near-identical structure
- Matching unusual variable names
- Matching comments
- Matching spelling mistakes
- Matching incorrect logic
- Matching formatting
- Matching blank-line patterns
- Matching reflections
- Matching unnecessary code
- Superficial renaming
### 15.3 Expected Similarities to Exclude
- Starter code
- Required text
- Required variable names
- Teacher examples
- Common beginner patterns
- Very short programs
- Shared instructions
### 15.4 Sample Report
```text
Review suggested:
PY1-A-ALPHA04
PY1-A-ALPHA17

Similarity score: 93%

Notable evidence:
- Same unusual variable name
- Same incorrect comparison
- Identical comment with the same typo
- Same blank-line structure
- Only one displayed value differs

Interpretation:
This is a review flag, not proof of copying.
Compare submission history and conduct a brief student conference.
```

---

## 16. Proficiency-Consistency Review

Possible signals:

- Sudden complexity increase
- Unintroduced libraries
- Advanced abstractions
- Major style changes
- Professional comments inconsistent with prior work
- Reflection style inconsistent with prior work
- Code from recognizable online examples
- Student cannot explain the code
- Complexity inconsistent with prior demonstrated proficiency

Sample output:

```text
Human review suggested.

This submission differs significantly from the student's previous
demonstrated work.

Evidence:
- Uses list comprehensions before instruction
- Introduces exception handling not required by the task
- Naming style differs from the previous six submissions
- Reflection does not explain the advanced approach

Recommended action:
Ask the student to explain and modify one section of the code.
```

This is not an AI-use verdict.

---

## 17. Student Ownership Conference

Suggested questions:

- What does this section do?
- What output do you predict?
- Why did you choose this variable?
- Change this requirement.
- Fix this small bug.
- Show another way to solve it.
- Explain what would happen with a different input.

A short conference is stronger evidence than an automated AI detector.

---

## 18. Spreadsheet Architecture
### 18.1 Private Roster Sheet
```text
codename
student_name
student_email
guardian_email
class_section
active_status
```
### 18.2 Assignment Results Sheet
```text
codename
assignment_id
lesson_id
submission_status
files_found
files_missing
execution_status
test_pass_count
test_fail_count
rubric_score
academic_points
possible_points
xp_earned
mastery_status
revision_required
reassessment_required
misconception_codes
strengths
errors
recommended_support
recommended_challenge
assigned_level
assigned_lane
next_assignment
small_group
similarity_flag
proficiency_flag
grader_confidence
human_review_reason
student_feedback_draft
guardian_update_draft
teacher_notes
score_approved
feedback_approved
release_status
```
### 18.3 Dashboard Views
- Students behind
- Students ready to reassess
- Students ready to extend
- Missing submissions
- Low-confidence grades
- Similarity flags
- Misconception groups
- Current levels
- Current lanes
- Pending feedback approval
- Approved feedback
- Guardian updates available

---

## 19. Feedback Workflow
```text
AI drafts feedback
        |
Teacher reviews
        |
        |-- Approve
        |-- Edit
        |-- Return for regrading
        |-- Hold
        |
Approved student email or HTML report
        |
Student revises, reassesses, or continues
```
### 19.1 Student Feedback Structure
```text
What you demonstrated
What is working
What needs revision
Your rubric results
Your academic points
Your XP
Your misconception resource
Your required next step
Your assigned level and lane
Optional challenge
```
### 19.2 Guardian Communication

Guardian updates are:

- Optional
- Teacher-selected
- Separately generated
- Never automatically sent
- Used for meaningful progress communication

Possible reasons:

- Student is behind
- Student needs encouragement
- Revision support is needed
- Student is exceeding expectations
- Positive progress should be recognized

---

## 20. Misconception Taxonomy

Example codes:

| Code | Description |
|---|---|
| ENV-01 | Student cannot locate or run the correct file |
| SYN-01 | Unmatched quotation marks |
| SYN-02 | Missing parenthesis |
| VAR-01 | Variable used before assignment |
| VAR-02 | Variable value overwritten unexpectedly |
| TYPE-01 | Incorrect data type |
| TYPE-02 | String and integer combined incorrectly |
| COND-01 | Incorrect comparison operator |
| COND-02 | Boundary case missed |
| COND-03 | Conditions ordered incorrectly |
| LOOP-01 | Incorrect loop range |
| LOOP-02 | Loop variable never updates |
| FUNC-01 | Function defined but never called |
| FUNC-02 | Incorrect parameter or argument use |
| INPUT-01 | Input not stored |
| INPUT-02 | Input not converted |

Each code should connect to:

- Feedback language
- Review resource
- Reassessment activity
- Teacher small-group guidance

---

## 21. Authoring Schema

Example canonical lesson record:

```yaml
lesson_id: lesson_01_01_first_python_output
module_id: module_01
lesson_number: "01.01"
title: First Python Output

overview: >
  Students learn how Python displays information and use print()
  to create their first output.

objectives:
  - Use print() to display text.
  - Identify a string literal.
  - Run a Python file using VS Code.
  - Correct common print syntax errors.

prerequisites:
  - Open a folder in VS Code.
  - Locate a file in the Explorer panel.
  - Save a file.

vocabulary:
  - output
  - print
  - string
  - syntax

instruction:
  introduction: content/introduction.md
  examples:
    - examples/example_01.py
    - examples/example_02.py
  visuals:
    - images/print-function-diagram.png
  common_errors:
    - SYN-01
    - SYN-02

practice:
  reinforce:
    - practice/reinforce/set-a
  core:
    - practice/core/set-a
    - practice/core/set-b
  extend:
    - practice/extend/set-a

reflection:
  prompts:
    - Explain what print() does.
    - Describe one error you fixed.

grading:
  total_points: 15
  rubric: rubrics/lesson_01_01.yaml
  tests: tests/lesson_01_01_tests.yaml
  human_review_rules: config/review_rules.yaml

xp:
  reflection: 10
  revision: 15
  challenge: 20

feedback:
  template: feedback/lesson_01_01.md

next_steps:
  mastery: lesson_01_02_strings_and_messages
  reinforce: lesson_01_01_reinforce
  reassess: lesson_01_01_reassessment
  extend: lesson_01_01_extension
```

---

## 22. Authoring Workflow
1. Confirm the lesson ID.
2. Confirm the module and lesson sequence.
3. Confirm the lesson title.
4. Confirm the lesson overview.
5. Confirm the programming objectives.
6. Confirm the computational-thinking objectives.
7. Confirm the language objectives.
8. Confirm prerequisites.
9. Confirm vocabulary.
10. Define what mastery looks like.
11. Define what partial understanding looks like.
12. Define what constitutes a meaningful attempt.
13. Define conditions for no score.
14. Define common misconceptions.
15. Define misconception codes.
16. Define rubric criteria.
17. Define point values.
18. Define XP opportunities.
19. Define revision expectations.
20. Define reassessment expectations.
21. Define progression rules.
22. Define Reinforce, Core, and Extend expectations.
23. Define Starter, Skilled, Legendary, and Mythic expectations when applicable.
24. Write the lesson introduction.
25. Write instructional explanations.
26. Create worked examples.
27. Create visual explanations or diagrams.
28. Create prediction questions.
29. Create checks for understanding.
30. Create guided practice.
31. Create independent practice.
32. Create Reinforce practice.
33. Create Core practice.
34. Create Extend practice.
35. Create stuck supports.
36. Create common-error supports.
37. Create challenge materials.
38. Create reflection prompts.
39. Create note-taking prompts.
40. Create submission instructions.
41. Create file-naming instructions.
42. Create a submission checklist.
43. Create visible test cases.
44. Create hidden test cases.
45. Define acceptable alternate approaches.
46. Define approaches that technically work but do not demonstrate the target concept.
47. Create sample full-credit responses.
48. Create sample partial-credit responses.
49. Create sample minimal-attempt responses.
50. Create sample no-score responses.
51. Create answer guidance rather than only one fixed answer.
52. Create rubric-based grading guidance.
53. Create automated grader configuration.
54. Create human-review triggers.
55. Create grading confidence rules.
56. Create feedback templates.
57. Create misconception-specific feedback.
58. Create revision feedback.
59. Create reassessment feedback.
60. Create extension feedback.
61. Create suggested next-level and next-lane rules.
62. Create small-group recommendations.
63. Generate student-facing HTML.
64. Generate student-facing Python files.
65. Generate teacher guides.
66. Generate rubric files.
67. Generate test files.
68. Generate grader configuration.
69. Generate LMS-ready content.
70. Generate spreadsheet-ready records.
71. Validate all filenames.
72. Validate all internal links.
73. Validate all image paths.
74. Validate folder structure.
75. Run accessibility checks.
76. Run spelling and grammar checks.
77. Run code examples.
78. Run visible tests.
79. Run hidden tests.
80. Test alternate valid solutions.
81. Test incomplete solutions.
82. Test common incorrect solutions.
83. Test missing-file behavior.
84. Test malformed-folder behavior.
85. Test the lesson on a school-like machine.
86. Confirm that students can run the work without the command line.
87. Confirm that no package installation is required.
88. Confirm that the lesson works with the available version of Python.
89. Confirm that the lesson works with the available VS Code configuration.
90. Pilot the lesson with students.
91. Observe where students become confused.
92. Record common misconceptions.
93. Review grader accuracy.
94. Review scoring consistency.
95. Review false-positive similarity flags.
96. Review low-confidence grading decisions.
97. Review whether feedback is understandable.
98. Review whether support resources are useful.
99. Revise the lesson.
100. Revise the grader.
101. Revise the authoring pipeline.
102. Record changes in the decisions log.
103. Approve the lesson for broader use.
104. Scale the validated structure to additional lessons.

---

## 23. Lesson Quality Standards

Every lesson should:

- Have a clear purpose.
- State what students will learn.
- State what students should already know.
- Use language appropriate for high-school learners and adults.
- Avoid assuming that all learners identify primarily as students.
- Break complex ideas into manageable steps.
- Avoid unnecessary cognitive overload.
- Include multiple examples.
- Include practice before independent assessment.
- Include meaningful opportunities to make mistakes safely.
- Explain common errors without shame.
- Support multiple valid problem-solving approaches.
- Avoid treating one sample solution as the only correct solution.
- Include a stuck pathway.
- Include an optional challenge pathway.
- Include reflection or explanation opportunities.
- Include explicit success criteria.
- Include accurate grading criteria.
- Include accessibility considerations.
- Include sufficient evidence for automated and human grading.
- Connect misconceptions to specific review resources.
- Clearly explain what students should do next.

---

## 24. First Pilot Unit
### 24.1 Student Topics
1. Course orientation
2. Codename and folder rules
3. Opening a folder in VS Code
4. Using the Explorer panel
5. Opening a Python file
6. Running a file using VS Code
7. Reading output
8. Saving changes
9. Using print()
10. Editing a string
11. Reading a simple syntax error
12. Fixing quotation marks or parentheses
13. Completing a small output project
14. Writing a reflection
15. Completing an optional challenge
### 24.2 Pilot Success Criteria

The pilot is successful when:

- Students can find the correct files.
- Students can run Python without the command line.
- Students understand the folder workflow.
- Students can use support resources.
- Students can submit the correct folder.
- The grader locates each submission.
- The grader runs the code.
- The grader handles multiple valid solutions.
- Rubric recommendations are reasonably consistent.
- Low-confidence work is flagged.
- Similarity reports exclude obvious starter-code matches.
- The XLSX export is usable.
- Teacher review is faster than fully manual grading.
- Feedback is understandable and actionable.
- No scores are released without approval.
- No PII is exposed to external AI tools.

---

## 25. Initial Build Order
1. Create 00-project-overview/system-architecture.md.
2. Create 00-project-overview/project-goals.md.
3. Create 00-project-overview/pilot-scope.md.
4. Create 01-privacy-and-governance/data-boundaries.md.
5. Create 01-privacy-and-governance/codename-policy.md.
6. Create 02-authoring-system/lesson-schema.md.
7. Create 02-authoring-system/authoring-workflow.md.
8. Create 02-authoring-system/lesson-quality-standards.md.
9. Create 03-student-course-template/README-FIRST.html.
10. Create the first sample lesson folder.
11. Create the matching teacher guide.
12. Create the matching rubric.
13. Create visible and hidden automated tests.
14. Create sample student submissions.
15. Create the grader output schema.
16. Create the XLSX dashboard template.
17. Create the student feedback template.
18. Create the similarity-review specification.
19. Create the proficiency-consistency review specification.
20. Create the pilot evaluation plan.
21. Run the complete workflow.
22. Review weaknesses before expanding the curriculum.

---

## 26. Open Decisions

The following decisions still need to be finalized:

- Moodle, Google Classroom, Google Site, or hybrid delivery
- Whether Moodle is district-approved or independently hosted
- Exact codename format
- One growing course folder versus separate assignment folders
- How student folders are distributed
- How folders are submitted
- Whether reflections are completed locally or in Moodle
- Which Python version is installed
- Which VS Code extensions are available
- Whether the visible Run button is reliably configured
- Whether downloaded folders preserve directory structure
- Maximum class size
- Expected grading runtime
- Required spreadsheet columns
- Final rubric scale
- Relationship between points, mastery, and XP
- How levels are assigned
- Whether students can self-select Reinforce work
- How reassessment replaces or supplements earlier scores
- How approved feedback returns to students
- How long grading files and reports are retained
- Which AI tools are approved for codename-based grading
- What data may be used to compare current and prior performance
- What requires a teacher conference
- What similarity threshold creates a review flag

---

## 27. Nonnegotiable Requirements

- Students are not required to use the command line.
- Student work is completed in VS Code.
- External AI tools do not receive student PII.
- Codenames are used in external grading workflows.
- AI does not automatically release grades.
- AI does not automatically release feedback.
- Guardians are not contacted automatically.
- The teacher reviews academic-integrity flags.
- Similarity is not treated as proof.
- AI-detection signals are not treated as proof.
- Valid alternate code solutions must be accepted.
- Rubric decisions must include evidence.
- The system must support human review.
- The system must remain lightweight.
- The system must work on school machines.
- The system must be designed around SOPPA-conscious data handling.
- The curriculum must remain portable beyond one LMS.
- The pilot must validate the complete workflow before full-scale generation.
