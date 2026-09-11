<?php
// test_check_lesson_ladder_wiring.php
//
// PURPOSE
//   Plain-PHP test harness for check-lesson-ladder-wiring.php's pure logic
//   (ladder_classify_title, ladder_run_checks). The checker's own header
//   comment describes exactly this harness shape but it was never actually
//   written -- this fills that gap. Deliberately NOT PHPUnit: worklog.md
//   (2026-08-30) already found "Moodle's PHPUnit-only test generators
//   aren't usable standalone" on this droplet, and this repo's other test
//   suites (05-grader) use stdlib-only tooling on purpose, so this matches
//   that convention -- plain assertions, zero dependencies, runs with a
//   stock `php` binary.
//
//   Defines LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP before requiring the real
//   checker file, exactly as that file's own header documents, so none of
//   this touches a live Moodle DB -- synthetic fixture objects only.
//
// USAGE
//   php 02-authoring-system/tools/tests/test_check_lesson_ladder_wiring.php
//
// EXIT CODE
//   0 if every assertion passed, 1 if any failed (prints a FAIL line per
//   failure plus a final summary either way).

define('LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP', true);
require __DIR__ . '/../check-lesson-ladder-wiring.php';

$failures = [];
$passed = 0;

function t_page(int $id, string $title, int $qtype = 0): stdClass {
    $p = new stdClass();
    $p->id = $id;
    $p->title = $title;
    $p->qtype = $qtype;
    return $p;
}

function t_answer(int $id, int $pageid, int $jumpto): stdClass {
    $a = new stdClass();
    $a->id = $id;
    $a->pageid = $pageid;
    $a->jumpto = $jumpto;
    return $a;
}

function assert_true(bool $cond, string $label): void {
    global $failures, $passed;
    if ($cond) {
        $passed++;
    } else {
        $failures[] = $label;
    }
}

function assert_count(int $expected, array $actual, string $label): void {
    assert_true(count($actual) === $expected, "$label (expected count $expected, got " . count($actual) . ": " . implode(' | ', $actual) . ")");
}

function assert_contains(string $needle, array $haystack, string $label): void {
    $found = false;
    foreach ($haystack as $h) {
        if (strpos($h, $needle) !== false) {
            $found = true;
            break;
        }
    }
    assert_true($found, "$label (looking for substring: \"$needle\")");
}

// --- ladder_classify_title ---

[$cluster, $lane] = ladder_classify_title('5.3 Core');
assert_true($cluster === '5.3' && $lane === 'Core', 'classify: "5.3 Core" -> cluster 5.3, lane Core');

[$cluster, $lane] = ladder_classify_title('5.3 Reinforce 1');
assert_true($cluster === '5.3' && $lane === 'Reinforce', 'classify: "5.3 Reinforce 1" -> cluster 5.3, lane Reinforce');

[$cluster, $lane] = ladder_classify_title('5.3 Extend 2');
assert_true($cluster === '5.3' && $lane === 'Extend', 'classify: "5.3 Extend 2" -> cluster 5.3, lane Extend');

[$cluster, $lane] = ladder_classify_title('5.3 Reteach');
assert_true($cluster === '5.3' && $lane === 'Reteach', 'classify: "5.3 Reteach" -> cluster 5.3, lane Reteach');

[$cluster, $lane] = ladder_classify_title('Welcome to the lesson');
assert_true($cluster === null && $lane === null, 'classify: non-ladder title -> [null, null]');

// --- ladder_run_checks: dangling jumps ---

$pages = [1 => t_page(1, '1.1 Core'), 2 => t_page(2, '1.1 Reinforce 1')];
$answers = [t_answer(1, 1, 999)]; // jumps to a page that doesn't exist
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['errors'], 'dangling jump: nonexistent page id is a hard ERROR');
assert_contains('DANGLING JUMP', $result['errors'], 'dangling jump error text');

$pages = [1 => t_page(1, '1.1 Core'), 2 => t_page(2, '1.1 Reinforce 1')];
$answers = [
    t_answer(1, 1, LADDER_LESSON_NEXTPAGE),
    t_answer(2, 1, LADDER_LESSON_THISPAGE),
    t_answer(3, 1, LADDER_LESSON_EOL),
];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(0, $result['errors'], 'valid special jumps (NEXTPAGE/THISPAGE/EOL) produce no errors');
assert_count(0, $result['warnings'], 'valid special jumps produce no warnings');

$pages = [1 => t_page(1, '1.1 Core')];
$answers = [t_answer(1, 1, LADDER_LESSON_PREVIOUSPAGE)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['warnings'], 'unexpected special jump (PREVIOUSPAGE) is a WARNING, not an error');
assert_count(0, $result['errors'], 'unexpected special jump is not an ERROR');

$pages = [1 => t_page(1, '1.1 Core')];
$answers = [t_answer(1, 1, -12345)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['warnings'], 'unrecognized negative jump value is a WARNING');
assert_contains('UNRECOGNIZED JUMP VALUE', $result['warnings'], 'unrecognized jump warning text');

// --- ladder_run_checks: lane crossing ---

$pages = [
    1 => t_page(1, '2.1 Reinforce 1'),
    2 => t_page(2, '2.1 Extend 1'),
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['errors'], 'Reinforce -> Extend lane crossing is a hard ERROR');
assert_contains('LANE CROSSING', $result['errors'], 'lane crossing error text (Reinforce->Extend)');

$pages = [
    1 => t_page(1, '2.1 Extend 1'),
    2 => t_page(2, '2.1 Reinforce 1'),
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['errors'], 'Extend -> Reinforce lane crossing is a hard ERROR');

$pages = [
    1 => t_page(1, '2.1 Reinforce 1'),
    2 => t_page(2, '2.1 Reinforce 2'),
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(0, $result['errors'], 'Reinforce looping within its own lane is fine');

// --- ladder_run_checks: Reteach must be a content page ---

$pages = [
    1 => t_page(1, '3.1 Reinforce 1'),
    2 => t_page(2, '3.1 Reteach', qtype: 0), // wrong type -- looks like a question page
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(1, $result['errors'], 'Reteach page with a question qtype is a hard ERROR');
assert_contains('RETEACH PAGE IS A QUESTION', $result['errors'], 'reteach-is-a-question error text');

$pages = [
    1 => t_page(1, '3.1 Reinforce 1'),
    2 => t_page(2, '3.1 Reteach', qtype: LADDER_LESSON_PAGE_BRANCHTABLE),
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(0, $result['errors'], 'Reteach page with the correct content qtype is fine');

// --- ladder_run_checks: Core target outside ladder is a NOTE, not an ERROR ---

$pages = [
    1 => t_page(1, '4.1 Core'),
    2 => t_page(2, '4.2 Core'), // classified (lane=Core), but neither Reinforce nor Extend
];
$answers = [t_answer(1, 1, 2)];
$result = ladder_run_checks($pages, $answers, 4);
assert_count(0, $result['errors'], 'Core jumping outside Reinforce/Extend is not an ERROR');
assert_count(1, $result['notes'], 'Core jumping outside Reinforce/Extend produces a NOTE');
assert_contains('CORE TARGET OUTSIDE LADDER', $result['notes'], 'core-target-outside-ladder note text');

// --- ladder_run_checks: pool-size cap ---

$pages = [
    1 => t_page(1, '5.1 Reinforce 1'),
    2 => t_page(2, '5.1 Reinforce 2'),
    3 => t_page(3, '5.1 Reinforce 3'),
];
$result = ladder_run_checks($pages, [], 2);
assert_count(1, $result['errors'], 'exceeding the pool-size cap is a hard ERROR');
assert_contains('POOL SIZE EXCEEDED', $result['errors'], 'pool-size error text');

$pages = [
    1 => t_page(1, '5.1 Reinforce 1'),
    2 => t_page(2, '5.1 Reinforce 2'),
];
$result = ladder_run_checks($pages, [], 2);
assert_count(0, $result['errors'], 'pool size exactly at the cap is fine');

// --- ladder_run_checks: empty lesson doesn't crash ---

$result = ladder_run_checks([], [], 4);
assert_count(0, $result['errors'], 'empty lesson produces no errors');
assert_count(0, $result['warnings'], 'empty lesson produces no warnings');
assert_count(0, $result['notes'], 'empty lesson produces no notes');

// --- summary ---

echo "Passed: $passed\n";
if ($failures) {
    echo "\nFAILED (" . count($failures) . "):\n";
    foreach ($failures as $f) {
        echo "  [FAIL] $f\n";
    }
    exit(1);
}
echo "All assertions passed.\n";
exit(0);
