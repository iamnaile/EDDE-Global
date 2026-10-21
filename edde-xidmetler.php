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
<meta name="description" content="EDDE Academy-nin bütün xidmətləri: IELTS, TOEFL, PTE, SAT, Duolingo, Alman və Türk dili kursları və digər imtahana hazırlıq proqramları.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-styles.css">
</head>
<body <?php body_class('edde-page'); ?>>
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

<!-- ============ MAIN SERVICES ============ -->
<section class="svc-section">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Əsas xidmətlərimiz</p>
      <h2>İmtahana hazırlıq proqramları</h2>
    </div>
    <div class="svc-grid">

      <div class="svc-card">
        <div class="svc-card__icon">📖</div>
        <h3>IELTS hazırlığı</h3>
        <p>Mütəxəssis rəhbərliyi altında hazırlıqla Band 7–8+ hədəfinə çatın.</p>
        <a href="<?php echo home_url('/ielts/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🌍</div>
        <h3>TOEFL hazırlığı</h3>
        <p>Akademik İngilis dili imtahanlarına effektiv şəkildə hazırlaşın.</p>
        <a href="<?php echo home_url('/toefl/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">💻</div>
        <h3>PTE Academic</h3>
        <p>Kompüter-əsaslı qiymətləndirmə formatına tam hazırlıq.</p>
        <a href="<?php echo home_url('/pte-academic/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🎓</div>
        <h3>SAT hazırlığı</h3>
        <p>Ən yüksək nəticələr üçün strukturlaşdırılmış Math və Verbal təlimi.</p>
        <a href="<?php echo home_url('/sat/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🦉</div>
        <h3>Duolingo English Test</h3>
        <p>Sürətli, uyğun qiymətli beynəlxalq dil sertifikatına hazırlıq.</p>
        <a href="<?php echo home_url('/duolingo/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🗣️</div>
        <h3>General English</h3>
        <p>İngilis dilini gündəlik və akademik istifadə üçün inamla öyrənin.</p>
        <a href="<?php echo home_url('/general-english/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

    </div>
  </div>
</section>

<!-- ============ KIDS ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Məktəblilər üçün</p>
      <h2>Uşaqlar üçün proqramlar</h2>
    </div>
    <div class="svc-grid">
      <div class="svc-card">
        <div class="svc-card__icon">🧒</div>
        <h3>Kids English</h3>
        <p>Uşaqlar üçün əsas dil bacarıqlarını inkişaf etdirən interaktiv proqram.</p>
        <a href="<?php echo home_url('/kids-english/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ LANGUAGE COURSES ============ -->
<section class="svc-section">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Dil kursları</p>
      <h2>Xaricdə təhsil üçün dil hazırlığı</h2>
    </div>
    <div class="svc-grid">

      <div class="svc-card">
        <div class="svc-card__icon">🇩🇪</div>
        <h3>Alman Dili Kursları</h3>
        <p>Almaniyada təhsil üçün başlanğıcdan irəliləmiş səviyyəyə qədər.</p>
        <a href="<?php echo home_url('/alman-dili-kurslari/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>

      <div class="svc-card">
        <div class="svc-card__icon">🇹🇷</div>
        <h3>Türk Dili Kursları</h3>
        <p>Türkiyədə təhsil üçün lazım olan dil bacarıqlarını qazanın.</p>
        <a href="<?php echo home_url('/turk-dili-kurslari/'); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
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