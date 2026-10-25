<?php
/** Tək yazı səhifəsi (geniş oxu düzümü). edde-page.php-dən çağırılır: $article, $render_blocks, $edde_pg, $e. */

$type    = $article['type'] === 'media' ? 'media' : 'meqale';
$all     = edde_news_all();
$related = [];
foreach ($all as $slug => $a) {
  if ($slug !== $article['slug'] && count($related) < 3 && ($a['type'] === $article['type'] || count($all) < 8)) { $related[$slug] = $a; }
}
if (count($related) < 3) { foreach ($all as $slug => $a) { if ($slug !== $article['slug'] && !isset($related[$slug]) && count($related) < 3) { $related[$slug] = $a; } } }
$full = isset($all[$article['slug']]) ? $all[$article['slug']] : $article;
?>
<article class="news-article">
  <header class="news-art-head">
    <div class="news-wrap news-wrap--read">
      <div class="ncard__meta">
        <a class="ncard__chip ncard__chip--<?php echo $type; ?>" href="<?php echo esc_url(home_url('/' . edde_article_base($article['type']) . '/')); ?>"><?php echo esc_html(edde_news_label($article['type'])); ?></a>
        <time><?php $e($article['date']); ?></time>
        <?php if (!empty($full['words'])) : ?><span class="ncard__min"><?php echo (int) edde_news_minutes($full) . (edde_lang() === 'en' ? ' min read' : ' dəq. oxu'); ?></span><?php endif; ?>
      </div>
      <h1><?php $e($article['title']); ?></h1>
      <?php if (!empty($full['excerpt'])) : ?><p class="news-art-lead"><?php $e(mb_strimwidth($full['excerpt'], 0, 260, '…', 'UTF-8')); ?></p><?php endif; ?>
    </div>
  </header>

  <?php if (!empty($full['image'])) : ?>
    <figure class="news-art-cover"><img src="<?php echo esc_url($full['image']); ?>" alt="<?php echo esc_attr($article['title']); ?>"></figure>
  <?php endif; ?>

  <div class="news-wrap news-wrap--read">
    <div class="news-body">
      <?php $render_blocks($edde_pg['blocks']); ?>
    </div>
    <?php if (!empty($article['source'])) : ?>
      <p class="news-source">Mənbə: <a href="<?php echo esc_url($article['source']); ?>" target="_blank" rel="noopener nofollow"><?php echo esc_html(parse_url($article['source'], PHP_URL_HOST)); ?> ↗</a></p>
    <?php endif; ?>
  </div>
</article>

<?php if ($related) : ?>
<section class="news-main news-related">
  <div class="news-wrap">
    <h2 class="news-sec">Digər yazılar</h2>
    <div class="news-grid">
      <?php foreach ($related as $a) { echo edde_news_card($a, 'grid'); } ?>
    </div>
  </div>
</section>
<?php endif; ?>
