<?php
/**
 * Brands Select Widget
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

if ( ! class_exists( 'YITH_WCBR_Brand_Select_Widget' ) ) {
	/**
	 * WooCommerce Brands Select Widget
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Select_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @return \YITH_WCBR_Brand_Select_Widget
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_select',
				__( 'YITH Brand Select', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Add a select with all brands', 'yith-woocommerce-brands-add-on' )
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
			$shortcode_atts        = shortcode_atts( array(
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'show_count'         => 'yes',
				// yes - no
				'hide_empty'         => 'no',
				// yes - no
				'brand'              => 'all',
				// brands slug to include
				'parent'             => '',
				// parent to match for terms (term id)
				'orderby'            => 'none',
				// terms ordering name - slug - term_group - term_id - id - description
				'order'              => 'ASC'
				// order ascending or descending
			), $instance );

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget'];
			echo $title;
			echo do_shortcode( "[yith_wcbr_brand_select $shortcode_atts_string]" );
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
			$autosense_category = isset( $instance['autosense_category'] ) && $instance['autosense_category'] == 'yes';
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$show_count         = isset( $instance['show_count'] ) && $instance['show_count'] == 'yes';
			$hide_empty         = isset( $instance['hide_empty'] ) && $instance['hide_empty'] == 'yes';
			$brand              = isset( $instance['brand'] ) ? $instance['brand'] : '';
			$parent             = isset( $instance['parent'] ) ? $instance['parent'] : '';
			$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order              = isset( $instance['order'] ) ? $instance['order'] : '';

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
				<label for="<?php echo $this->get_field_id( 'brand' ); ?>"><?php _e( 'Brand:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'brand' ); ?>" name="<?php echo $this->get_field_name( 'brand' ); ?>" value="<?php echo esc_attr( $brand ) ?>"/>
				<small><?php _e( 'Comma separated list of valid product brand IDs, to show in the widget; leave it empty if you want to retrieve all the brands', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'parent' ); ?>"><?php _e( 'Parent:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'parent' ); ?>" name="<?php echo $this->get_field_name( 'parent' ); ?>" value="<?php echo esc_attr( $parent ) ?>"/>
				<small><?php _e( 'ID for the parent brand to use in term query; leave it empty if you want to retrieve all the brands', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" type="checkbox" value="yes" <?php checked( $show_count ) ?>>
					<?php _e( 'Show count', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Show number of products for each brand', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'hide_empty' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'hide_empty' ); ?>" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" type="checkbox" value="yes" <?php checked( $hide_empty ) ?>>
					<?php _e( 'Hide empty', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Hide brands without products associated', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order by:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
					<option value="none" <?php selected( empty( $orderby ) || $orderby == 'none' ) ?> ><?php _e( 'Default', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="name" <?php selected( $orderby, 'name' ) ?> ><?php _e( 'Term name', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="slug" <?php selected( $orderby, 'slug' ) ?> ><?php _e( 'Term slug', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="term_group" <?php selected( $orderby, 'term_group' ) ?> ><?php _e( 'Term group', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="term_id" <?php selected( $orderby, 'term_id' ) ?> ><?php _e( 'Term ID', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="description" <?php selected( $orderby, 'description' ) ?> ><?php _e( 'Term description', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<option value="ASC" <?php selected( empty( $order ) || $order == 'ASC' ) ?> ><?php _e( 'Ascending', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="DESC" <?php selected( $order, 'DESC' ) ?> ><?php _e( 'Descending', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
			</p>
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
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['show_count']         = isset( $new_instance['show_count'] ) ? 'yes' : 'no';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['brand']              = ! empty( $new_instance['brand'] ) ? $new_instance['brand'] : '';
			$instance['parent']             = ! empty( $new_instance['parent'] ) ? $new_instance['parent'] : '';
			$instance['orderby']            = in_array( $new_instance['orderby'], array(
				'none',
				'name',
				'slug',
				'term_group',
				'term_id',
				'description'
			) ) ? $new_instance['orderby'] : 'none';
			$instance['order']              = in_array( $new_instance['order'], array(
				'ASC',
				'DESC'
			) ) ? $new_instance['order'] : 'ASC';

			return $instance;
		}
	}
}