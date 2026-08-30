<?php
define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

$activities = $DB->get_records_sql(
    "SELECT h.id, h.name
       FROM {h5pactivity} h
       JOIN {course_modules} cm ON cm.instance = h.id
       JOIN {modules} md ON md.id = cm.module AND md.name = 'h5pactivity'
      WHERE cm.course = ? AND h.name LIKE '%(Interactive)%'",
    [$course->id]
);

$updated = 0;
foreach ($activities as $a) {
    $newname = trim(str_replace('(Interactive)', '', $a->name));
    $newname = preg_replace('/\s+/', ' ', $newname);
    $DB->set_field('h5pactivity', 'name', $newname, ['id' => $a->id]);
    echo "{$a->name} -> {$newname}\n";
    $updated++;
}
rebuild_course_cache($course->id, true);
echo "Updated $updated activities\n";
