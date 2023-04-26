<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Layered Navigation Filters Widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends Widget Layered Nav Filters
 */
class PGS_Widget_Layered_Nav_Filters extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_layered_nav_filters pgs_layered_nav_filters';
		$this->widget_description = esc_html__( 'Shows active layered nav filters so users can see and deactivate them.', 'pgs-core' );
		$this->widget_id          = 'pgs_layered_nav_filters';
		$this->widget_name        = esc_html__( 'PGS Layered Nav Filters', 'pgs-core' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Active filters', 'pgs-core' ),
				'label' => esc_html__( 'Title', 'pgs-core' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Get current page URL for layered nav items.
	 *
	 * @return string
	 */
	protected function get_page_base_url() {
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif ( is_product_category() ) {
			$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
		} elseif ( is_product_tag() ) {
			$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
		} else {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		}

		// Min/Max.
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
		}

		// Orderby.
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
		}

		/**
		 * Search Arg.
		 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
		 */
		if ( get_search_query() ) {
			$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
		}

		// Post Type Arg.
		if ( isset( $_GET['post_type'] ) ) {
			$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );
		}

		// Min Rating Arg.
		if ( isset( $_GET['rating_filter'] ) ) {
			$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
		}

		// Min Rating Arg.
		if ( isset( $_GET['product_cat'] ) ) {
			$link = add_query_arg( 'product_cat', wc_clean( wp_unslash( $_GET['product_cat'] ) ), $link );
		}

		// All current filters.
		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		if ( $_chosen_attributes ) {
			foreach ( $_chosen_attributes as $name => $data ) {
				$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
				if ( ! empty( $data['terms'] ) ) {
					$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
				}
				if ( 'or' === (string) $data['query_type'] ) {
					$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
				}
			}
		}

		return $link;
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 * @param array $args .
	 * @param array $instance .
	 */
	public function widget( $args, $instance ) {
		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0;
		$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0;
		$product_cat        = isset( $_GET['product_cat'] ) ? wc_clean( wp_unslash( $_GET['product_cat'] ) ) : '';
		$search_text        = isset( $_GET['s'] ) ? wc_clean( wp_unslash( $_GET['s'] ) ) : '';
		$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wc_clean( wp_unslash( $_GET['rating_filter'] ) ) ) ) ) : array();
		$base_link          = $this->get_page_base_url();

		if ( 0 < count( $_chosen_attributes ) || 0 < $min_price || 0 < $max_price || ! empty( $rating_filter ) || ! empty( $product_cat ) ) {

			$this->widget_start( $args, $instance );

			?>
			<ul>
				<?php
				// Attributes.
				if ( ! empty( $_chosen_attributes ) ) {
					foreach ( $_chosen_attributes as $taxonomy => $data ) {
						foreach ( $data['terms'] as $term_slug ) {
							$term = get_term_by( 'slug', $term_slug, $taxonomy );
							if ( ! $term ) {
								continue;
							}

							$filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
							$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
							$current_filter = array_map( 'sanitize_title', $current_filter );
							$new_filter     = array_diff( $current_filter, array( $term_slug ) );

							$link = remove_query_arg( array( 'add-to-cart', $filter_name ), $base_link );

							if ( count( $new_filter ) > 0 ) {
								$link = add_query_arg( $filter_name, implode( ',', $new_filter ), $link );
							}
							?>
							<li class="chosen">
								<a aria-label="<?php echo esc_attr__( 'Remove filter', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>">
									<?php echo esc_html( $term->name ); ?>
								</a>
							</li>
							<?php
						}
					}
				}

				if ( $min_price ) {
					$link = remove_query_arg( 'min_price', $base_link );
					?>
					<li class="chosen">
						<a aria-label="<?php echo esc_attr__( 'Remove filter', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>">
							<?php
							printf(
								/* translators: %s: Minimum Price */
								esc_html__( 'Min %s', 'pgs-core' ),
								wc_price( $min_price )
							); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
							?>
						</a>
					</li>
					<?php
				}

				if ( $max_price ) {
					$link = remove_query_arg( 'max_price', $base_link );
					?>
					<li class="chosen">
						<a aria-label="<?php echo esc_attr__( 'Remove filter', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>">
							<?php
							printf(
								/* translators: %s: Maximum Price */
								esc_html__( 'Max %s', 'pgs-core' ),
								wc_price( $max_price )
							); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
							?>
						</a>
					</li>
					<?php
				}

				if ( $product_cat ) {
					$link       = remove_query_arg( 'product_cat', $base_link );
					$filter_cat = get_term_by( 'slug', $product_cat, 'product_cat' );
					?>
					<li class="chosen"><a aria-label="<?php echo esc_attr__( 'Remove category', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $filter_cat->name ); ?></a></li>
					<?php
				}

				if ( $search_text ) {
					$link = remove_query_arg( array( 's', 'post_type' ), $base_link );
					?>
					<li class="chosen"><a aria-label="<?php echo esc_attr__( 'Remove search text', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $search_text ); ?></a></li>
					<?php
				}

				if ( ! empty( $rating_filter ) ) {
					foreach ( $rating_filter as $rating ) {
						$link_ratings = implode( ',', array_diff( $rating_filter, array( $rating ) ) );
						$link         = $link_ratings ? add_query_arg( 'rating_filter', $link_ratings ) : remove_query_arg( 'rating_filter', $base_link );
						?>
						<li class="chosen">
							<a aria-label="<?php echo esc_attr__( 'Remove filter', 'pgs-core' ); ?>" href="<?php echo esc_url( $link ); ?>">
								<?php
								/* translators: %s: rating */
								echo sprintf( esc_html__( 'Rated %s out of 5', 'pgs-core' ), esc_html( $rating ) );
								?>
							</a>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
			$this->widget_end( $args );
		}
	}
}
