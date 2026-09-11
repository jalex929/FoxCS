<?php
// migrate-guided-practice-1-5-responses.php
//
// Carries real existing student answers from the old H5P "1.5 -- Guided
// Practice" (h5pactivity id=88, cmid=210) into the new self-contained
// resource (cmid=277) built by rebuild-lesson1-guided-practice.php, per
// Jay directly: "copy over their answers from the DB/past attempts... I do
// not want them to lose their work or be uncertain."
//
// Real complication found while investigating: this h5pactivity's content
// package has apparently been rebuilt at least twice over its life, each
// time regenerating fresh subContentIds -- 26 of 30 students who attempted
// this activity have their most recent real answers under the CURRENT
// content generation's subContentIds (matched below, high confidence).
// The remaining ~4 students only have responses recorded under one of two
// older, now-orphaned subContentId sets -- NOT migrated by this script,
// since guessing which orphaned response maps to which of the 3 essay
// prompts / 5 MC items risks misattributing a real student's answer to the
// wrong question. Flagged in worklog.md as a real remaining gap, not
// silently dropped.
//
// Writes one 'progress_state' telemetry event per student (matching the
// new page's own applyState() shape: {essay:{e1,e2,e3}, mc:{m1..m5}}) so
// the resume mechanism already built into the page restores it on load,
// exactly like a student who saved it there themselves.
//
// Run: sudo -u www-data php migrate-guided-practice-1-5-responses.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

$oldh5pactivityid = 88;
$newcmid = 277;
$newcourseid = 5;

// Current-generation subContentId -> our new field id, confirmed directly
// against the live content.json extracted from the h5p package.
$ESSAY_MAP = [
    '8638a660-5644-4860-b6eb-937f3aadfa2a' => 'e1', // $18/24 learners/$350 budget
    '5b92c920-6592-4e7c-9a48-093e8fafad33' => 'e2', // 3/4 cup sugar recipe
    '7db2abb9-0c13-4a8b-b4e0-a2050d3a635c' => 'e3', // work by 5:00 PM
];
$MC_MAP = [
    '3221f8a3-c8a9-48d0-af21-3a9883979c97' => 'm1', // Group A/B books -> Comprehension
    'bf9d7cfd-bc52-40fe-9100-7fdaf00612ab' => 'm2', // 10% of 150 -> Knowledge
    '83f04b81-1f52-41fb-af37-15529a555abd' => 'm3', // 6x7=48 -> Execution
    '00d446a0-1e22-4ba8-b13b-84dca44d8b40' => 'm4', // testing answer choices -> Strategy
    'e8d574f4-3a28-4127-8fdb-6d4826780824' => 'm5', // -6+9=-15 -> Knowledge
];

$allsubcontent = array_merge(array_keys($ESSAY_MAP), array_keys($MC_MAP));
list($insql, $params) = $DB->get_in_or_equal($allsubcontent, SQL_PARAMS_NAMED);

$rows = $DB->get_records_sql("
    SELECT ar.id, at.userid, ar.subcontent, ar.response, ar.timecreated
      FROM {h5pactivity_attempts_results} ar
      JOIN {h5pactivity_attempts} at ON at.id = ar.attemptid
     WHERE at.h5pactivityid = :h5pactivityid
       AND ar.subcontent $insql
     ORDER BY at.userid, ar.timecreated DESC
", array_merge(['h5pactivityid' => $oldh5pactivityid], $params));

// Keep only the most recent response per (userid, subcontent).
$latest = [];
foreach ($rows as $row) {
    $key = $row->userid . '|' . $row->subcontent;
    if (!isset($latest[$key])) {
        $latest[$key] = $row;
    }
}

$byuser = [];
foreach ($latest as $row) {
    $byuser[$row->userid] = $byuser[$row->userid] ?? ['essay' => [], 'mc' => []];
    if (isset($ESSAY_MAP[$row->subcontent])) {
        $byuser[$row->userid]['essay'][$ESSAY_MAP[$row->subcontent]] = $row->response;
    } elseif (isset($MC_MAP[$row->subcontent])) {
        $byuser[$row->userid]['mc'][$MC_MAP[$row->subcontent]] = $row->response;
    }
}

$migrated = 0;
foreach ($byuser as $userid => $state) {
    $record = new stdClass();
    $record->userid = $userid;
    $record->courseid = $newcourseid;
    $record->cmid = $newcmid;
    $record->eventtype = 'progress_state';
    $record->payload = json_encode($state);
    $record->timecreated = time();
    $DB->insert_record('local_foxcstelemetry_log', $record);
    $migrated++;
    echo "userid={$userid}: migrated " . count($state['essay']) . " essay + " . count($state['mc']) . " MC answers.\n";
}

echo "Done. {$migrated} students migrated.\n";

$allolduserids = $DB->get_fieldset_sql(
    "SELECT DISTINCT at.userid FROM {h5pactivity_attempts} at WHERE at.h5pactivityid = ?",
    [$oldh5pactivityid]
);
$notmigrated = array_diff($allolduserids, array_keys($byuser));
if ($notmigrated) {
    echo "NOT migrated (only orphaned/old-generation subContentIds on record, needs manual review): " . implode(', ', $notmigrated) . "\n";
}
