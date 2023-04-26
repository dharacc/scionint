<?php
global $pgscore_globals;

function pgscore_theme_sample_import_field_completed() {
	echo '<div class="admin-demo-data-notice notice-green" style="display:none;">' . esc_html__( 'All done. Remember to update the passwords and roles of imported users.', 'pgs-core' ) . '</div>';
	echo '<div class="admin-demo-data-reload notice-red" style="display: none;">' . esc_html__( 'Please wait... reloading page to apply changes.', 'pgs-core' ) . '</div>';
	echo '<div class="admin-demo-data-error notice-red" style="display: none;"></div>';
}
add_action( "redux/options/{$pgscore_globals['options_name']}/settings/change", 'pgscore_theme_sample_import_field_completed' );

// Prepapre Sample Data folder details
function pgscore_theme_sample_datas() {

	return apply_filters( 'pgscore_theme_sample_datas', array() );

}

// Prepapre Sample Data folder details
function pgscore_theme_sample_pages() {

	return apply_filters( 'pgscore_theme_sample_pages', array() );

}

function pgscore_sample_import_templates() {
	include_once trailingslashit( PGSCORE_PATH ) . 'includes/sample_data/templates/sample-import-alert.php';
}
add_action( 'admin_footer', 'pgscore_sample_import_templates' );

// System Requirements
function pgscore_sample_data_requirements() {
	return apply_filters(
		'pgscore_sample_data_requirements',
		array(
			'memory_limit'        => esc_html__( 'Memory Limit: 128 MB', 'pgs-core' ),
			'max_execution_time'  => esc_html__( 'Max Execution Time: 180 Seconds', 'pgs-core' ),
			'max_input_time'      => esc_html__( 'Max Input Time: 600 Seconds', 'pgs-core' ),
			'upload_max_filesize' => esc_html__( 'Maximum Upload Size: 32 MB', 'pgs-core' ),
			'post_max_size'       => esc_html__( 'Post Maximum Size: 128 MB', 'pgs-core' ),
		)
	);
}

function pgscore_sample_data_required_plugins_list() {
	global $pgscore_globals;

	$required_plugins_list = array();

	if ( function_exists( 'ciyashop_tgmpa_plugins_data' ) ) {
		$tgmpa_plugins_data = ciyashop_tgmpa_plugins_data();

		$tgmpa_plugins_all = $tgmpa_plugins_data['all'];

		foreach ( $tgmpa_plugins_all as $pgscore_tgmpa_plugins_data_k => $pgscore_tgmpa_plugins_data_v ) {
			if ( $pgscore_tgmpa_plugins_data_v['required'] ) {
				$required_plugins_list[] = $pgscore_tgmpa_plugins_data_v['name'];
			}
		}
	}

	return $required_plugins_list;
}

function pgscore_sample_data_url( $sample_id = '', $resource = '' ) {

	// bail early if sample_id or resource not provided
	if ( empty( $sample_id ) || empty( $resource ) ) {
		return '';
	}

	$purchase_token = ciyashop_is_activated();

	return add_query_arg(
		array(
			'sample_id'   => $sample_id, // default
			'content'     => $resource,  // sample_data.xml
			'token'       => $purchase_token,
			'site_url'    => get_site_url(),
			'product_key' => PGS_PRODUCT_KEY,
		),
		trailingslashit( PGS_ENVATO_API ) . 'sample-data'
	);
}

function pgscore_sample_page_url( $sample_id = '', $resource = '' ) {
	// bail early if sample_id or resource not provided
	if ( empty( $sample_id ) || empty( $resource ) ) {
		return '';
	}

	$purchase_token = ciyashop_is_activated();

	return add_query_arg(
		array(
			'sample_id'   => $sample_id, // default
			'content'     => $resource,  // sample_data.xml
			'token'       => $purchase_token,
			'site_url'    => get_site_url(),
			'product_key' => PGS_PRODUCT_KEY,
		),
		trailingslashit( PGS_ENVATO_API ) . 'sample-page'
	);
}
