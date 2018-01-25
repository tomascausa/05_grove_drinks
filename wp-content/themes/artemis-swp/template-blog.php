<?php
/*
	Template Name: Blog
*/
?>

<?php get_header(); ?>

<?php
	/*get archive page settings here*/
	$blog_layout			= get_post_meta(get_the_ID(), 'lc_swp_meta_blog_layout', true);
	$center_content			= get_post_meta(get_the_ID(), 'lc_swp_meta_blog_centering', true);


	/*create the query*/
	if (get_query_var('paged')) {
		$paged = get_query_var('paged'); 
	} elseif (get_query_var('page')) { 
		$paged = get_query_var('page'); 
	} else {
		$paged = 1; 
	}

	$posts_per_page = get_option('posts_per_page');
	$offset = ($paged - 1) * $posts_per_page;

	$args = array(
		'numberposts'	=> -1,
		'posts_per_page'   => $posts_per_page,
		'paged'			   => $paged,
		'offset'           => $offset,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => array('post'/*, 'js_videos', 'js_photo_albums'*/),
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);

	$keep_old_wp_query = $wp_query;

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	?>

	<?php
	$center_css_class = ("left" == $center_content) ? "text_left" : "text_center";
	$container_class = 'lc_blog_masonry_container blog_container';
	$gap_width = 30;
	$bricks_on_row = 3;
	if ("full_width" == $blog_layout) {
		$container_class .= " lc_swp_full";
		$bricks_on_row = 4;
		$gap_width = 60;
	} else {
		$container_class .= " lc_swp_boxed";
	}

	set_query_var('lc_masonry_brick_class', 'lc_blog_masonry_brick');
	set_query_var('centering_css_class', $center_css_class);

	if ($wp_query->have_posts()) {
		?>
		<div class="<?php echo esc_attr($container_class); ?>" data-gapwidth="<?php echo esc_attr($gap_width); ?>" data-bricksonrow="<?php echo esc_attr($bricks_on_row); ?>">
			<?php
			while ($wp_query->have_posts()) : the_post();
					get_template_part('views/archive/blog_masonry');
			endwhile;
			?>
		</div>
		<div class="page_navigation">
			<span class="page_nav_item">
				<?php next_posts_link('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> Older posts'); ?>
			</span>
			<span class="page_nav_item">
				<?php previous_posts_link('Newer posts <i class="fa fa-long-arrow-right" aria-hidden="true"></i>'); ?>
			</span>
		</div>		
		<?php
	} else { ?>

		<div class="lc_swp_boxed lc_basic_content_padding">
			<p><?php esc_html__('Sorry, no posts matched your criteria.', 'artemis-swp'); ?></p>
		</div>

	<?php 
	}

	$wp_query = null; $wp_query = $keep_old_wp_query;
?>


<?php get_footer(); ?>