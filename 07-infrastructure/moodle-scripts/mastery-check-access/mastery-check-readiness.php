<?php
// mastery-check-readiness.php -- READ-ONLY teacher view. One CSV row per
// student per Mastery Check, so you can pace the class at a glance:
// who is unlocked, who still has prerequisites left (and which), attempts
// used of the 3 allowed, current average, and how many attempts were
// submitted from outside the allowed network (should be 0 once the gate is
// on; non-zero flags a configuration gap worth a look, not a student).
//
//   sudo -u www-data php /tmp/foxcs-deploy-stage/mastery-check-access/mastery-check-readiness.php \
//       --course=foxcs-python > /tmp/mc-readiness.csv
//
// The CSV uses Moodle usernames (pseudonymous IDs), never real names. It
// lands in the teacher spreadsheet's results tab, not the private roster tab.

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once(__DIR__ . '/mca_lib.php');

[$options] = cli_get_params(['course' => 'foxcs-python', 'help' => false], ['h' => 'help']);
if ($options['help']) {
    echo "Options: --course=SHORTNAME\n";
    exit(0);
}

$course = $DB->get_record('course', ['shortname' => $options['course']], '*', MUST_EXIST);
$context = context_course::instance($course->id);
$modinfo = get_fast_modinfo($course);
$students = get_enrolled_users($context, 'mod/quiz:attempt', 0, 'u.id, u.username', 'u.username ASC', 0, 0, true);

$out = fopen('php://stdout', 'w');
fputcsv($out, ['student_id', 'mastery_check', 'status', 'missing_prerequisites',
               'attempts_used', 'attempts_allowed', 'average_grade', 'grade_max', 'attempts_off_network']);

foreach ($modinfo->sections as $cmids) {
    $section_cms = [];
    foreach ($cmids as $cmid) {
        $c = $modinfo->get_cm($cmid);
        $section_cms[] = ['id' => (int)$c->id, 'modname' => $c->modname, 'name' => $c->name,
                          'completion' => (int)$c->completion, 'visible' => (bool)$c->visible];
    }
    foreach ($section_cms as $scm) {
        if (!mca_is_mastery_check($scm)) {
            continue;
        }
        $cm = $modinfo->get_cm($scm['id']);
        $quiz = $DB->get_record('quiz', ['id' => $cm->instance], 'id, name, attempts, sumgrades, grade, subnet', MUST_EXIST);
        [$prereqs] = mca_find_prerequisites($section_cms, $scm['id']);

        $done = [];
        if ($prereqs) {
            [$insql, $params] = $DB->get_in_or_equal($prereqs);
            foreach ($DB->get_records_select('course_modules_completion',
                    "coursemoduleid {$insql} AND completionstate > 0", $params, '', 'id, coursemoduleid, userid') as $row) {
                $done[$row->userid][$row->coursemoduleid] = true;
            }
        }

        $attempts = $DB->get_records('quiz_attempts', ['quiz' => $quiz->id, 'preview' => 0, 'state' => 'finished'],
                                     '', 'id, userid, sumgrades');
        $ips = [];
        if ($attempts) {
            [$insql, $params] = $DB->get_in_or_equal(array_keys($attempts), SQL_PARAMS_NAMED);
            $params['ev'] = '\\mod_quiz\\event\\attempt_submitted';
            foreach ($DB->get_records_sql("SELECT id, objectid, ip FROM {logstore_standard_log}
                                            WHERE eventname = :ev AND objectid {$insql}", $params) as $log) {
                $ips[$log->objectid] = $log->ip;
            }
        }
        $byuser = [];
        foreach ($attempts as $a) {
            $byuser[$a->userid][] = $a;
        }

        foreach ($students as $s) {
            $missing = array_values(array_filter($prereqs, fn($id) => empty($done[$s->id][$id])));
            $mine = $byuser[$s->id] ?? [];
            $grades = array_map(fn($a) => $quiz->sumgrades > 0 ? $a->sumgrades / $quiz->sumgrades * $quiz->grade : 0, $mine);
            $off = $quiz->subnet === '' ? '' : count(array_filter($mine,
                fn($a) => isset($ips[$a->id]) && !mca_ip_in_subnets($ips[$a->id], $quiz->subnet)));
            $max = (int)$quiz->attempts;
            $status = $missing ? 'locked: prerequisites'
                : (!$mine ? 'ready' : ($max && count($mine) >= $max ? 'all attempts used' : 'in progress'));
            fputcsv($out, [
                $s->username, $quiz->name, $status,
                implode('; ', array_map(fn($id) => $modinfo->get_cm($id)->name, $missing)),
                count($mine), $max ?: 'unlimited',
                $grades ? round(array_sum($grades) / count($grades), 2) : '',
                (float)$quiz->grade, $off,
            ]);
        }
    }
}
fclose($out);
