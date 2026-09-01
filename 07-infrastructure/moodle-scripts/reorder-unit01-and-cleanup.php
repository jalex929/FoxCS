<?php
// reorder-unit01-and-cleanup.php
//
// Executes the standing Unit 01 section-ordering rule Jay confirmed this session:
// all sub-lessons (Instruction+Practice pairs) in order, then the unit Project (kept
// hidden until all lessons are assigned), then all Mastery Checks at the end, in
// lesson order. Also deletes the now-obsolete cmid=99 (01.2's old static MVP resource,
// superseded by the real native-Lesson build at cmid=194) -- confirmed zero real
// student activity first (5 log events, all admin/testing, verified separately).
//
// New sequence: 91 (Overview) -> 193 (01.1 Instruction) -> 188 (01.1 Practice) ->
// 194 (01.2 Instruction) -> 195 (01.2 Practice) -> 100,101,102,103 (01.3-01.6 old
// hidden placeholders, unbuilt) -> 92,93 (Project + starter, kept hidden) ->
// 114 (01.1 Mastery Check) -> 198 (01.2 Mastery Check).
//
// Run: sudo -u www-data php reorder-unit01-and-cleanup.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

// ---------------------------------------------------------------------------
// 1. Delete the obsolete cmid=99 resource.
// ---------------------------------------------------------------------------
course_delete_module(99);
echo "Deleted cmid=99 (old 01.2 MVP resource).\n";

// ---------------------------------------------------------------------------
// 2. Set the new section sequence.
// ---------------------------------------------------------------------------
$neworder = [91, 193, 188, 194, 195, 100, 101, 102, 103, 92, 93, 114, 198];
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
$section->sequence = implode(',', $neworder);
$DB->update_record('course_sections', $section);
echo "New sequence: {$section->sequence}\n";

rebuild_course_cache($course->id, true);
echo "Course cache rebuilt.\n";

echo "Done.\n";
