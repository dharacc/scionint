<?php
function pgscore_element_classes( $atts ) {

	extract( $atts );

	$element_css_class = '';
	if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
		$element_css_class = vc_shortcode_custom_css_class( $element_css, ' ' );
	}

	if ( ! empty( $element_classes ) && is_array( $element_classes ) ) {
		$element_classes = implode( ' ', array_filter( array_unique( $element_classes ) ) );
	} else {
		$element_classes = '';
	}

	$element_classes_new = array(
		$shortcode_handle . '_wrapper', // Wrapper Class
		trim( $element_classes ),       // Custom Classes added as per conditions
		trim( $element_css_class ),     // Class added by element design options
		trim( $element_class ),         // Class(es) added by user from element editor
	);
	$element_classes_new = implode( ' ', array_filter( array_unique( $element_classes_new ) ) );

	echo esc_attr( $element_classes_new );
}
