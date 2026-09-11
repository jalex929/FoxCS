<?php
// set-project-tier-grade.php
//
// Standing tool for grading any Project Assignment against the Starter/
// Skilled/Legendary/Mythic tier system (02-authoring-system/project-rubric-
// and-xp-tiers.md) using grade-point-scale.md's settled mechanism: the
// Moodle assign grade stays a plain, uninflated 25 (Skilled/on-level), and
// XP earned above that baseline converts to a small percent bonus --
// every 5 extra XP = +1%, capped at +4% by the Mythic ceiling (45 XP).
//
// This does NOT decide which tier a submission earned -- that's a holistic
// judgment call against the real rubric criteria (see
// 05-grader/feedback-and-grading-spec.md Section 14/15 for how that read
// should be done, by a human or an AI-assisted review of the actual
// submitted files). This script only takes an already-decided tier and
// turns it into the correct Moodle grade, consistently, so nobody hand-
// computes 25.5 vs 26 themselves and gets it wrong.
//
// KNOWN OPEN TENSION, not resolved by this script: 05-grader/feedback-and-
// grading-spec.md Section 15 describes a SEPARATE +1/+2 "Above-and-Beyond
// Bonus" mechanism that does the same job as the XP-to-percent bonus here.
// Do not apply both to the same submission -- see REPO_MAP.md's Known
// Tensions list. This script assumes Section 15's bonus is NOT also being
// applied; if it later is, this mechanism needs to be retired or merged
// into it, not stacked.
//
// Run: sudo -u www-data php set-project-tier-grade.php <assignid> <userid> <tier>
//   tier is one of: starter skilled legendary mythic

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

\core\cron::setup_user();

const BASELINE_GRADE = 25.0;   // Skilled / on-level tier, matches grade-point-scale.md.
const BONUS_PER_5_XP = 1.0;    // Percent, per Jay's stated rate.

const TIER_XP = [
    'starter'   => 15,
    'skilled'   => 25,
    'legendary' => 35,
    'mythic'    => 45,
];

function tier_to_grade(string $tier): float {
    $xp = TIER_XP[$tier] ?? null;
    if ($xp === null) {
        fwrite(STDERR, "Unknown tier '{$tier}'. Must be one of: " . implode(', ', array_keys(TIER_XP)) . "\n");
        exit(1);
    }

    if ($xp <= BASELINE_GRADE) {
        // Starter or Skilled: grade is simply min(tier_xp, baseline), no bonus.
        return (float) $xp;
    }

    $extraxp = $xp - BASELINE_GRADE;
    $bonuspercent = floor($extraxp / 5) * BONUS_PER_5_XP;
    $bonuspoints = BASELINE_GRADE * ($bonuspercent / 100);
    return BASELINE_GRADE + $bonuspoints;
}

[$script, $assignidarg, $useridarg, $tierarg] = array_pad($argv, 4, null);
if ($assignidarg === null || $useridarg === null || $tierarg === null) {
    fwrite(STDERR, "Usage: php set-project-tier-grade.php <assignid> <userid> <tier>\n");
    fwrite(STDERR, "  tier: " . implode(' | ', array_keys(TIER_XP)) . "\n");
    exit(1);
}

$assignid = (int) $assignidarg;
$userid = (int) $useridarg;
$tier = strtolower($tierarg);

$grade = tier_to_grade($tier);

$assignrecord = $DB->get_record('assign', ['id' => $assignid], '*', MUST_EXIST);
if ((float) $assignrecord->grade !== BASELINE_GRADE) {
    fwrite(STDERR, "Refusing: assign id={$assignid} ({$assignrecord->name}) grademax is {$assignrecord->grade}, expected " . BASELINE_GRADE . ". Confirm this is a tier-graded Project before running.\n");
    exit(1);
}

$cm = get_coursemodule_from_instance('assign', $assignid, $assignrecord->course, false, MUST_EXIST);
$context = context_module::instance($cm->id);
$assign = new assign($context, $cm, null);

$data = new stdClass();
$data->grade = $grade;
$assign->save_grade($userid, $data);

$xp = TIER_XP[$tier];
$extraxp = max(0, $xp - BASELINE_GRADE);
$bonuspercent = floor($extraxp / 5) * BONUS_PER_5_XP;

echo "assign id={$assignid} ({$assignrecord->name}) userid={$userid}: tier={$tier} ({$xp} XP) -> grade={$grade} (base " . min($xp, BASELINE_GRADE) . " + {$bonuspercent}% bonus)\n";
