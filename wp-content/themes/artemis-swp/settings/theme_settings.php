<?php

define("LC_SWP_PRINT_SETTINGS", false);

function ARTEMIS_SWP_setup_admin_menus()
{

	add_theme_page(
        'Artemis Theme Settings', /* page title*/
		'Artemis Settings',  /* menu title */
		'administrator',    /*capability*/
        'artemis_menu_page',  /*menu_slug*/
		'ARTEMIS_SWP_option_page_settings'  /*function */
		);		
}
add_action("admin_menu", "ARTEMIS_SWP_setup_admin_menus");


/*add theme settings to admin bar*/
function ARTEMIS_SWP_add_settings_to_adminbar($admin_bar) {

	$admin_bar->add_menu( 
		array(
        'id'    => 'artemis-settings',
        'title' => esc_html__("Artemis Settings", "artemis-swp"),
        'href'  => admin_url( 'themes.php?page=artemis_menu_page'),
        'meta'  => array(
            'title' => esc_html__("Go To Artemis Settings", "artemis-swp")
        	)
    	)
	);
}
add_action('admin_bar_menu', 'ARTEMIS_SWP_add_settings_to_adminbar', 9999);


function ARTEMIS_SWP_option_page_settings()
{
?>  
	<!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap">  
        <div id="icon-themes" class="icon32"></div>
        <h2>Artemis Theme Settings</h2>  
  
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->  
        <?php settings_errors(); ?> 
		
		<?php  
		if(isset($_GET['tab'])) {
			$active_tab = $_GET['tab'];  
		} else {
		    $active_tab = 'general_options';
		}
		?>  		
		
		<h2 class="nav-tab-wrapper">
			<?php
				$general_options_class = $active_tab == 'general_options' ? 'nav-tab-active' : '';
				$social_options_class = $active_tab == 'social_options' ? 'nav-tab-active' : '';
				$footer_options_class = $active_tab == 'footer_options' ? 'nav-tab-active' : '';
				$contact_options_class = $active_tab == 'contact_options' ? 'nav-tab-active' : '';
				$font_options_class = $active_tab == 'font_options' ? 'nav-tab-active' : '';
				$shop_options_class = $active_tab == 'shop_options' ? 'nav-tab-active' : '';
			?>
			<a href="?page=artemis_menu_page&tab=general_options" class="nav-tab <?php echo esc_attr($general_options_class); ?>">General Options</a>
			<a href="?page=artemis_menu_page&tab=social_options" class="nav-tab <?php echo esc_attr($social_options_class); ?>">Social Options</a>  
			<a href="?page=artemis_menu_page&tab=footer_options" class="nav-tab <?php echo esc_attr($footer_options_class); ?>">Footer Options</a>  
			<a href="?page=artemis_menu_page&tab=contact_options" class="nav-tab <?php echo esc_attr($contact_options_class); ?>">Contact Data</a>  
			<a href="?page=artemis_menu_page&tab=font_options" class="nav-tab <?php echo esc_attr($font_options_class); ?>">Fonts</a>  
			<a href="?page=artemis_menu_page&tab=shop_options" class="nav-tab <?php echo esc_attr($shop_options_class); ?>">Shop</a>  
		</h2> 		
  
        <!-- Create the form that will be used to render our options -->  
        <form method="post" action="options.php"> 
			<?php
				if ($active_tab == 'general_options') {
					settings_fields( 'artemis_theme_general_options'); 
					do_settings_sections( 'artemis_theme_general_options');
				} elseif ($active_tab == 'social_options') {
					settings_fields( 'artemis_theme_social_options'); 
					do_settings_sections( 'artemis_theme_social_options');
				} elseif ($active_tab == 'footer_options') {
					settings_fields( 'artemis_theme_footer_options'); 
					do_settings_sections( 'artemis_theme_footer_options');
				} elseif ($active_tab == 'contact_options') {
					settings_fields( 'artemis_theme_contact_options'); 
					do_settings_sections( 'artemis_theme_contact_options');
				} elseif ($active_tab == 'shop_options') {
					settings_fields( 'artemis_theme_shop_options'); 
					do_settings_sections( 'artemis_theme_shop_options');
				} elseif ($active_tab == 'font_options') {
					settings_fields( 'artemis_theme_font_options'); 
					do_settings_sections( 'artemis_theme_font_options');
				}
				submit_button(); 
			?>  
        </form>  
  
    </div><!-- /.wrap -->  
<?php 
}

/*
	Initialize theme options
*/
add_action('admin_init', 'ARTEMIS_SWP_initialize_theme_options');
function ARTEMIS_SWP_initialize_theme_options() 
{
	$lc_swp_available_theme_options = array (
		array (
			'option_name'		=> 'artemis_theme_general_options',
			'section_id'		=> 'artemis_general_settings_section',
			'title'				=> esc_html__('General Options', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_general_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_general_options'
		),
		array (
			'option_name'		=> 'artemis_theme_social_options',
			'section_id'		=> 'artemis_social_settings_section',
			'title'				=> esc_html__('Social Options', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_social_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_social_options'
		),
		array (
			'option_name'		=> 'artemis_theme_footer_options',
			'section_id'		=> 'artemis_footer_settings_section',
			'title'				=> esc_html__('Footer Options', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_footer_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_footer_options'
		),
		array (
			'option_name'		=> 'artemis_theme_contact_options',
			'section_id'		=> 'artemis_contact_settings_section',
			'title'				=> esc_html__('Contact Options', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_contact_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_contact_options'
		),
		array (
			'option_name'		=> 'artemis_theme_font_options',
			'section_id'		=> 'artemis_font_settings_section',
			'title'				=> esc_html__('Choose Fonts', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_font_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_font_options'
		),		
		array (
			'option_name'		=> 'artemis_theme_shop_options',
			'section_id'		=> 'artemis_shop_settings_section',
			'title'				=> esc_html__('Shop Options', 'artemis-swp'),
			'callback'			=> 'ARTEMIS_SWP_shop_options_callback',
			'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_shop_options'
		)		
	);

	foreach($lc_swp_available_theme_options as $theme_option) {
		/*
			Add available options
		*/
		if (false == get_option($theme_option['option_name'])) {
			add_option($theme_option['option_name']);
		}

		/*
			Add setting sections
		*/
		add_settings_section (
			$theme_option['section_id'],		// ID used to identify this section and with which to register options
			$theme_option['title'],				// Title to be displayed on the administration page
			$theme_option['callback'],			// Callback used to render the description of the section
			$theme_option['option_name']		// Page on which to add this section of options
		);
	}

	/*
		call add_settings_field to add theme options
	*/
	ARTEMIS_SWP_add_settings_fields();

	/*
		Register settings
	*/
	foreach($lc_swp_available_theme_options as $theme_option) {
		register_setting(
			//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
			$theme_option['option_name'],
			// option_name -  The name of an option to sanitize and save. 
			$theme_option['option_name'],
			//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
			$theme_option['sanitize_callback']  	
		);
	}
}

/*
	Callbacks that render the description for each tab
*/
function ARTEMIS_SWP_general_options_callback() {
?>
	<p>
		<?php echo esc_html__('Setup custom logo and favicon.', 'artemis-swp'); ?>
	</p>
<?php	
	/*print theme settings*/
	if (LC_SWP_PRINT_SETTINGS) {
		$general = get_option('artemis_theme_general_options');
		
		?>
		<pre>artemis_theme_general_options:
			<?php echo (json_encode($general)); ?>
		</pre>
		<?php
	}
}
 
function ARTEMIS_SWP_social_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Provide the URL to the social profiles you would like to display.', 'artemis-swp'); ?>
	</p>
	<?php	
}

function ARTEMIS_SWP_footer_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Setup footer text for the copyright area, footer text URL and analytics code. Also setup the footer widget area.', 'artemis-swp'); ?>
	</p>
	<?php
}

function ARTEMIS_SWP_contact_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Please insert your contact information.', 'artemis-swp'); ?>
	</p>
	<?php
}

function ARTEMIS_SWP_font_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Please select the fonts used by Artemis.', 'artemis-swp'); ?>
	</p>
	<?php
}

function ARTEMIS_SWP_shop_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Change WooCommerce shop related settings.', 'artemis-swp'); ?>
	</p>
	<?php
}


/*
	Add setting fields
*/
function ARTEMIS_SWP_add_settings_fields() {
	/*general options array*/
	$general_settings = array (
		array (
			'id'		=> 'lc_custom_logo',
			'label'		=> esc_html__('Upload logo image', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_logo_select_cbk'
		),
		array (
			'id'		=> 'lc_custom_favicon',
			'label'		=> esc_html__('Upload custom favicon', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_favicon_select_cbk'
		),
		array (
			'id'		=> 'lc_custom_innner_bg_image',
			'label'		=> esc_html__('Upload custom background image', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_innner_bg_image_select_cbk'
		),
		array (
			'id'		=> 'lc_menu_style',
			'label'		=> esc_html__('Choose menu style', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_menu_style_cbk'
		),
		array (
			'id'		=> 'lc_menu_message',
			'label'		=> esc_html__('Insert menu message', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_menu_message_cbk'
		),		
		array (
			'id'		=> 'lc_header_footer_width',
			'label'		=> esc_html__('Choose header/footer width', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_header_footer_width_cbk'
		),
		array (
			'id'		=> 'lc_default_color_scheme',
			'label'		=> esc_html__('Choose default color scheme', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_default_colorscheme_cbk'
		),
		array (
			'id'		=> 'lc_enable_sticky_menu',
			'label'		=> esc_html__('Enable sticky menu', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_enable_sticky_menu_cbk'
		),
		array (
			'id'		=> 'lc_back_to_top',
			'label'		=> esc_html__('Enable back to top button', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_back_to_top_cbk'
		),
		array (
			'id'		=> 'lc_404_bg_image',
			'label'		=> esc_html__('404 page template background image', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_404_bg_image'
		),
		array (
			'id'		=> 'lc_404_overlay',
			'label'		=> esc_html__('404 page template background overlay', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_404_overlay'
		),		
		array (
			'id'		=> 'lc_404_styling',
			'label'		=> esc_html__('404 page template styling', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_404_styling'
		),
		array (
			'id'		=> 'lc_remove_sidebar_single',
			'label'		=> esc_html__('Remove sidebar for posts', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_remove_sidebar_single'
		),
		array (
			'id'		=> 'lc_title_alignment',
			'label'		=> esc_html__('Titles alignment', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_title_alignment'
		),
		array (
			'id'		=> 'lc_login_popup_enable',
			'label'		=> esc_html__('Login Popup', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_login_popup_enable'
		),
		array (
			'id'		=> 'lc_login_popup_bg_image',
			'label'		=> esc_html__('Login Popup Background Image', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_login_popup_bg_image'
		),
		array (
			'id'		=> 'lc_ajax_search_for',
			'label'		=> esc_html__('Ajax Search Is For', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_ajax_search_for'
		)		
	);

	foreach($general_settings as $general_setting) {
	    add_settings_field(   
	        $general_setting['id'],         		// ID used to identify the field throughout the theme                
	        $general_setting['label'],              // The label to the left of the option interface element            
	        $general_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_general_options',   		// The page on which this option will be displayed  
	        'artemis_general_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*social options array*/
	$social_settings = array(
		array (
			'id'		=> 'lc_fb_url',
			'label'		=> esc_html__('Facebook URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_fb_url_cbk'			
		),
		array (
			'id'		=> 'lc_twitter_url',
			'label'		=> esc_html__('Twitter URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_twitter_url_cbk'			
		),
		/*Google+, YouTube, Vimeo, SoundCloud, Myspace, Pinterest, iTunes*/
		array (
			'id'		=> 'lc_gplus_url',
			'label'		=> esc_html__('Google+ URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_gplus_url_cbk'			
		),
		array (
			'id'		=> 'lc_youtube_url',
			'label'		=> esc_html__('YouTube URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_youtube_url_cbk'			
		),
		array (
			'id'		=> 'lc_soundcloud_url',
			'label'		=> esc_html__('SoundCloud URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_soundcloud_url_cbk'			
		),
		/*no font awesome icon for myspace*/
		array (
			'id'		=> 'lc_itunes_url',
			'label'		=> esc_html__('iTunes URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_itunes_url_cbk'			
		),
		array (
			'id'		=> 'lc_pinterest_url',
			'label'		=> esc_html__('Pinterest URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_pinterest_url_cbk'			
		),
		array (
			'id'		=> 'lc_instagram_url',
			'label'		=> esc_html__('Instagram URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_instagram_url_cbk'			
		),
		array (
			'id'		=> 'lc_houzz_url',
			'label'		=> esc_html__('Houzz URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_houzz_url_cbk'			
		),
		array (
			'id'		=> 'lc_weibo_url',
			'label'		=> esc_html__('Weibo URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_weibo_url_cbk'			
		)		

	);
	foreach($social_settings as $social_setting) {
	    add_settings_field(   
	        $social_setting['id'],         		// ID used to identify the field throughout the theme                
	        $social_setting['label'],              // The label to the left of the option interface element            
	        $social_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_social_options',   		// The page on which this option will be displayed  
	        'artemis_social_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*footer options array*/
	$footer_settings = array(
		array(
			'id'		=> 'lc_footer_widgets_color_scheme',
			'label'		=> esc_html__('Footer widgets color scheme', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_footer_widget_cs_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_image',
			'label'		=> esc_html__('Footer widgets Background Image', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_footer_widget_bgimg_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_color',
			'label'		=> esc_html__('Footer widgets color overlay', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_footer_widget_bgcolor_cbk'		
		),		
		array(
			'id'		=> 'lc_copyright_text',
			'label'		=> esc_html__('Copyright text', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_copyright_text_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_url',
			'label'		=> esc_html__('Copyrigth URL', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_copyright_url_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_color',
			'label'		=> esc_html__('Copyrigth Text Color Scheme', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_copyright_cs_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_bg_color',
			'label'		=> esc_html__('Copyrigth Text Background Color', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_copyright_bgc_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_put_social',
			'label'		=> esc_html__('Place social icons on footer', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_copyright_put_social_cbk'		
		)		
	);
	foreach($footer_settings as $footer_setting) {
	    add_settings_field(   
	        $footer_setting['id'],         		// ID used to identify the field throughout the theme                
	        $footer_setting['label'],              // The label to the left of the option interface element            
	        $footer_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_footer_options',   		// The page on which this option will be displayed  
	        'artemis_footer_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*contact options array*/
	$contact_settings = array(
		array(
			'id'		=> 'lc_contact_address',
			'label'		=> esc_html__('Contact address', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_lc_contact_address_cbk'		
		),
		array(
			'id'		=> 'lc_contact_phone',
			'label'		=> esc_html__('Contact phones', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_lc_contact_phone_cbk'		
		),
		array(
			'id'		=> 'lc_contact_fax',
			'label'		=> esc_html__('Contact Fax Number', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_lc_contact_fax_cbk'		
		),
		array(
			'id'		=> 'lc_contact_email',
			'label'		=> esc_html__('Contact E-mail', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_lc_contact_email_cbk'		
		)
	);

	foreach($contact_settings as $contact_setting) {
	    add_settings_field(   
	        $contact_setting['id'],         		// ID used to identify the field throughout the theme                
	        $contact_setting['label'],              // The label to the left of the option interface element            
	        $contact_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_contact_options',   		// The page on which this option will be displayed  
	        'artemis_contact_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*fonts options array*/
	$font_settings = array(
		array(
			'id'		=> 'at_fonts_custom_default',
			'label'		=> esc_html__('Fonts in use', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_at_fonts_custom_default_cbk'		
		),
		array(
			'id'		=> 'at_primary_font',
			'label'		=> esc_html__('Primary font', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_at_primary_font_cbk'
		),
		array(
			'id'		=> 'at_secondary_font',
			'label'		=> esc_html__('Secondary font', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_at_secondary_font_cbk'		
		)
	);

	foreach($font_settings as $font_setting) {
	    add_settings_field(   
	        $font_setting['id'],         		// ID used to identify the field throughout the theme                
	        $font_setting['label'],              // The label to the left of the option interface element            
	        $font_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_font_options',   		// The page on which this option will be displayed  
	        'artemis_font_settings_section'    	// The name of the section to which this field belongs  
	    );
	}	

	/*shop options arrat*/
	$artemis_shop_settings = array(
		array (
			'id'		=> 'lc_wishlist_page',
			'label'		=> esc_html__('Wishlist Page', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_wishlist_page'
		),
		array (
			'id'		=> 'lc_shop_width',
			'label'		=> esc_html__('Shop Page Width', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_shop_width'
		),		 
		array (
			'id'		=> 'lc_shop_sidebar',
			'label'		=> esc_html__('Shop Page Sidebar', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_shop_sidebar'
		),
		array (
			'id'		=> 'lc_shop_categories',
			'label'		=> esc_html__('Show product categories', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_shop_categories'
		),
		array (
			'id'		=> 'lc_shop_sidebar_single',
			'label'		=> esc_html__('Single Product Sidebar', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_shop_single_sidebar'
		),
		array (
			'id'		=> 'lc_product_page_template',
			'label'		=> esc_html__('Product Page Template', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_product_page_template'
		),
		array (
			'id'		=> 'lc_product_page_template_cover_img',
			'label'		=> esc_html__('Show Product Image As Cover', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_product_page_template_cover_img'
		),		
		array (
			'id'		=> 'lc_products_view_mode',
			'label'		=> esc_html__('Products View Mode', 'artemis-swp'),
			'callback'	=> 'ARTEMIS_SWP_lc_products_view_mode'
		),
		array (
			'id'		=> 'lc_products_per_row',
			'label'		=> esc_html__('Products Per Row', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_products_per_row'
		),
		array (
			'id'		=> 'lc_product_hover_effect',
			'label'		=> esc_html__('Hover effect for product image', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_product_hover_effect'
		),
		array (
			'id'		=> 'lc_remove_account_wish',
			'label'		=> esc_html__('Remove My Account and Wishlist', 'artemis-swp'),
			'callback'	=> 'Artemis_SWP_lc_remove_account_wish'
		)		
	);

	foreach($artemis_shop_settings as $artemis_shop_setting) {
	    add_settings_field(   
	        $artemis_shop_setting['id'],         		// ID used to identify the field throughout the theme                
	        $artemis_shop_setting['label'],              // The label to the left of the option interface element            
	        $artemis_shop_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'artemis_theme_shop_options',   		// The page on which this option will be displayed  
	        'artemis_shop_settings_section'    	// The name of the section to which this field belongs  
	    );
	}	
}

/*
	Sanitize Functions
*/
function  ARTEMIS_SWP_sanitize_general_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			if (($key == 'lc_custom_favicon') || 
				($key == 'lc_custom_logo')) {
				$output[$key] = esc_url_raw(trim( $input[$key] ) );
			} else {
				$output[$key] =  esc_html(trim($input[$key])) ;	
			}
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_general_options', $output, $input);
}

function ARTEMIS_SWP_sanitize_social_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_url_raw(trim($input[$key])) ;
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_social_options', $output, $input);
}

function ARTEMIS_SWP_sanitize_footer_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			switch($key) {
				case 'lc_copyright_url':
				case 'lc_footer_widgets_background_image':
					$output[$key] =  esc_url_raw(trim($input[$key]));
					break;
				default:
					$output[$key] =  esc_html(trim($input[$key]));
					break;
			}
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_footer_options', $output, $input);
}

function ARTEMIS_SWP_sanitize_contact_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			switch ($key) {
				case 'lc_contact_email':
					$output[$key] = sanitize_email(trim($input[$key]));
					break;
				case 'lc_contact_map_url':
					$output[$key] = esc_url_raw(trim($input[$key]));
					break;
				default:
					$output[$key] =  esc_html(trim($input[$key]));	
			}
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_contact_options', $output, $input);
}

function ARTEMIS_SWP_sanitize_font_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_html(trim($input[$key]));	
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_font_options', $output, $input);	
}

function ARTEMIS_SWP_sanitize_shop_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_html(trim($input[$key])) ;	
		}
	}

	return apply_filters('ARTEMIS_SWP_sanitize_shop_options', $output, $input);
}
/*
	CALLBACKS FOR SETTINGS FIELDS
*/
function ARTEMIS_SWP_logo_select_cbk() {
	$logo_url = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_logo');

?>
	<input id="lc_swp_logo_upload_value" type="text" name="artemis_theme_general_options[lc_custom_logo]" size="150" value="<?php echo esc_url($logo_url); ?>"/>
	<input id="lc_swp_upload_logo_button" type="button" class="button" value="<?php echo esc_html__('Upload Logo', 'artemis-swp'); ?>" />
	<input id="lc_swp_remove_logo_button" type="button" class="button" value="<?php echo esc_html__('Remove Logo', 'artemis-swp'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom logo image.', 'artemis-swp'); ?>
	</p>

	<div id="lc_logo_image_preview">
		<img class="lc_swp_setting_preview_logo" src="<?php echo esc_url($logo_url); ?>">
	</div>

<?php
}

function Artemis_SWP_favicon_select_cbk() {
	$favicon_url = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_favicon');

	if (function_exists('wp_site_icon')) {
?>
	<p class="description notice notice-success">
		<?php echo esc_html__('Hi, your WordPress version is higher than 4.3 and allows you to use the built in WordPress functionality related to custom favicon.', 'artemis-swp'); ?>
		<br>
		<?php echo esc_html__('Please go to Appearance - Customize - Site Identity and choose the favicon from that place.', 'artemis-swp'); ?>
		<br>
		<?php echo esc_html__('For your WordPress version, the Upload custom favicon option will be ignored, the one from customizer will be used.', 'artemis-swp'); ?>
		<br>
		<?php echo esc_html__('This option exists only for backward compatibility reasons.', 'artemis-swp'); ?>
	</p>
<?php
	}
?>

	<input id="lc_swp_favicon_upload_value" type="text" name="artemis_theme_general_options[lc_custom_favicon]" size="150" value="<?php echo esc_url($favicon_url); ?>"/>
	<input id="lc_swp_upload_favicon_button" type="button" class="button" value="<?php echo esc_html__('Upload Favicon', 'artemis-swp'); ?>" />
	<input id="lc_swp_remove_favicon_button" type="button" class="button" value="<?php echo esc_html__('Remove Favicon', 'artemis-swp'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom favicon image.', 'artemis-swp'); ?>
	</p>

	<div id="lc_favicon_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($favicon_url); ?>">
	</div>
<?php
}

function Artemis_SWP_innner_bg_image_select_cbk() {
	$inner_bg_img_url = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_custom_innner_bg_image');
?>

	<input id="lc_swp_innner_bg_image_upload_value" type="text" name="artemis_theme_general_options[lc_custom_innner_bg_image]" size="150" value="<?php echo esc_url($inner_bg_img_url); ?>"/>
	<input id="lc_swp_upload_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'artemis-swp'); ?>" />
	<input id="lc_swp_remove_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'artemis-swp'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for inner pages.', 'artemis-swp'); ?>
	</p>

	<div id="lc_innner_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($inner_bg_img_url); ?>">
	</div>	
<?php	
}

function Artemis_SWP_menu_style_cbk() {
	$menu_style = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_menu_style');
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	$menu_options = array(
		esc_html__('Creative Menu', 'artemis-swp')			=> 'creative_menu',
		esc_html__('Classic Menu', 'artemis-swp')			=> 'classic_menu',		
		esc_html__('Centered Menu', 'artemis-swp')			=> 'centered_menu',
		esc_html__('Classic Doubled Menu', 'artemis-swp')	=> 'classic_double_menu',
		esc_html__('Classic Doubled Menu Logo Center', 'artemis-swp')	=> 'classic_double_menu_logo_center',
		esc_html__('Classic Doubled Menu Center', 'artemis-swp')	=> 'classic_double_menu_center'
	);
?>

	<select id="lc_menu_style" name="artemis_theme_general_options[lc_menu_style]">
		<?php ARTEMIS_SWP_render_select_options($menu_options, $menu_style); ?>
	</select>
<?php	
}

function Artemis_SWP_back_to_top_cbk() {
	$back_to_top = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_back_to_top');
	if (empty($back_to_top)) {
		$back_to_top = 'disabled';
	}

	$options = array(
		esc_html__('Yes - enabled', 'artemis-swp')			=> 'enabled',
		esc_html__('No - disabled', 'artemis-swp')			=> 'disabled'
	);
?>

	<select id="lc_back_to_top" name="artemis_theme_general_options[lc_back_to_top]">
		<?php ARTEMIS_SWP_render_select_options($options, $back_to_top); ?>
	</select>
    <p class="description">
		<?php echo esc_html__( 'Enable or disable back to top button.', 'artemis-swp' ); ?>
	</p>
<?php
}

function Artemis_SWP_menu_message_cbk() {
	$menu_message = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_menu_message');

?>
	<input id="lc_menu_message" type="text" name="artemis_theme_general_options[lc_menu_message]" size="150" value="<?php echo esc_attr($menu_message); ?>"/>
	<p class="description">
		<?php echo esc_html__('Insert a short message that will be shown above the menu bar.', 'artemis-swp').'<br>'; ?>
		<?php echo esc_html__('Ex: [WE SHIP EVERYWHERE! FREE IN THE US!].', 'artemis-swp').'<br>'; ?>
		<?php echo esc_html__('This setting is available only for the following menu styles: [Classic Doubled Menu, Classic Doubled Menu Logo Center]', 'artemis-swp'); ?>
	</p>	
<?php

}

function Artemis_SWP_header_footer_width_cbk() {
	$header_width = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_header_footer_width');
	if (empty($header_width)) {
		$header_width = 'full';
	}

	$width_options = array(
		'Full Width'	=> 'full',
		'Boxed Width'	=> 'boxed'
	);
?>
	<select id="lc_header_footer_width" name="artemis_theme_general_options[lc_header_footer_width]">
		<?php ARTEMIS_SWP_render_select_options($width_options, $header_width); ?>
	</select>
<?php
}

function Artemis_SWP_default_colorscheme_cbk() {
	$color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_default_color_scheme');
	if (empty($color_scheme)) {
		$color_scheme = 'black_on_white';
	}

	$color_schemes = array(
		esc_html__('White On Black', 'artemis-swp')	=> 'white_on_black',
		esc_html__('Black on White', 'artemis-swp')	=> 'black_on_white'
	);
?>

	<select id="lc_default_color_scheme" name="artemis_theme_general_options[lc_default_color_scheme]">
		<?php ARTEMIS_SWP_render_select_options($color_schemes, $color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Default color scheme used for the website content.', 'artemis-swp').'<br>'; ?>
		<?php echo esc_html__('Black On White - black text on white background.', 'artemis-swp'); ?>
		<?php echo esc_html__('White On Black - white text on black background.', 'artemis-swp').'<br>'; ?>
		<?php echo esc_html__('If you change this value, you might need to change the background color or image for your website according to the color scheme.', 'artemis-swp'); ?>
		<?php echo esc_html__('You can change the background color for your website from Appearance - Customize - Colors.', 'artemis-swp'); ?>
	</p>
<?php	
}

function ARTEMIS_SWP_enable_sticky_menu_cbk() {
	$sticky_menu = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu)) {
		$sticky_menu = 'enabled';
	}

	$sticky_options = array(
		esc_html__('Enabled', 'artemis-swp')	=> 'enabled',
		esc_html__('Disabled', 'artemis-swp')	=> 'disabled'
	);
?>
	<select id="lc_enable_sticky_menu" name="artemis_theme_general_options[lc_enable_sticky_menu]">
		<?php ARTEMIS_SWP_render_select_options($sticky_options, $sticky_menu); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Enable or disable sticky menu bar. If enabled, menu will stay on top whyle the user moves the scrollbar.', 'artemis-swp'); ?>
	</p>
<?php
}

function Artemis_SWP_404_bg_image() {
	$bg_image_404 = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_bg_image');

?>
	<input id="lc_404_bg_image_value" type="text" name="artemis_theme_general_options[lc_404_bg_image]" size="150" value="<?php echo esc_url($bg_image_404); ?>"/>
	<input id="lc_swp_upload_404_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload 404 Image', 'artemis-swp'); ?>" />
	<input id="lc_swp_remove_404_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove 404 Image', 'artemis-swp'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom image for your 404 page template.', 'artemis-swp'); ?>
	</p>

	<div id="lc_404_image_preview">
		<img class="lc_swp_setting_preview_404_image" src="<?php echo esc_url($bg_image_404); ?>">
	</div>

<?php
}

function Artemis_SWP_404_overlay() {
	$overlay_404 = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_overlay');
	$default_bg_color = 'rgba(0, 0, 0, 0)';

	if ('' == $overlay_404) {
		$overlay_404 = $default_bg_color;
	}
?>
	<input type="text" id="lc_404_overlay" class="alpha-color-picker-settings" name="artemis_theme_general_options[lc_404_overlay]" value="<?php echo esc_attr($overlay_404); ?>" data-default-color="rgba(0, 0, 0, 0)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Color overlay for the 404 page template. It is used only in combination with background image.', 'artemis-swp'); ?>
	</p>
<?php		
}

function Artemis_SWP_404_styling() {
	$styling_404 = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_styling');

	if (empty($styling_404)) {
		$styling_404 = 'background_image';
	}

	$options_404 = array(
		esc_html__('Page background image', 'artemis-swp')	=> 'background_image',
		esc_html__('Text backgound image', 'artemis-swp')	=> 'background_text'
	);
?>
	<select id="lc_404_styling" name="artemis_theme_general_options[lc_404_styling]">
		<?php ARTEMIS_SWP_render_select_options($options_404, $styling_404); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Select the styling for your 404 page template. 404 page template is the page template shown when some resource is not found on your website', 'artemis-swp'); ?>
	</p>
<?php
}

function Artemis_SWP_remove_sidebar_single() {
	$remove_sidebar = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_remove_sidebar_single');

	if (empty($remove_sidebar)) {
		$remove_sidebar = 'disabled';
	}

	$remove_sidebar_values = array(
		esc_html__('Disabled - Keep Sidebar', 'artemis-swp')	=> 'disabled',		
		esc_html__('Enabled - Remove Sidebar', 'artemis-swp')	=> 'enabled'
	);
?>
	<select id="lc_remove_sidebar_single" name="artemis_theme_general_options[lc_remove_sidebar_single]">
		<?php ARTEMIS_SWP_render_select_options($remove_sidebar_values, $remove_sidebar); ?>
	</select>
	
	<p class="description">
		<?php echo esc_html__('Remove sidebar for single posts', 'artemis-swp'); ?>
	</p>
<?php
}

function Artemis_SWP_title_alignment() {
	$title_align = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_title_alignment');

	if (empty($title_align)) {
		$title_align = 'center';
	}

	$title_align_values = array(
		esc_html__('Center', 'artemis-swp')	=> 'center',		
		esc_html__('Left', 'artemis-swp')	=> 'left'
	);
?>
	<select id="lc_title_alignment" name="artemis_theme_general_options[lc_title_alignment]">
		<?php ARTEMIS_SWP_render_select_options($title_align_values, $title_align); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Align title and default content elements. Applies to page title, comments area title, comment form button, etc.', 'artemis-swp'); ?>
	</p>	
<?php	
}

function Artemis_SWP_wishlist_page() {
	$wishlist_page = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_wishlist_page');

	if( !$wishlist_page ) {
	    $wishlist_page = 'none';
    }

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'template-wishlist.php',
		)
	);

	$options = array(
		esc_html__( 'Please select', 'artemis-swp' ) => 'none'
	);
	if ( $pages ) {
		foreach ( $pages as $page ) {
			$options[ $page->post_title ] = $page->ID;
		}
	}
	?>
    <select id="lc_wishlist_page" name="artemis_theme_shop_options[lc_wishlist_page]">
        <?php ARTEMIS_SWP_render_select_options( $options, $wishlist_page)?>
	</select>

    <p class="description">
		<?php echo esc_html__('Select page on which you want to display wishlist. Please make sure you selected "Wishlist" as page template', 'artemis-swp'); ?>
	</p>
	<?php
}

function Artemis_SWP_shop_sidebar() {
	$shop_sidebar = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar');

	if (empty($shop_sidebar)) {
		$shop_sidebar = "none";
	}

	$shop_sidebar_values = array(
		esc_html__('No Sidebar', 'artemis-swp')		=> 'none',
		esc_html__('Left Sidebar', 'artemis-swp')	=> 'left',
		esc_html__('Right Sidebar', 'artemis-swp')	=> 'right'
	);

	?>
	<select id="lc_shop_sidebar" name="artemis_theme_shop_options[lc_shop_sidebar]">
		<?php ARTEMIS_SWP_render_select_options($shop_sidebar_values, $shop_sidebar); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose to add sidebar to shop pages. This setting applies to shop page, product cagegory page and product tag page.', 'artemis-swp'); ?>
	</p>	
<?php		
}


function Artemis_SWP_shop_categories() {
    $use_shop_categories = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_shop_categories' );

    if ( empty( $use_shop_categories ) ) {
        $use_shop_categories = "no";
    }

    $shop_categories = array(
        esc_html__( 'No', 'artemis-swp' )  => 'no',
        esc_html__( 'Yes', 'artemis-swp' ) => 'yes'
    );

    ?>
    <select id="lc_shop_categories" name="artemis_theme_shop_options[lc_shop_categories]">
		<?php ARTEMIS_SWP_render_select_options( $shop_categories, $use_shop_categories ); ?>
	</select>

    <p class="description">
		<?php echo esc_html__( 'Choose to add a list with categories links to shop page.', 'artemis-swp' ); ?>
	</p>
<?php
}

function Artemis_SWP_shop_width() {
	$shop_width = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_width');

	if (empty($shop_width)) {
		$shop_width = "lc_swp_full";
	}

	$shop_width_values = array(
		esc_html__('Full Width', 'artemis-swp')		=> 'lc_swp_full',
		esc_html__('Boxed Width', 'artemis-swp')	=> 'lc_swp_boxed'
	);

	?>
	<select id="lc_shop_width" name="artemis_theme_shop_options[lc_shop_width]">
		<?php ARTEMIS_SWP_render_select_options($shop_width_values, $shop_width); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the width for your shop page.', 'artemis-swp'); ?>
	</p>	
<?php	
}

function Artemis_SWP_shop_single_sidebar() {
	$shop_sidebar_single = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_shop_sidebar_single');

	if (empty($shop_sidebar_single)) {
		$shop_sidebar_single = "none";
	}

	$shop_sidebar_single_values = array(
		esc_html__('No Sidebar', 'artemis-swp')		=> 'none',
		esc_html__('Left Sidebar', 'artemis-swp')	=> 'left',
		esc_html__('Right Sidebar', 'artemis-swp')	=> 'right'
	);

	?>
	<select id="lc_shop_sidebar_single" name="artemis_theme_shop_options[lc_shop_sidebar_single]">
		<?php ARTEMIS_SWP_render_select_options($shop_sidebar_single_values, $shop_sidebar_single); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose to add sidebar to single product pages.', 'artemis-swp'); ?>
	</p>
<?php
}

function Artemis_SWP_product_page_template() {
	$template_type = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_page_template');

	if (empty($template_type)) {
		$template_type = "default";
	}

	$template_types = array(
        esc_html__( 'Default - Gallery Slider', 'artemis-swp' )     => 'default',
        esc_html__( 'Default - Gallery Thumbnails', 'artemis-swp' ) => 'type_3',
        esc_html__( 'Two Columns', 'artemis-swp' )                  => 'type_1',
        esc_html__( 'Full Width Gallery', 'artemis-swp' )           => 'type_2',
	);

	?>
	<select id="lc_product_page_template" name="artemis_theme_shop_options[lc_product_page_template]">
		<?php ARTEMIS_SWP_render_select_options($template_types, $template_type); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose product page template.', 'artemis-swp'); ?>
	</p>
<?php
}

function Artemis_SWP_product_page_template_cover_img() {
	$make_cover = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_page_template_cover_img');

	if (empty($make_cover)) {
		$make_cover = "enabled";
	}

	$cover_types = array(
        esc_html__('Enabled', 'artemis-swp')  => 'enabled',
        esc_html__('Disabled', 'artemis-swp') => 'disabled'
	);
?>
	<select id="lc_product_page_template_cover_img" name="artemis_theme_shop_options[lc_product_page_template_cover_img]">
		<?php ARTEMIS_SWP_render_select_options($cover_types, $make_cover); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Show the lanscape product images as cover on the product page. Option available only for [Two Columns] product layout style.', 'artemis-swp'); ?>
	</p>
<?php	
}

function Artemis_SWP_lc_products_per_row() {
	$products_per_row = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_products_per_row' );

	if ( !intval( $products_per_row ) ) {
		$products_per_row = 4;
	}

	$columns = array(
		esc_html__( '3 Columns', 'artemis-swp' ) => '3',
		esc_html__( '4 Columns', 'artemis-swp' )  => '4',
		esc_html__( '5 Columns', 'artemis-swp' )  => '5'
	);

	?>
    <select id="lc_products_per_row" name="artemis_theme_shop_options[lc_products_per_row]">
		<?php ARTEMIS_SWP_render_select_options( $columns, $products_per_row ); ?>
	</select>

    <p class="description">
		<?php echo esc_html__( 'Select number of products per row in products lists (grid mode)', 'artemis-swp' ); ?>
	</p>
    <?php
}

function Artemis_SWP_lc_product_hover_effect() {
	$hover_effect = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_product_hover_effect');

	if (empty($hover_effect)) {
		$hover_effect = "default"; /*full width*/
	}

	$effects = array(
		esc_html__( 'Default - Full Width Overlay', 'artemis-swp' ) => 'default',
		esc_html__( 'Horizontal Bar', 'artemis-swp' )  => 'horizontal_bar',			
	);

	?>
    <select id="lc_product_hover_effect" name="artemis_theme_shop_options[lc_product_hover_effect]">
		<?php ARTEMIS_SWP_render_select_options( $effects, $hover_effect ); ?>
	</select>

    <p class="description">
		<?php echo esc_html__( 'Select how the product actions buttons (add to cart, wishlist, quick view) look like. ', 'artemis-swp' ); ?>
	</p>
    <?php	
}

function Artemis_SWP_lc_remove_account_wish() {
	$remove_items = ARTEMIS_SWP_get_theme_option('artemis_theme_shop_options', 'lc_remove_account_wish');

	if (empty($remove_items)) {
		$remove_items = "keep"; /*full width*/
	}

	$options = array(
		esc_html__( 'Keep Items To Menu - Default', 'artemis-swp' ) => 'keep',
		esc_html__( 'Remove Items From Menu', 'artemis-swp' )  => 'remove',
	);

	?>
    <select id="lc_remove_account_wish" name="artemis_theme_shop_options[lc_remove_account_wish]">
		<?php ARTEMIS_SWP_render_select_options($options, $remove_items); ?>
	</select>

    <p class="description">
		<?php echo esc_html__( 'Remove My Account and Wishlist from menu bar. ', 'artemis-swp'); ?>
	</p>
    <?php

}

function Artemis_SWP_lc_products_view_mode() {
	$products_view_mode = ARTEMIS_SWP_get_theme_option( 'artemis_theme_shop_options', 'lc_products_view_mode' );

	if ( empty( $products_view_mode ) ) {
		$products_view_mode = 'grid';
	}

	$view_modes = array(
		esc_html__( 'Grid', 'artemis-swp' ) => 'grid',
		esc_html__( 'List', 'artemis-swp' )  => 'list',
	);

	?>
    <select id="lc_products_view_mode" name="artemis_theme_shop_options[lc_products_view_mode]">
		<?php ARTEMIS_SWP_render_select_options( $view_modes, $products_view_mode ); ?>
	</select>

    <p class="description">
		<?php echo esc_html__( 'Select product list view mode', 'artemis-swp' ); ?>
	</p>
<?php
}

function Artemis_SWP_lc_login_popup_enable() {
	$enable_login_popup = ARTEMIS_SWP_get_theme_option( 'artemis_theme_general_options', 'lc_login_popup_enable' );
	if ( empty( $enable_login_popup ) ) {
		$enable_login_popup = 'yes';
	}
	$options = array(
		esc_html__( 'Enabled', 'artemis-swp' ) => 'yes',
		esc_html__( 'Disabled', 'artemis-swp' )  => 'no',
	);
	?>
    <select id="lc_login_popup_enable" name="artemis_theme_general_options[lc_login_popup_enable]">
		<?php ARTEMIS_SWP_render_select_options( $options, $enable_login_popup ); ?>
	</select>
    <p class="description">
		<?php echo esc_html__( 'Enable or disable login popup on frontend', 'artemis-swp' ); ?>
	</p>
    <?php
}
function Artemis_SWP_lc_login_popup_bg_image() {
	$bg_image_lp = ARTEMIS_SWP_get_theme_option( 'artemis_theme_general_options', 'lc_login_popup_bg_image' );
	?>
    <input id="lc_login_popup_bg_image_value" type="hidden" name="artemis_theme_general_options[lc_login_popup_bg_image]"
           value="<?php echo esc_url( $bg_image_lp ); ?>"/>
    <input id="lc_swp_upload_login_popup_bg_image_button" type="button" class="button"
           value="<?php echo esc_html__( 'Select/Upload Image', 'artemis-swp' ); ?>"/>
    <input id="lc_swp_remove_login_popup_bg_image_button" type="button" class="button"
           value="<?php echo esc_html__( 'Remove Image', 'artemis-swp' ); ?>"/>
    <p class="description">
		<?php echo esc_html__( 'Select/Upload a custom image for your login popup.', 'artemis-swp' ); ?>
	</p>
    <div id="lc_login_popup_bg_image_preview">
		<img class="lc_swp_setting_preview_login_popup_image" src="<?php echo esc_url( $bg_image_lp ); ?>">
	</div>
	<?php
}

function Artemis_SWP_lc_ajax_search_for() {
	$search_for = ARTEMIS_SWP_get_theme_option( 'artemis_theme_general_options', 'lc_ajax_search_for' );
	if ( empty( $search_for ) ) {
		$search_for = 'products';
	}
	$options = array(
		esc_html__( 'Products', 'artemis-swp' ) => 'product',
		esc_html__( 'Posts', 'artemis-swp' )  => 'post',
		esc_html__( 'Products and Posts', 'artemis-swp' )  => 'all'
	);
	?>
    <select id="lc_ajax_search_for" name="artemis_theme_general_options[lc_ajax_search_for]">
		<?php ARTEMIS_SWP_render_select_options( $options, $search_for); ?>
	</select>
    <p class="description">
		<?php echo esc_html__( 'Choose what the ajax search screen should show.', 'artemis-swp' ); ?>
	</p>
    <?php
}
//
/*
	Social Options
*/
function ARTEMIS_SWP_fb_url_cbk() {
	$fb_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_fb_url');

?>
	<input id="lc_fb_url" type="text" name="artemis_theme_social_options[lc_fb_url]" size="150" value="<?php echo esc_url($fb_url); ?>"/>
<?php
}

function ARTEMIS_SWP_twitter_url_cbk() {
	$twitter_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_twitter_url');

?>
	<input id="lc_twitter_url" type="text" name="artemis_theme_social_options[lc_twitter_url]" size="150" value="<?php echo esc_url($twitter_url); ?>"/>
<?php
}

function ARTEMIS_SWP_gplus_url_cbk() {
	$gplus_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_gplus_url');

?>
	<input id="lc_gplus_url" type="text" name="artemis_theme_social_options[lc_gplus_url]" size="150" value="<?php echo esc_url($gplus_url); ?>"/>
<?php
}

function ARTEMIS_SWP_youtube_url_cbk() {
	$youtube_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_youtube_url');

?>
	<input id="lc_youtube_url" type="text" name="artemis_theme_social_options[lc_youtube_url]" size="150" value="<?php echo esc_url($youtube_url); ?>"/>
<?php
}

function ARTEMIS_SWP_soundcloud_url_cbk() {
	$soundcloud_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_soundcloud_url');

?>
	<input id="lc_soundcloud_url" type="text" name="artemis_theme_social_options[lc_soundcloud_url]" size="150" value="<?php echo esc_url($soundcloud_url); ?>"/>
<?php
}

function ARTEMIS_SWP_myspace_url_cbk() {
	$myspace_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_myspace_url');

?>
	<input id="lc_myspace_url" type="text" name="artemis_theme_social_options[lc_myspace_url]" size="150" value="<?php echo esc_url($myspace_url); ?>"/>
<?php
}

function ARTEMIS_SWP_itunes_url_cbk() {
	$itunes_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_itunes_url');

?>
	<input id="lc_itunes_url" type="text" name="artemis_theme_social_options[lc_itunes_url]" size="150" value="<?php echo esc_url($itunes_url); ?>"/>
<?php
}

function ARTEMIS_SWP_pinterest_url_cbk() {
	$pinterest_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_pinterest_url');

?>
	<input id="lc_pinterest_url" type="text" name="artemis_theme_social_options[lc_pinterest_url]" size="150" value="<?php echo esc_url($pinterest_url); ?>"/>
<?php
}

function ARTEMIS_SWP_instagram_url_cbk() {
	$instagram_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_instagram_url');

?>
	<input id="lc_instagram_url" type="text" name="artemis_theme_social_options[lc_instagram_url]" size="150" value="<?php echo esc_url($instagram_url); ?>"/>
<?php
}

function ARTEMIS_SWP_houzz_url_cbk() {
	$houzz_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_houzz_url');

?>
	<input id="lc_houzz_url" type="text" name="artemis_theme_social_options[lc_houzz_url]" size="150" value="<?php echo esc_url($houzz_url); ?>"/>
<?php
}

function ARTEMIS_SWP_weibo_url_cbk() {
	$weibo_url = ARTEMIS_SWP_get_theme_option('artemis_theme_social_options', 'lc_weibo_url');

?>
	<input id="lc_weibo_url" type="text" name="artemis_theme_social_options[lc_weibo_url]" size="150" value="<?php echo esc_url($weibo_url); ?>"/>
<?php	
}

/*
	Footer Options
*/

function ARTEMIS_SWP_footer_widget_cs_cbk() {
	$footer_color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_color_scheme');
	if (empty($footer_color_scheme)) {
		$footer_color_scheme = 'black_on_white';
	}

	$footer_color_schemes = array(
		esc_html__('Black on White', 'artemis-swp')	=> 'black_on_white',
		esc_html__('White On Black', 'artemis-swp')	=> 'white_on_black'
	);
?>

	<select id="lc_footer_widgets_color_scheme" name="artemis_theme_footer_options[lc_footer_widgets_color_scheme]">
		<?php ARTEMIS_SWP_render_select_options($footer_color_schemes, $footer_color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Color scheme used for footer widgets text.', 'artemis-swp'); ?>
	</p>
<?php
}

function ARTEMIS_SWP_footer_widget_bgimg_cbk() {
	$footer_bg_image = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_background_image');

?>
	<input id="lc_swp_footer_bg_image_upload_value" type="text" name="artemis_theme_footer_options[lc_footer_widgets_background_image]" size="150" value="<?php echo esc_url($footer_bg_image); ?>"/>
	<input id="lc_swp_upload_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'artemis-swp'); ?>" />
	<input id="lc_swp_remove_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'artemis-swp'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for the footer widgets area.', 'artemis-swp'); ?>
	</p>

	<div id="lc_footer_widgets_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($footer_bg_image); ?>">
	</div>
<?php
}

function ARTEMIS_SWP_footer_widget_bgcolor_cbk() {
	$footer_background_color = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_footer_widgets_background_color');
	$default_bg_color = 'rgba(255, 255, 255, 0)';

	if ('' == $footer_background_color) {
		$footer_background_color = $default_bg_color;
	}
?>

	<input type="text" id="lc_footer_widgets_background_color" class="alpha-color-picker-settings" name="artemis_theme_footer_options[lc_footer_widgets_background_color]" value="<?php echo esc_attr($footer_background_color); ?>" data-default-color="rgba(255, 255, 255, 0)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Color overlay for the footer widgets area. Can be used as background color or as color over the background image.', 'artemis-swp'); ?>
	</p>
<?php	
}

function ARTEMIS_SWP_copyright_text_cbk() {
	$copyright_text = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text');
?>
	<textarea  cols="147" rows="10" id="lc_copyright_text" name="artemis_theme_footer_options[lc_copyright_text]" ><?php echo esc_html($copyright_text); ?></textarea>;
<?php
}

function ARTEMIS_SWP_copyright_url_cbk() {
	$copyright_url = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_url');
?>
	<input type="text" size="147" id="lc_copyright_url" name="artemis_theme_footer_options[lc_copyright_url]" value="<?php echo esc_url_raw($copyright_url)?>"/>
<?php
}
/*
function ARTEMIS_SWP_analytics_code_cbk() {
	$analytics_code = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_analytics_code');

?>
	<textarea  cols="147" rows="10" id="analytics_code" name="artemis_theme_footer_options[lc_analytics_code]" ><?php echo esc_html($analytics_code); ?></textarea>
<?php
}
*/

function ARTEMIS_SWP_copyright_cs_cbk() {
	$copy_color_scheme = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text_color');
	if (empty($copy_color_scheme)) {
		$copy_color_scheme = 'black_on_white';
	}

	$copy_color_schemes = array(
		esc_html__('Black on White', 'artemis-swp')	=> 'black_on_white',		
		esc_html__('White On Black', 'artemis-swp')	=> 'white_on_black'
	);
?>

	<select id="lc_copyright_text_color" name="artemis_theme_footer_options[lc_copyright_text_color]">
		<?php ARTEMIS_SWP_render_select_options($copy_color_schemes, $copy_color_scheme); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Color scheme used for footer copyrigth text.', 'artemis-swp'); ?>
	</p>
<?php
}

function ARTEMIS_SWP_copyright_bgc_cbk() {
	$copy_bgc = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_text_bg_color');
	$default_copy_bgc = 'rgba(255, 255, 255, 0)';

	if ('' == $copy_bgc) {
		$copy_bgc = $default_copy_bgc;
	}
?>

	<input type="text" id="lc_copyright_text_bg_color" class="alpha-color-picker-settings" name="artemis_theme_footer_options[lc_copyright_text_bg_color]" value="<?php echo esc_html($copy_bgc); ?>" data-default-color="rgba(255, 255, 255, 0)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Background color for the copyright text area.', 'artemis-swp'); ?>
	</p>
<?php
}

function ARTEMIS_SWP_copyright_put_social_cbk() {
	$put_social_footer = ARTEMIS_SWP_get_theme_option('artemis_theme_footer_options', 'lc_copyright_put_social');
	if (empty($put_social_footer)) {
		$put_social_footer = 'enabled';
	}

	$put_social_footer_vals = array(
		esc_html__('Enabled', 'artemis-swp')	=> 'enabled',		
		esc_html__('Disabled', 'artemis-swp')	=> 'disabled'
	);
?>

	<select id="lc_copyright_put_social" name="artemis_theme_footer_options[lc_copyright_put_social]">
		<?php ARTEMIS_SWP_render_select_options($put_social_footer_vals, $put_social_footer); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Place social profiles icons on copyright area.', 'artemis-swp'); ?>
		<?php echo esc_html__('Please make sure that copyright text is filled in the above field.', 'artemis-swp'); ?>
	</p>
<?php
}

/*
	Contact Options
*/
function ARTEMIS_SWP_lc_contact_address_cbk() {
	$contact_address = ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_address');
?>
	<input type="text" size="200" id="lc_contact_address" name="artemis_theme_contact_options[lc_contact_address]" value="<?php echo esc_attr($contact_address); ?>" />
<?php
}

function ARTEMIS_SWP_lc_contact_phone_cbk() {
	$contact_phone = ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_phone');
?>
	<input type="text" size="50" id="lc_contact_phone" name="artemis_theme_contact_options[lc_contact_phone]" value="<?php echo esc_attr($contact_phone); ?>" />
<?php	
}

function ARTEMIS_SWP_lc_contact_fax_cbk() {
	$contact_fax = ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_fax');
?>
	<input type="text" size="50" id="lc_contact_fax" name="artemis_theme_contact_options[lc_contact_fax]" value="<?php echo esc_attr($contact_fax); ?>" />
<?php
}

function ARTEMIS_SWP_lc_contact_email_cbk() {
	$contact_email = sanitize_email(ARTEMIS_SWP_get_theme_option('artemis_theme_contact_options', 'lc_contact_email'));
?>
	<input type="text" size="50" id="lc_contact_email" name="artemis_theme_contact_options[lc_contact_email]" value="<?php echo esc_attr($contact_email); ?>" />
	<p class="description">
		<?php
		echo esc_html__("This is the email address shown on contact page.", "artemis-swp");
		?> <br> <?php
		echo esc_html__("To set the recipient email for the contact form, please go to Settings - Artemis Core Settings.", "artemis-swp");
		?>
	</p>
<?php
}

/*
	Font Options
*/
function ARTEMIS_SWP_at_fonts_custom_default_cbk() {
	$fonts_custom_default = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_fonts_custom_default');
	if (empty($fonts_custom_default)) {
		$fonts_custom_default = 'use_defaults';
	}

	$fonts_usage = array(
		esc_html__('Use Theme Defaults', 'artemis-swp')	=> 'use_defaults',
		esc_html__('Use Custom Fonts', 'artemis-swp')	=> 'use_custom'
	);
?>

	<select id="at_fonts_custom_default" name="artemis_theme_font_options[at_fonts_custom_default]">
		<?php ARTEMIS_SWP_render_select_options($fonts_usage, $fonts_custom_default); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose to use custom fonts for Lucille.', 'artemis-swp'); ?>
	</p>

<?php
}

function ARTEMIS_SWP_at_primary_font_cbk() {
	$primary_font = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_primary_font');
	if (empty($primary_font)) {
		$primary_font = 'Open Sans';
	}

	$font_families = ARTEMIS_SWP_get_google_fonts_array();

?>
	<select id="at_primary_font" name="artemis_theme_font_options[at_primary_font]">
		<?php ARTEMIS_SWP_render_select_options($font_families, $primary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the primary font.', 'artemis-swp'); ?>
	</p>	
<?php
}

function ARTEMIS_SWP_at_secondary_font_cbk() {
	$secondary_font = ARTEMIS_SWP_get_theme_option('artemis_theme_font_options', 'at_secondary_font');
	if (empty($secondary_font)) {
		$secondary_font = 'Oswald';
	}

	$font_families = ARTEMIS_SWP_get_google_fonts_array();

?>
	<select id="at_secondary_font" name="artemis_theme_font_options[at_secondary_font]">
		<?php ARTEMIS_SWP_render_select_options($font_families, $secondary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the secondary font (optional). ', 'artemis-swp'); ?>
		<br>
		<?php
		echo esc_html__('By default, the theme is using a single font family. ', 'artemis-swp'); 
		echo esc_html__('If you choose to use a secondary font, please add your custom CSS to theme customizer - Appearance - Customize - Additional CSS. The custom CSS should contain the html elements using the secondary font.', 'artemis-swp'); 
		?>
	</p>	
<?php	
}

/*
	UTILS FOR THEME SETTINGS
*/
function ARTEMIS_SWP_get_theme_option($option_group, $option_name) 
{
	$options = get_option($option_group);

	if (isset($options[$option_name])) {
		return $options[$option_name];
	}

	return '';
}

function ARTEMIS_SWP_render_select_options($options, $selected) {
	if (empty($selected)) {
		return;
	}

	foreach($options as $key => $value) { ?>
        <option <?php selected( $selected, esc_attr( $value ) ) ?> value="<?php echo esc_attr( $value ); ?>">
            <?php echo esc_attr( $key ); ?>
        </option>
	<?php }
}

/*
	Get all google fonts and creates an array like: 
	 array(
		'Open Sans',	=> 'Open Sans'
	);
*/
function ARTEMIS_SWP_get_google_fonts_array() {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$array_fonts = array();
	foreach($fonts_json as $font_json) {
		$array_fonts[$font_json['family']] = $font_json['family'];
	}

	return $array_fonts;
}