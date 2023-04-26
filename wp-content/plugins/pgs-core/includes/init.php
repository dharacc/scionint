<?php
require_once trailingslashit( PGSCORE_PATH ) . 'includes/globals.php';                 // Globals
require_once trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpt.php';                 // CPTs
require_once trailingslashit( PGSCORE_PATH ) . 'includes/widgets.php';                 // Widgets
require_once trailingslashit( PGSCORE_PATH ) . 'includes/icons/icons.php';             // Icons
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/admin-init.php';        // CiyaShop Panel
require_once trailingslashit( PGSCORE_PATH ) . 'includes/helper_functions.php';        // Helper Functions
require_once trailingslashit( PGSCORE_PATH ) . 'includes/meta-boxes/class-pgs-meataboxs.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/meta-boxes/metabox-fields.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/lib/pgs-instawp/init.php';

add_action( 'init', 'pgscore_file_inclusions', 7 );
function pgscore_file_inclusions() {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/redux/redux-init.php';        // Redux
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/sample_data/sample_data.php'; // Sample Data
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/sample_data/sample_data-ajax.php'; // Sample Data Ajax
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/scripts_and_styles.php';      // CSS & Javascript

	require_once trailingslashit( PGSCORE_PATH ) . 'includes/vc/vc.php';                   // Visual Composer
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/shortcode.php';               // Shortcodes
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/mailchimp.php';               // mailchimp
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin-notices.php';           // Admin Notices
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/healper_builder-functions.php';
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-builder-lib.php';
	if ( is_admin() ) {
		require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_bulder.php';
		require_once trailingslashit( PGSCORE_PATH ) . 'includes/healper_builder-functions.php';
		require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-builder-lib.php';
		if ( class_exists( 'WooCommerce' ) ) {
			require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/ciyashop_smart_product_postmeta.php';
		}
	}
}
