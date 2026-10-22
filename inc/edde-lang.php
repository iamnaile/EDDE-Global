<?php
/**
 * İki dilli sayt: Azərbaycan (əsas, "/") və İngilis ("/en/").
 *
 * - Ünvan: /en/... — marşrut eynidir, yalnız "en/" prefiksi var (məs. /en/shirket-haqqinda/).
 * - Məzmun səhifələri, FAQ, məqalələr, ölkələr: inc/data/en/*.php (eyni quruluşlu İngilis fayllar).
 * - Şablonlardakı sabit mətnlər (menyu, footer, ana səhifə, düymələr): inc/lang/en.php lüğəti
 *   (Azərbaycan mətni => İngilis mətni). Lüğətdə olmayan mətn Azərbaycanca qalır.
 *   Yeni mətn əlavə etsəniz, İngiliscəsini həmin lüğətə yazın.
 * - Çıxış HTML-i edde_lang_filter() ilə işlənir: mətnlər tərcümə olunur, daxili keçidlərə /en/ əlavə olunur.
 */

if (!function_exists('edde_lang')) {
  /** Cari dil: 'az' və ya 'en' (ünvanın əvvəlindəki /en/ prefiksinə görə). */
  function edde_lang() {
    static $lang = null;
    if ($lang !== null) { return $lang; }
    $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = (string) parse_url($uri, PHP_URL_PATH);
    $base = function_exists('home_url') ? (string) parse_url(home_url('/'), PHP_URL_PATH) : '/';
    if ($base !== '' && $base !== '/' && strpos($path, $base) === 0) { $path = substr($path, strlen($base) - 1); }
    $path = '/' . ltrim(strtolower($path), '/');
    $lang = ($path === '/en' || strpos($path, '/en/') === 0) ? 'en' : 'az';
    return $lang;
  }
}

if (!function_exists('edde_lang_path')) {
  /** Cari səhifənin dil prefiksi olmadan yolu, məs. "/shirket-haqqinda/". */
  function edde_lang_path() {
    $uri  = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $path = (string) parse_url($uri, PHP_URL_PATH);
    $base = (string) parse_url(home_url('/'), PHP_URL_PATH);
    if ($base !== '' && $base !== '/' && strpos($path, $base) === 0) { $path = substr($path, strlen($base) - 1); }
    $path = '/' . ltrim($path, '/');
    if (preg_match('~^/en(/|$)~i', $path)) { $path = substr($path, 3); }
    return '/' . ltrim($path, '/');
  }
}

if (!function_exists('edde_lang_urls')) {
  /** Dil keçidi üçün: ['az' => ünvan, 'en' => ünvan] (hazırkı səhifənin qarşı dildəki ekvivalenti). */
  function edde_lang_urls() {
    $p = edde_lang_path();
    return ['az' => home_url($p), 'en' => home_url('/en' . ($p === '/' ? '/' : $p))];
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

    // daxili keçidlərə /en/ prefiksi (dil keçidi data-lang ilə işarələnib, toxunulmur)
    $home = rtrim(home_url('/'), '/');
    $pat  = '~^(' . preg_quote($home, '~') . ')/(?!en(?:/|$|#|\?)|wp-|assets|theme)~';
    $html = preg_replace_callback('~<a\s[^>]*>~i', function ($m) use ($pat) {
      if (stripos($m[0], 'data-lang') !== false) { return $m[0]; }
      return preg_replace_callback('~\bhref="([^"]*)"~', function ($h) use ($pat) {
        $u = html_entity_decode($h[1]);
        $n = preg_replace($pat, '$1/en/', $u, 1, $c);
        return $c ? 'href="' . htmlspecialchars($n) . '"' : $h[0];
      }, $m[0]);
    }, $html);

    $html = preg_replace('~<html\b([^>]*?)\blang="az"~i', '<html$1lang="en"', $html, 1);

    return preg_replace_callback('~<!--EDDE_STASH_(\d+)-->~', function ($m) use ($stash) { return $stash[(int) $m[1]]; }, $html);
  }
}
