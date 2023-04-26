<?php
$fields = apply_filters(
	'pgs_custom_meta_wc_custom_tab',
	array(
		'id'       => 'pgs_custom_meta_wc_custom_tab',
		'title'    => esc_html__( 'Custom Tab', 'pgs-core' ),
		'screen'   => array( 'product' ),
		'priority' => 'high',
		'context'  => 'normal',
		'fields'   => array(
			array(
				'heading'       => esc_html__( 'Custom Tab Title', 'pgs-core' ),
				'field_id'      => 'custom_tab_title',
				'type'          => 'text',
				'default_value' => esc_html__( 'Custom Tab', 'pgs-core' ),
				'placeholder'   => esc_html__( 'Custom Tab', 'pgs-core' ),
			),
			array(
				'heading'  => esc_html__( 'Custom Tab Content', 'pgs-core' ),
				'field_id' => 'custom_tab_content',
				'type'     => 'editor',
			),
		),
	)
);

pgscf_add_field_group( $fields );
