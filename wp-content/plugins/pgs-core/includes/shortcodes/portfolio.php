<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_portfolio
 *
 ******************************************************************************/
function pgscore_shortcode_portfolio( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                   => 'style-1',
		'portfolio_per_page'      => '',
		'portfolio_type'          => 'isotope',
		'portfolio_space'         => '10',
		'carousel_items_xl'       => '2',
		'carousel_items_lg'       => '2',
		'carousel_items_md'       => '1',
		'carousel_items_sm'       => '1',
		'portfolio_column'        => '3',
		'portfolio_show_category' => '',
		'categories'              => '',
		'oredr_by'                => 'title',
		'sort_by'                 => 'ASC',
		'element_css'             => '',
		'element_id'              => '',
		'element_class'           => '',
		'shortcode_handle'        => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args  = array(
		'post_type'           => 'portfolio',
		'posts_per_page'      => ( ! empty( $portfolio_per_page ) && is_numeric( $portfolio_per_page ) && 'isotope' !== $portfolio_type ) ? $portfolio_per_page : -1,
		'orderby'             => ( isset( $oredr_by ) ) ? $oredr_by : 'publish_date',
		'order'               => ( isset( $sort_by ) ) ? $sort_by : 'ASC',
		'post_status'         => array( 'publish' ),
		'ignore_sticky_posts' => true,
	);

	if ( ! empty( $categories ) ) {
		$categories_array = explode( ',', $categories );
		if ( is_array( $categories_array ) && ! empty( $categories_array ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio-category',
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

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']      = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['the_query'] = $the_query;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'portfolio/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {

	$portfolio_categories = pgscore_get_terms(
		array( // You can pass arguments from get_terms (except hide_empty)
			'taxonomy'   => 'portfolio-category',
			'pad_counts' => true,
		)
	);

	$shortcode_fields = array(
		array(
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'style',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'description' => esc_html__( 'Select style.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => PGSCORE_URL . 'images/shortcodes/portfolio/style1.jpg',
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/portfolio/style2.jpg',
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 3',
					'image' => PGSCORE_URL . 'images/shortcodes/portfolio/style3.jpg',
				),
				array(
					'value' => 'style-4',
					'title' => 'Style 4',
					'image' => PGSCORE_URL . 'images/shortcodes/portfolio/style4.jpg',
				),
				array(
					'value' => 'style-5',
					'title' => 'Style 5',
					'image' => PGSCORE_URL . 'images/shortcodes/portfolio/style5.jpg',
				),
			),
			'save_always' => true,
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'portfolio_type',
			'heading'    => esc_html__( 'Portfolio Type', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'isotope'  => esc_html__( 'Isotope', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
				)
			),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Number Of Portfolio', 'pgs-core' ),
			'param_name'  => 'portfolio_per_page',
			'min'         => 10,
			'max'         => 100,
			'value'       => 20,
			'description' => esc_html__( 'Add number of portfolio to display', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => array( 'carousel', 'grid' ),
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'categories',
			'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			'value'       => $portfolio_categories,
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => 'isotope',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
			'param_name'  => 'carousel_items_xl',
			'std'         => '3',
			'value'       => array_flip(
				array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Large &ge;992px', 'pgs-core' ),
			'param_name'  => 'carousel_items_lg',
			'value'       => array_flip(
				array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'std'         => '3',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Medium &ge;768px', 'pgs-core' ),
			'param_name'  => 'carousel_items_md',
			'value'       => array_flip(
				array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'         => '2',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Small &ge;576px', 'pgs-core' ),
			'param_name'  => 'carousel_items_sm',
			'value'       => array_flip(
				array(
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'         => '1',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Portfolio Column Size', 'pgs-core' ),
			'param_name'  => 'portfolio_column',
			'std'         => '3',
			'value'       => array_flip(
				array(
					'6' => '6',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'portfolio_type',
				'value'   => array( 'isotope', 'grid' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Space between Portfolio', 'pgs-core' ),
			'param_name'  => 'portfolio_space',
			'value'       => array_flip(
				array(
					'0'  => '0',
					'5'  => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
				)
			),
			'std'         => '10',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'oredr_by',
			'heading'    => esc_html__( 'Order By', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'title'        => esc_html__( 'Title', 'pgs-core' ),
					'publish_date' => esc_html__( 'Date', 'pgs-core' ),
					'modified'     => esc_html__( 'Modified', 'pgs-core' ),
					'ID'           => esc_html__( 'ID', 'pgs-core' ),
				)
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'sort_by',
			'heading'    => esc_html__( 'Sort By', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'ASC'  => esc_html__( 'ASC', 'pgs-core' ),
					'DESC' => esc_html__( 'DESC', 'pgs-core' ),
				)
			),
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
		'name'                    => esc_html__( 'Portfolio', 'pgs-core' ),
		'description'             => esc_html__( 'Add Portfolio.', 'pgs-core' ),
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
