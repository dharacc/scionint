<?php

if (!class_exists('WCACR_Coupons')) {

	class WCACR_Coupons {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {
			add_filter('woocommerce_coupon_is_valid', array($this, 'is_coupon_valid'), 10, 2);
		}

		function is_coupon_valid($is_valid, $coupon) {
			return !vcwccr_is_restricted($coupon->get_id());
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_Coupons::$instance) {
				WCACR_Coupons::$instance = new WCACR_Coupons();
				WCACR_Coupons::$instance->init();
			}
			return WCACR_Coupons::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_Coupons_Obj')) {

	function WCACR_Coupons_Obj() {
		return WCACR_Coupons::get_instance();
	}

}
WCACR_Coupons_Obj();
