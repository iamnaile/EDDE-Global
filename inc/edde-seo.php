<?php
/**
 * EDDE SEO — bütün saytın səhifələri və məqalələr: index, canonical, hreflang, OG, Article/Breadcrumb schema, sitemap, robots.txt.
 * Yer: edde-child/inc/edde-seo.php  (functions.php bu faylı özü qoşur; faylı silməyin və ya köhnə nüsxə ilə əvəz etməyin!)
 *
 * Rank Math aktivdirsə onunla uyğun işləyir: onun noindex/canonical/təkrar teqlərini bu saytın öz səhifələrində düzəldir.
 */
if (!defined('ABSPATH')) { exit; }

/* === EDDE SEO (27.10.2026) === məqalə və bütün səhifələr: indeks, canonical, OG, schema, sitemap. Silməyin! */

if (!function_exists('edde_seo_ctx')) {
    /** Saytın öz şablonlarından biri göstərilirsə SEO konteksti, yoxsa (admin, 404, başqa WordPress səhifəsi) null. */
    function edde_seo_ctx() {
        static $ctx = false;
        if ($ctx !== false) { return $ctx; }
        $ctx = null;
        if (is_admin() || !function_exists('edde_request_route') || !function_exists('edde_lang')) { return null; }
        $root = rtrim(get_option('home'), '/');
        $en   = edde_lang() === 'en';
        $q    = $en ? '?lang=en' : '';
        $img  = get_stylesheet_directory_uri() . '/assets/hero-xaricde-tehsil.webp';
        $route = isset($GLOBALS['edde_route']) ? trim((string) $GLOBALS['edde_route'], '/') : trim((string) edde_request_route(), '/');
        if ($route === '' || $route === 'edde-home') {
            if (!is_front_page() && !($route === 'edde-home')) { return null; }
            $ctx = ['kind' => 'home', 'route' => '', 'path' => '', 'url' => $root . '/' . $q, 'title' => get_bloginfo('name'), 'desc' => '', 'image' => $img, 'article' => null, 'group' => ''];
            return $ctx;
        }
        if (function_exists('edde_template_for_route') && !edde_template_for_route($route) && !function_exists('edde_route_page')) { return null; }
        $pg = function_exists('edde_route_page') ? edde_route_page($route) : null;
        if (!$pg && (!function_exists('edde_template_for_route') || !edde_template_for_route($route))) { return null; }
        $article = ($pg && $pg['kind'] === 'article') ? $pg['article'] : null;
        $ctx = [
            'kind'    => $article ? 'article' : 'page',
            'route'   => $route,
            'path'    => $route . '/',
            'url'     => $root . '/' . $route . '/' . $q,
            'title'   => $pg ? wp_strip_all_tags($pg['title']) : (!empty($GLOBALS['edde_page_title']) ? $GLOBALS['edde_page_title'] : ucfirst($route)),
            'desc'    => $pg && isset($pg['meta']) ? trim(wp_strip_all_tags((string) $pg['meta'])) : '',
            'image'   => $article && !empty($article['image']) ? $article['image'] : $img,
            'article' => $article,
            'group'   => $pg && !empty($pg['group']) ? $pg['group'] : '',
        ];
        return $ctx;
    }
}

/* Rank Math: bu səhifələr həmişə açıqdır (noindex götürülür), canonical-ı biz verəndə onun ki söndürülür */
add_filter('rank_math/frontend/robots', function ($robots) {
    if (edde_seo_ctx()) {
        return ['index' => 'index', 'follow' => 'follow', 'max-snippet' => 'max-snippet:-1', 'max-video-preview' => 'max-video-preview:-1', 'max-image-preview' => 'max-image-preview:large'];
    }
    return $robots;
}, 99);
add_filter('wp_robots', function ($robots) {
    if (edde_seo_ctx()) {
        unset($robots['noindex'], $robots['nofollow']);
        $robots['max-image-preview'] = 'large';
    }
    return $robots;
}, 999);
add_filter('rank_math/frontend/canonical', function ($c) { return edde_seo_ctx() ? false : $c; }, 99);
add_filter('rank_math/frontend/description', function ($d) { return edde_seo_ctx() ? '' : $d; }, 99);
add_action('send_headers', function () {
    if (edde_seo_ctx() && !headers_sent()) { header_remove('X-Robots-Tag'); }
}, 999);

/* Sosial paylaşım şəkli: Rank Math-in öz şəkli yoxdursa saytın şəkli */
foreach (['rank_math/opengraph/facebook/image', 'rank_math/opengraph/twitter/image'] as $edde_seo_f) {
    add_filter($edde_seo_f, function ($img) {
        $c = edde_seo_ctx();
        return ($c && empty($img)) ? $c['image'] : $img;
    }, 99);
}
foreach (['rank_math/opengraph/facebook/og_title', 'rank_math/opengraph/twitter/twitter_title'] as $edde_seo_f) {
    add_filter($edde_seo_f, function ($t) {
        $c = edde_seo_ctx();
        return ($c && $c['kind'] === 'article') ? $c['title'] : $t;
    }, 99);
}

/* <head> çıxışı toplanır: noindex/təkrar teqlər təmizlənir, çatışmayanlar əlavə olunur */
add_action('wp_head', function () {
    if (edde_seo_ctx()) { ob_start(); }
}, 0);
add_action('wp_head', function () {
    $c = edde_seo_ctx();
    if (!$c) { return; }
    $buf  = (string) ob_get_clean();
    $root = rtrim(get_option('home'), '/');
    $lang = edde_lang();
    $has  = function ($re) use (&$buf) { return (bool) preg_match($re, $buf); };

    // 1) noindex və təkrar teqlər (şablon özü <meta name="description"> yazır)
    $buf = preg_replace('~<meta\s+name=["\']robots["\'][^>]*>\s*~i', '', $buf);
    $buf = preg_replace('~<meta\s+name=["\']description["\'][^>]*>\s*~i', '', $buf);
    $buf = preg_replace('~<link\s+rel=["\']canonical["\'][^>]*>\s*~i', '', $buf);

    $out  = '<meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large">' . "\n";
    $out .= '<link rel="canonical" href="' . esc_url($c['url']) . '" />' . "\n";
    $out .= '<link rel="alternate" hreflang="az" href="' . esc_url($root . '/' . $c['path']) . '" />' . "\n";
    $out .= '<link rel="alternate" hreflang="en" href="' . esc_url($root . '/' . $c['path'] . '?lang=en') . '" />' . "\n";
    $out .= '<link rel="alternate" hreflang="x-default" href="' . esc_url($root . '/' . $c['path']) . '" />' . "\n";
    $title = !empty($GLOBALS['edde_page_title']) ? wp_strip_all_tags($GLOBALS['edde_page_title']) : $c['title'];
    if (!$has('~property=["\']og:type["\']~i'))        { $out .= '<meta property="og:type" content="' . ($c['kind'] === 'article' ? 'article' : 'website') . '" />' . "\n"; }
    if (!$has('~property=["\']og:title["\']~i'))       { $out .= '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n"; }
    if (!$has('~property=["\']og:url["\']~i'))         { $out .= '<meta property="og:url" content="' . esc_url($c['url']) . '" />' . "\n"; }
    if (!$has('~property=["\']og:site_name["\']~i'))   { $out .= '<meta property="og:site_name" content="EDDE Global" />' . "\n"; }
    if (!$has('~property=["\']og:locale["\']~i'))      { $out .= '<meta property="og:locale" content="' . ($lang === 'en' ? 'en_US' : 'az_AZ') . '" />' . "\n"; }
    if ($c['desc'] !== '' && !$has('~property=["\']og:description["\']~i')) { $out .= '<meta property="og:description" content="' . esc_attr($c['desc']) . '" />' . "\n"; }
    if (!$has('~property=["\']og:image["\']~i'))       { $out .= '<meta property="og:image" content="' . esc_url($c['image']) . '" />' . "\n"; }
    if (!$has('~name=["\']twitter:card["\']~i'))       { $out .= '<meta name="twitter:card" content="summary_large_image" />' . "\n"; }
    if (!$has('~name=["\']twitter:image["\']~i'))      { $out .= '<meta name="twitter:image" content="' . esc_url($c['image']) . '" />' . "\n"; }

    // 2) strukturlaşdırılmış məlumat
    $ld = [];
    if ($c['kind'] === 'article') {
        $a  = $c['article'];
        $ts = !empty($a['ts']) ? (int) $a['ts'] : time();
        $ld[] = ['@context' => 'https://schema.org', '@type' => 'Article', 'headline' => mb_substr($c['title'], 0, 110), 'description' => $c['desc'],
                 'image' => [$c['image']], 'datePublished' => gmdate('c', $ts), 'dateModified' => gmdate('c', $ts), 'inLanguage' => $lang,
                 'mainEntityOfPage' => $c['url'],
                 'author' => ['@type' => 'Organization', 'name' => 'EDDE Global', 'url' => home_url('/')],
                 'publisher' => ['@type' => 'Organization', 'name' => 'EDDE Global', 'url' => home_url('/'), 'logo' => ['@type' => 'ImageObject', 'url' => get_stylesheet_directory_uri() . '/assets/logo.png']]];
    }
    if ($c['kind'] !== 'home') {
        $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'EDDE Global', 'item' => $root . '/']];
        $pos = 2;
        if ($c['group'] !== '' && $c['group'] !== $c['title']) { $items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $c['group']]; }
        $items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => $c['title'], 'item' => $c['url']];
        $ld[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    } elseif (stripos($buf, 'application/ld+json') === false) {
        $ct = function_exists('edde_contact') ? edde_contact() : [];
        $ld[] = ['@context' => 'https://schema.org', '@type' => 'EducationalOrganization', 'name' => 'EDDE Global', 'url' => $root . '/',
                 'logo' => get_stylesheet_directory_uri() . '/assets/logo.png', 'email' => isset($ct['email']) ? $ct['email'] : '',
                 'address' => isset($ct['address']) ? $ct['address'] : '', 'foundingDate' => '2018'];
    }
    foreach ($ld as $o) { $out .= '<script type="application/ld+json">' . wp_json_encode($o, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n"; }

    echo $buf . "<!-- EDDE SEO -->\n" . $out . "<!-- /EDDE SEO -->\n";
}, 9999);

/* === EDDE SEO sitemap === */
add_action('init', function () {
    $path = rtrim((string) parse_url(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', PHP_URL_PATH), '/');
    if (!in_array($path, ['/edde-news-sitemap.xml', '/edde-pages-sitemap.xml'], true) || !function_exists('edde_news_all')) { return; }
    status_header(200);
    header('Content-Type: application/xml; charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    if ($path === '/edde-news-sitemap.xml') {
        foreach (edde_news_all() as $slug => $a) {
            $base = function_exists('edde_article_base') ? edde_article_base($a['type']) : 'meqaleler';
            $ts   = !empty($a['ts']) ? (int) $a['ts'] : time();
            echo '<url><loc>' . esc_url(home_url('/' . $base . '/' . $slug . '/')) . '</loc><lastmod>' . gmdate('Y-m-d', $ts) . '</lastmod></url>' . "\n";
        }
    } else {
        $skip = ['edde-home', 'edde-home/edde-xidmetler', 'shirket-haqqinda-old'];
        $routes = array_keys(edde_data('pages'));
        $routes[] = 'edde-xidmetler';
        foreach (array_unique($routes) as $r) {
            if (in_array($r, $skip, true)) { continue; }
            echo '<url><loc>' . esc_url(home_url('/' . trim($r, '/') . '/')) . '</loc></url>' . "\n";
        }
    }
    echo '</urlset>';
    exit;
}, 20);
add_filter('rank_math/sitemap/index', function ($xml) {
    return $xml
        . '<sitemap><loc>' . esc_url(home_url('/edde-news-sitemap.xml')) . '</loc><lastmod>' . gmdate('c') . '</lastmod></sitemap>'
        . '<sitemap><loc>' . esc_url(home_url('/edde-pages-sitemap.xml')) . '</loc><lastmod>' . gmdate('c') . '</lastmod></sitemap>';
});

/* robots.txt: sitemap ünvanı https və işlək sitemap_index.xml (köhnə http://.../sitemap.xml sətri çıxarılır) */
add_filter('robots_txt', function ($out) {
    $out = preg_replace('~^\s*Sitemap:.*$\R?~mi', '', (string) $out);
    return rtrim($out) . "\nSitemap: " . preg_replace('~^http://~', 'https://', rtrim(get_option('home'), '/')) . "/sitemap_index.xml\n";
}, 99);
/* === /EDDE SEO === */
