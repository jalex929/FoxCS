<?php
// set-project-tier-grade.php
//
// Standing tool for grading any Unit Project Assignment against the
// Starter/Skilled/Legendary/Mythic tier system
// (02-authoring-system/project-rubric-and-xp-tiers.md), using
// grade-point-scale.md's settled 2026-09-11 mechanism: Project is a
// per-UNIT item (not per-lesson), grademax 20 (provisional), graded via
// a direct tier-to-percent lookup -- NOT a ratio of tier XP to grademax:
//
//   Starter (15 XP)   -> 80%
//   Skilled (25 XP)   -> 100%
//   Legendary (35 XP) -> 103% (+3% per 10 XP over the 25-XP baseline)
//   Mythic (45 XP)    -> 106% (+6%)
//
// This does NOT decide which tier a submission earned -- that's a
// holistic judgment call against the real rubric criteria (see
// 05-grader/feedback-and-grading-spec.md Section 14/15 for how that read
// should be done, by a human or an AI-assisted review of the actual
// submitted files). This script only takes an already-decided tier and
// turns it into the correct Moodle grade, consistently, against
// whatever the target assign's OWN configured grademax actually is --
// deliberately not hardcoded to 20, since grade-point-scale.md itself
// flags that number as provisional, not locked. If the Unit Project's
// grademax is tuned later, this script keeps working without an edit.
//
// Implementation choice made here, per grade-point-scale.md's own
// explicitly-left-open question ("a grade override on the Project item
// itself, or a separate always-positive Project Bonus extra-credit
// item"): grade override on the Project item itself. Simpler -- one
// gradebook item per unit, nothing extra for Jay to manage.
//
// KNOWN OPEN TENSION, not resolved by this script: 05-grader/feedback-and-
// grading-spec.md Section 15 describes a SEPARATE +1/+2 "Above-and-Beyond
// Bonus" mechanism that does the same job as the tier bonus here. Do not
// apply both to the same submission -- see REPO_MAP.md's Known Tensions
// list. This script assumes Section 15's bonus is NOT also being applied.
//
// Run: sudo -u www-data php set-project-tier-grade.php <assignid> <userid> <tier>
//   tier is one of: starter skilled legendary mythic

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

\core\cron::setup_user();

const TIER_PERCENT = [
    'starter'   => 80,
    'skilled'   => 100,
    'legendary' => 103,
    'mythic'    => 106,
];

function tier_to_percent(string $tier): float {
    $percent = TIER_PERCENT[$tier] ?? null;
    if ($percent === null) {
        fwrite(STDERR, "Unknown tier '{$tier}'. Must be one of: " . implode(', ', array_keys(TIER_PERCENT)) . "\n");
        exit(1);
    }
    return (float) $percent;
}

[$script, $assignidarg, $useridarg, $tierarg] = array_pad($argv, 4, null);
if ($assignidarg === null || $useridarg === null || $tierarg === null) {
    fwrite(STDERR, "Usage: php set-project-tier-grade.php <assignid> <userid> <tier>\n");
    fwrite(STDERR, "  tier: " . implode(' | ', array_keys(TIER_PERCENT)) . "\n");
    exit(1);
}

$assignid = (int) $assignidarg;
$userid = (int) $useridarg;
$tier = strtolower($tierarg);

$percent = tier_to_percent($tier);

$assignrecord = $DB->get_record('assign', ['id' => $assignid], '*', MUST_EXIST);
$grademax = (float) $assignrecord->grade;
if ($grademax <= 0) {
    fwrite(STDERR, "Refusing: assign id={$assignid} ({$assignrecord->name}) has no positive grademax ({$grademax}). Not a tier-graded Project?\n");
    exit(1);
}

$grade = $grademax * ($percent / 100);

$cm = get_coursemodule_from_instance('assign', $assignid, $assignrecord->course, false, MUST_EXIST);
$context = context_module::instance($cm->id);
$assign = new assign($context, $cm, null);

$data = new stdClass();
$data->grade = $grade;
$assign->save_grade($userid, $data);

echo "assign id={$assignid} ({$assignrecord->name}) userid={$userid}: tier={$tier} -> {$percent}% of grademax {$grademax} = grade={$grade}\n";
