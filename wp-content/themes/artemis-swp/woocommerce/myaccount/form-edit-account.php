<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if (! defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_edit_account_form'); ?>

<?php
/*Artemis-swp [[[*/

/*Artemis-swp ]]]*/
?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

	<?php do_action('woocommerce_edit_account_form_start'); ?>

	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr($user->first_name); ?>" placeholder="<?php echo esc_html__('First name (required)', 'artemis-swp'); ?>"/>
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr($user->last_name); ?>" placeholder="<?php echo esc_html__('Last name (required)', 'artemis-swp'); ?>"/>
	</p>
	<div class="clear"></div>

	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" value="<?php echo esc_attr($user->user_email); ?>" placeholder="<?php echo esc_html__('Email address (required)', 'artemis-swp'); ?>"/>
	</p>

	<fieldset>
		<legend><?php esc_html_e('Password Change', 'artemis-swp'); ?></legend>

		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" placeholder="<?php echo esc_html__('Current Password (leave blank to leave unchanged)', 'artemis-swp'); ?>"/>
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" placeholder="<?php echo esc_html__('New Password (leave blank to leave unchanged)', 'artemis-swp'); ?>"/>
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" placeholder="<?php echo esc_html__('Confirm New Password', 'artemis-swp'); ?>"/>
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action('woocommerce_edit_account_form'); ?>

	<p>
		<?php wp_nonce_field('save_account_details'); ?>
		<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e('Save changes', 'artemis-swp'); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<?php do_action('woocommerce_after_edit_account_form'); ?>
