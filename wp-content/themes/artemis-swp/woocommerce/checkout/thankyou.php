<?php
	/**
	 * Thankyou page
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
     * @version       3.2.0
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	?>

<div class="woocommerce-order">
	<?php if ( $order ) : ?>
        <div class="col2-set artemis-swp-order-thank-you">
            <div class="col-1">
                <?php if ( $order->has_status( 'failed' ) ) : ?>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'artemis-swp' ); ?></p>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
                           class="button pay"><?php esc_html_e( 'Pay', 'artemis-swp' ) ?></a>
		                <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
                               class="button pay"><?php esc_html_e( 'My Account', 'artemis-swp' ); ?></a>
		                <?php endif; ?>
                    </p>

                <?php else : ?>
                    <h2><?php echo esc_html__( 'Order received', 'artemis-swp' ) ?></h2>
                    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'artemis-swp' ), $order ); ?></p>

                    <table class="woocommerce-order-overview woocommerce-thankyou-order-details order_details" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="order"><?php esc_html_e( 'Order', 'artemis-swp' ); ?></th>
                                <th class="date"><?php esc_html_e( 'Date', 'artemis-swp' ); ?></th>
                                <th class="total"><?php esc_html_e( 'Total', 'artemis-swp' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="woocommerce-order-overview__order order">
                                    <strong>#<?php echo esc_html($order->get_order_number()); ?></strong>
                                </td>
                                <td class="woocommerce-order-overview__date date">
                                    <strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                                </td>
                                <td class="woocommerce-order-overview__total total">
                                    <strong><?php echo wp_kses($order->get_formatted_order_total(), array(
		                                    'span'  => array( 'class' => array() ),
		                                    'small' => array( 'class' => array() )
	                                    ) ); ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clear"></div>
                <?php endif; ?>

	            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>

	            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	            <?php $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id(); ?>

	            <?php if ( $show_customer_details ) : ?>
		            <?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ); ?>
	            <?php endif; ?>

	            <?php if ( $order->get_payment_method_title() ) : ?>
                    <header class="title">
                        <h3 class="method"><?php esc_html_e( 'Payment', 'artemis-swp' ); ?></h3>
                    </header>

                    <div class="woocommerce-order-overview__payment-method method">
                        <?php do_action('artemis_swp_order_payment_method_icon', $order->get_payment_method(), $order) ?>

                        <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </div>
	            <?php endif; ?>
            </div>
            <div class="col-2">
                <div class="artemis-swp-order-summary">
                    <?php
	                    set_query_var( 'order_id', $order->get_id() );
	                    //display custom order details template
	                    get_template_part( 'views/woocommerce-custom-order-details' );
                    ?>
                </div>
            </div>
        </div>
	<?php else : ?>
        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'artemis-swp' ), null ); ?></p>
	<?php endif; ?>
</div>
