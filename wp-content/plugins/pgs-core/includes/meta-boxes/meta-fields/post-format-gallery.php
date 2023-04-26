<?php
$fields = apply_filters(
	'pgs_custom_meta_post_format_gallery',
	array(
		'id'           => 'pgs_custom_meta_post_format_gallery',
		'title'        => esc_html__( 'Post Format - Gallery', 'pgs-core' ),
		'screen'       => 'post',
		'post_formate' => array(
			array(
				'param'    => 'post_formate',
				'operator' => '==',
				'value'    => 'gallery',
			),
		),
		'priority'     => 'high',
		'context'      => 'normal',
		'fields'       => array(
			array(
				'heading'       => esc_html__( 'Gallery Type', 'pgs-core' ),
				'field_id'      => 'gallery_type',
				'type'          => 'radio',
				'options'       => array(
					'slider' => esc_html__( 'Slider', 'pgs-core' ),
					'grid'   => esc_html__( 'Grid', 'pgs-core' ),
				),
				'instructions'  => esc_html__( 'For Grid View Add images in count 2 or 4.', 'pgs-core' ),
				'default_value' => 'slider',
				'layout'        => 'horizontal',
			),
			array(
				'heading'      => esc_html__( 'Gallery Images', 'pgs-core' ),
				'field_id'     => 'gallery_images',
				'type'         => 'repeater',
				'layout'       => 'horizontal',
				'button_label' => esc_html__( 'Add Image', 'pgs-core' ),
				'inner_fields' => array(
					array(
						'heading'  => esc_html__( 'Image', 'pgs-core' ),
						'field_id' => 'image',
						'type'     => 'image',
					),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );

