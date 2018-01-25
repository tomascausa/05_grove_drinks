<?php
/* 
|--------------------------------------------------------------------------
| ADD META BOXES
|--------------------------------------------------------------------------
*/
function ARTEMIS_SWP_custom_bg_meta() {
	/* CUSTOM BACKGROUND IMAGE*/
	$custom_bg_image_support = array('post', 'page');
	add_meta_box(
		'js_swp_custom_bg_meta',
		esc_html__( "Page Settings", 'artemis-swp-core' ),
		'ARTEMIS_SWP_custom_bg_meta_callback',
		$custom_bg_image_support
	);
	add_meta_box(
		'js_swp_custom_bg_meta',
		esc_html__( "Page Settings", 'artemis-swp-core' ),
		'ARTEMIS_SWP_custom_bg_meta_callback',
		array('product')
	);
	add_meta_box(
		'js_swp_custom_header_meta',
		esc_html__( "Header Settings", 'artemis-swp-core' ),
		'ARTEMIS_SWP_custom_header_meta_callback',
		$custom_bg_image_support
	);
	add_meta_box(
		'js_swp_custom_header_meta',
		esc_html__( "Header Settings", 'artemis-swp-core' ),
		'ARTEMIS_SWP_custom_header_meta_callback',
		'product'
	);
	add_meta_box(
		'js_swp_custom_product_description',
		esc_html__( "Description", 'artemis-swp-core' ),
		'ARTEMIS_SWP_custom_product_description_callback',
		array( 'product'),
        'normal',
        'high'
	);

    add_meta_box(
        'at_swp_product_video',
        esc_html__( "Product Video", 'artemis-swp-core' ),
        'ARTEMIS_SWP_custom_product_video_callback',
        array( 'product' ),
        'normal',
        'high'
    );
	
	/*add custom meta to archives and blog page templates only*/
	global $post;
    if ($post) { //on admin comments page $post is null
	$post_id = $post->ID;
	$page_template = get_post_meta($post_id,'_wp_page_template', TRUE);
	if (ARTEMIS_SWP_is_archive_like($page_template)) {
		add_meta_box(
			"js_swp_blog_settings_meta", 
			esc_html__("Archive And Blog Settings", 'artemis-swp-core'), 
			"ARTEMIS_SWP_blog_settings_cbk", 
			"page");
	}
    }
}
add_action( 'add_meta_boxes', 'ARTEMIS_SWP_custom_bg_meta');


/* 
|--------------------------------------------------------------------------
| CALLBACK FUNCTION THAT RENDERS META
|--------------------------------------------------------------------------
*/
/*custom page background*/
function ARTEMIS_SWP_custom_bg_meta_callback($post) {
	
    $js_swp_stored_meta = get_post_meta($post->ID);
	$meta_bg = '';
	$page_overlay_color = '';
	$remove_footer_widgets = '';
	$remove_breadcrumbs = '';
	$remove_contact_map = '';
	$color_scheme = '';
	/*page only*/
	$custom_page_title = '';


	$color_scheme_support = array (
		'Artemis Settings Default'			=> 'default_scheme',
		'Black On White'					=> 'black_on_white',
		'White On Black'					=> 'white_on_black'
	);

	if (isset($js_swp_stored_meta['js_swp_meta_bg_image'])) {
		$meta_bg = $js_swp_stored_meta['js_swp_meta_bg_image'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_overlay_color'])) {
		$page_overlay_color = $js_swp_stored_meta['lc_swp_meta_page_overlay_color'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_remove_footer'])) {
		$remove_footer_widgets = $js_swp_stored_meta['lc_swp_meta_page_remove_footer'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_remove_breadc'])) {
		$remove_breadcrumbs = $js_swp_stored_meta['lc_swp_meta_page_remove_breadc'][0];
	}
	if (isset($js_swp_stored_meta['lc_swp_meta_page_color_scheme'])) {
		$color_scheme = $js_swp_stored_meta['lc_swp_meta_page_color_scheme'][0];
	}
	/*only on pages based on contact template*/
	if (isset($js_swp_stored_meta['lc_swp_meta_page_remove_contact_map'])) {
		$remove_contact_map = $js_swp_stored_meta['lc_swp_meta_page_remove_contact_map'][0];
	}
	/*only on pages*/
	if (isset($js_swp_stored_meta['lc_swp_meta_page_custom_title'])) {
		$custom_page_title = $js_swp_stored_meta['lc_swp_meta_page_custom_title'][0];
	}

	$allow_tags	= array(
		'strong'	=> array(),
		'br'		=> array(),
		'i'			=> array(),
		'span'		=> array(
			'class'		=> array()
		)
	);


	wp_nonce_field( basename( __FILE__ ), 'js_swp_nonce' );
	ob_start();
?>	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Choose custom page background image:', 'artemis-swp-core'); ?>
		</span>
		<input type="text" style="width:100%; margin-bottom: 5px;" name="js_swp_meta_bg_image" id="js_swp_meta_bg_image" value="<?php echo esc_attr($meta_bg); ?>" />
		<div class="js_swp_meta_bg_image_buttons">
			<input type="button" id="js_swp_meta_bg_image-button" class="button" value="<?php echo esc_html__('Choose Image', 'artemis-swp-core'); ?>" />
			<input type="button" id="js_swp_meta_bg_image-buttondelete" class="button" value="<?php echo esc_html__('Remove Image', 'artemis-swp-core'); ?>" />
		</div>
	</div>
	<div id="custom_bg_meta_preview">
		<img style="max-width:100%;" src="<?php echo esc_url($meta_bg); ?>" />
    </div>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Page background color overlay:', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_overlay_color" value="<?php echo esc_attr($page_overlay_color); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true" />
		</div>
	</div>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Remove footer widgets area for this page:', 'artemis-swp-core'); ?>
		</span>
		<input name="lc_swp_meta_page_remove_footer" type="checkbox" value="1" <?php checked("1", $remove_footer_widgets); ?>>
	</div>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Remove breadcrumbs navigation for this page: ', 'artemis-swp-core'); ?>
		</span>
		<input name="lc_swp_meta_page_remove_breadc" type="checkbox" value="1" <?php checked("1", $remove_breadcrumbs); ?>>
	</div>	
	<?php if ("template-contact.php" == get_page_template_slug($post->ID)) {?>
		<div class="heading_meta_option">
			<span class="lc_swp_before_option">
				<?php echo esc_html__('Remove google map from this contact page: ', 'artemis-swp-core'); ?>
			</span>
			<input name="lc_swp_meta_page_remove_contact_map" type="checkbox" value="1" <?php checked("1", $remove_contact_map); ?>>
		</div>
	<?php } ?>
	<?php if ("page" == $post->post_type) {?>
		<div class="heading_meta_option">
			<span class="lc_swp_before_option">
				<?php echo esc_html__('Custom page title: ', 'artemis-swp-core'); ?>
			</span>
			<input name="lc_swp_meta_page_custom_title" type="text" size="100" value="<?php echo wp_kses($custom_page_title, $allow_tags); ?>">
			<p class="description show_on_right">
				<?php 
					$descr_val = 'Add custom title that will replace the default titles. Formatting tags allowed: ';
					echo esc_html__($descr_val, 'artemis-swp-core'); 

					$descr_val = "Use &lt;span class=&quot;lc_vibrant_color&quot;&gt;some colored text&lt;/span&gt; to color one or more words in vibrant color. ";
					echo '<br>' . esc_html__($descr_val, 'artemis-swp-core'); 

					$descr_val = "Use &lt;br&gt; to break the line. ";
					echo '<br>' . esc_html__($descr_val, 'artemis-swp-core'); 

					$descr_val = "Use &lt;strong&gt;some bold text&lt;/strong&gt; to increase the font weight of one of your words. ";
					echo '<br>' . esc_html__($descr_val, 'artemis-swp-core'); 

					$descr_val = "Use &lt;i&gt;some italic text&lt;/i&gt; to show the text italic. ";
					echo '<br>' . esc_html__($descr_val, 'artemis-swp-core'); 

				?>
			</p>
		</div>
	<?php } ?>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Color Scheme:', 'artemis-swp-core'); ?>
		</span>
		<select id="lc_swp_meta_page_color_scheme" name="lc_swp_meta_page_color_scheme">
		<?php
			foreach($color_scheme_support as $key => $value) {
				if ($value == $color_scheme) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('Choose to force a specific color scheme for this page/post.', 'artemis-swp-core');?>
		</p>
	</div>		
<?php

	$output = ob_get_clean();
	
	echo $output;
}

/*custom heading area*/
function ARTEMIS_SWP_custom_header_meta_callback($post) {
	$stored_meta = get_post_meta($post->ID);
	
	/*header color scheme*/
	$color_theme = 'default_scheme';
	if (isset($stored_meta['lc_swp_meta_heading_color_theme'])) {
		$color_theme = $stored_meta['lc_swp_meta_heading_color_theme'][0];
	}
	$color_themes_support = array (
		'Default'			=> 'default_scheme',
		'Black On White'	=> 'black_on_white',
		'White On Black'	=> 'white_on_black'
	);
	
	/*header background image*/
	$header_bg_image = '';
	if (isset($stored_meta['lc_swp_meta_heading_bg_image'])) {
		$header_bg_image = $stored_meta['lc_swp_meta_heading_bg_image'][0];
	}
	
	/*header color overlay*/
	$overlay_color = '';
	if (isset($stored_meta['lc_swp_meta_heading_overlay_color'])) {
		$overlay_color = $stored_meta['lc_swp_meta_heading_overlay_color'][0];
	}

	/*
		Menu Custom Colors - they do not apply for sticky menu
	*/

	/*custom logo image*/
	$page_logo = '';
	if (isset($stored_meta['lc_swp_meta_page_logo'])) {
		$page_logo = $stored_meta['lc_swp_meta_page_logo'][0];
	}

	/*menu bar bg color*/
	$page_menu_bg = '';
	if (isset($stored_meta['lc_swp_meta_page_menu_bg'])) {
		$page_menu_bg = $stored_meta['lc_swp_meta_page_menu_bg'][0];
	}

	/*menu bar txt color*/
	$page_menu_txt_color = '';
	if (isset($stored_meta['lc_swp_meta_page_menu_txt_color'])) {
		$page_menu_txt_color = $stored_meta['lc_swp_meta_page_menu_txt_color'][0];
	}		

	/*above menu bar bg color*/
	$page_above_menu_bg = '';
	if (isset($stored_meta['lc_swp_meta_page_above_menu_bg'])) {
		$page_above_menu_bg = $stored_meta['lc_swp_meta_page_above_menu_bg'][0];
	}

	/*above menu bar text color*/
	$page_above_menu_txt_color = '';
	if (isset($stored_meta['lc_swp_meta_page_above_menu_txt_color'])) {
		$page_above_menu_txt_color = $stored_meta['lc_swp_meta_page_above_menu_txt_color'][0];
	}


	?>
	<h4 class="swp_text_align_center"> <?php echo esc_html__('Text Color', 'artemis-swp-core'); ?> </h4>	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Header Color Scheme:', 'artemis-swp-core'); ?>
		</span>
		<select id="lc_swp_meta_heading_color_theme" name="lc_swp_meta_heading_color_theme">
		<?php
			foreach($color_themes_support as $key => $value) {
				if ($value == $color_theme) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
	</div>
	
	<hr>
	<h4 class="swp_text_align_center"> <?php echo esc_html__('Background', 'artemis-swp-core'); ?> </h4>	
	<div class="heading_meta_option">
		<input type="text" style="width:100%;" name="lc_swp_meta_heading_bg_image" id="lc_swp_meta_heading_bg_image" value="<?php echo esc_url($header_bg_image); ?>" />
		<div class="lc_swp_meta_head_bg_image_buttons">
			<span class="lc_swp_before_option">
				<?php echo esc_html__('Background image:', 'artemis-swp-core'); ?>
			</span>
			<input type="button" id="lc_swp_meta_head_bg_image-button" class="button" value="<?php echo esc_html__('Choose Image', 'artemis-swp-core'); ?>" />
			<input type="button" id="lc_swp_meta_head_bg_image-buttondelete" class="button" value="<?php echo esc_html__('Remove Image', 'artemis-swp-core'); ?>" />
		</div>
		
		<div id="custom_head_bg_meta_preview">
			<img style="max-width:100%;" src="<?php echo esc_url($header_bg_image); ?>" />
		</div>
	</div>
	
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Background color overlay:', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_heading_overlay_color" value="<?php echo esc_attr($overlay_color); ?>" 	data-default-color="rgba(0,0,0,0)" data-show-opacity="true" />
		</div>
	</div>

    <?php if ('product' == $post->post_type) {
        $slider_bg_color = '';
        if (isset($stored_meta['lc_swp_meta_images_slider_bg_color'])) {
            $slider_bg_color = $stored_meta['lc_swp_meta_images_slider_bg_color'][0];
        }
        if (function_exists('ARTEMIS_SWP_get_product_page_template')
            && 'type_2' == ARTEMIS_SWP_get_product_page_template()
        ) { ?>
            <div class="heading_meta_option">
                <span class="lc_swp_before_option">
                    <?php echo esc_html__('Images slider background color', 'artemis-swp-core'); ?>
                </span>
                <div class="lc_swp_option_right">
                	<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_images_slider_bg_color"
                       value="<?php echo esc_attr($slider_bg_color); ?>" data-default-color="rgba(0,0,0,0)"
                       data-show-opacity="true"/>
				</div>
            </div>
        <?php } ?>
    <?php } ?>
	<hr>	
	
	<h4 class="swp_text_align_center"> <?php echo esc_html__('Custom Menu Colors &amp; Logo', 'artemis-swp-core'); ?> </h4>		
	<p><?php echo esc_html__('Add custom colors for the menu area only for this page/post.', 'artemis-swp-core'); ?></p>
	<div class="heading_meta_option">
		<input type="text" style="width:100%;" name="lc_swp_meta_page_logo" id="lc_swp_meta_page_logo" value="<?php echo esc_url($page_logo); ?>" />
		<div class="lc_swp_meta_page_logo_image_buttons">
			<span class="lc_swp_before_option">
				<?php echo esc_html__('Custom logo image:', 'artemis-swp-core'); ?>
			</span>
			<input type="button" id="lc_swp_meta_page_logo_image-button" class="button" value="<?php echo esc_html__('Choose Custom Logo', 'artemis-swp-core'); ?>" />
			<input type="button" id="lc_swp_meta_page_logo-buttondelete" class="button" value="<?php echo esc_html__('Remove Custom Logo', 'artemis-swp-core'); ?>" />
		</div>
		
		<div id="custom_head_page_logo_meta_preview">
			<img style="max-width:100%;" src="<?php echo esc_url($page_logo); ?>" />
		</div>
		<p class="description"><?php echo esc_html__('Choose custom logo image. The logo will overwrite the default logo for this page.', 'artemis-swp-core'); ?></p>
	</div>

	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Menu bar background color:', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_menu_bg" value="<?php echo esc_attr($page_menu_bg); ?>" data-default-color="" data-show-opacity="true" />
			<p class="description"><?php echo esc_html__('Choose custom background color for the menu bar. This color will overwrite the default color for this page.', 'artemis-swp-core'); ?></p>
		</div>
	</div>

	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Menu bar text color:', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_menu_txt_color" value="<?php echo esc_attr($page_menu_txt_color); ?>" data-default-color="" data-show-opacity="false" />
			<p class="description"><?php echo esc_html__('Choose custom text color for the menu bar. This color will overwrite the default color for this page.', 'artemis-swp-core'); ?></p>
		</div>	
	</div>

	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Above menu bar background color (if used):', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_above_menu_bg" value="<?php echo esc_attr($page_above_menu_bg); ?>" data-default-color="" data-show-opacity="true" />
			<p class="description"><?php echo esc_html__('Choose custom background color for the bar above menu, if used. This color will overwrite the default color for this page.', 'artemis-swp-core'); ?></p>
		</div>	
	</div>

	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__('Above menu bar text color (if used):', 'artemis-swp-core'); ?>
		</span>
		<div class="lc_swp_option_right">
			<input type="text" class="lc_swp_option alpha-color-picker" name="lc_swp_meta_page_above_menu_txt_color" value="<?php echo esc_attr($page_above_menu_txt_color); ?>" data-default-color="" data-show-opacity="false" />
			<p class="description"><?php echo esc_html__('Choose custom text color for the bar above menu, if used. This color will overwrite the default color for this page.', 'artemis-swp-core'); ?></p>
		</div>
	</div>	

	<hr>
	<?php

}

/*custom product description area*/
function ARTEMIS_SWP_custom_product_description_callback($post) {
	$stored_meta = get_post_meta($post->ID);


	$product_description = '';
	if (isset($stored_meta['lc_swp_meta_custom_description'])) {
		$product_description = $stored_meta['lc_swp_meta_custom_description'][0];
	}

	$override_description = 0;
	if (isset($stored_meta['lc_swp_meta_override_description'])) {
		$override_description = $stored_meta['lc_swp_meta_override_description'][0];
	}
	?>
    <div class="heading_meta_option">
        <input type="checkbox"
               id="lc_swp_meta_override_description"
	        <?php checked( $override_description, 1 ) ?>
               name="lc_swp_meta_override_description"
               value="1">
        <label class="lc_swp_before_option" for="lc_swp_meta_override_description">
            <?php echo esc_html__( 'Override product description', 'artemis-swp-core' ); ?>
        </label>
    </div>

	<div class="heading_meta_option">
        <?php
	        $settings = array(
		        'textarea_name' => 'lc_swp_meta_custom_description',
		        'quicktags'     => array( 'buttons' => 'em,strong,link' ),
		        'tinymce'       => array(
			        'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
			        'theme_advanced_buttons2' => '',
		        ),
		        'editor_css'    => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>'
	        );

	        wp_editor( htmlspecialchars_decode( $product_description ), 'lc_swp_meta_custom_description', $settings );
        ?>
	</div>

	<?php
}

/*custom product video area*/
function ARTEMIS_SWP_custom_product_video_callback($post) {
    $video_id = get_post_meta($post->ID, 'lc_swp_meta_custom_video', true);

    $video_poster = '';
    $video_post = null;
    $video_container_class = 'no_video';
    if( $video_id) {
        $video_post = get_post( $video_id );
        $video_poster = wp_get_attachment_image_src( get_post_thumbnail_id( $video_id), 'thumbnail' );
        $video_container_class = 'has_video';
    }
	?>
	<div class="heading_meta_option">
		<span class="lc_swp_before_option">
			<?php echo esc_html__( 'Choose product video', 'artemis-swp-core' ); ?>
		</span>
		<input type="hidden" name="lc_swp_meta_custom_video" id="lc_swp_meta_custom_video" value="<?php echo esc_attr( $video_id ); ?>"/>
		<div class="js_swp_meta_bg_image_buttons">
			<input type="button" id="lc_swp_meta_custom_video-button" class="button" value="<?php echo esc_html__( 'Choose Video', 'artemis-swp-core' ); ?>"/>
			<input type="button" id="lc_swp_meta_custom_video-buttondelete" class="button" value="<?php echo esc_html__( 'Remove Video', 'artemis-swp-core' ); ?>"/>
		</div>

        <div id="at_swp_video_details_container" class="<?php echo esc_attr($video_container_class); ?> ">
            <div id="at_swp_video_poster_container">
                <?php if ( $video_poster ) { ?>
                    <img src="<?php echo esc_attr( $video_poster[0]) ?>" alt="video poster image"/>
                <?php } ?>
            </div>
            <span class="at_swp_video_title" id="at_swp_video_title"><?php echo $video_post ? esc_attr( get_the_title($video_post)) : '' ?></span>
        </div><br/>		
	</div>

	<?php
}

/* Blog settings callback */
function ARTEMIS_SWP_blog_settings_cbk($post) {
	$stored_meta = get_post_meta($post->ID);
	
	/*
		blog layout: boxed - full width
	*/
	$blog_page_layout = 'boxed';
	if (isset($stored_meta['lc_swp_meta_blog_layout'])) {
		$blog_page_layout = $stored_meta['lc_swp_meta_blog_layout'][0];
	}

	$blog_masonry_centering = "center";
	if (isset($stored_meta['lc_swp_meta_blog_centering'])) {
		$blog_masonry_centering = $stored_meta['lc_swp_meta_blog_centering'][0];
	}	
	
	/*available options*/
	$blog_page_layout_support = array(
		esc_html__('Boxed', 'artemis-swp-core')			=> 'boxed',
		esc_html__('Full Width', 'artemis-swp-core')	=> 'full_width'
	);

	$blog_page_layout_centering_support = array(
		esc_html__('Center', 'artemis-swp-core')	=> 'center',
		esc_html__('Left', 'artemis-swp-core')		=> 'left'
	);	
?>	
	<div class="blog_option heading_meta_option">
		<span class="lc_swp_before_option"><?php esc_html_e('Layout', 'artemis-swp')?>:</span>
		<select id="lc_swp_meta_blog_layout" name="lc_swp_meta_blog_layout">
		<?php
			foreach($blog_page_layout_support as $key => $value) {
				if ($value == $blog_page_layout) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('Choose blog or archive page layout. Applies on the following page templates: Blog', 'artemis-swp-core'); ?>
		</p>
	</div>

	<div class="blog_option heading_meta_option">
		<span class="lc_swp_before_option">Masonry content centering:</span>
		<select id="lc_swp_meta_blog_centering" name="lc_swp_meta_blog_centering">
		<?php
			foreach($blog_page_layout_centering_support as $key => $value) {
				if ($value == $blog_masonry_centering) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('Choose how to center text on masonry bricks', 'artemis-swp-core'); ?>
		</p>
	</div>	
<?php
}

/* 
|--------------------------------------------------------------------------
| SAVE META VALUES
|--------------------------------------------------------------------------
*/
function ARTEMIS_SWP_custom_bg_meta_save($post_id) {
     // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'js_swp_nonce' ] ) && wp_verify_nonce( $_POST[ 'js_swp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	// Checks for input and saves if needed
	if( isset( $_POST[ 'js_swp_meta_bg_image' ] ) ) {
		update_post_meta( $post_id, 'js_swp_meta_bg_image', trim(esc_url($_POST['js_swp_meta_bg_image']))) ;
	}
	if( isset( $_POST[ 'lc_swp_meta_page_overlay_color' ] ) ) {
		update_post_meta( $post_id, 'lc_swp_meta_page_overlay_color', trim($_POST['lc_swp_meta_page_overlay_color'])) ;
	}
	if(isset($_POST[ 'lc_swp_meta_page_remove_footer' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_footer', '1');
	} else {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_footer', '0');
	}
	if(isset($_POST[ 'lc_swp_meta_page_remove_contact_map' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_contact_map', '1');
	} else {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_contact_map', '0');
	}
	if(isset($_POST[ 'lc_swp_meta_page_remove_breadc' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_breadc', '1');
	} else {
		update_post_meta( $post_id, 'lc_swp_meta_page_remove_breadc', '0');
	}
	if(isset($_POST[ 'lc_swp_meta_page_custom_title' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_custom_title', trim($_POST[ 'lc_swp_meta_page_custom_title' ]));
	}
	if(isset($_POST[ 'lc_swp_meta_page_color_scheme' ])) {
		update_post_meta( $post_id, 'lc_swp_meta_page_color_scheme', trim($_POST[ 'lc_swp_meta_page_color_scheme' ]));
	}	

}
add_action('save_post', 'ARTEMIS_SWP_custom_bg_meta_save');

function ARTEMIS_SWP_custom_header_meta_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if ($is_autosave || $is_revision) {
		return;
	}
	
	if(isset($_POST['lc_swp_meta_heading_color_theme'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_color_theme', trim($_POST['lc_swp_meta_heading_color_theme'])) ;
	}
	if(isset($_POST['lc_swp_meta_heading_bg_image'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_bg_image', trim(esc_url($_POST['lc_swp_meta_heading_bg_image']))) ;
	}
	if(isset($_POST['lc_swp_meta_heading_overlay_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_heading_overlay_color', trim($_POST['lc_swp_meta_heading_overlay_color'])) ;
	}
	if(isset($_POST['lc_swp_meta_images_slider_bg_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_images_slider_bg_color', trim($_POST['lc_swp_meta_images_slider_bg_color'])) ;
	}

	/*
		Save Custom Page Related MENU Colors
	*/
	if(isset($_POST['lc_swp_meta_page_logo'])) {
		update_post_meta($post_id, 'lc_swp_meta_page_logo', trim($_POST['lc_swp_meta_page_logo'])) ;
	}
	if(isset($_POST['lc_swp_meta_page_menu_bg'])) {
		update_post_meta($post_id, 'lc_swp_meta_page_menu_bg', trim($_POST['lc_swp_meta_page_menu_bg'])) ;
	}
	if(isset($_POST['lc_swp_meta_page_menu_txt_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_page_menu_txt_color', trim($_POST['lc_swp_meta_page_menu_txt_color'])) ;
	}
	if(isset($_POST['lc_swp_meta_page_above_menu_bg'])) {
		update_post_meta($post_id, 'lc_swp_meta_page_above_menu_bg', trim($_POST['lc_swp_meta_page_above_menu_bg'])) ;
	}
	if(isset($_POST['lc_swp_meta_page_above_menu_txt_color'])) {
		update_post_meta($post_id, 'lc_swp_meta_page_above_menu_txt_color', trim($_POST['lc_swp_meta_page_above_menu_txt_color'])) ;
	}		
}
add_action('save_post', 'ARTEMIS_SWP_custom_header_meta_save');

function ARTEMIS_SWP_custom_description_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

	if ($is_autosave || $is_revision) {
		return;
	}

	if(isset($_POST['lc_swp_meta_custom_description'])) {
		update_post_meta($post_id, 'lc_swp_meta_custom_description', trim($_POST['lc_swp_meta_custom_description'])) ;
	}
	$override_description = 0;
	if(isset($_POST['lc_swp_meta_override_description']) && $_POST['lc_swp_meta_override_description'] == 1) {
		$override_description = 1;
	}
	update_post_meta( $post_id, 'lc_swp_meta_override_description', $override_description );

}
add_action('save_post', 'ARTEMIS_SWP_custom_description_save');

function ARTEMIS_SWP_custom_video_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );

	if ($is_autosave || $is_revision) {
		return;
	}

	$videoId = isset( $_POST['lc_swp_meta_custom_video']) ? intval( $_POST['lc_swp_meta_custom_video']) : '';
	if($videoId){
	    update_post_meta( $post_id, 'lc_swp_meta_custom_video', $videoId );
	}
	else {
	    delete_post_meta( $post_id, 'lc_swp_meta_custom_video');
    }

}
add_action('save_post', 'ARTEMIS_SWP_custom_video_save');

function ARTEMIS_SWP_blog_settings_meta_save($post_id) {
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if ($is_autosave || $is_revision) {
		return;
	}
	
	if(isset($_POST['lc_swp_meta_blog_layout'])) {
		update_post_meta($post_id, 'lc_swp_meta_blog_layout', trim($_POST['lc_swp_meta_blog_layout'])) ;
	}
	if(isset($_POST['lc_swp_meta_blog_centering'])) {
		update_post_meta($post_id, 'lc_swp_meta_blog_centering', trim($_POST['lc_swp_meta_blog_centering'])) ;
	}
}
add_action('save_post', 'ARTEMIS_SWP_blog_settings_meta_save');

/* 
|--------------------------------------------------------------------------
| ENQUEUE JS SCRIPTS
| js_swp_custom_bg_meta.JS - opens media gallery
|--------------------------------------------------------------------------
*/
function ARTEMIS_SWP_custom_bg_script() {
    global $typenow;
    if (($typenow == 'page') || ($typenow == 'post') || ($typenow == 'product') ) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'js_swp_custom_bg_meta', plugin_dir_url( __FILE__ ) . '/js/js_swp_custom_bg_meta.js', array( 'jquery', 'alpha_color_picker'), null, true);
        wp_enqueue_script( 'js_swp_custom_bg_meta' );
    }
}
add_action( 'admin_enqueue_scripts', 'ARTEMIS_SWP_custom_bg_script' );


/*
	UTILITIES
*/
function ARTEMIS_SWP_is_archive_like($page_template) {
	if ('template-blog.php' == $page_template) {
		return true;
	}
	
	return false;
}

/**
 * PRODUCT CATEGORY META BOXES
 */
add_action('product_cat_add_form_fields', 'ARTEMIS_SWP_add_category_fields');
add_action('product_cat_edit_form_fields', 'ARTEMIS_SWP_edit_category_fields', 10);
add_action('created_term', 'ARTEMIS_SWP_save_category_fields', 10, 3);
add_action('edit_term', 'ARTEMIS_SWP_save_category_fields', 10, 3);

function ARTEMIS_SWP_add_category_fields()
{
    ?>
    <div class="form-field term-display-type-wrap">
        <label for="at_swp_color_scheme"><?php esc_html_e('Heading Color Scheme', 'artemis-swp-core'); ?></label>
        <select id="at_swp_color_scheme" name="at_swp_color_scheme" class="postform">
            <option value="default"><?php esc_html_e('Default', 'artemis-swp-core'); ?></option>
            <option value="black_on_white"><?php esc_html_e('Black on White', 'artemis-swp-core'); ?></option>
            <option value="white_on_black"><?php esc_html_e('White on Black', 'artemis-swp-core'); ?></option>
        </select>
    </div>
    <?php
}

function ARTEMIS_SWP_edit_category_fields($term)
{
    $display_type = get_woocommerce_term_meta($term->term_id, 'at_swp_color_scheme', true);
    ?>
    <tr class="form-field">
        <th scope="row"
            valign="top"><label><?php esc_html_e('Heading Color Scheme', 'artemis-swp-core'); ?></label></th>
        <td>
            <select id="at_swp_color_scheme" name="at_swp_color_scheme" class="postform">
                <option value="default" <?php selected('default', $display_type); ?>><?php esc_html_e('Default', 'artemis-swp-core'); ?></option>
                <option value="black_on_white" <?php selected('black_on_white', $display_type); ?>><?php esc_html_e('Black on White', 'artemis-swp-core'); ?></option>
                <option value="white_on_black" <?php selected('white_on_black', $display_type); ?>><?php esc_html_e('White on Black', 'artemis-swp-core'); ?></option>
            </select>
        </td>
    </tr>
    <?php
}

function ARTEMIS_SWP_save_category_fields($term_id, $tt_id = '', $taxonomy = '')
{
    if (isset($_POST['at_swp_color_scheme']) && 'product_cat' === $taxonomy) {
        update_woocommerce_term_meta($term_id, 'at_swp_color_scheme', esc_attr($_POST['at_swp_color_scheme']));
    }
}

/**
 * END PRODUCT CATEGORY META BOXES
 */

?>
