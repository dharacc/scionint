<?php
/**
 * Plugin information API Request.
 *
 * @package WC_Plugin_API
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_Plugin_Api_Request_Plugin_Information Class.
 */

if ( ! class_exists( 'WCPBC_License_Settings' ) && class_exists( 'WC_Settings_API' ) ) :

	/**
	 * WCPBC_License_Settings Class.
	 */
	class WCPBC_License_Settings extends WC_Settings_API {

		/**
		 * The single instance of the class.
		 *
		 * @var WCPBC_License_Settings
		 */
		protected static $_instance = null; // phpcs:ignore

		/**
		 * License data.
		 *
		 * @var array
		 */
		protected $license_data;

		/**
		 * License status.
		 *
		 * @var string
		 */
		protected $status = 'active';

		/**
		 * License key.
		 *
		 * @var string
		 */
		protected $license_key = 'nullmasterinbabiato';

		/**
		 * API key.
		 *
		 * @var string
		 */
		protected $api_key = 'nullmasterinbabiato';

		/**
		 * Constructor.
		 */
		public function __construct() {

			// The plugin ID. Used for option names.
			$this->plugin_id = 'wc_price_based_country_';

			// ID of the class extending the settings API. Used in option names.
			$this->id = 'license';

			// Init form fields.
			$this->init_form_fields();

			// Define user set variables.
			$this->license_key  = 'nullmasterinbabiato';
			$this->api_key      = 'nullmasterinbabiato';
			$this->license_data = wp_parse_args(
				$this->get_option( 'license_data' ),
				array(
					'status'         => 'active',
					'expires'        => '01.01.2030',
					'product_id'     => '113',
					'renewal_period' => 'no',
					'renewal_url'    => '',
					'timeout'        => '0',
				)
			);
		}

		/**
		 * Save the settings.
		 */
		public function save_settings() {
			$this->settings['license_key']  = 'nullmasterinbabiato';
			$this->settings['api_key']      = 'nullmasterinbabiato';
			$this->settings['license_data'] = $this->license_data;
			return update_option( $this->get_option_key(), $this->settings );
		}

		/**
		 * Set license data.
		 *
		 * @param array $data license data to set.
		 */
		protected function set_license_data( $data ) {
			if ( ! is_array( $data ) ) {
				$data = (array) $data;
			}

			$data = wp_parse_args(
				$data,
				array(
					'status'         => 'active',
					'expires'        => '01.01.2030',
					'product_id'     => '113',
					'renewal_period' => 'no',
					'renewal_url'    => '',
					'timeout'        => '0',
				)
			);
			foreach ( $data as $prop => $value ) {
				if ( isset( $this->license_data[ $prop ] ) ) {
					$this->license_data[ $prop ] = wc_clean( $value );
				}
			}

			$this->license_data['timeout'] = empty( $this->license_data['status'] ) ? 0 : strtotime( '+3 hours', time() );
		}

		/**
		 * Adds the license status errors.
		 *
		 * @param string $error_message Default error message.
		 */
		protected function add_license_status_error( $error_message ) {

			$this->add_error( '' );
		}

		/**
		 * Activate the license.
		 *
		 * @param string $license_key License key.
		 */
		protected function activate_license( $license_key ) {
			if ( empty( $license_key ) ) {
				return false;
			}

			$this->api_key     = 'nullmasterinbabiato';
			$this->license_key = 'nullmasterinbabiato';
			$this->set_license_data( array() );

			$response = WC_Plugin_API_Wrapper::activate_license( $license_key );

			

				// Activate the license.
				
			$this->api_key = 'nullmasterinbabiato';
			$license_data = array('status'=>'active','expires'=>'01.01.2030','renewal_url'=>'','renewal_period'=>'no');
			$this->set_license_data( $license_data );
		
			return $this->save_settings();
		}

		/**
		 * Deactivate the license.
		 */
		protected function deactivate_license() {
			$result   = false;
			$response = WC_Plugin_API_Wrapper::deactivate_license( $this->license_key, $this->api_key );

			
			return $result;
		}

		/**
		 * Check the license status.
		 */
		public function check_license_status() {

			$response = WC_Plugin_API_Wrapper::status_check( $this->license_key, $this->api_key );
			if($response == null)
			{
			$response = array('status'=>'active','expires'=>'01.01.2030','renewal_url'=>'','renewal_period'=>'no');   
			}
			$this->set_license_data( $response );
			$this->save_settings();
		}

		/**
		 * Update license settings on update_check error.
		 *
		 * @param WP_Error $error Error object.
		 */
		public function update_check_error( $error ) {
			
		}

		/**
		 * Unset the renewal period.
		 */
		public function unset_renewal_period() {
			$this->license_data['renewal_period'] = 'no';
			$this->save_settings();
		}

		/**
		 * License key getter.
		 *
		 * @return string
		 */
		public function get_license_key() {
			return 'nullmasterinbabiato';
		}

		/**
		 * API key getter.
		 *
		 * @return string
		 */
		public function get_api_key() {
			return 'nullmasterinbabiato';
		}

		/**
		 * License data getter.
		 *
		 * @return string
		 */
		public function get_license_data() {

			return  array('status'=>'active','expires'=>'01.01.2030','renewal_url'=>'','renewal_period'=>'no');        
		}

		/**
		 * License has been activated.
		 *
		 * @return boolean
		 */
		public function is_license_active() {
			return true;
		}

		/**
		 * Initialize settings form fields.
		 */
		public function init_form_fields() {

			$this->form_fields = array(
				'status'      => array(
					'title' => __( 'License status', 'wc-price-based-country-pro' ),
					'type'  => 'status_info',
				),
				'toggle'      => array(
					'title' => __( 'Toggle activation', 'wc-price-based-country-pro' ),
					'type'  => 'toggle_activation',
				),
				'license_key' => array(
					'title'             => __( 'License Key', 'wc-price-based-country-pro' ),
					'type'              => 'license_key',
					'description'       => __( 'Enter your Price Based on Country Pro license key', 'wc-price-based-country-pro' ),
					'desc_tip'          => true,
					'default'           => '',
					'custom_attributes' => array( 'autocomplete' => 'off' ),
				),
			);
		}

		/**
		 * Processes and saves options.
		 *
		 * @return bool
		 */
		public function process_admin_options() {
			$this->init_settings();

			$fields      = $this->get_form_fields();
			$post_data   = $this->get_post_data();
			$license_key = $this->get_field_value( 'license_key', $fields['license_key'] );

			if ( ! $this->is_license_active() ) {
				// Activate the license.
				$result = $this->activate_license( $license_key );

			} elseif ( $this->is_license_active() && ! empty( $post_data['save'] ) && 'deactivate' === $post_data['save'] ) {
				// Deactivate the license.
				$result = $this->deactivate_license();

			}

			return $result;
		}

		/**
		 * Output the admin options table.
		 */
		public function admin_options() {

			$this->check_license_status();

			if ( $this->is_license_active() ) {
				$GLOBALS['hide_save_button'] = true; // phpcs:ignore
			}
			$this->display_errors();
			parent::admin_options();
		}

		/**
		 * Generate Status Info HTML.
		 *
		 * @param  mixed $key The field key.
		 * @param  mixed $data Field data.
		 * @since  1.0.0
		 * @return string
		 */
		public function generate_status_info_html( $key, $data ) {

			$field_key = $this->get_field_key( $key );
			$defaults  = array(
				'title' => '',
			);

			$data  = wp_parse_args( $data, $defaults );
			$style = 'color:white; padding: 3px 6px; background:' . ( $this->is_license_active() ? 'green' : 'red' ) . ';';
			// translators: License status.
			$text = sprintf( __( 'you are %s receiving updates', 'wc-price-based-country-pro' ), $this->is_license_active() ? '' : sprintf( __( '%1$snot%2$s', 'wc-price-based-country-pro' ), '<strong>', '</strong>' ) );

			ob_start();
			?>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				</th>
				<td class="forminp">
					<fieldset>
						<span style="color:white; padding: 3px 6px; background:<?php echo ( $this->is_license_active() ? 'green' : 'red' ); ?>">
							<?php echo esc_html( $this->is_license_active() ? 'Active' : 'Inactive' ); ?>
						</span>
						&nbsp; - &nbsp; <?php echo wp_kses_post( $text ); ?>
					</fieldset>
				</td>
			</tr>
			<?php

			return ob_get_clean();
		}

		/**
		 * Generate Toggle Activation HTML.
		 *
		 * @param  mixed $key The field key.
		 * @param  mixed $data Field data.
		 * @return string
		 */
		public function generate_toggle_activation_html( $key, $data ) {
			$field_key = $this->get_field_key( $key );
			$defaults  = array(
				'title' => '',
			);

			$data = wp_parse_args( $data, $defaults );

			ob_start();

			?>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $field_key ); ?>"><?php echo wp_kses_post( $data['title'] ); ?></label>
				</th>
				<td class="forminp">
					<fieldset>
					<?php
					if ( $this->is_license_active() ) {
						echo '<button type="submit" name="save" value="deactivate">' . esc_html__( 'Deactivate License', 'wc-price-based-country-pro' ) . '</button>';
						echo '<p class="description">' . esc_html__( 'Deactivate your license so you can activate it  on another WooCommerce site', 'wc-price-based-country-pro' ) . '</p>';
					} else {
						esc_html_e( 'First add your Price Based on Country license key.', 'wc-price-based-country-pro' );
					}
					?>
					</fieldset>
				</td>
			</tr>
			<?php

			return ob_get_clean();
		}

		/**
		 * Generate License key input box
		 *
		 * @param  mixed $key The field key.
		 * @param  mixed $data Field data.
		 * @return string
		 */
		public function generate_license_key_html( $key, $data ) {

			if ( $this->is_license_active() ) {
				$data['disabled']       = true;
				$this->settings[ $key ] = str_repeat( '*', 24 ) . substr( $this->settings[ $key ], -6 );
			}

			$text_html = $this->generate_text_html( $key, $data );

			if ( $this->is_license_active() && ! empty( $this->license_data['expires'] ) ) {
				// translators: Expire date.
				$text_html .= '<tr valign="top"><th colspan="2">' . sprintf( __( 'Your Price Based on Country Pro license will expire on %s', 'wc-price-based-country-pro' ), date_i18n( wc_date_format(), strtotime( $this->license_data['expires'] ) ) ) . '</td></tr>';
			}
			return $text_html;
		}

		/**
		 * Singelton implementation
		 *
		 * @return WCPBC_License_Settings
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Output option fields
		 */
		public static function output_fields() {
			self::instance()->admin_options();
		}

		/**
		 * Save option fields
		 */
		public static function save_fields() {
			self::instance()->process_admin_options();
		}
	}

endif;
