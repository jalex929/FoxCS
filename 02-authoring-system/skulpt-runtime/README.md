# Skulpt Runtime (self-hosted)

A pure-JS Python subset interpreter — no WebAssembly, no streaming-compile MIME-type requirements, no ~10s cold start. See `../browser-python-execution.md` for the full history: Pyodide (real CPython via WASM) was tried first and measured at ~10s cold-start even under ideal conditions, then confirmed to actually hang when served through Moodle's `pluginfile.php` (which serves `.wasm` as `application/octet-stream`, not `application/wasm`, breaking WASM streaming compilation). Skulpt avoids that entire class of problem by construction — it's plain JavaScript.

**Source:** `skulpt@1.2.0` (latest published to npm as of 2026-09-04; a `1.3.0` GitHub tag exists but hadn't reached the npm registry yet at that time — recheck before assuming 1.2.0 is still current), the two dist files a page actually needs: `skulpt.min.js` (interpreter) and `skulpt-stdlib.js` (standard library, defines the global `Sk.builtinFiles`). ~952KB combined, roughly 14x smaller than Pyodide's trimmed core build.

**Real numbers, measured with Playwright, not assumed:** page load ~330ms, first code execution ~18ms, a second run in the same page ~70ms. Effectively instant compared to Pyodide's ~10s — and unlike Pyodide, this was also confirmed to actually run correctly when served through Moodle (no special server MIME-type configuration needed, since there's no wasm file to mis-serve).

**Known tradeoff, accepted per `browser-python-execution.md`'s original Option C writeup:** partial standard-library coverage and some fidelity gaps vs. real CPython. Not a concern for Unit 01-02-level content (variables, print, basic types, arithmetic, simple control flow) — worth re-checking if a later unit needs a stdlib module Skulpt doesn't implement.

**Usage from a lesson page:**

```html
<script src="../skulpt-runtime/skulpt.min.js"></script>
<script src="../skulpt-runtime/skulpt-stdlib.js"></script>
<script>
function runPython(code, onOutput) {
  Sk.configure({
    output: onOutput,
    read: function (x) {
      if (Sk.builtinFiles === undefined || Sk.builtinFiles.files[x] === undefined) {
        throw "File not found: '" + x + "'";
      }
      return Sk.builtinFiles.files[x];
    },
  });
  return Sk.misceval.asyncToPromise(function () {
    return Sk.importMainWithBody("<stdin>", false, code, true);
  });
}
</script>
```

**To update:** check `npm view skulpt version` against what's here, download the two dist files from `https://cdn.jsdelivr.net/npm/skulpt@<version>/dist/`, replace, update the version above.
