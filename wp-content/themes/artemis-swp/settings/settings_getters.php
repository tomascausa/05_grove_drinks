<?php

function ARTEMIS_SWP_get_inner_bg_image() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_innner_bg_image');
}

function ARTEMIS_SWP_get_user_logo_img() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_logo');
}

function ARTEMIS_SWP_get_user_favicon() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_favicon');
}

function ARTEMIS_SWP_get_menu_style() {
	$menu_style = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_menu_style');

	/*cannot return empty value*/
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	return $menu_style;
}

function ARTEMIS_SWP_get_menu_message() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_menu_message');
}

function ARTEMIS_SWP_has_megamenu() {
	$menu_style = ARTEMIS_SWP_get_menu_style();
	$menus_with_mega_menu = array("centered_menu", "classic_menu", "classic_double_menu", "classic_double_menu_logo_center", "classic_double_menu_center");

	if (in_array($menu_style, $menus_with_mega_menu)) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_get_header_footer_width() {
	$header_width = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_header_footer_width');

	/*cannot return empty value*/
	if (empty($header_width)) {
		$header_width = 'full';
	}

	return $header_width;
}

function ARTEMIS_SWP_get_default_color_scheme() {
	$color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_default_color_scheme');
	if (!empty($color_scheme)) {
		return $color_scheme;
	}

	return  'black_on_white';
}

function ARTEMIS_SWP_is_sticky_menu() {
	$sticky_menu = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu) || ("enabled" == $sticky_menu)) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_is_back_to_top_enabled() {
	$back_to_top = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_back_to_top');

	if (empty($back_to_top) || ('disabled' == $back_to_top)) {
		return false;
	}

	return true;
}

function ARTEMIS_SWP_get_404_bg_image() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_bg_image');
}

function ARTEMIS_SWP_has_404_image_over_text() {
	if("background_text" == ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_styling')) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_has_sidebar_on_single() {
	$remove_sidebar = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_remove_sidebar_single');

	if (empty($remove_sidebar)) {
		return true;
	}

	return ("disabled" == $remove_sidebar) ? true : false;
}

function  ARTEMIS_SWP_get_titles_alignment_class() {
	$title_align = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_title_alignment');

	if (empty($title_align)) {
		return 'text_center';
	}

	return "center" == $title_align ? "text_center"	: "text_left";
}

function ARTEMIS_SWP_what_ajax_search_shows() {
	$search_for = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_ajax_search_for');
	if ( empty( $search_for ) ) {
		$search_for = 'product';
	}

	if ("all" == $search_for) {
		return array('post', 'product');
	}
	
	return $search_for;
}

function ARTEMIS_SWP_get_shop_width_class() {
	$shop_width = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_width');

	if (empty($shop_width)) {
		return "lc_swp_full";
	}

	return $shop_width;
}

/*
	Applies to:
	shop page,
	product cagegory page and
	product tag page
*/
function ARTEMIS_SWP_shop_has_sidebar() {
	/*
		This is a workaround used to force sidebar on demo pages
		Allows both sidebar and non sidebar for the same installation
		$_GET['has_sidebar'] expects: left/right/none
	*/
	$force_sidebar_from_url = empty( $_GET['has_sidebar'] ) ? "" : $_GET['has_sidebar'];
	if (("left" == $force_sidebar_from_url) ||
		("right" == $force_sidebar_from_url)) {
		return true;
	}
	if ("none" == $force_sidebar_from_url) {
		return false;
	}

	/*normal behavior*/
	$shop_sidebar = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar');

	if (empty($shop_sidebar)) {
		return false;
	}

	if ("none" != $shop_sidebar) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_shop_has_categories() {
    if( isset( $_GET['use_categories']) ) {
        return $_GET['use_categories'] == 'yes';
    }

    $theme_setting = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_shop_categories' );

    return 'yes' == $theme_setting;

}

function ARTEMIS_SWP_get_shop_page_sidebar() {
	/*
		This is a workaround used to force sidebar on demo pages
		Allows both sidebar and non sidebar for the same installation
		$_GET['has_sidebar'] expects: left/right/none
	*/
	$force_sidebar_from_url = empty( $_GET['has_sidebar'] ) ? "" : $_GET['has_sidebar'];
	if (("left" == $force_sidebar_from_url) ||
		("right" == $force_sidebar_from_url)) {
		return $force_sidebar_from_url;
	}

	/*normal behavior*/
	return ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar');
}

function ARTEMIS_SWP_single_product_has_sidebar() {
	$shop_sidebar_single = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar_single');

	if (empty($shop_sidebar_single)) {
		return false;
	}

	if ("none" != $shop_sidebar_single) {
		return true;
	}

	return false;
}

function ARTEMIS_SWP_get_product_page_template() {

	$template_type = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_product_page_template' );

	if ( empty( $template_type ) ) {
		$template_type = "default";
	}
	return $template_type;
}

function ARTEMIS_SWP_show_prod_img_as_cover() {
	if ("type_1" != ARTEMIS_SWP_get_product_page_template()) {
		return false;
	}

	if ("enabled" != ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_page_template_cover_img')) {
		return false;
	}

	return true;
}

function ARTEMIS_SWP_is_login_popup_enabled() {
	$enabled = ARTEMIS_SWP_get_theme_option( 'artemis_theme_general_options', 'lc_login_popup_enable' );
	if ( empty( $enabled ) ) {
		$enabled = true;
	}
	return $enabled == 'yes';
}

function ARTEMIS_SWP_get_login_popup_bg_image() {
	if(!($bg_url = ARTEMIS_SWP_get_theme_option( 'artemis_theme_general_options', 'lc_login_popup_bg_image' ))) {
		$bg_url = get_template_directory_uri() . '/core/img/login_default_bg.png';
	}
	return $bg_url;
}
function ARTEMIS_SWP_get_products_view_mode() {

	$view_modes = array( 'list', 'grid' );
	if ( isset( $_REQUEST['mode'] ) ) {
		$view_mode = sanitize_text_field( $_REQUEST['mode'] );
		if ( in_array($view_mode, $view_modes) ) {
			return $view_mode;
		}
	}

	$view_mode = isset( $_COOKIE['artemis_swp_products_view_mode'] ) ? sanitize_text_field( $_COOKIE['artemis_swp_products_view_mode'] ) : '';
	if ( in_array( $view_mode, $view_modes ) ) {
		return $view_mode;
	}

	$view_mode = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_products_view_mode' );

	if ( !in_array( $view_mode, $view_modes ) ) {
		return 'grid';
	}

	return $view_mode;
}

function ARTEMIS_SWP_get_products_per_row() {

	if ( isset( $_REQUEST['products_per_row'] ) ) {
		$ppr = intval( $_REQUEST['products_per_row'] );
		if ( 3 <= $ppr && $ppr <= 5 ) {
			return  $ppr;
		}
	}

	$ppr_in_cookie = isset( $_COOKIE['artemis_swp_products_per_row'] ) ? intval( $_COOKIE['artemis_swp_products_per_row'] ) : 0;
	if ( 3 <= $ppr_in_cookie && $ppr_in_cookie <= 5 ) {
		return $ppr_in_cookie;
	}

	$products_per_row = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_products_per_row' );

	if ( !intval( $products_per_row ) ) {
		$products_per_row = 4;
	}

	return $products_per_row;
}

function ARTEMIS_SWP_get_product_actions_hover() {
	$hover_effect = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_hover_effect');

	if (empty($hover_effect)) {
		return "default";
	}

	return $hover_effect;
}

function ARTEMIS_SWP_has_wishlist_on_menu() {
	$remove_items = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_remove_account_wish');

	if (empty($remove_items)) {
		return true;
	}

	return "keep" == $remove_items ? true : false;

}

function ARTEMIS_SWP_get_available_social_profiles() {
	$user_profiles = array();

	$available_profiles = array(
		/*'icon name'	=> 'settings name'*/
		'facebook'		=> 'lc_fb_url',
		'twitter'		=>'lc_twitter_url',
		'google-plus'	=>'lc_gplus_url',
		'youtube'		=>'lc_youtube_url',
		'soundcloud'	=>'lc_soundcloud_url',
		'apple'			=>'lc_itunes_url',
		'pinterest'		=>'lc_pinterest_url',
		'instagram'		=>'lc_instagram_url',
		'houzz'			=>'lc_houzz_url',
		'weibo'			=>'lc_weibo_url'
	);

	foreach ($available_profiles as $key =>	$profile) {
		$profile_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', $profile);

		if (!empty($profile_url)) {
			$single_profile = array();
			$single_profile['url'] 	= $profile_url;
			$single_profile['icon'] 	= $key;

			$user_profiles[] = $single_profile;
		}
	}

	return $user_profiles;
}

/*getters for footer options*/
function ARTEMIS_SWP_get_footer_color_scheme() {
	$footer_color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_color_scheme');

	if (!empty($footer_color_scheme)) {
		return $footer_color_scheme;
	}

	return 'black_on_white';
}

function ARTEMIS_SWP_get_footer_bg_image() {
	return ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_background_image');
}

function ARTEMIS_SWP_get_footer_bg_color() {
	$footer_background_color = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_background_color');

	if (!empty($footer_background_color)) {
		return $footer_background_color;
	}

	return 'rgba(255, 255, 255, 0)';
}

function ARTEMIS_SWP_get_copyrigth_text() {
	return esc_html(ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text'));
}

function ARTEMIS_SWP_get_copyrigth_url() {
	return esc_url_raw(ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_url'));
}

function ARTEMIS_SWP_have_social_on_copyright() {
	$put_social_footer = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_put_social');
	if (empty($put_social_footer)) {
		return true;
	}

	return "enabled" == $put_social_footer ? true : false;
}
/*
function ARTEMIS_SWP_get_analytics_code() {
	return esc_html(ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_analytics_code'));
}
*/
function ARTEMIS_SWP_get_copyright_bgc() {
	$copy_bgc = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text_bg_color');
	if (!empty($copy_bgc)) {
		return $copy_bgc;
	}

	return 'rgba(29, 29, 29, 1)';
}

function ARTEMIS_SWP_get_copyrigth_color_scheme() {
	$copy_color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text_color');
	if (!empty($copy_color_scheme)) {
		return $copy_color_scheme;
	}

	return 'white_on_black';
}

function ARTEMIS_SWP_get_post_bg_image($post_id) {
	return get_post_meta($post_id, 'js_swp_meta_bg_image', true);
}

function ARTEMIS_SWP_get_post_overlay_color($post_id) {
	return get_post_meta($post_id, 'lc_swp_meta_page_overlay_color', true);
}

function ARTEMIS_SWP_get_contact_address()
{
	return esc_html(ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_address'));
}

function ARTEMIS_SWP_get_contact_email()
{
	return sanitize_email(ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_email'));
}

function ARTEMIS_SWP_get_contact_phone()
{
	return esc_html(ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_phone'));
}

function ARTEMIS_SWP_get_contact_fax()
{
	return esc_html(ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_fax'));
}

function ARTEMIS_SWP_get_wishlist_url() {
	$wishlist_page_id = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_wishlist_page' );
	if ( $wishlist_page_id && $wishlist_page_id != 'none' ) {
		return get_permalink( $wishlist_page_id );
	}

	return '';
}

/*
	FONT helper functions
*/
function ARTEMIS_SWP_use_default_fonts() {
	$fonts_custom_default = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_fonts_custom_default');
	if (empty($fonts_custom_default)) {
		return true;
	}

	if ("use_defaults" == $fonts_custom_default) {
		return true;
	}

	return false;
}

if ( !function_exists('ARTEMIS_SWP_get_fonts_family_from_settings') ) {
	function ARTEMIS_SWP_get_fonts_family_from_settings() {
		if (ARTEMIS_SWP_use_default_fonts()) {
			return 'Lato:300,400,700,900&amp;subset=latin-ext';
		}

		$primary_font = ARTEMIS_SWP_get_user_primary_font();
		$secondary_font = ARTEMIS_SWP_get_user_secondary_font();

		return ARTEMIS_SWP_generate_fonts_family($primary_font, $secondary_font);
	}
}

function ARTEMIS_SWP_generate_fonts_family($primary, $secondary) {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$final_fonts = '';
	$found_fonts = 0;
	foreach($fonts_json as $font_json) {
		if (($primary == $font_json['family']) || 
			($secondary == $font_json['family'])) {

			$found_fonts++;
			if (strlen($final_fonts)) {
				$final_fonts .= '|';
			}
			$final_fonts .= str_replace(' ', '+', $font_json['family']) . ':' . $font_json['variants'];

			/*get out of the loop after two fonts found*/
			if (2 == $found_fonts) {
				break;
			}
		}/*if*/
	}/*foreach*/

	return $final_fonts . '&subset=latin,latin-ext';
}

function ARTEMIS_SWP_get_user_primary_font() {
	$primary_font = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_primary_font');
	if (empty($primary_font)) {
		return 'Lato';
	}

	return $primary_font;
}

function ARTEMIS_SWP_get_user_secondary_font() {
	$secondary_font = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_secondary_font');
	if (empty($secondary_font)) {
		return 'Lato';
	}

	return $secondary_font;
}


?>
