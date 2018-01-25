<?php
	$input_position_class = "vc_lc_element three_on_row three_on_row_layout";
	$center_button_class = "text_center";
?>

<div class="artemis_contactform">
	<form class="artemis_contactform">						
		<ul class="contactform_fields">

			<li class="comment-form-author artemis_cf_entry <?php echo esc_attr($input_position_class); ?>">
				<input type="text" placeholder="<?php echo esc_html__('Your Name ', 'artemis-swp'); ?>" name="contactName" id="contactName" class="artemis_cf_input required requiredField contactNameInput" />
				<div class="artemis_cf_error"><?php echo esc_html__('Please enter your name', 'artemis-swp'); ?></div>
			</li>

			<li class="comment-form-email artemis_cf_entry <?php echo esc_attr($input_position_class); ?>">
				<input type="text" placeholder="<?php echo esc_html__('Email ', 'artemis-swp'); ?>" name="email" id="contactemail" class="artemis_cf_input required requiredField email" />
				<div class="artemis_cf_error"><?php echo esc_html__('Please enter a correct email address', 'artemis-swp'); ?></div>
			</li>

			<li class="comment-form-url artemis_cf_entry <?php echo esc_attr($input_position_class); ?>">
				<input type="text" placeholder="<?php echo esc_html__('Phone ', 'artemis-swp'); ?>" name="phone" id="phone" class="artemis_cf_input" />
			</li>

			<li class="comment-form-comment artemis_cf_entry vc_lc_element">
				<textarea name="comments" placeholder="<?php echo esc_html__('Message ', 'artemis-swp'); ?>" id="commentsText" rows="10" cols="30" class="artemis_cf_input required requiredField contactMessageInput"></textarea>
				<div class="artemis_cf_error"><?php echo esc_html__('Please enter a message', 'artemis-swp'); ?></div>
			</li>
			<?php
			/*
			//TODO: add recaptcha error here
			<li class="captcha_error">
				<span class="error"><?php echo esc_html__('Incorrect reCaptcha. Please enter reCaptcha challenge;', 'artemis-swp'); ?></span>
			</li>
			*/
			?>
			<li class="wp_mail_error">
				<div class="artemis_cf_error"><?php echo esc_html__('Cannot send mail, an error occurred while delivering this message. Please try again later.', 'artemis-swp'); ?></div>
			</li>	

			<li class="formResultOK">
				<div class="artemis_cf_error"><?php echo esc_html__('Your message was sent successfully. Thanks!', 'artemis-swp'); ?></div>
			</li>
			<?php /*TODO: add recaptcha */?>
			<li class="<?php echo esc_attr($center_button_class); ?>">
				<input name="Button1" type="submit" id="submit" class="lc_button" value="<?php echo esc_html__('Send', 'artemis-swp'); ?>" >
				<?php /*<div class="progressAction"><img src="<?php echo get_template_directory_uri()."/images/progress.gif"; ?>"></div> */ ?>
			</li>

		</ul>
		<input type="hidden" name="action" value="artemiscontactform_action" />
		<?php wp_nonce_field('artemiscontactform_action', 'contactform_nonce'); /*wp_nonce_field('artemiscontactform_action', 'contactform_nonce', true, false); */?>
	</form>
</div>