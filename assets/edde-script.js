// ===== Mobil menyu (sürüşən panel) =====
(function () {
  const drawer = document.getElementById('mDrawer');
  const toggle = document.getElementById('navToggle');
  if (!drawer || !toggle) return;
  const setOpen = (open) => {
    drawer.classList.toggle('open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.classList.toggle('is-open', open);
    document.documentElement.classList.toggle('no-scroll', open);
  };
  toggle.addEventListener('click', () => setOpen(!drawer.classList.contains('open')));
  drawer.querySelectorAll('[data-drawer-close]').forEach(b => b.addEventListener('click', () => setOpen(false)));
  // alt menyular (akkordeon)
  drawer.querySelectorAll('.m-acc__btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const acc = btn.parentElement, on = !acc.classList.contains('open');
      drawer.querySelectorAll('.m-acc.open').forEach(o => { o.classList.remove('open'); o.querySelector('.m-acc__btn').setAttribute('aria-expanded', 'false'); });
      acc.classList.toggle('open', on);
      btn.setAttribute('aria-expanded', on ? 'true' : 'false');
    });
  });
  // keçidə basanda menyu bağlansın (xəritə/zəng düymələri öz işini görür)
  drawer.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setOpen(false)));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
  window.addEventListener('resize', () => { if (window.innerWidth > 1230) setOpen(false); });
  window.eddeCloseDrawer = () => setOpen(false);
})();

// ===== Xəritə modalı (Əlaqə menyusundakı "Bakı" qutusu, ünvan keçidi, mobil menyu) =====
(function () {
  const mapModal = document.getElementById('mapModal');
  if (!mapModal) return;
  const open = (e) => {
    if (e) e.preventDefault();
    const f = mapModal.querySelector('iframe');
    if (f && !f.getAttribute('src')) f.setAttribute('src', f.dataset.src);
    mapModal.classList.add('open');
  };
  document.querySelectorAll('[data-open-map], a[href="#map"]').forEach(el => el.addEventListener('click', open));
})();

// ===== "Zəng istə" modalını açan əlavə düymələr (mobil menyu) =====
document.querySelectorAll('[data-open-consult]').forEach(btn => {
  btn.addEventListener('click', () => { const m = document.getElementById('consultModal'); if (m) m.classList.add('open'); });
});

// ===== FAQ accordion =====
document.querySelectorAll('.accordion-trigger').forEach(trigger => {
  trigger.addEventListener('click', () => {
    const item = trigger.parentElement;
    const panel = item.querySelector('.accordion-panel');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.accordion-item').forEach(other => {
      other.classList.remove('open');
      other.querySelector('.accordion-panel').style.maxHeight = null;
    });
    if (!isOpen) {
      item.classList.add('open');
      panel.style.maxHeight = panel.scrollHeight + 'px';
    }
  });
});

// ===== Animated counters (hər sayğac öz görünəndə başlayır; data-count olan bütün elementlər) =====
function animateCounter(el) {
  if (el.dataset.counted) return;
  el.dataset.counted = '1';
  const target = parseInt(el.dataset.count, 10);
  const duration = 1400;
  const start = performance.now();
  function tick(now) {
    const progress = Math.min((now - start) / duration, 1);
    el.textContent = Math.floor(progress * target);
    if (progress < 1) requestAnimationFrame(tick);
    else el.textContent = target + '+';
  }
  requestAnimationFrame(tick);
}

const counterEls = document.querySelectorAll('[data-count]');
if (counterEls.length) {
  if ('IntersectionObserver' in window) {
    const counterObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) { animateCounter(entry.target); counterObserver.unobserve(entry.target); }
      });
    }, { threshold: 0.4 });
    counterEls.forEach(el => counterObserver.observe(el));
  } else {
    counterEls.forEach(animateCounter);
  }
}

// ===== Consult modal =====
const modal = document.getElementById('consultModal');
const openButtons = [
  document.getElementById('openConsult'),
  document.getElementById('openConsult2'),
  document.getElementById('openConsult3')
];
const closeBtn = document.getElementById('closeConsult');

openButtons.forEach(btn => {
  if (btn) btn.addEventListener('click', () => modal.classList.add('open'));
});
closeBtn.addEventListener('click', () => modal.classList.remove('open'));
modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('open'); });

// ===== Formalar: məlumatlar WhatsApp-da hazır mesaj kimi açılır =====
function eddeCollect(form) {
  const parts = [];
  let name = '', phone = '', email = '', message = '';
  form.querySelectorAll('input, select, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'submit' || el.type === 'button') return;
    const val = (el.value || '').trim();
    if (!val) return;
    if (el.type === 'tel') { phone = val; return; }
    if (el.type === 'email') { email = val; return; }
    if (el.tagName === 'TEXTAREA') { message = val; return; }
    if (el.tagName === 'SELECT') { if (el.selectedIndex > 0) parts.push(val); return; }
    if (el.name === 'surname' || !name) { name = (name + ' ' + val).trim(); return; }
    parts.push(val);
  });
  if (form.dataset.interest) parts.push(form.dataset.interest);
  const topic = [form.dataset.course].concat(parts).filter(Boolean).join(', ');
  if (window.EDDE_LANG === 'en') {
    return 'Hello, my name is ' + name + '.' + (topic ? ' I am interested in ' + topic + '.' : '') +
      ' My phone: ' + phone + (email ? ', e-mail: ' + email : '') + '.' + (message ? ' Message: ' + message : '');
  }
  return 'Salam, mənim adım ' + name + '.' + (topic ? ' ' + topic + ' ilə maraqlanıram.' : '') +
    ' Əlaqə nömrəm: ' + phone + (email ? ', e-poçt: ' + email : '') + '.' + (message ? ' Mesaj: ' + message : '');
}

window.eddeSendLead = function (form) {
  const text = eddeCollect(form);
  window.open('https://wa.me/' + (window.EDDE_WA || '994708332004') + '?text=' + encodeURIComponent(text), '_blank');
  return true;
};

const consultForm = document.getElementById('consultForm');
if (consultForm) {
  consultForm.addEventListener('submit', (e) => {
    e.preventDefault();
    window.eddeSendLead(consultForm);
    modal.classList.remove('open');
  });
}
// ===== Academy carousel arrows =====
const academyCarousel = document.getElementById('academyCarousel');
const academyPrev = document.getElementById('academyPrev');
const academyNext = document.getElementById('academyNext');
if (academyCarousel && academyPrev && academyNext) {
  academyPrev.addEventListener('click', () => academyCarousel.scrollBy({ left: -280, behavior: 'smooth' }));
  academyNext.addEventListener('click', () => academyCarousel.scrollBy({ left: 280, behavior: 'smooth' }));
}

// ===== HERO SLIDER =====
(function () {
  const track = document.getElementById('heroTrack');
  const dotsWrap = document.getElementById('heroDots');
  const prevBtn = document.getElementById('heroPrev');
  const nextBtn = document.getElementById('heroNext');
  if (!track) return;

  const slides = track.children.length;
  let current = 0;
  let timer;

  function goTo(index) {
    current = (index + slides) % slides;
    track.style.transform = `translateX(-${current * 100}%)`;
    Array.from(dotsWrap.children).forEach((d, i) => d.classList.toggle('active', i === current));
  }
  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }
  function startAuto() { timer = setInterval(next, 7000); }
  function stopAuto() { clearInterval(timer); }

  nextBtn.addEventListener('click', () => { next(); stopAuto(); startAuto(); });
  prevBtn.addEventListener('click', () => { prev(); stopAuto(); startAuto(); });
  Array.from(dotsWrap.children).forEach((dot, i) => {
    dot.addEventListener('click', () => { goTo(i); stopAuto(); startAuto(); });
  });

  const heroSection = document.querySelector('.hero-slider');
  heroSection.addEventListener('mouseenter', stopAuto);
  heroSection.addEventListener('mouseleave', startAuto);

  // telefonda barmaqla sürüşdürmə
  let sx = null;
  heroSection.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; stopAuto(); }, { passive: true });
  heroSection.addEventListener('touchend', (e) => {
    if (sx !== null) { const dx = e.changedTouches[0].clientX - sx; if (Math.abs(dx) > 40) { dx < 0 ? next() : prev(); } }
    sx = null; startAuto();
  }, { passive: true });

  startAuto();
})();

// ===== HERO MODALS (open/close/submit) =====
document.querySelectorAll('[data-open-modal]').forEach(btn => {
  btn.addEventListener('click', () => {
    const modal = document.getElementById(btn.dataset.openModal);
    if (modal) modal.classList.add('open');
  });
});
document.querySelectorAll('[data-close-modal]').forEach(btn => {
  btn.addEventListener('click', () => btn.closest('.modal-overlay').classList.remove('open'));
});
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', (e) => { if (e.target === overlay) overlay.classList.remove('open'); });
});
document.querySelectorAll('.hero-form').forEach(form => {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    window.eddeSendLead(form);
    form.classList.add('is-sent');
  });
});

// ===== SCROLL-DRIVEN KÜÇÜK PRENS TƏYYARƏSİ =====
(function () {
  const planeWrapper = document.getElementById('planeWrapper');
  if (!planeWrapper) return;

  function updatePlanePosition() {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = scrollHeight > 0 ? Math.min(Math.max(scrollTop / scrollHeight, 0), 1) : 0;
    const vw = window.innerWidth, vh = window.innerHeight;
    let xPct, yPct, rotation;

    if (progress < 0.33) {
      const p = progress / 0.33;
      xPct = 5 + p * 65; yPct = 15 + Math.sin(p * Math.PI) * 15; rotation = Math.sin(p * Math.PI) * 12;
    } else if (progress < 0.66) {
      const p = (progress - 0.33) / 0.33;
      xPct = 70 - p * 55; yPct = 30 + p * 25; rotation = -180 + Math.sin(p * Math.PI) * 10;
    } else {
      const p = (progress - 0.66) / 0.34;
      xPct = 15 + p * 60; yPct = 55 + p * 20; rotation = Math.sin(p * Math.PI) * 15;
    }

    const currentX = (xPct / 100) * (vw - 180);
    const currentY = (yPct / 100) * (vh - 180);
    const isFlipped = rotation < -90 || rotation > 90;
    const flipScale = isFlipped ? 'scaleY(-1)' : 'scaleY(1)';
    planeWrapper.style.transform = `translate3d(${currentX}px, ${currentY}px, 0) rotate(${rotation}deg) ${flipScale}`;
  }

  window.addEventListener('scroll', () => requestAnimationFrame(updatePlanePosition));
  window.addEventListener('resize', updatePlanePosition);
  updatePlanePosition();
})();

// ===== Bütün səhifələrdə: scroll edəndə bölmələr ana səhifədəki kimi tədricən görünsün =====
(function () {
  const root = document.querySelector('.page-content');
  if (!root) return;
  const grids = '.svc-grid, .svc-why__grid, .svc-stats__grid, .svc-includes, .svc-stages, .svc-form__inner, .epage-cards, .epage-stats, .epage-facts, .epage-links, .epage-quotes, .epage-steps, .epage-contact, .atl-grid, .partners-grid';
  const wrappers = '.epage-layout, .epage-content';
  const tag = el => { if (!el.classList.contains('reveal') && !el.closest('.reveal')) el.classList.add('reveal'); };
  const walk = parent => {
    Array.from(parent.children).forEach(c => {
      if (c.classList.contains('reveal') || c.classList.contains('reveal-group') || c.querySelector('.reveal')) return;
      if (c.matches(wrappers)) { walk(c); return; }
      if (c.matches(grids)) { c.classList.add('reveal-group'); Array.from(c.children).forEach(tag); return; }
      tag(c);
    });
  };
  root.querySelectorAll('section').forEach(sec => {
    if (sec.matches('.hero-slider, [class*="hero"]')) return;
    sec.querySelectorAll(':scope > .container, :scope > .container-fluid').forEach(walk);
  });
})();

// ===== SCROLL REVEAL =====
(function () {
  const items = document.querySelectorAll('.reveal');
  if (!items.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  items.forEach(item => observer.observe(item));
})();

// ===== Giriş ekranı (preloader) ilişib qalmasın: normal halda tema özü gizlədir; xəta olarsa 10 san. sonra gizlədilir =====
(function () {
  const pre = document.querySelector('.preloader');
  if (!pre) return;
  setTimeout(function () {
    if (!document.body.contains(pre)) return;
    pre.style.transition = 'opacity .5s ease';
    pre.style.opacity = '0';
    pre.style.pointerEvents = 'none';
    setTimeout(function () { pre.style.display = 'none'; }, 600);
  }, 10000);
})();


// ===== Telefonda oxlarla keçid (Proqramlar, Proses) =====
function eddeCarousel(g, itemSel) {
  if (!g) return;
  var cards = g.querySelectorAll(itemSel);
  var nav = document.createElement('div');
  nav.className = 'atl-nav';
  nav.innerHTML = '<button type="button" aria-label="‹" data-d="-1">‹</button><span class="atl-nav__count"></span><button type="button" aria-label="›" data-d="1">›</button>';
  g.parentNode.insertBefore(nav, g.nextSibling);
  var cnt = nav.querySelector('.atl-nav__count');
  function idx() { var c = g.scrollLeft + g.clientWidth / 2, best = 0, bd = 1e9; cards.forEach(function (e, i) { var d = Math.abs(e.offsetLeft + e.offsetWidth / 2 - c); if (d < bd) { bd = d; best = i; } }); return best; }
  function upd() { cnt.textContent = (idx() + 1) + ' / ' + cards.length; }
  nav.addEventListener('click', function (e) {
    var b = e.target.closest('button'); if (!b) return;
    var i = Math.max(0, Math.min(cards.length - 1, idx() + parseInt(b.dataset.d, 10)));
    g.scrollTo({ left: cards[i].offsetLeft - (g.clientWidth - cards[i].offsetWidth) / 2, behavior: 'smooth' });
  });
  g.addEventListener('scroll', upd, { passive: true });
  upd();
}
eddeCarousel(document.querySelector('.programs .atl-grid'), '.atl-card');
eddeCarousel(document.querySelector('.process-steps'), '.process-step');

// ===== Telefon: üst panellə ilk bölmə arasında artıq boşluq qalmasın =====
(function () {
  const emb = document.getElementById('emb');
  const root = document.querySelector('.page-content');
  if (!emb || !root) return;
  function fit() {
    document.body.style.marginTop = '';
    if (window.innerWidth > 1230) return;
    let first = null;
    for (const el of root.children) {
      if (el.classList.contains('edde-hdr') || el.classList.contains('emb') || /^(SCRIPT|STYLE)$/.test(el.tagName)) continue;
      if (el.offsetHeight > 0 && getComputedStyle(el).position !== 'fixed') { first = el; break; }
    }
    if (!first) return;
    const gap = Math.round(first.getBoundingClientRect().top + window.scrollY - emb.offsetHeight);
    if (gap > 2) document.body.style.marginTop = (-gap) + 'px';
  }
  window.addEventListener('load', fit);
  window.addEventListener('resize', fit);
  setTimeout(fit, 400);
})();

// ===== Hero: bütün slaydlar eyni hündürlükdə olsun (mətn uzunluğundan asılı olmayaraq) =====
(function () {
  const slides = Array.from(document.querySelectorAll('.hero-slider .hero-slide'));
  if (slides.length < 2) return;
  function equalize() {
    slides.forEach(s => { s.style.minHeight = ''; });
    if (window.innerWidth > 900) return;
    const h = Math.max.apply(null, slides.map(s => s.offsetHeight));
    slides.forEach(s => { s.style.minHeight = h + 'px'; });
  }
  window.addEventListener('load', equalize);
  window.addEventListener('resize', equalize);
  setTimeout(equalize, 600);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(equalize);
})();
