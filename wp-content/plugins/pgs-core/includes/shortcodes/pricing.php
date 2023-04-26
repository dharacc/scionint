<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_pricing
 *
 ******************************************************************************/
function pgscore_shortcode_pricing( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'style'             => 'style-1',
		'title'             => esc_html__( 'Standard Plan', 'pgs-core' ),
		'subtitle'          => esc_html__( 'Free Standard Plan', 'pgs-core' ),
		'frequency'         => '',
		'features'          => '',
		'btntext'           => esc_html__( 'Buy Now', 'pgs-core' ),
		'price'             => '',
		'btnlink'           => '',
		'bestseller'        => false,
		'bestseller_label'  => esc_html__( 'Best Seller', 'pgs-core' ),
		'product_plan_link' => '',
		'element_id'        => '',
		'element_css'       => '',
		'element_class'     => '',
		'shortcode_handle'  => $shortcode_handle,
	);
	$atts         = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	**********************************************************/
	$atts['element_classes'] = array();
	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'pricing/content' ); ?>
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

	$shortcode_fields = array(
		array(
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'description' => esc_html__( 'style of timeline item display.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/pricing/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/pricing/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => esc_html__( 'Style 3', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/pricing/style-3.png',
				),
			),
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'class'       => '',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'description' => wp_kses( __( 'Enter plan title.<br><strong><span class="ciyashop-red">Note</span> : Plan title must be required to display pricing plan.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'param_name'  => 'title',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Sub Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter pricing sub title.', 'pgs-core' ),
			'param_name'  => 'subtitle',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'class'       => '',
			'heading'     => esc_html__( 'Price', 'pgs-core' ),
			'description' => esc_html__( 'Enter price. e.g. $10.00', 'pgs-core' ),
			'param_name'  => 'price',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Frequency', 'pgs-core' ),
			'description' => esc_html__( 'Enter price. e.g.Per Month', 'pgs-core' ),
			'param_name'  => 'frequency',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'class'       => '',
			'heading'     => esc_html__( 'Features', 'pgs-core' ),
			'description' => wp_kses( __( 'Enter features included in the plan.<br><strong><span class="ciyashop-red">Note</span> : Features must be required to display pricing plan. Press enter to each new feature.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'param_name'  => 'features',
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Button Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter button title.', 'pgs-core' ),
			'param_name'  => 'btntext',
			'admin_label' => true,
		),
		array(
			'type'        => 'vc_link',
			'class'       => '',
			'heading'     => esc_html__( 'Button Link', 'pgs-core' ),
			'description' => esc_html__( 'Select/enter url.', 'pgs-core' ),
			'param_name'  => 'btnlink',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Best Seller', 'pgs-core' ),
			'description' => esc_html__( 'Select this checkbox to display the table as best-seller/featured.', 'pgs-core' ),
			'param_name'  => 'bestseller',
			'holder'      => 'div',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Best Seller Label', 'pgs-core' ),
			'description' => esc_html__( 'Best seller label text like "Best Seller, Trending, Best Plan".', 'pgs-core' ),
			'param_name'  => 'bestseller_label',
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'bestseller',
				'value'   => array( 'true' ),
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

	if ( pgscore_check_plugin_active( 'subscriptio/subscriptio.php' ) ) {
		/* Product Plan */
		$plan_args           = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'DESC',
			'meta_query'     => array(
				array(
					'key'     => '_subscriptio',
					'value'   => 'yes',
					'compare' => '=',
				),
			),
		);
		$products            = new WP_Query( $plan_args );
		$products_plan_array = array( esc_html__( 'Choose plan', 'pgs-core' ) => '' );
		if ( $products->have_posts() ) {
			while ( $products->have_posts() ) {
				$products->the_post();
				$title                         = get_the_title();
				$id                            = get_the_ID();
				$products_plan_array[ $title ] = $id;
			}
		}

		$shortcode_fields[] = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Plan add to cart (Plan ID)', 'pgs-core' ),
			'description' => esc_html__( 'Note: Work with only "Subscriptio" plugin', 'pgs-core' ),
			'param_name'  => 'product_plan_link',
			'value'       => $products_plan_array,
		);
	}

	// Params
	$params = array(
		'name'                    => esc_html__( 'Pricing Box', 'pgs-core' ),
		'description'             => esc_html__( 'Make pricing boxes.', 'pgs-core' ),
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
