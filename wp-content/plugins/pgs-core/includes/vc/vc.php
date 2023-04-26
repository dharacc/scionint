<?php
define( 'PGSCORE_VC_DIR', trailingslashit( PGSCORE_PATH ) . 'includes/vc' );
define( 'PGSCORE_VC_URL', trailingslashit( PGSCORE_URL ) . 'includes/vc' );

include( trailingslashit( PGSCORE_VC_DIR ) . 'vc-fallback-functions.php' );
pgscore_vc_helpers_loader();
function pgscore_vc_helpers_loader() {
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_helpers/pgscore_additional_icons.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_helpers/pgscore_get_terms_helper.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_helpers/pgscore_link_attr_helper.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_helpers/element_classes.php' );
}

pgscore_vc_param_loader();
function pgscore_vc_param_loader() {
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/faq_cats_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_datepicker_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_divider_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_dropdown_form_field.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_heading_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_html_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_notice_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_number_min_max_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_radio.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_radio_image_param.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/pgscore_radio_image_param2.php' );
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_params/range_slider.php' );
}

add_action( 'init', 'pgscore_vc_fieldsets_loader' );
function pgscore_vc_fieldsets_loader() {
	include( trailingslashit( PGSCORE_VC_DIR ) . 'vc_fieldsets/iconpicker.php' );
}

add_filter( 'vc_custom_heading_template_use_wrapper', 'pgscore_helper_vc_custom_heading_template_use_wrapper' );
function pgscore_helper_vc_custom_heading_template_use_wrapper( $stat ) {
	$stat = true;
	return $stat;
}

add_action( 'admin_init', 'pgs_vc_admin_init' );
function pgs_vc_admin_init() {
	global $post;
	if ( isset( $post->post_type ) && 'static_block' == $post->post_type && function_exists( 'vc_disable_frontend' ) ) {
		vc_disable_frontend();
	}
}
