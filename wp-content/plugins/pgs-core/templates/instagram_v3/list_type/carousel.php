<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_instagram_v3'] );
extract( $atts );

$owl_options_args = array(
	'nav'        => ( $carousel_arrow == 'true' ) ? true : false,
	'dots'       => ( $carousel_pagination == 'true' ) ? true : false,
	'loop'       => true,
	'items'      => ( $carousel_items_xl ) ? (int) $carousel_items_xl : 5,
	'smartSpeed' => 1000,
	'responsive' => array(
		1200 => array(
			'items' => ( $carousel_items_xl ) ? (int) $carousel_items_xl : 5,
		),
		992  => array(
			'items' => ( $carousel_items_lg ) ? (int) $carousel_items_lg : 4,
		),
		768  => array(
			'items' => ( $carousel_items_md ) ? (int) $carousel_items_md : 3,
		),
		576  => array(
			'items' => ( $carousel_items_sm ) ? (int) $carousel_items_sm : 2,
		),
		320  => array(
			'items' => 2,
		),
		0    => array(
			'items' => 1,
		),
	),
	'navText'    => array(
		"<i class='fas fa-angle-left fa-2x'></i>",
		"<i class='fas fa-angle-right fa-2x'></i>",
	),
	'margin'     => ( $carousel_gapping ) ? (int) $carousel_gapping : 0,
	'lazyLoad'   => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = json_encode( $owl_options_args );

$meta = false;
if ( $show_likes == 'true' || $show_comments == 'true' ) {
	$meta = true;
}

$insta_items_classes = array(
	'insta_v3_items',
	'insta_v3_style--' . ( $meta ? 'with_meta' : 'without_meta' ),
	'owl-carousel',
	'owl-theme',
	'owl-carousel-options',
);

$insta_items_classes = implode( ' ', array_filter( array_unique( $insta_items_classes ) ) );
?>
<div class="<?php echo esc_attr( $insta_items_classes ); ?>" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $images as $image ) {
		if ( 'small' === $image_size ) {
			$image_url = $image->images->low_resolution->url;
		} elseif ( 'large' === $image_size ) {
			$image_url = $image->images->standard_resolution->url;
		} else {
			$image_url = $image->images->thumbnail->url;
		}
		?>
		<div class="insta_v3_item">
			<a href="<?php echo esc_url( $image->link ); ?>" class="insta_v3_item--link" target="_blank">
				<div class="insta_v3_item--content">
					<?php
					if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
						echo '<img class="insta_v3_item--img img-responsive owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $image_url ) . '"  alt="' . esc_attr( 'Instagram Image', 'pgs-core' ) . '">';
					} else {
						echo '<img class="insta_v3_item--img img-responsive" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( 'Instagram Image', 'pgs-core' ) . '">';
					}
					?>
				</div>
				<?php
				if ( $show_likes == 'true' || $show_comments == 'true' ) {
					?>
					<div class="insta_v3_item--meta">
						<div class="insta_v3_item--meta_items">
							<?php
							if ( $show_likes == 'true' && isset( $image->likes->count ) ) {
								?>
								<div class="insta_v3_item--meta_item insta_v3_item--meta_item_likes">
									<span class="insta_v3_item--meta_item_likes_icon"><i class="fa fa-heart"></i></span>
									<span class="insta_v3_item--meta_item_likes_count"><?php echo esc_attr( $image->likes->count ); ?></span>
								</div>
								<?php
							}
							if ( $show_comments == 'true' && isset( $image->comments->count ) ) {
								?>
								<div class="insta_v3_item--meta_item insta_v3_item--meta_item_comments">
									<span class="insta_v3_item--meta_item_comments_icon"><i class="fa fa-comment"></i></span>
									<span class="insta_v3_item--meta_item_comments_count"><?php echo esc_attr( $image->comments->count ); ?></span>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
			</a>
		</div>
		<?php
	}
	?>
</div>