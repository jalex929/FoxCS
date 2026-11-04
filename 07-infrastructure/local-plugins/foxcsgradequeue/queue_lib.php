<?php
// Pure logic for the grading queue: no Moodle calls, no database, so it can
// be unit-tested with plain PHP (tests/test_queue_lib.php). The observer
// gathers facts from Moodle and passes them in.

defined('MOODLE_INTERNAL') || defined('FOXCS_GRADEQUEUE_TEST') || die();

/** Activity ID numbers become file and assignment names, so only a safe set is allowed. */
function foxcs_gq_valid_idnumber(string $idnumber): bool {
    return preg_match('/^[a-z0-9_]{1,100}$/D', $idnumber) === 1;
}

/** The allowlist setting, normalized: trimmed, lowercased, deduplicated, invalid entries dropped. */
function foxcs_gq_parse_allowlist(string $setting): array {
    $ids = [];
    foreach (preg_split('/[\s,]+/', strtolower($setting)) as $id) {
        if ($id !== '' && foxcs_gq_valid_idnumber($id)) {
            $ids[$id] = true;
        }
    }
    return array_keys($ids);
}

/** Queue a submission only when the queue is configured and the activity is allowlisted. */
function foxcs_gq_should_queue(string $queuedir, string $idnumber, string $allowlist): bool {
    return $queuedir !== '' && foxcs_gq_valid_idnumber($idnumber)
        && in_array($idnumber, foxcs_gq_parse_allowlist($allowlist), true);
}

/** A submitted filename reduced to a safe basename. Never empty, never a path. */
function foxcs_gq_safe_filename(string $name): string {
    $base = basename(str_replace('\\', '/', $name));
    $safe = preg_replace('/[^A-Za-z0-9._-]/', '_', $base);
    $safe = ltrim($safe, '.');
    return $safe === '' ? 'submission' : substr($safe, 0, 120);
}

/** Stable across resubmissions of the same Moodle submission, so the worker can tell them apart from new work. */
function foxcs_gq_submission_id(int $submissionid): string {
    return 'moodle-sub-' . $submissionid;
}

/**
 * The event the worker reads (grader/on_submission.py's parse_event shape).
 * $files maps each stored filename to the absolute path it was copied to.
 * The student is identified only by Moodle username, which is pseudonymous.
 */
function foxcs_gq_build_event(int $submissionid, string $username, string $idnumber, int $timesubmitted, array $files): array {
    $list = [];
    foreach ($files as $name => $path) {
        $list[] = ['name' => (string) $name, 'path' => (string) $path];
    }
    return [
        'submission_id' => foxcs_gq_submission_id($submissionid),
        'student_id' => $username,
        'assignment_id' => $idnumber,
        'submitted_at' => gmdate('Y-m-d\TH:i:s\Z', $timesubmitted),
        'files' => $list,
    ];
}

/** Where a submission's files are copied: <queuedir>/files/<submission_id>/. */
function foxcs_gq_files_dir(string $queuedir, int $submissionid): string {
    return rtrim($queuedir, '/') . '/files/' . foxcs_gq_submission_id($submissionid);
}

/**
 * Writes the event atomically: a .tmp file renamed into incoming/, so the
 * worker never reads a half-written event. Returns the final path.
 */
function foxcs_gq_write_event(string $queuedir, array $event, string $unique): string {
    $incoming = rtrim($queuedir, '/') . '/incoming';
    if (!is_dir($incoming) && !mkdir($incoming, 0770, true) && !is_dir($incoming)) {
        throw new RuntimeException("cannot create {$incoming}");
    }
    $final = $incoming . '/' . $event['submission_id'] . '-' . preg_replace('/[^A-Za-z0-9]/', '', $unique) . '.json';
    $tmp = $final . '.tmp';
    $json = json_encode($event, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . "\n";
    if (file_put_contents($tmp, $json) === false || !rename($tmp, $final)) {
        @unlink($tmp);
        throw new RuntimeException("cannot write {$final}");
    }
    return $final;
}
