<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_info_box_2'] );
extract( $atts );

$icon_inner_styles = array();

if ( 'style_5' !== $layout ) {
	if ( $icon_style == 'border' && isset( $icon_border_color ) && ! empty( $icon_border_color ) ) {
		$icon_inner_styles[] = 'border-color:' . $icon_border_color . ';';
	} elseif ( 'flat' === $icon_style && isset( $icon_background_color ) && ! empty( $icon_background_color ) ) {
		$icon_inner_styles[] = 'background-color:' . $icon_background_color . ';';
	}
}

$icon_inner_styles               = implode( ' ', array_filter( array_unique( $icon_inner_styles ) ) );
$allowed_html                    = pgscore_allowed_html( array( 'i', 'img', 'span' ) );
$allowed_html['img']['data-src'] = true;
?>
<div class="pgscore_info_box_2-icon-outer">
	<div class="pgscore_info_box_2-icon-inner" style="<?php echo esc_attr( $icon_inner_styles ); ?>">
		<?php echo wp_kses( $icon_html, $allowed_html ); ?>
	</div>
</div>
