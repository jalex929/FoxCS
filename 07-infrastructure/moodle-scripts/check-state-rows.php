<?php
// check-state-rows.php -- one-off diagnostic, reads via Moodle's own DB
// layer (not raw mysql client) to rule out a client-side reading artifact
// while investigating an unexplained xapi_states null. Read-only.
// Run: sudo -u www-data php check-state-rows.php <id> [<id> ...]

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$ids = array_slice($argv, 1);
foreach ($ids as $id) {
    $r = $DB->get_record('xapi_states', ['id' => (int)$id]);
    if (!$r) {
        echo "{$id}: no such row\n";
        continue;
    }
    echo "{$id}: userid={$r->userid} itemid={$r->itemid} timemodified={$r->timemodified} statedata=" . var_export($r->statedata, true) . "\n";
}
