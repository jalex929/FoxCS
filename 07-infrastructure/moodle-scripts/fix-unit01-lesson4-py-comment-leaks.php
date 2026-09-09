<?php
// fix-unit01-lesson4-py-comment-leaks.php
//
// Two files in the live "01.4 Printing Output" resource bundle (cmid=101)
// had internal dev-history comments visible to students -- unlike HTML
// pages, a `#` comment in a .py file a student opens directly in VS Code is
// NOT stripped by any rendering layer, it's exactly what they see. Found by
// an audit agent 2026-09-09 ("mentions Jay by name," internal rename/fix
// history). Fixed at the source
// (courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/
// 06_application.py, 10_mastery_check.py) and re-pushed here onto just
// those two files in the live bundle, leaving the other ~10 files in the
// same resource untouched.
//
// Run: sudo -u www-data php fix-unit01-lesson4-py-comment-leaks.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
error_reporting(E_ALL);

\core\cron::setup_user();

$cmid = 101;
$stage = '/tmp/foxcs-deploy-stage';
$lessondir = $stage . '/courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output';

$files = [
    '06_application.py' => $lessondir . '/06_application.py',
    '10_mastery_check.py' => $lessondir . '/10_mastery_check.py',
];

$fs = get_file_storage();
$modcontext = context_module::instance($cmid);

foreach ($files as $filename => $sourcepath) {
    if (!is_readable($sourcepath)) {
        fwrite(STDERR, "Missing staged source: {$sourcepath}\n");
        exit(1);
    }
    $content = file_get_contents($sourcepath);

    $existing = $fs->get_file($modcontext->id, 'mod_resource', 'content', 0, '/', $filename);
    if ($existing) {
        $existing->delete();
    }
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], $content);
    echo "Replaced {$filename} in cmid={$cmid}\n";
}

echo "Done.\n";
