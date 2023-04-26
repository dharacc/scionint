<?php
/**
 * Woo tools Compare.
 *
 * @package CiyaShop
 */

global $yith_woocompare;

// Return if compare plugin is not installed/activated ($yith_woocompare == null).
if ( ! $yith_woocompare ) {
	return;
}

?>
<li class="woo-tools-action woo-tools-compare">
	<a href="<?php echo esc_url( add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ); ?>" class="compare" rel="nofollow">
		<?php ciyashop_compare_icon(); ?>
	</a>
</li>
