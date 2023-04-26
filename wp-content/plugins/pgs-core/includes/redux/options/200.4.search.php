<?php
$cat_titles = array();

$args = array(
	'type'         => 'post',
	'orderby'      => 'id',
	'order'        => 'DESC',
	'hide_empty'   => false,
	'hierarchical' => 1,
	'taxonomy'     => 'product_cat',
	'pad_counts'   => false,
);

$post_categories = get_categories( $args );


foreach ( $post_categories as $cat ) {
	$cat_titles[ $cat->term_id ] = $cat->name;
}

return array(
	'title'            => esc_html__( 'Search', 'pgs-core' ),
	'id'               => 'search_section',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'    => 'cs_search_info',
			'type'  => 'info',
			'title' => __( 'Notice', 'pgs-core' ),
			'style' => 'warning',
			'icon'  => 'el el-info-circle',
			'desc'  => esc_html__( 'These Settings are not applicable for custom header, for the custom header, you can use header builder.', 'pgs-core' ),
		),
		array(
			'id'      => 'show_search',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable Search', 'pgs-core' ),
			'on'      => esc_html__( 'Yes', 'pgs-core' ),
			'off'     => esc_html__( 'No', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'          => 'search_background_type',
			'type'        => 'button_set',
			'title'       => esc_html__( 'Search Box Background', 'pgs-core' ),
			'options'     => array(
				'search-bg-default'     => esc_html__( 'Default', 'pgs-core' ),
				'search-bg-transparent' => esc_html__( 'Transparent', 'pgs-core' ),
				'search-bg-white'       => esc_html__( 'White', 'pgs-core' ),
				'search-bg-dark'        => esc_html__( 'Dark', 'pgs-core' ),
				'search-bg-theme'       => esc_html__( 'Theme', 'pgs-core' ),
			),
			'description' => esc_html__( 'Select the Search Background Color Type.', 'pgs-core' ),
			'default'     => 'search-bg-default',
			'required'    => array(
				array( 'show_search', '=', 1 ),
				array( 'header_type', '=', 'default' ),
			),
		),
		array(
			'id'       => 'search_box_shape',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Search Box Shape', 'pgs-core' ),
			'options'  => array(
				'square'  => esc_html__( 'Square', 'pgs-core' ),
				'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
			),
			'desc'     => esc_html__( 'Note: This field is applicable only, when "Header Style" is set to "Default".', 'pgs-core' ),
			'default'  => 'square',
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'header_type', '=', 'default' ),
			),
		),
		array(
			'id'       => 'search_placeholder_text',
			'type'     => 'text',
			'title'    => esc_html__( 'Search Input Placeholder', 'pgs-core' ),
			'default'  => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'required' => array(
				array( 'show_search', '=', 1 ),
			),
		),
		array(
			'id'       => 'search_content_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Search Content Type', 'pgs-core' ),
			'options'  => array(
				'all'     => esc_html__( 'All', 'pgs-core' ),
				'post'    => esc_html__( 'post', 'pgs-core' ),
				'product' => esc_html__( 'Product', 'pgs-core' ),
				'page'    => esc_html__( 'page', 'pgs-core' ),
			),
			'default'  => 'all',
			'required' => array(
				array( 'show_search', '=', 1 ),
			),
		),
		array(
			'id'       => 'show_categories',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show Categories', 'pgs-core' ),
			'on'       => esc_html__( 'Yes', 'pgs-core' ),
			'off'      => esc_html__( 'No', 'pgs-core' ),
			'default'  => true,
			'required' => array(
				array( 'search_content_type', '=', array( 'post', 'product' ) ),
			),
		),

		array(
			'id'       => 'search_keywords_start_info',
			'type'     => 'info',
			'style'    => 'warning',
			'desc'     => esc_html__( 'These fields will be applicable only when, "Header Style" is set to "Logo Center", "Menu Center", "Menu Right", "Topbar with Main Header", or "Right Topbar & Main".', 'pgs-core' ),
			'icon'     => 'el el-info-circle',
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array( 'product' ) ),
				array( 'header_type', '!=', array( 'default' ) ),
			),
		),

		array(
			'id'       => 'site_search_icon',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Search Icon', 'pgs-core' ),
			'options'  => array(
				'fa fa-search'                        => array(
					'img'   => PGSCORE_URL . 'images/options/icons/search-icon-1.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-search' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/search-icon-2.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-magnifying-glass' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/search-icon-3.jpg',
					'class' => 'pgs-icon-large',
				),
				'glyph-icon pgsicon-ecommerce-magnifying-glass-1' => array(
					'img'   => PGSCORE_URL . 'images/options/icons/search-icon-4.jpg',
					'class' => 'pgs-icon-large',
				),
			),
			'default'  => 'fa fa-search',
			'class'    => 'wishlist-icon-large radio-icon-selector-horizontal',
			'desc'     => esc_html__( 'These search icons will be applicable, when search icon is displaying only in header section, instead of full search field.', 'pgs-core' ),
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'header_type', '!=', array( 'default' ) ),
			),
		),

		/* ------------------------------------------------- Search Keyword ------------------------------------------------- */
		array(
			'id'       => 'search_keywords_start',
			'type'     => 'section',
			'title'    => esc_html__( 'Search Keyword', 'pgs-core' ),
			'indent'   => true,
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array( 'product' ) ),
				array( 'header_type', '!=', array( 'default' ) ),
			),
		),

		array(
			'id'       => 'show_search_keywords',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show Keywords', 'pgs-core' ),
			'on'       => esc_html__( 'Yes', 'pgs-core' ),
			'off'      => esc_html__( 'No', 'pgs-core' ),
			'default'  => true,
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array( 'product' ) ),
				array( 'header_type', '!=', array( 'default' ) ),
			),
		),
		array(
			'id'       => 'search_keywords_title',
			'type'     => 'text',
			'title'    => esc_html__( 'Search Keyword Title', 'pgs-core' ),
			'default'  => esc_html__( 'Popular Search', 'pgs-core' ),
			'required' => array(
				array( 'show_search_keywords', '=', true ),
			),
		),
		array(
			'id'       => 'search_keywords',
			'type'     => 'select',
			'multi'    => true,
			'title'    => esc_html__( 'Keywords', 'pgs-core' ),
			'desc'     => esc_html__( 'This keywords will display on search Popup', 'pgs-core' ),
			'sortable' => true,
			'options'  => $cat_titles,
			'required' => array(
				array( 'show_search_keywords', '=', true ),
			),
		),
		array(
			'id'       => 'search_keywords_end',
			'type'     => 'section',
			'indent'   => false,
			'required' => array(
				array( 'show_search', '=', 1 ),
				array( 'search_content_type', '=', array( 'product' ) ),
				array( 'header_type', '!=', array( 'default' ) ),
			),
		),
	),
);
