<?php

/*
	Theme Customiser Functionality
	Contains methods for customizing the theme customization screen.
*/

class ARTEMIS_SWP_Customize {
	//This hooks into 'customize_register' (available as of WP 3.4)
	public static function register($wp_customize) 
	{
		require_once(get_template_directory()."/customizer/alpha-color-picker-customizer.php");

		if (!isset($lc_customize['menu_mobile_bg_color'])) {
			$lc_customize['menu_mobile_bg_color'] = 'rgba(35, 35, 35, 1)';
		}
		if (!isset($lc_customize['mobile_border_bottom_color'])) {
			$lc_customize['mobile_border_bottom_color'] = '#333333';
		}


		//Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'lc_second_color', 
			array(
				'title' => esc_html__('Vibrant Color', 'artemis-swp'), 				//Visible title of section
				'priority' => 1, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Choose the link color', 'artemis-swp'), //Descriptive tooltip
			)
		);

		//Register new settings to the WP database...
		$wp_customize->add_setting( 'lc_customize[lc_second_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#18aebf', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_second_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Secondary Color', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_second_color', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_second_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));

		/*
			MENU OPTIONS
		*/
		$wp_customize->add_section('lc_menu_options', 
			array(
				'title' => esc_html__('Menu Colors', 'artemis-swp'), 				//Visible title of section
				'priority' => 2, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Choose menu colors', 'artemis-swp'), //Descriptive tooltip
			)
		);

		/*menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_bar_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 0)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_bar_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Bar Background Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_bar_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*sticky menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_sticky_bar_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 1)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_sticky_bar_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Sticky Menu Bar Background Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_sticky_bar_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*mobile menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_mobile_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 1)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_mobile_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Mobile Menu Background Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_mobile_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*mobile menu hmb menu color */
		$wp_customize->add_setting('lc_customize[menu_mobile_hmb_color]',
			array(
				'default' => '#000000', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_mobile_hmb_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Mobile Menu Hamburger Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_mobile_hmb_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));		

		/*mobile menu border bottom color*/
		$wp_customize->add_setting('lc_customize[mobile_border_bottom_color]',
			array(
				'default' => '#e1e1e1', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'mobile_border_bottom_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Mobile Menu Border Bottom Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[mobile_border_bottom_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*above the menu bar*/
		$wp_customize->add_setting('lc_customize[above_the_menu_bar]',
			array(
				'default' => 'rgba(241, 246, 247, 0.9)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'above_the_menu_bar', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Above The Menu Bar Background Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[above_the_menu_bar]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		$wp_customize->add_setting('lc_customize[above_the_menu_msg_color]',
			array(
				'default' => '#959595', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'above_the_menu_msg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Above The Menu Message Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[above_the_menu_msg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));			

		/*menu text color*/
		$wp_customize->add_setting('lc_customize[menu_text_color]',
			array(
				'default' => '#000000', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_menu_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Text Color', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_text_color]',
				'priority' => 2,
			) 
		));

		/*menu text hover color*/
		$wp_customize->add_setting('lc_customize[menu_text_hover_color]',
			array(
				'default' => '#ffffff', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_menu_text_hover_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Text Color on Hover', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_text_hover_color]',
				'priority' => 3,
			) 
		));

		/*sub menu text color*/
		$wp_customize->add_setting('lc_customize[submenu_text_color]',
			array(
				'default' => '#464646', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_submenu_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Text Color', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_text_color]',
				'priority' => 4,
			)
		));

		/*submenu text hover color*/
		$wp_customize->add_setting('lc_customize[submenu_text_hover_color]',
			array(
				'default' => '#000000',													//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_submenu_text_hover_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Text Color on Hover', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_text_hover_color]',
				'priority' => 5,
			)
		));

		/*current menu item text color*/
		$wp_customize->add_setting('lc_customize[current_menu_item_text_color]',
			array(
				'default' => '#18aebf',													//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_current_menu_item_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Current Menu Item Text Color', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[current_menu_item_text_color]',
				'priority' => 5,
			)
		));

		/*sub menu bg color*/
		$wp_customize->add_setting('lc_customize[submenu_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 0)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'submenu_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Background Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 6															//Determines the order this control appears in for the specified section
				)
		));

		/*menu bar color*/
		$wp_customize->add_setting('lc_customize[creative_menu_overlay_bg]',
			array(
				'default' => 'rgba(255, 255, 255, 0.9)', 												//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'creative_menu_overlay_bg', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Creative Menu Overlay Color', 'artemis-swp'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[creative_menu_overlay_bg]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 7															//Determines the order this control appears in for the specified section
				)
		));

		/*top icons on creative menu*/
		$wp_customize->add_setting('lc_customize[creative_icons_color]',
			array(
				'default' => '#000000', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_creative_icons_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Top Icons Color For Creative Menu. Also, the color for mobile menu icons, menu icon and search icon.', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[creative_icons_color]',
				'priority' => 8
			)
		));

		/*login signup wish list color*/
		$wp_customize->add_setting('lc_customize[login_wishlist_color]',
			array(
				'default' => '#959595', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'at_login_wishlist_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Text color for login, sign-up and wish list links on the menu bar.', 'artemis-swp'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[login_wishlist_color]',
				'priority' => 8
			)
		));

		/*buttons*/
		$wp_customize->add_section( 'lc_button_colors', 
			array(
				'title' => esc_html__('Button Colors', 'artemis-swp'), 				//Visible title of section
				'priority' => 3, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Set button colors.', 'artemis-swp'), //Descriptive tooltip
			)
		);

		$wp_customize->add_setting( 'lc_customize[lc_use_custom_btn_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => 'use_defaults', 										//Default setting/value to save
				'sanitize_callback'	=> 'ARTEMIS_SWP_sanitize_buttons_custom',
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		$wp_customize->add_control('lc_use_custom_btn_color_control' ,
			array(
				'label' 	=> esc_html__('Buttons Colors', 'artemis-swp'), 
				'section' 	=> 'lc_button_colors',
				'settings' 	=> 'lc_customize[lc_use_custom_btn_color]',
				'priority' 	=> 1,
				'type'		=> 'select',
				'choices'    => array(
									'use_defaults' 		=> esc_html__('Use Theme Defaults', 'artemis-swp'),
									'custom_btn_colors' => esc_html__('Use Custom Colors', 'artemis-swp' ),
								),
			)
		);

		/*btn bg color*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_bg_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#000000', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_bg_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Background Color', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_bg_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 2, //Determines the order this control appears in for the specified section
										)
		));

		/*btn text color*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_txt_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#ffffff', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_txt_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Text Color', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_txt_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										)
		));	

		/*btn border color*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_border_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#000000', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_border_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Border Color', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_border_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										)
		));			

		/*btn bg color on hover*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_bg_color_hover]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#555555', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_bg_color_hover', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Background Color On Hover', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_bg_color_hover]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 2, //Determines the order this control appears in for the specified section
										)
		));

		/*btn text color on hover*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_txt_color_hover]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#ffffff', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_txt_color_hover', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Text Color On Hover', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_txt_color_hover]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										)
		));	

		/*btn border color on hover*/
		$wp_customize->add_setting( 'lc_customize[lc_btn_border_color_hover]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#555555', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_btn_border_color_hover', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Button Border Color On Hover', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_button_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_btn_border_color_hover]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										)
		));			


		/*Various*/
		$wp_customize->add_section( 'lc_various_colors', 
			array(
				'title' => esc_html__('Various Colors', 'artemis-swp'), 				//Visible title of section
				'priority' => 3, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Set general colors.', 'artemis-swp'), //Descriptive tooltip
			)
		);

		/*bg color for single post with no featured img in blog template*/
		$wp_customize->add_setting( 'lc_customize[lc_blog_brick_bg_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#1d1d1d', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_blog_brick_bg_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Background Color For Blog Items With No Featured Image', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_various_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_blog_brick_bg_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										)
		));

		/*bg color for minicart and wishlist popups*/
		$wp_customize->add_setting( 'lc_customize[lc_minicart_wishlist_popup_bg_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#ffffff', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//define the control
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_minicart_wishlist_popup_bg_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Background Color For Minciart And Wishlist Popups', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_various_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_minicart_wishlist_popup_bg_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 2, //Determines the order this control appears in for the specified section
										)
		));

		/*bg color for order summary - cart and checkout pages*/
		$wp_customize->add_setting( 'lc_customize[lc_order_summary_bg_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#f4f8fb', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//define the control
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_order_summary_bg_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Background Color For Order Summary Container', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_various_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_order_summary_bg_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										)
		));

		/*bg color for overlay on shop page*/
		$wp_customize->add_setting( 'lc_customize[lc_shop_overlay_bg_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => 'rgba(255,255,255, 0.7)', 										//Default setting/value to save
				'sanitize_callback' => 'ARTEMIS_SWP_sanitize_rgba_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//define the control
		$wp_customize->add_control( new Customize_Alpha_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_shop_overlay_bg_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Background Color Product Actions Overlay On Shop Page', 'artemis-swp'), //Admin-visible name of the control
										'section' => 'lc_various_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_shop_overlay_bg_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 4, //Determines the order this control appears in for the specified section
										)
		));			

	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* keep 'transport'=>'postMessage' instead of the default 'transport' => 'refresh'
	* Used by hook: 'customize_preview_init'
	*/
	public static function live_preview() 
	{
		wp_enqueue_script( 
	       'artemis-swp-themecustomizer', 										// Give the script a unique ID
	       get_template_directory_uri().'/customizer/js/theme_customizer.js', 	// Define the path to the JS file
	       array('jquery', 'customize-preview'),				 				// Define dependencies
	       rand(5, 100), 																	// Define a version (optional) 
	       true 																// Specify whether to put in footer (leave this true)
		);

		wp_localize_script('artemis-swp-themecustomizer', 'artemisSwpCustomizerConfig', get_option( 'lc_customize', array() ));


	}

    public static function register_controls() {
        wp_enqueue_script( 'at_swp_customizer_controls',
                           get_template_directory_uri() . '/customizer/js/customizer_controls.js',
                           array( 'jquery' ),
                           '1.0.0',
                           true );
        wp_localize_script( 'at_swp_customizer_controls', 'atCustomizerControlsConfig', get_option( 'lc_customize', array() ) );
    }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * Used by hook: 'wp_head'
    * add_action('wp_head',$func)
    */
	public static function header_output()
	{
		$lc_customize = get_option('lc_customize');

		if (!isset($lc_customize['lc_second_color'])) {
			$lc_customize['lc_second_color'] = '#18aebf';
		}
		if (!isset($lc_customize['menu_bar_bg_color'])) {
			$lc_customize['menu_bar_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['menu_sticky_bar_bg_color'])) {
			$lc_customize['menu_sticky_bar_bg_color'] = 'rgba(255, 255, 255, 1)';
		}
		if (!isset($lc_customize['above_the_menu_bar'])) {
			$lc_customize['above_the_menu_bar'] = 'rgba(241, 246, 247, 0.9)';
		}
		if (!isset($lc_customize['menu_text_color'])) {
			$lc_customize['menu_text_color'] = '#000000';
		}
		if (!isset($lc_customize['menu_text_hover_color'])) {
			$lc_customize['menu_text_hover_color'] = '#18aebf';
		}

		if (!isset($lc_customize['submenu_text_color'])) {
			$lc_customize['submenu_text_color'] = '#464646';
		}
		if (!isset($lc_customize['submenu_text_hover_color'])) {
			$lc_customize['submenu_text_hover_color'] = '#000000';
		}
		if (!isset($lc_customize['submenu_bg_color'])) {
			$lc_customize['submenu_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['creative_menu_overlay_bg'])) {
			$lc_customize['creative_menu_overlay_bg'] = 'rgba(255, 255, 255, 0.9)';
		}
		if (!isset($lc_customize['creative_icons_color'])) {
			$lc_customize['creative_icons_color'] = '#000000';
		}
		if (!isset($lc_customize['menu_mobile_bg_color'])) {
			$lc_customize['menu_mobile_bg_color'] = "rgba(255, 255, 255, 1)";
		}
		if (!isset($lc_customize['menu_mobile_hmb_color'])) {
			$lc_customize['menu_mobile_hmb_color'] = "#000000";
		}		
		if (!isset($lc_customize['mobile_border_bottom_color'])) {
			$lc_customize['mobile_border_bottom_color'] = '#e1e1e1';
		}
		if (!isset($lc_customize['current_menu_item_text_color'])) {
			$lc_customize['current_menu_item_text_color'] = '#18aebf';	
		}
		if (!isset($lc_customize['login_wishlist_color'])) {
			$lc_customize['login_wishlist_color'] = '#959595';	
		}
		if (!isset($lc_customize['lc_blog_brick_bg_color'])) {
			$lc_customize['lc_blog_brick_bg_color'] = '#1d1d1d';	
		}
		if (!isset($lc_customize['lc_minicart_wishlist_popup_bg_color'])) {
			$lc_customize['lc_minicart_wishlist_popup_bg_color'] = '#ffffff';	
		}
		if (!isset($lc_customize['lc_order_summary_bg_color'])) {
			$lc_customize['lc_order_summary_bg_color'] = '#f4f8fb';	
		}
		if (!isset($lc_customize['above_the_menu_msg_color'])) {
			$lc_customize['above_the_menu_msg_color'] = '#959595';	
		}
		if (!isset($lc_customize['lc_use_custom_btn_color'])) {
			$lc_customize['lc_use_custom_btn_color'] = 'use_defaults';
		}
		/*buttons*/
		if (!isset($lc_customize['lc_btn_bg_color'])) {
			$lc_customize['lc_btn_bg_color'] = '#000000';
		}
		if (!isset($lc_customize['lc_btn_txt_color'])) {
			$lc_customize['lc_btn_txt_color'] = '#ffffff';
		}
		if (!isset($lc_customize['lc_btn_border_color'])) {
			$lc_customize['lc_btn_border_color'] = '#000000';
		}
		if (!isset($lc_customize['lc_btn_bg_color_hover'])) {
			$lc_customize['lc_btn_bg_color_hover'] = '#555555';
		}		
		if (!isset($lc_customize['lc_btn_txt_color_hover'])) {
			$lc_customize['lc_btn_txt_color_hover'] = '#ffffff';
		}
		if (!isset($lc_customize['lc_btn_border_color_hover'])) {
			$lc_customize['lc_btn_border_color_hover'] = '#ffffff';
		}
		if (!isset($lc_customize['lc_shop_overlay_bg_color'])) {
			$lc_customize['lc_shop_overlay_bg_color'] = 'rgba(255,255,255, 0.7)';
		}

		?>
		<!--Customizer CSS-->
		<style type="text/css">
			<?php
			/*vibrant color as text color*/
			?>
            .artemis_swp_search_post .at_swp-read-more:hover,
			a:hover, .vibrant_hover:hover, .vibrant_hover a:hover, .lc_vibrant_color, .vibrant_color, .black_on_white .lc_vibrant_color,  #recentcomments a:hover, .tagcloud a:hover,
			.widget_meta a:hover, .widget_pages a:hover, .widget_categories a:hover, .widget_recent_entries a:hover,
			.widget_archive a:hover, .lc_copy_area a:hover, .lc_swp_content a:hover, .lc_sharing_icons a:hover,
			.lc_post_meta a:hover, .post_item:hover > .post_item_details a h2, .lc_blog_masonry_brick.has_thumbnail .lc_post_meta a:hover,
			.post_item.no_thumbnail .lc_post_meta a:hover, .post_item:hover > a h2, .artemis_cf_error,
			.woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price,
			.woocommerce-message:before, .woocommerce a.remove, .woocommerce-info:before, .woocommerce form .form-row .required,
			.woocommerce form .form-row.woocommerce-invalid label, a.about_paypal, .single_video_item:hover h3, .goto_next_section,
			.post_item.no_thumbnail .masonry_read_more a:hover, .one_of_three.no_thumbnail h4 a:hover, .one_of_three.no_thumbnail .related_meta a:hover,
			.widget_layered_nav ul a:hover, .widget_layered_nav ul li.chosen a, .at_prod_slider_container a.unslider-arrow:hover,
			.centered_left.social_profiles_center_menu a:hover, .breadcrumbs_nav a.last_elt, .breadcrumbs_nav a.last_elt:hover,
			.at_swp_single_grid_prod .amount, .products_category_filter a.at_swp_cat_filter_active
			{ color: <?php echo esc_html($lc_customize['lc_second_color']); ?>; }


			<?php /*vibrant color as background*/ ?>
			.lc_swp_vibrant_bgc, .cart-contents-count, .lc_button:hover, .lc_button:hover > a, .woocommerce a.button:hover,  
			#commentform input#submit:hover,
			.single_track .mejs-controls .mejs-time-rail .mejs-time-current, 
			.lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce span.onsale, 
			.woocommerce ul.products li.product:hover > a.button, .woocommerce button.button.alt:hover, .woocommerce button.button.alt.disabled:hover,
			.woocommerce #respond input#submit:hover, .woocommerce input.button:hover, input.button:hover, .woocommerce a.button.alt:hover, 
			.woocommerce a.remove:hover, .woocommerce input.button.alt:hover, 
			.unslider-nav ol li.unslider-active, input[type="submit"]:hover, 
			.woocommerce .widget_layered_nav ul li.chosen a:before, .woocommerce .widget_layered_nav_filters ul li a:before, 
			.woocommerce .widget_price_filter .price_slider_amount .button:hover, a.at_link_line_before.lc_vibrant_color:before, .at_video_section_play,
			.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button.checkout:hover, 
			.artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button, .brick_cust_link a.at_link_line_before:hover:before, 
			.artemis-swp-miniwishlist .buttons .button
			{ background-color: <?php echo esc_html($lc_customize['lc_second_color']); ?>; }

			<?php /*vibrant color as border color*/ ?>
			.lc_button:hover, input[type="submit"]:hover, .woocommerce a.button:hover, .lc_blog_masonry_brick:hover > .post_item_details .lc_button, 
			.woocommerce ul.products li.product:hover > a.button, .woocommerce button.button.alt:hover, 
			.woocommerce #respond input#submit:hover, input.button:hover, .woocommerce input.button:hover,  
			.white_on_black .woocommerce a.button.alt:hover, .woocommerce-info, 
			.woocommerce form .form-row.woocommerce-invalid input.input-text, .unslider-nav ol li.unslider-active, 
			input.artemis_cf_input:focus, textarea.artemis_cf_input:focus, .woocommerce .widget_price_filter .price_slider_amount .button:hover,
			.artemis-swp-miniwishlist .buttons .button
			{ border-color: <?php echo esc_html($lc_customize['lc_second_color']); ?> !important; }

            .artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button
			{ border-color: <?php echo esc_html($lc_customize['lc_second_color']); ?> }

			<?php /*select2 stuff - arrow down*/ ?>
			.select2-container--default .select2-selection--single .select2-selection__arrow b
			{ border-color: <?php echo esc_html($lc_customize['lc_second_color']); ?> transparent transparent transparent; }

			<?php /*arrow up*/ ?>
			.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b
			{ border-color: transparent transparent <?php echo esc_html($lc_customize['lc_second_color']); ?> transparent; }

			<?php /*mose over option bg color*/ ?>
			.select2-container--default .select2-results__option--highlighted[aria-selected]
			{ background-color: <?php echo esc_html($lc_customize['lc_second_color']); ?>; }

			<?php /*menu bar background color*/ ?>
			.header_inner { background-color: <?php echo esc_html($lc_customize['menu_bar_bg_color']); ?>; }

			<?php /*sticky menu bar background color*/ ?>
			header.sticky_enabled .header_inner
			{ background-color: <?php echo esc_html($lc_customize['menu_sticky_bar_bg_color']); ?>; }

			<?php /*mobile_menu background color*/ ?>
			.header_inner.lc_mobile_menu, .mobile_navigation_container
			{ background-color: <?php echo esc_html($lc_customize['menu_mobile_bg_color']); ?>; }
			
			<?php /*mobile_menu hamburger color*/ ?>
			.hmb_line.mobile_menu_hmb_line
			{ background-color: <?php echo esc_html($lc_customize['menu_mobile_hmb_color']); ?>; }

			.lc_mobile_menu .mobile_menu_icon, .lc_mobile_menu .mobile_menu_icon a
			{ color: <?php echo esc_html($lc_customize['menu_mobile_hmb_color']); ?>; }

			<?php /*mobile menu subitem border bottom color*/ ?>
			.mobile_navigation ul li { border-bottom-color: <?php echo esc_html($lc_customize['mobile_border_bottom_color']); ?>; }
			
			<?php /*menu top text color*/  /*removed .cart-contents-count, from the list*/ ?>
			li.menu-item a, #logo a, .classic_header_icon, .classic_header_icon a,  .centered_left.social_profiles_center_menu a,
			.classic_header_icon:hover, .classic_header_icon a:hover,
			.menu > li.menu-item-swp-megamenu-parent > ul > li > a, .menu > li.menu-item-swp-megamenu-parent > ul > li > a:hover
			{ color: <?php echo esc_html($lc_customize['menu_text_color']); ?>; }

			<?php /*menu text color as background color for hmb menu icon*/ ?>
			.centered_left .hmb_line
			{ background-color: <?php echo esc_html($lc_customize['menu_text_color']); ?>; }

			<?php /*menu top text hover color*/ ?>
			li.menu-item a:hover { color: <?php echo esc_html($lc_customize['menu_text_hover_color']); ?>; }

			<?php /*sub menu text color*/ ?>
			ul.sub-menu li.menu-item a
			{ color: <?php echo esc_html($lc_customize['submenu_text_color']); ?>; }
			
			.creative_menu ul.sub-menu li.menu-item-has-children::before 
			{ border-left-color: <?php echo esc_html($lc_customize['submenu_text_color']); ?>; }

			<?php /*sub menu hover text color*/ ?>
			ul.sub-menu li.menu-item a:hover
			{ color: <?php echo esc_html($lc_customize['submenu_text_hover_color']); ?>; }
			
			.creative_menu ul.sub-menu li.menu-item-has-children:hover::before 
			{ border-left-color: <?php echo esc_html($lc_customize['submenu_text_hover_color']); ?>; }

			<?php /*current menu item text color*/ ?>
			li.current-menu-item a, li.current-menu-parent a, li.current-menu-ancestor a
			{ color: <?php echo esc_html($lc_customize['current_menu_item_text_color']); ?>; }

			<?php /*sub menu background color*/ ?>
			ul.sub-menu li, ul.sub-menu.mega_menu_ul
			{ background-color: <?php echo esc_html($lc_customize['submenu_bg_color']); ?>; }

			<?php /*creative menu overlay bagckground*/ ?>
			.nav_creative_container { background-color: <?php echo esc_html($lc_customize['creative_menu_overlay_bg']); ?>; }
			.login_creative_container { background-color: <?php echo esc_html($lc_customize['creative_menu_overlay_bg']); ?>; }

			<?php /*creative icons color*/ ?>
			.creative_header_icon, .creative_header_icon a, .creative_header_icon a.cart-contents:hover,
			.classic_double_menu_logo_center .classic_header_icon, .classic_double_menu_logo_center .classic_header_icon a
			{ color: <?php echo esc_html($lc_customize['creative_icons_color']); ?>; }

			<?php /*take care of hover*/ ?>
			.creative_header_icon.lc_social_icon:hover, .creative_header_icon.lc_social_icon a:hover
			{ color: <?php echo esc_html($lc_customize['lc_second_color']); ?>; }

			<?php /*login sign up wish list text color*/ ?>
			.account_option, .account_option a
			{ color: <?php echo esc_html($lc_customize['login_wishlist_color']); ?>; }

			.hmb_line { background-color: <?php echo esc_html($lc_customize['creative_icons_color']); ?>; }

			<?php /*various colors*/ ?>
			.post_item.lc_blog_masonry_brick.no_thumbnail, .gallery_brick_overlay, .at_related_posts .one_of_three.no_thumbnail,
			.lnwidtget_no_featured_img
			{ background-color: <?php echo esc_html($lc_customize['lc_blog_brick_bg_color']); ?>; }

			.at_wishlist .artemis-swp-miniwishlist, .artemis-swp-minicart-icon .artemis-swp-minicart
			{ background-color: <?php echo esc_html($lc_customize['lc_minicart_wishlist_popup_bg_color']); ?>; }

			<?php /*order summary bg color*/ ?>
			.artemis-swp-order-thank-you .artemis-swp-order-summary, .woocommerce-checkout-review-order, .cart_totals table,
			.woocommerce .col2-set#customer_login .col-2, .woocommerce-page .col2-set#customer_login .col-2, .woocommerce-checkout #order_review
			{ background-color: <?php echo esc_html($lc_customize['lc_order_summary_bg_color']); ?>; }

			<?php /*product actions overlay color*/ ?>
			.at_product_actions_mask { background-color: <?php echo esc_html($lc_customize['lc_shop_overlay_bg_color']); ?>; }

			<?php /*above the menu bar bg color*/ ?>
			.pre_header
			{ background-color: <?php echo esc_html($lc_customize['above_the_menu_bar']); ?>; }

			<?php /*above the menu message color*/ ?>
			.at_menu_message, nav.at_secondary_menu li a
			{ color: <?php echo esc_html($lc_customize['above_the_menu_msg_color']); ?>; }

			<?php /* for the footer menu only - vibrant color as text color*/ ?>
			.lc_footer_sidebar .menu a:hover 
			{ color: <?php echo esc_html($lc_customize['lc_second_color']); ?>; }


            <?php /** buttons */ ?>
            <?php if( 'use_defaults' != $lc_customize['lc_use_custom_btn_color'] ) { ?>
            .lc_button, input[type="submit"],
            .woocommerce a.button,
            .lc_blog_masonry_brick > .post_item_details .lc_button,
            .woocommerce ul.products li.product > a.button,
            .woocommerce button.button.alt,
            .woocommerce a.button.alt,
            .woocommerce #respond input#submit, input.button, .woocommerce input.button,
            .white_on_black .woocommerce a.button.alt,
            .unslider-nav ol li.unslider-active,
            .woocommerce .widget_price_filter .price_slider_amount .button,
            .artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button,
            .button, .wc-forward {
                background-color: <?php echo esc_html($lc_customize['lc_btn_bg_color']) ?>;
                border-color: <?php echo esc_html($lc_customize['lc_btn_border_color']) ?> ;
                color: <?php echo esc_html($lc_customize['lc_btn_txt_color']) ?>;
            }
            .lc_button:hover, input[type="submit"]:hover,
            .woocommerce a.button:hover,
            .lc_blog_masonry_brick > .post_item_details .lc_button:hover,
            .woocommerce ul.products li.product > a.button:hover,
            .woocommerce button.button.alt:hover,
            .woocommerce a.button.alt:hover,
            .woocommerce #respond input#submit:hover, input.button:hover,
            .woocommerce input.button:hover,
            .white_on_black .woocommerce a.button.alt:hover,
            .unslider-nav ol li.unslider-active:hover,
            .woocommerce .widget_price_filter .price_slider_amount .button:hover,
            .artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button:hover,
            .artemis-swp-minicart-icon .artemis-swp-minicart .buttons .button.checkout:hover,
            .button:hover, .wc-forward:hover{
                background-color: <?php echo esc_html($lc_customize['lc_btn_bg_color_hover']) ?>;
                border-color: <?php echo esc_html($lc_customize['lc_btn_border_color_hover']) ?>;
                color: <?php echo esc_html($lc_customize['lc_btn_txt_color_hover']) ?>;
            };
            <?php }?>
		</style>
		<?php
	}
}

/*
	sanitize rgba colors
*/
function ARTEMIS_SWP_sanitize_rgba_color($color) {
	if ('' === $color ) {
		return '';
	}

    if (false === strpos($color, 'rgba')) {
        return sanitize_hex_color($color );
    }	

    /*remove empty spaces*/
 	$color = str_replace(' ', '', $color);
 	/*read colors*/
	sscanf($color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha);
	/*recreate the rgba*/
    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}

function ARTEMIS_SWP_sanitize_buttons_custom($value) {
	if ($value == "custom_btn_colors") {
		return $value;
	}

	return "use_defaults";
}

?>
