<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_image_gallery'] );
extract( $atts );

$image_gallery = explode( ',', $image_gallery );
?>

<div class="isotope image_popup-gallery">
<?php
foreach ( $image_gallery as $slides ) {
	$image      = wp_get_attachment_image_src( $slides, 'full' );
	$image_full = wp_get_attachment_image_src( $slides, 'full' );
	?>
	<div class="image-gallery_isotope_item grid-item">
		<div class="image-gallery-info">
			<div class="image-gallery_item">
				<div class="pgscore_image-gallery_img">
					<?php
					if ( $image_gallery_style_disable ) {
						?>
						<a href="<?php echo esc_url( $image_full[0] ); ?>" class="image_popup-img pgscore_image-gallery_hover icon-disable">
							<img  src="<?php echo esc_url( $image[0] ); ?>">
						</a>
						<?php
					} else {
						?>
						<img src="<?php echo esc_url( $image[0] ); ?>">
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
