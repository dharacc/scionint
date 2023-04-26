<?php
/*
 * Register Post Type for Size Guide
 */

add_action( 'init', 'pgscore_cpt_size_guide' );
function pgscore_cpt_size_guide() {
	$labels = array(
		'name'               => esc_html__( 'Size Guide', 'pgs-core' ),
		'singular_name'      => esc_html__( 'Size Guide', 'pgs-core' ),
		'menu_name'          => esc_html__( 'Size Guides', 'pgs-core' ),
		'name_admin_bar'     => esc_html__( 'Size Guide', 'pgs-core' ),
		'add_new'            => esc_html__( 'Add New', 'pgs-core' ),
		'add_new_item'       => esc_html__( 'Add New Size Guide', 'pgs-core' ),
		'new_item'           => esc_html__( 'New Size Guide', 'pgs-core' ),
		'edit_item'          => esc_html__( 'Edit Size Guide', 'pgs-core' ),
		'view_item'          => esc_html__( 'View Size Guide', 'pgs-core' ),
		'all_items'          => esc_html__( 'All Size Guides', 'pgs-core' ),
		'search_items'       => esc_html__( 'Search Size Guides', 'pgs-core' ),
		'parent_item_colon'  => esc_html__( 'Parent Size Guides:', 'pgs-core' ),
		'not_found'          => esc_html__( 'No Size Guides found.', 'pgs-core' ),
		'not_found_in_trash' => esc_html__( 'No Size Guides found in Trash.', 'pgs-core' ),
	);

	$cpt_faqs_args = array(
		'labels'             => $labels,
		'description'        => esc_html__( 'Description.', 'pgs-core' ),
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor' ),
	);

	$cpt_size_guides_args = apply_filters( 'pgscore_register_cpt_size_guides', $cpt_faqs_args );
	register_post_type( 'size_guides', $cpt_size_guides_args );
}
