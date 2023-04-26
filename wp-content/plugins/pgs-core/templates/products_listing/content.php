<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );

$control_index_class = "products-listing-control-{$index}";

$products_listing_classes = array(
	'products-listing-wrapper',
	'products-listing-type-' . $listing_type,
	'products-listing-' . ( $enable_intro == 'true' ? 'with-intro' : 'without-intro' ),
);
$products_listing_classes = implode( ' ', array_filter( array_unique( $products_listing_classes ) ) );

$link_attr = false;

// Link Attributes
if ( $enable_intro_link == 'true' ) {
	$link_attr = pgscore_vc_link_attr(
		$intro_link,
		'',
		array(
			'style' => "color:{$intro_link_color};",
		)
	);
}

// Re-assin link attribute
$pgscore_shortcodes['pgscore_products_listing']['atts']['link_attr'] = $link_attr;
?> 
<div class="<?php echo esc_attr( $products_listing_classes ); ?>" data-intro="<?php echo esc_attr( $enable_intro == 'true' ? 'yes' : 'no' ); ?>">
	<div class="products-listing-inner">
		<div class="row">
			<?php
			if ( $enable_intro == 'true' ) {

				// Check intro position
				if ( 'right' === $intro_position ) {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1';
				} else {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9';
				}

				$products_listing_classes = array(
					'products-listing-intro-wrapper',
					'products-listing-intro-content-alignment-' . $intro_content_alignment,
					'products-listing-intro-bg_type-' . $intro_bg_type,
				);

				// Intro Style
				$intro_style = array();
				if ( 'image' === $intro_bg_type && $intro_bg_image ) {
					$intro_bg_image                  = wp_get_attachment_image_src( $intro_bg_image, 'full' );
					$intro_style['background-image'] = "background-image:url({$intro_bg_image[0]});";

					if ( $intro_bg_image_background_position ) {
						$intro_style['background-position'] = "background-position:{$intro_bg_image_background_position};";
					}
					if ( $intro_bg_image_background_repeat ) {
						$intro_style['background-repeat'] = "background-repeat:{$intro_bg_image_background_repeat};";
					}
					if ( $intro_bg_image_background_size ) {
						$intro_style['background-size'] = "background-size:{$intro_bg_image_background_size};";
					}
				} elseif ( 'color' === $intro_bg_type && $intro_bg_color ) {
					$intro_style['background-color'] = "background-color:{$intro_bg_color};";
				}
				$intro_style = implode( ' ', array_filter( array_unique( $intro_style ) ) );

				$products_listing_classes = implode( ' ', array_filter( array_unique( $products_listing_classes ) ) );
				?>
				<div class="<?php echo esc_attr( $intro_column_classes ); ?>">
					<div class="<?php echo esc_attr( $products_listing_classes ); ?>" style="<?php echo esc_attr( $intro_style ); ?>">
						<?php
						pgscore_get_shortcode_templates( 'products_listing/content-parts/overlay' );
						pgscore_get_shortcode_templates( 'products_listing/content-parts/title' );
						pgscore_get_shortcode_templates( 'products_listing/content-parts/description' );
						if ( $enable_intro_link == 'true' && ( 'grid' === $listing_type || ( 'carousel' === $listing_type && 'with_controls' !== $intro_link_position ) ) && ( ! empty( $link_title ) && ! empty( $link_attr ) ) ) {
							pgscore_get_shortcode_templates( 'products_listing/content-parts/link' );
						}

						if ( $listing_type == 'carousel' ) {
							// Classes
							$controls_classes = array(
								'products-listing-control',
								"products-listing-control-{$index}",
							);
							if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position ) {
								$controls_classes[] = "products-listing-control-link-alignment-{$intro_link_alignment}";
							}
							$controls_classes = implode( ' ', array_filter( array_unique( $controls_classes ) ) );
							?>
							<div class="<?php echo esc_attr( $controls_classes ); ?>">
								<?php
								if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position && ( ! empty( $link_title ) && ! empty( $link_attr ) ) ) {
									pgscore_get_shortcode_templates( 'products_listing/content-parts/link' );
								}
								?>
								<div class="products-listing-nav"></div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			} else {
				$item_column_classes = 'col-xs-12 col-sm-12 col-md-12';
			}
			?>
			<div class="<?php echo esc_attr( $item_column_classes ); ?>">
				<div class="products-listing-main">
					<div class="products-listing-main-inner">
						<?php
						if ( $enable_intro != 'true' ) {
							pgscore_get_shortcode_templates( 'products_listing/content-parts/header' );
						}
						?>
						<div class="products-listing-content">
							<div class="products-listing-content-inner">
								<?php pgscore_get_shortcode_templates( 'products_listing/content-parts/products' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
