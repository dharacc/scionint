<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $ciyashop_options;
extract( $pgscore_shortcodes['pgscore_portfolio'] );
extract( $atts );
?>

<div class="project-item">
	<div class="project-info">
		<div class="project-image">
			<?php
			if ( has_post_thumbnail() ) {
				if ( 'carousel' === $portfolio_type && isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
					echo '<img class="owl-lazy" src="' . LOADER_IMAGE . '" data-src="' . get_the_post_thumbnail_url( '', 'ciyashop-latest-post-thumbnail' ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
				} else {
					$size = 'full';
					if ( 'grid' === $portfolio_type ) {
						$size = 'ciyashop-latest-post-thumbnail';
					}

					if ( function_exists( 'ciyashop_lazyload_thumbnail' ) ) {
						$thumbnail_html = ciyashop_lazyload_thumbnail( get_the_ID(), $size );
					} else {
						$thumbnail_html = get_the_post_thumbnail( get_the_ID(), $size );
					}
					echo $thumbnail_html; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				}
			}
			?>
			<div class="portfolio-control">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="portfolio-link"><i class="fas fa-link"></i></span></a>
				<a href="<?php the_post_thumbnail_url( 'full' ); ?>" class="button popup-link popup-img"><i class="fas fa-expand-arrows-alt"></i></a>
			</div>
		</div>
		<div class="overlay">
			<div class="overlay-content">
				<a class="category-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'View Portfolio', 'pgs-core' ); ?></a>
				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
			</div>
		</div>
	</div>
</div>
