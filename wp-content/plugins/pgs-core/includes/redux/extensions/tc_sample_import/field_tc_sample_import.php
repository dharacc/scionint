<?php
	/**
	 * Redux Framework is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 2 of the License, or
	 * any later version.
	 * Redux Framework is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	 * GNU General Public License for more details.
	 * You should have received a copy of the GNU General Public License
	 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
	 *
	 * @package     ReduxFramework
	 * @author      Dovy Paukstys
	 * @version     3.1.5
	 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( ! class_exists( 'ReduxFramework_tc_sample_import' ) ) {

	/**
	 * Main ReduxFramework_tc_sample_import class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework_tc_sample_import {

		/**
		 * Field Constructor.
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		function __construct( $field = array(), $value = '', $parent ) {

			$this->parent = $parent;
			$this->field  = $field;
			$this->value  = $value;

			if ( empty( $this->extension_dir ) ) {
				$this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
				$this->extension_url = plugin_dir_url( __FILE__ );
			}

			// Set default args for this field to avoid bad indexes. Change this to anything you use.
			$defaults    = array(
				'options'          => array(),
				'stylesheet'       => '',
				'output'           => true,
				'enqueue'          => true,
				'enqueue_frontend' => true,
			);
			$this->field = wp_parse_args( $this->field, $defaults );

		}

		/**
		 * Field Render Function.
		 * Takes the vars and outputs the HTML for the field in the settings
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function render() {

			$secret = md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . $this->parent->args['opt_name'] );

			// No errors please
			$defaults = array(
				'full_width' => true,
				'overflow'   => 'inherit',
			);

			$this->field = wp_parse_args( $this->field, $defaults );

			$bDoClose = false;

			$id = $this->parent->args['opt_name'] . '-' . $this->field['id'];

			$pgscore_sample_datas = pgscore_theme_sample_datas();

			$nonce = wp_create_nonce( 'sample_data_security' );

			if ( ! empty( $pgscore_sample_datas ) && is_array( $pgscore_sample_datas ) ) {

				$sample_data_image_path = get_parent_theme_file_path( 'images/sample_data' );
				$sample_data_image_url  = get_parent_theme_file_uri( 'images/sample_data' );
				?>
				<div class="sample-data-items">
					<?php
					foreach ( $pgscore_sample_datas as $sample_data ) {
						$preview_img_path = trailingslashit( $sample_data_image_path ) . $sample_data['id'] . '.jpg';
						$preview_img_url  = trailingslashit( $sample_data_image_url ) . $sample_data['id'] . '.jpg';

						?>
						<div class="sample-data-item sample-data-item-<?php echo esc_attr( $sample_data['id'] ); ?>">
							<?php
							if ( file_exists( $preview_img_path ) ) {
								?>
								<div class="sample-data-item-screenshot">
									<img src="<?php echo esc_url( $preview_img_url ); ?>" alt="<?php echo esc_attr( $sample_data['name'] ); ?>"/>
								</div>
								<?php
							} else {
								?>
								<div class="sample-data-item-screenshot blank"></div>
								<?php
							}
							?>
							<span class="sample-data-item-details"><?php echo esc_html( $sample_data['name'] ); ?></span>
							<h2 class="sample-data-item-name"><?php echo esc_html( $sample_data['name'] ); ?></h2>
							<div class="sample-data-item-actions">
								<?php $required_plugins_list = pgscore_sample_data_required_plugins_list(); ?>
								<a href="#" class="button button-primary import-this-sample hide-if-no-customize"
									data-id="<?php echo esc_attr( $sample_data['id'] ); ?>"
									data-nonce="<?php echo esc_attr( $nonce ); ?>"
									data-title="<?php echo esc_attr( $sample_data['name'] ); ?>"
									data-title="<?php echo esc_attr( $sample_data['name'] ); ?>"
									data-message="<?php echo esc_attr( $sample_data['message'] ); ?>"
									<?php echo ( ! empty( $required_plugins_list ) ) ? 'data-required-plugins="' . esc_attr( count( $required_plugins_list ) ) . '"' : ''; ?>>
									<?php echo esc_html__( 'Install', 'pgs-core' ); ?>
								</a>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}

			$pgscore_sample_pages = pgscore_theme_sample_pages();
			if ( ! empty( $pgscore_sample_pages ) ) {
				?>
				<div class="pgscore-sample-page-cover">
					<div id="pgscore-sample-pages-section-start" class="redux-section-field redux-field redux-section-indent-start ">
						<h3><?php _e( 'Additional pages importer', 'pgs-core' ); ?></h3>
					</div>

					<div class="pgacore-page-preview">
						<img src="<?php echo esc_url( PGSCORE_URL . 'images/dummy-420x280.png' ); ?>">
						<a href="#" target="_blank"> <?php _e( 'Demo Preview', 'pgs-core' ); ?> </a>
					</div>
					<div class="pgscore-page-selector">
						<select name="pgscore-sample-page" id="pgscore-sample-page">
							<?php
							foreach ( $pgscore_sample_pages as $pgscore_sample_page ) {
								?>
								<option value="<?php echo esc_attr( $pgscore_sample_page['id'] ); ?>"
									data-demo="<?php echo esc_attr( $pgscore_sample_page['demo_url'] ); ?>"
									data-preview="<?php echo esc_attr( $pgscore_sample_page['previwe_img'] ); ?>"
									data-message="<?php echo esc_attr( $pgscore_sample_page['message'] ); ?>"
									data-additional_message="<?php echo ( isset( $pgscore_sample_page['additional_message'] ) ) ? esc_attr( $pgscore_sample_page['additional_message'] ) : ''; ?>">
									<?php echo esc_html( $pgscore_sample_page['name'] ); ?>
								</option>
								<?php
							}
							?>
						</select>
						<a href="#" class="button button-primary import-this-sample-page" data-id="" data-nonce="<?php echo $nonce; ?>" ><?php _e( 'Import', 'pgs-core' ); ?></a>
						<div class="pgscore-options-info info-red">
							<?php _e( 'Attention! Additional pages importer will import only page contents. Page styles will apply as per your theme styles and options. After importing page contents using additional page importer, you can manage these page contents later on using page settings.', 'pgs-core' ); ?>
						</div>
					</div>
				</div>
				<div id="section-section-end" class="redux-section-field redux-field"></div>
				<?php
			}
		}

		/**
		 * Enqueue Function.
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function enqueue() {
			$min = Redux_Functions::isMin();

			wp_enqueue_script(
				'redux-tc-import-export',
				$this->extension_url . 'field_tc_sample_import' . $min . '.js',
				array( 'jquery', 'jquery-confirm' ),
				time(),
				true
			);

			$pgscore_sample_data_requirements          = pgscore_sample_data_requirements();
			$pgscore_sample_data_required_plugins_list = pgscore_sample_data_required_plugins_list();

			wp_localize_script(
				'redux-tc-import-export',
				'sample_data_import_object',
				array(
					'ajaxurl'                           => admin_url( 'admin-ajax.php' ),
					'alert_title'                       => esc_html__( 'Warning', 'pgs-core' ),
					'alert_proceed'                     => esc_html__( 'Proceed', 'pgs-core' ),
					'alert_cancel'                      => esc_html__( 'Cancel', 'pgs-core' ),
					'alert_install_plugins'             => esc_html__( 'Install Plugins', 'pgs-core' ),
					'alert_default_message'             => esc_html__( 'Importing demo content will import contents, widgets and theme options. Importing sample data will override current widgets and theme options. It can take some time to complete the import process.', 'pgs-core' ),
					'tgmpa_url'                         => admin_url( 'themes.php?page=theme-plugins' ),
					'sample_data_requirements'          => ( ! empty( $pgscore_sample_data_requirements ) ) ? array_values( $pgscore_sample_data_requirements ) : false,
					'sample_data_required_plugins_list' => ( ! empty( $pgscore_sample_data_required_plugins_list ) ) ? array_values( $pgscore_sample_data_required_plugins_list ) : false,
					'sample_import_nonce'               => wp_create_nonce( 'sample_import_security_check' ),
					'page_import_massage'               => esc_html__( 'Attention! Additional pages importer will import only page contents. Page styles will apply as per your theme styles and options. After importing page contents using additional page importer, you can manage these page contents later on using page settings.', 'pgs-core' ),
				)
			);

			wp_enqueue_style(
				'redux-tc-import-export',
				$this->extension_url . 'field_tc_sample_import' . $min . '.css',
				time(),
				true
			);
		}
	}
}
