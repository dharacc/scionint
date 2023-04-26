<?php
if (!class_exists('WCACR_Dokan')) {

	class WCACR_Dokan {

		static private $instance = false;

		private function __construct() {
			
		}

		function init() {
			if (!class_exists('WeDevs_Dokan')) {
				return;
			}

			add_filter('vcwccr_tab_settings_filter', array($this, 'add_settings'));
			add_action('dokan_new_product_added', array($this, 'product_created'), 10, 1);
			add_action('dokan_product_edit_after_main', array($this, 'display_country_restrictions_fields'));
			add_action('dokan_process_product_meta', array($this, 'save_restrictions_fields'));
		}

		function product_created($product_id) {
			$settings = get_option('wcacr_dokan_allow_country_restrictions');
			if (!$settings || $settings !== 'auto') {
				return;
			}
			update_post_meta($product_id, 'vcwccr_selected_countries', wcacr_get_user_country());
			update_post_meta($product_id, 'vcwccr_availability_operator', '1');
			wcacr_save_disallowed_countries($product_id, array(wcacr_get_user_country()), 1);
		}

		function add_settings($settings) {
			$settings['dokan'] = array(
				'title' => __('Dokan', VCWCCR_TEXT_DOMAIN),
				'wcacr_dokan_allow_country_restrictions' => array(
					'name' => __('Allow to select country restrictions in the vendor dashboard?', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('No, vendor products will not have custom restrictions', VCWCCR_TEXT_DOMAIN),
						'vendor_country' => __('Automatically restrict products to the country of the vendor', VCWCCR_TEXT_DOMAIN),
						'custom' => __('Allow the vendor to select custom country restrictions', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wcacr_dokan_allow_country_restrictions',
				),
			);
			return $settings;
		}

		public function save_restrictions_fields($post_id) {

			$settings = get_option('wcacr_dokan_allow_country_restrictions');
			if (!$settings || $settings !== 'custom') {
				return;
			}

			if (!function_exists('vcwccr_save_product_custom_fields')) {
				require_once VCWCCR_PATH . 'backend/product-custom-fields.php';
			}

			vcwccr_save_product_custom_fields($post_id);
		}

		public function display_country_restrictions_fields($post) {

			$settings = get_option('wcacr_dokan_allow_country_restrictions');
			if (!$settings || $settings !== 'custom') {
				return;
			}
			?>
			<div class="dokan-edit-row">
				<script>
					jQuery(function ($) {
						$('.vcwccr-select2').select2();
					});
				</script>
				<div class="dokan-section-heading">
					<h2>
						<i class="fa fa-globe"></i>
						<?php _e('Country restrictions', VCWCCR_TEXT_DOMAIN); ?>
					</h2>
					<p><?php _e('configure in which countries your product will be sold', VCWCCR_TEXT_DOMAIN); ?></p>
					<a href="#" class="dokan-section-toggle">
						<i class="fa fa-sort-desc fa-flip-horizointal" aria-hidden="true" style="margin-top: 0px;"></i>
					</a>
					<div class="dokan-clearfix"></div>
				</div>                        
				<div class="dokan-section-content" >
					<div class="content-half-part dokan-form-group">
						<label for="product_selected_countries[]" class="form-label"><?php _e('Selected countries', VCWCCR_TEXT_DOMAIN); ?></label>
						<?php
						$selected_countries_raw = get_post_meta($post->ID, 'vcwccr_selected_countries', true);
						$selected_countries_raw = empty($selected_countries_raw) ? '' : $selected_countries_raw;
						$selected_countries = explode(',', strval($selected_countries_raw));
						?>
						<select id="product_selected_countries[]" name="product_selected_countries[]" class="dokan-form-control vcwccr-select2" multiple>
							<?php
							$this->display_options(
									vcwccr_get_countries_with_continents(), $selected_countries
							);
							?>
						</select>
					</div>
					<div class="content-half-part dokan-form-group">
						<label for="product_country_availability_operator" class="form-label"><?php _e('Availability', VCWCCR_TEXT_DOMAIN); ?> <span>(<?php _e('If product is available in selected countries', VCWCCR_TEXT_DOMAIN); ?>)</span></label>
						<select id="product_country_availability_operator" name="product_country_availability_operator" class="dokan-form-control">
							<?php
							$this->display_options(
									vcwccr_get_country_availability_operators(), get_post_meta($post->ID, 'vcwccr_availability_operator', true)
							);
							?>
						</select>
					</div>
					<div class="dokan-clearfix"></div>
				</div>    
			</div>    
			<?php
		}

		public function display_options($options, $selected = array()) {

			$selected_values = is_scalar($selected) ? array($selected) : $selected;

			$selected_values = array_map('strval', $selected_values);

			foreach ($options as $option_key => $option_text) {
				?><option value="<?php esc_attr_e($option_key); ?>" <?php selected(true, in_array(strval($option_key), $selected_values)); ?>>
					<?php esc_html_e($option_text); ?>
				</option><?php
			}
		}

		/**
		 * Creates or returns an instance of this class.
		 */
		static function get_instance() {
			if (null == WCACR_Dokan::$instance) {
				WCACR_Dokan::$instance = new WCACR_Dokan();
				WCACR_Dokan::$instance->init();
			}
			return WCACR_Dokan::$instance;
		}

		function __set($name, $value) {
			$this->$name = $value;
		}

		function __get($name) {
			return $this->$name;
		}

	}

}

if (!function_exists('WCACR_Dokan_Obj')) {

	function WCACR_Dokan_Obj() {
		return WCACR_Dokan::get_instance();
	}

}
WCACR_Dokan_Obj();
