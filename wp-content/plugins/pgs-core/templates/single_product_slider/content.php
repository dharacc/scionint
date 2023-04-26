<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_single_product_slider'] );
extract( $atts );

$owl_options_args = array(
	'items'              => 1,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayTimeout'    => 3000,
	'autoplayHoverPause' => true,
	'dots'               => false,
	'nav'                => true,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left"></i>',
		'<i class="fas fa-angle-right"></i>',
	),
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		600  => array(
			'items' => 1,
		),
		1000 => array(
			'items' => 1,
		),
	),
);

$owl_options = json_encode( $owl_options_args );

$single_product_carousel_classes = array(
	'single-product-carousel',
	'single-product-carousel-' . $style,
	'woocommerce',
	'feature-5',
);
$single_product_carousel_classes = implode( ' ', array_filter( array_unique( $single_product_carousel_classes ) ) );
?>
<div class="<?php echo esc_attr( $single_product_carousel_classes ); ?>">
	<?php
	if ( ( 'style_1' === $style || 'style_3' === $style ) && ( $custom_title || $custom_content ) ) {
		?>
		<div class="single-product-carousel-top-info top-info">
			<?php
			if ( $custom_title ) {
				?>
				<h3><?php echo esc_html( $custom_title ); ?></h3>
				<?php
			}
			if ( $custom_content ) {
				?>
				<p><?php echo esc_html( $custom_content ); ?></p>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
	<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
		<?php
		while ( $loop->have_posts() ) {
			$loop->the_post();
			?>
			<div class="item">
				<div class="product-img product">
					<div class="product-inner">
						<div class="product-thumbnail">
							<div class="product-thumbnail-inner">
								<?php woocommerce_template_loop_product_thumbnail(); ?>
							</div><!-- .product-thumbnail-inner -->
						</div><!-- .product-thumbnail -->
					</div><!-- .product-thumbnail-inner -->
					<div class="product-info">
						<div class="star-rating-wrapper">
							<?php woocommerce_template_loop_rating(); ?>
						</div><!-- .star-rating-wrapper -->
						<h3 class="product-name">
							<?php woocommerce_template_loop_product_link_open(); ?>
								<?php echo esc_html( get_the_title() ); ?>
							<?php woocommerce_template_loop_product_link_close(); ?>
						</h3><!-- .product-name-->
						<?php woocommerce_template_loop_price(); ?>
						<?php
						if ( $post->post_excerpt ) {
							$product_excerpt = $post->post_excerpt;
							$product_excerpt = pgscore_shorten_string( $product_excerpt, 115, true, true );
							if ( ! empty( $product_excerpt ) ) {
								?>
								<div class="woocommerce-product-details__short-description">
									<p><?php echo esc_html( $product_excerpt ); ?></p>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
		?>
	</div>
</div>
