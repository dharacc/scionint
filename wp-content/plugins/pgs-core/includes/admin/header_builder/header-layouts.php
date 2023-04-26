<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $header_layouts;

$header_layouts = header_builder_layouts();

function header_builder_layouts() {
	$header_layouts_array = array(
		array(
			'param_name'  => 'blank_header',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_blank.jpg' ),
		),
		array(
			'param_name'  => 'layout_1',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_01.jpg' ),
		),
		array(
			'param_name'  => 'layout_2',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_02.jpg' ),
		),
		array(
			'param_name'  => 'layout_3',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_03.jpg' ),
		),
		array(
			'param_name'  => 'layout_4',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_04.jpg' ),
		),
		array(
			'param_name'  => 'layout_5',
			'previwe_img' => esc_url( PGSCORE_URL . '/images/header-builder/layouts/layout_05.jpg' ),
		),
	);

	return $header_layouts_array;
}
