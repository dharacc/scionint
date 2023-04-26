<?php
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	/*
	array(
		"param_name"    => "field_param_name",
		'type'          => 'pgs_heading',
		"heading"       => esc_html__( "Field Heading", 'text-domain' ),
		'description'   => esc_html__( 'Field Description.', 'text-domain' ),
		'title'         => esc_html__( 'Field Title', 'text-domain' ),
		'title_el'      => 'h1',
		'title_class'   => 'title-custom-class',
		'title_style'   => 'color:#ff0000;',
		'subtitle'      => esc_html__( 'Field Subtitle', 'text-domain' ),
		'subtitle_el'   => 'h2',
		'subtitle_class'=> 'subtitle-custom-class',
		'subtitle_style'=> 'color:#0000ff;',
	)
	*/
	vc_add_shortcode_param( 'pgscore_heading', 'pgscore_heading_field' );
}
function pgscore_heading_field( $settings, $value ) {
	$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';

	$title       = isset( $settings['title'] ) ? $settings['title'] : '';
	$title_el    = isset( $settings['title_el'] ) ? $settings['title_el'] : 'h4';
	$title_class = isset( $settings['title_class'] ) ? ' ' . $settings['title_class'] : '';
	$title_style = isset( $settings['title_style'] ) ? $settings['title_style'] : '';

	$subtitle       = isset( $settings['subtitle'] ) ? $settings['subtitle'] : '';
	$subtitle_el    = isset( $settings['subtitle_el'] ) ? $settings['subtitle_el'] : 'h5';
	$subtitle_class = isset( $settings['subtitle_class'] ) ? ' ' . $settings['subtitle_class'] : '';
	$subtitle_style = isset( $settings['subtitle_style'] ) ? $settings['subtitle_style'] : '';

	$output = '';

	if ( ! empty( $title ) ) {
		$output .= "<$title_el" . ' class="pgscore_heading-title' . esc_attr( $title_class ) . '" style="' . esc_attr( $title_style ) . '">';
		$output .= $title;
		$output .= "</$title_el>";
	}
	if ( ! empty( $subtitle ) ) {
		$output .= "<$subtitle_el" . ' class="pgscore_heading-subtitle' . esc_attr( $subtitle_class ) . '" style="' . esc_attr( $subtitle_style ) . '">';
		$output .= $subtitle;
		$output .= "</$subtitle_el>";
	}
	return $output;
}
