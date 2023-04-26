<?php
if (!class_exists('WCACR_State_Restrictions')) {

	class WCACR_State_Restrictions {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {
			add_filter('vcwccr_tab_settings_filter', array($this, 'add_option_to_settings_page'));
			add_action("admin_footer", array($this, 'enqueue_script'), 99);


			$restrict_by = get_option('wccr_restriction_by');
			if ($restrict_by !== 'state') {
				return;
			}
			add_filter('pre_option_wccr_country_selector_full_name', array($this, 'filter_option_country_selector_full_name'));
			add_filter('vcwccr_get_countries', array($this, 'get_states'));
			add_filter('vcwccr_get_countries_continents', array($this, 'get_states'));
			add_filter('vcwccr_allow_to_replace_continent', '__return_false');
			add_filter('vcwccr_country_selector/show_icon', '__return_false');
			add_filter('vcwccr_billing_country_key_from_cart', array($this, 'get_state_key'));
			add_filter('vcwccr_shipping_country_key_from_cart', array($this, 'get_state_key'));
			add_filter('vcwccr_get_customer_billing_country', array($this, 'get_billing_state'));
			add_filter('vcwccr_get_customer_shipping_country', array($this, 'get_shipping_state'));
		}

		function enqueue_script() {
			if (empty($_GET['tab']) || $_GET["tab"] !== "variations_per_country_tab") {
				return;
			}
			?>

			<script>

			<?php if (!empty($_POST)) { ?>
					// If this is a POST request (settings saved), reload again
					// because the options are saved close to where they are rendered
					// so if we change from restriction by country to state, the dropdowns will 
					// show the options from the previous value
					window.location.href = window.location.href;
			<?php } ?>

				jQuery(window).load(function () {
					jQuery('.state-disclaimer').hide();
					var initialValue = jQuery('#wccr_restriction_by').val();
					jQuery('#wccr_restriction_by').change(function (e) {
						if (initialValue !== jQuery(this).val()) {
							if (confirm(<?php echo json_encode(__('You need to save your changes to continue. Do you want to save now?', VCWCCR_TEXT_DOMAIN)); ?>)) {
								jQuery('.woocommerce-save-button').click();
							}
						}

						if (jQuery(this).val() === 'state') {
							jQuery('.state-disclaimer').css({
								display: 'block'
							});
							jQuery('#wccr_geolocation_method option[value="ip"], #wccr_secondary_geolocation_method option[value="ip"]').hide();
						} else {
							jQuery('#wccr_geolocation_method option[value="ip"], #wccr_secondary_geolocation_method option[value="ip"]').show();
						}
					});
					jQuery('#wccr_restriction_by').trigger('change');
				});
			</script>
			<?php
		}

		function get_shipping_state($value) {
			return WC()->cart->get_customer()->get_shipping_state();
		}

		function get_billing_state($value) {
			return WC()->cart->get_customer()->get_billing_state();
		}

		function get_state_key($key) {
			return str_replace('country', 'state', $key);
		}

		function get_states($countries) {
			$countries_obj = new WC_Countries();
			$default_country = $countries_obj->get_base_country();
			$out = $countries_obj->get_states($default_country);
			return $out;
		}

		function add_option_to_settings_page($options) {

			$countries_obj = new WC_Countries();
			$default_country = $countries_obj->get_base_country();
			$states = $countries_obj->get_states();
			$countries = $countries_obj->get_countries();
			$supported_countries = array();
			foreach ($states as $country => $country_states) {
				if (empty($country_states)) {
					continue;
				}
				$supported_countries[] = $countries[$country];
			}

			$options['general']['wccr_restriction_by'] = array(
				'name' => __('Restrict by', VCWCCR_TEXT_DOMAIN),
				'desc' => sprintf(__('<span class="state-disclaimer">Notes, the restriction by country works perfectly with all countries with all geolocation methods.<br><br>The restriction by state works with these countries only: %s.<br><br>The restriction by state does not work with IP geolocation (automatic detection) because the automatic detection is unreliable for small states, it only works with the dropdown selector (the user selects the state in the dropdown on the header), billing state, and shipping state.<br><br>The list of states will be from the "base country" defined in the WooCommerce settings (Your base country is %s, you can <a href="%s">change it here</a> in the option named "%s".)</span>', VCWCCR_TEXT_DOMAIN), implode(', ', $supported_countries), $countries[$default_country], 'admin.php?page=wc-settings&tab=general', __('Country / State', 'woocommerce')),
				'type' => 'select',
				'id' => 'wccr_restriction_by',
				"options" => array(
					'' => __('Country and continents', VCWCCR_TEXT_DOMAIN),
					'state' => __('State or provinces of one country', VCWCCR_TEXT_DOMAIN),
				)
			);
			return $options;
		}

		function filter_option_country_selector_full_name($value) {
			return 'yes';
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_State_Restrictions::$instance) {
				WCACR_State_Restrictions::$instance = new WCACR_State_Restrictions();
				WCACR_State_Restrictions::$instance->init();
			}
			return WCACR_State_Restrictions::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_State_Restrictions_Obj')) {

	function WCACR_State_Restrictions_Obj() {
		return WCACR_State_Restrictions::get_instance();
	}

}
WCACR_State_Restrictions_Obj();
