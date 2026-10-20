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

/* ==========================================================================
   WhatsApp nömrəsi — WordPress-də Görünüş → Fərdiləşdir → "EDDE Əlaqə" bölməsindən idarə olunur.
   Üzən WhatsApp düyməsi, "WhatsApp-da yazın" linkləri və formaların göndərildiyi nömrə buradan gəlir.
   ========================================================================== */
const EDDE_WA_DEFAULT = '994772555658';

/** Yalnız rəqəmlər, beynəlxalq formatda (məs. 994772555658). */
function edde_wa_sanitize($value) {
    $digits = preg_replace('/\D+/', '', (string) $value);
    // 0772555658 → 994772555658
    if (strlen($digits) === 10 && $digits[0] === '0') {
        $digits = '994' . substr($digits, 1);
    }
    return $digits;
}

function edde_wa_number() {
    $n = edde_wa_sanitize(get_theme_mod('edde_whatsapp_number', EDDE_WA_DEFAULT));
    return $n !== '' ? $n : EDDE_WA_DEFAULT;
}

/** https://wa.me/<nömrə> (istəyə görə ?text=...) */
function edde_wa_url($text = '') {
    $url = 'https://wa.me/' . edde_wa_number();
    return $text !== '' ? $url . '?text=' . rawurlencode($text) : $url;
}

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('edde_contact', [
        'title'    => 'EDDE Əlaqə',
        'priority' => 30,
    ]);
    $wp_customize->add_setting('edde_whatsapp_number', [
        'default'           => EDDE_WA_DEFAULT,
        'sanitize_callback' => 'edde_wa_sanitize',
        'transport'         => 'refresh',
    ]);
    $wp_customize->add_control('edde_whatsapp_number', [
        'section'     => 'edde_contact',
        'label'       => 'WhatsApp nömrəsi',
        'description' => 'Beynəlxalq formatda, + və boşluqsuz yazın. Məs: 994772555658',
        'type'        => 'text',
    ]);
});

// Skriptlər üçün nömrəni səhifəyə ötür (edde-script.js, edde-pages.js, edde-ielts.php)
add_action('wp_head', function () {
    echo '<script>window.EDDE_WA=' . wp_json_encode(edde_wa_number()) . ';</script>' . "\n";
}, 1);
