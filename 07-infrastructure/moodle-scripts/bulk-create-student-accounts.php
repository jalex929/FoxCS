<?php
// Bulk-creates real Moodle student accounts from a codename-only CSV
// (codename,shortname,password), enrolls each into its course as Student,
// and forces a password change on first login. Written 2026-08-30 for the
// first real roster rollout -- generalizes create-foxcs-test-student.php's
// single-account pattern to 210 accounts across 4 courses. Deliberately
// takes no real student names: codename is the username, firstname/lastname
// are placeholder text, matching the codename-only account design in
// 01-privacy-and-governance/codename-policy.md. Safe to re-run (skips users
// that already exist, re-enrolment is idempotent).
// Run: sudo -u www-data php bulk-create-student-accounts.php /path/to/accounts.csv

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir . '/enrollib.php');

$csvpath = $argv[1] ?? null;
if (!$csvpath || !file_exists($csvpath)) {
    fwrite(STDERR, "Usage: bulk-create-student-accounts.php /path/to/accounts.csv\n");
    exit(1);
}

$studentrole = $DB->get_record('role', ['shortname' => 'student'], '*', MUST_EXIST);
$coursecache = [];

$fh = fopen($csvpath, 'r');
$header = fgetcsv($fh);
$created = 0;
$skipped = 0;
$enrolled = 0;

while ($row = fgetcsv($fh)) {
    [$codename, $shortname, $password] = $row;

    if (!isset($coursecache[$shortname])) {
        $coursecache[$shortname] = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
    }
    $course = $coursecache[$shortname];

    $user = $DB->get_record('user', ['username' => strtolower($codename), 'deleted' => 0]);

    if (!$user) {
        $newuser = new stdClass();
        $newuser->username = strtolower($codename);
        $newuser->password = $password;
        $newuser->firstname = $codename;
        $newuser->lastname = 'Student';
        $newuser->email = strtolower($codename) . '@foxcs.local';
        $newuser->auth = 'manual';
        $newuser->confirmed = 1;
        $newuser->mnethostid = $CFG->mnet_localhost_id;
        $newuser->policyagreed = 1;

        $userid = user_create_user($newuser, true, false);
        set_user_preference('auth_forcepasswordchange', 1, $userid);
        $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
        $created++;
        echo "Created {$codename} (id {$userid})\n";
    } else {
        // Update the password even for an existing account -- this script may be
        // re-run after fixing a bad password batch (e.g. one that violated
        // Moodle's minimum-length policy), and a stale password would silently
        // leave that student unable to log in with what's on the real roster.
        user_update_user((object) ['id' => $user->id, 'password' => $password], true, false);
        set_user_preference('auth_forcepasswordchange', 1, $user->id);
        $skipped++;
        echo "{$codename} already exists (id {$user->id}), password updated\n";
    }

    enrol_try_internal_enrol($course->id, $user->id, $studentrole->id);
    $enrolled++;
}

fclose($fh);
echo "\nDone. Created: {$created}, already existed: {$skipped}, enrolments processed: {$enrolled}\n";
