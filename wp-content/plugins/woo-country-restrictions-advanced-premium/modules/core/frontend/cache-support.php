<?php

if (!class_exists('WCACR_Cache_Support')) {

	class WCACR_Cache_Support {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {
			if (empty(get_option('wccr_enable_cache_support'))) {
				return;
			}

			// Don't apply restrictions on the catalog and product pages for GET requests,
			// we'll do it via ajax
			if ($_SERVER['REQUEST_METHOD'] === 'GET') {
				add_filter('wcacr_can_load_frontend_checks', '__return_false');
			}
			add_action('template_redirect', array($this, 'get_product_restrictions'));
			add_filter('woocommerce_ajax_variation_threshold', array($this, 'load_variations_via_ajax'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
			add_action('woocommerce_after_add_to_cart_button', array($this, 'render_add_to_cart_form_marker'));
			add_action('woocommerce_before_single_product', array($this, 'render_notices_marker'));
			add_action('woocommerce_product_price_class', array($this, 'render_price_marker'));
			add_action('wp_head', array($this, 'hide_elements_by_default'));
		}

		function hide_elements_by_default() {
			?>
			<style id="wcacr-cache-support-css">
				body:not(.single-product) .product .price,
				.single-product .wcacr-price,
				.single-product form.cart {
					display: none;
				}
			</style>
			<?php

		}

		function render_notices_marker() {
			echo '<span style="display:none;" class="wcacr-notices-marker"></span>';
		}

		function render_price_marker($class) {
			$class .= ' wcacr-price ';
			return $class;
		}

		function render_add_to_cart_form_marker() {
			echo '<span style="display:none;" class="wcacr-add-to-cart-marker"></span>';
		}

		function enqueue_assets() {
			wp_enqueue_script('wcacr-cache-support', VCWCCR_URL . '/assets/js/cache-support.js', array('jquery'), filemtime(VCWCCR_PATH . '/assets/js/cache-support.js'));
			wp_localize_script('wcacr-cache-support', 'wcacr_cache_support_data', array(
				'wccr_allow_variations_redirection' => get_option('wccr_allow_variations_redirection')
			));
		}

		function load_variations_via_ajax($count) {
			return 0;
		}

		function get_product_restrictions() {
			global $product, $vcwccr_plugin;
			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				return;
			}
			if (!isset($_REQUEST['wcacr_cache_buster_product_id'])) {
				return;
			}
			if (is_product() && empty($_REQUEST['wcacr_cache_buster_product_id'])) {
				return;
			}
			$message = get_option('wccr_restricted_product_page_message');
			if (empty($message)) {
				$message = __('This product is not available for your country', VCWCCR_TEXT_DOMAIN);
			}
			wc_add_notice($message, 'error');

			$classes = apply_filters('body_class', array());
			$classes[] = 'restriction-method-' . get_option('wccr_restriction_method');

			$extra_data = array();

			if (is_product()) {
				$product_id = (int) $_REQUEST['wcacr_cache_buster_product_id'];
				// Necessary for using the wc templates, they depend on the $product global
				$product = wc_get_product($product_id);
				$extra_data = array(
					'new_price' => '',
					'visible_variations_count' => 0,
					'is_product_restricted' => vcwccr_is_restricted($product_id) || !vcwccr_shop_is_available(),
					'product_type' => $product->get_type(),
				);
				if (strpos($product->get_type(), 'variable') !== false) {
					ob_start();
					woocommerce_template_single_price();
					$extra_data['new_price'] = ob_get_clean();
					$extra_data['visible_variations_count'] = count($product->get_visible_children());
				}
			}

			$out = array_merge(array(
				'is_shop_available' => vcwccr_shop_is_available(),
				'country' => wcacr_get_user_country(),
				'body_classes' => implode(' ', $classes),
				'notices' => wc_print_notices(true),
				'notice_plain_message' => $message,
					), $extra_data);
			wp_send_json_success(apply_filters('wcacr_cache_check_output', $out));
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_Cache_Support::$instance) {
				WCACR_Cache_Support::$instance = new WCACR_Cache_Support();
				WCACR_Cache_Support::$instance->init();
			}
			return WCACR_Cache_Support::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_Cache_Support_Obj')) {

	function WCACR_Cache_Support_Obj() {
		return WCACR_Cache_Support::get_instance();
	}

}
WCACR_Cache_Support_Obj();
