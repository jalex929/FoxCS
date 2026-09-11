<?php
// create-sandbox-unit02-pilot-instruction.php
//
// Deploys the Unit 02 pilot lesson's (02.1 Variables and Memory) Instruction
// module to the sandbox course, from the authored source at
// ../../courses/python/content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html.
//
// Two-phase, same pattern as create-sandbox-completion-prototype.php: (1)
// create the module with a placeholder to get a real cmid, (2) upload the
// real page with __CMID__ baked in. The authored source's Skulpt <script>
// tags use repo-relative paths (../../../../../02-authoring-system/
// skulpt-runtime/...) since that's correct for viewing the file directly in
// the repo -- this script rewrites those to flat filenames before upload,
// since a mod_resource serves every uploaded file from one flat directory,
// and bundles skulpt.min.js/skulpt-stdlib.js alongside index.html to match.
//
// Run: sudo -u www-data php create-sandbox-unit02-pilot-instruction.php

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
$repo = dirname(__DIR__, 2); // FoxCS/
$sourcepath = $repo . '/courses/python/content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html';

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-pilot-instruction']);
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
$moduleinfo->name = '2.1 Variables and Memory: Instruction (sandbox pilot)';
$moduleinfo->idnumber = 'sandbox-u02-pilot-instruction';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
// Manual completion tracking: local_foxcstelemetry's log.php calls
// update_state() directly once all 4 skill nodes + both spiral items are done.
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
    'index.html' => null, // content is $html directly, not a path
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
