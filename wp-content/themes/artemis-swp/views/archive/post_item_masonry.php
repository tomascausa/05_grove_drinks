<?php 
	/*
		query var:
			$lc_masonry_brick_class
			$is_cpt_archive - true/false
	*/
	$post_classes = 'post_item ';
	$post_classes .= $lc_masonry_brick_class;
	$item_details_thumb_class = '';

	if (has_post_thumbnail()) {
		$post_classes .= ' has_thumbnail';
	} else {
		$post_classes .= ' no_thumbnail';
		$item_details_thumb_class .= ' no_thumbnail';
	}

	$masonry_excerpt_length = 15;

	$taxonomy_type = 'category';
	$button_text = esc_html__("Read more", "artemis-swp");
	$post_type = get_post_type();
	switch($post_type) {
		case "js_videos":
			$taxonomy_type = "video_category";
			$button_text = esc_html__("Watch video", "artemis-swp");
			break;
		case "js_photo_albums":
			$taxonomy_type = "photo_album_category";
			$button_text = esc_html__("View gallery", "artemis-swp");
			break;
		default:
			break;
	}
?>

<article <?php post_class($post_classes);?>>
	<?php if (has_post_thumbnail()) { ?>
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('full', array('class' => 'lc_masonry_thumbnail_image')); ?>
		</a>

		<div class="brick_cover_bg_image transition4"></div>
		<div class="brick_bg_overlay"></div>
	<?php } ?>

	<div class="post_item_details<?php echo esc_attr($item_details_thumb_class); ?>">
		<a href="<?php the_permalink(); ?>">
			<h2 class="lc_post_title transition4 masonry_post_title">
				<?php the_title(); ?>
			</h2>
		</a>

		<div class="post_item_meta lc_post_meta masonry_post_meta">
			<?php 
			if(!$is_cpt_archive) {
				echo get_the_date(get_option('date_format'));
			}
			?>

			<?php 
			if(!$is_cpt_archive) {
				echo esc_html__('by', 'artemis-swp'); 
				?>
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
					<?php the_author(); ?>
				</a>
			<?php
			}


			if (has_term('', $taxonomy_type)) {
				if(!$is_cpt_archive) {
					echo esc_html__('in&nbsp;', 'artemis-swp');
				}
				the_terms('', $taxonomy_type, '', ' &#8901; ', '');
			}
			?>
		</div>

		<?php if(!$is_cpt_archive) { ?>
		<div class="lc_post_excerpt">
			<?php
				$default_excerpt = get_the_excerpt();
				echo "<p>".wp_trim_words($default_excerpt, $masonry_excerpt_length)."</p>";
			?>
		</div>
		<?php } ?>

		<?php if(!$is_cpt_archive) { ?>
		<div class="lc_button">
			<a href="<?php the_permalink(); ?>">
				<?php echo esc_html($button_text); ?>
			</a>
		</div>
		<?php } ?>

	</div>
</article>