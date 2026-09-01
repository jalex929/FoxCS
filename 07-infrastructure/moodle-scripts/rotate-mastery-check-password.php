<?php
// rotate-mastery-check-password.php
//
// Cron-driven password rotation for Python 01.1 Mastery Check (quizid=2, cmid=114),
// per Jay's 2026-09-01 request: switch to the 8th-period code at noon (1st period has
// already tested by then), and pre-stage the *next school day's* 1st-period code at
// 6pm (so whoever opens Moodle first thing the next morning already has the right
// live password, with no early-morning manual/cron step needed).
//
// Design choice: does NOT rely on cron's own timezone. The droplet's system clock is
// UTC (verified 2026-08-31 -- this is the same class of bug just fixed for Moodle's
// site timezone, and Ubuntu's stock cron package here is 3.0pl1, which does not
// reliably support CRON_TZ). Instead, cron ticks this script every 5 minutes
// regardless of system TZ, and the script itself computes the current time in
// America/Chicago and only acts if it's actually within a rotation window. This is
// also DST-safe automatically (PHP's DateTimeZone handles the CDT/CST transition;
// nothing here needs updating when clocks change).
//
// Day-tier (which of the 3 codes to use) is computed from a weekday count since
// START_DATE, capped at index 2 -- Day 3+ is a permanent plateau for stragglers, not
// a literal single day, so this never needs daily manual edits while 01.1 stays the
// live Mastery Check. Weekends are skipped entirely (no rotation fires).
//
// When Practice/Mastery Check content moves to 01.2 (or another pathway's Mastery
// Check goes live), this script's CODES_1ST/CODES_8TH/START_DATE/quiz id need updating
// or this needs duplicating per-quiz -- this is scoped to 01.1 only, not a generic
// multi-quiz system.
//
// Run via cron every 5 minutes: */5 * * * * sudo -u www-data php rotate-mastery-check-password.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

const QUIZ_ID = 2; // 01.1 Mastery Check (cmid=114)
const START_DATE = '2026-09-01'; // first real testing day for 01.1

const CODES_1ST = ['Papaya42#', 'Coconut19@', 'Starfruit77!'];
const CODES_8TH = ['Dragonfruit35%', 'Passionfruit8$', 'Tangerine63&'];

function foxcs_weekdays_since(string $startdate, DateTime $asof): int {
    $start = new DateTime($startdate, new DateTimeZone('America/Chicago'));
    $start->setTime(0, 0, 0);
    $asofdate = new DateTime($asof->format('Y-m-d'), $asof->getTimezone());
    $count = 0;
    $cursor = clone $start;
    while ($cursor < $asofdate) {
        if ((int) $cursor->format('N') <= 5) {
            $count++;
        }
        $cursor->modify('+1 day');
    }
    return $count;
}

function foxcs_set_password(string $password, string $slot): void {
    global $DB;
    $DB->set_field('quiz', 'password', $password, ['id' => QUIZ_ID]);
    $DB->set_field('quizaccess_seb_quizsettings', 'quitpassword', $password, ['quizid' => QUIZ_ID]);
    echo (new DateTime('now', new DateTimeZone('America/Chicago')))->format('Y-m-d H:i:s')
        . " [{$slot}] password set to {$password}\n";
}

$tz = new DateTimeZone('America/Chicago');
$now = new DateTime('now', $tz);
$hm = $now->format('H:i');
$dow = (int) $now->format('N'); // 1=Mon .. 7=Sun

if ($dow > 5) {
    exit(0); // weekend, no rotation, silent no-op
}

if ($hm >= '12:00' && $hm <= '12:04') {
    $tier = min(foxcs_weekdays_since(START_DATE, $now), 2);
    foxcs_set_password(CODES_8TH[$tier], 'noon -> 8th period');
} elseif ($hm >= '18:00' && $hm <= '18:04') {
    $tomorrow = (clone $now)->modify('+1 day');
    $tier = min(foxcs_weekdays_since(START_DATE, $tomorrow), 2);
    foxcs_set_password(CODES_1ST[$tier], 'evening -> next day 1st period (pre-staged)');
}
// Outside both windows: silent no-op, nothing printed (keeps the log file to real events only).
