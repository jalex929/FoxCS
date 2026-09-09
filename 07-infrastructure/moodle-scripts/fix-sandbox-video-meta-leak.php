<?php
// fix-sandbox-video-meta-leak.php
//
// The 3 leftover sandbox copies of 2.2/2.3/2.4 Instruction (cmid 250, 251,
// 252 -- superseded by the live course's cmid 259/260/261, but still present
// and browsable in sandbox-adaptive-demo) still carried the same
// teacher-facing "Length: not yet independently confirmed -- check the
// video before your class watches it." line already fixed on the live
// copies 2026-09-09. Patches each sandbox copy's existing content in place
// (string replace only -- preserves its sandbox-prototype banner/title
// exactly as deployed) rather than re-pushing from repo source, since the
// repo source no longer carries the sandbox banner injection those copies
// need. Per Jay's standing rule that sandbox content should stay perfectly
// representative of what could go live.
//
// Run: sudo -u www-data php fix-sandbox-video-meta-leak.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$targets = [250, 251, 252];

$fs = get_file_storage();
foreach ($targets as $cmid) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid, 'course' => $course->id], '*', MUST_EXIST);
    $modcontext = context_module::instance($cmid);
    $file = $fs->get_file($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html');
    if (!$file) {
        fwrite(STDERR, "No index.html found for cmid={$cmid}\n");
        continue;
    }
    $html = $file->get_content();
    $newhtml = preg_replace(
        '/ Length: not yet independently confirmed -- check the video before your class watches it\./',
        '',
        $html,
        1,
        $count
    );
    if ($count === 0) {
        echo "cmid={$cmid}: no matching leak text found, left unchanged.\n";
        continue;
    }
    $file->delete();
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => 'index.html',
    ], $newhtml);
    echo "cmid={$cmid}: fixed ({$count} replacement).\n";
}

echo "Done.\n";
