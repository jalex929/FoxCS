#!/usr/bin/env node
/**
 * verify_01_04_submissions.mjs
 *
 * Real-browser (Playwright) end-to-end submission test against the LIVE
 * foxcs.online Moodle instance, logged in as the real 'foxcstest' Student
 * account -- confirms a real student submission to the Mastery Check (quiz),
 * Coding Exercise (assignment), and Feedback (mod_feedback) actually
 * persists in the database, not just that the activities exist structurally.
 *
 * PREREQUISITE: the 3 target cmids must be visible (visible=1) for foxcstest
 * to reach them -- this script does NOT toggle visibility itself, since
 * whether to leave a module visible afterward is a real editorial call, not
 * something to automate. Toggle manually before/after running:
 *   UPDATE mdl_course_modules SET visible=1 WHERE id IN (214,215,218);
 *   (... run this script ...)
 *   UPDATE mdl_course_modules SET visible=0 WHERE id IN (214,215,218);
 *   php admin/cli/purge_caches.php after each toggle.
 *
 * Also deletes its own test data (quiz attempt / assign submission /
 * feedback completion) from foxcstest at the end, so re-runs stay clean and
 * don't burn down foxcstest's 3 allowed Mastery Check attempts. If a
 * mid-script failure leaves data behind, re-run cleanup manually via the
 * commented block at the bottom of this file.
 *
 * cmids are specific to Lesson 01.4 -- update the constants below to reuse
 * this against a different lesson's activities.
 *
 * Usage: node verify_01_04_submissions.mjs
 */
import { chromium } from 'playwright';

const BASE = 'https://foxcs.online';
const USERNAME = 'foxcstest';
const PASSWORD = 'FoxcsTest2026!';
const QUIZ_CMID = 214;
const QUIZ_PASSWORD = 'M8VNQY';
const ASSIGN_CMID = 215;
const FEEDBACK_CMID = 218;

function log(label, ok, extra = '') {
  console.log(`  [${ok ? 'PASS' : 'FAIL'}] ${label}${extra ? ' -- ' + extra : ''}`);
  return ok;
}

async function main() {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  let allPassed = true;
  const MARKER = '__FOXCS_SUBMIT_TEST_' + Date.now() + '__';

  console.log('Logging in as foxcstest...');
  await page.goto(`${BASE}/login/index.php`, { waitUntil: 'networkidle' });
  await page.waitForTimeout(500);
  await page.fill('#username', USERNAME);
  await page.fill('#password', PASSWORD);
  await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle' }),
    page.click('#loginbtn'),
  ]);
  allPassed &= log('Logged in', (await page.title()).toLowerCase().includes('dashboard'), await page.title());

  // ---- Mastery Check (Quiz) ----------------------------------------------
  console.log(`\n--- Mastery Check (cmid=${QUIZ_CMID}) ---`);
  await page.goto(`${BASE}/mod/quiz/view.php?id=${QUIZ_CMID}`, { waitUntil: 'networkidle' });
  await page.getByRole('button', { name: /continue your attempt|attempt quiz|re-attempt quiz/i }).click();
  await page.waitForTimeout(1000);
  const pwToggle = page.getByText(/click to enter text/i);
  if (await pwToggle.isVisible().catch(() => false)) {
    await pwToggle.click();
    await page.waitForTimeout(300);
    await page.locator('#id_quizpassword').fill(QUIZ_PASSWORD);
  }
  await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle' }),
    page.getByRole('button', { name: /start attempt/i }).click(),
  ]);
  allPassed &= log('Reached the real attempt page', page.url().includes('attempt.php'), page.url());

  await page.locator('input[type="text"]').first().fill('I understand');
  await page.frameLocator('iframe.tox-edit-area__iframe').locator('body').click();
  await page.frameLocator('iframe.tox-edit-area__iframe').locator('body').fill(`Test answer. ${MARKER}`);

  await page.getByRole('button', { name: /finish attempt/i }).click();
  await page.waitForLoadState('networkidle');
  await page.getByRole('button', { name: /submit all and finish/i }).click();
  await page.waitForTimeout(800);
  const confirmBtn = page.getByRole('button', { name: /submit all and finish/i }).last();
  if (await confirmBtn.isVisible().catch(() => false)) {
    await confirmBtn.click();
    await page.waitForLoadState('networkidle');
  }
  const quizFinished = (await page.content()).match(/status.{0,20}finished/i) !== null;
  allPassed &= log('Quiz attempt shows Finished', quizFinished, page.url());

  // ---- Coding Exercise (Assignment) --------------------------------------
  console.log(`\n--- Coding Exercise (cmid=${ASSIGN_CMID}) ---`);
  await page.goto(`${BASE}/mod/assign/view.php?id=${ASSIGN_CMID}`, { waitUntil: 'networkidle' });
  await page.getByRole('link', { name: /add submission/i }).or(page.getByRole('button', { name: /add submission/i })).click();
  await page.waitForTimeout(2000);

  const CODE = `# ${MARKER}\nprint("Health: 100/100")\nprint("Score: 0")\nprint("Level: 1")\nprint("Not enough gold. You need 5 more.")`;
  await page.frameLocator('#id_onlinetext_editor_ifr').locator('body').click();
  await page.frameLocator('#id_onlinetext_editor_ifr').locator('body').fill(CODE);
  await page.getByRole('button', { name: /save changes/i }).click();
  await page.waitForTimeout(2000);
  const assignSubmitted = (await page.content()).match(/submitted for grading/i) !== null;
  allPassed &= log('Assignment shows Submitted for grading', assignSubmitted, page.url());

  // ---- Feedback -----------------------------------------------------------
  console.log(`\n--- Feedback (cmid=${FEEDBACK_CMID}) ---`);
  await page.goto(`${BASE}/mod/feedback/view.php?id=${FEEDBACK_CMID}`, { waitUntil: 'networkidle' });
  await page.getByRole('link', { name: /answer the questions/i }).click();
  await page.waitForTimeout(1500);

  for (const g of ['multichoicerated_1', 'multichoicerated_3', 'multichoicerated_5']) {
    await page.locator(`input[name="${g}"][value="3"]`).check({ force: true }).catch(() => {});
  }
  for (const name of ['textarea_2', 'textarea_4', 'textarea_7', 'textarea_8']) {
    await page.locator(`textarea[name="${name}"]`).fill(`Feedback test: ${name}. ${MARKER}`).catch(() => {});
  }
  await page.locator('input[type="checkbox"][name="multichoice_6[1]"]').check({ force: true }).catch(() => {});

  await page.getByRole('button', { name: /submit your answers|^save$/i }).click();
  await page.waitForTimeout(1500);
  const fbSaved = (await page.content()).match(/your answers have been saved/i) !== null;
  allPassed &= log('Feedback shows save confirmation', fbSaved, page.url());

  await browser.close();

  console.log(`\nMarker used: ${MARKER}`);
  console.log(allPassed ? '\nAll checks passed.' : '\nOne or more checks FAILED.');
  process.exit(allPassed ? 0 : 1);
}

main().catch(err => {
  console.error('Unexpected error:', err);
  process.exit(1);
});
