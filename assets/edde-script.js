// ===== Mobile nav toggle =====
const navToggle = document.getElementById('navToggle');
const mainNav = document.getElementById('mainNav');
navToggle.addEventListener('click', () => mainNav.classList.toggle('open'));
document.querySelectorAll('.main-nav a').forEach(link => {
  link.addEventListener('click', () => mainNav.classList.remove('open'));
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

// ===== Formaların göndərilməsi: admin-ajax → WordPress "Müraciətlər" + e-poçt =====
function eddeCollect(form) {
  const data = { name: '', phone: '', email: '', message: '', details: '', website: '' };
  const details = [];
  form.querySelectorAll('input, select, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'submit' || el.type === 'button') return;
    const val = (el.value || '').trim();
    if (el.name === 'website') { data.website = val; return; }
    if (el.type === 'tel') { data.phone = val; return; }
    if (el.type === 'email') { data.email = val; return; }
    if (el.tagName === 'TEXTAREA') { data.message = val; return; }
    if (el.tagName === 'SELECT') {
      if (el.selectedIndex > 0 && val) details.push((el.options[0].text || 'Seçim') + ': ' + val);
      return;
    }
    if (el.name === 'surname') { data.name = (data.name + ' ' + val).trim(); return; }
    if (!data.name) { data.name = val; return; }
    if (val) details.push((el.placeholder || el.name || 'Sahə') + ': ' + val);
  });
  data.details = details.join('\n');
  data.course = form.dataset.course || '';
  data.source = form.dataset.source || document.title + ' — ' + location.pathname;
  if (form.dataset.interest) data.details += (data.details ? '\n' : '') + 'Maraqlandığı: ' + form.dataset.interest;
  return data;
}

function eddeStatus(form, text, ok) {
  let el = form.querySelector('.form-status');
  if (!el) { el = document.createElement('p'); el.className = 'form-status'; form.appendChild(el); }
  el.textContent = text;
  el.classList.toggle('is-ok', !!ok);
  el.classList.toggle('is-err', !ok);
}

// Uğurda true, xətada false qaytarır; xətada istifadəçi WhatsApp ilə yaza bilsin deyə mesaj göstərilir
window.eddeSendLead = function (form) {
  const data = eddeCollect(form);
  const btn = form.querySelector('button[type="submit"]');
  if (btn) { btn.disabled = true; btn.dataset.label = btn.dataset.label || btn.textContent; btn.textContent = 'Göndərilir…'; }
  const fd = new FormData();
  fd.append('action', 'edde_lead');
  Object.keys(data).forEach(k => fd.append(k, data[k]));
  return fetch(window.EDDE_AJAX || '/wp-admin/admin-ajax.php', { method: 'POST', body: fd, credentials: 'same-origin' })
    .then(r => r.json())
    .then(j => {
      if (!j || !j.success) throw new Error((j && j.data && j.data.message) || 'xəta');
      eddeStatus(form, 'Müraciətiniz qəbul edildi. Tezliklə sizinlə əlaqə saxlayacağıq.', true);
      form.reset();
      return true;
    })
    .catch(err => {
      eddeStatus(form, 'Müraciət göndərilmədi. Zəhmət olmasa WhatsApp və ya telefonla əlaqə saxlayın: +' + (window.EDDE_WA || '994708332024'), false);
      return false;
    })
    .finally(() => { if (btn) { btn.disabled = false; btn.textContent = btn.dataset.label; } });
};

const consultForm = document.getElementById('consultForm');
if (consultForm) {
  consultForm.addEventListener('submit', (e) => {
    e.preventDefault();
    consultForm.dataset.source = 'Zəng istə (modal) — ' + location.pathname;
    window.eddeSendLead(consultForm).then(ok => { if (ok) setTimeout(() => modal.classList.remove('open'), 1800); });
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

// ===== Mega menu on mobile (tap to open instead of hover) =====
document.querySelectorAll('.has-mega > a').forEach(link => {
  link.addEventListener('click', (e) => {
    if (window.innerWidth <= 1100) {
      e.preventDefault();
      link.parentElement.classList.toggle('mega-open');
    }
  });
});
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
    window.eddeSendLead(form).then(ok => { if (ok) form.classList.add('is-sent'); });
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