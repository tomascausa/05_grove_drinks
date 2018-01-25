<?php 

if (!function_exists('ARTEMIS_SWP_setup')) {
	function ARTEMIS_SWP_setup()
	{
		//theme textdomain for translation/localization support - load_theme_textdomain( $domain, $path )
		$domain = 'artemis-swp';
		// wp-content/languages/artemis-swp/de_DE.mo
		if (!load_theme_textdomain( $domain, trailingslashit(WP_LANG_DIR).$domain)) {
			// wp-content/themes/artemis/languages
			load_theme_textdomain('artemis-swp', get_template_directory().'/languages');
		}

		// add editor style
		add_editor_style('custom-editor-style.css');
		
		// enables post and comment RSS feed links to head
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
	 
		// enable support for Post Thumbnails, 
		add_theme_support('post-thumbnails');
		
		// register Menu
		register_nav_menus(
			array(
			  'main-menu' => esc_html__('Main Menu', 'artemis-swp'),
			  'secondary-menu' => esc_html__('Secondary Menu', 'artemis-swp')
			)
		);
		
		// custom background support
		global $wp_version;
		if (version_compare( $wp_version, '3.4', '>=')) {
			$defaults = array(
				'default-color'          => 'ffffff',
				'default-image'          => '',
				'wp-head-callback'       => 'ARTEMIS_SWP_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => ''
			);
			
			add_theme_support('custom-background',  $defaults); 
		}	

	}
}
add_action( 'after_setup_theme', 'ARTEMIS_SWP_setup' );


function ARTEMIS_SWP_custom_background_cb()
{
        $background = get_background_image();  
        $color = get_background_color();  
      
        if (!$background && !$color) {
        	return;
        }
      
        $style = $color ? "background-color: #$color;" : '';  
      
        if ( $background ) {  
            $image = " background-image: url('$background');";  
      
            $repeat = get_theme_mod( 'background_repeat', 'repeat' );  
      
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )  
                $repeat = 'repeat';  
      
            $repeat = " background-repeat: $repeat;";  
      
            $position = get_theme_mod( 'background_position_x', 'left' );  
      
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )  
                $position = 'left';  
      
            $position = " background-position: top $position;";  
      
            $attachment = get_theme_mod( 'background_attachment', 'scroll' );  
      
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )  
                $attachment = 'scroll';  
      
            $attachment = " background-attachment: $attachment;";  
      
            $style .= $image . $repeat . $position . $attachment;  
        }

		?>  
		<style type="text/css">  
			body, .woocommerce .woocommerce-ordering select option { <?php echo trim($style); ?> }  
		</style>  
		<?php  	
}

/*
	Load the main stylesheet - style.css
*/
if (!function_exists( 'ARTEMIS_SWP_load_main_stylesheet')) {
	function ARTEMIS_SWP_load_main_stylesheet()
	{
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	}
}
add_action( 'wp_enqueue_scripts', 'ARTEMIS_SWP_load_main_stylesheet' );


/*
	Load the font related css
*/
if (!function_exists( 'ARTEMIS_SWP_load_fonts_css')) {
	function ARTEMIS_SWP_load_fonts_css() {

		wp_enqueue_style('default_fonts', get_template_directory_uri() . "/core/css/fonts/default_fonts.css");	

		if (!ARTEMIS_SWP_use_default_fonts()) {
			$primary_font = ARTEMIS_SWP_get_user_primary_font();

			$user_fonts_css = '
				body, 
				.woocommerce .widget_layered_nav ul li.chosen a:before, .woocommerce .widget_layered_nav_filters ul li a:before,
				#logo, #mobile_logo, #heading_area h1,
				input[type="submit"],
				h3.footer-widget-title, h3.widgettitle,
				.lc_share_item_text, .lb-number, .lc_button, .woocommerce a.button, input.button, .woocommerce input.button, button.single_add_to_cart_button, h2.lc_post_title,
				.page_navigation, .lc_view_more,
				h1, h2, h3, h4, h5, h6 {
					font-family: ' . $primary_font . ', sans-serif;
				}
			';

			wp_add_inline_style( 'default_fonts', $user_fonts_css );
		} 
	}
}
add_action('wp_enqueue_scripts', 'ARTEMIS_SWP_load_fonts_css');

/*
	Load Needed Google Fonts
*/
if ( !function_exists('ARTEMIS_SWP_load_google_fonts') ) {
	function ARTEMIS_SWP_load_google_fonts() {

		$google_fonts_family = ARTEMIS_SWP_get_fonts_family_from_settings();

		$protocol = is_ssl() ? 'https' : 'http';
		//wp_enqueue_style( 'jamsession-opensans-oswald', $protocol."://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800|Oswald:300,400,700&subset=latin,latin-ext" );
		wp_enqueue_style('artemis-lato', $protocol."://fonts.googleapis.com/css?family=".$google_fonts_family);
	}
}
add_action( 'wp_enqueue_scripts', 'ARTEMIS_SWP_load_google_fonts' );


/*
	Control Excerpt Length
*/
if (!function_exists('ARTEMIS_SWP_excerpt_length')) {
	function ARTEMIS_SWP_excerpt_length($length)
	{
		return 40;
	}
}
add_filter( 'excerpt_length', 'ARTEMIS_SWP_excerpt_length', 999);


/*
	Remove [...] string from excerpt
*/
if ( ! function_exists( 'ARTEMIS_SWP_excerpt_more' ) ) {
	function ARTEMIS_SWP_excerpt_more($more) {
		return '...';
	}
}
add_filter('excerpt_more', 'ARTEMIS_SWP_excerpt_more');

/*
	Make Sure Content Width is Set
*/
if (!isset($content_width)) {
	$content_width = 900;
}

?>