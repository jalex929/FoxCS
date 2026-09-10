<?php
// local/foxcstelemetry/log.php
//
// Prototype endpoint for the 2026-09-04 structural brainstorm's "Option C":
// a custom FoxCS lesson/resource page (tabbed HTML, drag-to-match, code
// stepper, etc. -- the existing component library) calls this directly from
// its own JS to log interaction telemetry and mark itself complete, instead
// of adopting SCORM or rebuilding into native H5P/question types. See
// chat-log.md's 2026-09-04 entry for the fuller reasoning and comparison.
//
// GET  ?action=bootstrap&cmid=N
//      -> {sesskey, userid, cmid} for the current logged-in, enrolled user.
//         A static HTML resource has no server-side templating, so the page
//         fetches its own sesskey this way on load rather than having one
//         injected at render time.
//
// POST action=log&sesskey=...&cmid=N&eventtype=...&payload=<json>&complete=1
//      -> logs one telemetry row; if complete=1, marks the course module
//         complete for the current user. Requires manual completion tracking
//         (COMPLETION_TRACKING_MANUAL) to already be enabled on that module --
//         this does not force an override, it acts the same as the student
//         ticking Moodle's own manual-completion checkbox.
//
// GET  ?action=state&cmid=N
//      -> {state: <payload object>|null}, the most recent 'progress_state'
//         event this user logged for this cmid. Added 2026-09-10 so a
//         bundled Instruction+Practice page can resume a student where they
//         left off instead of forcing Learn + all Practice nodes to be
//         finished in one sitting -- see decisions-log.md's matching entry.
//         No new table: a page just logs its whole resumable-progress object
//         as a normal 'progress_state' row via the existing log action, and
//         this reads the latest one back. Same require_login()/enrollment
//         check as every other action here, so a student can only ever read
//         their own progress on a cmid they're actually enrolled in.

define('AJAX_SCRIPT', true);
require(__DIR__ . '/../../config.php');

$cmid = required_param('cmid', PARAM_INT);
list($course, $cm) = get_course_and_cm_from_cmid($cmid);
require_login($course, false, $cm);

header('Content-Type: application/json');

$action = required_param('action', PARAM_ALPHA);

if ($action === 'bootstrap') {
    echo json_encode([
        'sesskey' => sesskey(),
        'userid' => $USER->id,
        'cmid' => $cmid,
    ]);
    exit;
}

if ($action === 'state') {
    $rows = $DB->get_records_sql(
        "SELECT id, payload FROM {local_foxcstelemetry_log}
          WHERE userid = :userid AND cmid = :cmid AND eventtype = :eventtype
          ORDER BY timecreated DESC, id DESC",
        ['userid' => $USER->id, 'cmid' => $cmid, 'eventtype' => 'progress_state'],
        0, 1
    );
    $row = reset($rows);
    echo json_encode(['state' => $row ? json_decode($row->payload) : null]);
    exit;
}

if ($action !== 'log') {
    http_response_code(400);
    echo json_encode(['error' => 'unknown action']);
    exit;
}

require_sesskey();

$eventtype = required_param('eventtype', PARAM_ALPHANUMEXT);
$payload = required_param('payload', PARAM_RAW);
$markcomplete = optional_param('complete', 0, PARAM_INT);

json_decode($payload);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'payload must be valid JSON']);
    exit;
}

$record = new stdClass();
$record->userid = $USER->id;
$record->courseid = $course->id;
$record->cmid = $cmid;
$record->eventtype = $eventtype;
$record->payload = $payload;
$record->timecreated = time();
$DB->insert_record('local_foxcstelemetry_log', $record);

$result = ['logged' => true, 'completed' => false];

if ($markcomplete) {
    $completion = new completion_info($course);
    if ($completion->is_enabled($cm) && $cm->completion == COMPLETION_TRACKING_MANUAL) {
        $completion->update_state($cm, COMPLETION_COMPLETE, $USER->id);
        $result['completed'] = true;
    } else {
        $result['completionerror'] = 'completion not enabled or not set to manual tracking on this activity';
    }
}

echo json_encode($result);
