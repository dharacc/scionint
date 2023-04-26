<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );
?>
<div class="products-listing-link">
	<?php
	if ( ! empty( $link_title ) && ! empty( $link_attr ) ) {
		echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', ciyashop_allowed_html( 'a' ) );
	}
	?>
</div>
