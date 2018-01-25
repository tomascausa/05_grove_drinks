<?php 

	/*check if footer widgets are allowed from the post meta*/
	$remove_footer = "";
	if (is_author() || is_category() || is_archive() || is_home() || is_search() || is_404()) {
		/*default templates have footer by default*/
		$remove_footer = "0";
	} else {
		/*get option from page/post meta*/
		$post_id 		= get_the_ID();
		$remove_footer	= get_post_meta($post_id, 'lc_swp_meta_page_remove_footer', true);
		if (empty($remove_footer)) {
			$remove_footer = "0";
		}
	}

	if ("0" == $remove_footer) {
		$header_width = ARTEMIS_SWP_get_header_footer_width();
		$header_width = 'lc_swp_'.$header_width; /*lc_swp_full/lc_swp_boxed*/

		$bg_color = ARTEMIS_SWP_get_footer_bg_color();
		$bg_image = esc_url(ARTEMIS_SWP_get_footer_bg_image());
		$color_scheme = ARTEMIS_SWP_get_footer_color_scheme();

		if ( is_active_sidebar('footer-sidebar-1') || 
			is_active_sidebar('footer-sidebar-2') ||
			is_active_sidebar( 'footer-sidebar-3') ||
			is_active_sidebar( 'footer-sidebar-4' )) {
				?>
				<div id="footer_sidebars">
					<div id="footer_sidebars_inner" class="clearfix <?php echo esc_attr($header_width); ?>">
						<div id="footer_sidebar1" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-1')) {
						 		dynamic_sidebar('footer-sidebar-1');
						 	}
							?>
						</div>

						<div id="footer_sidebar2" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-2')) {
						 		dynamic_sidebar('footer-sidebar-2');
						 	}
							?>
						</div>

						<div id="footer_sidebar3" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-3')) {
						 		dynamic_sidebar('footer-sidebar-3');
						 	}
							?>
						</div>

						<div id="footer_sidebar4" class="lc_footer_sidebar <?php echo esc_attr($color_scheme); ?>">
							<?php 
						 	if (is_active_sidebar('footer-sidebar-4')) {
						 		dynamic_sidebar('footer-sidebar-4');
						 	}
							?>
						</div>
					</div>

					<?php
					if (!empty($bg_color)) {
					?>
						<div class="lc_swp_overlay footer_widget_overlay" data-color="<?php echo esc_attr($bg_color); ?>">
						</div>
					<?php
					}

					if (!empty($bg_image)) {
					?>
						<div class="lc_swp_image_overlay lc_swp_background_image" data-bgimage="<?php echo esc_attr($bg_image); ?>">
						</div>
					<?php
					}
					?>
				</div>

				<?php
		}
	} /*if not remove footer widgets*/

	$copyrigth_text = ARTEMIS_SWP_get_copyrigth_text();
	$copy_bgc = ARTEMIS_SWP_get_copyright_bgc();
	$copy_cs = ARTEMIS_SWP_get_copyrigth_color_scheme();
	$user_profiles = array();
	$user_profiles = ARTEMIS_SWP_get_available_social_profiles();
	$header_width = ARTEMIS_SWP_get_header_footer_width();
	$header_width = 'lc_swp_'.$header_width; /*lc_swp_full/lc_swp_boxed*/	

	if (!empty($copyrigth_text)) {
		?> <div class="lc_copy_area clearfix lc_swp_bg_color <?php echo esc_attr($copy_cs).' '.esc_attr($header_width); ?>" data-color="<?php echo esc_attr($copy_bgc); ?>"> <?php

			if (ARTEMIS_SWP_have_social_on_copyright() && !empty($user_profiles)) {
				?>
				<div class="one_of_two text_left">
					<a class="transition4" href="<?php echo esc_url(ARTEMIS_SWP_get_copyrigth_url()); ?>"><?php echo esc_html($copyrigth_text); ?></a>
				</div>

				<div class="two_of_two text_right">
					<div class="footer_w_social_icons copy_area_icons"> <?php
						foreach ($user_profiles as $social_profile) {
							?>
							<div class="footer_w_social_icon copy_area_social_icon">
								<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
									<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
								</a>
							</div>
							<?php
						}
						?>
					</div>
				</div>	
				<?php
			} else {
				?> <a class="transition4" href="<?php echo esc_url(ARTEMIS_SWP_get_copyrigth_url()); ?>"><?php echo esc_html($copyrigth_text); ?></a> <?php
			}

		?> </div> <?php
	}
 ?>