<?php
// rotate-daily-class-code.php -- keeps every Mastery Check's quiz password set
// to TODAY's class code. Meant for cron, every 10 minutes:
//
//   */10 * * * * www-data php /opt/foxcs/mastery-check-access/rotate-daily-class-code.php --courses=foxcs-python --notify >> /var/log/foxcs-class-code.log 2>&1
//
// (Install path: see README.md. Cron needs a copy www-data can read, not /home/jay.)
//
// What it does each run, per course:
//   1. Works out today's date in Chicago and today's code (mca_daily_code).
//   2. Sets the password on any "... Mastery Check" quiz that doesn't already
//      have today's code. Usually nothing, so it is cheap to run often, and a
//      missed run is fixed by the next one.
//   3. With --notify, once per day sends each editing teacher in the course a
//      Moodle notification with today's code (shows in the Moodle app and,
//      depending on their settings, email).
//
// Yesterday's code stops working on the first run after midnight Chicago time.
// A student already inside an attempt keeps going: Moodle only asks for the
// password when an attempt starts.
//
// Backups: this changes one field (quiz.password) on Mastery Checks only, on a
// schedule, so it relies on the nightly 3 AM backup rather than a manual
// backup per run. The first-time setup (apply-mastery-check-access.php) still
// follows the backup-first rule in CLAUDE.md.

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once(__DIR__ . '/mca_lib.php');

[$options] = cli_get_params([
    'courses' => 'foxcs-python', 'secret-file' => '/etc/foxcs/class-code.secret',
    'notify' => false, 'dry-run' => false, 'help' => false,
], ['h' => 'help']);
if ($options['help']) {
    echo "Options: --courses=a,b --secret-file=PATH --notify --dry-run\n";
    exit(0);
}

try {
    $secret = mca_load_secret($options['secret-file']);
} catch (RuntimeException $e) {
    cli_error($e->getMessage());
}

$now = time();
$today = mca_school_date($now);
$statefile = $CFG->dataroot . '/foxcs/class-code-state.json';
$state = is_readable($statefile) ? (json_decode(file_get_contents($statefile), true) ?: []) : [];
$stamp = date('c', $now);

foreach (array_filter(array_map('trim', explode(',', $options['courses']))) as $shortname) {
    $course = $DB->get_record('course', ['shortname' => $shortname]);
    if (!$course) {
        echo "{$stamp} {$shortname}: no such course, skipped\n";
        continue;
    }
    if (mca_fixed_code_allowed($shortname)) {
        echo "{$stamp} {$shortname}: sample course with the published demo code, skipped\n";
        continue;
    }
    $code = mca_daily_code($secret, $shortname, $today);

    $quizzes = [];
    foreach (get_fast_modinfo($course)->get_cms() as $cm) {
        if (mca_is_mastery_check(['modname' => $cm->modname, 'name' => $cm->name])) {
            $quizzes[] = $DB->get_record('quiz', ['id' => $cm->instance], 'id, password', MUST_EXIST);
        }
    }
    $targets = mca_rotation_targets(array_map(fn($q) => (array)$q, $quizzes), $code);

    if ($targets && !$options['dry-run']) {
        $tx = $DB->start_delegated_transaction();
        foreach ($targets as $quizid) {
            $DB->set_field('quiz', 'password', $code, ['id' => $quizid]);
        }
        $tx->allow_commit();
        rebuild_course_cache($course->id, true);
    }
    // Never log the code itself: logs are less protected than the secret.
    echo "{$stamp} {$shortname}: {$today}, " . count($quizzes) . " Mastery Check(s), "
        . count($targets) . ($options['dry-run'] ? ' would be' : '') . " updated\n";

    if ($options['notify'] && !$options['dry-run'] && mca_should_notify($state[$shortname] ?? null, $today)) {
        $role = $DB->get_record('role', ['shortname' => 'editingteacher'], 'id', MUST_EXIST);
        $teachers = get_role_users($role->id, context_course::instance($course->id), false, 'u.*');
        foreach ($teachers as $teacher) {
            $msg = new \core\message\message();
            $msg->component = 'moodle';
            $msg->name = 'instantmessage';
            $msg->notification = 1;
            $msg->courseid = $course->id;
            $msg->userfrom = core_user::get_noreply_user();
            $msg->userto = $teacher;
            $msg->subject = "{$course->shortname} class code for {$today}: {$code}";
            $msg->fullmessage = "Today's Mastery Check class code for {$course->fullname} is {$code}. "
                . "Post it in class. It stops working at midnight.";
            $msg->fullmessageformat = FORMAT_PLAIN;
            $msg->fullmessagehtml = '<p>' . s($msg->fullmessage) . '</p>';
            $msg->smallmessage = "Class code {$today}: {$code}";
            message_send($msg);
        }
        $state[$shortname] = $today;
        echo "{$stamp} {$shortname}: sent today's code to " . count($teachers) . " teacher(s)\n";
    }
}

if ($options['notify'] && !$options['dry-run']) {
    check_dir_exists(dirname($statefile));
    file_put_contents($statefile, json_encode($state));
}
