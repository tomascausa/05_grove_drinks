<?php

/*
	Load theme textdomain, editor style, auto feed links, custom background support
	Load the main stylesheet - style.css
	Load Needed Google Fonts
	Set excerpt length and Remove [...] string from excerpt
	Set the content width
*/
require_once( get_template_directory() . "/core/basic_theme_setup.php" );

/*
	Theme Settings Menu
*/
require_once( get_template_directory() . "/settings/theme_settings.php" );
require_once( get_template_directory() . "/settings/settings_getters.php" );

/*TODO: theme import menu*/

/*
	Set as theme Visual Composer
*/
if ( function_exists( "vc_set_as_theme" ) ) {
    add_action( 'vc_before_init', 'ARTEMIS_SWP_vcSetAsTheme' );
    function ARTEMIS_SWP_vcSetAsTheme() {
        vc_set_as_theme( true );
    }
}

/*
	Set as theme Slider Revolution
*/
if ( function_exists( 'set_revslider_as_theme' ) ) {
    add_action( 'init', 'ARTEMIS_SWP_RevSliderSetAsTheme' );
    function ARTEMIS_SWP_RevSliderSetAsTheme() {
        set_revslider_as_theme();
    }
}


/*
	Utilities
*/
require_once( get_template_directory() . "/core/utils.php" );

/*
	TODO: Require Lucille Demo Importer
*/
/*
	Theme Customizer
*/
require_once( get_template_directory() . "/customizer/theme_customizer.php" );
/* Setup the Theme Customizer settings and controls*/
add_action( 'customize_register', array( 'ARTEMIS_SWP_Customize', 'register' ) );
add_action( 'customize_controls_enqueue_scripts', array( 'ARTEMIS_SWP_Customize', 'register_controls' ) );

/* Output customizer CSS to live site - customizer colors*/
add_action( 'wp_head', array( 'ARTEMIS_SWP_Customize', 'header_output' ) );

/* Enqueue live preview javascript in Theme Customizer admin screen*/
add_action( 'customize_preview_init', array( 'ARTEMIS_SWP_Customize', 'live_preview' ) );


/*
	Load needed js scripts and css styles
	Calls of wp_enqueue_script and wp_enqueue_style
*/
require_once( get_template_directory() . "/core/enqueue_scripts.php" );


/*
	Register theme sidebars
*/
require_once( get_template_directory() . "/core/register_theme_sidebars.php" );


/*
	Comments template function used as callback in wp_list_comments() call in comments.php
	Comment form defaults
*/
require_once( get_template_directory() . "/core/comments_template_cbk.php" );
/*load comment reply - moved from header.php*/
if ( is_singular() ) {
    wp_enqueue_script( 'comment-reply' );
}


/*
	WooCommerce related functionality
*/
require_once( get_template_directory() . "/core/woocommerce_support.php" );


/*
	Checks if exists and install the required plugins that are coming with the theme
*/
require_once( get_template_directory() . "/core/install_required_plugins.php" );

/*
	Integrating Envato WordPress Toolkit plugin to the theme
*/
require_once( get_template_directory() . "/core/load_envato_toolkit.php" );


    /*
        wp_ajax actions
    */
    require_once( get_template_directory() . "/core/ajax_binding.php" );

/*
	Mega Menu
*/
if ( ARTEMIS_SWP_has_megamenu() ) {
    require_once( get_template_directory() . "/core/mega_menu/SWPFrontendWalkerNavMenu.php" );
    require_once( get_template_directory() . "/core/mega_menu/SWPMegaMenu.php" );
    $mega_menu_instance = new SWPMegaMenu();
}

/*
	Import/Export functionality
*/
require get_template_directory() . '/core/import-export/Artemis_SWP_Exporter.php';
require get_template_directory() . '/core/import-export/Artemis_SWP_Importer.php';

if ( class_exists( 'Artemis_SWP_Importer' ) ) {
    new Artemis_SWP_Importer();
}

/* by default exporter is disabled*/
define( "SWP_ENABLE_DEMO_EXPORT", false );
if ( SWP_ENABLE_DEMO_EXPORT && class_exists( 'Artemis_SWP_Exporter' ) ) {
    new Artemis_SWP_Exporter();
}



?>
