<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/*
 * Shortcode : pgscore_recent_posts
 */
function pgscore_shortcode_recent_posts( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                              => 'style-1',
		'listing_type'                       => 'grid',
		'enable_intro'                       => '',

		// Intro Settings
		'intro_title'                        => '',
		'intro_title_color'                  => '#323232',
		'intro_description'                  => '',
		'intro_description_color'            => '#969696',
		'enable_intro_link'                  => '',

		// Link Settings
		'link_title'                         => esc_html__( 'View All', 'pgs-core' ),
		'intro_link'                         => '|||',
		'intro_link_color'                   => '#323232',
		'intro_link_position'                => 'below_desc',
		'intro_link_alignment'               => 'left',

		// Intro Design
		'intro_position'                     => 'left',
		'intro_content_alignment'            => 'left',
		'intro_bg_type'                      => 'color',
		'intro_bg_color'                     => '#f5f5f5',
		'intro_bg_image'                     => '',
		'intro_bg_image_background_position' => '',
		'intro_bg_image_background_repeat'   => '',
		'intro_bg_image_background_size'     => '',
		'intro_bg_image_ol_color'            => 'rgba(0,0,0,0.6)',

		// Carousel Settings
		'carousel_items_xl'                  => 4,
		'carousel_items_lg'                  => 3,
		'carousel_items_md'                  => 2,
		'carousel_items_sm'                  => 1,
		'carousel_margin'                    => 15,

		// Grid Settings
		'grid_column_xl'                     => '2',

		// Post Settings
		'post_type'                          => 'post',
		'ignore_sticky_posts'                => true,
		'posts_per_page'                     => 10,
		'categories'                         => '',
		'show_category_boxes'                => '',

		'element_css'                        => '',
		'element_id'                         => '',
		'element_class'                      => '',
		'shortcode_handle'                   => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	$args = array(
		'post_type'           => $post_type,
		'post_status'         => array( 'publish' ),
		'posts_per_page'      => $posts_per_page,
		'ignore_sticky_posts' => $ignore_sticky_posts,
	);

	$categories = trim( $categories );
	if ( ! empty( $categories ) ) {
		$categories_array = explode( ',', $categories );
		if ( is_array( $categories_array ) && ! empty( $categories_array ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $categories_array,
				),
			);
		}
	}

	$loop = new WP_Query( $args );

	// Return if no posts found.
	if ( ! $loop->have_posts() ) {
		return;
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
		<?php pgscore_get_shortcode_templates( 'recent_posts/content' ); ?>
	</div>
	<?php
	return ob_get_clean();
}
if ( function_exists( 'vc_map' ) && ( is_admin() || vc_is_frontend_ajax() || vc_is_frontend_editor() || vc_is_inline() ) ) {

	/*
	 * Visual Composer Integration
	 */
	$recent_post_categories_data = get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
		)
	);

	$recent_post_categories = array();

	if ( ! is_wp_error( $recent_post_categories_data ) ) {
		if ( is_array( $recent_post_categories_data ) || ! empty( $recent_post_categories_data ) ) {
			foreach ( $recent_post_categories_data as $term_data ) {
				if ( is_object( $term_data ) && isset( $term_data->name, $term_data->term_id ) ) {
					$recent_post_categories[ "{$term_data->name} ({$term_data->count})" ] = $term_data->slug;
				}
			}
		}
	}

	$categories_hierarchy = get_terms_hierarchy( 'category' );
	$categories_flat      = get_terms_hierarchical_list( $categories_hierarchy );
	$categories_list      = array();
	foreach ( $categories_flat as $term_id => $term ) {
		$categories_list[ str_repeat( '&mdash; ', $term->depth ) . $term->name . ' (' . $term->count . ')' ] = $term_id;
	}
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
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => 'Style 2',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-2.png',
				),
				array(
					'value' => 'style-3',
					'title' => 'Style 3',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-3.png',
				),
				array(
					'value' => 'style-4',
					'title' => 'Style 4',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-4.jpg',
				),
				array(
					'value' => 'style-5',
					'title' => 'Style 5',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-5.jpg',
				),
				array(
					'value' => 'style-6',
					'title' => 'Style 6',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-6.jpg',
				),
				array(
					'value' => 'style-7',
					'title' => 'Style 7',
					'image' => PGSCORE_URL . 'images/shortcodes/recent_posts/style-7.jpg',
				),
			),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => esc_html__( 'List Type', 'pgs-core' ),
			'description' => esc_html__( 'Select list type.', 'pgs-core' ),
			'param_name'  => 'listing_type',
			'value'       => array(
				esc_html__( 'Grid', 'pgs-core' )     => 'grid',
				esc_html__( 'Carousel', 'pgs-core' ) => 'carousel',
			),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Intro', 'pgs-core' ),
			'param_name'  => 'enable_intro',
			'description' => esc_html__( 'Enable intro to display title and description (and tabs) on left side of listing.', 'pgs-core' ),
			'save_always' => true,
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'style',
				'value'   => 'style-1',
			),
		),

		/* Intro Settings */
		array(
			'type'             => 'textfield',
			'param_name'       => 'intro_title',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'description'      => esc_html__( 'Add intro title.', 'pgs-core' ),
			'admin_label'      => true,
			'group'            => esc_html__( 'Content', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-10',
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
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
			'dependency'       => array(
				'element' => 'enable_intro',
				'value'   => 'true',
			),
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

		/* Link Settings */
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

		/* Intro Design*/
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

		/* ---------Grid Settings ---------*/
		array(
			'type'             => 'dropdown',
			'param_name'       => 'grid_column_xl',
			'heading'          => esc_html__( 'Grid Columns - Extra large Devices (&ge;1200px)', 'pgs-core' ),
			'description'      => esc_html__( 'Select grid columns in extra large devices width &ge;1200px.', 'pgs-core' ),
			'value'            => array_flip(
				array(
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
				)
			),
			'group'            => esc_html__( 'Grid Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-4 vc_column',
			'dependency'       => array(
				'element' => 'listing_type',
				'value'   => 'grid',
			),
		),

		/* ---------Slider Settings ---------*/
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Extra large &ge;1200px', 'pgs-core' ),
			'param_name'  => 'carousel_items_xl',
			'value'       => array_flip(
				array(
					'5' => '5',
					'4' => '4',
					'3' => '3',
					'2' => '2',
				)
			),
			'std'         => '4',
			'description' => esc_html__( 'Select items per view.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'listing_type',
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
				'element' => 'listing_type',
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
				'element' => 'listing_type',
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
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Margin', 'pgs-core' ),
			'param_name'  => 'carousel_margin',
			'min'         => '0',
			'max'         => '100',
			'value'       => '15',
			'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'listing_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
		),

		/* ---------Post Settings ---------*/
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Count', 'pgs-core' ),
			'param_name'  => 'posts_per_page',
			'value'       => '',
			'min'         => '2',
			'max'         => '10',
			'description' => esc_html__( 'Enter number of posts to display.', 'pgs-core' ),
			'group'       => esc_html__( 'Posts', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'pgs-core' ),
			'param_name'  => 'categories',
			'description' => esc_html__( 'Select categories to limit result from. To display result from all categories leave all categories unselected.', 'pgs-core' ),
			'value'       => $recent_post_categories,
			'group'       => esc_html__( 'Posts', 'pgs-core' ),
			'admin_label' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Category Boxes', 'pgs-core' ),
			'param_name'  => 'show_category_boxes',
			'description' => esc_html__( 'Check this checkbox to show categories on top within boxes. Note that by choosing this, only single category will be shown for respected blog.', 'pgs-core' ),
			'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => array(
					'style-6',
					'style-7',
				),
			),
			'group'       => esc_html__( 'Posts', 'pgs-core' ),
			'admin_label' => true,
		),

		/* ---------Background Image ---------*/
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
		'name'                    => esc_html__( 'Recent Posts', 'pgs-core' ),
		'description'             => esc_html__( 'Display recent posts.', 'pgs-core' ),
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
