<?php
$fields = apply_filters(
	'pgs_custom_meta_team',
	array(
		'id'       => 'pgs_custom_meta_team',
		'title'    => esc_html__( 'Team Details', 'pgs-core' ),
		'screen'   => 'teams',
		'priority' => 'high',
		'context'  => 'advanced',
		'fields'   => array(
			array(
				'heading'   => esc_html__( 'General Details', 'pgs-core' ),
				'field_id'  => 'general_details_tab',
				'type'      => 'tab',
				'placement' => 'top',
			),
			array(
				'heading'  => esc_html__( 'Designation', 'pgs-core' ),
				'field_id' => 'designation',
				'type'     => 'text',
				'tab'      => 'general_details_tab',
			),
			array(
				'heading'   => esc_html__( 'Social Profiles', 'pgs-core' ),
				'field_id'  => 'social_details_tab',
				'type'      => 'tab',
				'placement' => 'top',
			),
			array(
				'heading'      => esc_html__( 'Social Profiles', 'pgs-core' ),
				'field_id'     => 'social_profiles',
				'tab'          => 'social_details_tab',
				'type'         => 'repeater',
				'layout'       => 'horizontal',
				'button_label' => esc_html__( 'Add Profile', 'pgs-core' ),
				'inner_fields' => array(
					array(
						'heading'  => esc_html__( 'Title', 'pgs-core' ),
						'field_id' => 'social_title',
						'type'     => 'text',
					),
					array(
						'heading'  => esc_html__( 'URL', 'pgs-core' ),
						'field_id' => 'social_url',
						'type'     => 'url',
					),
					array(
						'heading'        => esc_html__( 'Icon', 'pgs-core' ),
						'field_id'       => 'social_icon',
						'type'           => 'iconpicker',
						'icons_per_page' => 30,
						'icons'          => pgscore_fontawesome_array( true ),
					),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );
