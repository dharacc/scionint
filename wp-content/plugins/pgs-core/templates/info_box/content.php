<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

$infobox_classes = array();

$infobox_classes[] = 'pgscore_info_box';
$infobox_classes[] = 'pgscore_info_box-layout-' . $layout;
if ( in_array( $layout, array( 'style_4', 'style_5' ) ) ) {
	$infobox_classes[] = 'pgscore_info_box-content_alignment-left';
} else {
	$infobox_classes[] = 'pgscore_info_box-content_alignment-' . $content_alignment;
}

if ( in_array( $layout, array( 'style_1', 'style_2', 'style_3' ) ) ) {
	if ( $icon_html ) {
		$infobox_classes[] = 'pgscore_info_box-with-icon';

		$infobox_classes[] = 'pgscore_info_box-icon-source-' . $icon_source;

		$infobox_classes[] = 'pgscore_info_box-icon-style-' . $icon_style;
		$infobox_classes[] = 'pgscore_info_box-icon-size-' . $icon_size;
		if ( $icon_style != 'default' ) {
			$infobox_classes[] = 'pgscore_info_box-icon-shape-' . $icon_shape;

			if ( isset( $icon_enable_outer_border ) && $icon_enable_outer_border == 'true' ) {
				$infobox_classes[] = 'pgscore_info_box-outer-border';
			}
		}
	} else {
		$infobox_classes[] = 'pgscore_info_box-without-icon';
	}
}

if ( 'style_2' === $layout ) {
	if ( isset( $icon_position ) ) {
		$infobox_classes[] = 'pgscore_info_box-icon_position-' . $icon_position;
	}
	if ( isset( $style_2_step_position ) ) {
		$infobox_classes[] = 'info_box-step_position-' . $style_2_step_position;
	}
}

if ( isset( $icon_source ) && 'link' === $icon_source ) {
	$infobox_classes[] = 'pgscore_info_box-icon-source-image';
}

$infobox_classes = implode( ' ', array_filter( array_unique( $infobox_classes ) ) );
?>
<div class="<?php echo esc_attr( $infobox_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'info_box/layout/' . $layout ); ?>
</div>
