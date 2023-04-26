<?php
$fields = apply_filters(
	'pgs_custom_meta_post_format_video',
	array(
		'id'           => 'pgs_custom_meta_post_format_video',
		'title'        => esc_html__( 'Post Format - Video', 'pgs-core' ),
		'screen'       => array( 'post' ),
		'priority'     => 'high',
		'context'      => 'normal',
		'post_formate' => array(
			array(
				'param'    => 'post_formate',
				'operator' => '==',
				'value'    => 'video',
			),
		),
		'fields'       => array(
			array(
				'heading'       => esc_html__( 'Video Type', 'pgs-core' ),
				'field_id'      => 'video_type',
				'type'          => 'radio',
				'options'       => array(
					'html5'   => esc_html__( 'HTML5', 'pgs-core' ),
					'youtube' => esc_html__( 'YouTube', 'pgs-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'pgs-core' ),
				),
				'default_value' => 'youtube',
				'layout'        => 'horizontal',
			),
			array(
				'heading'           => esc_html__( 'YouTube Video', 'pgs-core' ),
				'field_id'          => 'post_format_video_youtube',
				'type'              => 'oembed',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'youtube',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'Vimeo Video', 'pgs-core' ),
				'field_id'          => 'post_format_video_vimeo',
				'type'              => 'oembed',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'vimeo',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'MP4', 'pgs-core' ),
				'field_id'          => 'post_format_video_html5_0_mp4',
				'type'              => 'file',
				'file_types'        => 'video/mp4',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'html5',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'WebM', 'pgs-core' ),
				'field_id'          => 'post_format_video_html5_0_webm',
				'type'              => 'file',
				'file_types'        => 'video/webm',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'html5',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'OGV', 'pgs-core' ),
				'field_id'          => 'post_format_video_html5_0_ogv',
				'type'              => 'file',
				'file_types'        => 'video/ogg',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'html5',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'Cover', 'pgs-core' ),
				'field_id'          => 'post_format_video_html5_0_cover',
				'type'              => 'image',
				'conditional_logic' => array(
					array(
						'field'    => 'video_type',
						'operator' => '==',
						'value'    => 'html5',
					),
				),
			),
			
		),
	)
);

pgscf_add_field_group( $fields );
