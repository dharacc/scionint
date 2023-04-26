<?php

if (!function_exists("vcwccr_import_attributes_old_format")) {

	add_action("init", "vcwccr_import_attributes_old_format");

	function vcwccr_import_attributes_old_format() {

		$attributes_data_already_imported = (bool) get_option("vcwccr_attributes_data_data_imported");
		$has_old_attributes = get_option('vcwccr_selected_attributes');

		if ($attributes_data_already_imported || empty($has_old_attributes)) {
			return;
		}

		$countries = get_option('vcwccr_attributes_selected_countries');
		$attributes = get_option('vcwccr_selected_attributes');
		$operator = get_option('vcwccr_attributes_availability_operator');

		$attributes_rules = array(
			array(
				'countries' => $countries,
				'attributes' => $attributes,
				'operator' => $operator,
			)
		);
		update_option('vcwccr_attributes_rules', $attributes_rules);

		update_option("vcwccr_attributes_data_data_imported", "1");
	}

}

