<?php
// reorder-unit01-no-mixing.php
//
// Corrects the Unit 01 section order per Jay's explicit 2026-09-01 correction:
// "all 1.1 content should exist in the specified order, then all 1.2 content, then
// all 1.3... there should not be any mixing of 1.1 1.2 etc like we see with the two
// mastery checks being together near the end." This REPLACES the earlier "bundle all
// Mastery Checks together after Project" interpretation -- each lesson's Mastery
// Check now sits directly after that lesson's own Practice, not clustered separately.
// Project still comes after all sub-lessons are complete, per the original standing
// rule (unaffected by this correction, which was specifically about lesson-number
// mixing).
//
// Also, per the same request:
//   - Deletes cmid=100, the old MVP placeholder for 01.3 (confirmed zero real student
//     activity), now superseded by the real build (cmid 203/204).
//   - Hides 01.4/01.5/01.6 (cmid 101/102/103, still old unbuilt MVP placeholders --
//     not ready to share yet) and the Project (cmid 92/93, per the standing rule that
//     it stays hidden until all lessons in the unit are assigned).
//
// New order: 91 (Overview) -> 193 (1.1 Inst) -> 188 (1.1 Practice) -> 114 (1.1 MC) ->
// 194 (1.2 Inst) -> 195 (1.2 Practice) -> 198 (1.2 MC) -> 203 (1.3 Inst) ->
// 204 (1.3 Practice) -> 101 (1.4, hidden) -> 102 (1.5, hidden) -> 103 (1.6, hidden) ->
// 92 (Project, hidden) -> 93 (Project starter, hidden)
//
// Run: sudo -u www-data php reorder-unit01-no-mixing.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 2;

// 1. Delete the obsolete 01.3 placeholder.
course_delete_module(100);
echo "Deleted cmid=100 (old 01.3 MVP placeholder).\n";

// 2. Hide 01.4/01.5/01.6 placeholders and the Project.
foreach ([101, 102, 103, 92, 93] as $cmid) {
    $DB->set_field('course_modules', 'visible', 0, ['id' => $cmid]);
    echo "Hid cmid={$cmid}\n";
}

// 3. New section sequence, no cross-lesson mixing.
$neworder = [91, 193, 188, 114, 194, 195, 198, 203, 204, 101, 102, 103, 92, 93];
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
$section->sequence = implode(',', $neworder);
$DB->update_record('course_sections', $section);
echo "New sequence: {$section->sequence}\n";

rebuild_course_cache($course->id, true);
echo "Done.\n";
