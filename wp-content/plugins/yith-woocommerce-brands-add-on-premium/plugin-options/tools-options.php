<?php
/**
 * General settings page
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

return apply_filters(
	'yith_wcbr_tools_settings',
	array(
		'tools' => array(
			'tools_panel' => array(
				'type' => 'custom_tab',
				'action' => 'yith_wcbr_tools_panel'
			)
		)
	)
);