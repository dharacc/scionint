<?php
/**
* Social networks configuration and setup
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* This should be reworked somehow.. the code has become spaghettis
*/
function pgssl_component_networks_setup() {
	// HOOKABLE:
	do_action( "pgssl_component_networks_setup_start" );

	$providers_config = pgssl_get_providers();

	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';
	$assets_setup_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/setup/';
	?>
	<script>
	function toggleproviderkeys(idp) {
		if(typeof jQuery=="undefined") {
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return;
		}

		console.log( '.pgssl_tr_settings_' + idp + ' th, .pgssl_tr_settings_' + idp + ' td' );
		if(jQuery('#pgssl_settings_' + idp + '_enabled').val()==1) {
			jQuery( '.pgssl_tr_settings_' + idp + ' th, .pgssl_tr_settings_' + idp + ' td' ).slideDown('fast');
		} else {
			jQuery( '.pgssl_tr_settings_' + idp + ' th, .pgssl_tr_settings_' + idp + ' td' ).slideUp('fast');
			jQuery('.pgssl_div_settings_help_' + idp).hide();
		}

		return false;
	}

	function toggleproviderhelp(idp) {
		if(typeof jQuery=="undefined") {
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return false;
		}

		jQuery('.pgssl_div_settings_help_' + idp).toggle();

		return false;
	}
	</script>
	<?php
	$providers_active = 0;
	foreach( $providers_config AS $item ) {
		$provider_id                = isset( $item["provider_id"]       ) ? $item["provider_id"]       : '';
		$provider_name              = isset( $item["provider_name"]     ) ? $item["provider_name"]     : '';

		$require_client_id          = isset( $item["require_client_id"] ) ? $item["require_client_id"] : '';
		$require_api_key            = isset( $item["require_api_key"]   ) ? $item["require_api_key"]   : '';
		$provide_email              = isset( $item["provide_email"]     ) ? $item["provide_email"]     : '';

		$provider_new_app_link      = isset( $item["new_app_link"]      ) ? $item["new_app_link"]      : '';
		$provider_userguide_section = isset( $item["userguide_section"] ) ? $item["userguide_section"] : '';

		$provider_callback_url      = "" ;

		/*
		if (
			! (
				( isset( $item["default_network"] ) && $item["default_network"] && ! get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) )
				|| get_option( 'pgssl_settings_' . $provider_id . '_enabled' )
			)
        ) {
			continue;
		}
		*/

		// default endpoint_url
		$endpoint_url = PGS_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL;

		if( isset( $item["callback"] ) && $item["callback"] ) {
			$provider_callback_url  = '<span style="color:green">' . $endpoint_url . 'callbacks/' . strtolower($provider_id) . '.php</span>';
		}

		$setupsteps = 0;
		$provider_icon = pgssl_get_icon( $provider_id );
		?>
		<div class="postbox pgssl-postbox pgssl-postbox-<?php echo strtolower( $provider_id );?>" id="setup<?php echo strtolower( $provider_id );?>">
            <div class="postbox-header">
                <h2 class="hndle ui-sortable-handlex">
                    <?php
                    /*
                    if( $provider_icon ){
                        ?>
                        <span class="pgssl-nework-setup-icon"><?php echo $provider_icon; ?></span>
                        <?php
                    }
                    */
                    ?>
                    <?php echo esc_html( $provider_name );?>
                </h2>
            </div>
			<div class="inside pgssl-fields">
				<table class="form-table editcomment">
					<tbody>
						<?php /* ?>
						<tr>
							<th><?php _pgssl_e("Enabled", 'pgssl-text-domain') ?>:</td>
							<td>
								<select
									name="<?php echo 'pgssl_settings_' . $provider_id . '_enabled' ?>"
									id="<?php echo 'pgssl_settings_' . $provider_id . '_enabled' ?>"
									onChange="toggleproviderkeys('<?php echo $provider_id; ?>')"
								>
									<option value="1" <?php if(   get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) echo "selected"; ?> ><?php _pgssl_e("Yes", 'pgssl-text-domain') ?></option>
									<option value="0" <?php if( ! get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) echo "selected"; ?> ><?php _pgssl_e("No", 'pgssl-text-domain') ?></option>
								</select>
							</td>
							<?php / *?><td style="width:160px">&nbsp;</td><?php * /?>
						</tr>
						<?php */ ?>

						<tr>
							<th><?php _pgssl_e("Enabled", 'pgssl-text-domain') ?>:</td>
							<td>
								<?php $provider_enabled = get_option( 'pgssl_settings_' . $provider_id . '_enabled', 0 ); ?>
								<div class="pgssl-field pgssl-field-type-radio">
									<div class="pgssl-field-radio-buttonset-wrapper">
										<label class="pgssl-field-radio-button-wrapper">
											<input type="radio" class="pgssl_provider_settings_showhide" name="<?php echo 'pgssl_settings_' . $provider_id . '_enabled' ?>" value="1" <?php checked( $provider_enabled, 1 ); ?>/>
											<span class="pgssl-field-radio-button"><?php esc_html_e( 'Yes', 'pgssl-text-domain' ) ?></span>
										</label>
										<label class="pgssl-field-radio-button-wrapper">
											<input type="radio" class="pgssl_provider_settings_showhide" name="<?php echo 'pgssl_settings_' . $provider_id . '_enabled' ?>" value="0" <?php checked( $provider_enabled, 0 ); ?>/>
											<span class="pgssl-field-radio-button"><?php esc_html_e( 'No', 'pgssl-text-domain' ) ?></span>
										</label>
									</div>
								</div>
							</td>
							<?php /*?><td style="width:160px">&nbsp;</td><?php */?>
						</tr>

						<?php
						if ( $provider_new_app_link ) {
							$table_td_css = array();
							if ( ! get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) {
								$table_td_css[] = 'display:none;';
							} else {
								$table_td_css[] = 'display: table-cell;';
							}
							$table_td_css = implode( ' ', $table_td_css );

							if ( $require_client_id ){ // key or id ?
								?>
								<tr class="pgssl_tr_setting pgssl_tr_settings_<?php echo esc_attr( $provider_id ); ?>" valign="top">
									<th style="<?php echo esc_attr( $table_td_css ); ?>"><?php _pgssl_e("Application ID", 'pgssl-text-domain') ?>:</td>
									<td style="<?php echo esc_attr( $table_td_css ); ?>"><input dir="ltr" class="pgssl-field pgssl-field-type-text" type="text" name="<?php echo 'pgssl_settings_' . $provider_id . '_app_id' ?>" value="<?php echo get_option( 'pgssl_settings_' . $provider_id . '_app_id' ); ?>" ></td>
									<?php /*?><td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')"><?php _pgssl_e("Where do I get this info?", 'pgssl-text-domain') ?></a></td><?php */?>
								</tr>
								<?php
							} else {
								?>
								<tr class="pgssl_tr_setting pgssl_tr_settings_<?php echo esc_attr( $provider_id ); ?>" valign="top">
									<th style="<?php echo esc_attr( $table_td_css ); ?>"><?php _pgssl_e("Application Key", 'pgssl-text-domain') ?>:</td>
									<td style="<?php echo esc_attr( $table_td_css ); ?>"><input dir="ltr" class="pgssl-field pgssl-field-type-text" type="text" name="<?php echo 'pgssl_settings_' . $provider_id . '_app_key' ?>" value="<?php echo get_option( 'pgssl_settings_' . $provider_id . '_app_key' ); ?>" ></td>
									<?php /*?><td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')"><?php _pgssl_e("Where do I get this info?", 'pgssl-text-domain') ?></a></td><?php */?>
								</tr>
								<?php
							}

							if( ! $require_api_key ) {
								?>
								<tr class="pgssl_tr_setting pgssl_tr_settings_<?php echo esc_attr( $provider_id ); ?>" valign="top">
									<th style="<?php echo esc_attr( $table_td_css ); ?>"><?php _pgssl_e("Application Secret", 'pgssl-text-domain') ?>:</td>
									<td style="<?php echo esc_attr( $table_td_css ); ?>"><input dir="ltr" class="pgssl-field pgssl-field-type-text" type="text" name="<?php echo 'pgssl_settings_' . $provider_id . '_app_secret' ?>" value="<?php echo get_option( 'pgssl_settings_' . $provider_id . '_app_secret' ); ?>" ></td>
									<?php /*?><td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')"><?php _pgssl_e("Where do I get this info?", 'pgssl-text-domain') ?></a></td><?php */?>
								</tr>
								<?php
							}
							?>
							<tr class="pgssl_tr_setting pgssl_tr_settings_<?php echo esc_attr( $provider_id ); ?>" valign="top">
								<th style="<?php echo esc_attr( $table_td_css ); ?>"><?php _pgssl_e("Callback/Redirection URL", 'pgssl-text-domain') ?>:</td>
								<td style="<?php echo esc_attr( $table_td_css ); ?>"><em><?php echo $endpoint_url . 'callbacks/' . strtolower($provider_id) . '.php'; ?></em></td>
								<?php /*?><td></td><?php */?>
							</tr>
							<?php
						} // if require registration
						?>
					</tbody>
				</table>
				<div class="pgssl_div_settings_help pgssl_div_settings_help_<?php echo $provider_id; ?>" style="display:none;">
					<hr/>
					<?php if (  $provider_id == "Steam" ) : ?>
					<?php elseif ( $provider_new_app_link  ) : ?>
						<?php _pgssl_e('<span style="color:#CB4B16;">Application <strong>ID</strong> and <strong>Secret</strong></span> (also sometimes referred as <span style="color:#CB4B16;">API</span> key and secret or <span style="color:#CB4B16;">Consumer</span> key and secret or <span style="color:#CB4B16;">Client</span> ID and secret) are what we call an application credentials', 'pgssl-text-domain') ?>.

						<?php echo sprintf( _pgssl__( 'The application will link your website to <b>%s\'s API</b> and it\'s needed in order for <b>%s\'s Users</b> to access your website', 'pgssl-text-domain'), $provider_name, $provider_name ) ?>.
						<br />
						<br />

						<?php echo sprintf( _pgssl__('To enable authentication with this provider and to register a new <b>%s API Application</b>, follow the steps', 'pgssl-text-domain'), $provider_name ) ?>
						:<br />
					<?php else: ?>
							<p><?php echo sprintf( _pgssl__('<b>Done.</b> Nothing more required for <b>%s</b>', 'pgssl-text-domain'), $provider_name) ?>.</p>
					<?php endif; ?>
					<div style="margin-left:40px;">
						<?php if ( $provider_new_app_link  ) : ?>
							<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php echo sprintf( _pgssl__( 'First go to: <a href="%s" target ="_blank">%s</a>', 'pgssl-text-domain'), $provider_new_app_link, $provider_new_app_link ) ?></p>

							<?php
							if ( $provider_id == "Google" ) :
								?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e('On the <b>Dashboard sidebar</b> click on <b>Project</b> then click <em style="color:#0147bb;">&ldquo;Create Project&rdquo;</em>', 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Once the project is created. Select that project, then <b>APIs & auth</b> &gt; <b>Consent screen</b> and fill the required information", 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e('Then <b>APIs & auth</b> &gt; <b>APIs</b> and enable <em style="color:#0147bb;">&ldquo;Google+ API&rdquo;</em>. If you want to import the user contatcs enable <em style="color:#0147bb;">&ldquo;Contacts API&rdquo;</em> as well', 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("After that you will need to create an new application: <b>APIs & auth</b> &gt; <b>Credentials</b> and then click <em style=\"color:#0147bb;\">&ldquo;Create new Client ID&rdquo;</em>", 'pgssl-text-domain') ?>.</p>
								</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("On the <b>&ldquo;Create Client ID&rdquo;</b> popup", 'pgssl-text-domain') ?> :</p>
								<ul style="margin-left:35px">
									<li><?php _pgssl_e('Select <em style="color:#0147bb;">&ldquo;Web application&rdquo;</em> as your application type', 'pgssl-text-domain') ?>.</li>
									<li><?php _pgssl_e("Put your website domain in the <b>Authorized JavaScript origins</b> field. This should match with the current hostname", 'pgssl-text-domain') ?> <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"]; ?></em>.</li>
									<li><?php _pgssl_e("Provide this URL as the <b>Authorized redirect URI</b> for your application", 'pgssl-text-domain') ?>: <br /><?php echo $provider_callback_url ?></li>
								</ul>
								<?php
							elseif ( $provider_id == "Facebook" ) :
								?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Select <b>Add a New App</b> from the <b>Apps</b> menu at the top", 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Fill out Display Name, Namespace, choose a category and click <b>Create App</b>", 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Go to Settings page and click on <b>Add Platform</b>. Choose website and enter in the new screen your website url in <b>App Domains</b> and <b>Site URL</b> fields", 'pgssl-text-domain') ?>.
									<?php _pgssl_e("They should match with the current hostname", 'pgssl-text-domain') ?> <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"]; ?></em>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Go to the <b>Status & Review</b> page and choose <b>yes</b> where it says <b>Do you want to make this app and all its live features available to the general public?</b>", 'pgssl-text-domain') ?>.</p>
								<?php
							else:
								?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Create a new application", 'pgssl-text-domain') ?>.</p>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Fill out any required fields such as the application name and description", 'pgssl-text-domain') ?>.</p>
								<?php
							endif;
							?>

							<?php
							if ( $provider_callback_url && $provider_id != "Google" && $provider_id != "Facebook"  ) :
								?>
								<p>
									<?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Provide this URL as the <b>Callback URL</b> for your application", 'pgssl-text-domain') ?>:
									<br />
									<?php echo $provider_callback_url ?>
								</p>
								<?php
							endif;
							?>

							<?php if ( $provider_id == "Live" ) : ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Put your website domain in the <b>Redirect Domain</b> field. This should match with the current hostname", 'pgssl-text-domain') ?> <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"]; ?></em>.</p>
							<?php endif; ?>

							<?php if ( $provider_id == "LinkedIn" ) : ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e('Choose <b>Live</b> on <b>Live Status</b>.', 'pgssl-text-domain') ?></p>
							<?php endif; ?>

							<?php if ( $provider_id == "Google" ) : ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Once you have registered past the created application credentials (Client ID and Secret) into the boxes above", 'pgssl-text-domain') ?>.</p>
							<?php elseif ( $provider_id == "Twitter" ) : ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Once you have registered, past the created application credentials (Consumer Key and Secret) into the boxes above", 'pgssl-text-domain') ?>.</p>
							<?php elseif ( $provider_id == "Facebook" ) : ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Go back to the <b>Dashboard</b> page and past the created application credentials (APP ID and Secret) into the boxes above", 'pgssl-text-domain') ?>.</p>
							<?php else: ?>
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> <?php _pgssl_e("Once you have registered, past the created application credentials into the boxes above", 'pgssl-text-domain') ?>.</p>
							<?php endif; ?>

						<?php endif; ?>
					</div>

					<?php if ( $provider_new_app_link  ) : ?>
						<hr />
						<p>
							<b><?php _pgssl_e("And that's it!", 'pgssl-text-domain') ?></b>
							<br />
							<?php echo sprintf( _pgssl__( 'If for some reason you still can\'t manage to create an application for %s, first try to <a href="https://www.google.com/search?q=%s API create application" target="_blank">Google it</a>, then check it on <a href="http://www.youtube.com/results?search_query=%s API create application " target="_blank">Youtube</a>, and if nothing works <a href="admin.php?page=pgssl_settings&pgssl_page=help">ask for support</a>', 'pgssl-text-domain'), $provider_name, $provider_name, $provider_name ) ?>.
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		$providers_active++;
	}
	if( $providers_active == 0 ){
		?>
		<div id="pgssl_div_warn">
			<h3><?php esc_html_e('Oops! No network(s) activated.', 'pgssl-text-domain') ?></h3>
			<hr />
			<p>
				<?php esc_html_e("Please activate a network by clicking a icon in the sidebar.", 'pgssl-text-domain') ?>
			</p>
		</div>
		<?php
	}

	if( $providers_active > 0 ){
		?>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e("Save Changes", 'pgssl-text-domain') ?>"></p>
		<?php
	}
	do_action( "pgssl_component_networks_setup_end" );
}
