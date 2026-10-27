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
<div class="edde-hdr" id="siteHeader" role="banner">
  <div class="container edde-hdr__inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>

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
                    <?php if (!empty($m['map'])) : ?>
                    <button type="button" class="mega-menu__visual-box mega-menu__visual-box--btn" data-open-map>
                      <span><?php echo esc_html($m['visual'][0]); ?></span>
                      <strong><?php echo esc_html($m['visual'][1]); ?></strong>
                      <em><?php echo esc_html($m['visual'][2]); ?></em>
                      <small>Xəritədə bax →</small>
                    </button>
                    <?php else : ?>
                    <div class="mega-menu__visual-box">
                      <span><?php echo esc_html($m['visual'][0]); ?></span>
                      <strong><?php echo esc_html($m['visual'][1]); ?></strong>
                      <em><?php echo esc_html($m['visual'][2]); ?></em>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </li>
          <?php endif;
        endforeach; ?>
      </ul>
    </nav>

    <div class="edde-hdr__right">
      <?php if (function_exists('edde_lang_urls')) : $edde_lu = edde_lang_urls(); $edde_cl = edde_lang(); ?>
      <div class="lang-switch" role="group" aria-label="Language">
        <a href="<?php echo esc_url($edde_lu['az']); ?>" data-lang="az" hreflang="az"<?php echo $edde_cl === 'az' ? ' class="is-current" aria-current="true"' : ''; ?>>AZ</a>
        <a href="<?php echo esc_url($edde_lu['en']); ?>" data-lang="en" hreflang="en"<?php echo $edde_cl === 'en' ? ' class="is-current" aria-current="true"' : ''; ?>>EN</a>
      </div>
      <?php endif; ?>
      <button class="btn btn--primary" id="openConsult">Zəng istə</button>
    </div>

  </div>
</div><!-- /.edde-hdr -->

<!-- Telefon üçün ayrıca üst panel (unikal adlar: ana temanın CSS-i toxuna bilməsin) -->
<div class="emb" id="emb" role="navigation" aria-label="Menyu">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="emb__logo"><img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/logo.png" alt="EDDE Global"></a>
  <div class="emb__right">
    <?php if (function_exists('edde_lang_urls')) : ?>
    <span class="emb__lang"><a href="<?php echo esc_url($edde_lu['az']); ?>" data-lang="az"<?php echo $edde_cl === 'az' ? ' class="is-current"' : ''; ?>>AZ</a><a href="<?php echo esc_url($edde_lu['en']); ?>" data-lang="en"<?php echo $edde_cl === 'en' ? ' class="is-current"' : ''; ?>>EN</a></span>
    <?php endif; ?>
    <button type="button" class="emb__burger edde-burger" id="navToggle" aria-label="Menyu" aria-expanded="false" aria-controls="mDrawer"><span></span><span></span><span></span></button>
  </div>
</div>


<?php /* Mobil menyu: başlıqdan (backdrop-filter) KƏNARDA olmalıdır, yoxsa position:fixed başlığın içində qalıb görünmür */
$edde_cm = edde_contact(); ?>
<div class="m-drawer" id="mDrawer" aria-hidden="true">
  <div class="m-drawer__backdrop" data-drawer-close></div>
  <aside class="m-drawer__panel" role="dialog" aria-label="Menyu">
    <div class="m-drawer__top">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>
      <button type="button" class="m-drawer__close" data-drawer-close aria-label="Bağla">✕</button>
    </div>
    <nav class="m-drawer__nav" aria-label="Menyu">
      <?php foreach (edde_nav_items() as $item) :
        if (empty($item['mega'])) : ?>
          <a class="m-drawer__link" href="<?php echo edde_href($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
        <?php else : ?>
          <div class="m-acc">
            <button type="button" class="m-acc__btn" aria-expanded="false"><span><?php echo esc_html($item['title']); ?></span><i aria-hidden="true"></i></button>
            <div class="m-acc__panel">
              <?php if (strpos($item['url'], '#') !== 0 && $item['url'] !== '/#contact') : ?>
                <a class="m-acc__main" href="<?php echo edde_href($item['url']); ?>"><?php echo esc_html($item['title']); ?> <span aria-hidden="true">→</span></a>
              <?php endif; ?>
              <?php foreach ($item['mega']['links'] as $l) : ?>
                <a href="<?php echo edde_href($l[1]); ?>"<?php echo $l[1] === '#map' ? ' data-open-map' : ''; ?>><?php echo esc_html($l[0]); ?></a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif;
      endforeach; ?>
    </nav>
    <div class="m-drawer__actions">
      <button type="button" class="btn btn--primary btn--block" data-open-consult>Zəng istə</button>
      <a class="btn btn--wa btn--block" href="<?php echo esc_url(edde_wa_url()); ?>" target="_blank" rel="noopener">WhatsApp-da yazın</a>
      <a class="m-drawer__phone" href="tel:<?php echo esc_attr($edde_cm['phones'][0][1]); ?>"><span aria-hidden="true">📞</span> <?php echo esc_html($edde_cm['phones'][0][0]); ?></a>
      <a class="m-drawer__phone" href="#map" data-open-map><span aria-hidden="true">📍</span> Xəritədə bax</a>
      <?php if (!empty($edde_lu)) : ?>
      <div class="lang-switch lang-switch--lg" role="group" aria-label="Language">
        <a href="<?php echo esc_url($edde_lu['az']); ?>" data-lang="az" hreflang="az"<?php echo $edde_cl === 'az' ? ' class="is-current" aria-current="true"' : ''; ?>>AZ</a>
        <a href="<?php echo esc_url($edde_lu['en']); ?>" data-lang="en" hreflang="en"<?php echo $edde_cl === 'en' ? ' class="is-current" aria-current="true"' : ''; ?>>EN</a>
      </div>
      <?php endif; ?>
    </div>
  </aside>
</div>
