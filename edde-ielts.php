<?php
/**
 * Template Name: EDDE Xidmət - IELTS
 *
 * QEYD: Bu şablonu başqa kurslar üçün (TOEFL, PTE, SAT və s.) təkrar istifadə etmək üçün:
 * 1. Bu faylı köçürüb yeni adla saxlayın (məs. edde-toefl.php)
 * 2. Yalnız aşağıdakı "MƏZMUN BLOKU" hissəsindəki mətnləri dəyişin
 * 3. Faylın başındakı "Template Name" şərhini də dəyişin (məs. EDDE Xidmət - TOEFL)
 */

/* ================= MƏZMUN BLOKU (kursu dəyişəndə YALNIZ bunu redaktə edin) ================= */
$svc_title        = "IELTS";
$svc_headline     = "Peşəkar dəstək ilə IELTS-dən yüksək nəticə əldə edin";
$svc_subheadline  = "Çevik tədris formatları. Təcrübəli müəllimlər. Real nəticələr.";
$svc_stat1_num    = "2018";  $svc_stat1_label = "İl bəri IELTS hazırlığı keçiririk";
$svc_stat2_num    = "7+";    $svc_stat2_label = "Ortalama Band hədəfi";
$svc_stat3_num    = "500";   $svc_stat3_label = "Uğurlu məzun";
$svc_includes = [
  ["title" => "Dörd bacarıq üzrə tam hazırlıq", "text" => "Listening, Reading, Writing və Speaking bölmələri üzrə effektiv, məqsədyönlü dərslər."],
  ["title" => "Fərdi təhsil planı", "text" => "Mövcud səviyyəniz, hazırlıq müddətiniz və hədəf balınız nəzərə alınaraq tam fərdiləşdirilmiş plan qurulur."],
  ["title" => "Davamlı praktika və sınaq imtahanları", "text" => "Müntəzəm sınaq imtahanları ilə zəif tərəflər müəyyən edilir, ətraflı geribildirim verilir."],
  ["title" => "Çevik format", "text" => "Əyani, onlayn, fərdi və ya kiçik qrup formatında dərslər — sizin qrafikinizə uyğun."],
];
$svc_stages = [
  ["title" => "Qeydiyyat və səviyyə qiymətləndirilməsi", "text" => "İlk mərhələdə ingilis dili səviyyəniz qiymətləndirilir və hədəf balınıza uyğun fərdi hazırlıq planı hazırlanır."],
  ["title" => "Dərslər və intensiv praktika", "text" => "Mövzular sistemli şəkildə öyrədilir, davamlı praktika və sınaq imtahanları ilə biliklər möhkəmləndirilir."],
  ["title" => "İmtahana hazırlıq və son dəstək", "text" => "Son mərhələdə imtahan strategiyaları, vaxtın idarə olunması və imtahan günü üçün vacib tövsiyələr təqdim olunur."],
];
/* ================= MƏZMUN BLOKU SONU ================= */
?>
<!DOCTYPE html>
<html lang="az" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($svc_title); ?> hazırlığı — EDDE Academy | EDDE Global</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-styles.css">
</head>
<body <?php body_class('edde-page'); ?>>
  <div class="page-bg" style="background-image:url('<?php echo get_stylesheet_directory_uri(); ?>/assets/bg-ielts.jpg');"></div>
<div class="page-bg-overlay"></div>
<div class="page-content">
<!-- ============ HEADER (vahid naviqasiya: inc/edde-nav.php) ============ -->
<?php $edde_current = 'ielts'; include get_stylesheet_directory() . '/parts/edde-header.php'; ?>

<!-- ============ BREADCRUMB ============ -->
<div class="svc-breadcrumb">
  <div class="container">
    <a href="<?php echo home_url('/edde-home/'); ?>">Ana səhifə</a> /
    <a href="<?php echo home_url('/edde-xidmetler/'); ?>">Xidmətlər</a> /
    <span><?php echo esc_html($svc_title); ?></span>
  </div>
</div>

<!-- ============ SERVICE HERO ============ -->
<section class="svc-detail-hero">
  <div class="container svc-detail-hero__inner">
    <h1><?php echo esc_html($svc_headline); ?></h1>
    <p><?php echo esc_html($svc_subheadline); ?></p>
    <a href="#svc-form" class="btn btn--primary">Pulsuz konsultasiya üçün müraciət edin</a>
  </div>
</section>

<!-- ============ STATS ============ -->
<section class="svc-stats">
  <div class="container svc-stats__grid">
    <div class="svc-stats__item"><strong><?php echo esc_html($svc_stat1_num); ?></strong><span><?php echo esc_html($svc_stat1_label); ?></span></div>
    <div class="svc-stats__item"><strong><?php echo esc_html($svc_stat2_num); ?></strong><span><?php echo esc_html($svc_stat2_label); ?></span></div>
    <div class="svc-stats__item"><strong><?php echo esc_html($svc_stat3_num); ?></strong><span><?php echo esc_html($svc_stat3_label); ?></span></div>
  </div>
</section>

<!-- ============ PROGRAM INCLUDES ============ -->
<section class="svc-section">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Proqram</p>
      <h2><?php echo esc_html($svc_title); ?> hazırlıq proqramımız</h2>
    </div>
    <div class="svc-includes">
      <?php foreach ($svc_includes as $item): ?>
      <div class="svc-includes__card">
        <h3><?php echo esc_html($item['title']); ?></h3>
        <p><?php echo esc_html($item['text']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ STAGES ============ -->
<section class="svc-section svc-section--alt">
  <div class="container">
    <div class="section-head" style="text-align:left; margin:0 0 40px; max-width:none;">
      <p class="eyebrow">Necə işləyir</p>
      <h2>Hazırlıq mərhələləri</h2>
    </div>
    <div class="svc-stages">
      <?php foreach ($svc_stages as $i => $stage): ?>
      <div class="svc-stages__item">
        <div class="svc-stages__num"><?php echo $i + 1; ?></div>
        <div>
          <h3><?php echo esc_html($stage['title']); ?></h3>
          <p><?php echo esc_html($stage['text']); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ CONSULT FORM (SƏHİFƏNİN ALTINDA) ============ -->
<section class="svc-form-section" id="svc-form">
  <div class="container svc-form__inner">
    <div class="svc-form__text">
      <p class="eyebrow">Qeydiyyat</p>
      <h2>Fərdi <?php echo esc_html($svc_title); ?> təlimatı alın</h2>
      <p>Məqsədləriniz barədə bizə məlumat verin, mütəxəssislərimiz sizə düzgün hazırlıq planını seçməyə kömək etsin.</p>
      <div class="svc-form__contact">
        <div>📞 <a href="tel:+994702141033">070 214 10 33</a></div>
        <div>✉️ <a href="mailto:info@eddeglobal.az">info@eddeglobal.az</a></div>
      </div>
    </div>
    <form class="svc-form" id="svcForm" data-course="<?php echo esc_attr($svc_title); ?>">
      <div class="svc-form__row">
        <input type="text" placeholder="Ad" required>
        <input type="text" placeholder="Soyad" required>
      </div>
      <div class="svc-form__row">
        <input type="email" placeholder="E-poçt" required>
        <input type="tel" placeholder="Telefon nömrəsi" required>
      </div>
      <textarea rows="3" placeholder="Hədəfləriniz (istəyə bağlı)"></textarea>
      <label class="svc-form__check">
        <input type="checkbox" required>
        <span>Məxfilik siyasəti ilə razıyam və müraciətimlə bağlı mənimlə əlaqə saxlanılmasına icazə verirəm.</span>
      </label>
      <button type="submit" class="btn btn--primary btn--block"><?php echo esc_html($svc_title); ?> üzrə məsləhət al</button>
    </form>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="site-footer" id="contact">
  <div class="container footer__grid">
    <div class="footer__col footer__col--brand">
      <a href="<?php echo home_url('/edde-home/'); ?>" class="logo logo--light"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>
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
      <a href="<?php echo home_url('/edde-home/'); ?>#programs">Foundation Təhsili</a>
      <a href="<?php echo home_url('/edde-home/'); ?>#programs">Bakalavr</a>
      <a href="<?php echo home_url('/edde-home/'); ?>#programs">Magistratura</a>
      <a href="<?php echo home_url('/edde-home/'); ?>#programs">Doktorantura</a>
    </div>
    <div class="footer__col footer__col--links">
      <h4>EDDE Academy</h4>
      <a href="<?php echo home_url('/ielts/'); ?>">IELTS</a>
      <a href="<?php echo home_url('/toefl/'); ?>">TOEFL</a>
      <a href="<?php echo home_url('/pte-academic/'); ?>">PTE Academic</a>
      <a href="<?php echo home_url('/sat/'); ?>">SAT</a>
    </div>
    <div class="footer__col footer__col--links">
      <h4>Əlaqə</h4>
      <a href="tel:+994702141033">070 214 10 33</a>
      <a href="tel:+994124096789">012 409 67 89</a>
      <a href="mailto:info@eddeglobal.az">info@eddeglobal.az</a>
      <span>Əliyar Əliyev 159, N.Nərimanov, Bakı</span>
    </div>
  </div>
  <div class="container footer__bottom">
    <span>© 2018–2026 EDDE Global.<br>Site by: Naila.</span>
    <a href="<?php echo home_url('/mexfilik-siyaseti/'); ?>">Məxfilik siyasəti</a>
  </div>
</footer>

<a href="https://wa.me/994702141033" class="floating-btn whatsapp" aria-label="WhatsApp ilə yazın">💬</a>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/edde-script.js"></script>
<script>
document.getElementById('svcForm').addEventListener('submit', function(e){
  e.preventDefault();
  var course = this.dataset.course;
  var inputs = this.querySelectorAll('input[type=text], input[type=tel]');
  var name = inputs[0] ? inputs[0].value.trim() : '';
  var phone = inputs[2] ? inputs[2].value.trim() : '';
  var text = encodeURIComponent('Salam, mənim adım ' + name + '. ' + course + ' proqramı ilə maraqlanıram. Əlaqə nömrəm: ' + phone);
  window.open('https://wa.me/994702141033?text=' + text, '_blank');
});
</script>
<?php wp_footer(); ?>
</div>
</body>
</html>