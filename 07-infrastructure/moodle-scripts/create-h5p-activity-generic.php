<?php
// Generic version of create-h5p-activity.php (which is hardcoded to
// foxcs-seminar3) -- creates an H5P activity in ANY course from a
// hand-built .h5p package, by course shortname + raw section number.
//
// Run: sudo -u www-data php create-h5p-activity-generic.php <course-shortname> <package.h5p> <sectionnum> "<name>"
// Example: sudo -u www-data php create-h5p-activity-generic.php foxcs-python /tmp/h5p-build/book.h5p 1 "Unit 0: Getting Started"

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

[, $shortname, $packagepath, $sectionnum, $name] = $argv + [null, null, null, null, null];
if (!$shortname || !$packagepath || !file_exists($packagepath) || !is_numeric($sectionnum) || !$name) {
    fwrite(STDERR, "Usage: create-h5p-activity-generic.php <course-shortname> <package.h5p> <sectionnum> \"<name>\"\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => (int) $sectionnum], '*', MUST_EXIST);
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
$moduleinfo->section = (int) $sectionnum;
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
echo "Created h5pactivity cmid={$result->coursemodule} instanceid={$result->id} in {$shortname} section {$sectionnum}\n";
