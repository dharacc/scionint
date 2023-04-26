<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_social_icons
 *
 ******************************************************************************/
function pgscore_shortcode_social_icons( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'            => 'default',
		'hover_style'      => 'hover-default',
		'shape'            => 'square',
		'size'             => 'medium',
		'list_items'       => '',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$list_items_raw = vc_param_group_parse_atts( $list_items );

	if ( ! is_array( $list_items_raw ) || empty( $list_items_raw ) || ( ( count( $list_items_raw ) == 1 ) && empty( $list_items_raw[0] ) ) ) {
		return;
	}

	$list_items_data = array();
	foreach ( $list_items_raw as $list_item ) {
		if ( isset( $list_item['icon'] ) && ! empty( $list_item['icon'] ) && isset( $list_item['link'] ) && ! empty( $list_item['link'] ) ) {
			$link_class = ''; // Array of Classes OR string
			$link_attr  = pgscore_vc_link_attr( $list_item['link'], $link_class );

			if ( $link_attr ) {
				$list_items_data[] = array(
					'icon_class'   => esc_attr( $list_item['icon'] ),
					'profile_name' => esc_attr( str_replace( 'fa fa-', '', $list_item['icon'] ) ),
					'icon'         => '<i class="' . esc_attr( $list_item['icon'] ) . '"></i>',
					'link'         => $link_attr,
				);
			}
		}
	}

	if ( empty( $list_items_data ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']            = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['list_items_data'] = $list_items_data;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'social_icons/content', $style ); ?>
	</div>
	<?php
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/
$shortcode_fields = array(
	array(
		'type'       => 'pgscore_heading',
		'heading'    => esc_html__( 'Select Icon Parameters', 'pgs-core' ),
		'param_name' => 'social_icon_heading',
	),
	array(
		'type'             => 'dropdown',
		'heading'          => esc_html__( 'Style', 'pgs-core' ),
		'param_name'       => 'style',
		'value'            => array(
			esc_html__( 'Default', 'pgs-core' )    => 'default',
			esc_html__( 'Border', 'pgs-core' )     => 'border',
			esc_html__( 'Flat Color', 'pgs-core' ) => 'flat-color',
		),
		'description'      => esc_html__( 'Select style. ', 'pgs-core' ),
		'admin_label'      => true,
		'edit_field_class' => 'vc_col-sm-6 vc_col-md-3 vc_col-lg-3',
	),
	array(
		'type'             => 'dropdown',
		'heading'          => esc_html__( 'Shape', 'pgs-core' ),
		'param_name'       => 'shape',
		'description'      => esc_html__( 'Select shape.', 'pgs-core' ),
		'std'              => 'square',
		'value'            => array(
			esc_html__( 'Square', 'pgs-core' )  => 'square',
			esc_html__( 'Rounded', 'pgs-core' ) => 'rounded',
			esc_html__( 'Round', 'pgs-core' )   => 'Round',
		),
		'admin_label'      => true,
		'edit_field_class' => 'vc_col-sm-6 vc_col-md-3 vc_col-lg-3',
	),
	array(
		'type'             => 'dropdown',
		'heading'          => esc_html__( 'Size', 'pgs-core' ),
		'param_name'       => 'size',
		'description'      => esc_html__( 'Select icon display size.', 'pgs-core' ),
		'std'              => 'medium',
		'value'            => array(
			esc_html__( 'Small', 'pgs-core' )       => 'small',
			esc_html__( 'Medium', 'pgs-core' )      => 'medium',
			esc_html__( 'Large', 'pgs-core' )       => 'large',
			esc_html__( 'Extra Large', 'pgs-core' ) => 'extra-large',
		),
		'admin_label'      => true,
		'edit_field_class' => 'vc_col-sm-6 vc_col-md-3 vc_col-lg-3',
	),
	array(
		'type'             => 'dropdown',
		'heading'          => esc_html__( 'Hover Style', 'pgs-core' ),
		'param_name'       => 'hover_style',
		'value'            => array(
			esc_html__( 'Default', 'pgs-core' )     => 'default',
			esc_html__( 'Color Hover', 'pgs-core' ) => 'color-hover',
		),
		'description'      => esc_html__( 'Select hover style.', 'pgs-core' ),
		'admin_label'      => true,
		'edit_field_class' => 'vc_col-sm-6 vc_col-md-3 vc_col-lg-3',
	),
	array(
		'type'       => 'param_group',
		'param_name' => 'list_items',
		'group'      => esc_html__( 'Social Profiles', 'pgs-core' ),
		'params'     => array(
			array(
				'type'       => 'vc_link',
				'heading'    => esc_html__( 'Profile Link', 'pgs-core' ),
				'param_name' => 'link',
			),
			array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon',
				'value'       => '',
				'settings'    => array(
					'emptyIcon'    => true,
					'iconsPerPage' => 4000,
					'type'         => 'fontawesome-social-icons',
				),
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'admin_label' => true,
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
	'name'                    => esc_html__( 'Social Icons', 'pgs-core' ),
	'description'             => esc_html__( 'Display social icons.', 'pgs-core' ),
	'base'                    => $shortcode_tag,
	'class'                   => 'pgscore_element_wrapper',
	'controls'                => 'full',
	'icon'                    => PGSCORE_URL . '/images/vc-icon.png',
	'category'                => esc_html__( 'Potenza Core', 'pgs-core' ),
	'show_settings_on_create' => true,
	'params'                  => $shortcode_fields,
);

if ( function_exists( 'vc_map' ) ) {
	vc_map( $params );
}
