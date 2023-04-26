<?php
if (!function_exists("vcwccr_select")) {

	function vcwccr_select($args = array()) {

		$default_args = array(
			"id" => "",
			"options" => array(),
			"multiple" => false,
			"value" => false
		);

		$args = array_merge($default_args, $args);
		?>
		<style>
			/*FIX Sometimes the selected options in the select2 are moved to the left and some are not visible due to the overflow:hidden, so we add the scroll bar*/
			.select2-container--default .select2-selection--multiple .select2-selection__rendered {
				overflow: auto;
			}
		</style>
		<select id = '<?php echo $args['id'] ?>' 
				name = '<?php echo $args["multiple"] ? $args['id'] . "[]" : $args['id'] ?>' 
				<?php echo $args['multiple'] ? "multiple='multiple'" : ""; ?>>

			<?php
			if (!empty($args['options']) && is_array($args['options'])) {

				foreach ($args['options'] as $key => $option) {
					?>
					<option value = '<?php echo $key; ?>'
					<?php
					if ($args["value"] !== false) {
						echo ( is_array($args["value"]) && $args["multiple"] ) ? selected(in_array($key, $args["value"]), true, false) : selected($key == $args["value"], true, false);
					}
					?>> 
								<?php echo $option; ?>
					</option>
					<?php
				}
			}
			?>

		</select> 
		<?php
		if ($args["multiple"]) {
			?>
			<script>
				jQuery(document).ready(function ($) {
					$('#<?php echo $args['id'] ?>').select2(<?php
			if (!empty($args["select_2_init_args"])) {
				?>
						JSON.parse('<?php echo json_encode($args["select_2_init_args"]); ?>');
				<?php
			}
			?>
					);
				});
			</script>    
			<?php
		}
	}

}

if (!function_exists("vcwccr_add_product_category_restrictions_form_fields")) {
	add_action('init', 'wcacr_add_taxonomy_form_fields');

	function wcacr_add_taxonomy_form_fields() {
		$taxonomies = vcwccr_get_taxonomies_for_restrictions();
		foreach ($taxonomies as $taxonomy) {
			add_action("{$taxonomy}_add_form_fields", "vcwccr_add_product_category_restrictions_form_fields", 50);
			add_action("{$taxonomy}_edit_form_fields", "vcwccr_edit_product_category_restrictions_fields", 50);
			add_action("edit_term", 'vcwccr_save_category_restrictions_fields', 10, 3);
			add_action("create_term", 'vcwccr_save_category_restrictions_fields', 10, 3);
		}
	}

	function vcwccr_add_product_category_restrictions_form_fields() {

		$countries = vcwccr_get_countries_with_continents();
		?>
		<hr>
		<h2> <?php _e("Country restrictions", VCWCCR_TEXT_DOMAIN) ?> </h2>
		<div class = "form-field">  
			<label for = "selected-countries"><?php _e("Select countries", VCWCCR_TEXT_DOMAIN); ?></label>
			<?php
			vcwccr_select(array(
				"id" => "product_selected_countries",
				"options" => $countries,
				"multiple" => true
			));
			?>
		</div>
		<div class = "form-field">  
			<label for = "country_availability_operator"><?php _e("Available in selected countries", VCWCCR_TEXT_DOMAIN); ?></label>
			<?php
			vcwccr_select(array(
				"id" => "product_country_availability_operator",
				"options" => vcwccr_get_country_availability_operators()
			));
			?>
		</div>                
		<div class = "form-field">  
			<label for = "apply_this_to"><?php _e("Apply this to", VCWCCR_TEXT_DOMAIN); ?></label>
			<?php
			vcwccr_select(array(
				"id" => "apply_this_to",
				"options" => vcwccr_category_apply_restrictions_operators()
			));
			?>
		</div>
		<hr>
		<?php
	}

}

if (!function_exists("vcwccr_edit_product_category_restrictions_fields")) {


	function vcwccr_edit_product_category_restrictions_fields($term) {

		$term_id = $term->term_id;
		$countries = vcwccr_get_countries_with_continents();
		$apply_operator = get_term_meta($term_id, "vcwccr_apply_this_to", true);

		if ($apply_operator == "products_only") {
			$term_products_only_meta = get_term_meta($term_id, "vcwccr_term_products_only_meta", true);

			$selected_countries = $term_products_only_meta["selected_countries"];
			$availability_operator = $term_products_only_meta["availability_operator"];
			$apply_operator = $term_products_only_meta["apply_this_to"];
		} else {
			$selected_countries = vcwccr_get_selected_countries($term_id, "category");
			$availability_operator = get_term_meta($term_id, "vcwccr_availability_operator", true);
		}
		?> 

		<tr class = "form-field">
			<th colspan="2"><hr>
				<b><?php _e("Country restrictions", VCWCCR_TEXT_DOMAIN) ?> </b>
			</th>
		</tr>  
		<tr class = "form-field"> 
			<th scope = "row">				
				<label><?php _e("Select countries", VCWCCR_TEXT_DOMAIN); ?></label>
			</th>
			<td>
				<?php
				vcwccr_select(array(
					"id" => "product_selected_countries",
					"options" => $countries,
					"multiple" => true,
					"value" => $selected_countries
				));
				?>
			</td>
		</tr>

		<tr class = "form-field"> 
			<th scope = "row">
				<label><?php _e("Available in selected countries", VCWCCR_TEXT_DOMAIN); ?></label>
			</th>
			<td>		
				<?php
				vcwccr_select(array(
					"id" => "product_country_availability_operator",
					"options" => vcwccr_get_country_availability_operators(),
					"value" => $availability_operator
				));
				?>
			</td>
		</tr>

		<tr class = "form-field"> 
			<th scope = "row">
				<label><?php _e("Apply this to", VCWCCR_TEXT_DOMAIN); ?></label>
			</th>
			<td>		
				<?php
				vcwccr_select(array(
					"id" => "apply_this_to",
					"options" => vcwccr_category_apply_restrictions_operators(),
					"value" => $apply_operator
				));
				?>
			</td>
		</tr>     
		<tr class = "form-field">
			<td colspan="2"><hr></td>
		</tr>  
		<?php
	}

}

if (!function_exists("vcwccr_save_category_restrictions_fields")) {


	function vcwccr_save_category_restrictions_fields($term_id, $tt_id, $taxonomy) {

		if (!isset($_POST["product_country_availability_operator"])) {
			return;
		}
		if (!isset($_POST["product_selected_countries"])) {
			$_POST["product_selected_countries"] = array();
		}
		$selected_countries = isset($_POST["product_selected_countries"]) ? array_map("sanitize_text_field", $_POST["product_selected_countries"]) : array();
		$operator = isset($_POST["product_country_availability_operator"]) ? sanitize_text_field($_POST["product_country_availability_operator"]) : '';
		$apply_operator = isset($_POST["apply_this_to"]) ? sanitize_text_field($_POST["apply_this_to"]) : '';

		// Exit if the values were empty and remain empty
		// We will save empty values only when they were not empty previously
		$previous_countries = get_term_meta($term_id, 'vcwccr_selected_countries', true);
		if ($apply_operator !== 'products_only' && empty($selected_countries) && empty($previous_countries)) {
			return;
		}

		$data = array(
			"selected_countries" => $selected_countries,
			"availability_operator" => $operator,
			"apply_this_to" => $apply_operator
		);

		vcwccr_save_category_meta($term_id, $data, $taxonomy);

		$term_children = get_term_children($term_id, $taxonomy);

		if (!empty($term_children) || !is_wp_error($term_children)) {

			foreach ($term_children as $term_child) {

				vcwccr_save_category_meta($term_child, $data, $taxonomy);
			}
		}
	}

}

if (!function_exists('vcwccr_save_term_restrictions')) {

	function vcwccr_save_term_restrictions($term_id, $data, $delete = false) {

		if ($delete) {
			delete_term_meta($term_id, "vcwccr_selected_countries");
			delete_term_meta($term_id, "vcwccr_availability_operator");
			update_term_meta($term_id, "vcwccr_apply_this_to", $data["apply_this_to"]);
			update_term_meta($term_id, "vcwccr_term_products_only_meta", $data);
		} else {
			update_term_meta($term_id, "vcwccr_selected_countries", implode(',', $data["selected_countries"]));
			update_term_meta($term_id, "vcwccr_availability_operator", $data["availability_operator"]);
			update_term_meta($term_id, "vcwccr_apply_this_to", $data["apply_this_to"]);
			delete_term_meta($term_id, "vcwccr_term_products_only_meta");
		}
	}

}

if (!function_exists("vcwccr_save_category_meta")) {

	function vcwccr_save_category_meta($term_id, $data, $taxonomy) {

		$products = vcwccr_get_category_products($term_id, $taxonomy);
		$apply_operator = $data["apply_this_to"];

		if (!empty($apply_operator)) {

			if ($apply_operator == "category") {
				vcwccr_save_term_restrictions($term_id, $data);
				vcwccr_save_category_products($products, $data, true, $term_id);
			}

			if ($apply_operator == "products_only") {
				vcwccr_save_term_restrictions($term_id, $data, true);
				vcwccr_save_category_products($products, $data, false, $term_id);
			}

			if ($apply_operator == "both") {
				vcwccr_save_term_restrictions($term_id, $data);
				vcwccr_save_category_products($products, $data, false, $term_id);
			}
		}
	}

}

if (!function_exists("vcwccr_save_category_products")) {

	function vcwccr_save_category_products($products, $data, $delete = false, $term_id = null) {

		$countries = $data["selected_countries"];
		$operator = $data["availability_operator"];

		if (!empty($products)) {
			foreach ($products as $product) {

				if (!$delete) {
					$countries = ( is_string($countries) ) ? explode(',', $countries) : $countries;
					vcwccr_save_product_custom_fields($product, array(
						'product_country_availability_operator' => $operator,
						'product_selected_countries' => $countries,
					));
					update_post_meta($product, 'vcwccr_inherited_from_term', $term_id);
					wcacr_save_disallowed_countries($product, $countries, $operator);
				} else {
					wcacr_save_disallowed_countries($product, array(), $operator);
					delete_post_meta($product, "vcwccr_selected_countries");
					delete_post_meta($product, "vcwccr_availability_operator");
				}
				if ($delete || empty($countries)) {
					delete_post_meta($product, 'vcwccr_inherited_from_term');
				}
			}
		}
	}

}

if (!function_exists("vcwccr_get_category_products")) {

	function vcwccr_get_category_products($term_id, $taxonomy) {

		$product_query_args = array(
			"fields" => "ids",
			"posts_per_page" => -1,
			"post_status" => 'any',
			"tax_query" => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $term_id,
					'operator' => 'IN'
				)
			)
		);

		$wc_products = new WP_Query($product_query_args);

		$products = $wc_products->posts;

		return $products;
	}

}

if (!function_exists('wcacr_render_category_restricted_notice')) {
	add_action('wcacr_before_product_custom_fields', 'wcacr_render_category_restricted_notice', 10, 2);

	function wcacr_render_category_restricted_notice($selected_countries, $post_id) {
		global $wpdb;
		$inherited_from_taxonomy = (int) get_post_meta($post_id, 'vcwccr_inherited_from_term', true);
		if (!$inherited_from_taxonomy) {
			return;
		}
		$term_taxonomy = $wpdb->get_row("SELECT * FROM $wpdb->term_taxonomy WHERE term_id = " . (int) $inherited_from_taxonomy, ARRAY_A);
		$term = get_term_by('term_id', $inherited_from_taxonomy, $term_taxonomy['taxonomy']);
		?>
		<p><?php printf(__('The restrictions are inherited from the category: <a href="%s" target="_blank">%s</a>'), admin_url('term.php?taxonomy=' . $term->taxonomy . '&tag_ID=' . $term->term_id), $term->name); ?></p>
		<script>
			jQuery(document).ready(function () {
				jQuery('#product_country_availability_operator, .product-selected-countries-field').prop('disabled', true);
			});
		</script>
		<?php
	}

}

if (!function_exists('vcwccr_update_product_restrictions_from_category')) {
	add_action('woocommerce_update_product', 'vcwccr_update_product_restrictions_from_category');

	function vcwccr_update_product_restrictions_from_category($product_id, $categories = null, $delete = false) {
		if (!$categories) {
			$product = wc_get_product($product_id);
			$categories = $product->get_category_ids();
		}

		$inherited_from_category = (int) get_post_meta($product_id, 'vcwccr_inherited_from_term', true);
		$has_category_with_restriction = false;

		foreach ($categories as $category_id) {
			$countries = get_term_meta($category_id, "vcwccr_selected_countries", true);
			$apply_to = get_term_meta($category_id, "vcwccr_apply_this_to", true);
			$availability = get_term_meta($category_id, "vcwccr_availability_operator", true);


			if (!empty($countries) && is_numeric($availability) && in_array($apply_to, array('both', 'products_only'))) {
				vcwccr_save_category_products(array($product_id), array(
					'selected_countries' => $countries,
					'availability_operator' => $availability
						), $delete, $category_id);
				$has_category_with_restriction = true;
			}
		}

		if ($inherited_from_category && !$has_category_with_restriction) {
			delete_post_meta($product_id, 'vcwccr_inherited_from_term');
		}
	}

}

if (!function_exists('vcwccr_remove_term_settings')) {
	add_action('delete_term_relationships', 'vcwccr_remove_term_settings', 10, 3);

	function vcwccr_remove_term_settings($object_id, $tt_ids, $taxonomy) {
		if (!in_array($taxonomy, vcwccr_get_taxonomies_for_restrictions(), true)) {
			return;
		}

		vcwccr_update_product_restrictions_from_category($object_id, $tt_ids, true);
	}

}