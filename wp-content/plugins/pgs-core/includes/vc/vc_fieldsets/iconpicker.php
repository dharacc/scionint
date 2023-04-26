<?php
function pgscore_iconpicker( $args = array() ) {
	$icon_type_data = $icon_picker = $icon_fields = array();

	// Return if font types is set, but empty
	if ( isset( $args['font_types'] ) && empty( $args['font_types'] ) ) {
		return $icon_picker;
	}

	$icon_library_param_name = ( isset( $args['param_name'] ) && ! empty( $args['param_name'] ) ) ? $args['param_name'] : 'icon_type';

	$font_types = ( isset( $args['font_types'] ) && ! empty( $args['font_types'] ) ) ? $args['font_types'] : pgscore_font_icons( 'all' );

	$icon_group = ( isset( $args['group'] ) && ! empty( $args['group'] ) ) ? $args['group'] : false;

	// Icon Liberary Dropdown
	$icon_liberary = array(
		'type'        => 'dropdown',
		'param_name'  => $icon_library_param_name,
		'heading'     => esc_html__( 'Icon Library', 'pgs-core' ),
		'description' => esc_html__( 'Select icon library.', 'pgs-core' ),
	);

	foreach ( $font_types as $font_type ) {
		$font_data = pgscore_font_icons( $font_type );

		if ( $font_data ) {
			$font_data_slug       = $font_data['slug'];
			$font_data_name       = $font_data['name'];
			$font_data_field_data = $font_data['field-data'];

			$icon_type_data[ $font_data_slug ] = $font_data_name;

			// Icon Fields
			$icon_fields[ $font_data_slug ]               = $font_data_field_data;
			$icon_fields[ $font_data_slug ]['dependency'] = array(
				'element' => $icon_library_param_name,
				'value'   => $font_data_slug,
			);
			if ( $icon_group ) {
				$icon_fields[ $font_data_slug ]['group'] = $icon_group;
			}
		}
	}

	// apply filters
	$icon_type_data = apply_filters( 'pgscore_icon_types', $icon_type_data, $args );

	// Reverse array_key with array_values to make compatible with Visual Composer
	$icon_type_data = array_flip( $icon_type_data );

	// Set returned font data
	$icon_liberary['value'] = $icon_type_data;

	/********************************************
	 *
	 * Icon Library
	 *
	 ********************************************/
	// Library Dependency
	if ( isset( $args['dependency'] ) && is_array( $args['dependency'] ) && ! empty( $args['dependency'] ) ) {
		$icon_liberary['dependency'] = $args['dependency'];
	}

	// Library Group
	if ( $icon_group ) {
		$icon_liberary['group'] = $icon_group;
	}

	// Assign Library Field to Icon Picker
	$icon_picker[ $icon_library_param_name ] = $icon_liberary;
	$icon_picker                             = array_merge( $icon_picker, $icon_fields );

	return $icon_picker;
}

function pgscore_font_icons( $font_type ) {

	// Return if no font type is provided
	if ( empty( $font_type ) ) {
		return false;
	}

	if ( function_exists( 'vc_pixel_icons' ) ) {
		$pixel_icons = vc_pixel_icons();
	} else {
		$pixel_icons = array();
	}

	$font_data = false;

	$fonts = array(
		'fontawesome' => array(
			'slug'       => 'fontawesome',
			'name'       => esc_html__( 'Font Awesome', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_fontawesome',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'fas fa-adjust',
				'settings'    => array(
					'emptyIcon'    => false,
					'iconsPerPage' => 300,
				),
			),
		),
		'openiconic'  => array(
			'slug'       => 'openiconic',
			'name'       => esc_html__( 'Open Iconic', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_openiconic',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'vc-oi vc-oi-dial',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'openiconic',
					'iconsPerPage' => 4000,
				),
			),
		),
		'typicons'    => array(
			'slug'       => 'typicons',
			'name'       => esc_html__( 'Typicons', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_typicons',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'typcn typcn-adjust-brightness',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'typicons',
					'iconsPerPage' => 4000,
				),
			),
		),
		'entypo'      => array(
			'slug'       => 'entypo',
			'name'       => esc_html__( 'Entypo', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_entypo',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'entypo-icon entypo-icon-note',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'entypo',
					'iconsPerPage' => 4000,
				),
			),
		),
		'linecons'    => array(
			'slug'       => 'linecons',
			'name'       => esc_html__( 'Linecons', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_linecons',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'vc_li vc_li-heart',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'linecons',
					'iconsPerPage' => 4000,
				),
			),
		),
		'monosocial'  => array(
			'slug'       => 'monosocial',
			'name'       => esc_html__( 'Mono Social', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_monosocial',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'vc-mono vc-mono-fivehundredpx',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'monosocial',
					'iconsPerPage' => 4000,
				),
			),
		),
		'material'    => array(
			'slug'       => 'material',
			'name'       => esc_html__( 'Material', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_material',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'vc-material vc-material-cake',
				'settings'    => array(
					'emptyIcon'    => false,
					'type'         => 'material',
					'iconsPerPage' => 4000,
				),
			),
		),
		'pixelicons'  => array(
			'slug'       => 'pixelicons',
			'name'       => esc_html__( 'Pixel', 'pgs-core' ),
			'field-data' => array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'pgs-core' ),
				'param_name'  => 'icon_pixelicons',
				'description' => esc_html__( 'Select icon from library.', 'pgs-core' ),
				'value'       => 'vc_pixel_icon vc_pixel_icon-alert',
				'settings'    => array(
					'emptyIcon' => false,
					'type'      => 'pixelicons',
					'source'    => $pixel_icons,
				),
			),
		),
		'flaticon'    => array(
			'slug'       => 'flaticon',
			'name'       => esc_html__( 'Flaticon', 'pgs-core' ),
			'field-data' => array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'pgs-core' ),
				'param_name' => 'icon_flaticon',
				'value'      => 'glyph-icon pgsicon-ecommerce-locked',
				'settings'   => array(
					'emptyIcon'    => true,
					'type'         => 'flaticon',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'flaticon',
				),
			),
		),
		'themefy'     => array(
			'slug'       => 'themefy',
			'name'       => esc_html__( 'themefy', 'pgs-core' ),
			'field-data' => array(
				'type'       => 'iconpicker',
				'heading'    => esc_html__( 'Icon', 'pgs-core' ),
				'param_name' => 'icon_themefy',
				'value'      => 'ti-arrow-up',
				'settings'   => array(
					'emptyIcon'    => true,
					'type'         => 'themefy',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'type',
					'value'   => 'themefy',
				),
			),
		),
	);

	$param_name_prefix = 'icon_';

	$fonts = apply_filters( 'pgscore_vc_iconpicker', $fonts, $param_name_prefix );

	if ( 'all' == $font_type ) {
		$font_data = array_keys( $fonts );
	} else {
		if ( array_key_exists( $font_type, $fonts ) ) {
			$font_data = $fonts[ $font_type ];
		}
	}
	return $font_data;
}
