# Web Development: Designing & Building Usable Interactive Experiences

## Course Map, Certification Alignment, and Development Notes

### Course Purpose

This course teaches students to design and build usable, accessible,
interactive web experiences while developing computational thinking,
programming, user experience, and product-design skills.

The course is designed for high school learners with mixed experience.
Web Development I students may move through the full HTML/CSS
foundation, while Web Development II students with demonstrated
foundational mastery can move more quickly into JavaScript and
interactive application development. Prior technical experience should
not automatically exempt students from UX, accessibility, research,
testing, or design-thinking work.

The goal is not simply for students to be able to "make a website." By
the end of the course, students should be able to investigate a problem,
understand a user, plan an interface, build an interactive solution,
observe people using it, identify usability problems, revise based on
evidence, and explain their technical and design decisions.

------------------------------------------------------------------------

### Certification Pathway

The course also provides a natural pathway toward two Certiport IT
Specialist credentials:

1.  **HTML5 Application Development --- Required target credential**
2.  **JavaScript --- Strongly encouraged second credential**

Certification preparation should be embedded into authentic
web-development work rather than taught as a separate test-prep course.
Students should repeatedly use certification skills while designing,
building, debugging, testing, and improving real interfaces.

The HTML5 Application Development credential is the required target
because it integrates HTML5, CSS3, JavaScript ES6, responsive layout,
forms, graphics, events, application state, data access, testing, and
the broader application lifecycle. The JavaScript credential is strongly
encouraged for students who demonstrate sufficient readiness because it
asks for deeper fluency with JavaScript syntax, data, functions,
decisions, loops, the DOM, events, forms, and debugging.

The certifications establish a **technical floor, not the ceiling of the
course**. UX, accessibility, computational thinking, research, usability
testing, product thinking, student choice, and authentic project
development remain core course outcomes.

# High School Appropriateness Review

This map has been reviewed with a high school audience in mind. The
overall progression is appropriate, with the following design principles
guiding implementation.

## 1. This is a mastery map, not 21 equally sized classroom units

The modules describe the full progression of knowledge and skills.
Individual lessons may be short, combined, revisited, or taught through
projects. A topic appearing as its own lesson does not mean it requires
a full class period.

This is especially important in Modules 06, 17, 19, and 20, where many
concepts represent steps in a process rather than isolated units of
study.

## 2. User research should stay authentic but lightweight

Students should learn real research habits without being expected to
conduct professional-scale UX research.

Appropriate high school experiences include:

-   short interviews with classmates or other accessible users
-   simple surveys
-   observation
-   task analysis
-   think-aloud usability testing
-   identifying repeated pain points or patterns
-   distinguishing observations from assumptions
-   making revisions based on evidence

Students do not need elaborate personas, large research samples, formal
research reports, or advanced statistical analysis.

## 3. JavaScript should be introduced as a new programming foundation

Students who know HTML and CSS may still be beginning programmers.
JavaScript instruction should therefore explicitly scaffold variables,
data types, decisions, functions, collections, loops, debugging, and
algorithmic thinking rather than assuming prior programming knowledge.

## 4. Advanced web concepts should remain application-focused

APIs, asynchronous behavior, JSON, state, and persistence belong in the
course, but they should be taught through concrete applications.

For example, students need to understand that `fetch()` may take time
and that the interface must account for loading, success, and failure.
They do not need a deep theoretical treatment of JavaScript's event loop
or advanced Promise composition.

## 5. UX and accessibility are core skills, not polish

Students should encounter usability, accessibility, visual hierarchy,
interaction feedback, and user needs from the beginning of the course.
These should continue through technical modules rather than being
confined to a single UX unit.

## 6. Certification should grow naturally from the course

Students should not experience the course as months of authentic
development followed by disconnected certification cramming.

Certification vocabulary and objective styles should be introduced after
students understand the underlying ideas through projects.

Use three levels of alignment:

-   **Taught** --- the skill is explicitly introduced.
-   **Reinforced** --- the skill appears repeatedly in projects,
    practice, debugging, or assessment.
-   **Certification Ready** --- students can recognize and apply the
    skill in the terminology and formats used by the exam.

Short certification checks can be embedded throughout the course, with a
focused review period before testing.

## 7. Projects should provide both structure and freedom

Students should not repeatedly face an empty editor with the instruction
to "make anything." Choice works best when students have clear
constraints, examples, required skills, checkpoints, and optional
extensions.

Most major projects should eventually support three pathways:

**Guided Build** - substantial scaffolding, starter code, examples, and
checkpoints.

**Design Challenge** - required skills and success criteria are
provided, but students make more design and implementation decisions.

**Build Your Own** - students propose a project that demonstrates the
same required mastery targets.

## 7. Professional practices should be introduced at a high-school-accessible level

Students should learn basic file organization, naming conventions,
commenting, documentation, version history/version control concepts,
testing, attribution, privacy awareness, and deployment. The goal is to
develop good habits without turning the course into a professional
software-engineering bootcamp.

------------------------------------------------------------------------

# Full Course Map

``` text
web-development/
│
├── 00-course-onboarding/
│   ├── 00.1-welcome-to-web-development
│   ├── 00.2-how-learning-works
│   ├── 00.3-how-the-web-works
│   ├── 00.4-using-the-development-environment
│   ├── 00.5-the-web-app-lifecycle-plan-design-build-test-share-improve
│   ├── 00.6-debugging-is-learning
│   ├── 00.7-introduction-to-computational-thinking
│   ├── 00.8-designing-for-someone-other-than-yourself
│   ├── 00.9-what-makes-an-interface-easy-to-use
│   └── 00.10-getting-unstuck
│
├── 01-html-and-page-structure/
│   ├── 01.1-what-html-does
│   ├── 01.2-elements-tags-and-content
│   ├── 01.3-document-structure
│   ├── 01.4-headings-and-paragraphs
│   ├── 01.5-links-and-navigation
│   ├── 01.6-images
│   ├── 01.7-lists
│   ├── 01.8-attributes
│   ├── 01.9-organizing-information-for-users
│   ├── 01.10-reading-and-debugging-html
│   └── 01.project-structured-content-page
│
├── 02-semantic-html-and-accessibility/
│   ├── 02.1-structure-vs-appearance
│   ├── 02.2-why-semantics-matter
│   ├── 02.3-header-nav-main-and-footer
│   ├── 02.4-sections-articles-and-asides
│   ├── 02.5-accessible-images
│   ├── 02.6-accessible-links-and-navigation
│   ├── 02.7-designing-for-different-users
│   ├── 02.8-keyboard-and-screen-reader-thinking
│   ├── 02.9-reading-page-structure
│   └── 02.project-accessible-information-page
│
├── 03-css-foundations/
│   ├── 03.1-what-css-does
│   ├── 03.2-selectors
│   ├── 03.3-properties-and-values
│   ├── 03.4-colors
│   ├── 03.5-typography
│   ├── 03.6-classes-and-ids
│   ├── 03.7-cascade-and-specificity
│   ├── 03.8-visual-hierarchy
│   ├── 03.9-consistency-and-reusable-styles
│   ├── 03.10-making-interactions-look-interactive
│   ├── 03.11-visual-effects-gradients-shadows-and-transparency
│   ├── 03.12-css-filters-for-images
│   ├── 03.13-reading-and-debugging-css
│   └── 03.project-style-your-world
│
├── 04-layout-and-the-box-model/
│   ├── 04.1-the-box-model
│   ├── 04.2-margin-padding-and-border
│   ├── 04.3-width-height-and-sizing
│   ├── 04.4-display
│   ├── 04.5-flexbox
│   ├── 04.6-css-grid
│   ├── 04.7-positioning-and-content-flow
│   ├── 04.8-overflow-and-visibility
│   ├── 04.9-alignment-spacing-and-proximity
│   ├── 04.10-common-interface-layout-patterns
│   ├── 04.11-decomposing-an-interface
│   └── 04.project-recreate-a-layout
│
├── 05-responsive-and-adaptive-design/
│   ├── 05.1-designing-for-different-screens
│   ├── 05.2-relative-units
│   ├── 05.3-responsive-images-picture-and-backgrounds
│   ├── 05.4-the-viewport
│   ├── 05.5-media-queries
│   ├── 05.6-responsive-flexbox-and-grid
│   ├── 05.7-mobile-first-thinking
│   ├── 05.8-content-prioritization
│   ├── 05.9-touch-targets-and-mobile-interaction
│   ├── 05.10-responsive-navigation
│   ├── 05.11-testing-responsive-designs
│   └── 05.project-responsive-site
│
├── 06-user-experience-user-research-and-interface-design/
│   ├── 06.1-who-are-we-designing-for
│   ├── 06.2-user-goals-needs-and-pain-points
│   ├── 06.3-assumptions-vs-evidence
│   ├── 06.4-asking-good-research-questions
│   ├── 06.5-interviews-surveys-and-observation
│   ├── 06.6-identifying-patterns-in-feedback
│   ├── 06.7-turning-pain-points-into-design-opportunities
│   ├── 06.8-information-architecture-and-hierarchy
│   ├── 06.9-common-interface-patterns
│   ├── 06.10-consistency-and-predictability
│   ├── 06.11-affordances-and-signifiers
│   ├── 06.12-feedback-and-system-status
│   ├── 06.13-preventing-and-recovering-from-errors
│   ├── 06.14-reducing-cognitive-load
│   ├── 06.15-user-flows
│   ├── 06.16-wireframes-and-prototypes
│   ├── 06.17-introduction-to-usability-testing
│   ├── 06.18-observe-dont-rescue
│   ├── 06.19-turning-observations-into-findings
│   ├── 06.20-revising-from-evidence
│   └── 06.project-research-redesign-and-test
│
├── 07-javascript-and-programming-thinking/
│   ├── 07.1-why-websites-need-javascript
│   ├── 07.2-html-css-and-javascript-working-together
│   ├── 07.3-internal-vs-external-scripts
│   ├── 07.4-how-javascript-runs
│   ├── 07.5-console-output-and-breakpoints
│   ├── 07.6-variables-constants-and-memory
│   ├── 07.7-strings
│   ├── 07.8-numbers
│   ├── 07.9-booleans-null-and-undefined
│   ├── 07.10-type-checking-and-conversion
│   ├── 07.11-assignment-arithmetic-and-compound-operators
│   ├── 07.12-comments-formatting-and-naming
│   ├── 07.13-reading-javascript
│   ├── 07.14-common-javascript-errors
│   ├── 07.15-browser-object-model-basics
│   ├── 07.16-try-catch-and-handling-errors
│   └── 07.project-interactive-page-upgrade
│
├── 08-decisions-and-logic/
│   ├── 08.1-making-decisions-with-code
│   ├── 08.2-comparison-operators
│   ├── 08.3-boolean-logic
│   ├── 08.4-if-statements
│   ├── 08.5-if-else
│   ├── 08.6-else-if-and-switch
│   ├── 08.7-combining-conditions
│   ├── 08.8-modeling-user-decisions
│   ├── 08.9-reading-conditional-code
│   ├── 08.10-designing-predictable-behavior
│   └── 08.project-decision-based-experience
│
├── 09-functions-and-reusable-behavior/
│   ├── 09.1-why-functions-matter
│   ├── 09.2-defining-functions
│   ├── 09.3-calling-functions
│   ├── 09.4-parameters
│   ├── 09.5-return-values
│   ├── 09.6-local-and-global-scope
│   ├── 09.7-values-references-and-reusable-data
│   ├── 09.8-breaking-problems-into-functions
│   ├── 09.9-recognizing-repeated-behavior
│   ├── 09.10-reusable-interface-behavior
│   ├── 09.11-reading-and-debugging-functions
│   └── 09.project-function-toolkit
│
├── 10-the-dom/
│   ├── 10.1-html-becomes-the-dom
│   ├── 10.2-understanding-the-document-tree
│   ├── 10.3-selecting-elements-by-id-class-and-tag
│   ├── 10.4-reading-content
│   ├── 10.5-changing-content
│   ├── 10.6-changing-attributes
│   ├── 10.7-changing-styles
│   ├── 10.8-working-with-classes
│   ├── 10.9-creating-elements
│   ├── 10.10-removing-elements
│   ├── 10.11-tracing-dom-changes
│   ├── 10.12-interface-state-and-visual-feedback
│   └── 10.project-page-transformer
│
├── 11-events-and-interaction/
│   ├── 11.1-event-driven-programming
│   ├── 11.2-click-events
│   ├── 11.3-event-listeners
│   ├── 11.4-input-events
│   ├── 11.5-keyboard-events
│   ├── 11.6-event-objects
│   ├── 11.7-mouse-focus-and-form-events
│   ├── 11.8-event-bubbling-basics
│   ├── 11.9-connecting-actions-to-behavior
│   ├── 11.10-hover-focus-active-and-disabled-states
│   ├── 11.11-immediate-and-delayed-feedback
│   ├── 11.12-making-interactions-discoverable
│   ├── 11.13-keyboard-accessible-interactions
│   └── 11.project-interactive-widget
│
├── 12-arrays-and-collections/
│   ├── 12.1-why-collections-matter
│   ├── 12.2-creating-arrays
│   ├── 12.3-accessing-items
│   ├── 12.4-updating-items
│   ├── 12.5-adding-and-removing-items
│   ├── 12.6-push-pop-shift-and-unshift
│   ├── 12.7-sorting-and-searching-arrays
│   ├── 12.8-multidimensional-arrays-as-a-stretch-skill
│   ├── 12.9-looping-through-arrays
│   ├── 12.10-recognizing-patterns-in-data
│   ├── 12.11-rendering-arrays-to-the-page
│   ├── 12.12-designing-repeated-interface-components
│   └── 12.project-dynamic-gallery-or-list
│
├── 13-objects-and-modeling-data/
│   ├── 13.1-what-objects-represent
│   ├── 13.2-properties-and-values
│   ├── 13.3-accessing-object-data
│   ├── 13.4-updating-objects
│   ├── 13.5-creating-and-using-objects
│   ├── 13.6-date-and-time-with-javascript
│   ├── 13.7-arrays-of-objects
│   ├── 13.8-modeling-real-world-information
│   ├── 13.9-separating-content-from-presentation
│   ├── 13.10-rendering-structured-data
│   ├── 13.11-designing-data-driven-components
│   └── 13.project-data-driven-interface
│
├── 14-loops-and-repeated-behavior/
│   ├── 14.1-why-loops-matter
│   ├── 14.2-for-loops
│   ├── 14.3-while-and-do-while-loops
│   ├── 14.4-for-in-and-loop-control
│   ├── 14.5-looping-through-arrays
│   ├── 14.6-building-elements-with-loops
│   ├── 14.7-recognizing-repeated-patterns
│   ├── 14.8-avoiding-unnecessary-repetition
│   ├── 14.9-debugging-loops
│   └── 14.project-generated-interface
│
├── 15-forms-and-user-input/
│   ├── 15.1-how-web-forms-work
│   ├── 15.2-input-types-and-form-structure
│   ├── 15.3-fieldset-legend-datalist-meter-and-output
│   ├── 15.4-labels-and-accessibility
│   ├── 15.5-reading-and-updating-form-values
│   ├── 15.6-form-events-and-submission
│   ├── 15.7-get-vs-post-conceptually
│   ├── 15.8-html-validation-attributes
│   ├── 15.9-javascript-input-validation
│   ├── 15.10-pattern-validation-and-regular-expression-basics
│   ├── 15.11-preventing-user-errors
│   ├── 15.12-writing-helpful-error-messages
│   ├── 15.13-success-confirmation-and-feedback
│   ├── 15.14-preserving-user-progress
│   ├── 15.15-testing-a-form-with-users
│   └── 15.project-interactive-form
│
├── 16-state-and-persistence/
│   ├── 16.1-what-is-state
│   ├── 16.2-tracking-changing-information
│   ├── 16.3-interface-state
│   ├── 16.4-selected-open-disabled-and-completed
│   ├── 16.5-local-vs-session-storage
│   ├── 16.6-saving-data
│   ├── 16.7-loading-data
│   ├── 16.8-designing-persistent-experiences
│   ├── 16.9-empty-default-and-returning-user-states
│   └── 16.project-persistent-web-app
│
├── 17-debugging-testing-and-quality/
│   ├── 17.1-debugging-html
│   ├── 17.2-debugging-css
│   ├── 17.3-debugging-javascript
│   ├── 17.4-browser-developer-tools
│   ├── 17.5-reading-console-and-runtime-errors
│   ├── 17.6-breakpoints-and-step-by-step-debugging
│   ├── 17.7-expected-vs-actual-behavior
│   ├── 17.8-test-cases
│   ├── 17.9-edge-cases
│   ├── 17.10-testing-user-interactions
│   ├── 17.11-accessibility-testing
│   ├── 17.12-usability-vs-functionality
│   ├── 17.13-observing-users-without-leading-them
│   ├── 17.14-prioritizing-usability-problems
│   └── 17.project-debug-test-and-improve
│
├── 18-graphics-animation-and-rich-web-experiences/
│   ├── 18.1-css-transitions-and-keyframe-animation
│   ├── 18.2-2d-transforms-translate-scale-rotate-and-skew
│   ├── 18.3-3d-transform-and-perspective-basics
│   ├── 18.4-canvas-basics-shapes-color-and-lines
│   ├── 18.5-moving-rotating-and-scaling-canvas-graphics
│   ├── 18.6-making-canvas-interactive
│   ├── 18.7-svg-basics-and-when-to-use-svg
│   ├── 18.8-inline-vs-referenced-svg
│   ├── 18.9-svg-shapes-color-and-filter-effects
│   ├── 18.10-animation-accessibility-and-reduced-motion
│   └── 18.project-interactive-visual-experience
│
├── 19-working-with-external-data/
│   ├── 19.1-static-vs-dynamic-data
│   ├── 19.2-json-and-complex-objects
│   ├── 19.3-sending-receiving-and-parsing-data
│   ├── 19.4-what-is-an-api
│   ├── 19.5-fetch
│   ├── 19.6-when-code-has-to-wait
│   ├── 19.7-reading-api-data
│   ├── 19.8-displaying-external-data
│   ├── 19.9-loading-and-saving-files-conceptually
│   ├── 19.10-xml-and-other-data-formats-overview
│   ├── 19.11-using-browser-apis
│   ├── 19.12-geolocation-and-privacy
│   ├── 19.13-loading-states
│   ├── 19.14-error-states
│   ├── 19.15-empty-states
│   ├── 19.16-designing-for-uncertain-data
│   └── 19.project-data-powered-app
│
├── 20-building-and-sharing-complete-web-applications/
│   ├── 20.1-from-feature-to-application
│   ├── 20.2-identifying-the-user-and-goal
│   ├── 20.3-mapping-the-user-flow
│   ├── 20.4-planning-interface-and-behavior
│   ├── 20.5-organizing-project-files
│   ├── 20.6-separating-html-css-and-javascript
│   ├── 20.7-breaking-features-into-functions
│   ├── 20.8-managing-application-and-session-state
│   ├── 20.9-designing-feedback-and-error-states
│   ├── 20.10-version-history-and-basic-version-control
│   ├── 20.11-testing-the-user-flow
│   ├── 20.12-refactoring
│   ├── 20.13-usability-accessibility-and-polish
│   ├── 20.14-attribution-privacy-and-responsible-publishing
│   ├── 20.15-deploying-and-sharing-a-web-project
│   └── 20.project-complete-web-application
│
└── 21-capstone-product-design-and-development/
    ├── 21.1-identifying-a-user-or-community
    ├── 21.2-exploring-a-problem-space
    ├── 21.3-planning-lightweight-user-research
    ├── 21.4-interviewing-and-observing-users
    ├── 21.5-identifying-needs-and-pain-points
    ├── 21.6-defining-the-problem
    ├── 21.7-generating-possible-solutions
    ├── 21.8-defining-requirements-and-success-criteria
    ├── 21.9-feature-scoping-and-prioritization
    ├── 21.10-user-flows-and-information-architecture
    ├── 21.11-wireframing-and-prototyping
    ├── 21.12-building-v1
    ├── 21.13-functional-testing-and-debugging
    ├── 21.14-usability-testing-observe-dont-rescue
    ├── 21.15-analyzing-observations-and-feedback
    ├── 21.16-prioritizing-revisions
    ├── 21.17-building-v2
    ├── 21.18-accessibility-and-quality-review
    ├── 21.19-publishing-and-sharing
    ├── 21.20-presentation-and-design-rationale
    ├── 21.21-reflection
    └── 21.final-product
```

------------------------------------------------------------------------

# Threads Throughout the Course

These are not intended to be taught once and forgotten. They should
appear repeatedly in lessons, practice, projects, critiques, mastery
checks, and reflection.

## Computational Thinking

-   Decomposition
-   Pattern recognition
-   Abstraction
-   Algorithmic thinking
-   Debugging and revision
-   Evaluating solutions
-   Iteration
-   Transfer to unfamiliar problems
-   Independent problem solving

A recurring question should be: **How can I break this problem or
interface into smaller parts I understand?**

## User Experience and Product Thinking

-   Designing for a user rather than only for yourself
-   User goals, needs, and pain points
-   Evidence vs. assumptions
-   Information hierarchy
-   Information architecture
-   User flows
-   Common interface patterns
-   Affordances and signifiers
-   Feedback and system status
-   Error prevention and recovery
-   Cognitive load
-   Usability
-   Accessibility
-   Observation
-   Iteration based on evidence

A recurring question should be: **Can another person understand and
successfully use what I built?**

## User Research

Students should repeatedly practice small, manageable research
activities.

The emphasis is on:

1.  identifying what they want to learn
2.  asking neutral questions
3.  listening rather than selling their idea
4.  observing behavior
5.  recording what happened
6.  separating observation from interpretation
7.  looking for patterns
8.  identifying pain points
9.  translating findings into possible design changes

A key distinction should be reinforced:

**User research:** What problems or needs should we understand?

**Usability testing:** Can people successfully use the solution we
designed?

## UI and Interaction Design

Students should analyze and build common interface structures such as:

-   navigation
-   cards
-   buttons
-   forms
-   menus
-   tabs
-   accordions
-   modals/dialogs
-   dashboards
-   lists
-   search and filtering
-   settings
-   alerts
-   confirmation messages
-   loading states
-   empty states
-   error states
-   disabled states
-   selected states

Students should not only learn how to code these patterns. They should
discuss **when a pattern is appropriate and what makes it understandable
to a user**.

## Accessibility

Accessibility should be treated as part of quality and usability from
the beginning.

Recurring considerations include:

-   semantic HTML
-   heading hierarchy
-   alternative text
-   meaningful links
-   labels
-   color contrast
-   readable typography
-   keyboard interaction
-   focus states
-   touch-target size
-   responsive layouts
-   avoiding reliance on color alone
-   understandable instructions and error messages

## Testing and Observation

Testing should include more than checking whether code runs.

Students should learn to test:

-   technical functionality
-   expected and unexpected inputs
-   different screen sizes
-   keyboard interaction
-   accessibility
-   user flows
-   comprehension
-   usability

A recurring class protocol should be:

### Observe, Don't Rescue

During a usability test:

1.  Give the participant a goal or task.
2.  Ask them to think aloud when appropriate.
3.  Avoid explaining the interface.
4.  Watch what they actually do.
5.  Record moments of hesitation, confusion, mistakes, and success.
6.  Ask follow-up questions afterward.
7.  Identify what the design could communicate more clearly.
8.  Revise and test again.

Students should learn that **"I can explain how it works" is not the
same as "the interface explains how it works."**

## Technical Best Practices

Students should gradually develop habits around:

-   meaningful file and variable names
-   readable formatting
-   project organization
-   reusable code
-   avoiding unnecessary duplication
-   comments and documentation
-   debugging systematically
-   browser developer tools
-   testing
-   version history and introductory version control
-   attribution
-   privacy awareness
-   responsible use of external data
-   responsible AI-assisted development
-   deployment and sharing

## Communication and Design Rationale

Students should practice explaining:

-   what they built
-   who it is for
-   what problem they were trying to solve
-   what evidence informed their decisions
-   how their code works
-   why they selected a particular interface pattern
-   what went wrong
-   how they debugged it
-   what they observed during testing
-   what they changed and why
-   what they would improve next

------------------------------------------------------------------------

# Certification Alignment Thread

Certification objectives should be visible to the teacher and available
to students without dominating the everyday language of the course.

## Credential 1: IT Specialist HTML5 Application Development --- Required

All students should be given a supported opportunity to prepare for and
attempt this credential.

The course should intentionally cover its five objective areas:

### 1. Application Lifecycle Management

Students practice planning, designing, developing, testing, deploying,
and maintaining web applications throughout projects and the capstone.

They also practice input-validation errors, runtime errors, and
breakpoints.

### 2. Graphics and Animation

Students learn:

-   Canvas graphics and basic interactivity
-   SVG
-   CSS visual effects and filters
-   2D and introductory 3D transforms
-   transitions
-   keyframe animation
-   typography and web fonts

These topics should be taught as tools for communication and
interaction, not decoration for its own sake.

### 3. Forms

Students construct accessible forms and work with:

-   common input types
-   datalist
-   fieldset
-   legend
-   meter
-   output
-   validation attributes
-   required values
-   length constraints
-   pattern validation
-   appropriate input data types

### 4. Layouts

Students receive substantial repeated practice with:

-   content flow
-   positioning
-   overflow
-   responsive design
-   responsive images
-   viewport behavior
-   media queries
-   Flexbox
-   CSS Grid

### 5. JavaScript Coding

Students use JavaScript to:

-   create and use classes at an introductory level
-   work with structured data
-   send, receive, and parse data
-   use JSON
-   understand XML at an appropriate introductory level
-   respond to events
-   use event listeners and handlers
-   understand event bubbling
-   use selected browser or JavaScript APIs
-   manage local, session, interface, and application state

The course may use modern APIs and tools in authentic projects while
also ensuring students recognize terminology that appears in the
certification objectives.

------------------------------------------------------------------------

## Credential 2: IT Specialist JavaScript --- Strongly Encouraged

Students who demonstrate readiness should be strongly encouraged and
supported to attempt the JavaScript credential.

The course should provide coverage of all major objective areas, with
additional certification practice for students pursuing the exam.

### 1. Operators, Methods, and Keywords

Students practice:

-   assignment
-   increment and decrement
-   arithmetic
-   modulus
-   compound assignment
-   comments
-   indentation
-   naming conventions
-   constants
-   debugging
-   console output
-   breakpoints
-   internal vs external scripts
-   exception handling
-   basic Browser Object Model concepts

### 2. Variables, Data Types, and Functions

Students practice:

-   Number
-   Boolean
-   String
-   null
-   undefined
-   type checking
-   conversion
-   arrays
-   array methods
-   sorting and searching
-   objects
-   dates and times
-   Math functions
-   parameters
-   return values
-   scope
-   reusable functions

Some less common exam-specific methods can be handled through
certification review rather than consuming large amounts of core
instructional time.

### 3. Decisions and Loops

Students practice:

-   comparison operators
-   logical operators
-   if
-   if/else
-   else-if
-   switch
-   nested decisions
-   for
-   for-in
-   while
-   do-while
-   break
-   continue

### 4. Document Object Model

Students practice:

-   reading the DOM tree
-   locating elements
-   modifying elements
-   changing attributes
-   creating elements
-   document, form, keyboard, and mouse events
-   event handlers
-   event listeners
-   text and HTML output

Modern, safer DOM patterns should be emphasized during normal
development. Exam-specific legacy patterns can be identified during
certification review when necessary.

### 5. HTML Forms

Students practice:

-   retrieving form values
-   updating fields
-   validating input
-   checking blank or invalid values
-   form submission
-   onsubmit behavior
-   GET vs POST conceptually

------------------------------------------------------------------------

# Certification Support Model

## Level 1: Learn It Through Development

Students first encounter skills in understandable project contexts.

Example:

> Build a responsive card layout.

The instructional focus is layout, hierarchy, responsiveness, and
usability.

## Level 2: Reinforce It Through Projects and Practice

Students encounter the same skill again in different contexts.

Example:

-   product cards
-   dashboard cards
-   search results
-   responsive portfolio content

## Level 3: Name the Certification Connection

Once the concept is understood, students see the certification
terminology.

Example:

> Certification Connection: CSS Flexbox --- flex container,
> flex-direction, flex-wrap, flex-grow, flex-shrink, flex-basis, order.

## Level 4: Certification Check

Short practice asks students to:

-   read unfamiliar code
-   select the correct implementation
-   debug a code sample
-   recognize terminology
-   predict behavior

These should be brief and distributed across the course.

## Level 5: Certification Readiness Review

Before the exam, students use:

-   objective-by-objective checklist
-   diagnostic assessment
-   targeted practice by weak objective
-   mixed certification-style practice
-   vocabulary review
-   debugging review
-   timed practice when appropriate

The goal is to identify gaps rather than reteach the entire course.

------------------------------------------------------------------------

# Recommended Certification Timing

## Required: HTML5 Application Development

The required certification should come **after students have completed
the major application-development sequence**, including responsive
design, JavaScript interaction, forms, state, graphics/animation,
external data, and testing.

Students should not take the exam immediately after the HTML/CSS portion
simply because the credential contains "HTML5" in its name. The
objectives also require JavaScript ES6 and application-development
skills.

## Strongly Encouraged: JavaScript

Students who demonstrate JavaScript readiness can attempt the JavaScript
certification after the major JavaScript, DOM, events, arrays/objects,
loops, forms, and debugging modules.

A readiness check should help determine whether the student would
benefit from:

-   taking the exam
-   receiving a short period of targeted review first
-   continuing to build JavaScript fluency before attempting it

Strong encouragement should still preserve a meaningful readiness
threshold so certification attempts remain supportive rather than
punitive.

------------------------------------------------------------------------

# Certification Objective Mapping

  Certification Area                         Primary Course Modules                  Status
  ------------------------------------------ --------------------------------------- ------------
  Application lifecycle                      00, 17, 20, 21                          Reinforced
  Debugging, runtime errors, breakpoints     07, 09, 17, 20                          Reinforced
  Canvas                                     18                                      Taught
  SVG                                        18                                      Taught
  CSS effects and filters                    03, 18                                  Taught
  CSS transforms/transitions/keyframes       18                                      Taught
  HTML forms and specialized form elements   15                                      Reinforced
  HTML/form validation                       15                                      Reinforced
  Content flow, positioning, overflow        04                                      Reinforced
  Responsive design                          05, 20, 21                              Reinforced
  Flexbox                                    04, 05                                  Reinforced
  CSS Grid                                   04, 05                                  Reinforced
  JavaScript classes                         13 / targeted certification extension   Taught
  Data access, JSON, XML overview            19                                      Taught
  Event listeners/handlers and bubbling      11                                      Reinforced
  JavaScript/browser APIs                    19                                      Taught
  Local/session/application state            16, 20                                  Reinforced
  JS operators and best practices            07                                      Reinforced
  Exception handling                         07, 17                                  Taught
  BOM basics                                 07                                      Taught
  JS primitive data types and conversion     07                                      Reinforced
  Arrays and array operations                12                                      Reinforced
  Objects and Date                           13                                      Reinforced
  Math functions                             07 / project practice                   Taught
  Functions, parameters, returns, scope      09                                      Reinforced
  Decisions and logical operators            08                                      Reinforced
  Loops and loop control                     14                                      Reinforced
  DOM tree and manipulation                  10                                      Reinforced
  DOM/form/keyboard/mouse events             11                                      Reinforced
  Form input and JS validation               15                                      Reinforced
  Form submission and GET/POST               15                                      Taught

# Mixed-Experience Learning Model

The course should support multiple entry points without lowering
expectations.

## Web Development I

Students generally move through the full progression, receiving
substantial support in HTML, CSS, layout, accessibility, programming
foundations, and JavaScript. The required HTML5 Application Development
credential provides a clear end-of-course technical target, while the
JavaScript credential is strongly encouraged when students demonstrate
readiness.

## Web Development II

Students can demonstrate prior HTML/CSS mastery through diagnostics,
short builds, or mastery checks and move more quickly into JavaScript
and application development.

However, prior HTML/CSS knowledge should **not** automatically exempt a
student from:

-   UX
-   user research
-   accessibility
-   usability testing
-   computational thinking
-   design rationale
-   technical best practices

These represent distinct competencies.

Web Development II students who accelerate through foundational HTML/CSS
should still demonstrate the certification objectives through
diagnostics and applied work. Acceleration changes how much
instructional time they need, not the technical expectations for the
required credential.

## Adaptive Project Pathways

Where appropriate, projects should offer:

### Guided Build

Starter files, worked examples, checkpoints, hints, and clearly
sequenced requirements.

### Design Challenge

Clear requirements and mastery targets with greater freedom over design
and implementation.

### Build Your Own

Students propose an original solution and show how it will demonstrate
the required skills.

All pathways should assess the same core mastery targets.

------------------------------------------------------------------------

# Suggested Project Depth Levels

Projects can also use progressive feature levels.

## Starter

Demonstrates the essential skill or required functionality.

## Skilled

Combines concepts and adds meaningful functionality, usability, or
design improvement.

## Legendary

Transfers learning to a less familiar situation, combines multiple
systems, or independently implements a meaningful extension.

## Mythic

Demonstrates substantial synthesis, independence, iteration, or
investigation beyond the taught pattern.

Higher levels should represent **deeper thinking and transfer**, not
simply more decoration or more lines of code.

------------------------------------------------------------------------

# Project Philosophy

The project names in this map are placeholders and examples, not
required assignments.

Project development should eventually create a bank of options aligned
to specific mastery targets. Existing ideas can be reused, revised,
combined, or replaced.

Projects should prioritize:

-   student choice
-   meaningful audiences or contexts
-   clear skill requirements
-   manageable scope
-   opportunities for iteration
-   UX and usability
-   accessibility
-   testing with other people
-   reflection
-   technical and design communication

------------------------------------------------------------------------

# What Still Needs to Be Created

## 1. Module-Level Curriculum Documentation

For every module:

-   module overview
-   essential question
-   technical outcomes
-   computational thinking outcomes
-   UX/usability outcomes
-   accessibility outcomes where relevant
-   communication/language outcomes
-   prerequisite skills
-   key vocabulary
-   common misconceptions
-   suggested pacing
-   mastery expectations

## 2. Lesson-Level Documentation

For every lesson:

-   lesson overview
-   learning objectives
-   computational thinking objective
-   UX connection
-   vocabulary
-   worked examples
-   interface examples when relevant
-   guided practice
-   independent practice
-   debugging practice
-   reflection
-   accessibility considerations
-   checks for understanding

## 3. UI Pattern and Example Library

Create a visual reference library students can repeatedly analyze.

Examples should include both effective and intentionally problematic
interfaces.

Potential categories:

-   navigation
-   cards
-   forms
-   buttons
-   menus
-   dashboards
-   mobile layouts
-   modals
-   settings
-   search
-   filters
-   error messages
-   empty states
-   loading states
-   onboarding
-   responsive layouts

Each example should include prompts that ask students to notice
hierarchy, grouping, affordances, feedback, accessibility, and possible
usability problems.

## 4. User Research Toolkit

Create student-friendly resources for:

-   interview planning
-   writing neutral questions
-   observation
-   simple surveys
-   research notes
-   identifying pain points
-   affinity/pattern grouping
-   turning findings into design opportunities
-   research ethics and privacy

## 5. Usability Testing Toolkit

Create:

-   task-writing templates
-   think-aloud instructions
-   Observe, Don't Rescue protocol
-   observation note sheets
-   usability issue tracker
-   severity/prioritization guidance
-   revision planning templates
-   before/after reflection

## 6. Project Bank

Create multiple project choices aligned to each major stage of the
course.

Projects should identify:

-   prerequisite skills
-   required mastery targets
-   UX requirements
-   accessibility requirements
-   Starter / Skilled / Legendary / Mythic possibilities
-   Guided Build / Design Challenge / Build Your Own options
-   suggested research or testing activity
-   reflection prompts

## 7. Practice and Question Bank

Create adaptive practice similar in philosophy to the Python course.

Questions should include:

-   reading code
-   predicting behavior
-   debugging
-   identifying patterns
-   selecting appropriate HTML structures
-   CSS reasoning
-   JavaScript reasoning
-   DOM tracing
-   usability analysis
-   accessibility analysis
-   UI critique
-   user-flow reasoning
-   interpreting research observations
-   distinguishing evidence from assumptions

## 8. Mastery Checks

Define what students must demonstrate before advancing.

Mastery should include more than syntax.

Depending on the module, evidence may include:

-   technical implementation
-   code reading
-   debugging
-   explanation
-   interface analysis
-   accessibility
-   usability reasoning
-   computational thinking
-   application to a new context

## 9. Scaffolding System

Develop reusable supports such as:

-   annotated examples
-   partially completed code
-   Parsons-style code ordering
-   debugging hints
-   interface decomposition diagrams
-   pseudocode
-   planning templates
-   vocabulary support
-   worked examples
-   code tracing
-   checklists
-   optional challenge extensions
-   fading support as mastery increases

## 10. Critique and Feedback Structures

Develop classroom protocols for:

-   design critique
-   peer code review
-   usability feedback
-   research debriefs
-   gallery walks
-   structured peer testing
-   revision planning

Feedback should focus on evidence and improvement rather than personal
taste.

## 11. Accessibility Checklist

Create a student-friendly checklist that grows with the course rather
than presenting every accessibility requirement at once.

## 12. Technical Best-Practices Guide

Create a concise reference covering:

-   file organization
-   naming
-   formatting
-   comments
-   reusable code
-   browser developer tools
-   debugging
-   version history/version control
-   attribution
-   privacy
-   responsible AI use
-   deployment

## 13. Capstone System

Develop:

-   problem-space exploration
-   research plan
-   research notes
-   pain-point synthesis
-   problem statement
-   requirements
-   feature prioritization
-   user flow
-   wireframe
-   prototype
-   development milestones
-   testing plan
-   usability test
-   revision log
-   accessibility review
-   final presentation
-   design rationale
-   reflection

## 14. Certification Alignment and Readiness System

Create:

-   objective-by-objective HTML5 Application Development checklist
-   objective-by-objective JavaScript checklist
-   module-to-objective mapping
-   short certification checks embedded in modules
-   certification vocabulary callouts
-   code-reading and debugging practice
-   HTML5 Application Development readiness diagnostic
-   JavaScript readiness diagnostic
-   targeted review paths by weak objective
-   mixed certification-style review
-   student progress tracker showing Taught / Reinforced / Certification
    Ready
-   exam reflection and next-step plan

The certification system should make readiness visible without replacing
authentic project work.

## 15. Entry Diagnostics and Acceleration Path

Especially for Web Development II, create diagnostics that determine
whether students need reinforcement in:

-   HTML structure
-   semantic HTML
-   CSS
-   layout
-   responsive design
-   accessibility
-   JavaScript programming foundations

Acceleration should be based on demonstrated mastery rather than course
enrollment alone.

------------------------------------------------------------------------

# Recommended Next Development Sequence

1.  Finalize course-level outcomes.
2.  Define module-level outcomes and prerequisites.
3.  Identify which modules are foundational for Web Development I versus
    primary Web Development II content.
4.  Define mastery targets for every module.
5.  Map computational-thinking, UX, and certification objectives across
    those targets.
6.  Build the certification objective matrix and identify any remaining
    gaps.
7.  Build the UI Pattern and Example Library.
8.  Build the User Research and Usability Testing Toolkits.
9.  Create project options and project rubrics.
10. Develop lesson content and scaffolds.
11. Build mastery checks and adaptive practice.
12. Create entry diagnostics and certification readiness checks and
    acceleration rules.
13. Build the capstone system.
14. Review the entire curriculum for pacing, accessibility, cognitive
    load, and redundancy.

------------------------------------------------------------------------

# Course-Level North Star

A successful student should leave the course able to say:

> I can understand a user's problem, break it into manageable parts,
> design an interface that helps them accomplish a goal, build the
> experience with HTML, CSS, and JavaScript, test both the code and the
> experience, observe how real people use it, improve my work based on
> evidence, and demonstrate the technical skills needed to pursue
> industry-recognized web development certifications.

That is the standard the individual lessons, projects, assessments, and
scaffolds should ultimately support.
