<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );

$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
?>
<h2><?php esc_html_e( 'Order Summary', 'artemis-swp' ); ?></h2>
<table class="shop_table order_details">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'artemis-swp' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Total', 'artemis-swp' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $order->get_items() as $item_id => $item ) {
			$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );

			wc_get_template( 'order/order-details-item.php', array(
				'order'              => $order,
				'item_id'            => $item_id,
				'item'               => $item,
				'show_purchase_note' => $show_purchase_note,
				'purchase_note'      => $product ? get_post_meta( $product->get_id(), '_purchase_note', true ) : '',
				'product'            => $product,
			) );
		}
		?>
		<?php do_action( 'woocommerce_order_items_table', $order ); ?>
	</tbody>
	<tfoot>
		<?php
		foreach ( $order->get_order_item_totals() as $key => $total ) {
			?>
            <tr class="<?php echo esc_attr( str_replace('_', '-',$key) ) ?>">
					<th scope="row"><?php echo wp_kses( $total['label'], array( 'span' => array( 'class' => array() ) ) ); ?></th>
					<td><?php echo wp_kses( $total['value'], array( 'span' => array( 'class' => array() ) ) ); ?></td>
				</tr>
			<?php
		}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

