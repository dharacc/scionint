<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_hotspot
 *
 ******************************************************************************/
function pgscore_shortcode_hotspot( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'hotspot_box_img'      => '',
		'hotspot_trigger'      => 'hover',
		'image_source'         => 'image',
		'hotspot_box_img_link' => '',
		'pointer_style'        => 'style1',
		'hotspot_color_scheme' => 'light-bg',
		'list_items'           => '',
		'element_css'          => '',
		'element_id'           => '',
		'element_class'        => '',
		'shortcode_handle'     => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$list_items_raw = vc_param_group_parse_atts( $list_items );

	if ( ! is_array( $list_items_raw ) || empty( $list_items_raw ) || ( ( count( $list_items_raw ) == 1 ) && empty( $list_items_raw[0] ) ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']           = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['list_items_raw'] = $list_items_raw;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'hotspot/content' ); ?>
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
			'type'             => 'attach_image',
			'param_name'       => 'hotspot_box_img',
			'heading'          => esc_html__( 'Hotspot Image', 'pgs-core' ),
			'description'      => esc_html__( 'Upload image.', 'pgs-core' ),
			'class'            => 'hotspot_main_image',
			'edit_field_class' => 'pgscore-hotspot-img vc_col-sm-12 vc_column',
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'image_source',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'hotspot_box_img_link',
			'heading'     => esc_html__( 'Hotspot Image Link', 'pgs-core' ),
			'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'link',
			),
		),
		array(
			'type'             => 'pgscore_radio_image2',
			'heading'          => esc_html__( 'Pointer Style', 'pgs-core' ),
			'description'      => esc_html__( 'Select Pointer Style.', 'pgs-core' ),
			'param_name'       => 'pointer_style',
			'edit_field_class' => 'pgscore_radio_image2 pgscore_radio_image2_small vc_col-sm-12 vc_col-lg-4 vc_column',
			'options'          => array(
				array(
					'value' => 'style1',
					'title' => 'Style 1',
					'image' => PGSCORE_URL . 'images/shortcodes/hotspot/style1.jpg',
				),
				array(
					'value' => 'style2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/hotspot/style2.jpg',
				),
			),
			'show_label'       => true,
			'admin_label'      => true,
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'hotspot_trigger',
			'heading'          => esc_html__( 'Trigger', 'pgs-core' ),
			'description'      => esc_html__( 'Select trigger.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-12 vc_col-lg-4 vc_column',
			'std'              => 'hover',
			'value'            => array_flip(
				array(
					'hover' => esc_html__( 'Hover', 'pgs-core' ),
					'click' => esc_html__( 'Click', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'hotspot_color_scheme',
			'heading'          => esc_html__( 'Color Scheme', 'pgs-core' ),
			'description'      => esc_html__( 'Select Color Scheme.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-12 vc_col-lg-4 vc_column',
			'std'              => 'hover',
			'value'            => array_flip(
				array(
					'light-bg' => esc_html__( 'Light', 'pgs-core' ),
					'dark-bg'  => esc_html__( 'Dark', 'pgs-core' ),
					'theme-bg' => esc_html__( 'Theme', 'pgs-core' ),
				)
			),
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'list_items',
			'params'     => array(
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Position', 'pgs-core' ),
					'param_name'       => 'position',
					'tooltip'          => esc_html__( 'Define hotspot position on background image. By clicking on Set Position  button you can drag the hotspot point to the desired position.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column pgscore-position',
					'value'            => '50||50',
					'admin_label'      => true,
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Image', 'pgs-core' ),
					'param_name' => 'hotspot_list_image',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'pgs-core' ),
					'param_name'       => 'hotspot_list_title',
					'tooltip'          => esc_html__( 'Add item title.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Content', 'pgs-core' ),
					'param_name'       => 'hotspot_list_content',
					'tooltip'          => esc_html__( 'Add item content.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Link', 'pgs-core' ),
					'param_name'  => 'hotspot_list_link',
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'param_name'  => 'hotspot_list_direction',
					'heading'     => esc_html__( 'Direction', 'pgs-core' ),
					'description' => esc_html__( 'Select Direction position.', 'pgs-core' ),
					'std'         => 'right',
					'value'       => array_flip(
						array(
							'up'    => esc_html__( 'Up', 'pgs-core' ),
							'right' => esc_html__( 'Right', 'pgs-core' ),
							'left'  => esc_html__( 'Left', 'pgs-core' ),
							'down'  => esc_html__( 'Down', 'pgs-core' ),
						)
					),
				),
				array(
					'type'             => 'checkbox',
					'heading'          => esc_html__( 'Hide Desktop?', 'pgs-core' ),
					'param_name'       => 'hotspot_desktop',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'value'            => array(
						esc_html__( 'Hide Desktop?', 'pgs-core' ) => 'true',
					),
				),
				array(
					'type'             => 'checkbox',
					'heading'          => esc_html__( 'Hide Mobile?', 'pgs-core' ),
					'param_name'       => 'hotspot_mobile',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'value'            => array(
						esc_html__( 'Hide Mobile?', 'pgs-core' ) => 'true',
					),
				),
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
		'name'                    => esc_html__( 'Hotspot Image', 'pgs-core' ),
		'description'             => esc_html__( 'Hotspot Image List.', 'pgs-core' ),
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
