<?php
/**
 * The Custom template
 *
 * This template can be overridden by copying it to yourtheme/woo-product-slider/templates/custom/custom.php
 *
 * @package    woo-product-slider
 * @subpackage woo-product-slider/Frontend
 */

?>
<div class="wpsf-product  swiper-slide">
	<div class="sp-wps-product-image-area">
		<?php
			require self::wps_locate_template( 'loop/thumbnail.php' );
		?>
	</div> <!-- sp-wps-product-image-area.  -->
<?php if ( $product_name || $product_price || $product_rating || $add_to_cart_button ) : ?>
	<div class="sp-wps-product-details">
		<div class="sp-wps-product-details-inner">
			<?php
			require self::wps_locate_template( 'loop/title.php' );
			require self::wps_locate_template( 'loop/price.php' );
			require self::wps_locate_template( 'loop/rating.php' );
			require self::wps_locate_template( 'loop/add_to_cart.php' );
			?>
		</div> <!-- sp-wps-product-details-inner. -->
	</div> <!--  sp-wps-product-details. -->
	<?php endif; ?>
</div> <!-- wpsf-product. -->
