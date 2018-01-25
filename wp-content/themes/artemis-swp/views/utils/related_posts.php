<?php

$cats = get_the_category();
$str_cats = array();
foreach ($cats as $category) {
	$str_cats[] = $category->term_id;
}

$args = array(
	'posts_per_page'	=> 3,
	'offset'           	=> 0,
	'category'         	=> $str_cats
);
$related_posts = get_posts($args);

if (count($related_posts) > 0) {
	?>

	<div class="at_related_posts">
		<h3 class="related_posts_title <?php echo esc_attr(ARTEMIS_SWP_get_titles_alignment_class()); ?>">
			<?php echo esc_html__("Related Articles", "artemis-swp"); ?>
		</h3>

		<div class="posts_display three_cols clearfix">
			<?php 
			foreach ($related_posts as $single_post) {
				$currentID = $single_post->ID;
				$postAuthorID = $single_post->post_author;
				$has_thumbnail_class = " has_thumbnail";
				if (!has_post_thumbnail($currentID)) {
					$has_thumbnail_class = " no_thumbnail";
				}
				?> 
				<div class="one_of_three<?php echo esc_attr($has_thumbnail_class); ?>">
					<?php
					if (has_post_thumbnail($currentID)) {
						$post_thumbnail_id = get_post_thumbnail_id($currentID);
						$image_attributes = wp_get_attachment_image_src($post_thumbnail_id, 'full');
						?>
						<div class="featured_image_container_parent">
							<div class="featured_image_container has_image lc_swp_background_image transition4" data-bgimage="<?php echo esc_attr($image_attributes[0]); ?>">
							</div>
						</div>
						<?php
					}
					?>

					<?php 
					if (!has_post_thumbnail($currentID)) {
						echo '<div class="featured_image_container">';
					}
					?>

					<div class="related_details">

						<div class="related_meta">
							<span class="meta_entry"><?php echo get_the_date('', $currentID); ?></span>
							<?php echo esc_html__('&#124;&#32;by&#32;', 'artemis-swp'); ?>
							<a href="<?php echo esc_attr(get_author_posts_url($postAuthorID)); ?>">
								<?php echo get_the_author_meta('user_nicename', $postAuthorID); ?>
							</a>
						</div>

						<h4 class="related_title">
							<a href="<?php echo esc_attr(get_the_permalink($currentID)); ?>"><?php echo esc_html(get_the_title($currentID)); ?></a>
						</h4>
					</div>

					<?php 
					if (!has_post_thumbnail($currentID)) {
						echo '</div>';
					}
					?>
				</div> 
				<?php
			}
			wp_reset_postdata();
			?>
		</div>
	</div>

	<?php	
}
?>