<?php
	$header_width = esc_attr(ARTEMIS_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$header_width = 'lc_swp_'.$header_width; 

	/*sticky menu*/
	$header_class = '';
	if (ARTEMIS_SWP_is_sticky_menu()) {
		$header_class = 'lc_sticky_menu';
	}

	$pre_header_class = 'pre_header clearfix classic_double_menu';

	/*custom menu styling*/
	$page_logo = $menu_bar_bg = $menu_txt_col = $above_menu_bg = $above_menu_txt_col = "";
	$has_custom_menu_styling = ARTEMIS_SWP_get_page_custom_menu_style($page_logo, $menu_bar_bg, $menu_txt_col, $above_menu_bg, $above_menu_txt_col);

	if ($has_custom_menu_styling) {
		$header_class .= ' cust_page_menu_style';
		$pre_header_class .= ' cust_pre_header_style';
	}	
?>

<div class="<?php echo esc_attr($pre_header_class); ?> <?php echo esc_attr($header_width); ?>" data-prebg="<?php echo esc_attr($above_menu_bg); ?>" data-precol="<?php echo esc_attr($above_menu_txt_col); ?>">
	<div class="at_menu_message float_left">
		<?php echo esc_html(ARTEMIS_SWP_get_menu_message()); ?>
	</div>

	<div class="classic_header_icons">
		<div class="classic_header_icon lc_search trigger_global_search vibrant_hover transition4">
			<span class="lnr lnr-magnifier"></span>
		</div>

		<?php 
		if (ARTEMIS_SWP_is_woocommerce_active()) {
		?>

			<div class="classic_header_icon artemis-swp-minicart-icon">
				<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html__('View your shopping cart', 'artemis-swp'); ?>">
					<i class="fa fa-artemis-cart" aria-hidden="true"></i>
					<span class="cart-contents-count lc_swp_vibrant_bgc">
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</span>
				</a>

                <div class="artemis-swp-minicart">
                    <?php woocommerce_mini_cart(); ?>
                </div>
			</div>

		<?php

		}
		?>
	</div>

	<?php if (has_nav_menu("secondary-menu")) { ?>
	<div class="at_secondary_menu float_right">
		<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'secondary-menu', 
					'container'			=> 'nav',
					'container_class'	=> 'at_secondary_menu'
				)
			);
		?>
	</div>
	<?php } ?>	
</div>

<header id="at_page_header" class="header_classic_double_menu <?php echo esc_attr($header_class); ?>" data-menubg="<?php echo esc_attr($menu_bar_bg); ?>" data-menucol="<?php echo esc_attr($menu_txt_col); ?>">
	<div class="header_inner lc_wide_menu <?php echo esc_attr($header_width); ?>">
		<div id="logo" class="relative_position">
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

					<a href="<?php echo esc_url(home_url('/')); ?>" class="global_logo"> 
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



		<?php
		$customWalker = new SWPFrontendWalkerNavMenu();

		/*render main menu*/
		wp_nav_menu(
			array(
				'theme_location'	=> 'main-menu', 
				'container'			=> 'nav',
				'container_class'	=> 'classic_menu add_margin_left classic_double_menu',
				'walker'			=> $customWalker
			)
		);
		?>

		<?php 
			/*at_login_wish*/
			get_template_part('views/menu/items/login_wish'); 
		?>
		
	</div>
	<?php 
	/*mobile menu*/
	get_template_part('views/menu/mobile_menu'); 
	?>
</header>
