<?php
/**
 * Attempts to initialize a PHP session when needed
 */
function pgssl_init_php_session() {
	// > check for wsl actions/page
	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : null;
	$page = isset( $_GET['page'] ) ? $_GET['page'] : null;

	if (
		! in_array( $action, array( "pgssl_authenticate", "pgssl_profile_completion", "pgssl_account_linking", "pgssl_authenticated" ) )
		&& ! in_array( $page, array( "pgssl_settings" ) )
	) {
		return false;
	}

	if ( headers_sent() ) {
		wp_die( __( "HTTP headers already sent to browser and WSL won't be able to start/resume PHP session.", 'pgssl-text-domain' ) );
	}

	if ( ! session_id() && ! defined( 'DOING_CRON' ) ) {
		session_start();
	}

	if ( session_id() ) {
		pgssl_init_php_session_storage();
	}
}

function pgssl_init_php_session_storage() {
    global $pgssl_version;

    $_SESSION["pgssl::plugin"] = "PGS Social Login " . $pgssl_version;

    if( defined( 'ABSPATH' ) )
    {
        $_SESSION['pgssl:consts:ABSPATH'] = ABSPATH;
    }
}

function pgssl_set_provider_config_in_session_storage($provider, $config) {
	$provider = strtolower($provider);

	$_SESSION['pgssl:' . $provider . ':config'] = (array) $config;
}

function pgssl_get_provider_config_from_session_storage($provider) {
	$provider = strtolower($provider);

    if(isset($_SESSION['pgssl:' . $provider . ':config']))
    {
        return (array) $_SESSION['pgssl:' . $provider . ':config'];
    }
}
