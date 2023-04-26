<?php
if( function_exists( 'vc_add_shortcode_param' ) ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	
	/**
	 * array(
	 *     "param_name"    => "field_param_name",
	 *     'type'          => 'pgscore_radio',
	 * 	   "heading"       => esc_html__( "Field Heading", 'text-domain' ),
	 *     'description'   => esc_html__( 'Field Description.', 'text-domain' ),
	 * )
	 * */
	vc_add_shortcode_param( 'pgscore_radio', 'pgscore_radio_field', trailingslashit(PGSCORE_URL).'js/pgscore_radio'.$suffix.'.js' );
}
function pgscore_radio_field( $settings, $value ) {
	$output = '';
	
	$current_value= is_string( $value ) ? ( strlen( $value ) > 0 ? explode( ',', $value ) : array() ) : (array) $value;
	$values       = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'pgs-core' )=> 'true' );

	$param_name   = isset($settings['param_name'])? $settings['param_name']: '';
	$type         = isset($settings['type'])      ? $settings['type']      : '';
	$class        = isset($settings['class'])     ? $settings['class']     : '';
	
	$field_classes = array();
	$field_classes[] = 'wpb_vc_param_value';
	$field_classes[] = 'wpb-input';
	$field_classes[] = 'wpb-radio';
	$field_classes[] = 'pgscore_radio';
	$field_classes[] = $param_name;
	$field_classes[] = $type;
	$field_classes[] = $class;
	$field_classes = implode( ' ', array_filter( array_unique( $field_classes ) ) );
	
	if ( ! empty( $values ) ) {
		$output .= '<div class="pgscore_radio-wrap">';
		foreach ( $values as $label => $v ) {
			
			$checked = count( $current_value ) > 0 && in_array( $v, $current_value ) ? ' checked' : '';
			$radio_id = $param_name . '-' . $v;
			
			$output .= '<label class="vc_radio-label">';
			$output .= '<input type="radio" id="'.esc_attr($radio_id).'" value="'.esc_attr($v).'" class="'.esc_attr($field_classes).'" name="'.esc_attr($param_name).'"'.$checked.'>';
			$output .= '<span class="pgscore_radio-title">'.$label.'</span>';
			$output .= '</label>';
		}
		$output .= '</div>';
	}

	return $output;
}