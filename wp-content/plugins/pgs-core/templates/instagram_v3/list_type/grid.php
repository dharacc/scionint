<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_instagram_v3'] );
extract( $atts );

$meta = false;
if ( $show_likes == 'true' || $show_comments == 'true' ) {
	$meta = true;
}

$insta_items_classes = array(
	'insta_v3_items',
	'insta_v3_style--' . ( $meta ? 'with_meta' : 'without_meta' ),
);

$insta_items_classes = implode( ' ', array_filter( array_unique( $insta_items_classes ) ) );
?>
<div class="<?php echo esc_attr( $insta_items_classes ); ?>">
	<div class="row">
		<?php
		$grid_classes = array(
			'col-xl-' . 12 / $grid_col_xl,
			'col-lg-' . 12 / $grid_col_lg,
			'col-md-' . 12 / $grid_col_md,
			'col-sm-' . 12 / $grid_col_sm,
			'col-' . 12 / $grid_col_xs,
		);
		$grid_classes = implode( ' ', array_filter( array_unique( $grid_classes ) ) );

		foreach ( $images as $image ) {
			if ( 'small' === $image_size ) {
				$image_url = $image->images->low_resolution->url;
			} elseif ( 'large' === $image_size ) {
				$image_url = $image->images->standard_resolution->url;
			} else {
				$image_url = $image->images->thumbnail->url;
			}
			?>
			<div class="<?php echo esc_attr( $grid_classes ); ?>">
				<div class="insta_v3_item">
					<a href="<?php echo esc_url( $image->link ); ?>" class="insta_v3_item--link" target="_blank">
						<div class="insta_v3_item--content">
							<?php
							if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
								echo '<img class="insta_v3_item--img img-responsive ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $image_url ) . '" alt="' . esc_attr( 'Instagram Image', 'pgs-core' ) . '">';
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
			</div>
			<?php
		}
		?>
	</div>
</div>
