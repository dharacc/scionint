<?php
return array(
	'title'            => esc_html__( 'Layout Settings', 'pgs-core' ),
	'id'               => 'layout_settings',
	'desc'             => esc_html__( 'Specify theme pages layout, color and background.', 'pgs-core' ),
	'customizer_width' => '400px',
	'icon'             => 'el el-website icon-large',
	'fields'           => array(
		array(
			'id'      => 'site_layout',
			'type'    => 'radio',
			'title'   => esc_html__( 'Site Layout', 'pgs-core' ),
			'desc'    => esc_html__( 'Select layout of site.', 'pgs-core' ),
			'options' => array(
				'fullwidth' => esc_html__( 'Full Width', 'pgs-core' ),
				'boxed'     => esc_html__( 'Boxed', 'pgs-core' ),
				'framed'    => esc_html__( 'Framed', 'pgs-core' ),
				'rounded'   => esc_html__( 'Rounded', 'pgs-core' ),
			),
			'default' => 'fullwidth',
		),
		array(
			'id'            => 'body_background',
			'type'          => 'background',
			'title'         => esc_html__( 'Background', 'pgs-core' ),
			'desc'          => esc_html__( 'Set site background. This is applicable for fixed width layouts ("Boxed", "Framed" and "Rounded" ) only.', 'pgs-core' ),
			'preview_media' => true,
			'transparent'   => false,
			'default'       => array(
				'background-image' => '',
			),
			'required'      => array(
				array( 'site_layout', '!=', 'fullwidth' ),
			),
		),
		array(
			'id'      => 'dark_layout',
			'type'    => 'switch',
			'title'   => esc_html__( 'Dark Theme Version', 'pgs-core' ),
			'desc'    => esc_html__( 'Select this option for dark version of the theme.', 'pgs-core' ),
			'default' => false,
		),
	),
);
