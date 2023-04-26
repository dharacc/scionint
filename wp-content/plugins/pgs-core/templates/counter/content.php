<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_counter'] );
extract( $atts );
pgscore_get_shortcode_templates( 'counter/style/' . $counter_style );

