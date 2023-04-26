<?php
/**
* The LOC in charge of displaying Admin GUI/nterfaces
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Generate admin pages
*/
function pgssl_admin_main() {

	do_action( 'pgssl_admin_main_start' );

	if ( ! current_user_can('manage_options') ) {
		wp_die( 'You do not have sufficient permissions to access this page.' );
	}

	if ( ! pgssl_check_requirements() ) {
		include trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'includes/templates/admin-ui-fail.php';
		exit;
	}

	global $pgssl_version;

	$admin_tabs = pgssl_get_components();

	$pgssl_page      = 'networks';
	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';

	if ( isset( $_REQUEST['pgssl_page'] ) ) {
		$pgssl_page = trim( strtolower( strip_tags( $_REQUEST['pgssl_page'] ) ) );
	}

	$admin_tabs    = pgssl_get_components();
	$tutorial_link = pgssl_get_tutorial_link();
	?>
	<div class="wrap">

		<h2><?php esc_html_e( 'PGS Social Login', 'pgssl-text-domain' ); if ( $tutorial_link ) { ?> <a class="add-new-h2" target="_blank" href="<?php echo esc_url($tutorial_link); ?>"><?php esc_html_e( 'Read Tutorial', 'pgssl-text-domain' ); ?></a><?php } ?></h2>

		<?php // settings_errors(); ?>

		<div class="pgssl-settings-meta-box-wrap">

			<?php
			$pgssl_menu_path = pgssl_get_menu_path();

			if ( in_array( $pgssl_page, array( 'networks' ) ) and ( isset( $_REQUEST['settings-updated'] ) || isset( $_REQUEST['enable'] ) ) ) {
				$active_plugins = implode('', (array) get_option('active_plugins') );
				$cache_enabled  =
					strpos( $active_plugins, "w3-total-cache"   ) !== false |
					strpos( $active_plugins, "wp-super-cache"   ) !== false |
					strpos( $active_plugins, "quick-cache"      ) !== false |
					strpos( $active_plugins, "wp-fastest-cache" ) !== false |
					strpos( $active_plugins, "wp-widget-cache"  ) !== false |
					strpos( $active_plugins, "hyper-cache"      ) !== false;

				if ( $cache_enabled ) {
					?>
					<div class="fade updated" style="margin: 4px 0 20px;">
						<p>
							<?php echo __( '<b>Note:</b> PGS Social Login has detected that you are using a caching plugin. If the saved changes didn\'t take effect immediately then you might need to empty the cache.', 'pgssl-text-domain' ); ?>
						</p>
					</div>
					<?php
				}
			}

			if ( get_option( 'pgssl_settings_development_mode_enabled' ) ) {
				?>
				<div class="fade error pgssl-error-dev-mode-on">
					<p>
						<?php echo __('<b>Warning:</b> You are now running PGS Social Login with DEVELOPMENT MODE enabled. This mode is not intend for live websites as it might raise serious security risks', 'pgssl-text-domain') ?>.
					</p>
					<p>
						<a class="button-secondary" href="<?php echo esc_url($pgssl_menu_path) ;?>?page=pgssl_settings&pgssl_page=tools#dev-mode"><?php echo __('Change this mode', 'pgssl-text-domain') ?></a>
						<a class="button-secondary" href="http://miled.github.io/wordpress-social-login/troubleshooting-advanced.html" target="_blank"><?php echo __('Read about the development mode', 'pgssl-text-domain') ?></a>
					</p>
				</div>
				<?php
			}

			if ( get_option( 'pgssl_settings_debug_mode_enabled' ) ) {
				?>
				<div class="fade updated pgssl-error-debug-mode-on" style="margin: 4px 0 20px;">
					<p>
						<?php echo __('<b>Note:</b> You are now running PGS Social Login with DEBUG MODE enabled. This mode is not intend for live websites as it might add to loading time and store unnecessary data on your server', 'pgssl-text-domain') ?>.
					</p>
					<p>
						<a class="button-secondary" href="<?php echo esc_url( $pgssl_menu_path ) ;?>?page=pgssl_settings&pgssl_page=tools#debug-mode"><?php echo __('Change Debug Mode', 'pgssl-text-domain') ?></a>
						<a class="button-secondary" href="<?php echo esc_url( $pgssl_menu_path ) ;?>?page=pgssl_settings&pgssl_page=watchdog"><?php echo __('View Logs', 'pgssl-text-domain') ?></a>
					</p>
				</div>
				<?php
			}

			if ( isset( $_GET['show_tabs'] ) && $_GET['show_tabs'] == 1 ) {
				?>
				<h2 class="nav-tab-wrapper">
					<?php
					foreach( $admin_tabs as $name => $settings ) {
						if ( isset($settings["enabled"]) && $settings["enabled"] && ( $settings["visible"] || $pgssl_page == $name ) ) {
							if ( $name == 'networks' ){
								$link = add_query_arg( array(
									'page'      => 'pgssl_settings',
									'show_tabs' => 1,
								), 'admin.php' );
							}else{
								$link = add_query_arg( array(
									'page'       => 'pgssl_settings',
									'pgssl_page' => $name,
									'show_tabs'  => 1,
								), 'admin.php' );
							}
							?>
							<a class="nav-tab <?php if ( $pgssl_page == $name ) echo "nav-tab-active"; ?>" href="<?php echo esc_url($link); ?>">
								<?php echo __( $settings["label"], 'pgssl-text-domain' );?>
							</a>
							<?php
						}
					}
					?>
				</h2>
				<?php
			}
			?>

			<div id="pgssl_admin_tab_content">
				<?php
				if ( isset( $admin_tabs[ $pgssl_page ] ) && isset( $admin_tabs[ $pgssl_page ]['enabled']) && $admin_tabs[ $pgssl_page ]['enabled'] ) {
					if ( isset( $admin_tabs[ $pgssl_page ]['action'] ) && $admin_tabs[ $pgssl_page ]['action'] ) {
						do_action( $admin_tabs[ $pgssl_page ]['action'] );
					} else {
						if ( file_exists( trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . "includes/admin/components/$pgssl_page/index.php" ) ) {
							include trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . "includes/admin/components/$pgssl_page/index.php";
						}
					}
				} else {
					do_action( 'pgssl_admin_ui_error_start' );
					?>
					<div id="pgssl_div_warn">
						<h3><?php _pgssl_e('Oops! We ran into an issue.', 'pgssl-text-domain') ?></h3>
						<hr />
						<p>
							<?php _pgssl_e("It seems you navigate to some unknown location. Please ensure you are opening proper link.", 'pgssl-text-domain') ?>
						</p>
					</div>
					<?php
					do_action( 'pgssl_admin_ui_error_end' );
				}

				?>
			</div> <!-- ./pgssl_admin_tab_content -->

			<div class="clear"></div>
			<?php
			do_action( 'pgssl_admin_ui_footer_start' );

			do_action( "pgssl_admin_ui_footer_end" );

			if ( get_option( 'pgssl_settings_development_mode_enabled' ) ) {
				pgssl_display_dev_mode_debugging_area();
			}

			do_action( 'pgssl_admin_main_end' );
			?>
		</div><!-- .pgssl-settings-meta-box-wrap -->

	</div><!-- .wrap -->
	<?php
}

/**
* Display PGS Social Login on settings as submenu
*/
function pgssl_admin_menu() {

	$pgssl_menu_type = pgssl_get_menu_type();

	if ( $pgssl_menu_type == 'sub_menu' ) {
		add_options_page(
			__( 'PGS Social Login Settings', 'pgssl-text-domain' ),
			__( 'PGS Social Login', 'pgssl-text-domain' ),
			'manage_options',
			'pgssl_settings',
			'pgssl_admin_main'
		);
	} else {
		add_menu_page(
			__( 'PGS Social Login Settings', 'pgssl-text-domain' ),
			__( 'PGS Social Login', 'pgssl-text-domain' ),
			'manage_options',
			'pgssl_settings',
			'pgssl_admin_main'
		);

		add_submenu_page( 'pgssl_settings', 'Network Settings', 'Networks', 'manage_options', 'pgssl_settings' );

		$admin_tabs = pgssl_get_components();

		foreach( $admin_tabs as $admin_tab => $admin_tab_data ){
			if ( $admin_tab == 'networks' ){
				continue;
			}
			if ( isset($admin_tab_data['sub_menu']) && $admin_tab_data['sub_menu'] ){
				add_submenu_page(
					'pgssl_settings',
					$admin_tab_data['label'],
					$admin_tab_data['label'],
					'manage_options',
					'pgssl_settings&pgssl_page=' . $admin_tab,
					'__return_null'
				);
			}
		}

	}

	add_action( 'admin_init', 'pgssl_register_setting' );
}

add_action('admin_menu', 'pgssl_admin_menu' );

/**
* Enqueue admin CSS file
*/
function pgssl_add_admin_stylesheets() {

	$pgssl_admin_css_v = filemtime( trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'assets/css/pgssl-admin.css' );
	$pgssl_admin_js_v  = filemtime( trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'assets/js/pgssl-admin.js' );

	wp_register_style( 'pgssl-admin', PGS_SOCIAL_LOGIN_PLUGIN_URL . "assets/css/pgssl-admin.css", array(), $pgssl_admin_css_v );
	wp_enqueue_style( 'pgssl-admin' );

	wp_register_script( 'pgssl-admin', PGS_SOCIAL_LOGIN_PLUGIN_URL . "assets/js/pgssl-admin.js", array( 'jquery' ), $pgssl_admin_js_v, true );
	wp_enqueue_script( 'pgssl-admin' );
}

add_action( 'admin_enqueue_scripts', 'pgssl_add_admin_stylesheets' );

function pgssl_highlight_submenu($parent_file){
	global $submenu_file;

	if (isset($_GET['page']) && $_GET['page'] == 'pgssl_settings' && isset($_GET['pgssl_page']) ){
		$submenu_file = $_GET['page'] . '&pgssl_page=' . $_GET['pgssl_page'];
	}

	return $parent_file;
}

add_filter('parent_file', 'pgssl_highlight_submenu');


function pgssl_enable_network(){

	if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'pgssl_settings' ) && ( isset( $_GET['enable'] ) && !empty( $_GET['enable'] ) ) ) {

		$providers_config = pgssl_get_providers();
		$provider_ids = array_column( $providers_config, 'provider_id' );
		$provider_id = $_REQUEST["enable"];

		if ( in_array( $provider_id , $provider_ids ) ){
			update_option( 'pgssl_settings_' . $provider_id . '_enabled', 1 );
		}

		$redirect_url =  remove_query_arg( array('enable') );
		wp_safe_redirect( $redirect_url );
		exit;
	}
}
add_action( 'admin_init', 'pgssl_enable_network');
