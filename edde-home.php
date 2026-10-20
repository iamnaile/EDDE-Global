<?php
/**
 * Template Name: EDDE Dizayn
 */
?>
<!DOCTYPE html>
<html lang="az" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EDDE Global — Xaricdə Təhsil Yolunda Birlikdə Addımlayırıq</title>
<meta name="description" content="EDDE Global — 2018-ci ildən 400-dən çox universitetlə əməkdaşlıq edən etibarlı xaricdə təhsil şirkəti.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-styles.css">
</head>
<body <?php body_class('edde-page'); ?>>
  <div class="page-bg" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/bg-home.jpg');"></div>
<div class="page-bg-overlay"></div>
<div class="page-content">
  
<!-- ============ SCROLL-DRIVEN KÜÇÜK PRENS TƏYYARƏSİ ============ -->
<div id="airplane-container">
  <div id="planeWrapper" class="plane-float-bob">
    <svg class="plane-svg" viewBox="0 0 200 160" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path class="plane-scarf" d="M95 62 Q 60 55 35 68 Q 55 60 95 64 Z" fill="#FBBF24"/>
      <path d="M102 42 C 95 35, 110 30, 108 22 C 115 28, 120 25, 122 35 C 126 30, 130 38, 120 44 Z" fill="#FACC15"/>
      <circle cx="112" cy="45" r="9" fill="#FED7AA"/>
      <circle cx="115" cy="44" r="1" fill="#475569"/>
      <path d="M102 54 C 102 54, 110 52, 120 54 L 118 70 L 100 70 Z" fill="#10B981"/>
      <line x1="135" y1="60" x2="135" y2="95" stroke="#7f1d1d" stroke-width="2.5"/>
      <path d="M80 95 L 140 90 C 145 95, 145 95, 140 98 L 80 100 C 75 100, 75 95, 80 95 Z" fill="#B91C1C"/>
      <path d="M50 80 C 50 70, 130 65, 165 80 C 175 85, 170 95, 150 95 C 100 95, 60 90, 50 80 Z" fill="#DC2626"/>
      <path d="M50 80 C 50 72, 130 68, 160 80 Z" fill="#EF4444"/>
      <ellipse cx="110" cy="72" rx="18" ry="6" fill="#991B1B"/>
      <path d="M52 80 L 35 60 L 48 58 L 62 76 Z" fill="#B91C1C"/>
      <path d="M52 80 L 30 98 L 42 96 L 65 85 Z" fill="#B91C1C"/>
      <path d="M85 55 L 145 55 C 150 55, 150 60, 145 60 L 85 60 C 80 60, 80 55, 85 55 Z" fill="#EF4444"/>
      <line x1="95" y1="60" x2="95" y2="95" stroke="#7f1d1d" stroke-width="2.5"/>
      <circle cx="120" cy="108" r="8" fill="#1E293B"/>
      <circle cx="120" cy="108" r="4" fill="#94A3B8"/>
      <line x1="115" y1="95" x2="120" y2="108" stroke="#475569" stroke-width="3"/>
      <path d="M162 77 C 170 77, 177 81, 177 87 C 177 91, 170 94, 162 94 Z" fill="#475569"/>
      <circle cx="174" cy="85" r="3" fill="#F8FAFC"/>
      <g class="plane-propeller" transform="translate(174, 82)">
        <ellipse cx="175" cy="78" rx="3.5" ry="24" fill="#E2E8F0" opacity="0.85"/>
      </g>
    </svg>
  </div>
</div>

<!-- ============ HEADER (vahid naviqasiya: inc/edde-nav.php) ============ -->
<?php include get_stylesheet_directory() . '/parts/edde-header.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero-slider" id="top">
  <div class="hero-slider__track" id="heroTrack">

    <div class="hero-slide hero-slide--s1">
      <div class="container hero-slide__inner">
        <div class="hero-slide__text">
          <p class="eyebrow">Xaricdə Təhsil</p>
          <h1>Dünyanın aparıcı universitetlərinə açılan qapınız</h1>
          <p>2018-ci ildən bəri EDDE Global tələbələrin xaricdə təhsil arzusunu reallığa çevirir. Dünyanın 20-dən çox ölkəsində, 400-ə yaxın nüfuzlu universitetlə birbaşa əməkdaşlıq edirik.</p>
          <div class="hero-slide__actions">
            <button class="btn btn--primary" data-open-modal="modalTehsil">Müraciət et</button>
            <a href="<?php echo home_url('/xaricde-tehsil/'); ?>" class="btn btn--outline">Ətraflı məlumat</a>
          </div>
        </div>
        <div class="hero-slide__visual">
          <div class="hero-visual-card">
            <span class="hero-visual-card__emoji">🌐</span>
            <div class="hero-visual-card__badge"><strong>400+</strong><span>Universitet</span></div>
          </div>
        </div>
      </div>
    </div>

    <div class="hero-slide hero-slide--s2">
      <div class="container hero-slide__inner">
        <div class="hero-slide__text">
          <p class="eyebrow">EDDE Academy</p>
          <h1>Dil və imtahan hazırlığı mərkəzi</h1>
          <p>IELTS, TOEFL, Duolingo, PTE, SAT, General English, Business English, Kids English, Türk və Alman dili kursları — sertifikatlı müəllimlər və fərdi inkişaf planı ilə.</p>
          <div class="hero-slide__actions">
            <button class="btn btn--primary" data-open-modal="modalAcademy">Müraciət et</button>
            <a href="<?php echo home_url('/edde-xidmetler/'); ?>" class="btn btn--outline">Ətraflı məlumat</a>
          </div>
        </div>
        <div class="hero-slide__visual">
          <div class="hero-visual-card">
            <span class="hero-visual-card__emoji">📖</span>
            <div class="hero-visual-card__badge"><strong>IELTS 5.5→7.5</strong><span>Bal artımı</span></div>
          </div>
        </div>
      </div>
    </div>
<div class="hero-slide hero-slide--s4">
      <div class="container hero-slide__inner">
        <div class="hero-slide__text">
          <p class="eyebrow">EDDE Corporate</p>
          <h1>Şirkətlər üçün korporativ təlim və dil həlləri</h1>
          <p>Komandanızın peşəkar inkişafı üçün korporativ xarici dil kursları və ixtisaslaşmış təlim proqramları təşkil edirik — ofisinizdə, bizim mərkəzdə və ya onlayn.</p>
          <div class="hero-slide__actions">
            <button class="btn btn--primary" data-open-modal="modalCorporate">Müraciət et</button>
            <a href="<?php echo home_url('/korporativ/'); ?>" class="btn btn--outline">Ətraflı məlumat</a>
          </div>
        </div>
        <div class="hero-slide__visual">
          <div class="hero-visual-card">
            <span class="hero-visual-card__emoji">🏢</span>
            <div class="hero-visual-card__badge"><strong>5 addım</strong><span>İş modeli</span></div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-slide hero-slide--s3">
      <div class="container hero-slide__inner">
        <div class="hero-slide__text">
          <p class="eyebrow">EDDE Event</p>
          <h1>Təhsil tədbirləri, seminarlar və universitet görüşləri</h1>
          <p>Universitet nümayəndələri ilə birbaşa görüşlər, təqaüd və viza mövzusunda seminarlar, xaricdə təhsil almış məzunların təcrübə paylaşımları. İştirak pulsuzdur, sertifikat təqdim olunur.</p>
          <div class="hero-slide__actions">
            <a href="<?php echo home_url('/tedbirler/'); ?>" class="btn btn--primary">Ətraflı</a>
          </div>
        </div>
        <div class="hero-slide__visual">
          <div class="hero-visual-card">
            <span class="hero-visual-card__emoji">📅</span>
            <div class="hero-visual-card__badge"><strong>Pulsuz</strong><span>Sertifikatlı iştirak</span></div>
          </div>
        </div>
      </div>
    </div>

    

  </div>

  <button class="hero-slider__arrow hero-slider__arrow--prev" id="heroPrev" aria-label="Əvvəlki">‹</button>
  <button class="hero-slider__arrow hero-slider__arrow--next" id="heroNext" aria-label="Növbəti">›</button>

  <div class="hero-slider__dots" id="heroDots">
    <button class="active" data-slide="0" aria-label="Slayd 1"></button>
    <button data-slide="1" aria-label="Slayd 2"></button>
    <button data-slide="2" aria-label="Slayd 3"></button>
    <button data-slide="3" aria-label="Slayd 4"></button>
  </div>
</section>

<!-- ============ WHY US ============ -->
<section class="why" id="why">
  <div class="container why__inner">
    <div class="why__text reveal">
      <p class="eyebrow">Bizi niyə seçirlər?</p>
      <h2>2018-ci ildən etibarlı yol yoldaşınız</h2>
      <p>EDDE Global, tələbələrimizə xaricdə təhsil prosesinin hər addımında — universitet seçimindən sənədləşməyə, viza müraciətindən uçuşa qədər — real, tətbiqi dəstək veririk. Nəzəri vədlər yox, konkret nəticə.</p>
      <p>Bu gün tələbələrə işəgötürənlərin və beynəlxalq universitetlərin gözlədiyi hazırlığı təmin edirik — düzgün sənədləşmə, güclü motivasiya məktubu və uyğun proqram seçimi ilə.</p>
    </div>
    <div class="why__stats reveal-group">
      <div class="counter-card reveal"><strong data-count="20">0</strong><span>Ölkə</span></div>
      <div class="counter-card reveal"><strong data-count="400">0</strong><span>Universitet</span></div>
      <div class="counter-card reveal"><strong data-count="1000">0</strong><span>Tələbə</span></div>
      <div class="counter-card reveal"><strong data-count="15">0</strong><span>Məsləhətçi</span></div>
      <div class="counter-card reveal"><strong data-count="7">0</strong><span>İl təcrübə</span></div>
    </div>
  </div>
</section>

<!-- ============ CONSULT BANNER ============ -->
<section class="consult-banner">
  <div class="container consult-banner__inner reveal">
    <div>
      <h2>Seçim etməyə kömək edərik!</h2>
      <p>Xaricdə hansı universiteti, ölkəni və proqramı seçəcəyinizdə əmin deyilsinizsə, nömrənizi buraxın — məsləhətçilərimiz sizə zəng edib bütün suallarınızı cavablandırsın.</p>
    </div>
    <button class="btn btn--light" id="openConsult2">Məsləhət almaq</button>
  </div>
</section>

<!-- ============ ACADEMY ============ -->
<section class="academy" id="academy">
  <div class="container">
    <div class="section-head section-head--light reveal">
      <p class="eyebrow">EDDE Academy</p>
      <h2>Beynəlxalq imtahanlara hazırlıq kursları</h2>
    </div>
    <div class="academy-carousel-wrap">
  <div class="academy-carousel reveal-group" id="academyCarousel">
    <a href="<?php echo home_url('/edde-ielts/'); ?>" class="academy-card academy-card--c1 reveal">
      <h3>IELTS</h3>
      <div class="academy-card__overlay">
        <p>Band 7–8+ hədəfi üçün mütəxəssis rəhbərliyi altında hazırlıq.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c2 reveal">
      <h3>TOEFL</h3>
      <div class="academy-card__overlay">
        <p>Akademik İngilis dili imtahanlarına effektiv hazırlıq.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c3 reveal">
      <h3>PTE Academic</h3>
      <div class="academy-card__overlay">
        <p>Kompüter-əsaslı qiymətləndirmə formatına tam hazırlıq.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c4 reveal">
      <h3>SAT</h3>
      <div class="academy-card__overlay">
        <p>Math və Verbal bölmələri üzrə strukturlaşdırılmış təlim.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c5 reveal">
      <h3>Duolingo Test</h3>
      <div class="academy-card__overlay">
        <p>Sürətli, əlçatan beynəlxalq dil sertifikatına hazırlıq.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c1 reveal">
      <h3>General English</h3>
      <div class="academy-card__overlay">
        <p>Gündəlik və akademik istifadə üçün inamlı dil bacarığı.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c2 reveal">
      <h3>Kids English</h3>
      <div class="academy-card__overlay">
        <p>Uşaqlar üçün interaktiv dil bacarığı proqramı.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c3 reveal">
      <h3>Alman Dili</h3>
      <div class="academy-card__overlay">
        <p>Almaniyada təhsil üçün başlanğıcdan irəliləmiş səviyyəyə qədər.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c4 reveal">
      <h3>Türk Dili</h3>
      <div class="academy-card__overlay">
        <p>Türkiyədə təhsil üçün lazım olan dil bacarıqları.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
    <a href="#academy" class="academy-card academy-card--c5 reveal">
      <h3>LanguageCert</h3>
      <div class="academy-card__overlay">
        <p>Beynəlxalq səviyyədə tanınan alternativ dil sertifikatı.</p>
        <span>Proqramla yaxından tanış olun ↗</span>
      </div>
    </a>
  </div>
  <div class="academy-carousel-nav">
    <button id="academyPrev" aria-label="Geri">←</button>
    <button id="academyNext" aria-label="İrəli">→</button>
  </div>
</div>
    <div class="academy__cta">
      <button class="btn btn--primary" id="openConsult3">Kursa qeydiyyatdan keç</button>
    </div>
  </div>
</section>

<!-- ============ PROCESS ============ -->
<section class="process" id="process">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Proses</p>
      <h2>Xaricdə təhsil prosesi necə işləyir?</h2>
    </div>
    <div class="process-steps reveal-group">

      <div class="process-step reveal">
        <div class="process-step__circle">01</div>
        <h3>Konsultasiya</h3>
        <p>Akademik göstəricilər, dil səviyyəsi, büdcə və hədəf ölkələr müzakirə olunur, şərtlər müqavilə ilə rəsmiləşdirilir.</p>
      </div>

      <div class="process-step reveal">
        <div class="process-step__circle">02</div>
        <h3>Mentor və araşdırma</h3>
        <p>Fərdi mentor təyin olunur, profilinizə uyğun ölkə, universitet və proqramlar üzrə ətraflı araşdırma aparılır.</p>
      </div>

      <div class="process-step reveal">
        <div class="process-step__circle">03</div>
        <h3>Universitet seçimi</h3>
        <p>Variantlar birlikdə dəyərləndirilir, hədəf və təhlükəsiz seçimləri əhatə edən yekun siyahı təsdiqlənir.</p>
      </div>

      <div class="process-step reveal">
        <div class="process-step__circle">04</div>
        <h3>Müraciətlər</h3>
        <p>Diplom, dil sertifikatı, motivasiya məktubu və CV hazırlanır, müraciətlər göndərilir və statusu izlənilir.</p>
      </div>

      <div class="process-step reveal">
        <div class="process-step__circle">05</div>
        <h3>Qəbul və yaşayış</h3>
        <p>Təkliflər müqayisə edilir, ən uyğunu qəbul olunur, yataqxana və ya alternativ yaşayış rezerv edilir.</p>
      </div>

      <div class="process-step reveal">
        <div class="process-step__circle">06</div>
        <h3>Viza</h3>
        <p>Viza sənədləri toplanır, müsahibəyə hazırlıq edilir — yeni mühitə və təhsil həyatına tam hazırsınız.</p>
      </div>

    </div>
  </div>
</section>

<!-- ============ PARTNER COUNTRIES MARQUEE ============ -->
<section class="countries-strip">
  <div class="marquee">
    <div class="marquee__track">

      <div class="country-card"><span class="country-card__icon">🕌</span><strong>Türkiyə</strong><img src="https://flagcdn.com/w80/tr.png" alt="Türkiyə bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏰</span><strong>Almaniya</strong><img src="https://flagcdn.com/w80/de.png" alt="Almaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">👑</span><strong>Böyük Britaniya</strong><img src="https://flagcdn.com/w80/gb.png" alt="Böyük Britaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🗽</span><strong>ABŞ</strong><img src="https://flagcdn.com/w80/us.png" alt="ABŞ bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🌲</span><strong>Latviya</strong><img src="https://flagcdn.com/w80/lv.png" alt="Latviya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🛡️</span><strong>Litva</strong><img src="https://flagcdn.com/w80/lt.png" alt="Litva bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">💻</span><strong>Estoniya</strong><img src="https://flagcdn.com/w80/ee.png" alt="Estoniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🎻</span><strong>Macarıstan</strong><img src="https://flagcdn.com/w80/hu.png" alt="Macarıstan bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🦅</span><strong>Polşa</strong><img src="https://flagcdn.com/w80/pl.png" alt="Polşa bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏟️</span><strong>İspaniya</strong><img src="https://flagcdn.com/w80/es.png" alt="İspaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🍁</span><strong>Kanada</strong><img src="https://flagcdn.com/w80/ca.png" alt="Kanada bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏔️</span><strong>Slovakiya</strong><img src="https://flagcdn.com/w80/sk.png" alt="Slovakiya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">⛩️</span><strong>Yaponiya</strong><img src="https://flagcdn.com/w80/jp.png" alt="Yaponiya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🗼</span><strong>Fransa</strong><img src="https://flagcdn.com/w80/fr.png" alt="Fransa bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🎎</span><strong>Cənubi Koreya</strong><img src="https://flagcdn.com/w80/kr.png" alt="Cənubi Koreya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🐉</span><strong>Çin</strong><img src="https://flagcdn.com/w80/cn.png" alt="Çin bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏙️</span><strong>Dubay</strong><img src="https://flagcdn.com/w80/ae.png" alt="BƏƏ bayrağı"></div>

      <!-- Fasiləsiz dövr üçün siyahı təkrarlanır -->
      <div class="country-card"><span class="country-card__icon">🕌</span><strong>Türkiyə</strong><img src="https://flagcdn.com/w80/tr.png" alt="Türkiyə bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏰</span><strong>Almaniya</strong><img src="https://flagcdn.com/w80/de.png" alt="Almaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">👑</span><strong>Böyük Britaniya</strong><img src="https://flagcdn.com/w80/gb.png" alt="Böyük Britaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🗽</span><strong>ABŞ</strong><img src="https://flagcdn.com/w80/us.png" alt="ABŞ bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🌲</span><strong>Latviya</strong><img src="https://flagcdn.com/w80/lv.png" alt="Latviya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🛡️</span><strong>Litva</strong><img src="https://flagcdn.com/w80/lt.png" alt="Litva bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">💻</span><strong>Estoniya</strong><img src="https://flagcdn.com/w80/ee.png" alt="Estoniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🎻</span><strong>Macarıstan</strong><img src="https://flagcdn.com/w80/hu.png" alt="Macarıstan bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🦅</span><strong>Polşa</strong><img src="https://flagcdn.com/w80/pl.png" alt="Polşa bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏟️</span><strong>İspaniya</strong><img src="https://flagcdn.com/w80/es.png" alt="İspaniya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🍁</span><strong>Kanada</strong><img src="https://flagcdn.com/w80/ca.png" alt="Kanada bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏔️</span><strong>Slovakiya</strong><img src="https://flagcdn.com/w80/sk.png" alt="Slovakiya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">⛩️</span><strong>Yaponiya</strong><img src="https://flagcdn.com/w80/jp.png" alt="Yaponiya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🗼</span><strong>Fransa</strong><img src="https://flagcdn.com/w80/fr.png" alt="Fransa bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🎎</span><strong>Cənubi Koreya</strong><img src="https://flagcdn.com/w80/kr.png" alt="Cənubi Koreya bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🐉</span><strong>Çin</strong><img src="https://flagcdn.com/w80/cn.png" alt="Çin bayrağı"></div>
      <div class="country-card"><span class="country-card__icon">🏙️</span><strong>Dubay</strong><img src="https://flagcdn.com/w80/ae.png" alt="BƏƏ bayrağı"></div>

    </div>
  </div>
</section>

<!-- ============ PROGRAMS ============ -->

<section class="programs" id="programs">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Proqramlar</p>
      <h2>Hər mərhələ üçün uyğun seçim</h2>
    </div>
    <div class="atl-grid reveal-group">

      <a href="<?php echo home_url('/foundation/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">🎒</div>
          <span class="atl-card__badge">Hazırlıq proqramı</span>
        </div>
        <h3>Foundation Təhsili</h3>
        <p>A-level, IB və SAT olmadan dünyanın top universitetlərinə qəbul. 11 illik təhsillə Foundation proqramına keçid mümkündür.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

      <a href="<?php echo home_url('/bakalavr/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">🎓</div>
          <span class="atl-card__badge">Akademik təhsil</span>
        </div>
        <h3>Bakalavr</h3>
        <p>Amerika, İngiltərə, Kanada və 10+ ölkədə bakalavr təhsili. İmtahanla və imtahansız qəbul seçimləri mövcuddur.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

      <a href="<?php echo home_url('/magistratura/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">📚</div>
          <span class="atl-card__badge">Akademik təhsil</span>
        </div>
        <h3>Magistratura</h3>
        <p>Əyani, distant və hibrid formatlarda magistratura. GPA aşağı olanlar üçün Pre-Master hazırlıq proqramı.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

      <a href="<?php echo home_url('/doktorantura/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">🔬</div>
          <span class="atl-card__badge">Elmi karyera</span>
        </div>
        <h3>Doktorantura</h3>
        <p>Hibrid və əyani formatda doktorantura proqramları — Türkiyə, Avropa və UK-da rəsmi tanınan diplomlar.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

      <a href="<?php echo home_url('/turkiyede-tehsil/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">🕌</div>
          <span class="atl-card__badge">Ölkə proqramı</span>
        </div>
        <h3>Türkiyədə təhsil</h3>
        <p>Bakalavr, magistr və doktorantura pillələri; YÖS, SAT və ya attestat balı ilə qəbul imkanı.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

      <a href="<?php echo home_url('/teqaud/'); ?>" class="atl-card reveal">
        <div class="atl-card__top">
          <div class="atl-card__icon">💰</div>
          <span class="atl-card__badge">Maliyyə dəstəyi</span>
        </div>
        <h3>Təqaüd Proqramları</h3>
        <p>Chevening, Erasmus+, Fulbright, DAAD, Türkiye Bursları və HTP — tam maliyyələşdirilən təqaüd seçimləri.</p>
        <div class="atl-card__bottom atl-card__bottom--center">
          <span class="atl-card__link">Ətraflı <span>→</span></span>
        </div>
      </a>

    </div>
  </div>
</section>

<!-- ============ STUDENT STORIES ============ -->
<section class="reviews" id="reviews">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Tələbə hekayələri</p>
      <h2>Məzunlarımızın uğur hekayələri</h2>
    </div>
    <div class="reviews__grid reveal-group">
      <div class="story-card reveal">
        <div class="story-card__stars">★★★★★</div>
        <p>"EDDE Global peşəkar yanaşması ilə övladımın xaricdə təhsil prosesini rahat və vaxtında tamamladı. Komandaya minnətdarıq."</p>
        <div class="story-card__meta"><strong>Hümmət Əliyev</strong><span>Quba 1 saylı Mediasiya Təşkilatının Direktoru</span></div>
      </div>
      <div class="story-card reveal">
        <div class="story-card__stars">★★★★★</div>
        <p>"Edde Global dünyanın aparıcı universitetlərində geniş imkanlar təqdim edən peşəkar bir şirkətdir. Üç övladım onların dəstəyi ilə xaricdə oxuyur."</p>
        <div class="story-card__meta"><strong>Dr. Nəcəf Allahverdiyev</strong><span>KarnegiKlub Treninq Mərkəzinin rəhbəri</span></div>
      </div>
      <div class="story-card reveal">
        <div class="story-card__stars">★★★★★</div>
        <p>"Sənədləşmə və universitet seçimində göstərdikləri diqqət sayəsində bütün prosesi problemsiz tamamladıq. Hər kəsə tövsiyə edirəm."</p>
        <div class="story-card__meta"><strong>Aqşin Rəhmanov</strong><span>BankRespublika filial direktoru</span></div>
      </div>
      <div class="story-card reveal">
        <div class="story-card__stars">★★★★★</div>
        <p>"EDDE Global sadəcə tərəfdaş deyil, etibarlı yol yoldaşımızdır. Uğurlu əməkdaşlığımız beynəlxalq təhsil sahəsində nümunədir."</p>
        <div class="story-card__meta"><strong>Nuket Tanol</strong><span>BAU Cyprus, Beynəlxalq Əlaqələr Direktoru</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ TƏRƏFDAŞ LOQOLARI ============ -->
<?php
// assets/logos qovluğundakı bütün şəkilləri avtomatik oxuyur
$logo_dir   = get_stylesheet_directory() . '/assets/logos/';
$logo_url   = get_stylesheet_directory_uri() . '/assets/logos/';
$logo_files = glob($logo_dir . '*.{png,jpg,jpeg,webp,svg,PNG,JPG,JPEG,WEBP,SVG}', GLOB_BRACE);
$logo_files = $logo_files ? array_map('basename', $logo_files) : [];
sort($logo_files, SORT_NATURAL | SORT_FLAG_CASE);

// Hər loqonun nisbətinə görə eyni "vizual çəki" (sahə) verən ölçü hesablanır
$logo_area = 22000;  // ümumi böyüklük: artırsanız hamısı böyüyür
$logo_maxw = 340;    // ən enli loqonun maksimum eni
$logo_maxh = 130;    // ən hündür loqonun maksimum hündürlüyü
$logo_items = [];
foreach ($logo_files as $f) {
  $path  = $logo_dir . $f;
  $ratio = 2.5;      // ölçüsü oxuna bilməyən fayllar üçün ehtiyat nisbət
  $info  = @getimagesize($path);
  if ($info && $info[1] > 0) {
    $ratio = $info[0] / $info[1];
  } elseif (strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'svg') {
    $svg = @file_get_contents($path);
    if ($svg && preg_match('/viewBox=["\']\s*[-\d.]+[\s,]+[-\d.]+[\s,]+([\d.]+)[\s,]+([\d.]+)/i', $svg, $m) && (float) $m[2] > 0) {
      $ratio = (float) $m[1] / (float) $m[2];
    }
  }
  $w = sqrt($logo_area * $ratio);
  $h = sqrt($logo_area / $ratio);
  if ($w > $logo_maxw) { $h = $h * $logo_maxw / $w; $w = $logo_maxw; }
  if ($h > $logo_maxh) { $w = $w * $logo_maxh / $h; $h = $logo_maxh; }
  $logo_items[] = ['file' => $f, 'w' => round($w), 'h' => round($h)];
}

// Zolaq boş yer qoymasın deyə az loqo olanda siyahı təkrarlanır
$logo_set = $logo_items;
while ($logo_set && count($logo_set) < 12) {
  $logo_set = array_merge($logo_set, $logo_items);
}
?>
<?php if ($logo_items) : ?>
<section class="logo-strip">
  <div class="container">
    <div class="section-head reveal">
    </div>
  </div>
  <div class="logo-strip__viewport">
    <!-- sürət loqo sayından asılı olmayaraq eyni qalsın deyə müddət sayla hesablanır -->
    <div class="logo-strip__track" style="animation-duration: <?php echo count($logo_set) * 5; ?>s;">
      <?php for ($pass = 0; $pass < 2; $pass++) :
        foreach ($logo_set as $item) :
          $alt = ucwords(str_replace(['-', '_'], ' ', pathinfo($item['file'], PATHINFO_FILENAME))); ?>
          <div class="logo-strip__item" style="width: <?php echo (int) $item['w']; ?>px; height: <?php echo (int) $item['h']; ?>px;"<?php echo $pass ? ' aria-hidden="true"' : ''; ?>>
            <img src="<?php echo esc_url($logo_url . rawurlencode($item['file'])); ?>" alt="<?php echo $pass ? '' : esc_attr($alt); ?>" loading="lazy">
          </div>
      <?php endforeach; endfor; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="faq" id="faq">
  <div class="container faq__inner">
    <div class="section-head reveal">
      <p class="eyebrow">FAQ</p>
      <h2>Tez-tez verilən suallar</h2>
    </div>
    <div class="accordion" id="accordion">
      <div class="accordion-item">
        <button class="accordion-trigger">Xaricdə təhsil üçün müraciət prosesinə necə başlaya bilərəm?</button>
        <div class="accordion-panel"><p>İlk addım olaraq bizimlə əlaqə saxlayın və pulsuz konsultasiya üçün görüş təyin edin. Məsləhətçilərimiz sizə uyğun universitet və proqram seçimində kömək edəcək.</p></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Xaricdə təhsil almaq üçün hansı ölkələrdə universitetlər təklif edirsiniz?</button>
        <div class="accordion-panel"><p>Bizim təklif etdiyimiz ölkələr arasında ABŞ, Kanada, İngiltərə, Avstraliya, Almaniya, Polşa, Macarıstan, Latviya, İtaliya, Türkiyə, Litva, Cənubi Koreya, Malayziya, Malta və s. var.</p></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Xaricdə imtahansız təhsil almaq mümkündürmü?</button>
        <div class="accordion-panel"><p>Bəli, bəzi universitetlər imtahansız qəbul təklif edir.</p></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Xaricdə təhsil müddətində işləmək mümkündürmü?</button>
        <div class="accordion-panel"><p>Bir çox ölkədə tələbələrə həftəlik 15–20 saat işləməyə icazə verilir.</p></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Xaricdə tibb təhsili almaq üçün hansı şərtlər tələb olunur?</button>
        <div class="accordion-panel"><p>Yüksək GPA, IELTS/TOEFL kimi dil sertifikatı, motivasiya məktubu və bəzi hallarda giriş imtahanı tələb olunur. Bizim vasitəmizlə müxtəlif ölkələrdə tibb üzrə təhsil ala bilərsiniz.</p></div>
      </div>
      <div class="accordion-item">
        <button class="accordion-trigger">Referans məktubu nədir?</button>
        <div class="accordion-panel"><p>Referans məktubu müəllim və ya işəgötürən tərəfindən yazılan və sizin bacarıqlarınızı təsdiqləyən məktubdur.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- ============ CONTACT / FOOTER ============ -->
<footer class="site-footer" id="contact">
  <div class="container footer__grid">

    <div class="footer__col footer__col--brand">
      <a href="#top" class="logo logo--light"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>
      <p>2018-ci ildən bəri tələbələrin xaricdə təhsil arzularını gerçəkləşdirməsinə kömək edən etibarlı təhsil şirkəti.</p>
      <div class="footer__social">
        <a href="https://www.facebook.com/eddeglobalaz">Facebook</a>
        <a href="https://www.instagram.com/eddeglobal/">Instagram</a>
        <a href="https://www.linkedin.com/company/edde-global/">LinkedIn</a>
        <a href="https://www.youtube.com/@eddeglobal6894">YouTube</a>
      </div>
    </div>

    <div class="footer__col footer__col--links">
      <h4>Xaricdə təhsil</h4>
      <a href="#programs">Foundation Təhsili</a>
      <a href="#programs">Bakalavr</a>
      <a href="#programs">Magistratura</a>
      <a href="#programs">Doktorantura</a>
      <a href="#programs">Təqaüd Proqramları</a>
    </div>

    <div class="footer__col footer__col--links">
      <h4>EDDE Academy</h4>
      <a href="#academy">IELTS</a>
      <a href="#academy">TOEFL</a>
      <a href="#academy">PTE Academic</a>
      <a href="#academy">SAT</a>
      <a href="#academy">Alman Dili Kursları</a>
    </div>

    <div class="footer__col footer__col--links">
      <h4>Əlaqə</h4>
      <a href="tel:+994702141033">070 214 10 33</a>
      <a href="tel:+994124096789">012 409 67 89</a>
      <a href="mailto:info@eddeglobal.az">info@eddeglobal.az</a>
      <span>Əliyar Əliyev 159, N.Nərimanov, Bakı</span>
    </div>

  </div>

  <div class="container footer__bottom"> <span>© 2018–2026 EDDE Global.<br>Site by: Naila.</span>
   <div class="footer__bottom-right"> <div class="footer__icef"> <span id='iasBadge' data-account-id='5105'></span><script async defer crossorigin="anonymous" src="https://www-cdn.icef.com/scripts/iasbadgeid.js"></script></div> 
   <a href="<?php echo home_url('/mexfilik-siyaseti/'); ?>">Məxfilik siyasəti</a> </div> </div>
</footer>

<a href="<?php echo esc_url(edde_wa_url()); ?>" class="floating-btn whatsapp" aria-label="WhatsApp ilə yazın">💬</a>

<!-- ============ CONSULT MODAL ============ -->
<div class="modal-overlay" id="consultModal">
  <div class="modal">
    <button class="modal__close" id="closeConsult">✕</button>
    <h3>Zəngə yazılın</h3>
    <p>Nömrənizi buraxın, məsləhətçimiz Sizinlə əlaqə saxlasın.</p>
    <form id="consultForm">
      <input type="text" placeholder="Ad Soyad" required>
      <input type="tel" placeholder="+994 XX XXX XX XX" required>
      <select>
        <option>Maraqlandığınız proqram</option>
        <option>Bakalavr</option>
        <option>Magistratura</option>
        <option>Dil Kursu</option>
        <option>Təqaüd Proqramı</option>
      </select>
      <button type="submit" class="btn btn--primary btn--block">Göndər</button>
      <p class="modal__note">Formu göndərməklə razılıq verirsiniz ki, EDDE Global Sizinlə əlaqə saxlaya bilər.</p>
    </form>
  </div>
</div>

<!-- ============ HERO MODAL: XARİCDƏ TƏHSİL ============ -->
<div class="modal-overlay" id="modalTehsil">
  <div class="modal">
    <button class="modal__close" data-close-modal>✕</button>
    <h3>Xaricdə təhsil üçün müraciət et</h3>
    <p>Məlumatlarınızı qoyun – mütəxəssisimiz 24 saat ərzində sizinlə əlaqə saxlayacaq.</p>
    <form class="hero-form" data-source="hero-slayd-1-xaricde-tehsil">
      <input type="text" placeholder="Ad, Soyad" required>
      <input type="tel" placeholder="+994 (__) ___ __ __" required>
      <input type="email" placeholder="E-mail" required>
      <select required>
        <option value="">Maraqlandığınız proqram</option>
        <option>Foundation</option>
        <option>Bakalavr</option>
        <option>Magistr</option>
        <option>Doktorantura (PhD)</option>
        <option>Yay məktəbi</option>
        <option>Dil kursu</option>
        <option>Təqaüd proqramları</option>
        <option>Digər</option>
      </select>
      <label class="svc-form__check"><input type="checkbox" required><span>Şəxsi məlumatlarımın emalına razıyam</span></label>
      <button type="submit" class="btn btn--primary btn--block">Müraciəti göndər</button>
      <p class="hero-form__success">Müraciətiniz qəbul edildi. Tezliklə sizinlə əlaqə saxlayacağıq.</p>
    </form>
  </div>
</div>

<!-- ============ HERO MODAL: EDDE ACADEMY ============ -->
<div class="modal-overlay" id="modalAcademy">
  <div class="modal">
    <button class="modal__close" data-close-modal>✕</button>
    <h3>EDDE Academy kurslarına yazıl</h3>
    <form class="hero-form" data-source="hero-slayd-2-edde-academy">
      <input type="text" placeholder="Ad, Soyad" required>
      <input type="tel" placeholder="+994 (__) ___ __ __" required>
      <input type="email" placeholder="E-mail" required>
      <select required>
        <option value="">Maraqlandığınız proqram</option>
        <option>IELTS</option><option>TOEFL</option><option>Duolingo</option><option>PTE</option><option>SAT</option>
        <option>General English</option><option>Business English</option><option>Kids English (6–12 yaş)</option>
        <option>Türk dili</option><option>Alman dili</option><option>Danışıq klubu</option><option>Digər</option>
      </select>
      <select>
        <option value="">Hazırkı dil səviyyəniz (istəyə bağlı)</option>
        <option>Başlanğıc</option><option>Orta</option><option>Yuxarı</option><option>Bilmirəm</option>
      </select>
      <label class="svc-form__check"><input type="checkbox" required><span>Şəxsi məlumatlarımın emalına razıyam</span></label>
      <button type="submit" class="btn btn--primary btn--block">Müraciəti göndər</button>
      <p class="hero-form__success">Müraciətiniz qəbul edildi. Tezliklə sizinlə əlaqə saxlayacağıq.</p>
    </form>
  </div>
</div>

<!-- ============ HERO MODAL: CORPORATE ============ -->
<div class="modal-overlay" id="modalCorporate">
  <div class="modal">
    <button class="modal__close" data-close-modal>✕</button>
    <h3>Korporativ təklif üçün müraciət et</h3>
    <form class="hero-form" data-source="hero-slayd-4-edde-corporate">
      <input type="text" placeholder="Ad, Soyad (əlaqədar şəxs)" required>
      <input type="tel" placeholder="+994 (__) ___ __ __" required>
      <input type="email" placeholder="Korporativ e-mail" required>
      <input type="text" placeholder="Şirkətin adı" required>
      <select required>
        <option value="">Maraqlandığınız proqram</option>
        <option>Korporativ xarici dil kursları</option>
        <option>Korporativ təlimlər</option>
        <option>Biznes ingilis dili</option>
        <option>İmtahan hazırlığı (komanda üçün)</option>
        <option>Ehtiyac analizi və səviyyə testi</option>
        <option>Digər</option>
      </select>
      <select>
        <option value="">Təxmini iştirakçı sayı (istəyə bağlı)</option>
        <option>1–10</option><option>11–30</option><option>30+</option>
      </select>
      <label class="svc-form__check"><input type="checkbox" required><span>Şəxsi məlumatlarımın emalına razıyam</span></label>
      <button type="submit" class="btn btn--primary btn--block">Müraciəti göndər</button>
      <p class="hero-form__success">Müraciətiniz qəbul edildi. Tezliklə sizinlə əlaqə saxlayacağıq.</p>
    </form>
  </div>
</div>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-script.js"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>