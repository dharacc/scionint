<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

if ( ! function_exists( 'WC' ) ) {
	return;
}

/*
 * Shortcode : pgscore_products_listing
 */
function pgscore_shortcode_products_listing( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'listing_type'                       => 'grid',
		'enable_intro'                       => '',

		'intro_title'                        => '',
		'intro_title_color'                  => '#323232',
		'intro_description'                  => '',
		'intro_description_color'            => '#969696',
		'enable_intro_link'                  => '',

		'link_title'                         => esc_html__( 'View All', 'pgs-core' ),
		'intro_link'                         => '|||',
		'intro_link_color'                   => '#323232',
		'intro_link_position'                => 'below_desc',
		'intro_link_alignment'               => 'left',

		'intro_position'                     => 'left',
		'intro_bg_type'                      => 'color',
		'intro_bg_color'                     => '#f5f5f5',
		'intro_bg_image'                     => '',
		'intro_bg_image_background_position' => '',
		'intro_bg_image_background_repeat'   => '',
		'intro_bg_image_background_size'     => '',
		'intro_bg_image_ol_color'            => 'rgba(0,0,0,0.6)',
		'intro_content_alignment'            => 'left',

		'product_source'                     => 'product_types',
		'product_source_category'            => '',
		'product_source_product_type'        => '',

		'number_of_item'                     => 5,

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
	extract( $atts );

	// Return if product source items are empty.
	if ( 'category' === $product_source && '' == $product_source_category ) {
		return;
	} elseif ( 'product_type' === $product_source && '' == $product_source_product_type ) {
		return;
	}

	// Query args
	$args = array(
		'post_type'           => 'product',
		'posts_status'        => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => $number_of_item,
	);
 
	if ( 'category' === $product_source ) {

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $product_source_category,
			),
		);

		$loop = new WP_Query( $args );

		if ( ! $loop->have_posts() ) {
			return;
		}
	} elseif ( 'product_type' === $product_source ) {
 
               $productid1=array();
		// New Arrival products
		if ( 'new_arrivals' === $product_source_product_type ) {
		      
		      if(is_user_logged_in())
		      {
		          global $wpdb; 
		         $uid=get_current_user_id();
		         
		         $myresults=$wpdb->get_row("SELECT * FROM `documentuser` where userid='".$uid."'");
			 $productid= explode(",",$myresults->productid) ;
			
			 $myresults1=$wpdb->get_results("SELECT ID FROM `wp_posts` where post_type='product' and post_status='publish'  order by ID desc limit 0,20");
			 foreach($myresults1 as $mval)
			 {
			    $productid1[]=	$mval->ID;
			 }
			 
		   		  $args['post__in']   = array_merge( $productid1,$productid );
		       
		      }
		      else{ 
		       $args['meta_query'] = array(
           'relation' => 'AND', // default relation
            array(
                'key' => 'special_product',
                'value' => 'no',
                'compare' => '=',
            ) 
            
        );  
		       
		       
		     }
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';

			// Featured product
		} elseif ( 'featured' === $product_source_product_type ) {
			$meta_query         = WC()->query->get_meta_query();
			$tax_query          = WC()->query->get_tax_query();
			$tax_query[]        = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
			$args['meta_query'] = $meta_query;
			$args['tax_query']  = $tax_query;

			// On Sale product
		} elseif ( 'on_sale' === $product_source_product_type ) {
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query']  = WC()->query->get_tax_query();
			$args['post__in']   = array_merge( array( 0 ), wc_get_product_ids_on_sale() );

			// Best Sellers Product
		} elseif ( 'best_sellers' === $product_source_product_type ) {
			$args['meta_key']   = 'total_sales';
			$args['orderby']    = 'meta_value_num';
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query']  = WC()->query->get_tax_query();

			// Cheapest Product
		} elseif ( 'cheapest' === $product_source_product_type ) {
			$args['meta_key'] = '_price';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'ASC';
		}

		$loop = new WP_Query( $args );
 
		if ( ! $loop->have_posts() ) {
			return;
		}
	}
 
	/*
	 * Element Classes
	 * For base wrapper
	 */
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts'] = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['loop'] = $loop;

	if ( isset( $pgscore_shortcodes[ $shortcode_handle ]['index'] ) ) {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = $pgscore_shortcodes[ $shortcode_handle ]['index'] + 1;
	} else {
		$pgscore_shortcodes[ $shortcode_handle ]['index'] = 1;
	}
	$pgscore_shortcodes[ $shortcode_handle ]['index_class'] = $shortcode_handle . '-' . $pgscore_shortcodes[ $shortcode_handle ]['index'];

	$atts['element_classes'][] = $pgscore_shortcodes[ $shortcode_handle ]['index_class'];

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'products_listing/content' ); ?>
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
		$categories_list[ $term->name . ' (' . $term->count . ')' ] = $term->slug;
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

		/*  Content  */
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
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Intro Link', 'pgs-core' ),
			'param_name'  => 'enable_intro_link',
			'description' => esc_html__( 'Enable this to display link in  Intro Content.', 'pgs-core' ),
			'group'       => esc_html__( 'Content', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
		),

		/*  Link Fields  */
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
			'description'      => esc_html__( 'Select link position. Note: This is applicable only when "Listing Type" is set to "Carousel". If "Listing Type" is set to grid, this will be set as "Below Description" by default.', 'pgs-core' ),
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

		/*  Intro  */
		array(
			'type'       => 'pgscore_divider',
			'param_name' => 'intro_design_divider',
			'group'      => esc_html__( 'Intro Design', 'pgs-core' ),
			'dependency' => array(
				'element' => 'enable_intro',
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
				'element' => 'enable_intro',
				'value'   => 'true',
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

		/*  Products Filter  */
		array(
			'type'        => 'dropdown',
			'param_name'  => 'product_source',
			'heading'     => esc_html__( 'Product Source', 'pgs-core' ),
			'description' => esc_html__( 'Select product source.', 'pgs-core' ),
			'save_always' => true,
			'value'       => array_flip(
				array(
					'category'     => esc_html__( 'Category', 'pgs-core' ),
					'product_type' => esc_html__( 'Product Type', 'pgs-core' ),
				)
			),
			'std'         => 'product_type',
			'group'       => esc_html__( 'Products', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'product_source_category',
			'heading'     => esc_html__( 'Product Source (Category)', 'pgs-core' ),
			'description' => esc_html__( 'Select category to display products from.', 'pgs-core' ),
			'save_always' => true,
			'value'       => $categories_list,
			'admin_label' => true,
			'group'       => esc_html__( 'Products', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'product_source',
				'value'   => 'category',
			),
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'product_source_product_type',
			'heading'     => esc_html__( 'Product Source (Product Type)', 'pgs-core' ),
			'value'       => pgscore_product_types( array( 'array_flip' => true ) ),
			'save_always' => true,
			'description' => esc_html__( 'Select product type to display products from.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Products', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'product_source',
				'value'   => 'product_type',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Number of item', 'pgs-core' ),
			'param_name'  => 'number_of_item',
			'group'       => esc_html__( 'Products', 'pgs-core' ),
			'admin_label' => true,
		),

		/*  Grid Settings  */
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

		/*  Carousel Settings  */
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
			'heading'          => esc_html__( 'Small Devices (&ge;576px )', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Products Listing', 'pgs-core' ),
		'description'             => esc_html__( 'Display product listing.', 'pgs-core' ),
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
