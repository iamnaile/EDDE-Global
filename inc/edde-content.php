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

require_once __DIR__ . '/edde-nav.php';

if (!function_exists('edde_data')) {
  /** inc/data/<ad>.php faylını bir dəfə oxuyub yadda saxlayır. */
  function edde_data($name) {
    static $cache = [];
    if (!isset($cache[$name])) {
      $file = __DIR__ . '/data/' . $name . '.php';
      $cache[$name] = is_readable($file) ? include $file : [];
    }
    return $cache[$name];
  }
}

if (!function_exists('edde_articles_by_type')) {
  /** type = 'meqale' | 'media'. Yeni → köhnə sıralanır. */
  function edde_articles_by_type($type) {
    $out = [];
    foreach (edde_data('articles') as $slug => $a) {
      if ($a['type'] === $type) { $a['slug'] = $slug; $out[$slug] = $a; }
    }
    uasort($out, function ($x, $y) {
      $dx = DateTime::createFromFormat('d.m.Y', $x['date']);
      $dy = DateTime::createFromFormat('d.m.Y', $y['date']);
      return $dy <=> $dx;
    });
    return $out;
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
      $articles = edde_data('articles');
      if (isset($articles[$slug])) {
        $a = $articles[$slug];
        if (edde_article_base($a['type']) === $base) {
          return [
            'route' => $route, 'kind' => 'article', 'article' => $a + ['slug' => $slug],
            'title' => $a['title'], 'group' => 'Yazılar', 'icon' => '📰',
            'meta'  => edde_excerpt($a['blocks'], 160),
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
    $base = (string) parse_url(home_url('/'), PHP_URL_PATH);
    if ($base !== '' && $base !== '/' && strpos($path, $base) === 0) {
      $path = substr($path, strlen($base));
    }
    return strtolower(trim(rawurldecode($path), '/'));
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
      ['EDDE Academy', '/edde-xidmetler/', false],
      ['Ölkələr və universitetlər', '/olkeler/', false],
      ['Məqalələr', '/meqaleler/', false],
      ['FAQ', '/faq/', false],
      ['Əlaqə', '/elaqe/', false],
    ]];
  }
}
