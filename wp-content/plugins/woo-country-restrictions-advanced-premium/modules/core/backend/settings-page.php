<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists("vcwccr_tab")) {

	add_filter('woocommerce_settings_tabs_array', "vcwccr_tab", 50);

	function vcwccr_tab($settings_tabs) {
		//adding variations per country settings tab		
		$settings_tabs['variations_per_country_tab'] = __('Country Restrictions', VCWCCR_TEXT_DOMAIN);
		return $settings_tabs;
	}

}

if (!function_exists("vcwccr_tab_get_settings")) {

	function vcwccr_tab_get_settings() {
		global $wpdb;

		// Clear the country cookie when we change global settings, 
		// so the country is detected again using the new settings
		if (!empty($_POST)) {
			setcookie(WCACR_USER_COUNTRY_COOKIE, '', time() - YEAR_IN_SECONDS, "/");
			$_COOKIE[WCACR_USER_COUNTRY_COOKIE] = NULL;
		}

		$menu_options = get_terms(array(
			'taxonomy' => 'nav_menu',
			'fields' => 'id=>name',
			'hide_empty' => false,
		));
		$menu_options[''] = __('Display automatically on the first visible menu', VCWCCR_TEXT_DOMAIN);
		$menu_options['none'] = __('None. I will display manually with the shortcode', VCWCCR_TEXT_DOMAIN);

		if (!function_exists('get_editable_roles')) {
			require_once ABSPATH . 'wp-admin/includes/user.php';
		}

		$countries_with_continents = vcwccr_get_countries_with_continents();

		$raw_attributes = $wpdb->get_results("SELECT attribute_name, attribute_label FROM {$wpdb->prefix}woocommerce_attribute_taxonomies", ARRAY_A);
		$attributes = array();
		foreach ($raw_attributes as $raw_attribute) {
			$attributes['pa_' . $raw_attribute['attribute_name']] = $raw_attribute['attribute_label'];
		}

		//adding settings
		$settings = array(
			'general' => array(
				'title' => __('General', VCWCCR_TEXT_DOMAIN),
				'wccr_geolocation_method' => array(
					'name' => __('Geolocation method', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_geolocation_method',
					"options" => array(
						'ip' => __('IP (Automatic)', VCWCCR_TEXT_DOMAIN),
						'country_selector' => __('Show country/state selector in the header', VCWCCR_TEXT_DOMAIN),
						'shipping_country' => __('Shipping country/state on checkout', VCWCCR_TEXT_DOMAIN),
						'billing_country' => __('Billing country/state on checkout', VCWCCR_TEXT_DOMAIN),
					)
				),
				'wccr_secondary_geolocation_method' => array(
					'name' => __('Fallback geolocation method', VCWCCR_TEXT_DOMAIN),
					'desc' => __('We use the fallback when the system does not find the user country using the primary method.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_secondary_geolocation_method',
					"options" => array(
						'none' => '--',
						'ip' => __('IP (Automatic)', VCWCCR_TEXT_DOMAIN),
						'shipping_country' => __('Shipping country/state on checkout', VCWCCR_TEXT_DOMAIN),
						'billing_country' => __('Billing country/state on checkout', VCWCCR_TEXT_DOMAIN),
					)
				),
				'wccr_geolocation_failed_action' => array(
					'name' => __('What happens when the user location is unknown?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('What do we do if the primary and secondary geolocation methods failed?', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_geolocation_failed_action',
					"options" => array(
						'' => __('Show all products', VCWCCR_TEXT_DOMAIN),
						'hide' => __('Hide all products', VCWCCR_TEXT_DOMAIN),
					)
				),
				'wccr_restriction_method' => array(
					'name' => __('Restriction method', VCWCCR_TEXT_DOMAIN),
					'desc' => __('What happens when the visitor country is not allowed?', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_restriction_method',
					"options" => array(
						'hide' => __('Hide product from the catalog', VCWCCR_TEXT_DOMAIN),
						'disable_add_to_cart' => __('Show product in catalog, disable add to cart, show prices', VCWCCR_TEXT_DOMAIN),
						'disable_add_to_cart_prices' => __('Show product in catalog, disable add to cart, hide prices', VCWCCR_TEXT_DOMAIN),
					)
				),
			),
			'header_selector' => array(
				'title' => __('Header selector', VCWCCR_TEXT_DOMAIN),
				'wccr_country_selector_options' => array(
					'name' => __('Dropdown selector options', VCWCCR_TEXT_DOMAIN),
					'desc' => __('What countries do you want to display in the list? Leave it empty to display the shipping countries from the WooCommerce settings.', VCWCCR_TEXT_DOMAIN),
					'type' => 'multiselect',
					'options' => $countries_with_continents,
					'id' => 'wccr_country_selector_options',
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled wcacr-show-select-all',
				),
				'wccr_default_country' => array(
					'name' => __('Dropdown selector: Default country/state', VCWCCR_TEXT_DOMAIN),
					'desc' => __('When the dropdown selector is enabled, what option is selected by default? Leave empty to use the country based on the IP of the user. Note. If the restriction is by state (not country), sometimes the state found through the IP geolocation is not reliable so you should define a default state here.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'options' => array_merge(array('' => '--'), vcwccr_get_countries()),
					'id' => 'wccr_default_country',
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled',
				),
				'wccr_country_selector_full_name' => array(
					'name' => __('Dropdown selector: How to display the selected country', VCWCCR_TEXT_DOMAIN),
					'desc' => __('The current country appears as a flag to use less space in the menu and the other items as a dropdown. If the restriction is by state, we always show the state name and this setting is ignored because states dont have flags', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('Show the current flag only', VCWCCR_TEXT_DOMAIN),
						'full_country_name' => __('Show the current flag and country name', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wccr_country_selector_full_name',
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled',
				),
				'wccr_country_selector_menu_targets' => array(
					'name' => __('Dropdown selector location', VCWCCR_TEXT_DOMAIN),
					'desc' => __('You can use the shortcode: [vcwccr_country_selector] to display it anywhere', VCWCCR_TEXT_DOMAIN),
					'type' => 'multiselect',
					'id' => 'wccr_country_selector_menu_targets',
					'options' => $menu_options,
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled',
				),
				'wccr_country_selector_show_popup' => array(
					'name' => __('Dropdown selector: Display a popup asking the user to select a country?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('By default, the user selects the country in the header dropdown. Enable this option to display a popup once when they visit the website so they select the country before viewing the website', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_country_selector_show_popup',
					'options' => array('' => 'No', 'yes' => 'Yes'),
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled',
				),
				'wccr_country_selector_popup_intro' => array(
					'name' => __('Display a message in the header of the popup', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Leave empty to not display any intro message and only display a title and the list of countries/states', VCWCCR_TEXT_DOMAIN),
					'type' => 'callable',
					'callback' => function() {
						if (isset($_POST['wccr_country_selector_popup_intro'])) {
							update_option('wccr_country_selector_popup_intro', wp_kses_post($_POST['wccr_country_selector_popup_intro']));
						}
						$content = get_option('wccr_country_selector_popup_intro');
						?>
						<table class="form-table">
							<tbody>						
								<tr valign="top" style="display: table-row;">
									<th scope="row" class="titledesc">
										<label for="wccr_country_selector_show_popup"><?php echo esc_html(__('Popup selector: Display a message in the header of the popup', VCWCCR_TEXT_DOMAIN)); ?></label>
									</th>
									<td class="forminp forminp-select wcaccr-country-selector-enabled">
										<?php wp_editor($content, 'wccr_country_selector_popup_intro', array('textarea_rows' => '8')); ?>
										<p class="description"><?php echo esc_html(__('Leave empty to not display any intro message and only display a title and the list of countries/states', VCWCCR_TEXT_DOMAIN)); ?></p>							</td>
								</tr>
							</tbody>
						</table>
						<?php
					},
					'id' => 'wccr_country_selector_popup_intro',
					'class' => 'wcaccr-country-selector-enabled',
				),
				'wccr_country_selector_linked_shipping_country' => array(
					'name' => __('Sync the dropdown selector with the shipping information?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('When we select a country/state in the selector, automatically set it as shipping country/state. When we change shipping country/state, automatically select it on the dropdown selector', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_country_selector_linked_shipping_country',
					'options' => array('' => 'No', 'yes' => 'Yes'),
					'class' => 'wc-enhanced-select wcaccr-country-selector-enabled',
				),
			),
			'restriction_enforcement' => array(
				'title' => __('Restriction enforcement', VCWCCR_TEXT_DOMAIN),
				'wccr_restricted_product_page_message' => array(
					'name' => __('Message shown in the product page when the product is restricted', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: This product is not available for your country.', VCWCCR_TEXT_DOMAIN),
					'id' => 'wccr_restricted_product_page_message',
					'type' => 'text',
				),
				'wccr_restricted_product_checkout_message' => array(
					'name' => __('Message shown in the checkout and cart pages when buying a restricted product', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: The product: {title} is not available for your country.', VCWCCR_TEXT_DOMAIN),
					'id' => 'wccr_restricted_product_checkout_message',
					'type' => 'text',
				),
				'wccr_archive_restriction_type' => array(
					'name' => __('What happens when there are zero allowed products for the catalog pages?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: Show error 404 (Category not found). Catalog pages means the shop, category, tag, attribute, search pages.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'wccr_archive_restriction_type',
					"options" => array(
						'not_found' => __('Display page with message "not found" (error 404)', VCWCCR_TEXT_DOMAIN),
						'' => __('Display the normal page with a custom message', VCWCCR_TEXT_DOMAIN),
					)
				),
				'wccr_archive_restriction_message' => array(
					'name' => __('Message shown when the products list is restricted', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: We don\'t have products allowed for your country.', VCWCCR_TEXT_DOMAIN),
					'id' => 'wccr_archive_restriction_message',
					'type' => 'text',
					'class' => 'wcacr-archive-custom-message',
				),
				'wccr_restricted_product_message_page_id' => array(
					'name' => __('Display Page when a restricted product is viewed', VCWCCR_TEXT_DOMAIN),
					'desc' => __('You can create a beautiful page with a page builder and show that page for restricted products. Leave it empty to display the message from the previous options', VCWCCR_TEXT_DOMAIN),
					'id' => 'wccr_restricted_product_message_page_id',
					'type' => 'single_select_page',
					'default' => '',
					'class' => 'wc-enhanced-select-nostd',
					'css' => 'min-width:300px;',
				),
				'wccr_whitelisted_roles' => array(
					'name' => __('Don\'t apply the location restrictions to these user roles', VCWCCR_TEXT_DOMAIN),
					'desc' => __('By default, the restrictions dont apply to "shop managers" and "administrator"', VCWCCR_TEXT_DOMAIN),
					'id' => 'wccr_whitelisted_roles',
					'type' => 'multiselect',
					"options" => wp_list_pluck(get_editable_roles(), 'name'),
					'default' => '',
					'class' => 'wc-enhanced-select-nostd',
					'css' => 'min-width:300px;',
				),
				'wccr_auto_remove_restricted_products_checkout' => array(
					'name' => __('Checkout: Auto remove restricted products from the cart?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: We remove the restricted products and show a message indicating that it is not allowed for the country. Enable this option to display the restriction message but keep the product in the cart.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('Yes', VCWCCR_TEXT_DOMAIN),
						'no' => __('No', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wccr_auto_remove_restricted_products_checkout',
				),
				'wccr_apply_restrictions_when_admin_creates_order' => array(
					'name' => __('Apply country restrictions when order is created manually in the backend?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: We dont apply restrictions when creating an order in wp-admin > woocommerce > orders', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('no', VCWCCR_TEXT_DOMAIN),
						'yes' => __('Yes', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wccr_apply_restrictions_when_admin_creates_order',
				),
			),
			'restrict_products' => array(
				'title' => __('Products per country', VCWCCR_TEXT_DOMAIN),
				'product_rules_section_title' => array(
					'type' => 'title',
					'desc' => __("In this section you can select the countries that can/can't see your products. This applies to all products in your store. If a user is not allowed to see a product, the product won't be displayed in the store, category pages, and search pages. For example: Display my products only to USA and Canada, and hide to the rest of the world; Or show my products to all the world except USA ", VCWCCR_TEXT_DOMAIN),
					'id' => 'vcwccr_settings_product_rules_section_title'
				),
				'product_select_country' => array(
					'name' => __("Select country", VCWCCR_TEXT_DOMAIN),
					'type' => 'multi_select_countries',
					'options' => $countries_with_continents,
					'id' => 'vcwccr_selected_countries',
				),
				'product_operator' => array(
					'name' => __('Sell in selected countries/states', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					'id' => 'vcwccr_availability_operator',
					"options" => vcwccr_get_country_availability_operators()
				),
			),
			'restrict_variations' => array(
				'title' => __('Variations per country', VCWCCR_TEXT_DOMAIN),
				'product_variations_rules' => array(
					'type' => 'callable',
					'callback' => 'wcacr_render_variations_settings'
				),
				'wccr_hide_country_attribute' => array(
					'name' => __('Variations: Select the attribute used for storing the country to hide it', VCWCCR_TEXT_DOMAIN),
					'desc' => __('For advanced users only, ignore this if you dont know what you are doing. When you create variations for specific countries, sometimes you use an attribute to assign a country to each variation and WooCommerce shows the country attribute dropdown in the product page. Use this option to select the attribute and we will hide it from the customers', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array_merge(array('' => __("I don't use attributes for countries", VCWCCR_TEXT_DOMAIN)), $attributes),
					'id' => 'wccr_hide_country_attribute',
				),
				'wccr_allow_variations_redirection' => array(
					'name' => __('For Advanced Users: Allow the variations redirection?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('When the cache support is enabled and the customer is allowed to buy one or more variations of the product, we reload the page to refresh the variations form and remove the disallowed variations. This is good because the customer will not see disallowed options. But you can use this option to disable the refresh and show all the variation options (if they select a disallowed variation we will notify that it is not allowed).', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array('' => __("Yes", VCWCCR_TEXT_DOMAIN), 'no' => __("No", VCWCCR_TEXT_DOMAIN)),
					'id' => 'wccr_allow_variations_redirection',
				),
			),
			'restrict_categories' => array(
				'title' => __('Category pages per country', VCWCCR_TEXT_DOMAIN),
				'category_rules_section_title' => array(
					'type' => 'title',
					'desc' => sprintf(__('You can hide category pages for specific countries/states, hide all the products inside the category and category links from the menus.<br><br>You need to the categories and select which countries can see them. You can edit categories in the normal editor: <a href="%s" target="_blank">Go to the list of categories</a>', VCWCCR_TEXT_DOMAIN), esc_url(admin_url('edit-tags.php?taxonomy=product_cat&post_type=product'))),
					'id' => 'category_rules_section_title'
				),
			),
			'restrict_coupons' => array(
				'title' => __('Coupons per country', VCWCCR_TEXT_DOMAIN),
				'coupon_rules_section_title' => array(
					'type' => 'title',
					'desc' => sprintf(__('You can restrict coupons by country, state, continents, or regions.<br><br>You can define the restrictions in the coupon editor. For that you can create or edit every coupon and select the country restrictions in the coupons editor > tab: "Usage restrictions". <a href="%s" target="_blank">Go to the coupons list</a>', VCWCCR_TEXT_DOMAIN), esc_url(admin_url('edit.php?post_type=shop_coupon'))),
					'id' => 'coupon_rules_section_title'
				),
			),
			'compatibility' => array(
				'title' => __('Compatibility with your server and setup', VCWCCR_TEXT_DOMAIN),
				'wccr_enable_cache_support' => array(
					'name' => __('Enable support for cache plugins?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('If you enable this option, we will show all products in the catalog pages and we will apply the restrictions via ajax on the product page and checkout page only. If you need help contact us. Note. Do not enable this option if you are using WPRocket or WP-Optimize, we have automatic support for those plugins.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('No', VCWCCR_TEXT_DOMAIN),
						'yes' => __('Yes', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wccr_enable_cache_support',
				),
				'wccr_enable_rest_api_restrictions' => array(
					'name' => __('Apply restrictions on the WC REST API endpoints?', VCWCCR_TEXT_DOMAIN),
					'desc' => __('Default: No. We only apply restrictions for the web pages, the REST API endpoints dont have restrictions.', VCWCCR_TEXT_DOMAIN),
					'type' => 'select',
					"options" => array(
						'' => __('No', VCWCCR_TEXT_DOMAIN),
						'yes' => __('Yes', VCWCCR_TEXT_DOMAIN),
					),
					'id' => 'wccr_enable_rest_api_restrictions',
				),
			),
			'shortcodes' => array(
				'title' => __('Shortcodes', VCWCCR_TEXT_DOMAIN),
				'shortcodes_desc' => array(
					'type' => 'title',
					'desc' => __('You can use these shortcodes:<br><br>[vcwccr_country_selector]  This displays the flags dropdown selector.<br><hr><br>[wccr_country countries=“US,SV,ES”]This is a great product[/wccr_country]<br><br>You can use this to show content/descriptions for specific countries or show different text in the home page, blog posts, about us, contact us page, etc based on the country of the user. <a href="https://wpsuperadmins.com/blog/woocommerce-product-descriptions-per-country-geolocalize-descriptions/?utm_source=wp-admin&utm_campaign=settings-page&utm_medium=country-catalogs-shortcodes" target="_blank">Tutorial</a>', VCWCCR_TEXT_DOMAIN),
				),
			)
		);

		return apply_filters('vcwccr_tab_settings_filter', $settings);
	}

}

if (!function_exists('wcacr_render_variations_settings')) {

	function wcacr_render_variations_settings() {

		$countries = vcwccr_get_countries_with_continents();
		asort($countries);

		if (!empty($_POST['vcwccr_attributes_rules'])) {
			$attributes_rules = wc_clean($_POST['vcwccr_attributes_rules']);
			update_option('vcwccr_attributes_rules', $attributes_rules);
		}

		$existing_attribute_rules = get_option('vcwccr_attributes_rules');
		if (empty($existing_attribute_rules)) {
			$existing_attribute_rules = array();
		}
		?>

		<style>
			.template-group label {
				display: block;
			}
			.attributes-group .field {
				margin-bottom: 10px;
				max-width: 400px;
			}
			.template-group select,
			.template-group input {
				width: 100%;
				display: inline-block;
			}
			.template-group {
				border-bottom: 1px solid #bbb;
				margin-bottom: 20px;
				padding-bottom: 20px;
				position: relative;
				max-width: 500px;
			}
			.template-group .vg-remove-parent {
				position: absolute;
				bottom: 20px;
				right: 0;
			}
		</style>
		<div class="variation-rules">
			<div id="vcwccr_settings_variations_section_title-description">
				<p><?php _e('If you have variable products, in this section you can select which product variations can be viewed by some countries/states. This applies to all variable products. For example, show "color:red" and "format:physical" to the United States only. Another example, show "size:large" to all countries except Canada.', VCWCCR_TEXT_DOMAIN); ?></p>
			</div>
			<div class="template-group attributes-group hidden">
				<h3><?php _e('Rules group', VCWCCR_TEXT_DOMAIN); ?></h3>
				<div class="field">
					<label><?php _e('Select country/state', VCWCCR_TEXT_DOMAIN); ?></label>
					<select multiple="multiple" name="vcwccr_attributes_rules[index][countries][]" style="width:350px" data-placeholder="Choose countries&hellip;" aria-label="Country" class="wc-enhanced-select-late">
						<option value="">--</option>
						<?php
						if (!empty($countries)) {
							foreach ($countries as $key => $val) {
								echo '<option value="' . esc_attr($key) . '" >' . esc_html($val) . '</option>';
							}
						}
						?>
					</select>
					<br /><a class="vg-select_all button" href="#"><?php esc_html_e('Select all', 'woocommerce'); ?></a> <a class="vg-select_none button" href="#"><?php esc_html_e('Select none', 'woocommerce'); ?></a>
				</div>
				<div class="field">
					<label for=""><?php _e('Select attributes', VCWCCR_TEXT_DOMAIN); ?></label>
					<select name="vcwccr_attributes_rules[index][attributes][]" id="vcwccr_selected_attributes" style="" class="wc-enhanced-select-late" multiple="multiple">
						<option value="">--</option>
						<?php
						foreach (vcwccr_get_attributes() as $key => $val) {
							echo '<option value="' . esc_attr($key) . '" >' . esc_html($val) . '</option>';
						}
						?>

					</select>

				</div>
				<div class="field">
					<label for=""><?php _e('Sell product variations in the selected countries/states', VCWCCR_TEXT_DOMAIN); ?></label>
					<select name="vcwccr_attributes_rules[index][operator]" id="variation_attribute_operator" style="" class="wc-enhanced-select-late">
						<option value="">--</option>
						<?php
						foreach (vcwccr_get_country_availability_operators() as $key => $val) {
							echo '<option value="' . esc_attr($key) . '" >' . esc_html($val) . '</option>';
						}
						?>

					</select>

				</div>
				<button type="button" class="button vg-remove-parent"><?php _e('Remove', VCWCCR_TEXT_DOMAIN); ?></button>
			</div>

			<?php
			foreach ($existing_attribute_rules as $index => $group) {
				if (empty($group['countries'])) {
					continue;
				}
				?>

				<div class="template-group attributes-group">
					<h3><?php _e('Rules group', VCWCCR_TEXT_DOMAIN); ?></h3>
					<div class="field">
						<label><?php _e('Select country/state', VCWCCR_TEXT_DOMAIN); ?></label>
						<select multiple="multiple" name="vcwccr_attributes_rules[<?php echo $index; ?>][countries][]" style="width:350px" data-placeholder="Choose countries&hellip;" aria-label="Country" class="wc-enhanced-select-late">
							<option value="">--</option>
							<?php
							if (!empty($countries)) {
								foreach ($countries as $key => $val) {
									echo '<option value="' . esc_attr($key) . '" ' . wc_selected($key, $group['countries']) . '>' . esc_html($val) . '</option>';
								}
							}
							?>
						</select>
						<br /><a class="vg-select_all button" href="#"><?php esc_html_e('Select all', 'woocommerce'); ?></a> <a class="vg-select_none button" href="#"><?php esc_html_e('Select none', 'woocommerce'); ?></a>
					</div>
					<div class="field">
						<label for=""><?php _e('Select attributes', VCWCCR_TEXT_DOMAIN); ?></label>
						<select name="vcwccr_attributes_rules[<?php echo $index; ?>][attributes][]" id="vcwccr_selected_attributes" style="" class="wc-enhanced-select-late" multiple="multiple">
							<option value="">--</option>
							<?php
							foreach (vcwccr_get_attributes() as $key => $val) {
								echo '<option value="' . esc_attr($key) . '" ' . wc_selected($key, $group['attributes']) . '>' . esc_html($val) . '</option>';
							}
							?>

						</select>

					</div>
					<div class="field">
						<label for=""><?php _e('Sell product variations in the selected countries/states', VCWCCR_TEXT_DOMAIN); ?></label>
						<select name="vcwccr_attributes_rules[<?php echo $index; ?>][operator]" id="variation_attribute_operator" style="" class="wc-enhanced-select-late">
							<option value="">--</option>
							<?php
							foreach (vcwccr_get_country_availability_operators() as $key => $val) {
								echo '<option value="' . esc_attr($key) . '" ' . wc_selected($key, $group['operator']) . '>' . esc_html($val) . '</option>';
							}
							?>

						</select>

					</div>
					<button type="button" class="button vg-remove-parent"><?php _e('Remove', VCWCCR_TEXT_DOMAIN); ?></button>
				</div>
			<?php }
			?>
			<button type="button" class="button vg-clone-prev-template"><?php _e('Add new', VCWCCR_TEXT_DOMAIN); ?></button>
		</div>
		<?php
	}

}

if (!function_exists("vcwccr_tab_settings")) {

	add_action('woocommerce_settings_tabs_variations_per_country_tab', "vcwccr_tab_settings");

	function vcwccr_tab_settings() {
		$options = vcwccr_tab_get_settings();
		?>
		<style>
			.tabs {
				width: 220px;
				float: left;
				background: #444;
			}
			.tabs a {
				display: block;
				font-size: 15px;
				text-decoration: none;
				color: white;
				padding: 10px;
				border-bottom: 1px solid #999999;
			}
			.tabs a.active {
				background: #555;
			}

			.tab-content {
				width: 1000px;
				width: calc(100% - 220px);
				float: left;
				padding: 0 40px;
				box-sizing: border-box;
			}
			p.submit {
				clear: both;
				padding-left: 260px;
			}
		</style>
		<div class="tabs">
			<?php
			foreach ($options as $tab_id => $fields) {
				$tab_name = $fields['title'];
				?>
				<a href="#<?php echo esc_attr($tab_id); ?>"><?php echo esc_html($tab_name); ?></a>
				<?php
			}
			?>
		</div>
		<?php
		foreach ($options as $tab_id => $fields) {
			$tab_name = $fields['title'];
			unset($fields['title']);
			?>
			<div class="tab-content" id="<?php echo esc_attr($tab_id); ?>">
				<h2><?php echo esc_html($tab_name); ?></h2>
				<?php
				foreach ($fields as $field) {
					if ($field['type'] === 'callable' && is_callable($field['callback'])) {
						call_user_func($field['callback']);
					} else {
						ob_start();
						woocommerce_admin_fields(array($field));
						$field_html = ob_get_clean();

						if (strpos($field_html, '<tr') === false) {
							$html = str_replace('<table class="form-table">', '', $field_html);
						} else {
							$html = '<table class="form-table"><tbody>' . $field_html . '</tbody></table>';
						}
						echo $html;
					}
				}

				do_action('vcwccr_tab_settings_after/' . $tab_id);
				?>
			</div>
			<?php
		}
		?>
		<?php
		do_action('vcwccr_tab_settings_after');
	}

}

if (!function_exists("vcwccr_update_settings")) {

	add_action('woocommerce_update_options_variations_per_country_tab', 'vcwccr_update_settings');

	function vcwccr_update_settings() {
		foreach (vcwccr_tab_get_settings() as $fields) {
			woocommerce_update_options($fields);
		}
	}

}

if (!function_exists("vcwccr_adding_scripts")) {

	add_action("admin_enqueue_scripts", "vcwccr_adding_scripts");

	function vcwccr_adding_scripts($hook) {

		//enqueing scripts in variations per country settings tab
		if ($hook === "woocommerce_page_wc-settings") {

			if ($_GET["page"] === "wc-settings" && isset($_GET["tab"]) && $_GET["tab"] === "variations_per_country_tab") {

				wp_enqueue_script("vcwccr_settings_script", plugin_dir_url(__DIR__) . "assets/js/settings_script.js", array("jquery"));
				wp_localize_script('vcwccr_settings_script', 'wcacr_data', array(
					'home_url' => home_url()
				));
			}
		}
	}

}

