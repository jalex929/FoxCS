<?php
// One-off setup script: renames the mdl_resource.name field for every existing
// Seminar III resource from "Week N ..." to "Unit XX ..." to match the
// 2026-08-29 renumbering. Section placement is untouched -- display name only.
// Safe to re-run (idempotent once names are already "Unit").
// Run: sudo -u www-data php rename-seminar3-resource-names.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

$resources = $DB->get_records_sql(
    "SELECT r.id, r.name
       FROM {resource} r
       JOIN {course_modules} cm ON cm.instance = r.id
       JOIN {modules} md ON md.id = cm.module AND md.name = 'resource'
      WHERE cm.course = ?",
    [$course->id]
);

$updated = 0;
foreach ($resources as $r) {
    if (!preg_match('/^Week (\d+)(.*)$/', $r->name, $m)) {
        continue;
    }
    $unit = (int) $m[1] - 1;
    $newname = sprintf('Unit %02d%s', $unit, $m[2]);
    $DB->set_field('resource', 'name', $newname, ['id' => $r->id]);
    echo "{$r->name} -> {$newname}\n";
    $updated++;
}

echo "Updated $updated resource names\n";
