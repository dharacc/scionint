<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['button'] = header_builder_element_button();

function header_builder_element_button() {

	$shortcode_fields = array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'param_name'  => 'button_title',
			'description' => esc_html__( 'Enter the button title', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Link', 'pgs-core' ),
			'param_name'  => 'button_link',
			'description' => esc_html__( 'Enter the link for button', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Button Link', 'pgs-core' ),
			'param_name'  => 'button_new_tab',
			'options'     => esc_html__( 'Open In New Tab', 'pgs-core' ),
			'default'     => false,
			'description' => esc_html__( 'Open the link in new tab.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Title style ', 'pgs-core' ),
			'param_name'  => 'button_title_type',
			'options'     => array(
				'normal' => __( 'Normal', 'pgs-core' ),
				'bold'   => __( 'Bold', 'pgs-core' ),
			),
			'default'     => 'normal',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose the title style.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Button Type', 'pgs-core' ),
			'param_name'  => 'button_type',
			'options'     => array(
				'default' => __( 'Default', 'pgs-core' ),
				'border'  => __( 'Border', 'pgs-core' ),
				'link'    => __( 'link', 'pgs-core' ),
			),
			'default'     => 'default',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose the button type.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Color Scheme', 'pgs-core' ),
			'param_name'  => 'button_color_scheme',
			'options'     => array(
				'light' => __( 'Light', 'pgs-core' ),
				'dark'  => __( 'Dark', 'pgs-core' ),
				'theme' => __( 'Theme', 'pgs-core' ),
			),
			'default'     => 'light',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose the color scheme for button.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Button size', 'pgs-core' ),
			'param_name'  => 'button_size',
			'options'     => array(
				'default'     => __( 'Default', 'pgs-core' ),
				'extra_small' => __( 'Extra Small', 'pgs-core' ),
				'small'       => __( 'Small', 'pgs-core' ),
				'large'       => __( 'Large', 'pgs-core' ),
				'extra_large' => __( 'Extra Large', 'pgs-core' ),
			),
			'default'     => 'default',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose button size.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Button shape', 'pgs-core' ),
			'param_name'  => 'button_shape',
			'options'     => array(
				'square'  => __( 'square', 'pgs-core' ),
				'round'   => __( 'Round', 'pgs-core' ),
				'rounded' => __( 'Rounded', 'pgs-core' ),
			),
			'default'     => 'square',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose button Shape.', 'pgs-core' ),
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
								'<strong>button_' . '</strong>'
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
		'id'           => 'button',
		'name'         => esc_html__( 'Button', 'pgs-core' ),
		'description'  => esc_html__( 'Add Button', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/button-icon.png',
		'element_icon' => 'ti-layout-cta-center',
		'params'       => $shortcode_fields,
	);

	return $params;

}
