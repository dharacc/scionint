<?php
return array(
	'title'            => esc_html__( 'Color Scheme', 'pgs-core' ),
	'id'               => 'color_scheme_section',
	'customizer_width' => '450px',
	'icon'             => 'el el-adjust-alt',
	'desc'             => esc_html__( 'In color schemes, you can change the site default color and set as per your site design.', 'pgs-core' ),
	'fields'           => array(
		array(
			'id'          => 'primary_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Primary Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Set main theme color and main background color.', 'pgs-core' ),
			'default'     => '#04d39f',
			'transparent' => false,
		),
		array(
			'id'          => 'secondary_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Secondary Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Set theme dark title and background.', 'pgs-core' ),
			'default'     => '#323232',
			'transparent' => false,
		),
		array(
			'id'          => 'tertiary_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Tertiary Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Set theme description color and border colors.', 'pgs-core' ),
			'default'     => '#777777',
			'transparent' => false,
		),
		array(
			'id'    => 'other_color_settings',
			'type'  => 'info',
			'style' => 'info',
			'title' => esc_html__( 'Other Color Settings', 'pgs-core' ),
			'desc'  => wp_kses(
				__(
					'Apart from these colors, there are some specific section, whose colors can be managed from there only<br><br>
						 <strong>Details are as below :</strong><br><strong>Header :</strong> For header color settings, go to Theme Options > Site Header.
						 <br><strong>Footer :</strong> For footer color settings, go to Theme Options > Footer.<br>
						 <strong>Revolution Slider :</strong> For color setting in Revolution Slider go to Slider Revolution.',
					'pgs-core'
				),
				array(
					'br'     => array(),
					'strong' => array(),
				)
			),
		),
	),
);
