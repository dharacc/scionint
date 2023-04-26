<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_video
 *
 ******************************************************************************/
function pgscore_shortcode_video( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'video_link'        => '',
		'video_img'         => '',
		'video_img_link'    => '',
		'button_style'      => 'icon',
		'button_style_type' => 'default',
		'icon_style'        => '',
		'btn_text'          => '',
		'enable_opacity'    => 'true',
		'opacity_color'     => 'rgba(0, 0, 0, 0.7)',
		'button_position'   => 'center',
		'image_source'      => 'image',
		'show_content'      => '',
		'title'             => '',
		'title_element'     => 'h2',
		'element_css'       => '',
		'element_id'        => '',
		'element_class'     => '',
		'shortcode_handle'  => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	global $ciyashop_options;

	extract( $atts );

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']    = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['content'] = $content;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'video/content' ); ?>
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
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Video URL', 'pgs-core' ),
			'param_name'  => 'video_link',
			'description' => sprintf(
				wp_kses(
					__( 'Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank"> codex page</a>)', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'image_source',
			'heading'    => esc_html__( 'Image Source', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				)
			),
			'std'        => 'image',
		),
		array(
			'type'        => 'attach_image',
			'param_name'  => 'video_img',
			'heading'     => esc_html__( 'Video Image', 'pgs-core' ),
			'description' => esc_html__( 'Kindly upload your required size image, as the same image will display which you upload here.', 'pgs-core' ),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'video_img_link',
			'heading'     => esc_html__( 'Image Link', 'pgs-core' ),
			'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'link',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Opacity', 'pgs-core' ),
			'param_name'  => 'enable_opacity',
			'value'       => array(
				esc_html__( 'Enable?', 'pgs-core' ) => 'true',
			),
			'std'         => 'true',
			'admin_label' => true,
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Opacity Color', 'pgs-core' ),
			'param_name'  => 'opacity_color',
			'value'       => 'rgba(0, 0, 0, 0.7)',
			'description' => esc_html__( 'Add opacity color.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_opacity',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button / Icon Type ', 'pgs-core' ),
			'param_name'  => 'button_style',
			'value'       => array(
				esc_html__( 'Button', 'pgs-core' ) => 'btn',
				esc_html__( 'Icon', 'pgs-core' )   => 'icon',
			),
			'std'         => 'icon',
			'description' => esc_html__( 'Select any one Button / Icon Type from given dropdown.', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Styles', 'pgs-core' ),
			'param_name'  => 'button_style_type',
			'value'       => array(
				esc_html__( 'Default', 'pgs-core' ) => 'default',
				esc_html__( 'Round', 'pgs-core' )   => 'round',
				esc_html__( 'Rounded', 'pgs-core' ) => 'rounded',
				esc_html__( 'Border', 'pgs-core' )  => 'border',
			),
			'std'         => 'default',
			'dependency'  => array(
				'element' => 'button_style',
				'value'   => 'btn',
			),
			'description' => esc_html__( 'Select any one Button Style from given dropdown.', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Button Text', 'pgs-core' ),
			'param_name'  => 'btn_text',
			'description' => esc_html__( 'Add Button Text.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'button_style',
				'value'   => 'btn',
			),
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'icon_style',
			'heading'     => esc_html__( 'Icon Style', 'pgs-core' ),
			'description' => esc_html__( 'Select icon style.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => PGSCORE_URL . 'images/shortcodes/video/video-popup-icon1.png',
					'title' => 'icon 1',
					'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon1.jpg',
				),
				array(
					'value' => PGSCORE_URL . 'images/shortcodes/video/video-popup-icon2.png',
					'title' => 'icon 2',
					'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon2.jpg',
				),
				array(
					'value' => PGSCORE_URL . 'images/shortcodes/video/video-popup-icon3.png',
					'title' => 'icon 3',
					'image' => PGSCORE_URL . 'images/shortcodes/video/video-popup-black-icon3.jpg',
				),
			),
			'dependency'  => array(
				'element' => 'button_style',
				'value'   => 'icon',
			),
			'save_always' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button / Icon Position ', 'pgs-core' ),
			'param_name'  => 'button_position',
			'value'       => array(
				esc_html__( 'Center', 'pgs-core' )      => 'center',
				esc_html__( 'Left Bottom', 'pgs-core' ) => 'left_bottom',
			),
			'std'         => 'center',
			'description' => esc_html__( 'Select any one Button / Icon position from given dropdown.', 'pgs-core' ),
		),
		/*---------------------------- Content ----------------------------*/
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Content?', 'pgs-core' ),
			'param_name'  => 'show_content',
			'description' => esc_html__( 'Check this checkbox to Show Content.', 'pgs-core' ),
			'value'       => array(
				esc_html__( 'Show', 'pgs-core' ) => 'true',
			),
			'group'       => esc_html__( 'Content', 'pgs-core' ),

		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'title',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter title.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Content', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'show_content',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'title_element',
			'heading'     => esc_html__( 'Title Element Tag', 'pgs-core' ),
			'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
			'std'         => 'h2',
			'value'       => array_flip(
				array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				)
			),
			'group'       => esc_html__( 'Content', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'show_content',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'textarea',
			'class'       => '',
			'heading'     => esc_html__( 'Description', 'pgs-core' ),
			'description' => esc_html__( 'Enter description.', 'pgs-core' ),
			'param_name'  => 'content',
			'group'       => esc_html__( 'Content', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'show_content',
				'value'   => 'true',
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
	);
	// Params
	$params = array(
		'name'                    => esc_html__( 'Video', 'pgs-core' ),
		'description'             => esc_html__( 'Display Video.', 'pgs-core' ),
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
