<?php
// update-live-unit02-video-meta-fix.php
//
// Re-pushes the corrected 01_instruction.html for 2.2/2.3/2.4 (cmid 259,
// 260, 261) onto the LIVE real course. Fixes a teacher-facing leak Jay
// flagged 2026-09-09: the video-meta line under each embedded video said
// "Length: not yet independently confirmed -- check the video before your
// class watches it," which is internal build-status language that should
// never have been visible to students. Fixed at the source
// (courses/python/content/unit_02_variables_and_data/lesson_02_0{2,3,4}_*/
// 01_instruction.html) by simply dropping the length clause entirely --
// don't state a length FoxCS hasn't confirmed, and don't leave a visible
// caveat about it either. 2.5 Booleans (cmid 262) already had a real,
// Jay-confirmed length and needed no change.
//
// Run: sudo -u www-data php update-live-unit02-video-meta-fix.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$stage = '/tmp/foxcs-deploy-stage';

$lessons = [
    259 => 'courses/python/content/unit_02_variables_and_data/lesson_02_02_integers/01_instruction.html',
    260 => 'courses/python/content/unit_02_variables_and_data/lesson_02_03_floats/01_instruction.html',
    261 => 'courses/python/content/unit_02_variables_and_data/lesson_02_04_strings/01_instruction.html',
];

foreach ($lessons as $cmid => $relpath) {
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

    $files = [
        'index.html' => null,
        'skulpt.min.js' => $stage . '/02-authoring-system/skulpt-runtime/skulpt.min.js',
        'skulpt-stdlib.js' => $stage . '/02-authoring-system/skulpt-runtime/skulpt-stdlib.js',
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
    echo "Updated cmid={$cmid} from {$relpath}\n";
}

echo "Done.\n";
