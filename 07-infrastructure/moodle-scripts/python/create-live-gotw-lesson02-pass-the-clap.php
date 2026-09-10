<?php
// Deploys Game of the Week Lesson 2: Pass the Clap to the LIVE foxcs-gotw
// course, as a mod_resource (the "new structure" -- local_foxcstelemetry-
// backed self-contained HTML, same pattern as foxcs-python's 02.1
// Instruction page), replacing the H5P.InteractiveBook approach used for
// Lesson 1. Per Jay's direct instruction 2026-09-10. Source:
// courses/python/game_of_the_week/week_02_pass_the_clap.html.
//
// Run: php create-live-gotw-lesson02-pass-the-clap.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-gotw'], '*', MUST_EXIST);
$sectionnum = 2;
course_create_sections_if_missing($course, $sectionnum);

$idnumber = 'live-gotw-lesson02';
$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => $idnumber]);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; skipping.\n";
    exit(0);
}

$sourcepath = '/tmp/foxcs-deploy-stage/courses/python/game_of_the_week/week_02_pass_the_clap.html';
if (!is_readable($sourcepath)) {
    fwrite(STDERR, "Missing staged source: {$sourcepath}\n");
    exit(1);
}

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
$moduleinfo->name = 'Lesson 2: Pass the Clap';
$moduleinfo->idnumber = $idnumber;
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
$moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
$moduleinfo->completionview = 0;
$moduleinfo->completionexpected = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = file_get_contents($sourcepath);
$html = str_replace('__CMID__', (string) $cmid, $html);
$fs->create_file_from_string([
    'contextid' => $modcontext->id, 'component' => 'mod_resource', 'filearea' => 'content',
    'itemid' => 0, 'filepath' => '/', 'filename' => 'index.html',
], $html);
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "Created cmid={$cmid} in section {$sectionnum}\n";
