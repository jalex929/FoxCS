<?php
// One-off: installs local_foxcstelemetry's single DB table directly from its
// install.xml, and registers the plugin's version so Moodle's admin UI shows
// it as installed. Narrower than running the full admin/cli/upgrade.php site
// upgrade for what is, for now, one new table behind one prototype plugin.
// Safe to re-run (skips if the table already exists).
// Run: php install-foxcstelemetry-table.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$dbman = $DB->get_manager();
$xmlfile = $CFG->dirroot . '/local/foxcstelemetry/db/install.xml';

if (!file_exists($xmlfile)) {
    fwrite(STDERR, "Not found: {$xmlfile} -- deploy the plugin files first.\n");
    exit(1);
}

$xmldb_file = new xmldb_file($xmlfile);
if (!$xmldb_file->loadXMLStructure()) {
    fwrite(STDERR, "Failed to parse install.xml\n");
    exit(1);
}
$structure = $xmldb_file->getStructure();

foreach ($structure->getTables() as $table) {
    if ($dbman->table_exists($table)) {
        echo "Table {$table->getName()} already exists, skipping.\n";
        continue;
    }
    $dbman->create_table($table);
    echo "Created table {$table->getName()}.\n";
}

$plugin = new stdClass();
require($CFG->dirroot . '/local/foxcstelemetry/version.php');
set_config('version', $plugin->version, 'local_foxcstelemetry');
echo "Registered local_foxcstelemetry version {$plugin->version}.\n";
