<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_recent_posts'] );
extract( $atts );

if ( $intro_description ) {
	$intro_description_css = '';
	if ( $enable_intro == 'true' ) {
		$intro_description_css = "color:{$intro_description_color}";
	}
	?>
	<div class="latest-post-description" style="<?php echo esc_attr( $intro_description_css ); ?>"><?php echo esc_html( $intro_description ); ?></div>
	<?php
}
