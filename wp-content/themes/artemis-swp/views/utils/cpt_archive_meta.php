<?php
/*
	NOT AVAILABLE
*/


	/*only for archive pages*/
	$templates_to_match = array(
		'template-events-all.php',
		'template-events-past.php',
		'template-events-upcoming.php',
		'template-photo-gallery.php'
	);
	if (is_page_template($templates_to_match)) {
		$tax_name = ARTEMIS_SWP_get_tax_name_by_page_template(basename(get_page_template()));

		$args = array('taxonomy' =>  $tax_name);
		$terms = get_terms($args);

		if (count($terms) > 0) {
			?>

			<div class="lc_post_meta lc_cpt_category cpt_post_meta lc_swp_full">
				<span class="meta_entry lc_cpt_category archive_cpt_category">
					<?php
					foreach($terms as $term) {
						$term_url = get_term_link($term);
						?>

						<a href="<?php echo esc_url($term_url); ?>">
							<?php echo esc_html($term->name); ?>
						</a>

						<?php
					} /*foreach*/
					?>	
				</span>
			</div>

			<?php
		}
	}

?>