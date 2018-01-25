<?php

add_action( 'wp_ajax_artemiscontactform_action', 'ARTEMIS_SWP_process_contact_form' );
add_action( 'wp_ajax_nopriv_artemiscontactform_action', 'ARTEMIS_SWP_process_contact_form' );

if ( !function_exists( 'ARTEMIS_SWP_process_contact_form' ) ) {
	function ARTEMIS_SWP_process_contact_form()
	{
		$data = array();
		parse_str($_POST['data'], $data);
		$namedError = '';
		$ret['success'] = false;
		
		if(isset($data['contactform_nonce']) && wp_verify_nonce($data['contactform_nonce'], 'artemiscontactform_action')) {
			if (sanitize_text_field($data['contactName']) === '') {
				$hasError = true;
				$namedError = 'contactName';
			} else {
				$name = sanitize_text_field($data['contactName']);
			} 

			if (trim($data['email']) === '') {
				$hasError = true;
				$namedError = 'email';
			}
			else {
				if ((!is_email($data['email']))) {
					$hasError = true;
					$namedError = 'notEmail';
				} 
				else {
					$email = trim($data['email']);
				}
			}
			
			$phone = sanitize_text_field($data['phone']);

			if(sanitize_text_field($data['comments']) === '') {
				$commentError = esc_html__('Please enter a message.', 'artemis-swp-core');
				$hasError = true;
				$namedError = 'comments';
			}
			else {
				$comments = sanitize_text_field($data['comments']);
			}

			/*TODO: check recaptcha here*/

			if(!isset($hasError)) {
				$emailTo = ARTEMIS_SWP_AC_get_contact_form_email();

				$email_subject = esc_html__("New contact form message from your website ", "artemis-swp-core")."[" . get_bloginfo('name') . "] ";

				$email_message = $comments;
				$email_message .= "\n\n".esc_html__("From: ", "artemis-swp-core"). " " . $name . " <".$email.">\n";
				$email_message .= esc_html__("Contact Phone: ", "artemis-swp-core")." ".$phone."\n";

				$headers = "MIME-Version: 1.0\r\n" .
				"From: " . get_option('admin_email') . "\r\n" .
				"Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\r\n";		
				
				if (!wp_mail( $emailTo, $email_subject, $email_message, $headers )) {
					$namedError = 'wp_mail_failed';
				} else {
					$ret['success'] = true;	
				}
			} 
		} else {
			$namedError = 'nonce';
		}
		
		$ret['error'] = $namedError;
		echo json_encode($ret);	
		
		/*important*/
		die();
	}
}

add_action( 'wp_ajax_artemisnewsform_action', 'ARTEMIS_SWP_process_mailchimp_subscr_form' );
add_action( 'wp_ajax_nopriv_artemisnewsform_action', 'ARTEMIS_SWP_process_mailchimp_subscr_form' );

if ( !function_exists( 'ARTEMIS_SWP_process_mailchimp_subscr_form' ) ) {
function ARTEMIS_SWP_process_mailchimp_subscr_form() {
	
	$data = array();
	parse_str($_POST['data'], $data);

	$namedError = '';
	$ret['success'] = false;
	$list_id = $data['at_mc_list_id'];

	if(isset($data['subscrform_nonce']) && wp_verify_nonce($data['subscrform_nonce'], 'artemisnewsform_action')) {
		require_once( CDIR_PATH."/assets/mailchimp/MailChimp.php");

		$MailChimp = new MailChimp($data['at_mc_api_key']);
		
		$mc_merge_fields = array(
			'FNAME'=>$data["newsletter_fname"], 
			'LNAME'=>$data["newsletter_fname"]
			);
		$mc_opts = array(
				'email_address' => $data["newsletter_email"],
                'merge_fields'  => $mc_merge_fields,
                'status'        => 'subscribed'
			);
		$result = $MailChimp->post("lists/$list_id/members", $mc_opts);

		if ($MailChimp->success()) {
			$ret['success'] = true;
		} else {
			$namedError = $MailChimp->getLastError();
		}
	} else {
		$namedError = esc_html__('Nonce error. Please refresh the page and try again.', 'artemis-swp-core');
	}

	$ret['error'] = $namedError;
	echo json_encode($ret);	

	die();
}
}
?>