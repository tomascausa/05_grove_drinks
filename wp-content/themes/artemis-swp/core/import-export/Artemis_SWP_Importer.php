<?php

/**
 * @author theodor-flavian hanu
 * Date: 9 Mar 2016
 * Time: 16:19
 */
class Artemis_SWP_Importer {

    /**
     * Set the theme framework in use
     *
     * @since 0.0.3
     *
     * @var object
     */
    public $theme_options_framework = 'artemis_swp'; //supports radium framework and option tree

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $theme_option_data = array();

    public $widgets_data = array();

    public $revslider_data = array();

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $widgets;

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.2
     *
     * @var object
     */
    public $content_demo;

    /**
     * Flag imported to prevent duplicates
     *
     * @since 0.0.3
     *
     * @var array
     */
    public $flag_as_imported = array( 'content' => false, 'menus' => false, 'options' => false, 'widgets' => false );

    /**
     * imported sections to prevent duplicates
     *
     * @since 0.0.3
     *
     * @var array
     */
    public $imported_demos = array();

    /**
     * Flag imported to prevent duplicates
     *
     * @since 0.0.3
     *
     * @var bool
     */
    public $add_admin_menu = true;

    /**
     * Holds a copy of the object for easy reference.
     *
     * @since 0.0.2
     *
     * @var object
     */
    private static $instance;

    private $_current_theme = '';

    /**
     * @var WP_Upgrader_Skin
     */
    private $upgrader_skin = null;

    private $_wp_import = null;

    public $import_dir;

    public $content_dir;

    protected $feedbackThrowException = false;

    protected $_current_error = null;
    protected $_processed_posts = array();

    /**
     * Constructor. Hooks all interactions to initialize the class.
     *
     * @since 0.0.2
     */
    public function __construct() {

        self::$instance    = $this;
        $this->import_dir  = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
        $this->content_dir = $this->import_dir . 'demo-content' . DIRECTORY_SEPARATOR;

        $this->imported_demos = get_option( 'artemis_imported_demo' );

        if ( $this->add_admin_menu ) {
            add_action( 'admin_menu', array( $this, 'add_admin' ) );
        }
        add_action( 'wp_ajax_artemis-demo-data', array( $this, 'do_import' ) );
        add_action( 'wp_ajax_artemis-import-homepage', array( $this, 'importHomePage' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );

        global $pagenow;
        if ($pagenow === 'themes.php') {
            add_filter('add_post_metadata', array($this, 'check_previous_meta'), 10, 5);
        }

        add_action( 'artemis_import_end', array( $this, 'after_wp_importer' ) );
    }

    public function enqueue_admin( $hook ) {
        if ( 'appearance_page_artemis_demo_installer' == $hook ) {
            $base_url = get_template_directory_uri() . '/core/import-export/';
            wp_enqueue_style( 'artemis_swp_style', $base_url . 'css/import.css' );
            wp_enqueue_script( 'artemis_swp_import_export_js', $base_url . 'js/import.js', array( 'jquery' ), '1.0', false );
            wp_localize_script( 'artemis_swp_import_export_js', 'artemisSwpImport', array(
                'messages'         => array(
                    'content'       => esc_html__( 'Importing theme content!', 'artemis-swp' ) . ' ' .
                                       esc_html__( 'Please be patient as this may take a while.', 'artemis-swp' ),
                    'error'         => esc_html__( 'An error has occured while importing your demo.', 'artemis-swp' ),
                    'invalidResponse'         => esc_html__( 'Invalid response from server', 'artemis-swp' ),
                    'theme_options' => esc_html__( 'Importing theme options', 'artemis-swp' ),
                    'widgets'       => esc_html__( 'Importing widgets', 'artemis-swp' ),
                    'revslider'     => esc_html__( 'Importing Revolution Slider', 'artemis-swp' ),
                ),
                'revslider'        => is_plugin_active( 'revslider/revslider.php' ),
                'nonce'            => wp_create_nonce( 'artemis_swp_ie_nonce' ),
                'processingImport' => isset( $_POST['action'] ) && $_POST['action'] == 'artemis-demo-data'
            ) );
        }
    }

    /**
     * Add Panel Page
     *
     * @since 0.0.2
     */
    public function add_admin() {

        add_theme_page( esc_html__( 'Import Artemis Demo', 'artemis-swp' ),
                        esc_html__( 'Import Artemis Demo', 'artemis-swp' ),
                        'switch_themes',
                        'artemis_demo_installer',
                        array(
                            $this,
                            'demo_installer'
                        )
        );
    }

    /**
     * Avoids adding duplicate meta causing arrays in arrays from WP_importer
     *
     * @param null  $continue
     * @param mixed $post_id
     * @param mixed $meta_key
     * @param mixed $meta_value
     * @param mixed $unique
     *
     * @return bool
     * @since 0.0.2
     *
     */
    public function check_previous_meta( $continue, $post_id, $meta_key, $meta_value, $unique ) {
        if ( ! defined( 'ARTEMIS_SWP_DO_IMPORT' ) || ! ARTEMIS_SWP_DO_IMPORT ) {
            return null;
        }
        $old_value = get_metadata( 'post', $post_id, $meta_key );

        if ( count( $old_value ) == 1 ) {
            if ( $old_value[0] === $meta_value ) {
                return false;
            } elseif ( $old_value[0] !== $meta_value ) {
                update_post_meta( $post_id, $meta_key, $meta_value );
                return false;
            }
        }
    }

    /**
     * Add Panel Page
     *
     * @since 0.0.2
     */
    public function after_wp_importer() {

        do_action( 'artemis_importer_after_content_import' );

        update_option( 'artemis_imported_demo', $this->flag_as_imported );

    }

    /**
     * demo_installer Output
     *
     * @since 0.0.2
     *
     * @return null
     */
    public function demo_installer() {
        ?>
        <div class="wrap artemis_swp_scontainer">
            <div id="icon-themes" class="icon32"></div>
            <h2 class="import_demo_title"><?php esc_html_e( 'Import Artemis Demos', 'artemis-swp' ) ?></h2>
            <?php

            if ( ! empty( $this->imported_demos ) ) { ?>
                <div class="notice notice-warning below-h2 demo-already-imported">
                    <p>
                        <strong><?php esc_html_e( 'Demo already imported!', 'artemis-swp' ); ?></strong>
                    </p>
                </div>
            <?php } ?>
            <div class="notice notice-info below-h2 is-dismissible">
                <p>
                    <?php echo esc_html__( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. ', 'artemis-swp' ); ?>
                    <?php echo esc_html__( 'It will allow you to quickly edit everything instead of creating content from scratch. ', 'artemis-swp' ); ?>
                    <?php echo esc_html__( 'When you import the data following things will happen:', 'artemis-swp' ) ?>
                </p>
                <ul class="artemis_import_headlines">
                    <li>
                        <?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'artemis-swp' ) ?>
                    </li>
                    <li>
                        <?php esc_html_e( 'Beware! Some of WordPress settings will be modified', 'artemis-swp' ) ?>.
                    </li>
                    <li>
                        <?php esc_html_e( 'Posts, pages, some images, some widgets and menus will get imported', 'artemis-swp' ) ?>.
                    </li>
                    <li>
                        <?php esc_html_e( 'Images will be downloaded from our server, these images are copyrighted and are for demo use only ', 'artemis-swp' ) ?>.
                    </li>
                    <li>
                        <?php esc_html_e( 'Please click import only once and wait, it can take a couple of minutes', 'artemis-swp' ) ?>
                    </li>
                </ul>
            </div>
            <?php if ( ! ARTEMIS_SWP_is_woocommerce_active() ) { ?>
                <div class="notice notice-warning below-h2">
                    <p>
                        <strong><?php echo esc_html__( 'WooCommerce is not active.', 'artemis-swp' ) ?></strong>
                        <strong><?php echo esc_html__( 'Please install and activate WooCommerce, otherwise you will not be able to import the demo products.', 'artemis-swp' ) ?></strong>
                    </p>
                </div>
            <?php } ?>

            <div class="available_demos">
                <form method="post">
                    <?php $this->available_themes(); ?>
                    <input type="hidden" name="artemis_swp_ie_nonce"
                           value="<?php echo wp_create_nonce( 'artemis_swp_ie_nonce' ); ?>"/>
		          	<input type="hidden" name="action" value="artemis-demo-data"/>
	 	        </form>
 	        </div>

            <div id="artemis-swp-import-processing">
                <p><?php esc_html_e('Theme import started','artemis-swp') ?></p>
                <p><strong><?php esc_html_e('Please do not close this page!','artemis-swp') ?></strong></p>
            </div>
            <div id="artemis-swp-import-complete">
                <p>
                    <?php esc_html_e( 'All done.', 'artemis-swp' ) ?>
                    <a href="<?php echo esc_attr(admin_url()) ?>"><?php esc_html_e( 'Have fun!', 'artemis-swp' ) ?></a>
                </p>
                <p><?php esc_html_e( 'Remember to update the passwords and roles of imported users.', 'artemis-swp' ) ?></p>
            </div>
        </div>
        <?php
    }

    public function available_themes() {
        $available_themes = glob( $this->content_dir . '*', GLOB_ONLYDIR );
        $themes           = array();
        $demo_content_uri = get_template_directory_uri() . '/core/import-export/demo-content/';
        foreach ( $available_themes as $available_theme ) {
            $code            = basename( $available_theme );
            $theme_label = str_replace( array('_','-'), ' ', $code);
            $themes[ $code ] = array(
                'label'     => ucwords( $theme_label ),
                'image_url' => $demo_content_uri . '/' . $code . '/' . $code . '.png'
            );
        }
        ?>
        <div id="import_items" class="import_items">
            <?php
            $demoNo      = 0;
            $DEMO_ON_ROW = 3;
            foreach ( $themes as $code => $theme ) {
                if ( ! ( $demoNo % $DEMO_ON_ROW ) ) {
                    if ( $demoNo != 0 ) {
                        echo '</div>';
                    }
                    echo '<div class="items_row">';
                }
                ?>
                <div class="items_cell">
                    <img src="<?php echo esc_url($theme['image_url']); ?>" alt="<?php echo esc_attr($theme['label']); ?>">
                    <button class="import_artemis_btn button button-primary" name="import_theme" type="submit" value="<?php echo esc_attr( $code ) ?>" data-theme="<?php echo
                    esc_attr( $code ) ?>">
                        <?php printf( esc_html__( 'Import %s Demo', 'artemis-swp' ), $theme['label'] ) ?>
                    </button>
                    <button class="import_artemis_homepage_btn button button-primary" name="import_theme_homepage" type="submit" value="<?php echo esc_attr( $code ) ?>" data-theme="<?php echo
                    esc_attr( $code ) ?>">
                        <?php printf( esc_html__( 'Import Only Homepage', 'artemis-swp' ), $theme['label'] ) ?>
                    </button>
                </div>
                <?php
                $demoNo ++;
            }
            $spinner_class = '';
            if ( isset( $_POST['action'] ) && $_POST['action'] == 'artemis-demo-data' ) {
                $spinner_class = 'active';
            }
            /*fill in with remaining empty cells*/
            if ( ( $remaining_placeholders = ( $demoNo % $DEMO_ON_ROW ) ) > 0 ) {
                for ( $i = $remaining_placeholders; $i < $DEMO_ON_ROW; $i ++ ) {
                    ?>
                    <div class="items_cell"></div><?php
                }
                echo '</div>';
            } ?>
            <div class="import_spinner <?php echo esc_attr( $spinner_class ) ?>">
                <img src="<?php echo get_template_directory_uri() . '/core/import-export/img/spinner.gif'; ?>">
            </div>
        </div>

        <hr class="after_demos_images">
        <?php
    }

    private function get_upgrader_skin() {
        if ( ! $this->upgrader_skin ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php';
            $this->upgrader_skin = new WP_Upgrader_Skin();
        }

        return $this->upgrader_skin;
    }

    public function feedback( $msg, $args = array() ) {
        if( $this->feedbackThrowException ) {
            throw new Exception($msg);
        }
        return;
        $this->get_upgrader_skin();
        ob_start();
        $this->upgrader_skin->feedback( $msg, $args );
    }

    protected function sendAjaxSuccess( $message, $data = array() ) {
        $this->sendAjaxResponse( $message, $data, 'success' );
    }

    protected function sendAjaxError( $message, $data = array() ) {
        $this->sendAjaxResponse( $message, $data, 'error' );
        exit;
    }

    protected function sendAjaxResponse( $message, $data, $type ) {
        $response = array( 'message' => $message );
        $response = array_merge( $response, $data );
        switch ( $type ) {
            case 'success':
                $response['success'] = true;
                break;
            case 'error':
            default:
                $response['error']   = true;
                $response['success'] = false;
                break;
        }
        echo json_encode( $response );
    }

    public function shutdownHandleError() {
        $error   = error_get_last();
        if ( $error !== null ) {
            $errno = $error["type"];

            if ( in_array( $errno, array( E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR ) ) ) {
                echo "<pre>";
                print_r( $error );
                echo "</pre>";
            }
        }
    }

    protected function _getFileSystem() {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
        require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
        return new WP_Filesystem_Direct( array() );
    }

    public function do_import() {
        register_shutdown_function( array($this, 'shutdownHandleError'));
        if( !defined('ARTEMIS_SWP_DO_IMPORT') ) {
            define( 'ARTEMIS_SWP_DO_IMPORT', true);
        }
        try {
            if ( ! wp_verify_nonce( $_POST['artemis_swp_ie_nonce'], 'artemis_swp_ie_nonce' ) ) {
                throw new Exception( esc_html__( 'Are you trying to trick me?', 'artemis-swp' ) );
            }
            if ( isset( $_POST['import_theme'] ) && ( $theme = trim( $_POST['import_theme'] ) ) ) {
                $this->_current_theme = sanitize_text_field( trim( $_POST['import_theme'] ) );

                $type = trim($_POST['type']);
                set_time_limit( 0 );
                $demo_content_dir = $this->content_dir . $this->_current_theme . DIRECTORY_SEPARATOR;

                $filesystem = $this->_getFileSystem();

                switch ( $type ) {
                    case 'content':
                        if ( file_exists( $demo_content_dir . 'content.json' ) ) {
                            /*if the main page exists, delete it*/
                            try {
                                $main_demo_page = get_page_by_title( 'Home' );
                                if ( null != $main_demo_page ) {
                                    wp_delete_post( $main_demo_page->ID, true );
                                }

                                $content = $filesystem->get_contents( $demo_content_dir . 'content.json' );
                                $content = json_decode( $content, true );
                                if ( ! $content ) {
                                    throw new Exception( esc_html__( 'Cannot retrieve demo content', 'artemis-swp' ) );
                                }
                                if( isset($content['woocommerce_settings']) && is_array( $content['woocommerce_settings']) ) {
                                    foreach ( $content['woocommerce_settings'] as $name => $setting ) {
                                        update_option( $name, $setting);
                                    }
                                }
                                $revslider_url      = rtrim( $content['base_site_url'], '/' ) . '/revslider.zip';
                                $this->content_demo = $content;

                                /*if the menu exists, delete it*/
                                wp_delete_nav_menu( 'Main Menu' );
                                wp_delete_nav_menu( 'Footer Menu' );

                                //recreate menus
                                wp_create_nav_menu('Main Menu');
                                wp_create_nav_menu('Footer Menu');

                                $this->set_demo_data();

                                $this->_processed_posts = $this->_wp_import->processed_posts;

                                $this->replaceMainPageProductShortcode( );

                                $this->sendAjaxSuccess( esc_html__( 'Successfully imported theme content', 'artemis-swp' ),
                                                        array(
                                                            'revslider_url'   => $revslider_url,
                                                            'processed_posts' => $this->_wp_import->processed_posts
                                                        ) );
                            } catch ( Exception $e ) {
                                $this->sendAjaxError( $e->getMessage() );
                            }
                        }
                        else {
                            $this->sendAjaxSuccess( esc_html__( 'No content.json file was found.', 'artemis-swp' ) );
                        }
                        break;
                    case 'theme_options':
                        if ( file_exists( $demo_content_dir . 'theme_options.json' ) ) {
                            $content = $filesystem->get_contents( $demo_content_dir . 'theme_options.json' );
                            $content = json_decode( $content, true );
                            if ( ! $content ) {
                                throw new Exception( esc_html__( 'Cannot retrieve theme options', 'artemis-swp' ) );
                            }
                            $this->theme_option_data = $content;

                            try {
                                $msg = $this->set_demo_theme_options();
                                $response = esc_html__( 'Successfully imported theme options', 'artemis-swp' );
                                if( $msg ) {
                                    $response .=  esc_html__('Warning', 'artemis-swp') . ': '. $msg;
                                }
                                $this->sendAjaxSuccess( $response );
                            } catch ( Exception $e ) {
                                $this->sendAjaxError( $e->getMessage() );
                            }
                        }
                        else {
                            $this->sendAjaxSuccess( esc_html__( 'No theme_options.json file was found.', 'artemis-swp' ) );
                        }
                        break;
                    case 'widgets':
                        if ( file_exists( $demo_content_dir . 'widgets.json' ) ) {
                            $content = $filesystem->get_contents( $demo_content_dir . 'widgets.json' );
                            $content = json_decode( $content, true );
                            if ( ! $content ) {
                                throw new Exception( esc_html__( 'Cannot retrieve widgets', 'artemis-swp' ) );
                            }
                            $this->widgets_data = $content;

                            try {
                                $this->import_widgets();
                                $this->sendAjaxSuccess( esc_html__( 'Successfully imported widgets', 'artemis-swp' ) );
                            } catch ( Exception $e ) {
                                $this->sendAjaxError( $e->getMessage() );
                            }
                        }
                        else {
                            $this->sendAjaxSuccess( esc_html__( 'No widgets.json file was found.', 'artemis-swp' ) );
                        }

                        break;
                    case 'revslider':
                        $revslider_url = esc_url_raw( $_POST['revslider_url']);
                        $msg = '';
                        if ( is_plugin_active( 'revslider/revslider.php' ) && $revslider_url ) {

                            try {
                                $filepath = download_url( $revslider_url );
                                if ( is_wp_error( $filepath ) ) {
                                    throw new Exception( $filepath->get_error_message() );
                                }
                                $this->import_revslider( $filepath );
                                unlink( $filepath );
                                $msg =  esc_html__( 'Successfully imported Revolution Slider', 'artemis-swp' );
                            } catch ( Exception $e ) {
                                $this->sendAjaxError( $e->getMessage() );
                                break;
                            }
                        }
                        do_action( 'artemis_import_end' );
                        $this->sendAjaxSuccess( $msg);

                        break;
                }
            }
            else {
                $this->sendAjaxError( esc_html__('No theme specified', 'artemis-swp' ) );
            }
        } catch ( Exception $e ) {
            $this->sendAjaxError( $e->getMessage() );
        }
        restore_error_handler();
        exit;
    }

    public function replaceProductId( $matches ) {
        if ( array_key_exists( $matches[2], $this->_processed_posts ) ) {
            return $matches[1] . $this->_processed_posts[ $matches[2] ] . $matches[3];
        }

        return $matches[0];
    }

    public function replaceMainPageProductShortcode() {

        $main_demo_page = get_page_by_title( 'Home' );
        if ( null != $main_demo_page ) {
            $page_content = $main_demo_page->post_content;

            $pattern = get_shortcode_regex( array( 'product' ) );

            if ( preg_match_all( "/$pattern/", $page_content, $matches ) ) {
                foreach ( $matches[0] as $key => $value ) {
                    $newValue     = preg_replace_callback( '/(.*id=\")(\d+)(\".*)/', array( $this, 'replaceProductId' ), $value );
                    $page_content = str_replace( $value, $newValue, $page_content );
                }
            }
            $main_demo_page->post_content = $page_content;

            wp_update_post( $main_demo_page );
        }
    }

    /**
     * Used for import homepage
     *
     * @param $msg
     *
     * @throws \Exception
     */
    public function notifyImportError( $msg ) {
        if($this->feedbackThrowException ) {
            throw new Exception($msg);
        }
    }

    public function importHomePage() {
        try {
            if ( ! wp_verify_nonce( $_POST['artemis_swp_ie_nonce'], 'artemis_swp_ie_nonce' ) ) {
                throw new Exception( esc_html__( 'Are you trying to trick me?', 'artemis-swp' ) );
            }
            if ( isset( $_POST['import_theme'] ) && ( $theme = trim( $_POST['import_theme'] ) ) ) {

                $this->_current_theme = sanitize_text_field( trim( $_POST['import_theme'] ) );

                set_time_limit( 0 );
                $demo_content_dir = $this->content_dir . $this->_current_theme . DIRECTORY_SEPARATOR;
                if ( ! file_exists( $demo_content_dir . 'content.json' ) ) {
                    throw new Exception( esc_html__( 'No content.json file was found.', 'artemis-swp' ) );
                }

                $filesystem = $this->_getFileSystem();
                $content    = $filesystem->get_contents( $demo_content_dir . 'content.json' );
                $content    = json_decode( $content, true );
                if ( ! $content ) {
                    throw new Exception( esc_html__( 'Cannot retrieve demo content', 'artemis-swp' ) );
                }

                //search for homepage
                if ( ! isset( $content['item'] ) ) {
                    throw new Exception( esc_html__( 'No content found for this demo', 'artemis-swp' ) );
                }
                $homepage = null;
                foreach ( $content['item'] as $item ) {
                    if ( isset( $item['title'] ) && 'Home' == $item['title'] && 'page' == $item['post_type'] ) {
                        $homepage = $item;
                        break;
                    }
                }

                if ( ! $homepage ) {
                    throw new Exception( esc_html__( 'No homepage found for this theme', 'artemis-swp' ) );
                }

                //change page title and name to Home [current theme]
                $theme_label = str_replace( array( '_', '-' ), ' ', $theme );
                $theme_label = ucwords( $theme_label);

                $homepage['title']  .= ' '. $theme_label;
                $homepage['post_name'] = sanitize_title( $homepage['post_name'] . ' '. $theme_label);

                $this->content_demo = array(
                    'base_site_url' => $content['base_site_url'],
                    'version'       => $content['version'],
                    'item'          => array( $homepage )
                );

                $revslider_url = rtrim( $content['base_site_url'], '/' ) . '/revslider.zip';


                try {
                    $this->set_demo_data();
                } catch ( Exception $e ) {
                    $this->sendAjaxError( esc_html__( 'Cannot import homepage!', 'artemis-swp' ) . $e->getMessage());
                }


                if ( is_plugin_active( 'revslider/revslider.php' ) && $revslider_url ) {
                    $tmpFilePath = download_url( $revslider_url );
                    if ( is_wp_error( $tmpFilePath ) ) {
                        throw new Exception( $tmpFilePath->get_error_message() );
                    }
                    $this->import_revslider( $tmpFilePath );
                    unlink( $tmpFilePath );
                }
                $this->sendAjaxSuccess( esc_html__( 'Homepage successfully imported', 'artemis-swp' ) );

            }
            else {
                throw new Exception(esc_html__( 'No theme provided', 'artemis-swp'));
            }
        }catch (Exception $e) {
            $this->sendAjaxError( $e->getMessage() );
        }
        exit;
    }

    public function set_demo_data() {

        require_once ABSPATH . 'wp-admin/includes/import.php';


        $class_wp_import = $this->import_dir . 'Artemis_SWP_WP_Import.php';

        if ( file_exists( $class_wp_import ) ) {
            require_once( $class_wp_import );
        }

        $this->_wp_import                    = new Artemis_SWP_WP_Import( $this );
        $this->_wp_import->fetch_attachments = true;
        $this->_wp_import->importJson( $this->content_demo );
        $this->flag_as_imported['content'] = true;

        do_action( 'artemis_importer_after_theme_content_import' );
    }

    public function set_demo_theme_options() {
        $msg = '';
        // Only if there is data
        if ( ! empty( $this->theme_option_data ) || is_array( $this->theme_option_data ) ) {

            // Hook before import
            $data = apply_filters( 'artemis_theme_import_theme_options', $this->theme_option_data );

            //update customizer
            if ( isset( $data['mods'] ) && is_array( $data['mods'] ) ) {
                update_option( 'theme_mods_artemis-swp', $data['mods'] );
            }

            $this->set_demo_menus();

            $data = $this->check_theme_settings_images( $data );
            if ( isset( $data['warnings'] ) ) {
                $msg = $data['warnings'];
            }

            //todo: link custom css customizer tab to custom_css post_type

            //update option tabs
            $theme_settings_tabs = array(
                'artemis_theme_general_options',
                'artemis_theme_social_options',
                'artemis_theme_footer_options',
                'artemis_theme_contact_options',
                'artemis_theme_shop_options',
            );
            $processed_posts = isset( $_POST['processed_posts'] ) && is_array( $_POST['processed_posts'] ) ? $_POST['processed_posts'] : array();

            if ( $processed_posts ) {
                //update wishlist page id
                if ( isset( $data['artemis_theme_shop_options'] ) && ! empty( $data['artemis_theme_shop_options']['lc_wishlist_page'] ) ) {
                    $old_wishlist_page_id = $data['artemis_theme_shop_options']['lc_wishlist_page'];
                     if ( isset( $processed_posts[ $old_wishlist_page_id ] ) ) {
                        $data['artemis_theme_shop_options']['lc_wishlist_page'] = $processed_posts[ $old_wishlist_page_id ];
                    } else {
                        $data['artemis_theme_shop_options']['lc_wishlist_page'] = 'none';
                    }
                }
            }
            foreach ( $theme_settings_tabs as $tab ) {
                if ( isset( $data[ $tab ] ) ) {
                    update_option( $tab, $data[ $tab ] );
                }
            }

            if ( isset( $data['customizer'] ) && is_array( $data['customizer'] ) ) {
                update_option( 'lc_customize', $data['customizer'] );
            }

            //update front page
            if ( $processed_posts ) {
                if ( isset( $data['show_on_front'] ) && ! empty( $data['show_on_front'] ) ) {
                    update_option( 'show_on_front', $data['show_on_front'] );
                }
                if ( isset( $data['page_on_front'] ) && ! empty( $data['page_on_front'] ) ) {
                    if ( isset( $processed_posts[ $data['page_on_front'] ] ) ) {
                        update_option( 'page_on_front', $processed_posts[ $data['page_on_front'] ] );
                    }
                }
                if ( isset( $data['page_for_posts'] ) && ! empty( $data['page_for_posts'] ) ) {
                    if ( isset( $processed_posts[ $data['page_for_posts'] ] ) ) {
                        update_option( 'page_for_posts', $processed_posts[ $data['page_for_posts'] ] );
                    }
                    //update_option('page_for_posts', $data['page_for_posts']);
                }
            }

            $this->flag_as_imported['options'] = true;
        }

        do_action( 'artemis_importer_after_theme_options_import' );
        return $msg;
    }

    public function check_theme_settings_images( $data ) {

        $response = '';
        if ( isset( $data['artemis_theme_general_options'] ) ) {
            //update general settings images
            $general_tab_options = array(
                'lc_custom_logo',
                'lc_custom_favicon',
                'lc_custom_innner_bg_image',
                'lc_404_bg_image',
                'lc_login_popup_bg_image',
            );

            $general_tab_data = $data['artemis_theme_general_options'];

            $content_url = content_url();
            foreach ( $general_tab_options as $general_tab_option ) {
                if ( isset( $general_tab_data[ $general_tab_option ] ) ) {
                    //check if file already imported exists
                    $path = explode( 'wp-content', $general_tab_data[ $general_tab_option ] );
                    array_shift( $path );
                    if ( $path ) {
                        $path = WP_CONTENT_DIR . implode( '', $path );
                        if ( file_exists( $path ) ) {
                            $data['artemis_theme_general_options'][ $general_tab_option ] = str_replace( WP_CONTENT_DIR, $content_url, $path );
                        } else {
                            //download attachment
                            $url = $general_tab_data[ $general_tab_option ];
                            try {
                                $url = self::create_attachment_from_url( $url );
                                if ( $url ) {
                                    $data['artemis_theme_general_options'][ $general_tab_option ] = $url;
                                }
                            } catch ( Exception $e ) {
                                $setting_name = str_replace( '_', ' ', str_replace( 'lc_', '', $general_tab_option ) );
                                $setting_name = ucwords( $setting_name );
                                $msg          = sprintf( esc_html__( 'Setting \'%s\': ', 'artemis-swp' ), $setting_name );
                                $msg          .= esc_html( $e->getMessage() );
                                $response .= $msg . '<br/>';
                            }
                        }//else file_exists($path)
                    }//endif $path
                }
            }
        }

        if (
            isset( $data['artemis_theme_footer_options'] )
            && isset( $data['artemis_theme_footer_options']['lc_footer_widgets_background_image'] )
            && ( $url = trim( $data['artemis_theme_footer_options']['lc_footer_widgets_background_image'] ) )
        ) {
            $path = explode( 'wp-content', $url );
            array_shift( $path );
            if ( $path ) {
                $path = WP_CONTENT_DIR . implode( '', $path );
                if ( file_exists( $path ) ) {
                    $content_url                                                                = content_url();
                    $data['artemis_theme_footer_options']['lc_footer_widgets_background_image'] = str_replace( WP_CONTENT_DIR, $content_url, $path );
                } else {
                    //download attachment
                    try {
                        $url = self::create_attachment_from_url( $url );
                        if ( $url ) {
                            $data['artemis_theme_footer_options']['lc_footer_widgets_background_image'] = $url;
                        }
                    } catch ( Exception $e ) {
                        $setting_name = 'Footer widgets background image';
                        $msg          = sprintf( esc_html__( 'Setting \'%s\': ', 'artemis-swp' ), $setting_name );
                        $msg          .= esc_html( $e->getMessage() );

                        $response .= $msg . '<br/>';
                    }
                }
            }
        }

        if( $response ){
            $data['warnings'] = $response;
        }
        return $data;
    }

    public function set_demo_menus() {
        // Menus to Import and assign
        $menu_object = wp_get_nav_menu_object( 'Main Menu' );
        $locations   = get_theme_mod( 'nav_menu_locations', array() );
        if ( $menu_object ) {
            $locations['main-menu'] = $menu_object->term_id;
        }

        $footer_menu = wp_get_nav_menu_object( 'Footer Menu' );
        if ( $footer_menu ) {
            $locations['secondary-menu'] = $footer_menu->term_id;
        }

        set_theme_mod( 'nav_menu_locations', $locations );
        $this->flag_as_imported['menus'] = true;
    }

    /**
     * @param $url
     *
     * @return mixed
     * @throws \Exception
     */
    static public function create_attachment_from_url( $url ) {
        $temp_file = download_url( $url );
        if ( is_wp_error( $temp_file ) ) {
            throw new Exception( 'Cannot download file.' );
        } else {
            $attachment_title = basename( $url );
            $file             = array(
                'name'     => $attachment_title,
                'type'     => 'image/jpg',
                'tmp_name' => $temp_file,
                'error'    => 0,
                'size'     => filesize( $temp_file ),
            );
            $overrides        = array(
                'test_form' => false,
                'test_size' => true,
            );
            // Move the temporary file into the uploads directory
            $results = wp_handle_sideload( $file, $overrides );
            if ( empty( $results['error'] ) ) {
                // Insert any error handling here
                $attachmentData = array(
                    'guid'           => $results['url'],
                    'post_mime_type' => $results['type'],
                    'post_title'     => $attachment_title,
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                $attachment_id  = wp_insert_attachment( $attachmentData, $results['file'] );
                if ( $attachment_id ) {
                    $attach_data = wp_generate_attachment_metadata( $attachment_id, $results['file'] );
                    wp_update_attachment_metadata( $attachment_id, $attach_data );
                } else {
                    throw new Exception( 'Cannot create attachment.' );
                }

                return $results['url'];
            } else {
                throw new Exception( 'Cannot move file.' );
            }
        }
    }

    /**
     * Import widget JSON data
     *
     * @since 0.0.2
     * @global array $wp_registered_sidebars
     *
     * @param array  $data JSON widget data from .json file
     *
     * @return array Results array
     */
    public function import_widgets() {

        global $wp_registered_sidebars;

        // Have valid data?
        // If no data or could not decode
        if ( empty( $this->widgets_data ) || ! is_array( $this->widgets_data ) ) {
            return;
        }

        // Hook before import
        $data = apply_filters( 'artemis_theme_import_widget_data', $this->widgets_data );

        // Get all available widgets site supports
        $available_widgets = $this->available_widgets();

        // Get all existing widget instances
        $widget_instances = array();
        foreach ( $available_widgets as $widget_data ) {
            $widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
        }

        // Begin results
        $results = array();

        $sidebar = isset( $data[0] ) ? $data[0] : array();

        $imported_widgets_data = isset( $data[1] ) ? $data[1] : array();
        // Loop import data's sidebars
        foreach ( $sidebar as $sidebar_id => $widgets ) {

            // Skip inactive widgets
            // (should not be in export file)
            if ( 'wp_inactive_widgets' == $sidebar_id ) {
                continue;
            }

            // Check if sidebar is available on this site
            // Otherwise add widgets to inactive, and say so
            if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
                $sidebar_available    = true;
                $use_sidebar_id       = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message      = '';
            } else {
                $sidebar_available    = false;
                $use_sidebar_id       = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
                $sidebar_message_type = 'error';
                $sidebar_message      = esc_html__( 'Sidebar does not exist in theme (using Inactive)', 'artemis-swp' );
            }

            // Result for sidebar
            $results[ $sidebar_id ]['name']         = ! empty( $wp_registered_sidebars[ $sidebar_id ]['name'] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
            $results[ $sidebar_id ]['message_type'] = $sidebar_message_type;
            $results[ $sidebar_id ]['message']      = $sidebar_message;
            $results[ $sidebar_id ]['widgets']      = array();

            // Loop widgets
            foreach ( $widgets as $widget_instance_id => $widget ) {

                $fail = false;

                // Get id_base (remove -# from end) and instance ID number
                $id_base            = preg_replace( '/-[0-9]+$/', '', $widget );
                $instance_id_number = str_replace( $id_base . '-', '', $widget );

                // Does site support this widget?
                if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
                    $fail                = true;
                    $widget_message_type = 'error';
                    $widget_message      = esc_html__( 'Site does not support widget', 'artemis-swp' ); // explain why widget not imported
                }

                // Filter to modify settings before import
                // Do before identical check because changes may make it identical to end result (such as URL replacements)
                $widget = apply_filters( 'artemis_theme_import_widget_settings', $widget );

                // Does widget with identical settings already exist in same sidebar?
                if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {

                    // Get existing widgets in this sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' );
                    $sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // check Inactive if that's where will go

                    // Loop widgets with ID base
                    $single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
                    foreach ( $single_widget_instances as $check_id => $check_widget ) {

                        // Is widget in same sidebar and has identical settings?
                        if(isset( $imported_widgets_data[ $id_base ][ $instance_id_number ])){
                            $wData = $imported_widgets_data[ $id_base ][ $instance_id_number ];}
                        else {
                            $wData = array();
                        }
                        if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $wData == $check_widget ) {
                            $fail                = true;
                            $widget_message_type = 'warning';
                            $widget_message      = esc_html__( 'Widget already exists', 'artemis-swp' ); // explain why widget not imported

                            break;

                        }

                    }

                }

                // No failure
                if ( ! $fail ) {

                    // Add widget instance
                    $single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
                    $single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to

                    if ( ! isset( $imported_widgets_data[ $id_base ][ $instance_id_number ] ) ) {
                        continue;
                    }
                    $single_widget_instances[] = $imported_widgets_data[ $id_base ][ $instance_id_number ]; // add it

                    // Get the key it was given
                    end( $single_widget_instances );
                    $new_instance_id_number = key( $single_widget_instances );

                    // If key is 0, make it 1
                    // When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
                    if ( '0' === strval( $new_instance_id_number ) ) {
                        $new_instance_id_number                             = 1;
                        $single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
                        unset( $single_widget_instances[0] );
                    }

                    // Move _multiwidget to end of array for uniformity
                    if ( isset( $single_widget_instances['_multiwidget'] ) ) {
                        $multiwidget = $single_widget_instances['_multiwidget'];
                        unset( $single_widget_instances['_multiwidget'] );
                        $single_widget_instances['_multiwidget'] = $multiwidget;
                    }

                    // Update option with new widget
                    update_option( 'widget_' . $id_base, $single_widget_instances );

                    // Assign widget instance to sidebar
                    $sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
                    if ( ! $sidebars_widgets ) {
                        $sidebars_widgets = array();
                    }
                    $new_instance_id                       = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
                    $sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id; // add new instance to sidebar
                    update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

                    // Success message
                    if ( $sidebar_available ) {
                        $widget_message_type = 'success';
                        $widget_message      = esc_html__( 'Imported', 'artemis-swp' );
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message      = esc_html__( 'Imported to Inactive', 'artemis-swp' );
                    }

                }

                // Result for widget instance
                if ( isset( $results[ $sidebar_id ]['widgets'][ $widget_instance_id ] ) ) {
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name']         = isset( $available_widgets[ $id_base ]['name'] ) ? $available_widgets[ $id_base ]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title']        = $widget->title ? $widget->title : esc_html__( 'No Title', 'artemis-swp' ); // show "No Title" if widget instance is untitled
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message_type'] = $widget_message_type;
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message']      = $widget_message;
                }
            }

        }

        $this->flag_as_imported['widgets'] = true;

        // Hook after import
        do_action( 'artemis_theme_import_widget_after_import' );

        // Return results
        return apply_filters( 'artemis_theme_import_widget_results', $results );

    }

    public function import_revslider( $slider_zip_file ) {
        $absolute_path = __FILE__;
        $path_to_file  = explode( 'wp-content', $absolute_path );
        $path_to_wp    = $path_to_file[0];

        require_once( $path_to_wp . '/wp-load.php' );
        require_once( $path_to_wp . '/wp-includes/functions.php' );

        $slider_array = array( $slider_zip_file );
        $slider       = new RevSlider();

        foreach ( $slider_array as $filepath ) {
            $slider->importSliderFromPost( true, true, $filepath );
        }
    }

    /**
     * Available widgets
     *
     * Gather site's widgets into array with ID base, name, etc.
     * Used by export and import functions.
     *
     * @since 0.0.2
     *
     * @global array $wp_registered_widget_updates
     * @return array Widget information
     */
    function available_widgets() {

        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ( $widget_controls as $widget ) {

            if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) { // no dupes

                $available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
                $available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];

            }

        }

        return apply_filters( 'artemis_theme_import_widget_available_widgets', $available_widgets );

    }

    /**
     * @access    public
     * @since     0.0.3
     * @updated   0.0.3.1
     * Helper function to return option tree decoded strings
     *
     * @param $value
     *
     * @return string
     */
    public function optiontree_decode( $value ) {

        $func          = 'base64' . '_decode';
        $prepared_data = maybe_unserialize( $func( $value ) );

        return $prepared_data;

    }

    /**
     * add_widget_to_sidebar Import sidebars
     *
     * @param  string $sidebar_slug    Sidebar slug to add widget
     * @param  string $widget_slug     Widget slug
     * @param  string $count_mod       position in sidebar
     * @param  array  $widget_settings widget settings
     *
     * @since 0.0.2
     *
     * @return null
     */
    public function add_widget_to_sidebar( $sidebar_slug, $widget_slug, $count_mod, $widget_settings = array() ) {

        $sidebars_widgets = get_option( 'sidebars_widgets' );

        if ( ! isset( $sidebars_widgets[ $sidebar_slug ] ) ) {
            $sidebars_widgets[ $sidebar_slug ] = array( '_multiwidget' => 1 );
        }

        $newWidget = get_option( 'widget_' . $widget_slug );

        if ( ! is_array( $newWidget ) ) {
            $newWidget = array();
        }

        $count                               = count( $newWidget ) + 1 + $count_mod;
        $sidebars_widgets[ $sidebar_slug ][] = $widget_slug . '-' . $count;

        $newWidget[ $count ] = $widget_settings;

        update_option( 'sidebars_widgets', $sidebars_widgets );
        update_option( 'widget_' . $widget_slug, $newWidget );

    }

}//class
