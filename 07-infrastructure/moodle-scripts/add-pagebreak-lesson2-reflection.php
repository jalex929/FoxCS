<?php
// add-pagebreak-lesson2-reflection.php
//
// Per Jay directly, 2026-09-10: "let's make sure the feedback module also
// does partial saves so it doesn't lose work." Seminar III's "Lesson 2
// Reflection" (mod_feedback, cmid=255, feedback id=6) was a single page --
// all 6 items (5 skill ratings + 1 open "Focus for next lesson" textarea)
// answered at once, nothing persisted server-side until the final Submit
// click, matching the audit fork's flagged risk (29 real completions on
// record, but any not-yet-submitted attempt had zero save protection).
//
// Fix, using Moodle's own native mechanism (no custom code, per the
// audit's "cheaper fix" recommendation): a page break between item 5
// (last skill rating) and item 6 (the open textarea). mod_feedback
// natively persists each completed page's answers into feedback_valuetmp
// as soon as the student clicks Next -- see feedback_save_tmp_values() in
// mod/feedback/lib.php -- so a student who finishes the 5 ratings and then
// loses their session before writing the open response keeps their
// ratings, instead of the whole attempt vanishing. This does NOT protect
// mid-typing on the final open-text page itself (no keystroke-level
// autosave the way local_foxcstelemetry gives Python's Instruction pages)
// -- flagged as a real remaining gap, not silently claimed as solved.
//
// Uses Moodle's real feedback_create_pagebreak()/feedback_move_item() API
// (mod/feedback/lib.php), not a raw item insert, so item ordering and any
// other internal bookkeeping stays consistent.
//
// Run: sudo -u www-data php add-pagebreak-lesson2-reflection.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$feedbackid = 6; // "Lesson 2 Reflection", confirmed via cmid=255.

$feedback = $DB->get_record('feedback', ['id' => $feedbackid], '*', MUST_EXIST);
if ($feedback->name !== 'Lesson 2 Reflection') {
    fwrite(STDERR, "Unexpected feedback name: {$feedback->name}\n");
    exit(1);
}

$existingbreaks = feedback_get_all_break_positions($feedbackid);
if ($existingbreaks) {
    fwrite(STDERR, "Refusing: pagebreak(s) already exist at position(s): " . implode(',', $existingbreaks) . "\n");
    exit(1);
}

$items = $DB->get_records('feedback_item', ['feedback' => $feedbackid], 'position');
$itemcount = count($items);
if ($itemcount !== 6) {
    fwrite(STDERR, "Expected 6 items, found {$itemcount}. Structure may have changed -- check before running.\n");
    exit(1);
}

$pagebreakid = feedback_create_pagebreak($feedbackid);
if (!$pagebreakid) {
    fwrite(STDERR, "feedback_create_pagebreak() returned false.\n");
    exit(1);
}

$pagebreakitem = $DB->get_record('feedback_item', ['id' => $pagebreakid], '*', MUST_EXIST);
feedback_move_item($pagebreakitem, 6); // Position 6: after the 5 ratings, before the textarea.

$final = $DB->get_records('feedback_item', ['feedback' => $feedbackid], 'position', 'id, position, typ, name');
foreach ($final as $item) {
    echo "position={$item->position} typ={$item->typ} name=\"{$item->name}\"\n";
}

echo "Done. Page 1 = the 5 skill ratings, Page 2 = the open reflection question.\n";
