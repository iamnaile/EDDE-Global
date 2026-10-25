<?php
/** Yazılar bölməsinin ortaq HTML köməkçiləri (kartlar, tarix, oxuma müddəti). */

if (!function_exists('edde_news_url')) {
  function edde_news_url($a) {
    return home_url('/' . edde_article_base($a['type']) . '/' . $a['slug'] . '/');
  }
}

if (!function_exists('edde_news_label')) {
  function edde_news_label($type) { return $type === 'media' ? 'Mediada biz' : 'Məqalə'; }
}

if (!function_exists('edde_news_minutes')) {
  function edde_news_minutes($a) { return max(1, (int) ceil(($a['words'] ?? 0) / 200)); }
}

if (!function_exists('edde_news_card')) {
  /** Kart: $variant = 'grid' | 'hero' | 'row'. */
  function edde_news_card($a, $variant = 'grid') {
    $url = esc_url(edde_news_url($a));
    $type = $a['type'] === 'media' ? 'media' : 'meqale';
    $media = $a['image']
      ? '<div class="ncard__media"><img src="' . esc_url($a['image']) . '" alt="" loading="lazy"></div>'
      : '<div class="ncard__media ncard__media--ph ncard__media--' . $type . '"><span>' . ($type === 'media' ? '🎙️' : '📰') . '</span></div>';
    $meta = '<span class="ncard__chip ncard__chip--' . $type . '">' . esc_html(edde_news_label($a['type'])) . '</span>'
          . '<time>' . esc_html($a['date']) . '</time>';
    $min = $a['words'] ? '<span class="ncard__min">' . (int) edde_news_minutes($a) . (edde_lang() === 'en' ? ' min read' : ' dəq. oxu') . '</span>' : '';
    if ($variant === 'row') {
      return '<a class="ncard ncard--row" href="' . $url . '">' . $media . '<div class="ncard__body"><div class="ncard__meta">' . $meta . '</div><h3>' . esc_html($a['title']) . '</h3></div></a>';
    }
    $ex = $variant === 'hero' ? '<p>' . esc_html(mb_strimwidth($a['excerpt'], 0, 240, '…', 'UTF-8')) . '</p>' : '<p>' . esc_html(mb_strimwidth($a['excerpt'], 0, 150, '…', 'UTF-8')) . '</p>';
    return '<a class="ncard ncard--' . $variant . '" href="' . $url . '">' . $media . '<div class="ncard__body"><div class="ncard__meta">' . $meta . '</div><h3>' . esc_html($a['title']) . '</h3>' . $ex . '<div class="ncard__foot">' . $min . '<em>Oxu →</em></div></div></a>';
  }
}

if (!function_exists('edde_news_include')) {
  /** parts/edde-news-<ad>.php şablonunu ayrıca dəyişən sahəsində (WordPress qlobal dəyişənləri ilə toqquşmasın deyə) işə salır. */
  function edde_news_include($name, $vars) {
    extract($vars, EXTR_SKIP);
    include get_stylesheet_directory() . '/parts/edde-news-' . $name . '.php';
  }
}
