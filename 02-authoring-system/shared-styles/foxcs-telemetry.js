// FoxCS telemetry event log — added 2026-08-08. See ../telemetry-and-analytics.md
// for the full schema and reasoning. This file is the reusable mechanism;
// individual components (theme link, code stepper, drills, the Core/Reinforce/
// Extend router) call FoxCSTelemetry.log(...) as students interact with them.
//
// Everything lives in one hidden JSON blob per page:
//   <script type="application/json" id="foxcs-telemetry" aria-hidden="true">
// re-serialized on every event, so whatever's in the DOM at Save time is
// always current — same "no separate finalize step to forget" reasoning as
// the mastery-check hidden-timestamp mechanism (component-library #12).
//
// No network calls anywhere in this file — the MVP model is static files
// only. If a page never saves, this data never persists; that's a known,
// accepted limitation, not a bug (see telemetry-and-analytics.md's
// "Design Constraints" section).

(function () {
  const ELEMENT_ID = 'foxcs-telemetry';

  function nowISO() {
    return new Date().toISOString();
  }

  function ensureElement() {
    let el = document.getElementById(ELEMENT_ID);
    if (!el) {
      el = document.createElement('script');
      el.type = 'application/json';
      el.id = ELEMENT_ID;
      el.setAttribute('aria-hidden', 'true');
      document.head.appendChild(el);
    }
    return el;
  }

  function readState() {
    const el = document.getElementById(ELEMENT_ID);
    if (el && el.textContent.trim()) {
      try { return JSON.parse(el.textContent); } catch (e) { /* fall through to fresh state */ }
    }
    return null;
  }

  let state = readState();
  let pageId = state ? state.page_id : null;

  function writeState() {
    ensureElement().textContent = JSON.stringify(state, null, 2);
  }

  const FoxCSTelemetry = {
    // Call once per page, with a stable identifier (e.g. the lesson/step
    // filename). Re-uses existing state if the page already had a partial
    // session recorded (e.g. reopened after a save without a full reload of
    // the in-memory page — rare in this static-file model, but cheap to
    // handle correctly).
    init: function (id) {
      pageId = id;
      if (!state || state.page_id !== id) {
        state = { page_id: id, opened_at: nowISO(), saves: [], events: [] };
      }
      writeState();
      return state;
    },

    // Generic event log. `type` matches the table in telemetry-and-analytics.md
    // (theme_change, stepper_speed_change, stepper_play, stepper_pause,
    // stepper_step, hint_reveal, drill_attempt, lane_transition). `fields` is
    // whatever that event type needs beyond type/at.
    log: function (type, fields) {
      if (!state) FoxCSTelemetry.init(pageId || document.title || 'untitled');
      const event = Object.assign({ type: type, at: nowISO() }, fields || {});
      state.events.push(event);
      writeState();
      return event;
    },

    // Call immediately before serializing the page for save. Records which
    // theme was active at save time and returns the full state for anyone
    // who wants it (mainly useful for the "show hidden telemetry" demo
    // toggle — real deployed pages never need to read this back).
    recordSave: function (theme) {
      if (!state) FoxCSTelemetry.init(pageId || document.title || 'untitled');
      state.saves.push({ at: nowISO(), theme: theme });
      writeState();
      return state;
    },

    getState: function () {
      return state;
    }
  };

  window.FoxCSTelemetry = FoxCSTelemetry;
})();
