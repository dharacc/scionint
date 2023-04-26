<?php
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'pgscore_notice', 'pgscore_notice_field' );
}
function pgscore_notice_field( $settings, $value ) {

	$param_name     = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
	$notice_type    = isset( $settings['notice_type'] ) ? $settings['notice_type'] : 'info';
	$display_header = isset( $settings['display_header'] ) ? $settings['display_header'] : false;
	$heading        = isset( $settings['heading'] ) ? $settings['heading'] : '';
	$message        = isset( $settings['message'] ) ? $settings['message'] : '';

	$notice_types = array(
		'info',
		'warning',
		'error',
		'success',
	);

	if ( ! in_array( $notice_type, $notice_types ) ) {
		$notice_type = 'info';
	}

	$notice_class = 'pgscore_notice_wrapper notice notice-' . $notice_type;

	$output = '';

	if ( $message ) {
		$output .= sprintf(
			'<div class="%1$s">%2$s<p>%3$s</p></div>',
			esc_attr( $notice_class ),
			( $display_header && $heading ) ? '<h2 class="pgscore_notice_heading">' . esc_html( $heading ) . '</h2>' : '',
			wp_kses(
				$message,
				array(
					'a' => array(
						'href'   => true,
						'rel'    => true,
						'name'   => true,
						'target' => true,
					),
				)
			)
		);
	}

	return $output;
}
