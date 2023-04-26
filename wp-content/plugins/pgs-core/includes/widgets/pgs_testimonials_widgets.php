<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Testimonials widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
/**
 * Extends Testimonials Widget
 */
class PGS_Testimonials_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'PGS_Testimonials_Widget', // Base ID.
			esc_html__( 'PGS Testimonials', 'pgs-core' ), // Name.
			array( 'description' => esc_html__( 'A Testimonials Sidebar Widget', 'pgs-core' ) ) // Args.
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

		$num_of_item = $instance['num_of_item'];

		$pargs     = array(
			'post_type'      => 'testimonials',
			'posts_per_page' => $num_of_item,
		);
		$the_query = new WP_Query( $pargs );

		// The Loop.
		if ( $the_query->have_posts() ) {

			$allowed_tags = wp_kses_allowed_html( 'post' );

			echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}

			$owl_options_args = array(
				'items'              => 1,
				'loop'               => true,
				'margin'             => 20,
				'autoplay'           => true,
				'autoplayTimeout'    => 2500,
				'autoplayHoverPause' => true,
				'dots'               => true,
				'nav'                => false,
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
			<div class="testimonials owl-carousel owl-carousel-options" data-owl_options="<?php echo esc_attr( $owl_options ); ?>">
				<?php
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$post_id      = get_the_ID();
					$img_thumb    = '';
					$author_image = '';
					if ( has_post_thumbnail() ) {
						if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] ) {
							$img_thumb = '<img class="owl-lazy img-fluid" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
						} else {
							$img_thumb = '<img class="img-fluid" src="' . esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
						}
					}

					$author              = get_post_meta( $post_id, 'author', true );
					$designation         = get_post_meta( $post_id, 'designation', true );
					$testimonial_content = get_post_meta( $post_id, 'content', true );

					if ( ! empty( $testimonial_content ) ) {
						?>
						<div class="item">
							<div class="client-avarta">
								<?php echo wp_kses( $img_thumb, array( 'img' => array_merge( $allowed_tags['img'], array( 'data-src' => true ) ) ) ); ?>
							</div>
							<div class="info">
								<?php
								$testimonial_author      = ! empty( $author ) ? $author : get_the_title();
								$testimonial_designation = ! empty( $designation ) ? ', ' . $designation : '';
								$lnth                    = strlen( $testimonial_content );

								if ( $lnth > 200 ) {
									$testimonial_ln      = substr( wp_strip_all_tags( $testimonial_content ), 0, 200 );
									$testimonial_content = $testimonial_ln . ' ...';
								}
								?>
								<div class="text-center">
									<?php echo wp_kses( $testimonial_content, array( 'span' => $allowed_tags['span'] ) ); ?>
								</div>
								<?php
								if ( ! empty( $testimonial_author ) ) {
									?>
									<h5><?php echo esc_html( $testimonial_author . $testimonial_designation ); ?></h5>
									<?php
								}
								?>
							</div>
						</div>
						<?php
					}
				}

				/* Restore original Post Data */
				wp_reset_postdata();
				?>
			</div>
			<?php

			echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}
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
		$num_of_item = ! empty( $instance['num_of_item'] ) ? $instance['num_of_item'] : 5;
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
} // class PGS_Testimonials_Widget
