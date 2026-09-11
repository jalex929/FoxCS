<?php
// build-lesson2-reflection.php
//
// Builds Seminar III Lesson 2's Reflection as a native mod_feedback activity
// (non-graded survey, per feedback-collection.md's rule this data never
// feeds a student's academic grade) -- ported from lesson-2-plan's "# 88.
// Student Reflection" (8 prompts), with two real corrections applied:
//
// 1. Prompts 1-2 ("Which Lesson 2 skill feels strongest?" / "...still needs
//    practice?") are NOT copied verbatim -- per the standing rule (Jay's
//    direct correction on Week 3's reflection doc, same anti-pattern),
//    open-ended "which skill" questions get replaced with a rate-EACH-of-
//    the-5-real-skills table (Strong / Still Practicing / Need Help), so
//    students see what the actual target skills were instead of guessing.
// 2. Error Analysis (a Day-2 chip in the week-at-a-glance with no dedicated
//    build) is folded in here rather than built as a separate activity --
//    the plan's own Error Analysis spec calls for inspecting "at least 2"
//    incorrect solutions, so this reflection asks for TWO mistake+category
//    pairs, not the plan's original single mistake prompt. Flagged as a
//    scope call, not a silent drop -- see decisions-log.md/worklog.md.
//
// Follows build-lesson-01-04-feedback.php's exact API pattern
// (feedback_get_item_class()->set_data()->save_item(), the real
// question-editing code path, not hand-rolled DB inserts) and its
// page_after_submit raw-scalar-field gotcha on create_module().
//
// Run: sudo -u www-data php build-lesson2-reflection.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-seminar3'], '*', MUST_EXIST);

// ---------------------------------------------------------------------------
// 1. Create the feedback activity.
// ---------------------------------------------------------------------------
$intro = '<p>A few minutes. This is about how the week went for you, not about grading you. Your honest answers help decide what changes for next time.</p>';

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'feedback';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 3; // Lesson 2: Numbers & Operations
$moduleinfo->visible = 1;
$moduleinfo->name = 'Lesson 2 Reflection';
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
// 2. Item helpers (rated / radio / textarea).
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

function foxcs_add_radio($feedback, $name, $label, $values) {
    $itemobj = feedback_get_item_class('multichoice');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = [
        'id' => 0, 'feedback' => $feedback->id, 'template' => 0,
        'name' => $name, 'label' => $label, 'presentation' => '',
        'typ' => 'multichoice', 'hasvalue' => 1, 'position' => $position,
        'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
        'subtype' => 'r', 'horizontal' => 1, 'hidenoselect' => 1, 'ignoreempty' => 0,
        'values' => $values,
    ];
    $presentation = str_replace("\n", FEEDBACK_MULTICHOICE_LINE_SEP, trim($record['values']));
    $record['presentation'] = $record['subtype'] . FEEDBACK_MULTICHOICE_TYPE_SEP . $presentation;
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [radio] {$name} -> item id={$saved->id}\n";
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

function foxcs_add_pagebreak($feedback) {
    $itemobj = feedback_get_item_class('pagebreak');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = ['id' => 0, 'feedback' => $feedback->id, 'template' => 0, 'name' => 'pagebreak',
        'label' => '', 'presentation' => '', 'typ' => 'pagebreak', 'hasvalue' => 0,
        'position' => $position, 'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => ''];
    $itemobj->set_data((object) $record);
    $itemobj->save_item();
}

// ---------------------------------------------------------------------------
// 3. Items.
// ---------------------------------------------------------------------------
$rating_scale = "1/Need Help\n2/Still Practicing\n3/Strong";

foxcs_add_rated($feedback, 'Skill: Compare/Absolute Value',
    'Comparing integers and finding absolute value', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Add/Subtract Integers',
    'Adding and subtracting integers', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Multiply/Divide Integers',
    'Multiplying and dividing integers', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Order of Operations',
    'Order of operations', $rating_scale);
foxcs_add_rated($feedback, 'Skill: Estimation/Reasonableness',
    'Estimation and checking whether an answer is reasonable', $rating_scale);

foxcs_add_pagebreak($feedback);

$error_categories = "Knowledge - I didn't know or remember something I needed\nProcess - I had the right idea, but did the steps wrong or out of order\nExecution - I had the right idea and steps, but made a small slip carrying it out\nComprehension - I misunderstood what the question was actually asking\nStrategy - I understood it, but picked a slower or less efficient approach";

foxcs_add_textarea($feedback, 'Mistake 1 description',
    'Describe one real mistake you made this week (yours, or one you looked at closely). What did you do, and where did it go wrong?');
foxcs_add_radio($feedback, 'Mistake 1 category',
    'Which error category best describes that mistake?', $error_categories);
foxcs_add_textarea($feedback, 'Mistake 1 response',
    'What did you do after you recognized that error? (Or: what should the correct next step have been?)');

foxcs_add_textarea($feedback, 'Mistake 2 description',
    'Now describe a second, different mistake (yours or one you looked at). What happened?');
foxcs_add_radio($feedback, 'Mistake 2 category',
    'Which error category best describes that second mistake?', $error_categories);

foxcs_add_pagebreak($feedback);

foxcs_add_textarea($feedback, 'Estimation example',
    'Give one real example of how estimation helped you this week (catching a mistake, checking an answer, or deciding something was unreasonable).');
foxcs_add_textarea($feedback, 'Calculator check',
    'What is one thing you should check before trusting a calculator answer?');
foxcs_add_rated($feedback, 'Confidence',
    'How confident are you with Numbers & Operations now?',
    "1/1 - Not confident\n2/2\n3/3\n4/4\n5/5 - Very confident");

echo "Done. " . $DB->count_records('feedback_item', ['feedback' => $feedback->id]) . " items total. cmid={$result->coursemodule}\n";
