<?php
// migrate-1-6-legacy-responses.php
//
// 1.6 Independent Practice (h5pactivityid=89, new cmid=278) had 4 students
// unmigrated by migrate-remaining-responses.php. Investigated each:
// - userid=3: response text is literally "test answer for completion
//   check" on every field -- a test/QA pass, not a real student. Excluded.
// - userid=84: real answers under one orphaned generation (confirmed
//   against known-correct MC answers -- all 10 correct, consistent
//   engagement).
// - userid=64, 87: real answers under a THIRD orphaned generation
//   (different subContentIds again, same 3 essay + 10 MC questions in the
//   same order, confirmed by matching response text).
//
// Run: sudo -u www-data php migrate-1-6-legacy-responses.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');

\core\cron::setup_user();

$newcmid = 278;
$newcourseid = 5;
$h5pactivityid = 89;

$GENERATION_2 = [ // user 84
    'essay' => ['e1' => '85a58eba-c16d-448a-a216-42f7e69e4c1f', 'e2' => 'b014cb8f-7c72-4f31-8805-586563b578e2', 'e3' => '30f07893-723b-4b4b-b289-23375cec4e06'],
    'mc'    => ['m1' => 'd476ee46-3103-4300-a08f-9b829f670882', 'm2' => '190d715f-3428-4179-9459-f000138d1fb1', 'm3' => '8a2c1151-228b-4177-a2bf-828e9e2bb286', 'm4' => '2be2da42-6aee-4f7b-a986-ba3eb928668f', 'm5' => '815465ca-36d3-4af5-997a-a206d4dfafae', 'm6' => '513c6da2-d6b5-46df-9352-12f3a94ef99e', 'm7' => 'd537dce4-a5c5-4e08-a857-c84b456484ec', 'm8' => '4d9a92fe-c96e-42cc-ad89-aabcf466ab8e', 'm9' => '7292627a-f0a2-419a-aaa5-de2ff475d349', 'm10' => 'e62f04c6-bab6-4adb-b8e5-9ee23ca00f25'],
];
$GENERATION_3 = [ // users 64, 87
    'essay' => ['e1' => '47a125c2-b5c9-488d-9b8f-0c3b36868c67', 'e2' => 'd52eb7cd-be0e-4847-95e1-8a11c1d49318', 'e3' => '0f463c65-8b3b-4c85-bede-1fefefaf4b9a'],
    'mc'    => ['m1' => '3ee47e55-cdb9-4bc3-b7bb-b3c786f40fb1', 'm2' => '7b880940-b28e-4e50-9c57-ed04ab6cb8a7', 'm3' => '289edfd6-0226-4b0a-a45d-d95a7a50bb08', 'm4' => '88c323c9-cf4a-47e7-8912-60f4964ef664', 'm5' => '1bbc2013-4ad8-41f2-881a-f262a6ca652e', 'm6' => '1424ca69-bbfa-47e3-9ebb-165e09262a71', 'm7' => '69728ea2-da8c-4b0e-9c20-649251302422', 'm8' => '5437a6fc-c8d2-4e54-83dc-0af48acf23e9', 'm9' => '428b25a2-7336-423a-8e14-8cc04cc2e8fb', 'm10' => 'd5064c44-5635-4238-bcb1-812e16718fd7'],
];

// MC responses in these older generations are numeric answer-array
// indices, same convention confirmed for the 1.5 legacy migration.
$MC_INDEX_TO_LABEL = ['Knowledge', 'Process', 'Execution', 'Comprehension', 'Strategy'];

$USERS = [
    84 => $GENERATION_2,
    64 => $GENERATION_3,
    87 => $GENERATION_3,
];

foreach ($USERS as $userid => $map) {
    $attempt = $DB->get_record_sql(
        "SELECT id FROM {h5pactivity_attempts} WHERE h5pactivityid = ? AND userid = ? ORDER BY id DESC LIMIT 1",
        [$h5pactivityid, $userid]
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

    echo "userid={$userid} (attemptid={$attempt->id}): migrated " . count($state['essay']) . " essay + " . count($state['mc']) . " MC answers.\n";
}

echo "Done. userid=3 deliberately excluded (test/QA data, not a real student).\n";
