<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_globals;
extract( $pgscore_shortcodes['pgscore_section_title'] );
extract( $atts );
pgscore_get_shortcode_templates( 'section_title/style/' . $section_title_style );

