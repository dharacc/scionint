<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes, $product, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_product_deal'] );
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

if ( ! empty( $product_image_ids ) && '' != $product_image_ids[0] ) {
	$product_image = wp_get_attachment_image_src( $product_image_ids[0], 'shop_catalog' );
} else {
	$product_image[] = wc_placeholder_img_src();
	$product_image[] = 510;
	$product_image[] = 650;
}

$sale_from_date = false;
$sale_to_date   = false;

$sale_from_date_timestamp = '';
$sale_from_date_str       = '';
$sale_to_date_timestamp   = '';
$sale_to_date_str         = '';

if ( $product->get_date_on_sale_from() ) {
	$sale_from_date           = $product->get_date_on_sale_from();
	$sale_from_date_timestamp = $sale_from_date->getTimestamp();
	$sale_from_date_str       = $sale_from_date->date( 'Y-m-d' );
}

if ( $product->get_date_on_sale_to() ) {
	$sale_to_date           = $product->get_date_on_sale_to();
	$sale_to_date_timestamp = $sale_to_date->getTimestamp();
	$sale_to_date_str       = $sale_to_date->date( 'Y-m-d' );
}

if ( ! $sale_to_date ) {
	$sale_to_date = new DateTime();
	$sale_to_date->setTime( 24, 00 );
	$sale_to_date_timestamp = $sale_to_date->getTimestamp();
	$sale_to_date_str       = $sale_to_date->format( 'Y-m-d' );
}
?>
<div class="product-deal-counter">
	<?php
	$counter_data = array(
		'expiremsg'     => $expire_message,
		'weeks'         => esc_html__( 'Week', 'pgs-core' ),
		'days'          => esc_html__( 'Day', 'pgs-core' ),
		'hours'         => esc_html__( 'Hrs', 'pgs-core' ),
		'minutes'       => esc_html__( 'Min', 'pgs-core' ),
		'seconds'       => esc_html__( 'Sec', 'pgs-core' ),
	);
	$counter_data = json_encode( $counter_data );
	if ( isset( $sale_to_date_str ) && ! empty( $sale_to_date_str ) ) {
		?>
		<div class="deal-counter-wrapper <?php echo esc_attr( "counter-size-{$counter_size}" ); ?>">
			<div class="deal-counter" data-countdown-date="<?php echo esc_attr( $sale_to_date_str ); ?>" data-counter_data="<?php echo esc_attr( $counter_data ); ?>"></div>
		</div>
		<?php
	}
	?>
</div>
<?php
if ( $product_image ) {
	?>
	<div class="product-deal-image">
		<?php
		if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && defined( 'LOADER_IMAGE' ) && ! vc_is_inline() ) {
			echo '<img class="product_img ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $product_image[0] ) . '" width="' . esc_attr( $product_image[1] ) . '" height="' . esc_attr( $product_image[2] ) . '" alt="' . esc_attr( $product_title ) . '">';
		} else {
			echo '<img class="product_img" src="' . esc_url( $product_image[0] ) . '" width="' . esc_attr( $product_image[1] ) . '" height="' . esc_attr( $product_image[2] ) . '" alt="' . esc_attr( $product_title ) . '">';
		}
		?>

	</div>
	<?php
}
?>
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
</div>
