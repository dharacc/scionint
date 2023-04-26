<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.welaunch.io
 * @since      1.0.0
 *
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WooCommerce_Catalog_Mode
 * @subpackage WooCommerce_Catalog_Mode/admin
 * @author     Daniel Barenkamp <support@db-dzine.com>
 */
class WooCommerce_Catalog_Mode_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    public function load_redux()
    {
        if(!is_admin() || !current_user_can('administrator') || (defined('DOING_AJAX') && DOING_AJAX && (isset($_POST['action']) && !$_POST['action'] == "woocommerce_catalog_mode_options_ajax_save") )) {
        	
            return false;
        }

        // Load the theme/plugin options
        if (file_exists(plugin_dir_path(dirname(__FILE__)).'admin/options-init.php')) {
            require_once plugin_dir_path(dirname(__FILE__)).'admin/options-init.php';
        }
        return true;
    }

    /**
     * Init
     * @author Daniel Barenkamp
     * @version 1.0.0
     * @since   1.0.0
     * @link    https://www.welaunch.io
     * @return  boolean
     */
    public function init()
    {
        global $woocommerce_catalog_mode_options;

        if(!is_admin() || !current_user_can('administrator') || (defined('DOING_AJAX') && DOING_AJAX)){
            $woocommerce_catalog_mode_options = get_option('woocommerce_catalog_mode_options');
        }

        $this->options = $woocommerce_catalog_mode_options;
    }
}
