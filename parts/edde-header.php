<?php
/**
 * Vahid başlıq (navbar). Dəyişənlər: $edde_current — aktiv səhifənin yolu (məs. "ielts"), istəyə bağlı.
 */
require_once get_stylesheet_directory() . '/inc/edde-nav.php';
$edde_current = isset($edde_current) ? trim($edde_current, '/') : '';
$edde_is_here = function ($url) use ($edde_current) {
  return $edde_current !== '' && trim($url, '/') === $edde_current;
};
?>
<header class="site-header" id="siteHeader">
  <div class="container header__inner">
    <a href="<?php echo esc_url(home_url('/edde-home/')); ?>" class="logo"><img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>

    <nav class="main-nav" id="mainNav">
      <ul>
        <?php foreach (edde_nav_items() as $item) :
          $here = $edde_is_here($item['url']);
          if (empty($item['mega'])) : ?>
            <li><a href="<?php echo edde_href($item['url']); ?>"<?php echo $here ? ' class="is-active"' : ''; ?>><?php echo esc_html($item['title']); ?></a></li>
          <?php else :
            $m    = $item['mega'];
            $wide = count($m['links']) > 8;
            foreach ($m['links'] as $l) { if ($edde_is_here($l[1])) { $here = true; } } ?>
            <li class="has-mega">
              <a href="<?php echo edde_href($item['url']); ?>"<?php echo $here ? ' class="is-active"' : ''; ?>><?php echo esc_html($item['title']); ?></a>
              <div class="mega-menu">
                <div class="mega-menu-grid<?php echo $wide ? ' mega-menu-grid--wide' : ''; ?>">
                  <div class="mega-menu__col mega-menu__col--intro">
                    <h3><?php echo esc_html($m['heading']); ?></h3>
                    <p><?php echo esc_html($m['text']); ?></p>
                    <a href="<?php echo edde_href(isset($m['cta_url']) ? $m['cta_url'] : $item['url']); ?>" class="btn btn--primary btn--sm"><?php echo esc_html($m['cta']); ?></a>
                  </div>
                  <div class="mega-menu__col mega-menu__col--links<?php echo $wide ? ' is-long' : ''; ?>">
                    <span class="mega-menu__label"><?php echo esc_html(isset($m['label']) ? $m['label'] : 'Bu bölmədə'); ?></span>
                    <?php foreach ($m['links'] as $link) : ?>
                      <a href="<?php echo edde_href($link[1]); ?>"><?php echo esc_html($link[0]); ?> <span>→</span></a>
                    <?php endforeach; ?>
                  </div>
                  <div class="mega-menu__col mega-menu__col--visual">
                    <div class="mega-menu__visual-box">
                      <span><?php echo esc_html($m['visual'][0]); ?></span>
                      <strong><?php echo esc_html($m['visual'][1]); ?></strong>
                      <em><?php echo esc_html($m['visual'][2]); ?></em>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          <?php endif;
        endforeach; ?>
      </ul>
    </nav>

    <div class="header__right">
      <button class="btn btn--primary" id="openConsult">Zəng istə</button>
    </div>

    <button class="nav-toggle" id="navToggle" aria-label="Menyu"><span></span><span></span><span></span></button>
  </div>
</header>
