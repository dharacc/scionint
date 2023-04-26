<?php
/**
* Authentication widgets generator
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// pgs_social_login action
add_action( 'pgs_social_login', 'pgssl_action_pgs_social_login' );

// Display on login form
// add_action( 'login_form'                   , 'pgssl_render_auth_widget_in_wp_login_form' );
add_action( 'login_footer'                    , 'pgssl_render_auth_widget_in_wp_login_form' );

// WooCommerce Login Form
add_action( 'woocommerce_login_form_end'      , 'pgssl_render_auth_widget_in_wp_login_form' );

// BuddyPress Login Form
// add_action( 'bp_before_account_details_fields', 'pgssl_render_auth_widget_in_wp_login_form' );
// add_action( 'bp_after_sidebar_login_form'    , 'pgssl_render_auth_widget_in_wp_login_form' );
add_action( 'bp_after_login_widget_loggedout'    , 'pgssl_render_auth_widget_in_wp_login_form' );

// Display on comment area
// add_action( 'comment_form_top'           , 'pgssl_render_auth_widget_in_comment_form' );
// add_action( 'comment_form'               , 'pgssl_render_auth_widget_in_comment_form' );
add_action( 'comment_form_must_log_in_after', 'pgssl_render_auth_widget_in_comment_form' );

// Display on login & register form
// add_action( 'register_form'  , 'pgssl_render_auth_widget_in_wp_register_form' );
add_action( 'after_signup_form' , 'pgssl_render_auth_widget_in_wp_register_form' );


// Enqueue CSS file
add_action( 'wp_enqueue_scripts'   , 'pgssl_enqueue_stylesheets' );
add_action( 'login_enqueue_scripts', 'pgssl_enqueue_stylesheets' );

// Enqueue Javascript
add_action( 'wp_enqueue_scripts'   , 'pgssl_enqueue_javascripts' );
add_action( 'login_enqueue_scripts', 'pgssl_enqueue_javascripts' );

/**
 * pgs_social_login action
 */
function pgssl_action_pgs_social_login( $args = array() ) {
	pgssl_display_social_login( $args );
}

/**
 * Display on comment area
 */
function pgssl_render_auth_widget_in_comment_form() {
	if( comments_open() ) {
		pgssl_display_social_login();
	}
}

/**
 * Display on login form
 */
function pgssl_render_auth_widget_in_wp_login_form() {
	
	if (
		$GLOBALS['pagenow'] === 'wp-login.php'
		&& ( isset( $_REQUEST['action'] ) && ! empty( $_REQUEST['action'] ) )
		&& ( $_REQUEST['action'] !== 'register' && $_REQUEST['action'] !== 'login' )
	) {
		return;
	}
	
	pgssl_display_social_login();
}

/**
 * Display on login & register form
 */
function pgssl_render_auth_widget_in_wp_register_form() {
	pgssl_display_social_login();
}

/**
 * Enqueue CSS file
 */
function pgssl_enqueue_stylesheets() {
	wp_register_style( "pgssl-front", PGS_SOCIAL_LOGIN_PLUGIN_URL . "assets/css/pgssl-front.css" );
	wp_enqueue_style( "pgssl-front" );
}

/**
 * Enqueue Javascript
 */
function pgssl_enqueue_javascripts() {

	$pgssl_authentication_display = pgssl_authentication_display();

    // if a user is visiting using a mobile device, WSL will fall back to more in page
	$pgssl_authentication_display = function_exists( 'wp_is_mobile' ) ? wp_is_mobile() ? 2 : $pgssl_authentication_display : $pgssl_authentication_display;

	if( $pgssl_authentication_display != 1 ) {
		return null;
	}

	wp_register_script( "pgssl-front", PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/js/pgssl-front.js', array('jquery') );
	wp_enqueue_script( "pgssl-front" );
}

/**
* Generate the HTML content of Widget
*   [pgs_social_login
*        auth_mode="login"
*        caption="Connect with"
*        enable_providers="facebook|google"
*        restrict_content="pgssl_user_logged_in"
*        assets_base_url="http://example.com/wp-content/uploads/2022/01/"
*   ]
*
*   Overall, widget work with these simple rules :
*      1. Shortcode arguments rule over the defaults
*      2. Filters hooks rule over shortcode arguments
*      3. Bouncer rules over everything
*/
function pgssl_display_social_login( $args = array() ) {
	$pgssl_login_providers_config = pgssl_get_providers();
	
	$auth_mode = isset( $args['mode'] ) && $args['mode'] ? $args['mode'] : 'login';

	// validate auth-mode
	if( ! in_array( $auth_mode, array( 'login', 'link', 'test' ) ) ) {
		return;
	}

	// auth-mode eq 'login' => display widget only for NON logged in users
	// > this is the default mode of widget.
	if( $auth_mode == 'login' && is_user_logged_in() ) {
		return;
	}

	// auth-mode eq 'link' => display widget only for LOGGED IN users
	// > this will allows users to manually link other social network accounts to their WordPress account
	if( $auth_mode == 'link' && ! is_user_logged_in() ) {
		return;
	}

	// auth-mode eq 'test' => display widget only for LOGGED IN users only on dashboard
	// > used in Authentication Playground on admin dashboard
	if( $auth_mode == 'test' && ! is_user_logged_in() && ! is_admin() ) {
		return;
	}

	// Allow authentication?
	if( pgssl_social_authentication_enabled() == 2 ) {
		return;
	}

	// HOOKABLE: This action runs just before generating the Widget.
	do_action( 'pgssl_render_auth_widget_start' );

	$providers_config = pgssl_get_providers();

	// Icon set. If eq 'none', we show text instead
	$social_icon_set = get_option( 'pgssl_settings_social_icon_set' );

	// wpzoom icons set, is shown by default
	if( empty( $social_icon_set ) ) {
		$social_icon_set = "wpzoom/";
	}

	$assets_base_url  = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/32x32/' . $social_icon_set . '/';

	$assets_base_url  = isset( $args['assets_base_url'] ) && $args['assets_base_url'] ? $args['assets_base_url'] : $assets_base_url;

	// HOOKABLE:
	$assets_base_url = apply_filters( 'pgssl_render_auth_widget_alter_assets_base_url', $assets_base_url );

	// get the current page url, which we will use to redirect the user to,
	// unless Widget::Force redirection is set to 'yes', then this will be ignored and Widget::Redirect URL will be used instead
	$redirect_to = pgssl_get_current_url();

	// Use the provided redirect_to if it is given and this is the login page.
	if ( in_array( $GLOBALS["pagenow"], array( "wp-login.php", "wp-register.php" ) ) && !empty( $_REQUEST["redirect_to"] ) ) {
		$redirect_to = $_REQUEST["redirect_to"];
	}

	// build the authentication url which will call for pgssl_process_login() : action=pgssl_authenticate
	$authenticate_base_url = add_query_arg( array(
		'action' => 'pgssl_authenticate',
		'mode'   => 'login',
	), site_url( 'wp-login.php', 'login_post' ) );
	
	$social_login_enable_stat = false;
	foreach( $pgssl_login_providers_config AS $item ) {
		$provider_id    = isset( $item["provider_id"]    ) ? $item["provider_id"]   : '' ;
		$provider_name  = isset( $item["provider_name"]  ) ? $item["provider_name"] : '' ;
		
		if( get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) {
			$social_login_enable_stat = true;
			break;
		}
	}
	
	
	if( ! $social_login_enable_stat ) {
		return;
	}

	// if not in mode login, we overwrite the auth base url
	// > admin auth playground
	if( $auth_mode == 'test' ) {
		$authenticate_base_url = home_url() . "/?action=pgssl_authenticate&mode=test&";
	}

	// > account linking
	elseif( $auth_mode == 'link' ) {
		$authenticate_base_url = home_url() . "/?action=pgssl_authenticate&mode=link&";
	}

	// Connect with caption
	$connect_with_label = pgssl_connect_with_label();

	$connect_with_label = isset( $args['caption'] ) ? $args['caption'] : $connect_with_label;

	// HOOKABLE:
	$connect_with_label = apply_filters( 'pgssl_render_auth_widget_alter_connect_with_label', $connect_with_label );
	?>
	<div class="pgssl-wplogin-wrapper">

		<div class="pgssl-wplogin-divider"><span><?php echo esc_html__( 'Or', 'pgs-social-login' ); ?></span></div>

		<div class="pgssl-wplogin-label-wrapper"><span class="pgssl-wplogin-label"><?php echo esc_html__( 'Connect with:', 'pgs-social-login' ); ?></span></div>

		<div class="pgssl-wplogin-icons-wrapper">
			<div class="pgssl-wplogin-icons">
				<?php
				// Widget::Authentication display
				$pgssl_authentication_display = pgssl_authentication_display();

				// if a user is visiting using a mobile device, PGSSL will fall back to more in page
				$pgssl_authentication_display = function_exists( 'wp_is_mobile' ) ? wp_is_mobile() ? 2 : $pgssl_authentication_display : $pgssl_authentication_display;

				$no_idp_used = true;

				// display provider icons
				foreach( $providers_config AS $item ) {
					$provider_id    = isset( $item["provider_id"]    ) ? $item["provider_id"]   : '' ;
					$provider_name  = isset( $item["provider_name"]  ) ? $item["provider_name"] : '' ;

					// provider enabled?
					if( get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) {
						
						// restrict the enabled providers list
						if( isset( $args['enable_providers'] ) && !empty( $args['enable_providers'] ) ) {
							$enable_providers = explode( ',', strtolower( $args['enable_providers'] ) ); // might add a couple of pico seconds

							if( ! in_array( strtolower( $provider_id ), $enable_providers ) ) {
								continue;
							}
						}

						// build authentication url
						$authenticate_url = add_query_arg( array(
							'provider'    => $provider_id,
							'redirect_to' => urlencode( $redirect_to ),
						), $authenticate_base_url );

						// in case, Widget::Authentication display is set to 'popup', then we overwrite 'authenticate_url'
						// > /assets/js/connect.js will take care of the rest
						if( $pgssl_authentication_display == 1 &&  $auth_mode != 'test' ) {
							$authenticate_url= "javascript:void(0);";
						}

						$authenticate_url = apply_filters( 'pgssl_render_auth_widget_alter_authenticate_url', $authenticate_url, $provider_id, $auth_mode, $redirect_to, $pgssl_authentication_display );

						$provider_icon = pgssl_get_icon( $provider_id );
						
						if( $provider_icon ) {
							?>
							<div class="pgssl-wplogin-icon pgssl-wplogin-icon-<?php echo strtolower( $provider_id ); ?>">
								<a class="pgssl-wplogin-link pgssl-wplogin-link-<?php echo strtolower( $provider_id ); ?>" href="<?php echo esc_url($authenticate_url); ?>" title="<?php echo sprintf( __("Connect with %s", 'pgssl-text-domain'), $provider_name ) ?>" data-provider="<?php echo $provider_id ?>" role="button" rel="nofollow">
									<span class="pgssl-wplogin-link-icon"><?php echo $provider_icon; ?></span>
									<span class="pgssl-wplogin-link-label">
										<?php
										/* translators: %s: Social Auth Provider Name */
										echo sprintf( esc_html__("Login with  %s", 'pgs-social-login'), $provider_name );
										?>
									</span>
								</a>
							</div>
							<?php
						}
						$no_idp_used = false;
					}
				}
				?>
			</div>
		</div>
	</div>
	<?php
	// no provider enabled?
	if( $no_idp_used ) {
		?>
		<p style="background-color: #FFFFE0;border:1px solid #E6DB55;padding:5px;">
			<?php _pgssl_e( '<strong>PGS Social Login is not configured yet.</strong>', 'pgssl-text-domain') ?>
		</p>
		<style>#wp-social-login-connect-with{display:none;}</style>
		<?php
	}
	
	// provide popup url for hybridauth callback
	if( $pgssl_authentication_display == 1 ) {
		?>
		<input type="hidden" id="pgssl_popup_base_url" value="<?php echo esc_url( $authenticate_base_url ) ?>" />
		<input type="hidden" id="pgssl_login_form_uri" value="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" />
		<?php
	}

	// HOOKABLE: This action runs just after generating the Widget.
	do_action( 'pgssl_render_auth_widget_end' );
	
	// Display debugging area bellow the widget.
	// pgssl_display_dev_mode_debugging_area(); // ! keep this line commented unless you know what you are doing :)
}

function pgssl_login_wrapper_start(){
	echo '<div class="pgssl-login-inner">';
}
add_action( 'login_header', 'pgssl_login_wrapper_start' );

function pgssl_login_wrapper_end(){
	echo '</div><!-- .pgssl-login-inner -->';
}
add_action( 'login_footer', 'pgssl_login_wrapper_end', 999999 );