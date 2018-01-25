<?php
class ARTEMIS_SWP_recent_posts_with_images extends WP_Widget {
	/* Sets up the widgets name etc */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget widget_artemis_recent_posts widget_recent_entries',
			'description' => esc_html__('Recent Posts With Images', 'artemis-swp-core'),
		);
		parent::__construct('ARTEMIS_SWP_recent_posts_with_images', 'Artemis Recent Posts', $widget_ops);
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
		if (!empty($instance['title'])) {
			echo wp_kses($args['before_title'], $allowed_html) . apply_filters('widget_title', $instance['title']) . wp_kses($args['after_title'], $allowed_html);
		}
		
		$number_of_posts = intval(isset($instance['number_of_posts']) ? $instance['number_of_posts'] : 5);
		$query_args = array(
			'post_type' 	=> 'post',
			'post_status'   => 'publish',
			'numberposts'	=> $number_of_posts,
			'posts_per_page'=> $number_of_posts,
			'orderby'       => 'post_date',
			'order'         => 'DESC'
		);
		
		$my_query = new WP_Query($query_args);
		if ($my_query->have_posts()) {
			echo '<ul>';
			while ($my_query->have_posts()) {
				$my_query->the_post();
				?>
				<li class="clearfix">
					<?php 
					if(has_post_thumbnail()) {
						the_post_thumbnail(array(50,50));
					} else {
						/*add default*/
						?>
						<div class="lnwidtget_no_featured_img">
							<?php bloginfo('name'); ?>
						</div>
						<?php
					}
					?>

					<a href="<?php esc_url(the_permalink()); ?>" class="at_related_posts_title">
						<?php echo esc_html(get_the_title()); ?>
					</a>
					<span class="post-date"><?php echo esc_html(get_the_date()); ?></span>
				</li>
				<?php
			}
			echo '</ul>';
			/* Restore original Post Data */
			wp_reset_postdata();
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
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('Latest News', 'artemis-swp-core');
		$number_of_posts = !empty($instance['number_of_posts']) ? intval($instance['number_of_posts']) : '5';
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'artemis-swp-core'); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
			
			<label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>"><?php esc_attr_e('Number of posts:', 'artemis-swp-core'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr(intval($number_of_posts)); ?>">
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
		$instance['number_of_posts'] = (!empty($new_instance['number_of_posts'])) ? intval(($new_instance['number_of_posts'])) : '5';

		return $instance;
	}
}