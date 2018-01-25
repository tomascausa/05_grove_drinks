<?php

/**
 * @author theodor-flavian hanu
 * Date: 8 Mar 2016
 * Time: 12:37
 */
class Artemis_SWP_Exporter
{

    public static $VERSION = '1.0';

    public static $EXPORT_DIR = 'artemis_export';

    protected $_defaults = array(
        'content'    => 'all',
        'author'     => false,
        'category'   => false,
        'start_date' => false,
        'end_date'   => false,
        'status'     => false,
    );

    protected $_post_ids = array();

    protected $_cats = array();

    protected $_authors = array();

    protected $_terms = array();

    protected $_term = array();

    protected $_tags = array();

    protected $_options = array();

    protected $_charset = 'UTF-8';

    protected $_export_data = array();

    protected $_export_dir;

    protected $_errors = array( 'error' => array(), 'warning' => array(), 'notice' => array(), 'success' => array() );

    protected static $revslider_prefix;

    public function __construct($options = array())
    {
        $uploads           = wp_upload_dir();
        $this->_export_dir = rtrim($uploads['basedir'], '/') . DIRECTORY_SEPARATOR . self::$EXPORT_DIR . DIRECTORY_SEPARATOR . wp_get_theme() . DIRECTORY_SEPARATOR;
        //make sure the export dir exist
        wp_mkdir_p($this->_export_dir);
        $this->_options = wp_parse_args($options, $this->_defaults);

        do_action('export_wp', $this->_options);

        $this->_charset = get_bloginfo('charset');
        add_action('admin_menu', array( $this, 'add_admin' ));
    }

    public function enqueue_admin()
    {
        //wp_enqueue_style('ai_swp_style', get_stylesheet_directory_uri() . '/css/ai_swp_style.css');
    }

    /**
     * Add Panel Page
     *
     * @since 0.0.2
     */
    public function add_admin()
    {
        $page_exporter = add_theme_page(esc_html__('Export Artemis Demo', 'artemis-swp'), esc_html__('Export Artemis Demo', 'artemis-swp'), 'switch_themes', 'artemis_demo_exporter', array(
            $this,
            'demo_exporter'
        ));
        //add_action("admin_print_scripts-$page_exporter", array( $this, 'enqueue_admin' ));
    }

    public function displayMessages()
    {
        if (count($this->_errors)) {
            ?>
            <?php foreach ($this->_errors as $type => $errors) {
                if (empty($errors)) {
                    continue;
                }
                ?>
                <div class="notice notice-<?php echo esc_attr($type); ?> is-dismissible">
                        <p><?php echo implode("<br/>", $errors) ?></p>
                    </div>
            <?php } ?>
            <?php
        }
    }

    /**
     * demo_installer Output
     *
     * @since 0.0.2
     *
     * @return null
     */
    public function demo_exporter()
    {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        if ('export-demo-data' == $action && check_admin_referer('artemis_swp-demo-export', 'artemis_swp-demo-nonce')) {
            $this->export();
            $this->displayMessages();
        } ?>
        <div class="ai_swp_bg"></div>
        <div class="ai_swp_overlay"></div>
        <div class="wrap ai_swp_scontainer">
                <div class="setup_theme_header">
                    <h2 class="ai_swp_settings"><?php esc_html_e('Export Demo Data', 'artemis-swp') ?></h2>
                </div>
            </div>

        <div class="ai-importer-wrap">
		        <form method="post">
		          	<br/>
		          	<br/>
                    <input type="hidden" name="artemis_swp-demo-nonce"
                           value="<?php echo wp_create_nonce('artemis_swp-demo-export'); ?>"/>
		          	<input name="export" class="panel-save button-primary ai-import-start" type="submit"
                           value="<?php echo esc_html__('Export', 'artemis-swp'); ?>"/>
		          	<input type="hidden" name="action" value="export-demo-data"/>
	 	        </form>
 	        </div>
        <br/>
        <br/><?php

    }

    public function export()
    {
        if (!is_writable($this->_export_dir)) {
            $this->addMessage( sprintf(esc_html__('The export directory \'%s\' is not writable.', 'artemis-swp'), $this->_export_dir ));

            return;
        }

        $this->_doExport();

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global /** @var WP_Filesystem_Base $wp_filesystem */
        $wp_filesystem;
        /* Start export data to files*/

        $errors = 0;
        //Content - pages, posts, etc

        //export attachments
        if (isset($this->_export_data['content']['item'])) {
            $att_dir = $this->_export_dir . 'attachments/';
            wp_mkdir_p($att_dir);
            foreach ($this->_export_data['content']['item'] as &$post) {
                if ('attachment' == $post['post_type']) {
                    //todo: decide whether to keep demo site url or use rest url

                    //remove _wp_attached_file and _wp_attachment_metadata meta values
                    if (isset($post['postmeta'])) {
                        foreach ($post['postmeta'] as $index => $meta) {
                            if ('_wp_attachment_metadata' == $meta['meta_key']) {
                                unset($post['postmeta'][$index]);
                            }
                        }
                    }
                }
            }
        }
        $json_content          = wp_json_encode($this->_export_data['content']);
        $wp_filesystem->errors = new WP_Error();
        if (!$wp_filesystem->put_contents($this->_export_dir . 'content.json', $json_content, 0644)) {
            $errors = $wp_filesystem->errors;
            $msg    = esc_html__('Failed to save content data.', 'artemis-swp');
            if ($errors->get_error_messages()) {
                $msg .= esc_html__('Please see errors: ', 'artemis-swp');
                $msg .= implode('<br/>', $wp_filesystem->get_error_messages());
            }
            $this->addMessage($msg);
            $errors ++;
        } else {
            $this->addMessage(esc_html__('Demo Content saved successfully!', 'artemis-swp'), 'success');
        }

        //Theme options and settings
        $json_theme            = wp_json_encode($this->_export_data['theme']);
        $wp_filesystem->errors = new WP_Error();

        if (!$wp_filesystem->put_contents($this->_export_dir . 'theme_options.json', $json_theme, 0644)) {
            $errors = $wp_filesystem->errors;
            $msg    = esc_html__('Failed to save theme settings data', 'artemis-swp');
            if ($errors->get_error_messages()) {
                $msg .= esc_html__('Please see errors: ', 'artemis-swp');
                $msg .= implode('<br/>', $wp_filesystem->get_error_messages());
            }
            $this->addMessage($msg);
            $errors ++;
        } else {
            $this->addMessage(esc_html__('Theme settings saved successfully!', 'artemis-swp'), 'success');
        }

        $wp_filesystem->errors = new WP_Error();
        //Widgets
        $json_widgets = wp_json_encode($this->_export_data['widgets']);
        if (!$wp_filesystem->put_contents($this->_export_dir . 'widgets.json', $json_widgets, 0644)) {
            $errors = $wp_filesystem->errors;
            $msg    = esc_html__('Failed to save widgets data', 'artemis-swp');
            if ($errors->get_error_messages()) {
                $msg .= esc_html__('Please see errors: ', 'artemis-swp');
                $msg .= implode('<br/>', $wp_filesystem->get_error_messages());
            }
            $this->addMessage($msg);
            $errors ++;
        } else {
            $this->addMessage(esc_html__('Widgets saved successfully!', 'artemis-swp'), 'success');
        }

        if ($errors < 3) {
            $this->addMessage(sprintf(wp_kses_post( __('Please check the <bold>\'%s\'</bold> folder', 'artemis-swp') ), $this->_export_dir), 'success');
        }
    }

    private function addMessage($message, $type = 'error')
    {
        $this->_errors[$type][] = $message;
    }

    protected function _doExport()
    {
        $this->_preparePosts();
        $this->_prepareTerms();

        $this->_export_data['version']       = self::$VERSION;
        $this->_export_data['title']         = get_bloginfo_rss('url');
        $this->_export_data['description']   = get_bloginfo_rss('description');
        $this->_export_data['language']      = get_bloginfo_rss('language');
        $this->_export_data['pubDate']       = date('D, d M Y H:i:s +0000');
        $this->_export_data['base_site_url'] = $this->_siteUrl();
        $this->_export_data['base_blog_url'] = get_bloginfo_rss('url');
        if ( ARTEMIS_SWP_is_woocommerce_active() ) {
            $this->_export_data['woocommerce_settings'] = array(
                'shop_catalog_image_size'   => get_option( 'shop_catalog_image_size' ),
                'shop_single_image_size'    => get_option( 'shop_single_image_size' ),
                'shop_thumbnail_image_size' => get_option( 'shop_thumbnail_image_size' ),
            );
        }

        $this->_authorsList();
        $this->_categoriesList();
        $this->_tagsList();
        $this->_termsList();
        $this->_menuList();
        $this->_postList();
        $this->_export_data = array( 'content' => $this->_export_data );

        $this->_exportWidgets();
        $this->_exportTheme();
        $this->_revSliders();

        return $this->_export_data;
    }

    protected function _preparePosts()
    {
        /** @global wpdb $wpdb */
        global $wpdb;
        if ($this->_post_ids) {
            return $this->_post_ids;
        }

        if ('all' != $this->_options['content'] && post_type_exists($this->_options['content'])) {
            $ptype = get_post_type_object($this->_options['content']);
            if (!$ptype->can_export) {
                $this->_options['content'] = 'post';
            }

            $where = $wpdb->prepare("{$wpdb->posts}.post_type = %s", $this->_options['content']);
        } else {
            $post_types = get_post_types(array( 'can_export' => true ));
            $esses      = array_fill(0, count($post_types), '%s');
            $where      = $wpdb->prepare("{$wpdb->posts}.post_type IN (" . implode(',', $esses) . ')', $post_types);
        }

        if ($this->_options['status'] && ('post' == $this->_options['content'] || 'page' == $this->_options['content'])) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_status = %s", $this->_options['status']);
        } else {
            $where .= " AND {$wpdb->posts}.post_status != 'auto-draft'";
        }

        $join = '';
        if ($this->_options['category'] && 'post' == $this->_options['content']) {
            if ($this->_term = term_exists($this->_options['category'], 'category')) {
                $join  = "INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)";
                $where .= $wpdb->prepare(" AND {$wpdb->term_relationships}.term_taxonomy_id = %d", $this->_term['term_taxonomy_id']);
            }
        }

        if ('post' == $this->_options['content'] || 'page' == $this->_options['content'] || 'attachment' == $this->_options['content']) {
            if ($this->_options['author']) {
                $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_author = %d", $this->_options['author']);
            }

            if ($this->_options['start_date']) {
                $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_date >= %s", date('Y-m-d', strtotime($this->_options['start_date'])));
            }

            if ($this->_options['end_date']) {
                $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_date < %s", date('Y-m-d', strtotime('+1 month', strtotime($this->_options['end_date']))));
            }
        }

        // Grab a snapshot of post IDs, just in case it changes during the export.
        $this->_post_ids = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} $join WHERE $where");

        $this->_post_ids = array_map('absint', $this->_post_ids);
    }

    protected function _prepareTerms()
    {

        if (isset($this->_term) && $this->_term) {
            $cat         = get_term($this->_term['term_id'], 'category');
            $this->_cats = array( $cat->term_id => $cat );
            unset($this->_term, $cat);
        } elseif ('all' == $this->_options['content']) {
            $categories  = (array)get_categories(array( 'get' => 'all' ));
            $this->_tags = (array)get_tags(array( 'get' => 'all' ));

            $custom_taxonomies = get_taxonomies(array( '_builtin' => false ));
            $custom_terms      = (array)get_terms($custom_taxonomies, array( 'get' => 'all' ));

            // Put categories in order with no child going before its parent.
            while ($cat = array_shift($categories)) {
                if ($cat->parent == 0 || isset($this->_cats[$cat->parent])) {
                    $this->_cats[$cat->term_id] = $cat;
                } else {
                    $categories[] = $cat;
                }
            }

            // Put terms in order with no child going before its parent.
            while ($t = array_shift($custom_terms)) {
                if ($t->parent == 0 || isset($this->_terms[$t->parent])) {
                    $this->_terms[$t->term_id] = $t;
                } else {
                    $custom_terms[] = $t;
                }
            }

            unset($categories, $custom_taxonomies, $custom_terms);
        }
    }

    protected function _siteUrl()
    {
        // Multisite: the base URL.
        if (is_multisite()) {
            return esc_url(network_home_url('/'));
        } // WordPress (single site): the blog URL.
        else {
            return get_bloginfo_rss('url');
        }
    }

    protected function _authorsList()
    {
        global $wpdb;

        if (!empty($this->_post_ids)) {
            $and = 'AND ID IN ( ' . implode(', ', $this->_post_ids) . ')';
        } else {
            $and = '';
        }

        $this->_authors = array();
        $results        = $wpdb->get_results("SELECT DISTINCT post_author FROM $wpdb->posts WHERE post_status != 'auto-draft' $and");
        foreach ((array)$results as $result) {
            $this->_authors[] = get_userdata($result->post_author);
        }

        $this->_authors = array_filter($this->_authors);

        if (count($this->_authors)) {
            $this->_export_data['authors'] = array();

            foreach ($this->_authors as $author) {
                $this->_export_data['authors'][$author->user_login] = array(
                    'author_id'           => intval($author->ID),
                    'author_login'        => $this->_cdata($author->user_login),
                    'author_email'        => $this->_cdata($author->user_email),
                    'author_display_name' => $this->_cdata($author->display_name),
                    'author_first_name'   => $this->_cdata($author->first_name),
                    'author_last_name'    => $this->_cdata($author->last_name),
                );
            }
        }

    }

    protected function _cdata($str)
    {
        if (!seems_utf8($str)) {
            $str = utf8_encode($str);
        }

        return $str;
    }

    protected function _categoriesList()
    {
        if (count($this->_cats)) {
            $this->_export_data['category'] = array();
            /** @var WP_Term $category */
            foreach ($this->_cats as $category) {
                $cat = array(
                    'term_id'            => intval($category->term_id),
                    'category_nice_name' => $this->_cdata($category->slug),
                    'category_parent'    => $this->_cdata($category->parent ? $this->_cats[$category->parent]->slug : ''),
                );
                if (!empty($category->name)) {
                    $cat['cat_name'] = $this->_cdata($category->name);
                }
                if (!empty($category->description)) {
                    $cat['category_description'] = $this->_cdata($category->description);
                }

                $this->_export_data['category'][] = $cat;
            }
        }
    }

    protected function _tagsList()
    {
        if (count($this->_tags)) {
            $this->_export_data['tag'] = array();
            foreach ($this->_tags as $tag) {
                $t = array(
                    'term_id'  => intval($tag->term_id),
                    'tag_slug' => $this->_cdata($tag->slug),
                );

                if (!empty($tag->name)) {
                    $t['tag_name'] = $this->_cdata($tag->name);
                }
                if (!empty($tag->description)) {
                    $t['tag_description'] = $this->_cdata($tag->description);
                }

                $this->_export_data['tag'][] = $t;
            }
        }
    }

    protected function _termsList()
    {
        if (count($this->_terms)) {
            $this->_export_data['term'] = array();
            foreach ($this->_terms as $term) {
                $t = array(
                    'term_id'       => $this->_cdata($term->term_id),
                    'term_taxonomy' => $this->_cdata($term->taxonomy),
                    'term_slug'     => $this->_cdata($term->slug),
                    'term_parent'   => $this->_cdata($term->parent ? $this->_terms[$term->parent]->slug : ''),
                );

                if (!empty($term->name)) {
                    $t['term_name'] = $this->_cdata($term->name);
                }
                if (!empty($term->description)) {
                    $t['term_description'] = $this->_cdata($term->description);
                }

                $this->_export_data['term'][] = $t;
            }
        }
    }

    protected function _menuList()
    {
        if ('all' == $this->_options['content']) {
            $nav_menus = wp_get_nav_menus();
            if (empty($nav_menus) || !is_array($nav_menus)) {
                return;
            }
            if (!isset($this->_export_data['term'])) {
                $this->_export_data['term'] = array();
            }
            foreach ($nav_menus as $menu) {
                $m = array(
                    'term_id'       => intval($menu->term_id),
                    'term_taxonomy' => 'nav_menu',
                    'term_slug'     => $this->_cdata($menu->slug),
                );

                if (!empty($menu->name)) {
                    $m['term_name'] = $menu->name;
                }

                $this->_export_data['term'][] = $m;
            }
        }

    }

    protected function _postList()
    {
        if (count($this->_post_ids)) {
            /**
             * @global WP_Query $wp_query
             * @global wpdb     $wpdb
             * @global WP_Post  $post
             */
            global $wp_query, $wpdb, $post;

            $wp_query->in_the_loop = true;

            //do not alter the object's post ids
            $post_ids                   = $this->_post_ids;
            $this->_export_data['item'] = array();

            //fetch 20 posts at a time
            while ($next_posts = array_splice($post_ids, 0, 20)) {
                $where = 'WHERE ID IN (' . join(',', $next_posts) . ')';
                $posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts} $where");
                foreach ($posts as $post) {
                    setup_postdata($post);

                    $is_sticky = is_sticky($post->ID) ? 1 : 0;
                    $p         = array(
                        'title'          => $this->_cdata($post->post_title),
                        'link'           => esc_url(get_permalink()),
                        'pubDate'        => mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false),
                        'creator'        => $this->_cdata(get_the_author_meta('login')),
                        'guid'           => get_the_guid(),
                        'description'    => '',
                        'content'        => $this->_cdata(apply_filters('the_content_export', $post->post_content)),
                        'excerpt'        => $this->_cdata(apply_filters('the_excerpt_export', $post->post_excerpt)),
                        'post_id'        => intval($post->ID),
                        'post_date'      => $this->_cdata($post->post_date),
                        'post_date_gmt'  => $this->_cdata($post->post_date_gmt),
                        'comment_status' => $this->_cdata($post->comment_status),
                        'ping_status'    => $this->_cdata($post->ping_status),
                        'post_name'      => $this->_cdata($post->post_name),
                        'status'         => $this->_cdata($post->post_status),
                        'post_parent'    => intval($post->post_parent),
                        'menu_order'     => intval($post->menu_order),
                        'post_type'      => $this->_cdata($post->post_type),
                        'post_password'  => $this->_cdata($post->post_password),
                        'is_sticky'      => intval($is_sticky),
                    );
                    if ('attachment' == $post->post_type) {
                        $p['attachment_url'] = $this->_cdata(wp_get_attachment_url($post->ID));
                    }

                    $taxonomies = get_object_taxonomies($post->post_type);
                    if (!empty($taxonomies)) {
                        $p['terms'] = array();
                        $terms      = wp_get_object_terms($post->ID, $taxonomies);
                        foreach ((array)$terms as $term) {
                            $p['terms'][] = array(
                                'domain'   => $this->_cdata($term->taxonomy),
                                'nicename' => $this->_cdata($term->slug),
                                'name'     => $this->_cdata($term->name)
                            );
                        }
                    }

                    $postmeta = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d", $post->ID));
                    if ($postmeta) {
                        $p['postmeta'] = array();
                        foreach ($postmeta as $meta) {
                            $p['postmeta'][] = array(
                                'meta_key'   => $this->_cdata($meta->meta_key),
                                'meta_value' => $this->_cdata($meta->meta_value),
                            );
                        }
                    }

                    $_comments = $wpdb->get_results($wpdb->prepare("SELECT * " .
                                                                   "FROM $wpdb->comments " .
                                                                   "WHERE comment_post_ID = %d AND " .
                                                                   "comment_approved <> 'spam'", $post->ID));
                    $comments  = array_map('get_comment', $_comments);
                    if ($comments) {
                        $p['comments'] = array();
                        foreach ($comments as $c) {
                            $comment = array(
                                'comment_id'           => intval($c->comment_ID),
                                'comment_author'       => $this->_cdata($c->comment_author),
                                'comment_author_email' => $this->_cdata($c->comment_author_email),
                                'comment_author_url'   => $this->_cdata(esc_url_raw($c->comment_author_url)),
                                'comment_author_IP'    => $this->_cdata($c->comment_author_IP),
                                'comment_date'         => $this->_cdata($c->comment_date),
                                'comment_date_gmt'     => $this->_cdata($c->comment_date_gmt),
                                'comment_content'      => $this->_cdata($c->comment_content),
                                'comment_approved'     => $this->_cdata($c->comment_approved),
                                'comment_type'         => $this->_cdata($c->comment_type),
                                'comment_parent'       => intval($c->comment_parent),
                                'comment_user_id'      => intval($c->comment_user_id),
                            );

                            $c_meta  = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->commentmeta WHERE comment_id = %d", $c->comment_ID));
                            $c_metas = array();
                            foreach ($c_meta as $meta) {
                                if (apply_filters('wxr_export_skip_commentmeta', false, $meta->meta_key, $meta)) {
                                    continue;
                                }
                                $c_metas[] = array(
                                    'meta_key'   => $this->_cdata($meta->meta_key),
                                    'meta_value' => $this->_cdata($meta->meta_value),
                                );
                            }
                            if ($c_metas) {
                                $comment['commentmeta'] = $c_metas;
                            }

                            $p['comments'][] = $comment;
                        }
                    }


                    $this->_export_data['item'][] = $p;
                }
            }
        }
    }

    protected function _revSliders()
    {
        if (is_plugin_active('revslider/revslider.php')) {
            global $wpdb;
            //get revslider plugin dir path
            $revsliderIncPath       = WP_PLUGIN_DIR . '/revslider/inc_php/';
            self::$revslider_prefix = $wpdb->base_prefix;
            if (is_multisite()) {
                global $blog_id;
                if ($blog_id != 1) {
                    self::$revslider_prefix .= $blog_id . '_';
                }
            }

            $revslider_globals_file = $revsliderIncPath . 'revslider_globals.class.php';
            if (!file_exists($revslider_globals_file)) {
                return array();
            }
            include_once $revslider_globals_file;

            $revslider_table       = self::$revslider_prefix . GlobalsRevSlider::TABLE_SLIDERS_NAME;
            $revslides_table       = self::$revslider_prefix . GlobalsRevSlider::TABLE_SLIDES_NAME;
            $revstaticslides_table = self::$revslider_prefix . GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME;

            //get all sliders
            $sliders = $wpdb->get_results("SELECT * FROM {$revslider_table}", ARRAY_A);

            $this->_export_data['revslider'] = array(
                'sliders'    => array(),
                'images'     => array(),
                'styles'     => '',
                'animations' => ''
            );

            foreach ($sliders as $slider) {
                //get slides
                $slider['params'] = json_decode($slider['params'], true);
                $stmt             = $wpdb->prepare("SELECT * FROM {$revslides_table} WHERE slider_id = %s", $slider['id']);
                $slides           = $wpdb->get_results($stmt, ARRAY_A);

                $usedCaptions   = array();
                $usedAnimations = array();

                if (count($slides)) {
                    $slider['slides'] = array();
                    foreach ($slides as $slide) {
                        $slide['params'] = json_decode($slide['params'], true);
                        $slide['layers'] = json_decode($slide['layers'], true);


                        if (isset($slide['layers']) && !empty($slide['layers']) && count($slide['layers']) > 0) {
                            foreach ($slide['layers'] as $lKey => $layer) {
                                if (isset($layer['style']) && $layer['style'] != '') {
                                    $usedCaptions[$layer['style']] = true;
                                }
                                if (isset($layer['animation']) && $layer['animation'] != '' && strpos($layer['animation'], 'customin') !== false) {
                                    $usedAnimations[str_replace('customin-', '', $layer['animation'])] = true;
                                }
                                if (isset($layer['endanimation']) && $layer['endanimation'] != '' && strpos($layer['endanimation'], 'customout') !== false) {
                                    $usedAnimations[str_replace('customout-', '', $layer['endanimation'])] = true;
                                }
                            }
                        }
                        $slider['slides'][] = $slide;
                    }
                }

                $stmt          = $wpdb->prepare("SELECT * FROM {$revstaticslides_table} WHERE slider_id = %s", $slider['id']);
                $static_slides = $wpdb->get_results($stmt, ARRAY_A);

                if (count($static_slides)) {
                    $slider['static_slides'] = array();
                    foreach ($static_slides as $slide) {

                        $slide['params'] = json_decode($slide['params'], true);
                        $slide['layers'] = json_decode($slide['layers'], true);


                        if (isset($slide['layers']) && !empty($slide['layers']) && count($slide['layers']) > 0) {
                            foreach ($slide['layers'] as $lKey => $layer) {
                                if (isset($layer['style']) && $layer['style'] != '') {
                                    $usedCaptions[$layer['style']] = true;
                                }
                                if (isset($layer['animation']) && $layer['animation'] != '' && strpos($layer['animation'], 'customin') !== false) {
                                    $usedAnimations[str_replace('customin-', '', $layer['animation'])] = true;
                                }
                                if (isset($layer['endanimation']) && $layer['endanimation'] != '' && strpos($layer['endanimation'], 'customout') !== false) {
                                    $usedAnimations[str_replace('customout-', '', $layer['endanimation'])] = true;
                                }
                            }
                        }

                        $slider['static_slides'][] = $slide;
                    }
                }

                if (!empty($usedCaptions)) {
                    $captions = array();
                    foreach ($usedCaptions as $class => $val) {
                        $cap = $this->getCaptionsContentArray($class);
                        if (!empty($cap)) {
                            $captions[] = $cap;
                        }
                    }
                    $this->_export_data['revslider']['styles'] .= "\r\n" . $this->parseArrayToCss($captions, "\n", false);
                }

                if (!empty($usedAnimations)) {
                    $animation = array();
                    foreach ($usedAnimations as $anim => $val) {
                        $anima = $this->getFullCustomAnimationByID($anim);
                        if ($anima !== false) {
                            $animation[] = $this->getFullCustomAnimationByID($anim);
                        }

                    }
                    if (!empty($animation)) {
                        $this->_export_data['revslider']['animations'] .= "\r\n" . serialize($animation);
                    }
                }

                $this->_export_data['revslider']['sliders'][] = $slider;
            }
            $this->_export_data['revslider']['styles']     = trim($this->_export_data['revslider']['styles'], "\r\n");
            $this->_export_data['revslider']['animations'] = trim($this->_export_data['revslider']['animations'], "\r\n");

            return $this->_export_data['revslider'];
        }

        return array();
    }

    /**
     *
     * get animation params by id
     *
     * @param $id
     *
     * @return array|bool
     */
    public function getFullCustomAnimationByID($id)
    {
        global $wpdb;
        $revcss_table = self::$revslider_prefix . GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;
        $result       = $wpdb->get_results($wpdb->prepare("SELECT * FROM $revcss_table WHERE id = %s", $id), ARRAY_A);

        if (!empty($result)) {
            $customAnimations           = array();
            $customAnimations['id']     = $result[0]['id'];
            $customAnimations['handle'] = $result[0]['handle'];
            $customAnimations['params'] = json_decode(str_replace("'", '"', $result[0]['params']), true);

            return $customAnimations;
        }

        return false;
    }

    /**
     *
     * get wp-content path
     */
    protected function getPathUploads()
    {
        global $wpdb;
        if (is_multisite()) {
            if (!defined("BLOGUPLOADDIR")) {
                $pathBase    = ABSPATH;
                $pathContent = $pathBase . "wp-content/uploads/sites/{$wpdb->blogid}/";
            } else {
                $pathContent = BLOGUPLOADDIR;
            }
        } else {
            $pathContent = WP_CONTENT_DIR;
            if (!empty($pathContent)) {
                $pathContent .= "/";
            } else {
                $pathBase    = ABSPATH;
                $pathContent = $pathBase . "wp-content/uploads/";
            }
        }

        return ($pathContent);
    }

    protected function getCaptionsContentArray($handle = false)
    {
        global $wpdb;
        $revcss_table = self::$revslider_prefix . GlobalsRevSlider::TABLE_CSS_NAME;
        $result       = $wpdb->get_results('SELECT * FROM ' . $revcss_table, ARRAY_A);
        $contentCSS   = $this->parseDbArrayToArray($result, $handle);

        return ($contentCSS);
    }

    protected function parseDbArrayToArray($cssArray, $handle = false)
    {

        if (!is_array($cssArray) || empty($cssArray)) {
            return false;
        }

        foreach ($cssArray as $key => $css) {
            if ($handle != false) {
                if ($cssArray[$key]['handle'] == '.tp-caption.' . $handle) {
                    $cssArray[$key]['params']   = json_decode(str_replace("'", '"', $css['params']), true);
                    $cssArray[$key]['hover']    = json_decode(str_replace("'", '"', $css['hover']), true);
                    $cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']), true);

                    return $cssArray[$key];
                } else {
                    unset($cssArray[$key]);
                }
            } else {
                $cssArray[$key]['params']   = json_decode(str_replace("'", '"', $css['params']), true);
                $cssArray[$key]['hover']    = json_decode(str_replace("'", '"', $css['hover']), true);
                $cssArray[$key]['settings'] = json_decode(str_replace("'", '"', $css['settings']), true);
            }
        }

        return $cssArray;
    }

    protected function parseArrayToCss($cssArray, $nl = "\n\r", $do_short = true)
    {
        $css = '';
        foreach ($cssArray as $id => $attr) {
            if ($do_short) {
                $stripped = '';
                if (strpos($attr['handle'], '.tp-caption') !== false) {
                    $stripped = trim(str_replace('.tp-caption', '', $attr['handle']));
                }
            }
            $styles = (array)$attr['params'];
            $css    .= $attr['handle'];
            if ($do_short) {
                if (!empty($stripped)) {
                    $css .= ', ' . $stripped;
                }
            }
            $css .= " {" . $nl;

            if (is_array($styles) && !empty($styles)) {
                foreach ($styles as $name => $style) {
                    if ($name == 'background-color' && strpos($style, 'rgba') !== false) { //rgb && rgba
                        $rgb = explode(',', str_replace('rgba', 'rgb', $style));
                        unset($rgb[count($rgb) - 1]);
                        $rgb = implode(',', $rgb) . ')';
                        $css .= $name . ':' . $rgb . ";" . $nl;
                    }
                    $css .= $name . ':' . $style . ";" . $nl;
                }
            }
            $css .= "}" . $nl . $nl;

            //add hover
            $setting = (array)$attr['settings'];
            if (@$setting['hover'] == 'true') {
                $hover = (array)$attr['hover'];
                if (is_array($hover)) {
                    $css .= $attr['handle'] . ":hover";
                    if (!empty($stripped)) {
                        $css .= ', ' . $stripped . ":hover";
                    }
                    $css .= " {" . $nl;
                    foreach ($hover as $name => $style) {
                        if ($name == 'background-color' && strpos($style, 'rgba') !== false) { //rgb && rgba
                            $rgb = explode(',', str_replace('rgba', 'rgb', $style));
                            unset($rgb[count($rgb) - 1]);
                            $rgb = implode(',', $rgb) . ')';
                            $css .= $name . ':' . $rgb . ";" . $nl;
                        }
                        $css .= $name . ':' . $style . ";" . $nl;
                    }
                    $css .= "}" . $nl . $nl;
                }
            }
        }

        return $css;
    }

    protected function _exportWidgets()
    {
        $sidebars_array = get_option('sidebars_widgets');
        $sidebar_export = array();
        $widgets        = array();
        foreach ($sidebars_array as $sidebar => $s_widgets) {
            if (!empty($s_widgets) && is_array($s_widgets)) {
                foreach ($s_widgets as $sidebar_widget) {
                    $sidebar_export[$sidebar][] = $sidebar_widget;
                    $widget                     = array();
                    $widget['type']             = trim(substr($sidebar_widget, 0, strrpos($sidebar_widget, '-')));
                    $widget['type-index']       = trim(substr($sidebar_widget, strrpos($sidebar_widget, '-') + 1));
                    $widgets[]                  = $widget;
                }
            }
        }

        $widgets_array = array();
        foreach ($widgets as $widget) {
            $widget_val                                            = get_option('widget_' . $widget['type']);
            $widget_val                                            = apply_filters('widget_data_export', $widget_val, $widget['type']);
            $multiwidget_val                                       = $widget_val['_multiwidget'];
            $widgets_array[$widget['type']][$widget['type-index']] = $widget_val[$widget['type-index']];
            if (isset($widgets_array[$widget['type']]['_multiwidget'])) {
                unset($widgets_array[$widget['type']]['_multiwidget']);
            }

            $widgets_array[$widget['type']]['_multiwidget'] = $multiwidget_val;
        }
        unset($widgets_array['export']);
        $export_array                  = array( $sidebar_export, $widgets_array );
        $this->_export_data['widgets'] = $export_array;
    }

    protected function _exportTheme()
    {
        $theme_mods = get_option('theme_mods_artemis-swp');

        if ($theme_mods) {
            $this->_export_data['theme']['mods'] = $theme_mods;
        }
        $theme_settings_tabs = array(
            'artemis_theme_general_options',
            'artemis_theme_social_options',
            'artemis_theme_footer_options',
            'artemis_theme_contact_options',
            'artemis_theme_shop_options',
        );
        foreach ($theme_settings_tabs as $tab) {
            $this->_export_data['theme'][$tab] = get_option($tab);
        }

        $theme_customizer = get_option('lc_customize', array());
        if( $theme_customizer ){
            $this->_export_data['theme']['customizer']  = $theme_customizer;
        }
        $this->_export_data['theme']['show_on_front']  = get_option('show_on_front');
        $this->_export_data['theme']['page_on_front']  = get_option('page_on_front');
        $this->_export_data['theme']['page_for_posts'] = get_option('page_for_posts');

        $this->_export_data['theme'] = array_filter($this->_export_data['theme']);

    }

    /**
     * @return array
     */
    public function getExportData()
    {
        return $this->_export_data;
    }
}
