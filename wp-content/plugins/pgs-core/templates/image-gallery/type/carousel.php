<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_image_gallery'] );
extract( $atts );

$owl_options_args = array(
	'items'              => ( $carousel_elements_xl ) ? (int) $carousel_elements_xl : 3,
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		576  => array(
			'items' => ( $carousel_elements_sm ) ? (int) $carousel_elements_sm : 2,
		),
		768  => array(
			'items' => ( $carousel_elements_md ) ? (int) $carousel_elements_md : 2,
		),
		992  => array(
			'items' => ( $carousel_elements_lg ) ? (int) $carousel_elements_lg : 3,
		),
		1200 => array(
			'items' => ( $carousel_elements_xl ) ? (int) $carousel_elements_xl : 3,
		),
	),
	'margin'             => ( $image_gallery_space ) ? (int) $image_gallery_space : 0,
	'dots'               => false,
	'nav'                => true,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'autoplayTimeout'    => 3100,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => true,
);

$owl_options   = json_encode( $owl_options_args );
$image_gallery = explode( ',', $image_gallery );

?>
<div class="carousel-wrapper ">
	<div class="image_popup-gallery owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $image_gallery as $slides ) {
		$image_full = wp_get_attachment_image_src( $slides, 'full' );
		?>
		<div class="image-gallery_carousel_item">
			<div class="image-gallery-info">
				<div class="image-gallery_item">
					<div class="pgscore_image-gallery_img">
						<?php 
						if ( $image_gallery_style_disable ) {
							?>
							<a href="<?php echo esc_url( $image_full[0] ); ?>" class="pgscore_image-gallery_hover image_popup-img icon-disable">
								<img  src="<?php echo esc_url( $image_full[0] ); ?>">
							</a>
							<?php 
						} else {
							?>
							<img  src="<?php echo esc_url( $image_full[0] ); ?>">
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
</div>
