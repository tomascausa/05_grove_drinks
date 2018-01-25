<?php
	/**
	 * Product Loop Start
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see           https://docs.woocommerce.com/document/template-structure/
	 * @author        WooThemes
	 * @package       WooCommerce/Templates
	 * @version       2.0.0
	 */

	$view_mode = ARTEMIS_SWP_get_products_view_mode();
	$classes   = 'mode-' . $view_mode;
	if ( 'grid' == $view_mode ) {
		$products_per_row = ARTEMIS_SWP_get_products_per_row();
		if (is_shop() || is_product_category()) {
			$classes .= ' at_custom_prod_cols at_columns-' . $products_per_row;	
		}
		
	}
?>
<ul class="products <?php echo esc_attr( $classes ) ?>">
