<?php

$preloader_show = yprm_get_theme_setting('preloader_show');
$preloader_type = yprm_get_theme_setting('preloader_type');
$preloader_static_word = yprm_get_theme_setting('preloader_static_word');
$preloader_img = yprm_get_theme_setting('preloader_img');
$site_scheme = yprm_get_theme_setting('site_color_mode');
$header_style = yprm_get_theme_setting('header_style');
$navigation_type = yprm_get_theme_setting('navigation_type');
$copyright_text = yprm_get_theme_setting('copyright_text');
$header_space = yprm_get_theme_setting('header_space');

if(get_post_type() == 'yprm_header_builder') {
  $header_style = get_the_ID();
} ?>

<!DOCTYPE html>
<html lang="az-AZ">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">

		<?php wp_head(); ?>


	 <style>
.swiper-autoheight, .swiper-autoheight .swiper-slide {
  height: 347px;
}

.floating-btn {
    position: fixed;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    z-index: 99999;
    transition: 0.3s ease;
}

/* votsap iconi */
.whatsapp {
    top: 45%;
    background: #25D366;
}

/* location iconi */
.location {
    top: calc(45% + 80px);
    background: #d63333;
}

.floating-btn:hover {
    transform: scale(1.08);
    box-shadow: 0px 6px 14px rgba(0,0,0,0.35);
}


 .mobile-navigation .menu > li > a.current span, .mobile-navigation .menu > li.current-menu-item > a span, .mobile-navigation .menu > li.current-menu-ancestor > a span, .mobile-navigation .menu > li.current_page_item > a span, .mobile-navigation .menu > li.current_page_parent > a span, .mobile-navigation .menu > li.current-menu-ancestor > a span, .mobile-navigation .menu > li.mega-current-menu-item > a span, .mobile-navigation .menu > li.mega-current-menu-ancestor > a span, .mobile-navigation .menu > li.mega-current_page_item > a span, .mobile-navigation .menu > li.mega-current_page_parent > a span, .mobile-navigation .menu > li.mega-current-menu-ancestor > a span, .mobile-navigation .menu > li:hover > a span {
  border-color: #e1093c;
}

.mobile-navigation .sub-menu > li > a.current, .mobile-navigation .sub-menu > li.current-menu-item > a, .mobile-navigation .sub-menu > li.current-menu-ancestor > a, .mobile-navigation .sub-menu > li.current_page_item > a, .mobile-navigation .sub-menu > li.current_page_parent > a, .mobile-navigation .sub-menu > li.current-menu-ancestor > a, .mobile-navigation .sub-menu > li.mega-current-menu-item > a, .mobile-navigation .sub-menu > li.mega-current-menu-ancestor > a, .mobile-navigation .sub-menu > li.mega-current_page_item > a, .mobile-navigation .sub-menu > li.mega-current_page_parent > a, .mobile-navigation .sub-menu > li.mega-current-menu-ancestor > a, .mobile-navigation .sub-menu > li:hover > a, .mobile-navigation .mega-sub-menu > li.current-menu-item > a, .mobile-navigation .mega-sub-menu > li.current-menu-ancestor > a, .mobile-navigation .mega-sub-menu > li.current_page_item > a, .mobile-navigation .mega-sub-menu > li.current_page_parent > a, .mobile-navigation .mega-sub-menu > li.current-menu-ancestor > a, .mobile-navigation .mega-sub-menu > li.mega-current-menu-item > a, .mobile-navigation .mega-sub-menu > li.mega-current-menu-ancestor > a, .mobile-navigation .mega-sub-menu > li.mega-current_page_item > a, .mobile-navigation .mega-sub-menu > li.mega-current_page_parent > a, .mobile-navigation .mega-sub-menu > li.mega-current-menu-ancestor > a, .mobile-navigation .mega-sub-menu > li:hover > a {
  color: #e1093c;
}

.button-style1, .vc_general.vc_btn3, .pixproof-data .button-download, .navigation > ul > li.current-menu-item > a span, .navigation > ul > li.current-menu-ancestor > a span, .navigation > ul > li.current-menu-parent > a span, .navigation > ul > li.current_page_item > a span, .banner .cell .content a[data-type="video"], .pagination ul li span.current, .pagination ul li a:hover, .pagination ul li a:focus, nav.woocommerce-pagination ul li span.current, nav.woocommerce-pagination ul li a:hover, nav.woocommerce-pagination ul li a:focus, .button-style1.fill {
  border-color: #e1093c;
}

.heading-decor::after, .heading-decor-s .h::after, .testimonials .item .quote::after, .button-style2, .preloader_content__container::after, .preloader_content__container::before, .navigation.hover-style2 > ul > li.current-menu-item > a span::after, .navigation.hover-style2 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style2 > ul > li.current-menu-parent > a span::after, .navigation.hover-style2 > ul > li.current_page_item > a span::after, .navigation.hover-style3 > ul > li.current-menu-item > a span::after, .navigation.hover-style3 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style3 > ul > li.current-menu-parent > a span::after, .navigation.hover-style3 > ul > li.current_page_item > a span::after, .navigation.hover-style4 > ul > li.current-menu-item > a span::after, .navigation.hover-style4 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style4 > ul > li.current-menu-parent > a span::after, .navigation.hover-style4 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style2 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style3 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style4 > ul > li.current_page_item > a span::after, .navigation > ul > li:hover > a, .navigation .sub-menu li.current-menu-item > a, .navigation .sub-menu li.current-menu-ancestor > a, .navigation .sub-menu li.current-menu-parent > a, .navigation .sub-menu li:hover > a, .navigation .sub-menu li.current-menu-item.menu-item-has-children::after, .navigation .sub-menu li.menu-item-has-children:hover::after, .navigation .children li.current_page_item > a, .navigation .children li.current-menu-ancestor > a, .navigation .children li:hover > a, .navigation .children li.current_page_item.page_item_has_children::after, .navigation .children li.page_item_has_children:hover::after, .full-screen-nav .fsn-container > ul > li:hover > a, .full-screen-nav .fsn-container > ul > li.current-menu-item > a, .full-screen-nav .fsn-container > ul > li.current-menu-parent > a, .full-screen-nav .fsn-container > ul > li.current-menu-ancestor > a, .minicart-wrap .cart_list .mini_cart_item .quantity, .widget_shopping_cart_content .cart_list .mini_cart_item .quantity, .minicart-wrap .total > span, .widget_shopping_cart_content .total > span, .side-navigation li.current-menu-item > a, .side-navigation li.current-menu-parent > a, .side-navigation li.current-menu-ancestor > a, .side-navigation li.current_page_item > a, .side-navigation li:hover > a, .banner-social-buttons .item:hover, .footer-social-button a:hover, .banner .cell .content .angle, .banner .heading span, .banner .owl-dot.active::before, .banner .owl-prev:hover, .banner .owl-next:hover, .banner .price, .widget_archive ul li a:hover, .widget_categories ul li a:hover, .widget_pages ul li a:hover, .widget_meta ul li a:hover, .widget_nav_menu ul li a:hover, .widget_recent_entries ul li a:hover, .product-categories li a:hover, .tagcloud .tag-cloud-link:hover, .blog-post-widget .item .blog-detail, .blog-item .date, .project-horizontal .content .date, .blog-item .bottom .col i, .site-content .date, .comment-items .comment-item .text .date, .site-footer .scroll-up-button:hover, .contact-row i, .pagination ul li span.current, .pagination ul li a:hover, .pagination ul li a:focus, nav.woocommerce-pagination ul li span.current, nav.woocommerce-pagination ul li a:hover, nav.woocommerce-pagination ul li a:focus, .gdpr-modal-block a, .share-stick-block .social-links a:hover {
  color: #e1093c;
}

.button-style1:hover, .vc_general.vc_btn3:hover, .pixproof-data .button-download:hover, .minicart-wrap a.checkout, .widget_shopping_cart_content a.checkout, .banner-social-buttons .item + .item::after, .banner-right-buttons .button + .button::before, .footer-social-button a + a::after, .post-bottom .zilla-likes, .button-style1.fill {
  background: #e1093c;
}

.bottom.like-on.comment-on {
  display: none !important;
}

.post-bottom {
  display: none;
}

body .header-140106.mobile-type .header-main-block {
  color: #e8466c !important;
}

/* desktop */
.lang .qtranxs_widget ul {
  list-style: none;
  display: flex;
  gap: 8px;
  margin: 0;
  padding: 3px 3px;
  background: #fff;
  border-radius: 6px;
  align-items: center;
  float: right;
}

/* mobil uchun */
@media (max-width: 768px) {
  .lang .qtranxs_widget ul {
    padding: 3px 21px !important;
  }
}

.date {
  display: none !important;
}
.lang .qtranxs_widget ul li {
    display: flex;
    align-items: center;
    cursor: pointer;
    opacity: 0.5;
    transition: .2s;
}

.lang .qtranxs_widget ul li:hover {
    opacity: 0.8;
}

.lang .qtranxs_widget ul li.qtranxs_active {
    opacity: 1;
    font-weight: bold;
}

.lang .qtranxs_widget img {
    width: 22px !important;
    height: auto !important;
    border-radius: 3px;
    box-shadow: none !important;
}


.mobile-nav .mobile-lang {
    margin-top: 15px;
    display: flex;
    gap: 12px;
    align-items: center;
}

.mobile-nav .mobile-lang img {
    width: 28px !important;
    height: auto !important;
}

.mobile-navigation .mobile-lang {
    margin-bottom: 15px;
    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: flex-start;
}

.heading-decor, .heading-decor-s {
  margin: 36px 0 30px;
  position: relative;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
.button-style1:hover, .vc_general.vc_btn3:hover, .pixproof-data .button-download:hover, .minicart-wrap a.checkout, .widget_shopping_cart_content a.checkout, .banner-social-buttons .item + .item::after, .banner-right-buttons .button + .button::before, .footer-social-button a + a::after, .post-bottom .zilla-likes, .button-style1.fill {
  background: #753b9f;
}	
	
	.button-style1, .vc_general.vc_btn3, .pixproof-data .button-download, .navigation > ul > li.current-menu-item > a span, .navigation > ul > li.current-menu-ancestor > a span, .navigation > ul > li.current-menu-parent > a span, .navigation > ul > li.current_page_item > a span, .banner .cell .content a[data-type="video"], .pagination ul li span.current, .pagination ul li a:hover, .pagination ul li a:focus, nav.woocommerce-pagination ul li span.current, nav.woocommerce-pagination ul li a:hover, nav.woocommerce-pagination ul li a:focus, .button-style1.fill {
  border-color: #753b9f;
}
	
	
	
	.heading-decor::after, .heading-decor-s .h::after, .testimonials .item .quote::after, .button-style2, .preloader_content__container::after, .preloader_content__container::before, .navigation.hover-style2 > ul > li.current-menu-item > a span::after, .navigation.hover-style2 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style2 > ul > li.current-menu-parent > a span::after, .navigation.hover-style2 > ul > li.current_page_item > a span::after, .navigation.hover-style3 > ul > li.current-menu-item > a span::after, .navigation.hover-style3 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style3 > ul > li.current-menu-parent > a span::after, .navigation.hover-style3 > ul > li.current_page_item > a span::after, .navigation.hover-style4 > ul > li.current-menu-item > a span::after, .navigation.hover-style4 > ul > li.current-menu-ancestor > a span::after, .navigation.hover-style4 > ul > li.current-menu-parent > a span::after, .navigation.hover-style4 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style2 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style2 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style3 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style3 > ul > li.current_page_item > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-item > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-ancestor > a span::after, .mobile-navigation.hover-style4 > ul > li.current-menu-parent > a span::after, .mobile-navigation.hover-style4 > ul > li.current_page_item > a span::after, .navigation > ul > li:hover > a, .navigation .sub-menu li.current-menu-item > a, .navigation .sub-menu li.current-menu-ancestor > a, .navigation .sub-menu li.current-menu-parent > a, .navigation .sub-menu li:hover > a, .navigation .sub-menu li.current-menu-item.menu-item-has-children::after, .navigation .sub-menu li.menu-item-has-children:hover::after, .navigation .children li.current_page_item > a, .navigation .children li.current-menu-ancestor > a, .navigation .children li:hover > a, .navigation .children li.current_page_item.page_item_has_children::after, .navigation .children li.page_item_has_children:hover::after, .full-screen-nav .fsn-container > ul > li:hover > a, .full-screen-nav .fsn-container > ul > li.current-menu-item > a, .full-screen-nav .fsn-container > ul > li.current-menu-parent > a, .full-screen-nav .fsn-container > ul > li.current-menu-ancestor > a, .minicart-wrap .cart_list .mini_cart_item .quantity, .widget_shopping_cart_content .cart_list .mini_cart_item .quantity, .minicart-wrap .total > span, .widget_shopping_cart_content .total > span, .side-navigation li.current-menu-item > a, .side-navigation li.current-menu-parent > a, .side-navigation li.current-menu-ancestor > a, .side-navigation li.current_page_item > a, .side-navigation li:hover > a, .banner-social-buttons .item:hover, .footer-social-button a:hover, .banner .cell .content .angle, .banner .heading span, .banner .owl-dot.active::before, .banner .owl-prev:hover, .banner .owl-next:hover, .banner .price, .widget_archive ul li a:hover, .widget_categories ul li a:hover, .widget_pages ul li a:hover, .widget_meta ul li a:hover, .widget_nav_menu ul li a:hover, .widget_recent_entries ul li a:hover, .product-categories li a:hover, .tagcloud .tag-cloud-link:hover, .blog-post-widget .item .blog-detail, .blog-item .date, .project-horizontal .content .date, .blog-item .bottom .col i, .site-content .date, .comment-items .comment-item .text .date, .site-footer .scroll-up-button:hover, .contact-row i, .pagination ul li span.current, .pagination ul li a:hover, .pagination ul li a:focus, nav.woocommerce-pagination ul li span.current, nav.woocommerce-pagination ul li a:hover, nav.woocommerce-pagination ul li a:focus, .gdpr-modal-block a, .share-stick-block .social-links a:hover {
  color: #844baa;
}
	
	
	
	
.reviews-container {
  display: grid;
  grid-template-columns: 1fr;
  gap: 18px;
  padding: 20px;
  max-width: 900px;
  margin: auto;
}

.review-box {
  background: #fff;
  padding: 18px;
  border-radius: 14px;
  box-shadow: 0 6px 22px rgba(0,0,0,0.08);
  border-left: 5px solid #2E5BFF;
}

.stars {
  font-size: 20px;
  color: #f4b400;
  margin-bottom: 8px;
}

.review-text {
  font-size: 15px;
  line-height: 1.6;
  margin-bottom: 12px;
}

.meta {
  font-size: 13px;
  font-weight: 600;
  color: #333;
}
	
	
	.page-title {
  margin-bottom: 36px;
  margin: 36px 0 30px;
}
	
	.vc_do_custom_heading {
  margin-bottom: 0.625rem;
  margin-top: 22px;
}
		</style>
		
		<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T36ZWFSZ');</script>
<!-- End Google Tag Manager -->
		

	
	</head>

	<body <?php body_class(); ?>>
		<div id="all" class="site">
      <?php do_action('yprm_before_header') ?>
			<?php if($preloader_show == 'true' && $preloader_type == 'words' && !empty($preloader_static_word)) { 
        $words_html = '';
        $words_count = 0;
        if($word = yprm_get_theme_setting('preloader_dinamic_word_1')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_2')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_3')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_4')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        } if($word = yprm_get_theme_setting('preloader_dinamic_word_5')) {
          $words_count++;
          $words_html .= '<li class="preloader_content__container__list__item">'.strip_tags($word).'</li>';
        }
      ?>
				<div class="preloader">
					<div class="preloader_content">
						<div class="preloader_content__container">
							<p class="preloader_content__container__text">
    <?php echo do_shortcode($preloader_static_word); ?>
</p>
							<?php if($words_count > 0) { ?>
								<ul class="preloader_content__container__list count_<?php echo esc_attr($words_count) ?>">
								<?php echo do_shortcode( wp_kses_post($words_html) ); ?>
								</ul>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } if($preloader_show == 'true' && $preloader_type == 'image' && isset($preloader_img['background-image'])) { ?>
				<div class="preloader">
					<div class="preloader_img"><img src="<?php echo esc_url($preloader_img['background-image']) ?>" alt="<?php echo get_bloginfo( 'name' ) ?>"></div>
				</div>
			<?php } if($header_style == 'default') { ?>
				<header class="site-header<?php echo esc_attr(yprm_header_class()) ?> main-row">
					<div class="<?php echo esc_attr(yprm_get_theme_setting('header_container')) ?>">
						<?php if(is_active_sidebar('sidebar')) { ?>
							<div class="side-bar-button multimedia-icon-list"></div>
						<?php } ?>
						<div class="logo"><?php echo yprm_site_logo(); ?></div>
						<div class="fr">
							<?php if(has_nav_menu('navigation') && $navigation_type != 'disabled') { ?>
								<nav class="navigation <?php echo esc_attr($navigation_type.' hover-'.yprm_get_theme_setting('navigation_item_hover_style')) ?>"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?></nav>
								<div class="butter-button nav-button <?php echo esc_attr($navigation_type) ?>">
									<div></div>
								</div>
							<?php } if((yprm_get_theme_setting('header_cart') == 'yes' || yprm_get_theme_setting('header_cart') == 'true') && class_exists( 'WooCommerce' )) { ?>
								<div class="header-minicart woocommerce header-minicart-novo">
									<?php global $woocommerce;
									$count = $woocommerce->cart->cart_contents_count;
									if($count == 0) { ?>
									<div class="hm-count empty"><i class="base-icon-minicart"></i></div>
									<?php } else { ?>
									<a class="hm-count" href="<?php echo esc_url(wc_get_cart_url()) ?>"><i class="base-icon-minicart"></i><span><?php echo esc_html($count) ?></span></a>
									<?php } ?>
									<div class="minicart-wrap">
										<?php woocommerce_mini_cart(); ?>
									</div>
								</div>
							<?php } if(yprm_get_theme_setting('header_search') == 'yes' || yprm_get_theme_setting('header_search') == 'true') { ?>
								<div class="search-button"><i class="basic-ui-icon-search"></i></div>
								<!-- ✅ DƏYİŞİKLİK 1: dil widget-i artıq CSS-də hazır olan .lang sarğısına alınıb,
								     əvvəlki versiyada bu sarğı olmadığı üçün .lang .qtranxs_widget ul qaydaları işləmirdi -->
								<div class="lang">
									<?php the_widget('qTranslateXWidget', array('type' => 'image', 'hide-title' => true) ); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</header>
			<?php } else if(class_exists('YPRM_Build_Header')) {
			new YPRM_Build_Header($header_style);
      } else if($header_style == 'side') { ?>
				<div class="side-header main-row <?php echo esc_attr($site_scheme) ?>">
					<div class="logo"><?php echo yprm_site_logo(); ?></div>
					<div class="wrap">
						<div class="cell">
							<nav class="side-navigation"><?php wp_nav_menu( array( 'theme_location' => 'navigation', 'container' => 'ul', 'menu_class' => 'menu', 'link_before' => '<span>', 'link_after' => '</span>', 'walker' => new Child_Wrap(), ) ); ?></nav>
						</div>
					</div>
					<?php if(!empty($copyright_text)) { ?>
						<div class="copyright"><?php echo $copyright_text ?></div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if($header_space == 'yes' || $header_space == 'true') { ?>
				<div class="header-space"></div>
			<?php } else { ?>
				<div class="header-space hide"></div>
			<?php } ?>
      <?php do_action('yprm_after_header') ?>

			<!-- ✅ DƏYİŞİKLİK 2: Üzən WhatsApp və Lokasiya düymələri.
			     CSS-də .floating-btn/.whatsapp/.location qaydaları artıq mövcud idi,
			     amma bu düymələrin özü HTML-də heç yerdə yox idi — indi əlavə olunur.
			     Nömrəni/ünvanı öz real məlumatınızla WordPress Customizer-dən idarə etmək
			     istəsəniz, bu iki sətri yprm_get_theme_setting() ilə əvəz edə bilərsiniz. -->
			<a href="https://wa.me/<?php echo function_exists('edde_contact') ? esc_attr(edde_contact()['whatsapp']) : '994708332024'; ?>" class="floating-btn whatsapp" target="_blank" rel="noopener" aria-label="WhatsApp ilə yazın">
				<i class="fa fa-whatsapp" aria-hidden="true"></i>
			</a>
			<a href="https://g.page/edde-global?share" class="floating-btn location" target="_blank" rel="noopener" aria-label="Ofisin ünvanı">
				<i class="fa fa-map-marker" aria-hidden="true"></i>
			</a>