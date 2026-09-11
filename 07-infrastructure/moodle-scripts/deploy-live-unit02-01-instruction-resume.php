<?php
// deploy-live-unit02-01-instruction-resume.php
//
// One-off: pushes the 2026-09-10 resume/progress-save rebuild of 02.1's
// Instruction page (cmid=245) live -- see decisions-log.md's matching entry.
// Same staged skulpt-src-rewrite pattern as update-live-unit02-due-date-banners.php,
// scoped to just this one cmid since it's the only Instruction page changed
// this pass (02.2-02.5 get the equivalent retrofit in a separate script).
//
// Run: sudo -u www-data php deploy-live-unit02-01-instruction-resume.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$stage = '/tmp/foxcs-deploy-stage';

$cmid = 245;
$relpath = 'courses/python/content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html';

$sourcepath = $stage . '/' . $relpath;
if (!is_readable($sourcepath)) {
    fwrite(STDERR, "Missing staged source: {$sourcepath}\n");
    exit(1);
}

$cm = $DB->get_record('course_modules', ['id' => $cmid, 'course' => $course->id], '*', MUST_EXIST);
$fs = get_file_storage();
$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = file_get_contents($sourcepath);
$html = str_replace('__CMID__', (string) $cmid, $html);
$html = str_replace(
    '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt.min.js"></script>',
    '<script src="skulpt.min.js"></script>',
    $html
);
$html = str_replace(
    '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt-stdlib.js"></script>',
    '<script src="skulpt-stdlib.js"></script>',
    $html
);

$files = ['index.html' => null];
if (strpos($html, 'skulpt.min.js') !== false) {
    $files['skulpt.min.js'] = $stage . '/02-authoring-system/skulpt-runtime/skulpt.min.js';
    $files['skulpt-stdlib.js'] = $stage . '/02-authoring-system/skulpt-runtime/skulpt-stdlib.js';
}
foreach ($files as $filename => $path) {
    $content = $filename === 'index.html' ? $html : file_get_contents($path);
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_resource',
        'filearea' => 'content',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], $content);
}
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);
echo "Updated cmid={$cmid} from {$relpath}\n";
