<?php
	/*
		query var:
			$lc_masonry_brick_class
			$centering_css_class: text_left | text_center
	*/
	$post_classes = 'post_item ';
	$post_classes .= $lc_masonry_brick_class;
	$thumbnail_class= "";

	if (has_post_thumbnail()) {
		$thumbnail_class = ' has_thumbnail';
	} else {
		$thumbnail_class = ' no_thumbnail';
	}

	$post_classes .= $thumbnail_class;
	$masonry_excerpt_length = 350;
?>

<article <?php post_class($post_classes);?>>
		<?php if (has_post_thumbnail()) { ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('full', array('class' => 'lc_masonry_thumbnail_image')); ?>
			</a>
		<?php } ?>

	<div class="post_item_details<?php echo esc_attr($thumbnail_class)." ".esc_attr($centering_css_class); ?>">
		<div class="post_item_meta lc_post_meta masonry_post_meta">
			<?php 
				echo get_the_date(get_option('date_format'));
			?>

			<span class="blog_meta_entry author_meta">
			<?php 
				echo esc_html__('&#32;&#124; by', 'artemis-swp'); 
			?>
			<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
				<?php the_author(); ?>
			</a>
			</span>
		</div>

		<a href="<?php the_permalink(); ?>">
			<h2 class="lc_post_title transition4 masonry_post_title">
				<?php the_title(); ?>
			</h2>
		</a>

		<div class="lc_post_excerpt">
			<?php
				$default_excerpt = get_the_excerpt();
				echo "<p>".wp_trim_words($default_excerpt, $masonry_excerpt_length)."</p>";
			?>
		</div>

		<div class="masonry_read_more artemis_link">
			<a href="<?php the_permalink(); ?>">
				<?php echo esc_html__("Read more", "artemis-swp"); ?>
			</a>
		</div>

	</div>
</article>