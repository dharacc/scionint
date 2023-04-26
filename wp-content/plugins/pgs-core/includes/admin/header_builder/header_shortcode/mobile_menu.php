<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['mobile_menu'] = header_builder_element_mobile_menu();

function header_builder_element_mobile_menu() {
	$shortcode_fields = array(
		array(
			'type'       => 'color_settings',
			'heading'    => esc_html__( 'Color Settings', 'pgs-core' ),
			'param_name' => 'menu_colors',
			'text_color' => false,
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'pgs-core' ),
			'param_name' => 'menu_bg_color',
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
								'<strong>mobile_menu_' . '</strong>'
							)
							. '</span>',
			'settings'    => array(),
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
		'id'           => 'mobile_menu',
		'name'         => esc_html__( 'Mobile Menu', 'pgs-core' ),
		'description'  => esc_html__( 'Display mobile menu', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'device'       => 'mobile',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/menu-icon.png',
		'element_icon' => 'ti-menu',
		'params'       => $shortcode_fields,
	);

	return $params;

}
