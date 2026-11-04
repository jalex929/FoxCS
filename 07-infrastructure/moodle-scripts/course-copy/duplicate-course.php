<?php
// duplicate-course.php -- makes a working copy of a live course that cannot
// touch student grades. DRY RUN by default.
//
// What the copy gets: every section, activity, resource, quiz, question,
// rubric, and file. What it never gets: users, enrolments, role assignments,
// grades, grade history, submissions, quiz attempts, completion state,
// comments, badge awards, or logs. Those backup settings are forced off (and
// unlocked first, so a site default can't turn them back on).
//
// After the restore it:
//   - hides the copy from students and enrols no one;
//   - pairs every live module with its copy (same section, type and name, in
//     order) and stops if they don't line up;
//   - rewrites every Instruction page file in the copy so its telemetry CMID
//     and its links point at the copy, not at the live activities. Without
//     this, using a copied page would log progress, completion and the
//     Instruction grade against the LIVE course;
//   - reports any live activity IDs still left in the copy.
//
// Safety:
//   - Prints the plan and changes nothing unless --apply is passed.
//   - --apply refuses unless backup.log is under an hour old (CLAUDE.md
//     "Data Safety"), or you pass --i-ran-the-backup.
//   - Never writes to the source course. Refuses if the target shortname exists.
//
// Use:
//   php duplicate-course.php --source=foxcs-python --shortname=foxcs-python-dev        # read the plan
//   php duplicate-course.php --source=foxcs-python --shortname=foxcs-python-dev --apply
//   Then enrol yourself and the test student: ../enrol-admin-as-teacher.php, ../create-foxcs-test-student.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');
require_once(__DIR__ . '/copy_lib.php');
require_once(__DIR__ . '/../mastery-check-access/mca_lib.php');

[$options] = cli_get_params([
    'source' => 'foxcs-python', 'shortname' => 'foxcs-python-dev', 'fullname' => '',
    'apply' => false, 'i-ran-the-backup' => false,
    'backup-log' => '/home/jay/moodle-backups/backup.log',
]);

// User data the copy must never carry. Each is forced to 0.
const NO_USER_DATA = ['users', 'role_assignments', 'comments', 'userscompletion', 'logs', 'grade_histories'];

$source = $DB->get_record('course', ['shortname' => $options['source']], '*', MUST_EXIST);
$shortname = $options['shortname'];
$fullname = $options['fullname'] ?: $source->fullname . ' (working copy)';
if (!copy_valid_shortname($shortname)) {
    cli_error("--shortname must be 3-100 lowercase letters, digits or hyphens: {$shortname}");
}
if ($shortname === $source->shortname || $DB->record_exists('course', ['shortname' => $shortname])) {
    cli_error("A course with shortname {$shortname} already exists. Pick another, or delete that one by hand first.");
}

echo "Source:  {$source->fullname} ({$source->shortname}, id {$source->id})\n";
echo "Copy:    {$fullname} ({$shortname}), hidden, same category, no one enrolled\n";
echo "Never copied: " . implode(', ', NO_USER_DATA) . ", plus grades, submissions and attempts\n";
if (!$options['apply']) {
    echo "\nDry run. Nothing changed. Re-run with --apply after the backup.\n";
    exit(0);
}

if (!$options['i-ran-the-backup']) {
    $mtime = @filemtime($options['backup-log']);
    if (!mca_backup_is_recent($mtime === false ? null : $mtime, time())) {
        cli_error("Refusing to write: {$options['backup-log']} is missing, unreadable, or over an hour old.\n"
            . "Run /home/jay/moodle-backups/backup_moodle.sh, confirm it finished, then re-run with --i-ran-the-backup.");
    }
}

$admin = get_admin();

// ---- 1. Back up the source with every user-data setting forced off.
$bc = new backup_controller(backup::TYPE_1COURSE, $source->id, backup::FORMAT_MOODLE,
    backup::INTERACTIVE_NO, backup::MODE_GENERAL, $admin->id);
$plan = $bc->get_plan();
foreach (NO_USER_DATA as $name) {
    if ($plan->setting_exists($name)) {
        $setting = $plan->get_setting($name);
        $setting->set_status(backup_setting::NOT_LOCKED);
        $setting->set_value(0);
    }
}
if ($plan->setting_exists('users') && $plan->get_setting('users')->get_value()) {
    cli_error('Backup would still include users. Stopping before anything is written.');
}
$bc->execute_plan();
$backupfile = $bc->get_results()['backup_destination'];
$bc->destroy();

// ---- 2. Restore it into a new, hidden course.
$backupid = 'foxcs_copy_' . time();
$backuppath = make_backup_temp_directory($backupid);
$backupfile->extract_to_pathname(get_file_packer('application/vnd.moodle.backup'), $backuppath);
$backupfile->delete();

$copyid = restore_dbops::create_new_course($fullname, $shortname, $source->category);
$rc = new restore_controller($backupid, $copyid, backup::INTERACTIVE_NO, backup::MODE_GENERAL,
    $admin->id, backup::TARGET_NEW_COURSE);
foreach (['users' => 0, 'role_assignments' => 0, 'userscompletion' => 0, 'comments' => 0, 'logs' => 0, 'grade_histories' => 0,
          'course_fullname' => $fullname, 'course_shortname' => $shortname] as $name => $value) {
    if ($rc->get_plan()->setting_exists($name)) {
        $rc->get_plan()->get_setting($name)->set_value($value);
    }
}
if (!$rc->execute_precheck()) {
    $results = $rc->get_precheck_results();
    $rc->destroy();
    delete_course($copyid, false);
    cli_error("Restore precheck failed. The empty course was removed:\n" . print_r($results['errors'] ?? $results, true));
}
$rc->execute_plan();
$rc->destroy();
$DB->set_field('course', 'visible', 0, ['id' => $copyid]);
$DB->set_field('course', 'visibleold', 0, ['id' => $copyid]);
echo "Restored into course id {$copyid}, hidden.\n";

// ---- 3. Pair live and copied modules, in course order.
function course_modules_in_order(int $courseid): array {
    $out = [];
    foreach (get_fast_modinfo($courseid)->get_cms() as $cm) {
        $out[] = ['section' => (int) $cm->sectionnum, 'modname' => $cm->modname, 'name' => $cm->name, 'cmid' => (int) $cm->id];
    }
    return $out;
}
rebuild_course_cache($copyid, true);
[$map, $problems] = copy_pair_modules(course_modules_in_order($source->id), course_modules_in_order($copyid));
if ($problems) {
    echo "\nThe copy does not mirror the live course, so its pages were NOT rewritten and still point at live activities.\n";
    echo "Hide or delete course id {$copyid} before anyone opens it.\n  - " . implode("\n  - ", $problems) . "\n";
    exit(1);
}

// ---- 4. Point every copied page file at the copy.
$fs = get_file_storage();
$rewritten = 0;
$leftover = [];
foreach ($map as $livecmid => $copycmid) {
    $context = context_module::instance($copycmid);
    foreach ($fs->get_area_files($context->id, 'mod_resource', 'content', false, 'filepath, filename', false) as $file) {
        if (!preg_match('/\.html?$/i', $file->get_filename())) {
            continue;
        }
        [$html, $n, $unmapped] = copy_rewrite_html($file->get_content(), $map, (int) $source->id, $copyid);
        foreach ($unmapped as $id) {
            $leftover["{$file->get_filename()} in copy cmid {$copycmid}: id {$id}"] = true;
        }
        if ($n === 0) {
            continue;
        }
        $record = ['contextid' => $context->id, 'component' => 'mod_resource', 'filearea' => 'content',
            'itemid' => $file->get_itemid(), 'filepath' => $file->get_filepath(), 'filename' => $file->get_filename(),
            'sortorder' => $file->get_sortorder()];
        $file->delete();
        $fs->create_file_from_string($record, $html);
        $rewritten += $n;
    }
}
echo "Rewrote {$rewritten} live IDs in copied page files.\n";

// ---- 5. Verify: no users came across, nothing still points at live activities.
$enrolled = $DB->count_records_sql('SELECT COUNT(1) FROM {user_enrolments} ue JOIN {enrol} e ON e.id = ue.enrolid WHERE e.courseid = ?', [$copyid]);
$grades = $DB->count_records_sql('SELECT COUNT(1) FROM {grade_grades} g JOIN {grade_items} i ON i.id = g.itemid WHERE i.courseid = ?', [$copyid]);
echo "Enrolled users in the copy: {$enrolled}. Grades in the copy: {$grades}.\n";
if ($leftover) {
    echo "IDs left unmapped in page files (check each one; links to other courses are fine):\n  - "
        . implode("\n  - ", array_keys($leftover)) . "\n";
}
if ($enrolled || $grades) {
    echo "UNEXPECTED: the copy has users or grades. Hide it and investigate before using it.\n";
    exit(1);
}
echo "\nDone. Enrol yourself and the test student, then open it at /course/view.php?id={$copyid}\n";
