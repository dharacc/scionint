<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {
	return array(
		'id'               => 'single_product_setting',
		'title'            => esc_html__( 'Single Product', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'product_page_style',
				'type'     => 'select',
				'title'    => esc_html__( 'Product Page Style', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select product page style.', 'pgs-core' ),
				'options'  => array(
					'classic'        => esc_html__( 'Classic', 'pgs-core' ),
					'sticky_gallery' => esc_html__( 'Sticky Gallery', 'pgs-core' ),
					'wide_gallery'   => esc_html__( 'Wide Gallery', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => false,
				),
				'default'  => 'classic',
			),
			array(
				'id'       => 'product_page_thumbnail_position',
				'type'     => 'select',
				'title'    => esc_html__( 'Thumbnail Position', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select thumbnail position.', 'pgs-core' ),
				'options'  => array(
					'bottom' => esc_html__( 'Bottom', 'pgs-core' ),
					'left'   => esc_html__( 'Left', 'pgs-core' ),
					'right'  => esc_html__( 'Right', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => false,
				),
				'default'  => 'bottom',
				'required' => array( 'product_page_style', '=', array( 'classic', 'sticky_gallery' ) ),
			),
			array(
				'id'       => 'product-page-sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Sidebar', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select sidebar layout', 'pgs-core' ),
				'options'  => array(
					'left'  => esc_html__( 'Left Sidebar', 'pgs-core' ),
					'right' => esc_html__( 'Right Sidebar', 'pgs-core' ),
					'no'    => esc_html__( 'No Sidebar', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => false,
				),
				'default'  => 'right',
			),
			array(
				'id'       => 'product-page-width',
				'type'     => 'select',
				'title'    => esc_html__( 'Page Width', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select page width', 'pgs-core' ),
				'options'  => array(
					'fixed' => esc_html__( 'Fixed', 'pgs-core' ),
					'wide'  => esc_html__( 'Wide', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => false,
				),
				'default'  => 'fixed',
			),
			array(
				'id'       => 'product-tab-layout',
				'type'     => 'select',
				'title'    => esc_html__( 'Tab Layout', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select product tab layout.', 'pgs-core' ),
				'options'  => array(
					'default'        => esc_html__( 'Default', 'pgs-core' ),
					'default_center' => esc_html__( 'Default (Center Aligned)', 'pgs-core' ),
					'left'           => esc_html__( 'Left', 'pgs-core' ),
					'accordion'      => esc_html__( 'Accordion', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => false,
				),
				'default'  => 'default',
			),
			array(
				'id'       => 'product_countdown',
				'type'     => 'switch',
				'title'    => esc_html__( 'Countdown Timer', 'pgs-core' ),
				'subtitle' => esc_html__( 'Show timer if product is scheduled for the sale on a specific date', 'pgs-core' ),
				'default'  => false,
			),
			array(
				'id'       => 'product_countdown_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Countdown Title', 'pgs-core' ),
				'default'  => esc_html__( 'Limited time offer', 'pgs-core' ),
				'required' => array(
					array( 'product_countdown', '=', true ),
				),
			),
			array(
				'id'      => 'product_sticky_content',
				'type'    => 'switch',
				'title'   => esc_html__( 'Sticky Title', 'pgs-core' ),
				'default' => false,
			),
			array(
				'id'       => 'single_sticky_add_to_cart',
				'type'     => 'switch',
				'title'    => esc_html__( 'Sticky Add to Cart', 'pgs-core' ),
				'subtitle' => esc_html__( 'Sticky Add to Cart not display in Mobile device.', 'pgs-core' ),
				'default'  => false,
			),
			array(
				'id'       => 'wishlist_sticky_add_to_cart',
				'type'     => 'switch',
				'title'    => esc_html__( 'Wishlist in Sticky Add to Cart', 'pgs-core' ),
				'default'  => false,
				'required' => array(
					array( 'single_sticky_add_to_cart', '=', true ),
				),
			),
			array(
				'id'       => 'compare_sticky_add_to_cart',
				'type'     => 'switch',
				'title'    => esc_html__( 'Compare in Sticky Add to Cart', 'pgs-core' ),
				'default'  => false,
				'required' => array(
					array( 'single_sticky_add_to_cart', '=', true ),
				),
			),
			array(
				'id'       => 'product_rating_sticky_add_to_cart',
				'type'     => 'switch',
				'title'    => esc_html__( 'Product Rating in Sticky Add to Cart', 'pgs-core' ),
				'default'  => false,
				'required' => array(
					array( 'single_sticky_add_to_cart', '=', true ),
				),
			),
			array(
				'id'       => 'sticky_add_to_cart_product_countdown',
				'type'     => 'switch',
				'title'    => esc_html__( 'Countdown Timer For Sticky Add to cart', 'pgs-core' ),
				'subtitle' => esc_html__( 'Show timer if product is scheduled for the sale on a specific date in Sticky Add to Cart', 'pgs-core' ),
				'default'  => false,
				'required' => array(
					array( 'single_sticky_add_to_cart', '=', true ),
				),
			),
			array(
				'id'      => 'smart-product',
				'type'    => 'switch',
				'title'   => esc_html__( 'Smart Product View', 'pgs-core' ),
				'default' => false,
				'on'      => esc_html__( 'Yes', 'pgs-core' ),
				'off'     => esc_html__( 'No', 'pgs-core' ),
			),
			array(
				'id'      => 'product-navigation',
				'type'    => 'switch',
				'title'   => esc_html__( 'Next/Previous Product Navigation', 'pgs-core' ),
				'default' => true,
				'on'      => esc_html__( 'Yes', 'pgs-core' ),
				'off'     => esc_html__( 'No', 'pgs-core' ),
			),
			array(
				'id'      => 'product-share-buttons',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Share Buttons', 'pgs-core' ),
				'default' => true,
				'on'      => esc_html__( 'Yes', 'pgs-core' ),
				'off'     => esc_html__( 'No', 'pgs-core' ),
			),
			array(
				'id'      => 'product-short-description',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Short Description', 'pgs-core' ),
				'default' => true,
				'on'      => esc_html__( 'Yes', 'pgs-core' ),
				'off'     => esc_html__( 'No', 'pgs-core' ),
			),

			/**********************************************************************************************/
			array(
				'id'     => 'single_product_header_section-start',
				'type'   => 'section',
				'title'  => esc_html__( 'Header Settings', 'pgs-core' ),
				'indent' => true,
			),
			array(
				'id'       => 'show_header_on_product_single_page',
				'type'     => 'switch',
				'title'    => esc_html__( 'Header On Single Product Page', 'pgs-core' ),
				'subtitle' => esc_html__( 'Header On Single Product Page', 'pgs-core' ),
				'on'       => esc_html__( 'Show', 'pgs-core' ),
				'off'      => esc_html__( 'Hide', 'pgs-core' ),
				'default'  => true,
			),
			/**********************************************************************************************/
			array(
				'id'     => 'related_products_section-start',
				'type'   => 'section',
				'title'  => esc_html__( 'Related Products', 'pgs-core' ),
				'indent' => true,
			),
			array(
				'id'       => 'show_related_products',
				'type'     => 'switch',
				'url'      => true,
				'title'    => esc_html__( 'Show Related Products', 'pgs-core' ),
				'compiler' => 'true',
				'subtitle' => esc_html__( 'Show related products on the product page.', 'pgs-core' ),
				'default'  => '1', // 1= on | 0= off
			),
			array(
				'id'            => 'related_products_per_page',
				'type'          => 'slider',
				'url'           => true,
				'title'         => esc_html__( 'Number of Related Products per Page', 'pgs-core' ),
				'compiler'      => 'true',
				'subtitle'      => esc_html__( 'Select the number of related products to display.', 'pgs-core' ),
				'default'       => 6,
				'min'           => 3,
				'step'          => 1,
				'max'           => 12,
				'display_value' => 'text',
				'required'      => array( 'show_related_products', '=', true ),
			),
			array(
				'id'     => 'related_products_section-end',
				'type'   => 'section',
				'indent' => false,
			),

			/**********************************************************************************************/
			array(
				'id'     => 'up_sells_section-start',
				'type'   => 'section',
				'title'  => esc_html__( 'Up Sells', 'pgs-core' ),
				'indent' => true,
			),
			array(
				'id'       => 'show_up_sells',
				'type'     => 'switch',
				'url'      => true,
				'title'    => esc_html__( 'Show UP Sells', 'pgs-core' ),
				'compiler' => 'true',
				'subtitle' => esc_html__( 'Show UP Sells products.', 'pgs-core' ),
				'default'  => '1', // 1= on | 0= off
			),
			array(
				'id'            => 'up_sells_products_per_page',
				'type'          => 'slider',
				'url'           => true,
				'title'         => esc_html__( 'Number of UP Sells Products per Page', 'pgs-core' ),
				'compiler'      => 'true',
				'subtitle'      => esc_html__( 'Select the number of UP Sells products to display.', 'pgs-core' ),
				'default'       => 6,
				'min'           => 3,
				'step'          => 1,
				'max'           => 12,
				'display_value' => 'text',
				'required'      => array( 'show_up_sells', '=', true ),
			),
			array(
				'id'     => 'up_sells_section-end',
				'type'   => 'section',
				'indent' => false,
			),
			/**********************************************************************************************/
		),
	);
}
