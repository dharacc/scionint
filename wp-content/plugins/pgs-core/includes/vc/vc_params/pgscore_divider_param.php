<?php
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'pgscore_divider', 'pgscore_divider_settings' );
}
function pgscore_divider_settings( $settings, $value ) {
	$title    = isset( $settings['title'] ) ? '<div class="wpb_element_label pgscore-vc-divider">' . $settings['title'] . '</div>' : '';
	$subtitle = isset( $settings['subtitle'] ) ? '<span class="vc_description vc_clearfix">' . $settings['subtitle'] . '</span>' : '';

	$input = '<input id="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" value="" type="hidden">';
	if ( isset( $settings['advanced'] ) ) {
		$input = '<label class="pgscore-vc-advanced-wrap pgscore-advanced-field">' . esc_html__( 'Advanced Settings', 'pgs-core' ) . '<input id="' . esc_attr( $settings['param_name'] ) . '-true" class="wpb_vc_param_value pgscore-vc-advanced ' . esc_attr( $settings['param_name'] ) . ' checkbox" name="' . esc_attr( $settings['param_name'] ) . '" ' . checked( $value, 'true', false ) . ' value="true" type="checkbox"></label>';
	}

	return $input . $title . $subtitle;
}
