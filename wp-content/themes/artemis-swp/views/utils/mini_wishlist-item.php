<?php
	/**
	 * Created by PhpStorm.
	 * User: th
	 * Date: 2 Feb 2017
	 * Time: 15:13
	 */

	/** @var WC_Product $wc_product */
	$wc_product = get_query_var( 'artemis_swp_product' );

	$thumbnail = $wc_product->get_image( 'shop_thumbnail' );
?>
<li class="mini_wishlist_item wishlist_item" data-wishlist-item="<?php echo esc_attr($wc_product->get_id()); ?>">
        <div class="mini_wishlist-item-product-image">
            <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
        </div>
        <span class="mini_wishlist-item-product-name"><?php echo wp_kses($wc_product->get_name(),array('span' => array('class' => array()))); ?></span>
	<?php
		echo apply_filters( 'artemis_swp_wishlist_item_remove_link', sprintf(
			'<span class="artemis-swp-wishlist-remove-item" title="%s" data-wishlist-id="%s">&times;</span>',
			esc_html__( 'Remove this item', 'artemis-swp' ),
			esc_attr( $wc_product->get_id() )
		), $wc_product );

		// Availability
		$availability = $wc_product->get_availability();
		if ( empty( $availability['availability'] ) ) {
			if ( $wc_product->is_in_stock() ) {
				$availability['availability'] = esc_html__( 'In stock', 'artemis-swp' );
			} else {
				$availability['availability'] = esc_html__( 'Out of stock', 'artemis-swp' );
			}
		}
	?>
    <a class="at_wishlist_add_to_cart" rel="nofollow" href="<?php echo esc_attr(esc_url($wc_product->add_to_cart_url())) ?>">
            <?php echo esc_html($wc_product->add_to_cart_text()); ?>
        </a>
	<?php
		$availability_html = '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
		echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $wc_product );
	?>
    </li>
