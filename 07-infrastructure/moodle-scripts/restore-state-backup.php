<?php
// restore-state-backup.php
//
// One-off recovery script: restores mdl_xapi_states.statedata from a backup
// dump taken via `mysql moodle --raw -e "SELECT u.username, s.itemid,
// s.statedata FROM ..."` (tab-separated, header row, real JSON in the last
// column). Used 2026-09-02 after confirming an H5P package swap reliably
// clears every existing student's saved resume state for that activity,
// even when done in place at the same cmid/context -- see the matching
// entry in 02-authoring-system/h5p-content-type-gotchas.md.
//
// Matches rows by username + itemid (the h5pactivity's context id) and
// UPDATEs (does not INSERT) an existing row's statedata -- if a row was
// deleted outright rather than nulled, this intentionally does nothing so a
// missing row doesn't silently get skipped.
//
// Run: sudo -u www-data php restore-state-backup.php /tmp/state-backup-file.txt

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$path = $argv[1] ?? null;
if (!$path || !file_exists($path)) {
    fwrite(STDERR, "Usage: restore-state-backup.php /path/to/backup.txt\n");
    exit(1);
}

$lines = file($path, FILE_IGNORE_NEW_LINES);
array_shift($lines); // header row

$restored = 0;
$missing = [];
foreach ($lines as $line) {
    [$username, $itemid, $statedata] = explode("\t", $line, 3);
    $user = $DB->get_record('user', ['username' => $username, 'deleted' => 0]);
    if (!$user) {
        $missing[] = "{$username} (no such user)";
        continue;
    }
    $existing = $DB->get_record('xapi_states', ['userid' => $user->id, 'itemid' => (int) $itemid]);
    if (!$existing) {
        $missing[] = "{$username}/{$itemid} (no existing row to update)";
        continue;
    }
    $DB->set_field('xapi_states', 'statedata', $statedata, ['id' => $existing->id]);
    $restored++;
    echo "restored {$username} itemid={$itemid} (row id={$existing->id})\n";
}

echo "Done. Restored {$restored}.\n";
if ($missing) {
    echo "Could not restore:\n" . implode("\n", $missing) . "\n";
}
