<?php
/**
 * Register "faqs" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */
function pgscore_register_cpt_faqs() {
	$labels = array(
		'name'               => esc_html__( 'Faqs', 'pgs-core' ),
		'singular_name'      => esc_html__( 'Faq', 'pgs-core' ),
		'menu_name'          => esc_html__( 'Faqs', 'pgs-core' ),
		'name_admin_bar'     => esc_html__( 'Faq', 'pgs-core' ),
		'add_new'            => esc_html__( 'Add New', 'pgs-core' ),
		'add_new_item'       => esc_html__( 'Add New Faq', 'pgs-core' ),
		'new_item'           => esc_html__( 'New Faq', 'pgs-core' ),
		'edit_item'          => esc_html__( 'Edit Faq', 'pgs-core' ),
		'view_item'          => esc_html__( 'View Faq', 'pgs-core' ),
		'all_items'          => esc_html__( 'All Faqs', 'pgs-core' ),
		'search_items'       => esc_html__( 'Search Faqs', 'pgs-core' ),
		'parent_item_colon'  => esc_html__( 'Parent Faqs:', 'pgs-core' ),
		'not_found'          => esc_html__( 'No faqss found.', 'pgs-core' ),
		'not_found_in_trash' => esc_html__( 'No faqss found in Trash.', 'pgs-core' ),
	);

	$cpt_faqs_args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Description.', 'pgs-core' ),
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array(
			'slug' => 'faqs',
		),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
		'menu_icon'          => 'dashicons-book',
	);

	$cpt_faqs_args = apply_filters( 'pgscore_register_cpt_faqs', $cpt_faqs_args );

	register_post_type( 'faqs', $cpt_faqs_args );
}
add_action( 'init', 'pgscore_register_cpt_faqs' );

/**
 * Register 'faq-category' taxonomy for post type 'faqs'.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
function pgscore_register_taxonomy_faq_category() {

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => esc_html__( 'Faq Categories', 'pgs-core' ),
		'singular_name'              => esc_html__( 'Faq Category', 'pgs-core' ),
		'search_items'               => esc_html__( 'Search aq Categories', 'pgs-core' ),
		'popular_items'              => esc_html__( 'Popular aq Categories', 'pgs-core' ),
		'all_items'                  => esc_html__( 'All aq Categories', 'pgs-core' ),
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

	$faq_category_args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array(
			'slug' => 'faq-category',
		),
	);

	$faq_category_args = apply_filters( 'pgscore_register_taxonomy_faq_category', $faq_category_args, 'faqs' );

	register_taxonomy( 'faq-category', 'faqs', $faq_category_args );
}

add_action( 'init', 'pgscore_register_taxonomy_faq_category' );
