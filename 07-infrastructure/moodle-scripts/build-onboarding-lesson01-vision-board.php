<?php
// build-onboarding-lesson01-vision-board.php
//
// Onboarding course (id=6, foxcs-onboarding-l2), NEW Section 2: "Lesson 1: Explore &
// Envision" -- pre-pathway-choice exploration activity shared across all 3 Level 2
// pathways (Game Design/Unity, Web Development, Software Development), built once here
// since students haven't chosen a pathway yet and the combined course is how content
// reaches all of them regardless of eventual pathway. Due Wed 2026-09-02 15:30 Central
// via soft completionexpected (not a hard block), matching the standing rule applied
// everywhere else this session.
//
// 3 modules, in completion order:
//   1. "Explore & Envision: Guided Research" -- native branching Lesson. First choice
//      (App / Website / Game), then 2 tailored characteristic questions per branch,
//      each answer giving concrete search-term suggestions, ending in a shared recap
//      that hands off to the Vision Board assignment. Ungraded (grade=0) -- this is a
//      self-exploration tool, not a skill check.
//   2. "Vision Board" -- native Assignment, online text submission (paste a Google
//      Slides share link). Detailed structural recommendations in the intro since
//      there's no template (Jay's explicit call) and he wants real depth encouraged,
//      not a one-liner-per-slide board.
//   3. "Reflection" -- native Assignment, online text submission, numbered reflection
//      prompts in the intro (patterns noticed, pathway lean, what to research further).
//
// Run: sudo -u www-data php build-onboarding-lesson01-vision-board.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

\core\cron::setup_user();

const LESSON_EOL = -9;
const LESSON_PAGE_MULTICHOICE = 3;
const LESSON_PAGE_BRANCHTABLE = 20;

$course = $DB->get_record('course', ['id' => 6], '*', MUST_EXIST);

// Due: Wed 2026-09-02 15:30 America/Chicago, soft completionexpected only.
$duedt = new DateTime('2026-09-02 15:30:00', new DateTimeZone('America/Chicago'));
$duetimestamp = $duedt->getTimestamp();

// ---------------------------------------------------------------------------
// 0. Create Section 2.
// ---------------------------------------------------------------------------
$section2 = $DB->get_record('course_sections', ['course' => $course->id, 'section' => 2]);
if (!$section2) {
    $section2 = course_create_section($course->id, 2);
}
$section2->name = 'Lesson 1: Explore & Envision';
$section2->summary = '<p>Before you choose your Level 2 pathway, let\'s explore what already draws you in. This lesson helps you notice patterns in the apps, websites, and games you already love, so you head into your pathway choice with a real sense of your own taste and interests.</p>';
$section2->summaryformat = FORMAT_HTML;
$DB->update_record('course_sections', $section2);
echo "Section 2 ready: id={$section2->id}\n";

// ---------------------------------------------------------------------------
// 1. Guided Research Lesson (branching: App / Website / Game).
// ---------------------------------------------------------------------------
$moduleinfo = new stdClass();
$moduleinfo->modulename = 'lesson';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'lesson']);
$moduleinfo->course = $course->id;
$moduleinfo->section = 2;
$moduleinfo->visible = 1;
$moduleinfo->name = '1.1 Explore & Envision: Guided Research';
$moduleinfo->introeditor = [
    'text' => '<p>A few quick questions to help you figure out what to search for when you '
        . 'build your Vision Board. There are no wrong answers here, just pick what\'s '
        . 'actually true for you.</p>',
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$moduleinfo->grade = 0;
$moduleinfo->custom = 1;
$moduleinfo->retake = 0;
$moduleinfo->modattempts = 1;
$moduleinfo->review = 0;
$moduleinfo->feedback = 1;
$moduleinfo->practice = 0;
$moduleinfo->usepassword = 0;
$moduleinfo->maxanswers = 4;
$moduleinfo->displayleft = 0;
$moduleinfo->displayleftif = 0;
$moduleinfo->mediafile = 0;

$result = create_module($moduleinfo);
$lessoncmid = $result->coursemodule;
$lessonid = $result->id;
echo "Created lesson: cmid={$lessoncmid} lessonid={$lessonid}\n";

function foxcs_insert_lesson_page($DB, $lessonid, $title, $contents, $qtype, $prevpageid) {
    $page = new stdClass();
    $page->lessonid = $lessonid;
    $page->title = $title;
    $page->contents = $contents;
    $page->contentsformat = FORMAT_HTML;
    $page->qtype = $qtype;
    $page->qoption = 0;
    $page->layout = 1;
    $page->display = 1;
    $page->timecreated = time();
    $page->timemodified = time();
    $page->prevpageid = $prevpageid;
    $page->nextpageid = 0;
    $page->id = $DB->insert_record('lesson_pages', $page);
    if ($prevpageid) {
        $DB->set_field('lesson_pages', 'nextpageid', $page->id, ['id' => $prevpageid]);
    }
    return $page->id;
}

function foxcs_insert_answer($DB, $lessonid, $pageid, $answerhtml, $responsehtml, $jumpto, $score) {
    $a = new stdClass();
    $a->lessonid = $lessonid;
    $a->pageid = $pageid;
    $a->answer = $answerhtml;
    $a->answerformat = FORMAT_HTML;
    $a->response = $responsehtml;
    $a->responseformat = FORMAT_HTML;
    $a->jumpto = $jumpto;
    $a->score = $score;
    $a->timecreated = time();
    $a->timemodified = time();
    return $DB->insert_record('lesson_answers', $a);
}

// --- Page order: create pages first with placeholder links, wire jumps after ---

$introhtml = <<<'HTML'
<p>Right now, which are you most drawn to?</p>
<p>Think about what you actually spend time on and enjoy, not what you think you "should" pick.</p>
HTML;
$introid = foxcs_insert_lesson_page($DB, $lessonid, 'Start Here', $introhtml, LESSON_PAGE_MULTICHOICE, 0);

// App branch
$appq1html = '<p>When you think of an app you love using, what stands out most?</p>';
$appq1id = foxcs_insert_lesson_page($DB, $lessonid, 'App: Question 1', $appq1html, LESSON_PAGE_MULTICHOICE, $introid);

$appq2html = '<p>Think about how an app makes you <strong>feel</strong> when you use it. Which matters most to you?</p>';
$appq2id = foxcs_insert_lesson_page($DB, $lessonid, 'App: Question 2', $appq2html, LESSON_PAGE_MULTICHOICE, $appq1id);

// Website branch
$webq1html = '<p>When you think of a website you love, what stands out most?</p>';
$webq1id = foxcs_insert_lesson_page($DB, $lessonid, 'Website: Question 1', $webq1html, LESSON_PAGE_MULTICHOICE, $appq2id);

$webq2html = '<p>What kind of website design do you gravitate toward?</p>';
$webq2id = foxcs_insert_lesson_page($DB, $lessonid, 'Website: Question 2', $webq2html, LESSON_PAGE_MULTICHOICE, $webq1id);

// Game branch
$gameq1html = '<p>When you think of a game you love, what stands out most?</p>';
$gameq1id = foxcs_insert_lesson_page($DB, $lessonid, 'Game: Question 1', $gameq1html, LESSON_PAGE_MULTICHOICE, $webq2id);

$gameq2html = '<p>What mood or vibe draws you into a game?</p>';
$gameq2id = foxcs_insert_lesson_page($DB, $lessonid, 'Game: Question 2', $gameq2html, LESSON_PAGE_MULTICHOICE, $gameq1id);

// Ending recap
$endhtml = <<<'HTML'
<h3>Now You Know What to Look For</h3>
<p>Head to the <strong>Vision Board</strong> assignment next. Start collecting real examples, screenshots, links, or clear descriptions, of apps, websites, or games that show the qualities you just picked out.</p>
<p>Aim for at least 4&ndash;6 examples. If something outside your main category catches your eye too (a website when you mostly picked "game," for instance) include it. Following genuine interest matters more than staying inside one lane.</p>
HTML;
$endid = foxcs_insert_lesson_page($DB, $lessonid, 'What to Search For', $endhtml, LESSON_PAGE_BRANCHTABLE, $gameq2id);

// --- Answers: Start Here (3-way branch, no wrong answer) ---
foxcs_insert_answer($DB, $lessonid, $introid, 'An app or piece of software',
    "Great, let's think about what makes an app feel good to use.", $appq1id, 1);
foxcs_insert_answer($DB, $lessonid, $introid, 'A website',
    "Great, let's think about what makes a website work for you.", $webq1id, 1);
foxcs_insert_answer($DB, $lessonid, $introid, 'A game',
    "Great, let's think about what pulls you into a game.", $gameq1id, 1);

// --- App: Q1 ---
foxcs_insert_answer($DB, $lessonid, $appq1id, "It's simple, fast, and easy to use",
    'Search for: "clean app UI examples," "minimalist app design."', $appq2id, 1);
foxcs_insert_answer($DB, $lessonid, $appq1id, 'It looks great, strong visual style',
    'Search for: "app UI design trends," "app color palette inspiration."', $appq2id, 1);
foxcs_insert_answer($DB, $lessonid, $appq1id, 'It has fun animations or interactive touches',
    'Search for: "app microinteractions," "gamified app design."', $appq2id, 1);
foxcs_insert_answer($DB, $lessonid, $appq1id, "It just does one thing really, really well",
    'Search for: "best utility app design," "focused productivity app UI."', $appq2id, 1);

// --- App: Q2 ---
foxcs_insert_answer($DB, $lessonid, $appq2id, 'Trustworthy and professional',
    'Search for: "professional app design examples," "trustworthy UI patterns."', $webq1id, 1);
foxcs_insert_answer($DB, $lessonid, $appq2id, 'Fun and playful',
    'Search for: "playful app design," "fun UI animations."', $webq1id, 1);
foxcs_insert_answer($DB, $lessonid, $appq2id, 'Calm and focused',
    'Search for: "calm app design," "minimal focus app UI."', $webq1id, 1);
foxcs_insert_answer($DB, $lessonid, $appq2id, 'Fast and efficient',
    'Search for: "fast UI patterns," "efficient app workflows."', $webq1id, 1);

// --- Website: Q1 ---
foxcs_insert_answer($DB, $lessonid, $webq1id, "It's easy to navigate, I can find things fast",
    'Search for: "clean website navigation examples," "website UX design."', $webq2id, 1);
foxcs_insert_answer($DB, $lessonid, $webq1id, 'Bold visual style, graphics, or typography',
    'Search for: "bold website typography," "website visual design inspiration."', $webq2id, 1);
foxcs_insert_answer($DB, $lessonid, $webq1id, 'Interactive touches, like animations or scroll effects',
    'Search for: "website scroll animation examples," "interactive website design."', $webq2id, 1);
foxcs_insert_answer($DB, $lessonid, $webq1id, 'The content itself is genuinely useful or well-written',
    'Search for: "content-first website design," "great website copywriting."', $webq2id, 1);

// --- Website: Q2 ---
foxcs_insert_answer($DB, $lessonid, $webq2id, 'Minimal and modern',
    'Search for: "minimalist website design examples."', $gameq1id, 1);
foxcs_insert_answer($DB, $lessonid, $webq2id, 'Bold and colorful, even maximalist',
    'Search for: "maximalist website design examples."', $gameq1id, 1);
foxcs_insert_answer($DB, $lessonid, $webq2id, 'Retro or nostalgic',
    'Search for: "retro website design," "Y2K web design."', $gameq1id, 1);
foxcs_insert_answer($DB, $lessonid, $webq2id, 'Dark mode and moody',
    'Search for: "dark mode website design examples."', $gameq1id, 1);

// --- Game: Q1 ---
foxcs_insert_answer($DB, $lessonid, $gameq1id, 'The art style or visual world',
    'Search for: "game art style examples," "[genre] game concept art."', $gameq2id, 1);
foxcs_insert_answer($DB, $lessonid, $gameq1id, 'The story or characters',
    'Search for: "best game narrative design," "game character design."', $gameq2id, 1);
foxcs_insert_answer($DB, $lessonid, $gameq1id, 'How it feels to actually play, the controls and systems',
    'Search for: "game mechanics breakdown," "game feel design."', $gameq2id, 1);
foxcs_insert_answer($DB, $lessonid, $gameq1id, 'Playing with or against other people',
    'Search for: "multiplayer game design examples," "social game features."', $gameq2id, 1);

// --- Game: Q2 ---
foxcs_insert_answer($DB, $lessonid, $gameq2id, 'Cozy and relaxing',
    'Search for: "cozy game aesthetic examples."', $endid, 1);
foxcs_insert_answer($DB, $lessonid, $gameq2id, 'Intense and high-stakes',
    'Search for: "intense game design examples."', $endid, 1);
foxcs_insert_answer($DB, $lessonid, $gameq2id, 'Funny and lighthearted',
    'Search for: "lighthearted game design examples."', $endid, 1);
foxcs_insert_answer($DB, $lessonid, $gameq2id, 'Mysterious and atmospheric',
    'Search for: "atmospheric game design examples."', $endid, 1);

// --- Ending page: Continue button ---
foxcs_insert_answer($DB, $lessonid, $endid, 'Continue to the Vision Board assignment', null, LESSON_EOL, 0);

echo "Pages: Start={$introid} AppQ1={$appq1id} AppQ2={$appq2id} WebQ1={$webq1id} WebQ2={$webq2id} GameQ1={$gameq1id} GameQ2={$gameq2id} End={$endid}\n";

$DB->set_field('course_modules', 'completion', 2, ['id' => $lessoncmid]);
$DB->set_field('course_modules', 'completionexpected', $duetimestamp, ['id' => $lessoncmid]);
$DB->set_field('lesson', 'completionendreached', 1, ['id' => $lessonid]);

// ---------------------------------------------------------------------------
// 2. Vision Board Assignment.
// ---------------------------------------------------------------------------
$vbinfo = new stdClass();
$vbinfo->modulename = 'assign';
$vbinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$vbinfo->course = $course->id;
$vbinfo->section = 2;
$vbinfo->visible = 1;
$vbinfo->name = '1.2 Vision Board';
$vbinfo->introeditor = [
    'text' => <<<'HTML'
<p>Build a Google Slides vision board, a real, dense visual collage of things that draw you in: games, apps, websites, software, whatever genuinely interests you. This is about exploring broadly and starting to notice your own taste, not picking a pathway yet.</p>

<p><strong>You'll be sharing this with the class</strong>, so treat it like a real presentation, not a private notes doc.</p>

<h3>What to Include</h3>
<ul>
<li><strong>Cover slide:</strong> your name/codename and a title.</li>
<li><strong>At least 30 images, total, arranged as collages.</strong> Think mood board, not a slideshow: several images per page, grouped however makes sense to you. This is NOT one-image-per-slide. Pull from art styles in games, UI styling in apps and websites, and anything else that genuinely pulls you in.</li>
<li><strong>At least 10 color schemes or palettes</strong> you're drawn to, on their own page(s), separate from and not counted in the 30 images above. These can be palettes you find, screenshots that show a color scheme clearly, or swatches you put together yourself.</li>
<li><strong>Closing slide, "What I Want to Learn More About":</strong> 2&ndash;3 things you noticed yourself gravitating toward that you'd like to research or learn more about.</li>
</ul>

<h3>The Only Text Rule: Theme Labels Only</h3>
<p>Don't caption individual images. The <strong>only</strong> text allowed on a collage page is one short label naming the theme of that whole page, think of it like a section heading, not a description of each picture. A few examples of real theme labels:</p>
<ul>
<li>"Cozy Game Aesthetics"</li>
<li>"Minimalist App UI"</li>
<li>"Bold Website Typography"</li>
<li>"Color Palettes I Love"</li>
<li>"Game HUD Designs"</li>
<li>"Dark Mode Everything"</li>
</ul>
<p>You'll do the deeper thinking about what specifically draws you to each theme in the Reflection assignment right after this. This assignment is about the visuals themselves.</p>

<p><strong>Go deep and wide.</strong> The point is real exploration, actually diving into art styles, UI styling, and color to start understanding what you're drawn to, not landing on a few safe picks. 30 images and 10 color schemes are minimums, not targets, use as many slides and as many images as you actually want.</p>

<p><strong>Every image needs to actually be visible.</strong> Someone in the back of the room should be able to tell what each picture is. If a page is so packed that the images shrink down to nothing, split it into more pages. More slides is always fine.</p>

<p><strong>This can keep growing.</strong> You don't have to be "done" forever, you can keep adding to this vision board over time as you find more things that interest you.</p>

<p><strong>Visuals first, always.</strong> Images should completely dominate every page.</p>

<h3>How to Submit</h3>
<ol>
<li>Create a new Google Slides presentation.</li>
<li>Share it so anyone with the link can view.</li>
<li>Paste the share link into the text box below.</li>
</ol>
HTML,
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$vbinfo->duedate = 0;
$vbinfo->allowsubmissionsfromdate = 0;
$vbinfo->cutoffdate = 0;
$vbinfo->gradingduedate = 0;
$vbinfo->grade = 100; // grade=0 (ungraded) hits a real circular-dependency bug in
// assign_grade_item_update()/is_gradebook_feedback_enabled() -- it instantiates the
// assign class to check feedback settings, which itself needs the grade item to
// already exist, so no grade item ever gets created and the module 500s on load.
// Use a nominal positive grade instead; completion is tracked via completion=1
// (manual), not this grade value.
$vbinfo->assignsubmission_onlinetext_enabled = 1;
$vbinfo->assignsubmission_file_enabled = 0;
$vbinfo->submissiondrafts = 0;
$vbinfo->requiresubmissionstatement = 0;
$vbinfo->sendnotifications = 0;
$vbinfo->sendlatenotifications = 0;
$vbinfo->sendstudentnotifications = 1;
$vbinfo->teamsubmission = 0;
$vbinfo->requireallteammemberssubmit = 0;
$vbinfo->blindmarking = 0;
$vbinfo->attemptreopenmethod = 'none';
$vbinfo->maxattempts = -1;
$vbinfo->markingworkflow = 0;
$vbinfo->markinganonymous = 0;

$vbresult = create_module($vbinfo);
$vbcmid = $vbresult->coursemodule;
echo "Created Vision Board assignment: cmid={$vbcmid}\n";

$DB->set_field('course_modules', 'completion', 1, ['id' => $vbcmid]);
$DB->set_field('course_modules', 'completionexpected', $duetimestamp, ['id' => $vbcmid]);

// ---------------------------------------------------------------------------
// 3. Reflection Assignment.
// ---------------------------------------------------------------------------
$refinfo = new stdClass();
$refinfo->modulename = 'assign';
$refinfo->module = $DB->get_field('modules', 'id', ['name' => 'assign']);
$refinfo->course = $course->id;
$refinfo->section = 2;
$refinfo->visible = 1;
$refinfo->name = '1.3 Reflection';
$refinfo->introeditor = [
    'text' => <<<'HTML'
<p>Answer all four in the text box below. Write in complete sentences, real detail beats a quick one-liner.</p>
<ol>
<li><strong>Patterns:</strong> Looking across all your examples, what patterns do you notice? Think about colors, styles, moods, or the kind of interactions you kept picking.</li>
<li><strong>Pathway lean:</strong> Based on what you explored, which pathway (Game Design/Unity, Web Development, or Software Development) feels like it connects most to what you're drawn to right now? Why? It's okay if you're still not sure, say that too, and what would help you decide.</li>
<li><strong>Research further:</strong> Pick one thing from your vision board you want to research or learn more about. What is it, and why did it stand out?</li>
<li><strong>Surprise:</strong> Was there anything about your own taste or interests that surprised you while doing this?</li>
</ol>
HTML,
    'format' => FORMAT_HTML,
    'itemid' => 0,
];
$refinfo->duedate = 0;
$refinfo->allowsubmissionsfromdate = 0;
$refinfo->cutoffdate = 0;
$refinfo->gradingduedate = 0;
$refinfo->grade = 100; // see note above on vbinfo->grade -- grade=0 breaks assign.
$refinfo->assignsubmission_onlinetext_enabled = 1;
$refinfo->assignsubmission_file_enabled = 0;
$refinfo->submissiondrafts = 0;
$refinfo->requiresubmissionstatement = 0;
$refinfo->sendnotifications = 0;
$refinfo->sendlatenotifications = 0;
$refinfo->sendstudentnotifications = 1;
$refinfo->teamsubmission = 0;
$refinfo->requireallteammemberssubmit = 0;
$refinfo->blindmarking = 0;
$refinfo->attemptreopenmethod = 'none';
$refinfo->maxattempts = -1;
$refinfo->markingworkflow = 0;
$refinfo->markinganonymous = 0;

$refresult = create_module($refinfo);
$refcmid = $refresult->coursemodule;
echo "Created Reflection assignment: cmid={$refcmid}\n";

$DB->set_field('course_modules', 'completion', 1, ['id' => $refcmid]);
$DB->set_field('course_modules', 'completionexpected', $duetimestamp, ['id' => $refcmid]);

rebuild_course_cache($course->id, true);
echo "Done. Lesson cmid={$lessoncmid}, Vision Board cmid={$vbcmid}, Reflection cmid={$refcmid}\n";
