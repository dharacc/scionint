<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_banner'] );
extract( $atts );

$badge_classes = array();
$badge_styles  = array();

/**********************************************
 * Classes
 **********************************************/
$badge_classes[] = 'pgscore_banner-badge';
$badge_classes[] = 'pgscore_banner-badge_style-' . $badge_style;
$badge_classes[] = 'pgscore_banner-badge_type-' . $badge_type;
$badge_classes[] = 'pgscore_banner-badge_align-' . $badge_vertical_align;
$badge_classes[] = 'pgscore_banner-badge_align-' . $badge_horizontal_align;

$badge_classes = implode( ' ', array_filter( array_unique( $badge_classes ) ) );

/**********************************************
 * Styles
 **********************************************/
$badge_styles['color']  = "color:{$badge_text_color};";
$badge_styles['width']  = "width:{$badge_width}px;";
$badge_styles['height'] = "height:{$badge_height}px;";

if ( isset( $badge_font_size ) && ! empty( $badge_font_size ) ) {
	$badge_styles['font-size'] = "font-size:{$badge_font_size}px;";
}
if ( isset( $badge_font_weight ) && ! empty( $badge_font_weight ) ) {
	$badge_styles['font-weight'] = "font-weight:{$badge_font_weight};";
}

if ( isset( $badge_line_height ) && ! empty( $badge_line_height ) ) {
	$badge_styles['line-height'] = "line-height:{$badge_line_height}px;";
}

if ( isset( $badge_text_transform ) && ! empty( $badge_text_transform ) ) {
	$badge_styles['text-transform'] = "text-transform:{$badge_text_transform};";
}

if ( 'flat' == $badge_type ) {
	$badge_styles['background-color'] = "background-color:{$badge_background_color};";
}
if ( 'border' == $badge_type ) {
	$badge_styles['border-color'] = "border-color:{$badge_border_color};";

	if ( isset( $badge_border_width ) && ! empty( $badge_border_width ) ) {
		$badge_styles['border-width'] = "border-width:{$badge_border_width}px;";
	}
}


$badge_styles = implode( ' ', array_filter( array_unique( $badge_styles ) ) );
?>
<div class="pgscore_banner-badge-wrap">
	<div class="pgscore_banner-badge-inner-wrap">
		<div class="<?php echo esc_attr( $badge_classes ); ?>" style="<?php echo esc_attr( $badge_styles ); ?>">
			<div class="pgscore_banner-badge-inner">
				<span class="pgscore_banner-badge-text"><?php echo esc_html( $badge_title ); ?></span>  
			</div>
		</div>
	</div>
</div>
