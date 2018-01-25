<?php
	$color_scheme = ARTEMIS_SWP_get_default_color_scheme();
	
	$woo_position_class = "";
	/*make sure we are on one of the WooCommerce pages that gets sidebar*/
	if (ARTEMIS_SWP_need_sidebar_on_woo()) {
		if (is_shop() || 
			is_product_category() || 
			is_product_tag()) {
			$woo_position_class .= " shop_sidebar sidebar_".ARTEMIS_SWP_get_shop_page_sidebar();
		} else {
			/*single product page*/
			$woo_position_class .= " shop_sidebar sidebar_".ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar_single');
		}
	}
?>

<div id="sidebar" class="lc_basic_content_padding <?php echo esc_attr($color_scheme).esc_attr($woo_position_class); ?>">
	<ul>
		<?php
		 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) {
		 }
		?>
	</ul>
</div>