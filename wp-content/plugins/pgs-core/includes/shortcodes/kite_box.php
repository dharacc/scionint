<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_kite_box
 *
 ******************************************************************************/

function pgscore_shortcode_kite_box( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'kitebox_images'   => '',
		'kitebox_content'  => '',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
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
		<?php pgscore_get_shortcode_templates( 'kite_box/content' ); ?>
	</div>
	<!-- Shortcode Base Wrapper -->
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
			'param_name'     => 'kitebox_images_warning',
			'notice_type'    => 'error',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'message'        => esc_html__( 'Select SQUARE image, with minimum 700px * 700px resolution. Otherwise, structure looks broken.', 'pgs-core' ),
			'display_header' => false,
			'group'          => esc_html__( 'Images', 'pgs-core' ),
		),
		array(
			'type'        => 'param_group',
			'param_name'  => 'kitebox_images',
			'max_items'   => 4,
			'description' => esc_html__( 'You can add maximum four images.', 'pgs-core' ),
			'params'      => array(
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Image', 'pgs-core' ),
					'param_name' => 'content_image',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'param_name'  => 'image_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Enable Button', 'pgs-core' ),
					'param_name'  => 'kitebox_image_enable_link',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Button Text', 'pgs-core' ),
					'param_name'  => 'kite_box_image_button_text',
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'kitebox_image_enable_link',
						'value'   => 'true',
					),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button Link', 'pgs-core' ),
					'description' => esc_html__( 'Select/enter url.', 'pgs-core' ),
					'param_name'  => 'kite_box_content_button_link',
					'dependency'  => array(
						'element' => 'kitebox_image_enable_link',
						'value'   => 'true',
					),
				),
			),
			'group'       => esc_html__( 'Images', 'pgs-core' ),
		),
		array(
			'type'        => 'param_group',
			'max_items'   => 3,
			'param_name'  => 'kitebox_content',
			'description' => esc_html__( 'You can add maximum three elements.', 'pgs-core' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'param_name'  => 'content_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Description', 'pgs-core' ),
					'param_name'  => 'content_description',
					'admin_label' => true,
				),
			),
			'group'       => esc_html__( 'Content', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Kite Box', 'pgs-core' ),
		'description'             => esc_html__( 'Display Kite Shaped Content.', 'pgs-core' ),
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
