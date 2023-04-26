<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $ciyashop_options;

/******************************************************************************
 *
 * Shortcode : pgscore_list
 *
 ******************************************************************************/
function pgscore_shortcode_list( $atts, $content = null, $shortcode_handle = '' ) {
	global $ciyashop_options;

	$default_atts = array(
		'list_element_tag'           => 'p',
		'list_font_weight'           => 'inherit',
		'list_text_transform'        => 'inherit',
		'list_title_color'           => '#969696',
		'list_title_hover_color'     => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
		'add_icon'                   => false,
		'list_items'                 => '',
		'list_style_type'            => 'none',
		'icon_style_type'            => 'default',
		'icon_shape'                 => 'square',
		'list_icon_color'            => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
		'list_icon_background_color' => '#323232',
		'icon_type'                  => 'fontawesome',
		'icon_fontawesome'           => 'fas fa-adjust',
		'icon_openiconic'            => 'vc-oi vc-oi-dial',
		'icon_typicons'              => 'typcn typcn-chevron-right',
		'icon_entypo'                => 'entypo-icon entypo-icon-note',
		'icon_linecons'              => 'vc_li vc_li-heart',
		'icon_monosocial'            => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'              => 'vc-material vc-material-cake',
		'icon_pixelicons'            => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'              => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'               => 'ti-arrow-up',
		'element_css'                => '',
		'element_id'                 => '',
		'element_class'              => '',
		'shortcode_handle'           => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	// List Items
	$list_items = vc_param_group_parse_atts( $list_items );

	// Return if no list items found
	if ( ! is_array( $list_items ) || empty( $list_items ) || ( ( count( $list_items ) == 1 ) && empty( $list_items[0] ) ) ) {
		return;
	}

	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html  = '';
	$icon_class = '';

	if ( ! empty( $add_icon ) && 'true' == $add_icon ) {
		$icon_wrapper = false;

		if ( isset( ${'icon_' . $icon_type} ) && ! empty( ${'icon_' . $icon_type} ) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${'icon_' . $icon_type};
		}

		if ( $icon_class ) {
			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_style = '';
				if ( isset( $list_icon_color ) && ! empty( $list_icon_color ) ) {
					$icon_style = ' style="color:' . esc_attr( $list_icon_color ) . ';';
				}
				if ( isset( $list_icon_background_color ) && ! empty( $list_icon_background_color ) && 'flat' === $icon_style_type ) {
					$icon_style .= 'background:' . esc_attr( $list_icon_background_color ) . ';';
				}
				$icon_style .= '"';
				$icon_html   = '<i class="' . esc_attr( $icon_class ) . '"' . $icon_style . '></i>';
			}

			// Enqueue icon CSS for icon type
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				if ( 'fontawesome' !== $icon_type ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
			}
		}
	}

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	 **********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']       = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['list_items'] = $list_items;
	$pgscore_shortcodes[ $shortcode_handle ]['icon_html']  = $icon_html;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'list/content' ); ?>
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
			'type'        => 'dropdown',
			'param_name'  => 'list_element_tag',
			'heading'     => esc_html__( 'Title Element Tag', 'pgs-core' ),
			'description' => esc_html__( 'Select Title Element Tag.', 'pgs-core' ),
			'std'         => 'p',
			'value'       => array_flip(
				array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
					'p'  => esc_html__( 'P', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_font_weight',
			'heading'          => esc_html__( 'List Title Font Weight', 'pgs-core' ),
			'description'      => esc_html__( 'Select Font Size.', 'pgs-core' ),
			'std'              => 'inherit',
			'value'            => array_flip(
				array(
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
					'bold'    => esc_html__( 'Bold', 'pgs-core' ),
					'normal'  => esc_html__( 'Normal', 'pgs-core' ),
				)
			),
			'dependency'       => array(
				'element'            => 'list_element_tag',
				'value_not_equal_to' => array( 'p' ),
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_text_transform',
			'heading'          => esc_html__( 'List Title Text Transform', 'pgs-core' ),
			'description'      => esc_html__( 'Select List Title Text Transform.', 'pgs-core' ),
			'std'              => 'inherit',
			'value'            => array_flip(
				array(
					'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
					'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
					'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
					'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
				)
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'list_title_color',
			'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Title color.', 'pgs-core' ),
			'value'            => '#969696',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'list_title_hover_color',
			'heading'          => esc_html__( 'Title Hover Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Title Hover Color, Working, if you have add list item content link.', 'pgs-core' ),
			'value'            => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Add Icon?', 'pgs-core' ),
			'param_name' => 'add_icon',
			'group'      => esc_html__( 'Icon', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'list_style_type',
			'heading'     => esc_html__( 'Icon list type', 'pgs-core' ),
			'description' => esc_html__( 'Select Icon List Type.', 'pgs-core' ),
			'std'         => 'none',
			'value'       => array_flip(
				array(
					'none'        => esc_html__( 'None', 'pgs-core' ),
					'circle'      => esc_html__( 'Circle', 'pgs-core' ),
					'decimal'     => esc_html__( 'Decimal', 'pgs-core' ),
					'disc'        => esc_html__( 'Disc', 'pgs-core' ),
					'square'      => esc_html__( 'Square', 'pgs-core' ),
					'lower-alpha' => esc_html__( 'Lower Alpha', 'pgs-core' ),
					'lower-roman' => esc_html__( 'Lower Roman', 'pgs-core' ),
				)
			),
			'group'       => esc_html__( 'Icon', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'add_icon',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon_style_type',
			'heading'     => esc_html__( 'Icon style type', 'pgs-core' ),
			'description' => esc_html__( 'Select Icon style Type.', 'pgs-core' ),
			'std'         => 'default',
			'value'       => array_flip(
				array(
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'border'  => esc_html__( 'Border', 'pgs-core' ),
					'flat'    => esc_html__( 'Flat', 'pgs-core' ),
				)
			),
			'group'       => esc_html__( 'Icon', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'add_icon',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon_shape',
			'heading'     => esc_html__( 'Icon shape', 'pgs-core' ),
			'description' => esc_html__( 'Select Icon Shape.', 'pgs-core' ),
			'std'         => 'square',
			'value'       => array_flip(
				array(
					'square'  => esc_html__( 'Square', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				)
			),
			'group'       => esc_html__( 'Icon', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'icon_style_type',
				'value_not_equal_to' => 'default',
			),
		),
		array(
			'type'        => 'colorpicker',
			'param_name'  => 'list_icon_color',
			'heading'     => esc_html__( 'Icon Color', 'pgs-core' ),
			'description' => esc_html__( 'Select Icon Color.', 'pgs-core' ),
			'value'       => isset( $ciyashop_options['primary_color'] ) ? $ciyashop_options['primary_color'] : '#04d39f',
			'group'       => esc_html__( 'Icon', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'add_icon',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'colorpicker',
			'param_name'  => 'list_icon_background_color',
			'heading'     => esc_html__( 'Icon Background Color', 'pgs-core' ),
			'description' => esc_html__( 'Select Icon Background Color.', 'pgs-core' ),
			'value'       => '#323232',
			'group'       => esc_html__( 'Icon', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'icon_style_type',
				'value'   => 'flat',
			),
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'list_items',
			'group'      => esc_html__( 'List Items', 'pgs-core' ),
			'params'     => array(
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Content', 'pgs-core' ),
					'param_name'       => 'content',
					'tooltip'          => esc_html__( 'Add item content.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Content Link', 'pgs-core' ),
					'param_name'  => 'content_link',
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

	$pgscore_iconpicker_args = array(
		'dependency' => array(
			'element' => 'add_icon',
			'value'   => 'true',
		),
		'group'      => esc_html__( 'Icon', 'pgs-core' ),
	);

	// Merge icon fields
	$shortcode_fields = array_merge(
		$shortcode_fields,
		pgscore_iconpicker( $pgscore_iconpicker_args )
	);

	// Params
	$params = array(
		'name'                    => esc_html__( 'List', 'pgs-core' ),
		'description'             => esc_html__( 'Display list items.', 'pgs-core' ),
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
