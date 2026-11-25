/* ==========================================================
   PORTOFOLIO MUHAMMAD KAIS SIDD — script.js
   Semua JavaScript ada di file ini dan dimuat dengan defer.
   ========================================================== */
'use strict';

const THEME_KEY = 'portfolio-theme';
const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const rootElement = document.documentElement;
const themeToggle = document.getElementById('theme-toggle');
const menuToggle = document.getElementById('menu-toggle');
const navMenu = document.getElementById('nav-menu');
const navLinks = document.querySelectorAll('.nav-links a');
const skillCards = document.querySelectorAll('.skill-card');
const accordionGroups = document.querySelectorAll('[data-accordion]');
const contactForm = document.getElementById('contact-form');
const formStatus = document.getElementById('form-status');
const darkQuery = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

function readSavedTheme() {
  try { const value = localStorage.getItem(THEME_KEY); return value === 'light' || value === 'dark' ? value : null; }
  catch (error) { return null; }
}
function saveTheme(theme) { try { localStorage.setItem(THEME_KEY, theme); } catch (error) {} }
function getSystemTheme() { return darkQuery && darkQuery.matches ? 'dark' : 'light'; }
let manualTheme = readSavedTheme();
function applyTheme(theme) {
  rootElement.setAttribute('data-theme', theme);
  if (themeToggle) {
    const label = theme === 'dark' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';
    themeToggle.setAttribute('aria-label', label); themeToggle.setAttribute('title', label);
  }
}
function toggleTheme() {
  const next = rootElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  manualTheme = next; saveTheme(next); applyTheme(next);
}
function setupTheme() {
  applyTheme(manualTheme || getSystemTheme());
  if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
  if (darkQuery) {
    if (darkQuery.addEventListener) darkQuery.addEventListener('change', () => { if (manualTheme === null) applyTheme(getSystemTheme()); });
    else if (darkQuery.addListener) darkQuery.addListener(() => { if (manualTheme === null) applyTheme(getSystemTheme()); });
  }
}
function syncMenuButton() {
  if (!navMenu || !menuToggle) return;
  const isOpen = navMenu.classList.contains('is-open');
  menuToggle.setAttribute('aria-expanded', String(isOpen));
  menuToggle.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
}
function closeMenu() { if (navMenu) navMenu.classList.remove('is-open'); syncMenuButton(); }
function setupMenu() {
  if (!menuToggle || !navMenu) return;
  menuToggle.addEventListener('click', () => { navMenu.classList.toggle('is-open'); syncMenuButton(); });
  navLinks.forEach(link => link.addEventListener('click', closeMenu));
  document.addEventListener('keydown', event => { if (event.key === 'Escape' && navMenu.classList.contains('is-open')) { closeMenu(); menuToggle.focus(); } });
  document.addEventListener('click', event => { if (navMenu.classList.contains('is-open') && !event.target.closest('.site-header')) closeMenu(); });
  if (window.matchMedia) {
    const desktopQuery = window.matchMedia('(min-width: 1001px)');
    const handleResize = event => { if (event.matches) closeMenu(); };
    if (desktopQuery.addEventListener) desktopQuery.addEventListener('change', handleResize);
    else if (desktopQuery.addListener) desktopQuery.addListener(handleResize);
  }
}
function setupSkillCards() {
  skillCards.forEach(card => card.addEventListener('click', () => {
    const isActive = card.classList.toggle('is-active'); card.setAttribute('aria-pressed', String(isActive));
  }));
}
function setAccordionItem(item, shouldOpen) {
  const trigger = item.querySelector('.accordion-trigger'); const panel = item.querySelector('.accordion-panel');
  if (!trigger || !panel) return;
  item.classList.toggle('is-open', shouldOpen); trigger.setAttribute('aria-expanded', String(shouldOpen)); panel.hidden = !shouldOpen;
}
function setupAccordion(group) {
  const items = Array.from(group.querySelectorAll('.accordion-item'));
  items.forEach(item => {
    const trigger = item.querySelector('.accordion-trigger'); setAccordionItem(item, item.hasAttribute('data-open'));
    if (trigger) trigger.addEventListener('click', () => {
      const willOpen = trigger.getAttribute('aria-expanded') !== 'true';
      items.forEach(otherItem => setAccordionItem(otherItem, otherItem === item && willOpen));
    });
  });
}
function setupAccordions() { accordionGroups.forEach(setupAccordion); }
function getErrorElement(input) { return document.getElementById(input.id + '-error'); }
function showFieldError(input, message) {
  const errorElement = getErrorElement(input); input.setAttribute('aria-invalid', 'true');
  if (errorElement) errorElement.textContent = message;
}
function clearFieldError(input) {
  const errorElement = getErrorElement(input); input.setAttribute('aria-invalid', 'false');
  if (errorElement) errorElement.textContent = '';
}
function getFieldError(input) {
  const value = input.value.trim(); const label = input.getAttribute('data-label') || 'Kolom ini';
  if (value === '') return label + ' wajib diisi.';
  if (input.type === 'email' && !EMAIL_PATTERN.test(value)) return 'Format email tidak valid. Contoh: nama@email.com';
  return '';
}
function setFormStatus(message) { if (formStatus) formStatus.textContent = message; }
function setupContactForm() {
  if (!contactForm) return;
  const fields = Array.from(contactForm.querySelectorAll('input, textarea'));
  contactForm.addEventListener('submit', event => {
    let firstInvalidField = null;
    fields.forEach(input => {
      const message = getFieldError(input);
      if (message !== '') { showFieldError(input, message); if (firstInvalidField === null) firstInvalidField = input; }
      else clearFieldError(input);
    });
    if (firstInvalidField !== null) {
      event.preventDefault(); firstInvalidField.focus(); setFormStatus('Periksa kembali kolom yang ditandai.');
    }
    // Jika valid, biarkan browser mengirim POST ke PHP untuk divalidasi di server.
  });
  fields.forEach(input => input.addEventListener('input', () => {
    setFormStatus('');
    if (input.getAttribute('aria-invalid') === 'true') {
      const message = getFieldError(input); if (message === '') clearFieldError(input); else showFieldError(input, message);
    }
  }));
}
function setActiveLink(sectionId) {
  navLinks.forEach(link => {
    const isActive = link.getAttribute('href') === '#' + sectionId; link.classList.toggle('active', isActive);
    if (isActive) link.setAttribute('aria-current', 'true'); else link.removeAttribute('aria-current');
  });
}
function setupScrollSpy() {
  if (!('IntersectionObserver' in window)) return;
  document.querySelectorAll('main section[id]').forEach(section => {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) setActiveLink(entry.target.id); }), { rootMargin: '-40% 0px -55% 0px' });
    observer.observe(section);
  });
}
function setupReveal() {
  const items = document.querySelectorAll('.reveal');
  const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!('IntersectionObserver' in window) || prefersReducedMotion) { items.forEach(item => item.classList.add('is-visible')); return; }
  const observer = new IntersectionObserver((entries, currentObserver) => entries.forEach(entry => {
    if (entry.isIntersecting) { entry.target.classList.add('is-visible'); currentObserver.unobserve(entry.target); }
  }), { threshold: 0.12 });
  rootElement.classList.add('js'); items.forEach(item => observer.observe(item));
}
function init() { setupTheme(); setupMenu(); setupSkillCards(); setupAccordions(); setupContactForm(); setupScrollSpy(); setupReveal(); }
init();
