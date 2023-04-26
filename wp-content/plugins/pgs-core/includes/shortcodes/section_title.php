<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_section_title
 *
 ******************************************************************************/
function pgscore_shortcode_section_title( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(

		// Content
		'section_title_style' => 'style1',
		'main_title'          => '',
		'section_alighnment'  => 'center',
		'main_title_el'       => 'h3',
		'main_title_el_color' => '#323232',
		'sub_title'           => '',
		'sub_title_color'     => '#bbbbbb',
		'section_description' => '',
		'image_source'        => 'image',
		'divider_bg_img'      => '',
		'divider_bg_img_link' => '',
		//'content' => '',
		'element_css'         => '',
		'element_id'          => '',
		'element_class'       => '',
		'shortcode_handle'    => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'section_title/content' ); ?>
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
		/*---------------------------- Content ----------------------------*/
		array(
			'type'        => 'pgscore_radio_image',
			'heading'     => esc_html__( 'Title Style', 'pgs-core' ),
			'param_name'  => 'section_title_style',
			'description' => 'Select  Title Style.',
			'options'     => array(
				'style1' => PGSCORE_URL . 'images/shortcodes/section_title/style1.jpg',
				'style2' => PGSCORE_URL . 'images/shortcodes/section_title/style2.jpg',
				'style3' => PGSCORE_URL . 'images/shortcodes/section_title/style3.jpg',
				'style4' => PGSCORE_URL . 'images/shortcodes/section_title/style4.jpg',
			),
			'show_label'  => true,
			'admin_label' => true,
			'std'         => 'style1',
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'main_title',
			'heading'     => esc_html__( 'Main Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter main title.', 'pgs-core' ),
			'admin_label' => true,
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
			'dependency' => array(
				'element' => 'section_title_style',
				'value'   => 'style4',
			),
		),
		array(
			'type'        => 'attach_image',
			'param_name'  => 'divider_bg_img',
			'heading'     => esc_html__( 'Divider Image', 'pgs-core' ),
			'description' => esc_html__( 'Select/upload divider image.', 'pgs-core' ),
			'holder'      => 'img',
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'divider_bg_img_link',
			'heading'     => esc_html__( 'Image Link', 'pgs-core' ),
			'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'link',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'main_title_el',
			'heading'          => esc_html__( 'Title Element Tag', 'pgs-core' ),
			'description'      => esc_html__( 'Select title element tag.', 'pgs-core' ),
			'std'              => 'h3',
			'value'            => array_flip(
				array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				)
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'main_title_el_color',
			'heading'          => esc_html__( 'Title Element Tag Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Title Element Tag color.', 'pgs-core' ),
			'value'            => '#323232',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'sub_title',
			'heading'     => esc_html__( 'Sub Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter Sub title.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'colorpicker',
			'param_name'  => 'sub_title_color',
			'heading'     => esc_html__( 'Sub Title Color', 'pgs-core' ),
			'description' => esc_html__( 'Select Sub Title color.', 'pgs-core' ),
			'value'       => '#bbbbbb',
		),
		array(
			'type'        => 'textarea',
			'class'       => '',
			'heading'     => __( 'Description', 'pgs-core' ),
			'param_name'  => 'section_description',
			'description' => __( 'Enter description.', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_radio',
			'param_name'  => 'section_alighnment',
			'heading'     => esc_html__( 'Alignment', 'pgs-core' ),
			'value'       => array_flip(
				array(
					'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
					'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
					'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
				)
			),
			'std'         => 'center',
			'class'       => 'pgscore_radio_label_only',
			'description' => __( 'Select section alignment.', 'pgs-core' ),
			'save_always' => true,
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
		'name'                    => esc_html__( 'Section Title', 'pgs-core' ),
		'description'             => esc_html__( 'Add Divider Section.', 'pgs-core' ),
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
