<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $header_elements, $header_configure_opt, $header_layouts, $yith_woocompare, $WOOCS;

require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-layouts.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-configure.php';

// Header Elements
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/account.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/button.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/cart.php';
}

if ( $yith_woocompare ) {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/compare.php';
}

if ( $WOOCS ) {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/currency.php';
}

require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/divider.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/email.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/html_block.php';

if ( function_exists( 'ciyashop_check_plugin_active' ) && ciyashop_check_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && function_exists( 'icl_get_languages' ) ) {
	require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/language.php';
}

require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/logo.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/menu.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/mobile_menu.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/phone_number.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/primary_menu.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/search.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/social_profiles.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/space.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/text_block.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header_shortcode/wishlist.php';

$header_elements      = apply_filters( 'header_builder_elements_list', $header_elements, $header_elements );
$header_configure_opt = apply_filters( 'header_configure_options', $header_configure_opt, $header_configure_opt );
$header_layouts       = apply_filters( 'header_layouts', $header_layouts, $header_layouts );
