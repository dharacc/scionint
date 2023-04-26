<?php

// We reuse the functions from the products metabox
add_action('woocommerce_coupon_options_usage_restriction', 'vcwccr_add_product_custom_fields');
add_action('woocommerce_process_shop_coupon_meta', 'vcwccr_save_product_custom_fields', 10, 1);
