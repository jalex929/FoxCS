# Brain Dump: Python Curriculum Authoring, Adaptive Practice, and AI-Assisted Grading System

I am developing an adaptive learning app and a curriculum-development system that I plan to pilot with my students during the school year. I want to test the content directly with students while continuing to refine both the curriculum and the underlying authoring pipeline.

My immediate goal is to review and strengthen the authoring pipeline so that curriculum is consistently written in a clear, accurate, engaging, and instructionally strong way. I also want to confirm that the overall learning flow makes sense before building too much content.

The first major phase should be:

1. Confirm the structure of the curriculum and grading system.
2. Define a strong authoring process.
3. Build a small but complete sample of the curriculum.
4. Organize that sample into a folder and subfolder system.
5. Pilot the sample in my classroom.
6. Learn from the pilot before expanding the system.

## Classroom Environment

Students will begin Python immediately.

They will work in a traditional IDE environment, primarily using VS Code. They will open folders, edit Python files, save their work, and run their code through the visible controls in VS Code.

Students may not be able to use the command line, so the student workflow should not require terminal commands. The course should assume that students are using the IDE interface to run files.

The grading system may use scripts, command-line tools, or automated tests behind the scenes on the teacher side, but students should not need to interact with those systems.

The student experience should be lightweight and work reliably on school computers. It should not require students to:

- Install packages
- Use administrator permissions
- Configure complex environments
- Run command-line commands
- Create external personal accounts
- Use systems that are not approved for student data

Python and VS Code should ideally already be installed and configured on the school machines.

## Student Curriculum Folders

I want students to work from simple, clearly organized folders that they can open directly in VS Code.

The student folders should contain all of the files they need to complete the work. Depending on the lesson, this may include:

- A start-here file
- Learning objectives
- Success criteria
- Instructional HTML pages
- Embedded or local images and diagrams
- Python examples
- Starter code
- Guided practice
- Independent practice
- Reflection questions
- A file for when students are stuck
- A file for students who want an additional challenge
- Common-error support
- Submission instructions
- File-naming instructions
- A self-check or submission checklist
- A place for notes
- Optional extension work

I want the files to be simple and easy to follow. Students should be able to move between the instructional content and their code without becoming confused about which file they are expected to use.

The instructional HTML pages should be engaging, supportive, and information-rich. They may include:

- Visual examples
- Code diagrams
- Expandable hints
- Common misconceptions
- Predictions
- Short checks for understanding
- Guided debugging
- Reflection prompts
- Worked examples
- Optional challenge pathways

The HTML files should be lightweight and should be able to open in a normal browser without requiring a server.

I want students to develop independent research, review, and problem-solving habits. The support materials should help them learn how to get unstuck rather than simply giving them the answer immediately.

## Moodle or Other Learning Platform

I am leaning toward using Moodle as the initial course-delivery platform.

Students may have Moodle accounts created with their codenames. Moodle or another approved learning platform could serve as the course home where students:

- Navigate through lessons
- Read instructional content
- View embedded media
- Download lesson folders
- Complete reflections
- Review expectations
- Submit completed folders
- Receive approved feedback
- View approved grades or progress
- Track completion

Moodle should be treated as a delivery layer rather than the only place where curriculum logic lives.

The canonical curriculum, grading criteria, question sets, answer guidance, and teacher resources should remain in an external curriculum repository or folder structure so that the system can later work with another LMS, Google Classroom, a Google Site, or the adaptive learning application.

The course should not require Moodle-specific functionality in order for the curriculum itself to remain usable.

I may also use a Google Site for shared class resources. The site could address common misconceptions and provide review or extension content. It could contain:

- Syntax references
- Debugging guides
- Common misconception pages
- Worked examples
- Review activities
- Practice opportunities
- Preparation resources
- Revision support
- Challenge resources

The shared site should contain general instructional content, not student-specific grades or private feedback.

## Google Classroom Submission Workflow

I want students to submit their work through Google Classroom or another school-controlled platform.

A possible workflow is:

1. Students receive or download a lesson folder.
2. Students open the folder in VS Code.
3. Students complete the required files.
4. Students save the full folder under their codename.
5. Students submit the folder through Google Classroom.
6. I download the full class submission folder.
7. The downloaded class folder contains one folder for each student codename.
8. I run the class folder through the grading system.
9. The grader creates a structured export.
10. I review the recommended scores and feedback.
11. I approve, revise, or withhold the results.
12. Approved feedback is returned to students.

Students may maintain one growing course folder, individual assignment folders, or a combination of both. This still needs to be finalized.

## Student Codenames and Privacy

I want every student to receive a codename at the beginning of the year.

The codenames should correspond to the alphabetized attendance list and follow the same order. This will allow me to organize student work consistently while keeping names out of external AI systems.

The private teacher-controlled roster will contain the relationship between:

- Codename
- Student name
- Student email
- Class or section
- Guardian email, when appropriate
- Other school-controlled records

The external grader and external AI tools should only receive:

- Codename
- Student work
- Assignment information
- Rubric information
- Prior codename-based performance information, when needed

They should not receive:

- Student names
- Student IDs
- Personal email addresses
- Guardian names
- Guardian email addresses
- Other directly identifying information

Students should be instructed to:

- Name their main folder using their codename.
- Use the required filenames.
- Avoid placing their real name in code comments.
- Avoid putting personal information in project files.
- Check filenames before submission.
- Submit the complete folder rather than isolated files.

The codename format should be consistent across class sections and assignments. It may include course, section, and roster position, such as:

`PY1-A-ALPHA01`

The exact format still needs to be finalized.

The codename map must remain inside the school-controlled environment.

The privacy plan also needs to account for accidental identifying information inside:

- Code comments
- File metadata
- Folder names
- Reflection responses
- Screenshots
- Embedded documents

The system must be lightweight and SOPPA compliant. The specific platform, hosting environment, plugins, retention policies, account requirements, logs, and data-sharing agreements must be reviewed before students use the system.

## Portable Storage and Backups

I want students to build the habit of storing their work on USB drives so they can move between school computers and reduce the risk of losing their files.

USB drives should not be the only copy of student work.

A recommended backup habit is:

1. Save the current working copy on the school computer.
2. Copy the complete codename folder to the USB drive.
3. Confirm that the copied folder opens.
4. Submit or back up the assignment in the school-controlled platform.
5. Safely eject the USB drive.

Students should avoid storing unrelated personal or family files in the same course folder.

## Teacher Master Folder

I want a master teacher folder that includes all of the information needed to teach, assess, and revise each lesson.

The teacher folder should include:

- Teacher lesson guidance
- Learning objectives
- Prerequisite knowledge
- Standards or competency alignment
- Expected student artifacts
- Sample correct responses
- Sample partial responses
- Sample incorrect responses
- Multiple acceptable coding approaches
- Common misconceptions
- Expected beginner variations
- Rubrics
- Point breakdowns
- XP opportunities
- Automated test cases
- Hidden test cases
- Static-analysis guidance
- Manual review guidance
- Conditions for full credit
- Conditions for partial credit
- Conditions for no score
- Conditions requiring human review
- Suggested feedback
- Suggested remediation
- Suggested challenge work
- Suggested reassessment work
- Small-group recommendations
- Misconception codes
- AI grading prompts
- Grader configuration
- Limitations of automated grading

The system should explicitly document what would warrant:

- Full points
- Partial points
- Minimal points
- No score
- A revision opportunity
- A reassessment
- A teacher conference
- An academic-integrity review

## AI-Assisted Grading

I want AI to manage much of the grading process, but I will review everything before it is released to students.

The AI should be able to:

- Inspect submitted files
- Check whether required files are present
- Run Python files
- Test expected behavior
- Use multiple test inputs
- Review code structure
- Apply a rubric
- Recommend point values
- Award or recommend XP
- Identify strengths
- Identify misconceptions
- Draft personalized feedback
- Recommend remediation
- Recommend reassessment
- Recommend extension work
- Flag low-confidence decisions
- Identify work that requires teacher review
- Suggest small-group placement
- Suggest a next level or practice lane

The AI should not:

- Automatically publish grades
- Automatically send student feedback
- Automatically contact guardians
- Make final academic-integrity determinations
- Treat an AI-detection score as proof
- Penalize valid solutions simply because they differ from a sample answer
- Use exact string matching as the primary method of evaluating code

The teacher must have a review buffer between grading and release.

The system should follow this sequence:

1. Student submission
2. Automated file checks
3. Automated execution tests
4. Static or structural analysis
5. AI rubric scoring
6. Feedback drafting
7. Classwide similarity review
8. Proficiency-consistency review
9. Teacher review
10. Teacher approval, revision, or rejection
11. Student release
12. Optional teacher-selected guardian communication

No grade or feedback should be released automatically.

## Robust Code Assessment

A major problem with previous attempts at automation was that valid code was marked incorrect when students solved the problem in a different way.

The new grader must be designed around semantic correctness and evidence of learning rather than exact code matching.

It should consider:

- Whether the program runs
- Whether the required behavior occurs
- Whether output is correct for multiple inputs
- Whether edge cases are handled
- Whether the student used the required concept
- Whether the student demonstrated the intended skill
- Whether the solution is complete
- Whether the student made a meaningful attempt
- Whether errors are syntax, runtime, logic, or conceptual
- Whether the solution is valid but different from the sample
- Whether the code is overly hardcoded
- Whether the student can explain the solution
- Whether the evidence is too ambiguous for automated scoring

The grader should use a combination of:

- Execution tests
- Hidden tests
- Static analysis
- Structural checks
- Rubric-based reasoning
- AI-assisted interpretation
- Human-review flags

A grader result should include evidence, not only a score.

For example:

> The program runs and produces correct results for three tested inputs. The student used two separate `if` statements instead of the requested `if/elif` structure. The output is correct, but the targeted concept is only partially demonstrated.

## Rubrics and Points

The course will use a combination of points and rubrics.

Points should reflect demonstrated academic learning.

A sample assignment structure might include:

| Criterion | Points |
|---|---:|
| Program runs successfully | 2 |
| Required behavior is correct | 4 |
| Target concept is demonstrated | 4 |
| Code is understandable and organized | 2 |
| Reflection demonstrates understanding | 3 |
| Total | 15 |

Each criterion should have explicit rubric language.

For example:

### Target Concept: Conditionals

| Score | Evidence |
|---|---|
| 4 | Uses conditionals accurately and handles all required cases. |
| 3 | Mostly correct, with a minor logical issue or missed case. |
| 2 | Demonstrates partial understanding but needs substantial revision. |
| 1 | Attempts the concept but does not yet demonstrate functional understanding. |
| 0 | No relevant attempt or insufficient evidence. |

The rubrics should make it easier for AI to norm scores consistently while also making teacher review faster.

## XP

I want to include XP as a separate encouragement system.

XP should not replace academic grades.

XP may reward:

- Reflection questions
- Revision after feedback
- Reassessment
- Additional practice
- Use of support resources
- Challenge attempts
- Explanation of alternate solutions
- Debugging documentation
- Persistence
- Independent research
- Helpful note-taking
- Extension work
- Thoughtful self-assessment

A student might earn:

- `11/15 academic points`
- `+30 XP`

XP should generally accumulate rather than be deducted.

Students should not lose academic points merely because they need to work at a lower level. The academic score should reflect what they demonstrated, while XP can recognize meaningful effort, revision, reflection, and persistence.

## Adaptive Levels and Practice Lanes

I want students to be able to engage with work at different levels.

The system may use the existing levels:

- Starter
- Skilled
- Legendary
- Mythic

Each level may contain:

- Reinforce
- Core
- Extend

A student assignment may identify:

- Current lesson
- Assigned level
- Assigned lane
- Required practice set
- Optional support
- Optional challenge
- Revision requirements
- Reassessment requirements
- Next recommended activity

Example:

- Current level: Skilled
- Current lane: Core
- Required next work: Lesson 02.3, Practice Set B
- Optional support: Skilled Reinforce Set
- Optional challenge: Skilled Extend Set

The assigned level describes the current work, not the student as a person.

Students should not be docked simply for completing lower-level work when they need support. They should still be expected to make a genuine attempt.

Completing lower-level work may demonstrate partial progress rather than full mastery, but it should still receive appropriate credit.

Possible progress statuses include:

- Not Started
- Attempted
- Needs Support
- Ready to Revise
- Ready to Reassess
- Mastered
- Ready to Extend

I may eventually assign different students different sets of practice problems.

This could be based on:

- Current mastery
- Prior misconceptions
- Need for repetition
- Readiness for extension
- Need for reassessment
- Need for a fresh problem set
- Need to reduce copying
- Current assigned level
- Teacher judgment

I do not want to introduce fully individualized assignments immediately, but the system should be designed so that differentiated practice can be added later.

## Feedback and Next Steps

Students will likely receive emails containing approved feedback.

The feedback may explain:

- What the student did well
- What needs revision
- What misconception appeared
- What support resource to review
- Whether reassessment is required
- Whether the student may move on
- Which level or lane to complete next
- What optional challenge is available
- How many academic points were earned
- How much XP was earned

The email should not be sent until I approve it.

It may also be useful to generate an HTML feedback report containing:

- Score summary
- Rubric breakdown
- Evidence from the submission
- Strengths
- Revision requirements
- Misconception explanations
- Guided examples
- Review links
- Reassessment instructions
- Challenge opportunities
- Reflection prompts

The email may contain a shorter summary and direct the student to the HTML report.

## Guardian Communication

The system should not automatically email or CC guardians.

Guardian communication should be optional and teacher-selected.

I may choose to send guardian updates when:

- A student is significantly behind
- A student needs encouragement to continue
- A student needs help completing revisions
- A student is doing exceptionally well
- A student is consistently going above and beyond
- A broader progress update would be helpful

The system may generate a guardian-facing draft, but I must decide whether to send it.

Guardian communications should be written separately from student feedback and should avoid exposing unnecessary student data.

## Similarity, Copying, and Academic Integrity

I want the grader to run one large classwide pass that compares submissions.

The system should flag identical or nearly identical work that may indicate:

- Copying from another student
- Shared files
- Minimal renaming
- Copying from an online source
- Copying from an AI system
- Work that does not reflect the student’s demonstrated proficiency

The system should compare:

- Code structure
- Variable names
- Comments
- Spelling errors
- Incorrect logic
- Formatting
- Blank-line patterns
- Function structure
- Reflection responses
- Unusual solutions
- Matching sequences
- Matching hardcoded values

It should discount expected similarities caused by:

- Starter code
- Required output
- Required variable names
- Very short assignments
- Teacher-provided examples
- Standard beginner solutions
- Shared instructions

The system should not declare plagiarism automatically.

It should produce a neutral review flag with evidence.

For example:

> Review suggested for PY1-A-ALPHA04 and PY1-A-ALPHA17.
>
> Similarity: 93%
>
> Evidence:
>
> - Same unusual variable name
> - Same incorrect comparison
> - Identical comments with the same typo
> - Same blank-line structure
> - Only the displayed name differs
>
> This is not proof of copying. Compare submission history and speak with the students before making a determination.

## AI or Online-Source Concerns

The system may flag work that appears inconsistent with the student’s demonstrated proficiency.

Possible signals include:

- Sudden use of advanced concepts
- Professional-quality documentation inconsistent with prior work
- Libraries that were not introduced
- Complex abstractions beyond the assignment
- A major change in naming style
- A major change in formatting style
- A reflection that does not match the student’s normal writing
- Code that solves a recognizable online exercise
- Code the student cannot explain
- Code complexity that is inconsistent with previous submissions

These should be treated as review signals, not proof.

A neutral flag might say:

> This submission differs significantly from the student’s previous demonstrated work and may warrant a brief explanation conference.

A short conference could ask the student to:

- Explain a section of the code
- Predict the output
- Modify one requirement
- Fix a small bug
- Describe an alternate solution
- Explain why a variable or function was used

The conference is a stronger ownership check than an automated AI detector.

## Teacher Dashboard and Spreadsheet

I want to generate a large XLSX file that can be uploaded into Google Sheets based on a template.

The private spreadsheet may contain:

- Codename
- Student name
- Student email
- Guardian email
- Class section
- Assignment ID
- Current lesson
- Assigned level
- Assigned lane
- Assigned practice set
- Submission status
- Files found
- Files missing
- Program execution status
- Automated test results
- Rubric scores
- Academic points
- XP
- Mastery status
- Revision required
- Reassessment required
- Strengths
- Errors
- Misconception codes
- Suggested remediation
- Suggested challenge
- Suggested next lesson
- Suggested next level
- Suggested small group
- Similarity flags
- Proficiency-consistency flags
- AI grading confidence
- Human review reason
- Student feedback draft
- Guardian update draft
- Teacher notes
- Feedback approval status
- Score approval status
- Email draft status
- Email send status
- Communication history

The spreadsheet should help identify:

- Which students are behind
- Which students are ready to move on
- Which students need reassessment
- Which students need extension work
- Which misconceptions are most common
- Which students should be grouped together
- Which assignments need revision
- Which grader results require human review
- Which students are assigned to each level or lane

The system may use Apps Script to:

- Generate student email drafts
- Generate optional guardian update drafts
- Allow the teacher to select specific students
- Populate approved feedback
- Track whether messages were approved
- Track whether messages were sent
- Generate HTML reports
- Create small-group lists

No email should be sent automatically without teacher approval.

## Common Misconceptions and Small Groups

The teacher folder and dashboard should identify general trends that students struggle with.

Each misconception should have a standardized code.

Examples:

- `VAR-01`: Variable used before assignment
- `TYPE-02`: String and integer combined incorrectly
- `COND-03`: Conditions overlap or appear in the wrong order
- `LOOP-02`: Loop control variable never changes
- `FUNC-01`: Function defined but never called
- `INPUT-02`: Input is not converted to the needed type

Misconception codes can connect to:

- Shared Google Site pages
- Moodle resources
- Local HTML support files
- Reassessment activities
- Small-group lesson plans
- Feedback templates

The dashboard should be able to group students by:

- Misconception
- Current level
- Current lane
- Revision need
- Reassessment need
- Missing prerequisite
- Readiness for extension

## Authoring Pipeline

I want one canonical source for each lesson so I do not have to manually maintain completely separate Moodle, HTML, teacher, and grading versions.

A canonical lesson definition might contain:

- Lesson ID
- Title
- Module
- Lesson number
- Overview
- Learning objectives
- Prerequisites
- Vocabulary
- Instructional content
- Examples
- Images
- Common misconceptions
- Guided practice
- Independent practice
- Reinforce questions
- Core questions
- Extend questions
- Starter content
- Skilled content
- Legendary content
- Mythic content
- Reflection prompts
- Challenge prompts
- Rubrics
- Points
- XP
- Automated tests
- Hidden tests
- Feedback templates
- Misconception codes
- Reassessment rules
- Next-step rules

The pipeline could then generate:

- Moodle-ready content
- Student HTML files
- Student Python folders
- Teacher guides
- Rubrics
- Answer guidance
- Grader configuration
- Spreadsheet records
- Feedback templates
- Review-site content

The authoring process should emphasize:

- Accuracy
- Clear objectives
- Strong instructional sequencing
- Appropriate cognitive load
- Multiple valid approaches
- Supportive language
- Accessibility
- Helpful feedback
- Adult and high-school relevance
- Independent problem-solving
- Meaningful practice
- Reflection
- Revision
- Mastery
- Extension

## Pilot Scope

The first pilot should test one complete learning and grading loop.

The student experience should include:

1. Access the lesson through Moodle or another approved platform.
2. Read the lesson introduction.
3. Review the objectives.
4. Download or open the lesson folder.
5. Open the folder in VS Code.
6. Run a provided Python file using the IDE.
7. Complete guided practice.
8. Complete independent practice.
9. Use the stuck resource when needed.
10. Attempt an optional challenge if ready.
11. Complete a reflection.
12. Save and back up the folder.
13. Submit the complete codename folder.

The teacher experience should include:

1. Download the class submissions.
2. Run one local grading workflow.
3. Check required files.
4. Run automated tests.
5. Apply rubrics.
6. Generate recommended points and XP.
7. Generate feedback drafts.
8. Run similarity analysis.
9. Run proficiency-consistency analysis.
10. Export an XLSX report.
11. Review low-confidence results.
12. Edit or approve scores.
13. Edit or approve feedback.
14. Assign next levels or lanes.
15. Return approved feedback.
16. Create optional guardian updates when appropriate.
17. Use misconception trends to form small groups.

The first content sequence may include:

- Course and folder orientation
- Opening a folder in VS Code
- Identifying files in the Explorer panel
- Running a Python file using the Run control
- Reading output
- Saving a file
- Using `print()`
- Editing and rerunning code
- Reading simple error messages
- Fixing a simple error
- Completing a personalized-output project
- Writing a reflection
- Attempting an optional extension

The goal is to validate the complete system before building the full school-year curriculum.