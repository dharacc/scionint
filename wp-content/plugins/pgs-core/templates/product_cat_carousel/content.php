<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_product_cat_carousel'] );
extract( $atts );
$carousel_classes = array();

// Shortcode Custom Classes
$carousel_classes[] = 'product-category-items';
$carousel_classes[] = 'product-category-' . $style;
$carousel_classes[] = 'product-category-' . $list_style;

$carousel_classes[] = 'product-category-' . $horizontal_align;
if ( 'style-1' === $style || 'style-3' === $style ) {
	$carousel_classes[] = 'product-category-' . $vertical_align;
}

// background overlay settings
if ( isset( $background_overlay ) && 'custom' !== $background_overlay ) {
	$carousel_classes[] = 'category-style-' . $background_overlay;
}

// category title hover setting
if ( isset( $hover_effect ) ) {
	$carousel_classes[] = 'category-hover-' . $hover_effect;
}

// Style 2 options
if ( isset( $cat_img_style ) ) {
	$carousel_classes[] = 'category-img-' . $cat_img_style;
}

$carousel_classes[] = $title_counter_display;
$carousel_classes   = implode( ' ', array_filter( array_unique( $carousel_classes ) ) );
?>
<div class="<?php echo esc_attr( $carousel_classes ); ?>">
	<?php pgscore_get_shortcode_templates( 'product_cat_carousel/style/' . $list_style ); ?>
</div>
