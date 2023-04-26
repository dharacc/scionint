<?php
/**
 *  Do not allow directly accessing this file.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_elements;

$header_elements['search'] = header_builder_element_search();

function header_builder_element_search() {

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

	$shortcode_fields = array(
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Search Type', 'pgs-core' ),
			'param_name'  => 'search_type',
			'options'     => array(
				'search_icon' => __( 'Icon', 'pgs-core' ),
				'search_form' => __( 'Form', 'pgs-core' ),
			),
			'default'     => 'search_form',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose the search type.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_icon',
			'heading'    => esc_html__( 'Search Icon', 'pgs-core' ),
			'param_name' => 'search_icon',
			'options'    => array(
				'search_icon_1' => '<i class="fa fa-search fa-2x" aria-hidden="true"></i>',
				'search_icon_2' => '<i class="glyph-icon pgsicon-ecommerce-search fa-2x" aria-hidden="true"></i>',
				'search_icon_3' => '<i class="glyph-icon pgsicon-ecommerce-magnifying-glass fa-2x" aria-hidden="true"></i>',
				'search_icon_4' => '<i class="glyph-icon pgsicon-ecommerce-magnifying-glass-1 fa-2x" aria-hidden="true"></i>',
			),
			'default'    => 'search_icon_2',
			'dependency' => array(
				'element' => 'search_type',
				'value'   => array( 'search_icon' ),
			),
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Search Input Placeholder', 'pgs-core' ),
			'param_name'  => 'search_input_placehlder',
			'default'     => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'placeholder' => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'search_type',
				'value'   => array( 'search_form' ),
			),
			'description' => esc_html__( 'Enter the Placeholder', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Search Box Shape', 'pgs-core' ),
			'param_name'  => 'search_box_shape',
			'options'     => array(
				'square'  => __( 'Square', 'pgs-core' ),
				'rounded' => __( 'Rounded', 'pgs-core' ),
			),
			'default'     => 'square',
			'classes'     => 'radio_label_only',
			'dependency'  => array(
				'element' => 'search_type',
				'value'   => array( 'search_form' ),
			),
			'description' => esc_html__( 'Choose search box shape.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Search Box Background', 'pgs-core' ),
			'param_name'  => 'search_box_background',
			'options'     => array(
				'default'     => __( 'Default', 'pgs-core' ),
				'transparent' => __( 'Transparent', 'pgs-core' ),
				'white'       => __( 'White', 'pgs-core' ),
				'dark'        => __( 'Dark', 'pgs-core' ),
				'theme'       => __( 'Theme', 'pgs-core' ),
			),
			'default'     => 'default',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose search box background.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'search_type',
				'value'   => array( 'search_form' ),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Search Content Type', 'pgs-core' ),
			'param_name'  => 'search_content_type',
			'options'     => array(
				'all'     => __( 'All', 'pgs-core' ),
				'product' => __( 'Product', 'pgs-core' ),
				'post'    => __( 'Post', 'pgs-core' ),
				'page'    => __( 'Page', 'pgs-core' ),
			),
			'default'     => 'all',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'Choose search content type.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_buttonset',
			'heading'    => esc_html__( 'Show Categories', 'pgs-core' ),
			'param_name' => 'show_categories',
			'options'    => array(
				'true'  => __( 'Yes', 'pgs-core' ),
				'false' => __( 'No', 'pgs-core' ),
			),
			'default'    => 'true',
			'dependency' => array(
				'element' => 'search_content_type',
				'value'   => array( 'product', 'post' ),
			),
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_buttonset',
			'heading'    => esc_html__( 'Show Keywords', 'pgs-core' ),
			'param_name' => 'show_keywords',
			'options'    => array(
				'true'  => __( 'Yes', 'pgs-core' ),
				'false' => __( 'No', 'pgs-core' ),
			),
			'default'    => 'true',
			'classes'    => 'radio_label_only',
			'description' => esc_html__( 'Keywords only visible for product search content type', 'pgs-core' ),
			'dependency' => array(
				'element' => 'search_type',
				'value'   => array( 'search_icon' ),
			),
			'group'      => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Search Keyword Title', 'pgs-core' ),
			'param_name'  => 'search_keywords_title',
			'default'     => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'placeholder' => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'description' => esc_html__( 'Enter the Placeholder', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'search_type',
				'value'   => array( 'search_icon' ),
			),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'           => 'dropdown',
			'heading'        => esc_html__( 'Keywords', 'pgs-core' ),
			'param_name'     => 'keywords[]',
			'default'        => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'placeholder'    => esc_html__( 'Enter Search Keyword...', 'pgs-core' ),
			'description'    => esc_html__( 'Enter the Placeholder', 'pgs-core' ),
			'multiple'       => true,
			'enable_select2' => true,
			'options'        => $cat_titles,
			'dependency'     => array(
				'element' => 'search_type',
				'value'   => array( 'search_icon' ),
			),
			'group'          => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
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
									__( 'Important : ID will be starts prefixed with "%s".', 'pgs-core' ),
									array(
										'atrong' => true,
									)
								),
								'<strong>search_' . '</strong>'
							)
							. '</span>',
			'settings'    => array(),
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
		'id'           => 'search',
		'name'         => esc_html__( 'Search', 'pgs-core' ),
		'description'  => esc_html__( 'Search Form', 'pgs-core' ),
		'class'        => 'pgscore_element_wrapper',
		'controls'     => 'full',
		'icon'         => PGSCORE_URL . 'images/header-builder/icons/search-icon.png',
		'element_icon' => 'ti-search',
		'params'       => $shortcode_fields,
	);

	return $params;

}
