<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<div class="page_not_found">
		<div class="pnf_text">
			<?php
			$addClass = '';
			$dataImage = '';
            $bg_image = '';
			if (ARTEMIS_SWP_has_404_image_over_text()) {
				$bg_image = esc_url(ARTEMIS_SWP_get_404_bg_image());
				if (strlen($bg_image)) {
					$addClass = "swp_image_over_text";
				}
			}
			?>
			<h3 class="<?php echo esc_attr($addClass); ?>" data-bgimage="<?php echo esc_attr($bg_image); ?>">
				<?php echo esc_html__("404", "artemis-swp"); ?>
			</h3>

			<h4 class="pnf_text">
				<?php echo esc_html__("Page not found", "artemis-swp"); ?>					
			</h4>
			
			<div class="pnf_text_simple">
				<?php echo esc_html__("The page you are looking for does not exists", "artemis-swp"); ?>
			</div>

			<a href="<?php echo esc_url(get_home_url('/')); ?>" class="artemis_link">
				<?php echo esc_html__("Please return to homepage", "artemis-swp"); ?>
			</a>	
		</div>
	</div>
</div>
<?php get_footer(); ?>