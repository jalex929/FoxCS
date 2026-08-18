# Game Development with Unity

## Designing, Building, Testing, and Improving Player Experiences

## Course Purpose

This course introduces high school students to game development through
a progression from game design and beginner-friendly programming into 2D
Unity, then 3D Unity, and finally independent game development.

The course is designed around the idea that **Unity is the main
development tool, but game development is the subject**.

Students should leave the course able to:

-   understand how games work as systems of rules, actions, goals,
    feedback, and player choices
-   program interactive game behavior
-   build and organize games in Unity
-   design clear and usable game interfaces
-   create levels that guide players effectively
-   test games with real players
-   identify where players get confused or frustrated
-   revise games based on evidence
-   explain their design and technical decisions
-   understand a range of careers involved in making games
-   use AI thoughtfully to understand code, debug problems, write and
    modify scripts, and fill knowledge gaps
-   evaluate, test, and explain AI-assisted work rather than treating
    generated code as automatically correct
-   plan and build an original game with a realistic scope

The course should maintain strong scaffolding for students who are new
to programming, game engines, and 3D environments.

### Certification Pathway

The course also provides a natural pathway toward two Unity Certified
User credentials:

1.  **Unity Certified User Programmer --- Required target credential**
2.  **Unity Certified User Artist --- Progress credential / strongly
    encouraged when ready**

The Programmer credential is the required target because C# programming,
debugging, API interpretation, input, logic, state, UI behavior, code
evaluation, and Unity workflow are central technical outcomes of the
course.

The Artist credential is an aligned progress credential. Students should
make meaningful progress through asset management, sprites, Prefabs,
Transform tools, greyboxing, animation, meshes, Terrain, materials,
lighting, cameras, and rendering concepts. Students who demonstrate
sufficient readiness should be strongly encouraged and supported to
attempt the Artist certification, but completion is not required for
every student.

Certification is a **technical floor and external validation, not the
ceiling of the course**. Game design, computational thinking, UX,
accessibility, player research, playtesting, AI-assisted development,
student choice, and authentic project work remain central outcomes.

------------------------------------------------------------------------

# High School Appropriateness Review

## 1. The course begins with familiar 2D experiences

Most students should not be expected to begin by understanding 3D space,
perspective cameras, physics, transforms, C#, Unity's interface, and
game-design concepts simultaneously.

The course therefore begins with approximately four weeks of:

-   game-design foundations
-   MakeCode Arcade
-   simple programming concepts
-   small game systems
-   player feedback
-   playtesting
-   iteration

Students then move into 2D Unity before entering 3D.

The transition should feel like:

> You already understand the idea. Now you are learning how Unity builds
> it.

## 2. Professional vocabulary comes after understandable ideas

The course should use clear student-facing lesson names.

For example:

**Student-facing idea:** Showing Players What They Can Do\
**Professional vocabulary:** affordance, signifier

**Student-facing idea:** Giving Players the Right Amount of Information\
**Professional vocabulary:** cognitive load

**Student-facing idea:** Giving Players Meaningful Choices\
**Professional vocabulary:** player agency

Students should understand the idea first and then learn the
professional term.

## 3. Advanced concepts are introduced through concrete experiences

Students may encounter sophisticated game-design concepts such as:

-   balance
-   probability
-   pacing
-   hidden information
-   state
-   emergent behavior
-   resource systems
-   optimization
-   rubber-banding
-   simulation

These concepts should be grounded in games students play, analyze,
modify, or build.

Students do not need to implement every system they analyze.

## 4. The course map is a mastery map, not 29 equal units

The module structure represents the complete progression of skills and
ideas.

Some modules may last several weeks.

Some lessons may take only part of a class period.

Some concepts will be revisited repeatedly across projects.

## 5. Player experience is part of development, not polish

Students should not think:

> First I make the game. Then I add UX.

Instead, the course should continually ask:

-   Does the player understand what to do?
-   Does the game communicate what happened?
-   Is the challenge understandable?
-   Are controls responsive?
-   Can players tell what is interactive?
-   Is information readable?
-   Can more people access and use the game successfully?

## 6. Playtesting should begin early

Students should test games with other people before they reach the
capstone.

A recurring protocol should be:

### Observe, Don't Rescue

1.  Give the player a goal.
2.  Let them try.
3.  Avoid explaining how the game works.
4.  Watch what they actually do.
5.  Record hesitation, confusion, mistakes, and success.
6.  Ask follow-up questions afterward.
7.  Identify what the game could communicate more clearly.
8.  Revise and test again.

## 7. AI support begins when students enter Unity

Once students reach Unity, AI-assisted development should become an
explicit and recurring skill.

AI can reduce the barrier created by unfamiliar C#, Unity APIs, error
messages, and project-specific features, but students should not use it
as a replacement for understanding.

The course should teach a repeatable workflow:

> **Ask → Understand → Build → Test → Explain**

Students may use AI to:

-   understand unfamiliar code
-   explain Unity terminology
-   interpret Console errors
-   troubleshoot Inspector or component setup
-   break a feature into smaller systems
-   write small scripts
-   modify existing scripts
-   compare implementation approaches
-   investigate a Unity feature that has not yet been taught
-   generate test cases and identify edge cases
-   fill knowledge gaps during independent projects

Students remain responsible for testing and explaining what they build.

## 8. Certification should grow naturally from game development

Students should not experience the course as authentic game development
followed by disconnected certification cramming.

Certification skills should first appear in understandable
game-development contexts and then be named using certification
terminology.

Use three levels of alignment:

-   **Taught** --- the skill is explicitly introduced.
-   **Reinforced** --- the skill appears repeatedly in projects,
    practice, debugging, or assessment.
-   **Certification Ready** --- students can recognize and apply the
    skill using the terminology and problem formats expected by the
    certification.

The required Unity Programmer objectives should ultimately move toward
**Certification Ready**.

Unity Artist objectives should be intentionally taught and reinforced,
with students moving toward Certification Ready where their interests,
project work, and demonstrated readiness support it.

## 9. Projects should balance structure and choice

Projects should eventually offer multiple pathways:

### Guided Build

Students receive starter files, examples, checkpoints, and structured
support.

### Design Challenge

Students receive required skills and success criteria but make more
design choices.

### Build Your Own

Students propose a project that demonstrates the required mastery
targets.

All pathways should assess the same core learning goals.

------------------------------------------------------------------------

# Course Map

``` text
game-development-unity/
│
├── 00-welcome-to-game-development/
│   ├── 00.1-welcome-to-game-development
│   ├── 00.2-what-game-developers-do
│   ├── 00.3-games-are-interactive-systems
│   ├── 00.4-the-player-is-part-of-the-game
│   ├── 00.5-how-learning-works
│   ├── 00.6-debugging-is-learning
│   ├── 00.7-introduction-to-computational-thinking
│   ├── 00.8-how-game-teams-work
│   ├── 00.9-careers-in-games
│   └── 00.10-getting-unstuck
│
├── 01-how-games-work/
│   ├── 01.1-what-makes-something-a-game
│   ├── 01.2-goals-rules-and-limits
│   ├── 01.3-what-the-player-can-do
│   ├── 01.4-the-gameplay-loop
│   ├── 01.5-how-games-respond-to-players
│   ├── 01.6-showing-players-what-happened
│   ├── 01.7-pacing-and-flow
│   ├── 01.8-breaking-games-into-parts
│   ├── 01.9-changing-one-rule
│   └── 01.challenge-paper-game-remix
│
├── 02-making-games-with-makecode-arcade/
│   ├── 02.1-meet-makecode-arcade
│   ├── 02.2-sprites-and-game-objects
│   ├── 02.3-player-input-and-events
│   ├── 02.4-variables-and-game-state
│   ├── 02.5-score-lives-and-goals
│   ├── 02.6-decisions-and-game-rules
│   ├── 02.7-collisions-and-overlaps
│   ├── 02.8-randomness-and-probability
│   ├── 02.9-repetition-and-game-loops
│   ├── 02.10-functions-and-reusable-actions
│   ├── 02.11-debugging-game-systems
│   └── 02.project-makecode-microgame
│
├── 03-design-test-and-improve-a-microgame/
│   ├── 03.1-from-one-mechanic-to-a-game
│   ├── 03.2-building-a-clear-gameplay-loop
│   ├── 03.3-making-games-fair-and-fun
│   ├── 03.4-challenge-vs-frustration
│   ├── 03.5-helping-players-understand-the-rules
│   ├── 03.6-making-actions-feel-responsive
│   ├── 03.7-learning-from-players
│   ├── 03.8-giving-a-player-a-task
│   ├── 03.9-observe-dont-rescue
│   ├── 03.10-finding-where-players-get-stuck
│   ├── 03.11-improving-a-game-from-evidence
│   └── 03.project-microgame-redesign
│
├── 04-getting-started-with-unity-2d/
│   ├── 04.1-why-we-are-changing-tools
│   ├── 04.2-navigating-the-unity-editor
│   ├── 04.3-scenes-gameobjects-and-components
│   ├── 04.4-the-hierarchy-and-inspector
│   ├── 04.5-position-rotation-and-scale
│   ├── 04.6-sprites-spritesheets-and-sprite-renderers
│   ├── 04.7-slicing-spritesheets-and-9-slicing
│   ├── 04.8-importing-assets-and-using-the-asset-store
│   ├── 04.9-assets-and-project-organization
│   ├── 04.10-from-makecode-sprites-to-unity-gameobjects
│   ├── 04.11-play-mode-and-testing
│   ├── 04.12-unity-windows-and-what-they-do
│   ├── 04.13-scripting-editor-and-project-workflow
│   ├── 04.14-asking-ai-good-unity-questions
│   └── 04.challenge-build-a-simple-2d-scene
│
├── 05-programming-in-unity-with-csharp/
│   ├── 05.1-how-scripts-control-gameobjects
│   ├── 05.2-reading-a-unity-script
│   ├── 05.3-variables-and-data
│   ├── 05.4-methods-and-actions
│   ├── 05.5-start-and-update
│   ├── 05.6-making-decisions-with-code
│   ├── 05.7-public-private-and-variable-modifiers
│   ├── 05.8-arrays-lists-and-dictionaries
│   ├── 05.9-connecting-scripts-to-components
│   ├── 05.10-using-the-unity-api-and-documentation
│   ├── 05.11-debug-log-and-reading-error-messages
│   ├── 05.12-null-references-and-missing-objects
│   ├── 05.13-debugging-with-the-console
│   ├── 05.14-naming-comments-and-readable-code
│   ├── 05.15-using-ai-to-understand-and-debug-code
│   ├── 05.16-writing-small-scripts-with-ai-support
│   └── 05.challenge-scripted-behavior
│
├── 06-2d-physics-and-collisions/
│   ├── 06.1-how-physics-changes-gameplay
│   ├── 06.2-rigidbody2d
│   ├── 06.3-collider2d
│   ├── 06.4-gravity-and-forces
│   ├── 06.5-collisions-vs-triggers
│   ├── 06.6-layers-and-collision-rules
│   ├── 06.7-cause-and-effect
│   ├── 06.8-making-physical-rules-feel-consistent
│   └── 06.challenge-physics-playground
│
├── 07-player-movement-and-controls/
│   ├── 07.1-turning-player-input-into-action
│   ├── 07.2-keyboard-touch-and-input-listeners
│   ├── 07.3-moving-left-and-right
│   ├── 07.4-jumping
│   ├── 07.5-checking-when-the-player-is-on-the-ground
│   ├── 07.6-tuning-speed-and-jump-height
│   ├── 07.7-making-controls-feel-responsive
│   ├── 07.8-common-control-patterns
│   ├── 07.9-testing-controls-with-other-players
│   └── 07.project-platformer-movement
│
├── 08-building-a-2d-platformer/
│   ├── 08.1-from-movement-to-a-playable-game
│   ├── 08.2-tilemaps-and-level-building
│   ├── 08.3-platforms-and-environment-collision
│   ├── 08.4-collectibles
│   ├── 08.5-hazards
│   ├── 08.6-checkpoints-and-goals
│   ├── 08.7-score-lives-and-rules
│   ├── 08.8-winning-and-losing
│   ├── 08.9-keeping-track-of-game-state
│   ├── 08.10-testing-the-gameplay-loop
│   └── 08.project-playable-platformer-v1
│
├── 09-cameras-and-player-view/
│   ├── 09.1-how-the-camera-changes-the-experience
│   ├── 09.2-making-the-camera-follow-the-player
│   ├── 09.3-setting-camera-limits
│   ├── 09.4-showing-the-right-information
│   ├── 09.5-smooth-camera-movement
│   ├── 09.6-revealing-and-hiding-information
│   └── 09.challenge-improve-the-platformer-camera
│
├── 10-game-ui-and-player-information/
│   ├── 10.1-what-information-does-the-player-need
│   ├── 10.2-canvas-and-ui-elements
│   ├── 10.3-readable-text-and-game-ui
│   ├── 10.4-score-health-and-status
│   ├── 10.5-showing-what-matters-most
│   ├── 10.6-screen-ui-vs-world-information
│   ├── 10.7-menus-buttons-and-navigation
│   ├── 10.8-responding-to-ui-value-changes-with-code
│   ├── 10.9-showing-players-what-is-happening
│   ├── 10.10-ui-states
│   ├── 10.11-making-game-ui-more-accessible
│   └── 10.project-platformer-ui
│
├── 11-making-games-feel-responsive/
│   ├── 11.1-what-is-game-feel
│   ├── 11.2-immediate-feedback
│   ├── 11.3-animation-as-feedback
│   ├── 11.4-sound-as-feedback
│   ├── 11.5-particles-and-visual-effects
│   ├── 11.6-camera-feedback
│   ├── 11.7-showing-players-what-is-about-to-happen
│   ├── 11.8-feedback-without-overloading-the-player
│   ├── 11.9-comparing-before-and-after
│   └── 11.project-platformer-feel-pass
│
├── 12-level-design-and-player-guidance/
│   ├── 12.1-levels-are-designed-experiences
│   ├── 12.2-teaching-without-explaining-everything
│   ├── 12.3-introduce-practice-challenge
│   ├── 12.4-building-a-difficulty-curve
│   ├── 12.5-pacing-action-and-rest
│   ├── 12.6-helping-players-know-where-to-go
│   ├── 12.7-landmarks-and-environment-clues
│   ├── 12.8-risk-and-reward
│   ├── 12.9-checkpoints-and-progress
│   ├── 12.10-making-challenges-feel-fair
│   └── 12.project-design-a-platformer-level
│
├── 13-designing-for-the-player/
│   ├── 13.1-designing-for-someone-else
│   ├── 13.2-understanding-what-players-need
│   ├── 13.3-showing-players-what-they-can-do
│   ├── 13.4-helping-players-figure-things-out
│   ├── 13.5-showing-players-what-is-happening
│   ├── 13.6-giving-players-the-right-amount-of-information
│   ├── 13.7-making-controls-easier-to-use
│   ├── 13.8-making-games-more-accessible
│   ├── 13.9-difficulty-and-access-options
│   ├── 13.10-giving-players-meaningful-choices
│   └── 13.challenge-player-experience-review
│
├── 14-playtesting-and-player-feedback/
│   ├── 14.1-dont-assume-test-it
│   ├── 14.2-deciding-what-you-want-to-learn
│   ├── 14.3-talking-to-and-watching-players
│   ├── 14.4-giving-players-a-task
│   ├── 14.5-asking-players-to-think-out-loud
│   ├── 14.6-observe-dont-rescue
│   ├── 14.7-what-players-say-vs-what-they-do
│   ├── 14.8-looking-for-patterns
│   ├── 14.9-deciding-what-to-fix-first
│   ├── 14.10-improving-your-game-from-feedback
│   └── 14.project-platformer-playtest-and-v2
│
├── 15-prefabs-and-reusable-game-parts/
│   ├── 15.1-why-reuse-matters
│   ├── 15.2-creating-prefabs
│   ├── 15.3-prefab-instances
│   ├── 15.4-reusable-components
│   ├── 15.5-spawning-gameobjects
│   ├── 15.6-groups-of-gameobjects
│   ├── 15.7-breaking-large-systems-into-smaller-parts
│   ├── 15.8-data-vs-behavior
│   └── 15.project-reusable-game-system
│
├── 16-animation-sound-and-effects/
│   ├── 16.1-animation-clips
│   ├── 16.2-the-animator
│   ├── 16.3-animation-states-and-transitions
│   ├── 16.4-building-a-functional-animation-state-machine
│   ├── 16.5-controlling-the-animator-with-code
│   ├── 16.6-animation-events-and-script-connections
│   ├── 16.7-keyframes-curves-and-tangents
│   ├── 16.8-audio-sources-and-audio-clips
│   ├── 16.9-music-ambience-and-sound-effects
│   ├── 16.10-using-audio-to-give-information
│   ├── 16.11-looking-good-vs-communicating-clearly
│   └── 16.project-feedback-and-presentation-pass
│
├── 17-scenes-progress-and-game-state/
│   ├── 17.1-using-scenes-to-organize-a-game
│   ├── 17.2-start-menus-and-gameplay-scenes
│   ├── 17.3-loading-and-changing-scenes
│   ├── 17.4-keeping-information-between-scenes
│   ├── 17.5-level-progression
│   ├── 17.6-restarting-and-resetting
│   ├── 17.7-pause-and-settings
│   ├── 17.8-how-saving-games-works
│   └── 17.project-multi-scene-game
│
├── 18-interactions-dialogue-and-game-worlds/
│   ├── 18.1-designing-clear-interactions
│   ├── 18.2-interaction-prompts
│   ├── 18.3-npcs-and-dialogue
│   ├── 18.4-keeping-track-of-dialogue
│   ├── 18.5-items-and-inventory
│   ├── 18.6-quests-and-objectives
│   ├── 18.7-hidden-information
│   ├── 18.8-telling-stories-through-the-environment
│   └── 18.project-interactive-world-system
│
├── 19-enemies-and-game-ai/
│   ├── 19.1-what-does-game-ai-mean
│   ├── 19.2-enemies-following-rules
│   ├── 19.3-changing-enemy-behavior
│   ├── 19.4-patrol-chase-and-return
│   ├── 19.5-detection-and-range
│   ├── 19.6-showing-players-what-enemies-will-do
│   ├── 19.7-tuning-enemy-difficulty
│   ├── 19.8-when-simple-rules-create-complex-results
│   └── 19.project-enemy-behavior-system
│
├── 20-moving-from-2d-to-3d/
│   ├── 20.1-adding-the-third-dimension
│   ├── 20.2-x-y-and-z
│   ├── 20.3-sprites-to-3d-objects
│   ├── 20.4-rigidbody2d-to-rigidbody
│   ├── 20.5-collider2d-to-collider
│   ├── 20.6-moving-in-3d
│   ├── 20.7-2d-cameras-vs-3d-cameras
│   ├── 20.8-thinking-in-3d-space
│   ├── 20.9-transfer-not-starting-over
│   └── 20.challenge-rebuild-a-familiar-mechanic-in-3d
│
├── 21-building-3d-worlds/
│   ├── 21.1-primitives-meshes-vertices-faces-and-edges
│   ├── 21.2-importing-3d-assets-fbx-obj-and-textures
│   ├── 21.3-greyboxing-with-primitives-and-low-poly-meshes
│   ├── 21.4-scale-and-proportion
│   ├── 21.5-materials-textures-and-shader-properties
│   ├── 21.6-building-a-3d-environment
│   ├── 21.7-terrain-and-landscape-basics
│   ├── 21.8-directional-point-spot-and-area-lighting
│   ├── 21.9-building-a-clear-and-interesting-game-world
│   ├── 21.10-landmarks-and-wayfinding-in-3d
│   ├── 21.11-designing-levels-in-3d
│   ├── 21.12-rendering-pipeline-concepts
│   └── 21.project-small-3d-environment
│
├── 22-3d-movement-physics-and-cameras/
│   ├── 22.1-moving-a-player-in-3d
│   ├── 22.2-character-movement-vs-physics-movement
│   ├── 22.3-3d-collisions-and-triggers
│   ├── 22.4-moving-relative-to-the-camera
│   ├── 22.5-camera-component-fov-clipping-and-culling
│   ├── 22.6-third-person-cameras
│   ├── 22.7-first-person-and-isometric-views
│   ├── 22.8-camera-control-and-player-comfort
│   ├── 22.9-testing-navigation-in-3d
│   └── 22.project-3d-movement-prototype
│
├── 23-raycasting-and-3d-interactions/
│   ├── 23.1-what-is-a-raycast
│   ├── 23.2-detecting-objects
│   ├── 23.3-interaction-range
│   ├── 23.4-showing-what-the-player-is-targeting
│   ├── 23.5-interaction-prompts
│   ├── 23.6-pickups-switches-and-doors
│   ├── 23.7-making-interactions-clear
│   └── 23.project-3d-interaction-system
│
├── 24-building-more-complex-game-systems/
│   ├── 24.1-resources-and-game-economies
│   ├── 24.2-risk-and-reward
│   ├── 24.3-progression-and-unlocks
│   ├── 24.4-randomness-vs-player-choice
│   ├── 24.5-cooperation-and-competition
│   ├── 24.6-adjusting-difficulty-during-play
│   ├── 24.7-optimization-as-a-game-system
│   ├── 24.8-building-systems-that-affect-each-other
│   ├── 24.9-balancing-connected-systems
│   └── 24.project-system-design-prototype
│
├── 25-careers-in-game-development/
│   ├── 25.1-how-games-get-made
│   ├── 25.2-game-design
│   ├── 25.3-gameplay-programming
│   ├── 25.4-ui-ux-and-player-experience
│   ├── 25.5-level-design
│   ├── 25.6-2d-and-3d-art
│   ├── 25.7-animation-vfx-and-technical-art
│   ├── 25.8-audio-and-sound-design
│   ├── 25.9-writing-and-narrative-design
│   ├── 25.10-qa-and-player-research
│   ├── 25.11-production-and-project-management
│   ├── 25.12-portfolios-and-showing-your-work
│   └── 25.reflection-where-could-i-fit
│
├── 26-testing-debugging-and-improving-games/
│   ├── 26.1-bugs-vs-design-problems
│   ├── 26.2-reproducing-a-bug
│   ├── 26.3-finding-what-caused-the-problem
│   ├── 26.4-debugging-code
│   ├── 26.5-debugging-scenes-and-components
│   ├── 26.6-test-cases-and-unusual-situations
│   ├── 26.7-playtesting-vs-qa
│   ├── 26.8-performance-basics
│   ├── 26.9-accessibility-review
│   ├── 26.10-usability-review
│   ├── 26.11-debugging-with-ai-without-replacing-everything
│   └── 26.project-break-test-fix
│
├── 27-planning-your-own-game/
│   ├── 27.1-start-with-the-player-experience
│   ├── 27.2-who-is-the-game-for
│   ├── 27.3-learning-from-players
│   ├── 27.4-what-should-the-game-feel-like
│   ├── 27.5-core-mechanic-and-gameplay-loop
│   ├── 27.6-looking-at-similar-games
│   ├── 27.7-paper-and-digital-prototypes
│   ├── 27.8-testing-the-biggest-question-first
│   ├── 27.9-must-have-nice-to-have-stretch-goals
│   ├── 27.10-keeping-the-project-realistic
│   ├── 27.11-roles-milestones-and-team-planning
│   └── 27.project-capstone-prototype
│
└── 28-capstone-build-your-own-game/
    ├── 28.1-game-idea-and-target-player
    ├── 28.2-research-and-inspiration
    ├── 28.3-goals-and-success-criteria
    ├── 28.4-core-loop-and-system-map
    ├── 28.5-scope-and-feature-priorities
    ├── 28.6-technical-plan
    ├── 28.7-player-flow-and-interface
    ├── 28.8-build-the-core-mechanic
    ├── 28.9-build-the-smallest-playable-version
    ├── 28.10-test-and-debug
    ├── 28.11-playtest-with-players
    ├── 28.12-study-what-happened
    ├── 28.13-decide-what-to-change
    ├── 28.14-build-v2
    ├── 28.15-improve-game-feel-and-presentation
    ├── 28.16-accessibility-and-usability-review
    ├── 28.17-final-testing-and-polish
    ├── 28.18-publish-and-present
    ├── 28.19-explain-your-design-and-code-choices
    ├── 28.20-document-important-ai-assisted-work
    ├── 28.21-postmortem-and-reflection
    └── 28.final-game
```

------------------------------------------------------------------------

# Course Phases

## Phase 1: Game Design and Programming Foundations

**Modules 00--03**

Approximate duration: first four weeks.

Students learn:

-   what makes games work
-   rules and goals
-   core gameplay loops
-   input and feedback
-   variables
-   state
-   decisions
-   collisions
-   randomness
-   functions
-   debugging
-   playtesting
-   iteration

MakeCode Arcade provides a lower-complexity environment so students can
focus on programming and game-design ideas before learning Unity.

## Phase 2: Learning Unity Through 2D

**Modules 04--14**

Students transfer familiar game concepts into Unity.

A 2D platformer should act as an anchor project that grows over time.

Possible progression:

1.  character appears
2.  character moves
3.  character jumps
4.  platforms collide
5.  camera follows
6.  collectibles work
7.  hazards work
8.  score or status appears
9.  winning and losing work
10. sound and feedback are added
11. level design is improved
12. another player tests the game
13. student revises from evidence

## Phase 3: Building Larger Game Systems

**Modules 15--19**

Students move beyond the basic platformer and learn reusable systems
such as:

-   prefabs
-   spawning
-   animation
-   sound
-   scenes
-   progression
-   dialogue
-   inventory concepts
-   objectives
-   enemies
-   simple game AI

## Phase 4: Moving from 2D into 3D

**Modules 20--23**

The course should explicitly connect new 3D ideas to familiar 2D
concepts.

Examples:

  2D Concept        3D Connection
  ----------------- ---------------------------
  Sprite            Mesh / 3D object
  Rigidbody2D       Rigidbody
  Collider2D        Collider
  X/Y position      X/Y/Z position
  2D trigger        3D trigger
  2D camera         Perspective or 3D camera
  2D interaction    Raycast-based interaction
  2D level layout   3D spatial level design

The message should be:

> You are transferring what you know, not starting over.

## Phase 5: Independent Game Development

**Modules 24--28**

Students analyze and build more connected systems, learn about careers
and professional practice, plan a realistic project, prototype it, build
it, test it, revise it, and present it.

------------------------------------------------------------------------

# Threads Throughout the Course

These concepts should not live in only one module. They should appear
repeatedly in lessons, projects, Game of the Week reflections,
critiques, testing, and capstone work.

## Thread 1: Programming and Computational Thinking

Students should repeatedly practice:

-   decomposition
-   pattern recognition
-   abstraction
-   algorithmic thinking
-   cause and effect
-   state tracking
-   debugging
-   iteration
-   testing
-   transfer
-   systems thinking
-   independent problem solving

Recurring questions:

-   What is the game doing?
-   What information does the game need to remember?
-   What causes this behavior?
-   What can we break into smaller parts?
-   What pattern is repeating?
-   What can be reused?
-   What did we expect to happen?
-   What actually happened?
-   What can we change and test?

------------------------------------------------------------------------

# Thread 2: Unity Development

Students gradually develop fluency with:

-   scenes
-   GameObjects
-   components
-   hierarchy
-   Inspector
-   transforms
-   sprites
-   C#
-   Rigidbody2D
-   Collider2D
-   Tilemaps
-   input
-   cameras
-   Canvas UI
-   prefabs
-   animation
-   audio
-   particle effects
-   game state
-   scene management
-   interaction systems
-   enemy systems
-   3D meshes
-   materials
-   lighting
-   Rigidbody
-   Collider
-   3D movement
-   raycasting

Students should continually connect new Unity tools to problems they are
trying to solve.

------------------------------------------------------------------------

# Thread 3: Game Design

Game design should be treated as a major academic strand.

## Foundational Game Concepts

Students should understand:

### Goal

What the player is trying to accomplish.

### Rules

What determines what can and cannot happen.

### Constraints

Limits that shape player choices.

### Mechanics

Actions and systems the player interacts with.

### Core Mechanic

The most important repeated action in a game.

### Gameplay Loop

The repeated cycle of actions and responses that drives play.

### Feedback

How the game communicates the results of player actions.

### Game State

Information the game must remember at a particular moment.

## Player Experience Concepts

Students should explore:

-   challenge
-   difficulty
-   fairness
-   flow
-   pacing
-   tension
-   reward
-   player choice
-   anticipation
-   feedback
-   readability
-   discoverability
-   onboarding
-   wayfinding
-   game feel
-   risk and reward

## Systems Concepts

Students should explore:

-   cause and effect
-   probability
-   randomness
-   hidden information
-   turn structure
-   pattern systems
-   resource flow
-   progression
-   cooperation
-   competition
-   optimization
-   emergence
-   simulation
-   interconnected systems

## Design Questions

Students should routinely ask:

-   What does the player do most often?
-   Why is that action interesting?
-   What makes the game difficult?
-   What information does the player have?
-   What information is hidden?
-   What choices matter?
-   What feedback does the player receive?
-   Is success based on skill, strategy, randomness, information, or
    some combination?
-   What happens if one rule changes?
-   Does the game stay balanced?
-   Is failure understandable?
-   What makes the player want to continue?

------------------------------------------------------------------------

# Thread 4: Player Experience, UI, and Usability

A central course question should be:

> How does the player know?

Students should analyze:

-   how players know what they can interact with
-   how players know where to go
-   how players know whether they succeeded
-   how players know why they failed
-   how players understand health, score, goals, inventory, or progress
-   whether controls match player expectations
-   whether important information is easy to notice
-   whether feedback is strong enough
-   whether the game gives too much information at once
-   whether interface elements are readable and understandable

## Common Game UI Patterns

Students should encounter:

-   HUDs
-   health bars
-   score displays
-   timers
-   inventories
-   objective displays
-   menus
-   pause screens
-   settings
-   dialogue boxes
-   interaction prompts
-   tooltips
-   cooldown indicators
-   maps or minimaps
-   quest logs
-   win/loss screens
-   loading states
-   locked/disabled states

Students should discuss not only how to build these but when they are
useful.

------------------------------------------------------------------------

# Thread 5: Accessibility

Accessibility should be introduced as part of designing a usable game.

Students should consider:

-   readable text
-   font size
-   color contrast
-   not relying only on color
-   captions and subtitles
-   volume controls
-   clear controls
-   remappable-control concepts
-   difficulty options
-   motion considerations
-   understandable UI
-   visual and audio feedback
-   multiple ways to communicate important information

Students do not need to become accessibility specialists, but they
should develop the habit of asking:

> Who might have difficulty using this, and what could make it easier?

------------------------------------------------------------------------

# Thread 6: Player Research, Playtesting, and Iteration

Students should learn that making games requires evidence, not only
personal opinion.

## Player Research

Research asks:

> What do players understand, expect, want, struggle with, or
> experience?

High-school-appropriate activities include:

-   short interviews
-   observation
-   simple surveys
-   looking at how players use similar games
-   asking about control expectations
-   identifying common frustrations
-   comparing different interface approaches

## Playtesting

Playtesting asks:

> What happens when somebody actually plays this game?

Students should watch for:

-   confusion
-   hesitation
-   missed information
-   repeated mistakes
-   unexpected strategies
-   places where players get lost
-   places where players stop having fun
-   moments where the player succeeds without understanding why
-   interactions players expect but cannot perform

## QA

QA asks:

> Does the game technically work as intended?

Students should learn to distinguish:

### Bug

Something is technically not working as intended.

### Usability Problem

The game works, but the player cannot understand or use it easily.

### Game Design Problem

The rules or systems create an unwanted experience.

### Preference

A player personally likes or dislikes something.

These should not automatically be treated as the same kind of feedback.

------------------------------------------------------------------------

# Thread 7: Communication and Collaboration

Students should practice:

-   explaining how a system works
-   explaining why they made a design choice
-   describing a bug clearly
-   writing useful comments
-   giving peer feedback
-   receiving critique
-   documenting playtest observations
-   discussing evidence
-   presenting a game
-   explaining technical choices
-   explaining design changes
-   reflecting on teamwork

Students working in groups should learn to separate roles while still
understanding the whole project.

------------------------------------------------------------------------

# Thread 8: Careers and Professional Practice

Career exploration should happen throughout the course rather than only
inside Module 25.

## Career Spotlights by Topic

### Programming Lessons

-   Gameplay Programmer
-   Tools Programmer
-   AI Programmer
-   UI Programmer

### Level Design

-   Level Designer
-   World Designer

### UI and Player Experience

-   UI Designer
-   UX Designer
-   Games User Researcher
-   Accessibility Specialist

### Art and Presentation

-   Concept Artist
-   2D Artist
-   Environment Artist
-   Character Artist
-   3D Modeler
-   Animator
-   Technical Artist
-   VFX Artist

### Audio

-   Sound Designer
-   Composer
-   Audio Programmer

### Story and Dialogue

-   Game Writer
-   Narrative Designer

### Testing

-   QA Tester
-   QA Analyst
-   Test Engineer
-   User Researcher

### Planning and Teamwork

-   Producer
-   Project Manager
-   Product Manager

Students should also discuss indie development, where one person may
perform several of these roles.

## Career Reflection Questions

-   What does this person actually do?
-   What problems do they solve?
-   Who do they work with?
-   What tools do they use?
-   What skills matter most?
-   What would appear in their portfolio?
-   Where have we practiced something similar?
-   Would I enjoy this kind of work?

------------------------------------------------------------------------

# Thread 9: Certification Alignment

Certification should support the course's authentic game-development
progression rather than replace it.

## Credential 1: Unity Certified User Programmer --- Required

All students should receive instruction, repeated practice, readiness
feedback, targeted review, and a supported opportunity to prepare for
and attempt the Unity Certified User Programmer credential.

The certification expects students to demonstrate foundational C#
programming within Unity, including debugging, API interpretation,
creating code, evaluating code, Unity interface knowledge, and
state-machine work.

### Programmer Area 1: Debugging, Problem-Solving, and Interpreting the API

Students should become Certification Ready with:

-   creating and interpreting `Debug.Log` messages
-   reading error messages
-   identifying null-object problems
-   isolating bugs
-   using Unity documentation and API references
-   identifying appropriate methods, properties, arguments, and syntax
-   testing one change at a time
-   using AI as a debugging and explanation tool without surrendering
    responsibility for the solution

Primary modules:

-   04 Getting Started with Unity 2D
-   05 Programming in Unity with C#
-   17 Scenes, Progress, and Game State
-   26 Testing, Debugging, and Improving Games
-   28 Capstone

### Programmer Area 2: Creating Code

Students should become Certification Ready with:

-   initializing and using variables
-   variable modifiers
-   arrays
-   Lists
-   Dictionaries
-   function declarations
-   parameters and reusable behavior
-   functions that control or trigger state
-   keyboard input
-   touch-input concepts and listeners
-   logic and flow-control operators
-   responding to UI changes

Primary modules:

-   05 Programming in Unity with C#
-   07 Player Movement and Controls
-   08 Building a 2D Platformer
-   10 Game UI and Player Information
-   12--19 larger systems
-   22--24 3D and complex systems

### Programmer Area 3: Evaluating Code

Students should become Certification Ready with:

-   determining appropriate event-function behavior
-   reading unfamiliar code
-   finding incorrect data types
-   identifying incorrect function or variable declarations
-   understanding public/private mismatches
-   recognizing appropriate naming conventions
-   evaluating comments for accuracy
-   recognizing class structures at the level expected by the
    certification
-   connecting Animation events and scripts

Primary modules:

-   05 Programming in Unity with C#
-   16 Animation, Sound, and Effects
-   26 Testing, Debugging, and Improving Games

The course should include regular code-reading tasks, not only
code-writing tasks.

### Programmer Area 4: Navigating the Interface and State Machines

Students should become Certification Ready with:

-   identifying the purpose of major Unity windows
-   understanding the scripting IDE workflow
-   changing or identifying the default scripting IDE
-   creating functional animation state machines
-   using the Animator Controller
-   connecting code to Animator state

Primary modules:

-   04 Getting Started with Unity 2D
-   16 Animation, Sound, and Effects

------------------------------------------------------------------------

## Credential 2: Unity Certified User Artist --- Progress Credential

Students should make meaningful progress toward the Unity Certified User
Artist objectives through normal game-development projects.

Students who demonstrate sufficient readiness or interest should be
strongly encouraged and supported to attempt the Artist credential, but
**completion is not required for every student**.

The Artist objectives provide useful breadth because game programmers
still benefit from understanding how visual assets, scenes, materials,
cameras, lighting, and animation work.

### Artist Area 1: Asset Management

Students should encounter and practice:

-   importing FBX and OBJ assets
-   working with associated textures
-   importing and configuring Asset Store assets
-   slicing spritesheets
-   9-slicing
-   identifying vertices, polygon faces, and edges
-   creating animation keyframes
-   changing tangents in the Curve Editor
-   creating, modifying, and using Prefabs

Primary modules:

-   04 Getting Started with Unity 2D
-   15 Prefabs and Reusable Game Parts
-   16 Animation, Sound, and Effects
-   20 Moving from 2D to 3D
-   21 Building 3D Worlds

### Artist Area 2: Scene Content Design

Students should encounter and practice:

-   Transform tools
-   Transform components
-   prototype scenes
-   white-box / grey-box techniques
-   Unity primitives
-   low-poly meshes
-   Terrain
-   basic landscape materials
-   texture painting concepts

Primary modules:

-   04 Getting Started with Unity 2D
-   12 Level Design and Player Guidance
-   20 Moving from 2D to 3D
-   21 Building 3D Worlds
-   27--28 capstone planning and production

### Artist Area 3: Lighting, Cameras, and Materials

Students should encounter and practice:

-   material properties
-   albedo
-   transparency
-   normal information
-   specular concepts
-   shadows
-   light settings
-   directional lights
-   point lights
-   spot lights
-   area-light concepts
-   camera components
-   field of view
-   clipping planes
-   culling masks
-   standard and isometric views
-   basic rendering-pipeline decisions

Primary modules:

-   09 Cameras and Player View
-   20 Moving from 2D to 3D
-   21 Building 3D Worlds
-   22 3D Movement, Physics, and Cameras
-   28 Capstone

------------------------------------------------------------------------

# Certification Support Model

## Level 1: Learn It Through Game Development

Students first encounter certification skills while solving an
understandable game-development problem.

Example:

> Make the player respond to keyboard input.

The immediate focus is creating responsive player control.

## Level 2: Reinforce It Through Projects

The same technical skill reappears in new contexts.

Input might later control:

-   menus
-   interactions
-   movement
-   dialogue
-   tools
-   3D navigation

## Level 3: Name the Certification Connection

Once students understand the skill, explicitly introduce the
certification terminology.

Example:

> **Unity Programmer Connection:** input listener, event function,
> keyboard input.

## Level 4: Short Certification Checks

Distributed practice should ask students to:

-   read unfamiliar C#
-   identify what a code sample does
-   locate an error
-   interpret an error message
-   choose an API method or property
-   recognize naming conventions
-   identify accurate comments
-   interpret Unity interface scenarios
-   predict state-machine behavior

These should remain short and should complement project work.

## Level 5: Certification Readiness Review

Before the required Programmer certification, students use:

-   objective-by-objective checklist
-   diagnostic assessment
-   targeted practice by weak objective
-   mixed code-reading practice
-   debugging practice
-   Unity interface review
-   state-machine review
-   certification vocabulary review
-   timed practice when appropriate

For Unity Artist, the same system can identify students who have
accumulated enough progress to make an additional certification attempt
worthwhile.

------------------------------------------------------------------------

# Recommended Certification Timing

## Required: Unity Certified User Programmer

The Programmer certification should occur after students have
substantial experience with:

-   Unity interface and workflow
-   C# variables and collections
-   functions
-   input
-   logic and flow control
-   UI events
-   debugging
-   API documentation
-   code evaluation
-   public/private behavior
-   naming and comments
-   Animator state machines

The exact point can remain flexible so certification preparation does
not interrupt a major project cycle.

The certification source recommends substantial hands-on Unity
experience, so the course should prioritize repeated use of these skills
rather than rushing students to the exam.

## Progress Credential: Unity Certified User Artist

Artist progress should accumulate across 2D and 3D development.

A later readiness check can identify students who have sufficient
experience with:

-   assets
-   sprites
-   Prefabs
-   animation
-   Transform tools
-   greyboxing
-   meshes
-   Terrain
-   materials
-   lighting
-   cameras
-   rendering concepts

Students who are ready should be strongly encouraged to attempt the
Artist credential.

Students who are not yet ready should still finish with visible,
documented progress toward its objectives.

------------------------------------------------------------------------

# Certification Objective Mapping

## Required Unity Programmer Credential

  -----------------------------------------------------------------------
  Certification Area      Primary Modules         Intended Status
  ----------------------- ----------------------- -----------------------
  Debug logs              05, 26                  Certification Ready

  Null-object debugging   05, 26                  Certification Ready

  API methods,            05, 15--24              Certification Ready
  properties, arguments,                          
  syntax                                          

  Variables and modifiers 05                      Certification Ready

  Arrays, Lists,          05, 12--19              Certification Ready
  Dictionaries                                    

  Function declarations   05, 15--19              Certification Ready

  Functions controlling   08, 16, 17, 19          Certification Ready
  state                                           

  Keyboard and touch      07                      Certification Ready
  input                                           

  Logic and flow control  05, 08, 19, 24          Certification Ready

  Responding to UI        10                      Certification Ready
  changes                                         

  Event functions         07, 10, 16, 18          Certification Ready

  Data-type errors        05, 26                  Certification Ready

  Public/private          05, 16, 26              Certification Ready
  declaration problems                            

  Animation events        16                      Certification Ready

  Naming conventions      05, 26                  Certification Ready

  Accurate comments       05, 26                  Certification Ready

  Class recognition / ECS 24 / targeted           Certification Ready
  awareness               certification review    

  Unity IDE windows       04                      Certification Ready

  Scripting IDE           04                      Certification Ready
  configuration                                   

  Functional state        16, 19                  Certification Ready
  machines                                        

  Animator Controller     16                      Certification Ready
  scripting                                       
  -----------------------------------------------------------------------

## Unity Artist Progress Credential

  Certification Area                    Primary Modules           Intended Status
  ------------------------------------- ------------------------- -----------------
  FBX/OBJ and texture import            21                        Taught
  Asset Store import/configuration      04, 21                    Reinforced
  Spritesheet slicing and 9-slicing     04                        Reinforced
  Vertices, faces, edges                20, 21                    Taught
  Keyframes and Curve Editor tangents   16                        Reinforced
  Prefabs                               15                        Reinforced
  Transform tools                       04, 20, 21                Reinforced
  Greyboxing                            12, 21, 27                Reinforced
  Terrain and landscape materials       21                        Taught
  Material properties                   21                        Reinforced
  Lighting and shadows                  21                        Reinforced
  Camera setup and properties           09, 22                    Reinforced
  Rendering-pipeline choice             21 / targeted extension   Taught

Students interested in art, environment design, technical art,
animation, or broader Unity production can receive targeted extensions
that move more of these objectives toward **Certification Ready**.

------------------------------------------------------------------------

# Thread 10: AI-Assisted Game Development

AI-assisted development becomes a formal recurring thread once students
enter Unity.

The purpose is not to have AI make the game for the student. The purpose
is to teach students how to use a modern development tool to **learn,
investigate, debug, build, test, and extend their own understanding**.

This is especially important in a choice-driven game-development course
because students will eventually want to create systems that have not
been directly demonstrated in class.

The course should help students move from:

> I cannot build that because we have not learned it.

toward:

> I have not learned that yet. What do I need to understand, and how can
> I test my way toward a solution?

## Core AI Workflow: Ask → Understand → Build → Test → Explain

### 1. Ask

Students should provide useful context rather than asking AI to guess.

Weak:

> My jump does not work. Fix it.

Stronger:

> I am making a 2D platformer in Unity using C#. My player has a
> Rigidbody2D and Collider2D. Horizontal movement works, but pressing
> Space does not make the player jump. Here is my PlayerMovement script.
> Help me figure out what might be wrong. Explain what I should check
> before rewriting the code.

Useful debugging context can include:

-   intended behavior
-   actual behavior
-   relevant script
-   exact Console error
-   GameObject components
-   Inspector settings
-   Rigidbody settings
-   Collider settings
-   tags and layers
-   what has already been tried

### 2. Understand

Students should ask follow-up questions until they can reasonably
explain the proposed solution.

Useful prompts include:

> Explain this like I am learning Unity.

> Which part checks whether the player is touching the ground?

> Why do we need this variable?

> What does this method do?

> Which Unity component does this script depend on?

> What would happen if I removed this line?

> Which part is C# and which part is specific to Unity?

Students do not need to memorize every line of code. They should
understand the major parts and how the system works.

### 3. Build

Students should use AI to build in small pieces.

Instead of:

> Make my platformer.

Prefer:

> Left and right movement already works. I want to add jumping next.
> Help me add only the jumping behavior and explain what I need to set
> up in Unity.

Then:

> Jumping works. Now help me prevent the player from jumping again while
> already in the air.

This reinforces decomposition.

### 4. Test

AI-generated code is a hypothesis, not an answer key.

Students should:

1.  predict what should happen
2.  run the game
3.  observe what actually happens
4.  check the Console
5.  test unusual situations
6.  change one thing at a time
7.  compare the result with the prediction

Useful questions include:

> What else could break this?

> What edge cases should I test?

> How can I tell whether this is actually fixed?

### 5. Explain

Students remain responsible for the systems in their projects.

At an appropriate level, students should be able to explain:

-   what the script is supposed to do
-   which GameObject uses it
-   what important variables store
-   what major methods do
-   which components the script depends on
-   what triggers the behavior
-   what they changed
-   how they tested it

The course boundary should be:

> **AI can help you build it. You still need to understand what you
> built.**

------------------------------------------------------------------------

## AI for Planning Scripts and Features

Before asking for code, students should describe the system.

### OBJECT

What GameObject is this controlling?

### TRIGGER

What causes something to happen?

### CONDITION

What needs to be true?

### ACTION

What should happen?

### DATA

What information needs to be remembered?

Example:

``` text
OBJECT: Coin
TRIGGER: Player touches the coin
CONDITION: The object touching it is the player
ACTION: Add one point and remove the coin
DATA: Player score
```

Students can then turn that system description into an AI request.

This makes AI use reinforce computational thinking rather than bypass
it.

For larger features, students should ask AI to decompose the idea before
generating code.

Example:

> I want an NPC who gives the player a quest to collect five crystals.
> Do not write the full code yet. Break the feature into smaller systems
> and tell me what I would need to build.

A useful decomposition might identify:

1.  NPC interaction
2.  dialogue
3.  quest state
4.  crystal collectibles
5.  collectible counter
6.  completion check
7.  updated NPC response
8.  reward
9.  player feedback

Students can then decide what they already know, what they need to
learn, and what should be built first.

------------------------------------------------------------------------

## AI for Debugging

Debugging should be one of the earliest and most frequent uses of AI.

Students should learn that a Unity problem may come from:

-   code
-   a missing component
-   Inspector settings
-   object references
-   tags
-   layers
-   colliders
-   Rigidbody settings
-   script placement
-   scene setup
-   animation state
-   input configuration

Students should therefore learn to ask for diagnostic help before asking
AI to rewrite a script.

Example:

> My collectible should disappear when the player touches it, but
> nothing happens. There are no Console errors. Before changing my code,
> give me a checklist of things I should inspect in Unity.

### AI Debugging Ladder

1.  **Observe:** What exactly is happening?
2.  **Predict:** What should be happening?
3.  **Inspect:** Check the Console, Inspector, components, references,
    tags, layers, and relevant code.
4.  **Isolate:** Which system appears to be causing the problem?
5.  **Ask AI to Explain:** Provide evidence and ask what it suggests.
6.  **Test One Change:** Make the smallest useful change.
7.  **Re-Test:** Did the behavior change?
8.  **Ask for Code if Needed:** Modify or create only the relevant
    piece.

The course should discourage:

> Does not work → paste everything into AI → replace everything.

------------------------------------------------------------------------

## AI for Reading Errors

Students should learn to provide the exact error.

Instead of:

> It does not work.

Use:

> Unity gives me this error: \[error message\]. Explain what it means in
> simple language. Do not fix it yet. Tell me what information I should
> look for in my script.

Then the student can provide the relevant code and continue
troubleshooting.

------------------------------------------------------------------------

## AI for Filling Knowledge Gaps

AI should help students continue learning when their project reaches
beyond the exact examples taught in class.

Examples:

> I know how Collider2D works, but I have not learned raycasting yet.
> Explain the basic idea and show me how it could help a player interact
> with an object.

> I want a door to open after the player collects three keys. What
> concepts would I need to understand?

> I want enemies to patrol between two locations. Do not write the
> script yet. Break this into smaller programming problems.

This is particularly important for Design Challenge and Build Your Own
projects.

------------------------------------------------------------------------

## AI for Player Experience and Playtesting

AI can help students think through observations, but it cannot replace
observing real players.

Students should gather evidence first.

AI may then help them:

-   organize observations
-   identify possible patterns
-   brainstorm possible solutions
-   compare interface approaches
-   generate follow-up questions
-   consider edge cases

Students remain responsible for deciding whether an AI interpretation
actually matches their evidence.

------------------------------------------------------------------------

## AI Failure Modes

Students should explicitly learn that AI can:

-   misunderstand the problem
-   produce outdated Unity code
-   use APIs from another Unity version
-   invent methods or properties
-   make unnecessary changes
-   produce overly complicated solutions
-   solve a different problem
-   introduce new bugs
-   remove working functionality
-   produce code the student cannot maintain

Therefore:

> **AI output is something to investigate and test, not automatically
> trust.**

------------------------------------------------------------------------

## AI Skill Progression Across the Unity Course

### Module 04: Getting Started with Unity 2D

Students learn:

-   what AI can and cannot see about a Unity project
-   how to describe project setup
-   how to ask conceptual questions
-   how to explain unfamiliar Unity terminology

### Module 05: Programming in Unity with C

Students learn:

-   asking AI to explain code
-   identifying variables and methods
-   distinguishing C# from Unity-specific concepts
-   generating small scripts
-   modifying one behavior at a time
-   debugging with AI support

### Modules 06--07: Physics, Collisions, Movement, and Controls

Students practice:

-   describing component setups
-   checking Inspector settings
-   distinguishing setup problems from code problems
-   generating troubleshooting checklists
-   tuning values
-   comparing possible solutions

### Modules 08--12: Platformer Development

Students practice:

-   breaking features into smaller systems
-   adding small pieces of code
-   debugging interactions
-   asking for edge cases
-   improving code without replacing everything
-   exploring unfamiliar features

### Modules 13--14: Player Experience and Playtesting

Students learn:

-   AI cannot substitute for real player observation
-   evidence should be collected before interpretation
-   AI can help organize findings or brainstorm possible revisions

### Modules 15--24: Larger Systems and 3D

Students increasingly use AI to:

-   investigate Unity APIs
-   learn unfamiliar systems
-   compare implementation strategies
-   refactor code
-   debug systems that interact
-   transfer 2D knowledge into 3D
-   pursue more individualized project ideas

### Modules 27--28: Independent Game Development

AI becomes part of the student's independent development workflow.

For important AI-assisted work, students should be able to document:

-   What were you trying to build?
-   What did you ask AI?
-   What did AI help you understand or create?
-   What did you change?
-   How did you test it?
-   Can you explain the final system?

------------------------------------------------------------------------

## AI and Assessment

Using AI should not automatically reduce a student's demonstrated
mastery.

Assessment should focus on whether the student can:

-   describe the problem
-   break it into parts
-   use AI intentionally
-   evaluate the response
-   test the result
-   debug problems
-   modify the solution
-   explain the final system
-   transfer the idea to another situation

A student who uses AI effectively while demonstrating understanding can
show meaningful computational thinking and professional problem-solving.

# Game of the Week Integration

Game of the Week should remain its own folder containing
mini-instruction and reflection activities.

Example structure:

``` text
game-development/
│
├── unity-course/
│   └── ...
│
└── game-of-the-week/
    ├── week-01-telephone/
    │   ├── mini-lesson
    │   └── reflection
    ├── week-02-pass-the-clap/
    │   ├── mini-lesson
    │   └── reflection
    └── ...
```

The concepts introduced through Game of the Week should then reappear
inside Unity lessons and projects.

------------------------------------------------------------------------

# Game of the Week Concept Map

## Quarter 1: Rules, Communication, and Core Game Systems

### Telephone

**Focus:** Information transfer and breakdown points

Connections: - communication - information loss - player assumptions -
instructions - feedback

### Pass the Clap

**Focus:** Turn-taking and pacing

Connections: - timing - player attention - rhythm - turn structures

### Zip Zap Zop

**Focus:** Core loop and flow

Connections: - repeated actions - player response - gameplay loops -
pacing

### Rock-Paper-Scissors

**Focus:** Balance and probability

Connections: - fairness - player choice - probability - symmetrical
systems

### RPS Tournament

**Focus:** Systems from simple mechanics

Connections: - tournament structure - progression - repeated systems -
simple rules producing larger experiences

### Ninja

**Focus:** Spatial rules and constraints

Connections: - position - movement - space - legal actions - player
planning

### Red Light, Green Light

**Focus:** Rule enforcement and fairness

Connections: - game rules - judging outcomes - clear failure
conditions - fairness

### Simon Says

**Focus:** Rule clarity and UX

Connections: - instructions - player expectations - errors -
understandable rules - interface clarity

### Mafia / Werewolf

**Focus:** Hidden information and deduction

Connections: - incomplete information - player roles - social systems -
deduction - deception

------------------------------------------------------------------------

# Quarter 2: Patterns, State, Probability, and Information

### Set

**Focus:** Pattern systems

Connections: - pattern recognition - visual rules - combinations

### Ghost

**Focus:** Constraints and turn structure

Connections: - legal moves - state - future consequences - turn systems

### Spoons

**Focus:** Escalation and tension

Connections: - pacing - signals - changing intensity - player awareness

### Liar's Dice

**Focus:** Probability and bluffing

Connections: - uncertainty - incomplete information - probability -
player psychology

### Pictionary Telephone

**Focus:** Multimodal communication

Connections: - visual communication - interpretation - information
loss - feedback

### Uno

**Focus:** Randomness and pacing

Connections: - random events - turn order - hand management - changing
momentum

### Dobble / Spot It!

**Focus:** Algorithmic generation

Connections: - patterns - combinations - systems - procedural thinking

### Charades

**Focus:** Nonverbal systems

Connections: - communication without text - feedback - interpretation -
constraints

### Memory / Concentration

**Focus:** State tracking

Connections: - hidden state - memory - information revealed over time

### Battleship

**Focus:** Deduction and grids

Connections: - coordinates - hidden information - probability - spatial
reasoning

### Tic-Tac-Toe + Variants

**Focus:** Solved games and balance

Connections: - strategy - predictable systems - rule modification - win
conditions

------------------------------------------------------------------------

# Quarter 3: Strategy, Resources, Cooperation, and Systems

### Connect Four

**Focus:** Emergent strategy

Connections: - simple rules - planning - patterns - strategy developing
from interaction

### Blokus

**Focus:** Territory control

Connections: - spatial systems - blocking - resource use - planning

### Mancala

**Focus:** Resource flow

Connections: - moving resources - accumulation - planning - system
effects

### Domino Rally

**Focus:** Sequencing and cause/effect

Connections: - chain reactions - order - timing - dependencies

### Jenga

**Focus:** Physical systems

Connections: - balance - risk - structural consequences - physics

### Forbidden Island

**Focus:** Cooperative mechanics

Connections: - teamwork - shared goals - role coordination - system
pressure

### Sushi Go

**Focus:** Drafting and probability

Connections: - limited choices - prediction - probability - resource
selection

### Kingdomino

**Focus:** Optimization

Connections: - scoring systems - tradeoffs - spatial planning -
maximizing outcomes

### Codenames

**Focus:** Semantics and clue systems

Connections: - language - shared interpretation - information - risk

### Keep Talking & Nobody Explodes

**Focus:** Communication protocols

Connections: - role separation - clear instructions - information
asymmetry - teamwork

------------------------------------------------------------------------

# Quarter 4: Input, Environments, Adaptation, and Advanced Systems

### Snake

**Focus:** Input systems and loops

Connections: - repeated updates - movement - input - state - collision

### GeoGuessr

**Focus:** Environmental storytelling

Connections: - visual clues - world design - landmarks - observation -
environment as information

### Quick, Draw!

**Focus:** Machine-learning pattern recognition

Connections: - classification - pattern recognition - training data -
human/computer interpretation

### Mario Kart

**Focus:** Rubber-banding

Connections: - dynamic difficulty - fairness - competition - keeping
players engaged

### Mini Metro

**Focus:** Optimization systems

Connections: - resource management - networks - efficiency - increasing
complexity

### Overcooked

**Focus:** Coordination and UX stress

Connections: - communication - cognitive load - time pressure - role
coordination - intentional friction

### Among Us

**Focus:** Social deduction

Connections: - hidden roles - information - trust - deception - group
behavior

### Universal Paperclips

**Focus:** Simulation and exponential systems

Connections: - feedback loops - growth - resource systems - automation -
unintended consequences

### Final Game Jam Warm-Up

**Focus:** Mechanic redesign

Connections: - iteration - remixing - changing rules - testing new
experiences - creative transfer

------------------------------------------------------------------------

# Connecting Game of the Week to Unity Lessons

Game of the Week should not feel separate from the technical course.

Example:

``` text
Related Game Design Concept:
Balance

Think Back:
What happened when we changed the rules of Rock-Paper-Scissors?

Unity Connection:
You are about to change enemy speed and player health.
How could those values change the balance of your game?
```

Another example:

``` text
Related Game Design Concept:
State Tracking

Think Back:
What information did players need to remember during Memory?

Unity Connection:
Your game needs to keep track of score, health, and whether a collectible
has already been collected.
```

Another:

``` text
Related Game Design Concept:
Environmental Storytelling

Think Back:
What clues helped you make guesses in GeoGuessr?

Unity Connection:
How can the environment tell players where they are, where to go,
or what happened without putting everything into text?
```

------------------------------------------------------------------------

# Recurring Game Design Analysis Framework

Students should have a simple framework they can use repeatedly.

## PLAYER

Who is playing?

What do they already know?

## GOAL

What are they trying to accomplish?

## ACTIONS

What can they do?

## RULES

What determines what happens?

## INFORMATION

What does the player know?

What is hidden?

## FEEDBACK

How does the game show what happened?

## CHALLENGE

What makes success difficult?

## SYSTEM

How do different rules or mechanics affect each other?

## EXPERIENCE

What kind of experience does this create?

## EVIDENCE

What did we actually observe when people played?

As students become more experienced, they can use professional
vocabulary alongside these questions.

------------------------------------------------------------------------

# Professional Vocabulary Strategy

Professional terms should still be taught, but they do not always need
to appear in lesson titles.

Examples:

  ---------------------------------------------------------------------
  Student-Friendly Idea              Professional Vocabulary
  ---------------------------------- ----------------------------------
  The Gameplay Loop                  core loop

  Showing Players What They Can Do   affordance, signifier

  Helping Players Figure Things Out  discoverability

  Giving Players the Right Amount of cognitive load
  Information                        

  Giving Players Meaningful Choices  player agency

  Showing Players What Is About to   telegraphing
  Happen                             

  When Simple Rules Create Complex   emergent behavior
  Results                            

  Adjusting Difficulty During Play   dynamic difficulty, rubber-banding

  Building Systems That Affect Each  interconnected systems
  Other                              

  Planning Before You Build          preproduction

  Explaining Your Design Choices     design rationale
  ---------------------------------------------------------------------

------------------------------------------------------------------------

# Project Philosophy

Project names in the map are examples and anchors, not mandatory
permanent assignments.

Projects should prioritize:

-   clear skill targets
-   student choice
-   manageable scope
-   game-design reasoning
-   player experience
-   testing
-   revision
-   communication
-   accessibility
-   technical quality

------------------------------------------------------------------------

# Project Pathways

## Guided Build

Best for students who need more structure.

Includes:

-   starter project
-   clear steps
-   example code
-   screenshots
-   checkpoints
-   debugging support
-   required reflection

## Design Challenge

Students receive:

-   required systems
-   success criteria
-   constraints
-   optional examples

Students decide more of the game's design and implementation.

## Build Your Own

Students propose:

-   the game idea
-   target player
-   core mechanic
-   required systems
-   project scope
-   testing plan

Students must still demonstrate required mastery targets.

------------------------------------------------------------------------

# Suggested Project Depth Levels

## Starter

The smallest version that demonstrates the core mechanic and required
learning.

## Skilled

Adds useful systems, better feedback, stronger usability, or meaningful
design improvements.

## Legendary

Combines multiple systems, transfers skills to a new context, or
includes a challenging feature developed with greater independence.

## Mythic

Demonstrates substantial synthesis, experimentation, iteration, or
independent learning.

Higher levels should represent deeper thinking and transfer, not simply
more art, more code, or more features.

------------------------------------------------------------------------

# Responsible AI-Assisted Development

See **Thread 9: AI-Assisted Game Development** for the full course
guidance.

The core expectation is:

> **Ask → Understand → Build → Test → Explain**

AI can help students debug, write and modify scripts, learn unfamiliar
Unity systems, and pursue more independent project ideas. Students
remain responsible for understanding, testing, and explaining the
systems they use.

# Technical and Professional Best Practices

Students should gradually learn:

-   project organization
-   clear file and object names
-   meaningful variable and method names
-   comments
-   reusable scripts
-   prefab organization
-   backing up projects
-   version-history concepts
-   introductory version control where appropriate
-   asset attribution
-   respecting licenses
-   responsible use of external assets
-   testing before sharing
-   build/export workflow
-   documenting known issues
-   keeping project scope realistic

------------------------------------------------------------------------

# What Still Needs to Be Created

## 1. Course-Level Outcomes

Define final outcomes for:

-   programming
-   computational thinking
-   Unity development
-   game design
-   player experience
-   accessibility
-   playtesting/research
-   communication
-   collaboration
-   career awareness
-   Unity Programmer certification readiness
-   Unity Artist certification progress

## 2. Module-Level Curriculum Documentation

For every module create:

-   module overview
-   essential question
-   technical objectives
-   computational-thinking objectives
-   game-design objectives
-   player-experience objectives
-   communication objectives
-   career connection
-   prerequisites
-   vocabulary
-   common misconceptions
-   suggested pacing
-   mastery targets

## 3. Lesson-Level Documentation

Each lesson should eventually include:

-   lesson overview
-   student-friendly learning goals
-   professional vocabulary
-   game-design connection
-   computational-thinking connection
-   Unity skill
-   worked example
-   guided practice
-   independent practice
-   prediction task
-   debugging task
-   reflection
-   accessibility or UX connection when relevant
-   career spotlight when relevant

## 4. Four-Week MakeCode Sequence

Build the complete opening unit including:

-   Week 1: games, rules, loops, input, feedback
-   Week 2: variables, state, conditions, score, goals
-   Week 3: collisions, randomness, balance, reusable behavior
-   Week 4: microgame design, playtesting, revision

Create:

-   mini-builds
-   sample games
-   starter projects
-   debugging tasks
-   game-design reflection
-   final microgame challenge

## 5. MakeCode-to-Unity Transfer Guide

Create a visual comparison guide connecting:

-   sprites
-   events
-   collisions
-   variables
-   game state
-   scenes
-   input
-   functions
-   tilemaps
-   score/lives
-   debugging

between MakeCode Arcade and Unity.

## 6. 2D Platformer Anchor Project

Develop the platformer as a progressive build.

Potential milestones:

1.  scene and player
2.  movement
3.  jumping
4.  collision
5.  level
6.  camera
7.  collectibles
8.  hazards
9.  score/health
10. win/loss
11. UI
12. sound/animation
13. game feel
14. level-design revision
15. usability test
16. V2 revision

Each milestone should include:

-   required skill
-   design question
-   prediction
-   test
-   reflection

## 7. Game of the Week Curriculum Folder

For every week create:

-   short introduction
-   rules
-   focus concept
-   discussion questions
-   reflection
-   connection to game development
-   professional vocabulary
-   optional modification challenge

## 8. Game Design Concept Library

Create reference pages for:

-   mechanics
-   rules
-   goals
-   constraints
-   core loops
-   feedback
-   balance
-   randomness
-   probability
-   fairness
-   pacing
-   tension
-   difficulty
-   state
-   hidden information
-   resource flow
-   cooperation
-   competition
-   progression
-   risk/reward
-   level design
-   wayfinding
-   emergence
-   simulation
-   optimization
-   rubber-banding
-   player agency
-   game feel

Each page should contain:

-   plain-language definition
-   professional terminology
-   game examples
-   questions to ask
-   connection to student projects

## 9. UI and Player Experience Pattern Library

Create examples of:

-   health displays
-   score displays
-   timers
-   objectives
-   menus
-   settings
-   inventories
-   dialogue
-   interaction prompts
-   disabled states
-   cooldowns
-   minimaps
-   win/loss screens
-   tutorial messages

Include strong and weak examples for analysis.

## 10. Level Design Example Library

Create examples students can study for:

-   guiding attention
-   teaching mechanics
-   difficulty progression
-   safe practice areas
-   landmarks
-   checkpoints
-   risk/reward
-   environmental clues
-   pacing
-   multiple routes
-   2D vs 3D navigation

## 11. Playtesting Toolkit

Create:

-   task-writing template
-   Observe, Don't Rescue guide
-   think-aloud instructions
-   observation sheet
-   player-feedback sheet
-   issue tracker
-   revision-priority template
-   before/after reflection

## 12. Player Research Toolkit

Create student-friendly tools for:

-   short interviews
-   neutral questions
-   observation
-   surveys
-   research notes
-   finding patterns
-   identifying player needs
-   separating evidence from assumptions

## 13. Accessibility Guide

Create a growing checklist for:

-   text
-   contrast
-   color
-   audio
-   subtitles
-   controls
-   difficulty options
-   motion
-   UI clarity
-   redundant feedback

## 14. Unity Debugging Guide

Create a student-friendly reference for:

-   reading Console errors
-   missing references
-   null references
-   component problems
-   collider problems
-   Rigidbody problems
-   layers
-   tags
-   Inspector mistakes
-   script attachment
-   scene setup
-   testing one change at a time

## 15. Practice and Question Bank

Develop questions and activities involving:

-   reading C#
-   predicting behavior
-   tracing state
-   identifying component setups
-   debugging
-   choosing Unity systems
-   game-design reasoning
-   UI analysis
-   level analysis
-   interpreting playtest observations
-   distinguishing bugs from usability issues
-   connecting Game of the Week concepts to digital games

## 16. AI-Assisted Development Toolkit

Create student-facing resources for:

-   writing useful Unity prompts
-   describing a GameObject and component setup
-   OBJECT → TRIGGER → CONDITION → ACTION → DATA planning
-   reading AI-generated C#
-   asking for explanations
-   reading errors with AI
-   the AI Debugging Ladder
-   checking for outdated or invented APIs
-   testing AI-generated code
-   documenting important AI-assisted work
-   deciding when to ask for code and when to ask for guidance
-   using AI to fill knowledge gaps during independent projects

Create prompt examples at multiple levels:

-   weak prompt
-   improved prompt
-   strong debugging prompt
-   strong feature-planning prompt
-   strong explanation prompt
-   strong testing prompt

## 23. Mastery Checks

Define mastery evidence for each major module.

Evidence can include:

-   technical implementation
-   prediction
-   debugging
-   explanation
-   design analysis
-   player-experience reasoning
-   transfer to a new situation

## 23. Career Spotlight Library

Develop short, reusable career resources for:

-   Game Designer
-   Systems Designer
-   Level Designer
-   Gameplay Programmer
-   UI Programmer
-   UX Designer
-   Games User Researcher
-   QA Tester
-   Producer
-   Narrative Designer
-   2D Artist
-   3D Artist
-   Animator
-   Technical Artist
-   VFX Artist
-   Sound Designer
-   Accessibility Specialist

Each spotlight should include:

-   what they do
-   what a normal task might look like
-   people they work with
-   tools
-   skills
-   example portfolio work
-   connection to the current lesson

## 23. 2D-to-3D Transfer Activities

Students should explicitly compare:

-   2D and 3D movement
-   2D and 3D physics
-   cameras
-   colliders
-   level design
-   interactions
-   player guidance

Activities should emphasize transfer rather than memorizing a second set
of isolated Unity tools.

## 23. Project Bank

Revise and expand the existing project bank so projects align with the
new course structure.

Each project should identify:

-   prerequisite skills
-   game-design concepts
-   technical skills
-   player-experience goals
-   accessibility expectations
-   playtesting requirement
-   Starter / Skilled / Legendary / Mythic extensions
-   Guided / Challenge / Build Your Own pathways

## 23. Team Project Structures

Create supports for:

-   roles
-   responsibilities
-   shared files
-   backups
-   communication
-   task boards
-   milestone planning
-   resolving absences
-   individual accountability
-   peer review

## 23. Capstone System

Develop:

-   target-player definition
-   research
-   concept pitch
-   comparable-game analysis
-   core mechanic
-   core loop
-   system map
-   scope
-   must-have / nice-to-have / stretch features
-   prototype
-   technical plan
-   production milestones
-   minimum playable build
-   playtest
-   observations
-   revision plan
-   V2
-   accessibility check
-   QA
-   final build
-   presentation
-   design rationale
-   technical rationale
-   postmortem

------------------------------------------------------------------------

# Recommended Development Order

1.  Finalize course-level outcomes.
2.  Define module objectives and mastery targets.
3.  Map every Unity Programmer objective to required instruction and
    repeated practice.
4.  Map Unity Artist objectives to core instruction, projects, and
    optional extensions.
5.  Build the four-week MakeCode curriculum.
6.  Build the MakeCode-to-Unity transfer guide.
7.  Fully design the 2D platformer anchor project.
8.  Build the Game Design Concept Library.
9.  Create Game of the Week mini-lessons and reflections.
10. Build the UI/Player Experience Pattern Library.
11. Build the Playtesting and Player Research Toolkits.
12. Build the Level Design Example Library.
13. Create accessibility and debugging guides.
14. Build the AI-Assisted Development Toolkit and integrate AI
    checkpoints across Unity modules.
15. Build the Unity Programmer certification-readiness system.
16. Build the Unity Artist progress tracker and optional readiness
    extensions.
17. Develop career spotlights.
18. Map project choices to modules.
19. Build mastery checks and practice.
20. Develop 2D-to-3D transfer activities.
21. Build capstone materials.
22. Review pacing and cognitive load across the full year.
23. Review the course for accessibility, student choice, AI-supported
    independence, certification readiness, and opportunities for
    authentic player feedback.

------------------------------------------------------------------------

# Certification Completion Philosophy

Certification should provide meaningful external validation without
narrowing the course to test preparation.

## Every Student

Every student should:

-   receive the full Unity Programmer instructional progression
-   practice all major Programmer certification objective areas
-   receive readiness feedback
-   receive targeted support for weak areas
-   prepare for the required Unity Programmer certification
-   make meaningful progress toward Unity Artist objectives

## Students Ready for the Additional Artist Credential

Students who demonstrate sufficient Unity Artist readiness should:

-   see which objectives they have already mastered
-   receive targeted support for remaining gaps
-   be strongly encouraged to attempt the certification
-   have access to art, environment, animation, and technical-art
    extensions
-   continue pursuing programming and game-design goals rather than
    being pulled out of authentic project work solely for test
    preparation

## Students Not Yet Ready for the Additional Artist Credential

Students should continue strengthening their Unity development skills
through authentic projects.

Progress toward the Artist credential should remain visible and valued
even when a student does not complete that certification during the
course.

This keeps the second credential aspirational and accessible without
making it an all-or-nothing measure of success.

------------------------------------------------------------------------

# Course-Level North Star

A successful student should leave the course able to say:

> I can understand how games work, break a game into smaller systems,
> build interactive experiences in Unity, explain how my code and game
> systems work, use AI thoughtfully to learn and debug without giving up
> responsibility for my work, design with the player in mind, test my
> game with real people, notice where players struggle, improve my
> design based on evidence, and plan and build a game of my own.

The goal is not only:

> I know how to use Unity.

The larger goal is:

> I know how to think, build, test, and improve like a game developer.
