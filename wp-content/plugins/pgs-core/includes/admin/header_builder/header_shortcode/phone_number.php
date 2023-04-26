<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['phone_number'] = header_builder_element_phone_number();

function header_builder_element_phone_number() {

	$shortcode_fields = array(
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'phone_number_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'description'    => sprintf(
				wp_kses(
					__( '<strong>Phone Number</strong>: You can manage phone number in <strong>"Site Contacts > Site Info"</strong> tab in <a href="%s" target="_blank">Theme Options</a>.', 'pgs-core' ),
					array(
						'a'      => array(
							'href'   => true,
							'target' => true,
						),
						'strong' => array(),
					)
				),
				admin_url( 'themes.php?page=ciyashop-options&tab=32' )
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
								'<strong>phone_number_' . '</strong>'
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
		'id'           => 'phone_number',
		'name'         => esc_html__( 'Phone Number', 'pgs-core' ),
		'description'  => esc_html__( 'Phone Number', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/phone-number-icon.png',
		'element_icon' => 'ti-mobile',
		'params'       => $shortcode_fields,
	);

	return $params;

}
