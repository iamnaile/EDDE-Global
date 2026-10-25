<?php
/**
 * Saytın giriş ekranı (preloader): "[ EDDE Global  <dəyişən sözlər> ]".
 * Novo temasının "Preloader" ayarlarından (Theme Options) oxunur — canlı saytdakı ilə eynidir, sözləri oradan dəyişmək olar.
 * Tema funksiyaları yoxdursa (məs. tema deyişib), eyni görünüşlü ehtiyat variant göstərilir.
 */
$edde_pl_show   = function_exists('yprm_get_theme_setting') ? yprm_get_theme_setting('preloader_show') : 'true';
$edde_pl_type   = function_exists('yprm_get_theme_setting') ? yprm_get_theme_setting('preloader_type') : 'words';
$edde_pl_static = function_exists('yprm_get_theme_setting') ? yprm_get_theme_setting('preloader_static_word') : '';
$edde_pl_img    = function_exists('yprm_get_theme_setting') ? yprm_get_theme_setting('preloader_img') : null;

if ($edde_pl_show === 'true' && $edde_pl_type === 'words' && !empty($edde_pl_static)) :
  $edde_pl_words = [];
  for ($i = 1; $i <= 5; $i++) {
    $w = yprm_get_theme_setting('preloader_dinamic_word_' . $i);
    if ($w) { $edde_pl_words[] = '<li class="preloader_content__container__list__item">' . strip_tags($w) . '</li>'; }
  } ?>
<div class="preloader">
  <div class="preloader_content">
    <div class="preloader_content__container">
      <p class="preloader_content__container__text"><?php echo do_shortcode($edde_pl_static); ?></p>
      <?php if ($edde_pl_words) : ?>
        <ul class="preloader_content__container__list count_<?php echo count($edde_pl_words); ?>"><?php echo do_shortcode(wp_kses_post(implode('', $edde_pl_words))); ?></ul>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php elseif ($edde_pl_show === 'true' && $edde_pl_type === 'image' && !empty($edde_pl_img['background-image'])) : ?>
<div class="preloader"><div class="preloader_img"><img src="<?php echo esc_url($edde_pl_img['background-image']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>"></div></div>
<?php elseif (!function_exists('yprm_get_theme_setting')) : ?>
<div class="edde-intro" id="eddeIntro" aria-hidden="true">
  <div class="edde-intro__box">
    <span class="edde-intro__br">[</span>
    <strong>EDDE Global</strong>
    <ul><li>Xaricdə təhsil</li><li>Dil kursları</li><li>Təqaüd proqramları</li></ul>
    <span class="edde-intro__br">]</span>
  </div>
</div>
<style>
.edde-intro { position: fixed; inset: 0; z-index: 99999; background: #fff; display: flex; align-items: center; justify-content: center; transition: opacity .5s ease; }
.edde-intro.is-hidden { opacity: 0; pointer-events: none; }
.edde-intro__box { display: flex; align-items: center; gap: 14px; font: 700 28px/1 Arial, sans-serif; color: #111; }
.edde-intro__br { color: #b58ad0; font-size: 44px; font-weight: 300; }
.edde-intro ul { list-style: none; margin: 0; padding: 0; height: 1em; overflow: hidden; }
.edde-intro li { height: 1em; animation: eddeIntroWord 6s infinite; }
@keyframes eddeIntroWord { 0%,28% { transform: translateY(0); } 33%,61% { transform: translateY(-100%); } 66%,95% { transform: translateY(-200%); } 100% { transform: translateY(-300%); } }
</style>
<script>
(function () {
  var el = document.getElementById('eddeIntro');
  function hide() { if (el) { el.classList.add('is-hidden'); setTimeout(function () { if (el.parentNode) { el.parentNode.removeChild(el); } }, 600); } }
  window.addEventListener('load', function () { setTimeout(hide, 2400); });
  setTimeout(hide, 8000);
})();
</script>
<?php endif; ?>
