<?php
// Updates an existing h5pactivity module in place: swaps its package file for
// a new one and (optionally) renames it. Written 2026-08-30 to replace Lesson
// 01.1's pilot package (cmid 116, the old 7-chapter bundled book) with the
// trimmed, architecture-correct Instruction-only book, without losing the
// module's existing cmid/gradebook link/completion history.
// Run: sudo -u www-data php update-h5p-activity.php <cmid> /path/to/package.h5p ["New Name"]

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$cmid = $argv[1] ?? null;
$packagepath = $argv[2] ?? null;
$newname = $argv[3] ?? null;
if (!$cmid || !$packagepath || !file_exists($packagepath)) {
    fwrite(STDERR, "Usage: update-h5p-activity.php <cmid> /path/to/package.h5p [\"New Name\"]\n");
    exit(1);
}

$cm = get_coursemodule_from_id('h5pactivity', $cmid, 0, false, MUST_EXIST);
$moduleinfo = clone $cm;
$moduleinfo->coursemodule = $cm->id;
$moduleinfo->course = $cm->course;
$moduleinfo->modulename = 'h5pactivity';
if ($newname) {
    $moduleinfo->name = $newname;
}

$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_pathname([
    'contextid' => $usercontext->id,
    'component' => 'user',
    'filearea' => 'draft',
    'itemid' => $draftitemid,
    'filepath' => '/',
    'filename' => basename($packagepath),
], $packagepath);
$moduleinfo->packagefile = $draftitemid;

$result = update_module($moduleinfo);
echo "Updated h5pactivity cmid={$result->coursemodule}\n";
