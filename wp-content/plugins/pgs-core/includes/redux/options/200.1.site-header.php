<?php
$custom_headers = '';

if ( function_exists( 'ciyashop_get_custom_headers' ) ) {
	$custom_headers = ciyashop_get_custom_headers();
}

return array(
	'title'            => esc_html__( 'Site Header', 'pgs-core' ),
	'id'               => 'appearance_subsection_site_header',
	'desc'             => esc_html__( 'You can manage site header settings here, like Header Type, Header Colors, Top Bar, Top bar Colors and other various settings.', 'pgs-core' ),
	'subsection'       => true,
	'customizer_width' => '400px',
	'fields'           => array(
		array(
			'id'       => 'header_type_info',
			'type'     => 'info',
			'title'    => __( 'Notice', 'pgs-core' ),
			'style'    => 'warning',
			'icon'     => 'el el-info-circle',
			'desc'     => esc_html__( 'To use the "Header Builder" layouts you have to create the header in the header builder section.', 'pgs-core' ),
			'required' => array(
				array( 'header_type_select', 'equals', 'header_builder' ),
			),
		),
		array(
			'id'      => 'header_type_select',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Select header type', 'pgs-core' ),
			'desc'    => esc_html__( 'Select the header type.', 'pgs-core' ),
			'options' => array(
				'predefined'     => esc_html__( 'Predefined', 'pgs-core' ),
				'header_builder' => esc_html__( 'Header Builder', 'pgs-core' ),
			),
			'default' => 'predefined',
		),
		array(
			'id'          => 'header_type',
			'type'        => 'select_image_new',
			'title'       => esc_html__( 'Header Style', 'pgs-core' ),
			'placeholder' => esc_html__( 'Select header style.', 'pgs-core' ),
			'select2'     => array(
				'allowClear' => 0,
			),
			'options'     => array(
				'default'                 => array(
					'alt'   => esc_html__( 'default', 'pgs-core' ),
					'title' => esc_html__( 'Classic', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/default.png' ),
				),
				'logo-center'             => array(
					'alt'   => esc_html__( 'logo-center', 'pgs-core' ),
					'title' => esc_html__( 'Logo Center', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/logo-center.png' ),
				),
				'menu-center'             => array(
					'alt'   => esc_html__( 'menu-center', 'pgs-core' ),
					'title' => esc_html__( 'Menu Center', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/menu-center.png' ),
				),
				'menu-right'              => array(
					'alt'   => esc_html__( 'menu-right', 'pgs-core' ),
					'title' => esc_html__( 'Menu Right', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/menu-right.png' ),
				),
				'topbar-with-main-header' => array(
					'alt'   => esc_html__( 'topbar-with-main-header', 'pgs-core' ),
					'title' => esc_html__( 'Topbar with Main Header', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/topbar-with-main-header.png' ),
				),
				'right-topbar-main'       => array(
					'alt'   => esc_html__( 'right-topbar-main', 'pgs-core' ),
					'title' => esc_html__( 'Right Topbar & Main', 'pgs-core' ),
					'img'   => esc_url( PGSCORE_URL . 'images/options/header_type/right-topbar-main.png' ),
				),
			),
			'default'     => 'menu-center',
			'required'    => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'custom_headers',
			'type'     => 'select',
			'title'    => __( 'Select Custom Header', 'pgs-core' ),
			'subtitle' => __( 'Select the header to display on front', 'pgs-core' ),
			'options'  => $custom_headers,
			'required' => array(
				array( 'header_type_select', 'equals', 'header_builder' ),
			),
		),
		array(
			'id'       => 'header_width_info',
			'type'     => 'info',
			'style'    => 'warning',
			'desc'     => esc_html__( 'These options will work for "Menu Center" and "Menu Right" header layout and for the "Header Builder" header layouts.', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_width',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Header Width', 'pgs-core' ),
			'options'  => array(
				'full_width'  => esc_html__( 'Full Width', 'pgs-core' ),
				'fixed_width' => esc_html__( 'Fixed Width', 'pgs-core' ),
			),
			'default'  => 'fixed_width',
			'required' => array(
				array( 'site_layout', '=', 'fullwidth' ),
			),
		),
		array(
			'id'       => 'header_above_content_info',
			'type'     => 'info',
			'style'    => 'warning',
			'desc'     => esc_html__( 'These options will work for "Menu Center" and "Menu Right" header layout and for the "Header Builder" header layouts.', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'      => 'header_above_content',
			'type'    => 'switch',
			'title'   => esc_html__( 'Header above content?', 'pgs-core' ),
			'desc'    => esc_html__( 'This will display the header above the page content. This is useful when displaying here or slider section below the header.', 'pgs-core' ),
			'default' => '0', // 1 = on | 0 = off
			'on'      => 'Enabled',
			'off'     => 'Disabled',
		),
		array(
			'id'       => 'categories_menu_status',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Categories Menu', 'pgs-core' ),
			'options'  => array(
				'enable'  => esc_html__( 'Enable', 'pgs-core' ),
				'disable' => esc_html__( 'Disable', 'pgs-core' ),
			),
			'default'  => 'disable',
			'required' => array( 'header_type', '=', array( 'default', 'logo-center', 'topbar-with-main-header' ) ),
		),
		array(
			'id'     => 'menu_font_style-start',
			'type'   => 'section',
			'title'  => esc_html__( 'Menu Fonts', 'pgs-core' ),
			'indent' => true,
		),
		array(
			'id'    => 'menu_font_style_info',
			'type'  => 'info',
			'style' => 'info',
			'desc'  => esc_html__( 'These fields will be applicable only when Mega menu not enabled for "Primary Menu".', 'pgs-core' ),
			'icon'  => 'el el-info-circle',
		),
		array(
			'id'      => 'menu_font_style_enable',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Menu Fonts Style', 'pgs-core' ),
			'desc'    => esc_html__( 'This will enable the custom font style for menu.', 'pgs-core' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'custom'  => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default' => 'default',
		),
		array(
			'id'             => 'menu_fonts',
			'type'           => 'typography',
			'title'          => esc_html__( 'Menu Fonts', 'pgs-core' ),
			'subtitle'       => esc_html__( 'Specify menu font properties.', 'pgs-core' ),
			'google'         => true,
			'font-backup'    => false,
			'all_styles'     => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'units'          => 'px',
			'color'          => false,
			'default'        => array(
				'font-family' => 'Lato',
				'font-weight' => '400',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '15px',
				'line-height' => '26px',
			),
			'fonts'          => pgscore_redux_typography_font_backup(),
			'required'       => array(
				array( 'menu_font_style_enable', '=', 'custom' ),
			),
		),
		array(
			'id'             => 'sub_menu_fonts',
			'type'           => 'typography',
			'title'          => esc_html__( 'Sub Menu Fonts', 'pgs-core' ),
			'subtitle'       => esc_html__( 'Specify Sub menu font properties.', 'pgs-core' ),
			'google'         => true,
			'font-family'    => false,
			'font-backup'    => false,
			'all_styles'     => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'units'          => 'px',
			'color'          => false,
			'font-weight'    => false,
			'font-style'     => false,
			'default'        => array(
				'font-weight' => '400',
				'font-style'  => '',
				'color'       => '#dd9933',
				'font-size'   => '15px',
				'line-height' => '26px',
			),
			'fonts'          => pgscore_redux_typography_font_backup(),
			'required'       => array(
				array( 'menu_font_style_enable', '=', 'custom' ),
			),
		),
		array(
			'id'     => 'menu_font_style-end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'       => 'woocommerce_icons-start',
			'type'     => 'section',
			'title'    => esc_html__( 'WooCommerce Icons', 'pgs-core' ),
			'indent'   => true,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'      => 'show_header_cart',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show Cart Icon', 'pgs-core' ),
			'on'      => esc_html__( 'Yes', 'pgs-core' ),
			'off'     => esc_html__( 'No', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'       => 'shopping-cart-icon',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Cart Icon', 'pgs-core' ),
			'options'  => array(
				'fa fa-shopping-cart'                     => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-1.jpg',
					'class' => 'pgs-icon-large',
				),
				'fa fa-shopping-basket'                   => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-2.jpg',
					'class' => 'pgs-icon-large',
				),
				'fa fa-shopping-bag'                      => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-3.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-empty-shopping-cart' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-4.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-shopping-cart-1' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-5.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-shopping-bag-4' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-6.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-commerce-1' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/cart-icon-7.jpg',
					'class' => 'pgs-icon-large',
				),
			),
			'default'  => 'fa fa-shopping-cart',
			'class'    => 'cart-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array( 'show_header_cart', '=', 1 ),
			),
		),
		array(
			'id'      => 'show_header_compare',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show Compare Icon', 'pgs-core' ),
			'on'      => esc_html__( 'Yes', 'pgs-core' ),
			'off'     => esc_html__( 'No', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'       => 'woocommerce_compare_icon',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Compare Icon', 'pgs-core' ),
			'options'  => array(
				'fa fa-compress'                        => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-1.jpg',
					'class' => 'pgs-icon-large',
				),
				'fa fa-expand'                          => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-2.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-arrows-9' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-3.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-repeat-2' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-4.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-shuffle'  => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-5.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-arrows-7' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/compare-icon-6.jpg',
					'class' => 'pgs-icon-large',
				),
			),
			'default'  => 'fa fa-compress',
			'class'    => 'compare-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array( 'show_header_compare', '=', 1 ),
			),
		),
		array(
			'id'      => 'show_header_wishlist',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show Wishlist Icon', 'pgs-core' ),
			'on'      => esc_html__( 'Yes', 'pgs-core' ),
			'off'     => esc_html__( 'No', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'       => 'woocommerce_wishlist_icon',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Wishlist Icon', 'pgs-core' ),
			'options'  => array(
				'fa fa-heart'                           => array(
					'img'   => PGSCORE_URL . 'images/options/icons/wishlist-icon-1.jpg',
					'class' => 'pgs-icon-large',
				),
				'fa fa-heart-o'                         => array(
					'img'   => PGSCORE_URL . 'images/options/icons/wishlist-icon-2.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-heart'    => array(
					'img'   => PGSCORE_URL . 'images/options/icons/wishlist-icon-3.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-shapes-1' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/wishlist-icon-4.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-like'     => array(
					'img'   => PGSCORE_URL . 'images/options/icons/wishlist-icon-5.jpg',
					'class' => 'pgs-icon-large',
				),
			),
			'default'  => 'fa fa-heart',
			'class'    => 'wishlist-icon-large radio-icon-selector-horizontal',
			'required' => array(
				array( 'show_header_wishlist', '=', 1 ),
			),
		),
		array(
			'id'       => 'woocommerce_icons-end',
			'type'     => 'section',
			'indent'   => false,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'divider_1',
			'type'     => 'divide',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_colors_info',
			'type'     => 'raw',
			'content'  => esc_html__( 'Here below you can customize and control colors of Topbar, Main Header, and Navigation section. These colors will be extension to colors set from Color Scheme theme options. So, some elements in these section will use default colors from Color Scheme theme options. ', 'pgs-core' ),
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		/******************************************************************* Topbar */
		array(
			'id'       => 'header_nav_colors_info_header_type_menu_center',
			'type'     => 'info',
			'style'    => 'info',
			'desc'     => esc_html__( 'If header style is set to "Topbar with Main Header", the background color will not applicable, as because the topbar will be moved in default header area and use background color from there.', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'header_type', '=', array( 'topbar-with-main-header' ) ),
			),
		),
		array(
			'id'       => 'topbar_colors-start',
			'type'     => 'section',
			'title'    => esc_html__( 'Topbar Colors', 'pgs-core' ),
			'indent'   => true,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'topbar_bg_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Background Color Type', 'pgs-core' ),
			'options'  => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'custom'  => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'  => 'default',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'topbar_bg_color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background Color', 'pgs-core' ),
			'default'  => array(
				'color' => '#FFFFFF',
				'alpha' => 1,
			),
			'options'  => array(
				'show_input'             => true,
				'show_initial'           => true,
				'show_alpha'             => true,
				'show_palette'           => true,
				'show_palette_only'      => false,
				'show_selection_palette' => true,
				'max_palette_size'       => 10,
				'allow_empty'            => true,
				'clickout_fires_change'  => true,
				'choose_text'            => esc_html__( 'Choose', 'pgs-core' ),
				'cancel_text'            => esc_html__( 'Cancel', 'pgs-core' ),
				'show_buttons'           => true,
				'use_extended_classes'   => true,
				'palette'                => null,  // show default
				'input_text'             => esc_html__( 'Select Color', 'pgs-core' ),
			),
			'required' => array(
				array( 'topbar_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'          => 'topbar_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'pgs-core' ),
			'mode'        => 'background-color',
			'validate'    => 'color',
			'transparent' => false,
			'default'     => '#323232',
			'required'    => array(
				array( 'topbar_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'topbar_link_color',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Link Color', 'pgs-core' ),
			'regular'  => true,
			'hover'    => true,
			'active'   => false,
			'visited'  => false,
			'default'  => array(
				'regular' => '#323232',
				'hover'   => '#04d39f',
			),
			'required' => array(
				array( 'topbar_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'topbar_colors-end',
			'type'     => 'section',
			'indent'   => false,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		/******************************************************************* Header (Main) */
		array(
			'id'       => 'header_main_colors-start',
			'type'     => 'section',
			'title'    => esc_html__( 'Header (Main) Colors', 'pgs-core' ),
			'indent'   => true,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_main_bg_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Background Color Type', 'pgs-core' ),
			'options'  => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'custom'  => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'  => 'default',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_main_bg_color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background Color', 'pgs-core' ),
			'default'  => array(
				'color' => '#FFFFFF',
				'alpha' => 1,
			),
			'options'  => array(
				'show_input'             => true,
				'show_initial'           => true,
				'show_alpha'             => true,
				'show_palette'           => true,
				'show_palette_only'      => false,
				'show_selection_palette' => true,
				'max_palette_size'       => 10,
				'allow_empty'            => true,
				'clickout_fires_change'  => true,
				'choose_text'            => esc_html__( 'Choose', 'pgs-core' ),
				'cancel_text'            => esc_html__( 'Cancel', 'pgs-core' ),
				'show_buttons'           => true,
				'use_extended_classes'   => true,
				'palette'                => null,  // show default
				'input_text'             => esc_html__( 'Select Color', 'pgs-core' ),
			),
			'required' => array(
				array( 'header_main_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'          => 'header_main_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'pgs-core' ),
			'mode'        => 'background-color',
			'validate'    => 'color',
			'transparent' => false,
			'default'     => '#323232',
			'required'    => array(
				array( 'header_main_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'header_main_link_color',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Link Color', 'pgs-core' ),
			'regular'  => true,
			'hover'    => true,
			'active'   => false,
			'visited'  => false,
			'default'  => array(
				'regular' => '#323232',
				'hover'   => '#04d39f',
			),
			'required' => array(
				array( 'header_main_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'header_main_colors-end',
			'type'     => 'section',
			'indent'   => false,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		/******************************************************************* Header (Navigation) */
		array(
			'id'       => 'header_nav_colors-start',
			'type'     => 'section',
			'title'    => esc_html__( 'Header (Navigation) Colors', 'pgs-core' ),
			'indent'   => true,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_nav_colors_info',
			'type'     => 'info',
			'style'    => 'info',
			'desc'     => esc_html__( 'These colors, except Background Color, will be applicable only if the menu is a normal menu, instead of Mega Menu.', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_nav_colors_info_header_type_menu_center',
			'type'     => 'info',
			'style'    => 'info',
			'desc'     => esc_html__( 'If header style is set to "Menu Center", "Menu Right", or "Right Topbar & Main", the background color will not applicable, as because the menu will be moved in default header area and use background color from there.', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'header_type', '=', array( 'menu-center', 'menu-right', 'right-topbar-main' ) ),
			),
		),
		array(
			'id'       => 'header_nav_bg_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Background Color Type', 'pgs-core' ),
			'options'  => array(
				'default' => esc_html__( 'Default', 'pgs-core' ),
				'custom'  => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'  => 'default',
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
		array(
			'id'       => 'header_nav_bg_color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Background Color', 'pgs-core' ),
			'default'  => array(
				'color' => '#FFFFFF',
				'alpha' => 1,
			),
			'options'  => array(
				'show_input'             => true,
				'show_initial'           => true,
				'show_alpha'             => true,
				'show_palette'           => true,
				'show_palette_only'      => false,
				'show_selection_palette' => true,
				'max_palette_size'       => 10,
				'allow_empty'            => true,
				'clickout_fires_change'  => true,
				'choose_text'            => esc_html__( 'Choose', 'pgs-core' ),
				'cancel_text'            => esc_html__( 'Cancel', 'pgs-core' ),
				'show_buttons'           => true,
				'use_extended_classes'   => true,
				'palette'                => null,  // show default
				'input_text'             => esc_html__( 'Select Color', 'pgs-core' ),
			),
			'required' => array(
				array( 'header_nav_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'          => 'header_nav_text_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Text Color', 'pgs-core' ),
			'mode'        => 'background-color',
			'validate'    => 'color',
			'transparent' => false,
			'default'     => '#ffffff',
			'required'    => array(
				array( 'header_nav_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'header_nav_link_color',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Link Color', 'pgs-core' ),
			'regular'  => true,
			'hover'    => true,
			'active'   => false,
			'visited'  => false,
			'default'  => array(
				'regular' => '#323232',
				'hover'   => '#04d39f',
			),
			'required' => array(
				array( 'header_nav_bg_type', '=', array( 'custom' ) ),
			),
		),
		array(
			'id'       => 'header_nav_colors-end',
			'type'     => 'section',
			'indent'   => false,
			'required' => array(
				array( 'header_type_select', 'equals', 'predefined' ),
			),
		),
	),
);
