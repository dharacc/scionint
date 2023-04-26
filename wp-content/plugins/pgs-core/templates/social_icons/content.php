<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_social_icons'] );
extract( $atts );

$list_classes   = array();
$list_classes[] = 'pgscore-social-icons';
if ( $style ) {
	$list_classes[] = 'pgssi-style-' . esc_attr( $style );
}
if ( $hover_style ) {
	$list_classes[] = 'pgssi-effect-' . esc_attr( $hover_style );
}
if ( $shape ) {
	$list_classes[] = 'pgssi-shape-' . esc_attr( $shape );
}
if ( $size ) {
	$list_classes[] = 'pgssi-size-' . esc_attr( $size );
}
$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );
?>
<div class="<?php echo esc_attr( $list_classes ); ?>">
	<ul>
		<?php
		foreach ( $list_items_data as $list_item ) {
			$list_item_class = str_replace( 'fab fa-', '', $list_item['profile_name'] );
			?>
			<li class="pgssi-item pgssi-color-<?php echo esc_attr( $list_item_class ); ?>">
				<?php echo wp_kses( '<a ' . $list_item['link'] . '>', pgscore_allowed_html( 'a' ) ); ?>
					<?php echo wp_kses( $list_item['icon'], pgscore_allowed_html( 'i' ) ); ?>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
</div>
