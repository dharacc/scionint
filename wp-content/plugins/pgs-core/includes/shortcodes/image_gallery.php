<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_image_gallery
 *
 ******************************************************************************/
function pgscore_shortcode_image_gallery( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'image_gallery_style_disable' => '',
		'image_gallery_style'         => 'style-1',
		'image_gallery_type'          => 'isotope',
		'image_gallery_column'        => '3',
		'carousel_elements_xl'        => '3',
		'carousel_elements_lg'        => '2',
		'carousel_elements_md'        => '1',
		'carousel_elements_sm'        => '1',
		'image_gallery_space'         => '10',
		'image_gallery_slides'        => '',
		'image_gallery'               => '',
		'element_css'                 => '',
		'element_id'                  => '',
		'element_class'               => '',
		'image_overlay_color'         => 'rgba(0,0,0,0.3)',
		'shortcode_handle'            => $shortcode_handle,
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
		<?php pgscore_get_shortcode_templates( 'image-gallery/content' ); ?>
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
	$shortcode_fields = array(
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Hide Icon Style?', 'pgs-core' ),
			'param_name' => 'image_gallery_style_disable',
			'value'      => array(
				esc_html__( 'Yes', 'pgs-core' ) => 'true',
			),
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'image_gallery_style',
			'heading'     => esc_html__( 'Icon Style', 'pgs-core' ),
			'description' => esc_html__( 'Select icon style.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => PGSCORE_URL . 'images/shortcodes/image-gallery/style1.jpg',
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/image-gallery/style2.jpg',
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 3',
					'image' => PGSCORE_URL . 'images/shortcodes/image-gallery/style3.jpg',
				),
			),
			'dependency'  => array(
				'element'            => 'image_gallery_style_disable',
				'value_not_equal_to' => 'true',
			),
			'save_always' => true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'image_gallery_type',
			'heading'    => esc_html__( 'Image Gallery Type', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'isotope'  => esc_html__( 'Masonry', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
				)
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Image Gallery Column Size', 'pgs-core' ),
			'param_name'  => 'image_gallery_column',
			'std'         => '3',
			'value'       => array_flip(
				array(
					'6' => '6',
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'image_gallery_type',
				'value_not_equal_to' => 'carousel',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'carousel_elements_xl',
			'heading'          => esc_html__( 'Columns - Extra large &ge;1200px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'6' => esc_html__( '6 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'image_gallery_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'carousel_elements_lg',
			'heading'          => esc_html__( 'Columns - Large &ge;992px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'image_gallery_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'carousel_elements_md',
			'heading'          => esc_html__( 'Columns - Medium &ge;768px', 'pgs-core' ),
			'description'      => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'image_gallery_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Columns - Small &ge;576px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'param_name'       => 'carousel_elements_sm',
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'image_gallery_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Space between Image', 'pgs-core' ),
			'param_name'  => 'image_gallery_space',
			'value'       => array_flip(
				array(
					'0'  => '0',
					'5'  => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
				)
			),
			'std'         => '10',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
		),
		array(
			'type'        => 'colorpicker',
			'param_name'  => 'image_overlay_color',
			'heading'     => esc_html__( 'Image Overlay Color', 'pgs-core' ),
			'description' => esc_html__( 'Select overlay color.', 'pgs-core' ),
			'value'       => 'rgba(0,0,0,0.3)',
			'group'       => esc_html__( 'Images', 'pgs-core' ),
		),
		array(
			'type'        => 'attach_images',
			'heading'     => esc_html__( 'Slider Image Gallery', 'pgs-core' ),
			'param_name'  => 'image_gallery',
			'admin_label' => true,
			'group'       => esc_html__( 'Images', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Image Gallery', 'pgs-core' ),
		'description'             => esc_html__( 'Add Image Gallery.', 'pgs-core' ),
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
