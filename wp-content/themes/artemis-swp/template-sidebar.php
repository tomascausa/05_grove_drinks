<?php
/*
	Template Name: Page With Sidebar
*/
?>

<?php get_header(); ?>

<div class="lc_content_full lc_swp_boxed">
	<div class="lc_content_with_sidebar lc_basic_content_padding">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php
			$has_thumbnail_class = "";
			if(has_post_thumbnail()) {
				$has_thumbnail_class = "has_thumbnail";
				the_post_thumbnail('full');
			}
			?>
			<div class="single_post_title <?php echo esc_attr(ARTEMIS_SWP_get_titles_alignment_class())." ".esc_attr($has_thumbnail_class); ?>">
				<h1> <?php the_title(); ?> </h1>
			</div>

			<div class="standard_page_content">
				<?php the_content(); ?>
			</div>
			
			<?php get_template_part('views/utils/sharing_icons'); ?>
		<?php endwhile; else : ?>
			<p><?php esc_html__('Sorry, no posts matched your criteria.', 'artemis-swp'); ?></p>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>

</div>
<?php get_footer(); ?>