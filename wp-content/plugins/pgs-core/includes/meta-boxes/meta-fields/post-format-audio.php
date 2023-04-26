<?php
$fields = apply_filters(
	'pgs_custom_meta_post_format_audio',
	array(
		'id'           => 'pgs_custom_meta_post_format_audio',
		'title'        => esc_html__( 'Post Format - Audio', 'pgs-core' ),
		'screen'       => array( 'post' ),
		'priority'     => 'high',
		'context'      => 'normal',
		'post_formate' => array(
			array(
				'param'    => 'post_formate',
				'operator' => '==',
				'value'    => 'audio',
			),
		),
		'fields'       => array(
			array(
				'heading'    => esc_html__( 'Audio File', 'pgs-core' ),
				'field_id'   => 'audio_file',
				'type'       => 'file',
				'file_types' => 'audio',
			),
		),
	)
);

pgscf_add_field_group( $fields );
