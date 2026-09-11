<?php
// fix-unit01-quiz-sumgrades.php
//
// NOT YET RUN LIVE. Written and verified against real Moodle source
// (2026-09-11), blocked from execution by this session's own permission
// classifier before it could be tested against even one real attempt --
// see decisions-log.md's matching entry. Review before running.
//
// Root cause, confirmed by direct DB query (2026-09-11): 5 of Unit 01's
// 6 Mastery Check quizzes (quiz ids 2/3/6/7/8 -- everything except
// quizid=5, "01.3 Mastery Check") have real `finished` rows in
// mdl_quiz_attempts (39-61 each) but ZERO rows in mdl_quiz_grades,
// despite mdl_grade_grades having 62 rows each (one per enrolled
// student, but with no real finalgrade cascaded through). 01.3's
// attempts, by contrast, have `sumgrades` correctly populated per
// attempt and 53 real mdl_quiz_grades rows.
//
// The actual difference, confirmed by inspecting individual rows: the
// broken quizzes' mdl_quiz_attempts.sumgrades column is BLANK on every
// attempt, even though state='finished'. mdl_quiz_grades is computed
// FROM sumgrades, so a blank sumgrades cascades to nothing downstream.
// Why sumgrades was never computed for these specific attempts isn't
// established here -- plausibly these rows were migrated/preserved
// across a content rebuild via a direct DB copy that didn't replicate
// Moodle's own finish-attempt grading step, rather than every student
// genuinely finishing through the real UI without it computing. Not
// confirmed; flagged as the likely explanation, not fact.
//
// THE FIX, traced directly from Moodle 5.x's own source (not guessed):
// mod_quiz\classes\quiz_attempt.php's real process_finish() /
// process_grade_submission() sequence, on a genuine finish, does exactly
// this:
//   1. $quba = question_engine::load_questions_usage_by_activity($attempt->uniqueid);
//   2. $attempt->sumgrades = $quba->get_total_mark();
//   3. $DB->update_record('quiz_attempts', $attempt);
//   4. mod_quiz\quiz_settings::create($quizid)->get_grade_calculator()->recompute_final_grade($userid);
// This script replicates exactly that sequence for attempts whose
// sumgrades is currently blank -- it does NOT call finish_all_questions()
// again (these attempts are already state=finished; only step 2-4 are
// missing), and does NOT touch quiz_overview_report's "regrade" tool,
// which is a DIFFERENT mechanism for re-marking against a changed
// question version, not for computing an originally-missing sumgrades
// (confirmed by reading mod/quiz/report/overview/report.php directly --
// it never writes quiz_attempts.sumgrades).
//
// SAFETY: only touches attempts where sumgrades is currently null/blank
// -- refuses to touch any attempt that already has a real sumgrades
// value, so this cannot silently overwrite an existing real grade.
// Run the mandatory backup_moodle.sh first, every time, per CLAUDE.md's
// Data Safety section. Recommended: run with --dry-run first, spot-check
// the computed totals look sane, then run for real on ONE quiz, verify
// mdl_quiz_grades and the gradebook actually show correct values for a
// real student, before running the rest.
//
// Run: sudo -u www-data php fix-unit01-quiz-sumgrades.php --dry-run
//      sudo -u www-data php fix-unit01-quiz-sumgrades.php <quizid>
//      sudo -u www-data php fix-unit01-quiz-sumgrades.php <quizid> --dry-run

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/question/engine/lib.php');

\core\cron::setup_user();

// Unit 01 Mastery Check quiz ids confirmed broken, per the audit above.
// quizid=5 (01.3) deliberately excluded -- it already works, don't touch it.
const BROKEN_QUIZ_IDS = [2, 3, 6, 7, 8];

$args = array_slice($argv, 1);
$dryrun = in_array('--dry-run', $args, true);
$args = array_values(array_filter($args, fn($a) => $a !== '--dry-run'));
$onlyquizid = isset($args[0]) ? (int) $args[0] : null;

$quizids = $onlyquizid ? [$onlyquizid] : BROKEN_QUIZ_IDS;
foreach ($quizids as $quizid) {
    if (!in_array($quizid, BROKEN_QUIZ_IDS, true)) {
        fwrite(STDERR, "quizid={$quizid} is not in the confirmed-broken list -- refusing (edit BROKEN_QUIZ_IDS if this is deliberate).\n");
        exit(1);
    }
}

$fixed = 0;
$skippedalreadypopulated = 0;

foreach ($quizids as $quizid) {
    $attempts = $DB->get_records('quiz_attempts', ['quiz' => $quizid, 'state' => 'finished']);
    echo "quizid={$quizid}: {$dryrun}" . ($dryrun ? " [DRY RUN] " : " ") . count($attempts) . " finished attempts\n";

    $quizobj = null; // Lazily created only if we actually fix something for this quiz.
    $useridstofix = [];

    foreach ($attempts as $attempt) {
        if ($attempt->sumgrades !== null && $attempt->sumgrades !== '') {
            $skippedalreadypopulated++;
            continue;
        }

        $quba = \question_engine::load_questions_usage_by_activity($attempt->uniqueid);
        $totalmark = $quba->get_total_mark();

        echo "  attemptid={$attempt->id} userid={$attempt->userid}: computed sumgrades=" . var_export($totalmark, true) . "\n";

        if ($dryrun) {
            continue;
        }

        $attempt->sumgrades = $totalmark;
        $DB->update_record('quiz_attempts', $attempt);
        $useridstofix[$attempt->userid] = true;
        $fixed++;
    }

    if (!$dryrun && $useridstofix) {
        $quizobj = \mod_quiz\quiz_settings::create($quizid);
        foreach (array_keys($useridstofix) as $userid) {
            $quizobj->get_grade_calculator()->recompute_final_grade((int) $userid);
        }
        echo "  recomputed final grade for " . count($useridstofix) . " students on quizid={$quizid}\n";
    }
}

echo "\nDone. sumgrades fixed: {$fixed}. Already populated (skipped): {$skippedalreadypopulated}.\n";
if ($dryrun) {
    echo "This was a dry run -- nothing was written. Re-run without --dry-run to apply.\n";
}
