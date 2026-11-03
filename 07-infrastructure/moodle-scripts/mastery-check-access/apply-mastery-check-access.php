<?php
// apply-mastery-check-access.php -- one-time setup of the automatic Mastery
// Check gates: lesson prerequisites + school network + daily class code.
// DRY RUN by default.
//
// For every quiz named "... Mastery Check" in the course:
//   - prerequisites: requires that lesson's Instruction (and Coding Exercise,
//     where there is one) to be complete. Shown to students, never hidden.
//     Refuses any prerequisite with completion tracking off, since that would
//     lock everyone out.
//   - network: sets "Require network address" to --subnets (plus --test-ip).
//   - class code: password set to today's class code, and the intro's old
//     "ask your teacher for the password" sentences replaced with one line
//     saying to enter today's class code, posted in class. From then on
//     rotate-daily-class-code.php (cron) keeps the code current.
//     (--no-class-code to leave the password and intro alone.)
// Existing availability conditions are kept. Re-running is a no-op.
//
// Safety:
//   - Prints the full plan and changes nothing unless --apply is passed.
//   - --apply refuses unless backup.log is under an hour old (CLAUDE.md
//     "Data Safety"), or you pass --i-ran-the-backup.
//   - --apply writes a rollback snapshot first; --rollback=FILE restores it.
//
// Typical use (stage first, see README.md):
//   # 1. Test from home in the sandbox: allowed, then blocked
//   php apply-mastery-check-access.php --course=foxcs-sandbox --subnets=SCHOOL --test-ip=HOME --apply
//   php apply-mastery-check-access.php --course=foxcs-sandbox --subnets=SCHOOL --apply
//   # 2. Live
//   php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL            # read the plan
//   php apply-mastery-check-access.php --course=foxcs-python --subnets=SCHOOL --apply

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once(__DIR__ . '/mca_lib.php');

[$options] = cli_get_params([
    'course' => '', 'subnets' => '', 'test-ip' => '', 'check-ip' => '', 'only-cmid' => 0,
    'no-prereqs' => false, 'no-network' => false, 'no-class-code' => false,
    'secret-file' => '/etc/foxcs/class-code.secret',
    'apply' => false, 'i-ran-the-backup' => false,
    'backup-log' => '/home/jay/moodle-backups/backup.log',
    'snapshot-dir' => '/tmp', 'rollback' => '', 'help' => false,
], ['h' => 'help']);

if ($options['help'] || ($options['course'] === '' && $options['rollback'] === '')) {
    echo "Required: --course=SHORTNAME. See the header of this file for options.\n";
    exit($options['help'] ? 0 : 1);
}

function mca_require_backup(array $options): void {
    if ($options['i-ran-the-backup']) {
        return;
    }
    $mtime = @filemtime($options['backup-log']);
    if (!mca_backup_is_recent($mtime === false ? null : $mtime, time())) {
        cli_error("Refusing to write: {$options['backup-log']} is missing, unreadable, or over an hour old.\n"
            . "Run /home/jay/moodle-backups/backup_moodle.sh, confirm it finished, then re-run with --i-ran-the-backup.");
    }
}

// ------------------------------------------------------------ rollback
if ($options['rollback'] !== '') {
    mca_require_backup($options);
    $snap = json_decode(file_get_contents($options['rollback']), true);
    if (!is_array($snap) || !isset($snap['courseid'], $snap['items'])) {
        cli_error('Not a rollback snapshot: ' . $options['rollback']);
    }
    foreach ($snap['items'] as $item) {
        $DB->update_record('quiz', (object)(['id' => $item['quizid']] + $item['quiz']));
        $DB->set_field('course_modules', 'availability', $item['availability'], ['id' => $item['cmid']]);
        echo "Restored cmid {$item['cmid']} ({$item['name']}).\n";
    }
    rebuild_course_cache($snap['courseid'], true);
    echo "Rollback complete.\n";
    exit(0);
}

// ------------------------------------------------------------ plan
$subnets = null;
if (!$options['no-network']) {
    [$subnets, $errors] = mca_normalize_subnets(trim($options['subnets'] . ',' . $options['test-ip'], ','));
    if ($errors) {
        cli_error("Bad --subnets/--test-ip: " . implode('; ', $errors) . "\n(Use --no-network to leave the network rule unchanged.)");
    }
}

$course = $DB->get_record('course', ['shortname' => $options['course']], '*', MUST_EXIST);
$code = null;
if (!$options['no-class-code']) {
    try {
        $code = mca_daily_code(mca_load_secret($options['secret-file']), $course->shortname, mca_school_date(time()));
    } catch (RuntimeException $e) {
        cli_error($e->getMessage() . "\n(Use --no-class-code to set up the other gates without it.)");
    }
}
if (!$options['no-prereqs'] && !$course->enablecompletion) {
    cli_error("Completion tracking is off for {$course->shortname}; prerequisites could never be met. Enable it or pass --no-prereqs.");
}
$modinfo = get_fast_modinfo($course);

$plans = [];
foreach ($modinfo->sections as $sectionnum => $cmids) {
    $section_cms = [];
    foreach ($cmids as $cmid) {
        $c = $modinfo->get_cm($cmid);
        $section_cms[] = ['id' => (int)$c->id, 'modname' => $c->modname, 'name' => $c->name,
                          'completion' => (int)$c->completion, 'visible' => (bool)$c->visible];
    }
    foreach ($section_cms as $scm) {
        if (!mca_is_mastery_check($scm) || ($options['only-cmid'] && (int)$options['only-cmid'] !== $scm['id'])) {
            continue;
        }
        $cm = $modinfo->get_cm($scm['id']);
        $quiz = $DB->get_record('quiz', ['id' => $cm->instance], 'id, name, password, subnet, intro', MUST_EXIST);
        [$prereqs, $problems] = $options['no-prereqs'] ? [[], []] : mca_find_prerequisites($section_cms, $scm['id']);
        $plan = mca_plan((array)$quiz, [
            'subnets' => $subnets,
            'password' => $code,
            'class_code_intro' => $code !== null,
            'prereq_cmids' => $prereqs,
            'availability' => $cm->availability,
        ]);
        $names = array_map(fn($id) => $modinfo->get_cm($id)->name, $prereqs);
        $plans[] = compact('cm', 'quiz', 'plan', 'problems', 'names');
    }
}

if (!$plans) {
    cli_error("No quizzes named '... Mastery Check' found in {$course->shortname}.");
}

$changes = 0;
foreach ($plans as $p) {
    echo "\n== {$p['quiz']->name} (cmid {$p['cm']->id})\n";
    echo "   Students will see: " . mca_describe_for_student($p['names'], $subnets ?: ($p['quiz']->subnet ?: null), $code !== null) . "\n";
    foreach ($p['plan']['quiz'] as $field => [$old, $new]) {
        // Never print codes or old passwords: terminal history and session logs are not secret.
        $shown = $field === 'password' ? [$old === '' ? '(none)' : '(old password)', "(today's class code)"]
                                       : [$old === '' ? '(empty)' : $old, $new === '' ? '(empty)' : $new];
        echo "   {$field}: {$shown[0]}  ->  {$shown[1]}\n";
        $changes++;
    }
    if ($p['plan']['availability']) {
        echo "   prerequisites: " . implode(', ', $p['names']) . "\n";
        $changes++;
    }
    foreach ($p['problems'] as $problem) {
        echo "   PROBLEM (skipped): {$problem}\n";
    }
    if (!$p['plan']['quiz'] && !$p['plan']['availability'] && !$p['problems']) {
        echo "   already up to date\n";
    }
}
if ($options['check-ip'] !== '' && $subnets) {
    $ok = mca_ip_in_subnets($options['check-ip'], $subnets);
    echo "\nAddress {$options['check-ip']} would be " . ($ok ? 'ALLOWED' : 'BLOCKED') . " by --subnets={$subnets}\n";
}

if (!$options['apply']) {
    echo "\nDRY RUN: {$changes} change(s) planned, nothing written. Re-run with --apply to write them.\n";
    exit(0);
}
if ($changes === 0) {
    echo "\nNothing to change.\n";
    exit(0);
}

// ------------------------------------------------------------ apply
mca_require_backup($options);

$snapshot = ['courseid' => (int)$course->id, 'created' => date('c'), 'items' => []];
foreach ($plans as $p) {
    $snapshot['items'][] = [
        'cmid' => (int)$p['cm']->id, 'quizid' => (int)$p['quiz']->id, 'name' => $p['quiz']->name,
        'quiz' => ['password' => $p['quiz']->password, 'subnet' => $p['quiz']->subnet, 'intro' => $p['quiz']->intro],
        'availability' => $p['cm']->availability,
    ];
}
$snapfile = rtrim($options['snapshot-dir'], '/') . "/foxcs-mca-rollback-{$course->shortname}-" . date('Ymd-His') . '.json';
if (file_put_contents($snapfile, json_encode($snapshot, JSON_PRETTY_PRINT)) === false) {
    cli_error("Could not write rollback snapshot to {$snapfile}; nothing changed.");
}
chmod($snapfile, 0600); // it holds the old passwords
echo "\nRollback snapshot: {$snapfile}\n";

$transaction = $DB->start_delegated_transaction();
foreach ($plans as $p) {
    if ($p['plan']['quiz']) {
        $record = ['id' => $p['quiz']->id];
        foreach ($p['plan']['quiz'] as $field => [, $new]) {
            $record[$field] = $new;
        }
        $DB->update_record('quiz', (object)$record);
    }
    if ($p['plan']['availability']) {
        $DB->set_field('course_modules', 'availability', $p['plan']['availability'][1], ['id' => $p['cm']->id]);
    }
}
$transaction->allow_commit();
rebuild_course_cache($course->id, true);
echo "Applied {$changes} change(s) to {$course->shortname}. Re-run without --apply to confirm it now reports 'already up to date'.\n";
