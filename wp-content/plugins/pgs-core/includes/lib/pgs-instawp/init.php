<?php
/**
 * Instagram init.
 *
 * @package pgs-core
 */

// Define PGSCORE_PATH and PGSCORE_URL.
define( 'PGS_INSTAWP_PATH', trailingslashit( PGSCORE_PATH ) . 'includes/lib/pgs-instawp' );
define( 'PGS_INSTAWP_URL', trailingslashit( PGSCORE_URL ) . 'includes/lib/pgs-instawp' );

/**
 * Include required files.
 */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/lib/pgs-instawp/class-pgs-instawp-settings.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/lib/pgs-instawp/class-pgs-instagram-api.php';
require_once trailingslashit( PGSCORE_PATH ) . 'includes/lib/pgs-instawp/class-pgs-instawp.php';
