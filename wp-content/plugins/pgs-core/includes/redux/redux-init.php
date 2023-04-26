<?php
global $pgscore_globals, $PGSCore_ReduxFramework;

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( ! current_theme_supports( 'pgs-core' ) ) {
	// return;
}

require_once trailingslashit( PGSCORE_PATH ) . 'includes/redux/redux-helpers.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/redux/base-config.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/redux/extensions.php';

/*****************************************************************************
 *
 * Add Theme Options Menu in WordPress Admin Bar
 *
 *****************************************************************************/
function pgscore_toolbar_theme_options_link( $wp_admin_bar ) {

	if ( ! function_exists( 'ciyashop_is_activated' ) || ! ciyashop_is_activated() ) {
		return;
	}

	global $pgscore_globals, $PGSCore_ReduxFramework;
	$args = array(
		'id'    => $pgscore_globals['options_slug'],
		'title' => $pgscore_globals['options_title'],
		'meta'  => array(
			'class' => 'wp-admin-bar-pgscore-options-link',
		),
		'href'  => admin_url( 'themes.php?page=' . $pgscore_globals['options_slug'] ),
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'pgscore_toolbar_theme_options_link', 999 );

/*****************************************************************************
 *
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 *
 *****************************************************************************/
if ( ! function_exists( 'pgscore_helper_remove_redux_demo' ) ) {
	function pgscore_helper_remove_redux_demo() {
		// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
		}
	}
}
add_action( 'redux/loaded', 'pgscore_helper_remove_redux_demo' );


/*****************************************************************************
 *
 * Remove Redux About menu under the tools
 *
 *****************************************************************************/
add_action( 'admin_menu', 'pgscore_remove_redux_menu', 12 );
function pgscore_remove_redux_menu() {
	remove_submenu_page( 'tools.php', 'redux-about' );
}
