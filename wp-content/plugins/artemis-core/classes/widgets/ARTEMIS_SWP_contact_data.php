<?php
class ARTEMIS_SWP_contact_data extends WP_Widget {
	/* Sets up the widgets name etc */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget widget_artemis_contact_data',
			'description' => esc_html__('Artemis Contact Details', 'artemis-swp-core'),
		);
		parent::__construct('ARTEMIS_SWP_contact_data', 'Artemis Contact Details', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		$allowed_html = array(
			'div'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'li'	=> array(
				'id'	=> array(),
				'class'	=> array()
			),
			'h3'	=> array(
				'id'	=> array(),
				'class'	=> array()
			)
		);

		echo wp_kses($args['before_widget'], $allowed_html);

		if('on' == $instance['replace_title_with_logo']) {
			if (function_exists("ARTEMIS_SWP_get_user_logo_img")) {
				echo wp_kses($args['before_title'], $allowed_html);

				$logo_img = ARTEMIS_SWP_get_user_logo_img();
				if (!empty($logo_img)) {
					?> <img src="<?php echo esc_url($logo_img); ?>" alt="<?php bloginfo('name'); ?>"> <?php
				} else {
					bloginfo('name');
				}

				echo wp_kses($args['after_title'], $allowed_html);
			}
		} else {
			if (!empty($instance['title'])) {
				echo wp_kses($args['before_title'], $allowed_html) . apply_filters('widget_title', $instance['title']) . wp_kses($args['after_title'], $allowed_html);
			}
		}


		$contact_address = $contact_email = $contact_phone = $contact_fax = "";
		if (function_exists("ARTEMIS_SWP_get_contact_address")) {
			$contact_address = ARTEMIS_SWP_get_contact_address();
		}
		if (function_exists("ARTEMIS_SWP_get_contact_email")) {
			$contact_email = ARTEMIS_SWP_get_contact_email();
		}
		if (function_exists("ARTEMIS_SWP_get_contact_phone")) {
			$contact_phone = ARTEMIS_SWP_get_contact_phone();	
		}
		if (function_exists("ARTEMIS_SWP_get_contact_fax")) {
			$contact_fax = ARTEMIS_SWP_get_contact_fax();
		}

		if (!empty($contact_address)) { ?>
		<div class="at_widget_contact contact_address_w_entry">
			<?php echo esc_html($contact_address); ?>
		</div>
		<?php }?>

		<?php if (!empty($contact_phone)) { ?>
		<div class="at_widget_contact">
			<span class="before_w_contact_data">
				<?php echo esc_html__("Phone: ", "artemis-swp-core"); ?>
			</span>
			<?php echo esc_html($contact_phone); ?>
		</div>
		<?php }?>

		<?php if (!empty($contact_fax)) { ?>
		<div class="at_widget_contact">
			<span class="before_w_contact_data">
				<?php echo esc_html__("Fax: ", "artemis-swp-core"); ?>
			</span>
			<?php echo esc_html($contact_fax); ?>
		</div>
		<?php }?>

		<?php if (!empty($contact_email)) { ?>
		<div class="at_widget_contact">
			<span class="before_w_contact_data">
				<?php echo esc_html__("Email: ", "artemis-swp-core"); ?>
			</span>
			<?php echo antispambot(esc_html($contact_email)); ?>
		</div>
		<?php }

		if('on' == $instance['show_social_profiles']) {
			if (function_exists("ARTEMIS_SWP_get_available_social_profiles")) {
				$user_profiles = array();
				$user_profiles = ARTEMIS_SWP_get_available_social_profiles();

				if (!empty($user_profiles)) {
					?> <div class="footer_w_social_icons"> <?php
				}

				foreach ($user_profiles as $social_profile) {
					?>
						<div class="footer_w_social_icon">
							<a href="<?php echo esc_url($social_profile['url']); ?>" target="_blank">
								<i class="fa fa-<?php echo esc_attr($social_profile['icon']); ?>"></i>
							</a>
						</div>
					<?php
				}
				if (!empty($user_profiles)) {
					?> </div> <?php
				}
			}
		}

		echo wp_kses($args['after_widget'], $allowed_html);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		// outputs the options form on admin
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Artemis Store', 'artemis-swp-core');
		$show_social_profiles = isset($instance['show_social_profiles']) && ($instance['show_social_profiles'] ==  'on') ? 'true' : 'false';
		$replace_title_with_logo = isset($instance['replace_title_with_logo']) && ($instance['replace_title_with_logo'] == 'on') ? 'true' : 'false';
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'artemis-swp-core'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">

			<input class="checkbox" type="checkbox" <?php checked($instance['show_social_profiles'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_social_profiles')); ?>" name="<?php echo esc_attr($this->get_field_name('show_social_profiles')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('show_social_profiles')); ?>"><?php esc_attr_e('Show social profiles icons', 'artemis-swp-core'); ?></label><br>
    		
			<input class="checkbox" type="checkbox" <?php checked($instance['replace_title_with_logo'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('replace_title_with_logo')); ?>" name="<?php echo esc_attr($this->get_field_name('replace_title_with_logo')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('replace_title_with_logo')); ?>"><?php esc_attr_e('Replace widget title with logo', 'artemis-swp-core'); ?></label>			
		</p>
		
		<?php 		
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : 'Latest News';
		$instance['show_social_profiles'] = $new_instance['show_social_profiles'];
		$instance['replace_title_with_logo'] = $new_instance['replace_title_with_logo'];

		return $instance;
	}
}