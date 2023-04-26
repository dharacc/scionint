<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_multi_tab_products_listing'] );
extract( $atts );

$mtpl_wrapper_classes = array(
	'pgs-mtpl-wrapper',
	'pgs-mtpl-' . ( ( $enable_intro == 'true' ) ? 'with-intro' : 'without-intro' ),
	( ( 'carousel' === $listing_type ) ? 'multi_tab-products-listing-type-carousel' : '' ),
);

$mtpl_wrapper_classes = implode( ' ', array_filter( array_unique( $mtpl_wrapper_classes ) ) );
?>
<div class="<?php echo esc_attr( $mtpl_wrapper_classes ); ?>">
	<div class="pgs-mtpl-inner">
		<div class="row">
			<?php
			if ( $enable_intro == 'true' ) {
				$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3';
				$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9';

				$mtpl_intro_classes = array(
					'pgs-mtpl-intro-wrapper',
					'pgs-mtpl-intro-content-alignment-' . $intro_content_alignment,
					'pgs-mtpl-intro-bg_type-' . $intro_bg_type,
				);

				$mtpl_intro_style = array();
				if ( 'image' === $intro_bg_type && $intro_bg_image ) {
					$intro_bg_image                       = wp_get_attachment_image_src( $intro_bg_image, 'full' );
					$mtpl_intro_style['background-image'] = "background-image:url({$intro_bg_image[0]});";

					if ( $intro_bg_image_background_position ) {
						$mtpl_intro_style['background-position'] = "background-position:{$intro_bg_image_background_position};";
					}
					if ( $intro_bg_image_background_repeat ) {
						$mtpl_intro_style['background-repeat'] = "background-repeat:{$intro_bg_image_background_repeat};";
					}
					if ( $intro_bg_image_background_size ) {
						$mtpl_intro_style['background-size'] = "background-size:{$intro_bg_image_background_size};";
					}
				} elseif ( 'color' === $intro_bg_type && $intro_bg_color ) {
					$mtpl_intro_style['background-color'] = "background-color:{$intro_bg_color};";
				}
				$mtpl_intro_style = implode( ' ', array_filter( array_unique( $mtpl_intro_style ) ) );

				$mtpl_intro_classes = implode( ' ', array_filter( array_unique( $mtpl_intro_classes ) ) );
				?>
				<div class="<?php echo esc_attr( $intro_column_classes ); ?>">
					<div class="<?php echo esc_attr( $mtpl_intro_classes ); ?>" style="<?php echo esc_attr( $mtpl_intro_style ); ?>">
						<?php
						// Overlay
						if ( 'image' === $intro_bg_type && $intro_bg_image ) {
							$mtpl_intro_overlay_style                     = array();
							$mtpl_intro_overlay_style['background-color'] = "background-color:{$intro_bg_image_ol_color};";
							$mtpl_intro_overlay_style                     = implode( ' ', array_filter( array_unique( $mtpl_intro_overlay_style ) ) );
							?>
							<div class="pgs-mtpl-wrapper-overlay" style="<?php echo esc_attr( $mtpl_intro_overlay_style ); ?>"></div>
							<?php
						}

						// Title
						if ( $intro_title ) {
							$intro_title_css = "color:{$intro_title_color}";
							?>
							<div class="mtpl-title"><h2 style="<?php echo esc_attr( $intro_title_css ); ?>"><?php echo esc_html( $intro_title ); ?></h2></div>
							<?php
						}

						// Description
						if ( $intro_description ) {
							$intro_description_css = "color:{$intro_description_color}";
							?>
							<div class="mtpl-description" style="<?php echo esc_attr( $intro_description_css ); ?>"><?php echo esc_html( $intro_description ); ?></div>
							<?php
						}

						// Tabs
						if ( 'intro' === $tabs_position ) {
							pgscore_get_shortcode_templates( 'multi_tab_products_listing/tabs' );
						}

						// Controls
						$controls_classes = array(
							'pgs-mtpl-control',
							'pgs-mtpl-control-' . $index,
						);
						$controls_classes = implode( ' ', array_filter( array_unique( $controls_classes ) ) );
				?>
						<div class="<?php echo esc_attr( $controls_classes ); ?>">
							<div class="mtpl-arrows">
								<?php
								$arrow_sr = 1;
								foreach ( $tabs_data as $tab_item ) {

									$arrow_id = 'mtpl-' . $index . '-arrow-' . $tab_item['tab_slug'];

									$arrow_active = '';
									if ( $arrow_sr == 1 ) {
										$arrow_active = ' active';
									}
									?>
									<div id="<?php echo esc_attr( $arrow_id ); ?>" class="mtpl-arrow<?php echo esc_attr( $arrow_active ); ?>"></div>
									<?php
									$arrow_sr++;
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<?php
			} else {
				$item_column_classes = 'col-xs-12 col-sm-12 col-md-12';
			}
			?>
			<div class="<?php echo esc_attr( $item_column_classes ); ?>">
				<div class="pgs-mtpl-main-wrapper">
					<?php
					if ( $enable_intro != 'true' || 'top' === $tabs_position ) {
						$header_classes = array(
							'pgs-mtpl-header-wrapper',
						);
						if ( $tabs_position == 'top' ) {
							$header_classes[] = 'pgs-mtpl-header-tabs_alignment-' . $tabs_alignment;
						}
						$header_classes = implode( ' ', array_filter( array_unique( $header_classes ) ) );
						?>
					<div class="<?php echo esc_attr( $header_classes ); ?>">
						<div class="pgs-mtpl-header-inner">
							<div class="row">
								<?php
								if ( $enable_intro != 'true' ) {
									?>
									<div class="col">
										<?php
										// Title
										if ( $intro_title ) {
											?>
											<div class="mtpl-title"><h2><?php echo esc_html( $intro_title ); ?></h2></div>
											<?php
										}
										?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							if ( $enable_intro != 'true' ) {
								?>
								<div class="row">
									<div class="col">
										<?php
										// Description
										if ( $intro_description ) {
											?>
											<div class="mtpl-description"><?php echo esc_html( $intro_description ); ?></div>
											<?php
										}
										?>
									</div>
								</div>
								<?php
							}
							if ( 'top' === $tabs_position ) {
								?>
								<div class="row">
									<div class="col">
										<?php pgscore_get_shortcode_templates( 'multi_tab_products_listing/tabs' ); ?>
									</div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php } ?>
					<div class="pgs-mtpl-products-wrapper">
						<?php pgscore_get_shortcode_templates( 'multi_tab_products_listing/tab-contents' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
