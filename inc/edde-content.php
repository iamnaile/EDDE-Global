<?php
/**
 * EDDE məzmun səhifələri: məlumat yükləmə, marşrut tapma və köməkçi funksiyalar.
 *
 * Məzmun inc/data/ qovluğundakı fayllardadır:
 *   pages.php      — hər səhifənin mətni (slug => məlumat)
 *   articles.php   — məqalələr və "Mediada biz" xəbərləri
 *   faq.php        — tez-tez verilən suallar
 *   countries.php  — ölkələr və universitetlər
 */

require_once __DIR__ . '/edde-lang.php';
require_once __DIR__ . '/edde-nav.php';

if (!function_exists('edde_data')) {
  /** inc/data/<ad>.php faylını bir dəfə oxuyub yadda saxlayır. */
  function edde_data($name) {
    static $cache = [];
    $lang = edde_lang();
    $key  = $lang . ':' . $name;
    if (!isset($cache[$key])) {
      $file = __DIR__ . '/data/' . ($lang === 'en' ? 'en/' : '') . $name . '.php';
      if (!is_readable($file)) { $file = __DIR__ . '/data/' . $name . '.php'; } // İngiliscə fayl yoxdursa Azərbaycanca
      $cache[$key] = is_readable($file) ? include $file : [];
    }
    return $cache[$key];
  }
}

if (!function_exists('edde_news_fallback_image')) {
  /**
   * Üz qabığı şəkli olmayan yazılar üçün avtomatik şəkil. assets/news/ qovluğuna atılan şəkillərdən (jpg/png/webp),
   * qovluq boşdursa saytın hero şəkillərindən seçilir. Seçim yazının slug-ına görə sabitdir (hər dəfə eyni şəkil).
   */
  function edde_news_fallback_image($slug) {
    static $pool = null;
    if ($pool === null) {
      $dir = get_stylesheet_directory() . '/assets/news/';
      $uri = get_stylesheet_directory_uri() . '/assets/news/';
      $pool = [];
      foreach ((array) glob($dir . '*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE) as $f) { $pool[] = $uri . rawurlencode(basename($f)); }
      if (!$pool) {
        $base = get_stylesheet_directory() . '/assets/';
        foreach (['hero-xaricde-tehsil.jpg', 'hero-edde-academy.jpg', 'hero-edde-corporate.jpg'] as $f) {
          if (is_readable($base . $f)) { $pool[] = get_stylesheet_directory_uri() . '/assets/' . $f; }
        }
      }
      sort($pool);
    }
    return $pool ? $pool[abs(crc32($slug)) % count($pool)] : '';
  }
}

if (!function_exists('edde_news_all')) {
  /**
   * Bütün yazılar (yeni → köhnə): inc/data/articles.php-dəki hazır yazılar + WordPress admin-də "Məqalələr (EDDE)" bölməsindən
   * (məs. Word-dən import olunanlar) gələnlər. Hər yazı: slug, title, date (d.m.Y), ts, type (meqale|media), blocks, image, excerpt, source, words.
   * Admin-dəki yazılar öz dilinə uyğun saytda görünür (AZ yazılar AZ-də, İngilis yazılar /en/-də); hazır yazılar isə inc/data/(en/)articles.php-dən.
   */
  function edde_news_all() {
    static $cache = [];
    $lang = edde_lang();
    if (isset($cache[$lang])) { return $cache[$lang]; }
    $out = [];
    foreach (edde_data('articles') as $slug => $a) {
      $dt = DateTime::createFromFormat('d.m.Y', $a['date']);
      $a['slug']    = $slug;
      $a['ts']      = $dt ? $dt->getTimestamp() : 0;
      $a['image']   = isset($a['image']) ? $a['image'] : '';
      $a['excerpt'] = edde_excerpt($a['blocks'], 200);
      $words = 0; foreach ($a['blocks'] as $b) { if (is_string($b[1] ?? null)) { $words += str_word_count(strip_tags($b[1]), 0, 'əıöüçşğƏİÖÜÇŞĞ'); } }
      $a['words']   = $words;
      $out[$slug] = $a;
    }
    if (function_exists('get_posts')) {
      foreach (get_posts(['post_type' => 'edde_news', 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC']) as $p) {
        $plang = get_post_meta($p->ID, '_edde_lang', true) === 'en' ? 'en' : 'az';
        $type  = get_post_meta($p->ID, '_edde_type', true) === 'media' ? 'media' : 'meqale';
        $img   = get_the_post_thumbnail_url($p->ID, 'large');
        $title = get_the_title($p);
        $html  = $p->post_content;
        $exc   = $p->post_excerpt;
        if ($lang === 'en' && $plang === 'az') {
          // Azərbaycan məqaləsinin bağlanmış İngilis tərcüməsi (doldurulmayıbsa EN saytda göstərilmir)
          $enT = (string) get_post_meta($p->ID, '_edde_en_title', true);
          $enC = (string) get_post_meta($p->ID, '_edde_en_content', true);
          if ($enT === '' || trim(strip_tags($enC)) === '') { continue; }
          $title = $enT; $html = $enC; $exc = (string) get_post_meta($p->ID, '_edde_en_excerpt', true);
        } elseif ($plang !== $lang) {
          continue; // yalnız öz dilindəki saytda görünür
        }
        $slug = $p->post_name ?: 'yazi-' . $p->ID;
        $out[$slug] = [
          'slug' => $slug, 'title' => $title, 'date' => mysql2date('d.m.Y', $p->post_date), 'ts' => strtotime($p->post_date),
          'type' => $type, 'blocks' => [['html', $html]], 'image' => $img ? $img : '',
          'excerpt' => $exc !== '' ? $exc : wp_trim_words(wp_strip_all_tags($html), 32, '…'),
          'source' => (string) get_post_meta($p->ID, '_edde_source', true),
          'words' => str_word_count(strip_tags($html), 0, 'əıöüçşğƏİÖÜÇŞĞ'),
        ];
      }
    }
    foreach ($out as $slug => &$it) {
      if ($it['image'] === '') { $it['image'] = edde_news_fallback_image($slug); $it['cover_fallback'] = true; }
    }
    unset($it);
    uasort($out, function ($x, $y) { return $y['ts'] <=> $x['ts']; });
    return $cache[$lang] = $out;
  }
}

if (!function_exists('edde_articles_by_type')) {
  /** type = 'meqale' | 'media'. Yeni → köhnə sıralanır. */
  function edde_articles_by_type($type) {
    return array_filter(edde_news_all(), function ($a) use ($type) { return $a['type'] === $type; });
  }
}

if (!function_exists('edde_article_base')) {
  function edde_article_base($type) {
    return $type === 'media' ? 'mediada-biz' : 'meqaleler';
  }
}

if (!function_exists('edde_route_page')) {
  /**
   * Marşrutu ("ielts" və ya "meqaleler/slug") səhifə məlumatına çevirir; tapılmasa null.
   */
  function edde_route_page($route) {
    $route = trim((string) $route, '/');
    if ($route === '') { return null; }
    $pages = edde_data('pages');
    if (isset($pages[$route])) {
      $p = $pages[$route];
      $p['route'] = $route;
      $p['kind']  = 'page';
      return $p;
    }
    if (strpos($route, '/') !== false) {
      list($base, $slug) = array_pad(explode('/', $route, 2), 2, '');
      $articles = edde_news_all();
      if (isset($articles[$slug])) {
        $a = $articles[$slug];
        if (edde_article_base($a['type']) === $base) {
          return [
            'route' => $route, 'kind' => 'article', 'article' => $a + ['slug' => $slug],
            'title' => $a['title'], 'group' => 'Yazılar', 'icon' => '📰',
            'meta'  => $a['excerpt'] !== '' ? mb_substr($a['excerpt'], 0, 160) : edde_excerpt($a['blocks'], 160),
            'lead'  => '', 'blocks' => $a['blocks'],
            'cta'   => 'Suallarınız var?', 'cta_course' => $a['type'] === 'media' ? 'Mediada biz' : 'Məqalə',
          ];
        }
      }
    }
    return null;
  }
}

if (!function_exists('edde_excerpt')) {
  /** Blokların ilk abzasından qısa xülasə. */
  function edde_excerpt($blocks, $len = 170) {
    foreach ($blocks as $b) {
      if ($b[0] === 'p' && mb_strlen($b[1]) > 40) {
        $t = $b[1];
        return mb_strlen($t) > $len ? rtrim(mb_substr($t, 0, $len - 1), " ,.;:") . '…' : $t;
      }
    }
    return '';
  }
}

if (!function_exists('edde_request_route')) {
  /** Cari sorğunun saytın kökünə nisbətən yolu (kiçik hərflərlə, / olmadan). */
  function edde_request_route() {
    $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = (string) parse_url($uri, PHP_URL_PATH);
    $base = edde_home_base();
    if ($base !== '' && strpos($path, $base) === 0) {
      $path = substr($path, strlen($base));
    }
    $route = strtolower(trim(rawurldecode($path), '/'));
    if ($route === 'en' || strpos($route, 'en/') === 0) { $route = trim(substr($route, 2), '/'); } // /en/ prefiksi
    return $route;
  }
}

if (!function_exists('edde_current_route')) {
  /** Hazırkı səhifənin marşrutu: marşrutlaşdırıcı təyin edibsə o, yoxsa WordPress səhifəsinin slug-ı. */
  function edde_current_route() {
    if (!empty($GLOBALS['edde_route'])) { return $GLOBALS['edde_route']; }
    $id = function_exists('get_queried_object_id') ? get_queried_object_id() : 0;
    return $id ? (string) get_post_field('post_name', $id) : '';
  }
}

if (!function_exists('edde_partner_name')) {
  /** assets/logos/ faylının adına görə təşkilatın adı (alt mətn və başlıq üçün). */
  function edde_partner_name($file) {
    static $names = [
      'pier'     => 'PIER — Professional International Education Resources',
      'yedab'    => 'YEDAB — Association of Study Abroad Counselors (Yurtdışı Eğitim Danışmanları Derneği)',
      'net'      => 'NET',
      'alpha'    => 'Alpha Omega',
      'asac'     => 'ASAC — Association of Study Abroad Companies',
      'icef'     => 'ICEF Academy',
      'sttravel' => 'StudyTravel (ST)',
      'link'     => 'Università degli Studi LINK',
      'marsol'   => 'Marsol Group',
      'akiab'    => 'AKİAB',
      'caspian'  => 'Caspian Energy Group',
      '166'      => '166 Yükdaşıma və Logistika',
    ];
    $stem = pathinfo($file, PATHINFO_FILENAME);
    $key  = strtolower(preg_replace('~^\d+-~', '', $stem));
    return isset($names[$key]) ? $names[$key] : ucwords(str_replace(['-', '_'], ' ', $key));
  }
}

if (!function_exists('edde_partner_logos')) {
  /** assets/logos/ qovluğundakı bütün PNG/JPG/WEBP/SVG loqolar: [fayl, url, ad]. Yeni loqonu qovluğa atmaq kifayətdir. */
  function edde_partner_logos() {
    $dir   = get_stylesheet_directory() . '/assets/logos/';
    $url   = get_stylesheet_directory_uri() . '/assets/logos/';
    $files = glob($dir . '*.{png,jpg,jpeg,webp,svg,PNG,JPG,JPEG,WEBP,SVG}', GLOB_BRACE);
    $files = $files ? array_map('basename', $files) : [];
    sort($files, SORT_NATURAL | SORT_FLAG_CASE);
    $out = [];
    foreach ($files as $f) {
      $out[] = ['file' => $f, 'url' => $url . rawurlencode($f), 'name' => edde_partner_name($f)];
    }
    return $out;
  }
}

if (!function_exists('edde_aside_links')) {
  /** Yan panel üçün eyni bölmədəki səhifələr: [başlıq, url, aktivdir]. */
  function edde_aside_links($route) {
    $root = $route;
    if (strpos($route, '/') !== false) { $root = explode('/', $route, 2)[0]; }
    foreach (edde_nav_items() as $item) {
      if (empty($item['mega'])) { continue; }
      $hit = trim($item['url'], '/') === $root;
      foreach ($item['mega']['links'] as $l) {
        if (trim($l[1], '/') === $root) { $hit = true; }
      }
      if ($hit) {
        $rows = [];
        foreach ($item['mega']['links'] as $l) {
          if (!preg_match('~^(#|tel:|mailto:|https?://)~', $l[1])) {
            $rows[] = [$l[0], $l[1], trim($l[1], '/') === $root];
          }
        }
        return [$item['mega']['heading'], $rows];
      }
    }
    return ['Faydalı keçidlər', [
      ['Xaricdə təhsil', '/xaricde-tehsil/', false],
      ['EDDE Academy', '/edde-home/edde-xidmetler/', false],
      ['Ölkələr və universitetlər', '/olkeler/', false],
      ['Məqalələr', '/meqaleler/', false],
      ['FAQ', '/faq/', false],
      ['Əlaqə', '/elaqe/', false],
    ]];
  }
}
