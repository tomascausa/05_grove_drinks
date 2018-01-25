<?php
	/**
	 * Order Customer Details
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
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
<section class="woocommerce-customer-details">

    <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

            <?php endif; ?>

            <header class="woocommerce-column__title title">
                <h3><?php esc_html_e( 'Billing Address', 'artemis-swp' ); ?></h3>
            </header>
            <address>
                <?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : esc_html__( 'N/A', 'artemis-swp' ); ?>
            </address>

            <div class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">
                <?php if ( $order->get_customer_note() ) : ?>
                    <div>
                        <span class="label"><?php esc_html_e( 'Note:', 'artemis-swp' ); ?></span>
                        <span><?php echo wptexturize( $order->get_customer_note() ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $order->get_billing_email() ) : ?>
                    <div class="woocommerce-customer-details--email">
                        <span class="label"><?php esc_html_e( 'Email:', 'artemis-swp' ); ?></span>
                        <span><?php echo esc_html($order->get_billing_email() ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $order->get_billing_phone() ) : ?>
                    <div>
                        <span class="label"><?php esc_html_e( 'Phone:', 'artemis-swp' ); ?></span>
                        <span><?php echo esc_html( $order->get_billing_phone() ); ?></span>
                    </div>
                <?php endif; ?>

                <?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
            </div>

            <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

        </div><!-- /.col-1 -->
        <div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
            <header class="woocommerce-column__title title">
                <h3><?php esc_html_e( 'Shipping Address', 'artemis-swp' ); ?></h3>
            </header>
            <address>
                <?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : esc_html__( 'N/A', 'artemis-swp' ); ?>
            </address>
        </div><!-- /.col-2 -->

    </section><!-- /.col2-set -->

    <?php endif; ?>

</section>
