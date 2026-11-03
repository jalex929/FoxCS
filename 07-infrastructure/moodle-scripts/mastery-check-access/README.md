# Mastery Check Access: a daily class code plus automatic gates

**Added 2026-11-03, per Jay.** With self-paced work, handing Mastery Check passwords to students one at a time as they asked "was not sustainable." The direction Jay chose is a **daily class code**: one code per course per day, posted once in class, which only works on the day it is for. Yesterday's code fails today. Around it sit gates that enforce themselves. **Status: built and unit-tested here, not yet applied to any course.** Applying it is a live Moodle change, so it runs from a session on the droplet, following CLAUDE.md's backup-first rule.

## Return-to-work checklist

Do these in order from a session on the droplet. Every write step has a dry run first. Nothing touches a real course until step 5.

1. `cd ~/FoxCS && git pull` (this folder lands on `main` with the merged PR).
2. **Server setup:** `sudo bash 07-infrastructure/moodle-scripts/mastery-check-access/setup-droplet.sh`, read it, then add `--apply`. This installs the scripts and creates the secret. It leaves cron off.
3. **Find the school network:** step 2 below.
4. **Sandbox test from home:** step 3 below. Check all four cases, including that yesterday's code fails.
5. **Turn on the daily rotation:** `sudo bash .../setup-droplet.sh --apply --enable-cron --courses=foxcs-python`.
6. **Go live in Python:** step 5 below, with no class in session, backup first.
7. **Tell Learners:** one line on the board the first day ("Mastery Checks now use today's class code, posted here each day"). Put `class-code.php --days=10` in the sub folder.

## The design, and why each piece is there

| Gate | How | What it does in class | Who has to act |
|---|---|---|---|
| **Daily class code** | Quiz password set to today's code by a scheduled job | Proves the student is in class today. Self-paced students take the check whatever day they're ready, using that day's code | You (or the sub) post one code per class. Nothing per student |
| **School network** | Quiz "Require network address" (`quiz.subnet`) | Refuses attempts from home | Nobody |
| **Lesson prerequisites** | Activity-completion availability, shown to students | Quiz says "Not available unless: *2.3 Floats: Instruction* is marked complete" | Nobody. Students see what's left |
| **Class-period backstop** (already exists) | `05-grader/check-submission-windows.py` | An attempt finished outside the student's period gets no credit | Runs at grading time |
| **3 attempts, averaged** (already exists) | Quiz settings | Rewards preparation over guessing | Nobody |

### How the daily code works

- **The code is computed, not chosen.** `code = HMAC-SHA256(secret, course | Chicago date)`, reduced to 6 digits. The secret lives only on the droplet (`/etc/foxcs/class-code.secret`), never in this repo. The scheduled job, your morning message, and a printed week of codes for sub plans all compute the same value, so nothing has to be stored or synced.
- **Yesterday's code fails today, guaranteed.** The last digit is the day number, mod 10. A code can never equal any code from the previous 9 days, regardless of the random part. The day changes at **midnight Chicago time**, not UTC.
- **Digits only.** That avoids capital-letter and O-versus-0 mistakes on Chromebooks.
- **Different per course.** A Python code doesn't open a Seminar III check.
- **Mid-attempt is safe.** Moodle asks for the code when an attempt starts, so a student already working isn't kicked out when the date changes.
- **Never logged.** Scripts print "(today's class code)", never the digits, except `class-code.php` and your Moodle notification, which exist to show it.

Honest limits:

- **The code can be shared.** A student could text today's code to a friend. That friend still needs to be at school (network gate), during their own period (backstop), with the lesson done (prerequisites). So a shared code is worth very little.
- **The prerequisite gate is a pacing nudge, not an integrity control.** Instruction uses manual completion, so a student can click "Mark as done" themselves.
- **The network gate can't be lifted per student.** Moodle overrides cover dates, time limits, attempts, and password, not the network rule. See Exceptions.
- **District proxies.** If many schools share one outbound address, the network gate means "any school in the district." `find-school-network.php` shows what the logs actually contain.

Deliberately avoided:

- **Per-student passwords and teacher-approval flows.** They scale with the number of students, which is the problem being solved.
- **Safe Exam Browser.** It needs a client install and was turned off sitewide on 2026-09-01.

## The scripts

| Script | Writes? | Purpose |
|---|---|---|
| `mca_lib.php` | No | All the decision logic, pure PHP, unit-tested here with no Moodle |
| `class-code.php` | No | Prints today's code, or `--days=10` for sub plans. Needs only the secret, no database |
| `rotate-daily-class-code.php` | Yes, one field | **Cron, every 10 minutes.** Sets each Mastery Check's password to today's code if it isn't already. With `--notify`, sends editing teachers a Moodle notification with the code once a day |
| `find-school-network.php` | No | Suggests the school's address blocks from Moodle logs, and shows your own address for test mode |
| `apply-mastery-check-access.php` | Only with `--apply` | One-time setup per course: prerequisites, network rule, today's code, and the intro line. Dry run by default, backup-gated, rollback snapshot, idempotent |
| `mastery-check-readiness.php` | No | CSV for the dashboard: locked or ready, missing prerequisites, attempts, averages, off-network attempts |
| `setup-droplet.sh` | Only with `--apply` | One-time server setup: install to `/opt/foxcs`, create the secret, optionally install cron |
| `tests/test_mca_lib.php`, `tests/test_setup_droplet.sh` | No | 111 logic checks plus an end-to-end setup test. CI runs both on every change to this folder |

## Setup on the droplet

Steps 0, 1 and 4 are what `setup-droplet.sh` does for you (dry run by default, `--apply` to write, `--enable-cron` for step 4). It never overwrites an existing secret, is safe to re-run, and is tested end to end in CI. The manual commands are kept below for reference.

### 0. Install a copy cron can read

`www-data` can't read `/home/jay` (mode 750):

```bash
sudo mkdir -p /opt/foxcs && sudo cp -r ~/FoxCS/07-infrastructure/moodle-scripts/mastery-check-access /opt/foxcs/
sudo chown -R root:www-data /opt/foxcs && sudo chmod -R o-rwx /opt/foxcs
cd /opt/foxcs/mastery-check-access
```

Re-copy after pulling changes to this folder.

### 1. Create the secret (once, ever)

```bash
sudo mkdir -p /etc/foxcs
openssl rand -base64 48 | sudo tee /etc/foxcs/class-code.secret > /dev/null
sudo chown root:www-data /etc/foxcs/class-code.secret && sudo chmod 640 /etc/foxcs/class-code.secret
```

Changing the secret changes every future code. Include it in your off-droplet backups if you ever set those up. The scripts refuse a secret file that everyone can read.

### 2. Find the school network (read-only)

```bash
sudo -u www-data php find-school-network.php --course=foxcs-python --days=30 --whoami=jay
```

### 3. Test from home, in the sandbox (`sandbox-adaptive-demo`)

Run `/home/jay/moodle-backups/backup_moodle.sh` first. Then:

```bash
sudo -u www-data php class-code.php --course=sandbox-adaptive-demo        # today's sandbox code

# Allowed case: school + your home address
sudo -u www-data php apply-mastery-check-access.php --course=sandbox-adaptive-demo \
    --subnets=SCHOOL_BLOCKS --test-ip=YOUR_HOME_IP --check-ip=YOUR_HOME_IP                 # read the plan
sudo -u www-data php apply-mastery-check-access.php --course=sandbox-adaptive-demo \
    --subnets=SCHOOL_BLOCKS --test-ip=YOUR_HOME_IP --apply --i-ran-the-backup
```

As the `foxcstest` student, from home, check each of these:

1. The quiz shows "enter today's class code" and the prerequisite message.
2. Today's code works.
3. A wrong code fails.
4. **Yesterday's code fails.** Get it with `class-code.php --course=sandbox-adaptive-demo --from=YESTERDAY_DATE`.

Then check the blocked case: re-run apply with `--subnets=SCHOOL_BLOCKS` only, and confirm that "only accessible from certain locations" appears from home.

To check the date rollover without waiting for midnight, run `rotate-daily-class-code.php --courses=sandbox-adaptive-demo --dry-run`. Undo anything with `--rollback=/tmp/foxcs-mca-rollback-....json` (the path is printed on apply).

If the sandbox quiz's prerequisites aren't detected (module names differ from the live pattern), the plan says so. Add `--no-prereqs` to test the other gates on their own.

### 4. Turn on the daily rotation

```bash
echo '*/10 * * * * www-data php /opt/foxcs/mastery-check-access/rotate-daily-class-code.php --courses=foxcs-python --notify >> /var/log/foxcs-class-code.log 2>&1' \
  | sudo tee /etc/cron.d/foxcs-class-code
sudo touch /var/log/foxcs-class-code.log && sudo chown www-data /var/log/foxcs-class-code.log
```

Add more courses comma-separated as they adopt it. `--notify` sends you the code once a day as a Moodle notification. It reaches the Moodle app and, depending on your notification settings, your email.

### 5. Live

Pick a time with no class in session. Back up first, then:

```bash
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS                    # read
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS --apply --i-ran-the-backup
sudo -u www-data php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL_BLOCKS                    # expect "already up to date"
```

## Daily routine

- **You:** post the code (it's in your morning notification, or run `class-code.php`). One line on the board.
- **Sub days:** put `class-code.php --days=10` output in your sub folder.
- **Readiness for pacing:** `mastery-check-readiness.php --course=foxcs-python > /tmp/mc-readiness.csv`

## Exceptions, planned ahead

- **Extra time, extra attempt, alternate dates:** native quiz user or group overrides (Quiz, Overrides).
- **Make-up in a different period:** the code and the network gate both allow it, but the bell-schedule backstop would give no credit. **Known gap:** `check-submission-windows.py` has no excused-attempts list yet.
- **Genuinely off-site student:** a hidden copy of that Mastery Check restricted to that student, with no network rule.

## New Mastery Checks

Build them with any password. Run `apply-mastery-check-access.php --only-cmid=NEW_CMID` once, and the cron job keeps the code current from then on.
