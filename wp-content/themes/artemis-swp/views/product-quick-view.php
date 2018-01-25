<?php
/**
 * Created by PhpStorm.
 * User: th
 * Date: 1 Mar 2017
 * Time: 12:48
 */
global /** @var \WC_Product $product */
$product;
global $post;
do_action( 'artemis_swp_quick_view_before' );

$props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
$image = $product->get_image( apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );;

?>
<div <?php post_class(); ?>>
	<div class="images image_gallery woocommerce-product-gallery__wrapper">
		<?php
		printf(
			'<a href="%s" class="woocommerce-main-image woocommerce-product-gallery__image" data-caption="%s" title="%s" data-fancybox="images">%s</a>',
			esc_url( $props['url'] ),
			esc_attr( $props['caption'] ),
			esc_attr( $props['caption'] ),
			$image
		);


		$attachment_ids = $product->get_gallery_image_ids();
		if ( $attachment_ids ) {
			?>
			<div class="hidden" style="display:none;">
			<?php foreach ( $attachment_ids as $attachment_id ) {
				$props = wc_get_product_attachment_props( $attachment_id, $post );

				if ( ! $props['url'] ) {
					continue;
				}
				$image_size = 'shop_single';
				echo apply_filters(
					'woocommerce_single_product_image_thumbnail_html',
					sprintf(
						'<a href="%s"  data-caption="%s" title="%s" data-fancybox="images">%s</a>',
						esc_url( $props['url'] ),
						esc_attr( $props['caption'] ),
						esc_attr( $props['caption'] ),
						wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', $image_size ), 0, $props )
					),
					$attachment_id,
					$post->ID,
					''
				);
			}
			?>
			</div>
			<?php
		}
		?>
	</div>
	<div class="summary entry-summary at_qv_product_details">
		<a href="<?php echo esc_url( get_permalink($post->ID)) ?>"><?php woocommerce_template_single_title() ?></a>
		<?php woocommerce_template_single_price() ?>
		<?php woocommerce_template_single_excerpt() ?>
		<?php woocommerce_template_single_add_to_cart() ?>
	</div>
</div>
<?php

do_action( 'artemis_swp_quick_view_after' );
