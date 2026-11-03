<?php
// Tests for mca_lib.php. Plain PHP, no Moodle, no database.
//   php 07-infrastructure/moodle-scripts/mastery-check-access/tests/test_mca_lib.php
// Exits non-zero on any failure. Run in CI by .github/workflows/mastery-check-access-tests.yml.

require __DIR__ . '/../mca_lib.php';

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

// ------------------------------------------------ subnet normalization
[$s, $e] = mca_normalize_subnets(" 10.20.30.0/24, 10.20.31.5 \n 172.16.4.10-40,10.9. ");
check('normalize: mixed valid forms', [$s, $e], ['10.20.30.0/24,10.20.31.5,172.16.4.10-40,10.9', []]);
[$s, $e] = mca_normalize_subnets('10.0.0.0/24,10.0.0.0/24');
check('normalize: duplicates collapse', $s, '10.0.0.0/24');
[, $e] = mca_normalize_subnets('');
check('normalize: empty is an error', $e, ['no subnets given']);
foreach (['300.1.1.1', '10.0.0.0/33', '10', '10.1.1.40-10', 'school', '::1', '10.1.1.1.1', '10.1.1.999-1000'] as $bad) {
    [, $e] = mca_normalize_subnets($bad);
    check("normalize: rejects {$bad}", count($e), 1);
}

// ------------------------------------------------ ip matching (mirrors Moodle address_in_subnet for IPv4)
$list = '10.20.30.0/24,192.168.1.50,172.16.4.10-40,10.9';
$cases = [
    ['10.20.30.7', true, 'inside CIDR'],
    ['10.20.31.7', false, 'outside CIDR'],
    ['192.168.1.50', true, 'exact'],
    ['192.168.1.51', false, 'exact neighbor'],
    ['172.16.4.10', true, 'range low edge'],
    ['172.16.4.40', true, 'range high edge'],
    ['172.16.4.41', false, 'past range'],
    ['10.9.200.1', true, 'dotted prefix'],
    ['10.90.0.1', false, 'prefix does not match a longer octet'],
    ['not-an-ip', false, 'garbage input'],
    ['', false, 'empty input'],
];
foreach ($cases as [$ip, $want, $label]) {
    check("ip_in_subnets: {$label}", mca_ip_in_subnets($ip, $list), $want);
}
check('ip_in_subnets: /0 allows all', mca_ip_in_subnets('8.8.8.8', '0.0.0.0/0'), true);
check('ip_in_subnets: /32 is exact', mca_ip_in_subnets('8.8.8.9', '8.8.8.8/32'), false);
check('ip_in_subnets: invalid entries ignored', mca_ip_in_subnets('8.8.8.8', 'junk, 8.8.8.8'), true);

// ------------------------------------------------ test-mode scenario: Jay testing from home
$school = '10.20.30.0/24';
$home = '73.50.10.5';
check('test mode: home blocked by school-only list', mca_ip_in_subnets($home, $school), false);
check('test mode: home allowed once added', mca_ip_in_subnets($home, "{$school},{$home}"), true);
check('test mode: school still allowed with home added', mca_ip_in_subnets('10.20.30.99', "{$school},{$home}"), true);

// ------------------------------------------------ school-network suggestion
$obs = [];
foreach (range(1, 12) as $u) {
    $obs[] = ['ip' => '10.20.30.' . (100 + $u), 'userid' => $u]; // school, many users
}
foreach (range(1, 3) as $u) {
    $obs[] = ['ip' => '10.20.31.' . $u, 'userid' => 20 + $u]; // second school block
}
$obs[] = ['ip' => '73.50.10.5', 'userid' => 1];  // one student's home
$obs[] = ['ip' => '73.50.10.5', 'userid' => 1];
$obs[] = ['ip' => 'bogus', 'userid' => 2];
$picked = mca_suggest_school_blocks($obs, 0.95, 3);
check('suggest: picks school blocks largest first', array_column($picked, 'block'), ['10.20.30.0/24', '10.20.31.0/24']);
check('suggest: counts distinct users', $picked[0]['users'], 12);
check('suggest: single-user home block excluded', in_array('73.50.10.0/24', array_column($picked, 'block'), true), false);
check('suggest: stops at coverage', array_column(mca_suggest_school_blocks($obs, 0.5, 3), 'block'), ['10.20.30.0/24']);
check('suggest: nothing observed', mca_suggest_school_blocks([]), []);
check('suggest: only invalid ips', mca_suggest_school_blocks([['ip' => 'x', 'userid' => 1]]), []);

// ------------------------------------------------ lesson codes
check('lesson code: 02.3', mca_lesson_code('02.3 Floats: Mastery Check'), '02.3');
check('lesson code: pads 2.3', mca_lesson_code('Lesson 2.3 Instruction'), '02.3');
check('lesson code: 01.10', mca_lesson_code('01.10 Review'), '01.10');
check('lesson code: none', mca_lesson_code('Unit 02 Project'), null);
check('is MC: quiz named Mastery Check', mca_is_mastery_check(['modname' => 'quiz', 'name' => '02.3 Mastery Check']), true);
check('is MC: other quiz', mca_is_mastery_check(['modname' => 'quiz', 'name' => '02.3 Vocab Quiz']), false);
check('is MC: non-quiz with the words', mca_is_mastery_check(['modname' => 'page', 'name' => 'About the Mastery Check']), false);

// ------------------------------------------------ prerequisites
function cm($id, $modname, $name, $completion = 1, $visible = true) {
    return compact('id', 'modname', 'name', 'completion', 'visible');
}
$section = [
    cm(10, 'resource', '02.2 Integers: Instruction'),
    cm(11, 'quiz', '02.2 Mastery Check'),
    cm(20, 'resource', '02.3 Floats: Instruction'),
    cm(21, 'assign', '02.3 Floats: Coding Exercise'),
    cm(22, 'page', '02.3 Floats: Extra Reading'),
    cm(23, 'quiz', '02.3 Mastery Check'),
    cm(24, 'feedback', '02.3 Feedback'),
    cm(30, 'resource', '02.4 Strings: Instruction'),
    cm(31, 'quiz', '02.4 Mastery Check'),
];
check('prereqs: instruction + coding exercise of same lesson only', mca_find_prerequisites($section, 23), [[20, 21], []]);
check('prereqs: lesson with no coding exercise', mca_find_prerequisites($section, 11), [[10], []]);
check('prereqs: modules after the quiz are ignored', in_array(24, mca_find_prerequisites($section, 23)[0], true), false);
[$p, $probs] = mca_find_prerequisites([cm(20, 'resource', '02.3 Instruction', 0), cm(23, 'quiz', '02.3 Mastery Check')], 23);
check('prereqs: completion off is refused, not applied', [$p, count($probs)], [[], 1]);
check('prereqs: completion off message explains lockout', str_contains($probs[0], 'could never unlock'), true);
[$p, $probs] = mca_find_prerequisites([cm(20, 'resource', '02.3 Instruction', 1, false), cm(23, 'quiz', '02.3 Mastery Check')], 23);
check('prereqs: hidden module skipped, reported as none found', [$p, count($probs)], [[], 1]);
check('prereqs: quiz missing', mca_find_prerequisites($section, 999)[1], ['quiz cmid 999 not found in its section']);
[, $probs] = mca_find_prerequisites([cm(5, 'quiz', 'Unit Mastery Check')], 5);
check('prereqs: no lesson code in quiz name', str_contains($probs[0], 'no lesson number'), true);

// ------------------------------------------------ availability merge
$j = mca_merge_availability(null, [20, 21]);
check('availability: fresh tree', json_decode($j, true), ['op' => '&', 'c' => [
    ['type' => 'completion', 'cm' => 20, 'e' => 1], ['type' => 'completion', 'cm' => 21, 'e' => 1]], 'showc' => [true, true]]);
check('availability: idempotent', mca_merge_availability($j, [20, 21]), $j);
$date = json_encode(['op' => '&', 'c' => [['type' => 'date', 'd' => '>=', 't' => 1790000000]], 'showc' => [true]]);
$merged = json_decode(mca_merge_availability($date, [20]), true);
check('availability: keeps existing date condition', $merged['c'][0]['type'], 'date');
check('availability: adds completion after it', $merged['c'][1], ['type' => 'completion', 'cm' => 20, 'e' => 1]);
check('availability: showc stays aligned', count($merged['showc']), count($merged['c']));
$or = json_encode(['op' => '|', 'c' => [['type' => 'group', 'id' => 4]], 'show' => true]);
$merged = json_decode(mca_merge_availability($or, [20]), true);
check('availability: OR tree nested intact', [$merged['op'], $merged['c'][0]['op']], ['&', '|']);
check('availability: no stray show key at root', array_key_exists('show', $merged), false);
check('availability: garbage json treated as empty', json_decode(mca_merge_availability('not json', [7]), true)['c'][0]['cm'], 7);
$noshowc = json_encode(['op' => '&', 'c' => [['type' => 'date', 'd' => '>=', 't' => 1]]]);
check('availability: missing showc rebuilt', json_decode(mca_merge_availability($noshowc, [3]), true)['showc'], [true, true]);

// ------------------------------------------------ intro rewrite
check('intro: password sentence removed', mca_strip_password_sentences('<p>4 questions checking what 02.3 taught about floats. Ask your teacher for the password.</p>'),
    '<p>4 questions checking what 02.3 taught about floats.</p>');
check('intro: paragraph that only held the password line removed', mca_strip_password_sentences('<p>Floats check.</p><p>Password: ask your teacher!</p>'), '<p>Floats check.</p>');
check('intro: untouched when no password mention', mca_strip_password_sentences('<p>4 questions.</p>'), '<p>4 questions.</p>');
check('intro: case-insensitive', mca_strip_password_sentences('Ready? The PASSWORD is on the board.'), 'Ready?');
check('intro: does not eat "passwords" substring words badly', mca_strip_password_sentences('Five questions.'), 'Five questions.');

// ------------------------------------------------ planning
$quiz = ['id' => 14, 'name' => '02.3 Mastery Check', 'password' => 'Kiwi63#', 'subnet' => '', 'intro' => '<p>4 questions. Ask your teacher for the password.</p>'];
$plan = mca_plan($quiz, ['subnets' => '10.20.30.0/24', 'remove_password' => true, 'prereq_cmids' => [20, 21], 'availability' => null]);
check('plan: subnet set', $plan['quiz']['subnet'], ['', '10.20.30.0/24']);
check('plan: password cleared', $plan['quiz']['password'], ['Kiwi63#', '']);
check('plan: intro rewritten', $plan['quiz']['intro'][1], '<p>4 questions.</p>');
check('plan: availability added', $plan['availability'][0], null);
$applied = ['id' => 14, 'name' => '02.3 Mastery Check', 'password' => '', 'subnet' => '10.20.30.0/24', 'intro' => '<p>4 questions.</p>'];
$again = mca_plan($applied, ['subnets' => '10.20.30.0/24', 'remove_password' => true, 'prereq_cmids' => [20, 21], 'availability' => $plan['availability'][1]]);
check('plan: re-running is a no-op', $again, ['quiz' => [], 'availability' => null]);
$keep = mca_plan($quiz, ['subnets' => null, 'remove_password' => false, 'prereq_cmids' => [], 'availability' => null]);
check('plan: nothing requested, nothing changes', $keep, ['quiz' => [], 'availability' => null]);

// ------------------------------------------------ student-facing description and backup gate
check('describe: both gates', mca_describe_for_student(['02.3 Instruction'], '10.0.0.0/8'), 'Unlocks after you complete: 02.3 Instruction. Can only be taken at school.');
check('describe: no gate', mca_describe_for_student([], null), 'Open to everyone (no gate).');
check('backup: recent', mca_backup_is_recent(1000, 1500), true);
check('backup: stale', mca_backup_is_recent(1000, 1000 + 3601), false);
check('backup: missing log', mca_backup_is_recent(null, 1500), false);
check('backup: future mtime is suspicious', mca_backup_is_recent(2000, 1500), false);

echo $failures ? "\n{$failures} of {$count} checks FAILED\n" : "OK: {$count} checks passed\n";
exit($failures ? 1 : 0);
