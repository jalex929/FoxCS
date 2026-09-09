# FoxCS Unity Learn Content Mapping
## Unity Essentials + Game Development → FoxCS Learning Outcomes and Unity Certified User: Programmer Preparation

**Planning document**  
**Current planning context:** 2026–27 school year  
**Unity Learn version reviewed:** Unity 6.3 pathway structure  
**Primary certification target:** Unity Certified User: Programmer  
**Later specialization options:** Unity Certified User: Artist or Unity Certified User: VR Developer

---

# 1. Purpose of This Document

This document maps the content in the following Unity Learn pathways to FoxCS learning outcomes:

1. **Unity Essentials**
2. **Game Development**

The goal is not to require students to complete every Unity Learn activity simply because it exists.

Instead, this document is intended to help FoxCS determine:

- which Unity Learn missions should be required;
- which individual activities are especially useful;
- which content can be compressed because students already learned the concept elsewhere;
- which content is valuable for general game-development growth but not essential to the Unity Certified User: Programmer exam;
- which content can be deferred to later Unity Artist or Unity VR Developer specialization;
- which Certified User: Programmer objectives are not covered deeply enough by these pathways and will require FoxCS-specific instruction, GMetrix, or other Unity Learn material;
- where AI-assisted development should be built into the learning process;
- what evidence students should submit to show that they completed and understood the work.

This is a **content-selection and curriculum-planning document**. It should later be used to build the detailed week-by-week academic-calendar course map.

---

# 2. Course Assumptions

## Installed software

Student machines are expected to already have:

- Unity Hub
- Unity Editor
- Visual Studio Code

Students should **not** spend instructional time installing these tools unless troubleshooting requires it.

Setup instructions should instead explicitly show students how to:

- sign in to Unity Learn;
- open the correct Unity project or template;
- confirm that the correct Unity version is being used;
- identify where their project is saved;
- open scripts in VS Code;
- return from VS Code to Unity and allow scripts to compile;
- locate Unity Console errors;
- save scenes and projects;
- access Microsoft Copilot;
- save/share useful Copilot conversations;
- maintain the FoxCS AI Development Log;
- submit required evidence in Moodle.

---

# 3. Primary Certification Target

The shared Unity curriculum should prepare students first for:

# Unity Certified User: Programmer

Unity currently organizes this certification around four broad areas:

1. **Debugging, problem-solving, and interpreting the Unity API**
2. **Creating code**
3. **Evaluating code**
4. **Navigating the Unity interface**

Unity also describes a certification-ready learner as someone who can:

- build projects using C# in Unity;
- navigate the Unity interface;
- interpret basics of the Unity API;
- iterate with prototypes;
- debug programming problems;
- solve programming challenges;
- create/program a function state machine.

FoxCS will interpret these expectations through an **AI-assisted development model**.

Students are not expected to become independent traditional C# programmers who can write every system from a blank file.

Students **are** expected to become increasingly capable of:

- reading Unity C#;
- identifying important variables, methods, conditions, and references;
- understanding what a script controls;
- using AI to generate or adapt simple scripts;
- attaching/configuring scripts correctly;
- testing scripts;
- reading errors;
- diagnosing whether a problem is caused by code, a component, an Inspector reference, or scene configuration;
- using Unity documentation and AI together;
- explaining how important parts of their game work.

---

# 4. FoxCS Skill Labels

Each Unity Learn activity can build different levels of understanding.

## USE

The student can successfully use the feature or script in a project.

Examples:

- attach a Rigidbody;
- add a Collider;
- configure a Prefab;
- use a script created from a tutorial or AI;
- add an Audio Source.

## INTERPRET

The student can examine an existing configuration or script and explain what the important parts do.

Examples:

- identify which variable controls speed;
- explain what a Rigidbody reference is for;
- recognize a condition;
- explain why a trigger activates a method.

## MODIFY

The student can make an intentional change to an existing system.

Examples:

- change movement speed;
- add a second collectible type;
- alter a win condition;
- change a particle effect.

## DEBUG

The student can investigate and correct a problem.

Examples:

- identify an unassigned Inspector reference;
- fix a missing component;
- interpret a Console error;
- determine why a collision callback is not firing.

## EXPLAIN

The student can explain how the system works using appropriate Unity/programming vocabulary.

Independent blank-page C# generation is **not automatically required** for mastery.

---

# 5. Content Priority Labels

## CORE — REQUIRED

Strongly aligned to the first certification target and/or essential Unity development skills.

## CORE — COMPRESS

Important content, but likely redundant with another required activity.

## RECOMMENDED

Valuable for game development and student projects and should normally be included when pacing allows.

## OPTIONAL / DIFFERENTIATION

Useful for some students, project types, remediation, acceleration, or specialization.

## DEFER

Good content, but better taught later when it becomes relevant to a project or specialization.

## REPLACE / FOXCS

Unity Learn content should not be used as written because FoxCS has a different certification goal or instructional model.

---

# 6. Unity Essentials Overview

Unity Essentials currently contains six missions:

1. Editor Essentials
2. 3D Essentials
3. Audio Essentials
4. Programming Essentials
5. 2D Essentials
6. Publishing Essentials

Unity describes the pathway as approximately two weeks of beginner work.

FoxCS should **not automatically require the entire pathway in sequence**.

Recommended use:

- **Editor Essentials:** required
- **3D Essentials:** required
- **Programming Essentials:** required/selectively emphasized
- **Audio Essentials:** defer until audio is taught in Game Development
- **2D Essentials:** optional
- **Publishing Essentials:** defer until students have a project worth publishing

---

# 7. Unity Essentials Mission Map

## UE-01 — Editor Essentials

### Unity Learn focus

Students explore a playground scene and create/modify a mural while learning the Unity Editor.

The mission develops:

- Unity Hub/project awareness;
- Unity Editor layout;
- Scene view navigation;
- 3D navigation;
- Move tool;
- Rotate tool;
- Transform manipulation;
- basic GameObject selection/manipulation.

### FoxCS priority

**CORE — REQUIRED**

### FoxCS learning outcomes

Students can:

- distinguish Unity Hub from the Unity Editor;
- open the correct project;
- identify the **Hierarchy**;
- identify the **Inspector**;
- identify the **Project** window;
- identify the **Scene** view;
- identify the **Game** view;
- navigate in 3D space;
- select GameObjects;
- move and rotate GameObjects;
- recognize Transform values in the Inspector;
- recover when they become lost in the Scene view;
- enter and exit Play Mode.

### Programmer-certification relevance

**High**

Directly supports:

- navigating the Unity interface;
- understanding where components and script references are configured;
- later debugging of Inspector/project problems.

### FoxCS addition

Students should complete a quick **Editor Fluency Check**:

> Teacher asks student to locate a named object, identify a component, change a Transform value, enter Play Mode, return to Edit Mode, and locate the Console.

### AI opportunity

Mostly **Explain Mode**, not code generation.

Useful questions:

- Why do changes made during Play Mode sometimes disappear?
- What is the difference between the Hierarchy and Project windows?
- Why do Position, Rotation, and Scale appear under Transform?
- Why does selecting a GameObject change the Inspector?

### Evidence

- Unity Learn mission completion or teacher checkoff;
- no AI log entry required unless AI substantially helps solve a setup/interface problem.

---

## UE-02 — 3D Essentials

### Unity Learn focus

Students construct a 3D room and use physical objects such as a bouncing ball and a collapsing tower.

Major concepts include:

- GameObjects;
- primitive meshes;
- Transform;
- components;
- appearance/materials;
- Rigidbody;
- Colliders;
- basic physics;
- Prefabs.

### FoxCS priority

**CORE — REQUIRED**

### FoxCS learning outcomes

Students can:

- create primitive GameObjects;
- explain the difference between a GameObject and a Component;
- position, rotate, and scale objects;
- identify Mesh Renderer / visible-object concepts;
- add and configure basic physics components;
- explain the purpose of Rigidbody;
- explain the purpose of a Collider;
- observe gravity/physics behavior;
- create or use a Prefab;
- place multiple Prefab instances;
- explain why reusable Prefabs are useful.

### Programmer-certification relevance

**High**

Supports:

- Unity interface fluency;
- GameObject/component architecture;
- troubleshooting missing/wrong components;
- understanding objects referenced from scripts;
- later physics/gameplay scripting.

### Game-design relevance

**Medium**

Students begin thinking about:

- spatial scale;
- physical behavior;
- predictability;
- interaction.

### AI opportunities

Explain/debug prompts can investigate:

- Why does this object fall while another object does not?
- Why did my object pass through the floor?
- What does a Rigidbody add to a GameObject?
- What is the difference between a Collider and a Rigidbody?
- Why would I turn a GameObject into a Prefab?

### Evidence

Recommended:

- completed Unity Learn mission;
- short teacher checkpoint showing a Rigidbody, Collider, and Prefab;
- AI log only if AI was used for meaningful troubleshooting.

---

## UE-03 — Audio Essentials

### Unity Learn focus

Students add sound to a 3D kitchen scene.

Major concepts include:

- Audio Clips;
- Audio Source;
- Audio Listener;
- background music;
- sound effects;
- 3D/spatial audio;
- audio configuration.

### FoxCS priority

**DEFER**

Students should not need to finish this before starting the Game Development pathway.

The Game Development pathway contains a larger Audio mission, so this content is partly redundant.

### FoxCS learning outcomes when used

Students can:

- distinguish Audio Clip, Audio Source, and Audio Listener;
- configure basic audio;
- distinguish spatialized/3D sound from non-spatial audio;
- explain how sound communicates information to a player;
- use sound intentionally rather than decoratively.

### Programmer-certification relevance

**Low to Medium**

Not a central Certified User: Programmer target, although script-triggered audio can support API/code comprehension.

### Game-design / UX relevance

**High**

Possible themes:

- player feedback;
- atmosphere;
- direction/attention;
- event confirmation;
- accessibility and alternatives to audio-only information.

### Recommendation

Use the **Game Development Audio mission as the primary audio sequence**.

Use Audio Essentials only as:

- remediation;
- extra practice;
- a simplified introduction;
- enrichment.

---

## UE-04 — Programming Essentials

### Confirmed current Unity Learn activities

- **Add a movement script**
- **Create a rotating collectible**
- **Collect the collectible**
- **Programming Essentials: More things to try**

### Unity Learn focus

Students create a simple interactive experience where a character moves around a room and collects objects.

Unity identifies skills including:

- creating a GameObject component with a script;
- working with components;
- basic Unity code comprehension;
- common logic structures;
- APIs;
- readable code;
- camera configuration.

### FoxCS priority

**CORE — REQUIRED**

This is one of the most directly useful Essentials missions for the Certified User: Programmer target.

### FoxCS learning outcomes

Students can:

- locate a script in the Project window;
- attach a script to a GameObject;
- open a script in VS Code;
- allow Unity to recompile code after edits;
- identify a class at a basic level;
- identify a variable;
- identify a method;
- recognize a component reference;
- identify simple movement logic;
- identify a condition;
- recognize an API call;
- explain in plain language what a simple Unity script does;
- modify an exposed gameplay value;
- test the result of a code change;
- identify whether a problem appears to be code-related or Unity-configuration-related.

### Programmer-certification relevance

**Very High**

Direct support for:

- creating code;
- evaluating code;
- API interpretation;
- Unity component/script relationships.

### Important FoxCS adaptation

Students do **not** need to reproduce these scripts from memory.

The desired learning sequence is:

**USE → INTERPRET → MODIFY → DEBUG → EXPLAIN**

### AI opportunities

This mission should include the first **required AI Development Log entry**.

Possible task:

> Ask Copilot to explain the movement script in language appropriate for someone who understands MakeCode but is new to C#. Ask it to identify the variables, methods, component references, and the part that causes movement.

Students then independently answer:

1. Which GameObject uses the script?
2. What component does the script depend on?
3. Which value changes movement behavior?
4. What method contains the movement logic?
5. What would you change to make the player move differently?

### Evidence

Required:

- Unity Learn completion/checkpoint;
- working movement + collectible behavior;
- one AI Development Log entry;
- short code-comprehension check.

---

## UE-05 — 2D Essentials

### Unity Learn focus

Students recreate an interactive scene as a 2D experience.

Major concepts include:

- 2D Scene navigation;
- Sprite Renderer;
- Sprite Editor;
- sprite-sheet slicing;
- Rigidbody2D;
- Collider2D;
- 2D-specific APIs/callbacks;
- rendering order;
- Rect tools.

### FoxCS priority

**OPTIONAL / DIFFERENTIATION**

Students already begin the course in MakeCode Arcade and will enter 3D Unity quickly.

There is no need for every student to complete a full Unity 2D sequence before beginning 3D.

### Best uses

- student specifically wants to make a 2D game;
- student wants reinforcement after MakeCode;
- student needs a lower-complexity Unity project;
- extension after finishing core work early;
- alternate project format.

### Programmer-certification relevance

**Medium**

Programming concepts transfer, but the primary FoxCS certification-prep environment will be 3D Unity.

### Later specialization relevance

Potentially useful for Artist students working with:

- sprites;
- sprite sheets;
- 2D animation;
- 2D asset workflows.

---

## UE-06 — Publishing Essentials

### Unity Learn focus

Students combine Essentials scenes into a single portfolio experience and configure a basic build.

### FoxCS priority

**DEFER**

FoxCS students do not need to build the Unity Essentials house portfolio if their main project is already moving into Game Development.

### FoxCS learning outcomes when used

Students can:

- configure a basic build;
- understand scenes included in a build;
- create/access a menu;
- test a built experience;
- share a playable project appropriately.

### Programmer-certification relevance

**Low**

### Course relevance

**Medium to High later**

Publishing becomes more meaningful when students publish their own game rather than a collection of Essentials exercises.

### Recommendation

Teach publishing when students have completed a meaningful game-development milestone.

---

# 8. Unity Essentials Recommended FoxCS Route

## Minimum shared route

### Required

1. **Editor Essentials**
2. **3D Essentials**
3. **Programming Essentials**

### Deferred

4. Audio Essentials
5. Publishing Essentials

### Optional

6. 2D Essentials

This allows Essentials to function as a **rapid Unity boot camp** rather than a two-week requirement.

---

# 9. Game Development Pathway Overview

Unity's current Game Development pathway is approximately 12 weeks and is designed to prepare learners toward the **Unity Certified Associate: Game Developer** level.

Current mission structure:

1. Get started in Unity
2. Create a basic 3D game
3. Create a basic 2D game
4. Planning a game
5. Audio
6. Visual effects
7. User interfaces
8. Animation
9. Shaders and Materials
10. Lighting
11. Iterate on your game
12. Prepare for certification and publishing

Because the Associate credential is positioned above the Certified User level, much of this pathway provides useful depth beyond what is strictly necessary for the FoxCS first certification target.

FoxCS should therefore expect students to complete a **substantial portion of the pathway**, while still removing or adapting content that does not efficiently support the Certified User: Programmer goal.

---

# 10. Game Development Mission Map

## GD-01 — Get Started in Unity

### Confirmed current activities

- **Welcome to the pathway**
- **Get Started with Unity: In-Editor Tutorial**
- **Create a balanced primitive structure**
- **Unit 1 — Unity fundamentals quiz**

### Unity Learn outcomes

Students:

- understand the pathway structure;
- complete an Editor tutorial;
- practice basic Unity navigation;
- create a structure from primitive GameObjects.

### FoxCS priority

**CORE — COMPRESS**

Much of the interface instruction overlaps with Unity Essentials.

### FoxCS recommendation

Students who completed UE-01 and UE-02 should not need to repeat all introductory instruction.

Use:

- pathway welcome/overview;
- balanced primitive challenge as a mastery check;
- quiz if useful.

### Learning outcomes

Students can:

- demonstrate basic Editor navigation without step-by-step support;
- create and transform primitives;
- build a stable 3D composition;
- organize a basic scene.

### Programmer-certification relevance

**Medium**

Primarily navigation/interface.

---

## GD-02 — Create a Basic 3D Game

### Confirmed current lessons

1. **Introduction to Unit 2**
2. **Setting up the game**
3. **Moving the Player**
4. **Moving the Camera**
5. **Setting up the Play Area**
6. **Creating Collectibles**
7. **Detecting Collisions with Collectibles**
8. **Displaying Score and Text**
9. **Adding AI Navigation**
10. **Building the Game**
11. **Unit 2 — Program a basic game quiz**

This creates a Roll-a-Ball-style 3D game.

### FoxCS priority

# CORE — REQUIRED

This should be one of the most important early Unity experiences.

### GD-02.1 — Setting up the game

#### Student outcomes

Students can:

- create/open the project;
- identify the key scene objects;
- configure a player object;
- identify required components;
- save scenes;
- organize basic project assets.

#### Certification relevance

- interface navigation;
- components;
- project structure.

---

### GD-02.2 — Moving the Player

#### Student outcomes

Students can:

- attach/use a movement script;
- identify the Rigidbody used by the script;
- identify the movement variable(s);
- understand that player input is converted into movement;
- modify/tune movement values;
- test changes;
- explain at a high level what the movement script does.

#### Certification relevance

**Very High**

Supports:

- creating code;
- evaluating code;
- component references;
- APIs;
- variables/methods;
- debugging.

#### FoxCS AI checkpoint

Required AI Development Log candidate.

Suggested task:

> Ask Copilot to explain the movement script and connect each major section to concepts you already know from MakeCode.

Follow-up:

> Identify what would have to change if you wanted the player to move faster, slower, or differently.

---

### GD-02.3 — Moving the Camera

#### Student outcomes

Students can:

- configure a camera;
- understand camera/player relationships;
- identify a camera-follow implementation;
- tune camera placement;
- explain why camera behavior affects player experience.

#### Certification relevance

**Medium**

#### UX/game-design relevance

**High**

Questions:

- What information does the camera provide?
- Can the player see hazards/objectives?
- Does the camera make movement easier or harder to interpret?

---

### GD-02.4 — Setting up the Play Area

#### Student outcomes

Students can:

- greybox a small play area;
- create boundaries;
- create readable spatial relationships;
- use primitives efficiently;
- establish scale.

#### Certification relevance

**Medium**

#### Game-design relevance

**High**

Introduce:

- greyboxing;
- player path;
- readable spaces;
- goal visibility.

---

### GD-02.5 — Creating Collectibles

#### Student outcomes

Students can:

- create a collectible;
- configure appearance/components;
- create/use a Prefab;
- duplicate reusable game objects.

#### Certification relevance

**High**

Supports:

- GameObjects;
- components;
- Prefabs;
- script references.

---

### GD-02.6 — Detecting Collisions with Collectibles

#### Student outcomes

Students can:

- distinguish Collider and Rigidbody responsibilities;
- recognize trigger/collision behavior;
- identify a collision/trigger callback in code;
- connect a collision event to a gameplay outcome;
- diagnose common collision problems.

#### Certification relevance

**Very High**

#### Required AI debugging opportunity

If the collectible does not work, students should ask AI for a **diagnostic checklist**, not immediately request replacement code.

Possible checks:

- Collider present?
- Is Trigger configured?
- Rigidbody present where needed?
- correct script attached?
- correct method/callback?
- tag/layer issue?
- Inspector reference missing?

Students log what **actually** fixed the problem.

---

### GD-02.7 — Displaying Score and Text

#### Student outcomes

Students can:

- represent score with a variable;
- update score in response to gameplay;
- display information in UI;
- identify the relationship between game state and UI;
- recognize references between scripts and UI objects.

#### Certification relevance

**High**

#### UX relevance

**High**

Students should consider:

- readability;
- placement;
- information hierarchy;
- whether information is necessary.

---

### GD-02.8 — Adding AI Navigation

#### Student outcomes

Students can:

- understand the purpose of navigation/agent systems;
- configure simple AI navigation;
- observe autonomous game behavior;
- distinguish built-in Unity systems from custom C# logic.

#### Certification relevance

**Low to Medium**

Useful for game development but not central to the Certified User: Programmer exam.

### Recommendation

**RECOMMENDED**, but this could be shortened if pacing requires.

---

### GD-02.9 — Building the Game

#### Student outcomes

Students can:

- configure a basic build;
- test the experience outside the Editor;
- recognize differences between Editor testing and built-game testing.

#### Certification relevance

**Low**

#### Course relevance

**Medium**

Completing and testing a build reinforces the idea that a project should become a usable product.

---

### GD-02 project outcome

By the end of GD-02, students should have a complete small 3D game containing:

- movement;
- camera;
- physics;
- play space;
- collectibles;
- collision/trigger behavior;
- score;
- UI;
- win/game-state logic;
- optional AI navigation;
- playable build.

This is a major FoxCS milestone.

---

## GD-03 — Create a Basic 2D Game

### Confirmed current lessons

1. **Introduction to Unit 3**
2. **Set up your 2D game world**
3. **Make a flying obstacle prefab**
4. **Random obstacle size, direction, and speed**
5. **Steer the player**
6. **Add a scoring system**
7. **Restart the game with a bang**
8. **Optional bonus features**
9. **Build and publish to web**
10. **Unit 3 — Create a basic 2D Game quiz**

The project is called **Sprite Flight**.

### FoxCS priority

**OPTIONAL / DIFFERENTIATION**

### Why it is not required for everyone

Students:

- already begin with 2D game design/programming in MakeCode Arcade;
- complete Unity Essentials;
- then build a full 3D game.

Requiring another complete introductory game immediately afterward may delay more important Programmer preparation.

### High-value concepts in this unit

Even if the full project is optional, the content provides useful practice with:

- Prefabs;
- randomness;
- player input;
- scoring;
- game restart/state;
- particles;
- 2D physics;
- scripting;
- publishing.

### Recommended uses

#### Option A — 2D interest track

Students who want to develop a 2D project complete the mission.

#### Option B — Reinforcement

Students who need another structured game before independent development complete Sprite Flight.

#### Option C — Accelerated/extension

Students ahead of pace may complete it as a second prototype.

#### Option D — Pull individual concepts

FoxCS can assign selected lessons such as:

- Prefab creation;
- randomization;
- restart/game-state logic;

without requiring the whole project.

### Programmer-certification relevance

**Medium**

Programming transfers, but the course does not require students to master both 2D and 3D physics APIs before the first certification attempt.

---

## GD-04 — Planning a Game

### Unity Learn focus

Students:

- study game-design concepts;
- consider genres/platforms;
- develop a game vision;
- create a Game Design Document (GDD);
- establish version control;
- learn strategies for getting unstuck.

### FoxCS priority

# CORE — REQUIRED

This mission is especially important because FoxCS is a **Game Design** course rather than simply Unity technical training.

### FoxCS learning outcomes

Students can:

- identify a target player;
- describe the core game loop;
- identify the player's primary actions;
- define an objective;
- identify challenge/failure conditions;
- describe feedback systems;
- define project scope;
- create a simple GDD;
- identify technical requirements;
- identify art/audio requirements;
- plan a testable prototype;
- revise the GDD as the game changes.

### UX/game-design expansion

FoxCS should add explicit questions:

- Who is the player?
- What should the player understand without explanation?
- What actions will the player repeat?
- How does the system respond to each action?
- How will the player know whether they are succeeding?
- What could confuse a first-time player?
- What accessibility barriers might exist?

### Programmer-certification relevance

**Indirect but important**

Supports:

- prototyping;
- iteration;
- translating requirements into game systems.

### AI opportunity

Students can use AI to:

- identify missing requirements in a GDD;
- ask what technical systems their design likely requires;
- identify scope risks;
- compare alternative implementations.

AI should **not design the entire game for the student**.

Suggested prompt:

> Here is my game concept. Ask me questions about missing rules, unclear player goals, edge cases, and technical systems I may not have considered. Do not rewrite the game design for me.

### AI evidence

Recommended log entry.

---

## GD-05 — Audio

### Confirmed current lessons

1. **Introduction to Unit 5**
2. **Get started with audio**
3. **Create 3D sound effects**
4. **Add special effects to existing audio**
5. **Challenge: Your own soundscape**
6. **Audio for 2D Projects**
7. **Add audio to your game (Game Dev)**
8. **Unit 5 — Audio quiz**

### FoxCS priority

**RECOMMENDED / NORMALLY REQUIRED**

The **Audio for 2D Projects** lesson may be optional for students remaining in 3D.

### Student outcomes

Students can:

- add background audio;
- configure Audio Sources;
- add one-shot gameplay sounds;
- configure 3D/spatial audio;
- refine audio properties;
- use audio to provide game feedback;
- create a basic soundscape;
- add audio intentionally to their own game.

### Programmer-certification relevance

**Low to Medium**

### Game-design/UX relevance

**Very High**

Students should analyze:

- diegetic vs. non-diegetic sound;
- confirmation feedback;
- danger cues;
- environmental storytelling;
- direction/attention;
- accessibility when important information is communicated through sound.

### AI opportunities

AI can help students reason about:

- why an Audio Source cannot be heard;
- 2D versus 3D sound;
- why attenuation is behaving unexpectedly;
- how to trigger sound from a gameplay event;
- what `PlayOneShot` does in a script.

### Evidence

- sound added to student game;
- explanation of what player information the sound communicates.

---

## GD-06 — Visual Effects

### Unity Learn focus

Students learn:

- Particle Systems;
- environmental effects;
- burst effects;
- basic VFX Graph interpretation;
- applying effects to their own game.

### FoxCS priority

**RECOMMENDED / NORMALLY REQUIRED**

### Student outcomes

Students can:

- identify a Particle System;
- configure basic Particle System properties;
- distinguish an environmental effect from an event/burst effect;
- connect an effect to a gameplay event;
- use VFX intentionally;
- explain what information or feeling the VFX is intended to communicate.

### Programmer-certification relevance

**Low to Medium**

### Game-design/UX relevance

**High**

VFX should be framed primarily as **feedback**.

Students should ask:

- What happened?
- Did the player notice?
- Does the effect clarify success/failure/damage/collection?
- Is the effect distracting?
- Is the effect overwhelming or inaccessible?

### AI opportunities

Students can ask:

- Why is this Particle System always playing?
- How do I trigger the effect only when X happens?
- Which Particle System property controls how long particles remain visible?
- Why is the effect appearing in the wrong location?

---

## GD-07 — User Interfaces

### Unity Learn focus

Students learn to:

- choose an appropriate UI approach;
- create visual UI;
- support different screen sizes/resolutions;
- create interactive elements such as buttons, toggles, and sliders;
- manage screens.

### FoxCS priority

# CORE — REQUIRED

### Student outcomes

Students can:

- create readable UI;
- display game-state information;
- create interactive controls;
- configure buttons/toggles/sliders;
- reason about screen layout;
- test UI at different sizes;
- create menus/screens;
- connect simple UI interactions to game behavior.

### Programmer-certification relevance

**Medium to High**

Especially when UI actions are connected to scripts/events.

### Game-design/UX relevance

**Very High**

This should be one of the strongest UX units.

Topics:

- information hierarchy;
- consistency;
- readability;
- affordance;
- feedback;
- input clarity;
- accessibility;
- avoiding unnecessary information;
- communicating state.

### AI opportunities

Students can use AI to:

- diagnose a button that does not fire;
- trace why UI text is not updating;
- identify a missing object reference;
- explain how an event connects UI to a method;
- review UI for potential usability/accessibility issues.

### Required AI checkpoint

Strong candidate.

---

## GD-08 — Animation

### Unity Learn focus

Students learn about:

- animation clips;
- Animator;
- Animator Controllers;
- keyframed animation;
- imported animation;
- states and transitions;
- applying animation to their project.

### FoxCS priority

# CORE — REQUIRED

### Student outcomes

Students can:

- identify an animation clip;
- identify an Animator component;
- open/read an Animator Controller;
- identify states;
- identify transitions;
- identify parameters;
- connect gameplay behavior to animation;
- diagnose a simple transition problem.

### Programmer-certification relevance

**High**

State-machine understanding is directly useful for Programmer certification preparation.

### Game-design relevance

**High**

Animation communicates:

- state;
- anticipation;
- action;
- damage;
- success/failure;
- responsiveness.

### AI opportunities

Strong debugging opportunities:

- Why does the transition never happen?
- Is the parameter name correct?
- What does this Bool/Trigger control?
- What must become true for this state transition to run?
- Why does the script find the Animator but not change state?

### Required AI checkpoint

Recommended.

Student should ask AI to walk through the Animator + relevant script together, then independently explain the transition logic.

---

## GD-09 — Shaders and Materials

### Unity Learn focus

Students explore:

- shaders;
- materials;
- surface appearance;
- textures;
- rendering concepts;
- normal/surface detail;
- selecting appropriate shader/material approaches.

### FoxCS priority

**RECOMMENDED**

### Student outcomes

Students can:

- distinguish material and shader conceptually;
- modify visible material properties;
- apply materials;
- use textures;
- explain how materials contribute to readability/mood;
- identify when visual choices interfere with gameplay clarity.

### Programmer-certification relevance

**Low**

### Later Artist relevance

**Very High**

This is useful shared foundation for students who later pursue Unity Artist.

### VR relevance

**Medium**

Materials affect visual readability and performance.

### Recommendation

Teach enough for all students to create intentional game visuals.

Do not require deep Shader Graph work before the Programmer exam.

---

## GD-10 — Lighting

### Unity Learn focus

Students learn to use:

- scene lighting;
- light sources;
- shadows;
- ambient/environmental lighting;
- baked lighting/lightmaps;
- probes;
- reflections;
- troubleshooting.

### FoxCS priority

**RECOMMENDED**

### Student outcomes

All students should at minimum be able to:

- identify major light types used in their project;
- adjust intensity/color/range as appropriate;
- use light to improve readability;
- use light to establish mood;
- troubleshoot a basic dark/overexposed scene;
- recognize that lighting choices can affect performance.

### Programmer-certification relevance

**Low**

### Artist relevance

**Very High**

### VR relevance

**Medium to High**

Lighting affects:

- spatial readability;
- comfort;
- performance;
- visual hierarchy.

### Scope note

Advanced baked-lighting/probe work may be **optional before Programmer certification**.

Students who later choose Artist can deepen this work.

---

## GD-11 — Iterate on Your Game

### Unity Learn focus

Students:

- reflect on the production process;
- reassess their game;
- refine controls;
- replace/improve assets;
- use additional Editor workflows;
- improve their project.

### FoxCS priority

# CORE — REQUIRED + EXPAND

This should become a major FoxCS **UX and playtesting unit**.

### Student outcomes

Students can:

- define a specific playtest question;
- observe another player without over-explaining;
- record evidence;
- distinguish a bug from a usability problem;
- identify confusing feedback;
- identify control/game-feel problems;
- prioritize changes;
- revise based on evidence;
- explain why they accepted or rejected feedback;
- document before/after changes.

### Programmer-certification relevance

**High**

Unity identifies iteration, prototyping, debugging, and solving programming problems as part of Programmer readiness.

### Game-design/UX relevance

**Extremely High**

This unit should include FoxCS-specific material on:

- game feel;
- player feedback;
- level design;
- accessibility;
- usability;
- player expectations;
- difficulty/fairness.

### GMTK/media integration

This is an ideal location for selected Game Maker's Toolkit content addressing:

- game feel;
- movement;
- level design;
- feedback;
- accessibility;
- difficulty;
- player engagement.

Each media assignment should lead to a **change/test in the student's own game**.

### AI opportunities

Students can ask AI to:

- identify possible causes of a recurring issue;
- generate hypotheses for why players misunderstand a mechanic;
- identify missing edge cases;
- propose diagnostic tests;
- explain why a system behaves inconsistently.

AI should not replace actual user testing.

---

## GD-12 — Prepare for Certification and Publishing

### Unity Learn focus

The Game Development pathway is designed toward the **Unity Certified Associate: Game Developer** credential.

Students finalize their project, compare it to design documentation, and prepare for certification/publishing.

### FoxCS priority

# REPLACE / FOXCS

The general project-finalization work is valuable, but the certification-prep target does not match FoxCS's first exam.

### FoxCS replacement

## FoxCS Unity Certified User: Programmer Preparation

Students should instead complete:

- Programmer objective review;
- Unity interface review;
- C# code-reading practice;
- script/component relationships;
- variables/data types;
- methods/parameters;
- conditions;
- arrays/lists/collections as relevant;
- access/visibility concepts;
- Unity lifecycle/event methods;
- Animator/state-machine interpretation;
- Console/error interpretation;
- debugging labs;
- Unity API/documentation practice;
- GMetrix diagnostic;
- targeted remediation;
- GMetrix practice tests;
- certification attempt.

### Publishing portion

Retain publishing/final-project work where useful.

### Programmer-certification relevance

**Very High after adaptation**

---

# 11. Recommended Game Development Requirement

| Mission | Expectation |
|---|---|
| GD-01 Get Started | **Compress** |
| GD-02 Basic 3D Game | **Required** |
| GD-03 Basic 2D Game | **Optional / differentiation** |
| GD-04 Planning a Game | **Required** |
| GD-05 Audio | **Normally required** |
| GD-06 Visual Effects | **Normally required** |
| GD-07 User Interfaces | **Required** |
| GD-08 Animation | **Required** |
| GD-09 Shaders & Materials | **Recommended** |
| GD-10 Lighting | **Recommended** |
| GD-11 Iterate on Your Game | **Required + expanded** |
| GD-12 Certification/Publishing | **Replace certification portion with Programmer prep** |

This means students complete a **substantial majority** of the Game Development pathway without being required to complete content merely for pathway-completion percentage.

---

# 12. Why the Game Development Pathway Is Still Valuable

The pathway is designed toward a certification level above the first FoxCS certification target.

That is useful because students gain experience with:

- full project development;
- 3D gameplay;
- C#;
- UI;
- animation;
- audio;
- VFX;
- materials;
- lighting;
- design documentation;
- iteration;
- publishing.

This broader game-development experience should make the narrower Certified User: Programmer concepts more meaningful.

However:

> Completing Game Development does **not automatically guarantee** that a student has practiced every Certified User: Programmer objective deeply enough.

FoxCS still needs targeted Programmer preparation.

---

# 13. Certified User: Programmer Coverage Gaps

The following areas may require **additional FoxCS lessons, Junior Programmer excerpts, certification courseware, or GMetrix** even if students complete most of Unity Game Development.

## Code vocabulary and interpretation

Students should explicitly practice:

- classes;
- variables/fields;
- common data types;
- access modifiers;
- methods;
- parameters;
- return values;
- conditions;
- collections;
- common Unity event methods.

## Debugging

Students need concentrated practice with:

- compile errors;
- runtime errors;
- exceptions;
- null references;
- wrong/missing components;
- unassigned Inspector references;
- incorrect method/callback names;
- API mistakes;
- logic errors.

## Unity API literacy

Students should practice:

- finding a Unity class/component;
- reading a method signature;
- identifying a property;
- interpreting parameters;
- using example code;
- comparing AI explanations to official documentation.

## State machines

Students should explicitly connect:

- state;
- transition;
- condition;
- Animator;
- gameplay state;
- function/state-machine concepts.

## Code evaluation

Students should regularly answer questions such as:

- What does this script do?
- When does this method run?
- Which value controls this behavior?
- Which component is required?
- What happens if this condition becomes true?
- What is likely causing this error?
- What would you change to produce a different behavior?

---

# 14. AI-Assisted Development Thread

AI should be integrated into lessons when it creates a meaningful opportunity to:

- explain;
- investigate;
- diagnose;
- compare;
- modify;
- generate;
- verify;
- reflect.

Students will likely use Microsoft Copilot.

The preferred learning cycle is:

# NOTICE → INVESTIGATE → ASK → TEST → VERIFY → EXPLAIN

## AI Mode 1 — Explain

Use when a student does not understand a concept.

Example:

> Explain what this Unity script is doing. Identify the variables, methods, component references, conditions, and Unity API calls I should understand.

## AI Mode 2 — Debug

Use when something does not work.

Preferred prompt style:

> Help me diagnose this problem. Give me a checklist of likely causes to test before you rewrite my code.

Students should learn that a bug may come from:

- code;
- Inspector configuration;
- GameObject selection;
- missing component;
- missing reference;
- physics settings;
- tags/layers;
- Animator configuration;
- scene state.

## AI Mode 3 — Build

Use when the desired behavior is understood but implementation syntax is a barrier.

Example:

> I want a door to open when the player has collected a key. Help me implement a simple Unity solution. Explain the components required and the important parts of the script.

Students remain responsible for understanding the implementation.

---

# 15. Required AI Evidence Points

Students do not need to log every Copilot interaction.

Recommended required checkpoints:

| Course Point | AI Task |
|---|---|
| Programming Essentials | Explain an unfamiliar script |
| 3D Player Movement | Explain/modify movement code |
| Collision/Collectibles | Diagnose a broken interaction |
| Game Planning | Identify missing requirements/edge cases |
| UI | Trace why state is or is not displaying |
| Animation | Diagnose an Animator/state problem |
| Iteration | Generate hypotheses for an observed problem |
| Programmer Prep | Analyze unfamiliar certification-style code |
| Debugging Unit | Diagnose intentionally broken systems |
| Capstone | Document one significant implementation/debugging conversation |

---

# 16. AI Development Log

Each student should maintain one persistent:

# FoxCS AI Development Log

Recommended format:

## Date

## Project / Lesson

## Goal
What were you trying to make happen?

## Problem / Question
What were you stuck on or trying to understand?

## Copilot Share Link
Paste the shareable conversation link.

## What Copilot Suggested
Summarize the important advice in your own words.

## What I Tested
What did you actually try?

## Result
What happened?

## What Actually Fixed or Improved It
What was the real solution?

## What I Understand Now
Explain what you learned.

## Still Unclear
Optional follow-up question.

---

# 17. Submission/Evidence Model

Unity assignments should not rely on one evidence type.

Possible evidence includes:

## Unity Learn evidence

- completed mission/activity;
- quiz result;
- pathway progress/checkpoint.

## Unity project evidence

- teacher checkoff;
- screenshot;
- short recording;
- playable build;
- project files when required.

## Game-design evidence

- GDD;
- level sketch;
- playtest notes;
- iteration record;
- accessibility review.

## AI evidence

- AI Development Log entry;
- Copilot share link;
- student summary/reflection.

## Certification evidence

- GMetrix diagnostic;
- targeted practice;
- practice test;
- certification result.

---

# 18. Moodle Structure Recommendation

Each major Unity assignment should include:

## 1. Learn

Exact Unity Learn lesson(s) to complete.

## 2. Build

What must exist/work in Unity.

## 3. Understand

Skills the student may be asked to demonstrate or explain.

## 4. Design / UX

What player-experience concept should be considered or tested.

## 5. AI Opportunity

Specific guidance for when/how AI can help.

## 6. Submit

Exactly what evidence must be turned in.

## 7. Move On When

The mastery checkpoint required to advance.

---

# 19. Example Moodle Assignment Structure

## Moving the Player

### Learn

Complete the assigned Unity Learn movement tutorial.

### Build

Your player must respond to the required controls and move consistently.

### Understand

Be prepared to identify:

- the movement script;
- the GameObject containing the script;
- the Rigidbody;
- the speed/movement variable;
- the method responsible for movement.

### Design

Test whether the movement feels:

- responsive;
- too fast;
- too slow;
- difficult to control.

Modify at least one movement value based on testing.

### AI

Use Copilot to explain the movement script.

Ask it to connect the script to concepts you learned in MakeCode.

### AI Development Log

Required.

Paste the conversation share link and explain what you learned.

### Submit

- Unity Learn completion/checkpoint;
- teacher demonstration or required project evidence;
- AI Development Log updated.

### Move On When

You can demonstrate working movement and explain the role of the script, Rigidbody, movement variable, and input logic.

---

# 20. Game Design and UX Thread

The following concepts should run alongside Unity technical content throughout the course.

## Player goal

Does the player know what to do?

## Feedback

Does the system clearly communicate the outcome of an action?

## Affordance

Does an interactive object look/behave like something the player can interact with?

## Controls / game feel

Does interaction feel responsive and intentional?

## Information hierarchy

Does the player receive the right information at the right time?

## Level design

Does the space teach and reinforce game mechanics?

## Difficulty

Is challenge understandable and fair?

## Accessibility

Who might encounter barriers?

## Playtesting

What happens when someone uses the game without the designer explaining it?

## Iteration

What changes because of evidence?

---

# 21. Relationship to Later Unity Artist Path

The following Game Development content creates useful shared preparation for Unity Artist:

- GameObjects/Prefabs;
- scene building;
- Audio;
- VFX;
- UI;
- Animation;
- Shaders and Materials;
- Lighting;
- project iteration.

Students who later choose Artist should deepen these areas after Programmer preparation rather than competing with Programmer preparation too early.

---

# 22. Relationship to Later Unity VR Developer Path

The following shared content creates useful preparation for VR:

- 3D navigation;
- GameObjects/components;
- physics;
- 3D spaces;
- camera concepts;
- interaction;
- UI;
- game state;
- audio;
- player feedback;
- accessibility;
- iteration;
- AI-assisted scripting;
- code interpretation/debugging.

After Programmer preparation, VR students can move into:

- XR setup;
- XR Interaction Toolkit;
- grabbing;
- locomotion;
- spatial UI;
- ergonomics;
- comfort;
- optimization;
- custom VR interactions.

---

# 23. Recommended Shared Unity Sequence

## Phase A — MakeCode

Students learn:

- events;
- input;
- variables;
- conditions;
- functions;
- coordinates;
- collision;
- game state;
- feedback.

## Phase B — Unity Essentials Boot Camp

Required:

1. Editor Essentials
2. 3D Essentials
3. Programming Essentials

## Phase C — Game Development Core

Required/expected:

1. compressed Get Started
2. Basic 3D Game
3. Planning a Game
4. Audio
5. VFX
6. UI
7. Animation
8. appropriate Materials/Lighting
9. Iterate on Your Game

2D Game:

- optional/differentiated.

## Phase D — FoxCS Programmer Preparation

- code interpretation;
- debugging;
- API literacy;
- state machines;
- GMetrix;
- targeted remediation;
- certification attempt.

## Phase E — Specialization

After the Programmer milestone:

### Artist-forward

Creative Core / Artist objectives.

### VR-forward

VR Development / VR Developer objectives.

---

# 24. Key Planning Decision

FoxCS should **not** measure success by whether every student earns 100% completion on both Unity Learn pathways.

The stronger measure is whether the selected content produces the required learning outcomes.

The recommended approach is:

> **Use Unity Learn as the primary structured learning spine, but use FoxCS mastery checkpoints to decide whether a student needs every activity.**

Students who can already demonstrate a skill may move ahead.

Students who need reinforcement can use additional Unity Learn activities.

Students interested in 2D can complete the 2D Game mission.

Students interested in deeper visual work can revisit/deepen Materials, Lighting, VFX, Animation, and later Creative Core.

---

# 25. Open Items for the Detailed Course Map

The next course-map pass should add:

- exact 2026–27 academic-calendar dates;
- expected week for each required Unity Learn activity;
- estimated lesson time;
- Moodle assignment names;
- direct Unity Learn lesson links;
- exact Programmer objective/domain IDs;
- GMTK/game-design resources paired to each unit;
- mastery checks;
- recovery routes;
- ahead-of-pace routes;
- GMetrix start date;
- certification exam window;
- Artist/VR specialization start date.

---

# 26. Planning Summary

## Unity Essentials

**Required core:**
- Editor Essentials
- 3D Essentials
- Programming Essentials

**Deferred/absorbed later:**
- Audio Essentials
- Publishing Essentials

**Optional:**
- 2D Essentials

## Game Development

**Required/expected:**
- Basic 3D Game
- Planning a Game
- Audio
- Visual Effects
- User Interfaces
- Animation
- Iterate on Your Game

**Recommended:**
- Shaders & Materials
- Lighting

**Compressed:**
- Get Started in Unity

**Optional/differentiated:**
- Basic 2D Game

**Adapt/replace:**
- Associate-oriented certification preparation → FoxCS Certified User: Programmer preparation

## Primary goal

Students develop enough broad Unity experience that the Certified User: Programmer exam reflects tools and concepts they have actually used.

## AI goal

Students use AI as a normal development partner for:

- explanation;
- implementation support;
- debugging;
- gap finding;
- code interpretation;
- reflection.

They preserve useful Copilot conversation links in a persistent AI Development Log and remain responsible for understanding the systems they use.
