/* ==========================================================
   Admin panel — admin.js
   Fungsi: buka/tutup sidebar (mobile) dan ganti tema terang/gelap.
   Kunci tema sama dengan website ('portfolio-theme').
   ========================================================== */
'use strict';

(function () {
  var root = document.documentElement;
  var shell = document.getElementById('admin-shell');
  var sidebar = document.getElementById('sidebar');
  var openBtn = document.getElementById('sidebar-open');
  var closeBtn = document.getElementById('sidebar-close');
  var backdrop = document.getElementById('sidebar-backdrop');
  var themeBtn = document.getElementById('admin-theme');

  function setSidebar(open) {
    if (!shell) return;
    shell.classList.toggle('sidebar-open', open);
    if (backdrop) backdrop.hidden = !open;
    if (openBtn) openBtn.setAttribute('aria-expanded', String(open));
  }

  if (openBtn) openBtn.addEventListener('click', function () { setSidebar(true); });
  if (closeBtn) closeBtn.addEventListener('click', function () { setSidebar(false); });
  if (backdrop) backdrop.addEventListener('click', function () { setSidebar(false); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setSidebar(false);
  });
  if (sidebar) {
    sidebar.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { setSidebar(false); });
    });
  }

  if (themeBtn) {
    themeBtn.addEventListener('click', function () {
      var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', next);
      try { localStorage.setItem('portfolio-theme', next); } catch (e) {}
    });
  }
})();
