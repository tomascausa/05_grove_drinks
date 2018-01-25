<?php
	
	$post_id 		= ARTEMIS_SWP_get_current_page_id();

	$title			= get_the_title();
	$user_title 	= get_post_meta($post_id, 'lc_swp_meta_page_custom_title', true);
	if (trim($user_title)) {
		$title = $user_title;
	}

	$header_color_theme 	= get_post_meta($post_id, 'lc_swp_meta_heading_color_theme', true);
	$bg_image 		= get_post_meta($post_id, 'lc_swp_meta_heading_bg_image', true);
	$overlay 		= get_post_meta($post_id, 'lc_swp_meta_heading_overlay_color', true);


	$remove_breadcrumbs		= get_post_meta($post_id, 'lc_swp_meta_page_remove_breadc', true);

	$GLOB_color_theme = ARTEMIS_SWP_get_default_color_scheme();
	$has_bg_image_class = "";

	/*special templates*/
	if (is_author() || is_category() || is_archive() || is_home() || is_search()) {
		$bg_image = $overlay = "";
		$header_color_theme = $GLOB_color_theme;

        if (ARTEMIS_SWP_is_woocommerce_active() && is_product_category()) {
            $cat              = $wp_query->get_queried_object();
            $cat_color_scheme = get_woocommerce_term_meta($cat->term_id, 'at_swp_color_scheme', true);
            if ( 'default' != $cat_color_scheme) {
                $header_color_theme = $cat_color_scheme;
            }
        }
	}

	/*404*/
	if (is_404()) {
		$header_color_theme = "";
		$bg_image = "";
		$overlay = 'rgba(0,0,0, 0)';

		$remove_breadcrumbs = 1;
	}

	/*woocommerce pages*/
	if (ARTEMIS_SWP_is_woocommerce_special_page()) {
		$header_color_theme = $GLOB_color_theme;
	}

	/*
		Add css classes
	*/
	$final_color_theme = "";
	if (($header_color_theme != $GLOB_color_theme) && 
		("default_scheme" != $header_color_theme)) {
		$final_color_theme = $header_color_theme;
	}
	
	/*get background image from product category*/
	if ( ARTEMIS_SWP_is_woocommerce_active() && is_product_category()){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
	    $woo_cat_image_url = wp_get_attachment_url($thumbnail_id);
	    if ($woo_cat_image_url) {
		    $bg_image = $woo_cat_image_url;
		}
	}

	/*header background image*/
	$img_overlay_div = '';
	if (!empty($bg_image)) {
		$has_bg_image_class = "header_has_image";
		$data_bgimage = ' data-bgimage="'.esc_url($bg_image).'"';
		$img_overlay_div = '<div class="lc_swp_background_image lc_heading_image_bg"'.$data_bgimage.'></div>';
	}
	
	/*handle overlay*/
	$overlay_div = '';
	if (!empty($overlay)) {
		$overlay_div = '<div class="lc_swp_overlay" data-color="'.esc_attr($overlay).'"></div>';
	}

	/*title for special templates - keep this the latest processed data*/
	if (is_author()) {
		$title = esc_html__('Author: ', "artemis-swp").get_the_author();
	} elseif (is_category()) {
		$title = single_cat_title("", FALSE);
	} elseif (is_archive()) {
		if (is_tax()) {
			/*custom taxonomy*/
			$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
			$title = $term->name;
		} else {
			$title = get_the_time(get_option('date_format'));	
		}
	} elseif (is_home()) {
		$title = esc_html__("Blog", "artemis-swp");
	} elseif (is_search()) {
		$title = get_search_query();
	}

	/*treat separately the shop and product page [[[*/
	if (function_exists("is_shop")) {
		if (is_shop()) {
			$title = woocommerce_page_title(false);
		}
	}
	/*treat separately the shop and product page ]]]*/


	$show_title_on_header = true;
	if (is_single() || is_page_template("default") || is_page_template("template-sidebar.php")) {
		$show_title_on_header = false;

		if (ARTEMIS_SWP_is_woocommerce_active() && is_product()) {
			if ("type_2" == ARTEMIS_SWP_get_product_page_template()) {
				$show_title_on_header = true;		
			}
		}
	}

	$title_align_class = "";
	if ("text_left" == ARTEMIS_SWP_get_titles_alignment_class()) {
		$title_align_class = " show_on_left";
	}

	/*heading width can be different for individual pages/templates*/
	$heading_width = "lc_swp_boxed";
	if (is_page_template('template-blog.php')) {
		$blog_layout			= get_post_meta(get_the_ID(), 'lc_swp_meta_blog_layout', true);
		if ("full_width" == $blog_layout) {
			$heading_width = "lc_swp_full";
		}
	}
	if (function_exists("is_shop")) {
		if (is_shop()) {
			$heading_width = ARTEMIS_SWP_get_shop_width_class();
		}
	}
	if (function_exists("is_product")) {
		if (is_product()) {
			$heading_width = ARTEMIS_SWP_get_product_width_class();
		}
	}
	if (is_page_template("template-visual-composer-header.php")) {
		$heading_width = "lc_swp_full";
	}

?>

<div id="heading_area" class="<?php echo esc_attr($final_color_theme); ?>">
	<?php
		/*image overlay*/
		$allowed_html = array(
			'div'	=> array(
				'id'			=> array(),
				'class'			=> array(),
				'data-bgimage'	=> array(),
				'data-color'	=> array()
			)
		);
		echo wp_kses($img_overlay_div, $allowed_html);

		/*color overlay*/
		echo wp_kses($overlay_div, $allowed_html);

		$allow_title_tags = array(
			'strong'	=> array(),
			'br'		=> array(),
			'i'			=> array(),
			'span'		=> array(
				'class'		=> array()
			)
		);
	?>
	
	<div class="heading_content_container clearfix <?php echo esc_attr($heading_width)." ".esc_attr($has_bg_image_class); ?>">
		<?php if ($show_title_on_header) {?>
		<div class="heading_titles_container">
			<div class="heading_area_title <?php echo esc_attr($title_align_class); ?> <?php echo trim($user_title) ? esc_attr("user_page_title") : ""; ?>">
				<h1> 
					<?php echo wp_kses($title, $allow_title_tags); ?> 
				</h1>
			</div>	
		</div>
		<?php } ?>


		<?php if (!$remove_breadcrumbs) { ?>
			<?php get_template_part('views/utils/breadcrumbs_nav'); ?>
		<?php } ?>
	</div>

	<?php get_template_part('views/utils/cpt_post_meta'); ?>
	<?php /*get_template_part('views/utils/cpt_archive_meta'); */?>
	
</div>
