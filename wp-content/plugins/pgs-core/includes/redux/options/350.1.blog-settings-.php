<?php
return array(
	'title'            => esc_html__( 'Blog Settings', 'pgs-core' ),
	'id'               => 'blog_settings',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'       => 'blog_sidebar',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Blog Sidebar', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select blog sidebar alignment.', 'pgs-core' ),
			'options'  => array(
				'full_width'    => array(
					'alt' => esc_html__( 'Full Width', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_sidebar/full_width.png',
				),
				'left_sidebar'  => array(
					'alt' => esc_html__( 'Left Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_sidebar/left_sidebar.png',
				),
				'right_sidebar' => array(
					'alt' => esc_html__( 'Right Sidebar', 'pgs-core' ),
					'img' => PGSCORE_URL . '/images/options/blog_sidebar/right_sidebar.png',
				),
			),
			'default'  => 'right_sidebar',
		),
		array(
			'id'       => 'blog_layout',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Blog Layout', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select blog style.', 'pgs-core' ),
			'options'  => array(
				'classic'  => array(
					'alt' => esc_html__( 'Classic', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_layout/classic.png',
				),
				'grid'     => array(
					'alt' => esc_html__( 'Grid', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_layout/grid.png',
				),
				'masonry'  => array(
					'alt' => esc_html__( 'Masonry', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_layout/masonry.png',
				),
				'timeline' => array(
					'alt' => esc_html__( 'Timeline', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/options/blog_layout/timeline.png',
				),
			),
			'default'  => 'classic',
		),
		array(
			'id'       => 'grid_size',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Grid Column Size', 'pgs-core' ),
			'options'  => array(
				'2' => esc_html__( '2 Column', 'pgs-core' ),
				'3' => esc_html__( '3 Column', 'pgs-core' ),
			),
			'default'  => '2',
			'required' => array(
				array( 'blog_sidebar', 'equals', 'full_width' ),
				array( 'blog_layout', '=', 'grid' ),
			),
		),
		array(
			'id'       => 'grid_size_info',
			'type'     => 'info',
			'title'    => esc_html__( 'Grid Size!', 'pgs-core' ),
			'style'    => 'warning',
			'icon'     => 'el-icon-info-sign',
			'desc'     => esc_html__( 'If sidebar is active grid size will be set to 2 columns by default.', 'pgs-core' ),
			'required' => array(
				array( 'blog_sidebar', '!=', 'full_width' ),
				array( 'blog_layout', '=', 'grid' ),
			),
		),
		array(
			'id'       => 'masonry_size',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Masonry Column Size', 'pgs-core' ),
			'options'  => array(
				'2' => esc_html__( '2 Column', 'pgs-core' ),
				'3' => esc_html__( '3 Column', 'pgs-core' ),
			),
			'default'  => '2',
			'required' => array(
				array( 'blog_sidebar', 'equals', 'full_width' ),
				array( 'blog_layout', '=', 'masonry' ),
			),
		),
		array(
			'id'       => 'masonry_size_info',
			'type'     => 'info',
			'title'    => esc_html__( 'Masonry Size!', 'pgs-core' ),
			'style'    => 'warning',
			'icon'     => 'el-icon-info-sign',
			'desc'     => esc_html__( 'If sidebar is active masonry size will be set to 2 columns by default.', 'pgs-core' ),
			'required' => array(
				array( 'blog_sidebar', '!=', 'full_width' ),
				array( 'blog_layout', '=', 'masonry' ),
			),
		),
		array(
			'id'       => 'blog_metas',
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
	),
);
