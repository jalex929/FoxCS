<?php
// create-sandbox-unit02-pilot-feedback.php
//
// Deploys the Unit 02 pilot lesson's (02.1 Variables and Memory) Feedback
// module to the sandbox course, matching Lessons 01.4-01.6's established
// mod_feedback pattern exactly (rated Clarity/Difficulty/Interest +
// followups + a vocab self-check checklist), vocab swapped to this lesson's
// 5 real terms.
//
// Run: sudo -u www-data php create-sandbox-unit02-pilot-feedback.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$sectionnum = 1;

$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'sandbox-u02-pilot-feedback']);
if ($existing) {
    echo "Already exists as cmid={$existing->id}; delete it first if you want to rebuild.\n";
    exit(1);
}

$intro = '<p>2-3 minutes. This is about the lesson, not about grading you. Your honest answers help decide what changes for next time.</p>';

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'feedback';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '2.1 Feedback (sandbox pilot)';
$moduleinfo->idnumber = 'sandbox-u02-pilot-feedback';
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
    "variable: a named place in a program's memory that stores a value\nassignment operator: the = sign, used to store a value in a variable\nvalue: the actual piece of data stored in a variable\nsnake_case: joining multi-word variable names with underscores\nreassignment: assigning a new value to a variable that already exists\nNone. I can explain all 5 words");

foxcs_add_textarea($feedback, 'Most rewarding',
    'What part of this lesson felt the most rewarding, or helped you learn the most? Give a specific example.');

foxcs_add_textarea($feedback, 'Getting help',
    'If something in this lesson was difficult to understand on your own, were you able to get help? What helped, or what would have made it easier to get help?');

echo "Done. " . $DB->count_records('feedback_item', ['feedback' => $feedback->id]) . " items total. cmid={$result->coursemodule}\n";
