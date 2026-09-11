<?php
// Backfilled 2026-09-04: the "Skulpt Try-It (device test)" sandbox resource
// (cmid 237, sandbox-adaptive-demo) was originally pushed to Moodle directly
// without a committed build script -- this reconstructs it reproducibly from
// the runtime files already in the repo (02-authoring-system/skulpt-runtime/)
// and the page content backed up alongside this script
// (content-sandbox-skulpt-tryit.html), matching the pattern established by
// create-sandbox-completion-prototype.php.
//
// Multi-file resource: page HTML + skulpt.min.js + skulpt-stdlib.js served
// together so the page can load the runtime same-origin, no CDN.
//
// Run: php create-sandbox-skulpt-tryit.php

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

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-skulpt-tryit']);
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
$moduleinfo->visible = 1;
$moduleinfo->name = 'Skulpt Try-It (device test)';
$moduleinfo->idnumber = 'sandbox-skulpt-tryit';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_NONE;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$files = [
    'index.html' => $repo . '/07-infrastructure/moodle-scripts/content-sandbox-skulpt-tryit.html',
    'skulpt.min.js' => $repo . '/02-authoring-system/skulpt-runtime/skulpt.min.js',
    'skulpt-stdlib.js' => $repo . '/02-authoring-system/skulpt-runtime/skulpt-stdlib.js',
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

echo "Created cmid={$cmid}.\n";
