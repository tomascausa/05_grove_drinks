<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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
 * @version     3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $post, $product;

if (is_string($product)) {
    $product = wc_get_product();
}
$attachment_ids = $product->get_gallery_image_ids();

if ($attachment_ids && has_post_thumbnail()) {
    $loop    = 0;
    $columns = apply_filters('woocommerce_product_thumbnails_columns', 3);

    $li_class              = "";
    $current_prod_template = ARTEMIS_SWP_get_product_page_template();
    if ("type_1" == $current_prod_template) {
        if (ARTEMIS_SWP_show_prod_img_as_cover()) {
            $li_class = "at_swp_custom_ar ar_169";    
        }
    }

    foreach ($attachment_ids as $attachment_id) {

        ?>
        <li class="thumbnails <?php echo esc_attr('columns-' . $columns) . ' ' . esc_attr($li_class); ?> "><?php
        $classes = array();

        if ($loop === 0 || $loop % $columns === 0) {
            $classes[] = 'first';
        }

        if (($loop + 1) % $columns === 0) {
            $classes[] = 'last';
        }

        $image_class = implode(' ', $classes);
        $props       = wc_get_product_attachment_props($attachment_id, $post);

        if (!$props['url']) {
            continue;
        }

        if (($current_prod_template == 'type_2') ||
            ($current_prod_template == 'type_1') ||
            ($current_prod_template == 'type_3')
        ) {
            $image_size = 'full';
        } else {
            $image_size = 'shop_single';
        }
        $attributes = array(
            'title'                   => get_post_field( 'post_title', $attachment_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'alt'                     => $props['alt'],
            'data-src'                => $props['url'],
            'data-large_image'        => $props['url'],
            'data-large_image_width'  => $props['full_src_w'],
            'data-large_image_height' => $props['full_src_h'],
        );

        $additional_container_class = "";
        if ("type_1" == $current_prod_template) {
            $additional_container_class = " at_container_prod_img";
        }        
        $html = '<div data-thumb="' . esc_url($props['url']) . '" class="woocommerce-product-gallery__image'.$additional_container_class.'">';
        $image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', $image_size), 0, $attributes);
        $html .= sprintf(
            '<a href="%s" class="%s" title="%s" data-fancybox="images">%s</a>',
            esc_url($props['url']),
            esc_attr($image_class),
            esc_attr($props['caption']),
            $image
        );
        $html .= '</div>';
        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id);

        $loop ++;
        ?></li><?php
    }
}
