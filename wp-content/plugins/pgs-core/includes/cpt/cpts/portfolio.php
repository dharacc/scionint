<?php
/**
 * Register "portfolio" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function pgscore_register_cpt_portfolio() {
	$labels = array(
		'name'                  => esc_html__( 'Portfolio', 'pgs-core' ),
		'singular_name'         => esc_html__( 'Portfolio', 'pgs-core' ),
		'menu_name'             => esc_html__( 'Portfolio', 'pgs-core' ),
		'name_admin_bar'        => esc_html__( 'Portfolio', 'pgs-core' ),
		'add_new'               => esc_html__( 'Add New', 'pgs-core' ),
		'add_new_item'          => esc_html__( 'Add New Portfolio', 'pgs-core' ),
		'new_item'              => esc_html__( 'New Portfolio', 'pgs-core' ),
		'edit_item'             => esc_html__( 'Edit Portfolio', 'pgs-core' ),
		'view_item'             => esc_html__( 'View Portfolio', 'pgs-core' ),
		'all_items'             => esc_html__( 'All Portfolio', 'pgs-core' ),
		'search_items'          => esc_html__( 'Search Portfolio', 'pgs-core' ),
		'parent_item_colon'     => esc_html__( 'Parent Portfolio:', 'pgs-core' ),
		'not_found'             => esc_html__( 'No portfolioss found.', 'pgs-core' ),
		'not_found_in_trash'    => esc_html__( 'No portfolioss found in Trash.', 'pgs-core' ),
		'featured_image'        => esc_html__( 'Portfolio Image', 'pgs-core' ),
		'set_featured_image'    => esc_html__( 'Set Portfolio Image', 'pgs-core' ),
		'remove_featured_image' => esc_html__( 'Remove Portfolio Image', 'pgs-core' ),
		'use_featured_image'    => esc_html__( 'Use Portfolio Image', 'pgs-core' ),
	);

	$cpt_portfolio_args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Description.', 'pgs-core' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'menu_icon'          => 'dashicons-portfolio',
	);

	$cpt_portfolio_args = apply_filters( 'pgscore_register_cpt_portfolio', $cpt_portfolio_args );

	register_post_type( 'portfolio', $cpt_portfolio_args );
}

add_action( 'init', 'pgscore_register_cpt_portfolio' );

/**
 * Register 'portfolio-category' taxonomy for post type 'portfolio'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_portfolio_category() {
	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => esc_html__( 'Portfolio Categories', 'pgs-core' ),
		'singular_name'              => esc_html__( 'Portfolio Category', 'pgs-core' ),
		'search_items'               => esc_html__( 'Search Categories', 'pgs-core' ),
		'popular_items'              => esc_html__( 'Popular Categories', 'pgs-core' ),
		'all_items'                  => esc_html__( 'All Categories', 'pgs-core' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => esc_html__( 'Edit Category', 'pgs-core' ),
		'update_item'                => esc_html__( 'Update Category', 'pgs-core' ),
		'add_new_item'               => esc_html__( 'Add New Category', 'pgs-core' ),
		'new_item_name'              => esc_html__( 'New Category Name', 'pgs-core' ),
		'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'pgs-core' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'pgs-core' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used Categories', 'pgs-core' ),
		'not_found'                  => esc_html__( 'No categories found.', 'pgs-core' ),
		'menu_name'                  => esc_html__( 'Categories', 'pgs-core' ),
	);

	$portfolio_category_args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'public'                => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'portfolio-category' ),
	);

	$portfolio_category_args = apply_filters( 'pgscore_register_taxonomy_portfolio_category', $portfolio_category_args, 'portfolio' );

	register_taxonomy( 'portfolio-category', 'portfolio', $portfolio_category_args );
}

add_action( 'init', 'pgscore_register_taxonomy_portfolio_category' );


/**
 * Register 'portfolio-tag' taxonomy for post type 'portfolio'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_portfolio_tag() {
	$portfolio_tag_args = array(
		'hierarchical'      => true,
		'label'             => esc_html__( 'Tags', 'pgs-core' ),
		'singular_name'     => esc_html__( 'Tag', 'pgs-core' ),
		'show_admin_column' => true,
		'rewrite'           => true,
		'query_var'         => true,
	);

	$portfolio_tag_args = apply_filters( 'pgscore_register_taxonomy_portfolio_tag', $portfolio_tag_args, 'portfolio' );

	register_taxonomy( 'portfolio-tag', 'portfolio', $portfolio_tag_args );
}

add_action( 'init', 'pgscore_register_taxonomy_portfolio_tag' );


/**
 * Register 'portfolio-skills' taxonomy for post type 'portfolio'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_portfolio_skills() {
	$portfolio_skills_args = array(
		'hierarchical'      => true,
		'label'             => esc_html__( 'Skills', 'pgs-core' ),
		'singular_name'     => esc_html__( 'Skill', 'pgs-core' ),
		'show_ui'           => true,
		'show_admin_column' => true,
		'public'            => false,
		'rewrite'           => true,
		'query_var'         => true,
	);

	$portfolio_skills_args = apply_filters( 'pgscore_register_taxonomy_portfolio_skills', $portfolio_skills_args, 'portfolio' );

	register_taxonomy( 'portfolio-skills', 'portfolio', $portfolio_skills_args );
}

add_action( 'init', 'pgscore_register_taxonomy_portfolio_skills' );

/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_portfolios_edit_columns( $columns ) {
	$newcolumns = array(
		'cb'                  => "<input type='checkbox' />",
		'portfolio_thumbnail' => esc_html__( 'Photo', 'pgs-core' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}
add_filter( 'manage_edit-portfolio_columns', 'pgscore_cpt_portfolios_edit_columns' );

/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_portfolio_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'portfolio_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( array( '50', '50' ) );
			}
			break;
	}
}
add_action( 'manage_posts_custom_column', 'pgscore_cpt_portfolio_custom_columns' );
