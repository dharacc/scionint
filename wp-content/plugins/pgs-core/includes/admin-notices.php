<?php
// Display admin notice if Visual Composer is not activated.
add_action( 'admin_notices', 'pgscore_is_vc_active' );
add_action( 'admin_notices', 'pgscore_plugin_active_notices' );

// Display admin notice if Visual Composer is not activated.
function pgscore_is_vc_active() {
}

// Display admin notice if required plugins are not active
function pgscore_plugin_active_notices() {

	$plugins_requried = array(
		'js_composer/js_composer.php'        => esc_html__( 'WPBakery Visual Composer', 'pgs-core' ),
	);

	$plugins_inactive = array();

	// Check required plugin active status
	foreach ( $plugins_requried as $plugin_requried => $plugin_requried_name ) {

		if ( ! is_plugin_active( $plugin_requried ) ) {
			$plugins_inactive[] = $plugin_requried_name;
		}
	}

	if ( ! empty( $plugins_inactive ) && is_array( $plugins_inactive ) ) {

		$plugins_inactive_str = implode( ', ', $plugins_inactive );

		if ( count( $plugins_inactive ) > 1 ) {
			$message = esc_html__( 'Below required plugins are not installed or activated. Please install/activate to enable feature/functionality.', 'pgs-core' );
		} else {
			$message = esc_html__( 'Below required plugin is not installed or activated. Please install/activate to enable feature/functionality.', 'pgs-core' );
		}
		?>
		<div class="notice notice-error">
			<p><?php echo $message . '<br><strong>' . $plugins_inactive_str . '</strong>'; ?></p>
		</div>
		<?php
	}
}
