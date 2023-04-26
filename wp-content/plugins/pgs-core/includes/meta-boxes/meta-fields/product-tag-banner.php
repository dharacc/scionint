<?php
$fields = apply_filters(
	'pgs_custom_meta_tag_banner_image',
	array(
		'id'       => 'pgs_custom_meta_tag_banner_image',
		'title'    => esc_html__( 'Tag Banner Image', 'pgs-core' ),
		'screen'   => 'taxonomy',
		'taxonomy' => 'product_tag',
		'fields'   => array(
			array(
				'field_id'     => 'product_tag_banner_image',
				'heading'      => esc_html__( 'Banner Image', 'pgs-core' ),
				'type'         => 'image',
				'instructions' => esc_html__( 'This banner will be visible on the Product Tag archive page.', 'pgs-core' ),
			),
		),
	)
);

pgscf_add_field_group( $fields );
