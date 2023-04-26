<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_configure_opt;

$header_configure_opt = header_builder_configuration();

function header_builder_configuration() {
	$configuration_fields = array(
		array(
			'type'       => 'radio',
			'heading'    => esc_html__( 'Row layout', 'pgs-core' ),
			'param_name' => 'row_layout',
			'options'    => array(
				'row_flex'   => esc_html__( '3 Column Fixed Width', 'pgs-core' ),
				'row_center' => esc_html__( '3 Column Liquid Width', 'pgs-core' ),
			),
			'default'    => 'row_flex',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Row height on desktop', 'pgs-core' ),
			'param_name'  => 'row_height_desktop',
			'label'       => esc_html__( 'Row Height', 'pgs-core' ),
			'min'         => 0,
			'max'         => 200,
			'default'     => 50,
			'unit'        => 'px',
			'description' => esc_html__( 'Determine the header height on desktop view value in pixels.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Row height on mobile', 'pgs-core' ),
			'param_name'  => 'row_height_mobile',
			'label'       => esc_html__( 'Row Height', 'pgs-core' ),
			'min'         => 0,
			'max'         => 200,
			'default'     => 50,
			'unit'        => 'px',
			'description' => esc_html__( 'Determine the header height on mobile view value in pixels.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox_multi',
			'heading'     => esc_html__( 'On desktop', 'pgs-core' ),
			'param_name'  => 'on_desktop',
			'options'     => array(
				'desktop_hide'   => array(
					'heading' => esc_html__( 'Hide on desktop', 'pgs-core' ),
					'default' => false,
				),
				'desktop_sticky' => array(
					'heading' => esc_html__( 'Sticky on desktop', 'pgs-core' ),
					'default' => false,
				),
			),
			'description' => esc_html__( 'This row settings for desktop devices.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox_multi',
			'heading'     => esc_html__( 'On mobile', 'pgs-core' ),
			'param_name'  => 'on_mobile',
			'options'     => array(
				'mobile_hide'   => array(
					'heading' => esc_html__( 'Hide on mobile', 'pgs-core' ),
					'default' => false,
				),
				'mobile_sticky' => array(
					'heading' => esc_html__( 'Sticky on mobile', 'pgs-core' ),
					'default' => false,
				),
			),
			'description' => esc_html__( 'This row settings for mobile devices.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'color_settings',
			'heading'    => esc_html__( 'Color Settings', 'pgs-core' ),
			'param_name' => 'header_color',
			'group'      => esc_html__( 'Design', 'pgs-core' ),
		),
		array(
			'type'       => 'background_settings',
			'heading'    => esc_html__( 'Background Settings', 'pgs-core' ),
			'param_name' => 'bg_settings',
			'group'      => esc_html__( 'Design', 'pgs-core' ),
		),
		array(
			'type'       => 'border_settings',
			'heading'    => esc_html__( 'Bottom Border Settings', 'pgs-core' ),
			'param_name' => 'border_bottom',
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
								'<strong>topbar_' . '</strong>'
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

	return $configuration_fields;
}
