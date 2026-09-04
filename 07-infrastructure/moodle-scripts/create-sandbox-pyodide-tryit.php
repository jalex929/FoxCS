<?php
// Backfilled 2026-09-04: the "Pyodide Try-It (device test)" sandbox resource
// (cmid 236, sandbox-adaptive-demo -- hidden after a real live hang, see
// decisions-log.md's 2026-09-04 "Pyodide parked" entry) was originally
// pushed to Moodle directly without a committed build script -- this
// reconstructs it reproducibly from the runtime files already in the repo
// (02-authoring-system/pyodide-runtime/) and the page content backed up
// alongside this script (content-sandbox-pyodide-tryit.html).
//
// Kept for a possible properly-instrumented retest later, not deleted.
// Created hidden (visible=0) to match its parked, non-recommended status --
// unhide manually if actually retesting.
//
// Run: php create-sandbox-pyodide-tryit.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$sectionnum = 1;
$repo = dirname(__DIR__, 2); // FoxCS/

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-pyodide-tryit']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

$fs = get_file_storage();
$usercontext = context_user::instance($USER->id);
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_string([
    'contextid' => $usercontext->id,
    'component' => 'user',
    'filearea' => 'draft',
    'itemid' => $draftitemid,
    'filepath' => '/',
    'filename' => 'index.html',
], '<html><body>placeholder</body></html>');

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 0; // parked, not recommended -- see decisions-log.md
$moduleinfo->name = 'Pyodide Try-It (device test)';
$moduleinfo->idnumber = 'sandbox-pyodide-tryit';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_NONE;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$files = [
    'index.html' => $repo . '/07-infrastructure/moodle-scripts/content-sandbox-pyodide-tryit.html',
    'pyodide.js' => $repo . '/02-authoring-system/pyodide-runtime/pyodide.js',
    'pyodide.asm.mjs' => $repo . '/02-authoring-system/pyodide-runtime/pyodide.asm.mjs',
    'pyodide.asm.wasm' => $repo . '/02-authoring-system/pyodide-runtime/pyodide.asm.wasm',
    'pyodide-lock.json' => $repo . '/02-authoring-system/pyodide-runtime/pyodide-lock.json',
    'python_stdlib.zip' => $repo . '/02-authoring-system/pyodide-runtime/python_stdlib.zip',
];
foreach ($files as $filename => $path) {
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], file_get_contents($path));
}
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "Created cmid={$cmid} (hidden -- parked).\n";
