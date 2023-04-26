<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['logo'] = header_builder_element_logo();

function header_builder_element_logo() {

	$shortcode_fields = array(
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'logo_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'display_header' => true,
			'description'    => sprintf(
				wp_kses(
					__( 'You can manage the logo related settings in <a href="%s" target="_blank">Theme Options</a>', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				admin_url( 'themes.php?page=ciyashop-options&tab=2' )
			),
			'group'          => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'ID', 'pgs-core' ),
			'param_name'  => 'element_id',
			'description' => sprintf(
				wp_kses(
					__( 'Enter ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>)', 'ciyashops' ),
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
								'<strong>logo_' . '</strong>'
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
		'id'           => 'logo',
		'name'         => esc_html__( 'Logo', 'pgs-core' ),
		'description'  => esc_html__( 'Website logo', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/logo-icon.png',
		'element_icon' => 'ti-palette',
		'params'       => $shortcode_fields,
	);

	return $params;

}
