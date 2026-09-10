// local/foxcstelemetry/foxcs-progress.js -- added 2026-09-10.
//
// Generic resume/progress-save helper for FoxCS's self-contained
// Instruction+Practice pages (see ../../../CLAUDE.md's Purpose section --
// "Instruction" bundles Learn + Key Terms + the Reinforce/Core/Extend
// Practice ladder into one page). Those pages are single long documents with
// no native Moodle save-state, so a student who closes the tab partway
// through previously lost all progress and had to redo Learn's reading-check
// gate and any already-resolved Practice skill checks from scratch.
//
// This file only provides the plumbing (fetch the last saved state from the
// server, with a localStorage fallback if the network call fails). It does
// NOT know anything about a specific lesson's DOM -- each lesson's own
// inline <script> still owns:
//   - what "the current progress" looks like for that lesson (its own
//     currentProgressState() function, built from its own `progress` object
//     and any Learn-gate index it tracks)
//   - how to reapply a restored state to its own DOM (its own
//     applyProgressState(state) function -- revealing Learn sections,
//     marking Practice nodes already-resolved, etc.)
// A lesson wires the two together with:
//   FoxCSProgress.restore(ENDPOINT, CMID, applyProgressState);
// and calls its own saveProgress() (which should call
// logEvent('progress_state', currentProgressState(), false) -- reusing the
// page's existing dual server+localStorage write path, so this never needs
// its own separate network code) after every state-changing interaction
// (a node resolving, a Learn reading-check advancing, a spiral item
// finishing).
//
// Deliberately NOT the older component-library FoxCSTelemetry
// (../../../02-authoring-system/shared-styles/foxcs-telemetry.js) -- that's
// the earlier no-backend, save-in-place DOM-blob mechanism for standalone
// demo pages. Live Moodle Instruction pages use this plugin's server-backed
// 'Option C' telemetry instead (see telemetry-and-analytics.md's "Live
// Implementation" section), so this resume helper reads from that same
// server log rather than a separate store.

var FoxCSProgress = (function () {
  function fetchState(endpoint, cmid, cb) {
    fetch(endpoint + '?action=state&cmid=' + cmid, { credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .then(function (data) { cb(data && data.state ? data.state : null); })
      .catch(function () { cb(null); });
  }

  // Falls back to this same browser's local telemetry backup (written by
  // every lesson's existing localBackup()) if the server call above fails
  // or a first-run student has no server-side row yet. Scans backwards for
  // the most recent 'progress_state' entry, same as the server query does.
  function localFallback(cmid) {
    try {
      var log = JSON.parse(localStorage.getItem('foxcs_telemetry_backup_' + cmid) || '[]');
      for (var i = log.length - 1; i >= 0; i--) {
        if (log[i].eventtype === 'progress_state') return log[i].payload;
      }
    } catch (e) { /* best-effort only, never block page load */ }
    return null;
  }

  // endpoint/cmid: same ENDPOINT/CMID vars every lesson's telemetry block
  // already defines. applyFn: the lesson's own applyProgressState(state)
  // function -- called once, only if a prior state actually exists (a
  // brand-new student sees no call at all, so a lesson's applyFn never has
  // to handle "empty state" itself).
  function restore(endpoint, cmid, applyFn) {
    fetchState(endpoint, cmid, function (serverState) {
      var state = serverState || localFallback(cmid);
      if (state) applyFn(state);
    });
  }

  return { restore: restore };
})();
