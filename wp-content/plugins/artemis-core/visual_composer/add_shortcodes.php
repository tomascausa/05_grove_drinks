<?php
/*
	Gallery - ok
*/
add_shortcode('js_swp_gallery', 'ARTEMIS_SWP_js_gallery');
function ARTEMIS_SWP_js_gallery($atts) {
	$defaults = array(
	  /*'title' => 'Featured Images',*/
	  'rowheight' => '',
	  'viewallmessage' => '',
	  'photosurl' => '',
	  'images' => ''
	);
	extract(shortcode_atts($defaults, $atts));

	/*$output = '<h2 class="short_title">'.$title.'</h2>';*/
	if ('' == $images){
		return $output;
	}
	
	if ( empty($rowheight) || !is_numeric($rowheight)) {
		$rowheight = 180;
	}
	if ( empty($viewallmessage)) {
		$viewallmessage = "View All Images";
	}
	$output = '<div class="lc_swp_justified_gallery" data-rheight="'.$rowheight.'">';
	
	$photoAlbumUnique = "photoAlbum".rand();
	$images = explode( ',', $images );
	foreach($images as $imageId) {
	
		$singleImgTag = wp_get_attachment_image( $imageId, 'full' );
		$imageAttributes = wp_get_attachment_image_src($imageId, "medium");
		
		$output .= '<div class="img_box">';
		$output .= '<div class="gallery_brick_overlay"></div>';
		$output .= '<a href="'.wp_get_attachment_url($imageId).'" data-lightbox="'.$photoAlbumUnique.'" data-imgid="' . $imageId . '">';
		$output .= $singleImgTag;
		$output .= '</a></div>';
	}
	$output .= "</div>";
	
	if( !empty($photosurl) ){
	$output .= '<div class="lc_view_more view_more_justified_gallery lc_swp_boxed"><a href="'.$photosurl.'">'.$viewallmessage.'</a></div>';
    }
	return $output;
}



/*
	Social Profiles
*/
add_shortcode('js_swp_social_profiles_icons', 'ARTEMIS_SWP_social_profiles_icons');
function ARTEMIS_SWP_social_profiles_icons($atts) {
	$defaults = array(
		'title' => '', 
		'center_icons' => 'text_center'
	);
	extract(shortcode_atts($defaults, $atts));	
	
	ob_start();
	
	if (!empty($title)) {
		echo '<h2 class="short_title">'.$title.'</h2>';		
	}
	
	$centeringClass = "text_center";
	switch ($center_icons) {
		case "text_left":
			$centeringClass = "text_left";
			break;
		case "text_right":
			$centeringClass = "text_right";
			break;
	}
	
	echo '<div class="social_profiles_contact js_vc_social_profiles '.$centeringClass.'">';
	if (function_exists('ARTEMIS_SWP_front_page_social_profiles')) {
		ARTEMIS_SWP_front_page_social_profiles();
	}
	echo '</div>';
	
	$output = ob_get_clean();
	
	return $output;
}

/*
	Contact Form - ok
*/
add_shortcode('js_swp_ajax_contact_form', 'ARTEMIS_SWP_js_swp_ajax_contact_form');
function ARTEMIS_SWP_js_swp_ajax_contact_form($atts) {
	$defaults = array(
		'input_styling' => ''
	);
	extract(shortcode_atts($defaults, $atts));
	
	$additional_input_class = "three_on_row" == $input_styling ? " three_on_row three_on_row_layout" : "";
	
	ob_start();
	?>
	<div class="lc_swp_boxed">
		<div class="artemis_contactform vc_lc_contactform">
			<form class="artemis_contactform">						
				<ul class="contactform_fields">

					<li class="comment-form-author vc_lc_element artemis_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Name ', 'artemis-swp-core'); ?>" name="contactName" id="contactName" class="artemis_cf_input required requiredField contactNameInput" />
						<div class="artemis_cf_error"><?php echo esc_html__('Please enter your name', 'artemis-swp-core'); ?></div>
					</li>

					<li class="comment-form-email vc_lc_element artemis_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Email ', 'artemis-swp-core'); ?>" name="email" id="contactemail" class="artemis_cf_input required requiredField email" />
						<div class="artemis_cf_error"><?php echo esc_html__('Please enter a correct email address', 'artemis-swp-core'); ?></div>
					</li>

					<li class="comment-form-url vc_lc_element artemis_cf_entry<?php echo esc_attr($additional_input_class); ?>">
						<input type="text" placeholder="<?php echo esc_html__('Phone ', 'artemis-swp-core'); ?>" name="phone" id="phone" class="artemis_cf_input" />
					</li>

					<li class="comment-form-comment vc_lc_element artemis_cf_entry">
						<textarea name="comments" placeholder="<?php echo esc_html__('Message ', 'artemis-swp-core'); ?>" id="commentsText" rows="10" cols="30" class="artemis_cf_input required requiredField contactMessageInput"></textarea>
						<div class="artemis_cf_error"><?php echo esc_html__('Please enter a message', 'artemis-swp-core'); ?></div>
					</li>
					<?php
					/*
					//TODO: add recaptcha error here
					<li class="captcha_error">
						<span class="error"><?php echo esc_html__('Incorrect reCaptcha. Please enter reCaptcha challenge;', 'artemis-swp-core'); ?></span>
					</li>
					*/
					?>
					<li class="wp_mail_error">
						<div class="artemis_cf_error"><?php echo esc_html__('Cannot send mail, an error occurred while delivering this message. Please try again later.', 'artemis-swp-core'); ?></div>
					</li>	

					<li class="formResultOK">
						<div class="artemis_cf_error"><?php echo esc_html__('Your message was sent successfully. Thanks!', 'artemis-swp-core'); ?></div>
					</li>
					<?php /*TODO: add recaptcha */?>
					<li>
						<input name="Button1" type="submit" id="submit" class="lc_button" value="<?php echo esc_html__('Send', 'artemis-swp-core'); ?>" >
						<?php /*<div class="progressAction"><img src="<?php echo get_template_directory_uri()."/images/progress.gif"; ?>"></div> */ ?>
					</li>

				</ul>
				<input type="hidden" name="action" value="artemiscontactform_action" />
				<?php wp_nonce_field('artemiscontactform_action', 'contactform_nonce'); /*wp_nonce_field('artemiscontactform_action', 'contactform_nonce', true, false); */?>
			</form>
		</div>
	</div>
	<?php
	$output = ob_get_clean();
	
	return $output;
}

/*
	Section Heading - ok
*/
add_shortcode('js_swp_row_heading', 'ARTEMIS_SWP_js_swp_row_heading');
function ARTEMIS_SWP_js_swp_row_heading($atts) {
	$defaults = array(
		'title' 				=> "Section title",
		'title_transform'		=> "",
		'subtitle'				=>	"",
		'subtitle_transform'	=>	"",
		'text_align'			=> "text_center",
		'heading_order'			=> "subtitle_under_title"
	);
	extract(shortcode_atts($defaults, $atts));
	
	$title = urldecode(base64_decode($title));
	$subtitle = urldecode(base64_decode($subtitle));

	$allowed_html = array(
			'span'	=> array(
					'class'	=> array()
				)
		);

	ob_start();
	?>

	<div class="lc_vc_section_title <?php echo esc_attr($text_align); ?>">
		<?php if ("subtitle_under_title" == $heading_order) { ?>
			<h2 class="section_title<?php echo " ".esc_attr($title_transform); ?>"><?php echo wp_kses($title, $allowed_html); ?></h2>
		<?php } ?>
		<h4 class="section_subtitle<?php echo " ".esc_attr($subtitle_transform); ?>"><?php echo wp_kses($subtitle, $allowed_html); ?></h4>
		<?php if ("subtitle_above_title" == $heading_order) { ?>
			<h2 class="section_title<?php echo " ".esc_attr($title_transform); ?>"><?php echo wp_kses($title, $allowed_html); ?></h2>
		<?php } ?>		
	</div>
	
	<?php	
	
	$output = ob_get_clean();
	
	return $output;
}


/*
	Reverse Letter With Text
*/
add_shortcode('at_swp_reverse_letter_with_text', 'ARTEMIS_SWP_reverse_letter_with_text');
function ARTEMIS_SWP_reverse_letter_with_text($atts) {
	$defaults = array(
		'letter'		=> "",
		'heading' 		=> "",
		'text_content'		=> ""
	);
	extract(shortcode_atts($defaults, $atts));

	$heading = urldecode(base64_decode($heading));
 	$text_content = urldecode(base64_decode($text_content));

 	if (strlen(trim($letter))) {
 		/*make sure you get only one letter*/
 		$letter = substr($letter, 0, 1);
 	} 	

 	$allowed_html = array (
 			'span'	=> array(
 					'class'	=> array()
 			),
 			'br'	=> array(),
 			'strong'=> array(),
 			'i'		=> array(
 					'class'	=> array()
 			)
 	);

 	ob_start();
?>
	<div class="reverse_letter_with_text">
		<div class="rev_rotate_letter">
			<?php echo esc_html($letter); ?>
		</div>
		<div class="reverse_letter_with_text_content">
			<h4> <?php echo wp_kses($heading, $allowed_html); ?> </h4>
			<?php echo wp_kses($text_content, $allowed_html); ?>
		</div>
	</div>
<?php
	$output = ob_get_clean();
 	return $output; 	
}

/*
	Heading with letter
*/
add_shortcode('at_swp_heading_with_letter', 'ARTEMIS_SWP_heading_with_letter');
function ARTEMIS_SWP_heading_with_letter($atts) {
	$defaults = array(
		'small_heading' 		=> "",
		'big_heading'			=> "",
		'letter'				=> "",
		"align"					=> "block_left"
	);
	extract(shortcode_atts($defaults, $atts));

 	$small_heading = urldecode(base64_decode($small_heading));
 	$big_heading = urldecode(base64_decode($big_heading));
 	if (strlen(trim($letter))) {
 		/*make sure you get only one letter*/
 		$letter = substr($letter, 0, 1);
 	}

 	$allowed_html = array(
 			'span'	=> array(
 					'class'	=> array()
 			),
 			'br'	=> array(),
 			'strong'=> array()
 	);

 	ob_start();
 ?>
 	<div class="at_heading_with_letter <?php echo esc_attr($align); ?>">
 		<div class="at_heading_with_letter_inner <?php echo esc_attr($align); ?>">
	 		<div class="titles_after_letter">
		 		<h3 class="small_title"><?php echo wp_kses($small_heading, $allowed_html); ?></h3>
		 		<h4 class="big_title"><?php echo wp_kses($big_heading, $allowed_html); ?></h4>
	 		</div>
	 		<div class="transparent_letter"><?php echo esc_html($letter); ?></div>
 		</div>
 	</div>

 <?php
 	$output = ob_get_clean();

 	return $output;
}

/*
	Standard Heading
*/
add_shortcode('at_swp_standard_heading', 'ARTEMIS_SWP_standard_heading_scd');
function ARTEMIS_SWP_standard_heading_scd($atts) {
	$defaults = array(
		'heading_type'		=> "2",
		'text'				=> "",
		'text_transform'	=> "no_transform",
		"text_center"		=> "text_left",
		"font_size"			=> "",
		"letter_spacing"	=> "",
		"font_weight"    => "default",
		"responsiveness"    => "{}"
	);
	extract(shortcode_atts($defaults, $atts));

	$font_size = str_replace("px", "", $font_size);
	if (!is_numeric($font_size)) {
		$font_size = "";
	}

	$letter_spacing = str_replace("px", "", $letter_spacing);
	if (!is_numeric($letter_spacing)) {
		$letter_spacing = "";
	}

	if ("default" == $font_weight) {
		$font_weight = "";
	}

	$js_css_class = "";
	if (strlen(trim($font_size)) || 
		strlen(trim($letter_spacing)) || 
		strlen(trim($font_weight))) {
		$js_css_class = " at_swp_js_css";
	}

    $responsiveness = ARTEMIS_SWP_map_responsive_font($responsiveness, $font_size, $letter_spacing);
	ob_start();
?>
	<h<?php echo esc_html($heading_type); ?>
            class="<?php echo esc_attr($text_transform).' '.esc_attr($text_center).esc_attr($js_css_class); ?>"
            data-atfs="<?php echo esc_attr($font_size); ?>"
            data-atresponsive="<?php echo esc_attr($responsiveness) ?>"
            data-atls="<?php echo esc_attr($letter_spacing); ?>"
            data-atfw="<?php echo esc_attr($font_weight); ?>">
		<?php echo esc_html($text); ?>
	</h<?php echo esc_html($heading_type); ?> >
<?php
	$output = ob_get_clean();
	return $output;
}

add_shortcode('at_swp_custom_link', 'ARTEMIS_SWP_custom_link_scd');
function ARTEMIS_SWP_custom_link_scd($atts) {
	$defaults = array(
		'text'				=> "",
		'url'				=> "",
		'text_transform'	=> "no_transform",
		"text_center"		=> "text_left",
		"font_size"			=> "",
		"letter_spacing"	=> "",
		"font_weight"		=> "default",
		"visual_effect"		=> "",	/*no effect / line before*/
		"text_color"     	=> "default" ,   /*default / vibrant color / lc_custom_color*/
		"custom_color" 			=> "",	/*only for text_color = lc_custom_color*/
		"custom_hover_color"	=> "", /*only for text_color = lc_custom_color*/
		"responsiveness"     => "{}"
	);

	extract(shortcode_atts($defaults, $atts));

	$font_size = str_replace("px", "", $font_size);
	if (!is_numeric($font_size)) {
		$font_size = "";
	}

	$letter_spacing = str_replace("px", "", $letter_spacing);
	if (!is_numeric($letter_spacing)) {
		$letter_spacing = "";
	}

	if ("default" == $font_weight) {
		$font_weight = "";
	}

	$js_css_class = "";
	if (strlen(trim($font_size)) || 
		strlen(trim($letter_spacing)) || 
		strlen(trim($font_weight))) {
		$js_css_class = " at_swp_js_css";
	}

	if ("line_before" == $visual_effect) {
		$js_css_class .= " at_link_line_before";
	}
	if ("default" != $text_color) {
		$js_css_class .= " lc_vibrant_color";
	}
	$responsiveness = ARTEMIS_SWP_map_responsive_font($responsiveness, $font_size, $letter_spacing);

	/*custom color*/
	$cust_color_class = "lc_custom_color" == $text_color ? "use_custom_link_color" : "" ;

	ob_start();
?>

	<div class="at_custom_link <?php echo esc_attr($text_transform). ' '.esc_attr($text_center). ' ' .esc_attr($cust_color_class); ?>" >
		<a href="<?php echo esc_url($url); ?>"
           class="<?php echo esc_attr($text_center).esc_attr($js_css_class); ?>"
           data-atfs="<?php echo esc_attr($font_size); ?>"
           data-atls="<?php echo esc_attr($letter_spacing); ?>"
           data-responsive="<?php echo esc_attr($responsiveness) ?>"
           data-atfw="<?php echo esc_attr($font_weight); ?>"
           data-custcol="<?php echo esc_attr($custom_color); ?>"
           data-custhcol="<?php echo esc_attr($custom_hover_color); ?>">
			<?php echo esc_html($text); ?>
		</a>
	</div>

<?php

	$output = ob_get_clean();
	return $output;
}

/*
	Artemis Button - ok
*/
add_shortcode('js_swp_theme_button', 'ARTEMIS_SWP_js_swp_theme_button');
function ARTEMIS_SWP_js_swp_theme_button($atts) {
	$defaults = array(
		'button_text' 				=> 'button text',
		'button_url' 				=> '',
		'button_align' 				=> 'left',
		'button_corners'			=> 'default',
		'button_bg_color'			=> 'default',
		'button_bg_hover_color'		=> 'default',
		'button_text_color'			=> 'default',
		'button_text_hover_color'	=> 'default',
		'button_border_color'		=> 'default',
		'button_border_hover_color'	=> 'default',
		'button_letter_spacing'		=> 'default',
		'button_direction'			=> 'default',
		'button_cust_hpadding'		=> 'default',
	);
	extract(shortcode_atts($defaults, $atts));

	$centeringClass = "button_left";
	$hasClearfix = 0;
	switch ($button_align) {
		case "button_center":
			$centeringClass = "button_center";
			break;
		case "button_right":
			$centeringClass = "button_right";
			$hasClearfix = 1;
			break;
		default: 
			$centeringClass = "button_left";
			$hasClearfix = 1;
			break;		
	}
	
	$corners_class = "";
	if ("rounded_corners" == $button_corners) {
		$corners_class = " rounded_corners";
	}

	if (!strlen($button_cust_hpadding)) {
		$button_cust_hpadding = "default";
	}	

	$button_letter_spacing = "default" != $button_letter_spacing ? intval($button_letter_spacing) : $button_letter_spacing;
	$button_cust_hpadding = "default" != $button_cust_hpadding ? intval($button_cust_hpadding) : $button_cust_hpadding;

	/*if any is set, add the custom css class*/
	$custom_styling_class = "";
	if (("default" != $button_bg_color) ||
		("default" != $button_bg_hover_color) ||
		("default" != $button_text_color) ||
		("default" != $button_text_hover_color) ||
		("default" != $button_border_color) ||
		("default" != $button_border_hover_color) ||
		("default" != $button_letter_spacing) ||
		("default" != $button_direction) || 
		("default != $button_cust_hpadding")) {
		$custom_styling_class = " lc_custom_button_style";
	}
	
	ob_start();
?>
	<div class="lc_button <?php echo esc_attr($centeringClass).esc_attr($corners_class).esc_attr($custom_styling_class); ?>" data-bbgc="<?php echo esc_attr($button_bg_color); ?>" data-bbgch="<?php echo esc_attr($button_bg_hover_color); ?>" data-btc="<?php echo esc_attr($button_text_color); ?>" data-btch="<?php echo esc_attr($button_text_hover_color); ?>" data-borderc="<?php echo esc_attr($button_border_color); ?>" data-borderhc="<?php echo esc_attr($button_border_hover_color); ?>" data-lsp="<?php echo esc_attr($button_letter_spacing); ?>" data-btndirection="<?php echo esc_attr($button_direction); ?>" data-custhpadding="<?php echo esc_attr($button_cust_hpadding); ?>">
		<a href="<?php echo esc_url($button_url); ?>" >
			<?php echo esc_html($button_text); ?>
		</a>
	</div>

	<?php if ($hasClearfix) { ?>
		<div class="clearfix"></div>
	<?php } ?>
<?php
	$output = ob_get_clean();
	return $output;
}

/*
	User Review - ok
*/
add_shortcode('lc_swp_user_review', 'ARTEMIS_SWP_lc_swp_user_review_scode');
function ARTEMIS_SWP_lc_swp_user_review_scode($atts) {
	$defaults = array(
		'reviewer_name' 	=> '',
		'reviewer_image'	=> '',
		'review_content' => ''
	);
	extract(shortcode_atts($defaults, $atts));
	
	$review_content = urldecode(base64_decode($review_content));
	$allowed_html = array(
	 			'span'	=> array(
	 					'class'	=> array()
	 			),
	 			'br'	=> array(),
	 			'strong'=> array(),
	 			'i'		=> array()
	 		);

	ob_start();
?>
	<li>
		<div class="lc_swp_boxed text_center">
			<?php if ("" != trim($reviewer_image)) { ?> 
				<div class="lc_reviewer_image"> 
					<?php echo wp_get_attachment_image($reviewer_image, "full"); ?> 
                    <span class="lc_reviews_slider_arrow"></span>
				</div> 
			<?php } ?>
			
			<div class="lc_review_content">
				<?php echo wp_kses($review_content, $allowed_html); ?>
			</div>
			<h5 class="lc_reviewer_name"><?php echo esc_html($reviewer_name); ?></h5>
		</div>
	</li>
<?php	
	$output = ob_get_clean();
	return $output;
}

/*
	User Review Container - ok
*/
add_shortcode('lc_review_slider', 'ARTEMIS_SWP_lc_review_slider');
function ARTEMIS_SWP_lc_review_slider($atts, $content = "")
{
    $defaults = array(
        'style'           => 'slider',
        'top_bg_color'    => '',
        'bottom_bg_color' => '',
        'arrows'		  => 'visible', /*visible/hidden*/
        'font_style'	  => 'big_font' /*big_font (default)/small_font*/,
		'image_border'		=> 'rounded',
		'image_size'		=> 'theme_default'	/*theme_default/original*/        
    );
    /**
     * @var string $style
     * @var string $top_bg_color
     * @var string $bottom_bg_color
     */
    extract( shortcode_atts( $defaults, $atts ) );

    $top_class = '';
    $bottom_class = '';
    $container_class = '';
    if ( 'two_rows' == $style ) {
        $top_class = 'lc_reviews_slider_top_row clearfix';
        $container_class .= ' lc_slider_two_rows';
        if ( $top_bg_color ) {
            $top_class .= ' lc_swp_bg_color';
        }
        if ( $bottom_bg_color ) {
            $bottom_class .= ' lc_swp_bg_color clearfix';
            $container_class .= ' lc_swp_bg_color';
        }
    }

    $arrows_visible_class = '';
    if (("visible" != $arrows) && ("slider" == $style)) {
    	$arrows_visible_class .= ' rev_slider_hide_arrows';
    }
    if (("small_font" == $font_style) && ("slider" == $style)) {
    	$container_class .= ' font_style_small';
    }
    if ("rounded" != $image_border) {
    	$container_class .=	' img_border_default';
    }
    if ("theme_default" != $image_size) {
    	$container_class .=	' img_size_default';
    }

	ob_start();
?>
	<div class="lc_reviews_slider_container<?php echo esc_attr($arrows_visible_class); ?>">
		<div class="lc_reviews_slider <?php echo esc_attr($container_class) ?>" data-color="<?php echo esc_attr($bottom_bg_color) ; ?>" >
            <?php
            if( 'two_rows' == $style ) {?>
                <div class="<?php echo esc_attr( $top_class) ?>" data-color="<?php echo esc_attr($top_bg_color); ?>" >
                    <div class="lc_reviews_slider_inner clearfix"></div>
                </div>
            <?php } ?>
			<ul class="<?php echo esc_attr($bottom_class)?>">
			<?php echo do_shortcode($content); ?>
			</ul>
		</div>	
	</div>
<?php	
	$output = ob_get_clean();
	return $output;
}


/*
	Product Attributes Showcase
*/
add_shortcode('lc_prod_attributes_showcase', 'ARTEMIS_SWP_lc_prod_attributes_showcase');
function ARTEMIS_SWP_lc_prod_attributes_showcase($atts, $content = "") {
	$defaults = array(
		'align_elt' 	=> 'float_left'
	);
	extract(shortcode_atts($defaults, $atts));

	ob_start();

?>
	<div class="lc_prod_attr_showcase clearfix">
		<div class="lc_prod_attr_showcase_inner <?php echo esc_attr($align_elt); ?>">
			<?php echo do_shortcode($content); ?>
		</div>	
	</div>
<?php

	$output = ob_get_clean();
	return $output;
}


/*
	Single Attribute - Product Attributes Showcase
*/
add_shortcode('lc_prod_attribute', 'ARTEMIS_SWP_lc_prod_attribute');
function ARTEMIS_SWP_lc_prod_attribute($atts) {
	$defaults = array(
		'attr_img' 	=> '',
		'attr_txt'			=> '',
		'product_img' => ''
	);
	extract(shortcode_atts($defaults, $atts));

	$unique_id = "at_" . uniqid ();

	ob_start();
?>
	<div class="left_side prod_show_attr" data-prodimg="<?php echo esc_html($unique_id); ?>">
		<div class="attr_img">
			<?php 
			if ("" != $attr_img) {
				echo wp_get_attachment_image($attr_img, "full");
			}
			?>
		</div>

		<div class="attr_txt">
			<?php echo esc_html($attr_txt); ?>
		</div>
	</div>

	<div class="right_side attr_show_prod_img" id="<?php echo esc_html($unique_id); ?>">
		<?php 
			if ("" != trim($product_img)) {
				 echo wp_get_attachment_image($product_img, "full");
			}
		?>
	</div>
<?php

	$output = ob_get_clean();
	return $output;
}

/*
	Video Section
*/
	/*
	video title
	background image
	overlay
	video source (youtube/vimeo)
	video height (calculate video width based on height?)
	*/
add_shortcode('at_swp_video_shortcode', 'ARTEMIS_SWP_at_swp_video_shortcode');
function ARTEMIS_SWP_at_swp_video_shortcode($atts) {
	$defaults = array(
		'video_title' 		=> '',
		'bg_img' 			=> '',
		'color_overlay'		=> '',
		'video_url'			=> '',
		'section_height'	=> '700'
	);
	extract(shortcode_atts($defaults, $atts));

	$section_height = str_replace("px", "", $section_height);
	if (!is_numeric($section_height)) {
		$section_height = "700";
	}

	$add_class = "at_swp_js_css";
	$bg_img = trim($bg_img);
	if (!empty($bg_img)) {
		$add_class .= " lc_swp_background_image";
	}

	$video_source = "none";
	$video_id = "none";
	if (strpos($video_url, "youtube") || strpos($video_url, "youtu.be")) {
		$video_source = "youtube";

		/*
			Supports: 
			https://youtu.be/5_IHHExhsKo
			https://www.youtube.com/watch?v=5_IHHExhsKo
		*/
		$pattern = 
	        '%^# Match any youtube URL
	        (?:https?://)?  # Optional scheme. Either http or https
	        (?:www\.)?      # Optional www subdomain
	        (?:             # Group host alternatives
	          youtu\.be/    # Either youtu.be,
	        | youtube\.com  # or youtube.com
	          (?:           # Group path alternatives
	            /embed/     # Either /embed/
	          | /v/         # or /v/
	          | /watch\?v=  # or /watch\?v=
	          )             # End path alternatives.
	        )               # End host alternatives.
	        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
	        $%x';
		$does_it_match = preg_match($pattern, $video_url, $matches);
		$video_id = $does_it_match ? $matches[1] : "";

	} elseif (strpos($video_url, "vimeo")) {
		$video_source = "vimeo";

		/*https://vimeo.com/205903497*/
		$pattern = '#https?://vimeo.com/([0-9]+)#i';
		$does_it_match = preg_match($pattern, $video_url, $matches);
		$video_id = $does_it_match ? $matches[1] : "";
	}
	
	ob_start();
?>
	<div class="at_video_section <?php echo esc_attr($add_class); ?>" data-bgimage="<?php echo esc_attr(wp_get_attachment_url($bg_img)); ?>" data-height="<?php echo esc_attr($section_height); ?>" data-vsource ="<?php echo esc_attr($video_source); ?>" data-vid="<?php echo esc_attr($video_id); ?>">
		<div class="lc_swp_overlay" data-color="<?php echo esc_attr($color_overlay); ?>"></div>
		<div class="at_video_section_play"><i class="fa fa-play" aria-hidden="true"></i></div>
		<h3 class="at_video_title"><?php echo esc_html($video_title); ?> </h3>
	</div>
<?php
	$output = ob_get_clean();
	return $output;
}

/*
	Blog Shortcode
*/
add_shortcode('js_swp_blog_shortcode', 'ARTEMIS_SWP_js_swp_blog_shortcode');
function ARTEMIS_SWP_js_swp_blog_shortcode($atts) {
	$defaults = array(
		'postsnumber' => '3'
	);
	extract(shortcode_atts($defaults, $atts));

	$args = array(
		'numberposts'	=> $postsnumber,
		'posts_per_page'   => $postsnumber,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => true
	); 	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	
	/*generic values for view*/

	$container_class = 'vc_at_blog lc_blog_masonry_container blog_container lc_swp_boxed';
	$gap_width = 30;
	$bricks_on_row = 3;

	ob_start();
	if ($wp_query->have_posts()) {
		?>
		<div class="<?php echo esc_attr($container_class); ?>" data-gapwidth="<?php echo esc_attr($gap_width); ?>" data-bricksonrow="<?php echo esc_attr($bricks_on_row); ?>">

				<?php
				while ($wp_query->have_posts()) {
					$wp_query->the_post();
					
					$centering_css_class = 'text_left';
					$item_details_class = 'post_item_details';
					$thumbnail_class = 'has_thumbnail';
					if (!has_post_thumbnail()) {
						$thumbnail_class = 'no_thumbnail ';
						$item_details_class .= ' featured_image_container';
					}
					$post_classes = 'at_related_posts post_item lc_blog_masonry_brick ' . $thumbnail_class;
					?>

					<article <?php post_class($post_classes);?>>
						<a href="<?php the_permalink(); ?>">

						<?php if (has_post_thumbnail(get_the_ID())) {
							$post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
							$image_attributes = wp_get_attachment_image_src($post_thumbnail_id, 'full');
							?>
							<div class="featured_image_container_parent">
								<div class="featured_image_container has_image lc_swp_background_image transition4" data-bgimage="<?php echo esc_attr($image_attributes[0]); ?>">
								</div>
							</div>
							<?php
						}
						?>


						<div class="<?php echo esc_attr($item_details_class) . ' ' . esc_attr($thumbnail_class)." ".esc_attr($centering_css_class); ?>">
							<div class="related_details">
								<div class="post_item_meta lc_post_meta masonry_post_meta">
									<?php 
										echo get_the_date(get_option('date_format'));
									?>

									<?php 
										echo esc_html__('&#32;&#124; by', 'artemis-swp'); 
										?>
										<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
											<?php the_author(); ?>
										</a>
								</div>

								<a href="<?php the_permalink(); ?>">
									<h2 class="lc_post_title transition4 masonry_post_title">
										<?php the_title(); ?>
									</h2>
								</a>
							</div>
						</div>
						</a>
					</article>

				<?php
			} /*if*/
			?>
		</div>
		<?php
	} /*while*/

	$output = ob_get_clean();
	
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();		

	return $output;
}

/*
	WooCommerce Best Products Slider
*/
add_shortcode('at_swp_woo_best_prod_slider', 'ARTEMIS_SWP_woo_best_prod_slider');
function ARTEMIS_SWP_woo_best_prod_slider($atts) {
	$defaults = array(
		'products_to_show'			=> '5',
		'text_next'					=> 'next',
		'text_prev'					=> 'prev',
		'button_corners'			=> 'default',
		'button_bg_color'			=> 'default',
		'button_bg_hover_color'		=> 'default',
		'button_text_color'			=> 'default',
		'button_text_hover_color'	=> 'default'
	);
	extract(shortcode_atts($defaults, $atts));
	
	if (!class_exists('woocommerce')) {
		return "";
	}

	$query_args = array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $products_to_show,
		'meta_key'            => 'total_sales',
		'orderby'             => 'meta_value_num',
		'meta_query'          => WC()->query->get_meta_query()
	);

	$products = new WP_Query($query_args);

	/*if any is set, add the custom css class*/
	$custom_styling_class = "";
	if (("default" != $button_bg_color) ||
		("default" != $button_bg_hover_color) ||
		("default" != $button_text_color) ||
		("default" != $button_text_hover_color)) {
		$custom_styling_class = " lc_custom_button_style";
	}

	$corners_class = "";
	if ("rounded_corners" == $button_corners) {
		$corners_class = " rounded_corners";
	}	

	ob_start();

	if ($products->have_posts()) { ?>
		<div class="at_prod_slider_container">
			<div class="at_produts_slider_inner" data-nextslide="<?php echo esc_attr($text_next); ?>" data-prevslide="<?php echo esc_attr($text_prev); ?>">
				<div class="best_products_shadow"><?php echo esc_html__("Best products", "artemis-swp"); ?></div>
				<ul class="at_produts_slider at_best_products">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<li>
						<?php 
						$postID = get_the_ID();

						$prod_title = get_the_title();
                        $product          = wc_get_product($postID);
                        $price            = $product->get_price_html();
						$product_cat_name = "";

						$terms = get_the_terms( $postID, 'product_cat' );
				        if($terms){
				        foreach ($terms  as $term  ) {
				            $product_cat_name = $term->name;
				            break;
				        }
				        }?>

						<div class="prod_img_container lc_swp_boxed">
							<?php
								if (has_post_thumbnail() ) { 
								?> <a href="<?php the_permalink(); ?>"> <?php	
									the_post_thumbnail("shop_single");
								?> </a> <?php	
								} 
							?>
						</div>

						<div class="prod_details_cotainer lc_swp_boxed clearfix">
							<div class="prod_details_left text_right">
								<div class="prod_details_name">
									<?php echo esc_html($prod_title); ?>
								</div>

								<?php if (!empty($product_cat_name)) { ?>
								<div class="prod_details_cat">
									<?php echo esc_html($product_cat_name); ?>
								</div>
								<?php } ?>
							</div>

							<div class="prod_details_right short_desc text_left">
								<?php echo apply_filters( 'woocommerce_short_description', get_the_excerpt()); ?>
							</div>
						</div>

						<div class="prod_slider_atc">
							<div class="lc_button <?php echo esc_attr($custom_styling_class).' '.esc_attr($corners_class); ?>" data-bbgc="<?php echo esc_attr($button_bg_color); ?>" data-bbgch="<?php echo esc_attr($button_bg_hover_color); ?>" data-btc="<?php echo esc_attr($button_text_color); ?>" data-btch="<?php echo esc_attr($button_text_hover_color); ?>">
								<a rel="nofollow" href="<?php echo esc_attr($product->add_to_cart_url()); ?>" data-quantity="1" data-product_id="<?php echo esc_attr($postID); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" class="button has_icon">
									<span class="lnr lnr-lock"></span>
									<?php echo wp_kses_post($price); ?>
								</a>
								
							</div>
						</div>

					</li>
				<?php endwhile; // end of the loop. ?>	

				</ul>
			</div>
		</div>
	<?php 
	}

	$output = ob_get_clean();
	return $output;
}
/**
 * Artemis SWP Icon box -
 */
add_shortcode( 'at_swp_icon_box', 'ARTEMIS_SWP_icon_box' );
function ARTEMIS_SWP_icon_box( $atts, $content ) {
	/**
	 * @var string $title
	 * @var string $add_icon
	 * @var string $icon_pos
	 * @var string $icon_bg_color
	 * @var string $icon_color
	 * @var string $icon_hover_color
	 * @var string $css
	 * @var string $url
	 * @var string $type
	 * @var string $hover_color
	 * @var string $hover_bg_color
	 * @var string $el_class
	 * @var string $content
	 */

	$defaults = array(
		'title'            => '',
		'add_icon'         => '',
		'icon_pos'         => 'top',
		'icon_bg_color'    => '',
		'icon_color'       => '',
        'icon_fontawesome' => '',
        'icon_openiconic'  => '',
        'icon_typicons'    => '',
        'icon_entypo'      => '',
        'icon_linecons'    => '',
		'icon_hover_color' => '',
		'css'              => '',
		'url'              => '',
		'type'             => 'fontawesome',
		'hover_color'      => '',
		'hover_bg_color'   => '',
		'el_class'         => ''
	);

	extract( shortcode_atts( $defaults, $atts ) );

	$link = $target = '';
	if ( $url ) {
		$vc_link = vc_build_link( $url );
		if ( strlen( $vc_link['target'] ) ) {
			$target = ' target="' . esc_attr( $vc_link['target'] ) . '"';
		}
		if ( strlen( $vc_link['title'] ) ) {
			$target = ' title="' . esc_attr( $vc_link['title'] ) . '"';
		}
		$link = '<a href="' . esc_attr( $vc_link['url'] ) . '" ' . $target . '>';
	}

	$icon_html = '';
	if ( 'true' === $add_icon ) {
	    $type = $type ? $type : 'fontawesome';
		vc_icon_element_fonts_enqueue( $type );
		$icon_wrapper = false;
		if ( isset( ${'icon_' . $type} ) ) {
			if ( 'pixelicons' === $type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${'icon_' . $type};
		} else {
			$icon_class = 'fa fa-adjust';
		}

		if ( $icon_wrapper ) {
			$icon_html = '<i class="at_swp_icon_box-icon">' .
			             '<span class="at_swp_icon-box-icon-inner ' . esc_attr( $icon_class ) . '"></span>' .
			             '</i>';
		} else {
			$icon_html = '<i class="at_swp_icon-box-icon ' . esc_attr( $icon_class ) . '"></i>';
		}
	}

	require_once  'css_manager.php';
	$css_manager = new Artemis_Swp_Css_Manager();

	$unique_id = uniqid( 'at_swp-icon-box-' );

	if ( $icon_bg_color && $icon_pos == 'top' ) {
		$css_manager->addMultiple( '#' . $unique_id . " .at_swp_icon-box-icon", array(
			'background-color'      => $icon_bg_color,
			'height'                => '80px',
			'width'                 => '80px',
			'line-height'           => '80px',
			'font-size'             => '32px',
			'-webkit-border-radius' => '50%',
			'-moz-border-radius'    => '50%',
			'-ms-border-radius'     => '50%',
			'border-radius'         => '50%',
		) );
	}
	if ( $icon_color ) {
		$css_manager->addRule( '#' . $unique_id . " .at_swp_icon-box-icon", 'color', $icon_color );
	}

	if ( $icon_hover_color ) {
		$css_manager->addRule( '#' . $unique_id . ":hover .at_swp_icon-box-icon", 'color', $icon_hover_color );
	}

	if ( $hover_color ) {
		$css_manager->addRule( '#' . $unique_id . ":hover .at_swp-icon-box-content-wrapper", 'color', $hover_color );
	}
	if ( $hover_bg_color ) {
		$css_manager->addRule( '#' . $unique_id . ':hover', 'background-color', $hover_bg_color );
	}


	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),'at_swp_icon_box', $atts );

	$style = $css_manager->getCss();
	ob_start();
	if ( $style ) {
		 echo '<style type="text/css">' .$style . '</style>';
	}
?>
	<div id="<?php echo esc_attr($unique_id); ?>" class="at_swp_icon_box at-swp-icon-box-<?php echo esc_attr($icon_pos) ?>">
	    <?php echo ( strlen( $link ) ) ? $link : '' ?>
	    <div class="<?php echo esc_attr($css_class) ?>">
	        <div class="at_swp-icon-box-content-wrapper">
	            <?php echo wp_kses($icon_html, array('i' => array('class' => true), 'span' => array('class' => true))) ?>
	            <h3 class="at_swp-icon-box-heading"><?php echo esc_html($title); ?></h3>
	            <div class="at_swp-icon-box-content">
	                <?php echo wpb_js_remove_wpautop( $content ); ?>
	            </div>
	        </div>
	    </div>
		<?php echo ( strlen( $link ) ) ? '</a>' : '' ?>
	</div>
<?php
    $output = ob_get_clean();

    return $output;
}

/*
	Artemis Products Grid Container
*/
add_shortcode('lc_prods_grid_container', 'ARTEMIS_SWP_lc_prods_grid_container_shortcode');
function ARTEMIS_SWP_lc_prods_grid_container_shortcode($atts, $content = "") {
	if ( !class_exists('woocommerce') ) {
		return "";
	}

	$defaults = array(
	        'gap' 			=> 0,
	        'bricks_on_row'	=> '4',
	        'aspect_ratio'	=> 'ar4_3',
	        "user_ar"		=> ""
    );
	extract(shortcode_atts($defaults, $atts));

    /** @var int $gap */
    $gap = intval($gap);
    $bricks_on_row = intval($bricks_on_row);

    if ($gap > 30) {
    	$gap = 30;
    }
	ob_start();

?>
	<div class="lc_swp_prods_grid_container" data-gapwidth="<?php echo esc_attr($gap); ?>" data-bricksonrow="<?php echo esc_attr($bricks_on_row); ?>" data-ar="<?php echo esc_attr($aspect_ratio);?>" data-userar="<?php echo esc_attr($user_ar); ?>">
		<?php echo do_shortcode($content); ?>
	</div>
<?php

	$output = ob_get_clean();
	return $output;
}


/*
	Artemis collection promo
*/
add_shortcode( 'at_swp_artemis_collection_promo', 'ARTEMIS_SWP_artemis_collection_promo_shortcode' );
function ARTEMIS_SWP_artemis_collection_promo_shortcode($atts) {
	$defaults = array(
		'bg_image'				=> '',
		'idle_color'			=> '#000000',
		'hover_color'			=> '#000000',
		'bold_text'				=> '',
		'additional_text'		=> '',
		'small_heading'			=> '',
		'promo_url'					=> ''
	);
	extract(shortcode_atts($defaults, $atts));

	$brick_classes = "at_swp_single_grid_prod at_collection_promo";
	$image_src = "";

	/*add class for bg image*/
	if (strlen($bg_image)) {
		$brick_classes .= " have_img lc_swp_background_image";
		$image_src = wp_get_attachment_url($bg_image);
	} else {
		$brick_classes .= " no_img";
	} 

	$bold_text = urldecode(base64_decode($bold_text));
	$allowed_html = array(
		'br'	=> array()
		);

	ob_start();
?>
	<div class="<?php echo esc_attr($brick_classes); ?>" data-bgimage="<?php echo esc_attr($image_src); ?>">
		<div class="at_promo_content">
			<div class="at_promo_content_inner">

			<?php if (strlen($promo_url)) { ?>
			<a href="<?php echo esc_attr(esc_url($promo_url)); ?>" class="use_custom_link_color">
			<?php } ?>
				<?php if (strlen($small_heading)) { ?>
					<div class="at_promo_small_head transition3 cust_hover_color at_swp_js_css" data-custcol="<?php echo esc_attr($idle_color); ?>" data-custhcol="<?php echo esc_attr($hover_color); ?>"> 
						<?php echo esc_html($small_heading); ?> 
					</div>
				<?php } ?>

				<?php if (strlen($bold_text)) { ?>
					<div class="at_promo_bold transition3 cust_hover_color at_swp_js_css" data-custcol="<?php echo esc_attr($idle_color); ?>" data-custhcol="<?php echo esc_attr($hover_color); ?>"> 
						<?php echo wp_kses($bold_text, $allowed_html); ?> 
					</div>
				<?php } ?>

				<?php if (strlen($additional_text)) { ?>
					<div class="at_promo_add_txt transition3 cust_hover_color at_swp_js_css" data-custcol="<?php echo esc_attr($idle_color); ?>" data-custhcol="<?php echo esc_attr($hover_color); ?>"> 
						<?php echo esc_html($additional_text); ?> 
					</div>
				<?php } ?>
			<?php if (strlen($promo_url)) { ?>
			</a>
			<?php } ?>

			</div>			
		</div>	
	</div>
<?php
	$output = ob_get_clean();

	return $output;
} 
/*
	Artemis Grid Product
*/
add_shortcode( 'at_swp_artemis_grid_product', 'ARTEMIS_SWP_artemis_grid_product_shortcode' );
function ARTEMIS_SWP_artemis_grid_product_shortcode($atts) {
	if ( ! class_exists('woocommerce') ) {
		return "";
	}

	/**
	 * @var string $product_id
	 * @var string $id
	 * @var string $brick_width
	 * @var string $brick_height
	 * @var string $bg_image_size
	 * @var string $custom_bg_img
	 * */
	$defaults = array(
		'brick_shows'			=> 'product_data',			/* product_data, product_cat, custom_data */
		'id' 					=> '',			/* shows => product_data */
		'product_cat'			=> '',			/* shows => prod_category */
		'cust_title'			=> '',			/* shows => custom */
		'cust_subtitle'			=> '',  		/* shows => custom */
		'cust_overlay'			=> '',  		/* shows => custom */
		'cust_shop_now_txt'		=> '',			/* shows => custom */
		'cust_shop_now_url'		=> '',			/* shows => custom */
		'cust_desc'				=> '',			/* shows => custom */
		'text_vertical_pos'		=> 'bottom',		/* top/middle/bottom */
		'text_horizontal_pos'	=> 'left',		/* left/center/right */
		'brick_width'			=> 'default',
		'brick_height'			=> 'default',
		'bg_image_size'			=> 'cover',
		'custom_bg_img'			=> '',
		'color_scheme'			=> 'default',	/* default/white_on_black/black_on_white */
		'font_size'				=> 'default'	/*default/small*/
	);
	extract( shortcode_atts( $defaults, $atts ) );
	
	$bg_image = "";

	/*product data*/
	$product_id = absint($id);
	$wc_product = wc_get_product( $product_id );
	$prod_title = "";
	$prod_permalink = "";
	$prod_price = "";
	if ($wc_product && ("product_data" == $brick_shows)) {
		$prod_title  = $wc_product->get_title();  
		$prod_permalink   = $wc_product->get_permalink();
		$bg_image    = wp_get_attachment_url($wc_product->get_image_id());
		$prod_price = $wc_product->get_price_html();
	}

	$allowed_title_html = array(
		'strong'	=> array(),
		'i'			=> array(),
		'br'		=> array(),
		'span'		=> array(
			'class'	=> array()
		)
	);

	$cust_title = urldecode(base64_decode($cust_title));
	$cust_desc = urldecode(base64_decode($cust_desc));

	/*handle custom bg image - custom overwrites product image*/
	if ($custom_bg_img) {
        $bg_image = wp_get_attachment_url($custom_bg_img);
    }

    /*product_cat data*/
	$tax_name = "";
	$tax_link = "";
	if ("product_cat" == $brick_shows) {
		$tax_obj = get_term($product_cat);
		if ($tax_obj) {
			$tax_name = $tax_obj->name;
			$tax_link = get_term_link($tax_obj);
		}
	}

	/*handle dimensions*/
	$brick_classes = 'at_swp_single_grid_prod brick4';
	if ($brick_width != "default") {
		$brick_classes .= ' width_'.$brick_width;
	}
	if ($brick_height != "default") {
		$brick_classes .= ' height_'.$brick_height;
	}

	/*handle background position*/
	if ($bg_image_size == "contain") {
		$brick_classes .= ' lc_swp_background_image_fit';
	} elseif ( $bg_image_size == "cover" ) {
		$brick_classes .= ' lc_swp_background_image';
	}
	else {
		$brick_classes .= ' lc_swp_background_image_normal';
	}

	/*add class for bg image*/
	if (strlen($bg_image)) {
		$brick_classes .= " have_img";
	} else {
		$brick_classes .= " no_img";
	}

	/*color scheme*/
	if ("default" != $color_scheme) {
		$brick_classes .= " ".$color_scheme;
	}
	if ("default" != $font_size) {
		$brick_classes .= " font_small";
	}

	/*handle text content position*/
	$content_hclass = 'show_on_' . $text_horizontal_pos;
	if ("center" == $text_horizontal_pos) {
		$content_hclass .= " text_center";
	}
	/*if ("right" == $text_horizontal_pos) {
		$content_hclass .= " text_right";
	}*/	
	$content_vclass = 'show_on_' . $text_vertical_pos;

	ob_start();
?>
	<div class="<?php echo esc_attr($brick_classes); ?>" data-bgimage="<?php echo esc_attr($bg_image); ?>">
		<?php if ($cust_overlay) { ?>
			<div class="brick_overlay lc_swp_cust_bg_color transition4" data-bgcolor="<?php echo esc_attr($cust_overlay); ?>">
			</div>
		<?php } ?>

		<div class="at_swp_single_prod_inner <?php echo esc_attr($content_hclass.' '.$content_vclass.' '.$brick_shows);?>" >
			<?php if ("product_data" == $brick_shows) { ?>
				<?php if (strlen($prod_title)) { ?>
				<a href="<?php echo esc_url($prod_permalink); ?>">
					<div class="prod_title">
						<h3><?php echo esc_html($prod_title); ?></h3>
					</div>
				<?php } ?>
				</a>

				<?php if (strlen($prod_price)) { ?>
				<div class="prod_price">
					<?php echo wp_kses_post($prod_price); ?>
				</div>
				<?php } ?>
			<?php } ?>

			<?php if ("product_cat" == $brick_shows) { ?>
				<a href="<?php echo esc_url($tax_link); ?>" >
					<div class="brick_cust_subtitle">
						<?php echo esc_html($tax_name); ?>
					</div>
				</a>

				<?php if (strlen($cust_shop_now_url) && strlen($cust_shop_now_txt)) { ?>
				<div class="brick_cust_link transition4">
					<a href="<?php echo esc_url($cust_shop_now_url); ?>" class="at_link_line_before">
						<?php echo ($cust_shop_now_txt); ?>
					</a>
				</div>
				<?php } ?>				
			<?php } ?>

			<?php if ("custom_data" == $brick_shows) { ?>
				<?php if (strlen($cust_subtitle)) { ?>
					<?php if (strlen($cust_shop_now_url)) { ?>
						<a href="<?php echo esc_url($cust_shop_now_url); ?>">
					<?php } ?>
						<div class="brick_cust_subtitle">
							<?php echo esc_html($cust_subtitle); ?>
						</div>
					<?php if (strlen($cust_shop_now_url)) { ?>
						</a>
					<?php } ?>	
				<?php } ?>

				<?php if (strlen($cust_title)) { ?>
					<?php if (strlen($cust_shop_now_url)) { ?>
					<a href="<?php echo esc_url($cust_shop_now_url); ?>">
					<?php } ?>
						<h3 class="brick_cust_title">
							<?php echo wp_kses($cust_title, $allowed_title_html); ?>
						</h3>
					<?php if (strlen($cust_shop_now_url)) { ?>
					</a>
					<?php } ?>	
				<?php } ?>

				<?php if (strlen($cust_desc)) { ?>
				<div class="brick_cust_desc">
					<?php echo wp_kses($cust_desc, $allowed_title_html); ?>
				</div>
				<?php } ?>

				<?php if (strlen($cust_shop_now_url) && strlen($cust_shop_now_txt)) { ?>
				<div class="brick_cust_link transition4">
					<a href="<?php echo esc_url($cust_shop_now_url); ?>" class="at_link_line_before">
						<?php echo ($cust_shop_now_txt); ?>
					</a>
				</div>
				<?php } ?>

			<?php } ?>
		</div>
	</div>
<?php
	$output = ob_get_clean();
	return $output;
}

/**
 * Artemis Vertical Row Separator
 */
add_shortcode('at_swp_vertical_row_separator', 'ARTEMIS_SWP_vertical_row_separator_shortcode');
function ARTEMIS_SWP_vertical_row_separator_shortcode($atts)
{
    $type = $height = $width = $vertical_anchor = $horizontal_alignment =
    $ends_with = $end_text_weight =$end_text = $end_image = $offset_left = $offset_right =
    $color = $z_index = $end_text_color= $end_text_fs = $extra_class = '';

    $defaults = array(
        'type'                 => 'dashed',
        'width'                => '1',
        'height'               => '100',
        'vertical_anchor'      => 'top',
        'horizontal_alignment' => 'center',
        'z_index'              => '1',
        'color'                => '',
        'ends_with'            => 'nothing',
        'end_image'            => '',
        'end_text'             => '',
        'end_text_weight'      => 100,
        'end_text_color'             => '',
        'end_text_fs'          => '',
        'offset_left'          => 0,
        'offset_right'         => 0,
        'extra_class'          => ''
    );

    extract(shortcode_atts($defaults, $atts));

    if( !$end_text_weight ){
        $end_text_weight = 100;
    }

    $classes = 'at_swp_vertical_row_separator at_swp_js_css ' . $extra_class;
    $classes .= ' at_swp_vrsep_' . $type;
    $classes .= ' at_swp_vrsep_anchor-' . $vertical_anchor;
    $classes .= ' at_swp_vrsep_halign-' . $horizontal_alignment;

    if( !$color ) {
        $lc_customize = get_option('lc_customize');

        if (!isset($lc_customize['lc_second_color'])) {
            $color = '#18aebf';
        } else {
            $color = $lc_customize['lc_second_color'];
        }
    }
    if (!$end_text_color) {
        $lc_customize = get_option('lc_customize');
        if (!isset($lc_customize['lc_second_color'])) {
            $end_text_color = '#18aebf';
        } else {
            $end_text_color = $lc_customize['lc_second_color'];
        }
    }
    $end_text_fs = intval($end_text_fs);

ob_start();
    ?>
    <div class="<?php echo esc_attr($classes) ?>"
         data-height="<?php echo esc_attr($height) ?>"
         data-z_index="<?php echo esc_attr($z_index) ?>"
         data-color="<?php echo esc_attr($color) ?>"
         data-offset-left="<?php echo esc_attr($offset_left) ?>"
         data-offset-right="<?php echo esc_attr($offset_right) ?>">
        <div class="at_swp_vertical_row_separator_line at_swp_js_css"
             data-border-width="<?php echo esc_attr($width) ?>"></div>
            <?php if ('text' == $ends_with && trim($end_text)) { ?>
            <span class="at_swp_vrsep_end at_swp_js_css at_swp_vrsep_text"
                  data-atfs="<?php echo esc_attr($end_text_fs) ?>"
                  data-font-weight="<?php echo esc_attr( $end_text_weight) ?>"
                  data-color="<?php echo esc_attr($end_text_color)?>"><?php echo esc_html($end_text) ?></span>
            <?php } elseif ('image' == $ends_with && absint($end_image)) {
                $img = wp_get_attachment_image_src($end_image, 'full');
                if( false !== $img ) { ?>
                    <img class="at_swp_vrsep_end at_swp_vrsep_img" src="<?php echo esc_attr($img[0]) ?>"/>
                <?php } ?>
            <?php } ?>
    </div>
    <?php

    return ob_get_clean();
}


add_shortcode('at_swp_lookbook_single', 'ARTEMIS_SWP_lookbook_single_shortcode');
function ARTEMIS_SWP_lookbook_single_shortcode($atts, $content = null) {
	$defaults = array(
		'image'			=> '',
		'title'			=> 'True Classics',
		'subtitle'		=> 'Casual Look',
		'link_text'		=> 'View Collection',
		'link_url'		=> '#',
	/*	'content'		=> '',*/
		'layout_style'	=> 'text_over_image',
		'full_height'	=> '0',
		"custom_height"	=> "0",
		'height'		=> '500',
		'text_location'	=> 'left',	/*only for text_aside*/
		'title_over_image'	=> '0'	/*only for text_aside*/
		/*TODO: position (center, top right, top left, bottom right, bottom left)*/
	);
	extract(shortcode_atts($defaults, $atts));

	/*
		layout_style:
			- text_over_image
			- text_aside
			- text_under_image
	*/
	$height = intval($height);
	if (!$height) {
		$height = "500px";
	} else {
		$height .= 'px';
	}
	
	if ($full_height && !$custom_height) {
		$height = '100vh';
	}	

	$container_class = $layout_style;
	$data_height_for_container = "";
	if ("text_over_image" == $layout_style) {
		$container_class .= ' lc_swp_background_image at_swp_js_css';
		$data_height_for_container = $height;
	}
	if ("text_aside" == $layout_style) {
		$container_class .= ' clearfix at_swp_js_css';
		$data_height_for_container = $height;
	}
	$image_src = wp_get_attachment_url($image);


	ob_start();
?>
	<div class="lookbook_single_container">
		<div class="lookbook_single <?php echo esc_attr($container_class); ?>" data-bgimage="<?php echo esc_attr($image_src); ?>" data-height="<?php echo esc_attr($data_height_for_container); ?>" data-layoutstyle="<?php echo esc_attr($layout_style); ?>">
			<?php if ("text_over_image" == $layout_style) { ?>
			<div class="look_overlay"></div>
			<div class="look_content show_on_hover">
				<?php if (!empty($subtitle)) {  ?>
					<h3> <?php echo esc_html($subtitle); ?> </h3>
				<?php } ?>

				<?php if (!empty($title)) {  ?>
					<h2> <?php echo esc_html($title); ?> </h2>
				<?php } ?>

				<?php if (!empty($link_url)) {  ?>
					<a href="<?php echo esc_attr($link_url); ?>" class="look_link text_over_image">
						<?php echo esc_html($link_text); ?>
					</a>
				<?php } ?>

				<?php if (!empty($content)) {  ?>
					<div class="look_desc">
						<?php echo wpb_js_remove_wpautop($content); ?>
					</div>
				<?php } ?>
			</div>
			<?php } ?>


			<?php if ("text_aside" == $layout_style) { ?>
				<?php 
					$content_add_class = $title_over_image ? ' over_image' : '';
					$content_inner_add_class = $content_add_class;
					$image_add_class = "";
					if ("right" == $text_location) {
						$content_add_class .= ' show_on_right';
					} else {
						$content_add_class .= ' show_on_left';
					}
					if (!$title_over_image) {
						$content_add_class .= ' no_overlap';
						$image_add_class .=  ' no_overlap';
					}
					
				?>
			<div class="look_content_aside<?php echo esc_attr($content_add_class); ?>">
				<div class="look_content_aside_inner<?php echo esc_attr($content_inner_add_class); ?>">
					<?php if (!empty($title)) {  ?>
						<h2> <?php echo esc_html($title); ?> </h2>
					<?php } ?>
					<?php if (!empty($content)) {  ?>
						<div class="look_desc">
							<?php echo wpb_js_remove_wpautop($content); ?>
						</div>
					<?php  } ?>
					<?php if (!empty($link_url)) {  ?>
						<a href="<?php echo esc_attr($link_url); ?>" class="look_link text_aside at_link_line_before">
							<?php echo esc_html($link_text); ?>
						</a>
					<?php } ?>
				</div>
			</div>
			<div class="look_image_aside lc_swp_background_image <?php echo esc_attr($image_add_class); ?>" data-bgimage="<?php echo esc_attr($image_src); ?>">	</div>	
			<?php } ?>


			<?php if ("text_under_image" == $layout_style) { ?>
			<div class="look_image_over lc_swp_background_image at_swp_js_css" data-bgimage="<?php echo esc_attr($image_src); ?>" data-height="<?php echo esc_attr($height); ?>">
			</div>
			<div class="look_content_under lc_swp_boxed">
				<div class="look_content_under_inner">
					<?php if (!empty($title)) {  ?>
						<h2> <?php echo esc_html($title); ?> </h2>
					<?php } ?>
					<?php if (!empty($content)) {  ?>
						<div class="look_desc">
							<?php echo wpb_js_remove_wpautop($content); ?>
						</div>
					<?php  } ?>
					<?php if (!empty($link_url)) {  ?>
						<div class="text_center lc_basic_content_padding">
							<div class="lc_button">
								<a href="<?php echo esc_attr($link_url); ?>">
									<?php echo esc_html($link_text); ?>
								</a>
							</div>
						</div>
					<?php } ?>				
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
<?php

	$output = ob_get_clean();
	return $output;
}

/*
	Lookbook Container
*/
add_shortcode('lc_lookbook_slider', 'ARTEMIS_SWP_lc_lookbook_slider');
function ARTEMIS_SWP_lc_lookbook_slider($atts, $content = "")
{
	$defaults = array(
		'navigation_style' 	=> 'nav_text',	/*nav_text/nav_icon*/
		'text_next'					=> 'next',
		'text_prev'					=> 'prev'
	);
	extract(shortcode_atts($defaults, $atts));

	if (empty($text_next)) {
		$text_next = "Next";
	}
	if (empty($text_prev)) {
		$text_next = "Prev";
	}

	ob_start();
?>
	<div class="lc_lookbook_slider_container">
		<div class="lc_lookbook_slider" data-navstyle="<?php echo esc_attr($navigation_style); ?>" data-prevtxt="<?php echo esc_attr($text_prev); ?>" data-nexttxt="<?php echo esc_attr($text_next); ?>">
			<div class="unslider_parent">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>	
	</div>
<?php	
	$output = ob_get_clean();

	return $output;
}


/*
	Partner Logo
*/
add_shortcode('lc_partner_logo', 'ARTEMIS_SWP_lc_partner_logo_scd');
function ARTEMIS_SWP_lc_partner_logo_scd($atts) {
	$defaults = array(
		'logo_img' 			=> '',
		'logo_url'			=> '',
		'black_and_white'	=> 'yes'
	);
	extract(shortcode_atts($defaults, $atts));
	ob_start();

	if (empty($logo_img)) {
		return "";
	}

	$img_class = "";
	if("yes" == $black_and_white) {
		$img_class = 'filter_grayscale';
	}
	ob_start();
?>
	<div class="partner_icon text_center transition3">
		<?php if (!empty($logo_url)) { ?>
			<a href="<?php echo esc_url($logo_url); ?>" target="_blank">
		<?php } ?>
			<?php echo wp_get_attachment_image($logo_img, "full", "", array("class" => $img_class)); ?> 
		<?php if (!empty($logo_url)) { ?>
			</a>
		<?php } ?>
	</div>
<?php
	$output = ob_get_clean();

	return $output;	
}

add_shortcode('lc_mailchimp_subscribe', 'ARTEMIS_SWP_lc_mailchimp_subscribe_scd');
function ARTEMIS_SWP_lc_mailchimp_subscribe_scd($atts) {
	$defaults = array(
		'api_key' 			=> '',
		'list_id'			=> ''
	);
	extract(shortcode_atts($defaults, $atts));

	if (empty($api_key) || empty($list_id)) {
		return "";
	}

	$btn_val = esc_html__('Subscribe', 'artemis-swp-core');
	$btn_loading_val = esc_html__('Processing...', 'artemis-swp-core');
	ob_start();
?>
	<div class="at_mc_subscr_form_container">
		<form class="at_mc_subscr_form">
			<input type="text" placeholder="<?php echo esc_html__('First Name', 'artemis-swp-core'); ?>" name="newsletter_fname" class="fname at_newslet_entry at_news_input_entry required"/>
			<input type="text" placeholder="<?php echo esc_html__('Last Name', 'artemis-swp-core'); ?>" name="newsletter_lname" class="lname at_newslet_entry at_news_input_entry required"/>
			<input type="text" placeholder="<?php echo esc_html__('Email', 'artemis-swp-core'); ?>" name="newsletter_email" class="mc_email at_newslet_entry at_news_input_entry required"/>
			<input type="text" name="at_mc_api_key" value="<?php echo esc_html($api_key); ?>" class="display_none"/>
			<input type="text" name="at_mc_list_id" value="<?php echo esc_html($list_id); ?>" class="display_none"/>

			<input name="newsletter_subscribe" type="submit" data-btnval="<?php echo esc_attr($btn_val);  ?>" data-loadingmsg="<?php echo esc_attr($btn_loading_val); ?>" class="lc_button at_newslet_entry at_news_button_entry" value="<?php echo esc_attr($btn_val); ?>" >
			<input type="hidden" name="action" value="artemisnewsform_action" />
			<?php wp_nonce_field('artemisnewsform_action', 'subscrform_nonce');?>			
		</form>
		<div class="at_mc_subscr_form_success">
			<?php echo esc_html__('You have been added to our mailing list.', 'artemis-swp-core'); ?>
		</div>
		<div class="at_mc_subscr_form_error">
		</div>		
	</div>
<?php
	$output = ob_get_clean();

	return $output;	
}


add_shortcode('swp_vertical_shop_promo', 'ARTEMIS_SWP_swp_vertical_shop_promo');
function ARTEMIS_SWP_swp_vertical_shop_promo($atts) {
	$defaults = array(
		'vertical_promo_txt'	=> 'featured',
		'category_name_txt'		=> urlencode(base64_encode('mens')),	/*allows <br>*/
		'link_txt'				=> 'view all',
		'link_url'				=> '#',
		'max_height'			=> '400'
	);
	extract(shortcode_atts($defaults, $atts));

	$category_name_txt = urldecode(base64_decode($category_name_txt));
	$allowed_html = array(
		'br'	=> array()
		);
	$max_height = intval($max_height);
	ob_start();

	/*get shop_catalog image size*/
	$aspect_ratio = 0.5;
	if (ARTEMIS_SWP_is_woocommerce_active()) {
		$woo_sizes = wc_get_image_size('shop_catalog');
		$aspect_ratio = $woo_sizes['width']/$woo_sizes['height'];
	}
?>
	<div class="swp_vertical_shop_promo" data-ar="<?php echo esc_attr($aspect_ratio); ?>" data-maxheight="<?php echo esc_attr($max_height); ?>">
		<div class="swp_vertical_shop_promo_inner">
			<div class="vertical_promo_txt">
				<div class="vertical_promo_inner">
					<div class="vertical_promo_inner_abs">
					<?php echo esc_html($vertical_promo_txt); ?>
					</div>
				</div>
			</div>

			<div class="vertical_promo_categ_name">
				<?php echo wp_kses($category_name_txt, $allowed_html); ?> 
			</div>

			<div class="vertical_promo_link">
				<a href="<?php echo esc_attr(esc_url($link_url)); ?>">
					<?php echo esc_html($link_txt); ?>
				</a>
			</div>
		</div>
	</div>
<?php
	$output = ob_get_clean();

	return $output;	

	

}