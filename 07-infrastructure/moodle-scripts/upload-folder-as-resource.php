<?php
// Uploads an entire local folder tree (preserving subdirectory structure) as
// one Moodle File resource, so a multi-page self-navigating site (like the
// Unit 00 onboarding lessons, which link to each other via relative paths
// including sibling subfolders) keeps working once it's inside Moodle --
// unlike upload_python_lesson.php's flat single-directory upload, which
// can't represent a folder-of-folders. Written 2026-08-30 under time
// pressure to get Unit 00 live before the next class day.
// Run: sudo -u www-data php upload-folder-as-resource.php <course-shortname> <section-num> "<name>" <local-folder> <entry-file-relative-path>
// Example: sudo -u www-data php upload-folder-as-resource.php foxcs-python 1 "Unit 00: Course Onboarding" /tmp/unit00 unit_00_overview.html

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

[, $shortname, $sectionnum, $name, $folder, $entryfile] = $argv + [null, null, null, null, null, null];
if (!$shortname || !$sectionnum || !$name || !$folder || !is_dir($folder) || !$entryfile) {
    fwrite(STDERR, "Usage: upload-folder-as-resource.php <course-shortname> <section-num> \"<name>\" <local-folder> <entry-file-relative-path>\n");
    exit(1);
}

$course = $DB->get_record('course', ['shortname' => $shortname], '*', MUST_EXIST);
$usercontext = context_user::instance($USER->id);
$fs = get_file_storage();
$draftitemid = file_get_unused_draft_itemid();

function upload_tree($fs, $contextid, $itemid, $basepath, $relpath = '') {
    $full = rtrim($basepath, '/') . '/' . $relpath;
    foreach (scandir($full) as $entry) {
        if ($entry === '.' || $entry === '..') continue;
        $entryfull = $full . '/' . $entry;
        $entryrel = ltrim($relpath . '/' . $entry, '/');
        if (is_dir($entryfull)) {
            upload_tree($fs, $contextid, $itemid, $basepath, $entryrel);
        } else {
            $dir = dirname($entryrel);
            $filepath = ($dir === '.') ? '/' : '/' . $dir . '/';
            $fs->create_file_from_pathname([
                'contextid' => $contextid,
                'component' => 'user',
                'filearea' => 'draft',
                'itemid' => $itemid,
                'filepath' => $filepath,
                'filename' => basename($entryrel),
            ], $entryfull);
        }
    }
}

upload_tree($fs, $usercontext->id, $draftitemid, $folder);

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = (int) $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = $name;
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_AUTO;

$result = create_module($moduleinfo);

$modcontext = context_module::instance($result->coursemodule);
$entrydir = dirname($entryfile);
$entryfilepath = ($entrydir === '.') ? '/' : '/' . $entrydir . '/';
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, $entryfilepath, basename($entryfile), 1);

echo "Created resource cmid={$result->coursemodule} instanceid={$result->id} in {$shortname} section {$sectionnum}, entry file: {$entryfile}\n";
