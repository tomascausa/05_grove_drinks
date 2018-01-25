<?php
	if (ARTEMIS_SWP_is_back_to_top_enabled()) {
		$color_scheme = ARTEMIS_SWP_get_default_color_scheme();
		?>
		<div class="lc_back_to_top_btn <?php echo esc_attr($color_scheme); ?>">
			<i class="fa fa-angle-up transition3" aria-hidden="true"></i>
		</div>

		<?php	
	}
?>
