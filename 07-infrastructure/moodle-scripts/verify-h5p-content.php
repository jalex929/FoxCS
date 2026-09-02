<?php
// verify-h5p-content.php
//
// Forces Moodle's core_h5p framework to actually parse/validate a deployed
// h5pactivity's package (the same processing that normally only happens
// lazily on first student view) so a broken package can be caught from the
// CLI, without needing a live browser session. Read-only in intent, but
// note core_h5p may legitimately write its processed mdl_h5p cache row as a
// side effect -- that's normal, expected H5P behavior, not a mutation this
// script is making on purpose.
//
// Run: sudo -u www-data php verify-h5p-content.php <cmid>

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$cmid = (int)($argv[1] ?? 0);
if (!$cmid) {
    fwrite(STDERR, "Usage: verify-h5p-content.php <cmid>\n");
    exit(1);
}

$cm = get_coursemodule_from_id('h5pactivity', $cmid, 0, false, MUST_EXIST);
$context = context_module::instance($cmid);

$fs = get_file_storage();
$files = $fs->get_area_files($context->id, 'mod_h5pactivity', 'package', 0, 'itemid', false);
if (empty($files)) {
    echo "No package file found for cmid={$cmid}\n";
    exit(1);
}
$file = reset($files);
echo "Package file: {$file->get_filename()} ({$file->get_filesize()} bytes)\n";

$url = \moodle_url::make_pluginfile_url(
    $context->id, 'mod_h5pactivity', 'package', 0, '/', $file->get_filename()
);

$factory = new \core_h5p\factory();
$config = new stdClass();
$messages = new stdClass();
[$resultfile, $h5pid] = \core_h5p\api::create_content_from_pluginfile_url(
    (string)$url, $config, $factory, $messages, true, true
);

foreach (['error', 'exception', 'info'] as $type) {
    if (!empty($messages->$type)) {
        echo strtoupper($type) . " messages:\n";
        foreach ($messages->$type as $m) {
            echo " - " . (is_object($m) ? ($m->message ?? json_encode($m)) : $m) . "\n";
        }
    }
}

if (!$h5pid) {
    echo "FAILED to process content (no h5pid returned).\n";
    exit(1);
}

echo "OK: processed successfully, mdl_h5p id={$h5pid}\n";
