<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_newsletter
 *
 ******************************************************************************/
function pgscore_shortcode_newsletter( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'style'             => '',
		'newsletter_design' => '',
		'title'             => '',
		'description'       => '',
		'content_alignment' => 'right',
		'bg_type'           => 'light',
		'element_css'       => '',
		'element_id'        => '',
		'element_class'     => '',
		'shortcode_handle'  => $shortcode_handle,
	);

	$atts = shortcode_atts( $default_atts, $atts, $shortcode_handle );
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
		<?php pgscore_get_shortcode_templates( 'newsletter/content' ); ?>
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
			'type'           => 'pgscore_notice',
			'param_name'     => 'banner_notice_warning',
			'notice_type'    => 'warning',
			'heading'        => esc_html__( 'Important Note', 'pgs-core' ),
			'message'        => esc_html__( 'MailChimp API key and List ID settings are moved in Theme Options. So, please update settings over there.', 'pgs-core' ),
			'display_header' => true,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'pgs-core' ),
			'param_name'  => 'style',
			'value'       => array(
				esc_html__( 'Style 1', 'pgs-core' ) => 'style-1',
				esc_html__( 'Style 2', 'pgs-core' ) => 'style-2',
				esc_html__( 'Style 3', 'pgs-core' ) => 'style-3',
			),
			'default'     => 'style-1',
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'pgscore_radio_image2',
			'param_name'  => 'newsletter_design',
			'heading'     => esc_html__( 'Newsletter Designs', 'pgs-core' ),
			'description' => esc_html__( 'Select style.', 'pgs-core' ),
			'options'     => array(
				array(
					'value' => 'design-1',
					'title' => 'Design 1',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_1.jpg',
				),
				array(
					'value' => 'design-2',
					'title' => 'Design 2',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_2.jpg',
				),
				array(
					'value' => 'design-3',
					'title' => 'Design 3',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_3.jpg',
				),
				array(
					'value' => 'design-4',
					'title' => 'Design 4',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_4.jpg',
				),
				array(
					'value' => 'design-5',
					'title' => 'Design 5',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_5.jpg',
				),
				array(
					'value' => 'design-6',
					'title' => 'Design 6',
					'image' => PGSCORE_URL . 'images/shortcodes/newsletter/style_6.jpg',
				),
			),
			'description' => esc_html__( 'Select the newsletter design', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'style',
				'value'   => 'style-1',
			),
			'value'       => 'design-1',
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'class'       => 'pgscore_newsletter_title',
			'heading'     => esc_html__( 'Title', 'pgs-core' ),
			'description' => esc_html__( 'Enter title here', 'pgs-core' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Description', 'pgs-core' ),
			'param_name'  => 'description',
			'description' => esc_html__( 'Enter description. Please ensure to add short content.', 'pgs-core' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Content Alignment', 'pgs-core' ),
			'param_name'  => 'content_alignment',
			'value'       => array(
				esc_html__( 'Right', 'pgs-core' )  => 'right',
				esc_html__( 'Center', 'pgs-core' ) => 'center',
				esc_html__( 'Left', 'pgs-core' )   => 'left',
			),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'style',
				'value'   => 'style-2',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Content Background', 'pgs-core' ),
			'param_name'  => 'bg_type',
			'value'       => array(
				esc_html__( 'Light', 'pgs-core' ) => 'light',
				esc_html__( 'Dark', 'pgs-core' )  => 'dark',
			),
			'admin_label' => true,
			'dependency'  => array(
				'element' => 'style',
				'value'   => 'style-2',
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
		'name'                    => esc_html__( 'Newsletter', 'pgs-core' ),
		'description'             => esc_html__( 'Display mailchimp newsletter form.', 'pgs-core' ),
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
