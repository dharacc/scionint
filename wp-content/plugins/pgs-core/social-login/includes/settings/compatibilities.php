<?php
/**
* Check and upgrade compatibilities from old versions
*
* Here we attempt to:
*	- set to default all settings
*	- make it compatible when updating from older versions, by registering new options
*
* Side note: Over time, the number of options have become too long, and as you can notice
*            things are not optimal. If you have any better idea on how to tackle this issue,
*            please don't hesitate to share it.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Check and upgrade compatibilities from old versions
*/
function pgssl_update_compatibilities() {
	delete_option( 'pgssl_settings_development_mode_enabled' );
	delete_option( 'pgssl_settings_debug_mode_enabled' );

	# contacts import
	if( ! get_option( 'pgssl_settings_contacts_import_facebook' ) ) {
		update_option( 'pgssl_settings_contacts_import_facebook', 2 );
	}

	if( ! get_option( 'pgssl_settings_contacts_import_google' ) ) {
		update_option( 'pgssl_settings_contacts_import_google', 2 );
	}

	if( ! get_option( 'pgssl_settings_contacts_import_twitter' ) ) {
		update_option( 'pgssl_settings_contacts_import_twitter', 2 );
	}

	if( ! get_option( 'pgssl_settings_contacts_import_live' ) ) {
		update_option( 'pgssl_settings_contacts_import_live', 2 );
	}

	if( ! get_option( 'pgssl_settings_contacts_import_linkedin' ) ) {
		update_option( 'pgssl_settings_contacts_import_linkedin', 2 );
	}

	if( ! get_option( 'pgssl_settings_buddypress_enable_mapping' ) ) {
		update_option( 'pgssl_settings_buddypress_enable_mapping', 2 );
	}

	# buddypress profile mapping
	if( ! get_option( 'pgssl_settings_buddypress_xprofile_map' ) ) {
		update_option( 'pgssl_settings_buddypress_xprofile_map', '' );
	}

	# if no idp is enabled then we enable the default providers (facebook, google, twitter)
	$providers_config = pgssl_get_providers();
	$nok = true;
	foreach( $providers_config AS $item ) {
		$provider_id = $item["provider_id"];

		if( get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) {
			$nok = false;
		}
	}

	if( $nok ) {
		foreach( $providers_config AS $item ) {
			$provider_id = $item["provider_id"];

			if( isset( $item["default_network"] ) && $item["default_network"] ){
				update_option( 'pgssl_settings_' . $provider_id . '_enabled', 1 );
			}
		}
	}

	global $wpdb, $pgssl_tbl_usersprofiles;

	# migrate steam users id to id64. Prior to 2.2
	$sql = "UPDATE {$wpdb->prefix}{$pgssl_tbl_usersprofiles}
		SET identifier = REPLACE( identifier, 'http://steamcommunity.com/openid/id/', '' )
		WHERE provider = 'Steam' AND identifier like 'http://steamcommunity.com/openid/id/%' ";
	$wpdb->query( $sql );
}

/**
* Old junk
*
* Seems like some people are using _internal_ functions for some reason...
*
* Here we keep few of those old/depreciated/undocumented/internal functions, so their websites
* doesn't break when updating to newer versions.
*/

// 2.1.6
function pgssl_render_login_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); return pgssl_render_auth_widget(); }
function pgssl_render_comment_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_render_login_form_login_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_render_login_form_login_on_register_and_login(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_render_login_form_login(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_shortcode_handler(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); return pgssl_shortcode_wordpress_social_login(); }

// 2.2.2
function pgssl_render_pgssl_widget_in_comment_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_render_pgssl_widget_in_wp_login_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_render_pgssl_widget_in_wp_register_form(){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); pgssl_action_wordpress_social_login(); }
function pgssl_user_custom_avatar($avatar, $mixed, $size, $default, $alt){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); return pgssl_get_wp_user_custom_avatar($html, $mixed, $size, $default, $alt); }
function pgssl_bp_user_custom_avatar($html, $args){ pgssl_deprecated_function( __FUNCTION__, '2.2.3' ); return pgssl_get_bp_user_custom_avatar($html, $args); }

// nag about it
function pgssl_deprecated_function( $function, $version ) {
	// user should be admin and logged in
	if( current_user_can('manage_options') ) {
		trigger_error( sprintf( __('%1$s is <strong>deprecated</strong> since PGS Social Login %2$s!'), $function, $version ), E_USER_NOTICE );
	}
}
