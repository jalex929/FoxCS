<?php
// Pure logic for duplicate-course.php: no Moodle calls, so it is unit-tested
// with plain PHP (tests/test_copy_lib.php).

defined('MOODLE_INTERNAL') || defined('FOXCS_COPY_TEST') || die();

/**
 * Pairs each module of the live course with its copy. Both lists are in
 * course order, one entry per module: ['section' => int, 'modname' => str,
 * 'name' => str, 'cmid' => int]. Returns [map of live cmid => copy cmid,
 * problems]. Any problem means the copy does not mirror the live course and
 * nothing should be rewritten.
 */
function copy_pair_modules(array $live, array $copy): array {
    $problems = [];
    if (count($live) !== count($copy)) {
        $problems[] = 'module count differs: live ' . count($live) . ', copy ' . count($copy);
    }
    $map = [];
    foreach (array_values($live) as $i => $l) {
        $c = array_values($copy)[$i] ?? null;
        if ($c === null) {
            break;
        }
        foreach (['section', 'modname', 'name'] as $key) {
            if ($l[$key] !== $c[$key]) {
                $problems[] = "module " . ($i + 1) . " ({$l['name']}): {$key} is " . var_export($l[$key], true)
                    . ' live but ' . var_export($c[$key], true) . ' in the copy';
            }
        }
        $map[(int) $l['cmid']] = (int) $c['cmid'];
    }
    return [$problems ? [] : $map, $problems];
}

/**
 * Points page HTML at the copy instead of the live course: the telemetry
 * CMID each page reports progress and completion against, links to live
 * activities, and links to the live course. IDs not in the map are left
 * alone and returned, so they can be reported. Returns [html, replaced, unmapped].
 */
function copy_rewrite_html(string $html, array $cmmap, int $livecourse, int $copycourse): array {
    $replaced = 0;
    $unmapped = [];
    $swap = function (array $m, array $map) use (&$replaced, &$unmapped) {
        $id = (int) $m[2];
        if (!isset($map[$id])) {
            $unmapped[$id] = true;
            return $m[0];
        }
        $replaced++;
        return $m[1] . $map[$id] . ($m[3] ?? '');
    };
    $html = preg_replace_callback('/(\bvar\s+CMID\s*=\s*["\'])(\d+)(["\'])/', fn($m) => $swap($m, $cmmap), $html);
    $html = preg_replace_callback('#(/mod/[a-z0-9_]+/view\.php\?id=)(\d+)()(?!\d)#', fn($m) => $swap($m, $cmmap), $html);
    $html = preg_replace_callback('#(/course/view\.php\?id=)(\d+)()(?!\d)#',
        fn($m) => $swap($m, [$livecourse => $copycourse]), $html);
    $ids = array_keys($unmapped);
    sort($ids);
    return [$html, $replaced, $ids];
}

/** A safe course shortname for the copy: lowercase letters, digits, hyphens. */
function copy_valid_shortname(string $name): bool {
    return preg_match('/^[a-z0-9-]{3,100}$/D', $name) === 1;
}
