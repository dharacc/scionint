<?php
return array(
	'title'            => esc_html__( 'Footer', 'pgs-core' ),
	'id'               => 'footer_section',
	'customizer_width' => '400px',
	'icon'             => 'el el-arrow-down',
	'fields'           => array(
		array(
			'id'      => 'footer_widget_columns',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Footer Column Layout', 'pgs-core' ),
			'options' => array(
				'one-column'            => array(
					'alt' => esc_html__( 'One Column', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/one-column.png',
				),
				'two-columns'           => array(
					'alt' => esc_html__( 'Two Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/two-columns.png',
				),
				'three-columns'         => array(
					'alt' => esc_html__( 'Three Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/three-columns.png',
				),
				'four-columns'          => array(
					'alt' => esc_html__( 'Four Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/four-columns.png',
				),
				'8-4-columns'           => array(
					'alt' => esc_html__( '8 + 4 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/8-4-columns.png',
				),
				'4-8-columns'           => array(
					'alt' => esc_html__( '4 + 8 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/4-8-columns.png',
				),
				'6-3-3-columns'         => array(
					'alt' => esc_html__( '6 + 3 + 3 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/6-3-3-columns.png',
				),
				'3-3-6-columns'         => array(
					'alt' => esc_html__( '3 + 3 + 6 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/3-3-6-columns.png',
				),
				'8-2-2-columns'         => array(
					'alt' => esc_html__( '8 + 2 + 2 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/8-2-2-columns.png',
				),
				'2-2-8-columns'         => array(
					'alt' => esc_html__( '2 + 2 + 8 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/2-2-8-columns.png',
				),
				'6-2-2-2-columns'       => array(
					'alt' => esc_html__( '6 + 2 + 2 + 2 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/6-2-2-2-columns.png',
				),
				'2-2-2-6-columns'       => array(
					'alt' => esc_html__( '2 + 2 + 2 + 6 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/2-2-2-6-columns.png',
				),
				'3-3-2-2-2-columns'     => array(
					'alt' => esc_html__( '3 + 3 + 2 + 2 + 2 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/3-3-2-2-2_columns.jpg',
				),
				'2-2-2-3-3-columns'     => array(
					'alt' => esc_html__( '2 + 2 + 2 + 3 + 3 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/2-2-2-3-3_columns.jpg',
				),
				'3-2-2-2-3-columns'     => array(
					'alt' => esc_html__( '3 + 2 + 2 + 2 + 3 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/3-2-2-2-3_columns.jpg',
				),
				'6-6-3-3-3-3-columns'   => array(
					'alt' => esc_html__( '6 + 6 / 3 + 3 + 3 + 3 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/6-6_3-3-3-3_columns.jpg',
				),
				'6-6-2-2-2-2-4-columns' => array(
					'alt' => esc_html__( '6 + 6 / 2 + 2 + 2 + 2 + 4 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/6-6_2-2-2-2-4_columns.jpg',
				),
				'12-2-2-2-2-4-columns'  => array(
					'alt' => esc_html__( '12 / 2 + 2 + 2 + 2 + 4 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/12_2-2-2-2-4_columns.jpg',
				),
				'12-3-3-3-3-columns'    => array(
					'alt' => esc_html__( '12 / 3 + 3 + 3 + 3 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/12_3-3-3-3_columns.jpg',
				),
				'2-2-2-2-2-2-columns'   => array(
					'alt' => esc_html__( '2 + 2 + 2 + 2 + 2 + 2 Columns', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/footer_layout/2-2-2-2-2-2_columns.jpg',
				),
			),
			'default' => 'four-columns',
		),
		array(
			'id'       => 'footer_one_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'First Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
		),
		array(
			'id'       => 'footer_two_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Second Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( 'two-columns', 'three-columns', 'four-columns', '8-4-columns', '4-8-columns', '6-3-3-columns', '3-3-6-columns', '8-2-2-columns', '2-2-8-columns', '6-2-2-2-columns', '2-2-2-6-columns', '2-2-2-2-2-2-columns', '12-2-2-2-2-4-columns', '6-6-2-2-2-2-4-columns', '6-6-3-3-3-3-columns', '3-2-2-2-3-columns', '2-2-2-3-3-columns', '3-3-2-2-2-columns', '12-3-3-3-3-columns' ) ),
			),
		),
		array(
			'id'       => 'footer_three_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Third Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( 'three-columns', 'four-columns', '6-3-3-columns', '3-3-6-columns', '8-2-2-columns', '2-2-8-columns', '6-2-2-2-columns', '2-2-2-6-columns', '2-2-2-2-2-2-columns', '12-2-2-2-2-4-columns', '6-6-2-2-2-2-4-columns', '6-6-3-3-3-3-columns', '3-2-2-2-3-columns', '2-2-2-3-3-columns', '3-3-2-2-2-columns', '12-3-3-3-3-columns' ) ),
			),
		),
		array(
			'id'       => 'footer_four_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Fourth Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( 'four-columns', '6-2-2-2-columns', '2-2-2-6-columns', '2-2-2-2-2-2-columns', '12-2-2-2-2-4-columns', '6-6-2-2-2-2-4-columns', '6-6-3-3-3-3-columns', '3-2-2-2-3-columns', '2-2-2-3-3-columns', '3-3-2-2-2-columns', '12-3-3-3-3-columns' ) ),
			),
		),
		array(
			'id'       => 'footer_five_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Fifth Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( '3-3-2-2-2-columns', '3-2-2-2-3-columns', '2-2-2-3-3-columns', '6-6-3-3-3-3-columns', '6-6-2-2-2-2-4-columns', '12-2-2-2-2-4-columns', '2-2-2-2-2-2-columns', '12-3-3-3-3-columns' ) ),
			),
		),
		array(
			'id'       => 'footer_six_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Sixth Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( '6-6-3-3-3-3-columns', '6-6-2-2-2-2-4-columns', '12-2-2-2-2-4-columns', '2-2-2-2-2-2-columns' ) ),
			),
		),
		array(
			'id'       => 'footer_seven_alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Seventh Footer Alignment', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select footer alignment', 'pgs-core' ),
			'options'  => array(
				'left'   => esc_html__( 'Left', 'pgs-core' ),
				'center' => esc_html__( 'Center', 'pgs-core' ),
				'right'  => esc_html__( 'Right', 'pgs-core' ),
			),
			'default'  => 'left',
			'required' => array(
				array( 'footer_widget_columns', '=', array( '6-6-2-2-2-2-4-columns' ) ),
			),
		),
		array(
			'id'       => 'sticky_footer',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sticky Footer', 'pgs-core' ),
			'subtitle' => esc_html__( 'The footer will be displayed behind the content of the page and will be visible when user scrolls to the bottom on the page.', 'pgs-core' ),
			'options'  => array(
				'enable'  => esc_html__( 'Enable', 'pgs-core' ),
				'disable' => esc_html__( 'Disable', 'pgs-core' ),
			),
			'default'  => 'disable',
		),
		array(
			'id'       => 'footer_background_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Footer Background Type', 'pgs-core' ),
			'subtitle' => esc_html__( 'Set footer background type(Image/color)', 'pgs-core' ),
			'options'  => array(
				'image' => esc_html__( 'Image', 'pgs-core' ),
				'color' => esc_html__( 'color', 'pgs-core' ),
			),
			'default'  => 'color',
		),
		array(
			'id'                  => 'footer_background_image',
			'type'                => 'background',
			'title'               => esc_html__( 'Footer Background', 'pgs-core' ),
			'subtitle'            => esc_html__( 'Footer Background Image.', 'pgs-core' ),
			'background-color'    => false,
			'background-position' => true,
			'transparent'         => false,
			'background-size'     => true,
			'compiler'            => true,
			'default'             => array(
				'background-color' => '#ffffff',
				'background-image' => PGSCORE_URL . 'images/options/footer-pattern.jpg',
			),
			'required'            => array(
				array( 'footer_background_type', '=', 'image' ),
			),
		),
		array(
			'id'       => 'footer_background_opacity',
			'type'     => 'button_set',
			'presets'  => true,
			'title'    => esc_html__( 'Background Opacity Color', 'pgs-core' ),
			'required' => array( 'footer_background_type', '=', 'image' ),
			'options'  => array(
				'none'   => esc_html__( 'None', 'pgs-core' ),
				'custom' => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'  => 'none',
		),
		array(
			'id'          => 'footer_background_overlay',
			'type'        => 'color_rgba',
			'title'       => esc_html__( 'Footer Background Overlay', 'pgs-core' ),
			'default'     => array(
				'color' => '#000000',
				'alpha' => 0.8,
			),
			'transparent' => false,
			'required'    => array(
				array( 'footer_background_opacity', '=', 'custom' ),
			),
		),
		array(
			'id'          => 'footer_background_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Footer Background Color', 'pgs-core' ),
			'default'     => '#f5f5f5',
			'transparent' => false,
			'required'    => array( 'footer_background_type', '=', 'color' ),
		),
		array(
			'id'          => 'footer_heading_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Footer Heading Color', 'pgs-core' ),
			'default'     => '#323232',
			'transparent' => false,
		),
		array(
			'id'          => 'footer_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Footer Text Color', 'pgs-core' ),
			'default'     => '#323232',
			'transparent' => false,
		),
		array(
			'id'          => 'footer_link_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Footer Link Color', 'pgs-core' ),
			'default'     => '#04d39f',
			'transparent' => false,
		),
		array(
			'id'     => 'copyright_section_start',
			'type'   => 'section',
			'title'  => 'Copyright Section',
			'indent' => true,
		),
		array(
			'id'      => 'enable_copyright_footer',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Show Copyright Text', 'pgs-core' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'pgs-core' ),
				'no'  => esc_html__( 'No', 'pgs-core' ),
			),
			'default' => 'yes',
		),
		array(
			'id'          => 'copyright_back_color',
			'type'        => 'color_rgba',
			'title'       => esc_html__( 'Copyright Background Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Custom color for copyright section background', 'pgs-core' ),
			'transparent' => false,
			'default'     => array(
				'color' => '#f5f5f5',
				'alpha' => 1,
			),
			'required'    => array( 'enable_copyright_footer', '=', 'yes' ),
		),
		array(
			'id'          => 'copyright_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'pgs-core' ),
			'subtitle'    => esc_html__( 'Custom color for copyright section font color', 'pgs-core' ),
			'transparent' => false,
			'default'     => '#323232',
			'validate'    => 'color',
			'required'    => array( 'enable_copyright_footer', '=', 'yes' ),
		),
		array(
			'id'          => 'copyright_link_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Link Color', 'pgs-core' ),
			'desc'        => esc_html__( 'Custom color for copyright section font link color', 'pgs-core' ),
			'transparent' => false,
			'default'     => '#04d39f',
			'validate'    => 'color',
			'required'    => array( 'enable_copyright_footer', '=', 'yes' ),
		),
		array(
			'id'       => 'footer_text_left',
			'type'     => 'editor',
			'title'    => esc_html__( 'Footer Text Left', 'pgs-core' ),
			'subtitle' => sprintf(
				wp_kses(
					__( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'pgs-core' ),
					array(
						'span' => array(
							'class' => true,
						),
						'br'   => array(),
					)
				)
			),
			'args'     => array(
				'media_buttons' => false,
			),
			'default'  => esc_html__( '&copy; Copyright [pgscore-year] [pgscore-site-title] All Rights Reserved.', 'pgs-core' ),
			'required' => array( 'enable_copyright_footer', '=', 'yes' ),
		),
		array(
			'id'       => 'footer_text_right',
			'type'     => 'editor',
			'title'    => esc_html__( 'Footer Text Right', 'pgs-core' ),
			'subtitle' => sprintf(
				wp_kses(
					__( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'pgs-core' ),
					array(
						'span' => array(
							'class' => true,
						),
						'br'   => array(),
					)
				)
			),
			'args'     => array(
				'media_buttons' => false,
			),
			'default'  => sprintf(
				wp_kses(
					__( 'Develop and design by <a href="%1$s">%2$s</a>', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.potenzaglobalsolutions.com/',
				esc_html__( 'Potenza Global Solutions', 'pgs-core' )
			),
			'required' => array( 'enable_copyright_footer', '=', 'yes' ),
		),
		array(
			'id'      => 'footer_bottom',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Footer Bottom', 'pgs-core' ),
			'options' => array(
				'show' => esc_html__( 'Show', 'pgs-core' ),
				'hide' => esc_html__( 'hide', 'pgs-core' ),
			),
			'default' => 'hide',
		),
		array(
			'id'       => 'footer_bottom_content',
			'type'     => 'editor',
			'title'    => esc_html__( 'Footer Bottom Content', 'pgs-core' ),
			'desc'     => esc_html__( 'You can use this field to add bottom content in footer area. You can use child-theme CSS or Theme Option > Custom CSS to format content in this field. Also, you can use shortcode to insert your desired contents.', 'pgs-core' ),
			'args'     => array(
				'media_buttons' => true,
			),
			'required' => array( 'footer_bottom', '=', 'show' ),
		),
		array(
			'id'     => 'copyright_section_end',
			'type'   => 'section',
			'indent' => false,
		),
	),
);
