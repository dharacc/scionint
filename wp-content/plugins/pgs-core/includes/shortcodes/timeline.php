<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_timeline
 *
 ******************************************************************************/
function pgscore_shortcode_timeline( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'style'                  => 'style-1',
		'list'                   => '',
		'element_css'            => '',
		'element_id'             => '',
		'box_shape'              => 'square',
		'list_bg_color'          => '#f5f5f5',
		'list_title_color'       => '#04d39f',
		'list_description_color' => '#969696',
		'element_class'          => '',
		'shortcode_handle'       => $shortcode_handle,
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
		<?php pgscore_get_shortcode_templates( 'timeline/content' ); ?>
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
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'description' => esc_html__( 'style of timeline item display.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/timeline/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/timeline/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => esc_html__( 'Style 3', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/timeline/style-3.png',
				),
			),
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'List Box Shape', 'pgs-core' ),
			'param_name'       => 'box_shape',
			'description'      => esc_html__( 'Select list box shape.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'std'              => 'square',
			'value'            => array(
				esc_html__( 'Square', 'pgs-core' )  => 'square',
				esc_html__( 'Rounded', 'pgs-core' ) => 'rounded',
			),
			'admin_label'      => true,
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'list_bg_color',
			'heading'          => esc_html__( 'List Background Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select background color.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'value'            => '#f5f5f5',
			'dependency'       => array(
				'element' => 'style',
				'value'   => array( 'style-3' ),
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'list_title_color',
			'heading'          => esc_html__( 'List Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select title color.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'value'            => '#323232',
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'list_description_color',
			'heading'          => esc_html__( 'List Description Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select description color.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'value'            => '#323232',
		),
		array(
			'type'       => 'param_group',
			'value'      => '',
			'param_name' => 'list',
			'heading'    => esc_html__( 'Timeline Data', 'pgs-core' ),
			'params'     => array(
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'param_name'  => 'timeline_title',
					'save_always' => true,
					'admin_label' => true,
				),
				array(
					'type'        => 'textarea',
					'class'       => '',
					'heading'     => esc_html__( 'Description', 'pgs-core' ),
					'save_always' => true,
					'param_name'  => 'timeline_description',
				),
			),
			'callbacks'  => array(
				'after_add' => 'vcChartParamAfterAddCallback',
			),
			'group'      => esc_html__( 'Lists', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Timeline', 'pgs-core' ),
		'description'             => esc_html__( 'Display Timeline.', 'pgs-core' ),
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
