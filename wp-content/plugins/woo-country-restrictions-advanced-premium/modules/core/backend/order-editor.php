<?php

if (!function_exists('wcacr_order_editor_js')) {
	add_action('admin_footer', 'wcacr_order_editor_js');

	function wcacr_order_editor_js() {
		global $post;
		if (!is_object($post) || $post->post_type !== 'shop_order') {
			return;
		}
		?>
		<script>
			(function ($) {
				$(document).ajaxSend(function (event, jqxhr, settings) {
					if (settings.url &&
							-1 < settings.url.indexOf('admin-ajax.php') &&
							!(settings.url.indexOf('wcacr-apply-restrictions') > 0)
							) {
						if (settings.url.indexOf('?') > 0) {
							settings.url += '&';
						} else {
							settings.url += '?';
						}

						settings.url += 'wcacr-apply-restrictions=' + jQuery('#_billing_country').val();

					}
				});
			})(jQuery);
		</script>
		<?php

	}

}