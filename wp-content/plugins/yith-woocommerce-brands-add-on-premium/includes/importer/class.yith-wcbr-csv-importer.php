<?php
/**
 * Brands CSV Importer class
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

if ( ! class_exists( 'YITH_WCBR_CSV_Importer' ) ) {
	/**
	 * WooCommerce Brands CSV Importer
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_CSV_Importer extends WP_Importer {

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
			$this->import_page = 'yith_wcbr_brand_csv';
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

				if ( 9 <= sizeof( $header ) ) {

					while ( ( $row = fgetcsv( $handle, 0, $this->delimiter ) ) !== false ) {

						list( $term_id, $term_name, $term_slug, $term_description, $term_parent, $base_url, $term_thumbnail, $term_banner, $term_custom_url ) = $row;

						// if the term already exists in the correct taxonomy leave it alone
						$id = term_exists( $term_slug, YITH_WCBR::$brands_taxonomy );

						if ( $id ) {
							$loop ++;
							continue;
						}

						if ( empty( $term_parent ) ) {
							$parent = 0;
						} else {
							$parent = term_exists( $term_parent, YITH_WCBR::$brands_taxonomy );

							if ( is_array( $parent ) ) {
								$parent = $parent['term_id'];
							}
						}

						$description = isset( $term_description ) ? $term_description : '';
						$termarr     = array(
							'slug'        => $term_slug,
							'description' => $description,
							'parent'      => intval( $parent )
						);

						$id = wp_insert_term( $term_name, YITH_WCBR::$brands_taxonomy, $termarr );

						if ( ! is_wp_error( $id ) ) {
							$loop ++;

							if ( ! empty( $term_thumbnail ) ) {
								$attachment_id = $this->process_attachment( $term_thumbnail, $base_url );
								if ( ! is_wp_error( $attachment_id ) ) {
									yith_wcbr_update_term_meta( $id['term_id'], 'thumbnail_id', absint( $attachment_id ) );
								} else {
									echo sprintf( __( 'Failed to import attachment %s', 'yith-woocommerce-brands-add-on' ), esc_html( $term_thumbnail ) );
									echo '<br />';
								}
							}

							if ( ! empty( $term_banner ) ) {
								$attachment_id = $this->process_attachment( $term_banner, $base_url );
								if ( ! is_wp_error( $attachment_id ) ) {
									yith_wcbr_update_term_meta( $id['term_id'], 'banner_id', absint( $attachment_id ) );
								} else {
									echo sprintf( __( 'Failed to import attachment %s', 'yith-woocommerce-brands-add-on' ), esc_html( $term_thumbnail ) );
									echo '<br />';
								}
							}

							if ( ! empty( $term_custom_url ) ) {
								yith_wcbr_update_term_meta( $id['term_id'], 'custom_url', $term_custom_url );
							}

							if ( 9 < sizeof( $header ) ) {
								for ( $i = 9; $i < sizeof( $header ); $i ++ ) {
									do_action( 'yith_wcbr_csv_importer_extra_field', $row[ $i ], $header[ $i ], $id );
								}
							}
						} else {
							echo sprintf( __( 'Failed to import %s %s', 'yith-woocommerce-brands-add-on' ), esc_html( YITH_WCBR::$brands_taxonomy ), esc_html( $term_name ) );
							echo '<br />';
						}
					}

				} else {
					$this->import_error( __( 'The CSV is invalid.', 'yith-woocommerce-brands-add-on' ) );
				}

				fclose( $handle );
			}

			// Show Result
			echo '<div class="updated settings-error below-h2"><p>' . sprintf( __( 'Import complete - imported <strong>%s</strong> brands.', 'yith-woocommerce-brands-add-on' ), $loop ) . '</p></div>';

			$this->import_end();
		}

		/**
		 * Attempt to create a new attachment from csv url
		 *
		 * @param string $url      URL to fetch attachment from
		 * @param string $base_url External site base url
		 *
		 * @return int|WP_Error Post ID on success, WP_Error otherwise
		 * @since 1.0.0
		 */
		public function process_attachment( $url, $base_url ) {
			$post = array();

			// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
			if ( preg_match( '|^/[\w\W]+$|', $url ) ) {
				$url = rtrim( $base_url, '/' ) . $url;
			}

			$upload = $this->fetch_remote_file( $url );
			if ( is_wp_error( $upload ) ) {
				return $upload;
			}

			if ( $info = wp_check_filetype( $upload['file'] ) ) {
				$post['post_mime_type'] = $info['type'];
			} else {
				return new WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'wordpress-importer' ) );
			}

			$post['guid'] = $upload['url'];

			// as per wp-admin/includes/upload.php
			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

			// remap resized image URLs, works by stripping the extension and remapping the URL stub.
			if ( preg_match( '!^image/!', $info['type'] ) ) {
				$parts = pathinfo( $url );
				$name  = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

				$parts_new = pathinfo( $upload['url'] );
				$name_new  = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

				$this->url_remap[ $parts['dirname'] . '/' . $name ] = $parts_new['dirname'] . '/' . $name_new;
			}

			return $post_id;
		}

		/**
		 * Attempt to download a remote file attachment
		 *
		 * @param string $url URL of item to fetch
		 *
		 * @return array|WP_Error Local file location details on success, WP_Error otherwise
		 * @since 1.0.0
		 */
		public function fetch_remote_file( $url ) {
			// extract the file name and extension from the url
			$file_name = basename( $url );

			// get placeholder file in the upload dir with a unique, sanitized filename
			$upload = wp_upload_bits( $file_name, 0, '' );

			if ( $upload['error'] ) {
				return new WP_Error( 'upload_dir_error', $upload['error'] );
			}

			// fetch the remote url and write it to the placeholder file
			$wp_http = new WP_Http();
			$result  = $wp_http->get( $url );

			// request failed
			if ( is_wp_error( $result ) ) {
				@unlink( $upload['file'] );

				return new WP_Error( 'import_file_error', __( 'Remote server did not respond', 'wordpress-importer' ) );
			}

			// make sure the fetch was successful
			if ( $result['response']['code'] != '200' ) {
				@unlink( $upload['file'] );

				return new WP_Error( 'import_file_error', sprintf( __( 'Remote server returned error response %1$d %2$s', 'wordpress-importer' ), esc_html( $result['response']['code'] ), $result['response']['message'] ) );
			}

			$out_fp = fopen( $upload['file'], 'w' );
			if ( $out_fp ) {
				fwrite( $out_fp, $result['body'] );
				fclose( $out_fp );
				clearstatcache();
			}

			$filesize = filesize( $upload['file'] );

			if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
				@unlink( $upload['file'] );

				return new WP_Error( 'import_file_error', __( 'Remote file is incorrect size', 'wordpress-importer' ) );
			}

			if ( 0 == $filesize ) {
				@unlink( $upload['file'] );

				return new WP_Error( 'import_file_error', __( 'Zero size file downloaded', 'wordpress-importer' ) );
			}

			$max_size = (int) $this->max_attachment_size();
			if ( ! empty( $max_size ) && $filesize > $max_size ) {
				@unlink( $upload['file'] );

				return new WP_Error( 'import_file_error', sprintf( __( 'Remote file is too large, limit is %s', 'wordpress-importer' ), size_format( $max_size ) ) );
			}

			// keep track of the old and new urls so we can substitute them later
			$this->url_remap[ $url ] = $upload['url'];
			// keep track of the destination if the remote url is redirected somewhere else
			if ( isset( $headers['x-final-location'] ) && $headers['x-final-location'] != $url ) {
				$this->url_remap[ $headers['x-final-location'] ] = $upload['url'];
			}

			return $upload;
		}

		/**
		 * Decide what the maximum file size for downloaded attachments is.
		 * Default is 0 (unlimited), can be filtered via yith_wcbr_import_attachment_size_limit
		 *
		 * @return int Maximum attachment file size to import
		 * @since 1.0.0
		 */
		public function max_attachment_size() {
			return apply_filters( 'yith_wcbr_import_attachment_size_limit', 0 );
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
			echo '<h2>' . __( 'YITH Brands Importer', 'yith-woocommerce-brands-add-on' ) . '</h2>';
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
			echo '<p>' . __( 'Hi there! Upload a CSV file containing brands to import the contents into your shop. Choose a .csv file to upload, then click "Upload file and import".', 'yith-woocommerce-brands-add-on' ) . '</p>';

			$action = 'admin.php?import=yith_wcbr_brand_csv&step=1';

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
		 * @return \YITH_WCBR_CSV_Importer
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
 * Unique access to instance of YITH_WCBR_CSV_Importer class
 *
 * @return \YITH_WCBR_CSV_Importer
 * @since 1.0.0
 */
function YITH_WCBR_CSV_Importer() {
	return YITH_WCBR_CSV_Importer::get_instance();
}