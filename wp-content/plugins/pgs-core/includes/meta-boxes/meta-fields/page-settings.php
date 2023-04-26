<?php
global $post;

$wc_page_ids = array();
$pages       = array( 'myaccount', 'shop', 'cart', 'checkout', 'terms' );

if ( function_exists( 'wc_get_page_id' ) ) {
	foreach ( $pages as $page ) {
		$wc_page_ids[] = wc_get_page_id( $page );
	}
}

$fields = apply_filters(
	'pgs_custom_meta_page_settings',
	array(
		'id'       => 'pgs_custom_meta_page_settings',
		'title'    => esc_html__( 'Page Settings', 'pgs-core' ),
		'screen'   => array( 'page', 'post', 'teams', 'portfolio', 'forum', 'topic' ),
		'exclude'  => $wc_page_ids,
		'priority' => 'low',
		'context'  => 'normal',
		'fields'   => array(
			array(
				'heading'       => esc_html__( 'Show Header', 'pgs-core' ),
				'field_id'      => 'show_header',
				'type'          => 'button_group',
				'instructions'  => esc_html__( 'Show/hide banner on this page.', 'pgs-core' ),
				'default_value' => 1,
				'options'       => array(
					1       => esc_html__( 'Show', 'pgs-core' ),
					'false' => esc_html__( 'Hide', 'pgs-core' ),
				),
			),
			array(
				'heading'           => esc_html__( 'Header Settings Source', 'pgs-core' ),
				'field_id'          => 'header_settings_source',
				'type'              => 'button_group',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
				),
				'options'           => array(
					'default' => esc_html__( 'Default (from Theme Options)', 'pgs-core' ),
					'custom'  => esc_html__( 'Custom', 'pgs-core' ),
				),
				'default_value'     => 'default',
				'layout'            => 'horizontal',
			),
			array(
				'heading'           => esc_html__( 'Banner Type', 'pgs-core' ),
				'field_id'          => 'banner_type',
				'type'              => 'button_group',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'options'           => array(
					'color' => '<i class="fa fa-paint-brush"></i> ' . esc_html__( 'Color', 'pgs-core' ),
					'image' => '<i class="fa fa-picture-o"></i> ' . esc_html__( 'Image', 'pgs-core' ),
					'video' => '<i class="fa fa-video-camera"></i> ' . esc_html__( 'Video', 'pgs-core' ),
				),
				'default_value'     => 'color',
				'layout'            => 'horizontal',
			),
			array(
				'heading'               => esc_html__( 'Banner Image', 'pgs-core' ),
				'field_id'              => 'banner_image_bg_custom',
				'type'                  => 'background',
				'conditional_logic'     => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
				'preview_height'        => 200,
				'show_preview'          => 1,
				'background_repeat'     => 'inherit',
				'background_size'       => 'inherit',
				'background_attachment' => 'inherit',
				'background_position'   => 'inherit',
			),
			array(
				'heading'           => esc_html__( 'Banner (Color)', 'pgs-core' ),
				'field_id'          => 'banner_image_color',
				'type'              => 'color_picker',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '==',
						'value'    => 'color',
					),
				),
				'default_value'     => '#191919',
			),
			array(
				'heading'           => esc_html__( 'Video Source', 'pgs-core' ),
				'field_id'          => 'banner_video_source',
				'type'              => 'button_group',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '==',
						'value'    => 'video',
					),
				),
				'options'           => array(
					'youtube' => '<i class="fa fa-youtube"></i> ' . esc_html__( 'YouTube', 'pgs-core' ),
					'vimeo'   => '<i class="fa fa-vimeo"></i> ' . esc_html__( 'Vimeo', 'pgs-core' ),
				),
				'default_value'     => 'youtube',
				'layout'            => 'horizontal',
			),
			array(
				'heading'           => esc_html__( 'YouTube', 'pgs-core' ),
				'field_id'          => 'banner_video_source_youtube',
				'type'              => 'oembed',
				'instructions'      => esc_html__( 'Enter YouTube video link.', 'pgs-core' ),
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'banner_video_source',
						'operator' => '==',
						'value'    => 'youtube',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'Vimeo', 'pgs-core' ),
				'field_id'          => 'banner_video_source_vimeo',
				'type'              => 'oembed',
				'instructions'      => esc_html__( 'Enter Vimeo video link.', 'pgs-core' ),
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '==',
						'value'    => 'video',
					),
					array(
						'field'    => 'banner_video_source',
						'operator' => '==',
						'value'    => 'vimeo',
					),
				),
			),
			array(
				'heading'           => esc_html__( 'Background Opacity Color', 'pgs-core' ),
				'field_id'          => 'background_opacity_color',
				'type'              => 'button_group',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '!=',
						'value'    => 'color',
					),
				),
				'options'           => array(
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'black'  => esc_html__( 'Black', 'pgs-core' ),
					'custom' => esc_html__( 'Custom', 'pgs-core' ),
				),
				'default_value'     => 'none',
				'layout'            => 'horizontal',
				'return_format'     => 'value',
			),
			array(
				'heading'           => esc_html__( 'Background Opacity Color (Custom Color)', 'pgs-core' ),
				'field_id'          => 'banner_image_opacity_custom_color',
				'type'              => 'color_picker',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '!=',
						'value'    => 'color',
					),
					array(
						'field'    => 'background_opacity_color',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default_value'     => '#000000',
			),
			array(
				'heading'           => esc_html__( 'Background Opacity Color (Custom Opacity)', 'pgs-core' ),
				'field_id'          => 'banner_image_opacity_custom_opacity',
				'type'              => 'number',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'banner_type',
						'operator' => '!=',
						'value'    => 'color',
					),
					array(
						'field'    => 'background_opacity_color',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default_value'     => '.8',
				'min'               => 0,
				'max'               => 1,
				'step'              => '0.01',
			),
			array(
				'heading'           => esc_html__( 'Page Header Height', 'pgs-core' ),
				'field_id'          => 'page_header_height',
				'type'              => 'number',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'range'             => true,
				'default_value'     => 287,
				'min'               => 200,
				'max'               => 600,
				'append'            => 'px',
			),
			array(
				'heading'           => esc_html__( 'Titlebar Text Align', 'pgs-core' ),
				'field_id'          => 'titlebar_text_align',
				'type'              => 'select',
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'options'           => array(
					'default'  => esc_html__( 'All Center', 'pgs-core' ),
					'allleft'  => esc_html__( 'All Left', 'pgs-core' ),
					'allright' => esc_html__( 'All Right', 'pgs-core' ),
					'left'     => esc_html__( 'Title Left / Breadcrumb Right', 'pgs-core' ),
					'right'    => esc_html__( 'Title Right / Breadcrumb Left', 'pgs-core' ),
				),
				'default_value'     => 'default',
			),
			array(
				'heading'           => esc_html__( 'Display Breadcrumb', 'pgs-core' ),
				'field_id'          => 'display_breadcrumb',
				'type'              => 'button_group',
				'options'           => array(
					1 => esc_html__( 'Yes', 'pgs-core' ),
					0 => esc_html__( 'No', 'pgs-core' ),
				),
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'default_value'     => 0,
			),
			array(
				'heading'           => esc_html__( 'Display Breadcrumb on Mobile', 'pgs-core' ),
				'field_id'          => 'display_breadcrumb_on_mobile',
				'type'              => 'button_group',
				'options'           => array(
					1 => esc_html__( 'Yes', 'pgs-core' ),
					0 => esc_html__( 'No', 'pgs-core' ),
				),
				'default_value'     => 0,
				'conditional_logic' => array(
					array(
						'field'    => 'show_header',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'field'    => 'header_settings_source',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'field'    => 'display_breadcrumb',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
		),
	)
);

pgscf_add_field_group( $fields );
