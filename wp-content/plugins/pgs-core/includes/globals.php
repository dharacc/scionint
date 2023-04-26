<?php
global $pgscore_globals, $pgscore_shortcodes, $PGSCore_ReduxFramework;

// Set blank array
$pgscore_globals = array(
	'current_theme'  => get_template(),
	'theme_data'     => wp_get_theme( get_template() ),
	'options_title'  => esc_html__( 'CiyaShop Theme Options', 'pgs-core' ),
	'options_slug'   => 'ciyashop-options',
	'options_name'   => 'ciyashop_options',
	'theme_slug'     => 'ciyashop',
	'active_plugins' => (array) get_option( 'active_plugins', array() ),
);
