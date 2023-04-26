<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {
	return array(
		'id'               => 'woocommerce_checkout',
		'title'            => esc_html__( 'Checkout', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'woocommerce_checkout_layout',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Checkout Layout', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select checkout page layout', 'pgs-core' ),
				'options'  => array(
					'default'      => esc_html__( 'Default', 'pgs-core' ),
					'light_spiral' => esc_html__( 'Light Spiral', 'pgs-core' ),
					'dark'         => esc_html__( 'Dark', 'pgs-core' ),
				),
				'default'  => 'default',
			),
		),
	);
}
