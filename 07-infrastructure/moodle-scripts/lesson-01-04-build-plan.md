# Lesson 01.4 (Printing Output) — Build Plan for Tomorrow

**Written 2026-09-03, updated same night after Instruction went live.** Goal: get 01.4 live for Python students, matching the exact pattern already proven for 01.1-01.3 (verified live against the DB — all three have real Instruction/Practice/Mastery Check modules; 01.3 additionally has a "01.3 Coding Exercise" Assignment). Real content for 01.4 already exists and is fully authored in `courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/` — this plan is about porting it into native Moodle modules, not writing new content from scratch.

**Decided tonight: 01.4 gets its own per-lesson Assignment** ("01.4 Coding Exercise"), matching 01.3's real precedent rather than the older "Project is per-unit only" note in worklog.md — 01.4's own authored content (`07_project.html`/`08_project.py`) is written as a complete standalone project, not a pointer back to the Unit project, so the per-lesson pattern is the better fit. See Open Decisions below, item 1 is now resolved; items 2-4 are still open.

**Status of each piece below.**

---

## 1. Instruction — DONE, LIVE (cmid=212, lessonid=11)

Built and verified tonight via `build-lesson-01-04-instruction-tabbed.php` + `content-01-04-tabbed-instruction.html`. Verified directly against the DB, not just script output: `maxanswers=6`, `custom=1`, `retake=0`, all 6 pages present (Tab/QCA/QCB/VocabQuiz/Breakdown/VocabRetry) with the right answer counts (1/4/4/7/1/7). Cache purge already run once tonight; re-purge (`sudo -u www-data php /var/www/moodle/admin/cli/purge_caches.php`) after any further direct-DB changes below.

Still to do for this module specifically: the same finalize pass 01.1 got (see `finalize-lesson-01-01.php`) — `completion=2` + `completionendreached=1`, gradebook item in the same category as Practice/Mastery Check once those exist, due date (see Open Decisions).

---

## 2. Practice — SCRIPTED, NOT YET RUN

`build-lesson-01-04-practice-ladder.php` is written and syntax-checked (`php -l` clean), staged for `/tmp` the same way as Instruction's script. **Redesigned tonight from an earlier drill-source-based draft** after checking the ladder against 01.4's actual stated objectives in `01_instruction.html` — the drill-source grouping didn't map cleanly onto them. Now THREE clusters, one per real objective, Core 1 / Reinforce 1 / Extend 1 each (no separate Reteach pages):

| Cluster | Objective | Core question |
|---|---|---|
| **01.4a** predicts_print_output | "write a correct print() statement and predict what it will display" | Predict exact output of `print("Game paused.")` |
| **01.4b** diagnoses_print_syntax_errors | "identify and fix a missing quote or missing parenthesis error" | Diagnose `print("Game Over')` — mismatched quote style |
| **01.4c** identifies_print_statement_parts | Language objective: function/string/argument | Identify what `"Ready to play!"` is called in `print("Ready to play!")` |

Every broken-statement example in this ladder (mismatched quote style in Core/Reinforce, missing opening parenthesis in Extend) is a genuinely new variant, distinct from the ones already used in Instruction's Quick Checks (missing opening quote / missing closing paren only) and the Mastery Check (missing closing quote / missing parens entirely) — checked directly against both of those, not assumed.

**To run:**
```
cp build-lesson-01-04-practice-ladder.php /tmp/
sudo -u www-data php /tmp/build-lesson-01-04-practice-ladder.php
```
**Then immediately run** `php 02-authoring-system/tools/check-lesson-ladder-wiring.php --cmid=<new cmid> --pool-cap=2` — zero errors, zero warnings is the bar, per this repo's own standing rule. Not run yet tonight since the activity itself hasn't been created live.

---

## 3. Mastery Check — SPEC ONLY, needs building

Reference implementation: `rebuild-mastery-check-task-pool.php` (has the current, correct question-save API pattern) and `finalize-lesson-01-01.php` (has the required-first integrity question, verbatim). Settings unchanged from 01.1-01.3: native `mod_quiz`, password-gated (`usepassword`... actually implemented via the quiz's own password/access-rule settings — check `enable-seb-mastery-check-01-01.php` for the Safe Exam Browser layer too, not yet resolved whether to add it here — see Open Decisions below), 3-attempt cap averaged not highest, real pre-attempt warning intro text.

**Required first question — copy this EXACT text (per Jay's standing instruction: this question is first on every Mastery Check, not just 01.1's):**

> **Before you begin: read this carefully.**
>
> By starting this Mastery Check, you are confirming that during this attempt you will **not**:
> - use any unauthorized sources (websites, AI tools, notes, textbooks, etc.)
> - use study materials of any kind
> - share information with peers, or receive information from a peer
> - keep your phone in your possession
>
> Violating any of these will result in a **0% (F)** on this Mastery Check, and you will be **ineligible for any retake** to earn credit for this skill.
>
> Type **I understand** below to continue.

`qtype = 'shortanswer'`, `maxmark = 0` (doesn't dilute the 4 real essay questions' average — same as 01.1).

**The 4 real essay questions (verbatim from `09_mastery_check.html`, slots 2-5):**

1. *(DOK 1-2, direct prediction)* Predict exactly what this displays:
   ```
   print("Welcome back!")
   print("You have 3 lives remaining.")
   ```
2. *(DOK 2, debug — missing closing quote)* This line is broken. Rewrite it correctly, and name the specific mistake: `print("Inventory Full)`
3. *(DOK 2, debug — missing parentheses)* This line is broken. Rewrite it correctly, and name the specific mistake: `print "Quest Complete"`
4. *(DOK 3, apply)* Write a single `print()` statement that could appear in a real game telling the player they don't have enough coins to buy something. Then explain, in a sentence or two, what makes your message good feedback rather than just technically-valid output.

Full grading criteria and the two misconception codes (`CODE-01`: treating "runs without crashing" as "good output"; `CODE-02`: fixing a syntax error without being able to name what was wrong) are in `courses/python/teacher-materials/unit_01_what_is_programming/lesson_01_04_mastery_check_KEY.md` — read that before grading, don't grade from memory of this plan.

**Real gotcha to reuse, not rediscover:** `quiz_update_sumgrades()` was renamed — use `quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();` after adding questions (confirmed working, see `rebuild-mastery-check-task-pool.php` line ~180).

**Pre-attempt intro text** (adapt from `finalize-lesson-01-01.php`'s pattern, referencing 01.4's own Practice/Project instead of 01.1's):
> This is a scored test attempt, not practice. Once you start, it counts.
> Before you begin, make sure you have already completed 01.4's Practice and Project/application work — this Mastery Check assumes you've already applied these skills, not that you're seeing them for the first time.
> Don't start until you're actually ready. Ask your teacher for the password when you are.

**Password:** pick a new 6-character one, don't reuse `T4WPR8`/`K7QXP2` from other lessons.

---

## 4. Coding Exercise (Assignment) — SPEC ONLY, needs building

**Decision made tonight (see top of doc): 01.4 gets its own per-lesson Assignment**, `01.4 Coding Exercise`, matching 01.3's real precedent. Content ports directly from the real, already-authored `07_project.html` ("Status Message Board" — write 3+ `print()` status lines plus one specific, readable problem message, matching the Game Connection usability idea) and `08_project.py` (the starter/answer file). Check `mdl_assign` for cmid=206 (01.3's Coding Exercise) directly and mirror its exact settings (submission type — almost certainly file upload of a `.py` file, matching the "VS Code, then upload" two-surface model — grading type, due-date field names) rather than guessing them fresh.

**Real tiered-XP structure already authored, don't flatten it:** Required (3+ status lines, 1+ specific problem message, no syntax errors) / Tier 1 bonus +10 XP (2+ more status lines of different kinds, a comment explaining a message's wording) / Tier 2 bonus +20 XP (a short reflection comment on the usability idea, thematic consistency across all lines). If the Assignment's grading is rubric-based, build the rubric with these three tiers as real rubric levels, not a flattened pass/fail.

---

## Open Decisions (need Jay's call before/while building)

1. ~~**Per-lesson Project/Assignment**~~ — **RESOLVED 2026-09-03**: 01.4 gets its own per-lesson `01.4 Coding Exercise` Assignment, matching 01.3's real precedent over the older per-unit-only note. See section 4 above.
2. **Safe Exam Browser** — `enable-seb-mastery-check-01-01.php` shows SEB is installed and was at least explored for 01.1. Not confirmed whether it should be applied to 01.4's Mastery Check too, or if 01.1's SEB status itself is still just exploratory (per the "real open question, not yet resolved" note in worklog). Decide before setting up 01.4's Quiz access rules.
3. **Due date.** 01.1's was set explicitly (`2026-09-01 15:30 America/Chicago`); worklog says 01.2/01.3 due dates were intentionally deferred ("Jay wants to come back to those later in the week"). Pick real due dates for 01.2, 01.3, and 01.4 together, or continue deferring — don't leave 01.4 dateless by default without a decision.
4. **Reflection.** Worklog flags "each unit should also get a Reflection" as a real, not-yet-built open item, separate from the per-sub-lesson pattern. Not blocking for 01.4 specifically, but worth deciding whether it lands before or after 01.4 ships.

## Verification Checklist (do this before calling 01.4 "live")

- [ ] `check-lesson-ladder-wiring.php --cmid=<practice cmid> --pool-cap=2` — zero errors, zero warnings.
- [ ] Query `mdl_lesson_pages`/`mdl_lesson_answers`/`mdl_quiz`/`mdl_question` directly to confirm what the build scripts *actually* wrote — a script reporting success and the database reflecting it are two different claims (this repo's own standing rule, learned the hard way on 01.1's ladder build).
- [ ] Click through Instruction, Practice, and Mastery Check as `foxcstest` (or log in as that account) end to end — tabs render, both Quick Checks route correctly, Vocab Quiz matching + branching works, Practice ladder routes wrong→Reinforce/right→Extend without lane-crossing, Mastery Check password gate + integrity question work.
- [ ] Confirm completion tracking (`completion=2`, `completionendreached=1`) and a gradebook item exist for Instruction and Practice, matching 01.1-01.3.
- [ ] Purge Moodle caches (`sudo -u www-data php /var/www/moodle/admin/cli/purge_caches.php`) after all direct-DB build scripts run — several of tonight's scripts write straight to the DB without always calling Moodle's own cache-rebuild helpers, which can cause a built module to exist correctly in the DB but not render/appear correctly until caches are purged. (This was checked and purged once already tonight as a precaution; re-purge after any further direct-DB changes.)
- [ ] Re-run this section's checklist against the LIVE course, not this plan's description of it — sections/cmids get renumbered/reorganized over time (already true of this course per `adaptive-ladder-runbook.md`).
