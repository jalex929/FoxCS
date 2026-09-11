<?php
// One-off: enables the "Completion tracking" course setting on
// sandbox-adaptive-demo (course-level enablecompletion was off, even though
// it's on site-wide) -- required before any course module's own completion
// setting has any effect. Safe to re-run.
// Run: php enable-sandbox-completion.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);

if ($course->enablecompletion) {
    echo "Completion already enabled on {$course->shortname}.\n";
} else {
    $data = new stdClass();
    $data->id = $course->id;
    $data->enablecompletion = 1;
    update_course($data);
    echo "Enabled completion tracking on {$course->shortname}.\n";
}
