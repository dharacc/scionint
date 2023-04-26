<?php
/** 
* Email notifications to send. so far only the admin one is implemented
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Send a notification to blog administrator when a new user register using PGSSL 
*
* also borrowed from http://wordpress.org/extend/plugins/oa-social-login/
* 
* Note: 
*   You may redefine this function
*/
if( ! function_exists( 'pgssl_admin_notification' ) ) {
	function pgssl_admin_notification( $user_id, $provider ) {
		//Get the user details
		$user = new WP_User($user_id);
		$user_login = stripslashes( $user->user_login );

		// The blogname option is escaped with esc_html on the way into the database
		// in sanitize_option we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$message  = sprintf(__('New user registration on your site: %s', 'pgssl-text-domain'), $blogname        ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'                          , 'pgssl-text-domain'), $user_login      ) . "\r\n";
		$message .= sprintf(__('Provider: %s'                          , 'pgssl-text-domain'), $provider        ) . "\r\n";
		$message .= sprintf(__('Profile: %s'                           , 'pgssl-text-domain'), $user->user_url  ) . "\r\n";
		$message .= sprintf(__('Email: %s'                             , 'pgssl-text-domain'), $user->user_email) . "\r\n";
		$message .= "\r\n--\r\n";
		$message .= "PGS Social Login\r\n";
		$message .= "http://wordpress.org/extend/plugins/wordpress-social-login/\r\n";

		@ wp_mail(get_option('admin_email'), '[PGS Social Login] '.sprintf(__('[%s] New User Registration', 'pgssl-text-domain'), $blogname), $message);
	}
}
