<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_clients'] );
extract( $atts );

$owl_options_args = array(
	'items'              => 5,
	'loop'               => true,
	'dots'               => $slider_elements != 'none' && ( $slider_elements == 'both' || $slider_elements == 'pagination' ),
	'nav'                => $slider_elements != 'none' && ( $slider_elements == 'both' || $slider_elements == 'prevnext' ),
	'margin'             => 30,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'smartSpeed'         => 1000,
	'responsive'         => array(
		'0'    => array(
			'items' => 1,
		),
		'480'  => array(
			'items' => 2,
		),
		'768'  => array(
			'items' => 3,
		),
		'980'  => array(
			'items' => 4,
		),
		'1200' => array(
			'items' => 5,
		),
	),
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
);

$owl_options = json_encode( $owl_options_args );
?>
<div class="our-clients owl-carousel owl-theme owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
	<?php
	foreach ( $slides_data as $slide ) {
		$link_attr = '';
		$img_src   = '';
		if ( ! empty( $slide['image_link'] ) ) {
			$link_attr = pgscore_vc_link_attr( $slide['image_link'] );
		}
		$image_source = isset( $slide['image_source'] ) ? $slide['image_source'] : 'image';
		if ( $image_source == 'image' ) {
			$img_src = ( ! empty( $slide['slide_image'] ) ) ? wp_get_attachment_image_src( $slide['slide_image'], $thumb_size ) : apply_filters(
				'default_brand_logo',
				array(
					get_template_directory_uri() . '/images/brand-logo.png',
					112,
					65,
					'',
				)
			);
		} elseif ( $image_source == 'link' ) {
			$img_src = ( ! empty( $slide['slide_img_link'] ) ) ? array( esc_url( $slide['slide_img_link'] ), 112, 65 ) : apply_filters(
				'default_brand_logo',
				array(
					get_template_directory_uri() . '/images/brand-logo.png',
					112,
					65,
					'',
				)
			);

		}

		if ( $img_src && isset( $img_src[0] ) ) {
			?>
			<div class="item">
				<?php
				if ( $link_attr ) {
					echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( 'a' ) );
				}

				if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
					echo '<img class="img-fluid center-block owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( isset( $slide['title'] ) ? $slide['title'] : '' ) . '">';
				} else {
					echo '<img class="img-fluid center-block" src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( isset( $slide['title'] ) ? $slide['title'] : '' ) . '">';
				}

				if ( $link_attr ) {
					?>
					</a>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
	?>
</div>
