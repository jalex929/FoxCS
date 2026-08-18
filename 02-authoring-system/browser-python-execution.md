# Browser-Based Python Execution ("Functional IDE Simulation")

Added 2026-08-11 per Jay: real code-writing practice where a student types actual Python, runs it, and sees actual output — not the simulated dark-panel drills `05_practice.html` uses today. Explicitly scoped as **robust enough to test the MVP, not as robust as the eventual full platform.** Jay is open to standing up a custom API (his portfolio site or GitHub) if that's what it takes — this doc evaluates that option seriously alongside the alternative before recommending one.

## The Core Design Question

Where does the Python code actually run: **in the student's browser** (nothing leaves the machine), or **on a server** (code is sent somewhere, executed, and the result comes back)?

## Option A — Pyodide: real CPython, compiled to WebAssembly, runs entirely in the browser (recommended)

[Pyodide](https://pyodide.org) is a full CPython interpreter compiled to WASM. A page loads the runtime once, then `pyodide.runPython(code)` executes real Python and its stdout can be captured directly into an on-page output panel — no network request per run, no server at all.

**Why this fits FoxCS specifically, better than it would fit a generic ed-tech project:**

- **Matches every architectural principle already established this session.** `telemetry-and-analytics.md` was deliberately designed around "no live backend, telemetry can't phone home." `mvp-unit-folder-structure.md`'s save-in-place model assumes everything runs from `file://` or a local folder. Fonts are self-hosted specifically to avoid an external CDN dependency in real lesson content. Pyodide is the only option here that adds *zero* new network dependency to any of that — it's a bigger asset to self-host, not a new architecture to reason about.
- **No security/abuse surface at all.** Code runs inside the student's own browser sandbox. There is nothing to secure, rate-limit, or monitor for abuse, because nothing is ever sent anywhere.
- **Self-hostable**, same pattern as `shared-styles/fonts/`: download the distribution once, serve it from the repo, works offline after the first load (or fully offline if bundled directly into the lesson folder — see Distribution below).
- **Real language fidelity.** Actual CPython, not a reimplementation — no "well, this works in real Python but not in the practice tool" gap, which matters a lot for a course whose whole later arc depends on students trusting that what runs in practice is what runs for real.

**Real costs, stated plainly, not glossed over:**

- **Download size.** The core runtime is roughly 6-10MB (more if a lesson needs extra packages, though nothing in Unit 01-level content does — `print()`, strings, basic control flow need only the interpreter core). That's a real, one-time cost per browser profile, worth testing against actual school network conditions, not assumed away.
- **Cold-start delay.** A few seconds the first time a page initializes Pyodide in a session. Needs a visible "loading the code runner..." state so it doesn't read as broken — a solved UX problem (every Pyodide-based tool does this), not a novel one.
- **Distribution question, ties into the still-open Classroom folder-structure question** (`open-questions.md`): does the runtime get self-hosted at a stable location every lesson links to (works once Classroom's folder-structure behavior is confirmed), or bundled into each lesson folder (simpler to reason about, meaningfully larger folder to distribute — worth sizing once the Classroom question resolves)?

## Option B — Custom execution API (Jay's suggested fallback)

A serverless function (portfolio site or GitHub-hosted) that receives code, runs it in a sandboxed environment server-side, and returns stdout/stderr.

**Real trade-offs, not a soft no:**

- **Security is the load-bearing concern.** Arbitrary code execution exposed to the internet is a genuine abuse target the moment it's reachable — even from "just my students," since a URL is a URL. This is not a place to hand-roll a sandbox; it would mean either building on a hardened isolation layer (gVisor/Firecracker-style) or using an existing hardened service (e.g., Piston, Judge0) rather than a bare subprocess call. Rolling this incorrectly is a real risk, not a hypothetical one.
- **Reintroduces a live backend**, which every other design decision this session has deliberately built around avoiding. Telemetry, save-in-place, and the whole "works from a folder, no server" model all assume there's no live backend anywhere in the loop. This would be the first exception, and it would need its own privacy/data-boundaries review (`01-privacy-and-governance/data-boundaries.md`) — code a student writes and runs could itself be personal/identifying in ways worth thinking through before it leaves their machine.
- **Hosting/cost/maintenance surface**, even at light volume — uptime, monitoring, and "what happens during a lesson if the API is down or slow" all become real operational questions that don't exist under Option A.
- **Latency**, worse than local execution for something meant to feel "seamless" — every run is a round trip, not instant.
- **Real advantage worth naming**: no client download size concern, and it's the only option that can run things Pyodide genuinely can't (certain C-extension-dependent packages, real file I/O). Not a concern for Unit 01, but could matter for a later unit depending what the course eventually needs.

## Option C — Skulpt / Brython (lighter pure-JS interpreters)

Smaller download than Pyodide, used by some existing ed-tech tools (e.g., CodeHS uses a similar approach). Real downside: partial/inconsistent standard-library coverage and less active maintenance than Pyodide currently has. Given the course's DOK ambitions (real, not simulated, coding evidence) and multi-year arc, the fidelity gap is a worse long-term trade than Pyodide's larger download. Not recommended, noted for completeness.

## Recommendation

**Pyodide, self-hosted, for the MVP.** It's the only option that's simultaneously seamless (no round trip, works offline once loaded), architecturally consistent with everything already built this session (no live backend, no phone-home, self-hosted assets), and has zero new security surface to design or maintain. Keep Option B (custom API) explicitly on the table as a **later** upgrade path specifically for whatever a future unit needs that Pyodide's package/stdlib coverage can't provide — not needed for Unit 01, and not worth the backend/security scope right now for something Option A already solves.

## How This Plugs Into the Adaptive Practice Model

A new item type for `adaptive-practice-model.md`'s skill nodes: **"Run & Check."** The student gets a code editor pane (plain `<textarea>` or a light code-editor widget — doesn't need to be full VS Code, just real text entry with the dark simulated-IDE styling `05_practice.html` already uses), optionally pre-seeded with a scaffold at the same fidelity as the project's existing Level 3 "commented shell" hint pattern. They click **Run**, Pyodide executes the code, captured stdout renders in an output panel styled like the rest of this lesson's dark code panels. Grading compares captured stdout against an expected string (or a small set of acceptable variants, same pattern `checkTyped()` already uses for typed-blank drills).

This is a genuinely higher-DOK format than anything currently in Practice — write code, run it, judge whether the *actual output* is right, not select/type a single token — and directly answers the standing "practice DOK is a worst-case placeholder, not final" concern flagged since 2026-08-06. It fits the existing telemetry schema with no new event type: a `drill_attempt` (or node `Core`/`Reinforce`/`Extend` item) with `correct` based on output match, same as every other item type.

## Not Decided / Not Built

- **The actual editor widget** — plain textarea is the fastest path; a lightweight syntax-highlighting editor (e.g., CodeMirror) is a nicer experience but is itself a dependency to vet against the "self-hosted, no CDN" rule that already governs fonts. Not chosen.
- **Where the Pyodide runtime is physically distributed from** — depends on the still-open Classroom folder-structure question.
- **Output-matching tolerance** — exact string match is simplest but brittle (trailing whitespace, print-formatting differences); worth a real pass on what "close enough" means before this is built, not decided here.
- **This has not been built.** This is a design/recommendation doc only, per Jay's ask to "see if there is any way to build out" the concept before committing engineering time to it.
