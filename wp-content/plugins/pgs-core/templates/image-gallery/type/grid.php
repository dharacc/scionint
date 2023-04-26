<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_image_gallery'] );
extract( $atts );

$grid_classes[] = 'image-gallery_grid_item';

if ( ! empty( $image_gallery_column ) && $image_gallery_column == '2' ) {
	$grid_classes[] = 'col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6';
} elseif ( ! empty( $image_gallery_column ) && $image_gallery_column == '3' ) {
	$grid_classes[] = 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4';
} elseif ( ! empty( $image_gallery_column ) && $image_gallery_column == '4' ) {
	$grid_classes[] = 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3';
} elseif ( ! empty( $image_gallery_column ) && $image_gallery_column == '6' ) {
	$grid_classes[] = 'col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-2';
}
$grid_classes = implode( ' ', array_filter( array_unique( $grid_classes ) ) );

$image_gallery = explode( ',', $image_gallery );
?>
<div class="row image_popup-gallery">
	<?php
	foreach ( $image_gallery as $slides ) {
		$image      = wp_get_attachment_image_src( $slides, 'ciyashop-latest-post-thumbnail' );
		$image_full = wp_get_attachment_image_src( $slides, 'full' );
		?>
		<div class="<?php echo esc_attr( $grid_classes ); ?>">
			<div class="image-gallery-info">
				<div class="image-gallery_item">
					<div class="pgscore_image-gallery_img">
						<?php
						if ( $image_gallery_style_disable ) {
							?>
							<a href="<?php echo esc_url( $image_full[0] ); ?>" class="pgscore_image-gallery_hover image_popup-img icon-disable">
								<img  src="<?php echo esc_url( $image[0] ); ?>">
							</a>
							<?php
						} else {
							?>
							<img  src="<?php echo esc_url( $image[0] ); ?>">
							<?php 
						}
						?>
					</div>
					<?php
					if ( ! $image_gallery_style_disable ) {
						?>
						<a style="background:<?php echo esc_attr( $image_overlay_color ); ?>" href="<?php echo esc_url( $image_full[0] ); ?>" class="pgscore_image-gallery_hover image_popup-img">
							<span class="gallery-icon"><i class="icon"></i></span>
						</a>
						<?php 
					}
					?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>
