<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['account'] = header_builder_element_account();

function header_builder_element_account() {
	$shortcode_fields = array(
		array(
			'type'       => 'radio_icon',
			'heading'    => esc_html__( 'Icon', 'pgs-core' ),
			'param_name' => 'account_icon',
			'options'    => array(
				'icon_1' => '<i class="fa fa-user" aria-hidden="true"></i>',
				'icon_2' => '<i class="glyph-icon pgsicon-ecommerce-user" aria-hidden="true"></i>',
				'icon_3' => '<i class="glyph-icon pgsicon-ecommerce-user-1" aria-hidden="true"></i>',
				'icon_4' => '<i class="glyph-icon pgsicon-ecommerce-user-2" aria-hidden="true"></i>',
				'icon_5' => '<i class="fa fa-sign-in"></i>',
			),
			'default'    => 'icon_1',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text', 'pgs-core' ),
			'param_name'  => 'account_text',
			'description' => esc_html__( 'Add the text to display.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Sign in Or Register', 'pgs-core' ),
			'param_name'  => 'show_register_form',
			'options'     => esc_html__( 'Show form', 'pgs-core' ),
			'default'     => false,
			'description' => esc_html__( 'Show Sign in Or Register form.', 'pgs-core' ),
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
								'<strong>account_' . '</strong>'
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
		'id'           => 'account',
		'name'         => esc_html__( 'Account', 'pgs-core' ),
		'description'  => esc_html__( 'Login/Register Settings.', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/account-icon.png',
		'element_icon' => 'ti-user',
		'params'       => $shortcode_fields,
	);

	return $params;

}
