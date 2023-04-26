<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );
?>
<div class="pgscore_info_box-inner clearfix">
	<div class="pgscore_info_box-icon">
		<div class="pgscore_info_box-icon-wrap">
			<?php
			if ( $icon_html ) {
				pgscore_get_shortcode_templates( 'info_box/content-parts/icon' );
			}
			pgscore_get_shortcode_templates( 'info_box/content-parts/title' );
			if ( $icon_html ) {
				pgscore_get_shortcode_templates( 'info_box/content-parts/step' );
			}
			?>
		</div>
	</div>
	
	<div class="pgscore_info_box-content">
		<div class="pgscore_info_box-content-wrap">
			<div class="pgscore_info_box-content-inner">
				<?php
				pgscore_get_shortcode_templates( 'info_box/content-parts/description' );
				?>
			</div>
		</div>
	</div>
</div>
