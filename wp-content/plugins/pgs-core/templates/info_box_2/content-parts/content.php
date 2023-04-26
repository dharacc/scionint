<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

if ( isset( $info_content ) && ! empty( $info_content ) ) {
	?>
	<div style="color:<?php echo esc_attr( $description_color ); ?>" class="pgscore_info_box_2-content">
		<p><?php echo $info_content; ?></p>
	</div>
	<?php
}
