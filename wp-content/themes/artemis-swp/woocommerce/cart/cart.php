<?php
	/**
	 * Cart Page
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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
     * @version 3.1.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
	exit;
	}

	wc_print_notices();

	do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name" colspan="2"><?php esc_html_e( 'Product', 'artemis-swp' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'artemis-swp' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'artemis-swp' ); ?></th>
			<th class="product-subtotal"><?php esc_html_e( 'Total', 'artemis-swp' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key );
							$allowed_thumbnail_html = array (
	                            'img' => array (
		                            'src'    => array(),
		                            'class'  => array(),
		                            'width'  => array(),
		                            'height' => array(),
		                            'alt'    => array(),
		                            'srcset' => array(),
		                            'sizes' => array()
	                            )
                            );

							if ( ! $product_permalink ) {
								echo wp_kses($thumbnail, $allowed_thumbnail_html);
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses($thumbnail, $allowed_thumbnail_html) );
							}
						?>
					</td>

					<td class="product-name" data-title="<?php esc_html_e( 'Product', 'artemis-swp' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
							}

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'artemis-swp' ) . '</p>';
							}
						?>
					</td>

					<td class="product-price" data-title="<?php esc_html_e( 'Price', 'artemis-swp' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_html_e( 'Quantity', 'artemis-swp' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									                                                'input_name'  => "cart[{$cart_item_key}][qty]",
									                                                'input_value' => $cart_item['quantity'],
                                                                                    'max_value'   => $_product->get_max_purchase_quantity(),
                                                                                    'min_value'   => '0',
								                                                ), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>

					<td class="product-subtotal" data-title="<?php esc_html_e( 'Total', 'artemis-swp' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove">
						<?php
							if ( $product_permalink ) {
								//echo '<a class="edit" href="' . esc_url( $product_permalink ) . '" >' . esc_html__( 'Edit', 'artemis-swp' ) . '</a>';
								?>
								<div class="lc_js_link lc_edit_prod_cart edit" data-href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo esc_html__( 'Edit', 'artemis-swp' ); ?>
								</div>
								<?php
							}

							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove', 'artemis-swp' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() ),
								esc_html__( 'Remove', 'artemis-swp' )
							), $cart_item_key );
						?>
					</td>

				</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
		?>
        <tr>
			<td colspan="6" class="actions">


				<?php do_action( 'woocommerce_cart_actions' ); ?>
                <input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'artemis-swp' ); ?>"/>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>


<div class="cart-collaterals">
    <div class="one_of_two">
        <?php if ( wc_coupons_enabled() ) { ?>
            <div class="coupon">
                <h2><?php esc_html_e('Coupon discount', 'artemis-swp') ?></h2>
                <form method="post" action="<?php echo esc_url(wc_get_cart_url()); ?>" class="at_coupon_form">
                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                           placeholder="<?php esc_attr_e( 'Enter your coupon code if you have one', 'artemis-swp' ); ?>"/>
                    <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'artemis-swp' ); ?>"/>

                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                </form>
            </div>
        <?php } ?>
        <?php do_action( 'woocommerce_cart_collaterals' ); ?>
    </div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
