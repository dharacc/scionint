<?php
/**
 * Instagram WP class file.
 *
 * @package Instagram WP
 */

/**
 * Instagram WP class.
 *
 * @since 1.0.0
 */
class PGS_InstaWP {

	/**
	 * Options prefix.
	 *
	 * @var string
	 */
	protected $option_prefix = 'pgs_instawp';

	/**
	 * App ID.
	 *
	 * @var string
	 */
	protected $app_id;

	/**
	 * App Secret.
	 *
	 * @var string
	 */
	protected $app_secret;

	/**
	 * Access key.
	 *
	 * @var string
	 */
	protected $access_token;

	/**
	 * Instagram Settings Page.
	 *
	 * @var string
	 */
	protected $settings_page = 'pgs_instawp';

	protected $settings_page_url = '';

	protected $image_count = 12;
	protected $image_fetch_duration = 2;

	/**
	 * Constructor. Don't call directly, @see instance() instead.
	 *
	 * @see instance()
	 *
	 * @return void
	 **/
	public function __construct() {

		$this->option_name = $this->option_prefix . '_settings';

		$this->app_id                = get_option( 'pgs_instawp_app_id' );
		$this->app_secret            = get_option( 'pgs_instawp_app_secret' );
		$this->access_token          = get_option( 'pgs_instawp_access_token' );
		$this->token_expiration_time = get_option( 'pgs_instawp_token_expiration_time' );
		$this->user_id               = get_option( 'pgs_instawp_user_id' );
		$this->image_count           = get_option( 'pgs_instawp_image_count', 12 );
		$this->image_fetch_duration  = get_option( 'pgs_instawp_image_fetch_duration' );
		$this->other_size_images     = get_option( 'pgs_instawp_get_other_size_images' );

		$this->set_settings_page_url();

		add_action( 'init', array( $this, 'save_access_token' ) );
		add_action( 'init', array( $this, 'refresh_access_token' ) );
		add_action( 'init', array( $this, 'refresh_access_token_cron' ) );
		add_action( 'init', array( $this, 'unregister_access_token' ) );
		add_action( 'init', array( $this, 'get_instagram_images_manually' ) );
		add_action( 'init', array( $this, 'get_instagram_images' ) );

		// $this->init();
		$this->init_settings();
	}

	public function get_instagram_images_manually() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		if (
			( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && $this->settings_page === $_GET['page'] )
			&& ( isset( $_GET['action'] ) && ! empty( $_GET['action'] ) && 'refresh_images_manually' === $_GET['action'] )
		) {
			$this->get_instagram_images( true );
		}
	}

	public function get_instagram_images( $manually = false ) {
		$manually  = (bool) $manually;

		if ( empty( $this->app_id ) || empty( $this->app_secret ) || empty( $this->access_token ) || empty( $this->user_id ) ) {
			return;
		}

		$image_fetch_hour = $this->image_fetch_duration;

		/**
		 * Filters arguments for instagram cache time.
		 *
		 * @param int    $cache_time      Cache time in seconds.
		 *
		 * @visible true
		 */
		$image_fetch_duration = apply_filters( 'ciyashop_instagram_cache_time', HOUR_IN_SECONDS * $image_fetch_hour );

		$image_limit   = $this->image_count;
		$app_cred_hash = md5( $this->app_id . $this->app_secret );
		$transient_key = "pgs_instawp-instagram-images-{$this->user_id}-{$image_limit}itm-{$image_fetch_hour}hrs-{$app_cred_hash}";
		$images_data   = array();

		$get_image_logger = wc_get_logger();

		// $context may hold arbitrary data.
		// If you provide a "source", it will be used to group your logs.
		// More on this later.
		$get_image_logger_context = array( 'source' => 'get_image' );
		$get_image_logger->debug( 'Inside "get_instagram_images" function....', $get_image_logger_context );

		if ( true === $manually || WP_DEBUG || false === ( $images_data = get_transient( $transient_key ) ) ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
			$get_image_logger->debug( sprintf( 'Inside Transient Check (%s):', ($manually ? 'Manual': 'Auto') ), $get_image_logger_context );
			$params          = array(
				'access_token' => $this->access_token,
				'user_id'      => $this->user_id,
			);
			$instagram_api   = new PGS_Instagram_API( $this->app_id, $this->app_secret, $params );
			$medias_response = $instagram_api->get_user_media(
				array(
					'limit' => $image_limit,
				)
			);

			if ( ! isset( $medias_response['data'] ) || ! is_array( $medias_response['data'] ) || empty( $medias_response['data'] ) ) {
				delete_option( 'pgs_instawp_user_medias' );
				delete_transient( $transient_key );
				return;
			}

			$medias = $medias_response['data'];

			foreach ( $medias as $media ) {
				$get_image_logger->debug( 'Image Id: ' . $media['id'], $get_image_logger_context );

				$new_media = new stdClass();

				$new_media->id              = $media['id'];
				$new_media->link            = $media['permalink'];
				$new_media->media_type      = $media['media_type'];
				$new_media->media_url       = $media['media_url'];
				$new_media->media_thumbnail = 'VIDEO' === $media['media_type'] ? $media['thumbnail_url'] : $media['media_url'];
				$new_media->caption         = ( isset( $media['caption'] ) ) ? $media['caption'] : '';
				$new_media->images          = new stdClass();

				$new_media->images->low_resolution     = new stdClass();
				$new_media->images->thumbnail          = new stdClass();
				$new_media->images->standard_resolution= new stdClass();

				$get_other_size = ( 'on' === $this->other_size_images );

				if ( $get_other_size ) {
					$get_image_logger->debug( 'Getting other image sizes...', $get_image_logger_context );
					/**
					 * @var array|WP_Error $response
					 */
					$low_resolution_response = wp_remote_get( trailingslashit( $media['permalink'] ) . 'media?size=t' );
					if ( is_array( $low_resolution_response ) && ! is_wp_error( $low_resolution_response ) ) {
						$get_image_logger->debug( 'Getting low resolution image...', $get_image_logger_context );
						$new_media->images->low_resolution->url = $low_resolution_response['http_response']->get_response_object()->url;
					}

					/**
					 * @var array|WP_Error $response
					 */
					$thumbnail_response = wp_remote_get( trailingslashit( $media['permalink'] ) . 'media?size=m' );
					if ( is_array( $thumbnail_response ) && ! is_wp_error( $thumbnail_response ) ) {
						$get_image_logger->debug( 'Getting medium resolution image...', $get_image_logger_context );
						$new_media->images->thumbnail->url = $thumbnail_response['http_response']->get_response_object()->url;
					}
				} else {
					$new_media->images->low_resolution->url = $new_media->media_thumbnail;
					$new_media->images->thumbnail->url      = $new_media->media_thumbnail;
				}

				$new_media->images->standard_resolution->url = $new_media->media_thumbnail;

				$images_data[] = $new_media;

			}

			if ( empty( $images_data ) ) {
				delete_option( 'pgs_instawp_user_medias' );
				delete_transient( $transient_key );
				return;
			}

			set_transient( $transient_key, $images_data, $image_fetch_duration );
			$get_image_logger->debug( 'Transient Check Ended:', $get_image_logger_context );
		}

		if ( ! empty( $images_data ) ) {
			update_option( 'pgs_instawp_user_medias', $images_data );
		}

		if ( $manually ) {
			$settings_page = $this->get_settings_page_url();

			wp_redirect( $settings_page );
			exit;
		}
	}

	public function save_access_token() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		if (
			( isset( $_GET['code'] ) && ! empty( $_GET['code'] ) )
			&& ( isset( $_GET['state'] ) && ! empty( $_GET['state'] ) && 'pgs_instawp_callback_state' === $_GET['state'] )
		) {
			$short_token   = $_GET['code'];
			$params        = array(
				'get_code'=> $short_token,
			);
			$instagram_api = new PGS_Instagram_API( $this->app_id, $this->app_secret, $params );

			$user_id               = $instagram_api->user_id;
			$access_token          = $instagram_api->get_user_access_token();
			$token_expiration_time = $instagram_api->get_user_access_token_expires_in() + time();

			update_option( 'pgs_instawp_access_token', $access_token );
			update_option( 'pgs_instawp_token_expiration_time', $token_expiration_time );
			update_option( 'pgs_instawp_user_id', $user_id );

			$settings_page = $this->get_settings_page_url();

			wp_redirect( $settings_page );
			exit;
		}

	}

	public function refresh_access_token() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		if (
			( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && $this->settings_page === $_GET['page'] )
			&& ( isset( $_GET['action'] ) && ! empty( $_GET['action'] ) && 'refresh_access_token' === $_GET['action'] )
		) {
			$this->refresh_access_token_callback();
			$settings_page = $this->get_settings_page_url();

			wp_redirect( $settings_page );
			exit;
		}
	}

	public function refresh_access_token_cron() {

		$token_expiration_time = $this->token_expiration_time;

		if ( ( $token_expiration_time - ( 10 * 24 * 60 * 60 ) ) < time() ) {
			$this->refresh_access_token_callback();
		}
	}

	public function refresh_access_token_callback() {
		$params        = array(
			'access_token' => $this->access_token,
			'user_id'      => $this->user_id,
		);
		$instagram_api = new PGS_Instagram_API( $this->app_id, $this->app_secret, $params );

		if ( $instagram_api->refresh_access_token() ) {
			$user_id               = $this->user_id;
			$access_token          = $instagram_api->get_user_access_token();
			$token_expiration_time = $instagram_api->get_user_access_token_expires_in() + time();

			update_option( 'pgs_instawp_user_id', $user_id );
			update_option( 'pgs_instawp_access_token', $access_token );
			update_option( 'pgs_instawp_token_expiration_time', $token_expiration_time );
		}
	}

	function unregister_access_token() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		if (
			( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && $this->settings_page === $_GET['page'] )
			&& ( isset( $_GET['action'] ) && ! empty( $_GET['action'] ) && 'unregister_access_token' === $_GET['action'] )
		) {
			delete_option( 'pgs_instawp_access_token' );
			delete_option( 'pgs_instawp_token_expiration_time');
			delete_option( 'pgs_instawp_user_id' );

			$settings_page = $this->get_settings_page_url();

			wp_redirect( $settings_page );
			exit;
		}

	}

	public function init_settings() {

		$params             = array(
			'access_token' => ! empty( $this->access_token ) ? $this->access_token : '',
			'state'        => 'pgs_instawp_callback_state',
			'user_id'      => $this->user_id,
		);
		$instagram_api      = new PGS_Instagram_API( $this->app_id, $this->app_secret, $params );
		$instagram_auth_url = $instagram_api->get_authorization_url();
		$callback_url       = $instagram_api->callback_url();

		/**
		 * Object for the class `PGS_InstaWP_Settings`.
		 */
		$pgs_instawp_settings = new PGS_InstaWP_Settings( array(
			'page_title'    => esc_html__( 'PGS InstaWP Settings', 'pgs-core' ),
			'menu_title'    => esc_html__( 'PGS InstaWP', 'pgs-core' ),
			'menu_slug'     => $this->settings_page,
			'option_prefix' => $this->option_prefix,
		) );

		$pgs_instawp_general_fields = array(
			array(
				'id'          => 'pgs_instawp_redirection_url',
				'type'        => 'text',
				'title'       => esc_html__( 'Redirection URL', 'pgs-core' ),
				'desc'        => esc_html__( 'Copy this URL and add it in your Instagram application in "Valid redirect URIs" field.', 'pgs-core' )
				. '<br><br><div class="pgs-instawp-alert pgs-instawp-alert-danger">'
				. sprintf(
					__( '"HTTPS" is required for Redirection URL. Refer <a href="%1$s" target="_blank" rel="noreferrer noopener">this</a> link for more information.' ),
					esc_url( 'https://docs.potenzaglobalsolutions.com/faq/facebook-app-redirect-uris-https-requirements/' )
				)
				. '<div>',
				'readonly'    => true,
				'default'     => $callback_url,
				'value'       => $callback_url,
				'desc_kses' => array(
					'br'     => array(),
					'a' => array(
						'href'   => true,
						'target' => true,
						'rel'    => true,
					),
					'strong' => array(),
					'div'    => array(
						'style' => array(),
						'class' => array(),
					),
				)
			),
			array(
				'id'         => 'pgs_instawp_app_id',
				'type'       => 'text',
				'title'      => esc_html__( 'Instagram App ID', 'pgs-core' ),
				'desc'       => esc_html__( 'Enter Instagram app ID here.', 'pgs-core' ),
				'with_btn'   => true,
				'btn_params' => array(
					'link_title'        => esc_html__( 'Click here to get/generate app credentials.', 'pgs-core' ),
					'target'            => '_blank',
					'value'             => 'https://developers.facebook.com/apps/',
				),
			),
			array(
				'id'         => 'pgs_instawp_app_secret',
				'type'       => ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) ? 'text' : 'password',
				'title'      => esc_html__( 'Instagram App Secret', 'pgs-core' ),
				'desc'       => esc_html__( 'Enter Instagram app secret here.', 'pgs-core' ),
				'with_btn'   => true,
				'btn_params' => array(
					'link_title'        => esc_html__( 'Click here to get/generate app credentials.', 'pgs-core' ),
					'target'            => '_blank',
					'value'             => 'https://developers.facebook.com/apps/',
				),
			),
		);

		if ( $this->app_id && $this->app_secret ) {
			if ( ! $this->access_token || empty( $this->access_token ) ) {
				$pgs_instawp_general_fields[] = array(
					'id'         => 'pgs_instawp_access_token_btn',
					'type'       => 'link',
					'title'      => esc_html__( 'Access Token', 'pgs-core' ),
					'link_title' => esc_html__( 'Generate Access Token', 'pgs-core' ),
					'value'      => $instagram_auth_url,
					'link_type'  => 'button',
				);
			} else {
				$pgs_instawp_general_fields[] = array(
					'id'         => 'pgs_instawp_access_token_view',
					'type'       => ( defined( 'PGS_DEV_DEBUG' ) && PGS_DEV_DEBUG ) ? 'text' : 'password',
					'title'      => esc_html__( 'Access Token', 'pgs-core' ),
					'value'      => $this->access_token,
					'readonly'   => true,
				);
				if ( ! empty( $this->token_expiration_time ) ) {
					$pgs_instawp_general_fields[] = array(
						'id'         => 'pgs_instawp_token_experation_date_view',
						'type'       => 'text',
						'title'      => esc_html__( 'Token Expiration Date', 'pgs-core' ),
						'value'      => date( 'd-m-Y H:i:s', $this->token_expiration_time ),
						'readonly'   => true,
					);
				}
				if ( ! empty( $this->user_id ) ) {
					$pgs_instawp_general_fields[] = array(
						'id'         => 'pgs_instawp_user_id_view',
						'type'       => 'text',
						'title'      => esc_html__( 'User ID', 'pgs-core' ),
						'value'      => $this->user_id,
						'readonly'   => true,
					);
				}

				$unregister_access_token_url = add_query_arg( array(
					'page'   => 'pgs_instawp',
					'action' => 'unregister_access_token',
				), admin_url( 'options-general.php' ) );

				$pgs_instawp_general_fields[] = array(
					'id'         => 'pgs_instawp_unregister_access_token_btn',
					'type'       => 'link',
					'title'      => '',
					'link_title' => esc_html__( 'Unregister Accesss Token', 'pgs-core' ),
					'value'      => $unregister_access_token_url,
					'link_type'  => 'button',
				);

				$refresh_access_token_url = add_query_arg( array(
					'page'   => 'pgs_instawp',
					'action' => 'refresh_access_token',
				), admin_url( 'options-general.php' ) );

				$pgs_instawp_general_fields[] = array(
					'id'         => 'pgs_instawp_refresh_access_token_btn',
					'type'       => 'link',
					'title'      => '',
					'link_title' => esc_html__( 'Refresh Accesss Token', 'pgs-core' ),
					'value'      => $refresh_access_token_url,
					'link_type'  => 'button',
				);
			}
		} else {
			$pgs_instawp_general_fields[] = array(
				'id'      => 'pgs_instawp_access_token_notice',
				'type'    => 'html',
				'title'   => esc_html__( 'Access Token', 'pgs-core' ),
				'value'   => __( 'Please enter <strong>Client ID</strong> and <strong>Client Secret</strong> to generate <strong>Access Token</strong>.', 'pgs-core' ),
				'wp_kses' => array(
					'strong' => array(),
				),
			);
		}

		$pgs_instawp_fields = array(
			'pgsiwp_general' => array(
				'id'     => 'pgs_instawp_general',
				'title'  => esc_html__( 'General Settings', 'pgs-core' ),
				'fields' => $pgs_instawp_general_fields,
			)
		);

		$refresh_images_manually_url = add_query_arg( array(
			'page'   => 'pgs_instawp',
			'action' => 'refresh_images_manually',
		), admin_url( 'options-general.php' ) );

		$pgs_instawp_fields['pgsiwp_image'] = array(
			'id'     => 'pgs_instawp_image',
			'title'  => esc_html__( 'Image Settings', 'pgs-core' ),
			'fields' => array(
				array(
					'id'      => 'pgs_instawp_image_count',
					'type'    => 'number',
					'min'     => 12,
					'max'     => 100,
					'step'    => 1,
					'default' => 12,
					'title'   => esc_html__( 'Image Count', 'pgs-core' ),
					'desc'    => esc_html__( 'Enter number of images to fetch from Instagram API.', 'pgs-core' ),
					'size'    => 'regular',
				),
				array(
					'id'      => 'pgs_instawp_image_fetch_duration',
					'type'    => 'select',
					'title'   => esc_html__( 'Image Fetch Duration', 'pgs-core' ),
					'desc'    => esc_html__( 'Select interval of hours to fetch images from Instagram.', 'pgs-core' ),
					'options' => array(
						1   => esc_html__( '1 Hour', 'pgs-core' ),
						2   => esc_html__( '2 Hours', 'pgs-core' ),
						3   => esc_html__( '3 Hours', 'pgs-core' ),
						4   => esc_html__( '4 Hours', 'pgs-core' ),
						6   => esc_html__( '6 Hours', 'pgs-core' ),
						12  => esc_html__( '12 Hours', 'pgs-core' ),
						24  => esc_html__( '24 Hours (One Day)', 'pgs-core' ),
						48  => esc_html__( '48 Hours (Two Days)', 'pgs-core' ),
						168 => esc_html__( '168 Hours (1 Week)', 'pgs-core' ),
					),
					'default' => 12,
					'size'    => 'regular',
				),
				array(
					'id'    => 'pgs_instawp_get_other_size_images',
					'type'  => 'checkbox',
					'title' => esc_html__( 'Get other size images', 'pgs-core' ),
					'desc'  => __( 'The current Instagram API does not provide small and medium-sized images. If you want to get these size images select this option.', 'pgs-core' )
					. '<br><br><div class="pgs-instawp-alert pgs-instawp-alert-warning">'
					.  __( '<strong>Note:</strong> Choosing this option will increase the code execution time to get images from Instagram and process other size images. So, make sure your system is configured to handle the long executing processes. If the system isn\'t configured properly, the image fetching process may break.', 'pgs-core' )
					.'</div>',
					'desc_kses' => array(
						'br'     => array(),
						'strong' => array(),
						'div'    => array(
							'class' => array(),
						),
					),
				),
				array(
					'id'         => 'pgs_instawp_refresh_images_manually_btn',
					'type'       => 'link',
					'title'      => esc_html__( 'Refresh Image Manually', 'pgs-core' ),
					'link_title' => esc_html__( 'Refresh Image Manually', 'pgs-core' ),
					'value'      => $refresh_images_manually_url,
					'link_type'  => 'button',
				),
			),
		);

		$pgs_instawp_fields['pgsiwp_instruction_tab'] = array(
			'id'     => 'pgs_instawp_instruction_tab',
			'title'  => esc_html__( 'Instructions', 'pgs-core' ),
			'fields' => array(
				array(
					'id'      => 'pgs_instawp_instruction',
					'type'    => 'iframe',
					'value'   => 'https://docs.potenzaglobalsolutions.com/faq/generate-facebook-app-and-get-instagram-app-id-secret/?is_iframe=yes',
					'height'  => '800px',
					'title'   => esc_html__( 'Token Generation Instructions', 'pgs-core' ),
					'desc'    => esc_html__( 'Enter number of images to fetch from Instagram API.', 'pgs-core' ),
				),
			),
		);

		$pgs_instawp_fields = apply_filters( 'pgs_instawp_fields', $pgs_instawp_fields );

		foreach ( $pgs_instawp_fields as $section ) {
			$pgs_instawp_settings->add_section(
				array(
					'id'    => $section['id'],
					'title' => $section['title'],
				)
			);

			foreach ( $section['fields'] as $field ) {

				$pgs_instawp_settings->add_field(
					$section['id'],
					$field
				);

			}
		}

	}

	protected function set_settings_page_url(){
		$this->settings_page_url = add_query_arg( array(
			'page' => $this->settings_page,
		), admin_url( 'options-general.php' ) );
	}

	protected function get_settings_page_url(){
		return $this->settings_page_url;
	}

}

$pgs_instawp = new PGS_InstaWP();

add_action( 'allowed_options', 'pgs_instawp_allowed_options', 99999 );
function pgs_instawp_allowed_options( $allowed_options ) {
	if ( isset( $allowed_options['pgs_instawp_general'] ) ) {
		$allowed_options['pgs_instawp_general'] = array(
			'pgs_instawp_app_id',
			'pgs_instawp_app_secret',
		);
	}

	if ( isset( $allowed_options['pgs_instawp_image'] ) ) {
		$allowed_options['pgs_instawp_image'] = array(
			'pgs_instawp_image_count',
			'pgs_instawp_image_fetch_duration',
			'pgs_instawp_get_other_size_images',
		);
	}

	if ( isset( $allowed_options['pgs_instawp_instruction_tab'] ) ) {
		$allowed_options['pgs_instawp_instruction_tab'] = array();
	}
	return $allowed_options;
}
