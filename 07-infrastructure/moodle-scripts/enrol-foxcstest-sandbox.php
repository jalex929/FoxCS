<?php
// One-off: enrols the existing foxcstest account (created by
// create-foxcs-test-student.php, which only covers 'foxcs-%' shortnames) into
// sandbox-adaptive-demo as well, so it can be used to test the
// local_foxcstelemetry prototype end to end. Idempotent.
// Run: php enrol-foxcstest-sandbox.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/enrollib.php');

$user = $DB->get_record('user', ['username' => 'foxcstest', 'deleted' => 0], '*', MUST_EXIST);
$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$studentrole = $DB->get_record('role', ['shortname' => 'student'], '*', MUST_EXIST);

enrol_try_internal_enrol($course->id, $user->id, $studentrole->id);
echo "Enrolled foxcstest as Student in {$course->shortname}.\n";
