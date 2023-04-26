<?php
/**
 * Register "CMS Block" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 */

function pgscore_register_cpt_blocks() {

	$labels = array(
		'name'               => _x( 'Static Blocks', 'Post Type General Name', 'pgs-core' ),
		'singular_name'      => _x( 'Static Block', 'Post Type Singular Name', 'pgs-core' ),
		'menu_name'          => __( 'Static Blocks', 'pgs-core' ),
		'parent_item_colon'  => __( 'Parent Item:', 'pgs-core' ),
		'all_items'          => __( 'All Items', 'pgs-core' ),
		'view_item'          => __( 'View Item', 'pgs-core' ),
		'add_new_item'       => __( 'Add New Item', 'pgs-core' ),
		'add_new'            => __( 'Add New', 'pgs-core' ),
		'edit_item'          => __( 'Edit Item', 'pgs-core' ),
		'update_item'        => __( 'Update Item', 'pgs-core' ),
		'search_items'       => __( 'Search Item', 'pgs-core' ),
		'not_found'          => __( 'Not found', 'pgs-core' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'pgs-core' ),
	);

	$args = array(
		'label'               => __( 'Static Block', 'pgs-core' ),
		'description'         => __( 'Static Blocks place blocks in your pages', 'pgs-core' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 29,
		'menu_icon'           => 'dashicons-editor-table',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => false,
		'capability_type'     => 'page',
	);

	register_post_type( 'static_block', $args );
}
add_action( 'init', 'pgscore_register_cpt_blocks' );

// Add shortcode column to block list

add_filter( 'manage_edit-static_block_columns', 'edit_static_blocks_columns' );
function edit_static_blocks_columns( $columns ) {
	$columns = array(
		'cb'        => '<input type="checkbox" />',
		'title'     => __( 'Title', 'pgs-core' ),
		'shortcode' => __( 'Shortcode', 'pgs-core' ),
		'date'      => __( 'Date', 'pgs-core' ),
	);

	return $columns;
}

add_action( 'manage_static_block_posts_custom_column', 'manage_static_blocks_columns', 10, 2 );
function manage_static_blocks_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'shortcode':
			echo '<strong>[static_block id="' . $post_id . '"]</strong>';
			break;
	}
}

if ( ! function_exists( 'pgs_html_block_shortcode' ) ) {
	function pgs_html_block_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);
		return pgs_get_html_block( $id );
	}
	add_shortcode( 'html_block', 'pgs_html_block_shortcode' );
}

if ( ! function_exists( 'pgs_static_block_shortcode' ) ) {
	function pgs_static_block_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);
		return pgs_get_html_block( $id );
	}
	add_shortcode( 'static_block', 'pgs_static_block_shortcode' );
}

if ( ! function_exists( 'pgs_get_html_block' ) ) {
	function pgs_get_html_block( $id ) {

		$content = get_post_field( 'post_content', $id );
		$content = do_shortcode( $content );

		$shortcodes_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );

		$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
		if ( ! empty( $shortcodes_css ) ) {
			$content .= $shortcodes_css;
		}
		$content .= '</style>';

		return $content;
	}
}
