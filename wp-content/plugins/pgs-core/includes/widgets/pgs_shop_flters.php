<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Shop Filters widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends Shop Filters Widget
 */
class PGS_Shop_Filters_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$widget_id   = 'PGS_Shop_Filters_Widget';
		$widget_name = esc_html__( 'PGS Shop Filters', 'pgs-core' );
		$widget_ops  = array(
			'classname'                   => 'woocommerce pgs_shop_filters',
			'description'                 => esc_html__( 'Display product filters in your store (for horizontal use only and will be available for shop/product listing slidebar only).', 'pgs-core' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct( $widget_id, $widget_name, $widget_ops );
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

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		/*
		------------ Set Options -------------
		*/
		$title = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} elseif ( ! isset( $instance['show_in'] ) || 'shop_pg_content' !== (string) $instance['show_in'] ) { // called from widget.
			$title = esc_attr__( 'Shop Filter', 'pgs-core' );
		}

		if ( isset( $instance['filter-attributes'] ) && ! empty( $instance['filter-attributes'] ) ) {
			if ( is_array( $instance['filter-attributes'] ) ) {
				$product_filters = $instance['filter-attributes'];
			} else {
				$product_filters = json_decode( $instance['filter-attributes'], true );
			}
		}

		$filters_to_show = ! empty( $product_filters ) ? $product_filters : array_keys( ciyashop_get_available_attr_array() );

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

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		?>
		<div class="pgs-shop-filters-wrapper">
			<div class="row no-gutters">
				<?php
				if ( in_array( 'search-box', $filters_to_show, true ) ) {
					?>
				<div class="col-md-3 col-sm-6">
					<div class="shop-filter shop-filter-search">
						<div class="shop-filter-wrapper">
							<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'pgs-core' ); ?></label>
							<input type="search" id="shop-filter-search" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'pgs-core' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
						</div>
					</div><!-- .shop-filter.shop-filter-search -->
					<?php
					wc_enqueue_js(
						"jQuery( '.shop-filter #shop-filter-search' ).on('keyup keypress', function(e) {
						var keyCode = e.keyCode || e.which;
						if (keyCode === 13) {
							e.preventDefault();
							var slug = jQuery( this ).val();
							location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 's' ) ) ) ) ) ) . '&s' . "=' + slug;
							return false;
						}
					});"
					);
					?>
				</div>
					<?php
				}
				if ( in_array( 'categories', $filters_to_show, true ) ) {
					?>
				<div class="col-md-3 col-sm-6">
					<div class="shop-filter shop-filter-product-category" data-placeholder="<?php esc_attr_e( 'Any Category', 'pgs-core' ); ?>">
						<div class="shop-filter-wrapper">
							<?php
							global $wp_query, $post;

							$count        = isset( $instance['count'] ) ? $instance['count'] : 0;
							$hierarchical = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : 1;
							$orderby      = isset( $instance['orderby'] ) ? $instance['orderby'] : 'name';
							$hide_empty   = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : 1;

							$dropdown_args = array(
								'hide_empty' => $hide_empty,
							);

							// Setup Current Category.
							$this->current_cat = false;

							if ( is_product_category() ) {
								if ( is_tax( 'product_cat' ) ) {
									$this->current_cat = $wp_query->queried_object;
								}
							} else {
								if ( isset( $wp_query->query ) && ( isset( $wp_query->query['product_cat'] ) && ! empty( $wp_query->query['product_cat'] ) ) ) {
									$this->current_cat = get_term_by( 'slug', $wp_query->query['product_cat'], 'product_cat' );
								}
							}

							$dropdown_defaults = array(
								'show_count'         => 0,
								'hierarchical'       => $hierarchical,
								'show_uncategorized' => 0,
								'orderby'            => $orderby,
								'selected'           => $this->current_cat ? $this->current_cat->slug : '',
								'option_select_text' => esc_html__( 'Any Category', 'pgs-core' ),
							);
							$dropdown_args     = wp_parse_args( $dropdown_args, $dropdown_defaults );

							// Stuck with this until a fix for https://core.trac.wordpress.org/ticket/13258.
							/**
							 * Filters shop filter products categories dropdown args.
							 *
							 * @visible false
							 * @ignore
							 */
							wc_product_dropdown_categories( apply_filters( 'pgs_shop_filters_product_categories_get_terms_args', $dropdown_args ) );
							wc_enqueue_js(
								"
								jQuery( '.shop-filter .dropdown_product_cat' ).change( function() {
									var slug = jQuery( this ).val();
									location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'product_cat' ) ) ) ) ) ) . '&product_cat' . "=' + slug;
								});
							"
							);
							?>
						</div>
					</div><!-- .shop-filter.shop-filter-product-category -->
				</div>
					<?php
				}
				if ( in_array( 'ratings', $filters_to_show, true ) ) {
					$rating_filter = isset( $_GET['rating_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['rating_filter'] ) ) : '';
					$any_label     = esc_html__( 'Any Rating', 'pgs-core' );
					$star          = esc_html__( 'Star', 'pgs-core' );
					?>
					<div class="col-md-2 col-sm-6">
						<div class="shop-filter shop-filter-product-rating" data-placeholder="<?php echo esc_attr__( 'Any Rating', 'pgs-core' ); ?>">
							<div class="shop-filter-wrapper">
								<select class="dropdown_layered_nav_rating">
									<option value=""><?php echo esc_html( $any_label ); ?></option>
									<?php
									for ( $rating = 5; $rating >= 1; $rating-- ) {
										$count       = $this->get_filtered_product_count( $rating );
										$found       = true;
										$rating_html = wc_get_star_rating_html( $rating );

										/**
										 * Filters WooCommerce rating filter count.
										 *
										 * @visible false
										 * @ignore
										 */
										$count_html = esc_html( apply_filters( 'woocommerce_rating_filter_count', "({$count})", $count, $rating ) );

										printf(
											'<option value="%1$s" %2$s>%3$s %4$s</option>',
											esc_attr( $rating ),
											selected( $rating_filter, $rating, false ),
											esc_html( $rating ),
											esc_html( $star )
										);
									}
									?>
								</select>
							</div>
						</div><!-- .shop-filter.shop-filter-product-rating -->
					</div>
					<?php
					wc_enqueue_js(
						"
					jQuery( '.shop-filter .dropdown_layered_nav_rating' ).change( function() {
						var slug = jQuery( this ).val();
						location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'rating_filter' ) ) ) ) ) ) . '&rating_filter' . "=' + slug;
					});
					"
					);
				}
				if ( in_array( 'price-slider', $filters_to_show, true ) ) {
					?>
				<div class="col-md-4 col-sm-6">
					<div class="shop-filter shop-filter-product-price widget_price_filter">
						<?php
						if ( ! isset( $instance['show_in'] ) || 'shop_pg_content' !== (string) $instance['show_in'] ) {
							?>
						<form>
							<?php
						}
						?>
							<div class="shop-filter-wrapper">
								<?php
								global $wp, $wp_the_query;

								// Find min and max price in current result set.
								$prices = $this->get_filtered_price();
								$min    = floor( $prices->min_price );
								$max    = ceil( $prices->max_price );

								/**
								 * Filters shop price-filter minimum amount.
								 *
								 * @visible false
								 * @ignore
								 */
								$min_price = isset( $_GET['min_price'] ) ? esc_attr( wc_clean( $_GET['min_price'] ) ) : apply_filters( 'ciyashop_price_filter_widget_min_amount', $min );

								/**
								 * Filters shop price-filter maximum amount.
								 *
								 * @visible false
								 * @ignore
								 */
								$max_price = isset( $_GET['max_price'] ) ? esc_attr( wc_clean( $_GET['max_price'] ) ) : apply_filters( 'ciyashop_price_filter_widget_min_amount', $max );

								wp_enqueue_script( 'wc-price-slider' );

								if ( '' === get_option( 'permalink_structure' ) ) {
									$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
								} else {
									$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
								}

								/**
								 * Adjust max if the store taxes are not displayed how they are stored.
								 * Min is left alone because the product may not be taxable.
								 * Kicks in when prices excluding tax are displayed including tax.
								 */
								if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
									$tax_classes = array_merge( array( '' ), WC_Tax::get_tax_classes() );
									$class_max   = $max;

									foreach ( $tax_classes as $tax_class ) {
										$tax_rates = WC_Tax::get_rates( $tax_class );
										if ( $tax_rates ) {
											$class_max = $max + WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max, $tax_rates ) );
										}
									}

									$max = $class_max;
								}
								?>
								<div class="price_slider_wrapper">
									<div class="price_slider_wrapper-inner">
										<div class="price_slider"></div>
										<div class="price_slider_amount">
											<?php
												/**
												 * Filters shop price-filter minimum amount.
												 *
												 * @visible false
												 * @ignore
												 */
												$data_min = apply_filters( 'woocommerce_price_filter_widget_min_amount', $min );
												/**
												 * Filters shop price-filter minimum amount.
												 *
												 * @visible false
												 * @ignore
												 */
												$data_max = apply_filters( 'woocommerce_price_filter_widget_max_amount', $max );
											?>
											<input type="text" id="min_price" name="min_price" value="<?php echo esc_attr( $min_price ); ?>" data-min="<?php echo esc_attr( $data_min ); ?>" placeholder="<?php echo esc_attr__( 'Min price', 'pgs-core' ); ?>" />
											<input type="text" id="max_price" name="max_price" value="<?php echo esc_attr( $max_price ); ?>" data-max="<?php echo esc_attr( $data_max ); ?>" placeholder="<?php echo esc_attr__( 'Max price', 'pgs-core' ); ?>" />
											<div class="price_label"><span class="from"></span> &mdash; <span class="to"></span></div>
											<?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price' ), '', true ); ?>
											<div class="clear"></div>
										</div>
									</div>
									<button type="submit" class="button"><?php esc_html_e( 'Filter', 'pgs-core' ); ?></button>
								</div>
							</div>
							<?php
							if ( ! isset( $instance['show_in'] ) || 'shop_pg_content' !== (string) $instance['show_in'] ) {
								?>
						</form>
								<?php
							}
							?>
					</div><!-- .shop-filter.shop-filter-product-price -->
				</div>
					<?php
				}
				?>
			</div>
			<div class="row no-gutters">
				<?php
				$attrs_to_exclude = array_diff( array_keys( ciyashop_get_available_attr_array( 'taxonomy_attributes' ) ), $filters_to_show );

				$_chosen_attributes   = WC_Query::get_layered_nav_chosen_attributes();
				$attribute_taxonomies = wc_get_attribute_taxonomies();
				/**
				 * Filters shop filter attributes to exclude.
				 *
				 * @param array    $attributes      Array of attributes to exclude.
				 *
				 * @visible true
				 */
				$exclude_attributes = (array) array_filter( apply_filters( 'ciyashop_shop_filter_exclude_attributes', $attrs_to_exclude ) );

				$attribute_sr = 0;
				if ( ! empty( $attribute_taxonomies ) ) {
					foreach ( $attribute_taxonomies as $tax ) {

						// Skip attributes if it's exclude list.
						if ( in_array( $tax->attribute_name, $exclude_attributes, true ) ) {
							continue;
						}

						if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
							$taxonomy       = wc_attribute_taxonomy_name( $tax->attribute_name );
							$taxonomy_label = wc_attribute_label( $taxonomy );
							$query_type     = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';

							$get_terms_args = array( 'hide_empty' => '1' );

							$orderby = wc_attribute_orderby( $taxonomy );

							switch ( $orderby ) {
								case 'name':
									$get_terms_args['orderby']    = 'name';
									$get_terms_args['menu_order'] = false;
									break;
								case 'id':
									$get_terms_args['orderby']    = 'id';
									$get_terms_args['order']      = 'ASC';
									$get_terms_args['menu_order'] = false;
									break;
								case 'menu_order':
									$get_terms_args['menu_order'] = 'ASC';
									break;
							}

							$terms = get_terms( $taxonomy, $get_terms_args );

							if ( 0 !== count( $terms ) ) {

								switch ( $orderby ) {
									case 'name_num':
										usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
										break;
									case 'parent':
										usort( $terms, '_wc_get_product_terms_parent_usort_callback' );
										break;
								}

								$row_break = 6;
								if ( 0 !== (int) $attribute_sr && 0 === (int) $attribute_sr % $row_break ) {
									?>
									</div>
									<div class="row no-gutters">
									<?php
								}
								
								$term_counts = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
								if ( $term_counts ) {
									?>
									<div class="col-sm">
										<div class="shop-filter shop-filter-product-<?php echo esc_attr( $tax->attribute_name ); ?>" data-placeholder="
									<?php
																								/* translators: $s: Any */
																								echo sprintf( esc_attr__( 'Any %s', 'pgs-core' ), esc_html( $taxonomy_label ) );
									?>
										">
											<div class="shop-filter-wrapper">
												<?php $found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type ); ?>
											</div>
										</div><!-- .shop-filter.shop-filter-product-<?php echo esc_attr( $tax->attribute_name ); ?>-->
									</div>
									<?php
								}
							}
							$attribute_sr++;
						}
					}
				}
				?>
			</div>
		</div>
		<?php

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
		$title            = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Shop Filter', 'pgs-core' );
		$filter_btn_title = ! empty( $instance['filter-btn-title'] ) ? $instance['filter-btn-title'] : esc_html__( 'Filter', 'pgs-core' );
		?>
		<div class="ciyashop-filter-widget">
			<div class="form-group">
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pgs-core' ); ?></label>
				<p>
				<input class="widefat form-control" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
				</p>
			</div>
			<div class="form-group">
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter-attributes' ) ); ?>">
					<?php esc_html_e( 'Select Filter fields:', 'pgs-core' ); ?>
				</label>
				<p>
				<?php
				$attributes     = ciyashop_get_available_attr_array( 'default_filters' );
				$selected_attrs = '';
				if ( isset( $instance['filter-attributes'] ) && ! empty( $instance['filter-attributes'] ) ) {
					$selected_attrs = (array) json_decode( $instance['filter-attributes'], true );
				}

				if ( ! empty( $attributes ) ) {
					foreach ( $attributes as $key => $attr ) {
						$checked = ( ! empty( $selected_attrs ) && in_array( $key, $selected_attrs, true ) ) ? 'checked="checked"' : '';
						?>
						<span>
							<input type="checkbox" class="ciyashop-checkbox" name="<?php echo esc_attr( $this->get_field_name( 'filter-attributes' ) ); ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $checked ); ?>>
							<?php echo esc_html( ucwords( $attr ) ); ?>
						</span>
						<?php
					}
				}
				?>
				</p>
				</div>
				<div class="form-group">
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter-attributes' ) ); ?>">
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product&page=product_attributes' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Select Filter Attributes:', 'pgs-core' ); ?>
					</a>
				</label>
				<p class="ciyashop-filter-attributes">
				<?php
				$attributes     = ciyashop_get_available_attr_array( 'taxonomy_attributes' );
				$selected_attrs = '';
				if ( isset( $instance['filter-attributes'] ) && ! empty( $instance['filter-attributes'] ) ) {
					$selected_attrs = (array) json_decode( $instance['filter-attributes'], true );
				}

				if ( ! empty( $attributes ) ) {
					foreach ( $attributes as $key => $attr ) {
						$checked = ( ! empty( $selected_attrs ) && in_array( $key, $selected_attrs, true ) ) ? 'checked="checked"' : '';
						?>
						<span>
							<input type="checkbox" class="ciyashop-checkbox" name="<?php echo esc_attr( $this->get_field_name( 'filter-attributes' ) ); ?>[]" value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $checked ); ?>>
							<?php echo esc_html( ucwords( $attr ) ); ?>
						</span>
						<?php
					}
				}
				?>
				</p>
			</div>
		</div>
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

		$instance = array();

		$instance['title']             = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['filter-attributes'] = ( ! empty( $new_instance['filter-attributes'] ) ) ? wp_strip_all_tags( wp_json_encode( $new_instance['filter-attributes'] ) ) : '';

		return $instance;
	}

	/**
	 * Return the currently viewed taxonomy name.
	 *
	 * @return string
	 */
	protected function get_current_taxonomy() {
		return is_tax() ? get_queried_object()->taxonomy : '';
	}

	/**
	 * Return the currently viewed term ID.
	 *
	 * @return int
	 */
	protected function get_current_term_id() {
		return absint( is_tax() ? get_queried_object()->term_id : 0 );
	}

	/**
	 * Return the currently viewed term slug.
	 *
	 * @return int
	 */
	protected function get_current_term_slug() {
		return absint( is_tax() ? get_queried_object()->slug : 0 );
	}

	/**
	 * Show dropdown layered nav.
	 *
	 * @param  array  $terms .
	 * @param  string $taxonomy .
	 * @param  string $query_type .
	 * @return bool Will nav display?
	 */
	protected function layered_nav_dropdown( $terms, $taxonomy, $query_type ) {
		$found = false;

		$term_counts          = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
		$_chosen_attributes   = WC_Query::get_layered_nav_chosen_attributes();
		$taxonomy_filter_name = str_replace( 'pa_', '', $taxonomy );
		$taxonomy_label       = wc_attribute_label( $taxonomy );

		/**
		 * Filters WooCommerce layered nav.
		 *
		 * @visible false
		 * @ignore
		 */
		$any_label = apply_filters(
			'woocommerce_layered_nav_any_label',
			sprintf(
			/* translators: $s: Any */
				esc_html__( 'Any %s', 'pgs-core' ),
				$taxonomy_label
			),
			$taxonomy_label,
			$taxonomy
		);

		if ( $term_counts ) {
			?>
			<select class="dropdown_layered_nav_<?php echo esc_attr( $taxonomy_filter_name ); ?>">
				<option value=""><?php echo esc_html( $any_label ); ?></option>
				<?php
				foreach ( $terms as $term ) {
					// Get count based on current view.
					$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
					$option_is_set  = in_array( $term->slug, $current_values, true );
					$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

					// Only show options with count > 0.
					if ( 0 < $count ) {
						$found = true;
					} elseif ( 0 === $count && ! $option_is_set ) {
						continue;
					}
					?>
					<option value="<?php echo esc_attr( $term->slug ); ?>" <?php echo selected( $option_is_set, true, false ); ?>><?php echo esc_html( $term->name ); ?></option>
					<?php
				}
				?>
			</select>
			<?php
		}

		wc_enqueue_js(
			"
			jQuery( '.shop-filter .dropdown_layered_nav_" . esc_js( $taxonomy_filter_name ) . "' ).change( function() {
				var slug = jQuery( this ).val();
				location.href = '" . preg_replace( '%\/page\/[0-9]+%', '', str_replace( array( '&amp;', '%2C' ), array( '&', ',' ), esc_js( add_query_arg( 'filtering', '1', remove_query_arg( array( 'page', 'filter_' . $taxonomy_filter_name ) ) ) ) ) ) . '&filter_' . esc_js( $taxonomy_filter_name ) . "=' + slug;
			});
		"
		);

		return $found;
	}

	/**
	 * Count products within certain terms, taking the main WP query into consideration.
	 *
	 * @param  array  $term_ids .
	 * @param  string $taxonomy .
	 * @param  string $query_type .
	 * @return array
	 */
	protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		if ( 'or' === $query_type ) {
			foreach ( $tax_query as $key => $query ) {
				if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
					unset( $tax_query[ $key ] );
				}
			}
		}

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		// Generate query.
		$query           = array();
		$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
		$query['from']   = "FROM {$wpdb->posts}";
		$query['join']   = "
			INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
			INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
			INNER JOIN {$wpdb->terms} AS terms USING( term_id )
			" . $tax_query_sql['join'] . $meta_query_sql['join'];

		$query['where'] = "
			WHERE {$wpdb->posts}.post_type IN ( 'product' )
			AND {$wpdb->posts}.post_status = 'publish'
			" . $tax_query_sql['where'] . $meta_query_sql['where'] . '
			AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')
		';

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$query['where'] .= ' AND ' . $search;
		}

		$query['group_by'] = 'GROUP BY terms.term_id';
		/**
		 * Filters WooCommerce filtered term product counts.
		 *
		 * @visible false
		 * @ignore
		 */
		$query   = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
		$query   = implode( ' ', $query );
		$results = $wpdb->get_results( $query );

		return wp_list_pluck( $results, 'term_count', 'term_count_id' );
	}

	/**
	 * Count products after other filters have occurred by adjusting the main query.
	 *
	 * @param  int $rating .
	 * @return int
	 */
	protected function get_filtered_product_count( $rating ) {
		global $wpdb;

		$tax_query  = WC_Query::get_main_tax_query();
		$meta_query = WC_Query::get_main_meta_query();

		// Unset current rating filter.
		foreach ( $tax_query as $key => $query ) {
			if ( ! empty( $query['rating_filter'] ) ) {
				unset( $tax_query[ $key ] );
				break;
			}
		}

		// Set new rating filter.
		$product_visibility_terms = wc_get_product_visibility_term_ids();
		$tax_query[]              = array(
			'taxonomy'      => 'product_visibility',
			'field'         => 'term_taxonomy_id',
			'terms'         => $product_visibility_terms[ 'rated-' . $rating ],
			'operator'      => 'IN',
			'rating_filter' => true,
		);

		$meta_query     = new WP_Meta_Query( $meta_query );
		$tax_query      = new WP_Tax_Query( $tax_query );
		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) FROM {$wpdb->posts} ";
		$sql .= $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$sql .= ' AND ' . $search;
		}

		return absint( $wpdb->get_var( $sql ) );
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
		} else {
			$link = get_term_link( get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		}

		// Min/Max.
		if ( isset( $_GET['min_price'] ) ) {
			$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
		}

		if ( isset( $_GET['max_price'] ) ) {
			$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
		}

		// Orderby.
		if ( isset( $_GET['orderby'] ) ) {
			$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
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
			$link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
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
	 * Get filtered min price for current products.
	 *
	 * @return int
	 */
	protected function get_filtered_price() {
		global $wpdb, $wp_the_query;

		$args       = $wp_the_query->query_vars;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		/**
		 * Filters WooCommerce price filter post type.
		 *
		 * @visible false
		 * @ignore
		 */
		$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$sql .= ' AND ' . $search;
		}

		return $wpdb->get_row( $sql );
	}
}
