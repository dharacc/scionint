<?php
/**
 * Ciyashop Widget init
 *
 * @package pgs-core
 */

/**
 * Include widget files.
 *
 * @return void
 */
function pgscore_widgets_classes() {

	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_contactus_widgets.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_instagram_widgets.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_instagram_widgets_2.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_newsletter_widgets.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_opening_hours.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_social_widgets.php';
	require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_testimonials_widgets.php';
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/widgets/categories.php';
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/widgets/recent-posts.php';
	
	if ( function_exists( 'WC' ) ) {
		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_bestseller_product.php';
		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_featured_product.php';
		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_related_product.php';
		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_shop_flters.php';
		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_wc-widget-layered-nav.php';

		if ( pgscore_check_plugin_active( 'yith-woocommerce-brands-add-on/init.php' ) ) {
			require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_brand_flters.php';
		}
	}
}
add_action( 'plugins_loaded', 'pgscore_widgets_classes', 20 );

/**
 * Register Widgets
 */
function pgscore_register_widgets() {

	register_widget( 'PGSCore_Widget_Recent_Posts' );
	register_widget( 'pgs_contact_widget' );
	register_widget( 'pgs_instagram_widget' );
	register_widget( 'PGS_Instagram_Widget_2' );
	register_widget( 'pgs_newsletter_widget' );
	register_widget( 'pgs_opening_widget' );
	register_widget( 'pgs_social_widget' );
	register_widget( 'pgs_testimonials_widget' );
	
	if ( function_exists( 'WC' ) ) {

		register_widget( 'pgs_bestseller_widget' );
		register_widget( 'pgs_featured_products_widget' );
		register_widget( 'pgs_related_widget' );
		register_widget( 'PGS_Shop_Filters_Widget' );
		register_widget( 'Pgs_WC_Widget_Layered_Nav' );

		if ( pgscore_check_plugin_active( 'yith-woocommerce-brands-add-on/init.php' ) ) {
			register_widget( 'pgs_brand_filters_widget' );
		}
	}
}
add_action( 'widgets_init', 'pgscore_register_widgets' );

/**
 * WooCommerce widgets
 *
 * @return void
 */
function ciyashop_override_woocommerce_widgets() {
	if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
		unregister_widget( 'WC_Widget_Layered_Nav_Filters' );

		require_once trailingslashit( PGSCORE_PATH ) . '/includes/widgets/pgs_layered_nav_filters.php';

		register_widget( 'PGS_Widget_Layered_Nav_Filters' );
	}
}
add_action( 'widgets_init', 'ciyashop_override_woocommerce_widgets', 15 );