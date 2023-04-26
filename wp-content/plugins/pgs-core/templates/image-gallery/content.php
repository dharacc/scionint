<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_image_gallery'] );
extract( $atts );

$image_gallery_classes[] = 'pgscore_image-gallery_wrapper';
$image_gallery_style     = ( ! empty( $image_gallery_style ) ) ? $image_gallery_style : 'style-1';

if ( ! $image_gallery_style_disable ) {
	$image_gallery_classes[] = 'pgscore_image-gallery_' . $image_gallery_style;
}

if ( 'isotope' === $image_gallery_type ) {
	$image_gallery_classes[] = 'isotope-wrapper';
}

if ( ! empty( $image_gallery_column ) && 'carousel' !== $image_gallery_type ) {
	$image_gallery_classes[] = 'column-' . $image_gallery_column;
}

if ( ! empty( $image_gallery_space ) ) {
	$image_gallery_classes[] = 'image-gallery-space-' . $image_gallery_space;
} else {
	$image_gallery_classes[] = 'image-gallery-space-0';
}
$image_gallery_classes = implode( ' ', array_filter( array_unique( $image_gallery_classes ) ) );

?>
<div class="<?php echo esc_attr( $image_gallery_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'image-gallery/type/' . $image_gallery_type ); ?>
</div>







