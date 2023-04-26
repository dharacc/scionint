<?php
/**
* Wannabe Contact Manager module
*/

function pgssl_component_contacts() {
	// HOOKABLE: 
	do_action( 'pgssl_component_contacts_start' );

	include 'components.contacts.list.php';
	include 'components.contacts.settings.setup.php';
	include 'components.contacts.settings.sidebar.php';

	if( isset( $_REQUEST['uid'] ) && $_REQUEST['uid'] ) {
		$user_id = (int) $_REQUEST['uid'];

		pgssl_component_contacts_list( $user_id );
	} else {
?>
<form method="post" id="pgssl_setup_form" action="options.php"> 
	<?php settings_fields( 'pgssl_settings-group-contacts-import' ); ?> 

	<div class="metabox-holder columns-2" id="post-body">
		<table width="100%"> 
			<tr valign="top">
				<td>
					<?php
						pgssl_component_contacts_settings_setup();
					?> 
				</td>
				<td width="10"></td>
				<td width="400">
					<?php 
						pgssl_component_contacts_settings_sidebar();
					?>
				</td>
			</tr>
		</table>
	</div>
</form>
<?php 
	}

	// HOOKABLE: 
	do_action( 'pgssl_component_contacts_end' );
}

pgssl_component_contacts();