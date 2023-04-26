<?php
add_action( 'wp_ajax_theme_import_sample', 'pgscore_theme_import_sample' );
function pgscore_theme_import_sample() {
	global $pgscore_globals, $ciyashop_options;

	sleep( 0 );

	$action_source = 'default';
	if ( isset( $_REQUEST['action_source'] ) && 'wizard' == $_REQUEST['action_source'] ) {
		$action_source = 'wizard';
	}

	// First check the nonce, if it fails the function will break
	if ( ! wp_verify_nonce( $_REQUEST['sample_import_nonce'], 'sample_import_security_check' ) ) {
		$import_status_data = array(
			'success' => false,
			'message' => esc_html__( 'Unable to validate security check. Please reload the page and try again.', 'pgs-core' ),
			'action'  => '',
		);
	} else {
		// Nonce is checked, get the posted data and process further
		$sample_id = isset( $_REQUEST['sample_id'] ) ? sanitize_text_field( $_REQUEST['sample_id'] ) : '';

		if ( empty( $sample_id ) ) {
			$import_status_data = array(
				'success' => false,
				'message' => esc_html__( 'Something went wrong or invalid sample selected.', 'pgs-core' ),
			);
		} else {
			global $wpdb;

			if ( ! current_user_can( 'manage_options' ) ) {
				$import_status_data = array(
					'success' => false,
					'message' => esc_html__( 'You are not allowed to perform this action.', 'pgs-core' ),
				);
			} else {

				if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
					define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
				}

				if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
					$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
					include $wp_importer;
				}

				$importer_path = trailingslashit( PGSCORE_PATH ) . 'includes/importer/importer.php';

				if ( file_exists( $importer_path ) ) {
					require_once( $importer_path );
				}

				// check for main import class and wp import class
				if ( ! class_exists( 'WP_Importer' ) || ! class_exists( 'Pgscore_Helper_WP_Import' ) ) {
					$import_status_data = array(
						'success' => false,
						'message' => esc_html__( 'WordPress importer class not found.', 'pgs-core' ),
					);
				} else {
					$sample_datas = pgscore_theme_sample_datas();
					$sample_data  = $sample_datas[ $sample_id ];

					/******************************************
					 * Import Main Data
					 ******************************************/

					// Import Data
					$importer = new Pgscore_Helper_WP_Import();

					// Import Posts, Pages, Portfolio Content, FAQ, Images, Menus
					$importer->fetch_attachments = true;

					require_once( ABSPATH . 'wp-admin/includes/file.php' );

					$download_sample = get_template_directory() . '/demos/' . $sample_id . '/sample_data.xml';

					$header_layout_url      = pgscore_sample_data_url( $sample_id, 'header_builder_menu.txt' );
					$download_header_layout = download_url( $header_layout_url );
					if ( is_wp_error( $download_sample ) ) {
						$import_status_data = array(
							'success' => false,
							'message' => esc_html__( 'Unable to download sample file.', 'pgs-core' ) . ' Error: ' . $download_sample->get_error_message(),
						);

						if ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) {
							$import_status_data['message'] = $import_status_data['message'] . "\r\n" . $sample_data_url;
						}
					} else {
						if ( ! file_exists( $download_sample ) ) {
							$import_status_data = array(
								'success' => false,
								'message' => esc_html__( "Sample file doesn't exist.", 'pgs-core' ),
							);

						} else {
							require_once( ABSPATH . 'wp-load.php' );
							if ( ! function_exists( 'post_exists' ) ) {
								require_once( ABSPATH . 'wp-admin/includes/post.php' );
							}

							require_once( ABSPATH . 'wp-admin/includes/image.php' );
							require_once( ABSPATH . 'wp-admin/includes/media.php' );
							require_once( ABSPATH . 'wp-admin/includes/taxonomy.php' );

							/* -------------------------------------------------------
							 *
							 * Prepapre Data Files
							 *
							 * ------------------------------------------------------- */
							$sample_data_path = get_parent_theme_file_path( 'includes/sample_data' );
							$sample_data_url  = get_parent_theme_file_uri( 'includes/sample_data' );

							/* -------------------------------------------------------
							 *
							 * Import sample data
							 *
							 * ------------------------------------------------------- */
							ob_start();
							$import_stattus = $importer->import( $download_sample );
							ob_clean();
							ob_end_clean();

							flush_rewrite_rules();

							/* -------------------------------------------------------
							 *
							 * Import Menus
							 *
							 * ------------------------------------------------------- */
							// Set imported menus to registered theme locations
							$locations        = get_theme_mod( 'nav_menu_locations' ); // registered menu locations in theme
							$registered_menus = wp_get_nav_menus(); // registered menus

							// Assign Menu Name to Registered menus as array keys
							$registered_menus_new = array();
							foreach ( $registered_menus as $registered_menu ) {
								$registered_menus_new[ $registered_menu->name ] = $registered_menu;
							}

							// Assgin Menus to provided locations
							if ( ! empty( $sample_data['menus'] ) && is_array( $sample_data['menus'] ) ) {
								foreach ( $sample_data['menus'] as $menu_loc => $menu_nm ) {
									$reg_menu_data          = isset( $registered_menus_new[ $menu_nm ] ) ? $registered_menus_new[ $menu_nm ] : '';
									$locations[ $menu_loc ] = isset( $reg_menu_data->term_id ) ? $reg_menu_data->term_id : '';
								}
							}

							set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations
							
							// Override the shop page with Wc shop page.
							$locations = get_nav_menu_locations();
							$menu_id   = isset( $locations[ 'primary' ] ) ? $locations[ 'primary' ] : '';

							if ( $menu_id ) {
								$get_menu_id    = '';
								$get_menu_order = '';
								$primary_data   = wp_get_nav_menu_items( $menu_id );
								$page_names     = array( 'shop', 'Shop' );

								if ( $primary_data && is_array( $primary_data ) ) {
									foreach ( $primary_data as $nav ) {
										if ( isset( $nav->title ) && in_array( $nav->title, $page_names, true ) ) {
											$get_menu_id    = $nav->ID;
											$get_menu_order = $nav->menu_order;
										}
									}
								}

								$shop_id = get_option( 'woocommerce_shop_page_id' );
								if ( $get_menu_id && $shop_id && $get_menu_order ) {
									wp_update_nav_menu_item( $menu_id, $get_menu_id, array(
										'menu-item-title'     => 'Shop',
										'menu-item-object-id' => $shop_id,
										'menu-item-object'    => 'page',
										'menu-item-position'  => $get_menu_order,
										'menu-item-status'    => 'publish',
										'menu-item-type'      => 'post_type',
									));
								}
							}

							WP_Filesystem();
							global $wp_filesystem;

							/* -------------------------------------------------------
							 *
							 * Import Theme Options
							 *
							 * ------------------------------------------------------- */
							$theme_options_data = get_template_directory() . '/demos/' . $sample_id . '/theme_options.json';
							if ( ! is_wp_error( $theme_options_data ) && file_exists( $theme_options_data ) ) {
								$redux_options_json = $wp_filesystem->get_contents( $theme_options_data );
								$redux_options      = json_decode( $redux_options_json, true );

								global $pgscore_array_replace_data;
								$pgscore_array_replace_data['old'] = $sample_data['demo_url'];
								$pgscore_array_replace_data['new'] = home_url( '/' );
								$redux_options                     = array_map( 'pgscore_replace_array', $redux_options );

								update_option( $pgscore_globals['options_name'], $redux_options );
								do_action( 'pgs_core_sample_data_import_theme_options', $redux_options );
							} else {
								if ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) {
									$import_status_data = array(
										'success' => false,
										'message' => esc_html__( 'Unable to options file.', 'pgs-core' ) . ' Error: ' . $theme_options_data_url->get_error_message() . "\r\n" . $sample_data_url,
									);

								}
							}

							/* -------------------------------------------------------
							 *
							 * Import Widget Data
							 *
							 * ------------------------------------------------------- */
							$widget_data = get_template_directory() . '/demos/' . $sample_id . '/widget_data.json';
							if ( ! is_wp_error( $widget_data ) && file_exists( $widget_data ) ) {
								if ( ! function_exists( 'pgscore_import_widget_data' ) ) {
									$widget_import = trailingslashit( PGSCORE_PATH ) . 'includes/lib/widget-importer-exporter/widget-import.php';
									if ( file_exists( $importer_path ) ) {
										include( $widget_import );
									}
								}
								$widget_data_json    = $wp_filesystem->get_contents( $widget_data );
								$widget_data_decoded = json_decode( $widget_data_json );

								$pgscore_widget_import_results = pgscore_import_widget_data( $widget_data_decoded );
							} else {
								if ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) {
									$import_status_data = array(
										'success' => false,
										'message' => esc_html__( 'Unable to widgets file.', 'pgs-core' ) . ' Error: ' . $widget_data_url->get_error_message() . "\r\n" . $sample_data_url,
									);

								}
							}

							/* -------------------------------------------------------
							 *
							 * Import Revolution Sliders
							 *
							 * ------------------------------------------------------- */
							// Check if "revsliders" folder exists
							if ( isset( $sample_data['revsliders'] ) && is_array( $sample_data['revsliders'] ) && ! empty( $sample_data['revsliders'] ) ) {
								$pgscore_revslider = new RevSlider();

								foreach ( $sample_data['revsliders'] as $revslider ) {
									$revslider_file = get_template_directory() . '/demos/' . $sample_id . '/' . $revslider;
									if ( ! is_wp_error( $revslider_file ) && file_exists( $revslider_file ) && class_exists( 'UniteFunctionsRev' ) ) {
										ob_start();
										$pgscore_revslider->importSliderFromPost( true, false, $revslider_file );
										ob_clean();
										ob_end_clean();
									}
								}
							}

							/* -------------------------------------------------------
							 *
							 * Set Default Pages
							 *
							 * ------------------------------------------------------- */
							// Home Page
							update_option( 'show_on_front', 'page' );
							if ( isset( $sample_data['home_page'] ) ) {
								$sample_param_home_page = trim( $sample_data['home_page'] );
								if ( ! empty( $sample_param_home_page ) ) {
									$home_page = get_page_by_title( $sample_param_home_page );
									if ( isset( $home_page ) && $home_page->ID ) {
										update_option( 'page_on_front', $home_page->ID ); // Front Page
									}
								}
							}
							// Blog Page
							if ( isset( $sample_data['blog_page'] ) ) {
								$sample_param_blog_page = trim( $sample_data['blog_page'] );
								if ( ! empty( $sample_param_blog_page ) ) {
									$blog_page = get_page_by_title( $sample_data['blog_page'] );
									if ( isset( $blog_page ) && $blog_page->ID ) {
										update_option( 'page_for_posts', $blog_page->ID ); // Posts Page
									}
								}
							}

							//Header Builder Import
							if ( ! is_wp_error( $download_header_layout ) && file_exists( $download_header_layout ) ) {
								$header_layout_import = file_get_contents( $download_header_layout );
								global $wpdb;
								$tablename = $wpdb->prefix . 'cs_header_builder';

								$unique_number       = substr( md5( mt_rand( 0, 999 ) ), 0, 5 );
								$header_builder_name = 'header_builder_menu' . $unique_number;
								$header_builder      = $wpdb->insert(
									$tablename,
									array(
										'name'  => $header_builder_name,
										'value' => $header_layout_import,
									)
								);
								$header_builder_id   = $wpdb->insert_id;
								Redux::setOption( 'ciyashop_options', 'custom_headers', $header_builder_id );
								Redux::setOption( 'ciyashop_options', 'header_type_select', 'header_builder' );
							}
							$import_status_data = array(
								'success' => true,
								'message' => esc_html__( 'All done. Remember to update the passwords and roles of imported users.', 'pgs-core' ),
							);
						}
					}
				}
			}
		}
	}

	// Outout if import called from wizard.
	if ( 'wizard' == $action_source ) {
	}

	wp_send_json( $import_status_data );
	die();
}

add_action( 'wp_ajax_theme_import_sample_page', 'pgscore_theme_import_sample_page' );
if ( ! function_exists( 'pgscore_theme_import_sample_page' ) ) {
	function pgscore_theme_import_sample_page() {
		global $pgscore_globals;

		ob_start();
		sleep( 0 );

		// First check the nonce, if it fails the function will break
		if ( ! wp_verify_nonce( $_REQUEST['sample_import_nonce'], 'sample_import_security_check' ) ) {
			$import_status_data = array(
				'success' => false,
				'message' => esc_html__( 'Unable to validate security check. Please reload the page and try again.', 'pgs-core' ),
				'action'  => '',
			);
		} else {

			// Nonce is checked, get the posted data and process further
			$sample_page_id = isset( $_REQUEST['sample_id'] ) ? sanitize_text_field( $_REQUEST['sample_id'] ) : '';

			if ( empty( $sample_page_id ) ) {
				$import_status_data = array(
					'success' => false,
					'message' => esc_html__( 'Something went wrong or invalid sample selected.', 'pgs-core' ),
				);
			} else {
				global $wpdb;
				if ( ! current_user_can( 'manage_options' ) ) {
					$import_status_data = array(
						'success' => false,
						'message' => esc_html__( 'You are not allowed to perform this action.', 'pgs-core' ),
					);
				} else {
					if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
						define( 'WP_LOAD_IMPORTERS', true ); // we are loading importers
					}

					if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
						$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
						include $wp_importer;
					}

					$importer_path = trailingslashit( PGSCORE_PATH ) . 'includes/importer/importer.php';

					if ( file_exists( $importer_path ) ) {
						require_once( $importer_path );
					}

					// check for main import class and wp import class
					if ( ! class_exists( 'WP_Importer' ) || ! class_exists( 'Pgscore_Helper_WP_Import' ) ) {
						$import_status_data = array(
							'success' => false,
							'message' => esc_html__( 'WordPress importer class not found.', 'pgs-core' ),
						);
					} else {
						$sample_pages = pgscore_theme_sample_pages();
						$sample_page  = $sample_pages[ $sample_page_id ];

						/******************************************
						 * Import Main Data
						 ******************************************/

						// Import Data
						$importer = new Pgscore_Helper_WP_Import();

						// Import Posts, Pages, Portfolio Content, FAQ, Images, Menus
						$importer->fetch_attachments = true;

						require_once( ABSPATH . 'wp-admin/includes/file.php' );

						$sample_page_url = pgscore_sample_page_url( $sample_page_id, 'sample_page.xml' );
						$download_sample = download_url( $sample_page_url );

						if ( is_wp_error( $download_sample ) ) {
							$import_status_data = array(
								'success' => false,
								'message' => esc_html__( 'Unable to download sample file.', 'pgs-core' ) . ' Error: ' . $download_sample->get_error_message(),
							);
							if ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) {
								$import_status_data['message'] = $import_status_data['message'] . "\r\n" . $sample_page_url;
							}
						} else {
							if ( ! file_exists( $download_sample ) ) {
								$import_status_data = array(
									'success' => false,
									'message' => esc_html__( "Sample file doesn't exist.", 'pgs-core' ),
								);
							} else {
								require_once( ABSPATH . 'wp-load.php' );
								if ( ! function_exists( 'post_exists' ) ) {
									require_once( ABSPATH . 'wp-admin/includes/post.php' );
								}

								require_once( ABSPATH . 'wp-admin/includes/image.php' );
								require_once( ABSPATH . 'wp-admin/includes/media.php' );
								require_once( ABSPATH . 'wp-admin/includes/taxonomy.php' );
							}

							/* -------------------------------------------------------
							 *
							 * Prepapre Data Files
							 *
							 * ------------------------------------------------------- */
							$sample_data_path = get_parent_theme_file_path( 'includes/sample_data' );
							$sample_data_url  = get_parent_theme_file_uri( 'includes/sample_data' );

							/* -------------------------------------------------------
							 *
							 * Import sample data
							 *
							 * ------------------------------------------------------- */
							ob_start();
							$import_stattus = $importer->import( $download_sample );
							ob_clean();
							ob_end_clean();

							flush_rewrite_rules();

							/* -------------------------------------------------------
							 *
							 * Import Revolution Sliders
							 *
							 * ------------------------------------------------------- */
							// Check if "revsliders" folder exists
							if ( isset( $sample_page['revsliders'] ) && is_array( $sample_page['revsliders'] ) && ! empty( $sample_page['revsliders'] ) ) {
								$pgscore_revslider = new RevSlider();

								foreach ( $sample_page['revsliders'] as $revslider ) {
									$revslider_url  = pgscore_sample_page_url( $sample_page_id, 'revsliders/' . $revslider );
									$revslider_file = download_url( $revslider_url );
									if ( ! is_wp_error( $revslider_file ) && file_exists( $revslider_file ) && class_exists( 'UniteFunctionsRev' ) ) {
										ob_start();
										$pgscore_revslider->importSliderFromPost( true, false, $revslider_file );
										ob_clean();
										ob_end_clean();
									}
									$import_status_data = array(
										'success' => true,
										'message' => $revslider_file,
									);
								}
							}

							$import_status_data = array(
								'success' => true,
								'message' => esc_html__( 'Sample page import successfuly', 'pgs-core' ),
							);

						}
					}
				}
			}
		}
		ob_clean();

		wp_send_json( $import_status_data );
		die();
	}
}

function pgscore_replace_array( $n ) {
	global $pgscore_array_replace_data;

	if ( is_array( $n ) ) {
		return array_map( 'pgscore_replace_array', $n );
	} else {
		if ( ! empty( $pgscore_array_replace_data ) && is_array( $pgscore_array_replace_data ) && isset( $pgscore_array_replace_data['old'] ) && isset( $pgscore_array_replace_data['new'] ) ) {
			if ( strpos( $n, $pgscore_array_replace_data['old'] ) !== false ) {
				return str_replace( $pgscore_array_replace_data['old'], $pgscore_array_replace_data['new'], $n );
			} else {
				return $n;
			}
		} else {
			return $n;
		}
	}
	return $n;
}
function getHeaderBuilderData( $download_url = '' ) {
	$file_open = fopen( $download_url, 'r+' );
	if ( false == $file_open ) {
		return;
	}

	$fileData = fread( $file_open );
	return $fileData;
}
