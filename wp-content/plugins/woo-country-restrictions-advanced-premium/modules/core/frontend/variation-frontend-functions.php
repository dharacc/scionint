<?php
if ( ! function_exists( 'wcacr_hide_country_attribute_from_variations_early' ) ) {
	add_action( 'wp_head', 'wcacr_hide_country_attribute_from_variations_early' );

	function wcacr_hide_country_attribute_from_variations_early() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}
		$country_attribute = get_option( 'wccr_hide_country_attribute' );
		if ( empty( $country_attribute ) ) {
			return;
		}

		?>
		<style>
			.variations_form.cart label[for="<?php echo sanitize_text_field( $country_attribute ); ?>"],
			.variations_form.cart select#<?php echo sanitize_text_field( $country_attribute ); ?> {
				display: none !important;
			}
		</style>
		<?php
	}
}

if ( ! function_exists( 'wcacr_hide_country_attribute_from_variations' ) ) {
	add_action( 'wp_footer', 'wcacr_hide_country_attribute_from_variations', 99 );

	function wcacr_hide_country_attribute_from_variations() {
		if ( ! is_singular( 'product' ) ) {
			return;
		}
		$country_attribute = get_option( 'wccr_hide_country_attribute' );
		if ( empty( $country_attribute ) ) {
			return;
		}

		?>
		<script>
			jQuery(document).ready(function () {
				var $select = jQuery('.variations_form.cart #<?php echo sanitize_text_field( $country_attribute ); ?>');
				if (!$select.length) {
					return;
				}
				var $firstOption = $select.find('option').filter(function () {
					return jQuery(this).attr('value');
				});
				$select.val($firstOption.first().attr('value')).trigger('change');
				$select.parents('tr').hide();
			});
		</script>
		<?php
	}
}

if ( ! function_exists( 'wcacr_filter_variation_attribute_options' ) ) {
	add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'wcacr_filter_variation_attribute_options' );

	function wcacr_filter_variation_attribute_options( $args ) {
		global $product;

		if ( ! empty( $product ) && intval( get_post_field( 'post_author', $product->get_id() ) ) === get_current_user_id() ) {
			  return $args;
		}

		$attribute_rules       = get_option( 'vcwccr_attributes_rules' );
		$attribute_rules_plain = serialize( $attribute_rules );
		if ( empty( $attribute_rules ) ) {
			$attribute_rules = array();
		}

		$my_country = wcacr_get_user_country();

		if ( empty( $attribute_rules ) || empty( $my_country ) || strpos( $attribute_rules_plain, $args['attribute'] ) === false ) {
			return $args;
		}

		$options = array();
		foreach ( $attribute_rules as $rule ) {
			if ( empty( $rule['countries'] ) ) {
				continue;
			}

			$attributes_are_visible = vcwccr_country_is_valid( $rule['countries'], $my_country, (int) $rule['operator'] );
			foreach ( $args['options'] as $attribute_value ) {
				$full_attribute = $args['attribute'] . ':' . $attribute_value;
				if ( ( $attributes_are_visible && in_array( $full_attribute, $rule['attributes'], true ) ) || ( ! $attributes_are_visible && ! in_array( $full_attribute, $rule['attributes'], true ) ) ) {
					$options[] = $attribute_value;
				}
			}
		}
		$args['options'] = $options;
		return $args;
	}
}

if ( ! function_exists( 'wcacr_get_enabled_variation' ) ) {
	add_filter( 'woocommerce_available_variation', 'wcacr_get_enabled_variation', 10, 3 );

	function wcacr_get_enabled_variation( $variation_data, $product, $variation ) {

		if ( vcwccr_is_restricted( $variation->get_id() ) || vcwccr_variation_has_restricted_attributes( $variation ) ) {
			$variation_data['is_purchasable']       = false;
			$variation_data['variation_is_visible'] = false;
		}

		return $variation_data;
	}
}
if ( ! function_exists( 'vcwccr_variations_filter' ) ) {

	add_filter( 'woocommerce_get_children', 'vcwccr_variations_filter', 10, 1 );

	function vcwccr_variations_filter( $children ) {

		if ( empty( $children ) ) {
			return $children;
		}

		$available_variations = array();
		foreach ( $children as $index => $child ) {

			$current_child = wc_get_product( $child );

			// If current child is variation we check restrictions
			// We use strpos to accept any type like variation, subscription_variation, etc.
			if ( strpos( $current_child->get_type(), 'variation' ) !== false ) {

				if ( ! vcwccr_is_restricted( $child ) && ! vcwccr_variation_has_restricted_attributes( $current_child ) ) {
					$available_variations[] = $child;

				}
			}
		}

		return $available_variations;
	}
}

if ( ! function_exists( 'vcwccr_variation_has_restricted_attributes' ) ) {

	function vcwccr_variation_has_restricted_attributes( $variation ) {

		$variation_post_author = intval( get_post_field( 'post_author', $variation->get_id() ) );
		if ( $variation_post_author === get_current_user_id() ) {
			return false;
		}

		$attribute_rules = get_option( 'vcwccr_attributes_rules' );
		if ( empty( $attribute_rules ) ) {
			$attribute_rules = array();
		}

		$my_country = wcacr_get_user_country();

		$has_restricted_attributes = false;

		if ( empty( $attribute_rules ) || empty( $my_country ) ) {
			return $has_restricted_attributes;
		}

		$variation_attributes = $variation->get_attributes();
		$attributes_keys      = array_keys( $variation_attributes );

		$attributes = array_map( 'strtolower', $attributes_keys );
		foreach ( $attribute_rules as $rule ) {
			if ( empty( $rule['countries'] ) ) {
				continue;
			}
			$required_attributes_setting           = $rule['attributes'];
			$attributes_selected_countries_setting = $rule['countries'];
			$selected_operator_attributes_setting  = $rule['operator'];

			$required_attributes           = apply_filters( 'vcwccr_selected_attributes_setting_before_restrictions_check', $required_attributes_setting );
			$attributes_selected_countries = apply_filters( 'vcwccr_attributes_selected_countries_before_restrictions_check', $attributes_selected_countries_setting );
			$required_attributes_operator  = apply_filters( 'vcwccr_attributes_availability_operator_before_restrictions_check', $selected_operator_attributes_setting );

			foreach ( $required_attributes as $attribute ) {

				$attribute_exploded = explode( ':', $attribute );

				$attribute_key_index = array_search( strtolower( $attribute_exploded[0] ), $attributes );

				// Required attribute not found in the variation attributes, so we try with the next one...
				if ( $attribute_key_index === false ) {
					continue;
				}

				$variation_attribute_value = $variation_attributes[ $attributes_keys[ $attribute_key_index ] ];

				if ( $variation_attribute_value == '' ) {
					if ( vcwccr_all_variation_attributes_selected( $attributes_keys[ $attribute_key_index ], $required_attributes ) ) {

						if ( ! vcwccr_country_is_valid( $attributes_selected_countries, $my_country, intval( $required_attributes_operator ) ) ) {
							$has_restricted_attributes = true;
						}
					}
					continue;
				}

				if ( strtolower( $variation_attribute_value ) == strtolower( $attribute_exploded[1] ) ) {

					if ( ! vcwccr_country_is_valid( $attributes_selected_countries, $my_country, intval( $required_attributes_operator ) ) ) {
						$has_restricted_attributes = true;
					}
				}
			}
		}

		return $has_restricted_attributes;
	}
}

if ( ! function_exists( 'vcwccr_all_variation_attributes_selected' ) ) {

	function vcwccr_all_variation_attributes_selected( $attribute_name, $selected_attributes_in_settings ) {

		$any_attribute_is_restricted             = true;
		$correct_selected_attributes_in_settings = array_map( 'strtolower', vcwccr_get_correct_attributes( $attribute_name, $selected_attributes_in_settings ) );
		$wc_correct_attributes                   = vcwccr_get_correct_attributes( $attribute_name, vcwccr_get_attributes() );

		if ( empty( $wc_correct_attributes ) ) {
			return $any_attribute_is_restricted;
		}

		foreach ( $wc_correct_attributes as $wc_correct_attribute ) {

			if ( ! in_array( strtolower( $wc_correct_attribute ), $correct_selected_attributes_in_settings ) ) {
				$any_attribute_is_restricted = false;
			}
		}

		return $any_attribute_is_restricted;
	}
}

if ( ! function_exists( 'vcwccr_get_correct_attributes' ) ) {

	function vcwccr_get_correct_attributes( $attribute_name, $attributes ) {

		$correct_attributes = array();

		if ( empty( $attributes ) ) {
			return $correct_attributes;
		}

		foreach ( $attributes as $current_attribute ) {

			$current_attribute_exploded = explode( ':', $current_attribute );

			if ( $current_attribute_exploded[0] == $attribute_name ) {
				$correct_attributes[] = $current_attribute;
			}
		}

		return $correct_attributes;
	}
}



