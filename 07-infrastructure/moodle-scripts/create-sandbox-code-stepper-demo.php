<?php
// create-sandbox-code-stepper-demo.php
//
// Deploys the standalone Code Execution Stepper demo (component-library #14)
// to the sandbox course as a plain mod_resource, so it can be viewed live in
// Moodle instead of only opened locally. Generic fruit-list demo content,
// same as the component library -- not yet authored against 02.7's real
// content. Pattern copied from create-sandbox-unit02-*-instruction.php.
// Source: ../../02-authoring-system/component-library/code-stepper-demo.html
//
// Run: sudo -u www-data php create-sandbox-code-stepper-demo.php

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
// (world-readable) used instead. See worklog.md's 2026-09-08 entry.
$repo = '/tmp/foxcs-deploy-stage';
$sourcepath = $repo . '/02-authoring-system/component-library/code-stepper-demo.html';

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-code-stepper-demo']);
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
$moduleinfo->name = 'Code Execution Stepper (demo, component #14)';
$moduleinfo->idnumber = 'sandbox-code-stepper-demo';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_NONE;
$moduleinfo->completionview = 0;
$moduleinfo->completionexpected = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created resource cmid={$cmid}\n";

$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = file_get_contents($sourcepath);
$fs->create_file_from_string([
    'contextid' => $modcontext->id,
    'component' => 'mod_resource',
    'filearea' => 'content',
    'itemid' => 0,
    'filepath' => '/',
    'filename' => 'index.html',
], $html);
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "Wrote real content, cmid={$cmid}. Visit as foxcstest to test.\n";
