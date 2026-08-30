<?php
define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

[, $filepath, $unitnum, $name] = $argv + [null, null, null, null];
if (!$filepath || !file_exists($filepath) || !is_numeric($unitnum) || !$name) {
    fwrite(STDERR, "Usage: upload_single_file.php <local-file> <unit-num> <name>\n");
    exit(1);
}

$sectionnum = ((int) $unitnum) + 1;
$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();

$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_pathname([
    'contextid' => $usercontext->id, 'component' => 'user', 'filearea' => 'draft',
    'itemid' => $draftitemid, 'filepath' => '/', 'filename' => basename($filepath),
], $filepath);

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = $name;
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = 0;

$result = create_module($moduleinfo);
echo "Created cmid={$result->coursemodule}\n";
