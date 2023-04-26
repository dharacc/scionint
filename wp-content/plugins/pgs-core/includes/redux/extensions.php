<?php
// Replace {$redux_opt_name} with your opt_name.
// Also be sure to change this function name!

if ( ! function_exists( 'pgscore_redux_extensions_loader' ) ) :

	global $pgscore_globals;
	function pgscore_redux_extensions_loader( $ReduxFramework ) {
		$path = realpath( trailingslashit( PGSCORE_PATH ) . 'includes/redux/extensions/' );
		if ( file_exists( $path ) ) {
			$extensions = array(
				'image_select',
				'repeater',
				'select_image_new',
				'tc_sample_import',
				'text',
			);

			foreach ( $extensions as $extension ) {

				$extension_class = 'ReduxFramework_' . $extension;

				if ( ! class_exists( $extension_class ) ) {

					// In case you wanted override your override, hah.
					$class_file = trailingslashit( $path ) . $extension . '/field_' . $extension . '.php';
					if ( $class_file ) {
						require_once( $class_file );
					}
				}
			}
		}
	}
	add_action( "redux/extensions/{$pgscore_globals['options_name']}/before", 'pgscore_redux_extensions_loader', 0 );

endif; // pgscore_redux_extensions_loader
