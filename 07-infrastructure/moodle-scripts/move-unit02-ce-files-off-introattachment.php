<?php
// move-unit02-ce-files-off-introattachment.php
//
// Per Jay's direct feedback 2026-09-09: the native Moodle "Additional
// files" block (mod_assign's introattachment filearea) shows each file's
// upload/modified date next to it -- e.g. "9 September 2026, 8:06 AM" --
// which is meaningless/confusing to a student and not something we want
// posted. Confirmed in Moodle's own source
// (public/mod/assign/lang/en/assign.php: $string['introattachments'] =
// 'Additional files') that this block is tied specifically to files stored
// in the 'introattachment' filearea -- there's no setting to suppress just
// the date, the whole block is inherent to that filearea.
//
// Fix: move each starter .py file from filearea 'introattachment' to
// filearea 'intro' (the same file area the intro WYSIWYG editor's own
// embedded files use) so it's servable via a real pluginfile.php link
// inside the "Code File(s)" section without Moodle auto-rendering a
// separate dated "Additional files" listing for it. Re-points the
// Code File(s) link at the new location.
//
// Run: sudo -u www-data php move-unit02-ce-files-off-introattachment.php

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

    // Read the existing introattachment file's content before deleting it.
    $oldfile = $fs->get_file($modcontext->id, 'mod_assign', 'introattachment', 0, '/', $filename);
    if (!$oldfile) {
        fwrite(STDERR, "cmid={$cmid}: no introattachment file '{$filename}' found, skipping.\n");
        continue;
    }
    $content = $oldfile->get_content();

    // Remove every file in the introattachment area for this module (kills
    // the "Additional files" block entirely for this assignment).
    $fs->delete_area_files($modcontext->id, 'mod_assign', 'introattachment', 0);

    // Re-create the same file under the intro editor's own filearea instead.
    $fs->create_file_from_string([
        'contextid' => $modcontext->id,
        'component' => 'mod_assign',
        'filearea' => 'intro',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => $filename,
    ], $content);

    // Rewrite the Code File(s) link in the intro HTML to point at the new
    // location (same filename, different filearea).
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);
    $oldurl = moodle_url::make_pluginfile_url($modcontext->id, 'mod_assign', 'introattachment', 0, '/', $filename);
    $newurl = moodle_url::make_pluginfile_url($modcontext->id, 'mod_assign', 'intro', 0, '/', $filename);
    $newintro = str_replace($oldurl->out(false), $newurl->out(false), $assign->intro);
    if ($newintro === $assign->intro) {
        fwrite(STDERR, "cmid={$cmid}: WARNING -- old URL not found in intro text, link not updated.\n");
    }
    $DB->set_field('assign', 'intro', $newintro, ['id' => $assign->id]);

    echo "cmid={$cmid}: moved {$filename} from introattachment -> intro filearea, link updated.\n";
}

echo "Done.\n";
