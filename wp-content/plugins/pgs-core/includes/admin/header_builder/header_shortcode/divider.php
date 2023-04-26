<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['divider'] = header_builder_element_divider();

function header_builder_element_divider() {

	$shortcode_fields = array(
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Set Full Height', 'pgs-core' ),
			'param_name'  => 'divider_full_height',
			'options'     => esc_html__( 'Full Height', 'pgs-core' ),
			'default'     => false,
			'description' => esc_html__( 'Set the full height for divider.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
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
								'<strong>divider_' . '</strong>'
							)
							. '</span>',
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
		'id'           => 'divider',
		'name'         => esc_html__( 'Divider', 'pgs-core' ),
		'description'  => esc_html__( 'Add Divider', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/divider.png',
		'element_icon' => 'ti-layout-line-solid',
		'params'       => $shortcode_fields,
	);

	return $params;
}
