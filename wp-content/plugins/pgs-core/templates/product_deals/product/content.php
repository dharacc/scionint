<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $product, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_product_deals'] );
extract( $atts );

$product_image     = false;
$product_id        = $product->get_id();
$product_title     = get_the_title( $product_id );
$product_image_id  = $product->get_image_id();
$product_image_ids = array();

if ( $product_image_id ) {
	$product_image_ids[] = $product_image_id;
}

$gallery_image_ids = $product->get_gallery_image_ids();
if ( $gallery_image_ids ) {
	$product_image_ids = array_merge( $product_image_ids, $gallery_image_ids );
}

if ( ! empty( $product_image_ids ) && $product_image_ids[0] != '' ) {
	$product_image = true;
} else {
	$product_image[] = wc_placeholder_img_src();
	$product_image[] = 510;
	$product_image[] = 650;
}

if ( $product_image ) {
	?>
	<div class="product-deals-item-left">
		<div class="product-deal-image">
			<?php
			if ( true === $product_image ) {
				echo wp_get_attachment_image(
					$product_image_ids[0],
					'ciyashop-product-180x230',
					array(
						'class' => 'product_img',
					)
				);
			} else {
				if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && defined( 'LOADER_IMAGE' ) && ! vc_is_inline() ) {
					echo '<img class="product_img ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $product_image[0] ) . '" width="' . esc_attr( $product_image[1] ) . '" height="' . esc_attr( $product_image[2] ) . '" alt="' . esc_attr( $product_title ) . '">';
				} else {
					echo '<img class="product_img" src="' . esc_url( $product_image[0] ) . '" width="' . esc_attr( $product_image[1] ) . '" height="' . esc_attr( $product_image[2] ) . '" alt="' . esc_attr( $product_title ) . '">';
				}
			}
			?>
		</div>
	</div>
	<?php
}
?>
<div class="product-deals-item-right">
	<div class="product-deal-content">
		<div class="product-deal-content-title">
			<h2 class="product-deal-title">
				<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"><?php echo esc_html( $product_title ); ?></a>
			</h2>
		</div>
		<div class="product-deal-content-rating">
			<?php
			$rating_count = $product->get_rating_count();
			if ( $rating_count > 0 ) {
				wc_get_template( 'loop/rating.php' );
			} else {
				?>
				<div class="star-rating"><span class="star-rating-inner"><?php esc_html_e( 'Rated 0 out of 5', 'pgs-core' ); ?></span></div>
				<?php
			}
			?>
		</div>
		<div class="product-deal-content-price">
			<?php wc_get_template( 'loop/price.php' ); ?>
		</div>
		<?php
		if ( $product->get_date_on_sale_to() ) {
			$sale_to_datex    = $product->get_date_on_sale_to()->getTimestamp();
			$sale_to_datetime = strtotime( $sale_to_datex );
			$sale_to_ymd      = date( 'Y-m-d', $sale_to_datex );

			$counter_data = array(
				'expiremsg'     => $expire_message,
				'weeks'         => esc_html__( 'Week', 'pgs-core' ),
				'days'          => esc_html__( 'Day', 'pgs-core' ),
				'hours'         => esc_html__( 'Hrs', 'pgs-core' ),
				'minutes'       => esc_html__( 'Min', 'pgs-core' ),
				'seconds'       => esc_html__( 'Sec', 'pgs-core' ),
				'on_expire_btn' => 'disable',
			);
			$counter_data = json_encode( $counter_data );
			?>
			<div class="product-deal-counter">
				<div class="deal-counter-wrapper <?php echo esc_attr( "counter-size-{$counter_size}" ); ?>">
					<div class="deal-counter" data-countdown-date="<?php echo esc_attr( $sale_to_ymd ); ?>" data-counter_data="<?php echo esc_attr( $counter_data ); ?>"></div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
