<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Social Widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends social widget
 */
class PGS_social_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$widget_ops  = array(
			'classname'                   => 'widget_pgs_social_profiles',
			'description'                 => esc_html__( 'Social profiles.', 'pgs-core' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);
		parent::__construct(
			'social_profiles', // Base ID.
			esc_html__( 'PGS Social', 'pgs-core' ),      // Name.
			$widget_ops,
			$control_ops
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
		$style = isset( $instance['style'] ) && ! empty( $instance['style'] ) ? $instance['style'] : 'default';
		$shape = isset( $instance['shape'] ) && ! empty( $instance['shape'] ) ? $instance['shape'] : 'square';

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

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		$widget_content = ! empty( $instance['content'] ) ? $instance['content'] : '';

		$ciyashop_social_profiles = ciyashop_social_profiles();

		$social_profile_classes[] = 'social-profiles-wrapper-inner';
		$social_profile_classes[] = 'social-profiles-' . $style;
		$social_profile_classes[] = 'social-profiles-shape-' . $shape;

		$social_profile_classes = implode( ' ', array_filter( array_unique( $social_profile_classes ) ) );
		?>
		<div class="social-profiles-wrapper">
			<div class="<?php echo esc_attr( $social_profile_classes ); ?>">
				<?php
				if ( ! empty( $widget_content ) ) {
					?>
					<p><?php echo wp_kses( $widget_content, array( 'br' => array() ) ); ?></p>
					<?php
				}
				if ( ! empty( $ciyashop_social_profiles ) && is_array( $ciyashop_social_profiles ) ) {
					?>
					<div class="social-profiles">
						<ul>
							<?php
							foreach ( $ciyashop_social_profiles as $ciyashop_social_profile ) {
								?>
								<li><a href="<?php echo esc_url( $ciyashop_social_profile['link'] ); ?>" title="<?php echo esc_attr( $ciyashop_social_profile['title'] ); ?>" target="_blank"><?php echo wp_kses( $ciyashop_social_profile['icon'], ciyashop_allowed_html( array( 'i' ) ) ); ?></a></li>
								<?php
							}
							?>
						</ul>
					</div>
					<?php
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
		$title   = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$content = ! empty( $instance['content'] ) ? $instance['content'] : '';
		$style   = ! empty( $instance['style'] ) ? $instance['style'] : 'square';
		$shape   = ! empty( $instance['shape'] ) ? $instance['shape'] : 'default';
		?>
		<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'pgs-core' ); ?></label> 
<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'Content:', 'pgs-core' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"  name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>"><?php echo esc_html( $content ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_html_e( 'style:', 'pgs-core' ); ?></label> 
			<select id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" class="widefat">
				<option <?php selected( $style, 'default' ); ?> value="default"><?php esc_html_e( 'Default', 'pgs-core' ); ?></option>
				<option <?php selected( $style, 'colored' ); ?> value="colored"><?php esc_html_e( 'Colored', 'pgs-core' ); ?></option> 
				<option <?php selected( $style, 'dark-flat' ); ?> value="dark-flat"><?php esc_html_e( 'Dark Flat', 'pgs-core' ); ?></option>
				<option <?php selected( $style, 'light-flat' ); ?> value="light-flat"><?php esc_html_e( 'Light Flat', 'pgs-core' ); ?></option>
				<option <?php selected( $style, 'dark-border' ); ?> value="dark-border"><?php esc_html_e( 'Dark Border', 'pgs-core' ); ?></option>
				<option <?php selected( $style, 'light-border' ); ?> value="light-border"><?php esc_html_e( 'Light Border', 'pgs-core' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>"><?php esc_html_e( 'shape:', 'pgs-core' ); ?></label> 
			<select id="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shape' ) ); ?>" class="widefat">
				<option <?php selected( $shape, 'square' ); ?> value="square"><?php esc_html_e( 'Square', 'pgs-core' ); ?></option>
				<option <?php selected( $shape, 'round' ); ?> value="round"><?php esc_html_e( 'Round', 'pgs-core' ); ?></option>
			</select>
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
		$instance            = array();
		$instance['content'] = wp_strip_all_tags( $new_instance['content'] );
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['style']   = ( ! empty( $new_instance['style'] ) ) ? wp_strip_all_tags( $new_instance['style'] ) : 'square';
		$instance['shape']   = ( ! empty( $new_instance['shape'] ) ) ? wp_strip_all_tags( $new_instance['shape'] ) : 'default';

		return $instance;
	}
}
