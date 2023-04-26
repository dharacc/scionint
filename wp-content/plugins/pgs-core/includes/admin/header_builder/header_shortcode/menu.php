<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['menu'] = header_builder_element_menu();

function header_builder_element_menu() {
	$menu_list = array();
	$menus     = wp_get_nav_menus();

	$menu_list[''] = esc_html__( 'Select Menu', 'pgs-core' );

	foreach ( $menus as $menu ) {
		$menu_list[ $menu->slug ] = $menu->name;
	}

	$shortcode_fields = array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Choose Menu', 'pgs-core' ),
			'param_name'  => 'menu',
			'options'     => $menu_list,
			'description' => esc_html__( 'Choose which menu to display in the header.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Menu Type', 'pgs-core' ),
			'param_name'  => 'menu_type',
			'options'     => array(
				'inline'   => __( 'Inline', 'pgs-core' ),
				'dropdown' => __( 'Dropdown', 'pgs-core' ),
				'flat'     => __( 'Flat', 'pgs-core' ),
			),
			'default'     => 'inline',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose menu type display in the header.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide For Tablet View', 'pgs-core' ),
			'param_name' => 'hide_for_tablet',
			'group'      => esc_html__( 'General', 'pgs-core' ),
			'options'    => esc_html__( 'Hide For Tablet', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'dropdown' ),
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Color', 'pgs-core' ),
			'param_name' => 'menu_bg_color',
			'group'      => esc_html__( 'General', 'pgs-core' ),
			'dependency' => array(
				'element' => 'menu_type',
				'value'   => array( 'dropdown' ),
			),
		),
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
			'group'      => esc_html__( 'Design', 'pgs-core' ),
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
								'<strong>menu_' . '</strong>'
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
		'id'           => 'menu',
		'name'         => esc_html__( 'Menu', 'pgs-core' ),
		'description'  => esc_html__( 'Menu List', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'device'       => 'desktop',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/menu-icon.png',
		'element_icon' => 'ti-menu',
		'params'       => $shortcode_fields,
	);

	return $params;

}
