<?php
	$header_width = esc_attr(ARTEMIS_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$header_width = 'lc_swp_'.$header_width;


	/*sticky menu*/
	$header_class = '';
	if (ARTEMIS_SWP_is_sticky_menu()) {
		$header_class = 'lc_sticky_menu transition4';
	}

	/*custom menu styling*/
	$page_logo = $menu_bar_bg = $menu_txt_col = $above_menu_bg = $above_menu_txt_col = "";
	$has_custom_menu_styling = ARTEMIS_SWP_get_page_custom_menu_style($page_logo, $menu_bar_bg, $menu_txt_col, $above_menu_bg, $above_menu_txt_col);

	if ($has_custom_menu_styling) {
		$header_class .= ' cust_page_menu_style';
	}
?>

<header id="at_page_header" class="<?php echo esc_attr($header_class); ?>" data-menubg="<?php echo esc_attr($menu_bar_bg); ?>" data-menucol="<?php echo esc_attr($menu_txt_col); ?>">
	<div class="header_inner lc_wide_menu <?php echo esc_attr($header_width); ?>">
		<div id="logo" class="lc_logo_centered">
			<?php
				$logo_img = ARTEMIS_SWP_get_user_logo_img();
				if (!empty($logo_img)) {
					?>

					<a href="<?php echo esc_url(home_url('/')); ?>" class="global_logo">
						<img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>">
					</a>

					<?php
				} else {
					?>

					<a href="<?php echo esc_url(home_url('/')); ?>" class="text_logo global_logo"> 
						<?php bloginfo('name'); ?>
					</a>

					<?php
				}

				/*custom page related logo*/
				if (!empty($page_logo)) {
				?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="cust_page_logo">
						<img src="<?php echo esc_url($page_logo); ?>" alt="<?php bloginfo('name'); ?>">
					</a>
				<?php
				}
			?>		
		</div>

		<div class="creative_right">
			<?php if (ARTEMIS_SWP_is_woocommerce_active()) {?>
			<div class="creative_header_icon lc_icon_creative_cart artemis-swp-minicart-icon">
				<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>"
                   title="<?php esc_html__( 'View your shopping cart', 'artemis-swp' ); ?>">
					<i class="fa fa-artemis-cart" aria-hidden="true"></i>
					<span class="cart-contents-count">
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</span>
				</a>
                <div class="artemis-swp-minicart">
					<?php woocommerce_mini_cart(); ?>
				</div>				
			</div>
			<?php } ?>

			<div class="creative_header_icon lc_search trigger_global_search">
				<span class="lnr lnr-magnifier"></span>
			</div>


			<?php 
				/*at_login_wish*/
				get_template_part('views/menu/items/login_wish'); 
			?>
		</div>

		<div class="creative_left">
			<div class="hmb_menu hmb_creative on_left">
				<div class="hmb_inner">
					<span class="hmb_line hmb1 on_left transition2"></span>
					<span class="hmb_line hmb2 on_left  transition2"></span>
					<span class="hmb_line hmb3 transition2"></span>
				</div>
			</div>

			<?php /*TODO: wpmp, EN/USD*/ ?>
		</div>
	</div>
	<?php 
	/*mobile menu*/
	get_template_part('views/menu/mobile_menu'); 
	?>
</header>

<div class="nav_creative_container transition3">
	<div class="lc_swp_boxed creative_menu_boxed">
		<div class="nav_creative_inner">
		<?php
		/*render main menu*/
		wp_nav_menu(
			array(
				'theme_location'	=> 'main-menu', 
				'container'			=> 'nav',
				'container_class'	=> 'creative_menu'
			)
		);
		?>
		</div>
	</div>
</div>
