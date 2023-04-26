<?php
/**
 * Brands Filter Widget
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

if ( ! class_exists( 'YITH_WCBR_Brand_Filter_Widget' ) ) {
	/**
	 * WooCommerce Brands FIlter Widget
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Brand_Filter_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @return \YITH_WCBR_Brand_Filter_Widget
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				'yith_wcbr_brands_filter',
				__( 'YITH Brand Filter', 'yith-woocommerce-brands-add-on' ),
				array(
					'description' => __( 'Add an A-Z filter for brands', 'yith-woocommerce-brands-add-on' )
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
			$shortcode_atts        = shortcode_atts( apply_filters( 'yith_wcbr_brand_filter_widget_atts', array(
				'autosense_category' => 'no',
				// yes - no (if yes, on product category page, ignores "category" options, and shows only brands for current category)
				'category'           => 'all',
				// all - a list of comma separated valid category slug
				'show_filter'        => 'yes',
				// yes - no
				'show_reset'         => 'yes',
				// yes - no
				'show_all_letters'   => 'yes',
				// yes - no
				'show_count'         => 'yes',
				// yes - no
				'hide_empty'         => 'no',
				// yes - no
				'style'              => 'default',
				// default - big-header - small-header - shadow - box - highlight
				'highlight_color'    => '#ffd900'
				// hex color code (only for highlight style)
			) ), $instance );

			foreach ( $shortcode_atts as $key => $value ) {
				$shortcode_atts_string .= $key . '="' . $value . '" ';
			}

			echo $args['before_widget'];
			echo $title;
			echo do_shortcode( "[yith_wcbr_brand_filter  $shortcode_atts_string]" );
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
			$show_filter        = isset( $instance['show_filter'] ) && $instance['show_filter'] == 'yes';
			$show_reset         = isset( $instance['show_reset'] ) && $instance['show_reset'] == 'yes';
			$show_all_letters   = isset( $instance['show_all_letters'] ) && $instance['show_all_letters'] == 'yes';
			$show_count         = isset( $instance['show_count'] ) && $instance['show_count'] == 'yes';
			$hide_empty         = isset( $instance['hide_empty'] ) && $instance['hide_empty'] == 'yes';
			$autosense_category = isset( $instance['autosense_category'] ) && $instance['autosense_category'] == 'yes';
			$category           = ! empty( $instance['category'] ) ? $instance['category'] : '';
			$style              = ! empty( $instance['style'] ) ? $instance['style'] : 'default';
			$highlight_color    = ! empty( $instance['highlight_color'] ) ? $instance['highlight_color'] : '#ffd900';

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_filter' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_filter' ); ?>" name="<?php echo $this->get_field_name( 'show_filter' ); ?>" type="checkbox" value="yes" <?php checked( $show_filter ) ?>>
					<?php _e( 'Show filters', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Show letter filter', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_reset' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_reset' ); ?>" name="<?php echo $this->get_field_name( 'show_reset' ); ?>" type="checkbox" value="yes" <?php checked( $show_reset ) ?>>
					<?php _e( 'Show reset:', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'Display "Show all" button within letter filter', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'show_all_letters' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'show_all_letters' ); ?>" name="<?php echo $this->get_field_name( 'show_all_letters' ); ?>" type="checkbox" value="yes" <?php checked( $show_all_letters ) ?>>
					<?php _e( 'Show all letters', 'yith-woocommerce-brands-add-on' ); ?>
				</label><br/>
				<small><?php _e( 'When filters are activated, show all letters instead of showing only those of brands available', 'yith-woocommerce-brands-add-on' ) ?></small>
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
				<label for="<?php echo $this->get_field_id( 'autosense_category' ); ?>">
					<input class="widefat" id="<?php echo $this->get_field_id( 'autosense_category' ); ?>" name="<?php echo $this->get_field_name( 'autosense_category' ); ?>" type="checkbox" value="yes" <?php checked( $autosense_category ) ?>>
					<?php _e( 'Autosense category', 'yith-woocommerce-brands-add-on' ); ?>
				</label>
				<small><?php _e( 'On product category page, ignore category option and filter brands for current category', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:' ); ?></label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo esc_attr( $category ) ?>"/>
				<small><?php _e( 'Comma separated list of valid product category slugs, to filter brands; leave empty if you don\'t want to filter brands by category', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Style:' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
					<option value="default" <?php selected( $style, 'default' ) ?> ><?php _e( 'Default', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="big-header" <?php selected( $style, 'big-header' ) ?> ><?php _e( 'Big Header', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="small-header" <?php selected( $style, 'small-header' ) ?> ><?php _e( 'Small Header', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="shadow" <?php selected( $style, 'shadow' ) ?> ><?php _e( 'Shadow', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="boxed" <?php selected( $style, 'boxed' ) ?> ><?php _e( 'Boxed', 'yith-woocommerce-brands-add-on' ) ?></option>
					<option value="highlight" <?php selected( $style, 'highlight' ) ?> ><?php _e( 'Highlight', 'yith-woocommerce-brands-add-on' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'highlight_color' ); ?>"><?php _e( 'Highlight:', 'yith-woocommerce-brands-add-on' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'highlight_color' ); ?>" name="<?php echo $this->get_field_name( 'highlight_color' ); ?>" type="text" value="<?php echo esc_attr( $highlight_color ); ?>">
				<small><?php _e( 'Valid hex color code, to use as background in highlight style', 'yith-woocommerce-brands-add-on' ) ?></small>
			</p>
			<script>
				jQuery(document).ready(function ($) {
					var show_filter = $('#<?php echo $this->get_field_id( 'show_filter' ); ?>'),
						show_reset = $('#<?php echo $this->get_field_id( 'show_reset' ); ?>'),
						show_all_letters = $('#<?php echo $this->get_field_id( 'show_all_letters' ); ?>'),
						style = $('#<?php echo $this->get_field_id( 'style' ); ?>'),
						highlight_color = $('#<?php echo $this->get_field_id( 'highlight_color' ); ?>');

					show_filter.on('change', function () {
						var t = $(this);

						if (t.is(':checked')) {
							show_reset.parents('p').show();
							show_all_letters.parents('p').show();
						} else {
							show_reset.parents('p').hide();
							show_all_letters.parents('p').hide();
						}
					}).change();

					style.on('change', function () {
						var t = $(this),
							val = t.val();

						if (val == 'highlight') {
							highlight_color.parents('p').show();
						} else {
							highlight_color.parents('p').hide();
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
			$instance['show_filter']        = isset( $new_instance['show_filter'] ) ? 'yes' : 'no';
			$instance['show_reset']         = isset( $new_instance['show_reset'] ) ? 'yes' : 'no';
			$instance['show_all_letters']   = isset( $new_instance['show_all_letters'] ) ? 'yes' : 'no';
			$instance['show_count']         = isset( $new_instance['show_count'] ) ? 'yes' : 'no';
			$instance['hide_empty']         = isset( $new_instance['hide_empty'] ) ? 'yes' : 'no';
			$instance['autosense_category'] = isset( $new_instance['autosense_category'] ) ? 'yes' : 'no';
			$instance['category']           = ! empty( $new_instance['category'] ) ? $new_instance['category'] : '';
			$instance['style']              = ! empty( $new_instance['style'] ) && in_array( $new_instance['style'], array(
				'default',
				'big-header',
				'small-header',
				'shadow',
				'boxed',
				'highlight'
			) ) ? $new_instance['style'] : 'default';
			$instance['highlight_color']    = ! empty( $new_instance['highlight_color'] ) ? strip_tags( $new_instance['highlight_color'] ) : '';

			return $instance;
		}
	}
}