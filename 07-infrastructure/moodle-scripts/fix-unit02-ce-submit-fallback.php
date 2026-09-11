<?php
// Per Jay's direct instruction 2026-09-09: the "can't upload" fallback
// should point students at the CodeHS Sandbox specifically (paste code
// there, share the view link) rather than a generic "e.g. Google Drive"
// suggestion. CodeHS Sandbox is already the established Chromebook-day
// fallback tool referenced elsewhere in this repo (01.4-01.6 Coding
// Exercises, decisions-log.md's Project-module description) -- this just
// makes Unit 02's fallback consistent with that, and more concrete than a
// generic "backup link" example. No specific URL is stated here (none is
// confirmed anywhere in this repo) -- students already know CodeHS from
// earlier lessons; add the real link if/when Jay confirms one.
define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
\core\cron::setup_user();

$old = "<p>If you can't upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>";
$new = "<p>If you can't upload for some reason, paste your code into the CodeHS Sandbox, then paste the share link (so we can view your code) in the text box below instead. Never paste your actual code directly into the text box, only a link.</p>";

foreach ([264, 265, 266, 267] as $cmid) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);
    if (strpos($assign->intro, $old) === false) {
        fwrite(STDERR, "cmid={$cmid}: old fallback text not found, skipping.\n");
        continue;
    }
    $newintro = str_replace($old, $new, $assign->intro);
    $DB->set_field('assign', 'intro', $newintro, ['id' => $assign->id]);
    echo "cmid={$cmid}: fallback text updated.\n";
}
echo "Done.\n";
