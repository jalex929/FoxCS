<?php
// One-off: clears the auth_forcepasswordchange preference set on the first
// bulk-create-student-accounts.php run, per Jay's follow-up direct request
// that students keep their assigned roster password rather than being
// prompted to set their own on first login. Run once against every account
// created from the codename roster.
// Run: sudo -u www-data php clear-forcepasswordchange.php /path/to/accounts.csv

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$csvpath = $argv[1] ?? null;
if (!$csvpath || !file_exists($csvpath)) {
    fwrite(STDERR, "Usage: clear-forcepasswordchange.php /path/to/accounts.csv\n");
    exit(1);
}

$fh = fopen($csvpath, 'r');
fgetcsv($fh); // header
$cleared = 0;
while ($row = fgetcsv($fh)) {
    $codename = $row[0];
    $user = $DB->get_record('user', ['username' => strtolower($codename), 'deleted' => 0]);
    if ($user) {
        unset_user_preference('auth_forcepasswordchange', $user);
        $cleared++;
    }
}
fclose($fh);
echo "Cleared force-password-change on {$cleared} accounts\n";
