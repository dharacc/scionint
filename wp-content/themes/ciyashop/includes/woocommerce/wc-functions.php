<?php
/**
 * WooCommerce Functions
 *
 * @package CiyaShop
 */

if ( function_exists( 'WC' ) ) {

	require_once get_parent_theme_file_path( '/includes/woocommerce/module/class-ciyashop-wishlist.php' ); // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

	if ( ! function_exists( 'ciyashop_get_available_attr_array' ) ) {
		/**
		 * Get all available product attributes for product filter options
		 *
		 * @param string $return .
		 */
		function ciyashop_get_available_attr_array( $return = 'all' ) {
			// Default Attributes.
			$default_filters = array(
				'search-box'   => esc_html__( 'Search Box', 'ciyashop' ),
				'categories'   => esc_html__( 'Categories', 'ciyashop' ),
				'ratings'      => esc_html__( 'Ratings', 'ciyashop' ),
				'price-slider' => esc_html__( 'Price Slider', 'ciyashop' ),
			);
			if ( 'default_filters' === $return ) {
				return $default_filters;
			}

			// Taxonomy Attributes.
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			$attributes           = array();
			if ( ! empty( $attribute_taxonomies ) ) {
				foreach ( $attribute_taxonomies as $attr ) {
					$attributes[ $attr->attribute_name ] = $attr->attribute_label;
				}
			}
			if ( 'taxonomy_attributes' === $return ) {
				return $attributes;
			}
			return array_merge( $default_filters, $attributes );
		}
	}

	if ( ! function_exists( 'ciyashop_get_product_attr_array' ) ) {
		/**
		 * Get all the product attributes
		 */
		function ciyashop_get_product_attr_array() {
			$product_attributes = wc_get_attribute_taxonomies();
			$product_attribute  = array();

			foreach ( $product_attributes as $key => $value ) {
				$product_attribute[ 'pa_' . $value->attribute_name ] = $value->attribute_label;
			}

			return $product_attribute;
		}
	}
}
