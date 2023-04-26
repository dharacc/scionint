<?php
return array(
	'title'            => esc_html__( 'Single Post', 'pgs-core' ),
	'id'               => 'single_settings',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'single_metas',
			'type'     => 'checkbox',
			'title'    => esc_html__( 'Display Meta Items', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select and reorder meta items to display', 'pgs-core' ),
			'options'  => array(
				'author'     => esc_html__( 'Author', 'pgs-core' ),
				'categories' => esc_html__( 'Categories', 'pgs-core' ),
				'tags'       => esc_html__( 'Tags', 'pgs-core' ),
				'comments'   => esc_html__( 'Comments', 'pgs-core' ),
			),
			'default'  => array(
				'date'       => '1',
				'author'     => '1',
				'categories' => '1',
				'tags'       => '1',
				'comments'   => '1',
			),
		),
		array(
			'id'      => 'related_posts',
			'type'    => 'switch',
			'title'   => esc_html__( 'Related Posts', 'pgs-core' ),
			'desc'    => esc_html__( 'Show/hide related posts.', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'      => 'author_details',
			'type'    => 'switch',
			'title'   => esc_html__( 'Author Details', 'pgs-core' ),
			'desc'    => esc_html__( 'Show/hide author details.', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'      => 'post_nav',
			'type'    => 'switch',
			'title'   => esc_html__( 'Post Navigation', 'pgs-core' ),
			'desc'    => esc_html__( 'Show/hide previous-next post links.', 'pgs-core' ),
			'default' => true,
		),
	),
);
