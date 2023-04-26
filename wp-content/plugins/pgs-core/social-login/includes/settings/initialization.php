<?php
/**
* Check requirements and register settings 
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
* Check minimum requirements. Display fail page if they are not met.
*
* This function will only test the strict minimal
*/
function pgssl_check_requirements() {
	if (
		   ! version_compare( PHP_VERSION, '5.4.0', '>=' )
		|| ! isset( $_SESSION["pgssl::plugin"] )
		|| ! function_exists('curl_init')
		|| ! function_exists('json_decode')
	) {
		return false;
	}

	$curl_version = curl_version();

	if( ! ( $curl_version['features'] & CURL_VERSION_SSL ) ) {
		return false;
	}

	return true;
}

function pgssl_get_components(){
	
	return array(
		"networks" => array(
			"type"       => "core",
			"label"      => _pgssl__("Networks", 'pgssl-text-domain'),
			"description"=> _pgssl__("Social networks setup.", 'pgssl-text-domain'),
			"enabled"    => true,
			"visible"    => true,
			"component"  => "networks",
			"sub_menu"   => true,
		),
		"config" => array(
			"type"       => "core",
			"label"      => _pgssl__("Config", 'pgssl-text-domain'),
			"description"=> _pgssl__("PGS Social Login advanced configuration.", 'pgssl-text-domain'),
			"enabled"    => true,
			"visible"    => true,
			"component"  => "config",
			"sub_menu"   => false,
		),
		"users" => array(
			"type"       => "addon",
			"label"      => _pgssl__("Users", 'pgssl-text-domain'),
			"description"=> _pgssl__("PGS Social Login users manager.", 'pgssl-text-domain'),
			"enabled"    => true,
			"visible"    => true,
			"component"  => "users",
			"sub_menu"   => false,
		),
		"contacts" => array(
			"type"       => "addon",
			"label"      => _pgssl__("Contacts", 'pgssl-text-domain'),
			"description"=> _pgssl__("PGS Social Login users contacts manager", 'pgssl-text-domain'),
			"enabled"    => true,
			"visible"    => true,
			"component"  => "contacts"
		),
		"buddypress" => array(
			"type"       => "addon",
			"label"      => _pgssl__("BuddyPress", 'pgssl-text-domain'),
			"description"=> _pgssl__("Makes PGS Social Login compatible with BuddyPress: Widget integration, Users avatars and xProfiles mapping.", 'pgssl-text-domain'),
			"enabled"    => true,
			"visible"    => true,
			"component"  => "buddypress"
		),
		"tools"       => array(
			"type"       => "addon",
			"label"       => _pgssl__("Tools", 'pgssl-text-domain'),
			"description"=> '',
			"visible"     => true,
			"enabled"     => true,
			"component"   => "tools",
		),
		"watchdog"    => array(
			"type"       => "addon",
			"label"       => _pgssl__("Log viewer", 'pgssl-text-domain'),
			"description"=> '',
			"visible"     => true,
			"enabled"     => true,
			"component"   => "watchdog",
		),
		"auth-paly"   => array(
			"type"       => "addon",
			"label"       => _pgssl__("Auth test", 'pgssl-text-domain'),
			"description"=> '',
			"visible"     => true,
			"enabled"     => true,
			"component"   => "auth-paly",
		),
		/*
		"components"  => array(
			"type"       => "addon",
			"label"       => _pgssl__("Components", 'pgssl-text-domain'),
			"description"=> '',
			"visible"     => true,
			"enabled"     => true,
			"component"   => "components",
		),
		*/
		"help"        => array(
			"type"       => "addon",
			"label"      => _pgssl__('Help', 'pgssl-text-domain'),
			"description"=> '',
			"visible"    => true,
			"enabled"    => true,
			"component"  => "help",
		),
	);
	
}

/**
* Check if a component is enabled
*/
function pgssl_is_component_enabled( $component ) {
	if( get_option( "pgssl_components_" . $component . "_enabled" ) == 1 ) {
		return true;
	}

	return false;
}

/**
* Register components (Bulk action)
*/
function pgssl_register_components() {
	global $pgssl_admin_tabs;
	
	// HOOKABLE:
	do_action( 'pgssl_register_components' );

	pgssl_get_components();
}

/**
* Register core settings ( options; components )
*/
function pgssl_register_setting() {
	global $pgssl_admin_tabs;
	
	$providers_config = pgssl_get_providers();

	// HOOKABLE:
	do_action( 'pgssl_register_setting' );

	pgssl_register_components();

	// idps credentials
	foreach( $providers_config AS $item ) {
		$provider_id          = isset( $item["provider_id"]       ) ? $item["provider_id"]       : null;
		$require_client_id    = isset( $item["require_client_id"] ) ? $item["require_client_id"] : null;
		$require_registration = isset( $item["new_app_link"]      ) ? $item["new_app_link"]      : null;

		/**
		* @fixme
		*
		* Here we should only register enabled providers settings. postponed. patches are welcome.
		***
			$default_network = isset( $item["default_network"] ) ? $item["default_network"] : null;

			if( ! $default_network || get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) != 1 .. ) {
				..
			}
		*/

		register_setting( 'pgssl_settings-group', 'pgssl_settings_' . $provider_id . '_enabled' );

		// require application?
		if( $require_registration ) {
			// api key or id ?
			if( $require_client_id ) {
				register_setting( 'pgssl_settings-group', 'pgssl_settings_' . $provider_id . '_app_id' ); 
			} else {
				register_setting( 'pgssl_settings-group', 'pgssl_settings_' . $provider_id . '_app_key' ); 
			}

			// api secret
			register_setting( 'pgssl_settings-group', 'pgssl_settings_' . $provider_id . '_app_secret' );
		}
	}

	

	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_facebook'                         ); 
	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_google'                           ); 
	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_twitter'                          ); 
	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_linkedin'                         ); 
	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_live'                             ); 
	register_setting( 'pgssl_settings-group-contacts-import'  , 'pgssl_settings_contacts_import_vkontakte'                        ); 

	register_setting( 'pgssl_settings-group-config'        , 'pgssl_settings_social_icon_set'                                  ); 

	register_setting( 'pgssl_settings-group-buddypress'       , 'pgssl_settings_buddypress_enable_mapping' ); 
	register_setting( 'pgssl_settings-group-buddypress'       , 'pgssl_settings_buddypress_xprofile_map' ); 

	register_setting( 'pgssl_settings-group-debug'            , 'pgssl_settings_debug_mode_enabled' ); 
	register_setting( 'pgssl_settings-group-development'      , 'pgssl_settings_development_mode_enabled' ); 
}
