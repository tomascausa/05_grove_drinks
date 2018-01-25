<?php
/*
	Template Name: Page Contact
*/
?>

<?php get_header(); ?>

<?php
	$remove_map	= get_post_meta(get_the_ID(), 'lc_swp_meta_page_remove_contact_map', true);
	$contact_address = ARTEMIS_SWP_get_contact_address();
	$contact_email = ARTEMIS_SWP_get_contact_email();
	$contact_phone = ARTEMIS_SWP_get_contact_phone();
	$contact_fax = ARTEMIS_SWP_get_contact_fax();

	$allowed_tags = array(
		'strong' => array()
	);

	$visit_us_msg = wp_kses(__("Visit <strong>Us</strong>", "artemis-swp"), $allowed_tags);
	$call_us_msg = wp_kses(__("Call <strong>Us</strong>", "artemis-swp"), $allowed_tags);
	$email_msg = wp_kses(__("Email", "artemis-swp"), $allowed_tags); 

?>

<div class="lc_content_full lc_swp_boxed lc_basic_content_padding">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="lc_template_user_content">
			<?php the_content(); ?>
		</div>
	<?php endwhile; endif; ?>


	<div class="at_contact_details clearfix">
		<div class="one_of_three at_cf_detail_rl">
			<div class="reverse_letter_with_text clearfix">
				<div class="rev_rotate_letter"> <?php echo esc_html(substr($visit_us_msg, 0, 1)); ?> </div>
				<div class="reverse_letter_with_text_content">
					<h4 class="text_uppercase"> <?php echo wp_kses($visit_us_msg, $allowed_tags); ?> </h4>
						<i class="fa fa-map-marker before_at_cf_detail" aria-hidden="true"></i>
						<span class="at_first_color">
							<strong>
								<?php echo antispambot(esc_html($contact_address)); ?>
							</strong>
						</span>
				</div>
			</div>
		</div>

		<div class="one_of_three at_cf_detail_rl">
			<div class="reverse_letter_with_text clearfix">
				<div class="rev_rotate_letter"> <?php echo esc_html(substr($call_us_msg, 0, 1)); ?> </div>
				<div class="reverse_letter_with_text_content">
					<h4 class="text_uppercase"> <?php echo wp_kses($call_us_msg, $allowed_tags); ?> </h4>
					<i class="fa fa-phone before_at_cf_detail" aria-hidden="true"></i>
					<?php echo esc_html($contact_phone); ?>
				</div>
			</div>		
		</div>

		<div class="one_of_three at_cf_detail_rl">
			<div class="reverse_letter_with_text clearfix">
				<div class="rev_rotate_letter"> <?php echo esc_html(substr($email_msg, 0, 1)); ?> </div>
				<div class="reverse_letter_with_text_content">
					<h4 class="text_uppercase"> <?php echo esc_html($email_msg); ?> </h4>
					<i class="fa fa-envelope-o before_at_cf_detail" aria-hidden="true"></i>
					<?php echo esc_html($contact_email); ?>
					<div class="at_contact_social">
						<?php get_template_part('views/utils/social_profiles'); ?>
					</div>	
				</div>
			</div>		
		</div>
	</div>

	<div class="at_cf_in_template">
		<?php get_template_part('views/utils/ajax_contact_form'); ?>
	</div>
</div>

<?php if (strlen($contact_address) && !($remove_map)) { ?>

	<div class="full_container_no_padding at_cf_map full_grayscale map_on_contact_template">
		<?php 
			$protocol = is_ssl() ? 'https' : 'http';
			$map_url = $protocol . "://www.google.com/maps?q=" . implode('+',explode(' ', $contact_address));
			$embedded_map = '<iframe src="' . $map_url . '&output=embed" frameborder="0" height="600"></iframe>';
			
			$allowed_tags = array(
				'iframe' => array(
					'src'		=> array(),
					'width'		=> array(),
					'height'	=> array()
				)
			);

			echo wp_kses($embedded_map, $allowed_tags);
		?>
	</div>

<?php } ?>

<?php get_footer(); ?>