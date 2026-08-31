<?php
// Creates an h5pactivity module in any foxcs-% course, from a hand-built
// .h5p package (dependencies already installed server-side). Generalized
// 2026-08-30 from ../create-h5p-pilot.php so any lesson's H5P content --
// Instruction books, standalone activities like the drag-and-drop vocab
// quiz -- can be deployed the same way to any course, not just foxcs-python.
// Run: sudo -u www-data php create-h5p-instruction.php <course-shortname> <section-num> "<name>" /path/to/package.h5p

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

[, $shortname, $sectionnum, $name, $packagepath] = $argv + [null, null, null, null, null];
if (!$shortname || !$sectionnum || !$name || !$packagepath || !file_exists($packagepath)) {
    fwrite(STDERR, "Usage: create-h5p-instruction.php <course-shortname> <section-num> \"<name>\" /path/to/package.h5p\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
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
$moduleinfo->grade = 0;
$moduleinfo->displayoptions = 0;
$moduleinfo->enabletracking = 1;
$moduleinfo->grademethod = 1;
$moduleinfo->reviewmode = 1;

$result = create_module($moduleinfo);
echo "Created h5pactivity cmid={$result->coursemodule} instanceid={$result->id} in section {$sectionnum}: {$name}\n";
