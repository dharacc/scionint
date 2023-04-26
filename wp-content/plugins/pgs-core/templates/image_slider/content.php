<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_image_slider'] );
extract( $atts );

$image_slider_class = array();

// Shortcode Custom Classes
$image_slider_class[] = 'image-slider-items';
$image_slider_class[] = 'image-slider-' . $style;
$image_slider_class[] = 'image-slider-' . $list_style;
$image_slider_class   = implode( ' ', array_filter( array_unique( $image_slider_class ) ) );
?>
<div class="<?php echo esc_attr( $image_slider_class ); ?>">
	<?php pgscore_get_shortcode_templates( 'image_slider/style/' . $list_style ); ?>
</div>
