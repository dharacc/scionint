<?php
/**
 * Datepicker parameter for Visual Composer
 *
 * @package Custom_vc
 *
 * # Usage -
 * array(
 * 'type' => 'pgscore_datepicker',
 * )
 */

if ( function_exists( 'vc_add_shortcode_param' ) ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	vc_add_shortcode_param( 'pgscore_datepicker', 'pgscore_datepicker_settings_field', trailingslashit( PGSCORE_URL ) . 'js/pgscore_datepicker' . $suffix . '.js' );
}

/**
 * Parsing settings field.
 *
 * @param array $settings Settings array.
 * @param array $value    Values array.
 *
 * @return string
 */
function pgscore_datepicker_settings_field( $settings, $value ) {
	$class = isset( $settings['class'] ) ? $settings['class'] : '';

	$param_classes   = array();
	$param_classes[] = 'wpb_vc_param_value';
	$param_classes[] = 'wpb-input';
	$param_classes[] = 'wpb-textinput';
	$param_classes[] = 'wpb-datepicker';
	$param_classes[] = 'vc_datepicker';
	$param_classes[] = esc_attr( $settings['param_name'] );
	$param_classes[] = esc_attr( $settings['type'] ) . '_field';
	$param_classes[] = esc_attr( $class );
	$param_classes   = implode( ' ', array_filter( array_unique( $param_classes ) ) );

	ob_start();
	?>
	<div class="datepicker_block edit_form_line">
		<input name="<?php echo esc_attr( $settings['param_name'] ); ?>" class="<?php echo esc_attr( $param_classes ); ?>" value="<?php echo esc_attr( $value ); ?>" type="text">
	</div>
	<?php
	return ob_get_clean();
}
