<?php
// Tests for answer_variants.php. Plain PHP; runs every accepted answer
// through Python to prove it prints exactly the target.
//   php 07-infrastructure/moodle-scripts/lib/tests/test_answer_variants.php

define('FOXCS_LIB_TEST', true);
require __DIR__ . '/../answer_variants.php';

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

$v = foxcs_print_variants('Game Over');
check('16 variants: 2 quote styles x 8 spacings', count($v), 16);
check('clean double-quote form first', $v[0], ['answer' => 'print("Game Over")', 'clean' => true, 'feedback' => 'Correct.']);
check('only two clean forms', count(array_filter($v, fn($x) => $x['clean'])), 2);
check('all unique', count(array_unique(array_column($v, 'answer'))), 16);
check('spaced forms carry the style tip', array_values(array_unique(array_column(array_filter($v, fn($x) => !$x['clean']), 'feedback'))), [FOXCS_STYLE_TIP]);
check('fully spaced form accepted', in_array("print ( 'Game Over' )", array_column($v, 'answer'), true), true);
check('target containing a double quote skips that style', array_column(foxcs_print_variants('Say "hi"'), 'answer')[0], "print('Say \"hi\"')");
check('target containing an apostrophe skips single quotes', count(foxcs_print_variants("Player's turn")), 8);

// Every accepted answer really is valid Python that prints exactly the target.
$python = trim((string) shell_exec('command -v python3'));
if ($python === '') {
    echo "python3 not found\n";
    exit(1);
}
foreach (['Ready to code!', 'Score: 100', 'Hello, world!', 'Level Up!', 'Game Over', 'Player 1 Wins!', "Player's turn"] as $target) {
    foreach (foxcs_print_variants($target) as $variant) {
        $out = shell_exec(escapeshellarg($python) . ' -I -c ' . escapeshellarg($variant['answer']) . ' 2>&1');
        check("runs and prints exactly the target: {$variant['answer']}", $out, $target . "\n");
    }
}

echo "{$count} checks, {$failures} failures\n";
exit($failures ? 1 : 0);
