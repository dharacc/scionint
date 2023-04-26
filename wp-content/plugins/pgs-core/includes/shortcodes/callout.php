<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_callout
 *
 ******************************************************************************/
function pgscore_shortcode_callout( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'callout_title'                         => '',
		'callout_title_element_tag'             => 'h3',
		'callout_description'                   => '',
		'callout_title_color'                   => '#323232',
		'callout_button_title'                  => '',
		'callout_button_link'                   => '',
		'callout_button_type'                   => 'default',
		'callout_button_text_color'             => '#323232',
		'callout_button_text_hover_color'       => '#04d39f',
		'callout_button_background_color'       => '#04d39f',
		'callout_button_background_hover_color' => '#323232',
		'callout_button_border_color'           => '#04d39f',
		'callout_button_border_hover_color'     => '#323232',
		'callout_icon_color'                    => '#323232',
		'callout_icon_size'                     => 'md',
		// Icon
		'callout_icon'                          => '',

		// Icon - Source
		'callout_icon_source'                   => 'font', // font, image

		// Icon - Type            = Image
		'icon_image'                            => '',

		// Icon - Type            = Font
		'icon_type'                             => 'fontawesome',
		'icon_fontawesome'                      => 'fas fa-adjust',
		'icon_openiconic'                       => 'vc-oi vc-oi-dial',
		'icon_typicons'                         => 'typcn typcn-chevron-right',
		'icon_entypo'                           => 'entypo-icon entypo-icon-note',
		'icon_linecons'                         => 'vc_li vc_li-heart',
		'icon_monosocial'                       => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'                         => 'vc-material vc-material-cake',
		'icon_pixelicons'                       => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'                         => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'                          => 'ti-arrow-up',

		'element_css'                           => '',
		'element_id'                            => '',
		'element_class'                         => '',
		'shortcode_handle'                      => $shortcode_handle,
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

	if ( isset( $callout_icon_source ) && 'font' == $callout_icon_source ) {
		$current_icon = 'icon_' . $icon_type;

		if ( isset( ${$current_icon} ) && ! empty( ${$current_icon} ) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${$current_icon};
		}
	}

	if ( $callout_icon ) {

		if ( isset( $callout_icon_source ) && 'font' == $callout_icon_source ) {

			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_style = '';
				if ( isset( $callout_icon_color ) && ! empty( $callout_icon_color ) ) {
					$icon_style = ' style="color:' . esc_attr( $callout_icon_color ) . ';"';
				}
				$icon_html = '<i class="' . esc_attr( $icon_class ) . '"' . $icon_style . '></i>';
			}

			// Enqueue icon CSS for icon type
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				if ( 'fontawesome' !== $icon_type ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
			}
		} elseif ( isset( $callout_icon_source ) && 'image' == $callout_icon_source ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['content']   = $content;

	ob_start(); ?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'callout/content' ); ?>
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
				'element' => 'callout_icon_source',
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
			array(
				'type'        => 'textfield',
				'param_name'  => 'callout_title',
				'heading'     => esc_html__( 'Title', 'pgs-core' ),
				'description' => esc_html__( 'Enter Callout Title.', 'pgs-core' ),
				'admin_label' => true,
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'callout_title_color',
				'heading'     => esc_html__( 'Title Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'value'       => '#323232',
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'callout_title_element_tag',
				'heading'     => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'description' => esc_html__( 'Select Title Element Tag.', 'pgs-core' ),
				'std'         => 'h3',
				'value'       => array_flip(
					array(
						'h2' => esc_html__( 'H2', 'pgs-core' ),
						'h3' => esc_html__( 'H3', 'pgs-core' ),
						'h4' => esc_html__( 'H4', 'pgs-core' ),
						'h5' => esc_html__( 'H5', 'pgs-core' ),
						'h6' => esc_html__( 'H6', 'pgs-core' ),
					)
				),
			),
			array(
				'type'        => 'textarea',
				'param_name'  => 'callout_description',
				'heading'     => esc_html__( 'Description', 'pgs-core' ),
				'description' => esc_html__( 'Enter Description.', 'pgs-core' ),
			),
			array(
				'type'       => 'vc_link',
				'class'      => '',
				'heading'    => __( 'Link', 'pgs-core' ),
				'param_name' => 'callout_button_link',
				'group'      => esc_html__( 'Button', 'pgs-core' ),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'callout_button_type',
				'heading'     => esc_html__( 'Button Type', 'pgs-core' ),
				'description' => esc_html__( 'Select Button Type.', 'pgs-core' ),
				'group'       => esc_html__( 'Button', 'pgs-core' ),
				'std'         => 'default',
				'value'       => array_flip(
					array(
						'default' => esc_html__( 'Default', 'pgs-core' ),
						'border'  => esc_html__( 'Border', 'pgs-core' ),
						'simple'  => esc_html__( 'Simple Link', 'pgs-core' ),
					)
				),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_background_color',
				'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Background Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'callout_button_type',
					'value'   => array( 'default' ),
				),
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_background_hover_color',
				'heading'          => esc_html__( 'Background Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Background Hover Color.', 'pgs-core' ),
				'value'            => '#323232',
				'dependency'       => array(
					'element' => 'callout_button_type',
					'value'   => array( 'default' ),
				),
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_border_color',
				'heading'          => esc_html__( 'Border Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Border Color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'dependency'       => array(
					'element' => 'callout_button_type',
					'value'   => array( 'border' ),
				),
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_border_hover_color',
				'heading'          => esc_html__( 'Border Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Border Hover Color.', 'pgs-core' ),
				'value'            => '#323232',
				'dependency'       => array(
					'element' => 'callout_button_type',
					'value'   => array( 'border' ),
				),
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_text_color',
				'heading'          => esc_html__( 'Text Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Text color.', 'pgs-core' ),
				'value'            => '#323232',
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'callout_button_text_hover_color',
				'heading'          => esc_html__( 'Text Hover Color', 'pgs-core' ),
				'description'      => esc_html__( 'Select Text Hover color.', 'pgs-core' ),
				'value'            => '#04d39f',
				'group'            => esc_html__( 'Button', 'pgs-core' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Icon', 'pgs-core' ),
				'param_name' => 'callout_icon',
				'group'      => esc_html__( 'Icon', 'pgs-core' ),
				'value'      => array(
					esc_html__( 'Enable?', 'pgs-core' ) => 'true',
				),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Source', 'pgs-core' ),
				'param_name'       => 'callout_icon_source',
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
					'element' => 'callout_icon',
					'value'   => 'true',
				),
				'class'            => 'pgscore_radio_label_only',
				'admin_label'      => true,
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'callout_icon_color',
				'heading'     => esc_html__( 'Icon Color', 'pgs-core' ),
				'description' => esc_html__( 'Select icon color.', 'pgs-core' ),
				'value'       => '#323232',
				'dependency'  => array(
					'element' => 'callout_icon_source',
					'value'   => 'font',
				),
				'group'       => esc_html__( 'Icon', 'pgs-core' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Icon Size', 'pgs-core' ),
				'param_name'  => 'callout_icon_size',
				'description' => esc_html__( 'Select icon size.', 'pgs-core' ),
				'value'       => array_flip(
					array(
						'xs' => esc_html__( 'Extra Small', 'pgs-core' ),
						'sm' => esc_html__( 'Small', 'pgs-core' ),
						'md' => esc_html__( 'Medium', 'pgs-core' ),
						'lg' => esc_html__( 'Large', 'pgs-core' ),
					)
				),
				'std'         => 'md',
				'group'       => esc_html__( 'Icon', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'callout_icon_source',
					'value'   => 'font',
				),
			),

			array(
				'type'             => 'attach_image',
				'param_name'       => 'icon_image',
				'heading'          => esc_html__( 'Icon Image', 'pgs-core' ),
				'description'      => esc_html__( 'Upload/select icon image.', 'pgs-core' ),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'dependency'       => array(
					'element' => 'callout_icon_source',
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
		'name'                    => esc_html__( 'Callout', 'pgs-core' ),
		'description'             => esc_html__( 'Make an action box with action button along with brief instructions.', 'pgs-core' ),
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
