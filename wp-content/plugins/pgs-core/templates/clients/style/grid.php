<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_clients'] );
extract( $atts );
?>
<div class="our-clients boxed-list box-<?php echo esc_attr( $grid_elements ); ?>">
	<ul class="list-inline clearfix">
		<?php
		foreach ( $slides_data as $slide ) {
			$link_attr = '';
			if ( ! empty( $slide['image_link'] ) ) {
				$link_attr = pgscore_vc_link_attr( $slide['image_link'] );
			}

			$image_source = isset( $slide['image_source'] ) ? $slide['image_source'] : 'image';
			
			if ( 'image' === $image_source ) {
				$img_src = ( ! empty( $slide['slide_image'] ) ) ? wp_get_attachment_image_src( $slide['slide_image'], $thumb_size ) : apply_filters(
					'default_brand_logo',
					array(
						get_template_directory_uri() . '/images/brand-logo.png',
						112,
						65,
						'',
					)
				);
			} elseif ( 'link' === $image_source ) {
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
				<li>
					<?php
					if ( ! empty( $link_attr ) ) {
						echo wp_kses( '<a ' . $link_attr . '>', pgscore_allowed_html( array( 'a' ) ) );
					}

					$slide_title = ( ! empty( $slide['title'] ) ) ? esc_attr( $slide['title'] ) : '';

					if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
						echo '<img class="img-fluid center-block ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( $slide_title ) . '">';
					} else {
						echo '<img class="img-fluid center-block" src="' . esc_url( $img_src[0] ) . '" width="' . esc_attr( $img_src[1] ) . '" height="' . esc_attr( $img_src[2] ) . '" alt="' . esc_attr( $slide_title ) . '">';
					}

					if ( ! empty( $link_attr ) ) {
						?>
						</a>
						<?php
					}
					?>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
