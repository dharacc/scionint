<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $ciyashop_options;

/******************************************************************************
 *
 * Shortcode : pgscore_menu_list
 *
 ******************************************************************************/
function pgscore_shortcode_menu_list( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'menu_list_element_title' => '',
		'menu_list_title'         => '',
		'menu_list_items'         => '',
		'menu_title'              => '',
		'menu_item_link'          => '',
		'menu_item_label'         => '',
		'icon_type'               => 'fontawesome',
		'icon_fontawesome'        => 'fas fa-adjust',
		'icon_openiconic'         => 'vc-oi vc-oi-dial',
		'icon_typicons'           => 'typcn typcn-chevron-right',
		'icon_entypo'             => 'entypo-icon entypo-icon-note',
		'icon_linecons'           => 'vc_li vc_li-heart',
		'icon_monosocial'         => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'           => 'vc-material vc-material-cake',
		'icon_pixelicons'         => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'           => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'            => 'ti-arrow-up',
		'menu_item_label_color'   => '',
		'add_icon'                => false,
		'element_css'             => '',
		'element_id'              => '',
		'element_class'           => '',
		'shortcode_handle'        => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	// Menu List Items
	$menu_list_items = vc_param_group_parse_atts( $menu_list_items );

	// Return if no menu list items found
	if ( ! is_array( $menu_list_items ) || empty( $menu_list_items ) || ( ( count( $menu_list_items ) == 1 ) && empty( $menu_list_items[0] ) ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['menu_list_items'] = $menu_list_items;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'menu_list/content' ); ?>
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

	$icon_picker     = array();
	$pgs_icon_picker = array();

	$pgscore_iconpicker_args = array(
		'dependency' => array(
			'element' => 'add_icon',
			'value'   => 'true',
		),
	);

	$icon_picker = pgscore_iconpicker( $pgscore_iconpicker_args );

	if ( ! empty( $icon_picker ) ) {
		foreach ( $icon_picker as $icon_p ) {
			$pgs_icon_picker[] = $icon_p;
		}
	}

	$params = array(
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Menu Title', 'pgs-core' ),
			'param_name'       => 'menu_title',
			'tooltip'          => esc_html__( 'Add item content.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'admin_label'      => true,
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'Menu Link', 'pgs-core' ),
			'param_name'  => 'menu_item_link',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Menu Label', 'pgs-core' ),
			'param_name'  => 'menu_item_label',
			'admin_label' => true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'menu_item_label_color',
			'heading'    => esc_html__( 'Menu Label Color', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'red'    => esc_html__( 'Red Color', 'pgs-core' ),
					'green'  => esc_html__( 'Green Color', 'pgs-core' ),
					'orange' => esc_html__( 'Orange Color', 'pgs-core' ),
					'blue'   => esc_html__( 'Blue Color', 'pgs-core' ),
					'black'  => esc_html__( 'Black Color', 'pgs-core' ),
				)
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Add Icon?', 'pgs-core' ),
			'param_name' => 'add_icon',
			'group'      => esc_html__( 'Icon', 'pgs-core' ),
		),
	);

	$params = array_merge( $params, $pgs_icon_picker );

	$shortcode_fields = array(
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'param_name'       => 'menu_list_title',
			'tooltip'          => esc_html__( 'Add menu list title.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			'admin_label'      => true,
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'menu_list_items',
			'params'     => $params,
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

	$params = array(
		'name'                    => esc_html__( 'Menu List', 'pgs-core' ),
		'description'             => esc_html__( 'Display Menu list items.', 'pgs-core' ),
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
