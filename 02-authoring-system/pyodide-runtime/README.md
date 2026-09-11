# Pyodide Runtime (self-hosted)

Real CPython, compiled to WebAssembly, runs entirely in the student's browser — no backend, no per-run network request. See `../browser-python-execution.md` for the full design reasoning (why self-hosted, why this over a custom execution API).

**Source:** `pyodide-core-314.0.6.tar.bz2` from the official [Pyodide releases](https://github.com/pyodide/pyodide/releases), the "core" build (interpreter + stdlib only, no extra scientific-stack packages — nothing in Unit 01-02-level content needs more than that).

**Trimmed from the release tarball** to just what a browser actually fetches at runtime (confirmed by grepping `pyodide.js` for its own asset references): `pyodide.js`, `pyodide.asm.mjs`, `pyodide.asm.wasm`, `python_stdlib.zip`, `pyodide-lock.json`. Dropped: native `python`/`python.exe`/`python.bat` CLI binaries, `.d.ts` TypeScript definitions, `package.json`, `python_cli_entry.mjs` — none of those are used by a page loading Pyodide via `<script src="pyodide.js">` + `loadPyodide()`.

**Usage from a lesson page:**

```html
<script src="../pyodide-runtime/pyodide.js"></script>
<script>
async function runCode(code) {
  const pyodide = await loadPyodide({ indexURL: '../pyodide-runtime/' });
  pyodide.setStdout({ batched: (msg) => { /* append msg to your output panel */ } });
  try {
    pyodide.runPython(code);
  } catch (e) {
    // e.message is Python's real traceback text
  }
}
</script>
```

`indexURL` must point at this folder so Pyodide can find `pyodide.asm.wasm`, `python_stdlib.zip`, and `pyodide-lock.json` relative to it.

**To update the runtime:** download a newer `pyodide-core-X.Y.Z.tar.bz2` from the releases page, extract, and copy over the same 5 files (re-check `pyodide.js`'s own references in case a future version needs something new). Update the version number above.

**Size:** ~13MB on disk, ~6.5MB compressed download from GitHub — real-world transfer size to a student's browser depends on the web server's own compression, not this repo. See `component-library/index.html`'s Run & Check component for a real, timed proof of load behavior before this goes into any graded lesson content.
