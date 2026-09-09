<?php
// One-off: 02.5 Mastery Check (cmid=273) appended to the end of the section
// via create_module(); moves it to sit right after 02.5 Coding Exercise
// (267), before the Unit 02 Mixed Data-Type Checkpoint (268), per CLAUDE.md's
// Publishing Checklist item 4.
//
// Run: sudo -u www-data php reorder-unit02-section-2026-09-09-e.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 3], '*', MUST_EXIST);

echo "Before: {$section->sequence}\n";

$newsequence = '244,245,248,269,259,264,270,260,265,271,261,266,272,262,267,273,268';
$DB->set_field('course_sections', 'sequence', $newsequence, ['id' => $section->id]);

rebuild_course_cache($course->id, true);

$after = $DB->get_field('course_sections', 'sequence', ['id' => $section->id]);
echo "After:  {$after}\n";
