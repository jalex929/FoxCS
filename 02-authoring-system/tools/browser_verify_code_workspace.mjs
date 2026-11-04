// Real-browser check of shared-components/foxcs-code-workspace.js with the
// real Skulpt runtime: Run executes Python, extra spaces still run (with a
// tip), Check compares output, and Download saves the code as a .py file.
//   node 02-authoring-system/tools/browser_verify_code_workspace.mjs
import { createRequire } from 'node:module';
import { fileURLToPath, pathToFileURL } from 'node:url';
import path from 'node:path';
import fs from 'node:fs';
import os from 'node:os';

// require() finds Playwright in this folder's node_modules (CI) or a global install.
const { chromium } = createRequire(import.meta.url)('playwright');
const here = path.dirname(fileURLToPath(import.meta.url));
const authoring = path.resolve(here, '..');
const page_html = `<!doctype html><meta charset="utf-8">
<script src="${pathToFileURL(path.join(authoring, 'skulpt-runtime/skulpt.min.js'))}"></script>
<script src="${pathToFileURL(path.join(authoring, 'skulpt-runtime/skulpt-stdlib.js'))}"></script>
<script src="${pathToFileURL(path.join(authoring, 'shared-components/foxcs-code-workspace.js'))}"></script>
<div class="foxcs-workspace" id="w" data-filename="status board" data-expected="Health: 85\nScore: 1240">print ( "Health: 85" )
print("Score:", 1240)</div>
<script>FoxCSWorkspace.mountAll(document, Sk);</script>`;
const dir = fs.mkdtempSync(path.join(os.tmpdir(), 'fw-'));
const file = path.join(dir, 'page.html');
fs.writeFileSync(file, page_html);

const failures = [];
const expect = (label, ok, detail = '') => { console.log(`${ok ? 'ok  ' : 'FAIL'} ${label}${ok ? '' : ' ' + detail}`); if (!ok) failures.push(label); };

const browser = await chromium.launch();
const page = await browser.newPage({ acceptDownloads: true });
await page.goto(pathToFileURL(file).href);
const w = page.locator('#w');

await w.locator('.fw-run').click();
await page.waitForFunction(() => !document.querySelector('#w .fw-output').textContent.includes('Running'));
const out = await w.locator('.fw-output').textContent();
expect('Run executes real Python, extra spaces and all', out.trim() === 'Health: 85\nScore: 1240', JSON.stringify(out));
const tips = await w.locator('.fw-tips li').allTextContents();
expect('spaced code gets clean-code tips, not an error', tips.length === 2 && tips[0].includes('No space between'), JSON.stringify(tips));

await w.locator('.fw-check').click();
await page.waitForFunction(() => document.querySelector('#w .fw-result').textContent !== '');
expect('Check accepts matching output', (await w.locator('.fw-result').textContent()) === 'Matches the expected output.');

await w.locator('.fw-editor').fill('print("Health: 85")\nprint("Score: 10")');
await w.locator('.fw-check').click();
await page.waitForFunction(() => document.querySelector('#w .fw-result').textContent.startsWith('Line'));
expect('Check names the first different line', (await w.locator('.fw-result').textContent()).startsWith('Line 2 differs.'));

await w.locator('.fw-editor').fill('print("unclosed)');
await w.locator('.fw-run').click();
await page.waitForFunction(() => /Error/.test(document.querySelector('#w .fw-output').textContent));
expect('errors are shown to the student', /SyntaxError|TokenError/.test(await w.locator('.fw-output').textContent()));

await w.locator('.fw-editor').fill('print("saved")');
const [download] = await Promise.all([page.waitForEvent('download'), w.locator('.fw-download').click()]);
const saved = fs.readFileSync(await download.path(), 'utf8');
expect('Download saves a .py file with the code', download.suggestedFilename() === 'status_board.py' && saved === 'print("saved")\n',
  `${download.suggestedFilename()} ${JSON.stringify(saved)}`);

await w.locator('.fw-reset').click();
expect('Reset restores the starter', (await w.locator('.fw-editor').inputValue()).startsWith('print ( "Health: 85" )'));

await browser.close();
fs.rmSync(dir, { recursive: true, force: true });
if (failures.length) { console.log(`\n${failures.length} failure(s)`); process.exit(1); }
console.log('\nAll code-workspace checks passed in a real browser.');
