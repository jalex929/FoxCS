<?php
// local/foxcstelemetry/report.php
//
// Minimal time-on-task report, added 2026-09-08 per Jay: "we need to track
// time spent if possible so I can see this for each student." log.php has
// been writing raw per-event rows (userid, cmid, eventtype, timecreated)
// since 2026-09-04, but nothing ever read them back into a view a teacher
// could actually look at -- this is that view.
//
// Time-on-content per student per activity is approximated as
// (last event timecreated - first event timecreated) for that user+cmid
// pair, per telemetry-and-analytics.md's own "Time-on-content" definition.
// This is a real limitation, not hidden: a single 'viewed' event with no
// follow-up interaction reads as 0 seconds even if the student sat on the
// page a while, since there's no periodic heartbeat event yet, only
// on-interaction/on-complete events. Good enough for "did they engage, and
// roughly how long," not a precise stopwatch.
//
// GET ?courseid=N  (defaults to the sandbox course if omitted)

require(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/course/lib.php');

$courseid = optional_param('courseid', 0, PARAM_INT);
if (!$courseid) {
    $sandbox = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo']);
    $courseid = $sandbox ? $sandbox->id : SITEID;
}

$course = get_course($courseid);
require_login($course);
$coursecontext = context_course::instance($course->id);
require_capability('moodle/site:viewreports', $coursecontext);

$PAGE->set_url('/local/foxcstelemetry/report.php', ['courseid' => $courseid]);
$PAGE->set_context($coursecontext);
$PAGE->set_title('Time-on-Task Report: ' . format_string($course->fullname));
$PAGE->set_pagelayout('report');

echo $OUTPUT->header();
echo $OUTPUT->heading('Time-on-Task Report: ' . format_string($course->fullname));
echo html_writer::tag('p', 'Approximate time per student per activity, from telemetry event timestamps. See this file\'s own header comment for what this does and doesn\'t capture.', ['style' => 'color:#555;max-width:60em;']);

$modinfo = get_fast_modinfo($course);

$rows = $DB->get_records_sql(
    "SELECT CONCAT(userid, '-', cmid) AS id, userid, cmid,
            MIN(timecreated) AS first_seen, MAX(timecreated) AS last_seen,
            COUNT(*) AS event_count,
            MAX(CASE WHEN eventtype = 'lesson_complete' THEN 1 ELSE 0 END) AS completed
     FROM {local_foxcstelemetry_log}
     WHERE courseid = :courseid
     GROUP BY userid, cmid
     ORDER BY userid, cmid",
    ['courseid' => $course->id]
);

if (!$rows) {
    echo html_writer::tag('p', 'No telemetry events logged for this course yet.');
    echo $OUTPUT->footer();
    exit;
}

$byuser = [];
foreach ($rows as $row) {
    $byuser[$row->userid][] = $row;
}

foreach ($byuser as $userid => $userrows) {
    $user = $DB->get_record('user', ['id' => $userid], 'id, firstname, lastname');
    $userlabel = $user ? fullname($user) : "user #{$userid}";

    echo $OUTPUT->heading($userlabel, 3);
    $table = new html_table();
    $table->head = ['Activity', 'First seen', 'Last seen', 'Time on task', 'Events', 'Completed'];
    $totalseconds = 0;

    foreach ($userrows as $row) {
        $cmname = 'cmid ' . $row->cmid . ' (not in this course anymore)';
        try {
            $cmname = $modinfo->get_cm($row->cmid)->name;
        } catch (Exception $e) {
            // Module deleted/moved since the events were logged -- keep the fallback label.
        }
        $seconds = max(0, $row->last_seen - $row->first_seen);
        $totalseconds += $seconds;
        $table->data[] = [
            $cmname,
            userdate($row->first_seen, '%b %d, %I:%M %p'),
            userdate($row->last_seen, '%b %d, %I:%M %p'),
            format_time_hms($seconds),
            $row->event_count,
            $row->completed ? 'Yes' : 'No',
        ];
    }

    echo html_writer::table($table);
    echo html_writer::tag('p', html_writer::tag('strong', 'Total logged time this course: ' . format_time_hms($totalseconds)));
}

/**
 * Formats a duration in seconds as "Hh Mm Ss" (omitting leading zero units).
 */
function format_time_hms($seconds) {
    $seconds = (int) $seconds;
    $h = intdiv($seconds, 3600);
    $m = intdiv($seconds % 3600, 60);
    $s = $seconds % 60;
    $parts = [];
    if ($h > 0) { $parts[] = $h . 'h'; }
    if ($h > 0 || $m > 0) { $parts[] = $m . 'm'; }
    $parts[] = $s . 's';
    return implode(' ', $parts);
}

echo $OUTPUT->footer();
