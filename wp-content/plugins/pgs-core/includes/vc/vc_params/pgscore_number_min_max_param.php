<?php
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'pgscore_number_min_max', 'pgscore_number_min_max_field' );
}
function pgscore_number_min_max_field( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';

	$min  = isset( $settings['min'] ) ? $settings['min'] : '';
	$max  = isset( $settings['max'] ) ? $settings['max'] : '';
	$step = isset( $settings['step'] ) ? $settings['step'] : '';

	$suffix = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
	$class  = isset( $settings['class'] ) ? $settings['class'] : '';

	$defaults = array(
		'min'    => 0,
		'max'    => 100,
		'step'   => 1,
		'value'  => 0,
		'prefix' => '',
		'suffix' => '',
		'class'  => '',
	);
	$settings = wp_parse_args( $settings, $defaults );
	$value    = ( null == $value ) ? $settings['value'] : $value;

	$output = '';

	$output .= '<div class="pgscore_number_min_max_input_group">';

	if ( ! empty( $settings['prefix'] ) ) {
		$output .= '<div class="pgscore_number_min_max_input_group_addon">' . $settings['prefix'] . '</div>';
	}

	$field_classes   = array();
	$field_classes[] = 'wpb_vc_param_value';
	$field_classes[] = 'pgscore_number_min_max_input';
	$field_classes[] = $settings['param_name'];
	$field_classes[] = $settings['type'];
	$field_classes[] = $settings['class'];
	$field_classes   = implode( ' ', array_filter( array_unique( $field_classes ) ) );

	$output .= '<input
		type="number"
		min="' . esc_attr( $settings['min'] ) . '"
		max="' . esc_attr( $settings['max'] ) . '"
		step="' . esc_attr( $settings['step'] ) . '"
		class="' . esc_attr( $field_classes ) . '"
		name="' . esc_attr( $settings['param_name'] ) . '"
		value="' . esc_attr( $value ) . '"
	/>';

	if ( ! empty( $settings['suffix'] ) ) {
		$output .= '<div class="pgscore_number_min_max_input_group_addon">' . $settings['suffix'] . '</div>';
	}

	$output .= '</div>';
	return $output;
}

function pgscore_number_min_max_field_old( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$type       = isset( $settings['type'] ) ? $settings['type'] : '';
	$min        = isset( $settings['min'] ) ? $settings['min'] : '';
	$max        = isset( $settings['max'] ) ? $settings['max'] : '';
	$step       = isset( $settings['step'] ) ? $settings['step'] : '';
	$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';
	$class      = isset( $settings['class'] ) ? $settings['class'] : '';
	$output     = '<input type="number" min="' . $min . '" max="' . $max . '" step="' . $step . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" style="max-width:200px; margin-right: 10px;" />' . $suffix;
	return $output;
}
