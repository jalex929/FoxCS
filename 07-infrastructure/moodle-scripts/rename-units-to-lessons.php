<?php
// Renames "Unit 00" -> "Orientation" and "Unit NN" -> "Lesson N" (drops leading
// zero) across every Seminar III section name and every resource/h5pactivity
// name in the course, including the "01.N --" item-prefix convention -> "N.M --".
// Safe to re-run: no-ops once names no longer match "Unit ".

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

function transform($name) {
    // Section-name style: "Unit 00: Title" / "Unit 07: Title"
    if (preg_match('/^Unit 00: (.*)$/', $name, $m)) {
        return "Orientation: {$m[1]}";
    }
    if (preg_match('/^Unit 0*(\d+): (.*)$/', $name, $m)) {
        return "Lesson {$m[1]}: {$m[2]}";
    }
    // Resource-name style: "Unit 00 <Rest>" / "Unit 01 <Rest>"
    if (preg_match('/^Unit 00 (.*)$/', $name, $m)) {
        return "Orientation {$m[1]}";
    }
    if (preg_match('/^Unit 0*(\d+) (.*)$/', $name, $m)) {
        return "Lesson {$m[1]} {$m[2]}";
    }
    // Item-prefix style: "01.6 -- Guided Practice" -> "1.6 -- Guided Practice"
    if (preg_match('/^0*(\d+)\.(\d+) -- (.*)$/', $name, $m)) {
        return "{$m[1]}.{$m[2]} -- {$m[3]}";
    }
    return null; // no change
}

$sectionchanges = 0;
foreach ($DB->get_records('course_sections', ['course' => $course->id]) as $section) {
    if (!$section->name) continue;
    $new = transform($section->name);
    if ($new !== null && $new !== $section->name) {
        $DB->set_field('course_sections', 'name', $new, ['id' => $section->id]);
        echo "[section {$section->section}] '{$section->name}' -> '{$new}'\n";
        $sectionchanges++;
    }
}

$resourcechanges = 0;
foreach ($DB->get_records('resource', ['course' => $course->id]) as $r) {
    $new = transform($r->name);
    if ($new !== null && $new !== $r->name) {
        $DB->set_field('resource', 'name', $new, ['id' => $r->id]);
        echo "[resource] '{$r->name}' -> '{$new}'\n";
        $resourcechanges++;
    }
}

$h5pchanges = 0;
foreach ($DB->get_records_sql(
    "SELECT h.* FROM {h5pactivity} h JOIN {course_modules} cm ON cm.instance = h.id
     JOIN {modules} m ON m.id = cm.module AND m.name = 'h5pactivity' WHERE cm.course = ?",
    [$course->id]
) as $h) {
    $new = transform($h->name);
    if ($new !== null && $new !== $h->name) {
        $DB->set_field('h5pactivity', 'name', $new, ['id' => $h->id]);
        echo "[h5pactivity] '{$h->name}' -> '{$new}'\n";
        $h5pchanges++;
    }
}

rebuild_course_cache($course->id, true);
echo "\nDone. Sections: $sectionchanges, resources: $resourcechanges, h5p activities: $h5pchanges\n";
