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
require_once get_stylesheet_directory() . '/inc/edde-contact.php';
require_once get_stylesheet_directory() . '/inc/edde-content.php';

/**
 * Marşrutun hansı şablonla göstəriləcəyi. null — WordPress özü həll etsin.
 * İngilis versiyada (/en/) ana səhifə və Xidmətlər səhifəsi də buradan tapılır.
 */
function edde_template_for_route($route) {
    if ($route !== '' && edde_route_page($route)) {
        return get_stylesheet_directory() . '/edde-page.php';
    }
    if (edde_lang() === 'en') {
        if ($route === '' || $route === 'edde-home') {
            return get_stylesheet_directory() . '/edde-home.php';
        }
        if ($route === 'edde-xidmetler' || $route === 'edde-home/edde-xidmetler') {
            return get_stylesheet_directory() . '/edde-xidmetler.php';
        }
    }
    return null;
}

add_filter('template_include', function ($template) {
    if (is_admin() || is_embed()) {
        return $template;
    }
    $route = edde_request_route();
    $tpl   = edde_template_for_route($route);
    if (!$tpl) {
        return $template;
    }
    $GLOBALS['edde_route'] = $route;
    global $wp_query;
    if ($wp_query->is_404()) {
        $wp_query->is_404 = false;
        status_header(200);
    }
    return $tpl;
}, 99);

/* Ana səhifə (eddeglobal.az) — edde-home.php şablonu avtomatik göstərilir.
   WordPress-də "Parametrlər → Oxu" bölməsi nəyə qurulubsa (son yazılar və ya statik səhifə) fərq etmir. */
add_filter('template_include', function ($template) {
    if (is_admin() || is_embed() || !is_front_page()) {
        return $template;
    }
    return get_stylesheet_directory() . '/edde-home.php';
}, 98);

/* İngilis versiya: bütün çıxış HTML-i tərcümə olunur (lüğət: inc/lang/en.php). */
add_action('template_redirect', function () {
    if (!is_admin() && edde_lang() === 'en') {
        ob_start('edde_lang_filter');
    }
}, 1);
add_filter('redirect_canonical', function ($redirect) {
    return edde_lang() === 'en' ? false : $redirect;
});

// WordPress "oxşar ünvana" yönləndirməsin (məs. /olkeler/ → başqa yazı)
add_filter('pre_redirect_guess_404_permalink', function ($pre) {
    return edde_template_for_route(edde_request_route()) ? '' : $pre;
});

/* Silinmiş səhifələrin köhnə ünvanları: ixtisas seçimi testi xarici test saytına, qalanları uyğun bölməyə yönləndirilir. */
add_action('template_redirect', function () {
    if (is_admin()) {
        return;
    }
    $c = edde_contact();
    $map = [
        'ixtisas-secimi-testi' => $c['test_url'],
        'turkiyede-tehsil'     => home_url('/xaricde-tehsil/'),
        'alman-dili-kurslari'  => home_url('/dil-kurslari/'),
    ];
    $route = edde_request_route();
    if (isset($map[$route])) {
        wp_redirect($map[$route], 301);
        exit;
    }
});
