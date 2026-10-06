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

// ===== Animated counters (triggered when visible) =====
const counters = document.querySelectorAll('.counter-card strong');
let countersStarted = false;

function animateCounters() {
  if (countersStarted) return;
  countersStarted = true;
  counters.forEach(el => {
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
  });
}

const whySection = document.querySelector('.why');
if (whySection) {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => { if (entry.isIntersecting) animateCounters(); });
  }, { threshold: 0.4 });
  observer.observe(whySection);
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

const consultForm = document.getElementById('consultForm');
consultForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const inputs = consultForm.querySelectorAll('input, select');
  const name = inputs[0].value.trim();
  const phone = inputs[1].value.trim();
  const program = inputs[2].value;
  const text = encodeURIComponent(`Salam, mənim adım ${name}. ${program} ilə maraqlanıram. Əlaqə nömrəm: ${phone}`);
  window.open(`https://wa.me/994702141033?text=${text}`, '_blank');
  modal.classList.remove('open');
});
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
    if (window.innerWidth <= 960) {
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
    // TODO: real email/database inteqrasiyası backend-dən qoşulmalıdır (bax qeyd aşağıda)
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