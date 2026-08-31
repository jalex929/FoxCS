<?php
// Enrols an existing set of student accounts (by username) into a target
// course as Student. Does not create accounts -- use
// bulk-create-student-accounts.php for that. Idempotent (enrol_try_internal_enrol
// is safe to re-run).
//
// Run: sudo -u www-data php enrol-existing-students.php <target-course-shortname> <usernames-file>
// usernames-file: one username per line.

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/enrollib.php');

[, $shortname, $userfile] = $argv + [null, null, null];
if (!$shortname || !$userfile || !file_exists($userfile)) {
    fwrite(STDERR, "Usage: enrol-existing-students.php <target-course-shortname> <usernames-file>\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
$studentrole = $DB->get_record('role', ['shortname' => 'student'], '*', MUST_EXIST);

$usernames = array_filter(array_map('trim', file($userfile)));
$enrolled = 0;
$missing = 0;

foreach ($usernames as $username) {
    $user = $DB->get_record('user', ['username' => strtolower($username), 'deleted' => 0]);
    if (!$user) {
        echo "MISSING user: {$username}\n";
        $missing++;
        continue;
    }
    enrol_try_internal_enrol($course->id, $user->id, $studentrole->id);
    $enrolled++;
}

echo "\nDone. Enrolled/verified: {$enrolled}, missing accounts: {$missing}\n";
