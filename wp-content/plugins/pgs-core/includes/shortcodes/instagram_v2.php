<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_instagram_v2
 *
 ******************************************************************************/
function pgscore_shortcode_instagram_v2( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                => 'default',
		'list_type'            => 'grid',
		'username'             => '',

		// Title
		'show_title'           => '',
		'title_el'             => 'h3',
		'title'                => '',

		// Button
		'show_button'          => '',
		'button_text'          => esc_html__( 'Follow us', 'pgs-core' ),
		'button_link'          => '|||',
		'show_icon'            => '',

		'image_display_target' => 'instagram',

		// Instagram Items Settings
		'item_count'           => '12',
		'show_likes'           => '',
		'show_comments'        => '',
		'image_size'           => 'thumbnail',

		// Grid Settings
		'grid_col_xl'          => '6',
		'grid_col_lg'          => '4',
		'grid_col_md'          => '3',
		'grid_col_sm'          => '2',
		'grid_col_xs'          => '2',

		// Carousel Settings
		'carousel_pagination'  => '',
		'carousel_arrow'       => '',
		'carousel_gapping'     => '0',
		'carousel_items_xl'    => '5',
		'carousel_items_lg'    => '4',
		'carousel_items_md'    => '3',
		'carousel_items_sm'    => '2',
		'carousel_items_xs'    => '1',

		'element_css'          => '',
		'element_id'           => '',
		'element_class'        => '',
		'shortcode_handle'     => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	extract( $atts );

	$images = array();
	if ( function_exists( 'ciyashop_scrape_instagram' ) ) {
		$images = ciyashop_scrape_instagram( $username, $item_count );
	}

	if ( ! $images || ! is_array( $images ) || empty( $images ) ) {
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']   = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['images'] = $images;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'instagram_v2/content' ); ?>
	</div>
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
			'heading'     => esc_html__( 'List Type', 'pgs-core' ),
			'param_name'  => 'list_type',
			'options'     => array(
				array(
					'value' => 'grid',
					'title' => 'Grid',
					'image' => PGSCORE_URL . 'images/shortcodes/instagram_v2/list_type/grid.png',
				),
				array(
					'value' => 'carousel',
					'title' => 'Carousel',
					'image' => PGSCORE_URL . 'images/shortcodes/instagram_v2/list_type/carousel.png',
				),
			),
			'value'       => 'grid',
			'show_label'  => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'options'     => array(
				array(
					'value' => 'default',
					'title' => 'Default',
					'image' => PGSCORE_URL . 'images/shortcodes/instagram_v2/style/default.png',
				),
				array(
					'value' => 'hover-border',
					'title' => 'Hover Border',
					'image' => PGSCORE_URL . 'images/shortcodes/instagram_v2/style/hover-border.png',
				),
			),
			'value'       => 'default',
			'show_label'  => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'username',
			'heading'     => esc_html__( 'Username', 'pgs-core' ),
			'description' => esc_html__( 'Enter Instagram username or #hashtag.', 'pgs-core' ),
			'admin_label' => true,
		),

		// Title
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Title', 'pgs-core' ),
			'param_name'       => 'show_title',
			'description'      => esc_html__( 'Select this checkbox to show title.', 'pgs-core' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Title Element', 'pgs-core' ),
			'param_name'       => 'title_el',
			'value'            => array_flip(
				array(
					'h2' => esc_html__( 'H2', 'pgs-core' ),
					'h3' => esc_html__( 'H3', 'pgs-core' ),
					'h4' => esc_html__( 'H4', 'pgs-core' ),
					'h5' => esc_html__( 'H5', 'pgs-core' ),
					'h6' => esc_html__( 'H6', 'pgs-core' ),
				)
			),
			'std'              => 'h3',
			'description'      => esc_html__( 'Select title element.', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'show_title',
				'value'   => 'true',
			),
			'group'            => esc_html__( 'Title Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-3',
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__( 'Title', 'pgs-core' ),
			'param_name'       => 'title',
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'show_title',
				'value'   => 'true',
			),
			'group'            => esc_html__( 'Title Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-9',
		),

		// Button
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Button', 'pgs-core' ),
			'param_name'       => 'show_button',
			'description'      => esc_html__( 'Select this checkbox to display "Follow us" button.', 'pgs-core' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Button Text', 'pgs-core' ),
			'param_name' => 'button_text',
			'value'      => esc_html__( 'Follow us', 'pgs-core' ),
			'dependency' => array(
				'element' => 'show_button',
				'value'   => 'true',
			),
			'group'      => esc_html__( 'Button Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Show Icon', 'pgs-core' ),
			'param_name'  => 'show_icon',
			'description' => esc_html__( 'Check this checkbox to enable "Instagram" icon.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'show_button',
				'value'   => 'true',
			),
			'group'       => esc_html__( 'Button Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Item Count', 'pgs-core' ),
			'param_name'  => 'item_count',
			'min'         => 1,
			'max'         => 20,
			'value'       => 12,
			'admin_label' => true,
			'group'       => esc_html__( 'Instagram Items Settings', 'pgs-core' ),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Likes', 'pgs-core' ),
			'param_name'       => 'show_likes',
			'description'      => esc_html__( 'Select this checkbox to show likes count.', 'pgs-core' ),
			'admin_label'      => true,
			'group'            => esc_html__( 'Instagram Items Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Comments', 'pgs-core' ),
			'param_name'       => 'show_comments',
			'description'      => esc_html__( 'Select this checkbox to show comments count.', 'pgs-core' ),
			'admin_label'      => true,
			'group'            => esc_html__( 'Instagram Items Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'           => 'pgscore_notice',
			'param_name'     => 'image_size_warning',
			'notice_type'    => 'error',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'message'        => esc_html__( '"Image Size" is for how big image to load, rather than what image size to show on the front. The size of the image on the front depends on the grid size and the carousel items.', 'pgs-core' ),
			'display_header' => false,
			'group'          => esc_html__( 'Instagram Items Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Image Size', 'pgs-core' ),
			'param_name'  => 'image_size',
			'value'       => array_flip(
				array(
					'thumbnail' => esc_html__( 'Thumbnail', 'pgs-core' ),
					'small'     => esc_html__( 'Small', 'pgs-core' ),
					'large'     => esc_html__( 'Large', 'pgs-core' ),
				)
			),
			'std'         => 'thumbnail',
			'description' => esc_html__( 'Select image size.', 'pgs-core' ),
			'group'       => esc_html__( 'Instagram Items Settings', 'pgs-core' ),
			'admin_label' => true,
		),

		// Grid Settings
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Column (Extra large &ge;1200px)', 'pgs-core' ),
			'param_name'  => 'grid_col_xl',
			'value'       => array_flip(
				array(
					'6' => esc_html__( '6 Column', 'pgs-core' ),
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'std'         => '6',
			'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'grid',
			),
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Column (Large &ge;992px)', 'pgs-core' ),
			'param_name'  => 'grid_col_lg',
			'value'       => array_flip(
				array(
					'4' => esc_html__( '4 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'std'         => '4',
			'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'grid',
			),
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Column (Medium &ge;768px)', 'pgs-core' ),
			'param_name'  => 'grid_col_md',
			'value'       => array_flip(
				array(
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'std'         => '3',
			'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'grid',
			),
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Column (Small &ge;576px)', 'pgs-core' ),
			'param_name'  => 'grid_col_sm',
			'value'       => array_flip(
				array(
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'std'         => '2',
			'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'grid',
			),
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Grid Column (Extra small <576px)', 'pgs-core' ),
			'param_name'  => 'grid_col_xs',
			'value'       => array_flip(
				array(
					'3' => esc_html__( '3 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'1' => esc_html__( '1 Column', 'pgs-core' ),
				)
			),
			'std'         => '2',
			'description' => esc_html__( 'Select grid columns.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'grid',
			),
			'group'       => esc_html__( 'Grid Settings', 'pgs-core' ),
		),

		// Carousel Settings
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Pagination', 'pgs-core' ),
			'param_name'       => 'carousel_pagination',
			'description'      => esc_html__( 'Select this checkbox to show carousel pagination navigation.', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Left/Right Navigation', 'pgs-core' ),
			'param_name'       => 'carousel_arrow',
			'description'      => esc_html__( 'Select this checkbox to show carousel left/right navigation.', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'            => esc_html__( 'Carousel Settings', 'pgs-core' ),
			'edit_field_class' => 'vc_col-md-6',
		),
		array(
			'type'        => 'pgscore_range_slider',
			'heading'     => esc_html__( 'Item Gapping', 'pgs-core' ),
			'param_name'  => 'carousel_gapping',
			'min'         => 0,
			'max'         => 20,
			'value'       => 0,
			'unit'        => 'px',
			'description' => esc_html__( 'Select gapping between carousel items', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Items(Extra large &ge;1200px)', 'pgs-core' ),
			'param_name'  => 'carousel_items_xl',
			'value'       => array_flip(
				array(
					'10' => esc_html__( '10 Items', 'pgs-core' ),
					'9'  => esc_html__( '9 Items', 'pgs-core' ),
					'8'  => esc_html__( '8 Items', 'pgs-core' ),
					'7'  => esc_html__( '7 Items', 'pgs-core' ),
					'6'  => esc_html__( '6 Items', 'pgs-core' ),
					'5'  => esc_html__( '5 Items', 'pgs-core' ),
					'4'  => esc_html__( '4 Items', 'pgs-core' ),
					'3'  => esc_html__( '3 Items', 'pgs-core' ),
				)
			),
			'std'         => '5',
			'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Items(Large &ge;992px)', 'pgs-core' ),
			'param_name'  => 'carousel_items_lg',
			'value'       => array_flip(
				array(
					'8' => esc_html__( '8 Items', 'pgs-core' ),
					'7' => esc_html__( '7 Items', 'pgs-core' ),
					'6' => esc_html__( '6 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
				)
			),
			'std'         => '4',
			'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Items(Medium &ge;768px)', 'pgs-core' ),
			'param_name'  => 'carousel_items_md',
			'value'       => array_flip(
				array(
					'6' => esc_html__( '6 Items', 'pgs-core' ),
					'5' => esc_html__( '5 Items', 'pgs-core' ),
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'1' => esc_html__( '1 Item', 'pgs-core' ),
				)
			),
			'std'         => '3',
			'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Items(Small &ge;576px)', 'pgs-core' ),
			'param_name'  => 'carousel_items_sm',
			'value'       => array_flip(
				array(
					'4' => esc_html__( '4 Items', 'pgs-core' ),
					'3' => esc_html__( '3 Items', 'pgs-core' ),
					'2' => esc_html__( '2 Items', 'pgs-core' ),
					'1' => esc_html__( '1 Item', 'pgs-core' ),
				)
			),
			'std'         => '2',
			'description' => esc_html__( 'Select items to display.', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_type',
				'value'   => 'carousel',
			),
			'group'       => esc_html__( 'Carousel Settings', 'pgs-core' ),
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
		'name'                    => esc_html__( 'Instagram', 'pgs-core' ),
		'description'             => esc_html__( 'Display Instagram images.', 'pgs-core' ),
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
