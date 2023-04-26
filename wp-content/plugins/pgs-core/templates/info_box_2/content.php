<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

$infobox_classes           = array();
$infobox_classes[]         = 'pgscore_info_box_2';
$infobox_classes[]         = 'pgscore_info_box_2-layout-' . $layout;
$element_content_alignment = ( 'style_2' !== $layout ) ? '' : '-left';
if ( 'style_2' !== $layout && isset( $content_alignment ) && ! empty( $content_alignment ) ) {
	$element_content_alignment = '-' . $content_alignment;
}

$infobox_classes[] = 'pgscore_info_box_2-content_alignment' . $element_content_alignment;
if ( isset( $disable_animation ) && $disable_animation == false ) {
	$infobox_classes[] = 'animated';
}

if ( in_array( $layout, array( 'style_1', 'style_2', 'style_3' ) ) ) {
	if ( $icon_html ) {
		$infobox_classes[] = 'pgscore_info_box_2-with-icon';
		$infobox_classes[] = 'pgscore_info_box_2-icon-source-' . $icon_source;
		$infobox_classes[] = 'pgscore_info_box_2-icon-style-' . $icon_style;
		$infobox_classes[] = 'pgscore_info_box_2-icon-size-' . $icon_size;
		if ( 'default' !== $icon_style ) {
			$infobox_classes[] = 'pgscore_info_box_2-icon-shape-' . $icon_shape;
		}
	} else {
		$infobox_classes[] = 'pgscore_info_box_2-without-icon';
	}
}

if ( $layout == 'style_2' && isset( $icon_position ) && $icon_position ) {
	$infobox_classes[] = 'pgscore_info_box_2-icon_position-' . $icon_position;
}

if ( isset( $icon_source ) && 'link' === $icon_source ) {
	$infobox_classes[] = 'pgscore_info_box_2-icon-source-image';
}

$infobox_classes = implode( ' ', array_filter( array_unique( $infobox_classes ) ) );

?>
<div class="<?php echo esc_attr( $infobox_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'info_box_2/layout/' . $layout ); ?>
</div>
