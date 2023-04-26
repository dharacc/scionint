<?php
add_action( 'init', 'pgscore_metabox_fields_loader_new' );
function pgscore_metabox_fields_loader_new() {
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/testimonials-settings.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/page-sidebar.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/page-settings.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/post-format-audio.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/post-format-video.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/post-format-quote.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/post-format-gallery.php' );
	include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/team-details.php' );

	if ( class_exists( 'WooCommerce' ) ) {
		include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/product-category-settings.php' );
		include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/product-tag-banner.php' );
		include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/wc-custom-tab.php' );
		include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/wc-product-video.php' );
		include_once( trailingslashit( PGSCORE_PATH ).'includes/meta-boxes/meta-fields/wc-size-guide-image.php' );

	}
}
?>
