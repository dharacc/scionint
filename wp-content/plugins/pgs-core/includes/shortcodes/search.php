<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_search
 *
 ******************************************************************************/
function pgscore_shortcode_search( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'search_placeholder_text' => 'Enter Search Keyword...',
		'search_box_shape'        => 'square',
		'search_box_background'   => 'default',
		'search_content_type'     => 'all',
		'show_categories'         => '',
		'element_css'             => '',
		'element_id'              => '',
		'element_class'           => '',
		'shortcode_handle'        => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array( 'header-search-wrap' );

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'search/content' ); ?>
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
			'heading'     => esc_html__( 'Search Input Placeholder', 'pgs-core' ),
			'param_name'  => 'search_placeholder_text',
			'value'       => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'description' => esc_html__( 'Enter the Placeholder', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Search Box Shape', 'pgs-core' ),
			'param_name'  => 'search_box_shape',
			'value'       => array_flip(
				array(
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Choose search box shape.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Search Box Background', 'pgs-core' ),
			'param_name'  => 'search_box_background',
			'value'       => array_flip(
				array(
					'default'     => esc_html__( 'Default', 'pgs-core' ),
					'transparent' => esc_html__( 'Transparent', 'pgs-core' ),
					'white'       => esc_html__( 'White', 'pgs-core' ),
					'dark'        => esc_html__( 'Dark', 'pgs-core' ),
					'theme'       => esc_html__( 'Theme', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Choose search box background.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Search Content Type', 'pgs-core' ),
			'param_name'  => 'search_content_type',
			'value'       => array_flip(
				array(
					'all'     => esc_html__( 'All', 'pgs-core' ),
					'product' => esc_html__( 'Product', 'pgs-core' ),
					'post'    => esc_html__( 'Post', 'pgs-core' ),
					'page'    => esc_html__( 'Page', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Choose search content type.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Categories ?', 'pgs-core' ),
			'param_name' => 'show_categories',
			'group'      => esc_html__( 'General', 'pgs-core' ),
			'dependency' => array(
				'element' => 'search_content_type',
				'value'   => array( 'product', 'post' ),
			),
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
		'name'                    => esc_html__( 'Search', 'pgs-core' ),
		'description'             => esc_html__( 'Add search box.', 'pgs-core' ),
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
