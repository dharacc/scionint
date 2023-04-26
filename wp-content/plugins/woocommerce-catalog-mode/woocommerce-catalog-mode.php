<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              https://www.welaunch.io
 * @since             1.0.0
 * @package           WooCommerce_Catalog_Mode
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Catalog Mode
 * Plugin URI:        https://welaunch.io/plugins/woocommerce-catalog-mode/
 * Description:       Transform your WooCommerce Shop into a product catalog. Remove prices, hide the add to cart button and more!
 * Version:           1.7.4
 * Author:            weLaunch
 * Author URI:        https://welaunch.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-catalog-mode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-catalog-mode-activator.php
 */
function activate_woocommerce_catalog_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-catalog-mode-activator.php';
	WooCommerce_Catalog_Mode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-catalog-mode-deactivator.php
 */
function deactivate_woocommerce_catalog_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-catalog-mode-deactivator.php';
	WooCommerce_Catalog_Mode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_catalog_mode' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_catalog_mode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-catalog-mode.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_catalog_mode() {

	$plugin_data = get_plugin_data( __FILE__ );
	$version = $plugin_data['Version'];

	$plugin = new WooCommerce_Catalog_Mode($version);
	$plugin->run();

	return $plugin;

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php') && (is_plugin_active('redux-dev-master/redux-framework.php') || is_plugin_active('redux-framework/redux-framework.php') ||  is_plugin_active('welaunch-framework/welaunch-framework.php') ) ){
	$WooCommerce_Catalog_Mode = run_woocommerce_catalog_mode();
} else {
	add_action( 'admin_notices', 'woocommerce_catalog_mode_installed_notice' );
}

function woocommerce_catalog_mode_installed_notice()
{
	?>
    <div class="error">
      <p><?php _e( 'WooCommerce Catalog Mode requires the WooCommerce & weLaunch Framework plugin. Please install or activate them before: https://www.welaunch.io/updates/welaunch-framework.zip', 'woocommerce-catalog-mode'); ?></p>
    </div>
    <?php
}