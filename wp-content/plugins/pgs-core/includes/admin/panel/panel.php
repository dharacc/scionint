<?php
add_filter( 'ciyashop-panel-sections', 'ciyashop_panel_custom_sections' );

function ciyashop_panel_custom_sections( $sections ) {

	if ( ! function_exists( 'ciyashop_is_activated' ) || ! ciyashop_is_activated() ) {
		return;
	}

	$sections['support'] = array(
		'slug'  => 'support',
		'title' => esc_html__( 'Support', 'pgs-core' ),
	);

	$sections['plugins'] = array(
		'slug'      => 'plugins',
		'title'     => esc_html__( 'Plugins', 'pgs-core' ),
		'link_type' => 'custom',
		'link'      => admin_url( 'themes.php?page=theme-plugins' ),
	);

	$install_demo_tab_count    = class_exists( 'WooCommerce' ) ? 44 : 33;
	$sections['install-demos'] = array(
		'slug'      => 'install-demos',
		'title'     => esc_html__( 'Install Demos', 'pgs-core' ),
		'link_type' => 'custom',
		'link'      => admin_url( 'themes.php?page=ciyashop-options&tab=' . $install_demo_tab_count ),
	);

	$sections['theme-options'] = array(
		'slug'      => 'theme-options',
		'title'     => esc_html__( 'Theme Options', 'pgs-core' ),
		'link_type' => 'custom',
		'link'      => admin_url( 'themes.php?page=ciyashop-options&tab=0' ),
	);

	$sections['header-builder'] = array(
		'slug'      => 'header-builder',
		'title'     => esc_html__( 'Header Builder', 'pgs-core' ),
		'link_type' => 'custom',
		'link'      => admin_url( 'admin.php?page=header-builder' ),
	);

	$sections['system-status'] = array(
		'slug'     => 'system-status',
		'title'    => esc_html__( 'System Status', 'pgs-core' ),
		'template' => trailingslashit( PGSCORE_PATH ) . 'includes/admin/panel/templates/system-status.php',
	);

	$sections['ratings'] = array(
		'slug'     => 'ratings',
		'title'    => esc_html__( 'Ratings', 'pgs-core' ),
		'template' => trailingslashit( PGSCORE_PATH ) . 'includes/admin/panel/templates/ratings.php',
	);

	$sections['mobile-app'] = array(
		'slug'     => 'mobile-app',
		'title'    => esc_html__( 'Mobile Application', 'pgs-core' ),
		'template' => trailingslashit( PGSCORE_PATH ) . 'includes/admin/panel/templates/mobile-app.php',
	);

	return $sections;
}
