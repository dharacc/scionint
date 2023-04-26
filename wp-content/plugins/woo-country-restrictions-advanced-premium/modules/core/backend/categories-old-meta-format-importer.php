<?php

if (!function_exists("vcwccr_import_categories_meta_old_format")) {

	add_action("init", "vcwccr_import_categories_meta_old_format");

	function vcwccr_import_categories_meta_old_format() {

		global $wpdb;

		$categories_restrictions_already_imported = (bool) get_option("vcwccr_categories_restrictions_data_imported");

		if ($categories_restrictions_already_imported) {
			return;
		}

		$query = "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE '%vcwccr_term_%'";

		$results = $wpdb->get_results($query, "ARRAY_A");

		if (empty($results)) {
			update_option("vcwccr_categories_restrictions_data_imported", "1");
			return;
		}

		foreach ($results as $result) {

			$option_name_exploded = explode("_", $result["option_name"]);

			$term_id = intval($option_name_exploded[2]);

			$data = unserialize($result["option_value"]);

			update_term_meta($term_id, "vcwccr_selected_countries", $data["selected_countries"]);
			update_term_meta($term_id, "vcwccr_availability_operator", $data["availabity_operator"]);
			update_term_meta($term_id, "vcwccr_apply_this_to", $data["apply_operator"]);
		}

		update_option("vcwccr_categories_restrictions_data_imported", "1");
	}

}

