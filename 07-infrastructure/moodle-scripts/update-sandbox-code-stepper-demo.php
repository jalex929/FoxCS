<?php
// update-sandbox-code-stepper-demo.php
//
// Redeploys the 2026-09-10 full-capability rebuild of the standalone Code
// Execution Stepper demo (component-library #14 -- Restart, predict-before-
// step, second conditional demo program, Condition panel, flow badges,
// telemetry wiring) onto the existing sandbox mod_resource (cmid=275),
// which was still serving the pre-9/10 version. Targeted by cmid directly,
// not idnumber -- the 2026-09-09 session's sandbox-framing rewrite renamed
// this module to "Tracing a Loop, Step by Step" and its idnumber came back
// NULL when checked 2026-09-10, so 'sandbox-code-stepper-demo' no longer
// resolves; cmid=275 is confirmed directly against mdl_course_modules.
// Same delete-then-recreate content pattern as
// update-live-unit02-due-date-banners.php; no skulpt-src rewriting needed
// since this file is deliberately single-file self-contained (see
// decisions-log.md's 2026-09-10 entry).
//
// Run: php update-sandbox-code-stepper-demo.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$repo = '/tmp/foxcs-deploy-stage';
$sourcepath = $repo . '/02-authoring-system/component-library/code-stepper-demo.html';

$cmid = 275;
$cm = $DB->get_record('course_modules', ['id' => $cmid, 'course' => $course->id], '*', MUST_EXIST);

if (!is_readable($sourcepath)) {
    fwrite(STDERR, "Missing staged source: {$sourcepath}\n");
    exit(1);
}

$fs = get_file_storage();
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

echo "Updated cmid={$cmid} from {$sourcepath}\n";
