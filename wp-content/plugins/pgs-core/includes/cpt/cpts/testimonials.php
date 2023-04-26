<?php
/**
 * Register "testimonials" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function pgscore_register_cpt_testimonials() {
	$labels = array(
		'name'                  => esc_html__( 'Testimonials', 'pgs-core' ),
		'singular_name'         => esc_html__( 'Testimonial', 'pgs-core' ),
		'menu_name'             => esc_html__( 'Testimonials', 'pgs-core' ),
		'name_admin_bar'        => esc_html__( 'Testimonial', 'pgs-core' ),
		'add_new'               => esc_html__( 'Add New', 'pgs-core' ),
		'add_new_item'          => esc_html__( 'Add New Testimonial', 'pgs-core' ),
		'new_item'              => esc_html__( 'New Testimonial', 'pgs-core' ),
		'edit_item'             => esc_html__( 'Edit Testimonial', 'pgs-core' ),
		'view_item'             => esc_html__( 'View Testimonial', 'pgs-core' ),
		'all_items'             => esc_html__( 'All Testimonials', 'pgs-core' ),
		'search_items'          => esc_html__( 'Search Testimonials', 'pgs-core' ),
		'parent_item_colon'     => esc_html__( 'Parent Testimonials:', 'pgs-core' ),
		'not_found'             => esc_html__( 'No testimonialss found.', 'pgs-core' ),
		'not_found_in_trash'    => esc_html__( 'No testimonialss found in Trash.', 'pgs-core' ),
		'featured_image'        => esc_html__( 'Author Image', 'pgs-core' ),
		'set_featured_image'    => esc_html__( 'Set Author Image', 'pgs-core' ),
		'remove_featured_image' => esc_html__( 'Remove Author Image', 'pgs-core' ),
		'use_featured_image'    => esc_html__( 'Use Author Image', 'pgs-core' ),
	);

	$cpt_testimonials_args = array(
		'labels'          => $labels,
		'description'     => esc_html__( 'Description.', 'pgs-core' ),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'query_var'       => true,
		'rewrite'         => array( 'slug' => 'testimonials' ),
		'capability_type' => 'post',
		'has_archive'     => false,
		'hierarchical'    => false,
		'menu_position'   => null,
		'supports'        => array( 'title', 'thumbnail' ),
		'menu_icon'       => 'dashicons-format-quote',
	);

	$cpt_testimonials_args = apply_filters( 'pgscore_register_cpt_testimonials', $cpt_testimonials_args );

	register_post_type( 'testimonials', $cpt_testimonials_args );
}

add_action( 'init', 'pgscore_register_cpt_testimonials' );

/**
 * Register 'testimonial-category' taxonomy for post type 'testimonials'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_testimonial_category() {
	// Add new taxonomy, NOT hierarchical (like tags)
	$testimonial_category_labels = array(
		'name'                       => esc_html__( 'Testimonial Categories', 'pgs-core' ),
		'singular_name'              => esc_html__( 'Testimonial Category', 'pgs-core' ),
		'search_items'               => esc_html__( 'Search Testimonial Categories', 'pgs-core' ),
		'popular_items'              => esc_html__( 'Popular Testimonial Categories', 'pgs-core' ),
		'all_items'                  => esc_html__( 'All Testimonial Categories', 'pgs-core' ),
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

	$testimonial_category_args = array(
		'hierarchical'          => true,
		'labels'                => $testimonial_category_labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'public'                => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'testimonial-category' ),
	);

	$testimonial_category_args = apply_filters( 'pgscore_register_taxonomy_testimonial_category', $testimonial_category_args, 'testimonials' );

	register_taxonomy( 'testimonial-category', 'testimonials', $testimonial_category_args );
}

add_action( 'init', 'pgscore_register_taxonomy_testimonial_category' );

/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_testimonials_edit_columns( $columns ) {
	$newcolumns = array(
		'cb'                     => "<input type='checkbox' />",
		'testimonials_thumbnail' => esc_html__( 'Photo', 'pgs-core' ),
		'title'                  => esc_html__( 'Title', 'pgs-core' ),
		'testimonial_order'      => esc_html__( 'Order', 'pgs-core' ),
	);
	$columns    = array_merge( $newcolumns, $columns );

	return $columns;
}
add_filter( 'manage_edit-testimonials_columns', 'pgscore_cpt_testimonials_edit_columns' );


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function pgscore_cpt_testimonials_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'testimonials_thumbnail':
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( array( '50', '50' ) );
			}
			break;
		case 'testimonial_order':
			echo $post->menu_order;
			break;
	}
}
add_action( 'manage_posts_custom_column', 'pgscore_cpt_testimonials_custom_columns' );


/**
 * Disable WYSIWYG editor
 *
 */
function pgscore_cpt_testimonial_disable_wysiwyg( $default ) {
	global $post;

	if ( isset( $post ) && 'testimonials' === $post->post_type ) {
		return false;
	}

	return $default;
}
add_filter( 'user_can_richedit', 'pgscore_cpt_testimonial_disable_wysiwyg' );


/**
 * Remove media button
 *
 */
function pgscore_cpt_testimonial_remove_media_button() {
	global $current_screen;

	// use 'post', 'page' or 'custom-post-type-name'
	if ( isset( $current_screen ) && 'testimonials' == $current_screen->post_type ) {
		remove_action( 'media_buttons', 'media_buttons' );
	}
}
add_action( 'admin_head', 'pgscore_cpt_testimonial_remove_media_button' );
