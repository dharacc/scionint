<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );
?>
<div class="products-listing-header">
	<div class="products-listing-inner">
		<?php
		if ( $intro_title ) {
			?>
			<div class="row">
				<div class="col-8"><?php pgscore_get_shortcode_templates( 'products_listing/content-parts/title' ); ?></div>
				<div class="col-4">
					<?php
					// Classes
					$header_controls_classes = array(
						'products-listing-header-control',
						"products-listing-header-control-{$index}",
					);
					$header_controls_classes = implode( ' ', array_filter( array_unique( $header_controls_classes ) ) );
					?>
					<div class="<?php echo esc_attr( $header_controls_classes ); ?>"><div class="products-listing-nav"></div></div>
				</div>
			</div>
			<?php
		}
		if ( $intro_description ) {
			?>
			<div class="row">
				<div class="col">
					<?php pgscore_get_shortcode_templates( 'products_listing/content-parts/description' ); ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
