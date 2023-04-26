<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_recent_posts'] );
extract( $atts );

$control_index_class = "latest-post-control-{$index}";

$latest_post_classes = array(
	'latest-post-wrapper',
	'latest-post-type-' . $listing_type,
	'latest-post-' . $style,
	'latest-post-' . ( $enable_intro == 'true' ? 'with-intro' : 'without-intro' ),
);
$latest_post_classes = implode( ' ', array_filter( array_unique( $latest_post_classes ) ) );

$link_attr = false;

// Link Attributes
if ( $enable_intro_link == 'true' ) {
	$link_attr = pgscore_vc_link_attr(
		$intro_link,
		'',
		array(
			'style' => "color:{$intro_link_color};",
		)
	);
}

// Re-assin link attribute
$pgscore_shortcodes['pgscore_recent_posts']['atts']['link_attr'] = $link_attr;
?>
<div class="<?php echo esc_attr( $latest_post_classes ); ?>" data-intro="<?php echo esc_attr( $enable_intro == 'true' ? 'yes' : 'no' ); ?>">
	<div class="latest-post-inner">
		<div class="row<?php echo ( ( $enable_intro == 'true' ) ? ' no-gutters' : '' ); ?>">
			<?php
			if ( $enable_intro == 'true' ) {

				// Check intro position
				if ( 'right' === $intro_position ) {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1';
				} else {
					$intro_column_classes = 'col-xs-12 col-sm-12 col-md-4 col-lg-3';
					$item_column_classes  = 'col-xs-12 col-sm-12 col-md-8 col-lg-9';
				}

				$latest_post_classes = array(
					'latest-post-intro-wrapper',
					'latest-post-intro-content-alignment-' . $intro_content_alignment,
					'latest-post-intro-bg_type-' . $intro_bg_type,
				);

				// Intro Style
				$intro_style = array();
				if ( 'image' === $intro_bg_type && $intro_bg_image ) {
					$intro_bg_image                  = wp_get_attachment_image_src( $intro_bg_image, 'full' );
					$intro_style['background-image'] = "background-image:url({$intro_bg_image[0]});";

					if ( $intro_bg_image_background_position ) {
						$intro_style['background-position'] = "background-position:{$intro_bg_image_background_position};";
					}
					if ( $intro_bg_image_background_repeat ) {
						$intro_style['background-repeat'] = "background-repeat:{$intro_bg_image_background_repeat};";
					}
					if ( $intro_bg_image_background_size ) {
						$intro_style['background-size'] = "background-size:{$intro_bg_image_background_size};";
					}
				} elseif ( 'color' === $intro_bg_type && $intro_bg_color ) {
					$intro_style['background-color'] = "background-color:{$intro_bg_color};";
				}
				$intro_style = implode( ' ', array_filter( array_unique( $intro_style ) ) );

				$latest_post_classes = implode( ' ', array_filter( array_unique( $latest_post_classes ) ) );
				?>
				<div class="<?php echo esc_attr( $intro_column_classes ); ?>">
					<div class="<?php echo esc_attr( $latest_post_classes ); ?>" style="<?php echo esc_attr( $intro_style ); ?>">
						<?php
						pgscore_get_shortcode_templates( 'recent_posts/content-parts/overlay' );
						pgscore_get_shortcode_templates( 'recent_posts/content-parts/title' );
						pgscore_get_shortcode_templates( 'recent_posts/content-parts/description' );
						if ( $enable_intro_link == 'true' && ( 'grid' === $listing_type || ( 'carousel' === $listing_type && 'with_controls' !== $intro_link_position ) ) && ( ! empty( $link_title ) && ! empty( $link_attr ) ) ) {
							pgscore_get_shortcode_templates( 'recent_posts/content-parts/link' );
						}

						if ( 'carousel' === $listing_type ) {
							// Classes
							$controls_classes = array(
								'latest-post-control',
								"latest-post-control-{$index}",
							);
							if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position ) {
								$controls_classes[] = "latest-post-control-link-alignment-{$intro_link_alignment}";
							}
							$controls_classes = implode( ' ', array_filter( array_unique( $controls_classes ) ) );
							?>
							<div class="<?php echo esc_attr( $controls_classes ); ?>">
								<?php
								if ( $enable_intro_link == 'true' && 'with_controls' === $intro_link_position && ( ! empty( $link_title ) && ! empty( $link_attr ) ) ) {
									pgscore_get_shortcode_templates( 'recent_posts/content-parts/link' );
								}
								?>
								<div class="latest-post-nav"></div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			} else {
				$item_column_classes = 'col-xs-12 col-sm-12 col-md-12';
			}
			?>
			<div class="<?php echo esc_attr( $item_column_classes ); ?>">
				<div class="latest-post-main">
					<div class="latest-post-main-inner">
						<div class="latest-post-content">
							<div class="latest-post-content-inner">
								<?php pgscore_get_shortcode_templates( 'recent_posts/list_style/' . $listing_type ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
