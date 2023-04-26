<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'pgscore_get_static_blocks' ) ) {
	return;
}

global $header_elements;

$header_elements['html_block'] = header_builder_element_html_block();

function header_builder_element_html_block() {
	$shortcode_fields = array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Static Block', 'pgs-core' ),
			'param_name'  => 'html_block_id',
			'description' => esc_html__( 'Select Static Block to display.', 'pgs-core' ),
			'options'     => pgscore_get_static_blocks(),
			'group'       => esc_html__( 'General', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'html_block_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'description'    => sprintf(
				wp_kses(
					__( '<strong>Static Block</strong>: Make sure You have added Static Block in Static Blocks section', 'pgs-core' ),
					array(
						'strong' => array(),
					)
				)
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
								'<strong>html_block_' . '</strong>'
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
		'id'           => 'html_block',
		'name'         => esc_html__( 'Static Block', 'pgs-core' ),
		'description'  => esc_html__( 'Select Static Block', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/html-block-icon.png',
		'element_icon' => 'ti-layout-slider',
		'params'       => $shortcode_fields,
	);

	return $params;

}
