<?php
// mca_lib.php -- Mastery Check Access: pure logic, no Moodle dependency.
//
// Added 2026-11-03, per Jay: replace manually handed-out Mastery Check
// passwords ("not sustainable") with gates that enforce themselves, chosen
// for classroom facilitation:
//
//   1. Lesson prerequisites: the quiz unlocks once that lesson's Instruction
//      (and Coding Exercise, where one exists) is complete. Native Moodle
//      activity-completion availability, shown to students so they always
//      see what is left to do.
//   2. School network: Moodle's native quiz "Require network address"
//      (quiz.subnet). Attempts only from the school's address range. Works
//      on sub days with nobody in the loop.
//   3. Daily class code (revised same day, per Jay): one code per course per
//      day, derived from a secret on the server and the Chicago date. It is
//      posted once in class (board, projector, sub plans), never handed out
//      per student, and a scheduled job writes it into every Mastery Check's
//      quiz password. Yesterday's code stops working when the date changes.
//   4. The existing after-the-fact bell-schedule check
//      (05-grader/check-submission-windows.py) stays as the backstop.
//
// Every function here is pure so it can be tested without a Moodle install:
//   php 07-infrastructure/moodle-scripts/mastery-check-access/tests/test_mca_lib.php
// The Moodle-facing CLI scripts in this folder only gather data, call these
// functions, and write what they return.
//
// IPv4 only. Moodle's subnet field also accepts IPv6, but the school
// network and this instance are IPv4; mca_normalize_subnets() rejects
// anything else rather than guessing.

// ------------------------------------------------------------------ subnets

/**
 * Validates and normalizes a subnet list into Moodle's quiz.subnet format
 * (comma-separated). Accepts the IPv4 forms Moodle's address_in_subnet()
 * understands: full address (10.1.2.3), CIDR (10.1.2.0/24), last-octet
 * range (10.1.2.10-40), and dotted prefix (10.1.2 or 10.1.2.).
 *
 * @return array{0: string, 1: string[]} [normalized list, errors]
 */
function mca_normalize_subnets(string $raw): array {
    $out = [];
    $errors = [];
    foreach (preg_split('/[\s,]+/', trim($raw), -1, PREG_SPLIT_NO_EMPTY) as $entry) {
        if (mca_parse_subnet($entry) === null) {
            $errors[] = "not a supported IPv4 subnet: {$entry}";
            continue;
        }
        $entry = rtrim($entry, '.');
        if (!in_array($entry, $out, true)) {
            $out[] = $entry;
        }
    }
    if (!$out && !$errors) {
        $errors[] = 'no subnets given';
    }
    return [implode(',', $out), $errors];
}

function mca_octets_ok(array $octets): bool {
    foreach ($octets as $o) {
        if (!preg_match('/^\d{1,3}$/', $o) || (int)$o > 255) {
            return false;
        }
    }
    return true;
}

/**
 * Parses one subnet entry into a matcher description, or null if invalid.
 * @return array|null ['type' => cidr|range|prefix|exact, ...]
 */
function mca_parse_subnet(string $entry): ?array {
    if (preg_match('#^(\d+\.\d+\.\d+\.\d+)/(\d{1,2})$#', $entry, $m)) {
        $bits = (int)$m[2];
        if (!mca_octets_ok(explode('.', $m[1])) || $bits > 32) {
            return null;
        }
        return ['type' => 'cidr', 'base' => ip2long($m[1]), 'bits' => $bits];
    }
    if (preg_match('#^(\d+\.\d+\.\d+)\.(\d+)-(\d+)$#', $entry, $m)) {
        if (!mca_octets_ok(array_merge(explode('.', $m[1]), [$m[2], $m[3]])) || (int)$m[2] > (int)$m[3]) {
            return null;
        }
        return ['type' => 'range', 'prefix' => $m[1], 'lo' => (int)$m[2], 'hi' => (int)$m[3]];
    }
    $trimmed = rtrim($entry, '.');
    $octets = explode('.', $trimmed);
    if ($trimmed === '' || count($octets) > 4 || !mca_octets_ok($octets)) {
        return null;
    }
    if (count($octets) === 4) {
        return ['type' => 'exact', 'ip' => $trimmed];
    }
    if (count($octets) < 2) {
        return null; // a single-octet prefix would allow a sixteen-million-address block
    }
    return ['type' => 'prefix', 'prefix' => $trimmed];
}

/** True if $ip falls inside any entry of a Moodle-format subnet list. */
function mca_ip_in_subnets(string $ip, string $subnets): bool {
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return false;
    }
    foreach (explode(',', $subnets) as $entry) {
        $s = mca_parse_subnet(trim($entry));
        if ($s === null) {
            continue;
        }
        switch ($s['type']) {
            case 'cidr':
                $mask = $s['bits'] === 0 ? 0 : (~0 << (32 - $s['bits'])) & 0xFFFFFFFF;
                if ((ip2long($ip) & $mask) === ($s['base'] & $mask)) {
                    return true;
                }
                break;
            case 'range':
                $parts = explode('.', $ip);
                $last = (int)array_pop($parts);
                if (implode('.', $parts) === $s['prefix'] && $last >= $s['lo'] && $last <= $s['hi']) {
                    return true;
                }
                break;
            case 'prefix':
                if (str_starts_with($ip . '.', $s['prefix'] . '.')) {
                    return true;
                }
                break;
            default: // exact
                if ($ip === $s['ip']) {
                    return true;
                }
        }
    }
    return false;
}

/**
 * Suggests the school's network from observed in-class attempt IPs.
 * Groups addresses into /24 blocks and returns the blocks that together
 * cover at least $coverage of observations, largest first. Blocks seen
 * from fewer than $min_users distinct users are dropped (one student's
 * home connection is not the school).
 *
 * @param array $observations list of ['ip' => string, 'userid' => int]
 * @return array list of ['block' => 'a.b.c.0/24', 'events' => n, 'users' => n, 'share' => float]
 */
function mca_suggest_school_blocks(array $observations, float $coverage = 0.8, int $min_users = 3): array {
    $blocks = [];
    $total = 0;
    foreach ($observations as $o) {
        if (!filter_var($o['ip'] ?? '', FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            continue;
        }
        $parts = explode('.', $o['ip']);
        $key = "{$parts[0]}.{$parts[1]}.{$parts[2]}.0/24";
        $blocks[$key]['events'] = ($blocks[$key]['events'] ?? 0) + 1;
        $blocks[$key]['users'][$o['userid']] = true;
        $total++;
    }
    if ($total === 0) {
        return [];
    }
    $rows = [];
    foreach ($blocks as $key => $b) {
        if (count($b['users']) >= $min_users) {
            $rows[] = ['block' => $key, 'events' => $b['events'], 'users' => count($b['users']), 'share' => $b['events'] / $total];
        }
    }
    usort($rows, fn($a, $b) => [$b['events'], $a['block']] <=> [$a['events'], $b['block']]);
    $picked = [];
    $covered = 0.0;
    foreach ($rows as $r) {
        if ($covered >= $coverage) {
            break;
        }
        $picked[] = $r;
        $covered += $r['share'];
    }
    return $picked;
}

// ------------------------------------------------------------------ prerequisites

/** "02.3 Floats: Mastery Check" -> "02.3"; "2.3 ..." -> "02.3"; null if none. */
function mca_lesson_code(string $name): ?string {
    if (!preg_match('/\b(\d{1,2})\.(\d{1,2})\b/', $name, $m)) {
        return null;
    }
    return sprintf('%02d.%d', (int)$m[1], (int)$m[2]);
}

function mca_is_mastery_check(array $cm): bool {
    return $cm['modname'] === 'quiz' && stripos($cm['name'], 'mastery check') !== false;
}

/**
 * Picks a Mastery Check's prerequisites from its section, in course order:
 * modules before the quiz, with the same lesson code, whose name marks
 * them as the Instruction or the Coding Exercise.
 *
 * @param array $section_cms ordered list of ['id','modname','name','completion'(int),'visible'(bool)]
 * @return array{0: int[], 1: string[]} [prerequisite cmids, problems]
 */
function mca_find_prerequisites(array $section_cms, int $quiz_cmid): array {
    $quiz = null;
    $before = [];
    foreach ($section_cms as $cm) {
        if ($cm['id'] === $quiz_cmid) {
            $quiz = $cm;
            break;
        }
        $before[] = $cm;
    }
    if ($quiz === null) {
        return [[], ["quiz cmid {$quiz_cmid} not found in its section"]];
    }
    $code = mca_lesson_code($quiz['name']);
    if ($code === null) {
        return [[], ["no lesson number in quiz name '{$quiz['name']}'"]];
    }
    $prereqs = [];
    $problems = [];
    foreach ($before as $cm) {
        if (mca_lesson_code($cm['name']) !== $code) {
            continue;
        }
        if (!preg_match('/instruction|coding exercise/i', $cm['name'])) {
            continue;
        }
        if (!$cm['visible']) {
            continue; // a hidden module can never be completed by a student
        }
        if ((int)$cm['completion'] === 0) {
            // A completion condition on an untracked activity can never be met:
            // that would lock every student out. Refuse rather than apply it.
            $problems[] = "'{$cm['name']}' (cmid {$cm['id']}) has completion tracking off; enable it or the quiz could never unlock";
            continue;
        }
        $prereqs[] = $cm['id'];
    }
    if (!$prereqs && !$problems) {
        $problems[] = "no Instruction or Coding Exercise for lesson {$code} found before the quiz";
    }
    return [$prereqs, $problems];
}

/**
 * Adds "must be complete" conditions for $cmids to an existing Moodle
 * availability tree, keeping every condition already there (dates, groups,
 * anything a teacher set by hand). Idempotent. Conditions are shown to
 * students (greyed out with the reason), never hidden.
 *
 * @return string availability JSON
 */
function mca_merge_availability(?string $existing_json, array $cmids): string {
    $tree = $existing_json ? json_decode($existing_json, true) : null;
    if (!is_array($tree) || !isset($tree['op'], $tree['c'])) {
        $tree = ['op' => '&', 'c' => [], 'showc' => []];
    }
    if ($tree['op'] !== '&') {
        // An existing OR / NOT tree: nest it intact, then AND ours alongside it.
        $tree = ['op' => '&', 'c' => [$tree], 'showc' => [true]];
    }
    $tree['showc'] = $tree['showc'] ?? array_fill(0, count($tree['c']), true);
    unset($tree['show']);
    $already = [];
    foreach ($tree['c'] as $c) {
        if (($c['type'] ?? '') === 'completion' && (int)($c['e'] ?? -1) === 1) {
            $already[(int)$c['cm']] = true;
        }
    }
    foreach ($cmids as $cmid) {
        if (!isset($already[$cmid])) {
            $tree['c'][] = ['type' => 'completion', 'cm' => (int)$cmid, 'e' => 1];
            $tree['showc'][] = true;
            $already[$cmid] = true;
        }
    }
    return json_encode($tree);
}

// ------------------------------------------------------------------ intro text

/**
 * Removes sentences that tell students to get a password, so the intro
 * matches how the quiz actually unlocks now. Only whole sentences
 * mentioning "password" are removed; everything else is kept as is.
 */
function mca_strip_password_sentences(string $intro): string {
    $out = preg_replace('/[^.!?<>]*\bpassword\b[^.!?<>]*[.!?]?\s*/i', '', $intro);
    $out = preg_replace('#<p>\s*</p>#i', '', $out);
    return trim($out);
}

// ------------------------------------------------------------------ daily class code

const MCA_TZ = 'America/Chicago';
const MCA_CODE_DIGITS = 6;

/** The school-calendar date (Y-m-d, Chicago time) for a Unix timestamp. */
function mca_school_date(int $timestamp): string {
    return (new DateTimeImmutable('@' . $timestamp))->setTimezone(new DateTimeZone(MCA_TZ))->format('Y-m-d');
}

/**
 * Today's class code for a course: HMAC-SHA256(secret, course|date) reduced to
 * MCA_CODE_DIGITS digits (random digits plus a final day digit). Digits only, so there is no capital-letter or
 * O-versus-0 confusion on a Chromebook keyboard. Deterministic, so the
 * rotation job, the teacher's morning message, and a printed week of codes
 * for sub plans always agree without storing anything.
 */
function mca_daily_code(string $secret, string $course, string $ymd, int $digits = MCA_CODE_DIGITS): string {
    if (strlen($secret) < 32) {
        throw new InvalidArgumentException('class-code secret must be at least 32 characters');
    }
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ymd)) {
        throw new InvalidArgumentException("date must be Y-m-d, got {$ymd}");
    }
    if ($digits < 2) {
        throw new InvalidArgumentException('a class code needs at least 2 digits');
    }
    $hash = hash_hmac('sha256', strtolower($course) . '|' . $ymd, $secret);
    $n = hexdec(substr($hash, 0, 12)) % (10 ** ($digits - 1));
    // The last digit is the day number mod 10, so a code can never match the
    // code from any of the previous 9 days. "Yesterday's code fails today" is
    // guaranteed by construction, not left to chance.
    $daynum = intdiv((new DateTimeImmutable($ymd, new DateTimeZone('UTC')))->getTimestamp(), 86400);
    return str_pad((string)$n, $digits - 1, '0', STR_PAD_LEFT) . ($daynum % 10);
}

/**
 * Reads the class-code secret. It lives only on the server (never in this
 * repo), readable by the web server user and nobody else.
 */
function mca_load_secret(string $path): string {
    if (!is_readable($path)) {
        throw new RuntimeException("class-code secret not readable at {$path}; see README.md, Daily class code setup");
    }
    $perms = fileperms($path) & 0777;
    if ($perms & 0007) {
        throw new RuntimeException(sprintf('class-code secret %s is readable by everyone (mode %o); run chmod 640', $path, $perms));
    }
    $secret = trim((string)file_get_contents($path));
    if (strlen($secret) < 32) {
        throw new RuntimeException("class-code secret at {$path} is shorter than 32 characters");
    }
    return $secret;
}

/** Dates and codes for the next $days days starting at $ymd, for sub plans. */
function mca_code_calendar(string $secret, string $course, string $ymd, int $days): array {
    $out = [];
    $d = new DateTimeImmutable($ymd, new DateTimeZone(MCA_TZ));
    for ($i = 0; $i < $days; $i++) {
        $day = $d->modify("+{$i} day");
        $out[] = ['date' => $day->format('Y-m-d'), 'weekday' => $day->format('l'), 'code' => mca_daily_code($secret, $course, $day->format('Y-m-d'))];
    }
    return $out;
}

/**
 * Which quizzes need their password set to today's code. Idempotent: the
 * job runs every few minutes and only writes when something is stale.
 * @param array $quizzes list of ['id' => int, 'password' => string]
 * @return int[] quiz ids to update
 */
function mca_rotation_targets(array $quizzes, string $code): array {
    return array_values(array_map(fn($q) => (int)$q['id'],
        array_filter($quizzes, fn($q) => $q['password'] !== $code)));
}

/** True if the teacher has not yet been sent the code for $today. */
function mca_should_notify(?string $last_notified_date, string $today): bool {
    return $last_notified_date !== $today;
}

const MCA_CODE_SENTENCE = "Enter today's class code. It is posted in class.";

/**
 * Rewrites a quiz intro for the class-code gate: drops old "ask your teacher
 * for the password" sentences and adds one standard sentence. Idempotent.
 */
function mca_intro_for_class_code(string $intro): string {
    $out = mca_strip_password_sentences(str_replace('<p>' . MCA_CODE_SENTENCE . '</p>', '', $intro));
    return trim($out . '<p>' . MCA_CODE_SENTENCE . '</p>');
}

// ------------------------------------------------------------------ planning

/**
 * Computes the change set for one Mastery Check. Pure: callers decide
 * whether to print it (dry run) or write it (--apply).
 *
 * @param array $quiz ['id','name','password','subnet','intro']
 * @param array $opts ['subnets' => string|null, 'password' => ?string (today's code, or null to leave),
 *                     'class_code_intro' => bool, 'prereq_cmids' => int[]|null, 'availability' => ?string]
 * @return array ['quiz' => [field => [old, new]], 'availability' => [old, new]|null]
 */
function mca_plan(array $quiz, array $opts): array {
    $plan = ['quiz' => [], 'availability' => null];
    if ($opts['subnets'] !== null && $quiz['subnet'] !== $opts['subnets']) {
        $plan['quiz']['subnet'] = [$quiz['subnet'], $opts['subnets']];
    }
    if (array_key_exists('password', $opts) && $opts['password'] !== null && $quiz['password'] !== $opts['password']) {
        $plan['quiz']['password'] = [$quiz['password'], $opts['password']];
    }
    if (!empty($opts['class_code_intro'])) {
        $intro = mca_intro_for_class_code($quiz['intro']);
        if ($intro !== $quiz['intro']) {
            $plan['quiz']['intro'] = [$quiz['intro'], $intro];
        }
    }
    if (!empty($opts['prereq_cmids'])) {
        $new = mca_merge_availability($opts['availability'] ?? null, $opts['prereq_cmids']);
        if ($new !== ($opts['availability'] ?? null)) {
            $plan['availability'] = [$opts['availability'] ?? null, $new];
        }
    }
    return $plan;
}

/** Plain-language student view of a planned gate, for the dry-run report. */
function mca_describe_for_student(array $prereq_names, ?string $subnets, bool $class_code = false): string {
    $lines = [];
    if ($class_code) {
        $lines[] = "Needs today's class code, posted in class.";
    }
    if ($prereq_names) {
        $lines[] = 'Unlocks after you complete: ' . implode(', ', $prereq_names) . '.';
    }
    if ($subnets) {
        $lines[] = 'Can only be taken at school.';
    }
    return $lines ? implode(' ', $lines) : 'Open to everyone (no gate).';
}

/** True if the backup log was written within $max_age_seconds of $now. */
function mca_backup_is_recent(?int $log_mtime, int $now, int $max_age_seconds = 3600): bool {
    return $log_mtime !== null && $log_mtime <= $now && ($now - $log_mtime) <= $max_age_seconds;
}
