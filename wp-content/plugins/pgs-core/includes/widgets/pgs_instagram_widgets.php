<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Instagram widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends Instagram Widget
 */
class PGS_Instagram_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'PGS_Instagram_Widget', // Base ID.
			esc_html__( 'PGS Instagram', 'pgs-core' ), // Name.
			array( 'description' => esc_html__( 'A Instagram Sidebar Widget', 'pgs-core' ) ) // Args.
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

		$username    = $instance['username'];
		$num_of_item = $instance['num_of_item'];

		$images = ciyashop_scrape_instagram( $username, $num_of_item );

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}

		if ( ! empty( $images ) ) {
			?>
			<div class="pgs_instgram_widget">
				<?php
				foreach ( $images as $image ) {
					if ( is_array( $image ) && isset( $image['link'] ) && isset( $image['thumbnail'] ) ) {
						?>
						<div class="instgram_item">
							<a href="<?php echo esc_url( $image['link'] ); ?>" class="pgs_instgram_widget--link" target="_blank">
								<div class="pgs_instgram_widget--content">
									<?php
									if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
										echo '<img class="pgs_instgram_widget--img ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $image['thumbnail'] ) . '" alt="' . esc_attr__( 'Instagram Image', 'pgs-core' ) . '">';
									} else {
										echo '<img class="pgs_instgram_widget--img" src="' . esc_url( $image['thumbnail'] ) . '" alt="' . esc_attr__( 'Instagram Image', 'pgs-core' ) . '">';
									}
									?>
								</div>
							</a>
						</div>
						<?php
					}
				}
				?>
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
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$username    = ! empty( $instance['username'] ) ? $instance['username'] : '';
		$num_of_item = ! empty( $instance['num_of_item'] ) ? $instance['num_of_item'] : 6;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'title:', 'pgs-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username:', 'pgs-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Enter Instagram username or #hashtag.', 'pgs-core' ); ?></label>
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
		$instance['username']    = ( ! empty( $new_instance['username'] ) ) ? wp_strip_all_tags( $new_instance['username'] ) : '';
		$instance['num_of_item'] = wp_strip_all_tags( $new_instance['num_of_item'] );
		return $instance;
	}
} // class PGS_Instagram_Widget
