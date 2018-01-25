<?php

	$post_id = get_the_ID();
	$post_bg_image = ARTEMIS_SWP_get_post_bg_image($post_id);
	$post_overlay_color = ARTEMIS_SWP_get_post_overlay_color($post_id);
	$image_source = '';
	
	if (!empty($post_bg_image)) {
		$image_source = $post_bg_image;
	} else {
		$image_source = ARTEMIS_SWP_get_inner_bg_image();
	}

	if (is_404()) {
		if ("background_image" == ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_styling')) {
			$image_source = ARTEMIS_SWP_get_404_bg_image();
			$post_overlay_color = ARTEMIS_SWP_get_theme_option('artemis_theme_general_options', 'lc_404_overlay');
		}
	}

	if (!empty($image_source)) {
	?>
		<div class="canvas_image lc_swp_background_image" data-bgimage="<?php echo esc_url($image_source); ?>"></div>
	<?php
	}

	if (!empty($post_overlay_color)) {
	?>
		<div class="canvas_overlay lc_swp_bg_color" data-color="<?php echo esc_attr($post_overlay_color); ?>"></div>
	<?php
	}

?>