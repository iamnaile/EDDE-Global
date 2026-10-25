<?php
/**
 * Word (.docx) faylını təmiz HTML-ə çevirir (WordPress-dən asılı olmayan təmiz PHP; ZipArchive + DOM lazımdır).
 *
 * edde_docx_parse($path, $saveImage) → [
 *   'title' => başlıq, 'html' => məqalənin gövdəsi (başlıq daxil deyil), 'excerpt' => qısa xülasə,
 *   'date' => 'Y-m-d H:i:s' (sənədin yaradılma tarixi) və ya '', 'images' => [saxlanmış şəkil ünvanları],
 * ]
 * $saveImage(string $filename, string $bytes): string|false — şəkli saxlayıb ünvanını qaytaran funksiya.
 */

if (!function_exists('edde_docx_translit')) {
  /** Azərbaycan/Türk hərflərini latına çevirir (slug üçün). */
  function edde_docx_translit($s) {
    return strtr($s, [
      'ə' => 'e', 'Ə' => 'e', 'ı' => 'i', 'İ' => 'i', 'I' => 'i', 'ö' => 'o', 'Ö' => 'o', 'ü' => 'u', 'Ü' => 'u',
      'ç' => 'c', 'Ç' => 'c', 'ş' => 's', 'Ş' => 's', 'ğ' => 'g', 'Ğ' => 'g',
    ]);
  }
}

if (!function_exists('edde_docx_parse')) {
  function edde_docx_parse($path, $saveImage = null) {
    if (!class_exists('ZipArchive')) { throw new RuntimeException('Serverdə ZipArchive (php-zip) yoxdur.'); }
    $zip = new ZipArchive();
    if ($zip->open($path) !== true) { throw new RuntimeException('Fayl açılmadı (düzgün .docx deyil).'); }
    $docXml = $zip->getFromName('word/document.xml');
    if ($docXml === false) { $zip->close(); throw new RuntimeException('word/document.xml tapılmadı.'); }
    $relsXml   = $zip->getFromName('word/_rels/document.xml.rels');
    $numXml    = $zip->getFromName('word/numbering.xml');
    $styleXml  = $zip->getFromName('word/styles.xml');
    $coreXml   = $zip->getFromName('docProps/core.xml');

    $W  = 'http://schemas.openxmlformats.org/wordprocessingml/2006/main';
    $R  = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships';
    $A  = 'http://schemas.openxmlformats.org/drawingml/2006/main';

    $load = function ($xml) {
      $d = new DOMDocument();
      $prev = libxml_use_internal_errors(true);
      $d->loadXML($xml, LIBXML_NONET | LIBXML_COMPACT);
      libxml_use_internal_errors($prev);
      return $d;
    };

    // əlaqələr (hiperlink və şəkil hədəfləri)
    $rels = [];
    if ($relsXml) {
      foreach ($load($relsXml)->getElementsByTagName('Relationship') as $r) {
        $rels[$r->getAttribute('Id')] = ['target' => $r->getAttribute('Target'), 'mode' => $r->getAttribute('TargetMode')];
      }
    }
    // üslub adları (styleId → ad)
    $styleNames = [];
    $styleNum   = []; // üslubun özündə siyahı (numPr) varsa: styleId → numId
    if ($styleXml) {
      foreach ($load($styleXml)->getElementsByTagNameNS($W, 'style') as $st) {
        $sid = $st->getAttributeNS($W, 'styleId');
        $nm  = $st->getElementsByTagNameNS($W, 'name')->item(0);
        $styleNames[$sid] = $nm ? strtolower($nm->getAttributeNS($W, 'val')) : '';
        $sn = $st->getElementsByTagNameNS($W, 'numId')->item(0);
        if ($sn && $sn->getAttributeNS($W, 'val') !== '0') { $styleNum[$sid] = $sn->getAttributeNS($W, 'val'); }
      }
    }
    // siyahı tipləri (numId → bullet|decimal)
    $numKinds = [];
    if ($numXml) {
      $nd = $load($numXml);
      $abs = [];
      foreach ($nd->getElementsByTagNameNS($W, 'abstractNum') as $an) {
        $lvl = $an->getElementsByTagNameNS($W, 'lvl')->item(0);
        $fmt = $lvl ? $lvl->getElementsByTagNameNS($W, 'numFmt')->item(0) : null;
        $abs[$an->getAttributeNS($W, 'abstractNumId')] = $fmt ? $fmt->getAttributeNS($W, 'val') : 'bullet';
      }
      foreach ($nd->getElementsByTagNameNS($W, 'num') as $n) {
        $ab = $n->getElementsByTagNameNS($W, 'abstractNumId')->item(0);
        $numKinds[$n->getAttributeNS($W, 'numId')] = $ab && isset($abs[$ab->getAttributeNS($W, 'val')]) ? $abs[$ab->getAttributeNS($W, 'val')] : 'bullet';
      }
    }

    $images = [];
    $imgCache = [];
    $imageHtml = function ($rid) use (&$rels, $zip, $saveImage, &$images, &$imgCache) {
      if (!isset($rels[$rid]) || !$saveImage) { return ''; }
      if (isset($imgCache[$rid])) { return $imgCache[$rid]; }
      $target = ltrim($rels[$rid]['target'], '/');
      $name   = strpos($target, 'word/') === 0 ? $target : 'word/' . $target;
      $bytes  = $zip->getFromName($name);
      if ($bytes === false) { return $imgCache[$rid] = ''; }
      $url = $saveImage(basename($name), $bytes);
      if (!$url) { return $imgCache[$rid] = ''; }
      $images[] = $url;
      return $imgCache[$rid] = '<figure><img src="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" alt=""></figure>';
    };

    $isOn = function ($el) use ($W) { // <w:b/> <w:b w:val="0"/>
      if (!$el) { return false; }
      $v = $el->getAttributeNS($W, 'val');
      return !($v === '0' || $v === 'false' || $v === 'off');
    };
    $esc = function ($t) { return htmlspecialchars($t, ENT_NOQUOTES, 'UTF-8'); };

    // bir run-ın HTML-i + plain mətni
    $runHtml = function (DOMElement $r) use ($W, $A, $R, $isOn, $esc, $imageHtml) {
      $out = ''; $plain = ''; $img = '';
      foreach ($r->childNodes as $c) {
        if (!($c instanceof DOMElement)) { continue; }
        $ln = $c->localName;
        if ($ln === 't') { $out .= $esc($c->textContent); $plain .= $c->textContent; }
        elseif ($ln === 'tab') { $out .= ' '; $plain .= ' '; }
        elseif ($ln === 'br') { $out .= '<br>'; $plain .= "\n"; }
        elseif ($ln === 'drawing' || $ln === 'pict') {
          foreach ($c->getElementsByTagNameNS($A, 'blip') as $b) { $img .= $imageHtml($b->getAttributeNS($R, 'embed')); }
        }
      }
      if ($out === '') { return ['', $plain, $img, false]; }
      $rpr = $r->getElementsByTagNameNS($W, 'rPr')->item(0);
      $bold = $rpr && $isOn($rpr->getElementsByTagNameNS($W, 'b')->item(0));
      $ital = $rpr && $isOn($rpr->getElementsByTagNameNS($W, 'i')->item(0));
      if ($bold) { $out = '<strong>' . $out . '</strong>'; }
      if ($ital) { $out = '<em>' . $out . '</em>'; }
      return [$out, $plain, $img, $bold];
    };

    // paraqraf → [html, plain, imgs, hamısı qalındmı, üslub, numId]
    $paraInfo = function (DOMElement $p) use ($W, $R, $runHtml, &$rels, $styleNames, $styleNum) {
      $html = ''; $plain = ''; $imgs = ''; $allBold = true; $hasText = false;
      $ppr = null; foreach ($p->childNodes as $c) { if ($c instanceof DOMElement && $c->localName === 'pPr') { $ppr = $c; break; } }
      $style = ''; $numId = null;
      if ($ppr) {
        $ps = $ppr->getElementsByTagNameNS($W, 'pStyle')->item(0);
        if ($ps) {
          $sid = $ps->getAttributeNS($W, 'val'); $style = strtolower($sid . ' ' . ($styleNames[$sid] ?? ''));
          if (isset($styleNum[$sid])) { $numId = $styleNum[$sid]; }
        }
        $np = $ppr->getElementsByTagNameNS($W, 'numPr')->item(0);
        if ($np) { $ni = $np->getElementsByTagNameNS($W, 'numId')->item(0); $numId = $ni ? $ni->getAttributeNS($W, 'val') : null; if ($numId === '0') { $numId = null; } }
      }
      $walk = function (DOMElement $node, $wrapLink) use (&$walk, &$html, &$plain, &$imgs, &$allBold, &$hasText, $runHtml, &$rels, $W, $R) {
        foreach ($node->childNodes as $c) {
          if (!($c instanceof DOMElement)) { continue; }
          if ($c->localName === 'r') {
            list($h, $pl, $im, $b) = $runHtml($c);
            if ($im !== '') { $imgs .= $im; }
            if ($h !== '') {
              if (trim($pl) !== '') { $hasText = true; if (!$b) { $allBold = false; } }
              $html .= $wrapLink ? '<a href="' . htmlspecialchars($wrapLink, ENT_QUOTES, 'UTF-8') . '">' . $h . '</a>' : $h;
              $plain .= $pl;
            }
          } elseif ($c->localName === 'hyperlink') {
            $rid = $c->getAttributeNS($R, 'id');
            $url = ($rid !== '' && isset($rels[$rid]) && $rels[$rid]['mode'] === 'External') ? $rels[$rid]['target'] : '';
            if ($url !== '' && !preg_match('~^(https?:|mailto:)~i', $url)) { $url = ''; }
            $walk($c, $url);
          } elseif (in_array($c->localName, ['smartTag', 'ins', 'sdt', 'sdtContent'], true)) {
            $walk($c, $wrapLink);
          }
        }
      };
      $walk($p, '');
      if ($numId === null && preg_match('~list (bullet|number)~', $style)) { $numId = 'style:' . (strpos($style, 'number') !== false ? 'decimal' : 'bullet'); }
      return ['html' => $html, 'plain' => trim($plain), 'imgs' => $imgs, 'allBold' => $hasText && $allBold, 'style' => $style, 'numId' => $numId];
    };

    $dom  = $load($docXml);
    $body = $dom->getElementsByTagNameNS($W, 'body')->item(0);
    if (!$body) { $zip->close(); throw new RuntimeException('Sənədin gövdəsi boşdur.'); }

    $title = ''; $out = ''; $excerpt = '';
    $list = null; // ['tag' => 'ul'|'ol', 'items' => []]
    $flush = function () use (&$list, &$out) {
      if ($list && $list['items']) {
        $out .= '<' . $list['tag'] . '>' . implode('', array_map(function ($i) { return '<li>' . $i . '</li>'; }, $list['items'])) . '</' . $list['tag'] . '>' . "\n";
      }
      $list = null;
    };
    $first = true;

    foreach ($body->childNodes as $node) {
      if (!($node instanceof DOMElement)) { continue; }
      if ($node->localName === 'tbl') {
        $flush();
        $rows = '';
        foreach ($node->getElementsByTagNameNS($W, 'tr') as $tr) {
          $cells = '';
          foreach ($tr->childNodes as $tc) {
            if (!($tc instanceof DOMElement) || $tc->localName !== 'tc') { continue; }
            $txt = [];
            foreach ($tc->getElementsByTagNameNS($W, 'p') as $cp) { $pi = $paraInfo($cp); if ($pi['html'] !== '') { $txt[] = $pi['html']; } }
            $cells .= '<td>' . implode('<br>', $txt) . '</td>';
          }
          $rows .= '<tr>' . $cells . '</tr>';
        }
        if ($rows !== '') { $out .= '<div class="news-table"><table>' . $rows . '</table></div>' . "\n"; }
        $first = false;
        continue;
      }
      if ($node->localName !== 'p') { continue; }
      $pi = $paraInfo($node);

      // yalnız şəkil olan paraqraf
      if ($pi['plain'] === '' && $pi['imgs'] !== '') { $flush(); $out .= $pi['imgs'] . "\n"; $first = false; continue; }
      if ($pi['plain'] === '') { continue; }

      $isTitleStyle = (bool) preg_match('~(^|\s)(title|başlıq|heading ?1)(\s|$)|^title~', $pi['style']);
      if ($title === '' && $first) {
        $short = mb_strlen($pi['plain']) <= 160;
        if ($short && ($isTitleStyle || $pi['allBold'] || preg_match('~heading~', $pi['style']) || $pi['numId'] === null)) {
          $title = preg_replace('~\s+~u', ' ', $pi['plain']);
          $first = false;
          continue;
        }
      }
      $first = false;

      if ($pi['numId'] !== null) {
        $kind = isset($numKinds[$pi['numId']]) ? $numKinds[$pi['numId']] : (strpos($pi['numId'], 'style:') === 0 ? substr($pi['numId'], 6) : 'bullet');
        $tag  = $kind !== 'bullet' ? 'ol' : 'ul';
        if (!$list || $list['tag'] !== $tag) { $flush(); $list = ['tag' => $tag, 'items' => []]; }
        $list['items'][] = $pi['html'];
        continue;
      }
      $flush();

      if (preg_match('~heading ?([1-6])~', $pi['style'], $m) || $isTitleStyle) {
        $lvl = isset($m[1]) ? (int) $m[1] : 1;
        $tag = $lvl <= 2 ? 'h2' : 'h3';
        $out .= '<' . $tag . '>' . strip_tags($pi['html'], '<a>') . '</' . $tag . '>' . "\n";
      } elseif ($pi['allBold'] && mb_strlen($pi['plain']) <= 110 && !preg_match('~[.!?]$~u', $pi['plain'])) {
        $out .= '<h3>' . strip_tags($pi['html'], '<a>') . '</h3>' . "\n";
      } else {
        $out .= '<p>' . $pi['html'] . '</p>' . "\n";
        if ($excerpt === '' && mb_strlen($pi['plain']) > 40) { $excerpt = $pi['plain']; }
      }
      if ($pi['imgs'] !== '') { $out .= $pi['imgs'] . "\n"; }
    }
    $flush();

    $date = '';
    if ($coreXml) {
      $cd = $load($coreXml);
      foreach (['created', 'modified'] as $tag) {
        $el = $cd->getElementsByTagNameNS('http://purl.org/dc/terms/', $tag)->item(0);
        if ($el && ($ts = strtotime($el->textContent)) && (int) date('Y', $ts) >= 2005) { $date = gmdate('Y-m-d H:i:s', $ts); break; }
      }
    }
    $zip->close();

    if (mb_strlen($excerpt) > 220) { $excerpt = rtrim(mb_substr($excerpt, 0, 217), " ,.;:") . '…'; }
    return ['title' => $title, 'html' => trim($out), 'excerpt' => $excerpt, 'date' => $date, 'images' => $images];
  }
}
