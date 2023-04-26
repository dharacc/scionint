<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) && ! class_exists( 'YITH_WCWL' ) ) {
	return array(
		'id'               => 'woocommerce_wishlist',
		'title'            => esc_html__( 'Wishlist', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'show_wishlist',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show Wishlist', 'pgs-core' ),
				'subtitle' => esc_html__( 'Show Wishlist', 'pgs-core' ),
				'on'       => esc_html__( 'Yes', 'pgs-core' ),
				'off'      => esc_html__( 'No', 'pgs-core' ),
				'default'  => true,
			),
			array(
				'id'       => 'cs_wishlist_page',
				'type'     => 'select',
				'title'    => esc_html__( 'Wishlist page', 'pgs-core' ),
				'desc'     => wp_kses(
					__( 'Pick a page as the main Wishlist page; make sure you add the <code>[ciyashop_wishlist]</code> shortcode into the page content', 'pgs-core' ),
					array(
						'code' => array(),
					)
				),
				'data'     => 'pages',
				'args'     => array(
					'exclude' => ( function_exists( 'pgscore_exclude_woo_pages' ) ) ? pgscore_exclude_woo_pages() : array(),
				),
				'required' => array( 'show_wishlist', '=', true ),
			),
			array(
				'id'       => 'wishlist_empty_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Wishlist Empty', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter text message for wishlist empty.', 'pgs-core' ),
				'default'  => esc_html__( 'No products added to the wishlist', 'pgs-core' ),
				'required' => array( 'show_wishlist', '=', true ),
			),
			array(
				'id'       => 'add_to_wishlist_text',
				'type'     => 'text',
				'title'    => esc_html__( '"Add to wishlist" text', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter a text for "Add to wishlist" button.', 'pgs-core' ),
				'default'  => esc_html__( 'Add to Wishlist', 'pgs-core' ),
				'required' => array( 'show_wishlist', '=', true ),
			),
			array(
				'id'       => 'product_added_text',
				'type'     => 'text',
				'title'    => esc_html__( '"Product added" text', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter the text of the message displayed when the user adds a product to the wishlist', 'pgs-core' ),
				'default'  => esc_html__( 'Product added!', 'pgs-core' ),
				'required' => array( 'show_wishlist', '=', true ),
			),
			array(
				'id'       => 'browse_wishlist_text',
				'type'     => 'text',
				'title'    => esc_html__( '"Browse wishlist" text', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter a text for the "Browse wishlist" link on the product page', 'pgs-core' ),
				'default'  => esc_html__( 'Browse Wishlist', 'pgs-core' ),
				'required' => array( 'show_wishlist', '=', true ),
			),
			array(
				'id'       => 'already_in_wishlist_text',
				'type'     => 'text',
				'title'    => esc_html__( '"Product already in wishlist" text', 'pgs-core' ),
				'desc'     => esc_html__( 'Enter the text for the message displayed when the user views a product that is already in the wishlist', 'pgs-core' ),
				'default'  => esc_html__( 'The product is already in the wishlist!', 'pgs-core' ),
				'required' => array( 'show_wishlist', '=', true ),
			),
		),
	);
}
