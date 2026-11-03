<?php
// find-school-network.php -- READ-ONLY. Suggests the school's network address
// range from Moodle's own logs, so the "Require network address" gate is set
// from evidence instead of guesswork.
//
// Looks at quiz attempt events from enrolled students in one course on
// weekdays during the school day (Chicago time), groups the addresses into
// /24 blocks, and keeps only blocks used by several different students (one
// student's home connection is not the school).
//
// Also prints the address Moodle last saw for a given account (--whoami), which
// is what test mode needs: add your own address to test from home.
//
// Run (stage first: www-data cannot read /home/jay, see README.md):
//   sudo -u www-data php /tmp/foxcs-deploy-stage/mastery-check-access/find-school-network.php \
//       --course=foxcs-python --days=30 --whoami=jay

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once(__DIR__ . '/mca_lib.php');

[$options] = cli_get_params(
    ['course' => 'foxcs-python', 'days' => 30, 'whoami' => '', 'min-users' => 3, 'coverage' => 0.9, 'help' => false],
    ['h' => 'help']
);
if ($options['help']) {
    echo "Options: --course=SHORTNAME --days=N --whoami=USERNAME --min-users=N --coverage=0..1\n";
    exit(0);
}

$course = $DB->get_record('course', ['shortname' => $options['course']], '*', MUST_EXIST);
$context = context_course::instance($course->id);
$students = get_enrolled_users($context, 'mod/quiz:attempt', 0, 'u.id', null, 0, 0, true);
$since = time() - ((int)$options['days'] * DAYSECS);

$events = ['\\mod_quiz\\event\\attempt_started', '\\mod_quiz\\event\\attempt_submitted',
           '\\mod_assign\\event\\assessable_submitted', '\\core\\event\\course_viewed'];
[$insql, $params] = $DB->get_in_or_equal($events, SQL_PARAMS_NAMED);
$params += ['courseid' => $course->id, 'since' => $since];
$rows = $DB->get_records_sql(
    "SELECT id, userid, ip, timecreated FROM {logstore_standard_log}
      WHERE courseid = :courseid AND timecreated >= :since AND eventname {$insql}",
    $params
);

$tz = new DateTimeZone('America/Chicago');
$obs = [];
foreach ($rows as $r) {
    if (!isset($students[$r->userid])) {
        continue;
    }
    $t = (new DateTime('@' . $r->timecreated))->setTimezone($tz);
    $dow = (int)$t->format('N');
    $hour = (int)$t->format('G');
    if ($dow <= 5 && $hour >= 7 && $hour < 16) {
        $obs[] = ['ip' => $r->ip, 'userid' => (int)$r->userid];
    }
}

echo "Course {$course->shortname}: " . count($obs) . " school-day student events in the last {$options['days']} days.\n\n";
$picked = mca_suggest_school_blocks($obs, (float)$options['coverage'], (int)$options['min-users']);
if (!$picked) {
    echo "No block was used by at least {$options['min-users']} students. Widen --days or lower --min-users.\n";
} else {
    printf("%-20s %8s %6s %7s\n", 'block', 'events', 'users', 'share');
    foreach ($picked as $p) {
        printf("%-20s %8d %6d %6.1f%%\n", $p['block'], $p['events'], $p['users'], 100 * $p['share']);
    }
    echo "\nSuggested --subnets=" . implode(',', array_column($picked, 'block')) . "\n";
    echo "Sanity-check this against what the school's IT says if you can: a district proxy can make many schools share addresses.\n";
}

if ($options['whoami'] !== '') {
    $u = $DB->get_record('user', ['username' => $options['whoami'], 'deleted' => 0], 'id, username, lastip, lastaccess');
    if (!$u) {
        echo "\n--whoami: no user '{$options['whoami']}'.\n";
    } else {
        $when = $u->lastaccess ? userdate($u->lastaccess) : 'never';
        echo "\nLast address Moodle saw for {$u->username}: {$u->lastip} (last access {$when}).\n";
        echo "Test mode: pass --test-ip={$u->lastip} to apply-mastery-check-access.php in the SANDBOX course.\n";
    }
}
