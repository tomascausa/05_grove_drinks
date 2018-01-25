<?php
/**
 * Created by PhpStorm.
 * User: th
 * Date: 23 Feb 2017
 * Time: 16:30
 */
if (ARTEMIS_SWP_is_login_popup_enabled() &&
    !is_user_logged_in() &&
    !ARTEMIS_SWP_is_my_account_page() &&
    'centered_menu' != ARTEMIS_SWP_get_menu_style()
) {
	$show_register = ARTEMIS_SWP_is_woocommerce_active() && get_option('woocommerce_enable_myaccount_registration') === 'yes';
	?>
    <div class="login_creative_container transition3" id="at_login_popup">

        <div class="lc_swp_boxed creative_menu_boxed">
            <div class="login_creative_inner lc_swp_background_image" data-bgimage="<?php echo esc_url(ARTEMIS_SWP_get_login_popup_bg_image()) ?>">
                <div class="at_login_popup_close">
                    <div class="hmb_inner">
                        <span class="hmb_line for_login_popup hmb1 on_left transition2 click"></span>
                        <span class="hmb_line for_login_popup  hmb2 on_left  transition2 click"></span>
                        <span class="hmb_line for_login_popup  hmb3 transition2 click"></span>
                    </div>
                </div>
                <div class="at_login_title active" id="at_login_title"><?php esc_html_e('Log in', 'artemis-swp') ?></div>
                <div class="at_login_title" id="at_register_title"><?php esc_html_e('Register', 'artemis-swp') ?></div>
	            <div class="at_login_popup_forms">
                    <div id="at_login_popup_messages"></div>
                    <div id="at_login_form_container" class="active">
                        <h3><?php esc_html_e('Log in your account', 'artemis-swp') ?></h3>
	                    <?php /*render login popup */ ?>
                        <form name="loginform" id="at_loginform" method="post">
                            <?php echo apply_filters('login_form_top', '', array()); ?>

	                        <?php do_action('woocommerce_login_form_start'); ?>
                            <p class="login-username">
                                <input type="text" name="username" class="input"
                                       placeholder="<?php echo esc_attr__('Enter your username or email', 'artemis-swp'); ?>"/>
                            </p>
                            <p class="login-password">
                                <input type="password" name="password" class="input" placeholder="<?php echo esc_attr__('Password', 'artemis-swp'); ?>"/>
                            </p>

		                    <?php 
                                add_filter('login_form_middle', 'ARTEMIS_SWP_add_lost_password_link');
                                echo apply_filters('login_form_middle', '', array());
                                remove_filter('login_form_middle', 'ARTEMIS_SWP_add_lost_password_link');
                            ?>

	                        <?php do_action('woocommerce_login_form'); ?>
                            <p class="login-remember">
                                <input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked"/>
                                <label for="rememberme" class="rememberme_label">
	                                <?php esc_html_e('Remember me', 'artemis-swp') ?>
                                </label>
                            </p> 

                            <p class="login-submit">
				                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                                <?php wp_nonce_field('artemis_swp-login', 'artemis-swp-login-nonce'); ?>
                                <input type="submit" class="button" name="login" id="at_login_btn"
                                       value="<?php esc_attr_e('Login', 'artemis-swp'); ?>"/>
                            </p>
                            
		                    <?php echo apply_filters('login_form_bottom', '', array()); ?>

	                        <?php do_action('woocommerce_login_form_end'); ?>
                        </form>
	                    <?php
	                    ?>
	                    <?php if ($show_register) : ?>
                            <div class="at_login_bottom">
                                <?php esc_html_e('Not a member?', 'artemis-swp') ?>
                                <a href="#" id="at_to_register"><?php esc_html_e('Register now', 'artemis-swp') ?></a>
                            </div>
	                    <?php endif; ?>
                    </div>

		            <?php if ($show_register) : ?>
                        <div id="at_register_form_container">
                            <h3><?php esc_html_e('Register with us', 'artemis-swp') ?></h3>
                            <form method="post" class="at_register">

                                <?php do_action('woocommerce_register_form_start'); ?>

	                            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

                                    <p class="register-username">
                                        <!--<label for="reg_username">--><?php //_e('Username', 'artemis-swp'); ?><!-- <span class="required">*</span></label>-->
                                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username"
                                               id="reg_username"
                                               placeholder="<?php esc_html_e('Username', 'artemis-swp') ?>"
                                               value="<?php if (! empty($_POST['username'])) {
	                                               echo esc_attr($_POST['username']);
                                               } ?>"/>
                                    </p>

	                            <?php endif; ?>

                                <p class="register-email">
                                    <!--<label for="reg_email">--><?php //_e('Email address', 'artemis-swp'); ?><!-- <span class="required">*</span></label>-->
                                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email"
                                           placeholder="<?php esc_html_e('Email address', 'artemis-swp') ?>"
                                           value="<?php if (! empty($_POST['email'])) {
	                                           echo esc_attr($_POST['email']);
                                           } ?>"/>
                                </p>

	                            <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

                                    <p class="register-password">
                                        <!--<label for="reg_password">--><?php //_e('Password', 'artemis-swp'); ?><!-- <span class="required">*</span></label>-->
                                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password"
                                               placeholder="<?php esc_html_e('Password', 'artemis-swp') ?>"
                                               id="reg_password"/>
                                    </p>

	                            <?php endif; ?>

                                <!-- Spam Trap -->
                                <div style="<?php echo((is_rtl()) ? 'right' : 'left'); ?>: -999em; position: absolute;"><label
                                            for="trap"><?php esc_html_e('Anti-spam', 'artemis-swp'); ?></label><input type="text" name="email_2" id="trap"
                                                                                                                tabindex="-1"
                                                                                                                autocomplete="off"/></div>

	                            <?php do_action('woocommerce_register_form'); ?>
	                            <?php do_action('register_form'); ?>

                                <p class="register-submit">
                                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                    <input type="submit" class="woocommerce-Button button" name="register"
                                           value="<?php esc_attr_e('Register', 'artemis-swp'); ?>"/>
                                </p>

	                            <?php do_action('woocommerce_register_form_end'); ?>

                            </form>

                            <div class="at_login_bottom">
                                <a href="#" id="at_to_login"><i class="fa fa-long-arrow-left"></i> <?php esc_html_e('Back to Login', 'artemis-swp') ?></a>
                            </div>
                        </div>
		            <?php endif ?>
                    <div id="at_loading_overlay">
                        <div class="spinner">
                            <i class="fa fa-cog fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
}
