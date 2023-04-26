<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {
	global $wp_customize;

	$pgs_core_redux_options_woocommerce_section_title = esc_html__( 'WooCommerce', 'pgs-core' );

	if ( isset( $wp_customize ) ) {
		$pgs_core_redux_options_woocommerce_section_title = esc_html__( 'WooCommerce (Theme Options)', 'pgs-core' );
	}

	return array(
		'title'            => $pgs_core_redux_options_woocommerce_section_title,
		'id'               => 'woocommerce_section',
		'customizer_width' => '400px',
		'icon'             => 'el el-shopping-cart icon-large',
	);
}
