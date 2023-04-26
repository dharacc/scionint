<?php
/**
 * Register "teams" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function pgscore_register_cpt_teams() {
	$labels = array(
		'name'                  => esc_html__( 'Teams', 'pgs-core' ),
		'singular_name'         => esc_html__( 'Team', 'pgs-core' ),
		'menu_name'             => esc_html__( 'Teams', 'pgs-core' ),
		'name_admin_bar'        => esc_html__( 'Team', 'pgs-core' ),
		'add_new'               => esc_html__( 'Add New', 'pgs-core' ),
		'add_new_item'          => esc_html__( 'Add New Team', 'pgs-core' ),
		'new_item'              => esc_html__( 'New Team', 'pgs-core' ),
		'edit_item'             => esc_html__( 'Edit Team', 'pgs-core' ),
		'view_item'             => esc_html__( 'View Team', 'pgs-core' ),
		'all_items'             => esc_html__( 'All Teams', 'pgs-core' ),
		'search_items'          => esc_html__( 'Search Teams', 'pgs-core' ),
		'parent_item_colon'     => esc_html__( 'Parent Teams:', 'pgs-core' ),
		'not_found'             => esc_html__( 'No teams found.', 'pgs-core' ),
		'not_found_in_trash'    => esc_html__( 'No teams found in Trash.', 'pgs-core' ),
		'featured_image'        => esc_html__( 'Member Image', 'pgs-core' ),
		'set_featured_image'    => esc_html__( 'Set Member Image', 'pgs-core' ),
		'remove_featured_image' => esc_html__( 'Remove Member Image', 'pgs-core' ),
		'use_featured_image'    => esc_html__( 'Use Member Image', 'pgs-core' ),
	);

	$cpt_teams_args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Description.', 'pgs-core' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug'       => 'team-member',
			'with_front' => true,
			'feeds'      => true,
			'pages'      => false,
		),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'          => 'dashicons-groups',
	);

	$cpt_teams_args = apply_filters( 'pgscore_register_cpt_teams', $cpt_teams_args );

	register_post_type( 'teams', $cpt_teams_args );
}
add_action( 'init', 'pgscore_register_cpt_teams' );

/**
 * Register 'team-category' taxonomy for post type 'teams'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_team_category() {

	$labels = array(
		'name'                       => esc_html__( 'Team Categories', 'pgs-core' ),
		'singular_name'              => esc_html__( 'Team Category', 'pgs-core' ),
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

	$team_category_args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'team-category',
		),
		'public'                => false,
	);

	$team_category_args = apply_filters( 'pgscore_register_taxonomy_team_category', $team_category_args, 'teams' );

	register_taxonomy( 'team-category', 'teams', $team_category_args );
}
add_action( 'init', 'pgscore_register_taxonomy_team_category' );

/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_teams_edit_columns( $columns ) {
	$newcolumns = array(
		'cb'              => "<input type='checkbox' />",
		'teams_thumbnail' => esc_html__( 'Thumbnail', 'pgs-core' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}
add_filter( 'manage_edit-teams_columns', 'pgscore_cpt_teams_edit_columns' );


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_teams_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'teams_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( array( '50', '50' ) );
			}
			break;
	}
}
add_action( 'manage_posts_custom_column', 'pgscore_cpt_teams_custom_columns' );
