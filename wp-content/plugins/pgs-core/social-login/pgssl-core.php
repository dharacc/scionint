<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

global $pgssl_version, $pgssl_components, $pgssl_admin_tabs, $pgssl_tbl_usersprofiles, $pgssl_tbl_userscontacts, $pgssl_tbl_watchdog;

$pgssl_tbl_usersprofiles = 'pgssl_usersprofiles';
$pgssl_tbl_userscontacts = 'pgssl_userscontacts';
$pgssl_tbl_watchdog      = 'pgssl_watchdog';

$pgssl_version = "1.0.0";

/**
 * Initialize PHP sessions
 * see implementation in includes/services/wsl.session.php
 */
add_action( 'init', 'pgssl_init_php_session' );

/* Constants */
if ( file_exists( WP_PLUGIN_DIR . '/wp-social-login-custom.php' ) ) {
	include_once( WP_PLUGIN_DIR . '/wp-social-login-custom.php' );
}

/* Constants */
if ( ! defined( 'PGS_SOCIAL_LOGIN_ABS_PATH' ) ) {
	define( 'PGS_SOCIAL_LOGIN_ABS_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'PGS_SOCIAL_LOGIN_PLUGIN_URL' ) ) {
	define( 'PGS_SOCIAL_LOGIN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PGS_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL' ) ) {
	define( 'PGS_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL', PGS_SOCIAL_LOGIN_PLUGIN_URL . 'hybridauth/' );
}

/**
* _e() wrapper
*/
function _pgssl_e( $text, $domain ) {
	echo __( $text, $domain );
}

/**
* __() wrapper
*/
function _pgssl__( $text, $domain ) {
	return __( $text, $domain );
}

/* includes */
# Setup & Settings
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/settings/providers.php'         ); // List of supported providers (mostly provided by hybridauth library)
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/settings/database.php'          ); // Install/Uninstall database tables
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/settings/initialization.php'    ); // Check requirements and register settings
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/settings/compatibilities.php'   ); // Check and upgrade database/settings (for older versions)

/**
* Attempt to install/migrate/repair upon activation
*
* Create tables
* Migrate old versions
* Register components
*/
function pgssl_install() {

	global $wpdb, $pgssl_tbl_usersprofiles, $pgssl_tbl_userscontacts;

	$db_check_profiles = $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}pgssl_usersprofiles'" ) === $wpdb->prefix . $pgssl_tbl_usersprofiles ? 1 : 0;
	$db_check_contacts = $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}pgssl_userscontacts'" ) === $wpdb->prefix . $pgssl_tbl_userscontacts ? 1 : 0;

	if( ! ( $db_check_profiles && $db_check_contacts ) ) {
		pgssl_database_install();
	}
	pgssl_update_compatibilities();
	pgssl_register_components();
}
pgssl_install();

/* includes */
# Services & Utilities
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/authentication.php'    ); // Authenticate users via social networks. <- that's the most important script.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/mail.notification.php' ); // Emails and notifications.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/user.avatar.php'       ); // Display users avatar.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/user.data.php'         ); // User data functions (database related).
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/session.php'           ); // Manage PHP session.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/utilities.php'         ); // Unclassified functions & utilities.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/utilities-new.php'     );
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/services/watchdog.php'          ); // logging agent.

# Widgets & Front-end interfaces
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/auth.widgets.php'       ); // Authentication widget generators (where widget/icons are displayed).
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/auth.shortcodes.php'    ); // Authentication shortcodes.
// require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/auth-gutenblock.php'    ); // Authentication Gutenberg Block.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/users.gateway.php'      ); // Accounts linking + Profile Completion.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/error.pages.php'        ); // Generate notices end errors pages.
require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/widgets/loading.screens.php'    ); // Generate loading screens.

# Admin interfaces
if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
	require_once( PGS_SOCIAL_LOGIN_ABS_PATH . 'includes/admin/admin.ui.php'         ); // The entry point to Admin interfaces.
}
