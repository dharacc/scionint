<?php

if (!function_exists('wcacr_link_global_settings_on_product')) {
	add_action('wcacr_after_product_custom_fields', 'wcacr_link_global_settings_on_product');
	add_action('wcacr_after_variation_custom_fields', 'wcacr_link_global_settings_on_product');

	function wcacr_link_global_settings_on_product() {
?>
		<?php printf(__('<p><a href="%s" target="_blank" class="wcacr-go-premium-link">Open global settings</a> - <a href="%s" target="_blank" class="wcacr-go-premium-link">Edit country restrictions by category</a></p>', WCACR_TEXTDOMAIN), esc_url(admin_url('admin.php?page=wc-settings&tab=variations_per_country_tab')), esc_url(admin_url('edit-tags.php?taxonomy=product_cat&post_type=product'))); ?>
		<?php

	}
}