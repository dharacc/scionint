<?php
/**
 * CiyaShop Header Builder Class
 *
 * @author      Potenza Team
 * @package     ciyashop
 * @version     3.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CiyashopHeaderBuilder' ) ) {
	class CiyashopHeaderBuilder {

		public $elements = '';

		function __construct() {
			global $header_elements, $header_configure_opt, $header_layouts;

			$this->layouts           = apply_filters( 'header_layouts', $header_layouts, $header_layouts );
			$this->elements          = apply_filters( 'header_builder_elements', $header_elements, $header_elements );
			$this->configure_options = apply_filters( 'header_configure_options', $header_configure_opt, $header_configure_opt );

			add_action( 'admin_menu', array( $this, 'register_header_builder_menu' ) );

			add_action( 'admin_init', array( $this, 'create_header_builder_table' ) );

			add_action( 'wp_ajax_add_sample_header', array( $this, 'add_sample_header' ) );
			add_action( 'wp_ajax_nopriv_add_sample_header', array( $this, 'add_sample_header' ) );

			add_action( 'wp_ajax_clone_header', array( $this, 'clone_header' ) );
			add_action( 'wp_ajax_nopriv_clone_header', array( $this, 'clone_header' ) );

			add_action( 'wp_ajax_export_header', array( $this, 'export_header' ) );
			add_action( 'wp_ajax_nopriv_export_header', array( $this, 'export_header' ) );

			add_action( 'wp_ajax_import_header', array( $this, 'import_header' ) );
			add_action( 'wp_ajax_nopriv_import_header', array( $this, 'import_header' ) );

			add_action( 'wp_ajax_edit_element', array( $this, 'edit_element' ) );
			add_action( 'wp_ajax_nopriv_edit_element', array( $this, 'edit_element' ) );

			add_action( 'wp_ajax_save_header_builder', array( $this, 'save_header_builder' ) );
			add_action( 'wp_ajax_nopriv_save_header_builder', array( $this, 'save_header_builder' ) );

			add_action( 'wp_ajax_delete_header', array( $this, 'delete_header' ) );
			add_action( 'wp_ajax_nopriv_delete_header', array( $this, 'delete_header' ) );

			add_action( 'wp_ajax_header_configure', array( $this, 'header_configure' ) );
			add_action( 'wp_ajax_nopriv_header_configure', array( $this, 'header_configure' ) );

		}

		function register_header_builder_menu() {
			$this->ciyashop_header_builder = add_menu_page(
				__( 'Header Builder', 'pgs-core' ),       // Page Title
				__( 'Header Builder', 'pgs-core' ),       // Menu Title
				'manage_options',                       // Capability
				'header-builder',                       // Slug
				array( $this, 'header_bulder_list' ),     // Callback
				'dashicons-archive',                    // Icon
				50                                      // Position
			);
			add_submenu_page(
				'header-builder',
				__( 'All Layouts', 'pgs-core' ),
				__( 'All Layouts', 'pgs-core' ),
				'manage_options',
				'header-builder',
				array( $this, 'header_bulder_list' )
			);
			add_submenu_page(
				'header-builder',
				__( 'Layout Setting', 'pgs-core' ),
				__( 'Add New Layout', 'pgs-core' ),
				'manage_options',
				'header-layout',
				array( $this, 'header_bulder_create' )
			);
		}

		function header_bulder_list() {
			require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-layout-lists.php';
		}

		function header_bulder_create() {
			require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/header-layout.php';
		}

		function create_header_builder_table() {
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			$table_name = $wpdb->prefix . 'cs_header_builder';

			$sql = "CREATE TABLE $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  name tinytext NOT NULL,
				  value longtext NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
			wp_reset_query();
		}

		function add_sample_header() {
			global $wpdb;

			$layout     = $_POST['layout'];
			$table_name = $wpdb->prefix . 'cs_header_builder';

			$value = file_get_contents( trailingslashit( PGSCORE_PATH ) . 'includes/admin/header_builder/samples/' . $layout . '.txt' );
			$data  = unserialize( $value );

			$wpdb->insert(
				$table_name,
				array(
					'name'  => $data['title'],
					'value' => $value,
				)
			);

			$header_id = $wpdb->insert_id;
			$redirect  = true;

			wp_reset_query();
			$return_data = array( 'header_id' => $header_id );

			echo wp_json_encode( $return_data );
			exit();
		}

		function edit_element() {
			$element_options = '';
			$element         = $_POST['elementId'];
			$elements        = $this->elements;

			$element_options = $elements[ $element ]['params'];

			echo wp_json_encode( $element_options );
			exit();
		}

		function save_header_builder() {
			$data = $_POST['objects'];

			if ( empty( $data ) ) {
				return;
			}

			global $ciyashop_options, $wpdb;

			$table_name = $wpdb->prefix . 'cs_header_builder';
			$title      = ( isset( $data['title'] ) ) ? $data['title'] : '';
			$header_id  = ( isset( $data['header_id'] ) ) ? $data['header_id'] : '';
			$value      = serialize( $data );
			$redirect   = false;

			if ( $header_id > 0 ) {
				$header_layout_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$header_id" );
				if ( ! empty( $header_layout_data ) ) {
					$wpdb->update(
						$table_name,
						array(
							'name'  => $title,
							'value' => $value,
						),
						array( 'id' => $header_id )
					);
					$redirect = true;
				}
			} else {
				$wpdb->insert(
					$table_name,
					array(
						'name'  => $title,
						'value' => $value,
					)
				);
				$header_id = $wpdb->insert_id;
				$redirect  = true;
			}

			wp_reset_query();
			$return_data = array(
				'header_id' => $header_id,
				'redirect'  => $redirect,
			);

			if ( class_exists( 'Redux' ) ) {
				// Generate the color customizer CSS
				$primary_color   = esc_html( $ciyashop_options['primary_color'] );
				$secondary_color = esc_html( $ciyashop_options['secondary_color'] );
				$tertiary_color  = esc_html( $ciyashop_options['tertiary_color'] );

				$header_schema   = ciyashop_get_custom_header_schema();
				$color_customize = ciyashop_get_color_scheme_colors( $primary_color, $secondary_color, $tertiary_color, $header_schema );
				ciyashop_generate_color_customize_css( $color_customize );
			}

			echo wp_json_encode( $return_data );
			exit();
		}

		function clone_header() {
			global $wpdb;

			$headerId = $_POST['headerId'];

			$table_name         = $wpdb->prefix . 'cs_header_builder';
			$header_layout_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE id=$headerId" );

			$header_builder_title = $header_layout_data[0]->name;
			$header_builder_value = $header_layout_data[0]->value;

			$wpdb->insert(
				$table_name,
				array(
					'name'  => $header_builder_title . ' (Copy)',
					'value' => $header_builder_value,
				)
			);

			$header_id = $wpdb->insert_id;
			wp_reset_query();
			$return_data = array(
				'header_title' => $header_builder_title . ' (Copy)',
				'header_id'    => $header_id,
			);

			echo wp_json_encode( $return_data );
			exit();
		}

		function export_header() {
			global $wpdb;
			$hdr_id = isset( $_POST['headerId'] ) ? (int) $_POST['headerId'] : '';

			$return_data = false;

			$header_layout_data = $wpdb->get_results(
				$wpdb->prepare(
					'
					SELECT * FROM ' . $wpdb->prefix . 'cs_header_builder
					WHERE id = %d
					',
					$hdr_id
				)
			);

			if ( $header_layout_data ) {

				$header_builder_title = $header_layout_data[0]->name;
				$header_builder_value = $header_layout_data[0]->value;

				$header_builder_title = strtolower( str_replace( ' ', '-', $header_builder_title ) );

				$return_data = array(
					'file_name'    => $header_builder_title . '.txt',
					'file_content' => $header_builder_value,
				);
			}

			echo wp_json_encode( $return_data );
			exit();

		}

		/**
		 * Import header.
		 */
		function import_header() {
			global $wpdb, $wp_filesystem;

			$return_data = false;

			if ( isset( $_FILES['file'] ) ) {

				if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base' ) ) {
					require_once ABSPATH . 'wp-admin/includes/file.php';
					$creds = request_filesystem_credentials( site_url() );
					wp_filesystem( $creds );
				}

				if ( isset( $_FILES['file']['type'] ) && 'text/plain' === $_FILES['file']['type'] ) {
					$table_name = $wpdb->prefix . 'cs_header_builder';
					$filename   = isset( $_FILES['file']['tmp_name'] ) ? sanitize_text_field( $_FILES['file']['tmp_name'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash

					$header_builder_value = $wp_filesystem->get_contents( $filename );
					$header_builder_title = unserialize( $header_builder_value );
					$header_builder_title = $header_builder_title['title'];

					$wpdb->insert(
						$table_name,
						array(
							'name'  => $header_builder_title,
							'value' => $header_builder_value,
						)
					);

					$header_id = $wpdb->insert_id;

					$return_data = array(
						'header_title' => $header_builder_title,
						'header_id'    => $header_id,
					);
				}
			}

			echo wp_json_encode( $return_data );
			exit();

		}

		function delete_header() {
			$headerId = $_POST['headerId'];

			if ( empty( $headerId ) ) {
				return;
			}

			global $wpdb;
			$table_name = $wpdb->prefix . 'cs_header_builder';

			$wpdb->delete( $table_name, array( 'id' => $headerId ) );

			wp_reset_query();
			exit();
		}

		function header_configure() {
			$configure_options = $this->configure_options;
			echo wp_json_encode( $configure_options );

			exit();
		}

	}
}

new CiyashopHeaderBuilder();
