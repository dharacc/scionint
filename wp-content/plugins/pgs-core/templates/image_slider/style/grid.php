<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_image_slider'] );
extract( $atts );

$col_xs_perview = ! empty( $grid_elements_sm ) ? $grid_elements_sm : 1;
$col_sm_perview = ! empty( $grid_elements_sm ) ? $grid_elements_sm : 1;
$col_md_perview = ! empty( $grid_elements_md ) ? $grid_elements_md : 2;
$col_lg_perview = ! empty( $grid_elements_lg ) ? $grid_elements_lg : 3;
$col_xl_perview = ! empty( $grid_elements_xl ) ? $grid_elements_xl : 3;

$col_xs = 12 / $col_xs_perview;
$col_sm = 12 / $col_sm_perview;
$col_md = 12 / $col_md_perview;
$col_lg = 12 / $col_lg_perview;
$col_xl = 12 / $col_xl_perview;

$bootstrap_classes    = array();
$bootstrap_classes [] = 'col-xs-' . $col_xs;
$bootstrap_classes [] = 'col-sm-' . $col_sm;
$bootstrap_classes [] = 'col-md-' . $col_md;
$bootstrap_classes [] = 'col-lg-' . $col_lg;
$bootstrap_classes [] = 'col-xl-' . $col_xl;

$bootstrap_classes = implode( ' ', array_filter( array_unique( $bootstrap_classes ) ) );?>

<div class="row">
	<?php
	foreach ( $slides_data as $slide ) {
		?>
		<div class="<?php echo esc_attr( $bootstrap_classes ); ?>">
			<div class="about pro-deta image-grid-<?php esc_attr_e( $style ); ?>">
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
							$custom_link = ( isset( $slide['custom_link'] ) ) ? $slide['custom_link'] : '';
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

					if ( $slide['onclick'] != 'link_no' && $link_stat ) {
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
