<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $product;
extract( $pgscore_shortcodes['pgscore_product_deals'] );
extract( $atts );

$intro_content_status = true;
$intro_status         = true;

if ( ! $intro_title && ! $intro_description ) {
	$intro_content_status = false;
}

if ( $enable_intro_content != 'true' || ! $intro_content_status ) {
	$intro_status = false;
}

$control_index_class = "product-deals-control-{$index}";

$deals_classes = array(
	'product-deals-wrapper',
	'woocommerce',
	"product-deals-style-{$style}",
);
$deals_classes = implode( ' ', array_filter( array_unique( $deals_classes ) ) );

$link_attr = false;

// Link Attributes
$additional_url_vars = array(
	'style' => "color:{$intro_link_color};",
);
if ( $enable_intro_link == 'true' ) {
	$link_attr = pgscore_vc_link_attr( $intro_link, '', $additional_url_vars );
}
?>
<div class="<?php echo esc_attr( $deals_classes ); ?>" data-intro="<?php echo esc_attr( $intro_status ? 'yes' : 'no' ); ?>">
	<div class="product-deals-inner">
		<div class="row">
			<?php
			if ( $enable_intro_content == 'true' && $intro_content_status ) {
				if ( 'right' === $intro_position ) {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1';
				} else {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9';
				}

				$deals_classes = array(
					'product-deals-content-wrapper',
					'product-deals-content-bg_style-' . $intro_bg_type,
				);

				$deals_content_style = array();
				if ( 'image' === $intro_bg_type && $intro_bg_image ) {
					$intro_bg_image                          = wp_get_attachment_image_src( $intro_bg_image, 'full' );
					$deals_content_style['background-image'] = "background-image:url({$intro_bg_image[0]});";

					if ( $intro_bg_image_background_position ) {
						$deals_content_style['background-position'] = "background-position:{$intro_bg_image_background_position};";
					}
					if ( $intro_bg_image_background_repeat ) {
						$deals_content_style['background-repeat'] = "background-repeat:{$intro_bg_image_background_repeat};";
					}
					if ( $intro_bg_image_background_size ) {
						$deals_content_style['background-size'] = "background-size:{$intro_bg_image_background_size};";
					}
				} elseif ( 'color' === $intro_bg_type && $intro_bg_color ) {
					$deals_content_style['background-color'] = "background-color:{$intro_bg_color};";
				}
				$deals_content_style = implode( ' ', array_filter( array_unique( $deals_content_style ) ) );

				$deals_classes = implode( ' ', array_filter( array_unique( $deals_classes ) ) );
				?>
				<div class="<?php echo esc_attr( $intro_column_classes ); ?>">
					<div class="<?php echo esc_attr( $deals_classes ); ?>" style="<?php echo esc_attr( $deals_content_style ); ?>">
						<?php
						if ( 'image' === $intro_bg_type && $intro_bg_image ) {
							$deals_content_overlay_style                     = array();
							$deals_content_overlay_style['background-color'] = "background-color:{$intro_bg_image_ol_color};";
							$deals_content_overlay_style                     = implode( ' ', array_filter( array_unique( $deals_content_overlay_style ) ) );
							?>
							<div class="product-deals-content-wrapper-overlay" style="<?php echo esc_attr( $deals_content_overlay_style ); ?>"></div>
							<?php
						}
						if ( $intro_title ) {
							$intro_title_css = "color:{$intro_title_color}";
							?>
							<div class="product-deals-title"><h2 style="<?php echo esc_attr( $intro_title_css ); ?>"><?php echo esc_html( $intro_title ); ?></h2></div>
							<?php
						}
						if ( $intro_description ) {
							$intro_description_css = "color:{$intro_description_color}";
							?>
							<div class="product-deals-description" style="<?php echo esc_attr( $intro_description_css ); ?>"><?php echo esc_html( $intro_description ); ?></div>
							<?php
						}
						if ( $enable_intro_link == 'true' && 'with_controls' !== $intro_link_position && ! empty( $link_title ) && ! empty( $link_attr ) ) {
							?>
							<div class="product-deals-link">
								<?php
								if ( ! empty( $link_title ) && ! empty( $link_attr ) ) {
									echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', pgscore_allowed_html( 'a' ) );
								}
								?>
							</div>
							<?php
						}
						$controls_classes = array(
							'product-deals-control',
							$control_index_class,
						);
						if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position ) {
							$controls_classes[] = "intro-link-alignment-{$intro_link_alignment}";
						}
						$controls_classes = implode( ' ', array_filter( array_unique( $controls_classes ) ) );
						?>
						<div class="<?php echo esc_attr( $controls_classes ); ?>">
							<?php
							if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position && ! empty( $link_title ) && ! empty( $link_attr ) ) {
								?>
								<div class="product-deals-link">
									<?php
									if ( ! empty( $link_title ) && ! empty( $link_attr ) ) {
										echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $link_title ) . '</a>', pgscore_allowed_html( 'a' ) );
									}
									?>
								</div>
								<?php
							}
							?>
							<div class="product-deals-nav"></div>
						</div>
					</div>
				</div>
				<?php
			} else {
				$item_column_classes = 'col-xs-12 col-sm-12 col-md-12';
			}
			?>
			<div class="<?php echo esc_attr( $item_column_classes ); ?>">
				<div class="product-deals-items-wrapper">
					<?php
					$owl_options_args = array(
						'items'              => 3,
						'responsive'         => array(
							0    => array(
								'items' => 1,
							),
							480  => array(
								'items' => 1,
							),
							768  => array(
								'items' => 1,
							),
							980  => array(
								'items' => 2,
							),
							1600 => array(
								'items' => 2,
							),
						),
						'margin'             => 20,
						'dots'               => false,
						'nav'                => true,
						'loop'               => false,
						'autoplay'           => false,
						'autoplayHoverPause' => true,
						'autoplayTimeout'    => 3100,
						'smartSpeed'         => 1000,
						'navText'            => array(
							'<i class="fas fa-angle-left fa-2x"></i>',
							'<i class="fas fa-angle-right fa-2x"></i>',
						),
					);
					if ( $intro_status ) {
						$owl_options_args['navContainer'] = ".product-deals-control.{$control_index_class} .product-deals-nav";
					}

					$owl_options = json_encode( $owl_options_args );
					?>
					<div class="product-deals-items owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
						<?php
						$items_in_column = 2;
						$sale_ids_chunks = array_chunk( $sale_ids, $items_in_column );

						foreach ( $sale_ids_chunks as $sale_ids_chunk ) {
							?>
							<div class="product-deals-items-column">
								<?php
								foreach ( $sale_ids_chunk as $sale_id ) {

									global $product;

									$product = wc_get_product( (int) $sale_id );
									if ( is_object( $product ) ) {
										$product_deals_item_classes = array( 'product-deals-item' );

										if ( ! $product->get_date_on_sale_to() ) {
											$product_deals_item_classes[] = 'product-deals-item-withou-counter';
										}

										if ( has_post_thumbnail( $product->get_id() ) ) {
											$product_deals_item_classes[] = 'product-deals-item-with-image';
										} else {
											$product_deals_item_classes[] = 'product-deals-item-without-image';
										}

										$product_deals_item_classes[] = 'clearfix';
										$product_deals_item_classes[] = 'match-height';

										$product_deals_item_classes = implode( ' ', array_filter( array_unique( $product_deals_item_classes ) ) );
										?>
										<div class="<?php echo esc_attr( $product_deals_item_classes ); ?>">
											<?php pgscore_get_shortcode_templates( 'product_deals/product/content' ); ?>
										</div>
										<?php
									}
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
