<?php
/**
 * Template Name: EDDE Academy — Ana səhifə (eddeacademy.az)
 *
 * eddeacademy.az açılanda ana səhifə üçün avtomatik göstərilir (functions.php).
 * Kurs siyahısı: inc/edde-site.php → edde_academy_courses(). Mətnləri aşağıda birbaşa dəyişə bilərsiniz.
 */

$theme_uri = get_stylesheet_directory_uri();
$wa_number = '994702141033';
$groups = ['exams' => [], 'lang' => [], 'kids' => []];
foreach (edde_academy_courses() as $c) { $groups[$c[4]][] = $c; }

$render_cards = function ($courses) {
  foreach ($courses as $c) : ?>
      <div class="svc-card">
        <div class="svc-card__icon"><?php echo esc_html($c[1]); ?></div>
        <h3><?php echo esc_html($c[2]); ?></h3>
        <p><?php echo esc_html($c[3]); ?></p>
        <a href="<?php echo esc_url(home_url('/' . $c[0] . '/')); ?>" class="svc-card__link">Proqramla yaxından tanış olun →</a>
      </div>
  <?php endforeach;
};

$title = 'EDDE Academy — IELTS, TOEFL, PTE, SAT və dil kursları | Bakı';
$desc  = 'EDDE Academy: IELTS, TOEFL, PTE Academic, SAT, Duolingo, Oxford ELLT hazırlığı, General English, Alman və Türk dili kursları. Rəsmi referal agent endirimləri və ödənişsiz sınaq imtahanları.';
?>
<!DOCTYPE html>
<html lang="az" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($title); ?></title>
<meta name="description" content="<?php echo esc_attr($desc); ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo esc_attr($title); ?>">
<meta property="og:description" content="<?php echo esc_attr($desc); ?>">
<meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
<?php edde_canonical_tag(''); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/assets/edde-styles.css">
<link rel="stylesheet" href="<?php echo esc_url($theme_uri); ?>/assets/edde-pages.css">
<script type="application/ld+json"><?php
  echo wp_json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'EducationalOrganization',
    'name'     => 'EDDE Academy',
    'url'      => home_url('/'),
    'parentOrganization' => ['@type' => 'Organization', 'name' => 'EDDE Global', 'url' => edde_global_url('/')],
    'telephone' => '+994702141033',
    'address'  => ['@type' => 'PostalAddress', 'streetAddress' => 'Əliyar Əliyev 159', 'addressLocality' => 'Bakı', 'addressCountry' => 'AZ'],
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?></script>
</head>
<body <?php body_class('edde-page edde-academy-home'); ?>>
  <div class="page-bg" style="background-image:url('<?php echo esc_url($theme_uri); ?>/assets/bg-xidmetler.webp');"></div>
<div class="page-bg-overlay"></div>
<div class="page-content">

<?php $edde_current = ''; include get_stylesheet_directory() . '/parts/edde-header.php'; ?>

<!-- ============ HERO ============ -->
<section class="svc-hero">
  <div class="container">
    <p class="eyebrow">EDDE Academy</p>
    <h1>Sizi qlobal uğura hazırlayırıq</h1>
    <p class="svc-hero__lead">EDDE Academy beynəlxalq dil imtahanlarında yüksək nəticə əldə etməyə və dünyanın aparıcı universitetlərinə qəbul olmağa kömək edir. IELTS, TOEFL, PTE, SAT, Duolingo və Oxford ELLT üzrə rəsmi referal agent kimi tələbələrimizə ödənişsiz sınaq imtahanları və xüsusi endirimlər təqdim edirik.</p>
    <div class="epage-hero__actions" style="margin-top:28px;">
      <a href="#kurslar" class="btn btn--primary">Kurslara baxın</a>
      <a href="#elaqe-forma" class="btn btn--outline">Pulsuz konsultasiya</a>
    </div>
  </div>
</section>

<!-- ============ İMTAHAN HAZIRLIĞI ============ -->
<section class="svc-section" id="kurslar">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Əsas xidmətlərimiz</p>
      <h2>İmtahana hazırlıq proqramları</h2>
    </div>
    <div class="svc-grid"><?php $render_cards($groups['exams']); ?></div>
  </div>
</section>

<!-- ============ DİL KURSLARI ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Dil kursları</p>
      <h2>Xaricdə təhsil üçün dil hazırlığı</h2>
    </div>
    <div class="svc-grid"><?php $render_cards($groups['lang']); ?></div>
  </div>
</section>

<!-- ============ UŞAQLAR ============ -->
<section class="svc-section">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Məktəblilər üçün</p>
      <h2>Uşaqlar üçün proqramlar</h2>
    </div>
    <div class="svc-grid"><?php $render_cards($groups['kids']); ?></div>
  </div>
</section>

<!-- ============ RƏQƏMLƏR ============ -->
<section class="svc-why">
  <div class="container svc-why__grid">
    <div class="svc-why__item"><strong data-count="400">0</strong><span>Partnyor universitet</span></div>
    <div class="svc-why__item"><strong data-count="15">0</strong><span>Sertifikatlı məsləhətçi</span></div>
    <div class="svc-why__item"><strong data-count="7">0</strong><span>İl təcrübə</span></div>
  </div>
</section>

<!-- ============ ÜSTÜNLÜKLƏR ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Niyə EDDE Academy?</p>
      <h2>Rəsmi tərəfdaşlıq, real üstünlüklər</h2>
    </div>
    <div class="svc-grid">
      <div class="svc-card">
        <div class="svc-card__icon">✅</div>
        <h3>Rəsmi referal agent</h3>
        <p>IELTS, TOEFL, PTE, Duolingo, Oxford ELLT və LanguageCert imtahanları üzrə qeydiyyatda xüsusi şərtlər.</p>
        <a href="<?php echo esc_url(home_url('/ustunlukler/')); ?>" class="svc-card__link">Üstünlüklərə baxın →</a>
      </div>
      <div class="svc-card">
        <div class="svc-card__icon">📝</div>
        <h3>Ödənişsiz sınaq imtahanları</h3>
        <p>Real imtahan formatında sınaqlarla hazırlığınızı yoxlayın və zəif tərəfləri vaxtında müəyyən edin.</p>
        <a href="<?php echo esc_url(home_url('/niye-biz/')); ?>" class="svc-card__link">Niyə biz? →</a>
      </div>
      <div class="svc-card">
        <div class="svc-card__icon">🌍</div>
        <h3>Xaricdə təhsil dəstəyi</h3>
        <p>EDDE Global ilə universitet qəbulu, viza və təqaüd prosesində tam dəstək — dil hazırlığından qəbula qədər bir ünvanda.</p>
        <a href="<?php echo esc_url(edde_global_url('/xaricde-tehsil/')); ?>" class="svc-card__link">EDDE Global-a keçin →</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ MÜRACİƏT FORMASI ============ -->
<section class="svc-form-section" id="elaqe-forma">
  <div class="container svc-form__inner">
    <div class="svc-form__text">
      <p class="epage-eyebrow">Əlaqə</p>
      <h2>Pulsuz konsultasiya</h2>
      <p>Məlumatlarınızı qeyd edin — məsləhətçimiz sizinlə əlaqə saxlayıb sizə uyğun kursu seçməkdə kömək edəcək.</p>
      <div class="svc-form__contact">
        <div>📞 <a href="tel:+994702141033">070 214 10 33</a></div>
        <div>📞 <a href="tel:+994124096789">012 409 67 89</a></div>
        <div>✉️ <a href="mailto:<?php echo esc_attr(edde_brand('email')); ?>"><?php echo esc_html(edde_brand('email')); ?></a></div>
        <div>📍 Əliyar Əliyev 159, N.Nərimanov, Bakı</div>
      </div>
    </div>
    <form class="svc-form epage-form" data-course="EDDE Academy kursları">
      <div class="svc-form__row">
        <input type="text" name="name" placeholder="Ad" required>
        <input type="text" name="surname" placeholder="Soyad" required>
      </div>
      <div class="svc-form__row">
        <input type="email" name="email" placeholder="E-poçt" required>
        <input type="tel" name="phone" placeholder="Telefon nömrəsi" required>
      </div>
      <textarea name="message" rows="3" placeholder="Hansı kurs və ya imtahan sizi maraqlandırır? (istəyə bağlı)"></textarea>
      <label class="svc-form__check">
        <input type="checkbox" required>
        <span><a href="<?php echo esc_url(home_url('/mexfilik-siyaseti/')); ?>">Məxfilik siyasəti</a> ilə razıyam və müraciətimlə bağlı mənimlə əlaqə saxlanılmasına icazə verirəm.</span>
      </label>
      <button type="submit" class="btn btn--primary btn--block">Müraciəti göndər</button>
    </form>
  </div>
</section>

<?php include get_stylesheet_directory() . '/parts/edde-footer.php'; ?>

<script src="<?php echo esc_url($theme_uri); ?>/assets/edde-script.js"></script>
<script src="<?php echo esc_url($theme_uri); ?>/assets/edde-pages.js"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>
