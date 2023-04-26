<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_countdown
 *
 ******************************************************************************/
function pgscore_shortcode_countdown( $atts, $content = null, $shortcode_handle = '' ) {
	$default_atts = array(
		'countdown_date'   => '',
		'expire_message'   => esc_html__( 'This offer has expired!', 'pgs-core' ),
		'counter_style'    => 'flat',
		'element_css'      => '',
		'element_id'       => '',
		'element_class'    => '',
		'shortcode_handle' => $shortcode_handle,
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
		<?php pgscore_get_shortcode_templates( 'countdown/content' ); ?>
	</div><!-- shortcode-base-wrapper-end -->
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
			'type'        => 'pgscore_datepicker',
			'class'       => '',
			'heading'     => esc_html__( 'Countdown Date', 'pgs-core' ),
			'param_name'  => 'countdown_date',
			'value'       => '',
			'description' => esc_html__( 'Enter coundown date.', 'pgs-core' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Expire Message', 'pgs-core' ),
			'param_name'  => 'expire_message',
			'value'       => esc_html__( 'This offer has expired!', 'pgs-core' ),
			'description' => esc_html__( 'Enter message to display, instead of date counter, when deal is expired.', 'pgs-core' ),
		),
		array(
			'type'        => 'pgscore_radio_image',
			'heading'     => esc_html__( 'Countdown Style', 'pgs-core' ),
			'description' => esc_html__( 'Select countdown style.', 'pgs-core' ),
			'param_name'  => 'counter_style',
			'options'     => array(
				'style-1'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_1.jpg',
				'style-2'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_2.jpg',
				'style-3'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_3.jpg',
				'style-4'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_4.jpg',
				'style-5'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_5.jpg',
				'style-6'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_6.jpg',
				'style-7'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_7.jpg',
				'style-8'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_8.jpg',
				'style-9'  => PGSCORE_URL . 'images/shortcodes/banner/deal/style_9.jpg',
				'style-10' => PGSCORE_URL . 'images/shortcodes/banner/deal/style_10.jpg',
			),
			'show_label'  => true,
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
		'name'                    => esc_html__( 'Countdown', 'pgs-core' ),
		'description'             => esc_html__( 'Add Countdown.', 'pgs-core' ),
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
