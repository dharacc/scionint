<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['space'] = header_builder_element_space();

function header_builder_element_space() {

	$shortcode_fields = array(
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Space width', 'pgs-core' ),
			'param_name' => 'space_width',
			'label'      => esc_html__( 'Space Width', 'pgs-core' ),
			'min'        => 1,
			'max'        => 150,
			'default'    => 10,
			'unit'       => 'px',
			'group'      => esc_html__( 'General', 'pgs-core' ),
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
								'<strong>space_' . '</strong>'
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
		'id'           => 'space',
		'name'         => esc_html__( 'Space', 'pgs-core' ),
		'description'  => esc_html__( 'Set Horizontal Space', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/space-icon.png',
		'element_icon' => 'ti-arrows-horizontal',
		'params'       => $shortcode_fields,
	);

	return $params;

}
