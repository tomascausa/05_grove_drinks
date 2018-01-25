<?php

$post_id = get_the_ID();
$post_type = get_post_type($post_id);
$taxonomy_name = ARTEMIS_SWP_get_tax_name_by_post_type($post_type);


if (!empty($post_id) && is_single($post_id)) {
	$post = $auth = get_post($post_id);
	$auth_id = $auth->post_author;

	if ('post' == $post_type) { ?>
		
			<div class="lc_post_meta">
				<span class="meta_entry swp_post_date_meta"><?php echo get_the_date('', $post_id); ?></span>
				<span class="meta_entry author_meta">
					<?php echo esc_html__('&#32;&#124; by', 'artemis-swp'); ?>
					<a href="<?php echo get_author_posts_url($auth_id); ?>">
						<?php echo get_the_author_meta('user_nicename', $auth_id); ?>
					</a>
				</span>
				<span class="meta_entry swp_post_cat_meta">
					<?php echo esc_html__('&#124; In ', 'artemis-swp'); the_category('&#8901;'); ?>
				</span>
			</div>

	<?php }?>
<?php 
}
?>


