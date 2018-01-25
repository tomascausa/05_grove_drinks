<?php
/**
 * Plugin Name: Artemis Core
 * Plugin URI: http://artemistheme.com/themepreview/
 * Description: This plugin adds custom post types and custom meta boxes used by Artemis WooCommerce WordPress theme.
 * Version: 1.3.8
 * Author: SmartWpress
 * Author URI: http://www.smartwpress.com
 * Text Domain: artemis-swp-core
 * Domain Path: /languages
 * License: GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 
 /*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
if (!defined('CDIR_PATH')) {
	define( 'CDIR_PATH', plugin_dir_path( __FILE__ ) );
}
if (!defined('CDIR_URL')) {
	define( 'CDIR_URL', plugin_dir_url( __FILE__ ) );
}
if (!defined('VCICONS_URL')) {
	define( 'VCICONS_URL', CDIR_URL . "visual_composer/vc_icons/" );
}
//visual_composer/vc_icons/
/* 
|--------------------------------------------------------------------------
| INCLUDE FUNCTIONALITY
|--------------------------------------------------------------------------
*/

/* 
	Plugin Settings
*/
require_once( CDIR_PATH."/plugin_settings.php");

/*
	Custom Post Types 
*/
/*require_once( CDIR_PATH."/videos.php");*/

/*
	Custom post meta
*/
require_once( CDIR_PATH."/custom_meta_boxes.php");
/*
	Widgets
*/
require_once( CDIR_PATH."/widgets.php");
/*
	Visual Composer Elements
*/
require_once( CDIR_PATH."/visual_composer/add_remove_params.php");	/*add remove params for some visual composer elements*/
require_once( CDIR_PATH."/visual_composer/add_shortcodes.php");		/*add new shortcodes to be used by visual composer*/
require_once( CDIR_PATH."/visual_composer/vc_map.php");				/*map existing shortcodes to vc elements*/

/*
	AJAX functions
*/
require_once( CDIR_PATH."/ajax_binding.php");

/* 
|--------------------------------------------------------------------------
| LOAD TEXT DOMAIN
|--------------------------------------------------------------------------
*/
/*
	Load text domain
*/
function ARTEMIS_SWP_languages_init() 
{
	$domain = "artemis-swp-core";
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	$trans_location = trailingslashit( WP_LANG_DIR ) . "plugins/" . $domain . '-' . $locale . '.mo';
	/* wp-content/languages/plugins/artemis-swp-core-en_US.mo */
	if ( $loaded = load_plugin_textdomain( $domain, FALSE, $trans_location) ) {
		return $loaded;
	} else {
		/*old location, languages dir in the plugin dir*/
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/');
	}
}
add_action('init', 'ARTEMIS_SWP_languages_init');


/* 
|--------------------------------------------------------------------------
| LOAD SCRIPTS AND STYLES
|--------------------------------------------------------------------------
*/
/*
	Load scripts and styles
*/
function ARTEMIS_SWP_plugin_load_admin_scripts_and_styles() {
	/*generic admin css*/
	wp_register_style( 'js_backend_css', plugins_url('/css/backend_style.css', __FILE__));
	wp_enqueue_style( 'js_backend_css');
	
	/*alpha color picker*/
	wp_register_script( 'alpha_color_picker', plugins_url('/js/alpha-color-picker.js', __FILE__), array('jquery', 'wp-color-picker'), '', true);
	wp_enqueue_script( 'alpha_color_picker');
	wp_enqueue_style( 'alpha_color_picker', plugins_url('/css/alpha-color-picker.css', __FILE__ ), array('wp-color-picker'));

	/*vc helper*/
	wp_register_script( 'artemis_vc_helper', plugins_url('/js/artemis_vc_helper.js', __FILE__), array('jquery', 'wp-color-picker'), '', true);
	wp_enqueue_script( 'artemis_vc_helper');
}
add_action( 'admin_enqueue_scripts', 'ARTEMIS_SWP_plugin_load_admin_scripts_and_styles');

function ARTEMIS_SWP_enqueue_vc_scripts()
{
    if (vc_backend_editor()->isValidPostType()) {
        wp_enqueue_script(
            'at_swp_heading_text_responsive',
            plugins_url('/js/heading_text_responsive.js', __FILE__),
            array('jquery'),
            '1.0.0',
            true
        );
    }
}

//after vc scripts
add_action('admin_print_scripts-post.php', 'ARTEMIS_SWP_enqueue_vc_scripts', 20);
add_action('admin_print_scripts-post-new.php', 'ARTEMIS_SWP_enqueue_vc_scripts', 20);

function ARTEMIS_SWP_plugin_load_front_scripts_and_styles() {
	/*contact form action*/
	wp_register_script('at_swp_mailchimp_subscr', plugins_url('/js/at_swp_mailchimp_subscr.js', __FILE__), array('jquery'), '', true);
	wp_enqueue_script('at_swp_mailchimp_subscr');

	/*set ajax url*/
	$ajaxurl_val = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'generalErrorText' => esc_html__('Unexpected problem occurred. Please try again later.','artemis-swp-core')
	);
	wp_localize_script('at_swp_mailchimp_subscr', 'DATAVALUES', $ajaxurl_val);		

	wp_register_script('lc_swp_contact_form', plugins_url('/js/lc_swp_contact_form.js', __FILE__), array('jquery'), '', true);
	wp_enqueue_script('lc_swp_contact_form');

	/*set ajax url*/
	$ajaxurl_val = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'generalErrorText' => esc_html__('Unexpected problem occurred when sending the email','artemis-swp-core')
	);
	wp_localize_script('lc_swp_contact_form', 'DATAVALUES', $ajaxurl_val);	
}
add_action('wp_enqueue_scripts', 'ARTEMIS_SWP_plugin_load_front_scripts_and_styles');


/* 
|--------------------------------------------------------------------------
| FLUSH REWRITE RULES
|--------------------------------------------------------------------------
*/
/*
	Flush rewrite rules on activation/deactivation
	Needed by the functionality that renames the slug for custom post types and taxonomies for custom post types
*/
function ARTEMIS_SWP_activate() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'ARTEMIS_SWP_activate');

function ARTEMIS_SWP_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'ARTEMIS_SWP_deactivate');


/* 
|--------------------------------------------------------------------------
| GET PLUGIN OPTION
|--------------------------------------------------------------------------
*/
/*
	Retreive plugin option
*/
function ARTEMIS_SWP_JPT_get_plugin_option($option)
{
	$options = get_option('AC_plugin_options');
	
	if (isset($options[$option])) {
		return $options[ $option ];
	}
	
	return "";
}

function ARTEMIS_SWP_AC_get_contact_form_email() 
{
	$options = get_option('AC_plugin_options');

	$cf_email = '';
	if (isset($options['lc_mc_contact_form_email'])) {
		$cf_email = sanitize_email($options['lc_mc_contact_form_email']);
	}

	if ("" == $cf_email) {
		$cf_email = get_option("admin_email");
	}
	
	return $cf_email;
}

function ARTEMIS_SWP_map_responsive_font($responsive_text, $font_size = '', $letter_spacing = ''){
    $responsiveness = str_replace(array(
                                      '`{`',
                                      '`}`',
                                      '``',
                                  ), array('[', ']', '"'), $responsive_text);
    $responsiveness = json_decode($responsiveness, true);
    if (!$responsiveness) {
        $responsiveness = array('ls' => array(), 'fs' => array());
    }

    if ($letter_spacing) {
        $responsiveness['ls']['xl'] = $letter_spacing;
    }
    if ($font_size) {
        $responsiveness['fs']['xl'] = $font_size;
    }
    return json_encode($responsiveness);
}
?>