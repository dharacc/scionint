<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

if ( ! function_exists( 'WC' ) ) {
	return;
}

/******************************************************************************
 *
 * Shortcode : pgscore_product_showcase
 *
 ******************************************************************************/
function pgscore_shortcode_product_showcase( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'title'            => '',
		'title_el'         => 'h3',
		'product_type'     => 'recently-viewed',
		'number_of_item'   => '6',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$query_args = array(
		'posts_per_page' => $number_of_item,
		'no_found_rows'  => 1,
		'post_status'    => 'publish',
		'post_type'      => 'product',
	);

	if ( 'recently-viewed' === $product_type ) {
		$woocommerce_recently_viewed = ( isset( $_COOKIE['woocommerce_recently_viewed'] ) && $_COOKIE['woocommerce_recently_viewed'] != '' ) ? sanitize_text_field( wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : '';
		$viewed_products             = ! empty( $woocommerce_recently_viewed ) ? (array) explode( '|', $woocommerce_recently_viewed ) : array();
		$viewed_products             = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
		if ( empty( $viewed_products ) ) {
			return;
		}

		$query_args['post__in'] = $viewed_products;
		$query_args['orderby']  = 'post__in';

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'outofstock',
					'operator' => 'NOT IN',
				),
			);
		}
	} elseif ( 'featured-products' === $product_type ) {
		$query_args['meta_query'] = WC()->query->get_meta_query();
		$query_args['tax_query']  = WC()->query->get_tax_query();
		$tax_query[]              = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'featured',
			'operator' => 'IN',
		);
		$query_args['tax_query']  = $tax_query;
	} elseif ( 'products-in-sale' === $product_type ) {
		$query_args['meta_key']     = '_sale_price';
		$query_args['meta_value']   = '0';
		$query_args['meta_compare'] = '>=';
	} elseif ( 'top-rated-products' === $product_type ) {
		$query_args['meta_key']   = '_wc_average_rating';
		$query_args['orderby']    = 'meta_value_num';
		$query_args['order']      = 'DESC';
		$query_args['meta_query'] = WC()->query->get_meta_query();
		$query_args['tax_query']  = WC()->query->get_tax_query();
	}

	$loop = new WP_Query( $query_args );
	if ( ! $loop->have_posts() ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['loop'] = $loop;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'product_showcase/content' ); ?>
	</div>
	<?php
	wp_reset_postdata();
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	$shortcode_fields = array(
		array(
			'type'        => 'textfield',
			'param_name'  => 'title',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter title.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'title_el',
			'heading'     => esc_html__( 'Title Element Tag', 'pgs-core' ),
			'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
			'std'         => 'h3',
			'value'       => array_flip(
				array(
					'h1' => esc_html__( 'H1', 'pgs-core' ),
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				)
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Product Type', 'pgs-core' ),
			'param_name'  => 'product_type',
			'value'       => array(
				esc_html__( 'Recently Viewed', 'pgs-core' ) => 'recently-viewed',
				esc_html__( 'Featured Products', 'pgs-core' ) => 'featured-products',
				esc_html__( 'Products in Sale', 'pgs-core' ) => 'products-in-sale',
				esc_html__( 'Top Rated Products', 'pgs-core' )  => 'top-rated-products',
			),
			'save_always' => true,
			'description' => esc_html__( 'Select type of product to display in slider.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Number of item', 'pgs-core' ),
			'param_name'  => 'number_of_item',
			'description' => esc_html__( 'Enter number of products to display in slider.', 'pgs-core' ),
			'admin_label' => true,
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
		'name'                    => esc_html__( 'Product Showcase', 'pgs-core' ),
		'description'             => esc_html__( 'Add Product Showcase.', 'pgs-core' ),
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
