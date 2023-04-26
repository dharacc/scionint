<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_recent_posts'] );
extract( $atts );

if ( 'image' === $intro_bg_type && $intro_bg_image ) {
	$deals_content_overlay_style                     = array();
	$deals_content_overlay_style['background-color'] = "background-color:{$intro_bg_image_ol_color};";
	$deals_content_overlay_style                     = implode( ' ', array_filter( array_unique( $deals_content_overlay_style ) ) );
	?>
	<div class="latest-post-intro-wrapper-overlay" style="<?php echo esc_attr( $deals_content_overlay_style ); ?>"></div>
	<?php
}
