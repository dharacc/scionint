<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.welaunch.io
 * @since      1.0.0
 *
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/includes
 * @author     Daniel Barenkamp <support@db-dzine.com>
 */
class WooCommerce_Catalog_Mode_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$loaded = load_plugin_textdomain(
			'woocommerce-catalog-mode',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
