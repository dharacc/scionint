<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_hotspot'] );
extract( $atts );

$pointer_class = 'hotspot-dot dot-' . $pointer_style;
$hotspot_image;
if ( 'link' === $image_source ) {
	if ( ! empty( $hotspot_box_img_link ) ) {
		$hotspot_image = array( $hotspot_box_img_link );
	}
} else {
	if ( ! empty( $hotspot_box_img ) ) {
		$hotspot_image = wp_get_attachment_image_src( $hotspot_box_img, 'full' );
	}
}
if ( isset( $hotspot_box_img ) && ! empty( $hotspot_image ) ) { ?>
<div class="pgscore-image-hotspot-wrapper">
	<div class="pgscore-image-hotspot">
		<img src="<?php echo esc_url( $hotspot_image[0]); ?>"/>

			<?php
			if ( ! empty( $list_items_raw ) ) {
				?>
				<div class="pgscore-hotspot-contents-wrapper">
				
					<?php
					foreach ( $list_items_raw as $list_item ) {

						$list_classes   = array();
						$list_classes[] = 'image-hotspot';
						$list_classes[] = 'pgscore-hotspot-' . $hotspot_color_scheme;
						if ( isset( $list_item['hotspot_desktop'] ) && $list_item['hotspot_desktop'] ) {
							$list_classes[] = 'hide-desktop';
						}
						if ( isset( $list_item['hotspot_mobile'] ) && $list_item['hotspot_mobile'] ) {
							$list_classes[] = 'hide-mobile';
						}
						if ( 'click' === $hotspot_trigger ) {
							$list_classes[] = 'trigger-click';
						} else {
							$list_classes[] = 'trigger-hover';
						}
						$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );

						if ( array_key_exists( 'hotspot_list_image', $list_item ) || array_key_exists( 'hotspot_list_title', $list_item ) || array_key_exists( 'hotspot_list_content', $list_item ) ) {
							$position = explode( '||', $list_item['position'] );
							?>
							<div style="top:calc(<?php echo esc_attr( $position[1] ); ?>% - 28px); left:calc(<?php echo esc_attr( $position[0] ); ?>% - 28px);" class="<?php echo esc_attr( $list_classes ); ?>">
								<div  class="<?php echo esc_attr( $pointer_class ); ?>">
									<span></span>
								</div>
								<div class="hotspot-content hotspot-dropdown-<?php echo esc_attr( $list_item['hotspot_list_direction'] ); ?>">
									<?php
									if ( array_key_exists( 'hotspot_list_image', $list_item ) ) {
										$list_img = wp_get_attachment_image_src( $list_item['hotspot_list_image'], 'medium' );
										?>
										<div class="hotspot-content-image">
											<img src="<?php echo esc_attr( $list_img[0] ); ?>"/>
										</div>
										<?php
									}

									if ( array_key_exists( 'hotspot_list_title', $list_item ) ) {
										?>
										<h6 class="hotspot-title"><?php echo esc_html( $list_item['hotspot_list_title'] ); ?></h6> 
										<?php
									}

									if ( array_key_exists( 'hotspot_list_content', $list_item ) ) {
										?>
										<div class="hotspot-content-text">
										<p><?php echo esc_html( $list_item['hotspot_list_content'] ); ?></p>
										</div>
										<?php
									}

									if ( isset( $list_item['hotspot_list_link'] ) ) {
										$link_attr     = vc_build_link( $list_item['hotspot_list_link'] );
										$button_target = 0;
										if ( ! empty( $link_attr['target'] ) ) {
											$button_target = 1;
										}
										if ( $link_attr && ! empty( $link_attr['title'] ) ) {
											?>
											<div class="hotspot-btn">
												<a <?php echo ( $button_target ) ? 'target=_blank' : ''; ?> href="<?php echo esc_url( $link_attr['url'] ); ?>">
													<?php echo esc_html( $link_attr['title'] ); ?>
												</a>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
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
<?php } ?>
