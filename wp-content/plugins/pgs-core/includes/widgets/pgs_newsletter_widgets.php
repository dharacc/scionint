<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Newsletter widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends newsletter widget
 */
class PGS_newsletter_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'PGS_newsletter_widget', // Base ID.
			esc_html__( 'PGS Newsletter', 'pgs-core' ), // Name.
			array( 'description' => esc_html__( 'A Newsletter Sidebar Widget', 'pgs-core' ) ) // Args.
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

		$widget_id = str_replace( '-', '_', $args['widget_id'] );
		?>
		<div class="newsletter">
			<?php
			if ( ! empty( $instance['content'] ) ) {
				?>
				<p>
				<?php
				echo wp_kses(
					$instance['content'],
					array(
						'div'  => $allowed_tags['div'],
						'img'  => $allowed_tags['img'],
						'span' => $allowed_tags['span'],
						'ul'   => $allowed_tags['ul'],
						'li'   => $allowed_tags['li'],
						'i'    => $allowed_tags['i'],
					)
				);
				?>
				</p>
				<?php
			}
			?>
			<div class="section-field">
				<div class="field-widget clearfix">
					<form class="newsletter_form" id="<?php echo esc_attr( $widget_id ); ?>">
						<div class="input-area">
							<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Enter your email', 'pgs-core' ); ?>">
						</div>
						<div class="button-area">		
							<span class="input-group-btn">
								<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr( $widget_id ); ?>"><?php esc_html_e( 'Subscribe', 'pgs-core' ); ?></button>
							</span>
							<span class="newsletter-spinner spinimg-<?php echo esc_attr( $widget_id ); ?>"></span>
						</div>
						<p class="newsletter-msg"></p>
					</form>
				</div>
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
		$title   = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$content = ! empty( $instance['content'] ) ? $instance['content'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pgs-core' ); ?></label> 
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Content:', 'pgs-core' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo esc_html( $content ); ?></textarea>
		</p>
		<p><?php esc_html_e( 'MailChimp API key and List ID settings are moved in Theme Options. So, please update settings over there.', 'pgs-core' ); ?></p>
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
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['content'] = wp_strip_all_tags( $new_instance['content'] );
		return $instance;
	}

} // class PGS_newsletter_widget
