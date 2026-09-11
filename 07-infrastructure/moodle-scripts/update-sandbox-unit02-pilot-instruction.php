<?php
// update-sandbox-unit02-pilot-instruction.php
//
// Re-pushes the authored source at
// ../../courses/python/content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html
// onto the EXISTING sandbox Instruction resource (idnumber
// sandbox-u02-pilot-instruction), instead of create-sandbox-unit02-pilot-
// instruction.php's from-scratch build (which refuses to run once that
// idnumber already exists). Same content-rewrite rules as the create
// script: repo-relative Skulpt <script src> paths get flattened to bare
// filenames, since a mod_resource serves every uploaded file from one flat
// directory.
//
// Run: sudo -u www-data php update-sandbox-unit02-pilot-instruction.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$repo = dirname(__DIR__, 2); // FoxCS/
// /home/jay is 750 (owner/group jay only) so www-data can't read the repo
// checkout directly -- read from a world-readable staging copy instead.
// The skulpt runtime files under 02-authoring-system/ are also unreadable to
// www-data for the same reason, so those get staged here too.
$stage = '/tmp/foxcs-deploy-stage';
if (!is_dir($stage)) { mkdir($stage, 0755, true); }
$sourcepath = $stage . '/01_instruction.html';
if (!is_readable($sourcepath)) {
    fwrite(STDERR, "Missing staged source: {$sourcepath}\n");
    fwrite(STDERR, "Run as the repo owner first: cp {$repo}/courses/python/content/unit_02_variables_and_data/lesson_02_01_variables_and_memory/01_instruction.html {$sourcepath} && chmod 644 {$sourcepath}\n");
    exit(1);
}

// idnumber was never set when this resource was originally built (2026-09-04
// full-lesson pilot build) -- cmid 238 confirmed directly against
// mdl_course_modules for course id 9 (sandbox-adaptive-demo).
$cmid = 238;
$existing = $DB->get_record('course_modules', ['id' => $cmid, 'course' => $course->id], '*', MUST_EXIST);

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

$files = [
    'index.html' => null,
    'skulpt.min.js' => $stage . '/skulpt.min.js',
    'skulpt-stdlib.js' => $stage . '/skulpt-stdlib.js',
];
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

echo "Updated cmid={$cmid} from source.\n";
