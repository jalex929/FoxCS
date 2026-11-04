<?php
// Tests for copy_lib.php. Plain PHP, no Moodle.
//   php 07-infrastructure/moodle-scripts/course-copy/tests/test_copy_lib.php

define('FOXCS_COPY_TEST', true);
require __DIR__ . '/../copy_lib.php';

$failures = 0;
$count = 0;
function check(string $label, $actual, $expected): void {
    global $failures, $count;
    $count++;
    if ($actual !== $expected) {
        $failures++;
        echo "FAIL: {$label}\n  expected: " . var_export($expected, true) . "\n  actual:   " . var_export($actual, true) . "\n";
    }
}
function m(int $section, string $modname, string $name, int $cmid): array {
    return ['section' => $section, 'modname' => $modname, 'name' => $name, 'cmid' => $cmid];
}

// ------------------------------------------------ pairing
$live = [m(1, 'resource', '01.1 Instruction', 200), m(1, 'quiz', '01.1 Mastery Check', 201), m(2, 'assign', '02.2 Coding Exercise', 262)];
$copy = [m(1, 'resource', '01.1 Instruction', 900), m(1, 'quiz', '01.1 Mastery Check', 901), m(2, 'assign', '02.2 Coding Exercise', 902)];
check('pair: identical structure', copy_pair_modules($live, $copy), [[200 => 900, 201 => 901, 262 => 902], []]);
[$map, $p] = copy_pair_modules($live, array_slice($copy, 0, 2));
check('pair: missing module refuses', [$map, $p], [[], ['module count differs: live 3, copy 2']]);
[$map, $p] = copy_pair_modules(array_slice($live, 0, 2), $copy);
check('pair: extra module refuses', [$map, $p], [[], ['module count differs: live 2, copy 3']]);
$swapped = $copy;
[$swapped[0], $swapped[1]] = [$swapped[1], $swapped[0]];
[$map, $p] = copy_pair_modules($live, $swapped);
check('pair: reordered modules refuse', [$map, count($p)], [[], 4]);
check('pair: problem names the module', $p[0], "module 1 (01.1 Instruction): modname is 'resource' live but 'quiz' in the copy");
$renamed = $copy;
$renamed[2] = m(2, 'assign', '02.2 Coding Exercise (copy)', 902);
check('pair: renamed module refuses', copy_pair_modules($live, $renamed)[1],
    ["module 3 (02.2 Coding Exercise): name is '02.2 Coding Exercise' live but '02.2 Coding Exercise (copy)' in the copy"]);
$moved = $copy;
$moved[2] = m(3, 'assign', '02.2 Coding Exercise', 902);
check('pair: different section refuses', copy_pair_modules($live, $moved)[1],
    ["module 3 (02.2 Coding Exercise): section is 2 live but 3 in the copy"]);
check('pair: empty course', copy_pair_modules([], []), [[], []]);

// ------------------------------------------------ rewriting page HTML
$map = [200 => 900, 262 => 902];
$html = 'var CMID = "200";' . "\n" . "var CMID='262';\n"
    . '<a href="/mod/assign/view.php?id=262">Coding Exercise</a>'
    . '<a href="https://example.test/mod/quiz/view.php?id=201">quiz</a>'
    . '<a href="/course/view.php?id=4">course</a> <a href="/course/view.php?id=44">other</a>'
    . '<a href="/mod/assign/view.php?id=2620">longer id</a>';
[$out, $n, $unmapped] = copy_rewrite_html($html, $map, 4, 9);
check('rewrite: telemetry CMID (double quotes)', strpos($out, 'var CMID = "900";') !== false, true);
check('rewrite: telemetry CMID (single quotes)', strpos($out, "var CMID='902';") !== false, true);
check('rewrite: activity link', strpos($out, '/mod/assign/view.php?id=902"') !== false, true);
check('rewrite: course link', strpos($out, '/course/view.php?id=9"') !== false, true);
check('rewrite: other course untouched', strpos($out, '/course/view.php?id=44"') !== false, true);
check('rewrite: a longer id is not a prefix match', strpos($out, '/mod/assign/view.php?id=2620"') !== false, true);
check('rewrite: count', $n, 4);
check('rewrite: unmapped ids reported, sorted', $unmapped, [44, 201, 2620]);
check('rewrite: unmapped quiz link left alone', strpos($out, '/mod/quiz/view.php?id=201"') !== false, true);
check('rewrite: placeholder pages untouched', copy_rewrite_html('var CMID = "__CMID__";', $map, 4, 9), ['var CMID = "__CMID__";', 0, []]);
check('rewrite: no ids', copy_rewrite_html('<p>hello</p>', $map, 4, 9), ['<p>hello</p>', 0, []]);
check('rewrite: idempotent once rewritten (copy ids are not live ids)',
    copy_rewrite_html($out, $map, 4, 9)[1], 0);

// ------------------------------------------------ shortname
foreach (['foxcs-python-dev', 'abc', 'foxcs-python-2'] as $ok) {
    check("shortname ok: {$ok}", copy_valid_shortname($ok), true);
}
foreach (['', 'ab', 'Foxcs', 'foxcs python', 'foxcs_python', "foxcs-dev\n", str_repeat('a', 101)] as $bad) {
    check('shortname rejected: ' . json_encode($bad), copy_valid_shortname($bad), false);
}

echo "{$count} checks, {$failures} failures\n";
exit($failures ? 1 : 0);
