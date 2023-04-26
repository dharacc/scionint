<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}

/******************************************************************************
 *
 * Shortcode : pgscore_html_block
 *
 ******************************************************************************/
function pgscore_shortcode_html_block( $atts, $content = null, $shortcode_handle = '' ) {

	$default_atts = array(
		'html_block_id'    => '',
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
		<?php pgscore_get_shortcode_templates( 'html_block/content' ); ?>
	</div>
	<?php
	return ob_get_clean();
}

/******************************************************************************
 *
 * Visual Composer Integration
 *
 ******************************************************************************/

$shortcode_fields = array(
	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Static Block', 'pgs-core' ),
		'param_name'  => 'html_block_id',
		'description' => esc_html__( 'Select Static Block to display.', 'pgs-core' ),
		'value'       => array_flip( pgscore_get_static_blocks() ),
		'admin_label' => true,
	),
);

// Params
$params = array(
	'name'                    => esc_html__( 'Static Block', 'pgs-core' ),
	'description'             => esc_html__( 'Add Static blocks.', 'pgs-core' ),
	'base'                    => $shortcode_tag,
	'class'                   => 'pgscore_element_wrapper',
	'controls'                => 'full',
	'icon'                    => PGSCORE_URL . '/images/vc-icon.png',
	'category'                => esc_html__( 'Potenza Core', 'pgs-core' ),
	'show_settings_on_create' => true,
	'params'                  => $shortcode_fields,
);

if ( function_exists( 'vc_map' ) ) {
	vc_map( $params );
}
