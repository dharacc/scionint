<?php
return array(
	'title'            => esc_html__( 'Page Settings', 'pgs-core' ),
	'id'               => 'page_settings',
	'customizer_width' => '450px',
	'icon'             => 'el el-cog',
	'fields'           => array(
		array(
			'id'       => 'page_sidebar',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Default Page Sidebar', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select page sidebar alignment.', 'pgs-core' ),
			'options'  => array(
				'full_width'    => array(
					'alt' => esc_html__( 'Full Width', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/full_width.png',
				),
				'left_sidebar'  => array(
					'alt' => esc_html__( 'Left Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/left_sidebar.png',
				),
				'right_sidebar' => array(
					'alt' => esc_html__( 'Right Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/right_sidebar.png',
				),
			),
			'default'  => 'right_sidebar',
		),
		array(
			'id'       => 'search_page_sidebar',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Search Page Sidebar', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select page sidebar alignment.', 'pgs-core' ),
			'options'  => array(
				'full_width'    => array(
					'alt' => esc_html__( 'Full Width', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/full_width.png',
				),
				'left_sidebar'  => array(
					'alt' => esc_html__( 'Left Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/left_sidebar.png',
				),
				'right_sidebar' => array(
					'alt' => esc_html__( 'Right Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/page_sidebar/right_sidebar.png',
				),
			),
			'default'  => 'right_sidebar',
		),
	),
);
