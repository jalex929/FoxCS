<?php
// One-off setup script: enrols the admin user as Teacher in all 4 FoxCS course
// shells, so they show up on the Dashboard and Jay can browse them with normal
// course navigation instead of only through Site Administration. Dev-instance
// convenience only -- real enrolment methods/rosters are a separate, later task.
// Safe to re-run (enrol_try_internal_enrol is idempotent).
// Run: sudo -u www-data php enrol-admin-as-teacher.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/enrollib.php');

$admin = $DB->get_record('user', ['username' => 'admin'], '*', MUST_EXIST);
$teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher'], '*', MUST_EXIST);

$courses = $DB->get_records_select('course', "shortname LIKE 'foxcs-%'");

foreach ($courses as $course) {
    enrol_try_internal_enrol($course->id, $admin->id, $teacherrole->id);
    echo "Enrolled admin as Teacher in {$course->shortname}\n";
}
