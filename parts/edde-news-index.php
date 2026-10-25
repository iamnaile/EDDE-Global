<?php
/** Yazılar (xəbər) siyahısı: /meqaleler/ və /mediada-biz/. edde-page.php-dən çağırılır. */

$all   = edde_news_all();
$cat   = isset($_GET['cat']) ? sanitize_key($_GET['cat']) : ($edde_route === 'mediada-biz' ? 'media' : 'all');
if (!in_array($cat, ['all', 'meqale', 'media'], true)) { $cat = 'all'; }
$q     = isset($_GET['q']) ? trim(wp_unslash($_GET['q'])) : '';
$pg    = isset($_GET['pg']) ? max(1, (int) $_GET['pg']) : 1;
$base  = home_url('/meqaleler/');

$items = array_values(array_filter($all, function ($a) use ($cat, $q) {
  if ($cat !== 'all' && $a['type'] !== $cat) { return false; }
  if ($q !== '' && mb_stripos($a['title'] . ' ' . $a['excerpt'], $q) === false) { return false; }
  return true;
}));
$counts = ['all' => count($all), 'meqale' => 0, 'media' => 0];
foreach ($all as $a) { $counts[$a['type']]++; }

$per      = 12;
$hasFeat  = ($q === '' && count($items) >= 4);          // ilk 4 yazı yalnız 1-ci səhifədə "böyük" blokda
$featured = ($hasFeat && $pg === 1) ? array_slice($items, 0, 4) : [];
$pool     = $hasFeat ? array_slice($items, 4) : $items;  // qalanları səhifələnir
$pages    = max(1, (int) ceil(count($pool) / $per));
$pg       = min($pg, $pages);
$slice    = array_slice($pool, ($pg - 1) * $per, $per);

$tabs = [['all', 'Hamısı'], ['meqale', 'Məqalələr'], ['media', 'Mediada biz']];
$link = function ($args) use ($base) {
  $args = array_filter($args, function ($v) { return $v !== '' && $v !== null && $v !== 'all' && $v !== 1; });
  return esc_url(add_query_arg($args, $base));
};
?>
<section class="news-head">
  <div class="news-wrap">
    <p class="news-kicker">EDDE Global</p>
    <h1>Yazılar və xəbərlər</h1>
    <p class="news-sub">Xaricdə təhsil, viza, təqaüd və dil imtahanları barədə məqalələr, habelə mediada çıxışlarımız.</p>
    <div class="news-bar">
      <nav class="news-tabs" aria-label="Bölmələr">
        <?php foreach ($tabs as $t) : ?>
          <a href="<?php echo $link(['cat' => $t[0], 'q' => $q]); ?>" class="<?php echo $cat === $t[0] ? 'is-on' : ''; ?>"><?php echo esc_html($t[1]); ?> <span><?php echo (int) $counts[$t[0]]; ?></span></a>
        <?php endforeach; ?>
      </nav>
      <form class="news-search" method="get" action="<?php echo esc_url($base); ?>" role="search">
        <?php if ($cat !== 'all') : ?><input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>"><?php endif; ?>
        <input type="search" name="q" value="<?php echo esc_attr($q); ?>" placeholder="Yazılarda axtar" aria-label="Yazılarda axtar">
        <button type="submit" aria-label="Axtar">🔍</button>
      </form>
    </div>
  </div>
</section>

<section class="news-main">
  <div class="news-wrap">
    <?php if (!$items) : ?>
      <p class="news-empty">Heç bir yazı tapılmadı.</p>
    <?php else : ?>

      <?php if ($featured) : ?>
        <div class="news-featured">
          <?php echo edde_news_card($featured[0], 'hero'); ?>
          <div class="news-featured__side">
            <?php foreach (array_slice($featured, 1) as $a) { echo edde_news_card($a, 'row'); } ?>
          </div>
        </div>
        <h2 class="news-sec">Son yazılar</h2>
      <?php endif; ?>

      <div class="news-grid">
        <?php foreach ($slice as $a) { echo edde_news_card($a, 'grid'); } ?>
      </div>

      <?php if ($pages > 1) : ?>
        <nav class="news-pager" aria-label="Səhifələr">
          <?php for ($i = 1; $i <= $pages; $i++) : ?>
            <a href="<?php echo $link(['cat' => $cat, 'q' => $q, 'pg' => $i]); ?>" class="<?php echo $i === $pg ? 'is-on' : ''; ?>"><?php echo $i; ?></a>
          <?php endfor; ?>
        </nav>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
