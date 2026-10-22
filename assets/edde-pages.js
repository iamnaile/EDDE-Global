/* EDDE məzmun səhifələri (edde-page.php) üçün skriptlər */
(function () {
  var WA = window.EDDE_WA || '994708332024';

  // ===== Müraciət formaları → admin-ajax (WordPress "Müraciətlər" + e-poçt) =====
  document.querySelectorAll('.epage-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      window.eddeSendLead(form);
    });
  });

  // Universitet kartındakı "məsləhət al" linki formanı həmin universitetlə doldurur
  document.querySelectorAll('[data-interest]').forEach(function (a) {
    a.addEventListener('click', function () {
      var f = document.querySelector('.svc-form-section .epage-form');
      if (f) { f.dataset.interest = a.dataset.interest; }
    });
  });

  // ===== FAQ axtarışı =====
  var search = document.getElementById('faqSearch');
  if (search) {
    var items = Array.prototype.slice.call(document.querySelectorAll('.epage-faq .accordion-item'));
    var empty = document.getElementById('faqEmpty');
    var norm = function (s) { return s.toLocaleLowerCase('az').trim(); };
    search.addEventListener('input', function () {
      var q = norm(search.value), shown = 0;
      items.forEach(function (it) {
        var match = !q || norm(it.textContent).indexOf(q) !== -1;
        it.hidden = !match;
        if (match) { shown++; }
      });
      if (empty) { empty.hidden = shown !== 0; }
    });
  }

  // ===== Ölkələr: tab-lar =====
  var tabs = document.querySelectorAll('.epage-ctab');
  var panels = document.querySelectorAll('[data-panel]');
  if (tabs.length && panels.length) {
    var has = function (id) { return Array.prototype.some.call(panels, function (p) { return p.id === id; }); };
    var show = function (id, updateHash) {
      panels.forEach(function (p) { p.hidden = p.id !== id; });
      tabs.forEach(function (t) {
        var on = t.dataset.target === id;
        t.classList.toggle('is-on', on);
        t.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      if (updateHash && history.replaceState) { history.replaceState(null, '', '#' + id); }
    };
    var fromHash = function () { var id = (location.hash || '').replace('#', ''); return has(id) ? id : null; };
    tabs.forEach(function (t) { t.addEventListener('click', function () { show(t.dataset.target, true); }); });
    show(fromHash() || panels[0].id, false);
    window.addEventListener('hashchange', function () { var id = fromHash(); if (id) { show(id, false); } });
  }
})();
