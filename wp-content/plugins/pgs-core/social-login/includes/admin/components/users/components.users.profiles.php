<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_users_profiles( $user_id ) {
	// HOOKABLE:
	do_action( "pgssl_component_users_profiles_start" );

	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';

	$linked_accounts = pgssl_get_stored_hybridauth_user_profiles_by_user_id( $user_id );

	// is it a PGS Social Login user?
	if( ! $linked_accounts ) {
?>
<div style="padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
	<?php _pgssl_e( "This's not a PGS Social Login user!", 'pgssl-text-domain' ); ?>.
</div>
<?php
		return;
	}

	# http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
	$ha_profile_fields = array(
		array( 'field' => 'identifier'  , 'label' => _pgssl__( "Provider user ID" , 'pgssl-text-domain'), 'description' => _pgssl__( "The Unique user's ID on the connected provider. Depending on the provider, this field can be an number, Email, URL, etc", 'pgssl-text-domain') ),
		array( 'field' => 'profileURL'  , 'label' => _pgssl__( "Profile URL"      , 'pgssl-text-domain'), 'description' => _pgssl__( "Link to the user profile on the provider web site"                                                                      , 'pgssl-text-domain') ),
		array( 'field' => 'webSiteURL'  , 'label' => _pgssl__( "Website URL"      , 'pgssl-text-domain'), 'description' => _pgssl__( "User website, blog or web page"                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'photoURL'    , 'label' => _pgssl__( "Photo URL"        , 'pgssl-text-domain'), 'description' => _pgssl__( "Link to user picture or avatar on the provider web site"                                                                , 'pgssl-text-domain') ),
		array( 'field' => 'displayName' , 'label' => _pgssl__( "Display name"     , 'pgssl-text-domain'), 'description' => _pgssl__( "User Display name. If not provided by social network, PGS Social Login will return a concatenation of the user first and last name"  , 'pgssl-text-domain') ),
		array( 'field' => 'description' , 'label' => _pgssl__( "Description"      , 'pgssl-text-domain'), 'description' => _pgssl__( "A short about me"                                                                                                       , 'pgssl-text-domain') ),
		array( 'field' => 'firstName'   , 'label' => _pgssl__( "First name"       , 'pgssl-text-domain'), 'description' => _pgssl__( "User's first name"                                                                                                      , 'pgssl-text-domain') ),
		array( 'field' => 'lastName'    , 'label' => _pgssl__( "Last name"        , 'pgssl-text-domain'), 'description' => _pgssl__( "User's last name"                                                                                                       , 'pgssl-text-domain') ),
		array( 'field' => 'gender'      , 'label' => _pgssl__( "Gender"           , 'pgssl-text-domain'), 'description' => _pgssl__( "User's gender. Values are 'female', 'male' or blank"                                                                    , 'pgssl-text-domain') ),
		array( 'field' => 'language'    , 'label' => _pgssl__( "Language"         , 'pgssl-text-domain'), 'description' => _pgssl__( "User's language"                                                                                                        , 'pgssl-text-domain') ),
		array( 'field' => 'age'         , 'label' => _pgssl__( "Age"              , 'pgssl-text-domain'), 'description' => _pgssl__( "User' age. Note that PGS Social Login do not calculate this field. We return it as it was provided"                                  , 'pgssl-text-domain') ),
		array( 'field' => 'birthDay'    , 'label' => _pgssl__( "Birth day"        , 'pgssl-text-domain'), 'description' => _pgssl__( "The day in the month in which the person was born. Not to confuse it with 'Birth date'"                                 , 'pgssl-text-domain') ),
		array( 'field' => 'birthMonth'  , 'label' => _pgssl__( "Birth month"      , 'pgssl-text-domain'), 'description' => _pgssl__( "The month in which the person was born"                                                                                 , 'pgssl-text-domain') ),
		array( 'field' => 'birthYear'   , 'label' => _pgssl__( "Birth year"       , 'pgssl-text-domain'), 'description' => _pgssl__( "The year in which the person was born"                                                                                  , 'pgssl-text-domain') ),
		array( 'field' => 'email'       , 'label' => _pgssl__( "Email"            , 'pgssl-text-domain'), 'description' => _pgssl__( "User's email address. Note: some providers like Facebook and Google can provide verified emails. Users with the same verified email will be automatically linked", 'pgssl-text-domain') ),
		array( 'field' => 'phone'       , 'label' => _pgssl__( "Phone"            , 'pgssl-text-domain'), 'description' => _pgssl__( "User's phone number"                                                                                                    , 'pgssl-text-domain') ),
		array( 'field' => 'address'     , 'label' => _pgssl__( "Address"          , 'pgssl-text-domain'), 'description' => _pgssl__( "User's address"                                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'country'     , 'label' => _pgssl__( "Country"          , 'pgssl-text-domain'), 'description' => _pgssl__( "User's country"                                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'region'      , 'label' => _pgssl__( "Region"           , 'pgssl-text-domain'), 'description' => _pgssl__( "User's state or region"                                                                                                 , 'pgssl-text-domain') ),
		array( 'field' => 'city'        , 'label' => _pgssl__( "City"             , 'pgssl-text-domain'), 'description' => _pgssl__( "User's city"                                                                                                            , 'pgssl-text-domain') ),
		array( 'field' => 'zip'         , 'label' => _pgssl__( "Zip"              , 'pgssl-text-domain'), 'description' => _pgssl__( "User's zipcode"                                                                                                         , 'pgssl-text-domain') ),
	);

	$user_data = get_userdata( $user_id );

	add_thickbox();

	$actions = array(
		'edit_details'  => '<a class="button button-secondary thickbox" href="' . admin_url( 'user-edit.php?user_id=' . $user_id . '&TB_iframe=true&width=1150&height=550' ) . '">' . _pgssl__( 'Edit user details', 'pgssl-text-domain' ) . '</a>',
		'show_contacts'  => '<a class="button button-secondary" href="' . admin_url( 'admin.php?page=pgssl_settings&pgssl_page=contacts&uid=' . $user_id ) . '">' . _pgssl__( 'Show user contacts list', 'pgssl-text-domain' ) . '</a>',
	);

	// HOOKABLE:
	$actions = apply_filters( 'pgssl_component_users_profiles_alter_actions_list', $actions, $user_id );
?>
<style>
	table td, table th { border: 1px solid #DDDDDD; }
	table th label { font-weight: bold; }
	.form-table th { width:120px; text-align:right; }
	p.description { font-size: 11px ! important; margin:0 ! important;}
</style>

<script>
	function confirmDeletePGSSLUser() {
		return confirm( <?php echo json_encode( _pgssl__("Are you sure you want to delete the user's social profiles and contacts?\n\nNote: The associated WordPress user won't be deleted.", 'pgssl-text-domain') ) ?> );
	}
</script>

<div style="margin-top: 15px;padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
 	<h3 style="margin:0;"><?php echo sprintf( _pgssl__("%s's social profiles", 'pgssl-text-domain'), $user_data->display_name ) ?></h3>

	<p style="float: <?php if( is_rtl() ) echo 'left'; else echo 'right'; ?>;margin-top:-23px">
		<?php
			echo implode( ' ', $actions );
		?>
	</p>
</div>

<div style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
	<table class="wp-list-table widefat">
		<tr><th width="200"><label><?php _pgssl_e("Wordpress User ID", 'pgssl-text-domain'); ?></label></th><td><?php echo $user_data->ID; ?></td></tr>
		<tr><th width="200"><label><?php _pgssl_e("Username", 'pgssl-text-domain'); ?></label></th><td><?php echo $user_data->user_login; ?></td></tr>
		<tr><th><label><?php _pgssl_e("Display name", 'pgssl-text-domain'); ?></label></th><td><?php echo $user_data->display_name; ?></td></tr>
		<tr><th><label><?php _pgssl_e("E-mail", 'pgssl-text-domain'); ?></label></th><td><a href="mailto:<?php echo $user_data->user_email; ?>" target="_blank"><?php echo $user_data->user_email; ?></a></td></tr>
		<tr><th><label><?php _pgssl_e("Website", 'pgssl-text-domain'); ?></label></th><td><a href="<?php echo $user_data->user_url; ?>" target="_blank"><?php echo $user_data->user_url; ?></a></td></tr>
		<tr><th><label><?php _pgssl_e("Registered", 'pgssl-text-domain'); ?></label></th><td><?php echo $user_data->user_registered; ?></td></tr>
		</tr>
	 </table>
</div>

<?php
	foreach( $linked_accounts AS $link ) {
?>
<div style="margin-top:15px;padding: 5px 20px 20px; border: 1px solid #ddd; background-color: #fff;">

<h4><img src="<?php echo $assets_base_url . strtolower( $link->provider ) . '.png' ?>" style="vertical-align:top;width:16px;height:16px;" /> <?php _pgssl_e("User profile", 'pgssl-text-domain'); ?> <small><?php echo sprintf( _pgssl__( "as provided by %s", 'pgssl-text-domain'), $link->provider ); ?> </small></h4>

<table class="wp-list-table widefat">
	<?php
		$profile_fields = (array) $link;

		foreach( $ha_profile_fields as $item ) {
			$item['field'] = strtolower( $item['field'] );
		?>
			<tr>
				<th width="200">
					<label><?php echo $item['label']; ?></label>
				</th>
				<td>
					<?php
						if( isset( $profile_fields[ $item['field'] ] ) && $profile_fields[ $item['field'] ] ) {
							$field_value = $profile_fields[ $item['field'] ];

							if( in_array( $item['field'], array( 'profileurl', 'websiteurl', 'email' ) ) ) {
								?>
									<a href="<?php if( $item['field'] == 'email' ) echo 'mailto:'; echo $field_value; ?>" target="_blank"><?php echo $field_value; ?></a>
								<?php
							} elseif( $item['field'] == 'photourl' ) {
								?>
									<a href="<?php echo $field_value; ?>" target="_blank"><img width="36" height="36" align="left" src="<?php echo $field_value; ?>" style="margin-right: 5px;" > <?php echo $field_value; ?></a>
								<?php
							} else {
								echo $field_value;
							}

							?>
								<p class="description">
									<?php echo $item['description']; ?>.
								</p>
							<?php
						}
					?>
				</td>
			</tr>
		<?php
		}
	?>
</table>
</div>
<?php
	}

	// HOOKABLE:
	do_action( "pgssl_component_users_profiles_end" );
}
