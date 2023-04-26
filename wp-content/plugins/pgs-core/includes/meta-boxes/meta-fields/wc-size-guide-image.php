<?php
$fields = apply_filters(
	'pgs_custom_meta_product_size_guide',
	array(
		'id'       => 'pgs_custom_meta_product_size_guide',
		'title'    => esc_html__( 'Size Guide Image', 'pgs-core' ),
		'screen'   => array( 'product' ),
		'priority' => 'high',
		'context'  => 'normal',
		'fields'   => array(
			array(
				'heading'       => esc_html__( 'Select Size Guides', 'pgs-core' ),
				'field_id'      => 'select_size_guides',
				'type'          => 'button_group',
				'options'       => array(
					'image' => esc_html__( 'Size Guide Image', 'pgs-core' ),
					'table' => esc_html__( 'Size Guide Table', 'pgs-core' ),
				),
				'default_value' => 'image',
			),
			array(
				'heading'           => esc_html__( 'Size Guide Image', 'pgs-core' ),
				'field_id'          => 'size_guide_image',
				'type'              => 'image',
				'instructions'      => esc_html__( 'This image will visible as size guide for product.', 'pgs-core' ),
				'conditional_logic' => array(
					array(
						'field'    => 'select_size_guides',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'Size Guide Table', 'pgs-core' ),
				'field_id'          => 'size_guide_tables',
				'type'              => 'post_object',
				'post_type'         => 'size_guides',
				'conditional_logic' => array(
					array(
						'field'    => 'select_size_guides',
						'operator' => '==',
						'value'    => 'table',
					),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );

