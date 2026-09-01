<?php
// enable-seb-mastery-check-01-01.php
//
// Enables Safe Exam Browser (quizaccess_seb) on 01.1 Mastery Check (cmid=114),
// per Jay's 2026-08-31 decision to run SEB and the quiz password together --
// not as alternatives. Password stays the readiness gate (controls WHEN a
// student starts); SEB is the integrity control (restricts WHAT they can do
// once inside the attempt).
//
// Mode: USE_SEB_CONFIG_MANUALLY (1) -- configure restrictions directly in
// Moodle rather than a template or an uploaded .seb file, since this is the
// first real SEB setup on this instance and there's nothing to template yet.
//
// Uses seb_quiz_settings (a real Moodle persistent class), not a raw SQL
// insert, specifically because it auto-computes the SEB config key hash on
// save (config_key::generate()) -- a raw insert would leave that unset/wrong
// and the SEB integrity check would fail for students.
//
// Restriction choices, mapped directly to Jay's stated integrity concerns:
//   - activateurlfiltering + filterembeddedcontent + expressionsallowed
//     limited to https://foxcs.online/* -- this is the actual technical
//     enforcement of "no unauthorized sources" during the attempt.
//   - allowcapturecamera/microphone = 0, allowspellchecking = 0,
//     allowreloadinexam = 0, showwificontrol = 0, showkeyboardlayout = 0:
//     reduce surface area for anything other than answering the quiz.
//   - quitpassword reuses the quiz's own password (T4WPR8) rather than a new
//     secret -- whoever already has the entry password can also authorize an
//     early exit; no separate password to track.
//   - userconfirmquit = 1: reduces accidental early exits.
//   - showsebdownloadlink = 1: students without SEB installed yet get a
//     direct link rather than a dead end.
//
// Does NOT touch the quiz password itself (still shared/global, T4WPR8) --
// per-student or per-day passwords are a separate, not-yet-built roster
// mechanism (see 06-data-and-spreadsheets/mastery-check-passwords-template.csv).
//
// Run: sudo -u www-data php enable-seb-mastery-check-01-01.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/mod/quiz/accessrule/seb/classes/seb_quiz_settings.php');

use quizaccess_seb\seb_quiz_settings;
use quizaccess_seb\settings_provider;

\core\cron::setup_user();

$cm = $DB->get_record('course_modules', ['id' => 114], '*', MUST_EXIST);
$quizid = $cm->instance;

$existing = $DB->get_record('quizaccess_seb_quizsettings', ['quizid' => $quizid]);
$settings = $existing
    ? new seb_quiz_settings($existing->id)
    : new seb_quiz_settings();

$settings->set('quizid', $quizid);
$settings->set('cmid', 114);
$settings->set('templateid', 0);
$settings->set('requiresafeexambrowser', settings_provider::USE_SEB_CONFIG_MANUALLY);
$settings->set('showsebtaskbar', 1);
$settings->set('showwificontrol', 0);
$settings->set('showreloadbutton', 0);
$settings->set('showtime', 1);
$settings->set('showkeyboardlayout', 0);
$settings->set('allowuserquitseb', 1);
$settings->set('quitpassword', 'T4WPR8');
$settings->set('linkquitseb', '');
$settings->set('userconfirmquit', 1);
$settings->set('enableaudiocontrol', 0);
$settings->set('muteonstartup', 1);
$settings->set('allowcapturecamera', 0);
$settings->set('allowcapturemicrophone', 0);
$settings->set('allowspellchecking', 0);
$settings->set('allowreloadinexam', 0);
$settings->set('activateurlfiltering', 1);
$settings->set('filterembeddedcontent', 1);
$settings->set('expressionsallowed', 'https://foxcs.online/*');
$settings->set('regexallowed', '');
$settings->set('expressionsblocked', '');
$settings->set('regexblocked', '');
$settings->set('showsebdownloadlink', 1);

if ($existing) {
    $settings->update();
    echo "Updated existing SEB settings for quizid={$quizid}\n";
} else {
    $settings->create();
    echo "Created SEB settings for quizid={$quizid}\n";
}

echo "Config key: " . $settings->get_config_key() . "\n";
echo "Done.\n";
