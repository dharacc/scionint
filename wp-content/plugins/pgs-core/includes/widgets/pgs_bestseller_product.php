<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Bestseller widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PGS_Bestseller_Widget' ) ) {
	/**
	 * Extends Bestseller Widget
	 */
	class PGS_Bestseller_Widget extends WC_Widget {

		/**
		 * Register widget.
		 */
		public function __construct() {

			$this->widget_id          = 'PGS_Bestseller_Widget';
			$this->widget_name        = esc_html__( 'PGS Bestseller Products', 'pgs-core' );
			$this->widget_description = esc_html__( 'Display bestseller products in sidebar.', 'pgs-core' );
			$this->widget_cssclass    = 'widget_pgs_bestseller_widget';

			$this->settings = array(
				'title'       => array(
					'type'  => 'text',
					'std'   => esc_html__( 'Bestseller Products', 'pgs-core' ),
					'label' => esc_html__( 'Title', 'pgs-core' ),
				),
				'num_of_item' => array(
					'type'  => 'number',
					'step'  => 1,
					'min'   => 1,
					'max'   => '',
					'std'   => 8,
					'label' => esc_html__( 'Number of item', 'pgs-core' ),
				),
			);

			parent::__construct();
		}
		/**
		 * Get bestseller products
		 *
		 * @param array  $args .
		 * @param string $instance .
		 */
		public function get_bestseller_products( $args, $instance ) {

			$num_of_item = ! empty( $instance['num_of_item'] ) ? absint( $instance['num_of_item'] ) : $this->settings['num_of_item']['std'];

			// https://stackoverflow.com/questions/43599991/woocommerce-list-top-selling-products-categories.
			include_once WC()->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php';
			$wc_report = new WC_Admin_Report();

			$data = $wc_report->get_order_report_data(
				array(
					'data'         => array(
						'_product_id'     => array(
							'type'            => 'order_item_meta',
							'order_item_type' => 'line_item',
							'function'        => '',
							'name'            => 'product_id',
						),
						'_qty'            => array(
							'type'            => 'order_item_meta',
							'order_item_type' => 'line_item',
							'function'        => 'SUM',
							'name'            => 'order_item_qty',
						),
						'_line_subtotal'  => array(
							'type'            => 'order_item_meta',
							'order_item_type' => 'line_item',
							'function'        => 'SUM',
							'name'            => 'total_earning',
						),
						'order_item_name' => array(
							'type'     => 'order_item',
							'function' => '',
							'name'     => 'order_item_name',
						),
					),
					'group_by'     => 'product_id',
					'order_by'     => 'order_item_qty DESC',
					'query_type'   => 'get_results',
					'limit'        => $num_of_item,
					'order_status' => array( 'completed', 'processing' ),
				)
			);

			return $data;
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			global $ciyashop_options;

			$allowed_tags = wp_kses_allowed_html( 'post' );

			$products = array();

			$bestseller_products = $this->get_bestseller_products( $args, $instance );
			if ( $bestseller_products && count( $bestseller_products ) > 0 ) {

				foreach ( $bestseller_products as $key => $bestseller_product ) {
					$product = wc_get_product( absint( $bestseller_product->product_id ) );
					if ( $product ) {
						$products[] = $product;
					}
				}

				if ( $products && is_array( $products ) && count( $products ) > 0 ) {

					$this->widget_start( $args, $instance );

					$owl_options_args = array(
						'items'              => 1,
						'autoplay'           => true,
						'loop'               => true,
						'autoplayTimeout'    => 3000,
						'autoplayHoverPause' => true,
						'dots'               => false,
						'nav'                => true,
						'navText'            => array(
							"<i class='fas fa-angle-left fa-2x'></i>",
							"<i class='fas fa-angle-right fa-2x'></i>",
						),
						'smartSpeed'         => 1000,
						'responsive'         => array(
							0    => array(
								'items' => 1,
							),
							600  => array(
								'items' => 1,
							),
							1000 => array(
								'items' => 1,
							),
						),
						'lazyLoad'           => ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) ? true : false,
					);
					$owl_options      = '';
					if ( is_array( $owl_options_args ) && ! empty( $owl_options_args ) ) {
						$owl_options = wp_json_encode( $owl_options_args );
					}
					?>
					<div class="pgs-bestseller-product">
						<div class="all-blocks">
							<div class="block-content">
								<div class="owl-carousel carousel owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
									<?php
									$product_sr = 0;
									foreach ( $products as $product ) {
										$product_sr++;
										$product_id = $product->get_id();

										if ( 1 === (int) $product_sr % 4 ) {
											?>
											<div class="item">
											<?php
										}
										?>
										<div class="sellers-row clearfix">
											<div class="item-img">
												<a href="<?php the_permalink( $product_id ); ?>" title="<?php the_title_attribute( array( 'post' => $product_id ) ); ?>">
													<?php
													if ( has_post_thumbnail( $product_id ) ) {
														if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
															echo '<img class="owl-lazy img-fluid" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( get_the_post_thumbnail_url( $product_id, 'woocommerce_gallery_thumbnail' ) ) . '" alt="' . esc_attr( get_the_title( $product_id ) ) . '" />';
														} else {
															echo '<img class="img-fluid" src="' . esc_url( get_the_post_thumbnail_url( $product_id, 'woocommerce_gallery_thumbnail' ) ) . '" alt="' . esc_attr( get_the_title( $product_id ) ) . '" />';
														}
													} else {
														if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
															echo '<img class="img-fluid owl-lazy" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( get_parent_theme_file_uri( '/assets/img/placeholder/shop_thumbnail.png' ) ) . '" alt="' . esc_attr__( 'No thumb', 'pgs-core' ) . '"/>';
														} else {
															echo '<img class="img-fluid" src="' . esc_url( get_parent_theme_file_uri( '/assets/img/placeholder/shop_thumbnail.png' ) ) . '" alt="' . esc_attr__( 'No thumb', 'pgs-core' ) . '"/>';
														}
													}
													?>
												</a>
											</div>
											<div class="item-detail">
												<h4><a href="<?php the_permalink( $product_id ); ?>" title="<?php the_title_attribute( array( 'post' => $product_id ) ); ?>" class="bestseller-product-title"><?php echo esc_html( $product->get_title() . '-' . $product_sr ); ?></a></h4>
												<p>
												<?php
												echo wp_kses(
													$product->get_price_html(),
													array(
														'span' => array_merge( $allowed_tags['span'], array( 'data-product-id' => true ) ),
														'del'  => $allowed_tags['del'],
														'ins'  => $allowed_tags['ins'],
													)
												);
												?>
												</p>
												<?php
												$rating_count = $product->get_rating_count();
												$review_count = $product->get_review_count();
												$average      = $product->get_average_rating();
												if ( $rating_count > 0 ) {
													?>
													<div class="woocommerce-product-rating">
														<div class="star-rating">
															<span style="width:<?php echo ( ( $average / 5 ) * 100 ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>%">
																<?php
																printf(
																	/* translators: 1: average rating 2: max rating (i.e. 5) */
																	esc_html__( '%1$s out of %2$s', 'pgs-core' ),
																	'<strong class="rating">' . esc_html( $average ) . '</strong>',
																	'<span>5</span>'
																);

																printf(
																	/* translators: %s: rating count */
																	esc_html( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'pgs-core' ) ),
																	'<span class="rating">' . esc_html( $rating_count ) . '</span>'
																);
																?>
															</span>
														</div>
													</div>
													<?php
													if ( comments_open() ) {
														?>
														<a href="<?php the_permalink( $product_id ); ?>#reviews" class="woocommerce-review-link" rel="nofollow">
															<?php
															printf(
																/* translators: %s: review count */
																esc_html( _n( '%s review', '%s reviews', $review_count, 'pgs-core' ) ),
																'<span class="count">' . esc_html( $review_count ) . '</span>'
															);
															?>
														</a>
														<?php
													}
												}
												?>
											</div>
										</div>
										<?php
										if ( 0 === (int) $product_sr % 4 ) {
											?>
											</div>
											<?php
										}
									}
									if ( 0 !== (int) $product_sr % 4 ) {
										?>
										</div>
										<?php
									}

									/* Restore original Post Data */
									wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
					</div>
					<?php

					$this->widget_end( $args );
				}
			}
		}
	}
}
