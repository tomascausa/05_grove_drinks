<?php

/*
	Load needed js scripts and css styles
*/


if (!function_exists('ARTEMIS_SWP_load_scripts_and_styles')) {
	function ARTEMIS_SWP_load_scripts_and_styles() {

		/*color scheme*/
		$scheme_file_name = ARTEMIS_SWP_get_specific_color_scheme();
		$scheme_file_name .= ".css";

		/*echo $scheme_file_name; exit(0);*/
		wp_register_style('color_scheme_css', get_template_directory_uri(). '/core/css/'.$scheme_file_name);
		wp_enqueue_style('color_scheme_css');

		wp_register_script('select2_js', get_template_directory_uri().'/assets/select2/select2.full.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'select2_js');
		wp_register_script('customScrollBar_js', get_template_directory_uri().'/assets/mCustomScrollBar/mCustomScrollbar.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'customScrollBar_js');

		wp_register_script('fancybox_js', get_template_directory_uri().'/assets/fancybox/fancybox.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'fancybox_js');
		$artemis_swp_dependencies = array(
            'jquery',
            'masonry',
            'debouncedresize',
            'justified-gallery',
            'unslider',
            'fancybox_js',
            'select2_js',
        );
        if ( ARTEMIS_SWP_is_login_popup_enabled() &&
             ! is_user_logged_in() &&
             ! ARTEMIS_SWP_is_my_account_page() &&
             'centered_menu' != ARTEMIS_SWP_get_menu_style() &&
             ARTEMIS_SWP_is_woocommerce_active() &&
             'yes' === get_option( 'woocommerce_enable_myaccount_registration' )
        ) {
            $artemis_swp_dependencies[] = 'password-strength-meter';
        }
		wp_register_script('artemis_swp', get_template_directory_uri().'/core/js/artemis_swp.js', $artemis_swp_dependencies, '', true);
		wp_enqueue_script( 'artemis_swp');

		wp_localize_script( 'artemis_swp', 'artemis_swp', array(
			'confirmCancel'       => esc_html__('Cancel', 'artemis-swp'),
			'confirmOk'       => esc_html__('Ok', 'artemis-swp'),
			'alertOk'       => esc_html__('Ok', 'artemis-swp'),
			'sliderPrevText'       => esc_html__('PREV', 'artemis-swp'),
			'sliderNextText'       => esc_html__('NEXT', 'artemis-swp')
		) );

		wp_localize_script( 'artemis_swp', 'artemis_swp_wishlist', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'emptyText'       => esc_html__('No products in wishlist.', 'artemis-swp')
		) );
		wp_localize_script( 'artemis_swp', 'artemis_swp_password_string_meter', array(
			'min_password_strength' => apply_filters( 'woocommerce_min_password_strength', 3 ),
			'i18n_password_error'   => esc_attr__( 'Please enter a stronger password.', 'artemis-swp' ),
			'i18n_password_hint'    => esc_attr__( 'The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', 'artemis-swp' )
		) );
		wp_localize_script( 'artemis_swp', 'artemis_swp_login_popup', array(
			'ajax_url'              => admin_url( 'admin-ajax.php' ),
			'general_error_text'    => esc_attr__( 'Something went wrong! Please try again later!', 'artemis-swp' )
		) );
		wp_localize_script( 'artemis_swp', 'at_quickview', array(
			'ajax_url'              => admin_url( 'admin-ajax.php' ),
		) );

		/*lightbox*/
		wp_register_script('lightbox', get_template_directory_uri().'/assets/lightbox2/js/lightbox.js', array('jquery'), '', true);
		wp_enqueue_script( 'lightbox');

		wp_register_style('lightbox', get_template_directory_uri(). '/assets/lightbox2/css/lightbox.css');
		wp_enqueue_style('lightbox');

		wp_register_style('select2_css', get_template_directory_uri(). '/assets/select2/select2.min.css');
		wp_enqueue_style('select2_css');
		wp_register_style('customScrollBar_css', get_template_directory_uri(). '/assets/mCustomScrollBar/mCustomScrollbar.min.css');
		wp_enqueue_style('customScrollBar_css');
		wp_register_style('fancybox_css', get_template_directory_uri(). '/assets/fancybox/fancybox.min.css');
		wp_enqueue_style('fancybox_css');

		/*masonry*/
		wp_enqueue_script('masonry');
		wp_enqueue_script('imagesloaded');

		/*font awesome*/
		wp_register_style('font_awesome', get_template_directory_uri(). '/assets/fa/css/fa.css');
		wp_enqueue_style('font_awesome');

		/*linear icons free*/
		wp_register_style('linearicons', get_template_directory_uri(). '/assets/linearicons/linear-style.css');
		wp_enqueue_style('linearicons');

		/*debounce resize*/
		wp_register_script('debouncedresize', get_template_directory_uri().'/core/js/jquery.debouncedresize.js', array('jquery'), '', true);
		wp_enqueue_script( 'debouncedresize');

		/*justified gallery*/
		wp_register_script('justified-gallery', get_template_directory_uri().'/assets/justifiedGallery/js/jquery.justifiedGallery.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'justified-gallery');

		wp_register_style('justified-gallery', get_template_directory_uri(). '/assets/justifiedGallery/css/justifiedGallery.min.css');
		wp_enqueue_style('justified-gallery');

		/*unslider*/
		wp_register_script('unslider', get_template_directory_uri().'/assets/unslider/unslider-min.js', array('jquery'), '', true);
		wp_enqueue_script( 'unslider');

		wp_register_style('unslider', get_template_directory_uri(). '/assets/unslider/unslider.css');
		wp_enqueue_style('unslider');

	}
}
add_action('wp_enqueue_scripts', 'ARTEMIS_SWP_load_scripts_and_styles');


if (!function_exists('ARTEMIS_SWP_load_admin_scripts_and_styles')) {
	function ARTEMIS_SWP_load_admin_scripts_and_styles() {
		wp_enqueue_media();

		/* theme settings*/
		wp_register_script('theme_settings',  get_template_directory_uri().'/settings/js/theme_settings.js', array('jquery', 'alpha_color_picker'), '', true);
		wp_enqueue_script('theme_settings');

		wp_register_style('theme_settings', get_template_directory_uri(). '/settings/css/theme_settings.css', array('alpha_color_picker'));
		wp_enqueue_style('theme_settings');

		/*alpha color picker*/
		wp_register_script('alpha_color_picker',  get_template_directory_uri().'/core/js/alpha-color-picker.js', array('jquery', 'wp-color-picker'), '', true);
		wp_enqueue_script('alpha_color_picker');

		wp_register_style('alpha_color_picker', get_template_directory_uri(). '/core/css/alpha-color-picker.css', array('wp-color-picker'));
		wp_enqueue_style('alpha_color_picker');
	}
}
add_action('admin_enqueue_scripts', 'ARTEMIS_SWP_load_admin_scripts_and_styles');

?>
