<?php
// Accepted answers for "write one print() statement that outputs exactly X"
// tasks. Pure PHP, no Moodle, so it is unit-tested (tests/test_answer_variants.php).
//
// Per Jay (2026-11-04): an answer with extra spaces that is still valid Python
// is correct, never marked wrong, but it gets a note on writing Python
// cleanly. So: every combination of quote style and optional spaces is
// accepted at full credit; the clean form gets plain feedback, and every
// spaced form gets a style tip.

defined('MOODLE_INTERNAL') || defined('FOXCS_LIB_TEST') || die();

const FOXCS_STYLE_TIP = 'Correct. Style tip: clean Python writes this with no extra spaces, like print("Hello"). Python runs it either way, but other programmers read the compact form faster.';

/**
 * @return array<int, array{answer: string, clean: bool, feedback: string}>
 *         Clean forms first (double quotes, then single), then spaced forms.
 */
function foxcs_print_variants(string $target): array {
    $out = [];
    foreach (['"', "'"] as $q) {
        if (strpos($target, $q) !== false) {
            continue; // that quote style would end the string early
        }
        foreach ([false, true] as $spaced) {
            foreach (['', ' '] as $before) {
                foreach (['', ' '] as $inleft) {
                    foreach (['', ' '] as $inright) {
                        $isclean = $before === '' && $inleft === '' && $inright === '';
                        if ($isclean === $spaced) {
                            continue;
                        }
                        $out[] = [
                            'answer' => "print{$before}({$inleft}{$q}{$target}{$q}{$inright})",
                            'clean' => $isclean,
                            'feedback' => $isclean ? 'Correct.' : FOXCS_STYLE_TIP,
                        ];
                    }
                }
            }
        }
    }
    return $out;
}
