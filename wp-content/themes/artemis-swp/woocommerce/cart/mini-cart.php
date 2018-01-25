<?php
	/**
	 * Mini-cart
	 *
	 * Contains the markup for the mini-cart, used by the cart widget.
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://docs.woocommerce.com/document/template-structure/
	 * @author  WooThemes
	 * @package WooCommerce/Templates
     * @version 3.2.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

				$prod_name_tags = array(
					'p' => array(
						'class'	=> array()
					),
					'div' => array(
						'class'	=> array()
					)					
				);

				?>
                <li class="woocommerce-mini-cart-item  <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) );?>"
                    data-cart-item-key="<?php echo esc_attr( $cart_item_key) ?>">
					<?php if ( ! $_product->is_visible() ) : ?>
                        <div class="minicart-item-product-image">
						    <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                        </div>
                        <span class="minicart-item-product-name"><?php echo wp_kses($product_name, $prod_name_tags); ?></span>
					<?php else : ?>
                        <a href="<?php echo esc_url( $product_permalink ); ?>" class="minicart-item-product-image">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                        </a>
                        <a href="<?php echo esc_url( $product_permalink ); ?>" class="minicart-item-product-name">
                            <span><?php echo wp_kses($product_name, $prod_name_tags); ?></span>
                        </a>
					<?php endif; ?>
	                <?php
		                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
			                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
			                esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
			                esc_html__( 'Remove this item', 'artemis-swp' ),
			                esc_attr( $product_id ),
                            esc_attr( $cart_item_key ),
			                esc_attr( $_product->get_sku() )
		                ), $cart_item_key );
	                ?>

					<?php echo WC()->cart->get_item_data( $cart_item ); ?>

					<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity',
					                          '<span class="quantity">' . esc_html__( 'Qty', 'artemis-swp' ) . sprintf( ': %s', $cart_item['quantity'] ) . '</span>',
					                          $cart_item,
					                          $cart_item_key ); ?>
					</li>
				<?php
			}
		}
		?>

	<?php else : ?>

        <li class="empty"><p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'artemis-swp' ); ?></p></li>

	<?php endif;

        do_action( 'woocommerce_mini_cart_contents' );
	?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>
    <p class="woocommerce-mini-cart__total total"><strong><?php esc_html_e( 'Subtotal', 'artemis-swp' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

    <p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
