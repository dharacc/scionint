<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit; 

function pgssl_component_buddypress() {
	// HOOKABLE: 
	do_action( "pgssl_component_buddypress_start" ); 

	include "components.buddypress.setup.php";
	include "components.buddypress.sidebar.php";

	if( ! function_exists( 'bp_has_profile' ) ){
		include "components.buddypress.notfound.php";

		return pgssl_component_buddypress_notfound();
	}
?>
<form method="post" id="pgssl_setup_form" action="options.php"> 
	
	<?php settings_fields( 'pgssl_settings-group-buddypress' ); ?>

	<div class="metabox-holder columns-2" id="post-body">
		<table width="100%"> 
			<tr valign="top">
				<td>
					<?php
						pgssl_component_buddypress_setup();
					?> 
				</td>
				<td width="10"></td>
				<td width="400">
					<?php 
						pgssl_component_buddypress_sidebar();
					?>
				</td>
			</tr>
		</table>
	</div>
</form>
<?php
	// HOOKABLE: 
	do_action( "pgssl_component_buddypress_end" );
}

pgssl_component_buddypress();