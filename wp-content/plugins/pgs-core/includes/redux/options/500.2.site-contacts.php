<?php
return array(
	'title'            => esc_html__( 'Site Contacts', 'pgs-core' ),
	'id'               => 'site_contacts',
	'customizer_width' => '400px',
	'subsection'       => true,
	'fields'           => array(
		array(
			'id'       => 'site_email',
			'type'     => 'text',
			'title'    => esc_html__( 'Email', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter email address.', 'pgs-core' ),
			'default'  => 'info@example.com',
			'validate' => 'email',
			'msg'      => esc_html__( 'Please enter valid email.', 'pgs-core' ),
		),
		array(
			'id'       => 'site_phone',
			'type'     => 'text',
			'title'    => esc_html__( 'Phone Number', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enter phone number.', 'pgs-core' ),
			'default'  => '(007) 123 456 7890',
		),
	),
);
