<?php
// One-off script: renames Unit 01's student-facing resources with a "01.N --"
// sequence prefix, hides the two now-superseded static resources (the old
// combined instructional page and the old static Check, both replaced by
// interactive equivalents), and reorders the section's module sequence to
// match. Teacher-only resources (deck, answer keys) are untouched.
// Safe to re-run: renaming/hiding/reordering are all idempotent given the
// same target state.
// Run: sudo -u www-data php sequence-unit01.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->libdir . '/modinfolib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2], '*', MUST_EXIST);

// cmid => new display name (01.N prefix), in the desired display order.
$sequence = [
    62 => '01.1 -- Solving Problems (Interactive)',
    48 => '01.2 -- Sequence the Five-Question Routine (Interactive)',
    63 => '01.3 -- Error Types (Interactive)',
    49 => '01.4 -- Sequence the Order of Operations Steps (Interactive)',
    50 => '01.5 -- Sequence a Real-World Problem (Interactive)',
    40 => '01.6 -- Guided Practice',
    64 => '01.7 -- Guided Practice: Classify the Error (Interactive)',
    41 => '01.8 -- Independent Practice',
    65 => '01.9 -- Independent Practice: Classify the Error (Interactive)',
    42 => '01.10 -- Quick Reference',
    61 => '01.11 -- Check (Interactive)',
];

// Superseded static resources: hide, don't delete.
$hide = [38, 39]; // old combined instructional page, old static check

// Rename.
foreach ($sequence as $cmid => $newname) {
    $cm = get_coursemodule_from_id('', $cmid, 0, false, MUST_EXIST);
    if ($cm->modname === 'resource') {
        $DB->set_field('resource', 'name', $newname, ['id' => $cm->instance]);
    } elseif ($cm->modname === 'h5pactivity') {
        $DB->set_field('h5pactivity', 'name', $newname, ['id' => $cm->instance]);
    }
    // Also update course_modules.name cache used by some renderers (Moodle keeps this in sync
    // via events normally; setting directly here since we're bypassing the edit form).
    rebuild_course_cache($course->id, true);
}

// Hide superseded resources.
foreach ($hide as $cmid) {
    set_coursemodule_visible($cmid, 0);
}

// Reorder: build the new sequence string, preserving every cmid already in the section
// (teacher-only + anything not explicitly listed) but placing the listed ones in order first.
$currentseq = explode(',', $section->sequence);
$ordered = array_keys($sequence);
$remaining = array_values(array_diff($currentseq, array_map('strval', $ordered)));
$newseq = array_merge($ordered, array_map('intval', $remaining));

$DB->set_field('course_sections', 'sequence', implode(',', $newseq), ['id' => $section->id]);
rebuild_course_cache($course->id, true);

echo "Renamed " . count($sequence) . " resources, hid " . count($hide) . ", reordered section.\n";
echo "New sequence: " . implode(',', $newseq) . "\n";
