// Render one or more self-contained HTML files to PDF via headless Chromium.
// Works headless -- no display/GUI needed, so this runs fine over SSH (e.g. on the
// FoxCS droplet, see ../../../07-infrastructure/droplet-setup.md). Each output PDF is
// written next to its source HTML with a .pdf extension.
//
// Usage:
//   npm install && npx playwright install --with-deps chromium   (one-time setup)
//   node render.mjs path/to/file.html [more.html ...]
//   node render.mjs --portrait path/to/worksheet.html            (Letter portrait instead of slide landscape)
import { chromium } from 'playwright';
import path from 'node:path';

const args = process.argv.slice(2);
const portrait = args.includes('--portrait');
const files = args.filter((a) => a !== '--portrait');

if (files.length === 0) {
  console.error('Usage: node render.mjs [--portrait] path/to/file.html [more.html ...]');
  process.exit(1);
}

const browser = await chromium.launch();
const page = await browser.newPage();

for (const file of files) {
  const htmlPath = path.resolve(file);
  const pdfPath = htmlPath.replace(/\.html?$/i, '.pdf');
  await page.goto('file:///' + htmlPath.replace(/\\/g, '/'));
  await page.emulateMedia({ media: 'print' });
  await page.pdf({
    path: pdfPath,
    landscape: !portrait,
    printBackground: true,
    ...(portrait
      ? { format: 'Letter' }
      : { width: '13.333in', height: '7.5in' }),
    margin: { top: '0in', right: '0in', bottom: '0in', left: '0in' },
  });
  console.log('Wrote', pdfPath);
}

await browser.close();
