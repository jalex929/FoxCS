<?php
// Creates an h5pactivity Instruction module in foxcs-python, from a
// hand-built .h5p package (H5P.InteractiveBook + dependencies already
// installed server-side). Generalized 2026-08-30 from
// ../create-h5p-pilot.php so every lesson's trimmed Instruction-only book
// (see h5p_book_builder.py) can be deployed the same way, not just 01.1.
// Run: sudo -u www-data php create-h5p-instruction.php <section-num> "<name>" /path/to/package.h5p

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

[, $sectionnum, $name, $packagepath] = $argv + [null, null, null, null];
if (!$sectionnum || !$name || !$packagepath || !file_exists($packagepath)) {
    fwrite(STDERR, "Usage: create-h5p-instruction.php <section-num> \"<name>\" /path/to/package.h5p\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
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
