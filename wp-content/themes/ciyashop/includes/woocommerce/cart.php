<?php
/**
 * WC cart
 *
 * @package CiyaShop
 */

/**
 * Remove cart item
 */
function ciyashop_remove_cart_item() {
	global $woocommerce;

	if ( ! empty( $_POST['_wpnonce'] ) ) {
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'woocommerce-cart' ) ) {

			$cart_item_key = false;

			if ( ! empty( $_POST['product_id'] ) && ! empty( $_POST['remove_item'] ) ) {

				$cart_item_key = sanitize_text_field( wp_unslash( $_POST['remove_item'] ) );

			} elseif ( empty( $_POST['product_id'] ) && ! empty( $_POST['remove_item'] ) ) {

				$cart_item_key = sanitize_text_field( wp_unslash( $_POST['remove_item'] ) );

			} elseif ( ! empty( $_POST['product_id'] ) && empty( $_POST['remove_item'] ) ) {

				$product_id = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );

				$cart_item_key = ciyashop_wc_get_cart_item_key( $product_id );
			}

			// Remove cart item.
			if ( $cart_item_key ) {
				$woocommerce->cart->remove_cart_item( $cart_item_key );
			}
		}
	}

	echo WC_AJAX::get_refreshed_fragments(); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
	wp_die();

}
add_action( 'wp_ajax_ciyashop_remove_cart_item', 'ciyashop_remove_cart_item' );
add_action( 'wp_ajax_nopriv_ciyashop_remove_cart_item', 'ciyashop_remove_cart_item' );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );


add_action( 'woocommerce_before_checkout_form', 'ciyashop_row_start', 9 );
if ( ! function_exists( 'ciyashop_row_start' ) ) {
	/**
	 * Row start
	 */
	function ciyashop_row_start() {
		?> <div class="row"> 
		<?php
	}
}


add_action( 'woocommerce_before_checkout_form', 'ciyashop_row_end', 11 );
if ( ! function_exists( 'ciyashop_row_end' ) ) {
	/**
	 * Row end
	 */
	function ciyashop_row_end() {
		?>
		</div> 
		<?php
	}
}

add_filter( 'woocommerce_cross_sells_columns', 'ciyashop_change_cross_sells_columns' );

if ( ! function_exists( 'ciyashop_change_cross_sells_columns' ) ) {
	/**
	 * Change scross sells columns
	 *
	 * @param int $columns .
	 */
	function ciyashop_change_cross_sells_columns( $columns ) {
		return 4;
	}
}
