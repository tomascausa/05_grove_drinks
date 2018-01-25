<?php if (ARTEMIS_SWP_has_wishlist_on_menu()) { ?>
    <div class="at_login_wish">

      <?php if ( ARTEMIS_SWP_is_woocommerce_active() ) { ?>
        <div class="at_wishlist account_option">
            <a href="<?php echo esc_attr( ARTEMIS_SWP_get_wishlist_url() ) ?>">
              <?php echo esc_html__('Wishlist', 'artemis-swp'); ?>
              <i class="fa fa-angle-down" aria-hidden="true"></i>         
            </a>

            <div class="artemis-swp-miniwishlist">
                <?php get_template_part('views/utils/mini_wishlist'); ?>
            </div>
        </div>

      <div class="at_login account_option">
        <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo esc_attr( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"
               class="at_to_my_account"
               title="<?php esc_attr_e( 'My Account', 'artemis-swp' ); ?>"><?php esc_html_e( 'My Account', 'artemis-swp' ); ?></a>
        <?php } else { ?>
            <a href="<?php echo esc_attr( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"
               class="<?php echo esc_attr( ARTEMIS_SWP_is_login_popup_enabled() ? 'at_to_login_popup' : '' ) ?>"
               title="<?php esc_attr_e( 'Login &#47; Signup', 'artemis-swp' ); ?>"><?php esc_html_e( 'Login &#47; Signup', 'artemis-swp' ); ?></a>
        <?php } ?>
      </div>
      <?php } ?>

    </div>
<?php } ?>