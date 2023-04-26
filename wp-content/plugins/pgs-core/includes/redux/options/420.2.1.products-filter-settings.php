<?php
/* woocommerce plugin is activate then only WooCommerce setting will be appear.  */
if ( function_exists( 'WC' ) ) {

	$attribute_taxonomies = ciyashop_get_available_attr_array();
	return array(
		'id'               => 'products_filters',
		'title'            => esc_html__( 'Products Filters', 'pgs-core' ),
		'desc'             => esc_html__( 'Products Filters Settings.', 'pgs-core' ),
		'customizer_width' => '400px',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'      => 'show_product_filter',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Show Filter', 'pgs-core' ),
				'desc'    => esc_html__( 'Show product filter on shop page.', 'pgs-core' ),
				'options' => array(
					'yes' => esc_html__( 'Yes', 'pgs-core' ),
					'no'  => esc_html__( 'No', 'pgs-core' ),
				),
				'default' => 'yes',
			),
			array(
				'id'       => 'show_product_filter_area_open',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Shop filters always opened', 'pgs-core' ),
				'desc'     => esc_html__( 'Product filter area opened on shop page.', 'pgs-core' ),
				'options'  => array(
					'yes' => esc_html__( 'Yes', 'pgs-core' ),
					'no'  => esc_html__( 'No', 'pgs-core' ),
				),
				'default'  => 'yes',
				'required' => array( 'show_product_filter', '=', 'yes' ),
			),
			array(
				'id'       => 'product_filter_type',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Filter Type', 'pgs-core' ),
				'desc'     => esc_html__( 'Select product filter type on shop page.', 'pgs-core' ),
				'options'  => array(
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'widget'  => esc_html__( 'Widget', 'pgs-core' ),
				),
				'default'  => 'default',
				'required' => array( 'show_product_filter', '=', 'yes' ),
			),
			array(
				'id'       => 'product_filter_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Filter Title', 'pgs-core' ),
				'desc'     => esc_html__( 'Title for the product filter section.', 'pgs-core' ),
				'default'  => esc_html__( 'Product Filters', 'pgs-core' ),
				'required' => array(
					array( 'show_product_filter', 'equals', 'yes' ),
					array( 'product_filter_type', '!=', 'widget' ),
				),
			),
			array(
				'id'       => 'product_filters',
				'type'     => 'select',
				'title'    => esc_html__( 'Product Filters', 'pgs-core' ),
				'subtitle' => esc_html__( 'Select attributes to add into filter on the shop page.', 'pgs-core' ),
				'options'  => $attribute_taxonomies,
				'multi'    => true,
				'required' => array(
					array( 'show_product_filter', 'equals', 'yes' ),
					array( 'product_filter_type', '!=', 'widget' ),
				),
			),
		),
	);
}
