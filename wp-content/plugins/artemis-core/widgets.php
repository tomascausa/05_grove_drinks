<?php

require_once( CDIR_PATH."/classes/widgets/ARTEMIS_SWP_recent_posts_with_images.php");
require_once( CDIR_PATH."/classes/widgets/ARTEMIS_SWP_contact_data.php");

add_action('widgets_init', function(){
	register_widget('ARTEMIS_SWP_recent_posts_with_images');
	register_widget('ARTEMIS_SWP_contact_data');
});

?>