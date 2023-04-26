<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box'] );
extract( $atts );

$icon_outer_styles = $icon_inner_styles  = array();

if ( 'style_5' !== $layout ) {
	if ( 'border' === $icon_style ) {
		if ( isset( $icon_border_color ) && ! empty( $icon_border_color ) ) {
			$icon_inner_styles[] = 'border-color:' . $icon_border_color . ';';
		}
		if ( isset( $icon_border_width ) && ! empty( $icon_border_width ) ) {
			$icon_inner_styles[] = 'border-width:' . $icon_border_width . 'px;';
		}
		if ( isset( $icon_border_style ) && ! empty( $icon_border_style ) ) {
			$icon_inner_styles[] = 'border-style:' . $icon_border_style . ';';
		}
	} elseif ( 'flat' === $icon_style ) {
		if ( isset( $icon_background_color ) && ! empty( $icon_background_color ) ) {
			$icon_inner_styles[] = 'background-color:' . $icon_background_color . ';';
		}
	}

	if ( 'default' !== $icon_style && isset( $icon_enable_outer_border ) && $icon_enable_outer_border == 'true' ) {
		if ( isset( $icon_outer_border_color ) && ! empty( $icon_outer_border_color ) ) {
			$icon_outer_styles[] = 'border-color:' . $icon_outer_border_color . ';';
		}
		if ( isset( $icon_outer_border_width ) && ! empty( $icon_outer_border_width ) ) {
			$icon_outer_styles[] = 'border-width:' . $icon_outer_border_width . 'px;';
		}
		if ( isset( $icon_outer_border_style ) && ! empty( $icon_outer_border_style ) ) {
			$icon_outer_styles[] = 'border-style:' . $icon_outer_border_style . ';';
		}
	}
}

$icon_outer_styles               = implode( ' ', array_filter( array_unique( $icon_outer_styles ) ) );
$icon_inner_styles               = implode( ' ', array_filter( array_unique( $icon_inner_styles ) ) );
$allowed_html                    = pgscore_allowed_html( array( 'i', 'img', 'span' ) );
$allowed_html['img']['data-src'] = true;

?>
<div class="pgscore_info_box-icon-outer" style="<?php echo esc_attr( $icon_outer_styles ); ?>">
	<div class="pgscore_info_box-icon-inner" style="<?php echo esc_attr( $icon_inner_styles ); ?>">
		<?php echo wp_kses( $icon_html, $allowed_html ); ?>
	</div>
</div>
