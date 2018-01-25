<?php

/*
	Create menu entry
*/
function ARTEMIS_SWP_AC_menu_entry() {    
	add_options_page("Artemis Core Settings", "Artemis Core Settings", "manage_options", "Artemis-Core-Post-Types-Settings", "ARTEMIS_SWP_AC_output_content");
}
add_action('admin_menu', 'ARTEMIS_SWP_AC_menu_entry');


/*
	Callback renders options content
*/
function ARTEMIS_SWP_AC_output_content()
{
?> 
	<!-- Create a header in the default WordPress 'wrap' container -->      
	<div class="wrap">
		<!-- Add the icon to the page -->          
		<h2>Artemis Core Plugin Settings</h2>				 
		
		<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->          
		<?php settings_errors(); ?> 				       
		
		<!-- Create the form that will be used to render our options -->
		<form method="post" action="options.php"> 			
			<?php   			
			settings_fields( 'AC_plugin_options' );  		
			do_settings_sections( 'AC_plugin_options' );						
			submit_button(); 			
			?>        
		</form>  
	
	</div>
 <?php
	/* very important call*/
	flush_rewrite_rules();
 }
 
 add_action('admin_init', 'ARTEMIS_SWP_AC_initialize_lmc_options');
 
 function ARTEMIS_SWP_AC_initialize_lmc_options()
 {	
	/* 
		Create plugin options 
	*/
	if( false == get_option( 'AC_plugin_options')) {		
		add_option( 'AC_plugin_options' );	
	}
	 
	/* 
		Create settings section	
	*/
	 add_settings_section(  		
		 'AC_plugin_section',          	/* ID used to identify this section and with which to register options  */		
		 esc_html__('Artemis Core Plugin Settings', 'artemis-swp-core'),                   /* Title to be displayed on the administration page   */		
		 'AC_plugin_options_callback',  	/* Callback used to render the description of the section */		
		 'AC_plugin_options'      			/* Page on which to add this section of options  */	
	 );	
	 
	register_setting(  
		'AC_plugin_options',  		//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'AC_plugin_options',  		// option_name -  The name of an option to sanitize and save. 
		'AC_sanitize_plugin_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);	

 	 
	/*
		Settings fields
	*/
	add_settings_field(           
		'lc_mc_contact_form_email',
		esc_html__('Contact Form E-mail', 'artemis-swp-core'),
		'AC_plugin_options_contact_form_email_callback',
		'AC_plugin_options',
		'AC_plugin_section'
	);	
 }
 
 
 /* 
|--------------------------------------------------------------------------
| CALLBACK FUNCTIONS
|--------------------------------------------------------------------------
*/
function AC_plugin_options_callback()
{
	echo esc_html__('Set up the slugs for custom post types and the contact form recipiend email address.', 'artemis-swp-core');
}

function AC_plugin_options_contact_form_email_callback() {
	$options = get_option('AC_plugin_options');

	$contact_form_email = '';
	if(isset( $options['lc_mc_contact_form_email'])) { 
		$contact_form_email = sanitize_email($options['lc_mc_contact_form_email']);
	}
?>
	<input type="text" size="50" id="AC_plugin_options" name="AC_plugin_options[lc_mc_contact_form_email]" value="<?php echo esc_html($contact_form_email); ?>" />
	<p class="description">
		<?php
		echo esc_html__("This is the recipient email address for the contact form.", "artemis-swp-core");
		?>
	</p>
<?php	
}

/* 
|--------------------------------------------------------------------------
| SANITIZE CALLBACK
|--------------------------------------------------------------------------
*/
function AC_sanitize_plugin_options($inputOptions)
{
	// Define the array for the updated options  
	$output = array();  

	// Loop through each of the options sanitizing the data  
	foreach($inputOptions as $key => $val) {  
		if(isset($inputOptions[$key])) {
			if ("lc_mc_contact_form_email" == $key) {
				$output[$key] = sanitize_email(trim($inputOptions[$key]));
			} else {
				$output[$key] = esc_html(trim($inputOptions[$key]));  	
			}
			
		}
	}
	  
	// Return the new collection  
	return apply_filters('AC_sanitize_plugin_options', $output, $inputOptions);
}

?>