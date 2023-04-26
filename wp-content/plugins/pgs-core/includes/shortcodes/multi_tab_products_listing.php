<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

if ( ! function_exists( 'WC' ) ) {
	return;
}

/******************************************************************************
 *
 * Shortcode : pgscore_multi_tab_products_listing
 *
 ******************************************************************************/
function pgscore_shortcode_multi_tab_products_listing( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'listing_type'                       => 'grid',
		'enable_intro'                       => '',

		'intro_title'                        => '',
		'intro_title_color'                  => '#323232',
		'intro_description'                  => '',
		'intro_description_color'            => '#969696',

		'intro_bg_type'                      => 'color',
		'intro_bg_color'                     => '#f5f5f5',
		'intro_bg_image'                     => '',
		'intro_bg_image_background_position' => '',
		'intro_bg_image_background_repeat'   => '',
		'intro_bg_image_background_size'     => '',
		'intro_bg_image_ol_color'            => 'rgba(0,0,0,0.6)',
		'intro_content_alignment'            => 'left',

		'tabs_position'                      => 'top',
		'top_tabs_style'                     => 'style-1',
		'tabs_alignment'                     => 'right',
		'tabs_source'                        => 'product_types',
		'tabs_source_cat_term_field_type'    => 'slug',
		'tabs_source_categories'             => '',
		'tabs_source_categories_ids'         => '',
		'tabs_source_product_types'          => '',

		'tab_link_color'                     => '#323232',
		'tab_link_active_color'              => '#04d39f',

		'number_of_item'                     => 10,

		'list_grid_columns'                  => 4,

		'list_carousel_items_sm'             => 2,
		'list_carousel_items_md'             => 3,
		'list_carousel_items_lg'             => 4,
		'list_carousel_items_xl'             => 5,

		'element_css'                        => '',
		'element_id'                         => '',
		'element_class'                      => '',
		'shortcode_handle'                   => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	// If Intro is not enabled and tab position is set to "intro", then set it back to "top".
	if ( $atts['enable_intro'] == '' && 'intro' == $atts['tabs_position'] ) {
		$atts['tabs_position'] = 'top';
	}

	extract( $atts );

	// Return if tabs source items are empty.
	if ( 'categories' == $tabs_source && ( ( 'slug' === $tabs_source_cat_term_field_type && '' == $tabs_source_categories ) || ( 'term_id' === $tabs_source_cat_term_field_type && '' == $tabs_source_categories_ids ) ) ) {
		$multi_tab_args       = array(
			'taxonomy'     => 'product_cat',
			'orderby'      => 'name',
			'show_count'   => 0,
			'pad_counts'   => 0,
			'hierarchical' => 0,
			'title_li'     => '',
			'hide_empty'   => 0,
		);
		$multi_tab_categories = get_terms( $multi_tab_args );
		$all_cat              = array();
		foreach ( $multi_tab_categories as $category ) {
			$all_cat[ $category->term_id ] = $category->slug;
		}
		$tabs_source_categories     = implode( ',', $all_cat );
		$tabs_source_categories_ids = implode( ',', array_keys( $all_cat ) );
	} elseif ( 'product_types' === $tabs_source && '' == $tabs_source_product_types ) {
		return;
	}

	// Tabs
	$product_types   = pgscore_product_types();
	$tabs_data       = array();
	$tabs_data_count = 0;

	$args = array(
		'post_type'      => 'product',
		'posts_status'   => 'publish',
		'posts_per_page' => $number_of_item,
	);

	if ( 'product_types' === $tabs_source ) {

		$tab_items = explode( ',', $tabs_source_product_types );

		foreach ( $tab_items as $tab_item ) {
			$typeargs = array();

			// New Arrival products
			if ( 'new_arrivals' === $tab_item ) {
				$typeargs['orderby'] = 'date';
				$typeargs['order']   = 'DESC';

				// Featured product
			} elseif ( 'featured' === $tab_item ) {
				$meta_query             = WC()->query->get_meta_query();
				$tax_query              = WC()->query->get_tax_query();
				$tax_query[]            = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
				$typeargs['meta_query'] = $meta_query;
				$typeargs['tax_query']  = $tax_query;

				// On Sale product
			} elseif ( 'on_sale' === $tab_item ) {
				$typeargs['meta_query'] = WC()->query->get_meta_query();
				$typeargs['tax_query']  = WC()->query->get_tax_query();
				$typeargs['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

				// Best Sellers Product
			} elseif ( 'best_sellers' === $tab_item ) {

				$typeargs['meta_key']   = 'total_sales';
				$typeargs['orderby']    = 'meta_value_num';
				$typeargs['meta_query'] = WC()->query->get_meta_query();
				$typeargs['tax_query']  = WC()->query->get_tax_query();

				// Cheapest Product
			} elseif ( 'cheapest' === $tab_item ) {

				$typeargs['meta_key'] = '_price';
				$typeargs['orderby']  = 'meta_value_num';
				$typeargs['order']    = 'ASC';
			}

			$loop = new WP_Query( array_merge( $args, $typeargs ) );

			if ( $loop->have_posts() ) {
				$tabs_data_count++;

				$tabs_data[ $tab_item ]['tab_slug']   = $tab_item;
				$tabs_data[ $tab_item ]['tab_name']   = $product_types[ $tab_item ];
				$tabs_data[ $tab_item ]['tab_query']  = $loop;
				$tabs_data[ $tab_item ]['tab_status'] = true;
			}
		}
	} elseif ( 'categories' === $tabs_source ) {

		if ( 'slug' === $tabs_source_cat_term_field_type ) {
			$tab_items = explode( ',', $tabs_source_categories );
		} elseif ( 'term_id' === $tabs_source_cat_term_field_type ) {
			$tab_items = explode( ',', $tabs_source_categories_ids );
		}

		foreach ( $tab_items as $tab_item ) {

			if ( is_numeric( $tab_item ) && is_string( $tab_item ) && 'term_id' === $tabs_source_cat_term_field_type ) {
				$tab_item = (int) $tab_item;
			}

			if ( term_exists( $tab_item, 'product_cat' ) ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => $tabs_source_cat_term_field_type,
						'terms'    => $tab_item,
					),
				);

				$loop = new WP_Query( $args );

				if ( $loop->have_posts() ) {
					$tabs_data_count++;

					$tab_item_term = get_term_by( $tabs_source_cat_term_field_type, $tab_item, 'product_cat' );

					$tabs_data[ $tab_item ]['tab_slug']   = $tab_item;
					$tabs_data[ $tab_item ]['tab_name']   = $tab_item_term->name;
					$tabs_data[ $tab_item ]['tab_query']  = $loop;
					$tabs_data[ $tab_item ]['tab_status'] = true;
				}
				wp_reset_query();
			}
		}
	}

	if ( 0 == $tabs_data_count ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['tabs_data'] = $tabs_data;

	if ( isset( $pgscore_shortcodes[ $shortcode_handle ]['index'] ) ) {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = $pgscore_shortcodes[ $shortcode_handle ]['index'] + 1;
	} else {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = 1;
	}
	$pgscore_shortcodes[ $shortcode_handle ]['index_class'] = $shortcode_handle . '-' . $pgscore_shortcodes[ $shortcode_handle ]['index'];

	$atts['element_classes'][] = $pgscore_shortcodes[ $shortcode_handle ]['index_class'];

	/* Featured-product */
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'multi_tab_products_listing/content' ); ?>
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

	$categories_list    = array();
	$categories_list_id = array();

	foreach ( $categories_flat as $term_id => $term ) {
		$categories_list[ $term->name . ' (' . $term->count . ')' ]    = $term->slug;
		$categories_list_id[ $term->name . ' (' . $term->count . ')' ] = $term->term_id;
	}

	$shortcode_fields = array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'listing_type',
			'heading'     => esc_html__( 'Listing Type', 'pgs-core' ),
			'description' => esc_html__( 'Select listing type.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'grid'     => esc_html__( 'Grid', 'pgs-core' ),
					'carousel' => esc_html__( 'Carousel', 'pgs-core' ),
				)
			),
			'std'         => 'grid',
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Intro', 'pgs-core' ),
			'param_name'  => 'enable_intro',
			'description' => esc_html__( 'Enable intro to display title and description (and tabs) on left side of listing.', 'pgs-core' ),
			'save_always' => true,
			'admin_label' => true,
		),

		/* Content */
		array(
			'type'        => 'pgscore_heading',
			'param_name'  => 'content_header_notice',
			'title'       => esc_html__( 'Notice', 'pgs-core' ),
			'title_el'    => 'h5',
			'subtitle'    => esc_html__( 'If "Intro" is enabled, title and subtitle will be displayed in "Intro" portion, otherwise it will be displayed at top.', 'pgs-core' ),
			'subtitle_el' => 'h6',
			'group'       => esc_html__( 'Content', 'pgs-core' ),
		),
		array(
			'type'             => 'textfield',
			'param_name'       => 'intro_title',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'description'      => esc_html__( 'Add intro title.', 'pgs-core' ),
			'admin_label'      => true,
			'group'            => esc_html__( 'Content', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-10',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Title Color', 'pgs-core' ),
			'param_name'       => 'intro_title_color',
			'description'      => esc_html__( 'Select title color.', 'pgs-core' ),
			'value'            => '#323232',
			'group'            => esc_html__( 'Content', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-2',
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
		),
		array(
			'type'             => 'textfield',
			'param_name'       => 'intro_description',
			'heading'          => esc_html__( 'Description', 'pgs-core' ),
			'description'      => esc_html__( 'Add intro description.', 'pgs-core' ),
			'admin_label'      => true,
			'group'            => esc_html__( 'Content', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-10',
		),
		array(
			'type'             => 'colorpicker',
			'heading'          => esc_html__( 'Description Color', 'pgs-core' ),
			'param_name'       => 'intro_description_color',
			'description'      => esc_html__( 'Select description color.', 'pgs-core' ),
			'value'            => '#969696',
			'group'            => esc_html__( 'Content', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-2',
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
		),

		/* Intro */
		array(
			'type'        => 'dropdown',
			'param_name'  => 'intro_bg_type',
			'heading'     => esc_html__( 'Background Type', 'pgs-core' ),
			'description' => esc_html__( 'Select intro background type.', 'pgs-core' ),
			'save_always' => true,
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
				'element' => 'enable_intro',
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
			'save_always'      => true,
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
			'save_always'      => true,
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
			'save_always'      => true,
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
		array(
			'type'        => 'dropdown',
			'param_name'  => 'intro_content_alignment',
			'heading'     => esc_html__( 'Intro Content Alignment', 'pgs-core' ),
			'description' => esc_html__( 'Select content alignment in Intro', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'left'  => esc_html__( 'Left', 'pgs-core' ),
					'right' => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'         => 'left',
			'group'       => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
		),

		/* Tabs */
		array(
			'type'        => 'dropdown',
			'param_name'  => 'tabs_position',
			'heading'     => esc_html__( 'Tabs Position', 'pgs-core' ),
			'description' => wp_kses(
				__( "Select tabs position. <strong><span class='ciyashop-red'>Note</span>: If 'Intro' is not enabled, Tab Position will be set as 'Top' by default.</strong>", 'pgs-core' ),
				pgscore_allowed_html( array( 'span', 'strong' ) )
			),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'top'   => esc_html__( 'Top', 'pgs-core' ),
					'intro' => esc_html__( 'Intro', 'pgs-core' ),
				)
			),
			'std'         => 'top',
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'top_tabs_style',
			'heading'     => esc_html__( 'Top Tabs Style', 'pgs-core' ),
			'description' => esc_html__( 'Select tabs style, when Tabs are positioned at top.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => 'Style 1',
					'image' => PGSCORE_URL . 'images/shortcodes/multi_tab_products_listing/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/multi_tab_products_listing/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 3',
					'image' => PGSCORE_URL . 'images/shortcodes/multi_tab_products_listing/style-3.png',
				),
				array(
					'value' => 'style-4',
					'title' => 'Style 4',
					'image' => PGSCORE_URL . 'images/shortcodes/multi_tab_products_listing/style-4.png',
				),
			),
			'admin_label' => true,
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'tabs_position',
				'value'   => 'top',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'tabs_alignment',
			'heading'     => esc_html__( 'Top Tabs Alignment', 'pgs-core' ),
			'description' => esc_html__( 'Select tabs alignment, when Tabs are positioned at top.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'left'   => esc_html__( 'Left', 'pgs-core' ),
					'center' => esc_html__( 'Center', 'pgs-core' ),
					'right'  => esc_html__( 'Right', 'pgs-core' ),
				)
			),
			'std'         => 'right',
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'tabs_position',
				'value'   => 'top',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'tabs_source',
			'heading'     => esc_html__( 'Tabs Source', 'pgs-core' ),
			'description' => esc_html__( 'Select tabs source.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'categories'    => esc_html__( 'Categories', 'pgs-core' ),
					'product_types' => esc_html__( 'Product Types', 'pgs-core' ),
				)
			),
			'std'         => 'product_types',
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'tabs_source_cat_term_field_type',
			'heading'     => esc_html__( 'Tabs Categories Field Type', 'pgs-core' ),
			'description' => esc_html__( 'Select category field type. If you are facing issue with tab navigation and click on the tab is not working correctly on the front, in another language, then select Category ID.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'slug'    => esc_html__( 'Slug', 'pgs-core' ),
					'term_id' => esc_html__( 'Category ID', 'pgs-core' ),
				)
			),
			'std'         => 'slug',
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'tabs_source',
				'value'   => 'categories',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'tabs_source_categories',
			'heading'     => esc_html__( 'Tabs Categories (Slug)', 'pgs-core' ),
			'description' => esc_html__( 'Select categories to display as tab.', 'pgs-core' ),
			'save_always' => true,
			'value'       => $categories_list,
			'admin_label' => true,
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'tabs_source_cat_term_field_type',
				'value'   => 'slug',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'tabs_source_categories_ids',
			'heading'     => esc_html__( 'Tabs Categories (IDs)', 'pgs-core' ),
			'description' => esc_html__( 'Select categories to display as tab.', 'pgs-core' ),
			'save_always' => true,
			'value'       => $categories_list_id,
			'admin_label' => true,
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'tabs_source_cat_term_field_type',
				'value'   => 'term_id',
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'tabs_source_product_types',
			'heading'     => esc_html__( 'Tabs Source (Product Types)', 'pgs-core' ),
			'value'       => pgscore_product_types( array( 'array_flip' => true ) ),
			'save_always' => true,
			'description' => esc_html__( 'Select product types to display as tabs.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'tabs_source',
				'value'   => 'product_types',
			),
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'tab_link_color',
			'heading'          => esc_html__( 'Tab Link Color', 'pgs-core' ),
			'description'      => wp_kses( __( "<strong><span class='ciyashop-red'>Note</span> : Tab Link color will applied, If 'Tab Position' set as intro.</strong>", 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong' ) ) ),
			'value'            => '#323232',
			'group'            => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'colorpicker',
			'param_name'       => 'tab_link_active_color',
			'heading'          => esc_html__( 'Tab Link Active Color', 'pgs-core' ),
			'description'      => wp_kses( __( "<strong><span class='ciyashop-red'>Note</span> : Tab link active color will applied, If 'Tab Position' set as intro.</strong>", 'pgs-core' ), pgscore_allowed_html( array( 'span', 'strong' ) ) ),
			'value'            => '#04d39f',
			'group'            => esc_html__( 'Tabs', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
			'edit_field_class' => 'vc_col-md-6',
		),

		/* Products */
		array(
			'type'        => 'textfield',
			'param_name'  => 'number_of_item',
			'heading'     => esc_html__( 'Number of item', 'pgs-core' ),
			'group'       => esc_html__( 'Products', 'pgs-core' ),
			'admin_label' => true,
		),

		/* Grid Settings */
		array(
			'type'        => 'dropdown',
			'param_name'  => 'list_grid_columns',
			'heading'     => esc_html__( 'Grid Columns', 'pgs-core' ),
			'description' => esc_html__( 'Select listing grid columns.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'5' => esc_html__( '5 Column', 'pgs-core' ),
				)
			),
			'std'         => '4',
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'listing_type',
				'value'   => 'grid',
			),
		),

		/* Carousel Settings */
		array(
			'type'       => 'pgscore_divider',
			'param_name' => 'list_carousel_items_divider',
			'group'      => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'dependency' => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_carousel_items_sm',
			'heading'          => esc_html__( 'Small Devices ( &ge;576px )', 'pgs-core' ),
			'description'      => esc_html__( 'Select number of items to display at a time in small devices.', 'pgs-core' ),
			'save_always'      => true,
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				)
			),
			'std'              => '2',
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_carousel_items_md',
			'heading'          => esc_html__( 'Medium Devices ( &ge;768px )', 'pgs-core' ),
			'description'      => esc_html__( 'Select number of items to display at a time in medium devices.', 'pgs-core' ),
			'save_always'      => true,
			'value'            => array_flip(
				array(
					'1' => esc_html__( '1 Item', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
				)
			),
			'std'              => '3',
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_carousel_items_lg',
			'heading'          => esc_html__( 'Large Devices ( &ge;992px )', 'pgs-core' ),
			'description'      => esc_html__( 'Select number of items to display at a time in large devices.', 'pgs-core' ),
			'save_always'      => true,
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
				)
			),
			'std'              => '4',
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6',
		),
		array(
			'type'             => 'dropdown',
			'param_name'       => 'list_carousel_items_xl',
			'heading'          => esc_html__( 'Extra Large Devices ( &ge;1200px )', 'pgs-core' ),
			'description'      => esc_html__( 'Select number of items to display at a time in  extra large devices.', 'pgs-core' ),
			'save_always'      => true,
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
				)
			),
			'std'              => '5',
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'edit_field_class' => 'vc_col-md-3 vc_col-sm-6',
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
		'name'                    => esc_html__( 'Multi Tab Product Listing', 'pgs-core' ),
		'description'             => esc_html__( 'Display products in multi tab layout.', 'pgs-core' ),
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
