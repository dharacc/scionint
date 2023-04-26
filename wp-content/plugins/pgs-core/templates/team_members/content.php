<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_team_members'] );
extract( $atts );
pgscore_get_shortcode_templates( 'team_members/list_style/carousel' );
