<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

if ( isset( $description ) && ! empty( $description ) ) {
	?>
	<div class="pgscore_info_box-description">
		<p><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}
