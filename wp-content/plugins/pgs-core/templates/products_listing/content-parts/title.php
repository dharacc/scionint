<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );

if ( $intro_title ) {
	$intro_title_css = '';
	if ( $enable_intro == 'true' ) {
		$intro_title_css = "color:{$intro_title_color}";
	}
	?>
	<div class="products-listing-title"><h2 style="<?php echo esc_attr( $intro_title_css ); ?>"><?php echo esc_html( $intro_title ); ?></h2></div>
	<?php
}
