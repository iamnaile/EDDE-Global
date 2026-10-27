<?php
// Hərəkətli tərəfdaş loqoları zolağı (ana səhifə və Akkreditasiya səhifəsi). Dəyişənlər funksiya daxilində qalır.
call_user_func(function () { ?>
<!-- ============ TƏRƏFDAŞ LOQOLARI ============ -->
<?php
// assets/logos qovluğundakı bütün şəkilləri avtomatik oxuyur
$logo_dir   = get_stylesheet_directory() . '/assets/logos/';
$logo_url   = get_stylesheet_directory_uri() . '/assets/logos/';
$logo_files = glob($logo_dir . '*.{png,jpg,jpeg,webp,svg,PNG,JPG,JPEG,WEBP,SVG}', GLOB_BRACE);
$logo_files = $logo_files ? array_map('basename', $logo_files) : [];
sort($logo_files, SORT_NATURAL | SORT_FLAG_CASE);
// Eyni adlı köhnə (png/jpg) və yeni (webp) fayl yan-yana qalıbsa yalnız webp götürülür
$__seen = [];
foreach ($logo_files as $__f) { $__k = pathinfo($__f, PATHINFO_FILENAME); if (!isset($__seen[$__k]) || strtolower(pathinfo($__f, PATHINFO_EXTENSION)) === 'webp') { $__seen[$__k] = $__f; } }
$logo_files = array_values($__seen);


// Hər loqonun nisbətinə görə eyni "vizual çəki" (sahə) verən ölçü hesablanır
$logo_area = 22000;  // ümumi böyüklük: artırsanız hamısı böyüyür
$logo_maxw = 340;    // ən enli loqonun maksimum eni
$logo_maxh = 130;    // ən hündür loqonun maksimum hündürlüyü
$logo_items = [];
foreach ($logo_files as $f) {
  $path  = $logo_dir . $f;
  $ratio = 2.5;      // ölçüsü oxuna bilməyən fayllar üçün ehtiyat nisbət
  $info  = @getimagesize($path);
  if ($info && $info[1] > 0) {
    $ratio = $info[0] / $info[1];
  } elseif (strtolower(pathinfo($f, PATHINFO_EXTENSION)) === 'svg') {
    $svg = @file_get_contents($path);
    if ($svg && preg_match('/viewBox=["\']\s*[-\d.]+[\s,]+[-\d.]+[\s,]+([\d.]+)[\s,]+([\d.]+)/i', $svg, $m) && (float) $m[2] > 0) {
      $ratio = (float) $m[1] / (float) $m[2];
    }
  }
  $w = sqrt($logo_area * $ratio);
  $h = sqrt($logo_area / $ratio);
  if ($w > $logo_maxw) { $h = $h * $logo_maxw / $w; $w = $logo_maxw; }
  if ($h > $logo_maxh) { $w = $w * $logo_maxh / $h; $h = $logo_maxh; }
  $logo_items[] = ['file' => $f, 'w' => round($w), 'h' => round($h)];
}

// Zolaq boş yer qoymasın deyə az loqo olanda siyahı təkrarlanır
$logo_set = $logo_items;
while ($logo_set && count($logo_set) < 12) {
  $logo_set = array_merge($logo_set, $logo_items);
}
?>
<?php if ($logo_items) : ?>
<section class="logo-strip">
  <div class="container">
    <div class="section-head reveal">
    </div>
  </div>
  <div class="logo-strip__viewport">
    <!-- sürət loqo sayından asılı olmayaraq eyni qalsın deyə müddət sayla hesablanır -->
    <div class="logo-strip__track" style="animation-duration: <?php echo count($logo_set) * 5; ?>s;">
      <?php for ($pass = 0; $pass < 2; $pass++) :
        foreach ($logo_set as $item) :
          $alt = function_exists('edde_partner_name') ? edde_partner_name($item['file']) : pathinfo($item['file'], PATHINFO_FILENAME); ?>
          <div class="logo-strip__item" style="width: <?php echo (int) $item['w']; ?>px; height: <?php echo (int) $item['h']; ?>px;"<?php echo $pass ? ' aria-hidden="true"' : ''; ?>>
            <img src="<?php echo esc_url($logo_url . rawurlencode($item['file'])); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy">
          </div>
      <?php endforeach; endfor; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<?php });
