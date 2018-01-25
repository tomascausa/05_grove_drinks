<?php
/*
	Map existing shortcodes to Visual Composer
	Shortcodes already defined in add_shortcodes.php
*/
/*
	Gallery shortcode - ok
*/
if (shortcode_exists('js_swp_gallery')) {

	add_action( 'vc_before_init', 'ARTEMIS_SWP_map_js_swp_gallery' );
	function ARTEMIS_SWP_map_js_swp_gallery() {
		vc_map( array(
			  "name" => esc_html__("Gallery", "artemis-swp-core"),
			  "base" => "js_swp_gallery",
			  "class" => "",
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  'icon'=> VCICONS_URL . 'vc_gallery.png',
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Row height in pixels", "artemis-swp-core"),
					"param_name" => "rowheight",
					"value" => "",
					"description" => esc_html__("Row height in pixels. Digits only. Default value: 180", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "View all text message", "artemis-swp-core"),
					"param_name" => "viewallmessage",
					"value" => "",
					"description" => esc_html__("View all text message. If empty, default value is: View All Images", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Gallery Page URL", "artemis-swp-core"),
					"param_name" => "photosurl",
					"value" => "",
					"description" => esc_html__("URL to all Photo Gallery page.", "artemis-swp-core")
				),						
				array(
					"type" => "attach_images",
					"class" => "",
					"heading" => esc_html__( "Add images", "artemis-swp-core"),
					"param_name" => "images",
					"value" => "",
					"description" => esc_html__("Add your images here", "artemis-swp-core")
				)
			  )
		));
	}
}


/*
	Contact Form Shortcode - ok
*/
if (shortcode_exists('js_swp_ajax_contact_form')) {

	add_action( 'vc_before_init', 'ARTEMIS_SWP_js_swp_ajax_contact_shortcode' );
	function ARTEMIS_SWP_js_swp_ajax_contact_shortcode() {
		vc_map( array(
			  "name" => esc_html__("Ajax Contact Form", "artemis-swp-core"),
			  "base" => "js_swp_ajax_contact_form",
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_contact.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Input Styling", "artemis-swp-core"),
					"param_name" => "input_styling",
					"value" =>  array( 
									"One on Row" => "one_on_row",
									"Three on Row" => "three_on_row"
								),
					"description" => esc_html__("Choose how to render the input fields", "artemis-swp-core")
				)
			  )
		));
	}
}

/*
	Section Heading - ok
*/
if (shortcode_exists('js_swp_row_heading')) {

	add_action( 'vc_before_init', 'ARTEMIS_SWP_js_swp_row_heading_shortcode' );

	function ARTEMIS_SWP_js_swp_row_heading_shortcode() {
		vc_map( array(
			  "name" => esc_html__("Section Heading", "artemis-swp-core"),
			  "base" => "js_swp_row_heading",
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_heading.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Title", "artemis-swp-core"),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__("Section title - use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Title transform" ),
					"param_name" => "title_transform",
					"value" => array(
						"No transform"	=> "no_transform",
						"Uppercase"		=> "text_uppercase"
					),
					"description" => esc_html__("Make section title uppercase", "artemis-swp-core")
				),
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Subtitle", "artemis-swp-core"),
					"param_name" => "subtitle",
					"value" => "",
					"description" => esc_html__("Section subtitle (optional) - use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Subtitle transform", "artemis-swp-core"),
					"param_name" => "subtitle_transform",
					"value" => array(
						"No transform"	=> "no_transform",
						"Uppercase"		=> "text_uppercase"
					),
					"description" => esc_html__("Make section subtitle uppercase", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Text align", "artemis-swp-core"),
					"param_name" => "text_align",
					"value" => array(
						"Center"	=> "text_center",
						"Left"		=> "text_left",
						"Rigth"		=> "text_right"
					),
					"description" => esc_html__("Text alignment", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Show order", "artemis-swp-core"),
					"param_name" => "heading_order",
					"value" => array(
						"Subtitle Under Title - Default"	=> "subtitle_under_title",
						"Subtitle Above Title"				=> "subtitle_above_title"
					),
					"description" => esc_html__("Choose what to show first.", "artemis-swp-core")
				)
			  )
		));
	}
}

if (shortcode_exists('at_swp_reverse_letter_with_text')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_at_swp_reverse_letter_with_text_shortcode');
	function ARTEMIS_SWP_at_swp_reverse_letter_with_text_shortcode() {
		$html_usage = "The following html tags allowed: Use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color. ";
		$html_usage .= "Use &lt;br&gt; to break the line. ";
		$html_usage .= "Use &lt;strong&gt;some bold text&lt;/strong&gt; to increase the font weight of one of your words. ";

		$heading_desc = "Heading. ".$html_usage;
		$content_desc = "Text content. ".$html_usage;

		vc_map( array(
			  "name" => esc_html__("Reverse Letter With Text", "artemis-swp-core"),
			  "base" => "at_swp_reverse_letter_with_text",
			  "class" => "",
              'icon'=> VCICONS_URL . 'vc_rev_letter.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Letter", "artemis-swp-core"),
					"param_name" => "letter",
					"admin_label"	=> true,
					"value" => "",
					"description" => esc_html__("Flip letter shown on left", "artemis-swp-core")
				),			  	
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Heading", "artemis-swp-core"),
					"param_name" => "heading",
					"value" => "",
					"description" => esc_html__($heading_desc, "artemis-swp-core")
				),
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__("Content", "artemis-swp-core"),
					"param_name" => "text_content",
					"value" => "",
					"description" => esc_html__($content_desc, "artemis-swp-core")
				)
			  )
		));
	}
}

/*
	Heading with letter
*/
if (shortcode_exists('at_swp_heading_with_letter')) {

	add_action( 'vc_before_init', 'ARTEMIS_SWP_at_swp_heading_with_letter_shortcode' );

	function ARTEMIS_SWP_at_swp_heading_with_letter_shortcode() {
		$html_usage = "The following html tags allowed: Use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color. ";
		$html_usage .= "Use &lt;br&gt; to break the line. ";
		$html_usage .= "Use &lt;strong&gt;some bold text&lt;/strong&gt; to increase the font weight of one of your words. ";

		$smallh_description = "The first heading - small one, shown on top.  ";
		$smallh_description .= $html_usage;

		$bigh_description = "Second heading, bigger font size, shown on bottom.";
		$bigh_description .= $html_usage;

		vc_map( array(
			  "name" => esc_html__("Title With Letter", "artemis-swp-core"),
			  "base" => "at_swp_heading_with_letter",
			  "class" => "",
              'icon'=> VCICONS_URL . 'vc_title_letter.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Small Heading", "artemis-swp-core"),
					"param_name" => "small_heading",
					"value" => "",
					"description" => esc_html__($smallh_description, "artemis-swp-core")
				),
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Big Heading", "artemis-swp-core"),
					"param_name" => "big_heading",
					"value" => "",
					"description" => esc_html__($bigh_description, "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Letter", "artemis-swp-core"),
					"param_name" => "letter",
					"value" => "",
					"description" => esc_html__("Transparent letter shown on left", "artemis-swp-core")
				),
				//align
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Block alignment", "artemis-swp-core"),
					"param_name" => "align",
					"value" => array(
						"Left"		=> "block_left",
						"Center"	=> "block_center",
						"Rigth"		=> "block_right"
					),
					"description" => esc_html__("Choose the alignment for the entire block.", "artemis-swp-core")
				)
			  )
		));
	}
}

/*Standard Heading*/
if (shortcode_exists("at_swp_standard_heading")) {
	add_action('vc_before_init', 'ARTEMIS_SWP_at_swp_standard_heading_map');
	function ARTEMIS_SWP_at_swp_standard_heading_map() {
		vc_map( array(
			  "name" => esc_html__("Standard Heading", "artemis-swp-core"),
			  "base" => "at_swp_standard_heading",
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_heading.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Heading Type", "artemis-swp-core"),
					"param_name" => "heading_type",
					"admin_label" => true,
					"value"		=> array( 
									"h1" => "1",
									"h2" => "2",
									"h3" => "3",
									"h4" => "4",
									"h5" => "5",
									"h6" => "6"
								),
					"description" => esc_html__("Choose heading", "artemis-swp-core")
				),				  	
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Heading Text", "artemis-swp-core"),
					"param_name" => "text",
                    'admin_label' => true,
					"value" => "",
					"description" => esc_html__("Text content for heading", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Text Transform", "artemis-swp-core"),
					"param_name" => "text_transform",
					"value"		=> array( 
									"none" => "no_transform",
									"uppercase" => "text_uppercase"
								),
					"description" => esc_html__("Make your heading uppercase", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Center Heading", "artemis-swp-core"),
					"param_name" => "text_center",
					"value"		=> array( 
									"left" => "text_left",
									"center" => "text_center",
									"right" => "text_right",
								),
					"description" => esc_html__("Center the heading to the container", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Custom Font Size", "artemis-swp-core"),
					"param_name" => "font_size",
					"value" => "",
					"description" => esc_html__("Overwrite default font size in pixels for your heading. Enter an integer value.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Custom Letter Spacing", "artemis-swp-core"),
					"param_name" => "letter_spacing",
					"value" => "",
					"description" => esc_html__("Overwrite default letter spacing in pixels for your heading. Enter an integer value.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Custom Font Weight", "artemis-swp-core"),
					"param_name" => "font_weight",
					"value" => array( 
									"Default" => "default",
									"Light" => "300",
									"Bold" => "700",
									"Bolder" => "900"
								),
					"description" => esc_html__("Overwrite default font weight for your heading.", "artemis-swp-core")
				),
                //responsive
                array(
                    "type"        => "at_swp_letter_spacing_responsive",
                    "group"       => esc_html__("Responsive Options", "artemis-swp-core"),
                    "param_name"  => "responsiveness",
                    "description" => esc_html__("Responsive letter spacing and font size. Enter integer values. All values inherit from smaller.", "artemis-swp-core")
				)					
			  )
		));
	}
}

/*	
	Custom Link
*/
if (shortcode_exists('at_swp_custom_link')) {
	add_action('vc_before_init', 'ARTEMIS_SWP_at_swp_custom_link_map');
	function ARTEMIS_SWP_at_swp_custom_link_map() {
		vc_map( array(
			  "name" => esc_html__("Custom Link", "artemis-swp-core"),
			  "base" => "at_swp_custom_link",
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_link.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"admin_label" => true,
					"heading" => esc_html__( "Link Text", "artemis-swp-core"),
					"param_name" => "text",
					"value" => "",
					"description" => esc_html__("Text content for link", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Link URL", "artemis-swp-core"),
					"param_name" => "url",
					"value" => "",
					"description" => esc_html__("URL for link", "artemis-swp-core")
				),				
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Text Transform", "artemis-swp-core"),
					"param_name" => "text_transform",
					"value"		=> array( 
									"None" => "no_transform",
									"Uppercase" => "text_uppercase"
								),
					"description" => esc_html__("Make your link text uppercase", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Center Link", "artemis-swp-core"),
					"param_name" => "text_center",
					"value"		=> array( 
									"left" => "text_left",
									"center" => "text_center",
									"right" => "text_right",
								),
					"description" => esc_html__("Center the link to the container", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Custom Font Size", "artemis-swp-core"),
					"param_name" => "font_size",
					"value" => "",
					"description" => esc_html__("Overwrite default font size in pixels for the link text. Enter an integer value.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Custom Letter Spacing", "artemis-swp-core"),
					"param_name" => "letter_spacing",
					"value" => "",
					"description" => esc_html__("Overwrite default letter spacing in pixels for the link text. Enter an integer value.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Custom Font Weight", "artemis-swp-core"),
					"param_name" => "font_weight",
					"value" => array( 
									"Default" => "default",
									"Light" => "300",
									"Bold" => "700",
									"Bolder" => "900"
								),
					"description" => esc_html__("Overwrite default font weight for link text.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Visual Effect", "artemis-swp-core"),
					"param_name" => "visual_effect",
					"value" => array( 
									"Theme Default" => "default",
									"Horizontal Line Before" => "line_before"
								),
					"description" => esc_html__("Add a visual effect for link.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Text Color", "artemis-swp-core"),
					"param_name" => "text_color",
					"value" => array( 
									"Theme Default" => "default",
									"Use vibrant color" => "lc_vibrant_color",
									"Custom color" => "lc_custom_color"
								),
					"description" => esc_html__("Choose to color the text in vibrant color.", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Link Color", "artemis-swp-core"),
					"param_name" => "custom_color",
					"value"		=> "",
                    'dependency' => array(
                        'element'   => 'text_color',
                        'value' => 'lc_custom_color'
                    ),					
					"description" => esc_html__("Choose custom text color for link", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Link Hover Color", "artemis-swp-core"),
					"param_name" => "custom_hover_color",
					"value"		=> "",
                    'dependency' => array(
                        'element'   => 'text_color',
                        'value' => 'lc_custom_color'
                    ),					
					"description" => esc_html__("Choose custom text hover color for link", "artemis-swp-core")
				),				
                //responsive
                array(
                    "type"        => "at_swp_letter_spacing_responsive",
                    "group"       => esc_html__("Responsive Options", "artemis-swp-core"),
                    "param_name"  => "responsiveness",
                    "description" => esc_html__("Responsive letter spacing and font size. Enter integer values. All values inherit from smaller.", "artemis-swp-core")
				)
			  )
		));
	}
}


/*
	Artemis Button - ok
*/
if (shortcode_exists('js_swp_theme_button')) {

	add_action('vc_before_init', 'ARTEMIS_SWP_js_swp_theme_button_map');
	function ARTEMIS_SWP_js_swp_theme_button_map() {
		vc_map( array(
			  "name" => esc_html__("Artemis Button", "artemis-swp-core"),
			  "base" => "js_swp_theme_button",
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_button.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textfield",
                    "admin_label" => true,
					"class" => "",
					"heading" => esc_html__( "Button Text", "artemis-swp-core"),
					"param_name" => "button_text",
					"value" => "",
					"description" => esc_html__("Text shown on Button", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Button URL", "artemis-swp-core"),
					"param_name" => "button_url",
					"value" => "",
					"description" => esc_html__("URL for this button", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Button Align", "artemis-swp-core"),
					"param_name" => "button_align",
					"value"		=> array( 
									"Left" => "button_left",
									"Center" => "button_center",
									"Right" => "button_right"
								),
					"description" => esc_html__("Button alignment", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Button Corners", "artemis-swp-core"),
					"param_name" => "button_corners",
					"value"		=> array( 
									"Default" => "default",
									"Rounded Corners" => "rounded_corners"
								),
					"description" => esc_html__("Choose rounded corners for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Background Color", "artemis-swp-core"),
					"param_name" => "button_bg_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom background color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Background Color On Hover", "artemis-swp-core"),
					"param_name" => "button_bg_hover_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom hover background color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Text Color", "artemis-swp-core"),
					"param_name" => "button_text_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom text color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Text Color On Hover", "artemis-swp-core"),
					"param_name" => "button_text_hover_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom hover text color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Border Color", "artemis-swp-core"),
					"param_name" => "button_border_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom border color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Button Border Color On Hover", "artemis-swp-core"),
					"param_name" => "button_border_hover_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom hover border color for this button", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Button Custom Letter Spacing", "artemis-swp-core"),
					"param_name" => "button_letter_spacing",
					"value" => "",
					"description" => esc_html__("Add custom letter spacing for this button", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "Button Custom Horizontal Padding", "artemis-swp-core"),
					"param_name" => "button_cust_hpadding",
					"value" => "",
					"description" => esc_html__("Add custom horizontal padding that will be applied to left and right padding", "artemis-swp-core")
				),				
                array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Button Direction", "artemis-swp-core" ),
                    "param_name"  => "button_cust_hpadding",
                    "value"       => array(
                        esc_html__("Horizontal", 'artemis-swp-core')   => "default",
                        esc_html__( "Vertical", 'artemis-swp-core' ) => "vertical_btn"
                    )
                )				
			  )
		));
	}
}

/*
	User Review - ok
*/
if (shortcode_exists('lc_swp_user_review')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_swp_user_review_map' );
	function ARTEMIS_SWP_lc_swp_user_review_map() {
		$html_usage = "The following html tags allowed: Use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color. ";
		$html_usage .= "Use &lt;br&gt; to break the line. ";
		$html_usage .= "Use &lt;i&gt;some italic text&lt;/i&gt; to make one of your words italic. ";
		$html_usage .= "Use &lt;strong&gt;some bold text&lt;/strong&gt; to increase the font weight of one of your words. ";

		$review_content_desc = "Insert the review content.  ";
		$review_content_desc .= $html_usage;

		vc_map(array(
			  "name" => esc_html__("User Review", "artemis-swp-core"),
			  "base" => "lc_swp_user_review",
			  "content_element" => true,
			  "class" => "",
              'icon' => VCICONS_URL . 'vc_review.png',
			  "as_child" => array('only' => 'lc_review_slider'),
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Reviewer Name", "artemis-swp-core"),
					"param_name" => "reviewer_name",
					"admin_label" =>true,
					"value" => "",
					"description" => esc_html__("Reviewer Name", "artemis-swp-core")
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_html__( "Reviewer Image", "artemis-swp-core"),
					"param_name" => "reviewer_image",
					"value" => "",
					"description" => esc_html__("Image for the review author", "artemis-swp-core")
				),
				array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__( "Review Content", "artemis-swp-core"),
					"param_name" => "review_content",
					"value"		=> "",
					"description" => esc_html__($review_content_desc, "artemis-swp-core")
				)
			  )
		));
	}
}


if (shortcode_exists('lc_review_slider')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_review_slider_map' );
	function ARTEMIS_SWP_lc_review_slider_map() {
		vc_map( array(
			"name" => esc_html__("User Reviews Slider", "artemis-swp-core"),
			"base" => "lc_review_slider",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"as_parent" => array('only' => 'lc_swp_user_review'), /* Use only|except attributes to limit child shortcodes (separate multiple values with comma)*/
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon' => VCICONS_URL . 'vc_users.png',
			"js_view" => 'VcColumnView',
            'params' => array(
                array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Style", "artemis-swp-core" ),
                    "param_name"  => "style",
                    "value"       => array(
                        esc_html__("Slider", 'artemis-swp-core')   => "slider",
                        esc_html__( "Two Rows", 'artemis-swp-core' ) => "two_rows"
                    )
                ),
                array(
                    "type"        => "colorpicker",
                    "class"       => "",
                    "heading"     => esc_html__( "Top Background Color", "artemis-swp-core" ),
                    "param_name"  => "top_bg_color",
                    'dependency' => array(
                        'element'   => 'style',
                        'value' => 'two_rows'
                    ),
                ),
                array(
                    "type"        => "colorpicker",
                    "heading"     => esc_html__( "Bottom Background Color", "artemis-swp-core" ),
                    "param_name"  => "bottom_bg_color",
                    'dependency' => array(
                        'element'   => 'style',
                        'value' => 'two_rows'
                    ),
                ),
				array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Slider Navigation Is", "artemis-swp-core" ),
                    "param_name"  => "arrows",
                    "value"       => array(
                        esc_html__("Visible", 'artemis-swp-core')   => "visible",
                        esc_html__( "Hidden", 'artemis-swp-core' ) => "hidden"
                    ),
					'dependency' => array(
                        'element'   => 'style',
                        'value' => 'slider'
                    )
                ),
				array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Font Style", "artemis-swp-core" ),
                    "param_name"  => "font_style",
                    "value"       => array(
                        esc_html__("Big Font (default)", 'artemis-swp-core')   => "big_font",
                        esc_html__( "Small Font", 'artemis-swp-core' ) => "small_font"
                    ),
					'dependency' => array(
                        'element'   => 'style',
                        'value' => 'slider'
                    )
                ),
				array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Image Border", "artemis-swp-core" ),
                    "param_name"  => "image_border",
                    "value"       => array(
                        esc_html__("Rounded", 'artemis-swp-core')   => "rounded",
                        esc_html__( "Image Default", 'artemis-swp-core' ) => "image_default"
                    ),
					'dependency' => array(
                        'element'   => 'style',
                        'value' => 'slider'
                    )
                ),
				array(
                    "type"        => "dropdown",
                    "heading"     => esc_html__( "Image Size", "artemis-swp-core" ),
                    "param_name"  => "image_size",
                    "value"       => array(
                        esc_html__("Theme Default", 'artemis-swp-core')   => "theme_default",
                        esc_html__( "Image Default", 'artemis-swp-core' ) => "image_default"
                    ),
					'dependency' => array(
                        'element'   => 'style',
                        'value' => 'slider'
                    )
                )                
            )
		));
	}
}


/*
	Extend VC classes for nested/container shortcodes
*/
add_action( 'vc_after_init', 'ARTEMIS_SWP_def_extend_bakery_container' );
function ARTEMIS_SWP_def_extend_bakery_container() {
	/*
		extend classes here, in after_init action, 
		since base class might not be defined in other moments of execution
	*/
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_lc_review_slider extends WPBakeryShortCodesContainer {
		}
	}
	if (class_exists( 'WPBakeryShortCode')) {
		class WPBakeryShortCode_lc_swp_user_review extends WPBakeryShortCode {
		}
	}

	/* Product Attribute Showcase */
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_lc_prod_attributes_showcase extends WPBakeryShortCodesContainer {
		}
	}
	if (class_exists( 'WPBakeryShortCode')) {
		class WPBakeryShortCode_lc_prod_attribute extends WPBakeryShortCode {
		}
	}

	/*Products Grid Container*/
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_lc_prods_grid_container extends WPBakeryShortCodesContainer {
		}
	}
	if (class_exists( 'WPBakeryShortCode')) {
		class WPBakeryShortCode_at_swp_artemis_grid_product extends WPBakeryShortCode {
		}
		class WPBakeryShortCode_at_swp_artemis_collection_promo extends WPBakeryShortCode {
		}		
	}
	

	/*Lookbook container slider*/
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_lc_lookbook_slider extends WPBakeryShortCodesContainer {
		}
	}
	if (class_exists( 'WPBakeryShortCode')) {
		class WPBakeryShortCode_at_swp_lookbook_single extends WPBakeryShortCode {
		}
	}	
}

/*
	Products Grid Container
*/
if (shortcode_exists('lc_prods_grid_container')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_prods_grid_container_map');
	function ARTEMIS_SWP_lc_prods_grid_container_map() {
		vc_map( array(
			"name" => esc_html__("Products Grid Container", "artemis-swp-core"),
			"base" => "lc_prods_grid_container",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"as_parent" => array('only' => 'at_swp_artemis_grid_product, at_swp_artemis_collection_promo'), 
			/* Use only|except attributes to limit child shortcodes (separate multiple values with comma)*/
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon' => VCICONS_URL . 'vc_grid.png',
			"js_view" => 'VcColumnView',
			"params"	=> array(
                array(
                    "type"        => "textfield",
                    "class"       => "",
                    "heading"     => esc_html__( "Gap", "artemis-swp-core" ),
                    "param_name"  => "gap",
                    "value"       => 0,
                    "description" => esc_html__("Distance between products. Default value: 0. Please use a value between 0 and 30.", "artemis-swp-core")
                ),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Bricks On Row", "artemis-swp-core"),
					"param_name" => "bricks_on_row",
					"value"		=> array( 
									"4 Bricks" => "4_bricks",
									"3 Bricks" => "3_bricks"
								),
					"description" => esc_html__("Choose the number of bricks on row.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Aspect ratio for single brick", "artemis-swp-core"),
					"param_name" => "aspect_ratio",
					"value"		=> array( 
									"4:3" => "ar4_3",
									"16:9" => "ar16_9",
									"Custom" => "ar_custom"
								),
					"description" => esc_html__("Choose the number of bricks on row.", "artemis-swp-core")
				),
				array(
                    "type"        => "textfield",
                    "class"       => "",
                    "heading"     => esc_html__( "Custom Aspect Ratio", "artemis-swp-core" ),
                    "param_name"  => "user_ar",
                    "value"       => 0,
                    'dependency' => array(
                        'element'   => 'aspect_ratio',
                        'value' => 'ar_custom'
                    ),		
                    "description" => esc_html__("Please enter a number represents the ratio between brick width and height. Example: 0.9", "artemis-swp-core")
                ),
            )
		));
	}
}

/*
	Product Attributes Showcase
*/
if (shortcode_exists('lc_prod_attributes_showcase')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_prod_attributes_showcase_map');
	function ARTEMIS_SWP_lc_prod_attributes_showcase_map() {
		vc_map( array(
			"name" => esc_html__("Product Attribute Showcase", "artemis-swp-core"),
			"base" => "lc_prod_attributes_showcase",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"as_parent" => array('only' => 'lc_prod_attribute'), /* Use only|except attributes to limit child shortcodes (separate multiple values with comma)*/
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon'=> VCICONS_URL . 'vc_attr_show.png',
			"js_view" => 'VcColumnView',
			"params"	=> array(
				/*array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Align Element", "artemis-swp-core"),
					"param_name" => "align_elt",
					"value"		=> array( 
									"Left" => "float_left",
									"Right" => "float_right"
								),
					"description" => esc_html__("Choose element alignment", "artemis-swp-core")
				)*/
			)
		));
	}
}

if (shortcode_exists('lc_prod_attribute')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_prod_attribute_map');
	function ARTEMIS_SWP_lc_prod_attribute_map() {
		vc_map(array(
			  "name" => esc_html__("Product Attribute", "artemis-swp-core"),
			  "base" => "lc_prod_attribute",
			  "content_element" => true,
			  "class" => "",
              'icon' => 'at_swp_vc_icon',
			  "as_child" => array('only' => 'lc_prod_attributes_showcase'),
			  "params" => array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_html__( "Attribute Image", "artemis-swp-core"),
					"param_name" => "attr_img",
					"value" => "",
					"description" => esc_html__("Image that shows product attribute (ex: material image)", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Attribute Name", "artemis-swp-core"),
					"param_name" => "attr_txt",
					"value" => "",
					"description" => esc_html__("Attribute Name (ex: GREY)", "artemis-swp-core")
				),
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_html__( "Product Image", "artemis-swp-core"),
					"param_name" => "product_img",
					"value" => "",
					"description" => esc_html__("Image that shows the product having this attribute", "artemis-swp-core")
				)
			  )
		));
	}
}


/*
	Video Shortcode
*/
/*
		'video_title' 		=> '',
		'bg_img' 			=> '',
		'color_overlay'	=> 'rgba(0,0,0,0)',
		'video_url'			=> '',
		'section_height'	=> '700'
*/
if (shortcode_exists('at_swp_video_shortcode')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_video_shortcode_map' );
	function ARTEMIS_SWP_video_shortcode_map() {
		vc_map(array(
			  "name" => esc_html__("Video Section", "artemis-swp-core"),
			  "base" => "at_swp_video_shortcode",
			  "class" => "",
              'icon'=> VCICONS_URL . 'vc_video.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Video Title", "artemis-swp-core"),
					"param_name" => "video_title",
					"value" => "",
					"description" => esc_html__("Title for your video. Can be empty.", "artemis-swp-core")
				),
				array(
					"type" => "attach_images",
					"class" => "",
					"heading" => esc_html__( "Background Image", "artemis-swp-core"),
					"param_name" => "bg_img",
					"value" => "",
					"description" => esc_html__("Add a background image for your section", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Section overlay", "artemis-swp-core"),
					"param_name" => "color_overlay",
					"value"		=> "",
					"description" => esc_html__("Add a custom overlay for better title readability. By default it is transparent.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Video URL", "artemis-swp-core"),
					"param_name" => "video_url",
					"value" => "",
					"description" => esc_html__("Paste the URL for your video. YouTube and Vimeo are supported.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Section height", "artemis-swp-core"),
					"param_name" => "section_height",
					"value" => "",
					"description" => esc_html__("Section height in pixels. Default value: 700px", "artemis-swp-core")
				)
			  )
		));
	}
}

/*
	Blog Shortcode - ok
*/
if (shortcode_exists('js_swp_blog_shortcode')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_blog_shortcode_map' );
	function ARTEMIS_SWP_blog_shortcode_map()
	{
		vc_map(array(
			  "name" => esc_html__("Blog Posts", "artemis-swp-core"),
			  "base" => "js_swp_blog_shortcode",
			  "class" => "",
              'icon'=> VCICONS_URL . 'vc_blog.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Number Of Posts", "artemis-swp-core"),
					"param_name" => "postsnumber",
					"value" => "",
					"description" => esc_html__("Number of posts to show. Default value: 3", "artemis-swp-core")
				)
			  )
		));
	}
}


/*
	WooCommerce Best Products Slider
*/
if (shortcode_exists('at_swp_woo_best_prod_slider')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_at_swp_woo_best_prod_slider_map' );
	function ARTEMIS_SWP_at_swp_woo_best_prod_slider_map()
	{
		vc_map(array(
			  "name" => esc_html__("WooCommerce Best Products Slider", "artemis-swp-core"),
			  "base" => "at_swp_woo_best_prod_slider",
			  "class" => "",
              'icon'		=> VCICONS_URL . 'vc_bp_slider.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Number Of Products", "artemis-swp-core"),
					"param_name" => "products_to_show",
					"value" => "",
					"description" => esc_html__("Number of products to show. Default value: 5", "artemis-swp-core")
				),
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Next Slide Text", "artemis-swp-core"),
					"param_name" => "text_next",
					"value" => "",
					"description" => esc_html__("Text shown on [Next] slide navigation link", "artemis-swp-core")
				),
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Prevous Slide Text", "artemis-swp-core"),
					"param_name" => "text_prev",
					"value" => "",
					"description" => esc_html__("Text shown on [Prev] slide navigation link", "artemis-swp-core")
				),	
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Buy Button Corners", "artemis-swp-core"),
					"param_name" => "button_corners",
					"value"		=> array( 
									"Default" => "default",
									"Rounded Corners" => "rounded_corners"
								),
					"description" => esc_html__("Choose rounded corners for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Buy Button Background Color", "artemis-swp-core"),
					"param_name" => "button_bg_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom background color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Buy Button Background Color On Hover", "artemis-swp-core"),
					"param_name" => "button_bg_hover_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom hover background color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Buy Button Text Color", "artemis-swp-core"),
					"param_name" => "button_text_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom text color for this button", "artemis-swp-core")
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Custom Buy Button Text Color On Hover", "artemis-swp-core"),
					"param_name" => "button_text_hover_color",
					"value"		=> "",
					"description" => esc_html__("Choose custom hover text color for this button", "artemis-swp-core")
				)
			  )
		));
	}
}


if ( shortcode_exists( 'at_swp_icon_box' ) ) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_icon_box_map' );
	function ARTEMIS_SWP_icon_box_map() {
		vc_map(
			array(
				'name'     => esc_html__( 'Artemis Icon Box', 'artemis-swp-core' ),
				'base'     => 'at_swp_icon_box',
				"class"    => '',
                'icon'=> VCICONS_URL . 'vc_iconbox.png',
				"category" => esc_html__( "Artemis Elements", 'artemis-swp-core' ),
				'params'   => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Title', 'artemis-swp-core' ),
						'param_name' => 'title'
					),
					array(
						'type'       => 'textarea_html',
						'heading'    => esc_html__( 'Content', 'artemis-swp-core' ),
						'param_name' => 'content'
					),
					array(
						'type'       => 'vc_link',
						'heading'    => esc_html__( 'URL', 'artemis-swp-core' ),
						'param_name' => 'url'
					),
					//region Icons
					array(
						'type'       => 'checkbox',
						'heading'    => esc_html__( 'Add icon?', 'artemis-swp-core' ),
						'param_name' => 'add_icon',
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Icon library', 'artemis-swp-core' ),
						'value'       => array(
							esc_html__( 'Font Awesome', 'artemis-swp-core' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'artemis-swp-core' )  => 'openiconic',
							esc_html__( 'Typicons', 'artemis-swp-core' )     => 'typicons',
							esc_html__( 'Entypo', 'artemis-swp-core' )       => 'entypo',
							esc_html__( 'Linecons', 'artemis-swp-core' )     => 'linecons'
						),
						'admin_label' => true,
						'param_name'  => 'type',
                        			'save_always' => true,
						'description' => esc_html__( 'Select icon library.', 'artemis-swp-core' ),
						'dependency'  => array(
							'element'   => 'add_icon',
							'not_empty' => true
						),
						'group'       => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'        => 'iconpicker',
						'heading'     => esc_html__( 'Icon', 'artemis-swp-core' ),
						'param_name'  => 'icon_fontawesome',
						'value'       => 'fa fa-adjust', // default value to backend editor admin_label
						'settings'    => array(
							'emptyIcon'    => false,
							// default true, display an "EMPTY" icon?
							'iconsPerPage' => 4000,
							// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
						),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'fontawesome',
						),
						'description' => esc_html__( 'Select icon from library.', 'artemis-swp-core' ),
						'group'       => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'        => 'iconpicker',
						'heading'     => esc_html__( 'Icon', 'artemis-swp-core' ),
						'param_name'  => 'icon_openiconic',
						'value'       => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
						'settings'    => array(
							'emptyIcon'    => false, // default true, display an "EMPTY" icon?
							'type'         => 'openiconic',
							'iconsPerPage' => 4000, // default 100, how many icons per/page to display
						),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'openiconic',
						),
						'description' => esc_html__( 'Select icon from library.', 'artemis-swp-core' ),
						'group'       => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'        => 'iconpicker',
						'heading'     => esc_html__( 'Icon', 'artemis-swp-core' ),
						'param_name'  => 'icon_typicons',
						'value'       => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
						'settings'    => array(
							'emptyIcon'    => false, // default true, display an "EMPTY" icon?
							'type'         => 'typicons',
							'iconsPerPage' => 4000, // default 100, how many icons per/page to display
						),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'typicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'artemis-swp-core' ),
						'group'       => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'       => 'iconpicker',
						'heading'    => esc_html__( 'Icon', 'artemis-swp-core' ),
						'param_name' => 'icon_entypo',
						'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
						'settings'   => array(
							'emptyIcon'    => false, // default true, display an "EMPTY" icon?
							'type'         => 'entypo',
							'iconsPerPage' => 4000, // default 100, how many icons per/page to display
						),
						'dependency' => array(
							'element' => 'type',
							'value'   => 'entypo',
						),
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'        => 'iconpicker',
						'heading'     => esc_html__( 'Icon', 'artemis-swp-core' ),
						'param_name'  => 'icon_linecons',
						'value'       => 'vc_li vc_li-heart', // default value to backend editor admin_label
						'settings'    => array(
							'emptyIcon'    => false, // default true, display an "EMPTY" icon?
							'type'         => 'linecons',
							'iconsPerPage' => 4000, // default 100, how many icons per/page to display
						),
						'dependency'  => array(
							'element' => 'type',
							'value'   => 'linecons',
						),
						'description' => esc_html__( 'Select icon from library.', 'artemis-swp-core' ),
						'group'       => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Icon Color', 'artemis-swp-core' ),
						'param_name' => 'icon_color',
						'dependency' => array(
							'element'   => 'add_icon',
							'not_empty' => true,
						),
						'value'      => '#797979', // default value to backend editor admin_label
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Icon Hover Color', 'artemis-swp-core' ),
						'param_name' => 'icon_hover_color',
						'value'      => '#797979', // default value to backend editor admin_label
						'dependency' => array(
							'element'   => 'add_icon',
							'not_empty' => true,
						),
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					/*
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon Position', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Left', 'artemis-swp-core' ) => 'left',
							esc_html__( 'Top', 'artemis-swp-core' )  => 'top'
						),
						'param_name' => 'icon_pos',
						'dependency' => array(
							'element'   => 'add_icon',
							'not_empty' => true
						),
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					*/
					/*
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Icon Background Color', 'artemis-swp-core' ),
						'param_name' => 'icon_bg_color',
						'value'      => 'rgba(255,255,255,0.01)', // default value to backend editor admin_label
						'dependency' => array(
							'element' => 'icon_pos',
							'value'   => 'top'
						),
						'group'      => esc_html__( 'Icon', 'artemis-swp-core' )
					),
					*/
					array(
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'Css', 'artemis-swp-core' ),
						'param_name' => 'css',
						'group'      => esc_html__( 'Design options', 'artemis-swp-core' ),
					),
					/*
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Hover Text Color', 'artemis-swp-core' ),
						'param_name' => 'hover_color',
						'group'      => esc_html__( 'Design options', 'artemis-swp-core' ),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Hover Background Color', 'artemis-swp-core' ),
						'param_name' => 'hover_bg_color',
						'group'      => esc_html__( 'Design options', 'artemis-swp-core' ),
					),
					*/
				)
			)
		);
	}
}

/*
	Artemis Collection Promo
*/
if (shortcode_exists('at_swp_artemis_collection_promo')) {
	add_action('vc_before_init', 'ARTEMIS_SWP_artemis_collection_promo_map');
	function ARTEMIS_SWP_artemis_collection_promo_map() {
		vc_map( array(
			"name" => esc_html__("Collection Promo", "artemis-swp-core"),
			"base" => "at_swp_artemis_collection_promo",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon'=> VCICONS_URL . 'vc_collection_promo.png',
			"params"	=> array(
	            array(
	                "type"        => "attach_image",
	                "class"       => "",
	                "heading"     => esc_html__("Background Image", "artemis-swp-core"),
	                "param_name"  => "bg_image",
	                "value"       => "",
	                "description" => esc_html__( "Choose a background image.", "artemis-swp-core" )
	            ),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Text Idle Color', 'artemis-swp-core' ),
					'param_name' => 'idle_color',
					"description" => esc_html__( "Choose the text color.", "artemis-swp-core" ),
					"value"       => "#000000"
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Text Hover Color', 'artemis-swp-core' ),
					'param_name' => 'hover_color',
					"description" => esc_html__( "Choose the text color on mouse hover.", "artemis-swp-core" ),
					"value"       => "#000000"
				),
			  	array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__("Vertically (Bold) Text", "artemis-swp-core"),
					"param_name" => "bold_text",
					"value" => "Next",
					"description" => esc_html__("Bold text that can be shown in vertically. Please use &#60;br&#62; between letters to break the line. Ex: ME&#60;br&#62;NS", "artemis-swp-core")
				),
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Additional Text", "artemis-swp-core"),
					"param_name" => "additional_text",
					"value" => "",
					"description" => esc_html__("Text shown on right of the bold text. Works with bold text on multiple lines. Ex: COLLECTION", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Small Heading", "artemis-swp-core"),
					"param_name" => "small_heading",
					"value" => "",
					"description" => esc_html__("Small heading shown above the bold text. Ex: ACCESORIES", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("URL", "artemis-swp-core"),
					"param_name" => "promo_url",
					"value" => "",
					"description" => esc_html__("URL of the page you want to promote.", "artemis-swp-core")
				)
			)
		));		
	}
}
/*
	Artemis Product Shortcode - single grid element
*/
if (shortcode_exists('at_swp_artemis_grid_product')) {
	add_action('vc_before_init', 'ARTEMIS_SWP_artemis_grid_product');
	function ARTEMIS_SWP_artemis_grid_product() {

		$allowed_tags = 'Allowed html tags: &#60;strong&#62;bold text&#60;&#47;strong&#62;, ';
		$allowed_tags .= '&#60;i&#62;italic text&#60;&#47;i&#62;, ';
		$allowed_tags .= 'use &#60;br&#62; to break line, ';
		$allowed_tags .= 'use &#x3C;span class=&#x22;vibrant_color&#x22;&#x3E;some text in vibrant color&#x3C;/span&#x3E; to color some text in vibrant color.';

		vc_map(
			array(
				'name'     => esc_html__( 'Grid Product', 'artemis-swp-core' ),
				'base'     => 'at_swp_artemis_grid_product',
				"class"    => '',
                'icon' => 'at_swp_vc_icon',
				"category" => esc_html__( "Artemis Elements", 'artemis-swp-core' ),
				"as_child" => array('only' => 'lc_prods_grid_container'),
				'params'   => array(
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Brick Shows', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Product', 'artemis-swp-core' ) => 'product_data',
							esc_html__( 'Product Category', 'artemis-swp-core' )  => 'product_cat',
							esc_html__( 'Custom Data', 'artemis-swp-core' )  => 'custom_data'
						),
						'param_name' => 'brick_shows',
						'description' => esc_html__( 'Choose what this element displays', 'artemis-swp-core' ),
					),					
					array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Select identifier', 'artemis-swp-core' ),
						'param_name'  => 'id',
						'description' => esc_html__( 'Input product ID or product SKU or product title to see suggestions', 'artemis-swp-core' ),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => 'product_data'
						),						
					),
					array(
						"type" => "artemis_product_cat",
						"class" => "",
						"heading" => esc_html__("Product Category", "lucille-music-core"),
						"param_name" => "product_cat",
						"value" => "",
						"description" => esc_html__("Choose a product category.", "lucille-music-core"),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => 'product_cat'
						),
					),					
					array(
						'type'       => 'textarea_raw_html',
						'heading'    => esc_html__( 'Custom Title', 'artemis-swp-core' ),
						'param_name' => 'cust_title',
						'description' => esc_html__( 'Add a custom title. '.$allowed_tags, 'artemis-swp-core'),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => 'custom_data'
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Custom Subtitle', 'artemis-swp-core' ),
						'param_name' => 'cust_subtitle',
						'description' => esc_html__( 'Add a custom subtitle.', 'artemis-swp-core'),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => 'custom_data'
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Custom Shop Now Text', 'artemis-swp-core' ),
						'param_name' => 'cust_shop_now_txt',
						'description' => esc_html__( 'Link text. Ex: [Shop Now] or [Take a look]', 'artemis-swp-core'),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => array('custom_data', 'product_cat')
						),
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Custom Shop Now URL', 'artemis-swp-core' ),
						'param_name' => 'cust_shop_now_url',
						'description' => esc_html__( 'URL to the page you want to promote.', 'artemis-swp-core'),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => array('custom_data', 'product_cat')
						),
					),
					array(
						'type'       => 'textarea_raw_html',
						'heading'    => esc_html__( 'Custom Description', 'artemis-swp-core' ),
						'param_name' => 'cust_desc',
						'description' => esc_html__( 'Add a short description', 'artemis-swp-core'),
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => 'custom_data'
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Custom Color Overlay On Hover', 'artemis-swp-core' ),
						'param_name' => 'cust_overlay',
						'dependency' => array(
							'element' => 'brick_shows',
							'value'   => array('custom_data', 'product_cat')
						),
					),
					array(
						'type'       => 'dropdown',
                        'heading'    => esc_html__( 'Background Image Size', 'artemis-swp-core' ),
                        'value'      => array(
                            esc_html__( 'Cover', 'artemis-swp-core' )   => 'cover',
                            esc_html__( 'Contain', 'artemis-swp-core' ) => 'contain',
                            esc_html__( 'Normal', 'artemis-swp-core' )  => 'normal'
                        ),
                        'param_name' => 'bg_image_size',
						'description' => esc_html__( 'Choose background image style.', 'artemis-swp-core' ),
					),
                    array(
                        "type"        => "attach_image",
                        "class"       => "",
                        "heading"     => esc_html__( "Custom background Image", "artemis-swp-core" ),
                        "param_name"  => "custom_bg_img",
                        "value"       => "",
                        "description" => esc_html__( "Use a custom background image instead of product image.", "artemis-swp-core" )
                    ),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text Content Vertical Position', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Bottom', 'artemis-swp-core' ) => 'bottom',
							esc_html__( 'Middle', 'artemis-swp-core' )  => 'middle',
							esc_html__( 'Top', 'artemis-swp-core' )  => 'top'
						),
						'param_name' => 'text_vertical_pos',
						'description' => esc_html__( 'Choose the vertical position of the text in container.', 'artemis-swp-core' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Text Content Horizontal Position', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Left', 'artemis-swp-core' ) => 'left',
							esc_html__( 'Center', 'artemis-swp-core' )  => 'center',
							esc_html__( 'Right', 'artemis-swp-core' )  => 'right'
						),
						'param_name' => 'text_horizontal_pos',
						'description' => esc_html__( 'Choose the horizontal position of the text in container.', 'artemis-swp-core' ),
					),					
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Brick Width', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Default', 'artemis-swp-core' ) => 'default',
							esc_html__( '2X', 'artemis-swp-core' )  => 'brick_2x',
							esc_html__( '3X', 'artemis-swp-core' )  => 'brick_3x'
						),
						'param_name' => 'brick_width',
						'description' => esc_html__( 'Choose to double the width of the brick', 'artemis-swp-core' ),
					),                    
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Brick Height', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Default', 'artemis-swp-core' ) => 'default',
							esc_html__( '2X', 'artemis-swp-core' )  => 'brick_2x',
							esc_html__( '3X', 'artemis-swp-core' )  => 'brick_3x'
						),
						'param_name' => 'brick_height',
						'description' => esc_html__( 'Choose to double the height of the brick', 'artemis-swp-core' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Color Scheme', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Default', 'artemis-swp-core' ) => 'default',
							esc_html__( 'White On Black', 'artemis-swp-core' )  => 'white_on_black',
							esc_html__( 'Black On White', 'artemis-swp-core' )  => 'black_on_white',
						),
						'param_name' => 'color_scheme',
						'description' => esc_html__( 'Force an oposite the color scheme.', 'artemis-swp-core' ),
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Font Size', 'artemis-swp-core' ),
						'value'      => array(
							esc_html__( 'Default', 'artemis-swp-core' ) => 'default',
							esc_html__( 'Small', 'artemis-swp-core' )  => 'small'
						),
						'param_name' => 'font_size',
						'description' => esc_html__( 'Choose between different font size schemes.', 'artemis-swp-core' ),
					)
				)
			)
		);
	}

	add_filter( 'vc_autocomplete_at_swp_artemis_grid_product_id_callback', 'ARTEMIS_SWP_autocomplete_callback' );
	add_filter( 'vc_autocomplete_at_swp_artemis_grid_product_id_render', 'ARTEMIS_SWP_autocomplete_render' );
	function ARTEMIS_SWP_autocomplete_callback( $query ) {
		global $wpdb;
		$product_id      = (int) $query;
		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title, b.meta_value AS sku
					FROM {$wpdb->posts} AS a
					LEFT JOIN ( SELECT meta_value, post_id  FROM {$wpdb->postmeta} WHERE `meta_key` = '_sku' ) AS b ON b.post_id = a.ID
					WHERE a.post_type = 'product' AND ( a.ID = '%d' OR b.meta_value LIKE '%%%s%%' OR a.post_title LIKE '%%%s%%' )", $product_id > 0 ? $product_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A );

		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data          = array();
				$data['value'] = $value['id'];
				$data['label'] = esc_html__( 'Id', 'artemis-swp-core' ) . ': ' . $value['id'] . ( ( strlen( $value['title'] ) > 0 ) ? ' - ' . esc_html__( 'Title', 'artemis-swp-core' ) . ': ' . $value['title'] : '' ) . ( ( strlen( $value['sku'] ) > 0 ) ? ' - ' . esc_html__( 'Sku', 'artemis-swp-core' ) . ': ' . $value['sku'] : '' );
				$results[]     = $data;
			}
		}

		return $results;
	}

	function ARTEMIS_SWP_autocomplete_render($query){
		$query = trim( $query['value'] ); // get value from requested
		if ( ! empty( $query ) ) {
			// get product
			$product_object = wc_get_product( (int) $query );
			if ( is_object( $product_object ) ) {
				$product_sku   = $product_object->get_sku();
				$product_title = $product_object->get_title();
				$product_id    = $product_object->get_id();

				$product_sku_display = '';
				if ( ! empty( $product_sku ) ) {
					$product_sku_display = ' - ' . esc_html__( 'Sku', 'artemis-swp-core' ) . ': ' . $product_sku;
				}

				$product_title_display = '';
				if ( ! empty( $product_title ) ) {
					$product_title_display = ' - ' . esc_html__( 'Title', 'artemis-swp-core' ) . ': ' . $product_title;
				}

				$product_id_display = esc_html__( 'Id', 'artemis-swp-core' ) . ': ' . $product_id;

				$data          = array();
				$data['value'] = $product_id;
				$data['label'] = $product_id_display . $product_title_display . $product_sku_display;

				return ! empty( $data ) ? $data : false;
			}

			return false;
		}

		return false;
	}
}/*if (shortcode_exists('at_swp_artemis_grid_product'))*/

/**
 * Artemis Vertical Separator
 */
if( shortcode_exists('at_swp_vertical_row_separator') ) {

    add_action('vc_before_init', 'ARTEMIS_SWP_vertical_row_separator');
    function ARTEMIS_SWP_vertical_row_separator() {
        vc_map(
            array(
                'name'     => esc_html__('Artemis Vertical Row Separator', 'artemis-swp-core'),
                'base'     => 'at_swp_vertical_row_separator',
                'class'    => '',
                'icon'		=> VCICONS_URL . 'vc_vertical_sep.png',
                'category' => esc_html__('Artemis Elements', 'artemis-swp-core'),
                'params' => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Separator type', 'artemis-swp-core'),
                        'param_name'  => 'type',
                        'value'       => array(
                            esc_html__('Dashed', 'artemis-swp-core') => 'dashed',
                            esc_html__('Dotted', 'artemis-swp-core') => 'dotted',
                            esc_html__('Solid', 'artemis-swp-core')  => 'solid'
                        ),
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Height', 'artemis-swp-core'),
                        'param_name'  => 'height',
                        'admin_label' => true,
                        'save_always' => true,
                        'description' => esc_html__('Enter an integer value followed by a measuring unit: px, em, %. Default: px', 'artemis-swp-core'),
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Line thickness', 'artemis-swp-core'),
                        'param_name'  => 'width',
                        'admin_label' => true,
                        'save_always' => true,
                        'description' => esc_html__('Enter an integer value followed by a measuring unit: px, em, %. Default: px', 'artemis-swp-core'),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "class"       => "",
                        "heading"     => esc_html__("Custom color", "artemis-swp-core"),
                        "param_name"  => "color",
                        'save_always' => true,
                        "description" => esc_html__("Choose custom color for separator ( default: theme vibrant color)", "artemis-swp-core")
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Vertical Anchor', 'artemis-swp-core'),
                        'param_name'  => 'vertical_anchor',
                        'value'       => array(
                            esc_html__('Top', 'artemis-swp-core')  => 'top',
                            esc_html__('Bottom', 'artemis-swp-core') => 'bottom'
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Horizontal Alignment', 'artemis-swp-core'),
                        'param_name'  => 'horizontal_alignment',
                        'value'       => array(
                            esc_html__('Left', 'artemis-swp-core')  => 'left',
                            esc_html__('Center', 'artemis-swp-core') => 'center',
                            esc_html__('Right', 'artemis-swp-core') => 'right'
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('z-index', 'artemis-swp-core'),
                        'param_name'  => 'z_index',
                        'value'       => array(
                            esc_html__('1', 'artemis-swp-core') => '1',
                            esc_html__('0', 'artemis-swp-core') => '0',
                            esc_html__('-1', 'artemis-swp-core')    => '-1',
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__('Separator ends width', 'artemis-swp-core'),
                        'param_name'  => 'ends_with',
                        'value'       => array(
                            esc_html__('Nothing', 'artemis-swp-core') => 'nothing',
                            esc_html__('Text', 'artemis-swp-core')    => 'text',
                            esc_html__('Image', 'artemis-swp-core')   => 'image'
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('End Text', 'artemis-swp-core'),
                        'param_name' => 'end_text',
                        'dependency' => array(
                            'element' => 'ends_with',
                            'value'   => 'text',
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('End Text Weight', 'artemis-swp-core'),
                        'param_name' => 'end_text_weight',
                        'dependency' => array(
                            'element' => 'ends_with',
                            'value'   => 'text',
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                        'value' => array(
                            esc_html__( '100', 'artemis-swp-core' ) => '100',
                            esc_html__( '200', 'artemis-swp-core' ) => '200',
                            esc_html__( '300', 'artemis-swp-core' ) => '300',
                            esc_html__( '400', 'artemis-swp-core' ) => '400',
                            esc_html__( '500', 'artemis-swp-core' ) => '500',
                            esc_html__( '600', 'artemis-swp-core' ) => '600',
                            esc_html__( '700', 'artemis-swp-core' ) => '700',
                            esc_html__( '800', 'artemis-swp-core' ) => '800',
                            esc_html__( '900', 'artemis-swp-core' ) => '900',
                        ),
                    ),
                    array(
                        "type"        => "colorpicker",
                        "class"       => "",
                        "heading"     => esc_html__("Custom Text color", "artemis-swp-core"),
                        "param_name"  => "end_text_color",
                        'dependency' => array(
                            'element' => 'ends_with',
                            'value'   => 'text',
                        ),
                        'save_always' => true,
                        "description" => esc_html__("Choose custom color for text( default: theme vibrant color)", "artemis-swp-core")
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('End Text Font Size', 'artemis-swp-core'),
                        'param_name' => 'end_text_fs',
                        'dependency' => array(
                            'element' => 'ends_with',
                            'value'   => 'text',
                        ),
                        'admin_label' => true,
                        'save_always' => true,
                        "description" => esc_html__("Choose custom font size for end text", "artemis-swp-core")
                    ),
                    array(
                        'type'       => 'attach_image',
                        'heading'    => esc_html__('End Image', 'artemis-swp-core'),
                        'param_name' => 'end_image',
                        'dependency' => array(
                            'element' => 'ends_with',
                            'value'   => 'image',
                        ),
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Offset left', 'artemis-swp-core'),
                        'param_name'  => 'offset_left',
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Offset right', 'artemis-swp-core'),
                        'param_name'  => 'offset_right',
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Extra class', 'artemis-swp-core'),
                        'param_name'  => 'extra_class',
                        'admin_label' => true,
                        'save_always' => true,
                    )
                )
            )
        );
    }
}

/*
	Lookbook Single
*/
if (shortcode_exists('at_swp_lookbook_single')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lookbook_single_map' );
	function ARTEMIS_SWP_lookbook_single_map()
	{
		vc_map(array(
			  "name" => esc_html__("Lookbook Single", "artemis-swp-core"),
			  "base" => "at_swp_lookbook_single",
			  "class" => "",
              'icon'=> VCICONS_URL . 'vc_look_single.png',
			  "category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			  "params" => array(
			  	array(
					"type" => "attach_images",
					"class" => "",
					"heading" => esc_html__("Image", "artemis-swp-core"),
					"param_name" => "image",
					"value" => "",
					"description" => esc_html__("Depending on the layout, image can be used as background. Please provide a good quality image.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Layout Styling", "artemis-swp-core"),
					"param_name" => "layout_style",
					"value" =>  array( 
									"Text Over Image" => "text_over_image",
									"Text Aside" => "text_aside",
									"Text Under Image" => "text_under_image"
								),
					"description" => esc_html__("Choose how your lookbook looks like.", "artemis-swp-core")
				),				
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Lookbook Title", "artemis-swp-core"),
					"param_name" => "title",
					"value" => "",
					"description" => esc_html__("Title for your lookbook. Ex: True Classics", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Lookbook Subtitle", "artemis-swp-core"),
					"param_name" => "subtitle",
					"value" => "",
					"description" => esc_html__("Subtitle for your lookbook. Ex: Accesories", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'layout_style',
							'value' => 'text_over_image'
					)					
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Link Text", "artemis-swp-core"),
					"param_name" => "link_text",
					"value" => "",
					"description" => esc_html__("Link text. Ex: View Collection", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Link URL", "artemis-swp-core"),
					"param_name" => "link_url",
					"value" => "",
					"description" => esc_html__("Link URL. Web address where the link points.", "artemis-swp-core")
				),
				array(
					"type" => "textarea_html",
					"class" => "",
					"heading" => esc_html__("Description", "artemis-swp-core"),
					"param_name" => "content",
					"value" => "",
					"description" => esc_html__("A short description about this look. Can be empty.", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Content Location", "artemis-swp-core"),
					"param_name" => "text_location",
					"value" =>  array( 
									"Content Left" => "left",
									"Content Right" => "right"
								),
					"description" => esc_html__("Choose where to add text content - left or right side of the image.", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'layout_style',
							'value' => 'text_aside'
					)
				),
				array(
					"type" => "checkbox",
					"heading" => esc_html__("Title over image", "artemis-swp-core"),
					"param_name" => "title_over_image",
					"description" => esc_html__("Make title overlap the image.", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'layout_style',
							'value' => 'text_aside'
					)					
				),				
				array(
					"type" => "checkbox",
					"heading" => esc_html__("Full Screen Height", "artemis-swp-core"),
					"param_name" => "full_height",
					"description" => esc_html__("Make this element full screen height.", "artemis-swp-core")
				),
				array(
					"type" => "checkbox",
					"heading" => esc_html__("Custom Element Height", "artemis-swp-core"),
					"param_name" => "custom_height",
					"description" => esc_html__("Add custom height for element.", "artemis-swp-core")
				),	
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Height", "artemis-swp-core"),
					"param_name" => "height",
					"value" => "",
					"description" => esc_html__("Height in pixels. Default value: 500px.", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'custom_height',
							'not_empty' => true
					)
				)
				
			  )
		));
	}
}

/*
	Lookbook container - slider
*/
if (shortcode_exists('lc_lookbook_slider')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_lookbook_slider_map');
	function ARTEMIS_SWP_lc_lookbook_slider_map() {
		vc_map( array(
			"name" => esc_html__("Lookbook Slider", "artemis-swp-core"),
			"base" => "lc_lookbook_slider",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"as_parent" => array('only' => 'at_swp_lookbook_single'), /* Use only|except attributes to limit child shortcodes (separate multiple values with comma)*/
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon'=> VCICONS_URL . 'vc_look_slider.png',
			"js_view" => 'VcColumnView',
			"params"	=> array(
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Navigation Style", "artemis-swp-core"),
					"param_name" => "navigation_style",
					"value" =>  array( 
									"Navigation Text" => "nav_text",
									"Navigation Icon" => "nav_icon"
								),
					"description" => esc_html__("Choose where to add text content - left or right side of the image.", "artemis-swp-core")

				),				
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Next Slide Text", "artemis-swp-core"),
					"param_name" => "text_next",
					"value" => "Next",
					"description" => esc_html__("Text shown on [Next] slide navigation link.", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'navigation_style',
							'value' => 'nav_text'
					)					
				),
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Prevous Slide Text", "artemis-swp-core"),
					"param_name" => "text_prev",
					"value" => "Prev",
					"description" => esc_html__("Text shown on [Prev] slide navigation link", "artemis-swp-core"),
					'dependency'  => array(
							'element' 	=> 'navigation_style',
							'value' => 'nav_text'
					)					
				),					
			)
		));
	}
}

if (shortcode_exists('lc_partner_logo')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_partner_logo_map');
	function ARTEMIS_SWP_lc_partner_logo_map() {
		vc_map( array(
			"name" => esc_html__("Partner Logo", "artemis-swp-core"),
			"base" => "lc_partner_logo",
			'icon'=> VCICONS_URL . 'vc_part_logo.png',
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"params"	=> array(
				array(
					"type" => "attach_image",
					"class" => "",
					"heading" => esc_html__( "Select Image", "artemis-swp-core"),
					"param_name" => "logo_img",
					"value" => "",
					"description" => esc_html__("Select Logo Image", "artemis-swp-core")
				),
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("URL", "artemis-swp-core"),
					"param_name" => "logo_url",
					"value" => "",
					"description" => esc_html__("Select URL (optional).", "artemis-swp-core")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => esc_html__( "Black And White Image", "artemis-swp-core"),
					"param_name" => "black_and_white",
					"value" =>  array( 
									"Yes" => "yes",
									"No - Use Original Image Colors" => "no"
								),
					"description" => esc_html__("Make the logo image black and white.", "artemis-swp-core")

				)				
			)
		));
	}
}

if (shortcode_exists('lc_mailchimp_subscribe')) {
	add_action( 'vc_before_init', 'ARTEMIS_SWP_lc_mailchimp_subscribe_map');
	function ARTEMIS_SWP_lc_mailchimp_subscribe_map() {
		vc_map( array(
			"name" => esc_html__("MailChimp Subscribe Form", "artemis-swp-core"),
			"base" => "lc_mailchimp_subscribe",
			'icon'=> VCICONS_URL . 'vc_mailchimp.png',
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"params"	=> array(
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Api Key", "artemis-swp-core"),
					"param_name" => "api_key",
					"value" => "",
					"description" => esc_html__("Your MailChimp Api Key.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__( "List ID", "artemis-swp-core"),
					"param_name" => "list_id",
					"value" => "",
					"description" => esc_html__("MailChimp List ID.", "artemis-swp-core")
				)
			)
		));
	}
}


if (shortcode_exists('swp_vertical_shop_promo')) {
	add_action('vc_before_init', 'ARTEMIS_SWP_swp_vertical_shop_promo_map');
	function ARTEMIS_SWP_swp_vertical_shop_promo_map() {
		vc_map( array(
			"name" => esc_html__("Vertical Collection Promo", "artemis-swp-core"),
			"base" => "swp_vertical_shop_promo",
			"category" => esc_html__("Artemis Elements", "artemis-swp-core"),
			"content_element" => true,
			"show_settings_on_create" => true,
            'icon'=> VCICONS_URL . 'vc_vertical_promo.png',
			"params"	=> array(
			  	array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Vertical text", "artemis-swp-core"),
					"param_name" => "vertical_promo_txt",
					"value" => "Featured",
					"description" => esc_html__("Vertical text shown on left. Ex: FEATURED", "artemis-swp-core")
				),				
			  	array(
					"type" => "textarea_raw_html",
					"class" => "",
					"heading" => esc_html__("Product category", "artemis-swp-core"),
					"param_name" => "category_name_txt",
					"value" => "",
					"description" => esc_html__("The name of the category that you want to promote Ex: ME&#60;br&#62;NS", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Link text", "artemis-swp-core"),
					"param_name" => "link_txt",
					"value" => "Show All",
					"description" => esc_html__("Text for the link to the products page. Ex: SHOW ALL", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Link URL", "artemis-swp-core"),
					"param_name" => "link_url",
					"value" => "#",
					"description" => esc_html__("URL of the page you want to promote.", "artemis-swp-core")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => esc_html__("Max Height", "artemis-swp-core"),
					"param_name" => "max_height",
					"value" => "400",
					"description" => esc_html__("Max height of the element. Height is automatically computed according to the catalog product image size.", "artemis-swp-core")
				)				
			)
		));		
	}
}

/*
	add new params for visual composer
*/
add_action('vc_before_init', 'ARTEMIS_SWP_add_new_vc_params');
function ARTEMIS_SWP_add_new_vc_params() {
	vc_add_shortcode_param('artemis_product_cat', 'ARTEMIS_SWP_vc_param_product_cat');
}

/*
	Product Category Param
*/
function ARTEMIS_SWP_vc_param_product_cat($settings, $value) {
	$args = array(
		'taxonomy'           => 'product_cat',
		'show_option_all'    => '',
		'class'              => 'wpb_vc_param_value',
		'name'               => $settings['param_name'],
		'selected'           => $value
	);

	ob_start();
	wp_dropdown_categories($args);
	$output = ob_get_clean();
	return $output;
}
