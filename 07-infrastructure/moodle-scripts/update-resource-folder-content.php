<?php
// Replaces an existing mod_resource's file content in place with a local
// folder tree (same multi-file approach as upload-folder-as-resource.php),
// instead of creating a new course module. Use when iterating on a resource
// that's already live (e.g. fixing a UI bug on a sandbox test page) so the
// same cmid/URL keeps working rather than accumulating a new module per fix.
// Run: php update-resource-folder-content.php <cmid> <local-folder> <entry-file-relative-path>

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

[, $cmid, $folder, $entryfile] = $argv + [null, null, null, null];
if (!$cmid || !$folder || !is_dir($folder) || !$entryfile) {
    fwrite(STDERR, "Usage: update-resource-folder-content.php <cmid> <local-folder> <entry-file-relative-path>\n");
    exit(1);
}

$cm = get_coursemodule_from_id('resource', (int) $cmid, 0, false, MUST_EXIST);
$modcontext = context_module::instance($cm->id);
$fs = get_file_storage();

function upload_tree_direct($fs, $contextid, $basepath, $relpath = '') {
    $full = rtrim($basepath, '/') . '/' . $relpath;
    foreach (scandir($full) as $entry) {
        if ($entry === '.' || $entry === '..') continue;
        $entryfull = $full . '/' . $entry;
        $entryrel = ltrim($relpath . '/' . $entry, '/');
        if (is_dir($entryfull)) {
            upload_tree_direct($fs, $contextid, $basepath, $entryrel);
        } else {
            $dir = dirname($entryrel);
            $filepath = ($dir === '.') ? '/' : '/' . $dir . '/';
            $fs->create_file_from_pathname([
                'contextid' => $contextid,
                'component' => 'mod_resource',
                'filearea' => 'content',
                'itemid' => 0,
                'filepath' => $filepath,
                'filename' => basename($entryrel),
            ], $entryfull);
        }
    }
}

$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);
upload_tree_direct($fs, $modcontext->id, $folder);

$entrydir = dirname($entryfile);
$entryfilepath = ($entrydir === '.') ? '/' : '/' . $entrydir . '/';
file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, $entryfilepath, basename($entryfile), 1);

echo "Updated cmid={$cmid}'s content from {$folder}, entry file: {$entryfile}\n";
