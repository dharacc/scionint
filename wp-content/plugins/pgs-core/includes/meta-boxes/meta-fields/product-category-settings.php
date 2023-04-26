<?php
$fields = apply_filters(
	'pgs_custom_meta_category_banner_image',
	array(
		'id'       => 'pgs_custom_meta_category_banner_image',
		'title'    => esc_html__( 'Category Banner Image', 'pgs-core' ),
		'screen'   => 'taxonomy',
		'taxonomy' => 'product_cat',
		'fields'   => array(
			array(
				'field_id'     => 'product_cat_banner_image',
				'heading'      => esc_html__( 'Banner Image', 'pgs-core' ),
				'type'         => 'image',
				'instructions' => esc_html__( 'This banner will be visible on the Product Category archive page.', 'pgs-core' ),
			),
			array(
				'field_id' => 'product_category_icon',
				'heading'  => esc_html__( 'Image (icon) for categories on the shop page header', 'pgs-core' ),
				'type'     => 'image',
			),
		),
	)
);

pgscf_add_field_group( $fields );
