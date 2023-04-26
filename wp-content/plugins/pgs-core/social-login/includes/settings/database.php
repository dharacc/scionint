<?php
/**
* Create database tables upon installation
*
* When plugin is activated, pgssl_database_migration_process() will attempt to create or upgrade the required database
* tables.
*
* Currently there is 2 tables :
*	- pgssl_usersprofiles:  where we store users profiles
*	- pgssl_userscontacts:  where we store users contact lists
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_database_install() {
	global $wpdb, $pgssl_tbl_usersprofiles, $pgssl_tbl_userscontacts;

	$charset_collate = $wpdb->get_charset_collate();

	// create tables
	$pgssl_usersprofiles = $wpdb->prefix . $pgssl_tbl_usersprofiles;
	$pgssl_userscontacts = $wpdb->prefix . $pgssl_tbl_userscontacts;

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$sql = "CREATE TABLE $pgssl_usersprofiles (
			id int(11) NOT NULL AUTO_INCREMENT,
			user_id int(11) NOT NULL,
			provider varchar(50) NOT NULL,
			object_sha varchar(45) NOT NULL,
			identifier varchar(255) NOT NULL,
			profileurl varchar(255) DEFAULT '',
			websiteurl varchar(255) DEFAULT '',
			photourl varchar(255) DEFAULT '',
			displayname varchar(150) DEFAULT '',
			description varchar(255) DEFAULT '',
			firstname varchar(150) DEFAULT '',
			lastname varchar(150) DEFAULT '',
			gender varchar(10) DEFAULT '',
			language varchar(20) DEFAULT '',
			age varchar(10) DEFAULT '',
			birthday varchar(10) DEFAULT '',
			birthmonth varchar(10) DEFAULT '',
			birthyear varchar(10) DEFAULT '',
			email varchar(255) DEFAULT '',
			emailverified varchar(255) DEFAULT '',
			phone varchar(75) DEFAULT '',
			address varchar(255) DEFAULT '',
			country varchar(75) DEFAULT '',
			region varchar(50) DEFAULT '',
			city varchar(50) DEFAULT '',
			zip varchar(25) DEFAULT '',
			UNIQUE KEY id (id),
			KEY user_id (user_id),
			KEY provider (provider)
		) $charset_collate;";
	dbDelta( $sql );

	$sql = "CREATE TABLE $pgssl_userscontacts (
			id int(11) NOT NULL AUTO_INCREMENT,
			user_id int(11) NOT NULL,
			provider varchar(50) NOT NULL,
			identifier varchar(255) NOT NULL,
			full_name varchar(150) DEFAULT '',
			email varchar(255) DEFAULT '',
			profile_url varchar(255) DEFAULT '',
			photo_url varchar(255) DEFAULT '',
			UNIQUE KEY id (id),
			KEY user_id (user_id)
		) $charset_collate;";
	dbDelta( $sql );
}

function pgssl_database_uninstall() {
	global $wpdb, $pgssl_tbl_usersprofiles, $pgssl_tbl_userscontacts, $pgssl_tbl_watchdog;
	$providers_config = pgssl_get_providers();

	// 1. Delete pgssl_usersprofiles, pgssl_userscontacts and pgssl_watchdog

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}{$pgssl_tbl_usersprofiles}" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}{$pgssl_tbl_userscontacts}" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}{$pgssl_tbl_watchdog}" );

	// 2. Delete user metadata from usermeta

	$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'pgssl_current_provider'"   );
	$wpdb->query( "DELETE FROM $wpdb->usermeta WHERE meta_key = 'pgssl_current_user_image'" );

	// 3. Delete registered options

	delete_option('pgssl_database_migration_version' );

	delete_option('pgssl_settings_development_mode_enabled' );
	delete_option('pgssl_settings_debug_mode_enabled' );

	delete_option('pgssl_components_core_enabled' );
	delete_option('pgssl_components_networks_enabled' );
	delete_option('pgssl_components_config_enabled' );
	delete_option('pgssl_components_diagnostics_enabled' );
	delete_option('pgssl_components_users_enabled' );
	delete_option('pgssl_components_contacts_enabled' );
	delete_option('pgssl_components_buddypress_enabled' );

	delete_option('pgssl_settings_social_icon_set' );

	delete_option('pgssl_settings_contacts_import_facebook' );
	delete_option('pgssl_settings_contacts_import_google' );
	delete_option('pgssl_settings_contacts_import_twitter' );
	delete_option('pgssl_settings_contacts_import_linkedin' );
	delete_option('pgssl_settings_contacts_import_live' );
	delete_option('pgssl_settings_contacts_import_vkontakte' );

	foreach( $providers_config as $provider ) {
		delete_option( 'pgssl_settings_' . $provider['provider_id'] . '_enabled' );
		delete_option( 'pgssl_settings_' . $provider['provider_id'] . '_app_id' );
		delete_option( 'pgssl_settings_' . $provider['provider_id'] . '_app_key' );
		delete_option( 'pgssl_settings_' . $provider['provider_id'] . '_app_secret' );
		delete_option( 'pgssl_settings_' . $provider['provider_id'] . '_app_scope' );
	}

	delete_option('pgssl_settings_buddypress_xprofile_map' );

	// bye.
}
