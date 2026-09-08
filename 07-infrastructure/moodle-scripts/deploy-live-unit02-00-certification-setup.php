<?php
// Deploys 02.0 Getting Ready for Certification to the LIVE foxcs-python
// course (section 3, "Unit 02: Variables & Data"), for real enrolled
// students. Due Tuesday, September 8, 2026, per Jay's direct instruction.
// Adapted from create-sandbox-unit02-00-certification-setup.php -- same
// content, live course/section, real due date via completionexpected
// (mod_resource has no native due-date field; completionexpected is the
// correct native mechanism -- shows in the student's Moodle calendar/timeline).

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

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$sectionnum = 3;
$sourcepath = '/tmp/foxcs-deploy-stage/02_00_instruction.html';

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'live-u02-00-cert-setup']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

$due = new DateTime('2026-09-08 15:30:00', new DateTimeZone('America/Chicago'));
$duets = $due->getTimestamp();

$fs = get_file_storage();
$usercontext = context_user::instance($USER->id);
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_string([
    'contextid' => $usercontext->id, 'component' => 'user', 'filearea' => 'draft',
    'itemid' => $draftitemid, 'filepath' => '/', 'filename' => 'index.html',
], '<html><body>placeholder</body></html>');

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '2.0 Getting Ready for Certification';
$moduleinfo->idnumber = 'live-u02-00-cert-setup';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
$moduleinfo->completionview = 0;
$moduleinfo->completionexpected = $duets;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created resource cmid={$cmid}\n";

$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = file_get_contents($sourcepath);
$html = str_replace('__CMID__', (string) $cmid, $html);

$fs->create_file_from_string([
    'contextid' => $modcontext->id, 'component' => 'mod_resource', 'filearea' => 'content',
    'itemid' => 0, 'filepath' => '/', 'filename' => 'index.html',
], $html);
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "LIVE: 2.0 deployed, cmid={$cmid}, due (completionexpected)=" . date('Y-m-d H:i:s T', $duets) . "\n";
