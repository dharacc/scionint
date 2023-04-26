<?php
/**
 * Ajax handler class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_Ajax_Handler' ) ) {
	/**
	 * WooCommerce Brands
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Ajax_Handler {

		public static function init() {
			add_action( 'wp_ajax_yith_wcbr_brand_filter', array( 'YITH_WCBR_Ajax_Handler', 'brand_filter' ) );
			add_action( 'wp_ajax_nopriv_yith_wcbr_brand_filter', array( 'YITH_WCBR_Ajax_Handler', 'brand_filter' ) );
		}

		public static function brand_filter() {
			$shortcode_args = isset( $_POST['shortcode_args'] ) ? $_POST['shortcode_args'] : false;
			$filter         = isset( $_POST['filter'] ) ? sanitize_text_field( $_POST['filter'] ) : false;
			$current_page   = isset( $_POST['page'] ) ? intval( $_POST['page'] ) : false;

			// sanitize shortcode args
			$sanitized_args = array();

			if ( ! empty( $shortcode_args ) ) {
				foreach ( $shortcode_args as $key => $value ) {
					if ( ! is_string( $value ) ) {
						continue;
					}

					$value = sanitize_text_field( $value );

					$sanitized_args[ $key ] = $value;
				}
			}

			if ( ! empty( $filter ) && 'all' !== $filter ) {
				$sanitized_args['name_like'] = $filter;
			}

			if ( ! empty( $current_page ) ) {
				$sanitized_args['page'] = $current_page;
			}

			// create param in textual form
			$args_string = "";

			if ( ! empty( $sanitized_args ) ) {
				foreach ( $sanitized_args as $key => $value ) {
					$args_string .= " {$key}=\"{$value}\"";
				}
			}

			$shortcode = "[yith_wcbr_brand_filter {$args_string}]";
			echo do_shortcode( $shortcode );
			die;
		}

	}
}

// init shortcodes
YITH_WCBR_Ajax_Handler::init();