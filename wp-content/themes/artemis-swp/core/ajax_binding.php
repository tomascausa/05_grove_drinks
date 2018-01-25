<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 8 Iun 2017
     * Time: 16:36
     */


    function ARTEMIS_SWP_login() {
        $nonce_value = isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '';
        $nonce_value = isset( $_POST['artemis-swp-login-nonce'] ) ? $_POST['artemis-swp-login-nonce'] : $nonce_value;

        if ( ! empty( $_POST['login'] ) ) {
            if ( wp_verify_nonce( $nonce_value, 'artemis_swp-login' ) ) {

                try {
                    $creds    = array();
                    $username = trim( $_POST['username'] );

                    $validation_error = new WP_Error();
                    $validation_error = apply_filters( 'artemis_swp_process_login_errors', $validation_error, $_POST['username'], $_POST['password'] );

                    if ( $validation_error->get_error_code() ) {
                        throw new Exception( '<strong>' . esc_html__( 'Error', 'artemis-swp' ) . ':</strong> ' . $validation_error->get_error_message() );
                    }

                    if ( empty( $username ) ) {
                        throw new Exception( '<strong>' . esc_html__( 'Error', 'artemis-swp' ) . ':</strong> ' . esc_html__( 'Username is required.', 'artemis-swp' ) );
                    }

                    if ( empty( $_POST['password'] ) ) {
                        throw new Exception( '<strong>' . esc_html__( 'Error', 'artemis-swp' ) . ':</strong> ' . esc_html__( 'Password is required.', 'artemis-swp' ) );
                    }

                    if ( is_email( $username ) && apply_filters( 'artemis_swp_get_username_from_email', true ) ) {
                        $user = get_user_by( 'email', $username );

                        if ( isset( $user->user_login ) ) {
                            $creds['user_login'] = $user->user_login;
                        } else {
                            throw new Exception( '<strong>' . esc_html__( 'Error', 'artemis-swp' ) . ':</strong> ' . esc_html__( 'No user could be found with this email address.', 'artemis-swp' ) );
                        }

                    } else {
                        $creds['user_login'] = $username;
                    }

                    $creds['user_password'] = $_POST['password'];
                    $creds['remember']      = isset( $_POST['rememberme'] );
                    $secure_cookie          = is_ssl() ? true : false;
                    $user                   = wp_signon( apply_filters( 'artemis_swp_login_credentials', $creds ), $secure_cookie );

                    if ( is_wp_error( $user ) ) {
                        $message = $user->get_error_message();
                        $message = str_replace( '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', '<strong>' . esc_html( $username ) . '</strong>', $message );
                        throw new Exception( $message );
                    } else {

                        if ( ! empty( $_POST['redirect'] ) ) {
                            $redirect = $_POST['redirect'];
                        } elseif ( wp_get_referer() ) {
                            $redirect = wp_get_referer();
                        } else {
                            $redirect = wc_get_page_permalink( 'myaccount' );
                        }
                        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                            echo json_encode( array( 'success' => true ) );
                        } else {
                            wp_redirect( apply_filters( 'artemis_swp_login_redirect', $redirect, $user ) );
                        }
                    }
                } catch ( Exception $e ) {
                    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                        echo json_encode( array( 'success' => false, 'message' => $e->getMessage() ) );
                    } else {
                        wc_add_notice( apply_filters( 'login_errors', $e->getMessage() ), 'error' );
                    }
                }
                exit;
            } else {
                if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                    echo json_encode( array( 'success' => false, 'message' => esc_html__( 'Bad Request', 'artemis-swp' ) ) );
                    exit;
                }
            }
        }
    }

    add_action( 'wp_loaded', 'ARTEMIS_SWP_login' );
    add_action( 'wp_ajax_artemis_swp_ajax_login', 'ARTEMIS_SWP_login' );
    add_action( 'wp_ajax_nopriv_artemis_swp_ajax_login', 'ARTEMIS_SWP_login' );


    function ARTEMIS_SWP_ajax_search() {
        $search_term = sanitize_text_field( $_POST['search_term'] );
        $search_for = ARTEMIS_SWP_what_ajax_search_shows();

        $args        = array(
            'post_type'   => $search_for,
            'post_status' => 'publish',
            's'           => $search_term,
            'orderby'     => array(
                'post_type'  => 'DESC',
                'post_title' => 'ASC'
            )
        );
        $query       = new WP_Query( $args );
        ob_start();
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();

                $thumb     = get_the_post_thumbnail( get_the_ID(), 'large');
                $content   = '';
                $title     = get_the_title();
                $permalink = get_the_permalink();

                $result_class = "artemis_swp_search_post";
                if (
                    ARTEMIS_SWP_is_woocommerce_active()
                    && 'product' == get_post_type()
                ) {
                    $wc_product = wc_get_product( get_the_ID() );
                    if ( $wc_product ) {
                        $thumb   = $wc_product->get_image('shop_catalog');
                        $content = $wc_product->get_price_html();
                        $title   = $wc_product->get_title();

                        $result_class .= " search_result_product";
                    }
                } else {
                    $content = '<a class="at_swp-read-more" href="'. esc_attr( $permalink ).'">'. esc_html__( 'Read more', 'artemis-swp') . '</a>';
                    $result_class .= " search_result_post";
                }
                ?>
                <div title="<?php echo esc_attr( $title ) ?>" class="<?php echo esc_attr( $result_class ); ?>">
                    <div class="artemis_swp_post_image">
                        <a href="<?php echo esc_attr( $permalink ) ?>">
                            <?php echo wp_kses_post( $thumb ); ?>
                        </a>
                    </div>
                    <div class="artemis_swp_post_title">
                        <a href="<?php echo esc_attr( $permalink ) ?>" class="search_result_post_title">
                            <?php echo wp_kses_post( wp_trim_words($title, 3) ); ?>
                        </a>
                        <?php echo wp_kses_post( $content ); ?>
                    </div>
                </div>
                <?php
            }
        } else {
            ?><p><?php echo esc_html__( 'Sorry, no pages matched your criteria.', 'artemis-swp' ); ?></p><?php
        }
        $posts = ob_get_clean();
        echo json_encode( array(
                              'posts' => $posts
                          ) );
        die();
    }

    add_action( 'wp_ajax_artemis_swp_ajax_search', 'ARTEMIS_SWP_ajax_search' );
    add_action( 'wp_ajax_nopriv_artemis_swp_ajax_search', 'ARTEMIS_SWP_ajax_search' );


    function ARTEMIS_SWP_add_to_wishlist() {
        $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'], 10 ) : 0;

        try {
            $product = wc_get_product( $product_id );

            $wl_product = array(
                'id'           => $product->get_id(),
                'price'        => $product->get_price_html(),
                'title'        => $product->get_title(),
                'image'        => $product->get_image( 'shop_thumbnail' ),
                'product_type' => $product->product_type,
                'permalink'    => $product->get_permalink()
            );

            $wishlist = ARTEMIS_SWP_get_wishlist_products();

            if ( ! isset( $wishlist[ $product->get_id() ] ) ) {
                $wishlist[ $product->get_id() ] = $wl_product;
                ARTEMIS_SWP_update_wishlist_products( $wishlist );

                set_query_var( 'artemis_swp_product', $product );
                ob_start();
                get_template_part( 'views/utils/mini_wishlist', 'item' );
                $mini_wishlist = ob_get_clean();
                $response      = array(
                    'success'            => true,
                    'code'               => 1,
                    'message'            => esc_html__( 'Added to wishlist', 'artemis-swp' ),
                    'product'            => $wl_product,
                    'mini_wishlist_item' => $mini_wishlist
                );
            } else {
                $response = array(
                    'success' => true,
                    'code'    => 2,
                    'message' => esc_html__( 'Already in wishlist', 'artemis-swp' ),
                    'product' => $wl_product
                );
            }

        } catch ( Exception $e ) {
            $response = array(
                'error'   => true,
                'message' => $e->getMessage()
            );
        }
        echo json_encode( $response );
        exit;
    }
    add_action( 'wp_ajax_artemis_swp_add_to_wishlist', 'ARTEMIS_SWP_add_to_wishlist' );
    add_action( 'wp_ajax_nopriv_artemis_swp_add_to_wishlist', 'ARTEMIS_SWP_add_to_wishlist' );

    function ARTEMIS_SWP_remove_from_wishlist() {
        $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'], 10 ) : 0;
        $wishlist   = ARTEMIS_SWP_get_wishlist_products();


        if ( isset( $wishlist[ $product_id ] ) ) {
            unset( $wishlist[ $product_id ] );
            ARTEMIS_SWP_update_wishlist_products( $wishlist );
            $response = array(
                'success'              => true,
                'products_in_wishlist' => count( $wishlist )
            );
        } else {
            $response = array(
                'error'   => true,
                'message' => esc_html__( 'Product not found in wishlist', 'artemis-swp' )
            );
        }
        echo json_encode( $response );
        exit;
    }
    add_action( 'wp_ajax_artemis_swp_remove_from_wishlist', 'ARTEMIS_SWP_remove_from_wishlist' );
    add_action( 'wp_ajax_nopriv_artemis_swp_remove_from_wishlist', 'ARTEMIS_SWP_remove_from_wishlist' );

    function ARTEMIS_SWP_remove_all_from_wishlist() {
        ARTEMIS_SWP_update_wishlist_products( array() );
        echo json_encode( array( 'success' => true ) );
        exit;
    }
    add_action( 'wp_ajax_artemis_swp_remove_all_from_wishlist', 'ARTEMIS_SWP_remove_from_wishlist' );
    add_action( 'wp_ajax_nopriv_artemis_swp_remove_all_from_wishlist', 'ARTEMIS_SWP_remove_from_wishlist' );
