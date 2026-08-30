<?php
// Uploads one Python lesson folder as a single Moodle File resource, with
// 00_table_of_contents.html as the main/entry file. Sibling files (other
// numbered .html/.py files) go in the same file area, so the lesson's own
// existing relative-link nav menu resolves correctly inside Moodle.
//
// Run: sudo -u www-data php upload_python_lesson.php <local-folder> <unit-num> <name>
// Example: sudo -u www-data php upload_python_lesson.php /tmp/python-src/lesson_01_01_what_programs_do 1 "01.1 What Programs Do"

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

[, $folder, $unitnum, $name] = $argv + [null, null, null, null];
if (!$folder || !is_dir($folder) || !is_numeric($unitnum) || !$name) {
    fwrite(STDERR, "Usage: upload_python_lesson.php <local-folder> <unit-num> <name>\n");
    exit(1);
}

$sectionnum = ((int) $unitnum) + 1; // Section 1 = Unit 00, section 2 = Unit 01, etc.

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();

$draftitemid = file_get_unused_draft_itemid();
$mainfilename = null;
foreach (scandir($folder) as $filename) {
    if ($filename === '.' || $filename === '..') continue;
    $filepath = "$folder/$filename";
    if (!is_file($filepath)) continue;
    $fs->create_file_from_pathname([
        'contextid' => $usercontext->id,
        'component' => 'user',
        'filearea' => 'draft',
        'itemid' => $draftitemid,
        'filepath' => '/',
        'filename' => $filename,
    ], $filepath);
    if ($filename === '00_table_of_contents.html') {
        $mainfilename = $filename;
    }
}
if (!$mainfilename) {
    fwrite(STDERR, "No 00_table_of_contents.html found in $folder\n");
    exit(1);
}

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = $name;
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_AUTO;

$result = create_module($moduleinfo);

// Mark the table-of-contents file as the main/entry file among the several uploaded.
// (Moodle computes "mainfile" dynamically from whichever file has sortorder=1 --
// there's no stored mainfile column on mdl_resource.)
$modcontext = context_module::instance($result->coursemodule);
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', $mainfilename, 1);

echo "Created resource cmid={$result->coursemodule} instanceid={$result->id} in Unit {$unitnum} (section {$sectionnum}), main file: $mainfilename\n";
