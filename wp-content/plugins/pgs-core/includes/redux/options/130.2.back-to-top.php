<?php
return array(
	'title'            => esc_html__( 'Back to Top', 'pgs-core' ),
	'id'               => 'main_back_to_top',
	'customizer_width' => '400px',
	'icon'             => 'el el-circle-arrow-up',
	'fields'           => array(
		array(
			'id'       => 'back_to_top',
			'type'     => 'switch',
			'title'    => esc_html__( 'Back to Top', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enable/disable back to top button.', 'pgs-core' ),
			'default'  => true,
		),
		array(
			'id'       => 'back_to_top_mobile',
			'type'     => 'switch',
			'title'    => esc_html__( 'Back to Top For Mobile', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enable/disable back to top button for mobile device.', 'pgs-core' ),
			'default'  => true,
		),
	),
);
