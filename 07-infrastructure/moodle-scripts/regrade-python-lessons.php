<?php
// regrade-python-lessons.php
//
// One-off: after switching Python's 01.1-01.3 Instruction + Practice mod_lesson
// activities to retake=1/usemaxgrade=1 (unlimited revisits, best-attempt grading --
// see worklog 2026-09-01), force Moodle to recompute each activity's gradebook
// values so we can confirm the switch didn't silently move anyone's existing grade
// (it shouldn't, since every student had exactly one attempt recorded at the time
// of the switch -- "average of 1" and "max of 1" are the same number).
//
// Run: sudo -u www-data php regrade-python-lessons.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/mod/lesson/locallib.php');

foreach ([1, 5, 6, 7, 9, 10] as $id) {
    $lesson = $DB->get_record('lesson', ['id' => $id], '*', MUST_EXIST);
    lesson_update_grades($lesson);
    echo "regraded lesson id={$id} ({$lesson->name})\n";
}
echo "Done.\n";
