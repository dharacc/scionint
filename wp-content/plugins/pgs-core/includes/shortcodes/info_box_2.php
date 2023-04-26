<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_info_box_2
 *
 ******************************************************************************/
function pgscore_shortcode_info_box_2( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'layout'                => 'style_1',
		'content_alignment'     => 'center',
		'icon_position'         => 'left',
		'add_anchor'            => false,
		'anchor_link'           => '',

		// Style 3 Options
		'background_options'    => 'border',
		'backround_img'         => '',
		'border_width'          => '5',
		'border_color'          => '#323232',
		'border_hover_color'    => '',
		'title_hover_color'     => '',
		'element_back_color'    => '',
		'element_hover_color'   => '',
		'description_color'     => '#323232',

		// Content
		'title'                 => '',
		'title_el'              => 'h3',
		'title_color'           => '#323232',
		'info_content'          => '',

		// Icon
		'icon_style'            => 'default', // default, border, flat
		'icon_size'             => 'md',
		'disable_animation'     => false,
		'icon_shape'            => 'square', // square, rounded, round

		// Icon - Background
		'icon_background_color' => '#878787',

		// Icon - Border
		'icon_border_color'     => '#878787',

		// Icon - Source
		'icon_source'           => 'font', // font, image

		// Icon - Type             = Image
		'icon_image'            => '',
		'image_link'            => '',

		// Icon - Type             = Font
		'icon_color'            => '#323232',
		'icon_type'             => 'fontawesome',
		'icon_fontawesome'      => 'fas fa-adjust',
		'icon_openiconic'       => 'vc-oi vc-oi-dial',
		'icon_typicons'         => 'typcn typcn-chevron-right',
		'icon_entypo'           => 'entypo-icon entypo-icon-note',
		'icon_linecons'         => 'vc_li vc_li-heart',
		'icon_monosocial'       => 'vc-mono vc-mono-fivehundredpx',
		'icon_material'         => 'vc-material vc-material-cake',
		'icon_pixelicons'       => 'vc_pixel_icon vc_pixel_icon-alert',
		'icon_flaticon'         => 'glyph-icon pgsicon-ecommerce-locked',
		'icon_themefy'          => 'ti-arrow-up',

		'element_css'           => '',
		'element_id'            => '',
		'element_class'         => '',
		'shortcode_handle'      => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );

	global $ciyashop_options;

	extract( $atts );

	// Return shortcode if no required content found to display the shortcode perfectly.
	if ( empty( $title ) && empty( $info_content ) ) {
		return;
	}

	/**********************************************************
	 *
	 * Icons Settings
	 *
	 **********************************************************/
	$icon_html    = '';
	$icon_class   = '';
	$icon_disable = false;
	$icon_wrapper = false;

	if ( isset( $icon_source ) && 'font' === $icon_source ) {
		$current_icon = 'icon_' . $icon_type;

		if ( isset( ${$current_icon} ) && ! empty( ${$current_icon} ) ) {
			if ( 'pixelicons' === $icon_type ) {
				$icon_wrapper = true;
			}
			$icon_class = ${$current_icon};
		}
	}

	if ( isset( $icon_class ) && empty( $icon_class ) ) {
		$icon_disable = true;
	}

	if ( false == $icon_disable ) {
		if ( isset( $icon_source ) && 'font' === $icon_source ) {
			if ( $icon_wrapper ) {
				$icon_html = '<i class="icon_wrap"><span class="' . esc_attr( $icon_class ) . '"></span></i>';
			} else {
				$icon_style = '';
				if ( in_array( $layout, array( 'style_1', 'style_2', 'style_3' ) ) ) {
					if ( isset( $icon_color ) && ! empty( $icon_color ) ) {
						$icon_style = ' style="color:' . esc_attr( $icon_color ) . ';"';
					}
				}
				$icon_html = '<i class="' . esc_attr( $icon_class ) . '"' . $icon_style . '></i>';
			}

			// Enqueue icon CSS for icon type
			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
				if ( 'fontawesome' !== $icon_type ) {
					vc_icon_element_fonts_enqueue( $icon_type );
				}
			}
		} elseif ( isset( $icon_source ) && 'image' === $icon_source ) {
			if ( ! empty( $icon_image ) ) {
				$banner_image = wp_get_attachment_image_src( $icon_image, 'pgscore-thumbnail-80' );
				if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
					$icon_html = '<img class="ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $banner_image[0] ) . '">';
				} else {
					$icon_html = '<img src="' . esc_url( $banner_image[0] ) . '">';
				}
			}
		} elseif ( isset( $icon_source ) && 'link' === $icon_source ) {
			if ( $image_link != '' ) {
				if ( isset( $ciyashop_options['enable_lazyload'] ) && $ciyashop_options['enable_lazyload'] && ! vc_is_inline() ) {
					$icon_html = '<img class="ciyashop-lazy-load" src="' . esc_url( LOADER_IMAGE ) . '" data-src="' . esc_url( $image_link ) . '">';
				} else {
					$icon_html = '<img src="' . esc_url( $image_link ) . '">';
				}
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
	$pgscore_shortcodes[ $shortcode_handle ]['atts']      = $atts;
	$pgscore_shortcodes[ $shortcode_handle ]['icon_html'] = $icon_html;
	ob_start();
	?>
	<div <?php pgscore_shortcode_id( $atts ); ?> class="<?php pgscore_element_classes( $atts, 'info_box_2' ); ?>"><!-- shortcode-base-wrapper -->
		<?php pgscore_get_shortcode_templates( 'info_box_2/content' ); ?>
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

	$shortcode_fields = array_merge(
		array(
			array(
				'type'             => 'pgscore_radio_image2',
				'heading'          => esc_html__( 'Layout', 'pgs-core' ),
				'param_name'       => 'layout',
				'edit_field_class' => 'infobox-2 pgscore_radio_image2',
				'options'          => array(
					array(
						'value' => 'style_1',
						'title' => 'Style 1',
						'image' => PGSCORE_URL . 'images/shortcodes/info_box_2/style_1.png',
					),
					array(
						'value' => 'style_2',
						'title' => 'Style 2',
						'image' => PGSCORE_URL . 'images/shortcodes/info_box_2/style_2.png',
					),
					array(
						'value' => 'style_3',
						'title' => 'Style 3',
						'image' => PGSCORE_URL . 'images/shortcodes/info_box_2/style_3.png',
					),
				),
				'dependency'       => array(
					'callback' => 'vcCiyaShopCustomIconDependencyCallback',
				),
				'show_label'       => true,
				'admin_label'      => true,
			),
			array(
				'type'             => 'pgscore_radio',
				'heading'          => esc_html__( 'Content Alignment', 'pgs-core' ),
				'param_name'       => 'content_alignment',
				'value'            => array_flip(
					array(
						'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
						'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
						'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
					)
				),
				'std'              => 'center',
				'class'            => 'pgscore_radio_label_only',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'save_always'      => true,
				'dependency'       => array(
					'element' => 'layout',
					'value'   => array( 'style_1', 'style_3' ),
				),
			),
			array(
				'type'             => 'pgscore_radio',
				'heading'          => esc_html__( 'Icon Position', 'pgs-core' ),
				'param_name'       => 'icon_position',
				'value'            => array_flip(
					array(
						'left'  => '<i class="dashicons dashicons-editor-outdent"></i>',
						'right' => '<i class="dashicons dashicons-editor-indent"></i>',
					)
				),
				'std'              => 'left',
				'class'            => 'pgscore_radio_label_only',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'save_always'      => true,
				'dependency'       => array(
					'element' => 'layout',
					'value'   => array( 'style_2' ),
				),
			),

			/*---------------------------- Content ----------------------------*/
			array(
				'type'        => 'textfield',
				'param_name'  => 'title',
				'heading'     => esc_html__( 'Title', 'pgs-core' ),
				'admin_label' => true,
				'save_always' => true,
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Add link to title?', 'pgs-core' ),
				'param_name'  => 'add_anchor',
				'description' => esc_html__( 'Add anchor tag for title?', 'pgs-core' ),
				'std'         => false,
				'save_always' => true,
				'admin_label' => true,
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'vc_link',
				'class'       => '',
				'heading'     => esc_html__( 'Link', 'pgs-core' ),
				'param_name'  => 'anchor_link',
				'description' => esc_html__( 'Enter title link.', 'pgs-core' ),
				'save_always' => true,
				'dependency'  => array(
					'element' => 'add_anchor',
					'value'   => 'true',
				),
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'dropdown',
				'param_name'  => 'title_el',
				'heading'     => esc_html__( 'Title Element Tag', 'pgs-core' ),
				'description' => esc_html__( 'Select title element tag.', 'pgs-core' ),
				'std'         => 'h3',
				'value'       => array_flip(
					array(
						'h2' => esc_html__( 'H2', 'pgs-core' ),
						'h3' => esc_html__( 'H3', 'pgs-core' ),
						'h4' => esc_html__( 'H4', 'pgs-core' ),
						'h5' => esc_html__( 'H5', 'pgs-core' ),
						'h6' => esc_html__( 'H6', 'pgs-core' ),
					)
				),
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'title_color',
				'heading'     => esc_html__( 'Title Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title color.', 'pgs-core' ),
				'value'       => '#323232',
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Description', 'pgs-core' ),
				'class'       => '',
				'value'       => '',
				'param_name'  => 'info_content',
				'show_label'  => true,
				'admin_label' => true,
				'save_always' => true,
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'description_color',
				'heading'     => esc_html__( 'Description Color', 'pgs-core' ),
				'description' => esc_html__( 'Select Description color.', 'pgs-core' ),
				'value'       => '#323232',
				'group'       => esc_html__( 'Content', 'pgs-core' ),
			),

			/*--------------------------- Image - Style 3 ----------------------*/
			array(
				'type'             => 'dropdown',
				'param_name'       => 'background_options',
				'heading'          => esc_html__( 'Background Options', 'pgs-core' ),
				'description'      => esc_html__( 'Select Option.', 'pgs-core' ),
				'group'            => esc_html__( 'Background Options', 'pgs-core' ),
				'std'              => 'md',
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'save_always'      => true,
				'value'            => array_flip(
					array(
						'border'   => esc_html__( 'Border Color', 'pgs-core' ),
						'back_img' => esc_html__( 'Background Color', 'pgs-core' ),
					)
				),
				'dependency'       => array(
					'element' => 'layout',
					'value'   => array( 'style_3' ),
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'title_hover_color',
				'heading'     => esc_html__( 'Title Hover Color', 'pgs-core' ),
				'description' => esc_html__( 'Select title hove color.', 'pgs-core' ),
				'value'       => '#04d39f',
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'save_always' => true,
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'back_img',
				),
			),
			array(
				'type'        => 'attach_image',
				'param_name'  => 'backround_img',
				'heading'     => esc_html__( 'Background Image', 'pgs-core' ),
				'description' => esc_html__( 'Upload only icon image types like ".jpg, .jpeg, .png, .gif". No other types are supported.', 'pgs-core' ),
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'save_always' => true,
				'dependency'  => array(
					'element' => 'layout',
					'value'   => array( 'style_3' ),
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'element_back_color',
				'heading'     => esc_html__( 'Background Color', 'pgs-core' ),
				'description' => esc_html__( 'Select background hover color.', 'pgs-core' ),
				'value'       => '#F5F5F5',
				'save_always' => true,
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'back_img',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'element_hover_color',
				'heading'     => esc_html__( 'Background Hover Color', 'pgs-core' ),
				'description' => esc_html__( 'Select element hover color.', 'pgs-core' ),
				'value'       => '#323232',
				'save_always' => true,
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'back_img',
				),
			),
			array(
				'type'        => 'pgscore_number_min_max',
				'heading'     => esc_html__( 'Border Width', 'pgs-core' ),
				'param_name'  => 'border_width',
				'min'         => '1',
				'max'         => '10',
				'value'       => '5',
				'description' => esc_html__( 'Enter border width between 1 to 10.', 'pgs-core' ),
				'admin_label' => true,
				'save_always' => true,
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'border',
				),
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'border_color',
				'heading'     => esc_html__( 'Border Color', 'pgs-core' ),
				'description' => esc_html__( 'Select border color.', 'pgs-core' ),
				'value'       => '#F5F5F5',
				'save_always' => true,
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'border',
				),
			),
			array(
				'type'        => 'colorpicker',
				'param_name'  => 'border_hover_color',
				'heading'     => esc_html__( 'Border Hover Color', 'pgs-core' ),
				'description' => esc_html__( 'Select border hover color.', 'pgs-core' ),
				'value'       => '#04d39f',
				'save_always' => true,
				'group'       => esc_html__( 'Background Options', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'background_options',
					'value'   => 'border',
				),
			),

			/*---------------------------- Icon ----------------------------*/
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Style', 'pgs-core' ),
				'param_name'       => 'icon_style',
				'value'            => array_flip(
					array(
						'default' => esc_html__( 'Default', 'pgs-core' ),
						'flat'    => esc_html__( 'Flat', 'pgs-core' ),
						'border'  => esc_html__( 'Border', 'pgs-core' ),
					)
				),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column vc_column-with-padding',
				'dependency'       => array(
					'element'            => 'layout',
					'value_not_equal_to' => 'style_3',
				),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Size', 'pgs-core' ),
				'param_name'       => 'icon_size',
				'description'      => esc_html__( 'Select icon size.', 'pgs-core' ),
				'value'            => array_flip(
					array(
						'xs'  => esc_html__( 'Extra Small', 'pgs-core' ),
						'sm'  => esc_html__( 'Small', 'pgs-core' ),
						'md'  => esc_html__( 'Medium', 'pgs-core' ),
						'lg'  => esc_html__( 'Large', 'pgs-core' ),
						'xlg' => esc_html__( 'Extra Large', 'pgs-core' ),
					)
				),
				'std'              => 'md',
				'admin_label'      => true,
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'element'            => 'layout',
					'value_not_equal_to' => 'style_3',
				),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Disable Animation?', 'pgs-core' ),
				'param_name'  => 'disable_animation',
				'description' => esc_html__( 'Check this checkbox to disable icon animation.', 'pgs-core' ),
				'value'       => array( esc_html__( 'Yes', 'pgs-core' ) => true ),
				'std'         => false,
				'group'       => esc_html__( 'Icon', 'pgs-core' ),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Shape', 'pgs-core' ),
				'param_name'       => 'icon_shape',
				'description'      => 'Select icon shape.',
				'value'            => array_flip(
					array(
						'square'  => esc_html__( 'Square', 'pgs-core' ),
						'rounded' => esc_html__( 'Rounded', 'pgs-core' ),
						'round'   => esc_html__( 'Round', 'pgs-core' ),
					)
				),
				'std'              => 'square',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'element' => 'icon_style',
					'value'   => array( 'flat', 'border' ),
				),
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Background Color', 'pgs-core' ),
				'param_name'       => 'icon_background_color',
				'description'      => esc_html__( 'Select icon background color.', 'pgs-core' ),
				'value'            => '#ccc',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'value'   => array( 'flat' ),
					'element' => 'icon_style',
				),
			),
			array(
				'type'             => 'colorpicker',
				'heading'          => esc_html__( 'Border Color', 'pgs-core' ),
				'param_name'       => 'icon_border_color',
				'description'      => esc_html__( 'Select border color.', 'pgs-core' ),
				'value'            => '#ccc',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-4 vc_column',
				'dependency'       => array(
					'element' => 'icon_style',
					'value'   => array( 'border' ),
				),
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Icon Source', 'pgs-core' ),
				'param_name'       => 'icon_source',
				'value'            => array_flip(
					array(
						'font'  => esc_html__( 'Font', 'pgs-core' ),
						'image' => esc_html__( 'Image', 'pgs-core' ),
						'link'  => esc_html__( 'External Link', 'pgs-core' ),
					)
				),
				'std'              => 'font',
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-12 vc_column',
				'class'            => 'pgscore_radio_label_only',
				'save_always'      => true,
				'admin_label'      => true,
				'dependency'       => array(
					'element'            => 'layout',
					'value_not_equal_to' => 'style_3',
				),
			),
			array(
				'type'             => 'attach_image',
				'param_name'       => 'icon_image',
				'heading'          => esc_html__( 'Icon Image', 'pgs-core' ),
				'description'      => esc_html__( 'We recommended upload image size 80x80', 'pgs-core' ),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'save_always'      => true,
				'dependency'       => array(
					'element' => 'icon_source',
					'value'   => 'image',
				),
			),
			array(
				'type'             => 'textfield',
				'param_name'       => 'image_link',
				'heading'          => esc_html__( 'Image Link', 'pgs-core' ),
				'description'      => esc_html__( 'Please enter image external link', 'pgs-core' ),
				'group'            => esc_html__( 'Icon', 'pgs-core' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'save_always'      => true,
				'dependency'       => array(
					'element' => 'icon_source',
					'value'   => 'link',
				),
			),
			array(
				'type'        => 'colorpicker',
				'heading'     => esc_html__( 'Icon Color', 'pgs-core' ),
				'param_name'  => 'icon_color',
				'description' => esc_html__( 'Select icon color.', 'pgs-core' ),
				'value'       => '#323232',
				'group'       => esc_html__( 'Icon', 'pgs-core' ),
				'dependency'  => array(
					'element' => 'icon_source',
					'value'   => 'font',
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
				'settings'    => array(),
				'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Extra class name', 'pgs-core' ),
				'param_name'  => 'element_class',
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'pgs-core' ),
				'group'       => esc_html__( 'ID/Class', 'pgs-core' ),
			),

		),
		pgscore_iconpicker(
			array(
				'dependency' => array(
					'element' => 'icon_source',
					'value'   => 'font',
				),
				'group'      => esc_html__( 'Icon', 'pgs-core' ),
			)
		)
	);

	// Params
	$params = array(
		'name'                    => esc_html__( 'Info Box 2', 'pgs-core' ),
		'description'             => esc_html__( 'Information box with icon and link.', 'pgs-core' ),
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
