<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_testimonials'] );
extract( $atts );
if ( empty( $enable_infinity_loop ) ) {
	$enable_infinity_loop = false;
}
$arrow_id = 'testimonials-arrow-' . $index;

$owl_options_args = array(
	'items'              => (int) $slides_per_view,
	'loop'               => $enable_infinity_loop,
	'margin'             => (int) $slide_margin,
	'autoplay'           => true,
	'autoplayTimeout'    => (int) $carousel_speed,
	'autoplayHoverPause' => true,
	'dots'               => false,
	'nav'                => true,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'responsive'         => array(
		0    => array(
			'items' => (int) $slides_per_view_xx,
		),
		480  => array(
			'items' => (int) $slides_per_view_xs,
		),
		768  => array(
			'items' => (int) $slides_per_view_sm,
		),
		992  => array(
			'items' => (int) $slides_per_view_md,
		),
		1200 => array(
			'items' => (int) $slides_per_view,
		),
	),
	'navContainer'       => "#{$arrow_id}",
	'lazyLoad'           => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = json_encode( $owl_options_args );
?>
<div class="testimonial testimonial-style-5 owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		$testimonials_img_src = '';

		$author      = '';
		$content     = '';
		$designation = '';

		$author      = get_post_meta( get_the_ID(), 'author', true );
		$content     = get_post_meta( get_the_ID(), 'content', true );
		$designation = get_post_meta( get_the_ID(), 'designation', true );

		$testimonials_img_alt = ( $author ) ? $author : esc_html__( 'Author', 'pgs-core' );

		if ( has_post_thumbnail() ) {
			$testimonials_thumbnail_id = get_post_thumbnail_id();
			$testimonials_img_data     = wp_get_attachment_image_src( $testimonials_thumbnail_id, 'thumbnail' );

			if ( isset( $testimonials_img_data[0] ) ) {
				$testimonials_img_src = $testimonials_img_data[0];
			}
		}
		if ( ! empty( $content ) ) {
			?>
			<div class="testimonial-information">
				<div class="client-image">
					<?php
					if ( empty( $testimonials_img_src ) ) {
						$testimonials_img_src = get_parent_theme_file_uri( '/images/placeholder/testimonials/150x150.png' );
					}
					?>
					<div class="author-photo">
						<?php
						if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && defined( 'LOADER_IMAGE' ) && ! vc_is_inline() ) {
							echo '<img class="img-responsive rounded-circle owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $testimonials_img_src ) . '" alt="' . esc_attr( $testimonials_img_alt ) . '" />';
						} else {
							echo '<img class="img-responsive rounded-circle" src="' . esc_url( $testimonials_img_src ) . '" alt="' . esc_attr( $testimonials_img_alt ) . '" />';
						}
						?>
					</div>

				</div>
				<div class="testimonial-content">
					<p><?php echo wp_kses( $content, array( 'p' => true ) ); ?></p>
					<div class="client-info">
						<?php
						if ( $author ) {
							?>
							<h5 class="author-name">- <?php echo esc_html( $author ); ?></h5>
							<?php
						}
						if ( $designation ) {
							?>
							<span><?php echo esc_html( $designation ); ?></span>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
<?php
if ( true == $show_prev_next_buttons ) {
	?>
	<div id="<?php echo esc_attr( $arrow_id ); ?>" class="testimonials-carousel-nav"></div>
	<?php 
}
?>

