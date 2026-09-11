<?php
// One-off: 02.3 Mastery Check (cmid=271) appended to the end of the section
// via create_module(); moves it to sit right after 02.3 Coding Exercise
// (265), before 02.4 Instruction (261), per CLAUDE.md's Publishing Checklist
// item 4.
//
// Run: sudo -u www-data php reorder-unit02-section-2026-09-09-c.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 3], '*', MUST_EXIST);

echo "Before: {$section->sequence}\n";

$newsequence = '244,245,248,269,259,264,270,260,265,271,261,266,262,267,268';
$DB->set_field('course_sections', 'sequence', $newsequence, ['id' => $section->id]);

rebuild_course_cache($course->id, true);

$after = $DB->get_field('course_sections', 'sequence', ['id' => $section->id]);
echo "After:  {$after}\n";
