<?php
/**
 * İki dilli sayt: Azərbaycan (əsas, "/") və İngilis ("/en/").
 *
 * - Ünvan: eyni marşrut + ?lang=en (məs. /shirket-haqqinda/?lang=en). /en/shirket-haqqinda/ da tanınır.
 * - Məzmun səhifələri, FAQ, məqalələr, ölkələr: inc/data/en/*.php (eyni quruluşlu İngilis fayllar).
 * - Şablonlardakı sabit mətnlər (menyu, footer, ana səhifə, düymələr): inc/lang/en.php lüğəti
 *   (Azərbaycan mətni => İngilis mətni). Lüğətdə olmayan mətn Azərbaycanca qalır.
 *   Yeni mətn əlavə etsəniz, İngiliscəsini həmin lüğətə yazın.
 * - Çıxış HTML-i edde_lang_filter() ilə işlənir: mətnlər tərcümə olunur, daxili keçidlərə /en/ əlavə olunur.
 */

if (!function_exists('edde_home_base')) {
  /**
   * Saytın kök yolu (məs. '' və ya '/alt-qovluq'). get_option('home') istifadə olunur: dil plaginləri
   * (Polylang və s.) home_url()-ə /en/ əlavə edə bildiyi üçün home_url() bu məqsədlə etibarlı deyil.
   */
  function edde_home_base() {
    $home = function_exists('get_option') ? (string) get_option('home') : '';
    $p    = $home !== '' ? (string) parse_url($home, PHP_URL_PATH) : '';
    return rtrim($p, '/');
  }
}

if (!function_exists('edde_home_root')) {
  /** Saytın kök ünvanı, sonunda / olmadan (dil prefiksi olmadan). */
  function edde_home_root() {
    $home = function_exists('get_option') ? (string) get_option('home') : '';
    return $home !== '' ? rtrim($home, '/') : rtrim(home_url('/'), '/');
  }
}

if (!function_exists('edde_lang')) {
  /**
   * Cari dil: 'az' və ya 'en'.
   * İngilis dili iki üsulla tanınır: ?lang=en parametri (əsas, hər yerdə işləyir) və ya /en/ ünvan prefiksi.
   */
  function edde_lang() {
    if (isset($_GET['lang'])) {
      $q = strtolower((string) $_GET['lang']);
      if ($q === 'en' || $q === 'az') { return $q; }
    }
    $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = (string) parse_url($uri, PHP_URL_PATH);
    $base = edde_home_base();
    if ($base !== '' && strpos($path, $base) === 0) { $path = substr($path, strlen($base)); }
    $path = '/' . ltrim(strtolower($path), '/');
    if ($path === '/en' || strpos($path, '/en/') === 0) { return 'en'; }
    // Polylang və s. dili öz üsulu ilə təyin edibsə
    if (function_exists('pll_current_language') && pll_current_language('slug') === 'en') { return 'en'; }
    return 'az';
  }
}

if (!function_exists('edde_lang_url')) {
  /** Daxili ünvana ?lang=en əlavə edir (# hissəsini qoruyaraq). */
  function edde_lang_url($url) {
    if (preg_match('~[?&]lang=~', $url)) { return $url; }
    $hash = '';
    if (($i = strpos($url, '#')) !== false) { $hash = substr($url, $i); $url = substr($url, 0, $i); }
    return $url . (strpos($url, '?') === false ? '?' : '&') . 'lang=en' . $hash;
  }
}

if (!function_exists('edde_lang_path')) {
  /** Cari səhifənin dil prefiksi olmadan yolu, məs. "/shirket-haqqinda/". */
  function edde_lang_path() {
    $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $path = (string) parse_url($uri, PHP_URL_PATH);
    $base = edde_home_base();
    if ($base !== '' && strpos($path, $base) === 0) { $path = substr($path, strlen($base)); }
    $path = '/' . ltrim($path, '/');
    if (preg_match('~^/en(/|$)~i', $path)) { $path = substr($path, 3); }
    return '/' . ltrim($path, '/');
  }
}

if (!function_exists('edde_lang_urls')) {
  /** Dil keçidi üçün: ['az' => ünvan, 'en' => ünvan] (hazırkı səhifənin qarşı dildəki ekvivalenti). */
  function edde_lang_urls() {
    $p = edde_lang_path();
    $root = edde_home_root();
    return ['az' => $root . $p, 'en' => edde_lang_url($root . $p)];
  }
}

if (!function_exists('edde_lang_dict')) {
  function edde_lang_dict() {
    static $d = null;
    if ($d === null) {
      $f = __DIR__ . '/lang/en.php';
      $d = is_readable($f) ? include $f : [];
    }
    return $d;
  }
}

if (!function_exists('edde_lang_norm')) {
  function edde_lang_norm($s) {
    return trim(preg_replace('~\s+~u', ' ', html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
  }
}

if (!function_exists('edde_lang_filter')) {
  /** Hazır HTML-i İngilis dilinə çevirir (mətn düyünləri, placeholder/alt/title/aria-label/content, keçidlər). */
  function edde_lang_filter($html) {
    if (edde_lang() !== 'en') { return $html; }
    $dict = edde_lang_dict();
    $tr = function ($raw) use ($dict) {
      $key = edde_lang_norm($raw);
      if ($key === '' || !isset($dict[$key])) { return null; }
      return $dict[$key];
    };

    // script / style bloklarını toxunmadan saxla
    $stash = [];
    $html = preg_replace_callback('~<(script|style)\b[^>]*>.*?</\1>~is', function ($m) use (&$stash) {
      $stash[] = $m[0];
      return '<!--EDDE_STASH_' . (count($stash) - 1) . '-->';
    }, $html);

    // mətn düyünləri
    $html = preg_replace_callback('~>([^<>]+)<~u', function ($m) use ($tr) {
      $t = $tr($m[1]);
      if ($t === null) { return $m[0]; }
      preg_match('~^(\s*)~u', $m[1], $lead);
      preg_match('~(\s*)$~u', $m[1], $trail);
      return '>' . $lead[1] . htmlspecialchars($t, ENT_NOQUOTES, 'UTF-8') . $trail[1] . '<';
    }, $html);

    // atributlar
    $html = preg_replace_callback('~\b(placeholder|alt|title|aria-label|content)="([^"]*)"~u', function ($m) use ($tr) {
      $t = $tr($m[2]);
      return $t === null ? $m[0] : $m[1] . '="' . htmlspecialchars($t, ENT_COMPAT, 'UTF-8') . '"';
    }, $html);

    // daxili səhifə keçidlərinə ?lang=en (dil keçidi data-lang ilə işarələnib, toxunulmur)
    $home = edde_home_root();
    // artıq /en/ prefiksi olan keçidlərə (məs. dil plaginindən gələnlərə) toxunulmur
    $pat  = '~^' . preg_quote($home, '~') . '(?!/en(?:/|$|\?|#))(/|$|\?|#)~';
    $skip = '~^' . preg_quote($home, '~') . '/(wp-|assets|theme|feed)~';
    $html = preg_replace_callback('~<a\s[^>]*>~i', function ($m) use ($pat, $skip) {
      if (stripos($m[0], 'data-lang') !== false) { return $m[0]; }
      return preg_replace_callback('~\bhref="([^"]*)"~', function ($h) use ($pat, $skip) {
        $u = html_entity_decode($h[1]);
        if (!preg_match($pat, $u) || preg_match($skip, $u)) { return $h[0]; }
        return 'href="' . htmlspecialchars(edde_lang_url($u)) . '"';
      }, $m[0]);
    }, $html);

    $html = preg_replace('~<html\b([^>]*?)\blang="az"~i', '<html$1lang="en"', $html, 1);

    return preg_replace_callback('~<!--EDDE_STASH_(\d+)-->~', function ($m) use ($stash) { return $stash[(int) $m[1]]; }, $html);
  }
}
