<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

// Return if custom post type is not supported
if ( ! current_theme_supports( 'pgs_teams' ) ) {
	return;
}

/*
 * Shortcode : pgscore_team_members
 */
function pgscore_shortcode_team_members( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                   => 'style-1',
		'posts_per_page'          => 10,
		'categories'              => '',
		'show_pagination_control' => 'no',
		'show_prev_next_buttons'  => 'no',
		'element_css'             => '',
		'element_id'              => '',
		'element_class'           => '',
		'shortcode_handle'        => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$args = array(
		'post_type'      => 'teams',
		'posts_per_page' => $atts['posts_per_page'],
	);

	if ( ! empty( $categories ) ) {
		$categories_array = explode( ',', $categories );
		if ( is_array( $categories_array ) && ! empty( $categories_array ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'team-category',
					'field'    => 'term_id',
					'terms'    => $categories_array,
				),
			);
		}
	}

	$the_query = new WP_Query( $args );
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

	$listlist_classes = array();
	$list_classes[]   = 'pgscore_team_member_list';

	if ( $style ) {
		$list_classes[] = 'pgscore_team_members_style_' . esc_attr( $style );
	}
	$list_classes = implode( ' ', array_filter( array_unique( $list_classes ) ) );
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<div class="<?php echo esc_attr( $list_classes ); ?>">
			<?php pgscore_get_shortcode_templates( 'team_members/content', 'carousel' ); ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	/*
	 * Visual Composer Integration
	 */
	$testimonial_categories = pgscore_get_terms(
		array( // You can pass arguments from get_terms (except hide_empty)
			'taxonomy'   => 'team-category',
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
					'title' => 'Style 1',
					'image' => PGSCORE_URL . 'images/shortcodes/team_members/style-1.png',
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/team_members/style-3.png',
				),
			),
			'show_label'  => true,
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Count', 'pgs-core' ),
			'param_name'  => 'posts_per_page',
			'value'       => '',
			'min'         => '1',
			'max'         => '10',
			'description' => esc_html__( 'Enter number of members to display.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'categories',
			'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			'value'       => $testimonial_categories,
			'admin_label' => true,
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Pagination Control', 'pgs-core' ),
			'param_name'       => 'show_pagination_control',
			'description'      => esc_html__( 'Select this checkbox to display pagination controls.', 'pgs-core' ),
			'value'            => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label'      => true,
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
			'param_name'       => 'show_prev_next_buttons',
			'description'      => esc_html__( 'Select this checkbox to display prev/next buttons.', 'pgs-core' ),
			'value'            => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label'      => true,
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
		'name'                    => esc_html__( 'Team Members', 'pgs-core' ),
		'description'             => esc_html__( 'Display team members.', 'pgs-core' ),
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
