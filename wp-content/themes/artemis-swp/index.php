<?php get_header(); ?>


	<?php 
		$container_class = 'lc_swp_boxed lc_blog_masonry_container blog_container'; 
		$gap_width = 30;
		$bricks_on_row = 3;
	?>

	<?php if (have_posts()) : ?> 
		<div class="<?php echo esc_attr($container_class); ?>" data-gapwidth="<?php echo esc_attr($gap_width); ?>" data-bricksonrow="<?php echo esc_attr($bricks_on_row); ?>">
			<?php while (have_posts()) : the_post(); ?>
				<?php
				set_query_var('lc_masonry_brick_class', 'lc_blog_masonry_brick');
				set_query_var('centering_css_class', "text_center");
				?>

				<?php get_template_part('views/archive/blog_masonry');?>

			<?php endwhile; ?>
		</div>
		<div class="page_navigation">
			<span class="page_nav_item">
				<?php next_posts_link('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> Older posts'); ?>
			</span>
			<span class="page_nav_item">
				<?php previous_posts_link('Newer posts <i class="fa fa-long-arrow-right" aria-hidden="true"></i>'); ?>
			</span>
		</div>
	<?php else :
			?>
			<div class="lc_swp_boxed">
				<?php
				if (is_search()) {
					echo '<p>'.esc_html__('Sorry, no results were found matching your search criteria. Please try something else.', 'artemis-swp').'</p>';
				} else {
					echo '<p>'.esc_html__('Sorry, no posts matched your criteria.', 'artemis-swp').'</p>';
				}
				?>
			</div>
			<?php
			
	endif; ?>

<?php get_footer(); ?>