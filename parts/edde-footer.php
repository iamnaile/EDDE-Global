<?php
/** Vahid altlıq + üzən WhatsApp düyməsi + "Zəng istə" modalı. */
$edde_theme_uri = get_stylesheet_directory_uri();
?>
<footer class="site-footer" id="contact">
  <div class="container footer__grid">
    <div class="footer__col footer__col--brand">
      <a href="<?php echo esc_url(home_url(edde_brand('home_path'))); ?>" class="logo logo--light"><img src="<?php echo esc_url($edde_theme_uri); ?>/assets/logo-footer.png" alt="<?php echo esc_attr(edde_brand('name')); ?>" class="logo-img"></a>
      <p><?php echo esc_html(edde_brand('footer_tagline')); ?></p>
      <div class="footer__social">
        <a href="https://www.facebook.com/eddeglobalaz">Facebook</a>
        <a href="https://www.instagram.com/eddeglobal/">Instagram</a>
        <a href="https://www.linkedin.com/company/edde-global/">LinkedIn</a>
        <a href="https://www.youtube.com/@eddeglobal6894">YouTube</a>
      </div>
    </div>
    <?php if (edde_is_academy_site()) :
      $by = ['exams' => [], 'lang' => [], 'kids' => []];
      foreach (edde_academy_courses() as $c) { $by[$c[4]][] = $c; } ?>
    <div class="footer__col footer__col--links">
      <h4>İmtahan hazırlığı</h4>
      <?php foreach (array_slice($by['exams'], 0, 6) as $c) : ?>
        <a href="<?php echo esc_url(home_url('/' . $c[0] . '/')); ?>"><?php echo esc_html($c[2]); ?></a>
      <?php endforeach; ?>
    </div>
    <div class="footer__col footer__col--links">
      <h4>Dil kursları</h4>
      <?php foreach (array_merge($by['lang'], $by['kids']) as $c) : ?>
        <a href="<?php echo esc_url(home_url('/' . $c[0] . '/')); ?>"><?php echo esc_html($c[2]); ?></a>
      <?php endforeach; ?>
      <a href="<?php echo esc_url(home_url('/ustunlukler/')); ?>">Xüsusi Üstünlüklər</a>
      <a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a>
      <a href="<?php echo esc_url(edde_global_url('/')); ?>">EDDE Global ↗</a>
    </div>
    <?php else : ?>
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
      <a href="<?php echo esc_url(home_url('/ielts/')); ?>">IELTS</a>
      <a href="<?php echo esc_url(home_url('/toefl/')); ?>">TOEFL</a>
      <a href="<?php echo esc_url(home_url('/pte-academic/')); ?>">PTE Academic</a>
      <a href="<?php echo esc_url(home_url('/sat/')); ?>">SAT</a>
      <a href="<?php echo esc_url(home_url('/alman-dili-kurslari/')); ?>">Alman Dili Kursları</a>
      <a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a>
    </div>
    <?php endif; ?>
    <div class="footer__col footer__col--links">
      <h4>Əlaqə</h4>
      <a href="tel:+994702141033">070 214 10 33</a>
      <a href="tel:+994708332004">070 833 20 04</a>
      <a href="tel:+994124096789">012 409 67 89</a>
      <a href="mailto:<?php echo esc_attr(edde_brand('email')); ?>"><?php echo esc_html(edde_brand('email')); ?></a>
      <span>Əliyar Əliyev 159, N.Nərimanov ray., Bakı, AZ1052</span>
    </div>
  </div>
  <div class="container footer__bottom">
    <span>© 2018–2026 <?php echo edde_is_academy_site() ? 'EDDE Academy — EDDE Global-ın tərkib hissəsi' : 'EDDE Global'; ?>.<br>Site by: Naila.</span>
    <div class="footer__bottom-right">
      <?php if (!edde_is_academy_site()) : ?>
      <div class="footer__icef"><span id="iasBadge" data-account-id="5105"></span><script async defer crossorigin="anonymous" src="https://www-cdn.icef.com/scripts/iasbadgeid.js"></script></div>
      <?php endif; ?>
      <a href="<?php echo esc_url(home_url('/mexfilik-siyaseti/')); ?>">Məxfilik siyasəti</a>
    </div>
  </div>
</footer>

<a href="https://wa.me/994702141033" class="floating-btn whatsapp" aria-label="WhatsApp ilə yazın">💬</a>

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
        <?php if (edde_is_academy_site()) : foreach (edde_academy_courses() as $c) : ?>
          <option><?php echo esc_html($c[2]); ?></option>
        <?php endforeach; ?>
        <option>Digər</option>
        <?php else : ?>
        <option>Foundation</option>
        <option>Bakalavr</option>
        <option>Magistratura</option>
        <option>Doktorantura</option>
        <option>Təqaüd Proqramı</option>
        <option>Dil Kursu</option>
        <option>Digər</option>
        <?php endif; ?>
      </select>
      <button type="submit" class="btn btn--primary btn--block">Göndər</button>
      <p class="modal__note">Formu göndərməklə razılıq verirsiniz ki, <?php echo esc_html(edde_brand('name')); ?> Sizinlə əlaqə saxlaya bilər.</p>
    </form>
  </div>
</div>
