<?php
/**
 * Brands Thumbnail Carousel Widget
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.0.0
 */

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

if ( ! class_exists( 'YITH_WCBR_Brand_Thumbnail_Carousel_Widget' ) ) {
	/**
	 * WooCommerce Brands Thumbnail Widget
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Thumbnail_Carousel_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @return \YITH_WCBR_Brand_Thumbnail_Carousel_Widget
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_thumbnail_carousel',
				__( 'YITH Brand Thumbnail Carousel', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Add a carousel of brand thumbnails', 'yith-woocommerce-brands-add-on' )
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @return void
		 * @see   WP_Widget::widget()
		 *
		 * @since 1.0.0
		 */
		public function widget( $args, $instance ) {
			$title = '';

			// translate widget title
			if ( isset( $instance['title'] ) ) {
				$title = $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
				unset( $instance['title'] );
			}

			// parse args
			$shortcode_atts_string = '';
			$shortcode_atts        = apply_filters( 'yith_wcbr_thumbnail_carrousel_shortcode_atts', shortcode_atts( array(
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'hide_empty'         => 'no',
				// yes - no
				'hide_no_image'      => 'no',
				// yes - no
				'direction'          => 'horizontal',
				// horizontal - vertical
				'cols'               => 2,
				// int
				'autoplay'           => 'yes',
				// yes - no
				'pagination'         => 'no',
				// yes - no
				'pagination_style'   => 'round',
				// round - square
				'prev_next'          => 'no',
				// yes - no
				'prev_next_style'    => 'round',
				// round - square
				'show_name'          => 'yes',
				// yes - no
				'show_rating'        => 'no',
				// yes - no
				'style'              => 'default',
				// default - top-border - shadow - centered-title - boxed - squared - background
			), $instance ) );

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget'];
			echo $title;
			echo do_shortcode( "[yith_wcbr_brand_thumbnail_carousel  $shortcode_atts_string]" );
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @return void
		 * @see   WP_Widget::form()
		 *
		 * @since 1.0.0
		 */
		public function form( $instance ) {
			$title              = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$hide_empty         = isset( $instance['hide_empty'] ) && $instance['hide_empty'] == 'yes';
			$hide_no_image      = isset( $instance['hide_no_image'] ) && $instance['hide_no_image'] == 'yes';
			$autoplay           = isset( $instance['autoplay'] ) && $instance['autoplay'] == 'yes';
			$direction          = ! empty( $instance['direction'] ) ? $instance['direction'] : 'horizontal';
			$pagination         = isset( $instance['pagination'] ) && $instance['pagination'] == 'yes';
			$pagination_style   = isset( $instance['pagination_style'] ) ? $instance['pagination_style'] : 'round';
			$show_name          = isset( $instance['show_name'] ) && $instance['show_name'] == 'yes';
			$show_rating        = isset( $instance['show_rating'] ) && $instance['show_rating'] == 'yes';
			$autosense_category = isset( $instance['autosense_category'] ) && $instance['autosense_category'] == 'yes';
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$style              = ! empty( $instance['style'] ) ? $instance['style'] : 'default';

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_name' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_name' ); ?>" name="<?php echo $this->get_field_name( 'show_name' ); ?>" type="checkbox" value="yes" <?php checked( $show_name ) ?>>
					<?php _e( 'Show name', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Show brand name for each element of the carousel', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_rating' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_rating' ); ?>" name="<?php echo $this->get_field_name( 'show_rating' ); ?>" type="checkbox" value="yes" <?php checked( $show_rating ) ?>>
					<?php _e( 'Show rating', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Show brand rate for each element of the carousel (brand rate is calculated as average rating for products of the same brand)', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" type="checkbox" value="yes" <?php checked( $hide_empty ) ?>>
					<?php _e( 'Hide empty', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Hide brands without products associated', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'hide_no_image' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'hide_no_image' ); ?>" name="<?php echo $this->get_field_name( 'hide_no_image' ); ?>" type="checkbox" value="yes" <?php checked( $hide_no_image ) ?>>
					<?php _e( 'Hide term without images', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Hide brands with no associated images', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" type="checkbox" value="yes" <?php checked( $autoplay ) ?>>
					<?php _e( 'Autoplay', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Autoplay carousel slides', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'autosense_category' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'autosense_category' ); ?>" name="<?php echo $this->get_field_name( 'autosense_category' ); ?>" type="checkbox" value="yes" <?php checked( $autosense_category ) ?>>
					<?php _e( 'Autosense category', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'On product category page, ignore category option and filter brands for current category', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo esc_attr( $category ) ?>"/>
				<small><?php _e( 'Comma separated list of valid product category slugs, to filter brands; leave it empty if you don\'t want to filter brands by category', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'direction' ); ?>"><?php _e( 'Direction:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'direction' ); ?>" name="<?php echo $this->get_field_name( 'direction' ); ?>">
					<option value="horizontal" <?php selected( $direction, 'horizontal' ) ?> ><?php _e( 'Horizontal', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="vertical" <?php selected( $direction, 'vertical' ) ?> ><?php _e( 'Vertical', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
				<small><?php _e( 'Select sliding direction in carousel', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'pagination' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'pagination' ); ?>" name="<?php echo $this->get_field_name( 'pagination' ); ?>" type="checkbox" value="yes" <?php checked( $pagination ) ?>>
					<?php _e( 'Show carousel pagination', 'yith-woocommerce-brands-add-on' ); ?><br/>
				</label>
				<small><?php _e( 'Show pagination for the carousel', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'pagination_style' ); ?>"><?php _e( 'Carousel pagination style:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'pagination_style' ); ?>" name="<?php echo $this->get_field_name( 'pagination_style' ); ?>">
					<option value="round" <?php selected( $pagination_style, 'round' ) ?> ><?php _e( 'Round', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="square" <?php selected( $pagination_style, 'square' ) ?> ><?php _e( 'Square', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
				<small><?php _e( 'Carousel pagination style', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
					<option value="default" <?php selected( $style, 'default' ) ?> ><?php _e( 'Default', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="top-border" <?php selected( $style, 'top-border' ) ?> ><?php _e( 'Top border', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="shadow" <?php selected( $style, 'shadow' ) ?> ><?php _e( 'Shadow', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="centered-title" <?php selected( $style, 'centered-title' ) ?> ><?php _e( 'Centered title', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="boxed" <?php selected( $style, 'boxed' ) ?> ><?php _e( 'Boxed', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="squared" <?php selected( $style, 'squared' ) ?> ><?php _e( 'Squared', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="background" <?php selected( $style, 'background' ) ?> ><?php _e( 'Background', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
			</p>
			<script>
				jQuery(document).ready(function ($) {
					var pagination = $('#<?php echo $this->get_field_id( 'pagination' ); ?>'),
						pagination_style = $('#<?php echo $this->get_field_id( 'pagination_style' ); ?>');

					pagination.on('change', function () {
						var t = $(this);

						if (t.is(':checked')) {
							pagination_style.parents('p').show();
						} else {
							pagination_style.parents('p').hide();
						}
					}).change();
				});
			</script>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 * @see   WP_Widget::update()
		 *
		 * @since 1.0.0
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                       = array();
			$instance['title']              = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['hide_no_image']      = isset( $new_instance['hide_no_image'] ) ? 'yes' : 'no';
			$instance['autoplay']           = isset( $new_instance['autoplay'] ) ? 'yes' : 'no';
			$instance['direction']          = ! empty( $new_instance['direction'] ) && in_array( $new_instance['direction'], array(
				'horizontal',
				'vertical'
			) ) ? $new_instance['direction'] : 'horizontal';
			$instance['pagination']         = isset( $new_instance['pagination'] ) ? 'yes' : 'no';
			$instance['pagination_style']   = ! empty( $new_instance['pagination_style'] ) && in_array( $new_instance['pagination_style'], array(
				'round',
				'square'
			) ) ? $new_instance['pagination_style'] : 'round';
			$instance['show_name']          = isset( $new_instance['show_name'] ) ? 'yes' : 'no';
			$instance['show_rating']        = isset( $new_instance['show_rating'] ) ? 'yes' : 'no';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['style']              = ! empty( $new_instance['style'] ) && in_array( $new_instance['style'], array(
				'default',
				'top-border',
				'shadow',
				'centered-title',
				'boxed',
				'squared',
				'background'
			) ) ? $new_instance['style'] : 'default';

			return $instance;
		}
	}
}