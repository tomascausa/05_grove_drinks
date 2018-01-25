<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<?php if (ARTEMIS_SWP_has_sidebar_on_single()) { ?> 
		<div class="lc_content_with_sidebar">
	<?php } ?>

		<?php
		$has_thumbnail_class = "";
		if(has_post_thumbnail()) {
			$has_thumbnail_class = "has_thumbnail";
			the_post_thumbnail('full', array('class' => 'aligncenter attachment-full size-full wp-post-image'));
		}
		?>	

		<div class="single_post_title <?php echo esc_attr(ARTEMIS_SWP_get_titles_alignment_class())." ".esc_attr($has_thumbnail_class); ?>">
			<h1> <?php the_title(); ?> </h1>
			<?php get_template_part('views/utils/post_meta');  ?>
		</div>

		<div class="clearfix">
			<div class="post_content_left">
				<?php get_template_part('views/utils/sharing_icons'); ?>
				<?php get_template_part('views/utils/author_info'); ?>
			</div>
			<div class="post_content_right">
				<?php the_content(); ?>
				<?php get_template_part('views/utils/post_tags'); ?>
			</div>
		</div>

		<?php 
		$args = array(
			'before'           => '<div class="pagination_links">' . esc_html__('Pages:', 'artemis-swp'),
			'after'            => '</div>',
			'link_before'      => '<span class="pagination_link">',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'nextpagelink'     => esc_html__('Next page', 'artemis-swp'),
			'previouspagelink' => esc_html__('Previous page', 'artemis-swp'),
			'pagelink'         => '%',
			'echo'             => 1
		); 
		?>
		<?php wp_link_pages( $args ); ?>

		
		
		<?php get_template_part('views/utils/related_posts'); ?>
		<?php comments_template(); ?>

	<?php if (ARTEMIS_SWP_has_sidebar_on_single()) { ?>
	</div>
	<?php } ?>

	<?php 
		if (ARTEMIS_SWP_has_sidebar_on_single()) {
			get_sidebar(); 	
		}
	?>
</div>