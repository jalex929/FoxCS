// FoxCS light/dark theme toggle — added 2026-08-08.
// Pairs with the CSS custom properties in foxcs-base.css ([data-theme="dark"]).
// Default: follow the system/browser preference (prefers-color-scheme). A
// manual toggle click overrides that and is remembered (localStorage) for
// next time this page loads. Include a button with id="theme-toggle-btn"
// anywhere in the page — this script wires it up automatically.

(function () {
  const STORAGE_KEY = 'foxcs-theme';

  function systemPrefersDark() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    const btn = document.getElementById('theme-toggle-btn');
    if (btn) btn.textContent = theme === 'dark' ? '☀ Light mode' : '🌙 Dark mode';
  }

  function currentTheme() {
    const saved = localStorage.getItem(STORAGE_KEY);
    if (saved === 'dark' || saved === 'light') return saved;
    return systemPrefersDark() ? 'dark' : 'light';
  }

  applyTheme(currentTheme());

  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('theme-toggle-btn');
    if (!btn) return;
    applyTheme(currentTheme());
    btn.addEventListener('click', function () {
      const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      localStorage.setItem(STORAGE_KEY, next);
      applyTheme(next);
    });
  });
})();
