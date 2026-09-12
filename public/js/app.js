/* Very Longsword Studio — front-end behaviour (no build step, vanilla JS) */
(function () {
  'use strict';

  /* --- reveal on scroll --------------------------------------------------- */
  var nodes = Array.prototype.slice.call(document.querySelectorAll('[data-reveal]'));
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (nodes.length && !reduce && 'IntersectionObserver' in window) {
    document.documentElement.classList.add('reveal-ready');
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e, i) {
        if (e.isIntersecting) {
          var el = e.target;
          el.style.transitionDelay = Math.min(i, 4) * 70 + 'ms';
          el.classList.add('is-visible');
          io.unobserve(el);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    nodes.forEach(function (n) { io.observe(n); });
    // Safety net: if anything is still hidden after 1.2s, show it.
    setTimeout(function () {
      nodes.forEach(function (n) { n.classList.add('is-visible'); });
    }, 1200);
  } else {
    nodes.forEach(function (n) { n.classList.add('is-visible'); });
  }

  /* --- header scrolled state + mobile nav --------------------------------- */
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    var toggle = header.querySelector('.nav-toggle');
    if (toggle) {
      toggle.addEventListener('click', function () {
        var open = header.classList.toggle('nav-open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      // Close the menu after tapping a link.
      header.querySelectorAll('.nav a').forEach(function (a) {
        a.addEventListener('click', function () {
          header.classList.remove('nav-open');
          toggle.setAttribute('aria-expanded', 'false');
        });
      });
    }
  }

  /* --- if the form was just sent, scroll it into view --------------------- */
  var alert = document.querySelector('[data-form-alert]');
  if (alert) {
    alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
})();
