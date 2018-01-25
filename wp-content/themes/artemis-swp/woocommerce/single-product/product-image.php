<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
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
 * @version       3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!is_product()) {
    return '';
}

global $post, $product;

$columns                = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$placeholder            = has_post_thumbnail() ? 'with-images' : 'without-images';
$current_prod_template  = ARTEMIS_SWP_get_product_page_template();
$images_container_class = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . $placeholder,
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
) );
$li_class               = "";
if ("type_1" == $current_prod_template) {
    if (ARTEMIS_SWP_show_prod_img_as_cover()) {
        $images_container_class[] = "at_sp_cover_img_slider";
        $images_container_class[] = "at_swp_custom_ar";
        $images_container_class[] = "ar_169";

        $li_class                 = "at_swp_custom_ar ar_169";
    }
}

$custom_bg_color = '';

if ('type_2' == ARTEMIS_SWP_get_product_page_template()) {
    $slider_bg_color = get_post_meta($post->ID, 'lc_swp_meta_images_slider_bg_color', true);
    if ($slider_bg_color) {
        $custom_bg_color          = $slider_bg_color;
        $images_container_class[] = ' lc_swp_bg_color';
    }
}
?>
<div class="<?php echo esc_attr(join(' ', array_map('sanitize_html_class', $images_container_class))); ?>"
     data-color="<?php echo esc_attr($custom_bg_color) ?>"
     data-columns="<?php echo esc_attr($columns); ?>">
	    <div class="image_gallery woocommerce-product-gallery__wrapper">
	        <ul>
	            <li class="<?php echo esc_attr($li_class); ?>">
	                <?php
                    if (has_post_thumbnail()) {
                        if (is_string($product)) {
                            $product = wc_get_product();
                        }
                        $attachment_count  = count($product->get_gallery_image_ids());
                        $props             = wc_get_product_attachment_props(get_post_thumbnail_id(), $post);
                        $post_thumbnail_id = get_post_thumbnail_id( $post->ID );
                        $thumbnail_post    = get_post($post_thumbnail_id);
                        $image_title       = $thumbnail_post->post_content;
                        $thumbnail_size = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
                        $full_size_image = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );

                        if (($current_prod_template == 'type_1') ||
                            ($current_prod_template == 'type_2') ||
                            ($current_prod_template == 'type_3')
                        ) {
                            $image_size = 'full';
                        } else {
                            $image_size = 'shop_single';
                        }
                        $attributes = array(
                            'title'                   => $image_title,
                            'alt'                     => $props['alt'],
                            'data-src'                => $full_size_image[0],
                            'data-large_image'        => $full_size_image[0],
                            'data-large_image_width'  => $full_size_image[1],
                            'data-large_image_height' => $full_size_image[2],
                        );

                        $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', $image_size), $attributes);

                        $additional_container_class = "";
                        if ("type_1" == $current_prod_template) {
                            $additional_container_class = " at_container_prod_img";
                        }
                        $html = sprintf(
                            '<div data-thumb="%s" class="woocommerce-product-gallery__image'.$additional_container_class.'"><a href="%s" class="woocommerce-main-image" title="%s" data-fancybox="images">%s</a></div>',
                            esc_url($props['url']),
                            esc_url($props['url']),
                            esc_attr($props['caption']),
                            $image
                        );
                    } else {
                        $html = '<div class="woocommerce-product-gallery__image--placeholder">';
                        $placeholder_src= wc_placeholder_img_src();
                        $html .= sprintf('<a href="%s" class="woocommerce-main-image" title="%s" data-fancybox="images">' .
                                         '<img src="%s" alt="%s" class="wp-post-image"/></a>',
                                         $placeholder_src,
                                         esc_html__('Awaiting product image', 'artemis-swp'),
                                         $placeholder_src,
                                         esc_html__('Awaiting product image', 'artemis-swp')
                        );
                        $html .= '</div>';
                    }
                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id($post->ID));
                    ?>
	            </li>
                <?php do_action('woocommerce_product_thumbnails'); ?>
                <?php
                    $video_id = get_post_meta( $post->ID, 'lc_swp_meta_custom_video', true );
                    if ( $video_id ) {
                        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $video_id ), 'full' );
                        $video_post = get_post( $video_id );
                        if ( $video_post ) {
                            $video_url = wp_get_attachment_url( $video_id );
                            ?>
                            <li class="<?php echo esc_attr( $li_class ); ?>">
                                <?php
                                    $metadata = wp_get_attachment_metadata($video_id);
                                    echo wp_video_shortcode(
                                    array(
                                        'src'    => $video_url,
                                        'loop'    => true,
                                        'poster' => $featured_image[0],
                                        'width' => !empty( $metadata['width']) ? intval($metadata['width']): 1280,
                                        'height' => !empty( $metadata['height']) ? intval($metadata['height']): 720,
                                    )
                                ) ?>
                            </li>
                            <?php
                        }
                    }
                ?>
	        </ul>
	    </div>

    <?php
    /**
     * @hooked ARTEMIS_SWP_after_product_images - 10
     */
    do_action('woocommerce_after_product_images');
    ?>
	</div>
