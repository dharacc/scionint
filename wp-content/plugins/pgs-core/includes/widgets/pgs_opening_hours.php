<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Opening Hours widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends opening widget
 */
class PGS_opening_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'PGS_opening_widget', // Base ID.
			esc_html__( 'PGS Opening Hours', 'pgs-core' ), // Name.
			array( 'description' => esc_html__( 'A Opening Hours Widget', 'pgs-core' ) ) // Args.
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

		$title = isset( $instance['title'] ) && ! empty( $instance['title'] ) ? $instance['title'] : '';

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

		$allowed_tags = wp_kses_allowed_html( 'post' );

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		?>
		<div class="pgs-opening-hours">
			<?php
			$ciyashop_opening_hours = ciyashop_opening_hours();

			if ( ! empty( $ciyashop_opening_hours ) ) {
				?>
				<ul>
					<?php
					foreach ( $ciyashop_opening_hours as $ciyashop_opening_hour => $ciyashop_opening_hour_val ) {
						if ( ! empty( $ciyashop_opening_hour_val ) ) {
							?>
							<li>
								<i class="fa fa-clock-o"></i><span><?php echo esc_html( $ciyashop_opening_hour ); ?></span>
								<label><?php echo wp_kses( $ciyashop_opening_hour_val, array( 'a' => $allowed_tags['a'] ) ); ?></label>
							</li>
							<?php
						}
					}
					?>
				</ul>
				<?php
			}
			?>
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

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pgs-core' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
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

		$allowed_tags = wp_kses_allowed_html( 'post' );

		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		return $instance;
	}

} // class PGS_opening-hours_widget
