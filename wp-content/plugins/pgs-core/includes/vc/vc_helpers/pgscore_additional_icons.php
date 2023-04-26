<?php
function pgscore_vc_iconpicker_type_fontawesome_social_icons( $icons ) {
	$fa_social_icons = vc_iconpicker_type_fontawesome( array() );
	$fa_social_icons = $fa_social_icons['Brands'];

	// Return icons
	return array_merge( $icons, $fa_social_icons );
}
add_filter( 'vc_iconpicker-type-fontawesome-social-icons', 'pgscore_vc_iconpicker_type_fontawesome_social_icons' );
