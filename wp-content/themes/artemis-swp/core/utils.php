<?php
//fix for wishlist
if ( ! session_id() ) {
	session_start();
}

/*
	UTILITIES FUNCTIONS
*/
function ARTEMIS_SWP_getIDFromShortURL($short_url) 
{
	@$elements = explode("/", $short_url);
	@$dim = count($elements); 
	
	if ($dim == 0) {
		return "";
	} else {
		return $elements[ $dim - 1];
	}
}

function ARTEMIS_SWP_get_tax_name_by_post_type($post_type) {
	switch($post_type) {
		case "js_albums":
			return 'album_category';
		case 'js_events':
			return 'event_category';
		case 'js_photo_albums':
			return 'photo_album_category';
		case 'js_videos':
			return 'video_category';
		default:
			return 'category';
	}
}

function ARTEMIS_SWP_get_tax_name_by_page_template($page_template) {
	switch ($page_template) {
		case 'template-events-past.php':
		case 'template-events-upcoming.php':
		case 'template-events-all.php':
			return ARTEMIS_SWP_get_tax_name_by_post_type('js_events');
		case 'template-photo-gallery.php':
			return ARTEMIS_SWP_get_tax_name_by_post_type('js_photo_albums');
		default:
			return 'category';
	}
}

function ARTEMIS_SWP_is_sharing_visible() 
{
	if (function_exists("is_checkout")) {
		if (is_checkout() || 
			is_cart() || 
			is_account_page()) {
			return false;
		}
	}

	return true;
}

function ARTEMIS_SWP_is_woocommerce_active()
{
	if (class_exists('woocommerce')) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_is_woocommerce_special_page() {
	if (function_exists("is_shop")) {
		if (is_shop()) {
			return true;
		}
	}
	if (function_exists("is_product")) {
		if (is_product()) {
			return true;
		}
	}
	if (function_exists("is_cart")) {
		if (is_cart()) {
			return true;
		}
	}

	return false;
}

function ARTEMIS_SWP_is_my_account_page() {
	if (!ARTEMIS_SWP_is_woocommerce_active()) {
		return false;
	}

	if (is_account_page()) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_get_wishlist_products() {
	$products = array();
	if ( is_user_logged_in() ) {
		$wishlist_items = get_option( 'artemis_swp_wishlist_for_user_id_' . get_current_user_id() );
		if ( isset( $wishlist_items['product_in_wishlist'] ) && count( $wishlist_items['product_in_wishlist'] ) >= 1 ) {
			$products = $wishlist_items['product_in_wishlist'];
		}
	} else {
		if ( isset( $_SESSION['artemis_swp_wishlist_product_array'] ) ) {
			$products = $_SESSION['artemis_swp_wishlist_product_array'];
		}
	}
	return $products;
}

function ARTEMIS_SWP_update_wishlist_products($products) {
	if ( is_user_logged_in() ) {
		update_option( 'artemis_swp_wishlist_for_user_id_' . get_current_user_id(), array( 'product_in_wishlist' => $products ) );
	} else {
		$_SESSION['artemis_swp_wishlist_product_array'] = $products;
	}
}
function ARTEMIS_SWP_add_lost_password_link( $content ) {
	return sprintf('<p class="forgot-password"><a href="%s">%s</a></p>', esc_attr(wp_lostpassword_url(get_permalink())), esc_html__('Forgot Password?', 'artemis-swp') );
}

function ARTEMIS_SWP_get_product_width_class() {
	$template_type = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_page_template');

	if (empty($template_type) || 
		("default" == $template_type)) {
		/*default template*/
		return  "lc_swp_boxed";
	}

	return "lc_swp_full";
}

function ARTEMIS_SWP_get_tags() {
    $tags = array();
    if( ARTEMIS_SWP_is_woocommerce_active() ) {
        $args = array(
            'taxonomy' => 'product_tag',
            'echo'     => false,
            'orderby'  => 'count',
            'order'    => 'DESC',
            'number'   => 4
        );
        $tags = get_terms($args);
    }

    if( !count($tags) ){
        $args = array(
            'taxonomy' => 'post_tag',
            'echo'     => false,
            'orderby'  => 'count',
            'order'    => 'DESC',
            'number'   => 4
        );
        $tags = get_terms($args);
    }

    return $tags;
}

function ARTEMIS_SWP_get_page_custom_menu_style(&$page_logo, &$menu_bar_bg, &$menu_txt_col, &$above_menu_bg, &$above_menu_txt_col) {
	$post_id 		= ARTEMIS_SWP_get_current_page_id();

	$page_logo = $menu_bar_bg = $menu_txt_col = $above_menu_bg = $above_menu_txt_col = "";

	$page_logo 	= get_post_meta($post_id, 'lc_swp_meta_page_logo', true);
	$menu_bar_bg = get_post_meta($post_id, 'lc_swp_meta_page_menu_bg', true);
	$menu_txt_col = get_post_meta($post_id, 'lc_swp_meta_page_menu_txt_color', true);
	$above_menu_bg = get_post_meta($post_id, 'lc_swp_meta_page_above_menu_bg', true);
	$above_menu_txt_col = get_post_meta($post_id, 'lc_swp_meta_page_above_menu_txt_color', true);

	return (!empty($menu_bar_bg) ||
		!empty($menu_txt_col) || 
		!empty($above_menu_bg) || 
		!empty($above_menu_txt_col));
}

function ARTEMIS_SWP_get_current_page_id() {
	if (ARTEMIS_SWP_is_woocommerce_active()) {
		if (is_shop()) {
			return wc_get_page_id('shop');
		}
		if (is_account_page()) {
			return wc_get_page_id('myaccount');
		}
		if (is_checkout()) {
			return wc_get_page_id('checkout');	
		}
	}

	if (!in_the_loop()) {
    	/** @var $wp_query wp_query */
	    global $wp_query;
		return  $wp_query->get_queried_object_id();
	}

	return get_the_ID();
}

function ARTEMIS_SWP_get_specific_color_scheme() {
	$global_color_scheme = ARTEMIS_SWP_get_default_color_scheme();

	/*page specific scheme*/
	$post_id 		= ARTEMIS_SWP_get_current_page_id();
	$page_specific_scheme = get_post_meta($post_id, 'lc_swp_meta_page_color_scheme', true);
	
	if (empty($page_specific_scheme)) {
		return $global_color_scheme;
	}

	if ("default_scheme" != $page_specific_scheme) {
		return $page_specific_scheme;
	}

	return $global_color_scheme;
}