<?php
// One-off fix, 2026-09-09, per Jay: coding exercise submission instructions
// told students they could "either paste your code into the text box below,
// or upload your saved .py file, whichever matches how you wrote it" -- an
// unrestricted rich-text option Jay does not want for actual code submission
// (formatting/quote-mangling risk, and it's the same failure mode as the
// worksheet-format/no-answer-keys-in-student-docs class of "don't let a
// non-interactive/lossy surface carry graded work" rules already in place
// elsewhere in FoxCS). New standard, matching 2.1 Project's file-only
// pattern but adding back a real backup path: file upload (.py only) is
// primary, the online-text box is relabeled as a BACKUP LINK field only
// (e.g. a Google Drive share link), never for pasting code directly.
//
// Touches: 01.3/01.4/01.5/01.6 Coding Exercise (cmid 206/215/222/227) --
// restrict file uploads to .py, rewrite the "How to Submit" paragraph.
// 2.1 Project (cmid 248) -- re-enable the onlinetext plugin (was fully
// disabled) as a backup-link-only field, append the same backup-link
// sentence to its existing file-only instruction.
//
// Run: sudo -u www-data php fix_coding_exercise_submission_2026-09-09.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

global $DB;

$backup_line = 'If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.';

// --- 01.3-01.6 Coding Exercises: restrict file type, rewrite submit instructions ---
$coding_exercises = [
    206 => ['old' => 'Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.'],
    215 => ['old' => 'Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.'],
    222 => ['old' => 'Either paste your code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.'],
    227 => ['old' => 'Either paste your fixed code into the text box below, or upload your saved <code>.py</code> file, whichever matches how you wrote it.'],
];

foreach ($coding_exercises as $cmid => $info) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);

    $new_line = 'Upload your saved <code>.py</code> file below. ' . $backup_line;
    if (strpos($assign->intro, $info['old']) === false) {
        echo "WARNING cmid={$cmid}: expected 'How to Submit' line not found verbatim, skipping intro rewrite.\n";
    } else {
        $newintro = str_replace($info['old'], $new_line, $assign->intro);
        $DB->set_field('assign', 'intro', $newintro, ['id' => $assign->id]);
        echo "cmid={$cmid}: intro 'How to Submit' line rewritten.\n";
    }

    $DB->set_field('assign_plugin_config', 'value', '.py', [
        'assignment' => $assign->id, 'subtype' => 'assignsubmission', 'plugin' => 'file', 'name' => 'filetypeslist',
    ]);
    echo "cmid={$cmid}: file submission restricted to .py.\n";
}

// --- 2.1 Project: re-enable onlinetext as backup-link-only, update intro ---
$cm248 = $DB->get_record('course_modules', ['id' => 248], '*', MUST_EXIST);
$assign248 = $DB->get_record('assign', ['id' => $cm248->instance], '*', MUST_EXIST);

$exists = $DB->record_exists('assign_plugin_config', [
    'assignment' => $assign248->id, 'subtype' => 'assignsubmission', 'plugin' => 'onlinetext', 'name' => 'enabled',
]);
if ($exists) {
    $DB->set_field('assign_plugin_config', 'value', '1', [
        'assignment' => $assign248->id, 'subtype' => 'assignsubmission', 'plugin' => 'onlinetext', 'name' => 'enabled',
    ]);
} else {
    $DB->insert_record('assign_plugin_config', (object)[
        'assignment' => $assign248->id, 'subtype' => 'assignsubmission', 'plugin' => 'onlinetext', 'name' => 'enabled', 'value' => '1',
    ]);
}
echo "cmid=248: onlinetext submission re-enabled (backup-link-only).\n";

$old248 = 'Upload your saved <code>.py</code> file below. Pasted text is not accepted for this assignment.';
if (strpos($assign248->intro, $old248) === false) {
    echo "WARNING cmid=248: expected 'How to Submit' line not found verbatim, skipping intro rewrite.\n";
} else {
    $new248 = 'Upload your saved <code>.py</code> file below. ' . $backup_line;
    $newintro248 = str_replace($old248, $new248, $assign248->intro);
    $DB->set_field('assign', 'intro', $newintro248, ['id' => $assign248->id]);
    echo "cmid=248: intro 'How to Submit' line rewritten.\n";
}

rebuild_course_cache(2, true);
echo "Done. Course 2 cache rebuilt.\n";
