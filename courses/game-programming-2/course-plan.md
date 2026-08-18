# FoxCS: Game Programming II: Course Plan

Source: `../../starter context/Unity_Game_Development_Course_Map_Certification_Aligned_Complete.md` ("Game Development with Unity — Designing, Building, Testing, and Improving Player Experiences"), a pre-drafted, certification-aligned course map covering 29 modules (00-28). This file is the FoxCS scope skeleton built from that map — first built 2026-08-17.

**Scope decision (2026-08-17): this course-plan is the Game Design/Unity-pathway curriculum, not "Game II" as a class period.** Per this session's decisions (`../../decisions-log.md`, `../../00-project-overview/shared-unit-00-onboarding.md`), pathway choice is decoupled from course enrollment — a student follows this course-plan if they chose the **Game Design/Unity pathway** at the shared Unit 0's pathway-choice lesson, regardless of whether their actual class period is "Game II" or "Web II." The JS/HTML5 app-dev lane that used to be ambiguously shared between Game II and Web II now belongs entirely to `../web-dev/course-plan.md` (the Web Dev pathway). This course-plan has zero JS/HTML5 content — consistent with its source map, which is 100% Unity/MakeCode Arcade and never mentions JS/HTML5.

**Terminology note:** FoxCS calls these **Units** (not "Modules"), matching `../python/course-plan.md`'s convention. **Unit numbering here is offset by +1 from the source map's Module numbering**, because the source map's own Module 00 duplicates most of the shared Unit 0 (see below) — so FoxCS Unit 01 = source Module 00 (trimmed), FoxCS Unit 02 = source Module 01, ... FoxCS Unit 29 = source Module 28. Every unit below cites its source Module number once for cross-reference.

## Unit 00: Course Onboarding

**Not authored here.** Game II shares one onboarding unit with Web II — see `../../00-project-overview/shared-unit-00-onboarding.md`. Game II students (like all Level 2 students) see that doc's **Level 2** edition: both Web Dev and Game Design/Unity pathways shown, pathway chosen at Lesson 00.8, not defaulted by class enrollment.

**Overlap note:** the source map's own Module 00 ("00-welcome-to-game-development") includes four lessons that substantially duplicate the shared Unit 0 spine: `00.5-how-learning-works`, `00.6-debugging-is-learning`, `00.7-introduction-to-computational-thinking`, `00.10-getting-unstuck`. These are **dropped here**, not authored twice — the shared Unit 0's "How Learning Works," "Troubleshooting Is Learning," "Introduction to Computational Thinking," and "Getting Unstuck" lessons cover the same ground at Level 2. The remaining, genuinely game-specific lessons from source Module 00 (Welcome to Game Development, What Game Developers Do, Games Are Interactive Systems, The Player Is Part of the Game, How Game Teams Work, Careers in Games) become real FoxCS content — see Unit 01 below, not skipped.

**Legend:** ⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final (all ⬜ below — nothing authored yet, checklist only)

---

## Certification Framing

**Confirmed by Jay, 2026-08-18** (previously a recommendation pending confirmation — now decided):

- **Unity Certified User Programmer — required target credential.** C# programming, debugging, API interpretation, input, logic, state, UI behavior, code evaluation, and Unity workflow are treated as the course's central technical outcomes. Every student receives the full instructional progression toward this credential.
- **Unity Certified User Artist — achievable, not guaranteed, with an honest expectations note.** Students accumulate progress toward it through normal game-development work (assets, sprites, Prefabs, animation, Transform tools, greyboxing, meshes, Terrain, materials, lighting, cameras) and are expected to engage with this content throughout the year. A student who keeps herself moving and uses class time well has every real opportunity to add Artist to Programmer before the year ends. **But finishing it is contingent on effective time use, not a promise made regardless of effort.** Per Jay (2026-08-18): every year, some students don't complete available content — not from lack of ability, but from misusing class time (playing unrelated games, doing work for other classes during work time). The framing to students should be supportive and honest, not a threat: engagement is expected and supported; completion depends on how well that time gets used, and the content itself won't wait if it doesn't.

**Where this belongs, not yet placed:** this expectation-setting note needs a real home in student-facing content — likely early in this course's Unit 01 (orientation) or wherever pathway-specific expectations get set, distinct from the shared Unit 0's general "Getting Unstuck"/"How Learning Works" lessons, which are pathway-agnostic. Not yet written as actual student-facing copy — this section is the internal planning record of the decision and its intended tone, not the lesson text itself.

**This resolves the open question in `../../open-questions.md`** ("Which Unity certification is the mandatory floor for Game II?") — Programmer required, Artist achievable-not-guaranteed. No longer a recommendation pending confirmation.

**Possible extension, not yet decided:** Web Dev's JavaScript-encouraged credential (`../web-dev/course-plan.md`) likely has the same "achievable with good time use, not guaranteed" dynamic. Not applied there yet — flagged as a natural follow-up, not assumed.

**No official Unity student workbook exists** (confirmed by Jay, per `CLAUDE.md`) — unlike Python's GMetrix workbook or Web Dev's JS/HTML5 workbooks, there's no page-by-page courseware to cite exercises from. Cert tie-ins below cite the source map's own **Certification Objective Mapping** tables (its "Primary Modules" columns per certification Area), not a workbook. Unity Learn is a plausible source of curated third-party practice content, especially for 3D — licensing not yet checked, see `../../open-questions.md`.

---

## Phase 1: Game Design and Programming Foundations *(source Modules 00-03, ~first 4 weeks)*

MakeCode Arcade is used as a lower-complexity on-ramp — game-design and programming ideas first, Unity's added complexity (3D space, C#, the editor itself) comes after. **Synergy worth noting, not yet decided:** `../python/course-plan.md` places MakeCode Arcade *after* its own capstone as real post-certification project work, not filler (corrected 2026-08-18 — see that file's "Post-Capstone: MakeCode Arcade" section) — the same tool opens this course and closes Game I's. Possible shared MakeCode Arcade content/exercises between the two courses; not scoped yet. Also see `../../00-project-overview/kickoff-avatar-and-intro-activity.md` for a separate, much earlier MakeCode touchpoint (a Day-1 avatar-creation activity, all three courses, unrelated to this Phase 1 on-ramp use).

## Unit 01: Welcome to Game Development
*Source: Module 00 (trimmed — see Unit 00 note above for the 4 dropped, shared-Unit-0-duplicate lessons).*
*Cert tie-in: none — foundational/orientation content, not certification-mapped, matching the source map's own framing (career/team content isn't part of either credential).*
*Game/UX tie-in: This unit doesn't teach Mechanics yet, but it sets up the idea that games are made by people in different roles (design, art, programming) working toward a shared player experience.*
*Journal (50-75 words): Think about a game you've played recently. Name one thing about it that feels like a design decision, one thing that feels like an art decision, and one thing that feels like a programming decision. You don't need to be right, just take a guess based on what you learned about game development roles this unit.*
- [ ] 01.1 Welcome to Game Development
- [ ] 01.2 What Game Developers Do
- [ ] 01.3 Games Are Interactive Systems
- [ ] 01.4 The Player Is Part of the Game
- [ ] 01.5 How Game Teams Work
- [ ] 01.6 Careers in Games

## Unit 02: How Games Work
*Source: Module 01.*
*Cert tie-in: none — game-design foundations (goals, rules, gameplay loop, pacing), pre-code. Feeds every later certification area conceptually but isn't itself Programmer/Artist-mapped.*
*Game/UX tie-in: This is where Mechanics, Dynamics, and Aesthetics (MDA) get introduced properly, the same framework from Game I, but grounded in this course's own vocabulary: a game's Goals, Rules, and Limits are its Mechanics; what actually happens once those Rules interact (the Gameplay Loop, how games respond to players) are its Dynamics; and how playing it feels (Thread 4's "how does the player know?" question, and Player Experience ideas like pacing and flow) are its Aesthetics.*
*Journal (50-100 words): Pick a game you know well. Name one Mechanic (a Goal, a Rule, or a Limit), describe the Dynamic that Mechanic produces once you actually play (something that happens because of it), and name the Aesthetic, the feeling it gives you. This is your first real MDA entry this year. You'll come back to it later.*
- [ ] 02.1 What Makes Something a Game
- [ ] 02.2 Goals, Rules, and Limits
- [ ] 02.3 What the Player Can Do
- [ ] 02.4 The Gameplay Loop
- [ ] 02.5 How Games Respond to Players
- [ ] 02.6 Showing Players What Happened
- [ ] 02.7 Pacing and Flow
- [ ] 02.8 Breaking Games into Parts
- [ ] 02.9 Changing One Rule
- [ ] 02 Challenge: Paper Game Remix

## Unit 03: Making Games with MakeCode Arcade
*Source: Module 02.*
*Cert tie-in: none directly (MakeCode isn't Unity), but this unit is where variables, input/events, decisions, collisions, randomness, loops, and functions are first introduced — the exact concepts Programmer Areas 1-2 later re-certify inside Unity/C#. Treat as pre-certification scaffolding, not itself cert-mapped.*
*Game/UX tie-in: Variables and game state in MakeCode are the literal Game State concept from this course's own vocabulary. Score, lives, and rules are Mechanics you're now building yourself instead of just naming in someone else's game.*
*Journal (50-100 words): Look at the MakeCode microgame you built. Name one variable you used (like score or lives) and explain what Game State it's tracking. Then describe one Rule your game enforces using that variable.*
- [ ] 03.1 Meet MakeCode Arcade
- [ ] 03.2 Sprites and Game Objects
- [ ] 03.3 Player Input and Events
- [ ] 03.4 Variables and Game State
- [ ] 03.5 Score, Lives, and Goals
- [ ] 03.6 Decisions and Game Rules
- [ ] 03.7 Collisions and Overlaps
- [ ] 03.8 Randomness and Probability
- [ ] 03.9 Repetition and Game Loops
- [ ] 03.10 Functions and Reusable Actions
- [ ] 03.11 Debugging Game Systems
- [ ] 03 Project: MakeCode Microgame

## Unit 04: Design, Test, and Improve a Microgame
*Source: Module 03.*
*Cert tie-in: none — this is the course's first playtesting cycle (Observe, Don't Rescue protocol), a Thread 6 (Player Research/Playtesting) skill, not a Programmer/Artist objective.*
*Game/UX tie-in: "Observe, Don't Rescue" is a direct, practical version of Thread 4's "how does the player know?" question. If a player gets stuck, that's information about your game's Feedback, not evidence the player did something wrong.*
*Journal (75-100 words): Describe one moment from playtesting your microgame where a player got stuck or confused. Using this unit's Observe, Don't Rescue idea, explain what you noticed instead of jumping in to help, and what that told you about your game's Feedback.*
- [ ] 04.1 From One Mechanic to a Game
- [ ] 04.2 Building a Clear Gameplay Loop
- [ ] 04.3 Making Games Fair and Fun
- [ ] 04.4 Challenge vs. Frustration
- [ ] 04.5 Helping Players Understand the Rules
- [ ] 04.6 Making Actions Feel Responsive
- [ ] 04.7 Learning from Players
- [ ] 04.8 Giving a Player a Task
- [ ] 04.9 Observe, Don't Rescue
- [ ] 04.10 Finding Where Players Get Stuck
- [ ] 04.11 Improving a Game from Evidence
- [ ] 04 Project: Microgame Redesign

---

## Phase 2: Learning Unity Through 2D *(source Modules 04-14)*

Students transfer familiar MakeCode concepts into Unity. A 2D platformer is the anchor project that grows across this entire phase (character → movement → jump → collision → camera → collectibles → hazards → score → win/loss → sound/feedback → level design → playtest → revise).

## Unit 05: Getting Started with Unity 2D
*Source: Module 04.*
*Cert tie-in: **Programmer Area 1** (Debugging/Problem-Solving/API) and **Area 4** (Interface & State Machines — Unity IDE windows, scripting IDE configuration) both cite this as a primary module. **Artist Area 1** (Asset Management — Asset Store import, spritesheet slicing/9-slicing) and **Area 2** (Scene Content Design — Transform tools) also primary here. This is the single densest cert-mapped unit for onboarding into Unity itself.*
*Game/UX tie-in: Moving from MakeCode to Unity doesn't change the Mechanics you already understand. A Sprite Renderer is just a more powerful way to show the same kind of GameObject you were already building.*
*Journal (100-150 words): Compare one thing you built in MakeCode to how you'd build the same thing in Unity so far (a sprite, a scene, a GameObject). What stayed the same conceptually, and what's genuinely new about the tool?*
- [ ] 05.1 Why We Are Changing Tools
- [ ] 05.2 Navigating the Unity Editor
- [ ] 05.3 Scenes, GameObjects, and Components
- [ ] 05.4 The Hierarchy and Inspector
- [ ] 05.5 Position, Rotation, and Scale
- [ ] 05.6 Sprites, Spritesheets, and Sprite Renderers
- [ ] 05.7 Slicing Spritesheets and 9-Slicing
- [ ] 05.8 Importing Assets and Using the Asset Store
- [ ] 05.9 Assets and Project Organization
- [ ] 05.10 From MakeCode Sprites to Unity GameObjects
- [ ] 05.11 Play Mode and Testing
- [ ] 05.12 Unity Windows and What They Do
- [ ] 05.13 Scripting Editor and Project Workflow
- [ ] 05.14 Asking AI Good Unity Questions
- [ ] 05 Challenge: Build a Simple 2D Scene

## Unit 06: Programming in Unity with C#
*Source: Module 05.*
*Cert tie-in: **Programmer Area 1, 2, and 3 all cite this as a primary module** — the densest single unit in the whole cert map. Debug logs, null-object debugging, variables/modifiers, arrays/Lists/Dictionaries, function declarations, logic/flow control, data-type errors, public/private problems, naming conventions, and accurate comments are all Certification Ready targets rooted here.*
*Game/UX tie-in: Reading error messages and using Debug.Log is a technical version of "how does the player know?", except here you're the one who needs the game to tell you what's happening.*
*Journal (100-200 words): Describe a bug you ran into while scripting this unit (a null reference, a naming mistake, anything real). Walk through how you used Debug.Log or an error message to figure out what was wrong, and connect it to this unit's idea that debugging is normal, not a sign you did something wrong.*
- [ ] 06.1 How Scripts Control GameObjects
- [ ] 06.2 Reading a Unity Script
- [ ] 06.3 Variables and Data
- [ ] 06.4 Methods and Actions
- [ ] 06.5 Start and Update
- [ ] 06.6 Making Decisions with Code
- [ ] 06.7 Public, Private, and Variable Modifiers
- [ ] 06.8 Arrays, Lists, and Dictionaries
- [ ] 06.9 Connecting Scripts to Components
- [ ] 06.10 Using the Unity API and Documentation
- [ ] 06.11 Debug.Log and Reading Error Messages
- [ ] 06.12 Null References and Missing Objects
- [ ] 06.13 Debugging with the Console
- [ ] 06.14 Naming, Comments, and Readable Code
- [ ] 06.15 Using AI to Understand and Debug Code
- [ ] 06.16 Writing Small Scripts with AI Support
- [ ] 06 Challenge: Scripted Behavior

## Unit 07: 2D Physics and Collisions
*Source: Module 06.*
*Cert tie-in: none directly cited in the Objective Mapping tables, but Rigidbody2D/Collider2D here are the direct precursor to the certified Rigidbody/Collider concepts revisited in Unit 23 (3D). Foundational, not itself cert-mapped.*
*Game/UX tie-in: Rigidbody2D and Collider2D are Mechanics you can't see directly, the invisible Rules that decide what cause and effect (a Systems Concept) looks like when two GameObjects touch.*
*Journal (100-200 words): Pick one physics behavior you set up this unit (gravity, a collision, a trigger). Explain the cause and the effect in plain language, then describe what would feel wrong to a player if that effect didn't happen the way they expected.*
- [ ] 07.1 How Physics Changes Gameplay
- [ ] 07.2 Rigidbody2D
- [ ] 07.3 Collider2D
- [ ] 07.4 Gravity and Forces
- [ ] 07.5 Collisions vs. Triggers
- [ ] 07.6 Layers and Collision Rules
- [ ] 07.7 Cause and Effect
- [ ] 07.8 Making Physical Rules Feel Consistent
- [ ] 07 Challenge: Physics Playground

## Unit 08: Player Movement and Controls
*Source: Module 07.*
*Cert tie-in: **Programmer Area 2** (Creating Code — keyboard input, touch-input concepts/listeners) primary module.*
*Game/UX tie-in: Tuning speed and jump height is Aesthetics work disguised as numbers. The same Mechanic (jumping) can feel completely different depending on small changes, which is exactly what game feel means.*
*Journal (100-200 words): Describe how you tuned your player's movement or jump this unit. What did you change, and how did the feeling of controlling the character change as a result? Connect this to the idea that a Mechanic's numbers shape its Aesthetic.*
- [ ] 08.1 Turning Player Input into Action
- [ ] 08.2 Keyboard, Touch, and Input Listeners
- [ ] 08.3 Moving Left and Right
- [ ] 08.4 Jumping
- [ ] 08.5 Checking When the Player Is on the Ground
- [ ] 08.6 Tuning Speed and Jump Height
- [ ] 08.7 Making Controls Feel Responsive
- [ ] 08.8 Common Control Patterns
- [ ] 08.9 Testing Controls with Other Players
- [ ] 08 Project: Platformer Movement

## Unit 09: Building a 2D Platformer
*Source: Module 08.*
*Cert tie-in: **Programmer Area 2** (functions controlling state, logic/flow control) primary module.*
*Game/UX tie-in: This is your first real playable game since Unit 02's MDA introduction. Tilemaps, collectibles, hazards, and win/loss conditions are all Mechanics you're now combining into one Gameplay Loop and Game State system.*
*Journal (150-200 words): Look back at your Unit 02 journal entry. Using your platformer so far, name a Mechanic you built (a rule about collectibles, hazards, or winning/losing), the Dynamic that emerges from it during real play, and the Aesthetic it's meant to produce. Has your thinking about MDA changed since Unit 02, now that you're building instead of just naming?*
- [ ] 09.1 From Movement to a Playable Game
- [ ] 09.2 Tilemaps and Level Building
- [ ] 09.3 Platforms and Environment Collision
- [ ] 09.4 Collectibles
- [ ] 09.5 Hazards
- [ ] 09.6 Checkpoints and Goals
- [ ] 09.7 Score, Lives, and Rules
- [ ] 09.8 Winning and Losing
- [ ] 09.9 Keeping Track of Game State
- [ ] 09.10 Testing the Gameplay Loop
- [ ] 09 Project: Playable Platformer V1

## Unit 10: Cameras and Player View
*Source: Module 09.*
*Cert tie-in: **Artist Area 3** (Lighting, Cameras, Materials — camera setup/properties) primary module.*
*Game/UX tie-in: The camera is pure Aesthetics work. It doesn't change any Rule, but it completely changes what information the player has and how the game feels to play.*
*Journal (100-200 words): Describe one camera decision you made this unit (following the player, setting limits, revealing or hiding information). Explain how that decision changes what the player knows at any given moment, connecting back to Thread 4's "how does the player know?" question.*
- [ ] 10.1 How the Camera Changes the Experience
- [ ] 10.2 Making the Camera Follow the Player
- [ ] 10.3 Setting Camera Limits
- [ ] 10.4 Showing the Right Information
- [ ] 10.5 Smooth Camera Movement
- [ ] 10.6 Revealing and Hiding Information
- [ ] 10 Challenge: Improve the Platformer Camera

## Unit 11: Game UI and Player Information
*Source: Module 10.*
*Cert tie-in: **Programmer Area 2** (responding to UI value changes with code, event functions) primary module.*
*Game/UX tie-in: UI is where "how does the player know?" gets answered directly. Score, health, and status displays are Feedback made visible.*
*Journal (100-200 words): Pick one piece of UI you built (health, score, or a status display). Explain what information it gives the player, why that information matters for the Gameplay Loop, and what would go wrong if it were missing.*
- [ ] 11.1 What Information Does the Player Need
- [ ] 11.2 Canvas and UI Elements
- [ ] 11.3 Readable Text and Game UI
- [ ] 11.4 Score, Health, and Status
- [ ] 11.5 Showing What Matters Most
- [ ] 11.6 Screen UI vs. World Information
- [ ] 11.7 Menus, Buttons, and Navigation
- [ ] 11.8 Responding to UI Value Changes with Code
- [ ] 11.9 Showing Players What Is Happening
- [ ] 11.10 UI States
- [ ] 11.11 Making Game UI More Accessible
- [ ] 11 Project: Platformer UI

## Unit 12: Making Games Feel Responsive
*Source: Module 11.*
*Cert tie-in: none directly cited — "game feel" (feedback, animation/sound/particles as feedback) is a Thread 4 (Player Experience/UI) skill, not separately cert-mapped, though it reinforces UI/event-function skills from Units 06 and 11.*
*Game/UX tie-in: This unit names something you've been doing since Unit 08 without a word for it. Animation, sound, and particles are all Feedback, the Aesthetic layer wrapped around a Mechanic.*
*Journal (100-200 words): Compare your platformer before and after adding a feedback pass (animation, sound, or particles). Pick one specific change and explain what Aesthetic it's meant to create, and whether it worked when you tested it.*
- [ ] 12.1 What Is Game Feel
- [ ] 12.2 Immediate Feedback
- [ ] 12.3 Animation as Feedback
- [ ] 12.4 Sound as Feedback
- [ ] 12.5 Particles and Visual Effects
- [ ] 12.6 Camera Feedback
- [ ] 12.7 Showing Players What Is About to Happen
- [ ] 12.8 Feedback Without Overloading the Player
- [ ] 12.9 Comparing Before and After
- [ ] 12 Project: Platformer Feel Pass

## Unit 13: Level Design and Player Guidance
*Source: Module 12.*
*Cert tie-in: **Programmer Area 2** (arrays/Lists/Dictionaries, function declarations — 12-19 range) and **Artist Area 2** (greyboxing) both primary modules.*
*Game/UX tie-in: Building a level is Constraint design, deciding what a player can and can't do in space, using landmarks and pacing (action and rest) to teach Rules without ever writing them down as text.*
*Journal (100-200 words): Describe one thing your level teaches a player without explicitly telling them (through landmarks, layout, or a safe first challenge). Explain how you know it worked, or how you'd find out.*
- [ ] 13.1 Levels Are Designed Experiences
- [ ] 13.2 Teaching Without Explaining Everything
- [ ] 13.3 Introduce, Practice, Challenge
- [ ] 13.4 Building a Difficulty Curve
- [ ] 13.5 Pacing: Action and Rest
- [ ] 13.6 Helping Players Know Where to Go
- [ ] 13.7 Landmarks and Environment Clues
- [ ] 13.8 Risk and Reward
- [ ] 13.9 Checkpoints and Progress
- [ ] 13.10 Making Challenges Feel Fair
- [ ] 13 Project: Design a Platformer Level

## Unit 14: Designing for the Player
*Source: Module 13.*
*Cert tie-in: none directly cited — this is the course's UX/accessibility deep-dive (affordance, discoverability, cognitive load, player agency), a Thread 4/5 skill set, not itself Programmer/Artist-mapped.*
*Game/UX tie-in: This is the deepest MDA revisit of the year so far. Affordance, discoverability, cognitive load, and player agency (Thread 4/5 ideas) are all just detailed answers to "how does the player know, and how much should they have to think about at once?"*
*Journal (150-200 words): Look back at your Unit 09 journal entry. Pick one accessibility or usability idea from this unit (discoverability, cognitive load, meaningful choice) and apply it to your platformer. What's one specific change you'd make, and what Aesthetic problem is it solving? Has your understanding of "how does the player know" grown since Unit 09?*
- [ ] 14.1 Designing for Someone Else
- [ ] 14.2 Understanding What Players Need
- [ ] 14.3 Showing Players What They Can Do
- [ ] 14.4 Helping Players Figure Things Out
- [ ] 14.5 Showing Players What Is Happening
- [ ] 14.6 Giving Players the Right Amount of Information
- [ ] 14.7 Making Controls Easier to Use
- [ ] 14.8 Making Games More Accessible
- [ ] 14.9 Difficulty and Access Options
- [ ] 14.10 Giving Players Meaningful Choices
- [ ] 14 Challenge: Player Experience Review

## Unit 15: Playtesting and Player Feedback
*Source: Module 14.*
*Cert tie-in: none — second full playtesting cycle (Thread 6), now against the growing platformer anchor project rather than a microgame.*
*Game/UX tie-in: This is your second full playtesting cycle, now against a real, growing game instead of a microgame. "What players say vs. what they do" is the practical difference between a player's stated Aesthetic and their actual Dynamic.*
*Journal (200-250 words): Describe a moment from this unit's playtest where what a player said didn't match what they actually did. What did you learn from watching instead of just asking? What's one thing you plan to change based on evidence, not assumption?*
- [ ] 15.1 Don't Assume — Test It
- [ ] 15.2 Deciding What You Want to Learn
- [ ] 15.3 Talking to and Watching Players
- [ ] 15.4 Giving Players a Task
- [ ] 15.5 Asking Players to Think Out Loud
- [ ] 15.6 Observe, Don't Rescue
- [ ] 15.7 What Players Say vs. What They Do
- [ ] 15.8 Looking for Patterns
- [ ] 15.9 Deciding What to Fix First
- [ ] 15.10 Improving Your Game from Feedback
- [ ] 15 Project: Platformer Playtest and V2

---

## Phase 3: Building Larger Game Systems *(source Modules 15-19)*

Beyond the basic platformer — reusable systems (prefabs, spawning), animation/sound, scene management, dialogue/inventory concepts, and simple game AI.

## Unit 16: Prefabs and Reusable Game Parts
*Source: Module 15.*
*Cert tie-in: **Programmer Area 2** (12-19 range) and **Artist Area 1** (Prefabs specifically) both primary modules.*
*Game/UX tie-in: Prefabs are Mechanics made reusable. Separating data from behavior means one underlying Rule can produce many different game objects without you rewriting the Rule each time.*
*Journal (200-250 words): Describe one system you rebuilt as a Prefab this unit. Explain the difference between the data (what makes each instance different) and the behavior (what stays the same for all of them), and why that separation matters as a game gets bigger.*
- [ ] 16.1 Why Reuse Matters
- [ ] 16.2 Creating Prefabs
- [ ] 16.3 Prefab Instances
- [ ] 16.4 Reusable Components
- [ ] 16.5 Spawning GameObjects
- [ ] 16.6 Groups of GameObjects
- [ ] 16.7 Breaking Large Systems into Smaller Parts
- [ ] 16.8 Data vs. Behavior
- [ ] 16 Project: Reusable Game System

## Unit 17: Animation, Sound, and Effects
*Source: Module 16.*
*Cert tie-in: **Programmer Area 2, 3, and 4** all cite this (functions controlling state, event functions, public/private problems, animation events, functional state machines, Animator Controller scripting). **Artist Area 1** (keyframes/Curve Editor tangents) also primary. Second-densest cert-mapped unit after Unit 06.*
*Game/UX tie-in: A functional animation state machine is Game State made visible. The player should always be able to tell what state a character or an enemy is in just by looking, which is Feedback at its most literal.*
*Journal (200-300 words): Pick one Animator state machine you built (a character or enemy). Walk through its states and transitions, and explain how a player can tell which state something is in just by watching, without any UI text. Where does this succeed, and where might a player still be confused?*
- [ ] 17.1 Animation Clips
- [ ] 17.2 The Animator
- [ ] 17.3 Animation States and Transitions
- [ ] 17.4 Building a Functional Animation State Machine
- [ ] 17.5 Controlling the Animator with Code
- [ ] 17.6 Animation Events and Script Connections
- [ ] 17.7 Keyframes, Curves, and Tangents
- [ ] 17.8 Audio Sources and Audio Clips
- [ ] 17.9 Music, Ambience, and Sound Effects
- [ ] 17.10 Using Audio to Give Information
- [ ] 17.11 Looking Good vs. Communicating Clearly
- [ ] 17 Project: Feedback and Presentation Pass

## Unit 18: Scenes, Progress, and Game State
*Source: Module 17.*
*Cert tie-in: **Programmer Area 1** (debugging/API — explicitly named a primary module for Area 1) and **Area 2** (12-19 range) both apply.*
*Game/UX tie-in: This unit is Game State at the whole-game level, what has to be remembered between scenes (progress, settings, whether a level is complete) instead of just within one moment of play.*
*Journal (200-300 words): Describe what Game State your game needs to remember between scenes (progress, a setting, a completed level). What would break for the player if that information were lost, and how does keeping it change what the player expects from your game?*
- [ ] 18.1 Using Scenes to Organize a Game
- [ ] 18.2 Start Menus and Gameplay Scenes
- [ ] 18.3 Loading and Changing Scenes
- [ ] 18.4 Keeping Information Between Scenes
- [ ] 18.5 Level Progression
- [ ] 18.6 Restarting and Resetting
- [ ] 18.7 Pause and Settings
- [ ] 18.8 How Saving Games Works
- [ ] 18 Project: Multi-Scene Game

## Unit 19: Interactions, Dialogue, and Game Worlds
*Source: Module 18.*
*Cert tie-in: **Programmer Area 2** (event functions) primary module.*
*Game/UX tie-in: Interaction prompts are Feedback that answers "can I do something here?" before the player even tries, and hidden information (a Systems Concept) is what makes exploring a world worth doing.*
*Journal (200-300 words): Describe one interaction you designed (a prompt, a piece of dialogue, an item). Explain what information it gives the player, what information it deliberately withholds, and why withholding it makes the world more interesting rather than more confusing.*
- [ ] 19.1 Designing Clear Interactions
- [ ] 19.2 Interaction Prompts
- [ ] 19.3 NPCs and Dialogue
- [ ] 19.4 Keeping Track of Dialogue
- [ ] 19.5 Items and Inventory
- [ ] 19.6 Quests and Objectives
- [ ] 19.7 Hidden Information
- [ ] 19.8 Telling Stories Through the Environment
- [ ] 19 Project: Interactive World System

## Unit 20: Enemies and Game AI
*Source: Module 19.*
*Cert tie-in: **Programmer Area 2** (functions controlling state, logic/flow control, functional state machines — 12-19 range) primary module.*
*Game/UX tie-in: This is where "Mechanics produce Dynamics" becomes the most visible all year. An enemy's Rules (patrol, chase, detection range) are simple, but combined with a player's choices, they create Dynamics nobody explicitly programmed, emergence, a Systems Concept, in action.*
*Journal (250-300 words): Look back at your Unit 14 journal entry. Describe one enemy behavior you built this unit (patrol, chase, detection). What are the simple Rules behind it, and what more complex Dynamic emerges when a player actually plays against it? Has your understanding of how simple Mechanics create complex results changed since Unit 14?*
- [ ] 20.1 What Does Game AI Mean
- [ ] 20.2 Enemies Following Rules
- [ ] 20.3 Changing Enemy Behavior
- [ ] 20.4 Patrol, Chase, and Return
- [ ] 20.5 Detection and Range
- [ ] 20.6 Showing Players What Enemies Will Do
- [ ] 20.7 Tuning Enemy Difficulty
- [ ] 20.8 When Simple Rules Create Complex Results
- [ ] 20 Project: Enemy Behavior System

---

## Phase 4: Moving from 2D into 3D *(source Modules 20-23)*

Explicitly framed as transfer, not restart: Sprite→Mesh, Rigidbody2D→Rigidbody, Collider2D→Collider, 2D camera→3D camera, 2D trigger→3D trigger, 2D interaction→raycast-based interaction, 2D level layout→3D spatial design.

## Unit 21: Moving from 2D to 3D
*Source: Module 20.*
*Cert tie-in: **Artist Area 1** (vertices/faces/edges) and **Area 2** (Transform tools) both primary modules.*
*Game/UX tie-in: This unit is explicitly framed as transfer, not starting over. The Mechanics you already understand (movement, collision, cameras) don't change, only the space they operate in does.*
*Journal (350-450 words): Pick one Mechanic you're rebuilding in 3D (movement, a collision, a camera). Explain what stays conceptually the same from its 2D version and what genuinely new thinking 3D space requires. Why does treating this as transfer, not a restart, make it easier?*
- [ ] 21.1 Adding the Third Dimension
- [ ] 21.2 X, Y, and Z
- [ ] 21.3 Sprites to 3D Objects
- [ ] 21.4 Rigidbody2D to Rigidbody
- [ ] 21.5 Collider2D to Collider
- [ ] 21.6 Moving in 3D
- [ ] 21.7 2D Cameras vs. 3D Cameras
- [ ] 21.8 Thinking in 3D Space
- [ ] 21.9 Transfer, Not Starting Over
- [ ] 21 Challenge: Rebuild a Familiar Mechanic in 3D

## Unit 22: Building 3D Worlds
*Source: Module 21.*
*Cert tie-in: **Artist Area 1, 2, and 3 all cite this as a primary module** — the single densest Artist unit in the whole course (FBX/OBJ+texture import, Asset Store, vertices/faces/edges, Transform tools, greyboxing, Terrain/landscape materials, material properties, lighting/shadows, rendering-pipeline choice).*
*Game/UX tie-in: Greyboxing and terrain work are Constraint design in three dimensions, deciding what space a player can move through, and landmarks/wayfinding in 3D are Thread 4's "how does the player know where to go" question made spatial.*
*Journal (350-450 words): Describe one 3D space you built this unit (a greybox layout, a terrain, a room). How did you help a player understand where they could go and where they couldn't, without relying only on walls? What landmarks or lighting choices are doing that work?*
- [ ] 22.1 Primitives, Meshes, Vertices, Faces, and Edges
- [ ] 22.2 Importing 3D Assets: FBX, OBJ, and Textures
- [ ] 22.3 Greyboxing with Primitives and Low-Poly Meshes
- [ ] 22.4 Scale and Proportion
- [ ] 22.5 Materials, Textures, and Shader Properties
- [ ] 22.6 Building a 3D Environment
- [ ] 22.7 Terrain and Landscape Basics
- [ ] 22.8 Directional, Point, Spot, and Area Lighting
- [ ] 22.9 Building a Clear and Interesting Game World
- [ ] 22.10 Landmarks and Wayfinding in 3D
- [ ] 22.11 Designing Levels in 3D
- [ ] 22.12 Rendering Pipeline Concepts
- [ ] 22 Project: Small 3D Environment

## Unit 23: 3D Movement, Physics, and Cameras
*Source: Module 22.*
*Cert tie-in: **Programmer Area 2** (22-24 range) and **Artist Area 3** (camera setup/properties) both primary modules.*
*Game/UX tie-in: Third-person, first-person, and isometric cameras aren't just visual choices. Each one changes what Dynamics are even possible (what a player can see, judge distance to, or react to in time), and camera control/player comfort is Aesthetics with real physical stakes.*
*Journal (350-500 words): Compare two camera types you tried this unit (first-person, third-person, or isometric). How did the choice change what the player could see or judge, and what Dynamics became easier or harder as a result? Which would you choose for your capstone game, and why?*
- [ ] 23.1 Moving a Player in 3D
- [ ] 23.2 Character Movement vs. Physics Movement
- [ ] 23.3 3D Collisions and Triggers
- [ ] 23.4 Moving Relative to the Camera
- [ ] 23.5 Camera Component: FOV, Clipping, and Culling
- [ ] 23.6 Third-Person Cameras
- [ ] 23.7 First-Person and Isometric Views
- [ ] 23.8 Camera Control and Player Comfort
- [ ] 23.9 Testing Navigation in 3D
- [ ] 23 Project: 3D Movement Prototype

## Unit 24: Raycasting and 3D Interactions
*Source: Module 23.*
*Cert tie-in: **Programmer Area 2** (22-24 range) primary module.*
*Game/UX tie-in: A raycast is a Mechanic for answering "what is the player looking at right now," and clear interaction prompts (pickups, switches, doors) are Feedback that turns an invisible ray into something a player can actually understand.*
*Journal (350-500 words): Describe one interaction system you built with raycasting (a pickup, switch, or door). How does the player know what they're able to interact with before they try? What would make that Feedback clearer or more confusing?*
- [ ] 24.1 What Is a Raycast
- [ ] 24.2 Detecting Objects
- [ ] 24.3 Interaction Range
- [ ] 24.4 Showing What the Player Is Targeting
- [ ] 24.5 Interaction Prompts
- [ ] 24.6 Pickups, Switches, and Doors
- [ ] 24.7 Making Interactions Clear
- [ ] 24 Project: 3D Interaction System

---

## Phase 5: Independent Game Development *(source Modules 24-28)*

Connected systems, careers/professional practice, planning a realistic original project, prototyping, building, testing, revising, presenting.

## Unit 25: Building More Complex Game Systems
*Source: Module 24.*
*Cert tie-in: **Programmer Area 2** (22-24 range, class recognition/ECS awareness — "targeted certification review") primary module. Resource economies, progression/unlocks, and connected/balanced systems.*
*Game/UX tie-in: Resource economies, progression, and connected systems are where Systems Concepts (resource flow, optimization, balance) stop being individual ideas and start interacting, which is exactly how real games develop Dynamics nobody fully predicts in advance.*
*Journal (400-550 words): Describe one system you built this unit that connects to at least one other system (resources affecting progression, difficulty affecting reward, or similar). What Dynamic emerges from that connection that wouldn't exist if the systems were separate? How did you playtest whether it felt balanced?*
- [ ] 25.1 Resources and Game Economies
- [ ] 25.2 Risk and Reward
- [ ] 25.3 Progression and Unlocks
- [ ] 25.4 Randomness vs. Player Choice
- [ ] 25.5 Cooperation and Competition
- [ ] 25.6 Adjusting Difficulty During Play
- [ ] 25.7 Optimization as a Game System
- [ ] 25.8 Building Systems That Affect Each Other
- [ ] 25.9 Balancing Connected Systems
- [ ] 25 Project: System Design Prototype

## Unit 26: Careers in Game Development
*Source: Module 25.*
*Cert tie-in: none — Thread 8 (Careers/Professional Practice) content. Per the source map, career exploration should really happen throughout the course (career spotlights tied to whatever topic is live that week), not only concentrated here; this unit is the explicit reflection/synthesis point.*
*Game/UX tie-in: This unit steps back from building to ask who actually builds. Every role you've been practicing all year (design, programming, art, playtesting, communicating decisions) maps to a real job, and MDA itself connects most directly to design and player-experience roles.*
*Journal (350-500 words): Which of the roles covered this unit (design, programming, art, QA, production, or another) felt closest to the work you've most enjoyed this year? Connect that to a specific Mechanic, Dynamic, or Aesthetic decision you made in an earlier unit that you're proud of.*
- [ ] 26.1 How Games Get Made
- [ ] 26.2 Game Design
- [ ] 26.3 Gameplay Programming
- [ ] 26.4 UI/UX and Player Experience
- [ ] 26.5 Level Design
- [ ] 26.6 2D and 3D Art
- [ ] 26.7 Animation, VFX, and Technical Art
- [ ] 26.8 Audio and Sound Design
- [ ] 26.9 Writing and Narrative Design
- [ ] 26.10 QA and Player Research
- [ ] 26.11 Production and Project Management
- [ ] 26.12 Portfolios and Showing Your Work
- [ ] 26 Reflection: Where Could I Fit?

## Unit 27: Testing, Debugging, and Improving Games
*Source: Module 26.*
*Cert tie-in: **Programmer Area 1** (debug logs, null-object debugging — explicitly named a primary module) and **Area 3** (data-type errors, public/private problems, naming conventions, accurate comments) both primary. Distinguishes bug vs. usability problem vs. design problem vs. preference (Thread 6).*
*Game/UX tie-in: This unit names the difference this course has been building toward all year: a bug (something broken), a usability problem (something confusing), a design problem (something that doesn't feel good even when it works correctly), and a preference (something that's just not to your taste). Confusing these is exactly what makes "how does the player know" hard to answer well.*
*Journal (400-550 words): Think back across this year's playtesting units (04, 15). Describe a real example from your own project of each: something that was a bug, something that was a usability problem, and something that was really a design problem, not a bug at all. Why does telling these apart matter for what you actually fix?*
- [ ] 27.1 Bugs vs. Design Problems
- [ ] 27.2 Reproducing a Bug
- [ ] 27.3 Finding What Caused the Problem
- [ ] 27.4 Debugging Code
- [ ] 27.5 Debugging Scenes and Components
- [ ] 27.6 Test Cases and Unusual Situations
- [ ] 27.7 Playtesting vs. QA
- [ ] 27.8 Performance Basics
- [ ] 27.9 Accessibility Review
- [ ] 27.10 Usability Review
- [ ] 27.11 Debugging with AI Without Replacing Everything
- [ ] 27 Project: Break, Test, Fix

## Unit 28: Planning Your Own Game
*Source: Module 27.*
*Cert tie-in: **Artist Area 2** (greyboxing) primary module. Otherwise pre-production/planning (Thread 3 Game Design + Thread 7 Communication), not itself heavily cert-mapped — the real cert payoff of this planning work lands in Unit 29's capstone build.*
*Game/UX tie-in: Planning starts with player experience, not features. "Who is the game for" and "what should it feel like" come before any Mechanic gets written down, MDA worked backward: starting from the Aesthetic you want and designing Mechanics to produce it.*
*Journal (450-600 words): Write your capstone's starting design pitch: who is the game for, what should playing it feel like (the Aesthetic you're aiming for), and what Core Mechanic and Gameplay Loop you think will produce that feeling. What's your biggest open question going into Unit 29?*
- [ ] 28.1 Start with the Player Experience
- [ ] 28.2 Who Is the Game For
- [ ] 28.3 Learning from Players
- [ ] 28.4 What Should the Game Feel Like
- [ ] 28.5 Core Mechanic and Gameplay Loop
- [ ] 28.6 Looking at Similar Games
- [ ] 28.7 Paper and Digital Prototypes
- [ ] 28.8 Testing the Biggest Question First
- [ ] 28.9 Must-Have, Nice-to-Have, Stretch Goals
- [ ] 28.10 Keeping the Project Realistic
- [ ] 28.11 Roles, Milestones, and Team Planning
- [ ] 28 Project: Capstone Prototype

## Unit 29: Capstone — Build Your Own Game
*Source: Module 28.*
*Cert tie-in: **Programmer Area 1** (explicitly named a primary module for debugging/API) and **Artist Area 2, 3** (greyboxing/scene design, lighting/cameras/materials, both explicitly named primary modules for capstone). This is the course's cert-readiness synthesis point.*
*Game/UX tie-in: Full-year synthesis. The postmortem (29.21) is this course's version of a design document, covering Mechanics, Dynamics, Aesthetics, and at least one usability decision, for a game the student actually designed, built, tested, and shipped.*
*Journal (500-700 words, ~2 pages): Write a short postmortem for your capstone game. Include: (1) your game's core Mechanics (the actual Rules and systems you built), (2) what Dynamics emerged when real players played it, (3) the Aesthetic or emotional experience you were aiming for and whether you achieved it, and (4) at least one accessibility or usability decision you made to keep the game clear and fair for someone playing it for the first time. Close by looking back at your very first Unit 02 journal entry. How has your thinking about games, Unity, and design grown across the year?*
- [ ] 29.1 Game Idea and Target Player
- [ ] 29.2 Research and Inspiration
- [ ] 29.3 Goals and Success Criteria
- [ ] 29.4 Core Loop and System Map
- [ ] 29.5 Scope and Feature Priorities
- [ ] 29.6 Technical Plan
- [ ] 29.7 Player Flow and Interface
- [ ] 29.8 Build the Core Mechanic
- [ ] 29.9 Build the Smallest Playable Version
- [ ] 29.10 Test and Debug
- [ ] 29.11 Playtest with Players
- [ ] 29.12 Study What Happened
- [ ] 29.13 Decide What to Change
- [ ] 29.14 Build V2
- [ ] 29.15 Improve Game Feel and Presentation
- [ ] 29.16 Accessibility and Usability Review
- [ ] 29.17 Final Testing and Polish
- [ ] 29.18 Publish and Present
- [ ] 29.19 Explain Your Design and Code Choices
- [ ] 29.20 Document Important AI-Assisted Work
- [ ] 29.21 Postmortem and Reflection
- [ ] 29 Final Game

---

## Pacing, added 2026-08-17 per `../../CLAUDE.md`'s Hard Constraints

AP testing runs mid-to-late April; seniors are typically checked out by mid-May; motivation drops hard once those periods hit. Applying that here:

- **Recommend the Unity Programmer certification attempt land in the Unit 20-21 window** (end of Phase 3 / start of Phase 4 — after the platformer, prefabs, animation/state-machine, and scene-management units that carry the bulk of the Programmer objective mapping, before the heavier 3D content of Phase 4). This matches the source map's own guidance ("the exact point can remain flexible so certification preparation does not interrupt a major project cycle") while giving real buffer before mid-April. **Not a scheduled date** — exact week-by-week pacing is blocked on the official CPS academic calendar, see `../../open-questions.md`.
- **Phase 4 (3D transfer, Units 21-24) and Phase 5 (Units 25-29, including the capstone) are the parts of this course most at risk of running into the AP-testing/senior-checkout window**, given how much content they cover. Two options worth deciding between once real pacing data exists: (a) compress/prioritize Phase 4-5 so the capstone (Unit 29) is genuinely finished before mid-April, matching Game I's approach; or (b) treat the capstone's later stages (V2, polish, presentation, postmortem — Unit 29.14 onward) as **continued, student-driven project work** that's fine to continue through the low-motivation stretch — not because it's lower-stakes (corrected 2026-08-18: per Jay, this window should still mean real project work, not reduced-effort filler), but because it's self-directed and doesn't depend on fresh full-class instruction the way new core content would. **Not decided — flag for Jay.**
- Unity Artist certification attempts (for students who reach readiness) naturally happen later, since Artist progress accumulates through Phase 4-5's 3D content — likely landing in or after the AP-testing window for most students. This suits the pacing goal well for the same delivery-independence reason: attempting an *optional* second certification is real, substantive work that doesn't require fresh full-class motivation to progress, not a lightweight add-on.

---

## Game Design and Journal Threads (added 2026-08-18)

Per Jay: this course needs the same kind of year-long, iteratively-building reflective throughline Game I has (`../python/course-plan.md`'s "Game Design, UX, and Journal Threads" section), not a separate invention. **Not a straight copy of Python's MDA-only framing, though** — the source map's own **Thread 3: Game Design** and **Thread 4: Player Experience, UI, and Usability** (`../../starter context/Unity_Game_Development_Course_Map_Certification_Aligned_Complete.md`, lines 822-967) already define a richer, course-native vocabulary than MDA alone: Goal, Rules, Constraints, Mechanics, Core Mechanic, Gameplay Loop, Feedback, Game State (Thread 3's foundational concepts); a long list of Player Experience concepts (challenge, flow, pacing, tension, reward, game feel, and more); Systems Concepts (cause and effect, emergence, resource flow, and more); and Thread 4's central question, **"How does the player know?"** Reusing this instead of re-importing Python's simpler 3-term framing wholesale keeps the journal thread native to what this course already teaches, while still bridging to Game I's MDA for continuity (a dual-enrolled or transferring student should recognize the connection, not see two unrelated systems).

**The bridge:** MDA stays the connecting lens across both Game courses (Mechanics ≈ Thread 3's Mechanics/Core Mechanic/Gameplay Loop; Dynamics ≈ Thread 3's Systems Concepts, emergent play from rules interacting; Aesthetics ≈ Thread 4's Player Experience concepts and the "How does the player know?" question). Every journal prompt below asks students to name the Mechanic, Dynamic, and Aesthetic **using this course's own richer vocabulary**, not just the bare three MDA words.

**Revisit schedule (5 touchpoints, same rhythm as Python's 5-touchpoint schedule across its 21 units, scaled to this course's 29):**

| Unit | Why it's a touchpoint |
|---|---|
| 02: How Games Work | Full MDA + Thread 3/4 vocabulary introduction — deepened from the shared Unit 0's light Game Design/Unity-tagged callout, which only names MDA, doesn't teach it fully. |
| 09: Building a 2D Platformer | First real playable game milestone (~31% through the course) — students can now point at Mechanics they actually built. |
| 14: Designing for the Player | Deepest MDA revisit of the year (~48% through) — the unit title is nearly synonymous with the framework itself. |
| 20: Enemies and Game AI | Systems producing emergent Dynamics (~69% through) — AI behavior is where "Mechanics → Dynamics" becomes most visible. |
| 29: Capstone | Full-year synthesis, explicit callback to the Unit 02 entry, mirrors Python's Unit 20 capstone journal closing the loop back to Unit 00. |

**Word-count progression (floors, not caps, same principle as Python's):**

| Stage | Units | Word range | What's expected |
|---|---|---|---|
| 1. Warm-Up | 01-04 (Phase 1) | 50-100 | Naming Mechanics/Dynamics/Aesthetics in games students already play, little to no Unity skill required yet |
| 2. Describing How It Works | 05-14 (Phase 2, first half) | 100-200 | Connecting a Unity concept just learned to a Thread 3/4 vocabulary term |
| 3. Analyzing and Justifying | 15-20 (Phase 2 close, Phase 3) | 200-350 | Structured reasoning, first real playtesting-informed reflection (Unit 15 pairs naturally here) |
| 4. Designing and Synthesizing | 21-29 (Phase 4-5) | 350-700 | Full design-document-style writing, explicit callbacks, capstone closes the year |

**Per-unit annotation lines: written 2026-08-18.** Every one of the 29 units above now has its own *Game/UX tie-in* and *Journal* line, following this schedule and vocabulary exactly. All 29 units mapped cleanly onto the Thread 3/4 vocabulary; no genuine bad-fit cases came up while writing them.

## Open Items This Course-Plan Doesn't Resolve

- ~~No Game/UX-tie-in or Journal-thread section~~ — **resolved 2026-08-18**, framework and all 29 per-unit annotation lines both done, see the section above.
- **Game of the Week, the AI-Assisted Development workflow (Ask → Understand → Build → Test → Explain), and the Career Spotlight library are real, extensively-designed parts of the source map** (its own Threads 7-10 and the Game of the Week Concept Map) but are **not reproduced in this file** — they're cross-cutting structures that span every unit rather than living in one, and copying ~900 lines of source material here would make this file unusable as a checklist. Read the source map directly (`../../starter context/Unity_Game_Development_Course_Map_Certification_Aligned_Complete.md`, "Threads Throughout the Course" and "Game of the Week Integration" sections) before authoring any unit's real lesson content — those threads are meant to recur inside the units above, not sit beside them.
- **Unity Learn licensing** for curated third-party content (especially 3D, Units 21-24) — not checked, see `../../open-questions.md`.
- **The "What Still Needs to Be Created" list in the source map** (23 numbered items: module/lesson documentation templates, the four-week MakeCode sequence, a MakeCode-to-Unity transfer guide, concept/pattern libraries, playtesting/research toolkits, mastery-check definitions, etc.) is real scoping work the source map itself flags as undone — none of it is built, this course-plan is strictly the unit/lesson skeleton layer.
- **Project pathways (Guided Build / Design Challenge / Build Your Own) and depth tiers (Starter / Skilled / Legendary / Mythic)** are specified in the source map and structurally identical to Web Dev's own adaptive-pathway model (`../web-dev/course-plan.md`) — worth authoring as a genuinely shared cross-course pattern rather than two separate implementations, not decided yet.
