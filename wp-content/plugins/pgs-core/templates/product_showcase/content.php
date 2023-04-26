<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_product_showcase'] );
extract( $atts );

$allowed_tags = wp_kses_allowed_html( 'post' );

$owl_options_args = array(
	'items'      => 1,
	'loop'       => true,
	'autoplay'   => false,
	'dots'       => false,
	'nav'        => true,
	'smartSpeed' => 1000,
	'navText'    => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'responsive' => array(
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
?>
<div class="pgscore_product_showcase_inner">
	<?php if ( isset( $title ) && ! empty( $title ) ) { ?>
		<<?php echo esc_html( $title_el ); ?> class="pgscore_product_showcase-title">
			<?php echo esc_html( $title ); ?>
		</<?php echo esc_html( $title_el ); ?>>
	<?php } ?>
	<div class="pgscore_product_showcase-carousel owl-carousel owl-theme owl-carousel-options feature-6" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
		<div class="item">
			<?php
			$product_sr = 1;
			while ( $loop->have_posts() ) {
				$loop->the_post();
				global $product;
				?>
				<div class="content-row product-sr-<?php echo esc_attr( $product_sr ); ?>">
					<div class="left-image">
						<?php echo wp_kses( $product->get_image( 'shop_thumbnail', array( 'class' => 'img-fluid' ) ), array( 'img' => $allowed_tags['img'] ) ); ?>
					</div>
					<div class="right-info">
						<span class="product_type-title">
							<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"><?php echo esc_html( $product->get_title() ); ?></a>
						</span>
						<span class="price">
							<?php
							echo wp_kses(
								$product->get_price_html(),
								array(
									'span' => array_merge( $allowed_tags['span'], array( 'data-product-id' => true ) ),
									'del'  => $allowed_tags['del'],
									'ins'  => $allowed_tags['ins'],
								)
							);
							?>
						</span>
					</div>
				</div>
				<?php
				if ( ( $product_sr % 4 ) == 0 && $product_sr != $loop->post_count ) {
					?>
					</div><div class="item">
					<?php
				}
				$product_sr++;
			}
			?>
		</div>
	</div>
</div>
