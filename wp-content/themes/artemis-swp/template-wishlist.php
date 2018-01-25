<?php
	/**
	 * Template Name: Wishlist
	 */

	$products = ARTEMIS_SWP_get_wishlist_products();

?>

<?php get_header(); ?>
<?php if ( count( $products ) == 0 ) { ?>
    <div class="lc_swp_boxed lc_basic_content_padding">
			<p class="wishlist-empty"><?php echo esc_html__( 'Your wishlist is empty.', 'artemis-swp' ); ?></p>
		</div>
<?php } else { ?>

    <div class="lc_swp_boxed lc_swp_boxed lc_basic_content_padding">
        <div class="woocommerce">
            <table class="shop_table shop_table_responsive wishlist" cellpadding="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-name" colspan="2"><?php echo esc_html__( 'Product', 'artemis-swp' ) ?></th>
                        <th class="product-price"><?php echo esc_html__( 'Price', 'artemis-swp' ) ?></th>
                        <th class="product-stock-status"><?php echo esc_html__( 'Stock status', 'artemis-swp' ) ?></th>
                        <th class="product-actions">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    //update products because some of them might be deleted
                    $new_wishlist_products = array();
                    foreach ( $products as $product ) {
                        $wc_product = wc_get_product( $product['id'] );
                        if ( ! $wc_product ) {
                            //product may be deleted
                            continue;
                        }
                        $new_wishlist_products[ $product['id']] = $product;
                        ?>
                        <tr class="wishlist_item" data-wishlist-item="<?php echo esc_attr( $wc_product->get_id() ) ?>">
                            <td data-title="<?php esc_attr_e('Remove', 'artemis-swp') ?>">
                                <span class="artemis-swp-wishlist-remove-item"
                                      data-wishlist-id="<?php echo esc_attr( $wc_product->get_id() ) ?>">&times;</span>
                            </td>
                            <td data-title="<?php esc_attr_e( 'Image', 'artemis-swp' ) ?>"><?php echo wp_kses( $wc_product->get_image( 'shop_thumbnail' ),
                                                    array(
	                                                    'img' => array(
		                                                    'src'    => array(),
		                                                    'class'  => array(),
		                                                    'width'  => array(),
		                                                    'height' => array(),
		                                                    'alt'    => array(),
		                                                    'srcset' => array(),
		                                                    'sizes' => array(),
	                                                    )
                                                    ) ) ?></td>
                            <td data-title="<?php esc_attr_e( 'Product', 'artemis-swp' ) ?>"><a href="<?php echo esc_attr($wc_product->get_permalink()) ?>" ><?php echo esc_html( $wc_product->get_title() ) ?></a></td>
                            <td data-title="<?php esc_attr_e( 'Price', 'artemis-swp' ) ?>"><?php echo wp_kses( $wc_product->get_price_html(), array( 'span' => array( 'class' => array() ) ) ) ?></td>
                            <td data-title="<?php esc_attr_e( 'Availability', 'artemis-swp' ) ?>"><?php
                                    // Availability
                                    $availability = $wc_product->get_availability();
                                    if ( empty( $availability['availability'] ) ) {
                                        if ( $wc_product->is_in_stock() ) {
                                            $availability['availability'] = esc_html__( 'In stock', 'artemis-swp' );
                                        } else {
                                            $availability['availability'] = esc_html__( 'Out of stock', 'artemis-swp' );
                                        }
                                    }
                                    $availability_html = '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
                                    echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $wc_product );
                                ?>
                            </td>
                            <td class="at_actions" data-title="<?php esc_attr_e( 'Actions', 'artemis-swp' ) ?>">
                                <?php
                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                        sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
                                                                 esc_url( $wc_product->add_to_cart_url() ),
                                                                 1,
                                                                 esc_attr( $wc_product->get_id() ),
                                                                 esc_attr( $wc_product->get_sku() ),
                                                                 'button',
                                                                 esc_html( $wc_product->add_to_cart_text() )
                                                        ),
                                                        $wc_product );
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                <tfoot>
                    <tr id="artemis-swp-empty-wishlist">
                        <td colspan="6"> <?php echo esc_html__( 'Your wishlist is empty', 'artemis-swp' ) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
	<?php
        //update wishlist
        ARTEMIS_SWP_update_wishlist_products($new_wishlist_products);
	?>
<?php } ?>
<?php get_footer(); ?>
