<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_opening_hours'] );
extract( $atts );

?>
<h4 class="pgs-opening-hours-title"><?php echo esc_html( $title ); ?></h4>
<div class="pgs-opening-hours">
	<?php
	$ciyashop_opening_hours = ciyashop_opening_hours();
	if ( ! empty( $ciyashop_opening_hours ) ) {
		?>
		<ul>
			<?php
			foreach ( $ciyashop_opening_hours as $ciyashop_opening_hour => $ciyashop_opening_hour_val ) {
				if ( ! empty( $ciyashop_opening_hour_val ) ) {
					?>
					<li>
						<i class="fa fa-clock-o"></i><span><?php echo esc_html( $ciyashop_opening_hour ); ?></span>
						<label><?php echo wp_kses( $ciyashop_opening_hour_val, pgscore_allowed_html( array( 'a' ) ) ); ?></label>
					</li>
					<?php
				}
			}
			?>
		</ul>
		<?php
	}
	?>
</div>
