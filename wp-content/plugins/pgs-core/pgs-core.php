<?php
/**
 * Plugin Name:       PGS Core
 * Plugin URI:        http://www.potenzaglobalsolutions.com/
 * Description:       This is core plugin for themes by Potenza Global Solutions.
 * Version:           4.8.0
 * Author:            Potenza Global Solutions
 * Author URI:        http://www.potenzaglobalsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pgs-core
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define PGSCORE_PLUGIN_FILE.
if ( ! defined( 'PGSCORE_PLUGIN_FILE' ) ) {
	define( 'PGSCORE_PLUGIN_FILE', __FILE__ );
}

// Define PGSCORE_VERSION.
define( 'PGSCORE_VERSION', '4.8.0' );

// Define PGSCORE_PATH and PGSCORE_URL.
define( 'PGSCORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'PGSCORE_URL', plugin_dir_url( __FILE__ ) );

global $pgscore_globals, $ciyashop_options;
$pgscore_globals = array();

// Plugin activation/deactivation hooks.
register_activation_hook( __FILE__, 'pgscore_activate' );
register_deactivation_hook( __FILE__, 'pgscore_deactivate' );

add_action( 'upgrader_process_complete', 'pgs_upgrader_process_complete' );


/**
 * The code that runs during plugin activation.
 */
function pgscore_activate() {

	// Display admin notice if Visual Composer is not activated.
	add_action( 'admin_notices', 'pgscore_is_vc_active' );
	add_action( 'admin_notices', 'pgscore_plugin_active_notices' );

	pgs_post_type_update();

	update_option( 'pgs_posttype_updated', true );
	update_option( 'pgscore_version', PGSCORE_VERSION );

}

/**
 * The code that runs after plugin update.
 */
function pgs_upgrader_process_complete() {
	update_option( 'pgscore_version', PGSCORE_VERSION );
}

/**
 * The code that runs during plugin deactivation.
 */
function pgscore_deactivate() {
	// TODO: Add settings for plugin deactivation.
}
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function pgscore_theme_functions_load_textdomain() {
	load_plugin_textdomain( 'pgs-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'pgscore_theme_functions_load_textdomain' );

add_action( 'admin_notices', 'pgs_run_the_updater' );
function pgs_run_the_updater() {
	global $wpdb;

	$pgs_posttype_updater = get_option( 'pgs_posttype_updated', false );
	if ( ! $pgs_posttype_updater ) {
		?>
		<div class="updated pgs-updated">
			<p>
				<strong> <?php esc_html_e( 'PGS CORE PLUGIN UPDATER', 'pgs-core' ); ?> </strong>				
			</p>
			<p>
				&#8211; <?php esc_html_e( 'To update post data according to the latest version.', 'pgs-core' ); ?>
			</p>
			<p>
				<a class="pgs-update-now button-primary" href="<?php echo esc_url( add_query_arg( 'do_update_pgs_updater', 'posttype_updater', $_SERVER['REQUEST_URI'] ) ); ?>">
					<?php esc_html_e( 'Run the updater', 'pgs-core' ); ?>
				</a>
			</p>
		</div>
		<script type="text/javascript">
			jQuery('.pgs-update-now').click('click', function () {
				return window.confirm('<?php echo esc_js( __( 'It is strongly recommended that you backup your database before proceeding. Are you sure you wish to run the updater now?', 'pgs-core' ) ); ?>');
			});
		</script>
		<?php
	}
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/init.php';

/**
 * Include social login core.
 */
if ( get_option( 'ciyashop_options' ) ) {
	$ciyashop_options_data = get_option( 'ciyashop_options' );
	$social_login = isset( $ciyashop_options_data['social_login'] ) ? $ciyashop_options_data['social_login'] : true;
	if (  $social_login ) {
		require plugin_dir_path( __FILE__ ) . 'social-login/pgssl-core.php';
	}
}