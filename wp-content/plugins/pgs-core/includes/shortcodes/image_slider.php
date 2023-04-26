<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_image_slider
 *
 ******************************************************************************/
function pgscore_shortcode_image_slider( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'                   => 'style-1',
		'list_style'              => 'slider',
		'grid_elements_xl'        => '4',
		'grid_elements_lg'        => '3',
		'grid_elements_md'        => '1',
		'grid_elements_sm'        => '1',
		'img_size'                => 'ciyashop-latest-post-thumbnail',
		'carousel_thumbnail_size' => 'default',
		'custom_img_size'         => '',
		'title_link_enable'       => '',
		'title_link_url'          => '',
		'slides_per_view'         => 4,
		'slides_per_view_xx'      => '',
		'slides_per_view_xs'      => '',
		'slides_per_view_sm'      => '3',
		'slides_per_view_md'      => '',
		'slide_margin'            => '30',
		'show_pagination_control' => '',
		'show_prev_next_buttons'  => '',
		'enable_infinity_loop'    => '',
		'enable_caption'          => false,
		'slides'                  => '',
		'element_css'             => '',
		'element_id'              => '',
		'element_class'           => '',
		'shortcode_handle'        => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
	extract( $atts );

	/*********************************************
	 *
	 * Check for slides
	 *
	 *********************************************/
	$slides_data = vc_param_group_parse_atts( $slides );

	if ( ! is_array( $slides_data ) || empty( $slides_data ) || ( ( count( $slides_data ) == 1 ) && empty( $slides_data[0] ) ) ) {
		return;
	}

	/*********************************************
	 *
	 * Check for thumbnail size
	 *
	 *********************************************/
	if ( ! empty( $carousel_thumbnail_size ) && 'custom' == $carousel_thumbnail_size ) {
		$img_size = $custom_img_size;
	}
	if ( empty( $img_size ) ) {
		$img_size = 'ciyashop-latest-post-thumbnail';
	}

	global $_wp_additional_image_sizes;
	$thumb_size = '';
	if (
		is_string( $img_size ) && (
			( ! empty( $_wp_additional_image_sizes[ $img_size ] ) && is_array( $_wp_additional_image_sizes[ $img_size ] ) )
			|| in_array( $img_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ) )
		)
	) {
		$thumb_size = $img_size;
	} elseif ( false !== strpos( $img_size, 'x' ) ) {
		$img_size = explode( 'x', $img_size );

		// Check for PHP version
		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) { // PHP < 5.3
			$img_size = array_filter( $img_size, create_function( '$value', 'return $value !== "";' ) );
		} else { // PHP 5.3 and later
			$img_size = array_filter(
				$img_size,
				function( $value ) {
					return $value !== '';
				}
			);
		}

		if ( count( $img_size ) == 2 && is_numeric( $img_size[0] ) && is_numeric( $img_size[1] ) ) {
			$thumb_size = $img_size;
		}
	}
	if ( empty( $thumb_size ) ) {
		$thumb_size = 'ciyashop-latest-post-thumbnail';
	}

	foreach ( $slides_data as $slide_tk => $slide_td ) {
		if ( empty( $slide_td['image'] ) ) {
			unset( $slides_data[ $slide_tk ] );
		} else {
			$image_thumb = wp_get_attachment_image_src( $slide_td['image'], $thumb_size, false );
			$image_full  = wp_get_attachment_image_src( $slide_td['image'], 'full', false );

			if ( $image_thumb && ! empty( $image_thumb[0] ) ) {
				$slides_data[ $slide_tk ]['image_thumbnail']        = $image_thumb[0];
				$slides_data[ $slide_tk ]['image_thumbnail_width']  = $image_thumb[1];
				$slides_data[ $slide_tk ]['image_thumbnail_height'] = $image_thumb[2];
				$slides_data[ $slide_tk ]['image_url']              = $image_full[0];
				$slides_data[ $slide_tk ]['image_url_width']        = $image_full[1];
				$slides_data[ $slide_tk ]['image_url_height']       = $image_full[2];
			} else {
				unset( $slides_data[ $slide_tk ] );
			}
		}
	}

	/**********************************************************
	 *
	 * Element Classes
	 * For base wrapper
	 *
	 **********************************************************/
	$atts['element_classes'] = array();

	global $pgscore_shortcodes;
	$pgscore_shortcodes[ $shortcode_handle ]['atts']        = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['slides_data'] = $slides_data;

	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'image_slider/content' ); ?>
	</div>
	<!-- Shortcode Base Wrapper -->
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
			'options'     => array(
				array(
					'value' => 'style-1',
					'title' => esc_html__( 'Style 1', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/image_slider/style-1.png',
				),
				array(
					'value' => 'style-2',
					'title' => esc_html__( 'Style 2', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/image_slider/style-2.png',
				),
			),
			'show_label'  => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'heading'     => esc_html__( 'List Style', 'pgs-core' ),
			'param_name'  => 'list_style',
			'description' => esc_html__( 'Layout style of displaying image slider.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'slider',
					'title' => esc_html__( 'Slider', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/clients/style-1.png',
				),
				array(
					'value' => 'grid',
					'title' => esc_html__( 'Grid', 'pgs-core' ),
					'image' => PGSCORE_URL . 'images/shortcodes/clients/style-2.png',
				),
			),
			'show_label'  => true,
			'admin_label' => true,
			'save_always' => true,
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Enable Caption', 'pgs-core' ),
			'param_name'  => 'enable_caption',
			'admin_label' => true,
			'description' => esc_html__( 'Select this to enable caption on slides.', 'pgs-core' ),
			'group'       => esc_html__( 'Slides', 'pgs-core' ),
		),
		array(
			'type'       => 'param_group',
			'value'      => '',
			'param_name' => 'slides',
			'params'     => array(
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Slide Image', 'pgs-core' ),
					'description'      => esc_html__( 'Upload only image types like JPG, JPEG, PNG No other types are supported.Please Upload maximum size of image.', 'pgs-core' ),
					'param_name'       => 'image',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'pgs-core' ),
					'param_name'       => 'title',
					'description'      => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'             => 'checkbox',
					'heading'          => esc_html__( 'Title Link ?', 'pgs-core' ),
					'param_name'       => 'title_link_enable',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Select this checkbox to add link on title.', 'pgs-core' ),
				),
				array(
					'type'             => 'vc_link',
					'heading'          => esc_html__( 'Title URL (Link)', 'pgs-core' ),
					'param_name'       => 'title_link_url',
					'description'      => esc_html__( 'Add custom link on title.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'title_link_enable',
						'value'   => 'true',
					),
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Subtitle', 'pgs-core' ),
					'param_name'       => 'subtitle',
					'description'      => esc_html__( 'This will be displayed only if Enable Caption is selected.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'admin_label'      => true,
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'On Click Action', 'pgs-core' ),
					'param_name'       => 'onclick',
					'value'            => array_flip(
						array(
							'link_no'     => esc_html__( 'None', 'pgs-core' ),
							'link_image'  => esc_html__( 'Image Popup', 'pgs-core' ),
							'custom_link' => esc_html__( 'Open Link', 'pgs-core' ),
						)
					),
					'description'      => esc_html__( 'Select action for click event.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-4 vc_column',
				),
				array(
					'type'             => 'vc_link',
					'heading'          => esc_html__( 'Custom Link', 'pgs-core' ),
					'param_name'       => 'custom_link',
					'description'      => esc_html__( 'Add custom link.', 'pgs-core' ),
					'edit_field_class' => 'vc_col-sm-4 vc_column',
					'dependency'       => array(
						'element' => 'onclick',
						'value'   => array( 'custom_link' ),
					),
				),
			),
			'group'      => esc_html__( 'Slides', 'pgs-core' ),
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
					'1' => esc_html__( '1 Column', 'pgs-core' ),
					'2' => esc_html__( '2 Column', 'pgs-core' ),
					'3' => esc_html__( '3 Column', 'pgs-core' ),
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
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Thumbnail Size', 'pgs-core' ),
			'param_name'  => 'carousel_thumbnail_size',
			'value'       => array_flip(
				array(
					'default' => esc_html__( 'Default', 'pgs-core' ),
					'custom'  => esc_html__( 'Custom', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Select thumbnail size you want to use.', 'pgs-core' ),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Carousel Thumbnail Size', 'pgs-core' ),
			'param_name'  => 'img_size',
			'value'       => array_flip(
				array(
					'thumbnail' => esc_html__( 'Thumbnail', 'pgs-core' ),
					'medium'    => esc_html__( 'Medium', 'pgs-core' ),
					'large'     => esc_html__( 'Large', 'pgs-core' ),
					'full'      => esc_html__( 'Full', 'pgs-core' ),
				)
			),
			'description' => esc_html__( 'Choose image size. If corresponding size is not available with the theme, then "ciyashop-latest-post-thumbnail" size will apply.', 'pgs-core' ),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'carousel_thumbnail_size',
				'value'   => array( 'default' ),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Custom', 'pgs-core' ),
			'description' => esc_html__( 'Enter image size. If corresponding size is not available with the theme, then "ciyashop-latest-post-thumbnail" size will apply.', 'pgs-core' ),
			'param_name'  => 'custom_img_size',
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'carousel_thumbnail_size',
				'value'   => array( 'custom' ),
			),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Pagination Control', 'pgs-core' ),
			'param_name'       => 'show_pagination_control',
			'description'      => esc_html__( 'Check this checkbox to display pagination controls.', 'pgs-core' ),
			'value'            => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'checkbox',
			'heading'          => esc_html__( 'Show Prev/Next Buttons', 'pgs-core' ),
			'param_name'       => 'show_prev_next_buttons',
			'description'      => esc_html__( 'Check this checkbox to display prev/next buttons.', 'pgs-core' ),
			'value'            => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label'      => true,
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Infinity Loop', 'pgs-core' ),
			'param_name'  => 'enable_infinity_loop',
			'description' => esc_html__( 'Check this checkbox to enable infinity loop and display carousel in circular loop.', 'pgs-core' ),
			'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => 'yes' ),
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view', 'pgs-core' ),
			'param_name'       => 'slides_per_view',
			'value'            => array_flip(
				array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				)
			),
			'std'              => '4',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 1200px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_md',
			'value'            => array_flip(
				array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
					'1' => '1',
				)
			),
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 992px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_sm',
			'value'            => array_flip(
				array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				)
			),
			'std'              => '3',
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 768px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_xs',
			'value'            => array_flip(
				array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				)
			),
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'             => 'dropdown',
			'heading'          => esc_html__( 'Slides per view ( < 480px)', 'pgs-core' ),
			'param_name'       => 'slides_per_view_xx',
			'value'            => array_flip(
				array(
					'1' => '1',
					'2' => '2',
				)
			),
			'description'      => esc_html__( 'Enter number of slides to display at the same time.', 'pgs-core' ),
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group'            => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'       => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'       => 'pgscore_html',
			'heading'    => esc_html__( 'Responsive slide counts', 'pgs-core' ),
			'param_name' => 'responsive_slide_counts_header',
			'html'       => '<h4>' . esc_html__( 'Note: Count entered in "Slides per view" will be used for device width above 1200px.', 'pgs-core' ) . '</h4>',
			'group'      => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency' => array(
				'element' => 'list_style',
				'value'   => 'slider',
			),
		),
		array(
			'type'        => 'pgscore_number_min_max',
			'heading'     => esc_html__( 'Margin', 'pgs-core' ),
			'param_name'  => 'slide_margin',
			'min'         => '0',
			'max'         => '50',
			'value'       => '0',
			'std'         => '30',
			'description' => esc_html__( 'Enter margin, in pixels (px), between each item.', 'pgs-core' ),
			'admin_label' => true,
			'group'       => esc_html__( 'Slider Settings', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'list_style',
				'value'   => 'slider',
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
		'name'                    => esc_html__( 'Image Slider', 'pgs-core' ),
		'description'             => esc_html__( 'Display image slider/carousel.', 'pgs-core' ),
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
