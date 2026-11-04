<?php
// Tests for queue_lib.php. Plain PHP, no Moodle, no database.
//   php 07-infrastructure/local-plugins/foxcsgradequeue/tests/test_queue_lib.php
// Exits non-zero on any failure. Run in CI by .github/workflows/grading-queue-tests.yml.

define('FOXCS_GRADEQUEUE_TEST', true);
require __DIR__ . '/../queue_lib.php';

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

// ------------------------------------------------ activity ID numbers
foreach (['lesson_02_06_coins_to_points', 'a', 'x9_'] as $ok) {
    check("idnumber ok: {$ok}", foxcs_gq_valid_idnumber($ok), true);
}
foreach (['', '../etc/passwd', 'Lesson_02', 'a b', 'a-b', 'a.json', str_repeat('a', 101), "a\n"] as $bad) {
    check('idnumber rejected: ' . json_encode($bad), foxcs_gq_valid_idnumber($bad), false);
}
check('idnumber: 100 chars is the limit', foxcs_gq_valid_idnumber(str_repeat('a', 100)), true);

// ------------------------------------------------ allowlist
check('allowlist: commas, spaces, newlines, case, duplicates',
    foxcs_gq_parse_allowlist(" lesson_02_06 , Lesson_02_07\nlesson_02_06,,  "), ['lesson_02_06', 'lesson_02_07']);
check('allowlist: invalid entries dropped', foxcs_gq_parse_allowlist('ok_1, ../x, bad-name'), ['ok_1']);
check('allowlist: empty', foxcs_gq_parse_allowlist(''), []);

// ------------------------------------------------ should we queue?
check('queue: configured and allowlisted', foxcs_gq_should_queue('/q', 'lesson_02_06', 'lesson_02_06'), true);
check('queue: not allowlisted', foxcs_gq_should_queue('/q', 'lesson_02_07', 'lesson_02_06'), false);
check('queue: no queue folder means off', foxcs_gq_should_queue('', 'lesson_02_06', 'lesson_02_06'), false);
check('queue: activity with no ID number', foxcs_gq_should_queue('/q', '', 'lesson_02_06'), false);
check('queue: uppercase ID number is not silently matched', foxcs_gq_should_queue('/q', 'Lesson_02_06', 'lesson_02_06'), false);
check('queue: substring is not a match', foxcs_gq_should_queue('/q', 'lesson_02', 'lesson_02_06'), false);

// ------------------------------------------------ filenames
check('filename: plain', foxcs_gq_safe_filename('exercise.py'), 'exercise.py');
check('filename: path stripped', foxcs_gq_safe_filename('../../etc/exercise.py'), 'exercise.py');
check('filename: windows path stripped', foxcs_gq_safe_filename('C:\\Users\\x\\exercise.py'), 'exercise.py');
check('filename: odd characters replaced', foxcs_gq_safe_filename('my exercise (1).py'), 'my_exercise__1_.py');
check('filename: no hidden files', foxcs_gq_safe_filename('.bashrc'), 'bashrc');
check('filename: never empty', foxcs_gq_safe_filename('...'), 'submission');
check('filename: never empty (slash)', foxcs_gq_safe_filename('/'), 'submission');
check('filename: length capped', strlen(foxcs_gq_safe_filename(str_repeat('a', 300) . '.py')), 120);

// ------------------------------------------------ event shape
$event = foxcs_gq_build_event(42, 'swiftfox', 'lesson_02_06', 1768226400, ['exercise.py' => '/q/files/moodle-sub-42/exercise.py']);
check('event: worker shape', $event, [
    'submission_id' => 'moodle-sub-42',
    'student_id' => 'swiftfox',
    'assignment_id' => 'lesson_02_06',
    'submitted_at' => '2026-01-12T14:00:00Z',
    'files' => [['name' => 'exercise.py', 'path' => '/q/files/moodle-sub-42/exercise.py']],
]);
check('event: no files is still an event (the worker holds it for the teacher)',
    foxcs_gq_build_event(1, 'u', 'a', 0, [])['files'], []);
check('event: numeric filename stays a string', foxcs_gq_build_event(1, 'u', 'a', 0, [123 => '/p'])['files'][0]['name'], '123');
check('files dir', foxcs_gq_files_dir('/srv/q/', 42), '/srv/q/files/moodle-sub-42');
check('files dir: no trailing slash', foxcs_gq_files_dir('/srv/q', 7), '/srv/q/files/moodle-sub-7');

// ------------------------------------------------ atomic write
$root = sys_get_temp_dir() . '/gq-test-' . bin2hex(random_bytes(4));
$path = foxcs_gq_write_event($root . '/', $event, '1768226400-ab/../cd');
check('write: lands in incoming/ with a safe unique name', $path, "{$root}/incoming/moodle-sub-42-1768226400abcd.json");
check('write: content round-trips', json_decode(file_get_contents($path), true), $event);
check('write: readable JSON, slashes unescaped', strpos(file_get_contents($path), '"/q/files/moodle-sub-42/exercise.py"') !== false, true);
check('write: ends with a newline', substr(file_get_contents($path), -1), "\n");
check('write: no .tmp left behind', glob("{$root}/incoming/*.tmp"), []);
$second = foxcs_gq_write_event($root, $event, 'second');
check('write: a second event for the same submission does not overwrite the first', [is_file($path), is_file($second)], [true, true]);

$blocked = $root . '/blocked';
file_put_contents($blocked, 'a file where the queue folder should be');
try {
    @foxcs_gq_write_event($blocked, $event, 'x');
    check('write: unwritable queue raises', 'no exception', 'exception');
} catch (RuntimeException $e) {
    check('write: unwritable queue raises', str_starts_with($e->getMessage(), 'cannot create '), true);
}
mkdir($root . '/ro/incoming', 0770, true);
chmod($root . '/ro/incoming', 0500);
if (function_exists('posix_geteuid') && posix_geteuid() === 0) {
    $count++; // root ignores permissions, so this case can't be shown here
} else {
    try {
        @foxcs_gq_write_event($root . '/ro', $event, 'x');
        check('write: read-only incoming raises', 'no exception', 'exception');
    } catch (RuntimeException $e) {
        check('write: read-only incoming raises', str_starts_with($e->getMessage(), 'cannot write '), true);
    }
}
chmod($root . '/ro/incoming', 0770);
exec('rm -rf ' . escapeshellarg($root));

echo "{$count} checks, {$failures} failures\n";
exit($failures ? 1 : 0);
