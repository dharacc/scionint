<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}

global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );
?>
<div class="pgscore_info_box_2-inner clearfix">
	<?php
	if ( 'font' === $icon_source ) {
		if ( $icon_html ) {
			?>
			<div class="pgscore_info_box_2-icon">
				<div class="pgscore_info_box_2-icon-wrap">
					<?php pgscore_get_shortcode_templates( 'info_box_2/content-parts/icon' ); ?>
				</div>
			</div>
			<?php
		}
	} else {
		?>
		<div class="pgscore_info_box_2-icon">
			<div class="pgscore_info_box_2-icon-wrap">
				<?php pgscore_get_shortcode_templates( 'info_box_2/content-parts/image' ); ?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="pgscore_info_box_2-content">
		<div class="pgscore_info_box_2-content-wrap">
			<div class="pgscore_info_box_2-content-inner">
				<?php
				pgscore_get_shortcode_templates( 'info_box_2/content-parts/title' );
				pgscore_get_shortcode_templates( 'info_box_2/content-parts/content' );
				?>
			</div>
		</div>
	</div>
</div>
