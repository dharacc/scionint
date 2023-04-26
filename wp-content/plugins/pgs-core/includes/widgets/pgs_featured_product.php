<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Feature widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends Featured Products Widget
 */
class PGS_Featured_Products_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'PGS_Featured_Products_Widget', // Base ID.
			esc_html__( 'PGS Featured Products', 'pgs-core' ), // Name.
			array( 'description' => esc_html__( 'A Feature Products Sidebar Widget', 'pgs-core' ) ) // Args.
		);
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

		$posts_per_page = isset( $instance['num_of_item'] ) ? $instance['num_of_item'] : 8;
		$title          = isset( $instance['title'] ) && ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Featured Products', 'pgs-core' );

		/**
		 * Filters the widget title.
		 *
		 * @since 2.6.0
		 *
		 * @param string $title    The widget title. Default 'Pages'.
		 * @param array  $instance Array of settings for the current widget.
		 * @param mixed  $id_base  The widget ID.
		 *
		 * @visible false
		 * @ignore
		 */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		// Get Featured IDs.
		/**
		 * Filters featured products ids.
		 *
		 * @visible false
		 * @ignore
		 */
		$featured_product_ids = apply_filters( 'pgs_featured_products_widget_ids', wc_get_featured_product_ids() );

		// Return if no featured product found.
		if ( 0 === (int) count( $featured_product_ids ) ) {
			return;
		}

		// Query args.
		/**
		 * Filters featured products widget args.
		 *
		 * @visible false
		 * @ignore
		 */
		$query_args = apply_filters(
			'pgs_featured_products_widget_args',
			array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'no_found_rows'       => 1,
				'posts_per_page'      => $posts_per_page,
				'orderby'             => 'rand',
				'order'               => 'desc',
				'post__in'            => $featured_product_ids,
			)
		);

		$products = new WP_Query( $query_args );

		if ( $products->have_posts() ) {

			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

			$owl_options_args = array(
				'items'              => 1,
				'autoplay'           => true,
				'loop'               => true,
				'autoplayTimeout'    => 3000,
				'autoplayHoverPause' => true,
				'dots'               => false,
				'nav'                => true,
				'smartSpeed'         => 1000,
				'navText'            => array(
					"<i class='fas fa-angle-left fa-2x'></i>",
					"<i class='fas fa-angle-right fa-2x'></i>",
				),
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
			<div class="pgs-featured-product">
				<div class="all-blocks">
					<div class="title-block">
					<?php
						echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
					?>
					</div>
					<div class="block-content">
						<div class="owl-carousel carousel owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
							<?php
							$product_sr = 0;
							while ( $products->have_posts() ) {
								$products->the_post();

								global $product, $post;

								$product_sr++;

								if ( 1 === (int) $product_sr % 4 ) {
									?>
									<div class="item">
									<?php
								}
								?>
								<div class="sellers-row clearfix">
									<div class="item-img">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php
											if ( has_post_thumbnail() ) {
												if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
													echo '<img class="owl-lazy img-fluid" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( get_the_post_thumbnail_url( $product->get_id(), 'woocommerce_gallery_thumbnail' ) ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
												} else {
													echo '<img class="img-fluid" src="' . esc_url( get_the_post_thumbnail_url( $product->get_id(), 'woocommerce_gallery_thumbnail' ) ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
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
										<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="featured-product-title"><?php the_title(); ?></a></h4>
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
													<span style="width:<?php echo esc_attr( ( $average / 5 ) * 100 ); ?>%">
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
												<a href="<?php the_permalink(); ?>#reviews" class="woocommerce-review-link" rel="nofollow">
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
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Featured Products', 'pgs-core' );
		$num_of_item = ! empty( $instance['num_of_item'] ) ? $instance['num_of_item'] : 8;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pgs-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num_of_item' ) ); ?>"><?php esc_html_e( 'Number of item:', 'pgs-core' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'num_of_item' ) ); ?>"  type="number" name="<?php echo esc_attr( $this->get_field_name( 'num_of_item' ) ); ?>" value="<?php echo esc_attr( $num_of_item ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['num_of_item'] = wp_strip_all_tags( $new_instance['num_of_item'] );

		return $instance;
	}
}
