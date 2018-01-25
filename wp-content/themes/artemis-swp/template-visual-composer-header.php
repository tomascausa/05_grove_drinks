<?php
/*
	Template Name: Visual Composer Empty Template With Header
*/
?>

<?php get_header(); ?>

<?php
	if (have_posts()) : while (have_posts()) : the_post(); 
		the_content();
	endwhile; endif;
?>

<?php get_footer(); ?>