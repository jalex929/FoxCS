#!/usr/bin/env node
/**
 * browser_verify_vocab_quiz_save.mjs
 *
 * PURPOSE
 *   Real-browser (Playwright/Chromium) end-to-end verification of the exact
 *   save-serialization bug check_save_serialization.py checks for
 *   statically: does a student's typed reflection actually survive Save?
 *   Runs the real page like a student would -- matches all 5 vocab terms,
 *   types a reflection, clicks Save -- then reads back the file the page
 *   actually wrote and asserts the typed text is really in it, not the
 *   placeholder/blank state. This is what Jay asked for when he wanted a
 *   real Chrome check of content behavior, not just a static-source
 *   pattern match; built with Playwright (already a devDependency of
 *   ../html-to-pdf) since the Claude-in-Chrome extension wasn't connected
 *   in the session that first needed this.
 *
 *   Forces the page's fallback save path (Blob + `<a download>`) by
 *   deleting `window.showSaveFilePicker` before the page's own script runs
 *   -- the File System Access API needs real OS-level user activation that
 *   headless Chromium can't provide, and the page already has a documented,
 *   real fallback for exactly this case ("Downloaded a copy...").
 *
 * WHAT IT CHECKS
 *   1. The quiz can actually be completed (all 5 terms placed correctly,
 *      Check Answers accepts them, Save becomes enabled).
 *   2. Save produces a real downloaded file.
 *   3. The downloaded file's HTML contains the exact reflection text typed
 *      into the textarea -- proof `syncFormStateToDom()` actually ran and
 *      worked, not just that the code pattern exists (which is all the
 *      static checker can confirm).
 *   4. The downloaded file also reflects all 5 terms as matched (not reset
 *      to the initial unmatched state).
 *
 * USAGE
 *   cd 02-authoring-system/tools/html-to-pdf && npm install && npx playwright install chromium
 *   node ../browser_verify_vocab_quiz_save.mjs [path/to/some_vocab_quiz.html]
 *   (path defaults to Lesson 01.4's real vocab quiz.)
 *
 * EXIT CODE
 *   0 if every assertion passed, 1 otherwise.
 */
import { chromium } from 'playwright';
import { readFileSync, existsSync } from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const DEFAULT_TARGET = path.resolve(
  __dirname,
  '../../courses/python/content/unit_01_what_is_programming/lesson_01_04_printing_output/04_vocab_quiz.html'
);
const target = process.argv[2] ? path.resolve(process.argv[2]) : DEFAULT_TARGET;
const REFLECTION_TEXT = '__BROWSER_VERIFY_TEST_REFLECTION_12345__';
const TERM_IDS = ['function', 'string', 'output', 'argument', 'SyntaxError'];

function assert(cond, label) {
  if (cond) {
    console.log(`  [PASS] ${label}`);
    return true;
  }
  console.log(`  [FAIL] ${label}`);
  return false;
}

async function main() {
  if (!existsSync(target)) {
    console.error(`Target file not found: ${target}`);
    process.exit(1);
  }

  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.addInitScript(() => {
    // Force the page's documented Blob/<a download> fallback path --
    // headless Chromium can't satisfy showSaveFilePicker's user-activation
    // requirement, and the page already has a real fallback for this case.
    try { delete window.showSaveFilePicker; } catch (e) { /* ignore */ }
  });

  let allPassed = true;
  console.log(`Loading ${target} ...`);
  await page.goto('file://' + target);

  console.log('\nMatching all 5 terms correctly...');
  for (const id of TERM_IDS) {
    await page.click(`#chip-${id}`);
    await page.click(`#slot-${id}`);
  }
  await page.click('.check-quiz-btn');

  const progressText = await page.textContent('#progressText');
  allPassed &= assert(progressText.trim() === '5 of 5 matched', `progress shows 5 of 5 matched (got "${progressText.trim()}")`);

  console.log('\nTyping reflection and enabling Save...');
  await page.fill('#memoryTrick', REFLECTION_TEXT);
  // oninput handler updates the Save gate; give it a tick.
  await page.waitForTimeout(50);
  const saveDisabled = await page.getAttribute('#saveBtn', 'disabled');
  allPassed &= assert(saveDisabled === null, 'Save button is enabled after all-matched + reflection filled');

  console.log('\nClicking Save and capturing the downloaded file...');
  const [download] = await Promise.all([
    page.waitForEvent('download', { timeout: 5000 }).catch(() => null),
    page.click('#saveBtn'),
  ]);
  allPassed &= assert(download !== null, 'Save triggered a real file download');

  if (download) {
    const savedPath = await download.path();
    const savedHtml = readFileSync(savedPath, 'utf-8');
    allPassed &= assert(
      savedHtml.includes(REFLECTION_TEXT),
      'downloaded file contains the exact typed reflection text (the real save-serialization bug this guards against)'
    );
    allPassed &= assert(
      (savedHtml.match(/class="def-slot correct"/g) || []).length === 5,
      'downloaded file shows all 5 def-slots still marked correct (matched state survived save)'
    );
  }

  await browser.close();

  console.log(allPassed ? '\nAll checks passed.' : '\nOne or more checks FAILED.');
  process.exit(allPassed ? 0 : 1);
}

main().catch(err => {
  console.error('Unexpected error:', err);
  process.exit(1);
});
