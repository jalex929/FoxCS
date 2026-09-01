<?php
// rebuild-seminar3-lesson1.php
//
// Executes the Seminar III Lesson 1 cleanup Jay confirmed 2026-09-01:
//   1. Delete 14 legacy/duplicate modules (confirmed zero real student activity --
//      only admin/test-account log entries).
//   2. Convert the ACT Math Baseline diagnostic from an H5P QuestionSet (which cannot
//      support Safe Exam Browser) to a native Moodle Quiz, porting its 24 real
//      MultiChoice questions (with per-answer feedback) as-is. Single attempt, fixed
//      order (not shuffled), completion-based tracking, SEB + password enabled --
//      same proven architecture as Python's Mastery Checks.
//   3. Renumber the remaining set sequentially in actual completion order:
//      1.1 Solving Problems -> 1.2 Error Types -> 1.3 Order of Operations Practice ->
//      1.4 Order of Operations Extra Practice (was mislabeled "1.10") ->
//      1.5 Guided Practice -> 1.6 Independent Practice -> 1.7 Quick Reference ->
//      1.8 Check -> 1.9 ACT Math Diagnostic -> 1.10 Reflection.
//   4. Set completionexpected = Thu 2026-09-03, end of school day (15:30 Central,
//      matching the school day / "3:30 PM" convention already used everywhere in
//      this course) on every active Lesson 1 module.
//
// No diagnostic-specific quick reference is added (Jay's lean, confirmed): the
// renumbered 1.7 Quick Reference stays as general practice-section reference
// material, not diagnostic prep -- SEB lockdown prevents accessing it during the
// diagnostic attempt anyway. The reflection (1.10, cmid=83) is left as-is: it
// already merges baseline-reflection + build-your-strategy into one activity and
// already covers skills/strengths/priorities and "what felt hardest."
//
// Run: sudo -u www-data php rebuild-seminar3-lesson1.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

use mod_quiz\quiz_settings;

\core\cron::setup_user();

$course = $DB->get_record('course', ['id' => 5], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 2;

$duedt = new DateTime('2026-09-03 15:30:00', new DateTimeZone('America/Chicago'));
$duetimestamp = $duedt->getTimestamp();

// ---------------------------------------------------------------------------
// 1. Delete legacy/duplicate modules.
// ---------------------------------------------------------------------------
$legacy = [66, 64, 67, 65, 38, 39, 69, 68, 70, 71, 72, 75, 76, 77];
foreach ($legacy as $cmid) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid]);
    if ($cm) {
        course_delete_module($cmid);
        echo "Deleted legacy cmid={$cmid}\n";
    }
}

// ---------------------------------------------------------------------------
// 2. Build the native Quiz diagnostic, porting the 24 real questions.
// ---------------------------------------------------------------------------
$qdata = require(__DIR__ . '/diagnostic_questions_data.php');
echo "Loaded " . count($qdata) . " questions from data file.\n";

// Dedicated category for the diagnostic's questions.
$catname = 'Lesson 1 ACT Math Diagnostic';
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
echo "Question category id={$cat->id}\n";

$qtype = question_bank::get_qtype('multichoice');
$questionids = [];
foreach ($qdata as $i => $q) {
    $question = new stdClass();
    $question->qtype = 'multichoice';
    $question->category = $cat->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $cat->id;
    $form->context = $coursecontext;
    $form->name = 'Diagnostic Q' . ($i + 1);
    $form->questiontext = ['text' => $q['question'], 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1;
    $form->penalty = 0;
    $form->single = 1;
    $form->shuffleanswers = 1;
    $form->answernumbering = 'abc';
    $form->showstandardinstruction = 0;
    $form->correctfeedback = ['text' => 'Correct.', 'format' => FORMAT_HTML];
    $form->partiallycorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->incorrectfeedback = ['text' => '', 'format' => FORMAT_HTML];

    $answer = [];
    $fraction = [];
    $feedback = [];
    foreach ($q['answers'] as $a) {
        $answer[] = ['text' => $a['text'], 'format' => FORMAT_HTML];
        $fraction[] = $a['correct'] ? 1.0 : 0.0;
        $feedback[] = ['text' => $a['feedback'], 'format' => FORMAT_HTML];
    }
    $form->answer = $answer;
    $form->fraction = $fraction;
    $form->feedback = $feedback;

    $saved = $qtype->save_question($question, $form);
    $questionids[] = $saved->id;
    echo "Saved Q" . ($i + 1) . ": id={$saved->id}\n";
}

// Create the quiz activity.
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '1.9 ACT Math Diagnostic';
$moduleinfo->introeditor = [
    'text' => '<p>This is a diagnostic, not a practice activity: answer each question '
        . 'with your first, best attempt. There is no retrying a question once you '
        . "submit it, and no hints or feedback along the way. That is intentional. "
        . 'A diagnostic only tells you something useful if it reflects what you '
        . 'actually know right now, not what you can get to with retries.</p>'
        . '<p>This requires Safe Exam Browser and the password your teacher gives '
        . 'you in class.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->quizpassword = 'Baseline26!';
$moduleinfo->attempts = 1;
$moduleinfo->grademethod = 1; // QUIZ_GRADEHIGHEST (only 1 attempt anyway)
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->overduehandling = 'autoabandon';
$moduleinfo->graceperiod = 0;
$moduleinfo->preferredbehaviour = 'deferredfeedback';
$moduleinfo->canredoquestions = 0;
$moduleinfo->attemptonlast = 0;
$moduleinfo->decimalpoints = 2;
$moduleinfo->questiondecimalpoints = -1;
$moduleinfo->reviewattempt = 65536; // reused verbatim from Python's proven Mastery Check config
$moduleinfo->reviewcorrectness = 0;
$moduleinfo->reviewmaxmarks = 0;
$moduleinfo->reviewmarks = 0;
$moduleinfo->reviewspecificfeedback = 0;
$moduleinfo->reviewgeneralfeedback = 0;
$moduleinfo->reviewrightanswer = 0;
$moduleinfo->reviewoverallfeedback = 0;
$moduleinfo->questionsperpage = 1;
$moduleinfo->navmethod = 'free';
$moduleinfo->shuffleanswers = 0;
$moduleinfo->grade = 100;
$moduleinfo->showuserpicture = 0;
$moduleinfo->showblocks = 0;
$moduleinfo->completionattemptsexhausted = 0;
$moduleinfo->completionminattempts = 1;
$moduleinfo->allowofflineattempts = 0;

$result = create_module($moduleinfo);
$quizcmid = $result->coursemodule;
$quizid = $result->id;
echo "Created diagnostic quiz: cmid={$quizcmid} quizid={$quizid}\n";

// Add all 24 questions in fixed order (no shuffling of question order). maxmark=1
// each (NOT 0 -- 0 is only for deliberately-unscored questions like Python's
// integrity acknowledgment; a real diagnostic needs every question to carry marks
// or the quiz can't compute its grade at all).
$quiz = $DB->get_record('quiz', ['id' => $quizid], '*', MUST_EXIST);
foreach ($questionids as $qid) {
    quiz_add_quiz_question($qid, $quiz, 0, 1);
}
echo "Added " . count($questionids) . " questions to quiz in fixed order.\n";

quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();

// Completion: pass-based tracking off (diagnostic isn't pass/fail), just require an
// attempt to be finished.
$DB->set_field('course_modules', 'completion', 2, ['id' => $quizcmid]);

// SEB.
$seb = new \quizaccess_seb\seb_quiz_settings();
$seb->set('quizid', $quizid);
$seb->set('cmid', $quizcmid);
$seb->set('templateid', 0);
$seb->set('requiresafeexambrowser', \quizaccess_seb\settings_provider::USE_SEB_CONFIG_MANUALLY);
$seb->set('showsebdownloadlink', 1);
$seb->set('showsebtaskbar', 1);
$seb->set('showwificontrol', 0);
$seb->set('showreloadbutton', 0);
$seb->set('showtime', 1);
$seb->set('showkeyboardlayout', 0);
$seb->set('allowuserquitseb', 0);
$seb->set('quitpassword', 'Baseline26!');
$seb->set('linkquitseb', '');
$seb->set('userconfirmquit', 1);
$seb->set('enableaudiocontrol', 0);
$seb->set('muteonstartup', 0);
$seb->set('allowcapturecamera', 0);
$seb->set('allowcapturemicrophone', 0);
$seb->set('allowspellchecking', 0);
$seb->set('allowreloadinexam', 0);
$seb->set('activateurlfiltering', 1);
$seb->set('filterembeddedcontent', 1);
$seb->set('expressionsallowed', 'https://foxcs.online/*');
$seb->set('regexallowed', '');
$seb->set('expressionsblocked', '');
$seb->set('regexblocked', '');
$seb->set('allowedbrowserexamkeys', '');
$seb->save();
echo "SEB enabled on diagnostic quiz.\n";

// ---------------------------------------------------------------------------
// 3. Delete the old H5P diagnostic (cmid=82) and its now-superseded content.
// ---------------------------------------------------------------------------
course_delete_module(82);
echo "Deleted old H5P diagnostic cmid=82.\n";

// ---------------------------------------------------------------------------
// 4. Rename remaining active modules to sequential 1.1-1.10, and set the new
//    section order + due dates.
// ---------------------------------------------------------------------------
$renames = [
    144 => '1.1 -- Solving Problems',
    151 => '1.2 -- Error Types',
    157 => '1.3 -- Order of Operations Practice',
    191 => '1.4 -- Order of Operations: Extra Practice',
    162 => '1.5 -- Guided Practice',
    163 => '1.6 -- Independent Practice',
    42  => '1.7 -- Quick Reference',
    154 => '1.8 -- Check',
    83  => '1.10 -- Lesson 1 Reflection',
];
foreach ($renames as $cmid => $newname) {
    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $modname = $DB->get_field('modules', 'name', ['id' => $cm->module]);
    $DB->set_field($modname, 'name', $newname, ['id' => $cm->instance]);
    echo "Renamed cmid={$cmid} -> \"{$newname}\"\n";
}

$neworder = [156, 144, 151, 157, 191, 162, 163, 42, 154, $quizcmid, 83];
$section = $DB->get_record('course_sections', ['course' => $course->id, 'section' => $sectionnum], '*', MUST_EXIST);
$section->sequence = implode(',', $neworder);
$DB->update_record('course_sections', $section);
echo "New sequence: {$section->sequence}\n";

// Due dates: soft completionexpected on every active module.
$duecmids = [144, 151, 157, 191, 162, 163, 42, 154, $quizcmid, 83];
foreach ($duecmids as $cmid) {
    $DB->set_field('course_modules', 'completionexpected', $duetimestamp, ['id' => $cmid]);
}
echo "completionexpected set to " . $duedt->format('Y-m-d H:i:s T') . " on " . count($duecmids) . " modules.\n";

rebuild_course_cache($course->id, true);
echo "Done.\n";
