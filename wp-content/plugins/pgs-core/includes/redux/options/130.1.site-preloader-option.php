<?php
return array(
	'title'            => esc_html__( 'Site Preloader Option', 'pgs-core' ),
	'id'               => 'main_preloader_option',
	'customizer_width' => '400px',
	'icon'             => 'fa fa-spinner',
	'fields'           => array(
		array(
			'id'       => 'preloader',
			'type'     => 'switch',
			'title'    => esc_html__( 'Preloader', 'pgs-core' ),
			'subtitle' => esc_html__( 'Enable/disable preloader animation.', 'pgs-core' ),
			'default'  => true,
		),
		array(
			'id'          => 'preloader_background_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Preloader Background Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Set preloader background color.', 'pgs-core' ),
			'default'     => '#ffffff',
			'transparent' => false,
			'required'    => array( 'preloader', '=', 1 ),
		),
		array(
			'id'       => 'preloader_source',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Preloader Source', 'pgs-core' ),
			'subtitle' => esc_html__( 'Set preloader type as per your need.', 'pgs-core' ),
			'options'  => array(
				'default'          => esc_html__( 'Default', 'pgs-core' ),
				'predefine_loader' => esc_html__( 'Predefined Loader', 'pgs-core' ),
				'custom'           => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'  => 'default',
			'required' => array( 'preloader', '=', 1 ),
		),
		array(
			'id'       => 'predefine_loader_image_info',
			'type'     => 'info',
			'style'    => 'info',
			'desc'     => esc_html__( 'The .svg file for the "Preloader Image" will not work in "Internet Explorer".', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'preloader', '=', 1 ),
				array( 'preloader_source', '!=', 'default' ),
			),
		),
		array(
			'id'       => 'predefine_loader_image',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Preloader Image', 'pgs-core' ),
			'subtitle' => esc_html__( 'Please select site preloader image.', 'pgs-core' ),
			'options'  => array(
				'default'  => array(
					'alt' => esc_html__( 'Loader 1', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/default.gif',
				),
				'loader1'  => array(
					'alt' => esc_html__( 'Loader 1', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader1.gif',
				),
				'loader2'  => array(
					'alt' => esc_html__( 'Loader 2', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader2.gif',
				),
				'loader3'  => array(
					'alt' => esc_html__( 'Loader 3', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader3.gif',
				),
				'loader4'  => array(
					'alt' => esc_html__( 'Loader 4', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader4.gif',
				),
				'loader5'  => array(
					'alt' => esc_html__( 'Loader 5', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader5.gif',
				),
				'loader6'  => array(
					'alt' => esc_html__( 'Loader 6', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader6.gif',
				),
				'loader7'  => array(
					'alt' => esc_html__( 'Loader 7', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader7.gif',
				),
				'loader8'  => array(
					'alt' => esc_html__( 'Loader 8', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader8.gif',
				),
				'loader9'  => array(
					'alt' => esc_html__( 'Loader 9', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader9.gif',
				),
				'loader10' => array(
					'alt' => esc_html__( 'Loader 10', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader10.gif',
				),
				'loader11' => array(
					'alt' => esc_html__( 'Loader 11', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader11.gif',
				),
				'loader12' => array(
					'alt' => esc_html__( 'Loader 12', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader12.gif',
				),
				'loader13' => array(
					'alt' => esc_html__( 'Loader 13', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader13.gif',
				),
				'loader14' => array(
					'alt' => esc_html__( 'Loader 14', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader14.gif',
				),
				'loader15' => array(
					'alt' => esc_html__( 'Loader 15', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader15.gif',
				),
				'loader16' => array(
					'alt' => esc_html__( 'Loader 16', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader16.gif',
				),
				'loader17' => array(
					'alt' => esc_html__( 'Loader 17', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader17.svg',
				),
				'loader18' => array(
					'alt' => esc_html__( 'Loader 18', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader18.svg',
				),
				'loader19' => array(
					'alt' => esc_html__( 'Loader 19', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader19.svg',
				),
				'loader20' => array(
					'alt' => esc_html__( 'Loader 20', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader20.svg',
				),
				'loader21' => array(
					'alt' => esc_html__( 'Loader 21', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader21.svg',
				),
				'loader22' => array(
					'alt' => esc_html__( 'Loader 22', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader22.svg',
				),
				'loader23' => array(
					'alt' => esc_html__( 'Loader 23', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader23.svg',
				),
				'loader24' => array(
					'alt' => esc_html__( 'Loader 24', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader24.svg',
				),
				'loader25' => array(
					'alt' => esc_html__( 'Loader 25', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader25.svg',
				),
				'loader26' => array(
					'alt' => esc_html__( 'Loader 26', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader26.gif',
				),
				'loader27' => array(
					'alt' => esc_html__( 'Loader 27', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader27.gif',
				),
				'loader28' => array(
					'alt' => esc_html__( 'Loader 28', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader28.gif',
				),
				'loader29' => array(
					'alt' => esc_html__( 'Loader 29', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader29.svg',
				),
				'loader30' => array(
					'alt' => esc_html__( 'Loader 30', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader30.svg',
				),
				'loader31' => array(
					'alt' => esc_html__( 'Loader 31', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader31.svg',
				),
				'loader32' => array(
					'alt' => esc_html__( 'Loader 32', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader32.svg',
				),
				'loader33' => array(
					'alt' => esc_html__( 'Loader 33', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/loader/loader33.svg',
				),
			),
			'default'  => 'default',
			'required' => array(
				array( 'preloader_source', '=', 'predefine_loader' ),
			),
		),
		array(
			'id'             => 'preloader_image',
			'type'           => 'media',
			'url'            => true,
			'title'          => esc_html__( 'Preloader Image', 'pgs-core' ),
			'subtitle'       => esc_html__( 'Select preloader image.', 'pgs-core' ),
			'default'        => array(
				'url' => PGSCORE_URL . 'images/options/loader/loader19.svg',
			),
			'library_filter' => array( 'gif', 'jpg', 'jpeg', 'png' ),
			'required'       => array( 'preloader_source', '=', 'custom' ),
		),
	),
);
