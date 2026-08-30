<?php
// One-off setup script: creates a single "foxcstest" account enrolled as Student in
// every FoxCS course shell, so Jay can log in as that account to see exactly what a
// student sees across all four courses at once, without needing four separate logins.
// Dev-instance convenience only -- mirrors enrol-admin-as-teacher.php's pattern.
// Safe to re-run (skips creation if the user already exists; re-enrolment is idempotent).
// Run: sudo -u www-data php create-foxcs-test-student.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir . '/enrollib.php');

$username = 'foxcstest';
$password = 'FoxcsTest2026!';

$user = $DB->get_record('user', ['username' => $username, 'deleted' => 0]);

if (!$user) {
    $newuser = new stdClass();
    $newuser->username = $username;
    $newuser->password = $password;
    $newuser->firstname = 'FoxCS';
    $newuser->lastname = 'Test Student';
    $newuser->email = 'foxcstest@foxcs.online';
    $newuser->auth = 'manual';
    $newuser->confirmed = 1;
    $newuser->mnethostid = $CFG->mnet_localhost_id;
    $newuser->policyagreed = 1;

    $userid = user_create_user($newuser, true, false);
    echo "Created user '{$username}' (id {$userid})\n";
    $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
} else {
    echo "User '{$username}' already exists (id {$user->id})\n";
}

$studentrole = $DB->get_record('role', ['shortname' => 'student'], '*', MUST_EXIST);
$courses = $DB->get_records_select('course', "shortname LIKE 'foxcs-%'");

foreach ($courses as $course) {
    enrol_try_internal_enrol($course->id, $user->id, $studentrole->id);
    echo "Enrolled {$username} as Student in {$course->shortname}\n";
}

echo "\nLogin: username={$username}  password={$password}\n";
