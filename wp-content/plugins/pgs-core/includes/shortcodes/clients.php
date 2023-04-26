<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_clients
 *
 ******************************************************************************/
function pgscore_shortcode_clients( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'            => 'slider',
		'slider_elements'  => 'none',
		'grid_elements'    => '2',
		'image_source'     => 'image',
		'slide_img_link'   => '',
		'slides'           => '',
		'img_size'         => 'full',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$slides = vc_param_group_parse_atts( $atts['slides'] );

	// Return shortcode if no required content found to display the shortcode perfectly.
	if ( ! is_array( $slides ) || empty( $slides ) ) {
		return;
	}

	/*********************************************
	 *
	 * Check for thumbnail size
	 *
	 *********************************************/
	if ( empty( $img_size ) ) {
		$img_size = 'full';
	}
	global $_wp_additional_image_sizes;

	$thumb_size = '';
	if ( is_string( $img_size ) && ( ( ! empty( $_wp_additional_image_sizes[ $img_size ] ) && is_array( $_wp_additional_image_sizes[ $img_size ] ) ) || in_array( $img_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) ) ) ) {
		$thumb_size = $img_size;
	} elseif ( strpos( $img_size, 'x' ) !== false ) {
		$img_size = explode( 'x', $img_size );

		// Check for PHP version
		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) { // PHP < 5.3
			$img_size = array_filter( $img_size, create_function( '$value', 'return $value !== "";' ) );
		} else { // PHP 5.3 and later
			$img_size = array_filter(
				$img_size,
				function( $value ) {
					return $value !== '';
				}
			);
		}

		if ( count( $img_size ) == 2 && is_numeric( $img_size[0] ) && is_numeric( $img_size[1] ) ) {
			$thumb_size = $img_size;
		}
	}
	if ( empty( $thumb_size ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']        = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['slides_data'] = $slides;
	$pgscore_shortcodes[ $shortcode_handle ]['thumb_size']  = $thumb_size;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'clients/content' ); ?>
	</div>
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
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'style',
			'heading'     => esc_html__( 'List Style', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'slider',
					'title' => 'Slider',
					'image' => PGSCORE_URL . 'images/shortcodes/clients/style-1.png',
				),
				array(
					'value' => 'grid',
					'title' => 'Grid',
					'image' => PGSCORE_URL . 'images/shortcodes/clients/style-2.png',
				),
			),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Slider Navigations', 'pgs-core' ),
			'param_name'  => 'slider_elements',
			'value'       => array_flip(
				array(
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'pagination' => esc_html__( 'Pagination Control', 'pgs-core' ),
					'prevnext'   => esc_html__( 'Prev/Next Buttons', 'pgs-core' ),
					'both'       => esc_html__( 'Both', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Select slider navigations controls type.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array(
					'slider',
				),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Columns', 'pgs-core' ),
			'param_name'  => 'grid_elements',
			'value'       => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'description' => esc_html__( 'Select number of columns in Grid view.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array(
					'grid',
				),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image Size', 'pgs-core' ),
			'param_name'  => 'img_size',
			'value'       => 'full',
			'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Logo Images', 'pgs-core' ),
			'value'      => '',
			'param_name' => 'slides',
			'params'     => array(
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
					'heading'     => esc_html__( 'Slide Image', 'pgs-core' ),
					'param_name'  => 'slide_image',
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'image_source',
						'value'   => 'image',
					),
				),
				array(
					'type'        => 'textfield',
					'param_name'  => 'slide_img_link',
					'heading'     => esc_html__( 'Image Link', 'pgs-core' ),
					'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'image_source',
						'value'   => 'link',
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'description' => esc_html__( 'Enter title.', 'pgs-core' ),
					'param_name'  => 'title',
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Image Link', 'pgs-core' ),
					'param_name'  => 'image_link',
					'admin_label' => true,
				),
			),
			'group'      => esc_html__( 'Logo Images', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Clients Logo', 'pgs-core' ),
		'description'             => esc_html__( 'Display clients logo as grid and carousel.', 'pgs-core' ),
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
