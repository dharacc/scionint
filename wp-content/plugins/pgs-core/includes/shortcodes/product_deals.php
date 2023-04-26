<?php
/*
 * Shortcode : pgscore_product_deals
 */
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

function pgscore_shortcode_product_deals( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                              => 'default',

		'enable_intro_content'               => '',
		'intro_title'                        => '',
		'intro_title_color'                  => '#323232',
		'intro_description'                  => '',
		'intro_description_color'            => '#969696',
		'product_per_page'                   => 8,
		'product_categories'                 => '',
		'enable_intro_link'                  => '',

		'intro_position'                     => 'left',
		'intro_bg_type'                      => 'color',
		'intro_bg_color'                     => '#f5f5f5',
		'intro_bg_image'                     => '',
		'intro_bg_image_background_position' => '',
		'intro_bg_image_background_repeat'   => '',
		'intro_bg_image_background_size'     => '',
		'intro_bg_image_ol_color'            => 'rgba(0,0,0,0.6)',

		'link_title'                         => esc_html__( 'View All', 'pgs-core' ),
		'intro_link'                         => '|||',
		'intro_link_color'                   => '#323232',
		'intro_link_position'                => 'below_desc',
		'intro_link_alignment'               => 'left',

		'expire_message'                     => esc_html__( 'This offer has expired!', 'pgs-core' ),
		'counter_size'                       => 'xs',
		'element_css'                        => '',
		'element_id'                         => '',
		'element_class'                      => '',
		'shortcode_handle'                   => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$sale_ids = array();

	$args = array(
		'post_type'      => 'product',
		'posts_status'   => 'publish',
		'posts_per_page' => $product_per_page,
		'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),
	);

	$product_categories = trim( $product_categories );
	if ( ! empty( $product_categories ) ) {
		$categories_array = explode( ',', $product_categories );
		if ( is_array( $categories_array ) && ! empty( $categories_array ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $categories_array,
				),
			);
		}
	}

	$loop = new WP_Query( $args );
	if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) :
			$loop->the_post();
			$sale_ids[] = get_the_ID();
		endwhile;
	}

	wp_reset_query();

	if ( ! is_array( $sale_ids ) || ( is_array( $sale_ids ) && empty( $sale_ids ) ) ) {
		return;
	}

	/*
	 * Element Classes
	 * For base wrapper
	*/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']     = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['sale_ids'] = $sale_ids;

	global $post;
	if ( isset( $pgscore_shortcodes[ $shortcode_handle ]['index'] ) ) {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = $pgscore_shortcodes[ $shortcode_handle ]['index'] + 1;
	} else {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = 1;
	}

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'product_deals/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {

	// Get Product Categories
	$product_categories_data = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		)
	);

	$product_categories = array();

	if ( ! is_wp_error( $product_categories_data ) ) {
		if ( is_array( $product_categories_data ) || ! empty( $product_categories_data ) ) {
			foreach ( $product_categories_data as $term_data ) {
				if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
					$product_categories[ "{$term_data->name}" ] = $term_data->slug;
				}
			}
		}
	}
	/*
	 * Visual Composer Integration
	 */
	$shortcode_fields = array(
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Intro Content', 'pgs-core' ),
			'param_name'  => 'enable_intro_content',
			'description' => esc_html__( 'Enable intro content to display title and description.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'             => 'textfield',
			'param_name'       => 'intro_title',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'description'      => esc_html__( 'Add intro title.', 'pgs-core' ),
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-10',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
			'param_name'       => 'intro_title_color',
			'description'      => esc_html__( 'Select title color.', 'pgs-core' ),
			'value'            => '#323232',
			'edit_field_class' => 'vc_col-md-2',
			'dependency'       => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'textfield',
			'param_name'       => 'intro_description',
			'heading'          => esc_html__( 'Description', 'pgs-core' ),
			'description'      => esc_html__( 'Add intro description.', 'pgs-core' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-md-10',
			'dependency'       => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Description Color', 'pgs-core' ),
			'param_name'       => 'intro_description_color',
			'description'      => esc_html__( 'Select description color.', 'pgs-core' ),
			'value'            => '#969696',
			'edit_field_class' => 'vc_col-md-2',
			'dependency'       => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Product Count', 'pgs-core' ),
			'param_name'  => 'product_per_page',
			'value'       => '',
			'min'         => '2',
			'max'         => '10',
			'description' => esc_html__( 'Enter number product to display.', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Product Categories', 'pgs-core' ),
			'param_name'  => 'product_categories',
			'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			'value'       => $product_categories,
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Link', 'pgs-core' ),
			'param_name'  => 'enable_intro_link',
			'description' => esc_html__( 'Enable this to display link in  Intro Content.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
			'admin_label' => true,
		),

		/* Intro Design Fields */
		array(
			'type'       => 'pgscore_divider',
			'param_name' => 'intro_design_divider',
			'group'      => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency' => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'intro_position',
			'heading'     => esc_html__( 'Intro Position', 'pgs-core' ),
			'description' => esc_html__( 'Select intro position.', 'pgs-core' ),
			'value'       => array_flip(
				array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'         => 'left',
			'admin_label' => true,
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'intro_bg_type',
			'heading'     => esc_html__( 'Background Type', 'pgs-core' ),
			'description' => esc_html__( 'Select intro background type.', 'pgs-core' ),
			'value'       => array_flip(
				array(
					'color' => esc_html__( 'Color', 'pgs-core' ),
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'none'  => esc_html__( 'None', 'pgs-core' ),
				)
			),
			'std'         => 'color',
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_intro_content',
				'value'   => 'true',
			),
			'admin_label' => true,
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Background Color', 'pgs-core' ),
			'param_name'  => 'intro_bg_color',
			'description' => esc_html__( 'Select background color.', 'pgs-core' ),
			'value'       => '#f5f5f5',
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'intro_bg_type',
				'value'   => 'color',
			),
		),
		array(
			'type'        => 'attach_image',
			'param_name'  => 'intro_bg_image',
			'heading'     => esc_html__( 'Background Image', 'pgs-core' ),
			'description' => esc_html__( 'Upload intro background image', 'pgs-core' ),
			'holder'      => 'img',
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'intro_bg_type',
				'value'   => 'image',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'intro_bg_image_background_position',
			'heading'          => esc_html__( 'Background Position', 'pgs-core' ),
			'description'      => esc_html__( 'Select intro background image position.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					''              => esc_html__( 'Select Background Position', 'pgs-core' ),
					'inherit'       => esc_html__( 'Inherit', 'pgs-core' ),
					'left top'      => esc_html__( 'Left Top', 'pgs-core' ),
					'left center'   => esc_html__( 'Left Center', 'pgs-core' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'pgs-core' ),
					'right top'     => esc_html__( 'Right Top', 'pgs-core' ),
					'right center'  => esc_html__( 'Right Center', 'pgs-core' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'pgs-core' ),
					'center top'    => esc_html__( 'Center Top', 'pgs-core' ),
					'center center' => esc_html__( 'Center Center', 'pgs-core' ),
					'center bottom' => esc_html__( 'Center Bottom', 'pgs-core' ),
				)
			),
			'std'              => '',
			'group'            => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'intro_bg_type',
				'value'   => 'image',
			),
			'edit_field_class' => 'vc_col-md-4',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'intro_bg_image_background_repeat',
			'heading'          => esc_html__( 'Background Repeat', 'pgs-core' ),
			'description'      => esc_html__( 'Select intro background image repeat.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					''          => esc_html__( 'Select Background Repeat', 'pgs-core' ),
					'inherit'   => esc_html__( 'Inherit', 'pgs-core' ),
					'repeat'    => esc_html__( 'Repeat', 'pgs-core' ),
					'repeat-x'  => esc_html__( 'Repeat-X', 'pgs-core' ),
					'repeat-y'  => esc_html__( 'Repeat-Y', 'pgs-core' ),
					'no-repeat' => esc_html__( 'No-Repeat', 'pgs-core' ),
					'initial'   => esc_html__( 'Initial', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'intro_bg_type',
				'value'   => 'image',
			),
			'edit_field_class' => 'vc_col-md-4',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'intro_bg_image_background_size',
			'heading'          => esc_html__( 'Background Size', 'pgs-core' ),
			'description'      => esc_html__( 'Select intro background image size.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					''        => esc_html__( 'Select Background Size', 'pgs-core' ),
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
					'auto'    => esc_html__( 'Auto', 'pgs-core' ),
					'cover'   => esc_html__( 'Cover', 'pgs-core' ),
					'contain' => esc_html__( 'Contain', 'pgs-core' ),
					'initial' => esc_html__( 'Initial', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'intro_bg_type',
				'value'   => 'image',
			),
			'edit_field_class' => 'vc_col-md-4',
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Overlay Color', 'pgs-core' ),
			'param_name'  => 'intro_bg_image_ol_color',
			'description' => esc_html__( 'Select overlay color for background image.', 'pgs-core' ),
			'value'       => 'rgba(0,0,0,0.6)',
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'intro_bg_type',
				'value'   => 'image',
			),
		),

		/* Link Fields */
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Link Title', 'pgs-core' ),
			'param_name' => 'link_title',
			'value'      => esc_html__( 'View All', 'pgs-core' ),
			'group'      => esc_html__( 'Intro Link', 'pgs-core' ),
			'dependency' => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'vc_link',
			'heading'          => esc_html__( 'Link', 'pgs-core' ),
			'param_name'       => 'intro_link',
			'description'      => esc_html__( 'Add link. For email use mailto:your.email@example.com.', 'pgs-core' ),
			'group'            => esc_html__( 'Intro Link', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Link Color', 'pgs-core' ),
			'param_name'       => 'intro_link_color',
			'description'      => esc_html__( 'Select link color.', 'pgs-core' ),
			'value'            => '#323232',
			'group'            => esc_html__( 'Intro Link', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'intro_link_position',
			'heading'          => esc_html__( 'Link Position', 'pgs-core' ),
			'description'      => esc_html__( 'Select link position.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'below_desc'    => esc_html__( 'Below Description', 'pgs-core' ),
					'with_controls' => esc_html__( 'With Carousel Controls', 'pgs-core' ),
				)
			),
			'std'              => 'below_desc',
			'group'            => esc_html__( 'Intro Link', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'enable_intro_link',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'intro_link_alignment',
			'heading'          => esc_html__( 'Link Alignment', 'pgs-core' ),
			'description'      => esc_html__( 'Select link alignment with carousel controls.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'              => 'left',
			'group'            => esc_html__( 'Intro Link', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'intro_link_position',
				'value'   => 'with_controls',
			),
			'edit_field_class' => 'vc_col-md-6',
		),

		/* Deal Fields */
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Expire Message', 'pgs-core' ),
			'param_name'  => 'expire_message',
			'value'       => esc_html__( 'This offer has expired!', 'pgs-core' ),
			'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
			'group'       => esc_html__( 'Deal Details', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Product Deals', 'pgs-core' ),
		'description'             => esc_html__( 'Add Product Deal For Multiple Product.', 'pgs-core' ),
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
