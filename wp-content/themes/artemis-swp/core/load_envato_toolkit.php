<?php

/**
 * Load the Envato WordPress Toolkit Library check for updates
 * and direct the user to the Toolkit Plugin if there is one
 */
function ARTEMIS_SWP_envato_toolkit_admin_init() 
{
    /* Include the Toolkit Library */
    include_once( get_template_directory() . '/assets/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php' );
 
    //add_action( 'admin_notices', 'ARTEMIS_SWP_envato_toolkit_admin_notices' );
	
    /* use credentials used in toolkit plugin so that we don't have to show our own forms anymore */
    $credentials = get_option( 'envato-wordpress-toolkit' );
    if ( empty($credentials['user_name']) || empty($credentials['api_key']) ) 
	{
        add_action( 'admin_notices', 'ARTEMIS_SWP_envato_toolkit_credentials_admin_notices' );
        return;
    }
    
    /* check updates only after a while */
    $lastCheck = get_option( 'toolkit-last-toolkit-check' );
    if ( $lastCheck === false ) 
	{
        update_option( 'toolkit-last-toolkit-check', time() );
        return;
    }
    
    /* check for an update every 6 hours */
    if ( (time() - $lastCheck) < 21600 ) 
	{
        return;
    }
    
    /* update the time we last checked */
    update_option( 'toolkit-last-toolkit-check', time() );
    
    /* check for updates */
    $upgrader = new Envato_WordPress_Theme_Upgrader( $credentials['user_name'], $credentials['api_key'] );
    $updates = $upgrader->check_for_theme_update();

    /* add update alert, to update the theme */
    if ( true == $updates->updated_themes_count ) 
	{
        add_action( 'admin_notices', 'ARTEMIS_SWP_envato_toolkit_admin_notices' );
    }

    /*
     *  Uncomment to update the current theme
     */
    
    // $upgrader->upgrade_theme();
 
}
add_action( 'admin_init', 'ARTEMIS_SWP_envato_toolkit_admin_init' );


/**
 * Display a notice in the admin to remind the user to enter their credentials
 */
function ARTEMIS_SWP_envato_toolkit_credentials_admin_notices() 
{
    $message = sprintf( esc_html__( "To enable theme update notifications, please enter your Envato Marketplace credentials in the %s", "artemis-swp" ),
                        "<a href='" . admin_url() . "admin.php?page=envato-wordpress-toolkit'>Envato WordPress Toolkit Plugin</a>" );
						
    echo "<div id='message' class='updated below-h2'><p>{$message}</p></div>";
}

/**
 * Display a notice in the admin that an update is available
 */
function ARTEMIS_SWP_envato_toolkit_admin_notices() 
{
    $message = sprintf( esc_html__( "An update to the theme is available! Head over to %s to update it now.", "artemis-swp" ),
                        "<a href='" . admin_url() . "admin.php?page=envato-wordpress-toolkit'>Envato WordPress Toolkit Plugin</a>" );

    echo "<div id='message' class='updated below-h2'><p>{$message}</p></div>";
}

?>