<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_counter
 *
 ******************************************************************************/
function pgscore_shortcode_counter( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(

		// Content
		'counter_style'                => 'style_1',
		'counter_alighnment'           => 'center',
		'counter_title'                => '',
		'counter_title_font_size'      => 20,
		'counter_title_font_style'     => 'inherit',
		'counter_title_font_weight'    => 'inherit',
		'counter_title_text_transform' => 'inherit',
		'counter_number'               => 70,
		'counter_number_font_size'     => 20,
		'counter_number_font_style'    => 'inherit',
		'counter_number_font_weight'   => 'inherit',
		'counter_title_color'          => '#969696',
		'counter_number_color'         => '#323232',
		'counter_icon_color'           => '#04d39f',

		'counter_icon_background'      => 'background',
		'counter_background_color'     => '#04d39f',
		'counter_border_color'         => '#04d39f',
		'counter_icon_position'        => 'left',

		'use_google_font'              => '',
		'counter_google_fonts'         => '',
		'google_font_enqueue_source'   => 'default',

		'counter_icon_disable'         => '',

		// Icon - Source
		'counter_icon_source'          => 'font', // font, image
		'counter_icon_size'            => 'md',
		// Icon - Type            = Image
		'icon_image'                   => '',

		// Icon - Type            = Font
		'icon_type'                    => 'fontawesome',
		'icon_fontawesome'             => 'fas fa-adjust',
		'icon_openiconic'              => 'vc-oi vc-oi-dial',
		'icon_typicons'                => 'typcn typcn-chevron-right',
		'icon_entypo'                  => 'entypo-icon entypo-icon-note',
		'icon_linecons'                => 'vc_li vc_li-heart',
		'icon_monosocial'              => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'                => 'vc-material vc-material-cake',
		'icon_pixelicons'              => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'                => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'                 => 'ti-arrow-up',

		'element_css'                  => '',
		'element_id'                   => '',
		'element_class'                => '',
		'shortcode_handle'             => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html    = $icon_class = '';
	$icon_wrapper = false;

	if ( isset( $counter_icon_source ) && 'font' == $counter_icon_source ) {
		$current_icon = 'icon_' . $icon_type;

		if ( isset( ${$current_icon} ) && ! empty( ${$current_icon} ) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${$current_icon};
		}
	}

	if ( ! $counter_icon_disable ) {

		if ( isset( $counter_icon_source ) && 'font' == $counter_icon_source ) {

			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_style = '';
				if ( isset( $counter_icon_color ) && ! empty( $counter_icon_color ) ) {
					$icon_style = ' style="color:' . esc_attr( $counter_icon_color ) . ';"';
				}
				$icon_html = '<i class="' . esc_attr( $icon_class ) . '"' . $icon_style . '></i>';
			}

			// Enqueue icon CSS for icon type
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				if ( $icon_type !== 'fontawesome' ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
			}
		} elseif ( isset( $counter_icon_source ) && 'image' == $counter_icon_source ) {
			if ( ! empty( $icon_image ) ) {
				$icon_image_size = array(
					'xs' => array( 16, 16 ),
					'sm' => array( 20, 20 ),
					'md' => array( 24, 24 ),
					'lg' => array( 28, 28 ),
				);

				$banner_image = wp_get_attachment_image_src( $icon_image, 'pgscore-thumbnail-80' );
				if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
					$icon_html = '<img class="ciyashop-lazy-load" src="' . esc_url( $banner_image[0] ) . '" data-src="' . esc_url( $banner_image[0] ) . '">';
				} else {
					$icon_html = '<img src="' . esc_url( $banner_image[0] ) . '">';
				}
			}
		}
	}

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']      = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['icon_html'] = $icon_html;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>">
		<!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'counter/content' ); ?>
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
	$icon_picker     = array();
	$pgs_icon_picker = array();

	$icon_picker = pgscore_iconpicker(
		array(
			'dependency' => array(
				'element' => 'counter_icon_source',
				'value'   => 'font',
			),
			'group'      => esc_html__( 'Icon', 'pgs-core' ),
		)
	);
	if ( ! empty( $icon_picker ) ) {
		foreach ( $icon_picker as $icon_p ) {
			$pgs_icon_picker[] = $icon_p;
		}
	}

	$shortcode_fields = array_merge(
		array(
			/*---------------------------- Content ----------------------------*/
			array(
				'type'        => 'pgscore_radio_image',
				'heading'     => esc_html__( 'Style', 'pgs-core' ),
				'param_name'  => 'counter_style',
				'description' => 'Select Counter Style.',
				'options'     => array(
					'style_1' => PGSCORE_URL . 'images/shortcodes/counter/style1.jpg',
					'style_2' => PGSCORE_URL . 'images/shortcodes/counter/style2.jpg',
					'style_3' => PGSCORE_URL . 'images/shortcodes/counter/style3.jpg',
					'style_4' => PGSCORE_URL . 'images/shortcodes/counter/style4.jpg',
				),
				'show_label'  => true,
				'admin_label' => true,
				'std'         => 'style_1',
			),
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'       => 'counter_icon_disable',
				'value'            => array(
					esc_html__( 'Disable?', 'pgs-core' ) => 'true',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'pgscore_radio',
				'param_name'       => 'counter_icon_position',
				'heading'          => esc_html__( 'Icon Position', 'pgs-core' ),
				'description'      => esc_html__( 'Select Icon Position.', 'pgs-core' ),
				'class'            => 'pgscore_radio_label_only',
				'std'              => 'left',
				'value'            => array_flip(
					array(
						'left'  => '<i class="dashicons dashicons-editor-outdent"></i>',
						'right' => '<i class="dashicons dashicons-editor-indent"></i>',
					)
				),
				'dependency'       => array(
					'element' => 'counter_style',
					'value'   => 'style_4',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'pgscore_radio',
				'param_name'       => 'counter_alighnment',
				'heading'          => esc_html__( 'Counter Alignment', 'pgs-core' ),
				'value'            => array_flip(
					array(
						'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
						'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
						'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
					)
				),
				'std'              => 'center',
				'class'            => 'pgscore_radio_label_only',
				'description'      => __( 'Select counter alignment.', 'pgs-core' ),
				'save_always'      => true,
				'dependency'       => array(
					'element' => 'counter_style',
					'value'   => array( 'style_1', 'style_2', 'style_3' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'counter_title',
				'heading'     => esc_html__( 'Counter Title', 'pgs-core' ),
				'description' => esc_html__( 'Enter Counter title.', 'pgs-core' ),
				'admin_label' => true,
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),

			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Use google fonts ?', 'pgs-core' ),
				'param_name'  => 'use_google_font',
				'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
				'description' => esc_html__( 'Select this checkbox to use google fonts.', 'pgs-core' ),
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'       => 'google_fonts',
				'param_name' => 'counter_google_fonts',
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
				'group'      => esc_html__( 'Content', 'pgs-core' ),
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
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'counter_title_color',
				'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Title color.', 'pgs-core' ),
				'value'            => '#969696',
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'pgscore_number_min_max',
				'heading'          => esc_html__( 'Counter Title Font Size', 'pgs-core' ),
				'description'      => esc_html__( 'Enter Counter Title Font Size between 14 to 50.', 'pgs-core' ),
				'min'              => 20,
				'max'              => 50,
				'value'            => 20,
				'param_name'       => 'counter_title_font_size',
				'suffix'           => 'px',
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_title_font_style',
				'heading'          => esc_html__( 'Counter Title Font Styles', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Title Font Style.', 'pgs-core' ),
				'std'              => 'inherit',
				'value'            => array_flip(
					array(
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'italic'  => esc_html__( 'Italic', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_title_font_weight',
				'heading'          => esc_html__( 'Counter Title Font Weights', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Title Font Weight.', 'pgs-core' ),
				'std'              => 'inherit',
				'value'            => array_flip(
					array(
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'normal'  => esc_html__( 'Normal', 'pgs-core' ),
						'400'     => esc_html__( '400', 'pgs-core' ),
						'500'     => esc_html__( '500', 'pgs-core' ),
						'700'     => esc_html__( '700', 'pgs-core' ),
						'900'     => esc_html__( '900', 'pgs-core' ),
						'bold'    => esc_html__( 'Bold', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_title_text_transform',
				'heading'          => esc_html__( 'Counter Title Text Transform', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Title Text Transform.', 'pgs-core' ),
				'std'              => 'inherit',
				'value'            => array_flip(
					array(
						'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
						'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
						'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
						'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'pgscore_number_min_max',
				'heading'          => esc_html__( 'Counter Number', 'pgs-core' ),
				'min'              => 1,
				'max'              => 1000000,
				'value'            => 70,
				'param_name'       => 'counter_number',
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

			array(
				'type'             => 'pgscore_number_min_max',
				'heading'          => esc_html__( 'Counter Number Font Size', 'pgs-core' ),
				'description'      => esc_html__( 'Enter Counter Number Font Size between 14 to 50.', 'pgs-core' ),
				'min'              => 20,
				'max'              => 50,
				'value'            => 20,
				'param_name'       => 'counter_number_font_size',
				'suffix'           => 'px',
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_number_font_style',
				'heading'          => esc_html__( 'Counter Number Font Styles', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Number Font Style.', 'pgs-core' ),
				'std'              => 'inherit',
				'value'            => array_flip(
					array(
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'italic'  => esc_html__( 'Italic', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_number_font_weight',
				'heading'          => esc_html__( 'Counter Number Font Weights', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Number Font Weight.', 'pgs-core' ),
				'std'              => 'inherit',
				'value'            => array_flip(
					array(
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'normal'  => esc_html__( 'Normal', 'pgs-core' ),
						'400'     => esc_html__( '400', 'pgs-core' ),
						'500'     => esc_html__( '500', 'pgs-core' ),
						'700'     => esc_html__( '700', 'pgs-core' ),
						'900'     => esc_html__( '900', 'pgs-core' ),
						'bold'    => esc_html__( 'Bold', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'counter_number_color',
				'heading'          => esc_html__( 'Number Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Number color.', 'pgs-core' ),
				'value'            => '#323232',
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'param_name'       => 'counter_icon_background',
				'heading'          => esc_html__( 'Counter Icon Background', 'pgs-core' ),
				'description'      => esc_html__( 'Select Icon Background/Border.', 'pgs-core' ),
				'std'              => 'background',
				'value'            => array_flip(
					array(
						'background' => esc_html__( 'Background', 'pgs-core' ),
						'border'     => esc_html__( 'Border', 'pgs-core' ),
					)
				),
				'dependency'       => array(
					'element' => 'counter_style',
					'value'   => 'style_2',
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'counter_background_color',
				'heading'          => esc_html__( 'Counter Background Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Background Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'counter_icon_background',
					'value'   => 'background',
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'counter_border_color',
				'heading'          => esc_html__( 'Counter Border Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Counter Border Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'counter_icon_background',
					'value'   => 'border',
				),
				'group'            => esc_html__( 'Content', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Source', 'pgs-core' ),
				'param_name'       => 'counter_icon_source',
				'value'            => array_flip(
					array(
						'font'  => esc_html__( 'Font', 'pgs-core' ),
						'image' => esc_html__( 'Image', 'pgs-core' ),
					)
				),
				'std'              => 'font',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'dependency'       => array(
					'element'            => 'counter_icon_disable',
					'value_not_equal_to' => 'true',
				),
				'class'            => 'pgscore_radio_label_only',
				'admin_label'      => true,
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Size', 'pgs-core' ),
				'param_name'       => 'counter_icon_size',
				'description'      => esc_html__( 'Select icon size.', 'pgs-core' ),
				'value'            => array_flip(
					array(
						'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
						'sm' => esc_html__( 'Small', 'pgs-core' ),
						'md' => esc_html__( 'Medium', 'pgs-core' ),
						'lg' => esc_html__( 'Large', 'pgs-core' ),
						'xl' => esc_html__( 'Extra Large', 'pgs-core' ),
					)
				),
				'std'              => 'md',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'element' => 'counter_icon_source',
					'value'   => 'font',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'counter_icon_color',
				'heading'          => esc_html__( 'Icon Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select icon color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'counter_icon_source',
					'value'   => 'font',
				),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type'             => 'attach_image',
				'param_name'       => 'icon_image',
				'heading'          => esc_html__( 'Icon Image', 'pgs-core' ),
				'description'      => esc_html__( 'Upload/select icon image.', 'pgs-core' ),
				'tooltip'          => esc_html__( 'We recommended upload image size 80x80', 'pgs-core' ),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array(
					'element' => 'counter_icon_source',
					'value'   => 'image',
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
		),
		$pgs_icon_picker
	);

	// Params
	$params = array(
		'name'                    => esc_html__( 'Counter', 'pgs-core' ),
		'description'             => esc_html__( 'Add Counter Section.', 'pgs-core' ),
		'base'                    => $shortcode_tag,
		'class'                   => 'pgscore_element_wrapper',
		'controls'                => 'full',
		'icon'                    => PGSCORE_URL . '/images/vc-icon.png',
		'category'                => esc_html__( 'Potenza Core', 'pgs-core' ),
		'show_settings_on_create' => true,
		'params'                  => $shortcode_fields,
	);
	vc_map( $params );
}
