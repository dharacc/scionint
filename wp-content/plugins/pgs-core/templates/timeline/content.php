<?php
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_timeline'] );

extract( $atts );
$list_items = vc_param_group_parse_atts( $list );

if ( ! is_array( $list_items ) || empty( $list_items ) || empty( $list_items[0] ) ) {
	return null;
}

$reference_array = array();
foreach ( $list_items as $key => $row ) {
	if ( isset( $row['timeline_date'] ) ) {
		$reference_array[ $key ] = $row['timeline_date'];
	}
}
if ( sizeof( $reference_array ) == sizeof( $list_items ) ) {
	array_multisort( $reference_array, $list_items, $direction );
}
$timeline_classes   = array();
$timeline_classes[] = 'pgscore-timeline';
$timeline_classes[] = 'pgscore-timeline-' . $style;
$timeline_classes   = implode( ' ', array_filter( array_unique( $timeline_classes ) ) );

?>
<ul class="timeline list-style-none <?php echo esc_attr( $timeline_classes ); ?>">
	<?php
	$timeline_sr = 1;
	foreach ( $list_items as $list_item ) {
		$item_classes   = array();
		$item_classes[] = 'timeline-item';
		$item_classes[] = $timeline_sr % 2 ? 'timeline-item-odd' : 'timeline-item-even timeline-inverted';
		$item_classes   = implode( ' ', array_filter( array_unique( $item_classes ) ) );
		$list_bg_color  = ( $list_bg_color ) ? $list_bg_color : 'transparent';
		$css_style      = array();
		if ( 'style-3' === $style ) {
			if ( ! empty( $list_bg_color ) ) {
				$css_style[] = "color:{$list_bg_color}";
				$css_style[] = "background:{$list_bg_color}";
			}
		}
		$css_style = implode( ';', array_filter( array_unique( $css_style ) ) );

		if ( ( isset( $list_item['timeline_title'] ) && ! empty( $list_item['timeline_title'] ) ) || isset( $list_item['timeline_description'] ) && ! empty( $list_item['timeline_description'] ) ) {
			?>
			<li class="<?php echo esc_attr( $item_classes ); ?>">
				<div class="timeline-badge"><h4><?php echo esc_html( $timeline_sr ); ?></h4></div>
				<div class="timeline-panel timeline-<?php echo esc_attr( $box_shape ); ?>" style="<?php echo esc_attr( $css_style ); ?>">
					<div class="timeline-heading">
						<?php
						if ( isset( $list_item['timeline_title'] ) && ! empty( $list_item['timeline_title'] ) ) {
							?>
							<h5 style="color:<?php echo esc_attr( $list_title_color ); ?>"><?php echo esc_html( $list_item['timeline_title'] ); ?></h5>
							<?php
						}
						?>
					</div>
					<?php
					if ( isset( $list_item['timeline_description'] ) && ! empty( $list_item['timeline_description'] ) ) {
						?>
						<div class="timeline-body" style="color:<?php echo esc_attr( $list_description_color ); ?>;">
							<p><?php echo esc_html( $list_item['timeline_description'] ); ?></p>
						</div>
						<?php
					}
					?>
				</div>
			</li>
			<?php
			$timeline_sr++;
		}
	}
	?>
</ul>
