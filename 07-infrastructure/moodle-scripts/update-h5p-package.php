<?php
// update-h5p-package.php
//
// Replaces an EXISTING h5pactivity's underlying .h5p package file IN PLACE
// (same cmid, same context), instead of the usual delete-and-recreate
// pattern. Deliberately used when a course module already has real student
// progress attached (mdl_xapi_states is keyed by context id) -- deleting and
// recreating the module would change the context id and silently orphan
// that saved progress. The old cached mdl_h5p content row (from the
// previous package) is left in place as harmless orphaned data; the next
// view reprocesses fresh from the new package.
//
// Run: sudo -u www-data php update-h5p-package.php <cmid> /path/to/package.h5p

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

[, $cmidArg, $packagepath] = $argv + [null, null, null];
$cmid = (int) $cmidArg;
if (!$cmid || !$packagepath || !file_exists($packagepath)) {
    fwrite(STDERR, "Usage: update-h5p-package.php <cmid> /path/to/package.h5p\n");
    exit(1);
}

$cm = get_coursemodule_from_id('h5pactivity', $cmid, 0, false, MUST_EXIST);
$context = context_module::instance($cmid);
$fs = get_file_storage();

// Remove the old package file(s).
$oldfiles = $fs->get_area_files($context->id, 'mod_h5pactivity', 'package', 0, 'itemid', false);
foreach ($oldfiles as $f) {
    $f->delete();
}

// Store the new one in the exact same place.
$fs->create_file_from_pathname([
    'contextid' => $context->id,
    'component' => 'mod_h5pactivity',
    'filearea' => 'package',
    'itemid' => 0,
    'filepath' => '/',
    'filename' => basename($packagepath),
], $packagepath);

echo "Replaced package for cmid={$cmid} (context {$context->id}) with " . basename($packagepath) . "\n";
