// Renders a self-contained HTML file to PDF using headless Chrome (Puppeteer).
// Two layouts:
//   slide  - 13.333x7.5in widescreen, no margins. For teacher-materials/week-NN-presentation.html decks.
//   doc    - US Letter, 0.4in margins. For instructional-content/*.html flowing documents.
//
// Why this exists: a rendered PDF (even a text-heavy one) is 100-300KB, well past what can
// be reliably relayed through a chat model as base64 without risking silent truncation/corruption.
// Rendering happens locally instead -- the binary never has to pass through the assistant.
// Same rationale as the old slide-deck-builder (pptx-from-JSON) tool this replaced.
const puppeteer = require('puppeteer');
const path = require('path');

async function convert(inputPath, outputPath, layout) {
  const browser = await puppeteer.launch({ headless: 'new', args: ['--no-sandbox'] });
  const page = await browser.newPage();
  await page.goto('file://' + path.resolve(inputPath), { waitUntil: 'networkidle0' });

  const pdfOptions = { path: outputPath, printBackground: true };
  if (layout === 'doc') {
    pdfOptions.format = 'Letter';
    pdfOptions.margin = { top: '0.4in', right: '0.4in', bottom: '0.4in', left: '0.4in' };
  } else {
    pdfOptions.width = '13.333in';
    pdfOptions.height = '7.5in';
    pdfOptions.margin = { top: 0, right: 0, bottom: 0, left: 0 };
  }

  await page.pdf(pdfOptions);
  await browser.close();
  console.log('wrote', outputPath);
}

const [, , input, output, layout] = process.argv;
if (!input || !output) {
  console.error('Usage: node render.js <input.html> <output.pdf> [slide|doc]');
  process.exit(1);
}
convert(input, output, layout === 'doc' ? 'doc' : 'slide').catch((e) => {
  console.error(e);
  process.exit(1);
});
