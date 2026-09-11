<?php
// One-off: attach GMETRIX-114-analyze.py to cmid=268 (Unit 02 Checkpoint),
// since build-unit02-checkpoint-coding-exercise.php's own attach step failed
// on a permission error (www-data can't traverse /home/jay, mode 750).
// Source copied to /tmp first, which is world-readable.
//
// Run: sudo -u www-data php attach-unit02-checkpoint-file.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$fs = get_file_storage();
$context = context_module::instance(268);
$sourcepath = '/tmp/GMETRIX-114-analyze.py';
$filerecord = [
    'contextid' => $context->id,
    'component' => 'mod_assign',
    'filearea'  => 'introattachment',
    'itemid'    => 0,
    'filepath'  => '/',
    'filename'  => 'GMETRIX-114-analyze.py',
];
if (!$fs->file_exists($filerecord['contextid'], $filerecord['component'], $filerecord['filearea'], $filerecord['itemid'], $filerecord['filepath'], $filerecord['filename'])) {
    $fs->create_file_from_pathname($filerecord, $sourcepath);
    echo "Attached GMETRIX-114-analyze.py to cmid=268.\n";
} else {
    echo "Already attached, skipped.\n";
}

rebuild_course_cache(2, true);
echo "Course cache rebuilt.\n";
