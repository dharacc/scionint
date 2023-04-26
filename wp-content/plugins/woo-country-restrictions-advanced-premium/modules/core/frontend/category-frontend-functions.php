<?php

if (!function_exists("vcwccr_filter_category_query")) {
	add_action('wcacr_filter_products_query', 'vcwccr_filter_category_query');

	function vcwccr_filter_category_query($q) {
		if (!is_product_category()) {
			return;
		}

		$term_id = $q->queried_object->term_id;

		$apply_operator = get_term_meta($term_id, "vcwccr_apply_this_to", true);

		if ($apply_operator === "products_only") {
			return;
		}

		if (!vcwccr_is_restricted($term_id, "category")) {
			return;
		}
		$restriction_type = get_option('wccr_archive_restriction_type', '');
		if ($restriction_type !== 'not_found') {
			$q->set('post_name__in', array(wp_generate_password()));
			remove_action('woocommerce_no_products_found', 'wc_no_products_found');
			add_action('woocommerce_no_products_found', 'wcacr_display_category_message');
		} else {
			$q->set_404();
		}
	}

}

if (!function_exists("vcwccr_remove_terms")) {

	add_filter("get_terms", "vcwccr_remove_terms", 10, 4);

	function vcwccr_remove_terms($terms, $taxonomies, $args, $term_query) {

		$available_terms = array();

		foreach ($terms as $term) {

			if (is_object($term)) {
				$term_id = $term->term_id;
			} elseif (is_int($term)) {
				$term_id = $term;
			} elseif (!empty($args['fields']) && in_array($args['fields'], array('names', 'slugs'))) {
				$raw_term = get_term_by(rtrim($args['fields'], 's'), $term, $taxonomies[0]);
				$term_id = $raw_term->term_id;
			}

			if (empty($term_id)) {
				continue;
			}
			$apply_operator = get_term_meta($term_id, "vcwccr_apply_this_to", true);

			if (!empty($apply_operator) && $apply_operator != "products_only") {
				if (vcwccr_is_restricted($term_id, "category")) {
					continue;
				}
			}

			$available_terms[] = $term;
		}

		return $available_terms;
	}

}

if (!function_exists("vcwccr_remove_terms_from_menu")) {

	add_filter('wp_get_nav_menu_items', 'vcwccr_remove_terms_from_menu', 10, 3);

	function vcwccr_remove_terms_from_menu($items, $menu, $args) {

		$available_menu_items = array();

		foreach ($items as $item) {

			if (in_array($item->object, vcwccr_get_taxonomies_for_restrictions(), true)) {
				$term_id = $item->object_id;
				$apply_operator = get_term_meta($term_id, "vcwccr_apply_this_to", true);

				if ($apply_operator != "products_only") {
					if (vcwccr_is_restricted($term_id, "category")) {
						continue;
					}
				}
			}

			$available_menu_items[] = $item;
		}

		return $available_menu_items;
	}

}

