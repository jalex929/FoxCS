# Mastery Check Access: automatic gates, no passwords

**Added 2026-11-03, per Jay.** Handing out Mastery Check passwords in person "was not sustainable," and passwords committed to this public repo were exposed anyway. The goal is a gate that is strong and enforces itself, designed for classroom facilitation. **Status: built and unit-tested here, not yet applied to any course.** Applying it is a live Moodle change, so it runs from a session on the droplet, following CLAUDE.md's backup-first rule.

## The design, and why each piece is there

| Gate | Moodle feature | What it does in class | Who has to act |
|---|---|---|---|
| **School network** | Quiz "Require network address" (`quiz.subnet`) | Attempts work from school computers and Wi-Fi, and are refused from home | Nobody. Works the same on a sub day |
| **Lesson prerequisites** | Activity-completion availability, shown to students | Quiz shows "Not available unless: *2.3 Floats: Instruction* is marked complete" until it is | Nobody. The student sees exactly what to do next |
| **No password** | Password field cleared, "ask your teacher" lines removed from the intro | No line at your desk. Leaked passwords become meaningless | Nobody |
| **Class-period backstop** (already exists) | `05-grader/check-submission-windows.py` | An attempt finished outside the student's period gets no credit | Runs at grading time |
| **3 attempts, averaged** (already exists) | Quiz settings | Rewards preparation over guessing | Nobody |

What this deliberately avoids:

- **Teacher-approval buttons.** Any gate that needs you to click brings back the bottleneck and blocks the class when you are out.
- **Safe Exam Browser.** It needs a client app on student devices. It was tried and turned off sitewide on 2026-09-01 because it never worked on the student machines.

Honest limits:

- **The prerequisite gate is a pacing nudge, not an integrity control.** Instruction pages use manual completion, which the telemetry plugin marks when the lesson is finished. A student can also click "Mark as done" themselves. The network gate and the bell-schedule backstop carry integrity.
- **The network gate cannot be lifted per student.** Moodle quiz overrides cover dates, time limits, attempts, and password, not the network rule. For a student who genuinely needs to test off-site (for example, homebound), see Exceptions below.
- **District proxies.** If many schools share one outbound address, the network gate is "any school in the district," not "this building." `find-school-network.php` shows what the logs actually contain. Confirm with school IT if you can.

## The scripts

| Script | Writes? | Purpose |
|---|---|---|
| `mca_lib.php` | No | All the decision logic, pure PHP. Unit-tested here with no Moodle |
| `find-school-network.php` | No | Suggests the school's address blocks from Moodle's own logs, and prints the address Moodle last saw for your account (`--whoami`) |
| `apply-mastery-check-access.php` | Only with `--apply` | Plans and applies the gates for every "... Mastery Check" quiz in a course. Dry run by default. Refuses to write without a fresh backup. Writes a rollback snapshot first. Re-running is a no-op |
| `mastery-check-readiness.php` | No | CSV for the teacher dashboard: per student per Mastery Check, locked or ready, which prerequisites are missing, attempts used, average, off-network attempts |
| `tests/test_mca_lib.php` | No | 75 checks. CI runs it on every change to this folder |

Safety built into `apply`:

- It refuses to set a prerequisite whose completion tracking is off, because that would lock every student out permanently.
- It keeps every availability condition already on the quiz.
- It rejects malformed or overly broad network entries, such as a single-number prefix that would allow millions of addresses.
- It never prints old passwords. The rollback file that stores them is written `chmod 600`.

## Staging (same as other scripts here)

`www-data` cannot read `/home/jay` (mode 750), so copy the folder first:

```bash
mkdir -p /tmp/foxcs-deploy-stage && cp -r ~/FoxCS/07-infrastructure/moodle-scripts/mastery-check-access /tmp/foxcs-deploy-stage/
cd /tmp/foxcs-deploy-stage/mastery-check-access
```

All commands below run as `sudo -u www-data php ...` from there.

## Step 1: find the school network (read-only, any time)

```bash
sudo -u www-data php find-school-network.php --course=foxcs-python --days=30 --whoami=jay
```

It prints suggested `--subnets=...` and your own current address for test mode.

## Step 2: test both directions from home, in the sandbox

The network rule applies to you too, so test mode adds your home address. Use the sandbox course (`sandbox-adaptive-demo`), never the live course. `/home/jay/moodle-backups/backup_moodle.sh` must run first.

```bash
# Allowed case: school + your home address. Expect the quiz to open for the test student from home.
sudo -u www-data php apply-mastery-check-access.php --course=sandbox-adaptive-demo \
    --subnets=SCHOOL_BLOCKS --test-ip=YOUR_HOME_IP --check-ip=YOUR_HOME_IP            # read the plan
sudo -u www-data php apply-mastery-check-access.php --course=sandbox-adaptive-demo \
    --subnets=SCHOOL_BLOCKS --test-ip=YOUR_HOME_IP --apply --i-ran-the-backup

# Blocked case: school only. Expect "only accessible from certain locations" from home.
sudo -u www-data php apply-mastery-check-access.php --course=sandbox-adaptive-demo \
    --subnets=SCHOOL_BLOCKS --apply --i-ran-the-backup
```

Check both as the `foxcstest` student, not as admin, since that is what students see. Also confirm the prerequisite message appears before the Instruction is complete and clears after. If the sandbox quiz's prerequisites aren't detected (its module names differ from the live pattern), the plan says so. Add `--no-prereqs` to test the network gate on its own.

To undo: `--rollback=/tmp/foxcs-mca-rollback-....json` (the path is printed on apply).

## Step 3: live

Pick a moment with no class in session (students are often live). Run the backup first, read the dry run, then:

```bash
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS --apply --i-ran-the-backup
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS   # expect "already up to date"
```

Then make one in-class check from a student account. Generate the readiness CSV for the dashboard:

```bash
sudo -u www-data php mastery-check-readiness.php --course=foxcs-python > /tmp/mc-readiness.csv
```

## Exceptions, planned ahead rather than handled on demand

- **Extra time, extra attempt, alternate dates:** native quiz user or group overrides (Quiz, Overrides). These work alongside the gates.
- **Make-up in a different period:** the network gate allows it, but the bell-schedule backstop would give no credit. **Known gap:** `check-submission-windows.py` has no exceptions list yet. Add an excused-attempts file before relying on this for make-ups.
- **Genuinely off-site student:** the network rule cannot be lifted per student. Duplicate that Mastery Check as a hidden copy restricted to that student (availability by user profile or group), with no network rule.

## New Mastery Checks

Build scripts should create new Mastery Checks with no password. Run `apply-mastery-check-access.php --only-cmid=NEW_CMID` after building, so each new quiz gets the same gates.
