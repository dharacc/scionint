<?php
$fields = apply_filters(
	'pgs_custom_meta_post_format_quote',
	array(
		'id'           => 'pgs_custom_meta_post_format_quote',
		'title'        => esc_html__( 'Post Format - Quote', 'pgs-core' ),
		'screen'       => array( 'post' ),
		'priority'     => 'high',
		'context'      => 'normal',
		'post_formate' => array(
			array(
				'param'    => 'post_formate',
				'operator' => '==',
				'value'    => 'quote',
			),
		),
		'fields'       => array(
			array(
				'heading'  => esc_html__( 'Quote', 'pgs-core' ),
				'field_id' => 'quote',
				'type'     => 'textarea',
			),
			array(
				'heading'  => esc_html__( 'Quote Author', 'pgs-core' ),
				'field_id' => 'quote_author',
				'type'     => 'text',
			),
			array(
				'heading'      => esc_html__( 'Author Link', 'pgs-core' ),
				'field_id'     => 'author_link',
				'type'         => 'url',
				'instructions' => esc_html__( 'Enter author URL if available.', 'pgs-core' ),
			),
		),
	)
);

pgscf_add_field_group( $fields );
