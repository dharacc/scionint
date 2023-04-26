<?php

if (!function_exists('vcwccr_allow_to_hide_products')) {
	add_filter('wcacr_allow_to_hide_products', 'vcwccr_allow_to_hide_products');

	function vcwccr_allow_to_hide_products($allowed) {
		if (get_option('wccr_restriction_method', 'hide') !== 'hide') {
			$allowed = false;
		}
		return $allowed;
	}

}

if (!function_exists('vcwccr_allow_to_purchase_product')) {
	add_filter('woocommerce_is_purchasable', 'vcwccr_allow_to_purchase_product', 99, 2);

	function vcwccr_allow_to_purchase_product($is_purchasable, $product) {

		if (get_option('wccr_auto_remove_restricted_products_checkout') !== 'no') {
			$product_id_to_check = ( $product->is_type('variation') ) ? $product->get_parent_id() : $product->get_id();
			$is_restricted = !vcwccr_shop_is_available() || vcwccr_is_restricted($product_id_to_check);
			if ($is_restricted) {
				$is_purchasable = !$is_restricted;
				if (!$is_purchasable) {
					add_filter('woocommerce_cart_item_removed_message', 'wcacr_filter_cart_item_removed_message', 10, 2);
				}
			}
		}
		return $is_purchasable;
	}

}

if (!function_exists('wcacr_filter_cart_item_removed_message')) {

	function wcacr_filter_cart_item_removed_message($message, $product) {
		$message = vcwccr_get_product_not_allowed_message($product->get_name());
		return $message;
	}

}
if (!function_exists('vcwccr_disallow_variation_add_to_cart')) {
	add_action('woocommerce_single_variation', 'vcwccr_disallow_variation_add_to_cart', 1);

	function vcwccr_disallow_variation_add_to_cart() {
		global $product;
		$is_allowed = vcwccr_allow_to_purchase_product(true, $product);
		if (!$is_allowed) {
			// We use remove_action as the simple solution.
			// some things might use the action with a different priority or
			// call the function woocommerce_single_variation_add_to_cart_button from
			// another action. In that case, we could overwrite the template
			// 'single-product/add-to-cart/variation-add-to-cart-button.php' here to return
			// an empty file.
			remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
		}
	}

}

if (!function_exists('vcwccr_maybe_hide_product_price_in_template')) {
	add_filter('template_redirect', 'vcwccr_maybe_hide_product_price_in_template', 99);

	function vcwccr_maybe_hide_product_price_in_template() {
		if (is_singular('product') && get_option('wccr_restriction_method', 'hide') === 'disable_add_to_cart_prices' && (!vcwccr_shop_is_available() || vcwccr_is_restricted(get_queried_object_id()))) {
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price');
		}
	}

}
if (!function_exists('vcwccr_maybe_hide_product_price')) {
	add_filter('woocommerce_get_price_html', 'vcwccr_maybe_hide_product_price', 99, 2);

	function vcwccr_maybe_hide_product_price($price, $product) {
		if (get_option('wccr_restriction_method', 'hide') === 'disable_add_to_cart_prices' && (!vcwccr_shop_is_available() || vcwccr_is_restricted($product->get_id()))) {
			$price = '';
		}
		return $price;
	}

}

if (!function_exists('wcacr_set_user_country_from_session')) {
	add_filter('vcwccr_set_user_country', 'wcacr_set_user_country_from_session', 10, 3);

	function wcacr_set_user_country_from_session($my_country, $geolocation_method, $suggested_country) {
		$option_key = ( $geolocation_method === 'primary') ? 'wccr_geolocation_method' : 'wccr_secondary_geolocation_method';
		$geolocation_method_key = get_option($option_key, 'ip');

		if (in_array($geolocation_method_key, array('shipping_country', 'billing_country')) && is_object(WC()->cart)) {
			$billing_country = apply_filters('vcwccr_get_customer_billing_country', WC()->cart->get_customer()->get_billing_country());
			$shipping_country = apply_filters('vcwccr_get_customer_shipping_country', WC()->cart->get_customer()->get_shipping_country());
			if (empty($suggested_country)) {
				if ($geolocation_method_key === 'shipping_country' && !empty($shipping_country)) {
					$my_country = $shipping_country;
				} elseif ($geolocation_method_key === 'billing_country' && !empty($billing_country)) {
					$my_country = $billing_country;
				}
			} else {
				$my_country = $suggested_country;
			}

			// Fix bug from WC Core. When the option "Default customer location=geolocate",
			// WC sets the shipping/billing country as the full name but everywhere it sets it as a 2 digit code
			// so here we make sure it's the country code...
			if (strlen($my_country) > 2) {
				$allowed_country_codes = WC()->countries->get_countries();
				$country_code = array_search($my_country, $allowed_country_codes, true);
				if ($country_code !== false) {
					$my_country = $country_code;
				}
			}
		}

		return $my_country;
	}

}

if (!function_exists('wcacr_prevent_checkout_if_wrong_country')) {
	add_action('wp_footer', 'wcacr_prevent_checkout_if_wrong_country');

	/**
	 * Disable the checkout form submission when there is a "country not allowed" message visible
	 * @return null
	 */
	function wcacr_prevent_checkout_if_wrong_country() {
		if (!is_checkout()) {
			return;
		}
		?>
		<script>
			jQuery(window).on('load', function () {
				setInterval(function () {
					var $button = jQuery('.woocommerce-checkout #place_order');
					if (jQuery('.wcacr-wrong-country').length) {
						$button.attr('disabled', 'disabled');
					} else if (!jQuery('.woocommerce-error li').length) {
						$button.removeAttr('disabled');
					}
				}, 800);
			});
		</script>
		<?php

	}

}

if (!function_exists('vcwccr_maybe_remove_product_from_cart')) {
	add_action('woocommerce_checkout_update_order_review', 'vcwccr_maybe_remove_product_from_cart');

	function vcwccr_maybe_remove_product_from_cart($posted_data) {
		$checkout_data = wp_parse_args($posted_data);
		$geolocation_method_key = get_option('wccr_geolocation_method', 'ip');
		$billing_country_key = apply_filters('vcwccr_billing_country_key_from_cart', 'billing_country');
		$shipping_country_key = apply_filters('vcwccr_billing_country_key_from_cart', 'shipping_country');

		if (in_array($geolocation_method_key, array('shipping_country', 'billing_country'))) {
			$shipping_country = ( empty($checkout_data['ship_to_different_address']) ) ? $checkout_data[$billing_country_key] : $checkout_data[$shipping_country_key];
			$country = null;
			if ($geolocation_method_key === 'shipping_country' && !empty($shipping_country)) {
				$country = $shipping_country;
			} elseif ($geolocation_method_key === 'billing_country' && !empty($checkout_data[$billing_country_key])) {
				$country = $checkout_data[$billing_country_key];
			}
			wcacr_set_user_country($country);

			// If the primary method is shipping or billing country and we don't have the country, use the fallback method
			if (!wcacr_get_user_country()) {
				wcacr_set_user_country($country, 'secondary');
			}
		}
		$country = wcacr_get_user_country();

		// If the country selector is linked to the shipping country, set the shipping country as user country
		if (get_option('wccr_geolocation_method') === 'country_selector' && get_option('wccr_country_selector_linked_shipping_country') === 'yes') {
			$shipping_country = ( empty($checkout_data['ship_to_different_address']) ) ? $checkout_data[$billing_country_key] : $checkout_data[$shipping_country_key];
			if (!empty($shipping_country)) {
				// The country selector needs this, otherwise the set_user_country has no result
				$_GET['wccr_country'] = $shipping_country;
				wcacr_set_user_country($shipping_country);
			}
		}

		$allow_to_remove_from_cart = get_option('wccr_auto_remove_restricted_products_checkout') !== 'no';
		$post_ids_removed = array();
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

			$is_product_restricted = !vcwccr_shop_is_available() || vcwccr_is_restricted($cart_item['product_id']);

			$is_variation_restricted = false;
			if (!empty($cart_item['variation_id'])) {
				$variation = wc_get_product($cart_item['variation_id']);
				$is_variation_restricted = vcwccr_is_restricted($cart_item['variation_id']) || vcwccr_variation_has_restricted_attributes($variation);
			}

			if ($is_product_restricted || $is_variation_restricted) {
				if ($allow_to_remove_from_cart) {
					WC()->cart->remove_cart_item($cart_item_key);
				}
				$post_ids_removed[] = ($is_product_restricted) ? $cart_item['product_id'] : $cart_item['variation_id'];
			}
		}

		$post_ids_removed = array_unique($post_ids_removed);
		foreach ($post_ids_removed as $post_id_for_alert) {
			wc_add_notice(vcwccr_get_product_not_allowed_message(get_the_title($post_id_for_alert)), 'error');
		}
	}

}
	