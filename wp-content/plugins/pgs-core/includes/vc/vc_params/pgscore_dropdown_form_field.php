<?php
/**
 * Radio image parameter for Visual Composer
 *
 * @package Custom_vc
 *
 * # Usage -
 * array(
 *     'type' => 'pgscore_dropdown',
 *     'multiple' => true,
 *     'select2' => array(
 *         'placeholder'=> "Select Categories",
 *         'allowClear' => true,
 *      ),
 *     'options' => array(
 *         'image-1' => '../assets/images/patterns/01.png',
 *         'image-2' => '../assets/images/patterns/02.png',
 *     ),
 * )
 */

if ( function_exists( 'vc_add_shortcode_param' ) ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	vc_add_shortcode_param( 'pgscore_dropdown', 'pgscore_dropdown_field_settings', trailingslashit( PGSCORE_URL ) . 'js/pgscore_dropdown' . $suffix . '.js' );
}

/**
 * Dropdown(select with options) shortcode attribute type generator.
 *
 * @param $settings
 * @param $value
 *
 * @since 4.4
 * @return string - html string.
 */
function pgscore_dropdown_field_settings( $settings, $value, $tag ) {
	$output = '';

	echo $settings['param_name'] . ':';
	var_dump( $value );

	$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );

	$field_attrs   = array();
	$field_classes = array();

	// Attributes
	$field_attrs['name']        = 'name="' . esc_attr( $settings['param_name'] ) . '"';
	$field_attrs['data-option'] = 'data-option="' . esc_attr( $css_option ) . '"';
	if ( $settings['multiple'] ) {
		$field_attrs['multiple'] = 'multiple';
	}

	// Classes
	$field_classes[] = 'wpb_vc_param_value wpb-input wpb-select';
	$field_classes[] = isset( $settings['class'] ) ? esc_attr( $settings['class'] ) : '';
	$field_classes[] = esc_attr( $settings['param_name'] );
	$field_classes[] = esc_attr( $settings['type'] );
	$field_classes[] = esc_attr( $css_option );

	$allow_clear = false;
	$placeholder = esc_html__( 'Select an option', 'pgs-core' );

	$select2_options = array(
		'placeholder' => $placeholder,
		'allowClear'  => true,
	);

	// Select 2
	if ( isset( $settings['select2'] ) && false !== $settings['select2'] ) {

		$field_classes[] = 'pgscore_dropdown-select2';

		if ( is_array( $settings['select2'] ) && ! empty( $settings['select2'] ) ) {
			$select2_options = wp_parse_args( $settings['select2'], $select2_options );
		}

		if ( isset( $select2_options['allowClear'] ) ) {
			$allow_clear = $select2_options['allowClear'];
		}
		$select2_options                     = json_encode( $select2_options );
		$field_attrs['data-select2_options'] = 'data-select2_options="' . esc_attr( $select2_options ) . '"';
	}

	// format classes
	$field_classes        = implode( ' ', array_filter( array_unique( $field_classes ) ) );
	$field_attrs['class'] = 'class="' . esc_attr( $field_classes ) . '"';

	// format attributes
	$field_attrs = implode( ' ', array_filter( array_unique( $field_attrs ) ) );

	$output .= '<select ' . $field_attrs . '>';

	if ( ! empty( $value ) && ! is_array( $value ) ) {
		$current_value = strlen( $value ) > 0 ? explode( ',', $value ) : array();
	}

	if ( ! empty( $settings['value'] ) ) {

		if ( $allow_clear ) {
			$value_null[ $placeholder ] = '';
			$settings['value']          = array_merge( $value_null, $settings['value'] );
		}

		foreach ( $settings['value'] as $index => $data ) {
			$option_value = $data;
			$option_label = $index;
			$selected     = count( $current_value ) > 0 && in_array( $option_value, $current_value ) ? ' selected="selected"' : '';

			$option_class = str_replace( '#', 'hash-', $option_value );
			$output      .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>' . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$output .= '</select>';

	return $output;
}
