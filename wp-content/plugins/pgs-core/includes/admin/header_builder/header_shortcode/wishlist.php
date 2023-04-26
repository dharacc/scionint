<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['wishlist'] = header_builder_element_wishlist();

function header_builder_element_wishlist() {

	$shortcode_fields = array(
		array(
			'type'       => 'radio_icon',
			'heading'    => esc_html__( 'Wishlist Icon', 'pgs-core' ),
			'param_name' => 'wishlist_icon',
			'options'    => array(
				'icon_1' => '<i class="fa fa-heart fa-2x" aria-hidden="true"></i>',
				'icon_2' => '<i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>',
				'icon_3' => '<i class="glyph-icon pgsicon-ecommerce-heart fa-2x" aria-hidden="true"></i>',
				'icon_4' => '<i class="glyph-icon pgsicon-ecommerce-shapes-1 fa-2x" aria-hidden="true"></i>',
				'icon_5' => '<i class="glyph-icon pgsicon-ecommerce-like fa-2x" aria-hidden="true"></i>',
			),
			'default'    => 'icon_1',
			'classes'    => 'radio_label_only',
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
									__( 'Important : ID will be starts  prefixed with "%s".', 'pgs-core' ),
									array(
										'atrong' => true,
									)
								),
								'<strong>wishlist_' . '</strong>'
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
		'id'           => 'wishlist',
		'name'         => esc_html__( 'Wishlist', 'pgs-core' ),
		'description'  => esc_html__( 'Wishlist Icon', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/wishlist-icon.png',
		'element_icon' => 'ti-list',
		'params'       => $shortcode_fields,
	);

	return $params;

}
