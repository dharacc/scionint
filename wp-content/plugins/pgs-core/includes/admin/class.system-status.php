<?php
defined( 'ABSPATH' ) || exit;

/**
 * System status controller class.
 *
 */
class Pgs_Core_System_Status {

	/**
	 * Get array of environment information. Includes thing like software
	 * versions, and various server settings.
	 *
	 * @return array
	 */
	public function get_environment_info() {

		// Figure out cURL version, if installed.
		$curl_version = '';
		if ( function_exists( 'curl_version' ) ) {
			$curl_version = curl_version();
			$curl_version = $curl_version['version'] . ', ' . $curl_version['ssl_version'];
		}

		// WP memory limit.
		$wp_memory_limit = $this->size_to_num( WP_MEMORY_LIMIT );
		if ( function_exists( 'memory_get_usage' ) ) {
			$wp_memory_limit = max( $wp_memory_limit, $this->size_to_num( @ini_get( 'memory_limit' ) ) );
		}

		// Test POST requests.
		$post_response            = wp_safe_remote_post(
			'https://www.paypal.com/cgi-bin/webscr',
			array(
				'timeout'     => 60,
				'user-agent'  => 'WordPress/4.9.6',
				'httpversion' => '1.1',
				'body'        => array(
					'cmd' => '_notify-validate',
				),
			)
		);
		$post_response_successful = false;
		if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] >= 200 && $post_response['response']['code'] < 300 ) {
			$post_response_successful = true;
		}

		// Test GET requests.
		$get_response            = wp_safe_remote_get( 'https://woocommerce.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );
		$get_response_successful = false;
		if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] >= 200 && $post_response['response']['code'] < 300 ) {
			$get_response_successful = true;
		}

		$database_version = $this->get_server_database_version();

		// Return all environment info. Described by JSON Schema.
		return array(
			'home_url'                  => home_url(),
			'site_url'                  => get_option( 'siteurl' ),
			'wp_version'                => get_bloginfo( 'version' ),
			'wp_multisite'              => is_multisite(),
			'wp_memory_limit'           => $wp_memory_limit,
			'wp_debug_mode'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
			'wp_cron'                   => ! ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ),
			'language'                  => get_locale(),
			'external_object_cache'     => wp_using_ext_object_cache(),
			'server_info'               => isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '', // Content escaped
			'php_version'               => phpversion(),
			'php_post_max_size'         => $this->size_to_num( ini_get( 'post_max_size' ) ),
			'php_upload_max_filesize'   => $this->size_to_num( ini_get( 'upload_max_filesize' ) ),
			'php_max_execution_time'    => ini_get( 'max_execution_time' ),
			'php_max_input_vars'        => ini_get( 'max_input_vars' ),
			'php_max_input_time'        => ini_get( 'max_input_time' ),
			'curl_version'              => $curl_version,
			'suhosin_installed'         => extension_loaded( 'suhosin' ),
			'max_upload_size'           => wp_max_upload_size(),
			'mysql_version'             => $database_version['number'],
			'mysql_version_string'      => $database_version['string'],
			'default_timezone'          => date_default_timezone_get(),
			'fsockopen_or_curl_enabled' => ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ),
			'soapclient_enabled'        => class_exists( 'SoapClient' ),
			'domdocument_enabled'       => class_exists( 'DOMDocument' ),
			'gzip_enabled'              => is_callable( 'gzopen' ),
			'mbstring_enabled'          => extension_loaded( 'mbstring' ),
			'remote_post_successful'    => $post_response_successful,
			'remote_post_response'      => ( is_wp_error( $post_response ) ? $post_response->get_error_message() : $post_response['response']['code'] ),
			'remote_get_successful'     => $get_response_successful,
			'remote_get_response'       => ( is_wp_error( $get_response ) ? $get_response->get_error_message() : $get_response['response']['code'] ),
		);
	}

	/**
	 * Get array of counts of objects. Orders, products, etc.
	 *
	 * @return array
	 */
	public function get_post_type_counts() {
		global $wpdb;

		$post_type_counts = $wpdb->get_results( "SELECT post_type AS 'type', count(1) AS 'count' FROM {$wpdb->posts} GROUP BY post_type;" );

		return is_array( $post_type_counts ) ? $post_type_counts : array();
	}

	/**
	 * Get a list of plugins active on the site.
	 *
	 * @return array
	 */
	public function get_active_plugins() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		require_once ABSPATH . 'wp-admin/includes/update.php';

		if ( ! function_exists( 'get_plugin_updates' ) ) {
			return array();
		}

		// Get both site plugins and network plugins.
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
			$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
		}

		$active_plugins_data = array();
		$available_updates   = get_plugin_updates();

		foreach ( $active_plugins as $plugin ) {

			if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
				continue;
			}

			$data           = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_latest = '';
			$slug           = explode( '/', $plugin );
			$slug           = explode( '.', end( $slug ) );
			$slug           = $slug[0];

			if ( isset( $available_updates[ $plugin ]->update->new_version ) ) {
				$version_latest = $available_updates[ $plugin ]->update->new_version;
			}

			// convert plugin data to json response format.
			$active_plugins_data[] = array(
				'plugin'            => $plugin,
				'name'              => $data['Name'],
				'version'           => $data['Version'],
				'version_latest'    => $version_latest,
				'url'               => $data['PluginURI'],
				'author_name'       => $data['AuthorName'],
				'author_url'        => esc_url_raw( $data['AuthorURI'] ),
				'network_activated' => $data['Network'],
			);
		}

		return $active_plugins_data;
	}

	/**
	 * Get info on the current active theme, info on parent theme (if presnet)
	 * and a list of template overrides.
	 *
	 * @return array
	 */
	public function get_theme_info() {
		$active_theme = wp_get_theme();

		// Get parent theme info if this theme is a child theme, otherwise
		// pass empty info in the response.
		if ( is_child_theme() ) {
			$parent_theme      = wp_get_theme( $active_theme->template );
			$parent_theme_info = array(
				'parent_name'           => $parent_theme->name,
				'parent_version'        => $parent_theme->version,
				'parent_version_latest' => $this->get_latest_theme_version( $parent_theme ),
				'parent_author_url'     => $parent_theme->{'Author URI'},
			);
		} else {
			$parent_theme_info = array(
				'parent_name'           => '',
				'parent_version'        => '',
				'parent_version_latest' => '',
				'parent_author_url'     => '',
			);
		}

		$active_theme_info = array(
			'name'                    => $active_theme->name,
			'version'                 => $active_theme->version,
			'version_latest'          => $this->get_latest_theme_version( $active_theme ),
			'author_url'              => esc_url_raw( $active_theme->{'Author URI'} ),
			'is_child_theme'          => is_child_theme(),
			'has_woocommerce_support' => current_theme_supports( 'woocommerce' ),
			'has_woocommerce_file'    => ( file_exists( get_stylesheet_directory() . '/woocommerce.php' ) || file_exists( get_parent_theme_file_path() . '/woocommerce.php' ) ),
		);

		return array_merge( $active_theme_info, $parent_theme_info );
	}

	/**
	 * Get latest version of a theme by slug.
	 *
	 * @param  object $theme WP_Theme object.
	 * @return string Version number if found.
	 */
	public static function get_latest_theme_version( $theme ) {
		include_once ABSPATH . 'wp-admin/includes/theme.php';

		$api = themes_api(
			'theme_information',
			array(
				'slug'   => $theme->get_stylesheet(),
				'fields' => array(
					'sections' => false,
					'tags'     => false,
				),
			)
		);

		$update_theme_version = 0;

		// Check .org for updates.
		if ( is_object( $api ) && ! is_wp_error( $api ) ) {
			$update_theme_version = $api->version;
		}

		return $update_theme_version;
	}

	/**
	 * Notation to numbers.
	 *
	 * This function transforms the php.ini notation for numbers (like '2M') to an integer.
	 *
	 * @param  string $size Size value.
	 * @return int
	 */
	public function size_to_num( $size ) {
		$l    = substr( $size, -1 );
		$ret  = substr( $size, 0, -1 );
		$byte = 1024;

		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= $byte;
				// No break.
			case 'T':
				$ret *= $byte;
				// No break.
			case 'G':
				$ret *= $byte;
				// No break.
			case 'M':
				$ret *= $byte;
				// No break.
			case 'K':
				$ret *= $byte;
				// No break.
		}
		return $ret;
	}

	/**
	 * Retrieves the MySQL server version. Based on $wpdb.
	 *
	 * @since 3.4.1
	 * @return array Vesion information.
	 */
	function get_server_database_version() {
		global $wpdb;

		if ( empty( $wpdb->is_mysql ) ) {
			return array(
				'string' => '',
				'number' => '',
			);
		}

		if ( $wpdb->use_mysqli ) {
			$server_info = mysqli_get_server_info( $wpdb->dbh ); // @codingStandardsIgnoreLine.
		} else {
			$server_info = mysql_get_server_info( $wpdb->dbh ); // @codingStandardsIgnoreLine.
		}

		return array(
			'string' => $server_info,
			'number' => preg_replace( '/([^\d.]+).*/', '', $server_info ),
		);
	}
}
