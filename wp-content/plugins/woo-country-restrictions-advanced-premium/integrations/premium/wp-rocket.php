<?php

if (!class_exists('WCACR_WP_Rocket')) {

	class WCACR_WP_Rocket {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {

			add_action('admin_init', array($this, 'wprocket_compat_init'));
		}

		function wprocket_compat_init() {
			if (!function_exists('flush_rocket_htaccess') || !function_exists('rocket_generate_config_file')) {
				return;
			}
			add_filter('rocket_htaccess_mod_rewrite', '__return_false');
			add_filter('rocket_cache_dynamic_cookies', array($this, 'wprocket_compat_cookies'));


			$flag_key = 'wcacr_rocket_compat_set';
			if (!empty(get_option($flag_key))) {
				return;
			}

			update_option($flag_key, 1);
			// Update the WP Rocket rules on the .htaccess file.
			flush_rocket_htaccess();
			// Regenerate the config file.
			rocket_generate_config_file();
		}

		function wprocket_compat_cookies($cookies) {
			$cookies[] = WCACR_USER_COUNTRY_COOKIE;
			return $cookies;
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_WP_Rocket::$instance) {
				WCACR_WP_Rocket::$instance = new WCACR_WP_Rocket();
				WCACR_WP_Rocket::$instance->init();
			}
			return WCACR_WP_Rocket::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_WP_Rocket_Obj')) {

	function WCACR_WP_Rocket_Obj() {
		return WCACR_WP_Rocket::get_instance();
	}

}
WCACR_WP_Rocket_Obj();
