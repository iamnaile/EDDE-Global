<?php
function edde_child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'edde_child_enqueue_styles');

/* ==========================================================================
   EDDE məzmun səhifələri (Haqqımızda, Xaricdə təhsil, EDDE Academy, Yazılar, FAQ, Əlaqə və s.)

   Bütün bu səhifələr inc/data/pages.php-dəki məlumatdan edde-page.php şablonu ilə çəkilir.
   Ünvan inc/data/ içindəki açarlardan biri ilə üst-üstə düşəndə (məs. /ielts/, /faq/, /elaqe/,
   /meqaleler/…) WordPress-də həmin səhifə olsa da, olmasa da, bu şablon göstərilir —
   ayrıca səhifə yaradıb şablon seçməyə ehtiyac yoxdur.
   ========================================================================== */
require_once get_stylesheet_directory() . '/inc/edde-content.php';

add_filter('template_include', function ($template) {
    if (is_admin() || is_embed()) {
        return $template;
    }
    $route = edde_request_route();
    if ($route === '' || !edde_route_page($route)) {
        return $template;
    }
    $GLOBALS['edde_route'] = $route;
    global $wp_query;
    if ($wp_query->is_404()) {
        $wp_query->is_404 = false;
        status_header(200);
    }
    return get_stylesheet_directory() . '/edde-page.php';
}, 99);

/* Ana səhifə (eddeglobal.az → edde-home.php, eddeacademy.az → edde-academy-home.php) avtomatik göstərilir.
   WordPress-də "Parametrlər → Oxu" bölməsi nəyə qurulubsa (son yazılar və ya statik səhifə) fərq etmir. */
add_filter('template_include', function ($template) {
    if (is_admin() || is_embed() || !is_front_page()) {
        return $template;
    }
    // eddeacademy.az — Academy ana səhifəsi
    if (edde_is_academy_site()) {
        return get_stylesheet_directory() . '/edde-academy-home.php';
    }
    return get_stylesheet_directory() . '/edde-home.php';
}, 98);

/* eddeacademy.az: Academy-yə aid olmayan səhifələr (xaricdə təhsil, haqqımızda, məqalələr və s.)
   eddeglobal.az-dakı eyni ünvana yönləndirilir. */
add_action('template_redirect', function () {
    if (!edde_is_academy_site() || is_admin() || is_embed() || is_front_page()) {
        return;
    }
    $route = edde_request_route();
    if ($route === '' || in_array($route, edde_academy_routes(), true)) {
        return;
    }
    // Köhnə ünvan: Global saytdakı Academy bölməsi → Academy ana səhifəsi
    if ($route === 'edde-xidmetler' || $route === 'edde-home') {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
    if (edde_route_page($route)) {
        wp_redirect(edde_global_url('/' . $route . '/'), 301);
        exit;
    }
}, 1);

// WordPress "oxşar ünvana" yönləndirməsin (məs. /olkeler/ → başqa yazı)
add_filter('pre_redirect_guess_404_permalink', function ($pre) {
    return edde_route_page(edde_request_route()) ? '' : $pre;
});

/**
 * "İxtisas seçimi testi" formundan sonra yönləndiriləcək rəsmi test ünvanı.
 * TC Üsküdar Universitetinin test linkini bura yazın (və ya başqa yerdən 'edde_test_url' filtri ilə verin).
 * Boş qalarsa, forma məlumatları WhatsApp vasitəsilə komandaya göndərilir.
 */
add_filter('edde_test_url', function ($url) {
    return $url ?: '';
});
