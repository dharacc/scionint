<?php
return array(
	'title'            => esc_html__( 'Archive Settings', 'pgs-core' ),
	'id'               => 'archive_settings',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'      => 'archive_header',
			'type'    => 'checkbox',
			'title'   => esc_html__( 'Display Archive Header.', 'pgs-core' ),
			'desc'    => esc_html__( 'Select archive header to display on different archive pages.', 'pgs-core' ),
			'options' => array(
				'author'   => esc_html__( 'Author Info', 'pgs-core' ),
				'category' => esc_html__( 'Category Description', 'pgs-core' ),
				'tag'      => esc_html__( 'Tag Description', 'pgs-core' ),
			),
			'default' => array(
				'author'   => '0',
				'category' => '0',
				'tag'      => '0',
			),
		),
	),
);
