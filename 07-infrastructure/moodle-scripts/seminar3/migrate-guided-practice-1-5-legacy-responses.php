<?php
// migrate-guided-practice-1-5-legacy-responses.php
//
// The 4 students flagged as "not migrated" by migrate-guided-practice-1-5-
// responses.php only had answers recorded under two OLDER content-package
// generations (subContentIds regenerated on rebuild). Inspected their full
// response history directly: both older generations ask the exact same 3
// essay questions and 5 MC questions, in the same order, as the current
// generation -- confirmed by matching response text ("school trip $18/24
// people/$350 budget", "3/4 cup sugar x2 batches", "work by 5:00 PM")
// and by confirming the MC numeric-index responses (H5P.MultiChoice
// records the answer's array position, not its text -- 0=Knowledge,
// 1=Process, 2=Execution, 3=Comprehension, 4=Strategy, per the real
// content.json answer order) decode to the same correct/incorrect pattern
// as the current generation's known-correct answers. Confident enough to
// migrate by position rather than subContentId.
//
// Run: sudo -u www-data php migrate-guided-practice-1-5-legacy-responses.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

$newcmid = 277;
$newcourseid = 5;

$MC_INDEX_TO_LABEL = ['Knowledge', 'Process', 'Execution', 'Comprehension', 'Strategy'];

// [userid => [latest attemptid, generation subContentId map]]
$GENERATION_B = [ // users 64, 85, 87
    'essay' => ['e1' => 'ee391de2-dd0c-4de3-84af-671b1a3be0d0', 'e2' => '38c11986-e9cc-44e4-a083-48e2a7c3cb29', 'e3' => '6f10260d-fc1a-49a1-a47f-e0b7d1d357d3'],
    'mc'    => ['m1' => '6ffb1b3b-ecba-4ac1-9409-3a28004639d2', 'm2' => '9bc516d4-8a69-4738-b101-2bcd426adc08', 'm3' => 'b912564b-7024-464e-8f4a-00784667169a', 'm4' => '414a1e16-109e-4743-bc44-6e220171a9ea', 'm5' => 'fa127891-a6b3-4310-963d-88010c571980'],
];
$GENERATION_A = [ // user 84 only
    'essay' => ['e1' => '344e9430-01ac-4bda-9f03-61870eed833d', 'e2' => 'a0b0fcbe-cba9-4e60-a5b4-3ba1bc9e97b3', 'e3' => '58764a03-6d3b-410b-8dd9-50447da45227'],
    'mc'    => ['m1' => '1958be1b-a043-4e6d-9766-92b1885ab806', 'm2' => '852b749b-648a-4960-ac92-be7eded74a34', 'm3' => '9b367478-172d-491c-9421-716b227e0c85', 'm4' => '6f136dfd-ce9a-49be-8429-69e1da14fdce', 'm5' => 'd8106fa4-74a3-4cdc-ba43-25c6368446fb'],
];

$USERS = [
    64 => $GENERATION_B,
    85 => $GENERATION_B,
    87 => $GENERATION_B,
    84 => $GENERATION_A,
];

$migrated = 0;
foreach ($USERS as $userid => $map) {
    // Latest attempt for this user on h5pactivityid=88.
    $attempt = $DB->get_record_sql(
        "SELECT id FROM {h5pactivity_attempts} WHERE h5pactivityid = 88 AND userid = ? ORDER BY id DESC LIMIT 1",
        [$userid]
    );
    if (!$attempt) {
        fwrite(STDERR, "userid={$userid}: no attempt found, skipping.\n");
        continue;
    }

    $state = ['essay' => [], 'mc' => []];
    foreach ($map['essay'] as $fieldid => $subcontent) {
        $row = $DB->get_record('h5pactivity_attempts_results', ['attemptid' => $attempt->id, 'subcontent' => $subcontent]);
        if ($row) {
            $state['essay'][$fieldid] = $row->response;
        }
    }
    foreach ($map['mc'] as $fieldid => $subcontent) {
        $row = $DB->get_record('h5pactivity_attempts_results', ['attemptid' => $attempt->id, 'subcontent' => $subcontent]);
        if ($row && is_numeric(trim($row->response))) {
            $idx = (int) trim($row->response);
            if (isset($MC_INDEX_TO_LABEL[$idx])) {
                $state['mc'][$fieldid] = $MC_INDEX_TO_LABEL[$idx];
            }
        }
    }

    $record = new stdClass();
    $record->userid = $userid;
    $record->courseid = $newcourseid;
    $record->cmid = $newcmid;
    $record->eventtype = 'progress_state';
    $record->payload = json_encode($state);
    $record->timecreated = time();
    $DB->insert_record('local_foxcstelemetry_log', $record);
    $migrated++;

    echo "userid={$userid} (attemptid={$attempt->id}): migrated " . count($state['essay']) . " essay + " . count($state['mc']) . " MC answers.\n";
}

echo "Done. {$migrated} students migrated.\n";
