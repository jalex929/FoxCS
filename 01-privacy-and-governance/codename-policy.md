# Codename Policy

Status: **locked 2026-08-30** for the real 2026-27 roster — the `PY1-A-ALPHA01` format below was provisional and never actually used to generate a real roster. It's superseded by the format Jay specified directly when asking for the first real 35-per-class codename batch (see `decisions-log.md`, 2026-08-30 entry, and `06-data-and-spreadsheets/roster-schema.md` for the real generated roster).

## Purpose

Remove student PII from any external/AI-assisted tooling (grader, similarity analysis, feedback drafting) while keeping stable, consistent identifiers a teacher can track across a full year, multiple sections, and multiple courses.

## Format

```
G1-1-NOVA
```

- `G1` — course code, chosen so the class's own name is directly readable (`G1` = Game I, `G2` = Game II, `W2` = Web II, `S3` = Seminar III). One letter + the course's own numeral, not an arbitrary abbreviation, per Jay's explicit requirement that the class be visually identifiable at a glance — this matters because Game II and Web II share the same room and period, and students may choose either pathway regardless of which course they're actually enrolled/graded under.
- `1` — class period (1st, 4th, 5th, 7th, 8th — whichever period that specific section meets).
- `NOVA` — one word from a shared Space & Astronomy theme word list (non-animal, real astronomy vocabulary, "fun but not goofy" per Jay's standing preference — see `decisions-log.md`'s earlier band-vocabulary-style entries for the same tone bar). 40 words cover each class (35 active seats + 5 reserve slots for transfers) with no repeats; see `06-data-and-spreadsheets/roster-schema.md` for the full word list and generation notes if a class ever needs more.

Codenames are assigned once at the start of the year and stay stable across all assignments and both delivery surfaces (Moodle account username *and* the folder/file name students use in VS Code — same codename, both places). **Word-to-student mapping isn't alphabetized yet** — the word list is generated in a fixed order; Jay assigns word #1 to the alphabetically-first real student on each class roster once he has it, same principle the old `ALPHA01` suffix was going for, just reusable across classes without collision since the course-period prefix already guarantees global uniqueness.

## Private Roster (school-controlled only, never leaves teacher-controlled storage)

| Field |
|---|
| `codename` |
| `student_name` |
| `student_email` |
| `guardian_email` |
| `class_section` |
| `school_student_id` |
| `active_status` |

## What External Tools (grader, AI feedback drafting, similarity analysis) May Receive

- Codename
- Student work / submissions
- Assignment and rubric information
- Prior codename-based performance history, when needed for adaptive placement or proficiency-consistency checks

## What External Tools Must Never Receive

- Student name
- Student ID
- Student or guardian email
- Guardian name
- Any other directly identifying information

## Student-Facing Rules

**Simplified 2026-08-04 — students no longer name anything with their codename.** Previously required students to name their own submission folder and files with their codename, graded as a rubric line item. That's reversed: the whole folder is submitted through Google Classroom exactly as provided (fixed filenames, no renaming), and Jay's codename-swap script (see below) does the renaming and real-name stripping *after* collection, working from Classroom's own account-linked submission data — before anything reaches `05-grader/` or Claude Code. Current rules:

- Don't rename the files or folders you're given — work inside them as-is.
- Never put your real name in code comments, reflection text, or anywhere else in your work, even though the filenames themselves are already handled for you.
- Submit the complete folder, not individual files pulled out of it (pending resolution — see `open-questions.md` on submission cadence).

## Tooling Needed: Codename-Swap-on-Download Script (not yet built)

Documented 2026-08-04 so this requirement doesn't get lost between sessions — see `worklog.md` and `open-questions.md` for status.

**Purpose:** when Jay downloads a batch of submitted unit folders from Google Classroom, real student names (from however Classroom names the downloaded files/folders — typically the student's account display name) need to be stripped and replaced with the matching codename from the private roster, **before** anything in that folder reaches `05-grader/` or any AI-assisted tool. This is what makes the Release Gate in `data-boundaries.md` actually enforceable in practice, not just a policy statement — the grader can only guarantee it never receives a real name if nothing upstream of it still has one.

**Requirements:**
- Input: whatever folder/file naming Google Classroom actually produces on bulk download (not yet confirmed — see `open-questions.md`'s "whether downloaded/submitted folders preserve directory structure through Google Classroom").
- Lookup: match each submission to a codename via the private roster (`student_name` ↔ `codename`), never the reverse — the script should not need to touch anything but the roster and the downloaded batch.
- Output: a renamed/rewritten copy of the batch where every folder, filename, and any real name that leaked into file *contents* (code comments, reflection text, journal entries — see "Known Gaps" below) is replaced with the codename. Should not modify the original download in place — keep it recoverable in case the swap needs re-running.
- Where it lives: not decided — either a `05-grader/` intake step or its own small tool under this folder. Leaning intake step, since its whole purpose is gating what `05-grader/` is allowed to see, but not confirmed.
- **Not built yet.** Needs the Classroom-download-format question answered first, then can be scoped for real.

## Known Gaps to Close Before Real Student Data Is Involved

- Accidental identifying info can still leak through: code comments, file metadata, folder names, reflection free-response answers, screenshots, embedded documents. No automated check for this exists yet — needs to be part of the grader's file-validation pass (`05-grader`) before launch, not just a student instruction.
- SOPPA compliance is not established by this policy alone — verify hosting environment, plugins, retention policy, and data-sharing agreements with the district's data privacy officer before any real student data flows through Moodle, the grader, or any external AI tool.
