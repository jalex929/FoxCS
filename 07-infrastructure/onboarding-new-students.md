# Onboarding a New or Transfer Student

**Added 2026-08-31**, after a full live-DB audit (see `worklog.md`'s 2026-08-31 entries) found the roster and Moodle had drifted out of sync for a handful of accounts. This documents the correct process going forward so a new student never gets an unusable login.

## The key fact: usernames and passwords are pre-generated, not created per-student

Every codename in the private roster (`06-data-and-spreadsheets/roster-schema.md`) already has a fixed username and `initial_password` assigned — generated once, up front, for all 240 slots across the 6 classes. Adding a real student to the roster **does not create a new identity**; it assigns an existing, already-generated codename/password pair to that student. This matters because it means two very different situations can both look like "add a student," depending on which kind of slot is being filled:

### Case A: Filling an unfilled `active` seat (Moodle account already exists)

Some `active` rows have no `first_name`/`last_name`/`student_email` yet (e.g. `G1-CERES`, `G1-ROVER` as of this writing) — these seats were already created as real Moodle accounts during the initial bulk rollout, just never assigned to a real student. To fill one:

1. Fill in `first_name`, `last_name`, `student_email` (and `guardian_email`/`school_student_id` if available) on that row in the roster spreadsheet.
2. **Verify the Moodle account's password actually matches `initial_password` on that row before handing it to the student.** Don't assume it does — the 2026-08-31 incident happened because passwords were regenerated in the spreadsheet after accounts were already created, and nothing re-pushed the change to Moodle. Check directly (see "How to verify" below); if it doesn't match, update it.
3. Confirm the account is enrolled in the right course (`06-data-and-spreadsheets/roster-schema.md`'s course-code table maps `class_period`/`course` to the Moodle course shortname). Don't assume enrollment happened correctly — one real gap found in the 2026-08-31 audit was a codename whose account existed but wasn't enrolled.

### Case B: Filling a `reserve` seat (transfer student, Moodle account does NOT exist yet)

Reserve rows (roster position 36-40 per class) have a codename and password already generated in the spreadsheet, but **no Moodle account has been created for them** — confirmed directly against the live DB 2026-08-31. To activate one:

1. Flip `active_status` from `reserve` to `active` and fill in the student's real name/email, same as Case A.
2. Run `moodle-scripts/bulk-create-student-accounts.php` (or the equivalent single-account path in `create-foxcs-test-student.php`) for that row — this creates the account with the roster's `initial_password` and enrolls it in one step, so there's no separate password-sync step needed here (the password is fresh at creation time, not drifted).
3. **Known gap:** that script has no `try`/`catch` around account creation/update — one bad row (e.g. a too-short password) can silently abort the rest of the batch, which is exactly what caused the 2026-08-31 incident. Not yet fixed. If re-running it for a batch of new students, watch its output carefully for where it stopped, don't assume it finished.

## How to verify a password/enrollment match before telling a student their login works

Never assume the spreadsheet and Moodle agree — verify directly against the live DB. From the droplet:

```
php -r '
define("CLI_SCRIPT", true);
require("/var/www/moodle/config.php");
$user = $DB->get_record("user", ["username" => strtolower($codename), "deleted" => 0]);
// validate_internal_user_password() checks the plaintext against the stored hash
var_dump(validate_internal_user_password($user, $initial_password_from_roster));
'
```

This is the same method used for the 2026-08-31 audit (see `worklog.md`) and the 2026-08-31 full-roster re-sweep. A one-off script is fine for this — don't guess from the spreadsheet alone, and don't assume a prior "fixed" note in `worklog.md` is still accurate without re-checking (the G21-ANDROMEDA account it once flagged as missing already existed by the time of the 2026-08-31 re-sweep, with no worklog update noting the fix — the log can lag reality).

## The `duplicate_email` column: a student in two class periods gets two codenames, but only one Moodle enrollment

A student who's genuinely enrolled in two FoxCS classes (e.g. Seminar III 4th period *and* Web II 7th period) gets **two separate codenames** in the roster, one per class, both pointing at the same real email in the `duplicate_email`/`courses_for_email` columns.

**Standing rule (established 2026-08-31, see `worklog.md`'s "Fixed 2026-08-31 (later still)" entry): a `duplicate_email` codename should NOT automatically be enrolled in its second course.** Jay's intent is one Moodle enrollment per student, under their actual/primary course — not a second enrollment under the Seminar III (or other) codename just because the row exists. A prior pass mistakenly enrolled two such accounts (`S4-CORONA`, `S4-ASTRO`) into `foxcs-seminar3` and had to reverse it. Confirm with Jay before enrolling any `duplicate_email`-flagged codename into a second course — don't treat "not enrolled" as a bug for these rows without checking first.
