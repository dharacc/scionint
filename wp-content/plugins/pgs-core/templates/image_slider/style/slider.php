<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_image_slider'] );
extract( $atts );
if ( $slide_margin >= 50 ) {
	$slide_margin = 50;
} elseif ( $slide_margin <= 0 ) {
	$slide_margin = 0;
}
$owl_options_args = array(
	'nav'        => ( ! empty( $show_prev_next_buttons ) && $show_prev_next_buttons == 'yes' ) ? true : false, // Arrow
	'dots'       => ( ! empty( $show_pagination_control ) && $show_pagination_control == 'yes' ) ? true : false, // Pagination
	'loop'       => ( ! empty( $enable_infinity_loop ) && $enable_infinity_loop == 'yes' ) ? true : false, // Loop
	'items'      => ( ! empty( $slides_per_view ) ) ? $slides_per_view : 3, // Data Items
	'smartSpeed' => 1000,
	'responsive' => array(
		1200 => array(
			'items' => ( ! empty( $slides_per_view ) ) ? $slides_per_view : 3,
		),
		992  => array(
			'items' => ( ! empty( $slides_per_view_md ) ) ? $slides_per_view_md : 3,
		),
		768  => array(
			'items' => ( ! empty( $slides_per_view_sm ) ) ? $slides_per_view_sm : 2,
		),
		480  => array(
			'items' => ( ! empty( $slides_per_view_xs ) ) ? $slides_per_view_xs : 1,
		),
		0    => array(
			'items' => ( ! empty( $slides_per_view_xx ) ) ? $slides_per_view_xx : 1,
		),
	),
	'navText'    => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'margin'     => ( ! empty( $slide_margin ) ) ? (int) $slide_margin : 0,
	'lazyLoad'   => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = '';
if ( is_array( $owl_options_args ) && ! empty( $owl_options_args ) ) {
	$owl_options = json_encode( $owl_options_args );
}
?>
<div class="owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $slides_data as $slide ) {
		?>
		<div class="item">
			<div class="about pro-deta image-slider-<?php esc_attr_e( $style ); ?>">
				<div class="about-image clearfix">
					<?php
					$link_stat = false;
					if ( $slide['onclick'] != 'link_no' ) {
						$link = '';
						if ( $slide['onclick'] == 'link_image' ) {
							$link      = $slide['image_url'];
							$link_stat = true;
							?>
							<a href="<?php echo esc_url( $link ); ?>" class="slider-popup">
							<?php
						} elseif ( $slide['onclick'] == 'custom_link' ) {
							$custom_link = $slide['custom_link'];
							$link_class  = array();
							$link_attr   = '';
							if ( ! empty( $custom_link ) ) {
								$link_attr = pgscore_vc_link_attr( $custom_link, $link_class );
							}
							if ( ! empty( $link_attr ) ) {
								$link_stat = true;
								echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
							}
						}
					}

					$alt_attr = ( isset( $slide['title'] ) && ! empty( $slide['title'] ) ) ? esc_attr( $slide['title'] ) : '';
					if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
						echo '<img class="img-fluid owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $slide['image_thumbnail'] ) . '" width="' . esc_attr( $slide['image_thumbnail_width'] ) . '" height="' . esc_attr( $slide['image_thumbnail_height'] ) . '" alt="' . esc_attr( $alt_attr ) . '">';
					} else {
						echo '<img class="img-fluid" src="' . esc_url( $slide['image_thumbnail'] ) . '" width="' . esc_attr( $slide['image_thumbnail_width'] ) . '" height="' . esc_attr( $slide['image_thumbnail_height'] ) . '" alt="' . esc_attr( $alt_attr ) . '">';
					}

					if ( 'link_no' !== $slide['onclick'] && $link_stat ) {
						?>
						</a>
						<?php
					}
					?>
				</div>
				<?php
				if ( $enable_caption ) {
					?>
					<div class="about-details">
						<?php
						if ( ! empty( $slide['subtitle'] ) ) {
							?>
							<div class="about-des"><?php echo esc_html( $slide['subtitle'] ); ?></div>
							<?php
						}
						if ( ! empty( $slide['title'] ) ) {

							$title_link_enable = isset( $slide['title_link_enable'] ) ? $slide['title_link_enable'] : '';
							$title_link_url    = '';

							if ( $title_link_enable == true && ! empty( $slide['title_link_url'] ) ) {
								$title_link_url = $slide['title_link_url'];
								if ( ! empty( $title_link_url ) ) {
									$title_link_attr = pgscore_vc_link_attr( $title_link_url );
								}

								if ( ! empty( $title_link_attr ) ) {
									echo wp_kses( '<a ' . $title_link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
								}
							}
							?>
							<h5 class="title"><?php echo esc_html( $slide['title'] ); ?></h5>
							<?php
							if ( $title_link_enable == true && ! empty( $slide['title_link_url'] ) ) {
								?>
								</a>
								<?php
							}
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
</div>
