<?php
// build-lesson-01-02-mastery-check.php
//
// 01.2 Mastery Check, built fresh using the exact architecture proven on 01.1
// (rebuild-mastery-check-task-pool.php): one static password, SEB enabled, a fixed
// academic-integrity acknowledgment as slot 1 (REUSING the same real question id=21,
// not recreating it -- Jay's standing rule is that this exact question is always first
// on every future Mastery Check), and a random draw of 1 from a dedicated 10-task essay
// pool as slot 2.
//
// Run: sudo -u www-data php build-lesson-01-02-mastery-check.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');

use mod_quiz\question\bank\filter\custom_category_condition;
use mod_quiz\quiz_settings;
use mod_quiz\structure;

\core\cron::setup_user();

const REAL_PASSWORD = 'Guava56#';

$course = $DB->get_record('course', ['shortname' => 'foxcs-python'], '*', MUST_EXIST);
$coursecontext = context_course::instance($course->id);
$sectionnum = 2;

// ---------------------------------------------------------------------------
// 1. Create the quiz activity, settings mirrored from 01.1's Mastery Check (cmid=114).
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'quiz';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = '01.2 Mastery Check';
$moduleinfo->introeditor = [
    'text' => '<p>Before you start: this Mastery Check only works with Safe Exam Browser and '
        . "the password your teacher gives you in class. If you don't have both, close this "
        . 'and check with your teacher.</p>'
        . '<p>You will answer two questions: a short acknowledgment, then one task randomly '
        . 'assigned to you from a pool of possible tasks. You get 3 attempts, and your grade '
        . 'is the average of all attempts, not just your best one, so take each attempt '
        . 'seriously.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->attempts = 3;
$moduleinfo->grademethod = 2; // QUIZ_GRADEAVERAGE
$moduleinfo->timeopen = 0;
$moduleinfo->timeclose = 0;
$moduleinfo->timelimit = 0;
$moduleinfo->overduehandling = 'autoabandon';
$moduleinfo->graceperiod = 0;
$moduleinfo->preferredbehaviour = 'manualgraded';
$moduleinfo->canredoquestions = 0;
$moduleinfo->attemptonlast = 0;
$moduleinfo->decimalpoints = 2;
$moduleinfo->questiondecimalpoints = -1;
$moduleinfo->reviewattempt = 65536;
$moduleinfo->reviewcorrectness = 0;
$moduleinfo->reviewmaxmarks = 0;
$moduleinfo->reviewmarks = 0;
$moduleinfo->reviewspecificfeedback = 0;
$moduleinfo->reviewgeneralfeedback = 0;
$moduleinfo->reviewrightanswer = 0;
$moduleinfo->reviewoverallfeedback = 0;
$moduleinfo->questionsperpage = 0;
$moduleinfo->navmethod = 'free';
$moduleinfo->shuffleanswers = 1;
$moduleinfo->grade = 10; // Mastery Check, per grade-point-scale.md
$moduleinfo->showuserpicture = 0;
$moduleinfo->showblocks = 0;
$moduleinfo->completionattemptsexhausted = 0;
$moduleinfo->completionminattempts = 0;
$moduleinfo->allowofflineattempts = 0;
$moduleinfo->quizpassword = REAL_PASSWORD;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
$quizid = $result->id;
echo "Created quiz activity: cmid={$cmid} quizid={$quizid}\n";

// ---------------------------------------------------------------------------
// 2. Enable SEB, using the real seb_quiz_settings persistent class (confirmed via
//    mod/quiz/accessrule/seb/classes/seb_quiz_settings.php) so config_key gets
//    computed correctly on save, mirrored from 01.1's enable-seb script.
// ---------------------------------------------------------------------------
$seb = new \quizaccess_seb\seb_quiz_settings();
$seb->set('quizid', $quizid);
$seb->set('cmid', $cmid);
$seb->set('templateid', 0);
$seb->set('requiresafeexambrowser', \quizaccess_seb\settings_provider::USE_SEB_CONFIG_MANUALLY);
$seb->set('showsebdownloadlink', 1);
$seb->set('showsebtaskbar', 1);
$seb->set('showwificontrol', 0);
$seb->set('showreloadbutton', 0);
$seb->set('showtime', 1);
$seb->set('showkeyboardlayout', 0);
$seb->set('allowuserquitseb', 0);
$seb->set('quitpassword', REAL_PASSWORD);
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
echo "SEB enabled on cmid={$cmid}.\n";

// ---------------------------------------------------------------------------
// 3. Create the dedicated task-pool category and write 10 new essay tasks.
// ---------------------------------------------------------------------------
$poolcatname = 'Lesson 01.2 Mastery Check - Task Pool';
$poolcat = $DB->get_record('question_categories', ['name' => $poolcatname, 'contextid' => $coursecontext->id]);
if (!$poolcat) {
    $poolcat = new stdClass();
    $poolcat->name = $poolcatname;
    $poolcat->contextid = $coursecontext->id;
    $poolcat->info = '';
    $poolcat->infoformat = FORMAT_HTML;
    $poolcat->stamp = make_unique_id_code();
    $poolcat->parent = 0;
    $poolcat->sortorder = 999;
    $poolcat->id = $DB->insert_record('question_categories', $poolcat);
}
echo "Pool category id={$poolcat->id}\n";

$tasks = [
    'A microwave: you set the time and press start, it heats the food, then it beeps when done. Identify the Input, the Process, and the Output in this example, one sentence each.',
    "Explain in your own words why Input, Process, and Output happen in that specific order. What would break if Process happened before Input?",
    'A vending machine takes your money, checks whether it\'s enough, then either dispenses a snack or shows "Insufficient Funds." Where does "checking whether it\'s enough" fall in the IPO pattern, and why does that matter for how the machine behaves?',
    'Think of an app or device from your own life. Break it down into its Input, Process, and Output stages, one sentence each.',
    'Explain the difference between something being Input and something being Output, using an example that shows you understand both.',
    'A smart thermostat is set to 70 degrees but is currently reading 65 degrees, so it turns on the heat. What is the Input, what is the Process, and what is the Output here?',
    'A single value, like a saved forecast or a calculated total, can sometimes be Output at one moment and then reused as Input later. Explain how that\'s possible, using an example.',
    'If a program had Input and Output but no Process at all, what would it actually be able to do? Explain using an example.',
    'A student says: "the screen showing the number is the same thing as the computer doing the math." Explain what\'s wrong with this idea and how you would correct it.',
    'Pick a video game or app you use. Describe one Process step that happens between when you give it Input and when you see Output.',
];

$qtype = question_bank::get_qtype('essay');
foreach ($tasks as $i => $qtext) {
    $question = new stdClass();
    $question->qtype = 'essay';
    $question->category = $poolcat->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $poolcat->id;
    $form->context = $coursecontext;
    $form->name = 'Mastery Check Task Pool ' . ($i + 1);
    $form->questiontext = ['text' => "<p>{$qtext}</p>", 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = 1;
    $form->penalty = 0;
    $form->responseformat = 'editor';
    $form->responserequired = 1;
    $form->responsefieldlines = 15;
    $form->attachments = 0;
    $form->attachmentsrequired = 0;
    $form->maxbytes = 0;
    $form->graderinfo = ['text' => '', 'format' => FORMAT_HTML];
    $form->responsetemplate = ['text' => '', 'format' => FORMAT_HTML];

    $saved = $qtype->save_question($question, $form);
    echo "Saved task " . ($i + 1) . ": id={$saved->id}\n";
}
echo "Pool now holds 10 tasks.\n";

// ---------------------------------------------------------------------------
// 4. Slot 1 = fixed integrity question (REUSED, id=21). Slot 2 = random draw of 1.
// ---------------------------------------------------------------------------
$integrityquestionid = 21;
$integrityq = $DB->get_record('question', ['id' => $integrityquestionid]);
if (!$integrityq || $integrityq->name !== 'Mastery Check Academic Integrity Acknowledgment') {
    fwrite(STDERR, "Question id=21 is not the expected integrity question -- aborting before touching slots.\n");
    exit(1);
}
echo "Integrity question id={$integrityquestionid} confirmed: {$integrityq->name}\n";

$quiz = $DB->get_record('quiz', ['id' => $quizid], '*', MUST_EXIST);
quiz_add_quiz_question($integrityquestionid, $quiz, 0, 0);
echo "Added integrity question as slot 1 (maxmark=0).\n";

$settings = quiz_settings::create_for_cmid($cmid);
$structure = structure::create_for_quiz($settings);
$filtercondition = [
    'qpage' => 0,
    'cat' => "{$poolcat->id},{$coursecontext->id}",
    'qperpage' => 20,
    'tabname' => 'questions',
    'sortdata' => [],
    'filter' => [
        'category' => [
            'jointype' => custom_category_condition::JOINTYPE_DEFAULT,
            'values' => [$poolcat->id],
            'filteroptions' => ['includesubcategories' => false],
        ],
    ],
];
$structure->add_random_questions(1, 1, $filtercondition);
echo "Added random-draw slot 2 (1 question from the 10-task pool).\n";

quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();
echo "Recomputed quiz sumgrades.\n";

echo "Done. cmid={$cmid} quizid={$quizid} password=" . REAL_PASSWORD . "\n";
