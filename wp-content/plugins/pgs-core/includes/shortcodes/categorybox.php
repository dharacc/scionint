<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/*
 * Shortcode : pgscore_categorybox
 */
function pgscore_shortcode_categorybox( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'title'               => '',
		'subtitle'            => '',
		'categories'          => '',
		'enable_archive_link' => false,
		'archive_link'        => '',
		'category_box_bg'     => '',
		'image_source'        => 'image',
		'category_img_link'   => '',
		'element_css'         => '',
		'element_id'          => '',
		'element_class'       => '',
		'shortcode_handle'    => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$categorybox_args = array(
		'taxonomy'     => 'product_cat',
		'orderby'      => 'name',
		'show_count'   => 0,
		'pad_counts'   => 0,
		'hierarchical' => 0,
		'title_li'     => '',
		'hide_empty'   => 0,
		'include'      => $categories,
	);

	$categorybox_categories = get_terms( $categorybox_args );

	if ( empty( $categorybox_categories ) || is_wp_error( $categorybox_categories ) ) {
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

	$pgscore_shortcodes[ $shortcode_handle ]['atts']                   = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['categorybox_categories'] = $categorybox_categories;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'categorybox/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
	<?php
	return ob_get_clean();
}

if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {
	/*
	 * Visual Composer Integration
	 */
	$shortcode_fields = array(
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'param_name'  => 'title',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => '',
			'heading'     => esc_html__( 'Subtitle', 'pgs-core' ),
			'param_name'  => 'subtitle',
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'categories',
			'description' => esc_html__( 'Select categories to display on front. If no categories selected, it will not display the complete box on front.', 'pgs-core' ),
			'value'       => pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'product_cat',
					'pad_counts' => true,
				)
			),
			'admin_label' => true,
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Display View All Link?', 'pgs-core' ),
			'param_name' => 'enable_archive_link',
		),
		array(
			'type'        => 'vc_link',
			'class'       => '',
			'heading'     => esc_html__( 'Link', 'pgs-core' ),
			'description' => esc_html__( 'Select/enter url.', 'pgs-core' ),
			'param_name'  => 'archive_link',
			'dependency'  => array(
				'element' => 'enable_archive_link',
				'value'   => 'true',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'image_source',
			'heading'    => esc_html__( 'Image Source', 'pgs-core' ),
			'group'      => esc_html__( 'Background', 'pgs-core' ),
			'value'      => array_flip(
				array(
					'image' => esc_html__( 'Image', 'pgs-core' ),
					'link'  => esc_html__( 'External Link', 'pgs-core' ),
				)
			),
			'std'        => 'image',
		),
		array(
			'type'        => 'attach_image',
			'heading'     => __( 'Background Image', 'pgs-core' ),
			'param_name'  => 'category_box_bg',
			'description' => esc_html__( 'Select background image from media library.', 'pgs-core' ),
			'group'       => esc_html__( 'Background', 'pgs-core' ),
			'holder'      => 'img',
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'image',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'category_img_link',
			'heading'     => esc_html__( 'Image Link', 'pgs-core' ),
			'description' => esc_html__( 'Please enter image external link', 'pgs-core' ),
			'group'       => esc_html__( 'Background', 'pgs-core' ),
			'save_always' => true,
			'dependency'  => array(
				'element' => 'image_source',
				'value'   => 'link',
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
					/* translators: $s: link */
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
						/* translators: $s: shortcode tag */
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
		'name'                    => esc_html__( 'Category Box', 'pgs-core' ),
		'description'             => esc_html__( 'Display category box.', 'pgs-core' ),
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
