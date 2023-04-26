<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['primary_menu'] = header_builder_element_primary_menu();

function header_builder_element_primary_menu() {
	$shortcode_fields = array(
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Menu Alignment', 'pgs-core' ),
			'param_name'  => 'menu_alignment',
			'options'     => array(
				'left'   => __( 'Left', 'pgs-core' ),
				'center' => __( 'Center', 'pgs-core' ),
				'right'  => __( 'Right', 'pgs-core' ),
			),
			'dependency'  => array(
				'element' => 'menu_type',
				'value'   => array( 'inline', 'flat' ),
			),
			'default'     => 'left',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose which menu to display in the header.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'color_settings',
			'heading'    => esc_html__( 'Color Settings', 'pgs-core' ),
			'param_name' => 'menu_colors',
			'text_color' => false,
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
								'<strong>primary_menu_' . '</strong>'
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
		'id'           => 'primary_menu',
		'name'         => esc_html__( 'Primary Menu', 'pgs-core' ),
		'description'  => esc_html__( 'Display primary menu', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'device'       => 'desktop',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/menu-icon.png',
		'element_icon' => 'ti-menu',
		'params'       => $shortcode_fields,
	);

	return $params;

}
