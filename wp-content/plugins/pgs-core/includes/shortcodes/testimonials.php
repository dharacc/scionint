<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

if ( ! current_theme_supports( 'pgs_testimonials' ) ) {
	return; // Return if custom post type is not supported
}

/*
 * Shortcode : pgscore_testimonials
 */
function pgscore_shortcode_testimonials( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'style'                  => 'style-1',
		'show_title'             => '',
		'title'                  => '',
		'carousel_speed'         => 2500,
		'show_prev_next_buttons' => false,
		'enable_infinity_loop'   => false,
		'slides_per_view'        => 1,
		'slides_per_view_xx'     => 1,
		'slides_per_view_xs'     => 1,
		'slides_per_view_sm'     => 1,
		'slides_per_view_md'     => 1,
		'slide_margin'           => 30,
		'posts_per_page'         => 4,
		'categories'             => '',
		'element_css'            => '',
		'element_id'             => '',
		'element_class'          => '',
		'shortcode_handle'       => $shortcode_handle,
	);
	$atts         = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$args = array(
		'post_type'           => 'testimonials',
		'posts_per_page'      => ( ! empty( $posts_per_page ) && is_numeric( $posts_per_page ) ) ? $posts_per_page : 3,
		'post_status'         => array( 'publish' ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( $categories ) ) {
		$categories_array = explode( ',', $categories );
		if ( is_array( $categories_array ) && ! empty( $categories_array ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'testimonial-category',
					'field'    => 'term_id',
					'terms'    => $categories_array,
				),
			);
		}
	}
	$the_query = new WP_Query( $args );

	// bail early if no posts found
	if ( ! $the_query->have_posts() ) {
		return;
	}

	/*
	 * Element Classes
	 * For base wrapper
	 */
	$atts['element_classes'] = array();
	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']      = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['the_query'] = $the_query;

	/*
	 * Shortcode Instance Index and Classes
	 */
	if ( isset( $pgscore_shortcodes[ $shortcode_handle ]['index'] ) ) {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = $pgscore_shortcodes[ $shortcode_handle ]['index'] + 1;
	} else {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = 1;
	}
	$pgscore_shortcodes[ $shortcode_handle ]['index_class'] = $shortcode_handle . '-' . $pgscore_shortcodes[ $shortcode_handle ]['index'];
	$atts['element_classes'][]                              = $pgscore_shortcodes[ $shortcode_handle ]['index_class'];
	/*
	 * Shortcode Instance Index and Classes END
	 */
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'testimonials/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	/*
	 * Visual Composer Integration
	 */
	$testimonial_categories = pgscore_get_terms(
		array( // You can pass arguments from get_terms (except hide_empty)
			'taxonomy'   => 'testimonial-category',
			'pad_counts' => true,
		)
	);
	$shortcode_fields       = array(
		array(
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => esc_html__( 'Style 3', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-3.png',
				),
				array(
					'value' => 'style-4',
					'title' => esc_html__( 'Style 4', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-4.png',
				),
				array(
					'value' => 'style-5',
					'title' => esc_html__( 'Style 5', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-5.png',
				),
				array(
					'value' => 'style-6',
					'title' => esc_html__( 'Style 6', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-6.png',
				),
				array(
					'value' => 'style-7',
					'title' => esc_html__( 'Style 7', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/testimonials/style-7.png',
				),
			),
			'value'       => 'style-1',
			'show_label'  => true,
			'admin_label' => true,
		),
		/******************** Slider Settings **********************/
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Carousel Speed', 'pgs-core' ),
			'param_name'  => 'carousel_speed',
			'min'         => 1000,
			'max'         => 10000,
			'value'       => 2500,
			'unit'        => 'ms',
			'description' => esc_html__( 'Enter carousel speed in milliseconds.', 'pgs-core' ),
			'dependency'  => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
			'param_name'       => 'show_prev_next_buttons',
			'description'      => esc_html__( 'Check this checkbox to display prev/next buttons.', 'pgs-core' ),
			'value'            => array( esc_html__( 'Yes', 'pgs-core' ) => 'true' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'admin_label'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Infinity Loop', 'pgs-core' ),
			'param_name'  => 'enable_infinity_loop',
			'description' => esc_html__( 'Check this checkbox to enable infinity loop and display carousel in circular loop.', 'pgs-core' ),
			'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => 'true' ),
			'admin_label' => true,
			'dependency'  => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Slides per view', 'pgs-core' ),
			'param_name'  => 'slides_per_view',
			'value'       => array_flip(
				array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'         => '1',
			'description' => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 1200px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_md',
			'value'            => array_flip(
				array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'              => '1',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'admin_label'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 992px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_sm',
			'value'            => array_flip(
				array(
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'              => '1',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'admin_label'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 768px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_xs',
			'value'            => array_flip(
				array(
					'2' => '2',
					'1' => '1',
				)
			),
			'std'              => '1',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'admin_label'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 480px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_xx',
			'value'            => array_flip(
				array(
					'1' => '1',
				)
			),
			'std'              => '1',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'admin_label'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => array( 'style-1' ),
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Margin', 'pgs-core' ),
			'param_name'  => 'slide_margin',
			'value'       => array_flip(
				array(
					'5'  => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
				)
			),
			'std'         => '30',
			'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element'            => 'slides_per_view',
				'value_not_equal_to' => array( '1' ),
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		/******************** Slider Settings End **********************/
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Count', 'pgs-core' ),
			'param_name'  => 'posts_per_page',
			'value'       => '4',
			'min'         => '1',
			'max'         => '50',
			'description' => wp_kses( __( 'Enter number of testimonial items to display. <br> <strong><span class="ciyashop-red">Note</span> : If you add "less than 0" value in input, then it will take "0" items and if you select "greater than 50" value, then it will set 50 items.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'admin_label' => true,
			'group'       => esc_html__( 'Post Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'categories',
			'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			'value'       => $testimonial_categories,
			'admin_label' => true,
			'group'       => esc_html__( 'Post Settings', 'pgs-core' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'pgs-core' ),
			'param_name' => 'element_css',
			'group'      => esc_html__( 'Design Options', 'pgs-core' ),
		),
		array(
			'type'        => 'el_id',
			'heading'     => esc_html__( 'ID', 'pgs-core' ),
			'param_name'  => 'element_id',
			'description' => sprintf(
				wp_kses(
					__( 'Enter ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>)', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.w3schools.com/tags/att_global_id.asp'
			)
				. '<br><span class="pgs-core-red">' .
				sprintf(
					wp_kses(
						__( 'Important : If ID starts with number, it will be prefixed with "%s".', 'pgs-core' ),
						array(
							'atrong' => true,
						)
					),
					'<strong>' . $shortcode_tag . '_' . '</strong>'
				)
				. '</span>',
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'pgs-core' ),
			'param_name'  => 'element_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pgs-core' ),
			'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
		),
	);
	// Params
	$params = array(
		'name'                    => esc_html__( 'Testimonials', 'pgs-core' ),
		'description'             => esc_html__( 'Display testimonials.', 'pgs-core' ),
		'base'                    => $shortcode_tag,
		'class'                   => 'pgscore_element_wrapper',
		'controls'                => 'full',
		'icon'                    => PGSCORE_URL . '/images/vc-icon.png',
		'category'                => esc_html__( 'Potenza Core', 'pgs-core' ),
		'show_settings_on_create' => true,
		'params'                  => $shortcode_fields,
	);
	vc_map( $params );
}
