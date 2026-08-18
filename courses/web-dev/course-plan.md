# FoxCS: Web Dev ("Web II"): Course Plan

**Built 2026-08-17.** Source: `../../starter context/Web_Development_Course_Map_Certification_Aligned.md` ("Web Development: Designing & Building Usable Interactive Experiences"), a pre-drafted, certification-aligned course map (Modules 00-21). This file translates that map's category-based design into a concrete `Unit NN / Lesson NN.N` checklist matching `../python/course-plan.md`'s format — the source map is not already numbered that way, it's organized around skill threads (Computational Thinking, UX/Product Thinking, User Research, UI/Interaction Design, Accessibility, Testing/Observation, Technical Best Practices, Communication/Design Rationale) layered across the modules. **Every unit/lesson title below is a direct, verified transcription of the source map's own module tree** (lines 160-507 of that file) — nothing renamed, only reformatted (kebab-case slugs → Title Case, `Module` → `Unit`, folder tree → checklist).

**Terminology note, matching Python's convention:** FoxCS calls these **Units**, not "Modules." "Unit NN" here corresponds 1:1 to "Module NN" in the source map.

**This is a pathway curriculum, not a course-enrollment curriculum.** Per the 2026-08-17 decisions in `../../decisions-log.md` and `../../00-project-overview/shared-unit-00-onboarding.md`: pathway choice is decoupled from course enrollment. This course-plan is the **Web Dev pathway** curriculum — followed by any Level 2 student (Game II or Web II, whichever class period they sit in) who chose Web Dev in the shared Unit 0's 00.8 lesson. A Web II student who instead chose Unity follows `../game-programming-2/course-plan.md` (being built in parallel as of this writing) instead of this file.

**Unit 00 is not here.** Web Dev students see the shared onboarding unit's **Level 2** edition — see `../../00-project-overview/shared-unit-00-onboarding.md`. Unit 01 below is this course's real first unit.

**Legend:** ⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final (all units below are ⬜ — nothing authored yet, this file is the checklist only)

---

## Certification Framing

**Corrected 2026-08-18, per Jay — overrides the source map's own labeling.** The source map states HTML5 Application Development as required and JavaScript as the encouraged second credential. **That's backwards from the real prerequisite structure**: JavaScript certification is a prerequisite for HTML5 Application Development. Per Jay, the actual expectation is:

1. **JavaScript — required/mandatory credential.** Every Web Dev-pathway student is expected to reach this. Deeper fluency with JS syntax, data, functions, decisions, loops, the DOM, events, forms, debugging. Attemptable once a student has finished the JS/DOM/events/arrays/objects/loops/forms sequence (roughly Units 07-15) — this exam-timing detail from the source map is unaffected by the required/encouraged correction, it was already sequenced first.
2. **HTML5 Application Development — encouraged second credential, gated by the JavaScript prerequisite.** Integrates HTML5, CSS3, JavaScript ES6, responsive layout, forms, graphics, events, application state, data access, testing, and the application lifecycle. Per the source map's "Recommended Certification Timing," attempted after the major application-development sequence (Units 05, 07-15 roughly, through Unit 20/21) — that timing was already correct, only the required/encouraged label was backwards. Since it requires the JavaScript credential first, a student who doesn't finish JavaScript in time isn't eligible to attempt this regardless of how much of the unit content she's covered.

**This mirrors Game Design/Unity's required/encouraged structure** (`../game-programming-2/course-plan.md`: Programmer required, Artist achievable-not-guaranteed) — worth applying the same "achievable, not guaranteed, contingent on effective time use" tone to HTML5 App Dev that was confirmed for the Unity Artist credential (`../../decisions-log.md`'s 2026-08-18 entry), since the shape of the two situations is now the same. **Not yet written here** — flagged as a natural follow-up, not assumed done.

Both certifications are "a technical floor, not the ceiling" (source map's own framing) — UX, accessibility, computational thinking, research, usability testing, and authentic project work remain core outcomes regardless of certification pursuit.

**Certification-readiness model (Levels 1-5), reused from the source map, not redesigned here:** Level 1 Learn It Through Development → Level 2 Reinforce It Through Projects and Practice → Level 3 Name the Certification Connection → Level 4 Certification Check → Level 5 Certification Readiness Review. Applies across every unit below; not repeated per-unit.

## Mixed-Experience Model: How "Web I / Web II" Resolves Here

**Proposed resolution, 2026-08-17 — pending Jay's confirmation, not a settled decision.** The source map's own "Mixed-Experience Learning Model" section describes "Web Development I" and "Web Development II" as **entry-point pacing lanes inside one course**, not two separate year-long classes — a Web I student "generally moves through the full progression" while a Web II student "can demonstrate prior HTML/CSS mastery through diagnostics... and move more quickly into JavaScript," but both still work through the same certification objectives and the same non-technical competencies (UX, research, accessibility, usability testing, computational thinking, design rationale, technical best practices — explicitly *not* waived by acceleration). Since FoxCS's own catalog has only one Web Dev/Web II course folder (no separately-authored "Web I"), this course-plan treats that distinction as **an internal pacing lane within this one course-plan**, not a prerequisite course: a short diagnostic/acceleration checkpoint at the end of Unit 01 (or spanning Units 01-04) lets a student with demonstrated prior HTML/CSS mastery move faster through the HTML/CSS-foundation units into Unit 06 onward, while a student new to HTML/CSS takes the fuller pace through the same units. Both lanes converge on the same units, the same lesson numbering, and the same certification targets — this is a pacing difference, not a content fork. **Not yet built**: the actual diagnostic instrument (per the source map's own "Entry Diagnostics and Acceleration Path" item — see Open Items below).

## Pacing Constraint

Per `../../CLAUDE.md`'s Hard Constraints: core/certification-critical content must land before mid-April (AP testing runs mid-to-late April; seniors are typically checked out by mid-May; motivation drops hard once these periods hit). Applied here: **Unit 21's capstone should be at final-presentation stage before mid-April**, with the required JavaScript exam (after Unit 15) and, for students who reach readiness, the encouraged HTML5 Application Development exam (after Unit 20/21) both scheduled ahead of that window, not crammed into it. **Unlike Game I, no confirmed post-AP-testing project activity is identified yet for this course** — Game I has planned MakeCode Arcade work for that stretch (see `../python/course-plan.md`; corrected 2026-08-18: that work is real project-based skills application, not "low-stakes" filler — the fit for that window is about not depending on fresh full-class instruction, not about reduced rigor); this course has no equivalent proposed. Flagged as an open item, not invented here. Exact week-by-week pacing against real dates is blocked on the official CPS academic calendar (see `../../open-questions.md`).

## PHP/Backend — Not In This Plan

Per `../../CLAUDE.md`'s Courses table and `CLAUDE.md`'s scope note: a PHP-or-similar backend is longer-range possible scope for this course but is **deliberately not included as a unit below**, and must not be surfaced to students as a promise until it's actually confirmed. If it happens, it would extend past Unit 21, not replace anything in this sequence.

---

## Unit 01: HTML and Page Structure
*Cert tie-in: foundational — not explicitly cited in the Certification Objective Mapping table on its own, but the underlying markup skill every later HTML5 App Dev objective area (Layouts, Forms, Graphics) depends on.*
*Mixed-Experience checkpoint: the acceleration diagnostic (see above) is anchored here — a student who tests out of 01/02's foundations moves into Unit 03 (CSS) at a faster pace, without skipping the non-technical threads (UX, accessibility, computational thinking) woven through every unit.*
- [ ] 01.1 What HTML Does
- [ ] 01.2 Elements, Tags, and Content
- [ ] 01.3 Document Structure
- [ ] 01.4 Headings and Paragraphs
- [ ] 01.5 Links and Navigation
- [ ] 01.6 Images
- [ ] 01.7 Lists
- [ ] 01.8 Attributes
- [ ] 01.9 Organizing Information for Users
- [ ] 01.10 Reading and Debugging HTML
- [ ] 01 Project: Structured Content Page

## Unit 02: Semantic HTML and Accessibility
*Cert tie-in: foundational — underlies HTML5 App Dev's Layouts and Application Lifecycle objective areas; accessibility itself isn't a named certification objective area but is a course-wide non-negotiable thread (see Threads section below).*
- [ ] 02.1 Structure vs. Appearance
- [ ] 02.2 Why Semantics Matter
- [ ] 02.3 header, nav, main, and footer
- [ ] 02.4 Sections, Articles, and Asides
- [ ] 02.5 Accessible Images
- [ ] 02.6 Accessible Links and Navigation
- [ ] 02.7 Designing for Different Users
- [ ] 02.8 Keyboard and Screen-Reader Thinking
- [ ] 02.9 Reading Page Structure
- [ ] 02 Project: Accessible Information Page

## Unit 03: CSS Foundations
*Cert tie-in: CSS effects and filters (Taught — Units 03, 18).*
- [ ] 03.1 What CSS Does
- [ ] 03.2 Selectors
- [ ] 03.3 Properties and Values
- [ ] 03.4 Colors
- [ ] 03.5 Typography
- [ ] 03.6 Classes and IDs
- [ ] 03.7 Cascade and Specificity
- [ ] 03.8 Visual Hierarchy
- [ ] 03.9 Consistency and Reusable Styles
- [ ] 03.10 Making Interactions Look Interactive
- [ ] 03.11 Visual Effects: Gradients, Shadows, and Transparency
- [ ] 03.12 CSS Filters for Images
- [ ] 03.13 Reading and Debugging CSS
- [ ] 03 Project: Style Your World

## Unit 04: Layout and the Box Model
*Cert tie-in: Content flow, positioning, overflow (Reinforced — Unit 04); Flexbox (Reinforced — Units 04, 05); CSS Grid (Reinforced — Units 04, 05).*
- [ ] 04.1 The Box Model
- [ ] 04.2 Margin, Padding, and Border
- [ ] 04.3 Width, Height, and Sizing
- [ ] 04.4 Display
- [ ] 04.5 Flexbox
- [ ] 04.6 CSS Grid
- [ ] 04.7 Positioning and Content Flow
- [ ] 04.8 Overflow and Visibility
- [ ] 04.9 Alignment, Spacing, and Proximity
- [ ] 04.10 Common Interface Layout Patterns
- [ ] 04.11 Decomposing an Interface
- [ ] 04 Project: Recreate a Layout

## Unit 05: Responsive and Adaptive Design
*Cert tie-in: Responsive design (Reinforced — Units 05, 20, 21); Flexbox (Reinforced — Units 04, 05); CSS Grid (Reinforced — Units 04, 05).*
- [ ] 05.1 Designing for Different Screens
- [ ] 05.2 Relative Units
- [ ] 05.3 Responsive Images: picture and Backgrounds
- [ ] 05.4 The Viewport
- [ ] 05.5 Media Queries
- [ ] 05.6 Responsive Flexbox and Grid
- [ ] 05.7 Mobile-First Thinking
- [ ] 05.8 Content Prioritization
- [ ] 05.9 Touch Targets and Mobile Interaction
- [ ] 05.10 Responsive Navigation
- [ ] 05.11 Testing Responsive Designs
- [ ] 05 Project: Responsive Site

## Unit 06: User Experience, User Research, and Interface Design
*Cert tie-in: none directly named in the Certification Objective Mapping table — this is the course's primary UX/HCD module rather than a certification-objective target itself. It's what makes the certifications "a floor, not the ceiling" real: the course's North Star (understanding a user, designing for them, testing with them) lives here.*
- [ ] 06.1 Who Are We Designing For?
- [ ] 06.2 User Goals, Needs, and Pain Points
- [ ] 06.3 Assumptions vs. Evidence
- [ ] 06.4 Asking Good Research Questions
- [ ] 06.5 Interviews, Surveys, and Observation
- [ ] 06.6 Identifying Patterns in Feedback
- [ ] 06.7 Turning Pain Points into Design Opportunities
- [ ] 06.8 Information Architecture and Hierarchy
- [ ] 06.9 Common Interface Patterns
- [ ] 06.10 Consistency and Predictability
- [ ] 06.11 Affordances and Signifiers
- [ ] 06.12 Feedback and System Status
- [ ] 06.13 Preventing and Recovering from Errors
- [ ] 06.14 Reducing Cognitive Load
- [ ] 06.15 User Flows
- [ ] 06.16 Wireframes and Prototypes
- [ ] 06.17 Introduction to Usability Testing
- [ ] 06.18 Observe, Don't Rescue
- [ ] 06.19 Turning Observations into Findings
- [ ] 06.20 Revising from Evidence
- [ ] 06 Project: Research, Redesign, and Test

## Unit 07: JavaScript and Programming Thinking
*Cert tie-in: heaviest single unit for JS-credential objectives. Debugging/runtime errors/breakpoints (Reinforced — Units 07, 09, 17, 20); JS operators and best practices (Reinforced — Unit 07); Exception handling (Taught — Units 07, 17); BOM basics (Taught — Unit 07); JS primitive data types and conversion (Reinforced — Unit 07); Math functions (Taught — Unit 07/project practice).*
- [ ] 07.1 Why Websites Need JavaScript
- [ ] 07.2 HTML, CSS, and JavaScript Working Together
- [ ] 07.3 Internal vs. External Scripts
- [ ] 07.4 How JavaScript Runs
- [ ] 07.5 Console Output and Breakpoints
- [ ] 07.6 Variables, Constants, and Memory
- [ ] 07.7 Strings
- [ ] 07.8 Numbers
- [ ] 07.9 Booleans, null, and undefined
- [ ] 07.10 Type Checking and Conversion
- [ ] 07.11 Assignment, Arithmetic, and Compound Operators
- [ ] 07.12 Comments, Formatting, and Naming
- [ ] 07.13 Reading JavaScript
- [ ] 07.14 Common JavaScript Errors
- [ ] 07.15 Browser Object Model Basics
- [ ] 07.16 try/catch and Handling Errors
- [ ] 07 Project: Interactive Page Upgrade

## Unit 08: Decisions and Logic
*Cert tie-in: Decisions and logical operators (Reinforced — Unit 08).*
- [ ] 08.1 Making Decisions with Code
- [ ] 08.2 Comparison Operators
- [ ] 08.3 Boolean Logic
- [ ] 08.4 if Statements
- [ ] 08.5 if/else
- [ ] 08.6 else if and switch
- [ ] 08.7 Combining Conditions
- [ ] 08.8 Modeling User Decisions
- [ ] 08.9 Reading Conditional Code
- [ ] 08.10 Designing Predictable Behavior
- [ ] 08 Project: Decision-Based Experience

## Unit 09: Functions and Reusable Behavior
*Cert tie-in: Functions, parameters, returns, scope (Reinforced — Unit 09); Debugging/runtime errors/breakpoints (Reinforced — Units 07, 09, 17, 20).*
- [ ] 09.1 Why Functions Matter
- [ ] 09.2 Defining Functions
- [ ] 09.3 Calling Functions
- [ ] 09.4 Parameters
- [ ] 09.5 Return Values
- [ ] 09.6 Local and Global Scope
- [ ] 09.7 Values, References, and Reusable Data
- [ ] 09.8 Breaking Problems into Functions
- [ ] 09.9 Recognizing Repeated Behavior
- [ ] 09.10 Reusable Interface Behavior
- [ ] 09.11 Reading and Debugging Functions
- [ ] 09 Project: Function Toolkit

## Unit 10: The DOM
*Cert tie-in: DOM tree and manipulation (Reinforced — Unit 10).*
- [ ] 10.1 HTML Becomes the DOM
- [ ] 10.2 Understanding the Document Tree
- [ ] 10.3 Selecting Elements by ID, Class, and Tag
- [ ] 10.4 Reading Content
- [ ] 10.5 Changing Content
- [ ] 10.6 Changing Attributes
- [ ] 10.7 Changing Styles
- [ ] 10.8 Working with Classes
- [ ] 10.9 Creating Elements
- [ ] 10.10 Removing Elements
- [ ] 10.11 Tracing DOM Changes
- [ ] 10.12 Interface State and Visual Feedback
- [ ] 10 Project: Page Transformer

## Unit 11: Events and Interaction
*Cert tie-in: Event listeners/handlers and bubbling (Reinforced — Unit 11); DOM/form/keyboard/mouse events (Reinforced — Unit 11).*
- [ ] 11.1 Event-Driven Programming
- [ ] 11.2 Click Events
- [ ] 11.3 Event Listeners
- [ ] 11.4 Input Events
- [ ] 11.5 Keyboard Events
- [ ] 11.6 Event Objects
- [ ] 11.7 Mouse, Focus, and Form Events
- [ ] 11.8 Event Bubbling Basics
- [ ] 11.9 Connecting Actions to Behavior
- [ ] 11.10 Hover, Focus, Active, and Disabled States
- [ ] 11.11 Immediate and Delayed Feedback
- [ ] 11.12 Making Interactions Discoverable
- [ ] 11.13 Keyboard-Accessible Interactions
- [ ] 11 Project: Interactive Widget

## Unit 12: Arrays and Collections
*Cert tie-in: Arrays and array operations (Reinforced — Unit 12).*
- [ ] 12.1 Why Collections Matter
- [ ] 12.2 Creating Arrays
- [ ] 12.3 Accessing Items
- [ ] 12.4 Updating Items
- [ ] 12.5 Adding and Removing Items
- [ ] 12.6 push, pop, shift, and unshift
- [ ] 12.7 Sorting and Searching Arrays
- [ ] 12.8 Multidimensional Arrays as a Stretch Skill
- [ ] 12.9 Looping Through Arrays
- [ ] 12.10 Recognizing Patterns in Data
- [ ] 12.11 Rendering Arrays to the Page
- [ ] 12.12 Designing Repeated Interface Components
- [ ] 12 Project: Dynamic Gallery or List

## Unit 13: Objects and Modeling Data
*Cert tie-in: JavaScript classes (Taught — Unit 13/targeted certification extension); Objects and Date (Reinforced — Unit 13).*
- [ ] 13.1 What Objects Represent
- [ ] 13.2 Properties and Values
- [ ] 13.3 Accessing Object Data
- [ ] 13.4 Updating Objects
- [ ] 13.5 Creating and Using Objects
- [ ] 13.6 Date and Time with JavaScript
- [ ] 13.7 Arrays of Objects
- [ ] 13.8 Modeling Real-World Information
- [ ] 13.9 Separating Content from Presentation
- [ ] 13.10 Rendering Structured Data
- [ ] 13.11 Designing Data-Driven Components
- [ ] 13 Project: Data-Driven Interface

## Unit 14: Loops and Repeated Behavior
*Cert tie-in: Loops and loop control (Reinforced — Unit 14).*
- [ ] 14.1 Why Loops Matter
- [ ] 14.2 for Loops
- [ ] 14.3 while and do-while Loops
- [ ] 14.4 for-in and Loop Control
- [ ] 14.5 Looping Through Arrays
- [ ] 14.6 Building Elements with Loops
- [ ] 14.7 Recognizing Repeated Patterns
- [ ] 14.8 Avoiding Unnecessary Repetition
- [ ] 14.9 Debugging Loops
- [ ] 14 Project: Generated Interface

## Unit 15: Forms and User Input
*Cert tie-in: last core JS-credential-heavy unit before the JavaScript exam becomes attemptable. HTML forms and specialized form elements (Reinforced — Unit 15); HTML/form validation (Reinforced — Unit 15); Form input and JS validation (Reinforced — Unit 15); Form submission and GET/POST (Taught — Unit 15). Per the source map's Recommended Certification Timing, a student who's completed Units 07-15 (JS, DOM, events, arrays, objects, loops, forms) is a candidate for a JavaScript-credential readiness check.*
- [ ] 15.1 How Web Forms Work
- [ ] 15.2 Input Types and Form Structure
- [ ] 15.3 fieldset, legend, datalist, meter, and output
- [ ] 15.4 Labels and Accessibility
- [ ] 15.5 Reading and Updating Form Values
- [ ] 15.6 Form Events and Submission
- [ ] 15.7 GET vs. POST, Conceptually
- [ ] 15.8 HTML Validation Attributes
- [ ] 15.9 JavaScript Input Validation
- [ ] 15.10 Pattern Validation and Regular Expression Basics
- [ ] 15.11 Preventing User Errors
- [ ] 15.12 Writing Helpful Error Messages
- [ ] 15.13 Success Confirmation and Feedback
- [ ] 15.14 Preserving User Progress
- [ ] 15.15 Testing a Form with Users
- [ ] 15 Project: Interactive Form

## Unit 16: State and Persistence
*Cert tie-in: Local/session/application state (Reinforced — Units 16, 20).*
- [ ] 16.1 What Is State?
- [ ] 16.2 Tracking Changing Information
- [ ] 16.3 Interface State
- [ ] 16.4 Selected, Open, Disabled, and Completed
- [ ] 16.5 Local vs. Session Storage
- [ ] 16.6 Saving Data
- [ ] 16.7 Loading Data
- [ ] 16.8 Designing Persistent Experiences
- [ ] 16.9 Empty, Default, and Returning-User States
- [ ] 16 Project: Persistent Web App

## Unit 17: Debugging, Testing, and Quality
*Cert tie-in: Application lifecycle (Reinforced — Units 17, 20, 21); Debugging/runtime errors/breakpoints (Reinforced — Units 07, 09, 17, 20); Exception handling (Taught — Units 07, 17).*
- [ ] 17.1 Debugging HTML
- [ ] 17.2 Debugging CSS
- [ ] 17.3 Debugging JavaScript
- [ ] 17.4 Browser Developer Tools
- [ ] 17.5 Reading Console and Runtime Errors
- [ ] 17.6 Breakpoints and Step-by-Step Debugging
- [ ] 17.7 Expected vs. Actual Behavior
- [ ] 17.8 Test Cases
- [ ] 17.9 Edge Cases
- [ ] 17.10 Testing User Interactions
- [ ] 17.11 Accessibility Testing
- [ ] 17.12 Usability vs. Functionality
- [ ] 17.13 Observing Users Without Leading Them
- [ ] 17.14 Prioritizing Usability Problems
- [ ] 17 Project: Debug, Test, and Improve

## Unit 18: Graphics, Animation, and Rich Web Experiences
*Cert tie-in: Canvas (Taught — Unit 18); SVG (Taught — Unit 18); CSS effects and filters (Taught — Units 03, 18); CSS transforms/transitions/keyframes (Taught — Unit 18).*
- [ ] 18.1 CSS Transitions and Keyframe Animation
- [ ] 18.2 2D Transforms: translate, scale, rotate, and skew
- [ ] 18.3 3D Transform and Perspective Basics
- [ ] 18.4 Canvas Basics: Shapes, Color, and Lines
- [ ] 18.5 Moving, Rotating, and Scaling Canvas Graphics
- [ ] 18.6 Making Canvas Interactive
- [ ] 18.7 SVG Basics and When to Use SVG
- [ ] 18.8 Inline vs. Referenced SVG
- [ ] 18.9 SVG Shapes, Color, and Filter Effects
- [ ] 18.10 Animation Accessibility and Reduced Motion
- [ ] 18 Project: Interactive Visual Experience

## Unit 19: Working with External Data
*Cert tie-in: Data access, JSON, XML overview (Taught — Unit 19); JavaScript/browser APIs (Taught — Unit 19).*
- [ ] 19.1 Static vs. Dynamic Data
- [ ] 19.2 JSON and Complex Objects
- [ ] 19.3 Sending, Receiving, and Parsing Data
- [ ] 19.4 What Is an API?
- [ ] 19.5 fetch
- [ ] 19.6 When Code Has to Wait
- [ ] 19.7 Reading API Data
- [ ] 19.8 Displaying External Data
- [ ] 19.9 Loading and Saving Files, Conceptually
- [ ] 19.10 XML and Other Data Formats Overview
- [ ] 19.11 Using Browser APIs
- [ ] 19.12 Geolocation and Privacy
- [ ] 19.13 Loading States
- [ ] 19.14 Error States
- [ ] 19.15 Empty States
- [ ] 19.16 Designing for Uncertain Data
- [ ] 19 Project: Data-Powered App

## Unit 20: Building and Sharing Complete Web Applications
*Cert tie-in: Application lifecycle (Reinforced — Units 17, 20, 21); Debugging/runtime errors/breakpoints (Reinforced — Units 07, 09, 17, 20); Responsive design (Reinforced — Units 05, 20, 21); Local/session/application state (Reinforced — Units 16, 20). This is where the HTML5 Application Development credential's full application-lifecycle objective area comes together — the source map's Recommended Certification Timing places the required exam after this unit.*
- [ ] 20.1 From Feature to Application
- [ ] 20.2 Identifying the User and Goal
- [ ] 20.3 Mapping the User Flow
- [ ] 20.4 Planning Interface and Behavior
- [ ] 20.5 Organizing Project Files
- [ ] 20.6 Separating HTML, CSS, and JavaScript
- [ ] 20.7 Breaking Features into Functions
- [ ] 20.8 Managing Application and Session State
- [ ] 20.9 Designing Feedback and Error States
- [ ] 20.10 Version History and Basic Version Control
- [ ] 20.11 Testing the User Flow
- [ ] 20.12 Refactoring
- [ ] 20.13 Usability, Accessibility, and Polish
- [ ] 20.14 Attribution, Privacy, and Responsible Publishing
- [ ] 20.15 Deploying and Sharing a Web Project
- [ ] 20 Project: Complete Web Application

## Unit 21: Capstone — Product Design and Development
*Cert tie-in: Application lifecycle (Reinforced — Units 17, 20, 21); Responsive design (Reinforced — Units 05, 20, 21). Full-year synthesis unit — this is where the required HTML5 Application Development exam is recommended to land (per the source map, after "the major application-development sequence" this unit represents the end of).*
*Design/reflection tie-in: 21.20 (Presentation and Design Rationale) and 21.21 (Reflection) are this course's own capstone reflective-writing moments — its version of "explain your decisions," matching the Communication and Design Rationale thread. Whether this becomes the same cross-course journal thread Game I already has, or its own separate thing, isn't decided — see Open Items.*
*Pacing target: per the constraint above, aim to have this unit at final-presentation stage before mid-April.*
- [ ] 21.1 Identifying a User or Community
- [ ] 21.2 Exploring a Problem Space
- [ ] 21.3 Planning Lightweight User Research
- [ ] 21.4 Interviewing and Observing Users
- [ ] 21.5 Identifying Needs and Pain Points
- [ ] 21.6 Defining the Problem
- [ ] 21.7 Generating Possible Solutions
- [ ] 21.8 Defining Requirements and Success Criteria
- [ ] 21.9 Feature Scoping and Prioritization
- [ ] 21.10 User Flows and Information Architecture
- [ ] 21.11 Wireframing and Prototyping
- [ ] 21.12 Building V1
- [ ] 21.13 Functional Testing and Debugging
- [ ] 21.14 Usability Testing: Observe, Don't Rescue
- [ ] 21.15 Analyzing Observations and Feedback
- [ ] 21.16 Prioritizing Revisions
- [ ] 21.17 Building V2
- [ ] 21.18 Accessibility and Quality Review
- [ ] 21.19 Publishing and Sharing
- [ ] 21.20 Presentation and Design Rationale
- [ ] 21.21 Reflection
- [ ] 21 Final Product

---

## Threads Woven Through Every Unit (not a separate unit — reused directly from the source map)

The source map specifies these as recurring, not one-time-taught: **Computational Thinking** (decomposition, pattern recognition, abstraction, algorithmic thinking, debugging/revision, evaluating solutions, iteration, transfer, independent problem solving — recurring question: *"How can I break this problem or interface into smaller parts I understand?"*), **UX and Product Thinking** (recurring question: *"Can another person understand and successfully use what I built?"*), **User Research** (distinct from usability testing — research asks "what problems/needs should we understand," testing asks "can people use what we designed"), **UI and Interaction Design** (a fixed set of interface patterns — navigation, cards, forms, menus, modals, etc. — analyzed for *when* a pattern is appropriate, not just how to code it), **Accessibility** (part of quality from the beginning, not a single unit), **Testing and Observation** (including the "Observe, Don't Rescue" usability-test protocol, used explicitly in Units 06, 17, and 21), **Technical Best Practices** (naming, formatting, version control, attribution, privacy, responsible AI use, deployment), and **Communication and Design Rationale** (explaining what was built, for whom, why, and what changed). Don't re-derive these per unit when authoring — read the source map's "Threads Throughout the Course" section directly (lines 511-694) before writing any lesson content.

## Adaptive Project Pathways and Project Depth (reused from the source map)

Every major unit project should eventually offer three pathways — **Guided Build** (starter files, worked examples, checkpoints), **Design Challenge** (required skills/success criteria given, more design freedom), **Build Your Own** (student proposes an original solution meeting the same mastery targets) — all assessing the same core mastery targets. Projects can also scale by depth: **Starter** (essential skill demonstrated) → **Skilled** (concepts combined, real functionality/usability added) → **Legendary** (transfer to a less familiar situation) → **Mythic** (substantial synthesis/independence/investigation). Not built into any unit above yet — flagged as a real design-work item, not silently dropped. Project names throughout this file (e.g. "01 Project: Structured Content Page") are the source map's own placeholders, not required assignments — see its "Project Philosophy" section.

## Reuse Notes

Nothing exists yet to adapt from the way `adaptive-python` feeds Game I — this course has no equivalent sibling app. The primary reuse source is the source map itself (already extensively designed — UI Pattern Library, User Research Toolkit, Usability Testing Toolkit, Scaffolding System, and Capstone System are all specified in its "What Still Needs to Be Created" section, none built yet) plus the LearnKey/Certiport workbooks (`JavaScript_INF-302_Student_Workbook.pdf`, `HTML5_Application_Development_Student_Workbook.pdf`, and their support-file folders in `../../starter context/`) for exercise ideas. Per the licensing pattern already established for GMetrix (`../../01-privacy-and-governance/licensing-boundaries.md`), anything adapted from these workbooks into a lesson should get a clear traceable naming convention analogous to Python's `GMETRIX-` prefix — a JS/HTML5-specific equivalent isn't defined yet, see Open Items.

## Certification Objective Mapping (adapted directly from the source map)

| Certification Area | Primary Units | Status |
|---|---|---|
| Application lifecycle | 17, 20, 21 | Reinforced |
| Debugging, runtime errors, breakpoints | 07, 09, 17, 20 | Reinforced |
| Canvas | 18 | Taught |
| SVG | 18 | Taught |
| CSS effects and filters | 03, 18 | Taught |
| CSS transforms/transitions/keyframes | 18 | Taught |
| HTML forms and specialized form elements | 15 | Reinforced |
| HTML/form validation | 15 | Reinforced |
| Content flow, positioning, overflow | 04 | Reinforced |
| Responsive design | 05, 20, 21 | Reinforced |
| Flexbox | 04, 05 | Reinforced |
| CSS Grid | 04, 05 | Reinforced |
| JavaScript classes | 13 / targeted certification extension | Taught |
| Data access, JSON, XML overview | 19 | Taught |
| Event listeners/handlers and bubbling | 11 | Reinforced |
| JavaScript/browser APIs | 19 | Taught |
| Local/session/application state | 16, 20 | Reinforced |
| JS operators and best practices | 07 | Reinforced |
| Exception handling | 07, 17 | Taught |
| BOM basics | 07 | Taught |
| JS primitive data types and conversion | 07 | Reinforced |
| Arrays and array operations | 12 | Reinforced |
| Objects and Date | 13 | Reinforced |
| Math functions | 07 / project practice | Taught |
| Functions, parameters, returns, scope | 09 | Reinforced |
| Decisions and logical operators | 08 | Reinforced |
| Loops and loop control | 14 | Reinforced |
| DOM tree and manipulation | 10 | Reinforced |
| DOM/form/keyboard/mouse events | 11 | Reinforced |
| Form input and JS validation | 15 | Reinforced |
| Form submission and GET/POST | 15 | Taught |

(Original table also cited Unit 00 for "Application lifecycle" — dropped here since Unit 00 is now the shared cross-course onboarding unit, not this course's content.)

## Open Items This Plan Doesn't Resolve

- **The Web I/II acceleration diagnostic isn't built.** The "Mixed-Experience Model" section above proposes treating it as an internal pacing lane rather than a separate course — this is a proposed resolution, not confirmed by Jay yet.
- **No post-AP-testing project activity identified for this course**, unlike Game I's MakeCode Arcade (which is real skills-application project work for that window, not filler — corrected 2026-08-18). Worth a deliberate decision once Unit 21's real pacing is scoped against the actual CPS calendar.
- **Whether Units 21.20/21.21's reflection work becomes the same cross-course journal thread Game I already has**, or stays this course's own separate thing — not decided. `../../open-questions.md` already flags "whether Game II/Web II eventually get their own version of this thread" as open; this plan doesn't resolve it, just notes where it would attach if extended here.
- **A JS/HTML5-equivalent to Python's `GMETRIX-` naming convention** for workbook-derived content isn't defined yet.
- **None of "What Still Needs to Be Created" (source map lines 1132-1394) is built**: module/lesson-level documentation, the UI Pattern Library, User Research Toolkit, Usability Testing Toolkit, Project Bank, Practice/Question Bank, Mastery Checks, Scaffolding System, Critique/Feedback structures, Accessibility Checklist, Technical Best-Practices Guide, Capstone System, or the Certification Alignment/Readiness tracking system. This course-plan is the unit/lesson checklist only — everything downstream of it (per Python's own authoring workflow, `../../02-authoring-system/authoring-workflow.md`) is still ahead.
- **Exact certification exam timing against real calendar dates** is blocked on the CPS academic calendar, same as the pacing constraint generally.
