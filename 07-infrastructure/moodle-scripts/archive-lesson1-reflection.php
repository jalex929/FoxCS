<?php
// archive-lesson1-reflection.php
//
// Jay's follow-up decision, same 2026-09-09 session as rebuild-lesson1-reflection.php:
// rather than reconciling the 8-9 students who already completed the OLD H5P
// Lesson 1 Reflection against the NEW mod_feedback version (no honest way to
// carry free-text essay answers into a skill rating scale -- see session
// notes / decisions-log.md), just stop collecting Lesson 1 Reflection
// submissions entirely. Hides the NEW mod_feedback activity (id=7, cmid=274)
// the same way the OLD H5P one (id=33, cmid=83) was already archived --
// hidden and renamed, not deleted, so both generations' real student answers
// stay intact and recoverable in the live DB.
//
// Run: sudo -u www-data php archive-lesson1-reflection.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

$cmid = 274;
$feedbackid = 7;

set_coursemodule_visible($cmid, 0);
$DB->set_field('feedback', 'name', 'Lesson 1 Reflection (archived 2026-09-09, not collecting further submissions)', ['id' => $feedbackid]);

$course = $DB->get_field('course_modules', 'course', ['id' => $cmid]);
rebuild_course_cache($course, true);

echo "Archived: cmid={$cmid} hidden, feedback id={$feedbackid} renamed.\n";
