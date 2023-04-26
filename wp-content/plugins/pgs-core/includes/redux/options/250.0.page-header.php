<?php
$breadcrumb_fields_info = $breadcrumb_fields = array();
$breadcrumb_fields[]    = array(
	'id'     => 'breadcrumb_section_start',
	'type'   => 'section',
	'title'  => esc_html__( 'Breadcrumb Settings', 'pgs-core' ),
	'indent' => true,
);

$breadcrumb_fields[] = array(
	'id'      => 'display_breadcrumb',
	'type'    => 'switch',
	'title'   => esc_html__( 'Display Breadcrumb', 'pgs-core' ),
	'default' => 0,
	'on'      => esc_html__( 'On', 'pgs-core' ),
	'off'     => esc_html__( 'Off', 'pgs-core' ),
);
$breadcrumb_fields[] = array(
	'id'       => 'hide_breadcrumb_mobile',
	'type'     => 'switch',
	'title'    => esc_html__( 'Display Breadcrumb on Mobile', 'pgs-core' ),
	'default'  => 0,
	'on'       => esc_html__( 'On', 'pgs-core' ),
	'off'      => esc_html__( 'Off', 'pgs-core' ),
	'required' => array(
		array( 'display_breadcrumb', '=', 1 ),
	),
);

$breadcrumb_fields[] = array(
	'id'          => 'yoast_breadcrumb',
	'type'        => 'switch',
	'title'       => esc_html__( 'Enable Yoast breadcrumb', 'pgs-core' ),
	'subtitle'    => esc_html__( 'The Yoast SEO plugin needs to be installed. It Replaces standard breadcrumb with the custom that comes with the plugin. If plugin not installed then default breadcrumb will appear.', 'pgs-core' ),
	'description' => esc_html__( 'You can configure it in Dashboard -> SEO -> Search Appearance -> Breadcrumbs.', 'pgs-core' ),
	'default'     => false,
	'required'    => array(
		array( 'display_breadcrumb', '=', 1 ),
	),
);

if ( function_exists( 'pgscore_is_plugin_installed' ) && pgscore_is_plugin_installed( 'breadcrumb-navxt' ) ) {
	if ( pgscore_check_plugin_active( 'breadcrumb-navxt/breadcrumb-navxt.php' ) ) {

		$breadcrumb_navxt_settings_link = add_query_arg( array( 'page' => 'breadcrumb-navxt' ), admin_url( 'options-general .php' ) );

		$breadcrumb_fields[] = array(
			'id'       => 'breadcrumb_navxt_settings',
			'type'     => 'info',
			'style'    => 'info',
			'title'    => esc_html__( 'Breadcrumb NavXT Settings', 'pgs-core' ),
			'desc'     => sprintf(
				wp_kses(
					__( 'Click <a href="%1$s">here</a> for more settings.', 'pgs-core' ),
					array(
						'a' => array(
							'href' => true,
						),
					)
				),
				$breadcrumb_navxt_settings_link
			),
			'required' => array(
				array( 'display_breadcrumb', '=', 1 ),
			),
		);
	}
}

$breadcrumb_fields[] = array(
	'id'     => 'breadcrumb_section_end',
	'type'   => 'section',
	'indent' => false,
);

return array(
	'title'            => esc_html__( 'Page Header', 'pgs-core' ),
	'id'               => 'page_header_section',
	'desc'             => esc_html__( 'You can manage page header settings here, like Page Header Type, Breadcrumb, Page Header Height and other various settings.', 'pgs-core' ),
	'customizer_width' => '450px',
	'fields'           => array_merge(
		array(
			array(
				'id'          => 'titlebar_view',
				'type'        => 'select_image_new',
				'title'       => esc_html__( 'Page Header Layout', 'pgs-core' ),
				'placeholder' => esc_html__( 'Select page header layout.', 'pgs-core' ),
				'select2'     => array(
					'allowClear' => 0,
				),
				'options'     => array(
					'default'  => array(
						'alt'   => esc_html__( 'Default', 'pgs-core' ),
						'title' => esc_html__( 'Default', 'pgs-core' ),
						'img'   => esc_url( PGSCORE_URL . 'images/options/titlebar_view/default.png' ),
					),
					'allleft'  => array(
						'alt'   => esc_html__( 'All Left', 'pgs-core' ),
						'title' => esc_html__( 'All Left', 'pgs-core' ),
						'img'   => esc_url( PGSCORE_URL . 'images/options/titlebar_view/allleft.png' ),
					),
					'allright' => array(
						'alt'   => esc_html__( 'All Right', 'pgs-core' ),
						'title' => esc_html__( 'All Right', 'pgs-core' ),
						'img'   => esc_url( PGSCORE_URL . 'images/options/titlebar_view/allright.png' ),
					),
					'left'     => array(
						'alt'   => esc_html__( 'Title Left / Breadcrumb Right', 'pgs-core' ),
						'title' => esc_html__( 'Title Left / Breadcrumb Right', 'pgs-core' ),
						'img'   => esc_url( PGSCORE_URL . 'images/options/titlebar_view/left.png' ),
					),
					'right'    => array(
						'alt'   => esc_html__( 'Title Right / Breadcrumb Left', 'pgs-core' ),
						'title' => esc_html__( 'Title Right / Breadcrumb Left', 'pgs-core' ),
						'img'   => esc_url( PGSCORE_URL . 'images/options/titlebar_view/right.png' ),
					),
				),
				'default'     => 'default',
			),
			array(
				'id'            => 'pageheader_height',
				'type'          => 'slider',
				'title'         => esc_html__( 'Page Header Height', 'pgs-core' ),
				'desc'          => esc_html__( 'Set height of the Page Header.', 'pgs-core' ),
				'default'       => 150,
				'min'           => 150,
				'step'          => 1,
				'max'           => 600,
				'display_value' => 'text',
			),
			array(
				'id'      => 'enable_full_width',
				'type'    => 'switch',
				'title'   => esc_html__( 'Enable Full Width', 'pgs-core' ),
				'desc'    => esc_html__( 'Enable/disable full width page header area', 'pgs-core' ),
				'default' => false,
			),
			array(
				'id'     => 'page_header_style_section_start',
				'type'   => 'section',
				'title'  => esc_html__( 'Page Header - Background Settings', 'pgs-core' ),
				'indent' => true,
			),
			array(
				'id'      => 'banner_type',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Background Type', 'pgs-core' ),
				'options' => array(
					'color' => esc_html__( 'Color', 'pgs-core' ),
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'video' => esc_html__( 'Video', 'pgs-core' ),
				),
				'default' => 'image',
			),
			array(
				'id'               => 'banner_image',
				'type'             => 'background',
				'title'            => esc_html__( 'Background', 'pgs-core' ),
				'desc'             => esc_html__( 'Set page header background image.', 'pgs-core' ),
				'background-color' => false,
				'preview_media'    => true,
				'default'          => array(
					'background-image' => get_parent_theme_file_uri( '/images/page-header.jpg' ),
				),
				'required'         => array(
					array( 'banner_type', '=', 'image' ),
				),
			),
			array(
				'id'       => 'video_type',
				'title'    => 'Video Source',
				'desc'     => 'Video source from where to play video in header background.',
				'type'     => 'button_set',
				'options'  => array(
					'youtube' => esc_html__( 'Youtube', 'pgs-core' ),
					'vimeo'   => esc_html__( 'Vimeo', 'pgs-core' ),
				),
				'select2'  => array(
					'allowClear' => 0,
				),
				'default'  => 'youtube',
				'required' => array(
					array( 'banner_type', '=', 'video' ),
				),
			),
			array(
				'id'       => 'youtube_video',
				'title'    => esc_html__( 'Youtube Video Link', 'pgs-core' ),
				'desc'     => esc_html__( 'Youtube Video Link of video to play in background', 'pgs-core' ),
				'type'     => 'text',
				'default'  => 'https://www.youtube.com/watch?v=D2EvaSgi3UQ',
				'required' => array(
					array( 'banner_type', '=', 'video' ),
					array( 'video_type', '=', 'youtube' ),
				),
			),
			array(
				'id'       => 'vimeo_video',
				'title'    => esc_html__( 'Vimeo Video Link', 'pgs-core' ),
				'desc'     => esc_html__( 'Vimeo Video Link of video to play in background', 'pgs-core' ),
				'type'     => 'text',
				'default'  => 'https://vimeo.com/134399785',
				'required' => array(
					array( 'banner_type', '=', 'video' ),
					array( 'video_type', '=', 'vimeo' ),
				),
			),
			array(
				'id'       => 'banner_image_opacity',
				'type'     => 'button_set',
				'presets'  => true,
				'title'    => esc_html__( 'Background Opacity Color', 'pgs-core' ),
				'required' => array(
					array( 'banner_type', '=', array( 'image', 'video' ) ),
				),
				'options'  => array(
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'black'  => esc_html__( 'Black', 'pgs-core' ),
					'custom' => esc_html__( 'Custom', 'pgs-core' ),
				),
				'default'  => 'black',
			),
			array(
				'id'       => 'banner_image_opacity_custom_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Opacity Color (Custom)', 'pgs-core' ),
				'default'  => array(
					'color' => '#7e33dd',
					'alpha' => '.8',
				),
				'mode'     => 'background-color',
				'required' => array(
					array( 'banner_type', '=', array( 'image', 'video' ) ),
					array( 'banner_image_opacity', '=', 'custom' ),
				),
			),
			array(
				'id'          => 'banner_image_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Background Color', 'pgs-core' ),
				'transparent' => false,
				'default'     => '#191919',
				'validate'    => 'color',
				'mode'        => 'background',
				'required'    => array( 'banner_type', '=', 'color' ),
			),
			array(
				'id'       => 'page_header_style_section_end',
				'type'     => 'section',
				'indent'   => false,
				'required' => array( 'sticky_header', '=', true ),
			),
		),
		$breadcrumb_fields
	),
);
