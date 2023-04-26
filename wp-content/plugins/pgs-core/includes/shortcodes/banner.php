<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_banner
 *
 ******************************************************************************/
function pgscore_shortcode_banner( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                         => 'style-1',

		'font_size_responsive'          => '',
		'font_size'                     => '70',
		'font_size_xl'                  => '70',
		'font_size_lg'                  => '60',
		'font_size_md'                  => '50',
		'font_size_sm'                  => '40',
		'font_size_xs'                  => '30',
		'banner_padding_responsive'     => '',
		'banner_css'                    => '',
		'banner_padding_xl'             => '',
		'banner_padding_lg'             => '',
		'banner_padding_md'             => '',
		'banner_padding_sm'             => '',
		'banner_padding_xs'             => '',
		'banner_link_enable'            => '',
		'banner_link_url'               => '',

		'vertical_align'                => 'vtop',
		'horizontal_align'              => 'hleft',
		'banner_effect'                 => 'none',
		'bg_img_source'                 => 'media_library',
		'bg_img'                        => '',
		'bg_img_link'                   => '',

		'list_items'                    => '',

		// Button
		'button_text'                   => esc_html__( 'Click Here', 'pgs-core' ),
		'button_style'                  => 'link',
		'button_size'                   => 'md',
		'button_shape'                  => 'square',

		'button_text_color'             => '#323232',
		'button_color'                  => '#04d39f',
		'button_border_color'           => '#04d39f',
		'button_hover_text_color'       => '#ffffff',
		'button_hover_background_color' => '#323232',
		'button_hover_border_color'     => '#323232',

		'button_border_width'           => '1',
		'button_text_transform'         => '',
		'button_letter_spacing'         => 0,
		'button_line_height'            => '',

		'link_url'                      => '|||',

		'add_badge'                     => '',
		'badge_style'                   => 'style-1',
		'badge_title'                   => '',
		'badge_type'                    => 'border',
		'badge_text_color'              => '#323232',
		'badge_background_color'        => '#ffffff',
		'badge_border_width'            => 1,
		'badge_border_color'            => '#323232',
		'badge_width'                   => '70',
		'badge_height'                  => '70',
		'badge_vertical_align'          => 'vbottom',
		'badge_horizontal_align'        => 'hright',
		'badge_font_size'               => 20,
		'badge_font_weight'             => '600',
		'badge_line_height'             => '',
		'badge_text_transform'          => '',

		'deal_date'                     => '',
		'expire_message'                => esc_html__( 'This offer has expired!', 'pgs-core' ),
		'counter_size'                  => 'sm',
		'counter_style'                 => 'flat',
		'deal_padding_responsive'       => '',
		'deal_css'                      => '',
		'deal_padding_xl'               => '',
		'deal_padding_lg'               => '',
		'deal_padding_md'               => '',
		'deal_padding_sm'               => '',
		'deal_padding_xs'               => '',
		'on_expire_btn'                 => 'disable',
		'element_css'                   => '',
		'element_id'                    => '',
		'element_class'                 => '',
		'shortcode_handle'              => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$banner_image = false;

	if ( 'external_link' == $bg_img_source ) {
		$banner_image[0] = $bg_img_link;
		$banner_image[1] = '';
		$banner_image[2] = '';
	} else {
		/* banner image is empty then return  */
		$banner_image = wp_get_attachment_image_src( $bg_img, 'full' );
	}
	if ( ! isset( $banner_image[0] ) || empty( $banner_image[0] ) ) {
		return;
	}

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']               = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['banner_image']       = $banner_image;
	$pgscore_shortcodes[ $shortcode_handle ]['show_hide_defaults'] = array( 'lg', 'md', 'sm', 'xs' );
	$pgscore_shortcodes[ $shortcode_handle ]['hide_classes']       = array(
		'lg' => 'hidden-lg',
		'md' => 'hidden-md',
		'sm' => 'hidden-sm',
		'xs' => 'hidden-xs',
	);

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'banner/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	$shortcode_fields = array(
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'banner_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'message'        => esc_html__( 'If "Banner Image" is not selected/set, the shortcode content will not be rendered.', 'pgs-core' ),
			'display_header' => true,
		),
		array(
			'type'        => 'pgscore_radio_image',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'options'     => array(
				'style-1' => PGSCORE_URL . 'images/shortcodes/banner/style-1.png',
				'deal-1'  => PGSCORE_URL . 'images/shortcodes/banner/deal-1.png',
				'deal-2'  => PGSCORE_URL . 'images/shortcodes/banner/deal-2.png',
			),
			'show_label'  => true,
			'admin_label' => true,
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => esc_html__( 'Vertical Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set banner text vertical position.', 'pgs-core' ),
			'param_name'       => 'vertical_align',
			'value'            => array_flip(
				array(
					'vtop'    => esc_html__( 'Top', 'pgs-core' ),
					'vmiddle' => esc_html__( 'Middle', 'pgs-core' ),
					'vbottom' => esc_html__( 'Bottom', 'pgs-core' ),
				)
			),
			'std'              => 'vtop',
			'edit_field_class' => 'vc_col-md-6',
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'style',
				'value'   => array( 'style-1', 'deal-1' ),
			),
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => esc_html__( 'Horizontal Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set banner text horizontal position', 'pgs-core' ),
			'param_name'       => 'horizontal_align',
			'value'            => array_flip(
				array(
					'hleft'   => esc_html__( 'Left', 'pgs-core' ),
					'hcenter' => esc_html__( 'Center', 'pgs-core' ),
					'hright'  => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'              => 'hleft',
			'edit_field_class' => 'vc_col-md-6',
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'style',
				'value'   => array( 'style-1', 'deal-1' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Effect', 'pgs-core' ),
			'param_name'  => 'banner_effect',
			'value'       => array_flip(
				array(
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'border' => esc_html__( 'Border', 'pgs-core' ),
					'flash'  => esc_html__( 'Flash', 'pgs-core' ),
					'zoom'   => esc_html__( 'Zoom', 'pgs-core' ),
				)
			),
			'std'         => 'none',
			'description' => esc_html__( 'Select banner effect type.', 'pgs-core' ),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Banner Padding Responsive?', 'pgs-core' ),
			'param_name'  => 'banner_padding_responsive',
			'description' => esc_html__( 'Select this checkbox to enable responsive banner padding for different width.', 'pgs-core' ),
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Banner Padding', 'pgs-core' ),
			'param_name'       => 'banner_css',
			'dependency'       => array(
				'element'            => 'banner_padding_responsive',
				'value_not_equal_to' => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-sm-6 vc_col-md-5 vc_col-lg-3 banner_css_wrap',
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Extra Large Devices (&ge;1200px)', 'pgs-core' ),
			'param_name'       => 'banner_padding_xl',
			'dependency'       => array(
				'element' => 'banner_padding_responsive',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Large Devices (&ge;992px)', 'pgs-core' ),
			'param_name'       => 'banner_padding_lg',
			'dependency'       => array(
				'element' => 'banner_padding_responsive',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Medium Devices (&ge;768px)', 'pgs-core' ),
			'param_name'       => 'banner_padding_md',
			'dependency'       => array(
				'element' => 'banner_padding_responsive',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Small Devices (&ge;576px)', 'pgs-core' ),
			'param_name'       => 'banner_padding_sm',
			'dependency'       => array(
				'element' => 'banner_padding_responsive',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Extra Small Devices (<576px)', 'pgs-core' ),
			'param_name'       => 'banner_padding_xs',
			'dependency'       => array(
				'element' => 'banner_padding_responsive',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-md-6 vc_col-lg-4 vc_col-xl-4 banner_css_wrap',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Font Size Responsive?', 'pgs-core' ),
			'param_name'  => 'font_size_responsive',
			'description' => esc_html__( 'Select this checkbox to enable responsive font size for different width.', 'pgs-core' ),
		),
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Font Size', 'pgs-core' ),
			'param_name' => 'font_size',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 70,
			'unit'       => 'px',
			'dependency' => array(
				'element'            => 'font_size_responsive',
				'value_not_equal_to' => 'true',
			),
		),
		/******************************************************/
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Extra Large Devices (&ge;1200px)', 'pgs-core' ),
			'param_name' => 'font_size_xl',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 70,
			'unit'       => 'px',
			'dependency' => array(
				'element' => 'font_size_responsive',
				'value'   => 'true',
			),
		),
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Large Devices (&ge;992px)', 'pgs-core' ),
			'param_name' => 'font_size_lg',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 60,
			'unit'       => 'px',
			'dependency' => array(
				'element' => 'font_size_responsive',
				'value'   => 'true',
			),
		),
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Medium Devices (&ge;768px)', 'pgs-core' ),
			'param_name' => 'font_size_md',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 50,
			'unit'       => 'px',
			'dependency' => array(
				'element' => 'font_size_responsive',
				'value'   => 'true',
			),
		),
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Small Devices (&ge;576px)', 'pgs-core' ),
			'param_name' => 'font_size_sm',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 40,
			'unit'       => 'px',
			'dependency' => array(
				'element' => 'font_size_responsive',
				'value'   => 'true',
			),
		),
		array(
			'type'       => 'pgscore_range_slider',
			'heading'    => esc_html__( 'Extra Small Devices (<576px)', 'pgs-core' ),
			'param_name' => 'font_size_xs',
			'tooltip'    => esc_html__( 'Choose font size', 'pgs-core' ),
			'min'        => 10,
			'max'        => 100,
			'value'      => 30,
			'unit'       => 'px',
			'dependency' => array(
				'element' => 'font_size_responsive',
				'value'   => 'true',
			),
		),
		/******************************************************/
		array(
			'type'        => 'param_group',
			'param_name'  => 'list_items',
			'group'       => esc_html__( 'List Items', 'pgs-core' ),
			'max_items'   => 5,
			'sortable'    => true,
			'deletable'   => true,
			'collapsible' => true,
			'params'      => array(
				array(
					'type'        => 'textfield',
					'param_name'  => 'title',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'description' => esc_html__( 'Add banner text.', 'pgs-core' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Use google fonts ?', 'pgs-core' ),
					'param_name'  => 'use_google_font',
					'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
					'description' => esc_html__( 'Select this checkbox to use google fonts.', 'pgs-core' ),
				),
				array(
					'type'       => 'google_fonts',
					'param_name' => 'banner_google_fonts',
					'settings'   => array(
						'fields' => array(
							'font_family_description' => __( 'Select font family.', 'pgs-core' ),
							'font_style_description'  => __( 'Select font styling.', 'pgs-core' ),
						),
					),
					'dependency' => array(
						'element' => 'use_google_font',
						'value'   => 'yes',
					),
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'google_font_enqueue_source',
					'heading'     => esc_html__( 'Google Fonts Enqueue Source', 'pgs-core' ),
					'description' => esc_html__( 'Choose the source of Google Fonts CSS. On selecting Default option, Visual Composer will enqueue CSS directly from Google Fonts. And, the Manual option will use fonts loaded for site contents.', 'pgs-core' ),
					'value'       => array_flip(
						array(
							'default' => esc_html__( 'Default', 'pgs-core' ),
							'manual'  => esc_html__( 'Manual', 'pgs-core' ),
						)
					),
					'dependency'  => array(
						'element' => 'use_google_font',
						'value'   => 'yes',
					),
					'std'         => 'default',
				),
				array(
					'type'             => 'pgscore_number_min_max',
					'heading'          => esc_html__( 'Font Size (Ratio to Main Font)', 'pgs-core' ),
					'param_name'       => 'font_size',
					'min'              => 10,
					'max'              => 100,
					'value'            => 70,
					'suffix'           => '%',
					'description'      => esc_html__( 'Enter/select font size. This font-size will be in ratio of main font-size.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-md-4',
					'admin_label'      => true,
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Color', 'pgs-core' ),
					'param_name'       => 'color',
					'description'      => esc_html__( 'Select text color.', 'pgs-core' ),
					'value'            => '#323232',
					'edit_field_class' => 'vc_col-md-4',
					'admin_label'      => true,
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
					'param_name'       => 'bg_color',
					'description'      => esc_html__( 'Select text background color.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-md-4',
					'admin_label'      => true,
				),
				array(
					'type'       => 'pgscore_divider',
					'param_name' => 'font_style_divider',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'font_style',
					'heading'          => esc_html__( 'Font Style', 'pgs-core' ),
					'description'      => esc_html__( 'Select font style.', 'pgs-core' ),
					'value'            => array_flip(
						array(
							''        => esc_html__( 'Select Font Style', 'pgs-core' ),
							'normal'  => esc_html__( 'Normal', 'pgs-core' ),
							'italic'  => esc_html__( 'Italic', 'pgs-core' ),
							'oblique' => esc_html__( 'Oblique', 'pgs-core' ),
							'initial' => esc_html__( 'Initial', 'pgs-core' ),
							'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						)
					),
					'dependency'       => array(
						'element'            => 'use_google_font',
						'value_not_equal_to' => 'yes',
					),
					'std'              => 'normal',
					'edit_field_class' => 'vc_col-md-4',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'font_weight',
					'heading'          => esc_html__( 'Font Weight', 'pgs-core' ),
					'description'      => esc_html__( 'Select font weight.', 'pgs-core' ),
					'value'            => array_flip(
						array(
							''        => esc_html__( 'Select Font Weight', 'pgs-core' ),
							'normal'  => esc_html__( 'Normal', 'pgs-core' ),
							'bold'    => esc_html__( 'Bold', 'pgs-core' ),
							'bolder'  => esc_html__( 'Bolder', 'pgs-core' ),
							'lighter' => esc_html__( 'Lighter', 'pgs-core' ),
							'100'     => esc_html__( '100', 'pgs-core' ),
							'200'     => esc_html__( '200', 'pgs-core' ),
							'300'     => esc_html__( '300', 'pgs-core' ),
							'400'     => esc_html__( '400', 'pgs-core' ),
							'500'     => esc_html__( '500', 'pgs-core' ),
							'600'     => esc_html__( '600', 'pgs-core' ),
							'700'     => esc_html__( '700', 'pgs-core' ),
							'800'     => esc_html__( '800', 'pgs-core' ),
							'900'     => esc_html__( '900', 'pgs-core' ),
							'initial' => esc_html__( 'Initial', 'pgs-core' ),
							'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						)
					),
					'dependency'       => array(
						'element'            => 'use_google_font',
						'value_not_equal_to' => 'yes',
					),
					'std'              => '400',
					'edit_field_class' => 'vc_col-md-4',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'text_transform',
					'heading'          => esc_html__( 'Text Transform', 'pgs-core' ),
					'description'      => esc_html__( 'Select text transformation.', 'pgs-core' ),
					'value'            => array_flip(
						array(
							''           => esc_html__( 'Select Text Transform', 'pgs-core' ),
							'none'       => esc_html__( 'None', 'pgs-core' ),
							'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
							'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
							'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
							'initial'    => esc_html__( 'Initial', 'pgs-core' ),
							'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
							'unset'      => esc_html__( 'Unset', 'pgs-core' ),
						)
					),
					'std'              => '',
					'edit_field_class' => 'vc_col-md-4',
				),
				array(
					'type'             => 'pgscore_number_min_max',
					'heading'          => esc_html__( 'Letter Spacing', 'pgs-core' ),
					'param_name'       => 'letter_spacing',
					'min'              => 0,
					'max'              => 100,
					'value'            => 0,
					'suffix'           => 'px',
					'description'      => esc_html__( 'Enter/select letter spacing.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-md-4',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Line Height', 'pgs-core' ),
					'param_name'       => 'line_height',
					'description'      => esc_html__( 'Enter line height i.e. 10px, 1em, or 100%. If you want to add value in decimal like [.5em], then use complete decimal format like [0.5em]. Allowed units are px, em, and %.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-md-4',
				),
				array(
					'type'             => 'checkbox',
					'heading'          => esc_html__( 'Responsive', 'pgs-core' ),
					'description'      => esc_html__( 'Select checkbox(es) to show/hide on text on specific device size.', 'pgs-core' ),
					'param_name'       => 'text_show_hide',
					'value'            => array_flip(
						array(
							'xl' => esc_html__( 'Extra Large Devices (&ge;1200px)', 'pgs-core' ),
							'lg' => esc_html__( 'Large Devices (&ge;992px)', 'pgs-core' ),
							'md' => esc_html__( 'Medium Devices (&ge;768px)', 'pgs-core' ),
							'sm' => esc_html__( 'Small Devices (&ge;576px)', 'pgs-core' ),
							'xs' => esc_html__( 'Extra small Devices (<576px)', 'pgs-core' ),
						)
					),
					'std'              => 'xl,lg,md,sm,xs',
					'edit_field_class' => 'vc_col-md-12',
				),
			),
			'value'       => urlencode(
				json_encode(
					array(
						array(
							'title'          => esc_html__( 'Lorem Ipsum', 'pgs-core' ),
							'font_size'      => '70',
							'color'          => '#323232',
							'text_show_hide' => 'xl,lg,md,sm,xs',
						),
					)
				)
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Image source', 'pgs-core' ),
			'param_name'  => 'bg_img_source',
			'description' => esc_html__( 'Select image source.', 'pgs-core' ),
			'value'       => array_flip(
				array(
					'media_library' => esc_html__( 'Media library', 'pgs-core' ),
					'external_link' => esc_html__( 'External link', 'pgs-core' ),
				)
			),
			'std'         => 'media_library',
		),
		array(
			'type'        => 'attach_image',
			'param_name'  => 'bg_img',
			'heading'     => esc_html__( 'Banner Image', 'pgs-core' ),
			'description' => esc_html__( 'Select/upload banner image.', 'pgs-core' ),
			'holder'      => 'img',
			'dependency'  => array(
				'element' => 'bg_img_source',
				'value'   => 'media_library',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Banner Link ?', 'pgs-core' ),
			'param_name'  => 'banner_link_enable',
			'description' => esc_html__( 'Select this checkbox to add link on banner.', 'pgs-core' ),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Banner URL (Link)', 'pgs-core' ),
			'param_name'  => 'banner_link_url',
			'description' => esc_html__( 'Add custom link on banner.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'banner_link_enable',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'bg_img_link',
			'heading'     => esc_html__( 'Banner Image', 'pgs-core' ),
			'description' => esc_html__( 'Enter banner image link.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'bg_img_source',
				'value'   => 'external_link',
			),
			'admin_label' => true,
		),

		// Button
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Button Title', 'pgs-core' ),
			'param_name'  => 'button_text',
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'button_style',
			'heading'          => esc_html__( 'Button Style', 'pgs-core' ),
			'description'      => esc_html__( 'Select button style.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'link'   => esc_html__( 'Link', 'pgs-core' ),
					'flat'   => esc_html__( 'Flat', 'pgs-core' ),
					'border' => esc_html__( 'Border', 'pgs-core' ),
				)
			),
			'std'              => 'link',
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-4',
			'dependency'       => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'button_size',
			'heading'          => esc_html__( 'Button Size', 'pgs-core' ),
			'description'      => esc_html__( 'Select button size.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				)
			),
			'std'              => 'md',
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'flat', 'border' ),
			),
			'edit_field_class' => 'vc_col-md-4',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'button_shape',
			'heading'          => esc_html__( 'Button Shape', 'pgs-core' ),
			'description'      => esc_html__( 'Select button shape.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
				)
			),
			'std'              => 'square',
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'flat', 'border' ),
			),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-4',
		),
		array(
			'type'             => 'hidden',
			'param_name'       => 'button_sep_1',
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-12',
			'dependency'       => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Text Color', 'pgs-core' ),
			'param_name'       => 'button_text_color',
			'description'      => esc_html__( 'Select button text color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
			'dependency'       => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Background Color', 'pgs-core' ),
			'param_name'       => 'button_color',
			'description'      => esc_html__( 'Select button background color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'flat' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Border Color', 'pgs-core' ),
			'param_name'       => 'button_border_color',
			'description'      => esc_html__( 'Select button border color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'border' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'hidden',
			'param_name'       => 'button_sep_2',
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-12',
			'dependency'       => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Text Hover Color', 'pgs-core' ),
			'param_name'       => 'button_hover_text_color',
			'description'      => esc_html__( 'Select button text hover color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
			'dependency'       => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Hover Background Color', 'pgs-core' ),
			'param_name'       => 'button_hover_background_color',
			'description'      => esc_html__( 'Select button hover background color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'flat' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Button Hover Border Color', 'pgs-core' ),
			'param_name'       => 'button_hover_border_color',
			'description'      => esc_html__( 'Select button hover border color.', 'pgs-core' ),
			'group'            => esc_html__( 'Button', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'button_style',
				'value'   => array( 'border' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Button Border Width', 'pgs-core' ),
			'param_name'  => 'button_border_width',
			'min'         => 1,
			'max'         => 15,
			'value'       => 1,
			'suffix'      => 'px',
			'description' => esc_html__( 'Enter/select button border width.', 'pgs-core' ),
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'button_style',
				'value'   => array( 'border' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'button_text_transform',
			'heading'     => esc_html__( 'Text Transform', 'pgs-core' ),
			'description' => esc_html__( 'Select text transformation.', 'pgs-core' ),
			'value'       => array_flip(
				array(
					''           => esc_html__( 'Select Text Transform', 'pgs-core' ),
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
					'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
					'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
					'initial'    => esc_html__( 'Initial', 'pgs-core' ),
					'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
					'unset'      => esc_html__( 'Unset', 'pgs-core' ),
				)
			),
			'std'         => '',
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Letter Spacing', 'pgs-core' ),
			'param_name'  => 'button_letter_spacing',
			'min'         => 0,
			'max'         => 100,
			'value'       => 0,
			'suffix'      => 'px',
			'description' => esc_html__( 'Enter/select letter spacing.', 'pgs-core' ),
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Line Height', 'pgs-core' ),
			'param_name'  => 'button_line_height',
			'description' => esc_html__( 'Enter line height i.e. 10px, 1em, or 100%. If you want to add value in decimal like ".5em", then use complete decimal format like "0.5em". Allowed units are px, em, and %.', 'pgs-core' ),
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'URL (Link)', 'pgs-core' ),
			'param_name'  => 'link_url',
			'description' => esc_html__( 'Add custom link.', 'pgs-core' ),
			'group'       => esc_html__( 'Button', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'banner_link_enable',
				'value_not_equal_to' => 'true',
			),
		),

		// Badge
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Add Badge', 'pgs-core' ),
			'param_name'  => 'add_badge',
			'description' => esc_html__( 'Select this checkbox to add badge.', 'pgs-core' ),
			'group'       => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => 'style-1',
			),
		),
		array(
			'type'             => 'textfield',
			'param_name'       => 'badge_title',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'description'      => esc_html__( 'Add badge title.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-9',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'badge_type',
			'heading'          => esc_html__( 'Badge Type', 'pgs-core' ),
			'description'      => esc_html__( 'Select badge style.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'border' => esc_html__( 'Border', 'pgs-core' ),
					'flat'   => esc_html__( 'Flat', 'pgs-core' ),
				)
			),
			'std'              => 'border',
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-3',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Text Color', 'pgs-core' ),
			'param_name'       => 'badge_text_color',
			'description'      => esc_html__( 'Select badge text color.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'value'            => '#323232',
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
			'param_name'       => 'badge_background_color',
			'description'      => esc_html__( 'Select badge background color.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'value'            => '#ffffff',
			'dependency'       => array(
				'element' => 'badge_type',
				'value'   => array( 'flat' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'       => 'pgscore_divider',
			'param_name' => 'badge_border_fields_divider',
			'group'      => esc_html__( 'Badge', 'pgs-core' ),
			'dependency' => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Badge Border Width', 'pgs-core' ),
			'param_name'       => 'badge_border_width',
			'min'              => 1,
			'max'              => 15,
			'value'            => 1,
			'suffix'           => 'px',
			'description'      => esc_html__( 'Enter/select badge border width.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
			'dependency'       => array(
				'element' => 'badge_type',
				'value'   => array( 'border' ),
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Border Color', 'pgs-core' ),
			'param_name'       => 'badge_border_color',
			'description'      => esc_html__( 'Select badge border color.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'value'            => '#323232',
			'dependency'       => array(
				'element' => 'badge_type',
				'value'   => array( 'border' ),
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Badge Width', 'pgs-core' ),
			'param_name'       => 'badge_width',
			'min'              => 10,
			'max'              => 200,
			'value'            => 70,
			'suffix'           => 'px',
			'description'      => esc_html__( 'Enter/select badge width.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Badge Height', 'pgs-core' ),
			'param_name'       => 'badge_height',
			'min'              => 10,
			'max'              => 200,
			'value'            => 70,
			'suffix'           => 'px',
			'description'      => esc_html__( 'Enter/select badge height.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Vertical Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set badge vertical position.', 'pgs-core' ),
			'param_name'       => 'badge_vertical_align',
			'value'            => array_flip(
				array(
					'vtop'    => esc_html__( 'Top', 'pgs-core' ),
					'vmiddle' => esc_html__( 'Middle', 'pgs-core' ),
					'vbottom' => esc_html__( 'Bottom', 'pgs-core' ),
				)
			),
			'std'              => 'vbottom',
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Horizontal Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set badge horizontal position.', 'pgs-core' ),
			'param_name'       => 'badge_horizontal_align',
			'value'            => array_flip(
				array(
					'hleft'   => esc_html__( 'Left', 'pgs-core' ),
					'hcenter' => esc_html__( 'Center', 'pgs-core' ),
					'hright'  => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'              => 'hright',
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Font Size', 'pgs-core' ),
			'param_name'       => 'badge_font_size',
			'min'              => 10,
			'max'              => 100,
			'value'            => 20,
			'suffix'           => 'px',
			'description'      => esc_html__( 'Enter/select font size.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Line Height', 'pgs-core' ),
			'param_name'       => 'badge_line_height',
			'min'              => 0,
			'max'              => 100,
			'suffix'           => 'px',
			'description'      => esc_html__( 'Enter/select line height.', 'pgs-core' ),
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'badge_font_weight',
			'heading'          => esc_html__( 'Font Weight', 'pgs-core' ),
			'description'      => esc_html__( 'Select font weight.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					''        => esc_html__( 'Select Font Weight', 'pgs-core' ),
					'normal'  => esc_html__( 'Normal', 'pgs-core' ),
					'bold'    => esc_html__( 'Bold', 'pgs-core' ),
					'bolder'  => esc_html__( 'Bolder', 'pgs-core' ),
					'lighter' => esc_html__( 'Lighter', 'pgs-core' ),
					'100'     => esc_html__( '100', 'pgs-core' ),
					'200'     => esc_html__( '200', 'pgs-core' ),
					'300'     => esc_html__( '300', 'pgs-core' ),
					'400'     => esc_html__( '400', 'pgs-core' ),
					'500'     => esc_html__( '500', 'pgs-core' ),
					'600'     => esc_html__( '600', 'pgs-core' ),
					'700'     => esc_html__( '700', 'pgs-core' ),
					'800'     => esc_html__( '800', 'pgs-core' ),
					'900'     => esc_html__( '900', 'pgs-core' ),
					'initial' => esc_html__( 'Initial', 'pgs-core' ),
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
				)
			),
			'std'              => '600',
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'badge_text_transform',
			'heading'          => esc_html__( 'Text Transform', 'pgs-core' ),
			'description'      => esc_html__( 'Select text transformation.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					''           => esc_html__( 'Select Text Transform', 'pgs-core' ),
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
					'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
					'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
					'initial'    => esc_html__( 'Initial', 'pgs-core' ),
					'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
					'unset'      => esc_html__( 'Unset', 'pgs-core' ),
				)
			),
			'std'              => '',
			'group'            => esc_html__( 'Badge', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'add_badge',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'        => 'pgscore_datepicker',
			'class'       => '',
			'heading'     => esc_html__( 'Deal Date', 'pgs-core' ),
			'param_name'  => 'deal_date',
			'value'       => '',
			'description' => esc_html__( 'Enter deal date.', 'pgs-core' ),
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'deal-1', 'deal-2' ),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Expire Message', 'pgs-core' ),
			'param_name'  => 'expire_message',
			'value'       => esc_html__( 'This offer has expired!', 'pgs-core' ),
			'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'deal-1', 'deal-2' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Counter Size', 'pgs-core' ),
			'description' => esc_html__( 'Select deal counter size.', 'pgs-core' ),
			'param_name'  => 'counter_size',
			'value'       => array_flip(
				array(
					'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
					'sm' => esc_html__( 'Small', 'pgs-core' ),
					'md' => esc_html__( 'Medium', 'pgs-core' ),
					'lg' => esc_html__( 'Large', 'pgs-core' ),
				)
			),
			'std'         => 'sm',
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'deal-2' ),
			),
		),
		array(
			'type'        => 'pgscore_radio_image',
			'heading'     => esc_html__( 'Counter Style', 'pgs-core' ),
			'description' => esc_html__( 'Select deal counter style.', 'pgs-core' ),
			'param_name'  => 'counter_style',
			'options'     => array(
				'style-1'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_1.jpg',
				'style-2'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_2.jpg',
				'style-3'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_3.jpg',
				'style-4'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_4.jpg',
				'style-5'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_5.jpg',
				'style-6'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_6.jpg',
				'style-7'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_7.jpg',
				'style-8'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_8.jpg',
				'style-9'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_9.jpg',
				'style-10' => PGSCORE_URL . 'images/shortcodes/banner/deal/style_10.jpg',
			),
			'show_label'  => true,
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'deal-1' ),
			),
		),
		array(
			'type'             => 'css_editor',
			'heading'          => esc_html__( 'Deal Padding', 'pgs-core' ),
			'param_name'       => 'deal_css',
			'group'            => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'style',
				'value'   => array( 'deal-1', 'deal-2' ),
			),
			'edit_field_class' => 'vc_col-sm-12 vc_col-sm-6 vc_col-md-5 vc_col-lg-3 banner_css_wrap',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'On Expire Button?', 'pgs-core' ),
			'description' => esc_html__( 'Select status of button on deal expire.', 'pgs-core' ),
			'param_name'  => 'on_expire_btn',
			'value'       => array_flip(
				array(
					'disable' => esc_html__( 'Disable', 'pgs-core' ),
					'remove'  => esc_html__( 'Remove', 'pgs-core' ),
				)
			),
			'std'         => 'disable',
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'deal-1', 'deal-2' ),
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'pgs-core' ),
			'param_name' => 'element_css',
			'group'      => esc_html__( 'Design Options', 'pgs-core' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'ID', 'pgs-core' ),
			'param_name'  => 'element_id',
			'description' => sprintf(
				wp_kses(
					/* translators: $s: link */
					__( 'Enter ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>)', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.w3schools.com/tags/att_global_id.asp'
			)
				. '<br><span class="pgs-core-red">' .
				sprintf(
					wp_kses(
						/* translators: $s: shortcode tag */
						__( 'Important : If ID starts with number, it will be prefixed with "%s".', 'pgs-core' ),
						array(
							'atrong' => true,
						)
					),
					'<strong>' . $shortcode_tag . '_' . '</strong>'
				)
				. '</span>',
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'pgs-core' ),
			'param_name'  => 'element_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pgs-core' ),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
	);

	$wp_scripts_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Params
	$params = array(
		'name'                    => esc_html__( 'Banner', 'pgs-core' ),
		'description'             => esc_html__( 'Display Banner.', 'pgs-core' ),
		'base'                    => $shortcode_tag,
		'class'                   => 'pgscore_element_wrapper',
		'controls'                => 'full',
		'icon'                    => PGSCORE_URL . '/images/vc-icon.png',
		'category'                => esc_html__( 'Potenza Core', 'pgs-core' ),
		'show_settings_on_create' => true,
		'params'                  => $shortcode_fields,
		'front_enqueue_js'        => array(
			includes_url( "/wp-includes/js/jquery/ui/core$wp_scripts_suffix.js" ),
			includes_url( "/js/jquery/ui/datepicker$wp_scripts_suffix.js" ),
		),
	);

	vc_map( $params );
}
