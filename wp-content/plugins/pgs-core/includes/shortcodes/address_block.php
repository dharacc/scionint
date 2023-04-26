<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_address_block
 *
 ******************************************************************************/
function pgscore_shortcode_address_block( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'shape'            => 'square',
		'style'            => 'border',
		'title'            => '',
		'sub_contents'     => '',
		'icon_type'        => 'fontawesome',
		'icon_fontawesome' => 'fas fa-adjust',
		'icon_openiconic'  => 'vc-oi vc-oi-dial',
		'icon_typicons'    => 'typcn typcn-chevron-right',
		'icon_entypo'      => 'entypo-icon entypo-icon-note',
		'icon_linecons'    => 'vc_li vc_li-heart',
		'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'    => 'vc-material vc-material-cake',
		'icon_pixelicons'  => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'    => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'     => 'ti-arrow-up',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$sub_contents = vc_param_group_parse_atts( $sub_contents );

	// Filter data without "subcontent_title"
	if ( is_array( $sub_contents ) && ! empty( $sub_contents ) ) {
		foreach ( $sub_contents as $sub_content_tk => $sub_content_td ) {
			if ( empty( $sub_content_td['subcontent_title'] ) ) {
				unset( $sub_contents[ $sub_content_tk ] );
			}
		}
	} else {
		$sub_contents = array();
	}

	/*********************************************
	 *
	 * Return shortcode if no title or sub contents found.
	 *
	 *********************************************/
	if ( empty( $title ) && empty( $sub_contents ) ) {
		return;
	}

	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html  = '';
	$icon_class = '';

	$add_icon = true;
	if ( $add_icon ) {
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
				$icon_html = '<i class="' . esc_attr( $icon_class ) . '"></i>';
			}

			// Enqueue icon CSS for icon type
			if ( 'fontawesome' !== $icon_type ) {
				vc_icon_element_fonts_enqueue( $icon_type );
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']              = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['sub_contents_data'] = $sub_contents;
	$pgscore_shortcodes[ $shortcode_handle ]['icon_html']         = $icon_html;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'address_block/content' ); ?>
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
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Style', 'pgs-core' ),
		'param_name'  => 'style',
		'description' => esc_html__( 'Select style.', 'pgs-core' ),
		'std'         => 'none',
		'value'       => array(
			esc_html__( 'Default', 'pgs-core' ) => 'default',
			esc_html__( 'Border', 'pgs-core' )  => 'border',
			esc_html__( 'Flat', 'pgs-core' )    => 'flat',
		),
		'admin_label' => true,
	),
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Shape', 'pgs-core' ),
		'param_name'  => 'shape',
		'description' => esc_html__( 'Select icon shape.', 'pgs-core' ),
		'std'         => 'square',
		'value'       => array(
			esc_html__( 'Square', 'pgs-core' )  => 'square',
			esc_html__( 'Rounded', 'pgs-core' ) => 'rounded',
			esc_html__( 'Round', 'pgs-core' )   => 'round',
		),
		'admin_label' => true,
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Title', 'pgs-core' ),
		'param_name'  => 'title',
		'admin_label' => true,
		'group'       => esc_html__( 'Content', 'pgs-core' ),
	),
	array(
		'type'       => 'param_group',
		'heading'    => esc_html__( 'Sub Contents', 'pgs-core' ),
		'value'      => '',
		'param_name' => 'sub_contents',
		'params'     => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Title', 'pgs-core' ),
				'param_name'  => 'subcontent_title',
				'description' => esc_html__( 'Add content here.', 'pgs-core' ),
				'admin_label' => true,
			),
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__( 'Enable Link', 'pgs-core' ),
				'param_name'       => 'enable_link',
				'description'      => esc_html__( 'Enable link for the content.', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
			),
			array(
				'type'             => 'vc_link',
				'heading'          => esc_html__( 'Content Link', 'pgs-core' ),
				'param_name'       => 'custom_link',
				'description'      => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'element' => 'enable_link',
					'value'   => 'true',
				),
			),
		),
		'group'      => esc_html__( 'Content', 'pgs-core' ),
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
				/* translators: $s: link */
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
					/* translators: $s: shortcode tag */
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

// Merge icon fields.
$shortcode_fields = array_merge(
	$shortcode_fields,
	pgscore_iconpicker()
);

// Params
$params = array(
	'name'                    => esc_html__( 'Address Block', 'pgs-core' ),
	'description'             => esc_html__( 'Add address blocks.', 'pgs-core' ),
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
