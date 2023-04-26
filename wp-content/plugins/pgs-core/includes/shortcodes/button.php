<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_button
 *
 ******************************************************************************/
function pgscore_shortcode_button( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'button_type'                    => 'default',
		'button_link'                    => '',
		'button_background_color'        => '#04d39f',
		'button_text_color'              => '#ffffff',

		'button_background_hover_color'  => '#323232',
		'button_text_hover_color'        => '#ffffff',

		'button_border_color'            => '#04d39f',
		'button_border_hover_color'      => '#323232',

		'button_border_background_color' => '',

		'button_border'                  => 'square',
		'button_width'                   => 'default',
		'button_size'                    => 'medium',
		'button_font_weight'             => 'inherit',
		'button_underline'               => '',

		'use_google_font'                => '',
		'banner_google_fonts'            => '',
		'google_font_enqueue_source'     => 'default',

		// Icon
		'button_icon'                    => '',

		// Icon - Source
		'button_icon_position'           => 'left',
		// Icon - Type            = Image
		'icon_image'                     => '',

		// Icon - Type            = Font
		'icon_type'                      => 'fontawesome',
		'icon_fontawesome'               => 'fas fa-adjust',
		'icon_openiconic'                => 'vc-oi vc-oi-dial',
		'icon_typicons'                  => 'typcn typcn-adjust-brightness',
		'icon_entypo'                    => 'entypo-icon entypo-icon-note',
		'icon_linecons'                  => 'vc_li vc_li-heart',
		'icon_monosocial'                => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'                  => 'vc-material vc-material-cake',
		'icon_pixelicons'                => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'                  => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'                   => 'ti-arrow-up',

		'element_css'                    => '',
		'element_id'                     => '',
		'element_class'                  => '',
		'shortcode_handle'               => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );
	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html    = '';
	$icon_class   = '';
	$icon_wrapper = false;

	if ( isset( $button_icon ) ) {
		$current_icon = 'icon_' . $icon_type;

		if ( isset( ${$current_icon} ) && ! empty( ${$current_icon} ) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${$current_icon};
		}
	}

	if ( $button_icon ) {

		if ( $icon_wrapper ) {
			$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
		} else {
			$icon_html = '<i class="' . esc_attr( $icon_class ) . '"></i>';
		}

		// Enqueue icon CSS for icon type
		if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
			if ( 'fontawesome' !== $icon_type ) {
				vc_icon_element_fonts_enqueue( $icon_type );
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
	$button_classes                                       = 'pgscore_button_width_' . $button_width;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="
		<?php
		pgscore_element_classes( $atts );
		echo ' ' . $button_classes;
		?>
	"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'button/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/
if ( function_exists( 'vc_map' ) ) {

	$icon_picker     = array();
	$pgs_icon_picker = array();

	$icon_picker = pgscore_iconpicker(
		array(
			'dependency' => array(
				'element' => 'button_icon',
				'value'   => 'true',
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
			array(
				'type'        => 'pgscore_radio_image',
				'param_name'  => 'button_type',
				'heading'     => esc_html__( 'Button Type', 'pgs-core' ),
				'description' => esc_html__( 'Select Button Type.', 'pgs-core' ),
				'options'     => array(
					'default' => PGSCORE_URL . 'images/shortcodes/button/default-btn.jpg',
					'border'  => PGSCORE_URL . 'images/shortcodes/button/border-btn.jpg',
					'link'    => PGSCORE_URL . 'images/shortcodes/button/link.jpg',
				),
				'show_label'  => true,
				'admin_label' => true,
				'std'         => 'default',
			),
			array(
				'type'        => 'vc_link',
				'class'       => '',
				'heading'     => __( 'Title & Link', 'pgs-core' ),
				'param_name'  => 'button_link',
				'description' => esc_html__( 'Enter button title and link.', 'pgs-core' ),
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
				'type'             => 'colorpicker',
				'param_name'       => 'button_background_color',
				'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Background Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'button_type',
					'value'   => array( 'default' ),
				),
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_background_hover_color',
				'heading'          => esc_html__( 'Background Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Background Hover Color.', 'pgs-core' ),
				'value'            => '#323232',
				'dependency'       => array(
					'element' => 'button_type',
					'value'   => array( 'default' ),
				),
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_text_color',
				'heading'          => esc_html__( 'Text Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Button Text color.', 'pgs-core' ),
				'value'            => '#ffffff',
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_text_hover_color',
				'heading'          => esc_html__( 'Text Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Button Hover Text color.', 'pgs-core' ),
				'value'            => '#ffffff',
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_border_color',
				'heading'          => esc_html__( 'Border Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Border Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'button_type',
					'value'   => array( 'border' ),
				),
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_border_hover_color',
				'heading'          => esc_html__( 'Border Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Border Hover Color.', 'pgs-core' ),
				'value'            => '#323232',
				'dependency'       => array(
					'element' => 'button_type',
					'value'   => array( 'border' ),
				),
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'button_border_background_color',
				'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select background Color.', 'pgs-core' ),
				'dependency'       => array(
					'element' => 'button_type',
					'value'   => array( 'border' ),
				),
				'group'            => esc_html__( 'Custom Color', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'button_border',
				'heading'     => esc_html__( 'Border Shape', 'pgs-core' ),
				'description' => esc_html__( 'Select Border Shape.', 'pgs-core' ),
				'std'         => 'square',
				'value'       => array_flip(
					array(
						'square'  => esc_html__( 'Square', 'pgs-core' ),
						'round'   => esc_html__( 'Round', 'pgs-core' ),
						'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					)
				),
				'dependency'  => array(
					'element' => 'button_type',
					'value'   => array( 'default', 'border' ),
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'button_width',
				'heading'     => esc_html__( 'Button Width', 'pgs-core' ),
				'description' => esc_html__( 'Select Button Width.', 'pgs-core' ),
				'std'         => 'default',
				'value'       => array_flip(
					array(
						'default' => esc_html__( 'Default', 'pgs-core' ),
						'full'    => esc_html__( 'Full', 'pgs-core' ),
					)
				),
				'dependency'  => array(
					'element' => 'button_type',
					'value'   => array( 'default', 'border' ),
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'button_size',
				'heading'     => esc_html__( 'Button Size', 'pgs-core' ),
				'description' => esc_html__( 'Select Button Size.', 'pgs-core' ),
				'std'         => 'medium',
				'value'       => array_flip(
					array(
						'small'  => esc_html__( 'Small', 'pgs-core' ),
						'medium' => esc_html__( 'Medium', 'pgs-core' ),
						'large'  => esc_html__( 'Large', 'pgs-core' ),
						'extra'  => esc_html__( 'Extra Large', 'pgs-core' ),
					)
				),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'button_font_weight',
				'heading'     => esc_html__( 'Button Font Weight', 'pgs-core' ),
				'description' => esc_html__( 'Select Font Size.', 'pgs-core' ),
				'std'         => 'inherit',
				'value'       => array_flip(
					array(
						'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
						'bold'    => esc_html__( 'Bold', 'pgs-core' ),
						'normal'  => esc_html__( 'Normal', 'pgs-core' ),
					)
				),
				'dependency'  => array(
					'element' => 'button_type',
					'value'   => array( 'link' ),
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Button Underline', 'pgs-core' ),
				'param_name' => 'button_underline',
				'value'      => array(
					esc_html__( 'Enable?', 'pgs-core' ) => 'true',
				),
				'dependency' => array(
					'element' => 'button_type',
					'value'   => array( 'link' ),
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Icon', 'pgs-core' ),
				'param_name' => 'button_icon',
				'group'      => esc_html__( 'Icon', 'pgs-core' ),
				'value'      => array(
					esc_html__( 'Enable?', 'pgs-core' ) => 'true',
				),
			),
			array(
				'type'        => 'pgscore_radio',
				'param_name'  => 'button_icon_position',
				'heading'     => esc_html__( 'Icon Position', 'pgs-core' ),
				'description' => esc_html__( 'Select Icon Position.', 'pgs-core' ),
				'class'       => 'pgscore_radio_label_only',
				'std'         => 'left',
				'value'       => array_flip(
					array(
						'left'  => '<i class="dashicons dashicons-editor-outdent"></i>',
						'right' => '<i class="dashicons dashicons-editor-indent"></i>',
					)
				),
				'dependency'  => array(
					'element' => 'button_icon',
					'value'   => 'true',
				),
				'group'       => esc_html__( 'Icon', 'pgs-core' ),
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

		),
		$pgs_icon_picker
	);

	// Params
	$params = array(
		'name'                    => esc_html__( 'Button', 'pgs-core' ),
		'description'             => esc_html__( 'Display Button.', 'pgs-core' ),
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
