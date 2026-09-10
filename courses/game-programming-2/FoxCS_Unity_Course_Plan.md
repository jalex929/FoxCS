# FoxCS: Game Design & Unity: Course Plan

Source basis: FoxCS Unity planning, Unity Learn **Unity Essentials** and **Game Development** pathways, and the Unity Certified User: Programmer certification objectives. This file is the master scope skeleton for the FoxCS Game Design / Unity course.

Planning status: **Draft course map — 2026-09-08**

Current-year pacing note: Students are at the **start of Week 3** when this version of the map begins. Weeks 1–2 are treated as shared onboarding / introductory course experiences rather than future instructional time.

Terminology note: FoxCS uses **Units** and **Lessons** throughout. Unity Learn uses Pathways, Missions/Units, Tutorials, Projects, and Quizzes. This file maps those external resources into FoxCS lesson-sized instructional chunks rather than preserving Unity Learn pacing exactly.

Unity Learn content map: `unity-learn-content-mapping.md` should be maintained as the source of truth for which Unity Learn activities belong to each FoxCS unit, which are required, compressed, optional, deferred, or replaced.

Skills-map expectation: A separate `skills-map.md` should eventually hold the per-lesson skill, misconception, mastery-check, AI-use, certification-objective, and adaptive-question specifications. This course-plan file is the master checklist and sequencing document.

External media expectation: A future `video-resources.md` should track GMTK and other game-design / UX videos assigned to individual lessons.

Legend: ⬜ not started · 🔄 in progress · ✅ drafted · 🔍 reviewed/final

---

# Course Philosophy

This is a **game design and Unity development course**, not a traditional C# programming course.

Students will:

- learn foundational programming/game logic in MakeCode Arcade;
- transition quickly into Unity;
- complete a substantial amount of Unity Learn's Game Development pathway;
- use Unity primarily in 3D for shared instruction;
- use Microsoft Copilot and other approved AI assistance to help create, interpret, modify, and debug Unity C#;
- build enough C# literacy to understand scripts and prepare for the Unity Certified User: Programmer exam;
- repeatedly analyze game design, usability, accessibility, feedback, player experience, and iteration;
- work toward **Unity Certified User: Programmer first**;
- later move toward **Unity Certified User: Artist** or **Unity Certified User: VR Developer** as a specialization.

Students are responsible for understanding the important code and systems they use even when AI helped produce them.

---

# AI-Assisted Development Model

The course-wide progression is:

**USE → INTERPRET → MODIFY → GENERATE → DEBUG → EXPLAIN**

Students should not be expected to generate all C# from memory.

Instead, they should become increasingly able to:

- describe a desired behavior precisely;
- identify the GameObjects and Components involved;
- ask AI for implementation help;
- read the proposed code;
- identify important variables, methods, conditions, and references;
- attach/configure scripts correctly;
- test the behavior;
- read Console errors;
- use AI to diagnose problems;
- compare AI advice against Unity documentation and observed behavior;
- explain what ultimately worked.

## AI Development Log

Students maintain one persistent **FoxCS AI Development Log**, likely as a Google Doc.

Required fields for significant entries:

- Date
- Project / Lesson
- Goal
- Problem / Question
- Copilot share link
- What Copilot suggested
- What I tested
- Result
- What actually fixed or improved it
- What I understand now
- Still unclear (optional)

Not every AI interaction requires a log entry. Required AI checkpoints are identified throughout this map.

---

# Unity Learn Role

Unity Learn is a **primary structured learning spine**, but pathway completion percentage is not the goal.

FoxCS uses Unity Learn selectively:

## Unity Essentials

Shared core:
- Editor Essentials
- 3D Essentials
- selected Programming Essentials

Deferred:
- Audio Essentials
- Publishing Essentials

Optional:
- 2D Essentials

## Game Development

Expected for most students:
- compressed Get Started in Unity
- Create a Basic 3D Game
- Planning a Game
- Audio
- Visual Effects
- User Interfaces
- Animation
- selected Shaders and Materials
- selected Lighting
- Iterate on Your Game

Optional / differentiated:
- Create a Basic 2D Game

Adapted:
- Associate-oriented certification preparation is replaced by FoxCS **Unity Certified User: Programmer** preparation.

---

# Certification Priority

## First shared target

**Unity Certified User: Programmer**

Shared course content intentionally builds:

- debugging and problem solving;
- Unity API interpretation;
- creating / adapting code;
- evaluating code;
- Unity interface navigation;
- GameObject / Component relationships;
- variables and common data types;
- methods and parameters;
- conditions and control flow;
- collections;
- event/lifecycle functions;
- Animator/state-machine interpretation;
- Console/error literacy.

## Later specializations

After serious Programmer preparation / certification attempt:

### Art-forward
Unity Programmer → Creative Core / visual systems → Unity Artist

### Interaction/dev-forward
Unity Programmer → VR Development → Unity VR Developer

---

# Game Design / UX Thread

Every unit should connect technical development to player experience.

Recurring concepts:

- player goals
- mechanics
- feedback
- affordance
- controls
- game feel
- information hierarchy
- level design
- difficulty
- accessibility
- onboarding
- player testing
- iteration
- ethical engagement
- visual/audio communication

External game-design media such as **Game Maker's Toolkit (GMTK)** should be assigned when it directly informs something students can inspect, build, test, or revise.

The instructional pattern should be:

**WATCH / READ → IDENTIFY → APPLY → TEST → REFLECT**

---

# Progression Model

## Early Course — FOLLOW
Students complete structured tasks.

## Early Unity — MODIFY
Students alter prebuilt scenes, Microgames, and tutorial projects.

## Core Unity — COMBINE
Students connect multiple systems.

## Programmer Preparation — BUILD FROM REQUIREMENTS
Students are told what behavior is needed, but not every implementation step.

## Specialization / Capstone — DESIGN INDEPENDENTLY
Students choose appropriate tools, resources, and implementation strategies.

---

# Unit 00: Shared Course Onboarding

**Timing:** Weeks 1–2, substantially completed before this map begins

Shared with the broader FoxCS onboarding structure where appropriate.

**Certification tie-in:** none directly.

**Game/UX tie-in:** Games are systems designed for people. Introduce player, goal, rules, interaction, challenge, feedback, and experience.

**AI tie-in:** Responsible AI use, asking productive questions, verifying answers, and understanding that using AI does not remove responsibility for understanding submitted work.

- ⬜ 00.1 Course Navigation and Expectations
- ⬜ 00.2 How Learning Works / Productive Struggle
- ⬜ 00.3 Responsible AI Use
- ⬜ 00.4 Digital Workflows and Submissions
- ⬜ 00.5 Introduction to Game Design
- ⬜ 00.6 Player Goals, Rules, and Feedback
- ⬜ 00 Project / Intro Activity: Shared FoxCS onboarding product

---

# Unit 01: Game Systems with MakeCode Arcade

**Timing target:** Weeks 3–4  
**Current position:** Students begin this map at the start of Week 3.

**Purpose:** Learn programming/game-system concepts without simultaneously learning Unity, C#, and 3D development.

**Unity bridge:** Events, variables, conditions, functions, input, coordinates, collisions, and state will reappear in Unity.

**Certification tie-in:** indirect preparation for code evaluation and control-flow concepts.

**Game/UX tie-in:** What does the player do, what does the system do in response, and how does the player know what happened?

**AI tie-in:** AI may explain logic or help diagnose MakeCode behavior, but MakeCode should remain primarily a concept-building environment.

### Skills students should leave Unit 01 with

Students can:

- identify player input;
- explain event-driven behavior;
- use variables to represent game state;
- recognize conditions;
- use simple functions;
- understand position through coordinates;
- create collision/overlap interactions;
- recognize repeated behavior;
- define a game objective;
- create win/lose conditions;
- identify multiple forms of player feedback;
- test another student's game without designer explanation;
- make a revision based on observed behavior.

- ⬜ 01.1 Player Input and Events
- ⬜ 01.2 Coordinates and Position
- ⬜ 01.3 Variables and Game State
- ⬜ 01.4 Conditions and Rules
- ⬜ 01.5 Collision and Interaction
- ⬜ 01.6 Functions and Reusable Behaviors
- ⬜ 01.7 Repetition and Game Loops
- ⬜ 01.8 Player Feedback and Game Feel
- ⬜ 01.9 First Peer Playtest
- ⬜ 01 Project: Small MakeCode Game

**Minimum advancement checkpoint:** Student can explain input, variable, condition, event, collision, function, game state, and feedback using their own game.

**Recovery route:** Finish a smaller MakeCode project with fewer features but demonstrate all checkpoint vocabulary.

**Ahead route:** Add a new mechanic, difficulty progression, stronger feedback, or a second level; begin Unity readiness material when approved.

---

# Unit 02: Unity Readiness and Course Workflow

**Timing target:** beginning of Week 5

**Purpose:** Explicitly establish course-specific setup and submission workflows before students enter Unity Learn.

**Installed software assumption:** Unity Hub, Unity Editor, and VS Code are already installed on student computers.

**Certification tie-in:** interface/tool fluency.

**AI tie-in:** Establish Copilot + AI Development Log routine.

### Skills students should leave Unit 02 with

Students can:

- access the assigned Unity Learn account/pathway;
- open Unity Hub;
- open the correct Unity project;
- identify where a project is stored;
- open scripts in VS Code;
- return to Unity and allow scripts to compile;
- locate the Console;
- save scenes;
- use Copilot;
- create a Copilot share link;
- maintain the AI Development Log;
- submit required evidence in Moodle.

- ⬜ 02.1 Access Unity Learn
- ⬜ 02.2 Open the Correct Unity Project
- ⬜ 02.3 Project Folder and Save Expectations
- ⬜ 02.4 Unity ↔ VS Code Workflow
- ⬜ 02.5 Console and Compilation Check
- ⬜ 02.6 Copilot and Share Links
- ⬜ 02.7 Create the AI Development Log
- ⬜ 02.8 Moodle Unity Submission Routine
- ⬜ 02 Readiness Check

**Important authoring note:** Give students exact click-by-click setup guidance. Do not assume prior knowledge simply because software is installed.

---

# Unit 03: Unity Editor and 3D Essentials

**Timing target:** Week 5

**Unity Learn ownership:**  
- Unity Essentials — Editor Essentials  
- Unity Essentials — 3D Essentials  
- Game Development — Get Started in Unity (compressed / mastery-check use)

**Certification tie-in:** very strong interface/navigation foundation.

**Game/UX tie-in:** Spatial scale, predictable physical behavior, and the relationship between what the designer builds and what the player can perceive.

**AI tie-in:** Explain Mode; use AI to understand components and diagnose setup problems rather than generate substantial code.

### Skills students should leave Unit 03 with

Students can:

- distinguish Unity Hub from Unity Editor;
- identify Scene, Game, Hierarchy, Inspector, Project, and Console;
- navigate a 3D scene;
- select and manipulate GameObjects;
- use Move, Rotate, and Scale;
- read Transform values;
- create primitive objects;
- explain GameObject vs. Component;
- add/remove components;
- explain Rigidbody;
- explain Collider;
- observe basic physics;
- create/use a Prefab;
- enter/exit Play Mode safely;
- recognize that Play Mode changes may not persist.

- ⬜ 03.1 Editor Interface
- ⬜ 03.2 Navigating the Scene View
- ⬜ 03.3 GameObjects and Components
- ⬜ 03.4 Transform: Position, Rotation, Scale
- ⬜ 03.5 Primitive 3D Objects
- ⬜ 03.6 Rigidbody and Basic Physics
- ⬜ 03.7 Colliders
- ⬜ 03.8 Prefabs
- ⬜ 03.9 Play Mode and Safe Experimentation
- ⬜ 03.10 Balanced Primitive / Editor Fluency Challenge
- ⬜ 03 Project: Modify a Prebuilt Scene or Microgame

**Minimum advancement checkpoint:** Teacher can name a Unity element or operation and student can locate/use it without step-by-step support.

**Recovery route:** Repeat targeted Unity Essentials tutorials rather than the entire mission.

**Ahead route:** Complete optional Essentials challenges or begin Programming Essentials.

---

# Unit 04: Programming Essentials — Reading and Modifying Unity Scripts

**Timing target:** Week 5–6

**Unity Learn ownership:** Unity Essentials — Programming Essentials

Known activities include:
- Add a movement script
- Create a rotating collectible
- Collect the collectible
- Programming Essentials: More things to try

**Certification tie-in:** very high — creating code, evaluating code, APIs, scripts as Components.

**Game/UX tie-in:** A mechanic is not just code; it is behavior the player experiences.

**AI tie-in:** first required AI Development Log entry.

### Skills students should leave Unit 04 with

Students can:

- locate a script asset;
- attach a script to a GameObject;
- open a script in VS Code;
- recognize a class;
- recognize variables/fields;
- recognize methods;
- recognize component references;
- recognize a condition;
- recognize a Unity API call;
- identify the GameObject that uses a script;
- identify which exposed value changes behavior;
- make a small modification;
- test the modification;
- explain the script in plain language;
- distinguish a code problem from a likely Unity configuration problem.

- ⬜ 04.1 Scripts as Components
- ⬜ 04.2 Reading a Simple Unity Script
- ⬜ 04.3 Variables and Exposed Settings
- ⬜ 04.4 Methods and "When Code Runs"
- ⬜ 04.5 Add a Movement Script
- ⬜ 04.6 Create a Rotating Collectible
- ⬜ 04.7 Collect the Collectible
- ⬜ 04.8 Modify Existing Behavior
- ⬜ 04.9 AI Explain Mode
- ⬜ 04.10 Programming Essentials Extension
- ⬜ 04 Mastery Check: Explain an Unfamiliar Simple Script

**Required AI evidence:** Ask Copilot to explain one Unity script and connect its major pieces to MakeCode concepts. Save the share link and summarize what was learned.

**Minimum advancement checkpoint:** Student does not need to reproduce the script from memory, but must be able to explain the important variables, methods, components, and behavior.

---

# Unit 05: Basic 3D Game I — Player, Camera, and Play Space

**Timing target:** Weeks 6–7

**Unity Learn ownership:** Game Development — Create a Basic 3D Game:
- Introduction / setup
- Moving the Player
- Moving the Camera
- Setting up the Play Area

**Certification tie-in:** strong — GameObjects, components, scripts, variables, methods, APIs.

**Game/UX tie-in:** Controls and camera design determine how the player understands and experiences movement.

**Suggested media:** GMTK or similar game-feel / movement analysis.

### Skills students should leave Unit 05 with

Students can:

- set up a small 3D game scene;
- identify the player GameObject;
- configure player physics;
- implement or adapt movement;
- tune movement variables;
- identify the code that handles movement;
- configure a camera;
- explain what information the camera provides;
- create a greyboxed play area;
- establish boundaries;
- think intentionally about scale;
- test control responsiveness.

- ⬜ 05.1 Set Up the 3D Game
- ⬜ 05.2 Player GameObject and Required Components
- ⬜ 05.3 Moving the Player
- ⬜ 05.4 Reading the Movement Script
- ⬜ 05.5 Tuning Movement
- ⬜ 05.6 Moving the Camera
- ⬜ 05.7 Camera and Player Experience
- ⬜ 05.8 Greyboxing the Play Area
- ⬜ 05.9 Scale, Boundaries, and Readability
- ⬜ 05 Project Checkpoint: Playable Movement Prototype

**Required AI checkpoint:** Explain or adapt the player controller. Student must identify which values change speed/feel and what components the script requires.

**Design experiment:** Create at least two movement configurations and compare which feels better and why.

---

# Unit 06: Basic 3D Game II — Collectibles, Collision, and Interaction

**Timing target:** Week 7–8

**Unity Learn ownership:** Game Development — Create a Basic 3D Game:
- Creating Collectibles
- Detecting Collisions with Collectibles

**Certification tie-in:** very high — component relationships, physics, callbacks, evaluating/debugging code.

**Game/UX tie-in:** Interactions need clear affordances and feedback.

### Skills students should leave Unit 06 with

Students can:

- create a collectible GameObject;
- create/use a collectible Prefab;
- distinguish Rigidbody and Collider responsibilities;
- distinguish a Collider interaction from a Trigger;
- recognize collision/trigger callbacks;
- connect player contact to a gameplay outcome;
- identify tags/layers when relevant;
- diagnose why an interaction is not firing;
- add feedback to an interaction.

- ⬜ 06.1 Building a Collectible
- ⬜ 06.2 Collectible Prefabs
- ⬜ 06.3 Collision vs. Trigger
- ⬜ 06.4 Detecting the Player
- ⬜ 06.5 Collision / Trigger Event Methods
- ⬜ 06.6 Common Physics Setup Errors
- ⬜ 06.7 Tags, Layers, and Object Identification
- ⬜ 06.8 Interaction Feedback
- ⬜ 06 Debugging Lab: Why Isn't My Collectible Working?
- ⬜ 06 Project Checkpoint: Working Collectible System

**Required AI checkpoint:** Student asks Copilot for a diagnostic checklist before asking for replacement code and logs what actually fixed the problem.

**Minimum advancement checkpoint:** Student can explain why their interaction fires and identify the necessary objects/components/settings.

---

# Unit 07: Basic 3D Game III — Score, UI, Navigation, and Build

**Timing target:** Weeks 8–9

**Unity Learn ownership:** Game Development — Create a Basic 3D Game:
- Displaying Score and Text
- Adding AI Navigation
- Building the Game
- Unit quiz

**Certification tie-in:** UI events/state and code interpretation; AI navigation itself is less central.

**Game/UX tie-in:** Information hierarchy and communicating progress.

### Skills students should leave Unit 07 with

Students can:

- represent score/state with a variable;
- update state after gameplay events;
- display state through UI;
- connect a UI reference to code;
- make instructions readable;
- explain when on-screen information is or is not useful;
- configure simple built-in navigation if assigned;
- distinguish built-in Unity systems from custom scripts;
- produce/test a basic build.

- ⬜ 07.1 Game State and Score
- ⬜ 07.2 Connecting Game State to UI
- ⬜ 07.3 UI Readability and Information Hierarchy
- ⬜ 07.4 Win / Completion Feedback
- ⬜ 07.5 AI Navigation — Core Concepts
- ⬜ 07.6 AI Navigation — Implementation (recommended, may compress)
- ⬜ 07.7 Build the Game
- ⬜ 07.8 Test the Built Experience
- ⬜ 07.9 Game Development 3D Quiz / Knowledge Check
- ⬜ 07 Project: First Complete 3D Game

**Major milestone:** Students finish a small, complete, playable 3D Unity game.

**Ahead route:** Optional Game Development 2D mission or begin original-game planning.

---

# Unit 08: Planning an Original Game

**Timing target:** Weeks 9–10

**Unity Learn ownership:** Game Development — Planning a Game

**Certification tie-in:** indirect but important — prototyping, translating requirements into systems, iteration.

**Game/UX tie-in:** central.

**AI tie-in:** use AI to find gaps and ask questions, not to design the whole project.

### Skills students should leave Unit 08 with

Students can:

- define a target player;
- identify the core game loop;
- define player actions;
- identify objectives;
- identify failure/success conditions;
- define feedback systems;
- distinguish core features from optional scope;
- create a lightweight GDD;
- identify technical requirements;
- identify art/audio/UI needs;
- plan a minimum viable prototype;
- identify likely accessibility/usability risks;
- revise a design based on feasibility.

- ⬜ 08.1 What Is a Game Design Document?
- ⬜ 08.2 Player, Goal, and Core Loop
- ⬜ 08.3 Mechanics and Rules
- ⬜ 08.4 Feedback and Player Information
- ⬜ 08.5 Scope and Minimum Viable Game
- ⬜ 08.6 Technical Systems Inventory
- ⬜ 08.7 Art, Audio, and UI Needs
- ⬜ 08.8 Accessibility / Usability Risk Scan
- ⬜ 08.9 Versioning / Project Organization
- ⬜ 08.10 AI Gap-Finding Review
- ⬜ 08 Project: Original Game GDD + Prototype Plan

**Required AI prompt pattern:** Give AI the concept and ask it to identify unclear rules, edge cases, missing systems, and questions the designer should answer without rewriting the design.

---

# Unit 09: Building Gameplay Systems with AI Assistance

**Timing target:** Weeks 10–11

**Unity Learn ownership:** FoxCS synthesis of skills from Programming Essentials + Basic 3D Game. This unit begins reducing step-by-step tutorial dependence.

**Certification tie-in:** strong — creating/evaluating code, variables, methods, components.

**Game/UX tie-in:** Every technical system should exist to create a player-facing mechanic or rule.

### Skills students should leave Unit 09 with

Students can:

- turn a plain-language requirement into a system plan;
- identify involved GameObjects/components;
- ask AI for a simple implementation;
- read the returned script before running it;
- identify configuration steps;
- test incrementally;
- modify variables/conditions;
- connect multiple simple systems;
- explain important implementation decisions.

- ⬜ 09.1 Requirement → System
- ⬜ 09.2 GameObject / Component Planning
- ⬜ 09.3 AI Build Mode
- ⬜ 09.4 Simple Doors and Switches
- ⬜ 09.5 Pickups and Inventory-Like State
- ⬜ 09.6 Health and Damage
- ⬜ 09.7 Timers and Objectives
- ⬜ 09.8 Reusable Prefab Systems
- ⬜ 09.9 Arrays / Lists as Collections of Game Objects
- ⬜ 09.10 Combining Systems
- ⬜ 09 Project: One Original Gameplay System

**Minimum advancement checkpoint:** Student receives a behavior requirement and can build/adapt a working solution with AI/tutorial/documentation support, then explain it.

---

# Unit 10: Audio and Player Feedback

**Timing target:** Week 11–12

**Unity Learn ownership:** Game Development — Audio  
Unity Essentials Audio may be used as remediation/support.

**Certification tie-in:** low to medium.

**Game/UX tie-in:** very high — sound as feedback, atmosphere, direction, and communication.

### Skills students should leave Unit 10 with

Students can:

- identify Audio Clip, Audio Source, and Audio Listener;
- add background music;
- trigger sound effects;
- configure 3D/spatial audio;
- understand attenuation at a basic level;
- connect sound to gameplay events;
- explain what information a sound communicates;
- avoid relying on sound alone for essential information where accessibility requires alternatives.

- ⬜ 10.1 Get Started with Audio
- ⬜ 10.2 Audio Source, Clip, and Listener
- ⬜ 10.3 2D vs. 3D / Spatial Sound
- ⬜ 10.4 Gameplay Sound Effects
- ⬜ 10.5 Audio Effects and Refinement
- ⬜ 10.6 Soundscape Challenge
- ⬜ 10.7 Audio as Feedback
- ⬜ 10.8 Audio Accessibility
- ⬜ 10 Project: Add Intentional Audio to Your Game

**Optional:** Game Development "Audio for 2D Projects" for students developing 2D games.

---

# Unit 11: Visual Effects and Communication

**Timing target:** Week 12–13

**Unity Learn ownership:** Game Development — Visual Effects

**Certification tie-in:** low to medium.

**Game/UX tie-in:** VFX should communicate state/action rather than exist only as decoration.

### Skills students should leave Unit 11 with

Students can:

- identify/configure a Particle System;
- manipulate basic particle properties;
- create an environmental effect;
- create an event/burst effect;
- trigger an effect from gameplay;
- position effects correctly;
- explain what an effect communicates to the player;
- recognize when feedback is excessive or unclear.

- ⬜ 11.1 Get Started with VFX
- ⬜ 11.2 Particle System Anatomy
- ⬜ 11.3 Environmental Effects
- ⬜ 11.4 Burst / Event Effects
- ⬜ 11.5 Triggering Effects from Gameplay
- ⬜ 11.6 VFX Debugging
- ⬜ 11.7 Feedback vs. Decoration
- ⬜ 11 Challenge: Add Some Magic
- ⬜ 11 Project: Add Purposeful VFX to Your Game

---

# Unit 12: User Interfaces and Game UX

**Timing target:** Weeks 13–14

**Unity Learn ownership:** Game Development — User Interfaces

**Certification tie-in:** medium to high, especially UI events and script references.

**Game/UX tie-in:** extremely high.

### Skills students should leave Unit 12 with

Students can:

- create readable UI;
- display game-state information;
- create buttons;
- use toggles/sliders where appropriate;
- connect UI events to behavior;
- organize multiple screens;
- reason about hierarchy and visual priority;
- test UI at different resolutions/aspect ratios;
- identify usability/accessibility problems;
- diagnose missing UI references or event connections.

- ⬜ 12.1 What Information Does the Player Need?
- ⬜ 12.2 Canvas and UI Structure
- ⬜ 12.3 Text and Readability
- ⬜ 12.4 Buttons and Events
- ⬜ 12.5 Toggles and Sliders
- ⬜ 12.6 Game-State Displays
- ⬜ 12.7 Menus and Screen Management
- ⬜ 12.8 Responsive UI
- ⬜ 12.9 UI Accessibility
- ⬜ 12.10 Debugging UI References
- ⬜ 12 Project: Usable Game Interface

**Required AI checkpoint:** Diagnose or trace a UI/state/event issue; save the share link and explain the actual cause.

---

# Unit 13: Animation and State Machines

**Timing target:** Weeks 14–15

**Unity Learn ownership:** Game Development — Animation

**Certification tie-in:** high — Animator, parameters, transitions, function/state-machine understanding.

**Game/UX tie-in:** Animation communicates state, anticipation, action, responsiveness, and consequence.

### Skills students should leave Unit 13 with

Students can:

- identify animation clips;
- use an Animator component;
- open/read an Animator Controller;
- identify states;
- identify transitions;
- identify parameters;
- distinguish Bool / Trigger / numeric parameters conceptually;
- connect script/state to animation;
- explain what must become true for a transition;
- diagnose a basic Animator problem.

- ⬜ 13.1 Animation Clips
- ⬜ 13.2 Animator Components and Controllers
- ⬜ 13.3 States
- ⬜ 13.4 Transitions
- ⬜ 13.5 Parameters
- ⬜ 13.6 Gameplay → Animation
- ⬜ 13.7 Imported / Keyframed Animation
- ⬜ 13.8 Animation as Feedback
- ⬜ 13.9 Animator Debugging
- ⬜ 13 Project: Animated Gameplay State

**Required AI checkpoint:** Ask AI to walk through an Animator + relevant script together; independently explain the transition logic afterward.

---

# Unit 14: Materials, Shaders, and Lighting

**Timing target:** Weeks 15–16

**Unity Learn ownership:**  
- Game Development — Shaders and Materials  
- Game Development — Lighting

**Certification tie-in:** low for Programmer; high future value for Artist.

**Game/UX tie-in:** visual hierarchy, mood, readability, navigation, and communication.

**Scope note:** Not every advanced lighting/shader activity must be completed before Programmer certification.

### Skills students should leave Unit 14 with

Students can:

- distinguish material from shader conceptually;
- apply and modify materials;
- use textures;
- recognize surface properties;
- use lighting intentionally;
- identify common light types in their scene;
- change intensity/color/range;
- use light to direct attention;
- recognize performance implications at a basic level;
- troubleshoot a basic dark/overexposed/pink-material situation.

- ⬜ 14.1 Materials and Surface Appearance
- ⬜ 14.2 Shaders: What They Do
- ⬜ 14.3 Textures and Surface Detail
- ⬜ 14.4 Materials for Readability
- ⬜ 14.5 Lighting Fundamentals
- ⬜ 14.6 Light Types
- ⬜ 14.7 Shadows and Mood
- ⬜ 14.8 Lighting for Navigation / Attention
- ⬜ 14.9 Advanced Lighting / Probes (optional before Programmer)
- ⬜ 14 Project: Visual Readability Pass

**Artist bridge:** Students who later pursue Artist will revisit this content in substantially greater depth.

---

# Unit 15: Game Feel, Level Design, Difficulty, and Accessibility

**Timing target:** Weeks 16–17

**Unity Learn ownership:** FoxCS game-design expansion; supports Game Development "Iterate on Your Game."

**Certification tie-in:** indirect.

**Game/UX tie-in:** central.

**Suggested media:** curated GMTK videos such as movement/game feel, level design, accessibility, difficulty, feedback, and ethical engagement.

### Skills students should leave Unit 15 with

Students can:

- define game feel using observable characteristics;
- tune exposed variables intentionally;
- compare mechanic variants;
- identify affordances;
- use level design to teach a mechanic;
- apply Introduce → Practice → Twist → Combine;
- distinguish challenge from unfairness;
- consider checkpoints and cost of failure;
- identify accessibility barriers;
- propose alternate ways to communicate important information;
- justify a design change based on player experience.

- ⬜ 15.1 What Is Game Feel?
- ⬜ 15.2 Tuning Movement and Responsiveness
- ⬜ 15.3 Affordance and Player Expectations
- ⬜ 15.4 Teaching Mechanics Through Levels
- ⬜ 15.5 Introduce → Practice → Twist → Combine
- ⬜ 15.6 Difficulty, Fairness, and Recovery
- ⬜ 15.7 Accessibility: Visual Information
- ⬜ 15.8 Accessibility: Audio and Controls
- ⬜ 15.9 Accessibility: Timing / Cognitive Load
- ⬜ 15 Project: Game Feel / Accessibility Improvement

---

# Unit 16: Playtesting and Iteration

**Timing target:** Weeks 17–18

**Unity Learn ownership:** Game Development — Iterate on Your Game, expanded substantially by FoxCS.

**Certification tie-in:** high through prototyping, debugging, iteration, and problem solving.

**Game/UX tie-in:** extremely high.

### Skills students should leave Unit 16 with

Students can:

- define a test question;
- prepare a playable test;
- observe without over-explaining;
- record behavior/evidence;
- distinguish bug, confusion, difficulty, and preference;
- identify recurring patterns;
- prioritize issues;
- revise based on evidence;
- explain why a piece of feedback was accepted/rejected;
- compare before/after behavior;
- recognize when a problem is design-related rather than code-related.

- ⬜ 16.1 What Are We Testing?
- ⬜ 16.2 Preparing a Playtest
- ⬜ 16.3 Observing Without Explaining
- ⬜ 16.4 Recording Evidence
- ⬜ 16.5 Bug vs. Usability vs. Preference
- ⬜ 16.6 Prioritizing Changes
- ⬜ 16.7 Iterating on Controls
- ⬜ 16.8 Iterating on Level / Feedback
- ⬜ 16.9 AI as Hypothesis Generator
- ⬜ 16.10 Re-Test
- ⬜ 16 Project: Documented Iteration Cycle

**AI rule:** AI can suggest hypotheses or diagnostic tests, but cannot replace actual user testing evidence.

---

# Unit 17: Unity Programmer Code Literacy

**Timing target:** Weeks 18–20

**Unity Learn ownership:** FoxCS Programmer synthesis; selected Junior Programmer resources may supplement Game Development.

**Certification tie-in:** very high.

**Game/UX tie-in:** code is studied through systems students have actually used.

### Skills students should leave Unit 17 with

Students can recognize and reason about:

- `using` statements/imports;
- class declarations;
- fields/variables;
- `int`, `float`, `bool`, `string`;
- GameObject/component references;
- public/private concepts;
- method names and bodies;
- parameters;
- return-value concept;
- assignments;
- comparisons;
- conditions;
- arrays;
- Lists;
- Dictionaries at recognition level if required by objectives;
- Unity lifecycle/event methods;
- readable comments/naming;
- Animator/state logic.

- ⬜ 17.1 Anatomy of a Unity Script
- ⬜ 17.2 Variables and Common Data Types
- ⬜ 17.3 Public, Private, and Inspector Exposure
- ⬜ 17.4 Methods
- ⬜ 17.5 Parameters and Return Values
- ⬜ 17.6 Conditions and Comparisons
- ⬜ 17.7 Arrays and Lists
- ⬜ 17.8 Dictionaries / Collections Recognition
- ⬜ 17.9 Start, Update, and Event Methods
- ⬜ 17.10 Reading Component References
- ⬜ 17.11 Reading Animator / State Logic
- ⬜ 17.12 Read Before Asking AI
- ⬜ 17 Mastery Check: Explain an Unfamiliar Unity Script

**Required AI checkpoint:** Analyze unfamiliar certification-style code with Copilot, then answer teacher-authored questions independently.

---

# Unit 18: Debugging, Problem Solving, and Unity API Literacy

**Timing target:** Weeks 20–22

**Certification tie-in:** extremely high — one of the central Unity Programmer domains.

**AI tie-in:** Debug Mode becomes a formal skill.

### Skills students should leave Unit 18 with

Students can:

- use the Console;
- distinguish warning/error;
- identify script and line references in errors;
- recognize basic compilation errors;
- recognize likely runtime errors;
- explain a NullReferenceException conceptually;
- investigate missing Inspector references;
- investigate missing/wrong Components;
- distinguish code error from configuration error;
- diagnose logic that runs but produces the wrong result;
- locate official Unity API documentation;
- find a class;
- find a method/property;
- interpret parameters;
- compare documentation with AI advice;
- create a useful debugging prompt.

- ⬜ 18.1 Reading the Console
- ⬜ 18.2 Compilation Errors
- ⬜ 18.3 Runtime Errors and Exceptions
- ⬜ 18.4 Null References
- ⬜ 18.5 Missing Components and Inspector References
- ⬜ 18.6 Logic Errors
- ⬜ 18.7 Unity API Documentation
- ⬜ 18.8 Reading Method Signatures and Parameters
- ⬜ 18.9 AI Debug Mode
- ⬜ 18.10 Verify Before Replacing Code
- ⬜ 18 Project: Intentionally Broken Unity Debugging Lab

**Required AI evidence:** Significant debugging conversation logged with the final actual cause and fix.

---

# Unit 19: Unity Certified User — Programmer Synthesis and GMetrix

**Timing target:** approximately Weeks 22–25, adjusted to the academic calendar and certification availability.

**Unity Learn ownership:** Replaces/adapts the Associate-focused certification end of Game Development.

**Certification tie-in:** direct.

### Skills reviewed

Students synthesize:

- interface navigation;
- GameObjects/components;
- script attachment/configuration;
- variables/data types;
- methods;
- conditions;
- collections;
- API interpretation;
- event functions;
- Animator/state machines;
- Console errors;
- debugging;
- prototype modification;
- code evaluation.

- ⬜ 19.1 Programmer Objective Overview
- ⬜ 19.2 Interface / Editor Review
- ⬜ 19.3 Code Interpretation Review
- ⬜ 19.4 Components and References Review
- ⬜ 19.5 Conditions / Flow Review
- ⬜ 19.6 Collections Review
- ⬜ 19.7 Animator / State Review
- ⬜ 19.8 Debugging Review
- ⬜ 19.9 Unity API Review
- ⬜ 19.10 GMetrix Diagnostic
- ⬜ 19.11 Targeted Remediation
- ⬜ 19.12 Practice Exam
- ⬜ 19.13 Individual Gap Plan
- ⬜ 19.14 Final Review
- ⬜ 19 Milestone: Unity Certified User — Programmer Exam Attempt

**Differentiation:** Students should receive targeted review based on diagnostic gaps rather than repeating identical content.

**After passing:** Student may begin Unit 20 specialization work earlier.

**After not passing:** Student receives focused remediation and retest opportunities where available.

---

# Unit 20: Post-Programmer Specialization

**Timing target:** after Programmer preparation / attempt

Students choose a primary direction based on interest, progress, available equipment, and time remaining.

---

## Unit 20A: Unity Artist Track

**Primary resource base:** Unity Creative Core + Artist certification objectives.

**Shared prior preparation:** Materials, Lighting, Animation, VFX, UI, Audio, Prefabs, scene design.

### Skills

Students deepen:

- asset importing/organization;
- meshes;
- textures;
- materials;
- shaders;
- Prefabs;
- scene composition;
- greyboxing;
- terrain where relevant;
- lighting;
- shadows;
- cameras;
- animation;
- VFX;
- rendering;
- visual polish.

- ⬜ 20A.1 Asset Management
- ⬜ 20A.2 Meshes, Textures, and Imported Assets
- ⬜ 20A.3 Prefabs and Scene Composition
- ⬜ 20A.4 Materials and Shaders
- ⬜ 20A.5 Lighting and Shadows
- ⬜ 20A.6 Animation
- ⬜ 20A.7 Cameras and Composition
- ⬜ 20A.8 VFX and Post-Processing
- ⬜ 20A.9 Environment Polish
- ⬜ 20A.10 Artist Objective / GMetrix Review
- ⬜ 20A Project: Portfolio Environment / Interactive Scene

---

## Unit 20B: Unity VR Developer Track

**Primary resource base:** Unity Learn VR Development pathway + VR Developer objectives.

### Skills

Students develop:

- XR project concepts;
- headset/controller awareness;
- XR Interaction Toolkit;
- interactors/interactables;
- grabbing;
- sockets;
- locomotion;
- teleportation;
- rotation approaches;
- spatial UI;
- spatial audio;
- ergonomics;
- comfort;
- accessibility;
- optimization;
- AI-assisted custom interaction scripting.

- ⬜ 20B.1 VR / XR Fundamentals
- ⬜ 20B.2 XR Project Setup
- ⬜ 20B.3 XR Interaction Toolkit
- ⬜ 20B.4 Grab and Release
- ⬜ 20B.5 Sockets and Object Interaction
- ⬜ 20B.6 Locomotion
- ⬜ 20B.7 Comfort and Motion
- ⬜ 20B.8 Spatial UI
- ⬜ 20B.9 Spatial Audio and Feedback
- ⬜ 20B.10 Ergonomics and Accessibility
- ⬜ 20B.11 Optimization
- ⬜ 20B.12 AI-Assisted Custom VR Interaction
- ⬜ 20B.13 VR Developer Objective / GMetrix Review
- ⬜ 20B Project: Small VR Interaction Experience

---

# Unit 21: Capstone — Design, Build, Test, Explain

**Timing target:** final course stretch

**Certification tie-in:** cumulative demonstration; may also support second-certification progress.

**Game/UX tie-in:** cumulative.

**AI tie-in:** students independently choose when AI is appropriate and document significant use.

### Capstone requirements

Students create a substantial Unity project appropriate to their pathway.

Possible formats:

- complete small game;
- polished 3D prototype;
- Artist-focused environment / interactive scene;
- VR interaction experience;
- other approved Unity project.

### Required development evidence

Students demonstrate:

- organized project;
- appropriate GameObjects/components;
- functional gameplay/interaction;
- intentional use of scripts;
- AI-assisted development where useful;
- debugging;
- testing;
- iteration.

### Required design evidence

Students demonstrate:

- defined player/user;
- clear goal;
- core interaction;
- feedback;
- intentional difficulty/experience;
- accessibility consideration;
- playtesting;
- documented revision.

### Required technical explanation

Student can explain:

- major GameObjects;
- major Components;
- important scripts;
- important variables;
- how key interactions run;
- at least one debugging problem;
- at least one AI-assisted development decision;
- what they would investigate if a major system stopped working.

- ⬜ 21.1 Capstone Proposal
- ⬜ 21.2 Scope Check
- ⬜ 21.3 Prototype
- ⬜ 21.4 Core Systems
- ⬜ 21.5 Design / UX Review
- ⬜ 21.6 Playtest Round 1
- ⬜ 21.7 Revision
- ⬜ 21.8 Accessibility Review
- ⬜ 21.9 Playtest Round 2
- ⬜ 21.10 Polish
- ⬜ 21.11 Technical Explanation / Defense
- ⬜ 21.12 Final Build / Presentation
- ⬜ 21 Capstone: Final Unity Project

---

# Optional Parallel Path: Game Development — Basic 2D Game

Unity Learn's **Create a Basic 2D Game / Sprite Flight** mission should remain available without becoming a shared-course requirement.

Potential uses:

- student wants to make a 2D game;
- reinforcement after the first 3D project;
- alternate project format;
- early-finisher extension;
- student benefits from a more structured second tutorial game.

Potential lesson ownership:

- Set up a 2D world
- Flying obstacle Prefab
- Random obstacle size/direction/speed
- Player steering
- Scoring
- Restart/game state
- Bonus features
- Build/publish

Skills from this mission can count toward existing FoxCS mastery checkpoints where equivalent.

---

# Moodle Lesson Structure

Each authored lesson should eventually contain the following sections.

## Learn

Exact FoxCS explanation and/or assigned Unity Learn tutorial.

## Skills

What the student should be able to **use, interpret, modify, debug, and/or explain**.

## Build

What should exist or work in Unity.

## Design / UX

What player-experience concept the student should consider.

## AI Opportunity

Specific guidance for appropriate AI use.

## AI Evidence

Whether an AI Development Log entry is required.

## Certification Connection

Relevant Unity Certified User: Programmer objective/domain.

## Check Your Understanding

Short conceptual questions.

## Submit

Exact evidence required in Moodle.

## Move On When

Mastery checkpoint.

## Recovery Route

Minimum targeted work for a student who is behind.

## Ahead Route

What a student may unlock after demonstrating mastery early.

---

# Standard Unity Submission Model

Assignments may require one or more of:

## Unity Learn Evidence
- activity completion
- quiz result
- pathway progress

## Unity Project Evidence
- teacher demonstration
- screenshot
- short video
- playable build
- project files when required

## Design Evidence
- GDD
- level sketch
- test plan
- playtest notes
- iteration record
- accessibility review

## AI Evidence
- updated AI Development Log
- Copilot share link
- student explanation of outcome

## Reflection
- what was built
- what changed
- what was difficult
- what was learned
- what should improve next

---

# Suggested Required AI Development Log Checkpoints

1. Unit 04 — explain unfamiliar Unity code
2. Unit 05 — movement script explanation/modification
3. Unit 06 — collision/trigger debugging
4. Unit 08 — GDD gap-finding
5. Unit 12 — UI/state debugging
6. Unit 13 — Animator/state debugging
7. Unit 16 — iteration hypothesis / diagnosis
8. Unit 17 — certification-style code analysis
9. Unit 18 — debugging lab
10. Unit 21 — significant capstone implementation or debugging issue

Additional entries are encouraged when genuinely useful.

---

# Suggested Game Design / UX Media Ownership

A separate `video-resources.md` should eventually identify exact resources and links.

Potential ownership:

## Unit 01
- What makes a game a game?
- feedback loops / player feedback

## Unit 05
- movement / game feel
- camera behavior

## Unit 08
- game design documents
- scope
- core loops

## Unit 10
- audio feedback

## Unit 11
- visual feedback / game juice

## Unit 12
- UI / readability / game UX

## Unit 13
- animation / anticipation / feedback

## Unit 15
- GMTK movement analysis
- level design
- difficulty
- accessibility
- ethical engagement

## Unit 16
- playtesting / iteration

Media should not be passive enrichment. Each resource should produce an observation, design decision, experiment, or revision.

---

# Recommended Academic-Year Flow From Current Week 3

This is a **planning target**, not yet the final CPS calendar mapping.

| Approx. Weeks | Units | Main Milestone |
|---|---|---|
| 1–2 | 00 | Shared onboarding |
| 3–4 | 01 | MakeCode game-system foundation |
| 5 | 02–03 | Unity readiness + Editor / 3D boot camp |
| 5–6 | 04 | Programming Essentials / code literacy |
| 6–9 | 05–07 | Complete first 3D Unity game |
| 9–10 | 08 | Original game planning |
| 10–11 | 09 | Build original gameplay systems |
| 11–16 | 10–14 | Audio, VFX, UI, animation, visual systems |
| 16–18 | 15–16 | Game design, UX, playtesting, iteration |
| 18–22 | 17–18 | Programmer code literacy + debugging |
| 22–25+ | 19 | GMetrix + Programmer certification |
| After Programmer | 20 | Artist or VR specialization |
| Final stretch | 21 | Capstone |

The final dated calendar should account for:

- quarter endings;
- report-card / grading weeks;
- school holidays;
- shortened weeks;
- testing days;
- certification scheduling;
- student absences;
- students progressing at different rates.

---

# Pacing Philosophy

Recommended deadlines represent the pace of an average student.

Students who finish early should move forward into later content rather than receive filler assignments.

Students who fall behind should receive a **recovery route** that focuses on the minimum missing skills rather than automatically repeating an entire Unity Learn pathway.

Students should not remain stuck on one tutorial simply because they have not reached 100% pathway completion.

Advancement should increasingly depend on:

> **Can you use and explain the important skill?**

rather than:

> **Did you click through every item?**

---

# Major Course Milestones

## Milestone 1 — MakeCode Game
Student demonstrates fundamental game/programming concepts.

## Milestone 2 — Unity Editor Fluency
Student can navigate Unity and work with GameObjects/components.

## Milestone 3 — First Unity Script Literacy
Student can read and explain a simple Unity script.

## Milestone 4 — First Complete 3D Game
Student completes the core Game Development 3D project.

## Milestone 5 — Original Game Plan
Student creates a scoped GDD and system plan.

## Milestone 6 — Original Gameplay System
Student builds from a requirement with AI/tutorial/documentation support.

## Milestone 7 — Polished Game Systems
Student has experience with audio, VFX, UI, animation, materials, and lighting.

## Milestone 8 — UX / Playtesting
Student improves a game from player evidence.

## Milestone 9 — Programmer Literacy
Student can interpret common Unity C# and state-machine structures.

## Milestone 10 — Debugging / API Literacy
Student can systematically investigate broken systems.

## Milestone 11 — Unity Certified User: Programmer
Student completes GMetrix preparation and attempts the certification.

## Milestone 12 — Specialization
Student progresses toward Artist or VR Developer.

## Milestone 13 — Capstone
Student independently designs, builds, tests, and explains a substantial Unity experience.

---

# Files to Build Alongside This Map

The following companion planning files are recommended:

- `skills-map.md`
  - per-lesson skills
  - misconceptions
  - mastery checks
  - question targets
  - use / interpret / modify / debug / explain levels

- `unity-learn-content-mapping.md`
  - exact Unity Learn ownership
  - required / optional / compressed / deferred decisions
  - lesson links
  - expected duration

- `unity-programmer-certification-map.md`
  - exact certification objective → FoxCS lesson
  - GMetrix ownership
  - coverage gaps

- `video-resources.md`
  - GMTK / UX / game-design media
  - assigned lesson
  - viewing purpose
  - student application task

- `ai-development-guidance.md`
  - AI Development Log instructions
  - Copilot prompt patterns
  - required checkpoints
  - submission guidance

- `academic-calendar-map.md`
  - exact 2026–27 instructional dates
  - due dates
  - unit lock dates if used
  - short-week adjustments
  - certification windows

---

# Immediate Authoring Priority From Week 3

Because the course is already at the start of Week 3, build student-facing content in this order:

1. **Unit 01 — MakeCode Game Systems**
2. **Unit 02 — Unity Readiness**
3. **Unit 03 — Editor / 3D Essentials**
4. **Unit 04 — Programming Essentials**
5. **Units 05–07 — Basic 3D Game**
6. **Unit 08 — Game Planning**
7. Continue forward while later units are refined against certification objectives.

The course map beyond those units can remain flexible while students begin the early sequence.

---

# End-State Vision

By the end of the shared Programmer portion, a successful FoxCS student should be able to say:

> I can navigate Unity, build and modify a 3D game, use common Unity systems, use AI responsibly to help implement and debug C# scripts, read enough code to understand what my game is doing, test my work with players, improve a game based on evidence, and explain the important systems I built.

The course should prepare students for certification **through authentic Unity use first**, with GMetrix becoming focused exam practice after students have meaningful experience to attach the exam concepts to.
