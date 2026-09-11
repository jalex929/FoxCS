<?php
// One-off: 02.1 Mastery Check (cmid=269) was created via create_module(),
// which appends to the end of the section's sequence -- landed after the
// Checkpoint (268) instead of right after 02.1 Project (248), violating
// CLAUDE.md's Publishing Checklist item 4 (module order must match
// pedagogical sequence). Moves it to the correct position.
//
// Run: sudo -u www-data php reorder-unit02-section-2026-09-09.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 3], '*', MUST_EXIST);

echo "Before: {$section->sequence}\n";

$newsequence = '244,245,248,269,259,264,260,265,261,266,262,267,268';
$DB->set_field('course_sections', 'sequence', $newsequence, ['id' => $section->id]);

rebuild_course_cache($course->id, true);

$after = $DB->get_field('course_sections', 'sequence', ['id' => $section->id]);
echo "After:  {$after}\n";
