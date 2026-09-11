<?php
// create-sandbox-unit02-00-certification-setup.php
//
// Deploys Unit 02's new opening lesson (02.0 Getting Ready for Certification
// -- Certiport/GMetrix account setup) to the sandbox course, from the
// authored source at ../../courses/python/content/unit_02_variables_and_data/
// lesson_02_00_getting_ready_for_certification/01_instruction.html.
//
// Same two-phase pattern as create-sandbox-unit02-pilot-instruction.php: (1)
// create the module with a placeholder to get a real cmid, (2) upload the
// real page with __CMID__ baked in for the telemetry calls. No Skulpt/other
// bundled assets needed here (no runnable code on this page), unlike 02.1's
// script.
//
// Positioned with beforemod so it lands ahead of 02.1's existing Instruction
// module (cmid 238) in section 1, since 02.0 is the unit's opening step.
//
// Run: sudo -u www-data php create-sandbox-unit02-00-certification-setup.php

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
// Read from the /tmp staging copy, not the repo path directly: /home/jay is
// mode 0750 (jay:jay only), so www-data can't traverse into it. Stage with:
//   cp <repo path> /tmp/foxcs-deploy-stage/ && chmod 644 the copy
$sourcepath = '/tmp/foxcs-deploy-stage/01_instruction.html';

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-00-cert-setup']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

$beforecm = $DB->get_record('course_modules', ['course' => $course->id, 'id' => 238], '*', IGNORE_MISSING);
if (!$beforecm) {
    echo "Warning: expected 02.1 Instruction at cmid=238 not found -- will append at end of section instead.\n";
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
$moduleinfo->name = '2.0 Getting Ready for Certification (sandbox)';
$moduleinfo->idnumber = 'sandbox-u02-00-cert-setup';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
if ($beforecm) {
    $moduleinfo->beforemod = $beforecm->id;
}
// Manual completion: student clicks "I've created both accounts and
// submitted the form" once both real accounts exist and the credential form
// is submitted -- local_foxcstelemetry's log.php calls update_state()
// directly at that point, same mechanism as 02.1's practice completion.
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
