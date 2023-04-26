<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

if ( ! function_exists( 'WC' ) ) {
	return;
}

/*
 * Shortcode : pgscore_single_product_slider
 */
function pgscore_shortcode_single_product_slider( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'            => 'style_1',
		'custom_title'     => '',
		'custom_content'   => '',
		'pro_cat_slug'     => '',
		'number_of_item'   => 3,
		'product_type'     => '',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$args = array(
		'post_type'      => 'product',
		'posts_status'   => 'publish',
		'posts_per_page' => esc_html( $number_of_item ),
	);

	if ( $pro_cat_slug != '' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => explode( ',', $pro_cat_slug ),
			),
		);
	}

	$product_type = esc_html( $product_type );

	/* Featured product */
	if ( 'featured' === $product_type ) {
		$args['meta_query'] = array(
			array(
				'key'     => '_featured',
				'value'   => 'yes',
				'compare' => '=',
			),
		);

		/* On Sale product */
	} elseif ( 'on_sale' === $product_type ) {
		$args['meta_query'] = array(
			array(
				'key'     => '_sale_price',
				'value'   => '',
				'compare' => '!=',
			),
		);

		/* Best Sellers Product */
	} elseif ( 'best_sellers' === $product_type ) {
		unset( $args['meta_query'] );
		$args['meta_key']       = 'total_sales';
		$args['meta_value_num'] = 'total_sales';
		$args['orderby']        = 'meta_value_num';
		$args['order']          = 'DESC';

		/* Cheapest Product */
	} elseif ( 'cheapest' === $product_type ) {
		unset( $args['meta_query'] );
		$args['meta_key']       = '_price';
		$args['meta_value_num'] = '_price';
		$args['orderby']        = 'meta_value_num';
		$args['order']          = 'ASC';
	}
	$loop = new WP_Query( $args );

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['loop'] = $loop;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'single_product_slider/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {

	/*
	 * Visual Composer Integration
	 */
	$categories_hierarchy = get_terms_hierarchy( 'product_cat' );
	$categories_flat      = get_terms_hierarchical_list( $categories_hierarchy );
	$categories_list      = array();
	foreach ( $categories_flat as $term_id => $term ) {
		$categories_list[ $term->name . ' (' . $term->count . ')' ] = $term_id;
	}
	$shortcode_fields = array(
		array(
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'options'     => array(
				array(
					'value' => 'style_1',
					'title' => 'Style 1',
					'image' => PGSCORE_URL . '/images/shortcodes/single_product_slider/style1.png',
				),
				array(
					'value' => 'style_2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . '/images/shortcodes/single_product_slider/style2.png',
				),
				array(
					'value' => 'style_3',
					'title' => 'Style 3',
					'image' => PGSCORE_URL . '/images/shortcodes/single_product_slider/style3.png',
				),
			),
			'description' => esc_html__( 'Select style.', 'pgs-core' ),
			'std'         => 'style_1',
			'show_label'  => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'param_name'  => 'custom_title',
			'dependency'  => array(
				'element' => 'style',
				'value'   => array( 'style_1', 'style_3' ),
			),
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Content', 'pgs-core' ),
			'param_name' => 'custom_content',
			'dependency' => array(
				'element' => 'style',
				'value'   => array( 'style_1', 'style_3' ),
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Select category', 'pgs-core' ),
			'param_name'  => 'pro_cat_slug',
			'value'       => $categories_list,
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Product Type', 'pgs-core' ),
			'param_name'  => 'product_type',
			'value'       => array(
				esc_html__( 'Newest', 'pgs-core' )       => 'newest',
				esc_html__( 'Featured', 'pgs-core' )     => 'featured',
				esc_html__( 'Best Sellers', 'pgs-core' ) => 'best_sellers',
				esc_html__( 'On sale', 'pgs-core' )      => 'on_sale',
				esc_html__( 'Cheapest', 'pgs-core' )     => 'cheapest',
			),
			'save_always' => true,
			'description' => esc_html__( 'Select product type. which type of product want to display on front page', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Number of Item', 'pgs-core' ),
			'param_name'       => 'number_of_item',
			'min'              => 3,
			'max'              => 10,
			'value'            => 3,
			'description'      => esc_html__( 'Enter number of items to display on front.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-4',
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
		'name'                    => esc_html__( 'Single Product Slider', 'pgs-core' ),
		'description'             => esc_html__( 'Display product slider with one product at a time.', 'pgs-core' ),
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
