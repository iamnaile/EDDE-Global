<?php
/**
 * Sayt rejimi: eyni tema iki domen üçün işləyir.
 *
 *   eddeglobal.az   → "global" rejimi (xaricdə təhsil + Academy + korporativ və s.)
 *   eddeacademy.az  → "academy" rejimi (yalnız EDDE Academy: kurslar, imtahan hazırlığı)
 *
 * Rejim sorğunun host-undan avtomatik təyin olunur. wp-config.php-də məcburi seçmək olar:
 *     define('EDDE_SITE_MODE', 'academy');   // və ya 'global'
 * (domen hələ DNS-də qoşulmayıb, sayt müvəqqəti ünvanda yoxlanılanda faydalıdır.)
 */

if (!defined('EDDE_ACADEMY_HOST')) { define('EDDE_ACADEMY_HOST', 'eddeacademy.az'); }
if (!defined('EDDE_GLOBAL_URL'))   { define('EDDE_GLOBAL_URL',   'https://eddeglobal.az'); }

if (!function_exists('edde_request_host')) {
  /** Kiçik hərflərlə, "www." və port olmadan. */
  function edde_request_host() {
    $h = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
    $h = preg_replace('~:\d+$~', '', $h);
    return preg_replace('~^www\.~', '', $h);
  }
}

if (!function_exists('edde_is_academy_site')) {
  function edde_is_academy_site() {
    static $is = null;
    if ($is === null) {
      if (defined('EDDE_SITE_MODE')) {
        $is = (EDDE_SITE_MODE === 'academy');
      } else {
        $is = (edde_request_host() === EDDE_ACADEMY_HOST);
      }
      $is = (bool) apply_filters('edde_is_academy_site', $is);
    }
    return $is;
  }
}

/* Eyni WordPress qurğusu iki domenə cavab verəndə, Academy domenində linklər də həmin domenə getsin.
   (Ayrıca WordPress quraşdırılıbsa, parametrlər onsuz da düzgündür — bu blok heç nəyi dəyişmir.) */
if (!defined('EDDE_SITE_MODE') && edde_request_host() === EDDE_ACADEMY_HOST) {
  $edde_academy_url = function () {
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    return ($https ? 'https://' : 'http://') . (isset($_SERVER['HTTP_HOST']) ? preg_replace('~[^a-z0-9.:-]~i', '', $_SERVER['HTTP_HOST']) : EDDE_ACADEMY_HOST);
  };
  add_filter('pre_option_home',    $edde_academy_url);
  add_filter('pre_option_siteurl', $edde_academy_url);
}

/* ------------------------------------------------------------------------------------------
   Academy kursları — Academy menyusu, ana səhifə və altlıq buradan oxuyur.
   [slug, ikon, başlıq, qısa təsvir, bölmə]
   ------------------------------------------------------------------------------------------ */
if (!function_exists('edde_academy_courses')) {
  function edde_academy_courses() {
    return [
      ['ielts',              '📖', 'IELTS',                 'Mütəxəssis rəhbərliyi altında hazırlıqla Band 7–8+ hədəfinə çatın.',          'exams'],
      ['toefl',              '🌍', 'TOEFL',                 'Akademik İngilis dili imtahanlarına effektiv şəkildə hazırlaşın.',            'exams'],
      ['pte-academic',       '💻', 'PTE Academic',          'Kompüter-əsaslı qiymətləndirmə formatına tam hazırlıq.',                      'exams'],
      ['sat',                '🎓', 'SAT',                   'Ən yüksək nəticələr üçün strukturlaşdırılmış Math və Verbal təlimi.',         'exams'],
      ['duolingo',           '🦉', 'Duolingo English Test', 'Sürətli, uyğun qiymətli beynəlxalq dil sertifikatına hazırlıq.',               'exams'],
      ['ellt-kursu',         '🏛️', 'Oxford ELLT',           'Oxford International Digital Institute imtahanına peşəkar hazırlıq.',         'exams'],
      ['languagecert-kursu', '📜', 'LanguageCert',          'Beynəlxalq səviyyədə tanınan alternativ dil sertifikatına hazırlıq.',         'exams'],
      ['general-english',    '🗣️', 'General English',       'İngilis dilini gündəlik və akademik istifadə üçün inamla öyrənin.',           'lang'],
      ['alman-dili-kurslari','🇩🇪', 'Alman Dili',           'Almaniyada təhsil üçün başlanğıcdan irəliləmiş səviyyəyə qədər.',             'lang'],
      ['turk-dili-kurslari', '🇹🇷', 'Türk Dili',            'Türkiyədə təhsil üçün lazım olan dil bacarıqlarını qazanın.',                 'lang'],
      ['kids-english',       '🧒', 'Kids English',          '6–12 yaş uşaqlar üçün əsas dil bacarıqlarını inkişaf etdirən interaktiv proqram.', 'kids'],
    ];
  }
}

if (!function_exists('edde_academy_routes')) {
  /** Academy saytında açıq olan marşrutlar. Qalan hər şey eddeglobal.az-a yönləndirilir. */
  function edde_academy_routes() {
    $routes = ['ustunlukler', 'niye-biz', 'faq', 'elaqe', 'mexfilik-siyaseti'];
    foreach (edde_academy_courses() as $c) { $routes[] = $c[0]; }
    return $routes;
  }
}

if (!function_exists('edde_brand')) {
  /** Saytın adı, e-poçtu, bağlantıları — rejimə görə. */
  function edde_brand($key = null) {
    $academy = edde_is_academy_site();
    $b = [
      'name'      => $academy ? 'EDDE Academy' : 'EDDE Global',
      'suffix'    => $academy ? 'EDDE Academy' : 'EDDE Global',
      'home_path' => $academy ? '/' : '/edde-home/',
      // Academy üçün ayrıca poçt yaradılanda burada və ya 'edde_brand_email' filtri ilə dəyişin.
      'email'     => apply_filters('edde_brand_email', 'info@eddeglobal.az'),
      'footer_tagline' => $academy
        ? 'EDDE Global-ın təhsil mərkəzi: beynəlxalq imtahanlara hazırlıq və dil kursları. IELTS, TOEFL, PTE, SAT, Duolingo və Oxford ELLT üzrə rəsmi referal agent.'
        : '2018-ci ildən bəri tələbələrin xaricdə təhsil arzularını gerçəkləşdirməsinə kömək edən etibarlı təhsil şirkəti.',
    ];
    return $key === null ? $b : (isset($b[$key]) ? $b[$key] : '');
  }
}

if (!function_exists('edde_global_url')) {
  function edde_global_url($path = '/') {
    return rtrim(EDDE_GLOBAL_URL, '/') . '/' . ltrim($path, '/');
  }
}

if (!function_exists('edde_canonical_tag')) {
  /** Academy saytında cari səhifənin kanonik ünvanını yazır (iki domen arasında təkrar məzmunun qarşısı). */
  function edde_canonical_tag($route = '') {
    if (!edde_is_academy_site()) { return; }
    $path = $route === '' ? '/' : '/' . trim($route, '/') . '/';
    echo '<link rel="canonical" href="' . esc_url(home_url($path)) . '">' . "\n";
  }
}
