<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['currency'] = header_builder_element_currency();

function header_builder_element_currency() {

	$shortcode_fields = array(
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'currency_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'description'    => sprintf(
				wp_kses(
					__( '<strong>Currency</strong>: This content is <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> dependant and it will be available only if <a href="%1$s" target="_blank">WooCommerce Currency Switcher</a> is installed.', 'pgs-core' ),
					array(
						'a'      => array(
							'href'   => true,
							'target' => true,
						),
						'strong' => true,
					)
				),
				'https://wordpress.org/plugins/woocommerce-currency-switcher/'
			),
			'display_header' => true,
			'group'          => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'ID', 'pgs-core' ),
			'param_name'  => 'element_id',
			'description' => sprintf(
				wp_kses(
					__( 'Enter ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>)', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.w3schools.com/tags/att_global_id.asp'
			)
							. '<br><span class="pgs-core-red">' .
							sprintf(
								wp_kses(
									__( 'Important : ID will be starts prefixed with "%s".', 'pgs-core' ),
									array(
										'atrong' => true,
									)
								),
								'<strong>currency_' . '</strong>'
							)
							. '</span>',
			'settings'    => array(
				// 'auto_generate'=> true,
			),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'pgs-core' ),
			'param_name'  => 'element_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pgs-core' ),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
	);

	// Params
	$params = array(
		'id'           => 'currency',
		'name'         => esc_html__( 'Currency', 'pgs-core' ),
		'description'  => esc_html__( 'Currency Dropdown', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/currency-icon.png',
		'element_icon' => 'ti-money',
		'params'       => $shortcode_fields,
	);

	return $params;

}
