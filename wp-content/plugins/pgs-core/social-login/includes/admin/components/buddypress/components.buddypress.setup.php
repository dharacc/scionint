<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_buddypress_setup() {
	$sections = array(
		'user_avatar'     => 'pgssl_component_buddypress_setup_user_avatar',
		'profile_mapping' => 'pgssl_component_buddypress_setup_profile_mapping',
	);

	$sections = apply_filters( 'pgssl_component_buddypress_setup_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_buddypress_setup_sections', $action );
	}
?>
<div>
	<?php
		// HOOKABLE:
		do_action( 'pgssl_component_buddypress_setup_sections' );
	?>

	<br />

	<div style="margin-left:5px;margin-top:-20px;">
		<input type="submit" class="button-primary" value="<?php _pgssl_e("Save Settings", 'pgssl-text-domain') ?>" />
	</div>
</div>
<?php
}

function pgssl_component_buddypress_setup_user_avatar() {
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Users avatars", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php
			if( pgssl_users_avatars() == 1 ){
				_pgssl_e("<b>Users avatars</b> is currently set to: <b>Display users avatars from social networks when available.</b>", 'pgssl-text-domain');
			} else {
				_pgssl_e("<b>Users avatars</b> is currently set to: <b>Display the default WordPress avatars.</b>", 'pgssl-text-domain');
			}
			?>
		</p>

		<p class="description">
			<?php _pgssl_e("To change this setting, go to <b>Widget</b> &gt; <b>Basic Settings</b> &gt <b>Users avatars</b>, then select the type of avatars that you want to display for your users.", 'pgssl-text-domain') ?>
		</p>
	</div>
</div>
<?php
}

function pgssl_component_buddypress_setup_profile_mapping() {
	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/';

	$pgssl_settings_buddypress_enable_mapping = get_option( 'pgssl_settings_buddypress_enable_mapping' );
	$pgssl_settings_buddypress_xprofile_map   = get_option( 'pgssl_settings_buddypress_xprofile_map' );

	# http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
	$ha_profile_fields = array(
		array( 'field' => 'provider'    , 'label' => _pgssl__( "Provider name"            , 'pgssl-text-domain'), 'description' => _pgssl__( "The the provider or social network name the user used to connected"                                                     , 'pgssl-text-domain') ),
		array( 'field' => 'identifier'  , 'label' => _pgssl__( "Provider user Identifier" , 'pgssl-text-domain'), 'description' => _pgssl__( "The Unique user's ID on the connected provider. Depending on the provider, this field can be an number, Email, URL, etc", 'pgssl-text-domain') ),
		array( 'field' => 'profileURL'  , 'label' => _pgssl__( "Profile URL"              , 'pgssl-text-domain'), 'description' => _pgssl__( "Link to the user profile on the provider web site"                                                                      , 'pgssl-text-domain') ),
		array( 'field' => 'webSiteURL'  , 'label' => _pgssl__( "Website URL"              , 'pgssl-text-domain'), 'description' => _pgssl__( "User website, blog or web page"                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'photoURL'    , 'label' => _pgssl__( "Photo URL"                , 'pgssl-text-domain'), 'description' => _pgssl__( "Link to user picture or avatar on the provider web site"                                                                , 'pgssl-text-domain') ),
		array( 'field' => 'displayName' , 'label' => _pgssl__( "Display name"             , 'pgssl-text-domain'), 'description' => _pgssl__( "User Display name. If not provided by social network, PGS Social Login will return a concatenation of the user first and last name"  , 'pgssl-text-domain') ),
		array( 'field' => 'description' , 'label' => _pgssl__( "Description"              , 'pgssl-text-domain'), 'description' => _pgssl__( "A short about me"                                                                                                       , 'pgssl-text-domain') ),
		array( 'field' => 'firstName'   , 'label' => _pgssl__( "First name"               , 'pgssl-text-domain'), 'description' => _pgssl__( "User's first name"                                                                                                      , 'pgssl-text-domain') ),
		array( 'field' => 'lastName'    , 'label' => _pgssl__( "Last name"                , 'pgssl-text-domain'), 'description' => _pgssl__( "User's last name"                                                                                                       , 'pgssl-text-domain') ),
		array( 'field' => 'gender'      , 'label' => _pgssl__( "Gender"                   , 'pgssl-text-domain'), 'description' => _pgssl__( "User's gender. Values are 'female', 'male' or blank"                                                                    , 'pgssl-text-domain') ),
		array( 'field' => 'language'    , 'label' => _pgssl__( "Language"                 , 'pgssl-text-domain'), 'description' => _pgssl__( "User's language"                                                                                                        , 'pgssl-text-domain') ),
		array( 'field' => 'age'         , 'label' => _pgssl__( "Age"                      , 'pgssl-text-domain'), 'description' => _pgssl__( "User' age. Note that PGS Social Login do not calculate this field. We return it as it was provided"                                  , 'pgssl-text-domain') ),
		array( 'field' => 'birthDay'    , 'label' => _pgssl__( "Birth day"                , 'pgssl-text-domain'), 'description' => _pgssl__( "The day in the month in which the person was born. Not to confuse it with 'Birth date'"                                 , 'pgssl-text-domain') ),
		array( 'field' => 'birthMonth'  , 'label' => _pgssl__( "Birth month"              , 'pgssl-text-domain'), 'description' => _pgssl__( "The month in which the person was born"                                                                                 , 'pgssl-text-domain') ),
		array( 'field' => 'birthYear'   , 'label' => _pgssl__( "Birth year"               , 'pgssl-text-domain'), 'description' => _pgssl__( "The year in which the person was born"                                                                                  , 'pgssl-text-domain') ),
		array( 'field' => 'birthDate'   , 'label' => _pgssl__( "Birth date"               , 'pgssl-text-domain'), 'description' => _pgssl__( "Complete birthday in which the person was born. Format: YYYY-MM-DD"                                                     , 'pgssl-text-domain') ),
		array( 'field' => 'email'       , 'label' => _pgssl__( "Email"                    , 'pgssl-text-domain'), 'description' => _pgssl__( "User's email address. Not all of provider grant access to the user email"                                               , 'pgssl-text-domain') ),
		array( 'field' => 'phone'       , 'label' => _pgssl__( "Phone"                    , 'pgssl-text-domain'), 'description' => _pgssl__( "User's phone number"                                                                                                    , 'pgssl-text-domain') ),
		array( 'field' => 'address'     , 'label' => _pgssl__( "Address"                  , 'pgssl-text-domain'), 'description' => _pgssl__( "User's address"                                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'country'     , 'label' => _pgssl__( "Country"                  , 'pgssl-text-domain'), 'description' => _pgssl__( "User's country"                                                                                                         , 'pgssl-text-domain') ),
		array( 'field' => 'region'      , 'label' => _pgssl__( "Region"                   , 'pgssl-text-domain'), 'description' => _pgssl__( "User's state or region"                                                                                                 , 'pgssl-text-domain') ),
		array( 'field' => 'city'        , 'label' => _pgssl__( "City"                     , 'pgssl-text-domain'), 'description' => _pgssl__( "User's city"                                                                                                            , 'pgssl-text-domain') ),
		array( 'field' => 'zip'         , 'label' => _pgssl__( "Zip"                      , 'pgssl-text-domain'), 'description' => _pgssl__( "User's zipcode"                                                                                                         , 'pgssl-text-domain') ),
	);
?>
<div class="stuffbox">
	<h3>
		<label><?php _pgssl_e("Profile mappings", 'pgssl-text-domain') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php _pgssl_e("When <b>Profile mapping</b> is enabled, PGS Social Login will try to automatically fill in Buddypress users profiles from their social networks profiles", 'pgssl-text-domain') ?>.
		</p>

		<p>
			<b><?php _pgssl_e('Notes', 'pgssl-text-domain') ?>:</b>
		</p>

		<p class="description">
			1. <?php _pgssl_e('<b>Profile mapping</b> will only work for new users. Profile mapping for returning users will implemented in future version.', 'pgssl-text-domain') ?>.
			<br />
			2. <?php _pgssl_e('Not all the mapped fields will be filled. Some providers and social networks do not give away many information about their users', 'pgssl-text-domain') ?>.
			<br />
			3. <?php _pgssl_e('PGS Social Login can only map <b>Single Fields</b>. Supported fields types are: Multi-line Text Areax, Text Box, URL, Date Selector and Number', 'pgssl-text-domain') ?>.
		</p>

		<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">
		  <tr>
			<td width="200" align="right"><strong><?php _pgssl_e("Enable profile mapping", 'pgssl-text-domain') ?> :</strong></td>
			<td>
				<select name="pgssl_settings_buddypress_enable_mapping" id="pgssl_settings_buddypress_enable_mapping" style="width:100px" onChange="toggleMapDiv();">
					<option <?php if( $pgssl_settings_buddypress_enable_mapping == 1 ) echo "selected"; ?> value="1"><?php _pgssl_e("Yes", 'pgssl-text-domain') ?></option>
					<option <?php if( $pgssl_settings_buddypress_enable_mapping == 2 ) echo "selected"; ?> value="2"><?php _pgssl_e("No", 'pgssl-text-domain') ?></option>
				</select>
			</td>
		  </tr>
		</table>
		<br>
	</div>
</div>

<div id="xprofilemapdiv" class="stuffbox" style="<?php if( $pgssl_settings_buddypress_enable_mapping == 2 ) echo "display:none;"; ?>">
	<h3>
		<label><?php _pgssl_e("Fields Map", 'pgssl-text-domain') ?></label>
	</h3>

	<div class="inside">
		<p>
			<?php _pgssl_e("Here you can create a new map by placing PGS Social Login users profiles fields to the appropriate destination fields", 'pgssl-text-domain') ?>.
			<?php _pgssl_e('The left column shows the available <b>PGS Social Login users profiles fields</b>: These select boxes are called <b>source</b> fields', 'pgssl-text-domain') ?>.
			<?php _pgssl_e('The right column shows the list of <b>Buddypress profiles fields</b>: Those are the <b>destination</b> fields', 'pgssl-text-domain') ?>.
			<?php _pgssl_e('If you don\'t want to map a particular Buddypress field, then leave the source for that field blank', 'pgssl-text-domain') ?>.
		</p>

		<hr />

		<?php
			if ( bp_has_profile() ) {
				while ( bp_profile_groups() ) {
					global $group;

					bp_the_profile_group();
					?>
						<h4><?php echo sprintf( _pgssl__("Fields Group '%s'", 'pgssl-text-domain'), $group->name ) ?> :</h4>

						<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">
							<?php
								while ( bp_profile_fields() ) {
									global $field;

									bp_the_profile_field();
									?>
										<tr>
											<td width="270" align="right" valign="top">
												<?php
													$map = isset( $pgssl_settings_buddypress_xprofile_map[$field->id] ) ? $pgssl_settings_buddypress_xprofile_map[$field->id] : 0;
													$can_map_it = true;

													if( ! in_array( $field->type, array( 'textarea', 'textbox', 'url', 'datebox', 'number' ) ) ){
														$can_map_it = false;
													}
												?>
												<select name="pgssl_settings_buddypress_xprofile_map[<?php echo $field->id; ?>]" style="width:255px" id="bb_profile_mapping_selector_<?php echo $field->id; ?>" onChange="showMappingConfirm( <?php echo $field->id; ?> );" <?php if( ! $can_map_it ) echo "disabled"; ?>>
													<option value=""></option>
													<?php
														if( $can_map_it ){
															foreach( $ha_profile_fields as $item ){
															?>
																<option value="<?php echo $item['field']; ?>" <?php if( $item['field'] == $map ) echo "selected"; ?> ><?php echo $item['label']; ?></option>
															<?php
															}
														}
													?>
												</select>
											</td>
											<td valign="top" align="center" width="50">
												<img src="<?php echo $assets_base_url; ?>arr_right.png" />
											</td>
											<td valign="top">
												<strong><?php echo $field->name; ?></strong>
												<?php
													if( ! $can_map_it ){
													?>
														<p class="description">
															<?php _pgssl_e("<b>PGS Social Login</b> can not map this field. Supported field types are: <em>Multi-line Text Areax, Text Box, URL, Date Selector and Number</em>", 'pgssl-text-domain'); ?>.
														</p>
													<?php
													} else {
													?>
														<?php
															foreach( $ha_profile_fields as $item ){
														?>
															<p class="description bb_profile_mapping_confirm_<?php echo $field->id; ?>" style="margin-left:0;<?php if( $item['field'] != $map ) echo "display:none;"; ?>" id="bb_profile_mapping_confirm_<?php echo $field->id; ?>_<?php echo $item['field']; ?>">
																<?php echo sprintf( _pgssl__( "PGS Social Login <b>%s</b> is mapped to Buddypress <b>%s</b> field", 'pgssl-text-domain' ), $item['label'], $field->name ); ?>.
																<br />
																<em><b><?php echo $item['label']; ?>:</b> <?php echo $item['description']; ?>.</em>
															</p>
														<?php
															}
														?>
													<?php
													}
												?>
											</td>
										</tr>
									<?php
								}
							?>
						</table>
					<?php
				}
			}
		?>
	</div>
</div>
<script>
	function toggleMapDiv(){
		if(typeof jQuery=="undefined"){
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return false;
		}

		var em = jQuery( "#pgssl_settings_buddypress_enable_mapping" ).val();

		if( em == 2 ) jQuery( "#xprofilemapdiv" ).hide();
		else jQuery( "#xprofilemapdiv" ).show();
	}

	function showMappingConfirm( field ){
		if(typeof jQuery=="undefined"){
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return false;
		}

		var el = jQuery( "#bb_profile_mapping_selector_" + field ).val();

		jQuery( ".bb_profile_mapping_confirm_" + field ).hide();

		jQuery( "#bb_profile_mapping_confirm_" + field + "_" + el ).show();
	}
</script>
<?php
}