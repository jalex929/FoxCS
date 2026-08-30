<?php
// Creates an H5P activity in foxcs-seminar3 from a hand-built .h5p package (no
// bundled library code -- relies on the target content type already being
// installed server-side via the H5P Content Type Hub; see decisions-log.md,
// 2026-08-29 "H5P pilot" entry for how that was confirmed to work). This is
// the general-purpose version of create-h5p-pilot.php's one-off proof.
//
// Run: sudo -u www-data php create-h5p-activity.php <package.h5p> <unit-number> <name>
// Example: sudo -u www-data php create-h5p-activity.php /tmp/unit-01-check.h5p 1 "Unit 01 Check (Interactive)"

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

[, $packagepath, $unitnum, $name] = $argv + [null, null, null, null];
if (!$packagepath || !file_exists($packagepath) || !is_numeric($unitnum) || !$name) {
    fwrite(STDERR, "Usage: create-h5p-activity.php <package.h5p> <unit-number> <name>\n");
    exit(1);
}

$sectionnum = ((int) $unitnum) + 1; // Section 1 = Unit 00, section 2 = Unit 01, etc.

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
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
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = $name;
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->packagefile = $draftitemid;
$moduleinfo->grade = 100;
$moduleinfo->displayoptions = 0;
$moduleinfo->enabletracking = 1;
$moduleinfo->grademethod = 1;
$moduleinfo->reviewmode = 1;

$result = create_module($moduleinfo);
echo "Created h5pactivity cmid={$result->coursemodule} instanceid={$result->id} in Unit {$unitnum} (section {$sectionnum})\n";
