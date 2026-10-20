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

/* Ana səhifə (eddeglobal.az) — edde-home.php şablonu avtomatik göstərilir.
   WordPress-də "Parametrlər → Oxu" bölməsi nəyə qurulubsa (son yazılar və ya statik səhifə) fərq etmir. */
add_filter('template_include', function ($template) {
    if (is_admin() || is_embed() || !is_front_page()) {
        return $template;
    }
    return get_stylesheet_directory() . '/edde-home.php';
}, 98);

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
