<?php
// rebuild-lesson1-reflection.php
//
// Replaces the old "1.10 -- Lesson 1 Reflection" H5P activity (h5pactivity
// id=33, cmid=83, package "unit-01-reflection-merged.h5p") with a native
// mod_feedback activity in the same lean format as the rebuilt Lesson 2
// Reflection (see fix-lesson2-reflection.php, same session): a skill
// self-assessment table (Need Help/Still Practicing/Strong) plus ONE
// forward-looking question. No mistake analysis.
//
// The old H5P activity was 16 separate essay boxes -- no skill rating at
// all, just open-ended text on baseline mistakes, error types, per-question
// confidence, and strengths/priorities restated twice in different words.
// Jay, 2026-09-09: "I think folks should just self-assess their skills and
// not reflect on mistakes... I do not want the reflections to be busy work,
// i want it to make sense and be smooth."
//
// The 4 skills below are drawn from lesson-1-plan's "# 2. Learning Targets"
// (STOP->FIND->CONNECT->TRY->CHECK problem-solving routine; the 5-category
// Error Analysis system; interpreting ACT Math baseline results), collapsed
// from 10 granular targets into 4 coherent, nameable skills -- matching
// Lesson 2's precedent of ~5 named skills, not a 10-row table.
//
// SAFETY: 8 of 72 enrolled students had already completed the old H5P
// reflection. All 8 students' full essay responses were exported first
// (see session notes / lesson1-reflection-responses-backup.tsv) and the
// standing nightly Moodle DB backup was re-run immediately before this
// script per CLAUDE.md's Data Safety rule. The old activity is HIDDEN and
// renamed below, not deleted -- its content and the 8 students' answers
// remain recoverable in the live DB, just off the visible course page.
//
// Run: sudo -u www-data php rebuild-lesson1-reflection.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 1. Hide + rename the old H5P reflection (archive in place, don't delete).
// ---------------------------------------------------------------------------
$oldcm = $DB->get_record('course_modules', ['id' => 83, 'course' => $course->id], '*', MUST_EXIST);
set_coursemodule_visible(83, 0);
$DB->set_field('h5pactivity', 'name', '1.10 -- Lesson 1 Reflection (old format, archived 2026-09-09)', ['id' => 33]);
rebuild_course_cache($course->id, true);
echo "Archived old H5P reflection: cmid=83 hidden, renamed.\n";

// ---------------------------------------------------------------------------
// 2. Create the new mod_feedback Lesson 1 Reflection.
// ---------------------------------------------------------------------------
$intro = '<p>A few minutes. This is about which Lesson 1 skills feel solid and which ones still need work, not about grading you. Answer honestly, it helps decide what we practice next.</p>';

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'feedback';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2; // Lesson 1: Academic Problem-Solving
$moduleinfo->visible = 1;
$moduleinfo->name = 'Lesson 1 Reflection';
$moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->anonymous = FEEDBACK_ANONYMOUS_NO;
$moduleinfo->email_notification = 0;
$moduleinfo->multiple_submit = 0;
$moduleinfo->autonumbering = 1;
$moduleinfo->publish_stats = 0;
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->page_after_submit_editor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->page_after_submit = '';
$moduleinfo->page_after_submitformat = FORMAT_HTML;
$moduleinfo->site_after_submit = '';
$moduleinfo->completion = 1;

$result = create_module($moduleinfo);
$feedback = $DB->get_record('feedback', ['id' => $result->instance], '*', MUST_EXIST);
echo "Created feedback cmid={$result->coursemodule} instanceid={$feedback->id} visible=1\n";

// ---------------------------------------------------------------------------
// 3. Item helpers (rated / textarea) -- same pattern as build-lesson2-reflection.php.
// ---------------------------------------------------------------------------
function foxcs_add_rated($feedback, $name, $label, $values) {
    $itemobj = feedback_get_item_class('multichoicerated');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = [
        'id' => 0, 'feedback' => $feedback->id, 'template' => 0,
        'name' => $name, 'label' => $label, 'presentation' => '',
        'typ' => 'multichoicerated', 'hasvalue' => 1, 'position' => $position,
        'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
        'subtype' => 'r', 'horizontal' => 1, 'hidenoselect' => 1, 'ignoreempty' => 0,
        'values' => $values,
    ];
    $presentation = $itemobj->prepare_presentation_values_save(trim($record['values']),
        FEEDBACK_MULTICHOICERATED_VALUE_SEP2, FEEDBACK_MULTICHOICERATED_VALUE_SEP);
    $presentation .= FEEDBACK_MULTICHOICERATED_ADJUST_SEP . '1';
    $record['presentation'] = $record['subtype'] . FEEDBACK_MULTICHOICERATED_TYPE_SEP . $presentation;
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [rated] {$name} -> item id={$saved->id}\n";
    return $saved;
}

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

// ---------------------------------------------------------------------------
// 4. Items: 4 named skills, rated, then one forward-looking question.
// ---------------------------------------------------------------------------
$rating_scale = "1/Need Help\n2/Still Practicing\n3/Strong";

foxcs_add_rated($feedback, 'Skill: Problem-Solving Routine',
    'Using the five-question routine (What info do I have? What am I finding? What skill helps? Try it. Check it.)', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Identifying Error Types',
    'Telling apart the five error types (Knowledge, Process, Execution, Comprehension, Strategy)', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Responding to a Mistake',
    'Deciding what to do next after making an error', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Reading My Baseline',
    'Understanding what my ACT Math baseline results mean for what to practice', $rating_scale);

foxcs_add_textarea($feedback, 'Focus for next lesson',
    'Based on your ratings above, what is one thing you want to focus on before Lesson 2?');

$total = $DB->count_records('feedback_item', ['feedback' => $feedback->id]);
echo "Done. {$total} items total. cmid={$result->coursemodule}\n";
