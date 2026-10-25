<?php
/** Vahid altlıq + üzən WhatsApp düyməsi + "Zəng istə" modalı. */
require_once get_stylesheet_directory() . '/inc/edde-contact.php';
$edde_theme_uri = get_stylesheet_directory_uri();
$edde_c = edde_contact();
?>
<script>window.EDDE_WA = <?php echo wp_json_encode($edde_c['whatsapp']); ?>; window.EDDE_LANG = <?php echo wp_json_encode(function_exists('edde_lang') ? edde_lang() : 'az'); ?>;</script>
<footer class="site-footer" id="contact">
  <div class="container footer__grid">
    <div class="footer__col footer__col--brand">
      <a href="<?php echo esc_url(home_url('/edde-home/')); ?>" class="logo logo--light"><img src="<?php echo esc_url($edde_theme_uri); ?>/assets/logo.png" alt="EDDE Global" class="logo-img"></a>
      <p>2018-ci ildən bəri tələbələrin xaricdə təhsil arzularını gerçəkləşdirməsinə kömək edən etibarlı təhsil şirkəti.</p>
      <div class="footer__social">
        <a href="https://www.facebook.com/eddeglobalaz">Facebook</a>
        <a href="https://www.instagram.com/eddeglobal/">Instagram</a>
        <a href="https://www.linkedin.com/company/edde-global/">LinkedIn</a>
        <a href="https://www.youtube.com/@eddeglobal6894">YouTube</a>
      </div>
    </div>
    <div class="footer__col footer__col--links">
      <h4>Xaricdə təhsil</h4>
      <a href="<?php echo esc_url(home_url('/foundation/')); ?>">Foundation Təhsili</a>
      <a href="<?php echo esc_url(home_url('/bakalavr/')); ?>">Bakalavr</a>
      <a href="<?php echo esc_url(home_url('/magistratura/')); ?>">Magistratura</a>
      <a href="<?php echo esc_url(home_url('/doktorantura/')); ?>">Doktorantura</a>
      <a href="<?php echo esc_url(home_url('/teqaud/')); ?>">Təqaüd Proqramları</a>
      <a href="<?php echo esc_url(home_url('/olkeler/')); ?>">Ölkələr və universitetlər</a>
    </div>
    <div class="footer__col footer__col--links">
      <h4>EDDE Academy</h4>
      <a href="<?php echo esc_url(home_url('/dil-kurslari/')); ?>">Dil kursları</a>
      <a href="<?php echo esc_url(home_url('/imtahana-hazirlik-kurslari/')); ?>">İmtahana hazırlıq kursları</a>
      <a href="<?php echo esc_url(home_url('/ielts/')); ?>">IELTS</a>
      <a href="<?php echo esc_url(home_url('/toefl/')); ?>">TOEFL</a>
      <a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a>
    </div>
    <div class="footer__col footer__col--links">
      <h4>Əlaqə</h4>
      <?php foreach ($edde_c['phones'] as $p) : ?>
        <a href="tel:<?php echo esc_attr($p[1]); ?>"><?php echo esc_html($p[0]); ?></a>
      <?php endforeach; ?>
      <a href="mailto:<?php echo esc_attr($edde_c['email']); ?>"><?php echo esc_html($edde_c['email']); ?></a>
      <span><?php echo esc_html($edde_c['address']); ?></span>
    </div>
  </div>
  <div class="container footer__bottom">
    <span>© 2018–2026 EDDE Global.<br>Site by: Naila.</span>
    <div class="footer__bottom-right">
      <?php
      // ICEF akkreditasiya nişanı: assets/icef-badge.png (png/webp/svg) varsa o göstərilir (hər domendə işləyir);
      // yoxdursa ICEF-in öz skripti (yalnız qeydiyyatlı domendə görünür), o da görünməzsə ehtiyat loqo.
      $edde_icef_file = '';
      foreach (['png', 'webp', 'svg', 'jpg'] as $ext) {
        if (is_readable(get_stylesheet_directory() . '/assets/icef-badge.' . $ext)) { $edde_icef_file = 'icef-badge.' . $ext; break; }
      }
      ?>
      <?php if ($edde_icef_file) : ?>
        <a class="footer__icef footer__icef--img" href="https://www.icef.com/agency/0016M00002HWsLdQAL" target="_blank" rel="noopener" title="ICEF Accredited Agency #5105">
          <img src="<?php echo esc_url($edde_theme_uri . '/assets/' . $edde_icef_file); ?>" alt="ICEF Accredited Agency #5105" loading="lazy">
        </a>
      <?php else : ?>
      <div class="footer__icef">
        <span id="iasBadge" data-account-id="5105"></span>
        <script async defer crossorigin="anonymous" src="https://www-cdn.icef.com/scripts/iasbadgeid.js"></script>
        <script>
          /* ICEF skripti nişanı göstərmirsə (domen qeydiyyatsızdır, bloklanıb), ehtiyat loqo göstərilir */
          window.addEventListener('load', function () {
            setTimeout(function () {
              var b = document.getElementById('iasBadge');
              if (b && (b.offsetHeight < 24 || b.offsetWidth < 24)) {
                b.innerHTML = '<a href="https://www.icef.com/agency/0016M00002HWsLdQAL" target="_blank" rel="noopener"><img src="<?php echo esc_url($edde_theme_uri); ?>/assets/logos/06-icef.png" alt="ICEF Accredited Agency #5105"></a>';
              }
            }, 3500);
          });
        </script>
      </div>
      <?php endif; ?>
      <a href="<?php echo esc_url(home_url('/mexfilik-siyaseti/')); ?>">Məxfilik siyasəti</a>
    </div>
  </div>
</footer>

<a href="<?php echo esc_url(edde_wa_url()); ?>" target="_blank" rel="noopener" class="floating-btn whatsapp" aria-label="WhatsApp ilə yazın">💬</a>

<!-- ============ CONSULT MODAL ============ -->
<div class="modal-overlay" id="consultModal">
  <div class="modal">
    <button class="modal__close" id="closeConsult">✕</button>
    <h3>Zəngə yazılın</h3>
    <p>Nömrənizi buraxın, məsləhətçimiz Sizinlə əlaqə saxlasın.</p>
    <form id="consultForm">
      <input type="text" placeholder="Ad Soyad" required>
      <input type="tel" placeholder="+994 XX XXX XX XX" required>
      <select>
        <option>Maraqlandığınız proqram</option>
        <option>Foundation</option>
        <option>Bakalavr</option>
        <option>Magistratura</option>
        <option>Doktorantura</option>
        <option>Təqaüd Proqramı</option>
        <option>Dil Kursu</option>
        <option>Digər</option>
      </select>
      <button type="submit" class="btn btn--primary btn--block">Göndər</button>
      <p class="modal__note">Formu göndərməklə razılıq verirsiniz ki, EDDE Global Sizinlə əlaqə saxlaya bilər.</p>
    </form>
  </div>
</div>
