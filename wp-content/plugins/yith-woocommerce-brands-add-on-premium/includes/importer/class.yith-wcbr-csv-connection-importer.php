<?php
/**
 * Brands CSV Connection Importer class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Brands Add-on
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCBR_CSV_Connection_Importer' ) ) {
	/**
	 * WooCommerce Brands CSV Connections Importer
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_CSV_Connection_Importer extends WP_Importer {

		/**
		 * Importer id
		 *
		 * @var int
		 * @since 1.0.0
		 */
		public $id;

		/**
		 * CSV file to import
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $file_url;

		/**
		 * Importer page
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $import_page;

		/**
		 * CSV delimiter
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $delimiter;

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCBR_CSV_Importer
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Constructor
		 *
		 * @return \YITH_WCBR_CSV_Importer
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->import_page = 'yith_wcbr_brand_connection_csv';
			$this->delimiter   = empty( $_POST['delimiter'] ) ? ',' : wc_clean( $_POST['delimiter'] );
		}

		/**
		 * Registered callback function for the WordPress Importer; manages the three separate stages of the CSV import process
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function dispatch() {

			$this->header();

			$step = empty( $_GET['step'] ) ? 0 : (int) $_GET['step'];

			switch ( $step ) {

				case 0:
					$this->greet();
					break;

				case 1:
					check_admin_referer( 'import-upload' );

					if ( $this->handle_upload() ) {

						if ( $this->id ) {
							$file = get_attached_file( $this->id );
						} else {
							$file = ABSPATH . $this->file_url;
						}

						add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );

						$this->import( $file );
					}
					break;
			}

			$this->footer();
		}

		/**
		 * format_data_from_csv function.
		 *
		 * @param mixed  $data
		 * @param string $enc
		 *
		 * @return string
		 * @since 1.0.0
		 */
		public function format_data_from_csv( $data, $enc ) {
			return ( $enc == 'UTF-8' ) ? $data : utf8_encode( $data );
		}

		/**
		 * Import terms from CSV
		 *
		 * @param mixed $file
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function import( $file ) {
			if ( ! is_file( $file ) ) {
				$this->import_error( __( 'The file does not exist, please try again.', 'yith-woocommerce-brands-add-on' ) );
			}

			$this->import_start();

			$loop = 0;

			if ( ( $handle = fopen( $file, "r" ) ) !== false ) {

				$header = fgetcsv( $handle, 0, $this->delimiter );

				if ( 2 === sizeof( $header ) ) {

					while ( ( $row = fgetcsv( $handle, 0, $this->delimiter ) ) !== false ) {

						list( $product_id, $term_id ) = $row;

						$term_id = apply_filters( 'yith_wcbr_csv_connection_importer_term_id', $term_id, $product_id, YITH_WCBR::$brands_taxonomy );

						// retrieve the term.
						$term = get_term( $term_id, YITH_WCBR::$brands_taxonomy );

						// if term doesn't exist, skip the row.
						if ( ! $term || is_wp_error( $term ) ) {
							echo sprintf( __( 'Failed to import: term %s doesn\'t exists', 'yith-woocommerce-brands-add-on' ), esc_html( $term_id ) );
							echo '<br />';
							continue;
						}

						$product_id = apply_filters( 'yith_wcbr_csv_connection_importer_product_id', $product_id, $term_id, YITH_WCBR::$brands_taxonomy );

						// retrieve the product.
						$product = wc_get_product( $product_id );

						// if the product doesn't exist, skip the row.
						if ( ! $product ) {
							echo sprintf( __( 'Failed to import: product %s doesn\'t exists', 'yith-woocommerce-brands-add-on' ), esc_html( $product_id ) );
							echo '<br />';
							continue;
						}

						wp_set_post_terms( $product_id, $term_id, YITH_WCBR::$brands_taxonomy, true );
						$loop ++;
					}

				} else {
					$this->import_error( __( 'The CSV is invalid.', 'yith-woocommerce-brands-add-on' ) );
				}

				fclose( $handle );
			}

			// Show Result
			echo '<div class="updated settings-error below-h2"><p>' . sprintf( __( 'Import complete - imported <strong>%s</strong> connections.', 'yith-woocommerce-brands-add-on' ), $loop ) . '</p></div>';

			$this->import_end();
		}

		/**
		 * Performs post-import cleanup of files and the cache
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function import_end() {
			echo '<p>' . __( 'All done!', 'yith-woocommerce-brands-add-on' ) . ' <a href="' . esc_url( add_query_arg( array(
					'taxonomy'  => YITH_WCBR::$brands_taxonomy,
					'post_type' => 'product'
				), admin_url( 'edit-tags.php' ) ) ) . '">' . __( 'View Brands', 'yith-woocommerce-brands-add-on' ) . '</a>' . '</p>';

			do_action( 'import_end' );
		}

		/**
		 * Handles the CSV upload and initial parsing of the file to prepare for displaying author import options
		 *
		 * @return bool False if error uploading or invalid file, true otherwise
		 * @since 1.0.0
		 */
		public function handle_upload() {
			if ( empty( $_POST['file_url'] ) ) {

				$file = wp_import_handle_upload();

				if ( isset( $file['error'] ) ) {
					$this->import_error( $file['error'] );
				}

				$this->id = absint( $file['id'] );

			} elseif ( file_exists( ABSPATH . $_POST['file_url'] ) ) {
				$this->file_url = esc_attr( $_POST['file_url'] );
			} else {
				$this->import_error();
			}

			return true;
		}

		/**
		 * Print import page header
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function header() {
			echo '<div class="wrap"><div class="icon32 icon32-woocommerce-importer" id="icon-woocommerce"><br></div>';
			echo '<h2>' . __( 'YITH Brands Connections Importer', 'yith-woocommerce-brands-add-on' ) . '</h2>';
		}

		/**
		 * Print import page footer
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function footer() {
			echo '</div>';
		}

		/**
		 * Print first step of import procedure
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function greet() {

			echo '<div class="narrow">';
			echo '<p>' . __( 'Hi there! Upload a CSV file containing brands/products connections to import the contents into your shop. Choose a .csv file to upload, then click "Upload file and import".', 'yith-woocommerce-brands-add-on' ) . '</p>';

			$action = 'admin.php?import=yith_wcbr_brand_connection_csv&step=1';

			$bytes      = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
			$size       = size_format( $bytes );
			$upload_dir = wp_upload_dir();
			if ( ! empty( $upload_dir['error'] ) ) :
				?>
				<div class="error">
				<p><?php _e( 'Before uploading your import file, you need to fix the following error:', 'yith-woocommerce-brands-add-on' ); ?></p>

				<p><strong><?php echo $upload_dir['error']; ?></strong></p></div><?php
			else :
				?>
				<form enctype="multipart/form-data" id="import-upload-form" method="post" action="<?php echo esc_attr( wp_nonce_url( $action, 'import-upload' ) ); ?>">
					<table class="form-table">
						<tbody>
						<tr>
							<th>
								<label for="upload"><?php _e( 'Choose a file from your computer:', 'yith-woocommerce-brands-add-on' ); ?></label>
							</th>
							<td>
								<input type="file" id="upload" name="import" size="25"/>
								<input type="hidden" name="action" value="save"/>
								<input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>"/>
								<small><?php printf( __( 'Maximum size: %s', 'yith-woocommerce-brands-add-on' ), $size ); ?></small>
							</td>
						</tr>
						<tr>
							<th>
								<label for="file_url"><?php _e( 'OR enter path to file:', 'yith-woocommerce-brands-add-on' ); ?></label>
							</th>
							<td>
								<?php echo ' ' . ABSPATH . ' '; ?>
								<input type="text" id="file_url" name="file_url" size="25"/>
							</td>
						</tr>
						<tr>
							<th><label><?php _e( 'Delimiter', 'yith-woocommerce-brands-add-on' ); ?></label><br/></th>
							<td><input type="text" name="delimiter" placeholder="," size="2"/></td>
						</tr>
						</tbody>
					</table>
					<p class="submit">
						<input type="submit" class="button" value="<?php esc_attr_e( 'Upload file to import', 'yith-woocommerce-brands-add-on' ); ?>"/>
					</p>
				</form>
			<?php
			endif;

			echo '</div>';
		}

		/**
		 * Added to http_request_timeout filter to force timeout at 60 seconds during import
		 *
		 * @param int $val
		 *
		 * @return int 60
		 * @since 1.0.0
		 */
		public function bump_request_timeout( $val ) {
			return 60;
		}

		/**
		 * Show import error and quit
		 *
		 * @param string $message
		 *
		 * @return void
		 * @since 1.0.0
		 */
		private function import_error( $message = '' ) {
			echo '<p><strong>' . __( 'Sorry, an error has occurred.', 'yirh-wcbr' ) . '</strong><br />';
			if ( $message ) {
				echo esc_html( $message );
			}
			echo '</p>';
			$this->footer();
			die();
		}

		/**
		 * Start import
		 *
		 * @return void
		 * @since 1.0.0
		 */
		private function import_start() {
			if ( function_exists( 'gc_enable' ) ) {
				gc_enable();
			}
			@set_time_limit( 0 );
			@ob_flush();
			@flush();
			@ini_set( 'auto_detect_line_endings', '1' );
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCBR_CSV_Connection_Importer
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCBR_CSV_Connection_Importer class
 *
 * @return \YITH_WCBR_CSV_Connection_Importer
 * @since 1.0.0
 */
function YITH_WCBR_CSV_Connection_Importer() {
	return YITH_WCBR_CSV_Connection_Importer::get_instance();
}