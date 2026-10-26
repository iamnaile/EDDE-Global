<?php
/**
 * Template Name: EDDE Xidmətlər
 */
?>
<!DOCTYPE html>
<html lang="az" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Xidmətlər — EDDE Academy | EDDE Global</title>
<meta name="description" content="EDDE Academy-nin bütün xidmətləri: dil kursları (İngilis, Çin, Koreya, İspan, Rus, Alman, Ərəb, Türk) və beynəlxalq imtahan hazırlıqları (IELTS, Duolingo, TOEFL, PET / PTE, CSCA, SAT, GRE / GMAT).">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-styles.css">
</head>
<body <?php body_class('edde-page'); ?>>
<?php include get_stylesheet_directory() . '/parts/edde-preloader.php'; ?>
  <div class="page-bg" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/bg-xidmetler.webp');"></div>
<div class="page-bg-overlay"></div>
<div class="page-content">
<!-- ============ HEADER (vahid naviqasiya: inc/edde-nav.php) ============ -->
<?php $edde_current = 'edde-xidmetler'; include get_stylesheet_directory() . '/parts/edde-header.php'; ?>

<!-- ============ PAGE HERO ============ -->
<section class="svc-hero">
  <div class="container">
    <p class="eyebrow">EDDE Academy</p>
    <h1>Sizi qlobal uğura hazırlayırıq</h1>
    <p class="svc-hero__lead">EDDE Academy tələbələrə beynəlxalq dil imtahanlarında yüksək nəticə əldə etməyə və dünyanın aparıcı universitetlərinə qəbul olmağa kömək edir. Aşağıda bütün proqramlarımızla tanış ola bilərsiniz.</p>
  </div>
</section>

<!-- ============ DİL KURSLARI ============ -->
<section class="svc-section">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Dil kursları</p>
      <h2>Dil kursları</h2>
    </div>
    <div class="svc-grid">

      <div class="svc-card">
        <div class="svc-card__icon">🇬🇧</div>
        <h3>İngilis dili</h3>
        <p>Gündəlik və akademik istifadə üçün inamlı dil bacarığı.</p>
        <a href="<?php echo home_url('/general-english/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇨🇳</div>
        <h3>Çin dili</h3>
        <p>Qrup formatında Çin dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇰🇷</div>
        <h3>Koreya dili</h3>
        <p>Qrup formatında Koreya dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇪🇸</div>
        <h3>İspan dili</h3>
        <p>Qrup formatında İspan dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇷🇺</div>
        <h3>Rus dili</h3>
        <p>Qrup formatında Rus dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇩🇪</div>
        <h3>Alman dili</h3>
        <p>Qrup formatında Alman dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇸🇦</div>
        <h3>Ərəb dili</h3>
        <p>Qrup formatında Ərəb dili kursu.</p>
        <a href="<?php echo home_url('/dil-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇹🇷</div>
        <h3>Türk dili</h3>
        <p>Türkiyədə təhsil üçün lazım olan dil bacarıqları.</p>
        <a href="<?php echo home_url('/turk-dili-kurslari/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

    </div>
    <ul class="svc-bullets">
        <li>Hazırda dərslər qrup formatında, həftədə 3 dəfə əsas dərs olmaqla keçirilir.</li>
        <li>Həftəiçi 3 dəfə 1 saatlıq əsas dərslər olur. (Tələbənin istəyinə uyğun olaraq dərsləri həftədə 2 dəfə, 90 dəqiqə olmaqla təyin etmək mümkündür.)</li>
        <li>Qrup dərsləri üçün qiymət <strong>150 AZN</strong> təşkil edir. Qiymət kursa davam edilən bütün aylar üçün keçərlidir.</li>
        <li>Əsas dərslərdən əlavə olaraq, həftədə 3 dəfə dərslərdən sonra speaking və practice dərslərinə qatıla bilərsiniz.</li>
        <li>Həftəsonu (şənbə günü) qrup formatında conversation klubları keçirilir.</li>
        <li>Qrup dərslərində 3–4 tələbə iştirak edir. Conversation qruplarında isə maksimum 6–8 tələbə iştirak edir.</li>
    </ul>
  </div>
</section>

<!-- ============ BEYNƏLXALQ İMTAHAN HAZIRLIQLARI ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">İmtahana hazırlıq</p>
      <h2>Beynəlxalq imtahan hazırlıqları</h2>
    </div>
    <div class="svc-grid">

      <div class="svc-card">
        <div class="svc-card__icon">📖</div>
        <h3>IELTS</h3>
        <p>Band 7–8+ hədəfi üçün mütəxəssis rəhbərliyi altında hazırlıq.</p>
        <a href="<?php echo home_url('/ielts/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🦉</div>
        <h3>Duolingo</h3>
        <p>Sürətli, əlçatan beynəlxalq dil sertifikatına hazırlıq.</p>
        <a href="<?php echo home_url('/duolingo/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🌍</div>
        <h3>TOEFL</h3>
        <p>Akademik İngilis dili imtahanlarına effektiv hazırlıq.</p>
        <a href="<?php echo home_url('/toefl/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">💻</div>
        <h3>PET / PTE</h3>
        <p>Kompüter-əsaslı qiymətləndirmə formatına tam hazırlıq.</p>
        <a href="<?php echo home_url('/pte-academic/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🈶</div>
        <h3>CSCA</h3>
        <p>Qrup formatında CSCA imtahanına hazırlıq.</p>
        <a href="<?php echo home_url('/csca/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🎓</div>
        <h3>SAT</h3>
        <p>Math və Verbal bölmələri üzrə strukturlaşdırılmış təlim.</p>
        <a href="<?php echo home_url('/sat/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">📊</div>
        <h3>GRE / GMAT</h3>
        <p>Magistratura və MBA qəbulu üçün GRE / GMAT hazırlığı.</p>
        <a href="<?php echo home_url('/gmat/'); ?>" class="svc-card__link">Ətraflı məlumat →</a>
      </div>

    </div>
    <ul class="svc-bullets">
        <li>Proqram üzrə dərslər qrup formatında, həftədə 3 dəfə əsas dərs olmaqla keçirilir.</li>
        <li>Həftəiçi 3 dəfə 1 saatlıq əsas dərsiniz olur, daha sonra isə speaking və practice dərsləri keçilir.</li>
        <li>Dərslər həm əyani, həm də online formada keçirilir.</li>
        <li>Dərslər və metodika ilə tanışlıq üçün ilkin olaraq level check və sınaq dərsi təyin olunur.</li>
        <li>Proqrama B2 səviyyəsindən başlamanız tövsiyə olunur.</li>
    </ul>
    <p><a href="<?php echo home_url('/imtahana-hazirlik-kurslari/'); ?>" class="btn btn--primary">İmtahan hazırlıqları haqqında ətraflı</a></p>
  </div>
</section>

<!-- ============ DİGƏR PROQRAMLAR ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Digər proqramlar</p>
      <h2>Uşaqlar və sertifikat proqramları</h2>
    </div>
    <div class="svc-grid">

      <div class="svc-card">
        <div class="svc-card__icon">🧒</div>
        <h3>Kids English</h3>
        <p>Uşaqlar üçün əsas dil bacarıqlarını inkişaf etdirən interaktiv proqram.</p>
        <a href="<?php echo home_url('/kids-english/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">📜</div>
        <h3>LanguageCert</h3>
        <p>Beynəlxalq səviyyədə tanınan alternativ dil sertifikatına hazırlıq.</p>
        <a href="<?php echo home_url('/languagecert-kursu/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ WHY US STRIP ============ -->
<section class="svc-why">
  <div class="container svc-why__grid">
    <div class="svc-why__item"><strong data-count="400">0</strong><span>Partnyor universitet</span></div>
    <div class="svc-why__item"><strong data-count="15">0</strong><span>Sertifikatlı məsləhətçi</span></div>
    <div class="svc-why__item"><strong data-count="7">0</strong><span>İl təcrübə</span></div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<!-- ============ FOOTER (vahid: parts/edde-footer.php) ============ -->
<?php include get_stylesheet_directory() . '/parts/edde-footer.php'; ?>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-script.js"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>