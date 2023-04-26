<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );

$listing_wrapper_classes = array(
	'products-listing-items-wrapper',
	"products-listing-{$listing_type}",
	'woocommerce',
);

$listing_wrapper_classes = implode( ' ', array_filter( array_unique( $listing_wrapper_classes ) ) );
?>
<div class="<?php echo esc_attr( $listing_wrapper_classes ); ?>">
	<?php if ( $loop->have_posts() ) : ?>

		<?php
			/**
			 * woocommerce_before_shop_loop hook.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
		?>

		<?php
		// setting ported from woocommerce_product_loop_start();
		$GLOBALS['woocommerce_loop']['loop'] = 0;

		$listing_classes = array(
			'products',
			'products-loop',
			'row',
			'grid',
		);

		$carousel_option = '';

		if ( 'grid' === $listing_type ) {
			$listing_classes[] = "products-loop-column-{$list_grid_columns}";
		} elseif ( 'carousel' === $listing_type ) {
			$listing_classes[] = 'owl-carousel owl-theme owl-carousel-options';

			$owl_options_args = array(
				'items'              => 3,
				'responsive'         => array(
					0    => array(
						'items' => 1,
					),
					576  => array(
						'items' => $list_carousel_items_sm,
					),
					768  => array(
						'items' => $list_carousel_items_md,
					),
					992  => array(
						'items' => $list_carousel_items_lg,
					),
					1200 => array(
						'items' => $list_carousel_items_xl,
					),
				),
				'margin'             => 20,
				'dots'               => false,
				'nav'                => true,
				'loop'               => true,
				'autoplay'           => false,
				'autoplayHoverPause' => true,
				'autoplayTimeout'    => 3100,
				'smartSpeed'         => 1000,
				'navText'            => array(
					'<i class="fas fa-angle-left fa-2x"></i>',
					'<i class="fas fa-angle-right fa-2x"></i>',
				),
				'lazyLoad'           => true,
			);
			if ( $enable_intro == 'true' ) {
				$owl_options_args['navContainer'] = ".products-listing-control.products-listing-control-{$index} .products-listing-nav";
			} elseif ( $enable_intro != 'true' && $intro_title ) {
				$owl_options_args['navContainer'] = ".products-listing-header-control.products-listing-header-control-{$index} .products-listing-nav";
			}

			$owl_options_args = apply_filters( 'products_listing_owl_options_args', $owl_options_args, $atts );

			$owl_options     = json_encode( $owl_options_args );
			$carousel_option = $owl_options;
		}

		$listing_classes = implode( ' ', array_filter( array_unique( $listing_classes ) ) );
		?>
		<ul class="<?php echo esc_attr( $listing_classes ); ?>" data-owl_options="<?php echo esc_attr( $carousel_option ); ?>">

			<?php
			while ( $loop->have_posts() ) :
				$loop->the_post();
				?>

				<?php
					/**
					 * woocommerce_shop_loop hook.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );
				?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>
			
			<?php wp_reset_postdata(); ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php
			/**
			 * woocommerce_after_shop_loop hook.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		?>

	<?php endif; ?>
</div>
