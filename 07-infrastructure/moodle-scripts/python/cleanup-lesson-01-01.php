<?php
// One-off cleanup for Lesson 01.1, 2026-08-30: removes the superseded pilot
// H5P activity (cmid 116, replaced by cmid 117's trimmed Instruction-only
// book) and hides the old 2026-08-04 MVP/Classroom-phase static resource
// links that now duplicate real Moodle-native content (the 01.1 instruction
// page and the two Project resource links, since a real mod_assign Project
// with a rubric is being built to replace them). Hidden, not deleted -- kept
// as a fallback reference, per the repo's general preference for reversible
// cleanup over destructive deletes.
// Run: sudo -u www-data php cleanup-lesson-01-01.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

// Delete the superseded pilot activity outright -- it's fully replaced by
// cmid 117, and leaving both live creates two competing "01.1 Instruction"
// surfaces for students.
course_delete_module(116);
echo "Deleted cmid 116 (pilot Interactive Book, superseded by 117)\n";

// Hide the old static resources that duplicate new native content.
foreach ([98, 92, 93] as $cmid) {
    set_coursemodule_visible($cmid, 0);
    rebuild_course_cache($DB->get_field('course_modules', 'course', ['id' => $cmid]), true);
    echo "Hid cmid {$cmid}\n";
}
