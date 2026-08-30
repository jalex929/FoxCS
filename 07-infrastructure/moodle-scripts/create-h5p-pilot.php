<?php
// Pilot script: creates a single H5P.MultiChoice activity in Unit 01 (section 2)
// of foxcs-seminar3, from a hand-built .h5p package (no bundled library code --
// relies on H5P.MultiChoice already being installed server-side via the H5P
// Content Type Hub, see decisions-log.md 2026-08-29). Proof-of-concept before
// building the full 10-question Unit 01 Check as H5P.
// Run: sudo -u www-data php create-h5p-pilot.php /path/to/package.h5p

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

$packagepath = $argv[1] ?? null;
if (!$packagepath || !file_exists($packagepath)) {
    fwrite(STDERR, "Usage: create-h5p-pilot.php /path/to/package.h5p\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
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

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'h5pactivity';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'h5pactivity']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2; // Unit 01
$moduleinfo->visible = 1;
$moduleinfo->name = 'Unit 01 Check Q1 (H5P pilot)';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->packagefile = $draftitemid;
$moduleinfo->grade = 0;
$moduleinfo->displayoptions = 0;
$moduleinfo->enabletracking = 1;
$moduleinfo->grademethod = 1;
$moduleinfo->reviewmode = 1;

$result = create_module($moduleinfo);
echo "Created h5pactivity cmid={$result->coursemodule} instanceid={$result->id}\n";
