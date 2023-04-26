<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 *  Shortcode : pgscore_product_cat_carousel
 *
 ******************************************************************************/
function pgscore_shortcode_product_cat_carousel( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                              => 'style-1', // shortcode style
		'title_counter_display'              => 'title-up-counter-bottom', // Categories list style
		'vertical_align'                     => 'vtop',
		'horizontal_align'                   => 'hleft',
		'list_style'                         => 'slider',

		// Categories Settings
		'product_categories'                 => '', // Product Categories
		'empty_categories'                   => false, // Show/Hide Empty Categories
		'hide_categories_count'              => false,
		'list_order'                         => 'ASC', // list order
		'order_by'                           => 'name', // order by field
		'category_title_tag'                 => 'h3',
		'title_font_weight'                  => 'inherit',
		'title_text_transform'               => 'inherit',
		'background_overlay'                 => 'custom',
		'category_title_color'               => '#04d39f',
		'category_title_hover_color'         => '#323232',
		'product_title_color'                => '#969696',
		'category_background_color'          => '',

		// Style 2 uniq options
		'category_title_hover_color_style_2' => '#04d39f',
		'category_title_color_style_2'       => '#323232',
		'cat_count_color_style_2'            => '#969696',
		'cat_img_style'                      => 'default',
		'show_border_style_2'                => false,
		'border_width_style_2'               => '',
		'border_style_style_2'               => '',
		'border_color_style_2'               => '',

		'category_title_font_size'           => '22',
		'product_title_font_size'            => '16',

		'hover_effect'                       => 'none',

		// Carousel Settings
		'slider_elements'                    => 'none', // navigation options
		'carousel_items_xl'                  => 4,
		'carousel_items_lg'                  => 3,
		'carousel_items_md'                  => 2,
		'carousel_items_sm'                  => 1,
		'carousel_margin'                    => 15,

		// Grid Settings
		'grid_elements_sm'                   => 1,
		'grid_elements_md'                   => 2,
		'grid_elements_lg'                   => 3,
		'grid_elements_xl'                   => 4,

		// Element Ids and CSS
		'element_css'                        => '',
		'element_class'                      => '',
		'shortcode_handle'                   => $shortcode_handle,
	);
	$atts         = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$product_cat_carousel_args = array(
		'taxonomy'     => 'product_cat',
		'orderby'      => $order_by,
		'order'        => $list_order,
		'show_count'   => 0,
		'pad_counts'   => 0,
		'hierarchical' => 0,
		'title_li'     => '',
		'hide_empty'   => ( false == $empty_categories ) ? 1 : 0,
		'include'      => $product_categories,
		'exclude'      => get_option( 'default_product_cat' ), // Exclude uncategorised(default) category
	);
	$product_cat_list          = get_terms( $product_cat_carousel_args );
	if ( empty( $product_cat_list ) || is_wp_error( $product_cat_list ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']             = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['product_cat_list'] = $product_cat_list;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'product_cat_carousel/content' ); ?>
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
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'description' => esc_html__( 'style of products categories item display.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => esc_html__( 'Style 3', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-3.png',
				),
				array(
					'value' => 'style-4',
					'title' => esc_html__( 'Style 4', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-4.png',
				),
				array(
					'value' => 'style-5',
					'title' => esc_html__( 'Style 5', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-5.png',
				),
				array(
					'value' => 'style-6',
					'title' => esc_html__( 'Style 6', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/style-6.png',
				),
			),
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type'             => 'pgscore_radio_image2',
			'heading'          => esc_html__( 'List Style', 'pgs-core' ),
			'param_name'       => 'list_style',
			'edit_field_class' => 'pgs-core-small-thumb vc_col-sm-12 vc_column',
			'description'      => esc_html__( 'Layout style of displaying products categories.', 'pgs-core' ),
			'options'          => array(
				array(
					'value' => 'slider',
					'title' => esc_html__( 'Slider', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/layout-style-1.png',
				),
				array(
					'value' => 'grid',
					'title' => esc_html__( 'Grid', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/product_cat_carousel/layout-style-2.png',
				),
			),
			'save_always'      => true,
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => esc_html__( 'Text Vertical Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set text vertical position.', 'pgs-core' ),
			'param_name'       => 'vertical_align',
			'value'            => array_flip(
				array(
					'vtop'    => esc_html__( 'Top', 'pgs-core' ),
					'vmiddle' => esc_html__( 'Middle', 'pgs-core' ),
					'vbottom' => esc_html__( 'Bottom', 'pgs-core' ),
				)
			),
			'std'              => 'vtop',
			'edit_field_class' => 'vc_col-md-6',
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'style',
				'value'   => array( 'style-1', 'style-3' ),
			),
		),
		array(
			'type'             => 'dropdown',
			'class'            => '',
			'heading'          => esc_html__( 'Text Horizontal Align', 'pgs-core' ),
			'description'      => esc_html__( 'Set text horizontal position', 'pgs-core' ),
			'param_name'       => 'horizontal_align',
			'value'            => array_flip(
				array(
					'hleft'   => esc_html__( 'Left', 'pgs-core' ),
					'hcenter' => esc_html__( 'Center', 'pgs-core' ),
					'hright'  => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'              => 'hleft',
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'category_title_tag',
			'heading'          => esc_html__( 'Title Element Tag', 'pgs-core' ),
			'description'      => esc_html__( 'Select category title element tag.', 'pgs-core' ),
			'std'              => 'h3',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value'            => array_flip(
				array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'title_font_weight',
			'heading'          => esc_html__( 'Font Weight', 'pgs-core' ),
			'description'      => esc_html__( 'Select category title font weight tag.', 'pgs-core' ),
			'std'              => 'inherit',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value'            => array_flip(
				array(
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
					'normal'  => esc_html__( 'Normal', 'pgs-core' ),
					'400'     => esc_html__( '400', 'pgs-core' ),
					'500'     => esc_html__( '500', 'pgs-core' ),
					'700'     => esc_html__( '700', 'pgs-core' ),
					'900'     => esc_html__( '900', 'pgs-core' ),
					'bold'    => esc_html__( 'Bold', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'title_text_transform',
			'heading'          => esc_html__( 'Text Transform', 'pgs-core' ),
			'description'      => esc_html__( 'Select text transform property for title.', 'pgs-core' ),
			'std'              => 'inherit',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'value'            => array_flip(
				array(
					'inherit'    => esc_html__( 'Inherit', 'pgs-core' ),
					'capitalize' => esc_html__( 'Capitalize', 'pgs-core' ),
					'initial'    => esc_html__( 'Initial', 'pgs-core' ),
					'uppercase'  => esc_html__( 'Uppercase', 'pgs-core' ),
					'lowercase'  => esc_html__( 'Lowercase', 'pgs-core' ),
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'unset'      => esc_html__( 'Unset', 'pgs-core' ),
				)
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'background_overlay',
			'heading'          => esc_html__( 'Text And Overlay Color', 'pgs-core' ),
			'description'      => esc_html__( 'Set text and overlay color.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 'none',
			'value'            => array_flip(
				array(
					'none'   => esc_html__( 'None', 'pgs-core' ),
					'theme'  => esc_html__( 'Theme', 'pgs-core' ),
					'dark'   => esc_html__( 'Dark', 'pgs-core' ),
					'light'  => esc_html__( 'Light', 'pgs-core' ),
					'custom' => esc_html__( 'Custom', 'pgs-core' ),
				)
			),
			'save_always'      => true,
			'dependency'       => array(
				'element'            => 'style',
				'value_not_equal_to' => 'style-2',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'category_title_color',
			'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Title Color.', 'pgs-core' ),
			'value'            => '#04d39f',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'background_overlay',
				'value'   => 'custom',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'category_title_hover_color',
			'heading'          => esc_html__( 'Title Hover Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Title Hover Color.', 'pgs-core' ),
			'value'            => '#323232',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'background_overlay',
				'value'   => 'custom',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'product_title_color',
			'heading'          => esc_html__( 'Count Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Count Title Color.', 'pgs-core' ),
			'value'            => '#969696',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'background_overlay',
				'value'   => 'custom',
			),
		),

		/* Style 2 Uniq Options */
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'category_title_color_style_2',
			'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Title Color.', 'pgs-core' ),
			'value'            => '#04d39f',
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'category_title_hover_color_style_2',
			'heading'          => esc_html__( 'Title Hover Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Title Hover Color.', 'pgs-core' ),
			'value'            => '#323232',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'cat_count_color_style_2',
			'heading'          => esc_html__( 'Count Title Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select Category Count Title Color.', 'pgs-core' ),
			'value'            => '#969696',
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'cat_img_style',
			'heading'          => esc_html__( 'Image Style', 'pgs-core' ),
			'description'      => esc_html__( 'Set category image style.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 'none',
			'value'            => array_flip(
				array(
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
				)
			),
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Border?', 'pgs-core' ),
			'param_name'       => 'show_border_style_2',
			'description'      => esc_html__( 'Check this checkbox to show border to the category item.', 'pgs-core' ),
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'border_color_style_2',
			'heading'          => esc_html__( 'Border Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select category item border color.', 'pgs-core' ),
			'value'            => '#969696',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'show_border_style_2',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'pgscore_number_min_max',
			'heading'          => esc_html__( 'Border Width', 'pgs-core' ),
			'param_name'       => 'border_width_style_2',
			'min'              => '0',
			'max'              => '20',
			'value'            => '1',
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'description'      => wp_kses( __( 'Enter width, in pixels (px). <br> <strong><span class="ciyashop-red">Note</span> : If you add "less than 0" value in input, then it will take "0" width and if you select "greater than 20" value, then it will set 20 as width.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'dependency'       => array(
				'element' => 'show_border_style_2',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'border_style_style_2',
			'heading'          => esc_html__( 'Border Style', 'pgs-core' ),
			'description'      => esc_html__( 'Select category border style.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 'none',
			'value'            => array_flip(
				array(
					'none'    => esc_html__( 'None', 'pgs-core' ),
					'solid'   => esc_html__( 'Solid', 'pgs-core' ),
					'dotted'  => esc_html__( 'Dotted', 'pgs-core' ),
					'dashed'  => esc_html__( 'Dashed', 'pgs-core' ),
					'double'  => esc_html__( 'Double', 'pgs-core' ),
					'inherit' => esc_html__( 'Inherit', 'pgs-core' ),
				)
			),
			'save_always'      => true,
			'dependency'       => array(
				'element' => 'show_border_style_2',
				'value'   => 'true',
			),
		),

		array(
			'type'             => 'colorpicker',
			'param_name'       => 'category_background_color',
			'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
			'description'      => esc_html__( 'Select category background color.', 'pgs-core' ),
			'value'            => '#969696',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element' => 'background_overlay',
				'value'   => 'custom',
			),
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Title Font Size', 'pgs-core' ),
			'description' => esc_html__( 'Enter Category Title Font Size between 10 to 80.', 'pgs-core' ),
			'param_name'  => 'category_title_font_size',
			'tooltip'     => esc_html__( 'Enter Category Title Font Size between 10 to 80.', 'pgs-core' ),
			'min'         => 10,
			'max'         => 80,
			'value'       => 22,
			'unit'        => 'px',
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Count Title Font Size', 'pgs-core' ),
			'description' => esc_html__( 'Enter Category Count Title Font Size between 10 to 80.', 'pgs-core' ),
			'param_name'  => 'product_title_font_size',
			'tooltip'     => esc_html__( 'Enter Category Count Title Font Size between 10 to 80.', 'pgs-core' ),
			'min'         => 10,
			'max'         => 80,
			'value'       => 16,
			'unit'        => 'px',
			'dependency'  => array(
				'element'            => 'hide_categories_count',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'title_counter_display',
			'heading'          => esc_html__( 'Title-Counter Display', 'pgs-core' ),
			'description'      => esc_html__( 'Select option to show title and product counter of product category.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'title-up-counter-bottom' => esc_html__( 'Title Up Counter Bottom', 'pgs-core' ),
					'counter-up-title-bottom' => esc_html__( 'Counter Up Title Bottom', 'pgs-core' ),
				)
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency'       => array(
				'element'            => 'hide_categories_count',
				'value_not_equal_to' => 'true',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'hover_effect',
			'heading'          => esc_html__( 'Hover Effect', 'pgs-core' ),
			'description'      => esc_html__( 'Set category title hover effect.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'std'              => 'none',
			'value'            => array_flip(
				array(
					'none' => esc_html__( 'None', 'pgs-core' ),
					'zoom' => esc_html__( 'Zoom', 'pgs-core' ),
				)
			),
			'save_always'      => true,
		),

		/*  Category Settings */
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'product_categories',
			'description' => esc_html__( 'Select categories to display on front. If no categories selected, it will show all the categories on front.', 'pgs-core' ),
			'value'       => pgscore_get_terms(
				array( // You can pass arguments from get_terms (except hide_empty)
					'taxonomy'   => 'product_cat',
					'pad_counts' => true,
					'hide_empty' => false,
					'exclude'    => get_option( 'default_product_cat' ),
				)
			),
			'group'       => esc_html__( 'Category', 'pgs-core' ),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Empty Categories?', 'pgs-core' ),
			'param_name'       => 'empty_categories',
			'description'      => wp_kses( __( 'Check this checkbox to show categories which are not assigned to any products. <br> <strong><span class="ciyashop-red">Note</span> : Here "Uncategorised" category will not be shown.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Category', 'pgs-core' ),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Hide Product Categories Count?', 'pgs-core' ),
			'param_name'       => 'hide_categories_count',
			'description'      => wp_kses( __( 'Check this checkbox to hide categories products counts.', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'save_always'      => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Category', 'pgs-core' ),
			'dependency'       => array(
				'callback' => 'vcCiyaShopCatItemsCountDependencyCallback',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'order_by',
			'heading'          => esc_html__( 'Order By', 'pgs-core' ),
			'description'      => esc_html__( 'Select order by field for order to display product category.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'name'   => esc_html__( 'Category Name', 'pgs-core' ),
					'date'   => esc_html__( 'Date', 'pgs-core' ),
					'id'     => esc_html__( 'ID', 'pgs-core' ),
					'author' => esc_html__( 'Author', 'pgs-core' ),
				)
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Category', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_order',
			'heading'          => esc_html__( 'Display Order', 'pgs-core' ),
			'description'      => esc_html__( 'Select order to display product category.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'ASC'  => esc_html__( 'Ascending', 'pgs-core' ),
					'DESC' => esc_html__( 'Descending', 'pgs-core' ),
				)
			),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Category', 'pgs-core' ),
		),

		/* ---------Grid Settings ---------*/
		array(
			'type'             => 'dropdown',
			'param_name'       => 'grid_elements_xl',
			'heading'          => esc_html__( 'Columns - Extra large &ge;1200px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				)
			),
			'std'              => '4',
			'group'            => esc_html__( 'Grid Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'grid',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'grid_elements_lg',
			'heading'          => esc_html__( 'Columns - Large &ge;992px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				)
			),
			'std'              => '3',
			'group'            => esc_html__( 'Grid Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'grid',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'grid_elements_md',
			'heading'          => esc_html__( 'Columns - Medium &ge;768px', 'pgs-core' ),
			'description'      => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Grid Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'grid',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Columns - Small &ge;576px', 'pgs-core' ),
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'param_name'       => 'grid_elements_sm',
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Grid Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'grid',
			),
		),

		/* ---------Slider Settings ---------*/
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slider Navigations', 'pgs-core' ),
			'param_name'       => 'slider_elements',
			'value'            => array_flip(
				array(
					'none'       => esc_html__( 'None', 'pgs-core' ),
					'pagination' => esc_html__( 'Pagination Control', 'pgs-core' ),
					'prevnext'   => esc_html__( 'Prev/Next Buttons', 'pgs-core' ),
					'both'       => esc_html__( 'Both', 'pgs-core' ),
				)
			),
			'description'      => esc_html__( 'Select slider navigations controls type.', 'pgs-core' ),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => array( 'slider' ),
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
			'param_name'       => 'carousel_items_xl',
			'value'            => array_flip(
				array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'std'              => '4',
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Large &ge;992px', 'pgs-core' ),
			'param_name'       => 'carousel_items_lg',
			'value'            => array_flip(
				array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'std'              => '3',
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Medium &ge;768px', 'pgs-core' ),
			'param_name'       => 'carousel_items_md',
			'value'            => array_flip(
				array(
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'std'              => '2',
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Small &ge;576px', 'pgs-core' ),
			'param_name'       => 'carousel_items_sm',
			'value'            => array_flip(
				array(
					'2' => '2',
					'1' => '1',
				)
			),
			'std'              => '1',
			'description'      => esc_html__( 'Select items per view.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Margin', 'pgs-core' ),
			'param_name'  => 'carousel_margin',
			'min'         => '0',
			'max'         => '50',
			'value'       => '15',
			'description' => wp_kses( __( 'Enter margin, in pixels (px), between each item. <br> <strong><span class="ciyashop-red">Note</span> : If you add "less than 0" value in input, then it will take "0" margin and if you select "greater than 50" value, then it will set 50 as margin.</strong>', 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong', 'br' ) ) ),
			'dependency'  => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		// Custom Design Editor
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'pgs-core' ),
			'param_name' => 'element_css',
			'group'      => esc_html__( 'Design Options', 'pgs-core' ),
		),
		// Additional Class Name
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
		'name'                    => esc_html__( 'Product Category Items', 'pgs-core' ),
		'description'             => esc_html__( 'Display Product Categories.', 'pgs-core' ),
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
