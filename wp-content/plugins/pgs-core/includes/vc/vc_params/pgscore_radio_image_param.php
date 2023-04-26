<?php
/**
 * Radio image parameter for Visual Composer
 *
 * @package Custom_vc
 *
 * # Usage -
 * array(
 * 'type' => 'radio_image_select',
 * 'options' => array(
 *           'image-1' => '../assets/images/patterns/01.png',
 *           'image-2' => '../assets/images/patterns/02.png',
 * ),
 * )
 */

if ( function_exists( 'vc_add_shortcode_param' ) ) {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	vc_add_shortcode_param( 'pgscore_radio_image', 'pgscore_radio_image_settings_field', trailingslashit( PGSCORE_URL ) . 'js/pgscore_radio_image' . $suffix . '.js' );
}

/**
 * Parsing settings field.
 *
 * @param array $settings Settings array.
 * @param array $value    Values array.
 *
 * @return string
 */
function pgscore_radio_image_settings_field( $settings, $value ) {
	$options = isset( $settings['options'] ) && is_array( $settings['options'] ) && ! empty( $settings['options'] ) ? $settings['options'] : array();

	$class = isset( $settings['class'] ) ? $settings['class'] : '';

	$output     = $selected = '';
	$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );

	$select_attrs = array();

	// Classes
	$select_classes   = array();
	$select_classes[] = 'vc_radio_select wpb_vc_param_value wpb-input wpb-select';
	$select_classes[] = esc_attr( $class );
	$select_classes[] = esc_attr( $settings['param_name'] );
	$select_classes[] = esc_attr( $settings['type'] );
	$select_classes[] = esc_attr( $css_option );

	$select_classes = implode( ' ', array_filter( array_unique( $select_classes ) ) );

	$data_show_label  = isset( $settings['show_label'] ) && is_bool( $settings['show_label'] ) ? ( ( true === $settings['show_label'] ) ? 'true' : 'false' ) : 'false';
	$data_hide_select = isset( $settings['hide_select'] ) && is_bool( $settings['hide_select'] ) ? ( ( true === $settings['hide_select'] ) ? 'true' : 'false' ) : 'true';

	$select_attrs['name']             = 'name="' . esc_attr( $settings['param_name'] ) . '"';
	$select_attrs['class']            = 'class="' . esc_attr( $select_classes ) . '"';
	$select_attrs['data-option']      = 'data-option="' . esc_attr( $css_option ) . '"';
	$select_attrs['data-show_label']  = 'data-show_label="' . esc_attr( $data_show_label ) . '"';
	$select_attrs['data-hide_select'] = 'data-hide_select="' . esc_attr( $data_hide_select ) . '"';

	$select_attr = '';
	$select_attr = implode( ' ', array_filter( array_unique( $select_attrs ) ) );

	$output .= '<select ' . $select_attr . '>';

	foreach ( $options as $key => $val ) {
		if ( '' !== $css_option && $css_option === $key ) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}

		$tooltip     = $key;
		$img_url     = $val;
		$option_name = ucwords( str_replace( array( '-', '_' ), ' ', $key ) );

		$output .= '<option data-tooltip="' . esc_attr( $tooltip ) . '"  data-img-label="' . esc_attr( $option_name ) . '" data-img-src="' . esc_url( $img_url ) . '"  value="' . esc_attr( $key ) . '" ' . $selected . '>' . $option_name . '</option>';
	}

	$output .= '</select>';

	return $output;
}
