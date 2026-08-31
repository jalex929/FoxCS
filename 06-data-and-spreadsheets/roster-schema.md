# Roster Schema

**Last verified against the live roster on 2026-08-31.**

**First real roster generated 2026-08-30**, per Jay's direct request for 35 codenames per class period across 6 real class periods, with the class visually identifiable from the codename itself. Lives as a Google Sheet in Jay's own Drive (`jafox7@cps.edu`, `SY27` folder), titled "FoxCS Private Roster 2026-27 (Codenames — DO NOT SHARE)" — not committed to this git repo, since it's the one place real student names will eventually land (see `01-privacy-and-governance/data-boundaries.md`'s Two Sheets, Never Merged rule). This file documents the schema and the codename generation itself, which is safe to keep in the repo since it contains no real student data yet.

**Revised twice same day, both times per Jay:** (1) column order changed so `first_name`/`last_name`/`student_email` lead, letting Jay paste a raw CPS roster export directly into the first 3 columns per class block, with `class_period`/`course` pre-filled by Claude Code since the block structure already encodes it; (2) each class extended from 35 to 40 rows (35 `active` + 5 `reserve`), so a mid-year transfer has a ready-made unassigned codename instead of requiring the whole scheme to be regenerated.

## Columns (left to right)

| Column | Meaning |
|---|---|
| `first_name`, `last_name`, `student_email` | Blank in the generated sheet — Claude Code never fabricates student names. Jay pastes these in from a real roster once he has one, matching them row-by-row within each class's block. |
| `class_period` | Class period (1st, 4th, 5th, 7th, 8th) — pre-filled. |
| `course` | Full course name (Game I / Game II / Web II / Seminar III) — pre-filled. |
| `codename` | See `01-privacy-and-governance/codename-policy.md`'s locked 2026-08-30 format: `{COURSECODE}-{PERIOD}-{WORD}`. |
| `roster_position` | 1-40 (1-35 active, 36-40 reserve), fixed generation order (alphabetical by theme word, not by student). Jay maps position 1 to the alphabetically-first real student once he has each class's real roster, same principle the old `ALPHA01` suffix was going for. |
| `initial_password` | One unique, memorable password per student — see Passwords below. |
| `guardian_email`, `school_student_id` | Blank — filled in once real data exists. |
| `active_status` | `active` for the 35 real slots per class, `reserve` for the 5 buffer slots — see Reserve Slots below. |

## The 6 Classes and Their Course Codes

**Corrected 2026-08-31 against the live roster** — the `Codename prefix` column below was the original design and was never actually implemented; see `01-privacy-and-governance/codename-policy.md`'s 2026-08-31 correction for why. The real prefixes are shown in the last column.

| Class | Course code | Period | Codename prefix (as designed, unused) | Codename prefix (actual, live) |
|---|---|---|---|---|
| Game I, 1st period | `G1` | 1st | `G1-1-` | `G1-` |
| Game I, 8th period | `G1` | 8th | `G1-8-` | `G8-` |
| Seminar III, 4th period | `S3` | 4th | `S3-4-` | `S4-` |
| Seminar III, 5th period | `S3` | 5th | `S3-5-` | `S5-` |
| Game II, 7th period | `G2` | 7th | `G2-7-` | `G7-` |
| Web II, 7th period | `W2` | 7th | `W2-7-` | `W7-` |

The actual scheme fuses a single subject-family letter (`G`=Game, `S`=Seminar, `W`=Web — Game I and Game II share `G`) directly with the period digit, dropping the course-version digit. This works only because no two classes sharing a letter ever meet at the same period. **`G21-ANDROMEDA` resolved, 2026-08-31, per Jay:** a real, intentional special case, not a data-entry error — a solo student in 1st period enrolled in Game II, who also serves as the teacher's assistant in the room. Not one of the 6 standard class blocks above, but a legitimate 7th seat. Keep as-is; her account should stay enrolled and valid in both `foxcs-gotw` and `foxcs-onboarding-l2`.

**Game II and Web II share the same room and period (7th)**, and students may pursue either pathway regardless of which course they're actually enrolled/graded under — the codename encodes *enrolled course*, not chosen pathway, since that's what determines which gradebook a student actually shows up in. This was Jay's explicit reason for wanting the class visually identifiable from the codename itself.

## Space & Astronomy Word List (40 words per class: 35 active + 5 reserve, no repeats within a class)

```
Active (roster_position 1-35):
NOVA, ORION, COMET, QUASAR, NEBULA, LUNAR, SOLAR, METEOR, ECLIPSE, ZENITH,
VEGA, POLARIS, COSMOS, GALAXY, PULSAR, CRATER, APOLLO, TITAN, EUROPA, CORONA,
ORBIT, STARDUST, ROCKET, ASTRO, ASTRAL, SATURN, MARS, VENUS, PLUTO, CERES,
ANDROMEDA, ROVER, LAUNCH, GRAVITY, HORIZON

Reserve (roster_position 36-40):
VESTA, NEPTUNE, LYRA, CYGNUS, ARIES
```

Same 40 words are reused across all 6 classes — safe, since the course-period prefix already guarantees global uniqueness (e.g. `G1-1-NOVA` and `S3-4-NOVA` are different students, never confused). **If a class's 5 reserve slots ever run out too**, this list needs more words or a numeric suffix (`NOVA01`/`NOVA02`) — not designed yet, since it wasn't needed for this first generation.

## Reserve Slots: Room for Transfers

Per Jay directly: some rows should "stay blank and be there for potential transfers or if something needs to be reassigned." Each class carries **5 extra `reserve` rows** (roster_position 36-40) beyond its 35 real seats — pre-generated with a real codename, course, period, and password, just like the active rows, but flagged `reserve` and left for Jay to activate (flip to `active`, fill in the student's name/email) the moment a transfer student actually arrives. This avoids re-running the whole generation scheme mid-year for one new student.

## Passwords: One Unique, Memorable Password Per Student

Per Jay directly: *"general passwords for them (perhaps some fruit and a number + special character; it should not be random and should be easy to remember)"* — then corrected the same day: *"The passwords should be unique for every student or at least have a bit more variation."* Final scheme: every one of the 240 rows gets its own distinct `{Fruit}{number}{symbol}` password (e.g. `Pineapple16!`, `Kumquat76@`), drawn from a 30-fruit list, a 2-97 number range, and 8 symbols (`! # $ % & * @ +`), generated with a fixed random seed so the run is reproducible if it ever needs regenerating. Still trivially memorable per student (three short, ordinary pieces), but no longer a single password shared across 35-40 people, and no longer a guessable sequential pattern (fruit and number both vary per student, not just an incrementing counter).

**Recommended pairing, not yet configured:** set Moodle's `forcepasswordchange` on every account created with its `initial_password`, so each student is prompted to set their own real password on first login. This keeps day-one onboarding painless (still just one simple string to type in) while the assigned password stops being a standing credential after each student's first session. Flagged here, not built — needs to happen wherever the actual Moodle user accounts get bulk-created.

## Open Items

**Updated 2026-08-31 — the two items below describing an unbuilt account-creation script are stale.** Real names/emails have been added for most seats, and `07-infrastructure/moodle-scripts/bulk-create-student-accounts.php` exists and has been run. See `07-infrastructure/onboarding-new-students.md` for the current process for filling a remaining unfilled seat or activating a reserve slot, and for the still-open `try`/`catch` gap in that script.

- Word-list exhaustion plan (a class needing more than 5 reserve slots) isn't designed.
- A handful of `active` seats still have no real student assigned (blank name/email) — see `07-infrastructure/onboarding-new-students.md`'s Case A for what to do when one gets filled.
