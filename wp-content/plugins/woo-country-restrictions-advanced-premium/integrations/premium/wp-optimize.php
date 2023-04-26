<?php

if (!class_exists('WCACR_WP_Optimize')) {

	class WCACR_WP_Optimize {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {

			add_action('wpo_cache_flush', array($this, 'regenerate_options'), 1);
			add_action('admin_init', array($this, 'compat_init'));
		}

		function regenerate_options() {
			add_filter('wpo_cache_cookies', array($this, 'compat_cookies'));
		}

		function compat_init() {
			if (!class_exists('WP_Optimize') || !function_exists('wpo_cache_flush')) {
				return;
			}

			$flag_key = 'wcacr_wpoptimize_compat_set';
			if (!empty(get_option($flag_key))) {
				return;
			}

			update_option($flag_key, 1);
			wpo_cache_flush();
		}

		function compat_cookies($cookies) {
			$cookies[] = WCACR_USER_COUNTRY_COOKIE;
			return $cookies;
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_WP_Optimize::$instance) {
				WCACR_WP_Optimize::$instance = new WCACR_WP_Optimize();
				WCACR_WP_Optimize::$instance->init();
			}
			return WCACR_WP_Optimize::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_WP_Optimize_Obj')) {

	function WCACR_WP_Optimize_Obj() {
		return WCACR_WP_Optimize::get_instance();
	}

}
WCACR_WP_Optimize_Obj();
