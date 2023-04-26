<?php
function pgscore_get_terms( $args = array(), $args2 = '' ) {
	$return_data = array();

	if ( ! empty( $args2 ) ) {
		$result = get_terms( $args, $args2 );
	} else {
		if ( ! isset( $args['hide_empty'] ) ) {
			$args['hide_empty'] = true;
		}
		$result = get_terms( $args );
	}

	if ( is_wp_error( $result ) ) {
		return $return_data;
	}

	if ( ! is_array( $result ) || empty( $result ) ) {
		return $return_data;
	}

	foreach ( $result as $term_data ) {
		if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
			$return_data[ $term_data->name . ( ( isset( $args['pad_counts'] ) && $args['pad_counts'] ) ? ' (' . $term_data->count . ')' : '' ) ] = $term_data->term_id;
		}
	}
	return $return_data;
}

function get_terms_hierarchical_list( $terms, $new_array = array() ) {

	foreach ( $terms as $term ) {
		$new_array[ $term->term_id ] = $term;

		if ( ! empty( $term->children ) ) {
			$new_array = get_terms_hierarchical_list( $term->children, $new_array );
			unset( $term->children );
		} else {
			unset( $term->children );
		}
	}

	return $new_array;
}

/**
 * Recursively get taxonomy and its children
 *
 * @param string $taxonomy
 * @param int $parent - parent term id
 * @return array
 */
function get_terms_hierarchy( $taxonomy, $parent = 0 ) {
	// only 1 taxonomy
	$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;

	// get all direct decendants of the $parent
	$terms = get_terms( $taxonomy, array( 'parent' => $parent ) );

	// prepare a new array.  these are the children of $parent
	// we'll ultimately copy all the $terms into this new array, but only after they
	// find their own children
	$children = array();

	if ( ! is_wp_error( $terms ) ) {

		// go through all the direct decendants of $parent, and gather their children
		foreach ( $terms as $term ) {

			// Append hierarchy depth
			$term->depth = count( get_ancestors( $term->term_id, '', 'taxonomy' ) );

			// recurse to get the direct decendants of "this" term
			$term->children = get_terms_hierarchy( $taxonomy, $term->term_id );

			// add the term to our new array
			$children[ $term->term_id ] = $term;

		}
	}

	// send the results back to the caller
	return $children;
}
