<?php
return array(
	'id'               => 'site_info_section_social_profiles',
	'title'            => esc_html__( 'Social Profiles', 'pgs-core' ),
	'heading'          => esc_html__( 'Social Profiles', 'pgs-core' ),
	'customizer_width' => '400px',
	'subsection'       => true,
	'fields'           => array(
		array(
			'id'           => 'social_media_icons',
			'type'         => 'pgs_repeater',
			'title'        => esc_html__( 'Social Profiles', 'pgs-core' ),
			'subtitle'     => esc_html__( 'Social profiles is a repeater field which allow to add one profile per row. Click the "Add" button to add additional fields.', 'pgs-core' ),
			'group_values' => true, // Group all fields below within the repeater ID
			'sortable'     => true, // Allow the users to sort the repeater blocks or not
			'full_width'   => true,
			'fields'       => array(
				array(
					'id'          => 'social_media_type',
					'type'        => 'select',
					'title'       => esc_html__( 'Social Profile', 'pgs-core' ),
					'desc'        => esc_html__( 'Select social profile. If you want to add custom social profile, then select "Custom".', 'pgs-core' ),
					'options'     => array(
						'facebook'  => esc_html__( 'Facebook', 'pgs-core' ),
						'twitter'   => esc_html__( 'Twitter', 'pgs-core' ),
						'dribbble'  => esc_html__( 'Dribbble', 'pgs-core' ),
						'vimeo'     => esc_html__( 'Vimeo', 'pgs-core' ),
						'pinterest' => esc_html__( 'Pinterest', 'pgs-core' ),
						'linkedin'  => esc_html__( 'LinkedIn', 'pgs-core' ),
						'youtube'   => esc_html__( 'Youtube', 'pgs-core' ),
						'instagram' => esc_html__( 'Instagram', 'pgs-core' ),
						'behance'   => esc_html__( 'Behance', 'pgs-core' ),
						'custom'    => esc_html__( 'Custom', 'pgs-core' ),
					),
					'placeholder' => esc_html__( 'Listing Field', 'pgs-core' ),
				),
				array(
					'id'    => 'social_media_url',
					'type'  => 'text',
					'title' => esc_html__( 'Link (URL)', 'pgs-core' ),
				),
				array(
					'id'       => 'custom_social_title',
					'type'     => 'text',
					'title'    => esc_html__( 'Title', 'pgs-core' ),
					'desc'     => esc_html__( 'Insert your custom social title here', 'pgs-core' ),
					'required' => array( 'select_field', '=', array( 'custom' ) ),
				),
				array(
					'id'       => 'custom_soical_icon',
					'type'     => 'text',
					'title'    => esc_html__( 'Font Awesome Icon Class', 'pgs-core' ),
					'desc'     => sprintf(
						wp_kses(
							__( 'Insert <strong>Font Awesome</strong> class here i.e.<code>fa-link</code>. For list of <strong>Font Awesome</strong> classes click <a href="%s" target="_blank">here</a>.', 'pgs-core' ),
							array(
								'code'   => true,
								'strong' => true,
								'a'      => array(
									'href'   => true,
									'target' => true,
								),
							)
						),
						'https://fontawesome.com/v4.7.0/icons/#brand'
					),
					'required' => array( 'select_field', '=', array( 'custom' ) ),
				),
			),
		),
	),
);
