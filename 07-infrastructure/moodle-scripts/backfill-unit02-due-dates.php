<?php
// backfill-unit02-due-dates.php
//
// Per Jay's direct standing policy 2026-09-09 ("every module posted... should
// have a recommended due date") plus his confirmation to backfill from the
// dates course-plan.md already documents, even where they're today/past --
// pacing targets the average student, students who are behind are expected
// to catch up in class, not get a silently-extended deadline.
//
// Dates pulled straight from course-plan.md's per-lesson "due" notes:
//   02.0/02.1        Tue Sept 8  3:30 PM CT
//   02.2             Wed Sept 9  3:30 PM CT
//   02.3/02.4        Thu Sept 10 3:30 PM CT
//   02.5             Fri Sept 11 2:30 PM CT (Friday early-time rule)
//   Checkpoint       Fri Sept 11 2:30 PM CT -- INFERRED, not explicitly
//                    dated in course-plan.md (only says it "sits after 2.5
//                    CE, ahead of 02.6"); placed alongside 02.5 since it
//                    reviews 02.1-02.5 content. Flagged to Jay, not a
//                    confirmed date the way the others are.
//
// For assign modules: sets duedate (a soft/late-flag date, not a hard
// block -- cutoffdate is deliberately left unset) AND completionexpected.
// For resource modules (no native due-date field): completionexpected only.
// For quiz modules: completionexpected only -- deliberately NOT setting
// timeclose, since that actually blocks starting a new attempt after the
// date, which would make this a hard deadline rather than the "recommended,
// students catch up in class" framing course-plan.md already establishes.
//
// Run: sudo -u www-data php backfill-unit02-due-dates.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
\core\cron::setup_user();

$TUE_SEPT8  = 1788899400; // Tue Sept 8 2026, 3:30 PM CDT
$WED_SEPT9  = 1788985800; // Wed Sept 9 2026, 3:30 PM CDT
$THU_SEPT10 = 1789072200; // Thu Sept 10 2026, 3:30 PM CDT
$FRI_SEPT11 = 1789155000; // Fri Sept 11 2026, 2:30 PM CDT

$resources = [
    244 => $TUE_SEPT8,  // 2.0 Getting Ready for Certification
    245 => $TUE_SEPT8,  // 2.1 Variables and Memory: Instruction
    259 => $WED_SEPT9,  // 2.2 Integers: Instruction
    260 => $THU_SEPT10, // 2.3 Floats: Instruction
    261 => $THU_SEPT10, // 2.4 Strings: Instruction
    262 => $FRI_SEPT11, // 2.5 Booleans: Instruction
];

$assigns = [
    248 => $TUE_SEPT8,  // 2.1 Project: Character Status Tracker
    264 => $WED_SEPT9,  // 2.2 Coding Exercise: Integers
    265 => $THU_SEPT10, // 2.3 Coding Exercise: Floats
    266 => $THU_SEPT10, // 2.4 Coding Exercise: Strings
    267 => $FRI_SEPT11, // 2.5 Coding Exercise: Booleans
    268 => $FRI_SEPT11, // Unit 02 Checkpoint: Mixed Data Types (inferred)
];

$quizzes = [
    269 => $TUE_SEPT8,  // 02.1 Mastery Check
    270 => $WED_SEPT9,  // 02.2 Mastery Check
    271 => $THU_SEPT10, // 02.3 Mastery Check
    272 => $THU_SEPT10, // 02.4 Mastery Check
    273 => $FRI_SEPT11, // 02.5 Mastery Check
];

foreach ($resources as $cmid => $ts) {
    $DB->set_field('course_modules', 'completionexpected', $ts, ['id' => $cmid]);
    echo "resource cmid={$cmid}: completionexpected=" . userdate($ts) . "\n";
}

foreach ($assigns as $cmid => $ts) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $DB->set_field('assign', 'duedate', $ts, ['id' => $cm->instance]);
    $DB->set_field('course_modules', 'completionexpected', $ts, ['id' => $cmid]);
    echo "assign cmid={$cmid}: duedate + completionexpected=" . userdate($ts) . "\n";
}

foreach ($quizzes as $cmid => $ts) {
    $DB->set_field('course_modules', 'completionexpected', $ts, ['id' => $cmid]);
    echo "quiz cmid={$cmid}: completionexpected=" . userdate($ts) . " (timeclose intentionally left unset)\n";
}

echo "Done.\n";
