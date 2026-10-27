<?php
/* === EDDE SEO === */
/**
 * Axtarış sistemləri (Google) üçün: canonical, robots, Open Graph, JSON-LD (Article / BreadcrumbList / Organization),
 * hreflang (AZ/EN) və sitemap (/edde-sitemap.xml). Yazılar və bütün məzmun səhifələri indekslənməyə açıqdır.
 *
 * DİQQƏT: bu fayl functions.php-dən AYRIDIR ki, functions.php dəyişəndə/üstünə yazılanda SEO silinməsin.
 * Faylı silməyin və ya köhnə nüsxə ilə əvəz etməyin. functions.php-də yalnız bir qoşulma sətri var.
 */

if (!function_exists('edde_seo_current')) {
  /** Cari səhifənin SEO məlumatı: [title, desc, url, type, image, article|null, crumbs] — saytın öz səhifələri üçün, yoxsa null. */
  function edde_seo_current() {
    if (is_admin() || !function_exists('edde_route_page')) { return null; }
    $root = rtrim(get_option('home'), '/');
    $lang = edde_lang();
    $q    = $lang === 'en' ? '?lang=en' : '';
    if (is_front_page() && !isset($GLOBALS['edde_route'])) {
      return ['title' => get_bloginfo('name'), 'desc' => get_bloginfo('description'), 'url' => $root . '/' . $q, 'type' => 'website',
              'image' => get_stylesheet_directory_uri() . '/assets/hero-xaricde-tehsil.jpg', 'article' => null, 'crumbs' => [], 'path' => ''];
    }
    $route = isset($GLOBALS['edde_route']) ? trim((string) $GLOBALS['edde_route'], '/') : '';
    if ($route === '') { return null; }
    $pg = edde_route_page($route);
    if (!$pg) { return null; }
    $article = $pg['kind'] === 'article' ? $pg['article'] : null;
    $img = $article && !empty($article['image']) ? $article['image'] : get_stylesheet_directory_uri() . '/assets/hero-xaricde-tehsil.jpg';
    $crumbs = [['EDDE Global', $root . '/' . $q]];
    if (!empty($pg['group']) && $pg['group'] !== $pg['title']) { $crumbs[] = [$pg['group'], '']; }
    $crumbs[] = [$pg['title'], $root . '/' . $route . '/' . $q];
    return ['title' => $pg['title'], 'desc' => isset($pg['meta']) ? $pg['meta'] : '', 'url' => $root . '/' . $route . '/' . $q,
            'type' => $article ? 'article' : 'website', 'image' => $img, 'article' => $article, 'crumbs' => $crumbs, 'path' => $route . '/'];
  }
}

add_filter('wp_robots', function ($robots) {
  if (function_exists('edde_seo_current') && edde_seo_current()) {
    unset($robots['noindex'], $robots['nofollow']);
    $robots['index'] = true; $robots['follow'] = true; $robots['max-snippet'] = '-1'; $robots['max-image-preview'] = 'large';
  }
  return $robots;
}, 999);

add_action('wp_head', function () {
  $s = edde_seo_current();
  if (!$s) { return; }
  remove_action('wp_head', 'rel_canonical');
  $root  = rtrim(get_option('home'), '/');
  $lang  = edde_lang();
  $name  = get_bloginfo('name');
  $title = $s['title'] . ($s['path'] === '' ? '' : ' — EDDE Global');
  echo "\n<!-- EDDE SEO -->\n";
  echo '<link rel="canonical" href="' . esc_url($s['url']) . '">' . "\n";
  echo '<link rel="alternate" hreflang="az" href="' . esc_url($root . '/' . $s['path']) . '">' . "\n";
  echo '<link rel="alternate" hreflang="en" href="' . esc_url($root . '/' . $s['path'] . '?lang=en') . '">' . "\n";
  echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($root . '/' . $s['path']) . '">' . "\n";
  echo '<meta property="og:site_name" content="' . esc_attr($name) . '">' . "\n";
  echo '<meta property="og:type" content="' . esc_attr($s['type']) . '">' . "\n";
  echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
  if ($s['desc'] !== '') { echo '<meta property="og:description" content="' . esc_attr($s['desc']) . '">' . "\n"; }
  echo '<meta property="og:url" content="' . esc_url($s['url']) . '">' . "\n";
  echo '<meta property="og:locale" content="' . ($lang === 'en' ? 'en_US' : 'az_AZ') . '">' . "\n";
  if ($s['image']) { echo '<meta property="og:image" content="' . esc_url($s['image']) . '">' . "\n"; }
  echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
  $ld = [];
  if ($s['path'] === '') {
    $c = function_exists('edde_contact') ? edde_contact() : [];
    $ld[] = ['@context' => 'https://schema.org', '@type' => 'EducationalOrganization', 'name' => 'EDDE Global', 'url' => $root . '/',
             'logo' => get_stylesheet_directory_uri() . '/assets/logo.png', 'email' => isset($c['email']) ? $c['email'] : '',
             'address' => isset($c['address']) ? $c['address'] : '', 'foundingDate' => '2018'];
  }
  if ($s['article']) {
    $a = $s['article'];
    $ld[] = ['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => mb_substr($a['title'], 0, 110),
             'description' => $s['desc'], 'image' => [$s['image']], 'inLanguage' => $lang,
             'datePublished' => gmdate('c', (int) $a['ts']), 'dateModified' => gmdate('c', (int) $a['ts']),
             'mainEntityOfPage' => $s['url'],
             'author' => ['@type' => 'Organization', 'name' => 'EDDE Global'],
             'publisher' => ['@type' => 'Organization', 'name' => 'EDDE Global', 'logo' => ['@type' => 'ImageObject', 'url' => get_stylesheet_directory_uri() . '/assets/logo.png']]];
  }
  if ($s['crumbs'] && count($s['crumbs']) > 1) {
    $items = []; $i = 1;
    foreach ($s['crumbs'] as $c) {
      $it = ['@type' => 'ListItem', 'position' => $i++, 'name' => $c[0]];
      if ($c[1] !== '') { $it['item'] = $c[1]; }
      $items[] = $it;
    }
    $ld[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
  }
  foreach ($ld as $o) { echo '<script type="application/ld+json">' . wp_json_encode($o, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n"; }
  echo "<!-- /EDDE SEO -->\n";
}, 1);

/* Sitemap: /edde-sitemap.xml — bütün səhifələr və yazılar (AZ; EN tərcümələri hreflang ilə bağlıdır). */
add_action('template_redirect', function () {
  $path = (string) parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH);
  if (substr($path, -17) !== '/edde-sitemap.xml' || !function_exists('edde_data')) { return; }
  $root = rtrim(get_option('home'), '/');
  $urls = [[$root . '/', null]];
  foreach (array_keys(edde_data('pages')) as $r) {
    if (in_array($r, ['edde-home', 'edde-xidmetler', 'edde-home/edde-xidmetler'], true)) { continue; }
    $urls[] = [$root . '/' . trim($r, '/') . '/', null];
  }
  foreach (edde_news_all() as $slug => $a) {
    $urls[] = [$root . '/' . edde_article_base($a['type']) . '/' . $slug . '/', $a['ts']];
  }
  nocache_headers();
  header('Content-Type: application/xml; charset=UTF-8');
  header('X-Robots-Tag: noindex'); // sitemap faylının özü indekslənmir, içindəki ünvanlar indekslənir
  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  foreach ($urls as $u) {
    echo '<url><loc>' . esc_url($u[0]) . '</loc>' . ($u[1] ? '<lastmod>' . gmdate('Y-m-d', (int) $u[1]) . '</lastmod>' : '') . '</url>' . "\n";
  }
  echo '</urlset>';
  exit;
}, 0);

add_filter('robots_txt', function ($out) {
  return rtrim($out) . "\nSitemap: " . rtrim(get_option('home'), '/') . "/edde-sitemap.xml\n";
}, 99);
/* === /EDDE SEO === */
