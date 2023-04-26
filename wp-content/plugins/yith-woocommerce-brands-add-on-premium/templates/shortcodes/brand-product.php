<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

global $wpdb, $woocommerce, $woocommerce_loop;
?>

	<div class="woocommerce yith-wcbr-product">

		<div class="yith-wcbr-title">
			<?php if ( ! empty( $title ) ) : ?>
				<h2><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
		</div>

		<?php if ( 'yes' === $show_brand_box && isset( $brand ) && 'all' !== $brand ) : ?>
			<div class="yith-wcbr-brand-box">
				<h3><?php echo esc_attr( apply_filters( 'yith_wcbr_brands_box_title', __( 'Products in Brands', 'yith-woocommerce-brands-add-on' ) ) ); ?></h3>

				<p>
					<?php
					$brand_array = explode( ',', $brand );
					$brand_links = array();

					if ( ! empty( $brand_array ) ) {
						foreach ( $brand_array as $elem ) {
							$term = get_term_by( 'slug', $elem, YITH_WCBR::$brands_taxonomy );

							if ( ! is_wp_error( $term ) && $term ) {
								$brand_links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $term, YITH_WCBR::$brands_taxonomy ) ), esc_html( $term->name ) );
							}
						}
					}

					echo implode( ', ', $brand_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</p>
			</div>
		<?php endif; ?>

		<div class="yith-wcbr-product-list row">
			<?php if ( $products->have_posts() ) : ?>
				<ul class="products <?php echo ! empty( $cols ) ? 'columns-' . esc_attr( $cols ) : ''; ?>">
					<?php
					while ( $products->have_posts() ) :
						$products->the_post();

						wc_set_loop_prop( 'columns', $cols );
						wc_get_template( 'content-product.php', array( 'product_in_a_row' => $cols ) );
					endwhile; // end of the loop.
					?>
				</ul>
			<?php endif; ?>
		</div>

		<nav class="yith-wcbr-brands-pagination woocommerce-pagination">
			<?php
			if ( isset( $page_links ) ) {
				echo $page_links; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</nav>
	</div>

<?php wp_reset_query(); ?>