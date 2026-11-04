<?php
namespace local_foxcsgradequeue;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../queue_lib.php');

/**
 * The event listener: when a student submits a queued Coding Exercise,
 * copy the file out of Moodle's file store and drop an event for the
 * grading worker. It never grades, never writes a grade, and never stops a
 * submission: if anything here fails, the submission still goes through and
 * the teacher grades it the usual way.
 */
class observer {
    public static function submission_submitted(\mod_assign\event\assessable_submitted $event): void {
        try {
            self::queue($event);
        } catch (\Throwable $e) {
            debugging('local_foxcsgradequeue: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }

    private static function queue(\mod_assign\event\assessable_submitted $event): void {
        global $DB;
        $queuedir = (string) get_config('local_foxcsgradequeue', 'queuedir');
        $allowlist = (string) get_config('local_foxcsgradequeue', 'assignments');
        $cm = get_coursemodule_from_id('assign', $event->contextinstanceid, 0, false, MUST_EXIST);
        $idnumber = (string) $cm->idnumber;
        if (!foxcs_gq_should_queue($queuedir, $idnumber, $allowlist)) {
            return;
        }
        $submission = $DB->get_record('assign_submission', ['id' => $event->objectid], 'id, userid, timemodified', MUST_EXIST);
        $user = \core_user::get_user($submission->userid, 'id, username', MUST_EXIST);

        $dir = foxcs_gq_files_dir($queuedir, (int) $submission->id);
        if (!is_dir($dir) && !mkdir($dir, 0770, true) && !is_dir($dir)) {
            throw new \RuntimeException("cannot create {$dir}");
        }
        foreach (glob($dir . '/*') ?: [] as $old) {
            unlink($old); // a resubmission replaces the earlier files
        }
        $copied = [];
        $fs = get_file_storage();
        $stored = $fs->get_area_files($event->contextid, 'assignsubmission_file', 'submission_files',
            $submission->id, 'filename', false);
        foreach ($stored as $file) {
            $name = foxcs_gq_safe_filename($file->get_filename());
            $file->copy_content_to($dir . '/' . $name);
            $copied[$name] = $dir . '/' . $name;
        }
        $payload = foxcs_gq_build_event((int) $submission->id, (string) $user->username, $idnumber,
            (int) $submission->timemodified, $copied);
        foxcs_gq_write_event($queuedir, $payload, time() . bin2hex(random_bytes(4)));
    }
}
