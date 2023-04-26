<?php
/**
 * PGS_Instagram API class wrapper.
 *
 * @package pgs-core
 */

/**
 * PGS_Instagram_API class.
 */
class PGS_Instagram_API {

	/**
	 * App ID.
	 *
	 * @var   string
	 */
	private $app_id = '';

	/**
	 * APP Secret.
	 *
	 * @var   string
	 */
	private $app_secret = '';

	/**
	 * Get code.
	 *
	 * @var   string
	 */
	private $get_code = '';


	/**
	 * Oauth callback URL.
	 *
	 * @var   string
	 */
	private $state = '';

	/**
	 * API Base URL.
	 *
	 * @var   string
	 */
	private $api_base_url = 'https://api.instagram.com/';

	/**
	 * Graph Base URL.
	 *
	 * @var   string
	 */
	private $graph_base_url = 'https://graph.instagram.com/';

	/**
	 * User access token.
	 *
	 * @var   string
	 */
	private $user_access_token = '';

	/**
	 * User access token expires in (seconds).
	 *
	 * @var   string
	 */
	private $user_access_token_expires_in = '';

	/**
	 * Authorization URL.
	 *
	 * @var   string
	 */
	public $authorization_url = '';

	/**
	 * Refresh Access Token URL.
	 *
	 * @var   string
	 */
	public $refresh_access_token_url = '';

	/**
	 * Whether has user access token.
	 *
	 * @var   boolean
	 */
	public $has_user_access_token = false;

	/**
	 * User ID.
	 *
	 * @var   string
	 */
	public $user_id = '';

	/**
	 * Constructor.
	 *
	 * @param array  $params       Constructor params.
	 * @param string $app_id       App ID.
	 * @param string $app_secret   App Secret.
	 */
	public function __construct( $app_id, $app_secret, $params ) {
		// save instagram code.
		$this->get_code   = ! empty( $params['get_code'] ) ? $params['get_code'] : '';
		$this->state      = ! empty( $params['state'] ) ? $params['state'] : '';
		$this->app_id     = $app_id;
		$this->app_secret = $app_secret;

		// get an access token.
		$this->set_user_instagram_access_token( $params );

		// get authorization url.
		$this->set_authorization_url();
		$this->set_refresh_access_token_url();
	}

	public function get_user_access_token() {
		return $this->user_access_token;
	}

	public function get_user_access_token_expires_in() {
		return $this->user_access_token_expires_in;
	}

	/**
	 * Set authorization url.
	 */
	private function set_authorization_url() {
		$get_vars = array(
			'app_id'        => $this->app_id,
			'redirect_uri'  => $this->callback_url(),
			'scope'         => 'user_profile,user_media',
			'response_type' => 'code',
			'state'         => ! empty( $this->state ) ? $this->state : '',
		);

		// create url.
		$this->authorization_url = trailingslashit( $this->api_base_url ) . 'oauth/authorize?' . http_build_query( $get_vars );
	}

	/**
	 * Get authorization url.
	 */
	public function get_authorization_url() {
		return $this->authorization_url;
	}

	/**
	 * Set refresh access token url.
	 */
	private function set_refresh_access_token_url() {

		$refresh_access_token_url = add_query_arg(
			array(
				'action' => 'instagram_refresh_access_token',
			),
			get_home_url()
		);

		// set url.
		$this->refresh_access_token_url = $refresh_access_token_url;
	}

	/**
	 * Get refresh access token url.
	 */
	public function get_refresh_access_token_url() {
		return $this->refresh_access_token_url;
	}

	private function set_user_instagram_access_token( $params ) {
		if ( ! empty( $params['access_token'] ) ) { // we have an access token.
			$this->user_access_token     = $params['access_token'];
			$this->has_user_access_token = true;
			$this->user_id               = $params['user_id'];
		} elseif ( ! empty( $params['get_code'] ) ) { // try and get an access token.
			$user_access_token_response  = $this->get_user_access_token_call();
			$this->user_access_token     = $user_access_token_response['access_token'];
			$this->has_user_access_token = true;
			$this->user_id               = $user_access_token_response['user_id'];

			// get long lived access token.
			$long_lived_access_token_response    = $this->get_long_lived_user_access_token();
			$this->user_access_token             = $long_lived_access_token_response['access_token'];
			$this->user_access_token_expires_in  = $long_lived_access_token_response['expires_in'];
		}
	}

	private function get_user_access_token_call() {

		$params = array(
			'endpoint_url' => trailingslashit( $this->api_base_url ) . 'oauth/access_token',
			'type'         => 'POST',
			'url_params'   => array(
				'app_id'       => $this->app_id,
				'app_secret'   => $this->app_secret,
				'grant_type'   => 'authorization_code',
				'redirect_uri' => $this->callback_url(),
				'code'         => $this->get_code,
			),
		);

		$response = $this->make_api_call( $params );

		return $response;
	}

	private function get_long_lived_user_access_token() {

		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . 'access_token',
			'type'         => 'GET',
			'url_params'   => array(
				'client_secret' => $this->app_secret,
				'grant_type'    => 'ig_exchange_token',
			),
		);

		$response = $this->make_api_call( $params );

		return $response;
	}

	public function get_user() {
		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . 'me',
			'type'         => 'GET',
			'url_params'   => array(
				'fields' => 'id,username,media_count,account_type',
			),
		);

		$response = $this->make_api_call( $params );
		return $response;
	}

	public function get_user_media( $args = array() ) {

		$user_id = 'me';

		if ( isset( $args['user_id'] ) && ! empty( $args['user_id'] ) ) {
			$user_id = $args['user_id'];
		}

		if ( empty( $user_id ) ) {

			$user = $this->get_user();

			if ( isset( $user['id'] ) && ! empty( $user['id'] ) ) {
				$user_id = $user['id'];
			}

		}

		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . "{$user_id}/media",
			'type'         => 'GET',
			'url_params'   => array(
				'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url',
			),
		);

		if ( isset( $args['limit'] ) && ! empty( $args['limit'] ) ) {
			$params['url_params'] = array_merge( $params['url_params'], array( 'limit' => absint( $args['limit'] ) ) );
		}

		$response = $this->make_api_call( $params );

		return $response;
	}

	public function get_paging( $paging_endpoint ) {
		$params = array(
			'endpoint_url' => $paging_endpoint,
			'type'         => 'GET',
			'url_params'   => array(
				'paging' => true,
			),
		);

		$response = $this->make_api_call( $params );
		return $response;
	}

	public function get_media( $media_id ) {
		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . $media_id,
			'type'         => 'GET',
			'url_params'   => array(
				'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username',
			),
		);

		$response = $this->make_api_call( $params );
		return $response;
	}

	public function get_media_children( $media_id ) {
		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . $media_id . '/children',
			'type'         => 'GET',
			'url_params'   => array(
				'fields' => 'id,media_type,media_url,permalink,thumbnail_url,timestamp,username',
			),
		);

		$response = $this->make_api_call( $params );
		return $response;
	}

	public function refresh_access_token() {
		$params = array(
			'endpoint_url' => trailingslashit( $this->graph_base_url ) . 'refresh_access_token',
			'type'         => 'GET',
			'url_params'   => array(
				'grant_type' => 'ig_refresh_token',
			),
		);

		$response = $this->make_api_call( $params );

		if ( ! empty( $response['access_token'] ) && ! empty( $response['expires_in'] ) ) {
			$this->user_access_token            = $response['access_token'];
			$this->user_access_token_expires_in = $response['expires_in'];
			return true;
		}

		return false;
	}

	private function make_api_call( $params ) {
		$ch = curl_init();

		$endpoint = $params['endpoint_url'];

		if ( 'POST' === $params['type'] ) { // post request.
			curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params['url_params'] ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );
		} elseif ( 'GET' === $params['type'] ) { // get request.
			$params['url_params']['access_token'] = $this->user_access_token;

			// add params to endpoint.
			$endpoint .= '?' . http_build_query( $params['url_params'] );
		}

		// general curl options.
		curl_setopt( $ch, CURLOPT_URL, $endpoint );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );

		curl_close( $ch );

		$response_array = json_decode( $response, true );
		if ( isset( $response_array['error_type'] ) ) {
			var_dump( $response_array );
			die();
		} else {
			return $response_array;
		}
	}

	public static function callback_url( $url_encode = false ) {
		$url = get_home_url( null, '/', 'https' );
		if ( $url_encode ) {
			$url = $url;
		}
		return $url;
	}

}
