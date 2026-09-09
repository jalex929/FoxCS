<?php
// fix-lesson2-reflection.php
//
// Rebuilds Lesson 2 Reflection (mdl_feedback id=6, cmid=255) into the leaner
// format Jay asked for 2026-09-09: a skill self-assessment table only, plus
// ONE forward-looking question -- no mistake-analysis pile. Jay's own words:
// "I think folks should just self-assess their skills and not reflect on
// mistakes... I do not want the reflections to be busy work, i want it to
// make sense and be smooth."
//
// This DELETES items 41-48 (two full mistake write-ups, an estimation
// example, a calculator check, a generic confidence rating -- 8 items of
// busy work stacked after a perfectly good 5-skill rating table) and adds
// one new textarea item in their place. Uses feedback_delete_item(), the
// real module API (not raw SQL) -- it correctly deletes each item's
// mdl_feedback_value rows, cleans up dependitem/dependvalue links, and
// renumbers remaining items.
//
// SAFETY: 19 of 72 enrolled students had already completed this reflection
// before this rebuild. Every existing response (247 value rows across all
// items) was exported first to
// FoxCS/07-infrastructure/moodle-scripts/../../../../tmp-backups (see
// session notes) -- nothing here is destroyed without a prior export, and
// the standing nightly Moodle DB backup was also re-run immediately before
// this script per CLAUDE.md's Data Safety rule. Deleting items 41-48 does
// remove those 19 students' answers to the mistake/estimation/calculator/
// confidence questions specifically (the exact content being eliminated by
// design) from the live gradebook view; the backup TSV is the durable copy.
//
// Run: sudo -u www-data php fix-lesson2-reflection.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$feedback = $DB->get_record('feedback', ['id' => 6], '*', MUST_EXIST);
echo "Editing feedback id={$feedback->id} ({$feedback->name})\n";

// ---------------------------------------------------------------------------
// 1. Tighten the intro to name skills specifically (was "how the week went").
// ---------------------------------------------------------------------------
$newintro = '<p>A few minutes. This is about which Lesson 2 skills feel solid and which ones still need work, not about grading you. Answer honestly, it helps decide what we practice next.</p>';
$DB->set_field('feedback', 'intro', $newintro, ['id' => $feedback->id]);
echo "Updated intro.\n";

// ---------------------------------------------------------------------------
// 2. Delete the busy-work items: two mistake write-ups, estimation example,
//    calculator check, confidence rating. Items 36-40 (the 5-skill rating
//    table) are untouched.
// ---------------------------------------------------------------------------
$to_delete = [41, 42, 43, 44, 45, 46, 47, 48];
foreach ($to_delete as $itemid) {
    $item = $DB->get_record('feedback_item', ['id' => $itemid, 'feedback' => $feedback->id]);
    if (!$item) {
        echo "  [skip] item {$itemid} not found (already removed?)\n";
        continue;
    }
    feedback_delete_item($itemid, false); // renumber once at the end, not per-delete
    echo "  [deleted] item {$itemid} ({$item->name})\n";
}
feedback_renumber_items($feedback->id);
echo "Renumbered remaining items.\n";

// ---------------------------------------------------------------------------
// 3. Add the one forward-looking question, matching Lesson 2's action items.
// ---------------------------------------------------------------------------
function foxcs_add_textarea($feedback, $name, $label) {
    $itemobj = feedback_get_item_class('textarea');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = [
        'id' => 0, 'feedback' => $feedback->id, 'template' => 0,
        'name' => $name, 'label' => $label, 'presentation' => '',
        'typ' => 'textarea', 'hasvalue' => 1, 'position' => $position,
        'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
        'itemwidth' => '60', 'itemheight' => '4',
    ];
    $record['presentation'] = $record['itemwidth'] . '|' . $record['itemheight'];
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [textarea] {$name} -> item id={$saved->id}\n";
    return $saved;
}

foxcs_add_textarea($feedback, 'Focus for next lesson',
    'Based on your ratings above, what is one thing you want to focus on before Lesson 3?');

$remaining = $DB->count_records('feedback_item', ['feedback' => $feedback->id]);
echo "Done. {$remaining} items total (was 13).\n";
