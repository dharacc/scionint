<?php
if( function_exists('vc_add_shortcode_param') ){
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	vc_add_shortcode_param( 'pgscore_range_slider', 'pgscore_helper_range_slider_field', trailingslashit(PGSCORE_URL) . 'js/pgscore_range_slider'.$suffix.'.js' );
}
function pgscore_helper_range_slider_field( $settings, $value ) {
	$defaults = array(
		'min'        => 0,
		'max'        => 100,
		'step'       => 1,
		'value'      => 0,
		'unit'       => '',
		'fill'       => true,
		'hide_input' => false
	);
	$settings = wp_parse_args( $settings, $defaults );
	$value = ($value == null) ? $settings[ 'value' ] : $value;

	$slider = '<div class="pgscore-vc-range-slider' . ( $settings[ 'hide_input' ] ? ' pgscore-hide-input' : '' ) . ( $settings[ 'fill' ] ? ' pgscore-fill' : '' ) . '">';
		$slider .= '<div class="pgscore-range-slider" data-min="' . esc_attr( $settings[ 'min' ] ) . '" data-max="' . esc_attr( $settings[ 'max' ] ) . '" data-step="' . esc_attr( $settings[ 'step' ] ) . '" data-value="' . esc_attr( $value ) . '"></div>';
	$slider .= '</div>';

	$input = '<input class="pgscore-value wpb_vc_param_value wpb-input ' . esc_attr( $settings[ 'param_name' ] ) . '" name="' . esc_attr( $settings[ 'param_name' ] ) . '" value="' . esc_attr( $value ) . '" type="text" />';

	$unit = $settings[ 'unit' ] != '' ? '<span class="pgscore-unit">' . $settings[ 'unit' ] . '</span>' : '';

	return '<div class="pgscore-range-slider-wrap">' . $slider . $unit . $input . '</div>';
}
