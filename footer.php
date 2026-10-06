<?php

$footer = yprm_get_theme_setting('footer');
$footer_social_buttons = yprm_get_theme_setting('footer_social_buttons');

if(get_post_type() == 'yprm_footer_builder') {
  $footer = get_the_ID();
}
?>
      <?php if($footer_social_buttons == 'show' && $social_links = yprm_build_social_links('with-label')) { ?>
				<div class="footer-social-button">
					<?php echo $social_links ?>
				</div>
			<?php } if(get_post_type() == 'yprm_footer_builder' && class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) { ?>
        <?php the_content() ?>
      <?php } else if(class_exists('YPRM_Footer_Builder') && $footer != 'disabled') {
        do_action('yprm_render_footer', $footer);
      } else if($footer == 'show' && get_post_type() != 'yprm_footer_builder') { ?>
				<footer class="site-footer main-row">
					<div class="container">
						<div class="row">
              <div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_1')) ?>">
                <?php if(yprm_get_theme_setting('footer_logo') == 'show') { ?>
                  <div class="logo"><?php echo yprm_site_footer_logo(); ?></div>
								<?php } if(is_active_sidebar('footer-1')) { ?>
									<?php dynamic_sidebar('footer-1'); ?>
								<?php } ?>
							</div>
							<?php if(is_active_sidebar('footer-2')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_2')) ?>">
								<?php dynamic_sidebar('footer-2'); ?>
							</div>
							<?php } if(is_active_sidebar('footer-3')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_3')) ?>">
								<?php dynamic_sidebar('footer-3'); ?>
							</div>
							<?php } if(is_active_sidebar('footer-4')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_4')) ?>">
								<?php dynamic_sidebar('footer-4'); ?>
							</div>
							<?php } ?>
            </div>
            <?php if(yprm_get_theme_setting('footer_scroll_up') == 'show') { ?>
              <div id="scroll-top" class="scroll-up-button basic-ui-icon-up-arrow"></div>
            <?php } ?>
					</div>
				</footer>
			<?php } if(yprm_get_theme_setting('use_gdpr') == 'true') { ?>
				<div class="gdpr-modal-block">
					<div class="close basic-ui-icon-cancel"></div>
					<div class="text"><?php echo wp_kses(yprm_get_theme_setting('gdpr_text'), 'post') ?></div>
				</div>
			<?php } ?>
		</div>
		
		<?php wp_footer(); ?>

 

 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T36ZWFSZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZGPYRB6DBG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZGPYRB6DBG');
</script>


	</body>
</html>
