# Codename Policy

Status: **provisional** — format is proposed, not finalized (see `open-questions.md`).

## Purpose

Remove student PII from any external/AI-assisted tooling (grader, similarity analysis, feedback drafting) while keeping stable, consistent identifiers a teacher can track across a full year, multiple sections, and multiple courses.

## Format

```
PY1-A-ALPHA01
```

- `PY1` — course code (Python 1). Other FoxCS courses get their own prefix (e.g. `WD1` for Web Dev, `UN1` for Unity) when they start.
- `A` — class section letter.
- `ALPHA01` — alphabetized roster position within that section, zero-padded.

Codenames are assigned once at the start of the year and stay stable across all assignments and both delivery surfaces (Moodle account username *and* the folder/file name students use in VS Code — same codename, both places).

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
