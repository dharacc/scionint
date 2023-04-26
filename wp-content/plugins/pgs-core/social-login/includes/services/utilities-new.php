<?php
// Values
// 1 = Yes
// 2 = No

function pgssl_accounts_linking_enabled(){
	return 1;
}

function pgssl_social_authentication_enabled(){
	return 1;
}

function pgssl_social_registration_enabled(){
	return 1;
}

function pgssl_social_profile_completion_hook_extra_fields(){
	return 1;
}

function pgssl_social_profile_completion_require_email(){
	return 1;
}

function pgssl_social_profile_completion_change_username(){
	return 1;
}

function pgssl_force_redirect_url(){
	return 2;
}

function pgssl_redirect_url(){
	return apply_filters( 'pgssl_redirect_url', home_url() );
}

function pgssl_authentication_display(){
	// Popup = 1
	// In Page = 2
	
	return 2;
}

function pgssl_users_social_login_notification(){
	// No notification = 0
	// Notify ONLY the blog admin of a new user = 1
	return 0;
}

function pgssl_users_avatars(){
	// Display the default WordPress avatars = 0
	// Display users avatars from social networks when available = 1
	
	return 1;
}

function pgssl_connect_with_label(){
	return esc_html__( 'Connect with:', 'pgssl-text-domain' );
}

function pgssl_get_menu_type(){
	return 'sub_menu';
}

function pgssl_get_menu_path(){

	$menu_type = pgssl_get_menu_type();

	if ( $menu_type == 'sub_menu' ) {
		$menu_path = 'options-general.php';
	} else {
		$menu_path = 'admin.php';
	}

	return $menu_path;
}

function pgssl_get_tutorial_link(){

	return apply_filters( 'pgssl_tutorial_link', 'http://docs.potenzaglobalsolutions.com/social-login/' );

}

function pgssl_get_icon( $name = '' ) {
	
	// Bail early if no icon name provided.
	if( empty( $name ) ){
		return false;
	}
	
	$icons_base_url  = apply_filters( 'pgssl_icons_base_url',  trailingslashit( PGS_SOCIAL_LOGIN_PLUGIN_URL ) . 'assets/img/icons/svg' );
	$icons_base_path = apply_filters( 'pgssl_icons_base_path', trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'assets/img/icons/svg' );
	
	// make name lowercase and remove spaces and dots
	$name = str_replace(array(' ', '.', '#'), '', strtolower($name));
	$name = str_replace('+', 'plus', $name);
	
	$icon_path = trailingslashit( 	$icons_base_path ) . $name . '.svg';
	
	if( file_exists( $icon_path ) ) {
		global $wp_filesystem;
		
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		
		$icon_data = $wp_filesystem->get_contents( $icon_path );
	}
	
	if( $icon_data ) {
		return $icon_data;
	}
}