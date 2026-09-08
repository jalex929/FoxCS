# 2.1 Adaptive Practice — Full Question Bank

Added 2026-09-08 per Jay: every lesson should have a markdown file listing its full adaptive question set (2 of each scaffold level — Reinforce, Core, Extend — per assessed skill), drafted ahead of when it actually gets wired into the interactive lesson, so authoring time is spent building, not re-deriving what to build.

**Current live state (verified against `01_instruction.html` 2026-09-08):** each of the 4 skill nodes below has exactly 1 Core + 1 Reinforce + 1 Extend item already coded and working (`core_01`/`reinforce_01`/`extend_01`). That's the old 1-per-tier minimum. This file's job is to bring every skill to **2 of each tier**, per Jay's new standing target. The `_01` items are described briefly below for continuity (see the live file for their exact wording/code); the `_02` items are fully drafted here, ready to wire in. Node 4 (`prints_variable_with_text`) already has two bonus items beyond the standard three (`extend-predict`, `contrast`) — noted below, left as-is, not part of the 2-per-tier count.

Grounded in `../../../skills-map.md`'s 02.1 section (Common Misconceptions, Adaptive Question Targets) and `../../../../../02-authoring-system/content-authoring-standards.md`'s misconception-pairing rule — every wrong answer below names the specific misconception it catches, not just "incorrect."

---

## Skill 1: `creates_variable`

**Misconceptions this skill targets** (from skills-map.md): `=` means mathematical equality; a variable's original value is permanently attached to it.

### Core (existing: `core_01`)
Fill-in-the-blank creating `player_name = "Rowan"`, run and check against expected `Player: Rowan` / `Health: 100` output. Already live.

### Core (new: `core_02`)
**Format:** Build the Code (Run & Check), new context (inventory, not player status — varies scenario per the "vary context, not just numbers" rule).

**Prompt:** Fill in the blank so the program prints exactly:
```text
Coins: 50
```
```python
____________________
print("Coins:", coins)
```
**Expected fill:** `coins = 50`

**Feedback if wrong:** run the student's code and diff the actual output against the expected line, same pattern as `core_01`.

### Reinforce (existing: `reinforce_01`)
MC: which line correctly creates a variable named `score` set to `0`, distractors hit reversed sides (`0 = score`), `==` instead of `=`, and quoting a number (`score = "0"`). Already live.

### Reinforce (new: `reinforce_02`)
**Format:** Categorization / identify-the-incorrect-line (per the tier-purpose rule that Reinforce should vary *format*, not just reuse MC every time).

**Prompt:** Three of these four lines correctly create a variable. Which one does **not**?
- A) `health = 100`
- B) `lives = 3`
- C) `score == 0`
- D) `difficulty = "Normal"`

**Correct:** C

**Feedback:**
- If C selected: "Right. `==` checks whether two things are equal — it never creates or changes a variable."
- If A/B/D selected: "That line does correctly create a variable. Look again at option C specifically: what does `==` actually do?"

### Extend (existing: `extend_01`)
Fill-in-the-blank creating `difficulty = "Normal"` alongside an existing `lives` variable, transfer to a second variable in the same short program. Already live.

### Extend (new: `extend_02`)
**Format:** Debugging, unfamiliar (non-game) context, per Extend's "less familiar context, requires transfer" rule.

**Prompt:** A weather app is supposed to create a variable holding today's temperature and print it. Here's what a student wrote:
```python
temperature == 72
print("Temperature:", temperature)
```
It crashes with `NameError: name 'temperature' is not defined`. Why, and what's the one-character fix?

**Expected answer (short answer):** `temperature = 72` — the fix is changing `==` to `=`. Accept an explanation along the lines of "`==` never creates a variable, so `temperature` was never actually defined."

**Feedback if wrong:** "Check what `==` actually does versus what `=` does. Only one of them creates a variable in the first place."

---

## Skill 2: `variable_naming_rules`

**Misconceptions this skill targets:** capitalization does not matter; any punctuation is fine as long as it "looks like" a name.

### Core (existing: `core_01`)
MC: which of `2score` / `player score` / `player_class` / `class` is valid. Distractors hit leading-digit, space, and reserved-word. Already live.

### Core (new: `core_02`)
**Format:** MC, same recognition task, different distractor set — this time include a case-sensitivity distractor, which `core_01`'s options don't cover.

**Prompt:** Which of these is a valid Python variable name?
- A) `Player-Score`
- B) `9lives`
- C) `total_score`
- D) `total score!`

**Correct:** C

**Feedback:**
- If A: "Hyphens aren't allowed in Python names — Python would read `Player-Score` as `Player` minus `Score`. Use an underscore instead: `player_score`."
- If B: "Names can't start with a digit."
- If D: "Spaces and punctuation like `!` aren't allowed in a name."

### Reinforce (existing: `reinforce_01`)
MC isolating the leading-digit rule specifically (`2lives` vs `lives2`/`_lives`/`lives_2`). Already live.

### Reinforce (new: `reinforce_02`)
**Format:** MC isolating a *different* single rule than `reinforce_01` (no spaces allowed), per Reinforce's "isolate one concept" purpose.

**Prompt:** A variable name is not allowed to contain a space. Which of these breaks that one specific rule?
- A) `player_name`
- B) `player name`
- C) `playername`
- D) `_player_name`

**Correct:** B

**Feedback:** "Right — Python reads a space as the end of the name. `player_name`, `playername`, and `_player_name` all avoid spaces (only `player_name` follows the snake_case style, but that's about style, not validity)." / If wrong: "Look for the one option with a literal space between two words."

### Extend (existing: `extend_01`)
Build-the-code: create `is_game_over = True` in snake_case, matching expected output. Already live.

### Extend (new: `extend_02`)
**Format:** Repair task (per skills-map's explicit "repair an invalid variable name" target, not yet covered by any existing item in this node).

**Prompt:** A student named a variable `player-score` (with a hyphen) to track a player's score. It doesn't work the way they expect. Rewrite it as a valid, snake_case Python variable name (don't change what it represents, just fix the name):

**Expected answer:** `player_score`

**Feedback if wrong:** "The problem is the hyphen specifically — Python doesn't allow it in a name. Snake_case uses underscores to join words, never hyphens or spaces."

---

## Skill 3: `reassigns_variable`

**Misconceptions this skill targets:** assigning a new value creates a second copy; a variable's original value is permanently attached to it.

### Core (existing: `core_01`)
Build-the-code: fill in `lives = 2` to make output go from `Lives: 3` to `Lives: 2`. Already live.

### Core (new: `core_02`)
**Format:** Build the Code, new scenario (temperature reading, not lives).

**Prompt:** The thermostat just updated. Fill in the blank so the program prints exactly:
```text
Temperature: 68
Temperature: 72
```
```python
temperature = 68
print("Temperature:", temperature)
____________________
print("Temperature:", temperature)
```
**Expected fill:** `temperature = 72`

### Reinforce (existing: `reinforce_01`)
MC: which line correctly changes `x` from `5` to `9` (distractors: `==`, `new x = 9`, `x + 9`). Already live — this tests the *syntax* of reassignment.

### Reinforce (new: `reinforce_02`)
**Format:** MC directly targeting the "second copy" misconception itself, not the syntax — a genuinely different angle, per Reinforce's "help diagnose the misconception" purpose.

**Prompt:**
```python
x = 5
x = 9
```
After this code runs, how many variables named `x` exist?

- A) One — `x` now holds `9`. The `5` is gone.
- B) Two — one holds `5`, one holds `9`.
- C) It depends on whether you print `x` afterward.

**Correct:** A

**Feedback:**
- If B: "This is a common assumption, but it's not what Python does. Reassigning `x` overwrites its value — it doesn't create a second, separate variable. The old value (`5`) isn't kept anywhere."
- If C: "Printing doesn't change how many variables exist — it just displays whatever `x` currently holds. Think about what the second line actually does to `x` itself."

### Extend (existing: `extend_01`)
Build-the-code: fill in a third reassignment (`score = 25`) after two prior ones, in a 3-line trace. Already live.

### Extend (new: `extend_02`)
**Format:** Multi-line trace/prediction (no fill-in-the-blank — asks the student to predict, a lighter version of the full Code Stepper work coming in 02.7), unfamiliar context.

**Prompt:** A vending machine program tracks how many snacks are left:
```python
stock = 10
stock = stock - 3
stock = stock - 2
print("Stock:", stock)
```
What does this print?

**Expected answer (short answer):** `Stock: 5`

**Feedback if wrong:** "Trace it one line at a time: what does `stock` hold right after the first `stock = stock - 3`? Use that value for the next line, not the original `10`."

---

## Skill 4: `prints_variable_with_text`

**Misconceptions this skill targets:** commas and `+` behave the same way; `+` auto-converts non-strings the way commas do.

**Note:** this node already has 5 live items, not just 3 — `core_01` (comma, build), `reinforce_01` (comma, MC), `extend-predict` + `extend_01` (a predict-then-fix `+`/TypeError pair), and `contrast` (MC identifying which of 4 lines crashes). The two new items below specifically fill a real gap: every existing item's *Core* and *Reinforce* slots are comma-focused, so the `+` side has never been Core- or Reinforce-tested on its own, only Extend-tested via the bug-fix pair.

### Core (new: `core_02`)
**Format:** Build the Code, `+` concatenation instead of commas (the existing `core_01` only builds a comma version).

**Prompt:** Fill in the blank with one `print()` call, using `+`, that prints exactly:
```text
Level 5 unlocked
```
```python
level = "5"
____________________
```
**Expected fill:** `print("Level " + level + " unlocked")`

**Hint (if requested):** "`level` is already a string here (it's in quotes), so no `str()` conversion is needed — just join the three pieces with `+`, remembering the spaces have to be typed inside the quotes."

### Reinforce (new: `reinforce_02`)
**Format:** MC isolating the auto-spacing difference specifically — a distinct misconception from `reinforce_01`'s (which tests comma/quote/colon syntax, not spacing).

**Prompt:**
```python
name = "Rowan"
print("Hello" + name)
```
What does this actually print?

- A) `Hello Rowan` (with a space)
- B) `HelloRowan` (no space)
- C) It crashes.

**Correct:** B

**Feedback:**
- If A: "This is the comma behavior, not `+`. Commas add a space automatically; `+` joins pieces exactly as written, with no extra space unless you type one yourself inside the quotes."
- If C: "This doesn't crash — `name` is already a string (`\"Rowan\"`), and `+` can join two strings fine. It just won't have the spacing you might expect."

### Extend (new: `extend_02`)
**Format:** Compare-and-choose, transfer — asks the student to reason about *which tool fits*, not just execute one.

**Prompt:** You need to print a sentence combining three pieces: a literal word, a number variable, and another literal word — something like `"You found " + str(count) + " coins"`. A teammate suggests using commas instead: `print("You found", count, "coins")`. Which approach requires less typing for a number variable specifically, and why?

**Expected answer (short response, not auto-graded — flag for a quick teacher glance or fold into Mastery Check style grading):** Commas require less typing here, because commas auto-convert `count` to text automatically, while `+` requires manually wrapping it in `str(count)` first.

**Feedback:** if the response doesn't mention auto-conversion, prompt: "Think about what extra step `+` needs that commas don't, specifically when one of the pieces is a number."

---

## Wiring Notes (for whoever implements these next)

- Match the existing `logEvent('drill_attempt', {...})` / `lane_transition` pattern already used by `core_01`/`reinforce_01`/`extend_01` for each new item — same `skill_id`, new `item_id` (`core_02`, `reinforce_02`, `extend_02`).
- Per the Adaptive Practice Structure in `skills-map.md`'s framework section, a student should see **2 questions per assessed skill** per real attempt (Core first, then Reinforce-on-miss or Extend-on-hit) — the `_02` items are the "second Core question" pool skills-map.md calls for (an alternate starting question for reassessment/repeated practice), not something every student sees on their first pass. Decide the actual selection logic (random between `_01`/`_02`, or `_02` reserved for a retry) before wiring in — not decided here.
- Skill 4's `extend_02` isn't a clean auto-gradable short-answer the way the others are — flag it as a discussion/written item if it stays, or convert it to an MC before wiring in, since the rest of this node auto-grades.
