<?php
// check-lesson-ladder-wiring.php
//
// PURPOSE
//   Automated wiring checker for a Moodle Lesson activity (mod_lesson) that
//   implements FoxCS's Reinforce/Core/Extend adaptive-practice ladder (see
//   ../objectives-and-skills-proficiency.md's "Reinforce / Core / Extend
//   Ladder" section for the policy, ../moodle-lesson-ladder-setup.md for the
//   click-by-click mechanics/vocabulary this script assumes).
//
//   Built per recommendation 3 of pipeline-comparison-python-app-2026-08-31.md
//   ("tie every new authoring rule to a real check, even a cheap one") and in
//   direct response to authoring-flow-gaps-2026-08-11.md's finding that every
//   content-QA catch so far has been a human reading closely, with nothing
//   automated. This is a READ-ONLY validator — it never writes to the Moodle
//   database (only $DB->get_record()/get_records() calls against lesson /
//   lesson_pages / lesson_answers). It does not build, fix, or edit ladder
//   content.
//
//   It checks three things for one Lesson activity:
//
//   1. DANGLING JUMPS
//      Every answer's `jumpto` either resolves to a real page id in the same
//      lesson, or is one of Moodle's documented special jump values
//      (LESSON_NEXTPAGE -1, LESSON_THISPAGE 0, LESSON_EOL -9). Any other
//      negative special (LESSON_UNSEENBRANCHPAGE -50, LESSON_PREVIOUSPAGE
//      -40, LESSON_RANDOMPAGE -60, LESSON_RANDOMBRANCH -70,
//      LESSON_CLUSTERJUMP -80) is flagged as a WARNING, since none of those
//      are part of the simple, shallow ladder design this course uses
//      (moodle-lesson-ladder-setup.md: "no separate branching feature to
//      learn, it's just that every answer picks its own next page"). A
//      dangling positive jumpto (no matching page id in this lesson) is a
//      hard ERROR.
//
//   2. STICKY-ENDPOINT / LANE-CROSSING
//      Pages are classified into a "lane" (Core / Reinforce / Extend /
//      Reteach / other) by matching the lane keyword in the page title,
//      per the naming convention moodle-lesson-ladder-setup.md recommends
//      (e.g. "5.3 Reinforce 1", "5.3 Extend 2", "5.3 Reteach"). The check:
//        - No answer on a Reinforce-lane page may jump to an Extend-lane
//          page, and no answer on an Extend-lane page may jump to a
//          Reinforce-lane page (the two lanes must never cross).
//        - A page whose title matches "Reteach" must actually be a Content
//          page (qtype LESSON_PAGE_BRANCHTABLE = 20), not a question page —
//          the setup doc is explicit a Reteach page is static content, not
//          another auto-served question.
//      NOTE ON SCOPE: this script does NOT attempt to replicate Moodle's
//      per-question-type "is this answer correct" logic (that logic lives
//      in each mod/lesson/pagetypes/*.php class and differs per qtype). It
//      checks the lane-crossing invariant on every answer's jump target
//      regardless of whether that answer is the "right" or "wrong" one,
//      which is a strictly stronger check than only checking the "wrong"
//      answer (if no answer on a Reinforce page ever reaches Extend, the
//      wrong-answer path certainly doesn't either) and needs no
//      correctness simulation to be reliable.
//
//   3. POOL-SIZE CAP
//      Pages are grouped into "skill clusters" by stripping the lane
//      keyword and trailing item number from the title (e.g. "5.3
//      Reinforce 1" and "5.3 Reinforce 2" both belong to cluster "5.3",
//      lane Reinforce). The count of Reinforce pages in a cluster, and
//      separately the count of Extend pages, must not exceed the pool-size
//      cap. Default cap is 4, the upper bound of the "Reinforce 2-4 /
//      Extend 2-4 per skill" range in objectives-and-skills-proficiency.md's
//      "Pool sizing" note as of 2026-08-31 -- that note explicitly says the
//      exact number is still unresolved/being pressure-tested, so RE-CHECK
//      THIS DEFAULT against the current text of that file's "Reinforce /
//      Core / Extend Ladder" section before trusting a flagged violation,
//      and override with --pool-cap=N if the reconciled number differs.
//
//   Also prints an informational note (not an error) if a Core-lane page's
//   answers resolve to jump targets outside the {Reinforce, Extend} lanes,
//   since the design calls for "a Core question with exactly two outcomes,
//   wrong -> Reinforce, right -> Extend, no answer-specific branch targets
//   beyond right/wrong."
//
// USAGE
//   sudo -u www-data php check-lesson-ladder-wiring.php --cmid=<cmid>
//   sudo -u www-data php check-lesson-ladder-wiring.php --lesson=<lessonid>
//   sudo -u www-data php check-lesson-ladder-wiring.php --lesson=<id> --pool-cap=5
//
// EXAMPLE
//   sudo -u www-data php check-lesson-ladder-wiring.php --cmid=214
//
// EXIT CODE
//   0 if no ERRORs were found (WARNINGs/NOTEs don't fail the run).
//   1 if any ERROR was found, or the lesson/cmid couldn't be resolved.
//
// STRUCTURE / TESTABILITY
//   All the actual rule-checking logic below (ladder_classify_title,
//   ladder_run_checks, ladder_format_report) is pure -- it takes plain
//   arrays of page/answer objects and returns results, with no Moodle or
//   database dependency. The only DB-touching code is the CLI entrypoint
//   at the bottom, gated behind `LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP` so
//   the pure logic can be exercised with synthetic fixtures (no live DB
//   writes, no test course/module ever created on the real instance) by a
//   harness that does:
//     define('LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP', true);
//     require '/path/to/check-lesson-ladder-wiring.php';
//     ladder_run_checks($fakepages, $fakeanswers, 4);

// --- Moodle's mod_lesson special jumpto values (public/mod/lesson/locallib.php) ---
const LADDER_LESSON_THISPAGE          = 0;
const LADDER_LESSON_NEXTPAGE          = -1;
const LADDER_LESSON_EOL               = -9;
const LADDER_LESSON_PREVIOUSPAGE      = -40;
const LADDER_LESSON_UNSEENBRANCHPAGE  = -50;
const LADDER_LESSON_RANDOMPAGE        = -60;
const LADDER_LESSON_RANDOMBRANCH      = -70;
const LADDER_LESSON_CLUSTERJUMP       = -80;

// Content/structure page type (public/mod/lesson/pagetypes/branchtable.php).
const LADDER_LESSON_PAGE_BRANCHTABLE = 20;

/**
 * Classify a Lesson page title into [cluster, lane].
 * Expected convention (moodle-lesson-ladder-setup.md): "<cluster> Core",
 * "<cluster> Reinforce N", "<cluster> Extend N", "<cluster> Reteach".
 * Returns [null, null] if the title doesn't match the convention (e.g. a
 * plain intro/welcome page that isn't part of any ladder cluster).
 */
function ladder_classify_title(string $title): array {
    if (preg_match('/^(.*?)\s*\b(core|reinforce|extend|reteach)\b\s*\d*\s*$/i', trim($title), $m)) {
        $cluster = trim($m[1]) !== '' ? trim($m[1]) : '(unnamed cluster)';
        $lane = ucfirst(strtolower($m[2]));
        return [$cluster, $lane];
    }
    return [null, null];
}

/**
 * Run all three wiring checks against a lesson's pages/answers.
 *
 * @param array $pages   lesson_pages rows, keyed by id, each an object/array
 *                        with ->id, ->title, ->qtype.
 * @param array $answers lesson_answers rows (list), each with ->id,
 *                        ->pageid, ->jumpto.
 * @param int   $poolcap max pages allowed per lane per skill cluster.
 * @return array{errors: string[], warnings: string[], notes: string[]}
 */
function ladder_run_checks(array $pages, array $answers, int $poolcap): array {
    $errors = [];
    $warnings = [];
    $notes = [];

    if (empty($pages)) {
        return ['errors' => $errors, 'warnings' => $warnings, 'notes' => $notes];
    }

    $laneof = [];
    $clusterof = [];
    foreach ($pages as $page) {
        [$cluster, $lane] = ladder_classify_title($page->title);
        $laneof[$page->id] = $lane;
        $clusterof[$page->id] = $cluster;
    }

    // --- 1. Dangling jumps ---
    $specialvalid = [LADDER_LESSON_THISPAGE, LADDER_LESSON_NEXTPAGE, LADDER_LESSON_EOL];
    $specialother = [
        LADDER_LESSON_PREVIOUSPAGE => 'LESSON_PREVIOUSPAGE',
        LADDER_LESSON_UNSEENBRANCHPAGE => 'LESSON_UNSEENBRANCHPAGE',
        LADDER_LESSON_RANDOMPAGE => 'LESSON_RANDOMPAGE',
        LADDER_LESSON_RANDOMBRANCH => 'LESSON_RANDOMBRANCH',
        LADDER_LESSON_CLUSTERJUMP => 'LESSON_CLUSTERJUMP',
    ];

    foreach ($answers as $answer) {
        $sourcepage = $pages[$answer->pageid] ?? null;
        $sourcetitle = $sourcepage ? $sourcepage->title : "(unknown page {$answer->pageid})";
        $jumpto = (int) $answer->jumpto;

        if ($jumpto > 0) {
            if (!isset($pages[$jumpto])) {
                $errors[] = "DANGLING JUMP: page \"{$sourcetitle}\" (id={$answer->pageid}) answer id={$answer->id} "
                    . "jumps to page id={$jumpto}, which does not exist in this lesson.";
            }
        } elseif (in_array($jumpto, $specialvalid, true)) {
            // fine -- THISPAGE / NEXTPAGE / EOL
        } elseif (isset($specialother[$jumpto])) {
            $warnings[] = "UNEXPECTED JUMP TYPE: page \"{$sourcetitle}\" (id={$answer->pageid}) answer id={$answer->id} "
                . "uses {$specialother[$jumpto]} ({$jumpto}), which isn't part of the simple Core/Reinforce/Extend "
                . "design (moodle-lesson-ladder-setup.md). Verify manually.";
        } else {
            $warnings[] = "UNRECOGNIZED JUMP VALUE: page \"{$sourcetitle}\" (id={$answer->pageid}) answer id={$answer->id} "
                . "jumpto={$jumpto} is not a known page id or Moodle special value.";
        }
    }

    // --- 2. Sticky-endpoint / lane-crossing + Reteach page-type check ---
    foreach ($answers as $answer) {
        $jumpto = (int) $answer->jumpto;
        if ($jumpto <= 0 || !isset($pages[$jumpto])) {
            continue; // already covered by the dangling-jump check above
        }
        $sourcepage = $pages[$answer->pageid] ?? null;
        if (!$sourcepage) {
            continue;
        }
        $sourcelane = $laneof[$sourcepage->id] ?? null;
        $targetlane = $laneof[$jumpto] ?? null;
        $targetpage = $pages[$jumpto];

        if ($sourcelane === 'Reinforce' && $targetlane === 'Extend') {
            $errors[] = "LANE CROSSING: Reinforce page \"{$sourcepage->title}\" (id={$sourcepage->id}) jumps to "
                . "Extend page \"{$targetpage->title}\" (id={$targetpage->id}) -- Reinforce must loop within its own "
                . "lane or exit to a Reteach/next-skill page, never cross into Extend.";
        }
        if ($sourcelane === 'Extend' && $targetlane === 'Reinforce') {
            $errors[] = "LANE CROSSING: Extend page \"{$sourcepage->title}\" (id={$sourcepage->id}) jumps to "
                . "Reinforce page \"{$targetpage->title}\" (id={$targetpage->id}) -- Extend must loop within its own "
                . "lane or exit forward, never cross into Reinforce.";
        }

        if ($targetlane === 'Reteach' && (int) $targetpage->qtype !== LADDER_LESSON_PAGE_BRANCHTABLE) {
            $errors[] = "RETEACH PAGE IS A QUESTION: \"{$targetpage->title}\" (id={$targetpage->id}) is named as a "
                . "Reteach page but has qtype={$targetpage->qtype}, not a Content page (qtype "
                . LADDER_LESSON_PAGE_BRANCHTABLE . "). moodle-lesson-ladder-setup.md requires Reteach to be static "
                . "content, not another auto-served question.";
        }

        // Informational: Core page's targets should land only in Reinforce/Extend.
        if ($sourcelane === 'Core' && $targetlane !== null && !in_array($targetlane, ['Reinforce', 'Extend'], true)) {
            $notes[] = "CORE TARGET OUTSIDE LADDER: Core page \"{$sourcepage->title}\" (id={$sourcepage->id}) jumps to "
                . "\"{$targetpage->title}\" (lane=" . ($targetlane ?? 'none') . ") -- design calls for Core's two "
                . "outcomes to be Reinforce (wrong) / Extend (right) only.";
        }
    }

    // --- 3. Pool-size cap per skill cluster ---
    $counts = []; // cluster => ['Reinforce' => n, 'Extend' => n]
    foreach ($pages as $page) {
        $lane = $laneof[$page->id];
        $cluster = $clusterof[$page->id];
        if ($cluster === null || !in_array($lane, ['Reinforce', 'Extend'], true)) {
            continue;
        }
        $counts[$cluster][$lane] = ($counts[$cluster][$lane] ?? 0) + 1;
    }
    foreach ($counts as $cluster => $lanecounts) {
        foreach (['Reinforce', 'Extend'] as $lane) {
            $n = $lanecounts[$lane] ?? 0;
            if ($n > $poolcap) {
                $errors[] = "POOL SIZE EXCEEDED: skill cluster \"{$cluster}\" has {$n} {$lane} pages, "
                    . "exceeding the cap of {$poolcap} (see objectives-and-skills-proficiency.md's Reinforce/Core/"
                    . "Extend Ladder pool-sizing note -- re-check this cap is still current).";
            }
        }
    }

    return ['errors' => $errors, 'warnings' => $warnings, 'notes' => $notes];
}

/** Render a checks result (from ladder_run_checks) as human-readable text. */
function ladder_format_report(array $result): string {
    $out = '';
    if (!empty($result['errors'])) {
        $out .= "\nERRORS (" . count($result['errors']) . "):\n";
        foreach ($result['errors'] as $e) {
            $out .= "  [ERROR] {$e}\n";
        }
    }
    if (!empty($result['warnings'])) {
        $out .= "\nWARNINGS (" . count($result['warnings']) . "):\n";
        foreach ($result['warnings'] as $w) {
            $out .= "  [WARN]  {$w}\n";
        }
    }
    if (!empty($result['notes'])) {
        $out .= "\nNOTES (" . count($result['notes']) . "):\n";
        foreach ($result['notes'] as $n) {
            $out .= "  [NOTE]  {$n}\n";
        }
    }
    if (empty($result['errors']) && empty($result['warnings']) && empty($result['notes'])) {
        $out .= "\nNo issues found.\n";
    }
    $out .= "\n" . (empty($result['errors']) ? "PASS" : "FAIL") . " -- " . count($result['errors']) . " error(s), "
        . count($result['warnings']) . " warning(s), " . count($result['notes']) . " note(s).\n";
    return $out;
}

// =====================================================================
// CLI entrypoint -- only runs against the real Moodle DB. Skipped when a
// test harness defines LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP before
// requiring this file, so the pure functions above can be exercised
// against synthetic fixtures with zero live-DB interaction.
// =====================================================================
if (!defined('LADDER_WIRING_SKIP_MOODLE_BOOTSTRAP')) {
    define('CLI_SCRIPT', true);
    require('/var/www/moodle/config.php');

    $options = [];
    foreach (array_slice($argv, 1) as $arg) {
        if (preg_match('/^--([a-z-]+)=(.+)$/', $arg, $m)) {
            $options[$m[1]] = $m[2];
        }
    }

    $poolcap = isset($options['pool-cap']) ? (int) $options['pool-cap'] : 4; // see header note above

    if (isset($options['cmid'])) {
        $cm = get_coursemodule_from_id('lesson', (int) $options['cmid'], 0, false, IGNORE_MISSING);
        if (!$cm) {
            fwrite(STDERR, "No lesson course-module found for cmid={$options['cmid']}\n");
            exit(1);
        }
        $lessonid = (int) $cm->instance;
    } elseif (isset($options['lesson'])) {
        $lessonid = (int) $options['lesson'];
    } else {
        fwrite(STDERR, "Usage: check-lesson-ladder-wiring.php --cmid=<cmid> | --lesson=<lessonid> [--pool-cap=N]\n");
        exit(1);
    }

    $lesson = $DB->get_record('lesson', ['id' => $lessonid], '*', IGNORE_MISSING);
    if (!$lesson) {
        fwrite(STDERR, "No lesson found with id={$lessonid}\n");
        exit(1);
    }

    $pages = $DB->get_records('lesson_pages', ['lessonid' => $lessonid]);
    $answers = $DB->get_records('lesson_answers', ['lessonid' => $lessonid]);

    echo "Lesson: \"{$lesson->name}\" (id={$lesson->id}, course={$lesson->course})\n";
    echo "Pages: " . count($pages) . "   Answers: " . count($answers) . "   Pool cap in effect: {$poolcap}\n";
    echo str_repeat('-', 70) . "\n";

    if (empty($pages)) {
        echo "No pages in this lesson -- nothing to check.\n";
        exit(0);
    }

    $result = ladder_run_checks($pages, $answers, $poolcap);
    echo ladder_format_report($result);
    exit(empty($result['errors']) ? 0 : 1);
}
