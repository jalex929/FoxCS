<?php
// restructure-unit02-ce-headings.php
//
// Unit 02 Coding Exercise instructions (cmid 264-267), per Jay's direct
// feedback 2026-09-09: give the whole instructions block one large heading
// ("Instructions"), then make "Video(s)", "Code File(s)", "What To Do", and
// "How To Submit" four parallel sub-headings one level smaller. "What To
// Do"'s first step now refers back to "the file named above" instead of
// re-stating the filename, since "Code File(s)" already names it -- keeps
// the labeling and the instructions pointing at the same thing instead of
// saying it twice in slightly different words.
//
// Latest change: "Code File(s)" now names the file as a real clickable
// pluginfile.php link straight to the introattachment, instead of forcing
// students to scroll past What To Do/How To Submit down to Moodle's native
// "Additional files" listing at the bottom of the page to actually get it.
// Verified live as foxcstest that this exact URL shape (pluginfile.php/
// <module context id>/mod_assign/introattachment/0/<filename>) resolves and
// downloads the real file before baking it into all 4.
//
// Run: sudo -u www-data php restructure-unit02-ce-headings.php

define('CLI_SCRIPT', true);
require('/var/www/moodle/config.php');
$CFG->debug = 32767;
$CFG->debugdisplay = 1;
error_reporting(E_ALL);

\core\cron::setup_user();

$updates = [
    264 => [
        'topic' => 'This exercise is about <strong>integers</strong> -- whole numbers with no decimal point. Work on this coding exercise while you watch the video.',
        'video' => 'int',
        'codefile' => 'GMETRIX-112-numbers.py',
        'whattodo' => '<ol><li>Download the file(s) above and open them in VS Code (File &gt; Open File &gt; choose the file to open).</li><li>Follow the numbered steps written as comments inside the file -- they walk you through a fill-in-the-blank question and a short coding task.</li><li>Run the file in VS Code to check your work as you go.</li></ol>',
        'submit' => '<p>Save your finished file as <strong>GMETRIX-112-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p><p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    265 => [
        'topic' => 'This exercise is about <strong>floats</strong> -- numbers with a decimal point -- and what happens when you do math with them. Work on this coding exercise while you watch the video.',
        'video' => 'float',
        'codefile' => 'GMETRIX-113-numbers.py',
        'whattodo' => '<ol><li>Download the file(s) above and open them in VS Code (File &gt; Open File &gt; choose the file to open).</li><li>Follow the numbered steps in the file\'s comments: you\'ll add a calculation, change it, and answer two questions about what data type came back.</li><li>Run the file in VS Code to check your work as you go.</li></ol>',
        'submit' => '<p>Save your finished file as <strong>GMETRIX-113-numbers-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p><p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    266 => [
        'topic' => 'This exercise is about <strong>strings</strong> -- text wrapped in quotation marks. Work on this coding exercise while you watch the video.',
        'video' => 'str',
        'codefile' => 'GMETRIX-111-str.py',
        'whattodo' => '<ol><li>Download the file(s) above and open them in VS Code (File &gt; Open File &gt; choose the file to open).</li><li>Follow the numbered steps in the file\'s comments: you\'ll print a full name, then answer two quoting questions.</li><li>Run the file in VS Code to check your work as you go.</li></ol>',
        'submit' => '<p>Save your finished file as <strong>GMETRIX-111-str-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p><p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
    267 => [
        'topic' => 'This exercise is about <strong>booleans</strong> -- values that are only ever <code>True</code> or <code>False</code>. Work on this coding exercise while you watch the video.',
        'video' => 'bool',
        'codefile' => 'GMETRIX-114-boolean.py',
        'whattodo' => '<ol><li>Download the file(s) above and open them in VS Code (File &gt; Open File &gt; choose the file to open).</li><li>Run it first, exactly as it is. Read the error carefully -- it\'s telling you something real about Python.</li><li>Follow the numbered steps in the file\'s comments to fix the bug and answer a casing question.</li></ol>',
        'submit' => '<p>Save your finished file as <strong>GMETRIX-114-boolean-completed.py</strong> (a hyphen before &quot;completed&quot;, not an underscore -- this matches GMetrix\'s own naming). Upload it below.</p><p>If you can\'t upload for some reason, paste a backup link (for example, a shared Google Drive link) in the text box below instead. Never paste your actual code into the text box, only a link.</p>',
    ],
];

foreach ($updates as $cmid => $d) {
    $modcontext = context_module::instance($cmid);
    $fileurl = moodle_url::make_pluginfile_url(
        $modcontext->id, 'mod_assign', 'introattachment', 0, '/', $d['codefile']
    );
    $codefilelink = '<a href="' . $fileurl->out(false) . '">' . $d['codefile'] . '</a>';

    $intro = '<h2>Instructions</h2>'
        . '<p>' . $d['topic'] . '</p>'
        . '<h3>Video(s)</h3>'
        . '<p>' . $d['video'] . '</p>'
        . '<h3>Code File(s)</h3>'
        . '<p>' . $codefilelink . '</p>'
        . '<h3>What To Do</h3>'
        . $d['whattodo']
        . '<h3>How To Submit</h3>'
        . $d['submit'];

    $cm = $DB->get_record('course_modules', ['id' => $cmid], '*', MUST_EXIST);
    $assign = $DB->get_record('assign', ['id' => $cm->instance], '*', MUST_EXIST);
    $DB->set_field('assign', 'intro', $intro, ['id' => $assign->id]);
    echo "Updated cmid={$cmid} (assign id={$assign->id})\n";
}

echo "Done.\n";
