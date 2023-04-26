<?php
/**
* Authentication Playground
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_authtest() {
	do_action( "pgssl_component_authtest_start" );

	$adapter      = null;
	$provider_id  = isset( $_REQUEST["provider"] ) ? $_REQUEST["provider"] : null;
	$user_profile = null;

	if ( ! empty( $provider_id ) ) {
		$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/';

		try {
			$adapter = pgssl_process_login_get_provider_adapter( $provider_id );

			// make as few call as possible
			if( ! ( isset( $_SESSION['pgssl::userprofile'] ) && $_SESSION['pgssl::userprofile'] && $user_profile = json_decode( $_SESSION['pgssl::userprofile'] ) ) ) {
				$user_profile = $adapter->getUserProfile();
				$_SESSION['pgssl::userprofile'] = json_encode( $user_profile );
			}

		} catch( Exception $e ) {
		}
	}

	$ha_profile_fields = array(
		array( 'field' => 'identifier'  , 'label' => _pgssl__( "Provider user ID" , 'pgssl-text-domain') ),
		array( 'field' => 'profileURL'  , 'label' => _pgssl__( "Profile URL"      , 'pgssl-text-domain') ),
		array( 'field' => 'webSiteURL'  , 'label' => _pgssl__( "Website URL"      , 'pgssl-text-domain') ),
		array( 'field' => 'photoURL'    , 'label' => _pgssl__( "Photo URL"        , 'pgssl-text-domain') ),
		array( 'field' => 'displayName' , 'label' => _pgssl__( "Display name"     , 'pgssl-text-domain') ),
		array( 'field' => 'description' , 'label' => _pgssl__( "Description"      , 'pgssl-text-domain') ),
		array( 'field' => 'firstName'   , 'label' => _pgssl__( "First name"       , 'pgssl-text-domain') ),
		array( 'field' => 'lastName'    , 'label' => _pgssl__( "Last name"        , 'pgssl-text-domain') ),
		array( 'field' => 'gender'      , 'label' => _pgssl__( "Gender"           , 'pgssl-text-domain') ),
		array( 'field' => 'language'    , 'label' => _pgssl__( "Language"         , 'pgssl-text-domain') ),
		array( 'field' => 'age'         , 'label' => _pgssl__( "Age"              , 'pgssl-text-domain') ),
		array( 'field' => 'birthDay'    , 'label' => _pgssl__( "Birth day"        , 'pgssl-text-domain') ),
		array( 'field' => 'birthMonth'  , 'label' => _pgssl__( "Birth month"      , 'pgssl-text-domain') ),
		array( 'field' => 'birthYear'   , 'label' => _pgssl__( "Birth year"       , 'pgssl-text-domain') ),
		array( 'field' => 'email'       , 'label' => _pgssl__( "Email"            , 'pgssl-text-domain') ),
		array( 'field' => 'phone'       , 'label' => _pgssl__( "Phone"            , 'pgssl-text-domain') ),
		array( 'field' => 'address'     , 'label' => _pgssl__( "Address"          , 'pgssl-text-domain') ),
		array( 'field' => 'country'     , 'label' => _pgssl__( "Country"          , 'pgssl-text-domain') ),
		array( 'field' => 'region'      , 'label' => _pgssl__( "Region"           , 'pgssl-text-domain') ),
		array( 'field' => 'city'        , 'label' => _pgssl__( "City"             , 'pgssl-text-domain') ),
		array( 'field' => 'zip'         , 'label' => _pgssl__( "Zip"              , 'pgssl-text-domain') ),
	);
?>
<style>
	.widefat td, .widefat th { border: 1px solid #DDDDDD; }
	.widefat th label { font-weight: bold; }

	.wp-social-login-provider-list { padding: 10px; }
	.wp-social-login-provider-list a {text-decoration: none; }
	.wp-social-login-provider-list img{ border: 0 none; }
</style>

<div class="metabox-holder columns-2" id="post-body">
	<table width="100%">
		<tr valign="top">
			<td>
				<?php if( ! $adapter ): ?>
					<div style="padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
						<p><?php _pgssl_e("Connect with a provider to get started", 'pgssl-text-domain') ?>.</p>
					</div>
				<?php else: ?>
					<div class="stuffbox">
						<h3>
							<label><?php _pgssl_e("Connected adapter specs", 'pgssl-text-domain') ?></label>
						</h3>
						<div class="inside">
							<table class="wp-list-table widefat">
								<tr>
									<th width="200"><label><?php _pgssl_e("Provider", 'pgssl-text-domain') ?></label></th>
									<td><?php echo $provider_id; ?></td>
								</tr>

								<?php if( isset( $adapter->openidIdentifier ) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("OpenID Identifier", 'pgssl-text-domain') ?></label></th>
										<td><?php echo $adapter->openidIdentifier; ?></td>
									</tr>
								<?php endif; ?>

								<?php if( isset( $adapter->scope ) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Scope", 'pgssl-text-domain') ?></label></th>
										<td><?php echo $adapter->scope; ?></td>
									</tr>
								<?php endif; ?>

								<?php if( isset( $adapter->config['keys'] ) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Application keys", 'pgssl-text-domain') ?></label></th>
										<td><div style="max-width:650px"><?php echo json_encode( $adapter->config['keys'] ); ?></div></td>
									</tr>
								<?php endif; ?>

								<?php 
									$accessToken = $adapter->getAccessToken();
								?>
								
								<?php if( isset($accessToken["access_token"]) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Access token", 'pgssl-text-domain') ?></label></th>
										<td><div style="max-width:650px"><?php echo $adapter->getAccessToken()["access_token"]; ?></div></td>
									</tr>
								<?php endif; ?>

								<?php if( isset($accessToken["access_token_secret"]) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Access token secret", 'pgssl-text-domain') ?></label></th>
										<td><?php echo $adapter->getAccessToken()["access_token_secret"]; ?></td>
									</tr>
								<?php endif; ?>

								<?php if( isset($accessToken["expires_in"]) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Access token expires in", 'pgssl-text-domain') ?></label></th>
										<td><?php echo (int) $adapter->getAccessToken()["expires_at"] - time(); ?> <?php _pgssl_e("second(s)", 'pgssl-text-domain') ?></td>
									</tr>
								<?php endif; ?>

								<?php if( isset($accessToken["expires_at"]) ): ?>
									<tr>
										<th width="200"><label><?php _pgssl_e("Access token expires at", 'pgssl-text-domain') ?></label></th>
										<td><?php echo date( DATE_W3C, $adapter->getAccessToken()["expires_at"] ); ?></td>
									</tr>
								<?php endif; ?>
							</table>
						</div>
					</div>

					<?php
					$console = false;

					if( ! isset( $adapter->openidIdentifier ) ):
						?>
						<div class="stuffbox">
							<h3>
								<label><?php _pgssl_e("Connected adapter console", 'pgssl-text-domain') ?></label>
							</h3>
							<div class="inside">
								<?php
									$path   = isset( $adapter->api->api_base_url ) ? $adapter->api->api_base_url : '';
									$path   = isset( $_REQUEST['console-path']   ) ? $_REQUEST['console-path']   : $path;
									$method = isset( $_REQUEST['console-method'] ) ? $_REQUEST['console-method'] : '';
									$query  = isset( $_REQUEST['console-query']  ) ? $_REQUEST['console-query']  : '';

									$response = '';

									if( $path && in_array( $method, array( 'GET', 'POST' ) ) ) {
										$console = true;

										try
										{
											if( $method == 'GET' ) {
												$response = $adapter->apiRequest( $path . ( $query ? '?' . $query : '' ) );
											} else {
												$response = $adapter->apiRequest( $path, $query );
											}

											$response = $response ? $response : Hybrid_Error::getApiError();
										}
										catch( Exception $e ) {
											$response = "ERROR: " . $e->getMessage();
										}
									}
								?>
								<form action="" method="post"/>
									<table class="wp-list-table widefat">
										<tr>
											<th width="200"><label><?php _pgssl_e("Path", 'pgssl-text-domain') ?></label></th>
											<td><input type="text" style="width:96%" name="console-path" value="<?php echo htmlentities( $path ); ?>"><a href="https://apigee.com/providers" target="_blank"><img src="<?php echo $assets_base_url . 'question.png' ?>" style="vertical-align: text-top;" /></a></td>
										</tr>
										<tr>
											<th width="200"><label><?php _pgssl_e("Method", 'pgssl-text-domain') ?></label></th>
											<td><select style="width:100px" name="console-method"><option value="GET" <?php if( $method == 'GET' ) echo 'selected'; ?>>GET</option><!-- <option value="POST" <?php if( $method == 'POST' ) echo 'selected'; ?>>POST</option>--></select></td>
										</tr>
										<tr>
											<th width="200"><label><?php _pgssl_e("Query", 'pgssl-text-domain') ?></label></th>
											<td><textarea style="width:100%;height:60px;margin-top:6px;" name="console-query"><?php echo htmlentities( $query ); ?></textarea></td>
										</tr>
									</table>

									<br />

									<input type="submit" value="<?php _pgssl_e("Submit", 'pgssl-text-domain') ?>" class="button">
								</form>
							</div>
						</div>

						<?php if( $console ): ?>
							<div class="stuffbox">
								<h3>
									<label><?php _pgssl_e("API Response", 'pgssl-text-domain') ?></label>
								</h3>
								<div class="inside">
									<textarea rows="25" cols="70" wrap="off" style="width:100%;height:400px;margin-bottom:15px;font-family: monospace;font-size: 12px;"><?php echo htmlentities( print_r( $response, true ) ); ?></textarea>
								</div>
							</div>
						<?php if( 0 ): ?>
							<div class="stuffbox">
								<h3>
									<label><?php _pgssl_e("Code PHP", 'pgssl-text-domain') ?></label>
								</h3>
								<div class="inside">
<textarea rows="25" cols="70" wrap="off" style="width:100%;height:210px;margin-bottom:15px;font-family: monospace;font-size: 12px;">
/*!
Important

Direct access to providers apis is newly introduced and we are still experimenting, so they may change in future releases.
*/

try
{
	$<?php echo strtolower( $adapter->providerId ); ?> = $adapter = pgssl_process_login_get_provider_adapter( '<?php echo htmlentities( $provider_id ); ?>' );

<?php if( $method == 'GET' ): ?>
    $response = $<?php echo strtolower( $adapter->providerId ); ?>->api()->get( '<?php echo htmlentities( $path . ( $query ? '?' . $query : '' ) ); ?>' );
<?php else: ?>
    $response = $<?php echo strtolower( $adapter->providerId ); ?>->api()->post( '<?php echo htmlentities( $path ); ?>', (array) $query );
<?php endif; ?>
}
catch( Exception $e ) {
    echo "Ooophs, we got an error: " . $e->getMessage();
}</textarea>
								</div>
							</div>
							<div class="stuffbox">
								<h3>
									<label><?php _pgssl_e("Connected adapter debug", 'pgssl-text-domain') ?></label>
								</h3>
								<div class="inside">
									<textarea rows="25" cols="70" wrap="off" style="width:100%;height:400px;margin-bottom:15px;font-family: monospace;font-size: 12px;"><?php echo htmlentities( print_r( $adapter, true ) ); ?></textarea>
								</div>
							</div>
							<div class="stuffbox">
								<h3>
									<label><?php _pgssl_e("PHP Session", 'pgssl-text-domain') ?></label>
								</h3>
								<div class="inside">
									<textarea rows="25" cols="70" wrap="off" style="width:100%;height:350px;margin-bottom:15px;font-family: monospace;font-size: 12px;"><?php echo htmlentities( print_r( $_SESSION, true ) ); ?></textarea>
								</div>
							</div>
						<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php if( ! $console ): ?>
						<div class="stuffbox">
							<h3>
								<label><?php _pgssl_e("Connected user social profile", 'pgssl-text-domain') ?></label>
							</h3>
							<div class="inside">
								<table class="wp-list-table widefat">
									<?php
										$user_profile = (array) $user_profile;

										foreach( $ha_profile_fields as $item ) {
											$item['field'] = $item['field'];
										?>
											<tr>
												<th width="200">
													<label><?php echo $item['label']; ?></label>
												</th>
												<td>
													<?php
														if( isset( $user_profile[ $item['field'] ] ) && $user_profile[ $item['field'] ] ) {
															$field_value = $user_profile[ $item['field'] ];

															if( in_array( strtolower( $item['field'] ), array( 'profileurl', 'websiteurl', 'email' ) ) ) {
																?>
																	<a href="<?php if( $item['field'] == 'email' ) echo 'mailto:'; echo $field_value; ?>" target="_blank"><?php echo $field_value; ?></a>
																<?php
															} elseif( strtolower( $item['field'] ) == 'photourl' ) {
																?>
																	<a href="<?php echo $field_value; ?>" target="_blank"><img width="36" height="36" align="left" src="<?php echo $field_value; ?>" style="margin-right: 5px;" > <?php echo $field_value; ?></a>
																<?php
															} else {
																echo $field_value;
															}
														}
													?>
												</td>
											</tr>
										<?php
										}
									?>
								</table>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</td>
			<td width="10"></td>
			<td width="400">
				<div class="postbox">
					<div class="inside">
						<h3><?php _pgssl_e("Authentication Playground", 'pgssl-text-domain') ?></h3>

						<div style="padding:0 20px;">
							<p>
								<?php _pgssl_e('Authentication Playground will let you authenticate with the enabled social networks without creating any new user account', 'pgssl-text-domain') ?>.
							</p>
							<p>
								<?php _pgssl_e('This tool will also give you a direct access to social networks apis via a lightweight console', 'pgssl-text-domain') ?>.
							</p>
						</div>
					</div>
				</div>

				</style>
				<div class="postbox">
					<div class="inside">
						<div style="padding:0 20px;">
							<p>
								<?php _pgssl_e("Connect with", 'pgssl-text-domain') ?>:
							</p>

							<div style="width: 380px; padding: 10px; border: 1px solid #ddd; background-color: #fff;">
								<?php do_action( 'pgs_social_login', array( 'mode' => 'test', 'caption' => '' ) ); ?>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php
	// HOOKABLE:
	do_action( "pgssl_component_authtest_end" );
}

pgssl_component_authtest();