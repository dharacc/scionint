<?php
$fields = apply_filters(
	'pgs_custom_meta_product_video',
	array(
		'id'       => 'pgs_custom_meta_product_video',
		'title'    => esc_html__( 'Product Video', 'pgs-core' ),
		'screen'   => array( 'product' ),
		'priority' => 'high',
		'context'  => 'normal',
		'fields'   => array(
			array(
				'heading'       => esc_html__( 'Video Source', 'pgs-core' ),
				'field_id'      => 'product_video_source',
				'type'          => 'button_group',
				'options'       => array(
					'internal' => '<i class="fa fa-upload"></i> ' . esc_html__( 'Internal', 'pgs-core' ),
					'external' => '<i class="fa fa-external-link"></i> ' . esc_html__( 'External', 'pgs-core' ),
				),
				'layout'        => 'horizontal',
				'return_format' => 'value',
			),
			array(
				'heading'           => esc_html__( 'Video', 'pgs-core' ),
				'field_id'          => 'product_video_internal',
				'type'              => 'file',
				'conditional_logic' => array(
					array(
						'field'    => 'product_video_source',
						'operator' => '==',
						'value'    => 'internal',
					),
				),
				'file_types'        => 'mp4,ogv,webm',
			),
			array(
				'heading'           => esc_html__( 'Video', 'pgs-core' ),
				'field_id'          => 'product_video_external',
				'type'              => 'oembed',
				'instructions'      => esc_html__( 'Enter YouTube, Vimeo or Dailymotion video url.', 'pgs-core' ),
				'conditional_logic' => array(
					array(
						'field'    => 'product_video_source',
						'operator' => '==',
						'value'    => 'external',
					),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );
