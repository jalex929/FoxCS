<?php
// Prototype for the 2026-09-04 structural brainstorm's "Option C": a plain
// mod_resource page (the exact module type that hits the "can't be marked
// done" ceiling -- see decisions-log.md) whose own JS calls the new
// local_foxcstelemetry endpoint to log telemetry and mark itself complete,
// without adopting SCORM or rebuilding into native H5P/question types.
//
// Two-phase because the page's JS needs to know its own cmid to call the
// endpoint, and a static resource has no server-side templating: (1) create
// the module with a placeholder file to get a real cmid, (2) replace the
// file content with the real page, cmid baked in.
//
// Run: php create-sandbox-completion-prototype.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/lib/resourcelib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');

\core\cron::setup_user();

$course = $DB->get_record('course', ['shortname' => 'sandbox-adaptive-demo'], '*', MUST_EXIST);
$sectionnum = 1;

// --- Phase 1: create the shell module with a placeholder file. ---
$fs = get_file_storage();
$usercontext = context_user::instance($USER->id);
$draftitemid = file_get_unused_draft_itemid();
$fs->create_file_from_string([
    'contextid' => $usercontext->id,
    'component' => 'user',
    'filearea' => 'draft',
    'itemid' => $draftitemid,
    'filepath' => '/',
    'filename' => 'index.html',
], '<html><body>placeholder</body></html>');

$moduleinfo = new stdClass();
$moduleinfo->modulename = 'resource';
$moduleinfo->module = $DB->get_field('modules', 'id', ['name' => 'resource']);
$moduleinfo->course = $course->id;
$moduleinfo->section = $sectionnum;
$moduleinfo->visible = 1;
$moduleinfo->name = 'Completion Prototype: Comments Recap';
$moduleinfo->introeditor = ['text' => '', 'format' => FORMAT_HTML, 'itemid' => 0];
$moduleinfo->files = $draftitemid;
$moduleinfo->display = RESOURCELIB_DISPLAY_EMBED;
// Manual completion tracking: lets our own endpoint call update_state()
// without needing the moodle/course:overridecompletion capability -- see
// completionlib.php's update_state(), acts exactly like the student ticking
// Moodle's own manual-completion checkbox, just triggered by our JS instead.
$moduleinfo->completion = COMPLETION_TRACKING_MANUAL;
$moduleinfo->completionview = 0;
$moduleinfo->completionexpected = 0;

$result = create_module($moduleinfo);
$cmid = $result->coursemodule;
echo "Created resource cmid={$cmid}\n";

// --- Phase 2: replace the placeholder with the real page, cmid baked in. ---
$modcontext = context_module::instance($cmid);
$fs->delete_area_files($modcontext->id, 'mod_resource', 'content', 0);

$html = <<<HTML
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: -apple-system, "Segoe UI", Roboto, sans-serif; margin: 0; padding: 1.4rem 1.6rem; color: #222; }
  .foxcs-tabset { border:1px solid #dee2e6; border-radius:10px; overflow:hidden; box-shadow:0 1px 2px rgba(16,24,32,0.06); margin-bottom:1.2rem; }
  .foxcs-tabset input[type="radio"] { position:absolute; opacity:0; pointer-events:none; }
  .foxcs-tab-labels { display:flex; flex-wrap:wrap; background:#f8f9fa; border-bottom:1px solid #dee2e6; margin:0; }
  .foxcs-tab-labels label { padding:0.7rem 1rem; font-size:0.88rem; font-weight:600; color:#6a737b; cursor:pointer; border-bottom:3px solid transparent; }
  .foxcs-tab-labels label:hover { color:#0f6cbf; background:#eaf3fb; }
  .foxcs-tab-panel { display:none; padding:1.3rem 1.4rem; }
  #t1:checked ~ .foxcs-tab-labels label[for="t1"],
  #t2:checked ~ .foxcs-tab-labels label[for="t2"] { color:#0f6cbf; border-bottom-color:#0f6cbf; background:#fff; }
  #t1:checked ~ .panels .p1, #t2:checked ~ .panels .p2 { display:block; }
  pre { background:#eef1f5; padding:0.5rem 0.8rem; border-radius:3px; font-family:Consolas,monospace; }
  .drill { border:1px solid #d7dee8; border-radius:10px; padding:1rem 1.2rem; margin-top:1rem; }
  .drill button { padding:0.5rem 0.9rem; border-radius:6px; border:1px solid #0f6cbf; background:#0f6cbf; color:#fff; cursor:pointer; font-size:0.9rem; margin-right:0.4rem; }
  .drill button:disabled { opacity:0.5; cursor:default; }
  .feedback { margin-top:0.7rem; font-weight:600; }
  .feedback.correct { color:#1a7f37; }
  .feedback.incorrect { color:#b3261e; }
  #complete-banner { display:none; margin-top:1.2rem; padding:0.9rem 1.1rem; border-radius:10px; background:#e6f4ea; border:1px solid #b7e0c3; color:#1a7f37; font-weight:700; }
  #save-status { font-size:0.8rem; color:#6a737b; margin-top:0.5rem; }
</style>
</head>
<body>

<h1>Comments Recap (Completion Prototype)</h1>

<div class="foxcs-tabset">
  <input type="radio" name="tabs" id="t1" checked>
  <input type="radio" name="tabs" id="t2">
  <div class="foxcs-tab-labels">
    <label for="t1">What's a Comment?</label>
    <label for="t2">Try It</label>
  </div>
  <div class="panels">
    <div class="foxcs-tab-panel p1">
      <p>A <strong>comment</strong> is a line Python completely ignores when it runs. Anything after a <code>#</code> is a comment.</p>
      <pre># This line is ignored
print("Hello!")</pre>
    </div>
    <div class="foxcs-tab-panel p2">
      <div class="drill" id="drill">
        <p>Which line is a comment?</p>
        <button data-correct="0">print("Hi")</button>
        <button data-correct="1"># print("Hi")</button>
        <div class="feedback" id="drill-feedback"></div>
      </div>
    </div>
  </div>
</div>

<div id="complete-banner">&#10003; Saved -- marked complete.</div>
<div id="save-status"></div>

<script>
(function () {
  var CMID = {$cmid};
  var ENDPOINT = '/local/foxcstelemetry/log.php';
  var sesskey = null;
  var statusEl = document.getElementById('save-status');

  function bootstrap(cb) {
    fetch(ENDPOINT + '?action=bootstrap&cmid=' + CMID, { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) { sesskey = data.sesskey; cb(); })
      .catch(function (e) { statusEl.textContent = 'Could not reach telemetry endpoint.'; });
  }

  function logEvent(eventtype, payload, complete) {
    if (!sesskey) { bootstrap(function () { logEvent(eventtype, payload, complete); }); return; }
    var body = new URLSearchParams();
    body.set('action', 'log');
    body.set('sesskey', sesskey);
    body.set('cmid', CMID);
    body.set('eventtype', eventtype);
    body.set('payload', JSON.stringify(payload));
    if (complete) body.set('complete', '1');
    fetch(ENDPOINT, { method: 'POST', credentials: 'same-origin', body: body })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        statusEl.textContent = 'Saved ' + new Date().toLocaleTimeString() + '.';
        if (data.completed) {
          document.getElementById('complete-banner').style.display = 'block';
        }
      })
      .catch(function (e) { statusEl.textContent = 'Save failed, will not block you from continuing.'; });
  }

  bootstrap(function () {
    logEvent('viewed', { tab: 'What\\'s a Comment?' }, false);
  });

  document.querySelectorAll('#drill button').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var correct = btn.dataset.correct === '1';
      var fb = document.getElementById('drill-feedback');
      fb.textContent = correct ? 'Right -- the # marks it as a comment.' : 'Not quite -- look for the #.';
      fb.className = 'feedback ' + (correct ? 'correct' : 'incorrect');
      logEvent('drill_attempt', { correct: correct, buttonText: btn.textContent }, false);
      if (correct) {
        document.querySelectorAll('#drill button').forEach(function (b) { b.disabled = true; });
        logEvent('lesson_complete', { drillCorrect: true }, true);
      }
    });
  });
})();
</script>

</body>
</html>
HTML;

$fs->create_file_from_string([
    'contextid' => $modcontext->id,
    'component' => 'mod_resource',
    'filearea' => 'content',
    'itemid' => 0,
    'filepath' => '/',
    'filename' => 'index.html',
], $html);

file_set_sortorder($modcontext->id, 'mod_resource', 'content', 0, '/', 'index.html', 1);

echo "Wrote real content, cmid={$cmid}. Visit as foxcstest to test.\n";
