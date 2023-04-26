<?php
function pgscore_vc_link_attr( $shortcode_url_vars, $classes = '', $additional_url_vars = array() ) {

	if ( empty( $shortcode_url_vars ) ) {
		return '';
	}

	$url_vars = ( function_exists( 'vc_build_link' ) ) ? vc_build_link( $shortcode_url_vars ) : pgscore_vc_build_link( $shortcode_url_vars );

	$link_attr = array();
	$url_stat  = false;

	if ( ! empty( $url_vars ) && is_array( $url_vars ) && ( isset( $url_vars['url'] ) && '' != $url_vars['url'] ) ) {

		if ( isset( $url_vars['target'] ) && '' != $url_vars['target'] && $url_vars['target'] == ' _blank' ) {
			if ( isset( $url_vars['rel'] ) && '' != $url_vars['rel'] ) {
				$url_vars['rel'] = $url_vars['rel'] . ' noopener';
			} else {
				$url_vars['rel'] = 'noopener';
			}
		}

		foreach ( $url_vars as $url_var_k => $url_var_v ) {
			if ( ! empty( $url_var_v ) ) {
				if ( 'url' == $url_var_k ) {
					$url_stat         = true;
					$link_attr['url'] = 'href="' . esc_url( $url_var_v ) . '"';
				} else {
					$link_attr[ $url_var_k ] = $url_var_k . '="' . esc_attr( $url_var_v ) . '"';
				}
			}
		}
	}

	if ( ! empty( $additional_url_vars ) && $url_stat ) {
		// prepare additional_url_vars
		unset( $additional_url_vars['url'] );
		unset( $additional_url_vars['class'] );

		// escaping additional_url_vars
		foreach ( $additional_url_vars as $additional_url_vars_k => $additional_url_vars_v ) {
			if ( ! empty( $additional_url_vars_v ) ) {
				$additional_url_vars[ $additional_url_vars_k ] = $additional_url_vars_k . '="' . esc_attr( $additional_url_vars_v ) . '"';
			}
		}
		$link_attr = array_merge( $link_attr, $additional_url_vars );
	}

	if ( ! empty( $classes ) && $url_stat ) {
		if ( is_array( $classes ) ) {
			$classes = implode( ' ', array_filter( array_unique( $classes ) ) );
		}
		$link_attr['class'] = 'class="' . esc_attr( $classes ) . '"';
	}

	if ( is_array( $link_attr ) && ! empty( $link_attr ) ) {
		$link_attr = implode( ' ', array_filter( array_unique( $link_attr ) ) );
	} else {
		$link_attr = false;
	}
	return $link_attr;
}
