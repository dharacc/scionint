<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_progress_bar
 *
 ******************************************************************************/
function pgscore_shortcode_progress_bar( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'progress_bar_list'           => '',
		'progress_bar_title_position' => 'up',
		'progress_bar_height'         => '15',
		'progress_bar_border'         => 'square',
		'element_css'                 => '',
		'element_id'                  => '',
		'element_class'               => '',
		'shortcode_handle'            => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	// List Items
	$progress_bar_list = vc_param_group_parse_atts( $progress_bar_list );

	// Return if no list items found
	if ( ! is_array( $progress_bar_list ) || empty( $progress_bar_list ) || ( ( count( $progress_bar_list ) == 1 ) && empty( $progress_bar_list[0] ) ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']              = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['progress_bar_list'] = $progress_bar_list;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'progress_bar/content' ); ?>
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
			'type'        => 'dropdown',
			'param_name'  => 'progress_bar_title_position',
			'heading'     => esc_html__( 'Title Position', 'pgs-core' ),
			'description' => esc_html__( 'Select Title position.', 'pgs-core' ),
			'std'         => 'up',
			'value'       => array_flip(
				array(
					'up'   => esc_html__( 'Up', 'pgs-core' ),
					'down' => esc_html__( 'Down', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Height', 'pgs-core' ),
			'description'      => esc_html__( 'Please select Height Between 1 to 20.', 'pgs-core' ),
			'min'              => 1,
			'max'              => 20,
			'value'            => 15,
			'suffix'           => 'px',
			'param_name'       => 'progress_bar_height',
			'edit_field_class' => 'vc_col-md-12',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'progress_bar_border',
			'heading'     => esc_html__( 'Border Styles', 'pgs-core' ),
			'description' => esc_html__( 'Select Border Style.', 'pgs-core' ),
			'std'         => 'square',
			'value'       => array_flip(
				array(
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
					'round'   => esc_html__( 'Round', 'pgs-core' ),
				)
			),
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'progress_bar_list',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'pgs-core' ),
					'param_name'  => 'progress_bar_title',
					'admin_label' => true,
				),
				array(
					'type'        => 'pgscore_number_min_max',
					'heading'     => esc_html__( 'Value', 'pgs-core' ),
					'description' => esc_html__( 'Enter value between 1 to 100.', 'pgs-core' ),
					'min'         => 1,
					'max'         => 100,
					'value'       => 70,
					'suffix'      => '%',
					'tooltip'     => esc_html__( 'Enter value between 1 to 100', 'pgs-core' ),
					'param_name'  => 'progress_bar_value',
					'admin_label' => true,
				),
				array(
					'type'        => 'colorpicker',
					'param_name'  => 'progress_bar_color',
					'heading'     => esc_html__( 'Progress Bar Color', 'pgs-core' ),
					'description' => esc_html__( 'Select Progress Bar Color.', 'pgs-core' ),
					'value'       => '#04d39f',
					'save_always' => true,
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
		'name'                    => esc_html__( 'Progress Bar', 'pgs-core' ),
		'description'             => esc_html__( 'Display Progress Bar.', 'pgs-core' ),
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
