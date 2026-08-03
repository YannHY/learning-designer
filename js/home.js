document.addEventListener('DOMContentLoaded', function () {
  var sections = Array.prototype.slice.call(document.querySelectorAll('.home-reveal'));
  if (!sections.length) return;

  var reduceMotion = window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduceMotion || !('IntersectionObserver' in window)) {
    sections.forEach(function (section) {
      section.classList.add('is-visible');
    });
    return;
  }

  document.documentElement.classList.add('reveal-ready');

  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, {
    threshold: 0.08,
    rootMargin: '0px 0px -12% 0px'
  });

  window.requestAnimationFrame(function () {
    sections.forEach(function (section) {
      observer.observe(section);
    });
  });
});
