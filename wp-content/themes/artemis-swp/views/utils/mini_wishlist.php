<?php
	/**
	 * Created by PhpStorm.
	 * User: th
	 * Date: 27 Ian 2017
	 * Time: 16:26
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	do_action( 'artemis_swp_before_mini_wishlist' );
	$products              = ARTEMIS_SWP_get_wishlist_products();
	$new_wishlist_products = array();
?>
    <ul class="artemis_swp-mini_wishlist product_list_widget">

        <?php if ( count( $products ) ) :
	        foreach ( $products as $id => $product ) {
		        $wc_product = wc_get_product( $product['id'] );
		        if ( ! $wc_product ) {
			        //product may be deleted
			        continue;
		        }
		        $new_wishlist_products[ $product['id'] ] = $product;

		        set_query_var( 'artemis_swp_product', $wc_product );
		        get_template_part( 'views/utils/mini_wishlist','item' );
	        }
        else : ?>
            <li class="empty"><?php esc_html_e( 'No products in wishlist.', 'artemis-swp' ); ?></li>
        <?php endif; ?>

    </ul><!-- end product list -->

<?php
	$wishlist_url = ARTEMIS_SWP_get_wishlist_url();
    $extra_class  = '';
	if ( !count( $products ) || !$wishlist_url ) {
	    $extra_class .= 'at_hidden';
    } ?>
    <p class="buttons <?php echo esc_attr($extra_class) ?>">
        <a href="<?php echo esc_url( $wishlist_url ); ?>"
           class="button artemis-swp-view-wishlist wc-forward"><?php esc_html_e( 'View Wishlist', 'artemis-swp' ); ?>
        </a>
    </p>


<?php do_action( 'artemis_swp_after_mini_wishlist' ); ?>
