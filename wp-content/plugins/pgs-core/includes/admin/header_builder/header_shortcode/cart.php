<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['cart'] = header_builder_element_cart();

function header_builder_element_cart() {

	$shortcode_fields = array(
		array(
			'type'       => 'radio_icon',
			'heading'    => esc_html__( 'Cart Icon', 'pgs-core' ),
			'param_name' => 'cart_icon',
			'options'    => array(
				'icon_1' => '<i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>',
				'icon_2' => '<i class="fa fa-shopping-basket fa-2x" aria-hidden="true"></i>',
				'icon_3' => '<i class="fa fa-shopping-bag fa-2x" aria-hidden="true"></i>',
				'icon_4' => '<i class="glyph-icon pgsicon-ecommerce-empty-shopping-cart fa-2x" aria-hidden="true"></i>',
				'icon_5' => '<i class="glyph-icon pgsicon-ecommerce-shopping-cart-1 fa-2x" aria-hidden="true"></i>',
				'icon_6' => '<i class="glyph-icon pgsicon-ecommerce-shopping-bag-4 fa-2x" aria-hidden="true"></i>',
				'icon_7' => '<i class="glyph-icon pgsicon-ecommerce-commerce-1 fa-2x" aria-hidden="true"></i>',
			),
			'default'    => 'icon_1',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_image',
			'heading'    => esc_html__( 'Cart Style', 'pgs-core' ),
			'param_name' => 'cart_style',
			'options'    => array(
				'cart_count'    => PGSCORE_URL . 'images/header-builder/fields/cart-2.jpg',
				'cart_subtotal' => PGSCORE_URL . 'images/header-builder/fields/cart-1.jpg',
				'cart_both'     => PGSCORE_URL . 'images/header-builder/fields/cart-3.jpg',
			),
			'default'    => 'cart_count',
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
									__( 'Important : ID will be starts prefixed with "%s".', 'pgs-core' ),
									array(
										'atrong' => true,
									)
								),
								'<strong>cart_' . '</strong>'
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
		'id'           => 'cart',
		'name'         => esc_html__( 'Cart', 'pgs-core' ),
		'description'  => esc_html__( 'Website Cart', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/cart-icon.png',
		'element_icon' => 'ti-shopping-cart',
		'params'       => $shortcode_fields,
	);

	return $params;
}
