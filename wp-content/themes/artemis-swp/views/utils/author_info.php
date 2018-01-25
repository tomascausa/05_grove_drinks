<div class="author_info_left">
	<div class="avatar_image">
		<?php echo get_avatar(get_the_author_meta("ID"), 100); ?>
	</div>

	<div class="author_name">
		<?php 
			$first_name = get_the_author_meta("first_name");
			$last_name = get_the_author_meta("last_name");
			
			if (strlen($first_name) || strlen($last_name)) {
				echo esc_html($first_name.' '.$last_name);
			} else {
				$nickname = get_the_author_meta("nickname");
				echo esc_html($nickname);
			}
		?>
	</div>
</div>