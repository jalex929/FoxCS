<?php
// Extends sequence-unit01.php's numbering (01.1-01.11, Days 1-2) with the
// Day 3-5 pieces built 2026-08-30: the ACT Math Baseline, its pre-baseline
// quick reference, the post-baseline reflection, and the Day 5 final
// reflection. Renames and appends to the section sequence; does not touch
// 01.1-01.11 or teacher-only resources. Safe to re-run.
// Run: sudo -u www-data php sequence-unit01-days3to5.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);

// cmid => new display name, in desired display order (appended after 01.11).
$sequence = [
    69 => '01.12 -- ACT Math Baseline Quick Reference',
    68 => '01.13 -- ACT Math Baseline',
    70 => '01.14 -- ACT Math Baseline Reflection',
    71 => '01.15 -- Reflection: Build Your Starting Strategy',
];

foreach ($sequence as $cmid => $newname) {
    $cm = get_coursemodule_from_id('', $cmid, 0, false, MUST_EXIST);
    if ($cm->modname === 'h5pactivity') {
        $DB->set_field('h5pactivity', 'name', $newname, ['id' => $cm->instance]);
    } elseif ($cm->modname === 'resource') {
        $DB->set_field('resource', 'name', $newname, ['id' => $cm->instance]);
    }
}

// Reorder: place these four right after the existing 01.1-01.11 block, before
// any teacher-only resources currently at the end of the sequence.
$teacheronly = [5, 37]; // Unit 01 Presentation (Teacher), Unit 01 Answer Keys (Teacher)
$currentseq = array_map('intval', explode(',', $section->sequence));
$newfour = array_keys($sequence);
$rest = array_values(array_diff($currentseq, $newfour));
// Split rest into non-teacher (keep first) and teacher-only (push to end).
$nonteacher = array_values(array_diff($rest, $teacheronly));
$teacheratend = array_values(array_intersect($rest, $teacheronly));
$newseq = array_merge($nonteacher, $newfour, $teacheratend);

$DB->set_field('course_sections', 'sequence', implode(',', $newseq), ['id' => $section->id]);
rebuild_course_cache($course->id, true);

echo "Renamed " . count($sequence) . " resources, reordered section.\n";
echo "New sequence: " . implode(',', $newseq) . "\n";
