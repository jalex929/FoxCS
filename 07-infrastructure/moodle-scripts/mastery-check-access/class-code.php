<?php
// class-code.php -- prints today's class code, or the next N days of codes for
// sub plans. Read-only. Needs no Moodle database, only the secret file.
//
//   sudo -u www-data php class-code.php --course=foxcs-python            # today
//   sudo -u www-data php class-code.php --course=foxcs-python --days=10  # sub plans
//
// Codes are a pure function of the secret, the course, and the date, so these
// always match what rotate-daily-class-code.php writes into Moodle.

require_once(__DIR__ . '/mca_lib.php');

$opts = getopt('', ['course:', 'days::', 'from::', 'secret-file::']);
$course = $opts['course'] ?? 'foxcs-python';
$days = max(1, (int)($opts['days'] ?? 1));
$from = $opts['from'] ?? mca_school_date(time());
$secretfile = $opts['secret-file'] ?? '/etc/foxcs/class-code.secret';

try {
    $secret = mca_load_secret($secretfile);
    $rows = mca_code_calendar($secret, $course, $from, $days);
} catch (Throwable $e) {
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}

echo "Mastery Check class codes for {$course} (Chicago dates)\n";
foreach ($rows as $r) {
    printf("  %s  %-9s  %s\n", $r['date'], $r['weekday'], $r['code']);
}
