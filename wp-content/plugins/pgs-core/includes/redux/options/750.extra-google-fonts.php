<?php
return array(
	'id'               => 'additional_google_fonts',
	'title'            => esc_html__( 'Additional Fonts', 'pgs-core' ),
	'heading'          => esc_html__( 'Additional Fonts', 'pgs-core' ),
	'customizer_width' => '400px',
	'subsection'       => true,
	'fields'           => array(
		array(
			'id'           => 'cs_google_fonts_repeater',
			'type'         => 'pgs_repeater',
			'title'        => esc_html__( 'Extra Google Fonts', 'pgs-core' ),
			'subtitle'     => esc_html__( 'Add Extra Google fonts', 'pgs-core' ),
			'group_values' => true, // Group all fields below within the repeater ID
			'sortable'     => true, // Allow the users to sort the repeater blocks or not
			'full_width'   => true,
			'fields'       => array(
				array(
					'id'             => 'cs_google_fonts',
					'type'           => 'typography',
					'title'          => esc_html__( 'Fonts Typography', 'pgs-core' ),
					'subtitle'       => esc_html__( 'Typography option with each property can be called individually.', 'pgs-core' ),
					'google'         => true,
					'font-backup'    => false,
					'font-size'      => false,
					'line-height'    => false,
					'letter-spacing' => false,
					'text-align'     => false,
					'units'          => 'px',
					'color'          => false,
					'fonts'          => pgscore_redux_typography_font_backup(),
				),
			),
		),
	),
);
