<?php
// ------------------------------------------------------------------------
//	Generic End Point
// ------------------------------------------------------------------------
//  Note: The way we handle errors is a bit messy and should be reworked
// ------------------------------------------------------------------------

if( ! isset( $provider_id ) || empty( $provider_id ) ){
    die("Couldn't continue. Missing required parameters.");
}

if (headers_sent() && !session_id()) {
    session_start();
}

if( ! file_exists( __DIR__ . '/../includes/services/session.php' )
    || ! file_exists( __DIR__ . '/library/src/autoload.php' ) ){
    die("Couldn't find required files.");
}

require_once __DIR__ . '/../includes/services/session.php';
require_once __DIR__ . '/library/src/autoload.php';

$provider_config = pgssl_get_provider_config_from_session_storage($provider_id);
$callback_url    = $provider_config['current_page'];
$wp_abspath      = isset($_SESSION['pgssl:consts:ABSPATH']) ? $_SESSION['pgssl:consts:ABSPATH'] : dirname(__FILE__, 5);

try {
    $hybridauth = new Hybridauth\Hybridauth($provider_config);

    $adapter = $hybridauth->authenticate($provider_id);

    Hybridauth\HttpClient\Util::redirect($callback_url);
}
catch( Exception $e ){
    // Attempt to Load WordPress Core
    $wp_load_path = $wp_abspath . '/wp-load.php';

    if( file_exists( $wp_load_path )){
        define( 'WP_USE_THEMES', false );
        include_once $wp_load_path;
    }

    // Well then
    else{
        function pgssl_process_login_render_error_page($exception){
            echo $exception->getMessage();
            die();
        }
    }

    return pgssl_process_login_render_error_page($e);
}
