<?php
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/faqs.php';
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/teams.php';
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/testimonials.php';
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/portfolio.php';
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/static-blocks.php';
include trailingslashit( PGSCORE_PATH ) . 'includes/cpt/cpts/size_guide.php';

if ( ! function_exists( 'webstercore_vc_set_theme' ) ) {
	/**
	 * Enable VC Editor
	 */
	function webstercore_vc_set_theme() {
		$list = array( 'page', 'post', 'portfolio', 'size_guides', 'static_block' );
		$list = apply_filters( 'webstercore_vc_set_theme', $list, $list );
		vc_set_default_editor_post_types( $list );
	}
}
add_action( 'vc_before_init', 'webstercore_vc_set_theme' );
