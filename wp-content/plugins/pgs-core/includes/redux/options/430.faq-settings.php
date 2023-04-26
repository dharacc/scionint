<?php
return array(
	'title'            => esc_html__( 'FAQ Settings', 'pgs-core' ),
	'id'               => 'faq_settings',
	'customizer_width' => '450px',
	'icon'             => 'fa fa-question-circle',
	'fields'           => array(
		array(
			'id'       => 'faq_layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'FAQ Layout', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select FAQ page layout.', 'pgs-core' ),
			'options'  => array(
				'layout_1' => array(
					'alt' => esc_html__( 'Layout 1', 'pgs-core' ),
					'img' => esc_url( PGSCORE_URL . 'images/options/faq_layout/layout_1.png' ),
				),
				'layout_2' => array(
					'alt' => esc_html__( 'Layout 2', 'pgs-core' ),
					'img' => esc_url( PGSCORE_URL . 'images/options/faq_layout/layout_2.png' ),
				),
			),
			'default'  => 'layout_1',
		),
		array(
			'id'       => 'layout_1_cat_source',
			'type'     => 'radio',
			'title'    => esc_html__( 'Category Source', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select which categories do you want to display.', 'pgs-core' ),
			'options'  => array(
				'all'      => esc_html__( 'All', 'pgs-core' ),
				'selected' => esc_html__( 'Selected', 'pgs-core' ),
			),
			'default'  => 'all',
			'required' => array( 'faq_layout', '=', 'layout_1' ),
		),
		array(
			'id'       => 'layout_1_categories',
			'type'     => 'select',
			'title'    => esc_html__( 'Categories', 'pgs-core' ),
			'data'     => 'terms',
			'args'     => array(
				'taxonomies' => 'faq-category',
				'hide_empty' => true,
			),
			'multi'    => true,
			'sortable' => true,
			'select2'  => array(
				'allowClear'  => false,
				'placeholder' => 'Select categories',
			),
			'subtitle' => esc_html__( 'Select categories to display posts from.', 'pgs-core' ),
			'required' => array(
				array( 'faq_layout', '=', 'layout_1' ),
				array( 'layout_1_cat_source', '=', 'selected' ),
			),
		),
		array(
			'id'       => 'layout_2_category',
			'type'     => 'select',
			'title'    => esc_html__( 'Category', 'pgs-core' ),
			'data'     => 'terms',
			'args'     => array(
				'taxonomies' => 'faq-category',
				'hide_empty' => true,
			),
			'sortable' => false,
			'select2'  => array(
				'allowClear'  => true,
				'placeholder' => 'Select a category',
			),
			'subtitle' => esc_html__( 'Select category to display posts from.', 'pgs-core' ),
			'required' => array( 'faq_layout', '=', 'layout_2' ),
		),
	),
);
