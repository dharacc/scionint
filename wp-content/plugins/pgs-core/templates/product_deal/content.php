<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $product;
extract( $pgscore_shortcodes['pgscore_product_deal'] );
extract( $atts );

if ( ! is_object( $product ) ) {
	return;
}

$deal_classes = array(
	'product-deal-wrapper',
	'woocommerce',
	"product-deal-style-{$style}",
);
$deal_classes = implode( ' ', array_filter( array_unique( $deal_classes ) ) );
?>
<div class="<?php echo esc_attr( $deal_classes ); ?>">
	<div class="product-deal-inner">
		<?php pgscore_get_shortcode_templates( 'product_deal/product/content' ); ?>
	</div>
</div>
