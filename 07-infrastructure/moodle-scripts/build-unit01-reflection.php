<?php
// build-unit01-reflection.php
//
// Builds "Unit 01 Reflection" as a native Moodle mod_feedback activity, closing
// the real gap flagged in worklog.md's 2026-09-03 entry: "Each unit should also
// get a Reflection, as its own recurring element alongside the one Project --
// not yet built for Unit 01." Distinct from the per-lesson Feedback activities
// (01.1-01.6 Feedback, which ask "how did THIS lesson feel") -- this is the
// year-long Journal-writing thread's real Unit 01 entry, per course-plan.md's
// "Game Design, UX, and Journal Threads" section: Unit 01's own prompt,
// 50-100 words, is printed directly under the Unit 01 heading in course-plan.md
// and ported verbatim here as the required item.
//
// mod_feedback (not mod_assign) is the deliberate choice, matching Jay's
// confirmed direction: same non-graded survey mechanism as the per-lesson
// Feedback activities, content scoped to the whole unit instead of one lesson,
// placed once at the end of Unit 01 alongside the Unit Project.
//
// Run: sudo -u www-data php build-unit01-reflection.php

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
$sectionnum = 2; // "Unit 01: What Is Programming?"

$intro = <<<'HTML'
<p>This is Unit 01's own entry in a year-long, iteratively-building reflective writing thread -- separate from each lesson's own quick feedback survey. Take a few minutes with it. 10-15 minutes is normal.</p>
HTML;

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'feedback';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = 'Unit 01 Reflection';
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

function foxcs_add_textarea($feedback, $name, $label, $required = false) {
    $itemobj = feedback_get_item_class('textarea');
    $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
    $record = [
        'id' => 0, 'feedback' => $feedback->id, 'template' => 0,
        'name' => $name, 'label' => $label, 'presentation' => '',
        'typ' => 'textarea', 'hasvalue' => 1, 'position' => $position,
        'required' => $required ? 1 : 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
        'itemwidth' => '70', 'itemheight' => '8',
    ];
    $record['presentation'] = $record['itemwidth'] . '|' . $record['itemheight'];
    $itemobj->set_data((object) $record);
    $saved = $itemobj->save_item();
    echo "  [textarea] {$name} -> item id={$saved->id}\n";
    return $saved;
}

// 1. The real Unit 01 Journal prompt, ported verbatim from course-plan.md's
//    Unit 01 header ("Journal (50-100 words)").
foxcs_add_textarea($feedback, 'Unit 01 Journal',
    'Journal (50-100 words): Every game takes input from a player and gives output back. '
    . 'Describe the Input-Process-Output loop for a game you know, using specific examples.',
    true);

// 2. Rate-each-skill confidence check, one item per actual Unit 01 lesson --
//    NOT a single generic "how confident overall" question. Corrected
//    2026-09-09 per feedback_skill_reflection_format.md's standing rule: a
//    skill reflection must list the real skills and have students rate
//    each one, since without a listed skill set students don't know what
//    the target skills were and just guess. The original version of this
//    script had one generic "Unit confidence" item here instead -- fixed
//    live on cmid=229 and here, so a future rebuild starts correct.
$unit01_lessons = [
    '01.1 What Programs Do',
    '01.2 Input-Process-Output',
    '01.3 Writing Your First Program',
    '01.4 Printing Output',
    '01.5 Comments and Documentation',
    '01.6 Common Syntax Mistakes',
];
foreach ($unit01_lessons as $lesson) {
    foxcs_add_rated($feedback, "Confidence: {$lesson}", "How confident do you feel with {$lesson}?",
        "1/1 - Not confident\n2/2\n3/3\n4/4\n5/5 - Very confident");
}

// 3. A forward-looking open reflection, tying the unit together.
foxcs_add_textarea($feedback, 'What to remember',
    'What\'s one specific thing from Unit 01 (a skill, an idea, a mistake you learned from) that you want to remember going forward into Unit 02?');

echo "Done. " . $DB->count_records('feedback_item', ['feedback' => $feedback->id]) . " items total. cmid={$result->coursemodule}\n";
