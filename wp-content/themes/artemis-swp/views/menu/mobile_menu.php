<?php
	$mobile_header_width = esc_attr(ARTEMIS_SWP_get_header_footer_width());
	/*create class: lc_swp_full/lc_swp_boxed*/
	$mobile_header_width = 'lc_swp_'.$mobile_header_width; 
?>
<div class="header_inner lc_mobile_menu <?php echo esc_attr($mobile_header_width); ?>">
	<div id="mobile_logo" class="lc_logo_centered">
		<?php
			$logo_img = ARTEMIS_SWP_get_user_logo_img();
			if (!empty($logo_img)) {
				?>

				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>">
				</a>

				<?php
			} else {
				?>

				<a href="<?php echo esc_url(home_url('/')); ?>"> <?php bloginfo('name'); ?></a>

				<?php
			}
		?>		
	</div>

	<div class="creative_right">
		<div class="hmb_menu hmb_mobile">
			<div class="hmb_inner">
				<span class="hmb_line mobile_menu_hmb_line hmb1 transition2"></span>
				<span class="hmb_line mobile_menu_hmb_line hmb2 transition2"></span>
				<span class="hmb_line mobile_menu_hmb_line hmb3 transition2"></span>
			</div>
		</div>

		<?php if (ARTEMIS_SWP_is_woocommerce_active()) {?>
		<div class="mobile_menu_icon creative_header_icon lc_icon_creative_cart artemis-swp-minicart-icon">
			<a class="cart-contents in_mobile_menu" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_html__('View your shopping cart', 'artemis-swp'); ?>">
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

        <?php if( in_array( ARTEMIS_SWP_get_menu_style(), array('creative_menu','classic_menu', 'classic_double_menu', 'classic_double_menu_center') ) && ARTEMIS_SWP_is_woocommerce_active()) { ?>
            <div class="creative_header_icon mobile_menu_icon at_login">
                <?php if (is_user_logged_in()) { ?>
                    <a href="<?php echo esc_attr(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                       class="at_to_my_account"
                       title="<?php esc_attr_e('My Account', 'artemis-swp'); ?>"><i class="fa fa-user"></i></a>
                <?php } else { ?>
                    <a href="<?php echo esc_attr(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"
                       class="<?php echo esc_attr( ARTEMIS_SWP_is_login_popup_enabled() ? 'at_to_login_popup' : '' ) ?>"
                       title="<?php esc_attr_e('Login &#47; Signup', 'artemis-swp'); ?>"><i class="fa fa-sign-in"></i></a>
                <?php } ?>
            </div>
        <?php } ?>
	</div>

	<div class="creative_left">
		<div class="mobile_menu_icon creative_header_icon lc_search trigger_global_search">
			<span class="lnr lnr_mobile lnr-magnifier"></span>
		</div>

	</div>
</div>

<div class="mobile_navigation_container lc_swp_full transition3">
	<?php
	/*render main menu*/
	wp_nav_menu(
		array(
			'theme_location'	=> 'main-menu', 
			'container'			=> 'nav',
			'container_class'	=> 'mobile_navigation'
		)
	);
	?>
</div>
