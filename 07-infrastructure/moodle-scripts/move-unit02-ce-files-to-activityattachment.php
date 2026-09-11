<?php
// move-unit02-ce-files-to-activityattachment.php
//
// Follow-up fix: the previous pass moved these files to the 'intro'
// filearea to escape the dated "Additional files" block, but that broke
// direct downloads -- confirmed in Moodle's own source
// (public/mod/assign/lib.php's assign_pluginfile()) that mod_assign's
// pluginfile handler ONLY serves files from 'introattachment' or
// 'activityattachment', nothing else (404s everything else, including
// 'intro'). 'activityattachment' (public/mod/assign/locallib.php:78) has no
// dated listing UI of its own the way 'introattachment' does -- it's meant
// for files referenced directly from the intro/instructions text, not a
// formal "Additional files" attachment list. That's exactly this case.
//
// Run: sudo -u www-data php move-unit02-ce-files-to-activityattachment.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);

\core\cron::setup_user();

$files = [
    264 => 'GMETRIX-112-numbers.py',
    265 => 'GMETRIX-113-numbers.py',
    266 => 'GMETRIX-111-str.py',
    267 => 'GMETRIX-114-boolean.py',
];

$fs = get_file_storage();

foreach ($files as $cmid => $filename) {
    $modcontext = context_module::instance($cmid);

    $oldfile = $fs->get_file($modcontext->id, 'mod_assign', 'intro', 0, '/', $filename);
    if (!$oldfile) {
        fwrite(STDERR, "cmid={$cmid}: no 'intro' filearea file '{$filename}' found, skipping.\n");
        continue;
    }
    $content = $oldfile->get_content();

    $fs->delete_area_files($modcontext->id, 'mod_assign', 'intro', 0);

    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_assign',
        'filearea' => 'activityattachment',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], $content);

    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);
    $oldurl = moodle_url::make_pluginfile_url($modcontext->id, 'mod_assign', 'intro', 0, '/', $filename);
    $newurl = moodle_url::make_pluginfile_url($modcontext->id, 'mod_assign', 'activityattachment', 0, '/', $filename);
    $newintro = str_replace($oldurl->out(false), $newurl->out(false), $assign->intro);
    if ($newintro === $assign->intro) {
        fwrite(STDERR, "cmid={$cmid}: WARNING -- old URL not found in intro text, link not updated.\n");
    }
    $DB->set_field('assign', 'intro', $newintro, ['id' => $assign->id]);

    echo "cmid={$cmid}: moved {$filename} from intro -> activityattachment filearea, link updated.\n";
}

echo "Done.\n";
