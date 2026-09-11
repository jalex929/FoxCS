<?php
// build-lesson-01-04-feedback.php
//
// Builds Lesson 01.4's (Printing Output) Feedback/Reflection step as a native
// Moodle mod_feedback activity -- per Jay's mid-session request for a real
// reflection component on 01.4 ("what felt challenging or what made sense").
// This is NOT new content -- 11_feedback.html already has a fully authored
// 6-question reflection page (per 02-authoring-system/feedback-collection.md's
// design), ported here verbatim into native items. mod_feedback (not mod_quiz
// or mod_lesson) is the deliberate choice: it's Moodle's non-graded survey
// activity, matching feedback-collection.md's explicit rule that this data
// "should never feed into a student's academic grade."
//
// Real gap this closes: NO lesson in this course (01.1/01.2/01.3 checked
// directly against the DB) has a Feedback module built in Moodle yet -- it's
// existed only as the old MVP self-saving-HTML file. This is the first one.
//
// Item types use Moodle's own production item-class API (feedback_get_item_
// class()->set_data()->save_item()), the exact same code path the real
// question-editing UI and Moodle's own test generator use -- not hand-rolled
// presentation-string building, same principle as this session's other
// scripts using save_question() instead of raw DB inserts.
//
// Run: sudo -u www-data php build-lesson-01-04-feedback.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 1. Create the feedback activity itself.
// ---------------------------------------------------------------------------
$intro = '<p>2-3 minutes. This is about the lesson, not about grading you. Your honest answers help decide what changes for next time.</p>';

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'feedback';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 0; // hidden until verified/reviewed, same as tonight's other builds.
$moduleinfo->name = '01.4 Feedback';
$moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->anonymous = FEEDBACK_ANONYMOUS_NO; // identified via pseudonymous codename, matches every other activity in this course.
$moduleinfo->email_notification = 0;
$moduleinfo->multiple_submit = 0; // one reflection per student per lesson.
$moduleinfo->autonumbering = 1;
$moduleinfo->publish_stats = 0; // don't show aggregate stats to students.
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->page_after_submit_editor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->page_after_submit = '';
$moduleinfo->page_after_submitformat = FORMAT_HTML;
$moduleinfo->site_after_submit = '';
$moduleinfo->completion = 1; // manual, matches the Coding Exercise Assignment's pattern.

$result = create_module($moduleinfo);
$feedback = $DB->get_record('feedback', ['id' => $result->instance], '*', MUST_EXIST);
echo "Created feedback cmid={$result->coursemodule} instanceid={$feedback->id} visible=0\n";

// ---------------------------------------------------------------------------
// 2. Add items, ported from 11_feedback.html's 6 questions (8 real fields:
//    3 rated scales, 2 optional followup textareas, 1 vocab checklist, 2 open
//    reflection prompts).
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
    $presentation .= FEEDBACK_MULTICHOICERATED_ADJUST_SEP . '1'; // horizontal.
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
        'itemwidth' => '60', 'itemheight' => '6',
    ];
    $record['presentation'] = $record['itemwidth'] . '|' . $record['itemheight'];
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [textarea] {$name} -> item id={$saved->id}\n";
    return $saved;
}

function foxcs_add_checkbox($feedback, $name, $label, $values) {
    $itemobj = feedback_get_item_class('multichoice');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = [
        'id' => 0, 'feedback' => $feedback->id, 'template' => 0,
        'name' => $name, 'label' => $label, 'presentation' => '',
        'typ' => 'multichoice', 'hasvalue' => 1, 'position' => $position,
        'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
        'subtype' => 'c', 'horizontal' => 0, 'hidenoselect' => 1, 'ignoreempty' => 0,
        'values' => $values,
    ];
    $presentation = str_replace("\n", FEEDBACK_MULTICHOICE_LINE_SEP, trim($record['values']));
    $record['presentation'] = $record['subtype'] . FEEDBACK_MULTICHOICE_TYPE_SEP . $presentation;
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [checkbox] {$name} -> item id={$saved->id}\n";
    return $saved;
}

foxcs_add_rated($feedback, 'Clarity',
    'How clear was it what you were being asked to do in this lesson?',
    "1/1 - Confusing\n2/2\n3/3\n4/4\n5/5 - Totally clear");

foxcs_add_textarea($feedback, 'Clarity followup',
    'If any part was unclear, describe what it was. (Leave blank if nothing was unclear.)');

foxcs_add_rated($feedback, 'Difficulty',
    'How difficult was this lesson for you?',
    "1/1 - Too easy\n2/2\n3/3\n4/4\n5/5 - Too difficult");

foxcs_add_textarea($feedback, 'Difficulty followup',
    'What part of this lesson was the most difficult for you? (Leave blank if nothing felt difficult.)');

foxcs_add_rated($feedback, 'Interest',
    'How interesting did this lesson feel to you?',
    "1/1 - Not interesting\n2/2\n3/3\n4/4\n5/5 - Very interesting");

foxcs_add_checkbox($feedback, 'Vocab self-check',
    "This lesson taught 5 words. Check any that you still find hard to explain in your own words.\n(Or check \"None\" if you can explain all 5.)",
    "function: a reusable block of code, like print()\nstring: text wrapped in quote marks\noutput: what your program displays on the screen\nargument: the value written inside the parentheses\nSyntaxError: an error from breaking one of Python's grammar rules\nNone. I can explain all 5 words");

foxcs_add_textarea($feedback, 'Most rewarding',
    'What part of this lesson felt the most rewarding, or helped you learn the most? Give a specific example.');

foxcs_add_textarea($feedback, 'Getting help',
    'If something in this lesson was difficult to understand on your own, were you able to get help? What helped, or what would have made it easier to get help?');

echo "Done. " . $DB->count_records('feedback_item', ['feedback' => $feedback->id]) . " items total. cmid={$result->coursemodule}\n";
