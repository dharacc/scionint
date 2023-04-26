<?php
$fields = apply_filters(
	'page_sidebar_custom_meta_page_settings',
	array(
		'id'            => 'page_sidebar_custom_meta_page_settings',
		'title'         => esc_html__( 'Page Sidebar', 'pgs-core' ),
		'screen'        => array( 'page' ),
		'context'       => 'side',
		'page_template' => array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => 'default',
			),
		),
		'fields'        => array(
			array(
				'field_id' => 'page_sidebar',
				'type'     => 'select',
				'options'  => array(
					'default'       => esc_html__( 'Default', 'pgs-core' ),
					'left_sidebar'  => esc_html__( 'Left Sidebar', 'pgs-core' ),
					'right_sidebar' => esc_html__( 'Right Sidebar', 'pgs-core' ),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );
