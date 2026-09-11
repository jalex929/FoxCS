<?php
// Deploys all 4 of 02.1 Variables and Memory's modules (Instruction, Mastery
// Check, Project, Feedback) to the LIVE foxcs-python course (section 3,
// "Unit 02: Variables & Data"), for real enrolled students. Due Tuesday,
// September 8, 2026, per Jay's direct instruction -- matches 01.1's own
// precedent of one unified due date/time across every module in the lesson.
//
// Adapted directly from the 4 already-verified sandbox scripts:
//   create-sandbox-unit02-pilot-instruction.php
//   create-sandbox-unit02-pilot-mastery-check.php (+ the item-4 rework from
//     update-sandbox-unit02-pilot-mastery-check-item4.php, folded in from
//     the start so this script only needs one pass)
//   create-sandbox-unit02-pilot-project.php
//   create-sandbox-unit02-pilot-feedback.php
// Same content, live course/section, real due date, a real (not sandbox)
// quiz password.

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/mod/feedback/lib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 3;

$due = new DateTime('2026-09-08 15:30:00', new DateTimeZone('America/Chicago'));
$duets = $due->getTimestamp();

// ===========================================================================
// 1. Instruction (mod_resource)
// ===========================================================================
$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'live-u02-01-instruction']);
if ($existing) {
    echo "Instruction already exists as cmid={$existing->id}; skipping.\n";
} else {
    $sourcepath = '/tmp/foxcs-deploy-stage/02_01_instruction.html';
    $fs = get_file_storage();
    $usercontext = context_user::instance($USER->id);
    $draftitemid = file_get_unused_draft_itemid();
    $fs->create_file_from_string([
        'contextid' => $usercontext->id, 'component' => 'user', 'filearea' => 'draft',
        'itemid' => $draftitemid, 'filepath' => '/', 'filename' => 'index.html',
    ], '<html><body>placeholder</body></html>');

    $moduleinfo = new stdClass();
    $moduleinfo->modulename = 'resource';
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
    $moduleinfo->course = $course->id;
    $moduleinfo->section = $sectionnum;
    $moduleinfo->visible = 1;
    $moduleinfo->name = '2.1 Variables and Memory: Instruction';
    $moduleinfo->idnumber = 'live-u02-01-instruction';
    $moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
    $moduleinfo->files = $draftitemid;
    $moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
    $moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
    $moduleinfo->completionview = 0;
    $moduleinfo->completionexpected = $duets;

    $result = create_module($moduleinfo);
    $cmid = $result->coursemodule;
    $modcontext = context_module::instance($cmid);
    $fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

    $html = file_get_contents($sourcepath);
    $html = str_replace('__CMID__', (string) $cmid, $html);
    $html = str_replace(
        '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt.min.js"></script>',
        '<script src="skulpt.min.js"></script>', $html
    );
    $html = str_replace(
        '<script src="../../../../../02-authoring-system/skulpt-runtime/skulpt-stdlib.js"></script>',
        '<script src="skulpt-stdlib.js"></script>', $html
    );
    $files = [
        'index.html' => null,
        'skulpt.min.js' => '/tmp/foxcs-deploy-stage/skulpt.min.js',
        'skulpt-stdlib.js' => '/tmp/foxcs-deploy-stage/skulpt-stdlib.js',
    ];
    foreach ($files as $filename => $path) {
        $content = $filename === 'index.html' ? $html : file_get_contents($path);
        $fs->create_file_from_string([
            'contextid' => $modcontext->id, 'component' => 'mod_resource', 'filearea' => 'content',
            'itemid' => 0, 'filepath' => '/', 'filename' => $filename,
        ], $content);
    }
    file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);
    echo "Instruction: cmid={$cmid}\n";
}

// ===========================================================================
// 2. Mastery Check (mod_quiz), item 4 already the corrected concatenation version
// ===========================================================================
$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'live-u02-01-mc']);
if ($existing) {
    echo "Mastery Check already exists as cmid={$existing->id}; skipping.\n";
} else {
    $catname = 'Live 02.1 Mastery Check';
    $cat = $DB->get_record('question_categories', ['name' => $catname, 'contextid' => $coursecontext->id]);
    if (!$cat) {
        $cat = new stdClass();
        $cat->name = $catname;
        $cat->contextid = $coursecontext->id;
        $cat->info = '';
        $cat->infoformat = FORMAT_HTML;
        $cat->stamp = make_unique_id_code();
        $cat->parent = 0;
        $cat->sortorder = 999;
        $cat->id = $DB->insert_record('question_categories', $cat);
    }

    $sa = question_bank::get_qtype('shortanswer');
    $mc = question_bank::get_qtype('multichoice');
    $qids = [];

    // Item 1: shortanswer, predict reassignment + print output.
    $q = new stdClass();
    $q->qtype = 'shortanswer'; $q->category = $cat->id; $q->contextid = $coursecontext->id;
    $q->createdby = $USER->id; $q->modifiedby = $USER->id;
    $form = new stdClass();
    $form->category = $cat->id; $form->context = $coursecontext;
    $form->name = 'MC Item 1: predict reassignment output';
    $form->questiontext = ['text' => '<p>What does this program print?</p><pre>score = 0
score = 15
print("Score:", score)</pre>', 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1; $form->penalty = 0.3333333; $form->usecase = 1;
    $form->answer = ['Score: 15']; $form->fraction = [1.0];
    $form->feedback = [['text' => '', 'format' => FORMAT_HTML]];
    $qids[] = $sa->save_question($q, $form)->id;

    // Item 2: shortanswer, fix the broken assignment line.
    $q = new stdClass();
    $q->qtype = 'shortanswer'; $q->category = $cat->id; $q->contextid = $coursecontext->id;
    $q->createdby = $USER->id; $q->modifiedby = $USER->id;
    $form = new stdClass();
    $form->category = $cat->id; $form->context = $coursecontext;
    $form->name = 'MC Item 2: fix the broken assignment';
    $form->questiontext = ['text' => '<p>This line is supposed to create a variable named <code>lives</code> set to <code>3</code>, but it has a mistake:</p><pre>3 = lives</pre><p>Write the corrected line.</p>', 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1; $form->penalty = 0.3333333; $form->usecase = 0;
    $form->answer = ['lives = 3', 'lives=3']; $form->fraction = [1.0, 1.0];
    $form->feedback = [['text' => '', 'format' => FORMAT_HTML], ['text' => '', 'format' => FORMAT_HTML]];
    $qids[] = $sa->save_question($q, $form)->id;

    // Item 3: multichoice, valid naming.
    $q = new stdClass();
    $q->qtype = 'multichoice'; $q->category = $cat->id; $q->contextid = $coursecontext->id;
    $q->createdby = $USER->id; $q->modifiedby = $USER->id;
    $form = new stdClass();
    $form->category = $cat->id; $form->context = $coursecontext;
    $form->name = 'MC Item 3: valid naming';
    $form->questiontext = ['text' => '<p>Which of these variable names is valid in Python?</p>', 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1; $form->penalty = 0.3333333; $form->single = 1; $form->shuffleanswers = 1;
    $form->answernumbering = 'abc';
    $form->correctfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->partiallycorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->incorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->answer = [
        ['text' => '<pre>1st_place</pre>', 'format' => FORMAT_HTML],
        ['text' => '<pre>player class</pre>', 'format' => FORMAT_HTML],
        ['text' => '<pre>player_class</pre>', 'format' => FORMAT_HTML],
        ['text' => '<pre>def</pre>', 'format' => FORMAT_HTML],
    ];
    $form->fraction = [0, 0, 1.0, 0];
    $form->feedback = [
        ['text' => 'Names cannot start with a digit.', 'format' => FORMAT_HTML],
        ['text' => 'Names cannot contain spaces.', 'format' => FORMAT_HTML],
        ['text' => 'Correct.', 'format' => FORMAT_HTML],
        ['text' => 'def is a reserved Python word.', 'format' => FORMAT_HTML],
    ];
    $qids[] = $mc->save_question($q, $form)->id;

    // Item 4: shortanswer, fix the concatenation TypeError (the corrected 2026-09-04 version).
    $q = new stdClass();
    $q->qtype = 'shortanswer'; $q->category = $cat->id; $q->contextid = $coursecontext->id;
    $q->createdby = $USER->id; $q->modifiedby = $USER->id;
    $form = new stdClass();
    $form->category = $cat->id; $form->context = $coursecontext;
    $form->name = 'MC Item 4: fix the concatenation error';
    $form->questiontext = ['text' => '<p>This line is supposed to print <code>Total: 12</code>, using <code>+</code>, but it crashes:</p><pre>total = 12
print("Total: " + total)</pre><p>Write the corrected line.</p>', 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1; $form->penalty = 0.3333333; $form->usecase = 0;
    $form->answer = ['print("Total: " + str(total))', 'print("Total: "+str(total))'];
    $form->fraction = [1.0, 1.0];
    $form->feedback = [['text' => '', 'format' => FORMAT_HTML], ['text' => '', 'format' => FORMAT_HTML]];
    $qids[] = $sa->save_question($q, $form)->id;

    echo "Saved " . count($qids) . " Mastery Check questions.\n";

    $intro = <<<'HTML'
<p>This is a scored test attempt, not practice. Once you start, it counts.</p>
<p>Make sure you've already completed 02.1's Practice and Project before starting this Mastery Check.</p>
HTML;

    $password = 'FGV73Q';

    $moduleinfo = new stdClass();
    $moduleinfo->modulename = 'quiz';
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
    $moduleinfo->course = $course->id;
    $moduleinfo->section = $sectionnum;
    $moduleinfo->visible = 1;
    $moduleinfo->name = '2.1 Mastery Check';
    $moduleinfo->idnumber = 'live-u02-01-mc';
    $moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
    $moduleinfo->quizpassword = $password;
    $moduleinfo->timeopen = 0;
    $moduleinfo->timeclose = $duets;
    $moduleinfo->timelimit = 0;
    $moduleinfo->attempts = 3;
    $moduleinfo->grademethod = QUIZ_GRADEAVERAGE;
    $moduleinfo->preferredbehaviour = 'adaptivenopenalty';
    $moduleinfo->questionsperpage = 0;
    $moduleinfo->shuffleanswers = 1;
    $moduleinfo->navmethod = 'free';
    $moduleinfo->grade = 10; // Mastery Check, per grade-point-scale.md

    $result = create_module($moduleinfo);
    $quiz = $DB->get_record('quiz', ['id' => $result->instance], '*', MUST_EXIST);
    foreach ($qids as $qid) {
        quiz_add_quiz_question($qid, $quiz, 0, 1);
    }
    $settings = \mod_quiz\quiz_settings::create($quiz->id);
    $settings->get_grade_calculator()->recompute_quiz_sumgrades();
    echo "Mastery Check: cmid={$result->coursemodule} quizid={$quiz->id} password={$password} timeclose=" . date('Y-m-d H:i:s T', $duets) . "\n";
}

// ===========================================================================
// 3. Project (mod_assign)
// ===========================================================================
$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'live-u02-01-project']);
if ($existing) {
    echo "Project already exists as cmid={$existing->id}; skipping.\n";
} else {
    $intro = <<<'HTML'
<p>A short applied task after Practice. Track a game character's status using variables, print it clearly, then update part of it partway through, the way a character's state changes during real play.</p>

<h3>What This Could Look Like</h3>
<p>The <em>output</em> a finished tracker might display, just to show the shape of what you're building. Not code to copy -- your own variable names, character, and event don't have to match this at all.</p>
<pre>Character: Nia
Class: Mage
Health: 100
Lives: 3
Health: 80</pre>

<h3>Required</h3>
<ul>
<li>At least 4 variables describing your character's state. At least one is text (a string), at least one is a number.</li>
<li>Each variable printed with a clear label (print("Health:", health), not a bare number).</li>
<li>At least one variable reassigned partway through to a new value, simulating something happening in the game, then printed again so the change is visible.</li>
<li>Every variable name follows this lesson's naming rules (starts with a letter or underscore, no spaces, snake_case for multi-word names).</li>
<li>No syntax errors. Run it and fix anything Python flags.</li>
</ul>

<h3>Tier 1 Bonus (+10 XP)</h3>
<ul>
<li>2+ more state variables beyond the required 4, genuinely different kinds of information.</li>
<li>A comment above at least one variable explaining why you named it the way you did.</li>
</ul>

<h3>Tier 2 Bonus (+20 XP, on top of Tier 1)</h3>
<ul>
<li>A second reassignment at a different point in the program.</li>
<li>A short comment (2-3 sentences) explaining, in your own words, how your chosen print labels would help an actual player understand what they're looking at.</li>
</ul>

<h3>Stuck?</h3>
<p>Start by listing what your character actually needs (a name, a class, health, lives). Get one variable printing correctly before adding the next. Add the one required reassignment last, once every variable prints on its own.</p>

<h3>How to Submit</h3>
<p>Upload your saved <code>.py</code> file below. Pasted text is not accepted for this assignment.</p>
HTML;

    $moduleinfo = new stdClass();
    $moduleinfo->modulename = 'assign';
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
    $moduleinfo->course = $course->id;
    $moduleinfo->section = $sectionnum;
    $moduleinfo->visible = 1;
    $moduleinfo->name = '2.1 Project: Character Status Tracker';
    $moduleinfo->idnumber = 'live-u02-01-project';
    $moduleinfo->introeditor = ['text' => $intro, 'format' => FORMAT_HTML, 'itemid' => 0];
    $moduleinfo->alwaysshowdescription = 0;
    $moduleinfo->nosubmissions = 0;
    $moduleinfo->submissiondrafts = 0;
    $moduleinfo->sendnotifications = 0;
    $moduleinfo->sendlatenotifications = 0;
    $moduleinfo->sendstudentnotifications = 1;
    $moduleinfo->duedate = $duets;
    $moduleinfo->allowsubmissionsfromdate = 0;
    $moduleinfo->cutoffdate = 0;
    $moduleinfo->gradingduedate = 0;
    $moduleinfo->grade = 25; // Project, per grade-point-scale.md
    $moduleinfo->requiresubmissionstatement = 0;
    $moduleinfo->teamsubmission = 0;
    $moduleinfo->requireallteammemberssubmit = 0;
    $moduleinfo->teamsubmissiongroupingid = 0;
    $moduleinfo->blindmarking = 0;
    $moduleinfo->hidegrader = 0;
    $moduleinfo->revealidentities = 0;
    $moduleinfo->attemptreopenmethod = 'none';
    $moduleinfo->maxattempts = -1;
    $moduleinfo->markingworkflow = 0;
    $moduleinfo->markingallocation = 0;
    $moduleinfo->completion = 1;
    $moduleinfo->completionsubmit = 1;
    $moduleinfo->assignsubmission_onlinetext_enabled = 0;
    $moduleinfo->assignsubmission_file_enabled = 1;
    $moduleinfo->assignsubmission_file_maxfiles = 1;
    $moduleinfo->assignsubmission_file_maxsizebytes = 1048576;
    $moduleinfo->assignsubmission_file_filetypes = '.py';
    $moduleinfo->assignsubmission_comments_enabled = 0;
    $moduleinfo->assignfeedback_comments_enabled = 1;
    $moduleinfo->assignfeedback_editpdf_enabled = 0;
    $moduleinfo->assignfeedback_offline_enabled = 0;
    $moduleinfo->assignfeedback_file_enabled = 0;

    $result = create_module($moduleinfo);
    echo "Project: cmid={$result->coursemodule} duedate=" . date('Y-m-d H:i:s T', $duets) . "\n";
}

// ===========================================================================
// 4. Feedback (mod_feedback)
// ===========================================================================
$existing = $DB->get_record('course_modules', ['course' => $course->id, 'idnumber' => 'live-u02-01-feedback']);
if ($existing) {
    echo "Feedback already exists as cmid={$existing->id}; skipping.\n";
} else {
    $intro = '<p>2-3 minutes. This is about the lesson, not about grading you. Your honest answers help decide what changes for next time.</p>';

    $moduleinfo = new stdClass();
    $moduleinfo->modulename = 'feedback';
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'feedback']);
    $moduleinfo->course = $course->id;
    $moduleinfo->section = $sectionnum;
    $moduleinfo->visible = 1;
    $moduleinfo->name = '2.1 Feedback';
    $moduleinfo->idnumber = 'live-u02-01-feedback';
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

    function foxcs_add_rated($feedback, $name, $label, $values) {
        $itemobj = feedback_get_item_class('multichoicerated');
        $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
        $record = ['id' => 0, 'feedback' => $feedback->id, 'template' => 0, 'name' => $name, 'label' => $label,
            'presentation' => '', 'typ' => 'multichoicerated', 'hasvalue' => 1, 'position' => $position,
            'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '', 'subtype' => 'r',
            'horizontal' => 1, 'hidenoselect' => 1, 'ignoreempty' => 0, 'values' => $values];
        $presentation = $itemobj->prepare_presentation_values_save(trim($record['values']),
            FEEDBACK_MULTICHOICERATED_VALUE_SEP2, FEEDBACK_MULTICHOICERATED_VALUE_SEP);
        $presentation .= FEEDBACK_MULTICHOICERATED_ADJUST_SEP . '1';
        $record['presentation'] = $record['subtype'] . FEEDBACK_MULTICHOICERATED_TYPE_SEP . $presentation;
        $itemobj->set_data((object) $record);
        return $itemobj->save_item();
    }
    function foxcs_add_textarea($feedback, $name, $label) {
        $itemobj = feedback_get_item_class('textarea');
        $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
        $record = ['id' => 0, 'feedback' => $feedback->id, 'template' => 0, 'name' => $name, 'label' => $label,
            'presentation' => '', 'typ' => 'textarea', 'hasvalue' => 1, 'position' => $position,
            'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '',
            'itemwidth' => '60', 'itemheight' => '6'];
        $record['presentation'] = $record['itemwidth'] . '|' . $record['itemheight'];
        $itemobj->set_data((object) $record);
        return $itemobj->save_item();
    }
    function foxcs_add_checkbox($feedback, $name, $label, $values) {
        $itemobj = feedback_get_item_class('multichoice');
        $position = $GLOBALS['DB']->count_records('feedback_item', ['feedback' => $feedback->id]) + 1;
        $record = ['id' => 0, 'feedback' => $feedback->id, 'template' => 0, 'name' => $name, 'label' => $label,
            'presentation' => '', 'typ' => 'multichoice', 'hasvalue' => 1, 'position' => $position,
            'required' => 0, 'dependitem' => 0, 'dependvalue' => '', 'options' => '', 'subtype' => 'c',
            'horizontal' => 0, 'hidenoselect' => 1, 'ignoreempty' => 0, 'values' => $values];
        $presentation = str_replace("\n", FEEDBACK_MULTICHOICE_LINE_SEP, trim($record['values']));
        $record['presentation'] = $record['subtype'] . FEEDBACK_MULTICHOICE_TYPE_SEP . $presentation;
        $itemobj->set_data((object) $record);
        return $itemobj->save_item();
    }

    foxcs_add_rated($feedback, 'Clarity', 'How clear was it what you were being asked to do in this lesson?',
        "1/1 - Confusing\n2/2\n3/3\n4/4\n5/5 - Totally clear");
    foxcs_add_textarea($feedback, 'Clarity followup', 'If any part was unclear, describe what it was. (Leave blank if nothing was unclear.)');
    foxcs_add_rated($feedback, 'Difficulty', 'How difficult was this lesson for you?',
        "1/1 - Too easy\n2/2\n3/3\n4/4\n5/5 - Too difficult");
    foxcs_add_textarea($feedback, 'Difficulty followup', 'What part of this lesson was the most difficult for you? (Leave blank if nothing felt difficult.)');
    foxcs_add_rated($feedback, 'Interest', 'How interesting did this lesson feel to you?',
        "1/1 - Not interesting\n2/2\n3/3\n4/4\n5/5 - Very interesting");
    foxcs_add_checkbox($feedback, 'Vocab self-check',
        "This lesson taught 5 words. Check any that you still find hard to explain in your own words.\n(Or check \"None\" if you can explain all 5.)",
        "variable: a named place in a program's memory that stores a value\nassignment operator: the = sign, used to store a value in a variable\nvalue: the actual piece of data stored in a variable\nsnake_case: joining multi-word variable names with underscores\nreassignment: assigning a new value to a variable that already exists\nNone. I can explain all 5 words");
    foxcs_add_textarea($feedback, 'Most rewarding', 'What part of this lesson felt the most rewarding, or helped you learn the most? Give a specific example.');
    foxcs_add_textarea($feedback, 'Getting help', 'If something in this lesson was difficult to understand on your own, were you able to get help? What helped, or what would have made it easier to get help?');

    echo "Feedback: cmid={$result->coursemodule}, " . $DB->count_records('feedback_item', ['feedback' => $feedback->id]) . " items\n";
}

echo "DONE.\n";
