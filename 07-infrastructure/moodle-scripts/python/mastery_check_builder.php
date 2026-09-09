<?php
// mastery_check_builder.php
//
// Shared helpers for building a lesson's Mastery Check as a real Moodle Quiz,
// auto-gradable (shortanswer/multichoice), per
// ../../02-authoring-system/mastery-check-standards.md's "prefer deterministic
// validation" rule -- the pattern the 02.1 sandbox pilot (quizid=11, course
// id=9) already proved out, promoted here into a reusable builder so 02.2
// onward don't each re-solve the same Moodle question-API plumbing.
//
// Real API gotchas this file has already solved (see
// create_lesson1_mastery_check_quiz.php for the original discovery, which
// used essay questions -- this file adds shortanswer/multichoice on top):
//   - create_module() for a quiz expects $moduleinfo->quizpassword, not
//     ->password.
//   - Sumgrades must be recomputed via
//     \mod_quiz\quiz_settings::create($quizid)->get_grade_calculator()
//     ->recompute_quiz_sumgrades() -- quiz_update_sumgrades() no longer
//     exists as a standalone function.
//   - question_type::save_question() is the real production save path (same
//     one the question edit form calls) -- NOT the PHPUnit generators, which
//     require a live PHPUnit\Framework\TestCase and can't run standalone.
//
// Grade convention: 10 points per Mastery Check, per
// feedback_lesson_point_scale.md's standing rule (10pt quizzes/assessments,
// not the older 100-point convention 01.1-01.6 still use live -- a known,
// pre-existing inconsistency, not fixed by this file).
//
// Include this file, then call build_mastery_check_quiz().

require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

/**
 * Create (or reuse) a question category scoped to the course context.
 */
function mcb_get_category($coursecontext, $categoryname) {
    global $DB;
    $existing = $DB->get_record('question_categories', ['name' => $categoryname, 'contextid' => $coursecontext->id]);
    if ($existing) {
        return $existing;
    }
    $category = new stdClass();
    $category->name = $categoryname;
    $category->contextid = $coursecontext->id;
    $category->info = '';
    $category->infoformat = FORMAT_HTML;
    $category->stamp = make_unique_id_code();
    $category->parent = 0;
    $category->sortorder = 999;
    $category->id = $DB->insert_record('question_categories', $category);
    return $category;
}

/**
 * $spec = [
 *   'name' => string,
 *   'questiontext' => string (HTML, no wrapping <p> needed),
 *   'defaultmark' => float (default 1),
 *   'usecase' => 0|1 (default 0, not case sensitive),
 *   'answers' => [ [text, fraction, feedback], ... ],
 * ]
 */
function mcb_create_shortanswer($category, $coursecontext, $spec) {
    global $USER;
    $qtype = question_bank::get_qtype('shortanswer');

    $question = new stdClass();
    $question->qtype = 'shortanswer';
    $question->category = $category->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $category->id;
    $form->context = $coursecontext;
    $form->name = $spec['name'];
    $form->questiontext = ['text' => $spec['questiontext'], 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = $spec['defaultmark'] ?? 1;
    $form->penalty = 0.3333333;
    $form->usecase = $spec['usecase'] ?? 0;

    $form->answer = [];
    $form->fraction = [];
    $form->feedback = [];
    foreach ($spec['answers'] as $a) {
        $form->answer[] = $a[0];
        $form->fraction[] = $a[1];
        $form->feedback[] = ['text' => $a[2] ?? '', 'format' => FORMAT_HTML];
    }

    $saved = $qtype->save_question($question, $form);
    echo "  Saved shortanswer '{$spec['name']}': id={$saved->id}\n";
    return $saved->id;
}

/**
 * $spec = [
 *   'name' => string,
 *   'questiontext' => string,
 *   'defaultmark' => float (default 1),
 *   'single' => 0|1 (default 1),
 *   'options' => [ [text, fraction, feedback], ... ],
 * ]
 */
function mcb_create_multichoice($category, $coursecontext, $spec) {
    global $USER;
    $qtype = question_bank::get_qtype('multichoice');

    $question = new stdClass();
    $question->qtype = 'multichoice';
    $question->category = $category->id;
    $question->contextid = $coursecontext->id;
    $question->createdby = $USER->id;
    $question->modifiedby = $USER->id;

    $form = new stdClass();
    $form->category = $category->id;
    $form->context = $coursecontext;
    $form->name = $spec['name'];
    $form->questiontext = ['text' => $spec['questiontext'], 'format' => FORMAT_HTML];
    $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
    $form->defaultmark = $spec['defaultmark'] ?? 1;
    $form->penalty = 0.3333333;
    $form->single = $spec['single'] ?? 1;
    $form->shuffleanswers = 1;
    $form->answernumbering = 'abc';
    $form->correctfeedback = ['text' => 'Correct.', 'format' => FORMAT_HTML];
    $form->partiallycorrectfeedback = ['text' => 'Partially correct.', 'format' => FORMAT_HTML];
    $form->incorrectfeedback = ['text' => 'Not quite.', 'format' => FORMAT_HTML];
    $form->shownumcorrect = 0;

    $form->answer = [];
    $form->fraction = [];
    $form->feedback = [];
    foreach ($spec['options'] as $o) {
        $form->answer[] = ['text' => $o[0], 'format' => FORMAT_HTML];
        $form->fraction[] = $o[1];
        $form->feedback[] = ['text' => $o[2] ?? '', 'format' => FORMAT_HTML];
    }

    $saved = $qtype->save_question($question, $form);
    echo "  Saved multichoice '{$spec['name']}': id={$saved->id}\n";
    return $saved->id;
}

/**
 * Builds the quiz module itself and attaches the given question ids.
 * $opts: course, section (int, human section number), name, intro (HTML),
 *        quizpassword, questionids (array), grade (default 10).
 */
function mcb_build_quiz($opts) {
    global $DB;

    $moduleinfo = new stdClass();
    $moduleinfo->modulename = 'quiz';
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'quiz']);
    $moduleinfo->course = $opts['course']->id;
    $moduleinfo->section = $opts['section'];
    $moduleinfo->visible = 1;
    $moduleinfo->name = $opts['name'];
    $moduleinfo->introeditor = ['text' => $opts['intro'], 'format' => FORMAT_HTML, 'itemid' => 0];
    $moduleinfo->quizpassword = $opts['quizpassword'];
    $moduleinfo->timeopen = 0;
    $moduleinfo->timeclose = 0;
    $moduleinfo->timelimit = 0;
    $moduleinfo->attempts = 3;
    $moduleinfo->grademethod = QUIZ_GRADEAVERAGE;
    $moduleinfo->preferredbehaviour = 'deferredfeedback';
    $moduleinfo->questionsperpage = 0;
    $moduleinfo->shuffleanswers = 1;
    $moduleinfo->navmethod = 'free';
    $moduleinfo->grade = $opts['grade'] ?? 10;
    $moduleinfo->completion = 1;

    $result = create_module($moduleinfo);
    $quiz = $DB->get_record('quiz', ['id' => $result->instance], '*', MUST_EXIST);

    foreach ($opts['questionids'] as $qid) {
        quiz_add_quiz_question($qid, $quiz, 0, 1);
    }
    $quizobj = \mod_quiz\quiz_settings::create($quiz->id);
    $quizobj->get_grade_calculator()->recompute_quiz_sumgrades();

    echo "Created quiz cmid={$result->coursemodule} quizid={$quiz->id}, " . count($opts['questionids']) . " questions added.\n";
    return $result;
}
