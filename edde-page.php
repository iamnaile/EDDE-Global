<?php
/**
 * Template Name: EDDE Məzmun Səhifəsi
 *
 * Haqqımızda, Xaricdə təhsil, EDDE Academy, Yazılar, FAQ, Əlaqə və digər bütün naviqasiya səhifələri üçün vahid şablon.
 * Mətnlər inc/data/pages.php (səhifələr), articles.php (məqalələr), faq.php və countries.php fayllarındadır.
 * functions.php həmin açarlara uyğun ünvanlarda bu şablonu avtomatik işə salır.
 */

$edde_route = edde_current_route();
$edde_pg       = edde_route_page($edde_route);

if (!$edde_pg) {
  status_header(404);
  $edde_pg = [
    'route' => '', 'kind' => 'page', 'title' => 'Səhifə tapılmadı', 'group' => 'EDDE Global', 'icon' => '🔎',
    'meta'  => 'Axtardığınız səhifə tapılmadı.',
    'lead'  => 'Axtardığınız səhifə tapılmadı və ya köçürülüb. Aşağıdakı bölmələrdən birinə keçə bilərsiniz.',
    'blocks' => [['links', [
      ['Xaricdə təhsil', '/xaricde-tehsil/', 'Foundation-dan doktoranturaya qədər bütün proqramlar.'],
      ['EDDE Academy', '/edde-xidmetler/', 'Dil kursları və beynəlxalq imtahan hazırlığı.'],
      ['Əlaqə', '/elaqe/', 'Pulsuz konsultasiya üçün bizimlə əlaqə saxlayın.'],
    ]]],
    'cta' => 'Bizimlə əlaqə saxlayın', 'cta_course' => '404',
  ];
  $edde_route = '';
}

$theme_uri = get_stylesheet_directory_uri();
$is_article = $edde_pg['kind'] === 'article';
$article    = $is_article ? $edde_pg['article'] : null;
$cta_title  = isset($edde_pg['cta']) ? $edde_pg['cta'] : 'Pulsuz konsultasiya';
$cta_course = isset($edde_pg['cta_course']) ? $edde_pg['cta_course'] : $edde_pg['title'];
$edde_c     = edde_contact();
$wa_number  = $edde_c['whatsapp'];

/* ------------------------------ köməkçi çıxış funksiyaları ------------------------------ */
$e = function ($t) { echo esc_html($t); };

$render_list_item = function ($it) {
  if (is_array($it)) {
    echo '<li><strong>' . esc_html($it[0]) . ':</strong> ' . esc_html($it[1]) . '</li>';
  } else {
    echo '<li>' . esc_html($it) . '</li>';
  }
};

$render_blocks = function ($blocks) use ($e, $render_list_item, $theme_uri, $wa_number, $edde_c) {
  foreach ($blocks as $b) {
    switch ($b[0]) {
      case 'h':
        echo '<h2 class="epage-h2">'; $e($b[1]); echo '</h2>';
        break;
      case 'h3':
        echo '<h3 class="epage-h3">'; $e($b[1]); echo '</h3>';
        break;
      case 'p':
        echo '<p>'; $e($b[1]); echo '</p>';
        break;
      case 'ul':
        echo '<ul class="epage-list">';
        foreach ($b[1] as $it) { $render_list_item($it); }
        echo '</ul>';
        break;
      case 'cards':
        echo '<div class="epage-cards">';
        foreach ($b[1] as $c) {
          echo '<div class="epage-card"><h3>'; $e($c[0]); echo '</h3><p>'; $e($c[1]); echo '</p></div>';
        }
        echo '</div>';
        break;
      case 'steps':
        echo '<div class="svc-stages epage-steps">';
        foreach ($b[1] as $i => $s) {
          echo '<div class="svc-stages__item"><div class="svc-stages__num">' . ($i + 1) . '</div><div><h3>';
          $e($s[0]); echo '</h3><p>'; $e($s[1]); echo '</p></div></div>';
        }
        echo '</div>';
        break;
      case 'stats':
        echo '<div class="epage-stats">';
        foreach ($b[1] as $s) {
          echo '<div class="epage-stat"><strong>'; $e($s[0]); echo '</strong><span>'; $e($s[1]); echo '</span></div>';
        }
        echo '</div>';
        break;
      case 'facts':
        echo '<div class="epage-facts">';
        foreach ($b[1] as $f) {
          echo '<div class="epage-fact"><span>'; $e($f[0]); echo '</span><strong>'; $e($f[1]); echo '</strong></div>';
        }
        echo '</div>';
        break;
      case 'note':
        echo '<div class="epage-note">'; $e($b[1]); echo '</div>';
        break;
      case 'tags':
        echo '<div class="epage-tags">';
        foreach ($b[1] as $t) { echo '<span>'; $e($t); echo '</span>'; }
        echo '</div>';
        break;
      case 'quotes':
        echo '<div class="epage-quotes">';
        foreach ($b[1] as $q) {
          echo '<figure class="epage-quote"><blockquote>“'; $e($q[0]); echo '”</blockquote><figcaption><strong>';
          $e($q[1]); echo '</strong><span>'; $e($q[2]); echo '</span></figcaption></figure>';
        }
        echo '</div>';
        break;
      case 'links':
        echo '<div class="epage-links">';
        foreach ($b[1] as $l) {
          echo '<a class="epage-link" href="' . edde_href($l[1]) . '"><strong>'; $e($l[0]); echo '</strong><span>'; $e($l[2]); echo '</span><em>Ətraflı →</em></a>';
        }
        echo '</div>';
        break;
      case 'mail':
        echo '<p><a class="btn btn--primary" href="mailto:' . esc_attr($b[1]) . '">'; $e($b[2]); echo '</a></p>';
        break;
      case 'contact': ?>
        <div class="epage-contact">
          <div class="epage-contact__card"><span>📞 Telefon</span>
            <?php foreach ($edde_c['phones'] as $p) : ?>
            <a href="tel:<?php echo esc_attr($p[1]); ?>"><?php echo esc_html($p[0]); ?></a>
            <?php endforeach; ?>
          </div>
          <div class="epage-contact__card"><span>💬 WhatsApp</span>
            <a href="<?php echo esc_url(edde_wa_url()); ?>" target="_blank" rel="noopener">WhatsApp-da yazın</a>
          </div>
          <div class="epage-contact__card"><span>✉️ E-poçt</span>
            <a href="mailto:<?php echo esc_attr($edde_c['email']); ?>"><?php echo esc_html($edde_c['email']); ?></a>
          </div>
          <div class="epage-contact__card"><span>📍 Ünvan</span>
            <p><?php echo esc_html($edde_c['address']); ?></p>
            <a href="https://g.page/edde-global?share" target="_blank" rel="noopener">Xəritədə aç</a>
          </div>
        </div>
        <div class="epage-map">
          <iframe title="EDDE Global ofisi" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                  src="https://www.google.com/maps?q=<?php echo rawurlencode($edde_c['map_query']); ?>&amp;output=embed"></iframe>
        </div>
        <?php break;
      case 'social': ?>
        <div class="epage-tags epage-tags--links">
          <a href="https://www.facebook.com/eddeglobalaz" target="_blank" rel="noopener">Facebook</a>
          <a href="https://www.instagram.com/eddeglobal/" target="_blank" rel="noopener">Instagram</a>
          <a href="https://www.linkedin.com/company/edde-global/" target="_blank" rel="noopener">LinkedIn</a>
          <a href="https://www.youtube.com/@eddeglobal6894" target="_blank" rel="noopener">YouTube</a>
        </div>
        <?php break;
      case 'faq':
        $faq = edde_data('faq'); ?>
        <div class="epage-faqsearch"><input type="search" id="faqSearch" placeholder="Sualı axtarın…" aria-label="FAQ-da axtar"></div>
        <div class="accordion epage-faq" id="accordion">
          <?php foreach ($faq as $i => $qa) : ?>
            <div class="accordion-item">
              <button class="accordion-trigger"><?php echo ($i + 1) . '. ' . esc_html($qa[0]); ?></button>
              <div class="accordion-panel"><p><?php echo esc_html($qa[1]); ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="epage-faqempty" id="faqEmpty" hidden>Heç bir sual tapılmadı. Sualınızı aşağıdakı formadan bizə yaza bilərsiniz.</p>
        <?php break;
      case 'articles':
        $list = edde_articles_by_type($b[1]);
        echo '<div class="epage-articles">';
        foreach ($list as $slug => $a) {
          $url = home_url('/' . edde_article_base($a['type']) . '/' . $slug . '/');
          echo '<a class="epage-article" href="' . esc_url($url) . '"><time>'; $e($a['date']); echo '</time><h3>'; $e($a['title']);
          echo '</h3><p>'; $e(edde_excerpt($a['blocks'], 180)); echo '</p><em>Oxu →</em></a>';
        }
        echo '</div>';
        break;
      case 'countries':
        $countries = edde_data('countries'); ?>
        <div class="epage-ctabs" role="tablist" aria-label="Ölkələr">
          <?php foreach ($countries as $i => $c) : ?>
            <button type="button" class="epage-ctab<?php echo $i === 0 ? ' is-on' : ''; ?>" role="tab" data-target="<?php echo esc_attr($c['slug']); ?>">
              <img src="https://flagcdn.com/w40/<?php echo esc_attr($c['flag']); ?>.png" alt="" width="22" height="16" loading="lazy"><?php $e($c['name']); ?>
            </button>
          <?php endforeach; ?>
        </div>
        <?php foreach ($countries as $i => $c) : ?>
          <section class="epage-cpanel" id="<?php echo esc_attr($c['slug']); ?>" data-panel>
            <h2 class="epage-h2"><?php echo esc_html($c['emoji'] . ' ' . $c['name']); ?> — <?php echo edde_lang() === 'en' ? 'leading universities' : 'aparıcı universitetlər'; ?></h2>
            <div class="epage-unis">
              <?php foreach ($c['unis'] as $u) : ?>
                <article class="epage-uni">
                  <header><h3><?php $e($u['name']); ?></h3><span><?php $e($u['city']); ?></span></header>
                  <p><?php $e($u['text']); ?></p>
                  <a class="epage-uni__cta" href="#epage-form" data-interest="<?php echo esc_attr($u['name']); ?>">Bu universitet üçün məsləhət al →</a>
                </article>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach;
        break;
      case 'html':
        echo wp_kses_post($b[1]);
        break;
      case 'partners':
        echo '<div class="epage-partners">';
        foreach (edde_partner_logos() as $lg) {
          echo '<img src="' . esc_url($lg['url']) . '" alt="' . esc_attr($lg['name']) . '" title="' . esc_attr($lg['name']) . '" width="170" height="170" loading="lazy">';
        }
        echo '</div>';
        break;
    }
  }
};

/* ------------------------------ yan panel ------------------------------ */
list($aside_title, $aside_rows) = edde_aside_links($edde_route);

/* ------------------------------ digər yazılar (məqalə səhifəsində) ------------------------------ */
$more = [];
if ($is_article) {
  foreach (edde_articles_by_type($article['type']) as $slug => $a) {
    if ($slug !== $article['slug'] && count($more) < 3) { $more[$slug] = $a; }
  }
}

$edde_current = $edde_route;
require_once get_stylesheet_directory() . '/inc/edde-news-ui.php';
$edde_news_mode = $is_article ? 'article' : (in_array($edde_route, ['meqaleler', 'mediada-biz'], true) ? 'index' : '');
$page_title   = $edde_pg['title'] . ' — EDDE Global';
$crumb_group  = $is_article
  ? [$article['type'] === 'media' ? 'Mediada biz' : 'Məqalələr', '/' . edde_article_base($article['type']) . '/']
  : null;
?>
<!DOCTYPE html>
<html lang="az" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light dark">
<meta name="theme-color" content="#7817B6">
<title><?php echo esc_html($page_title); ?></title>
<meta name="description" content="<?php echo esc_attr($edde_pg['meta']); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo esc_url(edde_asset('edde-styles.css')); ?>">
<link rel="stylesheet" href="<?php echo esc_url(edde_asset('edde-pages.css')); ?>">
<link rel="stylesheet" href="<?php echo esc_url(edde_asset('edde-news.css')); ?>">
<?php if ($edde_route === 'faq') : ?>
<script type="application/ld+json"><?php
  $ld = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => []];
  foreach (edde_data('faq') as $qa) {
    $ld['mainEntity'][] = ['@type' => 'Question', 'name' => $qa[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $qa[1]]];
  }
  echo wp_json_encode($ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?></script>
<?php endif; ?>
</head>
<body <?php body_class('edde-page edde-content-page'); ?>>
<?php include get_stylesheet_directory() . '/parts/edde-preloader.php'; ?>
  <div class="page-bg" style="background-image:url('<?php echo esc_url($theme_uri); ?>/assets/bg-home.jpg');"></div>
<div class="page-bg-overlay"></div>
<div class="page-content">

<?php include get_stylesheet_directory() . '/parts/edde-header.php'; ?>

<!-- ============ BREADCRUMB ============ -->
<div class="svc-breadcrumb">
  <div class="container">
    <a href="<?php echo esc_url(home_url('/')); ?>">Ana səhifə</a> /
    <?php if ($crumb_group) : ?>
      <a href="<?php echo esc_url(home_url($crumb_group[1])); ?>"><?php $e($crumb_group[0]); ?></a> /
    <?php elseif (!empty($edde_pg['group']) && $edde_pg['group'] !== $edde_pg['title']) : ?>
      <span class="epage-crumb-group"><?php $e($edde_pg['group']); ?></span> /
    <?php endif; ?>
    <span><?php echo esc_html(mb_strlen($edde_pg['title']) > 60 ? mb_substr($edde_pg['title'], 0, 57) . '…' : $edde_pg['title']); ?></span>
  </div>
</div>

<?php if ($edde_news_mode === 'index') : edde_news_include('index', compact('edde_route')); ?>
<?php elseif ($edde_news_mode === 'article') : edde_news_include('article', compact('article', 'render_blocks', 'edde_pg', 'e')); ?>
<?php else : ?>
<!-- ============ HERO ============ -->
<section class="epage-hero">
  <div class="container epage-hero__inner">
    <p class="epage-eyebrow"><?php echo esc_html(($edde_pg['icon'] ?? '') . ' ' . ($is_article ? ($article['type'] === 'media' ? 'Mediada biz' : 'Məqalə') : $edde_pg['group'])); ?></p>
    <h1><?php $e($edde_pg['title']); ?></h1>
    <?php if ($is_article) : ?>
      <p class="epage-meta"><time><?php $e($article['date']); ?></time><?php if (!empty($article['source'])) : ?> · <a href="<?php echo esc_url($article['source']); ?>" target="_blank" rel="noopener nofollow">Mənbə</a><?php endif; ?></p>
    <?php elseif (!empty($edde_pg['lead'])) : ?>
      <p class="epage-lead"><?php $e($edde_pg['lead']); ?></p>
    <?php endif; ?>
    <?php if (!$is_article) : ?>
    <div class="epage-hero__actions">
      <a href="#epage-form" class="btn btn--primary">Pulsuz konsultasiya</a>
      <a href="<?php echo esc_url(edde_wa_url()); ?>" class="btn btn--outline" target="_blank" rel="noopener">WhatsApp-da yazın</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ============ MƏZMUN ============ -->
<section class="epage-main">
  <div class="container epage-layout">
    <article class="epage-content">
      <?php $render_blocks($edde_pg['blocks']); ?>

      <?php if ($is_article && $more) : ?>
        <h2 class="epage-h2">Digər yazılar</h2>
        <div class="epage-articles">
          <?php foreach ($more as $slug => $a) : ?>
            <a class="epage-article" href="<?php echo esc_url(home_url('/' . edde_article_base($a['type']) . '/' . $slug . '/')); ?>">
              <time><?php $e($a['date']); ?></time><h3><?php $e($a['title']); ?></h3><p><?php $e(edde_excerpt($a['blocks'], 120)); ?></p><em>Oxu →</em>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </article>

    <aside class="epage-aside">
      <div class="epage-aside__card">
        <h4><?php $e($aside_title); ?></h4>
        <nav>
          <?php foreach ($aside_rows as $row) : ?>
            <a href="<?php echo edde_href($row[1]); ?>"<?php echo $row[2] ? ' class="is-current" aria-current="page"' : ''; ?>><?php $e($row[0]); ?></a>
          <?php endforeach; ?>
        </nav>
      </div>
      <div class="epage-aside__card epage-aside__card--cta">
        <h4>Pulsuz konsultasiya</h4>
        <p>Məsləhətçilərimiz sizə uyğun ölkə, universitet və proqramı seçməkdə kömək edəcək.</p>
        <a href="#epage-form" class="btn btn--light btn--block">Müraciət et</a>
        <a class="epage-aside__phone" href="tel:<?php echo esc_attr($edde_c['phones'][0][1]); ?>"><?php echo esc_html($edde_c['phones'][0][0]); ?></a>
      </div>
    </aside>
  </div>
</section>
<?php if ($edde_route === 'akkreditasiya') { include get_stylesheet_directory() . '/parts/edde-logo-strip.php'; } ?>
<?php endif; ?>

<!-- ============ MÜRACİƏT FORMASI ============ -->
<section class="svc-form-section" id="epage-form">
  <div class="container svc-form__inner">
    <div class="svc-form__text">
      <p class="epage-eyebrow">Əlaqə</p>
      <h2><?php $e($cta_title); ?></h2>
      <p>Məlumatlarınızı qeyd edin — məsləhətçimiz sizinlə əlaqə saxlayıb bütün suallarınızı cavablandıracaq.</p>
      <div class="svc-form__contact">
        <?php foreach ($edde_c['phones'] as $p) : ?>
        <div>📞 <a href="tel:<?php echo esc_attr($p[1]); ?>"><?php echo esc_html($p[0]); ?></a></div>
        <?php endforeach; ?>
        <div>✉️ <a href="mailto:<?php echo esc_attr($edde_c['email']); ?>"><?php echo esc_html($edde_c['email']); ?></a></div>
        <div>📍 <?php echo esc_html($edde_c['address']); ?></div>
      </div>
    </div>
    <form class="svc-form epage-form" data-course="<?php echo esc_attr($cta_course); ?>">
      <div class="svc-form__row">
        <input type="text" name="name" placeholder="Ad" required>
        <input type="text" name="surname" placeholder="Soyad" required>
      </div>
      <div class="svc-form__row">
        <input type="email" name="email" placeholder="E-poçt" required>
        <input type="tel" name="phone" placeholder="Telefon nömrəsi" required>
      </div>
      <textarea name="message" rows="3" placeholder="Hədəfləriniz və ya sualınız (istəyə bağlı)"></textarea>
      <label class="svc-form__check">
        <input type="checkbox" required>
        <span><a href="<?php echo esc_url(home_url('/mexfilik-siyaseti/')); ?>">Məxfilik siyasəti</a> ilə razıyam və müraciətimlə bağlı mənimlə əlaqə saxlanılmasına icazə verirəm.</span>
      </label>
      <button type="submit" class="btn btn--primary btn--block">Müraciəti göndər</button>
    </form>
  </div>
</section>

<?php include get_stylesheet_directory() . '/parts/edde-footer.php'; ?>

<script src="<?php echo esc_url(edde_asset('edde-script.js')); ?>"></script>
<script src="<?php echo esc_url(edde_asset('edde-pages.js')); ?>"></script>
<?php wp_footer(); ?>
</div>
</body>
</html>
