<?php
return array(
	'title'            => esc_html__( 'Performance', 'pgs-core' ),
	'id'               => 'performance_section',
	'customizer_width' => '400px',
	'icon'             => 'fa fa-line-chart',
	'fields'           => array(
		array(
			'id'      => 'enable_lazyload',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Lazyload (beta)?', 'pgs-core' ),
			'on'      => esc_html__( 'Yes', 'pgs-core' ),
			'off'     => esc_html__( 'No', 'pgs-core' ),
			'default' => '0',
			'desc'    => esc_html__( 'Enable this option to optimize your images and video loading on the website. They will be loaded only when user will scroll the page..', 'pgs-core' ),
		),
	),
);
