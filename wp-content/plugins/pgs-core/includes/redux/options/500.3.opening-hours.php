<?php
return array(
	'title'            => esc_html__( 'Opening Hours', 'pgs-core' ),
	'id'               => 'opening_hours',
	'customizer_width' => '400px',
	'subsection'       => true,
	'fields'           => array(
		array(
			'id'       => 'mon_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Monday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Monday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'tue_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Tuesday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Tuesday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'wed_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Wednesday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Wednesday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'thu_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Thursday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Thursday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'fri_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Friday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Friday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'sat_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Saturday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Saturday.', 'pgs-core' ),
			'default'  => esc_html__( '9:00 - 21:00', 'pgs-core' ),
		),
		array(
			'id'       => 'sun_time',
			'type'     => 'text',
			'title'    => esc_html__( 'Sunday', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter timing for Sunday.', 'pgs-core' ),
			'default'  => esc_html__( 'Closed', 'pgs-core' ),
		),
	),
);
