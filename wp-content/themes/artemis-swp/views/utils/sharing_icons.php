<?php
	$permalink = get_permalink();
	$title = get_the_title();
	$image = '';
	if(function_exists('the_post_thumbnail')) {
			$image =  wp_get_attachment_url(get_post_thumbnail_id());
	}


	if (ARTEMIS_SWP_is_sharing_visible()) {
		?>

		<div class="lc_sharing_icons">
			<p class="lc_share_item_text"><?php echo esc_html__('Share via:', 'artemis-swp')?></p>

			<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(esc_url($permalink)) . '&amp;t='.urlencode($title); ?>" target="_blank" class="lc_share_item">
				<i class="fa fa-facebook" aria-hidden="true"></i>
			</a>

			<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(esc_url($permalink)); ?>" target="_blank" class="lc_share_item">
				<i class="fa fa-twitter" aria-hidden="true"></i>
			</a>	

			<a href="https://plus.google.com/share?url=<?php echo urlencode(esc_url($permalink)); ?>" target="_blank" class="lc_share_item">
				<i class="fa fa-google-plus" aria-hidden="true"></i>
			</a>	

			<?php /*if (!empty($image)) {?>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($permalink).'&amp;media='.$image; ?>" target="_blank" class="lc_share_item">
				<i class="fa fa-pinterest-p" aria-hidden="true"></i>
			</a>
			<?php } */?>
		</div>

		<?php
	} /*show_sharing_icons*/
?>