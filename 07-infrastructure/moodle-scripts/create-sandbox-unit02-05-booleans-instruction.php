<?php
// create-sandbox-unit02-02-integers-instruction.php
//
// Deploys 02.2 Integers's Instruction module to the sandbox course, copied
// from create-sandbox-unit02-pilot-instruction.php's (02.1's) exact pattern.
// Source: ../../courses/python/content/unit_02_variables_and_data/lesson_02_05_booleans/01_instruction.html
//
// Run: sudo -u www-data php create-sandbox-unit02-02-integers-instruction.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$sectionnum = 1;
// /home/jay is mode 750, unreadable by www-data -- staged copy under /tmp
// (world-readable) used instead. See worklog.md's matching 2026-09-08 entry.
$repo = '/tmp/foxcs-deploy-stage';
$sourcepath = $repo . '/courses/python/content/unit_02_variables_and_data/lesson_02_05_booleans/01_instruction.html';

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-05-instruction']);
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
$moduleinfo->name = '2.5 Booleans: Instruction (sandbox)';
$moduleinfo->idnumber = 'sandbox-u02-05-instruction';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
$moduleinfo->completionview = 0;
$moduleinfo->completionexpected = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created resource cmid={$cmid}\n";

$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = file_get_contents($sourcepath);
$html = str_replace('__CMID__', (string) $cmid, $html);
$html = str_replace(
    '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt.min.js"></script>',
    '<script src="skulpt.min.js"></script>',
    $html
);
$html = str_replace(
    '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt-stdlib.js"></script>',
    '<script src="skulpt-stdlib.js"></script>',
    $html
);

$files = [
    'index.html' => null,
    'skulpt.min.js' => $repo . '/02-authoring-system/skulpt-runtime/skulpt.min.js',
    'skulpt-stdlib.js' => $repo . '/02-authoring-system/skulpt-runtime/skulpt-stdlib.js',
];
foreach ($files as $filename => $path) {
    $content = $filename === 'index.html' ? $html : file_get_contents($path);
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], $content);
}
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "Wrote real content, cmid={$cmid}. Visit as foxcstest to test.\n";
